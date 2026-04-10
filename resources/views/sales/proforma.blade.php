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
                            <h3 class="card-title">Proforma Invoice</h3>
                            <button type="button" class="btn btn-gradient-info btn-sm addbutton" data-toggle="modal"
                                data-target="" style='float:right; margin-top:2%; margin-right:1%;'>Add</button>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div class="table-responsive">
                                    <table id="proformatable"
                                        class="table table-bordered table-striped table-hover dt-responsive table mb-0"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Document No.</th>
                                                <th>Category</th>
                                                <th>Customer Name</th>
                                                <th>TIN No.</th>
                                                <th>Contact Person Name</th>
                                                <th>Contact Person Phone</th>
                                                <th>Shop</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel333">New Sales</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeinlineFormModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register" class="invoice-repeater">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-12">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="customerdiv">
                                                <label strong style="font-size: 14px;color">Customer </label>
                                                <input type="hidden" name="proformaid" id="proformaid">
                                                <input type="hidden" name="documentNumber" id="documentNumber">
                                                <div>
                                                    <select class="selectpicker form-control" data-live-search="true"
                                                        data-style="btn btn-outline-secondary waves-effect" name="customer"
                                                        id="customer">
                                                        <option selected disabled value=""></option>
                                                        <div id="wrdiv">
                                                            @foreach ($customerSrc as $customerSrc)
                                                                <option value="{{ $customerSrc->id }}">
                                                                    {{ $customerSrc->Code }} , {{ $customerSrc->Name }}
                                                                    ,
                                                                    {{ $customerSrc->TinNumber }} </option>
                                                            @endforeach
                                                        </div>
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="customer-error"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Contact Person Name</label>
                                                <input type="text" placeholder="Contact Person Name" class="form-control"
                                                    name="contactPersonName" id="contactPersonName"
                                                    onkeyup="removeContactPersonNameValidation()" />
                                                <span class="text-danger">
                                                    <strong id="contactPersonName-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Contact Person Phone</label>
                                                <input type="text" placeholder="Contact Person Mobile"
                                                    class="form-control" name="ContactPersonPhone" id="ContactPersonPhone"
                                                    onkeyup="removeContactPersonPhoneValidation()"
                                                    onkeypress="return ValidatePhone(event)" />
                                                <span class="text-danger">
                                                    <strong id="ContactPersonPhone-error"></strong>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Ordered By</label>
                                                <select class="selectpicker form-control form-control-lg"
                                                    data-live-search="true"
                                                    data-style="btn btn-outline-secondary waves-effect" name="orderBy"
                                                    id="orderBy" onchange="removevorderByValidation()">
                                                    <option value=""></option>
                                                    @foreach ($users as $users)
                                                        <option value="{{ $users->username }}">
                                                            {{ $users->username }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="orderBy-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="storediv">
                                                <label strong style="font-size: 14px;">Shop</label>
                                                <div>

                                                    <select class="selectpicker form-control form-control-lg"
                                                        data-live-search="true"
                                                        data-style="btn btn-outline-secondary waves-effect" name="store"
                                                        id="store" onchange="removeStoreValidation()">
                                                        @foreach ($storeSrc as $storeSrc)
                                                            <option value="{{ $storeSrc->StoreId }}">
                                                                {{ $storeSrc->StoreName }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="salecounti" id="salecounti"
                                                        readonly="true" />
                                                    <input type="hidden" name="calcutionhide" id="calcutionhide"
                                                        readonly="true" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="store-error"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="storedivedit">
                                                <label strong style="font-size: 14px;">Issue Store</label>
                                                <div>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" placeholder="Issue Store" class="form-control"
                                                            name="storeedit" id="storeedit" readonly />
                                                    </div>


                                                </div>
                                                <span class="text-danger">
                                                    <strong id="store-error"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="mrcdiv">
                                                <label strong style="font-size: 14px;">RFQ Number</label>
                                                <input type="text" placeholder="RFQ Numebr" class="form-control"
                                                    name="rfqNumber" id="rfqNumber" onkeyup="removerfqNumberValidation()" />
                                                <span class="text-danger">
                                                    <strong id="rfqNumber-error"></strong>
                                                </span>
                                            </div>


                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Date</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" name="date" id="date"
                                                        class="form-control flatpickr-basic" placeholder="YYYY-MM-DD"
                                                        onchange="removeDateValidation()" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="date-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Memo</label>
                                                <div id="memotoolbar-container">
                                                    <span class="ql-formats">
                                                        <select class="ql-font"></select>
                                                        <select class="ql-size"></select>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-bold"></button>
                                                        <button class="ql-italic"></button>
                                                        <button class="ql-underline"></button>
                                                        <button class="ql-strike"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <select class="ql-color"></select>
                                                        <select class="ql-background"></select>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-script" value="sub"></button>
                                                        <button class="ql-script" value="super"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-header" value="1"></button>
                                                        <button class="ql-header" value="2"></button>
                                                        <button class="ql-blockquote"></button>
                                                        <button class="ql-code-block"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-list" value="ordered"></button>
                                                        <button class="ql-list" value="bullet"></button>
                                                        <button class="ql-indent" value="-1"></button>
                                                        <button class="ql-indent" value="+1"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-direction" value="rtl"></button>
                                                        <select class="ql-align"></select>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-link"></button>
                                                        <button class="ql-video"></button>
                                                    </span>
                                                    <span class="ql-formats">
                                                        <button class="ql-clean"></button>
                                                    </span>
                                                    <div id="memoeditor-container"></div>
                                                </div>
                                                <textarea class="form-control" id="memo" placeholder="Write Reason here"
                                                    name="memo" style="display:none;"></textarea>
                                                <span class="text-danger">
                                                    <strong id="memo-error"></strong>
                                                </span>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title">Customer Info</h6>
                                            </div>
                                            <div class="card-body" id="customerInfoCardDiv">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 12px;">Name: </label>
                                                        </td>
                                                        <td>
                                                            <label id="cname" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 12px;">Category: </label>
                                                        </td>
                                                        <td>
                                                            <label id="ccategory" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 12px;">Defualt Price: </label>
                                                        </td>
                                                        <td>
                                                            <label id="cdefaultPrice" strong
                                                                style="font-size: 12px;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 12px;">TIN Number: </label>
                                                        </td>
                                                        <td>
                                                            <label id="ctinNumber" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 12px;">Vat: </label>
                                                        </td>
                                                        <td>
                                                            <label id="cvat" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label strong style="font-size: 12px;">Withold: </label>
                                                        </td>
                                                        <td>
                                                            <label id="cwithold" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <span id="dynamic-error"></span>
                                        <div style="width:98%; margin-left:1%;">
                                            <div class="table-responsive">
                                                <table id="dynamicTable" style="width: 100%;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Name</th>
                                                        <th>UOM</th>
                                                        <th>Qty.on Hand</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Before Tax</th>
                                                        <th>Tax Amount</th>
                                                        <th>Total Price</th>
                                                        <th></th>
                                                    </tr>
                                                </table>

                                                <table id="datatable-crud-child"
                                                    class="table table-bordered table-striped table-hover dt-responsive table mb-0"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Item Name</th>
                                                            <th>Quantity</th>
                                                            <th id="itemheadholdedit">D Price</th>
                                                            <th>Unitprice</th>
                                                            <th>Discount(%)</th>
                                                            <th>Before Tax</th>
                                                            <th>Tax Amount</th>
                                                            <th>Total Pric</th>
                                                            <th style="width: 15%">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <table id="datatable-crud-childsale"
                                                    class="table table-bordered table-striped table-hover dt-responsive table mb-0"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Code</th>
                                                            <th>Item Name</th>
                                                            <th>sku #</th>
                                                            <th>Quantity</th>
                                                            <th>Unitprice</th>
                                                            <th>Before Tax</th>
                                                            <th>Tax Amount</th>
                                                            <th>Total Price</th>
                                                            <th style="width: 15%">Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>

                                                <table>
                                                    <tr>
                                                        <td><button type="button" name="adds" id="adds"
                                                                class="btn btn-success btn-sm"><i data-feather='plus'></i>
                                                                Add New </button>
                                                            <button type="button" name="addnew" id="addnew"
                                                                class="btn btn-success btn-sm"><i data-feather='plus'></i>
                                                                Add New</button>
                                                            <button type="button" name="addnewhold" id="addnewhold"
                                                                class="btn btn-success btn-sm"><i data-feather='plus'></i>
                                                                Add New</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <table style="width:100%;" id="pricetable">

                                                    <tr>
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Sub Total:</label></td>
                                                        <td style="text-align: right; width:10%"><label id="subtotalLbl"
                                                                strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>
                                                        <td><input type="hidden" placeholder="" class="form-control"
                                                                name="subtotali" id="subtotali" readonly="true" value="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Tax:</label></td>
                                                        <td style="text-align: right; width:10%"><label id="taxLbl" strong
                                                                style="font-size: 16px; font-weight: bold;"></label></td>
                                                        <td><input type="hidden" placeholder="" class="form-control"
                                                                name="taxi" id="taxi" readonly="true" value="0" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Grand Total:</label></td>
                                                        <td style="text-align: right; width:10%"><label id="grandtotalLbl"
                                                                strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>
                                                        <td><input type="hidden" placeholder="" class="form-control"
                                                                name="grandtotali" id="grandtotali" readonly="true"
                                                                value="0" /></td>
                                                    </tr>


                                                    <tr id="witholdingTr">
                                                        <td style="text-align: right;"><label id="withodingTitleLbl" strong
                                                                style="font-size: 16px;">Witholding:</label></td>
                                                        <td style="text-align: right; width:10%">
                                                            <label id="witholdingAmntLbl" class="formattedNum" strong
                                                                style="font-size: 16px; font-weight: bold;"></label>
                                                            <input type="hidden" placeholder="" class="form-control"
                                                                name="witholdingAmntin" id="witholdingAmntin"
                                                                readonly="true" value="0" />
                                                        </td>
                                                    </tr>


                                                    <tr id="vatTr">
                                                        <td style="text-align: right;"><label id="vatTitleLbl" strong
                                                                style="font-size: 16px;">Vat:</label></td>
                                                        <td style="text-align: right; width:10%">
                                                            <label id="vatAmntLbl" class="formattedNum" strong
                                                                style="font-size: 16px; font-weight: bold;"></label>
                                                            <input type="hidden" placeholder="" class="form-control"
                                                                name="vatAmntin" id="vatAmntin" readonly="true" value="0" />
                                                        </td>
                                                    </tr>

                                                    </tr>
                                                    <tr id="netpayTr">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">Net Pay:</label></td>
                                                        <td style="text-align: right; width:10%">
                                                            <label id="netpayLbl" class="formattedNum" strong
                                                                style="font-size: 16px; font-weight: bold;"></label>
                                                            <input type="hidden" placeholder="" class="form-control"
                                                                name="netpayin" id="netpayin" readonly="true" value="0" />
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" style="text-align: right;">
                                                            —-------------------------------
                                                        </td>
                                                    </tr>
                                                    {{-- <tr id="discountTr">
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;color:#dc3545;"
                                                                id="discountamountextLbl">Discount:</label></td>
                                                        <td style="text-align: right; width:10%"><label
                                                                id="discountamountLbl" strong
                                                                style="font-size: 16px; font-weight: bold;color:#dc3545;"></label>
                                                        </td>
                                                        <td><input type="hidden" placeholder="" class="form-control"
                                                                name="discountamountli" id="discountamountli"
                                                                readonly="true" /></td>
                                                        <td><input type="hidden" placeholder="" class="form-control"
                                                                name="discountpercenti" id="discountpercenti"
                                                                readonly="true" /></td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td style="text-align: right;"><label strong
                                                                style="font-size: 16px;">No. of Items:</label></td>
                                                        <td style="text-align: right; width:10%"><label
                                                                id="numberofItemsLbl" strong
                                                                style="font-size: 16px; font-weight: bold;">0</label></td>
                                                        <td><input type="hidden" name="numbercounti" id="numbercounti" />
                                                        </td>
                                                    </tr>

                                                    <tr id="hidewitholdTr" style="display: none;">
                                                        <td colspan="3" style="text-align: right;">
                                                            <div class="form-check form-check-inline" id="hidewitholddiv"
                                                                style="display: none;">
                                                                <label class="form-check-label">Hide Deduction: </label>
                                                                <input class="form-check-input" name="hidewithold"
                                                                    type="checkbox" id="hidewithold" />
                                                                <input type="hidden" placeholder="" class="form-control"
                                                                    name="hidewitholdi" id="hidewitholdi" readonly="true"
                                                                    value="1" />
                                                                <input type="hidden" placeholder="" class="form-control"
                                                                    name="hidevati" id="hidevati" readonly="true"
                                                                    value="1" />
                                                            </div>

                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="witholdMinAmounti" id="witholdMinAmounti"
                            readonly="true" />
                        <input type="hidden" class="form-control" name="servicewitholdMinAmounti"
                            id="servicewitholdMinAmounti" readonly="true" />
                        <input type="hidden" class="form-control" name="witholdPercenti" id="witholdPercenti"
                            readonly="true" />
                        <input type="hidden" class="form-control" name="vatPercenti" id="vatPercenti" readonly="true" />
                        <input type="hidden" class="form-control" name="vatAmount" id="vatAmount" readonly="true" />
                        @can('sales-add')
                            <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        @endcan
                        <button id="closebutton" type="button" class="btn btn-danger"
                            onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!--End Registation Modal -->
    <div class="modal fade" id="IteminlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel333">Add Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeIteminlineFormModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="itemRegisterForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12 col-lg-12">
                                <div class="row">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="">
                                            <table>
                                                <tr>
                                                    <td style="width: 20%">
                                                        <label strong style="font-size: 14px;">Item Name</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">UOM</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">Qty on Hand</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">Quantity</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">Unit Price</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">Before Tax</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">Tax Amount</label>
                                                    </td>
                                                    <td>
                                                        <label strong style="font-size: 14px;">Total Price</label>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="itemid" id="itemid"
                                                            class="form-control">
                                                        <input type="hidden" name="HeaderId" id="HeaderId"
                                                            class="form-control">
                                                        <input type="hidden" name="storeId" id="storeId"
                                                            class="form-control">
                                                        <input type="hidden" name="commonId" id="commonId"
                                                            class="form-control">
                                                        <select class="selectpicker form-control form-control-lg ItemName"
                                                            data-live-search="true"
                                                            data-style="btn btn-outline-secondary waves-effect"
                                                            name="regitem_id" id="ItemName"
                                                            onchange="removeItemNameValidation()">
                                                            <option selected value=""></option>
                                                            @foreach ($itemSrcss as $storeSrc)

                                                                <option value="{{ $storeSrc->ItemId }}">
                                                                    {{ $storeSrc->Code }}, {{ $storeSrc->ItemName }},
                                                                    {{ $storeSrc->SKUNumber }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td style="width: 10%">
                                                        <select id="uoms" class="select2 form-control uoms"
                                                            onchange="uomsavedVal(this)" name="uoms"></select>
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Qty on hand" name="avQuantitiy"
                                                            id="avQuantitiy" class="form-control" readonly />
                                                        <input type="hidden" placeholder="Qty on hand" name="avQuantitiyh"
                                                            id="avQuantitiyh" class="form-control" readonly />
                                                    </td>

                                                    <td>
                                                        <input type="text" placeholder="Quantity" class="form-control"
                                                            name="Quantity" id="Quantity"
                                                            onkeyup="CalculateAddHoldTotal(this)"
                                                            onclick="removeQuantityValidation()"
                                                            onkeypress="return ValidateNum(event);" />
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="unit Price" class="form-control"
                                                            name="UnitPrice" id="UnitPrice"
                                                            onkeyup="CalculateAddHoldTotal(this)"
                                                            onclick="removeUnitPriceValidation()"
                                                            onkeypress="return ValidateNum(event);" readonly
                                                            @can('UnitPrice-Active') ondblclick="unitpriceSingleActive();"
                                                            @endcan />
                                                    </td>
                                                    <td>
                                                        <input type="text" name="BeforeTaxPrice" id="BeforeTaxPrice"
                                                            placeholder="Before Tax Price" class="form-control"
                                                            readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Tax" name="TaxAmount" id="TaxAmount"
                                                            class="form-control" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text" placeholder="Total" name="TotalPrice"
                                                            id="TotalPrice" class="form-control" readonly />
                                                        <input type="hidden" class="form-control"
                                                            name="minimimstockindividual" id="minimimstockindividual"
                                                            value="0" readonly="true" />
                                                        <input type="hidden" class="form-control"
                                                            name="avaliableallqauntittyindivdual"
                                                            id="avaliableallqauntittyindivdual" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control"
                                                            name="checkedpendingquantity" id="checkedpendingquantity"
                                                            value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="defaultuomi"
                                                            id="defaultuomi" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="defaultuomi"
                                                            id="defaultuomi" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="newuomi"
                                                            id="newuomi" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="convertedqi"
                                                            id="convertedqi" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="convertedamnti"
                                                            id="convertedamnti" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="mainPricei"
                                                            id="mainPricei" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="maxicost"
                                                            id="maxicost" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="discountiamount"
                                                            id="discountiamount" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="triggervalue"
                                                            id="triggervalue" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="Wsaleminamount"
                                                            id="Wsaleminamount" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="Rsaleprice"
                                                            id="Rsaleprice" value="0" readonly="true" />
                                                        <input type="hidden" class="form-control" name="Wsaleprice"
                                                            id="Wsaleprice" value="0" readonly="true" />
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <textarea class="form-control" id="description"
                                                            placeholder="Description" name="description"></textarea>
                                                    </td>
                                                    <td colspan="7">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="ItemName-error"></strong>
                                                        </span>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="Quantity-error"></strong>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="UnitPrice-error"></strong>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="discount-error"></strong>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="BeforeTaxPrice-error"></strong>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="TaxAmount-error"></strong>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger">
                                                            <strong id="TotalPrice-error"></strong>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </section>
                    </div>
                    <div class="modal-footer">
                        <button id="savebuttonsaleitem" type="button" class="btn btn-info">Add</button>
                        <button id="savebuttonitem" type="button" class="btn btn-info">Add</button>
                        <button id="closebutton" type="button" class="btn btn-danger"
                            onclick="closeIteminlineFormModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Proforma Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="proformaInfoForm">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Proforma Header Info</h6>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="reload" onclick="refreshContent()"><i
                                                                data-feather="rotate-cw"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body" id="infoCardDiv">
                                            <div class="table-responsive">
                                                <input type="hidden" placeholder="" class="form-control" name="statusid"
                                                    id="statusid" readonly="true">
                                                <label style="font-size: 14px;display:none;" id="infoDocType" strong
                                                    style="font-size: 12px;"></label>
                                                <table>
                                                    <tr>
                                                        <td style="width:43%;"><label strong
                                                                style="font-size: 14px;">Document
                                                                Number</label>
                                                        </td>
                                                        <td style="width:57%;"><label id="infoDocDocNo" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Customer Category</label>
                                                        </td>
                                                        <td><label id="infoDocCustomerCategory" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Customer Name</label>
                                                        </td>
                                                        <td><label id="infoDocCustomerName" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">TIN Number</label>
                                                        </td>
                                                        <td><label id="infoTINum" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Shop / Store</label>
                                                        </td>
                                                        <td><label id="infoShop" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Contact Person
                                                                Name</label>
                                                        </td>
                                                        <td><label id="infoContactPersonName" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Contact Person
                                                                Phone</label>
                                                        </td>
                                                        <td><label id="infoContactPersonPhone" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Order By</label>
                                                        </td>
                                                        <td><label id="infoOrderBy" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">RFQ Number</label>
                                                        </td>
                                                        <td><label id="infoRfqNum" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Prepared By</label>
                                                        </td>
                                                        <td><label id="infoUsername" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Date</label>
                                                        </td>
                                                        <td><label id="infoDate" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Status</label>
                                                        </td>
                                                        <td><label id="infoStatus" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Memo</label>
                                                        </td>
                                                        <td><label id="infoMemo" strong style="font-size: 14px;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label strong style="font-size: 14px;">Void Reason</label>
                                                        </td>
                                                        <td><label id="infoVoidReason" strong
                                                                style="font-size: 14px;font-weight:bold;"></label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Proforma Detail</h6>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="reload" onclick="refreshdetailtable()"><i
                                                                data-feather="rotate-cw"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="docInfoItem"
                                                    class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                                    <thead>
                                                        <th style="font-size:10px;">id</th>
                                                        <th style="font-size:10px; width:5%;">Item Code</th>
                                                        <th style="font-size:10px; width:15%;">Item Name</th>
                                                        <th style="font-size:10px; width:5%;">SKU Number</th>
                                                        <th style="font-size:10px; width:5%;">UOM</th>
                                                        <th style="font-size:10px; width:5%;">Qty</th>
                                                        <th style="font-size:10px; width:15%;">Unit Price</th>
                                                        <th style="font-size:10px; width:15%;">Before Tax</th>
                                                        <th style="font-size:10px; width:15%;">Tax</th>
                                                        <th style="font-size:10px; width:15%;">Total</th>
                                                        <th style="font-size:10px;">Action</th>
                                                        <th style="font-size:10px; width:1%;visibility:false;"></th>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="7" style="text-align: right;font-size:14px;">Total
                                                            </td>
                                                            <td style="font-size:10px;font-weight:bold;">
                                                                <label id="infosubtotal" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label>
                                                            </td>
                                                            <td style="font-size:10px;font-weight:bold;">
                                                                <label id="infotax" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label>
                                                            </td>
                                                            <td style="font-size:10px;font-weight:bold;">
                                                                <label id="infograndtotal" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr id="witholdProTr" style="display: none;">
                                                            <td colspan="9" style="text-align: right;font-size:14px;">
                                                                Withold
                                                            </td>
                                                            <td style="font-size:10px;font-weight:bold;">
                                                                <label id="infoWithold" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr id="vatProTr" style="display: none;">
                                                            <td colspan="9" style="text-align: right;font-size:14px;">
                                                                VAT
                                                            </td>
                                                            <td style="font-size:10px;font-weight:bold;">
                                                                <label id="infoVat" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label>
                                                            </td>
                                                        </tr>
                                                        <tr id="netpayProTr" style="display: none;">
                                                            <td colspan="9" style="text-align: right;font-size:14px;">
                                                                Net Pay
                                                            </td>
                                                            <td style="font-size:10px;font-weight:bold;">
                                                                <label id="infoNetpay" strong
                                                                    style="font-size: 14px;font-weight:bold;"></label>
                                                            </td>
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
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="selectedids" id="selectedids"
                            readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="recordIds" id="recordIds"
                            readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="statusIds" id="statusIds"
                            readonly="true">
                        <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Hold Info -->

    {{-- memo show starts --}}
    <div class="modal fade text-left" id="memomodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="memomodaltitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="memoform">
                    @csrf
                    <div class="modal-body">
                        <label id="infoMemoLbl" strong style="font-size: 14px;"></label>
                    </div>
                    <div class="modal-footer">
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- memo show ends --}}

@endsection

@section('scripts')



    <script type="text/javascript">
        memoeditor = new Quill('#memoeditor-container', {
            modules: {
                syntax: true,
                toolbar: '#memotoolbar-container'
            },
            placeholder: 'Write Memo here..',
            theme: 'snow'
        });
        memoeditor.on('text-change', function(delta, oldDelta, source) {
            $('#memo').text($(".ql-editor").html());
            if (memoeditor.getText().trim().length === 0) {
                $('#memo').html('');
            }
        });

        $(document).ready(function() {
            $('#proformatable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                fixedHeader: true,
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
                    url: "{{ url('proformalist') }}",
                    type: 'GET',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber'
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
                        data: 'ContactPerson',
                        name: 'ContactPerson'
                    },
                    {
                        data: 'ContactPersonPhone',
                        name: 'ContactPersonPhone'
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName'
                    },
                    {
                        data: 'CreatedDate',
                        name: 'CreatedDate'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Sold") {
                        for (var i = 0; i <= 7; i++) {
                            $(nRow).find('td:eq(' + i + ')').css({
                                "color": "#1cc88a"
                            });
                        }
                    } else if (aData.Status == "Void") {
                        for (var i = 0; i <= 7; i++) {
                            $(nRow).find('td:eq(' + i + ')').css({
                                "color": "#e74a3b"
                            });
                        }

                    }
                }

            });

        });
        $("#addnew").on('click', function() {

            var hid = $('#proformaid').val();
            var storeid = $('#store').val();
            $('#triggervalue').val('0');
            $('#itemid').val('');
            $('#ItemName').val(null).trigger('change');
            $('#uoms').val(null).trigger('change');
            $("#IteminlineForm").modal('show');
            $("#itemRegisterForm")[0].reset();
            $('#storeId').val(storeid);
            $('#HeaderId').val(hid);
            $('#savebuttonitem').hide();
            $('#savebuttonsaleitem').show();
        });

        function proformaitemedit(id) {
            var option = '';
            var itemtosend = '';
            $.get("showproformaitem/" + id, function(data, textStatus, jqXHR) {
                $('#HeaderId').val(data.proformaitem.proforma_id);
                $('#ItemName').selectpicker('val', data.proformaitem.regitem_id);
                $('#Quantity').val(data.proformaitem.Quantity);
                $('#defPrice').val(data.proformaitem.Dprice);
                $('#UnitPrice').val(data.proformaitem.UnitPrice);
                $('#mainPricei').val(data.proformaitem.UnitPrice * data.proformaitem.ConversionAmount);
                $('#BeforeTaxPrice').val(data.proformaitem.BeforeTaxPrice);
                $('#TaxAmount').val(data.proformaitem.TaxAmount);
                $('#TotalPrice').val(data.proformaitem.TotalPrice);
                $('#convertedqi').val(data.proformaitem.ConvertedQuantity);
                $('#convertedamnti').val(data.proformaitem.ConversionAmount);
                $('#newuomi').val(data.proformaitem.NewUOMId);
                $('#defaultuomi').val(data.proformaitem.DefaultUOMId);
                option = "<option selected value='" + data.proformaitem.NewUOMId + "'>" + data.uomname +
                    "</option>";
                $("#uoms").empty();
                $("#uoms").append(option);
                $('#uoms').select2();
                itemtosend = data.proformaitem.regitem_id;
                if (itemtosend != '') {
                    $.ajax({
                        type: "DELETE",
                        url: "saleUOMS/" + itemtosend,
                        data: "",
                        dataType: "",
                        success: function(response) {
                            if (response.sid) {
                                var defname = response['defuom'];
                                var defid = response['uomid'];
                                var optioneditdefault = "<option value='" + defid + "'>" + defname +
                                    "</option>";
                                $("#uoms").append(optioneditdefault);
                                $("#defaultuomi").val(defid);
                                $("#newuomi").val(defid);
                                $("#convertedamnti").val("1");
                                $.each(response.sid, function(index, value) {
                                    var name = value.ToUnitName;
                                    var id = value.ToUomID;
                                    var optionedit = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#uoms").append(optionedit);
                                });

                                $('#uoms').select2();

                            }

                        }
                    });
                }

            });


            var storeid = $('#store').val();
            var uomname = $(this).data('uom');
            $('#storeId').val(storeid);
            $('#triggervalue').val('1');
            $('#itemid').val(id);
            $("#IteminlineForm").modal('show');
            $("#savebuttonsaleitem").show();
            $("#savebuttonsaleitem").text("Update");
            $("#savebuttonitem").hide();


        }

        function deleteConfirmation(id) {
            // console.log('id='+id);
            swal({
                title: "Delete?",
                text: "Are You sure do you want to delet this data!",
                type: "warning",
                showCancelButton: !0,
                allowOutsideClick: false,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('/proformadelete') }}/" + id,
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function(results) {

                            if (results.success) {
                                swal({
                                    title: "Done",
                                    text: results.success,
                                    type: "success",
                                    allowOutsideClick: false,
                                });

                                var oTable = $('#datatable-crud-childsale').dataTable();
                                oTable.fnDraw(false);
                                $('#numberofItemsLbl').text(results.countitem);
                                $.each(results.pricing, function(index, value) {
                                    var beforetax = value.BeforeTaxPrice;
                                    var tax = parseFloat(beforetax) * 15 / 100;
                                    var grandTotal = parseFloat(beforetax) + parseFloat(tax);
                                    $('#subtotalLbl').html(numformat(beforetax));
                                    $('#taxLbl').html(numformat(tax.toString().match(
                                        /^\d+(?:\.\d{0,2})?/)));
                                    $('#grandtotalLbl').text(numformat(grandTotal.toString()
                                        .match(/^\d+(?:\.\d{0,2})?/)));
                                });
                            } else {

                                swal({
                                    title: "Error!",
                                    text: results.error,
                                    type: "error",
                                    allowOutsideClick: false,
                                });
                                $('#numberofItemsLbl').text(results.countitem);
                                $.each(results.pricing, function(index, value) {
                                    var beforetax = value.BeforeTaxPrice;
                                    var tax = parseFloat(beforetax) * 15 / 100;
                                    var grandTotal = parseFloat(beforetax) + parseFloat(tax);
                                    $('#subtotalLbl').html(numformat(beforetax));
                                    $('#taxLbl').html(numformat(tax.toString().match(
                                        /^\d+(?:\.\d{0,2})?/)));
                                    $('#grandtotalLbl').text(numformat(grandTotal.toString()
                                        .match(/^\d+(?:\.\d{0,2})?/)));
                                });
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }
        $('body').on('click', '.proformaunvoid', function() {
            var id = $(this).data('id');
            swal({
                title: "Undo-Void",
                text: "Are you sure do you want to undo-void this data!",
                type: "question",
                showCancelButton: !0,
                allowOutsideClick: false,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Undo-Void",
                cancelButtonText: "Cancel",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/proformaunvoid') }}/" + id,
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function(results) {

                            if (results.success) {
                                swal({
                                    position: 'top-end',
                                    title: "Done",
                                    text: results.success,
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                var oTable = $('#proformatable').dataTable();
                                oTable.fnDraw(false);
                            } else {

                                swal({
                                    title: "Error!",
                                    text: results.error,
                                    type: "error",
                                    allowOutsideClick: false,
                                });
                                var oTable = $('#proformatable').dataTable();
                                oTable.fnDraw(false);
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        });
        $('body').on('click', '.proformavoid', function() {
            var id = $(this).data('id');
            swal({
                title: "Void",
                text: "Are you sure do you want to void this data!",
                type: "question",
                showCancelButton: !0,
                allowOutsideClick: false,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Void",
                cancelButtonText: "Cancel",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'GET',
                        url: "{{ url('/proformavoid') }}/" + id,
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function(results) {

                            if (results.success) {
                                swal({
                                    position: 'top-end',
                                    title: "Done",
                                    text: results.success,
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 2000
                                });

                                var oTable = $('#proformatable').dataTable();
                                oTable.fnDraw(false);


                            } else {

                                swal({
                                    title: "Error!",
                                    text: results.error,
                                    type: "error",
                                    allowOutsideClick: false,
                                });
                                var oTable = $('#proformatable').dataTable();
                                oTable.fnDraw(false);
                            }
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })

        });

        $('body').on('click', '.proformaedit', function() {
            var id = $(this).data('id');
            $.get("proformaedit" + '/' + id, function(response) {
                $('#proformaid').val(response.proforma.id);
                $('#documentNumber').val(response.proforma.DocumentNumber);
                $('#contactPersonName').val(response.proforma.ContactPerson);
                $('#customer').selectpicker('val', response.proforma.CustomerId).trigger('change');
                $('#ContactPersonPhone').val(response.proforma.ContactPersonPhone);
                $('#orderBy').val(response.proforma.OrderBy);
                $('#store').selectpicker('val', response.proforma.store_id);
                $('#storeedit').val(response.storeName);
                $('#rfqNumber').val(response.proforma.RfQNumber);
                $('#date').val(response.proforma.CreatedDate);
                $('#memo').val(response.proforma.Memo);
                $('#numberofItemsLbl').html(response.getCountItem);
                $('#numbercounti').val(response.getCountItem);
                $('#subtotalLbl').html(numformat(response.proforma.SubTotal));
                $('#taxLbl').html(numformat(response.proforma.Tax));
                $('#grandtotalLbl').html(numformat(response.proforma.GrandTotal));
                $('#witholdingAmntLbl').html(numformat(response.proforma.WitholdAmount));
                $('#netpayLbl').html(numformat(response.proforma.NetPay));
                $('#vatAmntLbl').html(numformat(response.proforma.Vat));
                $('#subtotali').val(response.proforma.SubTotal);
                $('#taxi').val(response.proforma.Tax);
                $('#grandtotali').val(response.proforma.GrandTotal);
                $('#witholdMinAmounti').val(response.SalesWithHold);
                $('#servicewitholdMinAmounti').val(response.ServiceWithHold);
                $('#vatAmount').val(response.vatDeduct);
                memoeditor.clipboard.dangerouslyPasteHTML(response.proforma.Memo);
                calculateIndividaulGrandTotal(); //??there something here we have to check it later 
            });


            $("#inlineForm").modal('show');
            $('#storedivedit').show();
            $('#storediv').hide();
            $("#datatable-crud-childsale").show();
            $("#datatable-crud-child").hide();
            $("#adds").hide();
            $("#addnew").show();
            $("#addnewhold").hide();
            $("#dynamicTable").hide();
            $("#pricetable").show();
            $('#datatable-crud-childsale').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                destroy: true,

                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },

                ajax: {
                    url: '/proformachildlist/' + id,
                    type: 'GET',
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
                        data: 'SKUNumber',
                        name: 'SKUNumber'
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity'
                    },
                    {
                        data: 'UnitPrice',
                        name: 'UnitPrice'
                    },
                    {
                        data: 'BeforeTaxPrice',
                        name: 'BeforeTaxPrice'
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount'
                    },
                    {
                        data: 'TotalPrice',
                        name: 'TotalPrice'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],

            });


        });

        $('#customer').on('change', function() {
            $('#customer-error').html('');
            $('#customerInfoCardDiv').show();
            var customerid = $('#customer').val();
            var witholdsetle = $('#hidewitholdi').val();
            var vatsetled = $('#hidevati').val();
            $("#dynamicTable").empty();
            $("#dynamicTable").append(
                '<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th> <th>Unit Price</th><th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>'
            );
            if (customerid != null) {
                $.ajax({
                    type: "GET",
                    url: "showcustomer/" + customerid,

                    success: function(response) {
                        var colors = response.colors;
                        $('#cname').text(response.cust.Name);
                        $('#ccategory').text(response.cust.CustomerCategory);
                        $('#ctinNumber').text(response.cust.TinNumber);
                        $('#cvat').text(response.cust.VatType + "%");
                        $('#witholdPercenti').val(response.cust.Witholding);
                        $('#vatPercenti').val(response.cust.VatType);
                        if (colors == "red") {
                            $('#cdefaultPrice').html(
                                "<label class='badge badge-danger' strong style='font-size: 12px;'>" +
                                response.dprice + "</label>");
                        }
                        if (colors == "yellow") {
                            $('#cdefaultPrice').html(
                                "<label class='badge badge-warning' strong style='font-size: 12px;'>" +
                                response.dprice + "</label>");
                        }
                        if (witholdsetle == '0') {
                            $('#withodingTitleLbl').html(
                                "<p style='color:#f0ad4e;'><b>Not Settled </b>Withold Deduction  (" +
                                response.cust.Witholding + "%):</p>");
                        }
                        if (witholdsetle == '1') {
                            $('#withodingTitleLbl').html(
                                "<p style='color:#f0ad4e;'><b>Withold Deduction</b> (" + response
                                .cust.Witholding + "%):</p>");
                        }
                        if (vatsetled == '0') {
                            $('#vatTitleLbl').html(
                                "<p style='color:#f0ad4e;'<b> Not Settled </b>Vat Deduction (" +
                                response.cust.VatType + "%):</p>");
                        }
                        if (vatsetled == '1') {
                            $('#vatTitleLbl').html("<p style='color:#f0ad4e;'><b>Vat Deduction</b> (" +
                                response.cust.VatType + "%):</p>");
                        }
                        $('#cwithold').html(response.cust.Witholding + "%");

                    }
                });
            }
        });

        $('#savebutton').click(function() {
            var cust = customer.value;
            var arr = [];
            var found = 0;
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var numofitems = $('#numberofItemsLbl').text();

            $('.eName').each(function() {
                var name = $(this).val();

                if (arr.includes(name))
                    found++;
                else
                    arr.push(name);
            });
            if (found) {
                toastrMessage("error", "Item Name Can't Duplicates", "Error");
            } else {
                if (numofitems == 0) {
                    toastrMessage("error", "You should add atleast one item", "Error");
                } else {
                    $.ajax({
                        type: "POST",
                        url: "proformasave",
                        data: formData,
                        dataType: "",
                        beforeSend: function() {
                            $('#savebutton').text('Saving sale...');
                            $('#savebutton').prop('disabled', true);
                        },
                        success: function(response) {
                            if (response.errors) {
                                $('#savebutton').text('Save');
                                $('#savebutton').prop('disabled', false);
                                if (response.errors.customer) {
                                    $('#customer-error').html(response.errors.customer[0]);
                                }
                                if (response.errors.contactPersonName) {
                                    $('#contactPersonName-error').html(response.errors
                                        .contactPersonName[0]);
                                }
                                if (response.errors.ContactPersonPhone) {
                                    $('#ContactPersonPhone-error').html(response.errors
                                        .ContactPersonPhone[0]);
                                }
                                if (response.errors.orderBy) {
                                    $('#orderBy-error').html(response.errors.orderBy[0]);
                                }
                                if (response.errors.store) {
                                    $('#store-error').html(response.errors.store[0]);
                                }
                                if (response.errors.rfqNumber) {
                                    $('#rfqNumber-error').html(response.errors.rfqNumber[0]);
                                }
                                if (response.errors.date) {
                                    $('#date-error').html(response.errors.date[0]);
                                }

                            }
                            if (response.success) {
                                $('#savebutton').text('Save');
                                $('#savebutton').prop('disabled', false);
                                $("#inlineForm").modal('hide');
                                $("#dynamicTable").empty();
                                $("#dynamicTable").append(
                                    '<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th> <th>Unit Price</th><th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>'
                                );
                                $("#Register")[0].reset();
                                var oTable = $('#proformatable').dataTable();
                                oTable.fnDraw(false);
                                $('#customer').val(null).trigger('change');
                                toastrMessage("success", "Your proforma data is successfully saved",
                                    "Proforma Saved");

                            }


                        }
                    });
                }

            }
        });

        $('#savebuttonsaleitem').click(function() {
            var registerForm = $("#itemRegisterForm");
            var formData = registerForm.serialize();
            $.ajax({
                type: "POST",
                url: "proformasaveitem",
                data: formData,
                dataType: "",
                beforeSend: function() {
                    $('#savebuttonsaleitem').text('Saving...');
                    $('#savebuttonsaleitem').prop('disabled', true);
                },
                success: function(response) {
                    if (response.errors) {
                        $('#savebuttonsaleitem').prop('disabled', false);
                        $('#savebuttonsaleitem').text('Add');
                        if (response.errors.Quantity) {
                            $('#Quantity-error').html(response.errors.Quantity[0]);
                        }
                        if (response.errors.UnitPrice) {
                            $('#UnitPrice-error').html(response.errors.UnitPrice[0]);
                        }
                        if (response.errors.regitem_id) {
                            if (response.errors.regitem_id[0] == "The regitem id field is required.") {
                                $('#ItemName-error').html("Item name feild is required");
                            }
                            if (response.errors.regitem_id[0] ==
                                "The regitem id has already been taken.") {
                                $('#ItemName-error').html("The item name has already been taken.");
                            }

                        }
                    }
                    if (response.success) {
                        $('#savebuttonsaleitem').text('Add');
                        $('#savebuttonsaleitem').prop('disabled', false);
                        toastrMessage("success", "Proforma Saved Successfully");
                        $('#IteminlineForm').modal('hide');
                        var oTable = $('#datatable-crud-childsale').dataTable();
                        oTable.fnDraw(false);
                        $('#numberofItemsLbl').text(response.countitem);
                        $('#numbercounti').val(response.countitem);
                        $.each(response.pricing, function(index, value) {
                            var beforetax = value.BeforeTaxPrice;
                            var tax = parseFloat(beforetax) * 15 / 100;
                            var grandTotal = parseFloat(beforetax) + parseFloat(tax);
                            $('#subtotalLbl').html(numformat(beforetax));
                            $('#taxLbl').html(numformat(tax.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                            $('#grandtotalLbl').text(numformat(grandTotal.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                        });

                    }


                }
            });
        });

        $('body').on('click', '.addbutton', function() {
            memoeditor.clipboard.dangerouslyPasteHTML('');
            $("#proformaid").val("");
            $("#documentNumber").val("");
            $("#calcutionhide").val("0");
            $("#inlineForm").modal('show');
            $("#savebutton").show();
            $('#customerInfoCardDiv').hide();
            $('#storedivedit').hide();
            $('#customerdiv').show();
            $('#storediv').show();
            $('#itemInfoCardDiv').hide();
            $("#saveupbutton").hide();
            $("#dynamicTable").show();
            $("#adds").show();
            $("#addnew").hide();
            $("#addnewhold").hide();
            $('#subtotalLbl').html('0.0');
            $('#taxLbl').html('0.0');
            $('#grandtotalLbl').html('0.0');
            $('#numberofItemsLbl').html('0');
            $('#hidewitholdi').val('1');
            $('#hidevati').val('1');
            $("#datatable-crud-child").hide();
            $("#datatable-crud-childsale").hide();
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $("#pricetable").hide();
            $("#vatTr").hide();
            $("#hidewitholdTr").hide();
            $('#mrcdiv').show();
            $("#discountTr").hide();
            $("#date").datepicker({
                dateFormat: "yy-mm-dd"
            }).datepicker("setDate", new Date());
            $("#iteminfo").hide();
            $('#myModalLabel333').html("Add Proforma");
            $.ajax({
                type: "GET",
                url: "getcountable",
                success: function(response) {
                    var rnum = (Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
                    var commoncount = response.salecount;
                    $('.common').val(response.salecount);
                    $('#salecounti').val(rnum + commoncount);
                    $('#witholdMinAmounti').val(response.SalesWithHold);
                    $('#servicewitholdMinAmounti').val(response.ServiceWithHold);
                    $('#vatAmount').val(response.vatDeduct);
                }
            });

        });
        var i = 0;
        var j = 0;
        $("#adds").on('click', function() {
            ++i;
            ++j;
            $("#dynamicTable").append('<tr id="row' + i + '" class="dynamic-added"><td>' + j +
                '</td><td style="width: 30%;"><select id="itemNameSl" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row[' +
                i +
                '][ItemId]"><option selected disabled value=""></option>@foreach ($itemSrcs as $itemSrcs)<option value="{{ $itemSrcs->ItemId }}">{{ $itemSrcs->Code }},  {{ $itemSrcs->ItemName }},  {{ $itemSrcs->SKUNumber }}</option>@endforeach</select><span><textarea type="text" placeholder="Write Description here..." class="form-control Memo" id="Memo" name="row[' +
                i +
                '][Memo]"></textarea></span></td><td style="width:10%"><select id="uom" class="select2 form-control uom" onchange="uomVal(this)" name="row[' +
                i +
                '][uom]"></select><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td><input type="text" name="row[' +
                i +
                '][AvQuantity]" id="AvQuantity" class="AvQuantity form-control" readonly/><input type="hidden" name="row[' +
                i +
                '][AvQuantityh]" id="AvQuantityh" class="AvQuantityh form-control"  readonly/><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td><input type="text" name="row[' +
                i +
                '][Quantity]" placeholder="Quantity" id="quantity" class="quantity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="ValidQuantity(this)"/><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td style="width:10%"><input type="text" name="row[' +
                i +
                '][UnitPrice]" placeholder="Unit Price" id="unitprice" class="unitprice form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly  @can('UnitPrice-Active') ondblclick="unitpriceActive(this)"; @endcan <span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td><input type="text" name="row[' +
                i +
                '][BeforeTaxPrice]" id="" class="beforetax form-control"  style="font-weight:bold;" readonly/><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td><input type="text" name="row[' +
                i +
                '][TaxAmount]" id="taxamounts" class="taxamount form-control"  style="font-weight:bold;" readonly/><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td><input type="text" name="row[' +
                i +
                '][TotalPrice]" id="total" class="total form-control"  style="font-weight:bold;" readonly/><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td><td><input type="hidden" name="row[' +
                i +
                '][StoreId]" id="storeappend" class="storeappend form-control" readonly/></td><td><td><input type="hidden" name="row[' +
                i +
                '][Common]" id="common" class="common form-control" readonly/></td><td><input type="hidden" name="row[' +
                i +
                '][TransactionType]" id="TransactionType" class="TransactionType form-control" value="Sales" readonly/></td><td><input type="hidden" name="row[' +
                i +
                '][ItemType]" id="ItemType" class="ItemType form-control" value="Goods" readonly/></td><td><input type="hidden" name="row[' +
                i +
                '][DefaultUOMId]" id="DefaultUOMId" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][NewUOMId]" id="NewUOMId" class="NewUOMId form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][ConversionAmount]" id="ConversionAmount" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][ConvertedQuantity]" id="ConvertedQuantity" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][mainPrice]" id="mainPrice" class="mainPrice form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][maxCost]" id="maxCost" class="maxCost form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][DiscountAmount]" id="discountamount" class="discountamount form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][wholesaleminamount]" id="wholesaleminamount" class="wholesaleminamount form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][retailprice]" id="retailprice" class="retailprice form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][wholesaleprice]" id="wholesaleprice" class="wholesaleprice form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][minimumstock]" id="minimumstock" class="minimumstock form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][avaliableAllquantity]" id="avaliableAllquantity" class="avaliableAllquantity form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row[' +
                i +
                '][checkependingQauntity]" id="checkependingQauntity" class="checkependingQauntity form-control" readonly="true" style="font-weight:bold;"/></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">X</button><span><textarea type="text" placeholder="Write Description here..." class="form-control" style="visibility:hidden;"></textarea></span></td>'
            );
            var sc = $('#salecounti').val();
            $('.common').val(sc);
            renumberRows();
            var sroreidvar = $('#store').val();
            $('.storeappend').val(sroreidvar);
            $(".eName").select2({
                placeholder: "Select Item here",
            });

            var defaultprice = $('#cdefaultPrice').text();
            if (defaultprice == 'Wholeseller') {

            }
            if (defaultprice == 'Retailer') {

            }
        });

        $(document).on('click', '.remove-tr', function() {
            --i;
            $(this).parents('tr').remove();
            $("#hidewithold").prop("checked", false);
            CalculateGrandTotal();
            renumberRows();

        });

        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                $('#numberofItemsLbl').html(index - 1);
                $('#numbercounti').val(index - 1);
                ind = index - 1;
            });
            if (ind == 0) {
                $('#itemcodeInfoLbl').text("");
                $('#itemInfoLbl').text("");
                $('#itemInfoLbl').text("");
                $('#uomInfoLbl').text("");
                $('#itemCategoryInfoLbl').text("");
                $('#rpInfoLbl').text("");
                $('#wsInfoLbl').text("");
                $('#partNumInfoLbl').text("");
                $('#skuInfoLbl').text("");
                $('#taxInfoLbl').text("");
                $('#itemInfoCardDiv').hide();
                $('#pricetable').hide();
            } else {
                $('#itemInfoCardDiv').show();
                $('#pricetable').show();
            }

        }

        function calculateIndividaulGrandTotal() {

            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var ttwithold = 0;
            var ttvat = 0;
            var witholdam = $('#witholdMinAmounti').val();
            var vatamount = $('#vatAmount').val();
            var vatpercent = $('#vatPercenti').val();
            var Servicewitholdam = $('#servicewitholdMinAmounti').val();
            var witholdpr = $('#witholdPercenti').val();
            subtotal = $('#subtotali').val();
            tax = $('#taxi').val();
            grandTotal = $('#grandtotali').val();
            var cc = $('#ccategory').text();
            if ((parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) || (parseFloat(subtotal) >=
                    parseFloat(vatamount) && parseFloat(vatpercent) > 0)) {
                var st = parseFloat(subtotal);
                var wp = parseFloat(witholdpr);
                var vt = parseFloat(vatpercent);
                var tp = 0;
                var tt = 0;
                var np = 0;

                if (parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                    tp = wp;
                    $("#witholdingTr").show();
                    $("#netpayTr").show();
                    $("#vatTr").hide();
                    $("#hidewitholdTr").hide();
                }
                if (parseFloat(subtotal) >= parseFloat(vatamount) && parseFloat(vatpercent) > 0) {
                    tp = vt;
                    $("#witholdingTr").hide();
                    $("#netpayTr").show();
                    $("#vatTr").show();
                    $("#hidewitholdTr").hide();

                }
                if ((parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) && (parseFloat(subtotal) >=
                        parseFloat(vatamount) && parseFloat(vatpercent) > 0)) {
                    tp = vt + wp;
                    $("#witholdingTr").show();
                    $("#netpayTr").show();
                    $("#vatTr").show();
                    $("#hidewitholdTr").hide();

                }

                tt = ((st * tp) / 100).toString().match(/^\d+(?:\.\d{0,2})?/);
                ttwithold = (st * wp) / 100;
                ttvat = (st * vt) / 100;
                np = parseFloat(grandTotal) - parseFloat(tt);
                $('#witholdingAmntLbl').html(numformat(ttwithold.toFixed(2)));
                $('#witholdingAmntin').val(ttwithold.toFixed(2));
                $('#vatAmntLbl').html(numformat(ttvat.toFixed(2)));
                $('#vatAmntin').val(ttvat.toFixed(2));
                $('#netpayLbl').html(numformat(np.toFixed(2)));
                $('#netpayin').val(np.toFixed(2));
                if (cc === "Foreigner-Supplier" || cc === "Person") {
                    $("#witholdingTr").hide();
                    $("#netpayTr").hide();
                    $("#vatTr").hide();
                    $("#hidewitholdTr").hide();
                } else if (parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                    // $("#witholdingTr").show();
                    // $("#netpayTr").show();  
                    // $("#vatTr").show(); 
                }
            } else if (parseFloat(subtotal) < parseFloat(witholdam) || parseFloat(witholdpr) == 0) {
                $('#witholdingAmntLbl').html("0");
                $('#vatAmntLbl').html("0");
                $('#witholdingAmntin').val("0");
                $('#vatAmntin').val("0");
                $('#netpayLbl').html("0");
                $('#netpayin').val("0");
                $("#witholdingTr").hide();
                $("#netpayTr").hide();
                $("#vatTr").hide();
                $("#hidewitholdTr").hide();
            } else if (isNaN(parseFloat(vatpercent))) {
                $("#vatTr").hide();
            } else if (isNaN(parseFloat(witholdpr))) {
                $("#witholdingTr").hide();
            } else if (isNaN(parseFloat(witholdpr)) && isNaN(parseFloat(vatpercent))) {
                $("#witholdingTr").hide();
                $("#netpayTr").hide();
                $("#vatTr").hide();
            }
            $('#subtotalLbl').html(numformat(subtotal));
            $('#taxLbl').html(numformat(tax));
            $('#grandtotalLbl').html(numformat(grandTotal));
            $('#subtotali').val(subtotal);
            $('#taxi').val(tax);
            $('#grandtotali').val(grandTotal);
            //alert(subtotal+" "+tax+" "+grandTotal+" "+witholdpr+" "+parseFloat(vatpercent));
        }



        function CalculateGrandTotal() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var discountamount = 0;
            var discountPercent = 0;
            var witholdam = $('#witholdMinAmounti').val();
            var vatamount = $('#vatAmount').val();
            var vatpercent = $('#vatPercenti').val();
            var Servicewitholdam = $('#servicewitholdMinAmounti').val();
            var witholdpr = $('#witholdPercenti').val();

            $.each($('#dynamicTable').find('.beforetax'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });

            $.each($('#dynamicTable').find('.taxamount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    tax += parseFloat($(this).val());
                }
            });

            $.each($('#dynamicTable').find('.total'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });

            var cc = $('#ccategory').text();
            if ((parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) || (parseFloat(subtotal) >=
                    parseFloat(vatamount) && parseFloat(vatpercent) > 0)) {
                var st = parseFloat(subtotal);
                var wp = parseFloat(witholdpr);
                var vt = parseFloat(vatpercent);
                var tp = 0;
                var tt = 0;
                var np = 0;
                if (parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                    tp = wp;

                }
                if (parseFloat(subtotal) >= parseFloat(vatamount) && parseFloat(vatpercent) > 0) {
                    tp = vt;

                }
                if ((parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) && (parseFloat(subtotal) >=
                        parseFloat(vatamount) && parseFloat(vatpercent) > 0)) {
                    tp = vt + wp;

                }
                tt = ((st * tp) / 100).toFixed(2);
                var ttwithold = (st * wp) / 100;
                var ttvat = (st * vt) / 100;
                var taxinp = (parseFloat(subtotal) * 15) / 100;
                var grandTotalinp = (parseFloat(taxinp) + parseFloat(subtotal)).toString().match(/^\d+(?:\.\d{0,2})?/);
                np = parseFloat(grandTotalinp) - parseFloat(tt);
                $('#witholdingAmntLbl').html(numformat(ttwithold.toFixed(2)));
                $('#witholdingAmntin').val(ttwithold);
                $('#vatAmntLbl').html(numformat(ttvat.toFixed(2)));
                $('#vatAmntin').val(ttvat.toFixed(2));
                $('#netpayLbl').html(numformat(np.toFixed(2)));
                $('#netpayin').val(np.toFixed(2));
                if (cc === "Foreigner-Supplier" || cc === "Person") {
                    $("#witholdingTr").hide();
                    $("#netpayTr").hide();
                    $("#vatTr").hide();
                    $("#hidewitholdTr").hide();
                }
                if (parseFloat(subtotal) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                    $("#witholdingTr").show();
                    $("#netpayTr").show();
                    $("#hidewitholdTr").hide();
                }
                if (parseFloat(subtotal) >= parseFloat(vatamount) && parseFloat(vatpercent) > 0) {
                    $("#netpayTr").show();
                    $("#vatTr").show();
                    $("#hidewitholdTr").hide();
                }
            }
            if (parseFloat(vatpercent) == 0) {
                $("#vatTr").hide();
            }
            if (parseFloat(subtotal) < parseFloat(witholdam) || parseFloat(witholdpr) == 0) {
                $('#witholdingAmntLbl').html("0");
                $('#witholdingAmntin').val("0");
                $("#witholdingTr").hide();
            }

            if (parseFloat(subtotal) < parseFloat(vatamount) || parseFloat(vatpercent) == 0) {

                $('#vatAmntLbl').html("0");
                $('#vatAmntin').val("0");
                $("#vatTr").hide();

            }
            if ((parseFloat(subtotal) < parseFloat(vatamount) && parseFloat(vatpercent) == 0) || (parseFloat(subtotal) <
                    parseFloat(witholdam) && parseFloat(witholdpr) == 0)) {
                $('#netpayLbl').html("0");
                $('#netpayin').val("0");
                $("#netpayTr").hide();
            }
            if ((parseFloat(subtotal) < parseFloat(vatamount)) || (parseFloat(subtotal) < parseFloat(witholdam))) {
                $('#netpayLbl').html("0");
                $('#netpayin').val("0");
                $("#netpayTr").hide();
            }
            var taxi = (parseFloat(subtotal) * 15) / 100;
            var grandTotali = parseFloat(taxi) + parseFloat(subtotal);
            var grandTotalbeforediscount = parseFloat(grandTotali) + parseFloat();
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#taxLbl').html(numformat(taxi.toFixed(2).toString().match(/^\d+(?:\.\d{0,2})?/)));
            $('#grandtotalLbl').html(numformat(grandTotali.toFixed(2).toString().match(/^\d+(?:\.\d{0,2})?/)));
            $('#discountamountLbl').html(numformat(discountamount.toFixed(2)));
            $('#discountamountextLbl').html('Discount (' + discountPercent + '%):');
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxi').val(taxi.toString().match(/^\d+(?:\.\d{0,2})?/));
            $('#grandtotali').val(grandTotali.toString().match(/^\d+(?:\.\d{0,2})?/));
            $('#discountamountli').val(discountamount.toFixed(2));

        }

        function itemVal(ele) {
            var itemid = $(ele).closest('tr').find('.eName').val();
            $(ele).closest('tr').find('.quantity').val('');
            $(ele).closest('tr').find('.beforetax').val('0.0');
            $(ele).closest('tr').find('.taxamount').val('0.0');
            $(ele).closest('tr').find('.total').val('0.0');
            var storeval = store.value;
            if (itemid != null) {
                $.get("/showItemInfo" + '/' + itemid + '/' + storeval, function(data) {

                    if (data.Regitem) {
                        $.each(data.Regitem, function(index, value) {
                            var itemWsVar = value.WholesellerPrice;
                            var itemRpVar = value.RetailerPrice;
                            var avalaiblequantity = data['getQuantity'][index].AvailableQuantity;
                            var getCheckedPending = data['getCheckedPending'][index].CheckedQuantity;
                            var maxCostval = value.Maxcost;
                            var wholesaleminAmountVar = value.wholeSellerMinAmount;
                            var minimumstock = value.MinimumStock;
                            var avaliableAllquantity = data['getAllQuantity'][index].AllAvailableQuantity;
                            $(ele).closest('tr').find('.wholesaleprice').val((itemWsVar / 1.15).toFixed(2));
                            $(ele).closest('tr').find('.retailprice').val((itemRpVar / 1.15).toFixed(2));
                            if (avalaiblequantity == null) {
                                $(ele).closest('tr').find('.AvQuantity').val('0');
                                $(ele).closest('tr').find('.AvQuantityh').val('0');
                            }
                            if (avalaiblequantity > 0) {
                                $(ele).closest('tr').find('.AvQuantity').val(avalaiblequantity);
                                $(ele).closest('tr').find('.AvQuantityh').val(avalaiblequantity);
                            }
                            $(ele).closest('tr').find('.unitprice').val((itemRpVar / 1.15).toFixed(2));
                            $(ele).closest('tr').find('.mainPrice').val((itemRpVar / 1.15).toFixed(2));
                            var description = value.Description;
                            var textData = description.replace(/<\/?[^>]+(>|$)/g, "");
                            $(ele).closest('tr').find('.Memo').html(textData);
                        });
                    }
                });

                $(ele).closest('tr').find('.uom').empty();

                $.ajax({
                    url: 'saleUOMS/' + itemid,
                    type: 'DELETE',
                    data: '',
                    success: function(data) {
                        if (data.sid) {
                            var defname = data['defuom'];
                            var defid = data['uomid'];
                            var option = "<option selected value='" + defid + "'>" + defname + "</option>";
                            $(ele).closest('tr').find('.uom').append(option);
                            $(ele).closest('tr').find('.DefaultUOMId').val(defid);
                            $(ele).closest('tr').find('.NewUOMId').val(defid);
                            $(ele).closest('tr').find('.ConversionAmount').val("1");
                            $.each(data.sid, function(index, value) {
                                var name = value.ToUnitName;
                                var id = value.ToUomID;
                                var option = "<option value='" + id + "'>" + name + "</option>";
                                $(ele).closest('tr').find('.uom').append(option);

                            });
                            $(ele).closest('tr').find('.uom').select2();
                        }
                    },
                });
            }
            CalculateGrandTotal();
        }

        function uomVal(ele) {
            var uomnewval = $(ele).closest('tr').find('.uom').val();
            var UnitpriceVal = $(ele).closest('tr').find('.unitprice').val();
            var mainpriceval = $(ele).closest('tr').find('.mainPrice').val();
            var quantityOnhand = $(ele).closest('tr').find('.AvQuantity').val();
            var quantityOnhandh = $(ele).closest('tr').find('.AvQuantityh').val();
            var uomdefval = $(ele).closest('tr').find('.DefaultUOMId').val();
            $(ele).closest('tr').find('.NewUOMId').val(uomnewval);

            if (parseFloat(uomnewval) == parseFloat(uomdefval)) {
                $(ele).closest('tr').find('.ConversionAmount').val("1");
                $(ele).closest('tr').find('.unitprice').val(mainpriceval);
                $(ele).closest('tr').find('.AvQuantity').val(quantityOnhandh);
            } else if (parseFloat(uomnewval) != parseFloat(uomdefval)) {
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                if (uomnewval != null) {
                    $.ajax({
                        type: "DELETE",
                        url: "getsaleUOMAmount/" + uomdefval + "/" + uomnewval,
                        data: formData,
                        dataType: "",
                        success: function(response) {
                            if (response.sid) {
                                var amount = response['sid'];
                                $(ele).closest('tr').find('.ConversionAmount').val(amount);
                                var Result = mainpriceval / amount;
                                var onhandResult = quantityOnhandh / amount;
                                $(ele).closest('tr').find('.unitprice').val(Result);
                                $(ele).closest('tr').find('.AvQuantity').val(onhandResult);
                            }
                        }
                    });
                }

            }
            $(ele).closest('tr').find('.quantity').val("");
            $(ele).closest('tr').find('.ConvertedQuantity').val("");

        }

        function removeItemNameValidation() {
            var sid = $('#ItemName').val();
            var storeval = store.value;
            var headerid = $("#proformaid").val();
            $('#ItemName-error').html('');
            $('#UnitPrice-error').html('');
            $('#Quantity').val('');
            $('#BeforeTaxPrice').val('0');
            $('#TaxAmount').val('0');
            $('#TotalPrice').val('0');
            if (sid != '') {

                $.get("getsalesitemdetails" + '/' + sid + '/' + storeval + '/' + headerid, function(data, textStatus,
                    jqXHR) {
                    $.each(data.Regitem, function(index, value) {
                        var rprice = value.RetailerPrice;
                        var wprice = value.WholesellerPrice;
                        var wholesalminamount = value.wholeSellerMinAmount;
                        var avalaiblequantity = data['getQuantity'][index].AvailableQuantity;
                        var allQuantity = data['getAllQuantity'][index].AllAvailableQuantity;
                        var checkpendingQuantity = data['getCheckedPending'][index].CheckedQuantity;
                        var minimumstock = value.MinimumStock;
                        var maxcostVal = value.Maxcost;

                        $('#UnitPrice').val((rprice / 1.15).toFixed(2));
                        $('#mainPricei').val((rprice / 1.15).toFixed(2));
                        $('#Rsaleprice').val((rprice / 1.15).toFixed(2));
                        if (avalaiblequantity > 0) {
                            $('#avQuantitiy').val(avalaiblequantity);
                            $('#avQuantitiyh').val(avalaiblequantity);
                        }
                        if (avalaiblequantity == null || avalaiblequantity == 0) {
                            $('#avQuantitiy').val('0');
                            $('#avQuantitiyh').val('0');
                        }
                    });
                });
                $("#uoms").empty();
                $.ajax({
                    type: "DELETE",
                    url: "saleUOMS/" + sid,
                    success: function(response) {
                        if (response.sid) {
                            var defname = response['defuom'];
                            var defid = response['uomid'];
                            var option = "<option selected value='" + defid + "'>" + defname + "</option>";
                            $("#uoms").append(option);
                            $("#defaultuomi").val(defid);
                            $("#newuomi").val(defid);
                            $("#convertedamnti").val("1");
                            $.each(response.sid, function(index, value) {
                                var name = value.ToUnitName;
                                var id = value.ToUomID;
                                var option = "<option value='" + id + "'>" + name + "</option>";
                                $("#uoms").append(option);
                            });

                            $('#uoms').select2();
                        }
                    }
                });
            }


        }

        function CalculateAddHoldTotal(ele) {
            var availableq = $(ele).closest('tr').find('#avQuantitiy').val();
            var quantitys = $(ele).closest('tr').find('#Quantity').val();
            var retialprice = $(ele).closest('tr').find('#Rsaleprice').val();
            var inputid = ele.getAttribute('id');
            var taxpercent = "15";
            var quantity = $('#Quantity').val();
            var unitcost = $('#UnitPrice').val();
            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;
            if (!isNaN(unitcost) && !isNaN(quantity)) {
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                var linetotal = parseFloat(total) + parseFloat(taxamount);
                $('#BeforeTaxPrice').val(total.toFixed(2));
                $('#TaxAmount').val(taxamount.toFixed(2));
                $('#TotalPrice').val(linetotal.toFixed(2));
            }
            var defuom = $('#defaultuomi').val();
            var newuom = $('#newuomi').val();
            var convamount = $('#convertedamnti').val();
            var convertedq = parseFloat(quantity) / parseFloat(convamount);
            $('#convertedqi').val(convertedq);

        }

        function uomsavedVal(ele) {
            var uomnewval = $('#uoms').val();
            $('#newuomi').val(uomnewval);
            var uomdefval = $('#defaultuomi').val();
            var mainpriceVal = $('#mainPricei').val();
            var quntityOnhand = $('#avQuantitiy').val();
            var quntityOnhandh = $('#avQuantitiyh').val();
            $('#Quantity').val('');
            $('#BeforeTaxPrice').val('0');
            $('#TaxAmount').val('0');
            $('#TotalPrice').val('0');
            if (parseFloat(uomnewval) == parseFloat(uomdefval)) {
                $('#convertedamnti').val("1");
                $('#UnitPrice').val(mainpriceVal);
                $('#avQuantitiy').val(quntityOnhandh);
            } else if (parseFloat(uomnewval) != parseFloat(uomdefval)) {
                if (uomnewval != null) {
                    $.ajax({
                        type: "DELETE",
                        url: "getsaleUOMAmount/" + uomdefval + "/" + uomnewval,
                        data: "",
                        dataType: "",
                        success: function(response) {
                            if (response.sid) {
                                var amount = response['sid'];
                                var Result = mainpriceVal / amount;
                                var onHandQuantity = quntityOnhandh / amount;
                                $('#UnitPrice').val(Result);
                                $('#convertedamnti').val(amount);
                                $('#avQuantitiy').val(onHandQuantity);
                            }
                        }
                    });
                }
            }
            $('#convertedqi').val("");
            $('#Quantity').val("");
        }


        function CalculateTotal(ele) {
            var availableq = $(ele).closest('tr').find('.AvQuantity').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            var minAmount = $(ele).closest('tr').find('.wholesaleminamount').val();
            var retialprice = $(ele).closest('tr').find('.retailprice').val();
            var wholesaleprice = $(ele).closest('tr').find('.wholesaleprice').val();
            var minimumstock = $(ele).closest('tr').find('.minimumstock').val();
            var AllAvailableQuantity = $(ele).closest('tr').find('.avaliableAllquantity').val();
            var checkependingQauntity = $(ele).closest('tr').find('.checkependingQauntity').val();

            var inputid = ele.getAttribute('id');
            if (inputid == 'quantity') {
                // some code is here
            }
            if (inputid == 'unitprice') {
                //some code of there is 
            }
            if (parseFloat(quantity) == 0) {
                $(ele).closest('tr').find('.quantity').val('');
            }
            var taxpercent = "15";
            var unitprice = $(ele).closest('tr').find('.unitprice').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            unitprice = unitprice == '' ? 0 : unitprice;
            quantity = quantity == '' ? 0 : quantity;

            if (!isNaN(unitprice) && !isNaN(quantity)) {
                var total = parseFloat(unitprice) * parseFloat(quantity);
                var taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                var linetotal = parseFloat(total) + parseFloat(taxamount);
                $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
                //$(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
                $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
                $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
            }
            var defuom = $(ele).closest('tr').find('.DefaultUOMId').val();
            var newuom = $(ele).closest('tr').find('.NewUOMId').val();
            var convamount = $(ele).closest('tr').find('.ConversionAmount').val();
            var convertedq = parseFloat(quantity) / parseFloat(convamount);
            $(ele).closest('tr').find('.ConvertedQuantity').val(convertedq);
            CalculateGrandTotal();
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        function removeContactPersonNameValidation() {
            $('#contactPersonName-error').html('');
        }

        function removeContactPersonPhoneValidation() {
            $('#ContactPersonPhone-error').html('');
        }

        function removevorderByValidation() {
            $('#orderBy-error').html('');
        }

        function removeStoreValidation() {
            $('#store-error').html('');
        }

        function removerfqNumberValidation() {
            $('#rfqNumber-error').html('');
        }

        function removeDateValidation() {
            $('#date-error').html('');
        }

        function closeinlineFormModalWithClearValidation() {
            $("#dynamicTable").empty();
            $("#dynamicTable").append(
                '<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th> <th>Unit Price</th><th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>'
            );
            $('#customer').val(null).trigger('change');
            $('#savebutton').text('Save');
            $('#savebutton').prop('disabled', false);
            $('#contactPersonName-error').html('');
            $('#ContactPersonPhone-error').html('');
            $('#orderBy-error').html('');
            $('#store-error').html('');
            $('#rfqNumber-error').html('');
            $('#date-error').html('');
            $("#Register")[0].reset();
        }

        function closeIteminlineFormModalWithClearValidation() {
            $('#Quantity-error').html('');
            $('#UnitPrice-error').html('');
            $('#discount-error').html('');
            $('#ItemName-error').html('');
            $('#ItemType-error').html('');
            $('#savebuttonsaleitem').text('Add');
            $('#savebuttonitem').text('Add');
            $('#savebuttonitem').prop('disabled', false);
            $('#savebuttonsaleitem').prop('disabled', false);
        }

        function removeQuantityValidation() {
            $('#Quantity-error').html('');
        }

        function removeUnitPriceValidation() {
            $('#UnitPrice-error').html('');
        }

        function ValidQuantity(ele) {

        }

        function ValidatePhone(event) {
            var regex = new RegExp("^[0-9/+/-]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }

        function unitpriceSingleActive() {
            $("#UnitPrice").prop("readonly", false);
        }

        function unitpriceActive(ele) {
            $(ele).closest('tr').find('.unitprice').prop("readonly", false);
        }

        //Start show proforma doc info
        $(document).on('click', '.DocPrInfo', function() {
            var recordId = $(this).data('id');
            var statusval = $(this).data('status');
            $('#recordIds').val(recordId);
            $('#witholdProTr').hide();
            $('#vatProTr').hide();
            $('#netpayProTr').hide();
            $.get("getproformainfo/" + recordId,
                function(data, textStatus, jqXHR) {
                    $.each(data.proformainfo, function(indexInArray, valueOfElement) {
                        $('#infoDocDocNo').html(valueOfElement.DocumentNumber);
                        $('#infoDocCustomerCategory').html(valueOfElement.CustomerCategory);
                        $('#infoDocCustomerName').html(valueOfElement.Name);
                        $('#infoTINum').html(valueOfElement.TinNumber);
                        $('#infoShop').html(valueOfElement.StoreName);
                        $('#infoContactPersonName').html(valueOfElement.ContactPerson);
                        $('#infoContactPersonPhone').html(valueOfElement.ContactPersonPhone);
                        $('#infoOrderBy').html(valueOfElement.OrderBy);
                        $('#infoRfqNum').html(valueOfElement.RfQNumber);
                        $('#infoUsername').html(valueOfElement.Username);
                        $('#infoDate').html(valueOfElement.CreatedDate);
                        $('#infoMemo').html(valueOfElement.Memo);
                        $('#infosubtotal').html(valueOfElement.SubTotal);
                        $('#infotax').html(valueOfElement.Tax);
                        $('#infograndtotal').html(valueOfElement.GrandTotal);
                        //$('#infoVoidReason').html(valueOfElement.CustomerCategory);
                        var status = valueOfElement.Status;
                        if (status === "pending..") {
                            $('#infoStatus').html(
                                "<label class='badge badge-warning' strong style='font-size: 14px;'>" +
                                valueOfElement.Status + "</label>");
                        }
                        if (status === "Void") {
                            $('#infoStatus').html(
                                "<label class='badge badge-danger' strong style='font-size: 14px;'>" +
                                valueOfElement.Status + "</label>");
                        }
                        if (status === "Sold") {
                            $('#infoStatus').html(
                                "<label class='badge badge-success' strong style='font-size: 14px;'>" +
                                valueOfElement.Status + "</label>");
                        }
                        var withold = valueOfElement.WitholdAmount;
                        var vat = valueOfElement.Vat;
                        var netpay = valueOfElement.NetPay;
                        if (parseFloat(withold) > 0) {
                            $('#witholdProTr').show();
                            $('#netpayProTr').show();
                            $('#infoWithold').html(valueOfElement.WitholdAmount);
                            $('#infoNetpay').html(valueOfElement.NetPay);
                        }
                        if (parseFloat(vat) > 0) {
                            $('#vatProTr').show();
                            $('#netpayProTr').show();
                            $('#infoVat').html(valueOfElement.Vat);
                            $('#infoNetpay').html(valueOfElement.NetPay);
                        }

                    });
                });

            $('#docInfoItem').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                info: false,
                destroy: true,

                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },

                ajax: {
                    url: '/proformainfolist/' + recordId,
                    type: 'GET',
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
                        data: 'SKUNumber',
                        name: 'SKUNumber'
                    },
                    {
                        data: 'UOMName',
                        name: 'UOMName'
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity'
                    },
                    {
                        data: 'UnitPrice',
                        name: 'UnitPrice'
                    },
                    {
                        data: 'BeforeTaxPrice',
                        name: 'BeforeTaxPrice'
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount'
                    },
                    {
                        data: 'TotalPrice',
                        name: 'TotalPrice'
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        'visible': false
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.ItemType == "Goods") {
                        for (var i = 0; i <= 8; i++) {
                            $(nRow).find('td:eq(' + i + ')').css({
                                "font-size": "10px"
                            });
                        }
                    }
                }
            });
            $("#docInfoModal").modal('show');
        });
        //End show receiving doc info

        function refreshContent() {
            var recordId = $('#recordIds').val();
            $.get("getproformainfo/" + recordId,
                function(data, textStatus, jqXHR) {
                    $.each(data.proformainfo, function(indexInArray, valueOfElement) {
                        $('#infoDocDocNo').html(valueOfElement.DocumentNumber);
                        $('#infoDocCustomerCategory').html(valueOfElement.CustomerCategory);
                        $('#infoDocCustomerName').html(valueOfElement.Name);
                        $('#infoTINum').html(valueOfElement.TinNumber);
                        $('#infoShop').html(valueOfElement.StoreName);
                        $('#infoContactPersonName').html(valueOfElement.ContactPerson);
                        $('#infoContactPersonPhone').html(valueOfElement.ContactPersonPhone);
                        $('#infoOrderBy').html(valueOfElement.OrderBy);
                        $('#infoRfqNum').html(valueOfElement.RfQNumber);
                        $('#infoUsername').html(valueOfElement.Username);
                        $('#infoDate').html(valueOfElement.CreatedDate);
                        $('#infoMemo').html(valueOfElement.Memo);
                        //$('#infoVoidReason').html(valueOfElement.CustomerCategory);
                        var status = valueOfElement.Status;
                        if (status === "pending..") {
                            $('#infoStatus').html(
                                "<label class='badge badge-warning' strong style='font-size: 14px;'>" +
                                valueOfElement.Status + "</label>");
                        }
                        if (status === "Void") {
                            $('#infoStatus').html(
                                "<label class='badge badge-danger' strong style='font-size: 14px;'>" +
                                valueOfElement.Status + "</label>");
                        }
                        if (status === "Sold") {
                            $('#infoStatus').html(
                                "<label class='badge badge-success' strong style='font-size: 14px;'>" +
                                valueOfElement.Status + "</label>");
                        }
                    });
                });
        }

        function refreshdetailtable() {
            var recordId = $('#recordIds').val();
            $.get("getproformainfo/" + recordId,
                function(data, textStatus, jqXHR) {
                    $.each(data.proformainfo, function(indexInArray, valueOfElement) {
                        $('#infosubtotal').html(valueOfElement.SubTotal);
                        $('#infotax').html(valueOfElement.Tax);
                        $('#infograndtotal').html(valueOfElement.GrandTotal);
                        var withold = valueOfElement.WitholdAmount;
                        var vat = valueOfElement.Vat;
                        var netpay = valueOfElement.NetPay;
                        if (parseFloat(withold) > 0) {
                            $('#witholdProTr').show();
                            $('#netpayProTr').show();
                            $('#infoWithold').html(valueOfElement.WitholdAmount);
                            $('#infoNetpay').html(valueOfElement.NetPay);
                        }
                        if (parseFloat(vat) > 0) {
                            $('#vatProTr').show();
                            $('#netpayProTr').show();
                            $('#infoVat').html(valueOfElement.Vat);
                            $('#infoNetpay').html(valueOfElement.NetPay);
                        }
                    });
                });
            var oTable = $('#docInfoItem').dataTable();
            oTable.fnDraw(false);
        }


        $(document).on('click', '.docDescInfo', function() {
            var itemcode = $(this).data('code');
            var itemname = $(this).data('iname');
            var recordId = $('#recordIds').val();
            $('#memomodaltitle').html("<b>" + itemname + "</b> Description");
            $.get("getmemoinfo/" + recordId + "/" + itemcode,
                function(data, textStatus, jqXHR) {
                    $.each(data.proformalist, function(indexInArray, valueOfElement) {
                        var memo = valueOfElement.Memo;
                        if (memo === "" || memo == null) {} else {
                            $('#infoMemoLbl').text(valueOfElement.Memo);
                            $("#memomodal").modal('show');
                        }
                    });
                });
        });


        // $('#docInfoItem').on('mousemove', 'tr', function(e) {
        //     $("#memomodal").modal('show');
        // });

        // $('#docInfoItem').on('mouseleave', function(e) {
        //     $("#memomodal").modal('hide');
        // });
    </script>
@endsection
