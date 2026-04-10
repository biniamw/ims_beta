@extends('layout.app1')
@section('title')
@endsection
@section('content')
<div class="app-content content">
        <section id="responsive-datatable11">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Payment Order Report</h3>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%;">
                                <div style="width:98%; margin-left:2%; margin-top:2%;">
                                    <form id="salesbycustomereportform">
                                    
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;color">Fiscal Year<b style="color:red;">*</b></label> 
                                                <select class="selectpicker form-control fyear"  name="fiscalYear" id="fiscalYear" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="Year ({0})" data-live-search-placeholder="search Fiscal Year" title="Select Fiscal Year">
                                                @foreach ($fiscalyears as $key)
                                                    <option value="{{$key->FiscalYear}}">{{$key->Monthrange}}  </option>
                                                @endforeach
                                                </select>
                                                <span class="text-danger">
                                            <strong id="fiscalYear-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2 errorclear">
                                                <label strong style="font-size: 14px;color">Select Date Range</label> <b style="color:red;">*</b>
                                                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                                    <i class="fa fa-calendar"></i>&nbsp;
                                                    <span></span> <i class="fa fa-caret-down"></i>
                                                    <input type="hidden" name="from" id="datefrom">
                                                    <input type="hidden" name="to" id="dateto">
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="range-error"></strong>
                                                </span>
                                        </div>
                                        
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2 errorclear">
                                            <label strong style="font-size: 14px;color">Supplier</label> <b style="color:red;">*</b>
                                                <select class="selectpicker form-control suplier" name="supplier[]" id="supplier" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="({0}) Selected" data-live-search-placeholder="search supplier type" title="Select supplier" multiple >
                                                </select>
                                            <span class="text-danger">
                                                <strong id="supplier-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 errorclear">
                                                    <label strong style="font-size: 14px;color">Reference#.</label> <b style="color:red;">*</b>
                                                        <select class="selectpicker form-control po" name="po[]" id="po" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="({0}) Selected" data-live-search-placeholder="search reference" title="Select reference" multiple>
                                                        </select>
                                            <span class="text-danger"><strong id="po-error"></strong></span>
                                        </div>
                                            
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2 errorclear">
                                            <label strong style="font-size: 14px;color">Commodity</label> <b style="color:red;">*</b>
                                            <div>
                                            <select class="selectpicker form-control cmdty" name="commodity[]" id="commodity" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="({0}) Selected" data-live-search-placeholder="Search Commodity" title="Select Commodity" multiple>
                                                
                                            </select>
                                                </div>
                                                <span class="text-danger">
                                            <strong id="commodity-error"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 errorclear">
                                            <label strong style="font-size: 14px;color">Preparation</label> <b style="color:red;">*</b>
                                            
                                            <select class=" selectpicker form-control" name="preparation[]" id="preparation" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="({0}) Selected" data-live-search-placeholder="Search preparation" title="Select Preparation" multiple>
                                                <option value="--">--</option>
                                                @foreach ($proccesstype as $key)
                                                        <option value="{{$key->ProcessType}}">{{$key->ProcessType}}  </option>
                                                    @endforeach
                                            </select>
                                            
                                                <span class="text-danger">
                                            <strong id="preparation-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 errorclear">
                                            <label strong style="font-size: 14px;color">Crop Year</label> <b style="color:red;">*</b>
                                            
                                            <select class="selectpicker form-control crpy" name="cropyear[]" id="cropyear" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="({0}) Selected" data-live-search-placeholder="Search Crop Year" title="Select Crop Year" multiple>
                                                <option value="--">--</option>
                                                @foreach ($cropyear as $key)
                                                        <option value="{{$key->CropYear}}">{{$key->CropYear}}</option>
                                                    @endforeach
                                            </select>
                                            
                                            <span class="text-danger">
                                                    <strong id="cropyear-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 errorclear">
                                            <label strong style="font-size: 14px;color">Grade</label> <b style="color:red;">*</b>
                                            
                                            <select class="selectpicker form-control grde" name="grade[]" id="grade" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="({0}) Selected" data-live-search-placeholder="Search Grade" title="Select Grade" multiple>
                                                <option value="--">--</option>
                                                @foreach ($grade as $key)
                                                        <option value="{{$key->Grade}}">{{$key->Grade}}</option>
                                                    @endforeach
                                            </select>
                                            
                                                <span class="text-danger">
                                            <strong id="grade-error"></strong>
                                            </span>
                                        </div>

                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2 errorclear">
                                                <label strong style="font-size: 14px;color">Status</label> <b style="color:red;">*</b>
                                                <div>
                                                <select class="selectpicker form-control sp stat" name="status[]" id="status" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text=" ({0}) Selected" data-live-search-placeholder="Search Status" title="Select Status" multiple>
                                                        <option value="3">Approved</option>
                                                        <option value="5">Reject</option>
                                                        <option value="4">Void</option>
                                                </select>
                                                    </div>
                                                    <span class="text-danger">
                                                <strong id="status-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                    <input type="hidden" id="search-blocked" value="0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1" unchecked />
                                                        <label class="custom-control-label chboxlbl" for="customCheck1"><b>Select All Filters</b></label>
                                                    </div>
                                                    
                                            </div>

                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                <div style="text-align: left;">
                                                    <button id="paymentrequesreportbutton" type="button" class="btn btn-info btn-sm"><i data-feather='file-text'></i>  View</button>
                                                    <div class="btn-group dropdown" id="exportdiv" style="display: none;">
                                                        <button type="button" class="btn btn-info dropdown-toggle hide-arrow btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span> Print / Export </span><i class="fa fa-caret-down"></i>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <button id="printtable" type="button" class="dropdown-item" ><i class="fa fa-print" aria-hidden="true"></i>  Print</button>
                                                            <button id="downloatoexcel" type="button"  class="dropdown-item"><i class="fa fa-file-excel" aria-hidden="true"></i>To Excel</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="responsive-datatable" style="display: none;">
                                        <div class="col-12">
                                            <table id="salesReportByCustomer" class="display"  cellspacing="0" name="table" style="width: 100%;color:black;">
                                                <thead>
                                                        <tr style="display: none;" id="compinfotr">
                                                            <td colspan="20">
                                                                <table id="headertables"class="headerTable" style="border-bottom: 1px solid black; margin-top:-60px;" style="width:100%;">
                                                                </table>
                                                            </td>
                                                    </tr>
                                                        <tr style="color:white; border: 1px solid white;">
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">#</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Supplier Name</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Type</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">PO#</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Commodity</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Grade</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Crop Year</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Preparation</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">UOM</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">No Of Bag</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Bagweigt</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Net KG</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Feresula</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Unit Price</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Total</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">Peid</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">istaxable</th>
                                                        <th style="color:white; border: 1px solid white;background-color:#00cfe8;">poid</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr style="color: black;">
                                                        <th colspan="14" style="background:#f2f3f4;border: 0.1px solid black;"><h6 style="text-align: right;color:black;font-weight:bold;font-size:13px;">Sub Total</h6></th>
                                                        <th id='totalpaidamounts' style="border: 0.1px solid black;"></th>
                                                    
                                                    </tr>
                                                    <tr style="color: black;">
                                                        <th colspan="14" style="background:#f2f3f4;border: 0.1px solid black;"><h6 style="text-align: right;color:black;font-weight:bold;font-size:13px;">Tax</h6></th>
                                                        <th id='totaltax' style="border: 0.1px solid black;"></th>
                                                    </tr>
                                                    <tr style="color: black;">
                                                        <th colspan="14" style="background:#f2f3f4;border: 0.1px solid black;"><h6 style="text-align: right;color:black;font-weight:bold;font-size:13px;">Grand Total</h6></th>
                                                        <th id='totalgrand' style="border: 0.1px solid black;"></th>
                                                    </tr>
                                                    <tr style="color: black;">
                                                        <th colspan="14" style="background:#f2f3f4;border: 0.1px solid black;"><h6 style="text-align: right;color:black;font-weight:bold;font-size:13px;">Withold(2%)</h6></th>
                                                        <th id='totalwithold' style="border: 0.1px solid black;"></th>
                                                    </tr>
                                                    <tr style="color: black;">
                                                        <th colspan="14" style="background:#f2f3f4;border: 0.1px solid black;"><h6 style="text-align: right;color:black;font-weight:bold;font-size:13px;">Net Pay</h6></th>
                                                        <th id='totalnetpay' style="border: 0.1px solid black;"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
        </section>
    </div>

    <div class="modal modal-slide-in event-sidebar fade" id="paymentrequestinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Payment Request Information</h5>
                        <h5 style="text-align: right;" id="paymentrequestinfoStatus" class="modal-title">status</h5>
                        
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-xl-12" id="docinfo-block">
                                <div class="card collapse-icon">
                                    <div class="collapse-default" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#payrcollapseOne" aria-expanded="false" aria-controls="payrcollapseOne">
                                                <span class="lead collapse-title">Payment Request Details</span>
                                                
                                            </div>
                                            <div id="payrcollapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-2 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Basic Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table-responsive">
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Payment Request No: </label></td>
                                                                            <td><b><label id="parydocno" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                            <td><b><label id="payrinforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr class="potr">
                                                                            <td><label strong style="font-size: 12px;">Puchase Order#: </label></td>
                                                                            <td><b><label id="payrinfoporder" strong style="font-size: 12px;" class="paymentrequestinfopo" strong style="font-size: 16px; font-weight: bold;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Payment Reference: </label></td>
                                                                            <td><b><label class="paymentrefernceclass" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                            <td><b><label id="payrinfocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                            <td><b><label id="payrinfocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                            <td><b><label id="payrinfocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                            <td><b><label id="payrinfodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Supplier Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table-responsive">
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">ID: </label></td>
                                                                        <td><b><label id="paymentrequestinfosuppid" strong style="font-size: 12px;"></label></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">Name: </label></td>
                                                                        <td><b><label id="paymentrequestinfsupname" strong style="font-size: 12px;"></label></b></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label strong style="font-size: 12px;">TIN: </label></td>
                                                                        <td><b><label id="paymentrequestinfosupptin" strong style="font-size: 12px;"></label></b></td>
                                                                    </tr>
                                                                    
                                                                    </table>
                                                                    <div class="divider divider-secondary">
                                                                        <div class="divider-text"><b>Memo</b></div>
                                                                    </div>

                                                                    <table class="table-responsive">
                                                                        
                                                                        <tr>
                                                                            <td><label id="paymentrequestinfomemo" class="paymentrequestinfopurpose" strong style="font-size: 12px;"></label></td>
                                                                        </tr>
                                                                        
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Attached Document</h6>
                                                                </div>
                                                                <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                    <iframe src="" id="pdfviewer" width="100%" height="400px"></iframe>
                                                                </div>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                        {{-- <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Action</h6>
                                                                </div>
                                                                <div class="card-body scroll scrdiv">
                                                                    <ul class="timeline" id="ulist" style="height:25rem;">
                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                            <h5>Actions</h5>
                                                            <div class="scroll scrdiv">
                                                                    <ul class="timeline" id="paymentrequestulist" style="height:18rem;">
                                                                    
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
                        <div class="col-xl-12 col-lg-12" id="paymentinfordirectprice">
                            <div class="divider divider-secondary">
                                <div class="divider-text directdivider">Payment Details</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-12">

                                </div>
                                <div class="col-xl-4 col-lg-12">
                                    <table style="width:100%;" class="rtable">
                                        <tr>
                                            <td colspan="2" style="text-align: center;"><b>Payment Information</b></td> 
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Reference</label></td>
                                            <td style="text-align: center; width:25%;"><label id="" strong style="font-size: 16px; font-weight: bold;"> Direct</label></td>
                                        </tr> 
                                        <tr>
                                            <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Mode</label></td>
                                            <td style="text-align: center; width:25%;"><label id="" strong style="font-size: 16px; font-weight: bold;">Pre Finance</label></td>
                                        </tr>       
                                        <tr>
                                            <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">To be paid</label></td>
                                            <td style="text-align: center; width:25%;"><label id="directpopayrinfopaidamount" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Status</label></td>
                                            <td style="text-align: center; width:25%;"><label id="" strong style="font-size: 16px; font-weight: bold;">Direct</label></td>
                                        </tr>
                                    </table>
                            </div>
                            <div class="col-xl-4 col-lg-12">
                                    <table class="table-responsive">
                                        <tr style="text-align: center;">
                                            <td><label strong style="font-size: 12px;"><b>Purpose of payment</b></label></td>
                                        </tr>
                                        <tr>
                                            <td><label id="directpaymentrequestinfopurpose" class="paymentrequestinfopurpose" strong style="font-size: 12px;"></label></td>
                                        </tr>
                                        
                                    </table>
                            </div>
                            <div class="col-xl-5 col-lg-12">
                                
                            </div>
                        </div>
                    </div>

                        
                        
                        <div id="commodityrowinfo" class="scroll scrdiv">
                            <div class="divider divider-info">
                                <div class="divider-text directdivider">Commodity</div>
                            </div>

                        <table id="payrinfodirectdynamicTablecommdity" class="display table-bordered table-striped table-hover dt-responsive mb-0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Good Recieving#</th>
                                            <th>Purchase Invoice#</th>
                                            <th>Commodity</th>
                                            <th>Grade</th>
                                            <th>Preparation</th>
                                            <th>Crop year</th>
                                            <th>UOM/Bag</th>
                                            <th>No of Bag</th>
                                            <th>Bag Weight KG</th>
                                            <th>Total KG</th>
                                            <th>Net KG</th>
                                            <th>TON</th>
                                            <th>Feresula</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                            <th colspan="2" style="text-align: right;">Total</th>
                                            <th id="infonofbagtotal"></th>
                                            <th id="infobagweighttotal"></th>
                                            <th id="infokgtotal"></th>
                                            <th id="infonetkgtotal"></th>
                                            <th id="infotontotal"></th>
                                            <th id="infopriceferesula"></th>
                                            <th id="infopricetotal"></th>
                                            <th id="infototalpricetotal"></th>
                                        </tr>
                                    </tfoot>
                        </table>
                        
                        <div class="row">
                                
                                <div class="col-xl-9 col-lg-12">
                                    <div class="divider divider-secondary">
                                        <div class="divider-text directdivider">Payment Details</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-12">
                                                <table style="width:100%;" class="rtable">
                                                    <tr>
                                                        <td colspan="4" style="text-align: center;"><b>Payment Information</b><br>
                                                            <label>Purchase Order#</label><label class="paymentrequestinfopo" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td> 
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment Request</b></label></td>
                                                        
                                                        <td colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;"><b>Payment History</b></label></td>
                                                    
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Reference</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinfopaymentreference" class="paymentrefernceclass" strong style="font-size: 16px; "></label></td>
                                                        
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Total Amount</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinfototalpayamount" class="lbl" strong style="font-size: 16px;"></label></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">To be paid</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinfopaidamount" class="lbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                        
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Paid Amount</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinfopayamount" class="lbl infopaidamount" strong style="font-size: 16px; "></label></td>
                                                        
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Status</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinfopaymentstatus" strong style="font-size: 16px;"></label></td>
                                                        
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Remaining Amount</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinforemainamount" class="lbl inforemainamount" strong style="font-size: 16px;"></label></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right; width:25%;"><label strong style="font-size: 16px;">Payment Mode</label></td>
                                                        <td style="text-align: center; width:25%;"><label id="payrinfopaymentmode" class="lbl" strong style="font-size: 16px; "></label></td>
                                                        <td colspan="2" style="text-align: center; width:25%;"><label strong style="font-size: 16px;font-weight: bold;" id="payrinfoviewpaymenthistory"></label></td>
                                                        
                                                    </tr>
                                                    
                                                    
                                            </table>
                                
                            </div>
                                <div class="col-xl-4 col-lg-12">
                                    <table  style="width:100%;">
                                    <tr style="text-align: center;">
                                        <td><label strong style="font-size: 12px;"><b>Purpose Of Payment</b> </label></td>
                                        
                                    </tr>

                                    <tr>
                                        <td><label id="paymentrequestinfopurpose" class="paymentrequestinfopurpose" strong style="font-size: 12px;"></label></td>
                                    </tr>
                                </table>  
                            </div>

                            </div>
                        </div>
                                <div class="col-xl-3 col-lg-12 mt-1">
                                    <table style="width:100%;" id="directpricetable" class="rtable">
                                        <tr>
                                            <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                            <td style="text-align: center; width:50%;"><label id="grndirectsubtotalLbl" class="lbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                        </tr>
                                        <tr id="infodirecttaxtr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                            <td style="text-align: center;"><label id="grndirecttaxLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                        </tr>
                                        <tr id="grndirectgrandtotaltr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                            <td style="text-align: center;"><label id="grndirectgrandtotalLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                        </tr>
                                        <tr id="grndirectwitholdingTr" style="display: visible;">
                                        <td style="text-align: right;"><label id="grndirectwithodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                        <td style="text-align: center;">
                                            <label id="grndirectwitholdingAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                    <tr id="grndirectvatTr" style="display: none;">
                                        <td style="text-align: right;"><label id="vatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                        <td style="text-align: center;">
                                            <label id="grnvatAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                        </td>
                                    </tr>
                                    <tr id="grndirectnetpayTr" style="display: visible;">
                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                        <td style="text-align: center;">
                                            <label id="grndirectnetpayLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                            
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="text-align: right;"><label strong style="font-size: 16px;">No. Of Products</label></td>
                                        <td style="text-align: center;"><label id="grndirectnumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                    </tr>
                                    </table>
                                </div>
                    </div>
                </div>

                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-12">
                                    <input type="hidden" placeholder="" class="form-control" name="pyrrecordIds" id="pyrrecordIds" readonly="true"/>
                                    <button type="button" id="pyrprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                </div>
                                <div class="col-xl-4 col-lg-12" style="text-align:right;">
                                    <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal to  of po srtart-->
    <div class="modal modal-slide-in event-sidebar fade" id="modals-slide-in" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Purchase Order Information</h5>
                        <h5 style="text-align: right;" id="infoStatus" class="modal-title">status</h5>
                        
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-xl-12" id="docinfo-block">
                                <div class="card collapse-icon">
                                    <div class="collapse-default" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <span class="lead collapse-title">Purchase order Details</span>
                                                
                                            </div>
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Puchase order information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table-responsive">
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                            <td><b><label id="inforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr class="infopetr">
                                                                            <td><label strong style="font-size: 12px;">Reference#: </label></td>
                                                                            <td><b><label id="infope" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Purchase Order No: </label></td>
                                                                            <td><b><label id="infopo" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                            <td><b><label id="infocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                            <td><b><label id="infocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                            <td><b><label id="infocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                            <td><b><label id="infodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr class="infodirect">
                                                                            <td><label strong style="font-size: 12px;">Order Date: </label></td>
                                                                            <td><b><label id="inforderdate" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr class="infodirect">
                                                                            <td><label strong style="font-size: 12px;">Deliver Date: </label></td>
                                                                            <td><b><label id="infodeliverdate" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr class="infodirect">
                                                                            <td><label strong style="font-size: 12px;">Station: </label></td>
                                                                            <td><b><label id="infowarehouse" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr class="infodirect">
                                                                            <td><label strong style="font-size: 12px;">Payment Term: </label></td>
                                                                            <td><b><label id="infopaymenterm" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-12" id="directsupplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Supplier Information</h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <table class="table-responsive">
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">ID: </label></td>
                                                                            <td><b><label id="infosuppid" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">Name: </label></td>
                                                                            <td><b><label id="infsupname" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><label strong style="font-size: 12px;">TIN: </label></td>
                                                                            <td><b><label id="infosupptin" strong style="font-size: 12px;"></label></b></td>
                                                                        </tr>
                                                                    
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        {{-- <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="card-title">Action</h6>
                                                                </div>
                                                                <div class="card-body scroll scrdiv">
                                                                    <ul class="timeline" id="ulist" style="height:25rem;">
                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                            <h5>Actions</h5>
                                                            <div class="scroll scrdiv">
                                                                <ul class="timeline" id="ulist" style="height:20rem;">
                                                                        
                                                                </ul>
                                                                <ul class="timeline" id="ulistsupplier" style="height:25rem;">
                                                                    
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
                            <div class="divider-text directdivider">Commodity</div>
                        </div>
                        <div id="directcommuditylistdatabledivinfo" class="scroll scrdiv">
                            <table id="directcommudityinfodatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Commodity</th>
                                        <th>Crop Year</th>
                                        <th>Proccess Type</th>
                                        <th>Grade</th>
                                        <th>UOM/Bag</th>
                                        <th>No. of Bag</th>
                                        <th>Bag Weight Kg</th>
                                        <th>Total Kg</th>
                                        <th>Net Kg</th>
                                        <th>TON</th>
                                        <th>Feresula</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                        <tr>
                                        <td class="tdcolspan" id="tdcolspan" colspan="4" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                        <th colspan="2" style="text-align: right;">Total</th>
                                        <th id="infonofbagtotal"></th>
                                        <th id="infobagweighttotal"></th>
                                        <th id="infokgtotal"></th>
                                        <th id="infonetkgtotal"></th>
                                        <th id="infotontotal"></th>
                                        <th id="infopriceferesula"></th>
                                        <th id="infopricetotal"></th>
                                        <th id="infototalpricetotal"></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-xl-9 col-lg-12"></div>
                                <div class="col-xl-3 col-lg-12 mt-1">
                                    <table style="width:100%;" id="directinfopricetable" class="rtable">
                                        <tr>
                                            <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                            <td style="text-align: center; width:50%;"><label id="directinfosubtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                            
                                        </tr>
                                        <tr id="supplierinfotaxtr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                            <td style="text-align: center;"><label id="directinfotaxLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                        
                                        </tr>
                                        <tr id="supplierinforandtotaltr" style="display: visible;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                            <td style="text-align: center;"><label id="directinfograndtotalLbl" strong style="font-size: 16px; font-weight: bold;" ></label></td>
                                            
                                        </tr>
                                        <tr id="visibleinfowitholdingTr" style="display: visible;">
                                            <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                            <td style="text-align: center;">
                                                <label id="directinfowitholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                
                                            </td>
                                        </tr>
                                        <tr id="directinfovatTr" style="display: none;">
                                            <td style="text-align: right;"><label id="supplierinfovatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                            <td style="text-align: center;">
                                                <label id="directinfovatAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                            
                                            </td>
                                        </tr>
                                        <tr id="directinfonetpayTr" style="display: none;">
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                            <td style="text-align: center;">
                                                <label id="directinfonetpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                                
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                            <td style="text-align: center;"><label id="directinfonumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                            
                                        </tr>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-8 col-lg-12">
                                    <input type="hidden" placeholder="" class="form-control" name="porecordIds" id="porecordIds" readonly="true"/>
                                    <button type="button" id="poprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                </div>
                                <div class="col-xl-4 col-lg-12" style="text-align:right;">
                                    <button  type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal of po Ends-->
        <!-- Modal to add new user starts-->
                        <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-inpaymenthistory">
                            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;"> 
                                <form class="add-new-user modal-content pt-0">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                                    <div class="modal-header mb-1">
                                        <h5 class="modal-title" id="paymenthistorystatus"></h5>
                                    </div>
                                        <div class="modal-body flex-grow-1">
                                                        <table class="table-responsive">
                                                                
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Purchase Order#: </label></td>
                                                                    <td><b><label id="payrinfopo" class="paymentrequestinfopo" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                
                                                        </table>
                                                    <div class="card-datatable">
                                                        <div style="width:98%; margin-left:1%" class="" id="table-block">
                                                        <table id="historypcontracttables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Payment Reqeust#</th>
                                                                    <th>Reference</th>
                                                                    <th>Payment Reference</th>
                                                                    <th>Payment Mode</th>
                                                                    <th>Payment Status</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Paid Amount</th>
                                                                    
                                                                </tr>
                                                                
                                                            </thead>
                                                            <tbody></tbody>
                                                            <tfoot>
                                                                
                                                                <tr>
                                                                    <td colspan="6" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                                                    <th colspan="2" style="text-align: right;">Purchase Order Amount</th>
                                                                    <th id="historytotalamount" style='font-size:13px;color:black;font-weight:bold;'></th>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                                                    <th colspan="2" style="text-align: right;">Paid Amount</th>
                                                                    <th id="historypaidamount"></th>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="6" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                                                    <th colspan="2" style="text-align: right;">Purchase Order Remaining Amount</th>
                                                                    <th id="historyremainamount"></th>
                                                                    
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                            </div>
                                        </div>

                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-outline-danger waves-effect" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal modal-slide-in event-sidebar fade" id="recievingdocInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
            <div class="modal-content p-0">
                <div class="modal-header">
                    <h4 class="modal-title" id="receivinginfomodaltitle">Receiving Information</h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="closeInfoModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                    <div class="modal-body">
                        <form id="holdInfo">
                        @csrf
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-6 col-12">
                                            <section id="collapsible">
                                                <div class="card collapse-icon">
                                                    <div class="collapse-default">
                                                        <div class="card">
                                                            <div id="reciveheadingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="recivecollapse1">
                                                                <span class="lead collapse-title">Basic, Delivery, Receiving & Other Information</span>
                                                                <div style="text-align: right;" id="statustitles"></div>
                                                            </div>
                                                            <div id="recivecollapse1" role="tabpanel" aria-labelledby="reciveheadingCollapse1" class="collapse infoscl">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Basic Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <table style="width: 100%">
                                                                                            <tr>
                                                                                                <td style="width: 40%"><label style="font-size: 14px;">Document No.</label></td>
                                                                                                <td style="width: 60%"><label class="font-weight-bolder infolbls" id="infoDocDocNo" style="font-size: 14px;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Reference</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="referenceLbl"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Reference No.</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="purchaseOrdLbl"></label></td>
                                                                                            </tr>
                                                                                            <tr style="display: none;" id="commoditySrcRow">
                                                                                                <td><label style="font-size: 14px;">Commodity Source</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="commoditySrcLbl"></label></td>
                                                                                            </tr>
                                                                                            <tr style="display: none;" id="commodityTypeRow">
                                                                                                <td><label style="font-size: 14px;">Commodity Type</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="commodityTypeLbl"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Product Type</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="productTypeLbl"></label></td>
                                                                                            </tr>
                                                                                            <tr style="display: none;">
                                                                                                <td><label style="font-size: 14px;">Supplier Category</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoDocCustomerCategory"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Supplier Name</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoDocCustomerName"></label></td>
                                                                                            </tr>
                                                                                            <tr style="display: none;">
                                                                                                <td><label style="font-size: 14px;">TIN</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infotinnumberlbl"></label></td>
                                                                                            </tr>
                                                                                            <tr style="display: none;">
                                                                                                <td><label style="font-size: 14px;">VAT #</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infovatnumberlbl"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label style="font-size: 14px;">Company Type</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="companyTypeLbl"></label></td>
                                                                                            </tr>
                                                                                            <tr style="display: none;" id="customerOwnerRec">
                                                                                                <td><label style="font-size: 14px;">Customer</label></td>
                                                                                                <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="customerOrOwnerLbl"></label></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-5 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Delivery, Receiving & Other Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <table style="width: 100%">
                                                                                        <tr>
                                                                                            <td style="width:27%;"><label style="font-size: 14px;">Delivery Order No.</label></td>
                                                                                            <td style="width:73%;"><label class="font-weight-bolder infolbls" id="deliveryOrderLbl" style="font-size: 14px;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Dispatch Station</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" id="dispatchStationLbl" style="font-size: 14px;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Receiving Station</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="infoDocReceivingStore"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Received By</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="receivedByLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Driver Name</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="driverNameLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Plate No.</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="plateNumberLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Driver Phone No.</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="driverPhoneLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Delivered By</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="deliveredByLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Received Date</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="receivedDateLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Invoice Status</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="invoiceStatusLbl"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Remark</label></td>
                                                                                            <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="remarkLbl"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-3 col-md-6 col-12">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Action Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:20rem">
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
                                    <div class="table-responsive">
                                        <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                                        <label style="font-size: 14px;display:none;" id="infoDocType" style="font-size: 12px;"></label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <div class="datatableinfocls" id="infoGoodsDatatable">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12">
                                                    <table id="docInfoItem" class="display table-bordered table-striped table-hover dt-responsive">
                                                        <thead>
                                                            <th>id</th>
                                                            <th>#</th>
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
                                            </div>
                                            
                                        </div>
                                        <div class="datatableinfocls" id="infoCommDatatable">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12">
                                                    <table id="origindetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 infodatatbl" style="width: 100%">
                                                        <thead> 
                                                            <tr>
                                                                <th style="width:2%;">#</th>
                                                                <th style="width:6%;">Floor Map</th>
                                                                <th style="width:6%;">Type</th>
                                                                <th style="width:8%">Commodity</th>
                                                                <th style="width:6%">Grade</th>
                                                                <th style="width:6%">Process Type</th>
                                                                <th style="width:6%">Crop Year</th>
                                                                <th style="width:6%">UOM/ Bag</th>
                                                                <th style="width:6%">No. of Bag</th>
                                                                <th style="width:6%">Bag Weight by KG</th>
                                                                <th style="width:6%">Total KG</th>
                                                                <th style="width:6%">Net KG</th>
                                                                <th style="width:6%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                <th style="width:6%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                <th style="width:6%">Variance Shortage by KG</th>
                                                                <th style="width:6%">Variance Overage by KG</th>
                                                                <th style="width:6%">Remark</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table table-sm"></tbody>
                                                        <tfoot>
                                                            <th colspan="8" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                            <th style="font-size: 14px;" id="totalbag"></th>
                                                            <th style="font-size: 14px;" id="totalbagweight"></th>
                                                            <th style="font-size: 14px;" id="totalgrosskg"></th>
                                                            <th style="font-size: 14px;" id="totalkg"></th>
                                                            <th style="font-size: 14px;" id="totalferesula"></th>
                                                            <th style="font-size: 14px;" id="totalton"></th>
                                                            <th style="font-size: 14px;" id="totalvarshortage"></th>
                                                            <th style="font-size: 14px;" id="totalvarovrage"></th>
                                                            <th></th>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="row"></div>
                        </div>
                    </div>
                    </form>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="">
                        <input type="hidden" class="form-control" name="selectedids" id="selectedids" readonly="true">
                        <input type="hidden" class="form-control" name="recieverecordIds" id="recieverecordIds" readonly="true">
                        <input type="hidden" class="form-control" name="statusIds" id="statusIds" readonly="true">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-12">

                                        <button type="button" id="recievingprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                </div>
                                <div class="col-xl-6 col-lg-12" style="text-align: right;">
                                    <button id="closebuttone" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            
        </div>
    </div>

    <div class="modal modal-slide-in event-sidebar fade" id="purchaseinvoiceinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Purchase Invoice Information</h5>
                        <div style="text-align: right;" id="pivinfoStatus">

                        </div>
                    </div>
                    
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card collapse-icon">
                                            <div class="collapse-default" id="accordionExample">
                                                <div class="card">
                                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#pivcollapseOne" aria-expanded="true" aria-controls="pivcollapseOne">
                                                        <span class="lead collapse-title">Payment Invoice Details</span>
                                                        <span id="" style="font-size:16px;"></span>
                                                    </div>
                                                    <div id="pivcollapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Purchase Invoice Information</h6>
                                                                        </div>
                                                                        <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                            <table class="table-responsive">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Purchase Invoice#: </label></td>
                                                                                    <td><b><label id="pivdocno" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                                    <td><b><label id="pivinforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr class="infopetrpo">
                                                                                    <td><label strong style="font-size: 12px;">Purchase Order#: </label></td>
                                                                                    <td><b><label id="pivinfopo" class="pivinfopo" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                                    <td><b><label id="pivinfocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                                    <td><b><label id="pivinfocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                                    <td><b><label id="pivinfocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                                    <td><b><label id="pivinfodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Payment Type: </label></td>
                                                                                    <td><b><label id="pivinfopaymentype" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Reciept Type: </label></td>
                                                                                    <td><b><label id="pivinforecieptype" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr id="payrinfomrcnotr">
                                                                                    <td><label strong style="font-size: 12px;">MRC NO: </label></td>
                                                                                    <td><b><label id="pivinfomrcno" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Invoice/Ref#: </label></td>
                                                                                    <td><b><label id="pivinfoinvoice" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-3 col-lg-12" id="directsupplyinformationdiv" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;display:visible;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Supplier Information</h6>
                                                                        </div>
                                                                        <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                            
                                                                            <table style="width: 100%">
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">ID: </label></td>
                                                                                    <td><b><label id="pivinfosuppid" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">Name: </label></td>
                                                                                    <td><b><label id="pivinfsupname" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td><label strong style="font-size: 12px;">TIN: </label></td>
                                                                                    <td><b><label id="pivinfosupptin" strong style="font-size: 12px;"></label></b></td>
                                                                                </tr>
                                                                                
                                                                            </table>
                                                                                <div class="divider divider-secondary">
                                                                                    <div class="divider-text"><b>Memo</b></div>
                                                                                </div>
                                                                                <table class="table-responsive">
                                                                                    
                                                                                    <tr>
                                                                                        <td><label id="paymentrequestinfomemo" class="paymentrequestinfopurpose" strong style="font-size: 12px;"></label></td>
                                                                                    </tr>
                                                                                    
                                                                                </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Attached Document</h6>
                                                                        </div>
                                                                        <div class="card-body scroll scrdiv" style="height:18rem;">
                                                                            <iframe src="" id="purchaseinvoicepdfviewer" width="100%" height="400px"></iframe>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-2 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                                    <h5>Actions</h5>
                                                                    <div class="scroll scrdiv">
                                                                        <ul class="timeline" id="paymentinvoiceulist" style="height:18rem;">
                                                                                
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                        <div class="divider divider-secondary" id="dividerinfo">
                                            <div class="divider-text directdivider">Commodity</div>
                                        </div>
                                </div>
                                    
                            </div>
                            <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="pivtable" class="display table-bordered table-striped table-hover dt-responsive mb-1">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>GRN</th>
                                                        <th>Commodity</th>
                                                        <th>Crop Year</th>
                                                        <th>Preparation</th>
                                                        <th>Grade</th>
                                                        <th>UOM/Bag</th>
                                                        <th>No. of Bag</th>
                                                        <th>NET KG</th>
                                                        <th>TON</th>
                                                        <th>Feresula</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"></td>
                                                        <th colspan="2" style="text-align: right;">Total</th>
                                                        <th id="pinfonofbagtotal"></th>
                                                        <th id="pinfokgtotal"></th>
                                                        <th id="pinfotontotal"></th>
                                                        <th id="pinfopriceferesula"></th>
                                                        <th id="pinfopricetotal"></th>
                                                        <th id="pinfototalpricetotal"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xl-9 col-lg-12">
                                                
                                                <div class="row">
                                                    <div class="col-xl-8 col-lg-12">
                                                        
                                                </div>

                                                <div class="col-xl-4 col-lg-12 mt-1">
                                                    <label id="grvhistory">GRv</label>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-12 mt-1">
                                                <table style="width:100%;" id="pivinfodirectinfopricetable" class="rtable">
                                                    <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="pivinfodirectinfosubtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                        
                                                    </tr>
                                                    <tr id="pivinfosupplierinfotaxtr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                        <td style="text-align: center;"><label id="pivinfodirectinfotaxLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                    
                                                    </tr>
                                                    <tr id="pivinfosupplierinforandtotaltr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                                        <td style="text-align: center;"><label id="pivinfodirectinfograndtotalLbl" strong style="font-size: 16px; font-weight: bold;" ></label></td>
                                                        
                                                    </tr>
                                                    <tr id="pivinfovisibleinfowitholdingTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="pivinfodirectinfowitholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr id="pivinfodirectinfonetpayTr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="pivinfodirectinfonetpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                                        <td style="text-align: center;"><label id="pivinfodirectinfonumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                        
                                                    </tr>
                                                    
                                                </table>
                                            </div>
                                            
                                        </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                            
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- add srart of history modal--> 
        <div class="modal modal-slide-in event-sidebar fade" id="purchaseinvloicehistorymodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 80%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="paymentinvoicehistorystatus"> </h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="historpurchaseinvoicetables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>GRV#</th>
                                                    <th>PIV#</th>
                                                    <th>Invoice Date</th>
                                                    <th>Voucher Type </th>
                                                    <th>Payment Type</th>
                                                    <th>MRC</th>
                                                    <th>Doc/FS#</th>
                                                    <th>Invoice/Ref#</th>
                                                    <th>Status</th>
                                                    
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
                        <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- start info modal --}}
    <div class="modal modal-slide-in event-sidebar fade" id="purchaseevaulationinfomodal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable sidebar-xl" role="document" style="width: 90%;">
            <div class="modal-content p-0">
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Evaluation Information</h5>
                <div class="row">
                    <div style="text-align: right;" id="pevulationinfoStatus"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body flex-grow-1 pb-sm-0 pb-3 scroll scrdiv">
                <form id="holdInfo">
                @csrf
                <div class="col-xl-12" id="docinfo-block">
                    <div class="card collapse-icon">
                            <div class="collapse-default" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#pevualationcollapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span class="lead collapse-title">Purchase Evaluation Details</span>
                                        <span id="" style="font-size:16px;"></span>
                                    </div>
                                    <div id="pevualationcollapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-3 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Puchase Evaluation Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">DOC#: </label></td>
                                                                    <td><b><label id="pevualationinfope" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                    <td><b><label id="pevualationinforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr id="trinforfq">
                                                                    <td><label strong style="font-size: 12px;">Reference#: </label></td>
                                                                    <td><b><label id="pevualationinforfq" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Product Type: </label></td>
                                                                    <td><b><label id="pevualationinfotype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                    <td><b><label id="pevualationinfocommoditype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                    <td><b><label id="pevualationinfocommoditysource" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Commodity Status: </label></td>
                                                                    <td><b><label id="pevualationinfocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Request Date: </label></td>
                                                                    <td><b><label id="pevualationinfodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Request Station: </label></td>
                                                                    <td><b><label id="pevualationinfostation" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Priority: </label></td>
                                                                    <td><b><label id="pevualationinfopriority" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Sample: </label></td>
                                                                    <td><b><label id="pevualationinfosample" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Memo: </label></td>
                                                                    <td><b><label id="pevualationinfomemo" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-5 col-lg-12" id="requesteditemdiv">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title" id="requesteditemlabel"></h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="scroll scrdiv" style="overflow-y:scroll;height:25rem;">
                                                                <table id="requesteditemdatatablesoninfo" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th class="reqtabl1">col1</th>
                                                                            <th class="reqtabl2">col2</th>
                                                                            <th class="reqtabl3">col3</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Action</h6>
                                                        </div>
                                                        <div class="card-body scroll scrdiv">
                                                            <ul class="timeline" id="pevualationulist" style="height:25rem;">
                                                            
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
                <div class="divider-text">Commodity Details</div>
            </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="table-responsive">
                        <div id="itemsdatablediv" class="scroll scrdiv">
                            <table id="itemsdocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                            <thead>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>SKU#</th>
                                <th>Description</th>
                                <th>sample Amount(QTY)</th>
                                <th>Remark</th>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                
                            </tfoot>
                            </table>
                        </div>
                        <div id="commuditylistdatablediv" class="scroll scrdiv">
                            <div class="row">
                                    <div class="col-xl-2 col-md-2 col-sm-2" id="supllierlistdiv">
                                        <div class="row">
                                                <div class="col-xl-12 col-md-12 col-sm-12">
                                                    <table style="width: 100%;">
                                                        <tr>
                                                            <td style="width:80%;">
                                                                <input type="text" class="form-control" id="searchsupplier" placeholder="Search here...">
                                                            </td>
                                                            <td style="width: 20%;">
                                                                <button type="button" class="btn btn-outline-dark" id="clearsupplsearch"><i class="fa-duotone fa-circle-xmark"></i></button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                        </div>
                                        <div class="scroll scrdiv">
                                            <section id="carddatacanvas" style="margin-top:2rem;height:10rem">
                                            </section>
                                        </div>  
                                    </div> 
                                    <div class="col-xl-10 col-md-10 col-sm-10" id="commoditylistdiv">
                                            <div id="initiationcomuditydocInfoItemdiv">
                                                    <table id="initiationcomuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                        <thead>
                                                            <th>#</th>
                                                            <th>Requested Commodity</th>
                                                            <th>Crop Year</th>
                                                            <th>Proccess Type</th>
                                                        </thead>
                                                        <tbody></tbody>
                                                            <tfoot>
                                                            </tfoot>
                                                    </table>
                                            </div>
                                            <div id="comuditydocInfoItemdiv">
                                                    <ul class="nav nav-tabs nav-justified" id="infoapptabs" role="tablist">
                                                        @can('PE-View')
                                                            <li class="nav-item" id="initation">
                                                                <a class="nav-link" id="initationview-tab" data-toggle="tab" href="#initationview" aria-controls="initationview" role="tab" aria-selected="true" onclick="infopelistbytab('peview');"><i data-feather="home"></i>Evaluation Initation</a>
                                                            </li>
                                                        @endcan
                                                        @can('TE-View')
                                                            <li class="nav-item" id="tectnicaltab">
                                                                <a class="nav-link" id="technicalview-tab" data-toggle="tab" href="#technicalview" aria-controls="technicalview" role="tab" aria-selected="false" onclick="infopelistbytab('teview');"><i data-feather="tool"></i>Technical Evaluation</a>
                                                            </li>
                                                        @endcan
                                                        @can('FE-View')
                                                            <li class="nav-item" id="financialtab">
                                                                <a class="nav-link active" id="financialview-tab" data-toggle="tab" href="#financialview" aria-controls="financialview" role="tab" aria-selected="false" onclick="infopelistbytab('feview');"><i data-feather="codepen"></i>Financial Evaluation</a>
                                                            </li>
                                                        @endcan
                                                        
                                                    </ul>
                                                    <div class="tab-content">
                                                            <div class="tab-pane" id="initationview" aria-labelledby="initationview-tab" role="tabpanel">
                                                                <table id="comuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                    <thead>
                                                                        <th>#</th>
                                                                        <th>Customer</th>
                                                                        <th>Requested Commodity</th>
                                                                        <th>Supply Commodity</th>
                                                                        <th>Crop Year</th>
                                                                        <th>Proccess Type</th>
                                                                        <th>Sample(KG)</th>
                                                                        <th>Remark</th>
                                                                    </thead>
                                                                    <tbody></tbody>
                                                                        <tfoot>
                                                                        </tfoot>
                                                                </table>
                                                        </div>
                                                        <div class="tab-pane" id="technicalview" aria-labelledby="technicalview-tab" role="tabpanel">
                                                            <table id="technicalcomuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                    <thead>
                                                                        <th>#</th>
                                                                        <th>Customer</th>
                                                                        <th>Requested Commodity</th>
                                                                        <th>Supply Commodity</th>
                                                                        <th>Crop Year</th>
                                                                        <th>Proccess Type</th>
                                                                        <th>Sample(KG)</th>
                                                                        <th>Grade</th>
                                                                        <th>Sieve Size</th>
                                                                        <th>Moisture</th>
                                                                        <th>Cup Value</th>
                                                                        <th>Row Value</th>
                                                                        <th>Score</th>
                                                                        <th>Status</th>
                                                                        <th>Remark</th>
                                                                    </thead>
                                                                    <tbody class="table table-sm"></tbody>
                                                                        <tfoot>
                                                                        </tfoot>
                                                                </table>
                                                        </div>
                                                        <div class="tab-pane active" id="financialview" aria-labelledby="financialview-tab" role="tabpanel">
                                                                    <table id="financailcomuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                                        <thead>
                                                                            <th>#</th>
                                                                            <th>Customer</th>
                                                                            <th>Requested Commodity</th>
                                                                            <th>Supply Commodity</th>
                                                                            <th>Crop Year</th>
                                                                            <th>Proccess Type</th>
                                                                            <th>Grade</th>
                                                                            <th>Feresula</th>
                                                                            <th>Supplier Price</th>
                                                                            <th>Proposed Price</th>
                                                                            <th>Agreed Price</th>
                                                                            <th>Rank</th>
                                                                            <th>Remark</th>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                            <tfoot>
                                                                            </tfoot>
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
            </form>   
            </div>
            <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                        <input type="hidden" placeholder="" class="form-control" name="recordIds" id="recordIds" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="evelautestatus" id="evelautestatus" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="evalsupplierid" id="evalsupplierid" readonly="true"/>
                                        <input type="hidden" placeholder="" class="form-control" name="evalstatus" id="evalstatus" readonly="true"/>
                                        
                                    <div class="col-xl-6 col-lg-12">
                                            <button style="display: none;" type="button" id="prprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                    </div>        
                                    <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                                    </div> 
                                </div>
                    </div>
            </div>
        </div>
        </div>
    </div> 

        <!--/ end of history modal modal-->
        <div id="myPopoverContent" style="display:none">
                <div class='row'>
                    <div class='col-xl-6 col-lg-12' id="popoveretailpricediv"><b><u>RT Price BV</u></b><div id="popoveretailprice"></div></div>
                    <div class='col-xl-6 col-lg-12' id="popoveretailpriceavdiv"><b><u>RT Price AV</u></b><div id="popoveretailpriceav"></div></div>
                    <div class='col-xl-6 col-lg-12' id="popoverwholesalepricediv"><b><u>WS Price BV</u></b><div id="popoverwholesaleprice"></div></div>
                    <div class='col-xl-6 col-lg-12' id="popoverwholesalepriceavdiv"><b><u>WS Price Av</u></b><div id="popoverwholesalepriceav"></div></div>
                </div>
                <div class="row">
                    <div class='col-xl-6 col-lg-12' id='popovereminqtydiv'><b><u>Min Qty</u></b><div id="popovereminqty"></div></div>
                    <div class='col-xl-6 col-lg-12' id='popoveremaxqtydiv'><b><u>Max Qty</u></b><div id="popoveremaxqty"></div></div>
                </div>
        </div>
@endsection

@section('scripts')
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.3.2/js/dataTables.rowGroup.min.js"></script>
<script type="text/javascript">
var table='';
$('#printtable').click(function(){
        var tr='<tr>'+
                '<td colspan="6" class="headerTitles" style="text-align:center;font-size:1.7rem;"><b>{{ $companyname }}</b></td>'+
                '<td rowspan="4" style="float:right;width:150px;height:120px;"></td>'+
                '</tr>'+
                '<tr><td style="width:10%"><b>Tel:</b></td>'+
                '<td style="width:50%" colspan="2">{{$companyphone}},{{$companyoffphone}}</td>'+
                '<td style="width:10%"><b>Website:</b></td>'+
                '<td style="width:30%" colspan="2">{{$companywebsite}}</td>'+
                '</tr>'+
                '<tr><td><b>Email:</b></td>'+
                '<td colspan="2">{{$companyemail}}</td>'+
                '<td><b>Address:</b></td>'+
                '<td colspan="2">{{$companyaddress}}</td>'+
                '</tr>'+
                '<tr><td><b>TIN No.:</b></td>'+
                '<td colspan="2">{{$companytin}}</td>'+
                '<td><b>VAT No:</b></td>'+
                '<td colspan="2">{{$companyvat}}</td>'+
                '</tr>';
                $("#headertables").append(tr);
                $('#compinfotr').show();

        let tbl = document.getElementById('salesReportByCustomer');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        let header = tbl.getElementsByTagName('thead')[0];
        header.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
    
        var divToPrint=document.getElementById("salesReportByCustomer");
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
                
        $("#headertables").empty();
        $('#compinfotr').hide();

});

    $("#downloatoexcel").click(function(){
        $("#headertables").empty();
        var datefrom=$('#datefrom').val();
        var dateto=$('#dateto').val();
        let tbl = document.getElementById('salesReportByCustomer');
        let footer = tbl.getElementsByTagName('tfoot')[0];
        footer.style.display = 'table-row-group';
        tbl.removeChild(footer);
        tbl.appendChild(footer);
        $("#salesReportByCustomer").table2excel({
        name: "Worksheet Name",
        filename: "paymnetrequestreport"+datefrom+' to '+dateto, //do not include extension
        fileext: ".xls" // file extension
        });
});
    $('#customCheck1').click(function(){

            if ($('#customCheck1').is(':checked')) {
                makeitselectall();
                $('.chboxlbl').html('<b>Deselect All Filters</b>');
            } else{
                $('.chboxlbl').html('<b>Select All Filters</b>');
                undomakeitselectall();
            }
        
        });
        
        function makeitselectall() {
                $('#supplier').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                $('#po').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                $('#preparation').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                $('#cropyear').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                $('#preparation').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                $('#grade').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                $('#status').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
        }

        function undomakeitselectall() {
                $('#supplier').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                $('#po').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                $('#preparation').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                $('#cropyear').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                $('#preparation').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                $('#grade').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                $('#status').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
        }
        $(document).on('change', '.form-control', function() {
        // Get the closest error element to the selectpicker field
            const errorElement = $(this).closest('.errorclear').find('.text-danger strong');
            errorElement.text('');
        });
    
    $('.suplier').on('changed.bs.select', function () {

        var selectedValues = $(this).val();
        referencefilters(selectedValues);

        const totalOptions = $('#supplier option').length;
        const selectedOptions = $('#supplier option:selected').length;
        $('#reference').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
        $('#po').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
        $('#paymentreference').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
        
        checkupforselections(totalOptions,selectedOptions);
    });

    $('.po').on('changed.bs.select', function () {
        
        var selectedValues = $(this).val();
        commodityfilter(selectedValues);
        const totalOptions = $('#po option').length;
        const selectedOptions = $('#po option:selected').length;
        checkupforselections(totalOptions,selectedOptions);
    });
    $('.pref').on('changed.bs.select', function () {
    
        const totalOptions = $('#paymentreference option').length;
        const selectedOptions = $('#paymentreference option:selected').length;
        checkupforselections(totalOptions,selectedOptions);
    });

    $('.stat').on('changed.bs.select', function () {
        const totalOptions = $('#status option').length;
        const selectedOptions = $('#status option:selected').length;
        checkupforselections(totalOptions,selectedOptions);
    });

    function checkupforselections(totalOptions,selectedOptions) {
            if (areAllOptionsSelected()) {
                    $('.chboxlbl').html('<b>Deselect All Filters</b>');
                    $('#customCheck1').prop('checked', true);
            } else{
                    $('.chboxlbl').html('<b>Select All Filters</b>');
                    $('#customCheck1').prop('checked', false);
            }
    }

    function areAllOptionsSelected() {
            let suppliertotalOptions = $('#supplier option').length; // Total options
            let supplierselectedOptions = $('#supplier').val()?.length || 0; // Selected options

            let referencetotalOptions = $('#reference option').length; // Total options
            let referenceselectedOptions = $('#reference').val()?.length || 0; // Selected options

            let pototalOptions = $('#po option').length; // Total options
            let poselectedOptions = $('#po').val()?.length || 0; // Selected options

            let paymentreferencetotalOptions = $('#paymentreference option').length; // Total options
            let paymentreferenceselectedOptions = $('#paymentreference').val()?.length || 0; // Selected options

            let statustotalOptions = $('#status option').length; // Total options
            let statusselectedOptions = $('#status').val()?.length || 0; // Selected options

            return (suppliertotalOptions === supplierselectedOptions && pototalOptions === poselectedOptions &&  paymentreferencetotalOptions === paymentreferenceselectedOptions && statustotalOptions === statusselectedOptions) // Returns true if all options are selected
    }
function referencefilters(selectedvalues) {
    var from=$('#datefrom').val();
    var to=$('#dateto').val();
    $.ajax({
        type: "POST",
        url: "{{ url('purchaseordergetporeference') }}",
        data: {
                options: selectedvalues,
                from:from,
                to:to,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
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
        success: function (response) {
            var option='';
            $.each(response.purchaseorder, function (index, value) { 
                option+= "<option value='"+value.id+"'>"+value.documentumber+"</option>";
            });

            var directoption='<option value="1">Direct</option>';
            $('#po').empty();
            $("#po").append(directoption);
            $("#po").append(option);
            $('#po').selectpicker('refresh');

            if($('#customCheck1').is(':checked')) {
                    $('#po').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                } else{
                    $('#po').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                }
        }
    });
}
function commodityfilter(selectedValues) {
        var option='';
        var valuesToDisable =[];
         $('#paymentreference').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
        $.ajax({
            type: "POST",
            url: "{{ url('purchaseordergetcommodtyperpo') }}",
            data: {
                options: selectedValues,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
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
            success: function (response) {

                        var option='';
                        $.each(response.data, function (index, value) { 
                            option+= "<option value='"+value.supplyworeda+"'>"+value.origin+"</option>";
                        });
                        $('#commodity').empty();
                        $("#commodity").append(option);
                        $('#commodity').selectpicker('refresh');
                        if ($('#customCheck1').is(':checked')) {
                            $('#commodity').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                        } else{
                            $('#commodity').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                        }
                        
            }
        });
}
function checkforpofilters(selectedValues,customer,from,to) {
    var option='';
    $.ajax({
        type: "POST",
        url: "{{ url('pofilteringstatus') }}",
        data: {
                options: selectedValues,
                options2: customer,
                from: from,
                to: to,
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
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
        success: function (response) {
            $.each(response.purchaseorder, function (index, value) { 
                option+= "<option value='"+value.id+"'>"+value.porderno+"</option>";
            });
            $('#po').empty();
            $("#po").append(option);
            $('#po').selectpicker('refresh');

                if ($('#customCheck1').is(':checked')) {
                    $('#po').selectpicker('selectAll').selectpicker('refresh'); //Refresh UI
                } else{
                    $('#po').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                }


        }
    });
}
function setdefaultvaluesforeachelement() {

        $('#commodity').selectpicker('val', [])
        $('#commodity').selectpicker('refresh');

        $('#paymentreference').selectpicker('val', [])
        $('#paymentreference').selectpicker('refresh');

        $('#cropyear').selectpicker('val', [])
        $('#cropyear').selectpicker('refresh');

        $('#paymentreference').selectpicker('val', [])
        $('#paymentreference').selectpicker('refresh');

        $('#preparation').selectpicker('val', [])
        $('#preparation').selectpicker('refresh');

        $('#grade').selectpicker('val', [])
        $('#grade').selectpicker('refresh');

        $('#po option[value="1"]').prop('selected', true); 
        $('#po').attr('disabled', true)
        $('#po').selectpicker('refresh');

        $('#commodity option[value="3"]').prop('selected', true); 
        $('#commodity').attr('disabled', true)
        $('#commodity').selectpicker('refresh');

        $('#paymentreference option[value="Direct"]').prop('selected', true); 
        $('#paymentreference').attr('disabled', true);
        $('#paymentreference').selectpicker('refresh');
        
        $('#preparation option[value="--"]').prop('selected', true); 
        $('#preparation').attr('disabled', true);
        $('#preparation').selectpicker('refresh');

        $('#cropyear option[value="--"]').prop('selected', true); 
        $('#cropyear').attr('disabled', true);
        $('#cropyear').selectpicker('refresh');

        $('#grade option[value="--"]').prop('selected', true); 
        $('#grade').attr('disabled', true);
        $('#grade').selectpicker('refresh');
}

function undosetdefaultvaluesforeachelement() {

    $('#po option[value="1"]').prop('selected', false); 
    $('#po').attr('disabled', false)
    $('#po').selectpicker('refresh');

    $('#commodity option[value="3"]').prop('selected', false); 
    $('#commodity').attr('disabled', false)
    $('#commodity').selectpicker('refresh');

    $('#paymentreference option[value="Direct"]').prop('selected', false); 
    $('#paymentreference').attr('disabled', false)
    $('#paymentreference').selectpicker('refresh');

    $('#preparation option[value="--"]').prop('selected', false); 
    $('#preparation').attr('disabled', false)
    $('#preparation').selectpicker('refresh');

    $('#cropyear option[value="--"]').prop('selected', false); 
    $('#cropyear').attr('disabled', false)
    $('#cropyear').selectpicker('refresh');

    $('#grade option[value="--"]').prop('selected', false); 
    $('#grade').attr('disabled', false)
    $('#grade').selectpicker('refresh');
}

function formatOption(option) {
        if (!option.id) return option.text; // Return option text if no ID

        return $(
            '<div class="custom-option"> <input type="checkbox" class="checkbox-option" /> ${option.text}  </div>'
        );
    }

    function formatSelected(selected) {
        return selected.text; // Show selected option text
    }

    var $fr='';
    var $tr='';
            

            $(function() {
                // Initialize date range picker with options
            let drp = $('#reportrange').daterangepicker({

                autoUpdateInput: false, // Prevent initial date display
                locale: {
                    format: 'MMMM D, YYYY', // Clearer date format (e.g., "January 1, 2024")
                    cancelLabel: 'Clear'
                },
                ranges: { // Predefined date ranges
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 6 months': [moment().subtract(179, 'days'), moment()],
                    'Last 9 months': [moment().subtract(270, 'days'), moment()],
                    'This Year': [moment().startOf('year'), moment().endOf('year')]
                }
            });

    // Set initial state: empty display and placeholder
    const reportRangeSpan = $('#reportrange span'); // Cache the span element
    reportRangeSpan.text(""); // Clear any initial text
    
    $('#reportrange').attr("placeholder", "Select Date Range");

    // Event handler for when a date range is APPLIED
    drp.on('apply.daterangepicker', function(ev, picker) {
        const startDate = picker.startDate;
        const endDate = picker.endDate;

        $('#range-error').html('');
        $('#customCheck1').prop('disabled', false);
        reportRangeSpan.text(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));

        const fromDate = startDate.format('YYYY-MM-DD');
        const toDate = endDate.format('YYYY-MM-DD');

        $("#datefrom").val(fromDate);
        $("#dateto").val(toDate);
        filtersuppliterwithranges(fromDate, toDate);
    });

    // Event handler for when the CLEAR button is clicked
    drp.on('cancel.daterangepicker', function(ev, picker) {
        // Clear display, hidden inputs, and restore placeholder
        reportRangeSpan.text("");
        $("#datefrom").val("");
        $("#dateto").val("");
        $('#reportrange').attr("placeholder", "Select Date Range");

        //Log for debugging (optional)
    });
});

        $(function () {
                    pageSection = $('#page-block');
                });
                function filtersuppliterwithranges(from,to) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('purchaseorderfiltersupplier') }}/"+from+"/"+to,
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
                                var option='';
                            $.each(response.supplier, function (index, value) { 
                                option+= "<option value='"+value.customer_id+"'>"+value.customer_name+ ","+ value.customer_code+ ","+ value.tin_number+ "</option>";
                            });
                            $('#supplier').empty();
                            $("#supplier").append(option);
                            $('#supplier').selectpicker('refresh');
                            $('#po').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                            $('#paymentreference').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                            $('#status').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                            $('#preparation').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                            $('#cropyear').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                            $('#grade').selectpicker('deselectAll').selectpicker('refresh'); //Refresh UI
                        
                        }
                    });
                }
            
            $(document).ready(function() {
        
        $('#responsive-datatable').show();
        $('#fiscalYear').val($('#fiscalYear option:first').val()).selectpicker('refresh'); //
        $('#responsive-datatable').hide();
        $('#exportdiv').hide();
        $('#customCheck1').prop('disabled', true);
});

$('#paymentrequesreportbutton').click(function(){
    var fiscalYear=$('#fiscalYear').val();
    var from=$('#datefrom').val();
    var to=$('#dateto').val();
    var supplier=$('#supplier').val();
    var purchaseorder=$('#po').val();
    var commodity=$('#commodity').val();
    var preparation=$('#preparation').val();
    var cropyear=$('#cropyear').val();
    var grade=$('#grade').val();
    var status=$('#status').val();

            table = $("#salesReportByCustomer").DataTable({
                    processing:true,
                    serverSide: true,
                    responsive:true,
                    destroy:true,
                    paging:false,
                    searchHighlight: true,
                    info:true,
                    "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'lf><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'i><'col-sm-12 col-md-5'><'col-sm-12 col-md-3'p>>",
                    language: {
                            search: '',
                            searchPlaceholder: "Search here"
                        },
                        ajax: {
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: "POST",
                                url: "{{ url('purchaseordereportdispaly') }}",
                                        data: function (d) {
                                            Object.assign(d, {
                                                fiscalYear,
                                                from,
                                                to,
                                                supplier,
                                                purchaseorder,
                                                commodity,
                                                preparation,
                                                cropyear,
                                                grade,
                                                status
                                
                                            });
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
                                        error: function (xhr) {
                                            if (xhr.status === 422) {
                                                let errors = xhr.responseJSON.errors;
                                                    $('#responsive-datatable').hide();
                                                    $('#exportdiv').hide();
                                                    if(errors.from){
                                                        $('#range-error').html('Date Range is Required');
                                                    }
                                                    if(errors.supplier){
                                                            $('#supplier-error').html(errors.supplier[0]);
                                                    }
                                                    if(errors.fiscalYear){
                                                            $('#fiscalYear-error').html(errors.fiscalYear[0]);
                                                    }
                                                    if(errors.purchaseorder){
                                                            $('#po-error').html(errors.purchaseorder[0]);
                                                    }
                                                    if(errors.paymentreference){
                                                            $('#paymentreference-error').html(errors.paymentreference[0]);
                                                    }
                                                    if(errors.commodity){
                                                            $('#commodity-error').html(errors.commodity[0]);
                                                    }
                                                    if(errors.preparation){
                                                            $('#preparation-error').html(errors.preparation[0]);
                                                    }
                                                    if(errors.cropyear){
                                                            $('#cropyear-error').html(errors.cropyear[0]);
                                                    }
                                                    if(errors.grade){
                                                            $('#grade-error').html(errors.grade[0]);
                                                    }
                                                    if(errors.status){
                                                            $('#status-error').html(errors.status[0]);
                                                    }
                                                    if(errors.reference){
                                                            $('#reference-error').html(errors.reference[0]);
                                                    }
                                                    else{
                                                        
                                                    }
                                            } else {
                                                toastrMessage('error','An error occurred'+ xhr.responseText,'Error!');
                                            }
                                        },
                            },
                            columns: [
                                    { data:'DT_RowIndex'},
                                    {data: "SupplierName", className: 'SupplierName','visible':false},
                                    {data: "PE", className: 'PE',"sortable": false,searchable:false,visible:false},
                                    {data: "DocumentNo", className: 'DocumentNo',"sortable": false,'visible':false},
                                    {data: "Commodity", className: 'Commodity',"sortable": false,searchable:false},
                                    {data: "grade", className: 'grade',"sortable": false,searchable:false},
                                    {data: "cropyear", className: 'cropyear',"sortable": false,searchable:false},
                                    {data: "proccesstype", className: 'proccesstype',"sortable": false,searchable:false},
                                    {data: "UOM", className: 'UOM',"sortable": false,"searchable":false,searchable:false},
                                    {data: "NoOfBag", className: 'NoOfBag',"sortable": false,searchable:false},
                                    {data: "bagweight", className: 'bagweight',"sortable": false,searchable:false},
                                    {data: "netkg", className: 'netkg',"sortable": false,searchable:false},
                                    {data: "feresula", className: 'feresula',"sortable": false,searchable:false},
                                    {data: "price", className: 'price',"sortable": false,searchable:false},
                                    {data: "total", className: 'total',"sortable": false,searchable:false},
                                    {data: "peid", className: 'peid',"sortable": false,searchable:false,visible:false},
                                    {data: "istaxable", className: 'istaxable',"sortable": false,searchable:false,visible:false},
                                    {data: "poid", className: 'poid',"sortable": false,searchable:false,visible:false},
                                                                                                                                                                                                                                                                                
                            ],
                                columnDefs: [
                                        {
                                            targets: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14],
                                            createdCell: function (td, cellData, rowData, row, col){
                                            $(td).css('border', '0.1px solid black');
                                            $(td).css('color', 'black');
                                        }
                                    }
                                ],
                                fixedHeader: {
                                    header: true,
                                    headerOffset: $('.header-navbar').outerHeight(),
                                    footer: true
                                },
                                rowGroup: {
                                        dataSrc: ['SupplierName','PE','DocumentNo'],
                                            startRender: function ( rows, group,level) {
                                                var color = 'style="color:black;font-weight:bold;"';
                                                if(level===0){
                                                    return $('<tr ' + color + '/>')
                                                    .append('<th colspan="14" style="text-align:center;border:1px solid;background:#ccc; font-size:12px;"> Supplier: ' + group + '</th>')
                                                }
                                                else if(level==1){
                                                        var ga='';
                                                    switch (group) {
                                                        case '--':
                                                            ga='Direct';
                                                            break;
                                                        
                                                        default:
                                                            var poid=0;
                                                            
                                                                rows.data().each(row => {
                                                                    var po=JSON.stringify(row, null, 2);
                                                                    poid=row.peid;
                                                                })
                                                                
                                                            var polinks = "<a href='#' onclick=viewpeinformation("+poid+")><u>"+group+"</u></a>";
                                                            ga='PE#:-'+polinks;
                                                            break;
                                                    }
                                                    return $('<tr ' + color + '/>')
                                                    .append('<th colspan="14" style="text-align:left;border:0.1px solid;background:#f2f3f4;font-size:12px;">Refence: ' + ga + '</th>')
                                                }
                                                if(level===2){
                                                    return $('<tr ' + color + '/>')
                                                    .append('<th colspan="14" style="text-align:left;border:0.1px solid;background:#f2f3f4;font-size:12px;">' + group + '</th>')
                                                }
                                                
                                            },
                                            endRender: function ( rows, group, level ) {
                                                    var color = 'style="color:black;font-weight:bold;"';

                                                        var intVal = function ( i ) {
                                                            return typeof i === 'string' ?
                                                                i.replace(/[\$,]/g, '')*1 :
                                                                typeof i === 'number' ?
                                                                        i : 0;
                                                        };
                                                        
                                                        var groupSum = rows
                                                        .data()
                                                        .pluck('total')
                                                        .reduce(function (a, b) {
                                                            return intVal(a) + intVal(b);
                                                        }, 0);
                                                        
                                                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                                                    if(level===0){
                                                            let level1Sum = 0;
                                                        return $('<tr ' + color + '/>')
                                            .append('<th colspan="18" style="text-align:right;border: 1px solid black;background:#f2f3f4;font-size:12px;">Total Paid of '+group+': <b> '+numberendering(groupSum)+ ' </b></th>')
                                                    }
                                                    if(level===1){
                                                        var ga='';
                                                    switch (group) {
                                                        case '--':
                                                                ga='Direct';
                                                            break;
                                                        default:
                                                                var poid=0;
                                                                rows.data().each(row => {
                                                                    var po=JSON.stringify(row, null, 2);
                                                                    poid=row.peid;
                                                                })
                                                            var polinks = "<a href='#' onclick=viewpeinformation("+poid+")><u>"+group+"</u></a>";
                                                            ga='Purchase Evualation#:-'+polinks;
                                                            break;
                                                    }
                                                    
                                                        var level2Sum = 0;
                                                        
                                                        return $('<tr ' + color + '/>')
                                                        .append('<th colspan="18" style="text-align:right;border: 1px solid black;background:#f2f3f4;font-size:12px;">Total paid of ' + ga+': <b>' + numberendering(groupSum)+'</b></th>');
                                                    }
                                                    if(level===2){
                                                        const letter = "PO";
                                                            const words = group.match(new RegExp(`\\b${letter}\\w*/\\d+-\\d+\\b`, 'gi'));
                                                                var pyrid=0;
                                                                var istaxable=0;
                                                                rows.data().each(row => {
                                                                        var po=JSON.stringify(row, null, 2);
                                                                        pyrid=row.poid;
                                                                        istaxable=row.istaxable;
                                                                    });
                                                                    
                                                                var links = '<a href="#" onclick="viewpoinformation('+pyrid+');"><u>'+words+'</u></a>';
                                                                    
                                                                    var withold=0.00;
                                                                    var tax=0.00;
                                                            switch (istaxable) {
                                                                case 1:
                                                                    var aftertax=parseFloat(groupSum) * (1 + (15 / 100));
                                                                    var tax=parseFloat(aftertax)-parseFloat(groupSum);
                                                                    break;
                                                            
                                                                default:
                                                                    break;
                                                            }
                                                        
                                                            if(parseFloat(groupSum)>=10000){
                                                                withold=(parseFloat(groupSum)*2)/100;
                                                            }
                                                            var grandTotal=parseFloat(groupSum)+parseFloat(tax);
                                                            var netpay=parseFloat(grandTotal)-parseFloat(withold);

                                                                switch (istaxable) {
                                                                case 1:
                                                                        var tr='<td colspan="10" rowspan="6" style="text-align:right;border:0.1px solid;">Total of Purchase Order of:'+ links +'</td>';
                                                                        return $('<tr style="font-weight:bold;"> '+ tr+ '</tr>'+
                                                                        '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;"> Sub Total </td> <td style="text-align:left;border:0.1px solid;">'+numberendering(groupSum)+'</td> </tr>'+
                                                                        '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Tax</td><td style="text-align:left;border:0.1px solid;">'+numberendering(tax)+'</td></tr>'+
                                                                        '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Grand Total</td><td style="text-align:left;border:0.1px solid;">'+numberendering(grandTotal)+'</td></tr>'+
                                                                        '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Withold(2%)</td><td style="text-align:left;border:0.1px solid;">'+numberendering(withold)+'</td></tr>'+
                                                                        '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Net Pay</td><td style="text-align:left;border:0.1px solid;">'+numberendering(netpay)+'</td></tr>'
                                                                    );
                                                                    break;
                                                                    
                                                                default:
                                                                    var tr='<td colspan="10" rowspan="4" style="text-align:right;border:0.1px solid;"> Total of Purchase Order of: '+ links +'</td>';
                                                                        return $('<tr style="font-weight:bold;"> '+ tr+ '</tr>'+
                                                                            '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Grand Total</td><td style="text-align:left;border:0.1px solid;">'+numberendering(grandTotal)+'</td></tr>'+
                                                                            '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Withold(2%)</td><td style="text-align:left;border:0.1px solid;">'+numberendering(withold)+'</td></tr>'+
                                                                            '<tr style="font-weight:bold;"><td style="text-align:left;border:0.1px solid;">Net Pay</td><td style="text-align:left;border:0.1px solid;">'+numberendering(netpay)+'</td></tr>'
                                                                        );
                                                                    break;
                                                        }
                                                        
                                                        // return $('<tr ' + color + '/>')
                                                        // .append('<th colspan="18" style="text-align:right;border: 1px solid black;background:#f2f3f4;font-size:12px;">Paid Purchase Order#: ' +links+': <b>'+ numberendering(groupSum) +'</b></th>');
                                                    
                                                    }
                                                }
                        },
                        "footerCallback": function (row, data, start, end, display) {
                                var api = this.api();
                                    // Remove the formatting to get integer data for summation
                                    var intVal = function ( i ) {
                                        return typeof i === 'string' ?
                                            i.replace(/[\$,]/g, '')*1 :
                                            typeof i === 'number' ?
                                                i : 0;
                                    };
                                        
                                                total = api
                                                    .column( 13 )
                                                    .data()
                                                    .reduce( function (a, b) {
                                                        return intVal(a) + intVal(b);
                                                    }, 0 );

                                            var aftertax=parseFloat(total) * (1 + (15 / 100));
                                            if(parseFloat(total)>=10000){
                                                    withold=(parseFloat(total)*2)/100;
                                                }

                                            var tax=parseFloat(aftertax)-parseFloat(total);
                                            var grandTotal=parseFloat(total)+parseFloat(tax);
                                            var netpay=parseFloat(grandTotal)-parseFloat(withold);
                                                
                                    var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                                                    
                                $('#totalpaidamounts').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(total)+"</h6>");
                                $('#totaltax').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(tax)+"</h6>");
                                $('#totalgrand').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(grandTotal)+"</h6>");
                                $('#totalwithold').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(withold)+"</h6>");
                                $('#totalnetpay').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(netpay)+"</h6>");
                }
                
                });
            
                $('#responsive-datatable').show();
                $('#exportdiv').show();

});




$('#poprintbutton').click(function(){
    var id=$('#porecordIds').val();
    var link="/directpoattachemnt/"+id;
    window.open(link, 'Purchase Order', 'width=1200,height=800,scrollbars=yes');
});
$('#pyrprintbutton').click(function(){
            var id=$('#pyrrecordIds').val();
            var link="/paymentrequestattachemnt/"+id;
            window.open(link, 'Payment Request', 'width=1200,height=800,scrollbars=yes');
        });
$('#recievingprintbutton').click(function(){
    var id=$('#recieverecordIds').val();
    var link="/grvComm/"+id;
    window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
});
        
function viewpyrinformation(params) {
        payrinformations(params);
}

function viewpoinformation(params) {
        poinformations(params);
}
function viewpeinformation(params) {
        peinformations(params);
}

function peinformations(recordId) {
            var prstatus=0;
            var peid=0;
            var documentumber='';
            var status='';
            var petype='';
            $.ajax({
            type: "GET",
            url: "{{ url('peinfo') }}/"+recordId,
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
                        $("#pevualationcollapseOne").collapse('show');
                        $('#purchaseevaulationinfomodal').modal('show');
                    },
            success: function (response) {
                
                    $('#pevualationinfostation').html(response.storename);
                $.each(response.pr, function (indexInArray, valueOfElement) { 
                    peid=valueOfElement.id;
                    $('#recordIds').val(valueOfElement.id);
                    $('#evelautestatus').val(valueOfElement.status);
                    $('#pevualationinfope').html(valueOfElement.documentumber);
                    $('#pevualationinforefernce').html(valueOfElement.petype);
                    $('#pevualationinfotype').html(valueOfElement.type);
                    $('#pevualationinfodocumentdate').html(valueOfElement.date);
                    $('#pevualationinfocommoditype').html(valueOfElement.commudtytype);
                    $('#pevualationinfocommoditysource').html(valueOfElement.coffeesource);
                    $('#pevualationinfocommoditystatus').html(valueOfElement.coffestat);
                    $('#pevualationinfosample').html(valueOfElement.samplerequire);
                    $('#pevualationinfomemo').html(valueOfElement.memo);
                    switch (valueOfElement.priority) {
                        case '1':
                            $('#pevualationinfopriority').html('High');
                            break;
                        case '2':
                            $('#pevualationinfopriority').html('Medium');
                            break;
                        default:
                            $('#pevualationinfopriority').html('Low');
                            break;
                    }
                    prstatus=valueOfElement.status;
                    switch (valueOfElement.petype) {
                        case 'Direct':
                                $('#preditbutton').hide();
                                $('#trinforfq').hide();
                                setrequesteditemlabel(valueOfElement.id,valueOfElement.type,valueOfElement.petype);
                                switch (valueOfElement.type) {
                                    case 'Goods':
                                        $('#itemsdatablediv').show();
                                        $('#commuditylistdatablediv').hide();
                                        itemslist(valueOfElement.id);
                                        break;
                                    default:
                                        $('#itemsdatablediv').hide();
                                        $('#commuditylistdatablediv').show();
                                    break;
                                }
                            break;
                        default:
                            $('#trinforfq').show();
                            var tables='#requesteditemdatatablesoninfo';
                            getrequesteditem(tables,valueOfElement.id,valueOfElement.type,valueOfElement.petype);
                                switch (valueOfElement.type) {
                                    case 'Goods':
                                        $('#itemsdatablediv').show();
                                        $('#commuditylistdatablediv').hide();
                                        itemslist(valueOfElement.id);
                                        break;
                                    default:
                                        $('#itemsdatablediv').hide();
                                        $('#commuditylistdatablediv').show();
                                        break;
                                }
                            break;
                    }
                    showsupplier(valueOfElement.id);
                    documentumber=valueOfElement.documentumber;
                    status=valueOfElement.status;
                    petype=valueOfElement.petype;
                });
                $('#inforfq').html(response.rfq);
                if (response.supplier.length === 0) {
                    initationcommuditylist(peid);
                }
                else{
                    
                    setsupplierbytab(response.supplier,prstatus);
                    showdataonthestatus(prstatus);
                }
                pevulationsetminilog(response.actions);
                showbuttondependonstat('frominfo',documentumber,status,petype);
            }
        });
    }
function setrequesteditemlabel(peid, type,reference) {
        var tables='#requesteditemdatatablesoninfo';
        switch (reference) {
            case 'Direct':
                    switch (type) {
                    case 'Goods':
                        $('#requesteditemlabel').html('Requested item');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                    default:
                        $('#requesteditemlabel').html('Requested Commodity');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                }
                break;
            default:
                switch (type) {
                    case 'Goods':
                        $('#requesteditemlabel').html('Requested item');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                    default:
                        $('#requesteditemlabel').html('Requested Commodity');
                        getrequesteditem(tables,peid,type,reference);
                        break;
                }
                break;
        }
    }

    function getrequesteditem(tables,peid,type,reference) {
        switch (reference) {
            case 'Direct':
                    switch (type) {
                        case 'Goods':  
                                $('#requesteditemlabeladd').html('Requested Goods');
                            break;
                        
                        default:
                                $('#requesteditemlabeladd').html('Requested Commodity');
                                
                            break;
                    }
                    setableslabel(type,reference);
                break;
            default:
                    setableslabel(type,reference);
                break;
        }
        $(tables).DataTable({
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
            "dom": "<'row'<'col-lg-6 col-md-10 col-xs-4'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('requesteditems') }}/"+peid+"/"+reference+"/"+type,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'col1',name: 'col1',"width": "30%"},
                {data: 'col2',name: 'col2','width':'10%'},
                {data: 'col3',name: 'col3',"width": "10%"},
            ],
        });
    }
    function setableslabel(type,reference) {
            switch (reference) {
                case 'Direct':
                        switch (type) {
                            case 'Goods':
                                $('#requesteditemlabeladd').html('Requested Goods');
                                $('#evrequesteditemlabeladd').html('Requested Goods');
                                $('.reqtabl1').text('Code-Name');
                                $('.reqtabl2').text('SKU');
                                $('.reqtabl3').text('QTY');
                                
                                break;
                            default:
                                $('#requesteditemlabeladd').html('Requested Commodity');
                                $('#evrequesteditemlabeladd').html('Requested Commodity');
                                $('.reqtabl1').text('Commodity');
                                $('.reqtabl2').text('Crop year');
                                $('.reqtabl3').text('Process Type');
                                break;
                        }
                    break;
                default: 
                        switch (type) {
                            case 'Goods':
                                $('#requesteditemlabeladd').html('Requested Goods');
                                $('#evrequesteditemlabeladd').html('Requested Goods');
                                $('.reqtabl1').text('Code-Name');
                                $('.reqtabl2').text('SKU');
                                $('.reqtabl3').text('QTY');
                                break;
                        
                            default:
                                $('#requesteditemlabeladd').html('Requested Commodity');
                                $('#evrequesteditemlabeladd').html('Requested Commodity');
                                $('#requesteditemlabel').html('Requested Commodity');
                                $('.reqtabl1').text('Commodity');
                                $('.reqtabl2').text('Crop year');
                                $('.reqtabl3').text('Process Type');
                                break;
                        }
                    break;
            }
    }
    function showsupplier(params) {
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
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('showsupplierforpe') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'id',name: 'id','visible':false},
                {data: 'Code',name: 'Code'},
                {data: 'Name',name: 'Name'},
                {data: 'TinNumber',name: 'TinNumber'},
                {data: 'phone',name: 'phone'},
                {data: 'recievedate',name: 'recievedate'},
            ],
            
        });
    }
    function setsupplierbytab(supplier,prstatus) {
        var carddata='';
        var backcolor="";
        var forecolor="";
        var status='';
        var jj=0;
        var stitles='';
        var firstsupplierid=0;
        var sumbitdate='';
        var supplycode='';
        var sec=0;
        var statusing=$('#infoStatus').text();
        $.each(supplier, function (index, value) { 
            ++jj;
            switch (index) {
                case 0:
                    fetchorders(value.id,2);
                    firstsupplierid=value.id;
                    
                    break;
                
                default:
                    break;
            }
            
            stitles="Name:"+value.Name+" "+value.TinNumber;
            supplycode="Code:"+value.pecode;
            sumbitdate="Submit Date:"+value.recievedate;

            carddata+="<div id='commcard"+value.id+"' class='card supcard commcardcls"+value.id+"' data-title='"+stitles+"' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchorders("+value.id+","+sec+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span><b>"+supplycode+"</b></span><div id='targetspandiv"+value.id+"'><span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+status+"</b></span></div></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>@can('Supplier-View')"+stitles+"@endcan</b></div><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>@can('Supplier-View')"+sumbitdate+"@endcan</b></div></div></div></div>";
        });
        $('#carddatacanvas').empty();
        $('#carddatacanvas').html(carddata);
        $('.commcardcls'+firstsupplierid).addClass('supplierselected');
    }
    function fetchorders(id,isfirst) {
            var headerid=$('#recordIds').val();
            $('#evalsupplierid').val(id);
            $('.supcard').removeClass('supplierselected');
            $('.commcardcls'+id).addClass('supplierselected');
            console.log('isfirst=',isfirst);
            switch (isfirst) {
                case 1:
                    commuditylist(headerid,id);
                    break;
                default:
                
                    var activeTab = $("#infoapptabs .nav-item .active").attr("href");
                    console.log('activeTab=',activeTab);    
                    switch (activeTab) {
                        case '#initationview':
                                commuditylist(headerid,id);
                            break;
                        case '#technicalview':
                                commuditylistoftechnicalview(headerid,id);
                        break;
                        default:
                                commuditylistoffinancialview(headerid,id);
                            break;
                    }
                    break;
            }
    }
    function commuditylist(headerid,id) {

            $('#initiationcomuditydocInfoItemdiv').hide();
            $('#comuditydocInfoItemdiv').show();
            $("#supllierlistdiv").show();
            var status=$('#evelautestatus').val();
            //console.log('status=',status);
            switch (status) {
                case '0':
                    $("#commoditylistdiv").removeClass("col-xl-12 col-md-12 col-sm-12");
                    $("#commoditylistdiv").removeClass("col-xl-10 col-md-10 col-sm-10");
                    $("#commoditylistdiv").removeClass("col-xl-9 col-md-9 col-sm-9");
                    $("#commoditylistdiv").removeClass("col-xl-8 col-md-8 col-sm-8");

                    $("#supllierlistdiv").removeClass("col-xl-3 col-md-2 col-sm-2");
                    $("#supllierlistdiv").removeClass("col-xl-4 col-md-4 col-sm-4");

                    $("#commoditylistdiv").addClass("col-xl-8 col-md-8 col-sm-8");
                    $("#supllierlistdiv").addClass("col-xl-4 col-md-4 col-sm-4");
                    break;

                    case '1':
                    $("#commoditylistdiv").removeClass("col-xl-12 col-md-12 col-sm-12");
                    $("#commoditylistdiv").removeClass("col-xl-10 col-md-10 col-sm-10");
                    $("#commoditylistdiv").removeClass("col-xl-9 col-md-9 col-sm-9");
                    $("#commoditylistdiv").removeClass("col-xl-8 col-md-8 col-sm-8");

                    $("#supllierlistdiv").removeClass("col-xl-4 col-md-4 col-sm-4");
                    $("#supllierlistdiv").removeClass("col-xl-3 col-md-3 col-sm-3");

                    $("#commoditylistdiv").addClass("col-xl-8 col-md-8 col-sm-8");
                    $("#supllierlistdiv").addClass("col-xl-4 col-md-4 col-sm-4");
                    break;
            
                default:
                    $("#commoditylistdiv").removeClass("col-xl-12 col-md-12 col-sm-12");
                    $("#commoditylistdiv").removeClass("col-xl-10 col-md-10 col-sm-10");
                    $("#commoditylistdiv").removeClass("col-xl-9 col-md-9 col-sm-9");
                    $("#commoditylistdiv").removeClass("col-xl-8 col-md-8 col-sm-8");

                    $("#supllierlistdiv").removeClass("col-xl-3 col-md-3 col-sm-3");
                    $("#supllierlistdiv").removeClass("col-xl-4 col-md-4 col-sm-4");

                    $("#commoditylistdiv").addClass("col-xl-9 col-md-9 col-sm-9");
                    $("#supllierlistdiv").addClass("col-xl-3 col-md-3 col-sm-3");

                    break;
            }
            var title='---';
            var comudtable=$('#comuditydocInfoItem').DataTable({
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
                url: "{{ url('getpebysupplier') }}/"+headerid+'/'+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'requestedorigin',name: 'requestedorigin',width:'20%'},
                {data: 'supplyorigin',name: 'supplyorigin', width:'20%'},
                {data: 'cropyear',name: 'cropyear',width:'10%'},
                {data: 'proccesstype',name: 'proccesstype',width:'10%'},
                {data: 'sampleamount',name: 'sampleamount',width:'5%'},
                {data: 'remark',name: 'remark'},
                
            ],
            columnDefs: [   
                        {
                            targets: 6,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 0:
                                        return '';
                                        break;
                                    default:
                                        return data;
                                        break;
                                }
                            }
                        },

                        {
                            targets: 7,
                            render: function ( data, type, row, meta ) {
                                var remark = (data === undefined || data === null || data === '') ? 'EMPTY' : data;
                                switch (remark) {
                                    case 'EMPTY':
                                        return '';
                                        break;
                                    
                                    default:
                                        switch (type) {
                                                case 'display':
                                                    return data.length > 40 ?'<div class="text-ellipsis" title="' + data + '">' + data.substr(0, 50) + '…</div>' :data;
                                                    break;
                                            
                                                default:
                                                    return '--';
                                                    break;
                                            }
                                        break;
                                }
                                
                            }
                        }

                ]
        });
        
    }
    function showdataonthestatus(status) {
        var headerid=$('#recordIds').val();
        var id=$('#evalsupplierid').val();
        $('#evalstatus').val(status);

        var technicalpermit=$('#technicalviewpermission').val();
        var financalpremit=$('#financialviewpermission').val();
        var feprogresspermit=$('#financialprogresspermission').val();

        switch (status) {
                        case 0:
                        case 1:
                        case 2:
                            $('#initation').show();
                            $('#tectnicaltab').hide();
                            $('#financialtab').hide();
                            $('#initationview-tab').removeClass('active');
                            $('#technicalview-tab').removeClass('active');
                            $('#financialview-tab').removeClass('active');
                            $('#initationview-tab').addClass('active');

                            $('#initationview').removeClass('active');
                            $('#technicalview').removeClass('active');
                            $('#financialview').removeClass('active');
                            $('#initationview').addClass('active');

                        break;
                        
                        case 3:
                        case 4:
                        case 12:
                            switch (technicalpermit) {
                                case '1':
                                        $('#initation').show();
                                        $('#tectnicaltab').show();
                                        $('#financialtab').hide();

                                        $('#initationview-tab').removeClass('active');
                                        $('#technicalview-tab').removeClass('active');
                                        $('#financialview-tab').removeClass('active');
                                        $('#technicalview-tab').addClass('active');

                                        $('#initationview').removeClass('active');
                                        $('#technicalview').removeClass('active');
                                        $('#financialview').removeClass('active');
                                        $('#technicalview').addClass('active');

                                        commuditylistoftechnicalview(headerid,id);
                                    break;
                            
                                default:
                                        $('#initation').show();
                                        $('#tectnicaltab').hide();
                                        $('#financialtab').hide();
                                        $('#initationview-tab').removeClass('active');
                                        $('#technicalview-tab').removeClass('active');
                                        $('#financialview-tab').removeClass('active');
                                        $('#initationview-tab').addClass('active');

                                        $('#initationview').removeClass('active');
                                        $('#technicalview').removeClass('active');
                                        $('#financialview').removeClass('active');
                                        $('#initationview').addClass('active');

                                    break;
                            }
                            
                        break;
                        case 8:
                        case 9:
                        case 10:
                        case 11:
                        case 13:
                            switch (financalpremit) {
                                case '1':
                                        $('#initation').show();
                                        $('#tectnicaltab').show();
                                        $('#financialtab').show();
                                        $('#initationview-tab').removeClass('active');
                                        $('#technicalview-tab').removeClass('active');
                                        $('#financialview-tab').removeClass('active');
                                        $('#financialview-tab').addClass('active');

                                        $('#initationview').removeClass('active');
                                        $('#technicalview').removeClass('active');
                                        $('#financialview').removeClass('active');
                                        $('#financialview').addClass('active');

                                        commuditylistoffinancialview(headerid,id);
                                    break;
                            
                                default:
                                    break;
                            }
                            
                        break;
                        default:
                            break;
                    }

    }

    function infopelistbytab(params) {
            var headerid=$('#recordIds').val();
            var id=$('#evalsupplierid').val();
            var status=$('#evalstatus').val();
            switch (params) {
                case 'peview':
                        $('#finevaulatesuppliers').hide();
                        $('#backtotebutton').hide();
                        $('#financialapprovedbutton').hide();

                        $('#evaulatesuppliers').hide();
                        $('#backverifybutton').hide();
                        $('#approvedbutton').hide();
                        
                        $('#backtofebutton').hide();
                        $('#financialconfirmedbutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();
                        $('#financalevaulatingbutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#authorizebutton').hide();
                        
                    break;
                    case 'teview':
                        $('#finevaulatesuppliers').hide();
                        $('#backtotebutton').hide();
                        $('#financialapprovedbutton').hide();

                        $('#backtofebutton').hide();
                        $('#financialconfirmedbutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();

                        commuditylistoftechnicalview(headerid,id);

                        switch (status) {
                                case '2':
                                    $('#backtopendingbutton').show();
                                    $('#authorizebutton').show();
                                break;
                            case '3':
                                    $('#evaulatesuppliers').show();
                                    $('#backverifybutton').show();
                                    $('#approvedbutton').show();
                            break;

                                case '4':
                                    $('#evaulatesuppliers').hide();
                                    $('#backtotebutton').show();
                                    $('#financalevaulatingbutton').show();
                                    
                                break;
                        
                            default:
                                    $('#evaulatesuppliers').hide();
                                    $('#backverifybutton').hide();
                                    $('#approvedbutton').hide();
                                    $('#backtotebutton').hide();
                                    $('#financalevaulatingbutton').hide();
                                    $('#backtopendingbutton').hide();
                                    $('#authorizebutton').hide();
                                break;
                        }
                    break;
                default:    
                            
                        commuditylistoffinancialview(headerid,id);
                        console.log('status='+status);
                        switch (status) {
                            case '8':
                                $('#finevaulatesuppliers').show();
                                $('#backtotebutton').show();
                                $('#financialapprovedbutton').show();
                                break;
                            
                                case '9':
                                $('#backtofebutton').show();
                                $('#financialconfirmedbutton').show();
                                break;

                                case '10': 
                                    $('#backtofebutton').show();
                                    $('#financialapprovedafterconfirmbutton').show();
                                break;

                            default:
                                    $('#finevaulatesuppliers').hide();
                                    $('#backtotebutton').hide();
                                    $('#financialapprovedbutton').hide();
                                    $('#backtofebutton').hide();
                                    $('#financialconfirmedbutton').hide();
                                    $('#financialapprovedafterconfirmbutton').show();
                                break;
                        }
                    break;
            }
        }
function commuditylistoftechnicalview(headerid,id) {
        var comudtable=$('#technicalcomuditydocInfoItem').DataTable({
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
                url: "{{ url('getpebysupplier') }}/"+headerid+'/'+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'requestedorigin',name: 'requestedorigin',width:'20%'},
                {data: 'supplyorigin',name: 'supplyorigin', width:'20%'},
                {data: 'cropyear',name: 'cropyear',width:'10%'},
                {data: 'proccesstype',name: 'proccesstype',width:'10%'},
                {data: 'sampleamount',name: 'sampleamount',width:'10%'},
                {data: 'qualitygrade',name: 'qualitygrade'},
                {data: 'screensieve',name: 'screensieve'},
                {data: 'evmoisture',name: 'evmoisture'},
                {data: 'evcupvalue',name: 'evcupvalue'},
                {data: 'rowvalue',name: 'rowvalue'},
                {data: 'evscore',name: 'evscore'},
                {data: 'evstatus',name: 'evstatus'},
                {data: 'tecremark',name: 'tecremark', width:'30%'},
            ],
            columnDefs: [   
                        
                        {
                            targets: 14,
                            render: function ( data, type, row, meta ) {
                                var remark = (data === undefined || data === null || data === '') ? 'EMPTY' : data;
                                switch (remark) {
                                    case 'EMPTY':
                                        return '';
                                        break;
                                    
                                    default:
                                        switch (type) {
                                                case 'display':
                                                    return data.length > 40 ?'<div class="text-ellipsis" title="' + data + '">' + data.substr(0, 50) + '…</div>' :data;
                                                    break;
                                            
                                                default:
                                                    return '--';
                                                    break;
                                            }
                                        break;
                                }
                            }
                        }

                ]
        });
    }
    function commuditylistoffinancialview(headerid,id) {
        var comudtable=$('#financailcomuditydocInfoItem').DataTable({
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
                url: "{{ url('getpebysupplier') }}/"+headerid+'/'+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'requestedorigin',name: 'requestedorigin',width:'10%'},
                {data: 'supplyorigin',name: 'supplyorigin', width:'10%'},

                {data: 'cropyear',name: 'cropyear',width:'5%'},
                {data: 'proccesstype',name: 'proccesstype',width:'5%'},
                {data: 'qualitygrade',name: 'qualitygrade'},
                {data: 'bagamount',name: 'bagamount'},
                {data: 'customerprice',name: 'customerprice'},
                {data: 'proposedprice',name: 'proposedprice'},
                {data: 'finalprice',name: 'finalprice'},
                {data: 'rank',name: 'rank',width:'2%'},
                {data: 'fevremark',name: 'fevremark'},
            ],
            columnDefs: [   
                        {
                            targets: 11,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 0:
                                        return '';
                                        break;
                                    default:
                                        return data;
                                        break;
                                }
                            }
                        },
                        {
                            targets: 12,
                            render: function ( data, type, row, meta ) {
                                var remark = (data === undefined || data === null || data === '') ? 'EMPTY' : data;
                                switch (remark) {
                                    case 'EMPTY':
                                        return '';
                                        break;
                                    
                                    default:
                                        switch (type) {
                                                case 'display':
                                                    return data.length > 40 ?'<div class="text-ellipsis" title="' + data + '">' + data.substr(0, 50) + '…</div>' :data;
                                                    break;
                                            
                                                default:
                                                    return '--';
                                                    break;
                                            }
                                        break;
                                }
                            }
                        }
                ],
            
        });
    }
function viewpiformation(recordId) {
        var reference='';
            var poid=0;
            var path='';
            var paidamount=0.00;
            var popaidamount=0.00;
            var remaining=0.00;
            var poremaining=0.00;

            $.ajax({
                type: "GET",
                url: "{{ url('purinvoinfo') }}/"+recordId,
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
                        $("#pivcollapseOne").collapse('show');
                        $('#purchaseinvoiceinfomodal').modal('show');
                    },
                success: function (response) {
                        paidamount=response.paidamount;
                        popaidamount=response.popaidamount;
                    $.each(response.supplier, function (index, value) { 
                        $('#pivinfosuppid').html(value.Code);
                        $('#pivinfsupname').html(value.Name);
                        $('#pivinfosupptin').html(value.TinNumber);
                    });
                    
                    $.each(response.payrninfo, function (index, value) { 
                            switch (value.reference) {
                                case 'PO':
                                        var links='<b><u>'+value.porderno+'</u></b>';
                                        var glinks = '<a href="#" onclick="infoviewpurchaseivoicehistory('+value.poid+');"><u><b>View GRV History</b></u></a>';
                                        $('#grvhistory').html(glinks);
                                        $('.pivinfopo').html(links); 
                                        $('.infopetr').show();
                                        $('#pivinforefernce').html('Purchase Order');
                                    break;
                                
                                default:
                                    $('.infopetr').hide();
                                    $('#pivinforefernce').html(value.reference);
                                    $('#grvhistory').html('');
                                    break;
                            }
                        $('#pivdocno').html(value.docno);
                        $('#pivinfoStatus').html('<span class="text-success font-weight-medium"><b> '+value.docno+' Confirm</b>');
                        $('#pivinfocommoditype').html(value.commoditype);
                        $('#pivinfocommoditysource').html(value.commoditysource);
                        $('#pivinfocommoditystatus').html(value.commoditystatus);
                        $('#pivinfopaymentmode').html(value.paymentmode);
                        $('#pivinfodocumentdate').html(value.invoicedate);
                        $('#pivinfopaymentype').html(value.paymentype);
                        $('#pivinforecieptype').html(value.invoicetype);
                        $('#pivinfomrcno').html(value.mrc);
                        $('#pivinfoinvoice').html(value.voucherno);
                        switch (value.invoicetype) {
                            case 'Manual':
                                $('#payrinfomrcnotr').hide();
                                break;
                        
                            default:
                                    $('#payrinfomrcnotr').show();
                                break;
                        }
                        $('#pivinfodirectinfosubtotalLbl').html(numformat(value.subtotal));
                        $('#pivinfodirectinfotaxLbl').html(numformat(value.tax));
                        $('#pivinfodirectinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#pivinfodirectinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#pivinfodirectinfonetpayLbl').html(numformat(value.netpay));
                        $('.popayrinfopar').html(value.docno);
                        $('#payrinforemainamount').html(numformat(remaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory('+value.poid+');"><u>View Payment History</u></a>';
                        
                        $('#pivinfoviewpaymenthistory').html(links);
                        $('.paymentrequestinfopurpose').html(value.purpose);
                        
                        $('#pivmentrequestinfomemo').html(value.memo);
                        
                        reference=value.reference;
                        poid=value.poid;
                        path=value.path;
                        
                        switch (value.istaxable) {
                            case 0:
                                $('#pivinfodirecttaxtr').hide();
                                $('#pivinfosupplierinfotaxtr').hide();
                                $('#pivinfosupplierinforandtotaltr').hide();
                                
                                break;
                        
                            default:
                                $('#pivinfodirecttaxtr').show();
                                $('#pivinfosupplierinfotaxtr').show();
                                $('#pivinfosupplierinforandtotaltr').show();
                                break;
                        }
                        switch (value.reference) {
                            case 'PO':
                                $('#pivdividerinfo').show();

                                $('#pivpaymentinfordirectprice').hide();
                                
                                break;
                            default:
                                $('#pivpaymentinfordirectprice').show();
                                
                                $('#pivdividerinfo').hide();
                                $('#ppivinfopaymentreference').html('Direct');
                                break;
                        }
                        path = (path === undefined || path === null || path === '') ? 'EMPTY' : path;
                        switch (path) {
                            case 'EMPTY':
                                var iframe = $('#purchaseinvoicepdfviewer')[0];
                                var doc = iframe.contentDocument || iframe.contentWindow.document;
                                doc.open();
                                // Write a simple HTML structure with the text
                                var text="No Document Attached";
                                doc.write('<html><body><h1>' + text + '</h1></body></html>');
                                // Close the document to apply changes
                                doc.close();
                                break;
                            default:
                                purchaseinvoiceviewdocuments(recordId);
                                break;
                        }
                    });
                    showpurchaseinvloicecommodity(recordId);
                    setpurchaseinvoiceminilog(response.actions);
                }
            });
            
    }
    function showpurchaseinvloicecommodity(recordId) {
                var someCondition = true;
                var reference=$('#pivinforefernce').html();
                switch (reference) {
                    case 'Direct':
                        someCondition=false;
                        break;
                    
                    default:
                            someCondition=true;
                        break;
                }
            var suptables=$('#pivtable').DataTable({
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
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('purcachaseinvloicecommoditylist') }}/"+recordId,                   
                type: 'GET',
            },
            columns: [
                    {data:'DT_RowIndex'},
                    {data: 'docno',name: 'docno',width:'11%', visible: false},
                    {data: 'origin',name: 'origin',width:'15%'},
                    {data: 'cropyear',name: 'cropyear'},
                    {data: 'proccesstype',name: 'proccesstype'},
                    {data: 'grade',name: 'grade'},
                    {data: 'uomname',name: 'uomname'},
                    {data: 'nofbag',name: 'nofbag'},
                    {data: 'netkg',name: 'netkg'},
                    {data: 'ton',name: 'ton'},
                    {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'price',name: 'price',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'total',name: 'total',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'recid',name: 'recid', visible:false},
            ],
            columnDefs: [
                                {
                                    targets:1,
                                    render:function(data,type,row,meta){
                                        
                                        return '<a href="#" onclick="viewrecievinginformation('+row.recid+');"><u>'+data+'</u></a>';
                                    }
                            },
            ],
            rowGroup: {
                        startRender: function ( rows, group,level) {
                            var color = '';
                            var gr='--';
                            switch (someCondition) {
                                case true:
                                        var reid =  []
                                        var groupedData = rows.data(); 
                                        groupedData.each(function(rowData) {
                                            reid.push(rowData.recid);          // Collect names
                                        });
                                        var uniqueArray = [];
                                        reid.forEach(function(item) {
                                            // If the item is not already in the uniqueArray, add it
                                            if (!uniqueArray.includes(item)) {
                                                uniqueArray.push(item);
                                            }
                                        });
                                        // console.log('reid='+reid);
                                        // console.log('uniqueArray='+uniqueArray);
                                        if(level===0){
                                                var grp='<b><u>'+group+'</u></b>';
                                                return $('<tr ' + color + '/>')
                                                .append('<th colspan="12" style="text-align:left;background:#ccc; font-size:12px;">' + grp + ' </th>')
                                            }
                                            else{
                                                return $('<tr ' + color + '/>')
                                                .append('<th colspan="5" style="text-align:left;border:1px solid;background:#f2f3f4;font-size:12px;">Customer: ' + group + '</th>')
                                            }
                                    break;
                                        
                                default:
                                    break;
                            }
                            
                        },
                        dataSrc: ['docno']
                    },
                
            "initComplete": function(settings, json) {
                var totalRows = suptables.rows().count();
                $('#pivinfodirectinfonumberofItemsLbl').html(totalRows);

            },
            "footerCallback": function (row, data, start, end, display) {
                
                var api = this.api();
                // Helper function to parse integer from strings
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :  // Remove commas and convert to int
                        typeof i === 'number' ?
                            i : 0;
                };

                var totalbag = api
                .column(7)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalnet = api
                .column(8)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalton = api
                .column(9)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalferesula = api
                .column(10)  // The column index where the numeric data is
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var totalprice = api
                    .column(11)  // The column index where the numeric data is
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    var totaltotal = api
                    .column(12)  // The column index where the numeric data is
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    
                        var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                        $('#pinfonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalbag)+"</h6>");
                        $('#pinfokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalnet)+"</h6>");
                        $('#pinfotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalton)+"</h6>");
                        $('#pinfopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalferesula)+"</h6>");
                        $('#pinfopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalprice)+"</h6>");
                        $('#pinfototalpricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totaltotal)+"</h6>");

                }
            });
        }

        function setpurchaseinvoiceminilog(actions) {
            var list='';
            var icons=''
            var reason='';
            var addedclass='';
        $('#paymentinvoiceulist').empty();
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back To pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                        break;
                case 'Confirmed':
                        icons='success timeline-point';
                        addedclass='text-success';
                        reason='';
                break;
                case 'Reviewed':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                        reason='';
                break;
                case 'Created':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;

                case 'Undo Review':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;
                
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
                    reason='';
                break;
                
                case 'Void':
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                    break;
                case 'Refund':
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
        $('#paymentinvoiceulist').append(list);
        }

        function infoviewpurchaseivoicehistory(id){
                var cname=$('#pivinfsupname').text()||0;
                var tin=$('#pivinfosupptin').text()||0;
                var customertile=cname+' '+tin;
                $('#paymentinvoicehistorystatus').html('History Of '+customertile);
                $('#historpurchaseinvoicetables').DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            fixedHeader: true,
                            searchHighlight: true,
                            destroy:true,
                            paging: false,
                            ordering:false,
                            info: false,    
                            lengthMenu: [[50, 100], [50, 100]],
                            "pagingType": "simple",
                            language: { search: '', searchPlaceholder: "Search here"},
                            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                            ajax: {
                            url: "{{ url('pihistorypaymentrequestlist') }}/"+id,
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
                            $('#purchaseinvloicehistorymodal').modal('show');
                        },
                    },
                    columns: [
                        { data:'DT_RowIndex'},
                        { data: 'grv', name: 'grv','visible': true },
                        { data: 'piv', name: 'piv' },
                        { data: 'invoicedate', name: 'invoicedate' },
                        { data: 'paymentype', name: 'paymentype' },
                        { data: 'invoicetype', name: 'invoicetype' },
                        { data: 'mrc', name: 'mrc' },
                        { data: 'voucherno', name: 'voucherno' },
                        { data: 'invoiceno', name: 'invoiceno' },
                        { data: 'status', name: 'status' },
                    
                    ],

                    columnDefs: [   

                            {
                                targets: 9,
                                render: function ( data, type, row, meta ) {
                                    switch (data) {
                                        case '0':
                                            return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                            break;
                                        case '1':
                                            return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                                        break;
                                        case '2':
                                            return '<span class="text-primary font-weight-medium"><b>Verify</b></span>';
                                        break;
                                        case '3':
                                            return '<span class="text-success font-weight-medium"><b>Confirmed</b></span>';
                                        break;
                                        case '4':
                                            return '<span class="text-danger font-weight-danger"><b>Void</b></span>';
                                        break;
                                        case '5':
                                            return '<span class="text-danger font-weight-danger"><b>Refund</b></span>';
                                        break;
                                        default:
                                            return data;
                                            break;
                                    }
                                }
                            },
                    ],
            });
    }
function viewrecievinginformation(recordId){
            $('#receivinginfomodaltitle').html("Receiving Information");
            $("#statusid").val(recordId);
            $("#recieverecordIds").val(recordId);
            $('.datatableinfocls').hide();
            $('.recpropbtn').hide();
            var visibilitymode=false;
            var lidata="";
            
            $.ajax({
                url: '/showRecDataRec'+'/'+recordId,
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
                    $.each(data.holdHeader, function(key, value) {
                        $('#infoDocType').text(value.Type);
                        $('#infoDocDocNo').text(value.DocumentNumber);
                        $('#referenceLbl').text(value.RecType);
                        $('#purchaseOrdLbl').text(value.porderno);
                        $('#commoditySrcLbl').text(value.CommoditySource);
                        $('#commodityTypeLbl').text(value.CommodityType);
                        $('#productTypeLbl').text(value.ProductType);
                        $('#companyTypeLbl').text(value.CompanyTypeLbl);
                        $('#infoDocCustomerName').text(value.CustomerName);
                        $('#customerOrOwnerLbl').text(value.CustomerOrOwner);
                        
                        $('#deliveryOrderLbl').text(value.DeliveryOrderNo);
                        $('#dispatchStationLbl').text(value.DispatchStation);
                        $('#infoDocReceivingStore').text(value.StoreName);
                        $('#receivedByLbl').text(value.ReceivedBy);
                        $('#driverNameLbl').text(value.DriverName);
                        $('#plateNumberLbl').text(value.TruckPlateNo);
                        $('#driverPhoneLbl').text(value.DriverPhoneNo);
                        $('#deliveredByLbl').text(value.DeliveredBy);
                        $('#receivedDateLbl').text(value.ReceivedDate);
                        $('#remarkLbl').text(value.Memo);

                        $("#statusIds").val(value.Status);
                        var statusvals=value.Status;
                        var statusvalsold=value.StatusOld;
                        if(parseInt(value.CompanyType)==1){
                            $("#customerOwnerRec").hide();
                        }
                        else if(parseInt(value.CompanyType)==2){
                            $("#customerOwnerRec").show();
                        }

                        if(value.ProductType=="Commodity"){
                            $("#commoditySrcRow").show();
                            $("#commodityTypeRow").show();
                            $("#infoCommDatatable").show();
                        }
                        else if(value.ProductType=="Goods"){
                            $("#commoditySrcRow").hide();
                            $("#commodityTypeRow").hide();
                            $("#infoGoodsDatatable").show();
                        }

                        if(parseInt(value.InvoiceStatus)==0){
                            $("#invoiceStatusLbl").html("Waiting");
                        }
                        else if(parseInt(value.InvoiceStatus)==1){
                            $("#invoiceStatusLbl").html("Received");
                        }

                        if(statusvals==="Draft"){
                            $("#changetopending").show();
                            $("#statustitles").html("<span style='color:#A8AAAE;font-weight:bold;text-shadow;1px 1px 10px #A8AAAE;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else if(statusvals==="Pending"){
                            $("#backtodraft").show();
                            $("#checkreceiving").show();
                            $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else if(statusvals==="Verified"){
                            $("#confirmreceiving").show();
                            $("#backtopending").show();
                            $("#statustitles").html("<span style='color:#7367F0;font-weight:bold;text-shadow;1px 1px 10px #7367F0;font-size:16px;'>"+statusvals+"</span>");
                        }
                        else if(statusvals==="Confirmed" || statusvals==="Received"){
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

                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending" || value.action == "Back to Pending"){
                            classes="warning";
                        }
                        else if(value.action == "Verified" || value.action == "Change to Counting"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Undo Void"){
                            classes="secondary";
                        }
                        else if(value.action == "Confirmed" || value.action == "Received"){
                            classes="success";
                        }
                        else if(value.action == "Void"){
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
                },
            });

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
                    url: '/showrecDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode',
                        width:'10%',
                    },
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
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:'17%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:'5%',
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width:'7%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'BeforeTaxCost',
                        name: 'BeforeTaxCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    { data: 'BatchNumber', name: 'BatchNumber','visible': false },
                    { data: 'SerialNumber', name: 'SerialNumber','visible': false },
                    { data: 'ExpireDate', name: 'ExpireDate','visible': false },
                    { data: 'ManufactureDate', name: 'ManufactureDate','visible': false },
                    { data: 'RequireSerialNumber', name: 'RequireSerialNumber','visible': false },  
                    { data: 'RequireExpireDate', name: 'RequireExpireDate','visible': false },           
                ],
                "columnDefs": [
                    {
                        "targets": [8,9],
                        "visible": visibilitymode,
                    },
                ]
            });

            $('#origindetailtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                "order": [
                    [2, "asc"]
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
                    url: '/showRecCommodity/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"6%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"6%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"8%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"6%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"6%"
                    },
                    {
                        data: 'CropYearData',
                        name: 'CropYearData',
                        width:"6%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"6%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"6%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"6%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"6%"
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

                    var totalbagvar = api
                    .column(8)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagweight = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalgrosskg = api
                    .column(10)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkgvar = api
                    .column(11)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalferesulavar = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaltonvar = api
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceshr = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceov = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#totalbag').html(totalbagvar === 0 ? '' : numformat(totalbagvar));
                    $('#totalbagweight').html(totalbagweight === 0 ? '' : numformat(totalbagweight.toFixed(2)));
                    $('#totalgrosskg').html(totalgrosskg === 0 ? '' : numformat(totalgrosskg.toFixed(2)));
                    $('#totalkg').html(totalkgvar === 0 ? '' : numformat(totalkgvar.toFixed(2)));
                    $('#totalton').html(totaltonvar === 0 ? '' : numformat(totaltonvar.toFixed(2)));
                    $('#totalferesula').html(totalferesulavar === 0 ? '' : numformat(totalferesulavar.toFixed(2)));
                    $('#totalvarshortage').html(totalvarianceshr === 0 ? '' : numformat(totalvarianceshr.toFixed(2)));
                    $('#totalvarovrage').html(totalvarianceov === 0 ? '' : numformat(totalvarianceov.toFixed(2)));
                },
            });

            $("#recievingdocInfoModal").modal('show');
            $(".infoscl").collapse('show');
            $("#docRecInfoItem").show();
            $("#infoRecDiv").show();
            $("#docInfoItem").hide();
            $("#infoHoldDiv").hide();
            //var oTable = $('#docRecInfoItem').dataTable();
            //oTable.fnDraw(false);
            //$('#laravel-datatable-crud').DataTable().ajax.reload();
        }

function payrinformations(recordId) {
            var reference='';
            var poid=0;
            var path='';
            var paidamount=0.00;
            var popaidamount=0.00;
            var remaining=0.00;
            var poremaining=0.00;
            var paymentreference='';
            var totalamount=0.00;
            $('#pyrrecordIds').val(recordId);
            $.ajax({
                type: "GET",
                url: "{{ url('payrinfo') }}/"+recordId,
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
                        $("#payrcollapseOne").collapse('show');
                        $('#paymentrequestinfomodal').modal('show');
                    },
                success: function (response) {
                        paidamount=response.paidamount;
                        popaidamount=response.popaidamount;
                        totalamount=response.totalamount;
                        remaining=parseFloat(totalamount)-parseFloat(paidamount);
                        $('#popayrinfototalamount').html(numformat(totalamount));
                        $('#popayrinfototalpayamount').html(popaidamount);
                        
                    $.each(response.supplier, function (index, value) { 
                        $('#paymentrequestinfosuppid').html(value.Code);
                        $('#paymentrequestinfsupname').html(value.Name);
                        $('#paymentrequestinfosupptin').html(value.TinNumber);
                    });
                    $.each(response.podata, function (index, value) { 
                        switch (value.type) {
                            case 'Direct':
                                $('.paymentrequestinfopetr').hide();
                                break;
                            default:
                                $('.paymentrequestinfopetr').show();
                                break;
                        }
                        $('.paymentrequestinforeference').html(value.type);
                        
                        $('#popayrinfopaymentreference').html('PO');
                        $('#popayrinfopaymentmode').html('Advance');
                        $('#popayrinfopaymentstatus').html('Partial');
                        
                        $('#popayrinfototalpayamount').html(numformat(paidamount));
                        poremaining=parseFloat(value.netpay)-parseFloat(paidamount);
                        $('#popayrinforemainamount').html(numformat(poremaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory('+value.id+','+value.supplier+');"><u>View Payment History</u></a>';
                        $('#popayrinfoviewpaymenthistory').html(links);
                    });
                    $.each(response.payrninfo, function (index, value) { 
                        paymentreference=value.paymentreference;
                            switch (value.reference) {
                                case 'PO':
                                    var links='<a href="#" onclick="viewpoinformation('+value.poid+');"><u>'+value.porderno+'</u></a>';
                                    $('.paymentrequestinfopo').html(links); 
                                    $('.infopetr').show();
                                    $('#payrinforefernce').html('Purchase Order');
                                    break;
                                
                                default:
                                    $('.infopetr').hide();
                                    $('#payrinforefernce').html(value.reference);
                                    break;
                            }
                            switch (value.paymentreference) {
                                case 'PO':
                                    $('.paymentrefernceclass').html('Purchase Order');
                                    break;
                                case 'PI':
                                        
                                    $('.paymentrefernceclass').html('Purchase Invoice');
                                break;
                                default:
                                        
                                    $('.paymentrefernceclass').html('Good Recieving');
                                    break;
                            }
                        
                        $('#parydocno').html(value.docno);
                        
                        $('#payrinfocommoditype').html(value.commoditype);
                        $('#payrinfocommoditysource').html(value.commoditysource);
                        $('#payrinfocommoditystatus').html(value.commoditystatus);
                        $('#payrinfopaymentmode').html(value.paymentmode);
                        $('#payrinfodocumentdate').html(value.date);
                        $('#payrinfopaymentstatus').html(value.paymentstatus);
                        $('#grndirectsubtotalLbl').html(numformat(value.subtotal));
                        $('#grndirecttaxLbl').html(numformat(value.tax));
                        $('#grndirectgrandtotalLbl').html(numformat(value.grandtotal));
                        $('#grndirectwitholdingAmntLbl').html(numformat(value.withold));
                        $('#grndirectnetpayLbl').html(numformat(value.netpay));
                        $('#payrinfototalpayamount').html(numformat(value.netpay));
                        $('#payrinfopaidamount').html(numformat(value.Amount));
                        $("#payrinfopaidamount").css("text-decoration", "underline");
                        $('#payrinfototalpayamount').html(numformat(totalamount));
                        $('#directpopayrinfopaidamount').html(numformat(value.Amount));
                            //-----show for po data----
                        $('#payrinfodirectinfosubtotalLbl').html(numformat(value.subtotal));
                        $('#payrinfodirectinfotaxLbl').html(numformat(value.tax));
                        $('#payrinfodirectinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#payrinfodirectinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#payrinfodirectinfonetpayLbl').html(numformat(value.netpay));
                        // end of show po data
                        $('#payrinfopayamount').html(numformat(paidamount.toFixed(2)));
                        
                        $('#popayrinfopaidamount').html(numformat(value.Amount));
                        $("#popayrinfopaidamount").css("text-decoration", "underline");
                        $('.popayrinfopar').html(value.docno);

                        $('#payrinforemainamount').html(numformat(remaining.toFixed(2)));
                        var links = '<a href="#" onclick="infoviewpaymenthistory('+value.poid+');"><u>View Payment History</u></a>';

                        $('#payrinfoviewpaymenthistory').html(links);
                        $('.paymentrequestinfopurpose').html(value.purpose);
                        
                        $('#paymentrequestinfomemo').html(value.memo);
                        
                        reference=value.reference;
                        poid=value.poid;
                        path=value.path;

                        showactionbuttondependonstat(value.status,value.docno);
                        switch (value.istaxable) {
                            case 0:
                                $('#infodirecttaxtr').hide();
                                $('#grndirectgrandtotaltr').hide();
                                
                                break;
                            
                            default:
                                $('#infodirecttaxtr').show();
                                $('#grndirectgrandtotaltr').show();
                                break;
                        }
                        switch (value.reference) {
                            case 'PO':
                                $('#dividerinfo').show();
                                $('#commodityrowinfo').show();
                                $('#paymentinfordirectprice').hide();
                                $('.potr').show();
                                break;
                            default:
                                $('#paymentinfordirectprice').show();
                                $('#commodityrowinfo').hide();
                                $('#dividerinfo').hide();
                                $('#payrinfopaymentreference').html('Direct');
                                $('.potr').hide();
                                break;
                        }
                        path = (path === undefined || path === null || path === '') ? 'EMPTY' : path;
                        switch (path) {
                            case 'EMPTY':
                                var iframe = $('#pdfviewer')[0];
                                var doc = iframe.contentDocument || iframe.contentWindow.document;
                                doc.open();
                                // Write a simple HTML structure with the text
                                var text="No Document Attached";
                                doc.write('<html><body><h1>' + text + '</h1></body></html>');
                                // Close the document to apply changes
                                doc.close();
                                break;
                            default:
                                viewdocuments(recordId);
                                break;
                        }
                    });
                    switch (response.exist) {
                        case true:
                            showcommodity(recordId,paymentreference);
                            switch (paymentreference) {
                                case 'PI':
                                        $('#payrinfoapptabs .nav-link[data-tab="1"]').addClass('disabled');
                                        $('#payrinfoapptabs .nav-link[data-tab="2"]').addClass('disabled'); 
                                        $('#payrinfoapptabs .nav-link[data-tab="3"]').removeClass('disabled');
                                        $('#purchaseorderview-tab').removeClass('active');

                                        $('#payrinfopurchaseorderview-tab').removeClass('active');
                                        $('#payrinfogrnview-tab').removeClass('active');
                                        
                                        $('#payrinfopurchaseorderview').removeClass('active');
                                        $('#payrinfogrnview').addClass('active');

                                        $('#payrinfopiview-tab').addClass('active');
                                        
                                        $('#payrinfopiview').removeClass('active');
                                    break;
                            
                                default:
                                        $('#payrinfoapptabs .nav-link[data-tab="1"]').addClass('disabled');
                                        $('#payrinfoapptabs .nav-link[data-tab="2"]').removeClass('disabled');
                                        $('#payrinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');
                                        $('#purchaseorderview-tab').removeClass('active');

                                        $('#payrinfogrnview-tab').removeClass('active');
                                        $('#payrinfopiview-tab').removeClass('active');
                                        $('#payrinfopurchaseorderview-tab').removeClass('active');
                                        $('#payrinfogrnview-tab').addClass('active');

                                        $('#payrinfopurchaseorderview').removeClass('active');
                                        $('#payrinfopiview').removeClass('active');
                                        $('#payrinfogrnview').addClass('active');
                                    break;
                            }
                            
                            break;
                        
                        default:
                            $('#payrinfoapptabs .nav-link[data-tab="2"]').addClass('disabled');
                            $('#payrinfoapptabs .nav-link[data-tab="3"]').addClass('disabled');
                            $('#payrinfogrnview-tab').removeClass('active');
                            $('#payrinfopiview-tab').removeClass('active');
                            $('#payrinfopurchaseorderview-tab').removeClass('active');
                            $('#payrinfopurchaseorderview-tab').addClass('active');

                            $('#payrinfogrnview').removeClass('active');
                            $('#payrinfopurchaseorderview').addClass('active');

                            break;
                    }

                    switch (reference) {
                        case 'PO':
                           // showpodata(recordId,response.podata);
                            break;
                        
                        default:
                            break;
                    }

                    setpaymentrequestminilog(response.actions);

                }
            });
        }

        function setpaymentrequestminilog(actions) {
            var list='';
            var icons=''
            var reason='';
            var addedclass='';
        $('#paymentrequestulist').empty();
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back To pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
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
                case 'Reviewed':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                        reason='';
                break;
                case 'Created':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;
                case 'Undo Review':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;
                
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
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
        $('#paymentrequestulist').append(list);

        }

        function showcommodity(recordId,paymentreference) {
            
            var visiblemode=false;
            switch (paymentreference) {
                case 'PI':
                    visiblemode=true;
                    break;
            
                default:
                        visiblemode=false;
                    break;
            }
            var suptables=$('#payrinfodirectdynamicTablecommdity').DataTable({
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
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('payrequestcommoditylist') }}/"+recordId,                   
                type: 'GET',
            },
            columns: [

                    {data:'DT_RowIndex'},
                    {data: 'docno',name: 'docno',width:'11%'},
                    {data: 'pidocno',name: 'pidocno',width:'11%',visible:visiblemode},
                    {data: 'origin',name: 'origin',width:'15%'},
                    {data: 'grade',name: 'grade'},
                    {data: 'proccesstype',name: 'proccesstype'},
                    {data: 'cropyear',name: 'cropyear'},
                    {data: 'uomname',name: 'uomname'},
                    {data: 'nofbag',name: 'nofbag'},
                    {data: 'bagwieght',name: 'bagwieght'},
                    {data: 'totalkg',name: 'totalkg'},
                    {data: 'netkg',name: 'netkg'},
                    {data: 'ton',name: 'ton'},
                    {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 4, '')},
                    {data: 'price',name: 'price',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'total',name: 'total',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                    {data: 'recid',name: 'recid', visible:false},
                    {data: 'pid',name: 'pid', visible:false},
            ],
            columnDefs: [
                                {
                                    targets:1,
                                    render:function(data,type,row,meta){
                                        
                                        return '<a href="#" onclick="viewrecievinginformation('+row.recid+');"><u>'+data+'</u></a>';
                                    }
                            },
                            {
                                    targets:2,
                                    render:function(data,type,row,meta){
                                        
                                        return '<a href="#" onclick="viewpiformation('+row.pid+');"><u>'+data+'</u></a>';
                                    }
                            }
            ],
            "footerCallback": function (row, data, start, end, display) {
                
                var api = this.api();
                // Helper function to parse integer from strings
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :  // Remove commas and convert to int
                        typeof i === 'number' ?
                            i : 0;
                };

                var totalbag = api
                .column(8)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalbagwieght = api
                .column(9)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalkg = api
                .column(10)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalnet = api
                .column(11)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalton = api
                .column(12)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalferesula = api
                .column(13)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totalprice = api
                .column(14)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var totaltotal = api
                .column(15)  // The column index where the numeric data is
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                $('#infonofbagtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalbag)+"</h6>");
                $('#infobagweighttotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalbagwieght)+"</h6>");
                $('#infokgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalkg)+"</h6>");
                $('#infonetkgtotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalnet)+"</h6>");
                $('#infotontotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalton)+"</h6>");
                $('#infopriceferesula').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalferesula)+"</h6>");
                $('#infopricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalprice)+"</h6>");
                $('#infototalpricetotal').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totaltotal)+"</h6>");
            },
            "initComplete": function(settings, json) {
                var totalRows = suptables.rows().count();
                $('#grndirectnumberofItemsLbl').html(totalRows);
            }
        });

    }
function showactionbuttondependonstat(status,docno) {
            switch (status) {
                case 0:
                        $('#payreditbutton').show();
                        $('#payrpendingbutton').show();
                        $('#payrvoidbutton').show();
                        $('#payrejectbutton').show();
                        $('#payrverifybutton').hide();
                        $('#payrapprovebutton').hide();
                        $('#payrundovoidbutton').hide();
                        $('#payrundorejectbutton').hide();
                        $('#payrundoreviewbutton').hide();
                        $('#payrreviewbutton').hide();
                        $('#payrbacktopendingbutton').hide();
                        $('#payrbacktodraftbutton').hide();
                        $('#payrbacktoverifybutton').hide();
                        $('#payrprintbutton').hide();
                        $('#paymentrequestinfoStatus').html('<span class="text-secondary font-weight-medium"><b> '+docno+' Draft</b>');
                    break;
                    case 1:
                        $('#payreditbutton').show();
                        $('#payrbacktodraftbutton').show();
                        $('#payrpendingbutton').hide();
                        $('#payrverifybutton').show();
                        $('#payrapprovebutton').hide();
                        $('#payrundovoidbutton').hide();
                        $('#payrundorejectbutton').hide();
                        $('#payrundoreviewbutton').hide();
                        $('#payrreviewbutton').hide();
                        $('#payrbacktopendingbutton').hide();
                        $('#payrbacktoverifybutton').hide();
                        $('#payrprintbutton').hide();
                        $('#paymentrequestinfoStatus').html('<span class="text-warning font-weight-medium"><b> '+docno+' Pending</b>');
                    break;
                    case 2:
                        $('#payreditbutton').show();
                        $('#payrbacktopendingbutton').show();
                        $('#payrpendingbutton').hide();
                        $('#payrverifybutton').hide();
                        $('#payrapprovebutton').show();
                        $('#payrundovoidbutton').hide();
                        $('#payrundorejectbutton').hide();
                        $('#payrbacktodraftbutton').hide();
                        $('#payrbacktoverifybutton').hide();
                        $('#payrundoreviewbutton').hide();
                        $('#payrreviewbutton').hide();
                        $('#payrprintbutton').hide();
                        $('#paymentrequestinfoStatus').html('<span class="text-primary font-weight-medium"><b> '+docno+' Verify</b>');
                    break;
                    case 3: 
                            $('#payrbacktoverifybutton').show();
                            $('#payrprintbutton').show();
                            $('#payrpendingbutton').hide();
                            $('#payrverifybutton').hide();
                            $('#payrapprovebutton').hide();
                            $('#payrundovoidbutton').hide();
                            $('#payrundorejectbutton').hide();
                            $('#payreditbutton').hide();
                            $('#payrundoreviewbutton').hide();
                            $('#payrreviewbutton').hide();
                            $('#payrbacktopendingbutton').hide();
                            $('#payrbacktodraftbutton').hide();
                            $('#paymentrequestinfoStatus').html('<span class="text-success font-weight-medium"><b> '+docno+' Approved</b>');
                    break;
                    case 5:
                            $('#payrundorejectbutton').show();
                            $('#payrpendingbutton').hide();
                            $('#payrverifybutton').hide();
                            $('#payrapprovebutton').hide();
                            $('#payrundovoidbutton').hide();
                            $('#payrvoidbutton').hide();
                            $('#payreditbutton').hide();
                            $('#payrejectbutton').hide();
                            $('#payrprintbutton').hide();
                            $('#payrbacktopendingbutton').hide();
                            $('#payrbacktodraftbutton').hide();
                            $('#payrbacktoverifybutton').hide();
                            $('#payrreviewbutton').hide();
                            $('#payrundoreviewbutton').hide();
                            $('#paymentrequestinfoStatus').html('<span class="text-danger font-weight-medium"><b> '+docno+' Reject</b>');
                    break;
                    case 4:
                            $('#payrundovoidbutton').show();
                            $('#payrundorejectbutton').hide();
                            $('#payrpendingbutton').hide();
                            $('#payrverifybutton').hide();
                            $('#payrapprovebutton').hide();
                            $('#payrvoidbutton').hide();
                            $('#payreditbutton').hide();
                            $('#payrejectbutton').hide();
                            $('#payrprintbutton').hide();
                            $('#payrbacktopendingbutton').hide();
                            $('#payrbacktodraftbutton').hide();
                            $('#payrbacktoverifybutton').hide();
                            $('#payrreviewbutton').hide();
                            $('#payrundoreviewbutton').hide();
                            $('#paymentrequestinfoStatus').html('<span class="text-danger font-weight-medium"><b> '+docno+' Void</b>');
                    break;
                    case 6: 
                            $('#payrreviewbutton').show();
                            $('#payrundoreviewbutton').hide();
                            $('#payrundovoidbutton').hide();
                            $('#payrundorejectbutton').hide();
                            $('#payrpendingbutton').hide();
                            $('#payrverifybutton').hide();
                            $('#payrapprovebutton').hide();
                            $('#payrvoidbutton').hide();
                            $('#payreditbutton').hide();
                            $('#payrejectbutton').hide();
                            $('#payrbacktopendingbutton').hide();
                            $('#payrbacktodraftbutton').hide();
                            $('#payrbacktoverifybutton').hide();
                            $('#payrprintbutton').hide();
                            $('#paymentrequestinfoStatus').html('<span class="text-danger font-weight-medium"><b> '+docno+' Review</b>');
                    break;
                default:
                        $('#payrundoreviewbutton').show();
                        $('#payrapprovebutton').show();
                        $('#payrbacktopendingbutton').show();
                        $('#payrreviewbutton').hide();
                        $('#payrundovoidbutton').hide();
                        $('#payrundorejectbutton').hide();
                        $('#payrpendingbutton').hide();
                        $('#payrverifybutton').hide();
                        $('#payrvoidbutton').hide();
                        $('#payreditbutton').hide();
                        $('#payrejectbutton').hide();
                        $('#payrbacktodraftbutton').hide();
                        $('#payrbacktoverifybutton').hide();
                        $('#payrprintbutton').hide();
                        $('#paymentrequestinfoStatus').html('<span class="text-success font-weight-medium"><b> '+docno+' Reviewed</b>');
                    break;
            }
        }

function poinformations(recordId) {
            var status='';
            var type='';
            var poid='';
            var pono='';
            var peno='';
            var peid='';
            $('#porecordIds').val(recordId);
            $.ajax({
            type: "GET",
            url: "{{ url('poinfo') }}/"+recordId,
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
                        $('#modals-slide-in').modal('show');
                    },
            success: function (response) {
                    peno=response.pedocno;
                    
                    $('#infodocumentdate').html(response.createdAtInAddisAbaba);
                    $.each(response.po, function (index, value) { 
                        $('#inforefernce').html(value.type);
                        $('#infopo').html(value.porderno);
                        $('#inforderdate').html(value.orderdate);
                        $('#infodeliverdate').html(value.deliverydate);
                        $('#infopaymenterm').html(value.paymenterm);
                        $('#directinfosubtotalLbl').html(numformat(value.subtotal));
                        $('#directinfotaxLbl').html(numformat(value.tax));
                        $('#directinfograndtotalLbl').html(numformat(value.grandtotal));
                        $('#directinfowitholdingAmntLbl').html(numformat(value.withold));
                        $('#directinfovatAmntLbl').html(value.withold);
                        $('#directinfonetpayLbl').html(numformat(value.netpay));
                        $('#infocommoditype').html(value.commudtytype);
                        $('#infocommoditysource').html(value.commudtysource);
                        $('#infocommoditystatus').html(value.commudtystatus);
                        status=value.status;
                        type=value.type;
                        poid=value.id;
                        pono=value.porderno;
                        peid=value.purchasevaulation_id;
                        switch (value.istaxable) {
                            case 1:
                                $('#supplierinfotaxtr').show();
                                $('#supplierinforandtotaltr').show();
                                break;
                            default:
                                $('#supplierinfotaxtr').hide();
                                $('#supplierinforandtotaltr').hide();
                                break;
                        }
                        if(parseFloat(value.subtotal)>=10000){
                            $('#visibleinfowitholdingTr').show();
                            $('#directinfonetpayTr').show();
                        }
                        else{
                            $('#visibleinfowitholdingTr').hide();
                            $('#directinfonetpayTr').hide();
                        }
                    });
                    $.each(response.customer, function (index, value) { 
                        $('#infosuppid').html(value.Code);
                        $('#infsupname').html(value.Name);
                        $('#infosupptin').html(value.TinNumber);
                    });
                    switch (type) {
                    case 'Direct':
                    case 'PE':
                            peno = (peno === undefined || peno === null || peno === '' || peno === '--') ? 'EMPTY' : peno;
                            switch (peno) {
                                case 'EMPTY':
                                    $('.infopetr').hide();
                                    break;
                                default:
                                    var peviewpermit= $('#purchasevualationviewpermission').val();
                                    var links='';
                                    $('.infopetr').show();
                                    switch (peviewpermit) {
                                        case '1':
                                            links = '<a href="#" onclick="viewpeinformation('+peid+');"><u>'+peno+'</u></a>';
                                            break;

                                        default: 
                                            links=peno;
                                            break;
                                    }
                                    
                                    $('#infope').html(links);
                                    ;
                                    break;
                            }
                            $('#directcommuditylistdatabledivinfo').show();
                            $('#directsupplyinformationdiv').show();
                            $('.infodirect').show();
                            $('#directfooter').show();
                            $('#ulist').show();
                            $('#ulistsupplier').hide();
                            $('#pefooter').hide();
                            $('#commuditylistdatabledivinfo').hide();
                            $('#supplyinformationdiv').hide();
                            $('#itemsdatabledivinfo').hide();
                            directcommoditylist(poid);
                            $('.directdivider').html('Commodity List');
                            $('#infowarehouse').html(response.storename);
                        break;
                        
                    default: 
                        $('.directdivider').html('Supplier Purchase order list');
                        $('#supplyinformationdiv').show();
                        $('#pefooter').show();
                        $('.infopetr').show();
                        $('#ulistsupplier').show();
                        $('#ulist').hide();
                        $('.infodirect').hide();
                        $('#directfooter').hide();
                        $('#directsupplyinformationdiv').hide();

                    switch (response.type) {
                                case "Goods":
                                    
                                    break;
                            
                                default: 
                                    $('#itemsdatabledivinfo').hide();
                                    $('#commuditylistdatabledivinfo').show();
                                    var tables='comuditydocInfoItem';
                                    // setsupplierbytab(response.supplier);
                                    // commoditylist(response.peid,tables);
                                    //showsupplier(response.peid);
                                    directcommoditylist(poid);
                                    break;
                            }
                            $('#directcommuditylistdatabledivinfo').hide();
                        break;
                }
                
                showbuttondependonstat(pono,status,type);
                setminilog(response.actions);
            }
        });
    }

    function directcommoditylist(id) {
        var suptables=$('#directcommudityinfodatatables').DataTable({
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
            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('directcommoditylist') }}/"+id,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex'},
                {data: 'origin',name: 'origin'},
                {data: 'cropyear',name: 'cropyear'},
                {data: 'proccesstype',name: 'proccesstype'},
                {data: 'grade',name: 'grade'},
                {data: 'uomname',name: 'uomname'},
                {data: 'qty',name: 'qty',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'bagweight',name: 'bagweight',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'totalKg',name: 'totalKg',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'netkg',name: 'netkg',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'ton',name: 'ton',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'price',name: 'price'},
                {data: 'Total',name: 'Total',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                {data: 'price',name: 'price'},
            ],
                columnDefs: [
                                {
                                    targets: 14,
                                    render: function ( data, type, row, meta ) {
                                        return `<i class="info-icon fa fa-info-circle text-primary" 
                                            data-id="${data}" 
                                            data-price="${data}" 
                                            title="Price/Kg">
                                            </i>`;
                                    }
                                },
                            ],
            "initComplete": function(settings, json) {
                var totalRows = suptables.rows().count();
                $('#directinfonumberofItemsLbl').html(totalRows);
            },
        });
    }

    $(document).on('mouseenter', '.info-icon', function () {
        var $icon = $(this);
        // Check if popover is already initialized
        if (!$icon.data('bs.popover')) {
            // Extract row data from attributes
            var price = $icon.data('price');
                        // Create dynamic content
            var priceperkg=parseFloat(price)/17;
                priceperkg=Number(priceperkg.toFixed(2));
            //priceperkg = Math.floor(priceperkg * 10000) / 10000; this is truncate to 4 digits
            var content = `<div>${priceperkg}<br></div>`;
            // Initialize the popover
            $icon.popover({
                html: true,
                content: content,
                trigger: 'hover',
                placement: 'top',
                container: 'body'
            }).popover('show');
        }
    });

    // Clean up popovers on mouseleave
    $(document).on('mouseleave', '.info-icon', function () {
        $(this).popover('dispose');
    });
    function showbuttondependonstat(pe,status,type) {

        switch (status) {
                    case 0:
                        $('#pevulationinfoStatus').html('<span class="text-secondary font-weight-medium"><b> '+pe+' Draft</b>');
                        break;
                        case 1:
                            $('#pevulationinfoStatus').html('<span class="text-warning font-weight-medium"><b> '+pe+' Pending</b>');
                        break;
                        case 2:
                            $('#pevulationinfoStatus').html('<span class="text-primary font-weight-medium"><b> '+pe+' Verified</b>');
                        break;
                        case 7:
                            $('#pevulationinfoStatus').html('<span class="text-primary font-weight-medium"><b> '+pe+' Reviewed</b>');
                        break;
                        case 3:
                            $('#pevulationinfoStatus').html('<span class="text-success font-weight-medium"><b> '+pe+' Approved</b>');
                        break;
                        case 4:
                            $('#pevulationinfoStatus').html('<span class="text-void font-weight-medium"><b> '+pe+' Void</b>');
                        break;
                        break;
                        case 5:
                            $('#pevulationinfoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' Rejected</b>');
                        break;
                        
                        case 6:
                            $('#pevulationinfoStatus').html('<span class="text-warning font-weight-medium"><b> '+pe+' Review</b>');
                        break;
                    default:
                            
                        break;
                }
    }
    function setminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#ulist').empty();
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back To pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
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
                case 'Reviewed':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                        reason='';
                break;
                case 'Created':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;

                case 'Undo Review':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;
                
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
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

    function pevulationsetminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#pevualationulist').empty();
        $.each(actions, function (index, value) { 
            switch (value.status) {
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        switch (value.action) {
                            case 'Back To pending':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
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
                case 'Reviewed':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                        reason='';
                break;
                case 'Created':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                        switch (value.action) {
                            case 'Back To Draft':
                                reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;

                case 'Undo Review':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='';
                break;
                
                case 'Verify':
                    icons='primary timeline-point';
                    addedclass='text-primary';
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
        $('#pevualationulist').append(list);
    }

    function infoviewpaymenthistory(id,supplier) {
            var pono=$('#payrequestinfopo').text()||0;
            var cname=$('#paymentrequestinfsupname').text()||0;
            var tin=$('#paymentrequestinfosupptin').text()||0;
            var customertile=cname+' '+tin;
            paymenthistorydetails(id,pono,customertile,supplier);
        }
        function paymenthistorydetails(id,titleValue,customertile,suplier) {
                $('#paymenthistorystatus').html('Payment History Of '+customertile);
                
                $.ajax({
                    type: "GET",
                    url: "{{ url('getotalpodetiails') }}/"+id,
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
                    success: function (response) {
                        $('#historytotalamount').html(response.totalamount);
                        switch (response.totalamount) {
                            case 0:
                                var titleValue = $('#referenceno option:selected').attr('title');
                                toastrMessage('error','This Purcase Order# '+titleValue+' does not have a previous payment history!','Error!');
                                
                                break;
                        
                            default:
                                showhistorydatatables(id,suplier);
                                break;
                        }
                    }
                });
                
        }

    function showhistorydatatables(id,suplier) {
                $('#historypcontracttables').DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            fixedHeader: true,
                            searchHighlight: true,
                            destroy:true,
                            paging: false,
                            ordering:false,
                            info: false,    
                            lengthMenu: [[50, 100], [50, 100]],
                            "pagingType": "simple",
                            language: { search: '', searchPlaceholder: "Search here"},
                            "dom": "<'row'<'col-lg-5 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-5'>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                            ajax: {
                            url: "{{ url('historypaymentrequestlist') }}/"+id+"/"+suplier,
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
                            $('#modals-slide-inpaymenthistory').modal('show');
                        },
                    },
                    columns: [
                        { data:'DT_RowIndex'},
                        { data: 'docno', name: 'docno' },
                        { data: 'reference', name: 'reference','visible': false},
                        { data: 'paymentreference', name: 'paymentreference','visible': true },
                        { data: 'paymentmode', name: 'paymentmode','visible': true },
                        { data: 'paymentstatus', name: 'paymentstatus' },
                        { data: 'date', name: 'date' },
                        { data: 'status', name: 'status' },
                        {data: 'Amount',name: 'Amount'},
                    ],
                    columnDefs: [   
                            {
                                targets: 3,
                                render: function ( data, type, row, meta ) {
                                    switch (data) {
                                        case 'PO':
                                                return 'Purchase Order';
                                            break;
                                            case 'PI':
                                                return 'Purchase Invoice';
                                            break;
                                        default:
                                                return 'Good Recieving';
                                            break;
                                    }
                                }
                            },
                            {
                                targets: 7,
                                render: function ( data, type, row, meta ) {
                                    switch (data) {
                                        case 0:
                                            return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                            break;
                                        case 1:
                                            return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                                        break;
                                        case 2:
                                            return '<span class="text-primary font-weight-medium"><b>Verify</b></span>';
                                        break;
                                        case 3:
                                            return '<span class="text-success font-weight-medium"><b>Approved</b></span>';
                                        break;
                                        case 4:
                                            return '<span class="text-danger font-weight-danger"><b>Void</b></span>';
                                        break;
                                        case 5:
                                            return '<span class="text-danger font-weight-danger"><b>Rejected</b></span>';
                                        break;
                                        default:
                                            return '--';
                                            break;
                                    }
                                }
                            },
                            {
                                targets: 8,
                                render: function ( data, type, row, meta ) {
                                    switch (row.status) {
                                        case 3:
                                            var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                                            return numberendering(data);
                                            break;
                                        default:
                                            return '';
                                            break;
                                    }
                                
                                }
                            },
                        ],
                            
                    "footerCallback": function (row, data, start, end, display) {
                                var api = this.api();
                                // Helper function to parse integer from strings
                                var intVal = function (i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '')*1 :  // Remove commas and convert to int
                                        typeof i === 'number' ?
                                            i : 0;
                                };
                                    var total = api
                                        .cells( function ( index, data, node ) {
                                            return api.row( index ).data().status === 3 ?
                                                true : false;
                                        }, 8 )
                                        .data()
                                        .reduce( function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0);

                                    var totamount=$('#historytotalamount').text()||0;
                                    totamount= totamount.replace(/,/g, '');
                                    var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                                    total=total.toFixed(2);
                                    var remain=parseFloat(totamount)-parseFloat(total);
                            
                                    $('#historypaidamount').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(total)+"</h6>");
                                    $('#historyremainamount').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(remain)+"</h6>");
                                    
                            },
            });
        }


function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
</script>

@endsection
