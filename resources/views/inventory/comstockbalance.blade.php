@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Commodity-StockBalance-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="row" style="width:19%;">
                                <div style="width: 1%;"></div>
                                <h3 class="card-title">Commodity Stock Balance</h3>
                                
                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i class="fas fa-sync-alt"></i></button>
                            </div>
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="owner-tab" data-toggle="tab" href="#ownertab" aria-controls="ownertab" role="tab" aria-selected="true" onclick="refreshtbl()">Owner</a>                                
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="customer-tab" data-toggle="tab" href="#customertab" aria-controls="customertab" role="tab" aria-selected="false" onclick="refreshtbl()">Customers</a>
                                </li>
                            </ul>
                            <div style="text-align: right;"></div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active" id="ownertab" aria-labelledby="ownertab" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div>
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:32%;">Commodity</th>
                                                        <th style="width:30%;">UOM</th>
                                                        <th style="width:31%;">Available Balance</th>
                                                        <th style="width:4%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="customertab" aria-labelledby="customertab" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div>
                                            <table id="customersdatatable" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:15%;">Customer Code</th>
                                                        <th style="width:17%;">Customer Name</th>
                                                        <th style="width:15%;">Customer TIN</th>
                                                        <th style="width:15%;">Commodity</th>
                                                        <th style="width:15%;">UOM</th>
                                                        <th style="width:16%;">Available Balance</th>
                                                        <th style="width:4%;">Action</th>
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
        </section>
    </div>
    @endcan

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Commodity Stock Balance Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title" id="commoditycustitle"></span>
                                                        <div id="statustitles"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <table style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Commodity Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 25%;"><label style="font-size: 14px;">Commodity</label></td>
                                                                            <td style="width: 75%;"><label id="origininfolbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;"></label></td>
                                                                            <td><label id="uominfolbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-6">
                                                                    <table id="customerinfotbl" class="customerinfotbl" style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Customer Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 25%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                            <td style="width: 75%"><label id="infocustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                            <td><label id="infocustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                            <td><label id="infocustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                            <td><label id="infocustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                            <td><label id="infocustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
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
                            
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table id="comstockbalancetbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                        <thead>         
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2" style="width:7%">Store</th>
                                                <th rowspan="2" style="width:7%">Floor Map</th>
                                                <th rowspan="2" style="width:8%">Type</th>
                                                <th rowspan="2" style="width:7%">Grade</th>
                                                <th rowspan="2" style="width:8%">Process Type</th>
                                                <th rowspan="2" style="width:8%">Crop Year</th>
                                                <th rowspan="2" style="width:8%">UOM/Bag</th>
                                                <th colspan="4" style="width:28%;text-align:center;" title="Available quantity on hand">Quantity on Hand</th>
                                                <th rowspan="2" style="width:8%">Allocated Amount (by KG)</th>
                                                <th rowspan="2" style="width:8%">Pending Dispatch (by KG)</th>
                                            </tr>
                                            <tr>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: center;" colspan="13">-</th>
                                            </tr>
                                            <tr style="background-color: #cccccc;color:#000000;font-size:16px;">
                                                <th colspan="8" style="text-align: right;">Total</th>
                                                <th id="totalbagnumber" style="text-align: left"></th>
                                                <th id="totalbalanceinfo" style="text-align: left"></th>
                                                <th id="totalbalancetoninfo" style="text-align: left"></th>
                                                <th id="totalbalanceferesulainfo" style="text-align: left"></th>
                                                <th id="totalshipments" style="text-align: left"></th>
                                                <th id="totalpendingdispatch" style="text-align: left"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="recInfoId" id="recInfoId" readonly="true" value=""/> 
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <!--Start Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="prdinformationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="ProductionInformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:98%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title" id="detailinfomodaltitle"></h4>
                        <div style="text-align: right" id="statusdisplay"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoprd" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title" id="productioncomm"></span>
                                                        
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoprd">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <table style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Commodity Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 25%;"><label style="font-size: 14px;">Commodity</label></td>
                                                                            <td style="width: 75%;"><label id="prdorigininfolbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;"></label></td>
                                                                            <td><label id="prduominfolbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-6">
                                                                    <table id="customerinfotbl" class="customerinfotbl" style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Customer Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 25%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                            <td style="width: 75%"><label id="prdinfocustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                            <td><label id="prdinfocustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                            <td><label id="prdinfocustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                            <td><label id="prdinfocustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                            <td><label id="prdinfocustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                    </table>
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
                            
                            <div class="row detailscls" id="productiondiv" style="display: none;">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table id="prdcomstockbalancetbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                        <thead>         
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2" style="width:10%">Document No.</th>
                                                <th rowspan="2" style="width:10%">Store</th>
                                                <th rowspan="2" style="width:9%">Commodity Type</th>
                                                <th rowspan="2" style="width:9%">Grade</th>
                                                <th rowspan="2" style="width:9%">Process Type</th>
                                                <th rowspan="2" style="width:9%">Crop Year</th>
                                                <th rowspan="2" style="width:9%">UOM/Bag</th>
                                                <th colspan="4" style="width:32%;text-align:center;" title="Amount">Amount</th>
                                                <th rowspan="2"></th>
                                                <th rowspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: center;" colspan="14">-</th>
                                            </tr>
                                            <tr style="background-color: #cccccc;color:#000000;font-size:16px;">
                                                <th colspan="8" style="text-align: right;">Total</th>
                                                <th id="prdtotalbagnumber" style="text-align: left"></th>
                                                <th id="prdtotalbalanceinfo" style="text-align: left"></th>
                                                <th id="prdtotalbalancetoninfo" style="text-align: left"></th>
                                                <th id="prdtotalbalanceferesulainfo" style="text-align: left"></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row detailscls" id="dispatchdiv" style="display: none;">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table id="dispatchdetailtbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                        <thead>         
                                            <tr>
                                                <th rowspan="2" style="width:3%;">#</th>
                                                <th rowspan="2" style="width:7%">Document No.</th>
                                                <th rowspan="2" style="width:5%">Store</th>
                                                <th rowspan="2" style="width:5%">Commodity Type</th>
                                                <th rowspan="2" style="width:5%">Grade</th>
                                                <th rowspan="2" style="width:5%">Process Type</th>
                                                <th rowspan="2" style="width:5%">Crop Year</th>
                                                <th rowspan="2" style="width:5%">UOM/Bag</th>
                                                <th colspan="4" style="width:20%;text-align:center;" title="Requested Amount">Requested Amount</th>
                                                <th colspan="4" style="width:20%;text-align:center;" title="Dispatched Amount">Dispatched Amount</th>
                                                <th colspan="4" style="width:20%;text-align:center;" title="Remaining Amount">Remaining Amount</th>
                                            </tr>
                                            <tr>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                                <th>By Bag</th>
                                                <th>By KG</th>
                                                <th>By TON</th>
                                                <th>By Feresula</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table table-sm"></tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: center;" colspan="20">-</th>
                                            </tr>
                                            <tr style="background-color: #cccccc;color:#000000;font-size:16px;">
                                                <th colspan="8" style="text-align: right;">Total</th>
                                                <th id="reqtotalbag" style="text-align: left"></th>
                                                <th id="reqtotalkg" style="text-align: left"></th>
                                                <th id="reqtotalton" style="text-align: left"></th>
                                                <th id="reqtotalferesula" style="text-align: left"></th>
                                                <th id="distotalbag" style="text-align: left"></th>
                                                <th id="distotalkg" style="text-align: left"></th>
                                                <th id="distotalton" style="text-align: left"></th>
                                                <th id="distotalferesula" style="text-align: left"></th>
                                                <th id="remtotalbag" style="text-align: left"></th>
                                                <th id="remtotalkg" style="text-align: left"></th>
                                                <th id="remtotalton" style="text-align: left"></th>
                                                <th id="remtotalferesula" style="text-align: left"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="recPrdInfoId" id="recPrdInfoId" readonly="true" value=""/> 
                        <button id="closebuttonprd" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
    <!--End Information Modal -->

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var j=0;
        var i=0;
        var m=0;

        $(document).ready( function () { 
            var ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 1, "desc" ]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: { search: '', searchPlaceholder: "Search here"},
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/combalancelist',
                    type: 'DELETE',
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
                columns: [
                    { data: 'wid', name: 'wid', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'Origin', name: 'Origin',width:"32%"},
                    { data: 'UomName', name: 'UomName',width:"31%"},
                    { data: 'AvailableBalance', name: 'AvailableBalance',render: $.fn.dataTable.render.number(',', '.', 2, ''),width:"30%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
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
                },
            });

            var customerdtable=$('#customersdatatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 1, "desc" ]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: { search: '', searchPlaceholder: "Search here"},
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/cuscombalancelist',
                    type: 'DELETE',
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
                columns: [
                    { data: 'wid', name: 'wid', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'CustomerCode', name: 'CustomerCode',width:"15%"},
                    { data: 'CustomerName', name: 'CustomerName',width:"17%"},
                    { data: 'TinNumber', name: 'TinNumber',width:"15%"},
                    { data: 'Origin', name: 'Origin',width:"15%"},
                    { data: 'UomName', name: 'UomName',width:"16%"},
                    { data: 'AvailableBalance', name: 'AvailableBalance',render: $.fn.dataTable.render.number(',', '.', 2, ''),width:"15%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
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
                },
            });
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

        $('#customersdatatable tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        function comBalanceFn(wid,cusid) {
            $("#recInfoId").val(wid);
            if(parseInt(cusid)==1){
                $('.customerinfotbl').hide();
                $('#commoditycustitle').html("Commodity Basic Information");
            }
            else if(parseInt(cusid)>1){
                $('.customerinfotbl').show();
                $('#commoditycustitle').html("Commodity Basic & Customer Information");
            }

            $.ajax({
                url: '/showComStockBalance'+'/'+wid+'/'+cusid,
                type: 'GET',
                
                
                success: function(data) {
                    $.each(data.orgdata, function(key, value) {
                        $('#origininfolbl').html(value.Origin);
                        $('#prdorigininfolbl').html(value.Origin);
                        $('#uominfolbl').html("");
                    });

                    $.each(data.customerdata, function(key, value) {
                        $('#infocustomercode').html(value.CustomerCode);
                        $('#infocustomername').html(value.CustomerName);
                        $('#infocustomertin').html(value.TinNumber);
                        $('#infocustomerphone').html(value.PhoneNumber+",    "+value.OfficePhone);
                        $('#infocustomeremail').html(value.EmailAddress);

                        $('#prdinfocustomercode').html(value.CustomerCode);
                        $('#prdinfocustomername').html(value.CustomerName);
                        $('#prdinfocustomertin').html(value.TinNumber);
                        $('#prdinfocustomerphone').html(value.PhoneNumber+",    "+value.OfficePhone);
                        $('#prdinfocustomeremail').html(value.EmailAddress);
                    });
                },
            });

            $('#comstockbalancetbl').hide();
            $('#comstockbalancetbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
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
                    url: '/showComStockBalanceDetail/'+wid+'/'+cusid,
                    type: 'DELETE',
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
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"7%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"7%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"8%"
                    },
                    {
                        data: 'Grade',
                        name: 'Grade',
                        width:"7%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"8%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"8%"
                    }, 
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"8%"
                    }, 
                    {
                        data: 'AvailableByBag',
                        name: 'AvailableByBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"7%"
                    },
                    {
                        data: 'AvailableBalance',
                        name: 'AvailableBalance',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'AvailableByTon',
                        name: 'AvailableByTon',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'AvailableByFeresula',
                        name: 'AvailableByFeresula',
                        render: $.fn.dataTable.render.number(',', '.',2, ''),
                        width:"7%"
                    },
                    {
                        data: 'PendingQuantity',
                        name: 'PendingQuantity',
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;" onclick=openPrdModalFn("'+row.woredaId+'","'+row.StoreId+'","'+row.LocationId+'","'+row.CommodityType+'","'+row.GradeVal+'","'+row.ProcessType+'","'+row.CropYearVal+'","'+row.uomId+'","'+data+'","'+row.customers_id+'","1")>'+numformat(parseFloat(data).toFixed(2))+'</a>';
                        },
                        width:"8%"
                    },
                    {
                        data: 'PendingDispatch',
                        name: 'PendingDispatch',
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;" onclick=openPrdModalFn("'+row.woredaId+'","'+row.StoreId+'","'+row.LocationId+'","'+row.CommodityType+'","'+row.GradeVal+'","'+row.ProcessType+'","'+row.CropYearVal+'","'+row.uomId+'","'+data+'","'+row.customers_id+'","2")>'+numformat(parseFloat(data).toFixed(2))+'</a>';
                        },
                        width:"8%"
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0") {
                            $(this).text('');
                        }
                    });
                },
                order: [[1, 'asc'],[3, 'asc']],
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                        var colorB = 'style="color:black;font-weight:bold;background:#e6e6e6;"';
                        var colorC = 'style="color:black;font-weight:bold;background:#f2f2f2;"';
                        if(level===0){
                            return $('<tr ' + colorA + '>')
                            .append('<td colspan="14" style="text-align:left;"><b>' + group + ' </b></td></tr>')
                        }
                        else if(level===1){
                            return $('<tr ' + colorB + '>')
                            .append('<td colspan="14" style="text-align:center;">' + group + '</td></tr>')
                        } 
                        else if(level===2){
                            return $('<tr ' + colorC + '>')
                            .append('<td colspan="14" style="text-align:center;">' + group + '</td></tr>')
                        }                            
                    },
                    endRender: function ( rows, group,level ) {
                        var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                        var colorB = 'style="color:black;font-weight:bold;background:#e6e6e6;"';
                        var colorC = 'style="color:black;font-weight:bold;background:#f2f2f2;"';
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var avbag = rows
                            .data()
                            .pluck('AvailableByBag')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var avbalance = rows
                            .data()
                            .pluck('AvailableBalance')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var avbalanceton = rows
                            .data()
                            .pluck('AvailableByTon')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var avbalanceferesula = rows
                            .data()
                            .pluck('AvailableByFeresula')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var totalshipmentqnt = rows
                            .data()
                            .pluck('PendingQuantity')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);

                        var totalpendingdispatch = rows
                            .data()
                            .pluck('PendingDispatch')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);
                        
                        var balancefer=parseFloat(avbalance)/17;

                        avbag=avbag === 0 ? '' : numformat(parseFloat(avbag).toFixed(2));
                        avbalance=avbalance === 0 ? '' : numformat(parseFloat(avbalance).toFixed(2));
                        avbalanceton=avbalanceton === 0 ? '' : numformat(parseFloat(avbalanceton).toFixed(2));
                        avbalanceferesula=avbalanceferesula === 0 ? '' : numformat(parseFloat(avbalanceferesula).toFixed(2));
                        totalshipmentqnt=totalshipmentqnt === 0 ? '' : numformat(parseFloat(totalshipmentqnt).toFixed(2));
                        totalpendingdispatch=totalpendingdispatch === 0 ? '' : numformat(parseFloat(totalpendingdispatch).toFixed(2));

                        if(level===0){
                            return $('<tr ' + colorA + '>')
                                .append('<td colspan="8" style="text-align:right;"><b>Total of: ' + group + ' </b></td>')
                                .append('<td style="text-align:left;">'+ avbag+'</td>')
                                .append('<td style="text-align:left;">'+ avbalance+'</td>')
                                .append('<td style="text-align:left;">'+avbalanceton+'</td>')
                                .append('<td style="text-align:left;">'+avbalanceferesula+'</td>')
                                .append('<td style="text-align:left;">'+totalshipmentqnt+'</td>')
                                .append('<td style="text-align:left;">'+ totalpendingdispatch+'</td></tr>');
                        }
                        else if(level===1){
                            return $('<tr ' + colorB + '>')
                                .append('<td colspan="8" style="text-align:right;"><b>Total of: ' + group + ' </b></td>')
                                .append('<td style="text-align:left;">'+ avbag+'</td>')
                                .append('<td style="text-align:left;">'+ avbalance+'</td>')
                                .append('<td style="text-align:left;">'+avbalanceton+'</td>')
                                .append('<td style="text-align:left;">'+avbalanceferesula+'</td>')
                                .append('<td style="text-align:left;">'+totalshipmentqnt+'</td>')
                                .append('<td style="text-align:left;">'+ totalpendingdispatch+'</td></tr>');
                        }
                        else if(level===2){
                            return $('<tr ' + colorC + '>')
                                .append('<td colspan="8" style="text-align:right;"><b>Total of: ' + group + ' </b></td>')
                                .append('<td style="text-align:left;">'+ avbag+'</td>')
                                .append('<td style="text-align:left;">'+ avbalance+'</td>')
                                .append('<td style="text-align:left;">'+avbalanceton+'</td>')
                                .append('<td style="text-align:left;">'+avbalanceferesula+'</td>')
                                .append('<td style="text-align:left;">'+totalshipmentqnt+'</td>')
                                .append('<td style="text-align:left;">'+ totalpendingdispatch+'</td></tr>');
                        }
                    },
                    dataSrc: ['StoreName','CommType']
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['CommType']; // Assuming 'group_column' is the name of the column used for grouping
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
                        }
                    });
                },
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var totalbagnumber = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalavailablebal = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalavailableton = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalavailableferesula = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalshipment = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalpendingdisp = api
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $("#totalbagnumber").html(totalbagnumber === 0 ? '' : numformat(parseFloat(totalbagnumber).toFixed(0)));
                    $("#totalbalanceinfo").html(totalavailablebal === 0 ? '' : numformat(parseFloat(totalavailablebal).toFixed(2)));
                    $("#totalbalancetoninfo").html(totalavailableton === 0 ? '' : numformat(parseFloat(totalavailableton).toFixed(2)));
                    $("#totalbalanceferesulainfo").html(totalavailableferesula === 0 ? '' : numformat(parseFloat(totalavailableferesula).toFixed(2)));
                    $("#totalshipments").html(totalshipment === 0 ? '' : numformat(parseFloat(totalshipment).toFixed(2)));
                    $("#totalpendingdispatch").html(totalpendingdisp === 0 ? '' : numformat(parseFloat(totalpendingdisp).toFixed(2)));
                },
                drawCallback: function() {
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
                    $("#comstockbalancetbl").show();
                },
            });

            refreshtbl();
            $(".infoscl").collapse('show');
            $("#informationmodal").modal('show');
        }

        function openPrdModalFn(comm,str,flrmap,commtype,grade,prctype,crpyr,uomid,qnt,cusid,flg){
            $(".detailscls").hide();
            if(parseInt(flg)==1){
                $("#prdcomstockbalancetbl").hide();
                $('#prdcomstockbalancetbl').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: true,
                    info: false,
                    searchHighlight: true,
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
                        url: '/showProductionQnt/'+comm+'/'+str+'/'+flrmap+'/'+commtype+'/'+grade+'/'+prctype+'/'+crpyr+'/'+uomid+'/'+cusid,
                        type: 'DELETE',
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
                    columns: [
                        {
                            data:'DT_RowIndex',
                            width:"3%"
                        },
                        {
                            data: 'DocumentNumber',
                            name: 'DocumentNumber',
                            width:"10%"
                        },
                        {
                            data: 'StoreName',
                            name: 'StoreName',
                            width:"10%"
                        },
                        {
                            data: 'CommodityType',
                            name: 'CommodityType',
                            width:"9%"
                        },
                        {
                            data: 'Grade',
                            name: 'Grade',
                            width:"9%"
                        },
                        {
                            data: 'ProcessType',
                            name: 'ProcessType',
                            width:"9%"
                        },
                        {
                            data: 'CropYear',
                            name: 'CropYear',
                            width:"9%"
                        }, 
                        {
                            data: 'UOM',
                            name: 'UOM',
                            width:"9%"
                        }, 
                        {
                            data: 'NumOfBag',
                            name: 'NumOfBag',
                            render: $.fn.dataTable.render.number(',', '.',0, ''),
                            width:"8%"
                        },
                        {
                            data: 'NetKg',
                            name: 'NetKg',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"8%"
                        },
                        {
                            data: 'TON',
                            name: 'TON',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"8%"
                        },
                        {
                            data: 'Feresula',
                            name: 'Feresula',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"8%"
                        },
                        {
                            data: 'RecType',
                            name: 'RecType',
                            'visible': false
                        }, 
                        {
                            data: 'Ord',
                            name: 'Ord',
                            'visible': false
                        }, 
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $('td', row).each(function() {
                            // If the cell's text is "0", set it to an empty string
                            if ($(this).text() == "0.00" || $(this).text() == "0") {
                                $(this).text('');
                            }
                        });
                    }, 
                    rowGroup: {
                        startRender: function ( rows, group,level ) {
                            var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                            if(level===0){
                                return $('<tr ' + colorA + '>')
                                .append('<td colspan="12" style="text-align:left;"><b>' + group + ' </b></td></tr>')
                            }
                                                    
                        },
                        endRender: function ( rows, group,level ) {
                            var colorA = 'style="color:black;font-weight:bold;background:#cccccc;"';
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                            i : 0;
                            };

                            var totalnumofbag = rows
                                .data()
                                .pluck('NumOfBag')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                            }, 0);

                            var totalnetkg = rows
                                .data()
                                .pluck('NetKg')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                            }, 0);

                            var totalton = rows
                                .data()
                                .pluck('TON')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                            }, 0);

                            var totalferesula = rows
                                .data()
                                .pluck('Feresula')
                                .reduce(function (a, b) {
                                    return intVal(a) + intVal(b);
                            }, 0);

                            totalnumofbag=totalnumofbag === 0 ? '' : numformat(parseFloat(totalnumofbag));
                            totalnetkg=totalnetkg === 0 ? '' : numformat(parseFloat(totalnetkg).toFixed(2));
                            totalton=totalton === 0 ? '' : numformat(parseFloat(totalton).toFixed(2));
                            totalferesula=totalferesula === 0 ? '' : numformat(parseFloat(totalferesula).toFixed(2));

                            if(level===0){
                                return $('<tr ' + colorA + '>')
                                    .append('<td colspan="8" style="text-align:right;"><b>Total of: ' + group + ' </b></td>')
                                    .append('<td style="text-align:left;">'+ totalnumofbag+'</td>')
                                    .append('<td style="text-align:left;">'+ totalnetkg+'</td>')
                                    .append('<td style="text-align:left;">'+totalton+'</td>')
                                    .append('<td style="text-align:left;">'+totalferesula+'</td></tr>');
                            }
                        },
                        dataSrc: ['RecType']
                    },
                    drawCallback: function(settings) {
                        var api = this.api();
                        var currentIndex = 1;
                        var currentGroup = null;
                        api.rows({ page: 'current', search: 'applied' }).every(function() {
                            var rowData = this.data();
                            if (rowData) {
                                var group = rowData['RecType']; // Assuming 'group_column' is the name of the column used for grouping
                                if (group !== currentGroup) {
                                    currentIndex = 1; // Reset index for a new group
                                    currentGroup = group;
                                }
                                $(this.node()).find('td:first').text(currentIndex++);
                            }
                        });
                    },
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(),data;
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        var totalbagnumber = api
                        .column(8)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalavailablebal = api
                        .column(9)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalavailableton = api
                        .column(10)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalavailableferesula = api
                        .column(11)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        $('#prdtotalbagnumber').html(totalbagnumber=totalbagnumber === 0 ? '' : numformat(parseInt(totalbagnumber)));
                        $('#prdtotalbalanceinfo').html(totalavailablebal=totalavailablebal === 0 ? '' : numformat(parseFloat(totalavailablebal).toFixed(2)));
                        $('#prdtotalbalancetoninfo').html(totalavailableton=totalavailableton === 0 ? '' : numformat(parseFloat(totalavailableton).toFixed(2)));
                        $('#prdtotalbalanceferesulainfo').html(totalavailableferesula=totalavailableferesula === 0 ? '' : numformat(parseFloat(totalavailableferesula).toFixed(2)));
                    },
                    drawCallback: function() {
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
                        $("#prdcomstockbalancetbl").show();
                    },
                });
                $("#detailinfomodaltitle").html("Allocated Amount Information");
                $("#productiondiv").show();
            }
            else if(parseInt(flg)==2){
                $("#dispatchdetailtbl").hide();
                $('#dispatchdetailtbl').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    paging: false,
                    searching: true,
                    info: false,
                    searchHighlight: true,
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
                        url: '/showDispatchData/'+comm+'/'+str+'/'+flrmap+'/'+commtype+'/'+grade+'/'+prctype+'/'+crpyr+'/'+uomid+'/'+cusid,
                        type: 'DELETE',
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
                    columns: [
                        {
                            data:'DT_RowIndex',
                            width:"3%"
                        },
                        {
                            data: 'DocumentNumber',
                            name: 'DocumentNumber',
                            width:"7%"
                        },
                        {
                            data: 'StoreName',
                            name: 'StoreName',
                            width:"5%"
                        },
                        {
                            data: 'CommodityType',
                            name: 'CommodityType',
                            width:"5%"
                        },
                        {
                            data: 'Grade',
                            name: 'Grade',
                            width:"5%"
                        },
                        {
                            data: 'ProcessType',
                            name: 'ProcessType',
                            width:"5%"
                        },
                        {
                            data: 'CropYear',
                            name: 'CropYear',
                            width:"5%"
                        }, 
                        {
                            data: 'UOM',
                            name: 'UOM',
                            width:"5%"
                        }, 
                        {
                            data: 'NumOfBag',
                            name: 'NumOfBag',
                            render: $.fn.dataTable.render.number(',', '.',0, ''),
                            width:"5%"
                        },
                        {
                            data: 'NetKg',
                            name: 'NetKg',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'TON',
                            name: 'TON',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'Feresula',
                            name: 'Feresula',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'DispatchNumOfBag',
                            name: 'DispatchNumOfBag',
                            render: $.fn.dataTable.render.number(',', '.',0, ''),
                            width:"5%"
                        },
                        {
                            data: 'DispatchNetKG',
                            name: 'DispatchNetKG',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'DispatchTON',
                            name: 'DispatchTON',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'DispatchFeresula',
                            name: 'DispatchFeresula',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'RemNumOfBag',
                            name: 'RemNumOfBag',
                            render: $.fn.dataTable.render.number(',', '.',0, ''),
                            width:"5%"
                        },
                        {
                            data: 'RemNetKG',
                            name: 'RemNetKG',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'RemTON',
                            name: 'RemTON',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                        {
                            data: 'RemFeresula',
                            name: 'RemFeresula',
                            render: $.fn.dataTable.render.number(',', '.', 2, ''),
                            width:"5%"
                        },
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $('td', row).each(function() {
                            // If the cell's text is "0", set it to an empty string
                            if ($(this).text() == "0.00" || $(this).text() == "0") {
                                $(this).text('');
                            }
                        });
                    }, 
                    
                    
                    "footerCallback": function ( row, data, start, end, display ) {
                        var api = this.api(),data;
                        // Remove the formatting to get integer data for summation
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        var totalbagnumber = api
                        .column(8)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalavailablebal = api
                        .column(9)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalavailableton = api
                        .column(10)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var totalavailableferesula = api
                        .column(11)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        //--

                        var dtotalbag = api
                        .column(12)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var dtotalnetkg = api
                        .column(13)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var dtotalton = api
                        .column(14)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var dtotalferesula = api
                        .column(15)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        //--

                        var remtotalbag = api
                        .column(16)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var remtotalnetkg = api
                        .column(17)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var remtotalton = api
                        .column(18)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        var remtotalfer = api
                        .column(19)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                        $('#reqtotalbag').html(totalbagnumber=totalbagnumber === 0 ? '' : numformat(parseInt(totalbagnumber)));
                        $('#reqtotalkg').html(totalavailablebal=totalavailablebal === 0 ? '' : numformat(parseFloat(totalavailablebal).toFixed(2)));
                        $('#reqtotalton').html(totalavailableton=totalavailableton === 0 ? '' : numformat(parseFloat(totalavailableton).toFixed(2)));
                        $('#reqtotalferesula').html(totalavailableferesula=totalavailableferesula === 0 ? '' : numformat(parseFloat(totalavailableferesula).toFixed(2)));

                        $('#distotalbag').html(dtotalbag=dtotalbag === 0 ? '' : numformat(parseInt(dtotalbag)));
                        $('#distotalkg').html(dtotalnetkg=dtotalnetkg === 0 ? '' : numformat(parseFloat(dtotalnetkg).toFixed(2)));
                        $('#distotalton').html(dtotalton=dtotalton === 0 ? '' : numformat(parseFloat(dtotalton).toFixed(2)));
                        $('#distotalferesula').html(dtotalferesula=dtotalferesula === 0 ? '' : numformat(parseFloat(dtotalferesula).toFixed(2)));

                        $('#remtotalbag').html(remtotalbag=remtotalbag === 0 ? '' : numformat(parseInt(remtotalbag)));
                        $('#remtotalkg').html(remtotalnetkg=remtotalnetkg === 0 ? '' : numformat(parseFloat(remtotalnetkg).toFixed(2)));
                        $('#remtotalton').html(remtotalton=remtotalton === 0 ? '' : numformat(parseFloat(remtotalton).toFixed(2)));
                        $('#remtotalferesula').html(remtotalfer=remtotalfer === 0 ? '' : numformat(parseFloat(remtotalfer).toFixed(2)));
                    },
                    drawCallback: function() {
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
                        $("#dispatchdetailtbl").show();
                    },
                });
                $("#detailinfomodaltitle").html("Pending Dispatch Information");
                $("#dispatchdiv").show();
            }
            $(".infoprd").collapse('show');
            $("#prdinformationmodal").modal('show');
        }

        function refreshtbl()
        {
            var tabletr = $('#laravel-datatable-crud').DataTable();tabletr.search('');
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);

            var tablecustr = $('#customersdatatable').DataTable();tablecustr.search('');
            var iTable = $('#customersdatatable').dataTable(); 
            iTable.fnDraw(false);
        }

        function numformat(val){
            while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
            }
            return val;
        }

    </script>
@endsection
