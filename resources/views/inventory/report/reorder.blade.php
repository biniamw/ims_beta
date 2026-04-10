@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Reorder-View')
        <div class="app-content content">
            <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Reorder Report</h3>
                            <div class="btn-group dropdown" id="exportdiv">
                                <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span> Print / Export </span><i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button id="printtable" type="button" class="dropdown-item" ><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                    <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i> To Excel</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div class="table">
                                    <table id="reordertable" class="table" style="width: 100%">
                                        <thead>
                                            <tr style="display: none;" class="compinfotr">
                                                <th colspan="7">
                                                    <table id="headertables" class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;width:100%;"></table>
                                                </th>
                                            </tr>
                                            <tr style="display: none;" class="compinfotr">
                                                <td colspan="7">
                                                    <h3><p style="text-align:center; margin:top:-10px;color:#00cfe8;font-family: 'Segoe UI', Verdana, Helvetica, Sans-Serif;"><b>Reorder Report</b></p></h3>
                                                </td>
                                            </tr>
                                            <tr id="paymenttr" style="display: none;">
                                                <td colspan="7" style="color:black; border-bottom-color: white;background-color:white;"></td>
                                            </tr>
                                            <tr>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Code</th>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Item Name</th>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">SKU Number</th>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Category</th>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">UOM</th>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Reorder Point</th>
                                                <th style="width:5%;color:white; border: 0.1px solid white;background-color:#00cfe8;">Available Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot><tr></tr></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>
        </div>
    @endcan

    <script type="text/javascript">

    $(document).ready( function () 
    {
        var table=$('#reordertable').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            paging: false,
            "order": [[ 1, "asc" ]],
            "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here" },
            "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/reorderrep',
                type: 'DELETE',
                dataType: "json",
                },
            columns: [
            {
                data: "ItemCode",
                name: "ItemCode",
                width:"5%",
            },
            {
                data: "ItemName",
                name: "ItemName",
                width:"25%",
            },
            {
                data: "SKUNumber",
                name: "SKUNumber",
                width:"10%",
            },
            {
                data: "Category",
                name: "Category",
                width:"5%",
            },
            {
                data: "UOM",
                name: "UOM",
                width:"5%",
            },
            {
                data: "ReorderPoint",
                name: "ReorderPoint",
                width:"10%",
                render: $.fn.dataTable.render.number(',', '.',0, '')
            },
            {
                data: "AvailableQuantity",
                name: "AvailableQuantity",
                width:"10%",
                render: $.fn.dataTable.render.number(',', '.',2, '')
            },  
            ],
            columnDefs: [  
            {
                "width": "100%",
                targets: [0,1,2,3,4,5,6],
                createdCell: function (td, cellData, rowData, row, col){
                $(td).css('border', '0.1px solid black');
                $(td).css('color', 'black');
            } 
        }],
            fixedHeader: {
                header: true,
                headerOffset: $('.header-navbar').outerHeight(),
                footer: false
            },
        });
         table.on( 'draw', function () {
                var body = $( table.table().body());
                body.unhighlight();
                body.highlight( table.search() );
            });
    });            

    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }      

    $('#printtable').click(function(){
        var tr='<tr>'+
            '<td colspan="6" class="headerTitles" style="text-align:center;font-size:1.7rem;"><b>{{$compInfo->Name}}</b></td>'+
            '<td rowspan="4" style="float:right;width:150px;height:120px;"></td>'+
            '</tr>'+
            '<tr><td style="width:15%"><b>Tel:</b></td>'+
            '<td style="width:35%" colspan="2">{{$compInfo->Phone}},{{$compInfo->OfficePhone}}</td>'+
            '<td style="width:15%"><b>Website:</b></td>'+
            '<td style="width:35%" colspan="2">{{$compInfo->Website}}</td>'+
            '</tr>'+
            '<tr><td><b>Email:</b></td>'+
            '<td colspan="2">{{$compInfo->Email}}</td>'+
            '<td><b>Address:</b></td>'+
            '<td colspan="2">{{$compInfo->Address}}</td>'+
            '</tr>'+
            '<tr><td style="width:15%"><b>TIN No.:</b></td>'+
            '<td colspan="2">{{$compInfo->TIN}}</td>'+
            '<td><b>VAT No:</b></td>'+
            '<td colspan="2">{{$compInfo->VATReg}}</td>'+
            '</tr>';
        $("#headertables").append(tr);
        $('#daterangetr').show();
        $('#titletr').show();
        $('#paymenttr').show();
        $('.compinfotr').show();

        let tbl = document.getElementById('reordertable');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("reordertable");
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
            
        $('.compinfotr').hide();
        $('#daterangetr').hide();
        $('#titletr').hide();
        $('#paymenttr').hide();
        $("#headertables").empty();
    });

    $("#downloatoexcel").click(function(){
        $("#headertables").empty();
        var datefrom=$('#date').val();
        var dateto=$('#todate').val();
        let tbl = document.getElementById('reordertable');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#reordertable").table2excel({
        name: "Worksheet Name",
        filename: "ReorderReport", //do not include extension
        fileext: ".xls" // file extension
        });
    });
    </script>
@endsection
