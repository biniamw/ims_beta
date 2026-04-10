
@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content ">
        <section class="page-blockui" id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">User</h3>
                            @can('User-Add')

                                <button type="button" class="btn btn-gradient-info btn-sm addbutton">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>
                                    @can('User-View')
                                        <table id="laravel-datatable-crud"
                                            class="display table-bordered table-striped table-hover dt-responsive mb-0"
                                            style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th></th>
                                                    <th>Full Name</th>
                                                    <th>User Name</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                    <th>Address</th>
                                                    <th>Gender</th>
                                                    <th>Status</th>
                                                    <th style="width:7%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert"
        style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">User Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <ul class="nav nav-tabs justify-content-end" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="userInfoTab" data-toggle="tab" href="#userinfo"
                                    aria-controls="home-align-end" role="tab" aria-selected="true">User Information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="salesTab" data-toggle="tab" href="#sales"
                                    aria-controls="sales" role="tab" aria-selected="false">Point of Sales & Proforma</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="storeIssueTab" data-toggle="tab" href="#storeissue"
                                    aria-controls="storeissue" role="tab" aria-selected="false">Warehouse & Inventory</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="fitnessSpaTab" data-toggle="tab" href="#fitnesspa"
                                    aria-controls="fitnesspa" role="tab" aria-selected="false">Fitness & Spa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="reportTab" data-toggle="tab" href="#reportTabs"
                                    aria-controls="report" role="tab" aria-selected="false">Report</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="userinfo" aria-labelledby="userinfo" role="tabpanel">
                                <section id="input-mask-wrapper">
                                    <div class="col-md-12">
                                        <div class="divider">
                                            <div class="divider-text">Basic Information</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Full Name</label><label style="color: red; font-size:16px;">*</label>
                                                <input type="hidden" placeholder="customerid" class="form-control"
                                                    name="id" id="id" onkeyup="cusNameCV();" />
                                                <input type="text" placeholder="Full Name" class="form-control"
                                                    name="FullName" id="FullName" onkeyup="NameVal();" />
                                                <span class="text-danger">
                                                    <strong id="name-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">User Name</label><label style="color: red; font-size:16px;">*</label>
                                                <input type="text" placeholder="User Name" class="form-control"
                                                    name="UserName" id="UserName" onkeyup="userNameVal();" />
                                                <span class="text-danger">
                                                    <strong id="uname-error"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Role</label><label style="color: red; font-size:16px;">*</label>
                                                <select class="selectpicker form-control form-control-lg"
                                                    data-live-search="true"
                                                    data-style="btn btn-outline-secondary waves-effect" name="role"
                                                    id="urole" onchange="roleerror();">
                                                    <option disabled selected></option>
                                                    @foreach ($roles as $role)
                                                        <option value='{{ $role }}'>{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="role-error"></strong>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="divider">
                                            <div class="divider-text">Address Information and Other Information</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Phone Number</label>
                                                <input type="text" placeholder="Phone Number" class="form-control"
                                                    name="PhoneNumber" id="PhoneNumber"
                                                    onkeypress="return ValidatePhone(event);" onkeyup="PhoneVal()" />
                                                <span class="text-danger">
                                                    <strong id="PhoneNumber-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Alternate Phone Number</label>
                                                <input type="text" placeholder="Alternate Phone Number"
                                                    class="form-control" name="AlternatePhoneNumber"
                                                    id="AlternatePhoneNumber" onkeypress="return ValidatePhone(event);"
                                                    onkeyup="alternatePhoneVal()" />
                                                <span class="text-danger">
                                                    <strong id="AlternatePhoneNumber-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Email Address</label>
                                                <input type="text" placeholder="Email Address" class="form-control"
                                                    name="EmailAddress" id="EmailAddress" onkeyup="ValidateEmail(this);" />
                                                <span class="text-danger">
                                                    <strong id="email-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Address</label>
                                                <input type="text" placeholder="Address" class="form-control"
                                                    name="Address" id="Address" onkeyup="AddressVal()" />
                                                <span class="text-danger">
                                                    <strong id="Address-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Nationality</label>
                                                <div>
                                                    <select class="selectpicker form-control" data-live-search="true"
                                                        data-style="btn btn-outline-secondary waves-effect"
                                                        name="Nationality" id="Nationality" onchange="nationalityVal()">
                                                        @foreach ($counrtys as $cn)
                                                            <option value="{{ $cn->Name }}">{{ $cn->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="Nationality-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Gender</label><label style="color: red; font-size:16px;">*</label>
                                                <div class="demo-inline-spacing">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio1" name="Gender" class="custom-control-input " value="Male" onclick="genderVal()" />
                                                        <label style="font-size: 14px;" class="custom-control-label" for="customRadio1">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="customRadio2" name="Gender" class="custom-control-input" value="Female" onclick="genderVal()" />
                                                        <label style="font-size: 14px;" class="custom-control-label" for="customRadio2" >Female</label>
                                                    </div>
                                                </div>

                                                <span class="text-danger">
                                                    <strong id="Gender-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Status</label>
                                                <div class="input-group input-group-merge">
                                                    <select class="form-control" name="Status" id="ActiveStatus"
                                                        aria-errormessage="Select Status" onchange="statusVal()">
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="status-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane" id="sales" aria-labelledby="sales" role="tabpanel">
                                <section id="input-mask-wrapper">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Sales Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Point of Sale</label>
                                                <div>
                                                    <select class="select2 form-control salesstr" name="SalesStore[]" id="SalesStore" multiple="multiple">
                                                        <option value="" disabled></option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="salesstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">MRC Numbers</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select MRC Numbers</label>
                                                <div>
                                                    <select class="select2 form-control" name="MrcNumber[]" id="MrcNumber" onchange="mrcnumbersVal()" multiple="multiple">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="mrcnumber-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Proforma Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Proforma Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="ProformaStore[]"
                                                        id="ProformaStore" onchange="proformastoreVal()"
                                                        multiple="multiple">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="proformastore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane" id="fitnesspa" aria-labelledby="fitnesspa" role="tabpanel">
                                <section id="input-mask-wrapper">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Fitness & Spa Shop/Outlet</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Point of Sale</label>
                                                <div>
                                                    <select class="select2 form-control fitnesspa" name="FitnessSpa[]" id="FitnessSpa" multiple="multiple">
                                                        <option value="" disabled></option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="fitnesspa-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                <div class="divider">
                                                    <div class="divider-text">MRC Numbers</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select MRC Numbers</label>
                                                <div>
                                                    <select class="select2 form-control" name="MrcNumberFitness[]" id="MrcNumberFitness" onchange="mrcnumbersFitnessVal()" multiple="multiple">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="mrcnumberfitness-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane" id="storeissue" aria-labelledby="storeissue" role="tabpanel">
                                <section id="input-mask-wrapper">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Receiving Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Recieving Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="receivingstore[]"
                                                        id="receivingstore" onchange="receivingstoreVal()"
                                                        multiple="multiple">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="receivingstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Requisition Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Requisition Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="reqstore[]" id="reqstore" onchange="reqstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="reqstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider">
                                            <div class="divider-text">Transfer Store/Shop</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Select Transfer Source Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="trsrcstore[]" id="trsrcstore" onchange="trsrcstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="trsrcstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Select Transfer Destination Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="trdesstore[]" id="trdesstore" onchange="trdesstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="trdesstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Approver Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Approver Store/Shop <i>(Source)</i></label>
                                                <div>
                                                    <select class="select2 form-control" name="ApproverStore[]" id="ApproverStore" onchange="approverstoreVal()" multiple="multiple">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="approverstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Issue Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Issue Store/Shop <i>(Source)</i></label>
                                                <div>
                                                    <select class="select2 form-control" name="issuestore[]" id="issuestore" onchange="issuestoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="issuestore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Transfer Receive Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Transfer Receive Store/Shop <i>(Destination)</i></label>
                                                <div>
                                                    <select class="select2 form-control" name="TransferReceiveStore[]" id="TransferReceiveStore" onchange="transferrecstoreVal()" multiple="multiple">
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="transferrecstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Adjustment Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Adjustment Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="adjstore[]" id="adjstore" onchange="adjstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="adjstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Beginning Store/Shop</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Beginning Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="begstore[]" id="begstore" onchange="begstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="begstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Stock Balance</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Stock Balance Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="storebalacestore[]" id="storebalacestore" onchange="storebalacestoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="storebalance-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">-</div>
                                                </div>
                                                <div class="form-check form-check-inline" id="purchaserdiv">
                                                    <label class="form-check-label" style="font-size: 14px;"
                                                        for="purchaser">Is Purchaser :</label>
                                                    <input class="form-check-input" name="purchaser" type="checkbox"
                                                        id="purchaser" />
                                                    <input type="hidden" placeholder="" class="form-control"
                                                        name="checkboxVali" id="checkboxVali" readonly="true" value="0" />
                                                    <span class="text-danger">
                                                        <strong id="purchaser-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane" id="reportTabs" aria-labelledby="reportTab" role="tabpanel">
                                <section id="input-mask-wrapper">
                                    <div class="col-md-12">
                                       <div class="row">
                                           <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Sales Report Access Store</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Sales Report Store</label>
                                                <div>
                                                    <select class="select2 form-control" name="salesrepstore[]" id="salesrepstore" onchange="salesrepstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="salesrepstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Purchase Report Access Store</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Purchase Report Store</label>
                                                <div>
                                                    <select class="select2 form-control" name="purchaserepstore[]" id="purchaserepstore" onchange="purchaserepstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="purchaserepstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                <div class="divider">
                                                    <div class="divider-text">Financial Report Access Store</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Financial Report Store</label>
                                                <div>
                                                    <select class="select2 form-control" name="financialstore[]" id="financialstore" onchange="financialstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="financialstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <div class="divider">
                                                    <div class="divider-text">Inventory Report Access Store</div>
                                                </div>
                                                <label strong style="font-size: 14px;">Select Inventory Report Store</label>
                                                <div>
                                                    <select class="select2 form-control" name="inventoryrepstore[]" id="inventoryrepstore" onchange="inventoryrepstoreVal()" multiple="multiple"></select>
                                                    <span class="text-danger">
                                                        <strong id="inventoryrepstore-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="userRecId" id="userRecId" readonly="true" /></label>
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true" /></label>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="userInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">User Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="userInfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Basic Information</h6>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="reload" onclick="refreshUserInfoVal()"><i
                                                                data-feather="rotate-cw"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Full Name</label></td>
                                                            <td><label id="infoName" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">User Name</label></td>
                                                            <td><label id="infoUName" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Role</label></td>
                                                            <td><label id="infoRoleName" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Phone Number</label></td>
                                                            <td><label id="infophoneno" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Alternate Phone</label></td>
                                                            <td><label id="infoaltphone" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Email Address</label></td>
                                                            <td><label id="infoemailaddress" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Address</label></td>
                                                            <td><label id="infoaddress" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Nationality</label></td>
                                                            <td><label id="infonationality" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Gender</label></td>
                                                            <td><label id="infogender" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 14px;">Status</label></td>
                                                            <td><label id="infostatus" strong style="font-size: 14px;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-6 col-sm-12 mb-2">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Point of Sales & Proforma</h6>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li>
                                                                    <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a data-action="reload" onclick="refreshSalesVal()"><i
                                                                            data-feather="rotate-cw"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table>
                                                                    <tr>
                                                                        <td style="width: 12%;">
                                                                            <label strong style="font-size: 14px;">Point of Sales</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="poslbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label strong style="font-size: 14px;">MRC</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="mrclbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label strong style="font-size: 14px;">Proforma Store/Shop</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="proformalbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <table style="width: 100%;display:none;">
                                                                    <tr>
                                                                        <td style="width:33%;">
                                                                            <table id="salesstoreTable"
                                                                                class="table table-bordered table-striped table-hover dt-responsive table mb-0 text-center">
                                                                                <thead>
                                                                                    <th>Sales Store</th>
                                                                                </thead>
                                                                            </table>
                                                                        </td>
                                                                        <td style="width:33%;">
                                                                            <table id="mrcsTable"
                                                                                class="table table-bordered table-striped table-hover dt-responsive table mb-0 text-center">
                                                                                <thead>
                                                                                    <th>MRC Number</th>
                                                                                </thead>
                                                                            </table>
                                                                        </td>
                                                                        <td style="width:33%;">
                                                                            <table id="proformaTable"
                                                                                class="table table-bordered table-striped table-hover dt-responsive table mb-0 text-center">
                                                                                <thead>
                                                                                    <th>Proforma Store/Shop</th>
                                                                                </thead>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Warehouse & Inventory</h6>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li>
                                                                    <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a data-action="reload" onclick="refreshApproverVal()"><i
                                                                            data-feather="rotate-cw"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <table>
                                                                <tr>
                                                                    <td style="width: 25%;">
                                                                        <label strong style="font-size: 14px;">Receiving Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="reclbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Requisition Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="reqlbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Transfer Source Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="trsrclbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Transfer Destination Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="trdestlbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Transfer Receive Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="trreceivelbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Approver Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="applbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Issue Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="isslbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Adjustment Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="adjlbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Beginning Store/Shop</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="beglbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Stock Balance</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="strbalancelbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <label strong style="font-size: 14px;">Is Purchaser</label>
                                                                    </td>
                                                                    <td>
                                                                        <label id="purchaserInfoLbl" strong style="font-size: 14px;font-style:italic;font-weight:bold;"></label>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <div class="text-center" style="display: none;">
                                                                <table id="approverTable" style="display: none;" class="table table-bordered table-striped table-hover dt-responsive table mb-0 text-center">
                                                                    <thead>
                                                                        <th>Approver Store</th>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Fitness & Spa</h6>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li>
                                                                    <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a data-action="reload" onclick="refreshSalesVal()"><i data-feather="rotate-cw"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table>
                                                                    <tr>
                                                                        <td style="width: 25%;">
                                                                            <label strong style="font-size: 14px;">Fitnes & Spa Shop/Outlet</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="fitnesspalbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Report Access</h6>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline mb-0">
                                                                <li>
                                                                    <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                                </li>
                                                                <li>
                                                                    <a data-action="reload" onclick="refreshSalesVal()"><i data-feather="rotate-cw"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table>
                                                                    <tr>
                                                                        <td style="width: 25%;">
                                                                            <label strong style="font-size: 14px;">Sales Report Store/Shop</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="salesreplbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label strong style="font-size: 14px;">Purchase Report Store/Shop</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="purchasereplbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr style="display: none;">
                                                                        <td>
                                                                            <label strong style="font-size: 14px;">Financial Report Store/Shop</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="financialreplbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <label strong style="font-size: 14px;">Inventory Report Store/Shop</label>
                                                                        </td>
                                                                        <td>
                                                                            <label id="inventoryreplbl" style="font-size: 14px;font-weight:bold;"></label>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>  
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                    <div class="card" style="display:none;">
                                        <div class="card-header">
                                            <h6 class="card-title">Warehouse & Inventory</h6>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="reload" onclick="refreshReceivingVal()"><i
                                                                data-feather="rotate-cw"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="text-center">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 50%;">
                                                                <table id="receivingTable"
                                                                    class="table table-bordered table-striped table-hover dt-responsive table mb-0 text-center">
                                                                    <thead>
                                                                        <th>Receiving Store</th>
                                                                    </thead>
                                                                </table>
                                                            </td>
                                                            <td style="width: 50%;">
                                                                <table id="issueTable"
                                                                    class="table table-bordered table-striped table-hover dt-responsive table mb-0 text-center">
                                                                    <thead>
                                                                        <th>Issue Store</th>
                                                                    </thead>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="divider">
                                                                    <div class="divider-text"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                
                                                                
                                                            </td>
                                                            <td></td>
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
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="infoUserId" id="infoUserId"
                            readonly="true">
                        <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Start Reset modal -->
    <div class="modal fade text-left" id="resetpass" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="resetpassform">
                    @csrf
                    <div class="modal-body">
                        <label strong style="font-size: 16px;">Are you sure you want to Reset Password</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="resetUserId" id="resetUserId"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="resetpassbtn" type="button" class="btn btn-info">Reset</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Reset modal -->

    <script type="text/javascript">
        //Start page load event
        var selectedOption;
        $(function () {
            cardSection = $('#page-block');
        });

        $('#SalesStore').on('change', function () {
            var store=$('#SalesStore').val();
            var recIdVar = $("#userRecId").val();
            if(recIdVar!='' && store!=''){
                    $.ajax({
                    type: "GET",
                    url: "{{ url('getAssignedMrc') }}/"+store+"/"+recIdVar,
                    data: "",
                    dataType: "json",
                    success: function (response) {
                        $.each(response.mrc, function (index, value) {
                            var isExist = !!$('#MrcNumber option').filter(function() {
                                return parseInt($(this).attr('value')) == value.storemrc_id;
                            }).length;
                            if (!isExist) {
                            $('<option selected>').val(value.storemrc_id).text(value.mrcNumber).appendTo($('#MrcNumber'));
                            }
                        });
                    }
                });
            }

            if(store!=''){
                $.get("getstoresmrc/"+store, function (data, textStatus, jqXHR) {
                    $.each(data.storemrc, function (index, value) {
                        var st=value.id;
                        var isExist = !!$('#MrcNumber option').filter(function() {
                            return parseInt($(this).attr('value')) == value.id;
                        }).length;
                        if (!isExist) {
                            $('<option>').val(value.id).text(value.mrcNumber).appendTo($('#MrcNumber'));
                        }
                    });
                });
            }
            $('#salesstore-error').html("");
        });

        $('#FitnessSpa').on('change', function () {
            var store=$('#FitnessSpa').val();
            var recIdVar = $("#userRecId").val();
            if(recIdVar!='' && store!=''){
                    $.ajax({
                    type: "GET",
                    url: "{{ url('getAssignedMrcFt') }}/"+store+"/"+recIdVar,
                    data: "",
                    dataType: "json",
                    success: function (response) {
                        $.each(response.mrc, function (index, value) {
                            var isExist = !!$('#MrcNumberFitness option').filter(function() {
                                return parseInt($(this).attr('value')) == value.storemrc_id;
                            }).length;
                            if (!isExist) {
                            $('<option selected>').val(value.storemrc_id).text(value.mrcNumber).appendTo($('#MrcNumberFitness'));
                            }
                        });
                    }
                });
            }

            if(store!=''){
                $.get("getstoresmrcft/"+store, function (data, textStatus, jqXHR) {
                    $.each(data.storemrc, function (index, value) {
                        var st=value.id;
                        var isExist = !!$('#MrcNumberFitness option').filter(function() {
                            return parseInt($(this).attr('value')) == value.id;
                        }).length;
                        if (!isExist) {
                            $('<option>').val(value.id).text(value.mrcNumber).appendTo($('#MrcNumberFitness'));
                        }
                    });
                });
            }
            $('#fitnesspa-error').html("");
        });

        $('#MrcNumber').on ('change', function () {
            
        });

        $(document).ready(function() {
           var table= $('#laravel-datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                "lengthMenu": [50,100],
                "order": [
                    [1, "desc"]
                ],
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
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/userdata',
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
                columns: [
                    { data: 'DT_RowIndex'},
                    {
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'FullName',
                        name: 'FullName'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'RoleName',
                        name: 'RoleName'
                    },
                    {
                        data: 'Address',
                        name: 'Address',
                        'visible': false
                    },
                    {
                        data: 'Gender',
                        name: 'Gender',
                        'visible': false
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Active") {
                        $(nRow).find('td:eq(5)').css({
                            "color": "#4CAF50",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #4CAF50"
                        });
                    } else if (aData.Status == "Inactive") {
                        $(nRow).find('td:eq(5)').css({
                            "color": "#f44336",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #f44336"
                        });
                    }
                }
            });
            table.on('draw', function () {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());
        });
            $.fn.dataTable.ext.errMode = 'throw';
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        });

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        //Start get user number value
        $('body').on('click', '.addbutton', function() {
            $("#inlineForm").modal('show');
            $('#userRecId').val('');
            $.get("/getUserNumber", function(data) {
                var dbval = data.usercnt;
                var rnum = (Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
                $('#commonVal').val(rnum + dbval);
            });
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var uid = "0";

            $.ajax({
                url: 'getRec/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['receivingStr'].length;
                    $.each(data.receivingStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;

                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#receivingstore").append(option);

                    }); 
                },
            });

            $.ajax({
                url: 'getIssue/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['issueStr'].length;
                    $.each(data.issueStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#issuestore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getStoreB/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['storeBalances'].length;
                    $.each(data.storeBalances, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#storebalacestore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getStoreR/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['reqstr'].length;
                    $.each(data.reqstr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#reqstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getStoreTrS/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['trsrc'].length;
                    $.each(data.trsrc, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#trsrcstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getStoreTrD/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['trdes'].length;
                    $.each(data.trdes, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#trdesstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getStoreAd/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['adj'].length;
                    $.each(data.adj, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#adjstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getStoreBeg/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['beg'].length;
                    $.each(data.beg, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#begstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getApprover/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['approveStr'].length;
                    $.each(data.approveStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#ApproverStore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getTransferRec/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['transferrec'].length;
                    $.each(data.transferrec, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#TransferReceiveStore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getSales/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['salesStr'].length;
                    $.each(data.salesStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#SalesStore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getFitness/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['salesStr'].length;
                    $.each(data.salesStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#FitnessSpa").append(option);
                    });
                },
            });
           
            $.ajax({
                url: 'getProforma/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['proformaNum'].length;
                    $.each(data.proformaNum, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#ProformaStore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getSalesRep/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['salesrp'].length;
                    $.each(data.salesrp, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#salesrepstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getPurRep/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['purrp'].length;
                    $.each(data.purrp, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#purchaserepstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getInvRep/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['invrp'].length;
                    $.each(data.invrp, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#inventoryrepstore").append(option);
                    });
                },
            });

            $.ajax({
                url: 'getFinRep/' + uid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['finrp'].length;
                    $.each(data.finrp, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#financialstore").append(option);
                    });
                },
            });

            $("#UserName").prop("disabled", false);
            $('#SalesStore').select2();
            $('#FitnessSpa').select2();
            $('#issuestore').select2();
            $('#MrcNumber').select2();
            $('#ProformaStore').select2();
            $('#receivingstore').select2();
            $('#ApproverStore').select2();
            $('#storebalacestore').select2();
            $('#reqstore').select2();
            $('#trsrcstore').select2();
            $('#trdesstore').select2();
            $('#adjstore').select2();
            $('#begstore').select2();
            $('#salesrepstore').select2();
            $('#purchaserepstore').select2();
            $('#inventoryrepstore').select2();
            $('#TransferReceiveStore').select2();
            $('#financialstore').select2();
            $('.nav-tabs a[href="#userinfo"]').tab('show');
        });
        //End get user number value

        function roleerror() {
            $('#role-error').html("");
        }

        function NameVal() {
            $('#name-error').html("");
        }

        function userNameVal() {
            $('#uname-error').html("");
        }

        function PhoneVal() {
            $('#PhoneNumber-error').html("");
        }

        function alternatePhoneVal() {
            $('#AlternatePhoneNumber-error').html("");
        }

        function AddressVal() {
            $('#Address-error').html("");
        }

        function nationalityVal() {
            $('#Nationality-error').html("");
        }

        function genderVal() {
            $('#Gender-error').html("");
        }

        function statusVal() {
            $('#status-error').html("");
        }

        function receivingstoreVal() {
            $('#receivingstore-error').html("");
        }

        function mrcnumbersVal() {
            $('#mrcnumber-error').html("");
        }

        function mrcnumbersFitnessVal() {
            $('#mrcnumberfitness-error').html("");
        }

        function proformastoreVal() {
            $('#proformastore-error').html("");
        }

        function purchaserVal() {
            $('#purchaser-error').html("");
        }

        function transferrecstoreVal() {
            $('#transferrecstore-error').html("");
        }

        function approverstoreVal() {
            $('#approverstore-error').html("");
        }

        function issuestoreVal() {
            $('#issuestore-error').html("");
        }

        function storebalacestoreVal() {
            $('#storebalance-error').html("");
        }

        function reqstoreVal() {
            $('#reqstore-error').html("");
        }

        function trsrcstoreVal() {
            $('#trsrcstore-error').html("");
        }

        function trdesstoreVal() {
            $('#trdesstore-error').html("");
        }

        function adjstoreVal() {
            $('#adjstore-error').html("");
        }

        function begstoreVal() {
            $('#begstore-error').html("");
        }

        function salesrepstoreVal() {
            $('#salesrepstore-error').html("");
        }

        function purchaserepstoreVal() {
            $('#purchaserepstore-error').html("");
        }

        function inventoryrepstoreVal() {
            $('#inventoryrepstore-error').html("");
        }

        function financialstoreVal() {
            $('#financialstore-error').html("");
        }

        function closeModalWithClearValidation() {
            $('#email-error').html("");
            $('#name-error').html("");
            $('#uname-error').html("");
            $('#role-error').html("");
            $('#PhoneNumber-error').html("");
            $('#AlternatePhoneNumber-error').html("");
            $('#Address-error').html("");
            $('#Nationality-error').html("");
            $('#Gender-error').html("");
            $('#status-error').html("");
            $('#receivingstore-error').html("");
            $('#salesstore-error').html("");
            $('#fitnesspa-error').html("");
            $('#mrcnumber-error').html("");
            $('#purchaser-error').html("");
            $('#proformastore-error').html("");
            $('#financialstore-error').html("");
            $('#Nationality').val(null).trigger('change');
            $('#issuestore').val(null).trigger('change');
            $('#SalesStore').val(null).trigger('change');
            $('#FitnessSpa').val(null).trigger('change');
            $('#ProformaStore').val(null).trigger('change');
            $('#MrcNumber').val(null).trigger('change');
            $('#receivingstore').val(null).trigger('change');
            $('#ApproverStore').val(null).trigger('change');
            $('#TransferReceiveStore').val(null).trigger('change');
            $('#storebalacestore').val(null).trigger('change');
            $('#reqstore').val(null).trigger('change');
            $('#trsrcstore').val(null).trigger('change');
            $('#trdesstore').val(null).trigger('change');
            $('#adjstore').val(null).trigger('change');
            $('#begstore').val(null).trigger('change');
            $('#salesrepstore').val(null).trigger('change');
            $('#purchaserepstore').val(null).trigger('change');
            $('#inventoryrepstore').val(null).trigger('change');
            $('#financialstore').val(null).trigger('change');
            $('#urole').val(null).trigger('change');
            $("#Register")[0].reset();
            $('#SalesStore').empty();
            $('#FitnessSpa').empty();
            $('#ProformaStore').empty();
            $('#issuestore').empty();
            $('#MrcNumber').empty();
            $('#receivingstore').empty();
            $('#ApproverStore').empty();
            $('#TransferReceiveStore').empty();
            $('#storebalacestore').empty();
            $('#reqstore').empty();
            $('#trsrcstore').empty();
            $('#trdesstore').empty();
            $('#adjstore').empty();
            $('#begstore').empty();
            $('#salesrepstore').empty();
            $('#purchaserepstore').empty();
            $('#inventoryrepstore').empty();
            $('#financialstore').empty();
            $("#UserName").prop("disabled", false);
        }

        //Start Save records and close
        $('body').on('click', '#savebutton', function() {
            var em = document.getElementById("email-error").innerHTML;
            //alert($("#MrcNumber").val());
            if (em != "") {
                toastrMessage('error','Check Your Inputs','Error');
            } else {
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/saveUsers',
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
                        $('#savebutton').prop("disabled", false);
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
                            if (data.errors.FullName) {
                                $('#name-error').html(data.errors.FullName[0]);
                            }
                            if (data.errors.UserName) {
                                $('#uname-error').html(data.errors.UserName[0]);
                            }
                            if (data.errors.PhoneNumber) {
                                $('#PhoneNumber-error').html(data.errors.PhoneNumber[0]);
                            }
                            if (data.errors.AlternatePhoneNumber) {
                                $('#AlternatePhoneNumber-error').html(data.errors.AlternatePhoneNumber[
                                    0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#email-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#Address-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Nationality) {
                                $('#Nationality-error').html(data.errors.Nationality[0]);
                            }
                            if (data.errors.Gender) {
                                $('#Gender-error').html(data.errors.Gender[0]);
                            }
                            if (data.errors.Status) {
                                $('#status-error').html(data.errors.Status[0]);
                            }
                            if (data.errors.role) {
                                $('#role-error').html(data.errors.role[0]);
                            }
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                            toastrMessage('error','Check Your Inputs','Error');
                            $("#userInfoTab").tab('show');
                        }
                        if (data.success) {
                            $('#savebutton').text('Save');
                            toastrMessage('success','Successfully Saved','Success');
                            $("#inlineForm").modal('hide');
                            $("#Register")[0].reset();
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            $('#laravel-datatable-crud').DataTable().ajax.reload();
                            $('#Nationality').val(null).trigger('change');
                            closeModalWithClearValidation();
                        }
                    },
                });
            }
        });
        //End Save records and close

        //start checkbox change function
        $(function() {
            $("#purchaser").click(function() {
                if ($(this).is(":checked")) {
                    $('#checkboxVali').val('1');

                } else {
                    $('#checkboxVali').val('0');
                }
            });
        });
        //end checkbox change function

        //edit modal open
        $('body').on('click', '.editUserInfo', function() {
            var recIdVar = $(this).data('id');
            $("#userRecId").val(recIdVar);
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $.get("/useredit" + '/' + recIdVar, function(data) {
                var len = data['userdata'].length;
                $.each(data.userdata, function (index, value) {
                    $('#FullName').val(value.FullName);
                    $('#UserName').val(value.username);
                    $('#urole').selectpicker('val', value.RoleName).trigger('change');
                    $('#Nationality').selectpicker('val', value.Nationality);
                    $('#PhoneNumber').val(value.phone);
                    $('#AlternatePhoneNumber').val(value.AlternatePhone);
                    $('#EmailAddress').val(value.email);
                    $('#Address').val(value.Address);
                    // $('#Gender').val(value.Gender);
                    $('#ActiveStatus').val(value.Status);
                    $('#checkboxVali').val(value.IsPurchaser);
                    var pr = value.IsPurchaser;
                    var gender=value.Gender;
                    if(gender=="Male"){
                        $("#customRadio1").prop("checked", true);
                        $("#customRadio2").prop("checked", false);
                    }
                    if(gender=="Female"){
                        $("#customRadio1").prop("checked", false);
                        $("#customRadio2").prop("checked", true);
                    }
                    if (pr == 0) {
                        $("#purchaser").prop("checked", false);
                    }
                    if (pr == 1) {
                        $("#purchaser").prop("checked", true);
                    }

                });
                
            });
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: 'getRec/' + recIdVar,
                type: 'DELETE',
                data: formData,
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
                success: function(data) {
                    var len = data['receivingStr'].length;
                    $.each(data.receivingStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename= value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#receivingstore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#receivingstore").append(option);
                        }
                    });
                },
            });
         
            $.ajax({
                url: 'getIssue/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['issueStr'].length;
                    $.each(data.issueStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#issuestore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#issuestore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getStoreB/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['storeBalances'].length;
                    $.each(data.storeBalances, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#storebalacestore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#storebalacestore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getStoreR/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['reqstr'].length;
                    $.each(data.reqstr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#reqstore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#reqstore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getStoreTrS/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['trsrc'].length;
                    $.each(data.trsrc, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#trsrcstore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#trsrcstore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getStoreTrD/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['trdes'].length;
                    $.each(data.trdes, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#trdesstore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#trdesstore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getStoreAd/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['adj'].length;
                    $.each(data.adj, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#adjstore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#adjstore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getStoreBeg/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['beg'].length;
                    $.each(data.beg, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#begstore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#begstore").append(option);
                        }
                    });
                },
            });

            $.ajax({
                url: 'getApprover/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['approveStr'].length;
                    $.each(data.approveStr, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#ApproverStore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#ApproverStore").append(option);
                        }

                    });
                },
            });

            $.ajax({
                url: 'getTransferRec/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['transferrec'].length;
                    $.each(data.transferrec, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#TransferReceiveStore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#TransferReceiveStore").append(option);
                        }

                    });
                },
            });

            $.ajax({
                url: 'getSales/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    $.each(data.salesStr, function (index, value) {
                        var tablename = value.TableName;
                        if(tablename=="StoreAss"){
                            var option = "<option selected value='" + value.id + "'>" + value.Name + "</option>";
                            $("#SalesStore").append(option);
                        }
                        if(tablename=="Store"){
                            var options = "<option value='" + value.id + "'>" + value.Name + "</option>";
                            $("#SalesStore").append(options);
                        }
                    });
                    $("#SalesStore").select2().trigger("change");
                },
            });

            $.ajax({
                url: 'getFitness/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    $.each(data.salesStr, function (index, value) {
                        var tablename = value.TableName;
                        if(tablename=="StoreAss"){
                            var option = "<option selected value='" + value.id + "'>" + value.Name + "</option>";
                            $("#FitnessSpa").append(option);
                        }
                        if(tablename=="Store"){
                            var options = "<option value='" + value.id + "'>" + value.Name + "</option>";
                            $("#FitnessSpa").append(options);
                        }
                    });
                    $("#FitnessSpa").select2().trigger("change");
                },
            });

            $.ajax({
                url: 'getProforma/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['proformaNum'].length;
                    $.each(data.proformaNum, function (index, value) {
                        var name=value.Name;
                        var id=value.id;
                        var tablename=value.TableName;
                        if (tablename == "StoreAss") {
                            var option = "<option selected value='" + id + "'>" + name + "</option>";
                            $("#ProformaStore").append(option);
                        }
                        if (tablename == "Store") {
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#ProformaStore").append(option);
                        }

                    });
                },
            });

            $.ajax({
                url: 'getSalesRep/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    $.each(data.salesrp, function (index, value) {
                        var tablename = value.TableName;
                        if(tablename=="StoreAss"){
                            var option = "<option selected value='" + value.id + "'>" + value.Name + "</option>";
                            $("#salesrepstore").append(option);
                        }
                        if(tablename=="Store"){
                            var options = "<option value='" + value.id + "'>" + value.Name + "</option>";
                            $("#salesrepstore").append(options);
                        }
                    });
                    $("#salesrepstore").select2().trigger("change");
                },
            });

            $.ajax({
                url: 'getPurRep/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    $.each(data.purrp, function (index, value) {
                        var tablename = value.TableName;
                        if(tablename=="StoreAss"){
                            var option = "<option selected value='" + value.id + "'>" + value.Name + "</option>";
                            $("#purchaserepstore").append(option);
                        }
                        if(tablename=="Store"){
                            var options = "<option value='" + value.id + "'>" + value.Name + "</option>";
                            $("#purchaserepstore").append(options);
                        }
                    });
                    $("#purchaserepstore").select2().trigger("change");
                },
            });

            $.ajax({
                url: 'getInvRep/' + recIdVar,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    $.each(data.invrp, function (index, value) {
                        var tablename = value.TableName;
                        if(tablename=="StoreAss"){
                            var option = "<option selected value='" + value.id + "'>" + value.Name + "</option>";
                            $("#inventoryrepstore").append(option);
                        }
                        if(tablename=="Store"){
                            var options = "<option value='" + value.id + "'>" + value.Name + "</option>";
                            $("#inventoryrepstore").append(options);
                        }
                    });
                    $("#inventoryrepstore").select2().trigger("change");
                },
            });

            $.ajax({
                url: 'getFinRep/' + recIdVar,
                type: 'DELETE',
                data: formData,
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
                    $.each(data.finrp, function (index, value) {
                        var tablename = value.TableName;
                        if(tablename=="StoreAss"){
                            var option = "<option selected value='" + value.id + "'>" + value.Name + "</option>";
                            $("#financialstore").append(option);
                        }
                        if(tablename=="Store"){
                            var options = "<option value='" + value.id + "'>" + value.Name + "</option>";
                            $("#financialstore").append(options);
                        }
                    });
                    $("#financialstore").select2().trigger("change");
                },
            });

            $("#UserName").prop("disabled", true);
            $('#SalesStore').select2();
            $('#FitnessSpa').select2();
            $('#ProformaStore').select2();
            $('#issuestore').select2();
           // $('#MrcNumber').select2();
            $('#receivingstore').select2();
            $('#ApproverStore').select2();
            $('#storebalacestore').select2();
            $('#reqstore').select2();
            $('#trsrcstore').select2();
            $('#trdesstore').select2();
            $('#adjstore').select2();
            $('#begstore').select2();
            $('#salesrepstore').select2();
            $('#purchaserepstore').select2();
            $('#inventoryrepstore').select2();
            $('#TransferReceiveStore').select2();
            $('#financialstore').select2();
            $('.nav-tabs a[href="#userinfo"]').tab('show');
            $("#inlineForm").modal('show');
        });
        //end edit modal open

        //start Info Modal
        $(document).on('click', '.DocUserInfo', function() {
            var recordId = $(this).data('id');
            var rolename = $(this).data('role');
            $('#infoUserId').val(recordId);
            $.get("/useredit" + '/' + recordId, function(data) {
                var len = data['userdata'].length;
                $.each(data.userdata, function (index, value) {
                    $('#infoName').text(value.FullName);
                    $('#infoUName').text(value.username);
                    $('#infoRoleName').text(value.RoleName);
                    $('#infophoneno').text(value.phone);
                    $('#infoaltphone').text(value.AlternatePhone);
                    $('#infoemailaddress').text(value.email);
                    $('#infoaddress').text(value.Address);
                    $('#infonationality').text(value.Nationality);
                    $('#infogender').text(value.Gender);
                    var status = value.Status;
                    if (status === "Active") {
                        $('#infostatus').html(
                            "<label class='badge badge-success' strong style='font-size: 14px;'>" +
                            value.Status + "</label>");
                    }
                    if (status === "Inactive") {
                        $('#infostatus').html(
                            "<label class='badge badge-danger' strong style='font-size: 14px;'>" +
                            value.Status + "</label>");
                    }
                    var purchaser = value.IsPurchaser;
                    if (purchaser == 0) {
                        $('#purchaserInfoLbl').text("No");
                    }
                    if (purchaser == 1) {
                        $('#purchaserInfoLbl').text("Yes");
                    }
                });

                $.each(data.rec, function (index, value) {
                   $('#reclbl').html(value.StoreName);
                });
                $.each(data.iss, function (index, value) {
                   $('#isslbl').html(value.StoreName);
                });
                $.each(data.appr, function (index, value) {
                   $('#applbl').html(value.StoreName);
                });
                $.each(data.pos, function (index, value) {
                   $('#poslbl').html(value.StoreName);
                });
                $.each(data.proforma, function (index, value) {
                   $('#proformalbl').html(value.StoreName);
                });
                $.each(data.storebl, function (index, value) {
                   $('#strbalancelbl').html(value.StoreName);
                });
                $.each(data.req, function (index, value) {
                   $('#reqlbl').html(value.StoreName);
                });
                $.each(data.trsrc, function (index, value) {
                   $('#trsrclbl').html(value.StoreName);
                });
                $.each(data.trdest, function (index, value) {
                   $('#trdestlbl').html(value.StoreName);
                });
                $.each(data.adj, function (index, value) {
                   $('#adjlbl').html(value.StoreName);
                });
                $.each(data.beg, function (index, value) {
                   $('#beglbl').html(value.StoreName);
                });
                $.each(data.mrc, function (index, value) {
                   $('#mrclbl').html(value.MrcNumber);
                });
                $.each(data.salesrp, function (index, value) {
                   $('#salesreplbl').html(value.StoreName);
                });
                $.each(data.purrp, function (index, value) {
                   $('#purchasereplbl').html(value.StoreName);
                });
                $.each(data.invrp, function (index, value) {
                   $('#inventoryreplbl').html(value.StoreName);
                });
                $.each(data.transferrec, function (index, value) {
                   $('#trreceivelbl').html(value.StoreName);
                });
                $.each(data.finrp, function (index, value) {
                   $('#financialreplbl').html(value.StoreName);
                });
                $.each(data.fitness, function (index, value) {
                   $('#fitnesspalbl').html(value.StoreName);
                });
            });

            $('#salesstoreTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
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
                    url: '/showSalesStores/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                    data: 'StoreName',
                    name: 'StoreName'
                }, ],
            });
            $('#proformaTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
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
                    url: '/showProformaStores/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                    data: 'StoreName',
                    name: 'StoreName'
                }, ],
            });
            $('#mrcsTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
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
                    url: '/showMrcdata/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                    data: 'mrcNumber',
                    name: 'mrcNumber'
                }, ],
            });
            $('#receivingTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
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
                    url: '/showRecData/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                    data: 'StoreName',
                    name: 'StoreName'
                }, ],
            });
            $('#issueTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
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
                    url: '/showIssueStore/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                    data: 'StoreName',
                    name: 'StoreName'
                }, ],
            });
            $('#approverTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
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
                    url: '/showApproverData/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                    data: 'StoreName',
                    name: 'StoreName'
                }, ],
            });
            $("#userInfoModal").modal('show');

        });
        //end Info Modal

        $('body').on('click', '.resetPass', function() {
            var recordId = $(this).data('id');
            $("#resetUserId").val(recordId);
            $("#resetpass").modal('show');
        });
        //Start approve here
        $('body').on('click', '#resetpassbtn', function() {
            var registerForm = $("#resetpassform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/resetPassW',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#resetpassbtn').text('Reseting...');
                    $('#resetpassbtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.success) {
                        $('#resetpassbtn').text('Reset');
                        $('#resetpassbtn').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#resetpass").modal('hide');
                        $("#resetpassform")[0].reset();
                    }
                },
            });
        });
        //End Approve

        function refreshSalesVal() {
            var oTable = $('#salesstoreTable').dataTable();
            oTable.fnDraw(false);
            var iTable = $('#mrcsTable').dataTable();
            iTable.fnDraw(false);
            var jTable = $('#proformaTable').dataTable();
            jTable.fnDraw(false);
            var kTable = $('#laravel-datatable-crud').dataTable();
            kTable.fnDraw(false);
        }

        function refreshReceivingVal() {
            var oTable = $('#receivingTable').dataTable();
            oTable.fnDraw(false);
            var iTable = $('#issueTable').dataTable();
            iTable.fnDraw(false);
            var kTable = $('#laravel-datatable-crud').dataTable();
            kTable.fnDraw(false);
            var userId = $('#infoUserId').val();
            $.get("/useredit" + '/' + userId, function(data) {
                var len = data['userdata'].length;
                for (var i = 0; i <= len; i++) {
                    var purchaser = data['userdata'][i].IsPurchaser;
                    if (purchaser == 0) {
                        $('#purchaserInfoLbl').text("No");
                    }
                    if (purchaser == 1) {
                        $('#purchaserInfoLbl').text("Yes");
                    }
                }
            });
        }

        function refreshApproverVal() {
            var oTable = $('#approverTable').dataTable();
            oTable.fnDraw(false);
            var kTable = $('#laravel-datatable-crud').dataTable();
            kTable.fnDraw(false);
        }

        function refreshUserInfoVal() {
            var kTable = $('#laravel-datatable-crud').dataTable();
            kTable.fnDraw(false);
            var userId = $('#infoUserId').val();
            $.get("/useredit" + '/' + userId, function(data) {
                var len = data['userdata'].length;
                for (var i = 0; i <= len; i++) {
                    $('#infoName').text(data['userdata'][i].FullName);
                    $('#infoUName').text(data['userdata'][i].username);
                    $('#infoRoleName').text(data['userdata'][i].RoleName);
                    $('#infophoneno').text(data['userdata'][i].phone);
                    $('#infoaltphone').text(data['userdata'][i].AlternatePhone);
                    $('#infoemailaddress').text(data['userdata'][i].email);
                    $('#infoaddress').text(data['userdata'][i].Address);
                    $('#infonationality').text(data['userdata'][i].Nationality);
                    $('#infogender').text(data['userdata'][i].Gender);
                    var status = data['userdata'][i].Status;
                    if (status === "Active") {
                        $('#infostatus').html(
                            "<label class='badge badge-success' strong style='font-size: 14px;'>" +
                            data['userdata'][i].Status + "</label>");
                    }
                    if (status === "Inactive") {
                        $('#infostatus').html(
                            "<label class='badge badge-danger' strong style='font-size: 14px;'>" + data[
                                'userdata'][i].Status + "</label>");
                    }
                    var purchaser = data['userdata'][i].IsPurchaser;
                    if (purchaser == 0) {
                        $('#purchaserInfoLbl').text("No");
                    }
                    if (purchaser == 1) {
                        $('#purchaserInfoLbl').text("Yes");
                    }
                }
            });
        }
    </script>
@endsection
