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
                        @can('PE-View')
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-12">
                                    <h4 class="card-title">Purchase Evaluation(PE)
                                        <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="purchasetablesrefresh()"><i data-feather="refresh-cw"></i></button>
                                        <input type="hidden" name="contingencypertcent" id="contingencypertcent" class="form-control" value="{{ $percent }}" readonly>
                                        <input type="hidden" name="currentdate" id="currentdate" class="form-control" value="{{ $todayDate }}" readonly>
                                        <input type="hidden" class="form-control" name="pevsupplieradd" id="pevsupplieradd" value="{{ auth()->user()->can('PE-Add') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="pevsupplieredit" id="pevsupplieredit" value="{{ auth()->user()->can('PE-Edit') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="technicalviewpermission" id="technicalviewpermission" value="{{ auth()->user()->can('TE-View') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="financialviewpermission" id="financialviewpermission" value="{{ auth()->user()->can('FE-View') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="financialviewpermission" id="financialviewpermission" value="{{ auth()->user()->can('FE-View') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="financialprogresspermission" id="financialprogresspermission" value="{{ auth()->user()->can('TE-Progress') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="peaddpermission" id="peaddpermission" value="{{ auth()->user()->can('PE-Add') ? 1 : 0 }}" readonly/>
                                        <input type="hidden" class="form-control" name="suppplierviewpermission" id="suppplierviewpermission" value="{{ auth()->user()->can('Supplier-View') ? 1 : 0 }}" readonly/>
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
                                <div class="col-xl-3 col-lg-12"  style="display: visible;">
                                    <label strong style="font-size: 12px;font-weight:bold;">Filter By</label>
                                    <select data-column="6" class="selectpicker form-control filter-select" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-count-selected-text="PE ({0})" data-live-search-placeholder="search Evaluation" title="Select Filter" multiple>
                                            <option  value="1">PE Initation</option>
                                            <option  value="2">Technical Evaluation</option>
                                            <option  value="3">Financial Evaluation</option>
                                    </select>
                                </div>
                                <div class="col-xl-2 col-lg-12" style="display: none;">
                                    <b>Budget Review:</b>
                                    <label strong style="font-size: 12px;font-weight:bold;" id="budgetapprovalcount"></label>
                                    <span strong style="font-weight:bold;font-size:12px;text-decoration:underline;color:blue;" onclick="listreviewbudget()">View</span>
                                </div>
                            </div>
                            
                        </div>
                        @endcan
                        {{-- <ul class="nav nav-tabs nav-justified" id="apptabs" role="tablist">
                            @can('PE-View')
                                <li class="nav-item" id="allitemstab">
                                    <a class="nav-link active" id="homeIcon-tab" data-toggle="tab" href="#homeIcon" aria-controls="home" role="tab" aria-selected="true" onclick="pelistbytab('pe');"><i data-feather="home"></i> Purcase Evaluation</a>
                                </li>
                            @endcan
                            @can('TE-View')
                                <li class="nav-item" id="goodstab">
                                    <a class="nav-link" id="goods-tab" data-toggle="tab" href="#technical" aria-controls="technical" role="tab" aria-selected="false" onclick="pelistbytab('te');"><i data-feather="tool"></i>Technical Evaluation</a>
                                </li>
                            @endcan
                            @can('FE-View')
                                <li class="nav-item" id="consumptiontab">
                                    <a class="nav-link" id="consumption-tab" data-toggle="tab" href="#financial" aria-controls="financial" role="tab" aria-selected="false" onclick="pelistbytab('fe');"><i data-feather="codepen"></i>Financial Evaluation</a>
                                </li>
                            @endcan
                            
                        </ul> --}}
                        @can('PE-View')
                                <div class="tab-pane active" id="homeIcon" aria-labelledby="homeIcon-tab" role="tabpanel">
                                <div class="card-datatable">
                                    <div style="width:98%; margin-left:1%" class="" id="table-block">
                                        <table id="purtables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">#</th>
                                                    <th rowspan="2">Doc#</th>
                                                    <th rowspan="2">Code</th>
                                                    <th colspan="2" style="text-align: center;">Supplier</th>
                                                    <th colspan="2" style="text-align: center;">Reference</th>
                                                    <th rowspan="2">Product Type</th>
                                                    <th rowspan="2">Document Date </th>
                                                    <th rowspan="2">Status</th>
                                                    <th rowspan="2">Action</th>
                                                </tr>
                                                <tr style="text-align: center;">
                                                    <th>Name</th>
                                                    <th>TIN</th>
                                                    <th>Type</th>
                                                    <th>Number</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        <div class="tab-content">
                            @can('TE-View')
                                <div class="tab-pane" id="technical" aria-labelledby="technical-tab" role="tabpanel">
                                    <div class="card-datatable">
                                        <div style="width:98%; margin-left:1%" class="" id="table-block">
                                            <table id="technicalevualtiontables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Referene#</th>
                                                        <th>Reference</th>
                                                        <th>Reference#</th>
                                                        <th>Product Type</th>
                                                        <th>Document Date </th>
                                                        <th>status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                            @can('FE-View')
                                <div class="tab-pane" id="financial" aria-labelledby="financial-tab" role="tabpanel">
                                <div class="card-datatable">
                                    <div style="width:98%; margin-left:1%" class="" id="table-block">
                                        <table id="financialevualtiontables" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Referene#</th>
                                                    <th>Reference</th>
                                                    <th>Reference#</th>
                                                    <th>Product Type</th>
                                                    <th>Document Date </th>
                                                    <th>status</th>
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
    </div>
    {{-- start info modal --}}
    <div class="modal fade" id="docInfoModal" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" style="display: none;">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Purchase Evaluation Information</h5>
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
                                        <span class="lead collapse-title">Purchase Evaluation Details</span>
                                        <span id="" style="font-size:16px;"></span>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
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
                                                                    <td><b><label id="infope" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Reference: </label></td>
                                                                    <td><b><label id="inforefernce" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr id="trinforfq">
                                                                    <td><label strong style="font-size: 12px;">Reference#: </label></td>
                                                                    <td><b><label id="inforfq" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Product Type: </label></td>
                                                                    <td><b><label id="infotype" strong style="font-size: 12px;"></label></b></td>
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
                                                                    <td><label strong style="font-size: 12px;">Request Date: </label></td>
                                                                    <td><b><label id="infodocumentdate" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Request Station: </label></td>
                                                                    <td><b><label id="infostation" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Priority: </label></td>
                                                                    <td><b><label id="infopriority" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Sample: </label></td>
                                                                    <td><b><label id="infosample" strong style="font-size: 12px;"></label></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label strong style="font-size: 12px;">Memo: </label></td>
                                                                    <td><b><label id="infomemo" strong style="font-size: 12px;"></label></b></td>
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
                                                                <a class="nav-link active" id="initationview-tab" data-toggle="tab" href="#initationview" aria-controls="initationview" role="tab" aria-selected="true" onclick="infopelistbytab('peview');"><i data-feather="home"></i>Evaluation Initation</a>
                                                            </li>
                                                        @endcan
                                                        @can('TE-View')
                                                            <li class="nav-item" id="tectnicaltab">
                                                                <a class="nav-link" id="technicalview-tab" data-toggle="tab" href="#technicalview" aria-controls="technicalview" role="tab" aria-selected="false" onclick="infopelistbytab('teview');"><i data-feather="tool"></i>Technical Evaluation</a>
                                                            </li>
                                                        @endcan
                                                        @can('FE-View')
                                                            <li class="nav-item" id="financialtab">
                                                                <a class="nav-link" id="financialview-tab" data-toggle="tab" href="#financialview" aria-controls="financialview" role="tab" aria-selected="false" onclick="infopelistbytab('feview');"><i data-feather="codepen"></i>Financial Evaluation</a>
                                                            </li>
                                                        @endcan
                                                        
                                                    </ul>
                                                    <div class="tab-content">
                                                            <div class="tab-pane active" id="initationview" aria-labelledby="initationview-tab" role="tabpanel">
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
                                                        <div class="tab-pane" id="financialview" aria-labelledby="financialview-tab" role="tabpanel">
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
                                            @can('PE-Edit')
                                                <button type="button" id="preditbutton" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i> Edit</button>
                                                <button type="button" id="addeditrequestinition" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i> Add/Edit Commodity</button>
                                                <button type="button" id="addeditsuppliers" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i>Add/Edit Supplier </button>
                                            @endcan
                                            @can('TE-Insertion')
                                                <button type="button" id="evaulatesuppliers" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i>TE Insertion</button>
                                            @endcan
                                            @can('FE-Insertion')
                                                <button type="button" id="finevaulatesuppliers" class="btn btn-outline-dark"><i class="fa-sharp fa-solid fa-pen"></i>FE Insertion</button>
                                            @endcan
                                            @can('PE-Void')
                                                <button type="button" id="prvoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Void</button>
                                                <button type="button" id="prundovoidbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo void</button>
                                            @endcan
                                            @can('PE-Reject')
                                                <button type="button" id="prejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-xmark"></i> Reject</button>
                                                <button type="button" id="prundorejectbuttoninfo" class="btn btn-outline-dark"><i class="fa-solid fa-trash-undo"></i> Undo Reject</button>
                                            @endcan
                                            
                                            <button type="button" id="prprintbutton" class="btn btn-outline-dark"><i data-feather="printer" class="mr-25"></i>Print</button>
                                    </div>        
                                    <div class="col-xl-6 col-lg-12" style="text-align:right;">
                                            @can('PE-Pending')
                                                <button type="button" id="changetopendingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Change To Pending</button>
                                                <button type="button" id="backtodrfatbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Back To Draft</button>
                                            @endcan
                                            
                                            @can('PE-Verify')
                                                <button type="button" id="verifybutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Verify</button>
                                                <button type="button" id="backtopendingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Back to pending</button>
                                            @endcan
                                            
                                            @can('TE-Approve')
                                                <button type="button" id="evaluationapprovedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Evaluation Approved</button>
                                            @endcan
                                            @can('TE-Progress')
                                                <button type="button" id="backverifybutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back to verify</button>
                                                <button type="button" id="authorizebutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>TE Progress</button>
                                            @endcan

                                            @can('TE-Finish')
                                                <button type="button" id="backtotebutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back to TE</button>
                                                <button type="button" id="approvedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>TE Finished</button>
                                            @endcan
                                            
                                            @can('FE-Progress')
                                                <button type="button" id="financalevaulatingbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>FE Progress</button>
                                            @endcan
                                            
                                            @can('FE-Finish')
                                                <button type="button" id="backtofebutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Back to FE</button>
                                                <button type="button" id="financialapprovedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>FE Finished</button>
                                            @endcan
                                            @can('PE-Confirm')
                                                <button type="button" id="financialconfirmedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Confirm</button>
                                            @endcan
                                            @can('PE-Approve')
                                                <button type="button" id="financialapprovedafterconfirmbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>Approved</button>
                                            @endcan
                                            @can('TE-Fail')
                                                <button type="button" id="tefailbtn" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>TE Failed</button>
                                            @endcan
                                            @can('FE-Fail')
                                                <button type="button" id="fefailbtn" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i>FE Failed</button>
                                            @endcan
                                            
                                            <button type="button" id="reviewedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Review</button>
                                            <button type="button" id="undoreviewedbutton" class="btn btn-outline-dark"><i class="fa-solid fa-badge-check"></i> Undo Review</button>
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
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitleadd" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitleadd">Purchase Evaluation</h5>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                </div>
                <div class="modal-body scroll scrdiv" id="card-block">
                    <form id="Register">
                        {{ csrf_field() }}
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-12">
                                            <div class="row">
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Reference <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg sr" name="reference" id="reference" data-placeholder="select reference">
                                                            <option selected disabled  value=""></option>  
                                                            <option value="Direct">Direct</option>
                                                            <option value="RFQ">RFQ</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="reference-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Type <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg sr" name="type" id="type" data-placeholder="select purchase type">
                                                            <option selected disabled  value=""></option> 
                                                            <option value="Commodity">Commodity</option> 
                                                            <option value="Goods">Goods</option>
                                                            
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="type-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="rfqdiv">
                                                        <label strong style="font-size: 14px;">Referene# <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg sr" name="rfq" id="rfq" data-placeholder="select rfq">
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="rfq-error" class="rmerror"></strong>
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

                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="commoditytypediv" style="display: visible;">
                                                        <label strong style="font-size: 14px;">Commodity Type  <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg sr" name="commoditytype" id="commoditytype" data-placeholder="select commodity type">
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

                                                    <div class="col-xl-2 col-lg-12" id="coffeesourcediv" style="display: visible;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Commodity Source <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="coffeesource" id="coffeesource" data-placeholder="coffee source">
                                                                <option selected disabled  value=""></option>
                                                                <option value="Commercial">Commercial</option>
                                                                
                                                                <option value="Grower">Grower</option>
                                                                <option value="Vertical">Vertical</option>
                                                                <option value="Horizontol">Horizontol</option>
                                                                <option value="ECX">ECX</option>
                                                                <option value="Union">Union</option>
                                                                <option value="Farmer">Farmer</option>
                                                                <option value="Value-Added">Value Added</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="coffeesource-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-12" id="coffestatusdiv" style="display: visible;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Commodity Status <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control sr" name="coffestatus" id="coffestatus" data-placeholder="coffee status">
                                                                <option selected disabled  value=""></option>
                                                                <option value="Green Bean">Green Bean</option>
                                                                <option value="Roast and Grind">Roast and Grind</option>
                                                                <option value="Other">Other</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="coffestatus-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-12" id="coffecerificatediv" style="display: none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Organic Certified <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control sr" name="coffecerificate" id="coffecerificate" data-placeholder="Oranic Certificate">
                                                                <option selected disabled  value=""></option>
                                                                <option value="Y">Yes</option>
                                                                <option value="N">No</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="coffecerificate-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-12" id="cropYeardiv" style="display: none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Crop Year<b style="color:red;">*</b></label>
                                                        <select class="select2 form-control sr" name="cropYear" id="cropYear" data-placeholder="crop year">
                                                                <option selected disabled  value=""></option>  
                                                                @foreach ($cropyear as $key )
                                                                    <option  value="{{ $key->CropYear }}">{{ $key->CropYear }}</option>
                                                                @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="year-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Source of Stock <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control form-control-lg sr" name="source" id="source" data-placeholder="select purchase type">
                                                            <option selected disabled  value=""></option>  
                                                            <option value="All">All</option>
                                                            <option value="On Hand">On Hand</option>
                                                            <option value="Low Stock">Low Stock</option>
                                                            <option value="Out Off Stock">Out Off Stock</option>
                                                            <option value="Re-order">Re-order</option>
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="source-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>

                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Currency <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg sr" name="currency" id="currency" data-placeholder="select currency" >
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

                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: visible;">
                                                        <label strong style="font-size: 14px;"> Requst Station <b style="color:red;">*</b></label>
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

                                                    <div class="col-xl-2 col-lg-12" style="display: visible;">
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
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Request For <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg sr" name="requestby" id="requestby" data-placeholder="select department" >
                                                                <option selected disabled  value=""></option>  
                                                                @foreach ($user as $key )
                                                                    <option  value="{{ $key->id }}">{{ $key->FullName }}</option>
                                                                @endforeach
                                                            </select>
                                                        <span class="text-danger">
                                                            <strong id="requestby-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;" style="display: none;">
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
                                                        <label strong style="font-size: 14px;">Request Date <b style="color:red;">*</b></label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="text"  name="date" id="date" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                                        </div>
                                                        <span class="text-danger">
                                                            <strong id="date-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Submission Date <b style="color:red;">*</b></label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="text"  name="requiredate" id="requiredate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                                        </div>
                                                        <span class="text-danger">
                                                            <strong id="requiredate-error" class="rmerror"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                        <label strong style="font-size: 14px;">Memo</label>
                                                        <div class="input-group input-group-merge">
                                                            <textarea  class="form-control" id="memo" placeholder="Write memo here" name="memo" ></textarea>
                                                        </div>
                                                        <span class="text-danger">
                                                            <strong id="memo-error"></strong>
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="col-xl-6 col-md-6 col-sm-12 mb-2" id="supplierdiv" style="display: none;">
                                                        <label strong style="font-size: 14px;">Supplier <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg" name="customer" id="customer" data-placeholder="select supplier">
                                                                @foreach ($customer as $key)
                                                                    <option value="{{ $key->id }}">{{ $key->Code }}, {{ $key->Name }}, {{ $key->TinNumber }}</option>
                                                                @endforeach
                                                            </select>
                                                        <span class="text-danger">
                                                            <strong id="supplier-error"></strong>
                                                        </span>
                                                    </div>
                                                    <div class="col-xl-6 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;">Evulator <b style="color:red;">*</b></label>
                                                            <select class="select2 form-control form-control-lg" name="evualator" id="evualator" data-placeholder="select evualator">
                                                                @foreach ($user as $key)
                                                                    <option value="{{ $key->id }}">{{ $key->FullName }},</option>
                                                                @endforeach
                                                            </select>
                                                        <span class="text-danger">
                                                            <strong id="supplier-error"></strong>
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
                                                    
                                                    <div class="col-xl-3 col-lg-12" style="display:none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">requested Commodity <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="requestedcommodity" id="requestedcommodity">
                                                        </select>
                                                    </div>
                                                
                                                    <div class="col-xl-3 col-lg-12" style="display:none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Rfq Supplier <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="rfqsupllier" id="rfqsupllier">
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12" style="display:none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Commodity <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="hiddencommudity" id="hiddencommudity">
                                                            <option selected disabled  value=""></option>
                                                            @foreach ($woreda as $key)
                                                            <option title="{{$key->id}}" value="{{$key->id}}">{{$key->Rgn_Name}}, {{$key->Zone_Name}}, {{$key->Woreda_Name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-12" style="display: none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Item <b style="color:red;">*</b></label>
                                                        <select class="select2 form-control" name="hiddenitem" id="hiddenitem">
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
                                                                <option value="UG(P)">UG(P)</option>
                                                                <option value="UG(NP)">UG(NP)</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-12" style="display:none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Proccess Type</label>
                                                        <select class="select2 form-control" name="coffeeproccesstype" id="coffeeproccesstype" data-placeholder="Proccess type">
                                                                <option selected disabled  value=""></option>
                                                                <option value="Washed">Washed</option>
                                                                <option value="UnWashed">UnWashed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-12" style="display: none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">Unit Code</label>
                                                        <select class="select2 form-control" name="coffeeunitcode" id="coffeeunitcode" data-placeholder="Unit Code">
                                                                <option selected disabled  value=""></option>
                                                                @foreach ($uom as $key)
                                                                    <option value="{{ $key->id }}">{{ $key->Name }}</option>
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
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                                        <label strong style="font-size: 14px;" id="docfslabel">document# <b style="color:red;">*</b></label>
                                                        <div class="input-group">
                                                            <input type="text" placeholder="" class="form-control" name="documentnumber" id="documentnumber" readonly/>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-12">
                                            <div class="row">
                                                    <div class="col-xl-12 col-lg-12" id="requesteditemadd">
                                                        <label strong style="font-size: 14px;" id="requesteditemlabeladd">Requested item</label>
                                                            <div class="scroll scrdiv" style="overflow-y:scroll;height:15rem;">
                                                                <table id="requesteditemdatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
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
                                        
                                    </div>
                                    <!-- start of item Row -->
                                    
                                    <div class="row" id="itemrow">
                                        <div class="col-xl-4 col-lg-12" id="supllierdiv">
                                                <div class="divider divider-info">
                                                    <div class="divider-text">Suppliers</div>
                                                </div>
                                            <div class="nav-vertical nav-horizontal scrollhor" style="overflow-y: scroll;">
                                                <ul class="nav nav-tabs nav-left flex-column" role="tablist" id="verticaledittab">
                                                
                                                </ul> 
                                            </div>
                                            <table  style="width:100%" id="customerorsuppliertables" class="table rtable mb-0">
                                                <tr>
                                                    <th>Supplier</th>
                                                    <th>Phone</th>
                                                    <th>Date</th>
                                                </tr>
                                                <tr>
                                                    <td style="width: 40%;">
                                                        <select class="select2 form-control" name="customerorsupplier" id="customerorsupplier" data-placeholder="supplier" onchange="customerorsuppliererror()">
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="customerorsupplier-error" class="rmerror"></strong>
                                                        </span>
                                                    </td>
                                                    <td style="width: 30%;">
                                                        <input type="text"  name="customerphone" id="customerphone" class="form-control" maxlength="10" placeholder="phone" onkeyup="customerphoneerroremove()"/>
                                                        <span class="text-danger">
                                                            <strong id="customerphone-error" class="rmerror"></strong>
                                                        </span>
                                                    </td>
                                                    <td style="width: 30%;"> <input type="text"  name="submitiondate" id="submitiondate" class="form-control flatpickr-basic dr" onclick="submitiondateremoverror()" placeholder="YYYY-MM-DD"/>
                                                        <input type="hidden" name="suplierflag" id="suplierflag" class="form-control"/>
                                                        <span class="text-danger">
                                                            <strong id="submitiondate-error" class="rmerror"></strong>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table>
                                            <table>
                                                <tr>
                                                    <td><button type="button" class="btn btn-success btn-sm addRow"><i data-feather='plus'></i>Add</button></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-xl-8 col-lg-12" id="productdiv">
                                            <div class="divider divider-info">
                                                    <div class="divider-text" id="dividertext">Commodity</div>
                                                </div>
                                            <div style="width:98%; margin-left:1%;">
                                                <div class="table-responsive scroll scrdiv">
                                                    <table id="dynamicTable" class="rtable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="reqtables">Request Item</th>
                                                            <th>Name</th>
                                                            <th>Description</th>
                                                            <th>Sample Amount</th>
                                                            <th>Remark</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <table id="dynamicTablecommdity" class="rtable mb-0" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th class="reqtables">Requested Commodity</th>
                                                                <th id="supplythid">Supply Commodity</th>
                                                                
                                                                <th>Crop Year</th>
                                                                <th>Process Type</th>
                                                                <th>Sample(KG)</th>
                                                                <th>Remark</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <table>
                                                        <tr>
                                                            <td><button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of Item Row -->
                                    
                                </div>
                            </div>
                        </div>  
                        <input type="hidden" placeholder="purchaseid" class="form-control" name="purchaseid" id="purchaseid" readonly/> 
                        <input type="hidden" placeholder="editflag" class="form-control" name="editflag" id="editflag" readonly/> 
                    </form>
                </div>
            <div class="modal-footer">
                <input type="hidden" placeholder="" class="form-control" name="currentsuppid" id="currentsuppid" readonly/>
                <input type="hidden" placeholder="" class="form-control" name="currentpsuppliersid" id="currentpsuppliersid" readonly/>
                <button id="savebutton" type="button" class="btn btn-outline-dark"><i id="savedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                <button id="closebutton" type="button"  class="btn btn-outline-danger" onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="evualtionModalScrollable" tabindex="-1" role="dialog" aria-labelledby="evualtionModalScrollableTitleadd" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evualtionModalScrollableTitleadd">Technical Evaluation</h5>
                    <div class="row">
                        <div style="text-align: right;" id="technicalstatusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body scroll scrdiv" id="card-block">
                    <form id="evualationRegister">
                        {{ csrf_field() }}
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Reference <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="evreference" id="evreference" data-placeholder="select reference">
                                                <option selected disabled  value=""></option>  
                                                <option value="Direct">Direct</option>
                                                <option value="RFQ">RFQ</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="reference-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Type <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="evtype" id="evtype" data-placeholder="select purchase type">
                                                <option selected disabled  value=""></option>  
                                                <option value="Goods">Goods</option>
                                                <option value="Commodity">Commodity</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="type-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 rfqclass">
                                            <label strong style="font-size: 14px;">Referene# <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="evrfq" id="evrfq" data-placeholder="select rfq">
                                            </select>
                                            <span class="text-danger">
                                                <strong id="rfq-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Date <b style="color:red;">*</b></label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="evdate" id="evdate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="date-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;">status <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="evestatus" id="evestatus" data-placeholder="select status">
                                                <option selected disabled  value=""></option>  
                                                <option value=" ">----</option>
                                                <option value="Approved">Approved</option>
                                                <option value="Not Approved">Not Approved</option>
                                                <option value="Re Sample">Re Sample</option>
                                                
                                            </select>
                                            <span class="text-danger">
                                                <strong id="evstatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;">status <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg" name="evseivesize" id="evseivesize" data-placeholder="select evseivesize">
                                                <option selected disabled  value=""></option>  
                                                <option value=" ">----</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                
                                            </select>
                                            <span class="text-danger">
                                                <strong id="evstatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Memo</label>
                                            <div class="input-group input-group-merge">
                                                <textarea  class="form-control" id="memo" placeholder="Write memo here" name="memo" ></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error"></strong>
                                            </span>
                                        </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="evrequesteditemadd">
                                                
                                                <label strong style="font-size: 14px;" id="evrequesteditemlabeladd">Requested item</label>
                                                <div class="scroll scrdiv" style="overflow-y:scroll;height:15rem;">
                                                    <table id="evrequesteditemdatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
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
                                    <!-- start of item Row -->
                                    
                                    <div class="row" id="evitemrow">
                                        <div class="col-xl-3 col-lg-12" id="supllierdiv">
                                                <div class="divider divider-info">
                                                    <div class="divider-text">Suppliers</div>
                                                </div>
                                            <div class="nav-vertical nav-horizontal scrollhor" style="overflow-y: scroll;">
                                                <ul class="nav nav-tabs nav-left flex-column" role="tablist" id="evverticaledittab">
                                                
                                                </ul> 
                                            </div>
                                            
                                        </div>
                                        <div class="col-xl-9 col-lg-12" id="productdiv">
                                            <div class="divider divider-info">
                                                    <div class="divider-text" id="evdividertext">Products</div>
                                                </div>
                                            <div style="width:98%; margin-left:1%;">
                                                <div class="table-responsive scroll scrdiv">
                                                    <table id="evdynamicTable" class="rtable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Request Item</th>
                                                            <th>Supplier Item</th>
                                                            <th>Description</th>
                                                            <th>Technical Aprroval</th>
                                                            <th>Remark</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <table id="evdynamicTablecommdity" class="rtable mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Requested Commodity</th>
                                                                <th>Supply Commodity</th>
                                                                <th>Crop Year</th>
                                                                <th>Process Type</th>
                                                                <th>Grade</th>
                                                                <th>Seive size</th>
                                                                <th>Moisture</th>
                                                                <th>Cup value</th>
                                                                <th>Row value</th>
                                                                <th>Score</th>
                                                                <th>Status</th>
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
                                    
                                </div>
                            </div>
                        </div>  
                        <input type="hidden" placeholder="evpurchaseid" class="form-control" name="evpurchaseid" id="evpurchaseid" readonly/> 
                        <input type="hidden" placeholder="editflag" class="form-control" name="eveditflag" id="eveditflag" readonly/> 
                    </form>
                </div>
            <div class="modal-footer">
                <input type="hidden" placeholder="" class="form-control" name="evcurrentsuppid" id="evcurrentsuppid" readonly/>
                <button id="evsavebutton" type="button" class="btn btn-outline-dark"><i id="evsavedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                <button id="closebutton" type="button"  class="btn btn-outline-danger" onclick="purchasetablesrefresh()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- start of financialevualation modals  -->
    <div class="modal fade" id="financailevualtionModalScrollable" tabindex="-1" role="dialog" aria-labelledby="financailevualtionModalScrollableTitleadd" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="financailevualtionModalScrollableTitleadd">Financial Evaluation</h5>
                    <div class="row">
                        <div style="text-align: right;" id="financialstatusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body scroll scrdiv" id="card-block">
                    <form id="financailevualationRegister">
                        {{ csrf_field() }}
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Reference <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="financailevreference" id="financailevreference" data-placeholder="select reference">
                                                <option selected disabled  value=""></option>  
                                                <option value="Direct">Direct</option>
                                                <option value="RFQ">RFQ</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="reference-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Type <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="financailevtype" id="financailevtype" data-placeholder="select purchase type">
                                                <option selected disabled  value=""></option>  
                                                <option value="Goods">Goods</option>
                                                <option value="Commodity">Commodity</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="type-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 rfqclass">
                                            <label strong style="font-size: 14px;">Referene# <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="financailevrfq" id="financailevrfq" data-placeholder="select rfq">
                                            </select>
                                            <span class="text-danger">
                                                <strong id="rfq-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Date <b style="color:red;">*</b></label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="financailevdate" id="financailevdate" class="form-control flatpickr-basic dr" placeholder="YYYY-MM-DD"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="date-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" style="display: none;">
                                            <label strong style="font-size: 14px;">status <b style="color:red;">*</b></label>
                                            <select class="select2 form-control form-control-lg sr" name="financailevstatus" id="financailevstatus" data-placeholder="select status">
                                                <option selected disabled  value=""></option>  
                                                <option value="Approved">Approved</option>
                                                <option value="Not Approved">Not Approved</option>
                                                <option value="Re Sample">Re Sample</option>
                                                
                                            </select>
                                            <span class="text-danger">
                                                <strong id="evstatus-error" class="rmerror"></strong>
                                            </span>
                                        </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="financailevrequesteditemadd">
                                                <label strong style="font-size: 14px;" id="financailevrequesteditemlabeladd">Requested item</label>
                                                <div class="scroll scrdiv" style="overflow-y:scroll;height:10rem;">
                                                    <table id="financailevrequesteditemdatatables" class="display table-bordered table-striped table-hover dt-responsive mb-0">
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
                                    <!-- start of item Row -->
                                    
                                    <div class="row" id="evitemrow">
                                        <div class="col-xl-3 col-lg-12" id="supllierdiv">
                                                <div class="divider divider-info">
                                                    <div class="divider-text">Suppliers</div>
                                                </div>
                                            <div class="nav-vertical nav-horizontal scrollhor" style="overflow-y: scroll;">
                                                <ul class="nav nav-tabs nav-left flex-column" role="tablist" id="financailevverticaledittab">
                                                
                                                </ul> 
                                            </div>
                                            
                                        </div>
                                        <div class="col-xl-9 col-lg-12" id="productdiv">
                                            <div class="divider divider-info">
                                                    <div class="divider-text" id="financailevdividertext">Commodity</div>
                                                </div>
                                            <div style="width:98%; margin-left:1%;">
                                                <div class="table-responsive scroll scrdiv">
                                                    <table id="financailevdynamicTable" class="table rtable mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th class="financailevreqtables">Request Item</th>
                                                            <th>Name</th>
                                                            <th>Description</th>
                                                            <th>Financail Approval</th>
                                                            <th>Customer price</th>
                                                            <th>Proposed Price</th>
                                                            <th>Final Uprice</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                    <table id="financailevdynamicTablecommdity" class="rtable mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Requested Commodity</th>
                                                                <th>Supply Commodity</th>
                                                                
                                                                <th>Process Type</th>
                                                                <th>Crop Year</th>
                                                                <th>Feresula</th>
                                                                <th>Moisture</th>
                                                                <th>Quality Approval</th>
                                                                <th>Supplier Price</th>
                                                                <th>Proposed Price</th>
                                                                <th>Agreed Price</th>
                                                                <th>Is Agree</th>
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
                                    
                                </div>
                            </div>
                        </div>  
                        <input type="hidden" placeholder="financailevpurchaseid" class="form-control" name="financailevpurchaseid" id="financailevpurchaseid" readonly/> 
                        <input type="hidden" placeholder="financaileditflag" class="form-control" name="eveditflag" id="eveditflag" readonly/> 
                    </form>
                </div>
            <div class="modal-footer">
                <input type="hidden" placeholder="" class="form-control" name="financailevcurrentsuppid" id="financailevcurrentsuppid" readonly/>
                <button id="financailevsavebutton" type="button" class="btn btn-outline-dark"><i id="financailevsavedicon" class="fa-sharp fa-solid fa-floppy-disk"></i> <span>Save</span></button>
                <button id="closebutton" type="button"  class="btn btn-outline-danger" onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal"><i class="fa-regular fa-xmark"></i> Close</button>
            </div>
        </div>
        </div>
    </div>
    <!-- end of financialevualation modals  -->
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
                            <span id="messagespan"></span>
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

    <!-- add single supplier modal info modal-->
        <div class="modal modal-slide-in event-sidebar fade" id="singlesuppliermodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
            <div class="modal-dialog modal-dialog-scrollable sidebar-xl" style="width: 90%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Edit products for single suppliers</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <form id="singlesupplireform">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div style="width:98%; margin-left:1%;">
                                        <div class="table-responsive scroll scrdiv">
                                            <table id="supllierdynamicTable" class="table rtable mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Sample Amount</th>
                                                    <th>Remark</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <table id="supllierdynamicTablecommdity" class="table rtable mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Origin</th>
                                                        <th>Crop Year</th>
                                                        <th>Process Type</th>
                                                        <th>Sample Amount(kg)</th>
                                                        <th>Remark</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <table>
                                                <tr>
                                                    <input type="hidden" placeholder="" class="form-control" name="purchasesupplierid" id="purchasesupplierid" readonly="true"/>
                                                    <input type="hidden" placeholder="" class="form-control" name="purchaseevaultionid" id="purchaseevaultionid" readonly="true"/>
                                                    <input type="hidden" placeholder="" class="form-control" name="purchaseevaultiontype" id="purchaseevaultiontype" readonly="true"/>
                                                    <td><button type="button" name="supplersadds" id="supplersadds" class="btn btn-success btn-sm"><i data-feather='plus'></i>Add</button></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                            
                            <button id="suppliersave" type="button" class="btn btn-info">Save</button>
                            <button id="" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--/ add waited sales info modal-->
@endsection

@section('scripts')
<script type="text/javascript">
    var purtables='';
    var gblIndex=0;
    var i=0;
    var j=0;
    var m=0;
    var k=0;
    var m1=0;
    var index = 1; 
    var errorcolor="#ffcccc";
    var focustables='';
    $('#fiscalyear').on('change', function() {
        refereshtablesbytab();
    });
    function purchasetablesrefresh() {
        refereshtablesbytab();
    }
    function refereshtablesbytab() {
            var oTable = $('#purtables').dataTable();
            oTable.fnDraw(false);
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

    $('#prprintbutton').click(function(){
                var headerid=$('#recordIds').val();
                var id=$('#evalsupplierid').val();
                var link="/peattachemnt/"+headerid+"/"+id;
                window.open(link, 'Purchase request', 'width=1200,height=800,scrollbars=yes');
                //toastrMessage('info','Coming soon! We re actively developing this feature to enhance your experience','Coming soon!');
        });
    $('#changetopendingbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,1);
    });
    $('#verifybutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,2);
    });
    $('#authorizebutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,3);
    });
    $('#approvedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,4);
    });
    $('#prundorejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,5);
    });
    $('#reviewedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,6);
    });
    $('#undoreviewedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,7);
    });
    $('#financalevaulatingbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,8);
    });
    $('#financialapprovedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,9);
    });
    $('#financialconfirmedbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,10);
    });
    $('#financialapprovedafterconfirmbutton').click(function(){
        var id=$('#recordIds').val();
        confirmAction(id,11);
    });
    $('#prundovoidbuttoninfo').click(function(){ 
        var id=$('#recordIds').val();
        confirmAction(id,12);
    });
    function confirmAction(id,status) {
        var msg='--';
        var title='--';
        var buttontext='--';
        switch (status) {
            case 0:
                    msg='Are you sure do you want to back to pending this purchase evaluation';
                    title='Back';
                    buttontext='Back to pending';
                break;
                case 1:
                    msg='Are you sure do you want to Change To Pending';
                    title='Confirmation';
                    buttontext='Change To Pending';
                break;
                case 2:
                        msg='Are you sure do you want to verify this purchase evaluation';
                        title='Verify';
                        buttontext='Verify';
                break;
                case 3:
                    msg='Are you sure do you want change to start technical evaluation';
                    title='Confirmation';
                    buttontext='Start';
                break;
                case 4:
                    msg='Are you sure do you want To Finish Technical Evaluation';
                    title='Confirmation';
                    buttontext='Finished';
                break;
                case 5:
                    msg='Are you sure do you want to undo reject this purchase evaluation';
                    title='Undo Reject';
                    buttontext='Undo Reject';
                break;
                case 6:
                    msg='Are you sure do you want to review this purchase evaluation';
                    title='Review';
                    buttontext='Review';
                break;
                case 7:
                    msg='Are you sure do you want to undo review this purchase evaluation';
                    title='Undo Review';
                    buttontext='Undo Review';
                break;
                case 8:
                    msg='Are you sure do you want to change start Financial Evaluation';
                    title='Confirmation';
                    buttontext='Start';
                break;
                case 9:
                    msg='Are you sure do you want to Finish Financial Evaluation';
                    title='Confirmation';
                    buttontext='Finish';
                break;
                case 10:
                    msg='Are you sure do you wan to confirm';
                    title='Confirmation';
                    buttontext='Confirm';
                break;
                
                case 11:
                    msg='Are you sure do you want to approve evaluation';
                    title='Confirmation';
                    buttontext='Approve';
                break;  
                case 12:
                    msg='Are you sure do you want to undo void?';
                    title='Confirmation';
                    buttontext='Undo Void';
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
                        url:  "{{url('pevualationseaction')}}/" + id+'/'+status,
                        data: {_token: token},
                        success: function (resp) {
                            switch (resp.success) {
                                case 200:
                                    toastrMessage('success',resp.message,'success');
                                    $('#evalstatus').val(resp.status);
                                    showbuttondependonstat('fromaction',resp.doc,resp.status,resp.reference);
                                    setminilog(resp.actions);
                                    
                                    break;
                                    case 201:
                                        toastrMessage('error','Please fill all the technical feild evaluatins','Error');
                                    break;
                                    case 203:
                                        toastrMessage('error','Please fill all the sample amounts','Error');
                                    break;
                                    
                                    case 202:
                                        toastrMessage('error','Please add atleast one suppliers','Error');
                                    break;
                                    case 204:
                                        toastrMessage('error','Please Fill Status Feild','Error');
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
    function modalhider() {
            $('#docInfoModal').modal('hide');
            var fyear = $('#fiscalyear').val()||0;
            var oTable = $('#purtables').dataTable(); 
            oTable.fnDraw(false);
        
    }
    function showbuttondependonstat(from,pe,status,reference) {

        var technicalpermit=$('#technicalviewpermission').val();
        var financalpremit=$('#financialviewpermission').val();
        var feprogresspermit=$('#financialprogresspermission').val();
        
        var headerid=$('#recordIds').val();
        var id=$('#evalsupplierid').val();
        
        switch (status) {
            case 0:
                    $('#prvoidbuttoninfo').show();
                    $('#changetopendingbutton').show();
                    $('#prejectbuttoninfo').show();
                    $('#verifybutton').hide();
                    $('#backtodrfatbutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#evaulatesuppliers').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundovoidbuttoninfo').hide();
                    $('#backverifybutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#financialapprovedbutton').hide();
                    $('#financalevaulatingbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backtotebutton').hide();
                    $('#backverifybutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialconfirmedbutton').hide();
                    $('#tefailbtn').hide();
                    $('#fefailbtn').hide();
                    $('#financialapprovedafterconfirmbutton').hide();
                    switch (reference) {
                        case 'Direct':
                            $('#addeditrequestinition').show();
                            $('#addeditsuppliers').show();
                            $('#preditbutton').hide();
                            break;
                        default:
                            $('#addeditrequestinition').hide();
                            $('#addeditsuppliers').hide();
                            $('#preditbutton').show();
                            break;
                    }
                    $('#infoStatus').html('<span class="text-secondary font-weight-medium"><b> '+pe+' Draft</b>');
                break;
                case 1:
                    $('#prvoidbuttoninfo').show();
                    $('#backtodrfatbutton').show();
                    $('#changetopendingbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#verifybutton').show();
                    $('#approvedbutton').hide();
                    $('#authorizebutton').hide();
                    $('#evaulatesuppliers').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#backverifybutton').hide();
                    $('#prejectbuttoninfo').show();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#financialapprovedbutton').hide();
                    $('#financalevaulatingbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backtotebutton').hide();
                    $('#backverifybutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialconfirmedbutton').hide();
                    $('#financialapprovedafterconfirmbutton').hide();

                    $('#tefailbtn').hide();
                    $('#fefailbtn').hide();
                    
                    switch (reference) {
                        case 'Direct':
                            $('#addeditrequestinition').show();
                            $('#addeditsuppliers').show();
                            $('#preditbutton').hide();
                            break;
                        default:
                            $('#addeditrequestinition').hide();
                            $('#addeditsuppliers').hide();
                            $('#preditbutton').show();
                            break;
                    }
                    $('#infoStatus').html('<span class="text-warning font-weight-medium"><b> '+pe+' Pending</b>');
                break;
                case 2:
                    $('#prvoidbuttoninfo').show();
                    $('#prejectbuttoninfo').show();
                    $('#backtopendingbutton').show();
                    $('#evaulatesuppliers').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#backtodrfatbutton').hide();
                    $('#approvedbutton').hide();
                    $('#changetopendingbutton').hide();
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#backverifybutton').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#addeditrequestinition').hide();
                    $('#addeditsuppliers').hide();
                    $('#financialapprovedbutton').hide();
                    $('#financalevaulatingbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backtotebutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialconfirmedbutton').hide();
                    $('#financialapprovedafterconfirmbutton').hide();

                    $('#tefailbtn').hide();
                    $('#fefailbtn').hide();

                    switch (technicalpermit) {
                        case '1':
                                $('#authorizebutton').show();
                            break;
                    
                        default:
                            $('#authorizebutton').hide();
                            break;
                    }
                    $('#infoStatus').html('<span style="color:#4e73df;font-weight:bold;text-shadow;1px 1px 10px #4e73df"> '+pe+' Verify</span>');
                break;
                case 3:
                    $('#prejectbuttoninfo').show();
                    $('#prvoidbuttoninfo').show();
                    $('#financalevaulatingbutton').hide();
                    $('#changetopendingbutton').hide(); 
                    $('#verifybutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').hide();
                    $('#authorizebutton').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#addeditrequestinition').hide();
                    $('#addeditsuppliers').hide();
                    $('#financialapprovedbutton').hide();
                    $('#backtodrfatbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backtotebutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialapprovedafterconfirmbutton').hide();
                    $('#financialconfirmedbutton').hide();

                    $('#tefailbtn').hide();
                    $('#fefailbtn').hide();

                    switch (technicalpermit) {
                        case '1':
                                $('#evaulatesuppliers').show();
                                $('#backverifybutton').show();
                                $('#approvedbutton').show();
                                switch (from) {
                                    case 'fromaction':
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
                                        break;
                                }
                            break;
                    
                        default:
                                $('#evaulatesuppliers').hide();
                                $('#backverifybutton').hide();
                                $('#approvedbutton').hide();
                                
                            break;
                    }
                    $('#infoStatus').html('<span class="text-warning font-weight-medium"><b> '+pe+' Technical Evaluation is on progress</b>');
                break;
                case 4:
                    $('#prvoidbuttoninfo').show();
                    $('#prejectbuttoninfo').show();
                    $('#tefailbtn').show();
                    $('#changetopendingbutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#evaulatesuppliers').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#backtopendingbutton').hide();
                    $('#backverifybutton').hide();
                    $('#backtodrfatbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#addeditrequestinition').hide();
                    $('#addeditsuppliers').hide();
                    $('#financialapprovedbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backverifybutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialapprovedafterconfirmbutton').hide();
                    $('#financialconfirmedbutton').hide();
                    $('#fefailbtn').hide();
                    
                    switch (financalpremit) {
                            case '1':
                                    $('#financalevaulatingbutton').show();
                                break;
                            default:
                                    $('#financalevaulatingbutton').hide();
                                break;
                        }
                        switch (technicalpermit) {
                            case '1':
                                $('#backtotebutton').show();
                                break;
                        
                            default:
                                $('#backtotebutton').hide();
                                break;
                        }
                        
                    $('#infoStatus').html('<span class="text-primary font-weight-medium"><b> '+pe+' Technically Evualated</b>');
                break;
                case 12:
                    $('#prvoidbuttoninfo').show();
                    $('#prejectbuttoninfo').show();
                    $('#tefailbtn').show();
                    $('#changetopendingbutton').hide();
                    $('#prundovoidbuttoninfo').hide();   
                    $('#preditbutton').hide();
                    $('#verifybutton').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#evaulatesuppliers').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#backtopendingbutton').hide();
                    $('#backverifybutton').hide();
                    $('#backtodrfatbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#prundorejectbuttoninfo').hide();financalevaulatingbutton
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#addeditrequestinition').hide();
                    $('#addeditsuppliers').hide();
                    $('#financialapprovedbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backverifybutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialapprovedafterconfirmbutton').hide();
                    $('#financialconfirmedbutton').hide();
                    $('#fefailbtn').hide();
                    $('#tefailbtn').hide();
                    $('#financalevaulatingbutton').hide();
                        switch (technicalpermit) {
                            case '1':
                                $('#backtotebutton').show();
                                break;
                        
                            default:
                                $('#backtotebutton').hide();
                                break;
                        }
                        
                    $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' TE Failed</b>');
                break;

                case 5:
                    $('#prundovoidbuttoninfo').show();
                    $('#prejectbuttoninfo').hide();
                    $('#reviewedbutton').hide();
                    $('#undoreviewedbutton').hide();
                    $('#preditbutton').hide();
                    $('#prvoidbuttoninfo').hide();
                    $('#verifybutton').hide();
                    $('#evaulatesuppliers').hide(); 
                    $('#changetopendingbutton').hide();
                    $('#finevaulatesuppliers').hide();
                    $('#authorizebutton').hide();
                    $('#approvedbutton').hide();
                    $('#backtodrfatbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#backtopendingbutton').hide();
                    $('#backverifybutton').hide();
                    $('#prundorejectbuttoninfo').hide();
                    $('#addeditrequestinition').hide();
                    $('#addeditsuppliers').hide();
                    $('#financialapprovedbutton').hide();
                    $('#financalevaulatingbutton').hide();
                    $('#backtofebutton').hide();
                    $('#backtotebutton').hide();
                    $('#backverifybutton').hide();
                    $('#evaluationapprovedbutton').hide();
                    $('#prprintbutton').hide();
                    $('#financialapprovedafterconfirmbutton').hide();
                    $('#financialconfirmedbutton').hide();
                    $('#tefailbtn').hide();
                    $('#fefailbtn').hide();
                    $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' Void</b>');
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
                        $('#backverifybutton').hide();
                        $('#prejectbuttoninfo').show();
                        $('#evaulatesuppliers').hide();
                        $('#finevaulatesuppliers').hide();
                        $('#prundorejectbuttoninfo').hide();
                        $('#addeditrequestinition').hide();
                        $('#addeditsuppliers').hide();
                        $('#financialapprovedbutton').hide();
                        $('#financalevaulatingbutton').hide();
                        $('#backtebutton').hide();
                        $('#backverifybutton').hide();
                        $('#backtofebutton').hide();
                        $('#backtotebutton').hide();
                        $('#evaluationapprovedbutton').hide();
                        $('#prprintbutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();
                        $('#financialconfirmedbutton').hide();
                        $('#tefailbtn').hide();
                        $('#fefailbtn').hide();
                        $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' Review</b>');
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
                        $('#evaulatesuppliers').hide();
                        $('#finevaulatesuppliers').hide();
                        $('#backverifybutton').hide();
                        $('#prvoidbuttoninfo').hide();
                        $('#addeditrequestinition').hide();
                        $('#addeditsuppliers').hide();
                        $('#financialapprovedbutton').hide();
                        $('#financalevaulatingbutton').hide();
                        $('#backtofebutton').hide();
                        $('#backtotebutton').hide();
                        $('#evaluationapprovedbutton').hide();
                        $('#prprintbutton').hide(); 
                        $('#financialconfirmedbutton').hide();
                        $('#backtodrfatbutton').hide();
                        $('#changetopendingbutton').hide();
                        $('#reviewedbutton').hide();
                        $('#undoreviewedbutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();
                        $('#tefailbtn').hide();
                        $('#fefailbtn').hide();
                        $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' Rejected</b>');
                    break;
                    case 8:
                        $('#prejectbuttoninfo').show();
                        $('#prvoidbuttoninfo').show();
                        $('#changetopendingbutton').hide();
                        $('#backtodrfatbutton').hide();
                        $('#prprintbutton').hide();  
                        $('#approvedbutton').hide();
                        $('#prundorejectbuttoninfo').hide();
                        $('#verifybutton').hide();
                        $('#prundovoidbuttoninfo').hide();   
                        $('#preditbutton').hide();
                        $('#authorizebutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#evaulatesuppliers').hide();
                        $('#backverifybutton').hide();
                            
                        $('#addeditrequestinition').hide();
                        $('#addeditsuppliers').hide();
                        $('#reviewedbutton').hide(); 
                        $('#undoreviewedbutton').hide();
                        $('#financalevaulatingbutton').hide();
                        $('#backtofebutton').hide();
                        $('#evaluationapprovedbutton').hide();
                        $('#financialconfirmedbutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();
                        $('#tefailbtn').hide();
                        $('#fefailbtn').hide();
                        switch (financalpremit) {
                                    case '1':
                                            $('#backtotebutton').show();
                                            $('#finevaulatesuppliers').show();
                                            $('#financialapprovedbutton').show(); 
                                            switch (from) {
                                                case 'fromaction':
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
                                        $('#backtotebutton').hide();
                                        $('#finevaulatesuppliers').hide();
                                        $('#financialapprovedbutton').hide();
                                        break;
                                }
                        
                        $('#infoStatus').html('<span class="text-warning font-weight-medium"><b> '+pe+' Financial Evaluation is on progress</b>');
                    break;
                    case 9:
                        $('#backtofebutton').show();
                        $('#financialconfirmedbutton').show();
                        $('#evaluationapprovedbutton').hide();
                        $('#prejectbuttoninfo').show();
                        $('#prvoidbuttoninfo').show();
                        $('#fefailbtn').show();
                        $('#prprintbutton').hide(); 
                        $('#approvedbutton').hide();
                        $('#prundorejectbuttoninfo').hide();
                        $('#verifybutton').hide();
                        $('#prundovoidbuttoninfo').hide();   
                        $('#preditbutton').hide();
                        $('#authorizebutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#evaulatesuppliers').hide();
                        $('#finevaulatesuppliers').hide(); 
                        $('#backverifybutton').hide();
                        $('#addeditrequestinition').hide();
                        $('#addeditsuppliers').hide();
                        $('#financialapprovedbutton').hide();
                        $('#reviewedbutton').hide(); 
                        $('#undoreviewedbutton').hide(); 
                        $('#financalevaulatingbutton').hide();
                        $('#backtotebutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();
                        $('#backtodrfatbutton').hide();
                        $('#changetopendingbutton').hide();
                        $('#tefailbtn').hide();
                        
                            switch (financalpremit) {
                                case '1':
                                    $('#backtofebutton').show();
                                    break;
                            
                                default:
                                    $('#backtofebutton').hide();
                                    break;
                            }
                        $('#infoStatus').html('<span class="text-primary font-weight-medium"><b> '+pe+' Financially Evaluated</b>');
                    break;
                    case 13:
                        $('#backtofebutton').show();
                        $('#financialconfirmedbutton').hide();
                        $('#evaluationapprovedbutton').hide();
                        $('#prejectbuttoninfo').show();
                        $('#prvoidbuttoninfo').show();
                        $('#fefailbtn').hide();
                        $('#prprintbutton').hide(); 
                        $('#approvedbutton').hide();
                        $('#prundorejectbuttoninfo').hide();
                        $('#verifybutton').hide();
                        $('#prundovoidbuttoninfo').hide();   
                        $('#preditbutton').hide();
                        $('#authorizebutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#evaulatesuppliers').hide();
                        $('#finevaulatesuppliers').hide(); 
                        $('#backverifybutton').hide();
                        $('#addeditrequestinition').hide();
                        $('#addeditsuppliers').hide();
                        $('#financialapprovedbutton').hide();
                        $('#reviewedbutton').hide(); 
                        $('#undoreviewedbutton').hide(); 
                        $('#financalevaulatingbutton').hide();
                        $('#backtotebutton').hide();
                        $('#financialapprovedafterconfirmbutton').hide();
                        $('#backtodrfatbutton').hide();
                        $('#changetopendingbutton').hide();
                        $('#tefailbtn').hide();
                        
                            switch (financalpremit) {
                                case '1':
                                    $('#backtofebutton').show();
                                    break;
                            
                                default:
                                    $('#backtofebutton').hide();
                                    break;
                            }
                        $('#infoStatus').html('<span class="text-danger font-weight-medium"><b> '+pe+' FE Failed</b>');
                    break;
                    case 10:
                            $('#prvoidbuttoninfo').show();
                            $('#prejectbuttoninfo').show();
                            $('#backtofebutton').show(); 
                            $('#evaluationapprovedbutton').hide();
                            $('#backtodrfatbutton').hide();
                            $('#changetopendingbutton').hide();
                            $('#prprintbutton').hide(); 
                            $('#financialapprovedafterconfirmbutton').show();
                            $('#approvedbutton').hide();
                            $('#prundorejectbuttoninfo').hide();  
                            $('#verifybutton').hide();
                            $('#prundovoidbuttoninfo').hide();   
                            $('#preditbutton').hide();
                            $('#authorizebutton').hide();
                            $('#backtopendingbutton').hide();
                            $('#evaulatesuppliers').hide();
                            $('#finevaulatesuppliers').hide(); 
                            $('#backverifybutton').hide();
                            $('#addeditrequestinition').hide();
                            $('#addeditsuppliers').hide();
                            $('#financialapprovedbutton').hide();
                            $('#reviewedbutton').hide(); 
                            $('#undoreviewedbutton').hide(); 
                            $('#financalevaulatingbutton').hide();
                            $('#backtotebutton').hide();
                            $('#financialconfirmedbutton').hide();
                            $('#tefailbtn').hide();
                            $('#tefailbtn').hide();
                            $('#infoStatus').html('<span class="text-success font-weight-medium"><b> '+pe+' Confirmed </b>');
                    break;
                    case 11: 
                            $('#prejectbuttoninfo').show();
                            $('#prvoidbuttoninfo').show();
                            $('#evaluationapprovedbutton').hide();
                            $('#backtofebutton').hide();
                            $('#backtodrfatbutton').hide();
                            $('#changetopendingbutton').hide();
                            $('#prprintbutton').hide(); 
                            $('#financialapprovedafterconfirmbutton').hide();
                            $('#approvedbutton').hide();
                            $('#prundorejectbuttoninfo').hide();  
                            $('#verifybutton').hide();
                            $('#prundovoidbuttoninfo').hide();   
                            $('#preditbutton').hide();
                            $('#authorizebutton').hide();
                            $('#backtopendingbutton').hide();
                            $('#evaulatesuppliers').hide();
                            $('#finevaulatesuppliers').hide(); 
                            $('#backverifybutton').hide();
                            $('#addeditrequestinition').hide();
                            $('#addeditsuppliers').hide();
                            $('#financialapprovedbutton').hide();
                            $('#reviewedbutton').hide(); 
                            $('#undoreviewedbutton').hide(); 
                            $('#financalevaulatingbutton').hide();
                            $('#backtotebutton').hide();
                            $('#financialconfirmedbutton').hide();
                            $('#tefailbtn').hide();
                            $('#tefailbtn').hide();
                            $('#infoStatus').html('<span class="text-success font-weight-medium"><b> '+pe+' Approved </b>');
                    break;
            default:    
                        $('#prejectbuttoninfo').show();
                        $('#prvoidbuttoninfo').show(); 
                        $('#approvedbutton').hide();
                        $('#prundorejectbuttoninfo').hide();
                        $('#verifybutton').hide();
                        $('#prundovoidbuttoninfo').hide();   
                        $('#preditbutton').hide();
                        $('#authorizebutton').hide();
                        $('#backtopendingbutton').hide();
                        $('#evaulatesuppliers').hide();
                        $('#finevaulatesuppliers').hide(); 
                        $('#backverifybutton').hide();
                        $('#addeditrequestinition').hide();
                        $('#addeditsuppliers').hide();
                        $('#financialapprovedbutton').hide();
                        $('#reviewedbutton').hide(); 
                        $('#undoreviewedbutton').hide(); 
                        $('#financalevaulatingbutton').hide();
                        $('#backtofebutton').hide();
                        $('#evaluationapprovedbutton').show();
                        $('#backtotebutton').hide();
                        $('#prprintbutton').show(); 
                        $('#tefailbtn').hide();
                        $('#tefailbtn').hide();
                        $('#infoStatus').html('<span class="text-success font-weight-medium"><b> '+pe+' -- </b>');
                break;
        }
    }
    $('#purchasevoidbutton').click(function(){
        var form = $("#purchasevoidform");
        var formData = form.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('purchasevaliotionvoid') }}",
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
                    $('#prurchasevoidvoidmodal').modal('hide');
                    modalhider();
                    
                }
            }
        });
    });

    $('.filter-select').on('changed.bs.select', function() {
            var search = [];
            var selectedValues = $(this).val(); 
            var st= String(selectedValues); 
            var cleanedText = st.replace(/,/g, '');
            console.log('string ='+cleanedText);
            switch (cleanedText) {
                case '1':
                    var newValues = [0,1,2];
                    search.push.apply(search, newValues);
                    break;
                    case '2':
                    var newValues = [3,4];
                    search.push.apply(search, newValues);
                    break;
                    case '3':
                    var newValues = [8,9,10,11];
                    search.push.apply(search, newValues);
                    break;
                    
                    case '12':
                        var newValues = [0,1,2,3,4];
                        search.push.apply(search, newValues);
                    break;
                    case '13':
                        var newValues = [0,1,2,8,9,10,11];
                        search.push.apply(search, newValues);
                    break;
                    case '23':
                        var newValues = [3,4,8,9,10,11];
                        search.push.apply(search, newValues);
                    break;
                    case '123':
                        var newValues = [0,1,2,3,4,8,9,10,11];
                        search.push.apply(search, newValues);
                    break;
            
                default:
                    break;
            }
                    console.log('array='+search);
                    search = search.join('|');
                    console.log('se='+search);
                    purtables.column(9).search(search, true, false).draw();
            });
        $('#fefailbtn').click(function(){
            var id=$('#recordIds').val();
            $('#purchasevoidid').val(id);
            $('#voidtype').val('FEFAIL');
            $("#voidreason").val("");
            $("#messagespan").html("Are you sure do you want to fail technical evulation");
            $("#purchasevoidbutton").find('span').text("FE FAIL");
            $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#tefailbtn').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('TEFAIL');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to fail technical evulation");
        $("#purchasevoidbutton").find('span').text("TE FAIL");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#backtofebutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('FE');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to back to financial evualation?");
        $("#purchasevoidbutton").find('span').text("Back To FE");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#backtotebutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('TE');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to back to technical evualation?");
        $("#purchasevoidbutton").find('span').text("Back To TE");
        $('#prurchasevoidvoidmodal').modal('show');
    });

    $('#backverifybutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Verify');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to back to verify ?");
        $("#purchasevoidbutton").find('span').text("Back To Verify");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#backtodrfatbutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Draft');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to back to draft ?");
        $("#purchasevoidbutton").find('span').text("Back To Draft");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#backtopendingbutton').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('pending');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to back to pending");
        $("#purchasevoidbutton").find('span').text("Back to pending");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#prvoidbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Void');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to void?");
        $("#purchasevoidbutton").find('span').text("Void");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    $('#prejectbuttoninfo').click(function(){
        var id=$('#recordIds').val();
        $('#purchasevoidid').val(id);
        $('#voidtype').val('Reject');
        $("#voidreason").val("");
        $("#messagespan").html("Are you sure do you want to reject?");
        $("#purchasevoidbutton").find('span').text("Reject");
        $('#prurchasevoidvoidmodal').modal('show');
    });
    
    function clearvoiderror() {
        $('#voidreason-error').html('');
    }
    $('#addeditrequestinition').click(function(){
        $('#editflag').val('initation');
        $("#dynamicTable > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        $("#type option[value='Goods']").prop('disabled',true);
        $("#supplythid").html('Requested Commodity');
        $("#itemrow").show();
        $("#adds").show();
        $("#currentsuppid").val('0');
        $("#requesteditemadd").show();
        var id=$('#recordIds').val();
        var type='';
        var petype='';
        var rfqid='';
        var cropyear='';
        var peid=0;
        $('#purchaseid').val(id);
        $('#exampleModalScrollableTitleadd').html('Edit purchase Inititation');
        $("#reference option[value!=0]").prop('disabled',false);
        $('#commoditytype option[value!=0]').prop('disabled', false);
        $('#coffeesource option[value!=0]').prop('disabled', false);
        $('#coffestatus option[value!=0]').prop('disabled', false);
        $('#requestStation option[value!=0]').prop('disabled', false);
        $('#priority option[value!=0]').prop('disabled', false);
        $('#samplerequire option[value!=0]').prop('disabled', false);
        $('#memo').prop('readonly',false);
        $.ajax({
            type: "GET",
            url: "{{ url('peinitationedit') }}/"+id,
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
                            $("#supllierdiv").hide();
                            $("#productdiv").show();
                            $("#peinitationedit").show();
                            $("#supllierdiv").removeClass("col-xl-4 col-lg-12");
                            $("#productdiv").removeClass("col-xl-8 col-lg-12");
                            $("#productdiv").removeClass("col-xl-12 col-lg-12");
                            $("#productdiv").addClass("col-xl-12 col-lg-12");
                            $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
                            $("#savedicon").removeClass("fa-duotone fa-pen");
                            $("#savedicon").addClass("fa-duotone fa-pen");
                            $("#savebutton").find('span').text("Update");
                    },
            success: function (response) {
                    $.each(response.pr, function (indexInArray, valueOfElement) { 
                        $('#reference').select2('destroy');
                        $('#reference').val(valueOfElement.petype).select2();
                        $("#reference option[value!="+valueOfElement.petype+"]").prop("disabled", true);
                        $('#type').select2('destroy');
                        $('#type').val(valueOfElement.type).select2();
                        $('#itemtype').select2('destroy');
                        $('#itemtype').val(valueOfElement.itemtype).select2();
                        $('#memo').val(valueOfElement.memo);
                        
                        $('#commoditytype').select2('destroy');
                        $('#commoditytype').val(valueOfElement.commudtytype).select2();

                        $('#coffeesource').select2('destroy');
                        $('#coffeesource').val(valueOfElement.coffeesource).select2();

                        $('#coffestatus').select2('destroy');
                        $('#coffestatus').val(valueOfElement.coffestat).select2();

                        $('#requestStation').select2('destroy');
                        $('#requestStation').val(valueOfElement.store_id).select2();

                        $('#priority').select2('destroy');
                        $('#priority').val(valueOfElement.priority).select2();

                        $('#samplerequire').select2('destroy');
                        $('#samplerequire').val(valueOfElement.samplerequire).select2();

                        $("#type option[value!="+valueOfElement.type+"]").prop("disabled", true);
                        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true});
                        $('#date').val(valueOfElement.date);
                        type=valueOfElement.type;
                        petype=valueOfElement.petype;
                        rfqid=valueOfElement.rfq;
                        cropyear=valueOfElement.cropyear;
                        peid=valueOfElement.id;
                        switch (valueOfElement.status) {
                            case 0:
                                $('#statusdisplay').html('<span class="text-secondary font-weight-medium"><b>'+valueOfElement.documentumber+'</b> <b>Draft</b></span>');
                                break;
                            case 1:
                                $('#statusdisplay').html('<span class="text-warning font-weight-medium"><b>'+valueOfElement.documentumber+'</b> <b>Pending</b></span>');
                                break;
                            default:
                                $('#statusdisplay').html('<span class="text-primary font-weight-medium"><b>Verify</b></span>');
                                break;
                        }
                    });
                    
                    switch (type) {
                        case 'Goods':
                            $("#dynamicTable").show();
                            $("#dynamicTablecommdity").hide();
                            $('#dividertext').html('Goods');
                            $('#requesteditemlabeladd').html('Requested Goods');
                            itemlistappend(response.productlist);
                            break;
                        default:
                            $("#dynamicTablecommdity").show();
                            $("#dynamicTable").hide();
                            $('#dividertext').html('Commodity');
                            $('#requesteditemlabeladd').html('Requested Commodity');
                            commoditylistappendonedit(response.productlist,cropyear,response.pedatail);
                            break;
                    }
                    switch (petype) {
                        case 'Direct':
                            $('.reqtables').hide();
                            $('.rfqclass').hide();
                            $('#rfqdiv').hide();
                            
                            break;
                        default:
                            $('.reqtables').show();
                            $('.rfqclass').show();
                            $('#rfqdiv').show();
                            
                            break;
                    }
                    var tables='#requesteditemdatatables';
                    getrequesteditem(tables,peid,type,petype);
            }
        });
    });
    $('#preditbutton').click(function(){
        editpurchasevualtions();
    });
    $('#addeditsuppliers').click(function(){
        editpurchasevualtions();
    });
    $('#evaulatesuppliers').click(function(){
        evualatepurchasevualtions();
    });
    $('#finevaulatesuppliers').click(function(){
        fincancialevualatepurchasevualtions();
    });
    function fincancialevualatepurchasevualtions() {
        $("#financailevdynamicTable > tbody").empty();
        $("#financailevdynamicTablecommdity > tbody").empty();
        var id=$('#recordIds').val();
        $('#financailevpurchaseid').val(id);
        var type='';
        var petype='';
        var rfqid='';
        var cropyear='';
        var reference='';
        var peid=0;
        focustables='';
        $.ajax({
            type: "GET",
            url: "{{ url('tecevualatedit') }}/"+id,
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
                            $('#docInfoModal').modal('hide');
                            $('#financailevualtionModalScrollable').modal('show');
                            $("#financailevsavedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
                            $("#financailevsavedicon").removeClass("fa-duotone fa-pen");
                            $("#financailevsavedicon").addClass("fa-duotone fa-pen");
                            $("#financailevsavebutton").find('span').text("Update");
                    },
            success: function (response) {
                $.each(response.pr, function (index, value) { 
                    type=value.type;
                    petype=value.petype;
                    reference=value.petype;
                    rfqid=value.rfq;
                    cropyear=value.cropyear;
                    peid=value.id;
                    $('#financailevreference').select2('destroy');
                    $('#financailevreference').val(value.petype).select2();
                    $("#financailevreference option[value!="+value.petype+"]").prop("disabled", true);
                    $('#financailevtype').select2('destroy');
                    $('#financailevtype').val(value.type).select2();
                    $('#financailevrfq').select2('destroy');
                    $('#financailevrfq').val(value.itemtype).select2();
                    $("#financailevtype option[value!="+value.type+"]").prop("disabled", true);
                    
                    $('#financailevdate').val(value.date);
                    $('#financialstatusdisplay').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">'+value.documentumber+' Financial Evaluation on progress</span>');
                });
                financailevualationappendsupplierbtab(response.supplier);
                switch (petype) {
                    case 'Direct':
                        $('.rfqclass').hide();
                        switch (type) {
                            case 'Goods':
                                break;
                            default:
                                $("#financailevdynamicTablecommdity").show();
                                $("#financailevdynamicTable").hide();
                                $('#evdividertext').html('Commodity'); 
                                financailevualationcommoditylistappend(response.productlist);
                                break;
                        }
                        break;
                    default:
                        $('.rfqclass').show();
                        switch (type) {
                            case 'Goods':
                                
                                break;
                            default:
                                $("#financailevdynamicTablecommdity").show();
                                $("#financailevdynamicTable").hide();
                                $('#evdividertext').html('Commodity'); 
                                financailevualationcommoditylistappend(response.productlist);
                                break;
                        }
                        break;
                }
                var tables='#financailevrequesteditemdatatables';
                getrequesteditem(tables,peid,type,reference);
            }
            
        });
    }
    function evualatepurchasevualtions() {
        $("#evdynamicTable > tbody").empty();
        $("#evdynamicTablecommdity > tbody").empty();
        $("#evtype option[value!=0]").prop('disabled',false);
        var id=$('#recordIds').val();
        $('#evpurchaseid').val(id);
        var type='';
        var petype='';
        var rfqid='';
        var cropyear='';
        var reference='';
        var peid=0;
        focustables='';
        $.ajax({
            type: "GET",
            url: "{{ url('evualatedit') }}/"+id,
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
                            $('#evualtionModalScrollable').modal('show');
                            $("#evsavedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
                            $("#evsavedicon").removeClass("fa-duotone fa-pen");
                            $("#evsavedicon").addClass("fa-duotone fa-pen");
                            $("#evsavebutton").find('span').text("Update");
                    },
            success: function (response) {
                $.each(response.pr, function (index, value) { 
                    type=value.type;
                    petype=value.petype;
                    reference=value.petype;
                    rfqid=value.rfq;
                    cropyear=value.cropyear;
                    peid=value.id;
                    $('#evreference').select2('destroy');
                    $('#evreference').val(value.petype).select2();
                    $("#evreference option[value!="+value.petype+"]").prop("disabled", true);
                    $('#evtype').select2('destroy');
                    $('#evtype').val(value.type).select2();
                    $('#evitemtype').select2('destroy');
                    $('#evitemtype').val(value.itemtype).select2();
                    $("#evtype option[value!="+value.type+"]").prop("disabled", true);
                    
                    $('#evdate').val(value.date);
                    $('#technicalstatusdisplay').html('<span style="color:#f6c23e;font-weight:bold;text-shadow;1px 1px 10px #f6c23e">'+value.documentumber+' Technical Evaluation on progress</span>');
                });
                evualationappendsupplierbtab(response.supplier);
                switch (petype) {
                    case 'Direct':
                        $('.rfqclass').hide();
                        switch (type) {
                            case 'Goods':
                                $("#evdynamicTablecommdity").hide();
                                $("#evdynamicTable").show();
                                $('#evdividertext').html('Goods'); 
                                evualationitemlistappend(response.productlist);
                                break;
                            default:
                                $("#evdynamicTablecommdity").show();
                                $("#evdynamicTable").hide();
                                $('#evdividertext').html('Commodity'); 
                                evualationcommoditylistappend(response.productlist);
                                break;
                        }
                        break;
                    default:
                        $('.rfqclass').show();
                        switch (type) {
                            case 'Goods':
                                $("#evdynamicTablecommdity").hide();
                                $("#evdynamicTable").show();
                                $('#evdividertext').html('Goods'); 
                                evualationitemlistappend(response.productlist);
                                break;
                            default:
                                $("#evdynamicTablecommdity").show();
                                $("#evdynamicTable").hide();
                                $('#evdividertext').html('Commodity'); 
                                evualationcommoditylistappend(response.productlist);
                                break;
                        }
                        break;
                }
                    var tables='#evrequesteditemdatatables';
                    getrequesteditem(tables,peid,type,reference);
            }
        });
    }
    function editpurchasevualtions() {
        var id=$('#recordIds').val();
        $('#purchaseid').val(id);
        $('#editflag').val('Editpe');
        $('#exampleModalScrollableTitleadd').html('Add/Edit Suppliers');
        $("#dynamicTable > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        $("#itemrow").show();
        $("#requesteditemadd").show();
        $("#adds").show();
        $("#supplythid").html('Supply Commodity');
        $('#date').prop('readonly',true);
        $('#memo').prop('readonly',true);
        
        $("#type option[value='Goods']").prop('disabled',false);
        $("#reference option[value!=0]").prop('disabled',false);
        $('#commoditytype option[value!=0]').prop('disabled', false);
        $('#coffeesource option[value!=0]').prop('disabled', false);
        $('#coffestatus option[value!=0]').prop('disabled', false);
        $('#requestStation option[value!=0]').prop('disabled', false);
        $('#priority option[value!=0]').prop('disabled', false);
        $('#samplerequire option[value!=0]').prop('disabled', false);

        var type='';
        var petype='';
        var rfqid='';
        var cropyear='';
        var peid=0;
        var reference='';
        focustables='';

        $.ajax({
            type: "GET",
            url: "{{ url('pedit') }}/"+id,
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
                            $("#supllierdiv").show();
                            $("#productdiv").show();
                            $("#supllierdiv").removeClass("col-xl-4 col-lg-12");
                            $("#productdiv").removeClass("col-xl-8 col-lg-12");
                            $("#productdiv").removeClass("col-xl-12 col-lg-12");
                            $("#supllierdiv").addClass("col-xl-4 col-lg-12");
                            $("#productdiv").addClass("col-xl-8 col-lg-12");
                            $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
                            $("#savedicon").removeClass("fa-duotone fa-pen");
                            $("#savedicon").addClass("fa-duotone fa-pen");
                            $("#savebutton").find('span').text("Update");
                    },
            success: function (response) {
                $.each(response.pr, function (indexInArray, valueOfElement) { 
                    $('#reference').select2('destroy');
                    $('#reference').val(valueOfElement.petype).select2();
                    $('#type').select2('destroy');
                    $('#type').val(valueOfElement.type).select2();
                    $('#itemtype').select2('destroy');
                    $('#itemtype').val(valueOfElement.itemtype).select2();
                    flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:false});
                    $('#date').val(valueOfElement.date);

                    $('#commoditytype').select2('destroy');
                    $('#commoditytype').val(valueOfElement.commudtytype).select2();

                    $('#coffeesource').select2('destroy');
                    $('#coffeesource').val(valueOfElement.coffeesource).select2();

                    $('#coffestatus').select2('destroy');
                    $('#coffestatus').val(valueOfElement.coffestat).select2();

                    $('#requestStation').select2('destroy');
                    $('#requestStation').val(valueOfElement.store_id).select2();

                    $('#priority').select2('destroy');
                    $('#priority').val(valueOfElement.priority).select2();
                    
                    $('#samplerequire').select2('destroy');
                    $('#samplerequire').val(valueOfElement.samplerequire).select2();

                    $("#reference option[value!="+valueOfElement.petype+"]").prop("disabled", true);
                    $("#type option[value!="+valueOfElement.type+"]").prop("disabled", true);
                    $('#commoditytype option[value!="'+valueOfElement.commudtytype+'"]').prop('disabled', true);
                    $('#coffeesource option[value!="'+valueOfElement.coffeesource+'"]').prop('disabled', true);
                    $('#coffestatus option[value!="'+valueOfElement.coffestat+'"]').prop('disabled', true);
                    $('#requestStation option[value!="'+valueOfElement.store_id+'"]').prop('disabled', true);
                    $('#priority option[value!="'+valueOfElement.priority+'"]').prop('disabled', true);
                    $('#samplerequire option[value!="'+valueOfElement.samplerequire+'"]').prop('disabled', true);

                    type=valueOfElement.type;
                    petype=valueOfElement.petype;
                    reference=valueOfElement.petype;
                    rfqid=valueOfElement.rfq;
                    cropyear=valueOfElement.cropyear;
                    peid=valueOfElement.id;
                    switch (valueOfElement.status) {
                        case 0:
                            $('#statusdisplay').html('<span class="text-secondary font-weight-medium"><b>'+valueOfElement.documentumber+' Draft</b></span>');
                            break;
                        case 1:
                            $('#statusdisplay').html('<span class="text-warning font-weight-medium"><b>'+valueOfElement.documentumber+'<b>Pending</b></span>');
                            break;
                        default:
                            $('#statusdisplay').html('<span class="text-primary font-weight-medium"><b>'+valueOfElement.documentumber+' Verify</b></span>');
                            break;
                    }
                });
                appendsupplierbtab(response.supplier); // to append the supplier tab
                setsupplier(response.supplier,response.rfqsupplier); // to set customer supplier options
                appendrequestcommodity(response.productinitation,type,reference);
                    switch (petype) {
                        case 'Direct':
                            $('.rfqclass').show();
                            $('#rfq').empty();
                            $('#rfqdiv').hide();
                            
                            switch (type) {
                                    case 'Goods':
                                        $("#dynamicTable").show();
                                        $("#dynamicTablecommdity").hide();
                                        $('#dividertext').html('Goods');
                                        itemlistappend(response.productlist);
                                        break;
                                    default:
                                        $('.reqtables').show();
                                        $("#dynamicTablecommdity").show();
                                        $("#dynamicTable").hide();
                                        $('#dividertext').html('Commodity');
                                        commoditylistappendoneditforsuppliers(response.productlist,cropyear,'false');
                                        break;
                                }
                            
                            getallsuppliers();
                            break;
                        default:
                            $('.rfqclass').show();
                            $('#rfq').empty();
                                
                            $.each(response.rfq, function (index, value) { 
                                option = '<option selected value="'+value.id+'">'+value.rfq+'</option>';
                                $('#rfq').append(option);
                            });
                            $('#rfq').select2();
                            switch (type) {
                                case 'Goods':
                                    $("#dynamicTable").show();
                                    $("#dynamicTablecommdity").hide();
                                    $('#rfqdiv').hide();
                                    $('#dividertext').html('Goods');
                                    itemlistappend(response.productlist);
                                    break;
                                default:
                                    $("#dynamicTablecommdity").show();
                                    $('#rfqdiv').show();
                                    $("#dynamicTable").hide();
                                    $('#dividertext').html('Commodity');
                                    commoditylistappendonedit(response.productlist,cropyear,'false');
                                    break;
                            }
                            break;
                    }
                    
                    var tables='#requesteditemdatatables';
                    getrequesteditem(tables,peid,type,reference);
            },
            fail:function(jqXHR, textStatus, errorThrown){
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
                            toastrMessage('error','An unknown error occurred.'+textStatus,'Error');
                        break;
                }
            }
        });
    }
    function appendrequestcommodity(product,type,reference) {
        $('#requestedcommodity').empty();
        console.log('reference='+reference);
        console.log('type='+type);
        var option='<option disabled selected value=""></option>';
        switch (type) {
            case 'Goods':
                    $.each(product, function (index, value) { 
                            option+='<option value='+value.id+'>'+ value.item+' </option>';
                        });
                        $('#requestedcommodity').append(option).select2();
                break;
            
            default:
                $.each(product, function (index, value) { 
                        option+='<option value='+value.id+'>'+ value.RZW+' </option>'
                    });
                $('#requestedcommodity').append(option).select2();
                break;
        }
        
    }
    function  financailevualationappendsupplierbtab(suppliers) {
        $('#financailevverticaledittab').empty();
        var liopt='';
        var classval='';
        var customer='';
        var customercode='';
        var phone='';
        var dates='';
        var customername='';
        var suppaddpermission=$('#pevsupplieradd').val();
        var pevsupplieredit=$('#pevsupplieredit').val();
        $.each(suppliers, function (index, value) { 
            customer=value.customerid;
            customertext=value.suppliercode;
            phone=value.phone;
            dates=value.recievedate;
            customercode=value.suppliercode;
            customername=value.Name+' '+value.phone+' '+value.recievedate
            switch (index) {
                case 0:
                    classval="active";
                    break;
                default:
                    classval="";
                    break;
            }
            liopt+='<li class="nav-item" id="listof'+customer+'">'+
                    '<table>'+
                    '<tr>'+
                    '<td><a class="nav-link finacailevnavclick tabsupplier '+classval+'" id="fevsupplierid'+customer+'" data-customer="'+customer+'">@if(auth()->user()->can("Supplier-View"))'+customername+'@endif Code:'+customercode+'</a></td>'+
                    '</tr>'+
                    '</table>'+
                    '<input type="hidden" class="form-control evcustname'+customer+'" name="evsupplierow['+m1+'][evsupplier]" id="evcustName'+m1+'" value="'+customer+'">'+
                    '<input type="hidden" class="form-control evphone'+customer+'" name="evsupplierow['+m1+'][evphonenumber]" id="evphonenumber'+m1+'" value="'+phone+'">'+
                    '<input type="hidden" class="form-control evsubmitiondate'+customer+'" name="evsupplierow['+m1+'][evrecievedate]" id="evrecievedate'+m1+'" value="'+dates+'">'+
                '</li>';
        });
        $('#financailevverticaledittab').append(liopt);
    }
    function evualationappendsupplierbtab(suppliers) {
        $('#evverticaledittab').empty();
        var liopt='';
        var classval='';
        var customer='';
        var customercode='';
        var customername='';
        var phone='';
        var dates='';
        var suppaddpermission=$('#pevsupplieradd').val();
        var pevsupplieredit=$('#pevsupplieredit').val();

        $.each(suppliers, function (index, value) { 
            customer=value.customerid;
            customercode=value.suppliercode;
            phone=value.phone;
            dates=value.recievedate;
            switch (suppaddpermission) {
                case '1':
                    customername=value.Name+' '+value.phone+' '+value.recievedate
                    break;
                
                default:
                    switch (pevsupplieredit) {
                        case '1':
                                customername=value.Name+' '+value.phone+' '+value.recievedate
                            break;
                    
                        default:
                            customername='';
                            break;
                    }
                    break;
            }
            switch (index) {
                case 0:
                    classval="active";
                    break;
                default:
                    classval="";
                    break;
            }
            liopt+='<li class="nav-item" id="listof'+customer+'">'+
                    '<table>'+
                    '<tr>'+
                    '<td><a class="nav-link evnavclick tabsupplier '+classval+'" id="evsupplierid'+customer+'" data-customer="'+customer+'">@if(auth()->user()->can("Supplier-View"))'+customername+'@endif Code:'+customercode+'</a></td>'+
                    '</tr>'+
                    '</table>'+
                    '<input type="hidden" class="form-control evcustname'+customer+'" name="evsupplierow['+m1+'][evsupplier]" id="evcustName'+m1+'" value="'+customer+'">'+
                    '<input type="hidden" class="form-control evphone'+customer+'" name="evsupplierow['+m1+'][evphonenumber]" id="evphonenumber'+m1+'" value="'+phone+'">'+
                    '<input type="hidden" class="form-control evsubmitiondate'+customer+'" name="evsupplierow['+m1+'][evrecievedate]" id="evrecievedate'+m1+'" value="'+dates+'">'+
                '</li>';
        });

        $('#evverticaledittab').append(liopt);
    }
    function appendsupplierbtab(params) {
        
        $('#verticaledittab').empty();
        var liopt='';
        var classval='';
        var customer='';
        var customertext='';
        var phone='';
        var dates='';
        $.each(params, function (index, value) { 
            customer=value.customerid;
            phone=parseFloat(value.phone)==0?'':value.phone;
            dates=value.recievedate;
            customertext=value.Name+' '+phone+' '+value.recievedate;
            switch (index) {
                case 0:
                    classval="active";
                    break;
                default:
                    classval="";
                    break;
            }
            //liopt+='<li class="nav-item"><a class="nav-link tabsupplier '+classval+'" id="supplierid'+index+'" onclick="editsupplierdata('+value.psid+','+value.customerid+','+index+')" data-title="'+value.Name+'">'+value.Name+'</a></li>';
            ++m1;
            liopt+='<li class="nav-item" id="listof'+customer+'" data-supplier="'+customer+'">'+
                    '<table>'+
                    '<tr>'+
                    '<td><a class="nav-link navclick tabsupplier '+classval+'" id="supplierid'+customer+'" data-customer="'+customer+'">@if(auth()->user()->can("PE-Add") || auth()->user()->can("PE-Edit"))'+customertext+'@endif</a></td>'+
                    '<td><button type="button" id="editsupplier'+customer+'" class="btn btn-lignt btn-sm edit-supplier" data-customer="'+customer+'" data-phone="'+phone+'" data-date="'+dates+'"><i class="fa-solid fa-edit fa-lg"></i></button> </td>'+
                    '<td><button type="button" id="removesupplier'+customer+'" class="btn btn-lignt btn-sm remove-supplier" data-customer="'+customer+'"><i class="fa-solid fa-trash fa-lg"></i></button></td>'+
                    '</tr>'+
                    '</table>'+
                    '<input type="hidden" class="form-control custname'+customer+'" name="supplierow['+m1+'][supplier]" id="custName'+m1+'" value="'+customer+'">'+
                    '<input type="hidden" class="form-control phone'+customer+'" name="supplierow['+m1+'][phonenumber]" id="phonenumber'+m1+'" value="'+phone+'">'+
                    '<input type="hidden" class="form-control submitiondate'+customer+'" name="supplierow['+m1+'][recievedate]" id="recievedate'+m1+'" value="'+dates+'">'+
                '</li>';
        });
        $('#verticaledittab').append(liopt);
    }
    $('body').on('click', '.addRow', function() {
        var customer=$('#customerorsupplier').val()||0;
        var reference=$('#reference').val();
        var type=$('#type').val();
        var customertext=$('#customerorsupplier option:selected').text()||0;
        var phone=$('#customerphone').val()||0;
        var dates=$('#submitiondate').val()||0;
        var liopt='';
        var classval='';
        var index=0;
        customertext=customertext+' '+phone+' '+dates;
        var count = $('#verticaledittab li').length;
        if(parseFloat(count)<1){
                    if(customer==0){
                        $('#customerorsupplier-error').html('supplier is required');
                    } 
                    if(dates==0){
                        $('#submitiondate-error').html('Date is required');
                    } else{
                        var supplier=$('#supplierid'+customer).text();
                        var suplierflag=$('#suplierflag').val()||0;
                        if (supplierexist(customer)) {
                            toastrMessage('error','Supplier already exists','Error');
                            }
                            else{
                                listappending(customer,customertext,phone,dates);
                                switch (reference) {
                                    case 'Direct':
                                        getitemsinitiation(type);
                                        break;
                                    default:
                                        getitemsforeachsupplers(customer);
                                        break;
                                }
                                
                            }
                    }
        } else{
            toastrMessage('error','Impossible to add more than one supllier','Error!');
        }
    });
        
    function listappending(customer,customertext,phone,dates){
        var liopt='';
        var classval='';
        var index=0;
        ++m1;
        liopt='<li class="nav-item" id="listof'+customer+'" data-supplier="'+customer+'" >'+
            '<table>'+
            '<tr>'+
            '<td><a class="nav-link navclick tabsupplier'+classval+'" id="supplierid'+customer+'" data-customer="'+customer+'">'+customertext+'</a></td>'+
            '<td><button type="button" id="editsupplier'+customer+'" class="btn btn-lignt btn-sm edit-supplier" data-customer="'+customer+'" data-phone="'+phone+'" data-date="'+dates+'"><i class="fa-solid fa-edit fa-lg"></i></button> </td>'+
            '<td><button type="button" id="removesupplier'+customer+'" class="btn btn-lignt btn-sm remove-supplier" data-customer="'+customer+'"><i class="fa-solid fa-trash fa-lg"></i></button></td>'+
            '</tr>'+
            '</table>'+
            '<input type="hidden" class="form-control custname'+customer+'" name="supplierow['+m1+'][supplier]" id="custName'+m1+'" value="'+customer+'">'+
            '<input type="hidden" class="form-control phone'+customer+'" name="supplierow['+m1+'][phonenumber]" id="phonenumber'+m1+'" value="'+phone+'">'+
            '<input type="hidden" class="form-control submitiondate'+customer+'" name="supplierow['+m1+'][recievedate]" id="recievedate'+m1+'" value="'+dates+'">'+
        '</li>';
        $('#verticaledittab').append(liopt);
        $('#customerorsupplier').select2('destroy');
        $('#customerorsupplier').val(null).select2();
        $('#select2-customerorsupplier-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        $('#customerphone').val('');
        $('#submitiondate').val('');
        $(".tabsupplier").removeClass("active");
        $("#supplierid"+customer).addClass("active");
        $('#currentsuppid').val(customer);
        $('#suplierflag').val('');
        console.log('customer='+customer);
    }
    function supplierexist(name) {
                var exists = false;
                var listlength=$('#verticaledittab li').length;
                switch (listlength) {
                    case 0:
                        exists = false;
                        break;
                    default:
                            $('#verticaledittab li').each(function() {
                                if ($(this).data('supplier') == name) {
                                    exists = true;
                                    return false; // Exit loop if found
                                }
                            });
                        break;
                }
                return exists;
            }
    function getitemsinitiation(type) {
        var id=$('#purchaseid').val();
        $('#editflag').val('Initiation');
        $.ajax({
            type: "GET",
            url: "{{ url('getinitiationdata') }}/"+id+"/"+type,
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
                switch (type) {
                    case 'Goods':
                        itemlistappend(response.productlist);
                        $("#dynamicTable").show();
                        $("#dynamicTablecommdity").hide();
                        break;
                    default:
                        commoditylistappendonadd(response.productlist,'');
                        $("#dynamicTable").hide();
                        $("#dynamicTablecommdity").show();
                        break;
                }
            }
        });
    }
    function getitemsforeachsupplers(customer){
            $('#editflag').val('Editpe');
            var rfq=$('#rfq').val();
            var type='';
            var cropyear='';
            $.ajax({
                type: "GET",
                url: "{{ url('getprequestdata') }}/"+rfq,
                        beforeSend: function (jqXHR, settings) {
                            
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
                    $.each(response.purchase, function (index, value) { 
                            $('#type').select2('destroy');
                            $('#type').val(value.type).select2();
                            type=value.type;
                            cropyear=value.cropyear;
                        });
                        
                switch (type) {
                        case 'Goods':
                            itemlistappend(response.productlist);
                            $("#dynamicTable").show();
                            $("#dynamicTablecommdity").hide();
                            break;
                        default:
                            commoditylistappendonadd(response.productlist,cropyear);
                            $("#dynamicTable").hide();
                            $("#dynamicTablecommdity").show();
                            break;
                    }
                },
                    fail:function(jqXHR, textStatus, errorThrown){
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
                                toastrMessage('error','An unknown error occurred.'+textStatus,'Error');
                            break;
                    }
                }
            });
    }
    
$(document).on('click', '.navclick', function(){
    var customer=$(this).data("customer");
    $(".tabsupplier").removeClass("active");
    $("#supplierid"+customer).addClass("active"); 
    $(".dynamic-added").hide();
    $(".dynamic-commudity").hide();
    $(".supp-"+customer).show();
    $("#currentsuppid").val(customer);
    firstpagerenumberFields(customer);

    console.log('nav link is clicked customer='+customer);
});

$(document).on('click', '.finacailevnavclick', function(){
    var customer=$(this).data("customer");
    $(".tabsupplier").removeClass("active");
    $("#fevsupplierid"+customer).addClass("active"); 
    $(".financailevdynamic-added").hide();
    $(".financialevdynamic-commudity").hide();
    $(".financialevsupp-"+customer).show();
    $("#financailevcurrentsuppid").val(customer);
    financialrenumberFields(customer);

});
$(document).on('click', '.evnavclick', function(){
    var customer=$(this).data("customer");
    $(".tabsupplier").removeClass("active");
    $("#evsupplierid"+customer).addClass("active"); 
    $(".evdynamic-added").hide();
    $(".evdynamic-commudity").hide();
    $(".evsupp-"+customer).show();
    $("#evcurrentsuppid").val(customer);
    renumberFields(customer);
    console.log('evnav link is clicked customer='+customer);
});
$(document).on('click', '.edit-supplier', function(){
    var customer=$(this).data("customer");
    var currentsuppid= $('#currentsuppid').val();
    var phones=$(this).data("phone");
    var date = $(this).data("date");
    console.log('customer='+customer);
    var currentdate=$('#currentdate').val();
    $('#customerorsupplier').select2('destroy');
    $('#customerorsupplier').val(currentsuppid).select2();
    $('#customerphone').val(phones);
    // $('#suplierflag').val(customer);

    flatpickr('#submitiondate', { dateFormat: 'Y-m-d',clickOpens:true,minDate:currentdate});
    $('#submitiondate').val(date);
    $('#select2-customerorsupplier-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
    $(".tabsupplier").removeClass("active");
    $("#supplierid"+customer).addClass("active");
    $(".dynamic-commudity").hide();
    $(".supp-"+customer).show();
});

$(document).on('click', '.remove-supplier', function(){
    var customer=$(this).data("customer");
    $('#listof'+customer).remove();
    $(".supp-"+customer).remove();
    var first = $("#verticaledittab li:first").attr("id");
    var number=separateNumberFromString(first);
    $(".tabsupplier").removeClass("active");
    $("#supplierid4054").addClass("active"); 
    $(".dynamic-commudity").hide();
    $(".supp-"+number).show();
    
});

    function separateNumberFromString(str){
        var number = str.match(/\d+/); // Using regex to find the number
        return number ? parseInt(number[0]) : null; // Return the number if found, exit
    }
    function customerorsuppliererror() {
        var customer=$('#customerorsupplier').val()||0;
        console.log('customer='+customer);
        var custphone = $('#customerorsupplier option[value="'+customer+'"]').attr('title');
        $('#customerphone').val(custphone);
        $('#customerorsupplier-error').html('');
    }
    function customerphoneerroremove() {
        $('#customerphone-error').html('');
    }
    function submitiondateremoverror() {
        $('#submitiondate-error').html('');
    }
    
    function itemlistappend(product) {
        j=0;
        var supplierid=0;
        var psid=0;
        var sampleamount='';
        var description='';
        var supplierid=$('#currentsuppid').val()||0;
        var reference=$('#reference').val();
        var editflag=$('#editflag').val();
        var id=$('#purchaseid').val()||0;
        $.each(product, function (index, value) { 
            ++j;
            ++m;
            switch (index) {
                case 0:
                    switch (id) { //to check add and edit
                        case 0:
                            console.log('dynamicadd='+supplierid);
                            break;
                        default:
                            switch (reference) {
                                case 'Direct':
                                    switch (editflag) {
                                        case 'Editpe':
                                            supplierid=value.customers_id;
                                            break;
                                        default:
                                            supplierid=supplierid;
                                            break;
                                    }
                                    break;
                                default:
                                    switch (editflag) {
                                        case 'Editpe':
                                            supplierid=value.customers_id;
                                            break;
                                    
                                        default:
                                            supplierid=supplierid;
                                            break;
                                    }
                                    
                                    break;
                            }
                            console.log('dynamicedit='+supplierid);
                            psid=value.peid;
                            sampleamount=value.sampleamount;
                            cropyear=value.cropyear;
                            description=value.description==null?'':value.description;
                            break;
                    }
                    break;
                default:
                        switch (id) {
                            case 0:
                                console.log('dynamicadd onother index='+supplierid);
                                break;
                            default:
                                switch (reference) {
                                    case 'Direct':
                                        switch (editflag) {
                                            case 'Editpe':
                                                supplierid=value.customers_id;
                                                break;
                                            default:
                                                supplierid=supplierid;
                                                break;
                                        }
                                        break;
                                    default:
                                        supplierid=value.customers_id;
                                        break;
                                }
                                sampleamount=value.sampleamount;
                                cropyear=value.cropyear;
                                description=value.description==null?'':value.description;
                                break;
                        }
                    break;
            }
            var remark=value.remark==null?'':value.remark;
            var tables='<tr id="row'+j+'" class="dynamic-added supp-'+supplierid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 17%;" class="rfqclass"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg egName" name="row['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 17%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td style="width: 30%;"><textarea placeholder="Write Description here..." class="form-control description" id="description'+m+'" name="row['+m+'][description]">'+description+'</textarea></td>'+
                '<td><input type="text" name="row['+m+'][sampleamount]" placeholder="Enter sample" id="sampleamount'+m+'"  value="'+sampleamount+'" class="quantity form-control" onkeyup="removesamplerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="width:6%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '</tr>';
            $("#dynamicTable tbody").append(tables);
            var options = $("#hiddenitem > option").clone();
            var options2 = '<option selected value="'+value.id+'">'+value.Code+', '+value.Name+','+value.SKUNumber+'</option>';
            var options3 = '<option selected value="'+value.id+'">'+value.Code+', '+value.Name+','+value.SKUNumber+'</option>';
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+value.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();
            $('#itemNameoriginSl'+m).empty();
            $('#itemNameoriginSl'+m).append(options3);
            $('#itemNameoriginSl'+m).select2();
            $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });
        $(".dynamic-added").hide();
        $(".supp-"+supplierid).show();
        $("#currentsuppid").val(supplierid);
        $("#currentpsuppliersid").val(psid);
        $('#editflag').val('Editpe');
        firstpagerenumberFields(supplierid);
    }
    function commoditylistappendonadd(product,cropyear){

            var supplierid=$('#currentsuppid').val();
            var id=$('#purchaseid').val()||0;
            var reference=$('#reference').val();
            var editflag=$('#editflag').val();
            supplierid = supplierid ? parseFloat(supplierid) : 0;
            var sampleamount='';
            var description='';
            var supplyid='';
            var requestid='';
            var supploption='';
            var requestoption='';
            var firstsupl=0;
            var remark='';
            j=0;
            $.each(product, function (index, value) { 
                    ++j;
                    ++m;
                    switch (reference) {
                        case 'Direct':
                                requestoption=value.supplyorigin;
                                supploption=value.supplyorigin;
                                cropyear=value.cropyear;
                            break;
                    
                        default:
                                requestoption=value.requestedorigin;
                                supploption=value.requestedorigin;
                            break;
                    }
                    requestid=value.id;
                    supplyid=value.id;
                    remark=value.remark==null?'':value.remark;
                    description=value.description==null?'':value.description;
                var tables='<tr id="row'+j+'" class="dynamic-commudity supp-'+supplierid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 17%;" class="rfqclass"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg reqeName" name="row['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 17%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                
                '<td style="width: 7%;"><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td style="width: 7%;"><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                '<td><input type="text" name="row['+m+'][sampleamount]" placeholder="Sample amount" id="sampleamount'+m+'" value="'+sampleamount+'" class="sampleamount form-control" onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '</tr>';
                $("#dynamicTablecommdity > tbody").append(tables);
                var options = $("#hiddencommudity > option").clone();
                var cropyearoption=$("#cropYear > option").clone();
                var cropyearoption2='<option selected value="'+cropyear+'">'+cropyear+'</option>';
                var proccesstypeoption=$("#coffeeproccesstype > option").clone();

                var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
                var proccesstypeoption2='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';

                var options3='<option selected value="'+requestid+'">'+requestoption+'</option>';
                $('#itemNameSl'+m).empty();
                $('#itemNameSl'+m).append(options); 
                $("#itemNameSl"+m+" option[value='"+value.id+"']").remove();
                $('#itemNameSl'+m).append(options2);
                $('#itemNameSl'+m).select2();

                $('#itemNameoriginSl'+m).empty();
                $('#itemNameoriginSl'+m).empty();
                $('#itemNameoriginSl'+m).append(options3);
                $('#itemNameoriginSl'+m).select2();

                $('#coffeproccesstype'+m).append(proccesstypeoption);
                $("#coffeproccesstype"+m+" option[value='"+value.proccesstype+"']").remove();
                $('#coffeproccesstype'+m).append(proccesstypeoption2);
                $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
                
                $('#cropyear'+m).append(cropyearoption);
                $("#cropyear"+m+" option[value='"+value.cropyear+"']").remove();
                $('#cropyear'+m).append(cropyearoption2);
                $('#cropyear'+m).select2({placeholder: "Select crop year"});
                
                $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            });
        $(".dynamic-commudity").hide();
        $(".supp-"+supplierid).show();
        $("#currentsuppid").val(supplierid);
        $('#editflag').val('Editpe');
        firstpagerenumberFields(supplierid);
    }
    function commoditylistappendoneditforsuppliers(product,cropyear,exist) {
        var thcount = $('#dynamicTablecommdity thead tr th').length;
        console.log('thcountssss='+thcount);
        var newHeaders = ['<th>Sample(KG)</th>','<th>Remark</th>', '<th></th>'];
        switch (thcount) {
            case 8:
                $('#dynamicTablecommdity thead tr th').slice(-3).remove();
                break;
                case 7:
                    $('#dynamicTablecommdity thead tr th').slice(-2).remove();
                break;
            default:
                break;
        }
            for (var i = 0; i < newHeaders.length; i++) {
                $('#dynamicTablecommdity thead tr').append(newHeaders[i]);
            }
        j=0;
        var reference=$('#reference').val();
        var editflag=$('#editflag').val();
        var supplierid=$('#currentsuppid').val();
        supplierid = supplierid ? parseFloat(supplierid) : 0;
        var psid=0;
        var id=$('#purchaseid').val()||0;
        var sampleamount='';
        var description='';
        var supplyid='';
        var requestid='';
        var supploption='';
        var requestoption='';
        var remark='';
        var firstsupl=0;
        var disabledparameter='';
        var readonlyparamter='';
        switch (exist) {
            case true:
                readonlyparamter='readonly';
                disabledparameter='disabled';
                break;
        
            default:
                break;
        }
        $.each(product, function (index, value) { 
            ++j;
            ++m;
            switch (index) {
                case 0:
                    switch (editflag) {
                        case 'Editpe':
                            firstsupl=value.customers_id;
                            break;
                        
                        default:
                            break;
                    }
                    switch (reference) {
                                case 'Direct':
                                    switch (editflag) { // first saved in initation now in pe
                                        case 'Editpe':
                                            supplierid=value.customers_id;
                                            requestoption=value.requestedorigin;
                                            supploption=value.supplyorigin;
                                            requestid=value.requestedid;
                                            supplyid=value.id;
                                            break;
                                        default: // this from initiation data
                                                supplierid=supplierid;
                                                requestoption=value.supplyorigin;
                                                supploption=value.supplyorigin;
                                                requestid=value.id;
                                                supplyid=value.id;
                                            break;
                                    }
                                    break;
                                default:
                                    supplierid=value.customers_id;
                                    requestoption=value.requestedorigin;
                                    supploption=value.supplyorigin;
                                    requestid=value.requestedid;
                                    supplyid=value.id;
                                    break;
                            }
                    break;
                default:
                    switch (reference) {
                                case 'Direct':
                                    switch (editflag) { // first saved in initation now in pe
                                        case 'Editpe':
                                            supplierid=value.customers_id;
                                            requestoption=value.requestedorigin;
                                            supploption=value.supplyorigin;
                                            requestid=value.requestedid;
                                            supplyid=value.id;
                                            break;
                                        default: // this from initiation data
                                                supplierid=supplierid;
                                                requestoption=value.supplyorigin;
                                                supploption=value.supplyorigin;
                                                requestid=value.id;
                                                supplyid=value.id;
                                            break;
                                    }
                                    
                                    break;
                                default:
                                    supplierid=value.customers_id;
                                    requestoption=value.requestedorigin;
                                    supploption=value.supplyorigin;
                                    requestid=value.requestedid;
                                    supplyid=value.id;
                                    break;
                            }
                    
                    break;
            }

            remark=value.remark==null?'':value.remark;
            description=value.description==null?'':value.description;
            cropyear=value.cropyear;
            sampleamount=value.sampleamount==0?'':value.sampleamount;
            var tables='<tr id="row'+j+'" class="dynamic-commudity supp-'+supplierid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 17%;" class="rfqclass"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg reqeName" name="row['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 15%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td style="width: 15%;"><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td style="width: 15%;"><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                '<td><input type="text" name="row['+m+'][sampleamount]" placeholder="Sample amount" id="sampleamount'+m+'" value="'+sampleamount+'" class="sampleamount form-control" onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);" '+readonlyparamter+'/></td>'+
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control remark" id="remark'+m+'" name="row['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="text-align:center;background-color:#efefef;"><button '+disabledparameter+' type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;" reonly></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][pevid]" id="pevid'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+value.cid+'"/></td>'+
                '</tr>';
            $("#dynamicTablecommdity > tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var cropyearoption2='<option selected value="'+cropyear+'">'+cropyear+'</option>';

            var proccesstypeoption=$("#coffeeproccesstype > option").clone();

            var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
            var proccesstypeoption2='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';

            var options3='<option selected value="'+requestid+'">'+requestoption+'</option>';
            
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+value.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();

            $('#itemNameoriginSl'+m).empty();
            $('#itemNameoriginSl'+m).empty();
            $('#itemNameoriginSl'+m).append(options3);
            $('#itemNameoriginSl'+m).select2();

            $('#coffeproccesstype'+m).append(proccesstypeoption);
            $("#coffeproccesstype"+m+" option[value='"+value.proccesstype+"']").remove();
            $('#coffeproccesstype'+m).append(proccesstypeoption2);
            $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
            
            $('#cropyear'+m).append(cropyearoption);
            $("#cropyear"+m+" option[value='"+value.cropyear+"']").remove();
            $('#cropyear'+m).append(cropyearoption2);
            $('#cropyear'+m).select2({placeholder: "Select crop year"});
            
            switch (exist) {
                case true:
                    $("#cropyear"+m+" option[value!="+value.cropyear+"]").prop("disabled", true);
                    $("#coffeproccesstype"+m+" option[value!="+value.proccesstype+"]").prop("disabled", true);
                    $("#itemNameSl"+m+" option[value!="+value.id+"]").prop("disabled", true);
                    break;
            
                default:
                    break;
            }

            $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });
    
        switch (editflag) {
            case 'Editpe':
                $(".dynamic-commudity").hide();
                $(".supp-"+firstsupl).show();
        
                break;
        
            default:
                $(".dynamic-commudity").show();
                break;
        }
        
        $("#currentsuppid").val(firstsupl);
        firstpagerenumberFields(firstsupl);
    }
    function commoditylistappendonedit(product,cropyear,exist) {
        var thcount = $('#dynamicTablecommdity thead tr th').length;
        console.log('thcounttttt='+thcount);
        var newHeaders = ['<th>Remark</th>', '<th></th>'];
        switch (thcount) {
                case 8:
                    $('#dynamicTablecommdity thead tr th').slice(-3).remove();
                break;
                case 7:
                    $('#dynamicTablecommdity thead tr th').slice(-2).remove();
                break;
            default:
                break;
        }
        for (var i = 0; i < newHeaders.length; i++) {
                $('#dynamicTablecommdity thead tr').append(newHeaders[i]);
            }
        j=0;
        var reference=$('#reference').val();
        var editflag=$('#editflag').val();
        var supplierid=$('#currentsuppid').val();
        supplierid = supplierid ? parseFloat(supplierid) : 0;
        var psid=0;
        var id=$('#purchaseid').val()||0;
        var sampleamount='';
        var description='';
        var supplyid='';
        var requestid='';
        var supploption='';
        var requestoption='';
        var remark='';
        var firstsupl=0;
        var disabledparameter='';
        var readonlyparamter='';
        switch (exist) {
            case true:
                readonlyparamter='readonly';
                disabledparameter='disabled';
                break;
        
            default:
                    readonlyparamter='';
                    disabledparameter='';
                break;
        }
        $.each(product, function (index, value) { 
            ++j;
            ++m;
            switch (index) {
                case 0:
                    switch (editflag) {
                        case 'Editpe':
                            firstsupl=value.customers_id;
                            break;
                            
                        default:
                            break;
                    }
                    switch (reference) {
                                case 'Direct':
                                    switch (editflag) { // first saved in initation now in pe
                                        case 'Editpe':
                                            supplierid=value.customers_id;
                                            requestoption=value.requestedorigin;
                                            supploption=value.supplyorigin;
                                            requestid=value.requestedid;
                                            supplyid=value.id;
                                            break;
                                        default: // this from initiation data
                                                supplierid=supplierid;
                                                requestoption=value.supplyorigin;
                                                supploption=value.supplyorigin;
                                                requestid=value.id;
                                                supplyid=value.id;
                                            break;
                                    }
                                    break;
                                default:
                                    supplierid=value.customers_id;
                                    requestoption=value.requestedorigin;
                                    supploption=value.supplyorigin;
                                    requestid=value.requestedid;
                                    supplyid=value.id;
                                    break;
                            }
                    break;
                default:
                    switch (reference) {
                                case 'Direct':
                                    switch (editflag) { // first saved in initation now in pe
                                        case 'Editpe':
                                            supplierid=value.customers_id;
                                            requestoption=value.requestedorigin;
                                            supploption=value.supplyorigin;
                                            requestid=value.requestedid;
                                            supplyid=value.id;
                                            break;
                                        default: // this from initiation data
                                                supplierid=supplierid;
                                                requestoption=value.supplyorigin;
                                                supploption=value.supplyorigin;
                                                requestid=value.id;
                                                supplyid=value.id;
                                            break;
                                    }
                                    
                                    break;
                                default:
                                    supplierid=value.customers_id;
                                    requestoption=value.requestedorigin;
                                    supploption=value.supplyorigin;
                                    requestid=value.requestedid;
                                    supplyid=value.id;
                                    break;
                            }
                    
                    break;
            }

            remark=value.remark==null?'':value.remark;
            description=value.description==null?'':value.description;
            cropyear=value.cropyear;
            sampleamount=value.sampleamount==0?'':value.sampleamount;
            var tables='<tr id="row'+j+'" class="dynamic-commudity supp-'+supplierid+'">'+
                '<td style="text-align:center;width:1%;">'+j+'</td>'+
                '<td style="width: 17%;" class="rfqclass"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg reqeName" name="row['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 20%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                
                '<td style="width: 15%;"><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td style="width: 15%;"><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+

                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="text-align:center;background-color:#efefef; width:2%;"><button '+disabledparameter+' type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;" reonly></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][pevid]" id="pevid'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+value.cid+'"/></td>'+
                '</tr>';
            $("#dynamicTablecommdity > tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var cropyearoption2='<option selected value="'+cropyear+'">'+cropyear+'</option>';

            var proccesstypeoption=$("#coffeeproccesstype > option").clone();

            var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
            var proccesstypeoption2='<option selected value="'+value.proccesstype+'">'+value.proccesstype+'</option>';

            var options3='<option selected value="'+requestid+'">'+requestoption+'</option>';
            
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+value.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();

            $('#itemNameoriginSl'+m).empty();
            $('#itemNameoriginSl'+m).empty();
            $('#itemNameoriginSl'+m).append(options3);
            $('#itemNameoriginSl'+m).select2();

            $('#coffeproccesstype'+m).append(proccesstypeoption);
            $("#coffeproccesstype"+m+" option[value='"+value.proccesstype+"']").remove();
            $('#coffeproccesstype'+m).append(proccesstypeoption2);
            $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
            
            $('#cropyear'+m).append(cropyearoption);
            $("#cropyear"+m+" option[value='"+value.cropyear+"']").remove();
            $('#cropyear'+m).append(cropyearoption2);
            $('#cropyear'+m).select2({placeholder: "Select crop year"});
            
            switch (exist) {
                case true:
                    $("#cropyear"+m+" option[value!="+value.cropyear+"]").prop("disabled", true);
                    $("#coffeproccesstype"+m+" option[value!="+value.proccesstype+"]").prop("disabled", true);
                    $("#itemNameSl"+m+" option[value!="+value.id+"]").prop("disabled", true);
                    break;
            
                default:
                    break;
            }

            $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });
    
        switch (editflag) {
            case 'Editpe':
                $(".dynamic-commudity").hide();
                $(".supp-"+firstsupl).show();
        
                break;
        
            default:
                $(".dynamic-commudity").show();
                break;
        }
        
        $("#currentsuppid").val(firstsupl);
        firstpagerenumberFields(firstsupl);
    }
    
    function financailevualationcommoditylistappend(products){
        var supplierid=0;
        var sampleamount='';
        var description='';
        var cropyear='';
        var supplyid='';
        var requestid='';
        var supploption='';
        var requestoption='';
        var remark='';
        var description='';
        var tables='';
        var firstsupl=0;
        var j=0;
        var bagid=0;
        var isagreed=0;
        $.each(products, function (index, value) { 
                ++j;
                ++m;
                switch (index) {
                    case 0:
                        firstsupl=value.customers_id;
                        break;
                    default:
                        break;
                }
                
                supplierid=value.customers_id;
                cropyear=value.evaulationcropyear;
                requestid=value.requestedid;
                supplyid=value.woredaid;
                requestoption=value.requestedorigin;
                supploption=value.RZW;
                remark=value.fevremark==null?'':value.fevremark;
                description=value.description==null?'':value.description;
                isagreed=value.isagreed;
                tables='<tr id="row'+j+'" class="financialevdynamic-commudity financialevsupp-'+supplierid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 15%;" class="rfqclass"><select id="evitemNameoriginSl'+m+'" class="select2 form-control form-control-lg evalName" name="fevrow['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 15%;"><select id="evitemNameSl'+m+'" class="select2 form-control form-control-lg eName" name="fevrow['+m+'][evItemId]"></select></td>'+
                
                '<td><select id="evcoffeproccesstype'+m+'" class="select2 form-control evcoffeproccesstype" onchange="sourceVal(this)" name="fevrow['+m+'][evproccesstype]"></select></td>'+
                '<td style="width: 5%;"><select id="evcropyear'+m+'" class="select2 form-control evcropyear" onchange="sourceVal(this)" name="fevrow['+m+'][evcropyear]"></select></td>'+

                '<td><input type="text" name="fevrow['+m+'][bagamount]" placeholder="Feresula" id="bagamount'+m+'" value="1" class="bagamount form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][moisture]" placeholder="moisture" id="moisture'+m+'" value="'+value.evmoisture+'" class="moisture form-control" onkeypress="return ValidateNum(event);" readonly/></td>'+
                '<td><input type="text" name="fevrow['+m+'][qualityapproval]" placeholder="quality approval" id="qualityapproval'+m+'" value="'+value.evstatus+'" class="cupvalue form-control" readonly/></td>'+
                
                '<td><input type="text" name="fevrow['+m+'][customerprice]" placeholder="Supplier Price" id="customerpreice'+m+'" value="'+value.customerprice+'" class="customerpreice form-control" onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+m+'][proposedprice]" placeholder="Proposed Price" id="proposedprice'+m+'" value="'+value.proposedprice+'" class="proposedprice form-control" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="fevrow['+m+'][finalprice]" placeholder="Final price" id="finalprice'+m+'" value="'+value.finalprice+'" class="finalprice form-control" onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td style="text-align:center;"><div class="custom-control custom-control-primary custom-checkbox"><input type="checkbox" onclick="assignValue(this)" class="custom-control-input" id="colorCheck'+m+'"/><label class="custom-control-label" for="colorCheck'+m+'"></label></div></td>'+
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="fevrow['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="display:none;"><input type="hidden" name="fevrow['+m+'][vals]" id="evvals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="fevrow['+m+'][evsupp]" id="fevsupp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '<td style="display:none;"><input type="text" name="fevrow['+m+'][pevid]" id="pevid'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+value.pevid+'"/></td>'+
                '<td style="display:none;"><input type="text" name="fevrow['+m+'][isagreed]" id="isagreed'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+value.isagreed+'"/></td>'+
                '</tr>';
            $("#financailevdynamicTablecommdity > tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var bagamountoptions=$("#coffeeunitcode > option").clone();

            var cropyearoption=$("#cropYear > option").clone();
            var statusoption=$("#financailevstatus > option").clone();
            var statusoption2='<option selected value="'+value.fevstatus+'">'+value.fevstatus+'</option>';
            var cropyearoption2='<option selected value="'+cropyear+'">'+cropyear+'</option>';
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
            var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
            var proccesstypeoption2='<option selected value="'+value.evaulationproccesstype+'">'+value.evaulationproccesstype+'</option>';
            var options3='<option selected value="'+requestid+'">'+requestoption+'</option>';
            
            switch (isagreed) {
            case 1:
                $('#finalprice'+m).attr('readonly', true);
                $('#colorCheck'+m).prop('checked', true);
                break;
                
            default:
                    $('#finalprice'+m).attr('readonly', false);
                    $('#colorCheck'+m).prop('checked', false);
                break;
        }
            $('#evitemNameSl'+m).empty();
            
            $('#evitemNameSl'+m).append(options2);
            $('#evitemNameSl'+m).select2();

            $('#evitemNameoriginSl'+m).empty();
            $('#evitemNameoriginSl'+m).append(options3);
            $('#evitemNameoriginSl'+m).select2();

            $('#evcoffeproccesstype'+m).append(proccesstypeoption2);
            $('#evcoffeproccesstype'+m).select2({placeholder: "Select proccess type"});

            $('#evcropyear'+m).append(cropyearoption2);
            $('#evcropyear'+m).select2({placeholder: "Select crop year"});
            
            $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });
        
        $(".financialevdynamic-commudity").hide();
        $(".financialevsupp-"+firstsupl).show();
        $("#financailevcurrentsuppid").val(firstsupl);
        financialrenumberFields(firstsupl);
    }

    function  evualationcommoditylistappend(products) {
        console.log('dynamic technical append');
        var supplierid=0;
        var sampleamount='';
        var description='';
        var cropyear='';
        var supplyid='';
        var requestid='';
        var supploption='';
        var requestoption='';
        var remark='';
        var grade='';
        var screensieve='';
        var description='';
        var firstsuppler=0;
        var j=0;
        $.each(products, function (index, value) { 
                ++j;
                ++m;
                switch (index) {
                case 0:
                    firstsuppler=value.customers_id;
                    break;
                    
                default:
                    break;
            }
                supplierid=value.customers_id;
                cropyear=value.evaulationcropyear;
                requestid=value.requestedid;
                supplyid=value.woredaid;
                requestoption=value.requestedorigin;
                supploption=value.RZW;
                remark=value.tecremark==null?'':value.tecremark;
                grade=value.grade==null?'':value.grade;
                screensieve=value.screensieve==null?'':value.screensieve;
                description=value.description==null?'':value.description;
            var tables='<tr id="row'+j+'" class="evdynamic-commudity evsupp-'+supplierid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 15%;" class="rfqclass"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg evName" name="evrow['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 15%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="evrow['+m+'][ItemId]"></select></td>'+
                '<td style="width: 5%;"><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="evrow['+m+'][cropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="evrow['+m+'][proccesstype]"></select></td>'+
                '<td style="width: 15%;"><select id="coffegrade'+m+'" class="select2 form-control coffegrade" onchange="sourceVal(this)" name="evrow['+m+'][coffegrade]"></select></td>'+
                '<td style="width: 5%;"><select id="screensieve'+m+'" class="select2 form-control screensieve" onchange="sourceVal(this)" name="evrow['+m+'][screensieve]"></select></td>'+
                '<td><input type="text" name="evrow['+m+'][moisture]" placeholder="moisture" id="moisture'+m+'" value="'+value.evmoisture+'" class="moisture form-control" onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="evrow['+m+'][cupvalue]" placeholder="cup value" id="cupvalue'+m+'" value="'+value.evcupvalue+'" class="cupvalue form-control"  onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="evrow['+m+'][rowvalue]" placeholder="row value" id="rowvalue'+m+'" value="'+value.rowvalue+'" class="rowvalue form-control"  onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                '<td><input type="text" name="evrow['+m+'][score]" placeholder="score" id="score'+m+'" value="'+value.evscore+'" class="score form-control"  onkeyup="temovetechnicalunputerror(this)"/></td>'+
                '<td style="width: 5%;"><select id="status'+m+'" class="select2 form-control form-control-lg status" onchange="statusVal(this)" name="evrow['+m+'][status]"></select></td>'+
                
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="evrow['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="display:none;"><input type="hidden" name="evrow['+m+'][vals]" id="evvals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="evrow['+m+'][evsupp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '<td style="display:none;"><input type="text" name="evrow['+m+'][pevid]" id="pevid'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td>'+
                '</tr>';
            $("#evdynamicTablecommdity > tbody").append(tables);
            
            var options = $("#hiddencommudity > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var statusoption=$("#evestatus > option").clone();
            var evseivesizeoption=$("#evseivesize > option").clone();
            var gradeoption=$("#coffeegrade > option").clone();
            var evseivesizeoption2='<option selected value="'+screensieve+'">'+screensieve+'</option>';
            var statusoption2='<option selected value="'+value.evstatus+'">'+value.evstatus+'</option>';
            var cropyearoption2='<option selected value="'+cropyear+'">'+cropyear+'</option>';
            var gradeoption2='<option selected value="'+grade+'">'+grade+'</option>';
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();

            var options2 = '<option selected value="'+supplyid+'">'+supploption+'</option>';
            var proccesstypeoption2='<option selected value="'+value.evaulationproccesstype+'">'+value.evaulationproccesstype+'</option>';

            var options3='<option selected value="'+requestid+'">'+requestoption+'</option>';
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+value.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();

            $('#itemNameoriginSl'+m).empty();
            $('#itemNameoriginSl'+m).append(options3);
            $('#itemNameoriginSl'+m).select2();

            $('#coffeproccesstype'+m).append(proccesstypeoption);
            $("#coffeproccesstype"+m+" option[value='"+value.evaulationproccesstype+"']").remove();
            $('#coffeproccesstype'+m).append(proccesstypeoption2);
            $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
            
            $('#cropyear'+m).append(cropyearoption);
            $("#cropyear"+m+" option[value='"+cropyear+"']").remove();
            $('#cropyear'+m).append(cropyearoption2);
            $('#cropyear'+m).select2({placeholder: "Select crop year"});

            $('#coffegrade'+m).append(gradeoption);
            $("#coffegrade"+m+" option[value='"+grade+"']").remove();
            $('#coffegrade'+m).append(gradeoption2);
            $('#coffegrade'+m).select2({placeholder: "Select grade"});

            $('#screensieve'+m).append(evseivesizeoption);
            $("#screensieve"+m+" option[value='"+screensieve+"']").remove();
            $('#screensieve'+m).append(evseivesizeoption2);
            $('#screensieve'+m).select2({placeholder: "Select seive size"});
            
            $('#status'+m).empty();
            $('#status'+m).append(statusoption);
            $("#status"+m+" option[value='"+value.evstatus+"']").remove();
            $('#status'+m).append(statusoption2);
            $('#status'+m).select2({placeholder: "Select status"});

            $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });

        $(".evdynamic-commudity").hide();
        $(".evsupp-"+firstsuppler).show();
        $("#evcurrentsuppid").val(firstsuppler);
        renumberFields(firstsuppler);
    }

    function evualationitemlistappend(product) {
        var supplierid=0;
        var sampleamount='';
        var description='';
        var cropyear='';
        var supplyid='';
        var requestid='';
        var supploption='';
        var requestoption='';
        var remark='';
        var description='';
        var status='';
        var firstsuppler=0;
        var j=0;

        $.each(product, function (index, value) { 
            ++j;
            ++m;
            switch (index) {
                case 0:
                    firstsuppler=value.customers_id;
                    break;
            
                default:
                    break;
            }
            supplierid=value.customers_id;
            remark=value.remark==null?'':value.remark;
            description=value.description==null?'':value.description;
            status=value.evstatus==null?'':value.evstatus;
            var tables='<tr id="row'+j+'" class="evdynamic-added evsupp-'+supplierid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 17%;" class="rfqclass"><select id="evitemNameoriginSl'+m+'" class="select2 form-control form-control-lg eName" name="evrow['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 17%;"><select id="evitemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="evrow['+m+'][ItemId]"></select></td>'+
                '<td style="width: 30%;"><textarea placeholder="Write Description here..." class="form-control description" id="evdescription'+m+'" name="evrow['+m+'][description]">'+description+'</textarea></td>'+
                '<td style="width: 5%;"><select id="evstatus'+m+'" class="select2 form-control form-control-lg status" onchange="statusVal(this)" name="evrow['+m+'][evstatus]"></select></td>'+
                
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="evrow['+m+'][remark]">'+remark+'</textarea></td>'+
                '<td style="width:6%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm evremove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="evrow['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="evrow['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                '</tr>';
            $("#evdynamicTable tbody").append(tables);
            var options = $("#hiddenitem > option").clone();
            var options2 = '<option selected value="'+value.supllierid+'">'+value.supplyitem+'</option>';
            var options3 = '<option selected value="'+value.requestid+'">'+value.requestitem+'</option>';
            var statusoption=$("#evestatus > option").clone();
            var statusoption2='<option selected value="'+status+'">'+status+'</option>';
            $('#evitemNameSl'+m).empty();
            $('#evitemNameSl'+m).append(options); 
            $("#evitemNameSl"+m+" option[value='"+value.supllierid+"']").remove();
            $('#evitemNameSl'+m).append(options2);
            $('#evitemNameSl'+m).select2();
            
            $('#evitemNameoriginSl'+m).empty();
            $('#evitemNameoriginSl'+m).append(options3);
            $('#evitemNameoriginSl'+m).select2();

            $('#evstatus'+m).empty();
            $('#evstatus'+m).append(statusoption);
            $("#evstatus"+m+" option[value='"+status+"']").remove();
            $('#evstatus'+m).append(statusoption2);
            $('#evstatus'+m).select2({placeholder: "Select status"});

            $('#select2-evitemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#select2-evitemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        });

        $(".evdynamic-added").hide();
        $(".evsupp-"+firstsuppler).show();
        $("#evcurrentsuppid").val(firstsuppler);
        renumberFields(firstsuppler);
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
            peinformations(recordId);
    });
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
                        $("#collapseOne").collapse('show');
                        $('#docInfoModal').modal('show');
                    },
            success: function (response) {
                
                    $('#infostation').html(response.storename);
                $.each(response.pr, function (indexInArray, valueOfElement) { 
                    peid=valueOfElement.id;
                    $('#recordIds').val(valueOfElement.id);
                    $('#evelautestatus').val(valueOfElement.status);
                    $('#infope').html(valueOfElement.documentumber);
                    $('#inforefernce').html(valueOfElement.petype);
                    $('#infotype').html(valueOfElement.type);
                    $('#infodocumentdate').html(valueOfElement.date);
                    $('#infocommoditype').html(valueOfElement.commudtytype);
                    $('#infocommoditysource').html(valueOfElement.coffeesource);
                    $('#infocommoditystatus').html(valueOfElement.coffestat);
                    $('#infosample').html(valueOfElement.samplerequire);
                    $('#infomemo').html(valueOfElement.memo);
                    switch (valueOfElement.priority) {
                        case '1':
                            $('#infopriority').html('High');
                            break;
                        case '2':
                            $('#infopriority').html('Medium');
                            break;
                        default:
                            $('#infopriority').html('Low');
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
                setminilog(response.actions);
                showbuttondependonstat('frominfo',documentumber,status,petype);
            }
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
                    fetchorders(value.id,1);
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
    $('#searchsupplier').on('keyup', function() {
        var value = $(this).val().toLowerCase();
            $('#carddatacanvas .card').filter(function() {
                $(this).toggleClass('hidden', $(this).data('title').toLowerCase().indexOf(value) === -1);
            });
    });
    
    $('#clearsupplsearch').on('click', function(){
        var value = '';
        $('#carddatacanvas .card').filter(function() {
            $(this).toggleClass('hidden', $(this).data('title').toLowerCase().indexOf(value) === -1);
        });
        $('#searchsupplier').val('');
    });
    function fetchorders(id,isfirst) {
            var headerid=$('#recordIds').val();
            $('#evalsupplierid').val(id);
            $('.supcard').removeClass('supplierselected');
            $('.commcardcls'+id).addClass('supplierselected');

            switch (isfirst) {
                case 1:
                    commuditylist(headerid,id);
                    break;
                default:
                    var activeTab = $("#infoapptabs .nav-item .active").attr("href");
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
                            case 'Back to pending':
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
                case 'Approved':
                        icons='success timeline-point';
                        addedclass='text-success';
                break;
                case 'Confirm':
                        icons='success timeline-point';
                        addedclass='text-success';
                break;
                case 'Change To TE':
                        icons='primary timeline-point';
                        addedclass='text-primary';
                break;
                case 'Change To FE':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                case 'Back To FE':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                case 'Back To TE':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                        reason='<p class="text-muted"><b><u>Reason:</u></b>'+value.reason+'.</p>';
                break;
                case 'TE Inserted':
                        icons='warning timeline-point';
                        addedclass='text-warning';
                break;
                
                case 'Edited':
                        icons='warning timeline-point';
                        addedclass='text-warning';
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
                case 'Back To TE':
                case 'Back To FE':
                case 'Changed To TE':
                case 'Changed To FE':
                    icons='warning timeline-point';
                    addedclass='text-warning';
                    reason='';
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
                case 'Finished TE':
                case 'Finished FE':
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
                case 'TE Failed':
                    case 'FE Failed':
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
            autoWidth:false,
            "pagingType": "simple",
            order: [[ 0, "desc" ]],
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-2 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                url: "{{ url('peinfoitemlist') }}/"+params,                   
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex','width': '1%'},
                {data: 'customername',name: 'customername','visible':false},
                {data: 'Code',name: 'Code','width': '8%'},
                {data: 'Name',name: 'Name','width': '20%'},
                {data: 'SKUNumber',name: 'SKUNumber','width': '10%'},
                {data: 'description',name: 'description','width': '35%'},
                {data: 'sampleamount',name: 'sampleamount','width': '10%'},
                {data: 'remark',name: 'remark','width': '25%'},
            ],
            rowGroup: {
                startRender: function ( rows, group,level) {
                        var color = 'style="color:black;font-weight:bold;"';
                        var groupIndex = 1;
                        if(level===0){
                            return $('<tr ' + color + '/>')
                            .append('<th colspan="8" style="text-align:left;solid;background:#ccc; font-size:12px;">Supplier:'+group+'</th>')
                        }
                        else{
                            return $('<tr ' + color + '/>')
                            .append('<th colspan="8" style="text-align:left;solid;background:#f2f3f4;font-size:12px;">Customer: ' + group + '</th>')
                        }
                    },
                dataSrc: 'customername'
                },
                drawCallback: function(settings) {
                var api = this.api();
                var currentIndex = 1;
                var currentGroup = null;
                api.rows({ page: 'current', search: 'applied' }).every(function() {
                    var rowData = this.data();
                    if (rowData) {
                        var group = rowData['customername']; // Assuming 'group_column' is the name of the column used for grouping
                        if (group !== currentGroup) {
                            currentIndex = 1; // Reset index for a new group
                            currentGroup = group;
                        }
                        $(this.node()).find('td:first').text(currentIndex++);
                    }
                });
            }
        });
    }
    function initationcommuditylist(id) {
        $('#initiationcomuditydocInfoItemdiv').show();
        $('#comuditydocInfoItemdiv').hide();
        $("#supllierlistdiv").hide();
        $("#commoditylistdiv").removeClass("col-xl-10 col-md-10 col-sm-10");
        $("#supllierlistdiv").removeClass("col-xl-2 col-md-2 col-sm-2");
        $("#commoditylistdiv").removeClass("col-xl-12 col-md-12 col-sm-12");

        $("#commoditylistdiv").addClass("col-xl-12 col-md-12 col-sm-12");
        $("#supllierlistdiv").addClass("col-xl-0 col-md-0 col-sm-0");

        var status=$('#evelautestatus').val();
            var title='---';
            var comudtable=$('#initiationcomuditydocInfoItem').DataTable({
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
                url: "{{ url('getinitationcommodity') }}/"+id,           
                type: 'GET',
            },
            columns: [
                {data:'DT_RowIndex',"width": "1%"},
                {data: 'supplyorigin',name: 'supplyorigin'},
                {data: 'cropyear',name: 'cropyear'},
                {data: 'proccesstype',name: 'proccesstype'},
                
            ],
            
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
    function commuditylist(headerid,id) {

            $('#initiationcomuditydocInfoItemdiv').hide();
            $('#comuditydocInfoItemdiv').show();
            $("#supllierlistdiv").show();
            var status=$('#evelautestatus').val();
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
    $(document).ready(function () {
        
        var fyear = $('#fiscalyear').val()||0;
        var currentdate=$('#currentdate').val();
        focustables='#purtables';
        purchaselist('#purtables','pe',fyear);
        
    });
    
    $('.filter-select').change(function(){
            var search = [];
            $.each($('.filter-select option:selected'), function(){
                search.push($(this).val());
                });
            search = search.join('|');
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
    
    $('body').on('click', '.editsuppliers', function () {
            var supplierid = $(this).data('id');
            var peid=$('#recordIds').val();
            $('#purchasesupplierid').val(supplierid);
            $.ajax({
                type: "GET",
                url: "{{ url('specificsupplieredit') }}/"+peid+'/'+supplierid,
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
                        $('#singlesuppliermodal').modal('show');
                    },
                success: function (response) {
                        $('#purchaseevaultionid').val(peid);
                        $('#purchaseevaultiontype').val(response.type);
                        switch (response.type) {
                            case 'Goods':
                                appendsinglesuppliergoods(response.productlist);
                                break;
                            default:
                                appendsinglesuppliercommdity(response.productlist);
                                break;
                        }
                }
            });
    });
    $('body').on('click', '.enVoice', function () {
        var id = $(this).data('id');
        var link=$(this).data('link');
        window.open(link, 'Sale Report', 'width=1200,height=800,scrollbars=yes');
    });
    function appendsinglesuppliergoods(params) {
        var j=0;
        $("#supllierdynamicTable > tbody").empty();
        $("#supllierdynamicTable").show();
        $("#supllierdynamicTablecommdity").hide();
    }
    function appendsinglesuppliercommdity(params) {
        var j=0;
        $("#supllierdynamicTablecommdity > tbody").empty();
        $("#supllierdynamicTablecommdity").show();
        $("#supllierdynamicTable").hide();
        $.each(params, function (indexInArray, valueOfElement) { 
            ++j;
            ++m;
            var remark=valueOfElement.remark==null?'':valueOfElement.remark;
            var tables='<tr id="row'+j+'" class="dynamic-added">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 20%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                '<td><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                '<td><input type="text" name="row['+m+'][sampleamount]" placeholder="Sample amount" id="sampleamount'+m+'" value="'+valueOfElement.sampleamount+'" class="sampleamount form-control" onkeypress="return ValidateNum(event);"/></td>'+
                
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]">'+remark+'</textarea></td>'+
                '<input type="hidden" name="incrementval" id="incrementval" class="incrementval form-control"  style="font-weight:bold;" value="'+m+'" readonly/>'+
                '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '</tr>';
            $("#supllierdynamicTablecommdity tbody").append(tables);
            var options = $("#hiddencommudity > option").clone();
            var cropyearoption=$("#cropYear > option").clone();
            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
            
            var options2 = '<option selected value="'+valueOfElement.id+'">'+valueOfElement.Name+'</option>';
            var proccesstypeoption2='<option selected value="'+valueOfElement.proccesstype+'">'+valueOfElement.proccesstype+'</option>';
            var cropyearoption2='<option selected value="'+valueOfElement.cropyear+'">'+valueOfElement.cropyear+'</option>';
            $('#itemNameSl'+m).empty();
            $('#itemNameSl'+m).append(options); 
            $("#itemNameSl"+m+" option[value='"+valueOfElement.id+"']").remove();
            $('#itemNameSl'+m).append(options2);
            $('#itemNameSl'+m).select2();

            $('#coffeproccesstype'+m).append(proccesstypeoption);
            $("#coffeproccesstype"+m+" option[value='"+valueOfElement.proccesstype+"']").remove();
            $('#coffeproccesstype'+m).append(proccesstypeoption2);
            $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});

            
            $('#cropyear'+m).append(cropyearoption);
            $("#cropyear"+m+" option[value='"+valueOfElement.cropyear+"']").remove();
            $('#cropyear'+m).append(cropyearoption2);
            $('#cropyear'+m).select2({placeholder: "Select crop year"});
        });
    }
    function purchaselist(tables,type,fyear) {
            var suppplierviewpermission=$('#suppplierviewpermission').val();
            var visibiltymode=false;
            switch (suppplierviewpermission) {
                case '1':
                    visibiltymode=true;
                    break;
            
                default:
                        visibiltymode=false;
                    break;
            }
        purtables=$(tables).DataTable({
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
                text:'@can("PE-Add")<i data-feather="plus"></i> Add @endcan',
                className: '@can("PE-Add")btn btn-gradient-info btn-sm addbutton @endcan',
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary');
                }
            }
        ],
        ajax: {
        url: "{{ url('pevualationlist') }}/"+type+"/"+fyear,
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
                { data: 'documentumber', name: 'documentumber' },
                { data: 'Code', name: 'Code' },
                { data: 'Name', name: 'Name',visible:visibiltymode },
                { data: 'TinNumber', name: 'TinNumber',visible:visibiltymode },
                { data: 'petype', name: 'petype' },
                { data: 'rfqno', name: 'rfqno' },
                { data: 'type', name: 'type', },
                { data: 'date', name: 'date', },
                { data: 'status', name: 'status' },
                { data: 'id', name: 'id',orderable: false },
            ],
        columnDefs: [   
                        {
                            targets: 6,
                            render: function ( data, type, row, meta ) {
                                switch (row.petype) {
                                    case 'Direct':
                                        return '';
                                        break;
                                    default:
                                        return data;
                                        break;
                                }
                            }
                        },
                        {
                            targets: 9,
                            render: function ( data, type, row, meta ) {
                                switch (data) {
                                    case 0:
                                            return '<span class="text-secondary font-weight-medium"><b>Draft</b></span>';
                                    break;
                                    case 1:
                                        return '<span class="text-warning font-weight-medium"><b>Pending</b></span>';
                                    break;
                                    case 2:
                                        return '<span class="text-primary font-weight-medium"><b>Verified</b></span>';
                                    break;
                                    case 3:
                                        return '<span class="text-warning font-weight-medium"><b>TE on progress</b></span>';
                                    break;
                                    case 4:
                                        return '<span class="text-primary font-weight-medium"><b>Technically Evaluated</b></span>';
                                    break;
                                    case 5:
                                        return '<span class="text-danger font-weight-medium"><b>Void</b></span>';
                                    break;
                                    case 6:
                                        return '<p style="color:#e74a3b;font-weight:bold;text-shadow:1px 1px 10px #e74a3b;">Review</p>';
                                    break;
                                    case 7:
                                        return '<span class="text-danger font-weight-medium"><b>Rejected</b></span>';
                                    break;
                                    case 8:
                                        return '<span class="text-warning font-weight-medium"><b>FE on progress</b></span>';
                                    break;
                                    case 9:
                                        return '<span class="text-primary font-weight-medium"><b>Financially Evaluated</b></span>';
                                    break;
                                    case 10:
                                        return '<span class="text-success font-weight-medium"><b>Confirmed</b></span>';
                                    break;
                                    case 11:
                                        return '<span class="text-success font-weight-medium"><b>Approved</b></span>';
                                    break;
                                    case 12:
                                        return '<span class="text-danger font-weight-medium"><b>TE Failed</b></span>';
                                    break;
                                    case 13:
                                        return '<span class="text-danger font-weight-medium"><b>FE Failed</b></span>';
                                    break;
                                    default:
                                        return '--';
                                        break;
                                }
                            }
                        },
                        {
                            targets: 10,
                            render: function ( data, type, row, meta ) {
                                var anchor='<a class="DocPrInfo" href="javascript:void(0)" data-id='+data+' data-status='+row.status+' title="View sales"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a>';
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
    $('#coffestatus').on('change', function () {
        $('#coffestatus-error').html('');
    });
    $('#samplerequire').on('change', function () {
        $('#samplerequire-error').html('');
    });
    $('#reference').on('change', function () {
        $('#reference-error').html('');
        var reference=$('#reference').val()||0;
        $("#suppliertables > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        $("#dynamicTable > tbody").empty();
        $("#type option[value='Goods']").prop("disabled", true);
        $('#type').select2('destroy');
        $('#type').val('').select2();
        $('#customerorsupplier').empty();
        $("#itemrow").hide();
        $("#requesteditemadd").hide();

        $('#commoditytype option[value!=0]').prop('disabled', false);
        $('#coffeesource option[value!=0]').prop('disabled', false);
        $('#coffestatus option[value!=0]').prop('disabled', false);
        $('#requestStation option[value!=0]').prop('disabled', false);
        $('#priority option[value!=0]').prop('disabled', false);

        $('#commoditytype').select2('destroy');
        $('#commoditytype').val('').select2();

        $('#coffeesource').select2('destroy');
        $('#coffeesource').val('').select2();

        $('#coffestatus').select2('destroy');
        $('#coffestatus').val('').select2();

        $('#requestStation').select2('destroy');
        $('#requestStation').val('').select2();

        $('#priority').select2('destroy');
        $('#priority').val('').select2();
        switch (reference) {
            case 'RFQ':
                $('.rfqclass').show();
            
                break;
            default:
                $('#rfq').empty();
                $('#rfq').select2();
                $('.rfqclass').hide();
                
                reference
                break;
        }
    });
    $('#type').on('change', function () {
        $('#type-error').html('');
        var type=$('#type').val()||0;
        var id=$('#purchaseid').val()||0;
        var reference=$('#reference').val()||0;
        $("#adds").show();
        $("#dynamicTable > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        $("#suppliertables > tbody").empty();
        switch (reference) {
            case 0:
                toastrMessage('error','please select reference first','Error');
                break;
            case 'RFQ':
                $("#rfqdiv").show();
                sendrequestofetchrfq(type);
                    switch (type) {
                        case 'Goods':
                            $("#dynamicTable").show();
                            $("#dynamicTablecommdity").hide();
                            break;
                        default:
                            $("#dynamicTablecommdity").show();
                            $('.reqtables').show();
                            $("#dynamicTable").hide();
                            break;
                    }
                $('#supllierdiv').show();
                $('#productdiv').show();
                $("#supllierdiv").removeClass("col-xl-4 col-lg-12");
                $("#productdiv").removeClass("col-xl-8 col-lg-12");
                $("#productdiv").removeClass("col-xl-12 col-lg-12");
                $("#supllierdiv").addClass("col-xl-4 col-lg-12");
                $("#productdiv").addClass("col-xl-8 col-lg-12");
            break;
            default:
                $("#itemrow").show();
                $('#supllierdiv').hide();
                $("#rfqdiv").hide();
                $('#productdiv').show();
                $("#supllierdiv").removeClass("col-xl-4 col-lg-12");
                $("#productdiv").removeClass("col-xl-8 col-lg-12");
                $("#productdiv").removeClass("col-xl-12 col-lg-12");
                $("#productdiv").addClass("col-xl-12 col-lg-12");
                switch (type) {
                    case 'Goods':
                        $("#dynamicTable").show();
                        $("#dynamicTablecommdity").hide();
                        break;
                    default:
                        $("#dynamicTablecommdity").show();
                        $("#dynamicTable").hide();
                        $('.reqtables').hide();
                        $("#supplythid").html('Requested Commodity');
                        var thcount = $('#dynamicTablecommdity thead tr th').length;
                        var newHeaders = ['<th>Remark</th>', '<th></th>'];
                        switch (thcount) {
                                case 8:
                                    $('#dynamicTablecommdity thead tr th').slice(-3).remove();
                                break;
                                case 7:
                                    $('#dynamicTablecommdity thead tr th').slice(-2).remove();
                                break;
                                default:
                                    break;
                            }
                            for (var i = 0; i < newHeaders.length; i++) {
                                    $('#dynamicTablecommdity thead tr').append(newHeaders[i]);
                                }
                    break;
                }
                getallsuppliers();
                break;
        }
    });

    $('#rfq').on('change', function () {
        $('#rfq-error').html('');
        var rfq=$('#rfq').val();
        var requestype=$('#type').val()||0;
        var reference=$('#reference').val();
        $("#adds").show();
        $('#pricetable').hide();
        $("#suppliertables > tbody").empty();
        $("#dynamicTable > tbody").empty();
        $("#dynamicTablecommdity > tbody").empty();
        $("#requesteditemadd").show();
        $("#itemrow").show();
        var tables='#requesteditemdatatables';
        var type='';
        switch (reference) {
            case 'Direct':
                
                break;
            default:
                addgetrequesteditem(tables,rfq,requestype,reference);
                break;
        }
        $.ajax({
            type: "GET",
            url: "{{ url('getprequestdata') }}/"+rfq,
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
                $.each(response.purchase, function (index, value) { 
                    $('#type').select2('destroy');
                    $('#type').val(value.type).select2();

                    $('#commoditytype').select2('destroy');
                    $('#commoditytype').val(value.commudtytype).select2();

                    $('#coffeesource').select2('destroy');
                    $('#coffeesource').val(value.coffeesource).select2();

                    $('#coffestatus').select2('destroy');
                    $('#coffestatus').val(value.coffestat).select2();

                    $('#requestStation').select2('destroy');
                    $('#requestStation').val(value.store_id).select2();

                    $('#priority').select2('destroy');
                    $('#priority').val(value.priority).select2();

                    $('#commoditytype option[value!="'+value.commudtytype+'"]').prop('disabled', true);
                    $('#coffeesource option[value!="'+value.coffeesource+'"]').prop('disabled', true);
                    $('#coffestatus option[value!="'+value.coffestat+'"]').prop('disabled', true);
                    $('#requestStation option[value!="'+value.store_id+'"]').prop('disabled', true);
                    $('#priority option[value!="'+value.priority+'"]').prop('disabled', true);

                    type=value.type;
                });
                setsupplier(response.supplierlist,0);// to set customer supplier options
                appendrequestcommodity(response.productinitation,type,reference);
                switch (type) {
                        case 'Goods':
                            $("#dynamicTable").show();
                            $("#dynamicTablecommdity").hide();
                            break;
                        default:
                            $("#dynamicTable").hide();
                            $("#dynamicTablecommdity").show();
                            break;
                    }
            }
        });
    });
    function getallsuppliers() {
        $('#customerorsupplier').empty();
        $.ajax({
            type: "GET",
            url: "{{ url('getallsuppliers') }}",
            success: function (response) {
                $.each(response.supllier, function (index, value) { 
                    customeroption='<option selected value=""></option><option title="'+value.PhoneNumber+'" value="'+value.id+'">'+value.Name+'</option>';
                    $('#customerorsupplier').append(customeroption);
                });
                $('#customerorsupplier').select2({placeholder: "select supplier"});
                $('#select2-customerorsupplier-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });
    }
    function addgetrequesteditem(tables,rfq,requestype,reference) {
            switch (reference) {
                case 'Direct':
                        switch (type) {
                            case 'Goods':
                                    $('#requesteditemlabeladd').html('Requested Goods');
                                break;
                            
                            default:
                                    $('#requesteditemlabeladd').html('Requested Commudity');
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
                    url: "{{ url('addrequesteditems') }}/"+rfq+"/"+reference+"/"+requestype,                   
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
    function setsupplier(params,rfqsupplier) {
        var currentdate=$('#currentdate').val();
        $('#customerorsupplier').empty();
        $('#rfqsupllier').empty();
        var customeroption='';
        var rfqoption='';
        switch (rfqsupplier) {
            case 0: // this if there is no supplier on edit
                $.each(params, function (index, value) { 
                    customeroption='<option selected value=""></option><option title='+value.Name+' value="'+value.id+'">'+value.Name+'</option>';
                    $('#customerorsupplier').append(customeroption);
                });
                break;
            default:
                $.each(rfqsupplier, function (index, value) { 
                    rfqoption='<option selected value=""></option><option title='+value.Name+' value="'+value.id+'">'+value.Name+'</option>';
                    customeroption='<option selected value=""></option><option title='+value.Name+' value="'+value.id+'">'+value.Name+'</option>';
                    $('#rfqsupllier').append(rfqoption);
                    $('#customerorsupplier').append(customeroption);
                });
                break;
        }
                flatpickr('#submitiondate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
                $('#customerorsupplier').select2({placeholder: "select supplier"});
                $('#rfqsupllier').select2({placeholder: "select supplier"});
                $('#select2-customerorsupplier-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
    }

    function sendrequestofetchrfq(type) {
        var option='';
        var option1='';
        $('#rfq').empty();
        $.ajax({
            type: "GET",
            url: "{{ url('getrfq') }}/"+type,
            success: function (response) {
                $.each(response.rfq, function (index, value) { 
                    option = '<option selected></option><option value="'+value.id+'">'+value.rfq+'</option>';
                    $('#rfq').append(option);
                });
                $('#rfq').select2();
            }
        });
    }
    
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
        $('#exampleModalScrollableTitleadd').html('Add Purchase Evaluation');
        $("#supplythid").html('Supply Commodity');
        $("#purchaseid").val('');
        $('#infoStatus').html('');
        $('#statusdisplay').html('');
        $("#documentnumber").val('');
        $('#editflag').val('');
        $("#exampleModalScrollable").modal('show');
        $("#dynamicTable").hide();
        $("#dynamicTablecommdity").hide();
        $("#requesteditemadd").hide();
        $("#itemrow").hide();
        $('.rfqclass').hide();
        $("#adds").hide();
        $('.dr').val('');
        $('.dr').val('');
        flatpickr('#date', { dateFormat: 'Y-m-d',clickOpens:true});
        $('#date').val('');
        $('#memo').prop('readonly',false);
        $("#currentsuppid").val('');
        $('#customerphone').val('');
        $('#reference').select2('destroy');
        $('#reference').val('').select2();
        $('#rfq').select2('destroy');
        $('#rfq').val('').select2();
        $('#type').select2('destroy');
        $('#type').val('').select2();
        $('#itemtype').select2('destroy');
        $('#itemtype').val('').select2();
        $("#dynamicTable tbody").empty();
        $('#verticaledittab').empty();
        $('#pricetable').hide();
        $("#savebutton").find('span').text("Save");
        $("#savedicon").removeClass("fa-sharp fa-solid fa-floppy-disk");
        $("#savedicon").removeClass("fa-duotone fa-pen");
        $("#savedicon").addClass("fa-sharp fa-solid fa-floppy-disk");
        $("#coffecerificatediv").hide();
        $("#cropYeardiv").hide();

        $("#reference option[value!=0]").prop('disabled',false);
        $('#commoditytype option[value!=0]').prop('disabled', false);
        $('#coffeesource option[value!=0]').prop('disabled', false);
        $('#coffestatus option[value!=0]').prop('disabled', false);
        $('#requestStation option[value!=0]').prop('disabled', false);
        $('#samplerequire option[value!=0]').prop('disabled', false);
        $('#priority option[value!=0]').prop('disabled', false);
        $("#type option[value='Goods']").prop("disabled", true);

        $('#commoditytype').select2('destroy');
        $('#commoditytype').val('').select2();

        $('#coffeesource').select2('destroy');
        $('#coffeesource').val('').select2();

        $('#coffestatus').select2('destroy');
        $('#coffestatus').val('').select2();

        $('#requestStation').select2('destroy');
        $('#requestStation').val('').select2();

        $('#priority').select2('destroy');
        $('#priority').val('').select2();

        $('#customerorsupplier').empty();
        $('#customerorsupplier').select2({placeholder: "select supplier"});
        $('#select2-customerorsupplier-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
    }

    $("#adds").on('click', function() {
        var $list = $('#verticaledittab');
        var editflag=$('#editflag').val();
        var id=$('#purchaseid').val()||0;
        var reference=$('#reference').val()||0;
        switch (reference) {
            case 'Direct':
                switch (id) {
                        case 0:
                                addata(1);
                            break;
                        default:
                                switch (editflag) {
                                    case 'initation':
                                        addata(2);
                                        break;
                                    default:
                                        if ($list.is(':empty')) {
                                            toastrMessage('error','Add atleast one supplier','error');
                                        } 
                                        else{
                                            addata(3);
                                        }
                                        break;
                                }
                            break;
                    }
                break;
                
            default:
                    if ($list.is(':empty')) {
                            toastrMessage('error','Add atleast one supplier','error');
                        } 
                        else{
                            addata();
                        }
                break;
        }
    });

    function addata(logic) {
            ++i;
            ++j;
            ++m;
            var type=$('#type').val();
            var reference=$('#reference').val();
            var editflag=$('#editflag').val();
            var supplier=$('#currentsuppid').val();
            var options='';
            var options2='';
            var selectedval='';
            var requestoption='';

            switch (type) {
                case 'Goods':
                        var itemtype=$('#itemtype').val();
                        $("#dynamicTable").show();
                        $("#dynamicTablecommdity").hide();
                        appendtable(j,m);
                        firstpagerenumberFields(supplier);
                        options = $("#hiddenitem > option").clone();
                        requestoption = $("#requestedcommodity > option").clone();
                        options2 = '<option selected disabled value=""></option>';
                        $('#itemNameSl'+m).append(options);
                        $('#itemNameSl'+m).append(options2);
                        $('#itemNameoriginSl'+m).append(requestoption);
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

                            switch (logic) {
                                case 3:
                                    var length=$('#dynamicTablecommdity tbody tr').length;
                                    if(parseFloat(length)<1){
                                        commodityappendtablewithsample(j,m);
                                    }else
                                    {
                                        toastrMessage('error','Only single commodity is avaliable to save','Error');
                                    }
                                    
                                    break;
                                default:
                                    var length=$('#dynamicTablecommdity tbody tr').length;
                                    if(parseFloat(length)<1){
                                        commodityappendtable(j,m);
                                    } else
                                    {
                                        toastrMessage('error','Only single commodity is avaliable to save','Error');
                                    }
                                    
                                    break;
                            }
                            firstpagerenumberFields(supplier);
                            options = $("#hiddencommudity > option").clone();
                            requestoption = $("#requestedcommodity > option").clone();
                            var proccesstypeoption=$("#coffeeproccesstype > option").clone();
                            var cropyearoption=$("#cropYear > option").clone();
                            options2 = '<option selected disabled value=""></option>';
                            $('#itemNameSl'+m).append(options);
                            $('#itemNameoriginSl'+m).append(requestoption);
                            $('#coffeproccesstype'+m).append(proccesstypeoption);
                            $('#cropyear'+m).append(cropyearoption);
                            // for(var k=1;k<=m;k++){
                            //     if(($('#itemNameSl'+k).val())!=undefined){
                            //         selectedval=$('#itemNameSl'+k).val();
                            //         $("#itemNameSl"+m+" option[value='"+selectedval+"']").remove();
                            //     }
                            // }
                    break;
                default:
                    break;
            }
            switch (reference) {
                case 'Direct':
                    switch (editflag) {
                        case 'Editpe':
                            $(".reqtables").show();
                            break;
                        default:
                            $(".reqtables").hide();
                            break;
                    }
                    break;
                default:
                    $(".reqtables").show();
                    break;
            }
        $('#itemNameSl'+m).select2({placeholder: "Select Commodity"});
        $('#itemNameoriginSl'+m).select2({placeholder: "Requested Commodity"});
        $('#coffeproccesstype'+m).select2({placeholder: "Select proccess type"});
        $('#cropyear'+m).select2({placeholder: "Select crop year"});
        $('#select2-itemNameoriginSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
        $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
    }

        function appendtable(j,m) {
            var supplierid= $("#currentsuppid").val()||0;
            $("#dynamicTable tbody").append('<tr id="row'+j+'" class="dynamic-added supp-'+supplierid+'">'+
                    '<td style="text-align:center;">'+j+'</td>'+
                    '<td style="width: 17%;" class="reqtables"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg eName" name="row['+m+'][requestedItemId]"></select></td>'+
                    '<td style="width: 17%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                    '<td style="width: 30%;"><textarea placeholder="Write Description here..." class="form-control description" id="description'+m+'" name="row['+m+'][description]"></textarea></td>'+
                    
                    '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]"></textarea></td>'+
                    '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]"></textarea></td>'+
                    '<td style="width:6%;text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+supplierid+'"/></td>'+
                    '</tr>');
        }
    function commodityappendtable(j,m) {
        var suppid= $("#currentsuppid").val()||0;
        var psuplierid= $("#currentpsuppliersid").val()||0;
        $("#dynamicTablecommdity tbody").append('<tr id="row'+j+'" class="dynamic-commudity supp-'+suppid+'">'+
                '<td style="text-align:center;">'+j+'</td>'+
                '<td style="width: 17%;" class="reqtables"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg" name="row['+m+'][requestedItemId]"></select></td>'+
                '<td style="width: 17%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                
                '<td><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                '<td><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                
                '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]"></textarea></td>'+
                '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+suppid+'"/></td>'+
                '</tr>');
    }

    function commodityappendtablewithsample(j,m){
                var suppid= $("#currentsuppid").val()||0;
                var psuplierid= $("#currentpsuppliersid").val()||0;
                $("#dynamicTablecommdity tbody").append('<tr id="row'+j+'" class="dynamic-commudity supp-'+suppid+'">'+
                        '<td style="text-align:center;">'+j+'</td>'+
                        '<td style="width: 17%;" class="reqtables"><select id="itemNameoriginSl'+m+'" class="select2 form-control form-control-lg" name="row['+m+'][requestedItemId]"></select></td>'+
                        '<td style="width: 17%;"><select id="itemNameSl'+m+'" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+m+'][ItemId]"></select></td>'+
                        '<td><select id="cropyear'+m+'" class="select2 form-control cropyear" onchange="sourceVal(this)" name="row['+m+'][cropyear]"></select></td>'+
                        '<td><select id="coffeproccesstype'+m+'" class="select2 form-control coffeproccesstype" onchange="sourceVal(this)" name="row['+m+'][proccesstype]"></select></td>'+
                        '<td><input type="text" name="row['+m+'][sampleamount]" placeholder="Sample amount" id="sampleamount'+m+'" class="sampleamount form-control" onkeyup="temovetechnicalunputerror(this)" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="width: 30%;"><textarea placeholder="Write Remark Here..." class="form-control description" id="remark'+m+'" name="row['+m+'][remark]"></textarea></td>'+
                        '<td style="text-align:center;background-color:#efefef;"><button type="button" class="btn btn-lignt btn-sm remove-tr"><i class="fa-sharp fa-solid fa-x" style="color: #f03000;"></i></button></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                        '<td style="display:none;"><input type="text" name="row['+m+'][supp]" id="supp'+m+'" class="supp form-control" readonly="true" style="font-weight:bold;" value="'+suppid+'"/></td>'+
                        '</tr>');
    }

    
    $(document).on('click', '.remove-tr', function(){
            var supplier=$('#currentsuppid').val();
            --i;
            --j;
            $(this).parents('tr').remove();
            // renumberRows();
            firstpagerenumberFields(supplier);
    });
    function renumberRows(){
        var ind;
        var type=$('#type').val();
        switch (type) {
            case 'Goods':
                    $('#dynamicTable tr').each(function(index, el)
                        {
                            $(this).children('td').first().text(index++);
                            ind=index-1;
                            j=ind;
                        });
                break;
            default:
                        $('#dynamicTablecommdity tr').each(function(index, el){
                            $(this).children('td').first().text(index++);
                            $('#numberofItemsLbl').html(index-1);
                            $('#numbercounti').val(index-1);
                            ind=index-1;
                            j=ind;
                        });
                break;
        }
        
    }
    function firstpagerenumberFields(customer){
        var type=$('#type').val();
        var reference=$('#reference').val();
        var editflag=$('#editflag').val();
        var ind;
        
        switch (type) {
                    case 'Goods':
                            $('#dynamicTable tr.supp-'+customer+'').each(function(index, el){
                                $(this).children('td').first().text(index+1);
                                ind=index-1;
                                j=ind;
                            });
                        break;
                    default:
                        switch (editflag) {
                            case 'Editpe':
                                $('#dynamicTablecommdity tr.supp-'+customer+'').each(function(index, el){
                                    $(this).children('td').first().text(index+1);
                                    ind=index-1;
                                    j=ind;
                                });
                                break;
                                
                            default:
                                    $('#dynamicTablecommdity tr.supp-0').each(function(index, el){
                                    $(this).children('td').first().text(index+1);
                                    ind=index-1;
                                    j=ind;
                                });
                                break;
                        }
                        
                        break;
                }
        
    }
    function financialrenumberFields(customer){
        var ind;
        $('#financailevdynamicTablecommdity tr.financialevsupp-'+customer+'').each(function(index, el){
            $(this).children('td').first().text(index+1);
            ind=index-1;
            j=ind;
        });
    }
    function renumberFields(customer){
        var ind;
        var type=$('#evtype').val();
        switch (type) {
            case 'Goods':
                $('#evdynamicTable tr.evsupp-'+customer+'').each(function(index, el){
                    $(this).children('td').first().text(index+1);
                    ind=index-1;
                    j=ind;
                });
                break;
        
            default:
                $('#evdynamicTablecommdity tr.evsupp-'+customer+'').each(function(index, el){
                    $(this).children('td').first().text(index+1);
                    ind=index-1;
                    j=ind;
                });
                break;
        }
        
    }
    
    function removesamplerror(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        $('#sampleamount'+idval).css("background", "white");
    }
    function itemVal(ele){
        var idval = $(ele).closest('tr').find('.vals').val();
        var cropyear=$(ele).closest('tr').find('.cropyear').val();
        var proccestype=$(ele).closest('tr').find('.coffeproccesstype').val();
        var item = $(ele).closest('tr').find('.eName').val();
        var suppliier=$(ele).closest('tr').find('.supp').val();
        var commuditycnt=0;
        
        $('#cropyear'+idval).val('').trigger('change').select2({
                        placeholder: "Select crop year...",
                    });
        $('#coffeproccesstype'+idval).val('').trigger('change').select2({
                placeholder: "Select proccess type",
            });
        
            $('#status'+idval).val('').select2({
                placeholder: "select status here",
            });
            $('#sampleamount'+idval).val('');
            $('#moisture'+idval).val('');
            $('#screensieve'+idval).val('');
            $('#cupvalue'+idval).val('');
            $('#score'+idval).val('');
        for(var k=1;k<=m;k++){
                    if(($('#itemNameSl'+k).val())!=undefined){
                        if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype) && ($('#supp'+k).val()==suppliier)){
                            commuditycnt+=1;
                        }
                    }
                }
                if(parseInt(commuditycnt)<=1){
                    $('#select2-itemNameSl'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                }
                else if(parseInt(commuditycnt)>1){
                    $('#itemNameSl'+idval).val(null).trigger('change').select2
                    ({
                        placeholder: "Select Commodity",
                    });
                    $('#select2-itemNameSl'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                    toastrMessage('error'," commodity selected with all property","Error");
            }
            console.log('item='+item);
            console.log('proccestype='+proccestype);
            console.log('cropyear='+cropyear);

    }
    function assignValue(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        if ($('#colorCheck'+idval).is(':checked')) {
            $('#finalprice'+idval).attr('readonly', true);
            $('#isagreed'+idval).val('1');
        } else {
            $('#finalprice'+idval).attr('readonly', false);
            $('#isagreed'+idval).val('0');
        }
    }
    function sourceVal(ele){
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        var commuditycnt=0;
        switch (inputid) {
            case 'coffegrade'+idval:
                    $('#select2-coffegrade'+idval+'-container').parent().css('background-color',"white");
            break;
            case 'packingcontent'+idval:
                    var packingcontent=$('#packingcontent'+idval).val();
                    var unitprice = $(ele).closest('tr').find('.unitprice').val()||0;
                    var nofpackages=$(ele).closest('tr').find('.nofpackage ').val()||0;
                    var netwieght=parseFloat(packingcontent)*parseFloat(nofpackages);
                    var feresula=parseFloat(netwieght)/17;
                    $(ele).closest('tr').find('.netweight ').val(netwieght.toFixed(2));
                    $(ele).closest('tr').find('.feresula').val(feresula.toFixed(2));
                    var total=parseFloat(feresula)*parseFloat(unitprice);
                    $(ele).closest('tr').find('.totalprice').val(total.toFixed(2));
                    $('#select2-coffestatus'+idval+'-container').parent().css('background-color',"white");
                    CalculateGrandTotal();
            break;
            case 'coffeproccesstype'+idval:
                        var cropyear=$(ele).closest('tr').find('.cropyear').val();
                        var proccestype=$(ele).closest('tr').find('.coffeproccesstype').val();
                        var item = $(ele).closest('tr').find('.eName').val();
                        var suppliier=$(ele).closest('tr').find('.supp').val();

                        for(var k=1;k<=m;k++){
                            if(($('#coffeproccesstype'+k).val())!=undefined){
                                if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype)&&($('#supp'+k).val()==suppliier)){
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
            case 'cropyear'+idval:
                    var cropyear=$(ele).closest('tr').find('.cropyear').val();
                    var proccestype=$(ele).closest('tr').find('.coffeproccesstype').val();
                    var item = $(ele).closest('tr').find('.eName').val();
                    var suppliier=$(ele).closest('tr').find('.supp').val();
                    for(var k=1;k<=m;k++){
                        if(($('#itemNameSl'+k).val())!=undefined){
                            if((parseInt($('#itemNameSl'+k).val()) == parseInt(item)) && (parseInt($('#cropyear'+k).val()) == parseInt(cropyear))  && ($('#coffeproccesstype'+k).val()==proccestype) && ($('#supp'+k).val()==suppliier)){
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
                        placeholder: "Select crop year...",
                    });
                    $('#select2-cropyear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                    toastrMessage('error',"Crop year selected with all property","Error");
                }
                
            break;
            case 'coffeuom'+idval:
                    $('#select2-coffeuom'+idval+'-container').parent().css('background-color',"white");
            break;
            default:
                break;
        }
    }

    function statusVal(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        switch (inputid) {
            case 'fevstatus'+idval:
                $('#select2-fevstatus'+idval+'-container').parent().css('background-color',"white");
                break;
            case 'evstatus'+idval:
                $('#select2-evstatus'+idval+'-container').parent().css('background-color',"white");
            break;
            default:
                break;
        }
    
    }
    function temovetechnicalunputerror(ele) {
        var idval = $(ele).closest('tr').find('.vals').val();
        var inputid = ele.getAttribute('id');
        switch (inputid) {
            case 'moisture'+idval:
                $('#moisture'+idval).css('background-color',"white");
            break;
            case 'screensieve'+idval:
                $('#screensieve'+idval).css('background-color',"white");
            break;
            case 'cupvalue'+idval:
                $('#cupvalue'+idval).css('background-color',"white");
            break;
            case 'score'+idval:
                $('#score'+idval).css('background-color',"white");
            break;
            case 'bagamount'+idval:
                $('#bagamount'+idval).css('background-color',"white");
            break;
            case 'qualitygrade'+idval:
                $('#qualitygrade'+idval).css('background-color',"white");
            break;
            case 'customerpreice'+idval:
                $('#customerpreice'+idval).css('background-color',"white");
            break;
            case 'finalprice'+idval:
                $('#finalprice'+idval).css('background-color',"white");
            break;
            
            case 'sampleamount'+idval:
                $('#sampleamount'+idval).css('background-color',"white");
                break;
            default:

                break;
        }
    }
    
    $('#savebutton').click(function(){
        var type=$('#type').val();
        switch (type) {
            case 'Goods':
                var $tbody = $('#dynamicTable tbody');
                if ($tbody.is(':empty')) {
                        toastrMessage('error','Please add goods','Error!');
                    } else {
                        console.log('The tbody is not empty.');
                        purchasesave();
                    }
                break;
            default:
                var $tbody = $('#dynamicTablecommdity tbody');
                if ($tbody.is(':empty')) {
                        toastrMessage('error','Please add commodity','Error!');
                    } else {
                        console.log('The tbody is not empty.');
                        purchasesave();
                    }
                break;
        }
    
    });
    financailevsavebutton
    $('#financailevsavebutton').click(function(){
        financialevualationsave();
    });
    $('#evsavebutton').click(function(){
        technicalevualationsave();
    });
    $('#suppliersave').click(function(){
        itemforsuppliersave();
    });

    function itemforsuppliersave() {
        var registerForm = $("#singlesupplireform");
        var formData = registerForm.serialize();
        $.ajax({
                type: "POST",
                url: "{{ url('supliersave') }}",
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
                    toastrMessage('success','Pe is successfully saved','Save!');
                    $("#singlesuppliermodal").modal('hide');
                    var oTable = $('#comuditydocInfoItem').dataTable();
                    oTable.fnDraw(false);
                }
                if(response.errorv2){
                    for(var k=1;k<=m;k++){
                        var itmid=($('#itemNameSl'+k)).val();
                        var coffesource=$('#coffesource'+k).val()||0;
                        var certificate=$('#coffecertificate'+k).val()||0;
                        var grade=$('#coffegrade'+k).val()||0;
                        var status=$('#coffestatus'+k).val()||0;
                        var proccesstype=$('#coffeproccesstype'+k).val()||0;
                        var oum=$('#coffeuom'+k).val()||0;
                        var cropyear=($('#cropyear'+k)).val();
                        if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                            $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(isNaN(parseFloat(cropyear))||parseFloat(cropyear)==0){
                            $('#select2-cropyear'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(proccesstype)==0){
                            $('#select2-coffeproccesstype'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(($('#sampleamount'+k).val())!=undefined){
                            var sampleamount=$('#sampleamount'+k).val();
                            if(isNaN(parseFloat(sampleamount))||parseFloat(sampleamount)==0){
                                $('#sampleamount'+k).css("background", errorcolor);
                            }
                        }
                    }
                    toastrMessage("error","Please insert a valid data on highlighted fields","Error");
                }
            }
        });
    }

    function purchasesave() {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        var id=$('#purchaseid').val()||0;
        var route='';
        switch (id) {
            case 0:
                route="{{ url('pesave') }}";
                break;
            default:
                route="{{ url('peupdate') }}";
                break;
        }
        $.ajax({
            type: "POST",
            url: route,
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
                    
                    switch (id) {
                        case 0:
                            gblIndex=0;
                            break;
                        default:
                            gblIndex= gblIndex;
                            break;
                    }
                    var oTable = $('#purtables').dataTable();
                    oTable.fnDraw(false);
                }
                else if(response.errors){
                    if(response.errors.rfq){
                        $('#rfq-error').html( response.errors.rfq[0]);
                    }
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
                        $('#priority-error').html(response.errors.priority[0]);
                    }
                    if(response.errors.requiredate){
                        $('#requiredate-error').html(response.errors.requiredate[0]);
                    }
                    if(response.errors.requestStation){
                        $('#requestStation-error').html(response.errors.requestStation[0]);
                    }
                    if(response.errors.coffeesource){
                        $('#coffeesource-error').html(response.errors.coffeesource[0]);
                    }
                    if(response.errors.coffestatus){
                        $('#coffestatus-error').html(response.errors.coffestatus[0]);
                    }
                    if(response.errors.itemtype){
                        $('#itemtype-error').html(response.errors.itemtype[0]);
                    }
                    if(response.errors.reference){
                        $('#reference-error').html(response.errors.reference[0]);
                    }
                    if(response.errors.samplerequire){
                        $('#samplerequire-error').html(response.errors.samplerequire[0]);
                    }
                }
                else if(response.errorv2){
                    for(var k=1;k<=m1;k++){
                        var suplier=$('#custName'+k).val()||0;
                        if(suplier==0){
                            $('#select2-custName'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(($('#phonenumber'+k).val())!=undefined){
                            var phonenumber=$('#phonenumber'+k).val();
                            if(isNaN(parseFloat(phonenumber))||parseFloat(phonenumber)==0){
                                $('#phonenumber'+k).css("background", errorcolor);
                            }
                        }
                        if(($('#recievedate'+k).val())!=undefined){
                            var recievedate=$('#recievedate'+k).val();
                            if(isNaN(parseFloat(recievedate))||parseFloat(recievedate)==0){
                                $('#recievedate'+k).css("background", errorcolor);
                            }
                        }
                    }
                }
                else if(response.errorv3){
                    for(var k=1;k<=m;k++){
                        var itmid=($('#itemNameSl'+k)).val();
                        var coffesource=$('#coffesource'+k).val()||0;
                        var certificate=$('#coffecertificate'+k).val()||0;
                        var grade=$('#coffegrade'+k).val()||0;
                        var status=$('#coffestatus'+k).val()||0;
                        var proccesstype=$('#coffeproccesstype'+k).val()||0;
                        var oum=$('#coffeuom'+k).val()||0;
                        var cropyear=($('#cropyear'+k)).val();
                        if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                            $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(isNaN(parseFloat(cropyear))||parseFloat(cropyear)==0){
                            $('#select2-cropyear'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(parseFloat(proccesstype)==0){
                            $('#select2-coffeproccesstype'+k+'-container').parent().css('background-color',errorcolor);
                        }

                        if(($('#sampleamount'+k).val())!=undefined){
                            var sampleamount=$('#sampleamount'+k).val();
                            if(isNaN(parseFloat(sampleamount))||parseFloat(sampleamount)==0){
                                $('#sampleamount'+k).css("background", errorcolor);
                            }
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
    function technicalevualationsave() {
        var registerForm = $("#evualationRegister");
        var formData = registerForm.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('technicalevsave') }}",
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
                    toastrMessage('success','Technical evaluation is successfully saved','Save!');
                    $("#evualtionModalScrollable").modal('hide');
                    stayontableindex();
                }
                if(response.errorv2){
                    toastrMessage('error','Please fill the higlighted feilds','Error!');
                    for(var k=1;k<=m;k++){
                        var status=$('#evstatus'+k).val()||0;
                        var moisture=$('#moisture'+k).val();
                        var screensieve=$('#screensieve'+k).val();
                        var cupvalue=$('#cupvalue'+k).val();
                        var score=$('#score'+k).val();
                        
                        if(parseFloat(status)==0){
                            $('#select2-evstatus'+k+'-container').parent().css('background-color',errorcolor);
                        }
                        if(isNaN(parseFloat(moisture))||parseFloat(moisture)==0){
                            $('#moisture'+k).css("background", errorcolor);
                        }
                        if(isNaN(parseFloat(screensieve))||parseFloat(screensieve)==0){
                            $('#screensieve'+k).css("background", errorcolor);
                        }
                        if(isNaN(parseFloat(cupvalue))||parseFloat(cupvalue)==0){
                            $('#cupvalue'+k).css("background", errorcolor);
                        }
                        if(isNaN(parseFloat(score))||parseFloat(score)==0){
                            $('#score'+k).css("background", errorcolor);
                        }
                    }
                }
            }
        });
    }
    function financialevualationsave() {
            var registerForm = $("#financailevualationRegister");
            var formData = registerForm.serialize();
            $.ajax({
                    type: "POST",
                    url: "{{ url('financialsave') }}",
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
                    toastrMessage('success','financial evualaton is successfully saved','Save!');
                    $("#financailevualtionModalScrollable").modal('hide');
                    stayontableindex();
                }
                    if(response.errorv2){
                        toastrMessage('error','Please fill the higlighted feilds','Error!');
                        for(var k=1;k<=m;k++){
                            var status=$('#fevstatus'+k).val()||0;
                            var bagamount=$('#bagamount'+k).val();
                            var qualitygrade=$('#qualitygrade'+k).val();
                            var customerpreice=$('#customerpreice'+k).val();
                            var finalprice=$('#finalprice'+k).val();
                            
                            if(parseFloat(status)==0){
                                $('#select2-fevstatus'+k+'-container').parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(bagamount))||parseFloat(bagamount)==0){
                                $('#bagamount'+k).css("background", errorcolor);
                            }
                            if(isNaN(parseFloat(qualitygrade))||parseFloat(qualitygrade)==0){
                                $('#qualitygrade'+k).css("background", errorcolor);
                            }
                            if(isNaN(parseFloat(customerpreice))||parseFloat(customerpreice)==0){
                                $('#customerpreice'+k).css("background", errorcolor);
                            }
                            if(isNaN(parseFloat(finalprice))||parseFloat(finalprice)==0){
                                $('#finalprice'+k).css("background", errorcolor);
                            }
                        }
                    }
                }
            });
    }
    function stayontableindex() {
        var oTable = $('#purtables').dataTable(); 
        oTable.fnDraw(false);
    }
    function preloader() {
        
    }
    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
</script>
@endsection
