@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('DS-Store-Balance')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content">
                                <h3 class="card-title">Direct Stock Balance Report</h3>
                            </div>

                            <form id="storebalanceform">
                                @csrf  
                                <div class="card-datatable">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <section id="card-text-alignment">
                                            <div class="d-flex justify-content-between align-items-center cursor-pointer" data-toggle="collapse" data-target=".info-rep-parameter" aria-expanded="true">
                                                <h5 class="mb-0 mt-1 form_title parameter_header_info"></h5>
                                                <div class="mt-0 d-flex align-items-center header-tab">
                                                    <span class="text-uppercase font-weight-bold mr-50 toggle-text-label tab-text">Collapse</span>
                                                    <div class="collapse-icon">
                                                        <i class="fas text-secondary fa-minus-circle"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse show info-rep-parameter shadow-none pl-1 pr-1">
                                                <div class="row mt-1 fit-content">
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 mb-1">
                                                        <label class="form_lbl">Fiscal Year</label>
                                                        <select class="selectpicker form-control" id="fiscalyears" name="fiscalyears" data-live-search="true" data-style="btn btn-outline-secondary waves-effect">
                                                            @foreach ($fiscalyear as $fiscalyear)
                                                                <option value="{{ $fiscalyear->FiscalYear }}">{{ $fiscalyear->Monthrange }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="fiscalyear-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 mb-1">
                                                        <label class="form_lbl">From</label>
                                                        <input type="text" id="date" name="FromDate" class="form-control reg_form" placeholder="YYYY-MM-DD" onchange="dateVal()" readonly="true" />
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="date-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 mb-1">
                                                        <label class="form_lbl">To</label>
                                                        <input type="text" id="todate" name="ToDate" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="todateVal()" />
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="todate-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 mb-1" id="storediv">
                                                        <label class="form_lbl">Station</label>
                                                        <select class="selectpicker form-control" id="store" name="station[]" multiple="multiple" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Station ({0})"></select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="store-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 mb-1" id="itemgrp">
                                                        <label class="form_lbl">Item Group</label>
                                                        <select class="selectpicker form-control" id="itemgroup" name="itemGroup[]" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" onchange="clearitemgrp()" data-selected-text-format="count" data-count-selected-text="Item Group ({0})">
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="itemgroup-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 mb-1" id="itemdiv">
                                                        <label class="form_lbl">Item(s)</label>
                                                        <select class="selectpicker form-control" id="items" name="items[]" data-live-search="true" multiple="multiple" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" onchange="itemval()" data-selected-text-format="count" data-count-selected-text="Items ({0})"></select>
                                                        <span class="text-danger">
                                                            <strong class="errordatalabel" id="items-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                                                        <input type="hidden" class="form-control" name="fromhidden" id="fromhidden" readonly="true" value="" />
                                                        <input type="hidden" class="form-control" name="tohidden" id="tohidden" readonly="true" value="" />
                                                        <button id="reportbutton" type="button" class="btn btn-info btn-sm form_btn"><i class="fa fa-eye" aria-hidden="true"></i><span> View</span></button>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-left">
                                                        <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                            <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-caret-down"></i><span> Print & Export</span>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <li><a id="printtable" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-print"></i>  Print</a></li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li><a id="downloatoexcel" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-file-excel"></i> To Excel</a></li>
                                                                <li><a id="downloadtopdf" class="dropdown-item" href="javascript:void(0);"><i class="fa-solid fa-file-pdf"></i> To Pdf</a></li>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <hr class="my-30">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div id="balance_tbl_div" class="table-responsive fit-content" style="width:99%; margin-left:0.5%;display:none;">
                                                <table id="balancetable" class="report-dt table-bordered table-hover dt-responsive mb-0" style="width: 100%;">
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm"></tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display:none;">
                                            <table id="company_info_tbl" class="table table-sm" style="width:100%;border: none !important;">
                                                <tbody>
                                                    <tr>
                                                        <td style="width:8%;border: none !important;"><b>Tel:</b></td>
                                                        <td style="width:42%;border: none !important;">{{$compInfo->Phone}}, {{$compInfo->OfficePhone}}</td>
                                                        <td style="width:10%;border: none !important;"><b>Website:</b></td>
                                                        <td style="width:40%;border: none !important;">{{$compInfo->Website}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: none !important;"><b>Email:</b></td>
                                                        <td style="border: none !important;">{{$compInfo->Email}}</td>
                                                        <td style="border: none !important;"><b>Address:</b></td>
                                                        <td style="border: none !important;">{{$compInfo->Address}}</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #000000;">
                                                        <td style="border: none !important;"><b>TIN:</b></td>
                                                        <td style="border: none !important;">{{$compInfo->TIN}}</td>
                                                        <td style="border: none !important;"><b>VAT No:</b></td>
                                                        <td style="border: none !important;">{{$compInfo->VATReg}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <input type="hidden" id="info_company_name" name="info_company_name" value="{{$compInfo->Name}}"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endcan

    <script type="text/javascript">
        var fy = $('#fiscalyears').val();
        var table = null;
        var globalIndex = -1;


        $(function () {
            cardSection = $('#page-block');
        });

        $(function () {
            storeSection = $('#storediv');
        });

        $(function () {
            itemSection = $('#itemdiv');
        });

        $(function () {
            groupSection = $('#itemgrp');
        });

        $(document).ready(function() {
            resetBalanceFormFn();
            fetchSelectedStoreFn(fy);
        });

        function resetBalanceFormFn(){
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('#fiscalyears').selectpicker('refresh');
            $('#store').selectpicker('refresh');
            $('#items').selectpicker('refresh');
            $('#itemgroup').selectpicker('refresh');
            $('#date').val(`${fy}-07-08`);
            $('#fromhidden').val(`${fy}-07-08`);
            $('#balance_tbl_div').hide();
        }

        function fetchSelectedStoreFn(fy){
            var registerForm = $("#storebalanceform");
            var formData = registerForm.serialize();
            var seloption = "";
            $.ajax({
                url:'getDSStoreBySelectedFyear/'+fy,
                type:'POST',
                data:formData,
                beforeSend: function () { 
                    cardSection.block({
                        message:
                        '<div class="d-flex justify-content-center align-items-center"><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                success:function(data){
                    $.each(data.query, function(key, value) {
                        seloption += `<option value='${value.StoreId}'>${value.StoreName}</option>`;
                    });
                    $("#store").empty().append(seloption).val(null).selectpicker('refresh');  
                },
            });
        }

        function fetchGroupFn(str_id,f_year){
            var registerForm = $("#storebalanceform");
            var formData = registerForm.serialize();
            var item_options = "";
            var item_grp = "";
            $.ajax({
                url:'getDsItemsBySelectedStore/'+str_id+'/'+f_year,
                type:'POST',
                data:formData,
                beforeSend: function () { 
                    groupSection.block({
                        message:
                        '<div class="d-flex justify-content-center align-items-center"><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    groupSection.block({
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
                success:function(data){
                    $.each(data.item_group, function(key, value) {
                        item_grp += `<option value='${value.itemGroup}'>${value.itemGroup}</option>`;
                    });
                    $("#itemgroup").empty().append(item_grp).val(null).selectpicker('refresh');
                },
            });
        }

        function fetchItemsFn(str_id,f_year){
            var registerForm = $("#storebalanceform");
            var formData = registerForm.serialize();
            var item_grp = $('#itemgroup').val();
            var item_options = "";
            $.ajax({
                url:'getDsItemsBySelectedStore/'+str_id+'/'+f_year,
                type:'POST',
                data:formData,
                beforeSend: function () { 
                    itemSection.block({
                        message:
                        '<div class="d-flex justify-content-center align-items-center"><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    itemSection.block({
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
                success:function(data){
                    $.each(data.query, function(key, value) {
                        if(value.ItemGroup == "Local"){
                            item_options += `<option data-group='${value.ItemGroup}' value='${value.ItemId}'>${value.Code}, ${value.ItemName}, ${value.SKUNumber}</option>`;
                        }
                        else if(value.ItemGroup == "Imported"){
                            item_options += `<option data-group='${value.ItemGroup}' value='${value.ItemId}'>${value.Code}, ${value.ItemName}, ${value.SKUNumber}</option>`;
                        }
                        else{
                            item_options += `<option data-group='${value.ItemGroup}' value='${value.ItemId}'>${value.Code}, ${value.ItemName}, ${value.SKUNumber}</option>`;
                        }
                    });
                    $("#items").empty().append(item_options).val(null).selectpicker('refresh');  
                },
            });
        }

        function resetFiscalYearFn(f_year){
            $('.errordatalabel').html("");
            $('#date').val(`${f_year}-07-08`);
            $('#todate').val("");
            $("#items").empty().selectpicker('refresh');  
            $("#store").empty().selectpicker('refresh');
            $('#itemgroup').empty().selectpicker('refresh');

            $('#fiscalyear-error').html("");
        }

        function resetAfterRenderTrigFn(){
            $("#exportdiv").hide();
            $("#balance_tbl_div").hide();
        }

        $('#store').change(function() {
            var str_id = $(this).val();
            var f_year = $('#fiscalyears').val();
            fetchGroupFn(str_id,f_year);
            resetAfterRenderTrigFn()
            $("#store-error").html("");
        });

        $('#itemgroup').change(function() {
            var str_id = $('#store').val();
            var f_year = $('#fiscalyears').val();
            fetchItemsFn(str_id,f_year);
            resetAfterRenderTrigFn()
            $("#itemgroup-error").html("");
        });

        $('#fiscalyears').change(function() {
            var f_year = $(this).val();
            resetFiscalYearFn(f_year);
            fetchSelectedStoreFn(f_year);
            resetAfterRenderTrigFn()
        });

        $('#reportbutton').click(function() {
            var registerForm = $("#storebalanceform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/fetchDSBalanceRep',
                type: 'POST',
                data: formData,
                success: function(data) {
                    if(data.errors) {
                        if (data.errors.fiscalyears) {
                            $('#fiscalyear-error').html(data.errors.fiscalyears[0]);
                        }
                        if (data.errors.FromDate) {
                            $('#date-error').html(data.errors.FromDate[0]);
                        }
                        if (data.errors.ToDate) {
                            $('#todate-error').html(data.errors.ToDate[0]);
                        }
                        if (data.errors.station) {
                            $('#store-error').html(data.errors.station[0]);
                        }
                        if (data.errors.itemGroup) {
                            $('#itemgroup-error').html(data.errors.itemGroup[0]);
                        }
                        if (data.errors.items) {
                            $('#items-error').html(data.errors.items[0]);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    else if(data.success){
                        fetchBalanceDataFn();
                    }
                }
            });
        });

        function fetchBalanceDataFn(){
            var from_date = $('#date').val();
            var to_date = $('#todate').val();
            var str_id = $('#store').val();
            var f_year = $('#fiscalyears').val();
            var items = $('#items').val();
            var itemsgrp = $('#itemgroup').val();
            var itemnames = null;
            $('#balance_tbl_div').hide();

            table = $("#balancetable").DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: true,
                fixedHeader: false,
                searchHighlight: true,
                responsive:true,
                ordering: false,
                paging: false,
                deferRender: true,
                header: false,
                "order": [[2, "asc"]],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                dom: "<'row'<'col-sm-3 col-md-2 col-4 pr-0 mr-0'f><'col-sm-4 col-md-2 col-4 mt-1 pr-0 mr-0'><'col-sm-4 col-md-2 col-4 mt-1'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-0 col-md-0 col-0'l><'col-sm-12 col-md-12 col-12 d-flex justify-content-center'i><'col-sm-0 col-md-0 col-0 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/dsbalances/' + from_date + '/' + to_date + '/' + str_id,
                    type: 'POST',
                    data:{
                        itemnames: $('#items').val(),
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
                    complete: function () { 
                        $('#balancetable > thead').hide();
                        $("#balance_tbl_div").show();
                        $("#exportdiv").show();
                        setFocus('#balancetable');
                    },
                },
                columns: [{
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        width:"3%",
                    },
                    {
                        data: "ItemCode",
                        name: "ItemCode",
                        width:"10%",
                    },
                    {
                        data: "ItemName",
                        name: "ItemName",
                        width:"17%",
                    },
                        {
                        data: "SKUNumber",
                        name: "SKUNumber",
                        width:"10%",
                    },
                    {
                        data: "Category",
                        name: "Category",
                        width:"14%",
                    },
                        {
                        data: "UOM",
                        name: "UOM",
                        width:"8%",
                    },
                    {
                        data: "ItemGroup",
                        name: "ItemGroup",
                        width:"8%",
                    },
                    {
                        data: "StoreName",
                        name: "StoreName",
                        width:"15%",
                    },
                    {
                        data: "AvailableQuantity",
                        name: "AvailableQuantity",
                        width:"15%",
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                ],
                columnDefs: [
                    {
                        targets: [0,1,2,3,4,5,6,7,8],
                        createdCell: function (td, cellData, rowData, row, col){
                        $(td).css('border', '0.1px solid black');
                        $(td).css('color', 'black');
                    }
                }],
                fixedHeader: {
                    header: false,
                    headerOffset: $('.header-navbar').outerHeight(),
                    footer: true
                },
                rowGroup: {
                    startRender: function (rows,group){
                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        var header_group = `
                            <tr>
                                <th colspan="9" class="merged-header">${group}</th>
                            </tr>
                            <tr>
                                <th style="width:3%;">#</th>
                                <th style="width:10%;">Item Code</th>
                                <th style="width:17%;">Item Name</th>
                                <th style="width:10%;" title="Barcode Number">Barcode No.</th>
                                <th style="width:14%;">Category</th>
                                <th style="width:8%;" title="Unit of Measurement">UOM</th>
                                <th style="width:8%;">Item Group</th>
                                <th style="width:15%;">Station</th>
                                <th style="width:15%;">Available Qty.</th>
                            </tr>`;

                        return $(header_group)
                    },
                    endRender: function ( rows, group ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var totalquantity = rows
                            .data()
                            .pluck('AvailableQuantity')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0); 

                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        var total_merged_row = `<tr><td colspan="9" class="report-total-footer">Total of ${group}: ${numformat(parseFloat(totalquantity).toFixed(2))}</td></tr>`;
                        return $(total_merged_row);     
                    },  
                    dataSrc: 'ItemName'
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['ItemName'];
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
                        }
                    });

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
            });
        }

        $('#balancetable tbody').on('click', 'tr', function () {
            $('#balancetable tbody tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $("#downloatoexcel").click(function () {
            var fiscalyear = "";
            var station = "";
            var itemgrp = "";
            $("#fiscalyears :selected").each(function() {
                fiscalyear += this.text+"";
            });

            $("#store :selected").each(function() {
                station += this.text+"";
            });

            $("#itemgroup :selected").each(function() {
                itemgrp += this.text+", ";
            });
            
            station = station.replace(/,\s*$/, ""); // Remove trailing comma
            itemgrp = itemgrp.replace(/,\s*$/, ""); // Remove trailing comma

            let fromdate = $('#date').val();
            let todate = $('#todate').val();

            var table = document.getElementById("balancetable");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("DS_Balance_Report");

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow(["Direct Stock Balance Report"]);
            titleRow.font = { bold: true, size: 16, color: { argb: "000000" } };
            titleRow.alignment = { horizontal: "center", vertical: "middle" };
            

            worksheet.mergeCells(1, 1, 1, 9); // 🔹 Merge across all columns
            // **🔹 Leave an empty row below the title**
            worksheet.addRow([]);
            worksheet.mergeCells(2, 1, 2, 3); 
            worksheet.mergeCells(2, 4, 2, 5); 
            worksheet.mergeCells(2, 6, 2, 7); 
            worksheet.mergeCells(2, 8, 2, 9); 

            worksheet.addRow([]);
            worksheet.mergeCells(3, 1, 3, 3); 
            worksheet.mergeCells(3, 4, 3, 5);
            worksheet.mergeCells(3, 6, 3, 7);  
            worksheet.mergeCells(3, 8, 3, 9); 

            const fiscal_year = worksheet.getCell(2, 3);
            const fiscal_year_value = worksheet.getCell(2, 5);
            const date_range = worksheet.getCell(3, 3);
            const date_range_value = worksheet.getCell(3, 5);

            const stations = worksheet.getCell(2, 7);
            const station_value = worksheet.getCell(2, 9);
            const itemgrp_title = worksheet.getCell(3, 7);
            const itemgrp_value = worksheet.getCell(3, 9);

            fiscal_year.value = "Fiscal Year";
            fiscal_year.alignment = { horizontal: "right", vertical: "middle" };

            fiscal_year_value.value = fiscalyear;
            fiscal_year_value.alignment = { horizontal: "left", vertical: "middle" };
            fiscal_year_value.font = { bold: true};

            date_range.value = "Date Range";
            date_range.alignment = { horizontal: "right", vertical: "middle" };
            date_range_value.value = `${fromdate} to ${todate}`;
            date_range_value.alignment = { horizontal: "left", vertical: "middle" };
            date_range_value.font = { bold: true};

            stations.value = "Station";
            stations.alignment = { horizontal: "right", vertical: "middle" };
            station_value.value = station;
            station_value.alignment = { horizontal: "left", vertical: "middle" };
            station_value.font = { bold: true};

            itemgrp_title.value = "Item Group";
            itemgrp_title.alignment = { horizontal: "right", vertical: "middle" };
            itemgrp_value.value = itemgrp;
            itemgrp_value.alignment = { horizontal: "left", vertical: "middle" };
            itemgrp_value.font = { bold: true};
            
            worksheet.addRow([]);
            worksheet.mergeCells(4, 1, 4, 9); 

            function processTableRows(tableSection, startRow, isHeader = false) {
                let excelRowIndex = startRow;
                let rowSpanMap = {}; 

                $(tableSection).find("tr").each(function () {
                    let rowData = [];
                    let colIndex = 1;

                    $(this).find("th, td").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan") || 1);
                        let rowspan = parseInt($(this).attr("rowspan") || 1);

                        // Ensure column is not occupied by previous row span
                        while (rowSpanMap[`${excelRowIndex}-${colIndex}`]) {
                            colIndex++;
                        }

                        rowData[colIndex - 1] = text;
                        let estimatedWidth = text.length * 1.2; // 1.2 units per character (better scaling)
                        estimatedWidth = Math.max(estimatedWidth, 5); // Minimum width for any column

                        if (colIndex === 1) {
                            maxColumnWidths[colIndex] = 5;
                        }
                        else{
                            maxColumnWidths[colIndex] = Math.max(maxColumnWidths[colIndex] || 5, estimatedWidth);
                            maxColumnWidths[colIndex] = Math.min(maxColumnWidths[colIndex], 50); // **Limit max width to 30**
                        }

                        if (colspan > 1 || rowspan > 1) {
                            mergeCells.push({
                                start: { row: excelRowIndex, col: colIndex },
                                end: { row: excelRowIndex + rowspan - 1, col: colIndex + colspan - 1 }
                            });

                            for (let r = 0; r < rowspan; r++) {
                                for (let c = 0; c < colspan; c++) {
                                    rowSpanMap[`${excelRowIndex + r}-${colIndex + c}`] = true;
                                }
                            }
                        }

                        colIndex += colspan;
                    });

                    let row = worksheet.addRow(rowData);

                    row.eachCell((cell, cellIndex) => {
                        // Track current position in the original HTML cells
                        let currentColIndex = 0;
                        let foundOriginalCell = null;
                        let originalCells = $(this).find("th, td");
                        
                        // Find which original cell this Excel column belongs to
                        for (let i = 0; i < originalCells.length; i++) {
                            let originalCell = $(originalCells[i]);
                            let colspan = parseInt(originalCell.attr("colspan") || 1);
                            
                            // Check if the current Excel column falls within this original cell's colspan range
                            if (cellIndex > currentColIndex && cellIndex <= currentColIndex + colspan) {
                                foundOriginalCell = originalCell;
                                break;
                            }
                            currentColIndex += colspan;
                        }
                        
                        if (foundOriginalCell) {
                            let isTh = foundOriginalCell.is("th");
                            let isTd = foundOriginalCell.is("td");
                            let colspan = parseInt(foundOriginalCell.attr("colspan") || 1);
                            
                            // Make <th> cells bold
                            if (isTh) {
                                cell.font = { bold: true, size: 12, color: { argb: "000000" } };
                                cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "F3F4F6"}};
                            }
                            
                            // Apply header styling if this is a header row
                            if (isHeader) {
                                cell.font = { bold: true, size: 12, color: { argb: "FFFFFF" } };
                                cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "00cfe8" } };
                                if (colspan === 1) {
                                    cell.alignment = { horizontal: "center", vertical: "middle" };
                                }
                            }
                            
                            // If no alignment was set, default to center
                            if (!cell.alignment) {
                                cell.alignment = { horizontal: "center", vertical: "middle" };
                            }
                            // Handle colspan alignment to the right
                            if (colspan > 1 && isTd) {
                                cell.style = {
                                    alignment: { horizontal: "right", vertical: "middle" },
                                    font: { bold: true, size: 12 },
                                    fill: { type: "pattern", pattern: "solid", fgColor: { argb: "F9FAFB" }}
                                };
                            }
                        } 
                        else {
                            // Default alignment if no original cell found
                            cell.alignment = { horizontal: "center", vertical: "middle" };
                        }
                    });
                    excelRowIndex++;
                });

                return excelRowIndex;
            }

            let lastRow = processTableRows($(table).find("tbody"), 5);
            processTableRows($(table).find("tfoot"), lastRow, false, true); // Handle footer

            mergeCells.forEach((cell) => {
                worksheet.mergeCells(
                    cell.start.row,
                    cell.start.col,
                    cell.end.row,
                    cell.end.col
                );
            });

            worksheet.eachRow((row) => {
                row.eachCell((cell) => {
                    cell.border = {
                        top: { style: "thin" },
                        left: { style: "thin" },
                        bottom: { style: "thin" },
                        right: { style: "thin" },
                    };
                    //cell.alignment = { horizontal: "center", vertical: "middle" };
                });
            });

            worksheet.columns.forEach((column, i) => {
                column.width = maxColumnWidths[i + 1] || 5; // **Set a default min width of 10**
            });

            workbook.xlsx.writeBuffer().then((data) => {
                var blob = new Blob([data], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                saveAs(blob,`DS_Balance_Report_from_${fromdate}_to_${todate}.xlsx`);
            });
        });

        $("#downloadtopdf").click(function () {
            try {
                // Get filter values
                var fiscalyear = "";
                var station = "";
                var itemgrp = "";
                $("#fiscalyears :selected").each(function() {
                    fiscalyear += this.text+"";
                });

                $("#store :selected").each(function() {
                    station += this.text+"";
                });

                $("#itemgroup :selected").each(function() {
                    itemgrp += this.text+", ";
                });
                
                station = station.replace(/,\s*$/, ""); // Remove trailing comma
                itemgrp = itemgrp.replace(/,\s*$/, ""); // Remove trailing comma

                let fromdate = $('#date').val();
                let todate = $('#todate').val();

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                const company_name = $("#info_company_name").val();
                doc.autoTable({
                    startY: 2,
                    theme: 'plain',
                    showHead: 'firstPage',
                    styles: { lineWidth: 0, fontSize: 12 },
                    columnStyles: { 0: { cellWidth: 50 }, 1: { cellWidth: 50 }, 2: { cellWidth: 50 } },
                    body: [
                        [{ 
                            content: company_name, 
                            colSpan: 3, 
                            styles: { halign: 'center', fontStyle: 'bold', fontSize: 20 } 
                        }]
                    ]
                });

                doc.autoTable({ 
                    html: '#company_info_tbl',
                    startY: doc.lastAutoTable.finalY + 0,      // Y position to start the table
                    margin: { top: 1, left: 1, right: 1, bottom: 1 },
                    styles: { fontSize: 8, cellPadding: 0.6, halign: 'left', valign: 'middle' },
                    bodyStyles: { fillColor: [255, 255, 255] },
                    columnStyles: { 
                        0: { cellWidth: 13 }, 
                        1: { cellWidth: 77,fontStyle: 'bold' }, 
                        2: { cellWidth: 13 }, 
                        3: { cellWidth: 77,fontStyle: 'bold' }, 
                    }, // specific columns
                    theme: 'plain',  // 'striped', 'grid', 'plain'
                    showHead: 'firstPage', // 'never', 'firstPage', 'everyPage'
                    tableWidth: 'auto',     // 'auto', 'wrap', numeric value
                    pageBreak: 'auto',      // 'auto', 'avoid', 'always'
                });

                const companyTableEndY = doc.lastAutoTable.finalY + 1;
                const pageWidth = doc.internal.pageSize.getWidth();
                doc.line(0, companyTableEndY, pageWidth , companyTableEndY);


                const totalPagesExp = "{total_pages_count_string}";
                
                let bodyData = [];
                let colspanMap = []; // Store colspan information with column positions
                let cellStyles = []; // Store cell styling information

                // Process body data and build colspan map and styles
                $("#balancetable tbody tr").each(function (rowIndex) {
                    let rowData = [];
                    let rowColspanInfo = [];
                    let rowCellStyles = [];
                    let currentCol = 0;
                    
                    $(this).find("td, th").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan")) || 1;
                        let isTh = $(this).is("th");
                        
                        rowData.push(text);
                        
                        // Store colspan information with actual column positions
                        rowColspanInfo.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            text: text,
                            isTh: isTh
                        });
                        
                        // Store styling information
                        rowCellStyles.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            isTh: isTh,
                            text: text
                        });
                        
                        // Add empty cells for colspan
                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }
                        
                        currentCol += colspan;
                    });
            
                    if (rowData.length > 0) {
                        bodyData.push(rowData);
                        colspanMap.push(rowColspanInfo);
                        cellStyles.push(rowCellStyles);
                    }
                });

                // Check if there's actual data
                if (bodyData.length === 0) {
                    toastrMessage('error', "No data available for the selected criteria", "Error");
                    return;
                }

                // Add title
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text("Direct Stock Balance Report", doc.internal.pageSize.width / 2, 35, { align: "center" });

                // Add metadata in two columns
                doc.setFontSize(8);
                let yPosition = 40;

                // Left column
                if (fiscalyear) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Fiscal Year: ", 14, yPosition);
                    doc.setFont("helvetica", "bold");
                    doc.text(fiscalyear, 14 + doc.getTextWidth("Fiscal Year: "), yPosition);
                }
                yPosition += 5;

                doc.setFont("helvetica", "normal");
                doc.text("Date Range: ", 14, yPosition);
                doc.setFont("helvetica", "bold");
                doc.text(`${fromdate} to ${todate}`, 14 + doc.getTextWidth("Date Range: "), yPosition);

                // Right column
                let rightX = doc.internal.pageSize.width - 70;
                let rightY = 40;

                if (station) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Station: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(station, rightX + doc.getTextWidth("Station: "), rightY);
                    rightY += 5;
                }

                if (itemgrp) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Item Group: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(itemgrp, rightX + doc.getTextWidth("Item Group: "), rightY);
                }

                // Set yPosition for table after both columns
                let finalYPosition = Math.max(yPosition, rightY) + 5;

                // Generate table with colspan handling and styling
                doc.autoTable({
                    body: bodyData,
                    theme: "grid",
                    startY: yPosition + 2,
                    styles: {
                        fontSize: 8,
                        cellPadding: 1.5,
                        overflow: "linebreak",
                        valign: "middle",
                        halign: "center",
                        lineWidth: 0.1,
                        lineColor: [0, 0, 0], // Black border
                        textColor: [0, 0, 0], // Black font
                        fillColor: [255, 255, 255], // White background
                    },
                    margin: { top: 1, left: 1, right: 1, bottom: 8},
                    didParseCell: function (data) {
                        // Handle colspan and styling
                        if (data.row.section === 'body' && cellStyles[data.row.index]) {
                            for (let i = 0; i < cellStyles[data.row.index].length; i++) {
                                let cellInfo = cellStyles[data.row.index][i];
                                
                                // Check if this column is the start of a merged cell
                                if (data.column.index === cellInfo.startCol) {
                                    // Apply colspan if greater than 1
                                    if (cellInfo.colspan > 1) {
                                        data.cell.colSpan = cellInfo.colspan;
                                    }
                                    
                                    // Apply styling based on cell type
                                    if (cellInfo.isTh) {
                                        if(cellInfo.colspan > 1){
                                            data.cell.styles.fontSize = 10;
                                        }
                                        else{
                                            data.cell.styles.fontSize = 8;
                                        }
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'center';
                                        data.cell.styles.fillColor = [243, 244, 246];
                                    }
                                    
                                    // Right align for cells with colspan > 1
                                    if (cellInfo.colspan > 1 && !cellInfo.isTh) {
                                        data.cell.styles.fontSize = 9;
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'right';
                                        data.cell.styles.fillColor = [249, 250, 251];
                                    }                                    
                                    break;
                                }
                            }
                        }
                    },

                    didDrawPage: function (data) {
                        const pageCount = doc.internal.getNumberOfPages();
                        const pageWidth = doc.internal.pageSize.getWidth();
                        const pageHeight = doc.internal.pageSize.getHeight();

                        doc.setFontSize(8);
                        doc.setFont("helvetica", "normal");
                        doc.text(`Page ${data.pageNumber} of ${totalPagesExp}`, pageWidth + 25, pageHeight - 3, {
                            align: "right"
                        });

                        doc.text(`Exported on: ${getDateTimeTZ('Africa/Addis_Ababa')}`, 5, pageHeight - 3);

                        // Thin separator line (just above the bottom margin)
                        doc.setDrawColor(0); // Black
                        doc.setLineWidth(0.1); // Thin line
                        doc.line(1, pageHeight - 7, pageWidth - 1, pageHeight - 7); // From (x1, y1) to (x2, y2)
                    }
                });

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                // Save PDF
                const fileName = `DS_Balance_Report_${fromdate}_to_${todate}.pdf`;
                doc.save(fileName);
                
            } catch (error) {
                console.error("PDF Generation Error:", error);
                toastrMessage('error', "Error generating PDF: " + error.message, "Error");
            }
        });

        $("#printtable").click(function () {
            try {
                // Get filter values
                var fiscalyear = "";
                var station = "";
                var itemgrp = "";
                $("#fiscalyears :selected").each(function() {
                    fiscalyear += this.text+"";
                });

                $("#store :selected").each(function() {
                    station += this.text+"";
                });

                $("#itemgroup :selected").each(function() {
                    itemgrp += this.text+", ";
                });
                
                station = station.replace(/,\s*$/, ""); // Remove trailing comma
                itemgrp = itemgrp.replace(/,\s*$/, ""); // Remove trailing comma

                let fromdate = $('#date').val();
                let todate = $('#todate').val();

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                const company_name = $("#info_company_name").val();
                doc.autoTable({
                    startY: 2,
                    theme: 'plain',
                    showHead: 'firstPage',
                    styles: { lineWidth: 0, fontSize: 12 },
                    columnStyles: { 0: { cellWidth: 50 }, 1: { cellWidth: 50 }, 2: { cellWidth: 50 } },
                    body: [
                        [{ 
                            content: company_name, 
                            colSpan: 3, 
                            styles: { halign: 'center', fontStyle: 'bold', fontSize: 20 } 
                        }]
                    ]
                });

                doc.autoTable({ 
                    html: '#company_info_tbl',
                    startY: doc.lastAutoTable.finalY + 0,      // Y position to start the table
                    margin: { top: 1, left: 1, right: 1, bottom: 1 },
                    styles: { fontSize: 8, cellPadding: 0.6, halign: 'left', valign: 'middle' },
                    bodyStyles: { fillColor: [255, 255, 255] },
                    columnStyles: { 
                        0: { cellWidth: 13 }, 
                        1: { cellWidth: 77,fontStyle: 'bold' }, 
                        2: { cellWidth: 13 }, 
                        3: { cellWidth: 77,fontStyle: 'bold' }, 
                    }, // specific columns
                    theme: 'plain',  // 'striped', 'grid', 'plain'
                    showHead: 'firstPage', // 'never', 'firstPage', 'everyPage'
                    tableWidth: 'auto',     // 'auto', 'wrap', numeric value
                    pageBreak: 'auto',      // 'auto', 'avoid', 'always'
                });

                const companyTableEndY = doc.lastAutoTable.finalY + 1;
                const pageWidth = doc.internal.pageSize.getWidth();
                doc.line(0, companyTableEndY, pageWidth , companyTableEndY);


                const totalPagesExp = "{total_pages_count_string}";
                
                let bodyData = [];
                let colspanMap = []; // Store colspan information with column positions
                let cellStyles = []; // Store cell styling information

                // Process body data and build colspan map and styles
                $("#balancetable tbody tr").each(function (rowIndex) {
                    let rowData = [];
                    let rowColspanInfo = [];
                    let rowCellStyles = [];
                    let currentCol = 0;
                    
                    $(this).find("td, th").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan")) || 1;
                        let isTh = $(this).is("th");
                        
                        rowData.push(text);
                        
                        // Store colspan information with actual column positions
                        rowColspanInfo.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            text: text,
                            isTh: isTh
                        });
                        
                        // Store styling information
                        rowCellStyles.push({
                            startCol: currentCol,
                            endCol: currentCol + colspan - 1,
                            colspan: colspan,
                            isTh: isTh,
                            text: text
                        });
                        
                        // Add empty cells for colspan
                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }
                        
                        currentCol += colspan;
                    });
            
                    if (rowData.length > 0) {
                        bodyData.push(rowData);
                        colspanMap.push(rowColspanInfo);
                        cellStyles.push(rowCellStyles);
                    }
                });

                // Check if there's actual data
                if (bodyData.length === 0) {
                    toastrMessage('error', "No data available for the selected criteria", "Error");
                    return;
                }

                // Add title
                doc.setFontSize(14);
                doc.setFont("helvetica", "bold");
                doc.text("Direct Stock Balance Report", doc.internal.pageSize.width / 2, 35, { align: "center" });

                // Add metadata in two columns
                doc.setFontSize(8);
                let yPosition = 40;

                // Left column
                if (fiscalyear) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Fiscal Year: ", 14, yPosition);
                    doc.setFont("helvetica", "bold");
                    doc.text(fiscalyear, 14 + doc.getTextWidth("Fiscal Year: "), yPosition);
                }
                yPosition += 5;

                doc.setFont("helvetica", "normal");
                doc.text("Date Range: ", 14, yPosition);
                doc.setFont("helvetica", "bold");
                doc.text(`${fromdate} to ${todate}`, 14 + doc.getTextWidth("Date Range: "), yPosition);

                // Right column
                let rightX = doc.internal.pageSize.width - 70;
                let rightY = 40;

                if (station) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Station: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(station, rightX + doc.getTextWidth("Station: "), rightY);
                    rightY += 5;
                }

                if (itemgrp) {
                    doc.setFont("helvetica", "normal");
                    doc.text("Item Group: ", rightX, rightY);
                    doc.setFont("helvetica", "bold");
                    doc.text(itemgrp, rightX + doc.getTextWidth("Item Group: "), rightY);
                }

                // Set yPosition for table after both columns
                let finalYPosition = Math.max(yPosition, rightY) + 5;

                // Generate table with colspan handling and styling
                doc.autoTable({
                    body: bodyData,
                    theme: "grid",
                    startY: yPosition + 2,
                    styles: {
                        fontSize: 8,
                        cellPadding: 1.5,
                        overflow: "linebreak",
                        valign: "middle",
                        halign: "center",
                        lineWidth: 0.1,
                        lineColor: [0, 0, 0], // Black border
                        textColor: [0, 0, 0], // Black font
                        fillColor: [255, 255, 255], // White background
                    },
                    margin: { top: 1, left: 1, right: 1, bottom: 8},
                    didParseCell: function (data) {
                        // Handle colspan and styling
                        if (data.row.section === 'body' && cellStyles[data.row.index]) {
                            for (let i = 0; i < cellStyles[data.row.index].length; i++) {
                                let cellInfo = cellStyles[data.row.index][i];
                                
                                // Check if this column is the start of a merged cell
                                if (data.column.index === cellInfo.startCol) {
                                    // Apply colspan if greater than 1
                                    if (cellInfo.colspan > 1) {
                                        data.cell.colSpan = cellInfo.colspan;
                                    }
                                    
                                    // Apply styling based on cell type
                                    if (cellInfo.isTh) {
                                        if(cellInfo.colspan > 1){
                                            data.cell.styles.fontSize = 10;
                                        }
                                        else{
                                            data.cell.styles.fontSize = 8;
                                        }
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'center';
                                        data.cell.styles.fillColor = [243, 244, 246];
                                    }
                                    
                                    // Right align for cells with colspan > 1
                                    if (cellInfo.colspan > 1 && !cellInfo.isTh) {
                                        data.cell.styles.fontSize = 9;
                                        data.cell.styles.fontStyle = 'bold';
                                        data.cell.styles.halign = 'right';
                                        data.cell.styles.fillColor = [249, 250, 251];
                                    }                                    
                                    break;
                                }
                            }
                        }
                    },

                    didDrawPage: function (data) {
                        const pageCount = doc.internal.getNumberOfPages();
                        const pageWidth = doc.internal.pageSize.getWidth();
                        const pageHeight = doc.internal.pageSize.getHeight();

                        doc.setFontSize(8);
                        doc.setFont("helvetica", "normal");
                        doc.text(`Page ${data.pageNumber} of ${totalPagesExp}`, pageWidth + 25, pageHeight - 3, {
                            align: "right"
                        });

                        doc.text(`Printed on: ${getDateTimeTZ('Africa/Addis_Ababa')}`, 5, pageHeight - 3);

                        // Thin separator line (just above the bottom margin)
                        doc.setDrawColor(0); // Black
                        doc.setLineWidth(0.1); // Thin line
                        doc.line(1, pageHeight - 7, pageWidth - 1, pageHeight - 7); // From (x1, y1) to (x2, y2)
                    }
                });

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                const blob = doc.output("blob");
                const blobUrl = URL.createObjectURL(blob);

                // Open blank popup first
                const printWindow = window.open('about:blank', '_blank', 'width=1400,height=800,top=100,left=100');

                if (printWindow) {
                    // Create iframe inside the blank popup
                    printWindow.document.write(`<iframe style="width:100%;height:100%;" src="${blobUrl}"></iframe>`);
                    printWindow.document.close();
                    
                    // Auto-print when iframe loads
                    printWindow.onload = function() {
                        setTimeout(function() {
                            const iframe = printWindow.document.querySelector('iframe');
                            if (iframe) {
                                iframe.onload = function() {
                                    setTimeout(function() {
                                        iframe.contentWindow.print();
                                    }, 500);
                                };
                            }
                        }, 500);
                    };
                    
                    // Clean up
                    setTimeout(function() {
                        URL.revokeObjectURL(blobUrl);
                    }, 10000);
                } else {
                    toastrMessage('error', "Please allow popups!", "Error");
                }
                
            } catch (error) {
                console.error("PDF Generation Error:", error);
                toastrMessage('error', "Error generating PDF: " + error.message, "Error");
            }
        });

        function dateVal(){
            $("#date-error").html("");
        }

        function todateVal(){
            $("#todate-error").html("");
        } 

        function itemval() {
            $("#items-error").html("");
        }

        $(document).on('show.bs.collapse hide.bs.collapse', '.collapse', function (e) {
            e.stopPropagation();
            const collapse = $(this);
            const container = collapse.closest('.card, .modal-content, .row');
            const infoTarget = container.find('.parameter_header_info');
            const collapseId = collapse.attr('id');
            const trigger = $(`[data-target="#${collapseId}"], [data-bs-target="#${collapseId}"]`);

            const isOpening = e.type === 'show';

            $('.toggle-text-label').html(isOpening ? 'Collapse' : 'Expand');
            $('.collapse-icon').html(isOpening ? '<i class="fas text-secondary fa-minus-circle"></i>' : '<i class="fas text-secondary fa-plus-circle"></i>');

            if (isOpening) {
                const originalHeader = "";
                infoTarget.html(originalHeader);
            } 
            else {
                // Section is COLLAPSING: Show the data summary

                var fiscalyear = "";
                var station = "";
                var item_group = "";
                
                $("#fiscalyears :selected").each(function() {
                    fiscalyear += this.text + "";
                });

                $("#store :selected").each(function() {
                    station += this.text + "";
                });

                $("#itemgroup :selected").each(function() {
                    item_group += this.text + ", ";
                });
                
                station = station.replace(/,\s*$/, ""); // Remove trailing comma
                item_group = item_group.replace(/,\s*$/, ""); // Remove trailing comma

                let fromdate = $('#date').val();
                let todate = $('#todate').val();

                const report_parameter = `
                    Fiscal Year: <b>${fiscalyear}</b>,
                    Date Range: <b>${fromdate} to ${todate}</b>,
                    Station: <b>${station}</b>,
                    Item Group: <b>${item_group}</b>`;

                infoTarget.html(report_parameter);
            }
        });

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

        function getDateTimeTZ(timezone) {
            const now = new Date();
            const parts = new Intl.DateTimeFormat('en-US', {
                timeZone: timezone,
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            }).formatToParts(now);

            const map = {};
            parts.forEach(p => map[p.type] = p.value);

            return `${map.year}-${map.month}-${map.day} @ ${map.hour}:${map.minute}:${map.second} ${map.dayPeriod}`;
        }
    </script>
@endsection
  