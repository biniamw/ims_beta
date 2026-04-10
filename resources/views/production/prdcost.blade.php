@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Holiday-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Cost</h3>
                            @can('Holiday-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addprdcost" data-toggle="modal">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;display:none;">
                                <div>
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th></th>
                                                <th style="width:31%;">Holiday Name</th>
                                                <th style="width:31%;">Holiday Date</th>
                                                <th style="width:30%;">Status</th>
                                                <th style="width:5%;">Action</th>
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
    @endcan

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add Cost</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-2 col-md-4 col-sm-4 mb-1">
                                <label style="font-size: 14px;">Output Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="type" id="type" onchange="typeFn()">
                                    <option value="1">Commodity</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="type-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-4 col-sm-4 mb-1">
                                <label style="font-size: 14px;">Production Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="ProductionType" id="ProductionType" onchange="productionTypeFn()">
                                    <option selected value=""></option>
                                    <option value="1">Arrival</option>
                                    <option value="2">Export</option>
                                    <option value="3">Reject</option>
                                    <option value="4">Export & Reject</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="prdtype-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-4 mb-1 prdprop" id="cusProp">
                                <label style="font-size: 14px;">Customer</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="Customer" id="Customer" onchange="customerFn()">
                                    <option selected value=""></option>
                                    @foreach ($customersdata as $customersdata)
                                        <option value="{{ $customersdata->id }}">{{ $customersdata->Code }}   ,   {{ $customersdata->Name }}   ,   {{ $customersdata->TinNumber }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="customer-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-4 mb-1 prdprop" id="ordNumProp">
                                <label style="font-size: 14px;">Production Order Number</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="ProductionOrderNumber" id="ProductionOrderNumber" onchange="productionOrderFn()">
                                    <option selected value=""></option>
                                    @foreach ($productiondata as $productiondata)
                                        <option value="{{ $productiondata->id }}">{{ $productiondata->ProductionOrderNumber }}   ,   {{ $productiondata->Code }}   ,   {{ $customersdata->Name }}   ,   {{ $customersdata->TinNumber }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="prdorder-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-4 mb-1">
                                <label style="font-size: 14px;">Remark</label>
                                <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" rows="2" name="Remark" id="Remark" onkeyup="remarkFn()"></textarea>
                                <span class="text-danger">
                                    <strong id="remark-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row prdprop" id="cusPropBody">
                            
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                
                            </div>
                        </div>
                        <div class="row prdprop" id="ordNumPropBody">

                            <div class="col-xl-2 col-md-2 col-lg-2">
                                <!-- Tab navs -->
                                <div class="nav flex-column nav-tabs text-center" id="v-tabs-outputtab" role="tablist" aria-orientation="vertical" style="border:1px solid #D3D3D3">
                                    <a class="nav-link active prdcostinfo" id="storageTab" data-toggle="tab" href="#storageTabBody" role="tab" aria-controls="storageTab" aria-selected="true" onclick="costTypeFn(1)">Storage</a>
                                    <a class="nav-link prdcostinfo" id="processingTab" data-toggle="tab" href="#processingTabBody" role="tab" aria-controls="processingTab" aria-selected="false" onclick="costTypeFn(2)">Processing</a>
                                    <a class="nav-link prdcostinfo" id="loadingTab" data-toggle="tab" href="#loadingTabBody" role="tab" aria-controls="loadingTab" aria-selected="false" onclick="costTypeFn(3)">Loading & Unloading</a>
                                    <a class="nav-link prdcostinfo" id="printingTab" data-toggle="tab" href="#printingTabBody" role="tab" aria-controls="printingTab" aria-selected="false" onclick="costTypeFn(4)">Printing</a>
                                    <a class="nav-link prdcostinfo" id="othersTab" data-toggle="tab" href="#othersTabBody" role="tab" aria-controls="othersTab" aria-selected="false" onclick="costTypeFn(5)">Others</a>
                                    <a class="nav-link prdcostinfo mb-1" id="summaryTab" data-toggle="tab" href="#summaryTabBody" role="tab" aria-controls="summaryTab" aria-selected="false" onclick="costTypeFn(6)">Summary</a>
                                </div>
                                <!-- Tab navs -->
                            </div>

                            <div class="col-xl-10 col-md-10 col-sm-10">
                                <div class="tab-content" id="v-tabs-tabContent">
                                    <div class="tab-pane active prdcostinfoBody" id="storageTabBody" role="tabpanel" aria-labelledby="storageTabBody"> 
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div style="text-align: center;border: 0.1px solid #d9d7ce;">
                                                    <label style="font-size: 20px;font-weight:bold;">Storage</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-xl-3 col-md-3 col-sm-3">
                                                <section id="carddatacanvas"></section>
                                            </div>
                                            <div class="col-xl-9 col-md-9 col-sm-9">
                                                <div id="storageDiv" class="row" style="margin-top:-20px;display:none;">
                                                    <div class="col-xl-12 col-md-12 col-lg-12">
                                                        <section id="commoditytitle"></section>
                                                        <div class="table-responsive" style="margin-top:-2rem">                                                            
                                                            <table id="prepDynamicTable" class="mt-1 rtable" style="width:100%;">
                                                                <thead style="font-size: 12px;">
                                                                    <tr>
                                                                        <th style="width:3%;">#</th>
                                                                        <th colspan="2" style="width:23%;">First Date<label style="color: red;">*</label></th>
                                                                        <th style="width:13%;">End Date</th>
                                                                        <th style="width:10%;" title="Number of Days or Stay day in the warehouse">No. of Day</th>
                                                                        <th style="width:10%;" title="Number of Bag">No. of Bag<label style="color: red;">*</label></th>
                                                                        <th style="width:13%;" title="Price per Bag">Price per Bag</th>
                                                                        <th style="width:13%;" title="Total Price">Total Price</th>
                                                                        <th style="width:12%;">Remark</th>
                                                                        <th style="width:3%;"></th>
                                                                    </tr>
                                                                <thead>
                                                                <tbody></tbody>
                                                            </table>
                                                            <table class="mb-0 addbuttontbl" id="addtbl">
                                                                <tr>
                                                                    <td>
                                                                        <button type="button" name="prepadd" id="prepadd" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                                    <td>
                                                                </tr>
                                                            </table>
                                                            <span class="text-danger">
                                                                <strong id="prepdynamictbl-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-9 col-md-9 col-lg-9"></div>
                                                    <div class="col-xl-3 col-md-3 col-lg-3 pricingclass">
                                                        <table class="rtable" id="commpricingtbl" style="width:100%;">
                                                            <tr>
                                                                <td colspan="2" style="text-align: center;" id="commtotaltlb"></td>
                                                            </tr>
                                                            <tr style="text-align: center;" class="taxcalcflagcls">
                                                                <td style="width: 50%;">Subtotal</td>
                                                                <td style="width: 50%;">
                                                                    <b><label style="font-size: 14px;" class="commprc" id="commsubtotal"></label></b>
                                                                </td>
                                                            </tr>
                                                            <tr style="text-align: center;" class="taxcalcflagcls">
                                                                <td style="width: 50%;">Tax</td>
                                                                <td style="width: 50%;">
                                                                    <b><label style="font-size: 14px;" class="commprc" id="commtax"></label></b>
                                                                </td>
                                                            </tr>
                                                            <tr style="text-align: center;">
                                                                <td style="width: 50%;">Grand Total</td>
                                                                <td style="width: 50%;">
                                                                    <b><label style="font-size: 14px;" class="commprc" id="commgrandtotal"></label></b>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <hr class="m-1">
                                                <div class="row pricingclass">
                                                    <div class="col-xl-9 col-md-9 col-lg-9"></div>
                                                    <div class="col-xl-3 col-md-3 col-lg-3">
                                                        <table class="rtable" id="storagepricingtbl" style="width:100%;">
                                                            <tr>
                                                                <td colspan="2" style="text-align: center;" id="storagetotaltlb"><b>Total of Storage Fee</b></td>
                                                            </tr>
                                                            <tr style="text-align: center;" class="taxcalcflagcls">
                                                                <td style="width: 50%;">Subtotal</td>
                                                                <td style="width: 50%;">
                                                                    <b><label style="font-size: 14px;" id="strcommsubtotal"></label></b>
                                                                </td>
                                                            </tr>
                                                            <tr style="text-align: center;" class="taxcalcflagcls">
                                                                <td style="width: 50%;">Tax</td>
                                                                <td style="width: 50%;">
                                                                    <b><label style="font-size: 14px;" id="strcommtax"></label></b>
                                                                </td>
                                                            </tr>
                                                            <tr style="text-align: center;">
                                                                <td style="width: 50%;">Grand Total</td>
                                                                <td style="width: 50%;">
                                                                    <b><label style="font-size: 14px;" id="strcommgrandtotal"></label></b>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane prdcostinfoBody" id="processingTabBody" role="tabpanel" aria-labelledby="processingTabBody"> 
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div style="text-align: center;border: 0.1px solid #d9d7ce;">
                                                    <label style="font-size: 20px;font-weight:bold;">Processing</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-md-12 col-lg-12 mt-1">
                                                <table id="processingTable" class="mt-1 rtable" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:19%;">Produced Commodity</th>
                                                            <th style="width:10%;">Grade</th>
                                                            <th style="width:12%;">Process Type</th>
                                                            <th style="width:13%;">Sieve / Screen Size</th>
                                                            <th style="width:16%;" title="Produced Quantity by TON">Produced Qty. by TON</th>
                                                            <th style="width:15%;" title="Price per TON">Price per TON</th>
                                                            <th style="width:15%;" title="Total Price">Total Price</th>
                                                        </tr>
                                                    <thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control mainforminp" name="producedcommodity" id="producedcommodity" style="font-weight: bold;" readonly/>
                                                            </td> 
                                                            <td>
                                                                <input type="text" class="form-control mainforminp" name="procgrade" id="procgrade" readonly style="font-weight: bold;"/>
                                                            </td> 
                                                            <td>
                                                                <input type="text" class="form-control mainforminp" name="procprocesstype" id="procprocesstype" readonly style="font-weight: bold;"/>
                                                            </td> 
                                                            <td>
                                                                <input type="text" class="form-control mainforminp" name="procscreensize" id="procscreensize" readonly style="font-weight: bold;"/>
                                                            </td> 
                                                            <td>
                                                                <input type="text" class="form-control mainforminp" name="procproducedqty" id="procproducedqty" readonly style="font-weight: bold;"/>
                                                            </td> 
                                                            <td>
                                                                <input type="number" class="form-control mainforminp" name="procpriceperton" id="procpriceperton" onkeypress="return ValidateNum(event);" onkeyup="calcProcessFn()"/>
                                                            </td> 
                                                            <td>
                                                                <input type="text" class="form-control mainforminp" name="proctotalprice" id="proctotalprice" readonly style="font-weight: bold;"/>
                                                            </td>  
                                                        </tr>                                              
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-lg-6 mt-1">
                                                <table style="width: 100%" class="rtable">
                                                    <thead>
                                                        <tr>
                                                            <th>Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" rows="2" name="ProcessingRemark" id="ProcessingRemark"></textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-3 col-md-3 col-lg-3 mt-1"></div>
                                            <div class="col-xl-3 col-md-3 col-lg-3 mt-1">
                                                <table class="rtable" id="commpricingtbl" style="width:100%;">
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;" id="processingtitlelbl"><b>Total of Processing Fee</b></td>
                                                    </tr>
                                                    <tr style="text-align: center;" class="taxcalcflagcls">
                                                        <td style="width: 50%;">Subtotal</td>
                                                        <td style="width: 50%;">
                                                            <b><label style="font-size: 14px;" class="commprc" id="procsubtotal"></label></b>
                                                        </td>
                                                    </tr>
                                                    <tr style="text-align: center;" class="taxcalcflagcls">
                                                        <td style="width: 50%;">Tax</td>
                                                        <td style="width: 50%;">
                                                            <b><label style="font-size: 14px;" class="commprc" id="proctax"></label></b>
                                                        </td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td style="width: 50%;">Grand Total</td>
                                                        <td style="width: 50%;">
                                                            <b><label style="font-size: 14px;" class="commprc" id="procgrandtotal"></label></b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane prdcostinfoBody" id="loadingTabBody" role="tabpanel" aria-labelledby="loadingTabBody"> 
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div style="text-align: center;border: 0.1px solid #d9d7ce;">
                                                    <label style="font-size: 20px;font-weight:bold;">Loading & Unloading (Labour)</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab-pane prdcostinfoBody" id="printingTabBody" role="tabpanel" aria-labelledby="printingTabBody"> 
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div style="text-align: center;border: 0.1px solid #d9d7ce;">
                                                    <label style="font-size: 20px;font-weight:bold;">Printing</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-pane prdcostinfoBody" id="othersTabBody" role="tabpanel" aria-labelledby="othersTabBody"> 
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div style="text-align: center;border: 0.1px solid #d9d7ce;">
                                                    <label style="font-size: 20px;font-weight:bold;">Others</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-md-12 col-lg-12 mt-1">
                                                <table id="othersTable" class="mt-1 rtable" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:70%;">Description</th>
                                                            <th style="width:30%;" title="Others Cost">Others Cost</th>
                                                        </tr>
                                                    <thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <textarea type="text" placeholder="Write Description here..." class="form-control mainforminp" rows="2" name="OthersCostDescription" id="OthersCostDescription" onkeyup="othCostDescFn()"></textarea>
                                                            </td> 
                                                            <td>
                                                                <textarea type="number" placeholder="Write Others cost here..." class="form-control mainforminp" rows="2" name="procotherscost" id="procotherscost" onkeypress="return ValidateNum(event);" onkeyup="calcOthersFn()"></textarea>
                                                                {{-- <input type="number" placeholer="Write Others cost here..." class="form-control form-control-lg mainforminp" name="procotherscost" id="procotherscost" onkeypress="return ValidateNum(event);" onkeyup="calcOthersFn()"/> --}}
                                                            </td> 
                                                        </tr>                                              
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-lg-6 mt-1">
                                                <table style="width: 100%" class="rtable">
                                                    <thead>
                                                        <tr>
                                                            <th>Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" rows="2" name="OthersRemark" id="OthersRemark"></textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-3 col-md-3 col-lg-3 mt-1"></div>
                                            <div class="col-xl-3 col-md-3 col-lg-3 mt-1">
                                                <table class="rtable" id="otherspricingtbl" style="width:100%;">
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;" id="otherstbltitle"><b>Total of Others Fee</b></td>
                                                    </tr>
                                                    <tr style="text-align: center;" class="taxcalcflagcls">
                                                        <td style="width: 50%;">Subtotal</td>
                                                        <td style="width: 50%;">
                                                            <b><label style="font-size: 14px;" id="othcommsubtotal"></label></b>
                                                        </td>
                                                    </tr>
                                                    <tr style="text-align: center;" class="taxcalcflagcls">
                                                        <td style="width: 50%;">Tax</td>
                                                        <td style="width: 50%;">
                                                            <b><label style="font-size: 14px;" id="othcommtax"></label></b>
                                                        </td>
                                                    </tr>
                                                    <tr style="text-align: center;">
                                                        <td style="width: 50%;">Grand Total</td>
                                                        <td style="width: 50%;">
                                                            <b><label style="font-size: 14px;" id="othcommgrandtotal"></label></b>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="tab-pane prdcostinfoBody" id="summaryTabBody" role="tabpanel" aria-labelledby="summaryTabBody"> 
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-lg-12">
                                                <div style="text-align: center;border: 0.1px solid #d9d7ce;">
                                                    <label style="font-size: 20px;font-weight:bold;">Summary</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-md-12 col-lg-12 mt-1">
                                                <table id="summaryTable" class="rtable" style="width: 100%">
                                                    <thead style="text-align: center;">
                                                        <tr>
                                                            <th style="width: 5%;">#</th>
                                                            <th style="width: 35%;">Cost Type</th>
                                                            <th class="taxcalcflagcls" style="width: 20%;">Subtotal</th>
                                                            <th class="taxcalcflagcls" style="width: 20%;">Tax</th>
                                                            <th style="width: 20%;">Grand Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="text-align: center; padding:1px 1px 1px 1px;">
                                                        <tr>
                                                            <td>
                                                                <label style="font-size: 14px;">1</label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;">Storage</label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="strsubtotal"></label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="strtax"></label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="strgrandtotal"></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label style="font-size: 14px;">2</label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;">Processing</label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="prcsubtotal"></label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="prctax"></label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="prcgrandtotal"></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label style="font-size: 14px;">3</label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;">Loading & Unloading (Labour)</label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="loadsubtotal"></label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="loadtax"></label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="loadgrandtotal"></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label style="font-size: 14px;">4</label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;">Printing</label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="prnsubtotal"></label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="prntax"></label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="prngrandtotal"></label>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label style="font-size: 14px;">5</label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;">Others</label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="othsubtotal"></label>
                                                            </td>
                                                            <td class="taxcalcflagcls">
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="othtax"></label>
                                                            </td>
                                                            <td>
                                                                <label style="font-size: 14px;font-weight:bold;" class="summpricing" id="othgrandtotal"></label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-9 col-md-9 col-lg-9 mt-1"></div>
                                            <div class="col-xl-3 col-md-3 col-lg-3 mt-1">
                                                <table class="rtable" id="summarytotaltbl" style="width:100%;">
                                                    <tbody>
                                                        <tr style="text-align: center;" class="taxcalcflagcls">
                                                            <td style="width: 50%;">Subtotal</td>
                                                            <td style="width: 50%;">
                                                                <b><label style="font-size: 14px;" id="summsubtotal"></label></b>
                                                            </td>
                                                        </tr>
                                                        <tr style="text-align: center;" class="taxcalcflagcls">
                                                            <td style="width: 50%;">Tax</td>
                                                            <td style="width: 50%;">
                                                                <b><label style="font-size: 14px;" id="summtax"></label></b>
                                                            </td>
                                                        </tr>
                                                        <tr style="text-align: center;">
                                                            <td style="width: 50%;">Grand Total</td>
                                                            <td style="width: 50%;">
                                                                <b><label style="font-size: 14px;" id="summgrandtotal"></label></b>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" style="text-align: center;padding:3px;">
                                                                <label style="font-size:14px;"><input class="hummingbird-end-node isTaxable" style="width:17px;height:17px;" id="isTaxable" name="isTaxable" type="checkbox" value="1"/> Is Taxable</label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="arrivaldatedefault" id="arrivaldatedefault">
                                <option selected disabled value=""></option>
                                @foreach ($arrivaldatedata as $arrivaldatedata)
                                    <option title="{{$arrivaldatedata->woredaId}}" value="{{ $arrivaldatedata->ArrivalDate }}">{{ $arrivaldatedata->ArrivalDate}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" placeholder="" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <input type="hidden" class="form-control" name="prdStatusVal" id="prdStatusVal" readonly="true" value=""/> 
                        <input type="hidden" class="form-control" name="prdCommodityTypeVal" id="prdCommodityTypeVal" readonly="true" value=""/> 
                        <input type="hidden" class="form-control" name="prdRegionVal" id="prdRegionVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdGradeVal" id="prdGradeVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdProcessTypeVal" id="prdProcessTypeVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="predCropYearVal" id="predCropYearVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdStoreVal" id="prdStoreVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdUomVal" id="prdUomVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdQuantityKg" id="prdQuantityKg" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdQuantityVal" id="prdQuantityVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdMinDateVal" id="prdMinDateVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdProductionDate" id="prdProductionDate" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdUomFactorVal" id="prdUomFactorVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdUomNameVal" id="prdUomNameVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdSymbolVal" id="prdSymbolVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="prdRowIdVal" id="prdRowIdVal" readonly="true" value=""/>
                        <input type="hidden" name="CurrentDateVal" id="CurrentDateVal" placeholder="YYYY-MM-DD" class="OrderDate form-control" style="font-weight: bold;" value="{{$currentdate}}" readonly/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Holiday Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="2">
                                                <label id="basictitle" style="font-size: 16px;font-weight:bold;">Basic Information</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 55%"><label style="font-size: 14px;">Holiday Name</label></td>
                                            <td style="width: 45%"><label id="holidaynamelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Holiday Date</label></td>
                                            <td><label id="holidaydatelbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Calculate as</label></td>
                                            <td><label id="calculateotinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Description</label></td>
                                            <td><label id="descriptionlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Status</label></td>
                                            <td><label id="statuslbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="2">
                                                <label id="actiontitle" style="font-size: 16px;font-weight:bold;">Action Information</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%"><label style="font-size: 14px;">Created By</label></td>
                                            <td style="width: 60%"><label id="createdbylbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Created Date</label></td>
                                            <td><label id="createddatelbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Last Edited By</label></td>
                                            <td><label id="lasteditedbylbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Last Edited Date</label></td>
                                            <td><label id="lastediteddatelbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                    </table>
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
    <!--End Information Modal -->


    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var currentdate=$('#CurrentDateVal').val();

        var j=0;
        var i=0;
        var m=0;

        var jj=0;
        var ii=0;
        var mm=0;
        var checkflg=1;

        $(document).ready( function () {
            if(parseInt(checkflg)==0){
                $('.taxcalcflagcls').hide();
                $('#isTaxable').prop("checked",false);
            }
            else if(parseInt(checkflg)==1){
                $('.taxcalcflagcls').show();
                $('#isTaxable').prop("checked",true);
            }
            var ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 1, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/holidaylist',
                    type: 'DELETE',
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
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'HolidayName', name: 'HolidayName',width:"31%"},
                    { data: 'HolidayDate', name: 'HolidayDate',width:"31%"},
                    { data: 'Status', name: 'Status',width:"30%"},
                    { data: 'action', name: 'action',width:"5%"}
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
                {
                    if (aData.Status == "Active")
                    {
                        $(nRow).find('td:eq(3)').css({"color": "#4CAF50", "font-weight": "bold","text-shadow":"1px 1px 10px #4CAF50"});
                    }
                    else if (aData.Status == "Inactive")
                    {
                        $(nRow).find('td:eq(3)').css({"color": "#f44336", "font-weight": "bold","text-shadow":"1px 1px 10px #f44336"});
                    }
                }
            });
        });

        $('.addprdcost').click(function(){
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('.prdprop').hide();
            $('#storageDiv').hide();
            $('#type').select2({
                minimumResultsForSearch: -1
            });

            $('#ProductionType').val(null).select2({
                placeholder:"Select Production type here",
                minimumResultsForSearch: -1
            });
            $('#Customer').val(null).select2({
                placeholder:"Select Customer here"
            });
            $('#ProductionOrderNumber').val(null).select2({
                placeholder:"Select Production order number here"
            });
            $('#recId').val("");
            $('#operationtypes').val("1");
            $("#modaltitle").html("Add Cost");
            $('#carddatacanvas').empty();
            $("#prepDynamicTable > tbody").empty();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveHoliday',
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

                success: function(data) {
                    if (data.errors) {
                        if (data.errors.HolidayName) {
                            $('#name-error').html(data.errors.HolidayName[0]);
                        }
                        if (data.errors.HolidayDate) {
                            $('#holidaydate-error').html(data.errors.HolidayDate[0]);
                        }
                        if (data.errors.CalculateOvertime) {
                            $('#overtimecalc-error').html(data.errors.CalculateOvertime[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        closeRegisterModal();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        function holidayEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            j=0;
            $.get("/showholiday"+'/'+recordId , function(data) {
                $.each(data.holidaydata, function(key, value) {
                    $('#HolidayName').val(value.HolidayName);
                    $('#HolidayDate').val(value.HolidayDate);
                    $('#CalculateOvertime').val(value.overtime_id).trigger('change').select2();
                    $("#Description").val(value.Description);
                    $('#status').select2('destroy');
                    $('#status').val(value.Status).trigger('change').select2({
                            minimumResultsForSearch: -1
                        }
                    );
                });
            });
            $("#modaltitle").html("Edit Holiay");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function holidayInfoFn(recordId) { 
            $.get("/showholiday"+'/'+recordId , function(data) {
                $.each(data.holidaydata, function(key, value) {
                    $("#holidaynamelbl").html(value.HolidayName);
                    $("#holidaydatelbl").html(value.HolidayDate);
                    $("#calculateotinfo").html(value.OvertimeLevelName);
                    $("#descriptionlbl").html(value.Description);
                    $("#createdbylbl").html(value.CreatedBy);
                    $("#createddatelbl").html(value.CreatedDateTime);
                    $("#lasteditedbylbl").html(value.LastEditedBy);
                    if(value.LastEditedBy==null || value.LastEditedBy==""){
                        $("#lastediteddatelbl").html("");
                    }
                    if(value.LastEditedBy!=null && value.LastEditedBy!=""){
                        $("#lastediteddatelbl").html(value.UpdatedDateTime);
                    }
                    
                    var st=value.Status;
                    if(st=="Active"){
                        $("#statuslbl").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                    }
                    if(st=="Inactive"){
                        $("#statuslbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }
                });
            });
            $("#informationmodal").modal('show');
        }

        function holidayDeleteFn(recordId) { 
            var leavefromval=0;
            $("#delRecId").val(recordId);
            $.get("/showholiday"+'/'+recordId , function(data) {
                leavefromval=data.datefromval;
                if(parseInt(leavefromval)>=1){
                    toastrMessage('error',"Unable to delete holiday, because other record has been made based on this holiday","Error");
                }
                else if(parseInt(leavefromval)==0){
                    $('#deleterecbtn').text('Delete');
                    $('#deleterecbtn').prop("disabled", false);
                    $("#deletemodal").modal('show');
                }
            });
        }

        function typeFn() {
            $('#type-error').html('');
        }

        function productionTypeFn() {
            var prdtype=$('#ProductionType').val();
            $('.prdprop').hide();
            $('.mainforminp').val("");
            $('.commprc').html("");
            $(".prdcostinfo").removeClass("active");
            $(".prdcostinfoBody").removeClass("active");
            $('#Customer').val(null).select2({
                placeholder:"Select Customer here"
            });

            $('#ProductionOrderNumber').val(null).select2({
                placeholder:"Select Production order number here"
            });
            if(parseInt(prdtype)==1){
                $('#cusProp').show();
                $('#cusPropBody').show();
                $('#storageDiv').hide();
                $('#carddatacanvas').empty();
                $("#prepDynamicTable > tbody").empty();
            }
            else if(parseInt(prdtype)==2 || parseInt(prdtype)==3 || parseInt(prdtype)==4){
                $('#storageDiv').hide();
                $('#carddatacanvas').empty();
                $("#prepDynamicTable > tbody").empty();
                $('#ordNumProp').show();
                $('#ordNumPropBody').show();
                $("#storageTab").addClass("active");         
                $("#storageTabBody").addClass("active");     
            }
            $('#prdtype-error').html('');
            CalculateGrandTotalPrice();
            calcOthersFn();
            calcProcessFn();
            CalculateSummary();
        }

        function costTypeFn(flg){
            //console.log(flg);
        }

        function customerFn() {
            $('#customer-error').html('');
        }

        function productionOrderFn() {
            var prdId="";
            var carddata="";
            var commtypedef="";
            var origindef="";
            var gradedef="";
            var processtypedef="";
            var cropyeardef="";
            var storedef="";
            var productionDetId="";
            var productionType=$('#ProductionType').val();
            jj=0;
            $('#carddatacanvas').empty();
            $("#prepDynamicTable > tbody").empty();
            $('.commprc').html("");
            $('.mainforminp').val("");
            $.ajax({
                url: '/showPrdCommodity',
                type: 'POST',
                data:{
                    prdId:$('#ProductionOrderNumber').val(),
                },
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
                    $("#producedcommodity").val(data.commname);
                    $("#procgrade").val(data.gradename);
                    $("#procprocesstype").val(data.processtypename);
                    $("#procscreensize").val(data.sievesize);
                    $("#procproducedqty").val(data.totalton);

                    $.each(data.prdorderdetails, function(key, value) {
                        ++ii;
                        ++mm;
                        ++jj;
                        var commtypename="";
                        var backcolor="";
                        var forecolor="";
                        if (parseInt(value.CommodityType)==1){
                            commtypename="Arrival";
                            backcolor="#eae8fd !important";
                            forecolor="#7367f0 !important";
                        }
                        else if (parseInt(value.CommodityType)==2){
                            commtypename="Export";
                            backcolor="#dff7e9 !important";
                            forecolor="#28c76f !important";
                        }
                        else if (parseInt(value.CommodityType)==3){
                            commtypename="Reject";
                            backcolor="#fff1e3 !important";
                            forecolor="#ff9f43 !important";
                        }

                        carddata+="<div id='commcard"+value.PrdDetailId+"' class='card commcardcls' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchStorageCostFn("+mm+","+value.PrdDetailId+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+commtypename+"</b></span></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>"+value.Origin+"</b></div></div></div></div>";
                    
                        if(parseInt(jj)==1){
                            var mindate="";
                            display="block";
                            mindate = value.ProductionStartDate == '' ? 0 : value.OrderDate;
                            //$("#commoditytitle").html("<div id='actcomm"+value.PrdDetailId+"' class='card actcomm' style='margin-top:0rem;border:0.5px solid #FFFFFF'><div class='card-body pb-0' style='margin-top:0rem'></div></div>");
                            $("#commoditytitle").html("<div id='actcomm"+value.PrdDetailId+"' class='card actcomm' style='margin-top:0rem;border:0.5px solid #FFFFFF'><div class='card-body p-0 pl-1' style='margin-top:0rem'><table style='width:100%;text-align:left;font-size:11px;'><tr><td style='width:9%'>Type</td><td style='width:25%'>Region, Zone, Woreda</td><td style='width:8%'>Grade</td><td style='width:14%'>Process Type</td><td style='width:9%'>Crop Year</td> <td style='width:18%'>Store</td><td style='width:17%'>Quantity</td> </tr><tr style='font-weight:bold;'> <td>"+value.CommodityTypeName+"</td>  <td>"+value.Origin+"</td> <td>"+value.GradeName+"</td> <td>"+value.ProcessType+"</td> <td>"+value.CropYear+"</td> <td>"+value.StoreName+"</td> <td>"+value.Quantity+" "+value.UomName+", "+value.QuantityInKG+" KG</td></tr></table></div></div>");
                            $("#prdCommodityTypeVal").val(value.CommodityType);
                            $("#prdRegionVal").val(value.woredas_id);
                            $("#prdGradeVal").val(value.Grade);
                            $("#prdProcessTypeVal").val(value.ProcessType);
                            $("#predCropYearVal").val(value.CropYear);
                            $("#prdStoreVal").val(value.stores_id);
                            $("#prdUomVal").val(value.uoms_id);
                            $("#prdQuantityKg").val(value.QuantityInKG);
                            $("#prdQuantityVal").val(value.Quantity);
                            $("#prdRowIdVal").val(value.PrdDetailId);
                            $("#prdProductionDate").val(value.ProductionEndDate);
                            $("#prdMinDateVal").val(mindate);
                            $("#prdUomFactorVal").val(value.uomamount);
                            $("#prdBagWeightVal").val(value.bagweight);
                            $("#prdUomNameVal").val(value.UomName);
                            $("#prdSymbolVal").val(value.Symbol);
                            $("#commtotaltlb").html("Total of: <b>"+value.Symbol+"</b>");

                            commtypedef=value.CommodityType;
                            origindef=value.woredas_id;
                            gradedef=value.Grade;
                            processtypedef=value.ProcessType;
                            cropyeardef=value.CropYear;
                            storedef=value.stores_id;
                            productionDetId=value.PrdDetailId;
                        }
                        else if(parseInt(jj)>1){
                            display="none";
                        }
                    });

                    if(parseInt(productionType)==2){
                        $.each(data.prdexporder, function(key, value) {
                            ++ii;
                            ++mm;
                            ++jj;
                            var commtypename="";
                            var backcolor="";
                            var forecolor="";
                            if (parseInt(value.CommodityType)==1){
                                commtypename="Arrival";
                                backcolor="#eae8fd !important";
                                forecolor="#7367f0 !important";
                            }
                            else if (parseInt(value.CommodityType)==2){
                                commtypename="Export";
                                backcolor="#dff7e9 !important";
                                forecolor="#28c76f !important";
                            }
                            else if (parseInt(value.CommodityType)==3){
                                commtypename="Reject";
                                backcolor="#fff1e3 !important";
                                forecolor="#ff9f43 !important";
                            }

                            carddata+="<div id='commcard"+value.PrdDetailId+"' class='card commcardcls' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchStorageExpCostFn("+mm+","+value.PrdDetailId+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+commtypename+"</b></span></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>"+value.Origin+"</b></div></div></div></div>";
                            
                        });
                    }
                    else if(parseInt(productionType)==3){
                        $.each(data.prdrejorder, function(key, value) {
                            ++ii;
                            ++mm;
                            ++jj;
                            var commtypename="";
                            var backcolor="";
                            var forecolor="";
                            if (parseInt(value.CommodityType)==1){
                                commtypename="Arrival";
                                backcolor="#eae8fd !important";
                                forecolor="#7367f0 !important";
                            }
                            else if (parseInt(value.CommodityType)==2){
                                commtypename="Export";
                                backcolor="#dff7e9 !important";
                                forecolor="#28c76f !important";
                            }
                            else if (parseInt(value.CommodityType)==3){
                                commtypename="Reject";
                                backcolor="#fff1e3 !important";
                                forecolor="#ff9f43 !important";
                            }

                            carddata+="<div id='commcard"+value.PrdDetailId+"' class='card commcardcls' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchStorageRejCostFn("+mm+","+value.PrdDetailId+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+commtypename+"</b></span></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>"+value.Origin+"</b></div></div></div></div>";
                        });
                    }
                    else if(parseInt(productionType)==4){
                        $.each(data.prdexporder, function(key, value) {
                            ++ii;
                            ++mm;
                            ++jj;
                            var commtypename="";
                            var backcolor="";
                            var forecolor="";
                            if (parseInt(value.CommodityType)==1){
                                commtypename="Arrival";
                                backcolor="#eae8fd !important";
                                forecolor="#7367f0 !important";
                            }
                            else if (parseInt(value.CommodityType)==2){
                                commtypename="Export";
                                backcolor="#dff7e9 !important";
                                forecolor="#28c76f !important";
                            }
                            else if (parseInt(value.CommodityType)==3){
                                commtypename="Reject";
                                backcolor="#fff1e3 !important";
                                forecolor="#ff9f43 !important";
                            }

                            carddata+="<div id='commcard"+value.PrdDetailId+"' class='card commcardcls' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchStorageExpCostFn("+mm+","+value.PrdDetailId+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+commtypename+"</b></span></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>"+value.Origin+"</b></div></div></div></div>";
                        });

                        $.each(data.prdrejorder, function(key, value) {
                            ++ii;
                            ++mm;
                            ++jj;
                            var commtypename="";
                            var backcolor="";
                            var forecolor="";
                            if (parseInt(value.CommodityType)==1){
                                commtypename="Arrival";
                                backcolor="#eae8fd !important";
                                forecolor="#7367f0 !important";
                            }
                            else if (parseInt(value.CommodityType)==2){
                                commtypename="Export";
                                backcolor="#dff7e9 !important";
                                forecolor="#28c76f !important";
                            }
                            else if (parseInt(value.CommodityType)==3){
                                commtypename="Reject";
                                backcolor="#fff1e3 !important";
                                forecolor="#ff9f43 !important";
                            }

                            carddata+="<div id='commcard"+value.PrdDetailId+"' class='card commcardcls' style='margin-top:-1.75rem;border:0.5px solid #FFFFFF' onclick='fetchStorageRejCostFn("+mm+","+value.PrdDetailId+")'><div class='card-header' style='margin-top:-1rem;margin-left:-1rem;margin-right:-1rem'><span class='badge badge-center rounded-pill bg-secondary'>"+jj+"</span> <span style='background-color:"+backcolor+";color:"+forecolor+";padding:3px 5px;font-size:11px;'><b>"+commtypename+"</b></span></div><div class='card-body pb-0' style='margin-top:-1.2rem'><div class='row mt-0'><div class='col-xl-12 col-md-12 col-lg-12 p-0'><b>"+value.Origin+"</b></div></div></div></div>";
                        });
                    }
                    $('#carddatacanvas').html(carddata);
                    $('#storageDiv').show();
                    CalculateGrandTotalPrice();
                    calcOthersFn();
                    calcProcessFn();
                    CalculateSummary();
                }
            });
            $('#prdorder-error').html('');
        }

        function fetchStorageCostFn(rowid,recid){
            var recordid="";
            var arrdatecbx=0;
            var arrdateval=0;
            var lastdateval=0;
            var numofbag=0;
            var recidval=$("#prdRowIdVal").val();

            if(parseInt(recid)!=parseInt(recidval)){
                $.ajax({
                    url: '/getPrdCostCommData',
                    type: 'POST',
                    data:{
                        recordid:recid,
                    },
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
                        $.each(data.prdorderdetails, function(key, value) {
                            $.each($('#prepDynamicTable').find('.arrdatacb'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    arrdatecbx+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.dateval'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    arrdateval+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.lastdateval'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    lastdateval+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.numOfBag'+recidval), function() {
                                if ($(this).val() == '' || isNaN($(this).val())) {
                                    numofbag+= 1;
                                }
                            });

                            if(parseInt(arrdatecbx)==0 && parseInt(arrdateval)==0 && parseFloat(lastdateval)==0 && parseFloat(numofbag)==0){
                                var mindate="";
                                mindate = value.ProductionStartDate == '' ? 0 : value.OrderDate;
                                $("#commoditytitle").html("<div id='actcomm"+value.PrdDetailId+"' class='card actcomm' style='margin-top:0rem;border:0.5px solid #FFFFFF'><div class='card-body p-0 pl-1' style='margin-top:0rem'><table style='width:100%;text-align:left;font-size:11px;'><tr><td style='width:9%'>Type</td><td style='width:25%'>Region, Zone, Woreda</td><td style='width:8%'>Grade</td><td style='width:14%'>Process Type</td><td style='width:9%'>Crop Year</td> <td style='width:18%'>Store</td><td style='width:17%'>Quantity</td> </tr><tr style='font-weight:bold;'> <td>"+value.CommodityTypeName+"</td>  <td>"+value.Origin+"</td> <td>"+value.GradeName+"</td> <td>"+value.ProcessType+"</td> <td>"+value.CropYear+"</td> <td>"+value.StoreName+"</td> <td>"+value.Quantity+" "+value.UomName+", "+value.QuantityInKG+" KG</td></tr></table></div></div>");
                                $("#prdCommodityTypeVal").val(value.CommodityType);
                                $("#prdRegionVal").val(value.woredas_id);
                                $("#prdGradeVal").val(value.Grade);
                                $("#prdProcessTypeVal").val(value.ProcessType);
                                $("#predCropYearVal").val(value.CropYear);
                                $("#prdStoreVal").val(value.stores_id);
                                $("#prdUomVal").val(value.uoms_id);
                                $("#prdQuantityKg").val(value.QuantityInKG);
                                $("#prdQuantityVal").val(value.Quantity);
                                $("#prdRowIdVal").val(value.PrdDetailId);
                                $("#prdProductionDate").val(value.ProductionEndDate);
                                $("#prdMinDateVal").val(mindate);
                                $("#prdUomFactorVal").val(value.uomamount);
                                $("#prdBagWeightVal").val(value.bagweight);
                                $("#prdUomNameVal").val(value.UomName);
                                $("#prdSymbolVal").val(value.Symbol);
                                $("#commtotaltlb").html("Total of: <b>"+value.Symbol+"</b>");
                                $(".prdrow").hide();
                                $(".prdprop"+value.PrdDetailId).show();
                                $('.commcardcls').prop("disabled",false);
                                $('#commcard'+value.PrdDetailId).prop("disabled",true);
                                $(".commoditytotaltbl").hide();
                                $("#currComodityTable"+value.PrdDetailId).show();
                            }
                            else{
                                for(var q=1;q<=mm;q++){
                                    var arrdatecbxdata=$('#arrDateCbx'+q).val();
                                    var arrdatedata=$('#arrDate'+q).val();
                                    var lastdatedata=$('#prepLastDate'+q).val();
                                    var numofbagdata=$('#prepNumofBag'+q).val();
                                    
                                    if(($('#arrDateCbx'+q).val())!=undefined){
                                        if(arrdatecbxdata==""||arrdatecbxdata==null){
                                            $('#select2-arrDateCbx'+q+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#arrDate'+q).val())!=undefined){
                                        if(arrdatedata==""||arrdatedata==null){
                                            $('#arrDate'+q).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#prepLastDate'+q).val())!=undefined){
                                        if(lastdatedata==""||lastdatedata==null){
                                            $('#prepLastDate'+q).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#prepNumofBag'+q).val())!=undefined){
                                        if(numofbagdata==""||numofbagdata==null){
                                            $('#prepNumofBag'+q).css("background", errorcolor);
                                        }
                                    }
                                }
                                toastrMessage('error',"Please insert valid data on highlighted fields before proceeding to other commodity","Error");
                            }
                        });
                    }
                });
            }
        }

        function fetchStorageExpCostFn(rowid,recid){
            var recordid="";
            var arrdatecbx=0;
            var arrdateval=0;
            var lastdateval=0;
            var numofbag=0;
            var recidval=$("#prdRowIdVal").val();

            if(parseInt(recid)!=parseInt(recidval)){
                $.ajax({
                    url: '/getPrdExpCostCommData',
                    type: 'POST',
                    data:{
                        recordid:recid,
                    },
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

                        $.each(data.prdexporder, function(key, value) {
                            $.each($('#prepDynamicTable').find('.arrdatacb'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    arrdatecbx+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.dateval'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    arrdateval+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.lastdateval'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    lastdateval+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.numOfBag'+recidval), function() {
                                if ($(this).val() == '' || isNaN($(this).val())) {
                                    numofbag+= 1;
                                }
                            });

                            if(parseInt(arrdatecbx)==0 && parseInt(arrdateval)==0 && parseFloat(lastdateval)==0 && parseFloat(numofbag)==0){
                                var mindate="";
                                mindate = value.ProductionStartDate == '' ? 0 : value.OrderDate;
                                $("#commoditytitle").html("<div id='actcomm"+value.PrdDetailId+"' class='card actcomm' style='margin-top:0rem;border:0.5px solid #FFFFFF'><div class='card-body p-0 pl-1' style='margin-top:0rem'><table style='width:100%;text-align:left;font-size:11px;'><tr><td style='width:9%'>Type</td><td style='width:25%'>Region, Zone, Woreda</td><td style='width:8%'>Grade</td><td style='width:14%'>Process Type</td><td style='width:9%'>Crop Year</td> <td style='width:18%'>Store</td><td style='width:17%'>Quantity</td> </tr><tr style='font-weight:bold;'> <td>"+value.CommodityTypeName+"</td>  <td>"+value.Origin+"</td> <td>"+value.GradeName+"</td> <td>"+value.ProcessType+"</td> <td></td> <td>"+value.StoreName+"</td> <td>"+value.ExportNumofBag+", "+value.ExportWeightbyKg+" KG</td></tr></table></div></div>");
                                $("#prdCommodityTypeVal").val(value.CommodityType);
                                $("#prdRegionVal").val(value.woredas_id);
                                $("#prdGradeVal").val(value.Grade);
                                $("#prdProcessTypeVal").val(value.ProcessType);
                                $("#predCropYearVal").val("");
                                $("#prdStoreVal").val(value.PrdWarehouse);
                                $("#prdUomVal").val("1");
                                $("#prdQuantityKg").val(value.ExportWeightbyKg);
                                $("#prdQuantityVal").val(value.ExportNumofBag);
                                $("#prdRowIdVal").val(value.PrdDetailId);
                                $("#prdProductionDate").val(value.ProductionEndDate);
                                $("#prdMinDateVal").val(mindate);
                                $("#prdUomFactorVal").val("1");
                                $("#prdBagWeightVal").val("1");
                                $("#prdUomNameVal").val("");
                                $("#prdSymbolVal").val(value.Symbol);
                                $("#commtotaltlb").html("Total of: <b>"+value.Symbol+"</b>");
                                $(".prdrow").hide();
                                $(".prdprop"+value.PrdDetailId).show();
                                $('.commcardcls').prop("disabled",false);
                                $('#commcard'+value.PrdDetailId).prop("disabled",true);
                                $(".commoditytotaltbl").hide();
                                $("#currComodityTable"+value.PrdDetailId).show();
                            }
                            else{
                                for(var q=1;q<=mm;q++){
                                    var arrdatecbxdata=$('#arrDateCbx'+q).val();
                                    var arrdatedata=$('#arrDate'+q).val();
                                    var lastdatedata=$('#prepLastDate'+q).val();
                                    var numofbagdata=$('#prepNumofBag'+q).val();
                                    
                                    if(($('#arrDateCbx'+q).val())!=undefined){
                                        if(arrdatecbxdata==""||arrdatecbxdata==null){
                                            $('#select2-arrDateCbx'+q+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#arrDate'+q).val())!=undefined){
                                        if(arrdatedata==""||arrdatedata==null){
                                            $('#arrDate'+q).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#prepLastDate'+q).val())!=undefined){
                                        if(lastdatedata==""||lastdatedata==null){
                                            $('#prepLastDate'+q).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#prepNumofBag'+q).val())!=undefined){
                                        if(numofbagdata==""||numofbagdata==null){
                                            $('#prepNumofBag'+q).css("background", errorcolor);
                                        }
                                    }
                                }
                                toastrMessage('error',"Please insert valid data on highlighted fields before proceeding to other commodity","Error");
                            }
                        });
                    }
                });
            }
        }

        function fetchStorageRejCostFn(rowid,recid){
            var recordid="";
            var arrdatecbx=0;
            var arrdateval=0;
            var lastdateval=0;
            var numofbag=0;
            var recidval=$("#prdRowIdVal").val();

            if(parseInt(recid)!=parseInt(recidval)){
                $.ajax({
                    url: '/getPrdExpCostCommData',
                    type: 'POST',
                    data:{
                        recordid:recid,
                    },
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

                        $.each(data.prdrejorder, function(key, value) {
                            $.each($('#prepDynamicTable').find('.arrdatacb'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    arrdatecbx+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.dateval'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    arrdateval+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.lastdateval'+recidval), function() {
                                if ($(this).val() == '' || $(this).val() == null) {
                                    lastdateval+= 1;
                                }
                            });

                            $.each($('#prepDynamicTable').find('.numOfBag'+recidval), function() {
                                if ($(this).val() == '' || isNaN($(this).val())) {
                                    numofbag+= 1;
                                }
                            });

                            if(parseInt(arrdatecbx)==0 && parseInt(arrdateval)==0 && parseFloat(lastdateval)==0 && parseFloat(numofbag)==0){
                                var mindate="";
                                mindate = value.ProductionStartDate == '' ? 0 : value.OrderDate;
                                $("#commoditytitle").html("<div id='actcomm"+value.PrdDetailId+"' class='card actcomm' style='margin-top:0rem;border:0.5px solid #FFFFFF'><div class='card-body p-0 pl-1' style='margin-top:0rem'><table style='width:100%;text-align:left;font-size:11px;'><tr><td style='width:9%'>Type</td><td style='width:25%'>Region, Zone, Woreda</td><td style='width:8%'>Grade</td><td style='width:14%'>Process Type</td><td style='width:9%'>Crop Year</td> <td style='width:18%'>Store</td><td style='width:17%'>Quantity</td> </tr><tr style='font-weight:bold;'> <td>"+value.CommodityTypeName+"</td>  <td>"+value.Origin+"</td> <td>"+value.GradeName+"</td> <td>"+value.ProcessType+"</td> <td></td> <td>"+value.StoreName+"</td> <td>"+value.ExportNumofBag+", "+value.ExportWeightbyKg+" KG</td></tr></table></div></div>");
                                $("#prdCommodityTypeVal").val(value.CommodityType);
                                $("#prdRegionVal").val(value.woredas_id);
                                $("#prdGradeVal").val(value.Grade);
                                $("#prdProcessTypeVal").val(value.ProcessType);
                                $("#predCropYearVal").val("");
                                $("#prdStoreVal").val(value.PrdWarehouse);
                                $("#prdUomVal").val("1");
                                $("#prdQuantityKg").val(value.RejectWeightbyKg);
                                $("#prdQuantityVal").val(value.RejectNumofBag);
                                $("#prdRowIdVal").val(value.PrdDetailId);
                                $("#prdProductionDate").val(value.ProductionEndDate);
                                $("#prdMinDateVal").val(mindate);
                                $("#prdUomFactorVal").val("1");
                                $("#prdBagWeightVal").val("1");
                                $("#prdUomNameVal").val("");
                                $("#prdSymbolVal").val(value.Symbol);
                                $("#commtotaltlb").html("Total of: <b>"+value.Symbol+"</b>");
                                $(".prdrow").hide();
                                $(".prdprop"+value.PrdDetailId).show();
                                $('.commcardcls').prop("disabled",false);
                                $('#commcard'+value.PrdDetailId).prop("disabled",true);
                                $(".commoditytotaltbl").hide();
                                $("#currComodityTable"+value.PrdDetailId).show();
                            }
                            else{
                                for(var q=1;q<=mm;q++){
                                    var arrdatecbxdata=$('#arrDateCbx'+q).val();
                                    var arrdatedata=$('#arrDate'+q).val();
                                    var lastdatedata=$('#prepLastDate'+q).val();
                                    var numofbagdata=$('#prepNumofBag'+q).val();
                                    
                                    if(($('#arrDateCbx'+q).val())!=undefined){
                                        if(arrdatecbxdata==""||arrdatecbxdata==null){
                                            $('#select2-arrDateCbx'+q+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#arrDate'+q).val())!=undefined){
                                        if(arrdatedata==""||arrdatedata==null){
                                            $('#arrDate'+q).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#prepLastDate'+q).val())!=undefined){
                                        if(lastdatedata==""||lastdatedata==null){
                                            $('#prepLastDate'+q).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#prepNumofBag'+q).val())!=undefined){
                                        if(numofbagdata==""||numofbagdata==null){
                                            $('#prepNumofBag'+q).css("background", errorcolor);
                                        }
                                    }
                                }
                                toastrMessage('error',"Please insert valid data on highlighted fields before proceeding to other commodity","Error");
                            }
                        });
                    }
                });
            }
        }

        $("#prepadd").click(function() {
            var prdid=$('#productionId').val();
            var storeval=$('#prdStoreVal').val();
            var regionids=$('#prdRegionVal').val();
            var mindateval=$('#prdMinDateVal').val();
            var prddateval=$('#prdProductionDate').val();
            var uomfactor=$('#prdUomFactorVal').val();
            var prdbrowid=$('#prdRowIdVal').val();
            var commtype=$('#prdCommodityTypeVal').val();
            var lastrowcount=$('#prepDynamicTable tr:last').find('td').eq(1).find('input').val();
           
            var arrdate=$('#arrDateCbx'+lastrowcount).val();
  
            if(arrdate!==undefined && isNaN(parseFloat(arrdate))){
                $('#select2-arrDateCbx'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                toastrMessage('error',"Please fill all required fields ","Error");
            }
            else{
                ++ii;
                ++mm;
                ++jj;
                $("#prepDynamicTable > tbody").append('<tr class="prdrow prdprop'+prdbrowid+'" id="preprowind'+mm+'"><td id="rownumid'+mm+'" style="font-weight:bold;width:3%;text-align:center;">'+jj+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="preprow['+mm+'][prepvals]" id="prepvals'+mm+'" class="prepvals form-control" readonly="true" style="font-weight:bold;" value="'+mm+'"/></td>'+
                    '<td style="width:11%;"><select id="arrDateCbx'+mm+'" class="select2 form-control arrDateCbx arrdatacb'+prdbrowid+'" onchange="arrDateCbxFn(this)" name="preprow['+mm+'][arrDateCbx]"></select></td>'+
                    '<td style="width:12%;"><input type="text" id="arrDate'+mm+'" name="preprow['+mm+'][arrDate]" class="prepDate dateval'+prdbrowid+' form-control" placeholder="YYYY-MM-DD" onchange="arrDateFn(this)"/></td>'+
                    '<td style="width:13%;"><input type="text" name="preprow['+mm+'][prepLastDate]" placeholder="YYYY-MM-DD" id="prepLastDate'+mm+'" class="prepLastDate lastdateval'+prdbrowid+' form-control" onchange="lastDateFn(this)"/></td>'+
                    '<td style="width:10%;"><input type="number" name="preprow['+mm+'][prepNumofDay]" placeholder="Number of day" id="prepNumofDay'+mm+'" class="prepNumofDay numOfDay'+prdbrowid+' form-control numeral-mask commnuminp" readonly step="0.0000000001" style="font-weight:bold;"/></td>'+
                    '<td style="width:10%;"><input type="number" name="preprow['+mm+'][prepNumofBag]" placeholder="Write Number of bag" id="prepNumofBag'+mm+'" class="prepNumofBag numOfBag'+prdbrowid+' form-control numeral-mask commnuminp" onkeyup="prepNumofBagFn(this)" onkeypress="return ValidateOnlyNum(event);"/></td>'+
                    '<td style="width:13%;"><input type="number" name="preprow['+mm+'][prepPricePerBag]" placeholder="Price per bag" id="prepPricePerBag'+mm+'" class="prepPricePerBag pricePerBag'+prdbrowid+' form-control numeral-mask commnuminp" onkeyup="prepPricePerBagFn(this)" onkeypress="return ValidateOnlyNum(event);" readonly step="0.0000000001" style="font-weight:bold;"/></td>'+
                    '<td style="width:13%;"><input type="number" name="preprow['+mm+'][prepTotalPrice]" placeholder="Total price" id="prepTotalPrice'+mm+'" class="prepTotalPrice totalPrice'+prdbrowid+' form-control numeral-mask commnuminp" readonly step="0.0000000001" style="font-weight:bold;"/></td>'+
                    '<td style="width:12%;"><input type="text" name="preprow['+mm+'][prepRemark]" id="prepRemark'+mm+'" class="prepRemark form-control" placeholder="Write Remark here..."/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="prepremovebtn'+mm+'" class="btn btn-light btn-sm prepremove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF;padding: 1px 1px"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="preprow['+mm+'][prepid]" id="prepid'+mm+'" class="prepid form-control" readonly="true" style="font-weight:bold;"/></td></tr>'
                );
                
                var defaultoption = '<option selected value=""></option>';
                var emptyoption='<option title='+regionids+' value=0>-</option>';

                if(parseInt(commtype)==1){
                    var arrivaldatedefault = $("#arrivaldatedefault > option").clone();
                    $('#arrDateCbx'+mm).append(emptyoption);
                    $('#arrDateCbx'+mm).append(arrivaldatedefault);
                    $("#arrDateCbx"+mm+" option[title!="+regionids+"]").remove(); 

                    $('#prepDynamicTable > tbody > tr.prdprop'+prdbrowid).each(function(index) {
                        var row = $(this);
                        var indx=row.find('td').eq(1).find('input').val()||0;
                        if(($('#arrDateCbx'+indx).val())!=undefined){
                            var selectedval=$('#arrDateCbx'+indx).val();
                            if(selectedval!=0){
                                $("#arrDateCbx"+mm+" option[value='"+selectedval+"']").remove();   
                            }
                        }
                    });

                    $('#arrDateCbx'+mm).append(defaultoption);
                    $('#arrDateCbx'+mm).select2
                    ({
                        placeholder: "Select Arrival date here",
                        dropdownCssClass : 'cusprop',
                    });
                    
                    flatpickr('#arrDate'+mm, { dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate,minDate:mindateval});
                    $('#arrDate'+mm).val("");

                    flatpickr('#prepLastDate'+mm, { dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate,minDate:mindateval});
                    $('#prepLastDate'+mm).val(prddateval);
                }
                else{
                    var defaultselected='<option title='+regionids+' value=0>-</option>';
                    $('#arrDateCbx'+mm).append(defaultselected);
                    $('#arrDateCbx'+mm).select2
                    ({
                        minimumResultsForSearch: -1,
                        dropdownCssClass : 'cusprop',
                    });

                    flatpickr('#arrDate'+mm, { dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate,minDate:mindateval});
                    $('#arrDate'+mm).val(prddateval);

                    flatpickr('#prepLastDate'+mm, { dateFormat: 'Y-m-d',clickOpens:true,minDate:mindateval});
                    $('#prepLastDate'+mm).val("");
                }

                renumberPrepRows();
                $('#select2-arrDateCbx'+mm+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#prepdynamictbl-error').html("");
            }
        });

        function renumberPrepRows() {
            var ind;
            var prdbrowid=$('#prdRowIdVal').val();
            $('#prepDynamicTable tr.prdprop'+prdbrowid).each(function(index, el) {
                $(this).children('td').first().text(++index);
            });
        }

        $(document).on('click', '.prepremove-tr', function() {
            $(this).parents('tr').remove();
            renumberPrepRows();
            CalculateCommodityTotal();
            var prdbrowid=$('#prdRowIdVal').val();
            --ii;
        });

        function arrDateCbxFn(ele) {
            var idval = $(ele).closest('tr').find('.prepvals').val();
            var arrdate=$('#arrDateCbx'+idval).val();
            var mindateval=$('#prdMinDateVal').val();
            var arrvdate=$('#arrDate'+idval).val();
            var lastdayval=$('#prepLastDate'+idval).val();
            if(parseInt(arrdate)==0){
                flatpickr('#arrDate'+idval, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:mindateval});
                $('#arrDate'+idval).val("");
            }
            else{
                flatpickr('#arrDate'+idval, { dateFormat: 'Y-m-d',clickOpens:false,maxDate:currentdate});
                $('#arrDate'+idval).val(arrdate);
                $('#arrDate'+idval).css("background","white");
                if(arrvdate!=null && lastdayval!=null){
                    CalcDateDifference(idval);
                }
            }
            $('#select2-arrDateCbx'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            CalculateCommodityTotal();
        }

        function arrDateFn(ele) {
            var idval = $(ele).closest('tr').find('.prepvals').val();
            var arrdate=$('#arrDateCbx'+idval).val();
            var mindateval=$('#prdMinDateVal').val();
            var arrvdate=$('#arrDate'+idval).val();
            var lastdayval=$('#prepLastDate'+idval).val();

            var dupcount=0;
            for(var q=1;q<=mm;q++){
                if($('#arrDate'+q).val() == arrvdate && $('#prepLastDate'+q).val() == lastdayval){
                    dupcount+=1;
                }
            }
            if(parseInt(dupcount)<=1){
                if(arrvdate!=null && lastdayval!=null){
                    CalcDateDifference(idval);
                }
                $('#arrDate'+idval).css("background","white");
            }
            else if(parseInt(dupcount)>1){
                $('#arrDate'+idval).val("");
                $('#arrDate'+idval).css("background",errorcolor);
                toastrMessage('error',"Arrival date is selected with production date","Error");
            }
            CalculateCommodityTotal();
        }

        function lastDateFn(ele) {
            var idval = $(ele).closest('tr').find('.prepvals').val();
            var arrdate=$('#arrDateCbx'+idval).val();
            var mindateval=$('#prdMinDateVal').val();
            var arrvdate=$('#arrDate'+idval).val();
            var lastdayval=$('#prepLastDate'+idval).val();

            var dupcount=0;
            for(var q=1;q<=mm;q++){
                if($('#arrDate'+q).val() == arrvdate && $('#prepLastDate'+q).val() == lastdayval){
                    dupcount+=1;
                }
            }
            if(parseInt(dupcount)<=1){
                if(arrvdate!=null && lastdayval!=null){
                    CalcDateDifference(idval);
                }
                $('#prepLastDate'+idval).css("background","white");
            }
            else if(parseInt(dupcount)>1){
                $('#prepLastDate'+idval).val("");
                $('#prepLastDate'+idval).css("background",errorcolor);
                toastrMessage('error',"Production date is selected with arrival date","Error");
            }
            CalculateCommodityTotal();
        }

        function prepNumofBagFn(ele){
            var idval = $(ele).closest('tr').find('.prepvals').val();
            var prdbrowid=$('#prdRowIdVal').val();
            var prdQuantity=$('#prdQuantityVal').val();
            var prdNumOfBag=$('#prepNumofBag'+idval).val();
            prdQuantity = prdQuantity == '' ? 0 : prdQuantity;
            prdbrowid = prdbrowid == '' ? 0 : prdbrowid;
            prdNumOfBag = prdNumOfBag == '' ? 0 : prdNumOfBag;
            var totalbag=CalcTotalBag(prdbrowid);
            totalbag = totalbag == '' ? 0 : totalbag;
            $('#prepNumofBag'+idval).css("background","white");
            if(parseFloat(totalbag)>parseFloat(prdQuantity)){
                $('#prepNumofBag'+idval).css("background",errorcolor);
                $('#prepNumofBag'+idval).val("");
                toastrMessage('error',"Number of bag can not be greater than total bag","Error");
            }
            else if(parseFloat(prdNumOfBag)==0){
                $('#prepNumofBag'+idval).css("background",errorcolor);
                $('#prepNumofBag'+idval).val("");
                toastrMessage('error',"Number of bag can not be zero","Error");
            }
            CalculateCommodityTotal();
        }

        function prepPricePerBagFn(ele){
            var idval = $(ele).closest('tr').find('.prepvals').val();
            var prdbrowid=$('#prdRowIdVal').val();
            var prdQuantity=$('#prdQuantityVal').val();
            prdQuantity = prdQuantity == '' ? 0 : prdQuantity;
            prdbrowid = prdbrowid == '' ? 0 : prdbrowid;
            var totalbag=CalcTotalBag(prdbrowid);
            totalbag = totalbag == '' ? 0 : totalbag;
            $('#prepPricePerBag'+idval).css("background","white");
            if(parseFloat(totalbag)>parseFloat(prdQuantity)){
                $('#prepPricePerBag'+idval).css("background",errorcolor);
                $('#prepPricePerBag'+idval).val("");
                toastrMessage('error',"Number of bag can not be greater than total bag","Error");
            }
            CalculateCommodityTotal();
        }

        function CalcDateDifference(index){
            var arrdate=$('#arrDate'+index).val();
            var lastdate=$('#prepLastDate'+index).val();
            var arrivaldate="";
            var lastdates="";
            var commtype="";
            if(arrdate!=null && lastdate!=null){
                $.ajax({
                    url: '/getCommtDateDiff',
                    type: 'POST',
                    data:{
                        arrivaldate:$('#arrDate'+index).val(),
                        lastdates:$('#prepLastDate'+index).val(),
                        commtype:$('#prdCommodityTypeVal').val(),
                    },
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
                        $('#prepNumofDay'+index).val(data.diffInDays);
                        $('#prepPricePerBag'+index).val(data.prdamount);
                        CalculateCommodityTotal();
                    },
                });
            }
        }

        function CalcTotalBag(clsval){
            var totalnumofbag=0;
            $.each($('#prepDynamicTable').find('.numOfBag'+clsval), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalnumofbag+= parseFloat($(this).val());
                }
            });
            return totalnumofbag;
        }

        function CalcEachCommodity(clsval){
            var grandtotalprice=0;
            var taxprice=0;
            var subtotalprice=0;
            $.each($('#prepDynamicTable').find('.totalPrice'+clsval), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandtotalprice+= parseFloat($(this).val());
                }
            });
            subtotalprice=(parseFloat(grandtotalprice)/parseFloat(1.15));
            taxprice=parseFloat(grandtotalprice)-parseFloat(subtotalprice);
            $('#commtax').html(numformat(taxprice.toFixed(2)));
            $('#commsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#commgrandtotal').html(numformat(grandtotalprice.toFixed(2)));
        }

        function CalculateCommodityTotal(){
            var numofbag=0;
            var priceperbag=0;
            var totalprice=0;
            var prdbrowid=$('#prdRowIdVal').val();

            $('#prepDynamicTable > tbody > tr').each(function() {
                indnum = $(this).find('td').eq(1).find('input').val();
                numofbag = $('#prepNumofBag'+indnum).val();
                priceperbag = $('#prepPricePerBag'+indnum).val();
                numofbag = numofbag == '' ? 0 : numofbag;
                priceperbag = priceperbag == '' ? 0 : priceperbag;
                totalprice=parseFloat(numofbag)*parseFloat(priceperbag);
                $('#prepTotalPrice'+indnum).val(totalprice.toFixed(2));
            });
            CalcEachCommodity(prdbrowid);
            CalculateGrandTotalPrice();
        }

        function CalculateGrandTotalPrice(){
            var grandtotalprice=0;
            var taxprice=0;
            var subtotalprice=0;
            $.each($('#prepDynamicTable').find('.prepTotalPrice'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandtotalprice+= parseFloat($(this).val());
                }
            });
            subtotalprice=(parseFloat(grandtotalprice)/parseFloat(1.15));
            taxprice=parseFloat(grandtotalprice)-parseFloat(subtotalprice);
            $('#strcommtax').html(numformat(taxprice.toFixed(2)));
            $('#strcommsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#strcommgrandtotal').html(numformat(grandtotalprice.toFixed(2)));

            $('#strtax').html(numformat(taxprice.toFixed(2)));
            $('#strsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#strgrandtotal').html(numformat(grandtotalprice.toFixed(2)));

            CalculateSummary();
        }

        function CalculateSummary(){
            var grandtotalprice=0;
            var taxprice=0;
            var subtotalprice=0;
            var prctotalprice=$('#proctotalprice').val();
            var priceothcost=$('#procotherscost').val();
            prctotalprice = prctotalprice == '' ? 0 : prctotalprice;
            priceothcost = priceothcost == '' ? 0 : priceothcost;
            $.each($('#prepDynamicTable').find('.prepTotalPrice'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandtotalprice+= parseFloat($(this).val());
                }
            });
            grandtotalprice+= parseFloat(prctotalprice);
            grandtotalprice+= parseFloat(priceothcost);

            subtotalprice=(parseFloat(grandtotalprice)/parseFloat(1.15));
            taxprice=parseFloat(grandtotalprice)-parseFloat(subtotalprice);
            $('#summtax').html(numformat(taxprice.toFixed(2)));
            $('#summsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#summgrandtotal').html(numformat(grandtotalprice.toFixed(2)));
        }

        function calcProcessFn(){
            var producedqty=$('#procproducedqty').val();
            var priceperton=$('#procpriceperton').val();
            var totalprice=0;
            var taxprice=0;
            var subtotalprice=0;

            producedqty = producedqty == '' ? 0 : producedqty;
            priceperton = priceperton == '' ? 0 : priceperton;
            totalprice=parseFloat(producedqty)*parseFloat(priceperton);
            subtotalprice=(parseFloat(totalprice)/parseFloat(1.15));
            taxprice=parseFloat(totalprice)-parseFloat(subtotalprice);
            $('#proctotalprice').val(totalprice.toFixed(2));

            $('#proctax').html(numformat(taxprice.toFixed(2)));
            $('#procsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#procgrandtotal').html(numformat(totalprice.toFixed(2)));

            $('#prctax').html(numformat(taxprice.toFixed(2)));
            $('#prcsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#prcgrandtotal').html(numformat(totalprice.toFixed(2)));

            CalculateSummary();
        }

        function calcOthersFn(){
            var priceothcost=$('#procotherscost').val();
            var taxprice=0;
            var subtotalprice=0;
            priceothcost = priceothcost == '' ? 0 : priceothcost;
            
            subtotalprice=(parseFloat(priceothcost)/parseFloat(1.15));
            taxprice=parseFloat(priceothcost)-parseFloat(subtotalprice);
            priceothcost=parseFloat(priceothcost)*parseFloat(1);
            $('#othcommtax').html(numformat(taxprice.toFixed(2)));
            $('#othcommsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#othcommgrandtotal').html(numformat(priceothcost.toFixed(2)));

            $('#othtax').html(numformat(taxprice.toFixed(2)));
            $('#othsubtotal').html(numformat(subtotalprice.toFixed(2)));
            $('#othgrandtotal').html(numformat(priceothcost.toFixed(2)));
            $('#procotherscost').css("background","white");
            CalculateSummary();
        }

        function closeRegisterModal() {
            $('.mainforminp').val("");
            $('#status').val("Active");
            $('.prdprop').hide();
            $('.errordatalabel').html('');
            $('#recId').val("");
            $('#storageDiv').hide();
            $('#operationtypes').val("1");
            $('#carddatacanvas').empty();
            $('#type').select2({
                minimumResultsForSearch: -1
            });
            $('#ProductionType').val(null).select2({
                minimumResultsForSearch: -1
            });

            $('#Customer').val(null).select2({
                placeholder:"Select Customer here"
            });

            $('#ProductionOrderNumber').val(null).select2({
                placeholder:"Select Production order number here"
            });
            $("#prepDynamicTable > tbody").empty();
        }

        $('#isTaxable').change(function() {
            if($(this).is(":checked")) {
                $('.taxcalcflagcls').show();
                $('#isTaxable').prop("checked",true);
            }
            else{
                $('.taxcalcflagcls').hide();
                $('#isTaxable').prop("checked",false);
            }
        });

        function othCostDescFn() {
            $('#OthersCostDescription').css("background","white");
        }

        function remarkFn() {
            $('#remark-error').html('');
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection
