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
                            <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12 col-12 mb-1"> 
                                <fieldset class="fset">
                                    <legend>General Data</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Reference Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ReferenceType" id="ReferenceType">
                                                <option value="Direct">Direct</option>
                                                <option value="Proforma-Invoice">Proforma-Invoice</option>
                                                <option value="Sales-Order">Sales-Order</option>
                                                <option value="Sales-Invoice">Sales-Invoice</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="reference-type-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6 col-sm-6 col-12 mb-1 reference_doc default_hidden_div" id="reference_doc_div">
                                            <label class="form_lbl" title="Reference Document">Reference Doc.<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ReferenceDocument" id="ReferenceDocument"></select>
                                            <span class="text-danger">
                                                <strong id="reference-doc-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1" id="product_type_div">
                                            <label class="form_lbl">Product Type<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="ProductType" id="ProductType" onchange="productTypeFn()">
                                            </select>
                                            <span class="text-danger">
                                                <strong id="product-type-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl">Station<b style="color: red; font-size:16px;">*</b></label>
                                            <select class="select2 form-control" name="station" id="station" onchange="stationFn()">
                                                @foreach ($station_src as $station_src)
                                                    <option value="{{ $station_src->id }}">{{ $station_src->Name }}</option>
                                                @endforeach
                                            </select>
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
                                            <label class="form_lbl">Remark</label>
                                            <textarea type="text" placeholder="Write Remark here..." class="form-control reg_form" name="Remark" id="Remark" rows="1" onkeyup="remarkFn()"></textarea>
                                            <span class="text-danger">
                                                <strong id="remark-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 mb-1">
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
                                            <label class="form_lbl">Contact Person</label>
                                            <input type="text" placeholder="Write contact person here" class="form-control reg_form" name="ContactPerson" id="ContactPerson" onkeyup="contactPersonFn()"/>
                                            <span class="text-danger">
                                                <strong id="contact-person-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Contact Phone Number">Contact Phone No.</label>
                                            <input type="tel" placeholder="+251-XXX-XX-XX-XX" class="form-control reg_form phone_number" name="CotactPhoneNo" id="CotactPhoneNo" onkeyup="contactPhoneFn()"/>
                                            <span class="text-danger">
                                                <strong id="contact-phone-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 mb-1">
                                            <label class="form_lbl" title="Contact Email">Contact Email</label>
                                            <input type="email" id="ContactEmail" name="ContactEmail" class="form-control email_validation reg_form" placeholder="abc@domain.com" onkeydown="contactEmailFn()"/>
                                            <span class="text-danger">
                                                <strong id="contact-email-error" class="errordatalabel"></strong>
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
                                            <th style="width:14%;" title="Sales, Transfer, Requisition Document Number">Reference No.<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:20%;">Item Name<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:10%;" title="Unit of Measurement">UOM</th>
                                            <th style="width:11%;" title="Sold/ Issued Quantity" id="qty_data">Sold/ Issued Qty.</th>
                                            <th style="width:11%;" title="Remaining Quantity">Remaining  Qty.</th>
                                            <th style="width:11%;" title="Dispatch Quantity">Dispatch Qty.<b style="color: red; font-size:16px;">*</b></th>
                                            <th style="width:14%;">Remark</th>
                                            <th style="width:6%;"></th>
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="default_customer" id="default_customer">
                                @foreach ($customer_src as $customer_src)
                                    <option value="{{ $customer_src->id }}">{{ $customer_src->customer }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control reg_form" name="recordId" id="recordId" readonly="true"/>
                        <input type="hidden" class="form-controll reg_form" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
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

        $(function () {
            cardSection = $('#page-block');
        });

        $(function () {
            reference_doc_element = $('#ReferenceDocument');
        });

        $("#addDeliveryOrder").click(function() {
            resetDOFormFn();
            $("#delivery_order_title").html('Add Delivery Order');
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        function fetchReferenceDocFn(){
            var reference_type = null;
            var options = null;
            $.ajax({ 
                url: '/fetchReferenceDoc', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                },
                beforeSend: function() {
                    blockPage(cardSection, 'Fetching references...');
                },
                complete: function () { 
                    unblockPage(cardSection);
                },
                success: function(data) {
                    var ref_type = $('#ReferenceType').val();

                    if(ref_type == "Proforma-Invoice"){
                       //$.each(data.sales_invoice_data, function(key, value) {});
                    }
                    else if(ref_type == "Sales-Order"){
                        //$.each(data.sales_invoice_data, function(key, value) {});
                    }
                    else if(ref_type == "Sales-Invoice"){
                        $.each(data.sales_invoice_data, function(key, value) {
                            options += `<option value="${value.sales_id}">${value.sales_data}</option>`;
                        });
                    }
                    $('#ReferenceDocument')
                    .empty()
                    .append(options)
                    .val(null)
                    .select2({
                        placeholder: "Select reference document here"
                    });
                }
            });
        }

        function fetchReferenceDataFn(){
            var reference_type = null;
            var reference_id = null;
            var customer_option = null;
            var ref_type = $('#ReferenceType').val();
            var block_ui_message = "";
            $.ajax({ 
                url: '/fetchReferenceData', 
                type: 'POST',
                data:{
                    reference_type:$('#ReferenceType').val(),
                    reference_id:$('#ReferenceDocument').val(),
                },
                beforeSend: function() {
                    if(ref_type == "Proforma-Invoice"){
                        block_ui_message = "proforma";
                    }
                    if(ref_type == "Sales-Order"){
                        block_ui_message = "sales order";
                    }
                    if(ref_type == "Sales-Invoice"){
                        block_ui_message = "sales";
                    }
                    blockPage(cardSection, `Fetching ${block_ui_message} data...`);
                },
                complete: function () { 
                    unblockPage(cardSection);
                },
                success: function(data) {
                    if(ref_type == "Sales-Invoice"){
                        $.each(data.customer_data, function(key, value) {
                            customer_option = `<option selected value="${value.id}">${value.customer}</option>`;
                        });
                    }

                    $('#customer')
                    .empty()
                    .append(customer_option)
                    .select2({
                        placeholder: "Select customer here",
                        minimumResultsForSearch: -1
                    });
                }
            });
        }

        function resetDOFormFn(){
            $('#ReferenceType').val(null).select2({
                placeholder: "Select reference type here",
                minimumResultsForSearch: -1
            });
            $('#ReferenceDocument').val(null).select2({
                placeholder: "Select reference document here",
            });
            $('#ProductType').val(null).select2({
                placeholder: "Select product type here",
                minimumResultsForSearch: -1
            });
            $('#station').val(null).select2({
                placeholder: "Select station here",
            });
            $('#customer').val(null).select2({
                placeholder: "Select reference type first",
            });
            $('.default_hidden_div').hide();
            $('#operationtypes').val(1);
            $('.reg_form').val("");
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

        function productTypeFn(){
            $('#product-type-error').html("");
        }

        $('#ReferenceType').on('change', function() {
            var reference_type = $(this).val();
            $('.reference_doc').hide();
            $('.default_hidden_div').hide();
            fillProductTypeDataFn(reference_type);
            if(reference_type == "Direct"){
                $('#ExpiryDate').val("");
            }
            else{
                $('#reference_doc_div').show();
                fetchReferenceDocFn();
            }
            $('#reference-type-error').html("");
        });

        $('#ReferenceDocument').on('change', function() {
            fetchReferenceDataFn();
            $('#reference-doc-error').html("");
        });

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

        function stationFn(){
            $('#station-error').html("");
        }

        function deliveryDateFn(){
            $('#delivery-date-error').html("");
        }

        function expiryDateFn(){
            $('#expiry-date-error').html("");
        }

        function remarkFn(){
            $('#remark-error').html("");
        }

        function customerFn(){
            $('#customer-error').html("");
        }

        function contactPersonFn(){
            $('#contact-person-error').html("");
        }

        function contactPhoneFn(){
            $('#contact-phone-error').html("");
        }

        function contactEmailFn(){
            $('#contact-email-error').html("");
        }

        function fillProductTypeDataFn(ref_type){
            if(ref_type == "Direct"){
                var product_type_options = `
                    <option value="Goods">Goods</option>
                    <option value="Commodity">Commodity</option>
                    <option value="Metal">Metal</option>`;

                var customer_options = $("#default_customer > option").clone();

                $('#ProductType').empty().append(product_type_options).val(null).select2({
                    placeholder: "Select product type here",
                    minimumResultsForSearch: -1
                });

                $('#customer').empty().append(customer_options).val(null).select2({
                    placeholder: "Select customer here",
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
    </script>
@endsection