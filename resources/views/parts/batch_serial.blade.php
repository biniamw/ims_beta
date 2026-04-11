    
    
    <!-- start batch,serial,expire date modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="manageItemModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form id="ManageItemForm">    
            <div class="modal-dialog sidebar-xl" style="width: 95%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title form_title" id="manage-item-title">Item Receiving Information</h5>
                        <div class="info_modal_title_lbl" style="text-align: center;padding-right:30px;"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scrdivhor scrollhor" style="overflow-y:auto;height:100vh;">
                        <div class="row mb-1">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <section id="batch_serial_item_info_section">
                                    <div class="d-flex justify-content-between align-items-center cursor-pointer border-bottom" data-toggle="collapse" data-target=".batch_serial_collapse" aria-expanded="true">
                                        <h5 class="mb-0 form_title batch_serial_item_header_info"><i class="far fa-info-circle"></i> Basic Information</h5>
                                        <div class="d-flex align-items-center header-tab">
                                            <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                            <div class="collapse-icon">
                                                <i class="fas text-secondary fa-minus-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="collapse batch_coll show batch_serial_collapse shadow pl-1 pr-1">
                                        <div class="row mb-1">
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="card shadow-none border m-0">
                                                    <div class="card-body mb-0">
                                                        <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Information</h6>
                                                        <hr class="my-50">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                    <tr>
                                                                        <td><label class="info_lbl">Item Type</label></td>
                                                                        <td><label class="info_lbl batch_item_type_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl">Item Code</label></td>
                                                                        <td><label class="info_lbl batch_item_code_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl">Item Name</label></td>
                                                                        <td><label class="info_lbl batch_item_name_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Barcode Number">Barcode No.</label></td>
                                                                        <td><label class="info_lbl batch_barcode_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <table class="infotbl mb-0" style="width:100%;font-size:12px;">
                                                                    <tr>
                                                                        <td><label class="info_lbl">Category</label></td>
                                                                        <td><label class="info_lbl batch_item_category_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Unit of Measurement">UOM</label></td>
                                                                        <td><label class="info_lbl batch_item_uom_lbl" id="uom_lbl" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Batch Number Required">Is Batch No. Req.</label></td>
                                                                        <td><label class="info_lbl is_batch_req" id="is_batch_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Serial Number Required">Is Serial No. Req.</label></td>
                                                                        <td><label class="info_lbl is_serial_req" id="is_serial_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label class="info_lbl" title="Is Expiry Date Required">Is Expiry Date Req.</label></td>
                                                                        <td><label class="info_lbl is_expiry_date_req" id="is_expiry_date_req" style="font-weight: bold;"></label></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="card shadow-none border m-0">
                                                    <div class="card-body">
                                                        <h6 class="card-title mb-0"><i class="fa-sharp fa-solid fa-file-invoice-dollar"></i> Sales Pricing</h6>
                                                        <hr class="my-50">
                                                        <table class="infotbl" style="width:100%;font-size:12px;">
                                                            <tr>
                                                                <td><label class="info_lbl">Retail Price</label></td>
                                                                <td><label class="info_lbl batch_item_retial_price_lbl" style="font-weight: bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl">Wholesale Price</label></td>
                                                                <td><label class="info_lbl batch_item_wholesale_price_lbl" style="font-weight: bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label class="info_lbl" title="Wholesale Minimum Quantity">Wholesale Min. Qty.</label></td>
                                                                <td><label class="info_lbl batch_item_wholesale_min_qty" style="font-weight: bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div id="batch_no_div">
                                        <table id="batch_no_dynamic_table" class="fit-content" style="width:100%;">
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" name="add_batch_no" id="add_batch_no" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Batch No.</button>
                                    </div>
                                    <div id="serial_no_div" style="display: none;">
                                        <label style="font-size: 13px;" id="batch_title_for_serial_no"></label>
                                        <table id="serial_no_dynamic_table" class="mb-0 rtable form_dynamic_table fit-content" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th class="form_lbl" style="width: 10%">#</th>
                                                    <th class="form_lbl" style="width: 80%">Serial No.<b style="color: red; font-size:16px;">*</b></th>
                                                    <th class="form_lbl" style="width: 10%"></th>
                                                </tr>
                                            <thead>
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" name="add_serial_no" id="add_serial_no" class="btn btn-success btn-sm" style="display: none;"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Serial No.</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display: none;">
                                <label style="font-size: 16px;" id="batch_received_qty_lbl"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="bs_country_default" id="bs_country_default">
                                <option selected disabled value=""></option>
                                @foreach ($countries as $cnt)
                                    <option value="{{ $cnt->id }}">{{ $cnt->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="bs_manufacturer_default" id="bs_manufacturer_default">
                                <option selected disabled value=""></option>
                                <option value="1">Dell Inc.</option>
                                <option value="2">HP Inc.(Hewlett-Packard)</option>
                                <option value="3">Lenovo Group Limited</option>
                                <option value="4">Samsung Electronics</option>
                                <option value="5">Apple Inc.</option>
                            </select>
                            <select class="select2 form-control" name="bs_brand_default" id="bs_brand_default">
                                <option selected disabled value=""></option>
                                @foreach ($brand as $brand_opt)
                                    <option value="{{ $brand_opt->id }}">{{ $brand_opt->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="bs_model_default" id="bs_model_default">
                                <option selected disabled value=""></option>
                                @foreach ($models as $model_opt)
                                    <option data-brand-id="{{$model_opt->BrandId}}" value="{{ $model_opt->id }}">{{ $model_opt->Name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control" name="receiving_item_qty" id="receiving_item_qty" readonly="true">
                            <input type="hidden" class="form-control" name="receiving_item_id" id="receiving_item_id" readonly="true">
                            <input type="hidden" class="form-control" name="bs_current_index_value" id="bs_current_index_value" readonly="true">
                        </div>
                        <button id="mngItem" type="button" class="btn btn-info form_btn">Save</button>
                        <button id="closebuttonbatch" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--/ end batch,serial,expire date modal-->

    <script type="text/javascript">
        var b_i = 0;
        var b_m = 0;
        var b_j = 0;

        var s_i = 0;
        var s_m = 0;
        var s_j = 0;

        function mngBatchSerialExpireFn(indx,item_id){
            var qty = $(`#quantity${indx}`).val();
            if(isNaN(parseFloat(qty)) || parseFloat(qty) == 0){
                $(`#quantity${indx}`).css("background", errorcolor);
                toastrMessage('error',"Please enter a valid quantity first.","Error");
            }
            else{
                var is_batch_req = 0;
                var is_expiry_req = 0;
                var is_serial_req = 0;
                $.ajax({
                    type: "GET",
                    url: "{{ url('showitem') }}/"+item_id,
                    beforeSend: function () { 
                        blockPage(cardSection, 'Fetching item data...');
                    },
                    complete: function () { 
                        unblockPage(cardSection);
                    },
                    success: function(response) {
                        $("#receiving_item_qty").val(qty);
                        $("#receiving_item_id").val(item_id);
                        $("#batch_no_dynamic_table > tbody").empty();
                        $("#serial_no_dynamic_table > tbody").empty();

                        $("#batch_received_qty_lbl").html(`Received Quantity: <b>${numformat(parseFloat(qty).toFixed(0))}</b>`);

                        $.each(response.item, function (index, value) { 
                            $(".batch_item_type_lbl").html(value.Type);
                            $(".batch_item_code_lbl").html(value.Code);
                            $(".batch_item_name_lbl").html(value.Name);
                            $(".batch_barcode_lbl").html(value.SKUNumber);
                            $(".batch_item_category_lbl").html(value.category_name);
                            $(".batch_item_uom_lbl").html(value.uom_name);

                            $('.batch_serial_item_header_info').html(`Item Code: <b>${value.Code}</b>, Item Name: <b>${value.Name}</b>`);

                            $(".batch_item_retial_price_lbl").html(value.RetailerPrice === 0 ? '' : numformat(parseFloat(value.RetailerPrice).toFixed(2)));
                            $(".batch_item_wholesale_price_lbl").html(value.WholesellerPrice === 0 ? '' : numformat(parseFloat(value.WholesellerPrice).toFixed(2)));
                            $(".batch_item_wholesale_min_qty").html(value.wholeSellerMinAmount === 0 ? '' : numformat(parseFloat(value.wholeSellerMinAmount).toFixed(2)));

                            is_batch_req = value.RequireExpireDate == "Require-BatchNumber" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                            is_expiry_req = value.RequireExpireDate == "Require-ExpireDate" || value.RequireExpireDate == "Require-Both" ? "Yes" : "No";
                            is_serial_req = value.RequireSerialNumber == "Require" ? "Yes" : "No";

                            $(".is_batch_req").html(is_batch_req);
                            $(".is_expiry_date_req").html(is_expiry_req);
                            $(".is_serial_req").html(is_serial_req);

                            if(is_batch_req == "Yes" && is_serial_req == "Yes"){
                                $('#batch_no_div').attr('class','col-xl-10 col-lg-12 col-md-12 col-sm-12 col-12');
                                $('#serial_no_div').attr('class','col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12');
                                $("#serial_no_div").hide();
                            }
                            else{
                                $('#batch_no_div').attr('class','col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12');
                                $('#serial_no_div').attr('class','col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12');
                            }
                            
                        });
                    }
                });

                $(".batch_serial_collapse").collapse('hide');
                $('#manageItemModal').modal('show');
            }
        }

        $("#add_batch_no").click(function() {
            ++b_i;
            ++b_m;
            ++b_j;

            $("#batch_no_dynamic_table > tbody").append(
                `<tr class="border" id="bs_data_row${b_m}">
                    <td style="width:3%;text-align:left;vertical-align: top;">
                        <span class="badge badge-center rounded-pill bg-secondary">${b_j}</span>
                    </td>
                    <td style="display:none;"><input type="hidden" name="batch_row[${b_m}][batch_index_col]" id="batch_index_col${b_m}" class="batch_index_col form-control" readonly="true" style="font-weight:bold;" value="${b_m}"/></td>
                    <td style="width:94%">
                        <div class="row">
                            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Country</label>
                                <select class="select2 form-control" name="batch_row[${b_m}][bsOrigin]" id="bsOrigin${b_m}" onchange="bsOriginFn(this)"></select>
                                <span class="text-danger">
                                    <strong id="bs-origin-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Manufacturer</label>
                                <select class="select2 form-control" name="batch_row[${b_m}][bsManufacturer]" id="bsManufacturer${b_m}" onchange="bsManufacturerFn(this)"></select>
                                <span class="text-danger">
                                    <strong id="bs-manufacturer-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Manufacture Date</label>
                                <input type="text" id="bsManufactureDate${b_m}" name="batch_row[${b_m}][bsManufactureDate]" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="bsManufactureDateFn(this)"/>
                                <span class="text-danger">
                                    <strong id="bs-manufacture-date-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Brand</label>
                                <select class="select2 form-control" name="batch_row[${b_m}][bsBrand]" id="bsBrand${b_m}" onchange="bsBrandFn(this)"></select>
                                <span class="text-danger">
                                    <strong id="bs-brand-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-1 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Model</label>
                                <select class="select2 form-control" name="batch_row[${b_m}][bsModel]" id="bsModel${b_m}" onchange="bsModelFn(this)"></select>
                                <span class="text-danger">
                                    <strong id="bs-model-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Batch No.<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" placeholder="Enter Batch Number" class="bactchNumber form-control" name="batch_row[${b_m}][bactchNumber]" id="bactchNumber${b_m}" onkeyup="bactchNumberFn(this)" onblur="checkDuplicatesFn(this)"/>
                                <span class="text-danger">
                                    <strong id="bs-batchno-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Quantity<b style="color: red; font-size:16px;">*</b></label>
                                <input type="number" placeholder="Enter Quantity" class="bactchQuantity form-control" name="batch_row[${b_m}][bactchQuantity]" id="bactchQuantity${b_m}" onkeyup="bactchQuantityFn(this)" onkeypress="return ValidateOnlyNum(event);"/>
                                <span class="text-danger">
                                    <strong id="bs-batchqty-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                <label class="form_lbl">Expiry Date<b style="color: red; font-size:16px;">*</b></label>
                                <input type="text" id="bsExpiryDate${b_m}" name="batch_row[${b_m}][bsExpiryDate]" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="bsExpiryDateFn(this)"/>
                                <span class="text-danger">
                                    <strong id="bs-expiry-date-error${b_m}" class="bs_error_cls"></strong>
                                </span>
                            </div>
                        </div>
                    </td>
                    <td style="width:3%;position:relative;vertical-align: top;">
                        <button type="button" class="btn btn-light btn-sm remove-batch-tr" id="remove-batch-tr${b_m}" onclick="removeBatchRecordFn(this)" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;position: absolute; top: 2px; right: 0px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-light btn-sm add-serial-no-btn" id="add-serial-no-btn${b_m}" onclick="openSerailNumberFormFn(this)" title="Add serial number under this batch number" style="color:#00cfe8;background-color:#FFFFFF;border-color:#FFFFFF;position: absolute; bottom: 2px; right: 0px;"><i class="fas fa-arrow-circle-right"></i></button>
                    </td>
                </tr>`
            );

            var origin_options = $("#bs_country_default > option").clone();
            $(`#bsOrigin${b_m}`).empty().append(origin_options).select2({placeholder: "Select origin here..."});

            var manufacurer_options = $("#bs_manufacturer_default > option").clone();
            $(`#bsManufacturer${b_m}`).empty().append(manufacurer_options).select2({placeholder: "Select manufacturer here..."});

            flatpickr(`#bsManufactureDate${b_m}`, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});

            var brand_options = $("#bs_brand_default > option").clone();
            $(`#bsBrand${b_m}`).empty().append(brand_options).select2({placeholder: "Select brand here..."});

            $(`#bsModel${b_m}`).empty().select2({placeholder: "Select brand first"});

            flatpickr(`#bsExpiryDate${b_m}`, { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});

            $("#serial_no_div").hide();
            $("#add_serial_no").hide();
            $("#batch_title_for_serial_no").html("");

            renumberBatchNumberRows();
        });

        $("#add_serial_no").click(function() {
            var sn_last_row = $('#serial_no_dynamic_table tr:last').find('td').eq(1).find('input').val();
            var current_index = $("#bs_current_index_value").val();
            var serial_number = $(`#serialNumber${sn_last_row}`).val();
            var batch_qty = $(`#bactchQuantity${current_index}`).val();
            var total_sn = $(`#serial_no_dynamic_table > tbody > tr.serial_no_row${current_index}`).length;

            if(serial_number != undefined && (serial_number == null || serial_number == "")){
                $(`#serialNumber${sn_last_row}`).css("background",errorcolor);
                toastrMessage('error',"Please fill a valid data on highlighted fields","Error");
            }
            else if(parseFloat(batch_qty) == parseFloat(total_sn)){
                toastrMessage('error',"The number of serial numbers cannot exceed the total quantity for this batch.","Error");
            }
            else{
                ++s_i;
                ++s_m;
                ++s_j;
                $("#serial_no_dynamic_table > tbody").append(
                    `<tr class="border serial_no_tr serial_no_row${current_index}" id="sn_data_row${s_m}">
                        <td style="font-weight:bold;width:10%;text-align:center;">${s_j}</td>
                        <td style="display:none;"><input type="hidden" name="row[${s_m}][serial_index_col]" id="serial_index_col${m}" class="serial_index_col form-control" readonly="true" style="font-weight:bold;" value="${s_m}"/></td>
                        <td style="width:80%">
                            <input type="text" placeholder="Enter Serial Number" class="serialNumber form-control" name="serial_row[${s_m}][serialNumber]" id="serialNumber${s_m}" onkeyup="serialNumberFn(this)" onblur="checkSerialNumDuplicatesFn(this)"/>
                        </td>
                        <td style="width:10%;text-align:center;">
                            <button type="button" id="remove_serial_tr${s_m}" class="btn btn-light btn-sm remove_serial_tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        </td>
                    </tr>`
                );
                renumberSerialNumberRows();
            }
        });

        function renumberSerialNumberRows(){
            var current_index = $("#bs_current_index_value").val();
            $(`#serial_no_dynamic_table > tbody > tr.serial_no_row${current_index}`).each(function(index,el) {
                $(this).children('td').first().text(index += 1);
            });
        }

        function serialNumberFn(ele){
            var row_id = $(ele).closest('tr').find('.serial_index_col').val();
            $(`#serialNumber${row_id}`).css("background",'white');
        }

        function checkSerialNumDuplicatesFn(ele){
            var row_id = $(ele).closest('tr').find('.serial_index_col').val();
            checkSerialDuplicatesFn('serialNumber',row_id);
        }

        function checkSerialDuplicatesFn(className,row_id) {
            var values = [];
            var hasDuplicate = false;
            
            $('input.' + className).each(function() {
                var val = $(this).val().trim().toLowerCase();
                if (val && values.includes(val)) {
                    hasDuplicate = true;
                    return false; // Stop checking
                }
                values.push(val);
            });
            
            if (hasDuplicate) {
                $(`#serialNumber${row_id}`).val("");
                $(`#serialNumber${row_id}`).css("background",errorcolor);
                toastrMessage('error',"Duplicate serial number found! Please enter unique serial number.","Error");
                return false;
            }
            return true;
        }

        $(document).on('click', '.remove_serial_tr', function() {
            $(this).parents('tr').remove();
            renumberSerialNumberRows();
        });

        function renumberBatchNumberRows(){
            $('#batch_no_dynamic_table > tbody > tr').each(function(index,el) {
                $(this).children('td').first().html(`<span class="badge badge-center rounded-pill bg-secondary">${++index}</span>`);
            });
        }

        function bsOriginFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#select2-bsOrigin${row_id}-container`).parent().css('background-color','white');
            $(`#bs-origin-error${row_id}`).html("");
        }

        function bsManufacturerFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#select2-bsManufacturer${row_id}-container`).parent().css('background-color','white');
            $(`#bs-manufacturer-error${row_id}`).html("");
        }

        function bsManufactureDateFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#bsManufactureDate${row_id}`).css("background",'white');
            $(`#bs-manufacture-date-error${row_id}`).html("");
        }

        function bsBrandFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            var brand_id = $(`#bsBrand${row_id}`).val();
            var model_option = $("#bs_model_default");
            $(`#bsModel${row_id}`).empty().append(model_option.find(`option[data-brand-id="${brand_id}"]`).clone());
            $(`#bsModel${row_id}`).append(`<option selected disabled value=""></option>`).select2({placeholder: "Select model here..."});

            $(`#select2-bsBrand${row_id}-container`).parent().css('background-color','white');
            $(`#bs-brand-error${row_id}`).html("");
        }

        function bsModelFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#select2-bsModel${row_id}-container`).parent().css('background-color','white');
            $(`#bs-model-error${row_id}`).html("");
        }

        function bactchNumberFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            showBatchNumberTitleFn(row_id);
            $(`#bactchNumber${row_id}`).css("background",'white');
            $(`#bs-batchno-error${row_id}`).html("");
        }

        function checkDuplicatesFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            var batch_number = $(`#bactchNumber${row_id}`).val();
            checkBatchDuplicatesFn('bactchNumber',row_id);
        }

        function bactchQuantityFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#bactchQuantity${row_id}`).css("background",'white');
            $(`#bs-batchqty-error${row_id}`).html("");
            checkQuantityVarianceFn(row_id);
            showBatchNumberTitleFn(row_id);
        }

        function bsExpiryDateFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#bsExpiryDate${row_id}`).css("background",'white');
            $(`#bs-expiry-date-error${row_id}`).html("");
        }

        function removeBatchRecordFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();

            Swal.fire({
                title: confirmation_title,
                text: 'Are you sure: Removing this batch will automatically delete its associated serial numbers',
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Close',
                customClass: {
                    confirmButton: 'btn btn-info',
                    cancelButton: 'btn btn-danger'
                }
            }).then(function (result) {
                if (result.value) {
                    bsRemoveBatchNoFn(row_id);
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {}
            });
        }

        function bsRemoveBatchNoFn(row_id){
            $(`#bs_data_row${row_id}`).remove();
            $(`.serial_no_row${row_id}`).remove();
            renumberBatchNumberRows();
        }

        function openSerailNumberFormFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            
            var qty = $(`#bactchQuantity${row_id}`).val();

            if(isNaN(parseFloat(qty)) || parseFloat(qty) == 0){
                $(`#bactchQuantity${row_id}`).css("background",errorcolor);
                toastrMessage('error',"Please enter a valid quantity first.","Error");
            }
            else{
                $("#bs_current_index_value").val(row_id);
                showBatchNumberTitleFn(row_id);

                var current_index = $("#bs_current_index_value").val();
                $(".serial_no_tr").hide();
                $(`.serial_no_row${current_index}`).show();

                $("#serial_no_div").show();
                $("#add_serial_no").show();
                $("#bs_current_index_value").val(row_id);
            }
        }

        function checkQuantityVarianceFn(row_id){
            var received_qty =  $("#receiving_item_qty").val();
            var inserted_qty = 0;
            received_qty = received_qty == '' ? 0 : received_qty;

            $.each($('#batch_no_dynamic_table').find('.bactchQuantity'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    inserted_qty += parseFloat($(this).val());
                }
            });

            if(parseFloat(inserted_qty) > parseFloat(received_qty)){
                $(`#bactchQuantity${row_id}`).val("");
                $(`#bactchQuantity${row_id}`).css("background",errorcolor);
                toastrMessage('error',"Quantity cannot be greater than the amount received.","Error");
                return false;
            }
        }

        function checkBatchDuplicatesFn(className,row_id) {
            var values = [];
            var hasDuplicate = false;
            
            $('input.' + className).each(function() {
                var val = $(this).val().trim().toLowerCase();
                if (val && values.includes(val)) {
                    hasDuplicate = true;
                    return false; // Stop checking
                }
                values.push(val);
            });
            
            if (hasDuplicate) {
                $(`#bactchNumber${row_id}`).val("");
                $(`#bactchNumber${row_id}`).css("background",errorcolor);
                toastrMessage('error',"Duplicate batch number found! Please enter unique batch number.","Error");
                showBatchNumberTitleFn(row_id);
                return false;
            }
            return true;
        }

        function showBatchNumberTitleFn(row_id){
            var row_id_check = $("#bs_current_index_value").val();
            if(row_id == row_id_check){
                var batch_number = $(`#bactchNumber${row_id}`).val();
                var batch_qty = $(`#bactchQuantity${row_id}`).val();
                $("#batch_title_for_serial_no").html(`Batch No.: <b>${batch_number}</b> | Qty: <b>${batch_qty}</b>`);
            }
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.batch_coll', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.batch_serial_item_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if(isOpening) {
                const originalHeader = `<i class="far fa-info-circle"></i> Basic Information`;
                infoTarget.html(originalHeader);
            } 
            else{
                // Section is COLLAPSING: Show the data summary
                const item_code = container.find('.batch_item_code_lbl').text().trim();
                const item_name = container.find('.batch_item_name_lbl').text().trim();
                const summaryHtml = `
                    Item Code: <b>${item_code}</b>,
                    Item Name: <b>${item_name}</b>`;
                infoTarget.html(summaryHtml);
            }
        });
    </script>