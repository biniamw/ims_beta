@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Invoice-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom" style="height: 5rem;padding: 0.8rem;">
                            <h3 class="card-title">Fitness Form</h3>
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Voucher-tab" data-toggle="tab" href="#dailytab" aria-controls="invoice" role="tab" aria-selected="true" onclick="masterview()">Invoice View</a>                                
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Members-tab" data-toggle="tab" href="#memberstab" aria-controls="members" role="tab" aria-selected="false" style="display: none;" onclick="memberview()">Clients View</a>
                                </li>
                            </ul>
                            <div>
                                <input type="hidden" class="form-control" name="currentdateval" id="currentdateval" readonly="true" value="{{$cdate}}">
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-content"> 
                                    <div class="tab-pane active" id="dailytab" aria-labelledby="dailytab" role="tabpanel">
                                        <div class="col-lg-2 col-xl-2 col-md-4 col-sm-12 col-12" style="position: absolute;left: 260px;top: 85px;z-index: 10;display:none;" id="fiscalyear_div">
                                            <select class="select2 form-control" name="fiscalyear[]" id="fiscalyear">
                                                @foreach ($fiscalyears as $fiscalyears)
                                                    <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="width:99%; margin-left:0.5%;">
                                            <div id="app_dt" style="display: none;">
                                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none;"/th>
                                                            <th style="width: 3%;">#</th>
                                                            <th style="width: 8%;">Invoice Type</th>
                                                            <th style="width: 8%;">Group Category</th>
                                                            <th style="width: 8%;">POS</th>
                                                            <th style="width: 8%;">Voucher Type</th>
                                                            <th style="width: 8%;">FS/ Doc #</th>
                                                            <th style="width: 8%;">Inv/ Ref #</th>
                                                            <th style="width: 8%;">Inv/ Doc Date</th>
                                                            <th style="width: 8%;">Service(s)</th>
                                                            <th style="width: 13%;">Client(s)</th>
                                                            <th style="width: 8%;">Phone</th>
                                                            <th style="width: 8%;">Status</th>
                                                            <th style="width: 4%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="memberstab" aria-labelledby="memberstab" role="tabpanel">
                                        <div class="col-lg-2 col-xl-2 col-md-4 col-sm-12 col-12" style="position: absolute;left: 260px;top: 85px;z-index: 10;display:none;" id="service_st_div">
                                            <select class="selectpicker form-control" name="service_status[]" id="service_status" title="Select Service status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                                @foreach ($servicestatus as $servicestatus)
                                                    <option value="{{ $servicestatus->Status }}">{{ $servicestatus->Status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div style="width:99%; margin-left:0.5%;">
                                            <div id="member_dt" style="display: none;">
                                                <table id="laravel-datatable-crudmem" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="display: none;"/th>
                                                            <th style="width: 3%;">#</th>
                                                            <th style="width: 5%;">Face ID</th>
                                                            <th style="width: 12%;">Client ID</th>
                                                            <th style="width: 16%;">Full Name</th>
                                                            <th style="width: 12%;">Gender</th>
                                                            <th style="width: 12%;">DOB</th>
                                                            <th style="width: 12%;">Phone</th>
                                                            <th style="width: 12%;">Loyalty Status</th>
                                                            <th style="width: 12%;">Service Status</th>
                                                            <th style="width: 4%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
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

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="apptitle"></h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="AppRegister">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12 col-md-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 col-sm-12">
                                                <fieldset class="fset">
                                                    <legend>Basic Information</legend>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">Invoice Type    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" id="ApplicationType" name="ApplicationType" onchange="applicationTypeFn()">
                                                                <option selected disabled value=""></option>
                                                                <option value="New">New</option>
                                                                <option value="Renew">Renew</option>
                                                                <option value="Trainer-Fee">Trainer-Fee</option>
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="applicationtype-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-8 col-md-6 col-sm-12 mb-2" id="applicationiddiv" style="display: none;">
                                                            <label strong style="font-size: 14px;">FS/Invoice Number    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" id="ApplicationsId" name="ApplicationsId"></select>
                                                            <span class="text-danger">
                                                                <strong id="applicationid-error"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">No. of Group    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" name="Group" id="Group"></select>
                                                            <span class="text-danger">
                                                                <strong id="group-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                                            <label strong style="font-size: 14px;">Payment Term    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" name="PaymentTerm" id="PaymentTerm"></select>
                                                            <span class="text-danger">
                                                                <strong id="paymentterm-error"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="regdatediv" style="display: none;">
                                                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">Start Date    <b style="color:red;">*</b></label>
                                                            <input type="text" name="RegistationDate" placeholder="YYYY-MM-DD" onchange="regDateFn()" id="RegistationDate" class="RegistationDate form-control flatpickr-basic"/>
                                                            <span class="text-danger">
                                                                <strong id="regdate-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">End Date    <b style="color:red;">*</b></label>
                                                            <input type="text" name="ExpiryDate" placeholder="End Date" id="ExpiryDate" class="ExpiryDate form-control" readonly/>
                                                            <span class="text-danger">
                                                                <strong id="expdatedate-error"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-8 col-md-6 col-sm-12">
                                                <fieldset class="fset">
                                                    <legend>Invoice Information</legend>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">Point of Sales    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" name="Pos" id="Pos" onchange="posFn()">
                                                                <option selected disabled value=""></option>
                                                                @foreach ($shop as $shop)
                                                                    <option value="{{$shop->id}}">{{$shop->Name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="pos-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">Voucher Type    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" id="VoucherType" name="VoucherType" onchange="vouchertypeFn()">
                                                                <option selected disabled value=""></option>
                                                                <option value="Fiscal-Receipt">Fiscal-Receipt</option>
                                                                <option value="Manual-Receipt">Manual-Receipt</option>
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="vouchertype-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="mrcdiv" style="display:none;">
                                                            <label strong style="font-size: 14px;">MRC    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" id="mrc" name="mrc" onchange="mrcFn()"></select>
                                                            <span class="text-danger">
                                                                <strong id="mrc-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                            <label strong style="font-size: 14px;">Payment Type    <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control appsel" id="PaymentType" name="PaymentType" onchange="paymenttypeFn()">
                                                                <option selected disabled value=""></option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Credit">Credit</option>
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="paymenttype-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                                            <label id="fsnumberlbl" strong style="font-size: 14px;">FS No.</label>    <b style="color:red;">*</b>
                                                            <input type="text" placeholder="FS/Doc Number" class="form-control" name="VoucherNumber" id="VoucherNumber" onkeyup="voucherNumberval()" onkeypress="return ValidateOnlyNum(event);" />
                                                            <span class="text-danger">
                                                                <strong id="voucherNumber-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12" id="invnumdiv">
                                                            <label strong style="font-size: 14px;">Invoice/Ref No.</label>
                                                            <input type="text" placeholder="Invoice/Reference Number" class="form-control" name="InvoiceNumber" id="InvoiceNumber" onkeyup="invoiceNumberval()"/>
                                                            <span class="text-danger">
                                                                <strong id="invoiceNumber-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                                            <label strong style="font-size: 14px;">Invoice Date    <b style="color:red;">*</b></label>
                                                            <input type="text" id="date" name="date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="dateVal()"/>
                                                            <span class="text-danger">
                                                                <strong id="date-error"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                                            <label strong style="font-size: 14px;">Memo</label>
                                                            <div>
                                                                <textarea type="text" placeholder="Write Memo here..." class="form-control" name="Memo" id="Memo"></textarea>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="memo-error"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="divider trncls">
                                            <div class="divider-text">Trainer Selection</div>
                                        </div> 
                                        <div class="divider newext">
                                            <div class="divider-text">Client Selection</div>
                                        </div> 
                                        <div class="row newext">
                                            <div class="col-xl-12 col-md-6 col-sm-12">
                                                <table id="dynamicTablem" class="mb-0 ccc rtable" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 3%">#</th>
                                                            <th style="width: 61%">Client Name    <b style="color:red;">*</b></th>
                                                            <th style="width: 14%">Client ID</th>
                                                            <th style="width: 14%">Loyalty Status</th>
                                                            <th style="width: 8%"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <table style="width:100%">
                                                    <tr>
                                                        <td colspan="2">
                                                            <button type="button" name="addsm" id="addsm" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>      Add Client</button>
                                                        <td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="divider newext">
                                            <div class="divider-text">Service Selection</div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-xl-12 col-md-6 col-sm-12">
                                                <table id="dynamicTable" class="mb-0 newext rtable" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 3%;">#</th>
                                                            <th style="width: 16%;">Service Name    <b style="color:red;">*</b></th>
                                                            <th style="width: 16%;">Period    <b style="color:red;">*</b></th>
                                                            <th style="width: 11%;">Before Tax</th>
                                                            <th style="width: 11%;">Tax</th>
                                                            <th style="width: 11%;">Grand Total</th>
                                                            <th style="width: 12%;">Discount (%)</th>
                                                            <th style="width: 16%;">Access Control</th>
                                                            <th style="width: 3%;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <table id="dynamicTableTrn" class="mb-0 trncls rtable" style="width:100%;display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 3%;">#</th>
                                                            <th style="width: 15%;">Client Name</th>
                                                            <th style="width: 10%;">Client ID</th>
                                                            <th style="width: 14%;">Service Name</th>
                                                            <th style="width: 15%;">Trainer</th>
                                                            <th style="width: 10%;">Before Tax</th>
                                                            <th style="width: 10%;">Tax</th>
                                                            <th style="width: 10%;">Grand Total</th>
                                                            <th style="width: 10%;">Discount (%)</th>
                                                            <th style="width: 3%;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                                <table style="width:100%">
                                                    <tr class="newext">
                                                        <td colspan="2">
                                                            <button type="button" name="addser" id="addser" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>        Add Service</button>
                                                        <td>
                                                    </tr>
                                                    <tr class="trncls" style="display: none;">
                                                        <td colspan="2">
                                                            <button type="button" name="addstr" id="addstr" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>        Add Trainer</button>
                                                        <td>
                                                    </tr>
                                                    
                                                </table>
                                                <div class="col-xl-12">
                                                    <div class="row">
                                                        <div class="col-xl-9 col-lg-12"></div>
                                                        <div class="col-xl-3 col-lg-12">
                                                            <table style="width:103%;text-align:right" id="pricingTable" class="rtable">
                                                                <tr style="display:none;" class="totalrownumber">
                                                                    <td style="text-align:right;width:45%">
                                                                        <label strong style="font-size: 14px;">Sub Total</label>
                                                                    </td>
                                                                    <td style="text-align:center; width:55%">
                                                                        <label id="subtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                        <input type="hidden" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0" />
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;" class="totalrownumber">
                                                                    <td style="text-align: right;">
                                                                        <label strong style="font-size: 14px;">Total Tax</label>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <label id="taxLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                        <input type="hidden" class="form-control" name="taxi" id="taxi" readonly="true" value="0" />
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;" class="totalrownumber">
                                                                    <td style="text-align: right;">
                                                                        <label strong style="font-size: 14px;">Grand Total</label>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <label id="grandtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                        <input type="hidden" class="form-control" name="grandtotali" id="grandtotali" readonly="true" value="0" />
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;" class="totaldiscnumber">
                                                                    <td style="text-align: right;">
                                                                        <label id="dislbl" strong style="font-size: 14px;color:#ea5455;">Discount</label>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <label id="discountlbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;color:#ea5455;"></label>
                                                                        <input type="hidden" class="form-control" name="discounti" id="discounti" readonly="true" value="0" />
                                                                        <input type="hidden" class="form-control" name="discountper" id="discountper" readonly="true" value="0" />
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;" class="totalrownumberm">
                                                                    <td style="text-align: right;width:45%"><label strong style="font-size: 14px;">No. of Client(s)</label></td>
                                                                    <td style="text-align: center;width:55%"><label id="numberofItemsLblm" strong style="font-size: 14px; font-weight: bold;">0</label></td>
                                                                </tr>
                                                                <tr style="display:none;" class="totalrownumber">
                                                                    <td style="text-align: right;width:45%"><label strong style="font-size: 14px;">No. of Service(s)</label></td>
                                                                    <td style="text-align: center;width:55%"><label id="numberofItemsLbl" strong style="font-size: 14px; font-weight: bold;">0</label></td>
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
                        </section>
                    </div>
                    <div class="modal-footer">
                        <table style="width:100%;">
                            <tr>
                                <td style="width:50%">
                                    <label strong style="font-size: 12px;">Upload Application Form</label><br>
                                    <div class="row">
                                        <div class="col-xl-5 col-md-6 col-sm-12">
                                            <input type="file" name="ApplicationDocument" id="ApplicationDocument" accept="application/pdf,image/*" class="form-control fileuploads mainforminp">
                                        </div>
                                        <div class="col-xl-7 col-md-6 col-sm-12 ml-0">
                                            <button type="button" id="applicationdoclinkbtn" name="applicationdoclinkbtn" class="btn btn-flat-info waves-effect applicationdoclinkcls" style="display:none;"></button>
                                            <input type="hidden" name="applicationdocumentupdate" id="applicationdocumentupdate" class="form-control" readonly>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    
                                    <div style="display: none;">
                                        <div id="mempicdiv">
                                            <div id="membertitle" style="font-size: 16px;font-weight:bold;"></div>
                                            <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                                <img id="previewMemImg" src="" alt="Picture not found" height="200" width="200">
                                            </div>
                                        </div>
                                        <select class="select2 form-control appsel" id="groupcbx" name="groupcbx">
                                            <option selected disabled value=""></option>
                                            @foreach ($groupmem as $groupmem)
                                                <option value="{{$groupmem->id}}">{{$groupmem->GroupName}}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control appsel" id="membershipcbx" name="membershipcbx">
                                            <option selected disabled value=""></option>
                                            @foreach ($membershipinfos as $membershipinfos)
                                                <option title="{{ $membershipinfos->applications_id }}" value="{{ $membershipinfos->memberships_id}}">{{$membershipinfos->MemberInfo }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control appsel" id="servicetrncbx" name="servicetrncbx">
                                            <option selected disabled value=""></option>
                                            @foreach ($serviceinfos as $serviceinfos)
                                                <option label="{{ $serviceinfos->memberships_id }}" title="{{ $serviceinfos->applications_id }}" value="{{ $serviceinfos->services_id}}">{{$serviceinfos->ServiceName }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control appsel" id="trainercbx" name="trainercbx">
                                            <option selected disabled value=""></option>
                                            @foreach ($trainerinfos as $trainerinfos)
                                                <option title="{{ $trainerinfos->services_id }}" value="{{ $trainerinfos->employes_id}}">{{$trainerinfos->TrainerName }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control appsel" id="applicationsidcbx" name="applicationsidcbx">
                                            <option selected disabled value=""></option>
                                            @foreach ($appidsrc as $appidsrc)
                                                <option value="{{ $appidsrc->id }}">{{ $appidsrc->FSNum }}         ,       {{ $appidsrc->MemberInfo }}         ,       {{ $appidsrc->ServiceInfo }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control" name="paymenttermcbx" id="paymenttermcbx">
                                            <option selected disabled value=""></option>
                                            @foreach ($paymenttr as $paymenttr)
                                                <option value="{{$paymenttr->id}}">{{$paymenttr->PaymentTermName}}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control" name="mrccbx" id="mrccbx">
                                            <option selected value=""></option>
                                            @foreach ($mrclist as $mrclist)
                                                <option title="{{ $mrclist->store_id }}" value="{{ $mrclist->mrcNumber }}">{{ $mrclist->mrcNumber }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control" name="servicecbx" id="servicecbx">
                                            <option selected value=""></option>
                                            @foreach ($servicepr as $servicepr)
                                                <option label="{{ $servicepr->groupmembers_id }}" title="{{ $servicepr->paymentterms_id }}" value="{{ $servicepr->id }}">{{ $servicepr->ServiceName }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control" name="devicecbx" id="devicecbx">
                                            <option selected value=""></option>
                                            @foreach ($deviceval as $deviceval)
                                                <option value="{{ $deviceval->id }}">{{ $deviceval->DeviceName }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control" name="periodcbx" id="periodcbx">
                                            <option selected value=""></option>
                                            @foreach ($periodpr as $periodpr)
                                                <option accesskey="{{ $periodpr->services_id }}" label="{{ $periodpr->groupmembers_id }}" title="{{ $periodpr->paymentterms_id }}" value="{{ $periodpr->id }}">{{ $periodpr->PeriodName }}</option>
                                            @endforeach
                                        </select>
                                        <select class="select2 form-control" name="membercbx" id="membercbx">
                                            <option selected value=""></option>
                                            @foreach ($membershipval as $membership)
                                                <option value="{{ $membership->id }}">{{$membership->Name}}   ,   {{$membership->Mobile}}   ,   {{$membership->Phone}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" class="form-control" name="groupidrenew" id="groupidrenew" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="groupsizerenew" id="groupsizerenew" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="loyaltydiscountVal" id="loyaltydiscountVal" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="groupcategory" id="groupcategory" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="applicationCountVal" id="applicationCountVal" readonly="true" value="0"/>
                                    <input type="hidden" class="form-control" name="ExpireDateHiddenVal" id="ExpireDateHiddenVal" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="hiddenLasttrid" id="hiddenLasttFrid" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="hiddenAppType" id="hiddenAppType" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="PaymentTermAmountVal" id="PaymentTermAmountVal" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="GroupAmountVal" id="GroupAmountVal" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="ApplicationGroupVal" id="ApplicationGroupVal" readonly="true" value=""/>
                                    <input type="hidden" class="form-control" name="applicationId" id="applicationId" readonly="true" value=""/>     
                                    <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                                    <input type="hidden" class="form-control" name="documentNumbers" id="documentNumbers" readonly="true" value=""/>
                                    @can('Invoice-Add')
                                        <button id="savebutton" type="submit" class="btn btn-info">Save</button>
                                    @endcan   
                                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start settlement modal -->
    <div class="modal fade text-left" id="applicationinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="applicationinfotitle">Application Detail Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="applicationinfoclose()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="applicationinfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                    <span class="lead collapse-title">Basic, Invoice and Action Information</span>
                                                    <div style="text-align: right;" id="statustitles"></div>
                                                </div>
                                                <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infodocrec">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:none;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Basic Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr style="display:none;">
                                                                                <td><label strong style="font-size: 14px;">ID</label></td>
                                                                                <td><label id="applicationidinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Type</label></td>
                                                                                <td><label id="applicationtypeinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Group Category</label></td>
                                                                                <td><label id="groupcategoryinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Group</label></td>
                                                                                <td><label id="groupinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Payment Term</label></td>
                                                                                <td><label id="paymentterminfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Start Date</label></td>
                                                                                <td><label id="registrationdateinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">End Date</label></td>
                                                                                <td><label id="expirydateinfolbl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Invoice Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Point of Sales</label></td>
                                                                                <td><label id="posinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Voucher Type</label></td>
                                                                                <td><label id="vouchertypinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">MRC #</label></td>
                                                                                <td><label id="mrcinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Payment Type</label></td>
                                                                                <td><label id="paymenttypeinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">FS/ Doc #</label></td>
                                                                                <td><label id="fsnumberinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Invoice/ Ref #</label></td>
                                                                                <td><label id="invoiceinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Invoice Date</label></td>
                                                                                <td><label id="invoicedateinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr id="baseappidtr">
                                                                                <td><label strong style="font-size: 14px;">Base Application FS/ Doc , Invoice/ Ref #</label></td>
                                                                                <td><label id="baseapplicationinfolbl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Memo</label></td>
                                                                                <td><label id="memoinfolbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
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
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title" style="color: white;">.</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%">
                                                                            
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Refund By</label></td>
                                                                                <td><label id="refundbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Refund Date</label></td>
                                                                                <td><label id="refunddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Refund Reason</label></td>
                                                                                <td><label id="refundreasonlblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Undo Refund By</label></td>
                                                                                <td><label id="undorefundbylblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Undo Refund Date</label></td>
                                                                                <td><label id="undorefunddatelblinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                                                                                <td colspan="2">
                                                                                    <div class="divider">
                                                                                        <div class="divider-text">-</div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label strong style="font-size: 14px;">Application Document</label></td>
                                                                                <td><a style="text-decoration:underline;color:blue;" onclick="applicationDocumentsFn()" id="applicationdocid"></a></td>
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
                        <div class="divider" style="margin-top: -2rem">
                            <div class="divider-text">Client and Service Information </div>
                        </div> 
                        <div class="row">
                            <div style="width:98%; margin-left:1%;" class="nlink">
                                <div class="table-responsive scroll scrdiv">
                                    <div class="divider" style="display: none;">
                                        <div class="divider-text">Client Information</div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12 mb-2" style="display: none;">
                                            <table id="memberandserviceinfo" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>#</th>
                                                        <th>Client ID</th>
                                                        <th>Client Name</th>
                                                        <th>Phone</th>
                                                        <th>Service Name</th>
                                                        <th>Period</th>
                                                        <th>Active Range</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="divider" style="display: none;">
                                        <div class="divider-text">Service Information</div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <table id="memberservicepricetbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Invoice Type</th>
                                                        <th>Group Category</th>
                                                        <th>No. of Group</th>
                                                        <th>Payment Term</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Client Name</th>
                                                        <th>Phone</th>
                                                        <th>Service Name</th>
                                                        <th>Period</th>
                                                        <th>Device (Access Control)</th>
                                                        <th>Before Tax</th>
                                                        <th>Tax</th>
                                                        <th>Grand Total</th>
                                                        <th>Discount (%)</th>
                                                        <th></th>
                                                        <th>Loyalty Status</th>
                                                        <th>Service Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12 mt-1"></div>
                                        <div class="col-xl-3 col-lg-12 mt-1">
                                            <table style="width:100%;text-align:right" id="pricingTable" class="rtable">
                                                <tr>
                                                    <td style="text-align:right;width:45%">
                                                        <label strong style="font-size: 14px;">Sub Total</label>
                                                    </td>
                                                    <td style="text-align:center; width:55%">
                                                        <label id="subtotalinfolbl" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">
                                                        <label strong style="font-size: 14px;">Tax</label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <label id="taxinfolbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">
                                                        <label strong style="font-size: 14px;">Grand Total</label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <label id="grandtotalinfolbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    </td>
                                                </tr>
                                                <tr style="display:none;" id="discounttr">
                                                    <td style="text-align: right;">
                                                        <label id="discountinfolbl" strong style="font-size: 14px;color:#ea5455;">Discount</label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <label id="discountlblinfo" class="formattedNum" strong style="font-size: 14px; font-weight: bold;color:#ea5455;"></label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div style="width:98%; margin-left:1%;" class="trlink">
                                <div class="table-responsive scroll scrdiv">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <table id="membertrainerservicetbl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Client Name</th>
                                                        <th>Phone</th>
                                                        <th>Service Name</th>
                                                        <th>Period</th>
                                                        <th>Active Range</th>
                                                        <th>Trainer Name</th>
                                                        <th>Before Tax</th>
                                                        <th>Tax</th>
                                                        <th>Grand Total</th>
                                                        <th>Discount (%)</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12 mt-1"></div>
                                        <div class="col-xl-3 col-lg-12 mt-1">
                                            <table style="width:100%;text-align:right" class="rtable">
                                                <tr>
                                                    <td style="text-align:right;width:45%">
                                                        <label strong style="font-size: 14px;">Sub Total</label>
                                                    </td>
                                                    <td style="text-align:center; width:55%">
                                                        <label id="subtotalinfolbltr" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">
                                                        <label strong style="font-size: 14px;">Tax</label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <label id="taxinfolbltr" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;">
                                                        <label strong style="font-size: 14px;">Grand Total</label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <label id="grandtotalinfolbltr" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    </td>
                                                </tr>
                                                <tr style="display:none;" id="discounttrn">
                                                    <td style="text-align: right;">
                                                        <label id="discountinfolbltr" strong style="font-size: 14px;color:#ea5455;">Discount</label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <label id="discountlblinfotr" strong style="font-size: 14px; font-weight: bold;color:#ea5455;"></label>
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
                        <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                        <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                        <input type="hidden" class="form-control applicationinfoid" name="applicationinfoid" readonly="true">
                        <input type="hidden" class="form-control documentinfoval" name="documentinfoval" readonly="true">
                        <button id="sendtodevicebtn" type="button" onclick="sendtodevfn()" class="btn btn-info">Send to Device</button>
                        @can('Invoice-Verify')
                            <button id="verifyapplicationbtn" type="button" onclick="getverifyappinfo()" class="btn btn-info">Verify</button>
                        @endcan
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal" onclick="applicationinfoclose()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End application info modal -->

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
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to void invoice?</label>
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
                            <input type="hidden" class="form-control voidid" name="voididn" id="voididn" readonly="true">
                            <input type="hidden" class="form-control vstatus" name="vstatus" id="vstatus" readonly="true">
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

    <!--Start Refund modal -->
    <div class="modal fade text-left" id="refundreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="refundReasonFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="refundreasonform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label strong style="font-size: 16px;font-weight:bold;">Do you really want to refund invoice?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label strong style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control RefundReason" rows="3" name="RefundReason" id="RefundReason" onkeyup="refundReasonFn()"></textarea>
                        <span class="text-danger">
                            <strong id="refund-error"></strong>
                        </span>
                        <div class="form-group">
                            <input type="hidden" class="form-control refundid" name="refundidn" id="refundidn" readonly="true">
                            <input type="hidden" class="form-control vstatusref" name="vstatusref" id="vstatusref" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="refundbtn" type="button" class="btn btn-info">Refund</button>
                        <button id="closebuttonr" type="button" class="btn btn-danger" data-dismiss="modal" onclick="refundReasonFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Refund modal -->

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
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo void invoice?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                            <input type="hidden" class="form-control" name="ustatus" id="ustatus" readonly="true">
                            <input type="hidden" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
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

    <!--Start undo refund modal -->
    <div class="modal fade text-left" id="undorefundmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="undorefundform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo refund invoice?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undorefundid" id="undorefundid" readonly="true">
                            <input type="hidden" class="form-control" name="refstatus" id="refstatus" readonly="true">
                            <input type="hidden" class="form-control" name="oldrefstatus" id="oldrefstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="undorefundbtn" type="button" class="btn btn-info">Undo Refund</button>
                        <button id="closebuttonrj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo refund modal -->

    <!--Start Verify application modal -->
    <div class="modal fade text-left" id="applicationverifymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="verifyapplicationform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to verify invoice?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="checkedid" id="checkedid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="verifyappbtn" type="button" class="btn btn-info">Verify</button>
                        <button id="closebuttonf" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Verify application modal -->

    <!--Start send to device modal -->
    <div class="modal fade text-left" id="sendtodevicemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="sendtodeviceform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to send clients to device?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="sendappid" id="sendappid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="sendtodevbtn" type="button" class="btn btn-info">Send</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End send to device modal -->

    <!--Start freeze modal -->
    <div class="modal fade text-left" id="freezemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Freeze / Un-Freeze Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="freezeform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-6 col-sm-12">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 10%">
                                            <label style="font-size: 14px;">Client ID</label>
                                        </td>
                                        <td style="width: 90%">
                                            <label id="frmemberid" strong="" style="font-size:14px;font-weight:bold;"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="font-size: 14px;">Client Name</label>
                                        </td>
                                        <td>
                                            <label id="frmembername" strong="" style="font-size:14px;font-weight:bold;"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="font-size: 14px;">Client Phone</label>
                                        </td>
                                        <td>
                                            <label id="frmemberphone" strong="" style="font-size:14px;font-weight:bold;"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label style="font-size: 14px;">Loyalty Status</label>
                                        </td>
                                        <td>
                                            <label id="frloyaltystatus" strong="" style="font-size:14px;font-weight:bold;"></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">-</div>
                        </div> 
                        <div class="row">
                            <div class="col-xl-12 col-md-6 col-sm-12">
                                <table id="dynamicTabletr" class="mb-0 rtable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>FS/ Doc #, Inv/ Ref #</th>
                                            <th>Service</th>
                                            <th>Period</th>
                                            <th>Freeze Day #</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @can('Service-Freeze-UnFreeze')
                        <button id="savefreeze" type="button" class="btn btn-info">Save</button>
                        @endcan
                        <button id="closebuttoni" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End freeze modal -->

    {{-- info show modal --}}
    <div class="modal fade text-left" id="memberInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel334" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel334">Client & Service Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cleartenantinfovalue()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse2">
                                                        <span class="lead collapse-title">Client Basic, Address & Others Information</span>
                                                    </div>
                                                    <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-md-6 col-12" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Basic Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;" strong>ID</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="memberidslbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;" strong>Full Name</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="NameLbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr id="gendertr">
                                                                                            <td> <label style="font-size: 14px;" strong>Gender</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="GenderLbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr id="dobtr">
                                                                                            <td> <label style="font-size: 14px;" strong>DOB</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="DOBLbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr id="tintr">
                                                                                            <td> <label style="font-size: 14px;" strong>TIN</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="TinNumberLbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;" strong>Nationality</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="NationalityLbl" strong></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-md-6 col-12">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Emergency Contact</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;" strong>Name</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="emergencyconnamelbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;" strong>Phone</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="emergencyphonelbl" strong></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;" strong>Location</label></td>
                                                                                            <td><label style="font-size: 14px;font-weight:bold;" id="emergencyloclbl" strong></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Address & Other Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-xl-12 col-lg-12">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-12 col-lg-12">
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Country</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="CountryLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>City</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="CityLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Sub City</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="SubCityLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Woreda</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="WoredaLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Location</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="LocationLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Mobile Phone</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="PhoneLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Email</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="EmailLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Occupation</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="occLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;" strong>Passport #</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="PassportNoLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Residance ID</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="ResidanceIdLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Identification ID</label></td>
                                                                                                    <td><a style="text-decoration:underline;color:blue;" onclick="identificationidval()" id="IdentificationIdLbl"></a></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Health Status</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="healthstatuslbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Memo</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="memolbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Loyality Status</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="LoyalityStatusLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td> <label style="font-size: 14px;" strong>Client Status</label></td>
                                                                                                    <td><label style="font-size: 14px;font-weight:bold;" id="StatusLbl" strong></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="2">
                                                                                                        <div class="divider newext">
                                                                                                            <div class="divider-text">Action Information</div>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
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
                                                                <div class="col-lg-3 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Biometric Data</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-xl-12 col-lg-12 mb-2" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td style="width: 40%"><label strong style="font-size: 14px;">Enroll Device</label></td>
                                                                                            <td style="width: 60%"><label id="enrolldeviceinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-xl-12 col-lg-12">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td style="text-align: center;">
                                                                                                <label style="font-size: 14px;font-weight:bold;" class="form-label">Face ID</label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                                                                                    <img id="previewInfoImg" src="" alt="No picture uploaded" height="300" width="100%">
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-xl-12 col-lg-12 mt-2">
                                                                                    <table style="width: 100%;">
                                                                                        <tr>
                                                                                            <td colspan="5" style="text-align: center;">
                                                                                                <label style="font-size: 14px;font-weight:bold;" class="form-label"><u>Registered & Non-Registered Finger Print</u></label>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width:24;"><label style="font-size:12px;" class="form-label">Left Thumb</label></td>
                                                                                            <td style="width:24;"><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftthumblblinfo"></label></td>
                                                                                            <td style="width:4;"></td>
                                                                                            <td style="width:24;"><label style="font-size:12px;" class="form-label">Right Thumb</label></td>
                                                                                            <td style="width:24;"><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightthumblblinfo"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size:12px;" class="form-label">Left Index</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftindexlblinfo"></label></td>
                                                                                            <td></td>
                                                                                            <td><label style="font-size:12px;" class="form-label">Right Index</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightindexlblinfo"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size:12px;" class="form-label">Left Middle</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftmiddlelblinfo"></label></td>
                                                                                            <td></td>
                                                                                            <td><label style="font-size:12px;" class="form-label">Right Middle</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightmiddlelblinfo"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size:12px;" class="form-label">Left Ring</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftringlblinfo"></label></td>
                                                                                            <td></td>
                                                                                            <td><label style="font-size:12px;" class="form-label">Right Ring</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightringlblinfo"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size:12px;" class="form-label">Left Pinky</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftpinkylblinfo"></label></td>
                                                                                            <td></td>
                                                                                            <td><label style="font-size:12px;" class="form-label">Right Pinky</label></td>
                                                                                            <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightpinkylblinfo"></label></td>
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
                        </div>
                        <div class="divider" style="margin-top: -1rem">
                            <div class="divider-text">Clients service activity</div>
                        </div> 
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <table id="memberInfoTbl" class="display table-bordered table-striped table-hover dt-responsive">
                                        <thead>
                                            <th></th>
                                            <th>#</th>
                                            <th>FS/ Doc #, Inv/ Ref #</th>
                                            <th>Invoice Type</th>
                                            <th>Group Category</th>
                                            <th>Service Name</th>
                                            <th>POS</th>
                                            <th></th>
                                            <th></th>
                                            <th>Invoice Date</th>
                                            <th>Active Range</th>
                                            <th>Service Status</th>
                                            <th></th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" name="memberInfoId" id="memberInfoId" readonly="true" value=""/>
                    <input type="hidden" class="form-control" name="filenameInfo" id="filenameInfo" readonly="true" value=""/>
                    <button id="syncmemberbutton" type="button" onclick="synctodevicefn()" class="btn btn-info">Sync to Device</button>
                    <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of info show madal -->

    <!-- slide application info modal start-->
    <div class="modal modal-slide-in event-sidebar fade" id="applicationinfoslidemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog sidebar-xl" style="width: 90%;">
            <div class="modal-content p-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title">Application Detail Information</h5>
                </div>
                <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                    <div class="row">
                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                            <section id="collapsible">
                                <div class="card collapse-icon">
                                    <div class="collapse-default">
                                        <div class="card">
                                            <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapsesl" aria-expanded="false" aria-controls="collapse1">
                                                <span class="lead collapse-title">Basic, Invoice and Action Information</span>
                                                <div style="text-align: right;" id="statustitlessl"></div>
                                            </div>
                                            <div id="collapsesl" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infosl">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:none;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Basic Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table style="width: 100%">
                                                                        <tr style="display:none;">
                                                                            <td><label strong style="font-size: 14px;">ID</label></td>
                                                                            <td><label id="applicationidinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Type</label></td>
                                                                            <td><label id="applicationtypeinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Group</label></td>
                                                                            <td><label id="groupinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Payment Term</label></td>
                                                                            <td><label id="paymentterminfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Group Category</label></td>
                                                                            <td><label id="groupcategoryinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Start Date</label></td>
                                                                            <td><label id="registrationdateinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">End Date</label></td>
                                                                            <td><label id="expirydateinfolblsl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Invoice Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table style="width: 100%">
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Point of Sales</label></td>
                                                                            <td><label id="posinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Voucher Type</label></td>
                                                                            <td><label id="vouchertypinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">MRC #</label></td>
                                                                            <td><label id="mrcinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Payment Type</label></td>
                                                                            <td><label id="paymenttypeinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">FS/ Doc #</label></td>
                                                                            <td><label id="fsnumberinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Invoice/ Ref #</label></td>
                                                                            <td><label id="invoiceinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Invoice Date</label></td>
                                                                            <td><label id="invoicedateinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr id="baseappidtrsl">
                                                                            <td><label strong style="font-size: 14px;">Base Application FS/ Doc , Invoice/ Ref #</label></td>
                                                                            <td><label id="baseapplicationinfolblsl" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Memo</label></td>
                                                                            <td><label id="memoinfolblsl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Action Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table style="width: 100%">
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Prepared By</label></td>
                                                                            <td><label id="preparedbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Prepared Date</label></td>
                                                                            <td><label id="prepareddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Verified By</label></td>
                                                                            <td><label id="verifiedbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Verified Date</label></td>
                                                                            <td><label id="verifieddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Void By</label></td>
                                                                            <td><label id="voidbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Void Date</label></td>
                                                                            <td><label id="voiddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Void Reason</label></td>
                                                                            <td><label id="voidreasonlblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Undo Void By</label></td>
                                                                            <td><label id="undovoidbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Undo Void Date</label></td>
                                                                            <td><label id="undovoiddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title" style="color: white;">.</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table style="width: 100%">
                                                                        
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Refund By</label></td>
                                                                            <td><label id="refundbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Refund Date</label></td>
                                                                            <td><label id="refunddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Refund Reason</label></td>
                                                                            <td><label id="refundreasonlblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Undo Refund By</label></td>
                                                                            <td><label id="undorefundbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Undo Refund Date</label></td>
                                                                            <td><label id="undorefunddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Last Edited By</label></td>
                                                                            <td><label id="lasteditedbylblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Last Edited Date</label></td>
                                                                            <td><label id="lastediteddatelblinfosl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2">
                                                                                <div class="divider">
                                                                                    <div class="divider-text">-</div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 14px;">Application Document</label></td>
                                                                            <td><a style="text-decoration:underline;color:blue;" onclick="applicationDocumentsFn()" id="applicationsldocid"></a></td>
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
                    <div class="divider" style="margin-top: -2rem">
                        <div class="divider-text">Client and Service Information</div>
                    </div> 
                    <div class="row">
                        <div style="width:98%; margin-left:1%;" class="nlinksl">
                            <div class="table-responsive scroll scrdiv" style="display: none;">
                                <table id="memberandserviceinfosl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Phone</th>
                                            <th>Service Name</th>
                                            <th>Period</th>
                                            <th>Active Range</th>
                                            <th>Freeze Day</th>
                                            <th>Freezed By</th>
                                            <th>Freezed Date</th>
                                            <th>Un-Freezed By</th>
                                            <th>Un-Freezed Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        
                            <div class="table-responsive scroll scrdiv">
                                <table id="memberservicepricetblsl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Group Category</th>
                                            <th>No. of Group</th>
                                            <th>Payment Term</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Client Name</th>
                                            <th>Phone</th>
                                            <th>Service Name</th>
                                            <th>Period</th>
                                            <th>Device (Access Control)</th>
                                            <th>Loyalty Status</th>
                                            <th>Service Status</th>
                                            <th>Before Tax</th>
                                            <th>Tax</th>
                                            <th>Grand Total</th>
                                            <th>Discount (%)</th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot class="table table-sm">
                                        <tr>
                                            <td colspan="9" style="border-right-style: solid;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="5" style="border-right-style: solid;border-right-color:white;border-right-width: 1px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-top-style:solid;border-top-color:#ebe9f1;">
                                                <label style="font-size: 13px;font-weight: bold;color: black;">Sub Total</label>
                                            </td> 
                                            <td colspan="4" style="text-align: left;border-top-style:solid;border-top-color:#ebe9f1;">
                                                <label id="subtotalinfolblsl" style="font-size: 13px; font-weight: bold;color: black;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-right-style:solid;border-left-color:#ebe9f1;">
                                                <label style="font-size: 13px;font-weight: bold;color: black;">Tax</label>
                                            </td> 
                                            <td colspan="4" style="text-align: left;">
                                                <label id="taxinfolblsl" style="font-size: 13px; font-weight: bold;color: black;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-right-style:solid;border-right-color:#ebe9f1;">
                                                <label style="font-size: 13px;font-weight: bold;color: black;">Grand Total</label>
                                            </td> 
                                            <td colspan="4" style="text-align: left;">
                                                <label id="grandtotalinfolblsl" style="font-size: 13px; font-weight: bold;color: black;"></label>
                                            </td>
                                        </tr>
                                        <tr id="discounttrsl" style="display: none;">
                                            <td colspan="9" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-left-style:solid;border-left-color:#ebe9f1;">
                                                <label id="discountinfolblsl" style="font-size: 13px;font-weight: bold;color: #ea5455;">Discount</label>
                                            </td> 
                                            <td colspan="4" style="text-align: left;">
                                                <label id="discountlblinfosl" style="font-size: 13px; font-weight: bold;color:  #ea5455;"></label>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div style="width:98%; margin-left:1%;" class="trlinksl">
                            <div class="table-responsive scroll scrdiv">
                                <table id="membertrainerservicetblsl" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client Name</th>
                                            <th>Phone</th>
                                            <th>Service Name</th>
                                            <th>Period</th>
                                            <th>Active Range</th>
                                            <th>Trainer Name</th>
                                            <th>Before Tax</th>
                                            <th>Tax</th>
                                            <th>Grand Total</th>
                                            <th>Discount (%)</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot class="table table-sm">
                                        <tr>
                                            <td colspan="8" style="border-right-style: solid;border-right-color:white;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="4" style="border-right-style: solid;border-right-color:white;border-right-width: 1px;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-top-style:solid;border-top-color:#ebe9f1;">
                                                <label style="font-size: 13px;font-weight: bold;color: black;">Sub Total</label>
                                            </td> 
                                            <td colspan="3" style="text-align: left;border-top-style:solid;border-top-color:#ebe9f1;">
                                                <label id="subtotalinfolbltrsl" style="font-size: 13px; font-weight: bold;color: black;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-right-style:solid;border-left-color:#ebe9f1;">
                                                <label style="font-size: 13px;font-weight: bold;color: black;">Tax</label>
                                            </td> 
                                            <td colspan="3" style="text-align: left;">
                                                <label id="taxinfolbltrsl" style="font-size: 13px; font-weight: bold;color: black;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-right-style:solid;border-right-color:#ebe9f1;">
                                                <label style="font-size: 13px;font-weight: bold;color: black;">Grand Total</label>
                                            </td> 
                                            <td colspan="3" style="text-align: left;">
                                                <label id="grandtotalinfolbltrsl" style="font-size: 13px; font-weight: bold;color: black;"></label>
                                            </td>
                                        </tr>
                                        <tr id="discounttrnsl" style="display: none;">
                                            <td colspan="8" style="border-right-style: solid;border-right-color:#ebe9f1;border-left-color:white;border-top-color:white;border-bottom-color:white;border-right-width: 1px;"></td>
                                            <td colspan="1" style="text-align: right;border-left-style:solid;border-left-color:#ebe9f1;">
                                                <label id="discountinfolbltrsl" style="font-size: 13px;font-weight: bold;color: #ea5455;">Discount</label>
                                            </td> 
                                            <td colspan="3" style="text-align: left;">
                                                <label id="discountlblinfotrsl" style="font-size: 13px; font-weight: bold;color:  #ea5455;"></label>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control applicationinfoid" name="applicationinfoid" readonly="true">
                    <input type="hidden" class="form-control documentinfoval" name="documentinfoval" readonly="true">
                    <button id="closebuttonsl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- slide application info modal end-->

    <!--Start sync member modal -->
    <div class="modal fade text-left" id="syncmembermodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="syncmembermodaltitle">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="syncmemberform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want synchronize all active clients to device?</label>
                        <div class="form-group">
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="syncmemberbtn" type="button" class="btn btn-info">Sync</button>
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End sync member modal -->

    <!--Start sync to device modal -->
    <div class="modal fade text-left" id="synctodevicemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="synctodeviceform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to sync a client with active service to device?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="syncmemid" id="syncmemid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="synctodevicesbtn" type="button" class="btn btn-info">Sync</button>
                        <button id="closebuttonp" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End sync to device modal -->

{{-- @endsection

@section('scripts') --}}
    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var fyear = $('#fiscalyear').val();
        $('#service_status').val("Active").selectpicker('refresh');
        $(function () {
            cardSection = $('#page-block');
        });
        var j = 0;
        var i = 0;
        var m = 0;
        var a = 0;
        var b = 0;
        var c = 0;
        var e = 0;
        var f = 0;
        var g = 0;
        var q = 0;
        var r = 0;
        var s = 0;
        var latestprop = "";
        var table = "";
        var cdatevar = $('#currentdateval').val();

        function getApplicationListFn(fyear){
            var fiscal_year = "";
            $('#fiscalyear_div').hide();
            $('#app_dt').hide();
            table = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                deferRender: true,
                searchDelay: 800, // Reduce API calls while typing
                "lengthMenu": [50,100],
                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/applicationlist',
                    type: 'POST',
                    data:{
                        fiscal_year:fyear,
                    },
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
                },

                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'ApplicationType',
                        name: 'ApplicationType',
                        width:"8%"
                    },
                    {
                        data: 'Type',
                        name: 'Type',
                        width:"8%"
                    },
                    {
                        data: 'POS',
                        name: 'POS',
                        width:"8%"
                    },
                    {
                        data: 'VoucherType',
                        name: 'VoucherType',
                        width:"8%"
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        width:"8%"
                    },
                    {
                        data: 'InvoiceNumber',
                        name: 'InvoiceNumber',
                        width:"8%"
                    },
                    {
                        data: 'InvoiceDate',
                        name: 'InvoiceDate',
                        width:"8%"
                    },
                    {
                        data: 'Services',
                        name: 'Services',
                        width:"8%"
                    },
                    {
                        data: 'Members',
                        name: 'Members',
                        width:"13%"
                    },
                    {
                        data: 'Phone',
                        name: 'Phone',
                        width:"8%"
                    },
                    {
                        data: 'StatusVal',
                        name: 'StatusVal',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Verified"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Frozen"){
                                return `<span class="badge bg-info bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"8%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width:"4%"
                    }
                ],
                columnDefs:[{targets:[10,11],className:"truncate"}],
                createdRow: function(row){
                    $(row).find(".truncate").each(function(){
                        $(this).attr("title", this.innerText);
                    });
                },
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="syncmodalfn()" title="Synchronize each client to device"><i class="fas fa-sync-alt"></i></button>
                        @can('Invoice-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addappbutton">Add</button>
                        @endcan
                    `);
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
                    $('#fiscalyear_div').show();
                    $('#app_dt').show();
                },
            });
        }

        function getMembersListFn(){
            var service_status = "";
            var service_st = $('#service_status').val() != "" ? $('#service_status').val() : 0;
            $('#member_dt').hide();
            $('#service_st_div').hide();
            $('#laravel-datatable-crudmem').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "lengthMenu": [50,100],
                "order": [
                    [4, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/memberlist',
                    type: 'POST',
                    data:{
                        service_status:service_st,
                    },
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
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'Picture',
                        name: 'Picture',
                        "render": function( data, type, row, meta) {
                            if(data != null){
                                return `<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/MemberPicture/${data}" alt="-" width="80px" height="80px"></div>`;
                            } 
                            if(data == null){
                                if(row.Gender == "Male"){
                                    return '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/MemberPicture/dummymale.jpg" alt="-" width="80px" height="80px"></div>';
                                }
                                if(row.Gender == "Female"){
                                    return '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/MemberPicture/dummyfemale.jpg" alt="-" width="80px" height="80px"></div>';
                                }   
                            }
                        },
                        width:"5%"
                    },
                    {
                        data: 'MemberId',
                        name: 'MemberId',
                        width:"12%"
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                        width:"16%"
                    },
                    {
                        data: 'Gender',
                        name: 'Gender',
                        width:"12%"
                    },
                    {
                        data: 'DOB',
                        name: 'DOB',
                        "ordering": false,
                        width:"12%"
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone',
                        width:"12%"
                    },
                    {
                        data: 'LoyalityStatus',
                        name: 'LoyalityStatus',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Bronze"){
                                return `<span class="badge bg-glow" style="background-color:#cd7f32 !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Silver"){
                                return `<span class="badge bg-glow" style="background-color:#c0c0c0 !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Gold"){
                                return `<span class="badge bg-glow" style="background-color:#ffd700 !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Platinum"){
                                return `<span class="badge bg-glow" style="background-color:#e5e4e2 !important;color:#000000">${data}</span>`;
                            }
                            else if(data == "Sapphire"){
                                return `<span class="badge bg-glow" style="background-color:#0f52ba !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Diamond"){
                                return `<span class="badge bg-glow" style="background-color:#b9f2ff !important;color:#FFFFFF">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-glow" style="background-color:#000000 !important;color:#FFFFFF">${data}</span>`;
                            }
                        },
                        width:"12%"
                    },
                    {
                        data: 'ServiceStatus',
                        name: 'ServiceStatus',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Pending"){
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                            else if(data == "Frozen"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                        },
                        width:"12%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width:"4%"
                    }
                ],
                columnDefs:[{targets:[2],"width":"12%",orderable:false},{targets:[6],orderable:false}],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="syncmodalfn()" title="Synchronize each client to device"><i class="fas fa-sync-alt"></i></button>
                        @can('Invoice-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addappbutton">Add</button>
                        @endcan
                    `);
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
                    $('#member_dt').show(); 
                    $('#service_st_div').show();
                    $('#Members-tab').show();
                },
            });
        }

        $(document).ready(function() {
            $('#Dob').pickadate({
                format: 'yyyy-mm-dd',
                selectMonths: true,
                selectYears: 60,
                max: true
            });

            $('#Members-tab').hide();
            getApplicationListFn(fyear);
            getMembersListFn();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable
                    .tables({ visible: true, api: true })
                    .columns.adjust();
            });
        });

        $('#fiscalyear').on('change', function() {
            let fy = $(this).val();
            getApplicationListFn(fy);
        });

        $('#service_status').on('change', function() {
            getMembersListFn();
        });

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected'); 
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected'); 
            }
        });

        $('#laravel-datatable-crudmem tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('body').on('click', '.addappbutton', function() {
            $('#ApplicationType').empty();
            $('#PaymentTerm').empty();
            $('#Group').empty();
            $('#ApplicationType').append('<option selected value=""></option><option value="New">New</option></option><option value="Renew">Renew</option><option value="Trainer-Fee">Trainer-Fee</option>').select2();
            var groupopt = $("#groupcbx > option").clone();
            $('#Group').append(groupopt);
            $('#Group').select2
            ({
                placeholder: "Select Group here",
            });
            $('#PaymentTerm').select2
            ({
                placeholder: "Select Type first",
            });
            $('#Pos').select2
            ({
                placeholder: "Select POS here",
            });
            $('#VoucherType').select2
            ({
                placeholder: "Select Voucher Type here",
                minimumResultsForSearch: -1
            });
            $('#mrc').select2
            ({
                placeholder: "Select MRC here",
            });
            $('#PaymentType').select2
            ({
                placeholder: "Select Payment Type here",
                minimumResultsForSearch: -1
            });
            $('#ApplicationType').select2
            ({
                placeholder: "Select Type here",
                minimumResultsForSearch: -1
            });
            $('#ApplicationsId').select2
            ({
                placeholder: "Select FS/Invoice here",
                dropdownCssClass : 'appiddrp',
            });
            j=0;
            c=0;
            
            flatpickr('#RegistationDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
            flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
            $('#addsm').show();
            $('#addser').show();
            $('#addstr').hide();
            $('.newext').show();
            $('.trncls').hide();
            $('#mrcdiv').hide();
            $("#applicationdoclinkbtn").hide(); 
            $('#applicationiddiv').hide();
            $('#regdatediv').hide();
            $('#invnumdiv').show();
            $('#fsnumberlbl').html('FS/Doc No.');
            $('#applicationId').val("");
            $("#statusdisplay").html("");
            $('#operationtypes').val("1");
            $('#applicationCountVal').val("0");
            $("#apptitle").html("Add Fitness Form");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        //$('body').on('click', '.appfreeze', function() {
        function appfreeze(recordId){
            //var recordId = $(this).data('id');
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            var mobilephone="";
            var servstatus="";
            var defoptions="";
            var documentno="";
            var fsnum="";
            var refnum="";
            var numofservice=0;
            $("#dynamicTabletr > tbody").empty();
            f=0;
            $.ajax({
                type: "get",
                url: "{{ url('/showfreezeinfo') }}" + '/' + recordId,
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
                    numofservice=data.numofserv;
                    if(parseFloat(numofservice)==0){
                        toastrMessage('error',"This client does not have any active service","Error");
                    }
                    else if(parseFloat(numofservice)>=1){
                        $("#frmemberid").html(data.memid);
                        $("#frmembername").html(data.memname);
                        $("#frmemberphone").html(data.memphn);
                        $("#frloyaltystatus").html(data.lstatus);
                        $.each(data.freezedata, function(key, value) {
                            ++f;
                            mobilephone=value.Mobile+", "+value.Phone;
                            fsnum=value.VoucherNumber||"";
                            refnum=value.InvoiceNumber||"";
                            documentno=fsnum+", "+refnum;
                            $("#dynamicTabletr > tbody").append('<tr id="rowindtr'+f+'"><td style="font-weight:bold;width:3%;text-align:center;">'+f+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][valstr]" id="valstr'+f+'" class="valstr form-control" readonly="true" style="font-weight:bold;" value="'+f+'"/></td>'+
                                '<td style="width:11%;display:none;"><input type="text" name="rowtr['+f+'][MemberId]" placeholder="Client ID" id="MemberId'+f+'" value="'+value.MemberId+'" class="MemberId form-control" readonly/></td>'+
                                '<td style="width:25%;display:none;"><input type="text" name="rowtr['+f+'][MemberName]" placeholder="Member Name" id="MemberName'+f+'" value="'+value.MemberName+'" class="MemberName form-control" readonly/></td>'+
                                '<td style="width:20%;display:none;"><input type="text" name="rowtr['+f+'][Phone]" placeholder="Phone" id="Phone'+f+'" value="'+mobilephone+'" class="Phone form-control" readonly/></td>'+
                                '<td style="width:20%;"><input type="text" name="rowtr['+f+'][documentnum]" placeholder="FS/Doc #, Ref/Inv #" id="documentnum'+f+'" value="'+documentno+'" class="documentnum form-control" readonly/></td>'+
                                '<td style="width:20%;"><input type="text" name="rowtr['+f+'][ServiceName]" placeholder="Service Name" id="ServiceName'+f+'" value="'+value.ServiceName+'" class="ServiceName form-control" readonly/></td>'+
                                '<td style="width:20%;"><input type="text" name="rowtr['+f+'][Period]" placeholder="Period" id="Period'+f+'" value="'+value.PeriodName+'" class="Period form-control" readonly/></td>'+
                                '<td style="width:20%;"><input type="number" name="rowtr['+f+'][FreezeFor]" placeholder="Days" id="FreezeFor'+f+'" value="'+value.ExtendDays+'" class="FreezeFor form-control numeral-mask" onkeyup="freezeFn(this)" onkeypress="return ValidateNum(event);" readonly style="font-weight:bold;"/></td>'+
                                '<td style="width:17%;"><select id="Status'+f+'" class="select2 form-control form-control Status" onchange="statusFn(this)" name="rowtr['+f+'][Status]"></select></td>'+
                                '<td style="display:none;"><input type="text" name="rowtr['+f+'][StatusFlag]" placeholder="StatusFlag" id="StatusFlag'+f+'" value="0" class="StatusFlag form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][frozenId]" id="frozenId'+f+'" value="'+value.appConsId+'" class="frozenId form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][regDate]" id="regDate'+f+'" value="'+value.RegistrationDate+'" class="regDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][expDate]" id="expDate'+f+'" value="'+value.ExpiryDate+'" class="expDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][mainregDate]" id="mainregDate'+f+'" value="'+value.MainRegDate+'" class="mainregDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][mainexpDate]" id="mainexpDate'+f+'" value="'+value.MainExpDate+'" class="mainexpDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][remainingDate]" id="remainingDate'+f+'" value="'+value.RemainingDay+'" class="remainingDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][freezeby]" id="freezeby'+f+'" value="'+value.FreezedBy+'" class="freezeby form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][freezedate]" id="freezedate'+f+'" value="'+value.FreezedDate+'" class="freezedate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][unfreezeby]" id="unfreezeby'+f+'" value="'+value.UnFreezedBy+'" class="unfreezeby form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][unfreezedate]" id="unfreezedate'+f+'" value="'+value.UnFreezedDate+'" class="unfreezedate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][membershipid]" id="membershipid'+f+'" value="'+value.memberships_id+'" class="membershipid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][serviceid]" id="serviceid'+f+'" value="'+value.services_id+'" class="serviceid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][periodid]" id="periodid'+f+'" value="'+value.periods_id+'" class="periodid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][applicationIdVar]" id="applicationIdVar'+f+'" value="'+value.appidval+'" class="applicationIdVar form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="rowtr['+f+'][HiddenStatus]" placeholder="HiddenStatus" id="HiddenStatus'+f+'" value="'+value.ConsStatus+'" class="HiddenStatus form-control" readonly/></td></tr>'
                            );
                            if(value.AppStatus=="Frozen"){
                                defoptions='<option selected value="Frozen">Freeze</option><option value="Active">Un-Freeze</option>';
                                $("#FreezeFor"+f).prop("readonly",false);
                                $("#StatusFlag"+f).val("1");
                            }
                            else if(value.AppStatus=="Active"||value.AppStatus=="Pending"){
                                defoptions='<option selected value=""></option><option value="0">-</option><option value="Frozen">Freeze</option>';
                                $("#FreezeFor"+f).prop("readonly",true);
                                $("#StatusFlag"+f).val("0");
                            } 
                            $('#Status'+f).append(defoptions);
                            $('#Status'+f).select2
                            ({
                                placeholder: "Select Status here",
                                minimumResultsForSearch: -1
                            });
                        });
                        $('#savefreeze').text('Save');
                        $('#savefreeze').prop("disabled",false);
                        $("#freezemodal").modal('show');
                    }
                },
            });
        }

        //$('body').on('click', '.appVoid', function() {
        function appVoid(recordId){
            //var recordId = $(this).data('id');
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            var memcnt=0;
            $('.Reason').val("");
            $('#void-error').html("");
            $("#voididn").val(recordId);
            $.get("/showvoidinfo" + '/' + recordId, function(data) {
                cnt=data.count;
                memcnt=data.memcnts;
                $.each(data.appdataval, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if(parseFloat(cnt)>=1 || parseFloat(memcnt)>=1){
                    if(parseFloat(cnt)>=1){
                        toastrMessage('error',"Unable to void invoice, because Renew or Trainer-Fee invoice has been made based on this invoice","Error");
                    }
                    if(parseFloat(memcnt)>=1){
                        toastrMessage('error',"Due to the client's subsequent transaction, the invoice cannot be voided","Error");
                    }  
                }
                else if(parseFloat(cnt)==0 && parseFloat(memcnt)==0){
                    if(statusvals=="Pending"||statusvals=="Verified"){
                        $('#vstatus').val(settstatus);
                        $('#voidbtn').prop("disabled", false);
                        $('#voidbtn').text("Void");
                        $("#voidreasonmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"You cant void invoice on "+statusvals+" status","Error");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        function appRefund(recordId){
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            var memcnt=0;
            $('.RefundReason').val("");
            $('#refund-error').html("");
            $("#refundidn").val(recordId);
            $.get("/showvoidinfo" + '/' + recordId, function(data) {
                cnt=data.count;
                memcnt=data.memcnts;
                $.each(data.appdataval, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if(parseFloat(cnt)>=1 || parseFloat(memcnt)>=1){
                    if(parseFloat(cnt)>=1){
                        toastrMessage('error',"Unable to refund invoice, because Renew or Trainer-Fee invoice has been made based on this invoice","Error");
                    }
                    if(parseFloat(memcnt)>=1){
                        toastrMessage('error',"Due to the client's subsequent transaction, the invoice cannot be refunded","Error");
                    }  
                }
                else if(parseFloat(cnt)==0 && parseFloat(memcnt)==0){
                    if(statusvals=="Pending"||statusvals=="Verified"){
                        $('#vstatusref').val(settstatus);
                        $('#refundbtn').prop("disabled", false);
                        $('#refundbtn').text("Refund");
                        $("#refundreasonmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"You cant refund invoice on "+statusvals+" status","Error");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        }

        function appUndoVoid(recordId){
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            var memcnt=0;
            var grpinv=0;
            var renewapp=0;
            $("#undovoidid").val(recordId);
            $.get("/showundovoidinfo" + '/' + recordId, function(data) {
                memcnt=data.memcnts;
                grpinv=data.grpinv;
                renewapp=data.renewmemerr;
                $.each(data.appundodata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;  
                });
                if(parseFloat(memcnt)>=1){
                    toastrMessage('error',"You cant undo void invoice, because the client have other transactions","Error");
                }
                else if(parseFloat(grpinv)>=1){
                    toastrMessage('error',"You cant undo void invoice, because the client have been in other group","Error");
                }
                else if(parseFloat(renewapp)>=1){
                    toastrMessage('error',"This record cannot be saved because the member has new transactions before please change invoice type to Renew.","Error");
                }
                else if(parseFloat(memcnt)==0 && parseFloat(grpinv)==0){
                    if(statusvals=="Void"){
                        toastrMessage('error',"You cant undo void invoice, because base invoice is voided","Error");
                        var oTable = $('#laravel-datatable-crudsett').dataTable();
                        oTable.fnDraw(false);
                    }
                    else{
                        $('#vstatus').val(settstatus);
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    }
                }
            });
        }

        function appUndoRefund(recordId){
            var settstatus=0;
            var statusvals="";
            var cnt=0;
            var memcnt=0;
            var grpinv=0;
            $("#undorefundid").val(recordId);
            $.get("/showundovoidinfo" + '/' + recordId, function(data) {
                memcnt=data.memcnts;
                grpinv=data.grpinv;
                renewapp=data.renewmemerr;
                $.each(data.appundodata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;  
                });

                if(parseFloat(memcnt)>=1){
                    toastrMessage('error',"You cant undo refund invoice, because the client have other transactions","Error");
                }
                else if(parseFloat(grpinv)>=1){
                    toastrMessage('error',"You cant undo refund invoice, because the client have been in other group","Error");
                }
                else if(parseFloat(renewapp)>=1){
                    toastrMessage('error',"This record cannot be saved because the member has new transactions before please change invoice type to Renew.","Error");
                }
                else if(parseFloat(memcnt)==0 && parseFloat(grpinv)==0){
                    if(statusvals=="Refund"){
                        toastrMessage('error',"You cant undo refund invoice, because base invoice is refunded","Error");
                        var oTable = $('#laravel-datatable-crudsett').dataTable();
                        oTable.fnDraw(false);
                    }
                    else{
                        $('#vstatus').val(settstatus);
                        $('#undorefundbtn').prop("disabled", false);
                        $('#undorefundbtn').text("Undo Refund");
                        $("#undorefundmodal").modal('show');
                    }
                }
            });
        }

        function appLnFn(recordId){
            $.get("/showappedit"+'/'+recordId , function(data) {
                $('#baseapplicationinfolblsl').html(data.baseappidval);
                $.each(data.appdata, function(key, value) {
                    $("#statusid").val(value.id);
                    $('#applicationidinfolblsl').html(value.ApplicationNumber);
                    $('#applicationtypeinfolblsl').html(value.ApplicationType);
                    $('#groupinfolblsl').html(value.GroupName);
                    $('#groupcategoryinfolblsl').html(value.Type);
                    $('#paymentterminfolblsl').html(value.PaymentTermName);
                    $('#registrationdateinfolblsl').html(value.RegistrationDate);
                    $('#expirydateinfolblsl').html(value.ExpiryDate);
                    $('#posinfolblsl').html(value.POS);
                    $('#vouchertypinfolblsl').html(value.VoucherType);
                    $('#mrcinfolblsl').html(value.Mrc);
                    $('#paymenttypeinfolblsl').html(value.PaymentType);
                    $('#fsnumberinfolblsl').html(value.VoucherNumber);
                    $('#invoiceinfolblsl').html(value.InvoiceNumber);
                    $('#invoicedateinfolblsl').html(value.InvoiceDate);
                    $('#memoinfolblsl').html(value.Memo);
                    $('#preparedbylblinfosl').html(value.PreparedBy);
                    $('#prepareddatelblinfosl').html(value.PreparedDate);
                    $('#verifiedbylblinfosl').html(value.VerifiedBy);
                    $('#verifieddatelblinfosl').html(value.VerifiedDate);
                    $('#voidbylblinfosl').html(value.VoidBy);
                    $('#voiddatelblinfosl').html(value.VoidDate);
                    $('#voidreasonlblinfosl').html(value.VoidReason);
                    $('#undovoidbylblinfosl').html(value.UndoVoidBy);
                    $('#undovoiddatelblinfosl').html(value.UndoVoidDate);
                    $('#lasteditedbylblinfosl').html(value.LastEditedBy);
                    $('#lastediteddatelblinfosl').html(value.LastEditedDate);
                    $('#refundbylblinfosl').html(value.RefundBy);
                    $('#refunddatelblinfosl').html(value.RefundDate);
                    $('#refundreasonlblinfosl').html(value.RefundReason);
                    $('#undorefundbylblinfosl').html(value.UndoRefundBy);
                    $('#undorefunddatelblinfosl').html(value.UndoRefundDate);
                    $('#applicationsldocid').text(value.DocumentOriginalName);
                    $(".applicationinfoid").val(value.id);
                    $(".documentinfoval").val(value.DocumentUploadPath);

                    if(value.Status=="Pending"){
                        $("#statustitlessl").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else if(value.Status=="Verified"){
                        $("#statustitlessl").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else if(value.Status=="Frozen"){
                        $("#statustitlessl").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else if(value.Status=="Expired"){
                        $("#statustitlessl").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else{
                        $("#statustitlessl").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+value.Status+"("+value.OldStatus+")</span>");
                    }
                    if(parseFloat(value.RenewParentId)>=1){
                        $("#baseappidtrsl").show();
                    }
                    else if(parseFloat(value.RenewParentId)==0){
                        $("#baseappidtrsl").hide();
                    }
                    if(value.ApplicationType=="New"||value.ApplicationType=="Renew"){
                        $(".nlinksl").show();
                        $(".trlinksl").hide();
                    }
                    else if(value.ApplicationType=="Trainer-Fee"){
                        $(".nlinksl").hide();
                        $(".trlinksl").show();
                    }
                });
            });

            $('#memberandserviceinfosl').DataTable({
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
                    url: '/showmemservdata/' + recordId,
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
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'MemberId',
                        name: 'MemberId',
                        'visible': false
                    },
                    {
                        data: 'MemberName',
                        name: 'MemberName'
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'PeriodName',
                        name: 'PeriodName'
                    },
                    {
                        data: 'ActiveRange',
                        name: 'ActiveRange'
                    },
                    {
                        data: 'FreezeDayVal',
                        name: 'FreezeDayVal'
                    },
                    {
                        data: 'FreezedBy',
                        name: 'FreezedBy'
                    },
                    {
                        data: 'FreezedDate',
                        name: 'FreezedDate',
                    },
                    {
                        data: 'UnFreezedBy',
                        name: 'UnFreezedBy',
                    }, 
                    {
                        data: 'UnFreezedDate',
                        name: 'UnFreezedDate',
                    }, 
                    {
                        data: 'Status',
                        name: 'Status',
                    }, 
                ],
                
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Pending") {
                        $(nRow).find('td:eq(11)').css({"color": "#f6c23e","font-weight": "bold"}); 
                    } 
                    else if (aData.Status == "Frozen") {
                        $(nRow).find('td:eq(11)').css({"color": "#4e73df","font-weight": "bold"}); 
                    } 
                    else if (aData.Status == "Active") {
                        $(nRow).find('td:eq(11)').css({"color": "#1cc88a","font-weight": "bold"});
                    }
                    else if (aData.Status == "Void") {
                        $(nRow).find('td:eq(11)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                    else if (aData.Status == "Expired") {
                        $(nRow).find('td:eq(11)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                    else{
                        $(nRow).find('td:eq(11)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                }
            });

            $('#memberservicepricetblsl').DataTable({
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
                    url: '/showmemprice/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'ApplicationType',
                        name: 'ApplicationType'
                    },
                    {
                        data: 'Type',
                        name: 'Type'
                    },
                    {
                        data: 'GroupName',
                        name: 'GroupName'
                    },
                    {
                        data: 'PaymentTermName',
                        name: 'PaymentTermName'
                    },
                    {
                        data: 'RegistrationDate',
                        name: 'RegistrationDate'
                    },
                    {
                        data: 'ExpiryDate',
                        name: 'ExpiryDate'
                    },
                    {
                        data: 'MemberName',
                        name: 'MemberName'
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'PeriodName',
                        name: 'PeriodName'
                    },
                    {
                        data: 'DeviceName',
                        name: 'DeviceName'
                    },
                    {
                        data: 'LoyalityStatus',
                        name: 'LoyalityStatus'
                    },
                    {
                        data: 'ServiceStatus',
                        name: 'ServiceStatus'
                    },
                    {
                        data: 'BeforeTotal',
                        name: 'BeforeTotal',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'Tax',
                        name: 'Tax',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'TotalAmount',
                        name: 'TotalAmount',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'DiscountServicePercent',
                        name: 'DiscountServicePercent',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'DiscountServiceAmount',
                        name: 'DiscountServiceAmount',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        'visible': false
                    },   
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.LoyalityStatus == "Bronze") {
                        $(nRow).find('td:eq(12)').css({"color": "#CD7F32", "font-weight": "bold"});
                    } 
                    if (aData.LoyalityStatus == "Silver") {
                        $(nRow).find('td:eq(12)').css({"color": "#808080", "font-weight": "bold"});
                    } 
                    if (aData.LoyalityStatus == "Gold") {
                        $(nRow).find('td:eq(12)').css({"color": "#FFD700", "font-weight": "bold"});
                    } 
                    if (aData.LoyalityStatus == "Platinum") {
                        $(nRow).find('td:eq(12)').css({"color": "#e2e2e2", "font-weight": "bold"});
                    } 
                    if (aData.ServiceStatus == "Pending") {
                        $(nRow).find('td:eq(13)').css({"color": "#f6c23e", "font-weight": "bold"});
                    } 
                    if (aData.ServiceStatus == "Active") {
                        $(nRow).find('td:eq(13)').css({"color": "#1cc88a", "font-weight": "bold"});
                    } 
                    if (aData.ServiceStatus == "Frozen") {
                        $(nRow).find('td:eq(13)').css({"color": "#4e73df", "font-weight": "bold"});
                    }
                    if (aData.ServiceStatus != "Frozen" && aData.ServiceStatus != "Active" && aData.ServiceStatus != "Pending") {
                        $(nRow).find('td:eq(13)').css({"color": "#e74a3b", "font-weight": "bold"});
                    }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var columnData = api
                    .column(14)
                    .data();

                    var subtotal = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var tax = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var grandtotal = api
                    .column(16)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discount = api
                    .column(17)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discountamount = api
                    .column(18)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    $('#subtotalinfolblsl').text(numformat(subtotal/columnData.count().toFixed(2)));
                    $('#taxinfolblsl').text(numformat(tax/columnData.count().toFixed(2)));
                    $('#grandtotalinfolblsl').text(numformat(grandtotal/columnData.count().toFixed(2)));
                    if(parseFloat(discount)>=1){
                        $('#discounttrsl').show();
                        $('#discountinfolblsl').text("Discount ("+discount/columnData.count()+" %)");
                        $('#discountlblinfosl').text(numformat(discountamount/columnData.count().toFixed(2)));
                    }
                    else if(parseFloat(discount)<=0){
                        $('#discounttrsl').hide();
                    }
                },   
            });

            $('#membertrainerservicetblsl').DataTable({
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
                    url: '/showmempricetr/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'Phone',
                        name: 'Phone'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'PeriodName',
                        name: 'PeriodName'
                    },
                    {
                        data: 'ActiveRange',
                        name: 'ActiveRange'
                    },
                    {
                        data: 'TrainerName',
                        name: 'TrainerName'
                    },
                    {
                        data: 'BeforeTotal',
                        name: 'BeforeTotal',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'Tax',
                        name: 'Tax',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'TotalAmount',
                        name: 'TotalAmount',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'DiscountServicePercent',
                        name: 'DiscountServicePercent',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'DiscountServiceAmount',
                        name: 'DiscountServiceAmount',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        'visible': false
                    }, 
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var subtotal = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var tax = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var grandtotal = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discount = api
                    .column( 10 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discountamount = api
                    .column( 11 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    $('#subtotalinfolbltrsl').text(numformat(subtotal.toFixed(2)));
                    $('#taxinfolbltrsl').text(numformat(tax.toFixed(2)));
                    $('#grandtotalinfolbltrsl').text(numformat(grandtotal.toFixed(2)));
                    if(parseFloat(discount)>=1){
                        $('#discounttrnsl').show();
                        $('#discountinfolbltrsl').text("Discount ("+discount+" %)");
                        $('#discountlblinfotrsl').text(numformat(discountamount.toFixed(2)));
                    }
                    else if(parseFloat(discount)<=0){
                        $('#discounttrnsl').hide();
                    }
                },   
            });
            $(".nlinksl").removeClass("active");
            $(".tpanesl").removeClass("active");
            $(".trlinksl").removeClass("active");
            $(".ttrpanesl").removeClass("active");
            $(".infosl").collapse('show');
            $(".infosldt").collapse('show');
            $("#applicationinfoslidemodal").modal('show');
        }

        //$(document).on('click', '.appInfo', function() {
        function appInfo(recordId){
            //var recordId = $(this).data('id');
            $.get("/showappedit"+'/'+recordId , function(data) {
                $('#baseapplicationinfolbl').html(data.baseappidval);
                $.each(data.appdata, function(key, value) {
                    $("#statusid").val(value.id);
                    $('#applicationidinfolbl').html(value.ApplicationNumber);
                    $('#applicationtypeinfolbl').html(value.ApplicationType);
                    $('#groupinfolbl').html(value.GroupName);
                    $('#groupcategoryinfolbl').html(value.Type);
                    $('#paymentterminfolbl').html(value.PaymentTermName);
                    $('#registrationdateinfolbl').html(value.RegistrationDate);
                    $('#expirydateinfolbl').html(value.ExpiryDate);
                    $('#posinfolbl').html(value.POS);
                    $('#vouchertypinfolbl').html(value.VoucherType);
                    $('#mrcinfolbl').html(value.Mrc);
                    $('#paymenttypeinfolbl').html(value.PaymentType);
                    $('#fsnumberinfolbl').html(value.VoucherNumber);
                    $('#invoiceinfolbl').html(value.InvoiceNumber);
                    $('#invoicedateinfolbl').html(value.InvoiceDate);
                    $('#memoinfolbl').html(value.Memo);
                    $('#preparedbylblinfo').html(value.PreparedBy);
                    $('#prepareddatelblinfo').html(value.CreatedDateTime);
                    $('#verifiedbylblinfo').html(value.VerifiedBy);
                    $('#verifieddatelblinfo').html(value.VerifiedDate);
                    $('#voidbylblinfo').html(value.VoidBy);
                    $('#voiddatelblinfo').html(value.VoidDate);
                    $('#voidreasonlblinfo').html(value.VoidReason);
                    $('#undovoidbylblinfo').html(value.UndoVoidBy);
                    $('#undovoiddatelblinfo').html(value.UndoVoidDate);
                    $('#lasteditedbylblinfo').html(value.LastEditedBy);
                    $('#lastediteddatelblinfo').html(value.LastEditedDate);
                    $('#applicationdocid').text(value.DocumentOriginalName);
                    $('#refundbylblinfo').html(value.RefundBy);
                    $('#refunddatelblinfo').html(value.RefundDate);
                    $('#refundreasonlblinfo').html(value.RefundReason);
                    $('#undorefundbylblinfo').html(value.UndoRefundBy);
                    $('#undorefunddatelblinfo').html(value.UndoRefundDate);
                    $('#subtotalinfolbl').html(numformat(value.SubTotal));
                    $('#taxinfolbl').html(numformat(value.TotalTax));
                    $('#grandtotalinfolbl').html(numformat(value.GrandTotal));
                    var discount=value.DiscountPercent;
                    if(parseFloat(discount)>=1){
                        $('#discounttr').show();
                        $('#discountinfolbl').html("Discount ("+value.DiscountPercent+" %)");
                        $('#discountlblinfo').html(numformat(value.DiscountAmount.toFixed(2)));
                    }
                    else if(parseFloat(discount)<=0){
                        $('#discounttr').hide();
                    }

                    $(".applicationinfoid").val(value.id);
                    $(".documentinfoval").val(value.DocumentUploadPath);

                    if(value.Status=="Pending"){
                        $("#verifyapplicationbtn").show();
                        $("#sendtodevicebtn").show();
                        $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else if(value.Status=="Verified"){
                        $("#verifyapplicationbtn").hide();
                        $("#sendtodevicebtn").hide();
                        $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else if(value.Status=="Frozen"){
                        $("#verifyapplicationbtn").hide();
                        $("#sendtodevicebtn").hide();
                        $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else if(value.Status=="Expired"){
                        $("#verifyapplicationbtn").hide();
                        $("#sendtodevicebtn").hide();
                        $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+value.Status+"</span>");
                    }
                    else{
                        $("#verifyapplicationbtn").hide();
                        $("#sendtodevicebtn").hide();
                        $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+value.Status+"("+value.OldStatus+")</span>");
                    }
                    if(parseFloat(value.RenewParentId)>=1){
                        $("#baseappidtr").show();
                    }
                    else if(parseFloat(value.RenewParentId)==0){
                        $("#baseappidtr").hide();
                    }
                    if(value.ApplicationType=="New"||value.ApplicationType=="Renew"){
                        $(".nlink").show();
                        $(".trlink").hide();
                    }
                    else if(value.ApplicationType=="Trainer-Fee"){
                        $(".nlink").hide();
                        $(".trlink").show();
                    }
                });
            });

            $('#memberandserviceinfo').DataTable({
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
                    url: '/showmemservdata/' + recordId,
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
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'MemberId',
                        name: 'MemberId',
                        'visible': false
                    },
                    {
                        data: 'MemberName',
                        name: 'MemberName'
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'PeriodName',
                        name: 'PeriodName'
                    },
                    {
                        data: 'ActiveRange',
                        name: 'ActiveRange'
                    },
                    {
                        data: 'FreezeDayVal',
                        name: 'FreezeDayVal',
                        'visible': false
                    },
                    {
                        data: 'FreezedBy',
                        name: 'FreezedBy',
                        'visible': false
                    },
                    {
                        data: 'FreezedDate',
                        name: 'FreezedDate',
                        'visible': false
                    },
                    {
                        data: 'UnFreezedBy',
                        name: 'UnFreezedBy',
                        'visible': false
                    }, 
                    {
                        data: 'UnFreezedDate',
                        name: 'UnFreezedDate',
                        'visible': false
                    }, 
                    {
                        data: 'Status',
                        name: 'Status',
                    }, 
                ],
                
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Pending") {
                        $(nRow).find('td:eq(6)').css({"color": "#f6c23e","font-weight": "bold"}); 
                    } 
                    else if (aData.Status == "Frozen") {
                        $(nRow).find('td:eq(6)').css({"color": "#4e73df","font-weight": "bold"}); 
                    } 
                    else if (aData.Status == "Active") {
                        $(nRow).find('td:eq(6)').css({"color": "#1cc88a","font-weight": "bold"});
                    }
                    else if (aData.Status == "Void") {
                        $(nRow).find('td:eq(6)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                    else if (aData.Status == "Expired") {
                        $(nRow).find('td:eq(6)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                    else{
                        $(nRow).find('td:eq(6)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                }
            });

            $('#memberservicepricetbl').DataTable({
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
                    url: '/showmemprice/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'ApplicationType',
                        name: 'ApplicationType'
                    },
                    {
                        data: 'Type',
                        name: 'Type'
                    },
                    {
                        data: 'GroupName',
                        name: 'GroupName'
                    },
                    {
                        data: 'PaymentTermName',
                        name: 'PaymentTermName'
                    },
                    {
                        data: 'RegistrationDate',
                        name: 'RegistrationDate'
                    },
                    {
                        data: 'ExpiryDate',
                        name: 'ExpiryDate'
                    },
                    {
                        data: 'MemberName',
                        name: 'MemberName'
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'PeriodName',
                        name: 'PeriodName'
                    },
                    {
                        data: 'DeviceName',
                        name: 'DeviceName'
                    },
                    {
                        data: 'BeforeTotal',
                        name: 'BeforeTotal',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'Tax',
                        name: 'Tax',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'TotalAmount',
                        name: 'TotalAmount',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'DiscountServicePercent',
                        name: 'DiscountServicePercent',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        'visible': false
                    },
                    {
                        data: 'DiscountServiceAmount',
                        name: 'DiscountServiceAmount',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        'visible': false
                    }, 
                    {
                        data: 'LoyalityStatus',
                        name: 'LoyalityStatus'
                    },
                    {
                        data: 'ServiceStatus',
                        name: 'ServiceStatus'
                    },
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.LoyalityStatus == "Bronze") {
                        $(nRow).find('td:eq(12)').css({"color": "#CD7F32", "font-weight": "bold"});
                    } 
                    if (aData.LoyalityStatus == "Silver") {
                        $(nRow).find('td:eq(12)').css({"color": "#808080", "font-weight": "bold"});
                    } 
                    if (aData.LoyalityStatus == "Gold") {
                        $(nRow).find('td:eq(12)').css({"color": "#FFD700", "font-weight": "bold"});
                    } 
                    if (aData.LoyalityStatus == "Platinum") {
                        $(nRow).find('td:eq(12)').css({"color": "#e2e2e2", "font-weight": "bold"});
                    } 
                    if (aData.ServiceStatus == "Pending") {
                        $(nRow).find('td:eq(13)').css({"color": "#f6c23e", "font-weight": "bold"});
                    } 
                    if (aData.ServiceStatus == "Active" ||aData.ServiceStatus == "To-Be-Active") {
                        $(nRow).find('td:eq(13)').css({"color": "#1cc88a", "font-weight": "bold"});
                    } 
                    if (aData.ServiceStatus == "Frozen") {
                        $(nRow).find('td:eq(13)').css({"color": "#4e73df", "font-weight": "bold"});
                    }
                    if (aData.ServiceStatus != "Frozen" && aData.ServiceStatus != "Active" && aData.ServiceStatus != "To-Be-Active" && aData.ServiceStatus != "Pending") {
                        $(nRow).find('td:eq(13)').css({"color": "#e74a3b", "font-weight": "bold"});
                    }
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var columnData = api
                    .column( 11 )
                    .data();

                    var subtotal = api
                    .column( 11 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var tax = api
                    .column( 12 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var grandtotal = api
                    .column( 13 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discount = api
                    .column( 14 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discountamount = api
                    .column( 15 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                },   
            });

            $('#membertrainerservicetbl').DataTable({
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
                    url: '/showmempricetr/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'Phone',
                        name: 'Phone'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'PeriodName',
                        name: 'PeriodName'
                    },
                    {
                        data: 'ActiveRange',
                        name: 'ActiveRange'
                    },
                    {
                        data: 'TrainerName',
                        name: 'TrainerName'
                    },
                    {
                        data: 'BeforeTotal',
                        name: 'BeforeTotal',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'Tax',
                        name: 'Tax',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'TotalAmount',
                        name: 'TotalAmount',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'DiscountServicePercent',
                        name: 'DiscountServicePercent',
                        render: $.fn.dataTable.render.number(',', '.',2, '')
                    },
                    {
                        data: 'DiscountServiceAmount',
                        name: 'DiscountServiceAmount',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        'visible': false
                    }, 
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var subtotal = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var tax = api
                    .column( 8 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var grandtotal = api
                    .column( 9 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discount = api
                    .column( 10 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    var discountamount = api
                    .column( 11 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    $('#subtotalinfolbltr').text(numformat(subtotal.toFixed(2)));
                    $('#taxinfolbltr').text(numformat(tax.toFixed(2)));
                    $('#grandtotalinfolbltr').text(numformat(grandtotal.toFixed(2)));
                    if(parseFloat(discount)>=1){
                        $('#discounttrn').show();
                        $('#discountinfolbltr').text("Discount ("+discount+" %)");
                        $('#discountlblinfotr').text(numformat(discountamount.toFixed(2)));
                    }
                    else if(parseFloat(discount)<=0){
                        $('#discounttrn').hide();
                    }
                },   
            });

            $(".nlink").removeClass("active");
            $(".tpane").removeClass("active");
            $(".trlink").removeClass("active");
            $(".ttrpane").removeClass("active");
            $(".infodocrec").collapse('show');
            $("#applicationinfomodal").modal('show');
        }

        //$('body').on('click', '.appMemberInfo', function() {
        function appMemberInfo(recordId){
            //var recordId = $(this).data('id');
            $.get("/showmember"+'/'+recordId , function(data) {
                $.each(data.memlist, function(key, value) {
                    $('#memberInfoId').val(value.id);
                    $('#NameLbl').html(value.Name);
                    $('#GenderLbl').html(value.Gender);
                    $('#DOBLbl').html(value.DOB);
                    $('#TinNumberLbl').html(value.TinNumber);
                    $('#NationalityLbl').html(value.Nationality);
                    $('#CountryLbl').html(value.Country);
                    $('#CityLbl').html(value.city_name);
                    $('#SubCityLbl').html(value.subcity_name);
                    $('#WoredaLbl').html(value.Woreda);
                    $('#LocationLbl').html(value.Location);
                    $('#PhoneLbl').html(value.MobileNo+"  ,   "+value.PhoneNo);
                    $('#EmailLbl').html(value.Email);
                    $('#occLbl').html(value.Occupation);
                    $('#healthstatuslbl').html(value.HealthStatus);
                    $('#memolbl').html(value.Memo);
                    $('#memberidslbl').html(value.MemberId);
                    $('#ResidanceIdLbl').html(value.ResidanceId);
                    $('#PassportNoLbl').html(value.PassportNo);
                    $('#IdentificationIdLbl').text(value.IdentificationId);
                    $('#filenameInfo').val(value.IdentificationId);
                    $('#emergencyconnamelbl').html(value.EmergencyName);
                    $('#emergencyphonelbl').html(value.EmergencyMobile);
                    $('#emergencyloclbl').html(value.EmergencyLocation);
                    $("#createdbylbl").html(value.CreatedBy);
                    $("#createddatelbl").html(value.CreatedTime);
                    $("#lasteditedbylbl").html(value.LastEditedBy);
                    $("#lastediteddatelbl").html(value.LastEditedDate);
                    $("#enrolldeviceinfo").html(value.DeviceName);
                    
                    var leftthumb=value.LeftThumb;
                    var leftind=value.LeftIndex;
                    var leftmiddle=value.LeftMiddle;
                    var leftring=value.LeftRing;
                    var leftpicky=value.LeftPinky;
                    var rightthumb=value.RightThumb;
                    var rightind=value.RightIndex;
                    var rightmiddle=value.RightMiddle;
                    var rightring=value.RightRing;
                    var rightpicky=value.RightPinky;

                    var st=value.Status;
                    var loyaltyst=value.LoyalityStatus;
                    if(st=="Active"){
                        $("#StatusLbl").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                    }
                    if(st=="Inactive"){
                        $("#StatusLbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }
                    if(st=="Block"){
                        $("#StatusLbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }

                    if(loyaltyst=="Bronze"){
                        $("#LoyalityStatusLbl").html("<b style='color:#CD7F32'>"+value.LoyalityStatus+"</b>");
                    }
                    if(loyaltyst=="Silver"){
                        $("#LoyalityStatusLbl").html("<b style='color:#808080'>"+value.LoyalityStatus+"</b>");
                    }
                    if(loyaltyst=="Gold"){
                        $("#LoyalityStatusLbl").html("<b style='color:#FFD700'>"+value.LoyalityStatus+"</b>");
                    }
                    if(loyaltyst=="Platinum"){
                        $("#LoyalityStatusLbl").html("<b style='color:#e2e2e2'>"+value.LoyalityStatus+"</b>");
                    }
                    if(value.Picture===null){
                        $('#previewInfoImg').attr("src","");
                        $('#previewInfoImg').attr("alt","Face ID not found");
                        $("#previewInfoImg").show(); 
                    }
                    else if(value.Picture!=null){
                        $('#previewInfoImg').attr("src","../../../storage/uploads/MemberPicture/"+value.Picture);
                        $('#previewInfoImg').show();
                    }

                    if(leftthumb===null||leftthumb===''||leftthumb==='NULL'){
                        $('#leftthumblblinfo').html('Non-Registered');
                        $("#leftthumblblinfo").css("color","#5e5873");
                    }
                    if(leftthumb!==null && leftthumb!=='' && leftthumb!=='NULL'){
                        $('#leftthumblblinfo').html('Registered');
                        $("#leftthumblblinfo").css("color","#1CC88A");
                    }

                    if(leftind===null||leftind===''||leftind==='NULL'){
                        $('#leftindexlblinfo').html('Non-Registered');
                        $("#leftindexlblinfo").css("color","#5e5873");
                    }
                    if(leftind!==null && leftind!=='' && leftind!=='NULL'){
                        $('#leftindexlblinfo').html('Registered');
                        $("#leftindexlblinfo").css("color","#1CC88A");
                    }

                    if(leftmiddle===null||leftmiddle===''||leftmiddle==='NULL'){
                        $('#leftmiddlelblinfo').html('Non-Registered');
                        $("#leftmiddlelblinfo").css("color","#5e5873");
                    }
                    if(leftmiddle!==null && leftmiddle!=='' && leftmiddle!=='NULL'){
                        $('#leftmiddlelblinfo').html('Registered');
                        $("#leftmiddlelblinfo").css("color","#1CC88A");
                    }

                    if(leftring===null||leftring===''||leftring==='NULL'){
                        $('#leftringlblinfo').html('Non-Registered');
                        $("#leftringlblinfo").css("color","#5e5873");
                    }
                    if(leftring!==null && leftring!=='' && leftring!=='NULL'){
                        $('#leftringlblinfo').html('Registered');
                        $("#leftringlblinfo").css("color","#1CC88A");
                    }

                    if(leftpicky===null||leftpicky===''||leftpicky==='NULL'){
                        $('#leftpinkylblinfo').html('Non-Registered');
                        $("#leftpinkylblinfo").css("color","#5e5873");
                    }
                    if(leftpicky!==null && leftpicky!=='' && leftpicky!=='NULL'){
                        $('#leftpinkylblinfo').html('Registered');
                        $("#leftpinkylblinfo").css("color","#1CC88A");
                    }

                    if(rightthumb===null||rightthumb===''||rightthumb==='NULL'){
                        $('#rightthumblblinfo').html('Non-Registered');
                        $("#rightthumblblinfo").css("color","#5e5873");
                    }
                    if(rightthumb!==null && rightthumb!=='' && rightthumb!=='NULL'){
                        $('#rightthumblblinfo').html('Registered');
                        $("#rightthumblblinfo").css("color","#1CC88A");
                    }

                    if(rightind===null||rightind===''||rightind==='NULL'){
                        $('#rightindexlblinfo').html('Non-Registered');
                        $("#rightindexlblinfo").css("color","#5e5873");
                    }
                    if(rightind!==null && rightind!=='' && rightind!=='NULL'){
                        $('#rightindexlblinfo').html('Registered');
                        $("#rightindexlblinfo").css("color","#1CC88A");
                    }

                    if(rightmiddle===null||rightmiddle===''||rightmiddle==='NULL'){
                        $('#rightmiddlelblinfo').html('Non-Registered');
                        $("#rightmiddlelblinfo").css("color","#5e5873");
                    }
                    if(rightmiddle!==null && rightmiddle!=='' && rightmiddle!=='NULL'){
                        $('#rightmiddlelblinfo').html('Registered');
                        $("#rightmiddlelblinfo").css("color","#1CC88A");
                    }

                    if(rightring===null||rightring===''||rightring==='NULL'){
                        $('#rightringlblinfo').html('Non-Registered');
                        $("#rightringlblinfo").css("color","#5e5873");
                    }
                    if(rightring!==null && rightring!=='' && rightring!=='NULL'){
                        $('#rightringlblinfo').html('Registered');
                        $("#rightringlblinfo").css("color","#1CC88A");
                    }

                    if(rightpicky===null||rightpicky===''||rightpicky==='NULL'){
                        $('#rightpinkylblinfo').html('Non-Registered');
                        $("#rightpinkylblinfo").css("color","#5e5873");
                    }
                    if(rightpicky!==null && rightpicky!=='' && rightpicky!=='NULL'){
                        $('#rightpinkylblinfo').html('Registered');
                        $("#rightpinkylblinfo").css("color","#1CC88A");
                    }
                });
            });

            $('#memberInfoTbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                "pagingType": "simple",
                "order": [[ 0, "desc" ]],
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
                    url: '/showdetailservice/' + recordId,
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
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;" onclick=appLnFn("'+row.applications_id+'")>'+data+" , "+row.InvoiceNumber+'</a>';
                        }     
                    },
                    {
                        data: 'ApplicationType',
                        name: 'ApplicationType'
                    },
                    {
                        data: 'Type',
                        name: 'Type'
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName'
                    },
                    {
                        data: 'POS',
                        name: 'POS'
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber',
                        'visible': false
                    },
                    {
                        data: 'InvoiceNumber',
                        name: 'InvoiceNumber',
                        'visible': false
                    },
                    {
                        data: 'InvoiceDate',
                        name: 'InvoiceDate'
                    },
                    {
                        data: 'ActiveRange',
                        name: 'ActiveRange',
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                    }, 
                    {
                        data: 'applications_id',
                        name: 'applications_id',
                        'visible': false
                    }, 
                ],
                
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Pending") {
                        $(nRow).find('td:eq(8)').css({"color": "#f6c23e","font-weight": "bold"}); 
                    } 
                    else if (aData.Status == "Frozen") {
                        $(nRow).find('td:eq(8)').css({"color": "#4e73df","font-weight": "bold"}); 
                    } 
                    else if (aData.Status == "Active"||aData.Status == "To-Be-Active") {
                        $(nRow).find('td:eq(8)').css({"color": "#1cc88a","font-weight": "bold"});
                    }
                    else if (aData.Status == "Void") {
                        $(nRow).find('td:eq(8)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                    else if (aData.Status == "Expired" || aData.Status == "Refund") {
                        $(nRow).find('td:eq(8)').css({"color": "#e74a3b","font-weight": "bold"});
                    }
                }
            });

            $(".infoscl").collapse('show');
            $("#memberInfoModal").modal('show'); 
        }

        function appeditdata(recordId) {
            $('.select2').select2();
            var pterm=0;
            var grp=0;
            var memberinfo="";
            var serviceinfo="";
            var apptype="";
            var appcount=0;
            var memloysts=0;
            var isreadonly="";
            var isvisible="";
            var baseappid="";
            var fsnum="";
            var meminfo="";
            var memserinfo="";
            $("#operationtypes").val("2");
            $("#applicationId").val(recordId);
            $('#mrc').empty();
            $('#ApplicationsId').empty();
            var applicationidlist = $("#applicationsidcbx > option").clone();
            j=0;
            c=0;
            r=0;
            $.ajax({
                type: "get",
                url: "{{ url('/showappedit') }}" + '/' + recordId,
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
                    memberinfo=data.meminfo;
                    serviceinfo=data.serviceinfo;
                    apptype=data.apptypeval;
                    appcount=data.appcnt;
                    memloysts=data.membercnt;
                    baseappid=data.baseappidval;
                    fsnum=data.fsnumbers;
                    meminfo=data.memberinfo;
                    memserinfo=data.memserviceinfo;
                    $('#applicationCountVal').val(appcount);
                    $.each(data.appdata, function(key, value) {
                        $('#ApplicationsId').append(applicationidlist);
                        $('#ApplicationType').val(value.ApplicationType).select2();
                        $('#Group').val(value.groupmembers_id).trigger('change').select2();
                        $("#PaymentTerm option[value='"+value.paymentterms_id+"']").remove();
                        $('#PaymentTerm').append('<option selected value="'+value.paymentterms_id+'">'+value.PaymentTermName+'</option>').select2();
                        $('#Pos').val(value.stores_id).select2();
                        $('#VoucherType').val(value.VoucherType).select2();
                        $("#mrc option[value='"+value.Mrc+"']").remove(); 
                        $('#mrc').append('<option selected value="'+value.Mrc+'">'+value.Mrc+'</option>').select2();
                        $('#VoucherNumber').val(value.VoucherNumber);
                        $('#PaymentTermAmountVal').val(value.PaymentTermAmount);
                        $('#InvoiceNumber').val(value.InvoiceNumber);
                        $('#RegistationDate').val(value.RegistrationDate);
                        $('#ExpiryDate').val(value.ExpiryDate);
                        $('#date').val(value.InvoiceDate);
                        $('#Memo').val(value.Memo); 
                        $('#applicationdocumentupdate').val(value.DocumentUploadPath); 
                        var invnum=value.InvoiceNumber||"";
                        if(value.VoucherType=="Fiscal-Receipt"){
                            $('#mrcdiv').show();
                        }
                        else if(value.VoucherType=="Manual-Receipt"){
                            $('#mrcdiv').hide();
                        }
                        if(value.ApplicationType=="New"){
                            $('#ApplicationsId').empty();
                            $('#applicationiddiv').hide();
                        }
                        else{
                            $("#ApplicationsId option[value='"+value.id+"']").remove();
                            $("#ApplicationsId option[value='"+value.RenewParentId+"']").remove();
                            $("#ApplicationsId option").each(function() {
                                if(parseFloat(this.value)>=parseFloat(value.id)){
                                    $("#ApplicationsId option[value='"+this.value+"']").remove();
                                }
                            });
                            $('#ApplicationsId').append('<option selected value="'+value.RenewParentId+'">'+fsnum+"       ,     "+meminfo+"       ,     "+memserinfo+'</option>').select2();
                            $('#applicationiddiv').show();
                        }
                        if(parseFloat(value.RenewParentId)==0){
                            $('#hiddenAppType').val("New");
                        }
                        else if(parseFloat(value.RenewParentId)>=1){
                            $('#hiddenAppType').val("Renew");
                        }

                        if(value.DocumentUploadPath==null){
                            $("#applicationdoclinkbtn").hide(); 
                        }
                        else if(value.DocumentUploadPath!=null){
                            $("#documentNumbers").val(value.DocumentUploadPath); 
                            $("#applicationdoclinkbtn").text(value.DocumentOriginalName); 
                            $("#applicationdoclinkbtn").show(); 
                        }

                        var statusvals=value.Status;
                        if(statusvals==="Pending"){
                            $("#statusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else if(statusvals==="Verified"){
                            $("#statusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                        }

                        if(parseFloat(appcount)==0){
                            $('#ApplicationType').empty();
                            $('#Group').empty();
                            $('#PaymentTerm').empty();
                            var groupopt = $("#groupcbx > option").clone();
                            var ptermopt = $("#paymenttermcbx > option").clone();
                            $('#Group').append(groupopt);
                            $('#PaymentTerm').append(ptermopt);
                            $('#ApplicationType').append('<option value="New">New</option></option><option value="Renew">Renew</option><option value="Trainer-Fee">Trainer-Fee</option>').select2();
                            $("#ApplicationType option[value='"+value.ApplicationType+"']").remove();
                            $("#Group option[value='"+value.groupmembers_id+"']").remove();
                            $("#PaymentTerm option[value='"+value.paymentterms_id+"']").remove();
                            $('#Group').append('<option selected value="'+value.groupmembers_id+'">'+value.GroupName+'</option>').trigger('change').select2();
                            $('#ApplicationType').append('<option selected value="'+value.ApplicationType+'">'+value.ApplicationType+'</option>').select2();
                            $('#PaymentTerm').append('<option selected value="'+value.paymentterms_id+'">'+value.PaymentTermName+'</option>').select2();
                            if(value.Status=="Pending"){
                                flatpickr('#RegistationDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
                                flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
                            }
                            else if(value.Status!="Pending"){
                                flatpickr('#RegistationDate', { dateFormat: 'Y-m-d',clickOpens:false,maxDate:cdatevar});
                                flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false,maxDate:cdatevar});
                            }
                            
                            $('#RegistationDate').val(value.RegistrationDate);
                            $('#date').val(value.InvoiceDate);
                        }
                        else if(parseFloat(appcount)>=1){
                            $('#ApplicationType').empty();
                            $('#Group').empty();
                            $('#PaymentTerm').empty();
                            $('#ApplicationType').append('<option selected value="'+value.ApplicationType+'">'+value.ApplicationType+'</option>').select2();
                            $('#PaymentTerm').append('<option selected value="'+value.paymentterms_id+'">'+value.PaymentTermName+'</option>').select2();
                            $('#Group').append('<option selected value="'+value.groupmembers_id+'">'+value.GroupName+'</option>').trigger('change').select2();
                            flatpickr('#RegistationDate', { dateFormat: 'Y-m-d',clickOpens:false});
                            flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false});
                            $('#RegistationDate').val(value.RegistrationDate);
                            $('#date').val(value.InvoiceDate);
                        }
                        $('#PaymentType').empty();
                        if(parseFloat(memloysts)>=1){
                            $('#PaymentTerm').empty();
                            $('#PaymentTerm').append('<option selected value="'+value.paymentterms_id+'">'+value.PaymentTermName+'</option>').select2();
                        }
                        if(value.IsAllowedCreditSales=="Allow"){
                            $('#PaymentType').append('<option value="Cash">Cash</option><option value="Credit">Credit</option>');
                            $("#PaymentType option[value='"+value.PaymentType+"']").remove();
                            $('#PaymentType').append('<option selected value="'+value.PaymentType+'">'+value.PaymentType+'</option>');
                        }
                        if(value.IsAllowedCreditSales=="Not-Allow"){
                            $('#PaymentType').append('<option value="Cash">Cash</option>');
                            $("#PaymentType option[value='"+value.PaymentType+"']").remove();
                            $('#PaymentType').append('<option selected value="'+value.PaymentType+'">'+value.PaymentType+'</option>');
                        }

                        $('#PaymentType').select2
                        ({
                            minimumResultsForSearch: -1
                        });
                        $('#VoucherType').select2
                        ({
                            minimumResultsForSearch: -1
                        });
                        $('#ApplicationType').select2
                        ({
                            minimumResultsForSearch: -1
                        });
                        $('#ApplicationsId').select2
                        ({
                            dropdownCssClass : 'appiddrp',
                        });
                        pterm=value.paymentterms_id;
                        grp=value.groupmembers_id;
                    });

                    if(apptype == "New" || apptype == "Renew"){
                        $.each(data.memdata, function(key, value) {
                            ++a;
                            ++b;
                            ++c;
                            $("#dynamicTablem > tbody").append('<tr id="rowindm'+b+'"><td style="font-weight:bold;width:3%;text-align:center;">'+c+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="rowm['+b+'][valsm]" id="valsm'+b+'" class="valsm form-control" readonly="true" style="font-weight:bold;" value="'+b+'"/></td>'+
                                '<td style="width:61%;"><select id="Member'+b+'" class="select2 form-control form-control Member" onchange="MemberFn(this)" name="rowm['+b+'][member_id]"></select></td>'+
                                '<td style="width:14%;"><input type="text" name="rowm['+b+'][MemberId]" placeholder="Client ID" id="MemberId'+b+'" value="'+value.MemberId+'" class="MemberId form-control" readonly/></td>'+
                                '<td style="width:14%;"><input type="text" name="rowm['+b+'][LoyalityStatus]" placeholder="Loyality Status" id="LoyalityStatus'+b+'" value="'+value.OldLoyalityStatus+'" class="LoyalityStatus form-control" readonly/></td>'+
                                '<td style="width:8%;text-align:center;"><button type="button" id="viewbtn'+b+'" class="viewcls btn btn-light btn-sm" style="display:none;color:#00cfe8 ;background-color:#FFFFFF;border-color:#FFFFFF" onmouseover="viewPic(this)"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button><button type="button" id="removebtnm'+b+'" class="btn btn-light btn-sm removem-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberCount]" placeholder="Member Count ID" id="MemberCount'+b+'" value="'+value.IsMemberBefore+'" class="MemberCount form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberName]" placeholder="Member Name" id="MemberName'+b+'" value="'+value.Name+'" class="MemberName form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][StayDay]" placeholder="Stay Day" id="StayDay'+b+'" value="'+value.StayDay+'" class="StayDay form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][StayDayRenew]" placeholder="Stay Day Renew" id="StayDayRenew'+b+'" value="'+value.StayDayRenew+'" class="StayDayRenew form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][loyaltydiscountval]" placeholder="loyaltydiscountval" id="loydiscount'+b+'" value="'+value.MemberDiscount+'" class="LoyaltyDiscount form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberPic]" placeholder="Member Pic" id="MemberPic'+b+'" value="'+value.Picture+'" class="MemberPic form-control" readonly/></td></tr>'
                            );
                            var defmemopt='<option selected value="'+value.memberships_id+'">'+value.Name+'     ,       '+value.Mobile+'        ,       '+value.Phone+'</option>';
                            
                            if(parseFloat(appcount)==0){
                                var memberlist = $("#membercbx > option").clone();
                                $('#Member'+b).append(memberlist);
                                $("#Member"+b+" option[value='"+value.memberships_id+"']").remove();
                                $('#removebtnm'+b).show();
                                $('#addsm').show();
                            }
                            if(parseFloat(appcount)>=1){
                                $('#removebtnm'+b).hide();
                                $('#addsm').hide();
                            }

                            if(parseFloat(value.MemberActivity)>=1){
                                $('#removebtnm'+b).hide();
                                $('#Member'+b).empty();
                            }
                            $('.viewcls').show();
                            $('#Member'+b).append(defmemopt);
                            $('#Member'+b).select2();
                            flatpickr('#RegistationDate'+b, { dateFormat: 'Y-m-d'});
                            $('#select2-Member'+b+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        });

                        $.each(data.servdata, function(key, value) {
                            ++i;
                            ++m;
                            ++j;
                            
                            var gtotalhidden=parseFloat(value.DiscountServiceAmount||0)+parseFloat(value.TotalAmount||0);
                            $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                                '<td style="width:16%;"><select id="Service'+m+'" class="select2 form-control form-control Service" onchange="serviceFn(this)" name="row['+m+'][service_id]"></select></td>'+
                                '<td style="width:16%;"><select id="Period'+m+'" class="select2 form-control form-control Period" onchange="periodFn(this)" name="row['+m+'][period_id]"></select></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][BeforeTax]" placeholder="Before Tax" id="BeforeTax'+m+'" class="BeforeTax form-control numeral-mask" onkeyup="CalculateBTServicePrice(this)" onkeypress="return ValidateNum(event);" value="'+value.BeforeTotal+'" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly style="font-weight:bold;"/></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][Tax]" placeholder="Tax" id="Tax'+m+'" class="Tax form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.Tax+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][GrandTotal]" placeholder="Grand Total" id="GrandTotal'+m+'" class="GrandTotal form-control numeral-mask" onkeyup="CalculateGTServicePrice(this)" onkeypress="return ValidateNum(event);" value="'+value.TotalAmount+'" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly style="font-weight:bold;"/></td>'+
                                '<td style="width:12%;"><input type="number" step="any" name="row['+m+'][Discount]" placeholder="Discount Percent" id="Discount'+m+'" class="Discount form-control numeral-mask" onkeyup="discountFn(this)" onkeypress="return ValidateNum(event);" value="'+value.DiscountServicePercent+'" @can('Invoice-Apply-Discount') ondblclick="discountActiveFn(this)"; @endcan readonly style="font-weight:bold;"/></td>'+
                                '<td style="width:16%;"><select id="AccessControl'+m+'" class="select2 form-control form-control AccessControl" onchange="acControlFn(this)" name="row['+m+'][AccessControl]"></select></td>'+
                                '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                '<td style="display:none;"><input type="number" step="any" name="row['+m+'][DiscountAmount]" placeholder="DiscountAmount" id="DiscountAmount'+m+'" class="DiscountAmount form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.DiscountServiceAmount+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" step="any" name="row['+m+'][grandtotalhidden]" placeholder="grandtotalhidden" id="grandtotalhidden'+m+'" class="grandtotalhidden form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.DiscountServicePercent+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" step="any" name="row['+m+'][hiddengrandtotalamount]" placeholder="hiddengrandtotalamount" id="hiddengrandtotalamount'+m+'" class="hiddengrandtotalamount form-control numeral-mask" value="'+gtotalhidden+'" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td></tr>'
                            );
                            var defservopt='<option selected value="'+value.services_id+'">'+value.ServiceName+'</option>';
                            var defperdopt='<option selected value="'+value.periods_id+'">'+value.PeriodName+'</option>';
                            var defaccesscontrol='<option selected value="'+value.deviceid+'">'+value.DeviceName+'</option>';
                            var devicelist = $("#devicecbx > option").clone();
                            if(parseFloat(appcount)==0){
                                var servicelist = $("#servicecbx > option").clone();
                                $('#Service'+m).append(servicelist);
                                $("#Service"+m+" option[label!='"+grp+"']").remove();
                                $("#Service"+m+" option[title!='"+pterm+"']").remove();
                                $("#Service"+m+" option[value='"+value.services_id+"']").remove();

                                var options = $("#periodcbx > option").clone();
                                $('#Period'+m).append(options);
                                $("#Period"+m+" option[label!='"+grp+"']").remove();
                                $("#Period"+m+" option[title!='"+pterm+"']").remove();
                                $("#Period"+m+" option[accesskey!='"+value.services_id+"']").remove();
                                $("#Period"+m+" option[value='"+value.periods_id+"']").remove();

                                $('.remove-tr').show();
                                $('#addser').show();
                            }
                            if(parseFloat(appcount)>=1){
                                $('.remove-tr').hide();
                                $('#addser').hide();
                                $('.BeforeTax').prop("readonly", true);
                                $('.GrandTotal').prop("readonly", true);
                                $('.Discount').prop("readonly", true);
                            }
                            $('#Service'+m).append(defservopt);
                            $('#Service'+m).select2();

                            $('#Period'+m).append(defperdopt);
                            $('#Period'+m).select2();

                            $('#AccessControl'+m).append(devicelist);
                            $("#AccessControl"+m+" option[value='"+value.deviceid+"']").remove();
                            $('#AccessControl'+m).append(defaccesscontrol);
                            $('#AccessControl'+m).select2();
                        });

                        $('.newext').show();
                        $('.trncls').hide();

                        renumberRows();
                        renumbermRows();
                        CalculateGrandTotal();
                        $('#select2-Service'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Period'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-AccessControl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }
                    else if(apptype=="Trainer-Fee"){
                        $.each(data.traindata, function(key, value) {
                            ++q;
                            ++s;
                            ++r;
                            var gtotalhiddentr=parseFloat(value.DiscountServiceAmount||0)+parseFloat(value.TotalAmount||0);
                            $("#dynamicTableTrn > tbody").append('<tr id="rowTrnsind'+s+'"><td style="font-weight:bold;width:3%;text-align:center;">'+r+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="rowTrn['+s+'][vals]" id="valstrn'+s+'" class="valstr form-control" readonly="true" style="font-weight:bold;" value="'+s+'"/></td>'+
                                '<td style="width:15%;"><select id="Membertr'+s+'" class="select2 form-control form-control Membertr" onchange="MemberTrFn(this)" name="rowTrn['+s+'][member_id]"></select></td>'+
                                '<td style="width:10%;"><input type="text" name="rowTrn['+s+'][MemberId]" placeholder="Client ID" id="MemberIdtr'+s+'" value="'+value.MemberId+'" class="MemberIdtr form-control" readonly/></td>'+
                                '<td style="width:14%;"><select id="Servicetr'+s+'" class="select2 form-control form-control Servicetr" onchange="serviceTrFn(this)" name="rowTrn['+s+'][service_id]"></select></td>'+
                                '<td style="width:15%;"><select id="Trainertr'+s+'" class="select2 form-control form-control Trainertr" onchange="trainerFn(this)" name="rowTrn['+s+'][employes_id]"></select></td>'+
                                '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][BeforeTax]" placeholder="Before Tax" id="BeforeTaxtr'+s+'" class="BeforeTaxtr form-control numeral-mask" onkeyup="CalculateBTServicePriceTr(this)" value="'+value.BeforeTotal+'" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                                '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][Tax]" placeholder="Tax" id="Taxtr'+s+'" class="Taxtr form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.Tax+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][GrandTotal]" placeholder="Grand Total" id="GrandTotaltr'+s+'" class="GrandTotaltr form-control numeral-mask" onkeyup="CalculateGTServicePriceTr(this)" value="'+value.TotalAmount+'" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                                '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][Discount]" placeholder="Discount Percent" id="Discounttr'+s+'" class="Discounttr form-control numeral-mask" onkeyup="discountTrFn(this)" value="'+value.DiscountServicePercent+'" @can('Invoice-Apply-Discount') ondblclick="discountActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                                '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+s+'" class="btn btn-light btn-sm removetr-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                '<td style="display:none;"><input type="number" name="rowTrn['+s+'][period_id]" placeholder="Periodtr" id="periodtr'+s+'" class="periodtr form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.periods_id+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="rowTrn['+s+'][DiscountAmount]" placeholder="DiscountAmounttr" id="DiscountAmounttr'+s+'" class="DiscountAmounttr form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.DiscountServiceAmount+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="rowTrn['+s+'][grandtotalhidden]" placeholder="grandtotalhiddentr" id="grandtotalhiddentr'+s+'" class="grandtotalhiddentr form-control numeral-mask" onkeypress="return ValidateNum(event);" value="'+value.DiscountServicePercent+'" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="rowTrn['+s+'][hiddengrandtotalamount]" placeholder="hiddengrandtotalamounttr" id="hiddengrandtotalamounttr'+s+'" class="hiddengrandtotalamounttr form-control numeral-mask" value="'+gtotalhiddentr+'" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td></tr>'
                            );
                            var defmemopttr='<option selected value="'+value.memberships_id+'">'+value.MemberName+'     ,       '+value.Mobile+'        ,       '+value.Phone+'</option>';
                            var defservopttr='<option selected value="'+value.services_id+'">'+value.ServiceName+'</option>';
                            var defperdopttr='<option selected value="'+value.periods_id+'">'+value.PeriodName+'</option>';
                            var deftrainopttr='<option selected value="'+value.employes_id+'">'+value.TrainerName+'</option>';
                            var memberlist = $("#membershipcbx > option").clone();
                            $('#Membertr'+s).append(memberlist);
                            $("#Membertr"+s+" option[title!='"+value.applications_id+"']").remove();
                            $("#Membertr"+s+" option[value='"+value.memberships_id+"']").remove();
                            $('#Membertr'+s).append(defmemopttr);

                            var servicelist = $("#servicetrncbx > option").clone();
                            $('#Servicetr'+s).append(servicelist);
                            $("#Servicetr"+s+" option[label!='"+value.memberships_id+"']").remove();
                            $("#Servicetr"+s+" option[title!='"+value.applications_id+"']").remove();
                            $("#Servicetr"+s+" option[value='"+value.services_id+"']").remove();
                            $('#Servicetr'+s).append(defservopttr);

                            var options = $("#trainercbx > option").clone();
                            $('#Trainertr'+s).append(options);
                            $("#Trainertr"+s+" option[title!='"+value.services_id+"']").remove();
                            $("#Trainertr"+s+" option[value='"+value.employes_id+"']").remove();
                            $('#Trainertr'+s).append(deftrainopttr);

                            $('#Membertr'+s).select2();
                            $('#Servicetr'+s).select2();
                            $('#Trainertr'+s).select2();
                        });
                        $('#addstr').show();
                        renumberRowsTr();
                        CalculateGrandTotalTr();
                        $('.newext').hide();
                        $('.trncls').show();
                        $('#select2-Membertr'+s+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Servicetr'+s+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Trainertr'+s+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }
                }
            });
            $('#regdatediv').show();
            $("#apptitle").html("Edit Fitness Form");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        }

        $('#Group').on('change', function() {
            var pterms="";
            var exists = 0;
            var servexists = 0;
            var rowCount = $("#dynamicTablem > tbody tr").length;
            var grp=$('#Group').val();
            var payterm=$('#PaymentTerm').val();
            var grpcategory=$('#groupcategory').val();
            var servicepr="";
            var serviceval="";
            var grpval=$('#Group').val();
            var ptype=$('#ApplicationType').val();
            var prid=$('#applicationId').val();
            var applicationgrpidval=$('#ApplicationGroupVal').val();
            var groupsize=$('#groupsizerenew').val()||0;
            var options="";
            var servicelist="";
            var numofmem="";
            var subtotal=0;
            var tax=0;
            var grandtotal=0;
            var grandtotalnet=0;
            var ssubtotal=0;
            var stax=0;
            var sgrandtotal=0;
            var newgrandtotalnet=0;
            var oldsgrandtotalnet=0;
            var numoftotalmem=0;
            var memberflag=0;
            var selectedopt="";
            var selectedtext="";
            var selectedservtext="";
            var groupvalues=0;
            var regdateval=$('#RegistationDate').val();
            var defopt = '<option selected value=""></option>';
            var pterm=0;
            var regdate="";
            var days="";
            $.each($('#dynamicTablem').find('.MemberCount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    memberflag += parseFloat($(this).val());
                }
            });

            $.ajax({
                url: '/groupattr',
                type: 'POST',
                data:{
                    grp:$('#Group').val(),
                },
                success: function(data) {
                    $.each(data.glist, function(key, value) {
                        $('#GroupAmountVal').val(value.GroupSize);
                        groupvalues=value.GroupSize;
                        if(parseFloat(grp) !=1 && ptype=="Trainer-Fee"){
                            $('#Group').select2('destroy');
                            $('#Group').val(null).select2();
                            $('#Group').select2
                            ({
                                placeholder: "Select Group here",
                            });
                            toastrMessage('error',"You cant select more than 1 person group, on a single invoice","Error");
                        }
                        if(parseFloat(groupvalues)>parseFloat(groupsize) && ptype=="Renew" && isNaN(parseFloat(prid))){
                            var grpidval=$('#groupidrenew').val()||0;
                            $('#Group').select2('destroy');
                            $('#Group').val(grpidval).trigger('change').select2();
                            toastrMessage('error',"You cant increase group on Renew invoice type","Error");
                        }
                    });
                }
            });

            for(var i=1;i<=m;i++){
                serviceval=$('#Service'+i).val();
                selectedopt=$('#Period'+i).val();
                servexists=0;
                exists=0;
                if(($('#Service'+i).val())!=undefined){ 
                    $("#Service"+i+" :selected").each(function() {
                        selectedservtext=this.text;
                    });
                    $('#Service'+i).empty();
                    servicelist = $("#servicecbx > option").clone();
                    $('#Service'+i).append(servicelist);
                    $("#Service"+i+" option[label!='"+grpval+"']").remove();
                    $("#Service"+i+" option[title!='"+payterm+"']").remove();
                    $('#Service'+i+'  option').each(function(){
                        if (this.value == serviceval) {
                            servexists = 1;
                        }
                    });

                    if(parseFloat(servexists)>=1){
                        $("#Service"+i+" option[value='"+serviceval+"']").remove();
                        $('#Service'+i).append('<option selected value="'+serviceval+'">'+selectedservtext+'</option>');
                    }
                    else if(parseFloat(servexists)==0 && !isNaN(parseFloat(serviceval))){
                        $('#Service'+i).empty();
                        $('#Service'+i).append(servicelist);
                        $("#Service"+i+" option[label!='"+grpval+"']").remove();
                        $("#Service"+i+" option[title!='"+payterm+"']").remove();
                        $('#Service'+i).append(defopt);
                        $('#Period'+i).append(defopt);
                        $('#Period'+i).select2
                        ({
                            placeholder: "Select Period here",
                        });
                        $('#Service'+i).select2
                        ({
                            placeholder: "Select Service here",
                        });
                        $('#BeforeTax'+i).val("");
                        $('#Tax'+i).val("");
                        $('#GrandTotal'+i).val("");
                        $('#Discount'+i).val("");
                        $('#DiscountAmount'+i).val("");
                        $('grandtotalhidden'+i).val("");
                    }
                    else if(parseFloat(servexists)==0 && isNaN(parseFloat(serviceval))){
                        $('#Service'+i).append(defopt);
                        $('#Service'+i).select2
                        ({
                            placeholder: "Select Service here",
                        });
                    }
                }

                if(($('#Period'+i).val())!=undefined){
                    $("#Period"+i+" :selected").each(function() {
                        selectedtext=this.text;
                    });
                    $('#Period'+i).empty();
                    options = $("#periodcbx > option").clone();
                    $('#Period'+i).append(options);
                    $("#Period"+i+" option[label!='"+grpval+"']").remove();
                    $("#Period"+i+" option[title!='"+payterm+"']").remove();
                    $("#Period"+i+" option[accesskey!='"+serviceval+"']").remove();
                    $('#Period'+i+'  option').each(function(){
                        if (this.value == selectedopt) {
                            exists = 1;
                        }
                    });
                    if(parseFloat(exists)>=1){
                        $('.Period').append(defopt);
                        $('.Period').select2
                        ({
                            placeholder: "Select Period here",
                        });
                        $('.BeforeTax').val("");
                        $('.Tax').val("");
                        $('.GrandTotal').val("");
                        $('.Discount').val("");
                        $('.DiscountAmount').val("");
                        $('.grandtotalhidden').val("");
                    }
                    else if(parseFloat(exists)==0){
                        $('#Period'+i).empty();
                        $('#Period'+i).append(options);
                        $("#Period"+i+" option[label!='"+grpval+"']").remove();
                        $("#Period"+i+" option[title!='"+payterm+"']").remove();
                        $("#Period"+i+" option[accesskey!='"+serviceval+"']").remove();
                        $('#Period'+i).append(defopt);
                        $('#Period'+i).select2
                        ({
                            placeholder: "Select Period here",
                        });
                        $('#BeforeTax'+i).val("");
                        $('#Tax'+i).val("");
                        $('#GrandTotal'+i).val("");
                        $('#Discount'+i).val("");
                        $('#DiscountAmount'+i).val("");
                        $('grandtotalhidden'+i).val("");
                    } 
                } 
                
                if(grpcategory=="Group" && parseFloat(grp)==1 && ptype=="Renew" && isNaN(parseFloat(prid))){
                    $('#ApplicationType').select2('destroy');
				    $('#ApplicationType').val("New").select2();
                    $('#ApplicationType').select2
                    ({
                        minimumResultsForSearch: -1
                    });
                    $('#applicationiddiv').hide();
                }
            }
            
            $('#group-error').html("");
            //$('#dynamicTable tbody').empty();
            //$('#dynamicTablem tbody').empty();
            //$('.totalrownumber').hide();
            //$('.totalrownumberm').hide();
            //$('.totaldiscnumber').hide();
            renumberRows();
            CalculateGrandTotal();
            j=0;
            c=0;
        });

        $('#PaymentTerm').on('change', function() {
            var pterms="";
            var exists = 0;
            var servexists = 0;
            var rowCount = $("#dynamicTablem > tbody tr").length;
            var grp=$('#Group').val();
            var payterm=$('#PaymentTerm').val();
            var servicepr="";
            var serviceval="";
            var grpval=$('#Group').val();
            var applicationtypeval=$('#ApplicationType').val();
            var grpamountval=$('#GroupAmountVal').val();
            var rowService = 0;
            var discountvals=0;
            var options="";
            var servicelist="";
            var numofmem="";
            var subtotal=0;
            var tax=0;
            var grandtotal=0;
            var grandtotalnet=0;
            var ssubtotal=0;
            var stax=0;
            var sgrandtotal=0;
            var newgrandtotalnet=0;
            var oldsgrandtotalnet=0;
            var numoftotalmem=0;
            var memberflag=0;
            var selectedopt="";
            var selectedtext="";
            var selectedservtext="";
            var regdateval=$('#RegistationDate').val();
            var defopt = '<option selected value=""></option>';
            var pterm=0;
            var rday=0;
            var ptermval=0;
            var regdate="";
            var days="";
            var expiredatehidden="";
            $.each($('#dynamicTablem').find('.MemberCount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    memberflag += parseFloat($(this).val());
                }
            });
            $.ajax({
                url: '/ptermattr',
                type: 'POST',
                data:{
                    pterm:$('#PaymentTerm').val(),
                    expiredatehidden:$('#ExpireDateHiddenVal').val(),
                },
                success: function(data) {
                    $.each(data.ptlist, function(key, value) {
                        $('#PaymentTermAmountVal').val(value.PaymentTermAmount);
                    });
                    pterms=data.pterms;
                    rday=data.remainingday;
                    ptermval=data.paymenttermval;
                   
                    // if(applicationtypeval=="Trainer-Fee" && parseFloat(rday)<parseFloat(ptermval)){
                    //     toastrMessage('error',"The selected payment term is greater than the remaining day","Error");
                    //     $('#PaymentTerm').val(null).select2
                    //     ({
                    //         placeholder: "Select Payment Term here",
                    //     });
                    // }
                    if(!isNaN(parseFloat(regdateval))){
                        regDateFn();
                    }
                },
            });

            for(var i=1;i<=m;i++){
                serviceval=$('#Service'+i).val();
                selectedopt=$('#Period'+i).val();
                servexists=0;
                exists=0;
                if(($('#Service'+i).val())!=undefined){ 
                    $("#Service"+i+" :selected").each(function() {
                        selectedservtext=this.text;
                    });
                    $('#Service'+i).empty();
                    servicelist = $("#servicecbx > option").clone();
                    $('#Service'+i).append(servicelist);
                    $("#Service"+i+" option[label!='"+grpval+"']").remove();
                    $("#Service"+i+" option[title!='"+payterm+"']").remove();
                    $('#Service'+i+'  option').each(function(){
                        if (this.value == serviceval) {
                            servexists = 1;
                        }
                    });

                    if(parseFloat(servexists)>=1){
                        $("#Service"+i+" option[value='"+serviceval+"']").remove();
                        $('#Service'+i).append('<option selected value="'+serviceval+'">'+selectedservtext+'</option>');
                    }
                    else if(parseFloat(servexists)==0 && !isNaN(parseFloat(serviceval))){
                        $('#Service'+i).empty();
                        $('#Service'+i).append(servicelist);
                        $("#Service"+i+" option[label!='"+grpval+"']").remove();
                        $("#Service"+i+" option[title!='"+payterm+"']").remove();
                        $('#Service'+i).append(defopt);
                        $('#Period'+i).append(defopt);
                        $('#Period'+i).select2
                        ({
                            placeholder: "Select Period here",
                        });
                        $('#Service'+i).select2
                        ({
                            placeholder: "Select Service here",
                        });
                        $('#BeforeTax'+i).val("");
                        $('#Tax'+i).val("");
                        $('#GrandTotal'+i).val("");
                        $('#Discount'+i).val("");
                        $('#DiscountAmount'+i).val("");
                        $('grandtotalhidden'+i).val("");
                    }
                    else if(parseFloat(servexists)==0 && isNaN(parseFloat(serviceval))){
                        $('#Service'+i).append(defopt);
                        $('#Service'+i).select2
                        ({
                            placeholder: "Select Service here",
                        });
                    }
                    CalculateGrandTotal();
                }

                if(($('#Period'+i).val())!=undefined){
                    $("#Period"+i+" :selected").each(function() {
                        selectedtext=this.text;
                    });
                    $('#Period'+i).empty();
                    options = $("#periodcbx > option").clone();
                    $('#Period'+i).append(options);
                    $("#Period"+i+" option[label!='"+grpval+"']").remove();
                    $("#Period"+i+" option[title!='"+payterm+"']").remove();
                    $("#Period"+i+" option[accesskey!='"+serviceval+"']").remove();
                    $('#Period'+i+'  option').each(function(){
                        if (this.value == selectedopt) {
                            exists = 1;
                        }
                    });
                    if(parseFloat(exists)>=1){
                        $("#Period"+i+" option[value='"+selectedopt+"']").remove();
                        $('#Period'+i).append('<option selected value="'+selectedopt+'">'+selectedtext+'</option>');
                        (function(index){
                            $.ajax({
                                url: '/paymentlist',
                                type: 'POST',
                                data:{
                                    servicepr : serviceval,
                                    grp:$('#Group').val(),
                                    pterm:$('#PaymentTerm').val(),
                                    periodpr:selectedopt,
                                    numoftotalmem:rowCount,
                                    numofmem:memberflag,
                                },
                                
                                success: function(data) {
                                    $.each(data.plist, function(key, value) {//existing member
                                        oldsgrandtotalnet=parseFloat(value.MemberPrice||0)-parseFloat(value.Discount||0);
                                        
                                    });
                                    $.each(data.singledata, function(key, value) {//new member
                                        newgrandtotalnet=parseFloat(value.NewMemberPrice||0)-parseFloat(value.NewMemDiscount||0);
                                    });
                                    grandtotalnet=parseFloat(oldsgrandtotalnet)+parseFloat(newgrandtotalnet);
                                    subtotal=parseFloat(grandtotalnet)/1.15;
                                    tax=parseFloat(grandtotalnet)-parseFloat(subtotal);
                                    $('#BeforeTax'+index).val(subtotal.toFixed(2));
                                    $('#Tax'+index).val(tax.toFixed(2));
                                    $('#GrandTotal'+index).val(grandtotalnet);
                                    $('#grandtotalhidden'+index).val(grandtotalnet);
                                    discountvals=$('#loyaltydiscountVal').val()||0;
                                    if(parseFloat(discountvals)>0 && parseFloat(grpamountval)==1){
                                        discountEach();
                                    }
                                    CalculateGrandTotal();
                                }
                            });
                            
                        })(i);
                        discountvals=$('#loyaltydiscountVal').val()||0;
                        rowService = $("#dynamicTable > tbody tr").length;
                        if(parseFloat(discountvals)>0 && parseFloat(grpamountval)==1){
                            var discounteach=parseFloat(discountvals)/parseFloat(rowService);
                            $('.Discount').val(discounteach.toFixed(2));
                           
                        }
                        renumberRows();
                        renumbermRows();
                        CalculateGrandTotal();
                    }
                    else if(parseFloat(exists)==0){
                        $('#Period'+i).empty();
                        $('#Period'+i).append(options);
                        $("#Period"+i+" option[label!='"+grpval+"']").remove();
                        $("#Period"+i+" option[title!='"+payterm+"']").remove();
                        $("#Period"+i+" option[accesskey!='"+serviceval+"']").remove();
                        $('#Period'+i).append(defopt);
                        $('#Period'+i).select2
                        ({
                            placeholder: "Select Period here",
                        });
                        $('#BeforeTax'+i).val("");
                        $('#Tax'+i).val("");
                        $('#GrandTotal'+i).val("");
                        $('#Discount'+i).val("");
                        $('#DiscountAmount'+i).val("");
                        $('grandtotalhidden'+i).val("");
                        
                        CalculateGrandTotal();
                    } 
                    renumberRows();
                    //renumberRowsTr();
                    CalculateGrandTotal();
                }                
            }

            if(applicationtypeval=="Trainer-Fee"){
                for(var y=0;y<=s;y++){
                    var trainername="";
                    var trId=$('#Trainertr'+y).val();
                    $("#Trainertr"+y+" :selected").each(function() {
                        trainername=this.text;
                    });
                    $('#Servicetr'+y).trigger('change').select2();
                    $("#Trainertr"+y+" option[value='"+trId+"']").remove();
                    $('#Trainertr'+y).append('<option selected value="'+trId+'">'+trainername+'</option>');
                }
            }
            
            $('#paymentterm-error').html('');
            //$('#dynamicTable tbody').empty();
            //$('#dynamicTablem tbody').empty();
            //$('.totalrownumber').hide();
            //$('.totalrownumberm').hide();
            $('#regdatediv').show();
            renumberRows();
            CalculateGrandTotal();
            //renumberRowsTr();
            CalculateGrandTotalTr();
            j=0;
            c=0;
        });

        $('#ApplicationsId').on('change', function() {
            var apptype=$('#ApplicationType').val();
            var appid=$('#ApplicationsId').val();
            var discountvals=0;
            var rowService=0;
            var extendflag=0;
            var pterm=0;
            var grp=0;
            var grpsize=0;
            j=0;
            c=0;
            r=0;
            if(apptype=="Trainer-Fee"){
                $.ajax({
                    type: "get",
                    url: "{{ url('/showappedit') }}" + '/' + appid,
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
                        $.each(data.appdata, function(key, value) {
                            $('#ApplicationGroupVal').val(value.GroupSize);
                            $('#ExpireDateHiddenVal').val(value.ExpiryDate);
                        });
                    }
                });
                $("#dynamicTablem > tbody").empty();   
                $("#dynamicTable > tbody").empty();
                $("#dynamicTableTrn > tbody").empty();
                renumberRows();
                renumbermRows();
                CalculateGrandTotal();
            }

            else if(apptype=="Renew"){     
                $("#dynamicTablem > tbody").empty();   
                $("#dynamicTable > tbody").empty();
                $("#dynamicTableTrn > tbody").empty();
                $.ajax({
                    type: "get",
                    url: "{{ url('/showappedit') }}" + '/' + appid,
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
                        extendflag=data.stflag;
                        grpsize=data.grpsizeval;
                        $('#groupsizerenew').val(grpsize);
                        if(parseFloat(extendflag)==0){
                            $("#RegistationDate").val(moment(data.regdate,"YYYY-MM-DD").add(1,'d').format('YYYY-MM-DD'));
                            $("#ExpiryDate").val(data.expdate);
                        }
                        else if(parseFloat(extendflag)==1){
                            $("#RegistationDate").val("");
                            $("#ExpiryDate").val("");
                        }
                        $.each(data.appdata, function(key, value) {
                            $('#groupcategory').val(value.Type);
                            $("#PaymentTerm option[value='"+value.paymentterms_id+"']").remove();
                            $('#Group').val(value.groupmembers_id).trigger('change').select2();
                            $('#PaymentTerm').append('<option selected value="'+value.paymentterms_id+'">'+value.PaymentTermName+'</option>').trigger('change').select2();
                            $('#PaymentTermAmountVal').val(value.PaymentTermAmount);
                            $('#groupidrenew').val(value.groupmembers_id);
                            pterm=value.paymentterms_id;
                            grp=value.groupmembers_id;
                        });

                        $.each(data.memdata, function(key, value) {
                            ++a;
                            ++b;
                            ++c;
                            $("#dynamicTablem > tbody").append('<tr id="rowindm'+b+'"><td style="font-weight:bold;width:3%;text-align:center;">'+c+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="rowm['+b+'][valsm]" id="valsm'+b+'" class="valsm form-control" readonly="true" style="font-weight:bold;" value="'+b+'"/></td>'+
                                '<td style="width:61%;"><select id="Member'+b+'" class="select2 form-control form-control Member" onchange="MemberFn(this)" name="rowm['+b+'][member_id]"></select></td>'+
                                '<td style="width:14%;"><input type="text" name="rowm['+b+'][MemberId]" placeholder="Client ID" id="MemberId'+b+'" value="'+value.MemberId+'" class="MemberId form-control" readonly/></td>'+
                                '<td style="width:14%;"><input type="text" name="rowm['+b+'][LoyalityStatus]" placeholder="Loyality Status" id="LoyalityStatus'+b+'" value="'+value.LoyalityStatusMem+'" class="LoyalityStatus form-control" readonly/></td>'+
                                '<td style="width:8%;text-align:center;"><button type="button" id="viewbtn'+b+'" class="viewcls btn btn-light btn-sm" style="color:#00cfe8 ;background-color:#FFFFFF;border-color:#FFFFFF" onmouseover="viewPic(this)"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button><button type="button" id="removebtnm'+b+'" class="btn btn-light btn-sm removem-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberCount]" placeholder="Member Count ID" id="MemberCount'+b+'" value="1" class="MemberCount form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberName]" placeholder="Member Name" id="MemberName'+b+'" value="'+value.Name+'" class="MemberName form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][StayDay]" placeholder="Stay Day" id="StayDay'+b+'" value="'+value.StayDay+'" class="StayDay form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][StayDayRenew]" placeholder="Stay Day Renew" id="StayDayRenew'+b+'" value="'+value.StayDayRenew+'" class="StayDayRenew form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][loyaltydiscountval]" placeholder="loyaltydiscountval" id="loydiscount'+b+'" value="'+value.MemberDiscount+'" class="LoyaltyDiscount form-control" readonly/></td>'+
                                '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberPic]" placeholder="Member Pic" id="MemberPic'+b+'" value="'+value.Picture+'" class="MemberPic form-control" readonly/></td></tr>'
                            );
                            var defmemopt='<option selected value="'+value.memberships_id+'">'+value.Name+'     ,       '+value.Mobile+'        ,       '+value.Phone+'</option>';
                            var memberlist = $("#membercbx > option").clone();
                            $('#Member'+b).append(memberlist);
                            $("#Member"+b+" option[value='"+value.memberships_id+"']").remove();
                            $('#Member'+b).append(defmemopt);
                            $('#Member'+b).select2();
                            flatpickr('#RegistationDate'+b, { dateFormat: 'Y-m-d'});
                            $('#loyaltydiscountVal').val(value.MemberDiscount);
                        });

                        $.each(data.servdata, function(key, value) {
                            ++i;
                            ++m;
                            ++j;
                            $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                                '<td style="width:16%;"><select id="Service'+m+'" class="select2 form-control form-control Service" onchange="serviceFn(this)" name="row['+m+'][service_id]"></select></td>'+
                                '<td style="width:16%;"><select id="Period'+m+'" class="select2 form-control form-control Period" onchange="periodFn(this)" name="row['+m+'][period_id]"></select></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][BeforeTax]" placeholder="Before Tax" id="BeforeTax'+m+'" class="BeforeTax form-control numeral-mask" onkeyup="CalculateBTServicePrice(this)" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][Tax]" placeholder="Tax" id="Tax'+m+'" class="Tax form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                                '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][GrandTotal]" placeholder="Grand Total" id="GrandTotal'+m+'" class="GrandTotal form-control numeral-mask" onkeyup="CalculateGTServicePrice(this)" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                                '<td style="width:12%;"><input type="number" step="any" name="row['+m+'][Discount]" placeholder="Discount Percent" id="Discount'+m+'" class="Discount form-control numeral-mask" onkeyup="discountFn(this)" @can('Invoice-Apply-Discount') ondblclick="discountActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                                '<td style="width:16%;"><select id="AccessControl'+m+'" class="select2 form-control form-control AccessControl" onchange="acControlFn(this)" name="row['+m+'][AccessControl]"></select></td>'+
                                '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                '<td style="display:none;"><input type="number" step="any" name="row['+m+'][DiscountAmount]" placeholder="DiscountAmount" id="DiscountAmount'+m+'" class="DiscountAmount form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" step="any" name="row['+m+'][grandtotalhidden]" placeholder="grandtotalhidden" id="grandtotalhidden'+m+'" class="grandtotalhidden form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                                '<td style="display:none;"><input type="number" step="any" name="row['+m+'][hiddengrandtotalamount]" placeholder="hiddengrandtotalamount" id="hiddengrandtotalamount'+m+'" class="hiddengrandtotalamount form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td></tr>'
                            );
                            var defservopt='<option selected value="'+value.services_id+'">'+value.ServiceName+'</option>';
                            var defperdopt='<option selected value="'+value.periods_id+'">'+value.PeriodName+'</option>';
                            var servicelist = $("#servicecbx > option").clone();
                            var defaccesscontrol='<option selected value="'+value.deviceid+'">'+value.DeviceName+'</option>';
                            var devicelist = $("#devicecbx > option").clone();
                            $('#Service'+m).append(servicelist);
                            $("#Service"+m+" option[label!='"+value.groupmembers_id+"']").remove();
                            $("#Service"+m+" option[title!='"+value.paymentterms_id+"']").remove();
                            $("#Service"+m+" option[value='"+value.services_id+"']").remove();
                            $('#Service'+m).append(defservopt);
                            $('#Service'+m).select2();

                            var options = $("#periodcbx > option").clone();
                            $('#Period'+m).append(options);
                            $("#Period"+m+" option[label!='"+value.groupmembers_id+"']").remove();
                            $("#Period"+m+" option[title!='"+value.paymentterms_id+"']").remove();
                            $("#Period"+m+" option[accesskey!='"+value.services_id+"']").remove();
                            $("#Period"+m+" option[value='"+value.periods_id+"']").remove();
                            $('#Period'+m).append(defperdopt);
                            $('#Period'+m).select2();

                            $('#AccessControl'+m).append(devicelist);
                            $("#AccessControl"+m+" option[value='"+value.deviceid+"']").remove();
                            $('#AccessControl'+m).append(defaccesscontrol);
                            $('#AccessControl'+m).select2();

                            $('#select2-Service'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Period'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-AccessControl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            var servicepr=0;
                            var grp=0;
                            var pterm=0;
                            var periodpr=0;
                            
                            (function(index){
                                $.ajax({
                                    url: '/paymentextendlist',
                                    type: 'POST',
                                    data:{
                                        servicepr : value.services_id,
                                        grp:value.GroupId,
                                        pterm:value.PaymentTerms,
                                        periodpr:value.periods_id,
                                    },
                                    
                                    success: function(data) {
                                        var st=0;
                                        var tx=0;
                                        var gt=0;
                                        grpsize=data.grpsize;
                                        discountvals=$('#loyaltydiscountVal').val()||0;
                                        gt=parseFloat(data.exsmem)-parseFloat(data.exsmemdis||0);
                                        st=parseFloat(data.exsmem)/1.15;
                                        tx=parseFloat(gt)-parseFloat(st);
                                        $('#BeforeTax'+index).val(st.toFixed(2));
                                        $('#Tax'+index).val(tx.toFixed(2));
                                        $('#GrandTotal'+index).val(gt.toFixed(2));
                                        $('#grandtotalhidden'+index).val(gt.toFixed(2));
                                        if(parseFloat(discountvals)>0 && parseFloat(grpsize)==1){
                                            discountEach();
                                        }
                                        CalculateGrandTotal();
                                    }
                                });
                            })(m);
                        });
                        
                        discountvals=$('#loyaltydiscountVal').val()||0;
                        rowService = $("#dynamicTable > tbody tr").length;
                        if(parseFloat(discountvals)>0 && parseFloat(grpsize)==1){
                            var discounteach=parseFloat(discountvals)/parseFloat(rowService);
                            $('.Discount').val(discounteach.toFixed(2));
                        }
                        renumberRows();
                        renumbermRows();
                        CalculateGrandTotal();
                    }
                });
            }
            $('#Group').select2
            ({
                placeholder: "Select Group here",
            });
            $('#PaymentTerm').select2
            ({
                placeholder: "Select Payment Term here",
            });
            $('#applicationid-error').html('');
        });

        $('#savefreeze').click(function() {
            var registerForm = $("#freezeform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/saveFreezeUnFreeze',
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
                    $('#savefreeze').text('Saving...');
                    $('#savefreeze').prop("disabled", true);
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
                    if (data.errorv2) {
                        for(var p=1;p<=f;p++){
                            var freezeday=($('#FreezeFor'+p)).val();
                            var statusflags=($('#StatusFlag'+p)).val();
                            if(($('#FreezeFor'+p).val())!=undefined && parseFloat(statusflags)==1){
                                if(freezeday=="" || freezeday==null || isNaN(parseFloat(freezeday))){
                                    $('#FreezeFor'+p).css("background",errorcolor);
                                }
                            } 
                        }
                        $('#savefreeze').text('Save');
                        $('#savefreeze').prop("disabled", false);
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }

                    else if(data.frozenerr)
                    {
                        var frozeninfo="";
                        $.each(data.frozenmem, function(index, value) {
                            frozeninfo+=value.Name+"    ,   "+value.ServiceName+"  ,   "+value.PeriodName+"</br>";
                        });
                        $('#savefreeze').text('Save');
                        $('#savefreeze').prop("disabled", false);
                        toastrMessage('error',"You cant update freeze day, because freeze day is less than remaining freeze day</br>---------------------</br>"+frozeninfo,"Error");
                    }
                    else if (data.dberrors) {
                        $('#savefreeze').text('Save');
                        $('#savefreeze').prop("disabled", false);
                        toastrMessage('error',"Error </br>"+data.dberrors,"Error");
                    }
                    else if(data.success){
                        $('#savefreeze').text('Save');
                        $('#savefreeze').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#laravel-datatable-crudmem').dataTable();
                        iTable.fnDraw(false);
                        $("#freezemodal").modal('hide');
                    }
                }
            });
        });

        $('#AppRegister').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var optype = $("#operationtypes").val();
            var grpamount = $("#GroupAmountVal").val();
            var renfsnum=0;
            //var registerForm = $("#Register");
            // var formData = registerForm.serialize();
            $.ajax({
                url: '/saveApp',
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
                    else if(parseFloat(optype)==3){
                        $('#savebutton').text('Renewing...');
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
                        if (data.errors.ApplicationType) {
                            $('#applicationtype-error').html(data.errors.ApplicationType[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.ApplicationsId) {
                            var text=data.errors.HealthStatus[0];
                            text = text.replace("applications id","fs/invoice number");
                            $('#applicationid-error').html(text);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            }   
                        }
                        if (data.errors.Group) {
                            $('#group-error').html(data.errors.Group[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            }   
                        }
                        if (data.errors.PaymentTerm) {
                            $('#paymentterm-error').html(data.errors.PaymentTerm[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.RegistationDate) {
                            var text=data.errors.RegistationDate[0];
                            text = text.replace("registation date", "start date");
                            $('#regdate-error').html(text);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.ExpiryDate) {
                            var text=data.errors.ExpiryDate[0];
                            text = text.replace("expiry date", "end date");
                            $('#expdatedate-error').html(text);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.Pos) {
                            $('#pos-error').html(data.errors.Pos[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            } 
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.VoucherType) {
                            $('#vouchertype-error').html(data.errors.VoucherType[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.mrc) {
                            $('#mrc-error').html(data.errors.mrc[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.PaymentType) {
                            $('#paymenttype-error').html(data.errors.PaymentType[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.VoucherNumber) {
                            $('#voucherNumber-error').html(data.errors.VoucherNumber[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            } 
                        }
                        if (data.errors.InvoiceNumber) {
                            $('#invoiceNumber-error').html(data.errors.InvoiceNumber[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
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
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
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
                            else if(parseFloat(optype)==3){
                                $('#savebutton').text('Renew');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.errorv2) {
                        for(var k=1;k<=b;k++){
                            var member=($('#Member'+k)).val();
                            var registrationdt=($('#RegistationDate'+k)).val();
                            var expiredt=($('#ExpiryDate'+k)).val();
                            if(($('#Member'+k).val())!=undefined){
                                if(member==""||member==null){
                                    $('#select2-Member'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#RegistationDate'+k).val())!=undefined){
                                if(registrationdt==""||registrationdt==null){
                                    $('#RegistationDate'+k).css("background",errorcolor);
                                }
                            }
                            if(($('#ExpiryDate'+k).val())!=undefined){
                                if(expiredt==""||expiredt==null){
                                    $('#ExpiryDate'+k).css("background",errorcolor);
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
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if (data.errorv3) {
                        for(var p=1;p<=m;p++){
                            var serv=($('#Service'+p)).val();
                            var perd=($('#Period'+p)).val();
                            var btax=($('#BeforeTax'+p)).val();
                            var tax=($('#Tax'+p)).val();
                            var gtotal=($('#GrandTotal'+p)).val();
                            var accontrol=($('#AccessControl'+p)).val();
                            if(($('#Service'+p).val())!=undefined){
                                if(serv=="" || serv==null || isNaN(parseFloat(serv))){
                                    $('#select2-Service'+p+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#Period'+p).val())!=undefined){
                                if(perd==""|| perd==null || isNaN(parseFloat(perd))){
                                    $('#select2-Period'+p+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#BeforeTax'+p).val())!=undefined){
                                if(btax==""||btax==null){
                                    $('#BeforeTax'+p).css("background",errorcolor);
                                }
                            }
                            if(($('#Tax'+p).val())!=undefined){
                                if(tax==""||tax==null){
                                    $('#Tax'+p).css("background",errorcolor);
                                }
                            }
                            if(($('#GrandTotal'+p).val())!=undefined){
                                if(gtotal==""||gtotal==null){
                                    $('#GrandTotal'+p).css("background",errorcolor);
                                }
                            }
                            if(($('#AccessControl'+p).val())!=undefined){
                                if(accontrol=="" || accontrol==null || isNaN(parseFloat(accontrol))){
                                    $('#select2-AccessControl'+p+'-container').parent().css('background-color',errorcolor);
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
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if (data.errorv4) {
                        for(var p=1;p<=s;p++){
                            var memberid=($('#Membertr'+p)).val();
                            var serv=($('#Servicetr'+p)).val();
                            var trainersv=($('#Trainertr'+p)).val();
                            var btax=($('#BeforeTaxtr'+p)).val();
                            var tax=($('#Tax'+p)).val();
                            var gtotal=($('#GrandTotal'+p)).val();
                            if(($('#Membertr'+p).val())!=undefined){
                                if(memberid=="" || memberid==null || isNaN(parseFloat(memberid))){
                                    $('#select2-Membertr'+p+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#Servicetr'+p).val())!=undefined){
                                if(serv=="" || serv==null || isNaN(parseFloat(serv))){
                                    $('#select2-Servicetr'+p+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#Trainertr'+p).val())!=undefined){
                                if(trainersv==""|| trainersv==null || isNaN(parseFloat(trainersv))){
                                    $('#select2-Trainertr'+p+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#BeforeTaxtr'+p).val())!=undefined){
                                if(btax==""||btax==null){
                                    $('#BeforeTaxtr'+p).css("background",errorcolor);
                                }
                            }
                            if(($('#Taxtr'+p).val())!=undefined){
                                if(tax==""||tax==null){
                                    $('#Taxtr'+p).css("background",errorcolor);
                                }
                            }
                            if(($('#GrandTotaltr'+p).val())!=undefined){
                                if(gtotal==""||gtotal==null){
                                    $('#GrandTotaltr'+p).css("background",errorcolor);
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
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if(data.emptymemerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"You should add atleast one client","Error");
                    }
                    else if(data.expirydateerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        $('#expdatedate-error').html("Expiry date should be greater than current date");
                        toastrMessage('error',"Unable to save this records, because the invoice is already expired","Error");
                    }
                    else if(data.renewmemerr)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"This record cannot be saved because the member has new transactions before please change invoice type to Renew.","Error");
                    }
                    else if(data.renewflagerr)
                    {
                        var memname="";
                        $.each(data.newmemberlist, function(index, value) {
                            memname+=value.MemInfo+"</br>";
                        });
                        
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Records cannot be saved because there is new client(s)</br>"+memname,"Error");
                    }
                    else if(data.renewcount)
                    {
                        var memname="";
                        $.each(data.memberlists, function(index, value) {
                            memname+=value.MemberName+"</br>";
                        });
                        
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"The client(s) lists below is renewed their service before</br>"+memname,"Error");
                    }
                    else if(data.emptytrerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"You should add atleast one service","Error");
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
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"You should add atleast one service","Error");
                    }  
                    else if(data.memerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Please choose <b>"+grpamount+"</b> clients from client selection section","Error");
                    }  
                    else if(data.duperror)
                    {
                        var memname="";
                        $.each(data.duperrorname, function(index, value) {
                            memname+=value.MemberService+"</br>";
                        });
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Client, service and period already exist</br>---------------------</br>"+memname+"<br>OR please select the last invoice from FS/ Invoice Number","Error");
                    }  
                    else if(data.frerror)
                    {
                        var frozeninfo="";
                        $.each(data.frerrorname, function(index, value) {
                            frozeninfo+=value.Name+"    ,   "+value.ServiceName+"  ,   "+value.PeriodName+"</br>";
                        });
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"There is a frozen services</br>---------------------</br>"+frozeninfo,"Error");
                    }
                    else if(data.exerror)
                    {
                        var extendedinfo="";
                        $.each(data.exerrorname, function(index, value) {
                            extendedinfo+=value.Name+"    ,   "+value.ServiceName+"  ,   "+value.PeriodName+"</br>";
                        });
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"There is a renewed client and services</br>---------------------</br>"+extendedinfo,"Error");
                    }    
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
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
                        else if(parseFloat(optype)==3){
                            $('#savebutton').text('Renew');
                            $('#savebutton').prop("disabled", false);
                        } 
                        $.ajax({
                            url: '/getlatestapp',
                            type: 'POST',
                            data:{
                                renfsnum:$('#VoucherNumber').val()||0,
                            },
                            success: function(data) {
                                $.each(data.getlastrec, function(key, value) {
                                    latestprop='<option value="'+value.id+'">'+value.FSNum+'   ,   '+value.MemberInfo+'   ,   '+value.ServiceInfo+'</option>';
                                    $('#ApplicationsId').append(latestprop);
                                });
                            }
                        });
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#laravel-datatable-crudmem').dataTable();
                        iTable.fnDraw(false);
                        closeRegisterModal();
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        //Start void application
        $('#voidbtn').click(function() {
            var recordId = $('#voididn').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showvoidinfo" + '/' + recordId, function(data) {
                $.each(data.appdataval, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if(statusvals=="Pending"||statusvals=="Active"||statusvals=="Verified"){
                    var registerForm = $("#voidreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/voidAppSett',
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
                            else if (data.memcnt) {
                                var memname="";
                                $.each(data.countMembers, function(index, value) {
                                    memname+=value.Name+"<br>";
                                });
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop("disabled", false);
                                toastrMessage('error',"The following client have an overlaped loyalty status <br>"+memname,"Error");
                                $("#voidreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            else if (data.dberrors) {
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop("disabled", false);
                                toastrMessage('error',"Error </br>Please try again!</br>"+data.dberrors,"Error");
                            }
                            else if (data.success) {
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop("disabled",true);
                                toastrMessage('success',"Invoice voided","Success");
                                $("#voidreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant void invoice on "+statusvals+" status","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End void application

        //Start refund application
        $('#refundbtn').click(function() {
            var recordId = $('#refundidn').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showvoidinfo" + '/' + recordId, function(data) {
                $.each(data.appdataval, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if(statusvals=="Pending"||statusvals=="Active"||statusvals=="Verified"){
                    var registerForm = $("#refundreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/refundAppSett',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#refundbtn').text('Refunding...');
                            $('#refundbtn').prop("disabled",true);
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
                                if (data.errors.RefundReason) {
                                    $('#refund-error').html(data.errors.RefundReason[0]);
                                }
                                $('#refundbtn').text('Refund');
                                $('#refundbtn').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            else if (data.memcnt) {
                                var memname="";
                                $.each(data.countMembers, function(index, value) {
                                    memname+=value.Name+"<br>";
                                });
                                $('#refundbtn').text('Refund');
                                $('#refundbtn').prop("disabled", false);
                                toastrMessage('error',"The following client have an overlaped loyalty status <br>"+memname,"Error");
                                $("#refundreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            else if (data.dberrors) {
                                $('#refundbtn').text('Refund');
                                $('#refundbtn').prop("disabled", false);
                                toastrMessage('error',"Error </br>Please try again!</br>"+data.dberrors,"Error");
                            }
                            else if (data.success) {
                                $('#refundbtn').text('Refund');
                                toastrMessage('success',"Invoice refunded","Success");
                                $("#refundreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else{
                    toastrMessage('error',"You cant refund invoice on "+statusvals+" status","Error");
                    $("#refundreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End refund application

        //Start undo void application
        //$('body').on('click', '#undovoidbtn', function() {
        $('#undovoidbtn').click(function() {
            var recordId = $('#undovoidid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showundovoidinfo" + '/' + recordId, function(data) {
                $.each(data.appundodata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if (statusvals=="Void"){
                    toastrMessage('error',"You cant undo void invoice, because base invoice is voided","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
                else{
                    var registerForm = $("#undovoidform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/undoAppSett',
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
                                toastrMessage('error',"FS/Doc number already taken by another record","Error");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            else if (data.undoinverror) {
                                $('#undovoidbtn').text('Undo Void');
                                $('#undovoidbtn').prop("disabled", false);
                                toastrMessage('error',"Invoice/Ref number already taken by another record","Error");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            // else if (data.memcnt) {
                            //     var memname="";
                            //     $.each(data.countMembers, function(index, value) {
                            //         memname+=value.Name+"<br>";
                            //     });
                            //     $('#undovoidbtn').text('Undo Void');
                            //     $('#undovoidbtn').prop("disabled", false);
                            //     toastrMessage('error',"The following client have an overlaped loyalty status <br>"+memname,"Error");
                            //     $("#undovoidmodal").modal('hide');
                            //     var oTable = $('#laravel-datatable-crud').dataTable();
                            //     oTable.fnDraw(false);
                            // }
                            else if (data.grpinv) {
                                var memname="";
                                $.each(data.grpMembers, function(index, value) {
                                    memname+=value.Name+"<br>";
                                });
                                $('#undovoidbtn').text('Undo Void');
                                $('#undovoidbtn').prop("disabled", false);
                                toastrMessage('error',"The following client have been in other group <br>"+memname,"Error");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            else if (data.dberrors) {
                                $('#undovoidbtn').text('Undo Void');
                                $('#undovoidbtn').prop("disabled", false);
                                toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                            }
                            else if (data.success) {
                                $('#undovoidbtn').text('Undo Void');
                                toastrMessage('success',"Successful","Success");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
            });
        });
        //End undo void application

        //Start undo refund application
        $('#undorefundbtn').click(function() {
            var recordId = $('#undorefundid').val();
            var settstatus=0;
            var statusvals="";
            $.get("/showundovoidinfo" + '/' + recordId, function(data) {
                $.each(data.appundodata, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if (statusvals=="Void"){
                    toastrMessage('error',"You cant undo refund invoice, because base invoice is voided or refunded","Error");
                    $("#undorefundmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
                else{
                    var registerForm = $("#undorefundform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/undoRefundAppSett',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#undorefundbtn').text('Changing...');
                            $('#undorefundbtn').prop("disabled",true);
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
                            if (data.memcnt) {
                                var memname="";
                                $.each(data.countMembers, function(index, value) {
                                    memname+=value.Name+"<br>";
                                });
                                $('#undorefundbtn').text('Undo Refund');
                                $('#undorefundbtn').prop("disabled", false);
                                toastrMessage('error',"The following client have an overlaped loyalty status <br>"+memname,"Error");
                                $("#undorefundmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            if (data.grpinv) {
                                var memname="";
                                $.each(data.grpMembers, function(index, value) {
                                    memname+=value.Name+"<br>";
                                });
                                $('#undorefundbtn').text('Undo Refund');
                                $('#undorefundbtn').prop("disabled", false);
                                toastrMessage('error',"The following client have been in other group <br>"+memname,"Error");
                                $("#undorefundmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                            if (data.success) {
                                $('#undorefundbtn').text('Undo Refund');
                                toastrMessage('success',"Successful","Success");
                                $("#undorefundmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
            });
        });
        //End undo refund application

        //Start change to verified
        $('#verifyappbtn').click(function() {
            var recordId = $('#checkedid').val();
            var settstatus=0;
            var statusvals="";
            var uploadval=0;
            var renewcnts=0;
            $.get("/showvoidinfo" + '/' + recordId, function(data) {
                uploadval=data.upcnt;
                renewcnts=data.renewcnt;
                $.each(data.appdataval, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                if(parseFloat(uploadval)==0){
                    toastrMessage('error',"Please upload application document before verifying an invoice","Error");
                    $("#applicationverifymodal").modal('hide');
                    $("#applicationinfomodal").modal('hide');
                }
                else if(parseFloat(renewcnts)>=1){
                    toastrMessage('error',"Please verify the base invoice first","Error");
                    $("#applicationverifymodal").modal('hide');
                    $("#applicationinfomodal").modal('hide');
                }
                else if(statusvals=="Pending" && parseFloat(uploadval)>=1 && parseFloat(renewcnts)==0){
                    var registerForm = $("#verifyapplicationform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/verifyAppStatus',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#verifyappbtn').text('Verifying...');
                            $('#verifyappbtn').prop("disabled", true);
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
                            if (data.dberrors) {
                                $('#verifyappbtn').text('Verify');
                                $('#verifyappbtn').prop("disabled",false);
                                toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                            }
                            else if (data.success) {
                                $('#verifyappbtn').text('Verify');
                                toastrMessage('success',"Invoice verified","Success");
                                $("#applicationverifymodal").modal('hide');
                                $("#applicationinfomodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else if(statusvals!="Pending"){
                    toastrMessage('error',"You cant verify invoice on "+statusvals+" status","Error");
                    $("#applicationverifymodal").modal('hide');
                    $("#applicationinfomodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End change to verified

        //Start send to device
        $('#sendtodevbtn').click(function() {
            var recordId = $('#sendappid').val();
            var settstatus=0;
            var statusvals="";
            var uploadval=0;
            var renewcnts=0;
            $.get("/showvoidinfo" + '/' + recordId, function(data) {
                uploadval=data.upcnt;
                renewcnts=data.renewcnt;
                $.each(data.appdataval, function(key, value) {
                    settstatus=value.Status;
                    statusvals=value.Status;
                });
                
                if(statusvals=="Pending"){
                    var registerForm = $("#sendtodeviceform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/sendToDevice',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#sendtodevbtn').text('Sending...');
                            $('#sendtodevbtn').prop("disabled", true);
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
                            if (data.dberrors) {
                                $('#sendtodevbtn').text('Send');
                                $('#sendtodevbtn').prop("disabled",false);
                                toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                            }
                            else if (data.success) {
                                $('#sendtodevbtn').text('Send');
                                toastrMessage('success',"Successful","Success");
                                $("#sendtodevicemodal").modal('hide');
                                $("#applicationinfomodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
                else if(statusvals!="Pending"){
                    toastrMessage('error',"You cant send client to device on "+statusvals+" status","Error");
                    $("#sendtodevicemodal").modal('hide');
                    $("#applicationinfomodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });
        //End send to device

        //Start sync all clients 
        $('#syncmemberbtn').click(function() {
            var registerForm = $("#syncmemberform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/syncClients',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#syncmemberbtn').text('Syncing...');
                    $('#syncmemberbtn').prop("disabled", true);
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
                    if (data.dberrors) {
                        $('#syncmemberbtn').text('Sync');
                        $('#syncmemberbtn').prop("disabled",false);
                        toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                    }
                    else if (data.success) {
                        $('#syncmemberbtn').text('Sync');
                        toastrMessage('success',"Successful","Success");
                        $("#syncmembermodal").modal('hide');
                    }
                },
            });     
        });
        //End sync all clients

        //Start send to device
        $('#synctodevicesbtn').click(function() {
            var recordId = $('#syncmemid').val();

            var registerForm = $("#synctodeviceform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/syncToDevice',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#synctodevicesbtn').text('Syncing...');
                    $('#synctodevicesbtn').prop("disabled", true);
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
                    if (data.dberrors) {
                        $('#synctodevicesbtn').text('Sync');
                        $('#synctodevicesbtn').prop("disabled",false);
                        toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                    }
                    else if (data.success) {
                        var memcount=data.memcnt;
                        $('#synctodevicesbtn').text('Sync');
                        toastrMessage('success',memcount+" service(s) with client synced ","Success");
                        $("#synctodevicemodal").modal('hide');
                    }
                },
            });
        });
        //End send to device

        $("#addsm").click(function() {
            var lastrowcount=$('#dynamicTablem tr:last').find('td').eq(1).find('input').val();
            var mem=$('#Member'+lastrowcount).val();
            var lostatus=$('#LoyalityStatus'+lastrowcount).val();
            var grp=$('#Group').val();
            var pterm=$('#PaymentTerm').val();
            var grpval=$('#GroupAmountVal').val();
            var rowCount = $("#dynamicTablem > tbody tr").length;
            
            if(isNaN(parseFloat(grp)) || isNaN(parseFloat(pterm))){
                if(isNaN(parseFloat(grp))){
                    $('#group-error').html("Group field is required");
                }
                if(isNaN(parseFloat(pterm))){
                    $('#paymentterm-error').html("Period field is required");
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if((mem!==undefined && isNaN(parseFloat(mem)))){
                if(mem!==undefined && isNaN(parseFloat(mem))){
                    $('#select2-Member'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
           
            else if(parseFloat(rowCount)>=parseFloat(grpval)){
                toastrMessage('error',"You included all clients for the chosen group amount","Error");
            }
            else{
                ++a;
                ++b;
                ++c;
                $("#dynamicTablem > tbody").append('<tr id="rowindm'+b+'"><td style="font-weight:bold;width:3%;text-align:center;">'+c+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="rowm['+b+'][valsm]" id="valsm'+b+'" class="valsm form-control" readonly="true" style="font-weight:bold;" value="'+b+'"/></td>'+
                    '<td style="width:61%;"><select id="Member'+b+'" class="select2 form-control form-control Member" onchange="MemberFn(this)" name="rowm['+b+'][member_id]"></select></td>'+
                    '<td style="width:14%;"><input type="text" name="rowm['+b+'][MemberId]" placeholder="Client ID" id="MemberId'+b+'" class="MemberId form-control" readonly/></td>'+
                    '<td style="width:14%;"><input type="text" name="rowm['+b+'][LoyalityStatus]" placeholder="Loyality Status" id="LoyalityStatus'+b+'" class="LoyalityStatus form-control" readonly/></td>'+
                    '<td style="width:8%;text-align:center;"><button type="button" id="viewbtn'+b+'" class="viewcls btn btn-light btn-sm" style="display:none;color:#00cfe8 ;background-color:#FFFFFF;border-color:#FFFFFF" onmouseover="viewPic(this)"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button><button type="button" id="removebtnm'+b+'" class="btn btn-light btn-sm removem-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+                    
                    '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberCount]" placeholder="Member Count ID" id="MemberCount'+b+'" class="MemberCount form-control" readonly/></td>'+
                    '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberName]" placeholder="Member Name" id="MemberName'+b+'" class="MemberName form-control" readonly/></td>'+
                    '<td style="display:none;"><input type="text" name="rowm['+b+'][StayDay]" placeholder="Stay Day" id="StayDay'+b+'" class="StayDay form-control" readonly/></td>'+
                    '<td style="display:none;"><input type="text" name="rowm['+b+'][StayDayRenew]" placeholder="Stay Day Renew" id="StayDayRenew'+b+'" class="StayDayRenew form-control" value="0" readonly/></td>'+
                    '<td style="display:none;"><input type="text" name="rowm['+b+'][loyaltydiscountval]" placeholder="loyaltydiscountval" id="loydiscount'+b+'" value="0" class="LoyaltyDiscount form-control" readonly/></td>'+
                    '<td style="display:none;"><input type="text" name="rowm['+b+'][MemberPic]" placeholder="Member Pic" id="MemberPic'+b+'" class="MemberPic form-control" readonly/></td></tr>'
                );
                
                $('#Member'+b).empty();
                var defmopt = '<option selected value=""></option>';
                var memberlist = $("#membercbx > option").clone();
                $('#Member'+b).append(memberlist);
                $('#Member'+b).append(defmopt);
                for(var k=1;k<=b;k++){
                    if(($('#Member'+k).val())!=undefined){
                        var selectedval=$('#Member'+k).val();
                        $("#Member"+b+" option[value='"+selectedval+"']").remove();   
                    }
                } 
                $('#Member'+b).append(defmopt);
                $('#Member'+b).select2
                ({
                    placeholder: "Select Client here",
                });
                flatpickr('#RegistationDate'+b, { dateFormat: 'Y-m-d'});
                renumbermRows();
                $('#select2-Member'+b+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        $(document).on('click', '.removem-tr', function() {
            $(this).parents('tr').remove();
            var defopt = '<option selected disabled value=""></option>';
            var memberidval=$(this).parents('tr').find('td').eq(2).find('select').val();
            var lastrowcount=$('#dynamicTablem tr:last').find('td').eq(1).find('input').val();
            var loyaltydisval=$('#loydiscount'+lastrowcount).val()||0;
            $('#loyaltydiscountVal').val(loyaltydisval);
            if(!isNaN(parseFloat(memberidval))){
                $(".Period option[value='']").remove();  
                $('.Period').append(defopt);
                $('.BeforeTax').val("");
                $('.Tax').val("");
                $('.GrandTotal').val("");
                $('.grandtotalhidden').val("");
                $('.Discount').val("");
                $('.DiscountAmount').val("");
                $('.Period').select2
                ({
                    placeholder: "Select Period here",
                });
            }
            CalculateGrandTotal();
            renumbermRows();
            --a;
        });

        function renumbermRows() {
            var indx;
            $('#dynamicTablem tr').each(function(indxx,el) {
                $(this).children('td').first().text(indxx++);
                $('#numberofItemsLblm').html(indxx-1);
                indx = indxx-1;
            });
            if (indx == 0) {
               $('.totalrownumberm').hide();
            } else {
               $('.totalrownumberm').show();
            }
        }
        
        $("#addser").click(function() {
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var srv=$('#Service'+lastrowcount).val();
            var prd=$('#Period'+lastrowcount).val();
            var grp=$('#Group').val();
            var pterm=$('#PaymentTerm').val();
            var grpval=$('#GroupAmountVal').val();
            var rowCount = $("#dynamicTablem > tbody tr").length;
            var memcntval=0;
            for(var k=1;k<=b;k++){
                var member=($('#Member'+k)).val();
                if(($('#Member'+k).val())!=undefined){
                    if(member==""||member==null || isNaN(parseFloat(member))){
                        memcntval+=parseFloat(1);
                    }
                } 
            }
            if(isNaN(parseFloat(grp)) || isNaN(parseFloat(pterm))){
                if(isNaN(parseFloat(grp))){
                    $('#group-error').html("Group field is required");
                }
                if(isNaN(parseFloat(pterm))){
                    $('#paymentterm-error').html("Period field is required");
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if((srv!==undefined && isNaN(parseFloat(srv))) || (prd!==undefined && isNaN(parseFloat(prd)))){
                if(srv!==undefined && isNaN(parseFloat(srv))){
                    $('#select2-Service'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(prd!==undefined && isNaN(parseFloat(prd))){
                    $('#select2-Period'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else if(parseFloat(rowCount)!=parseFloat(grpval)){
                toastrMessage('error',"The selected client and chosen group amount doesnt mactch","Error");
            }
            else if(parseFloat(memcntval)>=1){
                for(var y=1;y<=b;y++){
                    var member=($('#Member'+y)).val();
                    if(($('#Member'+y).val())!=undefined){
                        if(member==""||member==null || isNaN(parseFloat(member))){
                            $('#select2-Member'+y+'-container').parent().css('background-color',errorcolor);
                        }
                    } 
                }
                toastrMessage('error',"Please choose clients on highlighted fields","Error");
            }
            else{
                ++i;
                ++m;
                ++j;
                
                $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="width:16%;"><select id="Service'+m+'" class="select2 form-control form-control Service" onchange="serviceFn(this)" name="row['+m+'][service_id]"></select></td>'+
                    '<td style="width:16%;"><select id="Period'+m+'" class="select2 form-control form-control Period" onchange="periodFn(this)" name="row['+m+'][period_id]"></select></td>'+
                    '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][BeforeTax]" placeholder="Before Tax" id="BeforeTax'+m+'" class="BeforeTax form-control numeral-mask" onkeyup="CalculateBTServicePrice(this)" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][Tax]" placeholder="Tax" id="Tax'+m+'" class="Tax form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="width:11%;"><input type="number" step="any" name="row['+m+'][GrandTotal]" placeholder="Grand Total" id="GrandTotal'+m+'" class="GrandTotal form-control numeral-mask" onkeyup="CalculateGTServicePrice(this)" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td style="width:12%;"><input type="number" step="any" name="row['+m+'][Discount]" placeholder="Discount Percent" id="Discount'+m+'" class="Discount form-control numeral-mask" onkeyup="discountFn(this)" @can('Invoice-Apply-Discount') ondblclick="discountActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td style="width:16%;"><select id="AccessControl'+m+'" class="select2 form-control form-control AccessControl" onchange="acControlFn(this)" name="row['+m+'][AccessControl]"></select></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="number" step="any" name="row['+m+'][DiscountAmount]" placeholder="DiscountAmount" id="DiscountAmount'+m+'" class="DiscountAmount form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="display:none;"><input type="number" step="any" name="row['+m+'][grandtotalhidden]" placeholder="grandtotalhidden" id="grandtotalhidden'+m+'" class="grandtotalhidden form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="display:none;"><input type="number" step="any" name="row['+m+'][hiddengrandtotalamount]" placeholder="hiddengrandtotalamount" id="hiddengrandtotalamount'+m+'" class="hiddengrandtotalamount form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td></tr>'
                );
                
                var defopt = '<option selected value=""></option>';
                var servicelist = $("#servicecbx > option").clone();
                var devicelist = $("#devicecbx > option").clone();
                $('#Service'+m).append(servicelist);
                $("#Service"+m+" option[label!='"+grp+"']").remove();
                $("#Service"+m+" option[title!='"+pterm+"']").remove();
                $('#Service'+m).append(defopt);
                
                for(var k=1;k<=m;k++){
                    if(($('#Service'+k).val())!=undefined){
                        var selectedval=$('#Service'+k).val();
                        $("#Service"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#Service'+m).append(defopt);
                $('#Service'+m).select2
                ({
                    placeholder: "Select Service here",
                });

                $('#Period'+m).append(defopt);
                $('#Period'+m).select2
                ({
                    placeholder: "Select Service first",
                });
                var accesscontrol = '';
                $('#AccessControl'+m).append(devicelist);
                $('#AccessControl'+m).append(defopt);
                $('#AccessControl'+m).select2
                ({
                    placeholder: "Access Control",
                });
                renumberRows();
                $('#select2-Service'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Period'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-AccessControl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        $(document).on('click', '.remove-tr', function() {
            var discountvals=$('#loyaltydiscountVal').val()||0;
            $(this).parents('tr').remove();
            var rowService = $("#dynamicTable > tbody tr").length;
            if(parseFloat(discountvals)>0){
                var discounteach=parseFloat(discountvals)/parseFloat(rowService);
                $('.Discount').val(discounteach.toFixed(2));
                discountEach();
            }
            CalculateGrandTotal();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index,el) {
                $(this).children('td').first().text(index++);
                $('#numberofItemsLbl').html(index-1);
                ind = index-1;
            });
            if (ind == 0) {
               $('.totalrownumber').hide();
            } else {
               $('.totalrownumber').show();
            }
        }

        $(document).on('click', '.removetr-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotalTr();
            renumberRowsTr();
            --r;
        });

        function renumberRowsTr() {
            var ind;
            $('#dynamicTableTrn tr').each(function(index,el) {
                $(this).children('td').first().text(index++);
                $('#numberofItemsLbl').html(index-1);
                ind = index-1;
            });
            if (ind == 0) {
               $('.totalrownumber').hide();
            } else {
               $('.totalrownumber').show();
            }
        }

        $("#addstr").click(function() {
            var lastrowcount=$('#dynamicTableTrn tr:last').find('td').eq(1).find('input').val();
            var srv=$('#Servicetr'+lastrowcount).val();
            var mem=$('#Membertr'+lastrowcount).val();
            var trn=$('#Trainertr'+lastrowcount).val();
            var grp=$('#Group').val();
            var pterm=$('#PaymentTerm').val();
            var applicationId=$('#ApplicationsId').val();
            var grpval=$('#GroupAmountVal').val();
            var rowCount = $("#dynamicTableTrn > tbody tr").length;
            var memcntval=0;
            if(isNaN(parseFloat(grp)) || isNaN(parseFloat(pterm))){
                if(isNaN(parseFloat(grp))){
                    $('#group-error').html("Group field is required");
                }
                if(isNaN(parseFloat(pterm))){
                    $('#paymentterm-error').html("Period field is required");
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            
            else if((mem!==undefined && isNaN(parseFloat(mem))) || (srv!==undefined && isNaN(parseFloat(srv))) || (trn!==undefined && isNaN(parseFloat(trn)))){
                if(mem!==undefined && isNaN(parseFloat(mem))){
                    $('#select2-Membertr'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(srv!==undefined && isNaN(parseFloat(srv))){
                    $('#select2-Servicetr'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(trn!==undefined && isNaN(parseFloat(trn))){
                    $('#select2-Trainertr'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please insert a valid data on highlighted fields","Error");
            }

            else{
                ++q;
                ++s;
                ++r;
                $("#dynamicTableTrn > tbody").append('<tr id="rowTrnsind'+s+'"><td style="font-weight:bold;width:3%;text-align:center;">'+r+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="rowTrn['+s+'][vals]" id="valstrn'+s+'" class="valstr form-control" readonly="true" style="font-weight:bold;" value="'+s+'"/></td>'+
                    '<td style="width:15%;"><select id="Membertr'+s+'" class="select2 form-control form-control Membertr" onchange="MemberTrFn(this)" name="rowTrn['+s+'][member_id]"></select></td>'+
                    '<td style="width:10%;"><input type="text" name="rowTrn['+s+'][MemberId]" placeholder="Client ID" id="MemberIdtr'+s+'" class="MemberIdtr form-control" readonly/></td>'+
                    '<td style="width:14%;"><select id="Servicetr'+s+'" class="select2 form-control form-control Servicetr" onchange="serviceTrFn(this)" name="rowTrn['+s+'][service_id]"></select></td>'+
                    '<td style="width:15%;"><select id="Trainertr'+s+'" class="select2 form-control form-control Trainertr" onchange="trainerFn(this)" name="rowTrn['+s+'][employes_id]"></select></td>'+
                    '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][BeforeTax]" placeholder="Before Tax" id="BeforeTaxtr'+s+'" class="BeforeTaxtr form-control numeral-mask" onkeyup="CalculateBTServicePriceTr(this)" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][Tax]" placeholder="Tax" id="Taxtr'+s+'" class="Taxtr form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][GrandTotal]" placeholder="Grand Total" id="GrandTotaltr'+s+'" class="GrandTotaltr form-control numeral-mask" onkeyup="CalculateGTServicePriceTr(this)" onkeypress="return ValidateNum(event);" @can('Invoice-Edit-Price') ondblclick="priceActiveFn(this)"; @endcan readonly style="font-weight:bold;"/></td>'+
                    '<td style="width:10%;"><input type="number" name="rowTrn['+s+'][Discount]" placeholder="Discount Percent" id="Discounttr'+s+'" class="Discounttr form-control numeral-mask" onkeyup="discountTrFn(this)" @can('Invoice-Apply-Discount') ondblclick="discountActiveFn(this)"; @endcan readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+s+'" class="btn btn-light btn-sm removetr-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="number" name="rowTrn['+s+'][period_id]" placeholder="Periodtr" id="periodtr'+s+'" class="periodtr form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="display:none;"><input type="number" name="rowTrn['+s+'][DiscountAmount]" placeholder="DiscountAmounttr" id="DiscountAmounttr'+s+'" class="DiscountAmounttr form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="display:none;"><input type="number" name="rowTrn['+s+'][grandtotalhidden]" placeholder="grandtotalhiddentr" id="grandtotalhiddentr'+s+'" class="grandtotalhiddentr form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="display:none;"><input type="number" name="rowTrn['+s+'][hiddengrandtotalamount]" placeholder="hiddengrandtotalamounttr" id="hiddengrandtotalamounttr'+s+'" class="hiddengrandtotalamounttr form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td></tr>'
                );
                var defmopt = '<option selected value=""></option>';
                var memberlist = $("#membershipcbx > option").clone();
                $('#Membertr'+s).append(memberlist);
                $("#Membertr"+s+" option[title!='"+applicationId+"']").remove();
                $('#Membertr'+s).append(defmopt);
                // for(var k=1;k<=s;k++){
                //     if(($('#Membertr'+k).val())!=undefined){
                //         var selectedval=$('#Membertr'+k).val();
                //         $("#Membertr"+s+" option[value='"+selectedval+"']").remove();   
                //     }
                // } 
                
                $('#Membertr'+s).select2
                ({
                    placeholder: "Select Client here",
                });

                $('#Servicetr'+s).append(defmopt);
                $('#Servicetr'+s).select2
                ({
                    placeholder: "Select Client first",
                });

                $('#Trainertr'+s).append(defmopt);
                $('#Trainertr'+s).select2
                ({
                    placeholder: "Select Service first",
                });
                $('#hiddenLasttrid').val(s);
                renumberRowsTr();
                $('#select2-Membertr'+s+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Servicetr'+s+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Trainertr'+s+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        function serviceFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var servicepr=$(ele).closest('tr').find('.Service').val();
            var grp=$('#Group').val();
            var pterm=$('#PaymentTerm').val();
            var defopt = '<option selected value=""></option>';
            var arr = [];
            var found = 0;
            $('.Service').each (function() 
            { 
                var name=$(this).val();
                if(arr.includes(name))
                found++;
                else
                arr.push(name);
            });
            if(found) {
                toastrMessage('error',"Service already exist","Error");
                $('#Period'+idval).empty();
                $(ele).closest('tr').find('.BeforeTax').val("");
                $(ele).closest('tr').find('.Tax').val("");
                $(ele).closest('tr').find('.GrandTotal').val("");
                $(ele).closest('tr').find('.Discount').val("");
                $(ele).closest('tr').find('.DiscountAmount').val("");
                $(ele).closest('tr').find('.grandtotalhidden').val("");
                $("#Service"+idval+" option[value='"+servicepr+"']").remove();
                $('#Service'+idval).append(defopt);
                $('#Service'+idval).select2
                ({
                    placeholder: "Select Service here",
                });
                $('#select2-Service'+idval+'-container').parent().css('background-color',errorcolor);
                CalculateGrandTotal();
            }
            else{
                $('#Period'+idval).empty();
                var options = $("#periodcbx > option").clone();
                $('#Period'+idval).append(options);
                $("#Period"+idval+" option[label!='"+grp+"']").remove();
                $("#Period"+idval+" option[title!='"+pterm+"']").remove();
                $("#Period"+idval+" option[accesskey!='"+servicepr+"']").remove();
                $('#Period'+idval).append(defopt);
                $('#Period'+idval).select2
                ({
                    placeholder: "Select Period here",
                });
                $('#select2-Service'+idval+'-container').parent().css('background-color',"white");
                $(ele).closest('tr').find('.BeforeTax').val("");
                $(ele).closest('tr').find('.Tax').val("");
                $(ele).closest('tr').find('.GrandTotal').val("");
                $(ele).closest('tr').find('.grandtotalhidden').val("");
                $(ele).closest('tr').find('.Discount').val("");
                CalculateGrandTotal();
            }  
        }

        function acControlFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#select2-AccessControl'+idval+'-container').parent().css('background-color',"white");
        }

        function trainerFn(ele) {
            var idval = $(ele).closest('tr').find('.valstr').val();
            $('#select2-Trainertr'+idval+'-container').parent().css('background-color',"white");
        }

        function serviceTrFn(ele) {
            var idval = $(ele).closest('tr').find('.valstr').val();
            var servicepr=$(ele).closest('tr').find('.Servicetr').val();
            var grp=$('#Group').val();
            var pterm=$('#PaymentTerm').val();
            var defopt = '<option selected value=""></option>';
            var applicationId=$('#ApplicationsId').val();
            var inputid = ele.getAttribute('id');
            var arr = [];
            var found = 0;
            var periodpr="";
            var grp="";
            var pterm="";
            var options="";
            var memberid="";
            var subtotal=0;
            var tax=0;
            var grandtotal=0;
            var grandtotalnet=0;
            var ssubtotal=0;
            var stax=0;
            var sgrandtotal=0;
            var newgrandtotalnet=0;
            var oldsgrandtotalnet=0;
            var memberflag=0;
            var numoftotalmem="";
            var numofmem="";
            $('.Servicetr').each (function() 
            { 
                var name=$(this).val();
                if(arr.includes(name))
                found++;
                else
                arr.push(name);
            });
            if(found) {
                toastrMessage('error',"Service already exist","Error");
                $('#Period'+idval).empty();
                $(ele).closest('tr').find('.BeforeTaxtr').val("");
                $(ele).closest('tr').find('.Taxtr').val("");
                $(ele).closest('tr').find('.GrandTotaltr').val("");
                $(ele).closest('tr').find('.Discounttr').val("");
                $(ele).closest('tr').find('.DiscountAmounttr').val("");
                $(ele).closest('tr').find('.grandtotalhiddentr').val("");
                $("#Servicetr"+idval+" option[value='"+servicepr+"']").remove();
                $('#Servicetr'+idval).append(defopt);
                $('#Servicetr'+idval).select2
                ({
                    placeholder: "Select Service here",
                });
                $('#select2-Servicetr'+idval+'-container').parent().css('background-color',errorcolor);
                CalculateGrandTotalTr();
            }
            else{
                $.ajax({
                    url: '/getServicePeriod',
                    type: 'POST',
                    data:{
                        applicationId:$('#ApplicationsId').val(),
                        servicepr : $(ele).closest('tr').find('.Servicetr').val(),
                        memberid : $(ele).closest('tr').find('.Membertr').val(),
                        grp : $('#Group').val(),
                        pterm : $('#PaymentTerm').val(),
                    },
                    success: function(data) {
                        $(ele).closest('tr').find('.periodtr').val(data.periodid);
                        $.each(data.applist, function(key, value) {
                            grandtotalnet=parseFloat(value.TrainerFee||0);
                            subtotal=parseFloat(grandtotalnet)/1.15;
                            tax=parseFloat(grandtotalnet)-parseFloat(subtotal);
                            $(ele).closest('tr').find('.BeforeTaxtr').val(subtotal.toFixed(2));
                            $(ele).closest('tr').find('.Taxtr').val(tax.toFixed(2));
                            $(ele).closest('tr').find('.GrandTotaltr').val(grandtotalnet.toFixed(2));
                            $(ele).closest('tr').find('.grandtotalhiddentr').val(grandtotalnet.toFixed(2));
                            CalculateGrandTotalTr();
                        });
                    }
                });
                $('#Trainertr'+idval).empty();
                var options = $("#trainercbx > option").clone();
                $('#Trainertr'+idval).append(options);
                $("#Trainertr"+idval+" option[title!='"+servicepr+"']").remove();
                $('#Trainertr'+idval).append(defopt);
                $('#Trainertr'+idval).select2
                ({
                    placeholder: "Select Trainer here",
                });
                $('#select2-Servicetr'+idval+'-container').parent().css('background-color',"white");
                $('#BeforeTaxtr'+idval).css('background-color',"#efefef");
                $('#Taxtr'+idval).css('background-color',"#efefef");
                $('#GrandTotaltr'+idval).css('background-color',"#efefef");
                CalculateGrandTotalTr();
                $('#select2-Trainertr'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }  
        }

        function statusFn(ele) {
            var idval = $(ele).closest('tr').find('.valstr').val();
            var statusval=$(ele).closest('tr').find('.Status').val();
            if(statusval=="Frozen"){
                $("#FreezeFor"+idval).prop("readonly",false);
                $("#StatusFlag"+idval).val("1");
                $("#FreezeFor"+idval).val("");
            }
            else if(statusval=="Active"){
                $("#FreezeFor"+idval).prop("readonly",true);
                $("#FreezeFor"+idval).val("0");
            }
            else if(statusval==0){
                $("#FreezeFor"+idval).prop("readonly",true);
                $("#StatusFlag"+idval).val("0");
                $("#FreezeFor"+idval).val("");
            }
        }

        function freezeFn(ele) {
            var idval = $(ele).closest('tr').find('.valstr').val();
            var freezeforval=$(ele).closest('tr').find('.FreezeFor').val();
            $('#FreezeFor'+idval).css("background","white");
            if(parseFloat(freezeforval)==0 || isNaN(parseFloat(freezeforval))){
                $("#FreezeFor"+idval).val("");
            }
        }

        function periodFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var rowCount = $("#dynamicTablem > tbody tr").length;
            var rowService = $("#dynamicTable > tbody tr").length;
            var grpamount=$('#GroupAmountVal').val();
            var discountvals=$('#loyaltydiscountVal').val()||0;
            var defopt = '<option selected value=""></option>';
            var servicepr="";
            var periodpr="";
            var grp="";
            var pterm="";
            var options="";
            var subtotal=0;
            var tax=0;
            var grandtotal=0;
            var grandtotalnet=0;
            var ssubtotal=0;
            var stax=0;
            var sgrandtotal=0;
            var newgrandtotalnet=0;
            var oldsgrandtotalnet=0;
            var memberflag=0;
            var numoftotalmem="";
            var numofmem="";
            var apptype=$('#ApplicationType').val();
            var numofnull=0;
            $.each($('#dynamicTablem').find('.MemberCount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    memberflag += parseFloat($(this).val());
                }
            });
            for(var k=1;k<=b;k++){
                var member=($('#Member'+k)).val();
                if(($('#Member'+k).val())!=undefined){
                    if(member==""||member==null){
                        numofnull+=parseFloat(1);
                    }
                }
            }

            if(parseFloat(rowCount)!=parseFloat(grpamount)){
                $("#Period"+idval+" option[value='']").remove();  
                toastrMessage('error',"Group and selected client doesnt match","Error");
                $(ele).closest('tr').find('.Period').append(defopt);
            }
            else if(parseFloat(numofnull)>=1){
                for(var k=1;k<=b;k++){
                    var member=($('#Member'+k)).val();
                    if(($('#Member'+k).val())!=undefined){
                        if(member==""||member==null){
                            $('#select2-Member'+k+'-container').parent().css('background-color',errorcolor);
                        }
                    }
                }
                $("#Period"+idval+" option[value='']").remove();  
                toastrMessage('error',"Please select a client from highlighted field","Error");
                $(ele).closest('tr').find('.Period').append(defopt);
            }
            else{
                $.ajax({
                    url: '/paymentlist',
                    type: 'POST',
                    data:{
                        servicepr : $(ele).closest('tr').find('.Service').val(),
                        grp:$('#Group').val(),
                        pterm:$('#PaymentTerm').val(),
                        periodpr:$(ele).closest('tr').find('.Period').val(),
                        numoftotalmem:rowCount,
                        numofmem:memberflag,
                        apptype:$('#ApplicationType').val(),
                    },
                    
                    success: function(data) {
                        $.each(data.plist, function(key, value) {//existing member
                            oldsgrandtotalnet=parseFloat(value.MemberPrice||0)-parseFloat(value.Discount||0);
                        });
                        $.each(data.singledata, function(key, value) {//new member
                            newgrandtotalnet=parseFloat(value.NewMemberPrice||0)-parseFloat(value.NewMemDiscount||0);
                        });
                        grandtotalnet=parseFloat(oldsgrandtotalnet)+parseFloat(newgrandtotalnet);
                        subtotal=parseFloat(grandtotalnet)/1.15;
                        tax=parseFloat(grandtotalnet)-parseFloat(subtotal);
                        $(ele).closest('tr').find('.BeforeTax').val(subtotal.toFixed(2));
                        $(ele).closest('tr').find('.Tax').val(tax.toFixed(2));
                        $(ele).closest('tr').find('.GrandTotal').val(grandtotalnet);
                        $(ele).closest('tr').find('.grandtotalhidden').val(grandtotalnet);
                        if(parseFloat(discountvals)>0 && parseFloat(memberflag)==1){
                            var discounteach=parseFloat(discountvals)/parseFloat(rowService);
                            $('.Discount').val(discounteach.toFixed(2));
                            discountEach();
                        }

                        if(parseFloat(grandtotalnet)==0){
                            toastrMessage('error',"Price is not found or deactivated","Error");
                            $(ele).closest('tr').find('.BeforeTax').val("");
                            $(ele).closest('tr').find('.Tax').val("");
                            $(ele).closest('tr').find('.GrandTotal').val("");
                            $(ele).closest('tr').find('.grandtotalhidden').val("");
                        }
                        CalculateGrandTotal();
                    }
                });
                $('#BeforeTax'+idval).css("background","#efefef");
                $('#Tax'+idval).css("background","#efefef");
                $('#GrandTotal'+idval).css("background","#efefef");
                $('#BeforeTax'+idval).prop("readonly", true);
                $('#GrandTotal'+idval).prop("readonly", true);
                $('#select2-Period'+idval+'-container').parent().css('background-color',"white");
            }
        }

        function MemberFn(ele) {
            var mrid = $(ele).closest('tr').find('.Member').val();
            var idval = $(ele).closest('tr').find('.valsm').val();
            var defopt = '<option selected value=""></option>';
            var grpamount=$('#GroupAmountVal').val();
            var appid="";
            var memId="";
            var arr = [];
            var found = 0;
            var groupinvolve=0;
            $('#loyaltydiscountVal').val("");

            $('.Member').each (function() 
            { 
                var name=$(this).val();
                if(arr.includes(name))
                found++;
                else
                arr.push(name);
            });

            if(found) 
            {
                toastrMessage('error',"Client already exist","Error");
                $(ele).closest('tr').find('.Member').val("0").trigger('change');
                $(ele).closest('tr').find('.MemberName').val("");
                $(ele).closest('tr').find('.LoyalityStatus').val("");
                $(ele).closest('tr').find('.MemberId').val("");
                $('#select2-Member'+idval+'-container').parent().css('background-color',errorcolor);
                $('#viewbtn'+idval).hide();
                CalculateGrandTotal();
            }
            else{
                $.ajax({
                    url: '/memberListinfo',
                    type: 'POST',
                    data:{
                        memId : $(ele).closest('tr').find('.Member').val(),
                        appid : $('#ApplicationsId').val()||0,
                    },
                    success: function(data) {
                        groupinvolve=data.grpinv;
                        $(ele).closest('tr').find('.MemberCount').val(data.memcnt);
                        $.each(data.mtlist, function(key, value) {
                            // if(value.LoyalityStatus!="Bronze" && parseFloat(grpamount)>1){
                            //     $(ele).closest('tr').find('.Member').val("0").trigger('change');
                            //     $(ele).closest('tr').find('.MemberName').val("");
                            //     $(ele).closest('tr').find('.LoyalityStatus').val("");
                            //     $(ele).closest('tr').find('.MemberId').val("");
                            //     toastrMessage('error',"This client can not be included in group, on "+value.LoyalityStatus+" status","Error");
                            //     $('#select2-Member'+idval+'-container').parent().css('background-color',errorcolor);
                            // }
                            if(parseFloat(groupinvolve)>0 && parseFloat(grpamount)>1){
                                $(ele).closest('tr').find('.Member').val("0").trigger('change');
                                $(ele).closest('tr').find('.MemberName').val("");
                                $(ele).closest('tr').find('.LoyalityStatus').val("");
                                $(ele).closest('tr').find('.MemberId').val("");
                                toastrMessage('error',"This client can not be included in group, <br>because the client is not a new client","Error");
                                $('#select2-Member'+idval+'-container').parent().css('background-color',errorcolor);
                            }
                            else{
                                $(ele).closest('tr').find('.MemberId').val(value.MemberId);
                                $(ele).closest('tr').find('.MemberPic').val(value.Picture);
                                $(ele).closest('tr').find('.MemberName').val(value.Name);
                                $(ele).closest('tr').find('.LoyalityStatus').val(value.LoyalityStatus);
                                $('#loyaltydiscountVal').val(value.MemberDiscount);

                                $('#viewbtn'+idval).show();
                                $(".Period option[value='']").remove();  
                                $('.Period').append(defopt);
                                $('.BeforeTax').val("");
                                $('.Tax').val("");
                                $('.GrandTotal').val("");
                                $('.grandtotalhidden').val("");
                                $('.Discount').val("");
                                $('.DiscountAmount').val("");
                                $('.Period').select2
                                ({
                                    placeholder: "Select Period here",
                                });
                                CalculateGrandTotal();
                                renumberRows();
                                $('#select2-Member'+idval+'-container').parent().css('background-color',"white");
                            }
                        });
                    }
                });  
            }
        }

        function MemberTrFn(ele) {
            var idval = $(ele).closest('tr').find('.valstr').val();
            var mrid = $(ele).closest('tr').find('.Membertr').val();
            var lastrowcount=$('#hiddenLasttrid').val();
            var mem=$('#Membertr'+lastrowcount).val();
            var applicationId=$('#ApplicationsId').val();
            var defopt = '<option selected value=""></option>';
            var memId="";
            var appid="";
            var errcount=0;
            for(var t=0;t<=s;t++){
                var mm=$('#Membertr'+t).val();
                if(mm!=undefined){
                    if(parseFloat($('#Membertr'+t).val())!=parseFloat(mrid)){
                        errcount+=parseFloat(1);
                    }
                }
            }
            if(parseFloat(errcount)>=1){
                var defmopt = '<option selected value=""></option>';
                $('#Membertr'+idval).append(defmopt);
                $('#Membertr'+idval).select2
                ({
                    placeholder: "Select Service here",
                });
                $('#select2-Membertr'+idval+'-container').parent().css('background-color',errorcolor);
                $('#BeforeTaxtr'+idval).val("");
                $('#Taxtr'+idval).val("");
                $('#GrandTotaltr'+idval).val("");
                $('#grandtotalhiddentr'+idval).val("");
                $('#Discounttr'+idval).val("");
                $('#MemberIdtr'+idval).val("");
                toastrMessage('error',"You cant select multiple clients for a single invoice","Error");
            }
            else{
                $.ajax({
                    url: '/memberListinfo',
                    type: 'POST',
                    data:{
                        memId : $(ele).closest('tr').find('.Membertr').val(),
                        appid:$('#ApplicationsId').val(),
                    },
                    success: function(data) {
                        $(ele).closest('tr').find('.MemberCount').val(data.memcnt);
                        $.each(data.mtlist, function(key, value) {
                            $(ele).closest('tr').find('.MemberIdtr').val(value.MemberId);
                            // $(ele).closest('tr').find('.MemberPic').val(value.Picture);
                            // $(ele).closest('tr').find('.MemberName').val(value.Name);
                        });
                    }
                });

                var defmopt = '<option selected value=""></option>';
                var servicelist = $("#servicetrncbx > option").clone();
                $('#Servicetr'+idval).append(servicelist);
                $("#Servicetr"+idval+" option[label!='"+mrid+"']").remove();
                $("#Servicetr"+idval+" option[title!='"+applicationId+"']").remove();
                $('#Servicetr'+idval).append(defmopt);
                $('#Servicetr'+idval).select2
                ({
                    placeholder: "Select Service here",
                });
                $('#BeforeTaxtr'+idval).val("");
                $('#Taxtr'+idval).val("");
                $('#GrandTotaltr'+idval).val("");
                $('#grandtotalhiddentr'+idval).val("");
                $('#Discounttr'+idval).val("");
                CalculateGrandTotalTr();
                renumberRowsTr();
                $('#select2-Membertr'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $('#select2-Servicetr'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
        }

        function viewPic(ele) {
            var idval = $(ele).closest('tr').find('.valsm').val();
            var picname = $(ele).closest('tr').find('.MemberPic').val();
            var membername = $(ele).closest('tr').find('.MemberName').val();
            $('#viewbtn'+idval).popover({
                trigger: "hover",
                title: '',
                width:'1000px',
                container: "body",
                html: true,
                content: function () {
                    $("#membertitle").html("<b>"+$(ele).closest('tr').find('.MemberId').val()+"</br>"+$(ele).closest('tr').find('.MemberName').val()+"</b>");
                    $('#previewMemImg').attr("src","../../../storage/uploads/MemberPicture/"+ $(ele).closest('tr').find('.MemberPic').val());
                    return $("#mempicdiv").html(); 
                }
            });
        }

        function regDateFn() {
            var regdate="";
            var days="";
            var expiredatehidden="";
            var typeval="";
            $.ajax({
                url: '/registrationDate',
                type: 'POST',
                data:{
                    regdate : $('#RegistationDate').val(),
                    days:$('#PaymentTermAmountVal').val(),
                    expiredatehidden:$('#ExpireDateHiddenVal').val(),
                    typeval:$('#ApplicationType').val(),
                },
                success: function(data) {
                    $('#ExpiryDate').val(data.expiredate);
                    $('#regdate-error').html("");
                    $('#expdatedate-error').html("");
                }
            });
        }

        function CalculateBTServicePrice(ele) {
            var beforetax = $(ele).closest('tr').find('.BeforeTax').val()||0;
            var tax = $(ele).closest('tr').find('.Tax').val()||0;
            var grandtotal = $(ele).closest('tr').find('.GrandTotal').val()||0;
            var grandtotalpr=0;
            var taxpr=0;
            grandtotalpr=parseFloat(beforetax)*1.15;
            taxpr=parseFloat(grandtotalpr)-parseFloat(beforetax);
            $(ele).closest('tr').find('.Tax').val(taxpr.toFixed(2));
            $(ele).closest('tr').find('.GrandTotal').val(grandtotalpr.toFixed(2));
            $(ele).closest('tr').find('.BeforeTax').css("background","white");
            $(ele).closest('tr').find('.Tax').css("background","#efefef");
            $(ele).closest('tr').find('.GrandTotal').css("background","white");
            CalculateGrandTotal();
        }

        function CalculateGTServicePrice(ele) {
            var beforetax = $(ele).closest('tr').find('.BeforeTax').val()||0;
            var tax = $(ele).closest('tr').find('.Tax').val()||0;
            var grandtotal = $(ele).closest('tr').find('.GrandTotal').val()||0;
            var grandtotalpr=0;
            var taxpr=0;
            beforetax=parseFloat(grandtotal)/1.15;
            taxpr=parseFloat(grandtotal)-parseFloat(beforetax);
            $(ele).closest('tr').find('.Tax').val(taxpr.toFixed(2));
            $(ele).closest('tr').find('.BeforeTax').val(beforetax.toFixed(2));
            $(ele).closest('tr').find('.BeforeTax').css("background","white");
            $(ele).closest('tr').find('.Tax').css("background","#efefef");
            $(ele).closest('tr').find('.GrandTotal').css("background","white");
            CalculateGrandTotal();
        }

        function discountFn(ele) {
            var beforetax = $(ele).closest('tr').find('.BeforeTax').val()||0;
            var tax = $(ele).closest('tr').find('.Tax').val()||0;
            var grandtotal = $(ele).closest('tr').find('.GrandTotal').val()||0;
            var discountval = $(ele).closest('tr').find('.Discount').val()||0;
            var grandtotalhid = $(ele).closest('tr').find('.grandtotalhidden').val()||0;
            var hiddenappId=$('#applicationId').val();
            var disc=0;
            var subtotal=0;
            var tax=0;
            var grandtotalnet=0;
            if(!isNaN(parseFloat(hiddenappId))){
                grandtotalhid=$(ele).closest('tr').find('.hiddengrandtotalamount').val()||0;
            }
            $(ele).closest('tr').find('.Discount').css("background","white");
            if(parseFloat(grandtotal)>0){
                if(parseFloat(discountval)>0 && parseFloat(discountval)<100){
                    disc=(parseFloat(grandtotalhid)*parseFloat(discountval))/100;
                    $(ele).closest('tr').find('.DiscountAmount').val(disc.toFixed(2));
                    grandtotalnet=parseFloat(grandtotalhid)-parseFloat(disc);
                    subtotal=parseFloat(grandtotalnet)/1.15;
                    tax=parseFloat(grandtotalnet)-parseFloat(subtotal);
                    $(ele).closest('tr').find('.BeforeTax').val(subtotal.toFixed(2));
                    $(ele).closest('tr').find('.Tax').val(tax.toFixed(2));
                    $(ele).closest('tr').find('.GrandTotal').val(grandtotalnet);
                }
                else if(parseFloat(discountval)>=100){
                    toastrMessage('error',"Discount cannot be greater than or equal to 100","Error");
                    subtotal=parseFloat(grandtotalhid)/1.15;
                    tax=parseFloat(grandtotalhid)-parseFloat(subtotal);
                    $(ele).closest('tr').find('.BeforeTax').val(subtotal.toFixed(2));
                    $(ele).closest('tr').find('.Tax').val(tax.toFixed(2));
                    $(ele).closest('tr').find('.GrandTotal').val(grandtotalhid);
                    $(ele).closest('tr').find('.Discount').val("");
                    $(ele).closest('tr').find('.Discount').css("background",errorcolor);
                }
                else if(isNaN(parseFloat(discountval))){
                    subtotal=parseFloat(grandtotalhid)/1.15;
                    tax=parseFloat(grandtotalhid)-parseFloat(subtotal);
                    $(ele).closest('tr').find('.BeforeTax').val(subtotal.toFixed(2));
                    $(ele).closest('tr').find('.Tax').val(tax.toFixed(2));
                    $(ele).closest('tr').find('.GrandTotal').val(grandtotalhid);
                    $(ele).closest('tr').find('.DiscountAmount').val("");
                }  
                CalculateGrandTotal();
            }
        }

        function discountEach(){
            for(var k=1;k<=m;k++){
                var beforetax=($('#BeforeTax'+k)).val()||0;
                var tax=($('#Tax'+k)).val()||0;
                var grandtotal=($('#GrandTotal'+k)).val()||0;
                var discount=($('#Discount'+k)).val()||0;
                var grandtothidden=($('#grandtotalhidden'+k)).val()||0;
                var servid=($('#Service'+k)).val()||0;
                var disc=0;
                var subtotal=0;
                var tax=0;
                var grandtotalnet=0;
                if(($('#BeforeTax'+k).val())!=undefined && ($('#Tax'+k).val())!=undefined && ($('#GrandTotal'+k).val())!=undefined && ($('#Discount'+k).val())!=undefined && ($('#grandtotalhidden'+k).val())!=undefined && ($('#Service'+k).val())!=undefined){
                    if(parseFloat(servid)>0){
                        disc=(parseFloat(grandtothidden)*parseFloat(discount))/100;
                        $('#DiscountAmount'+k).val(disc);
                        grandtotalnet=parseFloat(grandtothidden)-parseFloat(disc);
                        subtotal=parseFloat(grandtotalnet)/1.15;
                        tax=parseFloat(grandtotalnet)-parseFloat(subtotal);
                        $('#BeforeTax'+k).val(subtotal.toFixed(2));
                        $('#Tax'+k).val(tax.toFixed(2));
                        $('#GrandTotal'+k).val(grandtotalnet.toFixed(2)); 
                    }
                }
            }            
        }

        function CalculateBTServicePriceTr(ele) {
            var beforetax = $(ele).closest('tr').find('.BeforeTaxtr').val();
            var tax = $(ele).closest('tr').find('.Taxtr').val()||0;
            var grandtotal = $(ele).closest('tr').find('.GrandTotaltr').val()||0;
            var grandtotalpr=0;
            var taxpr=0;
            grandtotalpr=parseFloat(beforetax)*1.15;
            taxpr=parseFloat(grandtotalpr)-parseFloat(beforetax);
            $(ele).closest('tr').find('.Taxtr').val(taxpr.toFixed(2));
            $(ele).closest('tr').find('.GrandTotaltr').val(grandtotalpr.toFixed(2));
            $(ele).closest('tr').find('.BeforeTaxtr').css("background","white");
            $(ele).closest('tr').find('.Taxtr').css("background","#efefef");
            $(ele).closest('tr').find('.GrandTotaltr').css("background","white");
            CalculateGrandTotalTr();
        }

        function CalculateGTServicePriceTr(ele) {
            var beforetax = $(ele).closest('tr').find('.BeforeTaxtr').val()||0;
            var tax = $(ele).closest('tr').find('.Taxtr').val()||0;
            var grandtotal = $(ele).closest('tr').find('.GrandTotaltr').val();
            var grandtotalpr=0;
            var taxpr=0;
            beforetax=parseFloat(grandtotal)/1.15;
            taxpr=parseFloat(grandtotal)-parseFloat(beforetax);
            $(ele).closest('tr').find('.Taxtr').val(taxpr.toFixed(2));
            $(ele).closest('tr').find('.BeforeTaxtr').val(beforetax.toFixed(2));
            $(ele).closest('tr').find('.BeforeTaxtr').css("background","white");
            $(ele).closest('tr').find('.Taxtr').css("background","#efefef");
            $(ele).closest('tr').find('.GrandTotaltr').css("background","white");
            CalculateGrandTotalTr();
        }

        function discountTrFn(ele) {
            var beforetax = $(ele).closest('tr').find('.BeforeTaxtr').val()||0;
            var tax = $(ele).closest('tr').find('.Taxtr').val()||0;
            var grandtotal = $(ele).closest('tr').find('.GrandTotaltr').val()||0;
            var discountval = $(ele).closest('tr').find('.Discounttr').val();
            var grandtotalhid = $(ele).closest('tr').find('.grandtotalhiddentr').val()||0;
            var hiddenappId=$('#applicationId').val();
            var disc=0;
            var subtotal=0;
            var tax=0;
            var grandtotalnet=0;
            if(!isNaN(parseFloat(hiddenappId))){
                grandtotalhid=$(ele).closest('tr').find('.hiddengrandtotalamounttr').val()||0;
            }
            $(ele).closest('tr').find('.Discounttr').css("background","white");
            if(parseFloat(grandtotal)>0){
                if(parseFloat(discountval)>0 && parseFloat(discountval)<100){
                    disc=(parseFloat(grandtotalhid)*parseFloat(discountval))/100;
                    $(ele).closest('tr').find('.DiscountAmounttr').val(disc.toFixed(2));
                    grandtotalnet=parseFloat(grandtotalhid)-parseFloat(disc);
                    subtotal=parseFloat(grandtotalnet)/1.15;
                    tax=parseFloat(grandtotalnet)-parseFloat(subtotal);

                    $(ele).closest('tr').find('.BeforeTaxtr').val(subtotal.toFixed(2));
                    $(ele).closest('tr').find('.Taxtr').val(tax.toFixed(2));
                    $(ele).closest('tr').find('.GrandTotaltr').val(grandtotalnet);
                }
                else if(parseFloat(discountval)>=100){
                    toastrMessage('error',"Discount cannot be greater than or equal to 100","Error");
                    subtotal=parseFloat(grandtotalhid)/1.15;
                    tax=parseFloat(grandtotalhid)-parseFloat(subtotal);
                    $(ele).closest('tr').find('.BeforeTaxtr').val(subtotal.toFixed(2));
                    $(ele).closest('tr').find('.Taxtr').val(tax.toFixed(2));
                    $(ele).closest('tr').find('.GrandTotaltr').val(grandtotalhid);
                    $(ele).closest('tr').find('.Discounttr').val("");
                    $(ele).closest('tr').find('.Discounttr').css("background",errorcolor);
                }
                else if(isNaN(parseFloat(discountval))){
                    subtotal=parseFloat(grandtotalhid)/1.15;
                    tax=parseFloat(grandtotalhid)-parseFloat(subtotal);
                    $(ele).closest('tr').find('.BeforeTaxtr').val(subtotal.toFixed(2));
                    $(ele).closest('tr').find('.Taxtr').val(tax.toFixed(2));
                    $(ele).closest('tr').find('.GrandTotaltr').val(grandtotalhid);
                    $(ele).closest('tr').find('.DiscountAmounttr').val("");
                }  
                CalculateGrandTotalTr();
            }
        }

        function CalculateGrandTotal() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var discountper = 0;
            var discountamount = 0;
            $.each($('#dynamicTable').find('.BeforeTax'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.Tax'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    tax += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.GrandTotal'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.Discount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    discountper += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.DiscountAmount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    discountamount += parseFloat($(this).val());
                }
            });
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxLbl').html(numformat(tax.toFixed(2)));
            $('#taxi').val(tax.toFixed(2));
            $('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#grandtotali').val(grandTotal.toFixed(2));
            $('#discountper').val(discountper.toFixed(2));
            $('#discounti').val(discountamount.toFixed(2));
            $('#discountlbl').html(numformat(discountamount.toFixed(2)));
            $('#dislbl').html("Discount ("+discountper.toFixed(1)+" %)");
           
            if(parseFloat(discountamount)>0){
                $('.totaldiscnumber').show();
            }
            else if(parseFloat(discountamount)<=0){
                $('.totaldiscnumber').hide();
            }
        }

        function CalculateGrandTotalTr() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var discountper = 0;
            var discountamount = 0;
            $.each($('#dynamicTableTrn').find('.BeforeTaxtr'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTableTrn').find('.Taxtr'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    tax += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTableTrn').find('.GrandTotaltr'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTableTrn').find('.Discounttr'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    discountper += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTableTrn').find('.DiscountAmounttr'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    discountamount += parseFloat($(this).val());
                }
            });
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxLbl').html(numformat(tax.toFixed(2)));
            $('#taxi').val(tax.toFixed(2));
            $('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#grandtotali').val(grandTotal.toFixed(2));
            $('#discountper').val(discountper.toFixed(2));
            $('#discounti').val(discountamount.toFixed(2));
            $('#discountlbl').html(numformat(discountamount.toFixed(2)));
            $('#dislbl').html("Discount ("+discountper+" %)");
            if(parseFloat(discountamount)>0){
                $('.totaldiscnumber').show();
            }
            else if(parseFloat(discountamount)<=0){
                $('.totaldiscnumber').hide();
            }
        }

        function getverifyappinfo() {
            var stid = $('#statusid').val();
            $('#checkedid').val(stid);
            $('#applicationverifymodal').modal('show');
            $('#verifyappbtn').prop("disabled", false);
            $('#verifyappbtn').text("Verify");
        }

        function sendtodevfn() {
            var stid = $('#statusid').val();
            $('#sendappid').val(stid);
            $('#sendtodevicemodal').modal('show');
            $('#sendtodevbtn').prop("disabled", false);
            $('#sendtodevbtn').text("Send");
        }

        function synctodevicefn() {
            var stid = $('#memberInfoId').val();
            $('#syncmemid').val(stid);
            $('#synctodevicemodal').modal('show');
            $('#synctodevicesbtn').prop("disabled", false);
            $('#synctodevicesbtn').text("Sync");
        }

        function closeRegisterModal() {
            $('#ApplicationType').select2('destroy');
            $('#ApplicationType').val(null).select2();
            $('#Group').select2('destroy');
            $('#Group').val(null).select2();
            $('#Pos').select2('destroy');
            $('#Pos').val(null).select2();
            $('#VoucherType').select2('destroy');
            $('#VoucherType').val(null).select2();
            $('#mrc').empty();
            $('#PaymentTerm').empty();
            $('#PaymentType').select2('destroy');
            $('#PaymentType').val(null).select2();
            $('#VoucherNumber').val('');
            $('#InvoiceNumber').val('');
            $('#date').val('');
            $('#Memo').val('');
            $('#RegistationDate').val('');
            $('#ExpiryDate').val('');
            $('#group-error').html('');
            $('#paymentterm-error').html('');
            $('#dynamicTable tbody').empty();
            $('#dynamicTablem tbody').empty();
            $('#dynamicTableTrn tbody').empty();
            $('#operationtypes').val("1");
            $('#applicationId').val("");
            $('.totalrownumber').hide();
            $('.totalrownumberm').hide();
            $('.totaldiscnumber').hide();
            $('#pos-error').html('');
            $('#vouchertype-error').html('');
            $('#mrc-error').html('');
            $('#paymenttype-error').html('');
            $('#voucherNumber-error').html('');
            $('#invoiceNumber-error').html('');
            $('#applicationtype-error').html('');
            $('#applicationid-error').html('');
            $('#date-error').html('');
            $('#mrcdiv').hide();
            $('#regdatediv').hide();
            $('#applicationiddiv').hide();
            $('#invnumdiv').show();
            $('#fsnumberlbl').html('FS/Doc No.');
            $('#subtotalLbl').html("");
            $('#subtotali').val("");
            $('#taxLbl').html("");
            $('#taxi').val("");
            $('#ApplicationDocument').val("");
            $('#ApplicationDocument').val(null);
            $('#grandtotalLbl').html("");
            $('#regdate-error').html("");
            $('#expdatedate-error').html("");
            $('#grandtotali').val("");
            $('#discountper').val("");
            $('#discounti').val("");
            $('#applicationdocumentupdate').val("");
            $('#discountlbl').html("");
            $('.newext').show();
            $('.trncls').hide();
            flatpickr('#RegistationDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
            flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
            $('#addsm').show();
            $('#addser').show();
            $('#addstr').hide();
            $('.newext').show();
            $('.trncls').hide();
            $('#mrcdiv').hide();
            $('#applicationiddiv').hide();
            $("#applicationdoclinkbtn").hide(); 
            $('#regdatediv').hide();
            $('#invnumdiv').show();
            $('#fsnumberlbl').html('FS/Doc No.');
            $('#applicationId').val("");
            $("#statusdisplay").html("");
            // var oTable = $('#laravel-datatable-crud').dataTable();
            // oTable.fnDraw(false);
            // var iTable = $('#laravel-datatable-crudmem').dataTable();
            // iTable.fnDraw(false);
        }

        function getMrcs(pid) {
            var posid=0;
            $('#mrc').empty();
            var defopt = '<option disabled selected value=""></option>';
            var mrcnumlist = $("#mrccbx > option").clone();
            $('#mrc').append(mrcnumlist);
            $("#mrc option[title!='"+pid+"']").remove();
            $('#mrc').append(defopt);
        }

        function posFn() {
            var pids=$('#Pos').val();
            var posid;
            getMrcs(pids);
            $('#PaymentType').empty();
            $.ajax({
                url: '/getPaymentTypeInfo',
                type: 'POST',
                data:{
                    posid : pids,
                },
                success: function(data) {
                    $.each(data.posprop, function(key, value) {
                        var allowcr=value.IsAllowedCreditSales;
                        if(allowcr=="Allow"){
                            $('#PaymentType').append('<option selected disabled value=""></option><option value="Cash">Cash</option><option value="Credit">Credit</option>');
                        }
                        else if(allowcr=="Not-Allow"){
                            $('#PaymentType').append('<option selected disabled value=""></option><option value="Cash">Cash</option>');
                        }
                        $('#PaymentType').select2
                        ({
                            placeholder: "Select Payment Type here",
                            minimumResultsForSearch: -1
                        });
                    });
                }
            });
            $('#pos-error').html('');
        }

        function vouchertypeFn() {
            var vtype=$('#VoucherType').val();
            var pids=$('#Pos').val();
            if(vtype=="Fiscal-Receipt"){
                $('#mrcdiv').show();
                $('#fsnumberlbl').html('FS No.');
                $('#invnumdiv').show();
                getMrcs(pids);
            }
            else if(vtype=="Manual-Receipt"){
                $('#mrcdiv').hide();
                $('#fsnumberlbl').html('Doc No.');
                $('#invnumdiv').hide();
                $('#mrc').empty();
            }
            $('#InvoiceNumber').val('');
            $('#vouchertype-error').html('');
        }

        function mrcFn() {
            $('#mrc-error').html('');
        }

        function paymenttypeFn() {
            $('#paymenttype-error').html('');
        }

        function voucherNumberval() {
            $('#voucherNumber-error').html('');
        }

        function invoiceNumberval() {
            $('#invoiceNumber-error').html('');
        }

        function dateVal() {
            $('#date-error').html('');
        }

        function syncmodalfn() {
            $('#syncmembermodal').modal('show');
        }

        function applicationTypeFn() {
            var apptype=$('#ApplicationType').val();
            var applicationidvals=$('#applicationId').val();
            $('#PaymentTerm').empty();
            $('#ApplicationsId').empty();
            var defopt='<option selected value=""></option>';
            var paymenttermlist = $("#paymenttermcbx > option").clone();
            $('#PaymentTerm').append(paymenttermlist);
            var applicationidlist = $("#applicationsidcbx > option").clone();
            $('#ApplicationsId').append(applicationidlist);
            $('#ApplicationsId').append(defopt);
            if(latestprop!=null||latestprop!==""){
                $('#ApplicationsId').append(latestprop);
            }
            $('#dynamicTable tbody').empty();
            $('#dynamicTablem tbody').empty();
            $('#dynamicTableTrn tbody').empty();
            if(apptype=="New"){
                $('#applicationiddiv').hide();
                $("#operationtypes").val("1");
                $('#savebutton').text('Save');
                $('#savebutton').prop("disabled", false);
                $("#hiddenAppType").val("New");
                $('#ApplicationsId').empty();
                $('.newext').show();
                $('.trncls').hide();
            }
            else if(apptype=="Renew"){
                $("#PaymentTerm option[value=5]").remove();
                $('#applicationiddiv').show();
                $("#operationtypes").val("3");
                $('#savebutton').text('Renew');
                $('#savebutton').prop("disabled", false);
                $("#hiddenAppType").val("Renew");
                $('.newext').show();
                $('.trncls').hide();
                if(!isNaN(parseFloat(applicationidvals))){
                    $("#ApplicationsId option[value='"+applicationidvals+"']").remove();
                    $("#ApplicationsId option").each(function() {
                        if(parseFloat(this.value)>parseFloat(applicationidvals)){
                            $("#ApplicationsId option[value='"+this.value+"']").remove();
                        }
                    });
                }
            }
            else{
                if(!isNaN(parseFloat(applicationidvals))){
                    $("#ApplicationsId option[value='"+applicationidvals+"']").remove();
                    $("#ApplicationsId option").each(function() {
                        if(parseFloat(this.value)>parseFloat(applicationidvals)){
                            $("#ApplicationsId option[value='"+this.value+"']").remove();
                        }
                    });
                }
                $('#applicationiddiv').show();
                $("#operationtypes").val("1");
                $('#savebutton').text('Save');
                $('#savebutton').prop("disabled", false);
                $("#hiddenAppType").val("Trainer-Fee");
                $('.newext').hide();
                $('.trncls').show();
                $('.totalrownumberm').hide();
                $('.totalrownumber').hide();
                $('.totaldiscnumber').hide();
                $('#addstr').show();
                r=0;
            }
            $('#applicationCountVal').val("0");
            $("#RegistationDate").val("");
            $("#ExpiryDate").val("");
            $('#ApplicationsId').select2
            ({
                placeholder: "Select FS/Invoice here",
                dropdownCssClass : 'appiddrp',
            });
            $('#Group').select2('destroy');
			$('#Group').val(null).select2();
            $('#Group').select2
            ({
                placeholder: "Select Group here",
            });
            $('#PaymentTerm').select2
            ({
                placeholder: "Select Payment Term here",
            });
            $('#applicationtype-error').html('');
            renumberRows();
            renumbermRows();
            CalculateGrandTotal();
        }

        function voidReason() {
            $('#void-error').html("");
        }

        function refundReasonFn() {
            $('#refund-error').html("");
        }

        function masterview() {
            //var oTable = $('#laravel-datatable-crud').dataTable();
            //oTable.fnDraw(false);
        }

        function memberview() {
            //var oTable = $('#laravel-datatable-crudmem').dataTable();
            //oTable.fnDraw(false);
        }

        $(function(){
            $('.creditsllink').popover({
                trigger: "hover",
                title:"Credit Sales and Settlement",
                width:'100px',
                container: "body",
                html: true,
                content: function () {
                    return $("#mempicdiv").html();
                }
            });
        });

        function priceActiveFn(ele)
        {  
            var appcnt=$('#applicationCountVal').val()||0;
            if(parseFloat(appcnt)==0){
                $(ele).closest('tr').find('.BeforeTax').prop("readonly", false);
                $(ele).closest('tr').find('.GrandTotal').prop("readonly", false);
                $(ele).closest('tr').find('.BeforeTax').css("background","white");
                $(ele).closest('tr').find('.GrandTotal').css("background","white");
            }
            $(ele).closest('tr').find('.BeforeTaxtr').prop("readonly", false);
            $(ele).closest('tr').find('.GrandTotaltr').prop("readonly", false);
            $(ele).closest('tr').find('.BeforeTaxtr').css("background","white");
            $(ele).closest('tr').find('.GrandTotaltr').css("background","white");
        }

        function discountActiveFn(ele)
        {  
            var appcnt=$('#applicationCountVal').val()||0;
            if(parseFloat(appcnt)==0){
                $(ele).closest('tr').find('.Discount').prop("readonly", false);
                $(ele).closest('tr').find('.Discount').css("background","white");
            }
            $(ele).closest('tr').find('.Discounttr').prop("readonly", false);
            $(ele).closest('tr').find('.Discounttr').css("background","white");
        }

        $(document).on('click', '.applicationdoclinkcls', function() {
            var recordId = $('#applicationId').val();
            var filenames = $('#documentNumbers').val();
            $.get("/downloadingapp" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/ApplicationDocuments/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        });

        function applicationDocumentsFn() {
            var recordId = $('.applicationinfoid').val();
            var filenames = $('.documentinfoval').val();
            $.get("/downloadingapp" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/ApplicationDocuments/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
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