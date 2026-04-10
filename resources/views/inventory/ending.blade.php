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
                                <h3 class="card-title">Stock Ending</h3>
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
                            <div style="text-align: right;">
                            @can('Begining-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addendbutton" data-toggle="modal">Add</button>
                            @endcan
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 0%;">Id</th>
                                                <th style="width: 0%;">#</th>
                                                <th style="width: 20%;">Ending Doc. No.</th>
                                                <th>Beginning Doc. No.</th>
                                                <th style="width: 20%;">Store / Shop Name</th>
                                                <th style="width: 15%;">Fiscal Year</th>
                                                <th style="width: 15%;">Date</th>
                                                <th style="width: 15%;">Status</th>
                                                <th style="width: 8%;">Action</th>
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
     </div>
    <!--Start Info Modal -->

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
<div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="beginingtitle">Begining Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Register">
                {{ csrf_field() }}
                <div class="modal-body"> 
                    <label strong style="font-size: 16px;">Store/Shop Name</label>
                    <div>
                        <select class="select2 form-control" name="store" id="store" onchange="storeVal()">
                            <option selected disabled value=""></option>
                            @foreach ($storeSrc as $storeSrc)
                                <option value="{{$storeSrc->StoreId}}">{{$storeSrc->StoreName}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="tid" id="tid" readonly="true"/>
                        <input type="hidden" class="form-control" name="beginingId" id="beginingId" readonly="true"/>
                    </div>
                    <span class="text-danger">
                        <strong id="storename-error"></strong>
                    </span>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" name="nextfytxt" id="nextfytxt" readonly="true"/></label>
                    <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true"/></label>
                    <input type="hidden" placeholder="" class="form-control" name="beginingi" id="beginingi" readonly="true" value=""/>     
                    <button id="savebutton" type="button" class="btn btn-info">Save</button>
                    <button id="closebuttonz" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Registation Modal -->

    <div class="modal fade text-left" id="stockInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Store Balance Detail</h4>
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
                                        </tr>
                                        <tr>
                                            <td><label id="itemcodeval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="itemnameval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="skunumberval" strong style="font-size: 14px;"></label></td>
                                            <td><label id="categoryval" strong style="font-size: 14px;"></label></td>
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
                                <div class="table-responsive">
                                    <table id="stockinfodetail" class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <thead>
                                            <th>Store / Shop Name</th>
                                            <th>Store Balance</th>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table style="width:100%;" id="infoTotalQuantity">
                                <tr>
                                    <td style="text-align: right;">
                                        <label id="avlbl" strong style="font-size: 16px;">Total Quantity:</label>
                                        <label id="avbalanceval" strong style="font-size: 16px;font-weight: bold;"></label>
                                    </td>
                                </tr>
                            </table>
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

<!--Start count confirmation -->
<div class="modal fade text-left" id="startcountconfirmation" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="startcountform">
                @csrf
                <div class="modal-body" style="background-color:#f6c23e">
                    <label strong style="font-size: 16px;font-weight:bold;">Do you really want to start counting?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="countid" id="countid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="storeidi" id="storeidi" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="startcountbtn" type="button" class="btn btn-info">Start Count</button>
                    <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End count confirmation -->

<!--Start Info Modal -->
  <div class="modal fade text-left" id="bgInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Counting Form</h4>
                <div>
                    <button id="printtable" type="button" style="display: none;" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Print the entire item table"><i class="fa fa-print" aria-hidden="true"></i></button>
                    <button id="downloatoexcel" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Export the entire item table to excel"><i class="fa fa-file-excel" aria-hidden="true"></i></button>
                    <button id="syncbutton" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Sync Items" style="display: none;"><i data-feather='refresh-ccw'></i></button>
                    <label id="syncProgress" class="badge badge-light-info">Syncing...</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form id="bgInfoform">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                    <span class="lead collapse-title">Basic & Action Information</span>
                                                    <div style="text-align: right;" id="statustitles"></div>
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
                                                                        <div class="row">
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Beginnig Document Number</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infodocnum"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Ending Document Number</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infodocennum"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Store / Shop Name</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infostore"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Fiscal Year</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infofiscalyear"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Start Date</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infodate"></label></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Action Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width:40%;"><label style="font-size: 14px;" strong>Counted By</label></td>
                                                                                <td style="width:60%;"><label class="font-weight-bolder infolbls" id="infocountedbyl" strong style="font-size: 14px;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td style="width: 40%"><label style="font-size: 14px;" strong>Counted Date</label></td>
                                                                                <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infocounteddatel"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label style="font-size: 14px;" strong>Verified By</label></td>
                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoverifiedbyl"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label style="font-size: 14px;" strong>Verified Date</label></td>
                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoverifieddatel"></label></td>
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
                                
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Counting Section</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <label id="countinfo" style="font-size: 16px; font-weight:bold;">Click on physical count and insert counted quantity</label>
                                    <table id="doneinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                        <thead>
                                            <th>id</th>
                                            <th>#</th>
                                            <th style="width: 7%;">Item Code</th>
                                            <th style="width: 10%;">Item Name</th>
                                            <th style="width: 8%;">SKU Number</th>
                                            <th style="width: 10%;">Category</th>
                                            <th style="width: 5%;">UOM</th>
                                            <th style="width: 10%;">Store / Shop Name</th>
                                            <th>Average Cost</th>
                                            <th>Min Selling Price</th>
                                            <th style="width: 5%;">System Count</th>
                                            <th style="width: 15%;">Physical_Count</th>
                                            <th style="width: 5%;">Variance Shortage</th>
                                            <th style="width: 5%;">Varinace Overage</th>
                                            <th style="width: 5%;"></th>
                                            <th style="width: 5%;"></th>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot><tr></tr></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card" id="infoCommentCardDiv">
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
                <div class="modal-footer">
                    @can('Begining-ChangeToCounting')
                    <button id="changetocounting" type="button" onclick="getCountingInfo()" class="btn btn-info">Change to Counting</button>
                    @endcan
                    @can('Begining-FinishCounting')
                    <button id="donebtn" type="button" onclick="getDoneInfo()" class="btn btn-info">Finish Counting</button>
                    @endcan
                    @can('Begining-Verify')
                    <button id="verifybtn" type="button" onclick="getVerifyInfo()" class="btn btn-info">Verify</button>
                    @endcan
                    @can('Begining-Post')
                    <button id="confirmbeginingbtn" type="button" onclick="getConfirminfo()" class="btn btn-info">Post Ending</button>
                    @endcan
                    <button id="closebuttonb" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Info -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="postedInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Ending Info</h4>
                    <div>
                        <button id="downloatoexcelps" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Export the entire item table to excel"><i class="fa fa-file-excel" aria-hidden="true"></i></button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                </div>
                <form id="postedinfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                                                        <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infosclpo" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Basic & Action Information</span>
                                                        <div style="text-align: right;" id="statustitlespo"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infosclpo">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <td style="width: 40%"><label style="font-size: 14px;" strong>Beginnig Document Number</label></td>
                                                                                        <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosdocnum"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Ending Document Number</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosdocennum"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Store / Shop Name</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosstore"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Fiscal Year</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosfiscalyear"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Start Date</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosdate"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width:40%;"><label style="font-size: 14px;" strong>Counted By</label></td>
                                                                                    <td style="width:60%;"><label class="font-weight-bolder infolbls" id="infocountedby" strong style="font-size: 14px;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Counted Date</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infocounteddate"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Verified By</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoverifiedby"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Verified Date</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoverifieddate"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Posted By</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infopostedby"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Posted Date</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoposteddate"></label></td>
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
                                    <div class="table-responsive">
                                        <input type="hidden" placeholder="" class="form-control" name="itemid" id="itemid" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgId" id="recbgId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgStrId" id="recbgStrId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgStatus" id="recbgStatus" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowDatai" id="editRowDatai" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowQuantityi" id="editRowQuantityi" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowUnitcosti" id="editRowUnitcosti" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Counting Section</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="postedinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <tr>
                                                    <th colspan="11" style="text-align: right;">
                                                        <label style="font-size: 16px;font-weight:bold;" id="totalcostvallblheader"></label>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>id</th>
                                                    <th>#</th>
                                                    <th>Item Code</th>
                                                    <th style="width: 30%;">Item Name</th>
                                                    <th>SKU Number</th>
                                                    <th>Category</th>
                                                    <th>UOM</th>
                                                    <th>Store / Shop Name</th>
                                                    <th style="width: 15%;">Quantity</th>
                                                    <th style="width: 18%;">Unit Cost</th>
                                                    <th style="width: 18%;">Total Cost</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <td colspan="10" style="text-align: right;"><label style="font-size: 16px; font-weight:bold;" id="totalcostlbl">Total Value</label></td>
                                                <td><label style="font-size: 16px;font-weight:bold;" id="totalcostvallbl"></label></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="commentDiv">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card" id="infoCommentCardDiv">
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
                    <div class="modal-footer">
                        <button id="closebuttonc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
                                <label strong style="font-size: 14px;">Brand</label>
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
                                <label strong style="font-size: 14px;">Model</label>
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
                                <label strong style="font-size: 14px;">Manufacture Date</label>
                                <input type="text" id="ManufactureDate" name="ManufactureDate" class="form-control" placeholder="YYYY-MM-DD" onchange="mfgDateVal();" readonly="true"/>
                                <span class="text-danger">
                                    <strong id="manfdate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="expiredatediv" style="display:none;">
                                <label strong style="font-size: 14px;">Expired Date</label>
                                <input type="text" id="ExpireDate" name="ExpireDate" class="form-control" placeholder="YYYY-MM-DD" onchange="expireDateVal();" readonly="true"/>
                                <span class="text-danger">
                                    <strong id="expiredate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="batchnumberdiv" style="display:none;">
                                <label strong style="font-size: 14px;">Batch Number</label>
                                <div class="invoice-customer">
                                    <input type="text" placeholder="Enter batch number" class="form-control" name="BatchNumber" id="BatchNumber" onkeyup="batchNumberVal();"/>       
                                    <span class="text-danger">
                                        <strong id="batchnum-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="serialnumdiv" style="display:none;">
                                <label strong style="font-size: 14px;">Serial Number</label>
                                <div class="invoice-customer">
                                    <input type="text" placeholder="Enter serial number" class="form-control" name="SerialNumber" id="SerialNumber" onkeyup="serialNumberVal();"/>       
                                    <span class="text-danger">
                                        <strong id="serialnum-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="quantitydiv" style="display:none;">
                                <label strong style="font-size: 14px;">Quantity</label>
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
                                <label strong style="font-size: 16px;"></label>
                                <div style="text-align: right;">
                                    <button id="saveSerialNum" type="button" class="btn btn-info btn-sm">Add</button>
                                    <button id="closeSerialNum" type="button" class="btn btn-danger btn-sm" style="display: none;" onclick="closeSn();"><i class="fa fa-times" aria-hidden="true"></i></button>
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
                                            <td><label strong style="font-size: 12px;">Total Qty </label></td>
                                            <td><label id="totalQuantityLbl" strong style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label strong style="font-size: 12px;">Inserted </label></td>
                                            <td><label id="insertedQuantityLbl" strong style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label strong style="font-size: 12px;">Remaining </label></td>
                                            <td><label id="remainingQuantityLbl" strong style="font-size: 12px;font-weight:bold;"></label></td>
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
                <table id="laravel-datatable-crud-sn" class="table table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>HeaderId</th>
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
                <div class="modal-footer">
                    <input type="hidden" id="tableid" class="form-control" name="tableid" readonly="true"/>
                    <input type="hidden" id="serialnumreq" class="form-control" name="serialnumreq" readonly="true"/>
                    <input type="hidden" id="expirenumreq" class="form-control" name="expirenumreq" readonly="true"/>
                    <input type="hidden" id="seritemid" class="form-control" name="seritemid" readonly="true"/>
                    <input type="hidden" id="serheaderid" class="form-control" name="serheaderid" readonly="true"/>
                    <input type="hidden" id="serstoreid" class="form-control" name="serstoreid" readonly="true"/>
                    <input type="hidden" id="storeQuantity" class="form-control" name="storeQuantity" readonly="true"/>
                    <button id="closebuttonq" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeSn();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Serial Number Registation Modal -->

<!--Start done confirmation -->
<div class="modal fade text-left" id="donecountconfirmation" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="donecountform">
                @csrf
                <div class="modal-body" style="background-color:#d9534f">
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to finish counting?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="doneid" id="doneid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="statusi" id="statusi" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="donecountbtn" type="button" class="btn btn-info">Finish Counting</button>
                    <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End done confirmation -->

<!--Start verify confirmation -->
<div class="modal fade text-left" id="verifycountconfirmation" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifycountform">
                @csrf
                <div class="modal-body" style="background-color:#f6c23e">
                    <label strong style="font-size: 16px;font-weight:bold;">Do you really want to verify counting?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="verifyid" id="verifyid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="vstatusi" id="vstatusi" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="verifyBegbtn" type="button" class="btn btn-info">Verify</button>
                    <button id="closebuttonf" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End verify confirmation -->  

<!--Start Confirm modal -->
<div class="modal fade text-left" id="postbgmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="postform">
                @csrf
                <div class="modal-body" style="background-color:#d9534f">
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to Post? </br>Warning: Ending data is posted to begining i.e., You cant adjust quantity after posting</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="postid" id="postid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="poststatus" id="poststatus" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="bgpostbtn" type="button" class="btn btn-info">Post</button>
                    <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Confirm modal -->

<!--Start Comment modal -->
<div class="modal fade text-left" id="commentModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closecommentRemVal()">
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
                        <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="Comment" id="Comment" onkeyup="commentRemVal()" autofocus></textarea>
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
                    <button id="changecountingbtn" type="button" class="btn btn-info">Change to Counting</button>
                    <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closecommentRemVal()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Comment modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="postedInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Begining Info</h4>
                    <div>
                        <button id="printtables" type="button" style="display: none;" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Print the entire item table"><i class="fa fa-print" aria-hidden="true"></i></button>
                        <button id="downloatoexcels" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Export the entire item table to excel"><i class="fa fa-file-excel" aria-hidden="true"></i></button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="postedinfoform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infosclpo" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Basic & Action Information</span>
                                                        <div style="text-align: right;" id="statustitlespo"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infosclpo">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <td style="width: 40%"><label style="font-size: 14px;" strong>Beginnig Document Number</label></td>
                                                                                        <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosdocnum"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Ending Document Number</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosdocennum"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Store / Shop Name</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosstore"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Fiscal Year</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosfiscalyear"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;" strong>Start Date</label></td>
                                                                                        <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infosdate"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width:40%;"><label style="font-size: 14px;" strong>Counted By</label></td>
                                                                                    <td style="width:60%;"><label class="font-weight-bolder infolbls" id="infocountedby" strong style="font-size: 14px;"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="width: 40%"><label style="font-size: 14px;" strong>Counted Date</label></td>
                                                                                    <td style="width: 60%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infocounteddate"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Verified By</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoverifiedby"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Verified Date</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoverifieddate"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Posted By</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infopostedby"></label></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label style="font-size: 14px;" strong>Posted Date</label></td>
                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoposteddate"></label></td>
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
                                    <div class="table-responsive">
                                        <input type="hidden" placeholder="" class="form-control" name="itemid" id="itemid" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgId" id="recbgId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgStrId" id="recbgStrId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgStatus" id="recbgStatus" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowDatai" id="editRowDatai" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowQuantityi" id="editRowQuantityi" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowUnitcosti" id="editRowUnitcosti" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Counting Section</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="postedinfodetail" class="display table-bordered table-striped table-hover dt-responsive">
                                            <thead>
                                                <tr>
                                                    <th colspan="12" style="text-align: right;">
                                                        <label style="font-size: 16px;font-weight:bold;" id="totalcostvallblheader"></label>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>id</th>
                                                    <th>#</th>
                                                    <th>Item Code</th>
                                                    <th style="width: 30%;">Item Name</th>
                                                    <th>SKU Number</th>
                                                    <th>Category</th>
                                                    <th>UOM</th>
                                                    <th>Store / Shop Name</th>
                                                    <th style="width: 15%;">Quantity</th>
                                                    <th style="width: 18%;">Unit Cost</th>
                                                    <th style="width: 18%;">Total Cost</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <td colspan="11" style="text-align: right;"><label style="font-size: 16px; font-weight:bold;" id="totalcostlbl">Total Value</label></td>
                                                <td><label style="font-size: 16px;font-weight:bold;" id="totalcostvallbl"></label></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="commentDiv">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card" id="infoCommentCardDiv">
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
                    <div class="modal-footer">
                        <button id="closebuttonc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Info -->

<script type="text/javascript">

    $(function () {
        cardSection = $('#page-block');
    });

    //Datatable read property starts
    $(document).ready( function () {
        $('#fiscalyear').select2();
        $("#ManufactureDate").datepicker({ dateFormat:"yy-mm-dd",changeYear:true,changeMonth:true,yearRange: "1990:2022"}).datepicker();
        $("#ExpireDate").datepicker({ dateFormat:"yy-mm-dd",changeYear:true,changeMonth:true,yearRange: "1990:2022"}).datepicker(); 
        $(".selectpicker").selectpicker({
        noneSelectedText : ''
        });
        $("#donebtn").show();   
        $("#changetocounting").hide();
        $("#verifybtn").hide();        
        $("#confirmbeginingbtn").hide();        
        $('#syncProgress').hide();
        $('#syncProgressa').hide();
        $('#commentDiv').hide();
        $('#synccost').hide();
        $('#updateAdjustmentItem').hide();
        $('#savenewitem').show();
        $('#ItemName').hide();
        $('#itemDiv').show();
        $('#laravel-datatable-crud').DataTable(
        {
            processing: true,
            serverSide: true,
            responsive: true,
            orderCellsTop: true,
            fixedHeader: true,
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
                url: '/endingDataApp',
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
                { data: 'beginningnumber', name: 'beginningnumber' }, 
                { data: 'Store', name: 'Store'},
                { data: 'FiscalYearRange', name: 'FiscalYearRange'},
                { data: 'Date', name: 'Date'},
                { data: 'Status', name: 'Status' }, 
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
            {
                if (aData.Status == "Ready") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                }
                else if (aData.Status == "Counting") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                }
                else if (aData.Status == "Posted") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                }
                else if (aData.Status == "Done") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
                }
                else if (aData.Status == "Verified") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
                }
                else if (aData.Status == "Rejected") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                }
            },
            
        });
    });
   //Datatable read property ends

   $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    //Reset forms or modals starts
    function closeModalWithClearValidation() 
    {
        $("#Register")[0].reset();
        $('#storename-error').html("");
        $('#store').val(null).trigger('change');
    }
    //Reset forms or modals ends

    //Start get hold number value
    $('body').on('click', '.addendbutton', function () {
        $("#inlineForm").modal('show');
        $('#tid').val("");
        $('#beginingId').val("");
        $.get("/getbgnumber",function (data) {
            $('#beginingi').val(data.bgNumber);
            var dbval=data.BeginingCount;
            var currfiscalyr=data.fyear;
            var nextfyr=parseFloat(currfiscalyr)+1;
            var rnum=(Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
            $('#commonVal').val(rnum+dbval);
            $('#nextfytxt').val(nextfyr);
            $('#beginingtitle').html("Ending Period of <b>"+data.fyear+"/07/08-"+nextfyr+"/07/07"+"</b>");
        });
        $('#savebutton').prop( "disabled", false );
        $('#savebutton').text('Save');    
    });
    //End get hold number value

    //Save Records to database starts
    $('body').on('click', '#savebutton', function(){
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/saveend',
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
                $('#savebutton').text('Saving...');
                $('#savebutton').prop( "disabled", true );
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
                    if(data.errors.beginingi)
                    {
                        $('#savebutton').text('Save');
                        $('#savebutton').prop( "disabled", false );
                        toastrMessage('error',"Document Number already exist"+' <button id="getBgNm" type="button" class="btn btn-gradient-secondary">Get New Document No.</button>',"Error");
                    }
                    if(data.errors.store)
                    {
                        $('#storename-error' ).html( data.errors.store[0] );
                        $('#savebutton').text('Save');
                        $('#savebutton').prop( "disabled", false );
                        toastrMessage('error',"Check your inputs","Error");
                    }
                }
                if(data.dberrors)
                {
                    $('#storename-error').html("The store has already been taken.");
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled",false);
                    toastrMessage('error',"Check your inputs","Error"); 
                }
                if(data.recerror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please confirm or void transactions in receivings","Error"); 
                }
                if(data.trsrcerror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please issue and receive transactions in transfer","Error");  
                }
                if(data.trdesterror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please issue and receive transactions in transfer","Error");    
                }
                if(data.reqerror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in requistions","Error");  
                }
                
                if(data.saleserror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please confirm, void or refund transactions in sales","Error");  
                }
                if(data.duplicateerror)
                {
                    $('#storename-error').html("The store/shop has already been taken.");
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Store/Shop already exist","Error");    
                }
                if(data.beginingerror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please post transactions in begining","Error");
                }
                if(data.recholderror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in receiving","Error");
                }
                if(data.salesholderror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in sales","Error"); 
                }
                if(data.salesholderror)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in sales","Error");   
                }
                if(data.success) {
                    $('#savebutton').text('Save');
                    toastrMessage('success',"Successful","Success");
                    $("#inlineForm").modal('hide');
                    $("#beginingId").val("");
                    $("#Register")[0].reset();
                    $('#store').val(null).trigger('change');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //Save records and close modal ends

    //Start show resume doc info
    $(document).on('click', '.infoCounting', function()
    {
        var st;
        var comment;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status'); 
        $.get("/showEndData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.bgHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infosdocnum').text(data.bgHeader[i].DocumentNumber);
                $('#infosdocbegnum').text(data.bgHeader[i].beginningnumber);
                $('#infosstore').text(data.bgHeader[i].Store);
                $('#infosfiscalyear').text(data.bgHeader[i].FiscalYearRange);
                $('#infosdate').text(data.bgHeader[i].Date);
                $('#infocountedby').text(data.bgHeader[i].CountedBy);
                $('#infocounteddate').text(data.bgHeader[i].CountedDate);
                $('#infoverifiedby').text(data.bgHeader[i].VerifiedBy);
                $('#infoverifieddate').text(data.bgHeader[i].VerifiedDate);
                $('#infopostedby').text(data.bgHeader[i].PostedBy);
                $('#infoposteddate').text(data.bgHeader[i].PostedDate);
                $('#infosstatus').text(data.bgHeader[i].Status);
                st=data.bgHeader[i].Status;
                $('#recbgStrId').val(data.bgHeader[i].StoreId);
                comment=data.bgHeader[i].Memo;
                $('#commentlbl').text(data.bgHeader[i].Memo);
                $('#totalcostvallbl').text(numformat(data.pricing[i].TotalCost));
                $('#totalcostvallblheader').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                $("#statustitlespo").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+st+"</span>");
                if(comment=="-"||comment=="")
                {
                    $('#infoCommentCardDiv').hide();
                }
                else if(comment!="-" && comment!="")
                {
                    $('#infoCommentCardDiv').show();
                }
            }    
        });
        $('#postedinfodetail').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        paging:true,
        searching:true,
        info:true,
        searchHighlight: true,
        "order": [[ 2, "asc" ]],
        "pagingType": "simple",
        "lengthMenu": [50,100,500,1000,2000,5000,10000,25000,50000],
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/showDetailEndPosted/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data: 'id', name: 'id','visible': false },
            { data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName'},
            { data: 'SKUNumber', name: 'SKUNumber',
                "render": function ( data, type, row, meta ) {
                    return '<a>'+'&nbsp;'+data+'</a>';
                }  
            },
            { data: 'Category', name: 'Category'},  
            { data: 'UOM', name: 'UOM'},
            { data: 'StoreName', name: 'StoreName'},  
            { data: 'Quantity', name: 'Quantity',render: $.fn.dataTable.render.number(',', '.',0, '')},  
            { data: 'UnitCost', name: 'UnitCost',render: $.fn.dataTable.render.number(',', '.', 2, '')}, 
            { data: 'BeforeTaxCost', name: 'BeforeTaxCost',render: $.fn.dataTable.render.number(',', '.', 2, '')},
            { data: 'BatchNumber', name: 'BatchNumber','visible':false},
            { data: 'SerialNumber', name: 'SerialNumber','visible':false},
            { data: 'ExpireDate', name: 'ExpireDate','visible':false},
            { data: 'ManufactureDate', name: 'ManufactureDate','visible':false},        
        ],
        });
        $(".infosclpo").collapse('show');
        $("#postedInfoModal").modal('show');
        // var iTable = $('#postedinfodetail').dataTable(); 
        // iTable.fnDraw(false);
    });
    //End show resume doc info

    //edit modal open
    $('body').on('click', '.startCounting', function () 
    {
        var recIdVar = $(this).data('id');
        var statusvals = $(this).data('status');
        var str = $(this).data('sst');
        var desStore = $(this).data('dst');
        var rtype = $(this).data('typ');
        var fyear = $(this).data('fyear');
        if(statusvals=="Ready")
        {
            $.get("/endingedit" +'/' + recIdVar , function (data) { 
                $('#storeidi').val(data.closing.store_id);
            });
            $('#countid').val(recIdVar);
            $('#startcountconfirmation').modal('show');
            $('#startcountbtn').prop( "disabled", false );
        }
        else
        {
            toastrMessage('error',"You cant count on this status","Error");    
        }
    });
    //end edit modal open

        //Start change to conting
    $('body').on('click', '#startcountbtn', function()
    {
        var registerForm = $("#startcountform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/startEndingCount',
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
                $('#startcountbtn').text('Starting...');
                $('#startcountbtn').prop( "disabled", true );
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
                    $('#startcountbtn').text('Start Count');
                    toastrMessage('success',"Counting started","Success");
                    $("#startcountconfirmation").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    var st;
                    var recordId = $('#countid').val();
                    var statusval = "Counting";
                    $("#recbgId").val(recordId);
                    $("#recbgStatus").val(statusval);
                    $.get("/showEndingData" +'/' + recordId , function (data) 
                    {     
                        var dc=data;
                        var len=data.bgHeader.length;
                        for(var i=0;i<=len;i++) 
                        {  
                            $('#infodocnum').text(data.bgHeader[i].DocumentNumber);
                            $('#infobegdocnum').text(data.bgHeader[i].beginningnumber);
                            $('#infostore').text(data.bgHeader[i].Store);
                            $('#infofiscalyear').text(data.bgHeader[i].FiscalYearRange);
                            $('#infodate').text(data.bgHeader[i].Date);
                            $('#infocountedbyl').text(data.bgHeader[i].CountedBy);
                            $('#infocounteddatel').text(data.bgHeader[i].CountedDate);
                            $('#infoverifiedbyl').text(data.bgHeader[i].VerifiedBy);
                            $('#infoverifieddatel').text(data.bgHeader[i].VerifiedDate);
                            $('#infostatus').text(data.bgHeader[i].Status);
                            st=data.bgHeader[i].Status;
                            $('#recbgStrId').val(data.bgHeader[i].StoreId);
                            $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+st+"</span>"); 
                        }    
                    })

                    $('#doneinfodetail').DataTable({
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    paging:false,
                    searching:true,
                    info:false,
                    searchHighlight: true,
                    "order": [[ 2, "asc" ]],
                    "pagingType": "simple",
                    "lengthMenu": [50,100,500,1000,2000,5000,10000,25000,50000],
                    language: { search: '', searchPlaceholder: "Search here"},
                    "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/showDetailEnding/'+recordId,
                        type: 'DELETE',
                    },
                    columns: [
                        { data: 'id', name: 'id','visible': false },
                        { data:'DT_RowIndex'},
                        { data: 'ItemCode', name: 'ItemCode' },
                        { data: 'ItemName', name: 'ItemName'},
                        { data: 'SKUNumber', name: 'SKUNumber',
                            "render": function ( data, type, row, meta ) {
                                return '<a>'+'&nbsp;'+data+'</a>';
                            }  
                        },
                        { data: 'Category', name: 'Category'},  
                        { data: 'UOM', name: 'UOM'},
                        { data: 'StoreName', name: 'StoreName'}, 
                        { data: 'AverageCost', 
                            name: 'AverageCost',
                            width:"1%",
                            "render": function ( data, type, row, meta ) {
                            var ad="";
                            return '@if(auth()->user()->can("Begining-Verify"))<div>'+numformat(data.toFixed(2))+'</div>@endif @if(!auth()->user()->can("Begining-Verify"))<div class="badge badge-light-danger">Access Denied</div>@endif';} 
                        },  
                        { data: 'MinSalePrice', name: 'MinSalePrice',render: $.fn.dataTable.render.number(',', '.',2, '')},
                        { data: 'AllQuantity', name: 'AllQuantity',render: $.fn.dataTable.render.number(',', '.',0, '')},  
                        { data: 'PhysicalCount', name: 'PhysicalCount'},
                        { data: 'ShortageVariance', name: 'ShortageVariance'},
                        { data: 'OverageVariance', name: 'OverageVariance'},
                        { data: 'action', name: 'action'}, 
                        { data: 'SerialNumberFlag', name: 'SerialNumberFlag','visible': false}, 
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if (aData.SerialNumberFlag == 1) {
                            for(var i=0;i<=9;i++){
                                $(nRow).find('td:eq('+i+')').css({"color": "#4CAF50"});
                            }
                        } 
                        $(nRow).find('td:eq(11)').css({"color": "#e74a3b","font-weight": "bold"}); 
                        $(nRow).find('td:eq(12)').css({"color": "#f6c23e","font-weight": "bold"}); 
                    }
                    });
                    $(".infoscl").collapse('show');
                    $("#bgInfoModal").modal('show');
                    // var iTable = $('#doneinfodetail').dataTable(); 
                    // iTable.fnDraw(false);
                    $("#donebtn").show();   
                    $("#changetocounting").hide();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").hide();            
                }
            },
        });
    });
    //End change to conting

    //Start show resume doc info
    $(document).on('click', '.resumeCounting', function()
    {
        var st;
        var comment;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#recbgId").val(recordId);
        $("#recbgStatus").val(statusval);
        $.get("/showResEndingData" +'/' + recordId , function (data)
        {     
            var dc=data;
            var len=data.bgHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infodocnum').text(data.bgHeader[i].DocumentNumber);
                $('#infobegdocnum').text(data.bgHeader[i].beginningnumber);
                $('#infostore').text(data.bgHeader[i].Store);
                $('#infofiscalyear').text(data.bgHeader[i].FiscalYearRange);
                $('#infodate').text(data.bgHeader[i].Date);
                $('#infocountedbyl').text(data.bgHeader[i].CountedBy);
                $('#infocounteddatel').text(data.bgHeader[i].CountedDate);
                $('#infoverifiedbyl').text(data.bgHeader[i].VerifiedBy);
                $('#infoverifieddatel').text(data.bgHeader[i].VerifiedDate);
                $('#infostatus').text(data.bgHeader[i].Status);
                st=data.bgHeader[i].Status;
                $('#recbgStrId').val(data.bgHeader[i].store_id);
                comment=data.bgHeader[i].Memo;
                $('#commentlbl').text(data.bgHeader[i].Memo);
                if(comment=="-"||comment=="")
                {
                    $('#infoCommentCardDiv').hide();
                }
                else if(comment!="-" && comment!="")
                {
                    $('#infoCommentCardDiv').show();
                }
                if(st=="Ready")
                {
                    $("#bgInfoModal").modal('show');   
                    $("#donebtn").show();   
                    $("#changetocounting").hide();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").hide();        
                    $('#synccost').hide();        
                    $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+st+"</span>");  
                }
                else if(st=="Counting")
                {
                    $("#bgInfoModal").modal('show');   
                    $("#donebtn").show();   
                    $("#changetocounting").hide();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").hide();      
                    $('#synccost').hide();      
                    $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df;font-size:16px;'>"+st+"</span>");  
                }
                else if(st=="Done")
                {
                    $("#bgInfoModal").modal('show');
                    $("#donebtn").hide();   
                    $("#changetocounting").show();
                    $("#verifybtn").show();        
                    $("#confirmbeginingbtn").hide();
                    $('#synccost').show();  
                    $("#statustitles").html("<span style='color:#858796;font-weight:bold;text-shadow;1px 1px 10px #858796;font-size:16px;'>"+st+"</span>");  
                }
                else if(st=="Verified")
                {
                    $("#bgInfoModal").modal('show');
                    $("#donebtn").hide();   
                    $("#changetocounting").show();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").show();  
                    $('#synccost').show();  
                    $("#statustitles").html("<span style='color:#5bc0de;font-weight:bold;text-shadow;1px 1px 10px #5bc0de;font-size:16px;'>"+st+"</span>"); 
                }
                else if(st=="Posted")
                {
                    toastrMessage('error',"Closing already posted","Error");
                    $('#laravel-datatable-crud').DataTable().ajax.reload();
                    $("#donebtn").hide();   
                    $("#changetocounting").hide();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").hide();  
                    $('#synccost').hide();  
                    $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+st+"</span>"); 
                }
            }       
        });

        $('#doneinfodetail').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        paging:true,
        searching:true,
        info:true,
        searchHighlight: true,
        "order": [[ 2, "asc" ]],
        "pagingType": "simple",
        "lengthMenu": [50,100,500,1000,2000,5000,10000,25000,50000],
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/showDetailEnding/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data: 'id',name: 'id','visible': false},
            { data:'DT_RowIndex'},
            { data: 'ItemCode',name: 'ItemCode' },
            { data: 'ItemName',name: 'ItemName'},
            { data: 'SKUNumber',name: 'SKUNumber',
                "render": function (data,type,row,meta) {
                    return '<a>'+'&nbsp;'+data+'</a>';
                }  
            },
            { data: 'Category',name: 'Category'},  
            { data: 'UOM',name: 'UOM'},
            { data: 'StoreName',name: 'StoreName'}, 
            { data: 'AverageCost', 
                name: 'AverageCost',
                width:"1%",
                "render": function ( data, type, row, meta ) {
                var ad="";
                return '@if(auth()->user()->can("Begining-Verify"))<div>'+numformat(data.toFixed(2))+'</div>@endif @if(!auth()->user()->can("Begining-Verify"))<div class="badge badge-light-danger">Access</br>Denied</div>@endif';} 
            },  
            { data: 'MinSalePrice', name: 'MinSalePrice',render: $.fn.dataTable.render.number(',', '.',2, '')},
            { data: 'AllQuantity',name: 'AllQuantity',render: $.fn.dataTable.render.number(',', '.',0, '')},  
            { data: 'PhysicalCount', name: 'PhysicalCount', width:"15%"},
            { data: 'ShortageVariance', name: 'ShortageVariance'},
            { data: 'OverageVariance', name: 'OverageVariance',},
            { data: 'action', name: 'action'}, 
            { data: 'SerialNumberFlag', name: 'SerialNumberFlag','visible': false}, 
        ],
        columnDefs: [{
            "width": "25%",
            targets: [9,11],
        }],
        
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var variance=0;
            var allqnt=aData.AllQuantity||0;
            var phycnt=aData.PhysicalCount||0;
            variance=parseFloat(phycnt)-parseFloat(allqnt);
            if(parseFloat(variance)<0){
                $(nRow).find('td:eq(11)').text(parseFloat(variance)*(-1)); 
                $(nRow).find('td:eq(12)').text(""); 
            }
            if(parseFloat(variance)>0){
                $(nRow).find('td:eq(12)').text(parseFloat(variance)); 
                $(nRow).find('td:eq(11)').text(""); 
            }
            if(parseFloat(variance)==0){
                $(nRow).find('td:eq(12)').text(""); 
                $(nRow).find('td:eq(11)').text(""); 
            }
            
            if (aData.SerialNumberFlag == 1) {
                for(var i=0;i<=9;i++){
                    $(nRow).find('td:eq('+i+')').css({"color": "#4CAF50"});
                }
            }
            $(nRow).find('td:eq(11)').css({"color": "#e74a3b","font-weight": "bold"}); 
            $(nRow).find('td:eq(12)').css({"color": "#f6c23e","font-weight": "bold"}); 
        }
       
        });
        $(".infoscl").collapse('show');
        // var iTable = $('#doneinfodetail').dataTable(); 
        // iTable.fnDraw(false);
    });
    //End show resume doc info

    function uccloseInput(elm) {
        var value = $(elm).find('input').val();
        var ids = $(elm).find('id').val();
        $(elm).empty().text(value);
        $(elm).bind("dblclick", function () {
            newInput(elm);
        });
        if(value=="")
        {
            toastrMessage('error',"Cost is required","Error"); 
            var ids=$("#editRowDatai").val();
            var dval="NULL";
            $.get("/updateEndingUp/"+ids+'/'+'-1'  , function (data) {});
        }
        else if(value!="")
        {
            var ids=$("#editRowDatai").val();
            $.get("/updateEndingUp/"+ids+'/'+value  , function (data) {});
        }
    }

    $('#doneinfodetail').on('click', 'tr td:not(:first-child)', function (e) {
        var rowIndex = $(this).parents("tr").index();  
        var id = $('#doneinfodetail').DataTable().row(rowIndex).data().id;
        var avqnt = $('#doneinfodetail').DataTable().row(rowIndex).data().AvailableQuantity;  
        $("#editRowDatai").val(id);
        var table = $('#doneinfodetail').DataTable();
        var colindex =table.cell(this).index().columnVisible;
        // if(colindex=="7")
        // {
        //     //debugger;
        //     //UnitCostnewInput(this);
        // }
        if(colindex=="10")
        {
            //debugger;
           newInput(this);
        } 
    });

    function newInput(elm) 
    {
        $(elm).unbind('click');
        var value = $(elm).text();
        $(elm).empty();
        $("<input id='quantityId' name='quantityVal' class='form-control numeral-mask' onkeypress='return ValidateNum(event);'>")
        .attr('type', 'number')
        .val(value)
        .blur(function () {
            closeInput(elm);
            cakculateVariance(elm);
        })
        .appendTo($(elm))
        .focus();    
    }

    function cakculateVariance(elm){
        var avqnt=$(elm).closest('tr').find('td').eq(9).text()||0;
        var cntqnt=$(elm).closest('tr').find('td').eq(10).text();
        var variance=parseFloat(cntqnt)-parseFloat(avqnt);
        if(parseFloat(variance)<0){
            $(elm).closest('tr').find('td').eq(11).text(parseFloat(variance)*(-1));
            $(elm).closest('tr').find('td').eq(12).text("");
        }
        else if(parseFloat(variance)>0){
            $(elm).closest('tr').find('td').eq(11).text("");
            $(elm).closest('tr').find('td').eq(12).text(parseFloat(variance));
        }
        else if(parseFloat(variance)==0){
            $(elm).closest('tr').find('td').eq(11).text("");
            $(elm).closest('tr').find('td').eq(12).text("");
        }
    }    

    function UnitCostnewInput(elm) 
    {
        $(elm).unbind('click');
        var value = $(elm).text();
        $(elm).empty();
        $("<input name='unitcostVal' class='form-control numeral-mask' onkeypress='return ValidateNum(event);'>")
        .attr('type', 'number')
        .val(value)
        .blur(function () {
            uccloseInput(elm);
        })
        .appendTo($(elm))
        .focus();
    }

    function closeInput(elm) {
        var rows = $('tr.immediate');
        var table = $('#doneinfodetail').DataTable();
        var data = table.row(rows).data();
        var value = $(elm).find('input').val();
        var qnt=$(elm).find('td').val();
        var ids=$("#editRowDatai").val();
        $(elm).empty().text(value);
        $(elm).bind("dblclick", function () {newInput(elm);});  
        var val=parseFloat(value);
        if(value=="")
        {
            $.get("/updateEndingQ/"+ids+'/'+'-1'  , function (data){});
        }
        else if(val<0)
        {
            $("#quantityId").val("");
            $.get("/updateEndingQ/"+ids+'/'+'-1'  , function (data){});
        }
        else if(value!="")
        {    
            $.get("/updateEndingQ/"+ids+'/'+value  , function (data){});          
        }
        //$('#doneinfodetail').DataTable().ajax.reload(null, false);
        //refreshtable();
        //var iTable = $('#doneinfodetail').dataTable(); 
        //iTable.fnDraw(false);  
        //$('#doneinfodetail').DataTable().ajax.reload();
    }
    
    //Start Show Item Info
    $('body').on('click', '.addSerialNumber', function () 
    {
        var sid = $(this).data('id');
        $.get("/showSerialNumberEnding" +'/' + sid , function (data) 
        {
            $('#seritemid').val(data.recDataId.item_id);
            $('#serheaderid').val(data.recDataId.header_id);
            $('#serstoreid').val(data.recDataId.store_id);  
            $('#storeQuantity').val(data.recDataId.Quantity);  
            $('#totalQuantityLbl').html(data.recDataId.Quantity);  
            $('#Quantity').val("1");
            $('#saveSerialNum').text('Add');
            $('#saveSerialNum').prop( "disabled", false );
            $('#serialnumbertitle').html('Register Serial number , Batch number and Expire date for <b><u>'+data.itemname+'</u></b>');
            var itemname=data.itemname;
            var reqsnm=data.reqsn;
            var reqexd=data.reqed;
            var itemq=data.recDataId.Quantity;
            var countedval=data.cnts;
            var totalvl=parseFloat(itemq)-parseFloat(countedval);
            $('#serialnumreq').val(data.reqsn);
            $('#expirenumreq').val(data.reqed);
            $('#insertedQuantityLbl').html(countedval);  
            $('#remainingQuantityLbl').html(totalvl);  
            var qnt="0";
            if(itemq===null||itemq==="0")
            {
                qnt="0";
            }
            else if(itemq!=0||itemq!=null)
            {
                qnt=itemq; 
            }
            if(reqsnm==="Not-Require" && reqexd==="Not-Require")
            {
                toastrMessage('error',"Serial number or batch number or expire date are not required for this item","Error");
            }
            else if(parseFloat(qnt)==0)
            {
                toastrMessage('error',"Please insert quantity first","Error");
            }
            else
            {
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
                var headerid=data.recDataId.header_id;
                var itemid=data.recDataId.item_id;
                var storeid=data.recDataId.store_id;
                var trtype="1";
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
                        url: '/showSerialNmEnding/'+storeid+'/'+itemid,
                        type: 'GET',
                        },
                    columns: [
                        { data: 'id', name: 'id', 'visible': false },
                        { data: 'header_id', name: 'header_id' ,'visible': false},
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
                $("#serialNumberModal").modal('show');  
            }
        });
    });

    $('#saveSerialNum').click(function()
    {
        var registerForm = $('#serialNumberRegForm');
        var formData = registerForm.serialize();
        $.ajax({
           url:'/addSerialnumbersEnding',
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
                $('#saveSerialNum').text('Adding...');
                $('#saveSerialNum').prop( "disabled", true );
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
                    toastrMessage('error',"You inserted for all quantity","Error");
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
                    var totalcnt=$('#totalQuantityLbl').text();
                    var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                    $('#remainingQuantityLbl').text(netQ);
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

    $('#brand').on('change', function () 
    {
        var sid = $('#brand').val();
        $('#modelNumber').find('option').not(':first').remove();
        var registerForm = $("#serialNumberRegForm");
        var formData = registerForm.serialize();
        $.ajax({
            url:'showModels/'+sid,
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

    //start edit serial number modal
    $('body').on('click', '.editSN', function () 
    {
        var recIdVar = $(this).data('id');
        var mod = $(this).data('mod');
        $('#modelNumber').empty();
        var options = "<option selected value="+mod+">"+mod+"</option>";
        $('#modelNumber').append(options);
        $.get("/serialnumbereditBg" +'/' + recIdVar , function (data)
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

        //Start change to done
    $('body').on('click', '#donecountbtn', function()
    {
        var registerForm = $("#donecountform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/doneEndCount',
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
                $('#donecountbtn').text('Processing...');
                $('#donecountbtn').prop( "disabled", true );
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
                        singleVal=(data['countItems'][i].ItemName);
                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                        toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+" items"+loopedVal,"Error");
                        $("#donecountconfirmation").modal('hide');
                        $('#donecountbtn').text('Finish Counting');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.descerror)
                {
                    var singleVal='';
                    var loopedVal='';
                    var len=data['descerror'].length;
                    for(var i=0;i<=len;i++) 
                    {  
                        var count=data.countedescval;
                        var inc=i+1;
                        singleVal=(data['countdescItems'][i].ItemName);
                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                        toastrMessage('error',"System count and physical count does not match for "+count+" items"+loopedVal,"Error");
                        $("#donecountconfirmation").modal('hide');
                        $('#donecountbtn').text('Finish Counting');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.success) {
                    $('#donecountbtn').text('Finish Counting');
                    toastrMessage('success',"Ending changed to Done","Success");
                    $("#donecountconfirmation").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to done

        //Start change to verify
    $('body').on('click', '#verifyBegbtn', function()
    {
        var registerForm = $("#verifycountform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/verifyEndCount',
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
                $('#verifyBegbtn').text('Verifying...');
                $('#verifyBegbtn').prop( "disabled", true );
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
                        singleVal=(data['countItems'][i].ItemName);
                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                        toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+" items"+loopedVal,"Error");
                        $("#verifycountconfirmation").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.descerror)
                {
                    var singleVal='';
                    var loopedVal='';
                    var len=data['descerror'].length;
                    for(var i=0;i<=len;i++) 
                    {  
                        var count=data.countedescval;
                        var inc=i+1;
                        singleVal=(data['countdescItems'][i].ItemName);
                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                        toastrMessage('error',"System count and physical count does not match for "+count+" items"+loopedVal,"Error");
                        $("#verifycountconfirmation").modal('hide');
                        $('#verifyBegbtn').text('Verify');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.success) {
                    $('#verifyBegbtn').text('Verify');
                    toastrMessage('success',"Ending changed to Verify","Success");
                    $("#verifycountconfirmation").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to verify

    //Start change to post
    $('body').on('click', '#bgpostbtn', function()
    {
        var registerForm = $("#postform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/postEndCount',
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
                $('#bgpostbtn').text('Posting...');
                $('#bgpostbtn').prop( "disabled", true );
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
                $('#bgpostbtn').text('Post');
                $('#bgpostbtn').prop( "disabled", false );
            },
            success:function(data) 
            { 
                if(data.descerror)
                {
                    var singleVal='';
                    var loopedVal='';
                    var count='';
                    var len=data['descerror'].length;
                    for(var i=0;i<=len;i++) 
                    {  
                        count=data.countedescval;
                        var inc=i+1;
                        singleVal=(data['countdescItems'][i].ItemName);
                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                        
                        $("#postbgmodal").modal('hide');
                        $('#verifyBegbtn').text('Verify');
                        $('#bgpostbtn').text('Post');
                        $('#bgpostbtn').prop( "disabled", false );
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }  
                    toastrMessage('error',"System count and physical count does not match for "+count+" items"+loopedVal,"Error"); 
                }
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
                        toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+" items"+loopedVal,"Error");
                        $("#postbgmodal").modal('hide');
                        $('#bgpostbtn').text('Post');
                        $('#bgpostbtn').prop( "disabled", false );
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.fyerror)
                {
                    toastrMessage('error',"Please change fiscal year in setting","Error");
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                }
                if(data.recerror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please confirm or void transactions in receivings","Error");  
                }
                if(data.trsrcerror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in transfer","Error");     
                }
                if(data.trdesterror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in transfer","Error");
                }
                if(data.reqerror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please issue transactions in requistions","Error");     
                }
                if(data.adjerror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please confirm transactions in adjustment","Error");  
                }
                if(data.saleserror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please confirm, void or refund transactions in sales","Error");        
                }
                if(data.beginingerror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please post transactions in begining","Error");   
                }
                if(data.recholderror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in receiving","Error");      
                }
                if(data.salesholderror)
                {
                    $("#postbgmodal").modal('hide');
                    $('#bgpostbtn').text('Post');
                    $('#bgpostbtn').prop( "disabled", false );
                    toastrMessage('error',"Please settle a hold transaction in sales","Error");                   
                }
                if(data.success) 
                {
                    $('#bgpostbtn').text('Post');
                    toastrMessage('success',"Closing Posted","Success");
                    $("#postbgmodal").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to post

    //Start sync button
    $('body').on('click', '#syncbutton', function()
    {
        var countval="";
        var syncForm = $("#postedinfoform");
        var formData = syncForm.serialize();
        $.ajax({
           url:'/syncEndItem',
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
                $('#syncbutton').prop( "disabled", true );
                $('#syncbutton').hide();
                $('#syncProgress').show();
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
                    countval=data['syncCount'][0].Count;
                    toastrMessage('error',countval+" Item Synced","Error");
                    $("#bgInfoform")[0].reset();
                    var oTable = $('#doneinfodetail').dataTable(); 
                    oTable.fnDraw(false);
                    $('#syncbutton').prop( "disabled", false );
                    $('#syncbutton').show();
                    $('#syncProgress').hide();
                }
            },
        });
    });
    //End sync button

        //Start change to counting
    $('body').on('click', '#changecountingbtn', function()
    {
        var registerForm = $("#commentform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/commentEndCount',
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
                $('#changecountingbtn').text('Changing...');
                $('#changecountingbtn').prop( "disabled", true );
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
                    if(data.errors.Comment)
                    {
                        $('#comment-error').html(data.errors.Comment[0] );
                    }
                    $('#changecountingbtn').text('Change to Counting');
                    $('#changecountingbtn').prop( "disabled", false );
                    toastrMessage('error',"Check your inputs","Error");
                }
                if(data.success) 
                {
                    $('#changecountingbtn').text('Change to Counting');
                    toastrMessage('success',"Closing changed to counting","Success");
                    $("#commentModal").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to counting

    //Start Print Attachment
    $('body').on('click', '.printAttachment', function () 
    {
        var id = $(this).data('id');
        var link=$(this).data('link');
        window.open(link, 'Adj', 'width=1200,height=800,scrollbars=yes');
    });

    $('body').on('click', '.printBgAttachment', function () 
    {
        var id = $(this).data('id');
        var link=$(this).data('link');
        window.open(link, 'Adj', 'width=1200,height=800,scrollbars=yes');
    });
    //End Print Attachment

    function getDoneInfo()
    {
        var recId=$('#recbgId').val();
        var recStoreId=$('#recbgStrId').val();
        var recStatus=$('#recbgStatus').val();
        $('#doneid').val(recId);
        $('#donecountconfirmation').modal('show');
        $('#donecountbtn').prop( "disabled", false );
    }

    function getVerifyInfo()
    {
        var recId=$('#recbgId').val();
        var recStoreId=$('#recbgStrId').val();
        var recStatus=$('#recbgStatus').val();
        $('#verifyid').val(recId);
        $('#verifycountconfirmation').modal('show');
        $('#verifyBegbtn').prop( "disabled", false );
    }

    function getConfirminfo()
    {
        var recId=$('#recbgId').val();
        var recStoreId=$('#recbgStrId').val();
        var recStatus=$('#recbgStatus').val();
        $('#postid').val(recId);
        $('#postbgmodal').modal('show');
        $('#bgpostbtn').prop( "disabled", false );
    }

    function getCountingInfo()
    {
        var recId=$('#recbgId').val();
        var recStoreId=$('#recbgStrId').val();
        var recStatus=$('#recbgStatus').val();
        $('#commentid').val(recId);
        $('#Comment').val("");
        $('#commentModal').modal('show');
        $('#changecountingbtn').prop( "disabled", false );
        $('#Comment').focus();
    }

    function numformat(val)
    {
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }

    //Start sync button
    function refreshtable() 
    {
        var iTable = $('#doneinfodetail').dataTable(); 
        iTable.fnDraw(false);  
    }
    //End sync button

    function storeVal() 
    {
        $('#storename-error').html("");
    }

    function brandVal() 
    {
        $( '#brand-error' ).html("");
    }

    function closecommentRemVal() 
    {
        $('#comment-error').html("");
        $("#commentform")[0].reset();
    }

    function commentRemVal() 
    {
        $( '#comment-error' ).html("");
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
        $('#laravel-datatable-crud').DataTable(
        {
            destroy:true,
            processing: true,
            serverSide: true,
            responsive: true,
            orderCellsTop: true,
            fixedHeader: true,
            searchHighlight: true,
            "order": [[ 0, "desc" ]],
            "pagingType": "simple",
            "lengthMenu": [50,100],
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
                url: '/showEndingDataFy/'+fy,
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
                { data: 'beginningnumber', name: 'beginningnumber' }, 
                { data: 'Store', name: 'Store'},
                { data: 'FiscalYearRange', name: 'FiscalYearRange'},
                { data: 'Date', name: 'Date'},
                { data: 'Status', name: 'Status' }, 
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
            {
                if (aData.Status == "Ready") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                }
                else if (aData.Status == "Counting") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                }
                else if (aData.Status == "Posted") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                }
                else if (aData.Status == "Done") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
                }
                else if (aData.Status == "Verified") 
                {
                    $(nRow).find('td:eq(6)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
                }
                else if (aData.Status == "Rejected") 
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
    });

    $('#printtable').click(function(){
        let tbl = document.getElementById('doneinfodetail');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("doneinfodetail");
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
    });

    $("#downloatoexcel").click(function(){
        let tbl = document.getElementById('doneinfodetail');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#doneinfodetail").table2excel({
        name: "Worksheet Name",
        filename: "EndingDetailTable", //do not include extension
        fileext: ".xls" // file extension
        });
    });

    $("#downloatoexcelps").click(function(){
        let tbl = document.getElementById('postedinfodetail');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#postedinfodetail").table2excel({
        name: "Worksheet Name",
        filename: "PostedEndingDetailTable", //do not include extension
        fileext: ".xls" // file extension
        });
    });

    $('#printtable').click(function(){
        let tbl = document.getElementById('postedinfodetail');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("postedinfodetail");
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
    });

    $("#downloatoexcels").click(function(){
        let tbl = document.getElementById('postedinfodetail');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#postedinfodetail").table2excel({
        name: "Worksheet Name",
        filename: "EndingPostedItem", //do not include extension
        fileext: ".xls" // file extension
        });
    });

    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
</script>   
@endsection
  