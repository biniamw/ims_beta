@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('DeadStock-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">DS</h3>
                            <ul class="nav nav-tabs" role="tablist">
                                @can('StockBalance-View')
                                <li class="nav-item">
                                    <a class="nav-link active" id="balance-tab" data-toggle="tab" href="#balance" onclick="showBalance()" aria-controls="balance" role="tab" aria-selected="false">DS Balance</a>
                                </li>
                                @endcan
                                @can('HandIn-View')
                                <li class="nav-item">
                                    <a class="nav-link" id="receiving-tab" data-toggle="tab" href="#receiving" onclick="showRec()" aria-controls="receiving" role="tab" aria-selected="true">DS HandIn</a>                               
                                </li>
                                @endcan
                                @can('PullOut-View')
                                <li class="nav-item">
                                    <a class="nav-link" id="balance-tab" data-toggle="tab" href="#sales" onclick="showSales()" aria-controls="sales" role="tab" aria-selected="false">DS PullOut</a>
                                </li>
                                @endcan
                            </ul>
                            @can('HandIn-Add')
                            <div id="recdiv" style="display:none;">
                                <button type="button" class="btn btn-gradient-info btn-sm addbuttonrec" data-toggle="modal">Add</button>
                            </div>
                            @endcan
                            @can('PullOut-Add')
                            <div id="salesdiv" style="display:none;">
                                <button type="button" class="btn btn-gradient-info btn-sm addbuttonsales" data-toggle="modal">Add</button>
                            </div>
                            @endcan
                            @can('StockBalance-View')
                            <div id="salesbalancediv">
                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i class="fas fa-sync-alt"></i></button>
                            </div>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                @can('HandIn-View')
                                <div class="tab-pane active" id="receiving" aria-labelledby="receiving-tab" role="tabpanel" style="display: none;">
                                    <div style="width:98%; margin-left:1%;">
                                        <div>
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>#</th>
                                                        <th>Doc. No.</th>
                                                        <th>Customer Name</th>
                                                        <th>Payment Type</th>
                                                        <th>Source Store/Shop</th>
                                                        <th>Destination Store/Shop</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                                @can('StockBalance-View')
                                <div class="tab-pane active" id="balance" aria-labelledby="balance-tab" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div>
                                            <table id="laravel-datatable-crud-balance" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>SKU Number</th>
                                                        <th>Category</th>
                                                        <th>UOM</th>
                                                        <th>Selling Price</th>
                                                        <th>Available Quantity</th>
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
                                @endcan
                                @can('PullOut-View')
                                <div class="tab-pane active" id="sales" aria-labelledby="sales-tab" role="tabpanel" style="display: none;">
                                    <div style="width:98%; margin-left:1%;">
                                        <div>
                                            <table id="saleslaravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 0%;">Id</th>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 5%;">Doc. No.</th>
                                                        <th style="width: 5%;">Customer Name</th>
                                                        <th style="width: 10%;">Payment Type</th>
                                                        <th style="width: 10%;">Source Store/Shop</th>
                                                        <th style="width: 5%;">Tin No</th>
                                                        <th style="width: 5%;">Destination Store/Shop</th>
                                                        <th style="width: 5%;">Type</th>
                                                        <th style="width: 10%;">Doc/Fs No.</th>
                                                        <th style="width: 10%;">Doc. Date</th>
                                                        <th style="width: 10%;">Status</th>                                                        
                                                        <th style="width: 2%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>
     </div>
     @endcan
     <!--Toast Start-->
    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert" style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!--Toast End-->

    <!--Registration Modal -->
<div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style=" overflow-y: scroll;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="handinmodaltitle">DS HandIn Form</h4>
                <div class="row">
                    <div style="text-align: right;" id="statusdisplay"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()"><span aria-hidden="true">&times;</span></button>
                </div>   
            </div> 
            <form id="Register">
                {{ csrf_field() }}
                <div class="modal-body">
                    <section id="input-mask-wrapper">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Type</label>
                                            <div>
                                                <select class="form-control" name="Type" id="Type" onchange="TypeVal()" data-style="btn btn-outline-secondary waves-effect">
                                                    <option selected disabled value="">Select HandIn type</option>
                                                    <option value="External">External</option>
                                                    <option value="Internal">Internal</option>
                                                </select>
                                                <input type="text" class="form-control" name="TypeEd" id="TypeEd" readonly="true"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="Type-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="supplierdiv" style="display:none;">
                                            <label strong style="font-size: 14px;">Customer</label>
                                            <div id="supplierhiddendiv">
                                                <select class="select2 form-control" name="supplier" id="supplier" onchange="supplierVal()">
                                                    @foreach ($customerSrc as $customerSrc)
                                                        <option value="{{$customerSrc->id}}"> {{$customerSrc->Code}}  ,  {{$customerSrc->Name}}   ,   {{$customerSrc->TinNumber}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" class="form-control" name="tid" id="tid" readonly="true"/>
                                                <input type="hidden" class="form-control" name="receivingId" id="receivingId" readonly="true"/>
                                            </div>
                                            <input type="text" class="form-control" name="suppliered" id="suppliered" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="supplier-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="paymenttypediv" style="display:none;">
                                            <label strong style="font-size: 14px;">Payment Type</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="PaymentType" id="PaymentType" onchange="paymentTypeVal()">
                                                    <option selected disabled value=""></option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="paymentType-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-3 col-md-6 col-sm-12" style="display:none;" id="internaldiv">
                                            <label strong style="font-size: 14px;" id="sourcestorelbl">Source Store/Shop</label>
                                            <div id="srcstore">
                                                <select class="select2 form-control" name="SourceStore" id="SourceStore" onchange="SourceStoreVal()">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($SourceStoreSrc as $SourceStoreSrc)
                                                        <option value="{{$SourceStoreSrc->StoreId}}">{{$SourceStoreSrc->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" class="form-control" name="SourceStoreEd" id="SourceStoreEd" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="sourcestore-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="destinationStr" style="display:none;">
                                            <label strong style="font-size: 14px;" id="destinationstorelbl">Source Store/Shop</label>
                                            <div id="destinationdiv">
                                                <select class="select2 form-control" name="stores" id="stores" onchange="storeVal()">
                                                    <option selected disabled value=""></option>    
                                                    @foreach ($storeSrc as $storeSrc)
                                                        <option value="{{$storeSrc->StoreId}}">{{$storeSrc->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" class="form-control" name="storeEd" id="storeEd" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="store-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="purchasernamediv" style="display:none;">
                                            <label strong style="font-size: 14px;">Purchased By</label>
                                            <div>
                                                <select class="select2 form-control" name="Purchaser" id="Purchaser" onchange="purchaserVal()">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($purchaser as $purchaser)
                                                        <option value="{{$purchaser->username}}">{{$purchaser->username}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="purchaser-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" style="display:none;" id="handindatediv">
                                            <label strong style="font-size: 14px;">Date</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" id="date" name="date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="dateVal()"/>
                                            </div>
                                            <input type="text" class="form-control" name="dateed" id="dateed" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="date-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12" style="display:none;" id="handinmemodiv">
                                            <label strong style="font-size: 14px;">Memo</label>
                                            <div class="input-group input-group-merge">
                                                <textarea type="text" placeholder="Write Memo here..." class="form-control" rows="2" name="Memo" id="Memo" onkeyup="memoVal()"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error"></strong>
                                            </span>
                                        </div> 
                                    </div>    
                                   </div>
              
                                    <div class="card" style="display:none;">
                                        <div class="card-header">
                                            <h6 class="card-title">Supplier Info</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-body" id="infoCardDiv">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <label strong style="font-size: 12px;">Category: </label>
                                                    </td>
                                                    <td>
                                                        <label id="categoryInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label strong style="font-size: 12px;">Name: </label>
                                                    </td>
                                                    <td>
                                                        <label id="nameInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label strong style="font-size: 12px;">TIN #: </label>
                                                    </td>
                                                    <td>
                                                        <label id="tinInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label strong style="font-size: 12px;">VAT #: </label>
                                                    </td>
                                                    <td>
                                                        <label id="vatInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="divider">
                                        <div class="divider-text">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="itembodyhandin">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="dynamicTable" class="mb-0 rtable" style="width:100%;display: none;">  
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th>Item Name</th>
                                                <th>UOM</th>
                                                <th>Selling Price</th>
                                                <th id="qtyonhand">Qty. On Hand</th>
                                                <th>Quantity</th>
                                                <th>Unit Cost</th>
                                                <th>Total Cost</th>
                                                <th></th>
                                            </tr>
                                        </table>
                                        <div id="receivingdiv" style="display: none;">
                                            <table id="receivingEditTable" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%">  
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>#</th>
                                                        <th>HeaderId</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>SKU Number</th>
                                                        <th>UOM</th>
                                                        <th>Selling Price</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Cost</th>
                                                        <th>Total Cost</th>
                                                        <th style="width: 15%;">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        <table class="mb-0" id="dynamicbuttonsdiv" style="display: none;">
                                            <tr>
                                                <td>
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                    <button type="button" name="addhold" id="addhold" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newholdmodal" onclick="getheaderId();"><i data-feather='plus'></i> Add New</button>
                                                    <button type="button" name="addreceiving" id="addreceiving" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newholdmodal" onclick="getReceivingHeader();"><i data-feather='plus'></i> Add New</button>
                                                <td>
                                            </tr>
                                        </table>
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-xl-9 col-lg-12"></div>
                                                <div class="col-xl-3 col-lg-12">
                                                    <table style="width:103%;text-align:right" id="pricingTable" class="rtable">
                                                        <tr>
                                                            <td style="text-align: right;width:45%"><label strong style="font-size: 14px;">Total Cost</label></td>
                                                            <td style="text-align: center; width:55%">
                                                                <label id="subtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                <input type="hidden" placeholder="" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0"/>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: right;"><label strong style="font-size: 14px;">No. of Items</label></td>
                                                            <td style="text-align: center;"><label id="numberofItemsLbl" strong style="font-size: 14px; font-weight: bold;">0</label></td>
                                                        </tr>
                                                        <tr style="display:none;">
                                                            <td style="text-align: right;" colspan="2">
                                                                <div class="form-check form-check-inline" id="printgrvdiv">
                                                                    <label class="form-check-label" for="printGRVCBX">Print GRV : </label>
                                                                    <input class="form-check-input" name="printGRVCBX" type="checkbox" id="printGRVCBX" checked />
                                                                    <input type="hidden" placeholder="" class="form-control" name="checkboxVali" id="checkboxVali" readonly="true" value=""/>
                                                                </div>
                                                            </td>
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
                <div class="modal-footer">
                    <div style="display:none;">
                        <select class="select2 form-control allitems" data-style="btn btn-outline-secondary waves-effect" name="allitems" id="allitems">
                            <option selected disabled value=""></option>
                            <option selected disabled value=""></option>
                            @foreach ($storelists as $storelists)
                                <option title="{{ $storelists->id }}" value=""></option>
                            @endforeach
                            @foreach ($itemSrc as $itemSrc)
                                <option value="{{ $itemSrc->id }}">{{ $itemSrc->Code }}   ,   {{ $itemSrc->Name }}   ,   {{ $itemSrc->SKUNumber }}</option>
                            @endforeach 
                        </select>
                        <select class="select2 form-control eNamehandin" data-style="btn btn-outline-secondary waves-effect" name="eNamehandin" id="itemhandinfooter">
                            <option selected disabled value=""></option>
                            <option selected disabled value=""></option>
                            @foreach ($storelistsval as $storelistsval)
                                <option title="{{ $storelistsval->id }}" value=""></option>
                            @endforeach
                            @foreach ($itemSrcsl as $itemSrcsl)
                                <option title="{{ $itemSrcsl->StoreId }}" value="{{ $itemSrcsl->ItemId }}">{{ $itemSrcsl->Code }}   ,   {{ $itemSrcsl->ItemName }}   ,   {{ $itemSrcsl->SKUNumber }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <input type="hidden" class="form-control" name="hiddenstorevalsrc" id="hiddenstorevalsrc" readonly="true"/>
                    <input type="hidden" class="form-control" name="hiddenstoreval" id="hiddenstoreval" readonly="true"/>
                    <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                    <input type="hidden" class="form-control" name="witholdMinAmounti" id="witholdMinAmounti" readonly="true"/>
                    <input type="hidden" class="form-control" name="witholdPercenti" id="witholdPercenti" readonly="true"/>
                    <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true"/>
                    <input type="hidden" placeholder="" class="form-control" name="holdnumberi" id="holdnumberi" readonly="true" value=""/>
                    <input type="hidden" placeholder="" class="form-control" name="receivingnumberi" id="receivingnumberi" readonly="true" value=""/>  
                    <input type="hidden" placeholder="" class="form-control" name="receivingStatus" id="receivingStatus" readonly="true" value=""/>  
                    <button id="savebutton" type="button" class="btn btn-info">Save</button>
                    <button id="closebuttonk" type="button" class="btn btn-danger closebutton" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Registation Modal -->

<!--Start Receiving Item Delete modal -->
<div class="modal fade text-left" id="receivingremovemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deletereceivingitemform">
                @csrf
                <div class="modal-body">
                    <label strong style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="receivingremoveid" id="receivingremoveid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="receivingremoveheaderid" id="receivingremoveheaderid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="numofitemi" id="numofitemi" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="receivingDelStatus" id="receivingDelStatus" readonly="true">
                        <span class="text-danger">
                            <strong id="uname-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deletereceivingpenbtn" type="button" class="btn btn-info">Delete</button>
                    <button id="deletereceivingbtn" type="button" class="btn btn-info">Delete</button>
                    <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Receiving Item Delete Modal -->

<!--Start add new hold modal -->
<div class="modal fade text-left" id="newholdmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">New Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeHoldAddModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newHoldform">
                @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <table style="width:100%;">
                                    <tr>
                                        <td>
                                            <label strong style="font-size: 14px;">Item Name</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">UOM</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Selling Price</label>
                                        </td>
                                        <td id="internalTdHeader">
                                            <label strong style="font-size: 14px;">Qty. On Hand</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Quantity</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Unit Cost</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Total Cost</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">
                                            <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="addHoldItem" id="addHoldItem" onchange="itemNameHoldVal()" style="width: 30%">
                                                <option selected disabled value=""></option>
                                                @foreach ($itemSrcAddHold as $itemSrcAddHold)
                                                    <option value="{{$itemSrcAddHold->id}}">{{$itemSrcAddHold->Code}}    ,    {{$itemSrcAddHold->Name}}    ,     {{$itemSrcAddHold->SKUNumber}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="form-control" name="itid" id="itid" readonly="true"/>
                                            <input type="hidden" class="form-control" name="receivingidinput" id="receivingidinput" readonly="true"/>
                                            <input type="hidden" class="form-control" name="receIds" id="receIds" readonly="true"/>
                                            <input type="hidden" class="form-control" name="recId" id="recId" readonly="true"/>
                                            <input type="hidden" class="form-control" name="recevingedit" id="recevingedit" readonly="true"/>
                                            <input type="hidden" class="form-control" name="stId" id="stId" readonly="true"/>
                                            <input type="hidden" class="form-control" name="receivingstoreid" id="receivingstoreid" readonly="true"/>
                                            <input type="hidden" class="form-control" name="recSrcStore" id="recSrcStore" readonly="true"/>
                                            <input type="hidden" class="form-control" name="destreceivingstoreid" id="destreceivingstoreid" readonly="true"/>
                                            <input type="hidden" class="form-control" name="sourcestoreid" id="sourcestoreid" readonly="true"/>
                                            <input type="hidden" class="form-control" name="editVal" id="editVal" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="defaultuomi" id="defaultuomi" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="newuomi" id="newuomi" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="convertedqi" id="convertedqi" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="convertedamnti" id="convertedamnti" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="itemidi" id="itemidi" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="retailerpricei" id="retailerpricei" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="wholeselleri" id="wholeselleri" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="taxpercenti" id="taxpercenti" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="itemtypei" id="itemtypei" value="0" readonly="true"/>
                                            <input type="hidden" class="form-control" name="SourceStore" id="editinternalStore" value="" readonly="true"/>
                                            <input type="hidden" class="form-control" name="dstocktype" id="dstocktype" value="" readonly="true"/>
                                            <input type="hidden" class="form-control" name="itemidold" id="itemidold" value="" readonly="true"/>
                                        </td>
                                        <td style="width: 10%">
                                            <select id="uoms" class="select2 form-control uoms" onchange="uomsavedVal(this)" name="uoms"></select>
                                        </td>
                                        <td>
                                            <input type="number" name="SellingPrice" placeholder="Selling Price" id="SellingPrice" class="SellingPrice form-control" onkeypress="return ValidateNum(event);" onkeyup="validateSellingPriceVal();" ondrop="return false;" onpaste="return false;" readonly @can('StockBalance-EditPrice') ondblclick="sellingPricePerEd(this)" @endcan/>
                                        </td>
                                        <td id="internalTdBody">
                                            <input type="number" name="quantityOnHand" placeholder="Quantity On Hand" id="quantityOnHand" class="quantityOnHand form-control" onkeyup="CalculateAddHoldTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="validateQuantityVal();" ondrop="return false;" onpaste="return false;" readonly="true"/>
                                        </td>
                                        <td>
                                            <input type="number" name="quantityhold" placeholder="Quantity" id="quantityhold" class="quantityhold form-control" onkeyup="CalculateAddHoldTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="validateQuantityVal();" ondrop="return false;" onpaste="return false;"/>
                                        </td>
                                        <td>
                                            <input type="number" name="unitcosthold" placeholder="Unit Cost" id="unitcosthold" class="unitcosthold form-control" onkeyup="CalculateAddHoldTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="validateUnitcostVal();" ondrop="return false;" onpaste="return false;"/>
                                        </td>
                                        <td>
                                            <input type="number" name="beforetaxhold" placeholder="Total Cost" id="beforetaxhold" class="beforetaxhold form-control"  readonly style="font-weight:bold;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addholdItem-error"></strong>
                                            </span>
                                        </td>
                                        <td></td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="SellingPrice-error"></strong>
                                            </span>
                                        </td>
                                        <td></td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldQuantity-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldunitCost-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldbeforeTax-error"></strong>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button id="savenewreceivingpen" type="button" class="btn btn-info">Save</button>
                    <button id="savenewreceiving" type="button" class="btn btn-info">Save</button>
                    <button id="savenewhold" type="button" class="btn btn-info">Save</button>
                    <button id="closebuttona" type="button" class="btn btn-danger" onclick="closeHoldAddModal()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End add new hold Modal -->

<!--Start Info Modal -->
<div class="modal fade text-left" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">HandIn Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="holdInfo">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Basic & Others Information</span>
                                                        <div id="statustitleshi"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Document Number</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocDocNo" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Type</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocTypes" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Customer Name</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocCustomerName" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Source Store/Shop</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infosourcestore" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Destination Store/Shop</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocReceivingStore" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Payment Type</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocPaymentType" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocDate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Others Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Purchaser Name</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocPurchaserName" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Prepared By</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder" style="font-size: 14px;" id="infoDocholdby" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Created Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infocreateddatelbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Confirmed By</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoConfirmedBy" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Confirmed Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoConfirmedDate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Void By</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infovoidbylbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Void Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infovoiddatelbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Void Reason</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infovoidresonlbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Undo Void By</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoundovoidlbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Undo Void Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infoundovoiddatelbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Memo</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="infomemolbl" strong class="badge badge-success"></label></td>
                                                                                </tr>
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
                                    <input type="hidden" placeholder="" class="form-control" name="statusid" id="statusid" readonly="true">
                                    <label style="font-size: 14px;display:none;" id="infoDocType" strong style="font-size: 12px;"></label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail Information</div>
                        </div>
                        <div class="table-responsive scroll scrdiv">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div>
                                        <div id="infoHoldDiv">
                                            <table id="docInfoItem" class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                                <thead>
                                                    <th>id</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>SKU Number</th>
                                                    <th>UOM</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Before Tax</th>
                                                    <th>Tax Amount</th>
                                                    <th>Total Cost</th>
                                                </thead>
                                            </table>
                                        </div>
                                        <div id="infoRecDiv">
                                            <table id="docRecInfoItem" class="display table-bordered table-striped table-hover dt-responsive">
                                                <thead>
                                                    <th>id</th>
                                                    <th>#</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>SKU Number</th>
                                                    <th>UOM</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total Cost</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-9 col-lg-12 mt-1"></div>
                                <div class="col-xl-3 col-lg-12 mt-1">
                                    <table style="width:100%;" id="infopricingTable" class="rtable">
                                        <tr>
                                            <td style="text-align: right;width:45%;"><label strong style="font-size: 14px;">Total Cost</label></td>
                                            <td style="text-align: center;width:55%;">
                                                <label id="infosubtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                <input type="hidden" placeholder="" class="form-control" name="infosubtotali" id="infosubtotali" readonly="true" value="0"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;"><label strong style="font-size: 14px;">No. of Items</label></td>
                                            <td style="text-align: center;"><label id="infonumberofItemsLbl" strong style="font-size: 14px; font-weight: bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Confirm-HandIn')
                    <button id="confirmreceiving" type="button" onclick="getConfirmInfoConf()" class="btn btn-info">Confirm HandIn</button>
                    @endcan
                    <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Hold Info -->

<!--Start Void modal -->
<div class="modal fade text-left" id="voidreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="voidreasonform">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to void HandIn?</label>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Reason</div>
                    </div>
                    <label strong style="font-size: 16px;"></label>
                    <div class="form-group">
                        <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="Reason" id="Reason" onkeyup="voidReason()" autofocus></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="voidid" id="voidid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="vstatus" id="vstatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="vtype" id="vtype" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="voidbtnpen" type="button" class="btn btn-info">Void</button>
                    <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                    <button id="closebuttoni" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReason()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Void modal -->

<!--Start undo void modal -->
<div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="undovoidform">
                @csrf
                <div class="modal-body" style="background-color:#f6c23e">
                    <label strong style="font-size: 16px;font-weight:bold;">Do you really want to undo void HandIn?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="ustatus" id="ustatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="undovoidbtnpen" type="button" class="btn btn-info">Undo Void</button>
                    <button id="undovoidbtn" type="button" class="btn btn-info">Undo Void</button>
                    <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End undo void modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="stockInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">DS Balance Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                            <th><label strong style="font-size: 14px;">Selling Price</label></th>
                                            <th><label strong style="font-size: 14px;">Max Cost</label></th>
                                        </tr>
                                        <tr>
                                            <td><label id="itemcodeval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="itemnameval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="skunumberval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="categoryval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="uomvals" strong style="font-size: 14px;"></label></td>
                                            <td><label id="sellingpricevals" strong style="font-size: 14px;"></label></td>
                                            <td><label id="maxcostvals" strong style="font-size: 14px;"></label></td>
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
                                            <th>Balance</th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <td colspan="2" style="text-align:right;"><label id="avlbl" strong style="font-size: 16px;">Total Quantity</label></td>
                                            <td><label id="avbalanceval" strong style="font-size: 16px;font-weight: bold;"></label></td>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Info -->

<!--Start Selling Price modal -->
<div class="modal fade text-left" id="sellingPr" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sellingpricetitle">Update Selling Price & Cost</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModals()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="sellingPriceForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group" style="margin-left: 3%;">
                        <div class="row"><label id="itemcodelbl" style="font-size:16px;font-weight:bold;"></label></div>
                        <div class="row"><label id="itemnamelbl" style="font-size:16px;font-weight:bold;"></label></div>
                        <div class="row"><label id="skunumberlbl" style="font-size:16px;font-weight:bold;"></label></div>
                        <div class="row"><label id="maxcostlbl" style="font-size:16px;font-weight:bold;"></label></div>
                    </div>
                   
                    <div class="form-group" style="display: none;">
                         <label strong style="font-size: 16px;">Cost</label>
                        <input type="number" name="Cost" placeholder="Cost" id="Cost" class="Cost form-control" onkeyup="maxcVal()" onkeypress="return ValidateNum(event);" onkeydown="validateUnitcostVal();" ondrop="return false;" onpaste="return false;" readonly="true" ondblclick="removedisabled(this)"/>
                        <span class="text-danger">
                            <strong id="mc-error"></strong>
                        </span>
                    </div>
                    <label strong style="font-size: 16px;">Selling Price</label>
                    <div class="form-group">
                        <input type="number" name="SellingPrice" placeholder="Selling Price" id="SellingPrices" class="SellingPrices form-control" onkeyup="sellingPrVal()" onkeypress="return ValidateNum(event);" onkeydown="validateUnitcostVal();" ondrop="return false;" onpaste="return false;"/>
                        <span class="text-danger">
                            <strong id="sp-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="spitemid" id="spitemid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="maxcosthid" id="maxcosthid" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="sellingprbtn" type="button" class="btn btn-info">Update</button>
                    <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeModals()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Selling Price modal -->

<!--Start Sales Section-->

 <!--Registration Modal -->
 <div class="modal fade" id="salesinlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style=" overflow-y: scroll;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="dspomodaltitle">DS PullOut Form</h4>
                <div class="row">
                    <div style="text-align:right;" id="postatusdisplay"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="salescloseModalWithClearValidation()"><span aria-hidden="true">&times;</span></button>
                </div>   
            </div>
                <form id="salesRegister">
                {{ csrf_field() }}
                <div class="modal-body">
                    <section id="salesinput-mask-wrapper">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Type</label>
                                            <div>
                                                <div id="salestypediv">
                                                    <select class="form-control" name="SalesType" id="SalesType" onchange="SalesTypeVal()">
                                                        <option selected disabled value="">Select PullOut type</option>
                                                        <option value="External">External</option>
                                                        <option value="Internal">Internal</option>
                                                        <option value="Disposal">Disposal</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" name="salestypeHidden" id="salestypeHidden" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="SalesType-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="salescustomerdiv" style="display: none;">
                                            <label strong style="font-size: 14px;color" id="destinationlbls">Customer </label>
                                            <input type="hidden" name="id" id="salesid">
                                                <input type="hidden" name="ce" id="salesce">
                                            <div>
                                                <select class="select2 form-control" name="customer" id="salescustomer">
                                                    @foreach ($customerSrcSales as $customerSrcSales)
                                                    <option value="{{$customerSrcSales->id}}">{{$customerSrcSales->Code}}  ,  {{$customerSrcSales->Name}} ,   {{$customerSrcSales->TinNumber}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="salescustomer-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="salesPaymentTypeDiv" style="display: none;">
                                            <label strong style="font-size: 14px;">Payment Type</label>
                                            <div>
                                                <select class="form-control" name="paymentType" id="salespaymentType" onchange="paymenttyperemoveeroor();">
                                                    <option selected disabled value=""></option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="salespaymenttype-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="refrencediv" style="display:none;">
                                            <label strong style="font-size: 14px;">Doc/Fs Number</label>
                                            <div>
                                                <input type="text" placeholder="Document/Fs Number" class="form-control" name="VoucherNumber" id="ReferenceNumber" onkeyup="removeReferenceNumberValidation()" onkeypress="return ValidateOnlyNum(event);"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="referencenumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="salesstorediv" style="display:none;">
                                            <label strong style="font-size: 14px;" id="srclbls">Source Store/Shop</label>
                                            <div id="salessourcestore">  
                                                <select class="select2 form-control" name="store" id="salesstore">  
                                                    <option disabled selected value=""></option>    
                                                    @foreach ($storeSrcSales as $storeSrcSales)
                                                        <option value="{{$storeSrcSales->StoreId}}">{{$storeSrcSales->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="salecounti" id="salessalecounti" readonly="true"/>
                                                <input type="hidden" name="calcutionhide" id="salescalcutionhide" readonly="true"/>
                                            </div>
                                            <input type="text" class="form-control" name="salesStoreHidden" id="salesStoreHidden" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="salesstore-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="destsalesstorediv" style="display:none;">
                                            <label strong style="font-size: 14px;" id="destinationsstorelbls">Destination Store/Shop</label>
                                            <div id="salesdeststore">  
                                                <select class="select2 form-control" name="DestinationStore" id="destsalesstore" onchange="removeDestStoreValidation()">  
                                                    <option disabled selected value=""></option> 
                                                    @foreach ($storedestSrcSales as $storedestSrcSales)
                                                        <option value="{{$storedestSrcSales->StoreId}}">{{$storedestSrcSales->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" class="form-control" name="salesDestinationHidden" id="salesDestinationHidden" readonly="true"/>
                                            <span class="text-danger">
                                                <strong id="destsalesstore-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="podocumentdatediv" style="display: none;">
                                            <label strong style="font-size: 14px;">Document Date</label>
                                            <div>
                                                <input type="text" name="date" id="salesdate" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="removeDateValidation()"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="salesdate-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12" id="pomemodiv" style="display:none;">
                                            <label strong style="font-size: 14px;">Memo</label>
                                            <div>
                                                <textarea type="text" placeholder="Write Memo here..." class="form-control" rows="2" name="Memo" id="salesMemo" onkeyup="salesmemoVal()"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="salesmemo-error"></strong>
                                            </span>
                                        </div> 
                                        </div>
                                              
                                 </div>
                                 <div class="col-xl-3 col-lg-12" style="display:none;">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Customer  Info</h6>
                                        </div>
                                        <div class="card-body" id="salescustomerInfoCardDiv" style="display:none;">
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Name: </label>
                                                <label id="salescname" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Category: </label>
                                                <label id="salesccategory" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row" style="display:none;">
                                                <label strong style="font-size: 12px;">Defualt price: </label>
                                                <label id="salescdefaultPrice" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Tin Number: </label>
                                                <label id="salesctinNumber" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row" style="display:none;">
                                                <label strong style="font-size: 12px;">Vat: </label>
                                                <label id="salescvat" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row" style="display:none;">
                                                <label strong style="font-size: 12px;">Withold: </label>
                                                <label id="salescwithold" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="divider">
                                        <div class="divider-text">-</div>
                                    </div>
                                </div>
                            </div>
                              <div class="row" id="itembody">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="salesdynamicTable" class="mb-0 rtable" style="width:100%;">  
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th>Item Name</th>
                                                <th>UOM</th>
                                                <th id="salesqtyonhand">Qty. On Hand</th>
                                                <th>Quantity</th>
                                                <th id="salesSellingPr">Unit Price</th>
                                                <th id="salesTotalPrice">Total Price</th>
                                                <th></th>
                                            </tr>
                                        </table>
                                        <div id="edittable">
                                            <table id="salesdatatable-crud-childsale" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>Item Code</th>
                                                        <th>Item Name</th>
                                                        <th>SKU Number</th>
                                                        <th>UOM</th>
                                                        <th>Quantity</th>
                                                        <th id="unitpriceTh">Unit Price</th>
                                                        <th id="totalpriceTh">Total Price</th>
                                                        <th style="width: 15%">Action</th>
                                                    </tr>
                                                </thead>    
                                            </table>
                                        </div>
                                        <table class="mb-0" id="podynamicbuttonsdiv">
                                            <tr>
                                                <td>
                                                    <button type="button" name="adds" id="salesadds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                    <button type="button" name="addnew" id="salesaddnew" class="btn btn-success btn-sm"><i data-feather='plus'></i> Add New</button>
                                                    <!-- <button type="button" name="addhold" id="salesaddhold" class="btn btn-success btn-sm" data-toggle="modal" data-target="#salesnewholdmodal" onclick="getheaderId();"><i data-feather='plus'></i> Add New</button>
                                                    <button type="button" name="addreceiving" id="salesaddreceiving" class="btn btn-success btn-sm" data-toggle="modal" data-target="#salesnewholdmodal" onclick="getReceivingHeader();"><i data-feather='plus'></i> Add New</button> -->
                                                <td>
                                            </tr>
                                        </table>
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-xl-9 col-lg-12"></div>
                                                <div class="col-xl-3 col-lg-12">
                                                    <table style="width:103%;text-align:right" id="salespricingTable" class="rtable">
                                                        <tr class="salespricingTr" id="salespricingTr">
                                                            <td style="text-align: right;width:45%"><label strong style="font-size: 14px;">Total Price</label></td>
                                                            <td style="text-align: center; width:55%">
                                                                <label id="salessubtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                                <input type="hidden" placeholder="" class="form-control" name="subtotali" id="salessubtotali" readonly="true" value="0" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: right;"><label strong style="font-size: 14px;">No. of Items</label></td>
                                                            <td style="text-align: center;"><label id="salesnumberofItemsLbl" strong style="font-size: 14px; font-weight: bold;">0</label></td>
                                                        </tr>
                                                        <tr style="display:none;">
                                                            <td style="text-align: right;" colspan="2">
                                                                <div class="form-check form-check-inline" id="salesprintgrvdiv">
                                                                    <label class="form-check-label" for="printGRVCBX">Print GRV : </label>
                                                                    <input class="form-check-input" name="printGRVCBX" type="checkbox" id="salesprintGRVCBX" checked />
                                                                    <input type="hidden" placeholder="" class="form-control" name="checkboxVali" id="salescheckboxVali" readonly="true" value=""/>
                                                                </div>
                                                            </td>
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
                <div class="modal-footer">
                    <div style="display:none;">
                        <select class="select2 form-control eNames" data-style="btn btn-outline-secondary waves-effect" name="eNames" id="itemnamefooter">
                            <option selected disabled value=""></option>
                            @foreach ($itemSrcpo as $itemSrcpo)
                                <option label="{{$itemSrcpo->Balance}}" title="{{ $itemSrcpo->StoreId }}" value="{{ $itemSrcpo->ItemId }}">{{ $itemSrcpo->Code }}   ,   {{ $itemSrcpo->ItemName }}   ,   {{ $itemSrcpo->SKUNumber }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <input type="hidden" class="form-control" name="hiddenstorevalsrcpo" id="hiddenstorevalsrcpo" readonly="true"/>
                    <input type="hidden" class="form-control" name="hiddenstorevalpo" id="hiddenstorevalpo" readonly="true"/>
                    <input type="hidden" class="form-control" name="operationtypespo" id="operationtypespo" readonly="true" value="1"/>
                    <input type="hidden" class="form-control" name="witholdMinAmounti" id="saleswitholdMinAmounti" readonly="true"/>
                    <input type="hidden" class="form-control" name="witholdPercenti" id="saleswitholdPercenti" readonly="true"/>
                    <input type="hidden" class="form-control" name="salesDocNumber" id="salesDocNumber" readonly="true"/>
                    <input type="hidden" class="form-control" name="commonVal" id="salescommonVal" readonly="true"/>
                    <input type="hidden" placeholder="" class="form-control" name="holdnumberi" id="salesholdnumberi" readonly="true" value=""/>
                    <input type="hidden" class="form-control" name="transactionSt" id="transactionSt" readonly="true"/>
                    <input type="hidden" class="form-control" name="salesidval" id="salesidval" readonly="true"/>
                    <button id="salessavebutton" type="button" class="btn btn-info">Save</button>
                    <button id="salesclosebuttonk" type="button" class="btn btn-danger closebutton" onclick="salescloseModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Registation Modal -->

<!-- start item edit form  -->
<div class="modal fade" id="salesIteminlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="salesmyModalLabel333">Add Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeIteminlineFormModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="salesitemRegisterForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <section id="salesinput-mask-wrapper">
                    <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div style="width:98%; margin-left:1%;">
                                    <div class="">
                                <table>
                                    <tr>
                                        <td style="width: 20%">
                                            <label strong style="font-size: 14px;">Item Name</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">UOM</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Qty on Hand</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Quantity</label>
                                        </td>
                                        <td id="unitpriceHeader">
                                            <label strong style="font-size: 14px;">Unit Price</label>
                                        </td>
                                        <td id="totalpriceHeader">
                                            <label strong style="font-size: 14px;">Total Price</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="itemid" id="salesitemid" class="form-control">
                                            <input type="hidden" name="HeaderId" id="salesHeaderId" class="form-control"> 
                                            <input type="hidden" name="storeId" id="salesstoreId" class="form-control"> 
                                            <input type="hidden" name="commonId" id="salescommonId" class="form-control"> 
                                            <select class="selectpicker form-control form-control-lg ItemName" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="ItemName" id="salesItemName" onchange="removeItemNameValidation()">
                                                <option selected value=""></option>
                                                @foreach ($itemSrcs as $storeSrc)                                                   
                                                    <option value="{{$storeSrc->id}}">{{$storeSrc->Code}}, {{$storeSrc->Name}}, {{$storeSrc->SKUNumber}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                       
                                        <td style="width: 10%">
                                            <select id="salesuoms" class="select2 form-control uoms" onchange="uomsavedVal(this)" name="uoms"></select>
                                        </td>
                                        <td>
                                        <input type="text" placeholder="Qty on hand" name="avQuantitiy" id="salesavQuantitiy" class="form-control" readonly /> 
                                        <input type="hidden" placeholder="Qty on hand" name="avQuantitiyh" id="salesavQuantitiyh" class="form-control" readonly /> 
                                        <input type="hidden" placeholder="Qty on hand" name="avQuantitiyhid" id="avQuantitiyhid" class="form-control" readonly /> 
                                        </td>
                                        <td>
                                            <input type="text"  placeholder="Quantity" class="form-control" name="Quantity" id="salesQuantity" onkeyup="SalesCalculateAddHoldTotal(this)" onkeydown="removeQuantityValidation();" onkeypress="return ValidateNum(event);"/>
                                        </td>    
                                        <td id="unitpriceHeaderTd">
                                            <input type="text" placeholder="Unit Price" class="form-control" name="UnitPrice" id="salesUnitPrice" onkeyup="SalesCalculateAddHoldTotal(this)" onkeydown="removeUnitPriceValidation();" onkeypress="return ValidateNum(event);" readonly @can('StockBalance-EditPrice') ondblclick="unitpriceActiveEd(this)" @endcan/>
                                        </td>
                                        <td id="totalpriceHeaderTd">
                                        <input type="text" placeholder="Total Price" name="TotalPrice" id="salesTotalPrice" class="form-control" readonly /> 
                                        
                                        <input type="hidden" class="form-control" name="defaultuomi" id="salesdefaultuomi" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="newuomi" id="salesnewuomi" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="convertedqi" id="salesconvertedqi" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="convertedamnti" id="salesconvertedamnti" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="mainPricei" id="salesmainPricei" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="maxicost" id="salesmaxicost" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="discountiamount" id="salesdiscountiamount" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="triggervalue" id="salestriggervalue" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="Wsaleminamount" id="salesWsaleminamount" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="Rsaleprice" id="salesRsaleprice" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="Wsaleprice" id="salesWsaleprice" value="0" readonly="true"/>


                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="salesItemName-error"></strong>
                                        </span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="salesQuantity-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="salesUnitPrice-error"></strong>
                                            </span>
                                        </td>
                                        
                                        
                                        
                                        <td>
                                            <span class="text-danger">
                                            <strong id="salesTotalPrice-error"></strong>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                       
                    </section>
                </div>
                <div class="modal-footer">
                    <button id="salessavebuttonsaleitempen" type="button" class="btn btn-info">Add</button>
                    <button id="salessavebuttonsaleitem" type="button" class="btn btn-info" style="display: none;">Add</button>
                    <button id="salesclosebutton" type="button" class="btn btn-danger" onclick="closeIteminlineFormModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of item edit form  -->

<!--Start Delete modal -->
<div class="modal fade text-left" id="salesexamplemodal-delete" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="salesmyModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="salescloseModalWithClearValidations()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="salesdeletform" >
                @csrf
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Do you really want to delete these records? </label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="did" id="salesdid">
                        <input type="hidden" placeholder="hhaderid" class="form-control" name="hid" id="saleshid">
                        <span class="text-danger">
                            <strong id="salesuname-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="salesdeleteBtn" type="button" class="btn btn-info">Delete</button>
                    
                    <button id="salesclosebutton" type="button" class="btn btn-danger" onclick="salescloseModalWithClearValidations()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->

</div>

<div class="modal fade text-left" id="receivingcheckmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="removeundoVoucherNumberErrorclose();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="checkreceivingform">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label id="confirmLbl" strong style="font-size: 16px;font-weight:bold;">Do you really want to void PullOut?</label>
                    </div>
                    <div id="voidDiv">
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label strong style="font-size: 16px;"></label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="PulloutReason" id="PulloutReason" onkeyup="salesvoidReason()"></textarea>
                            <span class="text-danger">
                                <strong id="salesvoid-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="checkedid" id="checkedid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="checkedst" id="checkedst" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="currentstatus" id="currentstatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="currentstore" id="currentstore" readonly="true">
                    </div>
                    <div class="form-group" id="voucherNumberDive">
                        <label strong style="font-size: 14px;">Enter Voucher Number</label>
                        <input type="number" placeholder="Enter Voucher Number" class="form-control" name="undoVoucherNumber" id="undoVoucherNumber" onkeypress="removeundoVoucherNumberError();" autofocus/>
                            <span class="text-danger">
                                <strong id="undoVoucherNumber-error"></strong>
                            </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="checkedbtnvoid" type="button" class="btn btn-info">Void</button>
                    <button id="checkedbtnunvoid" type="button" class="btn btn-info">Undo Void</button>
                    <!-- <button id="checkedbtnpending" type="button" class="btn btn-info">Change to Pending</button>
                    <button id="checkedbtnsale" type="button" class="btn btn-info">Check Sales</button>
                    <button id="checkedbtnconfirm" type="button" class="btn btn-info">Confirm Sales</button> -->
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeundoVoucherNumberErrorclose();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- End Check Receiving modal --> 

    <!--Start Confimed Receiving modal -->
    <div class="modal fade text-left" id="receivingconfirmedmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmedreceivingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label strong style="font-size: 16px;font-weight:bold;">Do you really want to confirm HandIn?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="confirmid" id="confirmid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="confirmtype" id="confirmtype" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmbtn" type="button" class="btn btn-info">Confirm HandIn</button>
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Confimed Receiving modal -->
    
   <!--Start Info Modal -->
   <div class="modal fade text-left" id="saledocInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">PullOut Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saleholdInfo">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Basic & Others Information</span>
                                                        <div id="statustitles"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Document Number</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfoDocNumber" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Type</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="dsinfotype" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Customer Name</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfoDocCustomerName" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Source Store/Shop</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfoDocsaleShop" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Destination Store/Shop</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="dssalesdestinationstore" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Payment Type</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfoDocPaymentType" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Doc/Fs Number</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfoReferenceNumber" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Document Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfoDocDate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Others Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Prepared By</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfoPrepareddby" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Created Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfoprepareddate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Confirmed By</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfoconfirmedby" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Confirmed Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfoconfirmeddate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Void By</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfovoidby" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Void Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfovoidate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Void Reason</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfovoidreason" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Undo Void By</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfounvoidby" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Undo Void Date</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="saleinfunvoiddate" strong class="badge badge-success"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Memo</label></td>
                                                                                    <td><label class="font-weight-bolder" style="font-size: 14px;" id="salesinfomemo" strong class="badge badge-success"></label></td>
                                                                                </tr>
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
                                    <input type="hidden" placeholder="" class="form-control" name="statusid" id="statusid" readonly="true">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail Information</div>
                        </div>
                        <div class="table-responsive scroll scrdiv"> 
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div> 
                                        <div id="saletable">
                                        <table id="saledocInfosaleItem" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <th></th>
                                                <th>#</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>SKU #</th>
                                                <th>Quantity</th>                                         
                                                <th>Unit Price</th>                                           
                                                <th>Total Price</th>
                                            </thead>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-9 col-lg-12 mt-1"></div>
                                <div class="col-xl-3 col-lg-12 mt-1">
                                    <table style="width:100%;" id="saleinfopricingTable" class="rtable">
                                        <tr>
                                            <td style="text-align: right;width:45%"><label strong style="font-size: 14px;">Total Price</label></td>
                                            <td style="text-align: center;width:55%">
                                                <label id="saleinfosubtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                <input type="hidden" placeholder="" class="form-control" name="infosubtotali" id="saleinfosubtotali" readonly="true" value="0"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;"><label strong style="font-size: 14px;">No. of Items</label></td>
                                            <td style="text-align: center;"><label id="saleinfonumberofItemsLbl" strong style="font-size: 14px; font-weight: bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" placeholder="" class="form-control" name="infoheaderid" id="infoheaderid" readonly="true">
                    @can('Confirm-PullOut')                    
                    <button id="confirmsales" type="button" class="btn btn-info">Confirm PullOut</button>
                    @endcan
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Start Check Receiving modal -->
<div class="modal fade text-left" id="pulloutconfirmmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pulloutconfirmform">
                {{ csrf_field() }}
                <div class="modal-body" style="background-color:#f6c23e">
                    <label id="confirmLbl" strong style="font-size: 16px;font-weight:bold;">Do you really want to confirm PullOut?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="confirmrecid" id="confirmrecid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="checkedst" id="checkedst" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="currentstatus" id="currentstatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="currentstore" id="currentstore" readonly="true">

                    </div>
                </div>
                <div class="modal-footer">
                    <button id="checkedbtnconfirm" type="button" class="btn btn-info">Confirm PullOut</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeundoVoucherNumberErrorclose();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Check Receiving modal --> 

    <!-- End Hold Info -->
    <script type="text/javascript">
        $(function () {
            cardSection = $('#page-block');
        });

        var errorcolor="#ffcccc";
        //Start page load
        $(document).ready( function () 
        { 
            $('#infoCardDiv').hide();
            $('#mrcDiv').hide();
            $('#itemInfoCardDiv').hide();
            $('#pricingTable').hide();
            $('#changetopending').hide();
            $('#checkreceiving').hide();
            $('#iteminfocard').hide();
            $("#beforetax").attr("disabled", true);
            $("#taxamount").attr("disabled", true);
            $("#total").attr("disabled", true);
            $("#beforetax").css("font-weight","Bold");
            $("#taxamount").css("font-weight","Bold");
            $("#total").css("font-weight","Bold");
            $("#beforetaxhold").css("font-weight","Bold");
            $("#taxamounthold").css("font-weight","Bold");
            $("#totalcosthold").css("font-weight","Bold");
            $('#recId').val("");
            $('#recevingedit').val("");
            $('#internaldiv').hide();
            $('#destsalesstorediv').hide();
            $('#savenewreceiving').hide();
            $('#deletereceivingbtn').hide();
            var today = new Date();
            var dd = today.getDate();
            var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) :  + (today.getMonth()+1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
            //$('#date').val(formatedCurrentDate);
            //$('#salesdate').val(formatedCurrentDate);
            $("#dynamicTable").show();
            $("#adds").show();
            $("#holdEditTable").hide();
            $("#receivingEditTable").hide();
            $("#receivingdiv").hide();
            $("#addhold").hide();
            $("#addreceiving").hide();
            $("#saveHoldbutton").hide();
            $("#savebutton").show();
            $("#holdbutton").show();
            $('#tid').val("");
            $('#receivingId').val("");
            $('#recevingedit').val("");
            $('#editVal').val("0");
            $(".selectpicker").selectpicker({
                noneSelectedText : ''
            });
            $("#printgrvdiv").show();
            $('#laravel-datatable-crud').DataTable(
            {
            responsive: true,
            processing: true,
            serverSide: true,
            searchHighlight: true,
            destroy:true,
            scrollY:'55vh',
            scrollX: true,
            scrollCollapse: true,
            pagingType: "simple",
            order: [[ 1, "desc" ]],
            lengthMenu: [[50, 100], [50, 100]],
            language: { search: '', searchPlaceholder: "Search here"},
            dom: "<'row'<'col-lg-2 col-md-10 col-xs-2'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                ajax: 
                {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/deadstocktable',
                    type: 'DELETE',
                },
                
                columns: [
                    { data: 'id',name: 'id', 'visible': false },
                    { data: 'DT_RowIndex'},
                    { data: 'DocumentNumber',name: 'DocumentNumber',},
                    { data: 'CustomerName',name: 'CustomerName',},
                    { data: 'PaymentType',name: 'PaymentType',},
                    { data: 'Source',name: 'Source',},
                    { data: 'StoreName',name: 'StoreName',},  
                    { data: 'Type',name: 'Type',},
                    { data: 'TransactionDate',name: 'TransactionDate',}, 
                    { data: 'Status',name: 'Status',}, 
                    { data: 'action',name: 'action',}
                ],
                
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
                {
                    if (aData.Status == "Pending/Defective") 
                    {
                        $(nRow).find('td:eq(8)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                    }
                    else if (aData.Status == "Confirmed/Defective") 
                    {
                        $(nRow).find('td:eq(8)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    }
                    else if (aData.Status == "Void") 
                    {
                        $(nRow).find('td:eq(8)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                    }
                },
                
                });

            $('#laravel-datatable-crud-balance').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchHighlight: true,
                "order": [[ 2, "asc" ]],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here" },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/deadstockbalance',
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
                    },
                },
                columns: [
                    { data:'DT_RowIndex'},
                    { data: 'ItemCode', name: 'ItemCode' },
                    { data: 'ItemName', name: 'ItemName' },
                    { data: 'SKUNumber', name: 'SKUNumber' },
                    { data: 'Category', name: 'Category' },
                    { data: 'UOM', name: 'UOM' },
                    { data: 'SellingPrice', name: 'SellingPrice',
                        "render":function (data, type, row, meta){
                            var sellingprice=row.SellingPrice||0;
                            var editablemax=row.dsmaxcosteditable||0;
                            if(data!=null){
                                if(parseFloat(editablemax)>parseFloat(sellingprice)){
                                    return '<span class="badge badge-light-danger">unc</span>';
                                }
                                else{
                                    return numformat(data);
                                }
                            } 
                            else{
                                return data;
                            } 
                        }
                    },
                    { data: 'AvailableQuantity', name: 'AvailableQuantity',render: $.fn.dataTable.render.number(',', '.',0, '')}, 
                    { data: 'dsmaxcost', name: 'dsmaxcost','visible': false},
                    { data: 'dsmaxcosteditable', name: 'dsmaxcosteditable','visible': false},
                    { data: 'action', name: 'action' }
                ],
                });
             
                $('#internaldiv').hide();
                $('#supplierdiv').show();
                $('#paymenttypediv').show();
                $('#purchasernamediv').show();
                $('#Type').show();
                $('#supplierhiddendiv').show();
                $('#date').show();
                $('#srcstore').show();
                $('#destinationdiv').show();
                $('#TypeEd').hide();
                $('#suppliered').hide();
                $('#dateed').hide();
                $('#SourceStoreEd').hide();
                $('#storeEd').hide();
                $('#internalTdHeader').hide();
                $('#internalTdBody').hide();
        });
        //End page load

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#laravel-datatable-crud-balance tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        //Start get cons number value
        $('body').on('click', '.addbuttonrec', function () {
        $("#inlineForm").modal('show');
        $('#tid').val("");
        $('#receivingId').val("");
        $.get("/getDeadStockNum"  , function (data) {
            $('#holdnumberi').val(data.dnumber);
            $('#receivingnumberi').val(data.recnum);
            var dbval=data.DeadStockCount;
            var rnum=(Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
            $('#commonVal').val(rnum+dbval);
        });

        $('#stores').select2
        ({
            placeholder: "Select Destination Store/Shop here",
        });

        $('#SourceStore').select2
        ({
            placeholder: "Select Source Store/Shop here",
        });

        $('#Purchaser').select2
        ({
            placeholder: "Select Purchased By here",
        });

        $("#saveHoldbutton").hide();
        $("#savebutton").show();
        $("#holdbutton").show();
        $("#printgrvdiv").show();
        $('#savebutton').text('Save');
        $('#savebutton').prop( "disabled", false );
        $("#checkboxVali").val("1");
        $('#stores').val(null).trigger('change');
        $('#supplier').val("").trigger('change');
        $('#Type').show();
        $('#supplierhiddendiv').show();
        $('#date').show();
        $('#srcstore').show();
        $('#destinationdiv').show();
        $('#TypeEd').hide();
        $('#suppliered').hide();
        $('#dateed').hide();
        $('#SourceStoreEd').hide();
        $('#storeEd').hide();
        $('#PaymentType').val("");
        var today = new Date();
        var dd = today.getDate();
        var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) :  + (today.getMonth()+1);
        var yyyy = today.getFullYear();
        var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
        //$('#date').val(formatedCurrentDate);
        $("#supplierdiv").hide();
        $("#paymenttypediv").hide();
        $("#handindatediv").hide();
        $("#internaldiv").hide();
        $("#destinationStr").hide();
        $("#purchasernamediv").hide();
        $("#handinmemodiv").hide();
        $("#dynamicTable").hide();
        $("#receivingdiv").hide();
        $("#dynamicbuttonsdiv").hide();
        $("#savebutton").hide();
        $("#statusdisplay").html("");
        $('#operationtypes').val("1");
        $("#savebutton").text("Save");
        $('#savebutton').prop("disabled", false);
        $("#handinmodaltitle").html("Register New HandIn");
        $("#dynamicTable").empty();
        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th id="qtyonhand">Qty. On Hand</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
    });
    //End get cons number value

    var j=0;
    var i=0;
    var m=0;
    $("#adds").click(function()
    {  
        var types=$('#Type').val();
        var srcstores=$('#SourceStore').val();
        var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
        var itemids=$('#itemNameSl'+lastrowcount).val();
        if(types===""||(srcstores===null && types==="Internal")){
            if(types===""){
                $("#Type-error").html("Type field is required");
            }
            if(srcstores===null && types==="Internal"){
                $("#sourcestore-error").html("Source shop/store field is required");
            }
            toastrMessage('error',"Please fill all required fields","Error");
        }
        else if(itemids!==undefined && isNaN(parseFloat(itemids))){
            $('#select2-itemNameSl'+lastrowcount+'-container').parent().css('background-color',errorcolor);
            toastrMessage('error',"Please select item from highlighted field","Error");
        }
        else{
            var totalnumofitem=$('#numberofItemsLbl').text();
            ++i;
            j=parseFloat(totalnumofitem)+1;
            ++m;
            $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals" class="idvals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="width: 25%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control itemName" onchange="itemVal(this)" name="row['+m+'][ItemId]" text="itm'+m+'"><option selected value=""></option></select></td>'+
                '<td><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true"/></td>'+
                '<td><input type="number" name="row['+m+'][SellingPrice]" id="SellingPrice'+m+'" class="SellingPrice form-control" style="font-weight:bold;" onkeyup="CheckValidity(this)" readonly onkeypress="return ValidateNum(event);" @can('StockBalance-EditPrice') ondblclick="sellingPricePer(this)"; @endcan/></td>'+
                '<td id="qtyonhandtd" class="qtyonhandtds"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true"/></td>'+
                '<td><input type="number" name="row['+m+'][Quantity]" placeholder="Quantity" id="quantity'+m+'" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>'+
                '<td><input type="number" name="row['+m+'][UnitCost]" placeholder="Unit Cost" id="unitcost'+m+'" class="unitcost form-control numeral-mask" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetax'+m+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="HandIn" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][DefaultUOMId]" id="DefaultUOMId'+m+'" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][NewUOMId]" id="NewUOMId'+m+'" class="NewUOMId form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][ConversionAmount]" id="ConversionAmount'+m+'" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][ConvertedQuantity]" id="ConvertedQuantity'+m+'" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][Wholeseller]" id="Wholeseller'+m+'" class="Wholeseller form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][tax]" id="tax'+m+'" class="tax form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="width:10%;display:none;"><select id="uom'+m+'" class="select2 form-control uoms" onchange="uomVal(this)" name="row['+m+'][uom]"></select></td>'+
                '<td style="width:2%;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
            '</tr>');
            CalculateGrandTotal(); 
            var rnum= $('#commonVal').val();
            $('.common').val(rnum);
            var sroreidvar = $('#SourceStore').val(); 
            $('.storeid').val(sroreidvar);
            var typ=$('#Type').val(); 
            var arrays=new Array();   
            var opt = '<option selected value=""></option>';
            if(typ==="External")
            { 
                $('#qtyonhand').hide();
                $('.qtyonhandtds').hide();
                //$('#dynamicTable tr td:nth-child(5)').hide();
                var options = $("#allitems > option").clone();
                $('#itemNameSl'+m).append(options); 
                for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        var selectedval=$('#itemNameSl'+k).val();
                        $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#itemNameSl'+m).append(opt);     
                $('#itemNameSl'+m).select2
                ({
                    placeholder: "Select item here",
                });
            }
            else if(typ==="Internal")
            {
                var firstopt = "<option title='"+sroreidvar+"' value=''></option>";
                
                $('#qtyonhand').show();
                $('.qtyonhandtds').show();
                //$('#dynamicTable tr td:nth-child(5)').show();
                var options = $("#itemhandinfooter > option").clone();
                $('#itemNameSl'+m).append(firstopt); 
                $('#itemNameSl'+m).append(options); 
                $("#itemNameSl"+m+" option[title!='"+sroreidvar+"']").remove();
                for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        var selectedval=$('#itemNameSl'+k).val();
                        $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                var secopt="<option selected value=''></option>";
                $('#itemNameSl'+m).append(secopt);  
                $('#itemNameSl'+m).select2
                ({
                    placeholder: "Select item here",
                });
            }
            $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            renumberRows();
        }   
    });

    function CheckValidity(ele) 
    {
        var SellingPrice = $(ele).closest('tr').find('.SellingPrice').val();
        if(parseFloat(SellingPrice)==0)
        {
            $(ele).closest('tr').find('.SellingPrice').val(''); 
        }
        $(ele).closest('tr').find('.SellingPrice').css("background","white");
    }

    function CalculateTotal(ele) 
    {
        var typ=$('#Type').val();
        var cid=$(ele).closest('tr').find('.idvals').val();
        if(typ==="Internal")
        {
            var availableq = $(ele).closest('tr').find('.AvQuantity').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            if(parseFloat(quantity)>parseFloat(availableq))
            {     
                toastrMessage('error',"You cant decrease this amount of quantity","Error");
                $(ele).closest('tr').find('.quantity').val("");
            }
        }
        
        var taxpercent=$(ele).closest('tr').find('.tax').val();
        var unitcost = $(ele).closest('tr').find('.unitcost').val();
        var quantity = $(ele).closest('tr').find('.quantity').val();
        var retailerprice = $(ele).closest('tr').find('.SellingPrice').val();
        var wholeseller = $(ele).closest('tr').find('.Wholeseller').val();
        if(parseFloat(unitcost)==0)
        {
            $(ele).closest('tr').find('.unitcost').val(''); 
        }
        if(parseFloat(quantity)==0)
        {
            $(ele).closest('tr').find('.quantity').val(''); 
        }
        unitcost = unitcost == '' ? 0 : unitcost;
        quantity = quantity == '' ? 0 : quantity;
        retailerprice = retailerprice == '' ? 0 : retailerprice;
        var inputid = ele.getAttribute('id');
        if(inputid==="unitcost"+cid)
        {
            if(parseFloat(retailerprice)>0)
            {
                if(parseFloat(retailerprice)<parseFloat(unitcost))
                {
                    $(ele).closest('tr').find('.unitcost').val("");
                    toastrMessage('error',"Unit cost is greater than selling price","Error");
                }
            }
            $(ele).closest('tr').find('.unitcost').css("background","white");
        }
      
        if(inputid==="quantity"+cid){
            $(ele).closest('tr').find('.quantity').css("background","white");
        }
       

        if (!isNaN(unitcost) && !isNaN(quantity)) 
        {
            var total = parseFloat(unitcost) * parseFloat(quantity);
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
            $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
            if(parseFloat(total)>0){
                $(ele).closest('tr').find('.beforetax').css("background","#efefef");
            }
        }
        var defuom=$(ele).closest('tr').find('.DefaultUOMId').val();
        var newuom=$(ele).closest('tr').find('.NewUOMId').val();
        var convamount=$(ele).closest('tr').find('.ConversionAmount').val();
        var convertedq=parseFloat(quantity)/parseFloat(convamount);
        $(ele).closest('tr').find('.ConvertedQuantity').val(convertedq);
        CalculateGrandTotal();
    }

    function CalculateGrandTotal() 
    {
        var subtotal = 0;
        var tax = 0;
        var grandTotal = 0;
        var witholdam=$('#witholdMinAmounti').val();
        var witholdpr=$('#witholdPercenti').val();
        $.each($('#dynamicTable').find('.beforetax'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                subtotal += parseFloat($(this).val());
            }
        });
        $.each($('#dynamicTable').find('.taxamount'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                tax += parseFloat($(this).val());
            }
        });
        $.each($('#dynamicTable').find('.total'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                grandTotal += parseFloat($(this).val());
            }
        });
        var cc=$('#categoryInfoLbl').text();
        if(parseFloat(subtotal.toFixed(2))>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)
        {
            var st=parseFloat(subtotal.toFixed(2));
            var wp=parseFloat(witholdpr);
            var tt=0;
            var np=0;
            tt=(st*wp)/100;
            np=parseFloat(grandTotal.toFixed(2))-tt;
            $('#witholdingAmntLbl').html(numformat(tt.toFixed(2)));
            $('#witholdingAmntin').val(tt.toFixed(2));
            $('#netpayLbl').html(numformat(np.toFixed(2)));
            $('#netpayin').val(np.toFixed(2));
            if(cc==="Foreigner-Supplier"||cc==="Person")
            {
                $("#witholdingTr").hide();
			    $("#netpayTr").hide();	
            }
            else if(parseFloat(subtotal.toFixed(2))>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)
            {
                $("#witholdingTr").show();
			    $("#netpayTr").show();	
            }
        }
        
        
        $('#subtotali').val(subtotal.toFixed(2));
        $('#grandtotali').val(grandTotal.toFixed(2)); 
        $('#taxi').val(tax.toFixed(2));
        $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
        $('#taxLbl').html(numformat(tax.toFixed(2)));
        $('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));   
    }

    function renumberRows() 
    {
        var ind;
        $('#dynamicTable tr').each(function(index, el)
        {
            $(this).children('td').first().text(index++);
            $('#numberofItemsLbl').html(index-1);
            ind=index-1;
        });
        if (ind==0)
        {
            $('#itemcodeInfoLbl').text("");
            $('#itemInfoLbl').text("");
            $('#itemInfoLbl').text("");
            $('#uomInfoLbl').text("");
            $('#itemCategoryInfoLbl').text("");
            $('#rpInfoLbl').text("");
            $('#wsInfoLbl').text("");
            $('#partNumInfoLbl').text("");
            $('#skuInfoLbl').text("");
            $('#taxInfoLbl').text("");
            $('#itemInfoCardDiv').hide();
            $('#pricingTable').hide();
        }
        else
        {
            $('#itemInfoCardDiv').show();
            $('#pricingTable').show();
        }
    }

    $(document).on('click', '.remove-tr', function()
    {  
        $(this).parents('tr').remove();
        CalculateGrandTotal();
        renumberRows();
        --i;
    });

    //Start Show Item Info
function itemVal(ele) 
{  
    var sid = $(ele).closest('tr').find('.itemName').val();
    var idval = $(ele).closest('tr').find('.idvals').val();
    var arr = [];
    var found = 0;
    $('.itemName').each (function() 
    { 
        var name=$(this).val();
        if(arr.includes(name))
        found++;
        else
        arr.push(name);
    });
    
    if(found) 
    {
        toastrMessage('error',"Item already exist","Error");
        $(ele).closest('tr').find('.itemName').val("0").trigger('change');
        $(ele).closest('tr').find('.SellingPrice').val("");
        $(ele).closest('tr').find('.tax').val("");
        $(ele).closest('tr').find('.uom').empty();
        $(ele).closest('tr').find('.quantity').val("");
        $(ele).closest('tr').find('.beforetax').val("");
        $(ele).closest('tr').find('.taxamount').val("");
        $(ele).closest('tr').find('.total').val("");
        $(ele).closest('tr').find('.AvQuantity').val("");
        $(ele).closest('tr').find('.unitcost').val("");
        CalculateGrandTotal(); 
        $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
    } 
    else
    {
        $.get("/showdsItemInfo" +'/' + sid , function (data) 
        {     
            var len=data.length;
            for(var i=0;i<=len;i++) 
            {  
                var itemCodeVar=(data[i].Code);
                var itemTypeVar=(data[i].Type);
                var itemNameVar=(data[i].Name);
                var itemUOMVar=(data[i].UOM);
                var itemCategoryVar=(data[i].Category);
                var itemRpVar=(data[i].SellingPrice);
                var itemWsVar=(data[i].WholesellerPrice);
                var itemPnVar=(data[i].PartNumber);
                var itemSnVar=(data[i].SKUNumber);
                var itemTaxVar=(data[i].TaxTypeId);
                var dstock=(data[i].DeadStockPrice);    
                $('#itemcodeInfoLbl').text(itemCodeVar);
                $('#itemInfoLbl').text(itemTypeVar);
                $('#itemInfoLbl').text(itemNameVar);
                $('#uomInfoLbl').text(itemUOMVar);
                $('#itemCategoryInfoLbl').text(itemCategoryVar);
                $('#rpInfoLbl').text(itemRpVar);
                $('#wsInfoLbl').text(itemWsVar);
                $('#partNumInfoLbl').text(itemPnVar);
                $('#skuInfoLbl').text(itemSnVar);
                $('#taxInfoLbl').text(itemTaxVar);
                $('#itemInfoCardDiv').show();
                $(ele).closest('tr').find('.ItemType').val(itemTypeVar);
                $(ele).closest('tr').find('.SellingPrice').val(dstock);
                $(ele).closest('tr').find('.tax').val(itemTaxVar);
                $(ele).closest('tr').find('.uom').val(itemUOMVar);
                $(ele).closest('tr').find('.quantity').val("");
                $(ele).closest('tr').find('.beforetax').val("");
                $(ele).closest('tr').find('.taxamount').val("");
                $(ele).closest('tr').find('.total').val("");
                CalculateGrandTotal();
            }           
        });
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getDeadStockUOM/'+sid,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.sid)
                {
                    var defname=data['defuom'];
                    var defid=data['defuomid'];
                    var lastcost=data['lastCost'];
                    var maxprice=data['retailer'];
                    $(ele).closest('tr').find('.unitcost').val(lastcost);
                    $(ele).closest('tr').find('.SellingPrice').val(maxprice);
                    // if(isNaN(parseFloat(lastcost))){
                    //     $(ele).closest('tr').find('.unitcost').css("background",errorcolor);
                    // }
                    if(parseFloat(lastcost)>0){
                        $(ele).closest('tr').find('.unitcost').css("background","white");
                    }
                    // if(isNaN(parseFloat(maxprice))){
                    //     $(ele).closest('tr').find('.SellingPrice').css("background",errorcolor);
                    // }
                    if(parseFloat(maxprice)>0){
                        $(ele).closest('tr').find('.SellingPrice').css("background","#efefef");
                    }
                    var option = "<option selected value='"+defid+"'>"+defname+"</option>";
                    $(ele).closest('tr').find('.uom').append(option);
                    $(ele).closest('tr').find('.DefaultUOMId').val(defid);
                    $(ele).closest('tr').find('.NewUOMId').val(defid);
                    $(ele).closest('tr').find('.ConversionAmount').val("1");
                    var len=data['sid'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var name=data['sid'][i].ToUnitName;
                        var id=data['sid'][i].ToUomID;
                        var option = "<option value='"+id+"'>"+name+"</option>";
                        $(ele).closest('tr').find('.uom').append(option);
                    }
                    $(ele).closest('tr').find('.uom').select2();
                }
            },
        });
        var typ=$('#Type').val();
        if(typ==="Internal")
        {
            var storeidvar = $('#SourceStore').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url:'getDsItemBalance/'+sid,
                type:'DELETE',
                data:formData,
                success:function(data)
                {
                    if(data.sid)
                    {
                        var len=data['sid'].length;
                        for(var i=0;i<=len;i++) 
                        {  
                            var qn="0";
                            var quantitys=(data['sid'][i].AvailableQuantity);
                            var salesquantitys=(data['salesqnt'][i].TotalSalesQuantity);
                            var totalresult=parseFloat(quantitys)-parseFloat(salesquantitys);
                            if(totalresult==null)
                            {
                                qn="0";
                            }
                            else if(parseFloat(totalresult)<=0)
                            {
                                qn="0";
                            }
                            else if(parseFloat(totalresult)>0)
                            {
                                qn=totalresult;
                            }
                            $(ele).closest('tr').find('.AvQuantity').val(qn);   
                        }
                    }
                },
            });
        }
        $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
    }
    
}
//End Show Item Info

//Reset forms or modals starts
function closeModalWithClearValidation() 
{
    $("#Register")[0].reset();
    $('#infoCardDiv').hide();
    $('#itemInfoCardDiv').hide();
    $('#supplier').val(null).trigger('change');
    $('#store').val(null).trigger('change');
    $('#supplier-error').html("");
    $('#paymentType-error').html("");
    $('#voucherType-error').html("");
    $('#voucherNumber-error').html("");
    $('#mrcNumber-error').html("");
    $('#date-error').html("");
    $('#store-error').html("");
    $('#purchaser-error').html("");
    $('#memo-error').html("");
    var today = new Date();
    var dd = today.getDate();
    var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) :  + (today.getMonth()+1);
    var yyyy = today.getFullYear();
    var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
    //$('#date').val(formatedCurrentDate);
    //$('#subtotalLbl').html("0");
    $('#taxLbl').html("0");
    $('#grandtotalLbl').html("0");
    $('#witholdingAmntLbl').html("0");
    $('#netpayLbl').html("0");
    $('#numberofItemsLbl').html("0");
    $('#subtotali').val("0");
    $('#taxi').val("0");
    $('#grandtotali').val("0");
    $("#dynamicTable").empty();
    $('#pricingTable').hide();
    $("#dynamicTable").show();
    $("#adds").show();
    $("#holdEditTable").hide();
    $("#addhold").hide();
    $("#receivingEditTable").hide();
    $("#receivingdiv").hide();
    $("#addreceiving").hide();
    $('#tid').val("");
    $('#PaymentType').val("");
    $('#receivingId').val("");
    $("#savebutton").show();
    $("#printgrvdiv").show();
    $('#Purchaser').val(null).trigger('change');    
    $("#checkboxVali").val("1");
    $('#internaldiv').hide();
    $('#supplierdiv').show();
    $('#paymenttypediv').show();
    $('#purchasernamediv').show();
    $('#Type').show();
    $('#supplierhiddendiv').show();
    $('#date').show();
    $('#srcstore').show();
    $('#destinationdiv').show();
    $('#TypeEd').hide();
    $('#suppliered').hide();
    $('#dateed').hide();
    $('#SourceStoreEd').hide();
    $('#storeEd').hide();
    $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th id="qtyonhand">Qty. On Hand</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
}
//Reset forms or modals ends

//Start get customer info
$(document).ready(function () 
{
    $('#supplier').on ('change', function () 
    {
        var sid = $('#supplier').val();
        var voucherTypeVar = $('#voucherType').val();  
        $.get("/showSupplierInfo" +'/' + sid , function (data) 
        {     
            var len=data.length;
            for(var i=0;i<=len;i++) 
            {  
                var supNameVar=(data[i].Name);
                var supCategoryVar=(data[i].CustomerCategory);
                var supTinNumberVar=(data[i].TinNumber);
                var supVatNumberVar=(data[i].VatNumber);
                $('#nameInfoLbl').text(supNameVar);
                $('#categoryInfoLbl').text(supCategoryVar);
                $('#tinInfoLbl').text(supTinNumberVar);
                $('#vatInfoLbl').text(supVatNumberVar);
                $('#infoCardDiv').show();  
            }           
        });  
    });
});
//End get customer info

//Start UOM Change
function uomVal(ele) 
{
    var uomnewval = $(ele).closest('tr').find('.uom').val();
    $(ele).closest('tr').find('.NewUOMId').val(uomnewval);
    var uomdefval = $(ele).closest('tr').find('.DefaultUOMId').val();
    if(parseFloat(uomnewval)==parseFloat(uomdefval))
    {
        $(ele).closest('tr').find('.ConversionAmount').val("1");
    }
    else if(parseFloat(uomnewval)!=parseFloat(uomdefval))
    {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getDeadStockUOMAmount/'+uomdefval+"/"+uomnewval,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.sid)
                {
                    var amount=data['sid'];
                    $(ele).closest('tr').find('.ConversionAmount').val(amount);
                }
            },
        });
    }
    $(ele).closest('tr').find('.quantity').val("");
    $(ele).closest('tr').find('.ConvertedQuantity').val("");
}
//End UOM change

    //Start save receiving
    $('#savebutton').click(function()
    {
        var optype=$("#operationtypes").val();
        var sup = supplier.value;
        var str = stores.value;          
        var arr = [];
        var found = 0;
        $('.itemName').each (function() 
        { 
            var name=$(this).val();
            
            if(arr.includes(name))
            {
                found++;
            }
            else
            {
                arr.push(name);
            }    
        });
        if(found)
        {
            if(parseFloat(optype)==1){
                $('#savebutton').text('Save');
                $('#savebutton').prop("disabled", false);
            }
            else if(parseFloat(optype)==2){
                $('#savebutton').text('Update');
                $('#savebutton').prop("disabled", false);
            }
            toastrMessage('error',"There is duplicate item","Error");
        }
        else
        {
            var numofitems=$('#numberofItemsLbl').text(); 
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax(
            {
                url:'/saveDeadStock',
                type:'POST',
                data:formData,
                beforeSend:function(){
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
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Updating...');
                        $('#savebutton').prop("disabled", true);
                    }
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
                success:function(data) 
                {
                if(data.errors) 
                {
                    if(data.errors.receivingnumberi)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Document Number already exist"+' <button id="getNewHoldbtn" type="button" class="btn btn-gradient-secondary">Get New Document No.</button>',"Error");
                    }
                    if(data.errors.supplier)
                    {
                        $('#supplier-error').html( data.errors.supplier[0]);
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.errors.PaymentType)
                    {
                        $('#paymentType-error' ).html( data.errors.PaymentType[0] );
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.errors.date)
                    {
                        $('#date-error').html( data.errors.date[0] );
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.errors.stores)
                    {
                        $('#store-error').html( data.errors.stores[0] );
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.errors.SourceStore)
                    {
                        $('#sourcestore-error').html( data.errors.SourceStore[0] );
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.errors.Purchaser)
                    {
                        $('#purchaser-error').html( data.errors.Purchaser[0] );
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.errors.Memo)
                    {
                        $('#memo-error').html( data.errors.Memo[0] );
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Check your inputs","Error");
                    }
                }
                else if(data.errorv2)
                {
                    var error_html = '';
                    var qnt="";
                    var arr = [];
                    for(var k=1;k<=m;k++){
                        var itmid=($('#itemNameSl'+k)).val();
                        if(($('#quantity'+k).val())!=undefined){
                            var qnt=$('#quantity'+k).val();
                            if(isNaN(parseFloat(qnt))||parseFloat(qnt)==0){
                                $('#quantity'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#SellingPrice'+k).val())!=undefined){
                            var sellingpr=$('#SellingPrice'+k).val();
                            if(isNaN(parseFloat(sellingpr))||parseFloat(sellingpr)==0){
                                $('#SellingPrice'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#unitcost'+k).val())!=undefined){
                            var unitc=$('#unitcost'+k).val();
                            if(isNaN(parseFloat(unitc))||parseFloat(unitc)==0){
                                $('#unitcost'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#beforetax'+k).val())!=undefined){
                            var beforetx=$('#beforetax'+k).val();
                            if(isNaN(parseFloat(beforetx))||parseFloat(beforetx)==0){
                                $('#beforetax'+k).css("background", errorcolor);
                            }
                        }
                        if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                            $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                        }
                    }
                    // for(var count = 0; count < data.errorv2.length; count++)
                    // {
                    //     var x=count+1;
                    //     error_html += '<p>'+data.errorv2[count]+'</p>';
                    // }
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                    toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                }
                else if(found)
                {
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                    toastrMessage('error',"There is duplicate item","Error");
                }
                else if(data.dberrors)
                {
                    $('#voucherNumber-error' ).html("The voucher number has already been taken");
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                    toastrMessage('error',"Check your inputs","Error");
                }
                else if(data.emptyerror)
                {
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                        $('#saveHoldbutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                    toastrMessage('error',"Please add atleast one item","Error");
                } 
                else if (data.qnterror) {
                    var singleVal='';
                    var remitems='';
                    var loopedVal='';
                    var indx='';
                    var indxrem='';
                    var count='';
                    var len=data['qnterror'].length;
                    count=data.countedval;

                    $.each(data.countItems, function(index, value) {
                        singleVal=value.ItemName;
                    });

                    $.each(data.countremitems, function(index, value) {
                        remitems=value.RemovedItemName;
                    });
                    loopedVal=singleVal+"</br>"+remitems;
                    toastrMessage('error',"There is no available quantity for</br>"+loopedVal,"Error");
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                        $('#saveHoldbutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                } 
                else if (data.detqnterror) {
                    var singleVal='';
                    var remitems='';
                    var loopedVal='';
                    var indx='';
                    var indxrem='';
                    var count='';
                    var len=data['detqnterror'].length;
                    count=data.countedval;

                    $.each(data.countItems, function(index, value) {
                        singleVal=value.ItemName;
                    });

                    $.each(data.countremitems, function(index, value) {
                        remitems=value.RemovedItemName;
                    });
                    loopedVal=singleVal+"</br>"+remitems;
                    toastrMessage('error',"There is no available quantity for</br>"+loopedVal,"Error");
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                        $('#saveHoldbutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                } 
                else if(numofitems==0)
                {
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                    toastrMessage('error',"You should add atleast one item","Error");
                }
                else if(data.success) 
                {    
                    if(parseFloat(optype)==1){
                        $('#savebutton').text('Save');
                        $('#savebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled", false);
                    }
                    toastrMessage('success',"Successful","Success");
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                    dTable.fnDraw(false);
                    $("#inlineForm").modal('hide');   
                    var cval="";
                    cval=$('#checkboxVali').val();       
                    closeModalWithClearValidation();
                }
            },
            });
        }
    });   
    //End save receiving

    //edit hold modal open
    //$('body').on('click', '.editReceivingRecord', function () {
    //$("body").off("click").on('click','.editHandinRecord',function() {
    function edithandindata(recIdVar) {
        $('.select2').select2();
        var j=0;
        var ty="";
        $("#handinmodaltitle").html("Update HandIn");
        //var recIdVar = $(this).data('id');
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
        $.get("/deadstockedit" +'/' + recIdVar , function (data)
        { 
            var statusvals = data.recData.Status;
            var vt = $(this).data('voucher');
            var sroreidvar="";
            if(statusvals=="Void")
            {
                toastrMessage('error',"Item already exist","Error");
                $('#laravel-datatable-crud').DataTable().ajax.reload();
            }
            else
            {
                $('#receivingId').val(recIdVar);
                $('#inlineForm').modal('show');
                $.get("/deadstockedit" +'/' + recIdVar , function (data) 
                { 
                    $('#receivingnumberi').val(data.recData.DocumentNumber);
                    $('#receivingStatus').val(data.recData.Status);
                    $('#Type').val(data.recData.Type);
                    $('#TypeEd').val(data.recData.Type);
                    //$('#supplier').selectpicker('val',data.recData.CustomerId).trigger('change');
                    $('#supplier').select2('destroy');
                    $('#supplier').val(data.recData.CustomerId).trigger('change').select2();
                    $('#suppliered').val($('#supplier option:selected').text());
                    $('#PaymentType').val(data.recData.PaymentType);
                    $('#date').val(data.recData.TransactionDate);
                    $('#dateed').val(data.recData.TransactionDate);
                    //$('#SourceStore').selectpicker('val',data.recData.SourceStore);
                    $('#SourceStore').select2('destroy');
                    $('#SourceStore').val(data.recData.SourceStore).select2();
                    $('#SourceStoreEd').val($('#SourceStore option:selected').text());
                    //$('#stores').selectpicker('val',data.recData.StoreId);
                    $('#stores').select2('destroy');
                    $('#stores').val(data.recData.StoreId).select2();
                    $('#storeEd').val($('#stores option:selected').text());
                    $('#Memo').val(data.recData.Memo);
                    //$('#Purchaser').selectpicker('val',data.recData.PurchaserName);
                    $('#Purchaser').select2('destroy');
                    $('#Purchaser').val(data.recData.PurchaserName).select2();
                    //$('#subtotalLbl').html(numformat(data.recData.SubTotal));
                    //$('#subtotali').val(data.recData.SubTotal);
                    //$('#numberofItemsLbl').text(data.count);
                    sroreidvar=data.recData.SourceStore;
                    $('#hiddenstoreval').val(data.recData.StoreId);
                    $('#hiddenstorevalsrc').val(data.recData.SourceStore);
                    var sid=data.recData.CustomerId; 
                    var stotal=parseFloat($('#subtotali').val());
                    var withamnt=parseFloat($('#witholdMinAmounti').val());
                    var withprc=parseFloat($('#witholdPercenti').val());
                    $('#Type').show();
                    $('#supplierhiddendiv').show();
                    $('#date').show();
                    $('#srcstore').show();
                    $('#destinationdiv').show();
                    $('#TypeEd').hide();
                    $('#suppliered').hide();
                    $('#dateed').hide();
                    $('#SourceStoreEd').show();
                    $('#storeEd').hide();
                    ty=data.recData.Type;
                    if(ty==="External")
                    {
                        $('#internalTdHeader').hide();
                        $('#internalTdBody').hide();
                        $('#destinationstorelbl').text("Destination Store/Shop"); 
                        $("#supplierdiv").show();
                        $("#paymenttypediv").show();
                        $("#handindatediv").show();
                        $("#destinationStr").show();
                        $("#purchasernamediv").show();
                        $("#handinmemodiv").show();
                        $("#handinmemodiv").show();
                        $('#SourceStore').hide();
                        $('#SourceStoreEd').hide();
                        $('#internaldiv').hide();
                        $('#dynamicbuttonsdiv').show();
                        $('#adds').show();
                        $('#addreceiving').hide();
                        $("#dynamicTable").empty();
                        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th id="qtyonhand" style="display:none;">Qty. On Hand</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
                    }
                    else if(ty==="Internal")
                    {
                        $('#internalTdHeader').show();
                        $('#internalTdBody').show();
                        $('#sourcestorelbl').text("Source Store/Shop");
                        $('#destinationstorelbl').text("Destination Store/Shop"); 
                        $("#supplierdiv").hide();
                        $("#paymenttypediv").hide();
                        $("#handindatediv").show();
                        $("#destinationStr").show();
                        $("#purchasernamediv").hide();
                        $("#handinmemodiv").show();
                        $('#SourceStore').show();
                        $('#SourceStoreEd').hide();
                        $('#internaldiv').show();
                        $('#dynamicbuttonsdiv').show();
                        $('#adds').show();
                        $('#addreceiving').hide();
                        $("#dynamicTable").empty();
                        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th id="qtyonhand">Qty. On Hand</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
                    }
                    if(statusvals==="Pending/Defective"){
                        $("#statusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                    }
                    else if(statusvals==="Confirmed/Defective"){
                        $("#statusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                    }
                    var allselecteditems=[];
                    $.each(data.receivingdt, function(key, value) {
                        ++i;
                        ++m;
                        ++j;
                        var vis="";
                        if(value.ReSerialNm=="Not-Require" && value.ReExpDate=="Not-Require"){
                            vis="none";
                        }
                        else if(value.ReSerialNm==="" && value.ReExpDate===""){
                            vis="none";
                        }
                        else if(value.ReSerialNm=="Require" || value.ReExpDate=="Require"){
                            vis="visible";
                        }
                        $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals" class="idvals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width: 25%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg itemName" onchange="itemVal(this)" name="row['+m+'][ItemId]" text="itm'+m+'">"<option selected disabled value=""></option></select></td>'+
                            '<td><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true" value="'+value.UomName+'"/></td>'+
                            '<td><input type="number" name="row['+m+'][SellingPrice]" id="SellingPrice'+m+'" class="SellingPrice form-control" style="font-weight:bold;" onkeyup="CheckValidity(this)" readonly onkeypress="return ValidateNum(event);" value="'+value.SellingPrice+'" @can('StockBalance-EditPrice') ondblclick="sellingPricePer(this)"; @endcan/></td>'+
                            '<td id="qtyonhandtd" class="qtyonhandtds"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true" value="0"/></td>'+
                            '<td><input type="number" name="row['+m+'][Quantity]" placeholder="Quantity" id="quantity'+m+'" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" value="'+value.Quantity+'" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>'+
                            '<td><input type="number" name="row['+m+'][UnitCost]" placeholder="Unit Cost" id="unitcost'+m+'" class="unitcost form-control numeral-mask" onkeyup="CalculateTotal(this)" value="'+value.UnitCost+'" onkeypress="return ValidateNum(event);"/></td>'+
                            '<td><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetax'+m+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;" value="'+value.BeforeTaxCost+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;" value="'+value.Common+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="'+value.TransactionType+'" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;" value="'+value.ItemType+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;" value="'+value.StoreId+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][DefaultUOMId]" id="DefaultUOMId'+m+'" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][NewUOMId]" id="NewUOMId'+m+'" class="NewUOMId form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][ConversionAmount]" id="ConversionAmount'+m+'" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][ConvertedQuantity]" id="ConvertedQuantity'+m+'" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][Wholeseller]" id="Wholeseller'+m+'" class="Wholeseller form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][tax]" id="tax'+m+'" class="tax form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="width:2%;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                        '</tr>');
                        var opt = '<option selected value="'+value.ItemId+'">'+value.ItemCode+'  ,   '+value.ItemName+'  ,   '+value.SKUNumber+'</option>';
                        if(ty==="External")
                        { 
                            $('#qtyonhand').hide();
                            $('#qtyonhandtd').hide();
                            $('.qtyonhandtds').hide();
                            //$('#dynamicTable tr td:nth-child(5)').hide();
                            var options = $("#allitems > option").clone();
                            $('#itemNameSl'+m).append(options); 
                            for(var k=1;k<=m;k++){
                                if(($('#itemNameSl'+k).val())!=undefined){
                                    var selectedval=$('#itemNameSl'+k).val();
                                    $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                                }
                            }
                            $('#itemNameSl'+m).append(opt);     
                            $('#itemNameSl'+m).select2();
                        }
                        else if(ty==="Internal")
                        {
                            $('#qtyonhand').show();
                            $('#qtyonhandtd').show();
                            $('.qtyonhandtds').show();
                            //$('#dynamicTable tr td:nth-child(5)').show();
                            var options = $("#itemhandinfooter > option").clone();
                            $('#itemNameSl'+m).append(options); 
                            $("#itemNameSl"+m+" option[title!='"+sroreidvar+"']").remove();
                            for(var k=1;k<=m;k++){
                                if(($('#itemNameSl'+k).val())!=undefined){
                                    var selectedval=$('#itemNameSl'+k).val();
                                    $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                                }
                            }
                            $('#itemNameSl'+m).append(opt);     
                            $('#itemNameSl'+m).select2
                            ({
                                placeholder: "Select item here",
                            });
                        }
                        $("#itemNameSl"+m).select2();
                        $('#numberofItemsLbl').text(j);
                        CalculateGrandTotal(); 
                        allselecteditems.push(value.ItemId);
                        $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });

                    if(ty==="Internal"){
                        //Assign quantity on hands on the dynamic table
                        var q=0;
                        var r=0;
                        var sorteditems=allselecteditems.sort();
                        $.each(data.bal, function(key, value) {
                            ++q;
                            var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(2).find('select').val();
                            if(itemids==value.ItemId){
                                var qty=$('#dynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val()||0;
                                var totalqnt="0";
                                var qtyonhand=parseFloat(value.Balance)+parseFloat(qty);
                                if(parseFloat(qtyonhand)<=0){
                                    totalqnt="0";
                                }
                                else if(parseFloat(qtyonhand)>0){
                                    totalqnt=qtyonhand;
                                }
                                else{
                                    totalqnt="0";
                                }
                                $('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val(totalqnt);
                            }
                            ++r;
                        });
                    }
                });
                $('#receivingEditTable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging:false,
                searching:true,
                info:false,
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showrDeadStockDetail/'+recIdVar,
                    type: 'DELETE',
                    dataType: "json",
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
                columns: [
                    { data: 'id', name: 'id', 'visible': false },
                    { data:'DT_RowIndex'},
                    { data: 'HeaderId', name: 'HeaderId' ,'visible': false},
                    { data: 'Code', name: 'Code' },
                    { data: 'ItemName', name: 'ItemName' },
                    { data: 'SKUNumber', name: 'SKUNumber' },
                    { data: 'UOM', name: 'UOM' },
                    { data: 'SellingPrice', name: 'SellingPrice',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    { data: 'Quantity', name: 'Quantity',render: $.fn.dataTable.render.number(',', '.',0, '')},
                    { data: 'UnitCost', name: 'UnitCost',render: $.fn.dataTable.render.number(',', '.', 2, '')},    
                    { data: 'BeforeTaxCost', name: 'BeforeTaxCost',render: $.fn.dataTable.render.number(',', '.', 2, '')},    
                    { data: 'action', name: 'action' }
                ],
                
                });
                $('#operationtypes').val("2");
                $("#savebutton").text("Update");
                $('#savebutton').prop("disabled", false);
                $("#holdbutton").hide();
                $("#dynamicTable").show();
                $("#adds").show();
                $("#holdEditTable").hide();
                $("#addhold").hide();
                $("#pricingTable").show();
                $("#receivingEditTable").hide();
                $("#receivingdiv").hide();
                $("#addreceiving").hide();
                $("#printgrvdiv").hide();
                //var oTable = $('#receivingEditTable').dataTable(); 
                //oTable.fnDraw(false);
                $('#checkboxVali').val('0');
            }
        });
    }
    //end edit hold modal open

    //start edit hold item modal
    $('body').on('click', '.editRecDatas', function () 
    {
        var recItemVar = $(this).data('id');
        var uomname = $(this).data('uom');
        var itemid="";
        var type=$('#Type').val();
        $('#recevingedit').val(recItemVar);
        $('#newholdmodal').modal('show');
        $('#editinternalStore').val($('#SourceStore').val());
        $.get("/deadstockitemedit" +'/' + recItemVar , function (data) 
        { 
            $('#addHoldItem').selectpicker('val',data.recDataId.ItemId);
            $('#itemidold').val(data.recDataId.ItemId);
            $('#quantityhold').val(data.recDataId.Quantity);
            $('#unitcosthold').val(data.recDataId.UnitCost);
            $('#beforetaxhold').val(data.recDataId.BeforeTaxCost);
            $('#SellingPrice').val(data.recDataId.SellingPrice);
            $('#stId').val(data.recDataId.StoreId);
            $('#convertedqi').val(data.recDataId.ConvertedQuantity);
            $('#convertedamnti').val(data.recDataId.ConversionAmount);
            $('#newuomi').val(data.recDataId.NewUOMId);
            $('#defaultuomi').val(data.recDataId.DefaultUOMId);
            $('#editVal').val("1");
            $('#itemidi').val(data.recDataId.ItemId);
            var newuom= $('#newuomi').val();
            var sid=data.recDataId.ItemId;
            $("#uoms").empty();
            var registerForm = $("#newHoldform");
            var formData = registerForm.serialize();
            $.ajax({
                url:'getDeadStockUOM/'+sid,
                type:'DELETE',
                data:formData,
                success:function(data)
                {
                    if(data.sid)
                    {
                        var options = "<option selected value='"+newuom+"'>"+uomname+"</option>";
                        $("#uoms").append(options);
                        var defname=data['defuom'];
                        var defid=data['defuomid'];
                        var option = "<option value='"+defid+"'>"+defname+"</option>";
                        $("#uoms").append(option);
                        var len=data['sid'].length;
                        for(var i=0;i<=len;i++)
                        {
                            var name=data['sid'][i].ToUnitName;
                            var id=data['sid'][i].ToUomID;
                            var option = "<option value='"+id+"'>"+name+"</option>";
                            $("#uoms").append(option); 
                        }
                        $("#uoms").select2();
                    }
                },
            });
            if(type==="Internal")
            {
                var itemid=data.recDataId.ItemId;
                $.ajax({
                    url:'getDsItemBalance/'+itemid,
                    type:'DELETE',
                    data:formData,
                    success:function(data)
                    {
                        if(data.sid)
                        {
                            var len=data['sid'].length;
                            for(var i=0;i<=len;i++) 
                            {  
                                var qn="0";
                                var quantitys=(data['sid'][i].AvailableQuantity);
                                
                                if(quantitys==null)
                                {
                                    qn="0";
                                }
                                else
                                {
                                    qn=quantitys;
                                }
                                $("#quantityOnHand").val(qn); 
                            }
                        }
                    },
                });
            }
        });
        var status=$('#receivingStatus').val();
        if(status==="Pending/Defective")
        {
            $('#savenewreceivingpen').show();
            $('#savenewreceiving').hide();
        }
        else if(status==="Confirmed/Defective")
        {
            $('#savenewreceivingpen').hide();
            $('#savenewreceiving').show();
        }
        var sid=$('#SourceStore').val();
        var dsid=$('#stores').val();
        $('#dstocktype').val($('#Type').val());
        $('#receivingstoreid').val(sid);
        $('#recSrcStore').val(dsid);
        $('#destreceivingstoreid').val(dsid);
        var hid=$('#receivingId').val();
        $('#receIds').val(hid);
        $('#savenewhold').hide();
    });
    //end edit hold item modal

    function itemNameHoldVal() 
    {  
        var sid=$("#addHoldItem").val();
        var type=$("#Type").val();
        $("#uoms").empty();
        $("#quantityhold").val("");
        $("#beforetaxhold").val("");
        var registerForm = $("#newHoldform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getDeadStockUOM/'+sid,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.sid)
                {
                    var retailer=data['retailer'];
                    var wholeseller=data['wholeseller'];
                    var taxper=data['taxpr'];
                    var itemtype=data['itemtype'];
                    var lastcost=data['lastCost'];
                    $("#taxpercenti").val(taxper);
                    $("#SellingPrice").val(retailer);
                    var defname=data['defuom'];
                    var defid=data['defuomid'];
                    var option = "<option selected value='"+defid+"'>"+defname+"</option>";
                    $("#uoms").append(option);
                    $("#defaultuomi").val(defid);
                    $("#newuomi").val(defid);
                    $("#convertedamnti").val("1");
                    $("#itemtypei").val(itemtype);
                    if(lastcost!=null || lastcost!='')
                    {
                        $("#unitcosthold").val(lastcost);
                    }
                    var len=data['sid'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var name=data['sid'][i].ToUnitName;
                        var id=data['sid'][i].ToUomID;
                        var option = "<option value='"+id+"'>"+name+"</option>";
                        $("#uoms").append(option);
                    }
                    $("#uoms").select2();
                }
            },
        });
        $('#editinternalStore').val($('#SourceStore').val());
        
        if(type==="Internal")
        {
            $.ajax({
                url:'getDsItemBalance/'+sid,
                type:'DELETE',
                data:formData,
                success:function(data)
                {
                    if(data.sid)
                    {
                        var len=data['sid'].length;
                        for(var i=0;i<=len;i++) 
                        {  
                            var qn="0";
                            var quantitys=(data['sid'][i].AvailableQuantity);
                            
                            if(quantitys==null)
                            {
                                qn="0";
                            }
                            else
                            {
                                qn=quantitys;
                            }
                            $("#quantityOnHand").val(qn); 
                        }
                    }
                },
            });
        }
        $( '#addholdItem-error' ).html("");
    }

//Start UOM Change
function uomsavedVal(ele) 
{
    var uomnewval =  $('#uoms').val();
    $('#newuomi').val(uomnewval);
    var uomdefval =  $('#defaultuomi').val();
    if(parseFloat(uomnewval)==parseFloat(uomdefval))
    {
        $('#convertedamnti').val("1");
    }
    else if(parseFloat(uomnewval)!=parseFloat(uomdefval))
    {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
            url:'getDeadStockUOMAmount/'+uomdefval+"/"+uomnewval,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.sid)
                {
                    var amount=data['sid'];
                    $('#convertedamnti').val(amount);
                }
            },
        });
    }
    $('#convertedqi').val("");
    $('#quantityhold').val("");
}
//End UOM change

    //Start save new hold record
    $('body').on('click', '#savenewreceiving', function()
        {
            var registerForm = $('#newHoldform');
            var formData = registerForm.serialize();
            $.ajax({
            url:'/savenewdeadstockitem',
                type:'POST',
                data:formData,
                beforeSend:function(){$('#savenewreceiving').text('Saving...');
                    $('#savenewreceiving').prop( "disabled", true );
                },
                success:function(data) {
                    if(data.errors) 
                    {
                        if(data.errors.addHoldItem){
                            $( '#addholdItem-error' ).html( data.errors.addHoldItem[0] );
                        }
                        if(data.errors.quantityhold){
                            $( '#addHoldQuantity-error' ).html( data.errors.quantityhold[0] );
                        }
                        if(data.errors.unitcosthold){
                            $( '#addHoldunitCost-error' ).html( data.errors.unitcosthold[0] );
                        }
                        if(data.errors.SellingPrice){
                            $( '#SellingPrice-error' ).html( data.errors.SellingPrice[0] );
                        }
                        $('#savenewreceiving').text('Save');
                        $('#savenewreceiving').prop( "disabled", false );
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.counterror)
                    {
                        var singleVal='';
                        var loopedVal='';
                        var len=data['counterror'].length;
                        for(var i=0;i<=len;i++) 
                        {  
                            var count=data.countedval;
                            var inc=i+1;
                            singleVal=(data['countItems'][i].ItemName);
                            loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                            $('#savenewreceiving').text('Save');
                            $('#savenewreceiving').prop( "disabled", false );
                            toastrMessage('error',"Please Fill Quantity and Unitcost for "+count+" Items </br>"+loopedVal,"Error");
                            $("#postbgmodal").modal('hide');
                        }   
                    }
                    if(data.dberrors)
                    {
                        $('#addholdItem-error').html("The item has already been taken.");
                        $('#savenewreceiving').text('Save');
                        $('#savenewreceiving').prop( "disabled", false );
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.success) 
                    {    
                        $('#savenewreceiving').text('Save');
                        $('#savenewreceiving').prop( "disabled", false );
                        toastrMessage('success',"Successful","Success");
                        $("#newholdmodal").modal('hide');
                        closeHoldAddModal();
                        var oTable = $('#receivingEditTable').dataTable(); 
                        oTable.fnDraw(false);
                        $('#recId').val("");
                        $('#recevingedit').val("");
                        $('#editVal').val("0");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len=data.PricingVal.length;
                        for(var i=0;i<=len;i++)
                        {
                            
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            var stotal=parseFloat($('#subtotali').val());
                            var cc=$('#categoryInfoLbl').text();        
                        }
                    
                    }
                },
            });
        });
        //Ends save new hold record

        //Start save new hold record
        $('body').on('click', '#savenewreceivingpen', function()
        {
            var registerForm = $('#newHoldform');
            var formData = registerForm.serialize();
            $.ajax({
            url:'/savenewdeadstockitempen',
                type:'POST',
                data:formData,
                beforeSend:function(){$('#savenewreceivingpen').text('Saving...');
                $('#savenewreceivingpen').prop( "disabled", true );
                },
                success:function(data) {
                    if(data.errors) 
                    {
                        if(data.errors.addHoldItem){
                            $( '#addholdItem-error' ).html( data.errors.addHoldItem[0] );
                        }
                        if(data.errors.quantityhold){
                            $( '#addHoldQuantity-error' ).html( data.errors.quantityhold[0] );
                        }
                        if(data.errors.unitcosthold){
                            $( '#addHoldunitCost-error' ).html( data.errors.unitcosthold[0] );
                        }
                        if(data.errors.SellingPrice){
                            $( '#SellingPrice-error' ).html( data.errors.SellingPrice[0] );
                        }
                        $('#savenewreceivingpen').text('Save');
                        $('#savenewreceivingpen').prop( "disabled", false );
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.counterror)
                    {
                        var singleVal='';
                        var loopedVal='';
                        var len=data['counterror'].length;
                        for(var i=0;i<=len;i++) 
                        {  
                            var count=data.countedval;
                            var inc=i+1;
                            singleVal=(data['countItems'][i].ItemName);
                            loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                            $('#savenewreceivingpen').text('Save');
                            $('#savenewreceivingpen').prop( "disabled",false);
                            toastrMessage('error',"Please Fill Quantity and Unitcost for "+count+" Items </br>"+loopedVal,"Error");
                            $("#postbgmodal").modal('hide');
                        }   
                    }
                    if(data.dberrors)
                    {
                        $('#addholdItem-error').html("The item has already been taken.");
                        $('#savenewreceivingpen').text('Save');
                        $('#savenewreceivingpen').prop( "disabled", false );
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.success) 
                    {    
                        $('#savenewreceivingpen').text('Save');
                        $('#savenewreceivingpen').prop( "disabled", false );
                        toastrMessage('success',"Successful","Success");
                        $("#newholdmodal").modal('hide');
                        closeHoldAddModal();
                        var oTable = $('#receivingEditTable').dataTable(); 
                        oTable.fnDraw(false);
                        $('#recId').val("");
                        $('#recevingedit').val("");
                        $('#editVal').val("0");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len=data.PricingVal.length;
                        for(var i=0;i<=len;i++)
                        {
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            var stotal=parseFloat($('#subtotali').val());
                            var cc=$('#categoryInfoLbl').text();        
                        }
                    
                    }
                },
            });
        });
        //Ends save new hold record
           
    function CalculateAddHoldTotal(ele) 
    {
        var taxpercent=$("#taxpercenti").val();
        var quantity = $('#quantityhold').val();
        var unitcost =  $('#unitcosthold').val();
        var retailerprice =$('#retailerpricei').val();
        var wholeseller = $('#wholeselleri').val();
        var qtyonhand = $('#quantityOnHand').val();
        var typevar=$('#dstocktype').val();
        unitcost = unitcost == '' ? 0 : unitcost;
        quantity = quantity == '' ? 0 : quantity;
        qtyonhand = qtyonhand == '' ? 0 : qtyonhand;
        if(parseFloat(unitcost)==0)
        {
            $('#unitcosthold').val(""); 
        }
        if(parseFloat(quantity)==0)
        {
            $('#quantityhold').val("");
        }
        if(typevar==="Internal")
        {
            if(parseFloat(quantity)>parseFloat(qtyonhand))
            {
                toastrMessage('error',"You cant decrease this amount of quantity","Error");
                $('#quantityhold').val("");
                $('#beforetaxhold').val("");
            }
        }
        if (!isNaN(unitcost) && !isNaN(quantity)) 
        {
            var total = parseFloat(unitcost) * parseFloat(quantity);
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            $('#beforetaxhold').val(total.toFixed(2));
            $('#taxamounthold').val(taxamount.toFixed(2));
            $('#totalcosthold').val(linetotal.toFixed(2));
        }
        var defuom= $('#defaultuomi').val();
        var newuom=$('#newuomi').val();
        var convamount=$('#convertedamnti').val();
        var convertedq=parseFloat(quantity)/parseFloat(convamount);
        $('#convertedqi').val(convertedq);
    }

    //Start Resetting modal add hold
    function closeHoldAddModal()
    {
        $("#newHoldform")[0].reset();
        $('#addHoldItem').val(null).trigger('change');
        $('#addholdItem-error').html("");
        $('#addHoldQuantity-error').html("");
        $('#addHoldunitCost-error').html("");
        $('#addHoldbeforeTax-error').html("");
        $('#addHoldTaxAmount-error').html("");
        $('#addHoldTotalAmount-error').html("");
        $('#SellingPrice-error').html("");
        $('#savenewreceiving').hide();
        $('#savenewhold').hide();
        $('#recId').val("");
        $('#recevingedit').val("");
        $('#editVal').val("0");
    }
    //End Resetting modal add hold

    function getReceivingHeader()
    {
        var hid=$('#receivingId').val();
        $('#receivingidinput').val(hid);
        $('#receIds').val(hid);
        var sid=$('#SourceStore').val();
        var dsid=$('#stores').val();
        $('#receivingstoreid').val(sid);
        $('#destreceivingstoreid').val(dsid);
        $('#recSrcStore').val(dsid);
        $('#savenewreceiving').show();
        $('#savenewhold').hide();
        $('#recevingedit').val("");
        $('#editinternalStore').val($('#SourceStore').val());
        var status=$('#receivingStatus').val();
        if(status==="Pending/Defective")
        {
            $('#savenewreceivingpen').show();
            $('#savenewreceiving').hide();
        }
        else if(status==="Confirmed/Defective")
        {
            $('#savenewreceivingpen').hide();
            $('#savenewreceiving').show();
        }
    }

    //Starts Receiving Item Delete Modal With Value 
    $('#receivingremovemodal').on('show.bs.modal',function(event)
    {
        var numofitem=$("#numberofItemsLbl").html();
        $("#numofitemi").val(numofitem);
        $("#receivingDelStatus").val($("#receivingStatus").val());
        var button=$(event.relatedTarget)
        var id=button.data('id');
        var hid=button.data('hid');
        var modal=$(this);
        modal.find('.modal-body #receivingremoveid').val(id);
        modal.find('.modal-body #receivingremoveheaderid').val(hid);
        var st=$("#receivingDelStatus").val();
        if(st==="Pending/Defective")
        {
            $('#deletereceivingpenbtn').show();
            $('#deletereceivingbtn').hide();
        }
        else if(st==="Confirmed/Defective")
        {
            $('#deletereceivingpenbtn').hide();
            $('#deletereceivingbtn').show();
        }
       
    });
    //End Receiving Item Delete Modal With Value

         //Delete Receiving Item Records Starts
    $('#deletereceivingbtn').click(function()
    {
      
        var num= $("#numofitemi").val();
        if(parseFloat(num)==1)
        {
            toastrMessage('error',"You cant remove all items","Error");
        }
        else if(parseFloat(num)>=2)
        {
            var delid = document.forms['deletereceivingitemform'].elements['receivingremoveid'].value;
            var deleteForm = $("#deletereceivingitemform");
            var formData = deleteForm.serialize();
            $.ajax(
            {
                url:'/deletedeadstockitemdata/'+delid,
                type:'DELETE',
                data:formData,
                beforeSend:function(){
                $('#deletereceivingbtn').text('Deleting...');
                $('#deletereceivingbtn').prop( "disabled", true );
                },
                success:function(data)
                {
                    if(data.valerror)
                    {
                        var itemname=$("#ItemName").val();
                        toastrMessage('error',itemname+" have no available quantity","Error");
                        $("#postedRemoveModal").modal('hide');
                        closeSaveNewModal();  
                    }
                    else
                    {
                        $('#deletereceivingbtn').text('Delete');
                        $('#deletereceivingbtn').prop( "disabled", false );
                        toastrMessage('success',"Deleted","Success");
                        var oTable = $('#receivingEditTable').dataTable(); 
                        oTable.fnDraw(false);
                        $("#receivingremovemodal").modal('hide');
                        $('#recId').val("");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len=data.PricingVal.length;
                        for(var i=0;i<=len;i++)
                        {
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#grandtotali').val(data.PricingVal[i].TotalCost);  
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            $('#grandtotalLbl').html(numformat(data.PricingVal[i].TotalCost));   
                            var stotal=parseFloat($('#subtotali').val());
                            var gtotal=parseFloat($('#grandtotali').val());
                        }
                    }
                }
            });
        }
    });
    //Delete Receiving Item Records Ends

    //Delete Receiving Item Records Starts
    $('#deletereceivingpenbtn').click(function()
    {
        var num=$("#numofitemi").val();
        if(parseFloat(num)==1)
        {
            toastrMessage('error',"You cant remove all items","Error");
            $("#receivingremovemodal").modal('hide');
        }
        else if(parseFloat(num)>=2)
        {
            var delid = document.forms['deletereceivingitemform'].elements['receivingremoveid'].value;
            var deleteForm = $("#deletereceivingitemform");
            var formData = deleteForm.serialize();
            $.ajax(
            {
                url:'/deletedeadstockitemdatapen/'+delid,
                type:'DELETE',
                data:formData,
                beforeSend:function(){
                $('#deletereceivingpenbtn').text('Deleting...');
                $('#deletereceivingpenbtn').prop( "disabled", true );
                },
                success:function(data)
                {
                    if(data.valerror)
                    {
                        var itemname=$("#ItemName").val();
                        toastrMessage('error',itemname+" have no available quantity","Error");
                        $("#postedRemoveModal").modal('hide');
                        closeSaveNewModal();  
                    }
                    else
                    {
                        $('#deletereceivingpenbtn').text('Delete');
                        $('#deletereceivingpenbtn').prop( "disabled", false );
                        toastrMessage('success',"Deleted","Success");
                        var oTable = $('#receivingEditTable').dataTable(); 
                        oTable.fnDraw(false);
                        $("#receivingremovemodal").modal('hide');
                        $('#recId').val("");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len=data.PricingVal.length;
                        for(var i=0;i<=len;i++)
                        {
                           
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#grandtotali').val(data.PricingVal[i].TotalCost);      
                            var stotal=parseFloat($('#subtotali').val());
                            var gtotal=parseFloat($('#grandtotali').val());
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            $('#grandtotalLbl').html(numformat(data.PricingVal[i].TotalCost));
                        }
                    }
                }
            });
        }
    });
    //Delete Receiving Item Records Ends


    //Start show receiving doc info
    //$(document).on('click', '.DocDsRecInfo', function(){
    function DocDsRecInfo(recordId){
        //var recordId = $(this).data('id');
        //var statusval = $(this).data('status');
        $("#statusid").val(recordId);
        $.get("/showDeadStockData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.holdHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infoDocType').text(data.holdHeader[i].Type);
                $('#infoDocDocNo').text(data.holdHeader[i].DocumentNumber);
                $('#infoDocCustomerCategory').text(data.holdHeader[i].CustomerCategory);
                $('#infoDocTypes').text(data.holdHeader[i].Type);
                $('#infoDocCustomerName').text(data.holdHeader[i].CustomerName);
                $('#infosourcestore').text(data.holdHeader[i].Sources);
                $('#infoDocPaymentType').text(data.holdHeader[i].PaymentType);
                $('#infoDocReceivingStore').text(data.holdHeader[i].StoreName);
                $('#infoDocPurchaserName').text(data.holdHeader[i].PurchaserName);
                $('#infoDocDate').text(data.holdHeader[i].TransactionDate);
                $('#infoDocholdby').text(data.holdHeader[i].Username);
                $('#infoConfirmedBy').text(data.holdHeader[i].ConfirmedBy);
                $('#infoConfirmedDate').text(data.holdHeader[i].ConfirmedDate);
                $('#infoStatus').text(data.holdHeader[i].Status);
                $('#infoMemo').text(data.holdHeader[i].Memo);
                $('#infocreateddatelbl').text(data.holdHeader[i].created_at);
                $('#infovoidbylbl').text(data.holdHeader[i].VoidedBy);
                $('#infovoiddatelbl').text(data.holdHeader[i].VoidedDate);
                $('#infovoidresonlbl').text(data.holdHeader[i].VoidReason);
                $('#infoundovoidlbl').text(data.holdHeader[i].ChangeToPendingBy);
                $('#infoundovoiddatelbl').text(data.holdHeader[i].ChangeToPendingDate);
                $('#infomemolbl').text(data.holdHeader[i].Memo);
                $('#infosubtotalLbl').html(numformat(data.holdHeader[i].SubTotal));
                $('#infonumberofItemsLbl').text(data.count);
                var st=data.holdHeader[i].Status;  
                var sto=data.holdHeader[i].StatusOld;  
                if(st==="Pending/Defective")
                {
                    $('#confirmreceiving').show();
                    $("#statustitleshi").html("<span style='color:#f6c23e;font-weight:bold;'>Pending/Defective</span>");
                }
                else if(st==="Confirmed/Defective")
                {
                    $('#confirmreceiving').hide();
                    $("#statustitleshi").html("<span style='color:#1cc88a;font-weight:bold;'>Confirmed/Defective</span>");
                }
                else if(st==="Void")
                {
                    $('#confirmreceiving').hide();
                    $("#statustitleshi").html("<span style='color:#e74a3b;font-weight:bold;'>"+st+"("+sto+")</span>");
                }
            }    
        });
        $(".infoscl").collapse('show');
        $('#checkbyth').show();
        $('#checkdateth').show();
        $('#confirmbyth').show();
        $('#confirmdateth').show();
        $('#changetopendingth').show();
        $('#changetopendingdateth').show();
        $('#statusth').show();
        $('#infocheckbytd').show();
        $('#infocheckeddatetd').show();
        $('#infoconfirmbytd').show();
        $('#infoconfirmeddatetd').show();
        $('#infoconchangetopendingtd').show();
        $('#infochangetopendingdatetd').show();
        $('#infostatustd').show();
        $('#docRecInfoItem').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        paging:false,
        searching:true,
        info:false,
        searchHighlight: true,
        "order": [[ 0, "asc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            url: '/showDeadStockDetail/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName' },
            { data: 'SKUNumber', name: 'SKUNumber' },
            { data: 'UOM', name: 'UOM'},
            { data: 'Quantity', name: 'Quantity',render: $.fn.dataTable.render.number(',', '.',0, '')},
            { data: 'UnitCost', name: 'UnitCost',render: $.fn.dataTable.render.number(',', '.', 2, '')},  
            { data: 'BeforeTaxCost', name: 'BeforeTaxCost',render: $.fn.dataTable.render.number(',', '.', 2, '')},  
        ],
        });
        $("#docInfoModal").modal('show');
        $("#docRecInfoItem").show();
        $("#infoRecDiv").show();
        $("#docInfoItem").hide();
        $("#infoHoldDiv").hide();
        // var oTable = $('#laravel-datatable-crud').dataTable(); 
        // oTable.fnDraw(false);
        // var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
        // dTable.fnDraw(false);
    }
    //End show receiving doc info

    //Start Void Modal With Value 
    $('#voidreasonmodal').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var id=button.data('id');
        var statusval=button.data('status');
        var type=button.data('type');
        var modal=$(this);
        modal.find('.modal-body #voidid').val(id);
        modal.find('.modal-body #vstatus').val(statusval);
        modal.find('.modal-body #vtype').val(type);
        modal.find('.modal-body #Reason').val("");
        $("#Reason").focus();
        $('#voidbtn').prop("disabled", false);
        if(statusval==="Pending/Defective")
        {
            $("#voidbtnpen").show();
            $("#voidbtn").hide();
        }
        else if(statusval==="Confirmed/Defective")
        {
            $("#voidbtnpen").hide();
            $("#voidbtn").show();
        }
    });
    //End Void Modal With Value 

    //Start void
    $('body').on('click', '#voidbtn', function()
    {
        var recordId=$('#voidid').val();
        $.get("/showDeadStockRec" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.holdHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                var st=data.holdHeader[i].Status;
                if(st==="Void")
                {
                    toastrMessage('error',"HandIn already voided","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                    dTable.fnDraw(false);
                    $("#voidreasonform")[0].reset();
                }
                else
                {
                    var registerForm = $("#voidreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                    url:'/voidDeadStockReceiving',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
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
                        $('#voidbtn').text('Voiding...');
                        $('#voidbtn').prop( "disabled", true );
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
                    success:function(data) 
                    {
                        if(data.valerror)
                        {
                            var singleVal='';
                            var loopedVal='';
                            var len=data['valerror'].length;
                            for(var i=0;i<=len;i++) 
                            {  
                                var count=data.countedval;
                                var inc=i+1;
                                singleVal=(data['countItems'][i].Name);
                                loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop( "disabled", false );
                                toastrMessage('error',"You cant void "+count+" Item(s) it is issued"+loopedVal,"Error");
                                $("#voidreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable(); 
                                oTable.fnDraw(false);
                                var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                                dTable.fnDraw(false);
                                $("#voidreasonform")[0].reset();
                            }    
                        }
                        if(data.errors) 
                        {
                            if(data.errors.Reason)
                            {
                                $('#void-error' ).html( data.errors.Reason[0] );
                            }
                            toastrMessage('error',"Check your inputs","Error");
                            $('#voidbtn').text('Void');
                            $('#voidbtn').prop( "disabled", false );
                        }
                        if(data.success)
                        {
                            $('#voidbtn').text('Void');
                            toastrMessage('success',"HandIn Voided","Success");
                            $("#voidreasonmodal").modal('hide');
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                            dTable.fnDraw(false);
                            $("#voidreasonform")[0].reset();
                        }
                    },
                    });
                }    
            }    
        });
    });
    //End void


    //Start void
    $('body').on('click', '#voidbtnpen', function()
    {
        var recordId=$('#voidid').val();
        $.get("/showDeadStockRec" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.holdHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                var st=data.holdHeader[i].Status;
                if(st==="Void")
                {
                    toastrMessage('error',"HandIn already voided","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                    dTable.fnDraw(false);
                    $("#voidreasonform")[0].reset();
                }
                else
                {
                    var registerForm = $("#voidreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                    url:'/voidDeadStockReceivingPen',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
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
                        $('#voidbtnpen').text('Voiding...');
                        $('#voidbtnpen').prop( "disabled",true); 
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
                    success:function(data) 
                    {
                        
                        if(data.errors) 
                        {
                            if(data.errors.Reason)
                            {
                                $('#void-error' ).html( data.errors.Reason[0] );
                            }
                            $('#voidbtnpen').text('Void');
                            $('#voidbtnpen').prop( "disabled", false );
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if(data.success)
                        {
                            $('#voidbtnpen').text('Void');
                            toastrMessage('success',"HandIn Voided","Success");
                            $("#voidreasonmodal").modal('hide');
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                            dTable.fnDraw(false);
                            $("#voidreasonform")[0].reset();
                        }
                    },
                    });
                }    
            }    
        });
    });
    //End void

    //Start undo void Modal With Value 
    $('#undovoidmodal').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var id=button.data('id');
        var status=button.data('status');
        var ostatus=button.data('ostatus');
        var modal=$(this);
        modal.find('.modal-body #undovoidid').val(id);
        modal.find('.modal-body #ustatus').val(status);
        modal.find('.modal-body #oldstatus').val(ostatus);
        $('#undovoidbtn').prop( "disabled", false );
        if(ostatus==="Confirmed/Defective")
        {
            $("#undovoidbtnpen").hide();
            $("#undovoidbtn").show();
        }
        else if(ostatus==="Pending/Defective")
        {
            $("#undovoidbtnpen").show();
            $("#undovoidbtn").hide();
        }
    });
    //End undo void Modal With Value 

    //Start undo void
    $('body').on('click', '#undovoidbtn', function()
    {
        $('#undovoidbtn').prop( "disabled", true );
        var statusVal = $("#ustatus").val();
        var oldstatusVal = $("#oldstatus").val();
        var recordId=$('#undovoidid').val();
        $.get("/showDeadStockRec" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.holdHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                var st=data.holdHeader[i].Status;
                var stold=data.holdHeader[i].StatusOld;

                if(st==="Void")
                {
                    var registerForm = $("#undovoidform");
                    var formData = registerForm.serialize();
                    $.ajax({
                    url:'/undoDeadStockVoid',
                        type:'POST',
                        data:formData,
                        beforeSend:function(){
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
                            $('#undovoidbtn').text('Changing...');
                            $('#undovoidbtn').prop( "disabled", true );
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
                        success:function(data) 
                        {
                            if(data.valerror)
                            {
                                var singleVal='';
                                var loopedVal='';
                                var len=data['valerror'].length;
                                for(var i=0;i<=len;i++) 
                                {  
                                    var count=data.countedval;
                                    var inc=i+1;
                                    singleVal=(data['countItems'][i].Name);
                                    loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop( "disabled", false );
                                    toastrMessage('error',"You cant void "+count+" Item(s) it is issued"+loopedVal,"Error");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                                    oTable.fnDraw(false);
                                    var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                                    dTable.fnDraw(false);
                                    $("#voidreasonform")[0].reset();
                                }    
                            }
                            if(data.success) 
                            {
                                $('#undovoidbtn').text('Undo Void');
                                toastrMessage('success',"Successful","Success");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable(); 
                                oTable.fnDraw(false);
                                var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                                dTable.fnDraw(false);
                                $("#undovoidform")[0].reset();
                            }
                        },
                    });
                }
                else if(st!="Void")
                {
                    toastrMessage('error',"HandIn should be Void","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                    dTable.fnDraw(false);
                    $("#undovoidform")[0].reset();
                }
            }    
        });    
    });
    //End undo void

    //Start undo void
    $('body').on('click', '#undovoidbtnpen', function()
    {
        $('#undovoidbtnpen').prop( "disabled", true );
        var statusVal = $("#ustatus").val();
        var oldstatusVal = $("#oldstatus").val();
        var recordId=$('#undovoidid').val();
        $.get("/showDeadStockRec" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.holdHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                var st=data.holdHeader[i].Status;
                var stold=data.holdHeader[i].StatusOld;

                if(st==="Void")
                {
                    var registerForm = $("#undovoidform");
                    var formData = registerForm.serialize();
                    $.ajax({
                    url:'/undoDeadStockVoidPen',
                        type:'POST',
                        data:formData,
                        beforeSend:function(){
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
                            $('#undovoidbtnpen').text('Changing...');
                            $('#undovoidbtnpen').prop( "disabled", true );
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
                        success:function(data) 
                        {
                            if(data.success) 
                            {
                                $('#undovoidbtnpen').text('Undo Void');
                                toastrMessage('success',"Successful","Success");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable(); 
                                oTable.fnDraw(false);
                                var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                                dTable.fnDraw(false);
                                $("#undovoidform")[0].reset();
                            }
                        },
                    });
                }
                else if(st!="Void")
                {
                    toastrMessage('error',"HandIn should be Void","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                    dTable.fnDraw(false);
                    $("#undovoidform")[0].reset();
                }
            }    
        });    
    });
    //End undo void

    //Start Open Info Modal
    $('#stockInfoModal').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var id=button.data('id');
        var code=button.data('code');
        var name=button.data('name');
        var sku=button.data('sku');
        var category=button.data('category');
        var uom=button.data('uom');
        var sellingpr=button.data('sellingp');
        var maxcost=button.data('maxcosts');
        var maxcostedt=button.data('maxcostsedt');
        var totalq=button.data('totalq');
        var modal=$(this);
        modal.find('.modal-body #itemid').val(id);
        modal.find('.modal-body #itemcodeval').text(code);
        modal.find('.modal-body #itemnameval').text(name);
        modal.find('.modal-body #skunumberval').text(sku);
        modal.find('.modal-body #categoryval').text(category);
        modal.find('.modal-body #uomvals').text(uom);
        modal.find('.modal-body #sellingpricevals').text(sellingpr);
        modal.find('.modal-body #maxcostvals').text(maxcost);
        modal.find('.modal-body #avbalanceval').text(totalq+" "+uom);

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
            url: '/showDeadStockDetailInfo/'+id,
            type: 'DELETE',
            },
        columns: [
            { data: 'DT_RowIndex'},
            { data: 'StoreName', name: 'StoreName' },
            { data: 'StoreBalance', name: 'StoreBalance',
                "render": function ( data, type, row, meta ) {
                    var avbalance=data||0;
                    var penqnt=row.PendingQuantity||0;
                    var result=0;
                    result=parseFloat(avbalance)-parseFloat(penqnt);
                    if(parseFloat(result)<=0){
                        return "0";
                    }
                    if(parseFloat(result)>0){
                        return numformat(result)+" "+row.UOM;
                    }
                }
            },
            { data: 'PendingQuantity', name: 'PendingQuantity','visible':false},
            { data: 'UOM', name: 'UOM','visible':false},
        ],
        
        });
        $.fn.dataTable.ext.errMode = 'throw';
        var dTable = $('#stockinfodetail').dataTable(); 
        dTable.fnDraw(false);
    });
     //End Open Info Modal

     $('#sellingPr').on('show.bs.modal',function(event)
     {
        var button=$(event.relatedTarget);
        var id=button.data('id');
        var code=button.data('code');
        var name=button.data('name');
        var sku=button.data('sku');
        var pr=button.data('sellingp');
        var maxcost=button.data('maxcosts');
        var maxcostedt=button.data('maxcostsedt');
        var modal=$(this);
        modal.find('.modal-body #SellingPrices').val(pr);
        modal.find('.modal-body #spitemid').val(id);
        modal.find('.modal-body #Cost').val(maxcostedt);
        modal.find('.modal-body #maxcosthid').val(maxcost);
        modal.find('.modal-body #maxcostlbl').text("Max Cost : "+maxcost);
        modal.find('.modal-body #itemcodelbl').text("Item Code : "+code);
        modal.find('.modal-body #itemnamelbl').text("Item Name : "+name);
        modal.find('.modal-body #skunumberlbl').text("SKU Number : "+sku);
        $("#Cost").prop("readonly",true);
     });

    $('body').on('click', '#sellingprbtn', function()
    {
        var registerForm = $("#sellingPriceForm");
        var formData = registerForm.serialize();
        var cost=$('#Cost').val();
        var sellingpr=$('#SellingPrices').val();
        var maxcost=$('#maxcostlbl').text();
        if(parseFloat(cost)>parseFloat(sellingpr))
        {
            toastrMessage('error',"Cost is greater than selling price","Error");
        }
        else if(parseFloat(maxcost)>parseFloat(sellingpr))
        {
            toastrMessage('error',"Max cost is greater than selling price","Error");
        }
        else
        {
            $.ajax({
            url:'/updateSellingPr',
                type:'POST',
                data:formData,
                beforeSend:function(){$('#sellingprbtn').text('Updating...');},
                success:function(data) {
                    if(data.errors) {
                        if(data.errors.SellingPrice){
                            $('#sp-error').html( data.errors.SellingPrice[0] );
                        }
                        $('#sellingprbtn').text('Update');
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if(data.success) {
                        $('#sellingprbtn').text('Update');
                        toastrMessage('success',"Updated","Success");
                        $("#sellingPr").modal('hide');
                        $("#sellingPriceForm")[0].reset();
                        var oTable = $('#laravel-datatable-crud-balance').dataTable(); 
                        oTable.fnDraw(false);
                        sellingPrVal();
                        maxcVal();
                    }
                },
            });
        }      
    });

     $('#Type').on ('change', function () 
     {
        var type = $('#Type').val();
        if(type==="External")
        {
            $('#internaldiv').hide();
            $('#supplierdiv').show();
            $('#paymenttypediv').show();
            $('#purchasernamediv').show();

        }
        else if(type==="Internal")
        {
            $('#internaldiv').show();
            $('#supplierdiv').hide();
            $('#paymenttypediv').hide();
            $('#purchasernamediv').hide();
        }
     });

    //start quantity check
    function checkQ(ele) 
    {
        var typ=$('#Type').val();
        if(typ==="Internal")
        {
            var availableq = $(ele).closest('tr').find('.AvQuantity').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            if(parseFloat(quantity)>parseFloat(availableq))
            {
                toastrMessage('error',"You cant decrease this amount of quantity","Error");
                $(ele).closest('tr').find('.quantity').val("");
            }
        }
    }
    //end quantity check

    function supplierVal() 
    {
        $( '#supplier-error' ).html("");
    }

    $(function () {
        itemSections = $('#itembodyhandin');
    });

    function SourceStoreVal() 
    {
        // $("#dynamicTable").empty();
        // $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
        var storeid=$("#SourceStore").val();
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/syncDynamicTableds',
            type: 'POST',
            data: formData,
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
            success: function(data) {
                var q=0;
                var totalrow=$('#numberofItemsLbl').text();
                $('.AvQuantity').val("0");
                $.each(data.bal, function(key, value) {
                    ++q;
                    var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(2).find('select').val();
                    if(itemids==value.ItemId){
                        var qtyonhand=value.Balance;
                        var qty=$('#dynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val();
                        $('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val(value.Balance);
                        if(parseFloat(qtyonhand)<parseFloat(qty) || parseFloat(qtyonhand)==0){
                            $('#dynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val("");
                        }
                    }
                });
                for(var y=1;y<=m;y++){
                    var qtyonhand=($('#AvQuantity'+y)).val()||0;
                    var qty=($('#quantity'+y)).val()||0;
                    if(parseFloat(qtyonhand)<parseFloat(qty)|| parseFloat(qtyonhand)==0){
                        $('#quantity'+y).val("");
                        $('#beforetax'+y).val("");
                    }
                }
                CalculateGrandTotal();
            }
        });
        $('#sourcestore-error' ).html("");
        $('#subtotalLbl').html("");
        $('#subtotali').val("");
    }

    function paymentTypeVal() 
    {
        $( '#paymentType-error' ).html("");
    }
    function voucherTypeVal() 
    {
        $( '#voucherType-error' ).html("");
    }
    function voucherNumberval() 
    {
        $( '#voucherNumber-error' ).html("");
    }

    function TypeVal()
    {
        var typ=$('#Type').val();
        if(typ==="External")
        {
            $('#SourceStore').val(null).trigger('change');
            $('#supplier').val("1").trigger('change');
            $('#stores').val(null).trigger('change');
            $('#Purchaser').val(null).trigger('change');
            //$("#dynamicTable").empty();
            //$("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
            //$('#subtotalLbl').html("");
            //$('#subtotali').val("");
            $('#sourcestorelbl').html("0"); 
            $('#destinationstorelbl').text("Destination Store/Shop"); 
            $("#supplierdiv").show();
            $("#paymenttypediv").show();
            $("#handindatediv").show();
            $("#internaldiv").show();
            $("#destinationStr").show();
            $("#purchasernamediv").show();
            $("#srcstore").hide();
            $("#handinmemodiv").show();
            $("#dynamicTable").show();
            $("#receivingdiv").hide();
            $("#dynamicbuttonsdiv").show();
            $("#savebutton").show();
            $("#qtyonhand").hide();
            $("#qtyonhandtd").hide();
            $(".qtyonhandtds").hide();
            $(".AvQuantity").val("0");

        }
        else if(typ==="Internal")
        {
            $('#SourceStore').val(null).trigger('change');
            $('#supplier').val(null).trigger('change');
            $('#stores').val(null).trigger('change');
            $('#Purchaser').val(null).trigger('change');
            //$("#dynamicTable").empty();
            //$("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Selling Price</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Cost</th><th>Total Cost</th><th></th>');
            //$('#subtotalLbl').html("");
            //$('#subtotali').val("");
            $('#sourcestorelbl').text("Source Store/Shop");
            $('#destinationstorelbl').text("Destination Store/Shop"); 
            $("#supplierdiv").show();
            $("#paymenttypediv").hide();
            $("#handindatediv").show();
            $("#internaldiv").show();
            $("#srcstore").show();
            $("#destinationStr").show();
            $("#purchasernamediv").show();
            $("#handinmemodiv").show();
            $("#dynamicTable").show();
            $("#receivingdiv").hide();
            $("#dynamicbuttonsdiv").show();
            $("#savebutton").show();
            $("#qtyonhand").show();
            $("#qtyonhandtd").show();
            $(".qtyonhandtds").show();
            $(".AvQuantity").val("0");
        }
        CalculateGrandTotal();
        $( '#Type-error' ).html("");
    }

    function mrcNumberVal() 
    {
        $( '#mrcNumber-error' ).html("");
    }
    function dateVal() 
    {
        $( '#date-error' ).html("");
    }
    function storeVal() 
    {
        $( '#store-error' ).html("");
    }
    function purchaserVal() 
    {
        $( '#purchaser-error' ).html("");
    }
    function memoVal() 
    {
        $( '#memo-error' ).html("");
    }
    function validateQuantityVal() 
    {
        $( '#addHoldQuantity-error' ).html("");
    }
    function validateUnitcostVal() 
    {
        $( '#addHoldunitCost-error' ).html("");
    }
    function voidReason() 
    {
        $( '#void-error' ).html("");
    }
    function salesvoidReason() 
    {
        $( '#salesvoid-error' ).html("");
    }
    function validateSellingPriceVal() 
    {
        var SellingPrice = $('#SellingPrice').val();
        SellingPrice = SellingPrice == '' ? 0 : SellingPrice;
        if(parseFloat(SellingPrice)==0)
        {
            $('#SellingPrice').val(""); 
        }
        $( '#SellingPrice-error').html("");
    }
    function sellingPrVal() 
    {
        $('#sp-error').html("");
    }
    function maxcVal() 
    {
        $('#mc-error').html("");
    }
    function closeModals(){
        $('#mc-error').html("");
        $('#sp-error').html("");
    }

    function showRec() 
    {
        $('#recdiv').show();
        $('#salesdiv').hide();
        $('#salesbalancediv').hide();
        $('#receiving').show();
        $('#sales').hide();
        $('#balance').hide();
        var dTable = $('#laravel-datatable-crud').dataTable(); 
        dTable.fnDraw(false);
    }

    function showSales() 
    {
        $('#recdiv').hide();
        $('#salesdiv').show();
        $('#salesbalancediv').hide();
        $('#receiving').hide();
        $('#sales').show();
        $('#balance').hide();
        var dTable = $('#saleslaravel-datatable-crud').dataTable(); 
        dTable.fnDraw(false);
    }

    function showBalance() 
    {
        $('#recdiv').hide();
        $('#salesdiv').hide();
        $('#salesbalancediv').show();
        $('#receiving').hide();
        $('#sales').hide();
        $('#balance').show();
        var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
        dTable.fnDraw(false);
    }

    function refreshtbl() 
    {
        var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
        dTable.fnDraw(false);
    }

    function getConfirmInfoConf()
    {
        var stid=$('#statusid').val();
        $('#confirmid').val(stid);
        $('#receivingconfirmedmodal').modal('show');
        $('#confirmbtn').prop("disabled", false );
        $('#confirmtype').val($('#infoDocTypes').text());
    }
    
    //Start change to confirm
    $('body').on('click', '#confirmbtn', function()
    {
        $('#confirmbtn').prop( "disabled", true );
        $('#confirmbtn').text('Confirm');
        var recordId=$('#confirmid').val();
        $.get("/showDeadStockData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.holdHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                var st=data.holdHeader[i].Status;
                var stold=data.holdHeader[i].StatusOld;
                if(st==="Confirmed/Defective")
                {
                    toastrMessage('error',"HandIn already confirmed","Error");
                    $("#receivingconfirmedmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
                else if(st==="Void")
                {
                    toastrMessage('error',"HandIn already voided","Error");
                    $("#receivingconfirmedmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
                else if(st==="Pending/Defective")
                {
                    $('#confirmbtn').prop( "disabled", true );
                    var registerForm = $("#confirmedreceivingform");
                    var formData = registerForm.serialize();
                    $.ajax({
                    url:'/confirmHandInStatus',
                        type:'POST',
                        data:formData,
                        beforeSend:function(){
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
                            $('#confirmbtn').text('Confirming...');
                            $('#confirmbtn').prop( "disabled", true );
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
                        success:function(data) 
                        {
                            if(data.valerror)
                            {
                                var singleVal='';
                                var loopedVal='';
                                var len=data['valerror'].length;
                                for(var i=0;i<=len;i++) 
                                {  
                                    var count=data.countedval;
                                    var inc=i+1;
                                    singleVal=(data['countItems'][i].Name);
                                    loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                    $('#confirmbtn').text('Confirm HandIn');
                                    $('#confirmbtn').prop( "disabled", false );
                                    toastrMessage('error',"There is no available quantity for "+count+"  Items"+loopedVal,"Error");
                                    $("#receivingconfirmedmodal").modal('hide');
                                    $("#docInfoModal").modal('hide');
                                }    
                            }
                            if(data.success) 
                            {
                                $('#confirmbtn').text('Confirm HandIn');
                                toastrMessage('success',"Successful","Success");
                                $("#receivingconfirmedmodal").modal('hide');
                                $("#docInfoModal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable(); 
                                oTable.fnDraw(false);
                                var dTable = $('#laravel-datatable-crud-balance').dataTable(); 
                                dTable.fnDraw(false);
                                $("#itemnamefooter").empty();
                                var registerForm = $("#salesRegister");
                                var formData = registerForm.serialize();
                                $.ajax({
                                    url:'getItemsByDsStore',
                                    type:'DELETE',
                                    data:formData,
                                    success:function(data)
                                    {
                                        if(data.query)
                                        { 
                                            var options = "<option selected disabled value=''></option>";
                                            $("#itemnamefooter").append(options); 
                                            var len=data['query'].length;
                                            for(var i=0;i<=len;i++)
                                            {
                                                var balance=data['query'][i].Balance;
                                                var storeid=data['query'][i].StoreId;
                                                var itemid=data['query'][i].ItemId;
                                                var itemname=data['query'][i].ItemName;
                                                var code=data['query'][i].Code;
                                                var skunum=data['query'][i].SKUNumber;
                                                var option = "<option label='"+balance+"' title='"+storeid+"' value='"+itemid+"'>"+code+'    ,     '+itemname+'    ,   '+skunum+"</option>";
                                                $("#itemnamefooter").append(option); 
                                                $("#itemnamefooter").select2();
                                            } 
                                        }     
                                    },
                                });
                            }
                        },
                    });
                }
            }    
        });    
    });
</script>

<script type="text/javascript">

    $(document).ready( function () 
    {
        $('#saleslaravel-datatable-crud').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        searchHighlight: true,
       "lengthMenu": [50,100],
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        scrollY:'55vh',
        scrollX: true,
        scrollCollapse: true,
        "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
        ajax: {
            url: '/deadstocksalelist',
            type: 'GET',
            },
            columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' }, 
            { data: 'CustomerName', name: 'CustomerName' },      
            { data: 'PaymentType', name: 'PaymentType' },      
            { data: 'StoreName', name: 'StoreName' },
            { data: 'TinNumber', name: 'TinNumber' , 'visible': false },
            { data: 'Name', name: 'Name' },
            { data: 'Type', name: 'Type' }, 
            { data: 'VoucherNumber', name: 'VoucherNumber' },        
            { data: 'CreatedDate', name: 'CreatedDate' }, 
            { data: 'Status', name: 'Status' },           
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Void") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
            }
            else if (aData.Status == "Pending/Removed") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
            }
            else if (aData.Status == "Confirmed/Removed") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
        },
        
        });
     });

        $('#saleslaravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
        
      $('body').on('click', '.addbuttonsales', function () {
        $("#salesid").val("");
        $("#postatusdisplay").html("");
        $("#dspomodaltitle").html("Register New PullOut");
        $("#operationtypespo").val("1");
        $("#salesinlineForm").modal('show');
        $("#salesdatatable-crud-childsale").hide();
        $("#edittable").hide();
        $("#salesdynamicTable").show();
        $("#salesadds").show();
        $("#salesaddnew").hide();
        $("#salestypeHidden").hide();
        $("#salesStoreHidden").hide();
        $("#salesDestinationHidden").hide();
        $("#salestypediv").show();
        $("#salessourcestore").show();
        $("#salesdeststore").show();
        $("#salesidval").val("");
        $("#SalesType").val("");
        var today = new Date();
        var dd = today.getDate();
        var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) :  + (today.getMonth()+1);
        var yyyy = today.getFullYear();
        var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
        //$('#salesdate').val(formatedCurrentDate);

        $.get("/getSalesDeadStockNum" , function (data) 
        {
            $('#salesDocNumber').val(data.recnum);
            var dbval=data.DeadStockCount;
            var rnum=(Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
            $('#salescommonVal').val(rnum+dbval);
        });

        $('#salescustomer').select2
        ({
            placeholder: "Select Customer here",
        });

        $('#salesstore').select2
        ({
            placeholder: "Select Source Store/Shop here",
        });

        $('#destsalesstore').select2
        ({
            placeholder: "Select Destination Store/Shop here",
        });

        $('#salescustomer').val(null).trigger('change');
        $('#destsalesstore').val(null).trigger('change');
        $('#salesstore').val('');
        $('#salespaymentType').val("");
        $('#refrencediv').hide();
        $('#ReferenceNumber').val("");
        $('#salesTotalPrice').show();
        $('#salesSellingPr').show();
        $('#salescustomerdiv').show();
        $('#salesPaymentTypeDiv').show();
        $('#destsalesstorediv').hide();
        $('#salespricingTable').hide();
        $("#salesdynamicTable").empty();
        $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th></th>');
        $('#salescustomerdiv').hide();
        $('#salesPaymentTypeDiv').hide();
        $('#podocumentdatediv').hide();
        $('#refrencediv').hide();
        $('#salesstorediv').hide();
        $('#pomemodiv').hide();
        $('#salesdynamicTable').hide();
        $('#podynamicbuttonsdiv').hide();
        $('#salesdatatable-crud-childsale').hide();
        $('#salessavebutton').hide();
        $('#salessavebutton').text('Save');
        $('#salessavebutton').prop("disabled", false);
     });

     $("#salesaddnew").on('click', function() {

        var hid=$('#salesid').val();
        var storeid=$('#salesstore').val();
        var commonVal=$('#salessalecounti').val();
        $("#salesIteminlineForm").modal('show');
        $("#salesitemRegisterForm")[0].reset();
        $('#salesstoreId').val(storeid); 
        $('#salesHeaderId').val(hid);
        $('#salescommonId').val(commonVal);
        $('#salesitemid').val("");
        var status=$('#transactionSt').val();
        if(status==="Confirmed/Removed")
        {
            $('#salessavebuttonsaleitempen').hide();
            $('#salessavebuttonsaleitem').show();
        }
        else if(status==="Pending/Removed")
        {
            $('#salessavebuttonsaleitempen').show();
            $('#salessavebuttonsaleitem').hide();
        }
     });

    var i = 0;
    var j=0;
    var m=0;
    $("#salesadds").on('click', function() {
        var types=$("#SalesType").val();
        var srcstores=$("#salesstore").val();
        var lastrowcount=$('#salesdynamicTable tr:last').find('td').eq(21).find('input').val();
        var itemids=$('#salesitemNameSl'+lastrowcount).val();

        if(types===""||isNaN(parseFloat(srcstores))){
            if(types===""){
                $("#SalesType-error").html("Type field is required");
            }
            if(isNaN(parseFloat(srcstores))){
                $("#salesstore-error").html("Source shop/store field is required");
            }
            toastrMessage('error',"Please fill all required fields","Error");
        }
        else if(itemids!==undefined && itemids===null){
            $('#select2-salesitemNameSl'+lastrowcount+'-container').parent().css('background-color',errorcolor);
            toastrMessage('error',"Please select item from highlighted field","Error");
        }
        else{
            var totalnumofitem=$('#salesnumberofItemsLbl').text();
            ++i;
            ++m
            j=parseFloat(totalnumofitem)+1;    
            $("#salesdynamicTable").append('<tr id="salesrow'+m+'" class="dynamic-added"><td style="font-weight:bold;width:3;text-align:center;">'+j+'</td>'+
                '<td style="width: 25%;"><select id="salesitemNameSl'+m+'" class="select2 form-control eName" onchange="itemValSales(this)" name="row['+m+'][ItemId]">"<option selected disabled value=""></option></select></td>'+
                '<td style="width:10%;"><input type="text" name="row['+m+'][uom]" placeholder="" id="salesuom'+m+'" class="uomn form-control" readonly="true"/></td>'+
                '<td><input type="text" name="row['+m+'][AvQuantity]" id="salesAvQuantity'+m+'" class="AvQuantity form-control"  readonly/></td>'+
                '<td><input type="text" name="row['+m+'][Quantity]" placeholder="Quantity" id="salesquantity'+m+'" class="quantity form-control" onkeyup="SalesCalculateTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="ValidQuantity(this)"/></td>'+
                '<td style="width:15%"><input type="text" name="row['+m+'][UnitPrice]" placeholder="Unit Price" id="salesunitprice'+m+'" class="unitprice form-control" onkeyup="SalesCalculateTotal(this)" readonly onkeypress="return ValidateNum(event);" @can('StockBalance-EditPrice') ondblclick="unitpriceActive(this)"; @endcan /></td>'+
                '<td style="width: 15%;"><input type="text" name="row['+m+'][TotalPrice]" id="salestotal'+m+'" class="total form-control"  style="font-weight:bold;" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="salesstoreappend'+m+'" class="storeappend form-control" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="salescommon'+m+'" class="salescommon form-control" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="salesTransactionType'+m+'" class="TransactionType form-control" value="PullOut" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="salesItemType'+m+'" class="ItemType form-control" value="Goods" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][DefaultUOMId]" id="salesDefaultUOMId'+m+'" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][NewUOMId]" id="salesNewUOMId'+m+'" class="NewUOMId form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][ConversionAmount]" id="salesConversionAmount'+m+'" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;" value="1"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][ConvertedQuantity]" id="salesConvertedQuantity'+m+'" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][mainPrice]" id="salesmainPrice'+m+'" class="mainPrice form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][maxCost]" id="salesmaxCost'+m+'" class="maxCost form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][DiscountAmount]" id="salesdiscountamount'+m+'" class="discountamount form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][wholesaleminamount]" id="saleswholesaleminamount'+m+'" class="wholesaleminamount form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][retailprice]" id="salesretailprice'+m+'" class="retailprice form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][wholesaleprice]" id="saleswholesaleprice'+m+'" class="wholesaleprice form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row['+m+'][maxcosteditable]" id="maxcosteditable" class="maxcosteditable form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="idvalss" id="idvalss'+m+'" class="idvalss form-control" readonly="true" value="'+m+'" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][AvQuantityh]" id="salesAvQuantityh'+m+'" class="AvQuantityh form-control"  readonly/></td>'+
                '<td style="display:none;width:10%"><select id="salesuom'+m+'" class="select2 form-control uom" onchange="uomVal(this)" name="row['+m+'][uom]"></select></td>'+
                '<td><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
            '</tr>');
            var type=$('#SalesType').val();
            if(type=='Internal' || type=='Disposal')
            {
                $('#salesdynamicTable tr td:nth-child(6)').show(); 
                $('#salesdynamicTable tr td:nth-child(7)').show(); 
                $('#salesSellingPr').hide();
                $('#salesTotalPrice').hide();
                $('#salespricingTr').show();
            }
            else
            {
                $('#salesdynamicTable tr td:nth-child(6)').show(); 
                $('#salesdynamicTable tr td:nth-child(7)').show();
                $('#salesSellingPr').show();
                $('#salesTotalPrice').show();
                $('#salespricingTr').show();
            }
            var opt = '<option selected disabled value=""></option>';
            var sc= $('#salescommonVal').val();
            $('.salescommon').val(sc);
            var sroreidvar=$('#salesstore').val();
            $('.storeappend').val(sroreidvar); 

            var options = $("#itemnamefooter > option").clone();
            $('#salesitemNameSl'+m).append(options);
            $("#salesitemNameSl"+m+" option[title!='"+sroreidvar+"']").remove(); 
            $("#salesitemNameSl"+m+" option[label=0]").remove();
            $('#salesitemNameSl'+m).append(opt);
            for(var k=1;k<=m;k++){
                if(($('#salesitemNameSl'+k).val())!=undefined){
                    var selectedval=$('#salesitemNameSl'+k).val();
                    $("#salesitemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                }
            }
            $('#salesitemNameSl'+m).append(opt);  
            $('#salesitemNameSl'+m).select2
            ({
                placeholder: "Select Item here",
            });
            $('#select2-salesitemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            salesrenumberRows();
            $('#salespricingTable').show();
        }
    }); 

    $(document).on('click', '.remove-tr', function(){  
            --j;
        $(this).parents('tr').remove();
        SalesCalculateGrandTotal();
        salesrenumberRows();
    }); 

    function salesrenumberRows()
    {
        var ind;
        $('#salesdynamicTable tr').each(function(index, el)
        {
            $(this).children('td').first().text(index++);
            $('#salesnumberofItemsLbl').html(index-1);
            $('#salesnumbercounti').val(index-1);
            ind=index-1      
        });
    }
    
    function itemValSales(ele) 
    {
        var sid = $(ele).closest('tr').find('.eName').val();
        var idval = $(ele).closest('tr').find('.idvalss').val();
        $(ele).closest('tr').find('.quantity').val('');
        $(ele).closest('tr').find('.total').val('');
        var sellingpr = $(ele).closest('tr').find('.unitprice').val();
        var maxcostedit = $(ele).closest('tr').find('.maxcosteditable').val();
        var salestypes = $('#SalesType').val();
        var storeval = salesstore.value;
        var arr = [];
        var found = 0;
        $('.eName').each (function() 
        { 
            var name=$(this).val();
            if(arr.includes(name))
            found++;
            else
            arr.push(name);
        });
        
        if(found) 
        {
            toastrMessage('error',"Item already exist","Error");
            $(ele).closest('tr').find('.eName').val("0").trigger('change');
            $(ele).closest('tr').find('.uom').val("");
            $(ele).closest('tr').find('.AvQuantity').val("");
            $(ele).closest('tr').find('.quantity').val("");
            $(ele).closest('tr').find('.unitprice').val("");
            $(ele).closest('tr').find('.total').val("");
            $('#select2-salesitemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
            SalesCalculateGrandTotal();
        }
        else
        {
            if(sid!=null)
            {
                $.get("/showItemInfodead" +'/' + sid +'/'+ storeval, function(data) {            
                    if(data.Regitem)
                    {
                        var len=data['Regitem'].length;
                        for(var i=0;i<=len;i++)
                        {
                            var itemRpVar=data['Regitem'][i].DeadStockPrice;
                            var itemname=data['Regitem'][i].Name;
                            var uoms=data['Regitem'][i].UOM;
                            var maxcosts=data['Regitem'][i].dsmaxcost;
                            var maxcostsedt=data['Regitem'][i].dsmaxcosteditable;   
                            var conquantity=data['getQuantity'][i].AvailableQuantity||0;
                            var penquantity=data['getPenQuantity'][i].PendingQuantity||0;
                            var avalaiblequantity=parseFloat(conquantity)-parseFloat(penquantity); 
                            if(salestypes==="Internal"||salestypes==="Disposal"){
                                $(ele).closest('tr').find('.unitprice').val("");
                                $(ele).closest('tr').find('.unitprice').css("background","#efefef");
                            }
                            else if(salestypes==="External"){
                                $(ele).closest('tr').find('.unitprice').val(itemRpVar);
                                $(ele).closest('tr').find('.unitprice').css("background","white");
                            }
                            $(ele).closest('tr').find('.uomn').val(uoms);
                            $(ele).closest('tr').find('.mainPrice').val(itemRpVar);
                            if(parseFloat(maxcostsedt)>parseFloat(itemRpVar))
                            {
                                toastrMessage('error',"Cost is greater than price for "+itemname+"</br>Please adjust in DS Balance","Error");
                                $(ele).closest('tr').find('.eName').val("0").trigger('change');
                                $(ele).closest('tr').find('.uom').val("");
                                $(ele).closest('tr').find('.AvQuantity').val("");
                                $(ele).closest('tr').find('.quantity').val("");
                                $(ele).closest('tr').find('.unitprice').val("");
                                $(ele).closest('tr').find('.total').val("");
                                SalesCalculateGrandTotal();
                            }
                            else if(parseFloat(avalaiblequantity)>0)
                            { 
                                $(ele).closest('tr').find('.AvQuantity').val(avalaiblequantity);
                                $(ele).closest('tr').find('.AvQuantityh').val(avalaiblequantity);
                            } 
                            else if(avalaiblequantity==null|| parseFloat(avalaiblequantity)<=0)
                            { 
                                $(ele).closest('tr').find('.AvQuantity').val('0');
                            }
                        }
                    }
                });
            $(ele).closest('tr').find('.uom').empty();
            $.ajax({
            url:'saleUOMSdead/'+sid,
            type:'DELETE',
            data:'',
            success:function(data)
            {
                if(data.sid)
                {
                    var defname=data['defuom'];
                    var defid=data['uomid'];
                    var option = "<option selected value='"+defid+"'>"+defname+"</option>";
                    //$(ele).closest('tr').find('.uom').append(option);
                    $(ele).closest('tr').find('.DefaultUOMId').val(defid);
                    $(ele).closest('tr').find('.NewUOMId').val(defid);
                    $(ele).closest('tr').find('.ConversionAmount').val("1");
                    var len=data['sid'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var name=data['sid'][i].ToUnitName;
                        var id=data['sid'][i].ToUomID;
                        var option = "<option value='"+id+"'>"+name+"</option>";
                        $(ele).closest('tr').find('.uom').append(option); 
                    }
                    $(ele).closest('tr').find('.uom').select2();
                }
                },
            });

            }

            else
            {

            }
            SalesCalculateGrandTotal();
            $('#select2-salesitemNameSl'+idval+'-container').parent().css('background-color',"white");
        }
    }

    function SalesCalculateTotal(ele)
    {
        var availableq = $(ele).closest('tr').find('.AvQuantity').val();
        var quantity = $(ele).closest('tr').find('.quantity').val();
        var unitprice = $(ele).closest('tr').find('.unitprice').val();
        var minAmount=$(ele).closest('tr').find('.wholesaleminamount').val();
        var idval=$(ele).closest('tr').find('.idvalss').val();
        var inputid = ele.getAttribute('id');
        if(inputid==="salesquantity"+idval){
            $(ele).closest('tr').find('.quantity').css("background","white");
        }
        if(inputid==="salesunitprice"+idval){
            $(ele).closest('tr').find('.unitprice').css("background","white");
        }
        if(parseFloat(unitprice)==0)
        {
            $(ele).closest('tr').find('.unitprice').val(''); 
        }
        if(parseFloat(quantity)==0)
        {
            $(ele).closest('tr').find('.quantity').val(''); 
        }
        if(parseFloat(quantity)>parseFloat(availableq))
        {
            toastrMessage('error',"There is no available quantity","Error");
            $(ele).closest('tr').find('.quantity').val('');
            $("#saleshidewithold" ).prop( "checked", false );
        }
        if(parseFloat(quantity)==0)
        {
            $(ele).closest('tr').find('.quantity').val('');
           
        }

      var quantity = $(ele).closest('tr').find('.quantity').val();
        unitprice = unitprice == '' ? 0 : unitprice;
        quantity = quantity == '' ? 0 : quantity;
        if (!isNaN(unitprice) && !isNaN(quantity)) 
        {
            var total = parseFloat(unitprice) * parseFloat(quantity);
            $(ele).closest('tr').find('.total').val(total.toFixed(2));
            if(parseFloat(total)>0){
                $(ele).closest('tr').find('.total').css("background","#efefef");
            }
        }
        var convamount=$(ele).closest('tr').find('.ConversionAmount').val();
        var convertedq=parseFloat(quantity)/parseFloat(convamount);
        $(ele).closest('tr').find('.ConvertedQuantity').val(convertedq);

        SalesCalculateGrandTotal();

     }

    function SalesCalculateGrandTotal()
    {
        var grandTotal = 0;
        $.each($('#salesdynamicTable').find('.total'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                grandTotal += parseFloat($(this).val());
            }
        });
        $('#salessubtotalLbl').html(numformat(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)));
        $('#salessubtotali').val(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/));
    }

    $('#salessavebutton').click(function()
    {  
        var optype=$("#operationtypespo").val();
        var arr = [];
        var found = 0;
        $('.eName').each (function() 
        { 
            var name=$(this).val();
            if(arr.includes(name))
            found++;
            else
            arr.push(name);
        });
        
            if(found) 
            {
                if(parseFloat(optype)==1){
                    $('#salessavebutton').text('Save');
                    $('#salessavebutton').prop("disabled", false);
                }
                else if(parseFloat(optype)==2){
                    $('#salessavebutton').text('Update');
                    $('#salessavebutton').prop("disabled", false);
                }
                toastrMessage('error',"There is duplicate item","Error");
            }    
            else
            {
                var registerForm = $("#salesRegister");
                var formData = registerForm.serialize(); 
                var numofitems=$('#salesnumberofItemsLbl').text();
                if(numofitems==0)
                {
                    if(parseFloat(optype)==1){
                        $('#salessavebutton').text('Save');
                        $('#salessavebutton').prop("disabled", false);
                    }
                    else if(parseFloat(optype)==2){
                        $('#salessavebutton').text('Update');
                        $('#salessavebutton').prop("disabled", false);
                    }
                    toastrMessage('error',"You should add atleast one item","Error");
                }
                else
                {
                    $.ajax({
                        url:'/deadstocksavesale',
                        type:'POST',
                        data:formData,
                        beforeSend:function(){
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
                            if(parseFloat(optype)==1){
                                $('#salessavebutton').text('Saving..');
                                $('#salessavebutton').prop("disabled",true);
                            }
                            else if(parseFloat(optype)==2){
                                $('#salessavebutton').text('Updating...');
                                $('#salessavebutton').prop("disabled",true);
                            }
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
                        success:function(data) 
                        {
                            if(data.errors)
                            {
                               if(parseFloat(optype)==1){
                                    $('#salessavebutton').text('Save');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#salessavebutton').text('Update');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                if(data.errors.customer)
                                {
                                    $( '#salescustomer-error' ).html( data.errors.customer[0] );
                                }
                                if(data.errors.date)
                                {
                                    $( '#salesdate-error' ).html( data.errors.date[0]);
                                }
                                if(data.errors.VoucherNumber)
                                {
                                    $( '#referencenumber-error' ).html( data.errors.VoucherNumber[0]);
                                }
                                if(data.errors.paymentType)
                                {
                                    $( '#salespaymenttype-error' ).html( data.errors.paymentType[0]);
                                }
                                if(data.errors.store)
                                {
                                    $( '#salesstore-error' ).html( data.errors.store[0]);
                                }
                                if(data.errors.DestinationStore)
                                {
                                    $( '#destsalesstore-error' ).html( data.errors.DestinationStore[0]);
                                }
                                if(data.errors.Memo)
                                {
                                    $( '#salesmemo-error' ).html( data.errors.Memo[0]);
                                }
                                toastrMessage('error',"Check your input","Error");
                            }
                            else if(data.emptyerror)
                            {
                                if(parseFloat(optype)==1){
                                    $('#salessavebutton').text('Save');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#salessavebutton').text('Update');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Please add atleast one item","Error");
                            } 
                            else if (data.qnterror) {
                                var singleVal='';
                                var remitems='';
                                var loopedVal='';
                                var indx='';
                                var indxrem='';
                                var count='';
                                var len=data['qnterror'].length;
                                count=data.countedval;

                                $.each(data.countItems, function(index, value) {
                                    singleVal=value.ItemName;
                                });

                                $.each(data.countremitems, function(index, value) {
                                    remitems=value.RemovedItemName;
                                });
                                loopedVal=singleVal+"</br>"+remitems;
                                toastrMessage('error',"There is no available quantity for</br>"+loopedVal,"Error");
                                if(parseFloat(optype)==1){
                                    $('#salessavebutton').text('Save');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#salessavebutton').text('Update');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                            } 
                            else if (data.detqnterror) {
                                var singleVal='';
                                var remitems='';
                                var loopedVal='';
                                var indx='';
                                var indxrem='';
                                var count='';
                                var len=data['detqnterror'].length;
                                count=data.countedval;

                                $.each(data.countItems, function(index, value) {
                                    singleVal=value.ItemName;
                                });

                                $.each(data.countremitems, function(index, value) {
                                    remitems=value.RemovedItemName;
                                });
                                loopedVal=singleVal+"</br>"+remitems;
                                toastrMessage('error',"There is no available quantity for</br>"+loopedVal,"Error");
                                if(parseFloat(optype)==1){
                                    $('#salessavebutton').text('Save');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#salessavebutton').text('Update');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                            }
                            else if(data.errorv2)
                            {
                                var error_html = '';
                                for(var k=1;k<=m;k++){
                                    var itmid=($('#salesitemNameSl'+k)).val();
                                    var uomid=($('#salesuom'+k)).val();
                                    if(($('#salesquantity'+k).val())!=undefined){
                                        var qnt=$('#salesquantity'+k).val();
                                        if(isNaN(parseFloat(qnt))||parseFloat(qnt)==0){
                                            $('#salesquantity'+k).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#salesunitprice'+k).val())!=undefined){
                                        var unitp=$('#salesunitprice'+k).val();
                                        if(isNaN(parseFloat(unitp))||parseFloat(unitp)==0){
                                            $('#salesunitprice'+k).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#salestotal'+k).val())!=undefined){
                                        var totalp=$('#salestotal'+k).val();
                                        if(isNaN(parseFloat(totalp))||parseFloat(totalp)==0){
                                            $('#salestotal'+k).css("background", errorcolor);
                                        }
                                    }
                                    if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                                        $('#select2-salesitemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                                    }
                                    if(isNaN(parseFloat(uomid))||parseFloat(uomid)==0){
                                        $('#select2-salesuom'+k+'-container').parent().css('background-color',errorcolor);
                                    }
                                }
                                // for(var count = 0; count < data.errorv2.length; count++)
                                // {
                                //     error_html += '<p>'+data.errorv2[count]+'</p>';
                                // }
                                if(parseFloat(optype)==1){
                                    $('#salessavebutton').text('Save');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#salessavebutton').text('Update');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                            } 
                            else if(data.success)
                            {
                                if(parseFloat(optype)==1){
                                    $('#salessavebutton').text('Save');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#salessavebutton').text('Update');
                                    $('#salessavebutton').prop("disabled", false);
                                }
                                toastrMessage('success',"Successful","Success");
                                $("#salesinlineForm").modal('hide');
                                $("#salesdynamicTable").empty();
                                $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Cost</th><th></th>');
                                $("#salesRegister")[0].reset();
                                $('#salescustomer').val(null).trigger('change');
                                var oTable = $('#saleslaravel-datatable-crud').dataTable(); 
                                oTable.fnDraw(false); 
                                salescloseModalWithClearValidation();
                                $("#itemnamefooter").empty();
                                var registerForm = $("#salesRegister");
                                var formData = registerForm.serialize();
                                $.ajax({
                                    url:'getItemsByDsStore',
                                    type:'DELETE',
                                    data:formData,
                                    success:function(data)
                                    {
                                        if(data.query)
                                        { 
                                            var options = "<option selected disabled value=''></option>";
                                            $("#itemnamefooter").append(options); 
                                            var len=data['query'].length;
                                            for(var i=0;i<=len;i++)
                                            {
                                                var balance=data['query'][i].Balance;
                                                var storeid=data['query'][i].StoreId;
                                                var itemid=data['query'][i].ItemId;
                                                var itemname=data['query'][i].ItemName;
                                                var code=data['query'][i].Code;
                                                var skunum=data['query'][i].SKUNumber;
                                                var option = "<option label='"+balance+"' title='"+storeid+"' value='"+itemid+"'>"+code+'    ,     '+itemname+'    ,   '+skunum+"</option>";
                                                $("#itemnamefooter").append(option); 
                                                $("#itemnamefooter").select2();
                                            } 
                                        }     
                                    },
                                });
                            }
                        },
                    });
                    }
                }     
    });

    function salescloseModalWithClearValidation()
    {
        $("#salesRegister")[0].reset();
        $('#salessavebutton').text('Save');
        $('#salessavebutton').prop('disabled',false);
        $('#salescustomer-error' ).html('');
        $('#salesdate-error' ).html('');
        $('#salesmemo-error' ).html('');
        $('#salescustomer').val(null).trigger('change');
        $('#salesstore').val("").select2();
        $('#SalesTypeVal').val(null).trigger('change');
        $('#salesstore').val('');
        $('#SalesType-error').html('');
        $('#salespaymenttype-error').html('');
        $('#referencenumber-error').html('');
        $('#salesccategory').text('');
        $('#salescdefaultPrice').text('');
        $('#salesctinNumber').text('');
        $('#salescvat').text('');
        $('#salescustomerInfoCardDiv').hide();
        $('#salessubtotalLbl').html('');
        //$('#SalesType').val("External");
        $('#refrencediv').hide();
        $('#ReferenceNumber').val("");
        $('#salesTotalPrice').show();
        $('#salesSellingPr').show();
        $('#salescustomerdiv').show();
        $('#salesPaymentTypeDiv').show();
        $('#destsalesstorediv').hide();
        $('#salesstore').val('');
        $('#refrencediv').hide();
        $('#salesTotalPrice').show();
        $('#salesSellingPr').show();
        $('#salescustomerdiv').show();
        $('#salesPaymentTypeDiv').show();
        $('#destsalesstorediv').hide();
        $("#salesidval").val("");
        $("#salespaymentType").val("");
        $("#salesstore-error").html("");
        $("#salesdynamicTable").empty();
        $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th></th>');
    }

    $(function () {
        itemSection = $('#itembody');
    });

    $('#salesstore').on('change', function () {
        var type = $('#SalesType').val(); 
        var storeid = $('#salesstore').val(); 
        //$("#salesdynamicTable").empty();
        // if(type==="Internal"||type==="Disposal")
        // {
        //     $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th></th>');
        // }
        // else if(type==="External")
        // {
        //     $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th><th>Unit Price</th> <th>Total Price</th><th></th>');
        // }
        var registerForm = $("#salesRegister");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/syncDynamicTabledspo',
            type: 'POST',
            data: formData,
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
            success: function(data) {
                var q=0;
                $('.AvQuantity').val("0");
                $.each(data.bal, function(key, value) {
                    ++q;
                    var itemids=$('#salesdynamicTable tr:eq('+q+')').find('td').eq(1).find('select').val();
                    if(itemids==value.ItemId){
                        var qtyonhand=value.Balance;
                        var qty=$('#salesdynamicTable tr:eq('+q+')').find('td').eq(4).find('input').val();
                        $('#salesdynamicTable tr:eq('+q+')').find('td').eq(3).find('input').val(value.Balance);
                        if(parseFloat(qtyonhand)<parseFloat(qty) || parseFloat(qtyonhand)==0){
                            $('#salesdynamicTable tr:eq('+q+')').find('td').eq(4).find('input').val("");
                            $('#salesdynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val("");
                        }
                    }
                });
                for(var y=1;y<=m;y++){
                    var qtyonhand=($('#salesAvQuantity'+y)).val()||0;
                    var qty=($('#salesquantity'+y)).val()||0;
                    if(parseFloat(qtyonhand)<parseFloat(qty)|| parseFloat(qtyonhand)==0){
                        $('#salesquantity'+y).val("");
                        $('#salestotal'+y).val("");
                    }
                }
                SalesCalculateGrandTotal();
            }
        });
        $('#salesstore-error').html("");
    });

    $('#salescustomer').on ('change', function () 
    {
        $('#salescustomer-error').html('');
        var nm = $('#salescustomer').val(); 
        if(nm!=null)
        {
            $.get("/showcustomer" +'/' + nm , function (data) 
            {
                $('#salescname').text(data.Name);
                $('#salesccategory').text(data.CustomerCategory);
                $('#salescdefaultPrice').text(data.DefaultPrice);
                $('#salesctinNumber').text(data.TinNumber);
                $('#salescvat').text(data.VatType+"%");
                $('#saleswitholdPercenti').val(data.Witholding);
                $('#salesvatPercenti').val(data.VatType);
                $('#salescwithold').html(data.Witholding+"%");
            });   
        }
        $('#salescustomerInfoCardDiv').show();
    });

    function removeDateValidation()
    {
        $('#salesdate-error' ).html(''); 
    }

    function salesmemoVal()
    {
        $('#salesmemo-error').html('');
    }   

    function numformat(val)
    {
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }

    //$('body').on('click', '.saleeditProduct', function (){
    function editpullout(id){
        var j=0;
        var sroreidvar;
        $("#dspomodaltitle").html("Update PullOut");
        $("#operationtypespo").val("2");
        $('.select2').select2();
        $("#salesinlineForm").modal('show');
        $("#salesdynamicTable").show();
        $("#salesadds").show();
        $("#salesaddnew").hide();
        $("#salesdatatable-crud-childsale").hide();
        $("#edittable").hide();
        //var id = $(this).data('id');
        $("#salesidval").val(id);
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
        $.get("/deadshowSale" +'/' + id , function (data) 
        {
            $('#SalesType').val(data.sales.Type);
            $('#salesid').val(data.sales.id);  
            //$('#salescustomer').selectpicker('val',data.sales.CustomerId).trigger('change');
            $('#salescustomer').select2('destroy');
            $('#salescustomer').val(data.sales.CustomerId).trigger('change').select2();
            $('#salespaymentType').val(data.sales.PaymentType);
            //$('#salesstore').selectpicker('val',data.sales.StoreId).trigger('change');
            $('#salesstore').select2('destroy');
            $('#salesstore').val(data.sales.StoreId).select2();
            sroreidvar=data.sales.StoreId;
            //$('#destsalesstore').selectpicker('val',data.sales.DestinationStore).trigger('change');
            $('#destsalesstore').select2('destroy');
            $('#destsalesstore').val(data.sales.DestinationStore).trigger('change').select2();
            $('#salesdate').val(data.sales.CreatedDate);
            $('#salesMemo').val(data.sales.Memo);
            //$('#salessubtotalLbl').html(numformat(data.sales.SubTotal));
            //$('#salesnumberofItemsLbl').html(data.countItem);
            //$('#salessubtotali').val(data.sales.SubTotal);
            $('#salescommonVal').val(data.sales.Common);
            $('#ReferenceNumber').val(data.sales.VoucherNumber);  
            $("#salestypeHidden").val(data.sales.Type);
            $("#salesStoreHidden").val(data.storeName);
            $("#salesDestinationHidden").val(data.dsstoreName);
            $("#transactionSt").val(data.sales.Status);
            var type=data.sales.Type;
            var status=data.sales.Status;
            if(type==="Internal"){
                $('#salesTotalPrice').show();
                $('#salesSellingPr').show();
                $('#salescustomerdiv').show();
                $('#salesPaymentTypeDiv').show();
                $('#destsalesstorediv').show();
                $('#salesstorediv').show();
                $('#refrencediv').show();
                $("#destinationsstorelbls").html("Destination Store/Shop");
                $("#srclbls").html("Source Store/Shop");
                $("#destinationlbls").html("Customer");
                $("#SalesType-error").html("");
                $('#salesdynamicTable').show();
                $('#podynamicbuttonsdiv').show();
                $('#podocumentdatediv').show();
                $('#pomemodiv').show();
                $('#salesadds').show();
                $('#salesaddnew').hide();
            }
            else if(type==="External"){
                $('#refrencediv').hide();
                $('#salesTotalPrice').show();
                $('#salesSellingPr').show();
                $('#salescustomerdiv').show();
                $('#salesPaymentTypeDiv').show();
                $('#destsalesstorediv').hide();
                $('#salesstorediv').show();
                $("#destinationsstorelbls").html("Destination");
                $("#srclbls").html("Source Store/Shop");
                $("#destinationlbls").html("Customer");
                $('#salesdynamicTable').show();
                $('#podynamicbuttonsdiv').show();
                $('#podocumentdatediv').show();
                $('#pomemodiv').show();
                $('#salesadds').show();
                $('#salesaddnew').hide();
            }
            else if(type==="Disposal"){
                $('#salesstorediv').show();
                $('#refrencediv').hide();
                $('#ReferenceNumber').val("");
                $('#salesTotalPrice').show();
                $('#salesSellingPr').show();
                $('#salescustomerdiv').hide();
                $('#salesPaymentTypeDiv').hide();
                $('#destsalesstorediv').hide();
                $("#destinationsstorelbls").html("Destination");
                $("#srclbls").html("Source Store/Shop");
                $("#destinationlbls").html("Customer");
                $('#salesdynamicTable').show();
                $('#podynamicbuttonsdiv').show();
                $('#podocumentdatediv').show();
                $('#pomemodiv').show();
                $('#salesadds').show();
                $('#salesaddnew').hide();
            }
            if(status==="Pending/Removed"){
                $("#postatusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+status+"</span>");
            }
            else if(status==="Confirmed/Removed"){
                $("#postatusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+status+"</span>");
            }
            var allselecteditems=[];
            $.each(data.receivingdt, function(key, value) {
                ++i;
                ++m;
                ++j;   
                $("#salesdynamicTable").append('<tr id="salesrow'+m+'" class="dynamic-added"><td style="font-weight:bold;width:3;text-align:center;">'+j+'</td>'+
                    '<td style="width: 25%;"><select id="salesitemNameSl'+m+'" class="select2 form-control eName" onchange="itemValSales(this)" name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="width:10%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uoms'+m+'" class="uomn form-control" readonly="true" value="'+value.UomName+'"/></td>'+
                    '<td><input type="text" name="row['+m+'][AvQuantity]" id="salesAvQuantity'+m+'" class="AvQuantity form-control"  readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][Quantity]" placeholder="Quantity" id="salesquantity'+m+'" class="quantity form-control" value="'+value.Quantity+'" onkeyup="SalesCalculateTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="ValidQuantity(this)"/></td>'+
                    '<td style="width:15%"><input type="text" name="row['+m+'][UnitPrice]" placeholder="Unit Price" id="salesunitprice'+m+'" class="unitprice form-control" value="'+value.UnitPrice+'" onkeyup="SalesCalculateTotal(this)" readonly onkeypress="return ValidateNum(event);" @can('StockBalance-EditPrice') ondblclick="unitpriceActive(this)"; @endcan /></td>'+
                    '<td style="width: 15%;"><input type="text" name="row['+m+'][TotalPrice]" id="salestotal'+m+'" class="total form-control"  style="font-weight:bold;" value="'+value.TotalPrice+'" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="salesstoreappend'+m+'" class="storeappend form-control" value="'+value.StoreId+'" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="salescommon'+m+'" class="salescommon form-control" value="'+value.Common+'" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="salesTransactionType'+m+'" class="TransactionType form-control" value="PullOut" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="salesItemType'+m+'" class="ItemType form-control" value="Goods" readonly/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DefaultUOMId]" id="salesDefaultUOMId'+m+'" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;" value="'+value.DefaultUOMId+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][NewUOMId]" id="salesNewUOMId'+m+'" class="NewUOMId form-control" readonly="true" style="font-weight:bold;" value="'+value.NewUOMId+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ConversionAmount]" id="salesConversionAmount'+m+'" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;" value="'+value.ConversionAmount+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ConvertedQuantity]" id="salesConvertedQuantity'+m+'" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;" value="'+value.ConvertedQuantity+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][mainPrice]" id="salesmainPrice'+m+'" class="mainPrice form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][maxCost]" id="salesmaxCost'+m+'" class="maxCost form-control" readonly="true" style="font-weight:bold;" value="'+value.dsmaxcost+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DiscountAmount]" id="salesdiscountamount'+m+'" class="discountamount form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][wholesaleminamount]" id="saleswholesaleminamount'+m+'" class="wholesaleminamount form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][retailprice]" id="salesretailprice'+m+'" class="retailprice form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][wholesaleprice]" id="saleswholesaleprice'+m+'" class="wholesaleprice form-control" readonly="true" style="font-weight:bold;"/><input type="hidden" name="row['+m+'][maxcosteditable]" id="maxcosteditable" class="maxcosteditable form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="idvalss" id="idvalss'+m+'" class="idvalss form-control" readonly="true" value="'+m+'" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][AvQuantityh]" id="salesAvQuantityh'+m+'" class="AvQuantityh form-control"  readonly/></td>'+
                    '<td style="display:none;"><select id="salesuom'+m+'" class="select2 form-control uom" onchange="uomVal(this)" name="row['+m+'][uom]"><option selected value="'+value.DefaultUOMId+'">'+value.UomName+'</option></select></td>'+
                    '<td><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                '</tr>');
                var selectedoptions='<option selected value="'+value.ItemId+'">'+value.ItemCode+'  ,   '+value.ItemName+'  ,   '+value.SKUNumber+'</option>';
                var options = $("#itemnamefooter > option").clone();
                $('#salesitemNameSl'+m).append(options);
                $("#salesitemNameSl"+m+" option[title!='"+sroreidvar+"']").remove(); 
                $("#salesitemNameSl"+m+" option[label=0]").remove();
                for(var k=1;k<=m;k++){
                    if(($('#salesitemNameSl'+k).val())!=undefined){
                        var selectedval=$('#salesitemNameSl'+k).val();
                        $("#salesitemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#salesitemNameSl'+m).append(selectedoptions);  
                $('#salesitemNameSl'+m).select2();
                $('#select2-salesitemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#salesnumberofItemsLbl').html(j);
                allselecteditems.push(value.ItemId);
            });
            SalesCalculateGrandTotal();

            //Assign quantity on hands on the dynamic table
            var q=0;
            var r=0;
            var sorteditems=allselecteditems.sort();
            $.each(data.bal, function(key, value) {
                ++q;
                var itemids=$('#salesdynamicTable tr:eq('+q+')').find('td').eq(1).find('select').val();
                if(itemids==value.ItemId){
                    var qnt=$('#salesdynamicTable tr:eq('+q+')').find('td').eq(4).find('input').val()||0;
                    var totalqnt=parseFloat(qnt)+parseFloat(value.Balance);
                    $('#salesdynamicTable tr:eq('+q+')').find('td').eq(3).find('input').val(totalqnt);
                }
                ++r;
            });
        });

        
        $("#salestypeHidden").hide();
        $("#salesStoreHidden").hide();
        $("#salesDestinationHidden").hide();
        $("#salestypediv").show();
        $("#salessourcestore").show();
        $("#salesdeststore").show();
        $('#salespricingTable').show();
        $('#salessavebutton').text('Update');
        $('#salessavebutton').prop("disabled", false);
        $('#salessavebutton').show();
        $('#salesdatatable-crud-childsale').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        paging: false,
        info: false,
        destroy: true,
        searchHighlight: true,
        "order": [[ 0, "asc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            url: '/deadsalechildsalelist/'+id,
            type: 'GET',
            dataType: "json",
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
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'Type', name: 'Type' , 'visible': false},
            { data: 'Code', name: 'Code' },
            { data: 'ItemName', name: 'ItemName' },
            { data: 'SKUNumber', name: 'SKUNumber' }, 
            { data: 'UOM', name: 'UOM' },
            { data: 'Quantity', name: 'Quantity',render: $.fn.dataTable.render.number(',', '.',0, '')},
            { data: 'UnitPrice', name: 'UnitPrice',render: $.fn.dataTable.render.number(',', '.', 2, '')},
            { data: 'TotalPrice', name: 'TotalPrice',render: $.fn.dataTable.render.number(',', '.', 2, '')},
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
           if(aData.Type==="Internal"||aData.Type==="Disposal")
           {
                $(nRow).find('td:eq(6)').show();
                $(nRow).find('td:eq(7)').show();
                $('#unitpriceTh').show();
                $('#totalpriceTh').show();
                $('#unitpriceHeader').show();
                $('#totalpriceHeader').show();
                $('#unitpriceHeaderTd').show();
                $('#totalpriceHeaderTd').show();
           }
           else
           {
                $(nRow).find('td:eq(6)').show();
                $(nRow).find('td:eq(7)').show();
                $('#unitpriceTh').show();
                $('#totalpriceTh').show();
                $('#unitpriceHeader').show();
                $('#totalpriceHeader').show();
                $('#unitpriceHeaderTd').show();
                $('#totalpriceHeaderTd').show();
           }
        }
        });
    }

    function removeItemNameValidation()
    { 
                $('#salesItemName-error').html('');
                $('#salesItemType-error').html(''); 
                $('#salesUnitPrice-error').html(''); 
                $('#salesQuantity').val('');
                $('#salesTotalPrice').val('0');
                var sid=$('#salesItemName').val();
                var dssalesid=$('#salesitemid').val();

                var storeval = salesstore.value;


                    if(sid!='')
                    {
                        $.get("/deadshowItemInfo" +'/' + sid +'/'+storeval , function (data)
                        {
                            var len=data['Regitem'].length;
                           
                            for(var i=0;i<=len;i++) 
                            {
                                var qty=$('#salesQuantity').val()||0;
                                var deadstockprice=(data['Regitem'][i].DeadStockPrice);
                                var avalaiblequantity=data['getQuantity'][i].AvailableQuantity;
                                var avalaiblequantitpen=data['getPenQuantity'][i].PendingQuantity||0;
                             
                                var totalpending=parseFloat(avalaiblequantitpen)-parseFloat(qty);
                                var results=parseFloat(avalaiblequantity)-parseFloat(totalpending);
                                var result=0;
                                var res=parseFloat(avalaiblequantity)-parseFloat(avalaiblequantitpen);
                                //alert(avalaiblequantity+"       "+avalaiblequantitpen+"     "+results);
                                if(dssalesid===null||isNaN(parseFloat(dssalesid))){
                                    $('#salesUnitPrice').val(deadstockprice);
                                    $('#salesmainPricei').val(deadstockprice);
                                    if(parseFloat(avalaiblequantity)>0)
                                    {  
                                        if(parseFloat(results)<=0){
                                            $('#salesavQuantitiy').val("0");
                                            $('#salesavQuantitiyh').val(avalaiblequantity);
                                        }
                                        else if(parseFloat(results)>0){
                                            $('#salesavQuantitiy').val(results);
                                            $('#salesavQuantitiyh').val(avalaiblequantity);
                                        }  
                                    }
                                    if(parseFloat(avalaiblequantity)==null||parseFloat(avalaiblequantity)==0)
                                    { 
                                        $('#salesavQuantitiy').val('0');
                                    }  
                                    $('#avQuantitiyhid').val('0');
                                }
                                if(dssalesid!=null||!isNaN(parseFloat(dssalesid))){
                                    if(parseFloat(avalaiblequantity)>0)
                                    {  
                                        if(parseFloat(res)<=0){
                                            $('#avQuantitiyhid').val("0");
                                        }
                                        else if(parseFloat(res)>0){
                                            $('#avQuantitiyhid').val(res);
                                        }  
                                    }
                                    if(parseFloat(avalaiblequantity)==null||parseFloat(avalaiblequantity)==0)
                                    { 
                                        $('#avQuantitiyhid').val('0');
                                    }  
                                }
                                
                            }  
                        }); 

                       $("#salesuoms").empty();

                       $.ajax({
                      url:'saleUOMSdead/'+sid,
                      type:'DELETE',
                       data:'',
                       success:function(data)
                        {
                     if(data.sid)
                       {
                     var defname=data['defuom'];
                     var defid=data['uomid'];
                     var option = "<option selected value='"+defid+"'>"+defname+"</option>";
                     $("#salesuoms").append(option);
                     $("#salesdefaultuomi").val(defid);
                     $("#salesnewuomi").val(defid);
                     $("#salesconvertedamnti").val("1");
                     var len=data['sid'].length;
                     for(var i=0;i<=len;i++)
                     {
                    var name=data['sid'][i].ToUnitName;
                    var id=data['sid'][i].ToUomID;
                    var option = "<option value='"+id+"'>"+name+"</option>";
                    $("#salesuoms").append(option);
                    
                    }
                  $("#salesuoms").select2();
            }
        },
       });

                        
                    }


        }

        function uomVal(ele) 
            {
                var uomnewval = $(ele).closest('tr').find('.uom').val();
                var UnitpriceVal= $(ele).closest('tr').find('.unitprice').val();
                var mainpriceval= $(ele).closest('tr').find('.mainPrice').val();
                var quantityOnhand=$(ele).closest('tr').find('.AvQuantity').val();
                var quantityOnhandh=$(ele).closest('tr').find('.AvQuantityh').val();
                $(ele).closest('tr').find('.NewUOMId').val(uomnewval);
                var uomdefval = $(ele).closest('tr').find('.DefaultUOMId').val();

                if(parseFloat(uomnewval)==parseFloat(uomdefval))
                    {
                        $(ele).closest('tr').find('.ConversionAmount').val("1");
                        $(ele).closest('tr').find('.unitprice').val(mainpriceval);
                        $(ele).closest('tr').find('.AvQuantity').val(quantityOnhandh);
                    }
                    else if(parseFloat(uomnewval)!=parseFloat(uomdefval))
                    {
                        var registerForm = $("#salesRegister");
                        var formData = registerForm.serialize();
                        if(uomnewval!=null)
                        {
                            $.ajax({
                           url:'deadgetsaleUOMAmount/'+uomdefval+"/"+uomnewval,
                           type:'DELETE',
                           data:formData,
                           success:function(data)
                           {
                            if(data.sid)
                            {
                                var amount=data['sid'];
                                $(ele).closest('tr').find('.ConversionAmount').val(amount);
                                var Result= mainpriceval/amount;
                                var onhandResult=quantityOnhandh/amount;

                                $(ele).closest('tr').find('.unitprice').val(Result);
                                $(ele).closest('tr').find('.AvQuantity').val(onhandResult);

                                
                            }
                         },

                         });
                        }
                        

                    } 

                    $(ele).closest('tr').find('.quantity').val("");
                    $(ele).closest('tr').find('.ConvertedQuantity').val("");          

            }

             function SalesCalculateAddHoldTotal(ele)
             {
                var availableq = $(ele).closest('tr').find('#salesavQuantitiy').val();
                var quantitys = $(ele).closest('tr').find('#salesQuantity').val();
                var unitprices = $(ele).closest('tr').find('#salesUnitPrice').val();
                if(parseFloat(quantitys)==0)
                {
                    $(ele).closest('tr').find('#salesQuantity').val('');   
                }
                if(parseFloat(unitprices)==0)
                {
                    $(ele).closest('tr').find('#salesUnitPrice').val('');   
                }
                    if(parseFloat(quantitys)>parseFloat(availableq))
                    {
                        toastrMessage('error',"There is no available quantity","Error");
                        $(ele).closest('tr').find('#salesQuantity').val('');
                    }
                        var quantity = $('#salesQuantity').val();
                        var unitcost =  $('#salesUnitPrice').val();
                        unitcost = unitcost == '' ? 0 : unitcost;
                        quantity = quantity == '' ? 0 : quantity;
                        if (!isNaN(unitcost) && !isNaN(quantity)) 
                        {
                            var total = parseFloat(unitcost) * parseFloat(quantity);
                            $('#salesTotalPrice').val(total.toFixed(2));
                        }
                        var defuom= $('#salesdefaultuomi').val();
                        var newuom=$('#salesnewuomi').val();
                        var convamount=$('#salesconvertedamnti').val();
                        var convertedq=parseFloat(quantity)/parseFloat(convamount);
                        $('#salesconvertedqi').val(convertedq);

             } 

             function uomsavedVal(ele) 
              {
                var uomnewval =  $('#salesuoms').val();
               $('#salesnewuomi').val(uomnewval);
               var uomdefval =  $('#salesdefaultuomi').val();
               var mainpriceVal=$('#salesmainPricei').val();
               var quntityOnhand=$('#salesavQuantitiy').val();
               var quntityOnhandh=$('#salesavQuantitiyh').val();
               if(parseFloat(uomnewval)==parseFloat(uomdefval))
               {
                    $('#salesconvertedamnti').val("1");
                    $('#salesUnitPrice').val(mainpriceVal);
                    $('#salesavQuantitiy').val(quntityOnhandh);
               }

               else if(parseFloat(uomnewval)!=parseFloat(uomdefval))
            {
                var registerForm = $("#salesRegister");
                var formData = registerForm.serialize();
                if(uomnewval!=null)
                {
                    $.ajax({
                    url:'deadgetsaleUOMAmount/'+uomdefval+"/"+uomnewval,
                    type:'DELETE',
                    data:'',
                    success:function(data)
                    {
                        if(data.sid)
                        {
                        
                            var amount=data['sid'];
                        
                        var Result=mainpriceVal/amount;
                        var onHandQuantity=quntityOnhandh/amount;
                        $('#salesUnitPrice').val(Result);
                            $('#salesconvertedamnti').val(amount);
                            $('#salesavQuantitiy').val(onHandQuantity);

                        }
                    },
                });

                }
        
        }
        $('#salesconvertedqi').val("");
        $('#salesQuantity').val("");

              }

              $('#salessavebuttonsaleitem').click(function()
              {  
                    var registerForm = $("#salesitemRegisterForm");
                    var formData = registerForm.serialize(); 
                     $.ajax({
                        url:'/deadsavesaleitem',
                        type:'POST',
                        data:formData,
                        beforeSend:function(){
                            $('#salessavebuttonsaleitem').text('Saving...');
                            $('#salessavebuttonsaleitem').prop('disabled',true);
                            },
                            success:function(data) {
                                if(data.errors)
                                {
                                    $('#salessavebuttonsaleitem').prop('disabled',false);
                                    $('#salessavebuttonsaleitem').text('Add');

                                    if(data.errors.ItemName)
                                     {
                                    $('#salesItemName-error' ).html( data.errors.ItemName[0]);
                                    }
                                    if(data.errors.Quantity)
                                    {
                                    $('#salesQuantity-error' ).html( data.errors.Quantity[0]);
                                    }
                                    if(data.errors.UnitPrice)
                                    {
                                    $('#salesUnitPrice-error' ).html( data.errors.UnitPrice[0]);
                                    }

                                }
                                if(data.dberrors)
                            {
                                $('#salesItemName-error').html("The Item Name has already been taken.");
                                $('#salessavebuttonsaleitem').text('Add');
                                $('#salessavebuttonsaleitem').prop('disabled',false);
                                toastrMessage('error',"Check your inputs","Error");
                            } 
                            if(data.success)
                            {
                                toastrMessage('success',"Successful","Success");
                                $('#salessavebuttonsaleitem').text('Add');
                                $('#salessavebuttonsaleitem').prop('disabled',false);
                                $('#salesIteminlineForm').modal('hide');
                                $("#saleshidewithold").prop( "checked", false);
                                var oTable = $('#salesdatatable-crud-childsale').dataTable(); 
                                oTable.fnDraw(false);
                                $('#salesnumberofItemsLbl').text(data.Totalcount);
                                $('#salesnumbercounti').val(data.Totalcount);
                                closeIteminlineFormModalWithClearValidation();
                                var len=data.PricingVal.length;
                                for(var i=0;i<=len;i++)
                                {
                                    var totalPrice=data.PricingVal[i].TotalPrice;
                                    $('#salessubtotalLbl').html(numformat(totalPrice));
                                }
                           }
                        },
                   });
             
                });

                $('#salessavebuttonsaleitempen').click(function()
                {  
                    var registerForm = $("#salesitemRegisterForm");
                    var formData = registerForm.serialize(); 
                     $.ajax({
                        url:'/deadsavesaleitempen',
                        type:'POST',
                        data:formData,
                        beforeSend:function(){
                            $('#salessavebuttonsaleitempen').text('Saving...');
                            $('#salessavebuttonsaleitempen').prop('disabled',true);
                            },
                            success:function(data) 
                            {
                                if(data.errors)
                                {
                                    $('#salessavebuttonsaleitempen').prop('disabled',false);
                                    $('#salessavebuttonsaleitempen').text('Add');

                                    if(data.errors.ItemName)
                                     {
                                    $('#salesItemName-error' ).html( data.errors.ItemName[0]);
                                    }
                                    if(data.errors.Quantity)
                                    {
                                    $('#salesQuantity-error' ).html( data.errors.Quantity[0]);
                                    }
                                    if(data.errors.UnitPrice)
                                    {
                                    $('#salesUnitPrice-error' ).html( data.errors.UnitPrice[0]);
                                    }

                                }
                                if(data.dberrors)
                                {
                                    $('#salesItemName-error').html("The Item Name has already been taken.");
                                    $('#salessavebuttonsaleitempen').text('Add');
                                    $('#salessavebuttonsaleitempen').prop('disabled',false);
                                    toastrMessage('error',"Check your inputs","Error");
                                } 
                            if(data.success)
                            {
                                toastrMessage('success',"Successful","Success");
                                $('#salessavebuttonsaleitempen').text('Add');
                                $('#salessavebuttonsaleitempen').prop('disabled',false);
                                $('#salesIteminlineForm').modal('hide');
                                $("#saleshidewithold").prop( "checked", false);
                                var oTable = $('#salesdatatable-crud-childsale').dataTable(); 
                                oTable.fnDraw(false);
                                $('#salesnumberofItemsLbl').text(data.Totalcount);
                                $('#salesnumbercounti').val(data.Totalcount);
                                closeIteminlineFormModalWithClearValidation();
                                var len=data.PricingVal.length;
                                for(var i=0;i<=len;i++)
                                {
                                    var totalPrice=data.PricingVal[i].TotalPrice;
                                    $('#salessubtotalLbl').html(numformat(totalPrice));
                                }
                           }
                        },
                   });
             
                });

                $('body').on('click', '.saleeditItem', function () {
                    $("#salesIteminlineForm").modal('show');
                    var id = $(this).data('id');
                    var storeid=$('#salesstore').val();
                    var status=$('#transactionSt').val();
                    var uomname = $(this).data('uom');
                    var qnt=0;
                    $('#salesstoreId').val(storeid); 
                    $('#salesitemid').val(id);
                    var status=$('#transactionSt').val();
                    if(status==="Confirmed/Removed")
                    {
                        $('#salessavebuttonsaleitempen').hide();
                        $('#salessavebuttonsaleitem').show();
                    }
                    else if(status==="Pending/Removed")
                    {
                        $('#salessavebuttonsaleitempen').show();
                        $('#salessavebuttonsaleitem').hide();
                    }
                    $.get("/deadshowsaleItem" +'/' + id , function (data) {
                       
                        $('#salesItemName').selectpicker('val',data.saleholditem.ItemId).trigger('change');
                        var ItemIdSend=data.saleholditem.ItemId;
                        $('#salesHeaderId').val(data.saleholditem.HeaderId);
                        $('#salesQuantity').val(data.saleholditem.Quantity);
                        $('#salesUnitPrice').val(data.saleholditem.UnitPrice);
                        $('#salescommonId').val(data.saleholditem.Common);
                        $('#salesmainPricei').val(data.saleholditem.UnitPrice*data.saleholditem.ConversionAmount);
                        $('#salesTotalPrice').val(data.saleholditem.TotalPrice);
                        $('#salesconvertedqi').val(data.saleholditem.ConvertedQuantity);
                        $('#salesconvertedamnti').val(data.saleholditem.ConversionAmount);
                        $('#salesnewuomi').val(data.saleholditem.NewUOMId);
                        $('#salesdefaultuomi').val(data.saleholditem.DefaultUOMId);
                        $("#salesuoms").empty();
                        $('#salesuoms').find('option').not(':first').remove();
                        qnt=data.saleholditem.Quantity;

                        var newuom= $('#salesnewuomi').val();
                        var registerForm = $("#salesRegister");
                        var formData = registerForm.serialize();

                        if(ItemIdSend!=null)
                        {
                            $.ajax({
                                url:'saleUOMSdead/'+ItemIdSend,
                                type:'DELETE',
                                data:'',
                                success:function(data)
                                {
                                    if(data.sid)
                                    {
                                    var options = "<option selected value='"+newuom+"'>"+uomname+"</option>";
                                    $("#salesuoms").append(options);
                                    var defname=data['defuom'];
                                    var defid=data['uomid'];
                                    var option = "<option value='"+defid+"'>"+defname+"</option>";
                                    $("#salesuoms").append(option);
                                    var len=data['sid'].length;
                                    for(var i=0;i<=len;i++)
                                    {
                                        var name=data['sid'][i].ToUnitName;
                                        var id=data['sid'][i].ToUomID;
                                        var option = "<option value='"+id+"'>"+name+"</option>";
                                        $("#salesuoms").append(option); 
                                    }
                                    
                                    $("#salesuoms").select2();
                                    }
                                },
                            });

                            $.get("/deadshowItemInfo" +'/' + ItemIdSend +'/'+storeid , function (data)
                            {
                                var len=data['Regitem'].length;
                                for(var i=0;i<=len;i++) 
                                {
                                    var avalaiblequantity=data['getQuantity'][i].AvailableQuantity;
                                    var avalaiblequantitpen=data['getPenQuantity'][i].PendingQuantity||0;
                                    var res=parseFloat(avalaiblequantity)-parseFloat(avalaiblequantitpen);
                                    var totalav=parseFloat(res)+parseFloat(qnt); 
                                    $("#salesavQuantitiy").val(totalav);
                                }  
                            });
                        }
                    });

                }); // end of edit item

                $('body').on('click', '.saledeleteItem', function () {
                    var numbercount=$('#salesnumberofItemsLbl').html();
                    if(numbercount=='1')
                        {
                            toastrMessage('error',"You cant remove all items","Error");
                        }
                        else
                        {
                            
                            $("#salesexamplemodal-delete").modal('show');
                            var sid = $(this).data('id');
                            var headerid=$(this).data('hid');
                            $('#salesdid').val(sid);
                            $('#saleshid').val(headerid);

                        }

                });
                $('#salesdeleteBtn').click(function(){ 
                    var cid = document.forms['salesdeletform'].elements['did'].value;
                    var registerForm = $("#salesdeletform"); 
                    var formData = registerForm.serialize();
                    $.ajax({
                    url:'/deadsaleholddelete/'+cid,
                    type:'DELETE',
                    data:formData,
                  beforeSend:function(){
                  $('#salesdeleteBtn').text('Deleting sales...');
                 $('#salesdeleteBtn').prop('disabled',true);
              },
            success:function(data)
            {
                toastrMessage('success',"Successful","Success");
                $('#salesdeleteBtn').text('Delete');
                $('#salesdeleteBtn').prop('disabled',false);
                $('#salesexamplemodal-delete').modal('hide');
            
            var oTable = $('#salesdatatable-crud-childsale').dataTable(); 
            oTable.fnDraw(false);
            $('#salesnumberofItemsLbl').text(data.Totalcount);
            var len=data.PricingVal.length;
            for(var i=0;i<=len;i++)
         {
            var total=data.PricingVal[i].TotalPrice;
            $('#salessubtotalLbl').text(numformat(total));
         }

        }
       });

                });
                function closeIteminlineFormModalWithClearValidation()
                {
                    $('#salesItemName').val(null).trigger('change');
                    $('#salesuoms').val(null).trigger('change');
                    $('#salesavQuantitiy').val("");
                    $('#salesQuantity').val("");
                    $('#salesUnitPrice').val("");
                    $('#salesTotalPrice').val("");
                    $('#salesItemName-error').html('');
                    $('#salesQuantity-error').html('');
                    $('#salesUnitPrice-error').html('');
                    $('#salesTotalPrice-error').html('');
                    $('#salessavebuttonsaleitem').text('Add');
                    $('#salessavebuttonsaleitem').prop('disabled',false);
                }
                function salescloseModalWithClearValidations()
                {
                    $('#salesdeleteBtn').text('Delete');
                    $('#salesdeleteBtn').prop('disabled',false); 
                }

                function removeQuantityValidation()
                {
                    $('#salesQuantity-error' ).html('');
                }

                function removeUnitPriceValidation()
                {
                    $('#salesUnitPrice-error' ).html('');
                }

                $('body').on('click', '.saleVoid', function () {
                    var status=$(this).data('status');
                    var headid= $(this).data('id');
                    $('#currentstatus').val(status);
                    $('#checkedid').val(headid);
                    $('#checkedst').val('Void');
                    $("#receivingcheckmodal").modal('show');
                    $("#confirmLbl").html('Do you really want to void PullOut?');
                    $("#checkedbtnunvoid").hide();
                    $("#checkedbtnvoid").show();
                    $("#voucherNumberDive").hide();
                    $("#voidDiv").show();
                    $('#checkedbtnvoid').text('Void');
                    $('#checkedbtnvoid').prop("disabled",false);
               });

               $('#checkedbtnvoid').click(function(){ 
                var headid=$('#checkedid').val();
                var registerForm = $("#checkreceivingform");
                var formData = registerForm.serialize();  
                $.ajax({
                url:'/deadcheckedsale/'+headid,
                type:'DELETE',
                data:formData,
                beforeSend:function(){
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
                    $('#checkedbtnvoid').text('Voiding...');
                    $('#checkedbtnvoid').prop( "disabled",true);
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
                success:function(data) 
                {
                    if(data.errors) 
                    {
                        if(data.errors.PulloutReason)
                        {
                            $('#salesvoid-error' ).html( data.errors.PulloutReason[0] );
                        }
                        toastrMessage('error',"Check your inputs","Error");
                        $('#checkedbtnvoid').text('Void');
                        $('#checkedbtnvoid').prop( "disabled", false ); 
                    }
                    if(data.success)
                    {
                        toastrMessage('success',"Successful","Success");
                        $('#checkedbtnvoid').text('Void');
                        $("#receivingcheckmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        $("#checkreceivingform")[0].reset();
                        var oTable = $('#saleslaravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                },
                 });
            });

            $('body').on('click', '.saleunVoid', function () {
                var status=$(this).data('status');
                var headid= $(this).data('id');
                $('#checkedid').val(headid);         
                $('#checkedst').val('unVoid');
                $("#receivingcheckmodal").modal('show');
                $("#confirmLbl").html('Do you really want to undo void PullOut?');
                $("#voucherNumberDive").hide();
                $("#checkedbtnvoid").hide();
                $("#checkedbtnunvoid").show();
                $("#voidDiv").hide();
            });

            $('#checkedbtnunvoid').click(function(){ 
                var headid=$('#checkedid').val();
                var registerForm = $("#checkreceivingform");
                var formData = registerForm.serialize();   
                $.ajax({
                url:'/deadcheckedsale/'+headid,
                type:'DELETE',
                data:formData,
                beforeSend:function(){
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
                    $('#checkedbtnunvoid').text('Changing...');
                    $('#checkedbtnunvoid').prop('disabled',true);
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
                success:function(data) 
                {
                    if(data.success)
                    {
                        if(data.success)
                        {
                            toastrMessage('success',"Successful","Success");
                            $('#checkedbtnunvoid').text('Undo Void');
                            $('#checkedbtnunvoid').prop('disabled',false);
                            $("#receivingcheckmodal").modal('hide');
                            $("#docInfoModal").modal('hide');
                            $("#checkreceivingform")[0].reset();
                            var oTable = $('#saleslaravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                        }
                    }
      if(data.dberrors)
      {
        $('#checkedbtnunvoid').prop('disabled',false);
        $('#checkedbtnunvoid').text('Undo Void');
        $( '#undoVoucherNumber-error' ).html("The Voucher number has been taken");

       }
       if(data.errors)
       {
       
          if(data.errors.undoVoucherNumber)
         {
            $('#checkedbtnunvoid').prop('disabled',false);
           $('#checkedbtnunvoid').text('Undo Void');
            $( '#undoVoucherNumber-error' ).html( data.errors.undoVoucherNumber[0] );
          }

          }

          },
             });
            });

            //$('body').on('click', '.saleinfoProductItemDs', function () {
            function saleinfoProductItemDs(sid){
                var oTable = $('#salelaravel-datatable-crud').dataTable(); 
                oTable.fnDraw(false);
                //var sid = $(this).data('id');
                $('#infoheaderid').val(sid);
                var vstatus='';
                $("#saledocInfoModal").modal('show');  
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
                $.get("/deadshowSale" +'/' + sid , function (data) 
                {   
                    $('#salesinfoDocNumber').text(data.sales.DocumentNumber);
                    $('#dsinfotype').text(data.sales.Type);
                    $('#saleinfoDocCustomerName').text(data.cname);
                    $('#saleinfoTinNo').text(data.custTinNumber);
                    $('#saleinfoDocPaymentType').text(data.sales.PaymentType); 
                    $('#salesinfoReferenceNumber').text(data.sales.VoucherNumber); 
                    $('#saleinfoDocsaleShop').text(data.storeName); 
                    $('#dssaleinfoDocsaleShop').text(data.dsstoreName); 
                    $('#dssalesdestinationstore').text(data.dsstoreName); 
                    $('#saleinfoDocDate').text(data.sales.CreatedDate);
                    $('#saleinfoPrepareddby').text(data.sales.Username);
                    $('#saleinfovoidby').text(data.sales.VoidedBy);
                    $('#salesinfoconfirmedby').text(data.sales.ConfirmedBy);
                    $('#salesinfoconfirmeddate').text(data.sales.ConfirmedDate);
                    $('#saleinfovoidate').text(data.sales.VoidDate);
                    $('#saleinfounvoidby').text(data.sales.unVoidBy);
                    $('#saleinfunvoiddate').text(data.sales.unVoidDate);
                    $('#saleinfonumberofItemsLbl').text(data.countItem);  
                    $('#saleinfosubtotalLbl').text(numformat(data.sales.SubTotal));
                    $('#salesinfoStatusLbl').text(data.sales.Status);
                    $('#salesinfomemo').text(data.sales.Memo);
                    $('#salesinfoprepareddate').text(data.curdate);
                    $('#salesinfovoidreason').text(data.sales.VoidReason);
                    var st=data.sales.Status;
                    var sto=data.sales.StatusOld;
                    if(st==="Confirmed/Removed")
                    {
                        $('#confirmsales').hide();
                        $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;'>Confirmed/Removed</span>");
                    }
                    else if(st==="Pending/Removed")
                    {
                        $('#confirmsales').show();
                        $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;'>Pending/Removed</span>");
                    }
                    else if(st==="Void")
                    {
                        $('#confirmsales').hide();
                        $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;'>"+st+"("+sto+")</span>");
                    }
                });
                $(".infoscl").collapse('show');
                $('#saledocInfosaleItem').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: true,
                paging: false,
                info: false,
                //retrieve: true,
                destroy:true,
                searchHighlight: true,   
                "order": [[ 0, "asc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
       
         ajax: {
            url: '/deadsalechildsalelist/'+sid,
            type: 'GET',
            dataType: "json",
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
            columns: [
                { data:'id',name: 'id', 'visible': false},
                { data:'DT_RowIndex'},
                { data: 'Code', name: 'Code' },
                { data: 'ItemName', name: 'ItemName' },
                { data: 'SKUNumber', name: 'SKUNumber' },
                { data: 'Quantity', name: 'Quantity',render: $.fn.dataTable.render.number(',', '.',0, '')},
                { data: 'UnitPrice', name: 'UnitPrice',render: $.fn.dataTable.render.number(',', '.', 2, '')},          
                { data: 'TotalPrice', name: 'TotalPrice',render: $.fn.dataTable.render.number(',', '.', 2, '')}
            ],

        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {     
        }
        });     
    }

    function SalesTypeVal()
    {
        var type=$('#SalesType').val();
        if(type==="Internal")
        {
            $('#salescustomer').val(null).trigger('change');
            //$('#salesstore').val("0").trigger('change');
            $('#refrencediv').show();
            $('#ReferenceNumber').val("");
            $('#salesTotalPrice').show();
            $('#salesSellingPr').show();
            $('#salescustomerdiv').show();
            $('#salesPaymentTypeDiv').show();
            $('#destsalesstorediv').show();
            $('#salesstorediv').show();
            $("#destinationsstorelbls").html("Destination Store/Shop");
            $("#srclbls").html("Source Store/Shop");
            $("#destinationlbls").html("Customer");
            $("#SalesType-error").html("");
            // $("#salesdynamicTable").empty();
            // $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th></th>');
        }
        else if(type==="External"||type===""||type===null)
        {
            $('#salescustomer').val(null).trigger('change');
            //$('#salesstore').val("");
            $('#refrencediv').hide();
            $('#ReferenceNumber').val("");
            $('#salesTotalPrice').show();
            $('#salesSellingPr').show();
            $('#salescustomerdiv').show();
            $('#salesPaymentTypeDiv').show();
            $('#destsalesstorediv').hide();
            $('#salesstorediv').show();
            $("#destinationsstorelbls").html("Destination");
            $("#srclbls").html("Source Store/Shop");
            $("#destinationlbls").html("Customer");
            // $("#salesdynamicTable").empty();
            // $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th></th>');
        }
        else if(type==="Disposal")
        {
            $('#salescustomer').val(null).trigger('change');
            //$('#salesstore').val("0").trigger('change');
            $('#refrencediv').hide();
            $('#ReferenceNumber').val("");
            $('#salesTotalPrice').show();
            $('#salesSellingPr').show();
            $('#salescustomerdiv').hide();
            $('#salesPaymentTypeDiv').hide();
            $('#destsalesstorediv').hide();
            $('#salesstorediv').show();
            $("#destinationsstorelbls").html("Destination");
            $("#srclbls").html("Source Store/Shop");
            $("#destinationlbls").html("Customer");
            // $("#salesdynamicTable").empty();
            // $("#salesdynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty. On Hand</th><th>Quantity</th><th>Unit Price</th><th>Total Price</th><th></th>');
        }
        $('#podocumentdatediv').show();
        $('#pomemodiv').show();
        $('#salesdynamicTable').show();
        $('#podynamicbuttonsdiv').show();
        $('#salessavebutton').show();
        $('#salessubtotalLbl').html("");
        $('#SalesType-error').html('');
    }

    function removeReferenceNumberValidation()
    {
        $('#referencenumber-error').html("");
    }

    function removeDestStoreValidation()
    {
        $('#destsalesstore-error').html("");
    }

    function removeundoVoucherNumberErrorclose()
    {
        $('#undoVoucherNumber-error').html("");
        $('#salesvoid-error').html("");
        $('#PulloutReason').val("");
    }
   
   $('#confirmsales').click(function()
   { 
        var headid=$('#infoheaderid').val();
        $('#confirmLbl').text('Do you really want to confirm PullOut?');
        $('#confirmrecid').val(headid);
        $('#checkedst').val('Confirmed');
        $("#pulloutconfirmmodal").modal('show');
    });
    //End change to confirm

    $('#checkedbtnconfirm').click(function()
      { 
            $('#checkedbtnconfirm').prop( "disabled", true );
            var headid=$('#confirmrecid').val();
            $.get("/deadshowSale" +'/' + headid , function (data) 
            { 
                    var status=data.sales.Status;
                    if(status==="Confirmed/Removed")
                    {
                        toastrMessage('error',"PullOut already confirmed","Error");
                        $("#pulloutconfirmmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#saleslaravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                    else if(status==="Void")
                    {
                        toastrMessage('error',"PullOut already voided","Error");
                        $("#pulloutconfirmmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#saleslaravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                    else
                    {
                        var registerForm = $("#pulloutconfirmform");
                        var formData = registerForm.serialize();    
                        $.ajax({
                            url:'/confirmpullout',
                            type:'POST',
                            data:formData,
                            beforeSend:function(){
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
                                $('#checkedbtnconfirm').text('Confirming...');
                                $('#checkedbtnconfirm').prop( "disabled",true);
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
                            success:function(data) 
                            {
                                if(data.success)
                                {
                                    if(data.success)
                                    {
                                        $('#checkedbtnconfirm').prop( "disabled", false );
                                        $('#checkedbtnconfirm').text('Confirm PullOut');
                                        toastrMessage('success',"Successful","Success");
                                        $("#pulloutconfirmmodal").modal('hide');
                                        $("#saledocInfoModal").modal('hide');
                                        $("#pulloutconfirmform")[0].reset();
                                        var oTable = $('#saleslaravel-datatable-crud').dataTable(); 
                                        oTable.fnDraw(false);
                                        $("#itemnamefooter").empty();
                                        var registerForm = $("#salesRegister");
                                        var formData = registerForm.serialize();
                                        $.ajax({
                                            url:'getItemsByDsStore',
                                            type:'DELETE',
                                            data:formData,
                                            success:function(data)
                                            {
                                                if(data.query)
                                                { 
                                                    var options = "<option selected disabled value=''></option>";
                                                    $("#itemnamefooter").append(options); 
                                                    var len=data['query'].length;
                                                    for(var i=0;i<=len;i++)
                                                    {
                                                        var balance=data['query'][i].Balance;
                                                        var storeid=data['query'][i].StoreId;
                                                        var itemid=data['query'][i].ItemId;
                                                        var itemname=data['query'][i].ItemName;
                                                        var code=data['query'][i].Code;
                                                        var skunum=data['query'][i].SKUNumber;
                                                        var option = "<option label='"+balance+"' title='"+storeid+"' value='"+itemid+"'>"+code+'    ,     '+itemname+'    ,   '+skunum+"</option>";
                                                        $("#itemnamefooter").append(option); 
                                                        $("#itemnamefooter").select2();
                                                    } 
                                                }     
                                            },
                                        });
                                    }
                                }
                                if(data.valerror)
                                {
                                    $('#checkedbtnconfirm').prop( "disabled", false);
                                    var singleVal='';
                                    var loopedVal='';
                                    var len=data['valerror'].length;
                                    for(var i=0;i<=len;i++) 
                                    {  
                                        var count=data.countedval;
                                        var inc=i+1;
                                        singleVal=(data['countItems'][i].Name);
                                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                        $('#checkedbtnconfirm').text('Confirm PullOut');
                                        toastrMessage('error',"There is no available quantity for "+count+"  Items"+loopedVal,"Error");
                                        $("#pulloutconfirmmodal").modal('hide');
                                        $("#pulloutconfirmform")[0].reset();
                                    }    
                                }
                            },
                        });
                    }
                });
        });

        //Start Print Attachment
        $('body').on('click', '.dspoatt', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'D S PO', 'width=1200,height=800,scrollbars=yes');
        });
        
        $('body').on('click', '.dshiatt', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'D S HI', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

    function unitpriceActive(ele)
    {
        $(ele).closest('tr').find('.unitprice').prop("readonly", false);
        $(ele).closest('tr').find('.unitprice').css("background","white");
    }

    function sellingPricePer(ele)
    {
        $(ele).closest('tr').find('.SellingPrice').prop("readonly", false);
        $(ele).closest('tr').find('.SellingPrice').css("background","white");
    }

    function unitpriceActiveEd(ele)
    {
      $("#salesUnitPrice").prop("readonly", false);
    }

    function sellingPricePerEd(ele)
    {
      $("#SellingPrice").prop("readonly", false);
    }

    function removedisabled(ele)
    {
      $("#Cost").prop("readonly", false);
    }

    function paymenttyperemoveeroor()
    {
      $("#salespaymenttype-error").html("");
    }
</script>
@endsection
  