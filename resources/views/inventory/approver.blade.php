@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div style="width:19%;">
                                <h3 class="card-title">Approver</h3>
                                <label strong style="font-size: 10px;"></label>
                                <div class="form-group">
                                    <label strong style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                    <div>
                                        <select class="select2 form-control" data-style="btn btn-outline-secondary waves-effect" name="fiscalyear[]" id="fiscalyear" data-actions-box="true" data-selected-text-format="count" data-count-selected-text="Fiscal Year ({0})">
                                        @foreach ($fiscalyears as $fiscalyears)
                                            <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <ul class="nav nav-tabs justify-content-end" role="tablist" style="margin-top:-80px;">
                                @can('Approver-Transfer-View')
                                <li class="nav-item">
                                    <a class="nav-link active" id="Transfer-tab" data-toggle="tab" href="#transfer" aria-controls="transfer" role="tab" aria-selected="false">Transfer List</a>
                                </li>
                                @endcan
                                @can('Approver-Requisition-View')
                                <li class="nav-item">
                                    <a class="nav-link" id="Requisition-tab" data-toggle="tab" href="#requisition" aria-controls="requisition" role="tab" aria-selected="true">Requisition List</a>                                
                                </li>
                               @endcan
                            </ul>
                            <div style="text-align: right;">
                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i data-feather='refresh-ccw'></i></button>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                @can('Approver-Transfer-View')
                                <div class="tab-pane active" id="transfer" aria-labelledby="transfer" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="laravel-datatable-crud-tr" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>#</th>
                                                        <th>Document No.</th>
                                                        <th>Type</th>
                                                        <th>Source Store/Shop</th>
                                                        <th>Destination Store/Shop</th>
                                                        <th>Date</th>
                                                        <th>Requested By</th> 
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
                                @can('Approver-Requisition-View')
                                <div class="tab-pane" id="requisition" aria-labelledby="requisition" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>id</th>
                                                        <th>#</th>
                                                        <th>Document No.</th>
                                                        <th>Type</th>
                                                        <th>Source Store/Shop</th>
                                                        <th>Destination Store/Shop</th>
                                                        <th>Date</th>
                                                        <th>Requested By</th> 
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>
     </div>

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

<!--Start Info Modal -->
<div class="modal fade text-left" id="reqInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Store Requisition Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                    <input type="hidden" placeholder="" class="form-control" name="reqId" id="reqId" readonly="true">
                                    <input type="hidden" placeholder="" class="form-control" name="statusi" id="statusi" readonly="true">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Requisition Basic & Others Information</span>
                                                        <div id="statustitlesreq"></div>
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
                                                                                    <td><label strong style="font-size: 14px;">Document Number</label></td>
                                                                                    <td><label id="infodocnum" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Source Store/Shop</label></td>
                                                                                    <td><label id="infosourcestore" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 14px;">Reason</label></td>
                                                                                    <td><label id="infopurpose" strong style="font-size: 14px;font-weight:bold;"></label></td>
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
                                                                                            <td><label strong style="font-size: 14px;">Prepared By</label></td>
                                                                                            <td><label id="infopreparedby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Prepared Date</label></td>
                                                                                            <td><label id="infodate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Requested By</label></td>
                                                                                            <td><label id="inforequestby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Approved By</label></td>
                                                                                            <td><label id="infoapprovedby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Approved Date</label></td>
                                                                                            <td><label id="infoapproveddate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Issued By</label></td>
                                                                                            <td><label id="infoissuedby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Issued Date</label></td>
                                                                                            <td><label id="infoissueddate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Void By</label></td>
                                                                                            <td><label id="infovoidby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Void Date</label></td>
                                                                                            <td><label id="infovoiddate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Comment By</label></td>
                                                                                            <td><label id="infocommentby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Comment</label></td>
                                                                                            <td><label id="infocomment" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Comment Date</label></td>
                                                                                            <td><label id="infocommentdate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Rejected By</label></td>
                                                                                            <td><label id="inforejectby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label strong style="font-size: 14px;">Rejected Date</label></td>
                                                                                            <td><label id="inforejectdate" strong style="font-size: 14px;font-weight:bold;"></label></td>
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
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <table id="reqinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                        <thead>
                                            <th>#</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>SKU Number</th>
                                            <th>Part Number</th>
                                            <th>UOM</th>
                                            <th>Quantity</th>
                                            <th>Memo</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Approver-Requisition-Approve')
                    <button id="approvebtn" type="button" onclick="getApproveInfo()" class="btn btn-info">Approve</button>
                    @endcan
                    @can('Approver-Requisition-Comment')
                    <button id="correctionbtn" type="button" onclick="getCommentInfo()" class="btn btn-info">Comment</button>
                    @endcan
                    @can('Approver-Requisition-Reject')
                    <button id="rejectbtn" type="button" onclick="getRejectInfo()" class="btn btn-info">Reject</button>
                    @endcan
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- End Info -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="trInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Store Transfer Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                        <input type="hidden" placeholder="" class="form-control" name="recTrId" id="recTrId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recTrStatus" id="recTrStatus" readonly="true">
                                        <section id="collapsible">
                                            <div class="card collapse-icon">
                                                <div class="collapse-default">
                                                    <div class="card">
                                                        <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                            <span class="lead collapse-title">Transfer Basic & Others Information</span>
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
                                                                                        <td><label strong style="font-size: 14px;">Document Number</label></td>
                                                                                        <td><label id="infotrdocnum" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Source Store/Shop</label></td>
                                                                                        <td><label id="infotrsourcestore" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Destination Store/Shop</label></td>
                                                                                        <td><label id="infotrdestinationstore" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label strong style="font-size: 14px;">Reason</label></td>
                                                                                        <td><label id="infotrpurpose" strong style="font-size: 14px;font-weight:bold;"></label></td>
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
                                                                                                <td><label strong style="font-size: 14px;">Prepared By</label></td>
                                                                                                <td><label id="infotrpreparedby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Prepared Date</label></td>
                                                                                                <td><label id="infotrdate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Requested By</label></td>
                                                                                                <td><label id="infotrrequestby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Approved By</label></td>
                                                                                                <td><label id="infotrapprovedby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Approved Date</label></td>
                                                                                                <td><label id="infotrapproveddate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Issued By</label></td>
                                                                                                <td><label id="infotrissuedby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Issued Date</label></td>
                                                                                                <td><label id="infotrissueddate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-12">
                                                                                        <table>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Void By</label></td>
                                                                                                <td><label id="infotrvoidby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Void Date</label></td>
                                                                                                <td><label id="infotrvoiddate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Comment By</label></td>
                                                                                                <td><label id="infotrcommentby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Comment</label></td>
                                                                                                <td><label id="infotrcomment" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Comment Date</label></td>
                                                                                                <td><label id="infotrcommentdate" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Rejected By</label></td>
                                                                                                <td><label id="infotrrejectby" strong style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label strong style="font-size: 14px;">Rejected Date</label></td>
                                                                                                <td><label id="infotrrejectdate" strong style="font-size: 14px;font-weight:bold;"></label></td>
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
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="trinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <th>#</th>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>SKU Number</th>
                                                <th>Part Number</th>
                                                <th>UOM</th>
                                                <th>Quantity</th>
                                                <th>Remark</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @can('Approver-Transfer-Approve')
                        <button id="approvetrbtn" type="button" onclick="getTrApproveInfo()" class="btn btn-info">Approve</button>
                        @endcan
                        @can('Approver-Transfer-Comment')
                        <button id="correctiontrbtn" type="button" onclick="getTrCommentInfo()" class="btn btn-info">Comment</button>
                        @endcan
                        @can('Approver-Transfer-Reject')
                        <button id="rejecttrbtn" type="button" onclick="getTrRejectInfo()" class="btn btn-info">Reject</button>
                        @endcan
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <!-- End Info -->

<!--Start Approve modal -->
<div class="modal fade text-left" id="approveconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approveform">
                @csrf
                <div class="modal-body" style="background-color:#5cb85c">
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to approve requisition?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="appId" id="appId" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="conapprovebtn" type="button" class="btn btn-info">Approve</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Approve modal -->

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
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to approve transfer?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="apptrId" id="apptrId" readonly="true">
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

<!--Start Comment modal -->
<div class="modal fade text-left" id="commentModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closecommentRequis()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="commentform">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label strong style="font-size: 16px;">Put some comment</label>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Comment</div>
                    </div>
                    <label strong style="font-size: 16px;"></label>
                    <div class="form-group">
                        <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="Comment" id="Comment" onkeyup="commentRequis()" autofocus></textarea>
                        <span class="text-danger">
                            <strong id="comment-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="commentid" id="commentid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="commentstatus" id="commentstatus" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="concommentbtn" type="button" class="btn btn-info">Comment</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closecommentRequis()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Comment modal -->

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
                        <label strong style="font-size: 16px;">Put some comment</label>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Comment</div>
                    </div>
                    <label strong style="font-size: 16px;"></label>
                    <div class="form-group">
                        <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="Comment" id="CommentTr" onkeyup="commentTrVal()" autofocus></textarea>
                        <span class="text-danger">
                            <strong id="commenttr-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="commenttrid" id="commenttrid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="commenttrstatus" id="commenttrstatus" readonly="true">
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
<div class="modal fade text-left" id="rejectconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectform">
                @csrf
                <div class="modal-body" style="background-color:#d9534f">
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to reject requisition?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="rejId" id="rejId" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="rejstatus" id="rejstatus" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="conrejectbtn" type="button" class="btn btn-info">Reject</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Reject modal -->

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
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to reject transfer?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="rejtrId" id="rejtrId" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="rejtrstatus" id="rejtrstatus" readonly="true">
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
 

<script  type="text/javascript">
    $(function () {
        cardSection = $('#page-block');
    });

    //Datatable read property starts
    $(document).ready( function () {
        $('#fiscalyear').select2();
        $('#laravel-datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "order": [[ 0, "desc" ]],
        "lengthMenu": [50,100],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here" },
        "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/requisitiondataapp',
            type: 'DELETE',
            dataType: "json",
        },
        columns: [
            { data: 'id', name: 'id' , 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' },
            { data: 'Type', name: 'Type', 'visible': false },
            { data: 'SourceStore', name: 'SourceStore' },
            { data: 'DestinationStore', name: 'DestinationStore' , 'visible': false},
            { data: 'Date', name: 'Date' },
            { data: 'RequestedBy', name: 'RequestedBy' }, 
            { data: 'Status', name: 'Status' }, 
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Pending") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
            }
            else if (aData.Status == "Approved") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Issued") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
            else if (aData.Status == "Commented") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
            }
            else if (aData.Status == "Corrected") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
            }
            else if (aData.Status == "Rejected") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
            }
            else if (aData.Status == "Void") 
            {
                $(nRow).find('td:eq(5)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
            }
        },
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight(),
        },
        });

        $('#laravel-datatable-crud-tr').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        searchHighlight: true,
        "order": [[ 0, "desc" ]],
        "lengthMenu": [50,100],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here" },
        "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/transferDataShow',
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
            { data: 'id', name: 'id' , 'visible': false },
            {data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' },
            { data: 'Type', name: 'Type', 'visible': false },
            { data: 'SourceStore', name: 'SourceStore' },
            { data: 'DestinationStore', name: 'DestinationStore' },
            { data: 'Date', name: 'Date' },
            { data: 'TransferBy', name: 'TransferBy' }, 
            { data: 'Status', name: 'Status' }, 
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Pending") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
            }
            else if (aData.Status == "Approved") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Issued") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
            else if (aData.Status == "Commented") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
            }
            else if (aData.Status == "Corrected") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
            }
            else if (aData.Status == "Rejected") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
            }
            else if (aData.Status == "Void") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
            }
        },
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight(),
        },
        });

        $.fn.dataTable.ext.errMode = 'throw';
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
        var tTable = $('#laravel-datatable-crud-tr').dataTable(); 
        tTable.fnDraw(false);
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

    $('#laravel-datatable-crud-tr tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
    //Start show receiving doc info
    $(document).on('click', '.DocReqInfo', function()
    {
        $('#laravel-datatable-crud').DataTable().ajax.reload();
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#reqId").val(recordId);
        $("#statusi").val(statusval);
        $.get("/showReqDataapp" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.reqHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infodocnum').text(data.reqHeader[i].DocumentNumber);
                $('#infotype').text(data.reqHeader[i].Type);
                $('#infosourcestore').text(data.reqHeader[i].SourceStore);
                $('#infodestinationstore').text(data.reqHeader[i].DestinationStore);
                $('#infopreparedby').text(data.reqHeader[i].PreparedBy);
                $('#inforequestby').text(data.reqHeader[i].RequestedBy);
                $('#infodate').text(data.reqHeader[i].Date);
                $('#infopurpose').text(data.reqHeader[i].Purpose);
                $('#infostatus').text(data.reqHeader[i].Status);
                $('#infoapprovedby').text(data.reqHeader[i].ApprovedBy);
                $('#infoapproveddate').text(data.reqHeader[i].ApprovedDate);
                $('#infoissuedby').text(data.reqHeader[i].IssuedBy);
                $('#infoissueddate').text(data.reqHeader[i].IssuedDate);
                $('#inforejectby').text(data.reqHeader[i].RejectedBy);
                $('#inforejectdate').text(data.reqHeader[i].RejectedDate);
                $('#infocommentby').text(data.reqHeader[i].CommentedBy);
                $('#infocommentdate').text(data.reqHeader[i].CommentedDate);
                $('#infovoidby').text(data.reqHeader[i].VoidBy);
                $('#infovoiddate').text(data.reqHeader[i].VoidDate);
                $('#infocomment').text(data.reqHeader[i].Memo);
                var st=data.reqHeader[i].Status;
                if(st==="Pending")
                {
                    $("#approvebtn").show();
                    $("#correctionbtn").show();
                    $("#rejectbtn").show();
                    $("#statustitlesreq").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Approved")
                {
                    $("#approvebtn").hide();
                    $("#correctionbtn").hide();
                    $("#rejectbtn").show();
                    $("#statustitlesreq").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Commented")
                {
                    $("#approvebtn").show();
                    $("#correctionbtn").show();
                    $("#rejectbtn").show();
                    $("#statustitlesreq").html("<span style='color:#rgb(133 135 150);font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Rejected")
                {
                    $("#approvebtn").show();
                    $("#correctionbtn").show();
                    $("#rejectbtn").hide();
                    $("#statustitlesreq").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Issued")
                {
                    $("#approvebtn").hide();
                    $("#correctionbtn").hide();
                    $("#rejectbtn").hide();
                    $("#statustitlesreq").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Void")
                {
                    $("#approvebtn").hide();
                    $("#correctionbtn").hide();
                    $("#rejectbtn").hide();
                    $("#statustitlesreq").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
            }    
        })

        $('#reqinfodetail').DataTable({
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
            url: '/showReqDetailapp/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName'},
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'PartNumber', name: 'PartNumber', 'visible': false },  
            { data: 'UOM', name: 'UOM'},  
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'Memo', name: 'Memo'}
        ],
        });
        $.fn.dataTable.ext.errMode = 'throw';
        var oTable = $('#reqinfodetail').dataTable(); 
        oTable.fnDraw(false);
        $(".infoscl").collapse('show');
        $("#reqInfoModal").modal('show');
    });
    //End show receiving doc info

    //Start show receiving doc info
    $(document).on('click', '.DocTrInfo', function()
    {
        $('#laravel-datatable-crud-tr').DataTable().ajax.reload();
        var comments;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#recTrId").val(recordId);
        $("#recTrStatus").val(statusval);
        $.get("/showTrAppData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.trHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infotrdocnum').text(data.trHeader[i].DocumentNumber);
                $('#infotrsourcestore').text(data.trHeader[i].SourceStore);
                $('#infotrdestinationstore').text(data.trHeader[i].DestinationStore);
                $('#infotrrequestby').text(data.trHeader[i].TransferBy);
                $('#infotrpreparedby').text(data.trHeader[i].PreparedBy);
                $('#infotrdate').text(data.trHeader[i].Date);
                $('#infotrpurpose').text(data.trHeader[i].Reason);
                $('#infotrstatus').text(data.trHeader[i].Status);
                $('#infotrapprovedby').text(data.trHeader[i].ApprovedBy);
                $('#infotrapproveddate').text(data.trHeader[i].ApprovedDate);
                $('#infotrissuedby').text(data.trHeader[i].IssuedBy);
                $('#infotrissueddate').text(data.trHeader[i].IssuedDate);
                $('#infotrrejectby').text(data.trHeader[i].RejectedBy);
                $('#infotrrejectdate').text(data.trHeader[i].RejectedDate);
                $('#infotrcommentby').text(data.trHeader[i].CommentedBy);
                $('#infotrcommentdate').text(data.trHeader[i].CommentedDate);
                $('#infotrvoidby').text(data.trHeader[i].VoidBy);
                $('#infotrvoiddate').text(data.trHeader[i].VoidDate);
                $('#infotrcomment').text(data.trHeader[i].Memo);
                comments=data.trHeader[i].Memo;
                var st=data.trHeader[i].Status;
                if(st==="Pending")
                {
                    $("#approvetrbtn").show();
                    $("#correctiontrbtn").show();
                    $("#rejecttrbtn").show();
                    $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Approved")
                {
                    $("#approvetrbtn").hide();
                    $("#correctiontrbtn").hide();
                    $("#rejecttrbtn").show();
                    $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Commented")
                {
                    $("#approvetrbtn").show();
                    $("#correctiontrbtn").show();
                    $("#rejecttrbtn").show();
                    $("#statustitles").html("<span style='color:#rgb(133 135 150);font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Rejected")
                {
                    $("#approvetrbtn").show();
                    $("#correctiontrbtn").show();
                    $("#rejecttrbtn").hide();
                    $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Issued")
                {
                    $("#approvetrbtn").hide();
                    $("#correctiontrbtn").hide();
                    $("#rejecttrbtn").hide();
                    $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
                else if(st==="Void")
                {
                    $("#approvetrbtn").hide();
                    $("#correctiontrbtn").hide();
                    $("#rejecttrbtn").hide();
                    $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;text-align:right;'>"+st+"</span>");
                }
            }    
        });
        $('#trinfodetail').DataTable({
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
            url: '/showTrAppDetail/'+recordId,
            type: 'DELETE',
            },
        columns: [
            {data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName'},
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'PartNumber', name: 'PartNumber', 'visible': false },  
            { data: 'UOM', name: 'UOM'},  
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'Memo', name: 'Memo'}
        ],
        });
        $.fn.dataTable.ext.errMode = 'throw';
        var rTable = $('#trinfodetail').dataTable(); 
        rTable.fnDraw(false);
        $(".infoscl").collapse('show');
        $("#trInfoModal").modal('show');
    });
    //End show receiving doc info

    function getApproveInfo()
    {
        var rid=$('#reqId').val();
        $('#appId').val(rid);
        $('#approveconmodal').modal('show');
        $('#conapprovebtn').prop( "disabled", false );
    }

    function getTrApproveInfo()
    {
        var rid=$('#recTrId').val();
        $('#apptrId').val(rid);
        $('#approvetrconmodal').modal('show');
        $('#conapprovetrbtn').prop( "disabled", false );
    }

    function getCommentInfo()
    {
        var status=$('#statusi').val();
        var rid=$('#reqId').val();
        $('#commentid').val(rid);
        $('#commentstatus').val(status);
        $('#commentModal').modal('show');
        $("#Comment").focus();
        $('#concommentbtn').prop( "disabled", false );
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

    function getRejectInfo()
    {
        var status=$('#statusi').val();
        var rid=$('#reqId').val();
        $('#rejId').val(rid);
        $('#rejstatus').val(status);
        $('#rejectconmodal').modal('show');
        $('#conrejectbtn').prop( "disabled", false );
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

    //Start approve here
    $('body').on('click', '#conapprovebtn', function()
    {
        var registerForm = $("#approveform");
        var formData = registerForm.serialize();
        $.ajax({
        url:'/approveReq',
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
                $('#conapprovebtn').text('Approving...');
                $('#conapprovebtn').prop( "disabled", true );
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
                    $('#conapprovebtn').text('Approve');
                    toastrMessage('success',"Successful","Success");
                    $("#approveconmodal").modal('hide');
                    $("#reqInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    $("#approveform")[0].reset();
                }
            },
        });
    });
    //End Approve

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
                if(data.success) 
                {
                    $('#conapprovetrbtn').text('Approve');
                    toastrMessage('success',"Successful","Success");
                    $("#approvetrconmodal").modal('hide');
                    $("#trInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud-tr').dataTable(); 
                    oTable.fnDraw(false);
                    $("#approvetrform")[0].reset();
                }
            },
        });
    });
    //End Approve

    //Start Comment
    $('body').on('click', '#concommentbtn', function()
    {
        var statusVal = $("#commentstatus").val();
        if(statusVal=="Approved"||statusVal=="Issued")
        {
            toastrMessage('error',"You cant Comment on this status","Error");
        }
        else if(statusVal=="Pending"||statusVal=="Rejected")
        {
            var registerForm = $("#commentform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/commentReq',
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
                    $('#concommentbtn').text('Commenting...');
                    $('#concommentbtn').prop( "disabled", true );
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
                            $('#comment-error' ).html( data.errors.Comment[0] );
                        }
                        $('#concommentbtn').text('Comment');
                        $('#concommentbtn').prop( "disabled",false);
                        toastrMessage('error',"Check your inputs","Error"); 
                    }
                    if(data.success) {
                        $('#concommentbtn').text('Comment');
                        $('#concommentbtn').prop("disabled",false);
                        toastrMessage('success',"Successful","Success");
                        $("#commentModal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#commentform")[0].reset();
                    }
                },
            });
        }
    });
    //End Comment

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
                        $("#trInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud-tr').dataTable(); 
                        oTable.fnDraw(false);
                        $("#commenttrform")[0].reset();
                    }
                },
            });
        }
    });
    //End Comment

    //Start Rejection
    $('body').on('click', '#conrejectbtn', function()
    {
        var statusVal = $("#rejstatus").val();
        if(statusVal=="Issued"||statusVal=="Rejected")
        {
            toastrMessage('error',"You cant Reject on this status","Error");
        }
        else if(statusVal=="Pending"||statusVal=="Commented"||statusVal=="Approved")
        {
            var registerForm = $("#rejectform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/rejReq',
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
                    $('#conrejectbtn').text('Rejecting...');
                    $('#conrejectbtn').prop( "disabled", true );
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
                        $('#conrejectbtn').text('Reject');
                        toastrMessage('success',"Successful","Success");
                        $("#rejectconmodal").modal('hide');
                        $("#reqInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#rejectform")[0].reset();
                    }
                },
            });
        }
    });
    //End Rejection

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
                        $("#trInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud-tr').dataTable(); 
                        oTable.fnDraw(false);
                        $("#rejecttrform")[0].reset();
                    }
                },
            });
        }
    });
    //End Rejection

    function refreshtbl()
    {
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
        var tTable = $('#laravel-datatable-crud-tr').dataTable(); 
        tTable.fnDraw(false);
    }

    function commentRequis() 
    {
        $( '#comment-error' ).html("");
    }

    function commentTrVal() 
    {
        $( '#commenttr-error' ).html("");
    }

    function closecommentRequis() 
    {
        $('#comment-error').html("");
        $("#commentform")[0].reset();
    }

    function closecommenttr() 
    {
        $('#commenttr-error').html("");
        $("#commenttrform")[0].reset();
    }

    //Show modal with focus textbox starts
    $(document).on('shown.bs.modal', '.modal', function () 
    {
        $(this).find('[autofocus]').focus();
    });
    //Show modal with focus textbox ends

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
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/requisitiondataappfy/'+fy,
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
                    { data: 'id', name: 'id' , 'visible': false },
                    {data:'DT_RowIndex'},
                    { data: 'DocumentNumber', name: 'DocumentNumber' },
                    { data: 'Type', name: 'Type', 'visible': false },
                    { data: 'SourceStore', name: 'SourceStore' },
                    { data: 'DestinationStore', name: 'DestinationStore' , 'visible': false},
                    { data: 'Date', name: 'Date' },
                    { data: 'RequestedBy', name: 'RequestedBy' }, 
                    { data: 'Status', name: 'Status' }, 
                    { data: 'action', name: 'action' }
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
                {
                    if (aData.Status == "Pending") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                    }
                    else if (aData.Status == "Approved") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    }
                    else if (aData.Status == "Issued") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                    }
                    else if (aData.Status == "Commented") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
                    }
                    else if (aData.Status == "Corrected") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
                    }
                    else if (aData.Status == "Rejected") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                    }
                    else if (aData.Status == "Void") 
                    {
                        $(nRow).find('td:eq(5)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                    }
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },  
            });

            $('#laravel-datatable-crud-tr').DataTable({
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
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/transferDataShowfy/'+fy,
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
                { data: 'id', name: 'id' , 'visible': false },
                {data:'DT_RowIndex'},
                { data: 'DocumentNumber', name: 'DocumentNumber' },
                { data: 'Type', name: 'Type', 'visible': false },
                { data: 'SourceStore', name: 'SourceStore' },
                { data: 'DestinationStore', name: 'DestinationStore' },
                { data: 'Date', name: 'Date' },
                { data: 'TransferBy', name: 'TransferBy' }, 
                { data: 'Status', name: 'Status' }, 
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
            {
                if (aData.Status == "Pending") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                }
                else if (aData.Status == "Approved") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                }
                else if (aData.Status == "Issued") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                }
                else if (aData.Status == "Commented") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
                }
                else if (aData.Status == "Corrected") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
                }
                else if (aData.Status == "Rejected") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                }
                else if (aData.Status == "Void") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                }
            },
            fixedHeader: {
                header: true,
                headerOffset: $('.header-navbar').outerHeight(),
            },
            });
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
            var iTable = $('#laravel-datatable-crud-tr').dataTable(); 
            iTable.fnDraw(false);
        });
</script>   
@endsection
  