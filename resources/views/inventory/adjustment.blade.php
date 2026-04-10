@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Adjustment-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div style="width:22%;">
                                <h3 class="card-title">Stock Adjustments</h3>
                                <label style="font-size: 10px;"></label>
                                <div class="form-group">
                                    <label style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                    <div>
                                        <select class="select2 form-control" data-style="btn btn-outline-secondary waves-effect" name="fiscalyear[]" id="fiscalyear" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                                        @foreach ($fiscalyearslist as $fiscalyearslist)
                                            <option value="{{ $fiscalyearslist->FiscalYear }}">{{ $fiscalyearslist->Monthrange }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;"> 
                            @can('Adjustment-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addadjbutton" data-toggle="modal">Add</button>
                            @endcan
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>#</th>
                                            <th>Document No.</th>
                                            <th>Adjustment Type</th>
                                            <th>Reason</th>
                                            <th>Store/Shop</th>
                                            <th>Prepared By</th>
                                            <th>Fiscal Year</th>
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
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="adjustmentmodaltitle">Adjustment Form</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
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
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="fiscalyrdiv" style="display:none;">
                                                <label style="font-size: 14px;">Fiscal Year</label>
                                                <div>
                                                    <select class="select2 form-control syncitems" name="FiscalYears" id="FiscalYears" onchange="fiscalYearVal()">
                                                        @foreach ($fiscalyears as $fiscalyears)
                                                            <option value="{{$fiscalyears->FiscalYear}}">{{$fiscalyears->Monthrange}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="fiscalyr-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="fiscalyrdivedit" style="display:none;">
                                                <label style="font-size: 14px;">Fiscal Year</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="editfiscalyrtxt" name="editfiscalyrtxt" class="form-control" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12" id="typeDiv">
                                                <label style="font-size: 14px;">Adjustment Type</label>
                                                <div>
                                                    <select class="select2 form-control" name="Type" id="adjtype" onchange="adjTypeVal()">
                                                        <option selected disabled value=""></option>
                                                        <option value="Quantity" data-icon="fa fa-minus">Quantity</option>
                                                        <option value="Quantity&Cost" data-icon="fa fa-plus">Quantity&Cost</option>
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="type-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="typeDivEdit">
                                                <label style="font-size: 14px;">Type</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" id="typeStrEdit" name="typeStrEdit" class="form-control" readonly="true"/>
                                                    </div>
                                                <span class="text-danger">
                                                    <strong id="typeEdit-error"></strong>
                                                </span>
                                            </div>
                                            
                                            <div class="col-xl-3 col-md-6 col-sm-12" id="storediv">
                                                <label style="font-size: 14px;">Store/Shop</label>
                                                <div>
                                                    <select class="select2 form-control syncitems" name="Store" id="Store" onchange="storeval()">
                                                        <option selected disabled value=""></option>
                                                        @foreach ($storeSrc as $storeSrc)
                                                            <option value="{{$storeSrc->id}}">{{$storeSrc->Name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" class="form-control" name="tid" id="tid" readonly="true"/>
                                                    <input type="hidden" class="form-control" name="adjustmentId" id="adjustmentId" readonly="true"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="store-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12" id="storeEditDiv">
                                                <label style="font-size: 14px;">Store</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="editstore" name="editstore" class="form-control" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12">
                                                <label style="font-size: 14px;">Date</label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text" id="date" name="date" class="form-control" placeholder="YYYY-MM-DD" onchange="dateVal()" readonly="true"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="date-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12">
                                                <label style="font-size: 14px;">Memo</label>
                                                <textarea type="text" placeholder="Write memo here..." class="form-control"  name="Description" id="Description"></textarea>
                                                <span class="text-danger">
                                                    <strong id="description-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                    <div class="divider-text">-</div>
                                </div>  
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="table-responsive">
                                            <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">  
                                                <tr>
                                                    <th style="width:3%;">#</th>
                                                    <th>Item Name</th>
                                                    <th style="display:none;">Item Code</th>
                                                    <th>UOM</th>
                                                    <th>Qty. On Hand</th>
                                                    <th id="stockintr">Stock In(<i class="fa fa-plus" aria-hidden="true"></i>)</th>
                                                    <th id="stockouttr">Stock Out(<i class="fa fa-minus" aria-hidden="true"></i>)</th>
                                                    <th>Value</th>
                                                    <th>Total Value</th>
                                                    <th>Reason</th>
                                                    <th>Remark</th>
                                                    <th></th>
                                                </tr>
                                            </table>
                                            <table style="width:100%">
                                                <tr>
                                                    <td colspan="2">
                                                        <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                    <td>
                                                </tr>
                                            </table>
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-12"></div>
                                                    <div class="col-xl-3 col-lg-12">
                                                        <table style="width:103%;text-align:right" id="pricingTable" class="rtable">
                                                            <tr style="display:none;" class="totalrownumber">
                                                                <td style="text-align: right;width:45%"><label style="font-size: 14px;">Sub Total</label></td>
                                                                <td style="text-align: center; width:55%">
                                                                    <label id="totalvaluelbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                                    <input type="hidden" placeholder="" class="form-control" name="totalvalues" id="totalvalues" readonly="true" value="0" />
                                                                </td>
                                                            </tr>
                                                            <tr style="display:none;" class="totalrownumber">
                                                                <td style="text-align: right;"><label style="font-size: 14px;">No. of Items</label></td>
                                                                <td style="text-align: center;"><label id="numberofItemsLbl" style="font-size: 14px; font-weight: bold;">0</label></td>
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
                            <select class="form-control" name="Reason" id="adjReason" onchange="reqReqReasonVal()">
                                <option selected disabled value=""></option>
                                <option title="1" value="Stolen-Goods">Stolen-Goods</option>
                                <option title="1" value="Damaged-Goods">Damaged-Goods</option>
                                <option title="1" value="Missing-Goods">Missing-Goods</option>
                                <option title="2" value="Found-New-Goods">Found-New-Goods</option>
                                <option title="3" value="Counting-Error">Counting-Error</option>
                            </select>
                        </div>
                        <div style="display:none;">
                            <select class="select2 form-control allitems" data-style="btn btn-outline-secondary waves-effect" name="allitems" id="allitems">
                                    <option selected disabled value=""></option>
                                    <option selected disabled value=""></option>
                                    @foreach ($storelists as $storelists)
                                        <option title="{{ $storelists->id }}" value=""></option>
                                    @endforeach
                                    @foreach ($itemSrcs as $itemSrcs)
                                    <option label="{{ $itemSrcs->Balance }}" title="{{ $itemSrcs->StoreId }}" value="{{ $itemSrcs->ItemId }}">{{ $itemSrcs->Code }}   ,   {{ $itemSrcs->ItemName }}   ,   {{ $itemSrcs->SKUNumber }}</option>
                                    @endforeach 
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="cdate" id="cdate" readonly="true" value="{{ $curdate }}"/>
                        <input type="hidden" class="form-control" name="hiddenstr" id="hiddenstr" readonly="true"/>
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <input type="hidden" id="numberofItems" class="form-control" name="numberofItems" readonly="true"/>
                        <input type="hidden" class="form-control" name="allserialNumIds" id="allserialNumIds" readonly="true"/></label>
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true"/></label>
                        <input type="hidden" placeholder="" class="form-control" name="adjustmentnumi" id="adjustmentnumi" readonly="true" value=""/>     
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger closebutton" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="adjInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Stock Adjustment Detail Information</h4>
                <button type="button" class="close" data-dismiss="modal" onclick="closeInfoModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reqInfoform">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <input type="hidden" placeholder="" class="form-control" name="itemid" id="itemid" readonly="true">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Adjustment Basic & Others Information</span>
                                                        <div id="statustitles"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Document Number</label></td>
                                                                                    <td><label id="infodocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Adjustment Type</label></td>
                                                                                    <td><label id="infotype" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr style="display: none;">
                                                                                    <td><label style="font-size: 14px;">Reason</label></td>
                                                                                    <td><label id="inforeason" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Store/Shop</label></td>
                                                                                    <td><label id="infostore" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr style="display: none;">
                                                                                    <td><label style="font-size: 14px;">Fiscal Year</label></td>
                                                                                    <td><label id="infofiscalyear" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;">Memo</label></td>
                                                                                    <td><label id="infodescription" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-8 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Others Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Prepared By</label></td>
                                                                                            <td><label id="infoadjustedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Prepared Date</label></td>
                                                                                            <td><label id="infoadjusteddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Checked By</label></td>
                                                                                            <td><label id="infocheckedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Checked Date</label></td>
                                                                                            <td><label id="infocheckeddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Confirmed By</label></td>
                                                                                            <td><label id="infoconfirmedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Confirmed Date</label></td>
                                                                                            <td><label id="infoconfirmeddate" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Change to Pending By</label></td>
                                                                                            <td><label id="infochangetopeding" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Change to Pending Date</label></td>
                                                                                            <td><label id="infochangetopendingdate" style="font-size: 14px;font-weight:bold;"></label></td>
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
                                                                                            <td><label style="font-size: 14px;">Last Edited By</label></td>
                                                                                            <td><label id="infolasteditedby" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Last Edited Date</label></td>
                                                                                            <td><label id="infolastediteddate" style="font-size: 14px;font-weight:bold;"></label></td>
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
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail Information</div>
                        </div>
                        <div id="quantitysdiv">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="adjinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <th>#</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>SKU Number</th>
                                                <th>UOM</th>
                                                <th>Stock Out(<i class="fa fa-minus" aria-hidden="true"></i>)</th>
                                                <th>Value</th>
                                                <th>Total Value</th>
                                                <th>Reason</th>
                                                <th>Remark</th>
                                            </thead>
                                            <tfoot>
                                                <td colspan="7" style="text-align: right;">
                                                    <label style="font-size: 14px;font-weight:bold;">Sub Total</label>
                                                </td>
                                                <td colspan="3" style="text-align: left">
                                                    <label class="adjtotalvaluelbl" style="font-size: 14px;"></label>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="quantitycostdiv">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="adjinfodetailqcost" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <th>#</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>SKU Number</th>
                                                <th>UOM</th>
                                                <th>Stock In(<i class="fa fa-plus" aria-hidden="true"></i>)</th>
                                                <th>Value</th>
                                                <th>Total Value</th>
                                                <th>Reason</th>
                                                <th>Remark</th>
                                            </thead>
                                            <tfoot>
                                                <td colspan="7" style="text-align: right;">
                                                    <label style="font-size: 14px;font-weight:bold;">Sub Total</label>
                                                </td>
                                                <td colspan="3" style="text-align: left">
                                                    <label class="adjtotalvaluelbl" style="font-size: 14px"></label>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" placeholder="" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                    <input type="hidden" class="form-control" name="adjustmentidsval" id="adjustmentidsval" readonly="true"/>  
                    @can('Adjustment-Change-to-Pending')
                    <button id="changetopending" type="button" onclick="getPendingInfoConf()" class="btn btn-info">Change to Pending</button>
                    @endcan
                    @can('Adjustment-Check')
                    <button id="checkadjustment" type="button" onclick="getCheckInfoConf()" class="btn btn-info">Check Adjustment</button>
                    @endcan
                    @can('Adjustment-Confirm')
                    <button id="confirmadjustment" type="button" onclick="getConfirmInfoConf()" class="btn btn-info">Confirm Adjustment</button>
                    @endcan
                    <button id="closebuttona" type="button" class="btn btn-danger" onclick="closeInfoModal()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Info -->

<!-- Start serial number modal -->
<div class="modal fade text-left" id="serialNumberModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="serialnumbertitle">Register Serial Number / Manufacture Date  <strong id="st-name"></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeSn();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="serialNumberRegForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0">
                                <label style="font-size: 14px;">Brand</label>
                                <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="brand" id="brand" onchange="brandVal();">
                                    <option selected value="1"></option>
                                    @foreach ($brand as $brand)
                                        <option value="{{$brand->id}}"> {{$brand->Name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="brand-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0">
                                <label style="font-size: 14px;">Model</label>
                                <div>
                                    <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="modelNumber" id="modelNumber" onchange="modelNumberVal();">
                                        <option selected disabled value=""></option>
                                    </select>
                                </div>
                                <span class="text-danger">
                                    <strong id="model-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0">
                                <label style="font-size: 14px;">Manufacture Date</label>
                                <input type="text" id="ManufactureDate" name="ManufactureDate" class="form-control" placeholder="YYYY-MM-DD" onchange="mfgDateVal();" readonly="true"/>
                                <span class="text-danger">
                                    <strong id="manfdate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="expiredatediv" style="display:none;">
                                <label style="font-size: 14px;">Expired Date</label>
                                <input type="text" id="ExpireDate" name="ExpireDate" class="form-control" placeholder="YYYY-MM-DD" onchange="expireDateVal();" readonly="true"/>
                                <span class="text-danger">
                                    <strong id="expiredate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="batchnumberdiv" style="display:none;">
                                <label style="font-size: 14px;">Batch Number</label>
                                <div class="invoice-customer">
                                    <input type="text" placeholder="Enter batch number" class="form-control" name="BatchNumber" id="BatchNumber" onkeyup="batchNumberVal();"/>       
                                    <span class="text-danger">
                                        <strong id="batchnum-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="serialnumdiv" style="display:none;">
                                <label style="font-size: 14px;">Serial Number</label>
                                <div class="invoice-customer">
                                    <input type="text" placeholder="Enter serial number" class="form-control" name="SerialNumber" id="SerialNumber" onkeyup="serialNumberVal();"/>       
                                    <span class="text-danger">
                                        <strong id="serialnum-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="quantitydiv" style="display:none;">
                                <label style="font-size: 14px;">Quantity</label>
                                <div class="invoice-customer">
                                    <input type="number" placeholder="Enter quantity" class="form-control" name="Quantity" id="Quantity" value="1" onkeyup="batchQuantityVal();" onkeypress="return ValidateNum(event);"/>       
                                    <span class="text-danger">
                                        <strong id="quantitybatch-error"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-10 col-md-6 col-sm-12 mb-2">
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                <label style="font-size: 16px;"></label>
                                <div style="text-align: right;">
                                    <div id="dynamicbuttondiv">
                                        <button id="saveSerialNum" type="button" class="btn btn-info btn-sm">Add</button>
                                        <button id="closeSerialNum" type="button" class="btn btn-danger btn-sm" style="display: none;" onclick="closeSn();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                    <div id="staticbuttondiv" display="display:none;">
                                        <button id="saveSerialNumSt" type="button" class="btn btn-info btn-sm">Add</button>
                                        <button id="closeSerialNumSt" type="button" class="btn btn-danger btn-sm" style="display: none;" onclick="closeSnSt();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-11 col-md-6 col-sm-12 mb-2">
                            </div>
                            <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                <div>
                                    <table>
                                        <tr>
                                            <td><label style="font-size: 12px;">Total Qty </label></td>
                                            <td><label id="totalQuantityLbl" style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 12px;">Inserted </label></td>
                                            <td><label id="insertedQuantityLbl" style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 12px;">Remaining </label></td>
                                            <td><label id="remainingQuantityLbl" style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">-</div>
                        </div>                                   
                    </div>
                <div style="width:98%; margin-left:1%;" style="display: none;">
                    <div id="dynamicTableDiv">        
                        <table id="laravel-datatable-crud-sn" class="table table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>ItemId</th>
                                    <th>StoreId</th>
                                    <th>Brand Name</th>
                                    <th>Model Name</th>
                                    <th>Manufacture Date</th>
                                    <th>Expire Date</th>
                                    <th>Batch Number</th>
                                    <th>Serial Number</th>
                                    <th style="width:20%;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="staticTableDiv" style="display:none;">        
                        <table id="laravel-datatable-crud-snedit" class="table table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>ItemId</th>
                                    <th>StoreId</th>
                                    <th>Brand Name</th>
                                    <th>Model Name</th>
                                    <th>Manufacture Date</th>
                                    <th>Expire Date</th>
                                    <th>Batch Number</th>
                                    <th>Serial Number</th>
                                    <th style="width:20%;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="tableid" class="form-control" name="tableid" readonly="true"/>
                    <input type="hidden" id="serialnumreq" class="form-control" name="serialnumreq" readonly="true"/>
                    <input type="hidden" id="expirenumreq" class="form-control" name="expirenumreq" readonly="true"/>
                    <input type="hidden" id="seritemid" class="form-control" name="seritemid" readonly="true"/>
                    <input type="hidden" id="serheaderid" class="form-control" name="serheaderid" readonly="true"/>
                    <input type="hidden" id="serstoreid" class="form-control" name="serstoreid" readonly="true"/>
                    <input type="hidden" id="storeQuantity" class="form-control" name="storeQuantity" readonly="true"/>
                    <input type="hidden" id="commonserval" class="form-control" name="commonserval" readonly="true"/>
                    <input type="hidden" id="dynamicrownum" class="form-control" name="dynamicrownum" readonly="true"/>
                    <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeSn();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Serial Number Registation Modal -->

<!--Start Serial Number Delete modal -->
<div class="modal fade text-left" id="sernumDeleteModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteserialnumform">
                <div class="modal-body">
                    <label style="font-size: 16px;">Are you sure you want to delete</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="sid" id="sid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="totalBegQuantity" id="totalBegQuantity" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="dynamicdelval" id="dynamicdelval" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deleteSerialNumberBtn" type="button" class="btn btn-info">Delete</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Serial Number Delete Modal -->

 <!--Start Issue modal -->
 <div class="modal fade text-left" id="issueserialnumodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="issueserialnumberstitle">Select serial numbers</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="serialnumberVal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="issueserialnumberform">
                @csrf
                <div class="modal-body">
                    <label style="font-size: 16px;">Select serial number, batch number or expire date</label>
                    <div class="form-group">
                        <div>
                            <select class="select2 form-control" name="SerialNumber[]" id="SerialNumberIssue" onchange="serialnumberVal()" multiple="multiple"></select>
                        </div>
                        <span class="text-danger">
                            <strong id="serialnumbers-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="recids" id="recids" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="listofsernum" id="listofsernum" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="rownumval" id="rownumval" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="serialnumissuebtn" type="button" class="btn btn-info">Save</button>
                    <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal" onclick="serialnumberVal()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Issue modal -->

<!--Start Pending adjustment modal -->
<div class="modal fade text-left" id="adjustmentpendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pendingreceivingform">
                @csrf
                <div class="modal-body" style="background-color:#f6c23e">
                    <label style="font-size: 16px;font-weight:bold;">Do you really want to change adjustment to pending?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="pendingid" id="pendingid"
                            readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="pendingbtn" type="button" class="btn btn-info">Change to Pending</button>
                    <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Pending adjustment modal -->

<!--Start Confimed adjustment modal -->
<div class="modal fade text-left" id="adjustmentconfirmedmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                    <label style="font-size: 16px;font-weight:bold;">Do you really want to confirm adjustment?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="confirmid" id="confirmid" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="confirmbtn" type="button" class="btn btn-info">Confirm Adjustment</button>
                    <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Confimed adjustment modal -->

<!--Start Check adjustment modal -->
<div class="modal fade text-left" id="adjustmentcheckmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="checkreceivingform">
                @csrf
                <div class="modal-body" style="background-color:#f6c23e">
                    <label style="font-size: 16px;font-weight:bold;">Do you really want to check adjustment?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="checkedid" id="checkedid"
                            readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="checkedbtn" type="button" class="btn btn-info">Check Adjustment</button>
                    <button id="closebuttonf" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Check adjustment modal -->

<!--Start Void modal -->
<div class="modal fade text-left" id="voidreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="voidReason()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="voidreasonform">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to void adjustment?</label>
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
                        <input type="hidden" placeholder="" class="form-control" name="voidid" id="voidid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="vstatus" id="vstatus" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
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
                    <label style="font-size: 16px;font-weight:bold;">Do you really want to undo void adjustment?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="ustatus" id="ustatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
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


<script  type="text/javascript">
    var errorcolor="#ffcccc";
    $(function () {
        cardSection = $('#page-block');
    });

    function formatText (icon) {
        return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
    };

    $('#adjtype').select2({
        templateSelection: formatText,
        templateResult: formatText,
        minimumResultsForSearch: -1
    });
    

    //Start page load event
    $(document).ready( function () 
    {
        var today = new Date();
        var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
        var dd = today.getDate();
        var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) : + (today.getMonth()+1); 
        var yyyy = today.getFullYear();
        var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
        $('#date').val(currentdate);
        $(".selectpicker").selectpicker({
            noneSelectedText : ''
        });
        $('#fiscalyear').select2();
        $("#ManufactureDate").datepicker({ dateFormat:"yy-mm-dd",changeYear:true,changeMonth:true,yearRange: "1990:2099"}).datepicker();
        $("#ExpireDate").datepicker({ dateFormat:"yy-mm-dd",changeYear:true,changeMonth:true,yearRange: "1990:2099"}).datepicker();
        $("#dynamicTable").show();
        $("#adds").show();
        $('#adjustmentId').val("");
        $("#storediv").show();
        $("#storeEditDiv").hide();
        $("#typeDiv").show();
        $("#typeDivEdit").hide();
        $("#fiscalyrdiv").hide();
        $("#fiscalyrdivedit").hide();
        $("#adjReason option[value=Stolen-Goods]").hide();
        $("#adjReason option[value=Damaged-Goods]").hide();
        $("#adjReason option[value=Missing-Goods]").hide();
        $("#adjReason option[value=Internal-Use]").hide();
        $("#adjReason option[value=Gift]").hide();
        $("#adjReason option[value=Found-New-Goods]").hide();
        $("#adjReason option[value=Counting-Error]").hide();
        $("#stockintr").hide();
        $('#editstore').prop( "disabled", true );
        $('#laravel-datatable-crud').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            "order": [[ 0, "desc" ]],
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
                url: '/adjustmentdata',
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
                statusCode: {
                    401: function() {
                        toastrMessage('error',"Session Expired!","Error");
                        location.reload(false);
                    }
                },
            },
            columns: [
                { data: 'id', name: 'id' , 'visible': false },
                { data:'DT_RowIndex'},
                { data: 'DocumentNumber', name: 'DocumentNumber' },
                { data: 'Type', name: 'Type' },
                { data: 'Reason', name: 'Reason','visible':false},
                { data: 'Store', name: 'Store'},
                { data: 'AdjustedBy', name: 'AdjustedBy'},
                { data: 'FiscalYear', name: 'FiscalYear','visible': false},  
                { data: 'AdjustedDate', name: 'AdjustedDate'},
                { data: 'Status', name: 'Status'},
                { data: 'action', name: 'action'}
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.Status == "Pending") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#f6c23e",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #f6c23e"
                    });
                } else if (aData.Status == "Checked") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#4e73df",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #4e73df"
                    });
                } else if (aData.Status == "Confirmed") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#1cc88a",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #1cc88a"
                    });
                } else if (aData.Status == "Void"||aData.Status == "Void(Pending)"||aData.Status == "Void(Checked)"||aData.Status == "Void(Confirmed)") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#e74a3b",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #e74a3b"
                    });
                }
            }
            
        });       
    });
    //End page load event

    $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    //Start save requistion
    $('#savebutton').click(function()
    {    
        var registerForm = $("#Register");
        var formData = registerForm.serialize(); 
        var rownum=$('#numberofItems').val();
        var optype=$('#operationtypes').val();
        var serid=[];
        for(var i=1;i<=rownum;i++){
            if(typeof $("#serialnumids"+i).val()!=="undefined"){
                serid.push($('#serialnumids'+i).val());
            }
            else if($("#serialnumids"+i).val()!==0||$("#serialnumids"+i).val()!==""||$("#serialnumids"+i).val()!==null){
                serid.push($('#serialnumids'+i).val());
            }
        }
        $("#allserialNumIds").val(serid);
        var arr = [];
        var found = 0;
        $('.itemName').each (function() //item dropdown in the repeater 
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
            $.ajax(
            {
                url:'/saveAdjustment',
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
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"The following items have a transactions you cant edit </br>"+loopedVal,"Error");
                            closeModalWithClearValidation();
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            $("#inlineForm").modal('hide');
                        }    
                    }
                    else if(data.serisserror)
                    {
                        var singleVal='';
                        var loopedVal='';
                        var len=data['serisserror'].length;
                        for(var i=0;i<=len;i++) 
                        {  
                            var count=data.countedisserval;
                            var inc=i+1;
                            singleVal=(data['countisSerItems'][i].AllValues);
                            loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please select another serial number or batch number, the following "+count+" serial number or batch number are being issued </br>"+loopedVal,"Error");
                        }    
                    }
                    else if(data.errors) 
                    {
                        if(data.errors.adjustmentnumi){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Document number already exist </br> close this window and start again","Error");
                        }
                        if(data.errors.Store){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            $('#store-error').html(data.errors.Store[0]);
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if(data.errors.Type){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            $('#type-error' ).html( data.errors.Type[0] );
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if(data.errors.date){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            $('#date-error' ).html(data.errors.date[0]);
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if(data.errors.Reason){
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            $('#reason-error').html( data.errors.Reason[0]);
                            toastrMessage('error',"Check your inputs","Error");
                        }
                    }
                    else if(data.errorv2)
                    {
                        var error_html = '';
                        for(var k=1;k<=m;k++){
                            var itmid=($('#itemNameSl'+k)).val();
                            var reasons=($('#Reason'+k)).val();
                            if(($('#StockIn'+k).val())!=undefined){
                                var qnt=$('#StockIn'+k).val();
                                var qntonhand=$('#AvQuantity'+k).val();
                                if(isNaN(parseFloat(qnt))||parseFloat(qnt)==0){
                                    $('#StockIn'+k).css("background", errorcolor);
                                    toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                }
                            }
                            if(($('#StockOut'+k).val())!=undefined){
                                var qnt=$('#StockOut'+k).val();
                                var qntonhand=$('#AvQuantity'+k).val();
                                if(isNaN(parseFloat(qnt))||parseFloat(qnt)==0){
                                    $('#StockOut'+k).css("background", errorcolor);
                                    toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                }
                            }
                            if(($('#UnitCost'+k).val())!=undefined){
                                var ucost=$('#UnitCost'+k).val();
                                if(isNaN(parseFloat(ucost))||parseFloat(ucost)==0){
                                    $('#UnitCost'+k).css("background", errorcolor);
                                    toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                }
                            }
                            if(($('#StockOutUnitCost'+k).val())!=undefined){
                                var ucost=$('#StockOutUnitCost'+k).val();
                                if(isNaN(parseFloat(ucost))||parseFloat(ucost)==0){
                                    $('#StockOutUnitCost'+k).css("background", errorcolor);
                                    toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                                }
                            }
                            if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                                $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                                toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                            }
                            if(reasons==""||reasons==null||reasons===""){
                                $('#select2-Reason'+k+'-container').parent().css('background-color',errorcolor);
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
                    else if(data.strdifferrors)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You cant change current store/shop to posted store/shop","Error");
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
                        toastrMessage('error',"There is duplicate entry","Error");
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
                        toastrMessage('error',"The following items have a transactions you cant edit</br>"+loopedVal,"Error");
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
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
                        toastrMessage('error',"The following items have a transactions you cant edit</br>"+loopedVal,"Error");
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                    }
                    else if (data.qcqnterror) {
                        var singleVal='';
                        var remitems='';
                        var loopedVal='';
                        var indx='';
                        var indxrem='';
                        var count='';
                        var len=data['qcqnterror'].length;
                        count=data.countedval;

                        $.each(data.countItems, function(index, value) {
                            singleVal=value.ItemName;
                        });

                        $.each(data.countremitems, function(index, value) {
                            remitems=value.RemovedItemName;
                        });
                        loopedVal=singleVal+"</br>"+remitems;
                        toastrMessage('error',"The following items have a transactions you cant edit</br>"+loopedVal,"Error");
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                    }
                    else if (data.qcunqnterror) {
                        var singleVal='';
                        var remitems='';
                        var loopedVal='';
                        var indx='';
                        var indxrem='';
                        var count='';
                        var len=data['qcunqnterror'].length;
                        count=data.countedval;

                        $.each(data.countItems, function(index, value) {
                            singleVal=value.ItemName;
                        });

                        $.each(data.countremitems, function(index, value) {
                            remitems=value.RemovedItemName;
                        });
                        loopedVal=singleVal+"</br>"+remitems;
                        toastrMessage('error',"There is no available quantity for "+count+"  Items</br>"+loopedVal,"Error");
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                    }
                    else if(data.rowerrors)
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
                    else if(data.emptyerror)
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
                        closeModalWithClearValidation();
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                        $('#adjustmentId').val("");
                    }
                },
            });
        }
    });   
    //End save requistion

    //Start type change
    $('.syncitems').on('change', function() {
        var storeidvar = $('#Store').val()||0;
        var adjtypevar = $('#adjtype').val();
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/syncDynamicTablead',
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
                $.each(data.bal,function(key, value) {
                    ++q;
                    var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(2).find('select').val();
                    if(itemids==value.ItemId){
                        var qtyonhand=value.Balance;
                        var qty=$('#dynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val();
                        $('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val(value.Balance);
                        if(parseFloat(qtyonhand)<parseFloat(qty) || parseFloat(qtyonhand)==0){
                            $('#dynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val("");
                            $('#dynamicTable tr:eq('+q+')').find('td').eq(10).find('input').val("");
                            $('#dynamicTable tr:eq('+q+')').find('td').eq(11).find('input').val("");
                        }
                    }
                });
                for(var y=1;y<=m;y++){
                    var qtyonhand=($('#AvQuantity'+y)).val()||0;
                    var qty=($('#StockOut'+y)).val()||0;
                    if(parseFloat(qtyonhand)<parseFloat(qty)|| parseFloat(qtyonhand)==0){
                        ($('#StockOut'+y)).val("");
                        ($('#beforetax'+y)).val("");
                        ($('#beforetactuc'+y)).val("");
                    }
                }
                CalculateGrandTotal();
            }
        });
    });
    //End Type change

    //Start get adjustment number value
    $('body').on('click', '.addadjbutton', function () {
        $("#inlineForm").modal('show');
        $("#adjustmentmodaltitle").html('Add Stock Adjustment');
        $('#tid').val("");
        $('#receivingId').val("");
        $('#operationtypes').val("1");
        $('#hiddenstr').val(""); 
        $.get("/getadjnumber"  , function (data) {
            $('#adjustmentnumi').val(data.adjnum);
            var dbval=data.AdjustmentCount;
            var rnum=(Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
            $('#commonVal').val(rnum+dbval);
        });
       
        var currentdate=$("#cdate").val();
        $('#date').val(currentdate);
        $("#dynamicTable").show();
        $("#adds").show();
        $("#storediv").show();
        $("#storeEditDiv").hide();
        $("#typeDiv").show();
        $("#typeDivEdit").hide();
        $("#fiscalyrdiv").hide();
        $("#fiscalyrdivedit").hide();
        $("#statusdisplay").html("");
        $('#savebutton').text('Save');
        $('#savebutton').prop("disabled", false);
        $('#adjtype').select2('destroy');
        $('#adjtype').val(null).select2();
        $('#adjtype').select2({
            templateSelection: formatText,
            templateResult: formatText,
            minimumResultsForSearch: -1,
            placeholder: "Select Adjustment Type here",
        });

        $('#Store').select2
        ({
            placeholder: "Select Store/Shop here",
        });
    });
    //End get adjustment number value

    //Start show receiving doc info
    //$(document).on('click', '.DocAdjInfo', function(){
    function DocAdjInfo(recordId){
        //var recordId = $(this).data('id');
        //var statusval = $(this).data('status');
        $("#reqId").val(recordId);
        

        $.get("/showAdjDataHeader" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.adjHeader.length;
            for(var i=0;i<=len;i++) 
            {
                $('#adjustmentidsval').val(data.adjHeader[i].id);  
                $('#infodocnum').text(data.adjHeader[i].DocumentNumber);
                $('#infostore').text(data.adjHeader[i].Store);
                $('#infoadjustedby').text(data.adjHeader[i].AdjustedBy);
                $('#infoadjusteddate').text(data.adjHeader[i].created_at);
                $('#infofiscalyear').text(data.adjHeader[i].FiscalYear);
                $('#inforeason').text(data.adjHeader[i].Reason);
                $('#infodescription').text(data.adjHeader[i].Memo);
                $('#infostatuslbl').text(data.adjHeader[i].Status);
                $('#infocheckedby').text(data.adjHeader[i].CheckedBy);
                $('#infocheckeddate').text(data.adjHeader[i].CheckedDate);
                $('#infoconfirmedby').text(data.adjHeader[i].ConfirmedBy);
                $('#infoconfirmeddate').text(data.adjHeader[i].ConfirmedDate);
                $('#infochangetopeding').text(data.adjHeader[i].ChangetoPendingBy);
                $('#infochangetopendingdate').text(data.adjHeader[i].ChangetoPendingDate);
                $('#infovoidby').text(data.adjHeader[i].VoidBy);
                $('#infovoiddate').text(data.adjHeader[i].VoidDate);
                $('#infovoidreason').text(data.adjHeader[i].VoidReason);
                $('#infoundovoidby').text(data.adjHeader[i].UndoVoidBy);
                $('#infoundovoiddate').text(data.adjHeader[i].UndoVoidDate);
                $('#infolasteditedby').text(data.adjHeader[i].EditConfirmedBy);
                $('#infolastediteddate').text(data.adjHeader[i].EditConfirmedDate);
                $('.adjtotalvaluelbl').text(data.adjHeader[i].TotalValue);
                $("#statusi").val(data.adjHeader[i].Status);
                var types=data.adjHeader[i].Type;
                var statusvals=data.adjHeader[i].Status;
                var statusvalsold=data.adjHeader[i].StatusOld;
                if(types==="Quantity")
                {
                    $("#quantitycostdiv").hide();
                    $("#quantitysdiv").show();
                    $('#infotype').html(data.adjHeader[i].Type+" <b>(-)</b>");
                }
                else if(types==="Quantity&Cost")
                {
                    $("#quantitysdiv").hide();
                    $("#quantitycostdiv").show();
                    $('#infotype').html(data.adjHeader[i].Type+" <b>(+)</b>");
                }
                if(statusvals==="Pending"){
                    $("#changetopending").hide();
                    $("#checkadjustment").show();
                    $("#confirmadjustment").hide();
                    $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+statusvals+"</span>");
                }
                else if(statusvals==="Checked"){
                    $("#changetopending").show();
                    $("#checkadjustment").hide();
                    $("#confirmadjustment").show();
                    $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>"+statusvals+"</span>");
                }
                else if(statusvals==="Confirmed"){
                    $("#changetopending").hide();
                    $("#checkadjustment").hide();
                    $("#confirmadjustment").hide();
                    $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+statusvals+"</span>");
                }
                else{
                    $("#changetopending").hide();
                    $("#checkadjustment").hide();
                    $("#confirmadjustment").hide();
                    $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>"+statusvals+"("+statusvalsold+")</span>");
                }
            }    
        })

        $('#adjinfodetail').DataTable({
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
            url: '/showAdjDetailapp/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            {
                data: 'ItemName',
                name: 'ItemName',
                width:'20%',
                "render": function ( data, type, row, meta ) {
                    if(row.RequireSerialNumber=="Not-Require" && row.RequireExpireDate=="Not-Require"){
                        return '<div>'+data+'</div>'
                    }
                    else{
                        return '<div><u>'+data+'</u><br/><table><tr><td>Batch#</td><td>Serial#</td><td>ExpiredDate</td><td>ManfacDate</td></tr><tr><td>'+row.BatchNumber+'</td><td>'+row.SerialNumber+'</td><td>'+row.ExpireDate+'</td><td>'+row.ManufactureDate+'</td></tr></table></div>'
                    }
                } 
            },
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'UOM', name: 'UOM'}, 
            { data: 'StockOut', name: 'StockOut',render: $.fn.dataTable.render.number(',', '.',0, '')},
            { data: 'StockOutUnitCost', name: 'StockOutUnitCost',render: $.fn.dataTable.render.number(',', '.',2, '')},    
            { data: 'StockOutBeforeTaxCost', name: 'StockOutBeforeTaxCost',render: $.fn.dataTable.render.number(',', '.',2, '')},
            { data: 'Reason', name: 'Reason', width:'15%'},  
            { data: 'Memo', name: 'Memo'}
        ],
        });
        
        $('#adjinfodetailqcost').DataTable({
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
            url: '/showAdjDetailapp/'+recordId,
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
            {
                data: 'ItemName',
                name: 'ItemName',
                width:'30%',
                "render": function ( data, type, row, meta ) {
                    if(row.RequireSerialNumber=="Not-Require" && row.RequireExpireDate=="Not-Require"){
                        return '<div>'+data+'</div>'
                    }
                    else{
                        return '<div><u>'+data+'</u><br/><table><tr><td>Batch#</td><td>Serial#</td><td>ExpiredDate</td><td>ManfacDate</td></tr><tr><td>'+row.BatchNumber+'</td><td>'+row.SerialNumber+'</td><td>'+row.ExpireDate+'</td><td>'+row.ManufactureDate+'</td></tr></table></div>'
                    }
                } 
            },
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'UOM', name: 'UOM'},  
            { data: 'StockIn', name: 'StockIn',render: $.fn.dataTable.render.number(',', '.',0,'')},
            { data: 'UnitCost', name: 'UnitCost',render: $.fn.dataTable.render.number(',', '.',2,'')}, 
            { data: 'BeforeTaxCost', name: 'BeforeTaxCost',render: $.fn.dataTable.render.number(',', '.',2,'')},   
            { data: 'Reason', name: 'Reason', width:'15%'},    
            { data: 'Memo', name: 'Memo'}
        ],
        });
        $.fn.dataTable.ext.errMode = 'throw';
        var iTable = $('#adjinfodetail').dataTable(); 
        iTable.fnDraw(false);
        var jTable = $('#adjinfodetailqcost').dataTable(); 
        jTable.fnDraw(false);
        $(".infoscl").collapse('show');
        $("#adjInfoModal").modal('show');
    }
    //End show receiving doc info

    //Start get hold number value
    $('body').on('click', '#getAdjDocNum', function () {
        $.get("/getadjnumber"  , function (data) {
            $('#adjustmentnumi').val(data.adjnum);
            $("#myToast").toast('hide');
        });
    });
    //End get hold number value

    //$('body').on('click', '.editAdjHeader', function () {
    //$("body").off("click").on('click','.editAdjHeader',function() {
    function editadjustmentdata(recIdVar) {
        $('.select2').select2();
        //var recIdVar = $(this).data('id');
        var storeName = $(this).data('store');
        var fiscalyrs = $(this).data('fyear');
        var fiscalyearcurrent="";
        var fiscalyearadj="";
        var fiscalyearstr="";
        var statusval="";
        $("#adjustmentmodaltitle").html('Update Stock Adjustment');
        $('#operationtypes').val("2");
        var storeidvar="";
        var j=0;
        $('#editfiscalyrtxt').val(fiscalyrs);
        $('#editstore').val(storeName);
        $('#adjustmentId').val(recIdVar);
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
        $.get("/adjustmentedit" +'/' + recIdVar , function (data) {
            statusval=data.adjdata.Status;
            fiscalyearadj=data.adjdata.fiscalyear;
            fiscalyearcurrent=data.fyearcurr;
            fiscalyearstr=data.fiscalyrstr;
            if(statusval=="Void"){
                toastrMessage('error',"You cant update on this status","Error");
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
            }
            else if(parseFloat(fiscalyearadj)!=parseFloat(fiscalyearstr)){
                toastrMessage('error',"You cant update a closed fiscal year transaction","Error");
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
            }
            else{
                $('#adjtype').select2('destroy');
                $('#adjtype').val(data.adjdata.Type).select2();
                $('#adjtype').select2({
                    templateSelection: formatText,
                    templateResult: formatText,
                    minimumResultsForSearch: -1
                });
                $('#Store').select2('destroy');
                $('#Store').val(data.adjdata.StoreId).select2();
                $('#Description').val(data.adjdata.Memo);
                $('#typeStrEdit').val(data.adjdata.Type); 
                $('#date').val(data.adjdata.AdjustedDate); 
                storeidvar=data.adjdata.StoreId;
                $('#hiddenstr').val(data.adjdata.StoreId); 
                var types=data.adjdata.Type;
                appendTable();
                if(types==="Quantity")
                {
                    $("#adjReason option[value=Stolen-Goods]").show();
                    $("#adjReason option[value=Damaged-Goods]").show();
                    $("#adjReason option[value=Missing-Goods]").show();
                    $("#adjReason option[value=Internal-Use]").show();
                    $("#adjReason option[value=Gift]").show();
                    $("#adjReason option[value=Found-New-Goods]").hide();
                    $("#adjReason option[value=Counting-Error]").show();
                    $('#stockintr').hide();
                    $('#stockouttr').show();
                }
                else if(types==="Quantity&Cost")
                {
                    $("#adjReason option[value=Stolen-Goods]").hide();
                    $("#adjReason option[value=Damaged-Goods]").hide();
                    $("#adjReason option[value=Missing-Goods]").hide();
                    $("#adjReason option[value=Internal-Use]").hide();
                    $("#adjReason option[value=Gift]").hide();
                    $("#adjReason option[value=Found-New-Goods]").show();
                    $("#adjReason option[value=Counting-Error]").show();
                    $('#stockintr').show();
                    $('#stockouttr').hide();
                }
                $('#adjReason').val(data.adjdata.Reason);
                var statusvals=data.adjdata.Status;
                if(statusvals==="Pending"){
                    $("#statusdisplay").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                }
                else if(statusvals==="Checked"){
                    $("#statusdisplay").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                }
                else if(statusvals==="Confirmed"){
                    $("#statusdisplay").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+statusvals+"</span>");
                }
                var allselecteditems=[];
                $.each(data.adjdetail, function(key, value) {
                    ++i;
                    ++m;
                    ++j;
                    if(types==="Quantity"){
                        $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width: 20%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row['+m+'][ItemId]"></select></td>'+
                            '<td style="display:none;"><input type="text" name="row['+m+'][ItemCode]" placeholder="Item Code" id="ItemCode'+m+'" class="ItemCode form-control" readonly="true" value="'+value.ItemCode+'"/></td>'+
                            '<td style="width:10%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true" value="'+value.UomName+'"/></td>'+
                            '<td style="width:10%;"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true" placeholder="Quantity on hand"/></td>'+
                            '<td class="stockouttdcl" style="width:12%"><input type="number" name="row['+m+'][StockOut]" onkeypress="return ValidateNum(event);" value="'+value.StockOut+'" onkeyup="CalculateTotalSO(this)" id="StockOut'+m+'" class="StockOut form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#e74a3b;color:#e74a3b;font-weight:bold"/></td>'+
                            '<td class="stockoutcosttdcl" style="width:10%;"><input type="number" name="row['+m+'][StockOutUnitCost]" id="StockOutUnitCost'+m+'" onkeypress="return ValidateNum(event);" value="'+value.StockOutUnitCosts+'" onkeyup="CalculateTotalSO(this)" ondrop="return false;" onpaste="return false;" class="StockOutUnitCost form-control numeral-mask" style="font-weight:bold;" readonly="true"/></td>'+
                            '<td class="stockintdcl" style="width:12%;display:none;"><input type="text" name="row['+m+'][StockIn]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" id="StockIn'+m+'" class="StockIn form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#1cc88a;color:#1cc88a;font-weight:bold"/></td>'+
                            '<td class="unitcosttdcl" style="width:10%;display:none;"><input type="text" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" ondrop="return false;" onpaste="return false;" class="UnitCost form-control numeral-mask" style="font-weight:bold;" readonly="true"/></td>'+
                            '<td class="stockoutcostbtax" style="width:10%;"><input type="number" name="row['+m+'][StockOutBeforeTaxCost]" id="beforetax'+m+'" value="'+value.StockOutBeforeTaxCost+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td class="stockoutcostbtaxuc" style="width:10%;display:none;"><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetactuc'+m+'" value="'+value.BeforeTaxCost+'" class="beforetactuc form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="width:13%;"><select id="Reason'+m+'" onchange="reasonVal(this)" class="select2 form-control Reason" name="row['+m+'][Reason]"></select></td>'+
                            '<td style="width:13%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control" value="'+value.ReqMemo+'"/></td>'+
                            '<td style="display:none;"></td>'+
                            '<td style="width:2%;text-align:center"><button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="issSer(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;" value="'+value.StoreId+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Adjustment" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireSerialNumber]" id="RequireSerialNumber'+m+'" class="RequireSerialNumber form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireExpireDate]" id="RequireExpireDate'+m+'" class="RequireExpireDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][insertedqty]" id="insertedqty'+m+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="'+value.StockOut+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+j+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][serialnumids]" id="serialnumids'+m+'" class="serialnumids form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                        '</tr>');
                        var opt = '<option selected value="'+value.ItemId+'">'+value.ItemCode+'  ,   '+value.ItemName+'  ,   '+value.SKUNumber+'</option>';
                        var optreason = '<option selected value="'+value.Reason+'">'+value.Reason+'</option>';
                        var options = $("#allitems > option").clone();
                        $('#itemNameSl'+m).append(options); 
                        $("#itemNameSl"+m+" option[title!='"+storeidvar+"']").remove();
                        $("itemNameSl"+m+" option[label=0]").remove();
                        for(var k=1;k<=m;k++){
                            if(($('#itemNameSl'+k).val())!=undefined){
                                var selectedval=$('#itemNameSl'+k).val();
                                $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                            }
                        }
                        $('#itemNameSl'+m).append(opt);
                        $("#itemNameSl"+m).select2();
                        var adjreason = $("#adjReason > option").clone();
                        $('#Reason'+m).append(adjreason); 
                        $("#Reason"+m+" option[title=2]").remove();
                        $('#Reason'+m).append(optreason);
                        $("#Reason"+m).select2();
                        $('#numberofItemsLbl').text(j);
                        $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Reason'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }
                    else if(types==="Quantity&Cost"){
                        $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width: 20%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row['+m+'][ItemId]">@foreach ($itemSrcied as $itemSrcied)<option value="{{$itemSrcied->id}}">{{$itemSrcied->Code}}          ,          {{$itemSrcied->Name}}          ,         {{$itemSrcied->SKUNumber}}</option>@endforeach</select></td>'+
                            '<td style="display:none;"><input type="text" name="row['+m+'][ItemCode]" placeholder="Item Code" id="ItemCode'+m+'" class="ItemCode form-control" readonly="true" value="'+value.ItemCode+'"/></td>'+
                            '<td style="width:10%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true" value="'+value.UomName+'"/></td>'+
                            '<td style="width:10%;"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true" placeholder="Quantity on hand"/></td>'+
                            '<td class="stockintdcl" style="width:12%"><input type="number" name="row['+m+'][StockIn]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" id="StockIn'+m+'" value="'+value.StockIn+'" class="StockIn form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#1cc88a;color:#1cc88a;font-weight:bold"/></td>'+
                            '<td class="unitcosttdcl" style="width:10%;"><input type="number" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" value="'+value.UnitCosts+'" ondrop="return false;" onpaste="return false;" class="UnitCost form-control numeral-mask" style="font-weight:bold;" readonly="true"/></td>'+
                            '<td class="stockouttdcl" style="width:12%;display:none;"><input type="text" name="row['+m+'][StockOut]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSO(this)" id="StockOut'+m+'" class="StockOut form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#e74a3b;color:#e74a3b;font-weight:bold"/></td>'+
                            '<td class="stockoutcosttdcl" style="width:10%;display:none;"><input type="text" name="row['+m+'][StockOutUnitCost]" id="StockOutUnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSO(this)" ondrop="return false;" onpaste="return false;" class="StockOutUnitCost form-control numeral-mask" style="font-weight:bold;" readonly="true"/></td>'+
                            '<td class="stockoutcostbtaxuc" style="width:10%;"><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetactuc'+m+'" value="'+value.BeforeTaxCost+'" class="beforetactuc form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td class="stockoutcostbtax" style="width:10%;display:none;"><input type="number" name="row['+m+'][StockOutBeforeTaxCost]" id="beforetax'+m+'" value="'+value.StockOutBeforeTaxCost+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="width:13%;"><select id="Reason'+m+'" onchange="reasonVal(this)" class="select2 form-control Reason" name="row['+m+'][Reason]"></select></td>'+
                            '<td style="width:13%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control" value="'+value.ReqMemo+'"/></td>'+
                            '<td style="display:none;"></td>'+
                            '<td style="width:2%;text-align:center"><button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="issSer(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;" value="'+value.StoreId+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Adjustment" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireSerialNumber]" id="RequireSerialNumber'+m+'" class="RequireSerialNumber form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireExpireDate]" id="RequireExpireDate'+m+'" class="RequireExpireDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][insertedqty]" id="insertedqty'+j+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="'+value.StockIn+'"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+j+'"/></td>'+
                        '</tr>');
                        var opt = '<option selected value="'+value.ItemId+'">'+value.ItemCode+'  ,   '+value.ItemName+'  ,   '+value.SKUNumber+'</option>';
                        var optreason = '<option selected value="'+value.Reason+'">'+value.Reason+'</option>';
                        for(var k=1;k<=m;k++){
                            if(($('#itemNameSl'+k).val())!=undefined){
                                var selectedval=$('#itemNameSl'+k).val();
                                $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                            }
                        }
                        $('#itemNameSl'+m).append(opt);
                        $("#itemNameSl"+m).select2();
                        var adjreason = $("#adjReason > option").clone();
                        $('#Reason'+m).append(adjreason); 
                        $("#Reason"+m+" option[title=2]").remove();
                        $('#Reason'+m).append(optreason);
                        $("#Reason"+m).select2();
                        $('#numberofItemsLbl').text(j);
                        $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Reason'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    }
                });

                var q=0;
                var r=0;
                var sorteditems=allselecteditems.sort();
                $.each(data.bal, function(key, value) {
                    ++q;
                    var itemids=$('#dynamicTable tr:eq('+q+')').find('td').eq(2).find('select').val();
                    var currqnt=$('#dynamicTable tr:eq('+q+')').find('td').eq(6).find('input').val()||0;
                    if(itemids==value.ItemId){
                        var totalvals=parseFloat(value.Balance);
                        $('#dynamicTable tr:eq('+q+')').find('td').eq(5).find('input').val(totalvals);
                    }
                    ++r;
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
                $('.totalrownumber').show();
                $("#dynamicTable").show();
                $("#adds").show();
                $("#storediv").show();
                $("#storeEditDiv").hide();
                $("#typeDiv").show();
                $("#typeDivEdit").hide();
                $("#fiscalyrdiv").hide();
                $("#fiscalyrdivedit").hide();
                $('#savebutton').text('Update');
                $('#savebutton').prop("disabled", false);
                CalculateGrandTotal();
                $('#inlineForm').modal('show');
            }
        });   
    }

    //Start append item dynamically
    var j=0;
    var i=0;
    var m=0;
    $("#adds").click(function()
    {  
        var storeidvar = $('#Store').val();
        var adjustmenttype = $('#adjtype').val();
        var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
        var itemids=$('#itemNameSl'+lastrowcount).val();
        if(storeidvar==null||adjustmenttype==null)
        {
            if(storeidvar==null)
            {
                $('#store-error' ).html("The store/shop field is required.");            
            }
            if(adjustmenttype==null)
            {
                $('#type-error' ).html("The type field is required.");            
            }
            toastrMessage('error',"Check your inputs","Error");
        }
        else if(itemids!==undefined && itemids===null){
            $('#select2-itemNameSl'+lastrowcount+'-container').parent().css('background-color',errorcolor);
            toastrMessage('error',"Please select item from highlighted field","Error");
        }
        else
        {
            ++i;
            j+=1;
            ++m;
            $('#Reason'+m).empty();  
            if($("#adjtype").val()==="Quantity")
            {
                $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="width: 20%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control itemName" name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][ItemCode]" placeholder="Item Code" id="ItemCode'+m+'" class="ItemCode form-control" readonly="true"/></td>'+
                    '<td style="width: 10%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true"/></td>'+
                    '<td style="width: 10%;"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true" placeholder="Quantity on hand"/></td>'+
                    '<td class="stockouttdcl" style="width:12%"><input type="number" name="row['+m+'][StockOut]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSO(this)" id="StockOut'+m+'" class="StockOut form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#e74a3b;color:#e74a3b;font-weight:bold"/></td>'+
                    '<td class="stockoutcosttdcl" style="width:10%;"><input type="number" name="row['+m+'][StockOutUnitCost]" id="StockOutUnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSO(this)" ondrop="return false;" onpaste="return false;" class="StockOutUnitCost form-control numeral-mask" style="font-weight:bold;"/></td>'+
                    '<td class="stockintdcl" style="width:12%;display:none;"><input type="text" name="row['+m+'][StockIn]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" id="StockIn'+m+'" class="StockIn form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#1cc88a;color:#1cc88a;font-weight:bold"/></td>'+
                    '<td class="unitcosttdcl" style="width:10%;display:none;"><input type="text" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" ondrop="return false;" onpaste="return false;" class="UnitCost form-control numeral-mask" style="font-weight:bold;"/></td>'+
                    '<td class="stockoutcostbtax" style="width:10%;"><input type="number" name="row['+m+'][StockOutBeforeTaxCost]" id="beforetax'+m+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td class="stockoutcostbtaxuc" style="width:10%;display:none;"><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetactuc'+m+'" class="beforetactuc form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="width: 13%;"><select id="Reason'+m+'" onchange="reasonVal(this)" class="select2 form-control Reason" name="row['+m+'][Reason]"></select></td>'+
                    '<td style="width:17%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control"/></td>'+
                    '<td style="display:none;"></td>'+
                    '<td style="width:2%;text-align:center"><button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="issSer(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Adjustment" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireSerialNumber]" id="RequireSerialNumber'+m+'" class="RequireSerialNumber form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireExpireDate]" id="RequireExpireDate'+m+'" class="RequireExpireDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][insertedqty]" id="insertedqty'+m+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+j+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][serialnumids]" id="serialnumids'+m+'" class="serialnumids form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                '</tr>');
                var opt = '<option selected disabled value=""></option>';
                var options = $("#allitems > option").clone();
                var adjreason = $("#adjReason > option").clone();
                $('#itemNameSl'+m).append(options);
                $('#Reason'+m).append(adjreason);  
                $("#itemNameSl"+m+" option[title!='"+storeidvar+"']").remove();
                $("#Reason"+m+" option[title=2]").remove();
                $("itemNameSl"+m+" option[label=0]").remove();
                for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        var selectedval=$('#itemNameSl'+k).val();
                        $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#itemNameSl'+m).append(opt);
                $('#Reason'+m).append(opt);
                $('#itemNameSl'+m).select2
                ({
                    placeholder: "Select item here",
                });
                $('#Reason'+m).select2
                ({
                    placeholder: "Select reason here",
                });
                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Reason'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
            else if(adjustmenttype==null)
            {
                $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="width: 25%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control form-control-lg itemName" name="row['+m+'][ItemId]"><option selected disabled value=""></option>@foreach ($itemSrcd as $itemSrcd)<option value="{{$itemSrcd->id}}">{{$itemSrcd->Code}}          ,          {{$itemSrcd->Name}}          ,         {{$itemSrcd->SKUNumber}}</option>@endforeach</select></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][ItemCode]" placeholder="Item Code" id="ItemCode'+m+'" class="ItemCode form-control" readonly="true"/></td>'+
                    '<td><input type="text" name="row['+i+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true"/></td>'+
                    '<td><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true" placeholder="Quantity on hand"/></td>'+
                    '<td class="stockouttdcl" style="width:12%"><input type="number" name="row['+m+'][StockOut]" onkeypress="return ValidateNum(event);" onkeyup="checkQ(this)" id="StockOut'+m+'" class="StockOut form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#e74a3b;color:#e74a3b;font-weight:bold"/></td>'+
                    '<td class="stockoutcosttdcl" style="width:15%;"><input type="number" name="row['+m+'][StockOutUnitCost]" id="StockOutUnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="valcosts(this)" ondrop="return false;" onpaste="return false;" class="StockOutUnitCost form-control numeral-mask" style="font-weight:bold;"/></td>'+
                    '<td class="stockintdcl" style="width:12%;display:none;"><input type="text" name="row['+m+'][StockIn]" onkeypress="return ValidateNum(event);" onkeyup="compareQuantity(this)" id="StockIn'+m+'" class="StockIn form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#1cc88a;color:#1cc88a;font-weight:bold"/></td>'+
                    '<td class="unitcosttdcl" style="width:15%;display:none;"><input type="text" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="valcosts(this)" ondrop="return false;" onpaste="return false;" class="UnitCost form-control numeral-mask" style="font-weight:bold;"/></td>'+
                    '<td><input type="number" name="row['+m+'][StockOutBeforeTaxCost]" id="beforetax'+m+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td><select id="Reason'+m+'" class="select2 form-control form-control-lg Reason" name="row['+m+'][Reason]"></select></td>'+
                    '<td style="width:15%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control"/></td>'+
                    '<td style="width:2%;text-align:center"><button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="issSer(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+i+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+i+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Adjustment" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireSerialNumber]" id="RequireSerialNumber'+m+'" class="RequireSerialNumber form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireExpireDate]" id="RequireExpireDate'+m+'" class="RequireExpireDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][insertedqty]" id="insertedqty'+j+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+j+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][serialnumids]" id="serialnumids'+m+'" class="serialnumids form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                '</tr>');
                for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        var selectedval=$('#itemNameSl'+k).val();
                        $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#itemNameSl'+m).select2
                ({
                    placeholder: "Select item here",
                });
                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Reason'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
            else if($("#adjtype").val()==="Quantity&Cost")
            {
                $("#dynamicTable").append('<tr><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][idvals]" id="idvals'+m+'" class="idval form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="width:20%;"><select id="itemNameSl'+m+'" onchange="itemVal(this)" class="select2 form-control itemName" name="row['+m+'][ItemId]"><option selected disabled value=""></option>@foreach ($itemSrci as $itemSrci)<option value="{{$itemSrci->id}}">{{$itemSrci->Code}}          ,          {{$itemSrci->Name}}          ,         {{$itemSrci->SKUNumber}}</option>@endforeach</select></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][ItemCode]" placeholder="Item Code" id="ItemCode'+m+'" class="ItemCode form-control" readonly="true"/></td>'+
                    '<td style="width:10%;"><input type="text" name="row['+m+'][UOM]" placeholder="UOM" id="uom'+m+'" class="uom form-control" readonly="true"/></td>'+
                    '<td style="width:10%;"><input type="text" name="row['+m+'][AvQuantity]" id="AvQuantity'+m+'" class="AvQuantity form-control" readonly="true" placeholder="Quantity on hand"/></td>'+
                    '<td class="stockintdcl" style="width:12%"><input type="number" name="row['+m+'][StockIn]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" id="StockIn'+m+'" class="StockIn form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#1cc88a;color:#1cc88a;font-weight:bold"/></td>'+
                    '<td class="unitcosttdcl" style="width:10%;"><input type="number" name="row['+m+'][UnitCost]" id="UnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSI(this)" ondrop="return false;" onpaste="return false;" class="UnitCost form-control numeral-mask" style="font-weight:bold;"/></td>'+
                    '<td class="stockouttdcl" style="width:12%;display:none;"><input type="text" name="row['+m+'][StockOut]" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSO(this)" id="StockOut'+m+'" class="StockOut form-control numeral-mask" ondrop="return false;" onpaste="return false;" style="border-color:#e74a3b;color:#e74a3b;font-weight:bold"/></td>'+
                    '<td class="stockoutcosttdcl" style="width:10%;display:none;"><input type="text" name="row['+m+'][StockOutUnitCost]" id="StockOutUnitCost'+m+'" onkeypress="return ValidateNum(event);" onkeyup="CalculateTotalSO(this)" ondrop="return false;" onpaste="return false;" class="StockOutUnitCost form-control numeral-mask" style="font-weight:bold;"/></td>'+
                    '<td class="stockoutcostbtaxuc" style="width:10%;"><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetactuc'+m+'" class="beforetactuc form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td class="stockoutcostbtax" style="width:10%;display:none;"><input type="number" name="row['+m+'][StockOutBeforeTaxCost]" id="beforetax'+m+'" class="beforetax form-control numeral-mask" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="width:13%;"><select id="Reason'+m+'" onchange="reasonVal(this)" class="select2 form-control Reason" name="row['+m+'][Reason]"></select></td>'+
                    '<td style="width:13%;"><input type="text" name="row['+m+'][Memo]" id="Memo'+m+'" class="Memo form-control"/></td>'+
                    '<td style="width:2%;text-align:center"><button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="issSer(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Adjustment" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireSerialNumber]" id="RequireSerialNumber'+m+'" class="RequireSerialNumber form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireExpireDate]" id="RequireExpireDate'+m+'" class="RequireExpireDate form-control" readonly="true" style="font-weight:bold;"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][insertedqty]" id="insertedqty'+j+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+j+'"/></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][serialnumids]" id="serialnumids'+m+'" class="serialnumids form-control" readonly="true" style="font-weight:bold;" value="0"/></td>'+
                '</tr>');
                var opt = '<option selected disabled value=""></option>';
                var adjreason = $("#adjReason > option").clone();
                $('#Reason'+m).append(adjreason); 
                $("#Reason"+m+" option[title=1]").remove();
                for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        var selectedval=$('#itemNameSl'+k).val();
                        $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                    }
                }
                $('#Reason'+m).append(opt);
                $('#itemNameSl'+m).select2
                ({
                    placeholder: "Select item here",
                });
                $('#Reason'+m).select2
                ({
                    placeholder: "Select reason here",
                });
                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Reason'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            } 
            renumberRows();
            var rnum= $('#commonVal').val();
            $('.common').val(rnum);
        }
    });
    //End append item dynamically

    //Start remove item dynamically
    $(document).on('click', '.remove-tr', function()
    {  
        $(this).parents('tr').remove();
        CalculateGrandTotal();
        renumberRows();
        --i;
        var rownum=$('#numberofItems').val();
        var serid=[];
        for(var i=1;i<=rownum;i++){
            if(typeof $("#serialnumids"+i).val()!=="undefined"){
                serid.push($('#serialnumids'+i).val());
            }
            else if($("#serialnumids"+i).val()!==0||$("#serialnumids"+i).val()!==""||$("#serialnumids"+i).val()!==null){
                serid.push($('#serialnumids'+i).val());
            }
        }
        $("#allserialNumIds").val(serid);
    });
    //End remove item dynamically

    //Start Print Attachment
    $('body').on('click', '.printAdjAttachment', function () 
    {
        var id = $(this).data('id');
        var link=$(this).data('link');
        window.open(link, 'Adj', 'width=1200,height=800,scrollbars=yes');
    });
    //End Print Attachment

    //Start reorder number
    function renumberRows() 
    {
        var ind;
        $('#dynamicTable tr').each(function(index, el)
        {
            $(this).children('td').first().text(index++);
            $('#numberofItems').val(index-1);
            ind=index-1;
            $('#numberofItemsLbl').text(index - 1);
        });
        if (ind == 0) {
            $('.totalrownumber').hide();
        }
        else{
            $('.totalrownumber').show();
        }
    }
    //End reorder table

    function reasonVal(ele){
        var idval = $(ele).closest('tr').find('.idval').val();
        $('#select2-Reason'+idval+'-container').parent().css('background-color',"white");
    }

    //start select item
    function itemVal(ele)
    {
        var stid = $(ele).closest('tr').find('.storeid').val(); 
        var itid = $(ele).closest('tr').find('.itemName').val();
        var idval = $(ele).closest('tr').find('.idval').val();
        var arr = [];
        var found = 0;
        var storeidvar = $('#Store').val();
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
            $(ele).closest('tr').find('.itemName').val("0").trigger('change');
            $(ele).closest('tr').find('.ItemCode').val("");
            $(ele).closest('tr').find('.uom').val("");
            $(ele).closest('tr').find('.ItemType').val("");
            $(ele).closest('tr').find('.RequireSerialNumber').val("");
            $(ele).closest('tr').find('.RequireExpireDate').val("");
            $(ele).closest('tr').find('.Quantity').val("");
            $(ele).closest('tr').find('.StockOutUnitCost').val("");
            $(ele).closest('tr').find('.UnitCost').val("");
            $(ele).closest('tr').find('.AvQuantity').val("");
            $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
        }
        else{
            $.ajax({
                url:'getAdjItemBalance/'+itid,
                type:'DELETE',
                data:formData,
                success:function(data)
                {
                    if(data.sid)
                    {
                        var len=data['sid'].length;
                        for(var i=0;i<=len;i++) 
                        {  
                            var salesqty = (data['salesqnt'][i].TotalSalesQuantity);
                            var quantitys = (data['sid'][i].AvailableQuantity);
                            var totalquantity=parseFloat(quantitys)-parseFloat(salesqty);
                            if (parseFloat(totalquantity) == null||parseFloat(totalquantity)<=0|| isNaN(parseFloat(totalquantity))) {
                                $(ele).closest('tr').find('.AvQuantity').val("0");  
                            }
                            else if (parseFloat(totalquantity)>0) {
                                $(ele).closest('tr').find('.AvQuantity').val(totalquantity);
                            }
                            var partnum=(data['itinfo'][i].PartNumber);
                            var uoms=(data['itinfo'][i].UOM);
                            var code=(data['itinfo'][i].Code);
                            var itemtype=(data['itinfo'][i].Type);
                            var reqsn = (data['itinfo'][i].RequireSerialNumber);
                            var reqed = (data['itinfo'][i].RequireExpireDate);    
                            $(ele).closest('tr').find('.ItemCode').val(code);
                            $(ele).closest('tr').find('.uom').val(uoms);  
                            $(ele).closest('tr').find('.ItemType').val(itemtype);  
                            $(ele).closest('tr').find('.RequireSerialNumber').val(reqsn);
                            $(ele).closest('tr').find('.RequireExpireDate').val(reqed);
                            var lastcost=((parseFloat(data['lastcost'][i].AverageCost)/1.15).toFixed(2));
                            if($("#adjtype").val()==="Quantity")
                            {
                                $(ele).closest('tr').find('.StockOut').val("");
                                $(ele).closest('tr').find('.StockOutUnitCost').val(lastcost);
                                $(ele).closest('tr').find('.UnitCost').val(lastcost); 
                                if(parseFloat(lastcost)>0){
                                    $(ele).closest('tr').find('.StockOutUnitCost').css("background","#efefef");
                                    $(ele).closest('tr').find('.StockOutUnitCost').prop("readonly", true);
                                }
                                else{
                                    $(ele).closest('tr').find('.StockOutUnitCost').val("");
                                    $(ele).closest('tr').find('.StockOutUnitCost').prop("readonly",false);
                                    $(ele).closest('tr').find('.StockOutUnitCost').css("background","white");
                                }    
                                $(ele).closest('tr').find('.beforetax').val("");
                                CalculateGrandTotal();
                            }
                            else if($("#adjtype").val()==="")
                            {
                                $(ele).closest('tr').find('.StockOutUnitCost').val(lastcost);  
                                CalculateGrandTotal();
                            }
                            else if($("#adjtype").val()==="Quantity&Cost")
                            {
                                $(ele).closest('tr').find('.StockIn').val("");  
                                $(ele).closest('tr').find('.UnitCost').val(lastcost); 
                                $(ele).closest('tr').find('.StockOutUnitCost').val(lastcost);
                                if(parseFloat(lastcost)>0){
                                    $(ele).closest('tr').find('.UnitCost').css("background","#efefef");
                                    $(ele).closest('tr').find('.UnitCost').prop("readonly", true);
                                } 
                                else{
                                    $(ele).closest('tr').find('.UnitCost').val("");
                                    $(ele).closest('tr').find('.UnitCost').prop("readonly", false);
                                    $(ele).closest('tr').find('.UnitCost').css("background","white");
                                }   
                                $(ele).closest('tr').find('.beforetactuc').val("");
                                CalculateGrandTotal();
                            }
                            if(reqsn!="Not-Require" || reqed!="Not-Require")
                            {
                                $(ele).closest('tr').find('.addsernum').show();
                            }
                            else if(reqsn=="Not-Require" && reqed=="Not-Require")
                            {
                                $(ele).closest('tr').find('.addsernum').hide();
                            } 
                        }
                    }
                },
            });
            
            $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
        }
    }
    //end select type

    //start close modal function
    function closeModalWithClearValidation()
    {
        $('#Store').select2('destroy');
        $("#Register")[0].reset();
        $('#store-error').html("");
        $('#date-error').html("");
        $('#reason-error').html("");
        $('#type-error').html("");
        $('#Store').val(null).select2();
        var today = new Date();
        var dd = today.getDate();
        var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) :  + (today.getMonth()+1);
        var yyyy = today.getFullYear();
        var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
        $('#date').val(formatedCurrentDate);
        appendTable();
        $("#dynamicTable").show();
        $("#adds").show();
        $("#storediv").show();
        $("#storeEditDiv").hide();
        $("#typeDiv").show();
        $("#typeDivEdit").hide();
        $("#fiscalyrdiv").hide();
        $("#fiscalyrdivedit").hide();
        $('#adjustmentId').val("");
        $('#adjtype').val("");
        $('#adjReason').val("");
        $("#adjReason option[value=Stolen-Goods]").hide();
        $("#adjReason option[value=Damaged-Goods]").hide();
        $("#adjReason option[value=Missing-Goods]").hide();
        $("#adjReason option[value=Internal-Use]").hide();
        $("#adjReason option[value=Gift]").hide();
        $("#adjReason option[value=Found-New-Goods]").hide();
        $("#adjReason option[value=Counting-Error]").hide();
        $("#dynamicTable").empty();
        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th style="display:none;">Item Code</th><th>UOM</th><th>Qty. On Hand</th><th id="stockintr" style="display:none;">Stock In(<i class="fa fa-plus" aria-hidden="true"></i>)</th><th id="stockouttr">Stock Out(<i class="fa fa-minus" aria-hidden="true"></i>)</th><th>Value</th><th>Total Value</th><th>Reason</th><th>Remark</th><th></th>');
        $('.totalrownumber').hide();
    }
    //End close modal function

    function storeval() 
    {
        $('#store-error').html(""); 
    }

    function fiscalYearVal() 
    {
        $('#fiscalyr-error').html(""); 
    }

    function dateVal() 
    {
        $('#date-error').html("");
    }

    function reqReqReasonVal() 
    {
        $('#reason-error').html("");
    }

    function adjTypeVal() 
    {
        var adjustmentType = $('#adjtype').val();
        var opt = '<option selected disabled value=""></option>';
        $('.Reason').empty();
        if(adjustmentType==="Quantity")
        {
            $("#adjReason option[value=Stolen-Goods]").show();
            $("#adjReason option[value=Damaged-Goods]").show();
            $("#adjReason option[value=Missing-Goods]").show();
            $("#adjReason option[value=Internal-Use]").show();
            $("#adjReason option[value=Gift]").show();
            $("#adjReason option[value=Found-New-Goods]").hide();
            $("#adjReason option[value=Counting-Error]").show(); 
            $('.StockIn').css("background","white");
            $('.UnitCost').css("background","white");
            $('.StockOut').css("background","white");
            $('.StockOutUnitCost').css("background","white");
            $('.stockouttdcl').show();
            $('.stockoutcostbtax').show();
            $('.stockoutcosttdcl').show();
            $('#stockouttr').show();
            $('.stockintdcl').hide();
            $('.unitcosttdcl').hide();
            $('.stockoutcostbtaxuc').hide();
            $('#stockintr').hide();
            for(var y=1;y<=m;y++){
                var qtyonhand=($('#AvQuantity'+y)).val()||0;
                var qty=($('#StockOut'+y)).val()||0;
                var stockinqnt=($('#StockIn'+y)).val()||0;
                var stockinuc=($('#UnitCost'+y)).val()||0;
                var stockoutuc=($('#StockOutUnitCost'+y)).val()||0;
                if(parseFloat(qtyonhand)<parseFloat(stockinqnt)|| parseFloat(qtyonhand)==0){
                    $('#StockOut'+y).val("");
                }
                else if(parseFloat(qtyonhand)>=parseFloat(stockinqnt) && parseFloat(stockinqnt)>0){
                    $('#StockOut'+y).val(stockinqnt);
                }
                if(parseFloat(stockinuc)==0||isNaN(parseFloat(stockinuc))){
                    $('#StockOutUnitCost'+y).val("");
                    $('#StockOutUnitCost'+y).prop("readonly",false);
                    $('#StockOutUnitCost'+y).css("background","white");
                }
                else if(parseFloat(stockinuc)>0){
                    $('#StockOutUnitCost'+y).val(stockinuc);
                    $('#StockOutUnitCost'+y).prop("readonly",true);
                    $('#StockOutUnitCost'+y).css("background","#efefef");
                }
                $('#UnitCost'+y).val("");
                $('#StockIn'+y).val("");
                var socl=($('#StockOut'+y)).val()||0;
                var ucl=($('#StockOutUnitCost'+y)).val()||0;
                var totalcl=parseFloat(socl)*parseFloat(ucl);
                $('#beforetax'+y).val(totalcl.toFixed(2));
                var adjreason = $("#adjReason > option").clone();
                $('#Reason'+y).append(adjreason); 
                $("#Reason"+y+" option[title=2]").remove();
                $('#Reason'+y).append(opt);
                $('#Reason'+y).select2
                ({
                    placeholder: "Select reason here",
                });
                $('#select2-Reason'+y+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
            $('.UnitCost').val("");
            $('.UnitCost').prop("readonly",true);
            $('.beforetactuc').val("");
            $('#adjReason').val("");
        }
        else if(adjustmentType==="Quantity&Cost")
        {
            $("#adjReason option[value=Stolen-Goods]").hide();
            $("#adjReason option[value=Damaged-Goods]").hide();
            $("#adjReason option[value=Missing-Goods]").hide();
            $("#adjReason option[value=Internal-Use]").hide();
            $("#adjReason option[value=Gift]").hide();
            $("#adjReason option[value=Found-New-Goods]").show();
            $("#adjReason option[value=Counting-Error]").show();
            //$('.StockOut').val("");
            //$('.StockOutUnitCost').val("");
            $('.StockIn').css("background","white");
            $('.UnitCost').css("background","white");
            $('.StockOut').css("background","white");
            $('.StockOutUnitCost').css("background","white");
            $('.stockouttdcl').hide();
            $('.stockoutcostbtax').hide();
            $('.stockoutcosttdcl').hide();
            $('#stockouttr').hide();
            $('.stockintdcl').show();
            $('.unitcosttdcl').show();
            $('#stockintr').show();
            $('.stockoutcostbtaxuc').show();
            for(var y=1;y<=m;y++){
                var qtyonhand=($('#AvQuantity'+y)).val()||0;
                var qty=($('#StockOut'+y)).val()||0;
                var stockinqnt=($('#StockIn'+y)).val()||0;
                var stockinuc=($('#UnitCost'+y)).val()||0;
                var stockoutuc=($('#StockOutUnitCost'+y)).val()||0;
                if(parseFloat(stockoutuc)==0||isNaN(parseFloat(stockoutuc))){
                    $('#UnitCost'+y).val("");
                    $('#UnitCost'+y).prop("readonly",false);
                    $('#UnitCost'+y).css("background","white");
                }
                else if(parseFloat(stockoutuc)>0){
                    $('#UnitCost'+y).val(stockoutuc);
                    $('#UnitCost'+y).prop("readonly",true);
                    $('#UnitCost'+y).css("background","#efefef");
                }
                if(parseFloat(qty)==0||isNaN(parseFloat(qty))){
                    $('#StockIn'+y).val("");
                }
                else if(parseFloat(qty)>0){
                    $('#StockIn'+y).val(qty);
                }
                var sicl=($('#StockIn'+y)).val()||0;
                var uccl=($('#UnitCost'+y)).val()||0;
                var totalcl=parseFloat(sicl)*parseFloat(uccl);
                $('#beforetactuc'+y).val(totalcl.toFixed(2));
                $('#StockOutUnitCost'+y).val("");
                $('#StockOut'+y).val("");
                var adjreason = $("#adjReason > option").clone();
                $('#Reason'+y).append(adjreason); 
                $("#Reason"+y+" option[title=1]").remove();
                $('#Reason'+y).append(opt);
                $('#Reason'+y).select2
                ({
                    placeholder: "Select reason here",
                });
                $('#select2-Reason'+y+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
            $('.UnitCost').prop("readonly",false);
            $('.StockOutUnitCost').val("");
            $('.beforetax').val("");
            $('#adjReason').val("");
        }
        CalculateGrandTotal();
        //appendTable();
        $('#type-error').html("");
    }
    //end info modal
    
    function appendTable()
    {
        if($("#adjtype").val()==="Quantity")
        {
            $("#dynamicTable").empty();
            $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th style="display:none;">Item Code</th><th>UOM</th><th>Qty. On Hand</th><th id="stockintr" style="display:none;">Stock In(<i class="fa fa-plus" aria-hidden="true"></i>)</th><th id="stockouttr">Stock Out(<i class="fa fa-minus" aria-hidden="true"></i>)</th><th>Value</th><th>Total Value</th><th>Reason</th><th>Remark</th><th></th>');
        }
        else if($("#adjtype").val()==="")
        {
            $("#dynamicTable").empty();
            $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th style="display:none;">Item Code</th><th>UOM</th><th>Qty. On Hand</th><th id="stockintr" style="display:none;">Stock In(<i class="fa fa-plus" aria-hidden="true"></i>)</th><th id="stockouttr">Stock Out(<i class="fa fa-minus" aria-hidden="true"></i>)</th><th>Value</th><th>Total Value</th><th>Reason</th><th>Remark</th><th></th>');
        }
        else if($("#adjtype").val()==="Quantity&Cost")
        {
            $("#dynamicTable").empty();
            $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th style="display:none;">Item Code</th><th>UOM</th><th>Qty. On Hand</th><th id="stockintr">Stock In(<i class="fa fa-plus" aria-hidden="true"></i>)</th><th id="stockouttr" style="display:none;">Stock Out(<i class="fa fa-minus" aria-hidden="true"></i>)</th><th>Value</th><th>Total Value</th><th>Reason</th><th>Remark</th><th></th>');
        }  
    }

    //Add serial no or batch no or expire date
    function addser(ele){
        var itemnames="";
        $(".itemName :selected").each(function() {
            itemnames+=this.text+" , ";
        });
        var quantity = $(ele).closest('tr').find('.StockIn').val();
        var itemid = $(ele).closest('tr').find('.itemName').val();
        var storeid = $(ele).closest('tr').find('.storeid').val();
        var common = $(ele).closest('tr').find('.common').val();
        var reqsnm = $(ele).closest('tr').find('.RequireSerialNumber').val();
        var reqexd = $(ele).closest('tr').find('.RequireExpireDate').val();
        var vals = $(ele).closest('tr').find('.vals').val();
        var inserted = $(ele).closest('tr').find('.insertedqty').val();
        var itemname = $(ele).closest('tr').find('.itemName :selected').text();
        $("#serialnumbertitle").html("Register Serial number , Batch number or Expire date for <b><u>"+itemname+"<u></b>");
        quantity = quantity == '' ? 0 : quantity;
        if(quantity==0){
            toastrMessage('error',"Please insert quantity first","Error");
        }
        else{
            if(reqsnm==="Require"){
                $("#batchnumberdiv").hide();
                $("#quantitydiv").hide();
                $("#serialnumdiv").show();
            }
            if(reqexd==="Require-BatchNumber"){
                $("#batchnumberdiv").show();
                $("#quantitydiv").show();
                $("#expiredatediv").hide();
            }
            if(reqexd==="Require-ExpireDate"){
                $("#batchnumberdiv").hide();
                $("#quantitydiv").hide();
                $("#expiredatediv").show();
            }
            if(reqexd==="Require-Both"){
                $("#batchnumberdiv").show();
                $("#expiredatediv").show();
                $("#quantitydiv").show();
            }
            if(reqexd==="Not-Require"){
                $("#batchnumberdiv").hide();
                $("#quantitydiv").hide();
                $("#expiredatediv").hide();
            }
            if(reqexd==="Not-Require" && reqsnm==="Require"){
                $("#batchnumberdiv").hide();
                $("#quantitydiv").hide();
                $("#expiredatediv").hide();
                $("#serialnumdiv").show();
            }
            if(reqsnm==="Require" && reqexd==="Require-ExpireDate"){
                $("#batchnumberdiv").hide();
                $("#quantitydiv").hide();
                $("#expiredatediv").show();
                $("#serialnumdiv").show();
            }
            if(reqexd==="Require-BatchNumber" && reqsnm==="Require"){
                $("#batchnumberdiv").show();
                $("#quantitydiv").show();
                $("#expiredatediv").hide();
                $("#serialnumdiv").show();
            }
            if(reqexd==="Require-Both" && reqsnm==="Require"){
                $("#batchnumberdiv").show();
                $("#quantitydiv").hide();
                $("#expiredatediv").show();
                $("#serialnumdiv").show();
            }
            if(reqsnm==="Require" && reqexd==="Not-Require"){
                $("#batchnumberdiv").hide();
                $("#quantitydiv").hide();
                $("#expiredatediv").hide();
                $("#serialnumdiv").show();
            }
            if(reqexd==="Require-BatchNumber" && reqsnm==="Not-Require"){
                $("#batchnumberdiv").show();
                $("#quantitydiv").show();
                $("#expiredatediv").hide();
                $("#serialnumdiv").hide();
            }
            if(reqexd==="Require-Both" && reqsnm==="Not-Require"){
                $("#batchnumberdiv").show();
                $("#quantitydiv").show();
                $("#expiredatediv").show();
                $("#serialnumdiv").hide();
            }
            
                $("#serialnumreq").val(reqsnm);
                $("#expirenumreq").val(reqexd);
                $("#tableid").val("");
                $("#seritemid").val(itemid);
                $("#serstoreid").val(storeid);
                $("#storeQuantity").val(quantity);
                $("#commonserval").val(common);
                $("#dynamicrownum").val(vals);
                var remaining=parseFloat(quantity)-parseFloat(inserted);
                $("#totalQuantityLbl").html(quantity);
                $("#insertedQuantityLbl").html(inserted);
                $("#remainingQuantityLbl").html(remaining);
                $("#serialNumberModal").modal('show');
                $("#staticTableDiv").hide();
                $("#dynamicTableDiv").show();
                $("#staticbuttondiv").hide();
                $("#dynamicbuttondiv").show();
            $('#laravel-datatable-crud-sn').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            "order": [[ 0, "desc" ]],
            "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: '/showSerialNmRec/'+common+'/'+itemid,
                type: 'GET',
                },
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'item_id', name: 'item_id','visible': false},
                { data: 'store_id', name: 'store_id','visible': false},  
                { data: 'BrandName', name: 'BrandName'},
                { data: 'ModelName', name: 'ModelName' },
                { data: 'ManufactureDate', name: 'ManufactureDate' },
                { data: 'ExpireDate', name: 'ExpireDate' },
                { data: 'BatchNumber', name: 'BatchNumber' },
                { data: 'SerialNumber', name: 'SerialNumber' },
                { data: 'action', name: 'action' },
            ],
        });
        }
    }
    //End serial no or batch no or expire date

        //Add serial no or batch no or expire date
    function issSer(ele){
        var registerForm = $("#issueserialnumberform");
        var formData = registerForm.serialize();
        var itemnames="";
        $(".itemName :selected").each(function() {
            itemnames+=this.text+" , ";
        });
        var quantity = $(ele).closest('tr').find('.StockOut').val();
        var itemid = $(ele).closest('tr').find('.itemName').val();
        var serids=$(ele).closest('tr').find('.serialnumids').val();
        var storeid = $(ele).closest('tr').find('.storeid').val();
        var common = $(ele).closest('tr').find('.common').val();
        var reqsnm = $(ele).closest('tr').find('.RequireSerialNumber').val();
        var reqexd = $(ele).closest('tr').find('.RequireExpireDate').val();
        var vals = $(ele).closest('tr').find('.vals').val();
        var inserted = $(ele).closest('tr').find('.insertedqty').val();
        var itemname = $(ele).closest('tr').find('.itemName :selected').text();
        $("#serialnumbertitle").html("Select Serial number , Batch number or Expire date for <b><u>"+itemname+"<u></b>");
        quantity = quantity == '' ? 0 : quantity;
        if(quantity==0){
            toastrMessage('error',"Please insert quantity first","Error");
        }
        else if(reqsnm==="Not-Require" && reqexd==="Not-Require"){
            toastrMessage('error',"Batch number, serial number and expire date are not require for this item","Error");
        }
        else{
            $("#SerialNumberIssue").empty();
            $("#listofsernum").val(serids);
            $.ajax({
                url: 'getIssueSerNum/' + itemid+'/'+storeid+'/'+serids,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['serialNumbers'].length;
                    for (var i = 0; i <= len; i++) {
                        var name = data['serialNumbers'][i].AllValues;
                        var id = data['serialNumbers'][i].id;
                        var option = "<option value='" + id + "'>" + name + "</option>";
                        $("#SerialNumberIssue").append(option);
                    }
                },
            });
            $.ajax({
                url: 'getIssueSerNumSl/' + itemid+'/'+storeid+'/'+serids,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    var len = data['serialNumbersSl'].length;
                    for (var i = 0; i <= len; i++) {
                        var name = data['serialNumbersSl'][i].AllValues;
                        var id = data['serialNumbersSl'][i].id;
                        var option = "<option selected value='" + id + "'>" + name + "</option>";
                        $("#SerialNumberIssue").append(option);
                    }
                },
            });
            $("#rownumval").val(vals);
            $("#SerialNumberIssue").select2({
                maximumSelectionLength:quantity
            });
            $("#issueserialnumodal").modal('show');
        }
    }
    //End serial no or batch no or expire date

    $('#brand').on('change', function () 
    {
        var sid = $('#brand').val();
        $('#modelNumber').find('option').not(':first').remove();
        var registerForm = $("#serialNumberRegForm");
        var formData = registerForm.serialize();
        $.ajax({
            url:'showModelsRec/'+sid,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.model)
                {
                    var len=data['model'].length;
                    for(var i=0;i<=len;i++)
                    {
                        var name=data['model'][i].Name;
                        var option = "<option value='"+name+"'>"+name+"</option>";
                        $("#modelNumber").append(option);
                        $('#modelNumber').selectpicker('refresh');
                    }
                }
            },
        });
    });

    function batchQuantityVal() 
    {
        var remainingqnt=$('#remainingQuantityLbl').text();
        var quantityvals=$('#Quantity').val();
        if(parseFloat(quantityvals)==0){
            $('#Quantity').val("");
        }
        if(parseFloat(remainingqnt)<parseFloat(quantityvals)){
            $('#Quantity').val("");
            toastrMessage('error',"Inserted quantity is greater than remaining quantity","Error");
        }
        $('#quantitybatch-error').html("");
    }

    $('#saveSerialNum').click(function()
    {
        var registerForm = $('#serialNumberRegForm');
        var formData = registerForm.serialize();
        $.ajax({
           url:'/addSerialnumbersAdj',
            type:'POST',
            data:formData,
            beforeSend:function(){$('#saveSerialNum').text('Adding...');
            $('#saveSerialNum').prop( "disabled", true );
            },
            success:function(data) {
                if(data.errors) 
                {
                    if(data.errors.ExpireDate){
                        $('#expiredate-error').html( data.errors.ExpireDate[0] );
                    }
                    if(data.errors.SerialNumber){
                        $('#serialnum-error').html( data.errors.SerialNumber[0] );
                    }
                    if(data.errors.brand){
                        $('#brand-error').html( data.errors.brand[0] );
                    }
                    if(data.errors.modelNumber){
                        $('#model-error').html( data.errors.modelNumber[0] );
                    }
                    if(data.errors.ManufactureDate){
                        $('#manfdate-error').html( data.errors.ManufactureDate[0] );
                    }
                    if(data.errors.BatchNumber){
                        $('#batchnum-error').html( data.errors.BatchNumber[0] );
                    }
                    if(data.errors.Quantity){
                        $('#quantitybatch-error').html( data.errors.Quantity[0] );
                    }
                    $('#saveSerialNum').text('Add');
                    $('#saveSerialNum').prop( "disabled", false );
                    toastrMessage('error',"Check your inputs","Error");
                }
                if(data.valerror)
                {
                    $('#saveSerialNum').text('Add');
                    $('#saveSerialNum').prop( "disabled", false );
                    toastrMessage('error',"You inserted for all quantity");
                }
                if(data.qnterror)
                {
                    $('#saveSerialNum').text('Add');
                    $('#saveSerialNum').prop( "disabled", false );
                    toastrMessage('error',"The remaining quantity is not the same with inserted quantity","Error");
                }
                if(data.success) 
                {    
                    $('#saveSerialNum').text('Add');
                    $('#saveSerialNum').prop("disabled", false );
                    toastrMessage('success',"Successful","Success");
                    $('#insertedQuantityLbl').text(data.Totalcount);
                    var inserted=data.Totalcount;
                    var dval=$('#dynamicrownum').val();
                    var totalcnt=$('#totalQuantityLbl').text();
                    var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                    $('#remainingQuantityLbl').text(netQ);
                    $('#insertedqty'+dval).val(inserted);
                    $('#SerialNumber').val("");
                    $('#tableid').val("");
                    var iTable = $('#laravel-datatable-crud-sn').dataTable(); 
                    iTable.fnDraw(false);
                    var oTable = $('#doneinfodetail').dataTable(); 
                    oTable.fnDraw(false);
                    clearSn();
                    $('#modelNumber').empty();
                }
            },
        });
    });

    $('body').on('click', '#serialnumissuebtn', function() {
        var registerForm = $("#issueserialnumberform");
        var formData = registerForm.serialize();
        var serval=$("#SerialNumberIssue").val();
        var serialnumids=$("#listofsernum").val();
        var sernum=$("#serialnumids").val();
        var rownum=$('#numberofItems').val();
        var rid="";
        var serid=[];
        if(serval===""||serval==null){
            toastrMessage('error',"Please select serial number or batch number","Error");
        }
        else{
            var count = $("#SerialNumberIssue :selected").length;
            rid=$("#rownumval").val();
            $("#insertedqty"+rid).val(count);
            $("#serialnumids"+rid).val(serval);
            $("#issueserialnumodal").modal('hide');
            for(var i=1;i<=rownum;i++){
                if(typeof $("#serialnumids"+i).val()!=="undefined"){
                    serid.push($('#serialnumids'+i).val());
                }
                else if($("#serialnumids"+i).val()!==0||$("#serialnumids"+i).val()!==""||$("#serialnumids"+i).val()!==null){
                    serid.push($('#serialnumids'+i).val());
                }
            }
            $("#allserialNumIds").val(serid);
        } 
    });

    function closeSn()
    {
        $('#brand').val(null).trigger('change');
        $('#modelNumber').empty();
        $("#serialNumberRegForm")[0].reset();
        $('#ManufactureDate').val("");
        $('#tableid').val("");
        $('#ExpireDate').val("");
        $('#BatchNumber').val("");
        $('#brand-error').html("");
        $('#model-error').html("");
        $('#expiredate-error').html("");
        $('#serialnum-error').html("");
        $('#manfdate-error').html("");
        $('#batchnum-error' ).html("");
        $('#saveSerialNum').text("Add");
        $('#saveSerialNum').prop( "disabled", false );
        $('#closeSerialNum').hide();
    }

    function clearSn()
    {
        $('#brand').val(null).trigger('change');
        $('#brand').selectpicker('refresh');
        $('#modelNumber').empty();
        $('#modelNumber').selectpicker('refresh');
        $('#ManufactureDate').val("");
        $('#SerialNumber').val("");
        $('#Quantity').val("1");
        $('#tableid').val("");
        $('#brand-error').html("");
        $('#model-error').html("");
        $('#expiredate-error').html("");
        $('#serialnum-error').html("");
        $('#manfdate-error').html("");
        $('#batchnum-error' ).html("");
        $('#saveSerialNum').text("Add");
        $('#saveSerialNum').prop( "disabled", false );
        $('#closeSerialNum').hide();
    }

    //start edit serial number modal
    $('body').on('click', '.editSN', function () 
    {
        var recIdVar = $(this).data('id');
        var mod = $(this).data('mod');
        $('#modelNumber').empty();
        var options = "<option selected value="+mod+">"+mod+"</option>";
        $('#modelNumber').append(options);
        $.get("/serialnumbereditRec" +'/' + recIdVar , function (data)
        {
            $('#tableid').val(recIdVar);
            $('#brand').selectpicker('val',data.recData.brand_id).trigger('change');
            $('#ManufactureDate').val(data.recData.ManufactureDate);
            $('#ExpireDate').val(data.recData.ExpireDate);
            $('#BatchNumber').val(data.recData.BatchNumber);
            $('#SerialNumber').val(data.recData.SerialNumber);
        });
        $('#saveSerialNum').text("Update");
        $('#saveSerialNum').prop( "disabled", false );
        $('#closeSerialNum').show();
        $('#serialNumberModal').animate({scrollTop: 0},'slow');
    });
    //end edit serial number modal

    $('#sernumDeleteModal').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var totalqnt=$('#totalQuantityLbl').text();
        $('#dynamicdelval').val($('#dynamicrownum').val());
        $('#totalBegQuantity').val(totalqnt);
        var id=button.data('id');
        var modal=$(this);
        modal.find('.modal-body #sid').val(id);
    });

        //Delete Records Starts
    $('#deleteSerialNumberBtn').click(function()
    {
        var deleteForm = $("#deleteserialnumform");
        var formData = deleteForm.serialize();
        var sid=$('#sid').val();
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/serialdeleteRec/'+sid,
            type:'DELETE',
            data:'',
            beforeSend:function(){
            $('#deleteSerialNumberBtn').text('Deleting...');},
            success:function(data)
            {
                $('#deleteSerialNumberBtn').text('Delete');
                toastrMessage('success',"Removed","Success");
                $('#sernumDeleteModal').modal('hide');
                $('#insertedQuantityLbl').text(data.Totalcount);
                var dval=$('#dynamicdelval').val();
                var inserted=data.Totalcount;
                var totalcnt=$('#totalBegQuantity').val();
                var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                $('#remainingQuantityLbl').text(netQ);
                $('#insertedqty'+dval).val(inserted);
                var oTable = $('#doneinfodetail').dataTable(); 
                oTable.fnDraw(false);
                var iTable = $('#laravel-datatable-crud-sn').dataTable(); 
                iTable.fnDraw(false);
            }
        });
    });
    //Delete Records Ends

    function serialNumberVal() 
    {
        $( '#serialnum-error' ).html("");
    }
    function batchNumberVal() 
    {
        $( '#batchnum-error' ).html("");
    }
    function expireDateVal() 
    {
        $( '#expiredate-error' ).html("");
    }
    function modelNumberVal() 
    {
        $( '#model-error' ).html("");
    }
    function brandVal() 
    {
        $( '#brand-error' ).html("");
    }
    function mfgDateVal() 
    {
        $('#manfdate-error').html("");
    }
    function serialnumberVal()
    {
        $( '#serialnumbers-error').html("");
    }

    $(function () {
        cardSection = $('#page-block');
    });

    $('#fiscalyear').on('change', function() {
        var fy="0";
        var fyear = $('#fiscalyear').val();
        if(fyear.length==0){
            fy="0";
        }
        else{
            fy=fyear;
        }
        $('#laravel-datatable-crud').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            "order": [
                [0, "desc"]
            ],
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
            "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/adjustmentdatafy/'+fy,
                type: 'DELETE',
                dataType: "json",
                statusCode: {
                    401: function() {
                        toastrMessage('error',"Session Expired!","Error");
                        location.reload(false);
                    }
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
                
            },
            columns: [
                { data: 'id', name: 'id' , 'visible': false },
                { data:'DT_RowIndex'},
                { data: 'DocumentNumber', name: 'DocumentNumber' },
                { data: 'Type', name: 'Type' },
                { data: 'Reason', name: 'Reason' , 'visible': false},
                { data: 'Store', name: 'Store' },
                { data: 'AdjustedBy', name: 'AdjustedBy' },
                { data: 'FiscalYear', name: 'FiscalYear' , 'visible': false},  
                { data: 'AdjustedDate', name: 'AdjustedDate' },
                { data: 'Status', name: 'Status' },
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.Status == "Pending") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#f6c23e",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #f6c23e"
                    });
                } else if (aData.Status == "Checked") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#4e73df",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #4e73df"
                    });
                } else if (aData.Status == "Confirmed") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#1cc88a",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #1cc88a"
                    });
                } else if (aData.Status == "Void"||aData.Status == "Void(Pending)"||aData.Status == "Void(Checked)"||aData.Status == "Void(Confirmed)") {
                    $(nRow).find('td:eq(6)').css({
                        "color": "#e74a3b",
                        "font-weight": "bold",
                        "text-shadow": "1px 1px 10px #e74a3b"
                    });
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: $('.header-navbar').outerHeight(),
            },
        });
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
    });

    //Start change to checked
    $('body').on('click', '#checkedbtn', function() {
        var recordId = $('#checkedid').val();
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                if (st === "Confirmed") {
                    toastrMessage('error',"Adjustment already confirmed","Error");
                    $("#adjustmentcheckmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Void") {
                    toastrMessage('error',"Adjustment already voided","Error");
                    $("#adjustmentcheckmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Checked") {
                    toastrMessage('error',"Adjustment already checked","Error");
                    $("#adjustmentcheckmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Pending") {
                    var registerForm = $("#checkreceivingform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/checkStatusAdj',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#checkedbtn').text('Checking...');
                            $('#checkedbtn').prop("disabled", true);
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
                                    singleVal=(data['countItems'][i].ItemName);
                                    loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                    $('#checkedbtn').text('Check Adjustment');
                                    $('#checkedbtn').prop( "disabled", false );
                                    toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+"  Items"+loopedVal,"Error");
                                    $("#adjustmentcheckmodal").modal('hide');
                                }    
                            }
                            if (data.success) {
                                $('#checkedbtn').text('Check Adjustment');
                                toastrMessage('success',"Adjustment checked","Success");
                                $("#changetopending").show();
                                $("#confirmadjustment").show();
                                $("#checkadjustment").hide();
                                var today = new Date();
                                var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
                                var un=$("#usernamelbl").val();
                                $("#infocheckedby").html(un);
                                $("#infocheckeddate").html(currentdate);
                                $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>Checked</span>");
                                $("#adjustmentcheckmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
            }
        });
    });
    //End change to checked

    //Start change to confirm
    $('body').on('click', '#confirmbtn', function() {
        $('#confirmbtn').prop("disabled", true);
        var recordId = $('#confirmid').val();
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                if (st === "Confirmed") {
                    toastrMessage('error',"Adjustment already confirmed","Error");
                    $("#adjustmentconfirmedmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Void") {
                    toastrMessage('error',"Adjustment already voided","Error");
                    $("#adjustmentconfirmedmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Pending") {
                    toastrMessage('error',"Adjustment is in pending","Error");
                    $("#adjustmentconfirmedmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }else if (st === "Checked") {
                    $('#confirmbtn').prop("disabled", true);
                    var registerForm = $("#confirmedreceivingform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/confirmStatusAdj',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#confirmbtn').text('Confirming...');
                            $('#confirmbtn').prop("disabled", true);
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
                                    singleVal=(data['countItems'][i].ItemName);
                                    loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                    $('#confirmbtn').text('Confirm Adjustment');
                                    $('#confirmbtn').prop( "disabled", false );
                                    toastrMessage('error',"There is no available quantity for "+count+"  Items"+loopedVal,"Error");
                                    $("#adjustmentconfirmedmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }    
                            }
                            if (data.success) {
                                $('#confirmbtn').text('Confirm Adjustment');
                                toastrMessage('success',"Adjustment confirmed","Success");
                                $("#adjustmentconfirmedmodal").modal('hide');
                                $("#adjInfoModal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
            }
        });
    });
    //End change to confirm

    //Start change to pending
    $('body').on('click', '#pendingbtn', function() {
        var recordId = $('#pendingid').val();
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                if (st === "Confirmed") {
                    toastrMessage('error',"Adjustment already confirmed","Error");
                    $("#adjustmentpendingmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Void") {
                    toastrMessage('error',"Adjustment already voided","Error");
                    $("#adjustmentpendingmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Pending") {
                    toastrMessage('error',"Adjustment is on pending status","Error");
                    $("#adjustmentpendingmodal").modal('hide');
                    $("#adjInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                } else if (st === "Checked") {
                    var registerForm = $("#pendingreceivingform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/pendingStatusAdj',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#pendingbtn').text('Changing...');
                            $('#pendingbtn').prop("disabled", true);
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
                            if (data.success) {
                                $('#pendingbtn').text('Change to Pending');
                                toastrMessage('success',"Adjustment is changed to pending","Success");
                                $("#changetopending").hide();
                                $("#confirmadjustment").hide();
                                $("#checkadjustment").show();
                                var today = new Date();
                                var currentdate=moment(today,"YYYY-MM-DD").format('YYYY-MM-DD');
                                var un=$("#usernamelbl").val();
                                $("#infochangetopeding").html(un);
                                $("#infochangetopendingdate").html(currentdate);
                                $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>Pending</span>");
                                $("#adjustmentpendingmodal").modal('hide');
                                //$("#docInfoModal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        },
                    });
                }
            }
        });
    });
    //End change to pending

    //Start Void Modal With Value 
    // $('#voidreasonmodal').on('show.bs.modal', function(event) {
    //     var button = $(event.relatedTarget);
    //     var id = button.data('id');
    //     var statusval = button.data('status');
    //     var modal = $(this);
    //     modal.find('.modal-body #voidid').val(id);
    //     modal.find('.modal-body #vstatus').val(statusval);
    //     $('#voidbtn').prop("disabled",false);
    //     $('#voidbtn').text("Void");
    // });
    //End Void Modal With Value 

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
    //     $('#undovoidbtn').prop("disabled",false);
    //     $('#undovoidbtn').text("Undo Void");
    // });
    //End undo void Modal With Value 

    $('body').on('click', '.undovoidlnbtn', function() {
        var recordId = $(this).data('id');
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            var statusolds="";
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                var fiscalyearadj=data.adjHeader[i].fiscalyear;
                var fiscalyearcurrent=data.fyear;
                var fyearstrs=data.fyearstr;
                statusolds=data.adjHeader[i].StatusOld;

                if(parseFloat(fiscalyearadj)!=parseFloat(fyearstrs)){
                    toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
                else if (st != "Void") {
                    toastrMessage('error',"Adjustment should be void","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
                else{
                    $("#undovoidid").val(recordId);
                    $('#ustatus').val(st);
                    $('#oldstatus').val(statusolds);
                    $('#undovoidbtn').prop("disabled", false);
                    $('#undovoidbtn').text("Undo Void");
                    $("#undovoidmodal").modal('show');
                }
            }
        });
    });

    $('body').on('click', '.voidlnbtn', function() {
        var recordId = $(this).data('id');
        $('.Reason').val("");
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                var fiscalyearadj=data.adjHeader[i].fiscalyear;
                var fiscalyearcurrent=data.fyear;
                var fyearstrs=data.fyearstr;
                if(parseFloat(fiscalyearadj)!=parseFloat(fyearstrs)){
                    toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
                else if(st==="Pending"||st==="Checked"||st==="Confirmed"){
                    $("#voidid").val(recordId);
                    $('#vstatus').val(st);
                    $('#voidbtn').prop("disabled", false);
                    $('#voidbtn').text("Void");
                    $("#voidreasonmodal").modal('show');
                }
                else{
                    toastrMessage('error',"You cant void on these status","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            }
        });
    });

    //Start void
    $('body').on('click', '#voidbtn', function() {
        var recordId = $('#voidid').val();
        var fiscalyearadj="";
        var fiscalyearcurrent="";
        var fyearstrs="";
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                fiscalyearadj=data.adjHeader[i].fiscalyear;
                fiscalyearcurrent=data.fyear;
                fyearstrs=data.fyearstr;
                if (st === "Void") {
                    toastrMessage('error',"Adjustment already voided","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                    $("#voidreasonform")[0].reset();
                } 
                else if(parseFloat(fiscalyearadj)!=parseFloat(fyearstrs)){
                    toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                    $("#voidreasonmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                    $("#voidreasonform")[0].reset();
                }
                else if (st === "Confirmed") {
                    var registerForm = $("#voidreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/voidAdjustment',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#voidbtn').text('Voiding...');
                            $('#voidbtn').prop("disabled", true);
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
                            if (data.valerror) {
                                var singleVal = '';
                                var loopedVal = '';
                                var len = data['valerror'].length;
                                for (var i = 0; i <= len; i++) {
                                    var count = data.countedval;
                                    var inc = i + 1;
                                    singleVal = (data['countItems'][i].Name);
                                    loopedVal = loopedVal + "</br>" + inc + " ) " + singleVal;
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop("disabled", false);
                                    toastrMessage('error',"You cant void " + count +" Item(s) it is issued" + loopedVal,"Error");
                                    $("#voidreasonmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#voidreasonform")[0].reset();
                                }
                            }
                            if (data.errors) {
                                if (data.errors.Reason) {
                                    $('#void-error').html(data.errors.Reason[0]);
                                }
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.success) {
                                $('#voidbtn').text('Void');
                                toastrMessage('success',"Adjustment voided","Success");
                                $("#voidreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                                $("#voidreasonform")[0].reset();
                            }
                        },
                    });
                } else {
                    var registerForm = $("#voidreasonform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/voidAdj',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#voidbtn').text('Voiding...');
                            $('#voidbtn').prop("disabled", true);
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
                            if (data.errors) {
                                if (data.errors.Reason) {
                                    $('#void-error').html(data.errors.Reason[0]);
                                }
                                $('#voidbtn').text('Void');
                                $('#voidbtn').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.success) {
                                $('#voidbtn').text('Void');
                                toastrMessage('success',"Adjustment voided","Success");
                                $("#voidreasonmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                                $("#voidreasonform")[0].reset();
                            }
                        },
                    });
                }
            }
        });
    });
    //End void

    //Start undo void
    $('body').on('click', '#undovoidbtn', function() {
        $('#undovoidbtn').prop("disabled", true);
        var statusVal = $("#ustatus").val();
        var oldstatusVal = $("#oldstatus").val();
        var recordId = $('#undovoidid').val();
        $.get("/showRecDataAdj" + '/' + recordId, function(data) {
            var dc = data;
            var len = data.adjHeader.length;
            for (var i = 0; i <= len; i++) {
                var st = data.adjHeader[i].Status;
                var stold = data.adjHeader[i].StatusOld;
                var fyearadj = data.adjHeader[i].fiscalyear;
                var fyearstrs = data.fyearstr;
                if(parseFloat(fyearadj)!=parseFloat(fyearstrs)){
                    toastrMessage('error',"You cant undo void a closed fiscal year transaction","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                    $("#undovoidform")[0].reset();
                }
                else if (st == "Void" && stold == "Confirmed") {
                    var registerForm = $("#undovoidform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/undoAdjVoid',
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
                            if (data.valerror) {
                                var singleVal = '';
                                var loopedVal = '';
                                var len = data['valerror'].length;
                                for (var i = 0; i <= len; i++) {
                                    var count = data.countedval;
                                    var inc = i + 1;
                                    singleVal = (data['countItems'][i].ItemName);
                                    loopedVal = loopedVal + "</br>" + inc + " ) " + singleVal;
                                    $('#undovoidbtn').text('Undo Void');
                                    $('#undovoidbtn').prop("disabled", false);
                                    toastrMessage('error',"You cant undo void " + count +" Item(s)" + loopedVal,"Error");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#undovoidform")[0].reset();
                                }
                            }
                            if (data.success) {
                                $('#undovoidbtn').text('Undo Void');
                                toastrMessage('success',"Undo void successful","Success");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                                $("#undovoidform")[0].reset();
                            }
                        },
                    });
                } else if (st == "Void" && stold != "Confirmed") {
                    var registerForm = $("#undovoidform");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: '/undoPenVoid',
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
                            if(data.undoerror)
                            {
                                $('#undovoidbtn').text('Undo Void');
                                toastrMessage('error',"This doc/fs number is taken by another transaction","Error");
                                $("#undovoidmodal").modal('hide');
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                                $("#undovoidform")[0].reset();
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
                } else if (st != "Void") {
                    toastrMessage('error',"Adjustment should be void","Error");
                    $("#undovoidmodal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                    $("#undovoidform")[0].reset();
                }
            }
        });
    });
    //End undo void

    function getCheckInfoConf() {
        var stid = $('#adjustmentidsval').val();
        $('#checkedid').val(stid);
        $('#adjustmentcheckmodal').modal('show');
        $('#checkedbtn').text("Check Adjustment");
        $('#checkedbtn').prop("disabled", false);
    }

    function getPendingInfoConf() {
        var stid = $('#adjustmentidsval').val();
        $('#pendingid').val(stid);
        $('#adjustmentpendingmodal').modal('show');
        $('#pendingbtn').text("Change to Pending");
        $('#pendingbtn').prop("disabled", false);
    }

    function getConfirmInfoConf() {
        var stid = $('#adjustmentidsval').val();
        $('#confirmid').val(stid);
        $('#adjustmentconfirmedmodal').modal('show');
        $('#confirmbtn').text("Confirm Adjustment");
        $('#confirmbtn').prop("disabled",false);
    }

    function voidReason() {
        $('#void-error').html("");
    }

    //start quantity check
    function checkQ(ele) 
    {
        var incamount = $(ele).closest('tr').find('.StockIn').val();
        var availableq = $(ele).closest('tr').find('.AvQuantity').val();
        var quantity = $(ele).closest('tr').find('.StockOut').val();
        if(parseFloat(incamount)==0||parseFloat(quantity)==0){
            $(ele).closest('tr').find('.StockOut').val("");
            $(ele).closest('tr').find('.StockIn').val("");
        }
        if(parseFloat(quantity)>parseFloat(availableq))
        {
            toastrMessage('error',"This amount of quantity cannot be decreased","Error");
            $(ele).closest('tr').find('.StockOut').val("");
            $(ele).closest('tr').find('.StockIn').val("");
        }
        $(ele).closest('tr').find('.insertedqty').val(quantity);
        $(ele).closest('tr').find('.StockIn').val("");
        $(ele).closest('tr').find('.StockIn').css("background","white");
        $(ele).closest('tr').find('.StockOut').css("background","white");
    }
    //end quantity check

    function valcosts(ele){
        $(ele).closest('tr').find('.UnitCost').css("background","white");
        $(ele).closest('tr').find('.StockOutUnitCost').css("background","white");
    }

    //start quantity check
    function compareQuantity(ele) 
    {
        $(ele).closest('tr').find('.StockOut').val("");
        var qnt=$(ele).closest('tr').find('.StockIn').val();
        var reqexd=$(ele).closest('tr').find('.RequireExpireDate').val();
        var reqsnm=$(ele).closest('tr').find('.RequireSerialNumber').val();
        if(reqexd==="Not-Require" && reqsnm==="Not-Require"){
            $(ele).closest('tr').find('.insertedqty').val(qnt);
        } 
        $(ele).closest('tr').find('.StockIn').css("background","white");
    }
    //end quantity check

    function CalculateTotalSO(ele) {
        var cid=$(ele).closest('tr').find('.idval').val();
        var incamount = $(ele).closest('tr').find('.StockIn').val();
        var availableq = $(ele).closest('tr').find('.AvQuantity').val()||0;
        var unitcost = $(ele).closest('tr').find('.StockOutUnitCost').val();
        var quantity = $(ele).closest('tr').find('.StockOut').val();
        unitcost = unitcost == '' ? 0 : unitcost;
        quantity = quantity == '' ? 0 : quantity;
        var inputid = ele.getAttribute('id');
        if (!isNaN(unitcost) && !isNaN(quantity)) {
            if(inputid==="StockOutUnitCost"+cid){
                $(ele).closest('tr').find('.UnitCost').css("background","white");
                $(ele).closest('tr').find('.StockOutUnitCost').css("background","white");
            }
            if(inputid==="StockOut"+cid){
                if(parseFloat(incamount)==0||parseFloat(quantity)==0){
                    $(ele).closest('tr').find('.StockOut').val("");
                    $(ele).closest('tr').find('.StockIn').val("");
                }
                if(parseFloat(quantity)>parseFloat(availableq))
                {
                    toastrMessage('error',"Cannot deacrease this amount of quantity","Error");
                    $(ele).closest('tr').find('.StockOut').val("");
                    $(ele).closest('tr').find('.StockIn').val("");
                    $(ele).closest('tr').find('.StockOut').val("");
                    quantity=0;
                }
                $(ele).closest('tr').find('.insertedqty').val(quantity);
                $(ele).closest('tr').find('.StockIn').val("");
                $(ele).closest('tr').find('.StockIn').css("background","white");
                $(ele).closest('tr').find('.StockOut').css("background","white");
            }
            if(parseFloat(total)>0){
                $(ele).closest('tr').find('.beforetax').css("background","#efefef");
            }
            var total = parseFloat(unitcost) * parseFloat(quantity);
            $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
        }
        CalculateGrandTotal();
    }

    function CalculateTotalSI(ele) {
        var cid=$(ele).closest('tr').find('.idval').val();
        var incamount = $(ele).closest('tr').find('.StockOut').val();
        var availableq = $(ele).closest('tr').find('.AvQuantity').val();
        var sounitcost = $(ele).closest('tr').find('.StockOutUnitCost').val();
        var unitcost = $(ele).closest('tr').find('.UnitCost').val();
        var quantity = $(ele).closest('tr').find('.StockIn').val();
        unitcost = unitcost == '' ? 0 : unitcost;
        quantity = quantity == '' ? 0 : quantity;
        var inputid = ele.getAttribute('id');
        if (!isNaN(unitcost) && !isNaN(quantity)) {
            if(inputid==="UnitCost"+cid){
                $(ele).closest('tr').find('.UnitCost').css("background","white");
                $(ele).closest('tr').find('.StockOutUnitCost').css("background","white");
            }
            if(inputid==="StockIn"+cid){
                $(ele).closest('tr').find('.StockOut').val("");
                var qnt=$(ele).closest('tr').find('.StockIn').val();
                var reqexd=$(ele).closest('tr').find('.RequireExpireDate').val();
                var reqsnm=$(ele).closest('tr').find('.RequireSerialNumber').val();
                if(reqexd==="Not-Require" && reqsnm==="Not-Require"){
                    $(ele).closest('tr').find('.insertedqty').val(qnt);
                } 
                $(ele).closest('tr').find('.StockIn').css("background","white");
            }
            if(parseFloat(total)>0){
                $(ele).closest('tr').find('.beforetactuc').css("background","#efefef");
            }
            var total = parseFloat(unitcost) * parseFloat(quantity);
            $(ele).closest('tr').find('.beforetactuc').val(total.toFixed(2));
        }
        CalculateGrandTotal();
    }

    function CalculateGrandTotal() {
        var stockintotal = 0;
        var stockouttotal = 0;
        $.each($('#dynamicTable').find('.beforetactuc'), function() {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                stockintotal += parseFloat($(this).val());
            }
        });
        $.each($('#dynamicTable').find('.beforetax'), function() {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                stockouttotal += parseFloat($(this).val());
            }
        });
        var eitheroftotal=parseFloat(stockintotal)+parseFloat(stockouttotal);
        $('#totalvaluelbl').html(numformat(eitheroftotal.toFixed(2)));
        $('#totalvalues').val(eitheroftotal.toFixed(2));
    }

    function numformat(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
            val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
    }

    function closeInfoModal() 
    {
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
    }
</script>   
@endsection
