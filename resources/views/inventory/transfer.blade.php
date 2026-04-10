@extends('layout.app1')
@section('title')
@endsection
@section('content') 
    @can('Transfer-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom">
                                <div style="width:22%;">
                                    <h3 class="card-title">Stock Transfer</h3>
                                    <label style="font-size: 10px;"></label>
                                    <div class="form-group">
                                        <label style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                        <div>
                                            <select class="select2 form-control" data-style="btn btn-outline-secondary waves-effect" name="fiscalyear[]" id="fiscalyear" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                                            @foreach ($fiscalyears as $fiscalyears)
                                                <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: right;"> 
                                @can('Transfer-Add')
                                    <button type="button" class="btn btn-gradient-info btn-sm addtrabutton" data-toggle="modal">Add</button>
                                @endcan
                                </div>
                            </div>
                            <div class="card-datatable">
                                <div style="width:98%; margin-left:1%;">
                                    <div id="transferdtbldiv">
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:14%;">Transfer Doc. No.</th>
                                                    <th style="width:14%;">Source Store/Shop</th>
                                                    <th style="width:13%;">Destination Store/Shop</th>
                                                    <th style="width:13%;">Requested By</th>
                                                    <th style="width:13%;">Requested Date</th>
                                                    <th style="width:13%;">Transfer Status</th>
                                                    <th style="width:13%;">Dispatch Status</th>
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
            </section>
        </div>
    @endcan

    <!--Toast Start-->
    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert"
        style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!--Toast End-->

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="transferformtitle">Transfer Form</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-sm-12" id="sourceDiv">
                                                <label style="font-size: 14px;">Source Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="SourceStore" id="sstore" onchange="sourcestoreVal()">
                                                        <option selected disabled value=""></option>
                                                        @foreach ($storeSrc as $storeSrc)
                                                            <option value="{{ $storeSrc->StoreId }}">{{ $storeSrc->StoreName }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" class="form-control" name="tid" id="tid" readonly="true" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="sourcestore-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12" id="destinationDiv">
                                                <label style="font-size: 14px;">Destination Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control" name="DestinationStore" id="dstore" onchange="destinationstoreVal()">
                                                        <option selected disabled value=""></option>
                                                        @foreach ($desStoreSrc as $desStoreSrc)
                                                            <option value="{{ $desStoreSrc->StoreId }}">
                                                                {{ $desStoreSrc->StoreName }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="destinationstore-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="sourceEditDiv">
                                                <label style="font-size: 14px;">Source Store/Shop</label>
                                                <div>
                                                    <input type="text" class="form-control" name="soustoredis" id="soustoredis" readonly="true" /></label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="destinationstore-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="desEditDiv">
                                                <label style="font-size: 14px;">Destination Store</label>
                                                <div>
                                                    <input type="text" class="form-control" name="desstoredis" id="desstoredis" readonly="true" /></label>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="destinationstore-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" style="display: none;">
                                                <label style="font-size: 14px;">Requested For</label>
                                                <div>
                                                    <select class="select2 form-control" name="RequestedBy" id="RequestedBy" onchange="requestedByVal()">
                                                        <option selected value="{{ $user }}">{{ $user }}</option>
                                                        @foreach ($users as $users)
                                                            <option value="{{ $users->username }}">{{ $users->username }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="requestedby-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12">
                                                <label style="font-size: 14px;">Date</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="date" name="date" class="form-control"  placeholder="YYYY-MM-DD" onchange="dateVal()" readonly="true" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="date-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12">
                                                <label style="font-size: 14px;">Reason</label>
                                                <div class="input-group input-group-merge">
                                                    <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="2" name="Reason" id="Reason" onkeyup="ReasonVal()"></textarea>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="reason-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-1">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <span id="dynamic-error"></span>
                                        <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th style="width:27%;">Item Name</th>
                                                    <th style="width:11%;">UOM</th>
                                                    <th style="width:15%;">Qty. on Hand</th>
                                                    <th style="width:15%;">Request Qty.</th>
                                                    <th style="width:26%;">Remark</th>
                                                    <th style="width:3%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div style="display: none;">
                                            <table id="editReqItem" class="display table-bordered table-striped table-hover dt-responsive" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>ItemId</th>
                                                        <th>HeaderId</th>
                                                        <th>#</th>
                                                        <th style="width:15%;">Item Code</th>
                                                        <th style="width:20%;">Item Name</th>
                                                        <th style="width:15%;">SKU No.</th>
                                                        <th style="width:10%;">UOM</th>
                                                        <th style="width:10%;">Quantity</th>
                                                        <th style="width:20%;">Remark</th>
                                                        <th style="width:10%;">Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <button type="button" name="addnew" id="addnew" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newreqmodal" onclick="getheaderId();"><i data-feather='plus'></i> Add New</button>
                                        </div>
                                        <table style="width:100%">
                                            <tr>
                                                <td>
                                                    <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> Add New</button>
                                                <td>
                                            </tr>
                                            <tr style="display:none;" class="totalrownumber">
                                                <td colspan="2" style="text-align: right;"></td>
                                            </tr>
                                            <tr style="display:none;" class="totalrownumber">
                                                <td style="text-align: right;"><label style="font-size: 16px;">No. of Items:</label></td>
                                                <td style="text-align: right; width:5%"><label id="numberofItemsLbl" style="font-size: 16px; font-weight: bold;">0</label></td>
                                            </tr>
                                        </table>
                                        <div class="divider infoCommentCardDiv">
                                            <div class="divider-text">-</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-12">
                                                <div class="card infoCommentCardDiv" id="infoCommentCardDiv">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Comment</h6>
                                                        <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                                    </div>
                                                    <div class="card-body">
                                                        <label style="font-size: 16px;" id="commentlbl"></label>
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
                               
                                @foreach ($itemSrc as $itemSrc)
                                    <option value="{{ $itemSrc->ItemId }}">{{ $itemSrc->Code }}   ,   {{ $itemSrc->ItemName }}   ,   {{ $itemSrc->SKUNumber }}</option>
                                @endforeach 
                            </select>
                        </div>
                        @auth
                        <input type="hidden" class="form-control" name="checkqtyonhandval" id="checkqtyonhandval" readonly="true"/>
                        <input type="hidden" class="form-control" name="qtyonhandval" id="qtyonhandval" readonly="true"/>
                        <input type="hidden" class="form-control" name="hiddenstoreval" id="hiddenstoreval" readonly="true"/>
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <input type="hidden" class="form-control" name="uname" id="uname" readonly="true" value="{{ $user }}" />
                        <input type="hidden" class="form-control" name="cdate" id="cdate" readonly="true" value="{{ $curdate }}"/>
                        <input type="hidden" class="form-control" name="transferId" id="transferId" readonly="true" />
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true" /></label>
                        <input type="hidden" class="form-control" name="trnumberi" id="trnumberi" readonly="true" value="" />
                        <input type="hidden" class="form-control" name="numberofItems" id="numberofItems" readonly="true" value="" />
                        <input type="hidden" class="form-control" name="commenttype" id="commenttype" readonly="true" value="" />
                        @endauth
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttona" type="button" class="btn btn-danger closebutton" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start add new hold modal -->
    <div class="modal fade text-left" id="newreqmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeReqAddModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newreqform">
                    @csrf
                    <div>
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="row">
                                    <table style="width: 100%">
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Item Name</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Item Code</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">UOM</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Qty. On Hand</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Quantity</label>
                                            </td>
                                            <td>
                                                <label style="font-size: 14px;">Remark</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%">
                                                <select class="selectpicker form-control itemNames" data-live-search="true"
                                                    data-style="btn btn-outline-secondary waves-effect" name="itemNames"
                                                    id="reqItemname">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($itemSrcEd as $itemSrcEd)
                                                        <option value="{{ $itemSrcEd->ItemId }}">
                                                            {{ $itemSrcEd->Code }} ,
                                                            {{ $itemSrcEd->ItemName }} , {{ $itemSrcEd->SKUNumber }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" class="form-control" name="itid" id="itid"
                                                    readonly="true" />
                                                <input type="hidden" class="form-control" name="receivingidinput"
                                                    id="receivingidinput" readonly="true" />
                                                <input type="hidden" class="form-control" name="receIds" id="receIds"
                                                    readonly="true" />
                                                <input type="hidden" class="form-control" name="recId" id="recId"
                                                    readonly="true" />
                                                <input type="hidden" class="form-control" name="transfereditid"
                                                    id="transfereditid" readonly="true" />
                                                <input type="hidden" class="form-control" name="stId" id="stId"
                                                    readonly="true" />
                                                <input type="hidden" class="form-control" name="desstId" id="desstId"
                                                    readonly="true" />
                                                <input type="hidden" class="form-control" name="receivingstoreid"
                                                    id="receivingstoreid" readonly="true" />
                                                <input type="hidden" class="form-control" name="trEditMaxCost"
                                                    id="trEditMaxCost" readonly="true" />
                                                <input type="hidden" class="form-control" name="editVal" id="editVal"
                                                    value="0" readonly="true" />
                                            </td>
                                            <td style="width: 10%">
                                                <input type="text" name="Code" placeholder="Code" id="reqpartnumber"
                                                    readonly="true" class="reqpartnumber form-control" />
                                            </td>
                                            <td style="width: 10%">
                                                <input type="text" name="UOM" placeholder="UOM" id="requom"
                                                    class="requom form-control" readonly="true" />
                                            </td>
                                            <td style="width: 10%">
                                                <input type="text" class="form-control" name="itemquantity"
                                                    id="itemquantity" value="" readonly="true" />
                                            </td>
                                            <td style="width: 10%">
                                                <input type="number" name="Quantity" placeholder="Quantity" id="reqquantity"
                                                    class="reqquantity form-control" onkeypress="return ValidateNum(event);"
                                                    onkeyup="findQuantitys(this)" ondrop="return false;"
                                                    onpaste="return false;" />
                                            </td>
                                            <td style="width: 30%">
                                                <textarea type="text" placeholder="Write Remark here..."
                                                    class="reqmemo form-control" rows="2" name="reqmemo" id="reqmemo"
                                                    onkeyup="cusReasonV()"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newitemname-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newpartnumber-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newuom-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="qtyonhand-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newquantity-error"></strong>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-danger">
                                                    <strong id="newmemo-error"></strong>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="savenewreq" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttonb" type="button" class="btn btn-danger" onclick="closeReqAddModal()"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End add new hold Modal -->

    <!--Start Receiving Item Delete modal -->
    <div class="modal fade text-left" id="reqremovemodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletereqitemform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 16px;">Are you sure you want to delete</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="reqremoveid" id="reqremoveid"
                                readonly="true">
                            <input type="hidden" class="form-control" name="reqremoveheaderid"
                                id="reqremoveheaderid" readonly="true">
                            <input type="hidden" class="form-control" name="numofitemi" id="numofitemi"
                                readonly="true">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletereqbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Receiving Item Delete Modal -->

    <!--Start Delete modal -->
    <div class="modal fade text-left" id="deletereq" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletereqform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label style="font-size: 16px;font-weight:bold;">Do you really want to void transfer?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                        <div class="form-group">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="delidi" id="delidi" readonly="true">
                        <button id="deletereqdatabtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="reqInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Stock Transfer Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" onclick="closeInfoModal()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="reqInfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <section id="collapsible">
                                                <div class="card collapse-icon">
                                                    <div class="collapse-default">
                                                        <div class="card">
                                                            <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                                <span class="lead collapse-title">Transfer Basic & Action Information</span>
                                                                <div id="statustitlesA"></div>
                                                            </div>
                                                            <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-9 col-md-6 col-sm-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Basic Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td style="width: 32%"><label style="font-size: 14px;">Transfer Doc. No.</label></td>
                                                                                            <td style="width: 68%"><label id="infodocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr style="display: none;">
                                                                                            <td><label style="font-size: 14px;">Issue Doc. No.</label></td>
                                                                                            <td><label id="infoissuedocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Source Store/Shop</label></td>
                                                                                            <td><label id="infosourcestore" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Destination Store/Shop</label></td>
                                                                                            <td><label id="infodestinationstore" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr style="display: none;">
                                                                                            <td><label style="font-size: 14px;">Deliver By</label></td>
                                                                                            <td><label id="infodeliveredby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr style="display: none;">
                                                                                            <td><label style="font-size: 14px;">Shipment Date</label></td>
                                                                                            <td><label id="infodelivereddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Reason</label></td>
                                                                                            <td><label id="infopurpose" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Dispatch Status</label></td>
                                                                                            <td><label id="infodispatchstatus" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!-- <div class="col-lg-8 col-md-6 col-12">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Others Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Requested By</label></td>
                                                                                                    <td><label id="infopreparedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Requested Date</label></td>
                                                                                                    <td><label id="infodate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr style="display: none;">
                                                                                                    <td><label style="font-size: 14px;">Requested For</label></td>
                                                                                                    <td><label id="inforequestby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Approved By</label></td>
                                                                                                    <td><label id="infoapprovedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Approved Date</label></td>
                                                                                                    <td><label id="infoapproveddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Issued By</label></td>
                                                                                                    <td><label id="infoissuedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Issued Date</label></td>
                                                                                                    <td><label id="infoissueddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Received By</label></td>
                                                                                                    <td><label id="inforeceivedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Received Date</label></td>
                                                                                                    <td><label id="inforeceiveddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Void By</label></td>
                                                                                                    <td><label id="infovoidby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Void Date</label></td>
                                                                                                    <td><label id="infovoiddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Void Reason</label></td>
                                                                                                    <td><label id="infovoidreason" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Undo Void By</label></td>
                                                                                                    <td><label id="infoundovoidby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Undo Void Date</label></td>
                                                                                                    <td><label id="infoundovoiddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Comment By</label></td>
                                                                                                    <td><label id="infocommentby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Comment Date</label></td>
                                                                                                    <td><label id="infocommentdate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Comment</label></td>
                                                                                                    <td><label id="infocomment" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Rejected By</label></td>
                                                                                                    <td><label id="inforejectby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Rejected Date</label></td>
                                                                                                    <td><label id="inforejectdate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> -->

                                                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Action Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 col-md-12 col-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                                                            <ul id="actiondiv" class="timeline mb-0 mt-0"></ul>
                                                                                        </div>
                                                                                    </div>
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
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="row" id="detailcontent">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="reqinfodetail" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                            <thead>
                                                <th style="width: 3%;">#</th>
                                                <th style="width: 10%;">Item Code</th>
                                                <th style="width: 10%;">Item Name</th>
                                                <th style="width: 10%;">SKU Number</th>
                                                <th style="width: 7%;">UOM</th>
                                                <th style="width: 10%;">Requested Qty.</th>
                                                <th style="width: 10%;">Approved Qty.</th>
                                                <th style="width: 10%;">Issued Qty.</th>
                                                <th style="width: 10%;">Dispatched Qty.</th>
                                                <th style="width: 10%;">Requested Remark</th>
                                                <th style="width: 10%;">Approved Remark</th>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div> 
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-12">
                                            <div class="card" id="infosCommentCardDiv">
                                                <div class="card-header">
                                                    <h6 class="card-title">Comment</h6>
                                                    <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                                </div>
                                                <div class="card-body">
                                                    <label style="font-size: 16px;" id="commentslbl"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="itemid" id="itemid" readonly="true">
                        <input type="hidden" class="form-control" name="recTrId" id="recTrId" readonly="true">
                        <input type="hidden" class="form-control" name="recTrStatus" id="recTrStatus" readonly="true">
                        <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                        <input type="hidden" class="form-control" name="curdateinfo" id="curdateinfo" readonly="true" value="{{$curdate}}">
                        <button id="pendingtrbtn" type="button" onclick="getTrPendingInfo()" class="btn btn-info actbtns">Change to Pending</button>
                        <button id="backtodraft" type="button" onclick="backToDraftFn()" class="btn btn-info actbtns">Back to Draft</button>

                        <button id="verifybtn" type="button" onclick="verifyFn()" class="btn btn-info actbtns">Verify</button>
                        <button id="backtopending" type="button" onclick="backToPendingFn()" class="btn btn-info actbtns">Back to Pending</button>

                        <button id="backtoverifybtn" type="button" onclick="backToVerifyFn()" class="btn btn-info actbtns">Back to Verify</button>

                        <button id="approvetrbtn" type="button" onclick="getTrApproveInfo()" class="btn btn-info actbtns">Approve</button>
                        <button id="correctiontrbtn" type="button" onclick="getTrCommentInfo()" class="btn btn-info actbtns">Comment</button>
                        <button id="rejecttrbtn" type="button" onclick="getTrRejectInfo()" class="btn btn-info actbtns">Reject</button>
                        <button id="issuetrbtn" type="button" onclick="getTrIssueInfo()" class="btn btn-info actbtns">Issue</button>
                        <button id="receivetrbtn" type="button" onclick="getTrReceiveInfo()" class="btn btn-info actbtns">Receive</button>
                        <button id="closebuttone" type="button" class="btn btn-danger" onclick="closeInfoModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

    <!--Start Approve modal -->
    <div class="modal fade text-left" id="approvetrconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="approvetrform">
                    @csrf
                    <div class="modal-body" style="background-color:#5cb85c">
                        <label style="font-size: 16px; color:white;font-weight:bold;">Do you really want to approve transfer?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="apptrId" id="apptrId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conapprovetrbtn" type="button" class="btn btn-info">Approve</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Approve modal -->

    <!--Start Pending modal -->
    <div class="modal fade text-left" id="pendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="pendingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px; color:white;font-weight:bold;">Do you really want to change transfer to pending?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="pendingtrId" id="pendingtrId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conpendingtrbtn" type="button" class="btn btn-info">Change to Pending</button>
                        <button id="closebuttonpen" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Pending modal -->

    <!--Start Back to Draft modal -->
    <div class="modal fade text-left" id="backtodraftmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeBackToDraftFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backtodraftform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;">Comment</label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="BackToDraftComment" id="BackToDraftComment" onkeyup="commentValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="backtodraft-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="draftid" id="draftid" readonly="true">
                        <button id="backtodraftbtn" type="button" class="btn btn-info">Back to Draft</button>
                        <button id="closebuttonback" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeBackToDraftFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Back to Draft modal -->

    <!--Start Verify modal -->
    <div class="modal fade text-left" id="verifyreqmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="verifyform">
                    @csrf
                    <div class="modal-body" style="background-color:#00CFE8">
                        <label style="font-size: 16px; color:white;font-weight:bold;">Do you really want to verify transfer?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="verifyId" id="verifyId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="converifybtn" type="button" class="btn btn-info">Verify</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Verify modal -->

    <!--Start Back to Pending modal -->
    <div class="modal fade text-left" id="backtopendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeBackToPendingFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backtopendingform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;">Comment</label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="BackToPendingComment" id="BackToPendingComment" onkeyup="backToPenValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="backtopending-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="backtopendingid" id="backtopendingid" readonly="true">
                        <button id="backtopendingbtn" type="button" class="btn btn-info">Back to Pending</button>
                        <button id="closebacktopending" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeBackToPendingFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Back to Pending modal -->

    <!--Start Back to Verify modal -->
    <div class="modal fade text-left" id="backtoverifymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeBackToVerifyFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backtoverifyform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;">Comment</label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="BackToVerifyComment" id="BackToVerifyComment" onkeyup="backToVerifyValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="backtoverify-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="backtoverifyid" id="backtoverifyid" readonly="true">
                        <button id="backtoverifybutton" type="button" class="btn btn-info">Back to Verify</button>
                        <button id="closebacktoverifybtn" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeBackToVerifyFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Back to Verify modal -->

    <!--Start Receive modal -->
    <div class="modal fade text-left" id="receivetrconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="receivetrform">
                    @csrf
                    <div class="modal-body" style="background-color:#5cb85c">
                        <label style="font-size: 16px; color:white;font-weight:bold;">Do you really want to receive issued transfer?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="receivetrId" id="receivetrId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conreceivetrbtn" type="button" class="btn btn-info">Receive</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Receive modal -->

    <!--Start Comment modal -->
    <div class="modal fade text-left" id="commentTrModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closecommenttr()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="commenttrform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label style="font-size: 16px;">Put some comment</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Comment</div>
                        </div>
                        <label style="font-size: 16px;"></label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="Comment" id="CommentTr" onkeyup="commentTrVal()" autofocus></textarea>
                            <span class="text-danger">
                                <strong id="commenttr-error"></strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="commenttrid" id="commenttrid" readonly="true">
                            <input type="hidden" class="form-control" name="commenttrstatus" id="commenttrstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="contrcommentbtn" type="button" class="btn btn-info">Comment</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closecommenttr()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Comment modal -->

    <!--Start Reject modal -->
    <div class="modal fade text-left" id="rejecttrconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejecttrform">
                    @csrf
                    <div class="modal-body" style="background-color:#d9534f">
                        <label style="font-size: 16px;color:white;font-weight:bold;">Do you really want to reject transfer?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="rejtrId" id="rejtrId" readonly="true">
                            <input type="hidden" class="form-control" name="rejtrstatus" id="rejtrstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conrejecttrbtn" type="button" class="btn btn-info">Reject</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Reject modal -->

    <!--Start Issue modal -->
    <div class="modal fade text-left" id="issuetrconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="issuetrform">
                    @csrf
                    <div class="modal-body" style="background-color:#4e73df">
                        <label style="font-size: 16px;font-weight:bold;color:white">Do you really want to Issue?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="issuetrId" id="issuetrId" readonly="true">
                            <input type="hidden" class="form-control" name="issuetrStatusi" id="issuetrStatusi" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="conissuetrbtn" type="button" class="btn btn-info">Issue</button>
                        <button id="closebuttonc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Issue modal -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to undo void transfer?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                            <input type="hidden" class="form-control" name="ustatus" id="ustatus" readonly="true">
                            <input type="hidden" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="undovoidbtn" type="button" class="btn btn-info">Undo Void</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo void modal -->

    <!--Start Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="approvemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="ApproveForm">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" style="width:93%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header">
                        <h4 class="modal-title" id="approvetitle">Approve Requested Item</h4>
                        <div style="text-align: center;padding-right:30px;" id="appstatusdisplay"></div>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row mt-1">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse3" class="card-header" data-toggle="collapse" role="button" data-target=".infotrn" aria-expanded="false" aria-controls="collapse2">
                                                        <span class="lead collapse-title" id="approvespan">Transfer Basic Information</span>
                                                    </div>
                                                    <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse3" class="collapse infotrn">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-12">
                                                                    <table style="width: 100%;">
                                                                        <tr>
                                                                            <td colspan="2" style="text-align: left;font-size:16px"><b>Basic Information</b></td>
                                                                        </tr>
                                                                        <tr><td colspan="2"></td></tr>
                                                                        <tr>
                                                                            <td style="width: 28%;"><label style="font-size: 14px;">Transfer Doc. No.</label></td>
                                                                            <td style="width: 72%;"><label id="apprdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr style="display: none;">
                                                                            <td><label style="font-size: 14px;">Issue Doc. No.</label></td>
                                                                            <td><label id="apprissuedocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Source Store/Shop</label></td>
                                                                            <td><label id="apprsourcestore" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Destination Store/Shop</label></td>
                                                                            <td><label id="apprdestinationstore" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label style="font-size: 14px;">Reason</label></td>
                                                                            <td><label id="apprpurpose" style="font-size: 14px;font-weight:bold;"></label></td>
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
                            
                            <div class="row" id="apprdiv">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <table id="apprDynamicTable" class="mb-0 rtable" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:8%;">Item Code</th>
                                                <th style="width:16%;">Item Name</th>
                                                <th style="width:8%;">SKU No.</th>
                                                <th style="width:7%;">UOM</th>
                                                <th style="width:10%;" title="Quantity on Hand">Qty. on Hand</th>
                                                <th style="width:10%;" title="Requested Quantity">Requested Qty.</th>
                                                <th style="width:10%;" title="Approved Quantity">Approved Qty.</th>
                                                <th style="width:14%;">Request Remark</th>
                                                <th style="width:14%;">Approve Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>                                    
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="appcheckqty" id="appcheckqty" readonly="true"/>
                        <input type="hidden" class="form-control" name="appqtyonhandval" id="appqtyonhandval" readonly="true"/>
                        <input type="hidden" class="form-control" name="recAppId" id="recAppId" readonly="true" value=""/> 
                        <button id="approvetransfer" type="button" class="btn btn-info">Approve</button>
                        <button id="closebuttonstockbl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Information Modal -->

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        var fyears=$('#fiscalyear').val();
        $(function () {
            cardSection = $('#page-block');
        });

        var j2=0;
        var i2=0;
        var m2=0;

        //Start page load event
        $(document).ready(function() {
            $('#fiscalyear').select2();
            $("#fiscalyear option:first").attr('selected','selected');
            getTransferData(fyears);
            var today = new Date();
            var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
            var dd = today.getDate();
            var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : +(today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate = yyyy + "-" + mm + "-" + dd;
            $('#date').val(currentdate);
            $("#dynamicTable").show();
            $("#editReqItem").hide();
            $("#addhold").hide();
            $(".selectpicker").selectpicker({
                noneSelectedText: ''
            });
            $('#destinationDiv').show();
            $('#sourceDiv').show();
            $('#typeDiv').show();
            $('#sourceEditDiv').hide();
            $('#desEditDiv').hide();
            $('#typeEditDiv').hide();
            $('.infoCommentCardDiv').hide();
            $("#date").prop('readonly', true);
        });
        //End page load event

        function getTransferData(fyears){
            var fy="";
            $('#transferdtbldiv').hide();
            $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                "order": [[0, "desc"]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/transferdata',
                    type: 'POST',
                    dataType: "json",
                    data:{
                        fy:fyears,
                    },
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
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"14%"
                    },
                    {
                        data: 'SourceStore',
                        name: 'SourceStore',
                        width:"14%"
                    },
                    {
                        data: 'DestinationStore',
                        name: 'DestinationStore',
                        width:"13%"
                    },
                    {
                        data: 'PreparedBy',
                        name: 'PreparedBy',
                        width:"13%"
                    },
                    {
                        data: 'Date',
                        name: 'Date',
                        width:"13%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-info bg-glow">'+data+'</span>';
                            }
                            else if(data == "Checked" || data == "Issued" || data == "Reviewed" || data == "Issued(Received)" || data == "Issued(Partially-Received)" || data == "Issued(Fully-Received)"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Approved"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Rejected" || data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Approved)" || data == "Void(Issued)"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"13%"
                    },
                    {
                        data: 'DispatchStatus',
                        name: 'DispatchStatus',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Partially-Dispatched"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Fully-Dispatched"){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else{
                                return data;
                            }
                        },
                        width:"13%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width:"4%"
                    }
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
                    $('#transferdtbldiv').show();
                },
            });
            $.fn.dataTable.ext.errMode = 'throw';
        }

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        //Start get hold number value
        $('body').on('click', '.addtrabutton', function() {
            $("#inlineForm").modal('show');
            $("#transferformtitle").html('Add Stock Transfer');
            $('#tid').val("");
            $('#transferId').val("");
            $('#operationtypes').val("1");
            $('#hiddenstoreval').val("");
            $.get("/gettransfernumber", function(data) {
                $('#trnumberi').val(data.reqnum);
                var dbval = data.TransferCount;
                var rnum = (Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
                $('#commonVal').val(rnum + dbval);
            });

            $('#sstore').select2
            ({
                placeholder: "Select Source Store/Shop here",
            });

            $('#dstore').select2
            ({
                placeholder: "Select Destination Store/Shop here",
            });

            var currentdate=$("#cdate").val();
            flatpickr('#date',{dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate});
            $('#date').val(currentdate);
            $("#dynamicTable").show();
            $("#adds").show();
            $("#editReqItem").hide();
            $("#addnew").hide();
            $('#destinationDiv').show();
            $('#sourceDiv').show();
            $('#typeDiv').show();
            $('#sourceEditDiv').hide();
            $('#desEditDiv').hide();
            $('#typeEditDiv').hide();
            $('.infoCommentCardDiv').hide();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
        });
        //End get hold number value

        //Start type change
        $('#sstore').on('change', function() {
            var sid = $('#supplier').val();
            var storeidvar = $('#sstore').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/syncDynamicTabletr',
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
                    var itemprop="";
                    var totalrow=$('#numberofItemsLbl').text();
                    
                    $('.AvQuantity').val("0");
                    $('#qtyonhandval').val(data.qtyonhandflg);
                    $('#checkqtyonhandval').val(data.checkqtyonhand);
                    $.each(data.bal, function(key, value) {
                        ++q;
                        var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(1).find('select').val();
                        if(itemids==value.ItemId){
                            //var qtyonhand=value.Balance;
                            var reqbalance=value.ReqBalance;
                            var trnbalance=value.TrnBalance;
                            var salesbl=value.SalesBalance;
                            var balances=value.Balance;
                            var qtyonhand=0;
                            var consolidatebal=parseFloat(value.Balance)-parseFloat(value.TrnBalance)-parseFloat(value.ReqBalance);
                            if(parseFloat(consolidatebal)<=0){
                                qtyonhand=0;
                            }
                            else if(parseFloat(consolidatebal)>0){
                                qtyonhand=consolidatebal;
                            }
                            var qty=$('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val();
                            if(parseInt(data.qtyonhandflg)==0){
                                $('#dynamicTable tr:eq('+q+')').find('td').eq(4).find('input').val(qtyonhand);
                            }
                            if((parseFloat(qtyonhand)<parseFloat(qty) || parseFloat(qtyonhand)==0) && parseInt(data.checkqtyonhand)==1){
                                $('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val("");
                            }

                            itemprop+=value.ItemName+"<br>Pending Sales: "+salesbl+"<br>Pending Transfer: "+trnbalance+"<br>Pending Requisition: "+reqbalance+"<br>---------------<br>";
                        }
                    });

                    for(var y=1;y<=m;y++){
                        var qtyonhand=($('#AvQuantity'+y)).val()||0;
                        var qty=($('#quantity'+y)).val()||0;
                        if((parseFloat(qtyonhand)<parseFloat(qty)|| parseFloat(qtyonhand)==0) && parseInt(data.checkqtyonhand)==1){
                            ($('#quantity'+y)).val("");
                        }
                    }

                    if(parseInt(data.qtyonhandflg)==1){
                        $('.AvQuantity').val("");
                    }

                    if(itemprop!=''){
                        //toastrMessage('info',itemprop,"Info");
                    }
                },
                
            });
        });
        //End Type change

        //Start type change
        $(document).ready(function() {
            $('#reqtype').on('change', function() {
                var reqTypeVar = $('#reqtype').val();
                if (reqTypeVar == "Goods") {
                    $('#destinationDiv').show();
                    $('#dstore').val(null).trigger('change');
                } else if (reqTypeVar == "Consumption") {
                    $('#destinationDiv').hide();
                    $('#dstore').val(null).trigger('change');
                }
                appendTable();
            });
        });
        //End Type change

        //Start destination store change
        $(document).ready(function() {
            $('#dstore').on('change', function() {

                var destore = $('#dstore').val();
                $('.desstoreid').val(destore);
            });
        });
        //End destination store change

        //Start save requistion
        $('#savebutton').click(function() {
            var sstr = sstore.value;
            var dstr = dstore.value;
            var optype=$('#operationtypes').val();
            var arr = [];
            var found = 0;
            $('.itemName').each(function() {
                var name = $(this).val();
                if (arr.includes(name)) {
                    found++;
                } else {
                    arr.push(name);
                }
            });
            if (found) {
                if(parseFloat(optype)==1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                }
                else if(parseFloat(optype)==2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"There is duplicate item","Error");
            } else {
                var numofitems = $('#numberofItems').val();
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/saveTransfer',
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
                    success: function(data) {
                        if (data.errors) {
                            if (data.errors.trnumberi) {
                                if(parseFloat(optype)==1){
                                    $('#savebutton').text('Save');
                                    $('#savebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#savebutton').text('Update');
                                    $('#savebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Document Number already exist </br> close this window and start again","Error");
                            }
                            if (data.errors.SourceStore) {
                                if(parseFloat(optype)==1){
                                    $('#savebutton').text('Save');
                                    $('#savebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#savebutton').text('Update');
                                    $('#savebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Check your inputs","Error");
                                $('#sourcestore-error').html(data.errors.SourceStore[0]);
                            }
                            if (data.errors.DestinationStore) {
                                if(parseFloat(optype)==1){
                                    $('#savebutton').text('Save');
                                    $('#savebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#savebutton').text('Update');
                                    $('#savebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Check your inputs","Error");
                                $('#destinationstore-error').html(data.errors.DestinationStore[0]);
                            }
                            if (data.errors.date) {
                                if(parseFloat(optype)==1){
                                    $('#savebutton').text('Save');
                                    $('#savebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#savebutton').text('Update');
                                    $('#savebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Check your inputs","Error");
                                $('#date-error').html("date must be current date");
                            }
                            if (data.errors.RequestedBy) {
                                if(parseFloat(optype)==1){
                                    $('#savebutton').text('Save');
                                    $('#savebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#savebutton').text('Update');
                                    $('#savebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Check your inputs","Error");
                                $('#requestedby-error').html(data.errors.RequestedBy[0]);
                            }
                            if (data.errors.Reason) {
                                if(parseFloat(optype)==1){
                                    $('#savebutton').text('Save');
                                    $('#savebutton').prop("disabled", false);
                                }
                                else if(parseFloat(optype)==2){
                                    $('#savebutton').text('Update');
                                    $('#savebutton').prop("disabled", false);
                                }
                                toastrMessage('error',"Check your inputs","Error");
                                $('#reason-error').html(data.errors.Reason[0]);
                            }
                        } 
                        else if (data.errorv2) {
                            var error_html = '';
                            for(var k=1;k<=m;k++){
                                var itmid=($('#itemNameSl'+k)).val();
                                if(($('#quantity'+k).val())!=undefined){
                                    var qnt=$('#quantity'+k).val();
                                    var qntonhand=$('#AvQuantity'+k).val();
                                    if(isNaN(parseFloat(qnt))||parseFloat(qnt)==0){
                                        $('#quantity'+k).css("background", errorcolor);
                                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                    }
                                    if(parseFloat(qnt)>parseFloat(qntonhand)){
                                        $('#quantity'+k).css("background", errorcolor);
                                        toastrMessage('error',"Quantity is greater than available quantity!","Error");
                                    }
                                }
                                if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                                    $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                                    toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                }
                            }
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }   
                        } 
                        else if(data.emptyerror){
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
                        else if(data.differencefy){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Source and Destination Store/Shop should be in the same Fiscal Year","Error");
                        } 
                        else if(data.strdifferrors){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"You cant change current store/shop to posted store/shop","Error");
                        } 
                        else if (found) {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"There is duplicate entry","Error");
                        } else if (numofitems == 0) {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please add atleast one item","Error");
                        } else if (data.success) {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('success',"Successful","Success");
                            closeModalWithClearValidation();
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            $("#inlineForm").modal('hide');
                        }
                    },
                });
            }
        });
        //End save requistion

        //Start Approve 
        $('#approvetransfer').click(function() { 
            var registerForm = $("#ApproveForm");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/approveTransfer',
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
                    $('#approvetransfer').text('Approving...');
                    $('#approvetransfer').prop("disabled",true);
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
                    if (data.errorv2) {
                        for(var k=1;k<=m2;k++){
                            if(($('#appqnt'+k).val())!=undefined){
                                var qnt=$('#appqnt'+k).val();
                                if(isNaN(parseFloat(qnt))){
                                    $('#appqnt'+k).css("background", errorcolor);
                                }
                            }
                        }
                        $('#approvetransfer').text('Approve');
                        $('#approvetransfer').prop("disabled",false);
                        toastrMessage('error',"Please fill all highlighted fields","Error");
                    }
                    else if (data.dberrors) {
                        $('#approvetransfer').text('Approve');
                        $('#approvetransfer').prop("disabled",false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#approvemodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        $('#approvetransfer').text('Approve');
                        $('#approvetransfer').prop("disabled",false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });
        //End Approve

        //Start get hold number value
        $('body').on('click', '#getReqDocNum', function() {
            $.get("/gettransfernumber", function(data) {
                $('#trnumberi').val(data.reqnum);
                $("#myToast").toast('hide');
            });
        });
        //End get hold number value

        //start close modal function
        function closeModalWithClearValidation() {
            var uname = $("#uname").val();
            $("#Register")[0].reset();
            $('#type-error').html("");
            $('#sourcestore-error').html("");
            $('#destinationstore-error').html("");
            $('#date-error').html("");
            $('#reason-error').html("");
            $('#purpose-error').html("");
            $('#destinationDiv').show();
            $('#sstore').val(null).select2();
            $('#dstore').val(null).select2();
            $('#RequestedBy').selectpicker('val', uname).trigger('change');
            var today = new Date();
            var dd = today.getDate();
            var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : +(today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate = yyyy + "-" + mm + "-" + dd;
            var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
            $('#date').val(currentdate);
            $('#destinationDiv').show();
            $('#sourceDiv').show();
            $('#typeDiv').show();
            $('#sourceEditDiv').hide();
            $('#desEditDiv').hide();
            $('#typeEditDiv').hide();
            $('.infoCommentCardDiv').hide();
            appendTable();
            $('.totalrownumber').hide();
        }
        //End close modal function

        //Start save new hold record
        $('body').on('click', '#savenewreq', function() {
            var registerForm = $('#newreqform');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/savenewTransferItem',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#savenewreq').text('Saving...');
                    $('#savenewreq').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.itemName) {
                            $('#newitemname-error').html(data.errors.itemName[0]);
                        }
                        if (data.errors.Quantity) {
                            $('#newquantity-error').html(data.errors.Quantity[0]);
                        }
                        $('#savenewreq').text('Save');
                        $('#savenewreq').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.dberrors) {
                        $('#newitemname-error').html("The item has already been taken.");
                        $('#savenewreq').text('Save');
                        $('#savenewreq').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#savenewreq').text('Save');
                        toastrMessage('success',"Successful","Success");
                        $("#newreqmodal").modal('hide');
                        var oTable = $('#editReqItem').dataTable();
                        oTable.fnDraw(false);
                        $('#editVal').val("0");
                        $('#numberofItems').val(data.Totalcount);
                        closeReqAddModal();
                        $('#savenewreq').prop("disabled", false);
                    }
                },
            });
        });
        //Ends save new hold record

        //Open Delete Modal With Value Starts
        $('#reqremovemodal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var hid = button.data('hid');
            var modal = $(this);
            modal.find('.modal-body #reqremoveid').val(id);
            modal.find('.modal-body #reqremoveheaderid').val(hid);
        });
        //Open Delete Modal With Value Ends

        //Delete requisition Item Records Starts
        $('#deletereqbtn').click(function() {
            var numofitem = $("#numberofItems").val();
            $("#numofitemi").val(numofitem);
            if (parseFloat(numofitem) == 1) {
                toastrMessage('error',"You cant remove all items","Error");
            } else if (parseFloat(numofitem) >= 2) {
                var delid = document.forms['deletereqitemform'].elements['reqremoveid'].value;
                var deleteForm = $("#deletereqitemform");
                var formData = deleteForm.serialize();
                $.ajax({
                    url: '/deleteTrItem/' + delid,
                    type: 'DELETE',
                    data: formData,
                    beforeSend: function() {
                        $('#deletereqbtn').text('Deleting...');
                        $('#deletereqbtn').prop("disabled", true);
                    },
                    success: function(data) {
                        $('#deletereqbtn').text('Delete');
                        toastrMessage('success',"Deleted","Success");
                        var oTable = $('#editReqItem').dataTable();
                        oTable.fnDraw(false);
                        $("#reqremovemodal").modal('hide');
                        $('#numberofItems').val(data.Totalcount);
                        $('#deletereqbtn').prop("disabled", false);
                    }
                });
            }
        });
        //Delete requisition Item Records Ends

        //Open Delete Modal With Value Ends
        $('body').on('click', '.deleteRequisitionRecord', function() {
            var recIdVar = $(this).data('id');
            var fysetting="";
            var fyearstrs="";
            var desfyearstrs="";
            $('#delidi').val(recIdVar);
            $('.Reason').val("");
            $.get("/transferstatus" + '/' + recIdVar, function(data) {
                var statusvals = data.trstatusdata.Status;
                var fiscalyrreq = data.trstatusdata.fiscalyear;
                fysetting=data.fyear;
                fyearstrs=data.fyearstr;
                desfyearstrs=data.desfyearstr;
                if(parseFloat(fiscalyrreq)!=parseFloat(fyearstrs) || parseFloat(fiscalyrreq)!=parseFloat(desfyearstrs)){
                    toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                }
                else if (statusvals === "Pending" || statusvals === "Issued" || statusvals === "Approved") {
                    $('#Reason').val("");
                    $('#void-error').html("");
                    $("#deletereq").modal('show');
                } else {
                    toastrMessage('error',"Unable to void transfer on this status","Error");
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            });
        });

        //Delete requisition Item Records Starts
        $('#deletereqdatabtn').click(function() {
            var delid = document.forms['deletereqform'].elements['delidi'].value;
            var deleteForm = $("#deletereqform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/deleteTrData/' + delid,
                type: 'DELETE',
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
                    $('#deletereqdatabtn').text('Voiding...');
                    $('#deletereqdatabtn').prop("disabled", true);
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
                    if (data.errors) {
                        if (data.errors.Reason) {
                            $('#void-error').html(data.errors.Reason[0]);
                        }
                        $('#deletereqdatabtn').text('Void');
                        $('#deletereqdatabtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#deletereqdatabtn').text('Void');
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#deletereq").modal('hide');
                        $('#deletereqdatabtn').prop("disabled", false);
                    }
                }
            });
        });
        //Delete requisition Item Records Ends

        //start edit transfer item modal
        $('body').on('click', '.editTransferDatas', function() {
            $('#savenewreq').text("Update");
            var itemn = "";
            var recItemVar = $(this).data('id');
            var reqheaderid = $(this).data('hid');
            var reqitemid = $(this).data('iid');
            var reqitemname = $(this).data('itemname');
            var requomvar = $(this).data('uom');
            var reqcodevar = $(this).data('code');
            $('#transfereditid').val(recItemVar);
            $('#newreqmodal').modal('show');
            $.get("/transferitemedit" + '/' + recItemVar, function(data) {
                itemn = data.transferDataId.ItemId;
                console.log(itemn);
                $('#reqpartnumber').val(reqcodevar);
                $('#requom').val(requomvar);
                $('#reqquantity').val(data.transferDataId.Quantity);
                $('#reqmemo').val(data.transferDataId.Memo);
                $('#stId').val(data.transferDataId.StoreId);
                $('#desstId').val(data.transferDataId.DestStoreId);
                $('#editVal').val("1");
                $('#reqItemname').selectpicker('val', itemn).trigger('change');
                $('#reqItemname').selectpicker();
            });
            var stid = $('#sstore').val();
            $('#receivingstoreid').val(stid);
            var hid = $('#transferId').val();
            $('#receIds').val(reqheaderid);
            $('#itid').val(reqitemid);

            $.ajax({
                url: 'getEditTrItemBalance/' + reqitemid,
                type: 'POST',
                data: formData,
                success: function(data) {
                    if (data.sid) {
                        var len = data['sid'].length;
                        for (var i = 0; i <= len; i++) {
                            var quantitys = (data['sid'][i].AvailableQuantity);
                            $('#itemquantity').val(quantitys);
                        }
                    }
                },
            });
        });
        //end edit hold item modal

        //Start edit item change
        $(document).ready(function() {
            $('#reqItemname').on('change', function() {
                $('#newitemname-error').html("");
                var itemid = $('#reqItemname').val();
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getEditTrItemBalance/' + itemid,
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var len = data['sid'].length;
                            for (var i = 0; i <= len; i++) {
                                var quantitys = (data['sid'][i].AvailableQuantity);
                                $('#itemquantity').val(quantitys);
                                var takenquantity = $('#reqquantity').val();
                                var partnum = (data['itinfo'][i].PartNumber);
                                var uoms = (data['itinfo'][i].UOM);
                                var codes = (data['itinfo'][i].Code);
                                var maxcost = (data['getCost'][i].UnitCost);
                                $('#reqpartnumber').val(codes);
                                $('#requom').val(uoms);
                                $('#trEditMaxCost').val(maxcost);
                                if (parseFloat(takenquantity) > parseFloat(quantitys)) {
                                    $('#reqquantity').val("");
                                }
                                if (quantitys == null) {
                                    $('#itemquantity').val("0");
                                }
                            }
                        }
                    },
                });
            });
        });
        //End edit item change

        //Start append item dynamically
        var j = 0;
        var i = 0;
        var m = 0;
        $("#adds").click(function() {
            var storeidvar = $('#sstore').val();
            var desstoreidvar = $('#dstore').val();
            var lastrowcount=$('#dynamicTable > tbody > tr:last').find('td').eq(15).find('input').val();
            var itemids=$('#itemNameSl'+lastrowcount).val();
            if(isNaN(parseFloat(storeidvar))||storeidvar==null){
                toastrMessage('error',"Please select source store/shop first","Error");
                $('#sourcestore-error').html("The source store/shop field is required.");
            }
            else if(itemids!==undefined && itemids===null){
                $('#select2-itemNameSl'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                toastrMessage('error',"Please select item from highlighted field","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                $("#dynamicTable > tbody").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="width:27%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="width:12%;display:none;"><input type="text" name="row['+m+'][Code]" placeholder="Code" id="Code'+m+'" class="Code form-control" readonly="true"/></td>'+
                    '<td style="width:11%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true"/></td>'+
                    '<td style="width:15%;"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" placeholder="Quantity on Hand" class="AvQuantity form-control" readonly="true"/></td>'+
                    '<td style="width:15%;"><input type="number" name="row['+m+'][Quantity]" onkeyup="checkQ(this)" placeholder="Requested Quantity" id="quantity'+m+'" class="quantity form-control numeral-mask" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>'+
                    '<td style="width:26%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control" placeholder="Write remark here..."/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DestStoreId]" id="desstoreid'+m+'" class="desstoreid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Transfer" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DestStoreQuantity]" id="DestStoreQuantity'+m+'" class="DestStoreQuantity form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" class="UnitCost form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idval'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>');
                var rnum = $('#commonVal').val();
                $('.common').val(rnum);
                $('.storeid').val(storeidvar);
                $('.desstoreid').val(desstoreidvar);
                var opt = '<option selected disabled value=""></option>';
                var options = $("#allitems > option").clone();
                $('#itemNameSl'+m).append(options); 
                //$("#itemNameSl"+m+" option[title!='"+storeidvar+"']").remove();
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
                renumberRows();
                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });
        //End append item dynamically

        //start select item
        function itemVal(ele) {
            var idval = $(ele).closest('tr').find('.idval').val();
            var stid = $('#storeid'+idval).val(); 
            var itid = $('#itemNameSl'+idval).val(); 
            var qtyonhandflg = $('#qtyonhandval').val(); 
            var checkqtyonhand = $('#checkqtyonhandval').val(); 
            var itemid=null;
            var arr = [];
            var found = 0;
            var storeidvar = null;
            var desstoreidvar = null;
            var itemtax =0;
            var quantitys=0;
            var salesqty =0;
            var transferqty=0;
            var requistionqty=0;
            var totalquantity=0;
            var maxcost = 0;
            var totaltax=0;
            var totalamount=0;
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
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
                $('#itemNameSl'+idval).val("0").trigger('change');
                $('#uom'+idval).val("");
                $('#AvQuantity'+idval).val("");
                $('#quantity'+idval).val("");
                $('#UnitCost'+idval).val("");
                $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
            }
            else{
                $.ajax({
                    url: "{{url('getEditTrItemBalance')}}",
                    type: 'POST',
                    data:{
                        itemid:itid,
                        storeidvar: $('#sstore').val(),
                        desstoreidvar: $('#dstore').val(),
                    },
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
                    success: function(data) {
                        $.each(data.itinfo, function(key, value) {
                            $('#Code'+idval).val(value.Code);
                            $('#uom'+idval).val(value.UOM);
                            $('#ItemType'+idval).val(value.Type);
                            itemtax=value.TaxTypeId;
                        });

                        maxcost=data.getCost;
                        salesqty=data.salesqnt;
                        transferqty=data.trnqnt;
                        requistionqty=data.reqqnt;
                        totalquantity=parseFloat(data.avqnt)-parseFloat(data.salesqnt)-parseFloat(data.trnqnt)-parseFloat(data.reqqnt);
                        totaltax = (parseFloat(maxcost) * parseFloat(itemtax)) / 100;
                        totalamount = parseFloat(totaltax) + parseFloat(parseFloat(maxcost));
                        $('#AvQuantity'+idval).val(data.avqnt); 
                        $('#UnitCost'+idval).val(data.getCost);
                        $('#quantity'+idval).val("");

                        if ((parseFloat(totalquantity) == null || parseFloat(totalquantity)<=0) && parseInt(qtyonhandflg)==0) {
                            $('#AvQuantity'+idval).val("");
                        }
                        else if (parseFloat(totalquantity)>0 && parseInt(qtyonhandflg)==0) {
                            $('#AvQuantity'+idval).val(totalquantity);
                        }
                        else if(parseInt(qtyonhandflg)==1){
                            $('#AvQuantity'+idval).val("");
                        }

                        //if(parseFloat(data.salesqn)>0||parseFloat(data.trnqnt)>0||parseFloat(data.reqqnt)>0){
                            //toastrMessage('info',itemname+"<br>Pending Sales: "+salesqty+"<br>Pending Transfer: "+transferqty+"<br>Pending Requisition: "+requistionqty,"Info");
                        //}

                        $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");

                        // if (data.sid) {
                        //     var len = data['sid'].length;
                        //     for (var i = 0; i <= len; i++) {
                        //         var quantitys = (data['sid'][i].AvailableQuantity);
                        //         var salesqty = (data['salesqnt'][i].TotalSalesQuantity);
                        //         var transferqty = (data['trnqnt'][i].TotalTrnQuantity);
                        //         var requistionqty = (data['reqqnt'][i].TotalReqQuantity);
                        //         var 
                        //         $(ele).closest('tr').find('.AvQuantity').val(quantitys);
                        //         var partnum = (data['itinfo'][i].PartNumber);
                        //         var uoms = (data['itinfo'][i].UOM);
                        //         var codes = (data['itinfo'][i].Code);
                        //         var itemtype = (data['itinfo'][i].Type);
                        //         var itemtax = (data['itinfo'][i].TaxTypeId);
                        //         var itemname = (data['itinfo'][i].Name);
                        //         var maxcost = (data['getCost'][i].UnitCost);
                        //         var totaltax=0;
                        //         var totalamount=0;
                                
                                
                        //         $(ele).closest('tr').find('.Code').val(codes);
                        //         $(ele).closest('tr').find('.uom').val(uoms);
                        //         $(ele).closest('tr').find('.ItemType').val(itemtype);
                        //         $(ele).closest('tr').find('.UnitCost').val(maxcost);
                        //         $(ele).closest('tr').find('.quantity').val("");

                                
                        //     }
                        // }
                    },
                });
            }
        }
        //end select type

        //start quantity check
        function checkQ(ele) {
            var idval = $(ele).closest('tr').find('.idval').val();
            var availableq = $('#AvQuantity'+idval).val();
            var quantity = $('#quantity'+idval).val();
            var qtyonhandflg = $('#qtyonhandval').val(); 
            var checkqtyonhand = $('#checkqtyonhandval').val(); 
            availableq = availableq == '' ? 0 : availableq;
            quantity = quantity == '' ? 0 : quantity;
            qtyonhandflg = qtyonhandflg == '' ? 0 : qtyonhandflg;
            checkqtyonhand = checkqtyonhand == '' ? 0 : checkqtyonhand;
            $('#quantity'+idval).css("background","white");
            
            if ((parseFloat(quantity) > parseFloat(availableq)) && parseInt(checkqtyonhand)==0 && parseInt(qtyonhandflg)==0) {
                toastrMessage('error',"There is no available quantity","Error");
                $('#quantity'+idval).val("");
                $('#quantity'+idval).css("background",errorcolor);
            }
            if (parseFloat(quantity) == 0) {
                $('#quantity'+idval).val("");
            } 
        }
        //end quantity check

        //start quantity check
        function checkAppQnt(ele) {
            var idval = $(ele).closest('tr').find('.appidval').val();
            var qtyonhand = $('#appqtyonhand'+idval).val();
            var qty = $('#appqnt'+idval).val();
            var qtyonhandflg = $('#appqtyonhandval').val(); 
            var checkqtyonhand = $('#appcheckqty').val(); 

            qtyonhand = qtyonhand == '' ? 0 : qtyonhand;
            qty = qty == '' ? 0 : qty;
            qtyonhandflg = qtyonhandflg == '' ? 0 : qtyonhandflg;
            checkqtyonhand = checkqtyonhand == '' ? 0 : checkqtyonhand;

            $('#appqnt'+idval).css("background","white");

            if(parseFloat(qty)>parseFloat(qtyonhand) && parseInt(qtyonhandflg)==0){
                toastrMessage('error',"There is no available quantity","Error");
                $('#appqnt'+idval).val("");
                $('#appqnt'+idval).css("background",errorcolor);
            }
        }
        //end quantity check

        //start quantity check
        function findQuantitys(ele) {
            var availableq = $('#itemquantity').val();
            var quantity = $('#reqquantity').val();
            if (parseFloat(quantity) > parseFloat(availableq)) {
                toastrMessage('error',"There is no available quantity","Error");
                $('#reqquantity').val("");
            }
            if (parseFloat(quantity) == 0) {
                $('#reqquantity').val("");
            }
            $('#newquantity-error').html("");
        }
        //end quantity check

        //Start remove item dynamically
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });
        //End remove item dynamically

        //Start reorder number
        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                $('#numberofItems').val(index - 1);
                $('#numberofItemsLbl').text(index - 1);
                ind = index - 1;
            });
            if (ind == 0) {
                $('.totalrownumber').hide();
            }
            else{
                $('.totalrownumber').show();
            }
        }
        //End reorder table

        //edit modal open
        $('body').on('click', '.editTransferRecords', function() {
            $("#transferformtitle").html('Update Stock Transfer');
            $('.select2').select2();
            $('#operationtypes').val("2");
            var recIdVar = $(this).data('id');
            var statusvals = $(this).data('status');
            var srcStore = $(this).data('sst');
            var desStore = $(this).data('dst');
            var rtype = $(this).data('typ');
            var cmnt;
            var sourcestr="";
            var cmnt;
            var j=0;
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
            $.get("/transferedit" + '/' + recIdVar, function(data) {
                var statusvals = data.trdata.Status;
                if (statusvals == "Approved" || statusvals == "Rejected" || statusvals == "Issued" || statusvals == "Void") {
                    toastrMessage('error',"You cant update on this status","Error");
                    $('#laravel-datatable-crud').DataTable().ajax.reload();
                }
                else{
                    $('#soustoredis').val(srcStore);
                    $('#desstoredis').val(desStore);
                    $('#typeedit').val(rtype);
                    $('#transferId').val(recIdVar);
                    $('#trnumberi').val(data.trdata.DocumentNumber);
                    $('#reqtype').val(data.trdata.Type);
                    var typ = data.trdata.Type;
                    //$('#sstore').selectpicker('val', data.trdata.SourceStoreId);
                    //$('#dstore').selectpicker('val', data.trdata.DestinationStoreId);
                    $('#sstore').select2('destroy');
                    $('#sstore').val(data.trdata.SourceStoreId).select2();
                    $('#dstore').select2('destroy');
                    $('#dstore').val(data.trdata.DestinationStoreId).select2();
                    $('#date').val(data.trdata.Date);
                    $('#Reason').val(data.trdata.Reason);
                    $('#commentlbl').text(data.trdata.Memo);
                    $('#commenttype').val(data.trdata.Status);
                    cmnt = data.trdata.Status;
                    $('#numberofItems').val(data.count);
                    var comment = data.trdata.Memo;
                    if (cmnt == "Commented") {
                        $('#commenttype').val("Corrected");
                    }
                    $('#editReqItem').DataTable({
                        destroy: true,
                        processing: true,
                        serverSide: true,
                        paging: false,
                        searching: true,
                        info: false,
                        searchHighlight: true,
                        "order": [
                            [0, "asc"]
                        ],
                        "pagingType": "simple",
                        language: {
                            search: '',
                            searchPlaceholder: "Search here"
                        },
                        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                        ajax: {
                            url: '/showrtransferDetail/' + recIdVar,
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
                        columns: [{
                                data: 'id',
                                name: 'id',
                                'visible': false
                            },
                            {
                                data: 'ItemId',
                                name: 'ItemId',
                                'visible': false
                            },
                            {
                                data: 'HeaderId',
                                name: 'HeaderId',
                                'visible': false
                            },
                            {
                                data:'DT_RowIndex'
                            },
                            {
                                data: 'Code',
                                name: 'Code'
                            },
                            {
                                data: 'ItemName',
                                name: 'ItemName'
                            },
                            {
                                data: 'SKU',
                                name: 'SKU'
                            },
                            {
                                data: 'PartNumber',
                                name: 'PartNumber',
                                'visible': false
                            },
                            {
                                data: 'UOM',
                                name: 'UOM'
                            },
                            {
                                data: 'Quantity',
                                name: 'Quantity'
                            },
                            {
                                data: 'Memo',
                                name: 'Memo'
                            },
                            {
                                data: 'action',
                                name: 'action'
                            }
                        ],
                    });
                    // var oTable = $('#editReqItem').dataTable();
                    // oTable.fnDraw(false);
                    $("#dynamicTable").hide();
                    $("#adds").hide();
                    $("#editReqItem").show();
                    $("#addnew").show();
                    $('#destinationDiv').show();
                    $('#sourceDiv').show();
                    $('#typeDiv').hide();
                    $('#sourceEditDiv').hide();
                    $('#desEditDiv').hide();
                    $('#typeEditDiv').show();
                    if (comment == "-" || comment == "") {
                        $('.infoCommentCardDiv').hide();
                    } else {
                        $('.infoCommentCardDiv').show();
                    }
                    $('.totalrownumber').show();
                   // $('#inlineForm').modal('show');
                }
            });  
        });

        //end edit modal open

        //start get header data
        function getheaderId() {
            var hid = $('#transferId').val();
            var sstr = $('#sstore').val();
            var dstr = $('#dstore').val();
            $('#receIds').val(hid);
            $('#receivingstoreid').val(sstr);
            $('#desstId').val(dstr);
            $('#transfereditid').val("");
            $('#reqItemname').selectpicker(null).trigger('change');
            $('#savenewreq').text("Add");
        }
        //end get header data

        //Start show receiving doc info
        function DocTraInfo(recordId){   
            var comments;
            var recstore;
            var issstore;
            var appstore;
            var lidata="";
            $("#statusid").val(recordId);
            $("#recTrId").val(recordId);
            $('#detailcontent').hide();
            $('.actbtns').hide();

            $.ajax({
                url: '/showTrData'+'/'+recordId,
                type: 'GET',
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
                
                success: function(data) {
                    var dc = data;
                    var len = data.trHeader.length;
                    recstore=data.countval;
                    issstore=data.issuecnt;
                    appstore=data.approvecnt;

                    $.each(data.trHeader, function(key,value) {
                        $('#infodocnum').text(value.DocumentNumber);
                        $('#infoissuedocnum').text(value.IssueDocNumber);
                        $('#infosourcestore').text(value.SourceStore);
                        $('#infodestinationstore').text(value.DestinationStore);
                        $('#inforequestby').text(value.TransferBy);
                        $('#infopreparedby').text(value.PreparedBy);
                        $('#infodate').text(value.created_at);
                        $('#infopurpose').text(value.Reason);
                        $('#infodispatchstatus').text(value.DispatchStatus);
                        $('#commentslbl').text(value.Memo);
                        $('#infostatus').text(value.Status);
                        $('#infoapprovedby').text(value.ApprovedBy);
                        $('#infoapproveddate').text(value.ApprovedDate);
                        $('#infoissuedby').text(value.IssuedBy);
                        $('#infoissueddate').text(value.IssuedDate);
                        $('#inforejectby').text(value.RejectedBy);
                        $('#inforejectdate').text(value.RejectedDate);
                        $('#infocommentby').text(value.CommentedBy);
                        $('#infocommentdate').text(value.CommentedDate);
                        $('#infovoidby').text(value.VoidBy);
                        $('#infovoiddate').text(value.VoidDate);
                        $('#infodeliveredby').text(value.DeliveredBy);
                        $('#infodelivereddate').text(value.DeliveredDate);
                        $('#inforeceivedby').text(value.ReceivedBy);
                        $('#inforeceiveddate').text(value.ReceivedDate);
                        $('#infovoidreason').text(value.VoidReason);
                        $('#infoundovoidby').text(value.UndoVoidBy);
                        $('#infoundovoiddate').text(value.UndoVoidDate);
                        $('#infocomment').text(value.Memo);
                        comments = value.Memo;
                        $("#recTrStatus").val(value.Status);
                        var statusvals=value.Status;
                        var docnumber=value.DocumentNumber;

                        if(statusvals==="Draft"){
                            $("#pendingtrbtn").show();
                            $("#statustitles").html("<span style='color:#A8AAAE;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals==="Pending"){
                            $("#verifybtn").show();
                            $("#backtodraft").show();
                            $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals==="Verified" && parseFloat(appstore)>0){
                            $("#approvetrbtn").show();
                            $("#backtopending").show();
                            $("#rejecttrbtn").show();
                            $("#statustitles").html("<span style='color:#00CFE8;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Verified" && parseFloat(appstore)==0){
                            $("#backtopending").show();
                            $("#statustitles").html("<span style='color:#00CFE8;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }

                        else if(statusvals=="Issued" && parseFloat(recstore)>0){
                            $("#statustitles").html("<span style='color:#7367f0;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Issued" && parseFloat(recstore)==0){
                            $("#statustitles").html("<span style='color:#7367f0;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Issued(Received)" || statusvals=="Issued(Partially-Received)" || statusvals=="Issued(Fully-Received)"){
                            $("#statustitles").html("<span style='color:#7367f0;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Approved"){
                            if(parseFloat(appstore)>0){
                                $("#rejecttrbtn").show();
                                $("#issuetrbtn").show();
                            }
                            if(parseFloat(appstore)==0){
                                $("#approvetrbtn").hide();
                                $("#correctiontrbtn").hide();
                                $("#rejecttrbtn").hide();
                                $("#issuetrbtn").hide();
                                $("#receivetrbtn").hide();
                            }
                            if(parseFloat(issstore)>0){
                                $("#issuetrbtn").show();
                            }
                            if(parseFloat(issstore)==0){
                                $("#approvetrbtn").hide();
                                $("#correctiontrbtn").hide();
                                $("#rejecttrbtn").hide();
                                $("#issuetrbtn").hide();
                                $("#receivetrbtn").hide(); 
                            }
                            $("#backtoverifybtn").show(); 
                            $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        
                        else if(statusvals=="Commented" && parseFloat(appstore)>0){
                            $("#approvetrbtn").show();
                            $("#correctiontrbtn").show();
                            $("#rejecttrbtn").show();
                            $("#statustitles").html("<span style='color:#rgb(133 135 150);font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Commented" && parseFloat(appstore)==0){
                            $("#approvetrbtn").hide();
                            $("#correctiontrbtn").hide();
                            $("#rejecttrbtn").hide();
                            $("#issuetrbtn").hide();
                            $("#receivetrbtn").hide();
                            $("#statustitles").html("<span style='color:#rgb(133 135 150);font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Corrected"){
                            $("#approvetrbtn").show();
                            $("#correctiontrbtn").show();
                            $("#rejecttrbtn").show();
                            $("#statustitles").html("<span style='color:#5bc0de;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Rejected" && parseFloat(appstore)>0){
                            $("#approvetrbtn").show();
                            $("#correctiontrbtn").show();
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Rejected" && parseFloat(appstore)==0){
                            $("#approvetrbtn").hide();
                            $("#correctiontrbtn").hide();
                            $("#rejecttrbtn").hide();
                            $("#issuetrbtn").hide();
                            $("#receivetrbtn").hide();
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else if(statusvals=="Void"){
                            $("#approvetrbtn").hide();
                            $("#correctiontrbtn").hide();
                            $("#rejecttrbtn").hide();
                            $("#issuetrbtn").hide();
                            $("#receivetrbtn").hide();
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }
                        else{
                            $("#approvetrbtn").hide();
                            $("#correctiontrbtn").hide();
                            $("#rejecttrbtn").hide();
                            $("#issuetrbtn").hide();
                            $("#receivetrbtn").hide();
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+docnumber+"     ,     "+statusvals+"</span>");
                        }

                        if (comments == "-" || comments == "") {
                            $("#infosCommentCardDiv").hide();
                        } else {
                            $("#infosCommentCardDiv").hide();
                        }
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending" || value.action == "Back to Pending" || value.action == "Edited (Dispatch)" || value.action == "Back to Pending (Dispatch)"){
                            classes="warning";
                        }
                        else if(value.action == "Verified" ){
                            classes="info";
                        }
                        else if(value.action == "Change to Counting" || value.action == "Verified (Dispatch)"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Back to Verify" || value.action == "Back to Review" || value.action == "Undo Void" || value.action == "Created (Dispatch)" || value.action == "Undo Void (Dispatch)"){
                            classes="secondary";
                        }
                        else if(value.action == "Approved" || value.action == "Received" || value.action == "Approved (Dispatch)"){
                            classes="success";
                        }
                        else if(value.action == "Void" || value.action=="Void(Draft)" || value.action=="Void(Pending)" || value.action=="Void(Approved)" || value.action=="Void(Reviewed)" || value.action=="Rejected" || value.action=="Void (Dispatch)"){
                            classes="danger";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason:</b> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span>'+reasonbody+'</br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });
                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);

                }
            });

            $('#reqinfodetail').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [0, "asc"]
                ],
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
                    url: '/showTrDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:"10%"
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName',
                        width:"10%"
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:"10%"
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:"7%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width:"10%"
                    },
                    {
                        data: 'ApprovedQuantity',
                        name: 'ApprovedQuantity',
                        width:"10%"
                    },
                    {
                        data: 'IssuedQuantity',
                        name: 'IssuedQuantity',
                        width:"10%"
                    },
                    {
                        data: 'DispatchQuantity',
                        name: 'DispatchQuantity',
                        width:"10%"
                    },
                    {
                        data: 'Memo',
                        name: 'Memo',
                        width:"10%"
                    },
                    {
                        data: 'ApprovedMemo',
                        name: 'ApprovedMemo',
                        width:"10%"
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Loop through each cell in the row
                    $('td', row).each(function() {
                        // If the cell's text is "0", set it to an empty string
                        if ($(this).text() == "0.00" || $(this).text() == "0" || $(this).text() == "NULL") {
                            $(this).text('');
                        }
                    });
                },
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
                    $('#detailcontent').show(); 
                },
            });
            $.fn.dataTable.ext.errMode = 'throw';
            // var rTable = $('#reqinfodetail').dataTable();
            // rTable.fnDraw(false);
            // var oTable = $('#laravel-datatable-crud').dataTable();
            // oTable.fnDraw(false);
            $(".infoscl").collapse('show');
            $("#reqInfoModal").modal('show');
        }
        //End show receiving doc info

        //edit modal open

        function edittransferdata(recIdVar) {
            $("#transferformtitle").html('Edit Stock Transfer');
            $('.select2').select2();
            $('#operationtypes').val("2");
            //var recIdVar = $(this).data('id');
            
            var cmnt;
            var sourcestr="";
            var j=0;
            
            $.ajax({
                url: '/transferstatus'+'/'+recIdVar,
                type: 'GET',
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
                success: function(data) {
                    var statusvals = data.trstatusdata.Status;
                    var srcStore = data.srcstores;
                    var desStore = data.desstores;
                    var rtype = data.trstatusdata.Type;
                    if (statusvals == "Approved" || statusvals == "Rejected" || statusvals == "Issued" || statusvals == "Void") {
                        toastrMessage('error',"You cant update on this status","Error");
                        $('#laravel-datatable-crud').DataTable().ajax.reload();
                    } 
                    else {
                        $('#soustoredis').val(srcStore);
                        $('#desstoredis').val(desStore);
                        $('#typeedit').val(rtype);
                        $('#transferId').val(recIdVar);
                        $('#inlineForm').modal('show');
                        $.get("/transferedit" + '/' + recIdVar, function(data) {
                            
                            $('#reqnumberi').val(data.trdata.DocumentNumber);
                            $('#reqtype').val(data.trdata.Type);
                            var typ = data.trdata.Type;
                            sourcestr=data.trdata.SourceStoreId;
                            $('#hiddenstoreval').val(data.trdata.SourceStoreId);
                            $('#sstore').select2('destroy');
                            $('#sstore').val(data.trdata.SourceStoreId).select2();
                            $('#dstore').select2('destroy');
                            $('#dstore').val(data.trdata.DestinationStoreId).select2();
                            $('#RequestedBy').select2('destroy');
                            $('#RequestedBy').val(data.trdata.TransferBy).select2();
                            $('#date').val(data.trdata.Date);
                            $('#Reason').val(data.trdata.Reason);
                            $('#commentlbl').text(data.trdata.Memo);
                            $('#commenttype').val(data.trdata.Status);
                            $('#qtyonhandval').val(data.qtyonhandflg);
                            $('#checkqtyonhandval').val(data.checkqtyonhand);
                            cmnt = data.trdata.Status;
                            $('#numberofItems').val(data.count);
                            var comment = data.trdata.Memo;
                            if (cmnt == "Commented") {
                                $('#commenttype').val("Corrected");
                            }

                            var allselecteditems=[];
                            $.each(data.reqdetail, function(key, value) {
                                ++i;
                                ++m;
                                ++j;
                                var vis="";
                                $("#dynamicTable > tbody").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                                    '<td style="width:27%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row['+m+'][ItemId]"></select></td>'+
                                    '<td style="width:12%;display:none;"><input type="text" name="row['+m+'][Code]" placeholder="Code" id="Code'+m+'" class="Code form-control" readonly="true" value="'+value.ItemCode+'"/></td>'+
                                    '<td style="width:11%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true" value="'+value.UomName+'"/></td>'+
                                    '<td style="width:15%;"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" placeholder="Quantity on Hand" class="AvQuantity form-control" readonly="true"/></td>'+
                                    '<td style="width:15%;"><input type="number" name="row['+m+'][Quantity]" onkeyup="checkQ(this)" placeholder="Quantity" id="quantity'+m+'" class="quantity form-control numeral-mask" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;" value="'+value.Quantity+'"/></td>'+
                                    '<td style="width:26%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control" value="'+value.ReqMemo+'" placeholder="Write remark here..."/></td>'+
                                    '<td style="width:3%;text-align:center;"><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;" value="'+value.Common+'"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;" value="'+value.ItemType+'"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;" value="'+value.StoreId+'"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DestStoreId]" id="desstoreid'+m+'" class="desstoreid form-control" readonly="true" style="font-weight:bold;" value="'+value.DestStoreId+'"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Transfer" style="font-weight:bold;"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][DestStoreQuantity]" id="DestStoreQuantity'+m+'" class="DestStoreQuantity form-control" readonly="true" style="font-weight:bold;"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" class="UnitCost form-control" readonly="true" style="font-weight:bold;" value="'+value.UnitCost+'"/></td>'+
                                    '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idval'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                                '</tr>');
                                var selectedoptions='<option selected value="'+value.ItemId+'">'+value.ItemCode+'  ,   '+value.ItemName+'  ,   '+value.SKUNumber+'</option>';
                                var options = $("#allitems > option").clone();
                                $('#itemNameSl'+m).append(options); 
                                $("#itemNameSl"+m+" option[value="+value.ItemId+"]").remove();
                                //$("#itemNameSl"+m+" option[title!='"+sourcestr+"']").remove();
                                //$("#itemNameSl"+m+" option[label=0]").remove();
                                $('#itemNameSl'+m).append(selectedoptions); 
                                $("#itemNameSl"+m).select2();
                                $('#numberofItemsLbl').text(j);
                                allselecteditems.push(value.ItemId);
                                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            });

                            var q=0;
                            var r=0;
                            var sorteditems=allselecteditems.sort();
                            $.each(data.bal, function(key, value) {
                                ++q;
                                var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(1).find('select').val();
                                if(itemids==value.ItemId){
                                    var reqbalance=value.ReqBalance;
                                    var trnbalance=value.TrnBalance;
                                    var salesbl=value.SalesBalance;
                                    var balances=value.Balance;
                                    var qtyonhand=0;
                                    var consolidatebal=parseFloat(value.Balance)-parseFloat(value.TrnBalance)-parseFloat(value.ReqBalance);
                                    var qntval=$('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val();
                                    if(parseFloat(consolidatebal)<=0){
                                        qtyonhand=0;
                                    }
                                    else if(parseFloat(consolidatebal)>0){
                                        qtyonhand=consolidatebal;
                                    }

                                    if(parseInt(data.qtyonhandflg)==0){
                                        $('#dynamicTable tr:eq('+q+')').find('td').eq(4).find('input').val(parseFloat(qtyonhand)+parseFloat(qntval));
                                    }
                                }
                                ++r;
                            });

                            $('#editReqItem').DataTable({
                                destroy: true,
                                processing: true,
                                serverSide: true,
                                paging: false,
                                searching: true,
                                info: false,
                                searchHighlight: true,
                                "order": [
                                    [0, "asc"]
                                ],
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
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    url: '/showrtransferDetail/' + recIdVar,
                                    type: 'DELETE',
                                    dataType: "json",
                                    
                                },
                                columns: [ 
                                    {
                                        data: 'id',
                                        name: 'id',
                                        'visible': false
                                    },
                                
                                    {
                                        data: 'ItemId',
                                        name: 'ItemId',
                                        'visible': false
                                    },
                                    {
                                        data: 'HeaderId',
                                        name: 'HeaderId',
                                        'visible': false
                                    },
                                    {
                                        data:'DT_RowIndex'
                                    },
                                    {
                                        data: 'Code',
                                        name: 'Code'
                                    },
                                    {
                                        data: 'ItemName',
                                        name: 'ItemName'
                                    },
                                    {
                                        data: 'SKU',
                                        name: 'SKU'
                                    },
                                    {
                                        data: 'UOM',
                                        name: 'UOM'
                                    },
                                    {
                                        data: 'Quantity',
                                        name: 'Quantity'
                                    },
                                    {
                                        data: 'Memo',
                                        name: 'Memo'
                                    },
                                    {
                                        data: 'action',
                                        name: 'action'
                                    }
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
                            // var oTable = $('#editReqItem').dataTable();
                            // oTable.fnDraw(false);
                            $("#dynamicTable").show();
                            $("#adds").show();
                            $("#editReqItem").hide();
                            $("#addnew").hide();
                            $('#destinationDiv').show();
                            $('#sourceDiv').show();
                            $('#typeDiv').hide();
                            $('#sourceEditDiv').hide();
                            $('#desEditDiv').hide();
                            $('#typeEditDiv').show();
                            if (comment == "-" || comment == "") {
                                $('.infoCommentCardDiv').hide();
                            } else {
                                $('.infoCommentCardDiv').show();
                            }
                            //var oTable = $('#laravel-datatable-crud').dataTable();
                            //oTable.fnDraw(false);
                            $('.totalrownumber').show();
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        });
                    }
                }
            });
        }
        //end edit modal open

        //Start Print Attachment 
        $('body').on('click', '.printTraAttachment', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'Transfer', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        //Start Print Attachment
        $('body').on('click', '.printTrIssueAttachment', function () 
        {
            var id = $(this).data('id');
            var link=$(this).data('link');
            window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        //end info modal
        function appendTable() {
            $("#dynamicTable > tbody").empty();
            //$("#dynamicTable").append('<tr><th style="width:3%;">#</th><th style="width:27%;">Item Name</th><th style="display:none;">Item Code</th><th style="width:11%;>UOM</th><th style="width:15%;">Qty. On Hand</th><th style="width:15%;">Quantity</th><th style="width:26%;">Remark</th><th style="width:3%;"></th></tr>');
        }

        function closeReqAddModal() {
            $("#newreqform")[0].reset();
            $('#newquantity-error').html("");
            $('#newitemname-error').html("");
        }

        function reqTypeVal() {
            $('#type-error').html("");
        }

        function sourcestoreVal() {
            $('#sourcestore-error').html("");
        }

        function destinationstoreVal() {
            $('#destinationstore-error').html("");
        }

        function requestedByVal() {
            $('#requestedby-error').html("");
        }

        function dateVal() {
            $('#date-error').html("");
        }

        function ReasonVal() {
            $('#reason-error').html("");
        }

        $('body').on('click', '.refreshTrTable', function() {
            //var oTable = $('#laravel-datatable-crud').dataTable(); 
            //oTable.fnDraw(false);
            $('#laravel-datatable-crud').DataTable().ajax.reload();
        });
        
        $(function () {
            cardSection = $('#page-block');
        });

        $('#fiscalyear').on('change', function() {
            var fy="0";
            var fyear = $('#fiscalyear').val();
            getTransferData(fyear);
        });

        function getTrApproveInfo(){
            var rid=$('#recTrId').val();
            var appqnt=0;
            $('#recAppId').val(rid);
            $('#apprdiv').hide();
            $("#apprDynamicTable > tbody").empty();
            j2=0;
            $.ajax({
                url: '/showTrData'+'/'+rid,
                type: 'GET',
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
                    $('#apprdiv').hide();
                },
                
                success: function(data) {
                    $.each(data.trHeader, function(key,value) {
                        $('#apprdocnum').text(value.DocumentNumber);
                        $('#apprissuedocnum').text(value.IssueDocNumber);
                        $('#apprsourcestore').text(value.SourceStore);
                        $('#apprdestinationstore').text(value.DestinationStore);
                        $('#apprpurpose').text(value.Memo);

                        $('#appqtyonhandval').val(value.QtyOnHandFlag);
                        $('#appcheckqty').val(value.CheckQtyOnHand);

                        if(value.Status=="Pending"){
                            $("#appstatusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.Status+"</span>");
                        }
                        else if(value.Status=="Verified"){
                            $("#appstatusdisplay").html("<span style='color:#00CFE8;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.Status+"</span>");
                        }
                        else if(value.Status=="Issued" || value.Status=="Issued(Received)"){
                            $("#appstatusdisplay").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.Status+"</span>");
                        }
                        else if(value.Status=="Approved"){
                            $("#appstatusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.Status+"</span>");
                        }
                        else{
                            $("#appstatusdisplay").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+value.DocumentNumber+"     ,     "+value.Status+"</span>");
                        }
                    }); 

                    $.each(data.trDetail, function(key, value) {
                        ++i2;
                        ++m2;
                        ++j2;

                        appqnt = value.ApprovedQuantity <= 0 ? '' : value.ApprovedQuantity;

                        $("#apprDynamicTable > tbody").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j2+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="rowapp['+m2+'][appidval]" id="appidval'+m2+'" class="appidval form-control" readonly="true" style="font-weight:bold;" value="'+m2+'"/></td>'+
                            '<td style="width:8%;"><input type="text" name="rowapp['+m2+'][ItemCode]" placeholder="Item Code" id="appcode'+m2+'" class="appcode form-control" readonly="true" value="'+value.ItemCode+'"/></td>'+
                            '<td style="width:16%;"><input type="text" name="rowapp['+m2+'][ItemName]" placeholder="Item Name" id="appitem'+m2+'" class="appitem form-control" readonly="true" title="'+value.ItemName+'" value="'+value.ItemName+'"/></td>'+
                            '<td style="width:8%;"><input type="text" name="rowapp['+m2+'][SKUNum]" placeholder="SKU Number" id="appsku'+m2+'" class="appsku form-control" readonly="true" value="'+value.SKUNumber+'"/></td>'+
                            '<td style="width:7%;"><input type="text" name="rowapp['+m2+'][UOM]" placeholder="UOM" id="appuom'+m2+'" class="appuom form-control" readonly="true" value="'+value.UomName+'"/></td>'+
                            '<td style="width:10%;"><input type="text" name="rowapp['+m2+'][QuantityOnHand]" placeholder="Quantity on Hand" id="appqtyonhand'+m2+'" class="appqtyonhand form-control" readonly="true"/></td>'+
                            '<td style="width:10%;"><input type="text" name="rowapp['+m2+'][ReqQnt]" placeholder="Requested Quantity" id="appreq'+m2+'" class="appreq form-control" readonly="true" value="'+value.Quantity+'"/></td>'+
                            '<td style="width:10%;"><input type="number" name="rowapp['+m2+'][AppQuantity]" placeholder="Approve Quantity" id="appqnt'+m2+'" class="appqnt form-control" onkeypress="return ValidateNum(event);" onkeyup="checkAppQnt(this)" step="any" value="'+appqnt+'"/></td>'+
                            '<td style="width:14%;"><input type="text" name="rowapp['+m2+'][ReqRemark]" placeholder="Request Remark" id="appreqremark'+m2+'" class="appreqremark form-control" readonly="true" title="'+value.ReqMemo+'" value="'+value.ReqMemo+'"/></td>'+
                            '<td style="width:14%;"><input type="text" name="rowapp['+m2+'][AppRemark]" placeholder="Approve Remark" id="appappremark'+m2+'" class="appappremark form-control" value="'+value.ApprovedMemo+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="rowapp['+m2+'][storeid]" id="storeid'+m2+'" class="storeid form-control" readonly="true" style="font-weight:bold;" value="'+value.StoreId+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="rowapp['+m2+'][recordid]" id="recordid'+m2+'" class="recordid form-control" readonly="true" style="font-weight:bold;" value="'+value.RecordId+'"/></td>'+
                        '</tr>');

                        CalculateTrnAmount(value.HeaderId,value.ItemId,value.StoreId,m2);
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
                    $('#apprdiv').show();  
                },
            });
            
            $(".infotrn").collapse('show');
            $('#approvemodal').modal('show');
            $('#conapprovetrbtn').text("Approve");
            $('#conapprovetrbtn').prop("disabled", false );
        }

        function getTrPendingInfo(){
            var rid=$('#recTrId').val();
            $('#pendingtrId').val(rid);
            $('#pendingmodal').modal('show');
            $('#conpendingtrbtn').text("Change to Pending");
            $('#conpendingtrbtn').prop("disabled",false);
        }

        //Start Change to Pending here
        $("#conpendingtrbtn").click(function() {
            var registerForm = $("#pendingform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/pendingTransfer',
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
                    $('#conpendingtrbtn').text('Changing...');
                    $('#conpendingtrbtn').prop( "disabled", true );
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
                    if (data.dberrors) {
                        $('#conpendingtrbtn').text('Change to Pending');
                        $('#conpendingtrbtn').prop("disabled",false);
                        $('#pendingmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#conpendingtrbtn').text('Change to Pending');
                        $('#conpendingtrbtn').prop("disabled",false);
                        $('#pendingmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Draft","Error");
                    }
                    else if(data.success){
                        $('#conpendingtrbtn').text('Change to Pending');
                        toastrMessage('success',"Successful","Success");
                        $("#pendingmodal").modal('hide')
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //End Change to Pending here

        function verifyFn(){
            var rid=$('#recTrId').val();
            $('#verifyId').val(rid);
            $('#verifyreqmodal').modal('show');
            $('#converifybtn').text("Verify");
            $('#converifybtn').prop( "disabled", false );
        }

        //Start Verify here
        $("#converifybtn").click(function() {
            var registerForm = $("#verifyform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/verifyTransfer',
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
                    $('#converifybtn').text('Verifying...');
                    $('#converifybtn').prop( "disabled", true );
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
                    if (data.dberrors) {
                        $('#converifybtn').text('Verify');
                        $('#converifybtn').prop("disabled",false);
                        $('#verifyreqmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#converifybtn').text('Verify');
                        $('#converifybtn').prop("disabled",false);
                        $('#verifyreqmodal').modal('hide');
                        toastrMessage('error',"Transfer status should be on Pending","Error");
                    }
                    else if(data.success){
                        $('#converifybtn').text('Verify');
                        toastrMessage('success',"Successful","Success");
                        $("#verifyreqmodal").modal('hide')
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //End Verify here

        function backToPendingFn(){
            var stid = $('#recTrId').val();
            $('#backtopendingid').val(stid);
            $('#BackToPendingComment').val("");
            $('#backtopending-error').html("");
            $('#backtopendingmodal').modal('show');
            $('#backtopendingbtn').text("Back to Pending");
            $('#backtopendingbtn').prop("disabled", false);
        }

        $("#backtopendingbtn").click(function() {
            var registerForm = $("#backtopendingform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/trnBackToPending',
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

                    $('#backtopendingbtn').text('Changing...');
                    $('#backtopendingbtn').prop("disabled", true);
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
                    if (data.errors) {
                        if (data.errors.BackToPendingComment) {
                            $('#backtopending-error').html(data.errors.BackToPendingComment[0]);
                        }
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        toastrMessage('error',"Check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        $('#backtopendingmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        $('#backtopendingmodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Verified","Error");
                    }
                    else if(data.success){
                        $('#backtopendingmodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function backToPenValFn() {
            $('#backtopending-error').html("");
        }

        function backToVerifyFn(){
            var stid = $('#recTrId').val();
            $('#backtoverifyid').val(stid);
            $('#BackToVerifyComment').val("");
            $('#backtoverify-error').html("");
            $('#backtoverifybutton').text("Back to Verify");
            $('#backtoverifybutton').prop("disabled", false);
            $('#backtoverifymodal').modal('show');
        }

        $("#backtoverifybutton").click(function() {
            var registerForm = $("#backtoverifyform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/backToVerifyTrn',
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

                    $('#backtoverifybutton').text('Changing...');
                    $('#backtoverifybutton').prop("disabled", true);
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
                    if (data.errors) {
                        if (data.errors.BackToVerifyComment) {
                            $('#backtoverify-error').html(data.errors.BackToVerifyComment[0]);
                        }
                        $('#backtoverifybutton').text('Back to Verify');
                        $('#backtoverifybutton').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtoverifybutton').text('Back to Verify');
                        $('#backtoverifybutton').prop("disabled",false);
                        $('#backtoverifymodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtoverifybutton').text('Back to Verify');
                        $('#backtoverifybutton').prop("disabled",false);
                        $('#backtoverifymodal').modal('hide');
                        toastrMessage('error',"Requisition status should be on Review","Error");
                    }
                    else if(data.success){
                        $('#backtoverifymodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function backToVerifyValFn() {
            $('#backtoverify-error').html("");
        }

        function backToDraftFn() {
            var stid = $('#recTrId').val();
            $('#draftid').val(stid);
            $('#BackToDraftComment').val("");
            $('#backtodraft-error').html("");
            $('#backtodraftmodal').modal('show');
            $('#backtodraftbtn').text("Back to Draft");
            $('#backtodraftbtn').prop("disabled", false);
        }

        $("#backtodraftbtn").click(function() {
            var registerForm = $("#backtodraftform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/backToDraftTrn',
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
                    $('#backtodraftbtn').text('Changing...');
                    $('#backtodraftbtn').prop("disabled", true);
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
                    if (data.errors) {
                        if (data.errors.BackToDraftComment) {
                            $('#backtodraft-error').html(data.errors.BackToDraftComment[0]);
                        }
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        $('#backtodraftmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        $('#backtodraftmodal').modal('hide');
                        toastrMessage('error',"Transfer status should be on Pending","Error");
                    }
                    else if(data.success){
                        $('#backtodraftmodal').modal('hide');
                        $('#reqInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function commentValFn() {
            $('#backtodraft-error').html("");
        }

        function getTrReceiveInfo()
        {
            var rid=$('#recTrId').val();
            $('#receivetrId').val(rid);
            $('#receivetrconmodal').modal('show');
            $('#conreceivetrbtn').text("Receive");
            $('#conreceivetrbtn').prop("disabled",false);
        }

        function getTrCommentInfo()
        {
            var status=$('#recTrStatus').val();
            var rid=$('#recTrId').val();
            $('#commenttrid').val(rid);
            $('#commenttrstatus').val(status);
            $('#commentTrModal').modal('show');
            $("#CommentTr").focus();
            $('#contrcommentbtn').prop( "disabled", false );
        }

        function getTrRejectInfo()
        {
            var status=$('#recTrStatus').val();
            var rid=$('#recTrId').val();
            $('#rejtrId').val(rid);
            $('#rejtrstatus').val(status);
            $('#rejecttrconmodal').modal('show');
            $('#conrejecttrbtn').prop( "disabled", false );
        }

        function closecommenttr() 
        {
            $('#commenttr-error').html("");
            $("#commenttrform")[0].reset();
        }

        function closeInfoModal() 
        {
            //var oTable = $('#laravel-datatable-crud').dataTable(); 
           // oTable.fnDraw(false);
        }

        function CalculateTrnAmount(hid,iid,sid,indx){
            var itemid=0;
            var storeid=0;
            var headerid=0;
            let totalresult;
            var qtyonhandflg = $('#appqtyonhandval').val(); 
            var checkqtyonhand = $('#appcheckqty').val(); 
            qtyonhandflg = qtyonhandflg == '' ? 0 : qtyonhandflg;
            checkqtyonhand = checkqtyonhand == '' ? 0 : checkqtyonhand;
            $.ajax({
                url: '/calcTrnBalance',
                type: 'POST',
                dataType: "json",
                data:{
                    itemid:iid,
                    storeid:sid,
                    headerid:hid,
                },
                success: function(data) {
                    if(parseInt(qtyonhandflg)==0){
                        $('#appqtyonhand'+indx).val(data.qntonhand);
                    }
                },
                error: function(error) {
                    console.log("Error:", error);
                }
            });
        }

        //Start approve here
        $('body').on('click', '#conapprovetrbtn', function()
        {
            var registerForm = $("#approvetrform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/approveTr',
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
                    $('#conapprovetrbtn').text('Approving...');
                    $('#conapprovetrbtn').prop( "disabled", true );
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
                    if(data.differencefy){
                        toastrMessage('error',"Source and Destination Store/Shop should be in the same Fiscal Year","Error");
                        $("#approvetrconmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                    }
                    if(data.success) 
                    {
                        $('#conapprovetrbtn').text('Approve');
                        toastrMessage('success',"Successful","Success");
                        $("#approvetrbtn").hide();
                        $("#correctiontrbtn").hide();
                        $("#rejecttrbtn").show();
                        $("#issuetrbtn").show();
                        $("#receivetrbtn").hide();
                        var today = new Date();
                        var currentdate=$("#curdateinfo").val();
                        var un=$("#usernamelbl").val();
                        $("#infoapprovedby").html(un);
                        $("#infoapproveddate").html(currentdate);
                        $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>Approved</span>");
                        $("#approvetrconmodal").modal('hide');
                        //$("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#approvetrform")[0].reset();
                    }
                },
            });
        });
        //End Approve

        //Start approve here
        $('body').on('click', '#conreceivetrbtn', function()
        {
            var registerForm = $("#receivetrform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/receiveTr',
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
                    $('#conreceivetrbtn').text('Receiving...');
                    $('#conreceivetrbtn').prop( "disabled", true );
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
                        $('#conreceivetrbtn').text('Receive');
                        toastrMessage('success',"Successful","Success");
                        $("#receivetrconmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#receivetrform")[0].reset();
                    }
                },
            });
        });
        //End Approve

        //Start Comment
        $('body').on('click', '#contrcommentbtn', function()
        {
            var statusVal = $("#commenttrstatus").val();
            if(statusVal=="Approved"||statusVal=="Issued")
            {
                toastrMessage('error',"You cant Comment on this status","Error");
            }
            else
            {
                var registerForm = $("#commenttrform");
                var formData = registerForm.serialize();
                $.ajax({
                url:'/commentTr',
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
                        $('#contrcommentbtn').text('Commenting...');
                        $('#contrcommentbtn').prop( "disabled", true );
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
                    success:function(data) {
                        if(data.errors) 
                        {
                            if(data.errors.Comment){
                                $('#commenttr-error' ).html( data.errors.Comment[0] );
                            }
                            $('#contrcommentbtn').text('Comment');
                            $('#contrcommentbtn').prop( "disabled", false );
                            toastrMessage('error',"Check your inputs","Error"); 
                        }
                        if(data.success) {
                            $('#contrcommentbtn').text('Comment');
                            $('#contrcommentbtn').prop( "disabled", false );
                            toastrMessage('success',"Successful","Success");
                            $("#commentTrModal").modal('hide');
                            $("#reqInfoModal").modal('hide');
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            $("#commenttrform")[0].reset();
                        }
                    },
                });
            }
        });
        //End Comment

        //Start Rejection
        $('body').on('click', '#conrejecttrbtn', function()
        {
            var statusVal = $("#rejtrstatus").val();
            if(statusVal=="Issued"||statusVal=="Rejected")
            {
                toastrMessage('error',"You cant Reject on this status","Error");
            }
            else
            {
                var registerForm = $("#rejecttrform");
                var formData = registerForm.serialize();
                $.ajax({
                url:'/rejTr',
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
                        $('#conrejecttrbtn').text('Rejecting...');
                        $('#conrejecttrbtn').prop( "disabled",true);
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
                    success:function(data) {
                        if(data.success) {
                            $('#conrejecttrbtn').text('Reject');
                            $('#conrejecttrbtn').prop("disabled",false);
                            toastrMessage('success',"Successful","Success");
                            $("#rejecttrconmodal").modal('hide');
                            $("#reqInfoModal").modal('hide');
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            $("#rejecttrform")[0].reset();
                        }
                    },
                });
            }
        });
        //End Rejection

        function getTrIssueInfo()
        {
            var option ="";
            var opt="";
            var rid=$('#recTrId').val();
            $('#issuetrId').val(rid);
            var issuetrstatus=$('#infotrstatus').val();
            var strname=$('#infosourcestore').html();
            $('#issuedbyuser-error').html("");
            $('#deliveredbyuser-error').html("");
            $('#issuetrStatusi').val(issuetrstatus);
            $('#issuetrconmodal').modal('show');
            $('#conissuetrbtn').text("Issue");
            $('#conissuetrbtn').prop( "disabled", false );
            $('#IssuedByUser').empty();
            $('#DelivereddByUser').val(null).trigger('change');
            $.get("/showTrIssueUser"+'/'+strname, function (data) 
            {
                opt = "<option selected disabled value=''></option>";
                $.each(data.iuser, function(key, value) {
                    option += "<option value='"+value.UserName+"'>"+value.UserName+"</option>";
                });
                $("#IssuedByUser").append(option);
                $("#IssuedByUser").append(opt);
                $('#IssuedByUser').select2();
            });
        }

        //Start issue here
        $("#conissuetrbtn").click(function() {
            $('#conissuetrbtn').prop( "disabled", true );   
            var recordId=$("#issuetrId").val();
            $.get("/showTrIssData" +'/' + recordId , function (data) 
            {     
                var dc=data;
                var len=data.trHeader.length;
                for(var i=0;i<=len;i++) 
                {  
                    var stval=data.trHeader[i].Status;
                    if(stval==="Issued")
                    {
                        $("#trInfoModal").modal('hide');
                        $("#issuetrconmodal").modal('hide');
                        var rTable = $('#laravel-datatable-crud-tr').dataTable(); 
                        rTable.fnDraw(false);
                        toastrMessage('error',"Transfer is already Issued","Error");
                    }
                    else
                    {
                        var registerForm = $("#issuetrform");
                        var formData = registerForm.serialize();
                        $.ajax({
                        url:'/issTr',
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
                                $('#conissuetrbtn').text('Issuing...');
                                $('#conissuetrbtn').prop( "disabled", true );
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
                            success:function(data) {
                                if(data.valerror){
                                    var singleVal='';
                                    var loopedVal='';
                                    var len=data['valerror'].length;
                                    for(var i=0;i<=len;i++) 
                                    {  
                                        var count=data.countedval;
                                        var inc=i+1;
                                        singleVal=(data['countItems'][i].Name);
                                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                        $('#conissuetrbtn').text('Issue');
                                        $('#conissuetrbtn').prop( "disabled", false );
                                        toastrMessage('error',"There is no available quantity for "+count+" Items"+loopedVal,"Error");
                                        $("#issuetrconmodal").modal('hide');
                                        $("#issuetrform")[0].reset();
                                        var oTable = $('#laravel-datatable-crud').dataTable();
                                        oTable.fnDraw(false);
                                    }    
                                }
                                else if(data.sererror){
                                    var singleVal='';
                                    var loopedVal='';
                                    var len=data['sererror'].length;
                                    for(var i=0;i<=len;i++) 
                                    {  
                                        var count=data.countedserval;
                                        var inc=i+1;
                                        singleVal=(data['countSerItems'][i].ItemName);
                                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                        $('#conissuetrbtn').text('Issue');
                                        $('#conissuetrbtn').prop( "disabled", false );
                                        toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+"  Items"+loopedVal,"Error");
                                        $("#issuetrconmodal").modal('hide');
                                        $("#issuetrform")[0].reset();
                                    }    
                                }
                                else if(data.serisserror){
                                    var singleVal='';
                                    var loopedVal='';
                                    var len=data['serisserror'].length;
                                    for(var i=0;i<=len;i++) 
                                    {  
                                        var count=data.countedisserval;
                                        var inc=i+1;
                                        singleVal=(data['countisSerItems'][i].AllValues);
                                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                        $('#conissuetrbtn').text('Issue');
                                        $('#conissuetrbtn').prop( "disabled", false );
                                        toastrMessage('error',"Please select another serial number or batch number, the following "+count+" serial number or batch number are being issued </br>"+loopedVal,"Error");
                                        //$("#issuetrconmodal").modal('hide');
                                        $("#issuetrform")[0].reset();
                                    }    
                                }
                                else if(data.differencefy){
                                    $('#conissuetrbtn').text('Issue');
                                    $('#conissuetrbtn').prop( "disabled", false );
                                    toastrMessage('error',"Source and Destination Store/Shop should be in the same Fiscal Year","Error");
                                }
                                else if(data.appdiscrepancy){
                                    $('#conissuetrbtn').text('Issue');
                                    $('#conissuetrbtn').prop( "disabled", false );
                                    toastrMessage('error',"There is no approved item in this transfer request","Error");
                                }
                                else if(data.success){
                                    $('#conissuetrbtn').text('Issue');
                                    $('#conissuetrbtn').prop("disabled",false);
                                    toastrMessage('success',"Successful","Success");
                                    $("#issuetrconmodal").modal('hide');
                                    $("#reqInfoModal").modal('hide');
                                    $.fn.dataTable.ext.errMode = 'throw';
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#issuetrform")[0].reset();
                                    $('#IssuedByUser').val(null).trigger('change');
                                    var trid= data.header;
                                    var link="/tr/"+trid;
                                    window.open(link, 'Transfer & Issue', 'width=1200,height=800,scrollbars=yes');
                                }
                            },
                        });
                    }
                }    
            });
        });
        //End issue

        function issuedByVal()
        {
            $('#issuedbyuser-error').html("");
        }

        function deliveredByVal()
        {
            $('#deliveredbyuser-error').html("");
        }

        function voidReason()
        {
            $('#void-error').html("");
        }

        //Start undo void Modal With Value 
        // $('#undovoidmodal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var id = button.data('id');
        //     var status = button.data('status');
        //     var ostatus = button.data('ostatus');
        //     var modal = $(this);
        //     modal.find('.modal-body #undovoidid').val(id);
        //     modal.find('.modal-body #ustatus').val(status);
        //     modal.find('.modal-body #oldstatus').val(ostatus);
        //     $('#undovoidbtn').prop("disabled", false);
        // });
        //End undo void Modal With Value 

        $('body').on('click', '.undovoidlnbtn', function() {
            var recordId = $(this).data('id');
            $.get("/showTrData" + '/' + recordId, function(data) {
                var dc = data;
                var fiscalyearcurr=data.fyear;
                var fyearstrs=data.fyearstr;
                var desfyearstrs=data.desfyearstr;
                var len = data.trHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.trHeader[i].Status;
                    var fyearrec = data.trHeader[i].fiscalyear;
                    var statusold = data.trHeader[i].OldStatus;
                    if(parseFloat(fyearrec)!=parseFloat(fyearstrs) || parseFloat(fyearrec)!=parseFloat(desfyearstrs)){
                        toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                        $("#undovoidmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                    else if (st==="Void"||st==="Void(Pending)"||st==="Void(Approved)"||st==="Void(Issued)") {
                        $('#undovoidid').val(recordId);
                        $('#ustatus').val(st);
                        $('#oldstatus').val(statusold);
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    }
                    else{
                        toastrMessage('error',"Transfer should be void","Error");
                        $("#undovoidmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });

        //Start undo void
        $('body').on('click', '#undovoidbtn', function() {
            $('#undovoidbtn').prop("disabled", true);
            var statusVal = $("#ustatus").val();
            var oldstatusVal = $("#oldstatus").val();
            var recordId = $('#undovoidid').val();
            $.get("/showTrData" + '/' + recordId, function(data) {
                var dc = data;
                 var fiscalyearcurr=data.fyear;
                var len = data.trHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.trHeader[i].Status;
                    var stold = data.trHeader[i].StatusOld;
                    var fyearrec = data.trHeader[i].fiscalyear;
                    
                    if (st == "Void(Pending)" || st == "Void(Issued)" || st == "Void(Approved)") {
                        var registerForm = $("#undovoidform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/undotransfer',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#undovoidbtn').text('Changing...');
                                $('#undovoidbtn').prop("disabled", true);
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
                                        $('#undovoidbtn').text('Undo Void');
                                        toastrMessage('error',"You cant void <b>" + count +"</b> item(s) because item(s) have transaction" + loopedVal,"Error");
                                        $("#undovoidmodal").modal('hide');
                                        var oTable = $('#laravel-datatable-crud').dataTable();
                                        oTable.fnDraw(false);
                                        $("#undovoidform")[0].reset();
                                    }    
                                }
                                if (data.success) 
                                {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('success',"Undo void successful","Success");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    } else {
                        toastrMessage('error',"Transfer should be void","Error");
                        $("#undovoidmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#undovoidform")[0].reset();
                    }
                }
            });
        });
        //End undo void

    </script>
@endsection
