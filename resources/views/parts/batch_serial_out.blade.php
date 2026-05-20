    <!-- start batch,serial,expire date modal-->
    <div class="modal modal-slide-in event-sidebar fade fit-content" id="manageItemModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form id="ManageBatchAndSerialForm">    
            <div class="modal-dialog sidebar-xl" style="width: 96%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title form_title" id="manage-item-title"></h5>
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
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 mt-1 mb-1">
                                                <div class="card shadow-none border m-0">
                                                    <div class="card-body mb-0">
                                                        <h6 class="card-title mb-0"><i class="fas fa-database"></i> General Information</h6>
                                                        <hr class="my-50">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-7 col-sm-7 col-12">
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
                                                            <div class="col-xl-6 col-lg-6 col-md-5 col-sm-5 col-12">
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

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mt-1 mb-1">
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
                                    <div id="batch_no_div" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="table-responsive pr-0 pl-0" style="width: 100%;overflow-x: auto;-webkit-overflow-scrolling: touch;margin: 0 0rem;padding: 0 1rem;">
                                            <table id="batch_no_dynamic_table" class="fit-content" style="width:100%;">
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <table class="mb-0">
                                            <tr>
                                                <td>
                                                    <button type="button" name="add_batch_no" id="add_batch_no" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-xl-10 col-lg-9 col-md-8 col-sm-7 col-4"></div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-8">
                                        <table style="width: 100%;font-size:12px;text-align:center;">
                                            <tr>
                                                <td class="border" style="width:60%;"><label title="Sold/ Issued Quantity">Issued Qty.</label></td>
                                                <td class="border" style="width:40%;"><label style="font-weight: bold;" id="bs_footer_received_qty"></label></td>
                                            </tr>
                                            <tr id="total_batch_qty_tr" class="bs_total_figure_class">
                                                <td class="border total_batch_qty_td"><label class="total_batch_qty_lbl" title="Total Batch Quantity">Total Entered Qty.</label></td>
                                                <td class="border total_batch_qty_td"><label class="total_batch_qty_lbl" style="font-weight: bold;" id="bs_footer_total_batch_qty"></label></td>
                                            </tr>
                                            <tr id="total_serial_qty_tr" class="bs_only_serial_controls bs_total_figure_class" style="display: none;">
                                                <td class="border total_serial_qty_td"><label class="total_serial_qty_lbl" title="Total Serial Quantity">Total Serial Qty.</label></td>
                                                <td class="border total_serial_qty_td"><label class="total_serial_qty_lbl" style="font-weight: bold;" id="bs_footer_total_serial_qty"></label></td>
                                            </tr>
                                        </table>
                                        
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
                            {{-- <select class="select2 form-control" name="bs_country_default" id="bs_country_default">
                                <option selected disabled value=""></option>
                                @foreach ($countries as $cnt)
                                    <option value="{{ $cnt->id }}">{{ $cnt->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="bs_brand_default" id="bs_brand_default">
                                <option selected disabled value=""></option>
                                @foreach ($brand as $brand_opt)
                                    <option value="{{ $brand_opt->id }}">{{ $brand_opt->brand_name }}</option>
                                @endforeach
                            </select> --}}
                            <select class="select2 form-control" name="bs_item_instance_default" id="bs_item_instance_default">
                                <option selected disabled value=""></option>
                                @foreach ($item_instance as $instance_data)
                                    <option data-expiry-date="{{$instance_data->expiry_date}}" data-store-id="{{$instance_data->store_id}}" data-item-id="{{$instance_data->item_id}}" value="{{ $instance_data->id }}">{{ $instance_data->item_instance }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="serialnumber_default" id="serialnumber_default">
                                <option selected disabled value=""></option>
                                @foreach ($serial_number_data as $serial_num_data)
                                    <option data-batch-id="{{$serial_num_data->batches_id}}" data-sold-flag="{{$serial_num_data->is_sold_issued}}" data-sold-issued-id="{{$serial_num_data->sold_issue_id}}" data-source-type="{{ $serial_num_data->source_type }}" value="{{ $serial_num_data->id }}">{{ $serial_num_data->serial_number }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" class="form-control" name="IsBatchNumberRequired" id="IsBatchNumberRequired" readonly="true">
                            <input type="hidden" class="form-control" name="IsSerialNumberRequired" id="IsSerialNumberRequired" readonly="true">
                            <input type="hidden" class="form-control" name="IsExpiryDateRequired" id="IsExpiryDateRequired" readonly="true">
                            <input type="hidden" class="form-control" name="bsTransactionType" id="bsTransactionType" readonly="true">
                            <input type="hidden" class="form-control" name="bsHeaderId" id="bsHeaderId" readonly="true">
                            <input type="hidden" class="form-control" name="bs_item_qty" id="bs_item_qty" readonly="true">
                            <input type="hidden" class="form-control" name="bs_item_id" id="bs_item_id" readonly="true">
                            <input type="hidden" class="form-control" name="bs_store_id" id="bs_store_id" readonly="true">
                            <input type="hidden" class="form-control" name="bs_current_index_value" id="bs_current_index_value" readonly="true">
                            <input type="hidden" class="form-control" name="bs_operation_type" id="bs_operation_type" readonly="true">
                        </div>
                        <button id="save_batch_and_serial_btn" type="button" class="btn btn-info form_btn">Save</button>
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
        var START_YEAR = 1900;
        var END_YEAR = 2100;

        $('#save_batch_and_serial_btn').click(function(){
            var manageForm = $("#ManageBatchAndSerialForm");
            var formData = manageForm.serialize();
            var opt_type = $("#bs_operation_type").val();
            $.ajax({
                url: '/issueBatchAndSerial',
                type: 'POST',
                data: formData,
                beforeSend: function() { 
                    var processing_msg = "";
                    var btn_text = "";
                    if(parseInt(opt_type) == 1){
                        processing_msg = "Saving batch and/or serial number";
                        btn_text = "Saving...";
                    }
                    else{
                        processing_msg = "Updating batch and/or serial number";
                        btn_text = "Updating...";
                    }
                    blockPage(cardSection,processing_msg);
                    $('#save_batch_and_serial_btn').text(btn_text);
                    $('#save_batch_and_serial_btn').prop("disabled", true);
                },
                error: function () { 
                    unblockPage(cardSection);     
                },
                success:async function(data) {
                    await saveBatchSerialFn(data);
                }
            });
        });

        function saveBatchSerialFn(data){
            var opt_type = $("#bs_operation_type").val();

            if(data.errorbatch) {
                var is_batch_req =  $('#IsBatchNumberRequired').val();
                var is_expiry_req =  $('#IsExpiryDateRequired').val();
                $('#batch_no_dynamic_table > tbody > tr').each(function (index) {
                    let row_id = $(this).find('.batch_index_col').val();
                    var instance_id = $(`#Instance${row_id}`).val();
                    var qty = $(`#bactchQuantity${row_id}`).val();

                    if(isNaN(parseFloat(instance_id))){
                        $(`#select2-Instance${row_id}-container`).parent().css('background-color',errorcolor);
                    }
                    if($(`#bactchQuantity${row_id}`).val() != undefined){
                        if(isNaN(parseFloat(qty)) || parseFloat(qty) == 0){
                            $(`#bactchQuantity${row_id}`).css("background", errorcolor);
                        }
                    }
                });
                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
            }
            else if (data.errorserial) {
                var is_serial_req =  $('#IsSerialNumberRequired').val();
                $('.serial_no_dynamic_table > tbody > tr').each(function (index) {
                    let row_id = $(this).find('.serial_index_col').val();
                    let parent_row_id = $(this).find('.parent_row_id').val();
                    var serial_number = $(`#serialNumber${row_id}`).val();
                    if(serial_number !== undefined && is_serial_req == "Yes"){
                        if(isNaN(parseInt(serial_number))){
                            $(`#select2-serialNumber${row_id}-container`).parent().css('background-color',errorcolor);

                            $(`#serialNumberDiv${parent_row_id}`).show();
                            $(`#toggleSerialNum${parent_row_id}`).html('<i class="fa fa-chevron-up"></i> Hide Serial No.');
                        }
                    }
                });

                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
            }
            else if(data.empty_batch){
                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('error',"You should add atleast one batch group","Error");
            }
            else if(data.empty_serial){
                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('error',"You should add atleast one serial number","Error");
            }

            else if(data.variances){
                var list_of_rows = "";
                $.each(data.variances, function(index, rowno) {
                    list_of_rows += `Row #: <b>${rowno}</b></br>`;
                });

                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('warning',`Please match serial number and entered quantity for the specified rows below</br>--------------</br>${list_of_rows}`,"Warning");
            }
            else if(data.batch_variances){
                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('warning',"The issued quantity does not match the total quantity entered.","Warning");
            }
            else if (data.dberrors) {
                if(parseInt(opt_type) == 1){
                    $('#save_batch_and_serial_btn').text('Save');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                else if(parseInt(opt_type) == 2){
                    $('#save_batch_and_serial_btn').text('Update');
                    $('#save_batch_and_serial_btn').prop("disabled", false);
                }
                unblockPage(cardSection);
                toastrMessage('error',"Please contact administrator","Error");
            }
            else if (data.success) {
                toastrMessage('success',"Successful","Success");
                if(data.trn_type == 11){
                    createDOInfoFn(data.header_id);
                }
                $('#manageItemModal').modal('hide');
            }
        }

        function mngBatchSerialExpireFn(indx,header_id,item_id,store_id,qty,trn_type){
            var source_id = null;
            var itemId = null;
            var source_type = null;
            var default_serial_no = $("#serialnumber_default");
            $(".bs_only_serial_controls").hide();
            $("#bsItemRowId").val(indx);
            $("#batch_no_dynamic_table > tbody").empty();

            if(isNaN(parseFloat(qty)) || parseFloat(qty) == 0){
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
                        $("#bs_item_qty").val(qty);
                        $("#bs_footer_received_qty").html(numformat(parseFloat(qty).toFixed(0)));
                        $("#bs_item_id").val(item_id);
                        $("#bs_store_id").val(store_id);

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
                            is_serial_req = value.RequireSerialNumber == "Required" ? "Yes" : "No";

                            $(".is_batch_req").html(is_batch_req);
                            $(".is_expiry_date_req").html(is_expiry_req);
                            $(".is_serial_req").html(is_serial_req);

                            $("#IsBatchNumberRequired").val(is_batch_req);
                            $("#IsSerialNumberRequired").val(is_serial_req);
                            $("#IsExpiryDateRequired").val(is_expiry_req);

                            if(is_batch_req == "Yes"){
                                $(".bs_batch_no_controls").show();
                            }
                            if(is_serial_req == "Yes"){
                                $(".bs_only_serial_controls").show();
                            }
                            if(is_expiry_req == "Yes"){
                                $(".bs_expiry_date_controls").show();
                            }
                        });

                        $("#bs_footer_total_batch_qty").html("");
                        $("#bs_footer_total_serial_qty").html("");
                        countTotalBatchAndSerialFn();
                    }
                });

                $.ajax({ 
                    url: '/getBatchAndSerialIssued', 
                    type: 'POST',
                    data:{
                        source_id : header_id,
                        itemId : item_id,
                        source_type : trn_type,
                    },
                    success: function(data) {
                        if(parseInt(data.batch_data.length) > 0){
                            $("#bs_operation_type").val(2);
                            $("#manage-item-title").html("Update Batch and/or Serial Numbers");
                            $('#save_batch_and_serial_btn').text('Update');
                            $('#save_batch_and_serial_btn').prop("disabled", false);
                        }
                        else{
                            $("#bs_operation_type").val(1);
                            $("#manage-item-title").html("Save Batch and/or Serial Numbers");
                            $('#save_batch_and_serial_btn').text('Save');
                            $('#save_batch_and_serial_btn').prop("disabled", false);
                        }
                        
                        $.each(data.batch_data, function (index, value) { 
                            ++b_i;
                            ++b_m;
                            ++b_j;

                            $("#batch_no_dynamic_table > tbody").append(
                                `<tr class="border" id="bs_data_row${b_m}">
                                    <td style="width:2%;text-align:left;vertical-align: top;">
                                        <span class="badge badge-center rounded-pill bg-secondary">${b_j}</span>
                                    </td>
                                    <td style="display:none;">
                                        <input type="hidden" name="batch_row[${b_m}][batch_index_col]" id="batch_index_col${b_m}" class="batch_index_col form-control" readonly="true" style="font-weight:bold;" value="${b_m}"/>
                                    </td>
                                    <td style="width:96%">
                                        <div class="row">
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-sm-4 col-12 mb-1">
                                                <label class="form_lbl"><i class="fas fa-info-circle" title="✓ Brand &#10;✓ Generic/ Model Name &#10;✓ Batch Number &#10;✓ Expiry Date"></i> Item Instance<b style="color: red; font-size:16px;">*</b></label>
                                                <select class="select2 form-control item_instance" name="batch_row[${b_m}][Instance]" id="Instance${b_m}" onchange="instanceFn(this)"></select>
                                                <span class="text-danger">
                                                    <strong id="bs-instance-error${b_m}" class="bs_error_cls"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-1">
                                                <label class="form_lbl">Quantity on Hand</label>
                                                <input type="number" placeholder="Quantity on Hand" class="form-control" name="batch_row[${b_m}][quantity_on_hand]" readonly id="quantity_on_hand${b_m}" style="font-weight:bold;"/>
                                                <span class="text-danger">
                                                    <strong id="bs-qtyonhand-error${b_m}" class="bs_error_cls"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 mb-1">
                                                <label class="form_lbl">Quantity<b style="color: red; font-size:16px;">*</b></label>
                                                <input type="number" placeholder="Enter Quantity" class="bactchQuantity form-control" name="batch_row[${b_m}][bactchQuantity]" id="bactchQuantity${b_m}" onkeyup="bactchQuantityFn(this)" onkeypress="return ValidateOnlyNum(event);"/>
                                                <span class="text-danger">
                                                    <strong id="bs-batchqty-error${b_m}" class="bs_error_cls"></strong>
                                                </span>
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 bs_only_serial_controls" id="toggleSerialNumberDiv${b_m}" style="text-align:right;display:none;">
                                                <input type="hidden" id="batch_uuid${b_m}" name="batch_row[${b_m}][batch_uuid]" class="form-control batch_uuid"/>
                                                <input type="hidden" id="batch_db_id${b_m}" name="batch_row[${b_m}][batch_db_id]" class="form-control batch_db_id"/>
                                                <button type="button" class="btn btn-light btn-sm btn-outline-warning mr-1" id="batch_serial_stat_btn${b_m}" disabled>
                                                    Qty.: 0 | Serial Qty.: 0
                                                </button>
                                                
                                                <button type="button" class="btn btn-light btn-sm btn-outline-info" id="toggleSerialNum${b_m}" onclick="toggleSerialNumberFn('${b_m}')">
                                                    <i id="toggle_icon${b_m}" class="fa fa-chevron-down"></i> Show Serial No.
                                                </button>
                                            </div>
                                        </div>
                                    
                                        <div class="row" id="serialNumberDiv${b_m}" style="display:none;margin-top:-0.5rem !important;">
                                            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-2 mb-1"></div>
                                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-8 mb-1">
                                                <table id="serial_no_dynamic_table${b_m}" class="mb-0 serial_no_dynamic_table rtable form_dynamic_table" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th class="form_lbl" style="width: 10%">#</th>
                                                            <th class="form_lbl" style="width: 80%">Serial No.<b style="color: red; font-size:16px;">*</b></th>
                                                            <th class="form_lbl" style="width: 10%"></th>
                                                        </tr>
                                                    <thead>
                                                    <tbody></tbody>
                                                </table>
                                                <button type="button" name="batch_row[${b_m}][add_serial_no]" id="add_serial_no${b_m}" class="btn btn-success btn-sm" onclick="addSerialNumberFn(${b_m})"><i class="fa fa-plus" aria-hidden="true"></i>  Add Serial No.</button>
                                            </div>
                                            <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-2 mb-1"></div>
                                        </div>
                                    </td>
                                    <td style="width:2%;position:relative;vertical-align: top;">
                                        <button type="button" class="btn btn-light btn-sm remove-batch-tr" id="remove-batch-tr${b_m}" onclick="removeBatchRecordFn(this)" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;position: absolute; top: 2px; right: 0px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                                    </td>
                                </tr>`
                            );

                            var instance_data = `<option selected value='${value.batch_id}'>${value.item_instance}</option>`;
 
                            $(`#Instance${b_m}`).empty().append(getClonedOption(item_id,store_id));
                            $(`#Instance${b_m} option[value="${value.batch_id}"]`).remove();
                            $(`#Instance${b_m}`).append(instance_data).select2();

                            $(`#bactchNumber${b_m}`).val(value.batch_number);
                            $(`#bactchQuantity${b_m}`).val(value.sold_issued_qty);                       

                            $(`#batch_uuid${b_m}`).val(value.batch_uuid);
                            $(`#batch_db_id${b_m}`).val(value.batch_issue_id);

                            fetchInstanceFn(b_m,value.sold_issued_qty);

                            $(`#serialNumberDiv${b_m}`).hide();
                            $(`#toggleSerialNum${b_m}`).html('<i class="fa fa-chevron-down"></i> Show Serial No.');

                            if($("#IsBatchNumberRequired").val() == "Yes"){
                                $(".bs_batch_no_controls").show();
                            }
                            if($("#IsSerialNumberRequired").val() == "Yes"){
                                $(".bs_only_serial_controls").show();
                            }
                            if($("#IsExpiryDateRequired").val() == "Yes"){
                                $(".bs_expiry_date_controls").show();
                            }

                            $.each(data.serial_data, function (ser_index, ser_value) {
                                var op_type = $("#bs_operation_type").val();
                                if(parseFloat(value.id) == parseFloat(ser_value.batches_id)){
                                    ++s_i;
                                    ++s_m;
                                    ++s_j;
                                    $(`#serial_no_dynamic_table${b_m} > tbody`).append(
                                        `<tr class="border serial_no_tr serial_no_row${b_m}" id="sn_data_row${s_m}">
                                            <td style="font-weight:bold;width:10%;text-align:center;">${s_j}</td>
                                            <td style="display:none;"><input type="hidden" name="serial_row[${s_m}][serial_index_col]" id="serial_index_col${s_m}" class="serial_index_col form-control" readonly="true" style="font-weight:bold;" value="${s_m}"/></td>
                                            <td style="display:none;"><input type="hidden" name="serial_row[${s_m}][parent_row_id]" id="parent_row_id${s_m}" class="parent_row_id form-control" readonly="true" style="font-weight:bold;" value="${b_m}"/></td>
                                            <td style="width:80%">
                                                <select id="serialNumber${s_m}" class="select2 form-control serialNumber" onchange="serialNumberFn(this)" name="serial_row[${s_m}][serialNumber]"></select>
                                            </td>
                                            <td style="width:10%;text-align:center;">
                                                <input type="hidden" id="serial_uuid${s_m}" name="serial_row[${s_m}][serial_uuid]" class="form-control serial_uuid"/>
                                                <input type="hidden" id="serial_db_id${s_m}" name="serial_row[${s_m}][serial_db_id]" class="form-control serial_db_id"/>
                                                <button type="button" id="remove_serial_tr${s_m}" class="btn btn-light btn-sm remove_serial_tr" onclick="removeSerialNumberTrFn(${b_m},${s_m})" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                                            </td>
                                        </tr>`
                                    );

                                    var default_selected_serial_no = `<option selected value='${ser_value.id}'>${ser_value.serial_number}</option>`;
                                    var default_option = `<option selected disabled value=""></option>`;
                                    $(`#serialNumber${s_m}`).append(default_option).select2();
                                    if(parseInt(op_type) == 1){
                                        $(`#serialNumber${s_m}`).append(default_serial_no.find(`option[data-batch-id="${ser_value.batches_id}"][data-sold-flag="0"]`).clone());
                                    }
                                    else if(parseInt(op_type) == 2){
                                        var batch_flag = [0, 1];
                                        $(`#serialNumber${s_m}`).append(default_serial_no.find(`option[data-batch-id="${ser_value.batches_id}"][data-sold-flag="0"]`).clone());
                                        $(`#serialNumber${s_m}`).append(default_serial_no.find(`option[data-batch-id="${ser_value.batches_id}"][data-sold-flag="1"]`).clone());
                                    }

                                    $(`#serial_no_dynamic_table${b_m} > tbody > tr`).each(function(index, tr) {
                                        let ser_id = $(this).find('.serialNumber').val();
                                        $(`#serialNumber${s_m} option[value="${ser_id}"]`).remove(); 
                                    });

                                    $(`#serialNumber${s_m} option[value="${ser_value.id}"]`).remove();
                                    $(`#serialNumber${s_m}`).append(default_selected_serial_no).select2();

                                    $(`#serial_uuid${s_m}`).val(ser_value.serial_uuid);
                                    $(`#serial_db_id${s_m}`).val(ser_value.id);
                                } 
                            });

                            renumberSerialNumberRows(b_m);
                            countBatchAndSerialQtyFn(b_m);
                        });

                        renumberBatchNumberRows();
                        countTotalBatchAndSerialFn();
                    }
                });

                $(".batch_serial_collapse").collapse('hide');
                $("#bsTransactionType").val(trn_type);
                $("#bsHeaderId").val(header_id);
                $('#manageItemModal').modal('show');
            }
        }

        $("#add_batch_no").click(function() {
            var batch_last_row = $(`#batch_no_dynamic_table > tbody > tr:last`).find('td').eq(1).find('input').val();
            var batch_qty = $(`#bactchQuantity${batch_last_row}`).val();
            var total_received_qty = $(`#bs_item_qty`).val();
            var item_id = $(`#bs_item_id`).val(); 
            var store_id = $(`#bs_store_id`).val(); 
            var total_batch_qty = 0;
            $.each($(`#batch_no_dynamic_table`).find('.bactchQuantity'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    total_batch_qty += parseFloat($(this).val());
                }
            });

            if(batch_qty != undefined && (isNaN(parseFloat(batch_qty)) || parseFloat(batch_qty) == 0)){
                $(`#bactchQuantity${batch_last_row}`).css("background",errorcolor);
                toastrMessage('error',"Please fill a valid data on highlighted fields","Error");
            }
            else if(parseFloat(total_received_qty) == parseFloat(total_batch_qty)){
                toastrMessage('error',"The total quantity of batch numbers must not exceed the issued quantity.","Error");
            }
            else{
                ++b_i;
                ++b_m;
                ++b_j;
                var is_batch_req = $(".is_batch_req").text();
                var is_expiry_req = $(".is_expiry_date_req").text();
                var is_serial_req = $(".is_serial_req").text();

                $("#batch_no_dynamic_table > tbody").append(
                    `<tr class="border" id="bs_data_row${b_m}">
                        <td style="width:2%;text-align:left;vertical-align: top;">
                            <span class="badge badge-center rounded-pill bg-secondary">${b_j}</span>
                        </td>
                        <td style="display:none;">
                            <input type="hidden" name="batch_row[${b_m}][batch_index_col]" id="batch_index_col${b_m}" class="batch_index_col form-control" readonly="true" style="font-weight:bold;" value="${b_m}"/>
                        </td>
                        <td style="width:96%">
                            <div class="row">
                                <div class="col-xl-8 col-lg-6 col-md-6 col-sm-4 col-12 mb-1">
                                    <label class="form_lbl"><i class="fas fa-info-circle" title="✓ Brand &#10;✓ Generic/ Model Name &#10;✓ Batch Number &#10;✓ Expiry Date"></i> Item Instance<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control item_instance" name="batch_row[${b_m}][Instance]" id="Instance${b_m}" onchange="instanceFn(this)"></select>
                                    <span class="text-danger">
                                        <strong id="bs-instance-error${b_m}" class="bs_error_cls"></strong>
                                    </span>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-1">
                                    <label class="form_lbl">Quantity on Hand</label>
                                    <input type="number" placeholder="Quantity on Hand" class="form-control" name="batch_row[${b_m}][quantity_on_hand]" readonly id="quantity_on_hand${b_m}" style="font-weight:bold;"/>
                                    <span class="text-danger">
                                        <strong id="bs-qtyonhand-error${b_m}" class="bs_error_cls"></strong>
                                    </span>
                                </div>
                                
                                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6 mb-1">
                                    <label class="form_lbl">Quantity<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="number" placeholder="Enter Quantity" class="bactchQuantity form-control" name="batch_row[${b_m}][bactchQuantity]" id="bactchQuantity${b_m}" onkeyup="bactchQuantityFn(this)" onkeypress="return ValidateOnlyNum(event);"/>
                                    <span class="text-danger">
                                        <strong id="bs-batchqty-error${b_m}" class="bs_error_cls"></strong>
                                    </span>
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1 bs_only_serial_controls" id="toggleSerialNumberDiv${b_m}" style="text-align:right;display:none;">
                                    <input type="hidden" id="old_instance_id${b_m}" name="batch_row[${b_m}][old_instance_id]" class="form-control old_instance_id" readonly/>
                                    <input type="hidden" id="batch_uuid${b_m}" name="batch_row[${b_m}][batch_uuid]" class="form-control batch_uuid"/>
                                    <input type="hidden" id="batch_db_id${b_m}" name="batch_row[${b_m}][batch_db_id]" class="form-control batch_db_id"/>
                                    <button type="button" class="btn btn-light btn-sm btn-outline-warning mr-1" id="batch_serial_stat_btn${b_m}" disabled>
                                        Qty.: 0 | Serial Qty.: 0
                                    </button>
                                    
                                    <button type="button" class="btn btn-light btn-sm btn-outline-info" id="toggleSerialNum${b_m}" onclick="toggleSerialNumberFn('${b_m}')">
                                        <i id="toggle_icon${b_m}" class="fa fa-chevron-down"></i> Show Serial No.
                                    </button>
                                </div>
                            </div>
                        
                            <div class="row" id="serialNumberDiv${b_m}" style="display:none;margin-top:-1rem !important;">
                                <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-2 mb-1"></div>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-8 mb-1">
                                    <table id="serial_no_dynamic_table${b_m}" class="mb-0 serial_no_dynamic_table rtable form_dynamic_table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th class="form_lbl" style="width: 10%">#</th>
                                                <th class="form_lbl" style="width: 80%">Serial No.<b style="color: red; font-size:16px;">*</b></th>
                                                <th class="form_lbl" style="width: 10%"></th>
                                            </tr>
                                        <thead>
                                        <tbody></tbody>
                                    </table>
                                    <button type="button" name="batch_row[${b_m}][add_serial_no]" id="add_serial_no${b_m}" class="btn btn-success btn-sm" onclick="addSerialNumberFn(${b_m})"><i class="fa fa-plus" aria-hidden="true"></i>  Add Serial No.</button>
                                </div>
                                <div class="col-xl-4 col-lg-3 col-md-3 col-sm-3 col-2 mb-1"></div>
                            </div>
                        </td>
                        <td style="width:2%;position:relative;vertical-align: top;">
                            <button type="button" class="btn btn-light btn-sm remove-batch-tr" id="remove-batch-tr${b_m}" onclick="removeBatchRecordFn(this)" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;position: absolute; top: 2px; right: 0px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        </td>
                    </tr>`
                );

                if(is_batch_req == "Yes"){
                    $(".bs_batch_no_controls").show();
                }
                if(is_serial_req == "Yes"){
                    $(".bs_only_serial_controls").show();
                }
                if(is_expiry_req == "Yes"){
                    $(".bs_expiry_date_controls").show();
                }

                var default_option = `<option selected disabled value=""></option>`;
                $(`#Instance${b_m}`).empty().append(default_option);
                $(`#Instance${b_m}`).append(getClonedOption(item_id, store_id));
                
                $('#batch_no_dynamic_table > tbody > tr').each(function(index, tr) {
                    let instance_id = $(this).find('.item_instance').val();
                    $(`#Instance${b_m} option[value="${instance_id}"]`).remove(); 
                });

                $(`#Instance${b_m}`).append(default_option).select2({placeholder: "Select here"});

                $("#batch_title_for_serial_no").html("");

                renumberBatchNumberRows();
            }
        });

        function getClonedOption(item_id, store_id) {
            var $source = $("#bs_item_instance_default");
            
            if (!$source.length) {
                return null;
            }
            
            // Find all matching options by item_id and store_id
            var selector = `option[data-item-id="${item_id}"][data-store-id="${store_id}"]`;
            var $matchingOptions = $source.find(selector);
            
            if (!$matchingOptions.length) {
                return null;
            }
            
            // Filter options with expiry date
            var optionsWithExpiry = [];
            var optionsWithoutExpiry = [];
            
            $matchingOptions.each(function() {
                var $option = $(this);
                var expiryDate = $option.data('expiry-date');
                
                if (expiryDate && expiryDate !== '' && expiryDate !== null) {
                    optionsWithExpiry.push({
                        element: $option,
                        expiryDate: new Date(expiryDate),
                        expiryDateStr: expiryDate
                    });
                } else {
                    optionsWithoutExpiry.push($option);
                }
            });
            
            // Handle based on rules
            var $optionsToClone = $();
            
            if (optionsWithExpiry.length > 0) {
                // Find the oldest date
                var oldestDate = optionsWithExpiry.reduce(function(oldest, current) {
                    return current.expiryDate < oldest.expiryDate ? current : oldest;
                });
                
                // Find all options with the same oldest date
                var sameDateOptions = optionsWithExpiry.filter(function(option) {
                    return option.expiryDate.getTime() === oldestDate.expiryDate.getTime();
                });
                
                // Clone all options with the oldest date
                sameDateOptions.forEach(function(option) {
                    $optionsToClone = $optionsToClone.add(option.element.clone());
                });
            } 
            else if (optionsWithoutExpiry.length > 0) {
                // Show all options without expiry date
                optionsWithoutExpiry.forEach(function($option) {
                    $optionsToClone = $optionsToClone.add($option.clone());
                });
            }
            
            return $optionsToClone.length ? $optionsToClone : null;
        }

        function toggleSerialNumberFn(row_id){
            if ($(`#serialNumberDiv${row_id}`).is(':visible')) {
                $(`#serialNumberDiv${row_id}`).hide();
                $(`#toggleSerialNum${row_id}`).html('<i class="fa fa-chevron-down"></i> Show Serial No.');
            } else {
                $(`#serialNumberDiv${row_id}`).show();
                $(`#toggleSerialNum${row_id}`).html('<i class="fa fa-chevron-up"></i> Hide Serial No.');
            }
        }

        function addSerialNumberFn(row_id){
            var sn_last_row = $(`#serial_no_dynamic_table${row_id} tr:last`).find('td').eq(1).find('input').val();
            var current_index = row_id;
            var op_type = $("#bs_operation_type").val();
            var record_id = $("#bsHeaderId").val();
            var default_serial_no = $("#serialnumber_default");
            var serial_number = $(`#serialNumber${sn_last_row}`).val();
            var batch_qty = $(`#bactchQuantity${row_id}`).val();
            var batch_id = $(`#Instance${row_id}`).val();
            var total_sn = $(`#serial_no_dynamic_table${row_id} > tbody > tr`).length;

            if(serial_number !== undefined && serial_number === null){
                $(`#select2-serialNumber${sn_last_row}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Please fill a valid data on highlighted fields","Error");
            }
            else if(parseFloat(batch_qty) == parseFloat(total_sn)){
                toastrMessage('error',"The number of serial numbers cannot exceed the total quantity for this batch.","Error");
            }
            else if(isNaN(parseFloat(batch_qty)) || parseFloat(batch_qty) == 0){
                $(`#bactchQuantity${row_id}`).css("background",errorcolor);
                toastrMessage('error',"Quantity field is required","Error");
            }
            else{
                ++s_i;
                ++s_m;
                ++s_j;
                $(`#serial_no_dynamic_table${row_id} > tbody`).append(
                    `<tr class="border serial_no_tr serial_no_row${row_id}" id="sn_data_row${s_m}">
                        <td style="font-weight:bold;width:10%;text-align:center;">${s_j}</td>
                        <td style="display:none;"><input type="hidden" name="serial_row[${s_m}][serial_index_col]" id="serial_index_col${s_m}" class="serial_index_col form-control" readonly="true" style="font-weight:bold;" value="${s_m}"/></td>
                        <td style="display:none;"><input type="hidden" name="serial_row[${s_m}][parent_row_id]" id="parent_row_id${s_m}" class="parent_row_id form-control" readonly="true" style="font-weight:bold;" value="${row_id}"/></td>
                        <td style="width:80%">
                            <select id="serialNumber${s_m}" class="select2 form-control serialNumber" onchange="serialNumberFn(this)" name="serial_row[${s_m}][serialNumber]"></select>
                        </td>
                        <td style="width:10%;text-align:center;">
                            <input type="hidden" id="serial_uuid${s_m}" name="serial_row[${s_m}][serial_uuid]" class="form-control serial_uuid"/>
                            <input type="hidden" id="serial_db_id${s_m}" name="serial_row[${s_m}][serial_db_id]" class="form-control serial_db_id"/>
                            <button type="button" id="remove_serial_tr${s_m}" class="btn btn-light btn-sm remove_serial_tr" onclick="removeSerialNumberTrFn(${row_id},${s_m})" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                        </td>
                    </tr>`
                );

                var default_option = `<option selected disabled value=""></option>`;
                $(`#serialNumber${s_m}`).append(default_option).select2();

                if(parseInt(op_type) == 1){
                    $(`#serialNumber${s_m}`).append(default_serial_no.find(`option[data-batch-id="${batch_id}"][data-sold-flag="0"]`).clone());
                }
                else if(parseInt(op_type) == 2){
                    var batch_flag = [0, 1];
                    $(`#serialNumber${s_m}`).append(default_serial_no.find(`option[data-batch-id="${batch_id}"][data-sold-flag="${JSON.stringify(batch_flag)}"]`).clone());
                }

                $(`#serial_no_dynamic_table${row_id} > tbody > tr`).each(function(index, tr) {
                    let ser_id = $(this).find('.serialNumber').val();
                    $(`#serialNumber${s_m} option[value="${ser_id}"]`).remove(); 
                });
                $(`#serialNumber${s_m}`).append(default_option).select2({placeholder: "Select serial number here"});

                $(`#select2-serialNumber${s_m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberSerialNumberRows(row_id);
            }
        }

        function renumberSerialNumberRows(row_id){
            var current_index = $("#bs_current_index_value").val();
            $(`#serial_no_dynamic_table${row_id} > tbody > tr`).each(function(index,el) {
                $(this).children('td').first().text(index += 1);
            });
        }

        function serialNumberFn(ele){ 
            var row_id = $(ele).closest('tr').find('.serial_index_col').val();
            var batch_row_id = $(ele).closest('tr').find('.parent_row_id').val();
            var arr = [];
            var found = 0;
            $(`#serial_no_dynamic_table${batch_row_id} .serialNumber`).each(function() {
                let ser_id = $(this).val();
                if(arr.includes(ser_id)){
                    found++;
                }
                else{
                    arr.push(ser_id);
                }
            });

            if(found){
                $(`#serialNumber${row_id}`).val(null).select2({placeholder: "Select serial number here"});
                $(`#select2-serialNumber${row_id}-container`).parent().css('background-color',errorcolor);
                toastrMessage('error',"Duplicate serial number found","Error");
            }
            else{
                countBatchAndSerialQtyFn(batch_row_id);
                countTotalBatchAndSerialFn();
                $(`#select2-serialNumber${row_id}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
        }

        function checkSerialNumDuplicatesFn(ele){
            var row_id = $(ele).closest('tr').find('.serial_index_col').val();
            var parent_row_id = $(ele).closest('tr').find('.parent_row_id').val();
            checkSerialDuplicatesFn('serialNumber',row_id);
            countBatchAndSerialQtyFn(parent_row_id);
            countTotalBatchAndSerialFn();
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

        function removeSerialNumberTrFn(b_row,s_row){
            $(`#sn_data_row${s_row}`).remove();
            countBatchAndSerialQtyFn(b_row);
            renumberSerialNumberRows(b_row);
            countTotalBatchAndSerialFn();
        }

        function countBatchAndSerialQtyFn(row_id){
            var batch_qty = $(`#bactchQuantity${row_id}`).val();
            var total_sn = 0;
            $.each($(`#serial_no_dynamic_table${row_id}`).find('.serialNumber'), function() {
                if ($(this).val() != '') {
                    total_sn++;
                }
            });

            $(`#batch_serial_stat_btn${row_id}`).removeClass('btn-outline-warning');
            $(`#batch_serial_stat_btn${row_id}`).removeClass('btn-outline-success');

            if(parseFloat(batch_qty) == parseFloat(total_sn) && parseFloat(batch_qty) > 0){
                $(`#batch_serial_stat_btn${row_id}`).addClass('btn-outline-success');
            }
            else{
                $(`#batch_serial_stat_btn${row_id}`).addClass('btn-outline-warning');
            }
            $(`#batch_serial_stat_btn${row_id}`).text(`Qty.: ${batch_qty} | Serial Qty.: ${total_sn}`);
        }

        function countTotalBatchAndSerialFn(){
            var total_batch_qty = 0;
            var total_serial_qty = 0;
            var total_received_qty = $('#bs_item_qty').val();
            $.each($('#batch_no_dynamic_table').find('.bactchQuantity'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    total_batch_qty += parseFloat($(this).val());
                }
            });

            $.each($('.serial_no_tr').find('.serialNumber'), function() {
                if ($(this).val() != '') {
                    total_serial_qty++;
                }
            });

            $("#bs_footer_total_batch_qty").html(numformat(parseFloat(total_batch_qty).toFixed(0)));
            $("#bs_footer_total_serial_qty").html(numformat(parseFloat(total_serial_qty).toFixed(0)));
            $('.total_batch_qty_lbl').css("color","#5e5873");
            $('.total_serial_qty_lbl').css("color","#5e5873");

            if(parseFloat(total_received_qty) == parseFloat(total_batch_qty)){
                $('.total_batch_qty_lbl').css("color","#28c76f");
            }
            if(parseFloat(total_received_qty) == parseFloat(total_serial_qty)){
                $('.total_serial_qty_lbl').css("color","#28c76f");
            }
        }

        function renumberBatchNumberRows(){
            $('#batch_no_dynamic_table > tbody > tr').each(function(index,el) {
                $(this).children('td').first().html(`<span class="badge badge-center rounded-pill bg-secondary">${++index}</span>`);
            });
        }

        function bsManufactureDateFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            $(`#bsManufactureDate${row_id}`).css("background",'white');
            $(`#bs-manufacture-date-error${row_id}`).html("");
        }

        function instanceFn(ele){
            var row_id = $(ele).closest('tr').find('.batch_index_col').val();
            var instance_id = null;
            var arr = [];
            var found = 0;

            $('.item_instance').each(function(){ 
                var instance = $(this).val();
                if(arr.includes(instance)){
                    found++;
                }
                else{
                    arr.push(instance);
                }
            });

            if(found){
                var old_ins_id = $(`#old_instance_id${row_id}`).val();
                $(`#Instance${row_id}`).val(old_ins_id).select2();
                toastrMessage('error',"Item instance already exist in the list","Error");
            }
            else{
                $.ajax({
                    url: '/getBatchQuantity', 
                    type: 'POST',
                    data:{
                        instance_id: $(`#Instance${row_id}`).val() || 0,
                    },
                    beforeSend: function() {
                        blockPage(cardSection, 'Fetching instance data...');
                    },
                    success:async function(data) {
                        await getInstanceDataFn(data,row_id);
                        unblockPage(cardSection);
                    },
                    error: function () {
                        unblockPage(cardSection);
                    }
                });
                $(`#old_instance_id${row_id}`).val($(`#Instance${row_id}`).val());
                $(`#select2-Instance${row_id}-container`).parent().css('background-color','white');
                $(`#serial_no_dynamic_table${row_id} > tbody`).empty();
                countBatchAndSerialQtyFn(row_id);
                countTotalBatchAndSerialFn();
                $(`#bs-instance-error${row_id}`).html("");
            }
        }

        function getInstanceDataFn(data,row_id){
            $(`#quantity_on_hand${row_id}`).val(data.available_qty)
        }

        function fetchInstanceFn(row_id,qty){
            var instance_id = null;
            $.ajax({
                url: '/getBatchQuantity', 
                type: 'POST',
                data:{
                    instance_id: $(`#Instance${row_id}`).val() || 0,
                },
                success:function(data) {
                    $(`#quantity_on_hand${row_id}`).val(parseFloat(data.available_qty) + parseFloat(qty))
                },
            });
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
            countBatchAndSerialQtyFn(row_id);
            countTotalBatchAndSerialFn();
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
                text: 'Are you sure: Removing this batch will automatically remove its associated serial numbers',
                icon: confirmation_icon,
                showCloseButton: true,
                showCancelButton: true,      
                allowOutsideClick: false,
                confirmButtonText: 'Remove',
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
            var is_expiry_req = $(".is_expiry_date_req").text();
            var currentRow = $(`#bs_data_row${row_id}`);
            var nextRow = currentRow.next('tr');

            if (nextRow.length > 0 && is_expiry_req == "Yes") {
                toastrMessage('error',"You can't delete this record because it expires first. Please remove newer records first.","Error");
                return true;
            } else {
                $(`#bs_data_row${row_id}`).remove();
                $(`.serial_no_row${row_id}`).remove();
                renumberBatchNumberRows();
                countTotalBatchAndSerialFn();
                return false;
            }
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

                $("#bs_current_index_value").val(row_id);
            }
        }

        function checkQuantityVarianceFn(row_id){
            var issued_qty = $("#bs_item_qty").val();
            var qty_on_hand = $(`#quantity_on_hand${row_id}`).val();
            var batch_qty = $(`#bactchQuantity${row_id}`).val();
            var inserted_qty = 0;
            issued_qty = issued_qty == '' ? 0 : issued_qty;

            qty_on_hand = qty_on_hand == '' ? 0 : qty_on_hand;
            batch_qty = batch_qty == '' ? 0 : batch_qty;

            // $.each($('#batch_no_dynamic_table').find('.bactchQuantity'), function() {
            //     if ($(this).val() != '' && !isNaN($(this).val())) {
            //         inserted_qty += parseFloat($(this).val());
            //     }
            // });

            if(parseFloat(batch_qty) > parseFloat(qty_on_hand)){
                $(`#bactchQuantity${row_id}`).val("");
                $(`#bactchQuantity${row_id}`).css("background",errorcolor);
                toastrMessage('error',"Quantity not available","Error");
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