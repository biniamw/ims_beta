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
                                <h3 class="card-title">Issue</h3>
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
                                @can('Issue-Transfer-View')
                                <li class="nav-item">
                                    <a class="nav-link active" id="TrApprove-tab" data-toggle="tab" href="#trapproved" aria-controls="trapproved" role="tab" aria-selected="true">Transfer Approved List</a>                                
                                </li>
                                @endcan
                                @can('Issue-Transfer-View')
                                <li class="nav-item">
                                    <a class="nav-link" id="Stiv-tab" data-toggle="tab" href="#stiv" aria-controls="stiv" role="tab" aria-selected="false">STIV List</a>
                                </li>
                                @endcan
                                @can('Issue-Requisition-View')
                                <li class="nav-item">
                                    <a class="nav-link" id="Approve-tab" data-toggle="tab" href="#approved" aria-controls="approved" role="tab" aria-selected="true">Requisition Approved List</a>                                
                                </li>
                                @endcan
                                @can('Issue-Requisition-View')
                                <li class="nav-item">
                                    <a class="nav-link" id="Issue-tab" data-toggle="tab" href="#issue" aria-controls="issue" role="tab" aria-selected="false">SIV List</a>
                                </li>
                               @endcan
                            </ul>
                            <div style="text-align: right;">
                                <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshtbl()"><i data-feather='refresh-ccw'></i></button>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                @can('Issue-Transfer-View')
                                <div class="tab-pane active" id="trapproved" aria-labelledby="trapproved" role="tabpanel">
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
                                                        <th>Approved By</th>  
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="stiv" aria-labelledby="stiv" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="laravel-datatable-crud-stiv" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
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
                                                        <th>Approved By</th>  
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
                                @can('Issue-Requisition-View')
                                <div class="tab-pane" id="approved" aria-labelledby="approved" role="tabpanel">
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
                                                        <th>Destnation Store/Shop</th>
                                                        <th>Date</th>
                                                        <th>Requested By</th>
                                                        <th>Approved By</th>  
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>      
                                                <tbody></tbody>         
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="issue" aria-labelledby="issue" role="tabpanel">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="laravel-datatable-crud-issued" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
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
                                                        <th>Approved By</th>  
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
                                    <table class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <tr>
                                            <th><label strong style="font-size: 14px;">Document Number</label></th>
                                            <th style="display: none;"><label strong style="font-size: 14px;">Type</label></th>
                                            <th><label strong style="font-size: 14px;">Source Store / Shop</label></th>
                                            <th style="display: none;"><label strong style="font-size: 14px;">Destination Store / Shop</label></th>
                                            <th><label strong style="font-size: 14px;">Requested By</label></th>
                                            <th><label strong style="font-size: 14px;">Requested Date</label></th>
                                            <th><label strong style="font-size: 14px;">Approved By</label></th>
                                            <th><label strong style="font-size: 14px;">Approved Date</label></th>
                                            <th><label strong style="font-size: 14px;">Purpose</label></th>
                                            <th><label strong style="font-size: 14px;">Status</label></th>
                                        </tr>
                                        <tr>
                                            <td><label id="infodocnum" strong style="font-size: 14px;"></label></td>
                                            <td style="display: none;"><label id="infotype" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infosourcestore" strong style="font-size: 14px;"></label></td>
                                            <td style="display: none;"><label id="infodestinationstore" strong style="font-size: 14px;"></label></td>
                                            <td><label id="inforequestby" strong style="font-size: 14px;"></label></td>
                                            <td><label id="inforequestdate" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infoapprovedby" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infodate" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infopurpose" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infostatus" strong style="font-size: 14px;"></label></td>
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
                                    <table id="reqinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                        <thead>
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
                    @can('Issue-Requisition-Issue')
                    <button id="issuebtn" type="button" onclick="getIssueInfo()" class="btn btn-info">Issue</button>
                    @endcan
                    <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            <form id="reqInfoformtr">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <input type="hidden" placeholder="" class="form-control" name="itemid" id="itemid" readonly="true">
                                    <input type="hidden" placeholder="" class="form-control" name="recTrId" id="recTrId" readonly="true">
                                    <input type="hidden" placeholder="" class="form-control" name="recTrStatus" id="recTrStatus" readonly="true">
                                    <table class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <tr>
                                            <th><label strong style="font-size: 14px;">Document Number</label></th>
                                            <th><label strong style="font-size: 14px;">Source Store / Shop</label></th>
                                            <th><label strong style="font-size: 14px;">Destination Store / Shop</label></th>
                                            <th><label strong style="font-size: 14px;">Requested By</label></th>
                                            <th><label strong style="font-size: 14px;">Requested Date</label></th>
                                            <th><label strong style="font-size: 14px;">Approved By</label></th>
                                            <th><label strong style="font-size: 14px;">Approved Date</label></th>
                                            <th><label strong style="font-size: 14px;">Reason</label></th>
                                            <th><label strong style="font-size: 14px;">Status</label></th>
                                        </tr>
                                        <tr>
                                            <td><label id="infotrdocnum" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrsourcestore" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrdestinationstore" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrrequestby" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrdate" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrapprovedby" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrapproveddate" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrpurpose" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infotrstatus" strong style="font-size: 14px;"></label></td>
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Issue-Transfer-Issue')
                    <button id="issuetrbtn" type="button" onclick="getTrIssueInfo()" class="btn btn-info">Issue</button>
                    @endcan
                    <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- End Info -->


<!--Start Info Modal -->
<div class="modal fade text-left" id="issInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Approve Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reqInfoformap">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <input type="hidden" placeholder="" class="form-control" name="issId" id="issId" readonly="true">
                                    <input type="hidden" placeholder="" class="form-control" name="statusiss" id="statusiss" readonly="true">
                                    <table class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <tr>
                                            <th><label strong style="font-size: 14px;">Issue Document No.</label></th>
                                            <th><label strong style="font-size: 14px;">Transfer Document No.</label></th>
                                            <th style="display: none;"><label strong style="font-size: 14px;">Type</label></th>
                                            <th><label strong style="font-size: 14px;">Source Store / Shop</label></th>
                                            <th><label strong style="font-size: 14px;">Destination Store / Shop</label></th>
                                            <th><label strong style="font-size: 14px;">Prepared By</label></th>
                                            <th><label strong style="font-size: 14px;">Requested By</label></th>
                                            <th><label strong style="font-size: 14px;">Approved By</label></th>
                                            <th><label strong style="font-size: 14px;">Issued By</label></th>
                                            <th><label strong style="font-size: 14px;">Issued Date</label></th>
                                            <th><label strong style="font-size: 14px;">Purpose</label></th>
                                            <th><label strong style="font-size: 14px;">Status</label></th>
                                        </tr>
                                        <tr>
                                            <td><label id="infodocnumiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infodocnumreqiss" strong style="font-size: 14px;"></label></td>
                                            <td style="display: none;"><label id="infotypeiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infosourcestoreiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infodestinationstoreiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infopreparedby" strong style="font-size: 14px;"></label></td>
                                            <td><label id="inforequestbyiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infoapprovedbyiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infoissuedbyiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infodateiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infopurposeiss" strong style="font-size: 14px;"></label></td>
                                            <td><label id="infostatusiss" strong style="font-size: 14px;"></label></td>
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
                                    <table id="issinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                        <thead>
                                            <th>#</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>SKU Number</th>
                                            <th>Part Number</th>
                                            <th>UOM</th>
                                            <th>Quantity</th>
                                            <th>Memo</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closebuttona" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
  <!-- End Info -->

<!--Start Issue modal -->
<div class="modal fade text-left" id="issueconmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="issueform">
                @csrf
                <div class="modal-body" style="background-color:#5cb85c;">
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to Issue?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="issueId" id="issueId" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="conissuebtn" type="button" class="btn btn-info">Issue</button>
                    <button id="closebuttonb" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Issue modal -->

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
                <div class="modal-body">
                    <div class="form-group">
                        <label strong style="font-size: 20px;font-weight:bold;">Do you really want to Issue?</label>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Select Issed By User</div>
                    </div>
                    <label strong style="font-size: 16px;"></label>
                    <div class="form-group">
                        <div>
                            <select class="select2 form-control" name="IssuedByUser" id="IssuedByUser" onchange="issuedByVal()">
                                <option selected disabled value=""></option>
                            </select>
                        </div>
                        <span class="text-danger">
                            <strong id="issuedbyuser-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="issuetrId" id="issuetrId" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="issuetrStatusi" id="issuetrStatusi" readonly="true">
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
                    <label strong style="font-size: 16px;">Select serial number, batch number or expire date</label>
                    <div class="form-group">
                        <div>
                            <select class="select2 form-control" name="SerialNumber[]" id="SerialNumber" onchange="serialnumberVal()" multiple="multiple"></select>
                        </div>
                        <span class="text-danger">
                            <strong id="serialnumbers-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="recids" id="recids" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="listofsernum" id="listofsernum" readonly="true">
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


<script  type="text/javascript">
    $(function () {
        cardSection = $('#page-block');
    });

    //Datatable read property starts
    $(document).ready( function () {
        $(".selectpicker").selectpicker({
            noneSelectedText : ''
        });
        $('#fiscalyear').select2();
        $('#laravel-datatable-crud').DataTable({
        destroy:true,
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
            url: '/issuedataiss',
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
            { data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' },
            { data: 'Type', name: 'Type', 'visible': false  },
            { data: 'SourceStore', name: 'SourceStore' },
            { data: 'DestinationStore', name: 'DestinationStore' , 'visible': false },
            { data: 'Date', name: 'Date' },
            { data: 'RequestedBy', name: 'RequestedBy' },
            { data: 'ApprovedBy', name: 'ApprovedBy' },  
            { data: 'Status', name: 'Status' }, 
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Approved") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Issued") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
        },
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight(),
        },
        });

        $('#laravel-datatable-crud-issued').DataTable({
        destroy:true,
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
            url: '/issuedataapp',
            type: 'DELETE',
            dataType: "json",
            },
        columns: [
            { data: 'id', name: 'id' , 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' },
            { data: 'Type', name: 'Type' , 'visible': false},
            { data: 'SourceStore', name: 'SourceStore' },
            { data: 'DestinationStore', name: 'DestinationStore' , 'visible': false},
            { data: 'Date', name: 'Date' },
            { data: 'RequestedBy', name: 'RequestedBy' },
            { data: 'ApprovedBy', name: 'ApprovedBy' },  
            { data: 'Status', name: 'Status' }, 
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Approved") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Issued") 
            {
                $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
        },
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight(),
        },
        });

        $('#laravel-datatable-crud-stiv').DataTable({
        destroy:true,
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
            url: '/issuedatastiv',
            type: 'DELETE',
            dataType: "json",
            },
        columns: [
            { data: 'id', name: 'id' , 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' },
            { data: 'Type', name: 'Type' , 'visible': false},
            { data: 'SourceStore', name: 'SourceStore' },
            { data: 'DestinationStore', name: 'DestinationStore' },
            { data: 'Date', name: 'Date' },
            { data: 'RequestedBy', name: 'RequestedBy' },
            { data: 'ApprovedBy', name: 'ApprovedBy' },  
            { data: 'Status', name: 'Status' }, 
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Approved") 
            {
                $(nRow).find('td:eq(7)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Issued") 
            {
                $(nRow).find('td:eq(7)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
        },
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight(),
        },
        });

        $('#laravel-datatable-crud-tr').DataTable({
        destroy:true,
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
            url: '/transferIssDataShow',
            type: 'DELETE',
            dataType: "json",
            },
        columns: [
            { data: 'id', name: 'id' , 'visible': false },
            { data:'DT_RowIndex'},
            { data: 'DocumentNumber', name: 'DocumentNumber' },
            { data: 'Type', name: 'Type', 'visible': false  },
            { data: 'SourceStore', name: 'SourceStore' },
            { data: 'DestinationStore', name: 'DestinationStore' },
            { data: 'Date', name: 'Date' },
            { data: 'TransferBy', name: 'TransferBy' }, 
            { data: 'ApprovedBy', name: 'ApprovedBy' }, 
            { data: 'Status', name: 'Status' }, 
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "Approved") 
            {
                $(nRow).find('td:eq(7)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Issued") 
            {
                $(nRow).find('td:eq(7)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
        },
        fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight(),
        },
        });
    });

    $('#laravel-datatable-crud-issued tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
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

    $('#laravel-datatable-crud-stiv tbody').on('click', 'tr', function () {
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
        var st;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#issId").val(recordId);
        $("#statusiss").val(statusval);
        $.get("/showReqDataiss" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.issHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                 $('#infodocnumiss').text(data.issHeader[i].DocumentNumber);
                 $('#infodocnumreqiss').text(data.issHeader[i].ReqDocumentNumber);
                 $('#infotypeiss').text(data.issHeader[i].Type);
                 $('#infosourcestoreiss').text(data.issHeader[i].SourceStore);
                 $('#infodestinationstoreiss').text(data.issHeader[i].DestinationStore);
                 $('#infopreparedby').text(data.issHeader[i].PreparedBy);
                 $('#inforequestbyiss').text(data.issHeader[i].RequestedBy);
                 $('#infoapprovedbyiss').text(data.issHeader[i].ApprovedBy);
                 $('#infoissuedbyiss').text(data.issHeader[i].IssuedBy);
                 $('#infodateiss').text(data.issHeader[i].Date);
                 $('#infopurposeiss').text(data.issHeader[i].Purpose);
                 $('#infostatusiss').text(data.issHeader[i].Status);
                 st=data.issHeader[i].Status;
            }    
        })

        $('#issinfodetail').DataTable({
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
            url: '/showDetailiss/'+recordId,
            type: 'DELETE',
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
            { data: 'PartNumber', name: 'PartNumber', 'visible': false },  
            { data: 'UOM', name: 'UOM'},  
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'Memo', name: 'Memo'},
            { data: 'BatchNumber', name: 'BatchNumber','visible': false },
            { data: 'SerialNumber', name: 'SerialNumber','visible': false },
            { data: 'ExpireDate', name: 'ExpireDate','visible': false },
            { data: 'ManufactureDate', name: 'ManufactureDate','visible': false },
            { data: 'RequireSerialNumber', name: 'RequireSerialNumber','visible': false },  
            { data: 'RequireExpireDate', name: 'RequireExpireDate','visible': false }, 
            { data: 'InsertedQty', name: 'InsertedQty','visible': false },   
        ],
        });
        if(st=="Approved")
        {   
            $("#issuebtn").show();   
            $("#conissuebtn").show();         
        }
        else if(st!="Approved")
        {
            $("#issuebtn").hide();   
            $("#conissuebtn").hide();    
        }
        $("#issInfoModal").modal('show');
        $.fn.dataTable.ext.errMode = 'throw';
        var iTable = $('#issinfodetail').dataTable(); 
        iTable.fnDraw(false);
    });
    //End show receiving doc info

//Start show receiving doc info
$(document).on('click', '.DocReqInfoApp', function()
{
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#reqId").val(recordId);
        $("#statusi").val(statusval);

        $.get("/showReqDataapproving" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.reqHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infodocnum').text(data.reqHeader[i].DocumentNumber);
                $('#infotype').text(data.reqHeader[i].Type);
                $('#infosourcestore').text(data.reqHeader[i].SourceStore);
                $('#infodestinationstore').text(data.reqHeader[i].DestinationStore);
                $('#inforequestby').text(data.reqHeader[i].RequestedBy);
                $('#infoapprovedby').text(data.reqHeader[i].ApprovedBy);
                $('#infodate').text(data.reqHeader[i].ApprovedDate);
                $('#inforequestdate').text(data.reqHeader[i].Date);
                $('#infopurpose').text(data.reqHeader[i].Purpose);
                $('#infostatus').text(data.reqHeader[i].Status);
                var stval=data.reqHeader[i].Status;
                if(stval=="Issued")
                {
                    $("#issuebtn").hide();
                    $("#reqInfoModal").modal('hide');
                    var rTable = $('#laravel-datatable-crud').dataTable(); 
                    rTable.fnDraw(false);
                    toastrMessage('error',"Requisition is already issued","Error");
                }
                else
                {
                    $("#issuebtn").show();
                    $("#reqInfoModal").modal('show');
                }
            }    
        });

        $('#reqinfodetail').DataTable({
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
            url: '/showReqDetailapp/'+recordId,
            type: 'DELETE',
            },
        columns: [
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
        var iTable = $('#reqinfodetail').dataTable(); 
        iTable.fnDraw(false);
    });
    //End show receiving doc info

    function getIssueInfo()
    {
        var rid=$('#reqId').val();
        $('#issueId').val(rid);
        $('#issueconmodal').modal('show');
        $('#conissuebtn').prop( "disabled", false );
    }

    //Start Print Attachment
    $('body').on('click', '.printAttachment', function () 
    {
        var id = $(this).data('id');
        var link=$(this).data('link');
        window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
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

    function getTrIssueInfo()
    {
        var rid=$('#recTrId').val();
        $('#issuetrId').val(rid);
        var issuetrstatus=$('#infotrstatus').val();
        var strname=$('#infotrsourcestore').html();
        $('#issuedbyuser-error').html("");
        $('#issuetrStatusi').val(issuetrstatus);
        $('#issuetrconmodal').modal('show');
        $('#conissuetrbtn').prop( "disabled", false );
        $('#IssuedByUser').find('option').not(':first').remove();
        $.get("/showTrIssueUser"+'/'+strname, function (data) 
        {
            if(data.iuser)
            {
                var len=data['iuser'].length;
                for(var i=0;i<=len;i++)
                {
                    var name=data['iuser'][i].UserName;
                    var option = "<option value='"+name+"'>"+name+"</option>";
                    $("#IssuedByUser").append(option);
                    $('#IssuedByUser').selectpicker('refresh');
                }
            }
        });
    }

    //Start show receiving doc info
    $(document).on('click', '.DocTrInfo', function()
    {
        var comments;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#recTrId").val(recordId);
        $("#recTrStatus").val(statusval);
        $.get("/showTrIssData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.trHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infotrdocnum').text(data.trHeader[i].DocumentNumber);
                $('#infotrsourcestore').text(data.trHeader[i].SourceStore);
                $('#infotrdestinationstore').text(data.trHeader[i].DestinationStore);
                $('#infotrrequestby').text(data.trHeader[i].TransferBy);
                $('#infotrdate').text(data.trHeader[i].Date);
                $('#infotrpurpose').text(data.trHeader[i].Reason);
                $('#infotrapprovedby').text(data.trHeader[i].ApprovedBy);
                $('#infotrapproveddate').text(data.trHeader[i].ApprovedDate);
                $('#infotrstatus').text(data.trHeader[i].Status);
                comments=data.trHeader[i].Memo;
                var stval=data.trHeader[i].Status;
                if(stval==="Issued")
                {
                    $("#issuetrbtn").hide();
                    $("#trInfoModal").modal('hide');
                    var rTable = $('#laravel-datatable-crud-tr').dataTable(); 
                    rTable.fnDraw(false);
                    toastrMessage('error',"Transfer is already Issued","Error");
                }
                else
                {
                    $("#issuetrbtn").show();
                    $("#trInfoModal").modal('show');
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
            url: '/showTrIssAppDetail/'+recordId,
            type: 'DELETE',
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
            { data: 'PartNumber', name: 'PartNumber', 'visible': false },  
            { data: 'UOM', name: 'UOM'},  
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'Memo', name: 'Memo'},
            { data: 'action', name: 'action'},
            { data: 'BatchNumber', name: 'BatchNumber','visible': false },
            { data: 'SerialNumber', name: 'SerialNumber','visible': false },
            { data: 'ExpireDate', name: 'ExpireDate','visible': false },
            { data: 'ManufactureDate', name: 'ManufactureDate','visible': false },
            { data: 'RequireSerialNumber', name: 'RequireSerialNumber','visible': false },  
            { data: 'RequireExpireDate', name: 'RequireExpireDate','visible': false }, 
            { data: 'InsertedQty', name: 'InsertedQty','visible': false },       
        ],
            "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                if (aData.Quantity == aData.InsertedQty) {
                    for(var i=0;i<=15;i++){
                        $(nRow).find('td:eq('+i+')').css({"color": "#4CAF50"});
                    }
                } 
            }
        });
        $.fn.dataTable.ext.errMode = 'throw';
        var rTable = $('#trinfodetail').dataTable(); 
        rTable.fnDraw(false);
       
    });
    //End show receiving doc info

    //Start issue here
    $('body').on('click', '#conissuebtn', function()
    {
        $('#conissuebtn').prop( "disabled", true ); 
        var recordId=$("#issueId").val();
        $.get("/showReqDataapproving" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.reqHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                var stval=data.reqHeader[i].Status;
                if(stval=="Issued")
                {
                    $("#issueconmodal").modal('hide');
                    $("#reqInfoModal").modal('hide');
                    var rTable = $('#laravel-datatable-crud').dataTable(); 
                    rTable.fnDraw(false);
                    toastrMessage('error',"Requisition is already Issued","Error");
                }
                else
                {
                    var registerForm = $("#issueform");
                var formData = registerForm.serialize();
                $.ajax({
                url:'/issReq',
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
                        $('#conissuebtn').text('Issuing...');
                        $('#conissuebtn').prop( "disabled", true );
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
                                $('#conissuebtn').text('Issue');
                                $('#conissuebtn').prop( "disabled", false );
                                toastrMessage('error',"There is no available quantity for "+count+"  Items"+loopedVal,"Error");
                                $("#issueconmodal").modal('hide');
                                $("#issueform")[0].reset();
                            }    
                        }
                        if(data.success) 
                        {
                            $('#conissuebtn').text('Issue');
                            $('#conissuebtn').prop( "disabled", false );
                            toastrMessage('success',"Successful","Success");
                            $("#issueconmodal").modal('hide');
                            $("#reqInfoModal").modal('hide');
                            $.fn.dataTable.ext.errMode = 'throw';
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            var iTable = $('#laravel-datatable-crud-issued').dataTable(); 
                            iTable.fnDraw(false);
                            var tTable = $('#laravel-datatable-crud-tr').dataTable(); 
                            tTable.fnDraw(false);
                            $('#IssuedByUser').val(null).trigger('change');
                            $("#issueform")[0].reset();
                            var issueid= data.issueId;
                            var link="/iss/"+issueid;
                            window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
                        }
                    },
                });
                        }
                    }    
                });
    });
    //End issue

    //Start issue here
    $('body').on('click', '#conissuetrbtn', function()
    {
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
                                    $('#conissuetrbtn').text('Issue');
                                    $('#conissuetrbtn').prop( "disabled", false );
                                    toastrMessage('error',"There is no available quantity for "+count+"  Items"+loopedVal,"Error");
                                    $("#issuetrconmodal").modal('hide');
                                    $("#issuetrform")[0].reset();
                                }    
                            }
                            if(data.sererror)
                            {
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
                            if(data.serisserror)
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
                                    $('#conissuetrbtn').text('Issue');
                                    $('#conissuetrbtn').prop( "disabled", false );
                                    toastrMessage('error',"Please select another serial number or batch number, the following "+count+" serial number or batch number are being issued </br>"+loopedVal,"Error");
                                    //$("#issuetrconmodal").modal('hide');
                                    $("#issuetrform")[0].reset();
                                }    
                            }
                            if(data.errors)
                            {
                                if(data.errors.IssuedByUser)
                                {
                                    $('#issuedbyuser-error').html( data.errors.IssuedByUser[0] );
                                }
                                $('#conissuetrbtn').text('Issue');
                                $('#conissuetrbtn').prop( "disabled", false );
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if(data.success) 
                            {
                                $('#conissuetrbtn').text('Issue');
                                $('#conissuetrbtn').prop( "disabled", false );
                                toastrMessage('success',"Successful","Success");
                                $("#issuetrconmodal").modal('hide');
                                $("#trInfoModal").modal('hide');
                                $.fn.dataTable.ext.errMode = 'throw';
                                var oTable = $('#laravel-datatable-crud').dataTable();
                                oTable.fnDraw(false);
                                var iTable = $('#laravel-datatable-crud-issued').dataTable(); 
                                iTable.fnDraw(false);
                                var tTable = $('#laravel-datatable-crud-tr').dataTable(); 
                                tTable.fnDraw(false);
                                var tTable = $('#laravel-datatable-crud-stiv').dataTable(); 
                                tTable.fnDraw(false);
                                $("#issuetrform")[0].reset();
                                $('#IssuedByUser').val(null).trigger('change');
                                var issueid= data.issueId;
                                var link="/isstr/"+issueid;
                                 window.open(link, 'Issue', 'width=1200,height=800,scrollbars=yes');
                            }
                        },
                    });
                 }
            }    
        });
    });
    //End issue

    $('body').on('click', '.addserialnum', function () 
    {
        var registerForm = $("#issueserialnumberform");
        var formData = registerForm.serialize();
        var id = $(this).data('id');
        $.get("/showTransferSerialNum" +'/' + id , function (data) 
        {
            var dc=data;
            var len=data.trdetail.length;
            for(var i=0;i<=len;i++) 
            {  
                var itemid=data.trdetail[i].ItemId;
                var serids=data.trdetail[i].SerialnumIds;
                var reqexd=data.trdetail[i].RequireExpireDate;
                var reqsnm=data.trdetail[i].RequireSerialNumber;
                var storeid=data.trdetail[i].StoreId;
                var itemname=data.trdetail[i].ItemName;
                var itemcode=data.trdetail[i].ItemCode;
                var skunumber=data.trdetail[i].SKUNumber;
                var qnt=data.trdetail[i].Quantity;
                $('#issueserialnumberstitle').html("Select serial number , batch number or expire date for <u>"+itemcode+" , "+itemname+" , "+skunumber+"</u>");
                $('#recids').val(id);
                $('#listofsernum').val(serids);
                if(reqsnm==="Not-Require" && reqexd==="Not-Require"){
                    toastrMessage('error',"Serial number, batch number or expire date are not required for this item","Error");
                }
                else{
                    $("#SerialNumber").empty();
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
                                $("#SerialNumber").append(option);
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
                                $("#SerialNumber").append(option);
                            }
                        },
                    });
                    $("#SerialNumber").select2({
                        maximumSelectionLength: qnt
                    });
                    $("#issueserialnumodal").modal('show');
                }
            }
        });          
    });

    $('body').on('click', '#serialnumissuebtn', function() {
        var registerForm = $("#issueserialnumberform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/saveserialnum',
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
                $('#serialnumissuebtn').text('Saving...');
                $('#serialnumissuebtn').prop( "disabled", true );
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
                    if (data.errors.SerialNumber) {
                        $('#serialnumbers-error').html("This field is required");
                    }
                    $('#serialnumissuebtn').text('Save');
                    $('#serialnumissuebtn').prop( "disabled", false );
                    toastrMessage('error',"Please fill required fields","Error");
                }
                if (data.success) {
                    $('#serialnumissuebtn').text('Save');
                    $('#serialnumissuebtn').prop( "disabled", false );
                    toastrMessage('success',"Successful","Success");
                    $("#issueserialnumodal").modal('hide');
                    var tTable = $('#trinfodetail').dataTable(); 
                    tTable.fnDraw(false);
                }
            },
        });
    });

    function refreshtbl()
    {
        var tabletr = $('#laravel-datatable-crud-tr').DataTable(); tabletr.search('');
        var tablecrud = $('#laravel-datatable-crud').DataTable(); tablecrud.search('');
        var tableiss = $('#laravel-datatable-crud-issued').DataTable(); tableiss.search('');
        var tablestiv = $('#laravel-datatable-crud-stiv').DataTable(); tablestiv.search('');
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
        var iTable = $('#laravel-datatable-crud-issued').dataTable(); 
        iTable.fnDraw(false);
        var tTable = $('#laravel-datatable-crud-tr').dataTable(); 
        tTable.fnDraw(false);
        var stTable = $('#laravel-datatable-crud-stiv').dataTable(); 
        stTable.fnDraw(false);
    }

    function issuedByVal()
    {
        $( '#issuedbyuser-error').html("");
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
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/issuedataissfy/'+fy,
                    type: 'DELETE',
                    dataType: "json", 
                },

                columns: [
                    { data: 'id', name: 'id' , 'visible': false },
                    { data:'DT_RowIndex'},
                    { data: 'DocumentNumber', name: 'DocumentNumber' },
                    { data: 'Type', name: 'Type', 'visible': false  },
                    { data: 'SourceStore', name: 'SourceStore' },
                    { data: 'DestinationStore', name: 'DestinationStore' , 'visible': false },
                    { data: 'Date', name: 'Date' },
                    { data: 'RequestedBy', name: 'RequestedBy' },
                    { data: 'ApprovedBy', name: 'ApprovedBy' },  
                    { data: 'Status', name: 'Status' }, 
                    { data: 'action', name: 'action' }
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
                {
                    if (aData.Status == "Approved") 
                    {
                        $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    }
                    else if (aData.Status == "Issued") 
                    {
                        $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                    }
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },  
            });

            $('#laravel-datatable-crud-issued').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: { search: '', searchPlaceholder: "Search here" },
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/issuedataappfy/'+fy,
                    type: 'DELETE',
                    dataType: "json",
                    },
                columns: [
                    { data: 'id', name: 'id' , 'visible': false },
                    { data:'DT_RowIndex'},
                    { data: 'DocumentNumber', name: 'DocumentNumber' },
                    { data: 'Type', name: 'Type' , 'visible': false},
                    { data: 'SourceStore', name: 'SourceStore' },
                    { data: 'DestinationStore', name: 'DestinationStore' , 'visible': false},
                    { data: 'Date', name: 'Date' },
                    { data: 'RequestedBy', name: 'RequestedBy' },
                    { data: 'ApprovedBy', name: 'ApprovedBy' },  
                    { data: 'Status', name: 'Status' }, 
                    { data: 'action', name: 'action' }
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
                {
                    if (aData.Status == "Approved") 
                    {
                        $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    }
                    else if (aData.Status == "Issued") 
                    {
                        $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                    }
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });

            $('#laravel-datatable-crud-stiv').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: { search: '', searchPlaceholder: "Search here" },
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/issuedatastivfy/'+fy,
                    type: 'DELETE',
                    dataType: "json",
                    },
                columns: [
                    { data: 'id', name: 'id' , 'visible': false },
                    { data:'DT_RowIndex'},
                    { data: 'DocumentNumber', name: 'DocumentNumber' },
                    { data: 'Type', name: 'Type' , 'visible': false},
                    { data: 'SourceStore', name: 'SourceStore' },
                    { data: 'DestinationStore', name: 'DestinationStore' },
                    { data: 'Date', name: 'Date' },
                    { data: 'RequestedBy', name: 'RequestedBy' },
                    { data: 'ApprovedBy', name: 'ApprovedBy' },  
                    { data: 'Status', name: 'Status' }, 
                    { data: 'action', name: 'action' }
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
                {
                    if (aData.Status == "Approved") 
                    {
                        $(nRow).find('td:eq(7)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    }
                    else if (aData.Status == "Issued") 
                    {
                        $(nRow).find('td:eq(7)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
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
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: { search: '', searchPlaceholder: "Search here" },
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/transferIssDataShowfy/'+fy,
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
                    { data:'DT_RowIndex'},
                    { data: 'DocumentNumber', name: 'DocumentNumber' },
                    { data: 'Type', name: 'Type', 'visible': false  },
                    { data: 'SourceStore', name: 'SourceStore' },
                    { data: 'DestinationStore', name: 'DestinationStore' },
                    { data: 'Date', name: 'Date' },
                    { data: 'TransferBy', name: 'TransferBy' }, 
                    { data: 'ApprovedBy', name: 'ApprovedBy' }, 
                    { data: 'Status', name: 'Status' }, 
                    { data: 'action', name: 'action' }
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
                {
                    if (aData.Status == "Approved") 
                    {
                        $(nRow).find('td:eq(7)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    }
                    else if (aData.Status == "Issued") 
                    {
                        $(nRow).find('td:eq(7)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                    }
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
            var iTable = $('#laravel-datatable-crud-issued').dataTable(); 
            iTable.fnDraw(false);
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
            var tTable = $('#laravel-datatable-crud-tr').dataTable(); 
            tTable.fnDraw(false);
            var stTable = $('#laravel-datatable-crud-stiv').dataTable(); 
            stTable.fnDraw(false);
        });

</script>   
@endsection
  