    
    
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
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 d-flex justify-content-end">
                                <label style="font-size: 16px;" id="batch_received_qty_lbl"></label>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row">
                                    <div id="batch_no_div">
                                        <table id="batch_no_dynamic_table" class="fit-content" style="width:100%;">
                                            <tbody></tbody>
                                        </table>
                                        <button type="button" name="add_batch_no" id="add_batch_no" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                    </div>
                                    <div id="serial_no_div">
                                        <table id="serial_no_dynamic_table" class="mb-0 rtable form_dynamic_table fit-content" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th class="form_lbl">#</th>
                                                    <th class="form_lbl">Item Name</th>
                                                    <th class="form_lbl">Item Name</th>
                                                    <th class="form_lbl">Item Name</th>
                                                    <th class="form_lbl"></th>
                                                </tr>
                                            <thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <input type="hidden" class="form-control" name="receiving_item_qty" id="receiving_item_qty" readonly="true">
                            <input type="hidden" class="form-control" name="receiving_item_id" id="receiving_item_id" readonly="true">
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
                                $('#batch_no_div').attr('class','col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12');
                                $('#serial_no_div').attr('class','col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12');
                            }
                            else{
                                $('#batch_no_div').attr('class','col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12');
                                $('#serial_no_div').attr('class','col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12');
                            }
                            
                        });
                    }
                });

                $(".batch_serial_collapse").collapse('show');
                $('#manageItemModal').modal('show');
            }
        }

        $("#add_batch_no").click(function() {
            ++b_i;
            ++b_m;
            ++b_j;
            $("#batch_no_dynamic_table > tbody").append(
                `<tr>
                    <td style="width:3%;text-align:left;vertical-align: top;">
                        <span class="badge badge-center rounded-pill bg-secondary">${b_j}</span>
                    </td>
                    <td style="display:none;"><input type="hidden" name="batch_row[${b_m}][batch_index_col]" id="batch_index_col${b_m}" class="batch_index_col form-control" readonly="true" style="font-weight:bold;" value="${b_m}"/></td>
                    <td style="font-weight:bold;text-align:center;width:94%">
                        <div class="row">

                        </div>
                    </td>
                    <td style="width:3%;text-align:right;vertical-align: top;">
                        <button type="button" class="btn btn-light btn-sm remove-batch-tr" id="remove-batch-tr${b_m}" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                </tr>`
            );
        });





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