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
                @can('PR-View')
                <div class="card card-app-design">
                    <div class="card-body">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-12">
                                    <h4 class="card-title">Purchase Request
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="purchasetablesrefresh()"><i data-feather="refresh-cw"></i></button>
                                        <input type="hidden" name="contingencypertcent" id="contingencypertcent" class="form-control" value="{{ $percent }}" readonly>
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
                                <div class="col-xl-3 col-lg-12">
                                    <label strong style="font-size: 12px;font-weight:bold;">Station</label>
                                    <select data-column="6" class="selectpicker form-control filter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="station ({0})" data-live-search-placeholder="search station" title="Select station" multiple>
                                        @foreach ($stores as $key )
                                            <option  value="{{ $key->Name }}">{{ $key->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-2 col-lg-12">
                                    <b>Budget Review:</b>
                                    <label strong style="font-size: 12px;font-weight:bold;" id="budgetapprovalcount"></label>
                                    <span strong style="font-weight:bold;font-size:12px;text-decoration:underline;color:blue;" onclick="listreviewbudget()">View</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                        <div class="card-datatable">
                                <div style="width:98%; margin-left:1%" class="" id="table-block">
                                <table id="purtables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>PR#</th>
                                            <th>Type</th>
                                            <th>Request Station</th>
                                            <th>Prepare Date</th>
                                            <th>Require Date</th>
                                            <th>Priority</th>
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
                <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Request Information</h5>
                <div class="row">
                    <div style="text-align: right;"></div>
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
                                        <span class="lead collapse-title">Purchase Request Details</span>
                                        <span id="infoStatus" style="font-size:16px;"></span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Puchase Request Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">PR#: </label></td>
                                                                    <td><b><label id="infopr" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Product Type: </label></td>
                                                                    <td><b><label id="infotype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label strong style="font-size: 12px;">Source of Stock: </label></td>
                                                                    <td><b><label id="infosourceofstock" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Request Station: </label></td>
                                                                    <td><b><label id="inforequestation" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label strong style="font-size: 12px;">Request For: </label></td>
                                                                    <td><b><label id="inforequestfor" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Reqiure Date: </label></td>
                                                                    <td><b><label id="inforequiredate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                    <td><b><label id="inforequestdate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label strong style="font-size: 12px;">Currency: </label></td>
                                                                    <td><b><label id="infocurrency" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Priority: </label></td>
                                                                    <td><b><label id="infopriority" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Commodity Information</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                
                                                                <tr class="cmtype">
                                                                    <td><label strong style="font-size: 12px;">Commodity Type: </label></td>
                                                                    <td><b><label id="infocomodiytype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="cmtype">
                                                                    <td><label strong style="font-size: 12px;">Commodity Source: </label></td>
                                                                    <td><b><label id="infocoffesource" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr class="cmtype">
                                                                    <td><label strong style="font-size: 12px;">Commodity status: </label></td>
                                                                    <td><b><label id="infocommoditystatus" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label strong style="font-size: 12px;">Organic Certificate: </label></td>
                                                                    <td><b><label id="infoorganicertificate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr style="display: none;">
                                                                    <td><label strong style="font-size: 12px;">Cropyear: </label></td>
                                                                    <td><b><label id="infocropyyear" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Memo: </label></td>
                                                                    <td><b><label id="infomemo" strong style="font-size: 12px;"></label></b></td>
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
                <div class="divider-text">Commodity Detials</div>
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
                                <th>Est Price</th>
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
                                    <th>Ton</th>
                                    <th>Feresula</th>
                                    <th>Est Price</th>
                                    <th>Total</th>
                                    <th>Remark</th>
                                    <th></th>
                                </thead>
                            <tbody></tbody>
                                <tfoot>
                                    <th colspan="5" style="text-align: right;">Total</th>
                                    <th id="bottomtotalkg"></th>
                                    <th id="bottomtotalton"></th>
                                    <th id="bottomtotalferesula"></th>
                                    <th colspan="3"></th>
                                    <th><a type="button" id="bottomviemiteminfo" onmouseover="bottomviewtotalinformation()"><i class="fa-solid fa-info fa-lg" style="color: #00cfe8;"></i></a></th>
                                </tfoot>
                            
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-xl-9 col-lg-12"></div>
                        <div class="col-xl-3 col-lg-12">
                            <table style="width:100%;" id="infopricingTable" class="rtable mt-1">
                                
                                <tr>
                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                    <td style="text-align: center; width:50%;"><label id="totalprice" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                                <tr id="infotaxtr">
                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 16px;">Tax 15%</label></td>
                                    <td style="text-align: center; width:50%;"><label id="infotaxlbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                    <td style="text-align: center; width:50%;"><label id="totalwithcontingency" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                                
                                
                                <tr class="commuditywitholdtr">
                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 16px;">Withold 2 %</label></td>
                                    <td style="text-align: center; width:50%;"><label id="commuditywitholdvalue" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 16px;">Net Pay </label></td>
                                    <td style="text-align: center; width:50%;"><label id="commuditynetpayvalue" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;width:50%;"><label strong style="font-size: 16px;" id="contingencylabel">Contingency</label><i class="fa-solid fa-circle-info" title="Contingency=(Percentage/100)*Subtotal"></i></td>
                                    <td style="text-align: center; width:50%;"><label id="contigencyvalue" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. Of Commodity</label></td>
                                    <td style="text-align: center;"><label id="nofitems" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                            </table> 
                    </div>
                </div>   
            </div>
            </form>   
            </div>
            <div class="modal-footer">
                <div class="col-xl-12 col-lg-12">
                        <div class="row">
                                    <input type="hidden" placeholder="" class="form-control" name="recordIds" id="recordIds" readonly="true"/>
                                <div class="col-xl-5 col-lg-12">
                                        @can('PR-Edit')
                                            <button type="button" id="preditbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i> Edit</button>
                                        @endcan
                                        @can('PR-Void')
                                            <button type="button" id="prundovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Void</button>
                                            <button type="button" id="prvoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Void</button>
                                        @endcan
                                        @can('PR-Reject')
                                            <button type="button" id="prejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Reject</button>
                                            <button type="button" id="prundorejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Reject</button>
                                        @endcan
                                        <button type="button" id="prprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                </div>        
                                <div class="col-xl-1 col-lg-12">
                                
                                </div> 
                                <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                
                                    @can('PR-Pending')
                                        <button type="button" id="backtodraftbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Back To Draft</button>
                                        <button type="button" id="pendingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Change To Pending</button>
                                        
                                    @endcan
                                    
                                    @can('PR-Approved')
                                        <button type="button" id="backverifybutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Verify</button>
                                        <button type="button" id="approvedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Approve</button>
                                    @endcan
                                    @can('PR-Verify')
                                        <button type="button" id="verifybutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Verify</button>
                                        <button type="button" id="backtopendingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Back To Pending</button>
                                    @endcan
                                    
                                    @can('PR-Review')
                                        <button type="button" id="reviewedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Review</button>
                                        <button type="button" id="undoreviewedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Undo Review</button>
                                    @endcan
                                    
                                    <button id="closebutton" type="button" class="btn btn-outline-danger" onclick="purchasetablesrefresh()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                                </div> 
                            </div>
                </div>
            </div>
        </div>
        </div>
    </div> 
    {{-- end info modal --}}
    <!-- start of purchase modals  -->
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Request</h5>
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
                                            <label strong style="font-size: 14px;">Type <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="type" id="type" data-placeholder="select purchase type">
                                                <option selected disabled  value=""></option>  
                                                <option value="Goods">Goods</option>
                                                <option value="Commodity">Commodity</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="type-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="itemtypediv" style="display: none;">
                                            <label strong style="font-size: 14px;">Item type  <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="itemtype" id="itemtype" data-placeholder="select item type">
                                                <option selected disabled  value=""></option> 
                                                <option value="All">All</option> 
                                                <option value="Goods">Goods</option>
                                                <option value="Consumption">Consumption</option>
                                                <option value="Fixed Asset">Fixed Asset</option>
                                                <option value="Service">Service</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="itemtype-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="commoditytypediv" style="display: none;">
                                            <label strong style="font-size: 14px;">Commodity Type  <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="commoditytype" id="commoditytype" data-placeholder="select Commodity Type">
                                                <option selected disabled  value=""></option>  
                                                <option value="Coffee">Coffee</option>
                                                <option value="Sesame Seeds">Sesame Seeds</option>
                                                <option value="White PeaBeans">White PeaBeans</option>
                                                <option value="Live Animals">Live Animals</option>
                                                <option value="Soya Beans">Soya Beans</option>
                                                <option value="Green Mung">Green Mung</option>
                                                <option value="Red Kidney Bean">Red Kidney Bean</option>
                                                <option value="Pinto Bean">Pinto Bean</option>
                                                <option value="White/Bulla Pea Beans">White/Bulla Pea Beans</option>
                                                <option value="Sprilinked Kidney Beans">Sprilinked Kidney Beans</option>
                                                <option value="Pigeon pea beans">Pigeon pea beans</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="commoditytype-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-lg-12" id="coffeesourcediv">
                                            <label strong style="font-size: 14px;" id="docfslabel">Commodity Source <b style="color:red;">*</b></label>
                                            <select class="select2 form-control sr" name="coffeesource" id="coffeesource" data-placeholder="Commodity Source">
                                                    <option selected disabled  value=""></option>
                                                    <option value="Commercial">Commercial</option>
                                                    <option value="Grower">Grower</option>
                                                    <option value="Vertical">Vertical</option>
                                                    <option value="Union">Union</option>
                                                    <option value="Farmer">Farmer</option>
                                                    <option value="Value-Added">Value Added</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="coffeesource-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-lg-12" id="coffestatusdiv">
                                            <label strong style="font-size: 14px;" id="docfslabel">Commodity Status <b style="color:red;">*</b></label>
                                            <select class="select2 form-control sr" name="coffestatus" id="coffestatus" data-placeholder="Commodity Status">
                                                    <option selected disabled  value=""></option>
                                                    <option value="Green Bean">Green Bean</option>
                                                    <option value="Roast and Grind">Roast and Grind</option>
                                                    <option value="Other">Other</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="coffestatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-2 col-lg-12" id="cropYeardiv" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Crop Year<b style="color:red;">*</b></label>
                                            <select class="select2 form-control sr" name="cropYear" id="cropYear" data-placeholder="Crop Year">
                                                    <option selected disabled  value=""></option>
                                                    @foreach ($cropyear as $key )
                                                        <option  value="{{ $key->CropYear }}">{{ $key->CropYear }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="year-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        
                                        
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display:none;">
                                            <label strong style="font-size: 14px;">Currency <b style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg" name="currency" id="currency" data-placeholder="select currency" >
                                                    <option selected value="ETB">ETB</option>
                                                    <option value="USD">U.S. Dollar (USD)</option>
                                                    <option value="EUR">Euro (EUR)</option>
                                                    <option value="JPY">Japanese Yen (JPY)</option>
                                                    <option value="GBP">British Pound (GBP)</option>
                                                    <option value="CHF">Swiss Franc (CHF)</option>
                                                    <option value="CAD">Canadian Dollar (CAD)</option>
                                                    <option value="AUD/NZD">Australian/New Zealand Dollar (AUD/NZD)</option>
                                                    <option value="ZAR">South African Rand (ZAR)</option>
                                                </select>
                                            <span class="text-danger">
                                                <strong id="currency-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Request station <b style="color:red;">*</b></label>
                                                <select class="select2 form-control form-control-lg sr" name="requestStation" id="requestStation" data-placeholder="Select station" >
                                                    <option selected disabled  value=""></option>  
                                                    @foreach ($stores as $key )
                                                        <option  value="{{ $key->id }}">{{ $key->Name }}</option>
                                                    @endforeach
                                                </select>
                                            <span class="text-danger">
                                                <strong id="requestStation-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;">Department <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="department" id="department" data-placeholder="select department">
                                                <option selected disabled  value=""></option>  
                                                @foreach ($department as $key )
                                                    <option value="{{ $key->id }}">{{ $key->DepartmentName }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="department-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Prepare Date <b style="color:red;">*</b></label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="date" id="date" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="date-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Required Date <b style="color:red;">*</b></label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="requiredate" id="requiredate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="requiredate-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                            <label strong style="font-size: 14px;" id="docfslabel">Priority<b style="color:red;">*</b></label>
                                            <select class="select2 form-control sr" name="priority" id="priority" data-placeholder="Priority">
                                                    <option selected disabled  value=""></option>
                                                    <option value="1">High</option>
                                                    <option value="2">Meduim</option>
                                                    <option value="3">Low</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="priority-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Memo</label>
                                            <div class="input-group input-group-merge">
                                                <textarea  class="form-control" id="memo" placeholder="Write memo here" name="memo" ></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Contigency <b style="color:red;">*</b></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="Contingency" class="form-control" name="contingency" id="contingency" onkeyup="contingencyNumberValidation()" onkeypress="return ValidateOnlyNum(event);" />
                                            </div>
                                            <span class="text-danger">
                                                <strong id="contingency-error" class=".rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-lg-12" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Commodity <b style="color:red;">*</b></label>
                                            <select class="select2 form-control" name="hiddencommudity" id="hiddencommudity" data-placeholder="commudity">
                                                    <option selected disabled  value=""></option>
                                                    @foreach ($woreda as $key)
                                                    <option title="{{$key->id}}" value="{{$key->id}}">{{$key->Rgn_Name}}, {{$key->Zone_Name}}, {{$key->Woreda_Name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-12" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Item <b style="color:red;">*</b></label>
                                            <select class="select2 form-control" name="hiddenitem" id="hiddenitem" data-placeholder="item">
                                                    <option selected disabled  value=""></option>
                                                    @foreach ($item as $key)
                                                    <option title="{{$key->Type}}" value="{{$key->id}}">{{$key->Code}}  ,  {{$key->Name}} ,   {{$key->SKUNumber}} </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="col-xl-2 col-lg-12" style="display:none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Coffee Grade </label>
                                            <select class="select2 form-control" name="coffeegrade" id="coffeegrade" data-placeholder="coffee type">
                                                    <option selected disabled  value=""></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="UG">UG</option>
                                                    <option value="NG">NG</option>
                                                
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-lg-12" style="display:none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Proccess Type</label>
                                            <select class="select2 form-control" name="coffeeproccesstype" id="coffeeproccesstype" data-placeholder="Proccess type">
                                                    <option selected disabled  value=""></option>
                                                    <option value="Anaerobic">Anaerobic</option>
                                                    <option value="Winey">Winey</option>
                                                    <option value="Washed">Washed</option>
                                                    <option value="Unwashed">Unwashed</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-lg-12" style="display:none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Unit Code</label>
                                            <select class="select2 form-control" name="coffeeunitcode" id="coffeeunitcode" data-placeholder="Unit Code">
                                                    <option selected disabled  value=""></option>
                                                    @foreach ($uom as $key)
                                                        <option value="{{ $key->id }}" data-status="{{ $key->uomamount }}">{{ $key->Name }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-lg-12" style="display:none;">
                                            <label strong style="font-size: 14px;">Packaunit</label>
                                            <select class="select2 form-control" name="coffepackagenunit" id="coffepackagenunit" data-placeholder="Package unit">
                                                    <option selected disabled  value=""></option>
                                                        <option value="BG">BG</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-lg-12" style="display:none;">
                                            <label strong style="font-size: 14px;">Packing Content</label>
                                            <select class="select2 form-control" name="coffeepackingcontent" id="coffeepackingcontent" data-placeholder="packing content">
                                                    <option selected disabled  value=""></option>
                                                        <option value="60">60</option>
                                                        <option value="80">80</option>
                                                        <option value="85">85</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Contigency <b style="color:red;">*</b></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="purchaseid" class="form-control" name="purchaseid" id="purchaseid" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">document# <b style="color:red;">*</b></label>
                                            <div class="input-group">
                                                <input type="text" placeholder="purchaseid" class="form-control" name="documentnumber" id="documentnumber" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- start of item Row -->
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div style="width:98%; margin-left:1%;">
                                                <div class="table-responsive scroll scrdiv">
                                                    <table id="dynamicTable" class="table rtable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Estimated Price</th>
                                                            <th>Total Price</th>
                                                            <th>Remark</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <table id="dynamicTablecommdity" class="display rtable mb-0" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Commodity</th>
                                                                <th>Process Type</th>
                                                                <th>Crop Year</th>
                                                                <th>Grade</th>
                                                                <th>KG</th>
                                                                <th>TON</th>
                                                                <th>Feresula</th>
                                                                <th>Estimated Price</th>
                                                                <th>Total Price</th>
                                                                <th>Remark</th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="2" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"><button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button></td>
                                                                <th colspan="3" style="text-align: right;">Total</th>
                                                                <th id="totalkg"></th>
                                                                <th id="totalton"></th>
                                                                <th id="totalferesula"></th>
                                                                <th colspan="3"></th>
                                                                <th><a type="button" id="viemiteminfo" onmouseover="viewtotalinformation()"><i class="fa-solid fa-info fa-lg" style="color: #00cfe8;"></i></a></th>
                                                                <th></th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <table>
                                                        <tr>
                                                            
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of Item Row --><br>
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-12">
                                            
                                        </div>
                                        <div class="col-xl-3 col-lg-12">
                                            <table style="width:100%;" id="pricetable" class="rtable">

                                                <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total:</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="subtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                </tr>
                                                <tr id="taxtr" style="display: none;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                        <td style="text-align: center;"><label id="taxLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                </tr>
                                                <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Grand Total:</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="grandtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                        
                                                </tr>
                                                
                                                <tr class="witholdtr">
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Withold 2%:</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="witholdlbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                        
                                                </tr>
                                                <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Net Pay:</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="netpaylbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                </tr>
                                                <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Contingency:</label><label strong style="font-size: 16px;" id="percentconti"></label><i class="fa-solid fa-circle-info" title="Contingency=(Percentage/100)*Subtotal"></i></td>
                                                        <td style="text-align: center; width:50%;"><label id="amountcontingenyc" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                        
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. Of Commodity</label></td>
                                                    <td style="text-align: center;"><label id="numberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                </tr>
                                                <tr>
                                                        <td colspan="3" style="text-align: center;">
                                                            <div class="demo-inline-spacing">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="directcustomCheck1" />
                                                                    <label class="custom-control-label" for="directcustomCheck1">Taxable</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <input type="hidden" placeholder="" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0" />
                        <input type="hidden" placeholder="" class="form-control" name="taxi" id="taxi" readonly="true" value="0" readonly/>
                        <input type="hidden" placeholder="" class="form-control lg" name="contigencyi" id="contigencyi" readonly="true" value="0" readonly/>
                        <input type="hidden" placeholder="" class="form-control lg" name="totalwithcontigencyi" id="totalwithcontigencyi" value="0" readonly="true"/>
                        <input type="hidden" placeholder="" class="form-control lg" name="netpayi" id="netpayi" readonly="true" value="0" readonly/>
                        <input type="hidden" placeholder="" class="form-control lg" name="witholdi" id="witholdi" readonly="true" value="0" readonly/>
                        <input type="hidden" placeholder="" class="form-control lg" name="numbercounti" id="numbercounti" value='0' readonly/>
                        <input type="hidden" placeholder="" class="form-control lg" name="istaxable" id="istaxable" readonly="true" value="0"/>
                    </form>
                </div>
            <div class="modal-footer">
                @can('PR-Add')
                    <button id="savebutton" type="button" class="btn btn-outline-dark"><i id="savedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                @endcan
            
                <button id="closebutton" type="button"  class="btn btn-outline-danger" onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
        </div>
        </div>
    </div>
<!-- end of purchase modals  -->
<!-- start of void modals  -->
<div class="modal fade text-left" id="prurchasevoidvoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="purchasevoidform" >
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="purchasevoidid" id="purchasevoidid" readonly="true">
                            <input type="hidden" placeholder="" class="form-control" name="voidtype" id="voidtype" readonly="true">
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <textarea  class="form-control" id="voidreason" placeholder="Write Reason here" name="Reason" onkeyup="clearvoiderror();"></textarea>
                                    <span class="text-danger">
                                        <strong id="voidreason-error"></strong>
                                    </span>
                            </div>
                    <div class="modal-footer">
                        <button id="purchasevoidbutton" type="button" class="btn btn-outline-dark"><i class="fa-solid fa-trash"></i> <span>Void</span></button>
                        <button id="closebutton" type="button" class="btn btn-outline-danger" data-dismiss="modal" onclick="clearvoiderror();"><i class="fa-regular fa-xmark"></i> Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end of void modals  -->

    <!-- add waitedsales info modal-->
        <div class="modal modal-slide-in event-sidebar fade" id="approvedmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Review purchase request</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive scroll scrdiv">
                                        <table id="approvedtablelist" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <div class="custom-control custom-control-primary custom-checkbox" id="waitedselectalldiv">
                                                            <input type="checkbox" class="custom-control-input waitedselectall" id="waitedselectall" onclick="waitedselectallcheck()"/>
                                                            <label class="custom-control-label" for="waitedselectall"></label>
                                                        </div>  
                                                    </th>
                                                    <th>#</th>
                                                    <th>PUR#</th>
                                                    <th>Product Type</th>
                                                    <th>Source off stock</th>
                                                    <th>Request Station</th>
                                                    <th>Request For</th>
                                                    <th>Require Date</th>
                                                    <th>Priority</th>
                                                    <th>Currency</th>
                                                    <th>Request Date</th>
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
                                <div class="alert alert-success" role="alert" id="reviewdiv">
                                    <h4 class="alert-heading" id="reviewtitle"> </h4>
                                    <div class="alert-body" id="reviewbody">
                                    
                                    </div>
                                </div>
                            <button id="undoreview" type="button" class="btn btn-info" style="display:none;"> Undo Review</button>
                            <button id="permit" type="button" class="btn btn-info" style="display:none;">Review</button>
                        <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ add waited sales info modal-->
        <!--Start popover div -->
    <div id="myPopoverContent" style="display:none">
        <div class='row'>
            <table style="width: 100%;">
                <tr>
                    <th id="totalkghoverlabel">KG</th>
                    <th id="priceperkglabel">Price per KG</th>
                    <th>Total Price</th>
                </tr>
                <tr>
                    <td id="totalkghover" style="text-align: center;"></td>
                    <td id="priceperkg" style="text-align: center;"></td>
                    <td id="totalpriceofkg" style="text-align: center;"></td>
                </tr>
            </table>
        </div>
    </div>
<!--End popover div-->
@endsection

@section('scripts')
<script type="text/javascript">
    var purtables='';
    var gblIndex=0;
    var i=0;
    var j=0;
    var m=0;
    var errorcolor="#ffcccc";
    function purchasetablesrefresh() {
        var tabletr = $('#purtables').DataTable(); 
        tabletr.search('');
        var oTable = $('#purtables').dataTable(); 
        oTable.fnDraw(false);
        var fyear = $('#fiscalyear').val()||0;
        checkreview(fyear);
    }
    $('#prprintbutton').click(function(){
                var id=$('#recordIds').val();
                var link="/prattachemnt/"+id;
                window.open(link, 'Purchase request', 'width=1200,height=800,scrollbars=yes');
        });
    $('#pendingbutton').click(function(){
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

    // $('#authorizebutton').click(function(){
    //     var id=$('#recordIds').val();
    //     confirmAction(id,3);
    // });
    $('#prundovoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,4);
    });
    // $('#prundorejectbuttoninfo').click(function(){
    //     var id=$('#recordIds').val();
    //     confirmAction(id,5);
    // });
    $('#reviewedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,5);
    });
    $('#undoreviewedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,8);
    });
    
    function confirmAction(id,status) {
        var msg='--';
        var title='--';
        var buttontext='--';
        switch (status) {
            case 0:
                    msg='Are you sure do you want to back to pending this purchase';
                    title='Back';
                    buttontext='Back to pending';
                break;
                case 1:
                    msg='Are you sure do you want to change to pending';
                    title='Confirmation';
                    buttontext='Change To Pending';
                break;
                case 2:
                    msg='Are you sure do you want to change to verify';
                    title='Confirmation';
                    buttontext='Verify';
                break;
                case 3:
                    msg='Are you sure do you want to approved';
                    title='Confirmation';
                    buttontext='Approve';
                break;
                // case 4:
                //     msg='Are you sure do you want to approved this purchase';
                //     title='Approve';
                //     buttontext='Approve';
                // break;
                // case 4:
                //     msg='Are you sure do you want to undo this purchase';
                //     title='Undo';
                //     buttontext='Undo';
                // break;
                // case 5:
                //     msg='Are you sure do you want to undo reject this purchase';
                //     title='Undo Reject';
                //     buttontext='Undo';
                // break;
                case 6:
                    msg='Are you sure do you want to review this purchase';
                    title='Review';
                    buttontext='Review';
                break;
                case 5:
                    msg='Are you sure do you want to undo review this purchase';
                    title='Confirmation';
                    buttontext='Reviewed';
                break;
                case 8:
                    msg='Are you sure do you want to undo-review';
                    title='Confirmation';
                    buttontext='Undo Review';
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
                        url:  "{{url('purchaseaction')}}/" + id+'/'+status,
                        data: {_token: token},
                        success: function (resp) {
                            if (resp.success) {
                                toastrMessage('success',resp.message,'success');
                                showbuttondependonstat(resp.status);
                                setminilog(resp.actions);
                                switch (status) {
                                    case 1:
                                    break;
                                    default:
                                        modalhider();
                                    break;
                                }
                            } else {
                                swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                                var oTable = $('#proformatable').dataTable();
                                oTable.fnDraw(false);
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

    function modalhider() {
        $('#docInfoModal').modal('hide');
        var fyear = $('#fiscalyear').val()||0;
        checkreview(fyear);
        var tabletr = $('#purtables').DataTable(); 
        tabletr.search('');
        var oTable = $('#purtables').dataTable(); 
        oTable.fnDraw(false);
        
    }
    function showbuttondependonstat(status) {
        switch (status) {
            case 0:
                    $('#preditbutton').show();
                    $('#prvoidbuttoninfo').show();
                    $('#pendingbutton').show();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundovoidbuttoninfo').hide();
                    $('#backverifybutton').hide();
                    $('#prejectbuttoninfo').show();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#infoStatus').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">Draft</span>');
                break;
                case 1:
                    $('#prvoidbuttoninfo').show();
                    $('#backtodraftbutton').show();
                    $('#prejectbuttoninfo').show();
                    $('#verifybutton').show();
                    $('#preditbutton').show();
                    $('#approvedbutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#backverifybutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#pendingbutton').hide(); 
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#infoStatus').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">Pending</span>');
                break;
                case 2:
                    $('#prvoidbuttoninfo').show();
                    $('#approvedbutton').show();
                    $('#backverifybutton').hide();
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').show();
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').show();
                    $('#prejectbuttoninfo').show();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#pendingbutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#infoStatus').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df">Verify</span>');
                    
                break;
                case 3:
                    $('#prvoidbuttoninfo').show();
                    $('#approvedbutton').hide();
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').hide();
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prejectbuttoninfo').show();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#prprintbutton').show();
                    $('#backverifybutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#pendingbutton').hide();
                    $('#infoStatus').html('<span style="color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a">Approved</span>');
                break;
                case 4:
                    $('#reviewedbutton').show();
                    $('#preditbutton').show();
                    $('#backverifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();
                    $('#prvoidbuttoninfo').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtopendingbutton').show();
                    $('#prejectbuttoninfo').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#undoreviewedbutton').hide();
                    $('#pendingbutton').hide();
                    $('#backtodraftbutton').hide();
                    $('#prprintbutton').hide();
                    $('#infoStatus').html('<span style="color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b">Review</span>');
                    
                break;
                case 5:
                    $('#prejectbuttoninfo').show();
                    $('#undoreviewedbutton').show();
                    $('#prvoidbuttoninfo').show();
                    $('#approvedbutton').show();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').hide();
                    $('#reviewedbutton').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#backverifybutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#backtodraftbutton').hide();
                    $('#pendingbutton').hide();
                    $('#prprintbutton').hide();
                    $('#infoStatus').html('<span style="color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a">Reviewed</span>');
                    break;
                    case 6:
                        $('#approvedbutton').show();
                        $('#undoreviewedbutton').show();
                        $('#reviewedbutton').hide();
                        $('#prvoidbuttoninfo').show();
                        $('#verifybutton').hide();
                        $('#prundovoidbuttoninfo').hide();   
                        $('#preditbutton').hide();
                        $('#authorizebutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#backverifybutton').show();
                        $('#prejectbuttoninfo').show();
                        $('#prundorejectbuttoninfo').hide();
                        $('#infoStatus').html('<span style="color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b">Void</span>');
                    break;
                    case 7:
                        $('#approvedbutton').hide();
                        $('#prundorejectbuttoninfo').show();
                        $('#prejectbuttoninfo').hide();
                        $('#verifybutton').hide();
                        $('#prundovoidbuttoninfo').hide();   
                        $('#preditbutton').hide();
                        $('#authorizebutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#backverifybutton').hide();
                        $('#prvoidbuttoninfo').hide();
                        $('#infoStatus').html('<span style="color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b">Rejected</span>');
                    break;
                    
            default:
                break;
        }
    }
    $('#purchasevoidbutton').click(function(){
        var form = $("#purchasevoidform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('purchasevoid') }}",
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
                    var oTable = $('#purtables').dataTable();
                    oTable.fnDraw(false);
                    $('#prurchasevoidvoidmodal').modal('hide');
                    $("#docInfoModal").modal('hide');
                }
            }
        });
    });
    $('#backverifybutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Verify');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Back To Verify");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#backtopendingbutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Pending');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Back To Pending");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#backtodraftbutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Draft');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Back To Draft");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#prvoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Void');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Void");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#prejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Reject');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Reject");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    
    function clearvoiderror() {
        $('#voidreason-error').html('');
    }
    $('#preditbutton').click(function(){
        var id=$('#recordIds').val();
        $("#dynamicTable > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        var type='';
        $("#type option[value!=0]").prop('disabled',false);
        $.ajax({
            type: "GET",
            url: "{{ url('predit') }}/"+id,
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
                            $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
                            $("#savedicon").removeClass("fa-duotone fa-pen");
                            $("#savedicon").addClass("fa-duotone fa-pen");
                            $("#savebutton").find('span').text("Update");
                    },
            success: function (response) {
                $.each(response.pr, function (indexInArray, valueOfElement) { 
                    $('#type').select2('destroy');
                    $('#type').val(valueOfElement.type).select2();
                    $('#itemtype').select2('destroy');
                    $('#itemtype').val(valueOfElement.itemtype).select2();
                    $("#type option[value!="+valueOfElement.type+"]").prop("disabled", true);
                    $('#source').select2('destroy');
                    $('#source').val(valueOfElement.source).select2();
                    $('#department').select2('destroy');
                    $('#department').val(valueOfElement.department_id).select2();
                    $('#requestby').select2('destroy');
                    $('#requestby').val(valueOfElement.user_id).select2();
                    flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false});
                    $('#date').val(valueOfElement.date);
                    $('#contingency').val(valueOfElement.contingency);
                    $('#currency').select2('destroy');
                    $('#currency').val(valueOfElement.currency).select2();
                    $('#coffecerificate').select2('destroy');
                    $('#coffecerificate').val(valueOfElement.isorganic).select2();
                    $('#coffestatus').select2('destroy');
                    $('#coffestatus').val(valueOfElement.coffestat).select2();
                    $('#commoditytype').select2('destroy');
                    $('#commoditytype').val(valueOfElement.commudtytype).select2();
                    $('#priority').select2('destroy');
                    $('#priority').val(valueOfElement.priority).select2();
                    $('#requestStation').select2('destroy');
                    $('#requestStation').val(valueOfElement.store_id).select2();
                    $('#cropYear').select2('destroy');
                    $('#cropYear').val(valueOfElement.cropyear).select2();
                    $('#coffeesource').select2('destroy');
                    $('#coffeesource').val(valueOfElement.coffeesource).select2();
                    $('#requiredate').val(valueOfElement.requiredate);
                    $('#purchaseid').val(valueOfElement.id);
                    $('#documentnumber').val(valueOfElement.docnumber);
                    $('#numberofItemsLbl').html(valueOfElement.totalitems);
                    type=valueOfElement.type;
                    switch (valueOfElement.istaxable) {
                        case 1:
                            $('#directcustomCheck1').prop('checked', true);
                            $('#taxtr').show();
                            break;
                        
                        default:
                            $('#directcustomCheck1').prop('checked', false);
                            $('#taxtr').hide();
                            break;
                    }
                });
                switch (type) {
                        case 'Goods':
                            $("#dynamicTable").show();
                            $("#itemtypediv").show();
                            $("#coffeesourcediv").hide();
                            $("#dynamicTablecommdity").hide();
                            $("#commoditytypediv").hide();
                            $("#coffecerificatediv").hide();
                            $("#coffestatusdiv").hide();
                            itemlistappend(response.productlist);
                            break;
                        default:
                            $("#dynamicTablecommdity").show();
                            $("#commoditytypediv").show();
                            $("#coffecerificatediv").show();
                            $("#coffestatusdiv").show();
                            
                            $("#coffeesourcediv").show();
                            $("#itemtypediv").hide();
                            $("#dynamicTable").hide();
                            commoditylistappend(response.productlist);
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
                '<td style="width: 15%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td style="width: 5%;"><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                '<td style="width: 5%;"><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td style="width: 5%;"><select id="coffegrade'+m+'" class="select2 form-control coffegrade" onchange="sourceVal(this)" name="row['+m+'][grade]"></select></td>'+
                '<td><input type="text" name="row['+m+'][totalkg]" placeholder="Total KG" id="totalkg'+m+'"  value='+valueOfElement.totalkg+' class="totalkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][ton]" placeholder="Ton" id="ton'+m+'" value='+valueOfElement.ton+' class="ton form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][feresula]" placeholder="Feresula" id="feresula'+m+'" value='+valueOfElement.feresula+' class="feresula form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="row['+m+'][price]" id="unitprice'+m+'" value='+valueOfElement.price+' class="unitprice form-control" placeholder="Estimated Price" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td><input type="text" name="row['+m+'][totalprice]" id="totalprice'+m+'" value='+valueOfElement.totalprice+' class="totalprice form-control" placeholder="Total Price" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][remark]" id="remark'+m+'" value="'+remark+'" class="total form-control" placeholder="Enter remark Here" style="font-weight:bold;"/>'+
                '<input type="hidden" name="row['+m+'][oumselected]" id="oumselected'+m+'" value='+valueOfElement.uomamount+' class="oumselected form-control"  style="font-weight:bold;" readonly/>'+
                '<input type="hidden" name="row['+m+'][prid]" id="prid'+m+'" value='+valueOfElement.prid+'  class="prid form-control"  style="font-weight:bold;" readonly/>'+
                '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/></td>'+
                '<td style="width:2%;text-align:center;background-color:#efefef;"><a type="button" class="" id="viemiteminfo'+m+'" onmouseover="viewiteminformation(this)"><i class="fa-solid fa-info fa-lg" style="color: #00cfe8;"></i></a></td>'+
                '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>';
            $("#dynamicTablecommdity tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
            var unitcodeeoption=$("#coffeeunitcode > option").clone();
            var coffeepackingcontent=$("#coffeepackingcontent > option").clone();
            var coffepackageoption=$("#coffepackagenunit > option").clone();
            var cropyearoption=$("#cropYear > option").clone();

            var options2 = '<option selected value="'+valueOfElement.id+'">'+valueOfElement.RZW+'</option>';
            var sourceoptions2='<option selected value="'+valueOfElement.source+'">'+valueOfElement.source+'</option>';
            var gradeoption2='<option selected value="'+valueOfElement.grade+'">'+valueOfElement.grade+'</option>';
            var proccesstypeoption2='<option selected value="'+valueOfElement.proccesstype+'">'+valueOfElement.proccesstype+'</option>';
            var unitcodeeoption2='<option selected value="'+valueOfElement.uomid+'">'+valueOfElement.uom+'</option>';

            var coffeepackingcontent2='<option selected value="'+valueOfElement.packagingcontent+'">'+valueOfElement.packagingcontent+'</option>'; 
            var coffepackageoption2='<option selected value="'+valueOfElement.packageunit+'">'+valueOfElement.packageunit+'</option>';
            var cropyearselected='<option selected value="'+valueOfElement.cropyear+'">'+valueOfElement.cropyear+'</option>';

            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+valueOfElement.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();

            $('#coffegrade'+m).append(gradeoption);
            $("#coffegrade"+m+" option[value='"+valueOfElement.grade+"']").remove();
            $('#coffegrade'+m).append(gradeoption2);

            $('#coffeproccesstype'+m).append(proccesstypeoption);
            $("#coffeproccesstype"+m+" option[value='"+valueOfElement.proccesstype+"']").remove();
            $('#coffeproccesstype'+m).append(proccesstypeoption2);

            $('#cropyear'+m).append(cropyearoption);
            $("#cropyear"+m+" option[value='"+valueOfElement.cropyear+"']").remove();
            $('#cropyear'+m).append(cropyearoption);

            $('#coffegrade'+m).select2({placeholder: "Select grade"});
            $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
            
            $('#cropyear'+m).select2({placeholder: "select crop year"});
            
        });
        CalculateGrandTotal();
    }
    function bottomviewtotalinformation() {

        var totalkg=$('#bottomtotalkg').text()||0;
        var totalprice=$('#totalprice').text()||0;
        var tax=$('#infotaxlbl').text()||0;
        totalkg=parseFloat(totalkg.replace(/,/g, ''));
        totalprice=parseFloat(totalprice.replace(/,/g, ''));
        tax=parseFloat(tax.replace(/,/g, ''));
        var subtotal=parseFloat(totalprice)+parseFloat(tax);
        var priceperkg=parseFloat(subtotal)/parseFloat(totalkg);

        $('#totalkghover').html(numformat(totalkg.toFixed(2)));
        $('#priceperkg').html(numformat(priceperkg.toFixed(2)));
        $('#totalpriceofkg').html(numformat(subtotal.toFixed(2)));
        $('#bottomviemiteminfo').popover({
                trigger: "hover",
                title: 'Commodity KG Information',
                width:'1000px',
                container: "body",
                sanitize: false,
                html: true,
                content: function () {
                    return $('#myPopoverContent').html();
                }
            });
    }
    function viewtotalinformationoninfo(totalkg,feresula,priceperferesula) {
        var priceperkg=parseFloat(priceperferesula)/parseFloat(17);
        var total=parseFloat(totalkg)*parseFloat(priceperkg);
        $('#priceperkg').html(numformat(priceperkg.toFixed(2)));
        $('#totalkghover').html(numformat(totalkg.toFixed(2)));
        $('#totalpriceofkg').html(numformat(total.toFixed(2)));
        $('.viemiteminfoofinfo').popover({
                    trigger: "hover",
                    title: 'Commodity KG Information',
                    width:'1000px',
                    container: "body",
                    sanitize: false,
                    html: true,
                    content: function () {
                        return $('#myPopoverContent').html();
                    }
                });
    }
    function viewtotalinformation(){
        var total=$('#subtotali').val()||0;
        var tax=$('#taxLbl').text()||0;
        var kg=$('#totalkg').text();
        kg=parseFloat(kg.replace(/,/g, ''));
        tax=parseFloat(tax.replace(/,/g, ''));
        total=parseFloat(total)+parseFloat(tax);
        var priceperkg=(parseFloat(total)/kg);
        $('#priceperkglabel').html('Total Price/KG');
        $('#totalkghoverlabel').html('Total KG');
        $('#priceperkglabel').html('Price');
        $('#priceperkg').html(numformat(priceperkg.toFixed(2)));
        $('#totalkghover').html(numformat(kg));
        $('#totalpriceofkg').html(numformat(total.toFixed(2)));
        $('#viemiteminfo').popover({
                    trigger: "hover",
                    title: 'Commodity KG Information',
                    width:'1000px',
                    container: "body",
                    sanitize: false,
                    html: true,
                    content: function () {
                        return $('#myPopoverContent').html();
                    }
                });
    }
    function viewiteminformation(ele) {
        var value= $(ele).closest('tr').find('.vals').val()||0;
        var priceperferesula=$(ele).closest('tr').find('.unitprice').val()||0;
        var kg=$(ele).closest('tr').find('.totalkg').val()||0;
        var priceperkg=parseFloat(priceperferesula)/17;
        var totalprice=parseFloat(kg)*parseFloat(priceperkg);
            $('#totalkghoverlabel').html('KG');
            $('#priceperkglabel').html('Price Per KG');
            $('#priceperkg').html(numformat(priceperkg.toFixed(2)));
            $('#totalkghover').html(numformat(kg));
            $('#totalpriceofkg').html(numformat(totalprice.toFixed(2)));
            $('#viemiteminfo'+value).popover({
                    trigger: "hover",
                    title: 'Commodity KG information',
                    width:'1000px',
                    container: "body",
                    sanitize: false,
                    html: true,
                    content: function () {
                        return $('#myPopoverContent').html();
                    }
                });
    }

    function blurFunction(ele) {
        var netweight = $(ele).closest('tr').find('.netweight').val();
        var grossweight = $(ele).closest('tr').find('.grossweight').val();
        if(parseFloat(grossweight)<parseFloat(netweight)){
            $(ele).closest('tr').find('.grossweight').val('');
            toastrMessage('error','Gross weight is not less than netweight','Error!');
        }
    }
    $('body').on('click', '.DocPrInfo', function () {
            var recordId = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "{{ url('prinfo') }}/"+recordId,
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
                $.each(response.pr, function (indexInArray, valueOfElement) { 
                    $('#recordIds').val(valueOfElement.id);
                    $('#infotype').html(valueOfElement.type);
                    $('#infopr').html(valueOfElement.docnumber);
                    $('#infocomodiytype').html(valueOfElement.commudtytype);
                    $('#infocommoditystatus').html(valueOfElement.coffestat);
                    $('#infocropyyear').html(valueOfElement.cropyear);
                    $('#infosource').html(valueOfElement.source);
                    $('#infosourceofstock').html(valueOfElement.source);
                    $('#infocurrency').html(valueOfElement.currency);
                    $('#inforequestdate').html(valueOfElement.date);
                    $('#inforequiredate').html(valueOfElement.requiredate);
                    $('#infomemo').html(valueOfElement.memo);
                    $('#infocontingency').html(valueOfElement.contingency);
                    $('#infonumberofItems').html(valueOfElement.totalitems);
                    $('#infovoidreason').html(valueOfElement.reason);
                    $('#inforequiredate').html(valueOfElement.requiredate);
                    $('#infocoffeestat').html(valueOfElement.coffestat);
                    $('#infocoffesource').html(valueOfElement.coffeesource);

                    $('#totalprice').html(numformat(valueOfElement.totalprice));
                    $('#infotaxlbl').html(numformat(valueOfElement.tax));
                    $('#commuditywitholdvalue').html(numformat(valueOfElement.withold));
                    $('#contigencyvalue').html(numformat(valueOfElement.contingency));
                    $('#totalwithcontingency').html(numformat(valueOfElement.totalewithcontingency));
                    $('#commuditynetpayvalue').html(numformat(valueOfElement.net));
                            switch (valueOfElement.istaxable) {
                                case 1:
                                    $('#infotaxtr').show();
                                    break;
                            
                                default:
                                    $('#infotaxtr').hide();
                                    break;
                            }
                            switch (valueOfElement.priority) {
                                case 1:
                                    $('#infopriority').html("High");
                                    break;
                            case 2:
                                    $('#infopriority').html('Medium');
                            break;
                            case 3:
                                $('#infopriority').html('Low');
                            break;
                                default:
                                    break;
                            }
                            switch (valueOfElement.isorganic) {
                                case 'Y':
                                    $('#infoorganicertificate').html('Yes');
                                    break;
                            
                                default:
                                    $('#infoorganicertificate').html('No');
                                    break;
                            }
                            
                    switch (valueOfElement.type) {
                        case 'Goods':
                            $('#itemsdatablediv').show();
                            $('.cmtype').hide();
                            $('#commuditylistdatablediv').hide();
                            itemslist(valueOfElement.id);
                            break;
                        default:
                            $('#itemsdatablediv').hide();
                            $('#commuditylistdatablediv').show();
                            $('.cmtype').show();
                            commuditylist(valueOfElement.id);
                            break;
                    }
                    showbuttondependonstat(valueOfElement.status);
                });
                $('#inforequestation').html(response.storename);
                $('#inforequestfor').html(response.emploaye);
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
                            case 'Back To Pending':
                            reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                                break;
                            default:
                                reason='';
                                break;
                        }
                break;
                
                case 'Verify':
                    icons='secondary timeline-point';
                    addedclass='text-secondary';
                    switch (value.action) {
                        case 'Back To Verify':
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
                case 'Draft':
                    icons='warning timeline-point';
                    addedclass='text-warning';
                    reason='';
                break;
                
                case 'Reviewed':
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
                {data: 'totalprice',name: 'totalprice'},
                {data: 'remark',name: 'remark'},
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
                sumoprice = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                if(parseFloat(sumoprice)>=10000){
                    var withold=(parseFloat(sumoprice)*2)/100;
                    var netpay=parseFloat(sumoprice)-parseFloat(withold);
                    $('.itemswitholdtr').show();
                } else{
                    var withold=0;
                    var netpay=0;
                    $('.itemswitholdtr').hide();
                }
                var percent=$('#contingencypertcent').val();
                var percentoad=parseFloat(percent/100)+1;
                var totalwithcontinganc=parseFloat(sumoprice)*parseFloat(percentoad);
                var differance=parseFloat(totalwithcontinganc)-parseFloat(sumoprice);
                var numRows = api.rows( ).count();
                var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                $('#contingencylabel').html('Contigency '+percent+'% ');
                $('#totalprice').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(sumoprice)+"</h6>");
                $('#commuditywitholdvalue').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(withold)+"</h6>");
                $('#commuditynetpayvalue').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(netpay)+"</h6>");
                $('#totalwithcontingency').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(totalwithcontinganc)+"</h6>");
                $('#contigencyvalue').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numberendering(differance)+"</h6>");
                $('#nofitems').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numRows+"</h6>");
            },
        });
    }
    function commuditylist(params) {
        $('#comuditydocInfoItem').DataTable({
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
                {data: 'price',name: 'price'},
            ],
                columnDefs: [{
                    targets: 11,
                render: function(data, type, row, meta){
                    
                    return '<a type="button" class="viemiteminfoofinfo" data-totalkg="'+row.totalkg+'" data-feresula="'+row.feresula+'" onmouseover="viewtotalinformationoninfo('+row.totalkg+','+row.feresula+','+row.price+')"><i class="fa-solid fa-info fa-lg" style="color: #00cfe8;"></i></a>';
                }
                }],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api();
                    // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                sumoprice = api
                .column( 9 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                if(parseFloat(sumoprice)>=10000){
                    var withold=(parseFloat(sumoprice)*2)/100;
                    var netpay=parseFloat(sumoprice)-parseFloat(withold);
                    $('.commuditywitholdtr').show();
                } else{
                    var withold=0;
                    var netpay=0;
                    $('.commuditywitholdtr').hide();
                }

                totalgk = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                ton = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                feresula = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
                var numberendering = $.fn.dataTable.render.number( ',', '.', 2, ).display;
                $(api.column(5).footer()).html(numberendering(totalgk));
                $(api.column(6).footer()).html(numberendering(ton));
                $(api.column(7).footer()).html(numberendering(feresula));

                var percent=$('#contingencypertcent').val();
                var percentoad=parseFloat(percent/100)+1;
                var totalwithcontinganc=parseFloat(sumoprice)*parseFloat(percentoad);
                var differance=parseFloat(totalwithcontinganc)-parseFloat(sumoprice);
                var numRows = api.rows( ).count();

                $('#contingencylabel').html('Contigency '+percent+'% ');
                $('#nofitems').html("<h6 style='font-size:13px;color:black;font-weight:bold;'>"+numRows+"</h6>");
            
            },
        });
    }
    $(document).ready(function () {
        var fyear = $('#fiscalyear').val()||0;
        var currentdate=$('#currentdate').val();
        checkreview(fyear);
        purchaselist(fyear);
        flatpickr('#requiredate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
    });
    $('#fiscalyear').on('change', function() {
        var fyear = $('#fiscalyear').val()||0;
        checkreview(fyear);
        purchaselist(fyear);
    });
    $('.filter-select').change(function(){
            var search = [];
            $.each($('.filter-select option:selected'), function(){
                search.push($(this).val());
                });
            search = search.join('|');
            console.log('search='+search);

            purtables.column(6).search(search, true, false).draw(); 
    });
    function checkreview(fyear) {
        $.ajax({
            type: "GET",
            url: "{{ url('checkreview') }}/"+fyear,
            success: function (response) {
                $('#budgetapprovalcount').html(response.reviewsales);
            }
        });
    }
    function listreviewbudget() {
        //$('.waitedselectall').prop('checked', false);
        var fyear = $('#fiscalyear').val()||0;
        $('#approvedtablelist').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searchHighlight: true,
        destroy:true,
        lengthMenu: [[50, 100], [50, 100]],
        "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here"},
            dom: "<'row'<'col-lg-2 col-md-10 col-xs-2'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'p>>",
        ajax: {
        url: '{{ url("reviewlist") }}/'+fyear,
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
            $('#approvedmodal').modal('show');
        },
        },
        columns: [
            { data: 'id', name: 'id',orderable: false },
            { data:'DT_RowIndex'},
            { data: 'docnumber', name: 'docnumber', },
            { data: 'type', name: 'type' },
            { data: 'source', name: 'source' },
            { data: 'date', name: 'date' },
            { data: 'requiredate', name: 'requiredate' },
            { data: 'storename', name: 'storename'},
            { data: 'FullName', name: 'FullName' },
            { data: 'currency', name: 'currency' },
            { data: 'priority', name: 'priority' },
            { data: 'isapproved', name: 'isapproved' },
            
        ],
            columnDefs: [{
                targets: 0,
                render: function(data, type, row, meta){
                    switch (row.isapproved) {
                                    case 1:
                                        var xc='<div class="custom-control custom-control-danger custom-checkbox">'+
                                                '<input type="checkbox" value="'+data+'" name="reviewaitedsalesid[]" class="custom-control-input waitedcheckboxpermitted" id="colorCheck'+row.id+'" onclick="checkallitemswaitedundoreview();"/>'+
                                                '<label class="custom-control-label" for="colorCheck'+row.id+'"></label>'+
                                                '</div>';
                                        return xc;        
                                        break;
                                    default:
                                            var xc='<div class="custom-control custom-control-success custom-checkbox">'+
                                                '<input type="checkbox" value="'+data+'" name="waitedsalesid[]" class="custom-control-input waitedcheckbox" id="check'+row.id+'" onclick="checkallitemswaited();"/>'+
                                                '<label class="custom-control-label" for="check'+row.id+'"></label>'+
                                                '</div>';
                                        return xc; 
                                        
                                        break;
                                }
                }
            },
            {
                targets:2,
                render:function (data,type,row,meta) {
                    var anchor='<a class="enVoice" href="javascript:void(0)" data-link="/prattachemnt/'+row.id+'"  data-id="'+row.id+'" data-original-title="" title="Check purchase" style="text-decoration:underline;"><span>'+data+'</span></a>';
                    return anchor;
                }
            },
            {
                targets:10,
                render:function(data,type,row,meta){
                    switch (data) {
                        case 1:
                            return 'High';
                            break;
                            case 2:
                                return 'Medium';
                                break;
                            case 3: 
                            return 'Low';
                            break;    
                        default:
                            return '---';
                            break;
                    }
                }
            },
            {
                targets:11,
                render:function(data,type,row,meta){
                    switch (data) {
                        case 1:
                            return 'Reviewed';
                            break;
                            
                        default:
                            return '';
                            break;
                    }
                }
            }
            ],
        });
    }
    $('body').on('click', '.enVoice', function () {
        var id = $(this).data('id');
        var link=$(this).data('link');
        window.open(link, 'Sale Report', 'width=1200,height=800,scrollbars=yes');
    });
    function purchaselist(fyear) {
        purtables=$('#purtables').DataTable({
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
        url: "{{ url('purchaslist') }}/"+fyear,
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
            { data: 'docnumber', name: 'docnumber' },
            { data: 'type', name: 'type', },
            { data: 'storename', name: 'storename' },
            { data: 'date', name: 'date', },
            { data: 'requiredate', name: 'requiredate' },
            { data: 'priority', name: 'priority' },
            { data: 'status', name: 'status' },
            { data: 'id', name: 'id',orderable: false },
        ],
        columnDefs: [   
                        {
                            targets: 6,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 1:
                                        return 'High';
                                    break;
                                    case 2:
                                        return 'Meduim';
                                    break;
                                    case 3:
                                        return 'Low';
                                    break;
                                    default:
                                        return '--';
                                        break;
                                }
                            }
                        },
                        {
                            targets: 7,
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
                                    case 4:
                                        return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Review</p>';
                                    break;
                                    case 5:
                                        return '<p style="color:#1cc88a;font-weight:bold;text-shadow:1px 1px 10px #1cc88a;">Reviewed</p>';
                                    break;
                                    case 6:
                                        return '<p style="color:#1cc88a;font-weight:bold;text-shadow:1px 1px 10px #1cc88a;">Void</p>';
                                    break;
                                    case 7:
                                        return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Reject</p>';
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
                                var anchor='<a class="DocPrInfo" href="javascript:void(0)" data-id='+data+' title="View sales"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                                return anchor;
                            }
                        },
                ],
        });
    }
    function setFocus(){ 
        $($('#purtables tbody > tr')[gblIndex]).addClass('selected');  
    }
    $('#purtables tbody').on('click', 'tr', function () {
            $('#purtables tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
    });
    $('#commoditytype').on('change', function () {
        $('#commoditytype-error').html('');
    });
    $('#type').on('change', function () {
        $('#type-error').html('');
        var type=$('#type').val()||0;
        $("#adds").show();
        var nofitem=$('#numberofItemsLbl').text()||0;
        $("#dynamicTable > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        switch (type) {
            case 'Goods':
                $("#dynamicTable").show();
                $("#itemtypediv").show();
                $("#coffeesourcediv").hide();
                $("#dynamicTablecommdity").hide();
                $("#commoditytypediv").hide();
                $("#coffecerificatediv").hide();
                $("#coffestatusdiv").hide();
                
                break;
            default:
                $("#dynamicTable").hide();
                $("#itemtypediv").hide();
                $("#coffeesourcediv").show();
                $("#dynamicTablecommdity").show();
                $("#commoditytypediv").show();
                $("#coffecerificatediv").show();
                $("#coffestatusdiv").show();
                
                break;
        }
        switch (nofitem) {
            case '0':
                
                break;
            default:
                    $("#dynamicTable tbody").empty();
                    $('#pricetable').hide();
                break;
        }
    });
    $('#cropYear').on('change', function () {
        $('#year-error').html('');
    });
    $('#source').on('change', function () {
        $('#source-error').html('');
    });
    $('#department').on('change', function () {
        $('#department-error').html('');
    });
    $('#requestby').on('change', function () {
        $('#requestby-error').html('');
    });
    $('#currency').on('change', function () {
            $('#currency-error').html('');
    });
    $('#date').on('change', function () {
            $('#date-error').html('');
    });
    $('#priority').on('change', function () {
        $('#priority-error').html('');
    });
    $('#requiredate').on('change', function () {
        $('#requiredate-error').html('');
    });
    $('#requestStation').on('change', function () {
        $('#requestStation-error').html('');
    });
    $('#coffeesource').on('change', function () {
        $('#coffeesource-error').html('');
    });
    
    function contingencyNumberValidation() {
        $('#contingency-error').html('');
    }
    function closeinlineFormModalWithClearValidation() {
        $('.rmerror').html('');
    }
    $('body').on('click', '.addbutton', function () {
        setvaluestoempty();
    });
    function setvaluestoempty() {
        var currentdate=$('#currentdate').val();
        $("#purchaseid").val('');
        $('#infoStatus').html('');
        $("#documentnumber").val('');
        $("#exampleModalScrollable").modal('show');
        $("#dynamicTable").hide();
        $("#coffeesourcediv").hide();
        $("#dynamicTablecommdity").hide();
        $("#adds").hide();
        $('.sr').select2('destroy');
        $('.sr').val(null).select2();
        $('.dr').val('');
        $('.dr').val('');
        $("#dynamicTable tbody").empty();
        $('#pricetable').hide();
        $("#savebutton").find('span').text("Save");
        $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
        $("#savedicon").removeClass("fa-duotone fa-pen");
        $("#savedicon").addClass("fa-sharp fa-solid fa-floppy-disk");
        $("#coffecerificatediv").hide();
        $("#coffestatusdiv").hide();
        $("#type option[value!=0]").prop('disabled',false);
        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false,minDate:currentdate});
        $("#date").val(currentdate);
        $("#coffeeunitcode option[data-status='1']").prop("disabled", true);
        $('#totalkg').html('');
        $('#totalton').html('');
        $('#totalferesula').html('');

    }
    $("#adds").on('click', function() {
        ++i;
        ++j;
        ++m;
        var type=$('#type').val();
        var options='';
        var options2='';
        var selectedval='';
        switch (type) {
            case 'Goods':
                    var itemtype=$('#itemtype').val();
                    $("#dynamicTable").show();
                    $("#dynamicTablecommdity").hide();
                    appendtable(j,m);
                    renumberRows();
                    options = $("#hiddenitem > option").clone();
                    options2 = '<option selected disabled value=""></option>';
                    $('#itemNameSl'+m).append(options);
                    switch (itemtype) {
                        case 'All':
                            break;
                        default:
                                $("#itemNameSl"+m+" option[title!='"+itemtype+"']").remove();
                            break;
                    }
                    $('#itemNameSl'+m).append(options2);
                    for(var k=1;k<=m;k++){
                        if(($('#itemNameSl'+k).val())!=undefined){
                            selectedval=$('#itemNameSl'+k).val();
                            $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();   
                        }
                    }
                break;
                case 'Commodity':
                        $("#dynamicTable").hide();
                        $("#dynamicTablecommdity").show();
                        commodityappendtable(j,m);
                        renumberRows();
                        options = $("#hiddencommudity > option").clone();
                        var coffeepackingcontent=$("#coffeepackingcontent > option").clone();
                        var gradeoption=$("#coffeegrade > option").clone();
                        var statusoption=$("#coffestatus > option").clone();
                        var proccesstypeoption=$("#coffeeproccesstype > option").clone();
                        var unitcodeeoption=$("#coffeeunitcode > option").clone();
                        var cropyearoption=$("#cropYear > option").clone();
                        options2 = '<option selected disabled value=""></option>';
                        $('#itemNameSl'+m).append(options);
                        $('#coffegrade'+m).append(gradeoption);
                        $('#coffeproccesstype'+m).append(proccesstypeoption);
                        $('#cropyear'+m).append(cropyearoption);
                break;
            default:
                break;
        }
        $('#itemNameSl'+m).select2({placeholder: "Select product"});
        $('#coffegrade'+m).select2({placeholder: "Select grade"});
        $('#coffestatus'+m).select2({placeholder: "Select status"});
        $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
        $('#cropyear'+m).select2({placeholder: "Select crop year"});
    });
        function appendtable(j,m) {
            $("#dynamicTable tbody").append('<tr id="row'+j+'" class="dynamic-added">'+
                    '<td style="text-align:center;">'+j+'</td>'+
                    '<td style="width: 30%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                    '<td><input type="text" name="row['+m+'][Quantity]" placeholder="Quantity" id="quantity'+m+'" class="quantity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td><input type="text" name="row['+m+'][price]" id="unitprice'+m+'" class="unitprice form-control" placeholder="Estimated Price" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                    '<td><input type="text" name="row['+m+'][totalprice]" id="totalprice'+m+'" class="totalprice form-control" placeholder="Total Price" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][remark]" id="remark'+m+'" class="total form-control" placeholder="Enter remark Here" style="font-weight:bold;"/>'+
                    '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/>'+
                    '<td style="width:6%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '</tr>');
        }
    function commodityappendtable(j,m) {
        $("#dynamicTablecommdity tbody").append('<tr id="row'+j+'" class="dynamic-added">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 15%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="sourceVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td style="width:5%;"><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                '<td style="width:5%;"><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td style="width:5%;"><select id="coffegrade'+m+'" class="select2 form-control coffegrade" onchange="sourceVal(this)" name="row['+m+'][grade]"></select></td>'+
                '<td><input type="text" name="row['+m+'][totalkg]" placeholder="KG" id="totalkg'+m+'" class="totalkg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][ton]" placeholder="TON" id="ton'+m+'" class="ton form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][feresula]" placeholder="Feresula" id="feresula'+m+'" class="feresula form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="row['+m+'][price]" id="unitprice'+m+'" class="unitprice form-control" placeholder="Estimated Price" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" style="font-weight:bold;"/></td>'+
                '<td><input type="text" name="row['+m+'][totalprice]" id="totalprice'+m+'" class="totalprice form-control" placeholder="Total Price" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                '<td><input type="text" name="row['+m+'][remark]" id="remark'+m+'" class="total form-control" placeholder="Enter remark Here" style="font-weight:bold;"/>'+
                '<input type="hidden" name="row['+m+'][oumselected]" id="oumselected'+m+'" class="oumselected form-control"  style="font-weight:bold;" readonly/>'+
                '<input type="hidden" name="row['+m+'][prid]" id="prid'+m+'" class="prid form-control"  style="font-weight:bold;" readonly/>'+
                '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/></td>'+
                '<td style="width:2%;text-align:center;background-color:#efefef;"><a type="button" class="" id="viemiteminfo'+m+'" onmouseover="viewiteminformation(this)"><i class="fa-solid fa-info fa-lg" style="color: #00cfe8;"></i></a></td>'+
                '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>');
    }
    $(document).on('click', '.remove-tr', function(){
            --i;
            --j;
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRows();
    });
    function renumberRows(){
        var ind;
        var type=$('#type').val();
        switch (type) {
            case 'Goods':
                    $('#dynamicTable > tbody > tr').each(function(index, el)
                        {
                            $(this).children('td').first().text(index++);
                            $('#numberofItemsLbl').html(index-1);
                            $('#numbercounti').val(index-1);
                            ind=index-1;
                            j=ind;
                        });
                break;
            default:
                        $('#dynamicTablecommdity > tbody > tr').each(function(index, el){
                            $(this).children('td').first().text(++index);
                            $('#numberofItemsLbl').html(index);
                            $('#numbercounti').val(index);
                            ind=index;
                            j=ind;
                            //console.log('index='+index);
                        });
                break;
        }
        switch (ind) {
            case 0:
                $('#pricetable').hide();
                break;
            default:
                $('#pricetable').show();
                break;
        }
    }
    function itemVal(ele){
        var idval = $(ele).closest('tr').find('.vals').val();
        $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
    }
    function sourceVal(ele){
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        var cropyear=$(ele).closest('tr').find('.cropyear').val();
        var proccestype=$(ele).closest('tr').find('.coffeproccesstype').val();
        var item = $(ele).closest('tr').find('.eName').val();
        var grade=$(ele).closest('tr').find('.coffegrade').val();
        var commuditycnt=0;
        switch (inputid) {
            case 'itemNameSl'+idval:
                for (let k = 1; k <=m; k++) {
                    if(($('#itemNameSl'+k).val())!=undefined){
                        if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)){
                                        commuditycnt+=1;
                                    }
                    }
                    
                }
                if (parseInt(commuditycnt)<=1) {
                    $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
                } else if(parseInt(commuditycnt)>1) {
                    $('#itemNameSl'+idval).select2('destroy');
                    $('#itemNameSl'+idval).val('').select2();
                    $('#itemNameSl'+idval).select2({placeholder: "Select product"});
                    $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
                    toastrMessage('error',"Commodity selected with all property","Error");
                }
                
            break;
            case 'coffeproccesstype'+idval:
                    for (let k = 1; k <=m; k++) {
                        if(($('#itemNameSl'+k).val())!=undefined){
                                if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)){
                                                commuditycnt+=1;
                                            }
                            }
                    }
                    if (parseInt(commuditycnt)<=1) {
                        $('#select2-coffeproccesstype'+idval+'-container').parent().css('background-color',"white");
                } else {
                    $('#coffeproccesstype'+idval).select2('destroy');
                    $('#coffeproccesstype'+idval).val('').select2();
                    $('#coffeproccesstype'+idval).select2({placeholder: "Select proccess type"});
                    $('#select2-coffeproccesstype'+idval+'-container').parent().css('background-color',errorcolor);
                    toastrMessage('error',"Proccess type selected with all property","Error");
                }

            break;
            case 'cropyear'+idval:
                    for(var k=1;k<=m;k++){
                        if(($('#cropyear'+k).val())!=undefined){
                                    if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)){
                                        commuditycnt+=1;
                                    }
                        }
                    }
                    if(parseInt(commuditycnt)<=1){
                                
                                    $('#select2-cropyear'+idval+'-container').parent().css('background-color',"white");
                                }
                            else if(parseInt(commuditycnt)>1){
                                    $('#cropyear'+idval).select2('destroy');
                                    $('#cropyear'+idval).val('').select2();
                                    $('#cropyear'+idval).select2({placeholder: "Select crop year"});
                                    $('#select2-cropyear'+idval+'-container').parent().css('background-color',errorcolor);
                                    
                                    toastrMessage('error',"Crop year selected with all property","Error");
                                }
                
            break;
            
            case 'coffeuom'+idval:
                    item = (item === undefined || item === null || item === '') ? 'EMPTY' : item;
                    proccestype = (proccestype === undefined || proccestype === null || proccestype === '') ? 'EMPTY' : proccestype;
                    cropyear = (cropyear === undefined || cropyear === null || cropyear === '') ? 'EMPTY' : cropyear;
                    grade = (grade === undefined || grade === null || grade === '') ? 'EMPTY' : grade;
                    if(item!='EMPTY' && proccestype!='Empty' && cropyear!='EMPTY' && grade!='EMPTY'){
                        var selectedOption = $('#coffeuom'+idval).find('option:selected');
                        var value=selectedOption.data('status');
                        $('#oumselected'+idval).val(value);
                        
                        var quantity=$(ele).closest('tr').find('.quantity').val()||0;
                        var price=$(ele).closest('tr').find('.unitprice').val()||0;
                        totalkg=(parseFloat(value)*parseFloat(quantity)).toFixed(2);
                        feresula=(parseFloat(totalkg)/parseFloat(17)).toFixed(2);
                        ton=(parseFloat(totalkg)/1000).toFixed(2);
                        totalprice=(parseFloat(totalkg)*parseFloat(price)).toFixed(2);

                        $(ele).closest('tr').find('.totalkg').val(totalkg);
                        $(ele).closest('tr').find('.ton').val(ton);
                        $(ele).closest('tr').find('.feresula').val(feresula);
                        $(ele).closest('tr').find('.totalprice').val(totalprice);
                        CalculateGrandTotal();
                        
                    } else{
                        $('#coffeuom'+idval).select2('destroy');
                        $('#coffeuom'+idval).val('').select2({placeholder:"Select UOM"});
                        
                    }
                    $('#select2-coffeuom'+idval+'-container').parent().css('background-color',"white");
            break;
            default:
                break;
        }
    }
    $('#savebutton').click(function(){
        
        var nofitem=$('#numberofItemsLbl').text()||0;
        switch (nofitem) {
            case '0':
                toastrMessage('error','Please add atleast one product','Erroe');
                break;
            default:
                purchasesave();
                break;
        }
    });
    function purchasesave() {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        var id=$('#purchaseid').val()||0;
        $.ajax({
            type: "POST",
            url: "{{ url('prsave') }}",
            data: formData,
            dataType: 'json',
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
                    toastrMessage('success','Purchase is successfully saved','Save!');
                    $("#exampleModalScrollable").modal('hide');
                    var oTable = $('#purtables').dataTable();
                    oTable.fnDraw(false);
                    switch (id) {
                        case 0:
                            gblIndex=0;
                            break;
                        default:
                            gblIndex= gblIndex;
                            break;
                    }
                }
                else if(response.errors){
                    
                    if(response.errors.type){
                    
                        $('#type-error').html( response.errors.type[0]);
                    }
                    if(response.errors.source){
                        $('#source-error').html( response.errors.source[0]);
                    }
                    if(response.errors.department){
                        $('#department-error').html( response.errors.department[0]);
                    }
                    if(response.errors.date){
                        $('#date-error').html( response.errors.date[0]);
                    }
                    if(response.errors.requestby){
                        $('#requestby-error').html( response.errors.requestby[0]);
                    }
                    if(response.errors.currency){
                        $('#currency-error').html( response.errors.currency[0]);
                    }
                    if(response.errors.Contingency){
                        $('#contingency-error').html( response.errors.Contingency[0]);
                    }
                    if(response.errors.commoditytype){
                        $('#commoditytype-error').html( response.errors.commoditytype[0]);
                    }
                    if(response.errors.cropYear){
                        $('#year-error').html( response.errors.cropYear[0]);
                    }
                    if(response.errors.priority){
                        $('#priority-error').html( response.errors.priority[0]);
                    }
                    if(response.errors.requiredate){
                        $('#requiredate-error').html( response.errors.requiredate[0]);
                    }
                    if(response.errors.requestStation){
                        $('#requestStation-error').html( response.errors.requestStation[0]);
                    }
                    if(response.errors.coffeesource){
                        $('#coffeesource-error').html( response.errors.coffeesource[0]);
                    }
                    if(response.errors.itemtype){
                        $('#itemtype-error').html( response.errors.itemtype[0]);
                    }
                    
                }
                else if(response.errorv2){
                    for(var k=1;k<=m;k++){
                        var itmid=($('#itemNameSl'+k)).val();
                        var coffesource=$('#coffesource'+k).val()||0;
                        var certificate=$('#coffecertificate'+k).val()||0;
                        var grade=$('#coffegrade'+k).val()||0;
                        var status=$('#coffestatus'+k).val()||0;
                        var proccesstype=$('#coffeproccesstype'+k).val()||0;
                        var oum=$('#coffeuom'+k).val()||0;
                        if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                            $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(($('#quantity'+k).val())!=undefined){
                            var quantity=$('#quantity'+k).val();
                            if(isNaN(parseFloat(quantity))||parseFloat(quantity)==0){
                                $('#quantity'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#unitprice'+k).val())!=undefined){
                            var price=$('#unitprice'+k).val();
                            if(isNaN(parseFloat(price))||parseFloat(price)==0){
                                $('#unitprice'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#netweight'+k).val())!=undefined){
                            var netweight=$('#netweight'+k).val();
                            if(isNaN(parseFloat(netweight))||parseFloat(netweight)==0){
                                $('#netweight'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#packageunit'+k).val())!=undefined){
                            var packageunit=$('#packageunit'+k).val();
                            if(isNaN(parseFloat(packageunit))||parseFloat(packageunit)==0){
                                $('#packageunit'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#nofpackage'+k).val())!=undefined){
                            var nofpackage=$('#nofpackage'+k).val()||0;
                            if(isNaN(parseFloat(nofpackage))||parseFloat(nofpackage)==0){
                                $('#nofpackage'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#grossweight'+k).val())!=undefined){
                            var grossweight=$('#grossweight'+k).val();
                            if(isNaN(parseFloat(grossweight))||parseFloat(grossweight)==0){
                                $('#grossweight'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#feresula'+k).val())!=undefined){
                            var feresula=$('#feresula'+k).val();
                            if(isNaN(parseFloat(feresula))||parseFloat(feresula)==0){
                                $('#feresula'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#totalprice'+k).val())!=undefined){
                            var totalprice=$('#totalprice'+k).val();
                            if(isNaN(parseFloat(totalprice))||parseFloat(totalprice)==0){
                                $('#totalprice'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#packingcontent'+k).val())!=undefined){
                            var packingcontent=$('#packingcontent'+k).val();
                            if(isNaN(parseFloat(packingcontent))||parseFloat(packingcontent)==0){
                                $('#packingcontent'+k).css("background", errorcolor);
                            }
                        }
                        if(parseFloat(certificate)==0){
                            $('#select2-coffecertificate'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(grade)==0){
                            $('#select2-coffegrade'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(status)==0){
                            $('#select2-coffestatus'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(proccesstype)==0){
                            $('#select2-coffeproccesstype'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(oum)==0){
                            $('#select2-coffeuom'+k+'-container').parent().css('background-color',errorcolor);
                        }
                    }
                    toastrMessage("error","Please insert a valid data on highlighted fields","Error");
                } else if(response.dberrors){
                    toastrMessage('error',response.dberrors,'System Error!');
                }
                else{
                    toastrMessage('error',response,'Whoops');
                }
            }
        });
    }
    function CalculateTotal(ele) {
        var inputid = ele.getAttribute('id');
        var uniquevalue=$(ele).closest('tr').find('.vals ').val();
        var type=$('#type').val();
        var totalkg=0;
        var feresula=0;
        var ton=0;
        var totalprice=0;
        var price=0;
        switch (inputid) {
            case 'feresula'+uniquevalue:
                feresula=$(ele).closest('tr').find('.feresula').val()||0;
                price=$(ele).closest('tr').find('.unitprice').val()||0;

                totalkg=(parseFloat(feresula)*parseFloat(17)).toFixed(2);
                ton=(parseFloat(totalkg)/1000).toFixed(2);
                totalprice=(parseFloat(feresula)*parseFloat(price)).toFixed(2);

                $('#netweight'+uniquevalue).css("background", "white");
            break;
            case 'unitprice'+uniquevalue:
                switch (type) {
                    case "Goods":
                            var unitprice = $(ele).closest('tr').find('.unitprice').val()||0;
                            var quantity = $(ele).closest('tr').find('.quantity').val()||0;
                            var total = parseFloat(unitprice) * parseFloat(quantity);
                            $(ele).closest('tr').find('.totalprice').val(total.toFixed(2));
                        break;
                    default:
                            feresula=$(ele).closest('tr').find('.feresula').val()||0;
                            price=$(ele).closest('tr').find('.unitprice').val()||0;
                            totalkg=(parseFloat(feresula)*parseFloat(17)).toFixed(2);
                            ton=(parseFloat(totalkg)/1000).toFixed(2);
                            totalprice=(parseFloat(feresula)*parseFloat(price)).toFixed(2);
                            
                        break;
                }
                    $('#unitprice'+uniquevalue).css("background", "white");
            break;
            
            default:
                
                break;
        }

        $(ele).closest('tr').find('.totalkg').val(totalkg);
        $(ele).closest('tr').find('.ton').val(ton);
        
        $(ele).closest('tr').find('.totalprice').val(totalprice);
        CalculateGrandTotal();
    }
    $('#directcustomCheck1').click(function(){
        if ($('#directcustomCheck1').is(':checked')) {
            $('#istaxable').val('1');
            $('#taxtr').show();
        } else{
            $('#istaxable').val('0');
            $('#taxtr').hide();
        }
        CalculateGrandTotal();
    });
    function CalculateGrandTotal() {
        var subtotal = 0;
        var withold=0;
        var netpay=0;
        var totalkg=0;
        var totalton=0;
        var totferesula=0;
        var aftertax=0;
        var tax=0;
        var grandtotal=0;
        var differance=0;
        var totalwithcontingnacy=0;
        var percentoadd=0;
        var type=$('#type').val();
        var percent=$('#contingencypertcent').val();
        switch (type) {
            case 'Goods':
                $("#dynamicTable > tbody tr").each(function(i, val){
                    subtotal += parseFloat($(this).find('td').eq(4).find('input').val()||0);
                });
                break;
            default:
                $("#dynamicTablecommdity > tbody tr").each(function(i, val){
                    subtotal += parseFloat($(this).find('td').eq(9).find('input').val()||0);
                    totalkg += parseFloat($(this).find('td').eq(5).find('input').val()||0);
                    totalton += parseFloat($(this).find('td').eq(6).find('input').val()||0);
                    totferesula += parseFloat($(this).find('td').eq(7).find('input').val()||0);
                });
                break;
        }

            if ($('#directcustomCheck1').is(':checked')) {
                aftertax=parseFloat(subtotal) / (1 + (15 / 100));
                tax=parseFloat(subtotal)-parseFloat(aftertax);
                subtotal=parseFloat(subtotal)-parseFloat(tax);
                $('#taxtr').show();
                $('#grandtotaltr').show();
                } else {
                    $('#taxtr').hide();
                    $('#grandtotaltr').hide();
                }
            percentoadd=parseFloat(percent)/100+1;
            totalwithcontingnacy=parseFloat(subtotal)*parseFloat(percentoadd);
            grandtotal=parseFloat(subtotal)+parseFloat(tax);
            differance=parseFloat(totalwithcontingnacy)-parseFloat(subtotal);
            if(parseFloat(subtotal)>=10000){
                withold=(parseFloat(subtotal)*2)/100;
                $('#witholdlbl').html(numformat(withold.toFixed(2)));
                $('#witholdi').val(withold.toFixed(2));
                $('.witholdtr').show();
            }else{
                $('#witholdlbl').html('0');
                $('.witholdtr').hide();
                $('.witholdi').val('0.00');
                $('#netpayi').val('0.00');
            }
            netpay=parseFloat(grandtotal)-parseFloat(withold);
            // netpay=parseFloat(netpay)+parseFloat(differance);
            $('#percentconti').html(' '+percent+'% ');
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#taxLbl').html(numformat(tax.toFixed(2)));
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxi').val(tax.toFixed(2));
            $('#netpayi').val(netpay.toFixed(2));
            $('#totalwithcontigencyi').val(grandtotal.toFixed(2));
            $('#contigencyi').val(differance.toFixed(2));
            $('#amountcontingenyc').html(numformat(differance.toFixed(2)));
            $('#grandtotalLbl').html(numformat(grandtotal.toFixed(2)));
            $('#netpaylbl').html(numformat(netpay.toFixed(2)));
            $('#totalkg').html(numformat(totalkg.toFixed(2)));
            $('#totalton').html(numformat(totalton.toFixed(2)));
            $('#totalferesula').html(numformat(totferesula.toFixed(2)));
    }
    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
    function checkallitemswaitedundoreview(){
            $('.waitedcheckbox').prop('checked', false); //uncheck review
            $('#undoreview').show();
            $('#permit').hide();
            var masterCheck = $("#waitedselectall");
            var numberOfChecked = $('.waitedcheckboxpermitted').filter(':checked').length ;
            var totalCheckboxes=$("input[name='reviewaitedsalesid[]']").length;
            if((parseFloat(totalCheckboxes)==parseFloat(numberOfChecked))){
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
            } else{
                masterCheck.prop("indeterminate", true);
            }
            assigncheckboxstatus('danger');
            reviewdivassignclass('danger');
        }
        function checkallitemswaited(){
            $('.waitedcheckboxpermitted').prop('checked', false); //uncheck undoreview
            $('#undoreview').hide();
            $('#permit').show();
            var unchecked=0;
            var masterCheck = $("#waitedselectall");
            var numberOfChecked = $('.waitedcheckbox').filter(':checked').length ;
            var totalCheckboxes=$("input[name='waitedsalesid[]']").length;
            if((parseFloat(totalCheckboxes)==parseFloat(numberOfChecked))){
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
            } else{
                masterCheck.prop("indeterminate", true);
            }
            assigncheckboxstatus('success');
            reviewdivassignclass('success');
        }
        function reviewdivassignclass(type){
            var reviewcheck = $('.waitedcheckbox').filter(':checked').length;
            var undoreviewcheck = $('.waitedcheckboxpermitted').filter(':checked').length;
            switch (type) {
                case 'danger':
                    $('#reviewtitle').text('Undo-Review');
                    $('#reviewdiv').removeClass('alert alert-success');
                    $('#reviewdiv').addClass('alert alert-danger');
                    $('#reviewbody').text('You have selected '+undoreviewcheck+' purchase');
                    break;
                default:
                    $('#reviewtitle').text('Review');
                    $('#reviewdiv').removeClass('alert alert-danger');
                    $('#reviewdiv').addClass('alert alert-success');
                    $('#reviewbody').text('You have selected '+reviewcheck+' purchase');
                    break;
            }
            $('#reviewdiv').show();
        }
        function assigncheckboxstatus(status){
            $('#waitedselectalldiv').removeClass('custom-control custom-control-danger custom-checkbox');
            $('#waitedselectalldiv').removeClass('custom-control custom-control-success custom-checkbox');
            $('#waitedselectalldiv').removeClass('custom-control custom-control-primary custom-checkbox');
            $('#waitedselectalldiv').addClass('custom-control custom-control-'+status+' custom-checkbox');
        }
        function checkallitems(subtotal){
            var unchecked=0;
            var masterCheck = $("#selectall");
            var numberOfChecked = $('.recieptcheckbox').filter(':checked').length ;
            var totalCheckboxes=$("input[name='saleid[]']").length;
            $("#collapseExample").collapse('hide');
            $("#witholdwitholdReciept-error").html('');
            $("#witholvatReciept-error").html('');
            $("#witholdwitholdReciept").val('');
            $("#witholvatReciept").val('');
            if((parseFloat(totalCheckboxes)==parseFloat(numberOfChecked))){
                masterCheck.prop("indeterminate", false);
                masterCheck.prop("checked", true);
                
            }
            else{
                masterCheck.prop("indeterminate", true);
            }
        }
        function waitedselectallcheck(){
            var reviewcheck = $('.waitedcheckbox').filter(':checked').length;
            var undoreviewcheck = $('.waitedcheckboxpermitted').filter(':checked').length;
            
            if( $('#waitedselectall').is(':checked') ){
                checkBoxSelection(reviewcheck,undoreviewcheck);
            } 
            else{
                checkBoxUnSelection(reviewcheck,undoreviewcheck);
            }
            
        }
        function checkBoxSelection(reviewcheck,undoreviewcheck){
            if(parseFloat(reviewcheck)==0 && parseFloat(undoreviewcheck)==0){
                toastrMessage('error','Please select at least one checkbok','Error');
                $('.waitedselectall').prop('checked', false); 
            } 
            else if(parseFloat(reviewcheck)>0){
                $('.waitedcheckbox').prop('checked', true);
                assigncheckboxstatus('success');
                reviewdivassignclass('success');
            }
            else if(parseFloat(undoreviewcheck)>0){
                $('.waitedcheckboxpermitted').prop('checked', true);
                assigncheckboxstatus('danger');
                reviewdivassignclass('danger');
            }
        }
        function checkBoxUnSelection(reviewcheck,undoreviewcheck){
            if(parseFloat(undoreviewcheck)>0){
                $('.waitedcheckboxpermitted').prop('checked', false);
            }
            if(parseFloat(reviewcheck)>0){
                $('.waitedcheckbox').prop('checked', false);
            }
            $('#undoreview').hide();
            $('#permit').hide();
            $('#reviewdiv').hide();
        }
        $("#permit").click(function(){
                var numberOfChecked = $('.waitedcheckbox').filter(':checked').length;
                switch (numberOfChecked) {
                    case 0:
                        toastrMessage('error','Please select the sales record','Permit');
                        break;
                    default:
                        var checkid=$('.waitedcheckbox:checked').map(function(){
                            return $(this).val()
                            }).get().join(",");
                            permitconfirmessages(checkid);
                        break;
                }
        });
        $("#undoreview").click(function(){
            var numberOfChecked = $('.waitedcheckboxpermitted').filter(':checked').length;
            switch (numberOfChecked) {
                case 0:
                    toastrMessage('error','Please select the sales record','Undo-review');
                    break;
            
                default:
                    var checkid=$('.waitedcheckboxpermitted:checked').map(function(){
                            return $(this).val()
                            }).get().join(",");
                            reviewconfirmessages(checkid);
                    break;
            }
        });
        function reviewconfirmessages(checkid){
            var undoreviewcheck = $('.waitedcheckboxpermitted').filter(':checked').length;
            swal.fire({
                title: "Notice",
                icon: 'warning',
                html: "Are you sure do you to undo-review  "+undoreviewcheck+" selected purhase",
                type: "warning",
                showCancelButton: !0,
                allowOutsideClick: false,
                cancelButtonText: "Cancel",
                confirmButtonClass: "btn-info",
                cancelButtonClass: "btn-danger",
                confirmButtonText: "Ok",
                }).then(function (e) {
                if (e.value === true) {
                    undoprpermit(checkid);
                } else {
                    e.dismiss;
                    
                }
            }, function (dismiss) {
                return false;
            })
        }
        function permitconfirmessages(checkid){
                var reviewcheck = $('.waitedcheckbox').filter(':checked').length;
                swal.fire({
                    title: "Notice",
                    icon: 'warning',
                    html: "Are you sure do you to review "+reviewcheck +" selected purchase",
                    type: "warning",
                    showCancelButton: !0,
                    allowOutsideClick: false,
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn-info",
                    cancelButtonClass: "btn-danger",
                    confirmButtonText: "Ok",
                    }).then(function (e) {
                    if (e.value === true) {
                        prpermit(checkid);
                    } else {
                        e.dismiss;
                        
                    }
                }, function (dismiss) {
                    return false;
                })
        }
        function undoprpermit(checkid){
            $.ajax({
                type: "GET",
                url: "{{ url('undoprpermit') }}/"+checkid,
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
                    switch (response.success) {
                        case 200:
                            toastrMessage('success','The purchase data is successfully undo reviewed','Undo-review');
                            $('#approvedmodal').modal('hide');
                            $('.waitedselectall').prop('checked', false); 
                            
                            assigncheckboxstatus('primary');
                            purchasetablesrefresh();
                            break;
                        default:
                            toastrMessage('error','There is error please contact the support team','Undo-Review');
                            break;
                    }
                }
            });
        }
        function prpermit(checkid){
            $.ajax({
                type: "GET",
                url: "{{ url('prpermit') }}/"+checkid,
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
                    switch (response.success) {
                        case 200:
                            toastrMessage('success','The purchase data is successfully permitted','Permit');
                            $('#approvedmodal').modal('hide');
                            $('.waitedselectall').prop('checked', false); 
                            assigncheckboxstatus('primary');
                            purchasetablesrefresh();
                            break;
                        default:
                            toastrMessage('error','There is error please contact the support team','Permit');
                            break;
                    }
                }
            });
        }
</script>
@endsection
