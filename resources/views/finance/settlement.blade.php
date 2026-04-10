@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        @can('Sales-Settlement-View')
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div style="width:22%;">
                                    <h3 class="card-title">Credit Sales Settlement</h3>
                                    <label strong style="font-size: 10px;"></label>
                                    <div class="form-group">
                                        <label strong style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                        <div>
                                            <select class="select2 form-control" data-style="btn btn-outline-secondary waves-effect" name="fiscalyear[]" id="fiscalyear" onchange="fiscalyrfn()" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                                            @foreach ($fiscalyears as $fiscalyears)
                                                <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <ul class="nav nav-tabs justify-content-center" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Settlement-tab" data-toggle="tab" href="#settlement" aria-controls="settlement" role="tab" aria-selected="true" onclick="settlementtabval()">Settlement</a>                                
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Creditors-tab" data-toggle="tab" href="#creditors" aria-controls="creditors" role="tab" aria-selected="false" onclick="creditorsval()">Debtors</a>
                                    </li>
                                </ul>
                                <div>
                                    <div id="newbtndiv">
                                        @if (auth()->user()->can('Sales-Settlement-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm addsettbutton">Add</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div id="creditsalesdiv" style="display: none;"></div>
                            <div class="card-datatable">
                                <div class="tab-content">
                                    <div class="tab-content">
                                        <div class="tab-pane" id="creditors" aria-labelledby="creditors" role="tabpanel">
                                            <div style="width:98%; margin-left:1%;">
                                                <div>
                                                    <div class="row" style="height: 7rem;">
                                                        <div class="col-md-6" style="height:9rem;border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="card-title">Total Credit Sales</h4>
                                                                    <div class="heading-elements">
                                                                        <ul class="list-inline mb-0">
                                                                            <li>
                                                                                <a type="button" class="creditsllink"><i class="fa fa-info" aria-hidden="true"></i></a>
                                                                            </li>
                                                                            <li>
                                                                                <a data-action="reload" onclick="getBalances()"><i data-feather="rotate-cw"></i></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="card-content collapse show">
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td style="text-align: center;"><label id="totalcrsaleslbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                                                <td style="text-align: center;"><label id="totalstlbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                                                <td style="text-align: center;"><label id="totaloutlbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td id="crsaleslblnp" style="text-align: center;">Credit Sales(Net Pay)</td>
                                                                                <td style="text-align: center;">Settled Amount</td>
                                                                                <td style="text-align: center;">Outstanding Amount</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h4 class="card-title">Total Credit Purchase</h4>
                                                                    <div class="heading-elements">
                                                                        <ul class="list-inline mb-0">
                                                                            <li>
                                                                                <a data-action="reload" onclick="getallpurchasebl()"><i data-feather="rotate-cw"></i></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="card-content collapse show">
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td style="text-align: center;"><label id="totalcrpurlbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                                                <td style="text-align: center;"><label id="totalstpurlbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                                                <td style="text-align: center;"><label id="totaloutpurlbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="text-align: center;">Credit Purchase</td>
                                                                                <td style="text-align: center;">Settled Amount</td>
                                                                                <td style="text-align: center;">Outstanding Amount</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="divider">
                                                        <div class="divider-text"></div>
                                                    </div>  
                                                    <div class="row mt-0">
                                                        <div class="col-12">
                                                            <div>
                                                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>CustomerId</th>
                                                                            <th style="width: 0%;">#</th>
                                                                            <th>Customer ID</th>
                                                                            <th>Customer Category</th>
                                                                            <th>Customer Name</th>
                                                                            <th>TIN</th>
                                                                            <th>Default Price</th>
                                                                            <th>Credit Sales</th>
                                                                            <th>Settled Amount</th>
                                                                            <th>Outstanding Amount</th>
                                                                            <th>Action</th>
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
                                        
                                        <div class="tab-pane active" id="settlement" aria-labelledby="settlement" role="tabpanel">
                                            <div style="width:98%; margin-left:1%;">
                                                <div>
                                                    <table id="laravel-datatable-crudsett" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 0%;">Id</th>
                                                                <th style="width: 0%;">#</th>
                                                                <th>Customer ID</th>
                                                                <th>Customer Name</th>
                                                                <th>TIN</th>
                                                                <th>Point of Sales</th>
                                                                <th>CRV #</th>
                                                                <th>Doc/ FS #</th>
                                                                <th>Invoice/ Ref #</th>
                                                                <th>CRV Date</th>
                                                                <th>Status</th>
                                                                <th></th>
                                                                <th>Action</th>
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
                </div>
            </section>
        @endcan

        <!--Toast Start-->
        <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert"
            style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
            <div class="toast-body">
                <strong id="toast-massages"></strong>
                <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <!--Toast End-->

        <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Settlement Info</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="closeAll()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="Register">
                        {{ csrf_field() }}
                        <section class="page-blockui">
                            <div class="modal-body" id="card-block">
                                <div class="row">
                                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <section id="collapsible">
                                            <div class="card collapse-icon">
                                                <div class="collapse-default">
                                                    <div class="card">
                                                        <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                            <span class="lead collapse-title">Customer Informations</span>
                                                        </div>
                                                        <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Basic Information</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Code</label></td>
                                                                                        <td><label id="customercodeLbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Name</label></td>
                                                                                        <td><label id="customernameLbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">TIN</label></td>
                                                                                        <td><label id="customertinnumberLbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">VAT Number</label></td>
                                                                                        <td><label id="customervatnumberLbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Phone Number</label></td>
                                                                                        <td><label id="customerphonenumberLbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6 col-md-6 col-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Credit Sales Information</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Credit Sales Min Amount</label></td>
                                                                                        <td><label id="creditminsalesinfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Credit Sales Max Amount</label></td>
                                                                                        <td><label id="creditmaxsalesinfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr style="display: none;">
                                                                                        <td><label strong style="font-size: 14px;">Available Amount for Credit Sales</label></td>
                                                                                        <td><label id="availableamntcr" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Credit Sales Payment Term</label></td>
                                                                                        <td><label id="creditsaleslimitdayinfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Credit Sales Additional %</label></td>
                                                                                        <td><label id="creditsalesadditioninfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Settle Outstanding for Credit Sales</label></td>
                                                                                        <td><label id="settleoutstandinginfo" strong style="font-size: 14px;font-weight:bold;"></label></td>
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
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;margin-top:-3rem;">
                                        <div class="row">
                                            <div class="col-xl-11 col-lg-12">
                                                <div class="divider">
                                                    <div class="divider-text">Credit Sales</div>
                                                </div>
                                            </div>
                                            <div class="col-xl-1 col-lg-12">
                                                <div class="divider">
                                                    <a type="button" class="cuscreditsllink"><i class="fa fa-info" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="text-align: center;"><label id="totalbalanceLbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                <td style="text-align: center;"><label id="settledbalanceLbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                <td style="text-align: center;"><label id="outstandingbalanceLbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">Credit Sales<br><p><label id="creditsalesinfolbl"></label></p></td>
                                                <td style="text-align: center;">Settled Amount<br><p><label id="settledamountinfolbl"></label></p></td>
                                                <td style="text-align: center;">Outstanding Amount<br><p style="color:#ffffff;visibility: hidden">0</p></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-xl-6 col-lg-12" style="margin-top:-3rem;">
                                        <div class="row">
                                            <div class="col-xl-11 col-lg-12">
                                                <div class="divider">
                                                    <div class="divider-text">Credit Purchase</div>
                                                </div>
                                            </div>
                                            <div class="col-xl-1 col-lg-12">
                                                <div class="divider">
                                                    <a type="button" class=""><i class="fa fa-info" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="text-align: center;"><label id="totalbalancepurLbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                <td style="text-align: center;"><label id="settledbalancepurLbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                                <td style="text-align: center;"><label id="outstandingbalancepurLbl" strong style="font-weight:bold;font-size:20px;"></label></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">Total Credit Purcahse</td>
                                                <td style="text-align: center;">Settled Amount</td>
                                                <td style="text-align: center;">Outstanding Amount</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div> 
                                <div class="row" style="margin-top:-1rem;">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="divider">
                                            <div class="divider-text">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div style="width:98%; margin-left:1%;">
                                            <div class="table-responsive scroll scrdiv">
                                                <table id="customersettlementtbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>#</th>
                                                            <th>POS</th>
                                                            <th>Doc/ FS #</th>
                                                            <th>Invoice/ Ref #</th>
                                                            <th>Sales Doc Date</th>
                                                            <th>Due Date</th>
                                                            <th>CRV #</th>
                                                            <th>Credit Sales</th>
                                                            <th>Settled Amount</th>
                                                            <th>Outstanding Amount</th>
                                                            <th>Payment Status</th>
                                                            <th>Sales Status</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <td colspan="8" style="text-align: right;">
                                                            <label style="font-size: 13px;font-weight:bold;">Grand Total</label>
                                                        </td>
                                                        <td>
                                                            <label id="totalcrlblcus" style="font-size: 13px;font-weight:bold;"></label>
                                                        </td>
                                                        <td>
                                                            <label id="totalsettlblcus" style="font-size: 13px;font-weight:bold;"></label>
                                                        </td>
                                                        <td>
                                                            <label id="outstandingsettlblcus" style="font-size: 13px;font-weight:bold;"></label>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    
                                </div>
                                <div class="row">
                                    
                                    
                                </div>
                                
                            </div>
                            <div class="modal-footer" id="card-block">
                                <div id="cuscreditsalesdiv" style="display: none;"></div>
                                <input type="hidden" placeholder="Outstanding Balance" class="form-control" name="OutstandingBalance" id="OutstandingBalance" ondrop="return false;" onpaste="return false;" readonly="true" style="font-weight: bold;" />
                                <input type="hidden" placeholder="customerId" class="form-control" name="customerId" id="customerId" readonly="true" />
                                <input type="hidden" placeholder="outstandingTxt" class="form-control" name="outstandingTxt" id="outstandingTxt" readonly="true" />
                                @can('Settlement-Add')
                                    <button id="settleBtn" type="button" class="btn btn-info">Save</button>
                                @endcan
                                <button id="closebutton" type="button" class="btn btn-danger" onclick="closeAll()"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </section>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade text-left" id="settlementEdit" data-keyboard="false" data-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Edit Settlement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="closeSettlementEdit()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editSettlementForm">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                    <label strong style="font-size: 14px;">Payment Type</label>
                                    <select class="selectpicker form-control"
                                        data-style="btn btn-outline-secondary waves-effect" name="PaymentType"
                                        id="PaymentTypeEd" onchange="paymentTypeValEd()">
                                        <option selected value="Cash">Cash</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong id="paymenttype-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="banknameeddiv" style="display:none;">
                                    <label strong style="font-size: 14px;">Bank Name</label>
                                    <div>
                                        <select class="selectpicker form-control" data-live-search="true"
                                            data-style="btn btn-outline-secondary waves-effect" name="bank" id="banked"
                                            onchange="bankVal()">
                                            <option value=""></option>
                                            @foreach ($bankedt as $bankedt)
                                                <option value="{{ $bankedt->BankName }}">{{ $bankedt->BankName }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger">
                                        <strong id="banked-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="chequenumeddiv" style="display:none;">
                                    <label strong style="font-size: 14px;">Cheque No.</label>
                                    <input type="number" placeholder="Cheque Number" class="form-control"
                                        name="ChequeNumber" id="ChequeNumbered" onkeypress="return ValidateOnlyNum(event);"
                                        onkeyup="chequenumVal(this)" ondrop="return false;" onpaste="return false;" />
                                    <span class="text-danger">
                                        <strong id="chequenoed-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                    <label strong style="font-size: 14px;">CRV No.</label>
                                    <input type="number" placeholder="CRV Number" class="form-control" name="CrvNumber"
                                        id="CrvNumbered" onkeypress="return ValidateOnlyNum(event);"
                                        onkeyup="crvnumVal(this)" ondrop="return false;" onpaste="return false;" />
                                    <span class="text-danger">
                                        <strong id="crvnoed-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                    <label strong style="font-size: 14px;">Date</label>
                                    <input type="text" id="dateed" name="date" class="form-control flatpickr-basic"
                                        placeholder="YYYY-MM-DD" onchange="dateVal()" />
                                    <span class="text-danger">
                                        <strong id="dateed-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                    <label strong style="font-size: 14px;">Settlement Amount</label>
                                    <input type="number" step="any" placeholder="Settlement Amount" class="form-control"
                                        name="SettlementAmount" id="SettlementAmounted"
                                        onkeypress="return ValidateNum(event);" onkeyup="settlementedVal(this)"
                                        ondrop="return false;" onpaste="return false;" />
                                    <span class="text-danger">
                                        <strong id="settlementamounted-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                    <label strong style="font-size: 14px;">Memo</label>
                                    <textarea type="text" placeholder="Write Memo here..." class="form-control" rows="2"
                                        name="Memo" id="Memoed"></textarea>
                                    <span class="text-danger">
                                        <strong id="memoed-error"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" placeholder="settId" class="form-control" name="settId" id="settId"
                                readonly="true" />
                            <input type="hidden" placeholder="outstandingEditTxt" class="form-control"
                                name="outstandingEditTxt" id="outstandingEditTxt" readonly="true" />
                            <input type="hidden" placeholder="outstandingEditTotalTxt" class="form-control"
                                name="outstandingEditTotalTxt" id="outstandingEditTotalTxt" readonly="true" />
                            <input type="hidden" placeholder="customeredId" class="form-control" name="customeredId"
                                id="customeredId" readonly="true" />
                            <button id="settleEdtBtn" type="button" class="btn btn-info">Update</button>
                            <button id="closebutton" type="button" class="btn btn-danger" onclick="closeSettlementEdit()"
                                data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--Start void modal -->
        <div class="modal fade text-left" id="voidModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Void Settlement Form</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="reasonClVal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="voidform">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label strong style="font-size: 16px;"></label>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Reason</div>
                            </div>
                            <label strong style="font-size: 16px;"></label>
                            <div class="form-group">
                                <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3"
                                    name="Reason" id="Reason" onkeyup="reasonVal()" autofocus></textarea>
                                <span class="text-danger">
                                    <strong id="reason-error"></strong>
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control" name="voidid" id="voidid"
                                    readonly="true">
                                <input type="hidden" placeholder="" class="form-control" name="commentstatus"
                                    id="commentstatus" readonly="true">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                            <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal"
                                onclick="reasonClVal()">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End void modal -->

        <!--Start settlement modal -->
        <div class="modal fade text-left" id="settlementSingleTrInfo" data-keyboard="false" data-backdrop="static"
            tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Settlement Info</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="settlementSingleForm">
                        @csrf
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-1 col-lg-12"></div>
                                    <div class="col-xl-10 col-lg-12">
                                        <table>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Payment Type</label></td>
                                                <td><label id="paymenttypeinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">CRV Number</label></td>
                                                <td><label id="crvnumberinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Bank Name</label></td>
                                                <td><label id="banknameinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Cheque Number</label></td>
                                                <td><label id="chequenumberinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Settlement Amount</label></td>
                                                <td><label id="settlementamntinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Settled By</label></td>
                                                <td><label id="settledbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Transaction Date</label></td>
                                                <td><label id="transactiondateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr id="voidbytr">
                                                <td><label strong style="font-size: 14px;">Void By</label></td>
                                                <td><label id="voidbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr id="voiddatetr">
                                                <td><label strong style="font-size: 14px;">Void Date</label></td>
                                                <td><label id="voiddateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr id="voidreasontr">
                                                <td><label strong style="font-size: 14px;">Void Reason</label></td>
                                                <td><label id="voidreasoninfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Memo</label></td>
                                                <td><label id="memoinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-xl-1 col-lg-12"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="closebuttong" type="button" class="btn btn-danger"
                                data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End settlement modal -->

        <!--Start settlement modal -->
        <div class="modal fade text-left" id="settlementSalesInfo" data-keyboard="false" data-backdrop="static"
            tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Sales Info</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="settlementSalesForm">
                        @csrf
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-1 col-lg-12"></div>
                                    <div class="col-xl-10 col-lg-12">
                                        <table>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Customer Category</label></td>
                                                <td><label id="customercategoryinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Customer Name</label></td>
                                                <td><label id="customernameinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Customer Code</label></td>
                                                <td><label id="customercodeinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">TIN</label></td>
                                                <td><label id="customertinnuminfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">VAT Number</label></td>
                                                <td><label id="customervatnuminfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Payment Type</label></td>
                                                <td><label id="salespaymenttypeinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Voucher Type</label></td>
                                                <td><label id="salesvouchertypeinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Voucher Number</label></td>
                                                <td><label id="salesvouchernuminfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">MRC Number</label></td>
                                                <td><label id="salesmrcnuminfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Point Of Sales</label></td>
                                                <td><label id="salesposinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Withold Percent</label></td>
                                                <td><label id="saleswitholdpercentinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Withold Amount</label></td>
                                                <td><label id="saleswitholdamountinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Discount Percent</label></td>
                                                <td><label id="salesdiscountpercentinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Sub Total</label></td>
                                                <td><label id="salessubtotalinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Tax</label></td>
                                                <td><label id="salestaxinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Grand Total</label></td>
                                                <td><label id="salesgrandtotalinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Witholding</label></td>
                                                <td><label id="saleswitholdinginfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">VAT</label></td>
                                                <td><label id="salesvatinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Net Pay</label></td>
                                                <td><label id="salesnetpayinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">User</label></td>
                                                <td><label id="salesuserinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Document Date</label></td>
                                                <td><label id="salestransactiondateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Created Date</label></td>
                                                <td><label id="salescreateddateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Checked By</label></td>
                                                <td><label id="salescheckedbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Checked Date</label></td>
                                                <td><label id="salescheckeddateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Confirm By</label></td>
                                                <td><label id="salesconfirmbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Confirm Date</label></td>
                                                <td><label id="salesconfirmdateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Change To Pending By</label></td>
                                                <td><label id="saleschangetopendinginfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Change To Pending Date</label>
                                                </td>
                                                <td><label id="saleschangetopendingdateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Refund By</label></td>
                                                <td><label id="salesrefundbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Refund Date</label></td>
                                                <td><label id="salesrefunddateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">Withold Receipt</label></td>
                                                <td><label id="saleswitholdreceiptinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td><label strong style="font-size: 14px;">VAT Receipt</label></td>
                                                <td><label id="salesvatreceiptinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Undo Void By</label></td>
                                                <td><label id="salesundovoidbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr style="display:none;">
                                                <td><label strong style="font-size: 14px;">Undo Void Date</label></td>
                                                <td><label id="salesundovoiddateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr id="salesvoidbytr" style="display:none;">
                                                <td><label strong style="font-size: 14px;">Void By</label></td>
                                                <td><label id="salesvoidbyinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr id="salesvoiddatetr" style="display:none;">
                                                <td><label strong style="font-size: 14px;">Void Date</label></td>
                                                <td><label id="salesvoiddateinfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr id="salesvoidreasontr" style="display:none;">
                                                <td><label strong style="font-size: 14px;">Void Reason</label></td>
                                                <td><label id="salesvoidreasoninfo" strong
                                                        style="font-size: 14px;font-weight:bold;"></label></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-xl-1 col-lg-12"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="closebuttonl" type="button" class="btn btn-danger"
                                data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End settlement modal -->

        <!--Start settlement modal -->
        <div class="modal fade text-left" id="settlementTrInfo" data-keyboard="false" data-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Info</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="settlementForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-5 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="card-title">Customer Information</h2>
                                        </div>
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <td><label strong style="font-size: 14px;">Customer Code</label></td>
                                                    <td><label id="customercodeLblinfo" strong
                                                            style="font-size:14px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 14px;">Customer Name</label></td>
                                                    <td><label id="customernameLblinfo" strong
                                                            style="font-size:14px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 14px;">TIN</label></td>
                                                    <td><label id="customertinnumberLblinfo" strong
                                                            style="font-size:14px;font-weight:bold;"></label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-7 col-md-6 col-sm-12 mb-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Payment Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <table style="width:100%;">
                                                <tr>
                                                    <td style="text-align:center; vertical-align:middle;width:35%;"><label
                                                            id="totalbalanceLblinfo" strong
                                                            style="font-size:35px;font-weight:bold;"></label></td>
                                                    <td style="text-align:center; vertical-align:middle;width:30%;"><label
                                                            id="settledbalanceLblinfo" strong
                                                            style="font-size:35px;font-weight:bold;"></label></td>
                                                    <td style="text-align:center; vertical-align:middle;width:35%;"><label
                                                            class="count" id="outstandingbalanceLblinfo" strong
                                                            style="font-size:35px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center; vertical-align:middle;width:35%;"><label
                                                            strong style="font-size: 14px;">Total Credit Sales</label></td>
                                                    <td style="text-align:center; vertical-align:middle;width:30%;"><label
                                                            strong style="font-size: 14px;">Settled Balance</label></td>
                                                    <td style="text-align:center; vertical-align:middle;width:35%;"><label
                                                            strong style="font-size: 14px;">Outstanding Balance</label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive">
                                            <table id="detailtransaction"
                                                class="table table-bordered table-striped table-hover dt-responsive table mb-0"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display:none;"></th>
                                                        <th>Payment Type</th>
                                                        <th>Voucher Type</th>
                                                        <th>Voucher #</th>
                                                        <th>Shop</th>
                                                        <th>MRC #</th>
                                                        <th>Crv #</th>
                                                        <th>Bank Name</th>
                                                        <th>Cheque #</th>
                                                        <th>Date</th>
                                                        <th>Credit Amount</th>
                                                        <th>Settled Amount</th>
                                                        <th style="display:none;">Transaction Type</th>
                                                        <th style="display:none;"></th>
                                                        <th style="display:none;"></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan=9 style="border-right-style: hidden;">
                                                        <td>
                                                        <td style="text-align:center;"><label id="crfooterlbl" strong
                                                                style="font-size: 14px;font-weight:bold;">5</label></td>
                                                        <td style="text-align:center;"><label id="settfooterlbl" strong
                                                                style="font-size: 14px;font-weight:bold;">5</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan=9 style="border-right-style: hidden;">
                                                        <td>
                                                        <td colspan=2 style="text-align:center;"><label id="outstfooterlbl"
                                                                strong style="font-size: 14px;font-weight:bold;">5</label>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End settlement modal -->

        <div class="modal fade" id="settlementmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="newsettlementheader">Add Settlement</h4>
                        <div class="row">
                            <div style="text-align: right;" id="statusdisplay"></div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()"><span aria-hidden="true">&times;</span></button>
                        </div>   
                    </div>
                    <form id="SettlementForm">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <section id="input-mask-wrapper">
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                            <div class="row">
                                                <div class="col-xl-3 col-md-6 col-sm-12">
                                                    <label strong style="font-size: 14px;">Point of Sales</label>
                                                    <div>
                                                        <select class="select2 form-control" name="PointOfSales" id="PointOfSales" placeholder="Select POS here">
                                                            <option selected disabled value=""></option>
                                                            @foreach ($storeSrc as $storeSrc)
                                                                <option value="{{ $storeSrc->StoreId }}">{{ $storeSrc->StoreName }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="store-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Customer</label>
                                                    <div>
                                                        <select class="select2 form-control" name="Customer" id="Customer" placeholder="Select Customer here"></select>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="customer-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">CRV Number</label>
                                                    <input type="number" placeholder="CRV Number" class="form-control" name="CrvNumber" id="CrvNumber" onkeypress="return ValidateOnlyNum(event);" onkeyup="crvnumVal(this)"/>
                                                    <span class="text-danger">
                                                        <strong id="crvno-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">CRV Date</label>
                                                    <input type="text" id="date" name="date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="dateVal()" />
                                                    <span class="text-danger">
                                                        <strong id="date-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;">Memo</label>
                                                    <textarea type="text" placeholder="Write Memo here..." class="form-control" rows="2" name="Memo" id="Memo"></textarea>
                                                    <span class="text-danger">
                                                        <strong id="memo-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="card">
                                                <div class="card-header" style="background-color: hsl(47,83%,91%);height:0.5rem;border: 0.5px solid hsl(47,65%,84%);position:relative;">
                                                    <div class="card-title">
                                                        <p style="margin-top:-10px;margin-left:-15px;">
                                                            <label id="customerinformationlbl" strong style="font-size: 13px;font-weight:bold;">Customer Information</label>
                                                        </p>
                                                    </div>
                                                    <div class="heading-elements">
                                                        <p style="margin-top:-15px;margin-right:-15px;">
                                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-dark waves-effect showdocinfo" style="display: none;" id="customerinfobtn">
                                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                            </button>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="card-body scroll scrdiv" id="infoCardDiv" style="background-color: hsl(47,87%,94%);border: 0.5px solid hsl(47,65%,84%);">
                                                    <div style="text-align: left;">
                                                        <table style="width: 100%;margin-left:-15px;margin-top:5px;">
                                                            <tr>
                                                                <td style="width: 30%">
                                                                    <label strong style="font-size: 12px;">Category</label>
                                                                </td>
                                                                <td>
                                                                    <label id="categoryInfoLbl" strong style="font-size: 12px;font-weight:bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label strong style="font-size: 12px;">Name</label>
                                                                </td>
                                                                <td>
                                                                    <label id="nameInfoLbl" strong style="font-size: 12px;font-weight:bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label strong style="font-size: 12px;">TIN</label>
                                                                </td>
                                                                <td>
                                                                    <label id="tinInfoLbl" strong style="font-size: 12px;font-weight:bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label strong style="font-size: 12px;">VAT #</label>
                                                                </td>
                                                                <td>
                                                                    <label id="vatInfoLbl" strong style="font-size: 12px;font-weight:bold;"></label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <label strong style="font-size: 12px;">Phone #</label>
                                                                </td>
                                                                <td>
                                                                    <label id="phoneInfoLbl" strong style="font-size: 12px;font-weight:bold;"></label>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"  style="margin-top:-2rem;">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="divider">
                                                <div class="divider-text">-</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <table class="mb-0 rtable" id="dynamicTable" style="width: 100%;">
                                                <thead style="font-size: 12px;">
                                                    <tr>
                                                        <th style="width:2%;">#</th>
                                                        <th style="width:10%;">FS / Invoice #</th>
                                                        <th style="width:8%;">Rem. Day</th>
                                                        <th style="width:8%;">Rem. Amount</th>
                                                        <th style="width:9%;">Payment Mode</th>
                                                        <th style="width:12%;">Bank Name</th>
                                                        <th style="width:10%;">Account #</th>
                                                        <th style="width:10%;">Transaction Ref. #</th>
                                                        <th style="width:11%;">Settled Amount</th>
                                                        <th style="width:8%;">Status</th>
                                                        <th style="width:10%;">Remark</th>
                                                        <th style="width:2%;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <table class="mb-0">
                                                <tr>
                                                    <td>
                                                        <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>      Add New</button>
                                                    <td>
                                                </tr>
                                            </table>
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-12"></div>
                                                    <div class="col-xl-3 col-lg-12">
                                                        <table style="width:103%;text-align:right" id="pricingTable" class="rtable">
                                                            <tr style="display:none;" class="totalrownumber">
                                                                <td style="text-align: right;width:45%"><label strong style="font-size: 14px;">Total Outstanding Amount</label></td>
                                                                <td style="text-align: center;width:55%">
                                                                    <label id="cusoutstandinglbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                    <input type="hidden" placeholder="" class="form-control" name="totaloutstandingi" id="totaloutstandingi" readonly="true" value="0" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="text-align: right;width:57%">
                                                                    <label strong style="font-size: 14px;">Total Settled Amount</label>
                                                                </td>
                                                                <td style="text-align: center;width:43%">
                                                                    <label id="custotalsettledlbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                    <input type="hidden" placeholder="" class="form-control" name="custotalsettledi" id="custotalsettledi" readonly="true" value="0" />
                                                                </td>
                                                            </tr>
                                                            <tr style="display: none;">
                                                                <td style="text-align: right;width:45%">
                                                                    <label strong style="font-size: 14px;">Total Un-Settled Amount</label>
                                                                </td>
                                                                <td style="text-align: center;width:55%">
                                                                    <label id="custotalunpaidlbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                    <input type="hidden" placeholder="" class="form-control" name="custotalunpaidi" id="custotalunpaidi" readonly="true" value="0" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: none;">
                                            <table class="mb-0" id="dynamicTableCh" style="width: 100%;">
                                                <thead style="font-size: 13px;">
                                                    <tr>
                                                        <th>SalesId</th>
                                                        <th>PaymentType</th>
                                                        <th>BankName</th>
                                                        <th>ChequeNumber</th>
                                                        <th>SlipNumber</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <div style="display: none;">
                                <input type="hidden" id="MaxDate" name="MaxDate" class="form-control" placeholder="YYYY-MM-DD"/>
                                <input type="hidden" id="CreditSalesDate" name="CreditSalesDate" class="form-control" placeholder="YYYY-MM-DD"/>
                                <input type="hidden" placeholder="" class="form-control" name="isnewVal" id="isnewVal" readonly="true" value="0"/>
                                <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                                <input type="hidden" placeholder="" class="form-control" name="settlementId" id="settlementId" readonly="true"/>
                                <label id="lblarr" strong style="font-size: 12px;"></label>
                                <select class="select2 form-control" name="FSNumbers" id="FSNumbers"></select>
                                <select class="select2 form-control" name="bank" id="bank">
                                    <option value=""></option>
                                    @foreach ($bank as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->BankName }}</option>
                                    @endforeach
                                </select>
                                <select class="select2 form-control" name="AccData" id="AccData">
                                    <option selected disabled value=""></option>
                                    @foreach ($accnum as $accnum)
                                        <option title="{{ $accnum->banks_id }}" value="{{$accnum->id}}">{{$accnum->AccountNumber}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @can('Sales-Settlement-Add')
                                <button id="savebutton" type="button" class="btn btn-info">Save</button>
                            @endcan
                            <button id="closebuttonk" type="button" class="btn btn-danger closebutton" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- add settlement info modal-->
        <div class="modal modal-slide-in event-sidebar fade" id="documentnuminfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">FS/Invoice Number ,Document Number ,CRV Number Information</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">POS & Customer Information</span>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infodoc">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">POS Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Point of Sales</label></td>
                                                                                    <td><label id="posnamelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Customer Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Customer Code</label></td>
                                                                                    <td><label id="customercodeLblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Customer Name</label></td>
                                                                                    <td><label id="customernameLblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">TIN</label></td>
                                                                                    <td><label id="customertinnumberLblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">VAT Number</label></td>
                                                                                    <td><label id="customervatnumberLblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Phone Number</label></td>
                                                                                    <td><label id="customerphonenumberLblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Customer Credit Sales Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Min Amount</label></td>
                                                                                    <td><label id="creditminsalesinfostin" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Max Amount</label></td>
                                                                                    <td><label id="creditmaxsalesinfostin" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr style="display: none;">
                                                                                    <td><label strong style="font-size: 14px;">Remaining Amount for Credit Sales</label></td>
                                                                                    <td><label id="availableamntcrstin" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Payment Term</label></td>
                                                                                    <td><label id="creditsaleslimitdayinfostin" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Additional %</label></td>
                                                                                    <td><label id="creditsalesadditioninfostin" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Settle Outstanding for Credit Sales</label></td>
                                                                                    <td><label id="settleoutstandinginfostin" strong style="font-size: 14px;font-weight:bold;"></label></td>
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
                            <div class="divider" style="margin-top: -3rem">
                                <div class="divider-text">-</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="documentinfotbl" style="width:100%" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <th></th>
                                                <th>#</th>
                                                <th>POS</th>
                                                <th>Doc/ FS #</th>
                                                <th>Invoice/ Ref #</th>
                                                <th>Sales Doc Date</th>
                                                <th>Due Date</th>
                                                <th>CRV #</th>
                                                <th>Credit Sales</th>
                                                <th>Settled Amount</th>
                                                <th>Outstanding Amount</th>
                                                <th>Payment Status</th>
                                                <th>Sales Status</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </thead>
                                            <tfoot>
                                                <td colspan="8" style="text-align: right;">
                                                    <label style="font-size: 12px;font-weight:bold;">Total</label>
                                                </td>
                                                <td>
                                                    <label id="totalcrlbl" style="font-size: 12px;font-weight:bold;"></label>
                                                </td>
                                                <td>
                                                    <label id="totalsettlbl" style="font-size: 12px;font-weight:bold;"></label>
                                                </td>
                                                <td>
                                                    <label id="outstandingsettlbl" style="font-size: 12px;font-weight:bold;"></label>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ add settlement info modal-->

        <!--Start settlement modal -->
        <div class="modal fade text-left" id="settlementrecordInfo" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="settlementinfotitle">Info</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="settlementinfofn()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="settlementrecordInfoForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Customer, CRV, Action & Others Information</span>
                                                        <div style="text-align: right;" id="statustitles"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infodocrec">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Customer Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Customer Code</label></td>
                                                                                    <td><label id="customercodeLblslrec" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Customer Name</label></td>
                                                                                    <td><label id="customernameLblslrec" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">TIN</label></td>
                                                                                    <td><label id="customertinnumberLblslrec" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">VAT No.</label></td>
                                                                                    <td><label id="customervatnumberLblslrec" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Phone No.</label></td>
                                                                                    <td><label id="customerphonenumberlbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="crpropinfo">
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Min Amount</label></td>
                                                                                    <td><label id="creditminsalesinfost" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="crpropinfo">
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Max Amount</label></td>
                                                                                    <td><label id="creditmaxsalesinfost" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="crpropinfo">
                                                                                    <td style="display: none;"><label strong style="font-size: 14px;">Available Amount for Credit Sales</label></td>
                                                                                    <td style="display: none;"><label id="availableamntcrst" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="crpropinfo">
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Payment Term</label></td>
                                                                                    <td><label id="creditsaleslimitdayinfost" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="crpropinfo">
                                                                                    <td><label strong style="font-size: 14px;">Credit Sales Additional %</label></td>
                                                                                    <td><label id="creditsalesadditioninfost" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr class="crpropinfo">
                                                                                    <td><label strong style="font-size: 14px;">Settle Outstanding for Credit Sales</label></td>
                                                                                    <td><label id="settleoutstandinginfost" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="text-align: left;">
                                                                                        <a id="showmorebtn" style="text-decoration:underline;color:blue;" onclick="showmorefn()">Show More</a>
                                                                                        <a id="showlessbtn" style="text-decoration:underline;color:blue;" onclick="showlessfn()">Show Less</a>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="2" style="text-align: center;">
                                                                                        <div class="divider">
                                                                                            <div class="divider-text">Point of Sales Info</div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Point of Sales</label></td>
                                                                                    <td><label id="posnamelblrec" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">CRV Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">CRV No.</label></td>
                                                                                    <td><label id="crvnumberinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">CRV Date</label></td>
                                                                                    <td><label id="crvdateinoflbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Prepared By</label></td>
                                                                                    <td><label id="preparedbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Prepared Date</label></td>
                                                                                    <td><label id="prepareddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Verified By</label></td>
                                                                                    <td><label id="verifiedbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Verified Date</label></td>
                                                                                    <td><label id="verifieddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Confirmed By</label></td>
                                                                                    <td><label id="confirmedbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Confirmed Date</label></td>
                                                                                    <td><label id="confirmeddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Change to Pending By</label></td>
                                                                                    <td><label id="topendingbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Change to Pending Date</label></td>
                                                                                    <td><label id="topendingdatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Other Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Void By</label></td>
                                                                                    <td><label id="voidbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Void Date</label></td>
                                                                                    <td><label id="voiddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Void Reason</label></td>
                                                                                    <td><label id="voidreasonlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Undo Void By</label></td>
                                                                                    <td><label id="undovoidbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Undo Void Date</label></td>
                                                                                    <td><label id="undovoiddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Last Edited By</label></td>
                                                                                    <td><label id="lasteditedbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Last Edited Date</label></td>
                                                                                    <td><label id="lastediteddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Memo</label></td>
                                                                                    <td><label id="memolblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                            <div class="divider" style="margin-top: -3rem">
                                <div class="divider-text">-</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="settlementdetailtbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>#</th>
                                                        <th>Doc/ FS #</th>
                                                        <th>Invoice/ Ref #</th>
                                                        <th>Sales Doc. Date</th>
                                                        <th>Remaining Day</th>
                                                        <th>Payment Type</th>
                                                        <th>Bank Name</th>
                                                        <th>Account #</th>
                                                        <th>Transaction Ref. #</th>
                                                        <th>Settled Amount</th>
                                                        <th>Payment Status</th>
                                                        <th>Remark</th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="10" style="text-align: right;">
                                                            <label style="font-size: 13px;font-weight: bold;">Grand Total</label>
                                                        </td> 
                                                        <td style="text-align: left;">
                                                            <label id="custotalsettledlblinfo" style="font-size: 13px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <td colspan="10" style="text-align: right;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:white;">
                                                            <label strong style="font-size: 13px;">Total Outstanding Amount</label>
                                                        </td>
                                                        <td style="text-align: right;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:white;">
                                                            <label id="cusoutstandinglblinfo" class="formattedNum" strong style="font-size: 13px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <td colspan="10" style="text-align: right;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:white;">
                                                            <label strong style="font-size: 13px;">Total Un-Settled Amount</label>
                                                        </td>
                                                        <td style="text-align: right;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:white;">
                                                            <label id="custotalunpaidlblinfo" class="formattedNum" strong style="font-size: 13px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" placeholder="" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                            <input type="hidden" class="form-control" name="selectedids" id="selectedids" readonly="true">
                            <input type="hidden" class="form-control" name="recordIds" id="recordIds" readonly="true">
                            <input type="hidden" class="form-control" name="statusIds" id="statusIds" readonly="true">
                            <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                            @can('Sales-Settlement-ChangeToPending')
                                <button id="changetopending" type="button" onclick="getPendingInfoConf()" class="btn btn-info">Change to Pending</button>
                            @endcan
                            @can('Sales-Settlement-Verify')
                                <button id="verifysettlementbtn" type="button" onclick="getVerifyInfoConf()" class="btn btn-info">Verify Settlement</button>
                            @endcan
                            @can('Sales-Settlement-Confirm')
                                <button id="confirmsettlement" type="button" onclick="getConfirmInfoConf()" class="btn btn-info">Confirm Settlement</button>
                            @endcan
                            <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal" onclick="settlementinfofn()">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End settlement modal -->

        <!--Start Check Settlement modal -->
        <div class="modal fade text-left" id="settlementverifymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="verifysettlementform">
                        @csrf
                        <div class="modal-body" style="background-color:#f6c23e">
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to verify settlement?</label>
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control" name="checkedid" id="checkedid" readonly="true">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="verifysettbtn" type="button" class="btn btn-info">Verify Settlement</button>
                            <button id="closebuttonf" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Check Settlement modal -->

        <!--Start Pending Settlement modal -->
        <div class="modal fade text-left" id="settlementpendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="pendingsettlementform">
                        @csrf
                        <div class="modal-body" style="background-color:#f6c23e">
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to change settlement to pending?</label>
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control" name="pendingid" id="pendingid"
                                    readonly="true">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="pendingbtn" type="button" class="btn btn-info">Change to Pending</button>
                            <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Pending Settlement modal -->

        <!--Start Confimed Settlement modal -->
        <div class="modal fade text-left" id="settlementconfirmedmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="confirmedsettlementform">
                        @csrf
                        <div class="modal-body" style="background-color:#f6c23e">
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to confirm settlement?</label>
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control" name="confirmid" id="confirmid" readonly="true">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="confirmbtn" type="button" class="btn btn-info">Confirm Settlement</button>
                            <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Confimed Settlement modal -->

        <!--Start Void modal -->
        <div class="modal fade text-left" id="voidreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="voidReason()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="voidreasonform">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label strong style="font-size: 16px;font-weight:bold;">Do you really want to void settlements?</label>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Reason</div>
                            </div>
                            <label strong style="font-size: 16px;"></label>
                            <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                            <span class="text-danger">
                                <strong id="void-error"></strong>
                            </span>
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control voidid" name="voididn" id="voididn" readonly="true">
                                <input type="hidden" placeholder="" class="form-control vstatus" name="vstatus" id="vstatus" readonly="true">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                            <button id="closebuttoni" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReason()">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Void modal -->

        <!--Start undo void modal -->
        <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="undovoidform">
                        @csrf
                        <div class="modal-body" style="background-color:#f6c23e">
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo void settlement?</label>
                            <div class="form-group">
                                <input type="hidden" placeholder="" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                                <input type="hidden" placeholder="" class="form-control" name="ustatus" id="ustatus" readonly="true">
                                <input type="hidden" placeholder="" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
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

        <!--Start CRV detail modal -->
        <div class="modal fade text-left" id="crvdetailmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="crvdetailmodaltitle">CRV Detail</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="crvdetailform">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".crvdetinfocl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Sales Basic & Payment Information</span>
                                                        <div id="statustitles"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse crvdetinfocl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td><label strong="" style="font-size: 14px;">POS</label></td>
                                                                                    <td><label id="crvdetposlbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong="" style="font-size: 14px;">Doc/ FS #</label></td>
                                                                                    <td><label id="crvdetfslbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong="" style="font-size: 14px;">Invoice/ Ref #</label></td>
                                                                                    <td><label id="crvdetinvlbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong="" style="font-size: 14px;">Sales Doc. Date</label></td>
                                                                                    <td><label id="crvdetdocdatelbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong="" style="font-size: 14px;">Due Date</label></td>
                                                                                    <td><label id="crvdetduedatelbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong="" style="font-size: 14px;">Fiscal Year</label></td>
                                                                                    <td><label id="crvdetfiscalyrlbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Payment Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <td><label strong="" style="font-size: 14px;">Credit Sales</label></td>
                                                                                        <td><label id="crvdetcreditsaleslbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong="" style="font-size: 14px;">Settled Amount</label></td>
                                                                                        <td><label id="crvdetsettamountlbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong="" style="font-size: 14px;">Outstanding Amount</label></td>
                                                                                        <td><label id="crvdetoutstandinglbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong="" style="font-size: 14px;">Invoice Payment Status</label></td>
                                                                                        <td><label id="crvdetpaymentstlbl" strong="" style="font-size:14px;font-weight:bold;"></label></td>
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
                                    </section>
                                </div>
                            </div>
                            <div class="divider" style="margin-top: -2rem">
                                <div class="divider-text">-</div>
                            </div> 
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-12 table-responsive scroll scrdiv">
                                    <table id="crvdetaildatatable" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 0%;">Id</th>
                                                <th style="width: 0%;">#</th>
                                                <th>CRV #</th>
                                                <th>CRV Date</th>
                                                <th>Payment Type</th>
                                                <th>Bank Name</th>
                                                <th>Cheque #</th>
                                                <th>Bank Transfer #</th>
                                                <th>Settled Amount</th>
                                                <th>Payment Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" style="text-align: right;font-weight:bold;">Grand Total</td>
                                                <td colspan="2">
                                                    <label id="crvtotalsettledamountlbl" style="font-size: 13px;font-weight:bold;"></label>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End CRV detail modal -->
    </div>

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });
        var j = 0;
        var i = 0;
        var m = 0;
        var mc=0;
        var salesidarr=[];
        var tableheader="";
        var tablebody="";
        var tables="";
        var custableheader="";
        var custablebody="";
        var custables="";
        var fyears=$('#fiscalyear').val();

        $('#date').pickadate({
            format: 'yyyy-mm-dd',
            selectMonths: true,
            selectYears: 60,
            max: true,
            clear: false,
            width:17,
        });

        $('body').on('click', '.addsettbutton', function() {
            $('#PointOfSales').select2
            ({
                placeholder: "Select POS here",
            });
            $('#Customer').select2
            ({
                placeholder: "Select Customer here",
            });
            $('#customerinfobtn').hide();
            $('#infoCardDiv').hide();
            $('#dynamicTable tbody').empty();
            j = 0;
            $("#settlementmodal").modal('show');
            $("#newsettlementheader").html("Add Sales Settlement");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $('#settlementId').val("");
            $('#operationtypes').val("1");
            $('#isnewVal').val("0");
            $('#pricingTable').hide();
            $('#totaloutstandingi').val("");
            $('#custotalsettledi').val("");
            $('#custotalunpaidi').val("");
            $('#cusoutstandinglbl').html("");
            $('#custotalsettledlbl').html("");
            $('#custotalunpaidlbl').html("");
            $("#statusdisplay").html("");
            $('#MaxDate').val("");
            $('#CreditSalesDate').val("");
        });

        $('body').on('click', '.showdocinfo', function() {
            var pos=$('#PointOfSales').val();
            var cus=$('#Customer').val();
            var netpay=0;
            var withold=0;
            var vatamnt=0;
            var outstanding=0;
            var settledamount=0;
            var grandtotals=0;
            $.get("/showdocinfos"+'/'+pos+'/'+cus , function(data) {
                $.each(data.poslist, function(index, value) {
                    $("#posnamelbl").html(value.Name);
                });
                $.each(data.withsett, function(key, value) {
                    withold=value.WitholdAmount;
                });

                $.each(data.vatsett, function(key, value) {
                    vatamnt=value.VatAmount;
                });

                $.each(data.settpricing, function(key, value) {
                    settledamount=value.SettlementAmount;
                });

                $.each(data.pricing, function(key, value) {
                    grandtotals=value.GrandTotal;
                });
                netpay=parseFloat(grandtotals)- parseFloat(withold)-parseFloat(vatamnt);
                outstanding=parseFloat(netpay)-parseFloat(settledamount);
                $.each(data.cuslist, function(index, value) {
                    $("#customercodeLblsl").html(value.Code);
                    $("#customernameLblsl").html(value.Name);
                    $("#customertinnumberLblsl").html(value.TinNumber);
                    $("#customervatnumberLblsl").html(value.VatNumber);
                    $("#customerphonenumberLblsl").html(value.PhoneNumber+"         ,         "+value.OfficePhone);
                    $('#creditminsalesinfostin').text(numformat(value.CreditSalesLimitStart));
                    $('#creditsaleslimitdayinfostin').text(value.CreditSalesLimitDay);
                    $('#creditsalesadditioninfostin').text(value.CreditSalesAdditionPercentage);
                    var settleoutstanding=value.SettleAllOutstanding;
                    var isunlimitedcrsales=value.CreditSalesLimitFlag;
                    var permittedamount=parseFloat(value.CreditSalesLimitEnd)-parseFloat(netpay);
                    if(isunlimitedcrsales=="1"){
                        $('#creditmaxsalesinfostin').text("Unlimited");
                        $('#availableamntcrstin').text("Unlimited");
                    }
                    if(isunlimitedcrsales=="0"){
                        $('#creditmaxsalesinfostin').text(numformat(value.CreditSalesLimitEnd));
                        $('#availableamntcrstin').text(numformat(permittedamount));
                    }
                    if(settleoutstanding=="1"){
                        $('#settleoutstandinginfostin').html("Yes");
                    }
                    if(settleoutstanding=="0"){
                        $('#settleoutstandinginfostin').html("No");
                    }
                });
            });

            $('#documentinfotbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "ordering": false,
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
                    url: '/showdocinfodata/' + pos+'/'+cus,
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    { data:'DT_RowIndex'},
                    {
                        data: 'POS',
                        name: 'POS',
                        'visible': false
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber'
                    },
                    {
                        data: 'invoiceNo',
                        name: 'invoiceNo'
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate'
                    },
                    {
                        data: 'settlementexpiredate',
                        name: 'settlementexpiredate'
                    },
                    {
                        data: 'CRVNumbers',
                        name: 'CRVNumbers'
                    },
                    {
                        data: 'CreditSales',
                        name: 'CreditSales',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'SettledAmounts',
                        name: 'SettledAmounts',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'OustandingBalance',
                        name: 'OustandingBalance',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'PaymentStatus',
                        name: 'PaymentStatus'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },
                    {
                        data: 'setlmentstatus',
                        name: 'setlmentstatus',
                        'visible': false
                    },
                    {
                        data: 'RemainingDate',
                        name: 'RemainingDate',
                        'visible': false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        'visible': false
                    }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "pending..") {
                        $(nRow).find('td:eq(10)').css({"color": "#f6c23e","font-weight": "bold"});
                    } 
                    else if (aData.Status == "Checked") {
                        $(nRow).find('td:eq(10)').css({"color": "#4e73df","font-weight": "bold"});
                    } 
                    else if (aData.Status == "Confirmed") {
                        $(nRow).find('td:eq(10)').css({"color": "#1cc88a","font-weight": "bold"});
                    }
                    else if (aData.Status == "Void") {
                        $(nRow).find('td:eq(10)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                    if (aData.setlmentstatus == 0) {
                        $(nRow).find('td:eq(9)').css({"color": "#e74a3b","font-weight": "bold"});
                    } 
                    else if (aData.setlmentstatus == 1) {
                        $(nRow).find('td:eq(9)').css({"color": "#f6c23e","font-weight": "bold"});
                    } 
                    else if (aData.setlmentstatus == 2) {
                        $(nRow).find('td:eq(9)').css({"color": "#1cc88a","font-weight": "bold"});
                    } 
                    if(parseFloat(aData.RemainingDate)>=0 && parseFloat(aData.RemainingDate)<=30 && aData.setlmentstatus != 2){
                        $(nRow).find('td:eq(4)').css({"color": "#f6c23e","font-weight": "bold"});
                    }
                    else if(parseFloat(aData.RemainingDate)<0 && aData.setlmentstatus != 2){
                        $(nRow).find('td:eq(4)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
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
                    var totalcr = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var totalsett = api
                        .column( 9 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var outstandingsett = api
                        .column( 10 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
                    var totaloutstandinig=parseFloat(totalcr)-parseFloat(totalsett);
                    $("#totalcrlbl").html(numformat(totalcr.toFixed(2)));
                    $("#totalsettlbl").html(numformat(totalsett.toFixed(2)));
                    $("#outstandingsettlbl").html(numformat(totaloutstandinig.toFixed(2)));
                }
            });
            $(".infodoc").collapse('show');
            $("#documentnuminfomodal").modal('show');
        });

        function getBalances(){
            getallbalance(fyears);
        }

        function fiscalyrfn(){
            var fyearsch=$('#fiscalyear').val();
            getallbalance(fyearsch);
            getSettlement(fyearsch);
            getCreditSales(fyearsch);
            getsalesperstore(fyearsch)
        }

        function getallbalance(fyears){
            var fytext="";
            $("#fiscalyear :selected").each(function() {
                fytext=this.text;
            });
            $.get("/showallcreditsl"+ '/' + fyears, function(data) {
                var creditsales=0;
                var witholdsl=0;
                var vatsl=0;
                var settled=0;
                var netpay=0;
                var creditsalesfy=0;
                var witholdfy=0;
                var vatfy=0;
                var netpayfy=0;
                var totalnetpay=0;
                var outstandingbl=0;
                $.each(data.pricing, function(index, value) {
                    creditsales=value.GrandTotal;
                });
                $.each(data.withsett, function(index, value) {
                    witholdsl=value.WitholdAmount;
                });
                $.each(data.vatsett, function(index, value) {
                    vatsl=value.VatAmount;
                });

                $.each(data.pricingfy, function(index, value) {
                    creditsalesfy=value.GrandTotal;
                });
                $.each(data.withsettfy, function(index, value) {
                    witholdfy=value.WitholdAmount;
                });
                $.each(data.vatsettfy, function(index, value) {
                    vatfy=value.VatAmount;
                });

                $.each(data.settpricing, function(index, value) {
                    settled=value.SettlementAmount;
                });

                netpayfy=parseFloat(creditsalesfy)-parseFloat(witholdfy)-parseFloat(vatfy);
                netpay=parseFloat(creditsales)-parseFloat(witholdsl)-parseFloat(vatsl);
                totalnetpay=parseFloat(netpay)+parseFloat(netpayfy);
                //outstandingbl=parseFloat(totalnetpay)-parseFloat(settled);
                outstandingbl=(parseFloat(netpayfy)+parseFloat(netpay))-parseFloat(settled);
                $('#totalcrsaleslbl').text(numformat(netpay.toFixed(2)));
                $('#totalstlbl').text(numformat(settled.toFixed(2)));
                $('#totaloutlbl').text(numformat(outstandingbl.toFixed(2)));
                $('#crsaleslblnp').html("Credit Sales");
            });
        }

        function getallpurchasebl(){
            $.get("/showallcreditpr" , function(data) {
                var creditpur=0;
                var witholdsl=0;
                var vatsl=0;
                var settled=0;
                var netpay=0;
                var outstandingbl=0;
                $.each(data.pricing, function(index, value) {
                    creditpur=value.GrandTotal;
                });
                $.each(data.withsett, function(index, value) {
                    witholdsl=value.WitholdAmount;
                });
                // $.each(data.settpricing, function(index, value) {
                //     settled=value.SettlementAmount;
                // });
                netpay=parseFloat(creditpur);
                outstandingbl=parseFloat(netpay)-parseFloat(settled);
                $('#totalcrpurlbl').text(numformat(netpay.toFixed(2)));
                $('#totalstpurlbl').text(numformat(settled.toFixed(2)));
                $('#totaloutpurlbl').text(numformat(outstandingbl.toFixed(2)));
            });
        }

        function getsalesperstore(fyears){
            $.get("/showcrsales"+'/'+fyears , function(data) {
                var creditsalesval=0;
                var settledamountval=0;
                var outstandingval=0;
                tableheader="";
                tablebody="";
                tables="";
                $.each(data.crsales, function(index, value) {
                    creditsalesval=value.NetPay;
                    settledamountval=value.SettledAmounts||0;
                    outstandingval=value.OutstandingBalance||0;
                    tablebody+="<div class='row' style='border-top-style: solid;border-top-color:rgba(34, 41, 47, 0.2);border-top-width: 1px;'><div class='col-xl-3 col-lg-12'>"+value.Name+"</div><div class='col-xl-3 col-lg-12'>"+numformat(creditsalesval.toFixed(2))+"</div><div class='col-xl-3 col-lg-12'>"+numformat(settledamountval.toFixed(2))+"</div><div class='col-xl-3 col-lg-12'>"+numformat(outstandingval.toFixed(2))+"</div></div>";
                });
                tableheader="<div class='row'><div class='col-xl-3 col-lg-12'><b><u>POS</u></b></div><div class='col-xl-3 col-lg-12'><b><u>Credit Sales</u></b></div><div class='col-xl-3 col-lg-12'><b><u>Settled Amount</u></b></div><div class='col-xl-3 col-lg-12'><b><u>Outstanding Amount</u></b></div></div>";
                tables=tableheader+tablebody;
                $("#creditsalesdiv").html(tables);
            });
        }

        function getcussalessett(cusid,fyears){
            $.get("/showcrsalescus"+'/'+ cusid+'/'+fyears, function(data) {
                var creditsalesval=0;
                var settledamountval=0;
                var outstandingval=0;
                custableheader="";
                custablebody="";
                custables="";
                $.each(data.crsales, function(index, value) {
                    creditsalesval=value.NetPay;
                    settledamountval=value.SettledAmounts||0;
                    outstandingval=value.OutstandingBalance||0;
                    custablebody+="<div class='row' style='border-top-style: solid;border-top-color:rgba(34, 41, 47, 0.2);border-top-width: 1px;'><div class='col-xl-3 col-lg-12'>"+value.Name+"</div><div class='col-xl-3 col-lg-12'>"+numformat(creditsalesval.toFixed(2))+"</div><div class='col-xl-3 col-lg-12'>"+numformat(settledamountval.toFixed(2))+"</div><div class='col-xl-3 col-lg-12'>"+numformat(outstandingval.toFixed(2))+"</div></div>";
                });
                custableheader="<div class='row'><div class='col-xl-3 col-lg-12'><b><u>POS</u></b></div><div class='col-xl-3 col-lg-12'><b><u>Credit Sales</u></b></div><div class='col-xl-3 col-lg-12'><b><u>Settled Amount</u></b></div><div class='col-xl-3 col-lg-12'><b><u>Outstanding Amount</u></b></div></div>";
                custables=custableheader+custablebody;
                $("#cuscreditsalesdiv").html(custables);
            });
        }

        //Start open modal
        function settlementBtn(recordId,storeIds){
            //var recordId = $(this).data('id');
            //var storeIds = $(this).data('sid');
            var netpay=0;
            var withold=0;
            var vatamnt=0;
            var outstanding=0;
            var settledamount=0;
            var grandtotals=0;
            var grandtotalpur=0;
            var fiscalyr=$('#fiscalyear').val();
            getcussalessett(recordId,fiscalyr);
            $.get("/showCreditSales" + '/' + recordId+'/'+storeIds+'/'+fiscalyr, function(data) {
                $('#creditsalesinfolbl').html("<i>("+data.fymonthrange+")<i>");
                $('#settledamountinfolbl').html("<i>("+data.fymonthrange+")<i>");
                $.each(data.setdata, function(key, value) {
                    $('#poslbl').text(value.POS);
                });

                $.each(data.withsett, function(key, value) {
                    withold=value.WitholdAmount;
                });

                $.each(data.vatsett, function(key, value) {
                    vatamnt=value.VatAmount;
                });

                $.each(data.settpricing, function(key, value) {
                    settledamount=value.SettlementAmount;
                });

                $.each(data.pricing, function(key, value) {
                    grandtotals=value.GrandTotal;
                });

                $.each(data.pricingfy, function(index, value) {
                    creditsalesfy=value.GrandTotal;
                });
                $.each(data.withsettfy, function(index, value) {
                    witholdfy=value.WitholdAmount;
                });
                $.each(data.vatsettfy, function(index, value) {
                    vatfy=value.VatAmount;
                });

                $.each(data.recpricing, function(key, value) {
                    grandtotalpur=value.GrandTotal;
                });

                netpay=parseFloat(grandtotals)-parseFloat(withold)-parseFloat(vatamnt);
                netpayfy=parseFloat(creditsalesfy)-parseFloat(witholdfy)-parseFloat(vatfy);

                outstanding=(parseFloat(netpayfy)+parseFloat(netpay))-parseFloat(settledamount);
                $('#totalbalanceLbl').text(numformat(netpay.toFixed(2)));
                $('#settledbalanceLbl').text(numformat(settledamount.toFixed(2)));
                $('#outstandingbalanceLbl').text(numformat(outstanding.toFixed(2)));
                $('#totalbalancepurLbl').text(numformat(grandtotalpur.toFixed(2))); 

                $.each(data.crSales, function(key, value) {
                    var settleoutstanding=value.SettleAllOutstanding;
                    var isunlimitedcrsales=value.CreditSalesLimitFlag;
                    var permittedamount=parseFloat(value.CreditSalesLimitEnd)-parseFloat(netpay);
                    $('#customerId').val(value.CustomerId);
                    $('#customercodeLbl').text(value.Code);
                    $('#customernameLbl').text(value.Name);
                    $('#customertinnumberLbl').text(value.TinNumber);
                    $('#customervatnumberLbl').text(value.VatNumber);
                    $('#customerphonenumberLbl').html(value.PhoneNumber+"       ,       "+value.OfficePhone);
                    $('#creditminsalesinfo').text(numformat(value.CreditSalesLimitStart));
                    $('#creditsaleslimitdayinfo').text(value.CreditSalesLimitDay);
                    $('#creditsalesadditioninfo').text(value.CreditSalesAdditionPercentage);
                    
                    if(isunlimitedcrsales=="1"){
                        $('#creditmaxsalesinfo').text("Unlimited");
                        $('#availableamntcr').text("Unlimited");
                    }
                    if(isunlimitedcrsales=="0"){
                        $('#creditmaxsalesinfo').text(numformat(value.CreditSalesLimitEnd));
                        $('#availableamntcr').text(numformat(permittedamount));
                    }
                    if(settleoutstanding=="1"){
                        $('#settleoutstandinginfo').html("Yes");
                    }
                    if(settleoutstanding=="0"){
                        $('#settleoutstandinginfo').html("No");
                    }
                });
            });

            $('#customersettlementtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "ordering": false,
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
                    url: '/showcussett/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    { data:'DT_RowIndex'},
                    {
                        data: 'POS',
                        name: 'POS',
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber'
                    },
                    {
                        data: 'invoiceNo',
                        name: 'invoiceNo'
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate'
                    },
                    {
                        data: 'settlementexpiredate',
                        name: 'settlementexpiredate'
                    },
                    {
                        data: 'CRVNumbers',
                        name: 'CRVNumbers',
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;" onclick=crvdetailFn("'+row.VoucherNumber+'","'+row.StoreId+'")>'+data+'</a>';
                        } 
                    },
                    {
                        data: 'CreditSales',
                        name: 'CreditSales',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'SettledAmounts',
                        name: 'SettledAmounts',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'OustandingBalance',
                        name: 'OustandingBalance',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'PaymentStatus',
                        name: 'PaymentStatus'
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        'visible': false
                    },
                    {
                        data: 'setlmentstatus',
                        name: 'setlmentstatus',
                        'visible': false
                    },
                    {
                        data: 'RemainingDate',
                        name: 'RemainingDate',
                        'visible': false
                    },
                    {
                        data: 'StoreId',
                        name: 'StoreId',
                        'visible': false
                    },
                     {
                        data: 'Monthrange',
                        name: 'Monthrange',
                        'visible': false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        'visible': false
                    }
                ],
                order: [[1, 'asc'], [4, 'asc']],
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var color = 'style="color:black;font-weight:bold;"';
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="11" style="text-align:left;"><b>Fiscal Year : ' + group + ' </b></td></tr>')
                        }
                        if(level===1){
                            return $('<tr>')
                            .append('<td colspan="11" style="text-align:left;"><b>POS : ' + group + ' </b></td></tr>')
                        }
                        else{
                            return $('<tr>')
                            .append('<td colspan="11" style="text-align:center;"> ' + group + '</td></tr>')
                        }                            
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var totalsettled = rows
                        .data()
                        .pluck('SettledAmounts')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        var totaloutstanding = rows
                        .data()
                        .pluck('OustandingBalance')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        var totalcreditsales = rows
                        .data()
                        .pluck('CreditSales')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        var color = 'style="color:black;font-weight:bold;"';

                        if(level===0){
                            return $('<tr style="font-weight:bold;">')  
                            .append('<td colspan="7" style="text-align:right;">Total of : ' + group+ '</td>') 
                            .append('<td style="text-align:left;">'+ numformat(totalcreditsales.toFixed(2))+'</td>')
                            .append('<td style="text-align:left;">'+ numformat(totalsettled.toFixed(2))+'</td>')
                            .append('<td style="text-align:left;">'+ numformat(totaloutstanding.toFixed(2))+'</td></tr>'); 
                        }  
                        else if(level===1){
                            return $('<tr style="font-weight:bold;"><td colspan="7" style="text-align:right;">Total of : '+group+'</td><td style="text-align:left;">'+ numformat(totalcreditsales.toFixed(2))+'</td><td style="text-align:left;">'+ numformat(totalsettled.toFixed(2))+'</td><td style="text-align:left;">'+ numformat(totaloutstanding.toFixed(2))+'</td></tr><tr><td colspan="11" style="height:0.5rem !important;background-color:white;border-left-color: white;border-right-color: white;"></td></tr>'); 
                        }
                    },
                    dataSrc: ['Monthrange','POS']
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    // if (aData.Status == "pending..") {
                    //     $(nRow).find('td:eq(10)').css({"color": "#f6c23e","font-weight": "bold"});
                    // } 
                    // else if (aData.Status == "Checked") {
                    //     $(nRow).find('td:eq(10)').css({"color": "#4e73df","font-weight": "bold"});
                    // } 
                    // else if (aData.Status == "Confirmed") {
                    //     $(nRow).find('td:eq(10)').css({"color": "#1cc88a","font-weight": "bold"});
                    // }
                    // else if (aData.Status == "Void") {
                    //     $(nRow).find('td:eq(10)').css({"color": "#e74a3b","font-weight": "bold"});
                    // }
                    if (aData.SettledAmounts == 0|| aData.SettledAmounts==null) {
                        $(nRow).find('td:eq(10)').css({"color": "#e74a3b","font-weight": "bold"});
                    } 
                    else if (aData.SettledAmounts >0 && aData.OustandingBalance != 0) {
                        $(nRow).find('td:eq(10)').css({"color": "#f6c23e","font-weight": "bold"});
                    } 
                    else if (aData.SettledAmounts >0 && aData.OustandingBalance == 0) {
                        $(nRow).find('td:eq(10)').css({"color": "#1cc88a","font-weight": "bold"});
                    } 
                    if(parseFloat(aData.RemainingDate)>=0 && parseFloat(aData.RemainingDate)<=30 && aData.OustandingBalance != 0){
                        $(nRow).find('td:eq(5)').css({"color": "#f6c23e","font-weight": "bold"});
                    }
                    else if(parseFloat(aData.RemainingDate)<0 && aData.OustandingBalance != 0){
                        $(nRow).find('td:eq(5)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
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
                    var totalcr = api
                        .column( 8 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var totalsett = api
                        .column( 9 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var outstandingsett = api
                        .column( 10 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        
                    var totaloutstandinig=parseFloat(totalcr)-parseFloat(totalsett);
                    $("#totalcrlblcus").html(numformat(totalcr.toFixed(2)));
                    $("#totalsettlblcus").html(numformat(totalsett.toFixed(2)));
                    $("#outstandingsettlblcus").html(numformat(totaloutstandinig.toFixed(2)));
                }
            });

            $("#inlineForm").modal('show');
            $(".infoscl").collapse('show');
        }
        //End open modal

        //start open settlement info
        //$('body').on('click', '.settlementInfo', function() {
            
        function settlementInfo(recordId){
            //var recordId = $(this).data('id');
            var netpay=0;
            var withold=0;
            var vatamnt=0;
            var outstanding=0;
            var settledamount=0;
            var grandtotals=0;
            var grandtotalpur=0;
            $('#settlementinfotitle').html("Sales Settlement Detail Information");
            $("#statusid").val(recordId);
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                $.each(data.withsett, function(key, value) {
                    withold=value.WitholdAmount;
                });

                $.each(data.vatsett, function(key, value) {
                    vatamnt=value.VatAmount;
                });

                $.each(data.settpricing, function(key, value) {
                    settledamount=value.SettlementAmount;
                });

                $.each(data.pricing, function(key, value) {
                    grandtotals=value.GrandTotal;
                });
                netpay=parseFloat(grandtotals)- parseFloat(withold)-parseFloat(vatamnt);
                outstanding=parseFloat(netpay)-parseFloat(settledamount);
                $.each(data.settlist, function(key, value) {
                    $("#statusIds").val(value.Status);
                    $("#statusid").val(value.id);
                    $('#customercodeLblslrec').text(value.CustomerCode);
                    $('#customernameLblslrec').text(value.CustomerName);
                    $('#customertinnumberLblslrec').text(value.CustomerTIN);
                    $('#customerphonenumberlbl').html(value.PhoneNumber+"           ,          "+value.OfficePhone);
                    $('#customervatnumberLblslrec').text(value.VAT);
                    $('#posnamelblrec').text(value.POS);
                    $('#crvnumberinfolbl').text(value.CrvNumber);
                    $('#crvdateinoflbl').text(value.DocumentDate);
                    $('#preparedbylblinfo').text(value.SettledBy);
                    $('#prepareddatelblinfo').text(value.CreatedDateTime);
                    $('#verifiedbylblinfo').text(value.VerifiedBy);
                    $('#verifieddatelblinfo').text(value.VerifiedDate);
                    $('#confirmedbylblinfo').text(value.ConfirmedBy);
                    $('#confirmeddatelblinfo').text(value.ConfirmedDate);
                    $('#topendingbylblinfo').text(value.ChangeToPendingBy);
                    $('#topendingdatelblinfo').text(value.ChangeToPendingDate);
                    $('#voidbylblinfo').text(value.VoidBy);
                    $('#voiddatelblinfo').text(value.VoidDate);
                    $('#voidreasonlblinfo').text(value.VoidReason);
                    $('#undovoidbylblinfo').text(value.UndoVoidBy);
                    $('#undovoiddatelblinfo').text(value.UndoVoidDate);
                    $('#lasteditedbylblinfo').text(value.LastEditedBy);
                    $('#lastediteddatelblinfo').text(value.LastEditedDate);
                    $('#cusoutstandinglblinfo').text(numformat(value.OutstandingAmount.toFixed(2)));
                    $('#custotalunpaidlblinfo').text(numformat(value.UnSettlementAmount.toFixed(2)));
                    $('#creditminsalesinfost').text(numformat(value.CreditSalesLimitStart));
                    $('#creditsaleslimitdayinfost').text(value.CreditSalesLimitDay);
                    $('#creditsalesadditioninfost').text(value.CreditSalesAdditionPercentage);
                    $('#memolblinfo').text(value.Memo);
                    var statusvals=value.StatusName;
                    var settstatus=value.Status;
                    var settleoutstanding=value.SettleAllOutstanding;
                    var isunlimitedcrsales=value.CreditSalesLimitFlag;
                    var permittedamount=parseFloat(value.CreditSalesLimitEnd)-parseFloat(netpay);
                    if(isunlimitedcrsales=="1"){
                        $('#creditmaxsalesinfost').text("Unlimited");
                        $('#availableamntcrst').text("Unlimited");
                    }
                    if(isunlimitedcrsales=="0"){
                        $('#creditmaxsalesinfost').text(numformat(value.CreditSalesLimitEnd));
                        $('#availableamntcrst').text(numformat(permittedamount));
                    }
                    if(settleoutstanding=="1"){
                        $('#settleoutstandinginfost').html("Yes");
                    }
                    if(settleoutstanding=="0"){
                        $('#settleoutstandinginfost').html("No");
                    }
                    if(parseFloat(settstatus)==1){
                        $("#changetopending").hide();
                        $("#verifysettlementbtn").show();
                        $("#confirmsettlement").hide();
                        $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+statusvals+"</span>");
                    }
                    else if(parseFloat(settstatus)==2){
                        $("#changetopending").show();
                        $("#verifysettlementbtn").hide();
                        $("#confirmsettlement").show();
                        $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>"+statusvals+"</span>");
                    }
                    else if(parseFloat(settstatus)==3){
                        $("#changetopending").hide();
                        $("#verifysettlementbtn").hide();
                        $("#confirmsettlement").hide();
                        $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+statusvals+"</span>");
                    }
                    else{
                        $("#changetopending").hide();
                        $("#verifysettlementbtn").hide();
                        $("#confirmsettlement").hide();
                        $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+statusvals+"</span>");
                    }
                });
            });

            $('#settlementdetailtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
               
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
                    url: '/showdetailtransactions/' + recordId,
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
                        data: 'FSNumber',
                        name: 'FSNumber',
                        'visible': false
                    },
                    {
                        data: 'InvoiceNumber',
                        name: 'InvoiceNumber',
                        'visible': false
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate',
                        'visible': false
                    },
                    {
                        data: 'RemainingDate',
                        name: 'RemainingDate',
                        'visible': false
                    },
                    {
                        data: 'PaymentType',
                        name: 'PaymentType'
                    },
                    {
                        data: 'BankName',
                        name: 'BankName'
                    },
                    {
                        data: 'AccountNumber',
                        name: 'AccountNumber'
                    },
                    {
                        data: 'BankTransferNumber',
                        name: 'BankTransferNumber'
                    },
                    {
                        data: 'SettlementAmount',
                        name: 'SettlementAmount',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'SettStatus',
                        name: 'SettStatus',
                    }, 
                    {
                        data: 'Remark',
                        name: 'Remark',
                    },
                    {
                        data: 'SettlementStatus',
                        name: 'SettlementStatus',
                        'visible': false
                    }, 
                    {
                        data: 'TotalGroup',
                        name: 'TotalGroup',
                        'visible': false
                    }, 
                ],
                
                rowGroup: {
                    startRender: function (rows,group,level) {
                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        var firstRowData = rows.data().eq(0);
                        var text=group;
                        text = text.replace("bl", "<br>");
                        text = text.replace("Settled", "<b style='color:#1cc88a'>Settled</b>");
                        text = text.replace("Partially-Settled", "<b style='color:#f6c23e'>Partially-Settled</b>");
                        text = text.replace("Not-Settled", "<b style='color:#e74a3b'>Not-Settled</b>");
                        text = text.replace("bl", "<br>");
                        return $('<tr>').html('<td colspan="10" style="text-align:left;"><b>' + text +'</b></td></tr>');                       
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };
                        var totalsettled = rows
                        .data()
                        .pluck('SettlementAmount')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        var fsnum = rows
                        .data()
                        .pluck('FSNumber')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0)/ rows.count(); 

                        var color = 'style="color:black;font-weight:bold;"';
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="5" style="text-align:right;">Total of : ' + padWithLeadingZeros(fsnum, 8)+ '</td>') 
                            .append('<td style="text-align:left;">'+ numformat(totalsettled.toFixed(2))+'</td></tr>');
                        }  
                        else{
                        return $('<tr>')
                            .append('<td colspan="5" style="text-align:right;">Total of : ' + padWithLeadingZeros(fsnum, 8)+ '</td>') 
                            .append('<td style="text-align:left;">'+ numformat(totalsettled.toFixed(2))+'</td></tr>');
                        }
                    },
                    dataSrc: ['TotalGroup']
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var grandtotalsettled = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    $('#custotalsettledlblinfo').text(numformat(grandtotalsettled.toFixed(2)));
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.SettlementStatus == 0) {
                        $(nRow).find('td:eq(6)').css({"color": "#e74a3b","font-weight": "bold"}); 
                    } 
                    else if (aData.SettlementStatus == 1) {
                        $(nRow).find('td:eq(6)').css({"color": "#f6c23e","font-weight": "bold"}); 
                    } 
                    else if (aData.SettlementStatus == 2) {
                        $(nRow).find('td:eq(6)').css({"color": "#1cc88a","font-weight": "bold"});
                    }
                }
            });
            
            $("#showmorebtn").show();
            $("#showlessbtn").hide();
            $(".crpropinfo").hide();
            $(".infodocrec").collapse('show');
            $("#settlementrecordInfo").modal('show');
        }
        //end open settlement info

        function padWithLeadingZeros(num, totalLength) {
            return String(num).padStart(totalLength, '0');
        }
        //start double click on datatable

        // $(document).on("click", "#detailtransaction tr", function () {
        //     var recordId = $(this).data('id');
        // });
        //end double click on datatable

        //start open settlement info modal
        $('body').on('click', '.settlementSingleBtn', function() {
            $("#settlementSingleTrInfo").modal('show');
            var recordId = $(this).data('id');
            $.get("/getSettlementEdit" + '/' + recordId, function(data) {
                var len = data.sett.length;
                for (var i = 0; i <= len; i++) {
                    $('#paymenttypeinfo').text(data.sett[i].PaymentType);
                    $('#crvnumberinfo').text(data.sett[i].CrvNumber);
                    $('#banknameinfo').text(data.sett[i].BankName);
                    $('#chequenumberinfo').text(data.sett[i].ChequeNumber);
                    $('#settlementamntinfo').text(numformat(data.sett[i].SettlementAmount.toString().match(/^\d+(?:\.\d{0,2})?/)));
                    $('#settledbyinfo').text(data.sett[i].SettledBy);
                    $('#transactiondateinfo').text(data.sett[i].TransactionDate);
                    $('#voidbyinfo').text(data.sett[i].VoidBy);
                    $('#voiddateinfo').text(data.sett[i].VoidDate);
                    $('#voidreasoninfo').text(data.sett[i].VoidReason);
                    $('#memoinfo').text(data.sett[i].Memo);
                    var isvoid = data.sett[i].IsVoid;
                    if (isvoid == 0) {
                        $('#voidbytr').hide();
                        $('#voiddatetr').hide();
                        $('#voidreasontr').hide();
                    } else if (isvoid == 1) {
                        $('#voidbytr').show();
                        $('#voiddatetr').show();
                        $('#voidreasontr').show();
                    }
                }
            });
        });
        //end open settlement info modal

        //start open settlement info modal
        $('body').on('click', '.settlementSalesBtn', function() {
            $("#settlementSalesInfo").modal('show');
            var recordId = $(this).data('id');
            $.get("/getSettlementSales" + '/' + recordId, function(data) {
                var len = data.salesinfo.length;
                for (var i = 0; i <= len; i++) {
                    $('#customercategoryinfo').text(data.salesinfo[i].CustomerCategory);
                    $('#customernameinfo').text(data.salesinfo[i].Name);
                    $('#customercodeinfo').text(data.salesinfo[i].Code);
                    $('#customertinnuminfo').text(data.salesinfo[i].TinNumber);
                    $('#customervatnuminfo').text(data.salesinfo[i].VatNumber);
                    $('#salespaymenttypeinfo').text(data.salesinfo[i].PaymentType);
                    $('#salesvouchertypeinfo').text(data.salesinfo[i].VoucherType);
                    $('#salesvouchernuminfo').text(data.salesinfo[i].VoucherNumber);
                    $('#salesmrcnuminfo').text(data.salesinfo[i].CustomerMRC);
                    $('#salesposinfo').text(data.salesinfo[i].StoreName);
                    $('#salessubtotalinfo').text(numformat(data.salesinfo[i].SubTotal.toString().match(/^\d+(?:\.\d{0,2})?/)));
                    $('#salestaxinfo').text(numformat(data.salesinfo[i].Tax.toString().match(/^\d+(?:\.\d{0,2})?/)));
                    $('#salesgrandtotalinfo').text(numformat(data.salesinfo[i].GrandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)));
                    $('#saleswitholdinginfo').text(numformat(data.salesinfo[i].WitholdAmount.toString().match(/^\d+(?:\.\d{0,2})?/)));
                    $('#salesvatinfo').text(numformat(data.salesinfo[i].Vat.toString().match(/^\d+(?:\.\d{0,2})?/)));
                    $('#salesnetpayinfo').text(numformat(data.salesinfo[i].NetPay.toString().match(  /^\d+(?:\.\d{0,2})?/)));
                    $('#salesuserinfo').text(data.salesinfo[i].Username);
                    $('#salestransactiondateinfo').text(data.salesinfo[i].CreatedDate);
                    $('#salescreateddateinfo').text(data.salesinfo[i].CrDate);
                    $('#salescheckedbyinfo').text(data.salesinfo[i].CheckedBy);
                    $('#salescheckeddateinfo').text(data.salesinfo[i].CheckedDate);
                    $('#salesconfirmbyinfo').text(data.salesinfo[i].ConfirmedBy);
                    $('#salesconfirmdateinfo').text(data.salesinfo[i].ConfirmedDate);
                    $('#saleschangetopendinginfo').text(data.salesinfo[i].ChangeToPendingBy);
                    $('#saleschangetopendingdateinfo').text(data.salesinfo[i].ChangeToPendingDate);
                    $('#salesrefundbyinfo').text(data.salesinfo[i].RefundBy);
                    $('#salesrefunddateinfo').text(data.salesinfo[i].RefundDate);
                    $('#saleswitholdreceiptinfo').text(data.salesinfo[i].witholdNumber);
                    $('#salesvatreceiptinfo').text(data.salesinfo[i].vatNumber);
                    $('#salesundovoidbyinfo').text(data.salesinfo[i].UnvoidBy);
                    $('#salesundovoiddateinfo').text(data.salesinfo[i].UnVoidDate);
                    $('#salesvoidbyinfo').text(data.salesinfo[i].VoidedBy);
                    $('#salesvoiddateinfo').text(data.salesinfo[i].VoidedDate);
                    $('#salesvoidreasoninfo').text(data.salesinfo[i].VoidReason);
                    // var isvoid=data.salesinfo[i].IsVoid;
                    // if(isvoid==0)
                    // {
                    //     $('#voidbytr').hide();
                    //     $('#voiddatetr').hide();
                    //     $('#voidreasontr').hide();
                    // }
                    // else if(isvoid==1)
                    // {
                    //     $('#voidbytr').show();
                    //     $('#voiddatetr').show();
                    //     $('#voidreasontr').show();
                    // }
                }
            });
        });
        //end open settlement info modal

        //Start page load
        $(document).ready(function() {
            $('#fiscalyear').select2();
            getallbalance(fyears);
            getSettlement(fyears);
            getCreditSales(fyears);
            getallpurchasebl();
            getsalesperstore(fyears);
        });

        function getSettlement(fyears){
            var table =$('#laravel-datatable-crudsett').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "lengthMenu": [50,100],
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
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/salessettlementlist/'+fyears,
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
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'Code',
                        name: 'Code',
                    },
                    {
                        data: 'CustomerName'
                    },
                    {
                        data: 'TIN'
                    },
                    {
                        data: 'POS'
                    },
                    {
                        data: 'CrvNumber'
                    },
                    {
                        data: 'FSNumber'
                    },
                    {
                        data: 'InvoiceNumber'
                    },
                    {
                        data: 'CRVDate'
                    },
                    {
                        data: 'StatusVal'
                    },
                    {
                        data: 'Status',
                        'visible': false
                    },
                    {
                        data: 'action'
                    }
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == 1) {
                        $(nRow).find('td:eq(9)').css({
                            "color": "#f6c23e",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #f6c23e"
                        });
                    } else if (aData.Status == 2) {
                        $(nRow).find('td:eq(9)').css({
                            "color": "#4e73df",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #4e73df"
                        });
                    } else if (aData.Status == 3) {
                        $(nRow).find('td:eq(9)').css({
                            "color": "#1cc88a",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #1cc88a"
                        });
                    } else if (aData.Status == 4||aData.Status == 5||aData.Status == 6||aData.Status == 7) {
                        $(nRow).find('td:eq(9)').css({
                            "color": "#e74a3b",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #e74a3b"
                        });
                    }
                }
            });
        }

        function getCreditSales(fyears){
            $('#laravel-datatable-crud').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-4'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/settlementList/'+fyears,
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
                        data: 'CustomerId',
                        name: 'CustomerId',
                        'visible': false
                    },
                     {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'Code',
                        name: 'Code',
                    },
                    {
                        data: 'CustomerCategory',
                        name: 'CustomerCategory',
                        'visible': false
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'TinNumber',
                        name: 'TinNumber',
                    },
                    {
                        data: 'DefaultPrice',
                        name: 'DefaultPrice',
                        'visible': false
                    },
                    {
                        data: 'TotalNetPay',
                        name: 'TotalNetPay',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'SettledAmounts',
                        name: 'SettledAmounts',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'OustandingBalance',
                        name: 'OustandingBalance',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Pending") {
                        // $(nRow).find('td:eq(9)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                    } else if (aData.Status == "Checked") {
                        //$(nRow).find('td:eq(9)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                    } else if (aData.Status == "Confirmed") {
                        // $(nRow).find('td:eq(9)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    } else if (aData.Status == "Void") {
                        // $(nRow).find('td:eq(9)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                    }
                }
            }); 
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

        $('#laravel-datatable-crudsett tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
        $('body').on('click', '#settleBtn', function() {
            var registerForm = $('#Register');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/settleSales',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#settleBtn').text('Saving...');
                    $('#settleBtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.PaymentType) {
                            $('#paymenttype-error').html(data.errors.PaymentType[0]);
                        }
                        if (data.errors.CrvNumber) {
                            $('#crvno-error').html(data.errors.CrvNumber[0]);
                        }
                        if (data.errors.date) {
                            $('#date-error').html(data.errors.date[0]);
                        }
                        if (data.errors.SettlementAmount) {
                            $('#settlementamount-error').html(data.errors.SettlementAmount[0]);
                        }
                        if (data.errors.bank) {
                            $('#bank-error').html(data.errors.bank[0]);
                        }
                        if (data.errors.ChequeNumber) {
                            $('#chequeno-error').html(data.errors.ChequeNumber[0]);
                        }
                        $('#settleBtn').text('Save');
                        $('#settleBtn').prop("disabled", false);
                        $("#myToast").toast({
                            delay: 10000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Check Your Inputs");
                        $('.toast-body').css({
                            "background-color": "	#dc3545",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                    }
                    if (data.success) {
                        $('#settleBtn').text('Save');
                        $('#settleBtn').prop("disabled", false);
                        $("#myToast").toast({
                            delay: 4000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Successful");
                        $('.toast-body').css({
                            "background-color": "	#28a745",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                        $("#Register")[0].reset();
                        var oTable = $('#settledSales').dataTable();
                        oTable.fnDraw(false);
                        closeAll();
                        var dc = data;
                        var len = data.crSales.length;
                        for (var i = 0; i <= len; i++) {
                            $('#totalbalanceLbl').text(numformat(data.pricing[i].SubTotal));
                            $('#settledbalanceLbl').text(numformat(data.settpricing[i]
                                .SettlementAmount));
                            var totalcredit = data.pricing[i].SubTotal;
                            var settledval = data.settpricing[i].SettlementAmount;
                            var outstandingval = parseFloat(totalcredit) - parseFloat(settledval);
                            $('#outstandingbalanceLbl').text(numformat(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                            
                            $('#outstandingTxt').val(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/));
                            $('#OutstandingBalance').val(numformat(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                        }

                    }
                }
            });
        });

        $('body').on('click', '#settleEdtBtn', function() {
            var registerForm = $('#editSettlementForm');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/settleSalesupd',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#settleEdtBtn').text('Updating...');
                    $('#settleEdtBtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.PaymentType) {
                            $('#paymenttypeed-error').html(data.errors.PaymentType[0]);
                        }
                        if (data.errors.CrvNumber) {
                            $('#crvnoed-error').html(data.errors.CrvNumber[0]);
                        }
                        if (data.errors.date) {
                            $('#dateed-error').html(data.errors.date[0]);
                        }
                        if (data.errors.SettlementAmount) {
                            $('#settlementamounted-error').html(data.errors.SettlementAmount[0]);
                        }
                        if (data.errors.bank) {
                            $('#banked-error').html(data.errors.bank[0]);
                        }
                        if (data.errors.ChequeNumber) {
                            $('#chequenoed-error').html(data.errors.ChequeNumber[0]);
                        }
                        $('#settleEdtBtn').text('Update');
                        $('#settleEdtBtn').prop("disabled", false);
                        $("#myToast").toast({
                            delay: 10000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Check Your Inputs");
                        $('.toast-body').css({
                            "background-color": "	#dc3545",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                    }
                    if (data.success) {
                        $('#settleEdtBtn').text('Update');
                        $('#settleEdtBtn').prop("disabled", false);
                        $("#myToast").toast({
                            delay: 4000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Successful");
                        $('.toast-body').css({
                            "background-color": "	#28a745",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                        $("#editSettlementForm")[0].reset();
                        var oTable = $('#settledSales').dataTable();
                        oTable.fnDraw(false);
                        closeSettlementEdit();
                        $("#settlementEdit").modal('hide');
                        var dc = data;
                        var len = data.crSales.length;
                        for (var i = 0; i <= len; i++) {
                            $('#totalbalanceLbl').text(numformat(data.pricing[i].SubTotal));
                            $('#settledbalanceLbl').text(numformat(data.settpricing[i]
                                .SettlementAmount));
                            var totalcredit = data.pricing[i].SubTotal;
                            var settledval = data.settpricing[i].SettlementAmount;
                            var outstandingval = parseFloat(totalcredit) - parseFloat(settledval);
                            $('#outstandingbalanceLbl').text(numformat(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                           
                            $('#outstandingTxt').val(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/));
                            $('#OutstandingBalance').val(numformat(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                        }
                    }
                }
            });
        });

        $('#voidbtns').click(function() {
            var registerForm = $('#voidform');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/voidSettlement',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#voidbtn').text('Voiding...');
                    $('#voidbtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.Reason) {
                            $('#reason-error').html(data.errors.Reason[0]);
                        }
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled", false);
                        $("#myToast").toast({
                            delay: 10000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Check Your Inputs");
                        $('.toast-body').css({
                            "background-color": "	#dc3545",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                    }
                    if (data.success) {
                        $('#voidbtn').text('Void');
                        $('#voidbtn').prop("disabled", false);
                        $("#myToast").toast({
                            delay: 4000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Successful");
                        $('.toast-body').css({
                            "background-color": "	#28a745",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                        $("#voidform")[0].reset();
                        var oTable = $('#settledSales').dataTable();
                        oTable.fnDraw(false);
                        reasonClVal();
                        $("#voidModal").modal('hide');
                        var dc = data;
                        var len = data.crSales.length;
                        for (var i = 0; i <= len; i++) {
                            $('#totalbalanceLbl').text(numformat(data.pricing[i].SubTotal));
                            $('#settledbalanceLbl').text(numformat(data.settpricing[i]
                                .SettlementAmount));
                            var totalcredit = data.pricing[i].SubTotal;
                            var settledval = data.settpricing[i].SettlementAmount;
                            var outstandingval = parseFloat(totalcredit) - parseFloat(settledval);
                            $('#outstandingbalanceLbl').text(numformat(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));

                            $('#outstandingTxt').val(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/));
                            $('#OutstandingBalance').val(numformat(outstandingval.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                        }

                    }
                }
            });
        });

        $(document).on('click', '.settlementEditBtn', function() {
            $("#settlementEdit").modal('show');
            var recordId = $(this).data('id');
            $("#settId").val(recordId);
            $("#outstandingEditTxt").val($("#outstandingTxt").val());
            $("#customeredId").val($("#customerId").val());
            $.get("/getSettlementEdit" + '/' + recordId, function(data) {
                var len = data.sett.length;
                for (var i = 0; i <= len; i++) {
                    $('#PaymentTypeEd').selectpicker('val', data.sett[i].PaymentType).trigger('change');
                    $('#ChequeNumbered').val(data.sett[i].ChequeNumber);
                    $('#CrvNumbered').val(data.sett[i].CrvNumber);
                    $('#dateed').val(data.sett[i].TransactionDate);
                    $('#SettlementAmounted').val(data.sett[i].SettlementAmount);
                    $('#Memoed').val(data.sett[i].Memo);
                    var bn = data.sett[i].BankName;
                    var options = "<option selected value='" + bn + "'>" + bn + "</option>";
                    $("#banked").append(options);
                    $('#banked').selectpicker('refresh');
                    var outst = $("#outstandingEditTxt").val();
                    var settam = data.sett[i].SettlementAmount;
                    var totalout = parseFloat(outst) + parseFloat(settam);
                    $("#outstandingEditTotalTxt").val(totalout);
                }
            });
        });

        $(document).on('click', '.settlementVoidBtn', function() {
            $("#voidModal").modal('show');
            var recordId = $(this).data('id');
            $("#voidid").val(recordId);
        });

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        function closeModalWithClearValidation(){
            $('#PointOfSales').val(null).trigger('change');
            $('#Customer').empty();
            $('#FSNumbers').empty();
            $('#settlementId').val("");
            $('#CrvNumber').val("");
            $('#date').val("");
            $('#Memo').val("");
            $('#store-error').html("");
            $('#customer-error').html("");
            $('#crvno-error').html("");
            $('#date-error').html("");
            $('#memo-error').html("");
            $('#categoryInfoLbl').html("");
            $('#nameInfoLbl').html("");
            $('#tinInfoLbl').html("");
            $('#vatInfoLbl').html("");
            $('#customerinfobtn').hide();
            $('#infoCardDiv').hide();
            $('#dynamicTable tbody').empty();
            $('#pricingTable').hide();
            $('#totaloutstandingi').val("");
            $('#custotalsettledi').val("");
            $('#custotalunpaidi').val("");
            $('#cusoutstandinglbl').html("");
            $('#custotalsettledlbl').html("");
            $('#custotalunpaidlbl').html("");
            $('#operationtypes').val("1");
            $('#MaxDate').val("");
            $('#CreditSalesDate').val("");
            $('#isnewVal').val("0");
        }

        function paymentTypeVals() {
            $('#paymenttype-error').html("");
            var pt = $('#PaymentType').val();
            if (pt === "Cash") {
                $('#banknamediv').hide();
                $('#chequenumdiv').hide();
                $('#bank').val(null).trigger('change');
                $('#ChequeNumber').val("");
                $('#chequeno-error').html("");
                $('#bank-error').html("");
            } else if (pt === "Cheque") {
                $('#banknamediv').show();
                $('#chequenumdiv').show();
            }
        }

        function paymentTypeValEd() {
            $('#paymenttypeed-error').html("");
            var pt = $('#PaymentTypeEd').val();
            if (pt === "Cash") {
                $('#banknameeddiv').hide();
                $('#chequenumeddiv').hide();
                $('#banked').val(null).trigger('change');
                $('#ChequeNumbered').val("");
                $('#chequenoed-error').html("");
                $('#banked-error').html("");
            } else if (pt === "Cheque") {
                $('#banknameeddiv').show();
                $('#chequenumeddiv').show();
            }
        }

        function crvnumVal() {
            $('#crvno-error').html("");
        }

        function dateVal() {
            var selecteddate=$('#date').val();
            var startdate=$('#CreditSalesDate').val();
            var enddate=$('#MaxDate').val();
            var customerval=$('#Customer').val();
            
            if(selecteddate<startdate){
                $('#date-error').html("The date must be a date after or equal to "+startdate);
                toastrMessage('error',"Please check your inputs","Error");
                $('#date').val("");
            }
            if(selecteddate>enddate){
                $('#date-error').html("The date must be a date before or equal to "+enddate);
                toastrMessage('error',"Please check your inputs","Error");
                $('#date').val("");
            }
            if(isNaN(parseFloat(customerval))){
                $('#date-error').html("Please select customer before selecting CRV date");
                $('#customer-error').html("Customer selection is mandatory to select CRV date");
                toastrMessage('error',"Please check your inputs","Error");
                $('#date').val("");
            }
            else if(selecteddate>=startdate && selecteddate<=enddate){ 
                for(var k=m;k>=1;k--){
                    var expiredateval=($('#expdatei'+k)).val();
                    var rowid=($('#vals'+k)).val();
                    if(($('#expdatei'+k).val())!=undefined){
                        if(selecteddate<expiredateval){
                            var salesidvar=($('#salesids'+k)).text();
                            $("#rowind"+rowid).remove();
                            salesidarr.splice(0, 0, salesidvar);
                        }
                    }
                }
                for(var l=1;l<=m;l++){
                    var expiredt=($('#settexpdatei'+l)).val();
                    var remainingdt=dateDiffInDays(expiredt,selecteddate);
                    $('#RemainingDay'+l).val(remainingdt);
                }
                var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
                var salesidrow=($('#FSInvNumber'+lastrowcount)).val();
                if(isNaN(parseFloat(salesidrow))){
                    $("#rowind"+lastrowcount).remove();
                }
                var lastrownewt=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
                $('#removebtn'+lastrownewt).prop("disabled",false);
                $('#SettlementAmount'+lastrownewt).prop("readonly",false);
                $('#SettlementAmount'+lastrownewt).css("background", "white");
                $('#lblarr').text(unique(salesidarr));
                unique(salesidarr);
                CalculateGrandTotal();
                renumberRows();
                $('#date-error').html("");
            }
        }

        function chequenumVal() {
            $('#chequeno-error').html("");
        }

        function bankVal() {
            $('#bank-error').html("");
            $('#banked-error').html("");
        }

        function reasonVal() {
            $('#reason-error').html("");
        }

        function reasonClVal() {
            $('#reason-error').html("");
            $('#Reason').val("");
        }

        function storeVal() {
            $('#store-error').html("");
        }

        function settlementVal() {
            var ob = $('#outstandingTxt').val();
            var sa = $('#SettlementAmount').val();
            if (parseFloat(sa) == 0) {
                $("#myToast").toast({
                    delay: 10000
                });
                $("#myToast").toast('show');
                $('#toast-massages').html("Invalid input");
                $('.toast-body').css({
                    "background-color": "	#dc3545",
                    "color": "white",
                    "font-weight": "bold",
                    "font-size": "15px",
                    "border-radius": "15px"
                });
                $('#SettlementAmount').val("");
            } else {
                if (parseFloat(sa) > parseFloat(ob)) {
                    $("#myToast").toast({
                        delay: 10000
                    });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Settlement amount cant greater than outstanding balance");
                    $('.toast-body').css({
                        "background-color": "	#dc3545",
                        "color": "white",
                        "font-weight": "bold",
                        "font-size": "15px",
                        "border-radius": "15px"
                    });
                    $('#SettlementAmount').val("");
                }
            }
            $('#settlementamount-error').html("");
        }

        function settlementedVal() {
            var ob = $('#outstandingEditTotalTxt').val();
            var sa = $('#SettlementAmounted').val();
            if (parseFloat(sa) == 0) {
                $("#myToast").toast({
                    delay: 10000
                });
                $("#myToast").toast('show');
                $('#toast-massages').html("Invalid input");
                $('.toast-body').css({
                    "background-color": "#dc3545",
                    "color": "white",
                    "font-weight": "bold",
                    "font-size": "15px",
                    "border-radius": "15px"
                });
                $('#SettlementAmounted').val("");
            } else {
                if (parseFloat(sa) > parseFloat(ob)) {
                    $("#myToast").toast({
                        delay: 10000
                    });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Settlement amount cant greater than outstanding balance");
                    $('.toast-body').css({
                        "background-color": "#dc3545",
                        "color": "white",
                        "font-weight": "bold",
                        "font-size": "15px",
                        "border-radius": "15px"
                    });
                    $('#SettlementAmounted').val("");
                }
            }
            $('#settlementamounted-error').html("");
        }

        $('#PointOfSales').on('change', function() {
            var registerForm = $("#SettlementForm");
            var formData = registerForm.serialize();
            var posid=$("#PointOfSales").val();
            var settlementidsval=$("#settlementId").val();
            var iseditable=$("#isnewVal").val();
            var options;
            var defoptions = '<option selected disabled value=""></option>';
            $('#Customer').empty();
            $.ajax({
                url: '/getcreditcustomer'+'/'+posid,
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
                    $.each(data.cuslist, function(key, value) {
                        var contoption=value.CustomerCode+"     ,       "+value.CustomerName+"      ,       "+value.CustomerTIN;
                        options = "<option value='" + value.CustomerId + "'>" + contoption +"</option>";
                        if(parseFloat(iseditable)==0){
                            $('#Customer').append(options);
                        }
                    });
                    if(parseFloat(settlementidsval)==0||isNaN(parseFloat(settlementidsval))){
                        $('#Customer').append(defoptions);
                    }
                    $('#Customer').select2
                    ({
                        placeholder: "Select Customer here",
                    });
                }
            });
            $('#dynamicTable tbody').empty();
            j = 0;
            CalculateGrandTotal();
            renumberRows();
            $('#infoCardDiv').hide();
            $('#customerinfobtn').hide();
            $('#store-error').html("");
        });

        $('#Customer').on('change', function() {
            var registerForm = $("#SettlementForm");
            var formData = registerForm.serialize();
            var posid=$("#PointOfSales").val();
            var cusid=$("#Customer").val();
            var optype = $("#operationtypes").val();
            var options;
            salesidarr=[];
            var creditsales=0;
            var witholdsl=0;
            var vatsl=0;
            var settled=0;
            var netpay=0;
            var outstandingbl=0;
            var totalremanining=0;
            mc=0;
            $('#dynamicTableCh tbody').empty();
            var defoptions = '<option selected disabled value=""></option>';
            $('#FSNumbers').empty();
            $.ajax({
                url: '/getfsnumber'+'/'+posid+'/'+cusid,
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
                    $('#MaxDate').val(data.maxdatesel);
                    $.each(data.crdate, function(index, value) {
                        $('#CreditSalesDate').val(value.CreatedDate);
                    });
                    $.each(data.pricing, function(index, value) {
                        creditsales=value.GrandTotal;
                    });
                    $.each(data.withsett, function(index, value) {
                        witholdsl=value.WitholdAmount;
                    });
                    $.each(data.vatsett, function(index, value) {
                        vatsl=value.VatAmount;
                    });
                    $.each(data.settpricing, function(index, value) {
                        settled=value.SettlementAmount;
                    });
                    $.each(data.cusdata, function(index, value) {
                        $('#categoryInfoLbl').html(value.CustomerCategory);
                        $('#nameInfoLbl').html(value.Name);
                        $('#tinInfoLbl').html(value.TinNumber);
                        $('#vatInfoLbl').html(value.VatNumber);
                        $('#phoneInfoLbl').html(value.PhoneNumber+"</br>"+value.OfficePhone);
                    });
                    $.each(data.settdetails, function(index, value) {
                        ++mc;
                        $("#dynamicTableCh > tbody").append('<tr>'+
                            '<td style="width:10%;"><input type="text" name="rows['+mc+'][sales_id]" placeholder="sales_id" id="sales_id'+mc+'" class="sales_ids form-control" readonly="true" value="'+value.sales_id+'"/></td>'+
                            '<td style="width:12%;"><input type="text" name="rows['+mc+'][PaymentType]" placeholder="PaymentType" id="PaymentTypes'+mc+'" class="PaymentTypes form-control" readonly="true" value="'+value.PaymentType+'"/></td>'+
                            '<td style="width:12%;"><input type="text" name="rows['+mc+'][BankName]" placeholder="BankName" id="BankNames'+mc+'" class="BankNames form-control" readonly="true" value="'+value.BankName+'"/></td>'+
                            '<td style="width:10%;"><input type="number" name="rows['+mc+'][ChequeNumber]" placeholder="ChequeNumber" id="ChequeNumbers'+mc+'" class="ChequeNumbers form-control" value="'+value.ChequeNumber+'" onkeyup="chequenumberval(this)" onkeypress="return ValidateNum(event);" readonly="true"/></td>'+
                            '<td style="width:10%;"><input type="number" name="rows['+mc+'][BankTransferNumber]" placeholder="Slip Number" id="BankTransferNumbers'+mc+'" class="BankTransferNumber form-control" value="'+value.BankTransferNumber+'" onkeyup="slipnumberval(this)" onkeypress="return ValidateNum(event);" readonly="true"/></td></tr>'
                        );
                    });

                    netpay=parseFloat(creditsales)-parseFloat(witholdsl)-parseFloat(vatsl);
                    outstandingbl=parseFloat(netpay)-parseFloat(settled);
                    if(parseFloat(optype)==1){
                        $('#cusoutstandinglbl').text(numformat(outstandingbl.toFixed(2)));
                        $('#totaloutstandingi').val(outstandingbl.toFixed(2));
                        $.each(data.saleslist, function(key, value) {
                            var contoption=value.VoucherNumber+"     ,       "+value.invoiceNo;
                            options = "<option value='" + value.SalesId + "'>" + contoption +"</option>";
                            $('#FSNumbers').append(options);
                            salesidarr.push(value.SalesId);
                            $('#lblarr').text(salesidarr);
                        });
                    }
                    else if(parseFloat(optype)==2){
                        $.each(data.saleslisted, function(key, value) {
                            var contoption=value.VoucherNumber+"     ,       "+value.invoiceNo;
                            options = "<option value='" + value.SalesId + "'>" + contoption +"</option>";
                            $('#FSNumbers').append(options);
                            salesidarr.push(value.SalesId);
                            $('#lblarr').text(salesidarr);
                        });
                    }
                    $('#FSNumbers').append(defoptions);
                    $('#FSNumbers').select2
                    ({
                        placeholder: "Select FS or Invoice Number here",
                    });
                }
            });
            $('#pricingTable').hide();
            $('#infoCardDiv').show();
            $('#customerinfobtn').show();
            $('#dynamicTable tbody').empty();
            j = 0;
            $('#totaloutstandingi').val("");
            $('#custotalsettledi').val("");
            $('#custotalunpaidi').val("");
            $('#cusoutstandinglbl').html("");
            $('#custotalsettledlbl').html("");
            $('#custotalunpaidlbl').html("");
            $('#customer-error').html("");
        });

        function counter(textMatch){
            count=0;
            //loop through all <tr> s
            $('#dynamicTable').find('tbody tr').each(function( index ) {
                //if second <td> contains matching text update counter
                if($($(this).find('td')[2]).text() == textMatch){
                    count++
                }
            });
            return count;
        }

        function count()
        {
            var map = {};
            $("#dynamicTable > tbody tr").each(function(i, val){
                var key = $(this).find('td').eq(2).text().trim().toLowerCase();
               
                if (key in map)                   
                    map[key]=map[key] + 1;                                    
                else
                    map[key] = 1;                           
            });

            var result='';
            for(var key in map)
            {
                result += key;   
            }
        }
        
        $("#adds").click(function() {
            var posid=$("#PointOfSales").val();
            var cusid=$("#Customer").val();
            var crvdate=$("#date").val();
            var iseditable=$("#isnewVal").val();
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var salesid=$('#FSInvNumber'+lastrowcount).val();
            var paymenttypes=$('#PaymentType'+lastrowcount).val();
            var banknames=$('#BankName'+lastrowcount).val();
            var chequenumbers=$('#ChequeNumber'+lastrowcount).val();
            var slipnumbers=$('#BankTransferNumber'+lastrowcount).val();
            var settledamounts=$('#SettlementAmount'+lastrowcount).val();
            var lastsettstatus=$('#SettlementStatus'+lastrowcount).val();
            var totalnetpay=$('#NetPaySales'+lastrowcount).val()||0;
            var totalsettled=$('#SettledBalance'+lastrowcount).val()||0;
            var salesidzeroindex;
            var totalsettledamount=0;
            var totalsettledtonow=0;
            var finarr=[];
            var salesidslists=[];
            var numofsales=0;
            if((salesid!==undefined && salesid===null) || (settledamounts!=undefined && (settledamounts===""||settledamounts===null))|| (paymenttypes!=undefined && paymenttypes=="")){
                if(salesid!==undefined && salesid===null){
                    $('#select2-FSInvNumber'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(paymenttypes!=undefined && paymenttypes==""){
                    $('#select2-PaymentType'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(settledamounts!=undefined && (settledamounts===""||settledamounts===null)){
                    $('#SettlementAmount'+lastrowcount).css("background", errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if(isNaN(parseFloat(posid))||isNaN(parseFloat(cusid))||crvdate==""){
                if(isNaN(parseFloat(posid))){
                    $('#store-error').html("point of sales field is required");
                }
                if(isNaN(parseFloat(cusid))){
                    $('#customer-error').html("customer field is required");
                }
                if(crvdate==""){
                    $('#date-error').html("crv date field is required");
                }
                toastrMessage('error',"Please select required fields","Error");
            }
            else if(parseFloat(iseditable)>=1){
                toastrMessage('error',"You cant add sales, because you have settled another sales after these transaction","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                $('.remove-tr').prop("disabled",true);
                $('.SettlementAmount').prop("readonly",true);
                $('.SettlementAmount').css("background","#efefef");
                $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:2%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="display:none;" id="salesids'+m+'" class="salesids"></td>'+
                    '<td style="width:10%;"><select id="FSInvNumber'+m+'" class="select2 form-control fsninvoicenum" onchange="fsInVal(this)" name="row['+m+'][sales_id]"></select></td>'+
                    '<td style="width:8%;"><input type="text" name="row['+m+'][RemainingDay]" placeholder="Remaining Day" id="RemainingDay'+m+'" class="RemainingDay form-control" readonly="true"/></td>'+
                    '<td style="width:8%;"><input type="text" name="row['+m+'][RemainingAmount]" placeholder="Remaining Amount" id="RemainingAmount'+m+'" class="RemainingAmount form-control" readonly="true"/></td>'+
                    '<td style="width:9%;"><select id="PaymentType'+m+'" class="select2 form-control PaymentType" onchange="paymenttypeval(this)" name="row['+m+'][PaymentType]"></select></td>'+
                    '<td style="width:12%;"><select id="BankName'+m+'" class="select2 form-control BankName" onchange="banknameval(this)" name="row['+m+'][BankName]"></select></td>'+
                    '<td style="width:10%;"><select id="AccountNumber'+m+'" class="select2 form-control AccountNumber" onchange="AccnumVal(this)" name="row['+m+'][AccountNumber]"></select></td>'+
                    '<td style="width:10%;"><input type="text" name="row['+m+'][BankTransferNumber]" placeholder="Slip Number" id="BankTransferNumber'+m+'" class="BankTransferNumber form-control" onkeyup="slipnumberval(this)" onblur="removedupslp(this)" readonly="true" style="text-transform: uppercase;"/></td>'+
                    '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][SettlementAmount]" placeholder="Settlement Amount" id="SettlementAmount'+m+'" class="SettlementAmount form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondblclick="CloneValue(this)" readonly="true"/></td>'+
                    '<td style="width:8%;"><input type="text" name="row['+m+'][SettStatus]" placeholder="Status" id="SettStatus'+m+'" class="SettStatus form-control" readonly="true"/></td>'+
                    '<td style="width:10%;"><input type="text" name="row['+m+'][Remark]" placeholder="Write Remark here..." id="Remark'+m+'" class="Remark form-control"/></td>'+
                    '<td style="width:2%;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][NetPaySales]" placeholder="Net Pay Sales" id="NetPaySales'+m+'" class="NetPaySales form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][InvoiceDate]" placeholder="Invoice Date" id="InvoiceDate'+m+'" class="InvoiceDate form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][SettledBalance]" placeholder="Settled Balance" id="SettledBalance'+m+'" class="SettledBalance form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][IsDuplicatedChequnum]" placeholder="" id="IsDuplicatedChequnum'+m+'" class="IsDuplicatedChequnum form-control" readonly="true" value="0"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][IsDuplicateslipnum]" placeholder="" id="IsDuplicateslipnum'+m+'" class="IsDuplicateslipnum form-control" readonly="true" value="0"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][DbIsDuplicatedChequnum]" placeholder="" id="DbIsDuplicatedChequnum'+m+'" class="DbIsDuplicatedChequnum form-control" readonly="true" value="0"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][DbIsDuplicateslipnum]" placeholder="" id="DbIsDuplicateslipnum'+m+'" class="DbIsDuplicateslipnum form-control" readonly="true" value="0"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][SubTotal]" placeholder="" id="SubTotal'+m+'" class="SubTotal form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][Tax]" placeholder="" id="Tax'+m+'" class="Tax form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][GrandTotal]" placeholder="" id="GrandTotal'+m+'" class="GrandTotal form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][WitholdAmount]" placeholder="" id="WitholdAmount'+m+'" class="WitholdAmount form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][Vat]" placeholder="" id="Vat'+m+'" class="Vat form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][WitholdSetle]" placeholder="" id="WitholdSetle'+m+'" class="WitholdSetle form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][VatSetle]" placeholder="" id="VatSetle'+m+'" class="VatSetle form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][expdatei]" placeholder="" id="expdatei'+m+'" class="expdatei form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][settexpdatei]" placeholder="" id="settexpdatei'+m+'" class="settexpdatei form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="number" name="row['+m+'][ChequeNumber]" placeholder="Cheque Number" id="ChequeNumber'+m+'" class="ChequeNumber form-control" onkeyup="chequenumberval(this)" onblur="removedupchq(this)" onkeypress="return ValidateNum(event);" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][contactnum]" id="contactnum'+m+'" class="contactnum form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][branchadd]" id="branchadd'+m+'" class="branchadd form-control" readonly="true"/></td>' +
                    '<td style="display:none;"><input type="text" name="row['+m+'][SettlementStatus]" placeholder="Settlement Status" id="SettlementStatus'+m+'" class="SettlementStatus form-control" readonly="true"/><input type="text" name="row['+m+'][VoucherType]" placeholder="Voucher Type" id="VoucherType'+m+'" class="VoucherType form-control" readonly="true"/><input type="text" name="row['+m+'][MRC]" placeholder="MRC #" id="MRC'+m+'" class="MRC form-control" readonly="true"/></td></tr>'  
                );
                $("#dynamicTable > tbody tr").each(function(i, val){
                    salesidslists.push($(this).find('td').eq(2).text().trim().toLowerCase());       
                });
                numofsales=unique(salesidslists).length;
                
                CalculateGrandTotal();
                renumberRows();
                $('#dynamicTable tr').filter(function() {
                    return $(this).find('td').eq(2).text().trim().toLowerCase()==salesid;
                }).each(function() {
                    totalsettledamount += parseFloat($(this).find('td').eq(10).find('input').val());
                });
                totalsettledtonow=parseFloat(totalsettledamount)+parseFloat(totalsettled);
                $('#lblarr').text(unique(salesidarr));
                salesidzeroindex=salesidarr[numofsales];
                var fsopt = '<option selected disabled value=""></option>';
                var fsoptions = $("#FSNumbers > option").clone();
                $('#FSInvNumber'+m).append(fsoptions);
                if(!isNaN(parseFloat(salesid)) && parseFloat(totalnetpay)==parseFloat(totalsettledtonow.toFixed(2))){
                    $("#FSInvNumber"+m+" option").each(function(){
                        if (parseFloat(this.value) <= parseFloat(salesid)) {
                            $("#FSInvNumber"+m+" option[value='"+this.value+"']").remove();
                        }
                    });
                }
                if(!isNaN(parseFloat(salesid)) && parseFloat(totalnetpay)!=parseFloat(totalsettledtonow.toFixed(2))){
                    $("#FSInvNumber"+m+" option").each(function(){
                        if (parseFloat(this.value) < parseFloat(salesid)) {
                            $("#FSInvNumber"+m+" option[value='"+this.value+"']").remove();
                        }
                    });
                    
                }
                $("#FSInvNumber"+m+" option:not(:first)").remove();
                $('#FSInvNumber'+m).append(fsopt);
                $('#FSInvNumber'+m).select2
                ({
                    placeholder: "Select FS or Invoice # here",
                    dropdownCssClass : 'dynamicselect2',
                });
                var paymenttypeopt = '<option selected value=""></option><option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Bank-Transfer">Bank-Transfer</option>';
                $('#PaymentType'+m).append(paymenttypeopt);
                $('#PaymentType'+m).select2
                ({
                    placeholder: "Payment mode",
                    minimumResultsForSearch: -1,
                });
                var opt = '<option selected value=""></option>';
                var options = $("#bank > option").clone();
                $('#BankName'+m).append(options);
                $('#BankName'+m).append(opt);
                $('#BankName'+m).select2
                ({
                    placeholder: "Select Bank here",
                    dropdownCssClass : 'dynamicselect2',
                });
                $('#AccountNumber'+m).select2
                ({
                    placeholder: "Select Bank first",
                });
                $('#select2-FSInvNumber'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-BankName'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-PaymentType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                //$('#BankName'+m).prop("disabled", true);
            }
        });

        function chequenumberval(ele) {
            var totalchequecnt=0;
            var totalchequecnts=0;
            var cid=$(ele).closest('tr').find('.vals').val();
            var salesid=$('#FSInvNumber'+cid).val();
            var paymenttypes=$('#PaymentType'+cid).val();
            var banknames=$('#BankName'+cid).val();
            var chequenumbers=$('#ChequeNumber'+cid).val();
            var slipnumbers=$('#BankTransferNumber'+cid).val();
            var settledamounts=$('#SettlementAmount'+cid).val();
            var lastsettstatus=$('#SettlementStatus'+cid).val();
            var totalnetpay=$('#NetPaySales'+cid).val();
            var totalsettled=$('#SettledBalance'+cid).val()||0;
            // $('#dynamicTable tr').filter(function() {
            //     return $(this).find('td').eq(2).text().trim().toLowerCase()==salesid && $(ele).closest('tr').find('.PaymentType').val()=="Cheque" && $(ele).closest('tr').find('.BankName').val()==banknames && $(ele).closest('tr').find('.ChequeNumber').val()==chequenumbers;
            // }).each(function() {
            //     totalchequecnt += 1;
            // });
            for(var k=1;k<=m;k++){
                if(($('#ChequeNumber'+k).val())!=undefined){
                    var selectedsales=$('#FSInvNumber'+k).val();
                    var selectedpaymenttype=$('#PaymentType'+k).val();
                    var selectedbanks=$('#BankName'+k).val();
                    var selectedchequenum=$('#ChequeNumber'+k).val();
                    if(parseFloat(selectedsales)==parseFloat(salesid) && selectedpaymenttype=="Cheque" && selectedbanks==banknames && selectedchequenum==chequenumbers){
                        totalchequecnt += 1;
                    }
                }
            }
            for(var c=1;c<=mc;c++){
                if(($('#ChequeNumbers'+c).val())!=undefined){
                    var selectedpaymenttypes=$('#PaymentTypes'+c).val();
                    var selectedbankss=$('#BankNames'+c).val();
                    var selectedchequenums=$('#ChequeNumbers'+c).val();
                    if(selectedpaymenttypes=="Cheque" && selectedbankss==banknames && selectedchequenums==chequenumbers){
                        totalchequecnts += 1;
                    }
                }
            }
            
            if(parseFloat(totalchequecnt)>1){
                $('#IsDuplicatedChequnum'+cid).val("1");
                toastrMessage('info',"Duplicate cheque number for the same sales and bank","Information");
            }
            if(parseFloat(totalchequecnt)<=1){
                $('#IsDuplicatedChequnum'+cid).val("0");
            }
            if(parseFloat(totalchequecnts)>=1){
                $('#DbIsDuplicatedChequnum'+cid).val("1");
                //toastrMessage('info',"Duplicate cheque number for the same sales and bank","Information");
            }
            if(parseFloat(totalchequecnts)<1){
                $('#DbIsDuplicatedChequnum'+cid).val("0");
            }
            $('#ChequeNumber'+cid).css("background", "white");
        }

        function removedupchq(ele) {
            var cid=$(ele).closest('tr').find('.vals').val();
            var isduplicateval=$(ele).closest('tr').find('.IsDuplicatedChequnum').val();
            if(parseFloat(isduplicateval)==1){
                $(ele).closest('tr').find('.ChequeNumber').val("");
                toastrMessage('error',"Duplicate cheque number is removed","Error");
            }
        }

        function removedupslp(ele) {
            var settlementid="";
            var bankid="";
            var slipnum="";
            var invnum="";
            var paymode="";
            var cid=$(ele).closest('tr').find('.vals').val();
            var salesid=$(ele).closest('tr').find('.fsninvoicenum').val()||0;
            var paymentmodes=$(ele).closest('tr').find('.PaymentType').val()||0;
            var bankid=$(ele).closest('tr').find('.BankName').val()||0;
            var accountnum=$(ele).closest('tr').find('.AccountNumber').val()||0;
            var slipnumber=$(ele).closest('tr').find('.BankTransferNumber').val()||0;
            var isduplicateval=$(ele).closest('tr').find('.IsDuplicateslipnum').val();
            var found = 0;
            for(var l=1;l<=m;l++){
                if(($('#BankTransferNumber'+l).val())!=undefined){
                    if(($('#BankName'+l).val()==bankid) && ($('#BankTransferNumber'+l).val()==slipnumber) && ($('#FSInvNumber'+l).val()==salesid) && ($('#PaymentType'+l).val()==paymentmodes)){
                        found+=1;
                    }
                }
            }
            $.ajax({
                url: '/slipnumVal',
                type: 'POST',
                data:{
                    settlementid:$('#settlementId').val()||0,
                    bankid:$(ele).closest('tr').find('.BankName').val()||0,
                    slipnum:$(ele).closest('tr').find('.BankTransferNumber').val()||0,
                    invnum:$(ele).closest('tr').find('.fsninvoicenum').val()||0,
                    paymode:$(ele).closest('tr').find('.PaymentType').val()||0,
                },
                success: function(data) {  
                    if(parseFloat(data.contn)>0){
                        $('#BankTransferNumber'+cid).val("");
                        $('#BankTransferNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Transaction Reference number has already been taken","Error");
                    }
                    else if(parseFloat(found)>1){
                        $('#BankTransferNumber'+cid).val("");
                        $('#BankTransferNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Transaction Reference number has already been taken","Error");
                    }
                    $('#savebutton').prop("disabled",false);
                }
            });
        }

        function slipnumberval(ele) {
            var totalslipcnt=0;
            var totalslipcnts=0;
            var totalcashcnt=0;
            var totalchequecnt=0;
            var cid=$(ele).closest('tr').find('.vals').val();
            var salesid=$('#FSInvNumber'+cid).val();
            var paymenttypes=$('#PaymentType'+cid).val();
            var banknames=$('#BankName'+cid).val();
            var chequenumbers=$('#ChequeNumber'+cid).val();
            var slipnumbers=$('#BankTransferNumber'+cid).val();
            var settledamounts=$('#SettlementAmount'+cid).val();
            var lastsettstatus=$('#SettlementStatus'+cid).val();
            var totalnetpay=$('#NetPaySales'+cid).val();
            var totalsettled=$('#SettledBalance'+cid).val()||0;
            // $('#dynamicTable tr').filter(function() {
            //     return $(this).find('td').eq(2).text().trim().toLowerCase()==salesid && $(ele).closest('tr').find('.PaymentType').val()=="Cheque" && $(ele).closest('tr').find('.BankName').val()==banknames && $(ele).closest('tr').find('.ChequeNumber').val()==chequenumbers;
            // }).each(function() {
            //     totalchequecnt += 1;
            // });
            // for(var k=1;k<=m;k++){
            //     if(($('#BankTransferNumber'+k).val())!=undefined){
            //         var selectedsales=$('#FSInvNumber'+k).val();
            //         var selectedpaymenttype=$('#PaymentType'+k).val();
            //         var selectedbanks=$('#BankName'+k).val();
            //         var selectedslipnum=$('#BankTransferNumber'+k).val();
            //         if(parseFloat(selectedsales)==parseFloat(salesid) && selectedpaymenttype=="Bank-Transfer" && selectedbanks==banknames && selectedslipnum==slipnumbers){
            //             totalslipcnt += 1;
            //         }
            //         if(parseFloat(selectedsales)==parseFloat(salesid) && selectedpaymenttype=="Cash" && selectedbanks==banknames && selectedslipnum==slipnumbers){
            //             totalcashcnt += 1;
            //         }
            //         if(parseFloat(selectedsales)==parseFloat(salesid) && selectedpaymenttype=="Cheque" && selectedbanks==banknames && selectedslipnum==slipnumbers){
            //             totalchequecnt += 1;
            //         }
            //     }
            // }

            // for(var c=1;c<=mc;c++){
            //     if(($('#BankTransferNumbers'+c).val())!=undefined){
            //         var selectedpaymenttypes=$('#PaymentTypes'+c).val();
            //         var selectedbankss=$('#BankNames'+c).val();
            //         var selectedslipnums=$('#BankTransferNumbers'+c).val();
            //         if(selectedpaymenttypes=="Bank-Transfer" && selectedbankss==banknames && selectedslipnums==slipnumbers){
            //             totalslipcnts += 1;
            //         }
            //         if(selectedpaymenttypes=="Cash" && selectedbankss==banknames && selectedslipnums==slipnumbers){
            //             totalcashcnt += 1;
            //         }
            //         if(selectedpaymenttypes=="Cheque" && selectedbankss==banknames && selectedslipnums==slipnumbers){
            //             totalchequecnt += 1;
            //         }
            //     }
            // }

            // if(parseFloat(totalslipcnt)>1){
            //     $('#IsDuplicateslipnum'+cid).val("1");
            // }
            // if(parseFloat(totalcashcnt)>1){
            //     $('#IsDuplicateslipnum'+cid).val("1");
            // }
            // if(parseFloat(totalchequecnt)>1){
            //     $('#IsDuplicateslipnum'+cid).val("1");
            // }

            // if(parseFloat(totalslipcnt)<=1){
            //     $('#IsDuplicateslipnum'+cid).val("0");
            // }
            // if(parseFloat(totalslipcnts)>1){
            //     $('#DbIsDuplicateslipnum'+cid).val("1");
            // }
            // if(parseFloat(totalslipcnts)<=1){
            //     $('#DbIsDuplicateslipnum'+cid).val("0");
            // }
            $('#savebutton').prop("disabled", true);
            $('#BankTransferNumber'+cid).css("background", "white");
        }

        function paymenttypeval(ele) {
            var totalptypecount=0;
            var opt=$("#operationtypes").val();
            var iseditable=$("#isnewVal").val();
            var cid=$(ele).closest('tr').find('.vals').val();
            var salesid=$('#FSInvNumber'+cid).val();
            var paymenttypes=$('#PaymentType'+cid).val();
            var banknames=$('#BankName'+cid).val();
            var chequenumbers=$('#ChequeNumber'+cid).val();
            var slipnumbers=$('#BankTransferNumber'+cid).val();
            var settledamounts=$('#SettlementAmount'+cid).val();
            var lastsettstatus=$('#SettlementStatus'+cid).val();
            var totalnetpay=$('#NetPaySales'+cid).val();
            var totalsettled=$('#SettledBalance'+cid).val()||0;
            // $('#dynamicTable tr').filter(function() {
            //     return $(this).find('td').eq(2).text().trim().toLowerCase()==salesid && $(ele).closest('tr').find('.PaymentType').val()=="Cash";
                
            // }).each(function() {
            //     totalptypecount += 1;
            //     alert($(this).find('td').eq(2).text()+"                 "+$(ele).closest('tr').find('.PaymentType').val());
            // });
            for(var k=1;k<=m;k++){
                if(($('#PaymentType'+k).val())!=undefined){
                    var selectedsales=$('#FSInvNumber'+k).val();
                    var selectedpaymenttype=$('#PaymentType'+k).val();
                    if(parseFloat(selectedsales)==parseFloat(salesid) && selectedpaymenttype=="Cash"){
                        totalptypecount += 1;
                    }
                }
            }

            // if(parseFloat(totalptypecount)>1){
            //     $('#PaymentType'+cid).empty();
            //     toastrMessage('error',"You settled cash payment type for these sales","Error");
            //     var paymenttypeopt = '<option selected value=""></option><option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Bank-Transfer">Bank-Transfer</option>';
            //     $('#PaymentType'+cid).append(paymenttypeopt);
            //     $('#PaymentType'+cid).select2
            //     ({
            //         placeholder: "Payment type",
            //     });
            //     $('#select2-PaymentType'+cid+'-container').parent().css('background-color',errorcolor);
            // }
            // else if(parseFloat(totalptypecount)<=1){
            //     $('#BankName'+cid).empty();
            //     if(paymenttypes=="Cash"){
            //         $('#BankName'+cid).prop("disabled", false);
            //         $('#ChequeNumber'+cid).prop("readonly", true);
            //         $('#BankTransferNumber'+cid).prop("readonly", true);
            //         if(parseFloat(cid)==parseFloat(m) && parseFloat(iseditable)==0){
            //             $('#SettlementAmount'+cid).prop("readonly", false);
            //         }
            //         $('#BankTransferNumber'+cid).css("background","#efefef");
            //         $('#ChequeNumber'+cid).css("background","#efefef");
            //         $('#ChequeNumber'+cid).val("");
            //         $('#BankTransferNumber'+cid).val("");
            //         $('#IsDuplicatedChequnum'+cid).val("0");
            //         $('#IsDuplicateslipnum'+cid).val("0");
            //         var opt = '<option selected value="-"></option>';
            //         $('#BankName'+cid).append(opt);
            //         $('#BankName'+cid).select2
            //         ({
            //             placeholder: "---",
            //             minimumResultsForSearch: -1,
            //         });
            //     }
            //     if(paymenttypes=="Cheque"){
            //         $('#BankName'+cid).prop("disabled", false);
            //         $('#ChequeNumber'+cid).prop("readonly", true);
            //         $('#BankTransferNumber'+cid).prop("readonly", true);
            //         if(parseFloat(cid)==parseFloat(m) && parseFloat(iseditable)==0){
            //             $('#SettlementAmount'+cid).prop("readonly", false);
            //         }
            //         $('#ChequeNumber'+cid).css("background","#efefef");
            //         $('#BankTransferNumber'+cid).css("background","#efefef");
            //         $('#ChequeNumber'+cid).val("");
            //         $('#BankTransferNumber'+cid).val("");
            //         $('#IsDuplicateslipnum'+cid).val("0");
            //         var opt = '<option selected value=""></option>';
            //         var options = $("#bank > option").clone();
            //         $('#BankName'+cid).append(options);
            //         $('#BankName'+cid).append(opt);
            //         $('#BankName'+cid).select2
            //         ({
            //             placeholder: "Select Bank here",
            //             dropdownCssClass : 'dynamicselect2',
            //         });
            //     }
            //     if(paymenttypes=="Bank-Transfer"){
            //         $('#BankName'+cid).prop("disabled", false);
            //         $('#ChequeNumber'+cid).prop("readonly", true);
            //         $('#BankTransferNumber'+cid).prop("readonly", true);
            //         if(parseFloat(cid)==parseFloat(m) && parseFloat(iseditable)==0){
            //             $('#SettlementAmount'+cid).prop("readonly", false);
            //         }
            //         $('#ChequeNumber'+cid).css("background","#efefef");
            //         $('#BankTransferNumber'+cid).css("background","#efefef");
            //         $('#ChequeNumber'+cid).val("");
            //         $('#BankTransferNumber'+cid).val("");
            //         $('#IsDuplicatedChequnum'+cid).val("0");
            //         var opt = '<option selected value=""></option>';
            //         var options = $("#bank > option").clone();
            //         $('#BankName'+cid).append(options);
            //         $('#BankName'+cid).append(opt);
            //         $('#BankName'+cid).select2
            //         ({
            //             placeholder: "Select Bank here",
            //             dropdownCssClass : 'dynamicselect2',
            //         });
            //     }
            // }
            removedupslp(ele);
            $('#select2-PaymentType'+cid+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            $('#select2-BankName'+cid+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function banknameval(ele) {
            var cid=$(ele).closest('tr').find('.vals').val();
            var banknames=$('#BankName'+cid).val();
            var paymenttypes=$('#PaymentType'+cid).val();
            var opt = '<option selected disabled value=""></option>';
            var options = $("#AccData > option").clone();
            var bankid=$(ele).closest('tr').find('.Bank').val()||0;
            var accountnum=$(ele).closest('tr').find('.AccountNumber').val()||0;
            $('#AccountNumber'+cid).append(options);
            $("#AccountNumber"+cid+" option[title!='"+banknames+"']").remove();
            $('#AccountNumber'+cid).append(opt);
            $('#AccountNumber'+cid).select2
            ({
                placeholder: "Select account number here",
            });
            // if(paymenttypes=="Cheque"){
            //     $('#ChequeNumber'+cid).prop("readonly", false);
            //     $('#ChequeNumber'+cid).css("background","white");
            //     $('#BankTransferNumber'+cid).prop("readonly", true);
            //     $('#BankTransferNumber'+cid).css("background","#efefef");
            //     $('#ChequeNumber'+cid).val("");
            //     $('#BankTransferNumber'+cid).val("");
            // }
            // if(paymenttypes=="Bank-Transfer"){
            //     $('#ChequeNumber'+cid).prop("readonly", true);
            //     $('#ChequeNumber'+cid).css("background","#efefef");
            //     $('#BankTransferNumber'+cid).prop("readonly", false);
            //     $('#BankTransferNumber'+cid).css("background","white");
            //     $('#ChequeNumber'+cid).val("");
            //     $('#BankTransferNumber'+cid).val("");
            // }
            removedupslp(ele);
            $('#select2-BankName'+cid+'-container').parent().css('background-color',"white");
            $('#select2-AccountNumber'+cid+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            $('#BankTransferNumber'+cid).val("");
            $('#SettlementAmount'+cid).val("");
            $('#BankTransferNumber'+cid).prop("readonly", true);
            $('#SettlementAmount'+cid).prop("readonly", true);
            $('#BankTransferNumber'+cid).css("background", "#efefef");
            $('#SettlementAmount'+cid).css("background", "#efefef");
            $('#IsDuplicatedChequnum'+cid).val("0");
        }

        function AccnumVal(ele){
            var bankid = "";
            var accnum ="";
            var idval = $(ele).closest('tr').find('.vals').val();
            $.ajax({
                url: '/bankdetinfo',
                type: 'POST',
                data:{
                    bankid :$(ele).closest('tr').find('.BankName').val(),
                    accnum: $(ele).closest('tr').find('.AccountNumber').val(),
                },
                success: function(data) {
                    $.each(data.bankdet, function(key, value) {
                        $(ele).closest('tr').find('.branchadd').val(value.Branch);
                        $(ele).closest('tr').find('.contactnum').val(value.ContactNumber);
                    });
                }
            });
            $('#select2-AccountNumber'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-AccountNumber'+idval+'-container').parent().css('background-color',"white");
            $('#BankTransferNumber'+idval).prop("readonly", false);
            $('#SettlementAmount'+idval).prop("readonly", false);
            $('#BankTransferNumber'+idval).css("background", "#ffffff");
            $('#SettlementAmount'+idval).css("background", "#ffffff");
        }

        function CalculateTotal(ele) {
            var salesidsval = $(ele).closest('tr').find('.fsninvoicenum').val();
            var cid=$(ele).closest('tr').find('.vals').val();
            var inputid = ele.getAttribute('id');
            var remamnt=$(ele).closest('tr').find('.RemainingAmount').val();
            var settamnt=$(ele).closest('tr').find('.SettlementAmount').val();
            var netpaysales=$(ele).closest('tr').find('.NetPaySales').val();
            if(parseFloat(remamnt)==0|| isNaN(parseFloat(remamnt))){
                $(ele).closest('tr').find('.SettlementAmount').val("");
                $(ele).closest('tr').find('.SettStatus').val("");
                $(ele).closest('tr').find('.SettlementStatus').val("0");
            }
            if(parseFloat(settamnt)==0|| isNaN(parseFloat(settamnt))){
                $(ele).closest('tr').find('.SettlementAmount').val("");
                $(ele).closest('tr').find('.SettStatus').val("Not-Paid");
                $(ele).closest('tr').find('.SettlementStatus').val("0");
            }
            if(parseFloat(settamnt)>parseFloat(remamnt)){
                toastrMessage('error',"Settled amount is greather than remaining amount","Error");
                $(ele).closest('tr').find('.SettlementAmount').val("");
                $(ele).closest('tr').find('.SettStatus').val("Not-Paid");
                $(ele).closest('tr').find('.SettlementStatus').val("0");
            }
            else{
                var searchval=$(ele).closest('tr').find('td').eq(2).text();
                var newid=parseFloat(cid)+1;
                var newremamount=parseFloat(remamnt)-parseFloat(settamnt);
                if(parseFloat(netpaysales)==parseFloat(settamnt)){
                    $(ele).closest('tr').find('.SettStatus').val("Fully-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("2");
                }
                if(parseFloat(netpaysales)!=parseFloat(settamnt)){
                    $(ele).closest('tr').find('.SettStatus').val("Partially-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("1");
                }
                if(parseFloat(settamnt)==0|| isNaN(parseFloat(settamnt))){
                    $(ele).closest('tr').find('.SettlementAmount').val("");
                    $(ele).closest('tr').find('.SettStatus').val("Not-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("0");
                }
                $('#dynamicTable tr').filter(function() {
                    return $(this).find('td').eq(2).text().trim().toLowerCase()==salesidsval;
                }).each(function() {
                    for (var i = newid; i <= m; i++) {
                        var slids=$('#FSInvNumber'+i).val();
                        var slidstd=$('#salesids'+i).text();
                        if(parseFloat(slids)==parseFloat(searchval)){
                            $('#RemainingAmount'+i).val(newremamount.toFixed(2));
                            $('#SettlementAmount'+i).val("");
                            $('#SettStatus'+i).val("Not-Paid");
                            $('#SettlementStatus'+i).val("0");
                        }
                    }
                });
                $('#SettlementAmount'+cid).css("background", "white");
            }
            CalculateGrandTotal();
        }

        function CloneValue(ele) {
            var salesidsval = $(ele).closest('tr').find('.fsninvoicenum').val();
            var cid=$(ele).closest('tr').find('.vals').val();
            var inputid = ele.getAttribute('id');
            var remamnt=$(ele).closest('tr').find('.RemainingAmount').val();
            var settamnt=$(ele).closest('tr').find('.SettlementAmount').val();
            var netpaysales=$(ele).closest('tr').find('.NetPaySales').val();
            if ($('#SettlementAmount'+cid).is('[readonly]')) { 
                toastrMessage('error',"You cant clone remaining amount","Error");
                $('#SettlementAmount'+cid).css("background","#efefef");
            }
            else{
                if(parseFloat(remamnt)==0|| isNaN(parseFloat(remamnt))){
                    $(ele).closest('tr').find('.SettlementAmount').val("");
                    $(ele).closest('tr').find('.SettStatus').val("Not-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("0");
                }
                if(parseFloat(remamnt)>0 && parseFloat(netpaysales)!=parseFloat(remamnt)){
                    $(ele).closest('tr').find('.SettlementAmount').val(remamnt);
                    $(ele).closest('tr').find('.SettStatus').val("Partially-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("1");
                    $('#SettlementAmount'+cid).css("background", "white");
                    CalculateGrandTotal();
                }
                if(parseFloat(remamnt)>0 && parseFloat(netpaysales)==parseFloat(remamnt)){
                    $(ele).closest('tr').find('.SettlementAmount').val(remamnt);
                    $(ele).closest('tr').find('.SettStatus').val("Fully-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("2");
                    $('#SettlementAmount'+cid).css("background", "white");
                    CalculateGrandTotal();
                } 
            }
        }

        function CalculateGrandTotal() {
            var settamount = 0;
            var totalunpaidamount = 0;
            var totaloutstanding =  $('#totaloutstandingi').val();
            $.each($('#dynamicTable').find('.SettlementAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    settamount += parseFloat($(this).val());
                }
            });
            totalunpaidamount=parseFloat(totaloutstanding)-parseFloat(settamount);
            $('#custotalunpaidi').val(totalunpaidamount.toFixed(2));
            $('#custotalunpaidlbl').html(numformat(totalunpaidamount.toFixed(2)));
            $('#custotalsettledi').val(settamount.toFixed(2));
            $('#custotalsettledlbl').html(numformat(settamount.toFixed(2)));
        }

        function fsInVal(ele) {
            var salesidsval = $(ele).closest('tr').find('.fsninvoicenum').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            var settid = $('#settlementId').val()||0;
            var tot;
            var settlementamnt=0;
            let sum = 0;
            var searchval=$('#dynamicTable tr').find('td').eq(2).text();
            $('#dynamicTable tr').filter(function() {
                return $(this).find('td').eq(2).text().trim().toLowerCase() ==salesidsval;
            }).each(function() {
                settlementamnt += parseFloat($(this).find('td').eq(10).find('input').val());
                
            });
           
            // console.log("This is sales id = "+$(this).find('td').eq(2).text().trim().toLowerCase());
            $(ele).closest('tr').find('.salesids').html(salesidsval);
            $.get("/showSettlementInfo" + '/' + salesidsval+'/'+settid, function(data) {
                var creditsales=0;
                var witholdsl=0;
                var vatsl=0;
                var settled=0;
                var netpay=0;
                var outstandingbl=0;
                var totalremanining=0;
                var subtotalval=0;
                var grandtotalval=0;
                var taxval=0;
                var witholdamounts=0;
                var vatamounts=0;
                var witholdsettleval=0;
                var vatsettleval=0;
                var salesdate=data.createddates;
                var expdateval=data.expdate;
                var settlementdate=$('#date').val();
                var remainingdt=dateDiffInDays(expdateval,settlementdate); 
                $.each(data.pricing, function(index, value) {
                    creditsales=value.GrandTotal;
                    subtotalval=value.SubTotal;
                    grandtotalval=value.GTotal;
                    taxval=value.Tax;
                    witholdamounts=value.WitholdAmount;
                    vatamounts=value.Vat;
                    witholdsettleval=value.WitholdSetle;
                    vatsettleval=value.VatSetle;
                   // remainingdt=value.RemainingDate;
                });
                $.each(data.withsett, function(index, value) {
                    witholdsl=value.WitholdAmount;
                });
                $.each(data.vatsett, function(index, value) {
                    vatsl=value.VatAmount;
                });
                $.each(data.settpricing, function(index, value) {
                    settled=value.SettlementAmount;
                });
                netpay=parseFloat(creditsales)-parseFloat(witholdsl)-parseFloat(vatsl);
                outstandingbl=parseFloat(netpay)-parseFloat(settled);
                totalremanining=parseFloat(outstandingbl.toFixed(2))-parseFloat(settlementamnt.toFixed(2));
                if(parseFloat(totalremanining)<=0){
                    toastrMessage('error',"You paid the entire outstanding amount","Error");
                    $(ele).closest('tr').find('.fsninvoicenum').append('<option selected disabled value=""></option>');
                    $('#select2-FSInvNumber'+idval+'-container').parent().css('background-color',errorcolor);
                }
                else if(settlementdate<salesdate){
                    $('#date-error').html("date field is less than sales document number");
                    toastrMessage('error',"CRV date is less than sales document date","Error");
                    $(ele).closest('tr').find('.fsninvoicenum').append('<option selected disabled value=""></option>');
                    $('#select2-FSInvNumber'+idval+'-container').parent().css('background-color',errorcolor);
                }
                else if(parseFloat(totalremanining)>0 && settlementdate>=salesdate){
                    $(ele).closest('tr').find('.RemainingAmount').val(totalremanining.toFixed(2));
                    $(ele).closest('tr').find('.SubTotal').val(subtotalval);
                    $(ele).closest('tr').find('.GrandTotal').val(grandtotalval);
                    $(ele).closest('tr').find('.Tax').val(taxval);
                    $(ele).closest('tr').find('.WitholdAmount').val(witholdamounts);
                    $(ele).closest('tr').find('.Vat').val(vatamounts);
                    $(ele).closest('tr').find('.WitholdSetle').val(witholdsettleval);
                    $(ele).closest('tr').find('.VatSetle').val(vatsettleval);
                    $(ele).closest('tr').find('.RemainingDay').val(remainingdt);
                    $(ele).closest('tr').find('.NetPaySales').val(netpay.toFixed(2));
                    $(ele).closest('tr').find('.SettledBalance').val(settled);
                    $(ele).closest('tr').find('.expdatei').val(salesdate);
                    $(ele).closest('tr').find('.settexpdatei').val(expdateval);
                    $(ele).closest('tr').find('.SettStatus').val("Not-Paid");
                    $(ele).closest('tr').find('.SettlementStatus').val("0");
                    $(ele).closest('tr').find('.PaymentType').prop("disabled", false);
                    $('#select2-FSInvNumber'+idval+'-container').parent().css('background-color',"white");
                }
            });
            removedupslp(ele);
        }

        $(document).on('click', '.remove-tr', function() {
            var salesidvar=$(this).parents('tr').find('td').eq(2).text();
            var rowuniqueid=$(this).parents('tr').find('td').eq(1).find('input').val();
            $(this).parents('tr').remove();
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            $('#removebtn'+lastrowcount).prop("disabled",false);
            $('#SettlementAmount'+lastrowcount).prop("readonly",false);
            $('#SettlementAmount'+lastrowcount).css("background", "white");
            if(!isNaN(parseFloat(salesidvar))){
                salesidarr.splice(0, 0, salesidvar);
                $('#lblarr').text(unique(salesidarr));
                unique(salesidarr);
            }
            if(parseFloat(lastrowcount)>parseFloat(rowuniqueid)){
                for(var d=rowuniqueid;d<=lastrowcount;d++){
                    $("#rowind"+d).remove();
                }
            }
            CalculateGrandTotal();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                ind = index - 1;
            });
            if (ind == 0) {
                $('#custotalsettledlbl').text("");
                $('#custotalunpaidlbl').text("");
                $('#custotalsettledi').val("");
                $('#custotalunpaidi').val("");
                $('#pricingTable').hide();
            } else {
                $('#pricingTable').show();
            }
        }

        function unique(array) {
            if (array) {
                var found = {};
                array = array.join(",").split(",").filter(function (x) {
                    x = x.trim();
                    return (found[x] ? false : (found[x] = x));
                })
            }
            return array;
        }

        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#SettlementForm");
            var formData = registerForm.serialize();
            var ischequeduplicate=0;
            var isslipduplicate=0;
            $.each($('#dynamicTable').find('.IsDuplicatedChequnum'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    ischequeduplicate += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.IsDuplicateslipnum'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    isslipduplicate += parseFloat($(this).val());
                }
            });
            $.ajax({
                url: '/saveSettlement',
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
                        if (data.errors.PointOfSales) {
                            $('#store-error').html(data.errors.PointOfSales[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.Customer) {
                            $('#customer-error').html(data.errors.Customer[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.CrvNumber) {
                            $('#crvno-error').html(data.errors.CrvNumber[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.date) {
                            $('#date-error').html(data.errors.date[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.Memo) {
                            $('#memo-error').html(data.errors.Memo[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if (data.errorv2) {
                        var error_html = '';
                        for(var k=1;k<=m;k++){
                            var fsinvnum=($('#FSInvNumber'+k)).val();
                            var ptypes=($('#PaymentType'+k)).val();
                            var banknames=($('#BankName'+k)).val();
                            var remainingamnt=($('#RemainingAmount'+k)).val();
                            if(isNaN(parseFloat(fsinvnum))||parseFloat(fsinvnum)==0){
                                $('#select2-FSInvNumber'+k+'-container').parent().css('background-color',errorcolor);
                            }
                            if(($('#PaymentType'+k).val())!=undefined){
                                if(ptypes==""||ptypes==null){
                                    $('#select2-PaymentType'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#BankName'+k).val())!=undefined && ($('#PaymentType'+k).val())!=undefined){
                                if((banknames==""||banknames==null) && (ptypes=="Cheque" ||ptypes=="Bank-Transfer")){
                                    $('#select2-BankName'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#ChequeNumber'+k).val())!=undefined && ($('#PaymentType'+k).val())!=undefined){
                                var chequenum=$('#ChequeNumber'+k).val();
                                if((isNaN(parseFloat(chequenum))||parseFloat(chequenum)==0) && ptypes=="Cheque" && (banknames!=""||banknames!=null)){
                                    $('#ChequeNumber'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#BankTransferNumber'+k).val())!=undefined && ($('#PaymentType'+k).val())!=undefined){
                                var slipnumber=$('#BankTransferNumber'+k).val();
                                if((isNaN(parseFloat(slipnumber))||parseFloat(slipnumber)==0) && ptypes=="Bank-Transfer" && (banknames!=""||banknames!=null)){
                                    $('#BankTransferNumber'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#SettlementAmount'+k).val())!=undefined){
                                var settlementamnt=$('#SettlementAmount'+k).val();
                                if(isNaN(parseFloat(settlementamnt))||parseFloat(settlementamnt)==0){
                                    $('#SettlementAmount'+k).css("background", errorcolor);
                                }
                                if(parseFloat(settlementamnt)>parseFloat(remainingamnt)){
                                    $('#SettlementAmount'+k).val("");
                                    $('#SettlementAmount'+k).css("background", errorcolor);
                                    error_html = ',</br>Settlement amount is greater remaining amount';
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
                        toastrMessage('error',"Please insert valid data on highlighted fields"+error_html,"Error");
                    }
                    else if(data.emptyerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add atleast one sales settlement","Error");
                    } 
                    else if(data.duplicateerr){
                        for(var k=1;k<=m;k++){
                            var isduplicatechq=($('#IsDuplicatedChequnum'+k)).val();
                            var isduplicateslip=($('#IsDuplicateslipnum'+k)).val();
                            if(parseFloat(isduplicatechq)==1){
                                $('#ChequeNumber'+k).css("background", errorcolor);
                            }
                            else if(parseFloat(isduplicateslip)==1){
                                $('#BankTransferNumber'+k).css("background", errorcolor);
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
                        toastrMessage('error',"You inserted a duplicate data on highlighted fields","Error");
                    }
                    else if(data.dbduplicateerr){
                        for(var k=1;k<=m;k++){
                            var isduplicatechq=($('#DbIsDuplicatedChequnum'+k)).val();
                            var isduplicateslip=($('#DbIsDuplicateslipnum'+k)).val();
                            if(parseFloat(isduplicatechq)==1){
                                $('#ChequeNumber'+k).css("background", errorcolor);
                            }
                            else if(parseFloat(isduplicateslip)==1){
                                $('#BankTransferNumber'+k).css("background", errorcolor);
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
                        toastrMessage('error',"The data on highlighted fields are taken before</br> please use another data","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crudsett').dataTable();
                        oTable.fnDraw(false);
                        closeModalWithClearValidation();
                        $("#settlementmodal").modal('hide');
                    }
                }
            });
        });

        function editsettlementdata(recIdVar) {
            var customercat="";
            var cusnames="";
            var custn="";
            var cuscd="";
            var stname="";
            var settcount=0;
            var lastrow=0;
            $('.select2').select2();
            //var recIdVar = $(this).data('id');
            $("#operationtypes").val("2");
            var j=0;
            $.get("/salessettedit" + '/' + recIdVar, function(data) {
                var statusvals = data.recData.Status;
                var fyearrec = data.recData.fiscalyear;
                var fyearcurr=data.fiscalyr;
                cusnames=data.cusname;
                custn=data.custin;
                cuscd=data.cuscode;
                stname=data.statusnameval;
                settcount=data.settcnt;
                $('#isnewVal').val(settcount);
                if (statusvals == 4) {
                    toastrMessage('error',"You cant update on this status","Error");
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
                else{
                    $('#settlementId').val(recIdVar);
                    $('#settlementmodal').modal('show');
                    $.get("/salessettedit" + '/' + recIdVar, function(data) {
                        $('#date').val(data.recData.DocumentDate);
                        $('#date').prop("readonly",true);
                        $('#PointOfSales').select2('destroy');
                        $('#PointOfSales').val(data.recData.stores_id).trigger('change').select2();
                        $('#Customer').select2('destroy');
                        $('#Customer').append('<option selected value='+data.recData.customers_id+'>'+cuscd+"    ,   "+cusnames+"    ,   "+custn+'</option>');
                        $('#Customer').val(data.recData.customers_id).trigger('change').select2();
                        $('#CrvNumber').val(data.recData.CrvNumber);
                        $('#Memo').val(data.recData.Memo);
                        $('#totaloutstandingi').val(data.recData.OutstandingAmount);
                        $('#cusoutstandinglbl').html(numformat(data.recData.OutstandingAmount.toFixed(2)));
                        var statusvals=data.recData.Status;
                        if(statusvals==1){
                            $("#statusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+stname+"</span>");
                        }
                        else if(statusvals==2){
                            $("#statusdisplay").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;'>"+stname+"</span>");
                        }
                        else if(statusvals==3){
                            $("#statusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+stname+"</span>");
                        }
                        $.each(data.settedit, function(key, value) {
                            var settstatusval="";
                            var vatst=0;
                            var withst=0;
                            var editnetpay=0;
                            var paymenttypeopt="";
                            var selectedoptions="";
                            var options="";
                            var defpaymenttype="";
                            ++i;
                            ++m;
                            ++j;
                            if(value.SettlementStatus==0){
                                settstatusval="Not-Paid";
                            }
                            if(value.SettlementStatus==1){
                                settstatusval="Partially-Paid";
                            }
                            if(value.SettlementStatus==2){
                                settstatusval="Fully-Paid";
                            }
                            if(value.WSettle==1){
                                withst=value.WAmount;
                            }
                            if(value.VSettle==1){
                                vatst=value.VAmount;
                            }
                            editnetpay=parseFloat(value.GrandTotal)-parseFloat(withst)-parseFloat(vatst);
                            $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:2%;text-align:center;">'+j+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                                '<td style="display:none;" id="salesids'+m+'" class="salesids">'+value.sales_id+'</td>'+
                                '<td style="width:10%;"><select id="FSInvNumber'+m+'" class="select2 form-control form-control fsninvoicenum" onchange="fsInVal(this)" name="row['+m+'][sales_id]"><option selected value="'+value.SalesId+'">'+value.VoucherNum+'  ,   '+value.InvNum+'</option></select></td>'+
                                '<td style="width:8%;"><input type="text" name="row['+m+'][RemainingDay]" placeholder="Remaining Day" id="RemainingDay'+m+'" class="RemainingDay form-control" value="'+value.RemainingDate+'" readonly="true"/></td>'+
                                '<td style="width:8%;"><input type="text" name="row['+m+'][RemainingAmount]" placeholder="Remaining Amount" id="RemainingAmount'+m+'" class="RemainingAmount form-control" value="'+value.RemainingAmount+'" readonly="true"/></td>'+
                                '<td style="width:9%;"><select id="PaymentType'+m+'" class="select2 form-control PaymentType" onchange="paymenttypeval(this)" name="row['+m+'][PaymentType]"></select></td>'+
                                '<td style="width:12%;"><select id="BankName'+m+'" class="select2 form-control BankName" onchange="banknameval(this)" name="row['+m+'][BankName]"></select></td>'+
                                '<td style="width:10%;"><select id="AccountNumber'+m+'" class="select2 form-control AccountNumber" onchange="AccnumVal(this)" name="row['+m+'][AccountNumber]"></select></td>'+
                                '<td style="width:10%;"><input type="number" name="row['+m+'][BankTransferNumber]" placeholder="Slip Number" id="BankTransferNumber'+m+'" class="BankTransferNumber form-control" value="'+value.BankTransferNumber+'" onkeyup="slipnumberval(this)" onblur="removedupslp(this)" style="text-transform: uppercase;"/></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][SettlementAmount]" placeholder="Settlement Amount" id="SettlementAmount'+m+'" class="SettlementAmount form-control numeral-mask" value="'+value.SettlementAmount+'" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondblclick="CloneValue(this)" readonly="true"/></td>'+
                                '<td style="width:8%;"><input type="text" name="row['+m+'][SettStatus]" placeholder="Status" id="SettStatus'+m+'" class="SettStatus form-control" value="'+settstatusval+'" readonly="true"/></td>'+
                                '<td style="width:10%;"><input type="text" name="row['+m+'][Remark]" placeholder="Write Remark here..." id="Remark'+m+'" value="'+value.RemarkData+'" class="Remark form-control"/></td>'+
                                '<td style="width:2%;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][NetPaySales]" placeholder="Net Pay Sales" id="NetPaySales'+m+'" class="NetPaySales form-control" value="'+editnetpay+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][InvoiceDate]" placeholder="Invoice Date" id="InvoiceDate'+m+'" class="InvoiceDate form-control" value="'+value.CreatedDate+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][SettledBalance]" placeholder="Settled Balance" id="SettledBalance'+m+'" class="SettledBalance form-control" value="'+value.SettledBalance+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][IsDuplicatedChequnum]" placeholder="" id="IsDuplicatedChequnum'+m+'" class="IsDuplicatedChequnum form-control" readonly="true" value="0"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][IsDuplicateslipnum]" placeholder="" id="IsDuplicateslipnum'+m+'" class="IsDuplicateslipnum form-control" readonly="true" value="0"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][DbIsDuplicatedChequnum]" placeholder="" id="DbIsDuplicatedChequnum'+m+'" class="DbIsDuplicatedChequnum form-control" readonly="true" value="0"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][DbIsDuplicateslipnum]" placeholder="" id="DbIsDuplicateslipnum'+m+'" class="DbIsDuplicateslipnum form-control" readonly="true" value="0"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][SubTotal]" placeholder="" id="SubTotal'+m+'" class="SubTotal form-control" value="'+value.STotal+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][Tax]" placeholder="" id="Tax'+m+'" class="Tax form-control" value="'+value.Taxes+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][GrandTotal]" placeholder="" id="GrandTotal'+m+'" class="GrandTotal form-control" value="'+value.GTotal+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][WitholdAmount]" placeholder="" id="WitholdAmount'+m+'" class="WitholdAmount form-control" value="'+value.WAmount+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][Vat]" placeholder="" id="Vat'+m+'" class="Vat form-control" readonly="true" value="'+value.VAmount+'"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][WitholdSetle]" placeholder="" id="WitholdSetle'+m+'" class="WitholdSetle form-control" value="'+value.WSettle+'" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][VatSetle]" placeholder="" id="VatSetle'+m+'" class="VatSetle form-control" readonly="true" value="'+value.VSettle+'"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][expdatei]" placeholder="" id="expdatei'+m+'" class="expdatei form-control" readonly="true" value="'+value.CreatedDate+'"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][settexpdatei]" placeholder="" id="settexpdatei'+m+'" class="settexpdatei form-control" readonly="true" value="'+value.SettExpireDate+'"/></td>'+
                                '<td style="display:none;width:10%;"><input type="number" name="row['+m+'][ChequeNumber]" placeholder="Cheque Number" id="ChequeNumber'+m+'" class="ChequeNumber form-control" value="'+value.ChequeNumber+'" onkeyup="chequenumberval(this)" onblur="removedupchq(this)" onkeypress="return ValidateNum(event);" readonly="true"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][contactnum]" id="contactnum'+m+'" class="contactnum form-control" readonly="true" value="'+value.ContactNumber+'"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][branchadd]" id="branchadd'+m+'" class="branchadd form-control" readonly="true" value="'+value.Branch+'"/></td>'+
                                '<td style="display:none;"><input type="text" name="row['+m+'][SettlementStatus]" placeholder="Settlement Status" id="SettlementStatus'+m+'" value="'+value.SettlementStatus+'" class="SettlementStatus form-control" readonly="true"/><input type="text" name="row['+m+'][VoucherType]" placeholder="Voucher Type" id="VoucherType'+m+'" class="VoucherType form-control" readonly="true"/><input type="text" name="row['+m+'][MRC]" placeholder="MRC #" id="MRC'+m+'" class="MRC form-control" readonly="true"/></td></tr>'  
                            );
                            $("#FSInvNumber"+m).select2({
                                dropdownCssClass : 'dynamicselect2',
                            });

                            // if(value.PaymentType=="Cash"){
                            //     paymenttypeopt = '<option selected value="Cash">'+value.PaymentType+'</option><option value="Cheque">Cheque</option><option value="Bank-Transfer">Bank-Transfer</option>';
                            //     $('#ChequeNumber'+m).prop("readonly", true);
                            //     $('#BankTransferNumber'+m).prop("readonly", true);
                            //     $('#BankTransferNumber'+m).css("background","#efefef");
                            //     $('#ChequeNumber'+m).css("background","#efefef");
                            //     $('#ChequeNumber'+m).val("");
                            //     $('#BankTransferNumber'+m).val("");
                            //     $('#BankName'+m).empty();
                            //     selectedoptions='<option selected value="-"></option>';
                            //     $('#BankName'+m).append(selectedoptions); 
                            //     $('#BankName'+m).select2
                            //     ({
                            //         placeholder: "---",
                            //         minimumResultsForSearch: -1
                            //     });
                            // }
                            // if(value.PaymentType=="Cheque"){
                            //     $('#ChequeNumber'+m).prop("readonly",false);
                            //     $('#BankTransferNumber'+m).prop("readonly",true);
                            //     $('#ChequeNumber'+m).css("background","white");
                            //     $('#BankTransferNumber'+m).css("background","#efefef");
                            //     $('#BankTransferNumber'+m).val("");
                            //     paymenttypeopt = '<option value="Cash">Cash</option><option selected value="Cheque">'+value.PaymentType+'</option><option value="Bank-Transfer">Bank-Transfer</option>';
                            //     selectedoptions='<option selected value="'+value.BankName+'">'+value.BankName+'</option>';
                            //     options= $("#bank > option").clone();
                            //     $('#BankName'+m).append(options); 
                            //     $('#BankName'+m).append(selectedoptions); 
                            //     $("#BankName"+m).select2({
                            //         dropdownCssClass : 'dynamicselect2',
                            //     });
                            // }
                            // if(value.PaymentType=="Bank-Transfer"){
                            //     $('#ChequeNumber'+m).prop("readonly",true);
                            //     $('#BankTransferNumber'+m).prop("readonly",false);
                            //     $('#ChequeNumber'+m).css("background","#efefef");
                            //     $('#BankTransferNumber'+m).css("background","white");
                            //     $('#ChequeNumber'+m).val("");
                            //     paymenttypeopt = '<option value="Cash">Cash</option><option value="Cheque">Cheque</option><option selected value="Bank-Transfer">'+value.PaymentType+'</option>';
                            //     selectedoptions='<option selected value="'+value.BankName+'">'+value.BankName+'</option>';
                            //     options= $("#bank > option").clone();
                            //     $('#BankName'+m).append(options); 
                            //     $('#BankName'+m).append(selectedoptions); 
                            //     $("#BankName"+m).select2({
                            //         dropdownCssClass : 'dynamicselect2',
                            //     });
                            // }

                            paymenttypeopt = '<option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Bank-Transfer">Bank-Transfer</option>';
                            defpaymenttype='<option selected value="'+value.PaymentType+'">'+value.PaymentType+'</option>';
                            $('#PaymentType'+m).append(paymenttypeopt);
                            $("#PaymentType"+m+" option[value='"+value.PaymentType+"']").remove();
                            $('#PaymentType'+m).append(defpaymenttype);
                            $('#PaymentType'+m).select2({
                                minimumResultsForSearch: -1
                            }); 

                            var bankdef='<option selected value="'+value.banks_id+'">'+value.BankNames+'</option>';
                            var options = $("#bank > option").clone();
                            $('#BankName'+m).append(options);
                            $("#BankName"+m+" option[value='"+value.banks_id+"']").remove();
                            $('#BankName'+m).append(bankdef);
                            $('#BankName'+m).select2();

                            var accnum='<option selected value="'+value.bankdetails_id+'">'+value.AccountNumber+'</option>';
                            var accoptions = $("#AccData > option").clone();
                            $('#AccountNumber'+m).append(accoptions);
                            $("#AccountNumber"+m+" option[title!='"+value.banks_id+"']").remove();
                            $("#AccountNumber"+m+" option[value='"+value.bankdetails_id+"']").remove();
                            $('#AccountNumber'+m).append(accnum);
                            $('#AccountNumber'+m).select2();

                            $('#select2-FSInvNumber'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-BankName'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-PaymentType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-AccountNumber'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        });
                        $('.remove-tr').prop("disabled",true);
                        if(parseFloat(settcount)==0){
                            lastrow=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
                            $("#removebtn"+lastrow).prop("disabled",false);
                            $("#SettlementAmount"+lastrow).prop("readonly",false);
                        }
                        renumberRows();
                        CalculateGrandTotal();
                    });
                    $("#newsettlementheader").html("Update Sales Settlement");
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled",false);
                    $("#pricingTable").show();
                }
            });
        }

 
        //Start change to verified
        $('#verifysettbtn').click(function() {
            var recordId = $('#checkedid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(settstatus)==1){
                    var registerForm = $("#verifysettlementform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/verifyStatus',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#verifysettbtn').text('Verifying...');
                            $('#verifysettbtn').prop("disabled", true);
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
                            
                            if (data.success) {
                                $('#verifysettbtn').text('Verify Settlement');
                                toastrMessage('success',"Settlement verified","Success");
                                $("#changetopending").show();
                                $("#confirmsettlement").show();
                                $("#verifysettlementbtn").hide();
                                var today = new Date();
                                var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
                                var un=$("#usernamelbl").val();
                                $("#verifiedbylblinfo").html(un);
                                $("#verifieddatelblinfo").html(currentdate);
                                $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>Verified</span>");
                                $("#settlementverifymodal").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant verify settlement on "+statusvals+" status","Error");
                    $("#settlementverifymodal").modal('hide');
                    $("#settlementrecordInfo").modal('hide');
                    var oTable = $('#laravel-datatable-crudsett').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End change to verified

        //Start change to pending
        $('#pendingbtn').click(function() {
            var recordId = $('#pendingid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(settstatus)==2){
                    var registerForm = $("#pendingsettlementform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/pendingsettStatus',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#pendingbtn').text('Changing...');
                            $('#pendingbtn').prop("disabled",true);
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
                            
                            if (data.success) {
                                $('#pendingbtn').text('Change to Pending');
                                toastrMessage('success',"Settlement changed to pending","Success");
                                $("#changetopending").hide();
                                $("#confirmsettlement").hide();
                                $("#verifysettlementbtn").show();
                                var today = new Date();
                                var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
                                var un=$("#usernamelbl").val();
                                $("#topendingbylblinfo").html(un);
                                $("#topendingdatelblinfo").html(currentdate);
                                $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>Pending</span>");
                                $("#settlementpendingmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant change settlement to pending on "+statusvals+" status","Error");
                    $("#settlementpendingmodal").modal('hide');
                    $("#settlementrecordInfo").modal('hide');
                    var oTable = $('#laravel-datatable-crudsett').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End change to pending

        //Start change to confirm
        $('#confirmbtn').click(function() {
            var recordId = $('#confirmid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(settstatus)==2){
                    var registerForm = $("#confirmedsettlementform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/confirmSettStatus',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#confirmbtn').text('Confirming...');
                            $('#confirmbtn').prop("disabled",true);
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
                            if (data.success) {
                                $('#confirmbtn').text('Confirm Settlement');
                                toastrMessage('success',"Settlement confirmed","Success");
                                $("#settlementconfirmedmodal").modal('hide');
                                $("#settlementrecordInfo").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant confirm settlement on "+statusvals+" status","Error");
                    $("#settlementpendingmodal").modal('hide');
                    $("#settlementrecordInfo").modal('hide');
                    var oTable = $('#laravel-datatable-crudsett').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End change to confirm

        //Start void settlement
        $('#voidbtn').click(function() {
            var recordId = $('#voididn').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(settstatus)==1||parseFloat(settstatus)==2||parseFloat(settstatus)==3){
                    var registerForm = $("#voidreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/voidSett',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#voidbtn').text('Voiding...');
                            $('#voidbtn').prop("disabled",true);
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
                            if (data.errors) {
                                if (data.errors.Reason) {
                                    $('#void-error').html(data.errors.Reason[0]);
                                }
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.success) {
                                $('#voidbtn').text('Void');
                                toastrMessage('success',"Settlement voided","Success");
                                $("#voidreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant void settlement on "+statusvals+" status","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crudsett').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End void settlement

        //Start undo void settlement
        $('#undovoidbtn').click(function() {    
            var recordId = $('#undovoidid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(settstatus)==4||parseFloat(settstatus)==5||parseFloat(settstatus)==6||parseFloat(settstatus)==7){
                    var registerForm = $("#undovoidform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/undovoidSett',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#undovoidbtn').text('Changing...');
                            $('#undovoidbtn').prop("disabled",true);
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
                            if (data.undoerror) {
                                $('#undovoidbtn').text('Undo Void');
                                $('#undovoidbtn').prop("disabled", false);
                                toastrMessage('error',"CRV number already taken by another settlement","Error");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                            if (data.balancerror) {
                                $('#undovoidbtn').text('Undo Void');
                                $('#undovoidbtn').prop("disabled", false);
                                toastrMessage('error',"All outstanding amount has been settled","Error");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                            if (data.success) {
                                $('#undovoidbtn').text('Undo Void');
                                toastrMessage('success',"Settlement voided","Success");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crudsett').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant undo void settlement on "+statusvals+" status","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crudsett').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End undo void settlement

        $('body').on('click', '.voidlnbtn', function() {
            var recordId = $(this).data('id');
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            $('.Reason').val("");
            $('#void-error').html("");
            $("#voididn").val(recordId);
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                cnt=data.count;
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(cnt)>=1){
                    toastrMessage('error',"After these transactions, you settled credit sales for these customers","Error");
                }
                else if(parseFloat(cnt)==0){
                    if(parseFloat(settstatus)==1||parseFloat(settstatus)==2||parseFloat(settstatus)==3){
                        
                        $('#vstatus').val(settstatus);
                        $('#voidbtn').prop("disabled", false);
                        $('#voidbtn').text("Void");
                        $("#voidreasonmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"You cant void settlement on "+statusvals+" status","Error");
                        var oTable = $('#laravel-datatable-crudsett').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });

        //$('body').on('click', '.undovoidlnbtn', function() {
        function undovoidlnbtn(recordId){
            //var recordId = $(this).data('id');
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            $("#undovoidid").val(recordId);
            $.get("/showsettlementrec" + '/' + recordId, function(data) {
                cnt=data.vcount;
                $.each(data.settlist, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(cnt)>=1){
                    toastrMessage('error',"Before these transactions, you void settlements for these customers","Error");
                }
                else if(parseFloat(cnt)==0){
                    if(parseFloat(settstatus)==4||parseFloat(settstatus)==5||parseFloat(settstatus)==6||parseFloat(settstatus)==7){
                        
                        $('#vstatus').val(settstatus);
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"You cant undo void settlement on "+statusvals+" status","Error");
                        var oTable = $('#laravel-datatable-crudsett').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        function crvdetailFn(vnum,strid){
            var totalcreditsales=0;
            $.get("/showsalesinfo" + '/' + vnum+'/'+strid, function(data) {
                $.each(data.salesinfo, function(key, value) {
                    $('#crvdetposlbl').html(value.POS);
                    $('#crvdetfslbl').html(value.VoucherNumber);
                    $('#crvdetinvlbl').html(value.invoiceNo);
                    $('#crvdetdocdatelbl').html(value.CreatedDate);
                    $('#crvdetduedatelbl').html(value.settlementexpiredate);
                    $('#crvdetfiscalyrlbl').html(value.Monthrange);
                    $('#crvdetcreditsaleslbl').html(numformat(value.CreditSales.toFixed(2)));
                    totalcreditsales=value.CreditSales; 
                    if(value.setlmentstatus==0){
                        $("#crvdetpaymentstlbl").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:14px;'>"+value.PaymentStatus+"</span>");
                    }
                    if(value.setlmentstatus==1){
                        $("#crvdetpaymentstlbl").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:14px;'>"+value.PaymentStatus+"</span>");
                    }
                    if(value.setlmentstatus==2){
                        $("#crvdetpaymentstlbl").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:14px;'>"+value.PaymentStatus+"</span>");
                    }
                });

                $('#crvdetaildatatable').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: true,
                    info: false,
                    searchHighlight: true,
                    "ordering": false,
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
                        url: '/showcrvdetaildata/' + vnum+'/'+strid,
                        type: 'DELETE',
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            'visible': false
                        },
                        { data:'DT_RowIndex'},
                        {
                            data: 'CrvNumber',
                            name: 'CrvNumber',
                            'visible': false
                        },
                        {
                            data: 'DocumentDate',
                            name: 'DocumentDate',
                            'visible': false
                        },
                        {
                            data: 'PaymentType',
                            name: 'PaymentType'
                        },
                        {
                            data: 'BankName',
                            name: 'BankName'
                        },
                        {
                            data: 'ChequeNumber',
                            name: 'ChequeNumber'
                        },
                        {
                            data: 'BankTransferNumber',
                            name: 'BankTransferNumber'
                        },
                        {
                            data: 'SettlementAmount',
                            name: 'SettlementAmount',
                            render: $.fn.dataTable.render.number(',', '.',2,'')
                        },
                        {
                            data: 'SettlementPaymentStatus',
                            name: 'SettlementPaymentStatus',
                            'visible': false
                        },
                        {
                            data: 'CRVInfo',
                            name: 'CRVInfo',
                            'visible': false
                        },
                    ],
                    rowGroup: {
                        startRender: function ( rows, group,level ) {
                            var color = 'style="color:black;font-weight:bold;"';
                            if(level===0){
                                var text=group;
                                text = text.replace("bl", "<div style='display:block;'>");
                                text = text.replace("ble", "</div>");
                                text = text.replace("Fully-Paid", "<b style='color:#1cc88a'>Fully-Paid</b>");
                                text = text.replace("Partially-Paid", "<b style='color:#f6c23e'>Partially-Paid</b>");
                                text = text.replace("Not-Paid", "<b style='color:#e74a3b'>Not-Paid</b>");
                                text = text.replace("bln", "<div style='display:none;'>");
                                text = text.replace("blne", "</div>");
                                return $('<tr>').append('<td colspan="6" style="text-align:left;"><b>' + text + ' </b></td></tr>')
                            }                         
                        },
                        endRender: function ( rows, group,level ) {
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                            i : 0;
                            };

                            var totalsettledamount = rows
                            .data()
                            .pluck('SettlementAmount')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0); 

                            var color = 'style="color:black;font-weight:bold;"';

                            if(level===0){
                                var text=group;
                                text = text.replace("bl", "<div style='display:none;'>");
                                text = text.replace("ble", "</div>");
                                text = text.replace("bln", "<div style='display:block;'>");
                                text = text.replace("blne", "</div>");
                                return $('<tr>').append('<td colspan="5" style="text-align:right;"> ' + text+ '</td>').append('<td style="text-align:left;">'+ numformat(totalsettledamount.toFixed(2))+'</td></tr>'); 
                                }   
                        },
                        dataSrc: ['CRVInfo']
                    },
                    // "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    //     if (aData.SettlementPaymentStatus == "Not-Paid") {
                    //         $(nRow).find('td:eq(8)').css({"color": "#e74a3b", "font-weight": "bold"});
                    //     } else if (aData.SettlementPaymentStatus == "Partially-Paid") {
                    //         $(nRow).find('td:eq(8)').css({"color": "#f6c23e", "font-weight": "bold"});
                    //     } else if (aData.SettlementPaymentStatus == "Fully-Paid") {
                    //         $(nRow).find('td:eq(8)').css({"color": "#1cc88a", "font-weight": "bold"});
                    //     } 
                    // },
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(),data;
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };
                        var totalsett = api
                            .column( 8 )
                            .data()
                            .reduce( function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0 );
                        var outstandingbalance=parseFloat(totalcreditsales)-parseFloat(totalsett);
                        $("#crvdetsettamountlbl").html(numformat(totalsett.toFixed(2)));
                        $("#crvdetoutstandinglbl").html(numformat(outstandingbalance.toFixed(2)));
                        $("#crvtotalsettledamountlbl").html(numformat(totalsett.toFixed(2)));
                    }
                });
            });

            $(".crvdetinfocl").collapse('show');
            $('#crvdetailmodal').modal('show');
        }

        function getVerifyInfoConf() {
            var stid = $('#statusid').val();
            $('#checkedid').val(stid);
            $('#settlementverifymodal').modal('show');
            $('#verifysettbtn').prop("disabled", false);
            $('#verifysettbtn').text("Verify Settlement");
        }

        function getPendingInfoConf() {
            var stid = $('#statusid').val();
            $('#pendingid').val(stid);
            $('#settlementpendingmodal').modal('show');
            $('#pendingbtn').prop("disabled", false);
            $('#pendingbtn').text("Change to Pending");
        }

        function getConfirmInfoConf() {
            var stid = $('#statusid').val();
            $('#confirmid').val(stid);
            $('#settlementconfirmedmodal').modal('show');
            $('#confirmbtn').prop("disabled", false);
        }

        //Start Print Attachment
        $('body').on('click', '.printAttachment', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Settlement', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        function closeAll() {
            //getallbalance(fyears);
            //getallpurchasebl();
            //getsalesperstore();
            //var hTable = $('#laravel-datatable-crud').dataTable();
            //hTable.fnDraw(false);
        }

        function settlementinfofn() {
            var iTable = $('#laravel-datatable-crudsett').dataTable();
            iTable.fnDraw(false);
        }

        function closeSettlementEdit() {
            $('#paymenttypeed-error').html("");
            $('#crvnoed-error').html("");
            $('#dateed-error').html("");
            $('#chequenoed-error').html("");
            $('#banked-error').html("");
            $('#settlementamounted-error').html("");
        }

        function creditorsval() {
            $('#newbtndiv').hide();
            getallbalance(fyears);
            getsalesperstore(fyears);
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
        }

        function settlementtabval() {
            $('#newbtndiv').show();
            var oTable = $('#laravel-datatable-crudsett').dataTable(); 
            oTable.fnDraw(false);
        }

        function voidReason() {
            $('#void-error').html("");
        }

        function showmorefn() {
            $("#showmorebtn").hide();
            $("#showlessbtn").show();
			$(".crpropinfo").show();
        }

        function showlessfn() {
            $("#showmorebtn").show();
            $("#showlessbtn").hide();
			$(".crpropinfo").hide();
        }

        function dateDiffInDays(firstDate, secondDate) {
            // Discard the time and time-zone information.
            var startDay = new Date(firstDate);
            var endDay = new Date(secondDate);
            var millisBetween = startDay.getTime() - endDay.getTime();
            var days = millisBetween / (1000 * 3600 * 24);
            return Math.round(Math.abs(days));
        }

        $('[data-toggle="popover"]').popover({
            html: true, 
            content: function() {
                return $('#laravel-datatable-crud').html();
                }
        });

       $('.popper').popover({
    container: 'body',
    html: true,
    content: function () {
        return $(this).next('.popper-content').html();
    }
});
        function search_table(value){  
            var settlementamnt=0;
            $('#dynamicTable tr').each(function(){  
                var found = 'false';  
                $(this).each(function(){  
                    if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
                    {  
                        found = 'true';  
                    }  
                });  
                if(found == 'true')  
                {  
                    var searchval=$('#dynamicTable tr').find('td').eq(14).text();
                    $.each($('#dynamicTable').find('.SettlementAmount'), function() {
                        if(parseFloat(searchval)==parseFloat(value)){
                            if ($(this).val() != '' && !isNaN($(this).val())) {
                                settlementamnt += parseFloat($(this).val());
                            }
                        }
                    });
                }  
                else  
                {  
                    //$(this).hide();  
                }  
            });  
        }

        $(function(){
            $('.creditsllink').popover({
                trigger: "hover",
                title:"Credit Sales and Settlement",
                width:'100px',
                container: "body",
                html: true,
                content: function () {
                    return $("#creditsalesdiv").html();
                }
            });
        });

        $(function(){
            $('.cuscreditsllink').popover({
                trigger: "hover",
                title:"Credit Sales and Settlement",
                width:'100px',
                container: "body",
                html: true,
                content: function () {
                    return $("#cuscreditsalesdiv").html();
                }
            });
        });
    
    </script>
    <script>  
        $(document).ready(function(){  
            $('#search').keyup(function(){  
                search_table($(this).val());  
            });  
              
        });  
    </script>  
@endsection
