@extends('layout.app1')

@section('title')
@endsection

@section('content')
    <div class="app-content content">
        @can('Income-Follow-Up-View')
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div style="width:22%;">
                                    <h3 class="card-title">Income Follow-Up</h3>
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
                                @if (auth()->user()->can('Income-Follow-Up-Add'))
                                <button type="button" class="btn btn-gradient-info btn-sm addpaymentfollowup">Add</button>
                                @endif
                            </div>
                            <div class="card-datatable">
                                <div style="width:98%; margin-left:1%;">
                                    <div>
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th style="width: 3%">#</th>
                                                    <th style="width: 24%">Document Number</th>
                                                    <th style="width: 24%">POS</th>
                                                    <th style="width: 24%">Date</th>
                                                    <th style="width: 22%">Status</th>
                                                    <th></th>
                                                    <th style="width:3%;">Action</th>
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
            </section>
        @endcan
    </div>

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="paymentfollowuptitle" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="paymentfollowuptitle">Add Payment Follow-Up</h4>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-12">
                                            <label strong style="font-size: 14px;">Point of Sales</label>
                                            <div>
                                                <select class="select2 form-control" name="PointOfSales" id="PointOfSales">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($storeSrc as $storeSrc)
                                                        <option value="{{$storeSrc->StoreId}}">{{$storeSrc->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="pointofsales-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <label strong style="font-size: 14px;">Date</label>
                                            <div>
                                                <input type="text" class="form-control" id="datetimes" name="datetimes" placeholder="YYYY-MM-DD to YYYY-MM-DD" readonly="readonly" onchange="datetimefn(1)" style="background-color:#FFFFFF" value=""/>
                                                <div id="followdate" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;display:none;">
                                                    <i class="fa fa-calendar"></i>&nbsp;<span></span> <i class="fa fa-caret-down"></i>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="date-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-6 col-lg-12">
                                            <label strong style="font-size: 14px;">Upload Z-Receipt</label>
                                            <div>
                                                <input type="file" class="form-control" name="ZRecDoc" id="ZRecDoc" accept="application/pdf,image/*" onchange="clearZError()">
                                            </div>
                                            <span class="mt-1">
                                                <button type="button" id="zdocumentlinkbtn" name="zdocumentlinkbtn" class="btn btn-flat-info waves-effect zdocumentlinkbtn" onclick="ZdocumentDownload()" style="display:none;"></button>
                                                <input type="hidden" name="znumberval" id="znumberval" class="form-control" readonly> 
                                            </span><br>
                                            <span class="text-danger">
                                                <strong id="zrec-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12">
                                            <label strong style="font-size: 14px;">Upload Bank Transaction Ref.</label>
                                            <div>
                                                <input type="file" class="form-control" name="BankSlip" id="BankSlip" accept="application/pdf,image/*" onchange="clearBankSlError()">
                                            </div>
                                            <span class="mt-1">
                                                <button type="button" id="slipdocumentlinkbtn" name="slipdocumentlinkbtn" class="btn btn-flat-info waves-effect slipdocumentlinkbtn" onclick="SlipdocumentDownload()" style="display:none;"></button>
                                                <input type="hidden" name="bankslipval" id="bankslipval" class="form-control" readonly> 
                                            </span><br>
                                            <span class="text-danger">
                                                <strong id="banksl-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <label strong style="font-size: 14px;">Memo</label>
                                            <div>
                                                <textarea type="text" placeholder="Write Memo here..." class="form-control" name="Memo" id="Memo"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error"></strong>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xl-8 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title" id="revenuetitle">Income</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <label style="font-size: 14px;font-weight:bold;">Fiscal Receipt</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 24%"><label style="font-size: 12px;" title="Cash Income">Cash Inc.</label></td>
                                                                    <td style="width: 25%">
                                                                        <a id="fiscalcashreceiptlbl" style="text-decoration:underline;color:blue;font-weight:bold;font-size: 12px;" onclick="detTransactionFn('1')"></a>
                                                                        <input type="hidden" class="form-control form-control-sm" name="FiscalCashIncHidden" id="FiscalCashIncHidden" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                    <td style="width: 1%"></td>
                                                                    <td style="width: 25%">
                                                                        <label style="font-size: 12px;" title="Credit Income">Credit Inc.</label>
                                                                    </td>
                                                                    <td style="width: 25%">
                                                                        <a id="fiscalcreditreceiptlbl" style="text-decoration:underline;color:blue;font-weight:bold;font-size: 12px;" onclick="detTransactionFn('2')"></a>
                                                                        <input type="hidden" class="form-control form-control-sm" name="FiscalCreditIncHidden" id="FiscalCreditIncHidden" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 12px;" title="Other Cash Income">Other Cash</label></td>
                                                                    <td>
                                                                        <input type="number" step="any" placeholder="Other Income" class="form-control form-control-sm" name="OtherIncome" id="OtherIncome" onkeypress="return ValidateNum(event);" onkeyup="calcotherfn()" style="font-size: 12px;" />
                                                                    </td>
                                                                    <td></td>
                                                                    <td><label style="font-size: 12px;" title="Other Credit Income">Other Credit</label></td>
                                                                    <td>
                                                                        <input type="number" step="any" placeholder="Other Income" class="form-control form-control-sm" name="CreditFiscalOtherIncome" id="CreditFiscalOtherIncome" onkeypress="return ValidateNum(event);" onkeyup="calcfiscreditfn()" style="font-size: 12px;" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <div class="divider">
                                                                            <div class="divider-text">-</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="mt-3">
                                                                    <td><label style="font-size: 12px;" title="Total Cash Income">Total Cash</label></td>
                                                                    <td>
                                                                        <label style="font-size: 12px;font-weight:bold;" id="cashfiscaltotallbl"></label>
                                                                        <input type="hidden" class="form-control form-control-sm" name="cashfiscaltotalval" id="cashfiscaltotalval" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                    <td></td>
                                                                    <td><label style="font-size: 12px;" title="Total Credit Income">Total Credit</label></td>
                                                                    <td>
                                                                        <label style="font-size: 12px;font-weight:bold;" id="creditfiscaltotallbl"></label>
                                                                        <input type="hidden" class="form-control form-control-sm" name="creditfiscaltotalval" id="creditfiscaltotalval" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <label style="font-size: 14px;font-weight:bold;">Manual Receipt</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 24%"><label style="font-size: 12px;" title="Cash Income">Cash Inc.</label></td>
                                                                    <td style="width: 25%">
                                                                        <a id="manualcashreceiptlbl" style="text-decoration:underline;color:blue;font-weight:bold;font-size: 12px;" onclick="detTransactionFn('3')"></a>
                                                                        <input type="hidden" class="form-control form-control-sm" name="ManualCashIncHidden" id="ManualCashIncHidden" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                    <td style="width: 1%"></td>
                                                                    <td style="width: 25%">
                                                                        <label style="font-size: 12px;" title="Credit Income">Credit Inc.</label>
                                                                    </td>
                                                                    <td style="width: 25%">
                                                                        <a id="manualcreditreceiptlbl" style="text-decoration:underline;color:blue;font-weight:bold;font-size: 12px;" onclick="detTransactionFn('4')"></a>
                                                                        <input type="hidden" class="form-control form-control-sm" name="ManualCreditIncHidden" id="ManualCreditIncHidden" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label style="font-size: 12px;" title="Other Cash Income">Other Cash</label></td>
                                                                    <td>
                                                                        <input type="number" step="any" placeholder="Other Income" class="form-control form-control-sm" name="CashManualOtherIncome" id="CashManualOtherIncome" onkeypress="return ValidateNum(event);" onkeyup="calcmanualcashfn()" style="font-size: 12px;" />
                                                                    </td>
                                                                    <td></td>
                                                                    <td><label style="font-size: 12px;" title="Other Credit Income">Other Credit</label></td>
                                                                    <td>
                                                                        <input type="number" step="any" placeholder="Other Income" class="form-control form-control-sm" name="CreditManualOtherIncome" id="CreditManualOtherIncome" onkeypress="return ValidateNum(event);" onkeyup="calcmanualcreditfn()" style="font-size: 12px;" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="5">
                                                                        <div class="divider">
                                                                            <div class="divider-text">-</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="mt-3">
                                                                    <td><label style="font-size: 12px;" title="Total Cash Income">Total Cash</label></td>
                                                                    <td>
                                                                        <label style="font-size: 12px;font-weight:bold;" id="cashmanualtotallbl"></label>
                                                                        <input type="hidden" class="form-control form-control-sm" name="cashmanualtotalval" id="cashmanualtotalval" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                    <td></td>
                                                                    <td><label style="font-size: 12px;" title="Total Credit Income">Total Credit</label></td>
                                                                    <td>
                                                                        <label style="font-size: 12px;font-weight:bold;" id="creditmanualtotallbl"></label>
                                                                        <input type="hidden" class="form-control form-control-sm" name="creditmanualtotalval" id="creditmanualtotalval" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-12">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <label style="font-size: 14px;font-weight:bold;">Credit Sales Settled Amount</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:55%"><label style="font-size: 14px;">Cash Settlement Income</label></td>
                                                                    <td style="width:45%">
                                                                        <a id="settledamountlbl" style="text-decoration:underline;color:blue;font-weight:bold;font-size: 12px;" onclick="detTransactionFn('5')"></a>
                                                                        <input type="hidden" class="form-control form-control-sm" name="settledincomeval" id="settledincomeval" onkeypress="return ValidateNum(event);" style="font-size: 12px;" readonly="true" />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="divider" style="display: none;">
                                                        <div class="divider-text">Bank Deposit Variance</div>
                                                    </div>
                                                    <div class="row" style="display: none;">
                                                        <div class="col-xl-4 col-lg-6"></div>
                                                        <div class="col-xl-2 col-lg-6">
                                                            <label style="font-size: 14px;">Shortage Amount</label>
                                                            <input type="text" placeholder="Shortage Amount" class="form-control" name="ShortageAmount" id="ShortageAmount" onkeypress="return ValidateNum(event);" onkeyup="shortageVarFn()"/>
                                                            <span class="text-danger">
                                                                <strong id="shortageamount-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-6" style="text-align: left;">
                                                            <label style="font-size: 14px;">Overage Amount</label>
                                                            <input type="text" placeholder="Overage Amount" class="form-control" name="OverageAmount" id="OverageAmount" onkeypress="return ValidateNum(event);" onkeyup="overageVarFn()"/>
                                                            <span class="text-danger">
                                                                <strong id="overageamount-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-6"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-6 col-lg-12">
                                    <label strong style="font-size: 14px;">MRC Number</label>
                                    <div>
                                        <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="MrcNumber" id="MrcNumber" onchange="MrcNumberVal()"></select>
                                    </div>
                                    <span class="text-danger">
                                        <strong id="mrcnumber-error"></strong>
                                    </span>
                                </div> --}}
                            </div>
                            <div class="divider">
                                <div class="divider-text">MRC & Z-Number Selections</div>
                            </div>
                            
                            <div class="row" id="dynamictablediv">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dynamicTable" class="mb-0 rtable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:13%;">MRC Number</th>
                                                    <th style="width:13%;">Z-Number</th>
                                                    <th style="width:13%;">Z-Date</th>
                                                    <th style="width:14%;">Cash Amount</th>
                                                    <th style="width:14%;">Credit Amount</th>
                                                    <th style="width:14%;">Total Amount</th>
                                                    <th style="width:13%;">Business Day</th>
                                                    <th style="width:3%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <table class="mb-0">
                                            <tr>
                                                <td>
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-9 col-lg-12">
                                </div>
                                <div class="col-xl-3 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <table style="width:100%;" id="zpricingTable" class="mb-0 rtable">
                                                <tr>
                                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 14px;">Total Cash Amount</label></td>
                                                    <td style="text-align: center; width:50%;">
                                                        <label id="totalcashzamount" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="totalcashzamountinp" id="totalcashzamountinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;"><label strong style="font-size: 14px;">Total Credit Amount</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="totalcreditzamount" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="totalcreditzamountinp" id="totalcreditzamountinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;"><label strong style="font-size: 14px;">Grand Total</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="totalzamount" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="totalzamountinp" id="totalzamountinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Bank & Account Number Selections</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dynamicTableB" class="mb-0 rtable" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:10%;">Payment Mode</th>
                                                    <th style="width:16%;">Bank Name</th>
                                                    <th style="width:13%;">Account Number</th>
                                                    <th style="width:13%;">Transaction Ref. #</th>
                                                    <th style="width:10%;">Date</th>
                                                    <th style="width:13%;">Amount</th>
                                                    <th style="width:14%;">Remark</th>
                                                    <th style="width:8%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <table class="mb-0">
                                            <tr>
                                                <td>
                                                    <button type="button" name="addb" id="addb" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                </td>
                                            </tr>
                                        </table> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-9 col-lg-12">
                                </div>
                                <div class="col-xl-3 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <table style="width:100%;" id="deppricingTable" class="mb-0 rtable">
                                                <tr style="background-color: #f8f8f8;">
                                                    <td style="text-align: right;width:50%;"><label style="font-size: 14px;">Total Cash Deposited</label></td>
                                                    <td style="text-align: center; width:50%;">
                                                        <label id="depositedcashlbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="depositedcashinp" id="depositedcashinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr id="shortagevartr" class="variancetr" style="background-color: #f8f8f8;">
                                                    <td style="text-align: right;width:50%;"><label style="font-size: 14px;">Shortage Amount</label></td>
                                                    <td style="text-align: center; width:50%;">
                                                        <label id="shortageamountlbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="shortageamountinp" id="shortageamountinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr id="overagevartr" class="variancetr" style="background-color: #f8f8f8;">
                                                    <td style="text-align: right;width:50%;"><label style="font-size: 14px;">Overage Amount</label></td>
                                                    <td style="text-align: center; width:50%;">
                                                        <label id="overageamountlbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="overageamountinp" id="overageamountinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="col-xl-12 col-lg-12">
                                            <table style="width:100%;" id="pricingTable" class="mb-0 rtable">  
                                                <tr>
                                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 14px;">Total Cash Received</label></td>
                                                    <td style="text-align: center;width:50%;">
                                                        <label id="totalcash" class="formattedNum" strong
                                                            style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control"
                                                            name="totalcashi" id="totalcashi" readonly="true" value="0" />
                                                        <input type="hidden" placeholder="" class="form-control"
                                                            name="totalcashpermanent" id="totalcashpermanent" readonly="true" value="0" />
                                                        <input type="hidden" placeholder="" class="form-control"
                                                            name="totalinserted" id="totalinserted" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr id="witholdamounttr">
                                                    <td style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-minus" aria-hidden="true" style="color: #ea5455 !important"></i>     Withold Amount</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="withodcashlbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="witholdcashinp" id="witholdcashinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr id="vatamounttr">
                                                    <td style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-minus" aria-hidden="true" style="color: #ea5455 !important"></i>     VAT Amount</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="vatcashlbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="vatcashinp" id="vatcashinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                                <tr id="netcashtr">
                                                    <td style="text-align: right;"><label strong style="font-size: 14px;">Net Cash Received</label></td>
                                                    <td style="text-align: center;">
                                                        <label id="netcashlbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                        <input type="hidden" placeholder="" class="form-control" name="netcashrecinp" id="netcashrecinp" readonly="true" value="0" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            
                            <div id="referencediv">
                                <div id="referencedetail" style="font-size: 16px;font-weight:bold;"></div>
                            </div>
                            <select class="select2 form-control" name="MrcData" id="MrcData">
                                <option selected disabled value=""></option>
                                @foreach ($mrcdata as $mrcdata)
                                    <option title="{{ $mrcdata->StoreId }}" value="{{$mrcdata->CustomerMRC}}">{{$mrcdata->CustomerMRC}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="BankData" id="BankData">
                                <option selected disabled value=""></option>
                                @foreach ($banks as $banks)
                                    <option value="{{$banks->id}}">{{$banks->Name}}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="AccData" id="AccData">
                                <option selected disabled value=""></option>
                                @foreach ($accnum as $accnum)
                                    <option title="{{ $accnum->banks_id }}" value="{{$accnum->id}}">{{$accnum->AccountNumber}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="lastsevendaysval" id="lastsevendaysval" readonly="true" value="{{$lastsevendays}}">
                        <input type="hidden" placeholder="" class="form-control" name="countposval" id="countposval" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="zreceiptfilename" id="zreceiptfilename" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="slipreceiptfilename" id="slipreceiptfilename" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="StartDateComp" id="StartDateComp" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="StartDate" id="StartDate" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="EndDate" id="EndDate" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="CurrentDateVal" id="CurrentDateVal" value="{{$currentdate}}" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="closingId" id="closingId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="poshiddenval" id="poshiddenval" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="startdatehiddenval" id="startdatehiddenval" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="enddatehiddenval" id="enddatehiddenval" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control" name="minimumShortageVar" id="minimumShortageVar" value="{{$pershortamnt}}" readonly="true"/>

                        <button id="savebutton" type="submit" class="btn btn-info">Save</button>

                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- start income info modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="incomedetailmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog sidebar-xl" style="width: 97%;">
            <form id="Register">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetInfo()">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Income Data</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row mt-2">
                                <div class="col-xl-2 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                    <!-- Tab navs -->
                                    <div class="nav flex-column nav-tabs text-center" id="v-tabs-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link" id="v-tabs-fcash-tab" data-toggle="tab" href="#v-tabs-fcash" role="tab" aria-controls="v-tabs-fcash" aria-selected="true">Fiscal Receipt Cash Income</a>
                                        <a class="nav-link" id="v-tabs-fcredit-tab" data-toggle="tab" href="#v-tabs-fcredit" role="tab" aria-controls="v-tabs-fcredit" aria-selected="false">Fiscal Receipt Credit Income</a>
                                        <a class="nav-link" id="v-tabs-mcash-tab" data-toggle="tab" href="#v-tabs-mcash" role="tab" aria-controls="v-tabs-mcash" aria-selected="false">Manual Receipt Cash Income</a>
                                        <a class="nav-link" id="v-tabs-mcredit-tab" data-toggle="tab" href="#v-tabs-mcredit" role="tab" aria-controls="v-tabs-mcredit" aria-selected="false">Manual Receipt Credit Income</a>
                                        <a class="nav-link" id="v-tabs-settled-tab" data-toggle="tab" href="#v-tabs-settled" role="tab" aria-controls="v-tabs-settled" aria-selected="false">Credit Settlement Income</a>
                                    </div>
                                    <!-- Tab navs -->
                                </div>
                                <div class="col-xl-10 col-lg-12 scrollhor scrdivhor" style="height:55rem;">
                                    <!-- Tab content -->
                                    <div class="tab-content" id="v-tabs-tabContent">
                                        <div class="tab-pane" id="v-tabs-fcash" role="tabpanel" aria-labelledby="v-tabs-fcash-tab">
                                            <div class="divider">
                                                <div class="divider-text">Fiscal Receipt Cash Income</div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <table id="fcashtbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 14%">Customer/ Client Name</th>
                                                        <th style="width: 12%">TIN</th>
                                                        <th style="width: 12%">POS</th>
                                                        <th style="width: 12%">MRC Number</th>
                                                        <th style="width: 12%">FS Number</th>
                                                        <th style="width: 12%">Invoice/ Ref Number</th>
                                                        <th style="width: 12%">Invoice Date</th>
                                                        <th style="width: 12%">Grand Total</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot class="footercal">
                                                        <tr>
                                                            <td colspan="8" style="text-align: right;font-weight:bold">
                                                                <label style="font-size: 14px;">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: left; font-weight:bold;">
                                                                <label id="fiscalcashgrandtotal" style="font-size: 14px;"></label>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="v-tabs-fcredit" role="tabpanel" aria-labelledby="v-tabs-fcredit-tab">
                                            <div class="divider">
                                                <div class="divider-text">Fiscal Receipt Credit Income</div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <table id="fcredittbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 14%">Customer/ Client Name</th>
                                                        <th style="width: 12%">TIN</th>
                                                        <th style="width: 12%">POS</th>
                                                        <th style="width: 12%">MRC Number</th>
                                                        <th style="width: 12%">FS Number</th>
                                                        <th style="width: 12%">Invoice/ Ref Number</th>
                                                        <th style="width: 12%">Invoice Date</th>
                                                        <th style="width: 12%">Grand Total</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot class="footercal">
                                                        <tr>
                                                            <td colspan="8" style="text-align: right;font-weight:bold">
                                                                <label style="font-size: 14px;">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: left; font-weight:bold;">
                                                                <label id="fiscalcreditgrandtotal" style="font-size: 14px;"></label>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="v-tabs-mcash" role="tabpanel" aria-labelledby="v-tabs-mcash-tab">
                                            <div class="divider">
                                                <div class="divider-text">Manual Receipt Cash Income</div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <table id="mcashtbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 17%">Customer/ Client Name</th>
                                                        <th style="width: 16%">TIN</th>
                                                        <th style="width: 16%">POS</th>
                                                        <th style="width: 16%">Doc. Number</th>
                                                        <th style="width: 16%">Invoice Date</th>
                                                        <th style="width: 16%">Grand Total</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot class="footercal">
                                                        <tr>
                                                            <td colspan="6" style="text-align: right;font-weight:bold">
                                                                <label style="font-size: 14px;">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: left; font-weight:bold;">
                                                                <label id="manualcashgrandtotal" style="font-size: 14px;"></label>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="v-tabs-mcredit" role="tabpanel" aria-labelledby="v-tabs-mcredit-tab">
                                            <div class="divider">
                                                <div class="divider-text">Manual Receipt Credit Income</div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <table id="mcredittbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 17%">Customer/ Client Name</th>
                                                        <th style="width: 16%">TIN</th>
                                                        <th style="width: 16%">POS</th>
                                                        <th style="width: 16%">Doc. Number</th>
                                                        <th style="width: 16%">Invoice Date</th>
                                                        <th style="width: 16%">Grand Total</th>
                                                        <th></th>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot class="footercal">
                                                        <tr>
                                                            <td colspan="6" style="text-align: right;font-weight:bold">
                                                                <label style="font-size: 14px;">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: left; font-weight:bold;">
                                                                <label id="manualcreditgrandtotal" style="font-size: 14px;"></label>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="v-tabs-settled" role="tabpanel" aria-labelledby="v-tabs-settled-tab">
                                            <div class="divider">
                                                <div class="divider-text">Settled Income</div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <table id="settinctbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%;">
                                                    <thead>
                                                        <th style="width: 3%">#</th>
                                                        <th style="width: 17%">Customer Name</th>
                                                        <th style="width: 16%">TIN</th>
                                                        <th style="width: 16%">POS</th>
                                                        <th style="width: 16%">CRV Number</th>
                                                        <th style="width: 16%">CRV Date</th>
                                                        <th style="width: 16%">Total Cash</th>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot class="footercal">
                                                        <tr>
                                                            <td colspan="6" style="text-align: right;font-weight:bold">
                                                                <label style="font-size: 14px;">Grand Total</label>
                                                            </td>
                                                            <td style="text-align: left; font-weight:bold;">
                                                                <label id="settincomegrandtotal" style="font-size: 14px;"></label>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab content -->
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonabc" type="button" class="btn btn-danger" data-dismiss="modal" onclick="resetInfo()">Close</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--End income info modal-->

    <!--Start income closing modal -->
    <div class="modal fade text-left" id="incomeclosinginfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="incomeclosingtitle">Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="settlementinfofn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="incomeclosingform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 mb-2">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                    <span class="lead collapse-title">Basic, Income, Action & Others Information</span>
                                                    <div style="text-align: right;" id="statustitles"></div>
                                                </div>
                                                <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infodocrec">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Basic Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td style="width: 45%"><label strong style="font-size: 14px;">Document Number</label></td>
                                                                                <td style="width: 55%"><label id="recoredinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Point of Sales</label></td>
                                                                                <td><label id="posinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Date</label></td>
                                                                                <td><label id="dateinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Z-Receipt</label></td>
                                                                                <td><a style="text-decoration:underline;color:blue;" onclick="ZdocdownloadFn()" id="zreceipinfo"></a></td>
                                                                            </tr> 
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Bank Transaction Ref.</label></td>
                                                                                <td><a style="text-decoration:underline;color:blue;" onclick="slipdocdownloadFn()" id="slipdocinfo"></a></td>
                                                                            </tr>  
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Income Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td colspan="4" style="text-align:center">
                                                                                    <label style="font-size: 15px;font-weight:bold;"><u>Fiscal Receipt</u></label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width: 28%"><label strong style="font-size: 14px;">Cash Income</label></td>
                                                                                <td style="width: 22%"><label id="cashincomelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                <td style="width: 30%"><label strong style="font-size: 14px;">Credit Income</label></td>
                                                                                <td style="width: 20%"><label id="creditincomelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Other Cash</label></td>
                                                                                <td><label id="othercashlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                <td><label strong style="font-size: 14px;">Other Credit</label></td>
                                                                                <td><label id="othercreditlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Total Cash</label></td>
                                                                                <td><label id="totalcashlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                <td><label strong style="font-size: 14px;">Total Credit</label></td>
                                                                                <td><label id="totalcreditlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td colspan="4" style="text-align:center">
                                                                                    <label style="font-size: 15px;font-weight:bold;"><u>Manual Receipt</u></label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width: 28%"><label strong style="font-size: 14px;">Cash Income</label></td>
                                                                                <td style="width: 22%"><label id="cashincomemanlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                <td style="width: 30%"><label strong style="font-size: 14px;">Credit Income</label></td>
                                                                                <td style="width: 20%"><label id="creditincomemanlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Other Cash</label></td>
                                                                                <td><label id="othercashmanlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                <td><label strong style="font-size: 14px;">Other Credit</label></td>
                                                                                <td><label id="othercreditmanlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Total Cash</label></td>
                                                                                <td><label id="totalcashmanlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                <td><label strong style="font-size: 14px;">Total Credit</label></td>
                                                                                <td><label id="totalcreditmanlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td colspan="4" style="text-align:center">
                                                                                    <label style="font-size: 15px;font-weight:bold;"><u>Credit Sales Settled Amount</u></label>
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td colspan="3"><label style="font-size: 14px;">Cash Settlement Income</label></td>
                                                                                <td><label id="cashsettlementincomelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="4" style="text-align:center;display:none;">
                                                                                    <label style="font-size: 15px;font-weight:bold;"><u>Bank Deposit Variance</u></label>
                                                                                </td>
                                                                            </tr>
                                                                            <tr style="display: none;">
                                                                                <td colspan="3"><label style="font-size: 14px;">Shortage Amount</label></td>
                                                                                <td><label id="shortageamountinfo" style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr style="display: none;">
                                                                                <td colspan="3"><label style="font-size: 14px;">Overage Amount</label></td>
                                                                                <td><label id="overageamountinfo" style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Action Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td style="width: 50%"><label strong style="font-size: 14px;">Prepared By</label></td>
                                                                                <td style="width: 50%"><label id="preparedbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                                                            <div class="col-xl-3 col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Other Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td style="width: 40%"><label strong style="font-size: 14px;">Void By</label></td>
                                                                                <td style="width: 60%"><label id="voidbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                            <div class="divider-text">MRC & Z-Number Information</div>
                        </div>
                        <div class="row" style="margin-top: -2rem">
                            <div class="col-xl-12 col-lg-12 mb-2">
                                <div style="width:98%; margin-left:1%;">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="mrcinfotbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:13%;">MRC Number</th>
                                                    <th style="width:13%;">Z-Number</th>
                                                    <th style="width:13%;">Z-Date</th>
                                                    <th style="width:15%;">Cash Amount</th>
                                                    <th style="width:15%;">Credit Amount</th>
                                                    <th style="width:15%;">Total Amount</th>
                                                    <th style="width:13%;">Business Day</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: -1rem">
                            <div class="col-xl-9 col-lg-12"></div>
                            <div class="col-xl-3 col-lg-12" style="margin-left:-15px;">
                                <table style="width:100%;" id="zpricingTableInfo" class="mb-0 rtable">
                                    <tr>
                                        <td style="text-align: right;width:50%;"><label strong style="font-size: 14px;">Total Cash Amount</label></td>
                                        <td style="text-align: center; width:50%;">
                                            <label id="totalcashzamountinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;"><label strong style="font-size: 14px;">Total Credit Amount</label></td>
                                        <td style="text-align: center;">
                                            <label id="totalcreditzamountinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;"><label strong style="font-size: 14px;">Grand Total</label></td>
                                        <td style="text-align: center;">
                                            <label id="totalzamountinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Bank & Account Information</div>
                        </div>
                        <div class="row" style="margin-top: -2rem">
                            <div class="col-xl-12 col-lg-12 mb-2">
                                <div style="width:98%; margin-left:1%;">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="bankinfotbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:10%;">Payment Mode</th>
                                                    <th style="width:18%;">Bank Name</th>
                                                    <th style="width:15%;">Account Number</th>
                                                    <th style="width:14%;">Transaction Ref. #</th>
                                                    <th style="width:10%;">Date</th>
                                                    <th style="width:14%;">Amount</th>
                                                    <th style="width:16%;">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: -1rem">
                            <div class="col-xl-9 col-lg-12"></div>
                            <div class="col-xl-3 col-lg-12" style="margin-left:-15px;">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <table style="width:100%;" id="deppricingTableinfo" class="rtable">
                                            <tr style="background-color: #f8f8f8;">
                                                <td style="text-align: right;width:50%;"><label strong style="font-size: 14px;">Total Cash Deposited</label></td>
                                                <td style="text-align: center; width:50%;">
                                                    <label id="depositedcashlblinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="shortagevartrinfo" class="variancetr" style="background-color: #f8f8f8;">
                                                <td style="text-align: right;width:50%;"><label style="font-size: 14px;">Shortage Amount</label></td>
                                                <td style="text-align: center; width:50%;">
                                                    <label id="shortageamountlblinfo" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="overagevartrinfo" class="variancetr" style="background-color: #f8f8f8;">
                                                <td style="text-align: right;width:50%;"><label style="font-size: 14px;">Overage Amount</label></td>
                                                <td style="text-align: center; width:50%;">
                                                    <label id="overageamountlblinfo" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-xl-12 col-lg-12">
                                        <table style="width:100%;" id="pricingTableinfo" class="rtable">  
                                            <tr>
                                                <td rowspan="2" style="text-align: center;width:15%;"><label strong style="font-size: 14px;">Fiscal</label></td>
                                                <td style="text-align: right;width:35%;"><label strong style="font-size: 14px;">Cash Income</label></td>
                                                <td style="text-align: center;width:50%;">
                                                    <label id="fiscalcaslcashinclbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;"><label strong style="font-size: 14px;">Other Cash Income</label></td>
                                                <td style="text-align: center;">
                                                    <label id="otherfiscalcashinclbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2" style="text-align: center;width:15%;"><label strong style="font-size: 14px;">Manual</label></td>
                                                <td style="text-align: right;"><label strong style="font-size: 14px;">Cash Income</label></td>
                                                <td style="text-align: center;">
                                                    <label id="manualcashinclbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;"><label strong style="font-size: 14px;">Other Cash Income</label></td>
                                                <td style="text-align: center;">
                                                    <label id="othermanualcashinclbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: right;width:50%;"><label strong style="font-size: 14px;">Credit Settlement Income</label></td>
                                                <td style="text-align: center;width:50%">
                                                    <label id="creditsettlementinclbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f8f8;">
                                                <td colspan="2" style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-info-circle" aria-hidden="true" style="font-weight:bold;" title="Total Cash Received=Fiscal Cash Income + Other Fiscal Cash Income + Manual Cash Income + Other Manual Cash Income + Credit Settlement Income"></i>     Total Cash Received</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalcashinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="witholdamounttrinfo">
                                                <td colspan="2" style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-minus" aria-hidden="true" style="color: #ea5455 !important"></i>     Withold Amount</label></td>
                                                <td style="text-align: center;">
                                                    <label id="withodcashlblinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="vatamounttrinfo">
                                                <td colspan="2" style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-minus" aria-hidden="true" style="color: #ea5455 !important"></i>     VAT Amount</label></td>
                                                <td style="text-align: center;">
                                                    <label id="vatcashlblinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr style="display: none;">
                                                <td style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-plus" aria-hidden="true" style="color: #28c76f !important"></i>     Other Income</label></td>
                                                <td style="text-align: center;">
                                                    <label id="otherincomeinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                            <tr id="netcashreceivedtrinfo" style="background-color: #f8f8f8;">
                                                <td colspan="2" style="text-align: right;"><label strong style="font-size: 14px;"><i class="fa fa-info-circle" aria-hidden="true" style="font-weight:bold;" title="Net Cash Received=Total Cash Received - Withold Amount - VAT Amount"></i>     Net Cash Received</label></td>
                                                <td style="text-align: center;">
                                                    <label id="netcashlblinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                        <input type="hidden" class="form-control" name="zdocinfoval" id="zdocinfoval" readonly="true">
                        <input type="hidden" class="form-control" name="slipdocinfoval" id="slipdocinfoval" readonly="true">
                        <input type="hidden" class="form-control" name="recordIds" id="recordIds" readonly="true">
                        <input type="hidden" class="form-control" name="statusIds" id="statusIds" readonly="true">
                        <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                        @can('Income-Follow-Up-ChangeToPending')
                            <button id="changetopending" type="button" onclick="getPendingInfoConf()" class="btn btn-info">Change to Pending</button>
                        @endcan
                        @can('Income-Follow-Up-Verify')
                            <button id="verifyclosingbtn" type="button" onclick="getVerifyInfoConf()" class="btn btn-info">Verify Income Follow-Up</button>
                        @endcan
                        @can('Income-Follow-Up-Confirm')
                            <button id="confirmclosingbtn" type="button" onclick="getConfirmInfoConf()" class="btn btn-info">Confirm Income Follow-Up</button>
                        @endcan
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal" onclick="settlementinfofn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End income closing modal -->

    <!--Start Verify Follow-Up modal -->
    <div class="modal fade text-left" id="verifymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="verifyform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to verify income follow-up?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="checkedid" id="checkedid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="permittedVerified" id="permittedVerified" value="{{$pershortamnt}}" readonly="true"/>
                        <button id="verifybtn" type="button" class="btn btn-info">Verify Income Follow-Up</button>
                        <button id="closebuttonf" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Verify Follow-Up modal -->

    <!--Start Pending income follow-up modal -->
    <div class="modal fade text-left" id="incomependingfollowupmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="incomepenfollowupform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to change income follow-up to pending?</label>
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
    <!-- End Pending follow-up modal -->

    <!--Start Confimed income follow-up modal -->
    <div class="modal fade text-left" id="incomeconffollowupmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="incomeconffollowupform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to confirm income follow-up?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="confirmid" id="confirmid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="permittedConfirmed" id="permittedConfirmed" value="{{$pershortamnt}}" readonly="true"/>
                        <button id="confirmbtn" type="button" class="btn btn-info">Confirm Income Follow-Up</button>
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Confimed follow-up modal -->

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
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to void income follow-up?</label>
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
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="undovoidform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo void income follow-up?</label>
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

    <script type="text/javascript">
        var fr='';
        var tr='';
        var aa = moment().subtract(29, 'days');
        var bb = moment();
        var dateminval = $('#lastsevendaysval').val();
        
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        
        var j = 0;
        var i = 0;
        var m = 0;

        var x = 0;
        var y = 0;
        var z = 0;
        var flaglist=[];

        var daterangeflag=0;
        var fyears=$('#fiscalyear').val();

        $('body').on('click', '.addpaymentfollowup', function() {
            $('#PointOfSales').select2
            ({
                placeholder: "Select POS here",
            });
            
            $('#dynamicTable tbody').empty();
            $('#dynamicTableB tbody').empty();
            j = 0;
            x = 0;
            $("#inlineForm").modal('show');
            $("#paymentfollowuptitle").html("Add Income Follow-Up");
            $("#revenuetitle").html("Income");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $("#pointofsales-error").html("");
            $("#date-error").html("");
            $('#StartDate').val("");
            $('#EndDate').val("");
            $('#operationtypes').val("1");
            $('#pricingTable').hide();
            $('#deppricingTable').hide();
            $('#zpricingTable').hide();
            $('#closingId').val("");
            $("#statusdisplay").html("");
            $('#Memo').val("");	
            //$('#datetimes').unbind();
            flaglist=[0];
            $('#datetimes').val("");
            daterangeflag=0;
        });

        //Start page load
        $(document).ready(function() {
            getClosingList(fyears);
        });

        function getClosingList(fyears){
            var table =$('#laravel-datatable-crud').DataTable({
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
                    url: '/closinglist/'+fyears,
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
                        data:'DT_RowIndex',
                        width:'3%'
                    },
                    {
                        data: 'IncomeDocumentNumber',
                        name: 'IncomeDocumentNumber',
                        width:'24%'
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'24%'
                    },
                    {
                        data: 'DateRange',
                        width:'24%'
                    },
                    {
                        data: 'StatusName',
                        width:'22%'
                    },
                    {
                        data: 'Status',
                        'visible': false
                    },
                    {
                        data: 'action',
                        width:'3%'
                    }
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == 1) {
                        $(nRow).find('td:eq(4)').css({
                            "color": "#f6c23e",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #f6c23e"
                        });
                    } else if (aData.Status == 2) {
                        $(nRow).find('td:eq(4)').css({
                            "color": "#4e73df",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #4e73df"
                        });
                    } else if (aData.Status == 3) {
                        $(nRow).find('td:eq(4)').css({
                            "color": "#1cc88a",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #1cc88a"
                        });
                    } else if (aData.Status == 4||aData.Status == 5||aData.Status == 6||aData.Status == 7) {
                        $(nRow).find('td:eq(4)').css({
                            "color": "#e74a3b",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #e74a3b"
                        });
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

        function fiscalyrfn(){
            var fyearsch=$('#fiscalyear').val();
            getClosingList(fyearsch);
        }

        $('#PointOfSales').on('change', function () {
            var pid = $('#PointOfSales').val();
            var poshidden = $('#poshiddenval').val()||0;
            var registerForm = $("#Register");
            var opertype = $('#operationtypes').val();
            var closingid = $('#closingId').val()||0;
            var formData = registerForm.serialize();
            var posid="";
            var start="";
            var end="";
            var startdate="";
            var enddate="";
            var closingidval="";
            var countincs=0;
            var poshidd=0;
            $.ajax({
                url: '/getposdata',
                type: 'POST',
                data:{
                    posid:$('#PointOfSales').val(),
                    closingidval:closingid,
                    poshidd:poshidden,
                },
                success: function(data) {
                    $(function() {
                        countincs=data.countinc;

                        if(parseInt(countincs)==0){
                            start = moment(data.createddate);
                            end = moment(data.currentdate);
                            startdate=data.createddate;
                            enddate=data.currentdate;
                            $('#StartDateComp').val(startdate);
                            daterangeflag=0;
                            $('#datetimes').val("");
                            $("#revenuetitle").html("Income");
                            $('#fiscalcashreceiptlbl').html("");
                            $('#FiscalCashIncHidden').val("");
                            $('#fiscalcreditreceiptlbl').html("");
                            $('#FiscalCreditIncHidden').val("");
                            $('#manualcashreceiptlbl').html("");
                            $('#ManualCashIncHidden').val("");
                            $('#manualcreditreceiptlbl').html("");
                            $('#ManualCreditIncHidden').val("");
                            $('#settledamountlbl').html("");
                            $('#settledincomeval').val("");
                            $('#pricingTable').hide();
                            $('#deppricingTable').hide();
                            $('#zpricingTable').hide();
                            $('#StartDate').val("");
                            $('#EndDate').val("");
                            $('#dynamicTable tbody').empty();
                            $('#dynamicTableB tbody').empty();
                            $('#OtherIncome').val("");
                            $('#OtherIncome').css("background","white");
                            $('#CreditFiscalOtherIncome').css("background","white");
                            $('#CashManualOtherIncome').css("background","white");
                            $('#CreditManualOtherIncome').css("background","white");
                            $('#CreditFiscalOtherIncome').val("");
                            $('#CashManualOtherIncome').val("");
                            $('#CreditManualOtherIncome').val("");
                            $('#cashfiscaltotalval').val("");
                            $('#creditfiscaltotalval').val("");
                            $('#cashmanualtotalval').val("");
                            $('#creditmanualtotalval').val("");
                            $('#cashfiscaltotallbl').html("");
                            $('#creditfiscaltotallbl').html("");
                            $('#cashmanualtotallbl').html("");
                            $('#creditmanualtotallbl').html("");

                            $('#datetimes').daterangepicker({ 
                                minDate: start,
                                maxDate:end,
                                showDropdowns: true,
                                autoApply:false,
                                locale: {
                                    format: 'YYYY-MM-DD'
                                }
                            });
                            
                            $('#datetimes').val(""); 
                            $(".calendar-table").show();
                        }
                        if(parseInt(countincs)>=1){
                            $('#PointOfSales').val(poshidden).select2();
                            toastrMessage('error',"You have a record with this POS following this record, you can't change the POS.","Error");
                        }

                   })(daterangeflag=0);  
                },
            });
            daterangeflag=0;
            $('#pointofsales-error').html("");
        });


        function datetimefn(flg){
            var dt=$('#datetimes').val();
            const myArray = dt.split(" - ");
            var from=myArray[0];
            var to=myArray[1];
            var posidval="";
            var mindate="";
            var maxdate="";
            var totalcash=0;
            var witholdamount=0;
            var vatamount=0;

            if(parseInt(flaglist.length)>=2){
                $('#OtherIncome').val("");
                $('#CreditFiscalOtherIncome').val("");
                $('#CashManualOtherIncome').val("");
                $('#CreditManualOtherIncome').val("");
            }  

            var otherincome=$('#OtherIncome').val()||0;
            var manualcahsincome=$('#CashManualOtherIncome').val()||0;
            var fiscalcreditincome=$('#CreditFiscalOtherIncome').val()||0;
            var manualcreditincome=$('#CreditManualOtherIncome').val()||0;

            var otherinc=$('#OtherIncome').val();
            var manualcahsinc=$('#CashManualOtherIncome').val();
            var fiscalcreditinc=$('#CreditFiscalOtherIncome').val();
            var manualcreditinc=$('#CreditManualOtherIncome').val();

            var netcashrec=0;
            var optype="";
            fr=from;
            tr=to;
            var rowCount = $("#dynamicTable > tbody tr").length; 
            if(parseFloat(daterangeflag)==1){
                $.ajax({
                    url: '/getrevenues',
                    type: 'POST',
                    data:{
                        posidval:$('#PointOfSales').val()||0,
                        mindate:from,
                        maxdate:to,
                        optype:$('#operationtypes').val()||0,
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
                        $('#fiscalcashreceiptlbl').text(numformat(((data.cash||0)+(data.cashapp||0)).toFixed(2)));
                        $('#FiscalCashIncHidden').val(parseFloat(data.cash||0)+parseFloat(data.cashapp||0));
                        $('#fiscalcreditreceiptlbl').text(numformat(((data.credit||0)+(data.creditapp||0)).toFixed(2)));
                        $('#FiscalCreditIncHidden').val(parseFloat(data.credit||0)+parseFloat(data.creditapp||0));
                        $('#manualcashreceiptlbl').text(numformat(((data.mancash||0)+(data.mancashapp||0)).toFixed(2)));
                        $('#ManualCashIncHidden').val(parseFloat(data.mancash||0)+parseFloat(data.mancashapp||0));
                        $('#manualcreditreceiptlbl').text(numformat(((data.mancredit||0)+(data.mancreditapp||0)).toFixed(2)));
                        $('#ManualCreditIncHidden').val(parseFloat(data.mancredit||0)+parseFloat(data.mancreditapp||0));
                        $('#settledamountlbl').text(numformat(((data.settamnt||0)-(data.settwithamount||0)-(data.settvatamount||0)).toFixed(2)));
                 
                        $('#settledincomeval').val((data.settamnt||0)-(data.settwithamount||0)-(data.settvatamount||0));
                        totalcash=parseFloat(data.cash||0)+parseFloat(data.cashapp||0)+parseFloat(data.mancash||0)+parseFloat(data.mancashapp||0)+parseFloat(data.settamnt||0)+parseFloat(otherincome)+parseFloat(manualcahsincome);
                        $('#totalcash').text(numformat(totalcash.toFixed(2)));
                        $('#totalcashi').val(totalcash.toFixed(2));
                        $('#vatcashlbl').text(numformat(data.vatamount||0));
                        $('#vatcashinp').val(data.vatamount||0);
                        $('#withodcashlbl').text(numformat(data.withamount||0));
                        $('#witholdcashinp').val(data.withamount||0);
                        netcashrec=(parseFloat(totalcash)+parseFloat(otherincome)+parseFloat(manualcahsincome))-parseFloat(data.withamount||0)-parseFloat(data.vatamount||0)-parseFloat(data.settwithamount||0)-parseFloat(data.settvatamount||0);
                        $('#netcashlbl').text(numformat(netcashrec.toFixed(2)));
                        $('#netcashrecinp').val(netcashrec.toFixed(2));

                        if(isNaN(parseFloat(otherinc))){
                            $('#cashfiscaltotallbl').html("");
                        }
                        if(isNaN(parseFloat(fiscalcreditinc))){
                            $('#creditfiscaltotallbl').html("");
                        }
                        if(isNaN(parseFloat(manualcahsinc))){
                            $('#cashmanualtotallbl').html("");
                        }
                        if(isNaN(parseFloat(manualcreditinc))){
                            $('#creditmanualtotallbl').html("");
                        }

                        if(!isNaN(parseFloat(otherinc))){
                            $('#cashfiscaltotallbl').html(numformat((parseFloat(data.cash||0)+parseFloat(data.cashapp||0)+parseFloat(otherincome)).toFixed(2)));
                        }
                        if(!isNaN(parseFloat(fiscalcreditinc))){
                            $('#creditfiscaltotallbl').html(numformat((parseFloat(data.credit||0)+parseFloat(data.creditapp||0)+parseFloat(fiscalcreditincome)).toFixed(2)));
                        }
                        if(!isNaN(parseFloat(manualcahsinc))){ 
                            $('#cashmanualtotallbl').html(numformat((parseFloat(data.mancash||0)+parseFloat(data.mancashapp||0)+parseFloat(manualcahsincome)).toFixed(2)));
                        }
                        if(!isNaN(parseFloat(manualcreditinc))){
                            $('#creditmanualtotallbl').html(numformat((parseFloat(data.mancredit||0)+parseFloat(data.mancreditapp||0)+parseFloat(manualcreditincome)).toFixed(2)));
                        }
                        $('#cashfiscaltotalval').val((parseFloat(data.cash||0)+parseFloat(data.cashapp||0)+parseFloat(otherincome)).toFixed(2));
                        $('#creditfiscaltotalval').val((parseFloat(data.credit||0)+parseFloat(data.creditapp||0)+parseFloat(fiscalcreditincome)).toFixed(2));
                        $('#cashmanualtotalval').val((parseFloat(data.mancash||0)+parseFloat(data.mancashapp||0)+parseFloat(manualcahsincome)).toFixed(2));
                        $('#creditmanualtotalval').val((parseFloat(data.mancredit||0)+parseFloat(data.mancreditapp||0)+parseFloat(manualcreditincome)).toFixed(2));

                        if(parseFloat(data.withamount||0)>0){
                            $('#witholdamounttr').show();
                        }
                        if(parseFloat(data.withamount||0)==0){
                            $('#witholdamounttr').hide();
                        }
                        if(parseFloat(data.vatamount||0)>0){
                            $('#vatamounttr').show();
                        }
                        if(parseFloat(data.vatamount||0)==0){
                            $('#vatamounttr').hide();
                        }
                        if(parseFloat(data.withamount||0)>0 || parseFloat(data.vatamount||0)>0){
                            $('#netcashtr').show();
                        }
                        if(parseFloat(data.withamount||0)==0 && parseFloat(data.vatamount||0)==0){
                            $('#netcashtr').hide();
                        }
                        $('#pricingTable').show();
                        CalculateZGrandTotal(); 
                        compareCash(0);
                        compareCredit(0);
                        CalculateGrandTotal();
                        $('#StartDate').val(from);
                        $('#EndDate').val(to);
                        $('#date-error').html("");
                    }
                });

                if(parseFloat(rowCount)>0){
                    for(var k=1;k<=m;k++){
                        var zdate=($('#ZDate'+k)).val();
                        var zdatehidd=($('#zdatehidden'+k)).val();
                        if(($('#ZDate'+k).val())!=undefined){
                            if(zdate>to){
                                $('#ZDate'+k).val("");
                            }
                            flatpickr('.ZDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:to,minDate:from});
                        }
                    }

                    for(var q=1;q<=m;q++){
                        var zdate=($('#ZDate'+q)).val();
                        var zdatehidd=($('#zdatehidden'+q)).val();
                        if(($('#ZDate'+q).val())!=undefined){
                            if(zdatehidd<to){
                                $('#ZDate'+q).val(zdatehidd);
                            }
                        }
                    }
                }
            }
            CalGrandTotalCash();
            daterangeflag=1;
            flaglist.push(flg);
        }

        function cb(start, end) {
            $('#followdate span').html(start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
            //$("#revenuetitle").html("Revenue"+" <i>("+start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY')+")</i>");
            var from=start.format('YYYY-MM-DD');
            var to=end.format('YYYY-MM-DD');
            var posidval="";
            var mindate="";
            var maxdate="";
            var totalcash=0;
            var witholdamount=0;
            var vatamount=0;
            var otherincome=$('#OtherIncome').val()||0;
            var netcashrec=0;
            var optype="";
            fr=from;
            tr=to;
            var rowCount = $("#dynamicTable > tbody tr").length; 

            $.ajax({
                url: '/getrevenues',
                type: 'POST',
                data:{
                    posidval:$('#PointOfSales').val()||0,
                    mindate:from,
                    maxdate:to,
                    optype:$('#operationtypes').val()||0,
                },
                success: function(data) {
                    $('#fiscalcashreceiptlbl').text(numformat((data.cash||0)+(data.cashapp||0)));
                    $('#FiscalCashIncHidden').val(parseFloat(data.cash||0)+parseFloat(data.cashapp||0));
                    $('#fiscalcreditreceiptlbl').text(numformat((data.credit||0)+(data.creditapp||0)));
                    $('#FiscalCreditIncHidden').val(parseFloat(data.credit||0)+parseFloat(data.creditapp||0));
                    $('#manualcashreceiptlbl').text(numformat((data.mancash||0)+(data.mancashapp||0)));
                    $('#ManualCashIncHidden').val(parseFloat(data.mancash||0)+parseFloat(data.mancashapp||0));
                    $('#manualcreditreceiptlbl').text(numformat((data.mancredit||0)+(data.mancreditapp||0)));
                    $('#ManualCreditIncHidden').val(parseFloat(data.mancredit||0)+parseFloat(data.mancreditapp||0));
                    $('#settledamountlbl').text(numformat(data.settamnt||0));
                    $('#settledincomeval').val(data.settamnt||0);
                    totalcash=parseFloat(data.cash||0)+parseFloat(data.cashapp||0)+parseFloat(data.mancash||0)+parseFloat(data.mancashapp||0)+parseFloat(data.settamnt||0);
                    $('#totalcash').text(numformat(totalcash.toFixed(2)));
                    $('#totalcashi').val(totalcash.toFixed(2));
                    $('#vatcashlbl').text(numformat(data.vatamount||0));
                    $('#vatcashinp').val(data.vatamount||0);
                    $('#withodcashlbl').text(numformat(data.withamount||0));
                    $('#witholdcashinp').val(data.withamount||0);
                    netcashrec=(parseFloat(totalcash)+parseFloat(otherincome))-parseFloat(data.withamount||0)-parseFloat(data.vatamount||0);
                    $('#netcashlbl').text(numformat(netcashrec.toFixed(2)));
                    $('#netcashrecinp').val(netcashrec.toFixed(2));

                    if(parseFloat(data.withamount||0)>0){
                        $('#witholdamounttr').show();
                    }
                    if(parseFloat(data.withamount||0)==0){
                        $('#witholdamounttr').hide();
                    }
                    if(parseFloat(data.vatamount||0)>0){
                        $('#vatamounttr').show();
                    }
                    if(parseFloat(data.vatamount||0)==0){
                        $('#vatamounttr').hide();
                    }
                    $('#pricingTable').show();
                    CalculateGrandTotal();
                    $('#StartDate').val(from);
                    $('#EndDate').val(to);
                    $('#date-error').html("");
                }
            });

            if(parseFloat(rowCount)>0){
                for(var k=1;k<=m;k++){
                    var zdate=($('#ZDate'+k)).val();
                    var zdatehidd=($('#zdatehidden'+k)).val();
                    if(($('#ZDate'+k).val())!=undefined){
                        if(zdate>to){
                            $('#ZDate'+k).val("");
                        }
                        flatpickr('.ZDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:to,minDate:from});
                    }
                }

                for(var q=1;q<=m;q++){
                    var zdate=($('#ZDate'+q)).val();
                    var zdatehidd=($('#zdatehidden'+q)).val();
                    if(($('#ZDate'+q).val())!=undefined){
                        if(zdatehidd<to){
                            $('#ZDate'+q).val(zdatehidd);
                        }
                    }
                }
            }
        }

        $('#MrcNumber').on('change', function () {
            var mrcval=$('#MrcNumber').val();
            var pid = $('#PointOfSales').val();
            $.get("/showallpr" + '/' + mrcval+'/'+pid, function(data) {
                $('#fiscalcashreceiptlbl').text(numformat(data.cash||0));
                $('#fiscalcreditreceiptlbl').text(numformat(data.credit||0));
                $('#manualcashreceiptlbl').text(numformat(data.mancash||0));
                $('#manualcreditreceiptlbl').text(numformat(data.mancredit||0));
                var totalcash=parseFloat(data.cash||0)+parseFloat(data.mancash||0);
                $('#totalcash').text(numformat(totalcash));
                $('#totalcashi').val(totalcash);
                $('#totalcashpermanent').val(totalcash);
            });
            $('#dynamictablediv').show();
        });
   

        function detTransactionFn(trtype){
            var posid=$('#PointOfSales').val();
            var startdate = $('#StartDate').val();
            var enddate = $('#EndDate').val();
            $('.footercal').show();

            $('#fcashtbl').DataTable({
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
                    url: '/showfiscash/' + posid+'/'+startdate+'/'+enddate,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                        width:'13%',
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:'12%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'12%',
                    },
                    {
                        data: 'MRC',
                        name: 'MRC',
                        width:'12%',
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        width:'12%',
                    },
                    {
                        data: 'invoiceNo',
                        name: 'invoiceNo',
                        width:'12%',
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate',
                        width:'12%',
                    },
                    {
                        data: 'GrandTotal',
                        name: 'GrandTotal',
                        width:'12%',
                        render: $.fn.dataTable.render.number(',', '.','', '')
                    },
                    {
                        data: 'Outlets',
                        name: 'Outlets',
                        'visible': false
                    },
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                    footer: true
                },
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var color =  'style="font-weight:bold;background:#f2f3f4;"';
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="9"><b>Outlet : ' + group + ' </b></td></tr>')
                        }
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="9"><b>MRC # : ' + group + '</b></td></tr>')
                        }      
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var grandtotal = rows
                        .data()
                        .pluck('GrandTotal')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="8" style="text-align:right;">Total of : ' + group+ '</td>')  
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }  
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="8" style="text-align:right;">Total of : ' + group+ '</td>') 
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }
                    },
                    dataSrc: ['Outlets','MRC']
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    gtotal = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#fiscalcashgrandtotal').html(numformat(gtotal.toFixed(2)));
                },
            });

            $('#fcredittbl').DataTable({
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
                    url: '/showfiscredit/' + posid+'/'+startdate+'/'+enddate,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'14%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'12%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'12%',
                    },
                    {
                        data: 'MRC',
                        name: 'MRC',
                        width:'12%',
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        width:'12%',
                    },
                    {
                        data: 'invoiceNo',
                        name: 'invoiceNo',
                        width:'12%',
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate',
                        width:'12%',
                    },
                    {
                        data: 'GrandTotal',
                        name: 'GrandTotal',
                        width:'12%',
                        render: $.fn.dataTable.render.number(',', '.','', '')
                    },
                    {
                        data: 'Outlets',
                        name: 'Outlets',
                        'visible': false
                    },
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                    footer: true
                },
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var color =  'style="font-weight:bold;background:#f2f3f4;"';
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="9"><b>Outlet : ' + group + ' </b></td></tr>')
                        }
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="9"><b>MRC # : ' + group + '</b></td></tr>')
                        }      
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var grandtotal = rows
                        .data()
                        .pluck('GrandTotal')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="8" style="text-align:right;">Total of : ' + group+ '</td>')  
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }  
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="8" style="text-align:right;">Total of : ' + group+ '</td>') 
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }
                    },
                    dataSrc: ['Outlets','MRC']
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    gtotal = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#fiscalcreditgrandtotal').html(numformat(gtotal.toFixed(2)));
                },
            });

            $('#mcashtbl').DataTable({
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
                    url: '/showcashmanual/' + posid+'/'+startdate+'/'+enddate,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                        width:'17%',
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:'16%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'16%',
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        width:'16%',
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate',
                        width:'16%',
                    },
                    {
                        data: 'GrandTotal',
                        name: 'GrandTotal',
                        width:'16%',
                        render: $.fn.dataTable.render.number(',', '.','', '')
                    },
                    {
                        data: 'Outlets',
                        name: 'Outlets',
                        'visible': false
                    },
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                    footer: true
                },
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var color =  'style="font-weight:bold;background:#f2f3f4;"';
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="7"><b>Outlet : ' + group + ' </b></td></tr>')
                        }
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="7"><b>MRC # : ' + group + '</b></td></tr>')
                        }      
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var grandtotal = rows
                        .data()
                        .pluck('GrandTotal')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="6" style="text-align:right;">Total of : ' + group+ '</td>')  
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }  
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="6" style="text-align:right;">Total of : ' + group+ '</td>') 
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }
                    },
                    dataSrc: ['Outlets']
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    gtotal = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#manualcashgrandtotal').html(numformat(gtotal.toFixed(2)));
                },
            });

            $('#mcredittbl').DataTable({
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
                    url: '/showcreditmanual/' + posid+'/'+startdate+'/'+enddate,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                        width:'17%',
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:'16%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'16%',
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        width:'16%',
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate',
                        width:'16%',
                    },
                    {
                        data: 'GrandTotal',
                        name: 'GrandTotal',
                        width:'16%',
                        render: $.fn.dataTable.render.number(',', '.','', '')
                    },
                    {
                        data: 'Outlets',
                        name: 'Outlets',
                        'visible': false
                    },
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                    footer: true
                },
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var color =  'style="font-weight:bold;background:#f2f3f4;"';
                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="7"><b>Outlet : ' + group + ' </b></td></tr>')
                        }
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="7"><b>MRC # : ' + group + '</b></td></tr>')
                        }      
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var grandtotal = rows
                        .data()
                        .pluck('GrandTotal')
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0); 

                        if(level===0){
                            return $('<tr>')
                            .append('<td colspan="6" style="text-align:right;">Total of : ' + group+ '</td>')  
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }  
                        else if(level===1){
                            return $('<tr>')
                            .append('<td colspan="6" style="text-align:right;">Total of : ' + group+ '</td>') 
                            .append('<td><b>'+ numformat(grandtotal.toFixed(2))+'</b></td></tr>');
                        }
                    },
                    dataSrc: ['Outlets']
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    gtotal = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#manualcashgrandtotal').html(numformat(gtotal.toFixed(2)));
                },
            });

            $('#settinctbl').DataTable({
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
                    url: '/showsettincdata/' + posid+'/'+startdate+'/'+enddate,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%',
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                        width:'17%',
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:'16%',
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:'16%',
                    },
                    {
                        data: 'CrvNumber',
                        name: 'CrvNumber',
                        width:'16%',
                    },
                    {
                        data: 'DocumentDate',
                        name: 'DocumentDate',
                        width:'16%',
                    },
                    {
                        data: 'GrandTotal',
                        name: 'GrandTotal',
                        width:'16%',
                        render: $.fn.dataTable.render.number(',', '.','', '')
                    },
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                    footer: true
                },
                
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    gtotal = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#settincomegrandtotal').html(numformat(gtotal.toFixed(2)));
                },
            });

            $(".nav-link").removeClass("active");
            $(".tab-pane").removeClass("active");
            if(parseFloat(trtype)==1){
                $("#v-tabs-tab #v-tabs-fcash-tab").addClass("active");
                $("#v-tabs-tabContent #v-tabs-fcash").addClass("active");
            }
            if(parseFloat(trtype)==2){
                $("#v-tabs-tab #v-tabs-fcredit-tab").addClass("active");
                $("#v-tabs-tabContent #v-tabs-fcredit").addClass("active");
            }
            if(parseFloat(trtype)==3){
                $("#v-tabs-tab #v-tabs-mcash-tab").addClass("active");
                $("#v-tabs-tabContent #v-tabs-mcash").addClass("active");
            }
            if(parseFloat(trtype)==4){
                $("#v-tabs-tab #v-tabs-mcredit-tab").addClass("active");
                $("#v-tabs-tabContent #v-tabs-mcredit").addClass("active");
            }
            if(parseFloat(trtype)==5){
                $("#v-tabs-tab #v-tabs-settled-tab").addClass("active");
                $("#v-tabs-tabContent #v-tabs-settled").addClass("active");
            }

            $("#incomedetailmodal").modal('show');
        }

        $("#adds").click(function() {
            var dateval = $('#StartDate').val();
            var enddate = $('#EndDate').val();
            var posid = $('#PointOfSales').val();
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var mrcnums=$('#MrcNumber'+lastrowcount).val();
            if(isNaN(parseFloat(posid))||posid==null || dateval==""||dateval===""){
                if(isNaN(parseFloat(posid))||posid==null){
                    $('#pointofsales-error').html("The point of sales field is required.");
                }
                if(dateval==""||dateval===""){
                    $('#date-error').html("The date field is required.");
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if(mrcnums!==undefined && mrcnums===null){
                $('#select2-MrcNumber'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select MRC # from highlighted field","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="width:13%;"><select id="MrcNumber'+m+'" class="select2 form-control MrcNumber" onchange="MrcNumberVal(this)" name="row['+m+'][MrcNumber]"></select></td>'+
                    '<td style="width:13%;"><input type="number" name="row['+m+'][ZNumber]" placeholder="Write z number here..." id="ZNumber'+m+'" class="ZNumber form-control numeral-mask" onkeypress="return ValidateOnlyNum(event);" onkeyup="ZnumberFn(this)" onblur="checkZnumberFn(this)" readonly="true"/></td>'+
                    '<td style="width:13%;"><input type="number" name="row['+m+'][ZDate]" placeholder="Select z date here..." id="ZDate'+m+'" class="ZDate form-control flatpickr-basic" onchange="ZdateVal(this)"/></td>'+
                    '<td style="width:14%;"><input type="number" step="any" name="row['+m+'][CashAmount]" placeholder="Write cash amount here..." id="CashAmount'+m+'" class="CashAmount form-control numeral-mask" onkeyup="CalculateTotalZ(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:14%;"><input type="number" step="any" name="row['+m+'][CreditAmount]" placeholder="Write credit amount here..." id="CreditAmount'+m+'" class="CreditAmount form-control numeral-mask" onkeyup="CalculateTotalZ(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:14%;"><input type="number" step="any" name="row['+m+'][TotalAmount]" placeholder="Total amount" id="TotalAmount'+m+'" class="TotalAmount form-control numeral-mask" readonly="true" onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td style="width:13%;"><select id="BusinessDay'+m+'" class="select2 form-control BusinessDay" onchange="BusinessDayVal(this)" name="row['+m+'][BusinessDay]"></select></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][zdatehidden]" id="zdatehidden'+m+'" class="zdatehidden form-control" readonly="true"/></td></tr>'  
                );

                var opt = '<option selected disabled value=""></option>';
                var businessdayopt='<option value="1">Usual</option><option value="2">Unusual</option>';
                var options = $("#MrcData > option").clone();
                $('#MrcNumber'+m).append(options);
                $("#MrcNumber"+m+" option[title!='"+posid+"']").remove();
                $('#MrcNumber'+m).append(opt);
                $('#MrcNumber'+m).select2
                ({
                    placeholder: "Select MRC Number here",
                });

                $('#BusinessDay'+m).append(businessdayopt);
                $('#BusinessDay'+m).append(opt);
                $('#BusinessDay'+m).select2
                ({
                    placeholder: "Select business day type here",
                    minimumResultsForSearch: -1,
                });

                flatpickr('#ZDate'+m, { dateFormat: 'Y-m-d',clickOpens:false,maxDate:enddate,minDate:dateval});
                $('#select2-MrcNumber'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-BusinessDay'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberRows();
            }
        });

        $("#addb").click(function() {
            
            var dateval = $('#StartDate').val();
            var enddate = $('#EndDate').val();
            var currdate = $('#CurrentDateVal').val();
            var posid = $('#PointOfSales').val();
            var netcash = $('#netcashrecinp').val()||0;
            var lastrowcount=$('#dynamicTableB tr:last').find('td').eq(1).find('input').val();
            var bankid=$('#Bank'+lastrowcount).val();
            if(isNaN(parseFloat(posid))||posid==null || dateval==""||dateval===""){
                if(isNaN(parseFloat(posid))||posid==null){
                    $('#pointofsales-error').html("The point of sales field is required.");
                }
                if(dateval==""||dateval===""){
                    $('#date-error').html("The date field is required.");
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if(bankid!==undefined && bankid===null){
                $('#select2-Bank'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select bank from highlighted field","Error");
            }
            else if(parseFloat(netcash)==0){
                toastrMessage('error',"You havent received any cash yet, There should be a cash figure to add bank data","Error");
            }
            else{
                ++x;
                ++y;
                z += 1;
                $("#dynamicTableB > tbody").append('<tr id="rowind'+y+'"><td style="font-weight:bold;width:3%;text-align:center;">'+z+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="rowb['+y+'][valsb]" id="valsb'+y+'" class="valsb form-control" readonly="true" style="font-weight:bold;" value="'+y+'"/></td>'+
                    '<td style="width:10%;"><select id="PaymentType'+y+'" class="select2 form-control PaymentType" onchange="paymenttypeval(this)" name="rowb['+y+'][PaymentType]"></select></td>'+
                    '<td style="width:16%;"><select id="Bank'+y+'" class="select2 form-control Bank" onchange="BankVal(this)" name="rowb['+y+'][Bank]"></select></td>'+
                    '<td style="width:13%;"><select id="AccountNumber'+y+'" class="select2 form-control AccountNumber" onchange="AccnumVal(this)" name="rowb['+y+'][AccountNumber]"></select></td>'+
                    '<td style="width:13%;"><input type="text" name="rowb['+y+'][SlipNumber]" placeholder="Write slip/ reference number here..." id="SlipNumber'+y+'" class="SlipNumber form-control" onkeyup="SlNumFn(this)" onblur="checkSlnumberFn(this)" readonly="true" style="text-transform: uppercase;"/></td>'+
                    '<td style="width:10%;"><input type="text" name="rowb['+y+'][SlipDate]" placeholder="Select slip date here..." id="SlipDate'+y+'" class="SlipDate form-control flatpickr-basic" onchange="slipDateVal(this)"/></td>'+
                    '<td style="width:13%;"><input type="number" step="any" name="rowb['+y+'][DepositedAmount]" placeholder="Write amount here..." id="DepositedAmount'+y+'" class="DepositedAmount form-control numeral-mask" onkeyup="compareBankDep('+y+')" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:14%;"><input type="text" name="rowb['+y+'][Remark]" placeholder="Write Remark here..." id="Remark'+y+'" class="Remark form-control"/></td>'+
                    '<td style="width:8%;text-align:center;"><button type="button" id="viewbtn'+y+'" class="viewcls btn btn-light btn-sm" style="display:none;color:#00cfe8 ;background-color:#FFFFFF;border-color:#FFFFFF" onmouseover="viewRef(this)"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button><button type="button" id="removebank'+y+'" class="btn btn-light btn-sm removeb-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="text" name="rowb['+y+'][contactnum]" id="contactnum'+y+'" class="contactnum form-control" readonly="true"/></td>'+
                    '<td style="display:none;"><input type="text" name="rowb['+y+'][branchadd]" id="branchadd'+y+'" class="branchadd form-control" readonly="true"/></td></tr>'    
                );

                var opt = '<option selected disabled value=""></option>';
                var options = $("#BankData > option").clone();
                $('#Bank'+y).append(options);
                $('#Bank'+y).append(opt);
                $('#Bank'+y).select2
                ({
                    placeholder: "Select bank here",
                });
                $('#AccountNumber'+y).select2
                ({
                    placeholder: "Select bank first",
                });
                var paymenttypeopt = '<option selected value=""></option><option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Bank-Transfer">Bank-Transfer</option>';
                $('#PaymentType'+y).append(paymenttypeopt);
                $('#PaymentType'+y).select2
                ({
                    placeholder: "Payment mode",
                    minimumResultsForSearch: -1,
                });
                flatpickr('#SlipDate'+y, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currdate,minDate:dateminval});
                renumberRowsB();
                $('#select2-PaymentType'+y+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                //$('#numberofItemsLbl').html(index - 1);
                ind = index - 1;
            });
            if (ind == 0) {
                $('#zpricingTable').hide();
            }
            else{
                $('#zpricingTable').show();
            }
        }

        function renumberRowsB() {
            var ind;
            $('#dynamicTableB tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                ind = index - 1;
            });
        }

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });

        $(document).on('click', '.removeb-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRowsB();
            --x;
        });

        $('#Register').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var optype = $("#operationtypes").val();
            $.ajax({ 
                url: '/saveIncome',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
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
                            $('#pointofsales-error').html(data.errors.PointOfSales[0]);
                        }
                        if (data.errors.StartDate || data.errors.EndDate) {
                            $('#date-error').html("The date field is required.");
                        }
                        if (data.errors.OtherIncome) {
                            $('#OtherIncome').css("background", errorcolor);
                        }
                        if (data.errors.CreditFiscalOtherIncome) {
                            $('#CreditFiscalOtherIncome').css("background", errorcolor);
                        }
                        if (data.errors.CashManualOtherIncome) {
                            $('#CashManualOtherIncome').css("background", errorcolor);
                        }
                        if (data.errors.CreditManualOtherIncome) {
                            $('#CreditManualOtherIncome').css("background", errorcolor);
                        }
                        if (data.errors.ShortageAmount) {
                            $('#shortageamount-error').html(data.errors.ShortageAmount[0]);
                        }
                        if (data.errors.OverageAmount) {
                            $('#overageamount-error').html(data.errors.OverageAmount[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Please check your input OR Insert valid data on highlighted fields","Error");
                    }
                    else if(data.datediff){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"There is another income before the selected date. Please choose the previous one","Error");
                    }
                    else if(data.emptyrow){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add atleast one Z number","Error");
                    }
                    else if(data.emptybankrow){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add bank information because you have received a cash","Error");
                    }
                    else if(data.missingdays){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"The MRC & Z-Number section is missing a date.Please enter each day that is included in the range of dates</br>The missing days are listed below</br>----------</br>"+data.missingdays,"Error");
                    }
                    else if(data.descasherror){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"The total cash from each Z-number and the fiscal receipt total cash doesnt match","Error");
                    }
                    else if(data.peramounterror){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Shortage amount exceeds the maximum permitted shortage amount.","Error");
                    }
                    else if(data.descrediterror){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"The total credit from each Z-number and the fiscal receipt total credit doesnt match","Error");
                    }
                    else if(data.descrerror){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Total cash deposited and Cash received doesnt match","Error");
                    }
                    else if (data.errorv2) {
                        for(var k=1;k<=m;k++){
                            var mrcnum=($('#MrcNumber'+k)).val()||0;
                            var znumber=($('#ZNumber'+k)).val();
                            var zdate=($('#ZDate'+k)).val();
                            var cashamnt=($('#CashAmount'+k)).val();
                            var credamnt=($('#CreditAmount'+k)).val();
                            var totalamnt=($('#TotalAmount'+k)).val();
                            var businessdt=($('#BusinessDay'+k)).val();

                            if(mrcnum==""||mrcnum==null){
                                $('#select2-MrcNumber'+k+'-container').parent().css('background-color',errorcolor);
                            }
                            if(($('#ZNumber'+k).val())!=undefined && parseInt(businessdt)!=2){
                                if(znumber==""||znumber==null){
                                    $('#ZNumber'+k).css("background",errorcolor);
                                }
                            }
                            if(($('#ZDate'+k).val())!=undefined){
                                if(zdate==""||zdate==null){
                                    $('#ZDate'+k).css("background",errorcolor);
                                }
                            }
                            if(($('#CashAmount'+k).val())!=undefined){
                                if(cashamnt==""||cashamnt==null){
                                    $('#CashAmount'+k).css("background",errorcolor);
                                }
                            }
                            if(($('#CreditAmount'+k).val())!=undefined){
                                if(credamnt==""||credamnt==null){
                                    $('#CreditAmount'+k).css("background",errorcolor);
                                }
                            }
                            if(($('#TotalAmount'+k).val())!=undefined){
                                if(totalamnt==""||totalamnt==null){
                                    $('#TotalAmount'+k).css("background", errorcolor);
                                }
                            }
                            if(businessdt==""||businessdt==null){
                                $('#select2-BusinessDay'+k+'-container').parent().css('background-color',errorcolor);
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
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if (data.errorv3) {
                        var deperror="";
                        for(var l=1;l<=y;l++){
                            var pmodes=($('#PaymentType'+l)).val();
                            var bankid=($('#Bank'+l)).val()||0;
                            var accnum=($('#AccountNumber'+l)).val()||0;
                            var slipnum=($('#SlipNumber'+l)).val();
                            var depamount=($('#DepositedAmount'+l)).val();
                            var sldate=($('#SlipDate'+l)).val();

                            if(pmodes==""||pmodes==null){
                                $('#select2-PaymentType'+l+'-container').parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(bankid))||parseFloat(bankid)==0){
                                $('#select2-Bank'+l+'-container').parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(accnum))||parseFloat(accnum)==0){
                                $('#select2-AccountNumber'+l+'-container').parent().css('background-color',errorcolor);
                            }
                            if(($('#SlipNumber'+l).val())!=undefined){
                                if(slipnum==""||slipnum==null){
                                    $('#SlipNumber'+l).css("background", errorcolor);
                                }
                            }
                            if(($('#SlipDate'+l).val())!=undefined){
                                if(sldate==""||sldate==null){
                                    $('#SlipDate'+l).css("background", errorcolor);
                                }
                            }
                            if(($('#DepositedAmount'+l).val())!=undefined){
                                if(depamount==""||depamount==null){
                                    $('#DepositedAmount'+l).css("background", errorcolor);
                                }
                                if(parseFloat(depamount)==0){
                                    $('#DepositedAmount'+l).css("background", errorcolor);
                                    deperror="<br>The amount should be greather than 0";
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
                        toastrMessage('error',"Please insert valid data on highlighted fields"+deperror,"Error");
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
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        closeModalWithClearValidation();
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function editIncClosing(recordId) {
            $('.select2').select2();
            $("#operationtypes").val("2");
            var clid=$("#closingId").val();
            $("#closingId").val(recordId);
            flaglist=[];
            var currentdateval=$("#CurrentDateVal").val();
            var start="";
            var end="";
            var startval="";
            var endval="";
            var enddateval="";
            var posid="";
            var trcnt=0;
            var currdate="";
            var defbusiness="";
            var defbusinessid="";
            var closingcounts=0;
            j=0;
            z=0;
            $.ajax({
                type: "get",
                url: "{{ url('/showclosingdata') }}" + '/' + recordId,
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
                    trcnt=data.voidcnt;
                    currdate=data.currdate;
                    closingcounts=data.countinc;
                    $.each(data.incdata, function(key, value) {
                        $('#PointOfSales').val(value.stores_id).select2();
                        posid=value.stores_id;
                        start = moment(value.StartDate);
                        end = moment(value.EndDate);
                        startval=value.StartDate;
                        endval=value.EndDate;
                        enddateval=value.EndDate;
                        $('#poshiddenval').val(value.stores_id);
                        $('#startdatehiddenval').val(value.StartDate);
                        $('#enddatehiddenval').val(value.EndDate);
                        $('#countposval').val(closingcounts)||0;
                        $('#StartDateComp').val(value.StartDate);
                        $('#StartDate').val(value.StartDate);
                        $('#EndDate').val(value.EndDate);
                        $('#znumberval').val(value.ZDocumentPath); 
                        $('#bankslipval').val(value.SlipDocumentPath); 
                        $('#OtherIncome').val(value.OtherIncome)||0; 
                        $('#CreditFiscalOtherIncome').val(value.CreditFiscalOtherIncome)||0; 
                        $('#CashManualOtherIncome').val(value.CashManualOtherIncome)||0; 
                        $('#CreditManualOtherIncome').val(value.CreditManualOtherIncome)||0; 
                        $('#ShortageAmount').val(value.ShortageAmount)||0; 
                        $('#OverageAmount').val(value.OverageAmount)||0; 
                        $('#overageamountinp').val(value.OverageAmount.toFixed(2));
                        $('#OverageAmount').val(value.OverageAmount.toFixed(2));
                        $('#overageamountlbl').html(numformat(value.OverageAmount.toFixed(2)));

                        $('#shortageamountinp').val(value.ShortageAmount.toFixed(2));
                        $('#ShortageAmount').val(value.ShortageAmount.toFixed(2));
                        $('#shortageamountlbl').html(numformat(value.ShortageAmount.toFixed(2)));
                        $('#Memo').val(value.Memo);
                        var statusvals=value.Status;

                        if(parseFloat(value.ShortageAmount)==0){
                            $('#shortagevartr').hide();
                        }
                        else if(parseFloat(value.ShortageAmount)>0){
                            $('#shortagevartr').show();
                        }

                        if(parseFloat(value.OverageAmount)==0){
                            $('#overagevartr').hide();
                        }
                        else if(parseFloat(value.OverageAmount)>0){
                            $('#overagevartr').show();
                        }

                        if(parseFloat(trcnt)>=1){
                            endval = moment(value.EndDate);
                        }
                        if(parseFloat(trcnt)==0){
                            endval = moment(currdate);
                        }
                        if(parseInt(closingcounts)==0){
                            $('#datetimes').daterangepicker({ 
                                minDate: start,
                                maxDate:endval,
                                startDate: start, 
                                endDate: end,
                                autoApply:false,
                                locale: {
                                    format: 'YYYY-MM-DD'
                                }
                            });	
                            datetimefn('2');
                            $(".calendar-table").show();
                        }
                        if(parseInt(closingcounts)>=1){
                            $('#datetimes').daterangepicker({ 
                                minDate: start,
                                maxDate:endval,
                                startDate: start, 
                                endDate: end,
                                autoApply:true,
                                locale: {
                                    format: 'YYYY-MM-DD'
                                }
                            });	
                            datetimefn('2');
                            $(".calendar-table").hide();
                        }
                        
                        
                        if(value.ZDocumentPath==null){
                            $("#zdocumentlinkbtn").hide(); 
                        }
                        else if(value.ZDocumentPath!=null){
                            $("#znumberval").val(value.ZDocumentPath); 
                            $("#zdocumentlinkbtn").text(value.ZDocumentName); 
                            $("#zreceiptfilename").val(value.ZDocumentName);
                            $("#zdocumentlinkbtn").show(); 
                        }

                        if(value.SlipDocumentPath==null){
                            $("#slipdocumentlinkbtn").hide(); 
                        }
                        else if(value.SlipDocumentPath!=null){
                            $("#bankslipval").val(value.SlipDocumentPath); 
                            $("#slipdocumentlinkbtn").text(value.SlipDocumentName); 
                            $("#slipreceiptfilename").val(value.SlipDocumentName);
                            $("#slipdocumentlinkbtn").show(); 
                        }

                        if(statusvals==1){
                            $("#statusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+value.StatusName+"</span>");
                        }
                        else if(statusvals==2){
                            $("#statusdisplay").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;'>"+value.StatusName+"</span>");
                        }
                        else if(statusvals==3){
                            $("#statusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+value.StatusName+"</span>");
                        }
                    });

                    $.each(data.mrcdata, function(key, value) {
                        var paymenttypeopt="";
                        var defpaymenttype="";
                        ++i;
                        ++m;
                        ++j;
                        $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width:13%;"><select id="MrcNumber'+m+'" class="select2 form-control MrcNumber" onchange="MrcNumberVal(this)" name="row['+m+'][MrcNumber]"></select></td>'+
                            '<td style="width:13%;"><input type="number" name="row['+m+'][ZNumber]" placeholder="Write z number here..." id="ZNumber'+m+'" class="ZNumber form-control numeral-mask" onkeypress="return ValidateOnlyNum(event);" onkeyup="ZnumberFn(this)" onblur="checkZnumberFn(this)" value="'+value.ZNumber+'"/></td>'+
                            '<td style="width:13%;"><input type="text" name="row['+m+'][ZDate]" placeholder="Select z date here..." id="ZDate'+m+'" class="ZDate form-control flatpickr-basic" onchange="ZdateVal(this)"/></td>'+
                            '<td style="width:14%;"><input type="number" step="any" name="row['+m+'][CashAmount]" placeholder="Write cash amount here..." id="CashAmount'+m+'" class="CashAmount form-control numeral-mask" onkeyup="CalculateTotalZ(this)" onkeypress="return ValidateNum(event);" value="'+value.CashAmount+'"/></td>'+
                            '<td style="width:14%;"><input type="number" step="any" name="row['+m+'][CreditAmount]" placeholder="Write credit amount here..." id="CreditAmount'+m+'" class="CreditAmount form-control numeral-mask" onkeyup="CalculateTotalZ(this)" onkeypress="return ValidateNum(event);" value="'+value.CreditAmount+'"/></td>'+
                            '<td style="width:14%;"><input type="number" step="any" name="row['+m+'][TotalAmount]" placeholder="Total amount" id="TotalAmount'+m+'" class="TotalAmount form-control numeral-mask" readonly="true" onkeypress="return ValidateNum(event);" style="font-weight:bold;" value="'+value.TotalAmount+'"/></td>'+
                            '<td style="width:13%;"><select id="BusinessDay'+m+'" class="select2 form-control BusinessDay" onchange="BusinessDayVal(this)" name="row['+m+'][BusinessDay]"></select></td>'+
                            '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="text" name="row['+m+'][zdatehidden]" id="zdatehidden'+m+'" class="zdatehidden form-control" readonly="true" value="'+value.ZDate+'"/></td></tr>'  
                        );
                        
                        if(parseInt(value.BusinessDay)==1){
                            defbusiness="Usual";
                            $('#ZNumber'+m).prop("readonly", false);
                            $('#CashAmount'+m).prop("readonly", false);
                            $('#CreditAmount'+m).prop("readonly", false);
                            $('#ZNumber'+m).css("background","white");
                            $('#CashAmount'+m).css("background","white");
                            $('#CreditAmount'+m).css("background","white");
                        }
                        if(parseInt(value.BusinessDay)==2){
                            defbusiness="Unusual";
                            $('#ZNumber'+m).prop("readonly", true);
                            $('#CashAmount'+m).prop("readonly", true);
                            $('#CreditAmount'+m).prop("readonly", true);
                            $('#ZNumber'+m).css("background","#efefef");
                            $('#CashAmount'+m).css("background","#efefef");
                            $('#CreditAmount'+m).css("background","#efefef");
                        }
                        var zdate=$('#zdatehidden'+m).val();
                        var defmrcopt='<option selected value="'+value.MrcNumber+'">'+value.MrcNumber+'</option>';
                        var defbusinessopt='<option selected value="'+value.BusinessDay+'">'+defbusiness+'</option>';
                        var businessdayopt='<option value="1">Usual</option><option value="2">Unusual</option>';
                        var options = $("#MrcData > option").clone();
                        $('#MrcNumber'+m).append(options);
                        $("#MrcNumber"+m+" option[title!='"+posid+"']").remove();
                        $("#MrcNumber"+m+" option[value='"+value.MrcNumber+"']").remove();
                        $('#MrcNumber'+m).append(defmrcopt);
                        $('#MrcNumber'+m).select2();

                        $('#BusinessDay'+m).append(businessdayopt);
                        $("#BusinessDay"+m+" option[value='"+value.BusinessDay+"']").remove();
                        $('#BusinessDay'+m).append(defbusinessopt);
                        $('#BusinessDay'+m).select2
                        ({
                            minimumResultsForSearch: -1,
                        });

                        flatpickr('#ZDate'+m, { dateFormat: 'Y-m-d',clickOpens:true,minDate:startval,maxDate:enddateval});
                        $('#ZDate'+m).val(zdate);
                        $('#select2-MrcNumber'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-BusinessDay'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });

                    $.each(data.bankdata, function(key, value) {
                        ++x;
                        ++y;
                        ++z;
                        $("#dynamicTableB > tbody").append('<tr id="rowind'+y+'"><td style="font-weight:bold;width:3%;text-align:center;">'+z+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="rowb['+y+'][valsb]" id="valsb'+y+'" class="valsb form-control" readonly="true" style="font-weight:bold;" value="'+y+'"/></td>'+
                            '<td style="width:10%;"><select id="PaymentType'+y+'" class="select2 form-control PaymentType" onchange="paymenttypeval(this)" name="rowb['+y+'][PaymentType]"></select></td>'+
                            '<td style="width:16%;"><select id="Bank'+y+'" class="select2 form-control Bank" onchange="BankVal(this)" name="rowb['+y+'][Bank]"></select></td>'+
                            '<td style="width:13%;"><select id="AccountNumber'+y+'" class="select2 form-control AccountNumber" onchange="AccnumVal(this)" name="rowb['+y+'][AccountNumber]"></select></td>'+
                            '<td style="width:13%;"><input type="text" name="rowb['+y+'][SlipNumber]" placeholder="Write slip/ reference number here..." id="SlipNumber'+y+'" class="SlipNumber form-control" onkeyup="SlNumFn(this)" onblur="checkSlnumberFn(this)" value="'+value.SlipNumber+'" style="text-transform: uppercase;"/></td>'+
                            '<td style="width:10%;"><input type="text" name="rowb['+y+'][SlipDate]" placeholder="Select slip date here..." id="SlipDate'+y+'" class="SlipDate form-control flatpickr-basic" onchange="slipDateVal(this)" value="'+value.SlipDate+'"/></td>'+
                            '<td style="width:13%;"><input type="number" step="any" name="rowb['+y+'][DepositedAmount]" placeholder="Write amount here..." id="DepositedAmount'+y+'" class="DepositedAmount form-control numeral-mask" onkeyup="compareBankDep('+y+')" onkeypress="return ValidateNum(event);" value="'+value.Amount+'"/></td>'+
                            '<td style="width:14%;"><input type="text" name="rowb['+y+'][Remark]" placeholder="Write Remark here..." id="Remark'+y+'" class="Remark form-control" value="'+value.Remarks+'"/></td>'+
                            '<td style="width:8%;text-align:center;"><button type="button" id="viewbtn'+y+'" class="viewcls btn btn-light btn-sm" style="display:none;color:#00cfe8 ;background-color:#FFFFFF;border-color:#FFFFFF" onmouseover="viewRef(this)"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button><button type="button" id="removebank'+y+'" class="btn btn-light btn-sm removeb-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="text" name="rowb['+y+'][contactnum]" id="contactnum'+y+'" class="contactnum form-control" readonly="true" value="'+value.ContactNumber+'"/></td>'+
                            '<td style="display:none;"><input type="text" name="rowb['+y+'][branchadd]" id="branchadd'+y+'" class="branchadd form-control" readonly="true" value="'+value.Branch+'"/></td></tr>'    
                        );
                        var bankdef='<option selected value="'+value.banks_id+'">'+value.BankName+'</option>';
                        var options = $("#BankData > option").clone();
                        $('#Bank'+y).append(options);
                        $("#Bank"+y+" option[value='"+value.banks_id+"']").remove();
                        $('#Bank'+y).append(bankdef);
                        $('#Bank'+y).select2();

                        var accnum='<option selected value="'+value.bankdetails_id+'">'+value.AccountNumber+'</option>';
                        var accoptions = $("#AccData > option").clone();
                        $('#AccountNumber'+y).append(accoptions);
                        $("#AccountNumber"+y+" option[title!='"+value.banks_id+"']").remove();
                        $("#AccountNumber"+y+" option[value='"+value.bankdetails_id+"']").remove();
                        $('#AccountNumber'+y).append(accnum);
                        $('#AccountNumber'+y).select2();

                        paymenttypeopt = '<option value="Cash">Cash</option><option value="Cheque">Cheque</option><option value="Bank-Transfer">Bank-Transfer</option>';
                        defpaymenttype='<option selected value="'+value.PaymentType+'">'+value.PaymentType+'</option>';
                        $('#PaymentType'+y).append(paymenttypeopt);
                        $("#PaymentType"+y+" option[value='"+value.PaymentType+"']").remove();
                        $('#PaymentType'+y).append(defpaymenttype);
                        $('#PaymentType'+y).select2({
                            minimumResultsForSearch: -1
                        }); 
                        flatpickr('#SlipDate'+y, { dateFormat: 'Y-m-d',clickOpens:true,minDate:dateminval,maxDate:currentdateval});
                        $('#select2-Bank'+y+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-AccountNumber'+y+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });

                    $('.viewcls').show();
                    CalculateZGrandTotal();
                    CalculateGrandTotal();
                    CalGrandTotalCash();
                }
            });
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled", false);
            $("#paymentfollowuptitle").html("Edit Income Follow-Up");
            $("#inlineForm").modal('show');
        }

        function infoClosing(recordId){
            var totalcash=0;
            var totalcredit=0;
            $('#incomeclosingtitle').html("Income Follow-Up Information");
            $("#statusid").val(recordId);
            $.ajax({
                type: "get",
                url: "{{ url('/showclosingdata') }}" + '/' + recordId,
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
                    totalcash=data.tcash;
                    totalcredit=data.tcredit;
                    $.each(data.incdata, function(key, value) {
                        $("#recoredinfolbl").html(value.IncomeDocumentNumber);
                        $("#posinfolbl").html(value.POS);
                        $("#dateinfolbl").html(value.StartDate+" <i>to</i> "+value.EndDate);
                        $("#preparedbylblinfo").html(value.PreparedBy);
                        $("#prepareddatelblinfo").html(value.CreatedDateTime);
                        $("#verifiedbylblinfo").html(value.VerifiedBy);
                        $("#verifieddatelblinfo").html(value.VerifiedDate);
                        $("#confirmedbylblinfo").html(value.ConfirmedBy);
                        $("#confirmeddatelblinfo").html(value.ConfirmedDate);
                        $("#topendingbylblinfo").html(value.ChangeToPendingBy);
                        $("#topendingdatelblinfo").html(value.ChangeToPendingDate);
                        $("#zreceipinfo").text(value.ZDocumentName);
                        $("#slipdocinfo").text(value.SlipDocumentName);
                        $("#zdocinfoval").val(value.ZDocumentPath);
                        $("#slipdocinfoval").val(value.SlipDocumentPath);
                        $("#voidbylblinfo").html(value.VoidBy);
                        $("#voiddatelblinfo").html(value.VoidDate);
                        $("#voidreasonlblinfo").html(value.VoidReason);
                        $("#undovoidbylblinfo").html(value.UndoVoidBy);
                        $("#undovoiddatelblinfo").html(value.UndoVoidDate);
                        $("#lasteditedbylblinfo").html(value.LastEditedBy);
                        $("#lastediteddatelblinfo").html(value.LastEditedDate);
                        $("#memolblinfo").html(value.Memo);
                        $("#depositedcashlblinfo").html(numformat(value.TotalCashDeposited.toFixed(2)));
                        $("#shortageamountlblinfo").html(numformat(value.ShortageAmount.toFixed(2)));
                        $("#overageamountlblinfo").html(numformat(value.OverageAmount.toFixed(2)));
                        
                        $("#fiscalcaslcashinclbl").html(numformat(value.FisCashIncome.toFixed(2)));
                        $("#otherfiscalcashinclbl").html(numformat(value.OtherIncome.toFixed(2)));
                        $("#manualcashinclbl").html(numformat(value.ManCashIncome.toFixed(2)));
                        $("#othermanualcashinclbl").html(numformat(value.CashManualOtherIncome.toFixed(2)));
                        $("#creditsettlementinclbl").html(numformat(value.CreditSettIncome.toFixed(2)));
                        
                        $("#totalcashinfo").html(numformat(value.TotalCash.toFixed(2)));
                        $("#withodcashlblinfo").html(numformat(value.WitholdAmount.toFixed(2)));
                        $("#vatcashlblinfo").html(numformat(value.VatAmount.toFixed(2)));
                        $("#otherincomeinfo").html(numformat(value.OtherIncome.toFixed(2)));
                        $("#netcashlblinfo").html(numformat(value.NetCashReceived.toFixed(2)));

                        $("#cashincomelblinfo").html(numformat(value.FisCashIncome.toFixed(2)));
                        $("#othercashlblinfo").html(numformat(value.OtherIncome.toFixed(2)));
                        $("#totalcashlblinfo").html(numformat((value.FisCashIncome+value.OtherIncome).toFixed(2)));

                        $("#creditincomelblinfo").html(numformat(value.FisCreditIncome.toFixed(2)));
                        $("#othercreditlblinfo").html(numformat(value.CreditFiscalOtherIncome.toFixed(2)));
                        $("#totalcreditlblinfo").html(numformat((value.FisCreditIncome+value.CreditFiscalOtherIncome).toFixed(2)));

                        $("#cashincomemanlblinfo").html(numformat(value.ManCashIncome.toFixed(2)));
                        $("#othercashmanlblinfo").html(numformat(value.CashManualOtherIncome.toFixed(2)));
                        $("#totalcashmanlblinfo").html(numformat((value.ManCashIncome+value.CashManualOtherIncome).toFixed(2)));

                        $("#creditincomemanlblinfo").html(numformat(value.ManCreditIncome.toFixed(2)));
                        $("#othercreditmanlblinfo").html(numformat(value.CreditManualOtherIncome.toFixed(2)));
                        $("#totalcreditmanlblinfo").html(numformat((value.ManCreditIncome+value.CreditManualOtherIncome).toFixed(2)));

                        $("#cashsettlementincomelbl").html(numformat(value.CreditSettIncome.toFixed(2)));
                        $("#shortageamountinfo").html(numformat(value.ShortageAmount.toFixed(2)));
                        $("#overageamountinfo").html(numformat(value.OverageAmount.toFixed(2)));
                        
                        $("#shortageamountlblinfo").html(numformat(value.ShortageAmount.toFixed(2)));
                        $("#overageamountlblinfo").html(numformat(value.OverageAmount.toFixed(2)));
                        
                        if(parseFloat(value.ShortageAmount)==0){
                            $('#shortagevartrinfo').hide();
                        }
                        else if(parseFloat(value.ShortageAmount)>0){
                            $('#shortagevartrinfo').show();
                        }

                        if(parseFloat(value.OverageAmount)==0){
                            $('#overagevartrinfo').hide();
                        }
                        else if(parseFloat(value.OverageAmount)>0){
                            $('#overagevartrinfo').show();
                        }

                        var statusvals=value.StatusName;
                        var settstatus=value.Status;
                        $("#deppricingTableinfo").show();
                        $("#witholdamounttrinfo").show();
                        $("#vatamounttrinfo").show();
                        if(parseFloat(value.TotalCashDeposited)==0){
                            $("#deppricingTableinfo").hide();
                        }
                        if(parseFloat(value.WitholdAmount)==0){
                            $("#witholdamounttrinfo").hide();
                        }
                        if(parseFloat(value.VatAmount)==0){
                            $("#vatamounttrinfo").hide();
                        }
                        if(parseFloat(value.WitholdAmount)==0 && parseFloat(value.VatAmount)==0){
                            $("#netcashreceivedtrinfo").hide();
                        }
                        if(parseFloat(value.WitholdAmount)>0 || parseFloat(value.VatAmount)>0){
                            $("#netcashreceivedtrinfo").show();
                        }
                        
                        if(parseFloat(settstatus)==1){
                            $("#changetopending").hide();
                            $("#verifyclosingbtn").show();
                            $("#confirmclosingbtn").hide();
                            $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else if(parseFloat(settstatus)==2){
                            $("#changetopending").show();
                            $("#verifyclosingbtn").hide();
                            $("#confirmclosingbtn").show();
                            $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else if(parseFloat(settstatus)==3){
                            $("#changetopending").hide();
                            $("#verifyclosingbtn").hide();
                            $("#confirmclosingbtn").hide();
                            $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else{
                            $("#changetopending").hide();
                            $("#verifyclosingbtn").hide();
                            $("#confirmclosingbtn").hide();
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+statusvals+"</span>");
                        }

                    });
                },
            });

            $('#mrcinfotbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:true,
                info:false,
                searchHighlight: true,
            
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/mrcdetaildata/'+recordId,
                    type: 'DELETE',
                    },
                columns: [
                    { data:'DT_RowIndex', width:'3%'},
                    { data: 'MrcNumber', name: 'MrcNumber', width:'13%'},
                    { data: 'ZNumber', name: 'ZNumber', width:'13%'},
                    { data: 'ZDate', name: 'ZDate', width:'13%'}, 
                    { data: 'CashAmount', name: 'CashAmount',render: $.fn.dataTable.render.number(',', '.',2, ''), width:'15%'},
                    { data: 'CreditAmount', name: 'CreditAmount',render: $.fn.dataTable.render.number(',', '.',2, ''), width:'15%'},    
                    { data: 'TotalAmount', name: 'TotalAmount',render: $.fn.dataTable.render.number(',', '.',2, ''), width:'15%'},
                    { data: 'BusinessDays', name: 'BusinessDays', width:'13%'}, 
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api();
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var cashtotal = api
                    .column(4)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var creditotal = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var grandtotal = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $("#totalcashzamountinfo").html(numformat(cashtotal.toFixed(2)));
                    $("#totalcreditzamountinfo").html(numformat(creditotal.toFixed(2)));
                    $("#totalzamountinfo").html(numformat(grandtotal.toFixed(2)));
                },
            });

            $('#bankinfotbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:true,
                info:false,
                searchHighlight: true,
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/bankdetaildata/'+recordId,
                    type: 'DELETE',
                    },
                columns: [
                    { data:'DT_RowIndex', width:'3%'},
                    { data: 'PaymentType', name: 'PaymentType', width:'10%'},
                    { data: 'BankName', name: 'BankName', width:'18%'},
                    { data: 'AccountNumber', name: 'AccountNumber', width:'15%'},
                    { data: 'SlipNumber', name: 'SlipNumber', width:'14%'}, 
                    { data: 'SlipDate', name: 'SlipDate', width:'10%'}, 
                    { data: 'Amount', name: 'Amount',render: $.fn.dataTable.render.number(',', '.',2, ''), width:'14%'},
                    { data: 'Remarks', name: 'Remarks', width:'16%'}, 
                ],
            });

            $(".infodocrec").collapse('show');
            $("#incomeclosinginfomodal").modal('show');
        }

        //Start change to verified
        $('#verifybtn').click(function() {
            var recordId = $('#checkedid').val();
            var settstatus=0;
            var statusvals="";
            var zdoc=0;
            var slipdoc=0;
            var missingdate=0
            var missingdays="";
            var totalcashdep=0;
            var totalcashrec=0;
            var totalcashreceived=0;

            var fiscalcashrec=0;
            var fiscalcreditrec=0;
            var fiscalcashinput=0;
            var fiscalcreditinput=0;
            var permittedamount=0;
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                permittedamount=$("#permittedVerified").val()||0;
                zdoc=data.zuploadcnt;
                slipdoc=data.slipuploadcnt;
                missingdate=data.missingday;
                missingdays=data.allday;
                totalcashdep=data.totalcashdep;
                totalcashrec=parseFloat(data.netcashrec)+parseFloat(data.overageamnt||0)-parseFloat(data.shortageamnt||0);
                totalcashreceived=totalcashrec.toFixed(2);
                fiscalcashrec=data.totalcashrec;
                fiscalcreditrec=data.totalcreditrec;
                fiscalcashinput=data.tcash;
                fiscalcreditinput=data.tcredit;
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(zdoc)==0 && parseFloat(slipdoc)==0){
                    toastrMessage('error',"Please upload Z-receipt and Bank slip/reference","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(zdoc)==0){
                    toastrMessage('error',"Please upload Z-receipt","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(slipdoc)==0){
                    toastrMessage('error',"Please upload Bank slip/reference","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(settstatus)!=1){
                    toastrMessage('error',"You cant verify income follow-up on "+statusvals+" status","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(missingdate)>=1){
                    toastrMessage('error',"The MRC & Z-Number section is missing a date.Please enter each day that is included in the range of dates</br>The missing days are listed below</br>----------</br>"+missingdays,"Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(fiscalcashrec)!=parseFloat(fiscalcashinput)){
                    
                    toastrMessage('error',"The total cash from each Z-number and the fiscal receipt total cash doesnt match","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(fiscalcreditrec)!=parseFloat(fiscalcreditinput)){
                    toastrMessage('error',"The total credit from each Z-number and the fiscal receipt total credit doesnt match","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(data.shortageamnt||0)>parseFloat(permittedamount)){
                    toastrMessage('error',"Shortage amount exceeds the maximum permitted shortage amount.","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(totalcashdep)!=parseFloat(totalcashreceived)){
                    toastrMessage('error',"Total cash deposited and Cash received doesnt match","Error");
                    $("#verifymodal").modal('hide');
                }
                else if(parseFloat(settstatus)==1 && parseFloat(zdoc)>=1 && parseFloat(slipdoc)>=1 && parseFloat(missingdate)==0 && parseFloat(totalcashdep)==parseFloat(totalcashreceived)  && parseFloat(data.shortageamnt||0)<=parseFloat(permittedamount)){
                    var registerForm = $("#verifyform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/verfyinc',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#verifybtn').text('Verifying...');
                            $('#verifybtn').prop("disabled", true);
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
                                $('#verifybtn').text('Verify Income Follow-Up');
                                toastrMessage('success',"Income follow-up verified","Success");
                                $("#changetopending").show();
                                $("#confirmclosingbtn").show();
                                $("#verifyclosingbtn").hide();
                                var today = new Date();
                                var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
                                var un=$("#usernamelbl").val();
                                $("#verifiedbylblinfo").html(un);
                                $("#verifieddatelblinfo").html(currentdate);
                                $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>Verified</span>");
                                $("#verifymodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                
            });
        });
        //End change to verified

        //Start change to pending
        $('#pendingbtn').click(function() {
            var recordId = $('#pendingid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(settstatus)==2){
                    var registerForm = $("#incomepenfollowupform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/pendinginc',
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
                                toastrMessage('success',"Income follow-up changed to pending","Success");
                                $("#changetopending").hide();
                                $("#confirmclosingbtn").hide();
                                $("#verifyclosingbtn").show();
                                var today = new Date();
                                var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
                                var un=$("#usernamelbl").val();
                                $("#topendingbylblinfo").html(un);
                                $("#topendingdatelblinfo").html(currentdate);
                                $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>Pending</span>");
                                $("#incomependingfollowupmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant change income follow-up to pending on "+statusvals+" status","Error");
                    $("#incomependingfollowupmodal").modal('hide');
                }
            });
        });
        //End change to pending

        //Start change to confirm
        $('#confirmbtn').click(function() {
            var recordId = $('#confirmid').val();
            var settstatus=0;
            var statusvals="";
            var zdoc=0;
            var slipdoc=0;
            var missingdate=0
            var missingdays="";
            var totalcashdep=0;
            var totalcashrec=0;
            var fiscalcashrec=0;
            var fiscalcreditrec=0;
            var fiscalcashinput=0;
            var fiscalcreditinput=0;
            var totalcashreceived=0;
            var permittedamount=0;
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                permittedamount=$("#permittedConfirmed").val()||0;
                zdoc=data.zuploadcnt;
                slipdoc=data.slipuploadcnt;
                missingdate=data.missingday;
                missingdays=data.allday;
                totalcashdep=data.totalcashdep;
                totalcashrec=parseFloat(data.netcashrec)+parseFloat(data.overageamnt||0)-parseFloat(data.shortageamnt||0);
                totalcashreceived=totalcashrec.toFixed(2);
                fiscalcashrec=data.totalcashrec;
                fiscalcreditrec=data.totalcreditrec;
                fiscalcashinput=data.tcash;
                fiscalcreditinput=data.tcredit;
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(zdoc)==0 && parseFloat(slipdoc)==0){
                    toastrMessage('error',"Please upload Z-receipt and Bank slip/reference","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(zdoc)==0){
                    toastrMessage('error',"Please upload Z-receipt","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(slipdoc)==0){
                    toastrMessage('error',"Please upload Bank slip/reference","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(settstatus)!=2){
                    toastrMessage('error',"You cant verify income follow-up on "+statusvals+" status","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(missingdate)>=1){
                    toastrMessage('error',"The MRC & Z-Number section is missing a date.Please enter each day that is included in the range of dates</br>The missing days are listed below</br>"+missingdays,"Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(fiscalcashrec)!=parseFloat(fiscalcashinput)){
                    toastrMessage('error',"The total cash from each Z-number and the fiscal receipt total cash doesnt match","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(fiscalcreditrec)!=parseFloat(fiscalcreditinput)){
                    toastrMessage('error',"The total credit from each Z-number and the fiscal receipt total credit doesnt match","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(data.shortageamnt||0)>parseFloat(permittedamount)){
                    toastrMessage('error',"Shortage amount exceeds the maximum permitted shortage amount.","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(totalcashdep)!=parseFloat(totalcashreceived)){
                    toastrMessage('error',"Total cash deposited and Net cash received doesnt match","Error");
                    $("#incomeconffollowupmodal").modal('hide');
                }
                else if(parseFloat(settstatus)==2 && parseFloat(zdoc)>=1 && parseFloat(slipdoc)>=1 && parseFloat(missingdate)==0 && parseFloat(totalcashdep)==parseFloat(totalcashreceived) && parseFloat(data.shortageamnt||0)<=parseFloat(permittedamount)){
                    var registerForm = $("#incomeconffollowupform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/confirminc',
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
                                $('#confirmbtn').text('Confirm Income Follow-Up');
                                toastrMessage('success',"Income follow-up confirmed","Success");
                                $("#incomeconffollowupmodal").modal('hide');
                                $("#incomeclosinginfomodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
            });
        });
        //End change to confirm

        function voidClosing(recordId){
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            $('.Reason').val("");
            $('#void-error').html("");
            $("#voididn").val(recordId);
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                cnt=data.voidcnt;
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(cnt)>=1){
                    toastrMessage('error',"Unable to void these records because these POS have an income follow-up after the current record.","Error");
                }
                else if(parseFloat(cnt)==0){
                    if(parseFloat(settstatus)==1||parseFloat(settstatus)==2||parseFloat(settstatus)==3){ 
                        $('#vstatus').val(settstatus);
                        $('#voidbtn').prop("disabled", false);
                        $('#voidbtn').text("Void");
                        $("#voidreasonmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"You cant void income follow-up on "+statusvals+" status","Error");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        //Start void income follow-up
        $('#voidbtn').click(function() {
            var recordId = $('#voididn').val();
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                cnt=data.voidcnt;
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(cnt)>=1){
                    toastrMessage('error',"Unable to void these records because these POS have an income follow-up after the current record.","Error");
                }
                else if(parseFloat(cnt)==0){
                    if(parseFloat(settstatus)==1||parseFloat(settstatus)==2||parseFloat(settstatus)==3){
                        var registerForm = $("#voidreasonform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/voidincfollowup',
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
                                    toastrMessage('success',"Income follow-up voided","Success");
                                    $("#voidreasonmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    }
                    else{
                        toastrMessage('error',"You cant void income follow-up on "+statusvals+" status","Error");
                        $("#voidreasonmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });
        //End void income follow-up

        function undovoidlnbtn(recordId){
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            $("#undovoidid").val(recordId);
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                cnt=data.undovoidcnt;
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(cnt)>=1){
                    toastrMessage('error',"Before these transactions, you void income follow-up for these POS","Error");
                }
                else if(parseFloat(cnt)==0){
                    if(parseFloat(settstatus)==4||parseFloat(settstatus)==5||parseFloat(settstatus)==6||parseFloat(settstatus)==7){
                        $('#vstatus').val(settstatus);
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"You cant undo void income follow-up on "+statusvals+" status","Error");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        //Start undo void income follow-up
        $('#undovoidbtn').click(function() {    
            var recordId = $('#undovoidid').val();
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            $.get("/showclosingdata" + '/' + recordId, function(data) {
                cnt=data.undovoidcnt;
                $.each(data.incdata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.StatusName;
                });
                if(parseFloat(cnt)>=1){
                    toastrMessage('error',"Before these transactions, you void income follow-up for these POS","Error");
                }
                else if(parseFloat(cnt)==0){
                    if(parseFloat(settstatus)==5||parseFloat(settstatus)==6||parseFloat(settstatus)==7){
                        var registerForm = $("#undovoidform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/undovoidfollowup',
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
                                if (data.success) {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('success',"Undo-voided income follow-up","Success");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    }
                    else{
                        toastrMessage('error',"You cant undo void income follow-up on "+statusvals+" status","Error");
                        $("#undovoidmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });
        //End undo void income follow-up

        function MrcNumberVal(ele){
            var dateval = $('#StartDate').val();
            var enddate = $('#EndDate').val();
            var mrcnum = $(ele).closest('tr').find('.MrcNumber').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            var closingid=$('#closingId').val()||0;
            var znum=$(ele).closest('tr').find('.ZNumber').val()||0;
            var mrcnumbers=$(ele).closest('tr').find('.MrcNumber').val()||0;
            var closingids="";
            var znumbers="";
            var mrcnum="";
            var arr = [];
            var found = 0;
            var zdatehidd=$('#zdatehidden'+idval).val();
            flatpickr('#ZDate'+idval, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:enddate,minDate:dateval});
            $('#select2-MrcNumber'+idval+'-container').parent().css('background-color',"white");
            $('#ZNumber'+idval).prop("readonly", false);
            $('#ZDate'+idval).val(zdatehidd);
            
            for(var k=1;k<=m;k++){
                if(($('#ZNumber'+k).val())!=undefined){
                    if(($('#MrcNumber'+k).val()==mrcnum) && ($('#ZNumber'+k).val()==znum)){
                        found+=1;
                    }
                }
            }
        
            $.ajax({
                url: '/ZnumVal',
                type: 'POST',
                data:{
                    closingids:closingid,
                    znumbers:znum,
                    mrcnum:mrcnumbers,
                },
                success: function(data) {  
                    if(parseFloat(data.contn)>0){
                        $('#ZNumber'+idval).val("");
                        $('#ZNumber'+idval).css("background",errorcolor);
                        toastrMessage('error',"Z number has already been taken","Error");
                    }
                    else if(parseFloat(found)>1){
                        $('#ZNumber'+idval).val("");
                        $('#ZNumber'+idval).css("background",errorcolor);
                        toastrMessage('error',"Z number has already been taken","Error");
                    }
                }
            });
        }

        function BusinessDayVal(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            var closingid=$('#closingId').val()||0;
            var businessd=$(ele).closest('tr').find('.BusinessDay').val();
            if(parseInt(businessd)==1){
                $('#ZNumber'+idval).prop("readonly", false);
                $('#CashAmount'+idval).prop("readonly", false);
                $('#CreditAmount'+idval).prop("readonly", false);
                $('#ZNumber'+idval).css("background","white");
                $('#CashAmount'+idval).css("background","white");
                $('#CreditAmount'+idval).css("background","white");
            }
            if(parseInt(businessd)==2){
                $('#ZNumber'+idval).prop("readonly", true);
                $('#CashAmount'+idval).prop("readonly", true);
                $('#CreditAmount'+idval).prop("readonly", true);
                $('#ZNumber'+idval).val("");
                $('#CashAmount'+idval).val("0");
                $('#CreditAmount'+idval).val("0");
                $('#TotalAmount'+idval).val("0");
                $('#ZNumber'+idval).css("background","#efefef");
                $('#CashAmount'+idval).css("background","#efefef");
                $('#CreditAmount'+idval).css("background","#efefef");
            }
            $('#select2-BusinessDay'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-BusinessDay'+idval+'-container').parent().css('background-color',"white");
            CalculateZGrandTotal(); 
        }

        function checkZnumberFn(ele){
            var closingid=$('#closingId').val()||0;
            var optype=$('#operationtypes').val();
            var cid=$(ele).closest('tr').find('.vals').val();
            var znum=$(ele).closest('tr').find('.ZNumber').val();
            var mrcnumbers=$(ele).closest('tr').find('.MrcNumber').val()||0;
            var closingids="";
            var znumbers="";
            var mrcnum="";
            var arr = [];
            var found = 0;
            for(var k=1;k<=m;k++){
                if(($('#ZNumber'+k).val())!=undefined){
                    if(($('#MrcNumber'+k).val()==mrcnumbers) && ($('#ZNumber'+k).val()==znum)){
                        found+=1;
                    }
                }
            }
            $.ajax({
                url: '/ZnumVal',
                type: 'POST',
                data:{
                    closingids:closingid,
                    znumbers:znum,
                    mrcnum:mrcnumbers,
                },
                success: function(data) {  
                    if(parseFloat(data.contn)>0){
                        $('#ZNumber'+cid).val("");
                        $('#ZNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Z number has already been taken","Error");
                    }
                    else if(parseFloat(found)>1){
                        $('#ZNumber'+cid).val("");
                        $('#ZNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Z number has already been taken","Error");
                    }
                }
            });
        }

        function checkSlnumberFn(ele){
            var closingid=$('#closingId').val()||0;
            var optype=$('#operationtypes').val();
            var cid=$(ele).closest('tr').find('.valsb').val();
            var bankid=$(ele).closest('tr').find('.Bank').val()||0;
            var accountnum=$(ele).closest('tr').find('.AccountNumber').val()||0;
            var slipnumber=$(ele).closest('tr').find('.SlipNumber').val()||0;
            var paymentmodes=$(ele).closest('tr').find('.PaymentType').val()||0;
            var closingids="";
            var bankids="";
            var accnum="";
            var slipnum="";
            var pmodes="";
            var arr = [];
            var found = 0;
            for(var l=1;l<=y;l++){
                if(($('#SlipNumber'+l).val())!=undefined){
                    if(($('#Bank'+l).val()==bankid) && ($('#SlipNumber'+l).val()==slipnumber) && ($('#PaymentType'+l).val()==paymentmodes)){
                        found+=1;
                    }
                }
            }
            $.ajax({
                url: '/SlipNumVal',
                type: 'POST',
                data:{
                    closingids:closingid,
                    bankids:bankid,
                    accnum:accountnum,
                    slipnum:slipnumber,
                    pmodes:paymentmodes,
                },
                success: function(data) {  
                    if(parseFloat(data.contn)>0){
                        $('#SlipNumber'+cid).val("");
                        $('#SlipNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Transaction Reference number has already been taken","Error");
                    }
                    else if(parseFloat(found)>1){
                        $('#SlipNumber'+cid).val("");
                        $('#SlipNumber'+cid).css("background", errorcolor);
                        toastrMessage('error',"Transaction Reference number has already been taken","Error");
                    }
                }
            });
        }

        function paymenttypeval(ele){
            var idval = $(ele).closest('tr').find('.valsb').val();
            $('#select2-PaymentType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-PaymentType'+idval+'-container').parent().css('background-color',"white");
            checkSlnumberFn(ele);
        }

        function BankVal(ele){
            var dateval = $('#StartDate').val();
            var enddate = $('#EndDate').val();
            var idval = $(ele).closest('tr').find('.valsb').val();
            var opt = '<option selected disabled value=""></option>';
            var options = $("#AccData > option").clone();
            var closingid=$('#closingId').val()||0;
            var optype=$('#operationtypes').val();
            var cid=$(ele).closest('tr').find('.valsb').val();
            var bankid=$(ele).closest('tr').find('.Bank').val()||0;
            var accountnum=$(ele).closest('tr').find('.AccountNumber').val()||0;
            var slipnumber=$(ele).closest('tr').find('.SlipNumber').val()||0;
            var closingids="";
            var bankids="";
            var accnum="";
            var slipnum="";
            var arr = [];
            var found = 0;
            checkSlnumberFn(ele);
            $('#AccountNumber'+idval).append(options);
            $("#AccountNumber"+idval+" option[title!='"+bankid+"']").remove();
            $('#AccountNumber'+idval).append(opt);
            $('#AccountNumber'+idval).select2
            ({
                placeholder: "Select account number here",
            });
            $('#select2-Bank'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-Bank'+idval+'-container').parent().css('background-color',"white");
            
        }

        function AccnumVal(ele){
            var dateval = $('#StartDate').val();
            var enddate = $('#EndDate').val();
            var bankid = "";
            var accnum ="";
            var idval = $(ele).closest('tr').find('.valsb').val();
            $.ajax({
                url: '/bankdetinfo',
                type: 'POST',
                data:{
                    bankid :$(ele).closest('tr').find('.Bank').val(),
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
            $('#SlipNumber'+idval).prop("readonly", false);
            $('#viewbtn'+idval).show();
        }

        function ZdateVal(ele){
            var zdate = $(ele).closest('tr').find('.ZDate').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#zdatehidden'+idval).val(zdate);
            $('#ZDate'+idval).css("background","white");
        }

        function ZnumberFn(ele){
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#ZNumber'+idval).css("background","white");
        }

        function SlNumFn(ele){
            var idval = $(ele).closest('tr').find('.valsb').val();
            $('#SlipNumber'+idval).css("background","white");
        }

        function slipDateVal(ele){
            var idval = $(ele).closest('tr').find('.valsb').val();
            $('#SlipDate'+idval).css("background","white");
        }

        function CalculateTotalZ(ele) {
            var totalamount=0;
            var cid = $(ele).closest('tr').find('.vals').val();
            var cashamount = $(ele).closest('tr').find('.CashAmount').val()||0;
            var creditamount = $(ele).closest('tr').find('.CreditAmount').val()||0;
            totalamount=parseFloat(cashamount)+parseFloat(creditamount);
            $(ele).closest('tr').find('.TotalAmount').val(totalamount);
            var inputid = ele.getAttribute('id');
            if(inputid==="CashAmount"+cid){

                $(ele).closest('tr').find('.CashAmount').css("background","white");
            }
            if(inputid==="CreditAmount"+cid){
                $(ele).closest('tr').find('.CreditAmount').css("background","white");
            }
            $(ele).closest('tr').find('.TotalAmount').css("background","#efefef");
            CalculateZGrandTotal(); 
            compareCash(cid);
            compareCredit(cid);
        }

        function viewRef(ele) {
            var idval = $(ele).closest('tr').find('.valsb').val();
            var branchname = $(ele).closest('tr').find('.branchadd').val();
            var contactnum = $(ele).closest('tr').find('.contactnum').val();
            $('#viewbtn'+idval).popover({
                trigger: "hover",
                title: 'Bank Detail Info',
                width:'1000px',
                container: "body",
                html: true,
                content: function () {
                    $("#referencedetail").html("Branch : <b>"+branchname+"</b></br>Contact # : <b>"+contactnum+"</b>");
                    return $("#referencediv").html(); 
                }
            });
        }

        function ZdocumentDownload() {
            var recordId = $('#closingId').val();
            var filenames = $('#znumberval').val();
            $.get("/downloadzdoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/ZDocumentUploads/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function SlipdocumentDownload() {
            var recordId = $('#closingId').val();
            var filenames = $('#bankslipval').val();
            $.get("/downloadsldoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/BankSlipUploads/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function ZdocdownloadFn() {
            var recordId = $('#statusid').val();
            var filenames = $('#zdocinfoval').val();
            $.get("/downloadzdoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/ZDocumentUploads/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function slipdocdownloadFn() {
            var recordId = $('#statusid').val();
            var filenames = $('#slipdocinfoval').val();
            $.get("/downloadsldoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/BankSlipUploads/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function CalculateGrandTotal() {
            var grandTotal = 0; 
            var shortagevar = $('#ShortageAmount').val()||0;
            var overagevar = $('#OverageAmount').val()||0;
            //var idval = $(ele).closest('tr').find('.valsb').val();
            $.each($('#dynamicTableB').find('.DepositedAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });

            $('#depositedcashlbl').html(numformat(grandTotal.toFixed(2)));
            $('#depositedcashinp').val(grandTotal.toFixed(2));

            if(parseFloat(grandTotal)>0){
                $('#deppricingTable').show();
            }
            else if(parseFloat(grandTotal)==0){
                $('#deppricingTable').hide();
            }

            // if(parseFloat(shortagevar)==0){
            //     $('#shortagevartr').hide();
            // }
            // else if(parseFloat(shortagevar)>0){
            //     $('#shortagevartr').show();
            // }

            // if(parseFloat(overagevar)==0){
            //     $('#overagevartr').hide();
            // }
            // else if(parseFloat(overagevar)>0){
            //     $('#overagevartr').show();
            // }
            //$('#DepositedAmount'+idval).css("background","white");
        }

        function CalculateZGrandTotal() {
            var cashtotal = 0; 
            var credittotal = 0; 
            var grandTotal = 0; 
            var totalcash = $('#cashfiscaltotalval').val()||0;
            $.each($('#dynamicTable').find('.CashAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    cashtotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.CreditAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    credittotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.TotalAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });

            $('#totalcashzamount').html(numformat(cashtotal.toFixed(2)));
            $('#totalcashzamountinp').val(cashtotal.toFixed(2));
            $('#totalcreditzamount').html(numformat(credittotal.toFixed(2)));
            $('#totalcreditzamountinp').val(credittotal.toFixed(2));
            $('#totalzamount').html(numformat(grandTotal.toFixed(2)));
            $('#totalzamountinp').val(grandTotal.toFixed(2));
            $('#zpricingTable').show();
        }

        function compareCash(flg){
            var totalcashrec = $('#cashfiscaltotalval').val()||0;
            var totalcashinc = $('#totalcashzamountinp').val()||0;
            if(parseFloat(totalcashinc) > parseFloat(totalcashrec)){
                toastrMessage('error',"Cash amount is greather than "+numformat(totalcashrec),"Error");
                if(parseInt(flg)>=1){
                    $('#CashAmount'+flg).val("");
                    $('#CashAmount'+flg).css("background",errorcolor);
                    var cash=$('#CashAmount'+flg).val()||0;
                    var credit=$('#CreditAmount'+flg).val()||0;
                    var total=parseFloat(cash)+parseFloat(credit);
                    $('#TotalAmount'+flg).val(total.toFixed(2));
                }
                if(parseInt(flg)==0){
                    $('.CashAmount').val("");
                    $('.CashAmount').css("background",errorcolor);
                    for(var n=1;n<=m;n++){
                        var cash=$('#CashAmount'+n).val()||0;
                        var credit=$('#CreditAmount'+n).val()||0;
                        var total=parseFloat(cash)+parseFloat(credit);
                        $('#TotalAmount'+n).val(total.toFixed(2));
                    }
                }
            }
            CalculateZGrandTotal(); 
        }

        function compareCredit(flg){
            var totalcredit = $('#creditfiscaltotalval').val()||0;
            var totalcreditinc = $('#totalcreditzamountinp').val()||0;
            if(parseFloat(totalcreditinc) > parseFloat(totalcredit)){
                toastrMessage('error',"Credit amount is greather than "+numformat(totalcredit),"Error");
                if(parseInt(flg)>=1){
                    $('#CreditAmount'+flg).val("");
                    $('#CreditAmount'+flg).css("background",errorcolor);
                    var cash=$('#CashAmount'+flg).val()||0;
                    var credit=$('#CreditAmount'+flg).val()||0;
                    var total=parseFloat(cash)+parseFloat(credit);
                    $('#TotalAmount'+flg).val(total.toFixed(2));
                }
                if(parseInt(flg)==0){
                    $('.CreditAmount').val("");
                    $('.CreditAmount').css("background",errorcolor);
                    for(var n=1;n<=m;n++){
                        var cash=$('#CashAmount'+n).val()||0;
                        var credit=$('#CreditAmount'+n).val()||0;
                        var total=parseFloat(cash)+parseFloat(credit);
                        $('#TotalAmount'+n).val(total.toFixed(2));
                    }

                }
            }
            CalculateZGrandTotal(); 
        }

        function compareBankDep(flg){
            var totalcashrec = $('#cashfiscaltotalval').val()||0;
            var totalmanualrec = $('#cashmanualtotalval').val()||0;
            var creditsettcash = $('#settledincomeval').val()||0;
            CalculateGrandTotal(); 
            var totalcashdep = $('#depositedcashinp').val()||0;
            var netpayval = $('#netcashrecinp').val()||0;
            var variance=parseFloat(netpayval)-parseFloat(totalcashdep);
            variance=parseFloat(variance)+0;// to implement toFixed
            if(parseFloat(variance)>0){
                $('#shortagevartr').show();
                $('#overagevartr').hide();
                $('#overageamountinp').val("");
                $('#overageamountlbl').html("");
                $('#OverageAmount').val("0");
                $('#shortageamountinp').val(variance.toFixed(2));
                $('#ShortageAmount').val(variance.toFixed(2));
                $('#shortageamountlbl').html(numformat(variance.toFixed(2)));
            }
            else if(parseFloat(variance)<0){
                variance=parseFloat(variance)*(-1);
                $('#shortagevartr').hide();
                $('#shortageamountinp').val("");
                $('#shortageamountlbl').html("");
                $('#ShortageAmount').val("0");
                $('#overagevartr').show();
                $('#overageamountinp').val(variance.toFixed(2));
                $('#OverageAmount').val(variance.toFixed(2));
                $('#overageamountlbl').html(numformat(variance.toFixed(2)));
            }
            else if(parseFloat(variance)==0){
                $('#shortagevartr').hide();
                $('#shortageamountinp').val("");
                $('#shortageamountlbl').html("");
                $('#ShortageAmount').val("0");
                $('#overagevartr').hide();
                $('#overageamountinp').val("");
                $('#overageamountlbl').html("");
                $('#OverageAmount').val("0");
                $('#shortageamountinp').val("0");
                $('#ShortageAmount').val("0");
                $('#shortageamountlbl').html("0");
                $('#overageamountinp').val("0");
                $('#OverageAmount').val("0");
                $('#overageamountlbl').html("0");
            }
            //var totalcash=parseFloat(totalcashrec)+parseFloat(totalmanualrec)+parseFloat(creditsettcash);
            // if(parseFloat(totalcashdep) > parseFloat(totalcash)){
            //     toastrMessage('error',"Total cash deposit is greater than "+numformat(totalcash),"Error");
            //     if(parseInt(flg)>=1){
            //         $('#DepositedAmount'+flg).val("");
            //         $('#DepositedAmount'+flg).css("background",errorcolor);
            //     }
            //     if(parseInt(flg)==0){
            //         $('.DepositedAmount').val("");
            //         $('.DepositedAmount').css("background",errorcolor);
            //     }
            // }
            // else{
            //     $('#DepositedAmount'+flg).css("background","white");
            // }
            CalculateGrandTotal(); 
        }

        function shortageVarFn(){
            var shortagevar = $('#ShortageAmount').val()||0;
            var overagevar = $('#OverageAmount').val()||0;
            var minimumAmountval = $('#minimumShortageVar').val()||0;
            $('#overagevartr').hide();
            $('#OverageAmount').val("0");
            $('#overageamountinp').val("");
            $('#overageamountlbl').html("");
            shortagevar=parseFloat(shortagevar)+0;// to implement toFixed
            if(parseFloat(shortagevar)==0){
                $('#shortagevartr').hide();
                $('#shortageamountinp').val("");
                $('#shortageamountlbl').html("");
            }
            else if(parseFloat(shortagevar)>0){
                if(parseFloat(shortagevar)>parseFloat(minimumAmountval)){
                    $('#shortagevartr').hide();
                    $('#shortageamountinp').val("");
                    $('#shortageamountlbl').html("");
                    $('#ShortageAmount').val("0");
                    toastrMessage('error',"Shortage amount exceeds the maximum permitted shortage amount.","Error");
                }
                else if(parseFloat(shortagevar)<=parseFloat(minimumAmountval)){
                    $('#shortagevartr').show();
                    $('#shortageamountinp').val(shortagevar.toFixed(2));
                    $('#shortageamountlbl').html(numformat(shortagevar.toFixed(2)));
                }
            }
            $('#shortageamount-error').html("");
            $('#overageamount-error').html("");
        }

        function overageVarFn(){
            var shortagevar = $('#ShortageAmount').val()||0;
            var overagevar = $('#OverageAmount').val()||0;
            $('#shortagevartr').hide();
            $('#ShortageAmount').val("0");
            $('#shortageamountinp').val("");
            $('#shortageamountlbl').html("");
            overagevar=parseFloat(overagevar)+0;// to implement toFixed
            if(parseFloat(overagevar)==0){
                $('#overagevartr').hide();
                $('#overageamountinp').val("");
                $('#overageamountlbl').html("");
            }
            else if(parseFloat(overagevar)>0){
                $('#overagevartr').show();
                $('#overageamountinp').val(overagevar.toFixed(2));
                $('#overageamountlbl').html(numformat(overagevar.toFixed(2)));
            }
            $('#shortageamount-error').html("");
            $('#overageamount-error').html("");
        }

        function closeModalWithClearValidation(){
            $('#PointOfSales').select2('destroy');
            $('#PointOfSales').val(null).select2();
            $("#revenuetitle").html("Income");
            $('#fiscalcashreceiptlbl').html("");
            $('#FiscalCashIncHidden').val("");
            $('#fiscalcreditreceiptlbl').html("");
            $('#FiscalCreditIncHidden').val("");
            $('#manualcashreceiptlbl').html("");
            $('#ManualCashIncHidden').val("");
            $('#manualcreditreceiptlbl').html("");
            $('#ManualCreditIncHidden').val("");
            $('#pointofsales-error').html("");
            $('#date-error').html("");
            $('#settledamountlbl').html("");
            $('#settledincomeval').val("");
            $('#pricingTable').hide();
            $('#deppricingTable').hide();
            $('#StartDate').val("");
            $('#EndDate').val("");
            $('#StartDateComp').val("");
            $('#bankslipval').val("");
            $('#znumberval').val("");
            $('#dynamicTable tbody').empty();
            $('#dynamicTableB tbody').empty();
            $('#followdate span').html("");
            $('#BankSlip').val("");
            $('#rembankslsp').hide();
            $('#ZRecDoc').val("");
            $('#znumberval').val("");
            $('#remznumsp').hide();
            $('#zdocumentlinkbtn').hide();
            $('#slipdocumentlinkbtn').hide();
            $('#closingId').val("");
            $('#Memo').val("");
            $('#OtherIncome').val("");
            $('#shortageamountinp').val("");
            $('#overageamountinp').val("");
            $('#ShortageAmount').val("");
            $('#OverageAmount').val("");
            $('#CreditFiscalOtherIncome').val("");
            $('#CashManualOtherIncome').val("");
            $('#CreditManualOtherIncome').val("");
            $('#cashfiscaltotalval').val("");
            $('#creditfiscaltotalval').val("");
            $('#cashmanualtotalval').val("");
            $('#creditmanualtotalval').val("");
            $('#cashfiscaltotallbl').html("");
            $('#creditfiscaltotallbl').html("");
            $('#cashmanualtotallbl').html("");
            $('#creditmanualtotallbl').html("");
            $('#shortageamountlbl').html("");
            $('#overageamountlbl').html("");
            $('#OtherIncome').css("background","white");
            $('#CreditFiscalOtherIncome').css("background","white");
            $('#CashManualOtherIncome').css("background","white");
            $('#CreditManualOtherIncome').css("background","white");
            $('#poshiddenval').val("");
            $('#countposval').val("");
            resetInfo();
        }

        function resetInfo(){
            $('.footercal').hide();
        }

        function CalculateDiffrence(ele) {
            var loopingval = 0;
            $.each($('#dynamicTable').find('.amount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    loopingval += parseFloat($(this).val());
                }
            });
            var permanentcash=$('#totalcashpermanent').val();
            var netvalue=parseFloat(permanentcash)-parseFloat(loopingval);
            if(parseFloat(netvalue)<=0){
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("You inserted excess amount");
                $('.toast-body').css({"background-color": "#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                $(ele).closest('tr').find('.amount').val("");
                $.each($('#dynamicTable').find('.amount'), function() {
                    if ($(this).val() != '' && !isNaN($(this).val())) {
                        loopingval += parseFloat($(this).val());
                    }
                });
            
                var net=parseFloat(permanentcash)-parseFloat(loopingval);
                $('#totalcash').html(numformat(netvalue.toFixed(2)));
                $('#totalcashi').val(netvalue);
            }
            else if(parseFloat(netvalue)>0){
                $('#totalcash').html(numformat(netvalue.toFixed(2)));
                $('#totalcashi').val(netvalue);
            }
        }

        function clearZError() {
            $('#zrec-error').html('');
            $('#znumberval').val("");
            $('#remznumsp').show();
        }

        function clearBankSlError() {
            $('#banksl-error').html('');
            $('#bankslipval').val("");
            $('#rembankslsp').show();
        }

        //Start Print Attachment
        $('body').on('click', '.printIncomeAtt', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Income-Follow-Up', 'width=1200,height=800,scrollbars=yes'); 
        });
        //End Print Attachment

        function calcotherfn(){
            var totalfiscalcash=0;
            var cashitinc=$('#FiscalCashIncHidden').val()||0;
            var otherincome=$('#OtherIncome').val()||0;
            var otherinc=$('#OtherIncome').val();
            totalfiscalcash=parseFloat(cashitinc)+parseFloat(otherincome);
            if(isNaN(parseFloat(otherinc))){
                $('#cashfiscaltotalval').val(totalfiscalcash.toFixed(2));
                $('#cashfiscaltotallbl').html("");
            }
            if(!isNaN(parseFloat(otherinc))){
                $('#cashfiscaltotalval').val(totalfiscalcash.toFixed(2));
                $('#cashfiscaltotallbl').html(numformat(totalfiscalcash.toFixed(2)));
                $('#OtherIncome').css("background","white");
            }
            CalGrandTotalCash();
            compareCash(0);
            compareBankDep(0);
        }

        function calcfiscreditfn(){
            var totalfiscalcredit=0;
            var creditinc=$('#FiscalCreditIncHidden').val()||0;
            var creditotherinc=$('#CreditFiscalOtherIncome').val()||0;
            var creditfiscalinc=$('#CreditFiscalOtherIncome').val();
            totalfiscalcredit=parseFloat(creditinc)+parseFloat(creditotherinc);
            if(isNaN(parseFloat(creditfiscalinc))){
                $('#creditfiscaltotalval').val(totalfiscalcredit.toFixed(2));
                $('#creditfiscaltotallbl').html("");
            }
            if(!isNaN(parseFloat(creditfiscalinc))){
                $('#creditfiscaltotalval').val(totalfiscalcredit.toFixed(2));
                $('#creditfiscaltotallbl').html(numformat(totalfiscalcredit.toFixed(2)));
                $('#CreditFiscalOtherIncome').css("background","white");
            }
            CalGrandTotalCash();
            compareCredit(0);
        }

        function calcmanualcashfn(){
            var totalmanualcash=0;
            var manualcashinc=$('#ManualCashIncHidden').val()||0;
            var cashmanualotherinc=$('#CashManualOtherIncome').val()||0;
            var cashmanualinc=$('#CashManualOtherIncome').val();
            totalmanualcash=parseFloat(manualcashinc)+parseFloat(cashmanualotherinc);
            if(isNaN(parseFloat(cashmanualinc))){
                $('#cashmanualtotalval').val(totalmanualcash.toFixed(2));
                $('#cashmanualtotallbl').html("");
            }
            if(!isNaN(parseFloat(cashmanualinc))){
                $('#cashmanualtotalval').val(totalmanualcash.toFixed(2));
                $('#cashmanualtotallbl').html(numformat(totalmanualcash.toFixed(2)));
                $('#CashManualOtherIncome').css("background","white");
            } 
            compareBankDep(0);
            CalGrandTotalCash(); 
        }

        function calcmanualcreditfn(){
            var totalmanualcredit=0;
            var manualcreditinc=$('#ManualCreditIncHidden').val()||0;
            var creditmanualotherinc=$('#CreditManualOtherIncome').val()||0;
            var creditmanualinc=$('#CreditManualOtherIncome').val();
            totalmanualcredit=parseFloat(manualcreditinc)+parseFloat(creditmanualotherinc);
            if(isNaN(parseFloat(creditmanualinc))){
                $('#creditmanualtotalval').val(totalmanualcredit.toFixed(2));
                $('#creditmanualtotallbl').html("");
            }
            if(!isNaN(parseFloat(creditmanualinc))){
                $('#creditmanualtotalval').val(totalmanualcredit.toFixed(2));
                $('#creditmanualtotallbl').html(numformat(totalmanualcredit.toFixed(2)));
                $('#CreditManualOtherIncome').css("background","white"); 
            }  
            CalGrandTotalCash();
        }

        function CalGrandTotalCash(){
            var totalgrandcash=0;
            var netcahsreceived=0;
            var totalfiscalcash= $('#cashfiscaltotalval').val()||0;
            var totalmanualcahs=$('#cashmanualtotalval').val()||0;
            var totalsettlement=$('#settledincomeval').val()||0;
            var withold=$('#witholdcashinp').val()||0;
            var vat=$('#vatcashinp').val()||0;
            totalgrandcash=parseFloat(totalfiscalcash)+parseFloat(totalmanualcahs)+parseFloat(totalsettlement);
            netcahsreceived=parseFloat(totalgrandcash)-parseFloat(withold)-parseFloat(vat);
            if(parseFloat(withold)>0 || parseFloat(vat)>0){
                $('#netcashtr').show();
            }
            if(parseFloat(withold)==0 && parseFloat(vat)==0){
                $('#netcashtr').hide();
            }
            $('#totalcashi').val(totalgrandcash.toFixed(2));
            $('#totalcash').html(numformat(totalgrandcash.toFixed(2)));
            $('#netcashrecinp').val(netcahsreceived.toFixed(2));
            $('#netcashlbl').html(numformat(netcahsreceived.toFixed(2)));
        }

        function getVerifyInfoConf() {
            var stid = $('#statusid').val();
            $('#checkedid').val(stid);
            $('#verifymodal').modal('show');
            $('#verifybtn').prop("disabled", false);
            $('#verifybtn').text("Verify Income Follow-Up");
        }

        function getPendingInfoConf() {
            var stid = $('#statusid').val();
            $('#pendingid').val(stid);
            $('#incomependingfollowupmodal').modal('show');
            $('#pendingbtn').prop("disabled", false);
            $('#pendingbtn').text("Change to Pending");
        }

        function getConfirmInfoConf() {
            var stid = $('#statusid').val();
            $('#confirmid').val(stid);
            $('#incomeconffollowupmodal').modal('show');
            $('#confirmbtn').prop("disabled", false);
            $('#confirmbtn').text("Confirm Income Follow-Up");
        }

        $(document).on('click', '.removebankslipbtn', function() {
            $('#BankSlip').val("");
            $('#bankslipval').val("");
            $('#rembankslsp').hide();
        });

        $(document).on('click', '.removezdocbtn', function() {
            $('#ZRecDoc').val("");
            $('#znumberval').val("");
            $('#remznumsp').hide();
        });

        function voidReason() {
            $('#void-error').html("");
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>

@endsection
