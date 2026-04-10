@extends('layout.app1')
@section('title')
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('fontawesome6/pro/css/all.min.css') }}">
@endsection
@section('content')
    <div class="app-content content">
        <div class="row">
            <div class="col-12">
                <div class="card card-app-design">
                    <div class="card-body">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-12">
                                    <h4 class="card-title">Request For Quotation(RFQ)
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="rfqtablesrefresh()"><i data-feather="refresh-cw"></i></button>
                                        <input type="hidden" name="currentdate" id="currentdate" class="form-control" value="{{ $todayDate }}" readonly>
                                    </h4>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <label strong style="font-size: 12px;font-weight:bold;">Fiscal Year</label>
                                    <select class="select2 form-control" name="fiscalyear" id="fiscalyear">
                                            @foreach ($fiscalyears as $fiscalyears)
                                            <option value="{{ $fiscalyears->FiscalYear }}">{{ $fiscalyears->Monthrange }}</option>
                                            @endforeach 
                                    </select>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <label strong style="font-size: 12px;font-weight:bold;">RFQ Announcement</label>
                                    <select data-column="6" class="selectpicker form-control filter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="annoucement ({0})" data-live-search-placeholder="search annoucement" title="Select annoucement" multiple>
                                            <option  value="Proforma">By Proforma</option>
                                            <option  value="Bid">By Bid</option>
                                    </select>
                                </div>
                            </div>
                        </div>    
                    </div>
                    @can('RFQ-View')
                        <div class="card-datatable">
                                <div style="width:98%; margin-left:1%" class="" id="table-block">
                                <table id="rfqtables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>RFQ#</th>
                                            <th>Reference</th>
                                            <th>Type</th>
                                            <th>RFQ Announcement By</th>
                                            <th>Request Station</th>
                                            <th>Prepare Date</th>
                                            <th>Dead Line</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    {{-- start info modal --}}
    <div class="modal fade" id="docInfoModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">RFQ Information</h5>
                <div class="row">
                    <div style="text-align: right;" id="infoStatus"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body scroll scrdiv">
                <form id="holdInfo">
                @csrf
                <div class="col-xl-12" id="docinfo-block">
                    <div class="card collapse-icon">
                            <div class="collapse-default" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span class="lead collapse-title">Request For Qoute Details</span>
                                        <span id="statustitles" style="font-size:16px;"></span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Request For Qoute Information</h6>
                                                            
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Reference:</label></td>
                                                                    <td><b><label id="infopurchase" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">RFQ#:</label></td>
                                                                    <td><b><label id="inforfq" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">RFQ Announcement By:</label></td>
                                                                    <td><b><label id="infosource" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Prepare Date:</label></td>
                                                                    <td><b><label id="infodate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Dead Line:</label></td>
                                                                    <td><b><label id="infolastsubmittiondate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Prepare Station:</label></td>
                                                                    <td><b><label id="preparestation" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Sample:</label></td>
                                                                    <td><b><label id="infosamplerequire" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Evaluation:</label></td>
                                                                    <td><b><label id="infoevquire" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 col-lg-12" id="supplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:none;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Supplier Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="scroll scrdiv" style="overflow-y:scroll;height:25rem;">
                                                                <table id="supplierdatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>ID</th>
                                                                            <th>Name</th>
                                                                            <th>TIN</th>
                                                                            <th>Submission</th>
                                                                        
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 col-lg-12" id="bidinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:none;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Bid information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Description:</label></td>
                                                                    <td><b><label id="infodescription" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Action</h6>
                                                        </div>
                                                        <div class="card-body scroll scrdiv">
                                                            <ul class="timeline" id="ulist" style="height:25rem;">
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
            <div class="divider divider-info">
                <div class="divider-text">Product Detials</div>
            </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="table-responsive">
                        <div id="itemsdatablediv" class="scroll scrdiv">
                            <table id="itemsdocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                <thead>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>SKU#</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Remark</th>
                                </thead>
                            <tbody></tbody>
                            <tfoot>
                            
                            </tfoot>
                            </table>
                        </div>
                        <div id="commuditylistdatablediv" class="scroll scrdiv">
                            <table id="comuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                            <thead>
                                <th>#</th>
                                <th>Commodity</th>
                                <th>Proccess Type</th>
                                <th>Crop Year</th>
                                <th>Grade</th>
                                <th>KG</th>
                                <th>TON</th>
                                <th>Feresula</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Remark</th>
                            </thead>
                            <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </form>   
            </div>
            <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                        <input type="hidden" placeholder="" class="form-control" name="recordIds" id="recordIds" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="disabledbutton" id="disabledbutton" readonly="true"/>
                                    <div class="col-xl-5 col-lg-12">
                                        @can('RFQ-Edit')
                                            <button type="button" id="rfqeditbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i> Edit</button>
                                        @endcan
                                            @can('RFQ-Void')
                                                <button type="button" id="prvoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Void</button>
                                                <button type="button" id="prundovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Void</button>
                                            @endcan
                                            @can('RFQ-Reject')
                                                <button type="button" id="prejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Reject</button>
                                                <button type="button" id="prundorejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Reject</button>
                                            @endcan
                                            <button type="button" id="rfqprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                    </div>        
                                    <div class="col-xl-2 col-lg-12">
                                        
                                    </div> 
                                    <div class="col-xl-5 col-lg-12" style="text-align:right;">
                                        @can('RFQ-Submission')
                                            <button type="button" id="submissionbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Submission</button>
                                        @endcan
                                        @can('RFQ-Pending')
                                            <button type="button" id="backtodraftbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Back To Draft</button>
                                            <button type="button" id="changetopendingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Change To Pending</button>
                                        @endcan
                                        @can('RFQ-Verify')
                                        <button type="button" id="backtopendingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Back To Pending</button>
                                        <button type="button" id="verifybutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Verify</button>
                                        @endcan
                                        @can('RFQ-Approved')
                                            <button type="button" id="approvedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Approve</button>
                                        @endcan
                                        <button type="button" id="authorizebutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Authorize</button>
                                    
                                        <button id="closebutton" type="button" class="btn btn-outline-danger" onclick="rfqtablesrefresh()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                                    </div> 
                                </div>
                    </div>
            </div>
        </div>
        </div>
    </div> 
    {{-- end info modal --}}
    <!-- start of purchase modals  -->
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Add RFQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body scroll scrdiv">
                    <form id="Register">
                        {{ csrf_field() }}
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Reference <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="purchase" id="purchase" data-placeholder="select Reference">
                                                <option selected disabled  value=""></option>  
                                                @foreach ($purchase as $key)
                                                    <option title="{{$key->type}}" value="{{ $key->id }}">{{ $key->docnumber }}</option> 
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="purchase-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Request Station</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="requeststation" id="requeststation" class="form-control" placeholder="Request station" readonly/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="requeststation-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">RFQ Announcement<b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="type" id="type" data-placeholder="select purchase type">
                                                <option selected disabled  value=""></option>  
                                                <option value="Proforma">By Proforma</option>
                                                <option value="Bid">By Bid</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="type-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-1 col-md-1 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Prepare Date <b style="color:red;">*</b></label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="date" id="date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="date-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-1 col-md-1 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Dead Line <b style="color:red;">*</b></label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="lastsubmittiondate" id="lastsubmittiondate" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="lastsubmittiondate-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Evaluation<b style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg" name="evualationrequire" id="evualationrequire" data-placeholder="Select Evaluation">
                                                        <option disabled selected value=""></option>
                                                        <option value="Required">Required</option>
                                                        <option value="Not Required">Not Required</option>
                                                </select>
                                            <span class="text-danger">
                                                <strong id="evualationrequire-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-2 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Sample<b style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg" name="samplerequire" id="samplerequire" data-placeholder="Select Sample">
                                                        <option disabled selected value=""></option>
                                                        <option value="Required">Required</option>
                                                        <option value="Not Required">Not Required</option>
                                                </select>
                                            <span class="text-danger">
                                                <strong id="samplerequire-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                    
                                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2" id="supplierdiv" style="display: none;">
                                            <label strong style="font-size: 14px;">Supplier <b style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg supplier" name="supplier[]" id="supplier" data-placeholder="select supplier" multiple="multiple">
                                                    @foreach ($customer as $key)
                                                        <option value="{{ $key->id }}">{{ $key->Code }}, {{ $key->Name }}, {{ $key->TinNumber }}</option>
                                                    @endforeach
                                                </select>
                                            <span class="text-danger">
                                                <strong id="supplier-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2" id="descriptiondiv" style="display: none;">
                                            <label strong style="font-size: 14px;">Description</label>
                                            <div class="input-group input-group-merge">
                                                <textarea  class="form-control" id="description" name="description" placeholder="Write memo here"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Rfqid <b style="color:red;">*</b></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="rfqid" class="form-control" name="rfqid" id="rfqid" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">document# <b style="color:red;">*</b></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="documentnumber" class="form-control" name="documentnumber" id="documentnumber" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- start of item Row -->
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div style="width:98%; margin-left:1%;">
                                                <div id="itemslitsdatablesdiv" class="table-responsive scroll scrdiv" style="display: none;">
                                                    <table id="itemslitsdatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Code</th>
                                                            <th>Name</th>
                                                            <th>SKU#</th>
                                                            <th>Qty</th>
                                                            <th>Price</th>
                                                            <th>Total</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        
                                                    </table>
                                                </div>
                                            <div id="commoditydatablesdiv" class="table-responsive scroll scrdiv" style="display: none;">
                                                <table id="commoditydatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Commodity</th>
                                                            <th>Proccess Type</th>
                                                            <th>Cropyear</th>
                                                            <th>Grade</th>
                                                            <th>KG</th>
                                                            <th>Ton</th>
                                                            <th>Feresula</th>
                                                            <th>Price</th>
                                                            <th>Total</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of Item Row -->
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                            
                                        </div>
                                        {{-- <div class="col-xl-3 col-lg-12">
                                            <table style="width:100%;" id="pricetable" class="rtable">
                                                <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Total:</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="subtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                        <td><input type="hidden" placeholder="" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0" /></td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. of product</label></td>
                                                    <td style="text-align: center;"><label id="numberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                    <td><input type="hidden" name="numbercounti" id="numbercounti" value='0'/></td>
                                                </tr>
                                            </table>
                                        </div> --}}
                                    </div> 
                                </div>
                            </div>
                        </div>   
                    </form>
                </div>
            <div class="modal-footer">
                @can('RFQ-Add')
                    <button id="savebutton" type="button" class="btn btn-outline-dark"><i id="savedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                @endcan
                
                <button id="closebutton" type="button"  class="btn btn-outline-danger" onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
        </div>
        </div>
    </div>
<!-- end of purchase modals  -->
<!-- start of void modals  -->
<div class="modal fade text-left" id="rfqvoidvoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rfqvoidform" >
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="rfqvoidid" id="rfqvoidid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="rfqtype" id="rfqtype" readonly="true">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <textarea  class="form-control" id="voidreason" placeholder="Write Reason here" name="Reason" onkeyup="clearvoiderror();"></textarea>
                                    <span class="text-danger">
                                        <strong id="voidreason-error"></strong>
                                    </span>
                            </div>
                    <div class="modal-footer">
                        <button id="rfqvoidbutton" type="button" class="btn btn-outline-dark"><i id="rfqvoidbuttonicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span> Void</span></button>
                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="clearvoiderror();"><i class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of void modals  -->
    <div class="modal modal-slide-in event-sidebar fade" id="suppliersubmissionmodals" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Quatation Submission</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <form id="submissionsupllierform">
                                            {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Supplier <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg qselect" name="customer_id" id="submissionsupplier" data-placeholder="select supllier">
                                                <option selected disabled  value=""></option>  
                                                @foreach ($customer as $key)
                                                    <option title="{{$key->Code}}" value="{{ $key->id }}">{{ $key->Code }},{{ $key->Name }},{{ $key->TinNumber }}</option> 
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="submitsupllier-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Submission  <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg qselect" name="supplierstatus" id="supplierstatus" data-placeholder="Select Status">
                                                <option selected disabled  value=""></option>
                                                <option value="0">--</option>
                                                <option value="1">Submitted</option>
                                                <option value="2">Not submitted</option>  
                                            </select>
                                            <span class="text-danger">
                                                <strong id="supplierstatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Contact person name </label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="name" id="supname" class="form-control qs" placeholder="Contact person name"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="supplierstatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Contact person phone </label>
                                            <div class="input-group input-group-merge">
                                                <input type="tel"  name="phone" id="sphone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="10" onkeypress="return ValidateNum(event);" class="form-control qs" placeholder="Phone Number"/>
                                            
                                            </div>
                                            <span class="text-danger">
                                                <strong id="supplierstatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Date <b style="color:red;">*</b> </label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="submitdate" id="submitdate" class="form-control flatpickr-basic qs" placeholder="YYYY-MM-DD"/>
                                                
                                            </div>
                                            <span class="text-danger">
                                                <strong id="submitdate-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;">Hidde <b style="color:red;">*</b> </label>
                                            <div class="input-group">
                                                <input type="text"  name="supplierrfqid" id="supplierrfqid" class="form-control" placeholder="id"/>
                                                <input type="text"  name="rfqcustomerid" id="rfqcustomerid" class="form-control" placeholder="rfqcustomerid"/>
                                                
                                            </div>
                                            <span class="text-danger">
                                                <strong id="submitdate-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;"></label>
                                            <div class="input-group input-group-merge">
        
                                                <button id="submitsupplier" type="button" class="btn btn-outline-dark"><i id="supplsavedicon" class="fa-sharp fa-solid fa-plus"></i> <span>Add</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="supplierlistdatables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>TIN#</th>
                                                    <th>Submission</th>
                                                    <th>Contact Person</th>
                                                    <th>Phone</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    <th>Id</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="undoallsubmitbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Undo Submit</button>
                        <button type="button" id="allsubmitbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Submit</button>
                        
                        <button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('scripts')
<script type="text/javascript">
    var rfqtables='';
    var gblIndex=0;
    var qoutgblIndex=0;
    var i=0;
    var j=0;
    var m=0;
    var errorcolor="#ffcccc";
    $('body').on('click', '.addbutton', function () {
        var currentdate=$('#currentdate').val();
        $("#rfqid").val('');
        $("#date").val('');
        $("#lastsubmittiondate").val('');
        $("#requeststation").val('');
        $("#description").val('');
        $("#documentnumber").val('');
        $("#exampleModalScrollable").modal('show');
        $('#itemslitsdatablesdiv').hide();
        $('#commoditydatablesdiv').hide();
        $('#supplierdiv').hide();
        $("#dynamicTable tbody").empty();
        $('#pricetable').hide();
        $('#purchase').select2('destroy');
        $('#purchase').val(null).select2();
        $('#supplier').select2('destroy');
        $('#supplier').val(null).select2();
        $('#type').select2('destroy');
        $('#type').val(null).select2();
        $('#evualationrequire').select2('destroy');
        $('#evualationrequire').val('').select2();
        $('#samplerequire').select2('destroy');
        $('#samplerequire').val('').select2();
        
        $("#savebutton").find('span').text("Save");
        $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
        $("#savedicon").removeClass("fa-duotone fa-pen");
        $("#savedicon").addClass("fa-sharp fa-solid fa-floppy-disk");
        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false,minDate:currentdate});
        $("#date").val(currentdate);
        listofpurchaseitem(0);
    });

    function rfqtablesrefresh() {
        var tabletr = $('#rfqtables').DataTable(); 
        tabletr.search('');
        var oTable = $('#rfqtables').dataTable(); 
        oTable.fnDraw(false);
    }
    $('#submissionsupplier').on('change', function () {
        $('#submitsupllier-error').html('');
    });
    $('#supplierstatus').on('change', function () {
        $('#supplierstatus-error').html('');
    });
    $('#submitdate').on('change', function () {
        $('#submitdate-error').html('');
    });

    $('#submitsupplier').click(function(){
        savesubmitter();
    });
    function savesubmitter() {
        var form = $("#submissionsupllierform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('savesubmissionsupplier') }}",  
            data: formData,
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
            error: function (jqXHR, textStatus, errorThrown) {
                switch (textStatus) {
                    case 'timeout':
                        toastrMessage('error','The request timed out. Please try again later','Error');
                        break;
                    case 'error':
                        toastrMessage('error','An error occurred:'+errorThrown,'Error');
                    break;
                    case 'abort':
                        toastrMessage('error','The request was aborted.','Error');
                    break;
                    case 'parsererror':
                        toastrMessage('error','Parsing JSON request failed.','Error');
                    break;
                    default:
                            toastrMessage('error','AJAX Error: '+textStatus+','+errorThrown,'Error');
                        break;
                }
                
            },
            success: function (response) {
                if(response.success){
                    
                    toastrMessage('success','successfully save','Done');
                    var rfq= $('#rfqcustomerid').val()||0;
                    switch (rfq) {
                        case 0:
                            qoutgblIndex=0;
                            break;
                    
                        default:
                            qoutgblIndex= qoutgblIndex;
                            break;
                    }
                    $('.qs').val('');
                    $('#rfqcustomerid').val('');
                    $('.qselect').val('').select2();
                    $("#submitsupplier").find('span').text("Add");
                    $("#supplsavedicon").removeClass("fa-sharp fa-solid fa-plus");
                    $("#supplsavedicon").removeClass("fa-duotone fa-pen");
                    $("#supplsavedicon").addClass("fa-sharp fa-solid fa-plus");
                    var oTable = $('#supplierlistdatables').dataTable(); 
                    oTable.fnDraw(false);
                    var tables = $('#supplierdatatables').dataTable(); 
                    tables.fnDraw(false);
                    setminilog(response.actions);
                }
                if(response.errors){
                    if(response.errors.customer_id){
                        var text=response.errors.customer_id[0];
                        text = text.replace("customer id", "supplier");
                        $('#submitsupllier-error').html(text);
                    }
                    if(response.errors.submitdate){
                        var text=response.errors.submitdate[0];
                        text = text.replace("submitdate", "date");
                        $('#submitdate-error').html(text);
                    }
                    if(response.errors.supplierstatus){
                        var text=response.errors.supplierstatus[0];
                        text = text.replace("supplierstatus", "submission");
                        $('#supplierstatus-error').html(text);
                    }
                }
            }
        });
    }
    $('#submissionbutton').click(function(){

        var id=$('#recordIds').val();
        var currentdate=$('#currentdate').val();
        qoutgblIndex=0;
        $('.rmerror').html('');
        $('.qs').val('');
        $('#rfqcustomerid').val('');
        $('.qselect').val('').select2();
        $("#submitsupplier").find('span').text("Add");
        $("#supplsavedicon").removeClass("fa-sharp fa-solid fa-plus");
        $("#supplsavedicon").removeClass("fa-duotone fa-pen");
        $("#supplsavedicon").addClass("fa-sharp fa-solid fa-plus");
        flatpickr('#submitdate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
        $.ajax({
            type: "GET",
            url: "{{ url('checksubmissionstartornot') }}/"+id,  
            success: function (response) {
                switch (response.exist) {
                    case true:
                        $('#submitsupplier').prop('disabled',true);
                        $('#undoallsubmitbutton').hide();
                        $('#allsubmitbutton').hide();
                        break;
                    
                    default:
                            switch (response.status) {
                                case 3:
                                    $('#undoallsubmitbutton').hide();
                                    $('#allsubmitbutton').show();
                                    break;
                            
                                default:
                                    $('#undoallsubmitbutton').show();
                                    $('#allsubmitbutton').hide();
                                    break;
                            }
                            $('#submitsupplier').prop('disabled',false);
                        break;
                }
            }
        });
        opensubmission(id);
    });
    function opensubmission(id) {
        $("#submissionsupplier option[value!=0]").prop('disabled',false);
        $("#supplierstatus option[value!=0]").prop('disabled',false);

        $('#supplierlistdatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('showsupplier') }}/"+id,                   
                type: 'GET',
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
                        setquatationFocus();
                        $('#supplierrfqid').val(id);
                        $('#suppliersubmissionmodals').modal('show');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        toastrMessage('error','AJAX Error: '+textStatus+','+errorThrown,'Error');
                    }
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'Code',name: 'Code'},
                {data: 'Name',name: 'Name'},
                {data: 'TinNumber',name: 'TinNumber'},
                {data: 'status',name: 'status'},
                {data: 'contactperson',name: 'contactperson'},
                {data: 'phonenumber',name: 'phonenumber'},
                {data: 'date',name: 'date'},
                {data: 'isaddorder',name: 'isaddorder'},
                {data: 'rfqid',name: 'rfqid',width:'3%'},
                {data: 'id',name: 'id',visible:false},
            ],
            columnDefs: [{
                targets:1,
                render:function (data,type,row,meta) {
                    var anchor='<a class="enVoice" href="javascript:void(0)"  data-code="'+data+'" data-original-title="" title="RfQ" style="text-decoration:underline;"><span>'+data+'</span></a>';
                    return anchor;
                }
            },
            {
                targets:4,
                render:function (data,type,row,meta) {
                    switch (data) {
                        case '1':
                            return 'Submitted';
                            break;
                        case '2':
                            return 'Not Submitted';
                            break;
                        default:
                            return '';
                            break;
                    }
                }
            },
            {
                targets:8,
                render:function (data,type,row,meta) {
                    switch (data) {
                        case 0:
                            return 'Old'
                            break;
                    
                        default:
                            return 'New';
                            break;
                    }
                }
            },
            {
                targets:9,
                render:function (data,type,row,meta) {
                    var anchor='<a class="supplieredit" href="javascript:void(0)" data-suplierid='+row.id+' data-id='+data+' title="Edit supplier"><i class="fa-duotone fa-pen" style="color: #4b4b4b;"></i></a> <a class="deletesupplier" href="javascript:void(0)" data-suplierid='+row.id+' data-id='+data+' title="Delete supplier"><i class="fa-solid fa-trash"  style="color: #4b4b4b;"></i></a>';
                    return anchor;
                }
            }
        ],
        });
    }

    function setquatationFocus(){ 
        $($('#supplierlistdatables tbody > tr')[qoutgblIndex]).addClass('selected');  
    }
    $('#supplierlistdatables tbody').on('click', 'tr', function () {
            $('#supplierlistdatables tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            qoutgblIndex = $(this).index();
    });

    $('body').on('click', '.supplieredit', function () {
            var rfqid = $(this).data('id');
            var suplierid=$(this).data('suplierid');

                editsubmitter(rfqid,suplierid);
    });
    function editsubmitter(rfqid,suplierid) {
        $('.rmerror').html('');
        $("#submitsupplier").find('span').text("Update");
        $("#supplsavedicon").removeClass("fa-sharp fa-solid fa-plus");
        $("#supplsavedicon").removeClass("fa-duotone fa-pen");
        $("#supplsavedicon").addClass("fa-duotone fa-pen");
        var disabledbutton=$('#disabledbutton').val();
        var currentdate=$('#currentdate').val();
        $("#submissionsupplier option[value!=0]").prop('disabled',false);
        $("#supplierstatus option[value!=0]").prop('disabled',false);
        
        
        $.ajax({
            type: "GET",
            url: "{{ url('editcustomerfq') }}/"+suplierid,   
            data: "",
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
                error: function (jqXHR, textStatus, errorThrown) {
                    switch (textStatus) {
                        case 'timeout':
                            toastrMessage('error','The request timed out. Please try again later','Error');
                            break;
                        case 'error':
                            toastrMessage('error','An error occurred:'+errorThrown,'Error');
                        break;
                        case 'abort':
                            toastrMessage('error','The request was aborted.','Error');
                        break;
                        case 'parsererror':
                            toastrMessage('error','Parsing JSON request failed.','Error');
                        break;

                        default:
                                
                                toastrMessage('error','AJAX Error: '+textStatus+','+errorThrown,'Error');
                            break;
                    }
                },
            success: function (response) {
                if(response.success){
                    var isevaulted=response.exist;
                    $.each(response.data, function (index, value) { 
                        $('#submissionsupplier').select2('destroy');
                        $('#submissionsupplier').val(value.customer_id).select2();
                        $('#supplierstatus').select2('destroy');
                        $('#supplierstatus').val(value.status).select2();
                        $('#supname').val(value.contactperson);
                        $('#sphone').val(value.phonenumber);
                        $('#rfqcustomerid').val(value.id);
                        
                        var stat=value.status==''?0:value.status;
                        remark=value.remark==null?'':value.remark;
                        switch (isevaulted) {
                            case true:
                                $("#submissionsupplier option[value!="+value.customer_id+"]").prop("disabled", true);
                                $("#supplierstatus option[value!="+stat+"]").prop("disabled", true);
                                flatpickr('#submitdate', { dateFormat: 'Y-m-d',clickOpens:false,minDate:currentdate});
                                
                                break;
                        
                            default:
                                    $("#submissionsupplier option[value!=0]").prop('disabled',false);
                                    $("#supplierstatus option[value!=0]").prop('disabled',false);
                                
                                    flatpickr('#submitdate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
                                break;
                        }
                        $('#submitdate').val(value.date);
                        $('#submitsupplier').prop('disabled',false);
                    });
                }
            }
        });
    }
    $('body').on('click', '.deletesupplier', function () {
            var id = $(this).data('id');
            var suplierid=$(this).data('suplierid');
            $.ajax({
                type: "GET",
                url:  "{{url('checkevalationisrtart')}}/" + id+"/"+suplierid,
                success: function (response) {
                    switch (response.exist) {
                        case true:
                                toastrMessage('info','Due to this RFQ, it is impossible to remove the supplier; the evaluation process has begun','Info');
                            break;
                        default:
                            switch (response.isaddorder) {
                                case 0:
                                        toastrMessage('info','It is impossible to remove the supplier;','Info');
                                    break;
                            
                                default:
                                    deletesubmitter(suplierid);
                                    break;
                            }
                        
                            break;
                    }
                }
            });
    });
    function deletesubmitter(id) {
        var msg='Are you sure do you want to remove the supplier';
            var title='Conformation';
            var buttontext='Delete';
                swal.fire({
                    title: title,
                    icon: 'question',
                    html: msg,
                    showCancelButton: !0,
                    allowOutsideClick: false,
                    confirmButtonClass: "btn-info",
                    confirmButtonText: buttontext,
                    cancelButtonText: "Cancel",
                    cancelButtonClass: "btn-danger",
                    reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    let token = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: 'GET',
                            url:  "{{url('removesupplier')}}/" + id,
                            data: {_token: token},
                            success: function (resp) {
                                if (resp.success) {
                                    toastrMessage('success',resp.message,'success');
                                    qoutgblIndex=0;
                                    var oTable = $('#supplierlistdatables').dataTable(); 
                                    oTable.fnDraw(false);
                                    var tables = $('#supplierdatatables').dataTable(); 
                                    tables.fnDraw(false);
                                    setminilog(resp.actions);
                                } else {
                                    swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                                    
                                }
                            },
                            error: function (resp) {
                                swal.fire("Error!", 'Something went wrong.', "error");
                            }
                        });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
    }
    $('#allsubmitbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,1);
    });

    $('#changetopendingbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,1);
    });
    $('#verifybutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,2);
    });
    
    $('#approvedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,3);
    });
    $('#prundovoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,4);
    });
    $('#prundorejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,5);
    });
    $('#allsubmitbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,8);
    });

    $('#undoallsubmitbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,9);
    });

    function confirmAction(id,status) {
        var msg='--';
        var title='--';
        var buttontext='--';
        switch (status) {
            case 1:
                    msg='Are you sure do you want to change to pending';
                    title='Confirmation';
                    buttontext='Change To Pending';
                break;
                case 2:
                    msg='Are you sure do you want to verify';
                    title='Confirmation';
                    buttontext='Verify';
                break;
                
                case 3:
                    msg='Are you sure do you want to approved this RFQ';
                    title='Approve';
                    buttontext='Approve';
                break;
                case 4:
                    msg='Are you sure do you want to undo this RFQ';
                    title='Undo';
                    buttontext='Undo';
                break;
                case 5:
                    msg='Are you sure do you want to undo reject this RFQ';
                    title='Undo reject';
                    buttontext='Undo reject';
                break;
                case 6:
                    msg='Are you sure do you want back to verify';
                    title='Confirmation';
                    buttontext='Back To Verify';
                break;
                case 8:
                    msg='Are you sure do you want to submit';
                    title='Confirmation';
                    buttontext='Submit';
                break;
                case 9:
                    msg='Are you sure do you want to undo submission';
                    title='Confirmation';
                    buttontext='Undo Submit';
                break;

            default:
                msg='whoops';
                title='whoops';
                buttontext='whoops';
                break;
        }
            swal.fire({
                title: title,
                icon: 'question',
                html: msg,
                showCancelButton: !0,
                allowOutsideClick: false,
                confirmButtonClass: "btn-info",
                confirmButtonText: buttontext,
                cancelButtonText: "Cancel",
                cancelButtonClass: "btn-danger",
                reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                let token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'GET',
                        url:  "{{url('rfqaction')}}/" + id+'/'+status,
                        data: {_token: token},
                        success: function (resp) {
                            switch (resp.success) {
                                case 200:
                                    toastrMessage('success',resp.message,'success');
                                    showbuttondependonstat(resp.status);
                                    switch (resp.status) {
                                        case 8:
                                            $('#allsubmitbutton').hide();
                                            $('#undoallsubmitbutton').show();
                                            
                                            break;
                                            case 3:
                                                $('#allsubmitbutton').show();
                                                $('#undoallsubmitbutton').hide();
                                            break;
                                        default:
                                                $('#allsubmitbutton').hide();
                                                $('#undoallsubmitbutton').hide();
                                            break;
                                    }
                                    setminilog(resp.actions);
                                    break;
                                case 300:
                                    toastrMessage('error',resp.message,'success');
                                    break;
                                default:
                                    swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                                        var oTable = $('#proformatable').dataTable();
                                        oTable.fnDraw(false);
                                    break;
                            }
                        
                        },
                        error: function (resp) {
                            swal.fire("Error!", 'Something went wrong.', "error");
                        }
                    });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }
    function showbuttondependonstat(status) {
        switch (status) {
            case 0:
                    $('#rfqeditbutton').show();
                    $('#prvoidbuttoninfo').show();
                    $('#changetopendingbutton').show();
                    $('#verifybutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#submissionbutton').hide();
                    $('#prejectbuttoninfo').show();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundovoidbuttoninfo').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#rfqprintbutton').hide();
                    $('#backtoverifybutton').hide();
                    $('#statustitles').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">Draft</span>');
                break;
                case 1:
                    $('#prvoidbuttoninfo').show();
                    $('#backtodraftbutton').show();
                    $('#changetopendingbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#backtoverifybutton').hide();
                    $('#prejectbuttoninfo').show();
                    $('#submissionbutton').hide();
                    $('#approvedbutton').hide();
                    $('#verifybutton').show();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#rfqeditbutton').show();
                    $('#prundorejectbuttoninfo').hide();
                    $('#rfqprintbutton').hide();
                    $('#authorizebutton').hide();
                    $('#statustitles').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">Draft</span>');
                    
                break;
                case 2:
                    $('#prvoidbuttoninfo').show();
                    $('#approvedbutton').show();
                    $('#prejectbuttoninfo').show();
                    $('#backtodraftbutton').hide();
                    $('#submissionbutton').hide();
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#rfqeditbutton').show();
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').show();
                    $('#prundorejectbuttoninfo').hide();
                    $('#rfqprintbutton').hide();
                    $('#backtoverifybutton').hide();
                    $('#changetopendingbutton').hide();
                    $('#statustitles').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df">Verify</span>');
                    
                break;
                case 3:
                    $('#prvoidbuttoninfo').show();
                    $('#prejectbuttoninfo').show();
                    $('#submissionbutton').show();
                    $('#rfqprintbutton').show();
                    $('#approvedbutton').hide();
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#rfqeditbutton').hide();
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#backtoverifybutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#changetopendingbutton').hide();
                    $('#statustitles').html('<span style="color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a">Approved</span>');
                break;
                case 8:
                    $('#prvoidbuttoninfo').show();
                    $('#prejectbuttoninfo').show();
                    $('#submissionbutton').show();
                    $('#rfqprintbutton').show();
                    $('#approvedbutton').hide();
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#rfqeditbutton').hide();
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#backtoverifybutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#changetopendingbutton').hide();
                    $('#statustitles').html('<span style="color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a">Approved/Submitted</span>');
                break;
                case 4:
                    $('#prundovoidbuttoninfo').show();
                    $('#submissionbutton').hide();
                    $('#prejectbuttoninfo').hide();
                    $('#rfqeditbutton').hide();
                    $('#prvoidbuttoninfo').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#submissionbutton').hide();
                    $('#rfqprintbutton').hide();
                    $('#statustitles').html('<span style="color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b">Void</span>');
                break;
                case 5:
                    $('#prundovoidbuttoninfo').hide();
                    $('#prejectbuttoninfo').hide();
                    $('#rfqeditbutton').hide();
                    $('#prvoidbuttoninfo').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').show();
                    $('#submissionbutton').hide();
                    $('#rfqprintbutton').hide();
                    $('#statustitles').html('<span style="color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b">Rejected</span>');
                break;
            default:
                    $('#prundovoidbuttoninfo').hide();
                    $('#prejectbuttoninfo').hide();
                    $('#rfqeditbutton').hide();
                    $('#prvoidbuttoninfo').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#submissionbutton').hide();
                    $('#rfqprintbutton').hide();
                break;
        }
    }
    $('#rfqvoidbutton').click(function(){
        var form = $("#rfqvoidform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('rfqvoid') }}",
            data: formData,
            dataType: "json",
            success: function (response) {
                if(response.errors){
                    if(response.errors.Reason){
                        $('#voidreason-error').html( response.errors.Reason[0]);
                    }
                }
                else if(response.dberrors){
                    toastrMessage('error',response.dberrors,'Error!');
                } 
                else if(response.success){
                    toastrMessage('success','voided succeeesfully','Success');
                    var oTable = $('#rfqtables').dataTable();
                    oTable.fnDraw(false);
                    $('#rfqvoidvoidmodal').modal('hide');
                    $("#docInfoModal").modal('hide');
                }
            }
        });
    });
    $('body').on('click', '.enVoice', function () {
        var id=$('#recordIds').val();
        var customercode=$(this).data('code');
        var link="/rfqattachemnt/"+id+"/"+customercode;
        window.open(link, 'Sale Report', 'width=1200,height=800,scrollbars=yes');
    });
    $('#rfqprintbutton').click(function(){
            var id=$('#recordIds').val();
            var customercode=0;
            var link="/rfqattachemnt/"+id+"/"+customercode;
            window.open(link, 'Purchase request', 'width=1200,height=800,scrollbars=yes');
        });
        $('#backtoverifybutton').click(function(){
            var id=$('#recordIds').val();
            $('#rfqvoidid').val(id);
            $('#rfqtype').val('Verify');
            $("#voidreason").val("");
            $("#rfqvoidbuttonicon").removeClass("fa-solid fa-rotate-left");
            $("#rfqvoidbuttonicon").removeClass("fa-solid fa-trash");
            $("#rfqvoidbuttonicon").addClass("fa-solid fa-rotate-left");
            $("#rfqvoidbutton").find('span').text("Back To Verify");
            $('#rfqvoidvoidmodal').modal('show');
    });
    $('#backtopendingbutton').click(function(){
        var id=$('#recordIds').val();
        $('#rfqvoidid').val(id);
        $('#rfqtype').val('Back');
        $("#voidreason").val("");
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-rotate-left");
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-trash");
        $("#rfqvoidbuttonicon").addClass("fa-solid fa-rotate-left");
        $("#rfqvoidbutton").find('span').text("Back to pending");
        $('#rfqvoidvoidmodal').modal('show');
    });
    $('#backtodraftbutton').click(function(){
        var id=$('#recordIds').val();
        $('#rfqvoidid').val(id);
        $('#rfqtype').val('Draft');
        $("#voidreason").val("");
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-rotate-left");
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-trash");
        $("#rfqvoidbuttonicon").addClass("fa-solid fa-rotate-left");
        $("#rfqvoidbutton").find('span').text("Back to Draft");
        $('#rfqvoidvoidmodal').modal('show');
    });
    $('#prvoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        $('#rfqvoidid').val(id);
        $('#rfqtype').val('Void');
        $("#voidreason").val("")
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-rotate-left");
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-trash");
        $("#rfqvoidbuttonicon").addClass("fa-solid fa-trash");
        $("#rfqvoidbutton").find('span').text("Void");
        $('#rfqvoidvoidmodal').modal('show');
    });
    $('#prejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        $('#rfqvoidid').val(id);
        $('#rfqtype').val('Reject');
        $("#voidreason").val("")
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-rotate-left");
        $("#rfqvoidbuttonicon").removeClass("fa-solid fa-trash");
        $("#rfqvoidbuttonicon").addClass("fa-solid fa-trash");
        $("#rfqvoidbutton").find('span').text("Reject");
        $('#rfqvoidvoidmodal').modal('show');
    });
    function clearvoiderror() {
        $('#voidreason-error').html('');
    }
    $('#rfqeditbutton').click(function(){
        var id=$('#recordIds').val();
        var type='';
        var prid='';
        var arr = [];
        //$("#store option[value!=0]").prop('disabled',false);
        $.ajax({
            type: "GET",
            url: "{{ url('rfqedit') }}/"+id,
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
                            $('#docInfoModal').modal('hide');
                            $('#itemsdatablediv').hide();
                            $('#commuditylistdatablediv').hide();
                            $('#exampleModalScrollable').modal('show');
                    },
            success: function (response) {
                        type=response.type;
                        $('#requeststation').val(response.storename);
                    $.each(response.rfq, function (indexInArray, valueOfElement) { 
                        $('#type').select2('destroy');
                        $('#type').val(valueOfElement.type).select2();
                        $('#evualationrequire').select2('destroy');
                        $('#evualationrequire').val(valueOfElement.evrequire).select2();
                        $('#samplerequire').select2('destroy');
                        $('#samplerequire').val(valueOfElement.samplerequire).select2();

                        $('#purchase').select2('destroy');
                        $('#purchase').val(valueOfElement.purequest_id).select2();
                        $('#date').val(valueOfElement.date);
                        $('#lastsubmittiondate').val(valueOfElement.lastsubmittiondate);
                        $('#rfqid').val(valueOfElement.id);
                        $('#description').val(valueOfElement.reason);
                        $('#documentnumber').val(valueOfElement.documentumber);
                        prid=valueOfElement.purequest_id;
                        $('#supplier').select2('destroy');
                        $.each(valueOfElement.customers, function (indexInArray, valueOfElement) { 
                            arr.push(valueOfElement.id);
                        });
                        $('#supplier').val(arr).select2();
                        switch (valueOfElement.type) {
                            case 'Bid':
                                $('#descriptiondiv').show();
                                $('#supplierdiv').hide();
                                break;
                        
                            default:
                                $('#descriptiondiv').hide();
                                $('#supplierdiv').show();
                                break;
                        }
                    });
                
                switch (type) {
                        case 'Goods':
                            listofpurchaseitem(prid);
                            $('#itemslitsdatablesdiv').show();
                            $('#commoditydatablesdiv').hide();
                            break;
                        default:
                            commuditylist(prid,'commoditydatables');
                            $('#itemslitsdatablesdiv').hide();
                            $('#commoditydatablesdiv').show();
                            break;
                    }
            }
        });
    });
    function itemlistappend(product) {
        j=0;
        $.each(product, function (indexInArray, valueOfElement) { 
            ++j;
            ++m;
            var totalprice=parseFloat(valueOfElement.qty)*parseFloat(valueOfElement.price);
            var remark=valueOfElement.remark==null?'':valueOfElement.remark;
            var tables='<tr id="row'+j+'" class="dynamic-added">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 30%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td><input type="text" name="row['+m+'][Quantity]" placeholder="Quantity" id="quantity'+m+'" value='+valueOfElement.qty+' class="quantity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="row['+m+'][price]" id="unitprice'+m+'" value='+valueOfElement.price+' class="unitprice form-control" placeholder="Estimated Price" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td><input type="text" name="row['+m+'][totalprice]" id="totalprice'+m+'" value='+totalprice+' class="totalprice form-control" placeholder="Total Price" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][remark]" id="remark'+m+'" value="'+remark+'" class="total form-control" placeholder="Enter remark Here" style="font-weight:bold;"/>'+
                '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/>'+
                '<td style="width:6%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>';
            $("#dynamicTable tbody").append(tables);
            var options = $("#hiddenitem > option").clone();
            var options2 = '<option selected value="'+valueOfElement.id+'">'+valueOfElement.Code+', '+valueOfElement.Name+','+valueOfElement.SKUNumber+'</option>';
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+valueOfElement.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();
        });
        CalculateGrandTotal();
    }
    function commoditylistappend(product) {
        j=0;
        $.each(product, function (indexInArray, valueOfElement) { 
            ++j;
            ++m;
            var totalprice=parseFloat(valueOfElement.qty)*parseFloat(valueOfElement.price);
            var remark=valueOfElement.remark==null?'':valueOfElement.remark;
            var tables='<tr id="row'+j+'" class="dynamic-added">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 30%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td><input type="text" name="row['+m+'][Quantity]" placeholder="Quantity" id="quantity'+m+'" value='+valueOfElement.qty+' class="quantity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="row['+m+'][price]" id="unitprice'+m+'" value='+valueOfElement.price+' class="unitprice form-control" placeholder="Estimated Price" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td><input type="text" name="row['+m+'][totalprice]" id="totalprice'+m+'" value='+totalprice+' class="totalprice form-control" placeholder="Total Price" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][remark]" id="remark'+m+'" value="'+remark+'" class="total form-control" placeholder="Enter remark Here" style="font-weight:bold;"/>'+
                '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/>'+
                '<td style="width:6%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>';
            $("#dynamicTable tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var options2 = '<option selected value="'+valueOfElement.id+'">'+valueOfElement.Name+'</option>';
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+valueOfElement.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();
        });
        CalculateGrandTotal();
    }
    $('body').on('click', '.DocPrInfo', function () {
            var recordId = $(this).data('id');
            var types='';
            var prid='';
        $.ajax({
            type: "GET",
            url: "{{ url('rfqinfo') }}/"+recordId,
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
                        $("#collapseOne").collapse('show');
                        $('#docInfoModal').modal('show');
                    },
            success: function (response) {
                    types=response.type;
                    $('#infopurchase').html(response.prno);
                    $('#preparestation').html(response.storename);
                    $('#disabledbutton').val(response.disabledbutton);
                $.each(response.rfq, function (indexInArray, valueOfElement) { 
                    prid=valueOfElement.purequest_id;
                    $('#recordIds').val(valueOfElement.id);
                    $('#inforfq').html(valueOfElement.documentumber);
                    $('#infosource').html(valueOfElement.type);
                    $('#infodate').html(valueOfElement.date);
                    $('#infodescription').html(valueOfElement.reason);
                    $('#infosamplerequire').html(valueOfElement.samplerequire);
                    $('#infoevquire').html(valueOfElement.evrequire);
                    $('#infolastsubmittiondate').html(valueOfElement.lastsubmittiondate);
                    switch (valueOfElement.type) {
                        case 'Bid':
                            $('#bidinformationdiv').show();
                            $('#supplyinformationdiv').hide()
                            break;
                        default:
                            $('#bidinformationdiv').hide();
                            $('#supplyinformationdiv').show();
                            break;
                    }
                    showbuttondependonstat(valueOfElement.status);
                    showsupplier(valueOfElement.id);
                });
                switch (types) {
                    case 'Goods':
                        $('#itemsdatablediv').show();
                        $('#commuditylistdatablediv').hide()
                        itemslist(prid);
                        break;
                    default:
                        $('#itemsdatablediv').hide();
                        $('#commuditylistdatablediv').show();
                        commuditylist(prid,'comuditydocInfoItem');
                        break;
                }
                setminilog(response.actions);
            }
        });
    });
    function setminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#ulist').html('');
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back to pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Reject':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
                    switch (value.action) {
                        case 'Back To Verify':
                            reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                            break;
                        
                        default:
                            reason='';
                            break;
                    }
                    
                break;
                case 'Draft':
                    icons='warning timeline-point';
                    addedclass='text-warning';
                    switch (value.action) {
                        case 'Back To Draft':
                            reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                            break;
                    
                        default:
                            reason='';
                            break;
                    }
                    
                break;
                case 'Approve':
                    icons='success timeline-point';
                    addedclass='text-success';
                    reason='';
                break;
                case 'Authorize':
                    icons='success timeline-point';
                    addedclass='text-success';
                    reason='';
                break;
                case 'Void':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                    break;
                case 'Rejected':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                default:
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='';
                    break;
            }
            list+='<li class="timeline-item"><span class="timeline-point timeline-point-'+icons+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 '+addedclass+'">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i>'+value.user+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span>'+reason+'</div></li>';
        });
            $('#ulist').append(list);
    }
    function showsupplier(params) {
        var status=$('#statustitles').text()||0;
        $('#supplierdatatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-4 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('showsupplier') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'Code',name: 'Code'},
                {data: 'Name',name: 'Name'},
                {data: 'TinNumber',name: 'TinNumber'},
                {data: 'status',name: 'status'},
            ],
            columnDefs: [{
                targets:1,
                render:function (data,type,row,meta) {
                    switch (status) {
                        case 'Approved':
                            var anchor='<a class="enVoice" href="javascript:void(0)"  data-code="'+data+'" data-original-title="" title="RfQ" style="text-decoration:underline;"><span>'+data+'</span></a>';
                            return anchor;
                            break;
                            case 'Approved/Submitted':
                                var anchor='<a class="enVoice" href="javascript:void(0)"  data-code="'+data+'" data-original-title="" title="RfQ" style="text-decoration:underline;"><span>'+data+'</span></a>';
                                return anchor;
                            break;
                        default:
                            return data;
                            break;
                    }
                }
            },
        {
            targets:4,
            render:function (data,type,row,meta) {
                switch (data) {
                    case '1':
                        return 'Submited';
                        break;
                    case '2':
                        return 'Not Submitted';
                        break;
                    default:
                        return '--';
                        break;
                }
            },

        }],
        });
    }
    
    function itemslist(params) {
        $('#itemsdocInfoItem').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('purchaseinfoitemlist') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'Code',name: 'Code'},
                {data: 'Name',name: 'Name'},
                {data: 'SKUNumber',name: 'SKUNumber'},
                {data: 'qty',name: 'qty'},
                {data: 'price',name: 'price'},
                {data: 'price',name: 'price'},
                {data: 'remark',name: 'remark'},
            ],
            columnDefs: [
                {
                    targets: 5,
                    render: function ( data, type, row, meta ) {
                        return '';
                    }
                },{
                    targets: 6,
                    render: function ( data, type, row, meta ) {
                        return '';
                    }
                }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                    // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                sumofqty = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                sumoprice = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var numRows = api.rows( ).count();
                totalprice=parseFloat(sumofqty)*parseFloat(sumoprice);
                var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
            },
        });
    }
    function commuditylist(params,tables) {
        $('#'+tables).DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('purchaseinfocomoditylist') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'RZW',name: 'RZW',width:'15%'},
                {data: 'proccesstype',name: 'proccesstype'},
                {data: 'cropyear',name: 'cropyear'},
                {data: 'grade',name: 'grade'},
                {data: 'totalkg',name: 'totalkg'},
                {data: 'ton',name: 'ton'},
                {data: 'feresula',name: 'feresula'},
                {data: 'price',name: 'price'},
                {data: 'totalprice',name: 'totalprice'},
                {data: 'remark',name: 'remark'},
            ],
            columnDefs: [
                    {
                        targets: 8,
                            render: function ( data, type, row, meta ) {
                                return '';
                            }
                    },
                    {
                        targets: 9,
                            render: function ( data, type, row, meta ) {
                                return '';
                            }
                    },
            ],
        });
    }
    $(document).ready(function () {
        var fyear = $('#fiscalyear').val()||0;
        var currentdate=$('#currentdate').val();
        rfqlist(fyear);
        flatpickr('#lastsubmittiondate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
    });
    $('#fiscalyear').on('change', function() {
        var fyear = $('#fiscalyear').val()||0;
        rfqlist(fyear);
    });
    $('.filter-select').change(function(){
            var search = [];
            $.each($('.filter-select option:selected'), function(){
                search.push($(this).val());
                });
            search = search.join('|');
            rfqtables.column(3).search(search, true, false).draw(); 
    });
    function rfqlist(fyear) {
        rfqtables=$('#rfqtables').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        searchHighlight: true,
        destroy:true,
        lengthMenu: [[50, 100], [50, 100]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        dom:'<"row mt-75"' +
        '<"col-lg-12 col-xl-6" f>' +
        '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1 mt-2"<"mr-1">B>>' +
        '>t' +
        '<"d-flex justify-content-between mx-2 row mb-1"' +
        '<"col-sm-12 col-md-3"i>' +'<"col-sm-12 col-md-6">' +
        '<"col-sm-12 col-md-3"p>' +
        '>',
        buttons: [
            {
            text:'<i data-feather="plus"></i> Add',
            className: 'btn btn-gradient-info btn-sm addbutton',
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
            }
            }
        ],
        ajax: {
        url: "{{ url('rfqslist') }}/"+fyear,
        type: 'GET',
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
            { data:'DT_RowIndex'},
            { data: 'RFQ', name: 'RFQ',orderable: false },
            { data: 'PR', name: 'PR',orderable: false },
            { data: 'PRTYPE', name: 'PRTYPE',orderable: false },
            { data: 'type', name: 'type',orderable: false },
            { data: 'storename', name: 'storename',orderable: false },
            { data: 'date', name: 'date',orderable: false },
            { data: 'lastsubmittiondate', name: 'lastsubmittiondate',orderable: false },
            { data: 'status', name: 'status',orderable: false },
            { data: 'id', name: 'id',orderable: false },
        ],
        columnDefs: [
                        {
                            targets: 8,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 0:
                                            return '<p style="color:#F1941D;font-weight:bold;text-shadow:1px 1px 10px #F1941D;">Draft</p>';
                                    break;
                                    case 1:
                                        return '<p style="color:#F1941D;font-weight:bold;text-shadow:1px 1px 10px #F1941D;">Pending</p>';
                                        
                                    break;
                                    case 2:
                                        return '<p style="color:#4e73df;font-weight:bold;text-shadow:1px 1px 10px #4e73df;">Verified</p>';
                                        
                                    break;
                                    case 3:
                                        return '<p style="color:#1cc88a;font-weight:bold;text-shadow:1px 1px 10px #1cc88a;">Approved</p>';
                                    break;
                                    case 8:
                                        return '<p style="color:#1cc88a;font-weight:bold;text-shadow:1px 1px 10px #1cc88a;">Approved/Submitted</p>';
                                    break;
                                    case 4:
                                        return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Void</p>';
                                    break;
                                    case 5:
                                        return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Reject</p>';
                                    break;
                                    default:
                                        return '---';
                                        break;
                                }
                            }
                        },
                        {
                            targets: 9,
                            render: function ( data, type, row, meta ) {
                                var anchor='<a class="DocPrInfo" href="javascript:void(0)" data-id='+data+' title="View sales"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                                return anchor;
                            }
                        },
                ],
        });
    }
    function setFocus(){ 
        $($('#rfqtables tbody > tr')[gblIndex]).addClass('selected');  
    }
    $('#rfqtables tbody').on('click', 'tr', function () {
            $('#rfqtables tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
    });
    
    $('#purchase').on('change', function () {
        $('#purchase-error').html('');
        var purchase=$('#purchase').val();
        var type='';
        $.ajax({
            type: "GET",
            url: "{{ url('getstores') }}/"+purchase,
            success: function (response) {
                $('#requeststation').val(response.storename);
                switch (response.type) {
                    case 'Commodity':
                            listofpurchasecommoduty(purchase);
                            $('#itemslitsdatablesdiv').hide();
                            $('#commoditydatablesdiv').show();
                        break;
                    default:
                            listofpurchaseitem(purchase);
                            $('#itemslitsdatablesdiv').show();
                            $('#commoditydatablesdiv').hide();
                        break;
                }
            }
        });
        
    });
    function listofpurchasecommoduty(params) {

        $('#commoditydatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('purchaseinfocomoditylist') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'RZW',name: 'RZW',width:'15%'},
                {data: 'proccesstype',name: 'proccesstype'},
                {data: 'cropyear',name: 'cropyear'},
                {data: 'grade',name: 'grade'},
                {data: 'totalkg',name: 'totalkg'},
                {data: 'ton',name: 'ton'},
                {data: 'feresula',name: 'feresula'},
                {data: 'price',name: 'price'},
                {data: 'totalprice',name: 'totalprice'},
                {data: 'remark',name: 'remark'},
            ],
            columnDefs: [
                        {
                            targets: 8,
                            render: function ( data, type, row, meta ) {
                                
                                return '';
                            }
                        },
                        {
                            targets: 9,
                            render: function ( data, type, row, meta ) {
                                
                                return '';
                            }
                        }
                        ],
            "footerCallback": function ( row, data, start, end, display ) {
                
            },
        });
    }
    function listofpurchaseitem(params) {
        $('#itemslitsdatables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            paging: false,
            ordering:false,
            info: false,
            searchHighlight: true,
            destroy:true,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('purchaseinfoitemlist') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'Code',name: 'Code'},
                {data: 'Name',name: 'Name'},
                {data: 'SKUNumber',name: 'SKUNumber'},
                {data: 'qty',name: 'qty'},
                {data: 'price',name: 'price'},
                {data: 'price',name: 'price'},
                {data: 'remark',name: 'remark'},
            ],
                columnDefs: [
                        {
                            targets: 5,
                            render: function ( data, type, row, meta ) {
                                
                                return '';
                            }
                        },
                        {
                            targets: 6,
                            render: function ( data, type, row, meta ) {
                                
                                return '';
                            }
                        }
                        ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                    // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                sumofqty = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                sumoprice = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var numRows = api.rows( ).count();
                totalprice=parseFloat(sumofqty)*parseFloat(sumoprice);
                var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
            },
        });
    }
    $('#type').on('change', function () {
        var type=$('#type').val();
        switch (type) {
            case 'Bid':
                $('#descriptiondiv').show();
                $('#supplierdiv').hide();
                break;
        
            default:
                $('#descriptiondiv').hide();
                $('#supplierdiv').show();
                break;
        }
        $('#type-error').html('');
    });
    $('#supplier').on('change', function () {
        $('#supplier-error').html('');
    });
    $('#date').on('change', function () {
        $('#date-error').html('');
    });
    $('#lastsubmittiondate').on('change', function () {
        $('#lastsubmittiondate-error').html('');
    });
    $('#samplerequire').on('change', function () {
        $('#samplerequire-error').html('');
    });
    $('#evualationrequire').on('change', function () {
        $('#evualationrequire-error').html('');
    });
    function closeinlineFormModalWithClearValidation() {
        $('.rmerror').html('');
    }
    $('#savebutton').click(function(){
        rfqsave();
    });
    
    function rfqsave() {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        var id=$('#rfqid').val()||0;
        $.ajax({
            type: "POST",
            url: "{{ url('rfqsave') }}",
            data: formData,
            dataType: "json",
                    beforeSend: function () {
                        cardSection.block({
                            message:
                            '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mt-0">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                if(response.success){
                    toastrMessage('success','Successfully Saved','Save');
                    $("#exampleModalScrollable").modal('hide');
                    var oTable = $('#rfqtables').dataTable();
                    oTable.fnDraw(false);
                    switch (id) {
                        case 0:
                            gblIndex=gblIndex+1;
                            break;
                        default:
                            gblIndex= gblIndex;
                            break;
                    }
                }
                else if(response.errors){
                    if(response.errors.purchase){
                        $('#purchase-error').html( response.errors.purchase[0]);
                    }
                    if(response.errors.type){
                        $('#type-error').html( response.errors.type[0]);
                    }
                    if(response.errors.date){
                        $('#date-error').html( response.errors.date[0]);
                    }
                    if(response.errors.lastsubmittiondate){
                        var text=response.errors.lastsubmittiondate[0];
                        text = text.replace("lastsubmittiondate", "Dead Line");
                        $('#lastsubmittiondate-error').html(text);
                    }
                    if(response.errors.supplier){
                        $('#supplier-error').html( response.errors.supplier[0]);
                    }
                    if(response.errors.description){
                        $('#description-error').html( response.errors.description[0]);
                    }
                    if(response.errors.evualationrequire){
                        var text=response.errors.evualationrequire[0];
                        text = text.replace("evualationrequire", "Evalualation");
                        $('#evualationrequire-error').html( text);
                    } 
                    if(response.errors.samplerequire){
                        var text=response.errors.samplerequire[0];
                        text = text.replace("samplerequire", "Sample");
                        $('#samplerequire-error').html(text);
                    }

                }
                else if(response.dberrors){
                    toastrMessage('error',response.dberrors,'Error!');
                } 
            }
        });
    }
</script>
@endsection
