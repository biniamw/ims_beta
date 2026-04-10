@extends('layout.app1')
@section('title')
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('fontawesome6/pro/css/all.min.css') }}">
@endsection
@section('content')
    @can('StoreBalance-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="row" style="width:100%;">
                                <div style="width: 1%;"></div>
                                <h3 class="card-title">Stock Balance</h3>
                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i data-feather='refresh-ccw'></i></button>
                                <input type="hidden" class="form-control" name="costtype" id="costtype" value="{{ $settingsval->costType }}" readonly/>
                            </div> 
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>
                                    <table id="stockbalancedatatable" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>SKU Number</th>
                                                <th>Category</th>
                                                <th>UOM</th>
                                                <th>RT Price</th>
                                                <th>WS Price</th>
                                                <th>WS Min Qty</th> 
                                                <th>WS Max Qty</th>  
                                                <th>Avaliable Stock</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" class="form-control" name="wholesalefeaturetable" id="wholesalefeaturetable" readonly="true" value="{{ $settingsval->wholesalefeature }}" />
    </div>
    @endcan
    <!--Start Info Modal -->
    <div class="modal fade text-left" id="stockInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Item Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeInfoModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="storeBalanceInfo">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <input type="hidden" placeholder="" class="form-control" name="itemid" id="itemid" readonly="true">
                                    <table class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <tr>
                                            <th><label strong style="font-size: 14px;">Item Code</label></th>
                                            <th><label strong style="font-size: 14px;">Item Name</label></th>
                                            <th><label strong style="font-size: 14px;">SKU Number</label></th>
                                            <th><label strong style="font-size: 14px;">Category</label></th>
                                            <th><label strong style="font-size: 14px;">UOM</label></th>
                                            <th><label strong style="font-size: 14px;">RT Price</label></th>
                                            <th><label strong style="font-size: 14px;">WS Price</label></th>
                                            <th><label strong style="font-size: 14px;">WS Min Qty</label></th>
                                            <th><label strong style="font-size: 14px;">Ws Max Qty</label></th>
                                            <th style="display:none;"><label strong style="font-size: 14px;">Max Cost</label></th>
                                        </tr>
                                        <tr>
                                            <td><label id="itemcodeval" strong style="font-size:14px;"></label></td>
                                            <td><label id="itemnameval" strong style="font-size:14px;"></label></td>
                                            <td><label id="skunumberval" strong style="font-size:14px;"></label></td>
                                            <td><label id="categoryval" strong style="font-size:14px;"></label></td>
                                            <td><label id="uomval" strong style="font-size:14px;"></label></td>
                                            <td><label id="retailerval" strong style="font-size:14px;"></label></td>
                                            <td><label id="wholesaleval" strong style="font-size:14px;"></label></td>
                                            <td><label id="wholesaleminval" strong style="font-size:14px;"></label></td>
                                            <td><label id="wholesalemaxval" strong style="font-size:14px;"></label></td>
                                            <td style="display:none;"><label id="maxcostval" strong style="font-size:14px;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail Information</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <table id="stockinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                        <thead>
                                            <th>#</th>
                                            <th>Store/Shop Name</th>
                                            <th>Stock Balance</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Waiting for Delivery</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                        <tfoot>
                                            <td style="text-align: right;font-size: 16px;font-weight:bold;" colspan="2"><label id="avlbl" strong style="font-size: 16px;">Total Quantity</label></td>
                                            <td><label id="avbalanceval" strong style="font-size: 16px;font-weight: bold;"></label></td>
                                            <td colspan="5"></td>
                                            <td><label id="delbalanceval" strong style="font-size: 16px;font-weight: bold;"></label></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table style="width:100%;" id="infoTotalQuantity">
                                <tr>
                                    <td>       
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeInfoModal()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Info -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="deliveryqtymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Shipping Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deliveryqtyform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <table class="table table-bordered table-striped table-hover dt-responsive table mb-0" style="width:100%;">
                                    <tr>
                                        <th><label strong style="font-size: 14px;">Item Code</label></th>
                                        <th><label strong style="font-size: 14px;">Item Name</label></th>
                                        <th><label strong style="font-size: 14px;">SKU Number</label></th>
                                        <th><label strong style="font-size: 14px;">Category</label></th>
                                        <th><label strong style="font-size: 14px;">UOM</label></th>
                                        <th><label strong style="font-size: 14px;">Retailer Price</label></th>
                                        <th><label strong style="font-size: 14px;">Wholeseller Price</label></th>
                                        <th><label strong style="font-size: 14px;">Wholesale Minimum Quantity</label></th>
                                        <th><label strong style="font-size: 14px;">Wholesale Maximum Quantity</label></th>
                                    </tr>
                                    <tr>
                                        <td><label id="itemcodelbl" strong style="font-size:14px;"></td>
                                        <td><label id="itemnamelbl" strong style="font-size:14px;"></td>
                                        <td><label id="skunumlbl" strong style="font-size:14px;"></td>
                                        <td><label id="catdellbl" strong style="font-size:14px;"></td>
                                        <td><label id="uomdellbl" strong style="font-size:14px;"></td>
                                        <td><label id="retdellbl" strong style="font-size:14px;"></td>
                                        <td><label id="wholesaledellbl" strong style="font-size:14px;"></td>
                                        <td><label id="wholmindellbl" strong style="font-size:14px;"></td>
                                        <td><label id="wholmaxdellbl" strong style="font-size:14px;"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail Information</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <table id="quantityondeliverytbl" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>Source Store/Shop</th>
                                            <th>Destination Store/Shop</th>
                                            <th>Transfer Doc. #</th>
                                            <th>Issue Doc. #</th>
                                            <th>Deliver By</th>
                                            <th>Shipment Date</th>
                                            <th>Quantity</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                        <tfoot>
                                            <td colspan="7"></td>
                                            <td><label id="totaldeliveredqty" strong style="font-size: 16px;font-weight: bold;"></label></td>
                                            <td></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo void modal -->

<script  type="text/javascript">
    var stockbaltable='';
    var gblIndex=0;
    $(function () {
        cardSection = $('#page-block');
    });
    //Datatable read property starts
    $(document).ready( function () {
        stockbalancedatalist();
    });
    function stockbalancedatalist(){
        stockbaltable=$('#stockbalancedatatable').DataTable({
        destroy:true,
        processing: true,
        serverSide: true,
        responsive: true,
        searchHighlight: true,
        "order": [[ 2, "asc" ]],
        "lengthMenu": [[50, 100], [50, 100]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here" },
        scrollY:'55vh',
        scrollX: true,
        scrollCollapse: true,
        "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'p>>",
        ajax: {
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/stockbalancedata',
            type: 'DELETE',
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
                    setFocus();    
            },
        },
        columns: [
            { data: 'DT_RowIndex'},
            { data: 'ItemCode', name:'ItemCode'},
            { data: 'ItemName', name:'ItemName'},
            { data: 'SKUNumber', name:'SKUNumber'},
            { data: 'Category', name:'Category'},
            { data: 'UOM', name:'UOM'},
            { data: 'RetailerPrice', name:'RetailerPrice'},
            { data: 'Wholeseller', name:'Wholeseller'},
            { data: 'wholeSellerMinAmount', name:'wholeSellerMinAmount'},
            { data: 'MinimumStock',name:'MinimumStock'},
            { data: 'AvailableQuantityReg', name:'AvailableQuantityReg'}, 
            { data: 'MinimumStockFlag', name:'MinimumStockFlag','visible':false},
            { data: 'StockPr', name:'StockPr','visible':false},
            { data: 'StockAv', name:'StockAv','visible':false},
            { data: 'Balance', name:'Balance','visible':false},
            { data: 'MinimumStock', name:'MinimumStock','visible':false},  
            { data: 'PendingQuantity', name:'PendingQuantity','visible':false},
            { data: 'MaxCost', name:'MaxCost','visible':false},
            { data: 'averageCost', name:'averageCost','visible':false},
            { data: 'id', name:'id','visible':false},
            { data: 'AvailableQuantity', name:'AvailableQuantity','visible':false},
            { data: 'action', name: 'action'}
        ],
        columnDefs: [
            {
                targets:6,
                render:function (data, type, row, meta){
                    var retailerprice=row.RetailerPrice;
                    //var maxcost=row.MaxCost;
                    var costType=$('#costtype').val();
                    var maxcost = costType == 0 ? row.MaxCost: row.averageCost;
                    switch(data){
                        case 0:
                            return '';
                        default:
                            if(parseFloat(maxcost)>parseFloat(retailerprice)){
                            return '<span class="badge badge-light-danger">unc</span>';
                            }
                            else{
                                return numformat(data||0);
                            }
                    } 
                }
            },
            {
                targets:7,
                render:function (data, type, row, meta){
                    var wholesaleprice=row.Wholeseller;
                    //var maxcost=row.MaxCost;
                    var costType=$('#costtype').val();
                    var maxcost = costType == 0 ? row.MaxCost: row.averageCost;
                    switch(data){
                        case 0:
                            return '';
                            break;
                        default:
                            if(parseFloat(maxcost)>parseFloat(wholesaleprice)){
                                return '<span class="badge badge-light-danger">unc</span>';
                            }
                            else{
                                return numformat(data||0);
                            }
                    }
                }
            },
            {
                targets:8,
                render:function(data,type,row,meta){
                    switch(data){
                        case 0:
                            return '';
                        break;
                    default:
                        return data;
                    }
                }
            },
            {
                targets:9,
                render:function (data, type, row, meta){
                    var maximum=0;
                    var maxreturn='';
                    var balance=row.Balance||0;
                    var minumumstock=row.MinimumStock||0;
                    var pendingquantity=row.PendingQuantity||0;
                    if(minumumstock>0){
                        var maxc=parseFloat(balance)-parseFloat(minumumstock)-parseFloat(pendingquantity);
                        maximum=maxc>0?maxc:0;
                        maxreturn=maximum>=row.wholeSellerMinAmount?maximum:0;
                    }
                    switch(row.wholeSellerMinAmount){
                        case 0:
                            return '';
                        break;
                        default:
                            return numformat(maxreturn);
                    }
                }
            },
            {
                targets:10,
                render: function (data, type, row, meta) {
                    var avbalance=data||0;
                    var balance=row.Balance||0;
                    var result=0;
                    if(parseFloat(avbalance)<=0 && parseFloat(balance)>0){
                        return "0";
                    }
                    if(parseFloat(avbalance)<=0 && parseFloat(balance)==0){
                        return "0";
                    }
                    if(parseFloat(avbalance)>0){
                        return numformat(data);
                    }
                }
            },
            {
                targets:21,
                render: function ( data, type, row, meta ) {
                    var balance=row.Balance||0;
                    var allbalance=row.AvailableQuantity||0;
                    var minumumstock=row.MinimumStock||0;
                    var pendingquantity=row.PendingQuantity||0;
                    var minamount=row.wholeSellerMinAmount||0;
                    var minstock=row.MinimumStock||0;
                    var wholesalemax=parseFloat(balance)-parseFloat(pendingquantity)-parseFloat(minstock);
                        wholesalemax=wholesalemax>0?wholesalemax:0;
                    var btn="";
                    btn='<a class="balanceinfo" href="javascript:void(0)" data-id="'+row.id+'" data-code="'+row.ItemCode+'" data-name="'+row.ItemName+'" data-sku="'+row.SKUNumber+'" data-category="'+row.Category+'" data-uom="'+row.UOM+'" data-ret="'+row.RetailerPrice+'" data-wholesale="'+row.Wholeseller+'" data-wholesalemin="'+minamount+'" data-wholesalemax="'+wholesalemax+'" data-totalq="'+row.Balance+'" data-maxcost="'+row.MaxCost+'" data-pending="'+pendingquantity+'" data-minstock="'+minstock+'" data-toggle="modal" id="mediumButton" data-target="#stockInfoModal" title="Show Detail Info"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                    return btn;
                }
            }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull){
            var api = this.api();
            var maximum='';
            var balance=aData.Balance||0;
            var pendingbalance=aData.PendingQuantity||0;
            var minstock=aData.MinimumStock||0;
            var minamount=aData.wholeSellerMinAmount||0;
            var allblance=parseFloat(balance)-parseFloat(pendingbalance);
            if(parseFloat(minstock)>0){
                var maxc=parseFloat(allblance)-parseFloat(minstock);
                maximum=maxc>=0?maxc:0;
            }
            var minimumstock= aData.MinimumStock||0;    
            var avquantity=aData.AvailableQuantity||0;  
            var wholesalefeaturetable=$('#wholesalefeaturetable').val();
            if(wholesalefeaturetable==0){
                api.column(7).visible(false);
                api.column(8).visible(false);
                api.column(9).visible(false);
                if (parseFloat(allblance)<=0 || parseFloat(avquantity)<=0) {
                    $(nRow).find('td:eq(6)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                }
                
                if (aData.StockPr==1 && aData.StockAv==1) {
                    $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                } 
                else if (aData.StockPr==0 && aData.StockAv==1) {
                    $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                }
                else if (aData.StockPr==0 && aData.StockAv==0) {
                    $(nRow).find('td:eq(7)').css({"font-weight": "bold"});
                }  
            }
            if(wholesalefeaturetable==1){
                api.column(7).visible(true);
                api.column(8).visible(true);
                api.column(9).visible(true);
                //console.log('ab='+allblance+','+minimumstock+','+minamount+','+pendingbalance+','+balance);
                if(parseFloat(allblance)<parseFloat(minimumstock) || parseFloat(maximum)<parseFloat(minamount)|| parseFloat(allblance)<=0 ||parseFloat(maximum)<=0|| parseFloat(allblance)<parseFloat(minamount)){
                    
                    $(nRow).find('td:eq(7)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                    $(nRow).find('td:eq(8)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                    $(nRow).find('td:eq(9)').css({"text-decoration": "line-through","text-decoration-color": "red"});
                }
                if (aData.StockPr==1 && aData.StockAv==1) {
                    $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                } 
                else if (aData.StockPr==0 && aData.StockAv==1) {
                    $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                }
                else if (aData.StockPr==0 && aData.StockAv==0) {
                    $(nRow).find('td:eq(10)').css({"font-weight": "bold"});
                }  
            }  
        },
        });
    }
    function setFocus(){ 
            $($('#stockbalancedatatable tbody > tr')[gblIndex]).addClass('selected');  
        }
    $('#stockbalancedatatable tbody').on('click', 'tr', function () {
            $('#stockbalancedatatable tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
    });
    $('#stockInfoModal').on('show.bs.modal',function(event){
        var button=$(event.relatedTarget);
        var id=button.data('id');
        var category=button.data('category');
        var uom=button.data('uom');
        var totalavailableqnt="";
        var wholemax=-1;
        var wholemin=-1;
        var modal=$(this);
        $.ajax({
                type: "GET",
                url: "{{ url('showitem') }}/"+id,
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
                success: function (response) {
                        $.each(response, function (index, value) { 
                            var code=value.Code;
                            var name=value.Name;
                            var sku=value.SKUNumber;
                            var retpr=value.RetailerPrice;
                            var wholesale=value.WholesellerPrice;
                            wholemin=value.wholeSellerMinAmount;
                            var totalq=value.AvailableQuantity;
                            var minstock=value.MinimumStock;
                            var pending=value.PendingQuantity; 
                            var maxc=value.MaxCost;
                            var averageCost= value.MaxCost;
                            totalq=parseFloat(value.AvailableQuantity)-parseFloat(value.PendingQuantity);
                            wholemax=parseFloat(totalq)-parseFloat(minstock);
                            if(parseFloat(retpr)>0){
                                if(parseFloat(maxc)>parseFloat(retpr)){
                                var unc= '<span class="badge badge-light-danger">unc</span>';
                                modal.find('.modal-body #retailerval').html(unc);
                            } else{
                                if(parseFloat(totalq)<=0){
                                    retpr="<p style='text-decoration:line-through;text-decoration-color:red;'>"+retpr+"</p>";
                                }else{
                                    modal.find('.modal-body #retailerval').html(numformat(retpr));
                                }
                                
                            }
                        } else{
                            
                            modal.find('.modal-body #retailerval').html('');
                        }
                        if(parseFloat(wholesale)>0){
                            if(parseFloat(maxc)>parseFloat(wholesale)){
                            var unc= '<span class="badge badge-light-danger">unc</span>';
                            modal.find('.modal-body #wholesaleval').html(unc);
                            modal.find('.modal-body #wholesaleminval').html(numformat(wholemin));
                            modal.find('.modal-body #wholesalemaxval').html(numformat(wholemax));
                            } else{
                                    if(parseFloat(totalq)<parseFloat(minstock) || parseFloat(wholemax)<parseFloat(wholemin) || parseFloat(totalq)<=0||parseFloat(wholemax)<=0||parseFloat(totalq)<parseFloat(wholemin)){
                                            switch(minstock){
                                                case 0:
                                                wholemax='';
                                                break;
                                                default:
                                                    if(parseFloat(wholemax)<=0){
                                                    wholemax=0;
                                                } else{
                                                    wholemax=wholemax;
                                                }
                                                break;
                                            }
                                        wholesale="<p style='text-decoration:line-through;text-decoration-color:red;'>"+wholesale+"</p>";
                                        wholemin="<p style='text-decoration:line-through;text-decoration-color:red;'>"+wholemin+"</p>";
                                        wholemax="<p style='text-decoration:line-through;text-decoration-color:red;'>"+wholemax+"</p>";
                                        modal.find('.modal-body #wholesaleval').html(numformat(wholesale));
                                        modal.find('.modal-body #wholesaleminval').html(numformat(wholemin));
                                        modal.find('.modal-body #wholesalemaxval').html(numformat(wholemax));
                                    } else{
                                        switch(minstock){
                                                case 0:
                                                wholemax='';
                                                break;
                                                default:
                                                    if(parseFloat(wholemax)<=0){
                                                    wholemax=0;
                                                } else{
                                                    wholemax=wholemax;
                                                }
                                                break;
                                            }
                                        modal.find('.modal-body #wholesaleval').html(numformat(wholesale));
                                        modal.find('.modal-body #wholesaleminval').html(numformat(wholemin));
                                        modal.find('.modal-body #wholesalemaxval').html(numformat(wholemax));
                                    }
                        }
                    }
                    else {
                        modal.find('.modal-body #wholesaleval').html('');
                        modal.find('.modal-body #wholesaleminval').html('');
                        modal.find('.modal-body #wholesalemaxval').html('');
                    } 
                    modal.find('.modal-body #itemid').val(id);
                    modal.find('.modal-body #itemcodeval').text(code);
                    modal.find('.modal-body #itemnameval').text(name);
                    modal.find('.modal-body #skunumberval').text(sku);
                    modal.find('.modal-body #categoryval').text(category);
                    modal.find('.modal-body #maxcostval').text(numformat(maxc));
                    modal.find('.modal-body #uomval').text(uom);
                    });
                }
            });

        $('#stockinfodetail').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        paging:false,
        searching:false,
        info:false,
        "order": [[ 1, "asc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/showStockDetail/'+id,
            type: 'DELETE',
            dataType: "json",
            beforeSend: function () { 
                $('#stockinfodetail').hide();
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
                    $('#stockinfodetail').show();     
            },
        },
        columns: [
            { data: 'DT_RowIndex'},
            { data: 'StoreName', name: 'StoreName'},
            { data: 'StoreBalance', name: 'StoreBalance'},
            { data: 'StrBalance', name: 'StrBalance','visible': false},
            { data: 'UserIds', name: 'UserIds','visible': false},
            { data: 'PendingQuantity', name: 'PendingQuantity','visible': false},
            { data: 'UOM', name: 'UOM','visible': false},
            { data: null, className: "sum",'visible': false,
                "render": function (data, type, row, meta) {
                    var pen=row.PendingQuantity||0;
                    var bal=row.StoreBalance||0;
                    var result=0;
                    result=parseFloat(bal)-parseFloat(pen);
                    if((parseFloat(result)<0)&& row.UserIds==0||row.UserIds==""||row.UserIds==null){
                        return "0";
                    }
                    if(parseFloat(result)<0 && row.UserIds>0){
                        return "0";
                    }
                    if((row.UserIds==0||row.UserIds==""||row.UserIds==null) && parseFloat(result)>0){
                        return "0";
                    }
                    if(row.UserIds==0||row.UserIds==""||row.UserIds==null){
                        return "0";
                    }
                    if(row.UserIds>0){
                        return result;
                    }
                    if(parseFloat(result)>0 && row.UserIds>0){
                        return result;
                    }   
                }
            },
            { data: 'QtyOnDelivery', name: 'QtyOnDelivery'},
            { data: 'QtyOnDelivery', name: 'QtyOnDelivery','visible': false},
            { data: 'ItemId', name: 'ItemId','visible': false},
            { data: 'StoreId', name: 'StoreId','visible': false},
        ],
        columnDefs: [{
            targets:2,
            render: function (data,type,row,meta) {  
                var pen=row.PendingQuantity||0;
                var bal=row.StoreBalance||0;
                var result=0;
                result=parseFloat(bal)-parseFloat(pen);
                if((parseFloat(result)<0)&& row.UserIds==0||row.UserIds==""||row.UserIds==null){
                    return "N/A";
                }
                if(parseFloat(result)<0 && row.UserIds>0){
                    return "0";
                }
                if((row.UserIds==0||row.UserIds==""||row.UserIds==null) && parseFloat(result)>0){
                    return "A/V";
                }
                if(row.UserIds==0||row.UserIds==""||row.UserIds==null){
                    return "N/A";
                }
                if(parseFloat(row.UserIds)>0){
                    return numformat(result)+" "+row.UOM;
                }
                if(parseFloat(result)>0 && parseFloat(row.UserIds)>0){
                    return numformat(result)+" "+row.UOM;
                }   
            } 
        },
        { 
            targets:8,
            render: function (data,type,row,meta) {  
                var qtydel=row.QtyOnDelivery||0;
                var results=0;
                results=parseFloat(qtydel);
                if((parseFloat(results)<0)&& parseFloat(row.UserIds)==0||row.UserIds==""||row.UserIds==null){
                    return "N/A";
                }
                if(parseFloat(results)<0 && parseFloat(row.UserIds)>0){
                    return "0";
                }
                if((row.UserIds==0 ||row.UserIds=="" ||row.UserIds==null) && parseFloat(results)>0){
                    return "A/V";
                }
                if(row.UserIds==0 || row.UserIds=="" ||row.UserIds==null){
                    return "N/A";
                }
                if(parseFloat(row.UserIds)>0){
                    return '<a style="text-decoration:underline;color:blue;" onclick=opendetailmod("'+row.ItemId+'","'+row.StoreId+'","'+row.QtyOnDelivery+'")>'+numformat(results)+" "+row.UOM+'</a>';  
                    //return numformat(results)+" "+row.UOM;
                }
                if(parseFloat(results)>0 && parseFloat(row.UserIds)>0){
                    return '<a style="text-decoration:underline;color:blue;" onclick=opendetailmod("'+row.ItemId+'","'+row.StoreId+'","'+row.QtyOnDelivery+'")>'+numformat(results)+" "+row.UOM+'</a>';  
                    //return numformat(results)+" "+row.UOM;
                }   
            },      
        }],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            var qtydel=aData.QtyOnDelivery||0;
            var pen=aData.PendingQuantity||0;
            var bal=aData.StoreBalance||0;
            var userid=aData.UserIds||0;
            var result=0;
            var total=0;
            result=parseFloat(bal)-parseFloat(pen);
            if ((parseFloat(userid)==0)&&(parseFloat(result)>0)) {
                for(var i=0;i<=3;i++){
                    $(nRow).find('td:eq('+i+')').css({"color":"#f6c23e","font-weight":"bold"});
                }
            } 
            else if (parseFloat(result)>0) {
                for(var i=0;i<=3;i++){
                    $(nRow).find('td:eq('+i+')').css({"color":"#1cc88a","font-weight":"bold"});
                }
            } 
            else if (parseFloat(result)<=0) {
                for(var i=0;i<=3;i++){
                    $(nRow).find('td:eq('+i+')').css({"color":"#e74a3b","font-weight":"bold"});
                }
            }
            if(parseFloat(result)<=0 && parseFloat(qtydel)<=0){
                $(nRow).css({"display":"none"});
            }
        },    

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
            var columns = [0];
            $.each(columns, function(idx) {
                // var storebalanceqnt = api
                //     .column(3)
                //     .data()
                //     .reduce(function (a,b) {
                //         var cur_index = api.column(3).data().indexOf(b);
                //         if (api.column(4).data()[cur_index]>0) {
                //             return parseInt(a) + parseInt(b);
                //         }
                //         else { return parseInt(a); }
                //     }, 0);

                    var storebalanceqnt = api
                    .cells( function ( index, data, node ) {
                        return api.row( index ).data().UserIds>0 ?
                            true : false;
                    }, 3 )
                    .data()
                    .reduce( function (a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                // var pendingqnt = api
                //     .column(5)
                //     .data()
                //     .reduce(function (a, b) {
                //             var cur_index = api.column(5).data().indexOf(b);
                //             if (api.column(4).data()[cur_index]>0) {
                //             return parseInt(a) + parseInt(b);
                //         }
                //         else { return parseInt(a); }
                //     }, 0);  

                        var pendingqnt = api
                        .cells( function ( index, data, node ) {
                            return api.row( index ).data().UserIds>0 ?
                                true : false;
                        }, 5 )
                        .data()
                        .reduce( function (a, b) {
                            return parseInt(a) + parseInt(b);
                        }, 0);
                var totalallbalance = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                            var cur_index = api.column(3).data().indexOf(b);
                            if (api.column(4).data()[cur_index]>0) {
                            return parseInt(a) + parseInt(b);
                        }
                        else { return parseInt(a); }
                    }, 0);  
                var quantityondel = api
                    .column(9)
                    .data()
                    .reduce(function (a, b) {
                            var cur_index = api.column(9).data().indexOf(b);
                            if (api.column(4).data()[cur_index]>0) {
                            return parseInt(a) + parseInt(b);
                        }
                        else { return parseInt(a); }
                    }, 0);  
                    
                var total=parseFloat(storebalanceqnt)-parseFloat(pendingqnt); 
                if(parseFloat(total||0)<=0){
                    totalavailableqnt="<h3><p style='font-weight:bold;'>0 "+uom+"</p></h3>";
                }
                else if(parseFloat(total||0)>0){
                    totalavailableqnt="<h3><p style='font-weight:bold;'>"+numformat(total||0)+" "+uom+"</p></h3>";
                }
                $('#avbalanceval').html(totalavailableqnt);
                $('#delbalanceval').html("<h3><p style='font-weight:bold;'>"+numformat(quantityondel||0)+" "+uom+"</p></h3>");
                var maximum=0;
                var maxreturn='';
                var balance=totalallbalance||0;
                var minumumstock=wholemax||0;
                var pendingquantity=pendingqnt||0;
                if(minumumstock>0){
                    var maxc=parseFloat(balance)-parseFloat(minumumstock)-parseFloat(pendingquantity);
                    maximum=maxc>0?maxc:0;
                    maxreturn=maximum>=wholemin?maximum:0;
                }
                //$('#wholesalemaxval').html(numformat(maxreturn));
            });
        },
        });
        // var oTable = $('#stockinfodetail').dataTable(); 
        // oTable.fnDraw(false);
        //refreshtbl();
    });
    //End Open Info Modal
    function refreshtbl()
    {
        var tabletr = $('#stockbalancedatatable').DataTable();tabletr.search('');
        var oTable = $('#stockbalancedatatable').dataTable(); 
        oTable.fnDraw(false);
    }

    function closeInfoModal()
    {
        //var tabletr = $('#stockbalancedatatable').DataTable(); tabletr.search('');
        //var oTable = $('#stockbalancedatatable').dataTable(); 
        //oTable.fnDraw(false);
    }

    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }

    function opendetailmod(itemid,storeid,qtydel){
        if(parseFloat(qtydel)<=0){
            toastrMessage('error',"There is no quantity on delivery","Error");
        }
        else if(parseFloat(qtydel)>0){
            var icode=$('#itemcodeval').text();
            var iname=$('#itemnameval').text();
            var skunum=$('#skunumberval').text();
            var retailv=$('#retailerval').text();
            var wholesalev=$('#wholesaleval').text();
            var wholesaleminv=$('#wholesaleminval').text();
            var wholesalemaxv=$('#wholesalemaxval').text();
            var uom=$('#uomval').text();
            var categoryv=$('#categoryval').text();
            $('#itemcodelbl').text(icode);
            $('#itemnamelbl').text(iname);
            $('#skunumlbl').text(skunum);
            $('#retdellbl').text(retailv);
            $('#wholesaledellbl').text(wholesalev);
            $('#wholmindellbl').text(wholesaleminv);
            $('#wholmaxdellbl').text(wholesalemaxv);
            $('#uomdellbl').text(uom);
            $('#catdellbl').text(categoryv);
            $('#quantityondeliverytbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:true,
                info:false,
                searchHighlight: true,
                "order": [[ 1, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showdeliveredqty/'+itemid+'/'+storeid,
                    type: 'DELETE',
                    dataType: "json",
                },
                columns: [
                    { data: 'DT_RowIndex'},
                    { data: 'SourceStoreName', name: 'SourceStoreName'},
                    { data: 'StoreName', name: 'StoreName'},
                    { data: 'DocumentNumber', name: 'DocumentNumber',
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;" onclick=opentrdoc("'+row.TransferId+'")>'+data+'</a>';
                        } 
                    },
                    { data: 'IssueDoc', name: 'IssueDoc',
                        "render": function ( data, type, row, meta ) {
                            return '<a style="text-decoration:underline;color:blue;" onclick=openissdoc("'+row.IssuesIds+'")>'+data+'</a>';
                        } 
                    },
                    { data: 'DeliveredBy', name: 'DeliveredBy'},
                    { data: 'DeliveredDate', name: 'DeliveredDate'},
                    { data: 'ShipmentQuantity', name: 'ShipmentQuantity',
                        "render": function ( data, type, row, meta ) {
                            return data+"   "+uom;
                        }
                    },
                    { data: 'ShipmentQuantity', name: 'ShipmentQuantity','visible': false},
                    { data: 'IssuesIds', name: 'IssuesIds','visible': false},
                    { data: 'TransferId', name: 'TransferId','visible': false},
                ],
                "footerCallback": function (row,data,start,end,display) {
                    var api = this.api(),data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    var totaldelonqty = api
                        .column(7)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                        $('#totaldeliveredqty').html("<p style='font-weight:bold;'>"+numformat(totaldelonqty||0)+" "+uom+"</p>");
                },
            });
            // var oTable = $('#quantityondeliverytbl').dataTable(); 
            // oTable.fnDraw(false);
            $('#deliveryqtymodal').modal('show'); 
        }
        else{
            toastrMessage('error',"There is no quantity on delivery","Error");
        }
    }

    function opentrdoc(trid){
        var link = "/tr/" + trid;
        window.open(link, 'Transfer', 'width=1200,height=800,scrollbars=yes');
    }

    function openissdoc(issid){
        var link = "/isstr/" + issid;
        window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
    }
</script>   
@endsection