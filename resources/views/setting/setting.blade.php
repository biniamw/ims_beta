@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Setting-Change')
        <div class="app-content content">
            <form id="SettingForm">
                {{ csrf_field() }}
                <section id="responsive-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h3 class="card-title">General</h3>
                                    
                                    @can('Setting-Change')
                                        <button type="submit" class="btn btn-gradient-info btn-sm" id="savechange">Save Changes</button>
                                    @endcan
                                </div>
                                <div class="card-datatable">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="nav-horizontal">
                                                        <ul class="nav nav-tabs justify-content-center" role="tablist">
                                                            <li class="nav-item">
                                                                <a class="nav-link active" id="tabregistry" data-toggle="tab"
                                                                    aria-controls="registrytab" href="#registrytab" role="tab"
                                                                    aria-selected="true"><i data-feather='align-justify'></i>
                                                                    Registry</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tabsales" data-toggle="tab"
                                                                    aria-controls="salestab" href="#salestab" role="tab"
                                                                    aria-selected="false"><i data-feather='shopping-bag'></i>
                                                                    Sales & Marketing</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tabinventory" data-toggle="tab"
                                                                    aria-controls="inventorytab" href="#inventorytab" role="tab"
                                                                    aria-selected="false"><i data-feather='home'></i>
                                                                    Inventory</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tabinventoryperiod" data-toggle="tab"
                                                                    aria-controls="inventorytab" href="#inventoryperiodtab" role="tab"
                                                                    aria-selected="false"><i data-feather='trending-up'></i>
                                                                    Inventory Period</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tabhr" data-toggle="tab"
                                                                    aria-controls="tabhr" href="#hrbody" role="tab"
                                                                    aria-selected="false"><i class="fa fa-user" aria-hidden="true"></i>
                                                                    HR</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tabpurchaser" data-toggle="tab"
                                                                    aria-controls="purchasertab" href="#purchasertab" role="tab"
                                                                    aria-selected="false"><i data-feather='user'></i>
                                                                    Purchasers</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" id="tabcompanyinfo" data-toggle="tab"
                                                                    aria-controls="companyinfotab" href="#companyinfotab"
                                                                    role="tab" aria-selected="false"><i
                                                                        class="fa fa-info"></i> Company Info</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="registrytab" role="tabpanel" aria-labelledby="tabregistry">
                                                                <p>
                                                                <div class="divider">
                                                                    <div class="divider-text">Items</div>
                                                                </div>
                                                                <div style="width:90%; margin-left:5%;">
                                                                    <div class="col-xl-12 col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label"
                                                                                for="itemcode">Generate Item Code</label>
                                                                            <div class="col-sm-9">
                                                                                <input
                                                                                    name="itemcode" type="checkbox"
                                                                                    id="itemcode" />
                                                                                <input type="hidden" placeholder=""
                                                                                    class="form-control"
                                                                                    name="itemcodeval"
                                                                                    id="itemcodeval" readonly="true"
                                                                                    value="{{ $setting->ItemCodeType }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="itemcode-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Item Code
                                                                                Prefix</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="ItemCodePrefix"
                                                                                    id='ItemCodePrefix'
                                                                                    onkeyup="itemcodePrefixVal()"
                                                                                    value="{{ $setting->ItemCodePrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="itemcodeprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Item Code
                                                                                Number</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="ItemCodeNumber"
                                                                                    id='ItemCodeNumber'
                                                                                    onkeyup="itemcodeNumberVal()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->ItemCodeNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="itemcodenumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Require SKU No.
                                                                                </label>
                                                                            <div class="col-sm-9">
                                                                                <select class="form-control" name="RequireSku" id="RequireSku"
                                                                                    onchange="removeSKUNum()">
                                                                                    <option value="Require">Require</option>
                                                                                    <option value="Not-Require">Not-Require</option>
                                                                                </select>
                                                                                <input type="hidden" placeholder="" class="form-control" name="skunumberreq" id="skunumberreq" value="{{ $setting->BarcodeRequire }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="reqsku-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">SKU
                                                                                Prefix</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control" name="SKUPrefix"
                                                                                    id='skuprefix' onkeyup="skuprefixval()"
                                                                                    value="{{ $setting->prefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="skuprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">SKU Number</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="SkuNumber" id='skunumber' onkeyup="skunumberval()" onkeypress="return ValidateOnlyNum(event);"  value="{{ $setting->skunumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="skunumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label" for="wholesalefeaturecheck">Wholesale Feature</label>
                                                                            <div class="col-sm-9">
                                                                                <input name="wholesalefeaturecheck" type="checkbox" id="wholesalefeaturecheck" />
                                                                                <input type="hidden" placeholder="" class="form-control" name="wholesalefeature" id="wholesalefeature" readonly="true" value="{{ $setting->wholesalefeature }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="wholesalefeature-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label" for="itemcode">Selling Price</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="demo-inline-spacing">
                                                                                    <div class="custom-control custom-radio">
                                                                                        <input type="radio" id="maxcostcheck" name="cost" class="custom-control-input " value="0"  />
                                                                                        <label style="font-size: 14px;" class="custom-control-label" for="maxcostcheck">Max cost</label>
                                                                                    </div>
                                                                                    <div class="custom-control custom-radio">
                                                                                        <input type="radio" id="averagecostcheck" name="cost" class="custom-control-input" value="1"  />
                                                                                        <label style="font-size: 14px;" class="custom-control-label" for="averagecostcheck" >Average Cost</label>
                                                                                    </div>
                                                                                    <input type="hidden" placeholder="" class="form-control" name="costType" id="costType" readonly="true" value="{{ $setting->costType }}" />
                                                                                </div>
                                                                                <span class="text-danger">
                                                                                    <strong id="wholesalefeature-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="divider">
                                                                        <div class="divider-text">Customers</div>
                                                                    </div>
                                                                    <div class="col-xl-12 col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label" for="customercode">Generate Customer ID</label>
                                                                            <div class="col-sm-9">
                                                                                <input name="customercode" type="checkbox" id="customercode" />
                                                                                <input type="hidden" placeholder="" class="form-control" name="cuscodecheckboxVali" id="cuscodecheckboxVali" readonly="true" value="{{ $setting->CustomerCodeType }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="cuscode-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Customer ID Prefix</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" placeholder="" class="form-control" name="CustomerCodePrefix" id='CustomerCodePrefix' onkeyup="customerCodePrefixVal()" value="{{ $setting->CustomerCodePrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="customercodepr-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Customer ID Number</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="CustomerCodeNumber" id="CustomerCodeNumber" onkeyup="customerCodeNumVal()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->CustomerCodeNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="customercodenum-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Credit Sales Min Amount</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="CreditSalesLimitStart" id="CreditSalesLimitStart" onkeyup="creditlimitstart()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->CreditSalesLimitStart }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="creditlimitstart-error"></strong>
                                                                                </span>
                                                                            </div>                                                                        
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Credit Sales Max Amount</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="CreditSalesLimitEnd" id="CreditSalesLimitEnd" onkeyup="creditlimitend()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->CreditSalesLimitEnd }}" />
                                                                                <span>
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <input name="unlimitcreditslcbx" type="checkbox" id="unlimitcreditslcbx"/>
                                                                                            <label class="col-form-label" for="unlimitcreditslcbx">Unlimit credit sales</label>
                                                                                            <input type="hidden" placeholder="" class="form-control" name="unlimitflag" id="unlimitflag" readonly="true" value="{{ $setting->CreditSalesLimitFlag }}" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <strong class="text-danger" id="creditlimitend-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Credit Sales Payment Term</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="CreditSalesLimitDay" id="CreditSalesLimitDay" onkeyup="creditslimitval()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->CreditSalesLimitDay }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="creditslimit-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Credit Sales Additional %</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="CreditSalesAdditionPercentage" id="CreditSalesAdditionPercentage" onkeyup="creditsalesaddval()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->CreditSalesAdditionPercentage }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="creditsalesadd-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label" for="settleoutcbx">Settle All Outstanding for Credit Sales</label>
                                                                            <div class="col-sm-9">
                                                                                <input name="settleoutcbx" type="checkbox" id="settleoutcbx" />
                                                                                <input type="hidden" placeholder="" class="form-control" name="settleoutstanding" id="settleoutstanding" readonly="true" value="{{ $setting->SettleAllOutstanding }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="settleout-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">First Purchase Amount<label class="col-sm-1 col-form-label" strong style="font-size: 14px;" title="When a customer makes their first purchase, set a minimum purchase amount that must be meet in order to unlock a wholesale price."><i class="fa fa-info" aria-hidden="true"></i></label></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="MinimumPurchaseAmount" id="MinimumPurchaseAmount" onkeyup="minpurchasefn()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->MinimumPurchaseAmount }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="minpurchase-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label">Days/ Period<label class="col-sm-1 col-form-label" strong style="font-size: 14px;" title="Set a day for the customer's purchases of the specified amount over the specified number of days."><i class="fa fa-info" aria-hidden="true"></i></label></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="MinimumPeriod" id="MinimumPeriod" onkeyup="minimumperfn()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->MinimumPeriod }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="minimumper-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-3 col-form-label" strong style="font-size: 14px;">Days/ Period Amount<label strong style="font-size: 14px;" title="The customer must purchase provided amount within a given day/period in order to continue being a wholesale customer."><i class="fa fa-info" aria-hidden="true"></i></label></label>
                                                                            <div class="col-sm-9">
                                                                                <input type="number" placeholder="" class="form-control" name="PurchaseLimit" id="PurchaseLimit" onkeyup="purchaselimfn()" onkeypress="return ValidateOnlyNum(event);" value="{{ $setting->PurchaseLimit }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="purlimit-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        

                                                                    </div>
                                                                </div>
                                                                </p>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="salestab" role="tabpanel" aria-labelledby="tabsales">
                                                                <div class="divider divider-info">
                                                                    <div class="divider-text">Sales & Marketing</div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="row">
                                                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                                            <label>Witholding Min Amount</label>
                                                                            <input type="text" placeholder="" class="form-control" name="SalesWitholdMinAmount" id='SalesWitholdMinAmount'onkeyup="salesWitholdVal()" value="{{ $setting->SalesWithHold }}" />
                                                                                    <span class="text-danger">
                                                                                        <strong id="saleswithold-error"></strong>
                                                                                    </span>
                                                                        </div>
                                                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                                            <label>VAT Deduct Min Amount</label>
                                                                            <input type="text" placeholder="" class="form-control" name="SalesVatDeductMinAmount" id='SalesVatDeductMinAmount' onkeyup="salesVatVal()" value="{{ $setting->vatDeduct }}" />
                                                                                    <span class="text-danger">
                                                                                        <strong id="salesvat-error"></strong>
                                                                                    </span>
                                                                        </div>
                                                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                                            <label>Hold Prefix</label>
                                                                            <input type="text" placeholder="Sales Hold Prefix" class="form-control" name="salesHoldPrefix" id='salesHoldPrefix' value="{{ $setting->SalesHoldPrefix }}" />
                                                                                    <span class="text-danger">
                                                                                        <strong id="salesvat-error"></strong>
                                                                                    </span>
                                                                        </div>
                                                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                                                            <label>Hold #</label>
                                                                            <input type="number" placeholder="Sales hold number" class="form-control" name="salesHoldNumber" id='salesHoldNumber' value="{{ $setting->SalesHoldNumber }}" />
                                                                                    <span class="text-danger">
                                                                                        <strong id="salesvat-error"></strong>
                                                                                    </span>
                                                                        </div>

                                                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                                            <label>Block Sales</label>
                                                                            <input type="hidden" placeholder="" class="form-control" name="isaleblockhidden" id="isaleblockhidden" value="{{ $setting->isaleblock }}"/>
                                                                            <select class="select2 form-control" name="isaleblock" id="isaleblock" data-placeholder="Select your action" >
                                                                                    <option value="" selected disabled></option>
                                                                                    <option value="1">Allow</option>
                                                                                    <option value="0">Not-Allow</option>
                                                                            </select>
                                                                                    <span class="text-danger">
                                                                                        <strong id="isaleblock-error"></strong>
                                                                                    </span>
                                                                        </div>
                                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="pendingwaitdiv">

                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Maximum no. of waiting days on pending</label></td>
                                                                                    <td style="width: 50%;"><label strong style="font-size: 14px;">Maximum no. of sales on pending</label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <div class="input-group">
                                                                                        
                                                                                          <input type="number" placeholder="" class="touchspin" name="pendingwait" id='pendingwait' value="{{ $setting->pendingdays }}" />
                                                                                         
                                                                                        </div>
                                                                                        </td><td>

                                                                                        <div class="input-group">
                                                                                         
                                                                                          <input type="number" placeholder="" class="touchspin" name="nofsalesonpending" id='nofsalesonpending' value="{{ $setting->nofsalesonpending }}" />
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                                <span class="text-danger">
                                                                                    <strong id="pendingwait-error"></strong>
                                                                                </span>
                                                                                <span class="text-danger">
                                                                                    <strong id="nofsalesonpending-error"></strong>
                                                                                </span>
                                                                                    
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                                    <!-- Accordion with margin start -->
                                                                    <section id="accordion-with-margin">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="card collapse-icon">
                                                                                 <div class="divider divider-info">
                                                                                    <div class="divider-text">Sales invoice number configuration</div>
                                                                                </div>
                                                                                    
                                                                                    <div class="card-body">
                                                                                        <p class="card-text">
                                                                                           
                                                                                        </p>
                                                                                        <div class="collapse-margin" id="accordionExample">
                                                                                            <div class="card">
                                                                                                <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" onclick="clearpos()">
                                                                                                    <span class="lead collapse-title">Add auto increment sales invoice number</span>
                                                                                                </div>
                                                                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                                                    <div class="card-body">
                                                                                                        <div class="col-xl-12">
                                                                                                            <div class="row">
                                                                                                                
                                                                                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                                                                                    <label>Type<b style="color:red;">*</b></label>
                                                                                                                    <input type="hidden" name="storemrcid" id="storemrcid" readonly/>
                                                                                                                    <select class="select2 form-control" name="machinetype" id="machinetype" data-placeholder="Select type" >
                                                                                                                            <option value="" selected disabled></option>
                                                                                                                            <option value="fiscal">Fiscal-Reciept</option>
                                                                                                                            <option value="manual">Manual-Reciept</option>
                                                                                                                    </select>
                                                                                                                            <span class="text-danger">
                                                                                                                                <strong id="machinetype-error"></strong>
                                                                                                                            </span>
                                                                                                                </div>
                                                                                                                
                                                                                                                
                                                                                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="divfiscalstore" style="display: none;">
                                                                                                                        <label>Point of sales <b style="color:red;">*</b></label>
                                                                                                                        <select class="select2 form-control" name="pos" id="pos" data-placeholder="Select point of sales">
                                                                                                                            <option selected></option>
                                                                                                                            @foreach ($store as $str)
                                                                                                                                <option value="{{ $str->id }}">{{ $str->Name }}</option>
                                                                                                                            @endforeach
                                                                                                                        </select>
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="pos-error"></strong>
                                                                                                                                </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="divfiscalmrc" style="display: none;">
                                                                                                                        <label>MRC <b style="color:red;">*</b></label>
                                                                                                                        <select class="select2 form-control" name="mrc" id="mrc" data-placeholder="select mrc">
                                                                                                                            
                                                                                                                        </select>
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="mrc-error"></strong>
                                                                                                                                </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divfiscalnumber" style="display: none;">
                                                                                                                        <label>FS Number <b style="color:red;">*</b></label>
                                                                                                                        <input type="number" class="form-control" name="fsNumber" id="fsNumber" onclick="cf()"  onkeypress="return ValidateOnlyNum(event);"/>
                                                                                                                        
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="fsNumber-error"></strong>
                                                                                                                                </span>
                                                                                                                    </div>
                                                                                                                    
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divfiscalcash" style="display: none;">
                                                                                                                        <label>CASI No <b style="color:red;">*</b></label>
                                                                                                                        <input type="number" class="form-control" name="fiscalCashInvoiceNumber" id="fiscalCashInvoiceNumber" onclick="cf2()" onkeypress="return ValidateOnlyNum(event);" />
                                                                                                                        
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="fiscalCashInvoiceNumber-error"></strong>
                                                                                                                                </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divfiscalcredit" style="display: none;">
                                                                                                                        <label>CRSI No <b style="color:red;">*</b></label>
                                                                                                                        <input type="number" class="form-control" name="fiscalCreditInvoiceNumber" id="fiscalCreditInvoiceNumber" onclick="cf3()" onkeypress="return ValidateOnlyNum(event);" />
                                                                                                                        
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="fiscalCreditInvoiceNumber-error"></strong>
                                                                                                                                </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="diveditType" style="display: none;">
                                                                                                                        <label>Edit Type # <b style="color:red;">*</b></label>
                                                                                                                        <select class="select2 form-control" name="editType" id="editType" data-placeholder="Select edit type">
                                                                                                                            <option selected></option>
                                                            
                                                                                                                                <option value="1">Not Editable</option>
                                                                                                                                <option value="0"> Editable</option>
                                                                                                                            
                                                                                                                        </select>
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="editType-error"></strong>
                                                                                                                                </span>
                                                                                                                    </div>
                                                                                                                    
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divfiscalsave" style="display: none;">
                                                                                                                        <label>&nbsp;</label>
                                                                                                                        <div>
                                                                                                                            <button type="button" id="savepos" class="btn btn-info waves-effect waves-float waves-light">
                                                                                                                            
                                                                                                                                <span id="loadid"></span>
                                                                                                                                <span id="saveid">Save</span>
                                                                                                                            
                                                                                                                            </button>
                                                                                                                        </div>
                                                                                                                                
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="divmanualpos" style="display: none;">
                                                                                                                        <label>Point of sales <b style="color:red;">*</b></label>
                                                                                                                        
                                                                                                                            <select class="select2 form-control" name="pointOfSale" id="pointOfSale" data-placeholder="select point of sales">
                                                                                                                                <option selected></option>
                                                                                                                                @foreach ($stores as $str )
                                                                                                                                <option value="{{ $str->id }}">{{ $str->Name }}</option> 
                                                                                                                                @endforeach
                                                                                                                            </select>
                                                                                                                        
                                                                                                                                <span class="text-danger">
                                                                                                                                    <strong id="pointOfSale-error"></strong>
                                                                                                                                </span>
                                                                                                                    
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divmanualcash" style="display: none;">
                                                                                                                        <label>CASI No <b style="color:red;">*</b></label>
                                                                                                                        <input type="number" class="form-control" name="manulCashInvoiceNumber" id="manulCashInvoiceNumber" onclick="cf4()" onkeypress="return ValidateOnlyNum(event);" />
                                                                                                                        <span class="text-danger">
                                                                                                                            <strong id="manulCashInvoiceNumber-error"></strong>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divmanulcredit" style="display: none;">
                                                                                                                        <label>CRSI No <b style="color:red;">*</b></label>
                                                                                                                        <input type="number" class="form-control" name="manulCreditInvoiceNumber" id="manulCreditInvoiceNumber" onclick="cf5()" onkeypress="return ValidateOnlyNum(event);" />
                                                                                                                        <span class="text-danger">
                                                                                                                            <strong id="manulCreditInvoiceNumber-error"></strong>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divmanuleditType" style="display: none;">
                                                                                                                        <label>Edit Type # <b style="color:red;">*</b></label>
                                                                                                                        <select class="select2 form-control" name="manuleditType" id="manuleditType" data-placeholder="Select edit type">
                                                                                                                            <option selected></option>
                                                                                                                            <option value="1">Not Editable</option>
                                                                                                                            <option value="0"> Editable</option>
                                                                                                                        </select>
                                                                                                                        <span class="text-danger">
                                                                                                                            <strong id="manuleditType-error"></strong>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="divmanualsave" style="display: none;">
                                                                                                                        <label>&nbsp;</label>
                                                                                                                        <div>
                                                                                                                            <button type="button" id="savemanualpos" class="btn btn-info waves-effect waves-float waves-light">
                                                                                                                            
                                                                                                                                <span id="manualoadid"></span>
                                                                                                                                <span id="manualsaveid">Save</span>
                                                                                                                            
                                                                                                                            </button>
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
                                                                    </section>
                                                                    <div class="row">
                                                                        <div class="col-xl-6" id="card-block">
                                                                            <p class="card-text">
                                                                                Machine invoice setup
                                                                            </p>
                                                                            <div class="table-responsive">   
                                                                                <table id="storemrctables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>POS</th>
                                                                                            <th>Mrc #</th>
                                                                                            <th>Fs #</th>
                                                                                            <th>CASI #</th>
                                                                                            <th>CRSI #</th>
                                                                                            <th>Cancel Type</th>
                                                                                            <th>Is Editable</th>
                                                                                            <th>Action</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6" id="card-block-manual">
                                                                            <p class="card-text">
                                                                                Manual invoice setup
                                                                            </p>
                                                                            <div class="table-responsive">
                                                                                <table id="manualstoremrctables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>#</th>
                                                                                            <th>POS</th>
                                                                                            <th>CASI #</th>
                                                                                            <th>CRSI #</th>
                                                                                            <th>Edit Type</th>
                                                                                            <th>Action</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="inventorytab" role="tabpanel"
                                                                aria-labelledby="tabinventory">
                                                                <p>
                                                                <div class="divider">
                                                                    <div class="divider-text">Inventory</div>
                                                                </div>
                                                                <div style="width:90%; margin-left:5%;">
                                                                    <div class="col-xl-12 col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Receiving
                                                                                Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="ReceivingPrefix" id='recprefix'
                                                                                    onkeyup="recprefixval()"
                                                                                    value="{{ $setting->GRVPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="recprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Receiving
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="ReceivingNumber" id='recnumber'
                                                                                    onkeyup="recnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->GRVNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="recnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Hold
                                                                                Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control" name="HoldPrefix"
                                                                                    id='holdprefix' onkeyup="holdprefixval()"
                                                                                    value="{{ $setting->HoldPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="holdprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Hold
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control" name="HoldNumber"
                                                                                    id='holdnumber' onkeyup="holdnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->HoldNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="holdnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Requisition
                                                                                Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="RequisitionPrefix" id='reqprefix'
                                                                                    onkeyup="reqprefixval()"
                                                                                    value="{{ $setting->RequisitionPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="reqprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Requisition
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="RequisitionNumber" id='reqnumber'
                                                                                    onkeyup="reqnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->RequisitionNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="reqnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Transfer
                                                                                Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="TransferPrefix" id='trprefix'
                                                                                    onkeyup="trprefixval()"
                                                                                    value="{{ $setting->TransferPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="trprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Transfer
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="TransferNumber" id='trnumber'
                                                                                    onkeyup="trnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->TransferNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="trnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Issue  Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control" name="IssuePrefix"
                                                                                    id='issprefix' onkeyup="issprefixval()"
                                                                                    value="{{ $setting->IssuePrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="issprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Issue
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control" name="IssueNumber"
                                                                                    id='issnumber' onkeyup="issnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->IssueNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="issnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Transfer
                                                                                Issue Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="TansferIssuePrefix" id='trissprefix'
                                                                                    onkeyup="trissprefixval()"
                                                                                    value="{{ $setting->TransferIssuePrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="trissprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Transfer Issue Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="TransferIssueNumber" id='trissnumber'
                                                                                    onkeyup="trissnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->TransferIssueNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="trissnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Adjustment Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""  class="form-control"  name="AdjustmentPrefix" id='adjprefix' onkeyup="adjprefixval()"                                                        value="{{ $setting->AdjustmentPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="adjprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Adjustment
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="AdjustmentNumber" id='adjnumber'
                                                                                    onkeyup="adjnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->AdjustmentNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="adjnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Begining
                                                                                Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="BeginingPrefix" id='bgprefix'
                                                                                    onkeyup="bgprefixval()"
                                                                                    value="{{ $setting->BeginingPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="bgprefix-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Begining
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="BeginingNumber" id='bgnumber'
                                                                                    onkeyup="bgnumberval()"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    value="{{ $setting->BeginingNumber }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="bgnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Dead Stock
                                                                                HandIn Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="DeadStockAvoidancePrefix"
                                                                                    id='deadstockprefix'
                                                                                    onkeyup="deadstockprefix()"
                                                                                    value="{{ $setting->DeadStockPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="deadstockavd-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Dead Stock
                                                                                HandIn Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="DeadStockAvoidanceNumber"
                                                                                    id='deadstocknumber'
                                                                                    onkeyup="deadstocknumber()"
                                                                                    onkeypress="return ValidateNum(event);"
                                                                                    value="{{ $setting->DeadStockCount }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="deadstocknumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Dead Stock
                                                                                PullOut Prefix</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder=""
                                                                                    class="form-control"
                                                                                    name="DeadStockRemovalPrefix"
                                                                                    id='deadstockremprefix'
                                                                                    onkeyup="deadstockremprefix()"
                                                                                    value="{{ $setting->DeadStockSalesPrefix }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="deadstockrem-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Dead Stock
                                                                                PullOut Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="DeadStockRemNumber"
                                                                                    id='deadstockremnumber'
                                                                                    onkeyup="deadstockremnumber()"
                                                                                    onkeypress="return ValidateNum(event);"
                                                                                    value="{{ $setting->DeadStockSalesCount }}" />
                                                                                <span class="text-danger">
                                                                                    <strong
                                                                                        id="deadstockremnumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Witholding
                                                                                Deduct Amount</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="number" placeholder=""
                                                                                    class="form-control"
                                                                                    name="WitholdingMinimumAmount"
                                                                                    id='WitholdingMinimumAmount'
                                                                                    onkeyup="withAmnt()"
                                                                                    onkeypress="return ValidateNum(event);"
                                                                                    value="{{ $setting->WitholdMinimumAmount }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="witholdamount-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row" style="display:none;">
                                                                            <label class="col-sm-4 col-form-label">Fiscal
                                                                                Year</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="selectpicker form-control"
                                                                                    data-style="btn btn-outline-secondary waves-effect"
                                                                                    name="FiscalYear" id="fiscalyr"
                                                                                    onchange="fiscalyearval()">
                                                                                    <option value="{{ $setting->FiscalYear }}"
                                                                                        selected>{{ $setting->FiscalYear }}
                                                                                    </option>
                                                                                    @foreach ($fiscalyear as $fiscalyear)
                                                                                        <option value="{{ $fiscalyear->id }}">
                                                                                            {{ $fiscalyear->FiscalYear }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger">
                                                                                    <strong id="fiscalyear-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                            <input type="hidden" class="form-control"
                                                                                name="fiscalyeari" id="fiscalyeari"
                                                                                readonly="true"
                                                                                value="{{ $setting->FiscalYear }}" />
                                                                               <input typ e="text" class="form-control" name="fiscalyeariflag" id="fiscalyeariflag" readonly="true" value="{{ $setting->IsFiscalYearChanged }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </p>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="purchasertab" role="tabpanel"
                                                                aria-labelledby="tabpurchaser">
                                                                <p>
                                                                <div class="divider">
                                                                    <div class="divider-text">Purchaser</div>
                                                                </div>
                                                                <div style="width:90%; margin-left:5%;">
                                                                    <div class="col-xl-12 col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Purchaser
                                                                                Name</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="select2 form-control"
                                                                                    name="PurchaserName[]" id="purchasernm"
                                                                                    onchange="purchasernameval()"
                                                                                    multiple="multiple">
                                                                                    @foreach ($purchaser as $purchaser)
                                                                                        <option selected
                                                                                            value="{{ $purchaser->id }}">
                                                                                            {{ $purchaser->username }}</option>
                                                                                    @endforeach
                                                                                    @foreach ($users as $users)
                                                                                        <option value="{{ $users->id }}">
                                                                                            {{ $users->username }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger">
                                                                                    <strong id="purchasername-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <div class="col-sm-12"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                </p>
                                                            </div>
                                                            
                                                            <div class="tab-pane" id="companyinfotab" role="tabpanel"
                                                                aria-labelledby="companyinfotab">
                                                                <p>
                                                                <div class="divider">
                                                                    <div class="divider-text">Company Information</div>
                                                                </div>
                                                                <div style="width:90%; margin-left:5%;">
                                                                    <div class="col-xl-12 col-lg-12">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Name</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder="Company Name"
                                                                                    class="form-control" name="name"
                                                                                    id="name" onkeyup="cusNameCV();"
                                                                                    value="{{ $companyinfo->Name }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="name-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">TIN Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder="TIN Number" class="form-control" name="TinNumber"  id="TinNumber" onkeypress="return ValidateOnlyNum(event);" onkeyup="countTinChar(this)"  value="{{ $companyinfo->TIN }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="tin-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">VAT Reg
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"
                                                                                    placeholder="VAT Registration Number"
                                                                                    class="form-control" name="VatNumber"
                                                                                    id="VatNumber"
                                                                                    onkeypress="return ValidateOnlyNum(event);"
                                                                                    onkeyup="cusVATCV();"
                                                                                    value="{{ $companyinfo->VATReg }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="VatNumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">VAT
                                                                                Deduct</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control"
                                                                                    name="VatDeduct" id="VatType"
                                                                                    onchange="cusVATDedCV()"
                                                                                    value="{{ $companyinfo->VATDeduct }}">
                                                                                    <option selected
                                                                                        value="{{ $companyinfo->VATDeduct }}">
                                                                                        {{ $companyinfo->VATDeduct }}%</option>
                                                                                    @foreach ($vats as $vt)
                                                                                        <option value="{{ $vt->Value }}">
                                                                                            {{ $vt->Name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger">
                                                                                    <strong id="VatDeduct-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Withold
                                                                                Deduct</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="form-control"
                                                                                    name="WitholdDeduct" id="Witholding"
                                                                                    onchange="cusWithDedCV()">
                                                                                    <option selected
                                                                                        value="{{ $companyinfo->WitholdDeduct }}">
                                                                                        {{ $companyinfo->WitholdDeduct }}%
                                                                                    </option>
                                                                                    @foreach ($witholds as $wh)
                                                                                        <option value="{{ $wh->Value }}">
                                                                                            {{ $wh->Name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger">
                                                                                    <strong id="WitholdDeduct-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Phone
                                                                                Number</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"
                                                                                    placeholder="Phone or Mobile Number"
                                                                                    class="form-control" name="PhoneNumber"
                                                                                    id="PhoneNumber"
                                                                                    onkeypress="return ValidatePhone(event);"
                                                                                    onkeyup="cusPhoneCV()"
                                                                                    value="{{ $companyinfo->Phone }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="PhoneNumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Office Phone
                                                                                No.</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text"
                                                                                    placeholder="Office Phone Number"
                                                                                    class="form-control"
                                                                                    name="OfficePhoneNumber" id="OfficePhone"
                                                                                    onkeypress="return ValidatePhone(event);"
                                                                                    onkeyup="cusOffPhoneCV()"
                                                                                    value="{{ $companyinfo->OfficePhone }}" />
                                                                                <span class="text-danger">
                                                                                    <strong
                                                                                        id="OfficePhoneNumber-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-4 col-form-label">Email</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder="Email Address"
                                                                                    class="form-control" name="EmailAddress"
                                                                                    id="EmailAddress"
                                                                                    onkeyup="ValidateEmail(this);"
                                                                                    value="{{ $companyinfo->Email }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="email-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-4 col-form-label">Website</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder="Website"
                                                                                    class="form-control" name="Website"
                                                                                    id="Website"
                                                                                    onkeyup="ValidateWebsite(this);"
                                                                                    value="{{ $companyinfo->Website }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="Website-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-4 col-form-label">Address</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" placeholder="Address"
                                                                                    class="form-control" name="Address"
                                                                                    id="Address" onkeyup="cusAddressv()"
                                                                                    value="{{ $companyinfo->Address }}" />
                                                                                <span class="text-danger">
                                                                                    <strong id="Address-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-sm-4 col-form-label">Country</label>
                                                                            <div class="col-sm-8">
                                                                                <select class="selectpicker form-control"
                                                                                    data-live-search="true"
                                                                                    data-style="btn btn-outline-secondary waves-effect"
                                                                                    name="Country" id="Country"
                                                                                    onchange="cusCountryVC()">
                                                                                    <option selected
                                                                                        value="{{ $companyinfo->Country }}">
                                                                                        {{ $companyinfo->Country }}</option>
                                                                                    @foreach ($counrtys as $cn)
                                                                                        <option value="{{ $cn->Name }}">
                                                                                            {{ $cn->Name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <span class="text-danger">
                                                                                    <strong id="Country-error"></strong>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Logo</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="file" id="item_image"
                                                                                    name="item_image" class="form-control"
                                                                                    style="width:100%;"
                                                                                    onchange="previewFile(this);" />
                                                                                <div class="card">
                                                                                    <div class="card-img-top"
                                                                                        id="imagepreviews">
                                                                                        <div class="row">
                                                                                            <div class="avatar avatar-xl"
                                                                                                id="uplcomplogo">
                                                                                                <img id="previewImg" src=""
                                                                                                    alt="">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="avatar avatar-xl"
                                                                                            id="compLogo">
                                                                                        </div>
                                                                                        <div class="row"
                                                                                            id="clearbtndiv">
                                                                                            <button type="button"
                                                                                                class="btn btn-icon btn-icon rounded-circle btn-flat-danger waves-effect btn-sm"
                                                                                                onclick=""><i
                                                                                                    data-feather='x'></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <section id="accordion-with-margin">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12 col-lg-12">
                                                                                        <div class="card collapse-icon">
                                                                                            <div class="card-body">
                                                                                                <div class="collapse-margin"
                                                                                                    id="accordionExample">
                                                                                                    <div class="card-header"
                                                                                                        id="headingOne"
                                                                                                        data-toggle="collapse"
                                                                                                        role="button"
                                                                                                        onclick="addMRC()"
                                                                                                        data-target="#collapseOne"
                                                                                                        aria-expanded="false"
                                                                                                        aria-controls="collapseOne">
                                                                                                        <span
                                                                                                            class="lead collapse-title"
                                                                                                            onclick="addMRC()">
                                                                                                            Add MRC </span>
                                                                                                    </div>
                                                                                                    <div id="collapseOne"
                                                                                                        class="collapse"
                                                                                                        aria-labelledby="headingOne"
                                                                                                        data-parent="#accordionExample">
                                                                                                        <div
                                                                                                            class="card-body">
                                                                                                            <div
                                                                                                                class="row">
                                                                                                                <div
                                                                                                                    class="col-xl-5 col-md-6 col-sm-12 mb-2">
                                                                                                                    <label
                                                                                                                        strong
                                                                                                                        style="font-size: 16px;">MRC
                                                                                                                        No.</label>
                                                                                                                    <input
                                                                                                                        type="hidden"
                                                                                                                        id="customerid"
                                                                                                                        class="form-control"
                                                                                                                        name="customerid" />
                                                                                                                    <input
                                                                                                                        type="text"
                                                                                                                        id="MrcNumber"
                                                                                                                        placeholder="MRC Number"
                                                                                                                        class="form-control compmrc"
                                                                                                                        name="MrcNumber"
                                                                                                                        onkeypress="cusNameCV()"
                                                                                                                        onkeyup="countAddMrcChar(this)"
                                                                                                                        ondrop="return false;"
                                                                                                                        onpaste="return false;"
                                                                                                                        autofocus />
                                                                                                                    <span
                                                                                                                        class="text-danger"
                                                                                                                        style="height:10px;">
                                                                                                                        <strong
                                                                                                                            id="mname-error"></strong>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                                                                                    <label
                                                                                                                        strong
                                                                                                                        style="font-size: 16px;">Status</label>
                                                                                                                    <div
                                                                                                                        class="invoice-customer">
                                                                                                                        <select
                                                                                                                            class="form-control"
                                                                                                                            name="status"
                                                                                                                            id="lstatus">
                                                                                                                            <option
                                                                                                                                value="Active">
                                                                                                                                Active
                                                                                                                            </option>
                                                                                                                            <option
                                                                                                                                value="Inactive">
                                                                                                                                Inactive
                                                                                                                            </option>
                                                                                                                        </select>
                                                                                                                        <span
                                                                                                                            class="text-danger">
                                                                                                                            <strong
                                                                                                                                id="mstatus-error"></strong>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                                                                    <label
                                                                                                                        strong
                                                                                                                        style="font-size: 16px;"></label>
                                                                                                                    <div>
                                                                                                                        <button
                                                                                                                            id="savemrcbtn"
                                                                                                                            type="button"
                                                                                                                            class="btn btn-info">Add
                                                                                                                            MRC</button>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div
                                                                                                                class="row">
                                                                                                                <div
                                                                                                                    class="table-responsive">
                                                                                                                    <table
                                                                                                                        id="laravel-datatable-crud-mrc"
                                                                                                                        class="table table-bordered table-striped table-hover dt-responsive table mb-0"
                                                                                                                        style="width: 100%">
                                                                                                                        <thead>
                                                                                                                            <tr>
                                                                                                                                <th
                                                                                                                                    style="width: 0%;">
                                                                                                                                    Id
                                                                                                                                </th>
                                                                                                                                <th
                                                                                                                                    style="width: 35%;">
                                                                                                                                    MRC
                                                                                                                                    Number
                                                                                                                                </th>
                                                                                                                                <th
                                                                                                                                    style="width: 35%;">
                                                                                                                                    Status
                                                                                                                                </th>
                                                                                                                                <th
                                                                                                                                    style="width: 30%;">
                                                                                                                                    Action
                                                                                                                                </th>
                                                                                                                            </tr>
                                                                                                                        </thead>
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
                                                                </div>
                                                                </p>
                                                            </div>
                                                        
                                                            <div class="tab-pane" id="inventoryperiodtab" role="tabpanel" aria-labelledby="inventoryperiodtab">
                                                                <p>
                                                                    <div class="divider">
                                                                        <div class="divider-text">Inventory Period</div>
                                                                    </div>
                                                                    <div style="width:90%; margin-left:10%;" id="fiscalyeardiv">
                                                                        <div class="col-xl-3 col-lg-12"></div>
                                                                        <div class="col-xl-12 col-lg-12">
                                                                            <table style="width:100%">
                                                                                <tr id="newfytr">
                                                                                    <td colspan="7">
                                                                                        <button type="button" id="openfy" onclick="openFiscalYearModal()" class="btn btn-info btn-sm">Add Fiscal Year</button>
                                                                                        <label strong style="font-size: 14px;"></label>
                                                                                    </td>
                                                                                </tr>
                                                                                
                                                                                <tr><td colspan="7" style="height:15px;"></td></tr>
                                                                                <tr>
                                                                                    <td colspan="2"><button type="button" style="display:none;" id="showperiodsbtn" class="btn btn-info btn-sm"></button></td>
                                                                                    <td colspan="3"></td>
                                                                                    <td colspan="2" style="text-align: right;"><button type="button" style="display:none;" id="openfiscalyear" onclick="openfyear()" class="btn btn-info btn-sm">Open Fiscal Year</button></td>
                                                                                </tr>
                                                                                <tr><td colspan="7" style="height:10px;"></td></tr>
                                                                                <tr id="periodtable">
                                                                                    <td colspan="7">
                                                                                        <table id="fiscalyrperiod" class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                                                                            <thead>
                                                                                                <th></th>
                                                                                                <th style="width: 7%;">Period Name</th>
                                                                                                <th style="width: 10%;">Period Start</th>
                                                                                                <th style="width: 8%;">Period End</th>
                                                                                            </thead>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr><td colspan="7" style="height:10px;"></td></tr>
                                                                                <tr style="display:none;" id="openfiscalyrtr">
                                                                                    <td colspan="3"></td>
                                                                                    <td colspan="4"></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </p>
                                                            </div>

                                                            <div class="tab-pane" id="hrbody" role="tabpanel" aria-labelledby="hrbody">
                                                                <p>
                                                                    <div class="divider">
                                                                        <div class="divider-text">HR</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-xl-1 col-md-3 col-sm-4 mt-1">
                                                                            <div class="nav-vertical nav-horizontal">
                                                                                <ul class="nav nav-tabs nav-left flex-column" role="tablist" id="verticaltab">
                                                                                    <li class="nav-item"><a class="nav-link active" id="overtimetab" data-toggle="tab" href="#overtimetabody" aria-controls="overtimetab" role="tab" aria-selected="true">Overtime</a></li>
                                                                                    <li class="nav-item"><a class="nav-link " id="payrolltab" data-toggle="tab" href="#payrolltabody" aria-controls="payrolltab" role="tab" aria-selected="true">Payroll</a></li>
                                                                                </ul> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-11 col-md-9 col-sm-8 mt-1">
                                                                            <div class="tab-content" id="verticaltabbody">
                                                                                <div class="tab-pane active" id="overtimetabody" aria-labelledby="overtimetabody" role="tabpanel">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1" style="text-align: right;">
                                                                                            <button id="assignotlevel" type="button" class="btn btn-gradient-success btn-sm assignotlevel"><i class="fa fa-plus" aria-hidden="true"></i>  Assign Overtime Level</button>
                                                                                        </div>
                                                                                        <div class="col-xl-12 col-md-12 col-sm-12 mb-3">
                                                                                            <table id="overtimetable" class="mb-0 rtable" style="width:100%;">  
                                                                                                <thead style="font-size: 13px;">
                                                                                                    <tr>
                                                                                                        <th rowspan="3" style="width:3%;">#</th>
                                                                                                        <th rowspan="3" style="width:7%;">Days</th>
                                                                                                        <th colspan="288" style="width:90%;">Times</th>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th colspan="144" style="width:45%;">AM</th>
                                                                                                        <th colspan="144" style="width:45%;">PM</th>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">00</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">01</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">02</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">03</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">04</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">05</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">06</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">07</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">08</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">09</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">10</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">11</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">12</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">13</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">14</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">15</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">16</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">17</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">18</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">19</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">20</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">21</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">22</th>
                                                                                                        <th colspan="12" style="text-align: center;width:3.75%;">23</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody></tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="col-xl-3 col-md-3 col-sm-6">
                                                                                            <label style="font-size: 14px;">Overtime Level for Day Off</label>
                                                                                            <select class="select2 form-control" name="OvertimeLevelDayOff" id="OvertimeLevelDayOff" onchange="otdayoffcalcFn()">
                                                                                                @foreach ($otdayoffseldata as $otdayoffseldata)
                                                                                                <option value="{{$otdayoffseldata->id}}">{{$otdayoffseldata->OvertimeLevelName}}</option>
                                                                                                @endforeach
                                                                                                @foreach ($otdayoffdata as $otdayoffdata)
                                                                                                <option value="{{$otdayoffdata->id}}">{{$otdayoffdata->OvertimeLevelName}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            <span class="text-danger">
                                                                                                <strong id="otdayoff-error" class="errordatalabel"></strong>
                                                                                            </span>    
                                                                                        </div>
                                                                                        <div class="col-xl-3 col-md-3 col-sm-6">
                                                                                            <label style="font-size: 14px;">Overtime Level for Holiday</label>
                                                                                            <select class="select2 form-control" name="OvertimeLevelHoliday" id="OvertimeLevelHoliday" onchange="otholidaycalcFn()">
                                                                                                @foreach ($otholidayseldata as $otholidayseldata)
                                                                                                <option value="{{$otholidayseldata->id}}">{{$otholidayseldata->OvertimeLevelName}}</option>
                                                                                                @endforeach
                                                                                                @foreach ($otholidaydata as $otholidaydata)
                                                                                                <option value="{{$otholidaydata->id}}">{{$otholidaydata->OvertimeLevelName}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                            <span class="text-danger">
                                                                                                <strong id="otholiday-error" class="errordatalabel"></strong>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="tab-pane" id="payrolltabody" aria-labelledby="payrolltabody" role="tabpanel">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                                                                            <table id="dynamicTable" class="mb-0 rtable" style="width: 100%">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th rowspan="2" style="width:3%;">#</th>
                                                                                                        <th colspan="2" style="width:50%;">Salary Range</th>
                                                                                                        <th rowspan="2" style="width:18%;">Tax Rate %</th>
                                                                                                        <th rowspan="2" style="width:16%;">Deduction</th>
                                                                                                        <th rowspan="2" style="width:3%;"></th>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <th style="width:25%;">Min</th>
                                                                                                        <th style="width:25%;">Max</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody></tbody>
                                                                                            </table>
                                                                                            <table class="mb-0">
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                                                                    <td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </p>
                                                            </div>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Vertical Left Tabs ends -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert"
                        style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
                        <div class="toast-body">
                            <strong id="toast-massages"></strong>
                            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                </section>
            </form>
        </div>
    @endcan
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
                            <input type="text" placeholder="MRC Number" class="form-control compmrc" name="mrcnumber"
                                id="mrcnumber" onkeypress="removeMrcNameValidation()" onkeyup="countAddEdMrcChar(this)"
                                ondrop="return false;" onpaste="return false;" />
                            <span class="text-danger">
                                <strong id="muname-error"></strong>
                            </span>
                        </div>
                        <label strong style="font-size: 16px;">Status</label>
                        <div class="form-group">
                            <div class="invoice-customer">
                                <select class="form-control" name="status" id="status">
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
    
    <!--Start change fiscal year modal -->
    <div class="modal fade text-left" id="previewfiscalyear" data-keyboard="false" data-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">New Fiscal Year</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newfiscalyear">
                    <div class="modal-body">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width:8%;">
                                    <label strong style="font-size: 14px;">No. of Year : </label>
                                </td>
                                <td style="width:10%;">
                                    <select class="form-control" name="NumberOfYear" id="NumberOfYear" onchange="numberofyearval()">
                                        <option value="" selected></option>
                                        <option value="1">1</option>
                                        {{-- <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option> --}}
                                    </select>
                                </td>
                                <td style="width:3%;"></td>
                                <td style="width:15%;">
                                    <label strong style="font-size: 14px;" id="numofperlbl">No. of Periods : </label>
                                    <input type="hidden" name="numofperiod" placeholder="" id="numofperiod" class="form-control"  readonly style="font-weight:bold;"/>
                                </td>
                                <td style="width:3%;"></td>
                                <td>
                                    <label id="startdatelbl" style="font-size: 14px;">Start Date : </label>
                                    <input type="hidden" class="form-control" name="startdateval" id="startdateval" readonly="true" value=""/>
                                </td>

                                <td style="width:3%;"></td>
                                <td>
                                    <label id="calendarlbl" style="font-size: 14px;">Calendar : </label>
                                    <input type="hidden" class="form-control" name="calendarval" id="calendarval" readonly="true"/>
                                </td>
                                <td style="width:3%;"></td>
                                <td>
                                    <label id="openedfiscalyr" style="font-size: 14px;"></label>
                                    <input type="hidden" class="form-control" name="fiscalyrhids" id="fiscalyrhids" readonly="true" value="{{$fiscalyearattr->id}}"/>
                                </td>
                            </tr>
                            <tr><td colspan="10" style="height: 10px;"></td></tr>
                            <tr>
                                <td colspan="10" style="width: 100%;"><div id="fiscalyeardivtbl"></div><label id="fiscalyearlbltbl" style="font-size: 14px;"></label></td>
                            </tr>
                        </table>
                        <div class="mt-1 ml-1" style="display: none;" id="resetdocdiv">
                            <label id="startdoclbl" for="resetdoc" style="font-size: 14px;font-weight:bold;">Reset document numbers</label>
                            <input name="resetdoc" type="checkbox" id="resetdoc" />
                            <input type="hidden" class="form-control" name="resetdocval" id="resetdocval" readonly="true" value="1"/>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button id="openewfiscalyear" type="button" class="btn btn-info" style="display:none;" data-toggle="modal" data-target="#fiscalyearchangemodal" onclick="openFyModalFn()">Open New Fiscal Year</button>
                        <button id="closebuttonfy" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End change fiscal year Modal -->
    
    <!--Start change fiscal year modal -->
    <div class="modal fade text-left" id="fiscalyearchangemodal" data-keyboard="false" data-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changefyform">
                    <div class="modal-body" style="background-color: #ea5455;">
                        <label strong style="font-size: 16px;color:white;font-weight:bold;">Are you sure you want to change Fiscal Year</label>
                    </div>   
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="resetdocvalfy" id="resetdocvalfy" readonly="true"/>
                        <button id="confirmfybtn" type="button" class="btn btn-info">Confirm</button>
                        <button id="closebuttonfy" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End change fiscal year Modal -->

    <!--Start OT level assignment Modal -->
    <div class="modal fade" id="otlevelassignmentmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Overtime Level Assignment</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="AssignmentForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                <div class="divider">
                                    <div class="divider-text">Days</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <span class="text-danger">
                                            <strong id="days-error"></strong>
                                        </span>
                                        <div class="custom-control custom-control-primary custom-checkbox">
                                            <input type="checkbox" class="custom-control-input selectallcbx" id="selectallcbx" name="selectallcbx[]"/>
                                            <label class="custom-control-label" for="selectallcbx" style="font-weight: bold;">Select All</label>                                                
                                        </div>
                                        <div id="dayslist" class="scrollhor"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="divider">
                                    <div class="divider-text">Time & Overtime Level</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12 mb-1">
                                        <label style="font-size: 14px;">Overtime Level</label><label style="color: red; font-size:16px;">*</label>
                                        <select class="select2 form-control" name="OvertimeLevel" id="OvertimeLevel" onchange="overtimecalcFn()">
                                            @foreach ($overtimedata as $overtimedata)
                                            <option title="{{$overtimedata->Color}}" label="{{$overtimedata->WorkhourRate}}" value="{{$overtimedata->id}}">{{$overtimedata->OvertimeLevelName}}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            <strong id="overtimecalc-error" class="errordatalabel"></strong>
                                        </span>                                   
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label style="font-size: 14px;" for="StartTime">Start Time</label><label style="color: red; font-size:16px;">*</label><br>
                                        <input type="text" placeholder="Start Time" class="form-control mainforminp" name="StartTime" id="StartTime" onchange="startTimeFn()"/>
                                        <span class="text-danger">
                                            <strong id="startime-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                        <label style="font-size: 14px;" for="EndTime">End Time</label><label style="color: red; font-size:16px;">*</label><br>
                                        <input type="text" placeholder="End Time" class="form-control mainforminp" name="EndTime" id="EndTime" onchange="endTimeFn()"/>
                                        <span class="text-danger">
                                            <strong id="endtime-error" class="errordatalabel"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="assigntoshiftandnew" type="button" class="btn btn-info assignbtn">Assign & New</button>
                        <button id="assigntoshiftandclose" type="button" class="btn btn-info assignbtn">Assign & Close</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End OT level assignment Modal -->

    <!--Start timetable delete modal -->
    <div class="modal fade text-left" id="otleveldeletemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletetimeform">
                    @csrf
                    <div class="modal-body" style="background-color:#e74a3b">
                        <label id="otlevelconfdata" style="font-size: 16px;color:white;"></label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="timeTblId" id="timeTblId" readonly="true">
                            <input type="hidden" class="form-control" name="timeRowId" id="timeRowId" readonly="true">
                            <input type="hidden" class="form-control" name="timeTdIndex" id="timeTdIndex" readonly="true">
                            <input type="hidden" class="form-control" name="timeColspanVal" id="timeColspanVal" readonly="true">
                            <input type="hidden" class="form-control" name="timeNameVal" id="timeNameVal" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="otleveldeletebtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End timetable delete modal -->

    </div>

    <script type="text/javascript">
        $('input[type=radio][name=cost]').on('change', function(){
            switch($(this).val()){
                    case '0' :
                    $('#costType').val('0');
                        break;
                    case '1' :
                    $('#costType').val('1');
                        break;
            }
        });

        var errorcolor="#ffcccc";
        var j=0;
        var i=0;
        var m=0;

        var x=0;
        var y=0;
        var z=0;

        var endtimeval="23:59";
        var inptime={0:{name:'.',stime:'00:00',etime:'00:00',duration:'0',color:'#000000'}};
        var flagdata=0;
        var days=[];
        var startdatearr=[];
        var enddatearr=[];
        var rowinfodata={};
        var rowallinfodata={};
        var rowrepoinfodata={};
        var timetableobj={};
        var timetablealldata={};
        var saveobjectdata={};

        $(document).ready(function() {
            $.get("/getCompLogo/", function(data) {
                $("#compLogo").html(data.getCompanyLogos);
            });
            $('#uplcomplogo').hide();
            $('#clearbtndiv').show();
            $('#compLogo').show();
            $('#purchasernm').select2();
            $(".selectpicker").selectpicker({
                noneSelectedText: ''
            });
            var fyear = $("#fiscalyeari").val();
            var fyearfl = $("#fiscalyeariflag").val();
            $("#fiscalyr").selectpicker('val', fyear);

            if(parseFloat(fyearfl)==1){
                $('#newfytr').hide();
            }
            else if(parseFloat(fyearfl)!=1){
                $('#newfytr').hide();
            }
            
            $('#laravel-datatable-crud-mrc').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-2 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-8'l><'col-sm-12 col-md-3'>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showsettingmrc',
                    type: 'DELETE',
                    dataType: "json",
                },
                columns: [{
                        data: 'id',
                        name: 'id',
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
            $('#fiscalyrperiod').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:false,
                info:false,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showfiscalperiods',
                    type: 'DELETE',
                    },
                columns: [
                    { data:'id',name:'id','visible': false },
                    { data: 'PeriodName', name: 'PeriodName'},
                    { data: 'PeriodStartDate', name: 'PeriodStartDate'},
                    { data: 'PeriodEndDate', name: 'PeriodEndDate'},
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    var today = new Date();
                    var dd = ((today.getDate().length + 1) === 1) ? (today.getDate() + 0) : '0' + (today.getDate() + 0);
                    var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : '0' + (today.getMonth() + 1);
                    var yyyy = today.getFullYear();
                    var formatedCurrentDate = moment(today,"YYYY/MM/DD").format('YYYY/MM/DD');
                    if ((formatedCurrentDate>= aData.PeriodStartDate) && (formatedCurrentDate<=aData.PeriodEndDate)) {
                        for(var i=0;i<=3;i++){
                            $(nRow).find('td:eq('+i+')').css({"background-color":"#4CAF50","color": "#FFFFFF","font-weight": "bold"});
                        }
                    }    
                }
            });
            var cuscode = $("#cuscodecheckboxVali").val();
            var costType=$('#costType').val();
            var wholesalefeature=$('#wholesalefeature').val();
            var unlimitflagvar = $("#unlimitflag").val();
            var settleoutst = $("#settleoutstanding").val();
            if(costType==0){
                // enable max cost
                $("#maxcostcheck").prop("checked", true);
                $("#averagecostcheck").prop("checked", false);
            }
            if(costType==1){
                // enable max cost
                $("#maxcostcheck").prop("checked", false);
                $("#averagecostcheck").prop("checked", true);
            }

            if(wholesalefeature==0){
                $("#wholesalefeaturecheck").prop("checked", false);
            }
            if(wholesalefeature==1){
                $("#wholesalefeaturecheck").prop("checked", true);
            }
            if (cuscode === "0") {
                $("#customercode").prop("checked", false);
            }
            if (cuscode === "1") {
                $("#customercode").prop("checked", true);
            }
            if (unlimitflagvar === "0") {
                $("#unlimitcreditslcbx").prop("checked", false);
                $("#unlimitflag").prop("checked", false);
                $("#CreditSalesLimitEnd").prop("readonly",false);
            }
            if (unlimitflagvar === "1") {
                $("#unlimitcreditslcbx").prop("checked", true);
                $("#CreditSalesLimitEnd").prop("readonly",true);
                $("#CreditSalesLimitEnd").val("");
            }

            if (settleoutst === "0") {
                $("#settleoutcbx").prop("checked", false);
            }
            if (settleoutst === "1") {
                $("#settleoutcbx").prop("checked", true);
            }

            var itemcodes = $("#itemcodeval").val();
            if (itemcodes === "0") {
                $("#itemcode").prop("checked", false);
            }
            if (itemcodes === "1") {
                $("#itemcode").prop("checked", true);
            }

            var skureq = $("#skunumberreq").val();
            $("#RequireSku").val(skureq);
            var isaleblockhidden=$("#isaleblockhidden").val();
            $('#isaleblock').select2('destroy');
            $('#isaleblock').val(isaleblockhidden).select2();

            switch (isaleblockhidden) {
                case '1':
                    $('#pendingwaitdiv').show();
                    $('#nofsalesonpendingdiv').show();
                    break;
                default:
                    $('#pendingwaitdiv').hide();
                    $('#nofsalesonpendingdiv').hide();
                    break;
            }

            //-------------------HR Start-----------------------

            $("#overtimetable > tbody").empty();
            $("#dynamicTable > tbody").empty();

            var rowdata="<tr>";
            var daysname=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $.each(daysname, function(index,day) {
                ++m;
                if(parseInt(m)<=9){
                    m="0"+m;
                }
                rowdata+="<td style='text-align:center;font-weight:bold;width:3%;'>"+m+"</td><td style='display:none;'><input type='hidden' id='flagvalue"+m+"' class='flagvalue form-control' readonly='true' value='0'/></td><td style='display:none;'><label id='rowobjectval"+m+"'></label></td><td id='days_"+m+"' style='text-align:center;font-weight:bold;width:7%;'>"+day+"</td>";
                for(let q=1;q<=288;q++){
                    rowdata+="<td style='width:0.3125%;' id="+m+"_"+q+" ondblclick='removeTime("+m+","+q+")'></td>";
                }
                rowdata+="</tr>";
            });
            $("#overtimetable > tbody").append(rowdata);

            $('#overtimetable > tbody  > tr').each(function(index, tr) {
                var ind= ++index;
                var keyvaldata=0;
                var n=0;
                if(parseInt(ind)<=9){
                    ind="0"+ind;
                }

                startdatearr=[];
                enddatearr=[];
                var hour="";
                var min="";
                var endhour="";
                var endmin="";

                $.get("/otSettingData", function(data) {
                    $.each(data.overtimesett, function(i,val) {
                        n=parseInt(i)+parseInt(1);
                        flagdata=1;
                        if(parseInt(ind)==parseInt(val.daynum)){
                            var indval=0;
                            var colsp=0;
                            var starttime=val.StartTime;
                            var endtime=val.EndTime;
                            var startimea=null;
                            var endtimea=null;
                            var timetablename=null;
                            var rowindex=null;
                            var dayindex=null;
                            var dayname=null;
                            var timetblname=null;
                            
                            min=moment("2000-01-01 "+starttime+":00").format("mm"); 
                            hour=moment("2000-01-01 "+starttime+":00").format("HH");

                            endmin=moment("2000-01-01 "+endtime+":00").format("mm"); 
                            endhour=moment("2000-01-01 "+endtime+":00").format("HH");

                            startimea=hour+":"+min;
                            endtimea=endhour+":"+endmin;
                            
                            startdatearr.push(hour+":"+min);
                            enddatearr.push(endhour+":"+endmin);

                            var starttimemins=(parseFloat(min)/parseFloat(60));
                            var colindex=Math.round((parseFloat(hour)*parseInt(12)+parseFloat(starttimemins)*parseInt(12))+parseInt(1));
                            var endtimemins=(parseFloat(endmin)/parseFloat(60));
                            var colmaxindex=Math.round((parseFloat(endhour)*parseInt(12)+parseFloat(endtimemins)*parseInt(12))+parseInt(1));
                            
                            for(var cls=colindex;cls<colmaxindex;cls++){
                                $("#"+ind+"_"+cls).attr("class","rowclass_"+ind+"_"+n);
                            }
                            for(var cls=colindex+1;cls<colmaxindex;cls++){
                                $("#"+ind+"_"+cls).remove();
                            }
                            
                            var colspanval=parseFloat(colmaxindex)-parseFloat(colindex);
                            $(".rowclass_"+ind+"_"+n).attr("colspan",colspanval);
                            $(".rowclass_"+ind+"_"+n).css({"background-color":val.Color,"border-bottom-color":"white","color":"white","text-align":"center","font-weight":"bold"});
                            $(".rowclass_"+ind+"_"+n).html(val.OvertimeLevelName+" ("+val.StartTime+"-"+val.EndTime+") Rate:"+val.WorkhourRate+"%");
                            $(".rowclass_"+ind+"_"+n).attr('title',"Name: "+val.OvertimeLevelName+"\nTime: "+val.StartTime+"-"+val.EndTime+"\nRate: "+val.WorkhourRate+"%");
                        }
                    });
                });
            });

            $.get("/payrollSettingData", function(data) {
                $.each(data.payrollsett, function(index,value) {
                    ++x;
                    ++z;
                    y += 1;

                    var maxval=0;
                    var taxamnt=0;
                    var deductionamnt=0;
                    if(parseInt(index)==0){
                        if(value.MaxAmount===0){
                            maxval="0";
                        }
                        if(value.TaxRate===0){
                            taxamnt="0";
                        }
                        if(value.Deduction===0){
                            deductionamnt="0";
                        }
                    }
                    if(parseInt(index)>0){
                        if(value.MaxAmount===0){
                            maxval="";
                        }
                        if(value.TaxRate===0){
                            taxamnt="";
                        }
                        if(value.Deduction===0){
                            deductionamnt="";
                        }
                    }

                    if(parseFloat(value.MaxAmount)>0){
                        maxval=value.MaxAmount;
                    }
                    if(parseFloat(value.TaxRate)>0){
                        taxamnt=value.TaxRate;
                    }
                    if(parseFloat(value.Deduction)>0){
                        deductionamnt=value.Deduction;
                    }
                    
                    $("#dynamicTable > tbody").append(
                        '<tr><td style="font-weight:bold;text-align:center;width:3%">'+y+'</td>'+
                        '<td style="width:25%"><input type="number" name="payrow['+z+'][MinAmount]" placeholder="Min Amount" id="MinAmount'+z+'" class="MinAmount form-control numeral-mask" onkeyup="MinAmountFn(this)" onkeypress="return ValidateNum(event);" value="'+value.MinAmount+'"/></td>'+
                        '<td style="width:25%"><input type="number" name="payrow['+z+'][MaxAmount]" placeholder="Max Amount" id="MaxAmount'+z+'" class="MaxAmount form-control numeral-mask" onkeyup="MaxAmountFn(this)" onkeypress="return ValidateNum(event);" onblur="valMaxAmountFn(this)" value="'+maxval+'"/></td>'+
                        '<td style="width:18%"><input type="number" name="payrow['+z+'][TaxRate]" placeholder="Tax Rate" id="TaxRate'+z+'" class="TaxRate form-control numeral-mask" onkeyup="TaxRateFn(this)" onkeypress="return ValidateNum(event);" value="'+taxamnt+'"/></td>'+
                        '<td style="width:16%"><input type="number" name="payrow['+z+'][Deduction]" placeholder="Deduction" id="Deduction'+z+'" class="Deduction form-control numeral-mask" onkeyup="DeductionFn(this)" onkeypress="return ValidateNum(event);" value="'+deductionamnt+'"/></td>'+
                        '<td style="width:3%;text-align:center;"><button type="button" id="removepaybtn'+z+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                        '<td style="display:none;"><input type="hidden" name="payrow['+z+'][payval]" id="payval'+z+'" class="payval form-control" readonly="true" style="font-weight:bold;" value="'+z+'"/></td></tr>'
                    );
                });
                $('.remove-tr').css({"display":"none"});
                $('.MinAmount').prop("readonly",true);
                $('.MaxAmount').prop("readonly",true);
                var lastValue=$('#dynamicTable tr:last input.payval').val();
                $('#removepaybtn'+lastValue).css({"display":"block"});
                $('#MinAmount'+lastValue).prop("readonly",true);
                $('#MaxAmount'+lastValue).prop("readonly",false);
            });

            //-------------------HR End-----------------------
        });

        $('#isaleblock').on ('change', function () {
            var isblock= $('#isaleblock').val()||0;
            switch (isblock) {
                case '1':
                    $('#pendingwaitdiv').show();
                    $('#nofsalesonpendingdiv').show();
                    break;
            
                default:
                    $('#pendingwaitdiv').hide();
                    $('#nofsalesonpendingdiv').hide();
                    break;
            }
        });

        //----------------------HR Start--------------------

        $("#adds").click(function() {
            var lastValue=$('#dynamicTable tr:last input.payval').val();
            var minamount=$('#MinAmount'+lastValue).val();
            var maxamount=$('#MaxAmount'+lastValue).val();
            var taxrateamount=$('#TaxRate'+lastValue).val();
            var deductionamount=$('#Deduction'+lastValue).val();
            if((minamount!==undefined && isNaN(parseFloat(minamount))) || (maxamount!==undefined && isNaN(parseFloat(maxamount))) || (taxrateamount!==undefined && isNaN(parseFloat(taxrateamount))) || (deductionamount!==undefined && isNaN(parseFloat(deductionamount)))){
                if(minamount!==undefined && isNaN(parseFloat(minamount))){
                    $('#MinAmount'+lastValue).css("background", errorcolor);
                }
                if(maxamount!==undefined && isNaN(parseFloat(maxamount))){
                    $('#MaxAmount'+lastValue).css("background", errorcolor);
                }
                if(taxrateamount!==undefined && isNaN(parseFloat(taxrateamount))){
                    $('#TaxRate'+lastValue).css("background", errorcolor);
                }
                if(deductionamount!==undefined && isNaN(parseFloat(deductionamount))){
                    $('#Deduction'+lastValue).css("background", errorcolor);
                }
            }
            else{

                ++x;
                ++z;
                y += 1;
                $('.MaxAmount').css({"background":"#efefef"});
                $("#dynamicTable > tbody").append(
                    '<tr><td style="font-weight:bold;text-align:center;width:3%">'+y+'</td>'+
                    '<td style="width:25%"><input type="text" name="payrow['+z+'][MinAmount]" placeholder="Min Amount" id="MinAmount'+z+'" class="MinAmount form-control numeral-mask" onkeyup="MinAmountFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:25%"><input type="text" name="payrow['+z+'][MaxAmount]" placeholder="Max Amount" id="MaxAmount'+z+'" class="MaxAmount form-control numeral-mask" onkeyup="MaxAmountFn(this)" onkeypress="return ValidateNum(event);" onblur="valMaxAmountFn(this)"/></td>'+
                    '<td style="width:18%"><input type="text" name="payrow['+z+'][TaxRate]" placeholder="Tax Rate" id="TaxRate'+z+'" class="TaxRate form-control numeral-mask" onkeyup="TaxRateFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:16%"><input type="text" name="payrow['+z+'][Deduction]" placeholder="Deduction" id="Deduction'+z+'" class="Deduction form-control numeral-mask" onkeyup="DeductionFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removepaybtn'+z+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="payrow['+z+'][payval]" id="payval'+z+'" class="payval form-control" readonly="true" style="font-weight:bold;" value="'+z+'"/></td></tr>'
                );
                renumberRows();

                $('.remove-tr').css({"display":"none"});
                $('.MinAmount').prop("readonly",true);
                $('.MaxAmount').prop("readonly",true);
                var lastValueAppend=$('#dynamicTable tr:last input.payval').val();
                $('#removepaybtn'+lastValueAppend).css({"display":"block"});
                $('#MinAmount'+lastValueAppend).prop("readonly",true);
                $('#MaxAmount'+lastValueAppend).prop("readonly",false);
                var isDecimal = maxamount % 1 !== 0;
                if(isDecimal==true){
                    $('#MinAmount'+lastValueAppend).val((parseFloat(maxamount)+parseFloat(0.1)).toFixed(1));
                }
                else if(isDecimal==false){
                    $('#MinAmount'+lastValueAppend).val(parseFloat(maxamount)+parseFloat(1));
                }
                var minamnt=$('#MinAmount'+lastValueAppend).val()||0;
                if(parseFloat(minamnt)==0 || isNaN(parseFloat(minamnt))){
                    $('#MinAmount'+lastValueAppend).val("0");
                }
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            var lastValue=$('#dynamicTable tr:last input.payval').val();
            $('#removepaybtn'+lastValue).css({"display":"block"});
            $('#MinAmount'+lastValue).prop("readonly",true);
            $('#MaxAmount'+lastValue).prop("readonly",false);
            renumberRows();
            --x;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                ind = index - 1;
            });
        }

        $('.assignotlevel').click(function(){
            $('#selectallcbx').prop('indeterminate', false); 
            $('#selectallcbx').prop('checked', false); // Unchecks it
            $('#OvertimeLevel').val(null).trigger('change').select2
            ({
                placeholder: "Select overtime level here",
            });
            $('.mainforminp').val("");
            $('.errordatalabel').html("");
            var daysname=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            $("#dayslist").empty();
            $.each(daysname, function(m,day) {
                ++m;
                if(parseInt(m)<=9){
                    m="0"+m;
                }
                $("#dayslist").append('<div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input daylst" id="daylst'+m+'" name="daylst[]" value="'+m+'"/><label class="custom-control-label" for="daylst'+m+'">'+day+'</label></div>');
            });
            flatpickr('#StartTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:"",static:true});
            flatpickr('#EndTime', {clickOpens:false});
            $("#otlevelassignmentmodal").modal('show');
        });

        $('.assignbtn').click(function(){
            var errorflags=0;
            var timetablenamearr=[];
            var rowindexarr=[];
            var dayindexarr=[];
            var otleveltext = $('#OvertimeLevel').find('option:selected').text();
            var selectedOption = $('#OvertimeLevel').find('option:selected');
            var colorValue = selectedOption.attr('title');
            var rateValue = selectedOption.attr('label');
            var otvalue = selectedOption.attr('value');
            var starttime=$('#StartTime').val();
            var endtime=$('#EndTime').val();
            var daylist=$('.daylst:checked').length;
            var timetablelen=$('.timetable:checked').length;

            if(parseInt(daylist)==0 || isNaN(parseInt(otvalue)) || starttime=="" || endtime==""){
                if(isNaN(parseInt(otvalue))){
                    $('#overtimecalc-error').html("overtime level is required.");
                }
                if(starttime==""){
                    $('#startime-error').html("start time is required.");
                }
                if(endtime==""){
                    $('#endtime-error').html("end time is required.");
                }
                if(parseInt(daylist)==0){
                    $('#days-error').html("at-least one day is required.");
                }
                toastrMessage('error',"Please check required boxes","Error");
            }
            else if(parseInt(daylist)>0 && !isNaN(parseInt(otvalue)) && starttime!=null && endtime!=null){
                
                $('#overtimetable > tbody  > tr').each(function(index, tr) { 
                    var ind= ++index;
                    var keyvaldata=0;
                    if(parseInt(ind)<=9){
                        ind="0"+ind;
                    }

                    var selectedValues = [];
                    $('.daylst:checked').each(function() {
                       
                        if(ind == $(this).val()){
                            i+=1;
                            console.log("This is i="+i);
                            var indval=0;
                            var colsp=0;
                            var startimea=null;
                            var endtimea=null;
                            var timetablename=null;
                            var rowindex=null;
                            var dayindex=null;
                            var dayname=null;
                            var timetblname=null;

                            min=moment("2000-01-01 "+starttime+":00").format("mm"); 
                            hour=moment("2000-01-01 "+starttime+":00").format("HH");

                            endmin=moment("2000-01-01 "+endtime+":00").format("mm"); 
                            endhour=moment("2000-01-01 "+endtime+":00").format("HH");

                            startimea=hour+":"+min;
                            endtimea=endhour+":"+endmin;

                            dayname=$('#days_'+ind).text();
                            timetablename="<b>"+dayname+" "+otleveltext+"</b> time overlaps on row <b>"+ind+"</b>,</br>";
                            rowindex=ind;
                            timetblname=otleveltext+" ("+starttime+"-"+endtime+")";

                            startdatearr.push(hour+":"+min);
                            enddatearr.push(endhour+":"+endmin);

                            if(parseInt(flagdata)==0){
                                var starttimemins=(parseFloat(min)/parseFloat(60));
                                var colindex=Math.round((parseFloat(hour)*parseInt(12)+parseFloat(starttimemins)*parseInt(12))+parseInt(1));
                                var endtimemins=(parseFloat(endmin)/parseFloat(60));
                                var colmaxindex=Math.round((parseFloat(endhour)*parseInt(12)+parseFloat(endtimemins)*parseInt(12))+parseInt(1));
                                for(var cls=colindex;cls<colmaxindex;cls++){
                                    $("#"+ind+"_"+cls).attr("class", "rowclass_"+ind+"_"+i);
                                }
                                for(var cls=colindex+1;cls<colmaxindex;cls++){
                                    $("#"+ind+"_"+cls).remove();
                                }
                                var colspanval=parseFloat(colmaxindex)-parseFloat(colindex);
                                $(".rowclass_"+ind+"_"+i).attr("colspan",colspanval);
                                $(".rowclass_"+ind+"_"+i).css({"background-color":colorValue,"border-bottom-color":"white","color":"white","text-align":"center","font-weight":"bold"});
                                $(".rowclass_"+ind+"_"+i).html(otleveltext+" ("+starttime+"-"+endtime+") Rate:"+rateValue+"%");
                                $(".rowclass_"+ind+"_"+i).attr('title',"Name: "+otleveltext+"\nTime: "+starttime+"-"+endtime+"\nRate: "+rateValue+"%");
                            }

                            else if(parseInt(flagdata)==1){
                                var ovrcheck=0;
                                var classname=null;
                                var colspanatt=null;
                                var classtartime=null;
                                var classorginaltime=null;
                                var classendtime=null;
                                var classendtimesval=null;
                                var sminute=0;
                                var shour =0;
                                var finalshour=0;
                                var finalsminute=0;
                                var startfinal=0;

                                var eminute=0;
                                var ehour =0;
                                var finalehour=0;
                                var finaleminute=0;
                                var endfinal=0;
                                
                                var starttimemins=(parseFloat(min)/parseFloat(60));
                                var colindex=Math.round((parseFloat(hour)*parseInt(12)+parseFloat(starttimemins)*parseInt(12))+parseInt(1));
                                var endtimemins=(parseFloat(endmin)/parseFloat(60));
                                var colmaxindex=Math.round((parseFloat(endhour)*parseInt(12)+parseFloat(endtimemins)*parseInt(12))+parseInt(1));
                                var diff=parseFloat(colmaxindex)-parseFloat(colindex);

                                var counter=0;
                                var namecounter=0;
                                var index=1;
                                for(var ovrch=colindex;ovrch<colmaxindex;ovrch++){
                                    if ($("#"+ind+"_"+ovrch).length) {
                                        counter++;
                                    }
                                }
                                for(var colindex=1;colindex<=288;colindex++){
                                    var stra=$("#"+ind+"_"+colindex).text();
                                    var strb=timetblname;
                                    if(stra.indexOf(strb) != -1){
                                        namecounter++;
                                    }
                                }

                                if(parseInt(counter)==parseInt(diff)){
                                    var starttimemins=(parseFloat(min)/parseFloat(60));
                                    var colindex=Math.round((parseFloat(hour)*parseInt(12)+parseFloat(starttimemins)*parseInt(12))+parseInt(1));
                                    var endtimemins=(parseFloat(endmin)/parseFloat(60));
                                    var colmaxindex=Math.round((parseFloat(endhour)*parseInt(12)+parseFloat(endtimemins)*parseInt(12))+parseInt(1));
                                
                                    console.log(starttimemins+"         "+colindex+"         "+endtimemins+"         "+colmaxindex);
                                    for(var cls=colindex;cls<colmaxindex;cls++){
                                        $("#"+ind+"_"+cls).attr("class", "rowclass_"+ind+"_"+i);
                                    }
                                    for(var cls=colindex+1;cls<colmaxindex;cls++){
                                        $("#"+ind+"_"+cls).remove();
                                    }
                                    var colspanval=parseFloat(colmaxindex)-parseFloat(colindex);
                                    $(".rowclass_"+ind+"_"+i).attr("colspan",colspanval);
                                    $(".rowclass_"+ind+"_"+i).css({"background-color":colorValue,"border-bottom-color":"white","color":"white","text-align":"center","font-weight":"bold"});
                                    $(".rowclass_"+ind+"_"+i).html(otleveltext+" ("+starttime+"-"+endtime+") Rate:"+rateValue+"%");
                                    $(".rowclass_"+ind+"_"+i).attr('title',"Name: "+otleveltext+"\nTime: "+starttime+"-"+endtime+"\nRate: "+rateValue+"%");
                                }
                                else if(parseInt(counter)!=parseInt(diff) && parseInt(namecounter)==0){
                                    errorflags+=1;
                                    timetablenamearr.push(timetablename);
                                }
                            }
                        }
                    });
                }); 
                
                flagdata=1;
                if(parseInt(errorflags)>=1){
                    toastrMessage('error',timetablenamearr,"Error");
                }
                else if(parseInt(errorflags)==0){
                    var registerForm = $("#AssignmentForm");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/saveOtSetting',
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            if (data.dberrors) {
                                toastrMessage('error',"Please contact administrator","Error");
                            } 
                        },
                    });

                    if($(this).attr('id')=="assigntoshiftandclose"){
                        $("#otlevelassignmentmodal").modal('hide');
                    }
                    else if($(this).attr('id')=="assigntoshiftandnew"){
                        $('#selectallcbx').prop('indeterminate', false); 
                        $('#selectallcbx').prop('checked', false); // Unchecks it
                        $('#OvertimeLevel').val(null).trigger('change').select2
                        ({
                            placeholder: "Select overtime level here",
                        });
                        var daysname=['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                        $("#dayslist").empty();
                        $.each(daysname, function(m,day) {
                            ++m;
                            if(parseInt(m)<=9){
                                m="0"+m;
                            }
                            $("#dayslist").append('<div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" class="custom-control-input daylst" id="daylst'+m+'" name="daylst[]" value="'+m+'"/><label class="custom-control-label" for="daylst'+m+'">'+day+'</label></div>');
                        });
                        $('.mainforminp').val("");
                        $('.errordatalabel').html("");
                        flatpickr('#StartTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:"00:00",maxTime:endtimeval,defaultHour:"",static:true});
                        flatpickr('#EndTime', {clickOpens:false});
                    }   
                }  
            }       
        });

        $('#selectallcbx').change(function() {
            if($(this).is(":checked")) {
                $('.daylst').prop('checked', true); 
            }
            else{
                $('.daylst').prop('checked', false);
            }
            $('#days-error').html("");
        });

        $(document).on('click', '.daylst', function(){
            var currentind=null;
            if($(this).is(":checked")) {
                currentind=$(this).val();
                var allclass=$('.daylst').length;
                var checkedclass=$('.daylst:checked').length;
                if(parseInt(allclass)==parseInt(checkedclass)){
                    $('#selectallcbx').prop('indeterminate', false); 
                    $('#selectallcbx').prop('checked', true); 
                }
                else if(parseInt(allclass)!=parseInt(checkedclass)){
                    $('#selectallcbx').prop('indeterminate', true); 
                }
            }
            else{
                currentind=$(this).val();
                var allclass=$('.daylst').length;
                var uncheckedclass=$('.daylst:not(:checked)').length;
                if(parseInt(allclass)==parseInt(uncheckedclass)){
                    $('#selectallcbx').prop('indeterminate', false); 
                    $('#selectallcbx').prop('checked', false); 
                }
                else if(parseInt(allclass)!=parseInt(uncheckedclass)){
                    $('#selectallcbx').prop('indeterminate', true); 
                }
            }
            $('#days-error').html("");
        });

        function removeTime(idvala,idvalb) {
            if(parseInt(idvala)<=9){
                idvala="0"+idvala;
            }
            var colspanval= $("#"+idvala+"_"+idvalb).attr('colspan');
            if(colspanval!=undefined){
                var textname= $("#"+idvala+"_"+idvalb).text();
                var dayname= $("#days_"+idvala).text();
                var lbldata="Would you really like to delete <b>"+textname+"</b> on row <b>"+idvala+"</b>";
                $("#otlevelconfdata").html(lbldata);
                $("#timeTblId").val(idvala+"_"+idvalb);
                $("#timeRowId").val(idvala);
                $("#timeColspanVal").val(colspanval);
                $("#timeTdIndex").val(idvalb);
                $("#timeNameVal").val(textname);
                $("#otleveldeletemodal").modal('show');
            }
        }

        $('#otleveldeletebtn').click(function(){
            var keyids=null;
            var timeid=$('#timeTblId').val();
            var timerow=$('#timeRowId').val();
            var timecolspan=$('#timeColspanVal').val();
            var timetdindex=$('#timeTdIndex').val();
            var timenamedata=$('#timeNameVal').val();
            var lastindx=(parseInt(timetdindex)+parseInt(timecolspan))-parseInt(1);
            var lasttd="<td style='width:0.3125%;' id="+timerow+"_"+timetdindex+" ondblclick='removeTime("+timerow+","+timetdindex+")'></td>";
            $("#"+timerow+"_"+timetdindex).attr('colspan',0);
            $("#"+timerow+"_"+timetdindex).css({"background-color":"white","border-color":"#d9d7ce"});
            $("#"+timerow+"_"+timetdindex).text('');
            
            for(var tdindx=timetdindex;tdindx<lastindx;tdindx++){
                var tdnxt=tdindx;
                if(parseInt(tdindx)<=9){
                    tdindx="0"+tdindx;
                }
                $("#"+timerow+"_"+tdindx).after("<td style='width:0.3125%;' id="+timerow+"_"+(parseInt(tdindx)+parseInt(1))+" ondblclick='removeTime("+timerow+","+(parseInt(tdindx)+parseInt(1))+")'></td>");
            }

            var registerForm = $("#deletetimeform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/deleteOtSetting',
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data.dberrors) {
                        toastrMessage('error',"Please contact administrator","Error");
                    } 
                },
            });
            $("#otleveldeletemodal").modal('hide');
        });

        function startTimeFn() {
            var stime=$('#StartTime').val();
            flatpickr('#EndTime', {clickOpens:true,enableTime:true,noCalendar:true,time_24hr: true,dateFormat: 'H:i',minTime:stime,maxTime:endtimeval,defaultHour:"",static:true});
            $('#startime-error').html('');
        }

        function endTimeFn() {
            $('#endtime-error').html('');
        }

        function overtimecalcFn() {
            $('#overtimecalc-error').html('');
        }

        function otdayoffcalcFn() {
            $('#otdayoff-error').html('');
        }

        function otholidaycalcFn() {
            $('#otholiday-error').html('');
        }

        function MinAmountFn(ele) {
            var cid=$(ele).closest('tr').find('.payval').val();
            $('#MinAmount'+cid).css("background", "white");
        }

        function MaxAmountFn(ele) {
            var cid=$(ele).closest('tr').find('.payval').val();
            $('#MaxAmount'+cid).css("background", "white");
        }

        function TaxRateFn(ele) {
            var cid=$(ele).closest('tr').find('.payval').val();
            $('#TaxRate'+cid).css("background", "white");
        }

        function DeductionFn(ele) {
            var cid=$(ele).closest('tr').find('.payval').val();
            $('#Deduction'+cid).css("background", "white");
        }

        function valMaxAmountFn(ele) {
            var cid=$(ele).closest('tr').find('.payval').val();
            var minamnt=$('#MinAmount'+cid).val()||0;
            var maxamnt=$('#MaxAmount'+cid).val()||0;

            if(parseFloat(maxamnt)>0 && parseFloat(minamnt)>parseFloat(maxamnt)){
                $('#MaxAmount'+cid).val("");
                $('#MaxAmount'+cid).css("background",errorcolor);
                toastrMessage('error',"The minimum amount cannot be greater than the maximum amount.","Error");
            }
            if(parseFloat(maxamnt)==0){
                $('#MaxAmount'+cid).val("");
            }  
        }

        //----------------------HR End----------------------

        function skuprefixval() {
            $('#skuprefix-error').html('');
        }

        function skunumberval() {
            $('#skunumber-error').html('');
        }

        function recprefixval() {
            $('#recprefix-error').html('');
        }

        function recnumberval() {
            $('#recnumber-error').html('');
        }

        function holdprefixval() {
            $('#holdprefix-error').html('');
        }

        function holdnumberval() {
            $('#holdnumber-error').html('');
        }

        function reqprefixval() {
            $('#reqprefix-error').html('');
        }

        function reqnumberval() {
            $('#reqnumber-error').html('');
        }

        function trprefixval() {
            $('#trprefix-error').html('');
        }

        function trnumberval() {
            $('#trnumber-error').html('');
        }

        function issprefixval() {
            $('#issprefix-error').html('');
        }

        function issnumberval() {
            $('#issnumber-error').html('');
        }

        function adjprefixval() {
            $('#adjprefix-error').html('');
        }

        function adjnumberval() {
            $('#adjnumber-error').html('');
        }

        function bgprefixval() {
            $('#bgprefix-error').html('');
        }

        function bgnumberval() {
            $('#bgnumber-error').html('');
        }

        function fiscalyearval() {
            $('#fiscalyear-error').html('');
        }

        function purchasernameval() {
            $('#purchasername-error').html('');
        }

        function trissprefixval() {
            $('#trissprefix-error').html('');
        }

        function trissnumberval() {
            $('#trissnumber-error').html('');
        }
        //Start Image preview
        function previewFile(input) {
            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
                $("#imagepreview").show();
                $("#imageload").hide();
                $('#previewImg').show();
                $('#uplcomplogo').show();
                $('#clearbtndiv').show();
                $('#compLogo').hide();
            }
        }
        //End Image preview
        function addMRC() {
            $('#MrcNumber').val("");
            $('#mname-error').html("");
        }

        function cusNameCV() {
            $('#name-error').html("");
        }

        function cusCodeCV() {
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

        function cusWithDedCV() {
            $('#WitholdDeduct-error').html("");
        }

        function cusPhoneCV() {
            $('#PhoneNumber-error').html("");
        }

        function cusOffPhoneCV() {
            $('#OfficePhoneNumber-error').html("");
        }

        function cusAddressv() {
            $('#Address-error').html("");
        }

        function cusCountryVC() {
            $('#Country-error').html("");
        }

        function removeMrcNameValidation() {
            $('#muname-error').html("");
        }

        function withAmnt() {
            $('#witholdamount-error').html("");
        }

        function customerCodePrefixVal() {
            $('#customercodepr-error').html("");
        }

        function customerCodeNumVal() {
            $('#customercodenum-error').html("");
        }

        function salesWitholdVal() {
            $('#saleswithold-error').html("");
        }

        function salesVatVal() {
            $('#salesvat-error').html("");
        }

        function deadstockprefix() {
            $('#deadstockavd-error').html("");
        }

        function deadstocknumber() {
            $('#deadstocknumber-error').html("");
        }

        function deadstockremprefix() {
            $('#deadstockrem-error').html("");
        }

        function deadstockremnumber() {
            $('#deadstockremnumber-error').html("");
        }
        function itemcodePrefixVal() {
            $('#itemcodeprefix-error').html("");
        }
        function itemcodeNumberVal() {
            $('#itemcodenumber-error').html("");
        }
        function creditlimitstart() {
            $('#creditlimitstart-error').html("");
        }
        function creditlimitend() {
            $('#creditlimitend-error').html("");
        }
        function creditslimitval() {
            $('#creditslimit-error').html("");
        }
        function creditsalesaddval() {
            $('#creditsalesadd-error').html("");
        }
        function minimumperfn() {
            $('#minimumper-error').html("");
        }
        function purchaselimfn() {
            $('#purlimit-error').html("");
        }
        function minpurchasefn() {
            $('#minpurchase-error').html("");
        }
        //Reset Validation Ends

        //Start Open mrc update modal with value
        $('#examplemodal-mrcedit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var mrcnumber = button.data('mrcnumber');
            var status = button.data('status');
            var modal = $(this);
            modal.find('.modal-body #mrcnumber').val(mrcnumber);
            modal.find('.modal-body #status').val(status);
            modal.find('.modal-body #id').val(id);
            $('#muname-error').html("");
            $('#mustatus-error').html("");

        });
        //End Open mrc update modal with value

        //Start Save Mrc
        $('body').on('click', '#savemrcbtn', function() {
            var mc = document.getElementById("mname-error").innerHTML;
            if (mc != "") {
                $('#savemrcbtn').text('Add MRC');
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#SettingForm");
                var formData = registerForm.serialize();
                $('#mname-error').html("");
                $('#mstatus-error').html("");
                $.ajax({
                    url: '/savecompanymrc',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#savemrcbtn').text('Adding...');
                    },
                    success: function(data) {
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
                            toastrMessage('success',"MRC Saved Successfully","Success");
                            $('#MrcNumber').val("");
                            $('#MrcNumber').focus();
                            var oTable = $('#laravel-datatable-crud-mrc').dataTable();
                            oTable.fnDraw(false);
                            $('#laravel-datatable-crud-mrc').DataTable().ajax.reload();
                        }
                    },
                });
            }
        });
        //End Save MRC

        //Start mrc update
        $('body').on('click', '#updatemrcbutton', function() {
            var mc = document.getElementById("muname-error").innerHTML;
            if (mc != "") {
                $('#updatemrcbutton').text('Update');
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var updateForm = $("#updatemrcform");
                var cid = document.forms['updatemrcform'].elements['id'].value;
                var formData = updateForm.serialize();
                $('#muname-error').html("");
                $('#mustatus-error').html("");
                $.ajax({
                    url: '/mrcupdatecompany/' + cid,
                    type: 'GET',
                    data: formData,
                    beforeSend: function() {
                        $('#updatemrcbutton').text('Updating...');
                    },
                    success: function(data) {
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
                            toastrMessage('success',"MRC Updated Successfully","Success");
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
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
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
                url: '/mrccompanydelete/' + cid,
                type: 'DELETE',
                data: '',
                beforeSend: function() {
                    $('#deleteMrcbtn').text('Deleting...');
                },
                success: function(data) {
                    if (data.errors) {
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#deleteMrcbtn').text('Delete');
                        toastrMessage('success',"MRC Removed Successfully","Success");
                        $('#examplemodal-mrcdelete').modal('hide');
                        var oTable = $('#laravel-datatable-crud-mrc').dataTable();
                        oTable.fnDraw(false);
                        $('#laravel-datatable-crud-mrc').DataTable().ajax.reload();
                    }
                }
            })
        });
        //Delete Records Ends

        $('#SettingForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '/savesetting',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#savechange').text('Saving...');
                    $('#savechange').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.SkuNumber) {
                            $('#skunumber-error').html(data.errors.SkuNumber[0]);
                        }
                        if (data.errors.CustomerCodeNumber) {
                            $('#customercodenum-error').html(data.errors.CustomerCodeNumber[0]);
                        }
                        if (data.errors.ReceivingNumber) {
                            $('#recnumber-error').html(data.errors.ReceivingNumber[0]);
                        }
                        if (data.errors.HoldNumber) {
                            $('#holdnumber-error').html(data.errors.HoldNumber[0]);
                        }
                        if (data.errors.RequisitionNumber) {
                            $('#reqnumber-error').html(data.errors.RequisitionNumber[0]);
                        }
                        if (data.errors.TransferNumber) {
                            $('#trnumber-error').html(data.errors.TransferNumber[0]);
                        }
                        if (data.errors.IssueNumber) {
                            $('#issnumber-error').html(data.errors.IssueNumber[0]);
                        }
                        if (data.errors.TransferIssueNumber) {
                            $('#trissnumber-error').html(data.errors.TransferIssueNumber[0]);
                        }
                        if (data.errors.AdjustmentNumber) {
                            $('#adjnumber-error').html(data.errors.AdjustmentNumber[0]);
                        }
                        if (data.errors.BeginingNumber) {
                            $('#bgnumber-error').html(data.errors.BeginingNumber[0]);
                        }
                        if (data.errors.DeadStockAvoidancePrefix) {
                            $('#deadstockavd-error').html(data.errors.DeadStockAvoidancePrefix[0]);
                        }
                        if (data.errors.DeadStockAvoidanceNumber) {
                            $('#deadstocknumber-error').html(data.errors.DeadStockAvoidanceNumber[0]);
                        }
                        if (data.errors.DeadStockRemovalPrefix) {
                            $('#deadstockrem-error').html(data.errors.DeadStockRemovalPrefix[0]);
                        }
                        if (data.errors.DeadStockRemNumber) {
                            $('#deadstockremnumber-error').html(data.errors.DeadStockRemNumber[0]);
                        }
                        if (data.errors.FiscalYear) {
                            $('#fiscalyear-error').html(data.errors.FiscalYear[0]);
                        }
                        if (data.errors.ItemCodeNumber) {
                            $('#itemcodenumber-error').html(data.errors.ItemCodeNumber[0]);
                        }
                        if (data.errors.CreditSalesLimitStart) {
                            var text=data.errors.CreditSalesLimitStart[0];
                            text = text.replace("credit sales limit start", "credit sales minimum amount");
                            $('#creditlimitstart-error').html(text);
                        }
                        if (data.errors.CreditSalesLimitEnd) {
                            var text=data.errors.CreditSalesLimitEnd[0];
                            text = text.replace("credit sales limit end", "credit sales maximum amount");
                            text=text.replace("credit sales limit start", "credit sales minimum amount");
                            $('#creditlimitend-error').html(text);
                        }
                        if (data.errors.CreditSalesLimitDay) {
                            $('#creditslimit-error').html(data.errors.CreditSalesLimitDay[0]);
                        }
                        if (data.errors.CreditSalesAdditionPercentage) {
                            $('#creditsalesadd-error').html(data.errors.CreditSalesAdditionPercentage[0]);
                        }
                        if (data.errors.MinimumPeriod) {
                            $('#minimumper-error').html(data.errors.MinimumPeriod[0]);
                        }
                        if (data.errors.PurchaseLimit) {
                            $('#purlimit-error').html(data.errors.PurchaseLimit[0]);
                        }
                        if (data.errors.MinimumPurchaseAmount) {
                            var text=data.errors.MinimumPurchaseAmount[0];
                            text = text.replace("minimum purchase amount", "first purchase amount");
                            $('#minpurchase-error').html(text);
                        }
                        $('#savechange').text('Save Setting');
                        $('#savechange').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.valerror) {
                        $('#fiscalyear-error').html("Invalid fiscal year selection");
                        $('#savechange').text('Save Setting');
                        $('#savechange').prop("disabled", false);
                        toastrMessage('error',"Fiscal Year cannot be back","Error");
                        $("#issueconmodal").modal('hide');
                        $("#issueform")[0].reset();
                    }
                    if (data.success) {
                        $('#savechange').text('Save Setting');
                        $('#savechange').prop("disabled", false);
                        toastrMessage('success',"Setting Saved","Success");
                    }
                },
            });
        });

        //start checkbox change function
        $(function() {
            $("#customercode").click(function() {
                if ($(this).is(":checked")) {
                    $('#cuscodecheckboxVali').val('1');
                } else {
                    $('#cuscodecheckboxVali').val('0');
                }
            });
        });
        //end checkbox change function

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

        //start checkbox change function
        $(function() {
            $("#settleoutcbx").click(function() {
                if ($(this).is(":checked")) {
                    $('#settleoutstanding').val('1');
                } else {
                    $('#settleoutstanding').val('0');
                }
            });
        });
        //end checkbox change function

        //start checkbox change function
        $(function() {
            $("#itemcode").click(function() {
                if ($(this).is(":checked")) {
                    $('#itemcodeval').val('1');

                } else {
                    $('#itemcodeval').val('0');
                }
            });

            $("#wholesalefeaturecheck").click(function() {
                if ($(this).is(":checked")) {
                    $('#wholesalefeature').val('1');

                } else {
                    $('#wholesalefeature').val('0');
                }
            });

            $("#resetdoc").click(function() {
                if ($(this).is(":checked")) {
                    $('#resetdocval').val('1');

                } else {
                    $('#resetdocval').val('0');
                }
            });
        });
        //end checkbox change function

        $(document).ready(function() {
            var elem = $(".compmrc");
            if (elem) {
                elem.keydown(function() {
                    if (elem.val().length > 9)
                        return false;
                });
            }
        });

        $(document).ready(function() {
            var elem = $("#mrcnumber");
            if (elem) {
                elem.keydown(function() {
                    if (elem.val().length > 9)
                        return false;
                });
            }
        });
        
        //show periods starts
        $('body').on('click', '#showperiodsbtn', function() {
            var fiscalyrhid=$('#fiscalyrhids').val();
            $('#fiscalyrperiod').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            paging:false,
            searching:false,
            info:false,
            "order": [[ 0, "asc" ]],
            "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/showfiscalperiods/'+fiscalyrhid,
                type: 'DELETE',
                },
            columns: [
                { data: 'id', name: 'id','visible': false},
                { data: 'PeriodName', name: 'PeriodName' },
                { data: 'PeriodStartDate', name: 'PeriodStartDate'},
                { data: 'PeriodEndDate', name: 'PeriodEndDate'},
            ],
            });
            $("#periodtable").show();
            $("#openfiscalyear").show();
        });
        //show periods ends

        //start open confirmation modal
        function openfyear(){
            $("#fiscalyearchangemodal").modal('show');
        }
        //end open confirmation modal

        //start open confirmation modal
        function openFiscalYearModal(){
            $("#startdatelbl").html("");
            $("#calendarlbl").html(""); 
            $("#openedfiscalyr").html("");
            $("#numofperlbl").html("");   
            $("#fiscalyeardivtbl").html("");
            $("#numofperiod").val("");
            $("#NumberOfYear").val("");
            $("#showperiodsbtn").hide();
            $("#openewfiscalyear").hide(); 
            $("#resetdocdiv").hide();
            $("#previewfiscalyear").modal('show');
        }
        //end open confirmation modal

        //number of year starts
        function numberofyearval(){
            var numyr=$("#NumberOfYear").val();
            if(parseFloat(numyr)>=1){
                var fy=$("#fiscalyeari").val();
                var total=0;
                var newfy=0;
                var endfy=0;
                var newdis="";
                var today = new Date();
                var dd = today.getDate();
                var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : '0' + (today.getMonth() + 1);
                var yyyy = today.getFullYear();
                var formatedCurrentDate = yyyy + "/" + mm + "/" + dd;
                total=parseFloat(numyr)*12;
                $("#numofperiod").val(total);
                newfy=parseFloat(fy)+1;
                endfy=parseFloat(newfy)+parseFloat(numyr);
                newdis=newfy+"/07/08-"+endfy+"/07/07";
                $("#openedfiscalyr").html("<b>Open Fiscal Year : </b>"+newdis+" <b><i>(Year-02)</i></b>");
                $("#showperiodsbtn").text("Show Periods");
                $("#startdatelbl").html("<b>Start Date : </b>"+formatedCurrentDate);
                $("#calendarlbl").html("<b>Calendar : </b>Ethiopian");
                $("#numofperlbl").html("<b>No. of Periods : </b>"+total);
                var fiscalyearperiod="";
                var fiscalyearoutput="";
                fiscalyearperiod="<table class='table table-bordered table-striped table-hover dt-responsive table mb-0 dataTable no-footer' style='width:100%;'><tr><td><b>Period Name</b></td><td><b>Period Start</b></td><td><b>Period End</b></td></tr>"+
                        "<tr><td>Period-01</td><td>"+newfy+"/07/08</td><td>"+newfy+"/08/06</td></tr>"+
                        "<tr><td>Period-02</td><td>"+newfy+"/08/07</td><td>"+newfy+"/09/10</td></tr>"+
                        "<tr><td>Period-03</td><td>"+newfy+"/09/11</td><td>"+newfy+"/10/10</td></tr>"+
                        "<tr><td>Period-04</td><td>"+newfy+"/10/11</td><td>"+newfy+"/11/09</td></tr>"+
                        "<tr><td>Period-05</td><td>"+newfy+"/11/10</td><td>"+newfy+"/12/09</td></tr>"+
                        "<tr><td>Period-06</td><td>"+newfy+"/12/10</td><td>"+endfy+"/01/08</td></tr>"+
                        "<tr><td>Period-07</td><td>"+endfy+"/01/09</td><td>"+endfy+"/02/07</td></tr>"+
                        "<tr><td>Period-08</td><td>"+endfy+"/02/08</td><td>"+endfy+"/03/09</td></tr>"+
                        "<tr><td>Period-09</td><td>"+endfy+"/03/10</td><td>"+endfy+"/04/08</td></tr>"+
                        "<tr><td>Period-10</td><td>"+endfy+"/04/09</td><td>"+endfy+"/05/08</td></tr>"+
                        "<tr><td>Period-11</td><td>"+endfy+"/05/09</td><td>"+endfy+"/06/07</td></tr>"+
                        "<tr><td>Period-12</td><td>"+endfy+"/06/08</td><td>"+endfy+"/07/07</td></tr>"+
                        "</table>";
                $("#fiscalyeardivtbl").html(fiscalyearperiod);
                $("#openewfiscalyear").show(); 
                $("#resetdocdiv").show(); 
                $("#resetdoc").prop("checked", true);
                $("#resetdocval").val("1"); 
            }
            else{
                $("#startdatelbl").html("");
                $("#calendarlbl").html(""); 
                $("#openedfiscalyr").html("");
                $("#numofperlbl").html("");   
                $("#fiscalyeardivtbl").html("");
                $("#numofperiod").val("");
                $("#showperiodsbtn").hide();
                $("#openewfiscalyear").hide();   
                $("#resetdocdiv").hide(); 
            }       
        }
       
    //Save Records to database starts
    $('body').on('click', '#confirmfybtn', function(){
        var registerForm = $("#changefyform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/changeFiscalYear',
            type:'POST',
            data:formData,
            beforeSend:function(){
                $('#confirmfybtn').text('Changing...');
                $('#confirmfybtn').prop( "disabled", true );
            },
            success:function(data) 
            {
                if(data.recerror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please confirm or void transactions in receivings","Error"); 
                    $("#fiscalyearchangemodal").modal('hide'); 
                }
                if(data.trsrcerror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in transfer","Error");
                    $("#fiscalyearchangemodal").modal('hide');   
                }
                if(data.trdesterror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in transfer","Error");
                    $("#fiscalyearchangemodal").modal('hide'); 
                }
                if(data.reqerror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in requistions","Error");
                    $("#fiscalyearchangemodal").modal('hide');  
                }
                if(data.saleserror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please confirm, void or refund transactions in sales","Error");
                    $("#fiscalyearchangemodal").modal('hide');  
                }
                if(data.beginingerror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please post transactions in begining","Error");
                    $("#fiscalyearchangemodal").modal('hide');  
                }
                if(data.recholderror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in receiving","Error"); 
                    $("#fiscalyearchangemodal").modal('hide'); 
                }
                if(data.salesholderror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in sales","Error");
                    $("#fiscalyearchangemodal").modal('hide'); 
                }
                if(data.timeerror)
                {
                    $('#confirmfybtn').text('Confirm');
                    $('#confirmfybtn').prop( "disabled", false );
                    toastrMessage('error',"You can change fiscal year after</br>"+finalyear,"Error");
                    $("#fiscalyearchangemodal").modal('hide'); 
                }
                if(data.success) {
                    $('#confirmfybtn').text('Confirm');
                    toastrMessage('success',"Successful","Success");
                    $("#fiscalyearchangemodal").modal('hide');
                    location.reload(true);
                }
            },
        });
    });
    //Save records and close modal ends
    
    $(document).ready(function() {
           var table=$('#storemrctables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                language: {
                    search: '',
                    searchPlaceholder: "Search here",
                    
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'p>>",
                    "order": [[ 1, "asc" ]],
                ajax: {
                url: '/storewithmrcset',
                type: 'GET',
                },
                columns: [
                { data:'DT_RowIndex' },
                
                { data: 'Name'  },
                { data: 'mrcNumber' },
                { data: 'fsnumber' },
                { data: 'fiscalcashinvoice' },
                { data: 'fiscalcreditinvoice' },
                { data: 'fiscalvoidtype' },
                { data: 'isincrement' },
                { data: 'id' },
        ],
        columnDefs: [{
            targets:6,
            render: function(data,type,row){
                if(data==1){
                    return "Fs #";
                }
                else if(data==2){
                    return "Invoice #";
                }
                else {
                    return "Not set";
                }
            }
        },
        {
            targets:7,
            render: function(data,type,row){
                if(data==1){
                    return "Not Editable";
                }
                else if(data==0){
                    return "Editable";
                }
                else {
                    return "Unknown";
                }
            }
        },{
            targets:8,
            render: function(data,type,row){
                var editlink ="<a class='btn btn-icon btn-gradient-info btn-sm' onclick='editfsnumber("+data+")' style='color:white;'><i class='fa fa-edit'></i></a>";
                var deletelink="<a class='btn btn-icon btn-gradient-danger btn-sm' onclick='deletefsnumber("+data+")' style='color:white'><i class='fa fa-trash'></i></a>";
                return editlink;
            }
        }]

            });

            var manualtable=$('#manualstoremrctables').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                language: {
                    search: '',
                    searchPlaceholder: "Search here",
                    
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'p>>",
                    "order": [[ 1, "asc" ]],
                ajax: {
                url: '/manualstore',
                type: 'GET',
                },
                columns: [
                { data:'DT_RowIndex' },   
                { data: 'Name'  },
                { data: 'manualcashinvoice' },
                { data: 'manualcreditinvoice' },
                { data: 'isincrement' },
                { data: 'id' },
        ],
        columnDefs: [{
            targets: 4,
            render: function ( data, type, row, meta ) {
                if(data==1){
                    return "Not Editable";
                }
                else {
                    return "Editable";
                }
            }
        },{
            targets: 5,
            render: function ( data, type, row, meta ) {
                var editlink ="<a class='btn btn-icon btn-gradient-info btn-sm' onclick='editmanualnumber("+data+")' style='color:white;'><i class='fa fa-edit'></i></a>";
                var deletelink="<a class='btn btn-icon btn-gradient-danger btn-sm' onclick='deletemanualnumber("+data+")' style='color:white'><i class='fa fa-trash'></i></a>";
                return editlink;
            }
        }]
            });
            
            
        });
//add new code 
        $('#pos').on ('change', function () {
            var store = $('#pos').val()||0;
            var id=$('#storemrcid').val()||0;
            $('#pos-error').html('');
            $("#mrc").empty();
            if(id==0){
                    $.get("getmrcwithstore/"+store, function (data, textStatus, jqXHR) {
                    var mrcno=data.mrc.length;
                    
                    if(mrcno==1){
                    
                        $.each(data.mrc, function (index, value ) {
                            $("#mrc").append('<option selected value="' + value.mrcNumber + '">' + value.mrcNumber + '</option>');
                            $('#mrc').select2();
                        });
                        $('#mrc-error').html('');
                    }
                    else{
                        $.each(data.mrc, function (index, value ) {
                            $("#mrc").append('<option selected value="" disabled></option>');
                            $("#mrc").append('<option value="' + value.mrcNumber + '">' + value.mrcNumber + '</option>');
                            $('#mrc').select2();
                        });
                    }
                });
            }
        });

        function editfsnumber(id){
            $('#storemrcid').val(id);
            $('#mrc').empty();
            $.get("updatefsnumber/"+id, function (data, textStatus, jqXHR) {
                $.each(data.store, function (index, value) { 
                    $('#pos').val(value.store_id).trigger('change');
                    $('#mrc').append('<option selected value="' +value.mrcNumber+ '">' + value.mrcNumber + '</option>');
                    $('#mrc').select2();
                    $('#fsNumber').val(value.fsnumber);
                    $('#editType').val(value.isincrement).trigger('change');
                    $('#fiscalCashInvoiceNumber').val(value.fiscalcashinvoice);
                    $('#fiscalCreditInvoiceNumber').val(value.fiscalcreditinvoice);
                    $('#machinetype').val('fiscal').trigger("change");
                    $('#collapseOne').collapse('show');
                });    
                $.each(data.mainstore, function (index, value) { 
                    var isallowedflag=value.IsAllowedCreditSales;
                    if(isallowedflag=="Allow"){
                        $('#divfiscalcredit').show();
                    }
                    else{
                        $('#divfiscalcredit').hide();
                    }
                });
            });
        }

        $('#mrc').on ('change', function () {
            $('#mrc-error').html('');
        });
        
        $('#pointOfSale').on ('change', function () {
            $('#pointOfSale-error').html('');
        });

        function cf(){
        $('#fsNumber-error').html('');
        }
        function cf1(){
            $('#envoiceNumber-error').html('');
        }

        function cf2(){
            $('#fiscalCashInvoiceNumber-error').html('');
        }

        function cf3(){
            $('#fiscalCreditInvoiceNumber-error').html('');
        }

        function cf4(){
            $('#manulCashInvoiceNumber-error').html('');
        }

        function cf5(){
            $('#manulCreditInvoiceNumber-error').html('');
        }

        function openFyModalFn(){
            $('#resetdocvalfy').val($('#resetdocval').val());
        }
                                                    
        function clearpos(){
            $('#storemrcid').val('');
            $('#fsNumber-error').html('');
            $('#mrc-error').html('');
            $('#pos-error').html('');
            $('#fiscalCashInvoiceNumber-error').html('');
            $('#fiscalCreditInvoiceNumber-error').html('');
            $('#pointOfSale-error').html('');
            $('#manulCashInvoiceNumber-error').html('');
            $('#manulCreditInvoiceNumber-error').html('');
            $('#envoiceNumber-error').html('');
            $('#divfiscalstore').hide();
            $('#divfiscalmrc').hide();
            $('#divfiscalnumber').hide();
            $('#divfiscalcash').hide();
            $('#divfiscalcredit').hide();
            $('#divfiscalvoid').hide();
            $('#divfiscalsave').hide();
            $('#divmanualpos').hide();
            $('#divmanualenvoice').hide();
            $('#divmanualcash').hide();
            $('#divmanulcredit').hide();
            $('#diveditType').hide();
            $('#divmanuleditType').hide();
            $('#divmanualsave').hide();
            $('#machinetype').val(null).trigger("change");
        }

        function clearmanualpos(){
        
        }

        function editmanualnumber(id){
            $.get("editmanualnumber/"+id, function (data, textStatus, jqXHR) {
                $.each(data.store, function (index, value) { 
                    $('#pointOfSale').val(value.id).trigger("change"); 
                    $('#manuleditType').val(value.isincrement).trigger('change');
                    $('#manulCashInvoiceNumber').val(value.manualcashinvoice);
                    $('#manulCreditInvoiceNumber').val(value.manualcreditinvoice);
                    $('#machinetype').val('manual').trigger("change");
                    var isallowedflag=value.IsAllowedCreditSales;
                    if(isallowedflag=="Allow"){
                        $('#divmanulcredit').show();
                    }
                    else{
                        $('#divmanulcredit').hide();
                    }
                    $('#collapseOne').collapse('show');
                });
                
            });
        }

        function deletemanualnumber(id){
            Swal.fire({
                                title: 'Are you sure?',
                                text: "Do you want to delete this data",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Delete',
                                customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-outline-danger ml-1'
                                },
                                buttonsStyling: false
                            }).then(function (result) {
                                if (result.value) {
                                    $.get("deletemanulnumber/"+id, function (data, textStatus, jqXHR) {
                                            if(data.success){
                                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Your data has been deleted.',
                                    customClass: {
                                    confirmButton: 'btn btn-success'
                                    }
                                });
                                        var oTable = $('#manualstoremrctables').dataTable(); 
                                        oTable.fnDraw(false);
                                            }
                                        });
                                
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: 'Cancelled',
                                    text: 'Your imaginary data is safe :)',
                                    icon: 'error',
                                    customClass: {
                                    confirmButton: 'btn btn-success'
                                    }
                                });
                                }
                            });
        }
        
                function deletefsnumber(id){
                                    Swal.fire({
                                title: 'Are you sure?',
                                text: "Do you want to delete this data",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Delete',
                                customClass: {
                                confirmButton: 'btn btn-danger',
                                cancelButton: 'btn btn-outline-danger ml-1'
                                },
                                buttonsStyling: false
                            }).then(function (result) {
                                if (result.value) {
                                    $.get("deletefsnumber/"+id, function (data, textStatus, jqXHR) {
                                            if(data.success){
                                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Your data has been deleted.',
                                    customClass: {
                                    confirmButton: 'btn btn-success'
                                    }
                                });
                                        var oTable = $('#storemrctables').dataTable(); 
                                        oTable.fnDraw(false);
                                            }
                                        });
                                
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                Swal.fire({
                                    title: 'Cancelled',
                                    text: 'Your imaginary data is safe :)',
                                    icon: 'error',
                                    customClass: {
                                    confirmButton: 'btn btn-success'
                                    }
                                });
                                }
                            });
                            
        }
        
        $('#manuleditType').on ('change', function (){
            $('#manuleditType-error').html('');
        });
        $('#editType').on ('change', function (){
            $('#editType-error').html('');
        });
        $('#machinetype').on ('change', function (){
            var type=$('#machinetype').val()||0;
            if(type==="fiscal"){
                $('#divfiscalstore').show();
                $('#divfiscalmrc').show();
                $('#divfiscalnumber').show();
                $('#divfiscalcash').show();
                $('#divfiscalcredit').show();
                $('#divfiscalvoid').show();
                $('#divfiscalsave').show();
                $('#diveditType').show();
                $('#divmanualpos').hide();
                $('#divmanualenvoice').hide();
                $('#divmanualcash').hide();
                $('#divmanulcredit').hide();
                $('#divmanualsave').hide();
                $('#divmanuleditType').hide();
            }
            else if(type==="manual"){
                $('#divfiscalstore').hide();
                $('#divfiscalmrc').hide();
                $('#divfiscalnumber').hide();
                $('#divfiscalcash').hide();
                $('#divfiscalcredit').hide();
                $('#divfiscalvoid').hide();
                $('#divfiscalsave').hide();
                $('#diveditType').hide();
                $('#divmanualpos').show();
                $('#divmanualenvoice').show();
                $('#divmanualcash').show();
                $('#divmanulcredit').show();
                $('#divmanualsave').show();
                $('#divmanuleditType').show();
            }
        });

        $(function () {
            cardSection = $('#card-block');
            cardSection2 = $('#card-block-manual');
        });

        $("#savepos").on('click', function()
        {
            var registerForm = $("#SettingForm");
            var formData = registerForm.serialize();
            $.ajax({
                type: "POST",
                url: "savepos",
                data: formData,
                dataType: "json",
                beforeSend:function(){
                    
                    $('#savepos').prop('disabled',true);
                    $('#loadid').addClass('spinner-border spinner-border-sm');
                    $('#saveid').addClass('sml-25 align-middle').text('Please wait...');
                    cardSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                                
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
                            $('#savepos').prop('disabled',false);
                            $('#loadid').removeClass('spinner-border spinner-border-sm');
                            $('#saveid').text('Save');
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
                    if(response.errors){
                        toastrMessage('error','Wrong Input','Error');
                        if(response.errors.pos){
                            $('#pos-error').html(response.errors.pos[0]);
                        }
                        if(response.errors.mrc){
                            $('#mrc-error').html(response.errors.mrc[0]);
                        }
                        if(response.errors.fsNumber){
                            $('#fsNumber-error').html(response.errors.fsNumber[0]);
                        }
                        
                        if(response.errors.fiscalCashInvoiceNumber){
                            $('#fiscalCashInvoiceNumber-error').html(response.errors.fiscalCashInvoiceNumber[0]);
                        }
                        if(response.errors.fiscalCreditInvoiceNumber){
                            $('#fiscalCreditInvoiceNumber-error').html(response.errors.fiscalCreditInvoiceNumber[0]);
                        }
                        if(response.errors.editType){
                            $('#editType-error').html(response.errors.editType[0]);
                        }
                        
                    }
                    if(response.succees){
                        $('#pos').val(null).trigger('change');
                        $('#mrc').val(null).trigger('change');
                        $('#fsNumber').val('');
                        $('#envoiceNumber').val('');
                        $('#fiscalCashInvoiceNumber').val('');
                        $('#fiscalCreditInvoiceNumber').val('');
                        $('#manulCashInvoiceNumber').val('');
                        $('#manulCreditInvoiceNumber').val('');
                        $('#fiscalVoidType').val(null).trigger('change');
                        $('#collapseOne').collapse('hide');
                        toastrMessage('success','successfully saved','success');
                        var oTable = $('#storemrctables').dataTable(); 
                        oTable.fnDraw(false);
                        
                    }
                }
            });
        });

        $("#savemanualpos").on('click', function(){
            var registerForm = $("#SettingForm");
            var formData = registerForm.serialize();
            $.ajax({
                type: "POST",
                url: "savemanualpos",
                data: formData,
                dataType: "json",
                beforeSend:function(){
                    
                    $('#savemanualpos').prop('disabled',true);
                    $('#manualoadid').addClass('spinner-border spinner-border-sm');
                    $('#manualsaveid').addClass('sml-25 align-middle').text('Please wait...');
                    cardSection2.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                                
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
                        $('#savemanualpos').prop('disabled',false);
                        $('#manualoadid').removeClass('spinner-border spinner-border-sm');
                        $('#manualsaveid').text('Save');
                            cardSection2.block({
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
                    if(response.errors){
                        toastrMessage('error','Wrong Input','Error');
                        if(response.errors.pointOfSale){
                            $('#pointOfSale-error').html(response.errors.pointOfSale[0]);
                        }
                        if(response.errors.manulCashInvoiceNumber){
                            $('#manulCashInvoiceNumber-error').html(response.errors.manulCashInvoiceNumber[0]);
                        }
                        if(response.errors.manulCreditInvoiceNumber){
                            $('#manulCreditInvoiceNumber-error').html(response.errors.manulCreditInvoiceNumber[0]);
                        }
                        if(response.errors.envoiceNumber){
                            $('#envoiceNumber-error').html(response.errors.envoiceNumber[0]);
                        }
                        if(response.errors.manuleditType){
                            $('#manuleditType-error').html(response.errors.manuleditType[0]);
                        }

                    }
                    if(response.succees){
                        $('#pointOfSale').val(null).trigger('change');
                        $('#envoiceNumber').val('');
                        $('#manulCashInvoiceNumber').val('');
                        $('#manulCreditInvoiceNumber').val('');
                        $('#collapseOne').collapse('hide');
                        toastrMessage('success','successfully saved','success');
                        var oTable = $('#manualstoremrctables').dataTable(); 
                        oTable.fnDraw(false);
                    }
                }
            });
        });
    </script>
@endsection
