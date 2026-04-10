@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('ERCA-Sales-Report-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <h3 class="card-title">ERCA Sales Report</h3>
                            </div>
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <form id="profitandlossform">
                                        @csrf
                                        <div style="width:98%; margin-left:1%; margin-top:2%;">
                                            <div class="row">
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2" style="display: none">
                                                    <label strong style="font-size: 14px;">Fiscal Year</label>
                                                    <select class="selectpicker form-control" id="fiscalyears" name="fiscalyears" data-live-search="true" data-style="btn btn-outline-secondary waves-effect">
                                                        {{-- @foreach ($fiscalyear as $fiscalyear)
                                                            <option value="{{ $fiscalyear->FiscalYear }}">{{ $fiscalyear->Monthrange }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="fiscalyear-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                    <label strong style="font-size: 14px;color">Select Date Range</label>
                                                    <div id="reportrange"
                                                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                                        <i class="fa fa-calendar"></i>&nbsp;
                                                        <span></span> <i class="fa fa-caret-down"></i>
                                                    </div>

                                                    <span class="text-danger">
                                                        <strong id="date-error"></strong>
                                                    </span>
                                                </div>
                                                
                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="storediv">
                                                    <label strong style="font-size: 14px;">Point of Sales</label>
                                                    <select class="selectpicker form-control" id="store" name="store[]" multiple data-live-search="true" data-style="btn btn-outline-secondary waves-effect" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Point of Sales ({0})" onchange="storeVal()">
                                                        <option disabled value=""></option>
                                                        @foreach ($store as $store)
                                                            <option value="{{ $store->StoreId }}">{{ $store->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="store-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <div class="row" style="color:white;">
                                                        .
                                                    </div>
                                                    <div class="row">
                                                        <input type="hidden" placeholder="" class="form-control" name="fromhidden" id="fromhidden" readonly="true" value=""/>
                                                        <input type="hidden" placeholder="" class="form-control" name="tohidden" id="tohidden" readonly="true" value=""/>
                                                        <button id="reportbutton" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>    View</button>
                                                        <div style="width: 0.5%;"></div>
                                                        <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                            <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span>Print/Export</span><i class="fa fa-caret-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <button id="printtable" type="button" class="dropdown-item" ><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                                                <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i> To Excel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-datatable">
                                <div style="width:100%;">
                                    <div class="row" id="printable" style="display:none;">
                                    <div class="col-xl-11 col-md-6 col-sm-12 mb-2">
                                    </div>
                                    <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                        <button type="button" class="btn btn-gradient-info btn-sm" style="color: white;display:none;" onclick="printDiv('printable')" title="Print"><i data-feather='printer'></i></button>
                                    </div>
                                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <div style="width: 100%;">
                                            <div class="table-responsive">
                                                <div style="width:99%; margin-left:0.5%;">
                                                    <table id="itemsaleshistory" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;color:black;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:2%;color:white; border: 0.1px solid white;background-color:#00cfe8;">#</th>
                                                                <th style="width:9%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Customer Name</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">TIN</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Code</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Name</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">UOM</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Quantity</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Unit Price</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Before Tax</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">VAT</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Doc/ FS No.</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Invoice/ Ref No.</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Date</th>
                                                                <th style="width:7%;color:white; border: 0.1px solid white;background-color:#00cfe8;">MRC</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                            <tr style="background-color: #f2f3f4">
                                                                <td colspan="8" style="text-align: right;border-color:black;">
                                                                    <label strong style="font-size: 16px;font-weight: bold;color:black;">Total</label>
                                                                </td>
                                                                <td style="border-color:black;">
                                                                    <label id="totalbeforetaxlbl" strong style="font-size: 16px;font-weight:bold;color:black;"></label>
                                                                </td>
                                                                <td style="border-color:black;">
                                                                    <label id="totaltaxlbl" strong style="font-size: 16px;font-weight: bold;color:black;"></label>
                                                                </td>
                                                                <td colspan="4" style="border-color:black;"></td>
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
                    </div>
                </div>
            </section>
        </div>
    @endcan
@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function() {
        $('#store').selectpicker('refresh');
    });
    
    $(function () {
        cardSection = $('#page-block');
    });

    $(function () {
        storeSection = $('#storediv');
    });

    $(function () {
        itemSection = $('#itemdiv');
    });

    var fr = '';
    var tr = '';
    $(function() {
        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var from = start.format('YYYY-MM-D');
            var to = end.format('YYYY-MM-D');
            fr = from;
            tr = to;
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')],
                    'Last 6 Month': [moment().subtract(179, 'days'), moment()],
            }
        }, cb);
        cb(start, end);
    });


    $('#reportbutton').click(function() {
        var storeval = $('#store').val();
        var selectedstore="";
        var selecteditemgrp="";
        var fiscalyearselected="";
        var itemnames="";
        var paymenttypevals="";
        var rankbytotal="";
        var sortbytotal="";
        if(storeval==''||storeval=='0'||storeval==null){
            if(storeval==''||storeval=='0'||storeval==null)
            {
                $('#store-error').html('Point of sales is required');
            }
            toastrMessage("error", "Please fill all required fields","Error");
        }
        else{
            $('#store-error').html("");
            $('#date-error').html("");
            var registerForm = $("#profitandlossform");
            var formData = registerForm.serialize();
            $("#store :selected").each(function() {
                selectedstore+=this.text+" , ";
            });
            $('#daterange').html('<b>'+fr+'</b> to <b>'+tr+'</b>');
            $('#selectedstorelbl').html('<b>'+selectedstore+'</b>');
            var table = $("#itemsaleshistory").DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: true,
                fixedHeader: true,
                searchHighlight: true,
                responsive:true,
                    "pagingType": "simple",
                    language: {
                        search: '',
                        searchPlaceholder: "Search here"
                    },
                    // scrollY:'55vh',
                    // scrollX: true,
                    // scrollCollapse: true,
                    "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/custdata/' + fr + '/' + tr + '/' + storeval,
                        type: 'POST',
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
                    buttons: true,
                    ordering: false,
                    paging: false,
                    columns: [
                        {
                            data:'DT_RowIndex',
                            width: "2%",
                        },
                        {
                            data: "CustomerName",
                            name: "CustomerName",
                            width:"9%",
                        },    
                        {
                            data: "TinNumber",
                            name: "TinNumber",
                            width:"7%",
                            "render": function ( data, type, row, meta ) {
                                return '<a>'+'&nbsp;'+data+'</a>';
                            }     
                        },
                        {
                            data: "ItemID",
                            name: "ItemID",
                            width:"7%",
                        },
                        {
                            data: "Description",
                            name: "Description",
                            width:"7%",
                        },
                        {
                            data: "uom_name",
                            name: "uom_name",
                            width:"7%",
                        },
                        {
                            data: "Quantity",
                            name: "Quantity",
                            width:"7%",
                            render: $.fn.dataTable.render.number(',', '.',2, '')
                        },
                        {
                            data: "UnitPrice",
                            name: "UnitPrice",
                            width:"7%",
                            render: $.fn.dataTable.render.number(',', '.',2, '')
                        },
                        {
                            data: "BeforeTaxPrice",
                            name: "BeforeTaxPrice",
                            width:"7%",
                            render: $.fn.dataTable.render.number(',', '.',2, '')
                        },
                        {
                            data: "TaxAmount",
                            name: "TaxAmount",
                            width:"7%",
                            render: $.fn.dataTable.render.number(',', '.',2, '')
                        },
                        {
                            data: "VoucherNumber",
                            name: "VoucherNumber",
                            width:"7%",
                        },
                        {
                            data: "InvoiceNumber",
                            name: "InvoiceNumber",
                            width:"7%",
                        },
                        {
                            data: "CreatedDate",
                            name: "CreatedDate",
                            width:"7%",
                        },
                        {
                            data: "CustomerMRC",
                            name: "CustomerMRC",
                            width:"7%",
                        },  
                    ],
                    fixedHeader: {
                        header: true,
                        headerOffset: $('.header-navbar').outerHeight(),
                        footer: true
                    },
                    columnDefs: [
                        {
                            width: '2%', targets: 0 ,
                            targets: [0,1,2,3,4,5,6,7,8,9,10,11,12,13],
                            createdCell: function (td, cellData, rowData, row, col){
                                $(td).css('border','0.1px solid black');
                                $(td).css('color','black');
                            }
                        },
                    ],
                    footerCallback: function (row, data, start, end, display) {
                        var api = this.api();
                        var intVal = function (i) {
                            return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                        };

                        // Total over all pages
                        var totaltax = api
                            .column(9)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        var totalbeftax = api
                            .column(8)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                        $("#totalbeforetaxlbl").html(numformat(totalbeftax.toFixed(2)));
                        $("#totaltaxlbl").html(numformat(totaltax.toFixed(2)));
                    },
                });
                $("#printable").show();  
                $('#exportdiv').show();
            }
        });

    $('#fiscalyears').change(function() {
        var fy=$('#fiscalyears').val();
        var nextfy=parseFloat(fy)+1;
        var startdate=fy +"-07-08";
        var enddate=nextfy +"-07-07";
        var sd=new Date(startdate);
        var ed=new Date(enddate);

        $("#date").flatpickr({
            minDate: sd,
            maxDate: ed,
        });

        $("#todate").flatpickr({
            minDate: sd,
            maxDate: ed,
        });
        $("#store").empty(); 
        $('#items').selectpicker('refresh');  
        $('#store').selectpicker('refresh');  
        var registerForm = $("#profitandlossform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getSalesStore/'+fy,
            type:'DELETE',
            data:formData,
            beforeSend: function () { 
            storeSection.block({
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
            
            success:function(data)
            {
                storeSection.block({
                    message:
                        '',
                        timeout: 1,
                        css: {
                        backgroundColor: '',
                        color: '',
                        border: ''
                        }, 
                }); 

                if(data.query)
                {
                    var len=data['query'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var storeid=data['query'][i].StoreId;
                        var storename=data['query'][i].StoreName;
                        var option = "<option value='"+storeid+"'>"+storename+"</option>";
                        $("#store").append(option); 
                        $('#store').selectpicker('refresh');  
                    }
                }   
            },
        });

        $('#date').val(startdate);
        $('#todate').val("");
    });

    $("#downloatoexcel1").click(function(){
        $("#headertables").empty();
        var datefrom=$('#date').val();
        var dateto=$('#todate').val();
        let tbl = document.getElementById('itemsaleshistory');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#itemsaleshistory").table2excel({
            name: "Worksheet Name",
            filename: "SalesDataCollection", //do not include extension
            fileext: ".xlx" //// file extension
        });
    });

    $(document).on('click', '#downloatoexcel', function() {
        // Create workbook and worksheet
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('sales_erca');

        // Get table data
        const headers = [];
        const rows = [];
        const footers = [];
        const footerRows = [];

        // Get headers from table
        $('#itemsaleshistory thead th').each(function() {
            headers.push($(this).text());
        });

        // Get data rows from table
        $('#itemsaleshistory tbody tr').each(function() {
            const row = [];
            $(this).find('td').each(function() {
                row.push($(this).text());
            });
            rows.push(row);
        });

        // Get footer rows from table footer
        $('#itemsaleshistory tfoot tr').each(function() {
            const cells = $(this).find('td');
            footerRows.push({ 
                text: cells.eq(0).text().trim(),      
                figure1: cells.eq(1).text().trim(),    
                figure2: cells.eq(2).text().trim(),    
                lastMergedText: cells.eq(3).text(), 
                style: {
                    bgColor: cells.eq(0).css('background-color'),
                    bold: cells.eq(0).css('font-weight') === '700'
                }
            });
        });

        // Add title row (merged across 14 columns)
        const titleRow = worksheet.addRow(['ERCA Sales Report']);
        
        // Merge the first 14 cells of the title row
        worksheet.mergeCells(`A1:N1`);
        
        // Style the title
        titleRow.font = { 
            bold: true, 
            size: 16,
            color: { argb: '00000000' } // Blue color
        };
        titleRow.alignment = { 
            vertical: 'middle', 
            horizontal: 'center' 
        };
        titleRow.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFFFFFFF' } //
        };
        titleRow.height = 30;

        // Add headers to worksheet (now at row 3)
        const headerRow = worksheet.addRow(headers);

        // Add data rows to worksheet
        rows.forEach(row => {
            worksheet.addRow(row);
        });

        footerRows.forEach(footer => {
            const rowData = ['', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        
            rowData[0] = footer.text;           
            rowData[8] = footer.figure1;        
            rowData[9] = footer.figure2;       
            
            const footerRow = worksheet.addRow(rowData);
            
            worksheet.mergeCells(`A${footerRow.number}:H${footerRow.number}`); 
            worksheet.mergeCells(`K${footerRow.number}:N${footerRow.number}`);

            // Make ALL cells in the row bold with size 13
            for (let i = 1; i <= 14; i++) {
                const cell = footerRow.getCell(i);
                if (cell.value) {
                    cell.font = { bold: true, size: 12 };
                }
            }
            
            const firstCell = footerRow.getCell(1);
            firstCell.alignment = { horizontal: 'right' };
            firstCell.font = { bold: true, size: 13 };

            // Set the value for last merged cell
            if (footer.lastMergedText) {
                const lastCell = footerRow.getCell(11); // K column
                lastCell.value = footer.lastMergedText;
                lastCell.alignment = { horizontal: 'center' };
            }
        });

        // Style the header row
        headerRow.font = { bold: true };
        headerRow.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: { argb: 'FFE0E0E0' } // Light gray
        };
        headerRow.alignment = { 
            vertical: 'middle', 
            horizontal: 'left' 
        };

        // Add borders to all cells with data
        worksheet.eachRow({ includeEmpty: false }, function(row, rowNumber) {
            row.eachCell({ includeEmpty: false }, function(cell) {
                cell.border = {
                    top: { style: 'thin' },
                    left: { style: 'thin' },
                    bottom: { style: 'thin' },
                    right: { style: 'thin' }
                };
            });
        });

        // SMART AUTO-FIT WITH CUSTOM LIMITS PER COLUMN
        worksheet.columns.forEach((column, index) => {
            let maxLength = 0;
            column.eachCell({ includeEmpty: true }, function(cell) {
                if (cell.value) {
                    const length = cell.value.toString().length;
                    maxLength = Math.max(maxLength, length);
                }
            });
            
            // Set different max widths based on column
            if (index === 0) { // Column A (merged A-H)
                column.width = 6;
            }
            else if (index === 1) {
                column.width = 40; 
            }
            else if (index >= 2 && index <= 3) { 
                column.width = 15;
            }
            else if (index === 4) { 
                column.width = 35;
            }
            else if (index === 5) { 
                column.width = 25; 
            } 
            else if (index > 5){
                column.width = 15;
            }
        });

        // Generate and download Excel file
        workbook.xlsx.writeBuffer().then(function(buffer) {
            const blob = new Blob([buffer], { type: 'application/octet-stream' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'sales_data.xlsx';
            link.click();
        });
    });

    $('#printtable').click(function(){
        var tr='<tr>'+
                '<td colspan="8" class="headerTitles" style="text-align:center;font-size:1.7rem;height:12px;"><b>{{$compInfo->Name}}</b></td>'+
            '</tr>';
            $("#headertables").append(tr);
            $('#daterangetr').show();
            $('#titletr').show();
            $('.paymenttr').show();
            $('#compinfotr').show();

        let tbl = document.getElementById('itemsaleshistory');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("itemsaleshistory");
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'table th, table td {' +
            'border:1px solid #000;' +
            'padding:0.5em;' +
            '}' +
            '</style>';
            htmlToPrint += divToPrint.outerHTML;
            newWin= window.open("");
            newWin.document.write(divToPrint.outerHTML);
            newWin.print();
            newWin.close();
            
        $('#compinfotr').hide();
        $('#daterangetr').hide();
        $('#titletr').hide();
        $('.paymenttr').hide();
        $("#headertables").empty();
    });
  
    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }

    function dateVal() {
        $('#date-error').html("");
    }

    function storeVal() {
        $('#store-error').html("");
    }

</script>
@endsection