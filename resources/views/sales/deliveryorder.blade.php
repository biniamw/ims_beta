@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Dispatch-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Delivery Order</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDOFn()"><i class="fas fa-sync-alt"></i></button>
                                            @can('Dispatch-Add')
                                            <button type="button" class="btn btn-gradient-info btn-sm addDeliveryOrder header-prop" id="addDeliveryOrder"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                            @endcan 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-datatable">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content">
                                    <div class="row mt-1 border-bottom mx-n2 pl-1">
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-secondary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_draft_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Draft</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-warning mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_pending_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Pending</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-primary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_verified_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Verified</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-success mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_approved_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Approved</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-danger mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_void_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Void</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-secondary mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-box-archive"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_total_record_lbl"></span>
                                                        <p class="card-text font-small-3 mb-0">Total</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-sm-3 col-lg custom-col mb-1">
                                            <div class="stat-item">
                                                <div class="media">
                                                    <div class="avatar bg-light-success mr-1">
                                                        <div class="avatar-content">
                                                            <i class="fa-solid fa-check-double"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body my-auto mr-1">
                                                        <span class="font-weight-bolder mb-0 do_status_record_lbl" id="do_ready_record_lbl"></span>
                                                        <p title="Ready for Delivery Order" class="card-text font-small-3 mb-0">Ready for DO</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>      
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 fit-content" style="display: none;">
                                    <div class="row main_datatable" id="delivery_order_tbl">
                                        <div style="width:99%; margin-left:0.5%;">
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt fit-content" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:11%;" title="Dispatch Document Number">Document No.</th>
                                                        <th style="width:10%;">Dispatch Type</th>
                                                        <th style="width:10%;">Dispatch Mode</th>
                                                        <th style="width:11%;">Driver/ Person Name</th>
                                                        <th style="width:11%;" title="Driver or Person Phone Number">Driver/ Person Phone No.</th>
                                                        <th style="width:10%;" title="Driver License Number">Driver License No.</th>
                                                        <th style="width:10%;" title="Plate Number">Plate No.</th>
                                                        <th style="width:10%;">Date</th>
                                                        <th style="width:10%;">Status</th>
                                                        <th style="width:4%;">Action</th>
                                                        <th style="display: none;"></th>
                                                        <th style="display: none;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="fiscalyearval" id="fiscalyearval" value="{{$fiscalyr}}" readonly/>
                                    <input type="hidden" class="form-control" name="currentdateval" id="currentdateval" value="{{$curdate}}" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endcan

    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="delivery_order_title"></h4>
                    <div class="row">
                        <div style="text-align: right;" class="form_title" id="delivery_order_status"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>  
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-8 col-lg-6 col-md-12 col-sm-12 col-12 mb-1"> 
                                <fieldset class="fset">
                                    <legend>General Data</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Reference Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ReferenceType" id="ReferenceType">
                                                @foreach ($ref_type_data as $reftype)
                                                    <option value="{{ $reftype->id }}">{{ $reftype->LookupName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="reference-type-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1 reference_doc default_hidden_div" id="reference_doc_div">
                                            <label class="form_lbl" title="Reference Document">Reference<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="Reference" id="Reference"></select>
                                            <span class="text-danger">
                                                <strong id="reference-doc-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="product_type_div">
                                            <label class="form_lbl">Product Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ProductType" id="ProductType" onchange="productTypeFn()"></select>
                                            <span class="text-danger">
                                                <strong id="product-type-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="station" id="station"></select>
                                            <span class="text-danger">
                                                <strong id="station-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Delivery Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" id="DeliveryDate" name="DeliveryDate" class="form-control flatpickr-basicl reg_form" placeholder="YYYY-MM-DD" onchange="deliveryDateFn()"/>
                                            <span class="text-danger">
                                                <strong id="delivery-date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Expiry Date<b style="color: red; font-size:16px;">*</b></label>
                                            <input type="text" id="ExpiryDate" name="ExpiryDate" class="form-control flatpickr-basicl reg_form" placeholder="YYYY-MM-DD" onchange="expiryDateFn()"/>
                                            <span class="text-danger">
                                                <strong id="expiry-date-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Order By<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="OrderedBy" id="OrderedBy" onchange="orderedByFn()">
                                                @foreach ($uses_data as $orderby)
                                                    <option value="{{ $orderby->username }}">{{ $orderby->username }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="orderby-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Sales Person<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="SalesPerson" id="SalesPerson" onchange="salesPersonFn()"></select>
                                            <span class="text-danger">
                                                <strong id="sales-person-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="document_no_div">
                                            <label class="form_lbl" title="Document Number">Document No.</label>
                                            <input type="text" name="DocumentNumber" id="DocumentNumber" placeholder="Enter document number here" class="form-control mainforminp reg_form" onkeyup="docNumberFn()"/>
                                            <span class="text-danger">
                                                <strong id="docnumber-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 direct-reference" style="display: none;">
                                            <label class="form_lbl">Payment Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="PaymentType" id="PaymentType" onchange="paymentTypeFn()">
                                                <option selected disabled value=""></option>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit">Credit</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="paymentType-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1 direct-reference" style="display: none;">
                                            <label class="form_lbl">Payment Term<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="PaymentTerm" id="PaymentTerm" onchange="PaymentTermFn()">
                                                <option selected disabled value=""></option>
                                                <option value="1">1 Month</option>
                                                <option value="2">2 Month</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="paymentTerm-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Remark</label>
                                            <textarea type="text" placeholder="Enter remark here" class="form-control reg_form" name="Remark" id="Remark" rows="1" onkeyup="remarkFn()"></textarea>
                                            <span class="text-danger">
                                                <strong id="remark-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="do_cost_visibility">
                                            <div class="form-check form-check-inline">
                                                <div class="custom-control custom-control-primary custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="VisiblePrice" name="VisiblePrice"/>
                                                    <label class="custom-control-label form_lbl" for="VisiblePrice">Show Price Columns</label>                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
                                <fieldset class="fset">
                                    <legend>Customer Data</legend>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Customer<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="customer" id="customer" onchange="customerFn()">
                                            </select>
                                            <span class="text-danger">
                                                <strong id="customer-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Deliver By</label>
                                            <input type="text" placeholder="Enter deliver by here" class="form-control reg_form" name="DeliverBy" id="DeliverBy" onkeyup="deliverByFn()"/>
                                            <span class="text-danger">
                                                <strong id="deliverby-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Phone Number">Phone No.</label>
                                            <input type="tel" placeholder="+251-XXX-XX-XX-XX" class="form-control reg_form phone_number" name="PhoneNumber" id="PhoneNumber" onkeyup="phoneNoFn()"/>
                                            <span class="text-danger">
                                                <strong id="phone-no-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">ID No.</label>
                                            <input type="text" placeholder="Enter ID number here" class="form-control reg_form" name="IdNumber" id="IdNumber" onkeyup="idNumberFn()"/>
                                            <span class="text-danger">
                                                <strong id="id-no-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Plate Number">Plate No.</label>
                                            <input type="text" name="PlateNumber" id="PlateNumber" placeholder="Enter plate number here" class="form-control reg_form" onkeyup="plateNumFn()" style="text-transform:uppercase"/>
                                            <span class="text-danger">
                                                <strong id="platenum-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <hr class="my-30"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                    <table id="dynamicTable" class="mb-0 rtable fit-content" style="width:100%;">
                                        <thead>
                                            <th style="width:3%;">#</th>
                                            <th style="width:14%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:8%;" title="Unit of Measurement">UOM</th>
                                            <th style="width:10%;" class="direct_reference" title="Quantity on Hand">Qty. on Hand</th>
                                            <th style="width:10%;" class="non_direct_reference" title="Ordered Quantity">Ordered Qty.</th>
                                            <th style="width:10%;" class="non_direct_reference" title="Remaining Quantity">Remaining Qty.</th>
                                            <th style="width:10%;" title="Delivery Quantity">Delivery Qty.<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:9%;" class="pricing_column">Unit Price<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:9%;" class="pricing_column">Total Price</th>
                                            <th style="width:12%;">Remark</th>
                                            <th style="width:5%;"></th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <table style="width:100%">
                                        <tr>
                                            <td>
                                                <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-9 col-lg-8 col-md-5 col-sm-5 col-12"></div>
                            <div class="col-xl-3 col-lg-4 col-md-7 col-sm-7 col-12" style="text-align: right;">
                                <table style="width:100%;" id="pricingTable" class="rtable pricing_column">
                                    <tr style="display: none;">
                                        <td style="text-align: right;width:45%">
                                            <label id="subGrandTotalLbl" class="form_lbl">Sub Total</label>
                                        </td>
                                        <td style="text-align: center; width:55%">
                                            <label id="subtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                    <tr style="display: none;">
                                        <td style="text-align: right;">
                                            <label class="form_lbl" id="pricing_tbl_tax">Tax</label>
                                        </td>
                                        <td style="text-align: center;">
                                            <label id="taxLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;width:50%">
                                            <label class="form_lbl">Grand Total</label>
                                        </td>
                                        <td style="text-align: center;width:50%">
                                            <label id="grandtotalLbl" class="formattedNum form_lbl form_reset_cls" style="font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="default_customer" id="default_customer">
                                @foreach ($customer_src as $customer_src)
                                    <option value="{{ $customer_src->id }}">{{ $customer_src->customer }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="default_station" id="default_station">
                                @foreach ($station_src as $station_src)
                                    <option value="{{ $station_src->id }}">{{ $station_src->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="DefaultSalesPerson" id="DefaultSalesPerson">
                                @foreach ($uses_data as $salesperson)
                                    <option value="{{ $salesperson->username }}">{{ $salesperson->username }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="item_default" id="item_default">
                                <option selected disabled value=""></option>
                                @foreach ($itemSrcs as $itm)
                                    <option data-type="{{ $itm->Type }}" value="{{ $itm->id }}">{{ $itm->items }}</option>
                                @endforeach 
                            </select>
                            <select class="select2 form-control" name="reference_item_default" id="reference_item_default">
                                <option selected disabled value=""></option>
                            </select>
                        </div>
                        <input type="hidden" class="form-control reg_form" name="recordId" id="recordId" readonly="true"/>
                        <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var fyears = $('#fiscalyearval').val();
        var current_date = $('#currentdateval').val();
        var table = "";
        var gblIndex = -1;
        var i = 0;
        var m = 0;
        var j = 0;

        $(function () {
            cardSection = $('#page-block');
        });

        $(function () {
            reference_doc_element = $('#Reference');
        });

        $("#addDeliveryOrder").click(function() {
            resetDOFormFn();
            $("#delivery_order_title").html('Add Delivery Order');
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        function fetchReferenceDataFn(){
            var reference_type = null;
            var reference_id = null;
            var ref_type = $('#ReferenceType').val();
            var block_ui_message = "";
            $.ajax({ 
                url: '/fetchReferenceData', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                    reference_id:$('#Reference').val(),
                },
                beforeSend: function() {
                    if(ref_type == 601){
                        block_ui_message = "proforma";
                    }
                    if(ref_type == 602){
                        block_ui_message = "sales order";
                    }
                    if(ref_type == 603){
                        block_ui_message = "sales invoice";
                    }
                    blockPage(cardSection, `Fetching ${block_ui_message} data...`);
                },
                success: async function(data) {
                    await getReferenceDataFn(data,ref_type);
                    unblockPage(cardSection);
                },
                error: function () { 
                    unblockPage(cardSection);
                },
            });
        }

        function getReferenceDataFn(data,ref_type){
            var expiry_date = null;
            var sales_person = null;
            var product_type = null;
            var station = null;
            var customer_option = null;
            var payment_type_option = null;
            
            if(ref_type == 601){
                $.each(data.customer_data, function(key, value) {
                    customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                });

                $.each(data.main_data, function(key, value) {
                    flatpickr('#ExpiryDate', {dateFormat: 'Y-m-d',clickOpens:false});
                    $('#ExpiryDate').val(value.expireDate);

                    station = `<option selected value="${value.store_id}">${value.station}</option>`;
                    product_type = `<option selected value="${value.product_type}">${value.product_type}</option>`;
                    sales_person = `<option selected value="${value.Username}">${value.Username}</option>`;
                });

                listReferenceItemFn(data.detail_data);
            }
            else if(ref_type == 602){
                $.each(data.customer_data, function(key, value) {
                    customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                });

                $.each(data.main_data, function(key, value) {
                    flatpickr('#ExpiryDate', {dateFormat: 'Y-m-d',clickOpens:false});
                    $('#ExpiryDate').val(value.expiredate);
                    sales_person = `<option selected value="${value.username}">${value.username}</option>`;
                });
            }
            else if(ref_type == 603){
                $.each(data.customer_data, function(key, value) {
                    customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                });

                $.each(data.main_data, function(key, value) {
                    flatpickr('#ExpiryDate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:current_date});
                    $('#ExpiryDate').val(value.expiredate);

                    station = `<option selected value="${value.store_id}">${value.station}</option>`;
                    product_type = `<option selected value="${value.product_type}">${value.product_type}</option>`;
                    sales_person = `<option selected value="${value.Username}">${value.Username}</option>`;
                });

                //populateReferenceItemFn(data.detail_data);
                listReferenceItemFn(data.detail_data);
            }
            
            $('#customer').empty().append(customer_option).select2({
                minimumResultsForSearch: -1
            });

            $('#ProductType').empty().append(product_type).select2({
                minimumResultsForSearch: -1
            });

            $('#SalesPerson').empty().append(sales_person).select2({
                minimumResultsForSearch: -1
            });

            $('#station').empty().append(station).select2({
                minimumResultsForSearch: -1
            });
        }

        function populateReferenceItemFn(detail_data){
            var item_options = null;
            var remaining_qty = null;
            $.each(detail_data, function(key, value) {
                remaining_qty = (parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0)) + parseFloat(value.issued_qty || 0);
                if(parseFloat(remaining_qty) > 0){
                    item_options += `<option value="${value.itemid}">${value.items}</option>`; 
                }
            });

            item_options += `<option selected disabled value=""></option>`;
            $('#reference_item_default').empty().append(item_options).select2();
        }

        function listReferenceItemFn(detail_data){
            j = 0;
            var item_options = null;
            var remaining_qty = null;
            $("#dynamicTable > tbody").empty();

            $.each(detail_data, function(key, value) {
                ++i;
                ++j;
                ++m;
                
                remaining_qty = parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0);
                if(parseFloat(remaining_qty) > 0){
                    $("#dynamicTable > tbody").append(`<tr>
                        <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                        <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                        <td style="width:14%"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"><option selected value="${value.itemid}">${value.items}</option></select></td>
                        <td style="width:8%"><select id="uom${m}" class ="select2 form-control uom" onchange="uomFn(this)" name = "row[${m}][uom]"><option selected value="${value.uom}">${value.uom_name}</option></select></td>
                        <td style="width:10%;" class="direct_reference"><input type="text" name="row[${m}][qty_on_hand]" placeholder="Quantity on hand" id="qty_on_hand${m}" class="qty_on_hand form-control" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][ordered_qty]" placeholder="Ordered quantity" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" value="${value.Quantity}" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][remaining_qty]" placeholder="Remaining quantity" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" value="${remaining_qty >= 0 ? remaining_qty : 0}" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:10%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                        <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][UnitPrice]" placeholder="Enter unit price here" id="unitprice${m}" class="unitprice form-control numeral-mask" value="${value.UnitPrice}" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                        <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total price" id="total${m}" class="total form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                        <td style="width:12%;"><input type="text" name="row[${m}][remark]" id="remark${m}" class="remark form-control" placeholder="Enter remark here"/></td>
                        <td style="width:5%;text-align:center;">
                            <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                            <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        </td>
                    </tr>`);

                    columnMgtFn();

                    $(`#itemNameSl${m}`).select2({minimumResultsForSearch: -1});
                    $(`#uom${m}`).select2({minimumResultsForSearch: -1});
                    $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                    item_options += `<option value="${value.itemid}">${value.items}</option>`; 

                    var is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                    var is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                    var is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";

                    if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                        $(`#batch_serial_info${m}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                        $(`#batch_serial_info${m}`).show();
                    }
                }
            });

            item_options += `<option selected disabled value=""></option>`;
            $('#reference_item_default').empty().append(item_options).select2();
            renumberRows();
            CalculateGrandTotal();
        }

        function productTypeFn(){
            $('#product-type-error').html("");
        }

        $('#ReferenceType').on('change', function() {
            var reference_type = $(this).val();
            var sales_person = null;
            $('.reference_doc').hide();
            $('.default_hidden_div').hide();
            $("#dynamicTable > tbody").empty();
            fillProductTypeDataFn(reference_type);
            $('#PaymentType').val(null).select2({placeholder: "Select payment type here"});
            $('#PaymentTerm').val(null).select2({placeholder: "Select payment term here"});
            $('#SalesPerson').empty().select2({placeholder: "Select sales person here"});
            if(reference_type == 600){
                $('.non_direct_reference').hide();
                $('.direct_reference').show();
                $('.unitprice').prop("readonly",false);       
                $('.pricing_inp').val("");
                $('#ExpiryDate').val("");
                $('.direct-reference').show();
                sales_person = $("#DefaultSalesPerson > option").clone();
                $('#SalesPerson').append(sales_person).val(null).select2({placeholder: "Select sales person here"});
            }
            else{
                $('.non_direct_reference').show();
                $('.direct_reference').hide();
                $('.unitprice').prop("readonly",true);
                $('#reference_doc_div').show();
                $('.direct-reference').hide();
                fetchReferenceDocFn();
            }
            CalculateGrandTotal();
            $('#reference-type-error').html("");
        });

        $('#Reference').on('change', function() {
            fetchReferenceDataFn();
            $('#reference-doc-error').html("");
        });

        function fetchReferenceDocFn(){
            var reference_type = null;
            $.ajax({ 
                url: '/fetchReferenceDoc', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching references...');
                },  
                success: async function(data) {
                    await fetchReferenceListFn(data);
                    unblockPage(cardSection);
                },
                error: function () { 
                    unblockPage(cardSection);
                },
            });
        }

        function fetchReferenceListFn(data){
            var ref_type = $('#ReferenceType').val();
            var options = null;
            if(ref_type == 601){
                $.each(data.proforma_invoice_data, function(key, value) {
                    options += `<option value="${value.proforma_id}">${value.proforma_data}</option>`;
                });
            }
            else if(ref_type == 602){
                $.each(data.sales_order_data, function(key, value) {
                    options += `<option value="${value.sales_id}">${value.sales_data}</option>`;
                });
            }
            else if(ref_type == 603){
                $.each(data.sales_invoice_data, function(key, value) {
                    options += `<option value="${value.sales_id}">${value.sales_data}</option>`;
                });
            }

            $('#Reference').empty().append(options).val(null).select2({
                placeholder: "Select reference here"
            });
        }

        $("#adds").click(function() {
            var lastrowcount = $('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${lastrowcount}`).val();
            var product_type = $("#ProductType").val();
            var reference_type = $("#ReferenceType").val();
            var station = $("#station").val();
            var options = null;

            if(itemids !== undefined && itemids === null){
                $(`#select2-itemNameSl${lastrowcount}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else if((product_type !== undefined && (product_type == null || product_type == "")) || (station !== undefined && (station == null || station == ""))){
                if(product_type !== undefined && (product_type == null || product_type == "")){
                    $('#product-type-error').html("The product type field is required.");
                }
                if(station !== undefined && (station == null || station == "")){
                    $('#station-error').html("The station field is required.");
                }
                toastrMessage('error',"Please fill required fields first","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;

                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:14%"><select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select></td>
                    <td style="width:8%"><select id="uom${m}" class ="select2 form-control uom" onchange="uomFn(this)" name = "row[${m}][uom]"></select></td>
                    <td style="width:10%;" class="direct_reference"><input type="text" name="row[${m}][qty_on_hand]" placeholder="Quantity on hand" id="qty_on_hand${m}" class="qty_on_hand form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][ordered_qty]" placeholder="Ordered quantity" id="ordered_qty${m}" class="ordered_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%" class="non_direct_reference"><input type="number" name="row[${m}][remaining_qty]" placeholder="Remaining quantity" id="remaining_qty${m}" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:10%"><input type="number" name="row[${m}][Quantity]" placeholder="Enter quantity here" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>
                    <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][UnitPrice]" placeholder="Enter unit price here" id="unitprice${m}" class="unitprice pricing_inp form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>
                    <td style="width:9%" class="pricing_column"><input type="number" name="row[${m}][TotalPrice]" placeholder="Total price" id="total${m}" class="total pricing_inp form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>
                    <td style="width:12%;"><input type="text" name="row[${m}][remark]" id="remark${m}" class="remark form-control" placeholder="Enter remark here"/></td>
                    <td style="width:5%;text-align:center;">
                        <a id="batch_serial_info${m}" href="javascript:void(0)" class="batch_serial_info" style="display:none;"><i class="fas fa-info-circle" style="color: #82868b;"></i></a>
                        <button type="button" id="remove_rec_item${m}" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                </tr>`);

                columnMgtFn();

                var default_option = `<option selected disabled value=""></option>`;
                if(reference_type == 600){
                    options = $("#item_default");
                    $(`#itemNameSl${m}`).append(options.find(`option[data-type="${product_type}"]`).clone());
                }
                else if(reference_type != 600){
                    options = $("#reference_item_default > option").clone();
                    $(`#itemNameSl${m}`).append(options);
                }

                $('#dynamicTable > tbody > tr').each(function(index, tr) {
                    let item_id = $(this).find('.itemName').val();
                    $(`#itemNameSl${m} option[value="${item_id}"]`).remove(); 
                });

                $(`#itemNameSl${m}`).append(default_option);
                $(`#itemNameSl${m}`).select2({
                    placeholder: "Select item here",
                });

                $(`#uom${m}`).select2({
                    placeholder: "Select UOM here",
                });

                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                renumberRows();
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                ind = index;
            });
            columnMgtFn();
        }

        function itemFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var item_id = $(`#itemNameSl${idval}`).val();
            
            var arr = [];
            var found = 0;
            $('.itemName').each(function(){ 
                var name = $(this).val();
                if(arr.includes(name)){
                    found++;
                }
                else{
                    arr.push(name);
                }
            });
            
            if(found){
                $(`#quantity${idval}`).val("");
                $(`#unitprice${idval}`).val("");
                $(`#total${idval}`).val("");
                $(`#uom${idval}`).empty().select2({minimumResultsForSearch: -1,placeholder: "Select item first"});
                $(`#select2-itemNameSl${idval}-container`).parent().css('background-color',errorcolor);
                $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                toastrMessage('error',"Item already exist in the list","Error");
                CalculateGrandTotal();
            }
            else{
                fetchItemInfoFn(idval);
                fetchUOMListFn(idval);
                calcBalanceFn(idval);
                $(`#select2-itemNameSl${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
        }

        function uomFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $(`#select2-uom${idval}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function fetchItemInfoFn(indx){
            var itemid = null;
            var reference_id = null;
            var reference_type = null;
            var ref_type = $('#ReferenceType').val() || 0;
            var itm = $(`#itemNameSl${indx}`).val() || 0;

            $.ajax({
                url: '/fetchDOItemInfo', 
                type: 'POST',
                data:{
                    itemid: $(`#itemNameSl${indx}`).val() || 0,
                    reference_id: $('#Reference').val() || 0,
                    reference_type: ref_type,
                },
                success: function(data) {
                    $.each(data.item_info, function(key, value) {
                        var is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                        var is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";
                        var tax_percent = 15;
                        tax_percent = tax_percent == '' || tax_percent == null ? 0 : tax_percent;

                        $(`#uom${indx}`).empty().append(`<option selected value='${value.uom}'>${value.uom_name}</option>`).select2();
                        $(`#unitprice${indx}`).val(value.UnitPrice);

                        var quantity = $(`#quantity${indx}`).val() || 0;
                        var unitprice = $(`#unitprice${indx}`).val() || 0;

                        var total = parseFloat(value.UnitPrice || 0) * parseFloat(quantity);

                        $(`#total${indx}`).val(parseFloat(total).toFixed(2));
                        CalculateGrandTotal();

                        if(is_batch_req == "Yes" || is_expiry_req == "Yes" || is_serial_req == "Yes"){
                            $(`#batch_serial_info${indx}`).attr("title",`Is Batch No. Req.: ${is_batch_req}\nIs Expiry Date Req.: ${is_expiry_req}\nIs Serial No. Req.: ${is_serial_req}`);
                            $(`#batch_serial_info${indx}`).show();
                        }

                        if(ref_type == 601){
                            $(`#ordered_qty${indx}`).val(value.Quantity);
                            var remaining_qty = parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0);
                            remaining_qty >= 0 ? remaining_qty : 0;
                            $(`#remaining_qty${indx}`).val(remaining_qty);
                        }
                        else if(ref_type == 602){

                        }
                        else if(ref_type == 603){
                            $(`#ordered_qty${indx}`).val(value.Quantity);
                            var remaining_qty = parseFloat(value.Quantity || 0) - parseFloat(value.issued_qty || 0);
                            remaining_qty >= 0 ? remaining_qty : 0;
                            $(`#remaining_qty${indx}`).val(remaining_qty);
                        }
                    });
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function fetchUOMListFn(indx){
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var itemid = $(`#itemNameSl${indx}`).val() || 0;
            $.ajax({
                url: 'getUOMS/' + itemid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var defname = data.defuom;
                    var defid = data.defuomid;
                    var lastcost = data.lastCost;
                    var taxper = data.taxpr;
                    var option = null;
                    $.each(data.sid, function(key, value) {
                        option += `<option value='${value.ToUomID}'>${value.ToUnitName}</option>`;
                    });

                    $(`#uom${indx}`).append(option).select2();
                },
            });
        }

        function calcBalanceFn(rowid){
            var baseRecordId = null;
            var storeval = null;
            var itemid = null;
            
            $.ajax({
                url: '/calcDOBalance', 
                type: 'POST',
                data:{
                    baseRecordId:$('#recordId').val() || 0,
                    storeval:$('#station').val(),
                    itemid:$(`#itemNameSl${rowid}`).val(),
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching item data...');
                },
                success: async function(data) {
                    await getBalanceFn(data,rowid);
                    unblockPage(cardSection);
                },
                error: function () {
                    unblockPage(cardSection);
                }
            });
        }

        function getBalanceFn(data,rowid){
            var net_balance = null;
            var qty = null;

            net_balance = parseFloat(data.available_qty);
            qty = $(`#quantity${rowid}`).val();
            $(`#qty_on_hand${rowid}`).val(net_balance);

            if(parseFloat(qty) > parseFloat(net_balance)){
                $(`#qty_on_hand${rowid}`).val("");
            }
        }

        $('#VisiblePrice').on('change', function() {
            showCostColumnFn();
        });

        function showCostColumnFn(){
            var reference_type = $("#ReferenceType").val(); 
            var isChecked = $('#VisiblePrice').is(':checked');
            if(isChecked){
                $('.pricing_column').show();
            }
            else{
                $('.pricing_column').hide();
            }
        }

        function columnMgtFn(){
            var reference_type = $("#ReferenceType").val(); 
            var isChecked = $('#VisiblePrice').is(':checked');

            if(reference_type == 600){
                $('.non_direct_reference').hide();
                $('.direct_reference').show();
                $('.unitprice').prop("readonly",false);
            }
            else if(reference_type != 600){
                $('.non_direct_reference').show();
                $('.direct_reference').hide();
                $('.unitprice').prop("readonly",true);
            }

            if(isChecked){
                $('.pricing_column').show();
            }
            else if(!isChecked){
                $('.pricing_column').hide();
            }
        }

        function CalculateTotal(ele) {
            var inputid = ele.getAttribute('id');
            var cid = $(ele).closest('tr').find('.vals').val();
            var unitprice = $(ele).closest('tr').find('.unitprice').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();

            unitprice = unitprice == '' ? 0 : unitprice;
            quantity = quantity == '' ? 0 : quantity;
            
            if(!isNaN(unitprice) && !isNaN(quantity)) {
                var total = parseFloat(unitprice) * parseFloat(quantity);
                $(`#total${cid}`).val(parseFloat(total).toFixed(2));

                if(inputid === `unitprice${cid}`){
                    $(`#unitprice${cid}`).css("background","white");
                }
                if(inputid === `quantity${cid}`){
                    var reference_type = $("#ReferenceType").val();
                    if(reference_type == 600){
                        var qty_on_hand = $(`#qty_on_hand${cid}`).val();
                        qty_on_hand = qty_on_hand == '' ? 0 : qty_on_hand;

                        if(parseFloat(quantity) > parseFloat(qty_on_hand)){
                            $(`#quantity${cid}`).css("background",errorcolor);
                            $(`#quantity${cid}`).val("");
                            $(`#total${cid}`).val("");
                            toastrMessage('error',"Quantity exceeds available stock.","Error");
                        }
                        else{
                            $(`#quantity${cid}`).css("background","white");
                        }
                    }
                    else{
                        var remaining_qty = $(`#remaining_qty${cid}`).val();
                        remaining_qty = remaining_qty == '' ? 0 : remaining_qty;

                        if(parseFloat(quantity) > parseFloat(remaining_qty)){
                            $(`#quantity${cid}`).css("background",errorcolor);
                            $(`#quantity${cid}`).val("");
                            $(`#total${cid}`).val("");
                            toastrMessage('error',"Quantity exceeds remaining balance.","Error");
                        }
                        else{
                            $(`#quantity${cid}`).css("background","white");
                        }
                    }
                }
                if(parseFloat(total) > 0){
                    $(`#total${cid}`).css("background","#efefef");
                }
            }
            CalculateGrandTotal();
        }

        function CalculateGrandTotal() {
            var grandTotal = 0;

            $.each($('#dynamicTable').find('.total'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });

            $('#grandtotalLbl').html(numformat(parseFloat(grandTotal).toFixed(2)));
        }

        $('.phone_number').on('input', function (e) {
            let input = $(this);
            let v = input.val();
            
            // If user is deleting and the current value starts with "+251"
            if ((e.originalEvent?.inputType === 'deleteContentBackward' || 
                e.originalEvent?.inputType === 'deleteContentForward') &&
                v.startsWith('+251')) {
                
                // Get digits only (without "+" and "-")
                let digits = v.replace(/\D/g, '');
                
                // If we have only country code digits or less, clear everything
                if (digits.length <= 3) {
                    input.val('');
                    return;
                }
                
                // If we have more than country code, just remove the last digit
                // Keep going with normal formatting below
                v = digits;
            } else {
                // Normal case: get digits only
                v = v.replace(/\D/g, '');
            }
            
            // If empty after cleaning, clear field
            if (v === '') {
                input.val('');
                return;
            }
            
            // Remove leading 251 if user typed it (we'll add it back)
            v = v.replace(/^251/, '');
            
            // Add country code
            v = '251' + v;
            
            // Limit to 12 digits (251 + 9 digits)
            v = v.substring(0, 12);
            
            // Validate first digit after country code
            if (v.length > 3) {
                let firstDigit = v.charAt(3);
                if (firstDigit !== '9' && firstDigit !== '7') {
                    v = v.substring(0, 3);
                }
            }
            
            // Format with dashes
            let formatted = '+251';
            if (v.length > 3) formatted += '-' + v.substring(3, 6);
            if (v.length > 6) formatted += '-' + v.substring(6, 8);
            if (v.length > 8) formatted += '-' + v.substring(8, 10);
            if (v.length > 10) formatted += '-' + v.substring(10, 12);
            
            input.val(formatted);
        });

        $('.email_validation').on('input', function () {
            const email = $(this).val().trim();

            const isValid =
                /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email);

            $(this).toggleClass('is-invalid', email !== '' && !isValid);
        });

        $('#station').on('change', function() {
            getStoreBalanceFn($(this).val());
            $('#station-error').html("");
        });

        function getStoreBalanceFn(str_id){
            var store_id = null;
            var item_id = null;
            var selected_items = [];
            $('#dynamicTable > tbody > tr').each(function(index, tr) {
                selected_items.push($(this).find('.itemName').val());
            });

            if(selected_items.length > 0) {
                $.ajax({ 
                    url: '/getDOStoreBalance', 
                    type: 'POST',
                    data:{
                        store_id : str_id,
                        item_id : selected_items,
                    },      
                    beforeSend: function() {
                        blockPage(cardSection, 'Calculating available balance...');
                    }, 
                    success: async function(data) {
                        await getAllItemBalanceFn(data);
                        unblockPage(cardSection);
                    },
                    error: function () {
                        unblockPage(cardSection);
                    }
                });
            }
        }

        function getAllItemBalanceFn(data){
            $('.qty_on_hand').val(0);
            if(parseFloat(data.result.length) == 0){
                $('.quantity').val("");
            }
            else{
                $.each(data.result, function(key, value) {
                    $('#dynamicTable > tbody > tr').each(function(index, tr) {
                        var itm = $(this).find('.itemName').val();

                        if(parseInt(value.ItemId) == parseInt(itm)){
                            var qty = $(this).find('.quantity').val();
                            var available_qty = value.available_quantity;
                            $(this).find('.qty_on_hand').val(available_qty);

                            if(parseFloat(qty) > parseFloat(available_qty)){
                                $(this).find('.quantity').val("");
                            }
                        }
                    });
                });
            }
        }

        function deliveryDateFn(){
            $('#delivery-date-error').html("");
        }

        function expiryDateFn(){
            $('#expiry-date-error').html("");
        }

        function orderedByFn(){
            $('#orderby-error').html("");
        }

        function salesPersonFn(){
            $('#sales-person-error').html("");
        }

        function docNumberFn(){
            $('#docnumber-error').html("");
        }

        function paymentTypeFn(){
            $('#paymentType-error').html("");
        }

        function PaymentTermFn(){
            $('#paymentTerm-error').html("");
        }

        function remarkFn(){
            $('#remark-error').html("");
        }

        function customerFn(){
            $('#customer-error').html("");
        }

        function deliverByFn(){
            $('#deliverby-error').html("");
        }

        function phoneNoFn(){
            $('#phone-no-error').html("");
        }

        function idNumberFn(){
            $('#id-no-error').html("");
        }

        function plateNumFn(){
            $('#platenum-error').html("");
        }

        function fillProductTypeDataFn(ref_type){
            if(ref_type == 600){
                var product_type_options = `
                    <option value="Goods">Goods</option>
                    <option value="Commodity">Commodity</option>
                    <option value="Metal">Metal</option>`;

                var customer_options = $("#default_customer > option").clone();
                var station_options = $("#default_station > option").clone();

                $('#ProductType').empty().append(product_type_options).val(null).select2({
                    placeholder: "Select product type here",
                    minimumResultsForSearch: -1
                });

                $('#customer').empty().append(customer_options).val(null).select2({
                    placeholder: "Select customer here",
                });

                $('#station').empty().append(station_options).val(null).select2({
                    placeholder: "Select station here",
                });
            }
            else{
                $('#ProductType').empty().select2({
                    placeholder: "Select reference document first",
                    minimumResultsForSearch: -1
                });

                $('#customer').empty().select2({
                    placeholder: "Select reference document first",
                    minimumResultsForSearch: -1
                });
            }
        }

        function resetDOFormFn(){
            $('#ReferenceType').val(null).select2({
                placeholder: "Select reference type here",
                minimumResultsForSearch: -1
            });
            $('#Reference').val(null).select2({
                placeholder: "Select reference document here",
            });
            $('#ProductType').empty().select2({
                placeholder: "Select product type here",
                minimumResultsForSearch: -1
            });
            $('#station').val(null).select2({
                placeholder: "Select station here",
            });
            $('#OrderedBy').val(null).select2({
                placeholder: "Select order by here",
            });
            $('#SalesPerson').empty().select2({
                placeholder: "Select sales person here",
            });
            $('#PaymentType').val(null).select2({
                placeholder: "Select payment type here",
            });
            $('#PaymentTerm').val(null).select2({
                placeholder: "Select payment term here",
            });
            $('#customer').val(null).select2({
                placeholder: "Select reference type first",
            });
            $('.default_hidden_div').hide();
            $('.direct-reference').hide();
            $('#operationtypes').val(1);
            $('.reg_form').val("");
            $('#VisiblePrice').prop('checked', false);
            showCostColumnFn();
            $('.non_direct_reference').hide();
            $('.direct_reference').hide();
            $('#delivery_order_status').html("");
            $('.errordatalabel').html("");
            flatpickr('#DeliveryDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:current_date});
            flatpickr('#ExpiryDate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:current_date});
            $("#dynamicTable > tbody").empty();
        }

        function refreshDOFn(){
            var f_year = $('#fiscalyear').val();
            //countDispatchStatusFn(f_year);

            var rTable = $('#laravel-datatable-crud').dataTable();
            rTable.fnDraw(false);
        }
        
        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection