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
                @can('PC-View')
                <div class="card card-app-design">
                    <div class="card-body">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-12">
                                    <h4 class="card-title">Purchase Contract
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="purchasetablesrefresh()"><i data-feather="refresh-cw"></i></button>
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
                                    <label strong style="font-size: 12px;font-weight:bold;">Filter by Status</label>
                                    <select data-column="10" class="selectpicker form-control filter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="status ({0})" data-live-search-placeholder="search here" title="Select Status" multiple>
                                            <option value="4">Active</option>
                                            <option value="5">Expired</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card-datatable">
                                <div style="width:98%; margin-left:1%" class="" id="table-block">
                                <table id="pcontracttables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">#</th>
                                            <th rowspan="2">Doc#</th>
                                            <th colspan="2" style="text-align: center;">Type</th>
                                            <th colspan="2" style="text-align: center;">Contract Giver</th>
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">ECTA#</th>
                                            <th rowspan="2">DARA#</th>
                                            <th colspan="2">Contract Term</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr style="text-align: center;">
                                            <th>Product</th>
                                            <th>Contract</th>
                                            <th>Name</th>
                                            <th>TIN</th>
                                            <th>Sign Date</th>
                                            <th>End Date</th>
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
    <div class="modal fade" id="docInfoModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Contract Information</h5>
                <div class="row">
                    <div style="text-align: right;"></div>
                    <span id="supplierinfoStatus" style="font-size:16px;"></span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
            <div class="modal-body scroll scrdiv">
                <form id="upload-form" enctype="multipart/form-data">
                @csrf
                <div class="col-xl-12" id="docinfo-block">
                    <div class="card collapse-icon">
                            <div class="collapse-default" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <span class="lead collapse-title">Purchase Contract Information</span>
                                        
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            {{-- <h6 class="card-title">Puchase Contract Information</h6> --}}
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table-responsive">
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Doc#: </label></td>
                                                                    <td><b><label id="infodoc" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Product Type: </label></td>
                                                                    <td><b><label id="infotype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Contract Type: </label></td>
                                                                    <td><b><label id="infocontype" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Contract Giver: </label></td>
                                                                    <td><b><label id="infocontractgiver" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Prepare Date: </label></td>
                                                                    <td><b><label id="infopreparedate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr id="trinforfq">
                                                                    <td><label strong style="font-size: 12px;">ECTA#: </label></td>
                                                                    <td><b><label id="infoecta" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">DARA#: </label></td>
                                                                    <td><b><label id="infodara" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Sign Date: </label></td>
                                                                    <td><b><label id="infosigndate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">End Date: </label></td>
                                                                    <td><b><label id="infoendate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-7 col-lg-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h6 class="card-title">Attached Contract</h6>
                                                        </div>
                                                        <div class="card-body scroll scrdiv">
                                                            <iframe src="" id="pdfviewer" width="100%" height="500px"></iframe>
                                                        </div>
                                                        
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-xl-3 col-lg-3" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;height:20rem">
                                                    <h5>Actions</h5>
                                                    <div class="scroll scrdiv">
                                                        
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
            <div class="divider divider-info">
                <div class="divider-text">Commodity Details</div>
            </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="table-responsive">
                        <div id="commuditylistdatablediv" class="scroll scrdiv">
                            <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12" id="commoditylistdiv">
                                            <div id="comuditydocInfoItemdiv">
                                                <table id="comuditydocInfoItem" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">#</th>
                                                            <th rowspan="2">Commodity</th>
                                                            <th rowspan="2">Proccess Type</th>
                                                            <th rowspan="2">Grade</th>
                                                            <th colspan="3" style="text-align: center;">UOM</th>
                                                            <th rowspan="2">Addittional Percetnage</th>
                                                            <th rowspan="2">Dispatch Station</th>
                                                            <th rowspan="2">Grade Given Authority</th>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <th>TON</th>
                                                            <th>Kg</th>
                                                            <th>Feresula</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                        <tfoot>
                                                        </tfoot>
                                                </table>
                                            </div>
                                            <div id="directcommuditylistdatabledivinfo" class="scroll scrdiv">
                                                <table id="directcommudityinfodatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">#</th>
                                                            <th colspan="4" style="text-align: center;">Commodity Type</th>
                                                            <th colspan="5" style="text-align: center;">Weight</th>
                                                            <th rowspan="2">Unit Price</th>
                                                            <th rowspan="2">Total</th>
                                                            <th rowspan="2">Supplier Warehouse</th>
                                                        </tr>
                                                        
                                                            <tr style="text-align: center;">
                                                                <th>Commodity</th>
                                                                <th>Crop Year</th>
                                                                <th>Proccess Type</th>
                                                                <th>Grade</th>
                                                                <th>UOM/Bag</th>
                                                                <th>No. of Bag</th>
                                                                <th>KG</th>
                                                                <th>TON</th>
                                                                <th>Feresula</th>
                                                            </tr>
                                                    </thead>
                                                </table>
                                                <div class="row">
                                                    <div class="col-xl-9 col-lg-12"></div>
                                                    <div class="col-xl-3 col-lg-12">
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
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <input type="hidden" placeholder="" class="form-control" name="recordIds" id="recordIds" readonly="true"/>
            <input type="hidden" placeholder="" class="form-control" name="pcontractrecordid" id="pcontractrecordid" readonly="true"/>
            </form>   
            </div>
            <div class="modal-footer">
                    <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                    <div class="col-xl-6 col-lg-12">
                                            <button style="display: none;" type="button" id="poaddorderbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-plus"></i> Add</button>
                                            <button type="button" id="supplierpoverifypoeditbutton" class="btn btn-outline-dark"><i id="iconsupplierpoverifypoeditbutton" class="fa-sharp fa-solid fa-pen"></i> <span></span></button>
                                            @can('PC-Void')
                                                <button type="button" id="supplierpoverifypovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Void</button>
                                                <button type="button" id="supplierpoundovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Void</button>
                                            @endcan
                                            @can('PC-Reject')
                                                <button type="button" id="supplierejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Reject</button>
                                                <button type="button" id="supplierundorejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Reject</button>
                                            @endcan
                                            <button type="button" id="supplierpoprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                            
                                    </div>        
                                    <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                            
                                            <button type="button" id="supplierbacktoverify" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Verify </button>
                                            @can('PC-Pending')
                                                <button type="button" id="supplierbacktodraft" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Draft </button>
                                                <button type="button" id="supplierpoverifypopending" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>change To Pending</button>
                                            @endcan
                                            @can('PC-Verify')
                                                <button type="button" id="supplierbacktopending" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back To Pending </button>
                                                <button type="button" id="supplierpoverify" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Verify</button>
                                            @endcan
                                            @can('PC-Approve')
                                                <button type="button" id="supplierpoverifypoapproved" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Approved</button>
                                            @endcan
                                            <button id="closebutton" type="button" class="btn btn-outline-danger" onclick="purchasetablesrefresh()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
                                    </div>
                                </div>
                    </div>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <form id="Register">
                        {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitleadd">Add Purchase Contract</h5>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body scroll scrdiv">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Type <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="type" id="type" data-placeholder="select purchase type">
                                                <option selected value="Commodity">Commodity</option>
                                                <option value="Goods">Goods</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="type-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Contract Type <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="contractype" id="contractype" data-placeholder="select Contract Type">
                                                <option selected disabled  value=""></option>
                                                <option value="1">One Time </option>
                                                <option value="2">Long Term</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="contractype-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Contract Giver <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="contractseller" id="contractseller" data-placeholder="select seller">
                                                <option selected disabled  value=""></option>  
                                                @foreach ($customer as $key)
                                                    <option value="{{ $key->id }}">{{ $key->Name }}</option>
                                                @endforeach
                                                
                                            </select>
                                            <span class="text-danger">
                                                <strong id="contractseller-error" class="rmerror"></strong>
                                            </span>
                                            <div class="card">
                                                            <div class="card-header" style="display:none;background-color: hsl(47,83%,91%);border: 1px solid hsl(47,65%,84%);height:0.5rem;">
                                                            <h6 class="card-title" style="font-size: 12px;font-weight:bold;">Seller Information</h6>
                                                            </div>
                                                            <div class="card-body scroll scrdiv" id="sellerinformationcard" style="display:none;overflow-y:scroll;height:12rem;background-color: hsl(47,87%,94%);border: 1px solid hsl(47,65%,84%);">
                                                                <table class="table-responsive" style="display: none;">
                                                    <tr>
                                                            <td><label strong style="font-size: 12px;">የንግድ ምዝገባ ቁጥር: </label></td>
                                                            <td>
                                                                <b><label id="cname" strong style="font-size: 12px;" class=""></label></b>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">የንግድ ስራ ፍቅድ ቁጥር: </label></td>
                                                            <td>
                                                                <b><label id="cname" strong style="font-size: 12px;" class=""></label></b>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">ክልል: </label></td>
                                                            <td>
                                                                <b><label id="cname" strong style="font-size: 12px;" class=""></label></b>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">ዞን/ክ/ከተማ: </label></td>
                                                            <td>
                                                                <b><label id="cname" strong style="font-size: 12px;" class=""></label></b>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">ወረደ: </label></td>
                                                            <td>
                                                                <b><label id="cname" strong style="font-size: 12px;" class=""></label></b>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label strong style="font-size: 12px;">ስልክ ቁጥር: </label></td>
                                                            <td>
                                                                <b><label id="cname" strong style="font-size: 12px;" class=""></label></b>
                                                                
                                                            </td>
                                                        </tr>
                                                </table>
                                                            </div>
                                                    
                                                </div>
                                        </div>
                                        
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Prepare Date <b style="color:red;">*</b></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text"  name="date" id="date" class="form-control" placeholder="YYYY-MM-DD"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="date-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="ectadiv">
                                                <label strong style="font-size: 14px;">ECTA# <b style="color:red;">*</b></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text"  name="ecxno" id="ecta" class="form-control" placeholder="ECTA#"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="ecta-error" class="rmerror"></strong>
                                                </span>
                                            </div>  
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="daradiv">
                                                <label strong style="font-size: 14px;">DARA# <b style="color:red;">*</b></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text"  name="ddano" id="dara" class="form-control" placeholder="DARA#"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="dara-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="signdatediv">
                                                <label strong style="font-size: 14px;">Sign Date <b style="color:red;">*</b></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text"  name="signdate" id="signdate" class="form-control" placeholder="YYYY-MM-DD"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="signdate-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="enddatediv">
                                                <label strong style="font-size: 14px;">End Date <b style="color:red;">*</b></label>
                                                <div class="input-group input-group-merge">
                                                    <input type="text"  name="enddate" id="enddate" class="form-control" placeholder="YYYY-MM-DD"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="enddate-error" class="rmerror"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-lg-12">
                                                <label for="basicInputFile">Contract Upload</label>
                                                <input type="file" class="form-control-file" name="pdf" id="pdf" />
                                                <input type="hidden" class="form-control" name="filaname" id="filename" readonly/>
                                                <input type="hidden" class="form-control" name="filepath" id="filepath" readonly/>
                                                <span class="text-danger">
                                                    <strong id="pdf-error" class="rmerror"></strong>
                                                </span>
                                                <button type="button" id="slipdocumentlinkbtn" name="slipdocumentlinkbtn" class="btn btn-flat-info waves-effect slipdocumentlinkbtn" onclick="SlipdocumentDownload()"><span id="slipdocumentlinkbtntext"></span> <i class="fa-sharp fa-solid fa-x removecontract" style="color: #f03000;"></i></button>
                                                
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
                                        <div class="col-xl-3 col-lg-12" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Commodity <b style="color:red;">*</b></label>
                                            <select class="select2 form-control" name="hiddencommudity" id="hiddencommudity" data-placeholder="commudity">
                                                    <option selected disabled  value=""></option>
                                                    @foreach ($woreda as $key)
                                                    <option title="{{$key->Wh_name}}" value="{{$key->id}}">{{$key->Rgn_Name}}, {{$key->Zone_Name}}, {{$key->Woreda_Name}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-3 col-lg-12" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">contract Seller <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="contractsellerhidden" id="contractsellerhidden" data-placeholder="select seller">
                                                <option selected disabled  value=""></option>  
                                                @foreach ($customer as $key)
                                                    <option value="{{ $key->id }}">{{ $key->Name }}</option>
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
                                            <label strong style="font-size: 14px;">UOM<b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg selectclass" name="uom" id="uom" data-placeholder="select uom">
                                                <option value="" selected disabled></option>
                                                @foreach ($uom as $key)
                                                    <option value="{{ $key->id }}" title="{{ $key->uomamount }}">{{ $key->Name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="uom-error" class="rmerror"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-2 col-lg-12" id="cropYeardiv" style="display: none;">
                                            <label strong style="font-size: 14px;" id="docfslabel">Crop Year<b style="color:red;">*</b></label>
                                            <select class="select2 form-control sr" name="cropYear" id="cropYear" data-placeholder="crop year">
                                                    <option selected disabled  value=""></option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="year-error" class="rmerror"></strong>
                                            </span>
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
                                                    <table id="dynamicTablecommdity" class="display rtable mb-0" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">#</th>
                                                                <th rowspan="2">Commodity</th>
                                                                <th rowspan="2">Proccess Type</th>
                                                                <th rowspan="2">Grade</th>
                                                                <th colspan="3">UOM</th>
                                                                <th rowspan="2">Additional Price in Percentage</th>
                                                                <th rowspan="2">Dispatch Station</th>
                                                                <th rowspan="2">Grade Given Authority</th>
                                                                <th rowspan="2"></th>
                                                            </tr>
                                                            <tr style="text-align: center;">
                                                                <th>TON</th>
                                                                <th>KG</th>
                                                                <th>Feresula</th>
                                                                
                                                            </tr>
                                                            
                                                        </thead>
                                                        <tbody></tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="8" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"><button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button></td>
                                                                
                                                            </tr>
                                                        </tfoot>
                                            </table>
                                            <table id="directdynamicTablecommdity" class="display rtable mb-0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">#</th>
                                                                    <th colspan="4">Commodity Type</th>
                                                                    
                                                                    <th rowspan="2">UOM/Bag</th>
                                                                    <th rowspan="2">No of Bag</th>
                                                                    <th colspan="3">Weight</th>
                                                                    <th rowspan="2">Price</th>
                                                                    <th rowspan="2">Total</th>
                                                                    <th rowspan="2">Supplier Warehouse</th>
                                                                    <th rowspan="2"></th>
                                                                </tr>
                                                                <tr style="text-align: center;">
                                                                    <th>Commodity</th>
                                                                    <th>Crop year</th>
                                                                    <th>Proccess Type</th>
                                                                    <th>Grade</th>
                                                                    <th>KG</th>
                                                                    <th>TON</th>
                                                                    <th>Feresula</th>
                                                                </tr>
                                                            
                                                            </thead>
                                                                <tbody>
                                                                </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <td colspan="7" style="text-align:left;background-color: #FFFFFF;border:none;padding:0px;"><button type="button" name="longadds" id="longadds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button></td>
                                                                <th colspan="1" style="text-align: right;">Total</th>
                                                                <th id="totalkg"></th>
                                                                <th id="totalton"></th>
                                                                <th id="totalferesula"></th>
                                                                <th id="totalprice"></th>
                                                                <th colspan="2"></th>
                                                            </tr>
                                                        </tfoot>
                                            </table>
                                        </div>
                                                <div class="col-xl-9 col-lg-12">
                                                    </div>
                                            <div class="col-xl-3 col-lg-12">
                                                <table style="width:100%;" id="directpricetable" class="rtable">
                                                    
                                                    <tr>
                                                        <td style="text-align: right; width:50%;"><label strong style="font-size: 16px;">Sub Total</label></td>
                                                        <td style="text-align: center; width:50%;"><label id="directsubtotalLbl" class="lbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                    </tr>
                                                    <tr id="directtaxtr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Tax(15%)</label></td>
                                                        <td style="text-align: center;"><label id="directtaxLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                        
                                                    </tr>
                                                    <tr id="directgrandtotaltr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total</label></td>
                                                        <td style="text-align: center;"><label id="directgrandtotalLbl" strong style="font-size: 16px; font-weight: bold;" class="lbl"></label></td>
                                                        
                                                    </tr>
                                                    <tr id="directwitholdingTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="directwithodingTitleLbl" strong style="font-size: 16px;">Withold(2%)</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directwitholdingAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr id="directvatTr" style="display: visible;">
                                                        <td style="text-align: right;"><label id="vatTitleLbl" strong style="font-size: 16px;">Vat</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="vatAmntLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr id="directnetpayTr" style="display: visible;">
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="directnetpayLbl" class="formattedNum lbl" strong style="font-size: 16px; font-weight: bold;"></label>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items</label></td>
                                                        <td style="text-align: center;"><label id="directnumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                    
                                                    </tr>
                                                    <tr id="hidewitholdTr">
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
                        <input type="hidden" placeholder="" class="form-control" name="pcontractid" id="pcontractid" readonly="true" value="" />
                        <input type="hidden" placeholder="documentnumber" class="form-control" name="documentnumber" id="documentnumber" readonly/> 
                        <input type="hidden" placeholder="sub total" class="form-control" name="directsubtotali" id="directsubtotali" readonly/>
                        <input type="hidden" placeholder="tax" class="form-control" name="directtaxi" id="directtaxi" readonly/>
                        <input type="hidden" placeholder="grand Total" class="form-control" name="directgrandtotali" id="directgrandtotali" readonly/>
                        <input type="hidden" placeholder="withold" class="form-control" name="directwitholdingAmntin" id="directwitholdingAmntin" readonly/>
                        <input type="hidden" placeholder="Vat" class="form-control" name="directvatAmntin" id="directvatAmntin" readonly/>
                        <input type="hidden" placeholder="net pay" class="form-control" name="directnetpayin" id="directnetpayin" readonly/>
                        <input type="hidden" placeholder="is taxable" class="form-control" name="directistaxable" id="directistaxable" readonly/>
                </div>
            <div class="modal-footer">
                    <button id="savebutton" type="submit" class="btn btn-outline-dark"><i id="savedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                <button id="closebutton" type="button"  class="btn btn-outline-danger" onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
            </form>
        </div>
        </div>
    </div>

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
                            <input type="hidden" placeholder="" class="form-control" name="pcontractsupplierid" id="pcontractsupplierid" readonly="true">
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
@endsection

@section('scripts')

<script type="text/javascript">
    var pctables='';
    var suptables=''; 
    var gblIndex=0;
    var i=0;
    var j=0;
    var m=0;
    var jj=0;
    var mm=0;
    var errorcolor="#ffcccc";

    $("#longadds").on('click', function() {
        ++jj;
        ++mm;
        longtermappendtable(jj,mm);
        longtermrenumberRows();
    });
    $(document).on('click', '.longtermremove-tr', function(){
        $(this).parents('tr').remove();
        directCalculateGrandTotal();
        longtermrenumberRows();
    });
    function longtermrenumberRows() {
        var ind;
        $('#directdynamicTablecommdity > tbody > tr').each(function(index, el){
            $(this).children('td').first().text(++index);
            $('#directnumberofItemsLbl').html(index);
            ind=index;
            jj=ind;
        });
    }
    function longtermappendtable(jj,mm) {
            console.log('this is long add');
            var tables='<tr id="row'+jj+'" class="financialevdynamic-commudity">'+
                '<td style="text-align:center;">'+jj+'</td>'+
                '<td><select id="itemNameSl'+mm+'" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="fevrow['+mm+'][evItemId]"></select></td>'+
                '<td><select id="cropyear'+mm+'" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="fevrow['+mm+'][evcropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+mm+'" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="fevrow['+mm+'][coffeproccesstype]"></select></td>'+
                '<td style="width:6%;"><select id="directgrade'+mm+'" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="fevrow['+mm+'][directgrade]"></select></td>'+
                '<td><select id="uom'+mm+'" class="select2 form-control directuom" onchange="directuomval(this)" name="fevrow['+mm+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+mm+'][qauntity]" placeholder="No of Bag" id="directfevqauntity'+mm+'" class="directfevqauntity form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][quantitykg]" placeholder="KG" id="quantitykg'+mm+'"  class="directquantitykg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][ton]" placeholder="TON" id="directton'+mm+'"  class="directton form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][feresula]" placeholder="feresula" id="feresula'+mm+'" class="directferesula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][finalprice]" placeholder="price" id="directfinalprice'+mm+'" class="directfinalprice form-control"onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);" /></td>'+
                '<td><input type="text" name="fevrow['+mm+'][Total]" placeholder="Total" id="fevtotal'+mm+'" class="directfevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td style="width:6%;"><select id="supplierwarehouse'+mm+'" class="select2 form-control supplierwarehouse" onchange="directsourceVal(this)" name="fevrow['+mm+'][supplierwarehouse]"></select></td>'+
                '<td style="width:3%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm longtermremove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][vals]" id="directvals'+mm+'" class="directvals form-control" readonly="true" style="font-weight:bold;" value="'+mm+'"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][pdetid]" id="pdetid'+mm+'" class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
            '</tr>';
            $("#directdynamicTablecommdity > tbody").append(tables);
                
                var options = $("#hiddencommudity > option").clone();
                var proccesstypeoption=$("#coffeeproccesstype > option").clone();
                var cropyearoption=$("#cropYear > option").clone();
                var uomoption=$("#uom > option").clone();
                var gradeoption=$("#coffeegrade > option").clone();
                var suplieroption=$("#contractsellerhidden > option").clone();
                
                $('#itemNameSl'+mm).append(options);
                $('#coffeproccesstype'+mm).append(proccesstypeoption);
                $('#cropyear'+mm).append(cropyearoption);
                $('#uom'+mm).append(uomoption);
                $('#directgrade'+mm).append(gradeoption);
                $('#supplierwarehouse'+mm).append(suplieroption);
                $('#itemNameSl'+mm).select2({placeholder: "Select products"});
                $('#coffeproccesstype'+mm).select2({placeholder: "Select proccess type"});
                $('#cropyear'+mm).select2({placeholder: "Select crop year"});
                $('#uom'+mm).select2({placeholder: "Select uom"});
                $('#directgrade'+mm).select2({placeholder: "Select grade"});
                $('#supplierwarehouse'+mm).select2({placeholder: "Supllier Warehouse"});
                
    }
    function directCalculateTotal(ele) {
        var reference=$('#reference').val();
        var idval = $(ele).closest('tr').find('.directvals').val();
        var quantity = $(ele).closest('tr').find('.directfevqauntity').val()||0;
        var prcie = $(ele).closest('tr').find('.directfinalprice').val()||0;
        var uom= $(ele).closest('tr').find('.directuom').val()||0;
        var uomount = $('#uom'+idval+' option[value='+uom+']').attr('title');
        
        var totalkg=(parseFloat(quantity)*parseFloat(uomount)).toFixed(2);
        var feresula=(parseFloat(totalkg)/17).toFixed(2);
        var ton=(parseFloat(totalkg)/1000).toFixed(2);
        var total=(parseFloat(prcie)*parseFloat(feresula)).toFixed(2);

        $(ele).closest('tr').find('.directfevtotal').val(total);
        $(ele).closest('tr').find('.directquantitykg ').val(totalkg);
        $(ele).closest('tr').find('.directton').val(ton);
        
        $(ele).closest('tr').find('.directferesula').val(feresula);
        // $('#directfinalprice'+idval).css("background", "white");
        $('#directfevqauntity'+idval).css("background", "white");

        directCalculateGrandTotal();
    }

    
    function directCalculateGrandTotal() {
        var subtotal=0;
        var tax=0;
        var grandTotal=0;
        var vat=0;
        var withold=0;
        var aftertax=0;
        var netpay=0;
        var totalkg=0;
        var totalton=0;
        var totalferesula=0;
        $("#directdynamicTablecommdity > tbody tr").each(function(i, val){
            subtotal += parseFloat($(this).find('td').eq(11).find('input').val()||0);
            totalkg += parseFloat($(this).find('td').eq(7).find('input').val()||0);
            totalton += parseFloat($(this).find('td').eq(8).find('input').val()||0);
            totalferesula += parseFloat($(this).find('td').eq(9).find('input').val()||0);
        });
        

        if ($('#directcustomCheck1').is(':checked')) {
            aftertax=parseFloat(subtotal) / (1 + (15 / 100));
            $('#directtaxtr').show();
            $('#directgrandtotaltr').show();
            tax=parseFloat(subtotal)-parseFloat(aftertax);
            subtotal=parseFloat(subtotal)-parseFloat(tax);
        } else {
            $('#directtaxtr').hide();
            $('#directgrandtotaltr').hide();
        }
        if(parseFloat(subtotal)>=10000){
            withold=(parseFloat(subtotal)*2)/100;
            $('#directwitholdingTr').show();
            $('#directnetpayTr').show();
            $('#directvatTr').hide();
        } 
        else{
            $('#directwitholdingTr').hide();
            $('#directnetpayTr').hide();
            $('#directvatTr').hide();
            
        }
        
        grandTotal=parseFloat(subtotal)+parseFloat(tax);
        netpay=parseFloat(grandTotal)-parseFloat(vat)-parseFloat(withold);
        $('#directsubtotalLbl').html(numformat(subtotal.toFixed(2)));
        $('#directtaxLbl').html(numformat(tax.toFixed(2)));
        $('#directgrandtotalLbl').html(numformat(grandTotal.toFixed(2)));
        $('#directwitholdingAmntLbl').html(numformat(withold.toFixed(2)));
        $('#directvatAmntLbl').html(numformat(vat.toFixed(2)));
        $('#directnetpayLbl').html(numformat(netpay.toFixed(2)));

        $('#totalkg').html(numformat(totalkg.toFixed(2)));
        $('#totalton').html(numformat(totalton.toFixed(2)));
        $('#totalferesula').html(numformat(totalferesula.toFixed(2)));
        $('#directsubtotali').val(subtotal.toFixed(2));
        $('#directtaxi').val(tax.toFixed(2));
        $('#directgrandtotali').val(grandTotal.toFixed(2));
        $('#directwitholdingAmntin').val(withold.toFixed(2));
        $('#directvatAmntin').val(vat.toFixed(2));
        $('#directnetpayin').val(netpay.toFixed(2));

    }
    function directsourceVal(ele) {
            var idval = $(ele).closest('tr').find('.directvals').val();
            var inputid = ele.getAttribute('id');
            var cropyear=$(ele).closest('tr').find('.cropyear').val();
            var proccestype=$(ele).closest('tr').find('.coffeproccesstype').val();
            var item = $(ele).closest('tr').find('.eName').val();
            var commuditycnt=0;
            switch (inputid) {
                    case 'itemNameSl'+idval:
                        for(var k=1;k<=mm;k++){
                            if(($('#itemNameSl'+k).val())!=undefined){
                                if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)){
                                    commuditycnt+=1;
                                }
                            }
                        }
                        if(parseInt(commuditycnt)<=1){
                                $('#select2-itemNameSl'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                            }
                        else if(parseInt(commuditycnt)>1){
                                $('#itemNameSl'+idval).val('').trigger('change').select2
                                ({
                                    placeholder: "Select proccess type",
                                });
                                $('#select2-itemNameSl'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                toastrMessage('error',"Commodity type selected with all property","Error");
                            }
                    break;
                            
                    case 'cropyear'+idval:
                            for(var k=1;k<=mm;k++){
                                if(($('#cropyear'+k).val())!=undefined){
                                    if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)){
                                        commuditycnt+=1;
                                    }
                                }
                            }
                            if(parseInt(commuditycnt)<=1){
                                    $('#select2-cropyear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                                }
                            else if(parseInt(commuditycnt)>1){
                                    $('#cropyear'+idval).val('').trigger('change').select2
                                    ({
                                        placeholder: "Select proccess type",
                                    });
                                    $('#select2-cropyear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                    toastrMessage('error',"Crop year selected with all property","Error");
                                }
                    break;
                    case 'coffeproccesstype'+idval:
                            for(var k=1;k<=mm;k++){
                                if(($('#coffeproccesstype'+k).val())!=undefined){
                                    if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)){
                                        commuditycnt+=1;
                                    }
                                }
                            }
                            if(parseInt(commuditycnt)<=1){
                                    $('#select2-coffeproccesstype'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                                }
                            else if(parseInt(commuditycnt)>1){
                                    $('#coffeproccesstype'+idval).val('').trigger('change').select2
                                    ({
                                        placeholder: "Select proccess type",
                                    });
                                    $('#select2-coffeproccesstype'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                    toastrMessage('error',"Proccess type selected with all property","Error");
                                }
                    break;
                    
                default:
                    break;
            }
    }
    function directuomval(ele) {
        
        var idval = $(ele).closest('tr').find('.directvals').val();
        var quantity = $(ele).closest('tr').find('.directfevqauntity').val()||0;
        var prcie = $(ele).closest('tr').find('.directfinalprice').val()||0; 
        var uom= $(ele).closest('tr').find('.directuom').val()||0; 
        var uomount = $('#uom'+idval+' option[value='+uom+']').attr('title');
        var totalkg=(parseFloat(quantity)*parseFloat(uomount)).toFixed(2);
        var ton=(parseFloat(totalkg)/1000).toFixed(2);
        var feresula=(parseFloat(totalkg)/17).toFixed(2);
        var total=(parseFloat(prcie)*parseFloat(feresula)).toFixed(2);
        
        $(ele).closest('tr').find('.directton').val(ton);
        $(ele).closest('tr').find('.directfevtotal').val(total);
        $(ele).closest('tr').find('.directquantitykg ').val(totalkg);
        $(ele).closest('tr').find('.directferesula').val(feresula);
        $('#select2-uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            directCalculateGrandTotal();
    }
    $('#contractype').on('change', function () {
        var contract=$('#contractype').val();
        console.log('contract='+contract);
        $("#dynamicTablecommdity > tbody").empty();
        $("#directdynamicTablecommdity > tbody").empty();
        switch (contract) {
            case '1':
                $('#signdatediv').show();
                $('#ectadiv').hide();
                $('#daradiv').hide();
                $('#enddatediv').hide();
                
                $('#dynamicTablecommdity').hide();
                $('#directdynamicTablecommdity').show();
                $('#directpricetable').show();
                break;
            
            default:
                $('#ectadiv').show();
                $('#daradiv').show();
                $('#signdatediv').show();
                $('#enddatediv').show();
                $('#dynamicTablecommdity').show();
                $('#directdynamicTablecommdity').hide();
                $('#directpricetable').hide();
                break;
        }
        $('#contractype-error').html('');
    });
    $(document).ready(function () {
        $('#signdate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('#enddate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            $('#date').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            
        contractlist();
    });
    function SlipdocumentDownload(){
        var contractid=$('#pcontractid').val();
        console.log('id='+contractid);
    }
    function purchasetablesrefresh () {
        var oTable = $('#pcontracttables').dataTable();
        oTable.fnDraw(false);
    }
    $('.filter-select').change(function(){
            var search = [];
            $.each($('.filter-select option:selected'), function(){
                search.push($(this).val());
                });
            search = search.join('|');
            pctables.column(10).search(search, true, false).draw(); 
    });
    function additionalFileDownload() {
            $.get("/downloadPrOrder" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../uploads/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }
        
        $('body').on('click', '.removecontract', function () {
            $('#slipdocumentlinkbtn').hide();
            $('.removecontract').hide();
            $('#filename').val('');
            $('#filepath').val('');
        });
        $('body').on('click', '.viewpdf', function () {
                var id = $(this).data('id');
                var path=$(this).data('path');

            $.ajax({
                type: "GET",
                url: "{{url('downloadcontract') }}/" + id,
                xhrFields: {
                        responseType: 'blob' // important for handling binary data
                    },
                success: function (response) {
                    var blobUrl = URL.createObjectURL(response);
                    $('#pdfviewer').attr('src', blobUrl);
                },
                error: function(xhr) {
                        
                        toastrMessage('error','An error occurred while loading the PDF.','Error!');
                    }
            });
        });
    
    $('#Register').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var id=$('#pcontractid').val()||0;
        var contracttype=$('#contractype').val();
            switch (contracttype) {
                case '1':
                    console.log('logic1');
                    var $tbody = $('#directdynamicTablecommdity tbody');

                    break;
            
                default:  
                console.log('logic2');  
                    var $tbody = $('#dynamicTablecommdity tbody');
                    break;
            }
        
        if ($tbody.is(':empty')) {
                toastrMessage('error','Please add commodity','Error!');
            } else {
                pcsave(formData,id);
            }
        
    });

    function pcsave(formData,id) {
        $.ajax({
            type: "POST",
            url: "{{ url('pcsave') }}",
            contentType: false,
            processData: false,
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
                    toastrMessage('success','purchase contract is successfully saved','Save!');
                    $("#exampleModalScrollable").modal('hide');
                    var oTable = $('#pcontracttables').dataTable();
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
                if(response.errors){
                    if(response.errors.contractseller){
                        $('#contractseller-error').html( response.errors.contractseller[0]);
                    }
                    if(response.errors.contractrecipent){
                        $('#contractrecipent-error').html( response.errors.contractrecipent[0]);
                    }
                    if(response.errors.date){
                        $('#date-error').html( response.errors.date[0]);
                    }
                    if(response.errors.ecxno){
                        $('#ecta-error').html( response.errors.ecxno[0]);
                    }
                    if(response.errors.ddano){
                        $('#dara-error').html( response.errors.ddano[0]);
                    }
                    if(response.errors.signdate){
                        $('#signdate-error').html( response.errors.signdate[0]);
                    }
                    if(response.errors.enddate){
                        $('#enddate-error').html( response.errors.enddate[0]);
                    }
                    if(response.errors.pdf){
                        $('#pdf-error').html( response.errors.pdf[0]);
                    }

                }
                else if(response.errorv2){
                    for(var k=1;k<=m;k++){
                        var itmid=($('#itemNameSl'+k)).val();
                        var grade=$('#coffegrade'+k).val()||0;
                        var proccesstype=$('#proccesstype'+k).val()||0;
                        var oum=$('#coffeuom'+k).val()||0;
                        var ton=$('#ton'+k).val()||0;
                        var percentage=$('#totalkg'+k).val()||0;
                        if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                            $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(($('#ton'+k).val())!=undefined){
                            var ton=$('#ton'+k).val();
                            if(isNaN(parseFloat(ton))||parseFloat(ton)==0){
                                $('#ton'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#percentage'+k).val())!=undefined){
                            var nofpackage=$('#percentage'+k).val()||0;
                            if(isNaN(parseFloat(nofpackage))||parseFloat(nofpackage)==0){
                                $('#percentage'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#ectalocation'+k).val())!=undefined){
                            var ectalocation=$('#ectalocation'+k).val()||0;
                            if(isNaN(parseFloat(ectalocation))||parseFloat(ectalocation)==0){
                                $('#ectalocation'+k).css("background", errorcolor);
                            }
                        }

                        if(parseFloat(grade)==0){
                            $('#select2-coffegrade'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(proccesstype)==0){
                            $('#select2-proccesstype'+k+'-container').parent().css('background-color',errorcolor);
                        }
                    }
                    toastrMessage("error","Please insert a valid data on highlighted fields","Error");
                }
            }
        });
        
    }
    
    $('#upload-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "{{ route('ajax.upload.pdf') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // $('#messages').html('<p style="color: green;">' + response.message + '</p>');
                $('#basicInputFile').val('');
                toastrMessage('success',response.message,'Upload');
                viewcontracts(response.id);
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessages = '';
                for (var error in errors) {
                    errorMessages += '<p style="color: red;">' + errors[error][0] + '</p>';
                }
                $('#messages').html(errorMessages);
            }
        });

    });
    function viewcontracts(id) {
        $.ajax({
                type: "GET",
                url: "{{url('downloadcontract') }}/" + id,
                xhrFields: {
                        responseType: 'blob' // important for handling binary data
                    },
                success: function (response) {
                    var blobUrl = URL.createObjectURL(response);
                    $('#pdfviewer').attr('src', blobUrl);
                },
                error: function(xhr) {
                        
                        toastrMessage('error','An error occurred while loading the PDF.','Error!');
                    }
            });
    }
    function clearvoiderror() {
            $('#cancelreason-error').html('');
            $('#voidreason-error').html('');
            $('#suppliervoidreason-error').html('');
        }

        
    $('#supplierpoverifypopending').click(function(){
        var id=$('#recordIds').val();
        supplierconfirmAction(id,1);
    });

    $('#supplierpoverify').click(function(){
        var id=$('#recordIds').val();
        supplierconfirmAction(id,2);
    });

    $('#supplierpoverifypoapproved').click(function(){
        var id=$('#recordIds').val();
        supplierconfirmAction(id,3);
    });

    $('#supplierpoundovoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        supplierconfirmAction(id,4);
    });
    $('#supplierundorejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        supplierconfirmAction(id,7);
    });
    
    function supplierconfirmAction(id,status) {
            var headerid=$('#recordIds').val();
            var msg='--';
            var title='--';
            var buttontext='--';
        switch (status) {
            case 1:
                    msg='Are you sure do you want change to pending';
                    title='Confirmation';
                    buttontext='Pending';
            break;
            case 0:
                    msg='Are you sure do you want to back to pending this purchase evaluation';
                    title='Back';
                    buttontext='Back to pending';
                break;
                case 2:
                    msg='Are you sure do you want to verify';
                    title='Confirmation';
                    buttontext='Verify';
                break;
                case 3:
                    msg='Are you sure do you want Arproved';
                    title='Confirmation';
                    buttontext='Approved';
                break;
                
                case 4:
                    msg='Are you sure do you want to undo void';
                    title='Confirmation';
                    buttontext='Undo Void';
                break;
                
                case 5:
                    msg='Are you sure do you want to undo void';
                    title='Confirmation';
                    buttontext='Undo Void';
                break;

                case 7:
                    msg='Are you sure do you want to undo void reject';
                    title='Confirmation';
                    buttontext='Undo Reject';
                break;
                case 8:
                    msg='Are you sure do you want to back to pending';
                    title='Confirmation';
                    buttontext='Back To Pending';
                break;
                case 9:
                    msg='Are you sure do you want to back to verify';
                    title='Confirmation';
                    buttontext='Back To Verify';
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
                        url:  "{{url('pcsupplieraction')}}/"+headerid+'/'+status,
                        data: {_token: token},
                        success: function (resp) {
                            switch (resp.success) {
                                case 200:
                                    toastrMessage('success',resp.message,'success');
                                    switch (resp.status) {
                                        case 3:
                                            $('#docInfoModal').modal('hide');
                                        break;
                                        case 4:
                                            $('#docInfoModal').modal('hide');
                                        break;
                                        case 5:
                                            $('#docInfoModal').modal('hide');
                                        break;
                                        default:
                                                $('#docInfoModal').modal('show');
                                            break;
                                    }
                                    showbuttondependonsupplierstat(id,resp.docno,resp.status);
                                    suppliersetminilog(resp.actions);
                                    var oTable = $('#pcontracttables').dataTable();
                                        oTable.fnDraw(false);
                                    break;
                                    case 201:
                                        toastrMessage('error',resp.message,'Error');
                                    break;
                                    
                                default:
                                        swal.fire("Whoops!", 'Something went wrong please contact support team.', "error");
                                        // var oTable = $('#proformatable').dataTable();
                                        // oTable.fnDraw(false);
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

    $("#supplierpoverifypoeditbutton").click(function(){
                var headerid=$('#recordIds').val();
                getorderdata(headerid);
        });
        function getorderdata(headerid) {
            var porderid=$('#recordIds').val();
            var currentdate=$('#currentdate').val();
            $("#dynamicTablecommdity > tbody").empty();
            $('#pdf').val('');
            $('#pcontractid').val(porderid);
            var contractype=0;
            console.log('ddd');
            $('#type option[value!=0]').prop('disabled', false);
            $('#contractype option[value!=0]').prop('disabled', false);
            $('#exampleModalScrollableTitleadd').text('Edit Purchase Contract');
            $.ajax({
                type: "GET",
                url: "{{ url('getsuplleritems') }}/"+headerid,
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
                        
                        $('#docInfoModal').modal('hide');
                        $('#exampleModalScrollable').modal('show');
                    },
                success: function (response) {
                    $('#iswhere').val(response.from);
                    if(response.success){
                            $.each(response.pc, function (index, value) { 
                                $('#contractseller').select2('destroy');
                                $('#contractseller').val(value.customer_id).select2();
                                $('#contractype').select2('destroy');
                                $('#contractype').val(value.contractype).select2();
                                $('#type option[value!='+value.type+']').prop('disabled', true);
                                $('#contractype option[value!='+value.contractype+']').prop('disabled', true);
                                $('#ecta').val(value.ecxno);
                                $('#dara').val(value.ddano);
                                // flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate});
                                // flatpickr('#signdate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
                                // flatpickr('#enddate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
                                $('#signdate').val(value.signedate);
                                $('#enddate').val(value.endate);
                                $('#filename').val(value.name);
                                $('#filepath').val(value.path);
                                
                                var filename=value.name;
                                var preparedate=value.date;
                                contractype=value.contractype;
                                preparedate=(preparedate === undefined || preparedate === null || preparedate === '') ? 'EMPTY' : preparedate;
                                filename=(filename === undefined || filename === null || filename === '') ? 'EMPTY' : filename;
                                switch (value.status) {
                                    case 0:
                                            $('#statusdisplay').html('<span class="text-secondary font-weight-medium"><b> PC'+value.docno+' Draft</b></span>');
                                        break;
                                        case 1: 
                                            $('#statusdisplay').html('<span class="text-warning font-weight-medium"><b> PC'+value.docno+' Pending</b></span>');
                                        break;
                                    default:
                                            $('#statusdisplay').html('<span class="text-primary font-weight-medium"><b> PC'+value.docno+' Verified</b></span>');
                                        break;
                                }

                                switch (filename) {
                                    case 'EMPTY':
                                        $('#slipdocumentlinkbtn').hide();
                                        $('.removecontract').hide();
                                        break;
                                    
                                    default:
                                        $('#slipdocumentlinkbtn').show();
                                        $('.removecontract').show();
                                        $("#slipdocumentlinkbtntext").text(filename); 
                                        break;
                                }
                                switch (preparedate) {
                                    case 'EMPTY':
                                        $('#date').val(currentdate);
                                        break;
                                    default:
                                        $('#date').val(value.date);
                                        break;
                                }
                            });
                            switch (contractype) {
                                case 1:
                                    onetimeappend(response.comiditylist);
                                    $('#directpricetable').show();
                                    $('#dynamicTablecommdity').hide();
                                    $('#directdynamicTablecommdity').show();
                                    $('#signdatediv').show();
                                    $('#ectadiv').hide();
                                    $('#daradiv').hide();
                                    $('#enddatediv').hide();
                                    
                                    break;
                            
                                default:
                                    appendcommodity(response.comiditylist);
                                    $('#directpricetable').hide();
                                    $('#dynamicTablecommdity').show();
                                    $('#directdynamicTablecommdity').hide();
                                    $('#ectadiv').show();
                                    $('#daradiv').show();
                                    $('#enddatediv').show();
                                    break;
                            }
                        
                    }
                }
            });
    }

        $("#posuppliersavebutton").click(function(){
            var contracttype=$('#contractype').val();
            switch (contracttype) {
                case '1':
                    console.log('logic1');
                    var $tbody = $('#directdynamicTablecommdity tbody');

                    break;
            
                default:  
                console.log('logic2');  
                    var $tbody = $('#dynamicTablecommdity tbody');
                    break;
            }
            
        if ($tbody.is(':empty')) {
                toastrMessage('error','Please add commodity','Error!');
            } else {
                pcsupliersave();
            }
        });
    function pcsupliersave() {
        var registerForm = $("#posupplieradd");
        var formData = registerForm.serialize();
        $.ajax({
                type: "POST",
                url: "{{ url('pcsavesupplier') }}",
                data: formData,
                dataType: "json",
                success: function (response) {
                    switch (response.success) {
                        case 200:
                                toastrMessage('success','Successfully saved contracts','Save');
                                $('#giveordermodals').modal('hide');
                                gblIndex=0;
                                var oTable = $('#pcontracttables').dataTable();
                                oTable.fnDraw(false);
                            break;
                        
                        default:
                            if(response.errors){
                                if(response.errors.contractseller){
                                    $('#contractseller-error').html( response.errors.contractseller[0]);
                                }
                                if(response.errors.contractrecipent){
                                    $('#contractrecipent-error').html( response.errors.contractrecipent[0]);
                                }
                                if(response.errors.date){
                                    $('#date-error').html( response.errors.date[0]);
                                }
                                if(response.errors.ecta){
                                    $('#ecta-error').html( response.errors.ecta[0]);
                                }
                                if(response.errors.dara){
                                    $('#dara-error').html( response.errors.dara[0]);
                                }
                                if(response.errors.signdate){
                                    $('#signdate-error').html( response.errors.signdate[0]);
                                }
                                if(response.errors.enddate){
                                    $('#enddate-error').html( response.errors.enddate[0]);
                                }
                            }
                            else if(response.errorv2){
                                
                            }
                            break;
                    }
                }
            });
    }
    $('body').on('click', '.DocPrInfo', function () {
            var recordId = $(this).data('id');
            $('#recordIds').val(recordId);
            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
            $("#iconsupplierpoverifypoeditbutton").addClass("fa-duotone fa-pen");
            $("#supplierpoverifypoeditbutton").find('span').text("Edit");
            var path='';
            var ctype=0;
        $.ajax({
            type: "GET",
            url: "{{ url('pcinfo') }}/"+recordId,
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
                if(response.success){
                    if(response.success){
                        $.each(response.pc, function (index, value) { 
                            $('#infodoc').html(value.docno);
                            $('#infopreparedate').html(value.date);
                            $('#infoecta').html(value.ecxno);
                            $('#infodara').html(value.ddano);
                            $('#infosigndate').html(value.signedate);
                            $('#infoendate').html(value.endate);
                            $('#infotype').html(value.type);
                            $('#infocontractgiver').html(value.customername);
                            $('#directinfosubtotalLbl').html(numformat(value.subtotal));
                            $('#directinfotaxLbl').html(numformat(value.tax));
                            $('#directinfograndtotalLbl').html(numformat(value.grandtotal));
                            $('#directinfowitholdingAmntLbl').html(numformat(value.withold));
                            $('#directinfovatAmntLbl').html(value.withold);
                            $('#directinfonetpayLbl').html(numformat(value.netpay));
                            path=value.path;
                            ctype=value.contractype;
                            switch (ctype) {
                                case 1:
                                    $('#infocontype').html('One Time');
                                    break;
                                
                                default:
                                    $('#infocontype').html('Long Term');
                                    break;
                            }
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
                            showbuttondependonsupplierstat(recordId,value.docno,value.status);
                        });
                        infocommodotylist(recordId,ctype);
                        suppliersetminilog(response.actions);
                        path = (path === undefined || path === null || path === '') ? 'EMPTY' : path;
                        switch (path) {
                            case 'EMPTY':
                                var iframe = $('#pdfviewer')[0];
                                var doc = iframe.contentDocument || iframe.contentWindow.document;
                                doc.open();
                                // Write a simple HTML structure with the text
                                var text="No Contract Attached";
                                doc.write('<html><body><h1>' + text + '</h1></body></html>');
                                // Close the document to apply changes
                                doc.close();
                                break;
                            default:
                                viewcontracts(recordId);
                                break;
                        }
                    
                    }
                    else{
                        
                    }
                }
            }
        });
    });
    function registerenwcontract(){
        $('#pcontractrecordid').val('-1');
        $('#carddatacanvas').empty();
        $('#pcsupplierid').val('');
        var oTable = $('#comuditydocInfoItem').dataTable(); 
        oTable.fnDraw(false);
        $('#pdfviewer').attr('src', '');
        $('.ssupd').html('');
        $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
        $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
        $("#iconsupplierpoverifypoeditbutton").addClass("fa-sharp fa-solid fa-plus");
        $("#supplierpoverifypoeditbutton").find('span').text("Add");
        $('#supplierpoverifypoeditbutton').show();
        $('#supplierpoverifypopending').hide();
        $('#supplierpoverifypovoidbuttoninfo').hide();
        $('#supplierpoverify').hide();
        $('#supplierbacktopending').hide();
        $('#supplierbacktoverify').hide();
        $('#supplierpoverifypoapproved').hide();
        $('#supplierpoundovoidbuttoninfo').hide();
        $('#supplierpoprintbutton').hide();
        $('#supplierbacktodraft').hide();
        $('#supplierinfoStatus').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">New</span>');
    }
    function setsupplierbytab(supplier) {
        var carddata='';
        var backcolor="";
        var forecolor="";
        var status='---';
        var jj=0;
        var stitles='';
        var firstsupplierid=0;
        $.each(supplier, function (index, value) { 
            ++jj;
            switch (index) {
                case 0:
                    fetchorders(value.id);
                    firstsupplierid=value.id;
                    
                    break;
                
                default:
                    break;
            }
            stitles=value.ecxno+" "+value.ddano+" ";
            switch (value.status) {
                case 0:
                        status='Draft';
                        backcolor="#fff1e3 !important";
                        forecolor="#ff9f43 !important";
                        
                    break;
                    case 1:
                        status='Pending';
                        backcolor="#eae8fd !important";
                        forecolor="#7367f0 !important";
                    break;
                    case 2:
                        status='Verify';
                        backcolor="#eae8fd !important";
                        forecolor="#7367f0 !important";
                    break;
                    case 3:
                        status='Approved';
                        backcolor="#dff7e9 !important";
                        forecolor="#28c76f !important";
                    break;
                    case 4:
                        status='Void';
                        backcolor="#fff1e3 !important";
                        forecolor="#ff9f43 !important";
                    break;
                    case 5:
                        status='Reject';
                        backcolor="#fff1e3 !important";
                        forecolor="#ff9f43 !important";
                    break;
                default:
                    status='--';
                    backcolor="#fff1e3 !important";
                    forecolor="#ff9f43 !important";
                    break;
            }
            carddata+="<div id='commcard"+value.id+"' class='card supcard commcardcls"+value.id+"' data-title='"+stitles+"' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchorders("+value.id+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span>status#:<b>"+value.isexpired+"</b></span><div id='targetspandiv"+value.id+"'><span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+status+"</b></span></div></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-6 col-md-6 col-lg-6 p-0'>DARA#:<b>"+value.ddano+"</b></div><div class='col-xl-6 col-md-6 col-lg-6 p-0'>ECT#:<b>"+value.ecxno+"</b></div></div></div></div>";
        });
        $('#carddatacanvas').empty();
        $('#carddatacanvas').html(carddata);
        $('.commcardcls'+firstsupplierid).addClass('supplierselected');
    }
    function fetchorders(id) {
        var headerid=$('#recordIds').val();
        $('#pcsupplierid').val(id);
        $('#pcontractrecordid').val(id);
        $('.supcard').removeClass('supplierselected');
        $('.commcardcls'+id).addClass('supplierselected');
        $.ajax({
            type: "GET",
            url: "{{ url('infogetsupllers') }}/"+headerid+"/"+id,
            dataType: "json",
            success: function (response) {
                $.each(response.supplinfo, function (index, value) { 
                    $('#infodocumentno').html('PC'+value.docno);
                    $('#infopreparedate').html(value.date);
                    $('#infoectno').html(value.ecxno);
                    $('#infodarano').html(value.ddano);
                    $('#infosignedate').html(value.signedate);
                    $('#infoendate').html(value.endate);
                    $('#infostatus').html(value.isexpired);
                    var anchor='<a class="viewpdf" href="javascript:void(0)" data-id='+value.id+' data-name='+value.name+'  data-path='+value.path+' title="View PDF">'+value.name+'</a>';
                    $('#infofile').html(anchor);
                });
                switch (response.headerexist) {
                        case true:
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-duotone fa-pen");
                            $("#supplierpoverifypoeditbutton").find('span').text("Edit");
                            break;
                        default:
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-sharp fa-solid fa-plus");
                            $("#iconsupplierpoverifypoeditbutton").removeClass("fa-duotone fa-pen");
                            $("#iconsupplierpoverifypoeditbutton").addClass("fa-sharp fa-solid fa-plus");
                            $("#supplierpoverifypoeditbutton").find('span').text("Add");
                            break;
                    }
                    suppliersetminilog(response.actions);
                    $.each(response.supplinfo, function (index, value) { 
                        showbuttondependonsupplierstat(id,value.status);
                    });
                
            }
        });

        $.ajax({
                type: "GET",
                url: "{{url('downloadcontract') }}/" + id,
                xhrFields: {
                        responseType: 'blob' // important for handling binary data
                    },
                success: function (response) {
                    switch (response.success) {
                        case 201:
                            $('#pdfviewer').attr('src', '');
                            break;

                        default:
                            var blobUrl = URL.createObjectURL(response);
                            $('#pdfviewer').attr('src', blobUrl);
                            break;
                    }
                    
                },
                error: function(xhr) {
                    
                        toastrMessage('error','An error occurred while loading the PDF.','Error!');
                        $('#pdfviewer').attr('src', '');
                    }
            });
        
    }
    $('#supplierbacktodraft').click(function(){
        var id=$('#recordIds').val();
        var suplierid=$('#pcontractrecordid').val();
        $('#purchasevoidid').val(id);
        $('#pcontractsupplierid').val(suplierid);
        $('#voidtype').val('Draft');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Back To Draft");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#supplierbacktopending').click(function(){
        var id=$('#recordIds').val();
        var suplierid=$('#pcontractrecordid').val();
        $('#purchasevoidid').val(id);
        $('#pcontractsupplierid').val(suplierid);
        $('#voidtype').val('Pending');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Back To Pending");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#supplierpoverifypovoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        var suplierid=$('#pcontractrecordid').val();
        $('#purchasevoidid').val(id);
        $('#pcontractsupplierid').val(suplierid);
        $('#voidtype').val('Void');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Void");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#supplierejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        var suplierid=$('#pcontractrecordid').val();
        $('#purchasevoidid').val(id);
        $('#pcontractsupplierid').val(suplierid);
        $('#voidtype').val('Reject');
        $("#voidreason").val("")
        $("#purchasevoidbutton").find('span').text("Rejct");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#purchasevoidbutton').click(function(){
        var form = $("#purchasevoidform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('pcvoid') }}",
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
                    var oTable = $('#pcontracttables').dataTable();
                    oTable.fnDraw(false);
                    $('#prurchasevoidvoidmodal').modal('hide');
                    $("#docInfoModal").modal('hide');
                }
            }
        });
    });

    function showbuttondependonsupplierstat(id,docno,status) {
        var stringstatus='';
        var backcolor='';
        var forecolor='';
        var span='';
        $('#targetspandiv'+id).html('');
        switch (status) {
            case 0:
                stringstatus='Draft';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypopending').show();
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierejectbuttoninfo').show();
                $('#supplierundorejectbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierinfoStatus').html('<span class="text-secondary font-weight-medium"><b> PC'+docno+' Draft</b>');
            break;
            case 1:
                stringstatus='Pending';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierpoverify').show();
                $('#supplierbacktodraft').show();
                $('#supplierejectbuttoninfo').show();
                $('#supplierundorejectbuttoninfo').hide();
                $('#supplierbacktopending').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierinfoStatus').html('<span class="text-warning font-weight-medium"><b> PC'+docno+' Pending</b>');
            break;
            case 2:
                stringstatus='Verify';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierbacktopending').show();
                $('#supplierpoverifypoeditbutton').show();
                $('#supplierpoverifypoapproved').show();
                $('#supplierejectbuttoninfo').show();
                $('#supplierundorejectbuttoninfo').hide(); 
                $('#supplierpoverify').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierinfoStatus').html('<span class="text-primary font-weight-medium"><b> PC'+docno+' Verified</b>');
            break;
            case 3:
                stringstatus='Approved';
                backcolor="#dff7e9 !important";
                forecolor="#28c76f !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierejectbuttoninfo').show();
                $('#supplierundorejectbuttoninfo').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierinfoStatus').html('<span class="text-success font-weight-medium"><b> PC'+docno+' Approved</b>');
            break;
            case 4:
                stringstatus='Void';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierejectbuttoninfo').show();
                $('#supplierundorejectbuttoninfo').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierbacktopending').hide();
                $('#supplierinfoStatus').html('<span class="text-success font-weight-medium"><b> PC'+docno+' Active</b>');
            break;
            case 5:
                stringstatus='Expire';
                backcolor="#eae8fd !important";
                forecolor="#7367f0 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierejectbuttoninfo').show();
                $('#supplierpoverifypovoidbuttoninfo').show();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierundorejectbuttoninfo').hide();
                $('#supplierpoverifypopending').hide(); 
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierinfoStatus').html('<span class="text-danger font-weight-medium"><b> PC'+docno+' Expired</b>');
            break;
            
            case 6:
                stringstatus='Void';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierpoundovoidbuttoninfo').show();
                $('#supplierpoverifypovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide(); 
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierejectbuttoninfo').hide();
                $('#supplierundorejectbuttoninfo').hide();
                
                $('#supplierinfoStatus').html('<span class="text-danger font-weight-medium"><b> PC'+docno+' Void</b>');
            break;

            case 7:
                stringstatus='Void';
                backcolor="#fff1e3 !important";
                forecolor="#ff9f43 !important";
                span="<span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+stringstatus+"</b></span>";
                $('#targetspandiv'+id).html(span);
                $('#supplierundorejectbuttoninfo').show();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#supplierpoverifypovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide(); 
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierpoverifypoeditbutton').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierejectbuttoninfo').hide();
                $('#supplierinfoStatus').html('<span class="text-danger font-weight-medium"><b> PC'+docno+' Reject</b>');
            break;

            default:
                $('#supplierpoverifypovoidbuttoninfo').hide();
                $('#supplierpoverify').hide();
                $('#supplierpoverifypopending').hide();
                $('#supplierpoverifypoapproved').hide();
                $('#supplierpoundovoidbuttoninfo').hide();
                $('#poprintbutton').hide();
                $('#supplierbacktodraft').hide();
                $('#supplierbacktoverify').hide();
                $('#supplierbacktopending').hide();
                $('#supplierpoprintbutton').hide();
                break;
        }
    }
    function suppliersetminilog(actions) {
        var list='';
        var icons=''
        var reason='';
        var addedclass='';
        $('#ulistsupplier').empty();
        $.each(actions, function (index, value) {
            var reason=''; 
            switch (value.status) {
                case 'Void':
                        icons='danger timeline-point';
                        addedclass='text-danger';
                        reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                case 'Approve':
                        icons='success timeline-point';
                        addedclass='text-success';
                        
                break;
                case 'Verify':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                break;
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Draft':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                break;
                case 'Pending':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Created':
                        icons='secondary timeline-point';
                        addedclass='text-secondary';
                break;
                default:
                    icons='danger timeline-point';
                    addedclass='text-danger';
                    reason='';
                    break;
            }
            list+='<li class="timeline-item"><span class="timeline-point timeline-point-'+icons+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0 '+addedclass+'">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i>'+value.user+'</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span>'+reason+'</div></li>';
        });
        $('#ulistsupplier').append(list);
    }
    function infocommodotylist(headerid,ctype) {
        switch (ctype) {
            case 1:
                $('#comuditydocInfoItemdiv').hide();
                $('#directcommuditylistdatabledivinfo').show();
                $('#directinfopricetable').show();
                    suptables=$('#directcommudityinfodatatables').DataTable({ 
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
                        url: "{{ url('suppliercontractcommodity') }}/"+headerid,                   
                        type: 'GET',
                    },
                    columns: [
                        {data:'DT_RowIndex'},
                        {data: 'origin',name: 'origin'},
                        {data: 'cropyear',name: 'cropyear'},
                        {data: 'proccesstype',name: 'proccesstype'},
                        {data: 'grade',name: 'grade'},
                        {data: 'uomname',name: 'uomname'},
                        {data: 'nofbag',name: 'nofbag',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'kg',name: 'kg',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'ton',name: 'ton',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'price',name: 'price',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'total',name: 'total',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'suplier',name: 'suplier'},
                        
                    ],
                    "initComplete": function(settings, json) {
                        var totalRows = suptables.rows().count();
                        $('#directinfonumberofItemsLbl').html(totalRows);
                    }
                });
                break;
        
            default:
                    $('#comuditydocInfoItemdiv').show();
                    $('#directcommuditylistdatabledivinfo').hide();
                    $('#directinfopricetable').hide();
                    suptables=$('#comuditydocInfoItem').DataTable({ 
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
                        url: "{{ url('suppliercontractcommodity') }}/"+headerid,                   
                        type: 'GET',
                    },
                    columns: [
                        {data:'DT_RowIndex'},
                        {data: 'origin',name: 'origin'},
                        {data: 'proccesstype',name: 'proccesstype'},
                        {data: 'grade',name: 'grade'},
                        {data: 'ton',name: 'ton',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'kg',name: 'kg',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'feresula',name: 'feresula',render: $.fn.dataTable.render.number(',', '.', 2, '')},
                        {data: 'percentage',name: 'percentage'},
                        {data: 'recievestation',name: 'recievestation'},
                        {data: 'ectalocation',name: 'ectalocation'},
                    ],
                });
                break;
        }
            
    }
    function closeinlineFormModalWithClearValidation() {
        $('.rmerror').html('');
    }

    $('#contractseller').on('change', function(e) {
        $('#contractseller-error').html('');
    });
    $('#contractrecipent').on('change', function(e) {
        $('#contractrecipent-error').html('');
    });
    $('#date').on('change', function(e) {
        $('#date-error').html('');
    });
    
    $('#enddate').on('change', function(e) {
        $('#enddate-error').html('');
    });
    $('#pdf').on('change', function(e) {
        $('#pdf-error').html('');
    });
    $('#signdate').on('change', function(e) {
        $('#signdate-error').html('');
    });
    
    $('#dara').on('keyup', function(e) {
        $('#dara-error').html('');
    });
    $('#ecta').on('keyup', function(e) {
        $('#ecta-error').html('');
    });
    $('body').on('click', '.addbutton', function () {
        setvaluestoempty();
    });
    function setvaluestoempty() {
        $('#dynamicTable').hide();
        $('.sr').select2('destroy');
        $('.sr').val('').select2();
        $('#contractype').select2('destroy');
        $('#contractype').val('').select2();
        $("#exampleModalScrollable").modal('show');
        var currentdate=$('#currentdate').val();
        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false,minDate:currentdate});
        $("#date").val(currentdate);
        $('#directistaxable').val('0');
        $('#ecta').val('');
        $('#dara').val('');
        $('#signdate').val('');
        $('#enddate').val('');
        $('#memo').val('');
        $('#pcontractid').val('');
        $('#filename').val('');
        $('#pdf').val('');
        $('#filepath').val('');
        $('#ectadiv').hide();
        $('#daradiv').hide();
        $('#signdatediv').hide();
        $('#enddatediv').hide();
        $('#slipdocumentlinkbtn').hide();
        $('#exampleModalScrollableTitleadd').text('Add Purchase Contract');
        $('#statusdisplay').html('');
        $('#directcustomCheck1').prop('checked', false);
        $('#directpricetable').hide();
        $('.lbl').html('0.00');
        $("#dynamicTablecommdity > tbody").empty();
        $("#directdynamicTablecommdity > tbody").empty();
        $('#dynamicTablecommdity').hide();
        $('#directdynamicTablecommdity').hide();
        $('#type option[value!=0]').prop('disabled', false);
        $('#contractype option[value!=0]').prop('disabled', false);
        $('#totalkg').html('');
        $('#totalton').html('');
        $('#totalferesula').html('');
    }
    
    $("#adds").on('click', function() {
        ++i;
        ++j;
        ++m;
        commodityappendtable(j,m);
        renumberRows();
        var currentdate=$('#currentdate').val();
        var options = $("#hiddencommudity > option").clone();
        var gradeoption=$("#coffeegrade > option").clone();
        var proccesstype=$("#coffeeproccesstype > option").clone();
        $('#itemNameSl'+m).append(options);
        $('#coffegrade'+m).append(gradeoption);
        $('#proccesstype'+m).append(proccesstype);
        $('#itemNameSl'+m).select2({placeholder: "Select commodity"});
        $('#coffegrade'+m).select2({placeholder: "Select grade"});
        $('#proccesstype'+m).select2({placeholder: "Select proccess type"});
        flatpickr('#signedate'+m, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
        flatpickr('#endate'+m, { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
    });

    function commodityappendtable(j,m) {
                $("#dynamicTablecommdity tbody").append('<tr id="row'+j+'" class="dynamic-added">'+
                    '<td style="text-align:center;">'+j+'</td>'+
                    '<td style="width: 15%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="sourceVal(this)"  name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="width:10%;"><select id="proccesstype'+m+'" class="select2 form-proccesstype coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                    '<td style="width:10%;"><select id="coffegrade'+m+'" class="select2 form-control coffegrade" onchange="sourceVal(this)" name="row['+m+'][grade]"></select></td>'+
                    '<td><input type="text" name="row['+m+'][ton]" placeholder="TON" id="ton'+m+'" class="ton form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" /></td>'+
                    '<td><input type="text" name="row['+m+'][kg]" placeholder="KG" id="totalkg'+m+'" class="kg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][feresula]" placeholder="Feresula" id="totalkg'+m+'" class="feresula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][percentage]" placeholder="Percentage" id="percentage'+m+'" class="percent form-control" onkeyup="clearerrors(this)" onkeypress="return ValidateNum(event);" /></td>'+
                    '<td><input type="text" name="row['+m+'][revievestation]" id="revievestation'+m+'" class="revievestation form-control" placeholder="Dispatch Station" style="font-weight:bold;" readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][ectalocation]" id="ectalocation'+m+'" class="total form-control" onkeyup="clearerrors(this)" placeholder="" style="font-weight:bold;"/>'+
                    '<input type="hidden" name="row['+m+'][pcid]" id="pcid'+m+'" class="prid form-control"  style="font-weight:bold;" readonly/>'+
                    '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/></td>'+
                    '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>');
    }
    function appendcommodity(product) {
        $("#dynamicTablecommdity > tbody").empty();
        j=0;
        $.each(product, function (index, value) { 
                ++j;
                ++m;
                supplyid=value.supplyworeda;
                supploption=value.supplyorigin;
                tables='<tr id="row'+j+'" class="dynamic-added">'+
                '<td style="text-align:center;">'+j+'</td>'+
                    '<td style="width: 15%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="sourceVal(this)"  name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="width:10%;"><select id="proccesstype'+m+'" class="select2 form-proccesstype coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                    '<td style="width:10%;"><select id="coffegrade'+m+'" class="select2 form-control coffegrade" onchange="sourceVal(this)" name="row['+m+'][grade]"></select></td>'+
                    '<td><input type="text" name="row['+m+'][ton]" placeholder="TON" id="ton'+m+'" value="'+value.ton+'" class="ton form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" /></td>'+
                    '<td><input type="text" name="row['+m+'][kg]" placeholder="KG" id="kg'+m+'" value="'+value.kg+'" class="kg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][feresula]" placeholder="Feresula" id="feresula'+m+'" value="'+value.feresula+'" class="feresula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                    '<td><input type="text" name="row['+m+'][percentage]" placeholder="Percentage" id="percentage'+m+'" value="'+value.percentage+'" class="ton form-control"  onkeyup="clearerrors(this)"  onkeypress="return ValidateNum(event);" /></td>'+
                    '<td><input type="text" name="row['+m+'][revievestation]" id="revievestation'+m+'" value="'+value.recievestation+'" class="revievestation form-control" placeholder="Reciever Station" style="font-weight:bold;"/></td>'+
                    '<td><input type="text" name="row['+m+'][ectalocation]" id="ectalocation'+m+'"  value="'+value.ectalocation+'" class="total form-control" onkeyup="clearerrors(this)" placeholder="" style="font-weight:bold;"/>'+
                    '<input type="hidden" name="row['+m+'][pcid]" id="pcid'+m+'"  value="'+value.id+'"  class="prid form-control"  style="font-weight:bold;" readonly/>'+
                    '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/></td>'+
                    '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>';
            
            $("#dynamicTablecommdity > tbody").append(tables);
        
            var options = $("#hiddencommudity > option").clone();
            var optionsselected = '<option selected value="'+value.woreda+'">'+value.origin+'</option>';
            var gradeoption=$("#coffeegrade > option").clone();
            var gradeoptionselected = '<option selected value="'+value.grade+'">'+value.grade+'</option>';

            var proccesstype=$("#coffeeproccesstype > option").clone();
            var proccesstypeselected = '<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+value.woreda+"']").remove();
            $('#itemNameSl'+m).append(optionsselected);
                
            $('#coffegrade'+m).append(gradeoption);
            $("#coffegrade"+m+" option[value='"+value.grade+"']").remove();
            $('#coffegrade'+m).append(gradeoptionselected);
        
            $('#proccesstype'+m).append(proccesstype);
            $("#proccesstype"+m+" option[value='"+value.proccesstype+"']").remove();
            $('#proccesstype'+m).append(proccesstypeselected);
                        
            $('#itemNameSl'+m).select2({placeholder: "Select commodity"});
            $('#coffegrade'+m).select2({placeholder: "Select grade"});
            $('#proccesstype'+m).select2({placeholder: "Select proccess type"});
        
        });
    }
    function onetimeappend(product) {
        var jj=0;
        
        $("#directdynamicTablecommdity > tbody").empty();
        var readonly='';
        $.each(product, function (index, value) { 
            ++jj;
            ++mm;
            console.log('value='+value.ton);
            var tables='<tr id="row'+jj+'" class="financialevdynamic-commudity">'+
                '<td style="text-align:center;">'+jj+'</td>'+
                '<td><select id="itemNameSl'+mm+'" class="select2 form-control form-control-lg eName" onchange="directsourceVal(this)" name="fevrow['+mm+'][evItemId]"></select></td>'+
                '<td><select id="cropyear'+mm+'" class="select2 form-control cropyear" onchange="directsourceVal(this)" name="fevrow['+mm+'][evcropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+mm+'" class="select2 form-control coffeproccesstype" onchange="directsourceVal(this)" name="fevrow['+mm+'][coffeproccesstype]"></select></td>'+
                '<td style="width:6%;"><select id="directgrade'+mm+'" class="select2 form-control directgrade" onchange="directsourceVal(this)" name="fevrow['+mm+'][directgrade]"></select></td>'+
                '<td><select id="uom'+mm+'" class="select2 form-control directuom" onchange="directuomval(this)" name="fevrow['+mm+'][uom]"></select></td>'+
                '<td><input type="text" name="fevrow['+mm+'][qauntity]" placeholder="No of bag" id="directfevqauntity'+mm+'" value="'+value.nofbag+'" class="directfevqauntity form-control" onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][quantitykg]" placeholder="KG" id="quantitykg'+mm+'" value="'+value.kg+'" class="directquantitykg form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][ton]" placeholder="TON" id="directon'+mm+'" value="'+value.ton+'" class="directon form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][feresula]" placeholder="feresula" id="feresula'+mm+'" value="'+value.feresula+'" class="directferesula form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][finalprice]" placeholder="price" id="directfinalprice'+mm+'" value="'+value.price+'" class="directfinalprice form-control"onkeyup="directCalculateTotal(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+mm+'][Total]" placeholder="Total" id="fevtotal'+mm+'" value="'+value.total+'" class="directfevtotal form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td style="width:6%;"><select id="supplierwarehouse'+mm+'" class="select2 form-control supplierwarehouse" onchange="directsourceVal(this)" name="fevrow['+mm+'][supplierwarehouse]"></select></td>'+
                '<td style="width:3%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm longtermremove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][vals]" id="directvals'+mm+'" class="directvals form-control" readonly="true" style="font-weight:bold;" value="'+mm+'"/></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+mm+'][pdetid]" id="pdetid'+mm+'" value="'+value.id+'" class="pdetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
            '</tr>';
            $("#directdynamicTablecommdity > tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var uomoption=$("#uom > option").clone();
            var itemoptionsselected='<option selected value="'+value.woreda+'">'+value.origin+'</option>';
            var cropyearselected='<option selected value="'+value.cropyear+'">'+value.cropyear+'</option>';
            var proccesstypeselected='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';
            var uomselected='<option selected value="'+value.uimid+'" title="'+value.amount+'">'+value.uomname+'</option>';
            var gardeselected='<option selected value="'+value.grade+'">'+value.grade+'</option>';
            
            var suplieroption=$("#contractsellerhidden > option").clone();
            var suplieroptionselected='<option selected value="'+value.cusid+'">'+value.cname+'</option>';

            $('#supplierwarehouse'+mm).append(suplieroption);
            $("#supplierwarehouse"+mm+" option[value='"+value.cusid+"']").remove();
            $('#supplierwarehouse'+mm).append(suplieroptionselected);
            $('#supplierwarehouse'+mm).select2({placeholder: "Supllier Warehouse"});

            $('#itemNameSl'+mm).append(options);
            $("#itemNameSl"+mm+" option[value='"+value.supplyworeda+"']").remove();

            $('#cropyear'+mm).append(cropyearoption);
            $("#cropyear"+mm+" option[value='"+value.cropyear+"']").remove();

            $('#directgrade'+mm).append(gradeoption);
            $("#directgrade"+mm+" option[value='"+value.grade+"']").remove();

            $('#coffeproccesstype'+mm).append(proccesstypeoption);
            $("#coffeproccesstype"+mm+" option[value='"+value.proccesstype+"']").remove();
            $('#itemNameSl'+mm).append(itemoptionsselected);
            $('#itemNameSl'+mm).select2();
            
            $('#cropyear'+mm).append(cropyearselected);
            $('#cropyear'+mm).select2();

            $('#directgrade'+mm).append(gardeselected);
            $('#directgrade'+mm).select2();

            $('#coffeproccesstype'+mm).append(proccesstypeselected);
            $('#coffeproccesstype'+mm).select2();

            $('#uom'+mm).append(uomoption);
            $("#uom"+mm+" option[value='"+value.uomid+"']").remove();
            $('#uom'+mm).append(uomselected);
            $('#uom'+mm).select2();
            $('#select2-directgrade'+mm+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });
        directCalculateGrandTotal();
        $('#directdynamicTablecommdity').show();
        var count=$("#directdynamicTablecommdity > tbody tr").length;
        $('#directpricetable').show();
        $('#adds').show();
        $('#directnumberofItemsLbl').html(count);

    }
    function CalculateTotal(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        var ton = $(ele).closest('tr').find('.ton').val()||0;
        var kg=parseFloat(ton)*1000;
        var feresula=parseFloat(kg)/17;
        $(ele).closest('tr').find('.kg ').val(kg.toFixed(2));
        $(ele).closest('tr').find('.feresula').val(feresula.toFixed(2));
        $('#ton'+idval).css("background", "white");
    }
    function clearerrors(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        switch (inputid) {
            case 'percentage'+idval:
                $('#percentage'+idval).css("background", "white");
                break;

            default:
                $('#ectalocation'+idval).css("background", "white");
                
                break;
        }
        
    }
    function sourceVal(ele){
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        var selectedcommodity= $(ele).closest('tr').find('.eName').val()||0;
        var selectedproccestype=$(ele).closest('tr').find('.coffeproccesstype').val()||0;
        var selectedgrade=$(ele).closest('tr').find('.coffegrade').val()||0;
        var commuditycnt=0;
        switch (inputid) {
            case 'itemNameSl'+idval:
                    for (let k = 1; k <=m; k++) {
                        if(($('#itemNameSl'+k).val())!=undefined){
                            var kgrade=$('#coffegrade'+k).val()||0;
                            var kproccesstype=$('#proccesstype'+k).val()||0;
                            var kcommodity=$('#itemNameSl'+k).val()||0;
                            console.log('kgrade='+kgrade+"--"+selectedgrade);
                            console.log('kproccesstype='+kproccesstype+"--"+selectedproccestype);
                            console.log('kcommodity='+kcommodity+"--"+selectedcommodity);
                            if((parseInt(kcommodity) == parseInt(selectedcommodity)) && kgrade == selectedgrade && kproccesstype===selectedproccestype){
                                            commuditycnt+=1;
                                        }
                        }
                    }
                    
                    if (parseInt(commuditycnt)<=1) {
                            var selectedOptionTitle = $('#itemNameSl'+idval+' option:selected').attr('title');
                            $('#revievestation'+idval).val(selectedOptionTitle);
                            $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
                    } else if(parseInt(commuditycnt)>1) {
                            $('#itemNameSl'+idval).select2('destroy');
                            $('#itemNameSl'+idval).val('').select2();
                            $('#itemNameSl'+idval).select2({placeholder: "Select commodity"});
                            $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
                            toastrMessage('error',"Commodity selected with all property","Error");
                    }
                break;
                case 'proccesstype'+idval:
                    for (let k = 1; k <=m; k++) {
                        if(($('#itemNameSl'+k).val())!=undefined){
                            var kgrade=$('#coffegrade'+k).val()||0;
                            var kproccesstype=$('#proccesstype'+k).val()||0;
                            var kcommodity=$('#itemNameSl'+k).val()||0;
                            console.log('kgrade='+kgrade+"--"+selectedgrade);
                            console.log('kproccesstype='+kproccesstype+"--"+selectedproccestype);
                            console.log('kcommodity='+kcommodity+"--"+selectedcommodity);
                            if((parseInt(kcommodity) == parseInt(selectedcommodity)) && kgrade == selectedgrade && kproccesstype===selectedproccestype){
                                            commuditycnt+=1;
                                        }
                        }
                    }
                    if (parseInt(commuditycnt)<=1) {
                            $('#select2-proccesstype'+idval+'-container').parent().css('background-color',"white");
                    } else if(parseInt(commuditycnt)>1) {
                            $('#proccesstype'+idval).select2('destroy');
                            $('#proccesstype'+idval).val('').select2();
                            $('#proccesstype'+idval).select2({placeholder: "Select proccess type"});
                            $('#select2-proccesstype'+idval+'-container').parent().css('background-color',errorcolor);
                            toastrMessage('error',"Commodity selected with all property","Error");
                    }
                    break;
                    
            default:
                    for (let k = 1; k <=m; k++) {
                        if(($('#itemNameSl'+k).val())!=undefined){
                            var kgrade=$('#coffegrade'+k).val()||0;
                            var kproccesstype=$('#proccesstype'+k).val()||0;
                            var kcommodity=$('#itemNameSl'+k).val()||0;
                            console.log('kgrade='+kgrade+"--"+selectedgrade);
                            console.log('kproccesstype='+kproccesstype+"--"+selectedproccestype);
                            console.log('kcommodity='+kcommodity+"--"+selectedcommodity);
                            if((parseInt(kcommodity) == parseInt(selectedcommodity)) && kgrade == selectedgrade && kproccesstype===selectedproccestype){
                                            commuditycnt+=1;
                                        }
                        }
                    }
                    if (parseInt(commuditycnt)<=1) {
                            $('#select2-coffegrade'+idval+'-container').parent().css('background-color',"white");
                    } else if(parseInt(commuditycnt)>1) {
                            $('#coffegrade'+idval).select2('destroy');
                            $('#coffegrade'+idval).val('').select2();
                            $('#coffegrade'+idval).select2({placeholder: "Select proccess type"});
                            $('#select2-coffegrade'+idval+'-container').parent().css('background-color',errorcolor);
                            toastrMessage('error',"Commodity selected with all property","Error");
                    }
                    
                break;
        }
    }
    function renumberRows(params) {
        var ind;
        $('#dynamicTablecommdity > tbody > tr').each(function(index, el){
                            $(this).children('td').first().text(++index);
                            
                            ind=index;
                            j=ind;
        });
    }
    $(document).on('click', '.remove-tr', function(){
            --i;
            --j;
            $(this).parents('tr').remove();
            renumberRows();
    });
    function contractlist() {
        pctables=$('#pcontracttables').DataTable({
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
                
                        text:'@can("PC-Add")<i data-feather="plus"></i> Add @endcan',
                        className: '@can("PC-Add")btn btn-gradient-info btn-sm addbutton @endcan',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-secondary');
                        }
            }
        ],
        ajax: {
        url: "{{ url('contractlist') }}",
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
            { data: 'docno', name: 'docno' },
            { data: 'type', name: 'type' },
            { data: 'contractype', name: 'contractype' },
            { data: 'customername', name: 'customername' },
            { data: 'tin', name: 'tin' },
            { data: 'date', name: 'date' },
            { data: 'ecxno', name: 'ecxno' },
            { data: 'ddano', name: 'ddano' },
            { data: 'signedate', name: 'signedate' },
            { data: 'endate', name: 'endate' },
            { data: 'status', name: 'status' },
            { data: 'id', name: 'id',orderable: false },
        ],
        columnDefs: [   

                        {
                            targets: 1,
                            render: function ( data, type, row, meta ) {
                                    return 'PC'+data;
                            }
                        },
                        {
                            targets: 3,
                            render: function ( data, type, row, meta ) {
                                    switch (data) {
                                        case 1:
                                            return 'One Time';
                                            break;
                                    
                                        default:
                                            return 'Long Term';
                                            break;
                                    }
                            }
                        }
                        ,
                        {
                            targets: 11,
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
                                        return '<span class="text-success font-weight-medium"><b>Active</b></span>';
                                    break;
                                    case 5:
                                        return '<span class="text-danger font-weight-medium"><b>Expired</b></span>';
                                    break;
                                    case 6:
                                        return '<span class="text-danger font-weight-medium"><b>Void</b></span>';
                                    break;
                                    case 7:
                                        return '<span class="text-danger font-weight-medium"><b>Reject</b></span>';
                                    break;
                                    default:
                                        return '--';
                                        break;
                                }
                            }
                        },
                        {
                            targets: 12,
                            render: function ( data, type, row, meta ) {
                                var anchor='<a class="DocPrInfo" href="javascript:void(0)" data-id='+data+' title="View sales"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
                                return anchor;
                            }
                        },
                ],
        });

    }

    function setFocus(){ 
        $($('#pcontracttables tbody > tr')[gblIndex]).addClass('selected');  
    }
    $('#pcontracttables tbody').on('click', 'tr', function () {
            $('#pcontracttables tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            gblIndex = $(this).index();
    });
    $('#directcustomCheck1').click(function(){
        if ($('#directcustomCheck1').is(':checked')) {
            $('#directistaxable').val('1');
        } else{
            $('#directistaxable').val('0');
        }
        directCalculateGrandTotal();
    });
    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
</script>
@endsection