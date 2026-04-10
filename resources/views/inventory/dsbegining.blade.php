@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Begining-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">DS Beginning</h3>
                        <div style="width:19%;display:none;">
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
                        <button type="button" class="btn btn-gradient-info btn-sm addbuttonbeg" data-toggle="modal">Add</button>
                        @endcan
                        </div>
                    </div>
                    <div class="card-datatable">
                        <div style="width:98%; margin-left:1%;">
                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 0%;">Id</th>
                                        <th style="width: 0%;">#</th>
                                        <th style="width: 20%;">Document No.</th>
                                        <th style="width: 20%;">Ending Document No.</th>
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

  <!--Start Info Modal -->
  <div class="modal fade text-left" id="bgInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Counting Form</h4>
                <div>
                    @can('Begining-Verify')
                    <button id="synccost" type="button" class="btn btn-gradient-info btn-sm synccost" onclick="startSyncCost()" data-toggle="modal">Sync Cost</button>
                    @endcan
                    <button id="printtable" type="button" style="display: none;" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Print the entire item table"><i class="fa fa-print" aria-hidden="true"></i></button>
                    <button id="downloatoexcel" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Export the entire item table to excel"><i class="fa fa-file-excel" aria-hidden="true"></i></button>
                    <button id="syncbutton" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Sync Items"><i data-feather='refresh-ccw'></i></button>
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
                                                                                <tr style="display: none;">
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
                                <div class="table-responsive">
                                    
                                </div>
                                
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Counting Section</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive scroll scrdiv">
                                    <label id="countinfo" style="font-size: 16px; font-weight:bold;">Click on Quantity or Cost to Adjust</label>
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
                                            <th style="width: 10%;">Min Sale Price (Before VAT)</th>
                                            <th style="width: 18%;">Quantity</th>
                                            <th style="width: 25%;">Unit Cost (Before VAT)</th>
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
                    <button id="confirmbeginingbtn" type="button" onclick="getConfirminfo()" class="btn btn-info">Post Begining</button>
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
                                                                                    <tr style="display: none;">
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
                                                    <th>Store/Shop Name</th>
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

      <!--Start Info Modal -->
    <div class="modal fade text-left" id="adjustmentModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Adjustment</h4>
                    <div>
                        <button id="syncbuttona" type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" title="Sync Items"><i data-feather='refresh-ccw'></i></button>
                        <label id="syncProgressa" class="badge badge-light-info">Syncing...</label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form id="adjustmentform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <input type="hidden" placeholder="" class="form-control" name="adjitemid" id="adjitemid" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="adjrecbgId" id="adjrecbgId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgStrId" id="adjrecbgStrId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="itemid" id="itemid" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgId" id="adjHeaderId" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="recbgStatus" id="recbgStatus" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowDatai" id="editRowDatai" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowQuantityi" id="editRowQuantityi" readonly="true">
                                        <input type="hidden" placeholder="" class="form-control" name="editRowUnitcosti" id="editRowUnitcosti" readonly="true">
                                        <table class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                            <tr>
                                                <th><label strong style="font-size: 14px;">DS Document Number</label></th>
                                                <th><label strong style="font-size: 14px;">Store / Shop Name</label></th>
                                                <th style="display: none;"><label strong style="font-size: 14px;display:none;">Fiscal Year</label></th>
                                                <th><label strong style="font-size: 14px;">Start Date</label></th>
                                                <th><label strong style="font-size: 14px;">Counted By</label></th>
                                                <th><label strong style="font-size: 14px;">Counted Date</label></th>
                                                <th><label strong style="font-size: 14px;">Verified By</label></th>
                                                <th><label strong style="font-size: 14px;">Verified Date</label></th>
                                                <th><label strong style="font-size: 14px;">Posted By</label></th>
                                                <th><label strong style="font-size: 14px;">Posted Date</label></th>
                                                <th><label strong style="font-size: 14px;">Status</label></th>
                                            </tr>
                                            <tr>
                                                <td><label id="adjinfosdocnum" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfosstore" strong style="font-size: 14px;"></label></td>
                                                <td style="display: none;"><label id="adjinfosfiscalyear" strong style="font-size: 14px;display:none;"></label></td>
                                                <td><label id="adjinfosdate" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfocountedby" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfocounteddate" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfoverifiedby" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfoverifieddate" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfopostedby" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfoposteddate" strong style="font-size: 14px;"></label></td>
                                                <td><label id="adjinfosstatus" strong style="font-size: 14px;"></label></td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">-</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <table id="adjustmentdetail" class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                            <thead>
                                                <tr>
                                                <th></th>
                                                    <th colspan="11">
                                                        <button type="button" name="addnew" id="addnew" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newItemModal" onclick="getInfo();"><i data-feather='plus'></i> Add New</button>
                                                        <div style="text-align: right; margin-top:-30px;">
                                                            <label style="font-size: 16px;font-weight:bold;" id="adjtotalcostvallblheader"></label>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Item Code</th>
                                                    <th style="width: 30%;">Item Name</th>
                                                    <th>SKU Number</th>
                                                    <th>Category</th>
                                                    <th>UOM</th>
                                                    <th>Store / Shop Name</th>
                                                    <th style="width: 15%;">Quantity</th>
                                                    <th style="width: 18%;">Unit Cost</th>
                                                    <th style="width: 18%;">Total Cost</th>
                                                    <th style="width:15%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <td colspan="11"><button type="button" name="addnew" id="addnewf" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newItemModal" onclick="getInfo();"><i data-feather='plus'></i> Add New</button><div style="text-align: right; margin-top:-30px;"><label style="font-size: 16px; font-weight:bold;" id="adjtotalcostvallbl"></label></div></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <!-- End Info -->


      <!--Start add new adjustment modal -->
 <div class="modal fade text-left" id="newItemModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="adjustmentModalTitle">New Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeSaveNewModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="adjNewItemForm">
                @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <table style="width:100%">
                                    <tr>
                                        <td>
                                            <label strong style="font-size: 14px;">Item Name</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">UOM</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Min. Selling Price</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Quantity</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Unit Cost(Before VAT)</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Total Cost</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 30%">
                                            <div id="itemDiv">
                                                <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="Item" id="Item" onchange="itemVal()" style="width: 30%">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($itemSrc as $itemSrc)
                                                        <option value="{{$itemSrc->ItemId}}">{{$itemSrc->Code}}    ,    {{$itemSrc->ItemName}}    ,     {{$itemSrc->SKUNumber}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" name="ItemName" placeholder="ItemName" id="ItemName" class="form-control"  readonly style="font-weight:bold;"/>
                                            
                                        </td>
                                        <td style="width: 10%">
                                            <input type="text" name="uoms" placeholder="UOM" id="uoms" class="form-control"  readonly style="font-weight:bold;"/>
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" name="MinSelling" placeholder="Minimum Selling Price" id="MinSelling" class="form-control" readonly style="font-weight:bold;"/>
                                        </td>
                                        <td>
                                            <input type="number" name="beginingQuantity" placeholder="Quantity" id="beginingQuantity" class="beginingQuantity form-control" onkeyup="CalculateTotalCost(this)" onkeypress="return ValidateNum(event);" onkeydown="validateQuantityVal();" ondrop="return false;" onpaste="return false;"/>
                                            <input type="hidden" name="hiddenQuantity" placeholder="Quantity" id="hiddenQuantity" class="hiddenQuantity form-control" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/>
                                        </td>
                                        <td>
                                            <input type="number" name="BeginingUnitCost" placeholder="Unit Cost" id="BeginingUnitCost" class="BeginingUnitCost form-control" onkeyup="CalculateTotalCost(this)" onkeypress="return ValidateNum(event);" onkeydown="validateUnitcostVal();" ondrop="return false;" onpaste="return false;"/>
                                        </td>
                                        <td>
                                            <input type="number" name="TotalCost" placeholder="Total Cost" id="TotalCost" class="TotalCost form-control"  readonly style="font-weight:bold;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="Item-error"></strong>
                                            </span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="Quantity-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="UnitCost-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="TotalCost-error"></strong>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <input type="hidden" placeholder="" class="form-control" name="itemidi" id="itemidi" readonly="true">
                    <input type="hidden" placeholder="" class="form-control" name="storeidadj" id="storeidadj" readonly="true">
                    <input type="hidden" placeholder="" class="form-control" name="headeridi" id="headeridi" readonly="true">
                    <button id="updateAdjustmentItem" type="button" class="btn btn-info">Update</button>
                    <button id="savenewitem" type="button" class="btn btn-info">Save</button>
                    <button id="closebuttona" type="button" class="btn btn-danger" onclick="closeSaveNewModal()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End add new adjustment Modal -->

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
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to Post?</br>Warning: If you Post this Begining you cant adjust Quantity or Unit price</label>
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

<!--Start Sync Cost confirmation -->
<div class="modal fade text-left" id="syncCostConfirmationModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="syncCostForm">
                @csrf
                <div class="modal-body">
                    <label strong style="font-size: 16px;font-weight:bold;">Do you really want to sync cost from latest store/shop?</label>
                    <div class="divider">
                        <div class="divider-text">Select Store to Sync</div>
                    </div>
                    <div>
                        <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="SyncStore" id="SyncStore" onchange="syncStoreVal()">
                            <option selected disabled value=""></option>
                            @foreach ($syncStoreSrc as $syncStoreSrc)
                                <option value="{{$syncStoreSrc->id}}">{{$syncStoreSrc->Name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="text-danger">
                        <strong id="store-error"></strong>
                    </span>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="syncheaderid" id="syncheaderid" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="syncCostBtn" type="button" class="btn btn-info">Sync Cost</button>
                    <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeConfmodal()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End sync cost confirmation -->   

<!--Start item remove modal -->
<div class="modal fade text-left" id="postedRemoveModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="removeItemModal">
                @csrf
                <div class="modal-body" style="background-color:#d9534f">
                    <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to remove this item?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="removeRecordId" id="removeRecordId" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="removeStoreId" id="removeStoreId" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="removeItemId" id="removeItemId" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="removeItemQuantity" id="removeItemQuantity" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="removeHeaderId" id="removeHeaderId" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deletePostedItem" type="button" class="btn btn-info">Delete</button>
                    <button id="closebuttonp" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
                    <label strong style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="sid" id="sid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="totalBegQuantity" id="totalBegQuantity" readonly="true">
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


<script  type="text/javascript">
    $(function () {
        cardSection = $('#page-block');
    });
    //Reset forms or modals starts
    function closeModalWithClearValidation() 
    {
        $("#Register")[0].reset();
        $('#storename-error').html("");
        $('#store').val(null).trigger('change');
    }
    //Reset forms or modals ends

    //Remove error messages on keyup event starts
    function removeNameValidation() 
    {
        $( '#name-error' ).html("");
        $( '#uname-error' ).html("");
    }
    
    function storeVal() 
    {
        $( '#storename-error' ).html("");
    }
    //Remove error messages on keyup event ends

    //Datatable read property starts
    $(document).ready( function () {

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
            destroy: true,
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
                url: '/dsbeginingDataApp',
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
                { data: 'EndingDocumentNo', name: 'EndingDocumentNo', 'visible': false},
                { data: 'Store', name: 'Store'},
                { data: 'FiscalYearRange', name: 'FiscalYearRange', 'visible': false},
                { data: 'Date', name: 'Date'},
                { data: 'Status', name: 'Status' }, 
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
            {
                if (aData.Status == "Ready") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                }
                else if (aData.Status == "Counting") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                }
                else if (aData.Status == "Posted") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                }
                else if (aData.Status == "Done") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
                }
                else if (aData.Status == "Verified") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
                }
                else if (aData.Status == "Rejected") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
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

    //Start get hold number value
    $('body').on('click', '.addbuttonbeg', function () {
        $("#inlineForm").modal('show');
        $('#tid').val("");
        $('#beginingId').val("");
        $.get("/getdsbgnumber"  , function (data) {
            $('#beginingi').val(data.bgNumber);
            var dbval=data.BeginingCount;
            var rnum=(Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
            $('#commonVal').val(rnum+dbval);
            $('#beginingtitle').text("DS Begining Form");
        });
        $('#store').select2
        ({
            placeholder: "Select Store/Shop here",
        });
        $('#savebutton').prop( "disabled", false );
        $('#savebutton').text('Save');    
        $('#savebutton').show();    
    });
    //End get hold number value

    //Save Records to database starts
    $('body').on('click', '#savebutton', function(){
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dssavebg',
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
                        toastrMessage('error',"Check Your Inputs","Error"); 
                    }
                }
                if(data.requirederror)
                {
                    $('#storename-error').html("The store/shop field is required.");
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Store/shop is required","Error");
                }
                if(data.duplicateerror)
                {
                    $('#storename-error').html("The store/shop has already been taken.");
                    $('#savebutton').text('Save');
                    $('#savebutton').prop( "disabled", false );
                    toastrMessage('error',"Store/shop already exist","Error");  
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

    //Start get hold number value
    $('body').on('click', '#getBgNm', function () {
        $.get("/dsgetbgnumber" , function (data) {
            $('#beginingi').val(data.bgNumber);
            $("#myToast").toast('hide');
        });
    });
    //End get hold number value

    //Start change to conting
    $('body').on('click', '#startcountbtn', function()
    {
        var registerForm = $("#startcountform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dsstartCount',
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
                    $.get("/dsshowBgData" +'/' + recordId , function (data) 
                    {     
                        var dc=data;
                        var len=data.bgHeader.length;
                        for(var i=0;i<=len;i++) 
                        {  
                            $('#infodocnum').text(data.bgHeader[i].DocumentNumber);
                            $('#infostore').text(data.bgHeader[i].Store);
                            $('#infofiscalyear').text(data.bgHeader[i].FiscalYear);
                            $('#infodate').text(data.bgHeader[i].Date);
                            $('#infocountedbyl').text(data.bgHeader[i].CountedBy);
                            $('#infocounteddatel').text(data.bgHeader[i].CountedDate);
                            $('#infoverifiedbyl').text(data.bgHeader[i].VerifiedBy);
                            $('#infoverifieddatel').text(data.bgHeader[i].VerifiedDate);
                            $('#infostatus').text(data.bgHeader[i].Status);
                            st=data.bgHeader[i].Status;
                            $('#recbgStrId').val(data.bgHeader[i].StoreId);
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
                        url: '/dsshowDetailBg/'+recordId,
                        type: 'DELETE',
                        },
                    columns: [
                        { data: 'id', name: 'id','visible': false },
                        { data:'DT_RowIndex'},
                        { data: 'ItemCode', name: 'ItemCode' },
                        { data: 'ItemName', name: 'ItemName'},
                        { data: 'SKUNumber', name: 'SKUNumber'},
                        { data: 'Category', name: 'Category'},  
                        { data: 'UOM', name: 'UOM'},
                        { data: 'StoreName', name: 'StoreName'}, 
                        { data: 'MinSalePrice', name: 'MinSalePrice'}, 
                        { data: 'Quantity', name: 'Quantity'},  
                        { data: 'UnitCost', name: 'UnitCost'},    
                        { data: 'action', name: 'action'}, 
                        { data: 'SerialNumberFlag', name: 'SerialNumberFlag','visible': false}, 
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if (aData.SerialNumberFlag == 1) {
                            for(var i=0;i<=11;i++){
                                $(nRow).find('td:eq('+i+')').css({"color": "#4CAF50"});
                            }
                        } 
                    }
                    });
                    $("#bgInfoModal").modal('show');
                    var iTable = $('#doneinfodetail').dataTable(); 
                    iTable.fnDraw(false);
                    $("#donebtn").show();   
                    $("#changetocounting").hide();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").hide();            
                }
            },
        });
    });
    //End change to conting

    //Start sync button
    $('body').on('click', '#syncbutton', function()
    {
        var countval="";
        var syncForm = $("#postedinfoform");
        var formData = syncForm.serialize();
        $.ajax({
           url:'/dssyncItem',
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
                    toastrMessage('success',countval+" Item Synced","Success");
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

    //Start sync button
    $('body').on('click', '#syncbuttona', function()
    {
        var countval="";
        var syncForm = $("#adjustmentform");
        var formData = syncForm.serialize();
        $.ajax({
           url:'/dssyncItem',
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
                $('#syncbuttona').prop( "disabled", true );
                $('#syncbuttona').hide();
                $('#syncProgressa').show();
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
                    $('#syncbuttona').prop( "disabled", false );
                    $('#syncbuttona').show();
                    $('#syncProgressa').hide();
                }
            },
        });
        window.location.reload();
    });
    //End sync button

    //Start sync cost button
    $('body').on('click', '#syncCostBtn', function()
    {
        var countval="";
        var syncForm = $("#syncCostForm");
        var formData = syncForm.serialize();
        $.ajax({
           url:'/dssyncCost',
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
                $('#syncCostBtn').prop( "disabled", true );
                $('#syncCostBtn').text('Syncing...');
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
                    if(data.errors.SyncStore)
                    {
                        $('#store-error').html(data.errors.SyncStore[0] );
                    }
                    $('#syncCostBtn').text('Sync Cost');
                    $('#syncCostBtn').prop("disabled",false);
                    toastrMessage('error',"Check your inputs","Error");
                }
                if(data.success)
                {
                    countval=data['syncCount'][0].Count;
                    toastrMessage('success',countval+" Cost Synced","Success");
                    $("#bgInfoform")[0].reset();
                    var oTable = $('#doneinfodetail').dataTable(); 
                    oTable.fnDraw(false);
                    $('#syncCostBtn').prop( "disabled", false );
                    $("#syncCostConfirmationModal").modal('hide');
                    $('#syncCostBtn').text('Sync Cost');
                    $('#SyncStore').val(null).trigger('change');
                }
            },
        });
    });
    //End sync cost button

    //edit modal open
    $('body').on('click', '.editBegining', function () 
    {
        var recIdVar = $(this).data('id');
        var statusvals = $(this).data('status');
        var str = $(this).data('sst');
        var desStore = $(this).data('dst');
        var rtype = $(this).data('typ');
        var fyear = $(this).data('fyear');
        if(statusvals=="Approved"||statusvals=="Rejected"||statusvals=="Issued")
        {
            toastrMessage('error',"You cant update on this status","Error");
        }
        else
        {
            $('#beginingId').val(recIdVar);
            $.get("/dsbeginingedit" +'/' + recIdVar , function (data) { 
                $('#store').selectpicker('val',data.begining.StoreId);
                $('#beginingtitle').text("Begining Form (Fiscal Year: "+data.begining.FiscalYear+")");
            });
            $('#inlineForm').modal('show');
            $('#savebutton').prop( "disabled", false );
            $('#savebutton').text('Save');
        }
    });
    //end edit modal open

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
            $.get("/dsbeginingedit" +'/' + recIdVar , function (data) { 
                $('#storeidi').val(data.begining.StoreId); 
            });
            $('#countid').val(recIdVar);
            $('#startcountconfirmation').modal('show');
            $('#startcountbtn').prop("disabled",false);
        }
        else
        {
            toastrMessage('error',"You cant count on this status","Error");   
        }
    });
    //end edit modal open

    //Start show resume doc info
    $(document).on('click', '.resumeDsCounting', function()
    {
        var st;
        var comment;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status');
        $("#recbgId").val(recordId);
        $("#recbgStatus").val(statusval);

        $.get("/dsshowBgData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.bgHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infodocnum').text(data.bgHeader[i].DocumentNumber);
                $('#infostore').text(data.bgHeader[i].Store);
                $('#infofiscalyear').text(data.bgHeader[i].FiscalYear);
                $('#infodate').text(data.bgHeader[i].created_at);
                $('#infocountedbyl').text(data.bgHeader[i].CountedBy);
                $('#infocounteddatel').text(data.bgHeader[i].CountedDate);
                $('#infoverifiedbyl').text(data.bgHeader[i].VerifiedBy);
                $('#infoverifieddatel').text(data.bgHeader[i].VerifiedDate);
                $('#infostatus').text(data.bgHeader[i].Status);
                st=data.bgHeader[i].Status;
                $('#recbgStrId').val(data.bgHeader[i].StoreId);
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
                    toastrMessage('error',"Begining already posted","Error");
                    $('#laravel-datatable-crud').DataTable().ajax.reload();
                    $("#donebtn").hide();   
                    $("#changetocounting").hide();
                    $("#verifybtn").hide();        
                    $("#confirmbeginingbtn").hide();  
                    $('#synccost').hide();  
                    $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+st+"</span>");
                }
            }    
        })
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
            url: '/dsshowDetailBg/'+recordId,
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
            { data: 'id', name: 'id','visible': false },
            { data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName'},
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'Category', name: 'Category'},  
            { data: 'UOM', name: 'UOM'},
            { data: 'StoreName', name: 'StoreName'}, 
            { data: 'MinSalePrice', name: 'MinSalePrice'}, 
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'UnitCost', name: 'UnitCost'},     
            { data: 'action', name: 'action' },
            { data: 'SerialNumberFlag', name: 'SerialNumberFlag','visible': false}, 
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData.SerialNumberFlag == 1) {
                for(var i=0;i<=11;i++){
                    $(nRow).find('td:eq('+i+')').css({"color": "#4CAF50"});
                }
            } 
        }
        });
        // var iTable = $('#doneinfodetail').dataTable(); 
        // iTable.fnDraw(false);
        $(".infoscl").collapse('show');
    });
    //End show resume doc info

    //Start show resume doc info
    $(document).on('click', '.infoDsCounting', function()
    {
        var st;
        var comment;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status'); 
        $.get("/dsshowBgData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.bgHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#infosdocnum').text(data.bgHeader[i].DocumentNumber);
                $('#infosstore').text(data.bgHeader[i].Store);
                $('#infosfiscalyear').text(data.bgHeader[i].FiscalYearRange);
                $('#infosdate').text(data.bgHeader[i].created_at);
                $('#infocountedby').text(data.bgHeader[i].CountedBy);
                $('#infocounteddate').text(data.bgHeader[i].CountedDate);
                $('#infoverifiedby').text(data.bgHeader[i].VerifiedBy);
                $('#infoverifieddate').text(data.bgHeader[i].VerifiedDate);
                $('#infopostedby').text(data.bgHeader[i].PostedBy);
                $('#infoposteddate').text(data.bgHeader[i].PostedDate);
                st=data.bgHeader[i].Status;
                $("#statustitlespo").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>"+st+"</span>");
                
                $('#recbgStrId').val(data.bgHeader[i].StoreId);
                comment=data.bgHeader[i].Memo;
                $('#commentlbl').text(data.bgHeader[i].Memo);
                $('#totalcostvallbl').text(numformat(data.pricing[i].TotalCost));
                $('#totalcostvallblheader').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                
                if(comment=="-"||comment=="")
                {
                    $('#infoCommentCardDiv').hide();
                }
                else if(comment!="-" && comment!="")
                {
                    $('#infoCommentCardDiv').show();
                }
            }    
        })
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
            url: '/dsshowDetailBgPosted/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data: 'id', name: 'id','visible': false },
            { data:'DT_RowIndex'},
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName',
              width:"50%",
                "render": function ( data, type, row, meta ) {
                    //return '<div><u>'+data+'</u></br>'+row.BatchNumberandSerialNumber+'</div>';
                   // return '<div><u>'+data+'</u><br/><table><tr><td>Batch#</td><td>Serial#</td><td>ExpiredDate</td><td>ManfacDate</td></tr><tr><td>'+row.BatchNumber+'</td><td>'+row.SerialNumber+'</td><td>'+row.ExpireDate+'</td><td>'+row.ManufactureDate+'</td></tr></table></div>'
                   return data
                }    
            },
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'Category', name: 'Category'},  
            { data: 'UOM', name: 'UOM'},
            { data: 'StoreName', name: 'StoreName'},  
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'UnitCost', name: 'UnitCost',render: $.fn.dataTable.render.number(',', '.', 2, '')}, 
            { data: 'BeforeTaxCost', name: 'BeforeTaxCost',render: $.fn.dataTable.render.number(',', '.', 2, '')},
            { data: 'BatchNumber', name: 'BatchNumber','visible': false },
            { data: 'SerialNumber', name: 'SerialNumber','visible': false },
            { data: 'ExpireDate', name: 'ExpireDate','visible': false },
            { data: 'ManufactureDate', name: 'ManufactureDate','visible': false },         
        ],
        });
        $(".infosclpo").collapse('show');
        $("#postedInfoModal").modal('show');
        // var iTable = $('#postedinfodetail').dataTable(); 
        // iTable.fnDraw(false);
    });
    //End show resume doc info

    //Start show resume doc info
    $(document).on('click', '.adjustmentBegining', function()
    {
        var st;
        var comment;
        var recordId = $(this).data('id');
        var statusval = $(this).data('status'); 
        $("#adjHeaderId").val(recordId);
        $.get("/dsshowBgData" +'/' + recordId , function (data) 
        {     
            var dc=data;
            var len=data.bgHeader.length;
            for(var i=0;i<=len;i++) 
            {  
                $('#adjinfosdocnum').text(data.bgHeader[i].DocumentNumber);
                $('#adjinfosstore').text(data.bgHeader[i].Store);
                $('#adjinfosfiscalyear').text(data.bgHeader[i].FiscalYear);
                $('#adjinfosdate').text(data.bgHeader[i].Date);
                $('#adjinfocountedby').text(data.bgHeader[i].CountedBy);
                $('#adjinfocounteddate').text(data.bgHeader[i].CountedDate);
                $('#adjinfoverifiedby').text(data.bgHeader[i].VerifiedBy);
                $('#adjinfoverifieddate').text(data.bgHeader[i].VerifiedDate);
                $('#adjinfopostedby').text(data.bgHeader[i].PostedBy);
                $('#adjinfoposteddate').text(data.bgHeader[i].PostedDate);
                $('#adjinfosstatus').text(data.bgHeader[i].Status);
                st=data.bgHeader[i].Status;
                $('#adjrecbgStrId').val(data.bgHeader[i].StoreId);
                $('#adjtotalcostvallbl').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                $('#adjtotalcostvallblheader').text("Total Value : "+numformat(data.pricing[i].TotalCost));
            }    
        });

        $('#adjustmentdetail').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        paging:true,
        searching:true,
        info:true,
        "order": [[ 2, "asc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/dsshowAdjData/'+recordId,
            type: 'DELETE',
            },
        columns: [
            { data: 'id', name: 'id','visible': false },
            { data: 'ItemCode', name: 'ItemCode' },
            { data: 'ItemName', name: 'ItemName'},
            { data: 'SKUNumber', name: 'SKUNumber'},
            { data: 'Category', name: 'Category'},  
            { data: 'UOM', name: 'UOM'},
            { data: 'StoreName', name: 'StoreName'},  
            { data: 'Quantity', name: 'Quantity'},  
            { data: 'UnitCost', name: 'UnitCost'}, 
            { data: 'BeforeTaxCost', name: 'BeforeTaxCost'},    
            { data: 'action', name: 'action' },     
        ],
        });
        $("#adjustmentModal").modal('show');
        var iTable = $('#adjustmentdetail').dataTable(); 
        iTable.fnDraw(false);
    });
    //End show resume doc info

    
    $('#doneinfodetail').on( 'click', 'tr td:not(:first-child)', function (e) {
        var rowIndex = $(this).parents("tr").index();  
        var id = $('#doneinfodetail').DataTable().row(rowIndex).data().id;  
        $("#editRowDatai").val(id);
        var table = $('#doneinfodetail').DataTable();
        var colindex =table.cell( this ).index().columnVisible;
        if(colindex=="8")
        {
            //debugger;
            newInput(this);
        }
        else if(colindex=="9")
        {
            //debugger;
            UnitCostnewInput(this);
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
        })
        .appendTo($(elm))
        .focus();
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
        var value = $(elm).find('input').val();
        var ids=$("#editRowDatai").val();
        $(elm).empty().text(value);
        $(elm).bind("dblclick", function () {
            newInput(elm);
        });  
        var val=parseFloat(value);
        if(value=="")
        {
            $.get("/dsupdateQ/"+ids+'/'+'-1'  , function (data) {});
        }
        else if(val<0)
        {
            $("#quantityId").val("");
            $.get("/dsupdateQ/"+ids+'/'+'-1'  , function (data) {});
        }
        else if(value!="")
        {    
            $.get("/dsupdateQ/"+ids+'/'+value  , function (data) {});
            var iTable = $('#doneinfodetail').dataTable(); 
            iTable.fnDraw(false);            
        }
    }

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
            $.get("/dsupdateUp/"+ids+'/'+'-1'  , function (data) {});
        }
        else if(value!="")
        {
            var ids=$("#editRowDatai").val();
            $.get("/dsupdateUp/"+ids+'/'+value  , function (data) {});
        }
    }

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

    function getConfirminfo()
    {
        var recId=$('#recbgId').val();
        var recStoreId=$('#recbgStrId').val();
        var recStatus=$('#recbgStatus').val();
        $('#postid').val(recId);
        $('#postbgmodal').modal('show');
        $('#bgpostbtn').prop( "disabled", false );
    }

    //Start change to done
    $('body').on('click', '#donecountbtn', function()
    {
        var registerForm = $("#donecountform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dsdoneCount',
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
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.success) {
                    $('#donecountbtn').text('Finish Counting');
                    toastrMessage('success',"Begining changed to Done","Success");
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
           url:'/dsverifyCount',
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
                if(data.success) {
                    $('#verifyBegbtn').text('Verify');
                    toastrMessage('success',"Begining Changed to Verify","Success");
                    $("#verifycountconfirmation").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to verify

    //Start change to counting
    $('body').on('click', '#changecountingbtn', function()
    {
        var registerForm = $("#commentform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dscommentCount',
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
                    toastrMessage('success',"Begining changed to Counting","Success");
                    $("#commentModal").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to counting

    //Start change to post
    $('body').on('click', '#bgpostbtn', function()
    {
        var registerForm = $("#postform");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dspostCount',
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
            },
            success:function(data) 
            {
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
                        $('#bgpostbtn').text('Post');
                        $('#bgpostbtn').prop( "disabled", false );
                        toastrMessage('error',"Please Fill Quantity and Unitcost for "+count+" Items </br>"+loopedVal,"Error");
                        $("#postbgmodal").modal('hide');
                    }   
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
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                    }   
                }
                if(data.success) 
                {
                    $('#bgpostbtn').text('Post');
                    toastrMessage('success',"Begining Posted","Success");
                    $("#postbgmodal").modal('hide');
                    $("#bgInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //End change to post

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

    function commentRemVal() 
    {
        $( '#comment-error' ).html("");
    }

    function closecommentRemVal() 
    {
        $('#comment-error').html("");
        $("#commentform")[0].reset();
    }

    function startSyncCost() 
    {
        $("#syncCostConfirmationModal").modal('show');
        $("#syncheaderid").val($("#recbgId").val())
    }

    function numformat(val)
    {
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
    //Show modal with focus textbox starts
    $(document).on('shown.bs.modal', '.modal', function () 
    {
        $(this).find('[autofocus]').focus();
    });
    //Show modal with focus textbox ends

    function syncStoreVal() 
    {
        $( '#store-error' ).html("");
    }

    function closeConfmodal()
    {
        $( '#store-error' ).html("");
        $('#SyncStore').val(null).trigger('change');
    }
    function closeSaveNewModal()
    {
        $('#Item').val(null).trigger('change');
        $('#beginingQuantity').val("");
        $('#uoms').val("");
        $('#BeginingUnitCost').val("");
        $('#MinSelling').val("");
        $('#TotalCost').val("");
        $('#Item-error').html("");
        $('#Quantity-error').html("");
        $('#UnitCost-error').html("");
        $('#TotalCost-error').html("");
        $('#ItemName').hide();
        $('#Item').show();
    }

    $('body').on('click', '#savenewitem', function(){
        var registerForm = $("#adjNewItemForm");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dspostSingleItem',
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
                $('#savenewitem').text('Saving...');
                $('#savenewitem').prop( "disabled", true );
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
                if(data.errors) {
                    if(data.errors.Item){
                        $( '#Item-error' ).html( data.errors.Item[0] );
                    }
                    if(data.errors.beginingQuantity){
                        $( '#Quantity-error' ).html( data.errors.beginingQuantity[0] );
                    }
                    if(data.errors.BeginingUnitCost){
                        $( '#UnitCost-error' ).html( data.errors.BeginingUnitCost[0] );
                    }
                    $('#savenewitem').text('Save');
                    $('#savenewitem').prop( "disabled", false );
                    toastrMessage('error',"Check your inputs","Error");  
                }
                if(data.success) {
                    $('#savenewitem').text('Save');
                    toastrMessage('success',"Item posted successfully","Success");
                    $("#newItemModal").modal('hide');
                    $("#adjNewItemForm")[0].reset();
                    closeSaveNewModal();
                    var oTable = $('#adjustmentdetail').dataTable(); 
                    oTable.fnDraw(false);
                    var recordId= $("#headeridi").val();
                    $.get("/dsshowBgData" +'/' + recordId , function (data) 
                    {     
                        var dc=data;
                        var len=data.bgHeader.length;
                        for(var i=0;i<=len;i++) 
                        {  
                            $('#adjtotalcostvallbl').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                            $('#adjtotalcostvallblheader').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                        }    
                    });
                }
            },
        });
    });

    $('body').on('click', '#updateAdjustmentItem', function(){
        var registerForm = $("#adjNewItemForm");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dseditPostedSingleItem',
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
                $('#updateAdjustmentItem').text('Saving...');
                $('#updateAdjustmentItem').prop( "disabled", true );
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
                    var itemname=$("#ItemName").val();
                    toastrMessage('error',itemname+" have no available quantity","Error");
                    $("#newItemModal").modal('hide');
                    $("#adjNewItemForm")[0].reset();
                    closeSaveNewModal();  
                }
                if(data.errors) {
                    if(data.errors.beginingQuantity){
                        $( '#Quantity-error' ).html( data.errors.beginingQuantity[0] );
                    }
                    if(data.errors.BeginingUnitCost){
                        $( '#UnitCost-error' ).html( data.errors.BeginingUnitCost[0] );
                    }
                    $('#updateAdjustmentItem').text('Save');
                    $('#updateAdjustmentItem').prop( "disabled", false );
                    toastrMessage('error',"Check your inputs","Error");  
                }
                if(data.success) {
                    $('#updateAdjustmentItem').text('Save');
                    toastrMessage('success',"Successful","Success");
                    $("#newItemModal").modal('hide');
                    $("#adjNewItemForm")[0].reset();
                    closeSaveNewModal();
                    var oTable = $('#adjustmentdetail').dataTable(); 
                    oTable.fnDraw(false);
                    var recordId= $("#headeridi").val();
                    $.get("/dsshowBgData" +'/' + recordId , function (data) 
                    {     
                        var dc=data;
                        var len=data.bgHeader.length;
                        for(var i=0;i<=len;i++) 
                        {  
                            $('#adjtotalcostvallbl').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                            $('#adjtotalcostvallblheader').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                        }    
                    });
                }
            },
        });
    });

    $('body').on('click', '#deletePostedItem', function(){
        var registerForm = $("#removeItemModal");
        var formData = registerForm.serialize();
        $.ajax({
           url:'/dsdeletePostedItem',
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
                $('#deletePostedItem').text('Deleting...');
                $('#deletePostedItem').prop( "disabled", true );
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
                    var itemname=$("#ItemName").val();
                    toastrMessage('error',itemname+" have no available quantity","Error");
                    $("#postedRemoveModal").modal('hide');
                    closeSaveNewModal();  
                }
                if(data.success) {
                    $('#deletePostedItem').text('Delete');
                    toastrMessage('success',"Successful","Success");
                    $("#postedRemoveModal").modal('hide');
                    closeSaveNewModal();
                    var oTable = $('#adjustmentdetail').dataTable(); 
                    oTable.fnDraw(false);
                    var recordId= $("#removeHeaderId").val();
                    $.get("/dsshowBgData" +'/' + recordId , function (data) 
                    {     
                        var dc=data;
                        var len=data.bgHeader.length;
                        for(var i=0;i<=len;i++) 
                        {  
                            $('#adjtotalcostvallbl').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                            $('#adjtotalcostvallblheader').text("Total Value : "+numformat(data.pricing[i].TotalCost));
                        }    
                    });
                }
            },
        });
    });

    function itemVal() 
    { 
        var sid=$("#Item").val();
        var storeid=$("#storeidadj").val();
        var headerid=$("#headeridi").val();
        $.get("/dsshowBgItemInfo" +'/' + sid+'/'+storeid+'/'+headerid , function (data) 
        {    
            if(data.valerror)
            {
                toastrMessage('error',"Item already posted","Error");
                $('#Item').val(null).trigger('change');
                $('#uoms').val("");
                $('#MinSelling').val("");
            }
            else
            { 
                if(data.Regitem)
                {  
                    var unitcost=data['cost'];
                    $('#BeginingUnitCost').val(unitcost);
                    var len=data['Regitem'].length;
                    for(var i=0;i<=len;i++) 
                    {  
                       
                        var itemUOMVar=(data['Regitem'][i].UOM);
                        var itemWholeseller=(data['Regitem'][i].WholesellerPrice); 
                        $('#uoms').val(itemUOMVar);
                        $('#MinSelling').val(parseFloat(itemWholeseller)/1.15);
                    } 
                } 
            }         
        });
 
    $( '#Item-error' ).html("");
}

function getInfo()
{
    $('#storeidadj').val($('#adjrecbgStrId').val());
    $('#headeridi').val($('#adjHeaderId').val());
    $('#Item-error' ).html("");
    $('#Item').val(null).trigger('change');
    $('#uoms').val("");
    $('#savenewitem').text('Save');
    $('#savenewitem').prop( "disabled", false );
    $('#savenewitem').show();
    $('#updateAdjustmentItem').hide();
    $('#ItemName').hide();
    $('#itemDiv').show();
    $('#adjustmentModalTitle').html("Add New Item");
}

function CalculateTotalCost(ele) 
{
    var quantity = $('#beginingQuantity').val();
    var unitcost =  $('#BeginingUnitCost').val();
    unitcost = unitcost == '' ? 0 : unitcost;
    quantity = quantity == '' ? 0 : quantity;
    if (!isNaN(unitcost) && !isNaN(quantity)) 
    {
        var total = parseFloat(unitcost) * parseFloat(quantity);
        $('#TotalCost').val(total.toFixed(2));
    }
}

$('body').on('click', '.editPosted', function () 
{
    var recIdVar = $(this).data('id');
    var itemid = $(this).data('itemid');
    var itemname = $(this).data('itemname');
    var uomname = $(this).data('uom');
    var minimumsale = $(this).data('wholesale');
    $('#storeidadj').val($('#adjrecbgStrId').val());
    $('#headeridi').val($('#adjHeaderId').val());
    $('#Item-error' ).html("");
    $('#savenewitem').text('Save');
    $('#savenewitem').prop( "disabled", false );
    $('#savenewitem').hide();
    $('#updateAdjustmentItem').show();
    $('#ItemName').show();
    $('#itemDiv').hide();
    $('#ItemName').val(itemname);
    $('#uoms').val(uomname);
    $('#MinSelling').val(parseFloat(minimumsale/1.15));
    $('#updateAdjustmentItem').text('Save');
    $('#updateAdjustmentItem').prop( "disabled", false );
    $("#newItemModal").modal('show');
    $.get("/dseditPostedItem" +'/' + recIdVar , function (data) 
    {
        $('#itemidi').val(data.begdetail.ItemId);
        $('#beginingQuantity').val(data.begdetail.Quantity);
        $('#hiddenQuantity').val(data.begdetail.Quantity);
        $('#BeginingUnitCost').val(data.begdetail.UnitCost);
        $('#TotalCost').val(data.begdetail.BeforeTaxCost);
    });
    $('#adjustmentModalTitle').html("Adjust Posted Item");
});

$('body').on('click', '.deletedPosted ', function () 
{
    var recIdVar = $(this).data('id');
    var itemid = $(this).data('itemid');
    var itemname = $(this).data('itemname');
    var uomname = $(this).data('uom');
    var minimumsale = $(this).data('wholesale');
    $('#updateAdjustmentItem').text('Save');
    $('#ItemName').val(itemname);
    $('#updateAdjustmentItem').prop( "disabled", false );
    $('#removeRecordId').val(recIdVar);
    $('#removeHeaderId').val($('#adjHeaderId').val());
    $("#postedRemoveModal").modal('show');
    $.get("/dseditPostedItem" +'/' + recIdVar , function (data) 
    {
        $('#removeItemId').val(data.begdetail.ItemId);
        $('#removeItemQuantity').val(data.begdetail.Quantity);
        $('#removeStoreId').val(data.begdetail.StoreId);
    });
    $('#deletePostedItem').text('Delete');
    $('#deletePostedItem').prop( "disabled", false );
});

function validateQuantityVal()
{
    var quantity=$('#beginingQuantity').val();
    if(parseFloat(quantity)==0)
    {
        $('#beginingQuantity').val("");
    }
    $('#Quantity-error').html("");
}
function validateUnitcostVal()
{
    var unitcost=$('#BeginingUnitCost').val();
    if(parseFloat(unitcost)==0)
    {
        $('#BeginingUnitCost').val("");
    }
    $('#UnitCost-error').html("");
}

//Start Show Item Info
$('body').on('click', '.addSerialNumber', function () 
{
    var sid = $(this).data('id');
    $.get("/dsshowSerialNumberBg" +'/' + sid , function (data) 
    {
        $('#seritemid').val(data.recDataId.ItemId);
        $('#serheaderid').val(data.recDataId.HeaderId);
        $('#serstoreid').val(data.recDataId.StoreId);  
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
            var headerid=data.recDataId.HeaderId;
            var itemid=data.recDataId.ItemId;
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
                    url: '/dsshowSerialNmBg/'+headerid+'/'+itemid+'/'+trtype,
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
           url:'/dsaddSerialnumbersBg',
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
                    $('#saveSerialNum').prop("disabled",false);
                    toastrMessage('error',"The remaining quantity is not the same with inserted quantity","Error");
                }
                if(data.success) 
                {    
                    $('#saveSerialNum').text('Add');
                    $('#saveSerialNum').prop("disabled",false);
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

    $('#brand').on ('change', function () 
    {
        var sid = $('#brand').val();
        $('#modelNumber').find('option').not(':first').remove();
        var registerForm = $("#serialNumberRegForm");
        var formData = registerForm.serialize();
        $.ajax({
            url:'dsshowModels/'+sid,
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
        $.get("/dsserialnumbereditBg" +'/' + recIdVar , function (data)
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

    $('#sernumDeleteModal').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var totalqnt=$('#totalQuantityLbl').text();
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
            url:'/dsserialdeleteBg/'+sid,
            type:'DELETE',
            data:'',
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
                $('#deleteSerialNumberBtn').text('Deleting...');
                $('#deleteSerialNumberBtn').prop( "disabled",true);
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
                $('#deleteSerialNumberBtn').text('Delete');
                $('#deleteSerialNumberBtn').prop( "disabled",false);
                toastrMessage('success',"Successful","Success");
                $('#sernumDeleteModal').modal('hide');
                $('#insertedQuantityLbl').text(data.Totalcount);
                var inserted=data.Totalcount;
                var totalcnt=$('#totalBegQuantity').val();
                var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                $('#remainingQuantityLbl').text(netQ);
                var oTable = $('#receivingEditTable').dataTable(); 
                oTable.fnDraw(false);
                var iTable = $('#laravel-datatable-crud-sn').dataTable(); 
                iTable.fnDraw(false);
            }
        });
    });
    //Delete Records Ends

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
            language: { search: '', searchPlaceholder: "Search here" },
            "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/dsshowBeginingDataFy/'+fy,
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
                { data: 'EndingDocumentNo', name: 'EndingDocumentNo', 'visible': false},
                { data: 'Store', name: 'Store'},
                { data: 'FiscalYearRange', name: 'FiscalYearRange', 'visible': false},
                { data: 'Date', name: 'Date'},
                { data: 'Status', name: 'Status' }, 
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
            {
                if (aData.Status == "Ready") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
                }
                else if (aData.Status == "Counting") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
                }
                else if (aData.Status == "Posted") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                }
                else if (aData.Status == "Done") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
                }
                else if (aData.Status == "Verified") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#5bc0de", "font-weight": "bold","text-shadow":"1px 1px 10px #5bc0de"});
                }
                else if (aData.Status == "Rejected") 
                {
                    $(nRow).find('td:eq(4)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                }
            }
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
        filename: "DSBeginingDetailTable", //do not include extension
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
        filename: "DSBeginningPostedItem", //do not include extension
        fileext: ".xls" // file extension
        });
    });
</script>  

@endsection
  