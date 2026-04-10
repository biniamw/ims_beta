@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Commodity-Beginning-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom" style="height: 5rem;padding: 0.8rem;">
                            <div style="width:19%;">
                                <h3 class="card-title">Commodity Beginning</h3>
                            </div>
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="owner-tab" data-toggle="tab" href="#ownertab" aria-controls="ownertab" role="tab" aria-selected="true" onclick="tableReloadFn(1)">Owner</a>                                
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="customer-tab" data-toggle="tab" href="#customertab" aria-controls="customertab" role="tab" aria-selected="false" onclick="tableReloadFn(2)">Customers</a>
                                </li>
                            </ul>
                            <div style="text-align: right;">
                                
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active" id="ownertab" aria-labelledby="ownertab" role="tabpanel">
                                    <div class="row" style="position: absolute;left: 270px;top: 83px;width:50%;z-index: 10;display:none" id="fiscalyear_div">
                                        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-12">
                                            <select class="select2 form-control" name="fiscalyear[]" id="fiscalyear" onchange="fiscalyrfn()">
                                            @foreach ($fiscalyears as $ownnerfy)
                                                <option value="{{ $ownnerfy->FiscalYear }}">{{ $ownnerfy->Monthrange }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-12">
                                            <select class="selectpicker form-control dropdownclass" name="product_type[]" id="product_type" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                            @foreach ($prdtypedata as $ownprdtype)
                                                <option selected value="{{ $ownprdtype->ProductType }}">{{ $ownprdtype->ProductType }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div style="width:99%; margin-left:0.5%;" id="owner_dt" style="display: none;">
                                        <div>
                                            <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:13%;">Beginning Doc. No.</th>
                                                        <th style="width:13%;">Ending Doc. No.</th>
                                                        <th style="width:13%;">Product Type</th>
                                                        <th style="width:15%;">Store/ Station</th>
                                                        <th style="width:13%;">Fiscal Year</th>
                                                        <th style="width:13%;">Date</th>
                                                        <th style="width:13%;">Status</th>
                                                        <th style="width:4%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="customertab" aria-labelledby="customertab" role="tabpanel">
                                    <div class="row" style="position: absolute;left: 270px;top: 83px;width:50%;z-index: 10;display:none" id="cus_fiscalyear_div">
                                        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-12">
                                            <select class="select2 form-control" name="cus_fiscalyear[]" id="cus_fiscalyear" onchange="cus_fiscalyrfn()">
                                            @foreach ($fiscalyears as $customerfy)
                                                <option value="{{ $customerfy->FiscalYear }}">{{ $customerfy->Monthrange }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-xl-4 col-md-6 col-sm-12 col-12">
                                            <select class="selectpicker form-control dropdownclass" name="cus_product_type[]" id="cus_product_type" title="Select product type here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                            @foreach ($prdtypedata as $cusprdtype)
                                                <option selected value="{{ $cusprdtype->ProductType }}">{{ $cusprdtype->ProductType }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div style="width:99%; margin-left:0.5%;" id="customer_dt" style="display: none;">
                                        <div>
                                            <table id="customersdatatable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="display: none;"></th>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:9%;">Beginning Doc. No.</th>
                                                        <th style="width:9%;">Ending Doc. No.</th>
                                                        <th style="width:9%;">Product Type</th>
                                                        <th style="width:9%;">Customer Code</th>
                                                        <th style="width:12%;">Customer Name</th>
                                                        <th style="width:9%;">Customer TIN</th>
                                                        <th style="width:9%;">Store/ Station</th>
                                                        <th style="width:9%;">Fiscal Year</th>
                                                        <th style="width:9%;">Date</th>
                                                        <th style="width:9%;">Status</th>
                                                        <th style="width:4%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                            </table>
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
    @endcan

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add Commodity Beginning</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row mt-1 mb-1">
                            <div class="col-xl-3 col-md-3 col-sm-6">
                                <label style="font-size: 14px;">Product Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="ProductType" id="ProductType" onchange="prTypeFn()">
                                    <option selected disabled value=""></option>
                                    @foreach ($prdtypedata as $prdtypedata)
                                    <option value="{{$prdtypedata->ProductTypeValue}}">{{$prdtypedata->ProductType}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="prdtype-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-6">
                                <label style="font-size: 14px;">Customer</label><label style="color: red; font-size:16px;">*</label>
                                <div>
                                    <select class="select2 form-control" name="customers_id" id="customers_id" onchange="customerFn()">
                                        <option selected disabled value=""></option>
                                        @foreach ($customers as $customers)
                                            <option value="{{ $customers->id }}">{{ $customers->Code }}     ,     {{ $customers->Name }}     ,     {{ $customers->TinNumber }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger">
                                    <strong id="customer-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-6">
                                <label style="font-size: 14px;">Store/ Station</label><label style="color: red; font-size:16px;">*</label>
                                <div>
                                    <select class="select2 form-control" name="stores_id" id="stores_id" onchange="storeFn()">
                                        <option selected disabled value=""></option>
                                        @foreach ($storedata as $storedata)
                                            <option value="{{ $storedata->id }}">{{ $storedata->Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger">
                                    <strong id="store-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-6">
                                <label style="font-size: 14px;">Remark</label>
                                <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" rows="2" name="Remark" id="Remark" onkeyup="remarkFn()"></textarea>
                                <span class="text-danger">
                                    <strong id="remark-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-1">
                        <div class="row dynamictblclass" id="goods_div">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <table id="goodsDynamicTable" class="mb-0 rtable" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:3%;">#</th>
                                            <th style="width:13%">Location <label style="color: red; font-size:16px;">*</label></th>
                                            <th style="width:16%">Item Name <label style="color: red; font-size:16px;">*</label></th>
                                            <th style="width:13%">UOM <label style="color: red; font-size:16px;">*</label></th>
                                            <th style="width:13%">Quantity <label style="color: red; font-size:16px;">*</label></th>
                                            <th style="width:13%">Unit Cost <label style="color: red; font-size:16px;">*</label></th>
                                            <th style="width:13%">Total Cost <label style="color: red; font-size:16px;">*</label></th>
                                            <th style="width:13%">Remark</th>
                                            <th style="width:3%"></th>
                                        </tr>
                                    <thead>
                                    <tbody></tbody>
                                    <tfoot>
                                        <tr>
                                            <th style="background-color:#FFFFFF;padding: 0px 0px 0px 0px;border-color:#FFFFFF;text-align:left" colspan="6">
                                                <button type="button" name="addgoods" id="addgoods" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                <label style="font-size: 16px;text-align:right;float:right;">Total</label>
                                            </th>
                                            <th style="background-color:#efefef;border-color:#FFFFFF;text-align:center">
                                                <label style="font-size: 16px;font-weight:bold;" class="infototalcost" id="infototalcost"></label>
                                            </th>
                                            <th colspan="2" style="background-color:#FFFFFF;border-color:#FFFFFF;"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row dynamictblclass" id="commodity_div">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div>
                                    <table id="dynamicTable" class="mb-0 cbegtable" style="width:100%;">
                                        {{-- <thead style="font-size: 13px;">
                                            <tr>
                                                <th style="width:2%;">#</th>
                                                <th style="width:6%">Floor Map<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:7%" title="Arrival Date">Arr. Date</th>
                                                <th style="width:8%">Type<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:12%">Region, Zone, Woreda<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:7%">Grade<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:7%">Process Type<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:7%">Crop Year<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:7%">UOM<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:8%">Balance by KG<label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:8%">Unit Cost<i style="font-size: 8px;">(Before VAT)</i></th>
                                                <th style="width:8%">Total Cost<i style="font-size: 7px;">(Before VAT)</i><label id="feresulainfolbl" title="Total Price= Balance * Unit Cost"><i class="fa-solid fa-circle-info"></i></label></th>
                                                <th style="width:10%">Remark</th>
                                                <th style="width:2%"></th>
                                            </tr>
                                        <thead> --}}
                                        <tbody></tbody>
                                    </table>
                                    <table class="mb-0">
                                        <tr>
                                            <td>
                                                <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                            <td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-12"></div>
                                    <div class="col-xl-3 col-lg-12">
                                        <table style="width:100%;text-align:right" id="pricingTable" class="rtable">
                                            <tr style="background-color: #f8f9fa;">
                                                <td style="text-align: right;width:60%"><label id="totalnumofbag" style="font-size: 14px;">Total Number of Bag</label></td>
                                                <td style="text-align: center;width:40%">
                                                    <label id="totalnumberofbag" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalnumberofbagval" id="totalnumberofbagval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label id="totalweightkg" style="font-size: 14px;">Total Bag Weight by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbagweightbykg" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalbagweightbykgval" id="totalbagweightbykgval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td style="text-align: right;"><label id="totalbykg" style="font-size: 14px;">Total Balance by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbalancekg" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalbalancekgval" id="totalbalancekgval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label id="totalvarinceshortage" style="font-size: 14px;">Total Variance Shortage by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalvarianceshortage" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalvarianceshortageval" id="totalvarianceshortageval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label id="totalvarinceoverage" style="font-size: 14px;">Total Variance Overage by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalvarianceoverage" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalvarianceoverageval" id="totalvarianceoverageval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label id="totalbyferesula" style="font-size: 14px;">Total Balance by Feresula</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbalanceferesula" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalferesulaval" id="totalferesulaval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label id="totalbyton" style="font-size: 14px;">Total Balance by TON</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbalanceton" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalbalancetonval" id="totalbalancetonval" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td colspan="2" style="text-align: center">-</td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label id="subGrandTotalLbl" style="font-size: 14px;">Total Value</label></td>
                                                <td style="text-align: center;">
                                                    <label id="subtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr class="vatproperty" style="display: none;">
                                                <td style="text-align: right;"><label strong style="font-size: 14px;">Tax</label></td>
                                                <td style="text-align: center;">
                                                    <label id="taxLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="taxi" id="taxi" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr class="vatproperty" style="display: none;">
                                                <td style="text-align: right;"><label strong style="font-size: 14px;">Grand Total</label></td>
                                                <td style="text-align: center;">
                                                    <label id="grandtotalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="grandtotali" id="grandtotali" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="display: none;">
                                                <td style="text-align: right;"><label strong style="font-size: 14px;">No. of Items</label></td>
                                                <td style="text-align: center;"><label id="numberofItemsLbl" strong style="font-size: 14px; font-weight: bold;">0</label></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="supplierdefault" id="supplierdefault">
                                <option selected disabled value=""></option>
                                @foreach ($supplierdata as $supplierdata)
                                    <option value="{{ $supplierdata->id }}">{{ $supplierdata->Code }}   ,   {{ $supplierdata->Name }}   ,   {{ $supplierdata->TinNumber }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="locationdefault" id="locationdefault">
                                <option selected disabled value=""></option>
                                @foreach ($locationdata as $locationdata)
                                    <option title="{{$locationdata->StoreId}}" value="{{ $locationdata->id }}">{{ $locationdata->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="uomdefault" id="uomdefault">
                                <option selected disabled value=""></option>
                                @foreach ($uomdata as $uomdata)
                                    <option title="{{$uomdata->uomamount}}" label="{{$uomdata->bagweight}}" value="{{ $uomdata->id }}">{{ $uomdata->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="origindefault" id="origindefault">
                                <option selected disabled value=""></option>
                                @foreach ($origin as $origin)
                                    <option title="{{$origin->CommType}}" value="{{ $origin->id }}">{{ $origin->Origin }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="itemsdefault" id="itemsdefault">
                                <option selected disabled value=""></option>
                                @foreach ($items as $items)
                                    <option value="{{ $items->id }}">{{ $items->Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="CurrentDateVal" id="CurrentDateVal" placeholder="YYYY-MM-DD" class="CurrentDateVal form-control" style="font-weight: bold;" value="{{$currentdate}}" readonly/>
                        <input type="hidden" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savebuttongood" type="button" class="btn btn-info savebtnclass">Save</button>
                        <button id="savebutton" type="button" class="btn btn-info savebtnclass">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="InformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Beginning Information</h4>
                        <div class="row">
                            <div style="text-align: right" id="statustitles"></div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Beginning Basic & Action Information</span>
                                                        <div id="statustitlesA"></div>
                                                    </div>
                                                    <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table style="width: 100%;" class="infotbl">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Beginning Doc. No.</label></td>
                                                                                            <td style="width: 70%"><label id="infobeginningdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Ending Doc. No.</label></td>
                                                                                            <td><label id="infoendingdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Product Type</label></td>
                                                                                            <td><label id="infoproducttype" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Store/ Station</label></td>
                                                                                            <td><label id="infostorename" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Fiscal Year</label></td>
                                                                                            <td><label id="infofiscalyear" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Remark</label></td>
                                                                                            <td><label id="inforemark" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table id="customerinfotbl" class="infotbl" style="width: 100%;">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                                            <td style="width: 70%"><label id="infocustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                                            <td><label id="infocustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                                            <td><label id="infocustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                                            <td><label id="infocustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                                            <td><label id="infocustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:12rem">
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
                            <hr class="m-0">
                            <div class="row detail_table" id="goods_dt_div">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12" style="text-align: right;">
                                            <a id="goods_downloatoexcel" href="javascript:void(0);" title="Export the table to excel" class="exportbtns"><i class="fa-solid fa-file-excel fa-lg" style="color: #00cfe8" aria-hidden="true"></i></a>
                                            <a id="goods_downloadtopdf" href="javascript:void(0);" title="Export the table to Pdf" class="exportbtns"><i class="fa-solid fa-file-pdf fa-lg" style="color: #00cfe8" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                            <div class="table-responsive scroll scrdiv">
                                                <table id="goodsdatatable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                    <thead> 
                                                        <tr>
                                                            <th style="width:4%;">#</th>
                                                            <th style="width:13%;">Location</th>
                                                            <th style="width:16%">Item Name</th>
                                                            <th style="width:13%">UOM</th>
                                                            <th style="width:13%">Quantity</th>
                                                            <th style="width:13%">Unit Cost</th>
                                                            <th style="width:13%">Total Cost</th>
                                                            <th style="width:16%">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <th colspan="6" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                        <th style="font-size: 16px;padding:6px;" id="goods_total_cost"></th>
                                                        <th></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row detail_table" id="commodity_dt_div">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12" style="text-align: right;">
                                            <a id="downloatoexcel" href="javascript:void(0);" title="Export the table to excel" class="exportbtns"><i class="fa-solid fa-file-excel fa-lg" style="color: #00cfe8" aria-hidden="true"></i></a>
                                            <a id="downloadtopdf" href="javascript:void(0);" title="Export the table to Pdf" class="exportbtns"><i class="fa-solid fa-file-pdf fa-lg" style="color: #00cfe8" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
                                            <div class="table-responsive scroll scrdiv">
                                                <table id="origindetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                    <thead> 
                                                        <tr>
                                                            <th style="width:2%;">#</th>
                                                            <th style="width:4%;text-align:left;">Floor Map</th>
                                                            <th style="width:4%;text-align:left;" title="Arrival Date">Arrival Date</th>
                                                            <th style="width:4%">Type</th>
                                                            <th style="width:5%">Supplier</th>
                                                            <th style="width:4%" title="GRN Number">GRN No.</th>
                                                            <th style="width:5%" title="Production Order Number">Production Order No.</th>
                                                            <th style="width:4%" title="Certificate Number">Certificate No.</th>
                                                            <th style="width:5%">Commodity</th>
                                                            <th style="width:4%">Grade</th>
                                                            <th style="width:5%">Process Type</th>
                                                            <th style="width:4%">Crop Year</th>
                                                            <th style="width:4%">UOM/ Bag</th>
                                                            <th style="width:5%">No. of Bag</th>
                                                            <th style="width:4%">Bag Weight by KG</th>
                                                            <th style="width:4%">Total KG</th>
                                                            <th style="width:4%">Net KG</th>
                                                            <th style="width:4%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:4%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:4%">Unit Cost<i class="fa-solid fa-circle-info" title="Before VAT"></i></th>
                                                            <th style="width:4%">Total Cost<label id="feresulainfolbl" title="Total Cost= Net KG * Unit Cost"><i class="fa-solid fa-circle-info"></i></label></th>
                                                            <th style="width:4%">Variance Shortage by KG</th>
                                                            <th style="width:4%">Variance Overage by KG</th>
                                                            <th style="width:5%">Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot class="table table-sm">
                                                        <th colspan="13" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalbag"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalbagweight"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalgrosskg"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalkg"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalton"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalferesula"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalunitcost"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalvaluedata"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalvarshortage"></th>
                                                        <th style="font-size: 16px;padding:5px;" id="totalvarovrage"></th>
                                                        <th></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="customerOrOwnerName" id="customerOrOwnerName" readonly="true"/> 
                        <input type="hidden" class="form-control" name="recInfoId" id="recInfoId" readonly="true"/> 
                        @can('Commodity-Beginning-ChangeToCounting')
                        <button id="changetocntbtn" type="button" onclick="getChangeBtn()" class="btn btn-info" style="display: none;">Change to Counting</button>
                        @endcan
                        @can('Commodity-Beginning-FinishCounting')
                        <button id="donebtn" type="button" onclick="getDoneInfo()" class="btn btn-info" style="display: none;">Finish Counting</button>
                        @endcan
                        @can('Commodity-Beginning-Verify')
                        <button id="verifybtn" type="button" onclick="getVerifyInfo()" class="btn btn-info" style="display: none;">Verify</button>
                        @endcan
                        @can('Commodity-Beginning-Post')
                        <button id="postbtn" type="button" onclick="getPostInfo()" class="btn btn-info" style="display: none;">Post</button>
                        @endcan
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Information Modal -->

    <!--Start Ending Modal --> 
    <div class="modal fade" id="manageendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="EndingForm">
        {{ csrf_field() }}
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ending Form</h4>
                        <div class="row">
                            <div style="text-align: right" id="statustitlesB"></div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    </div>
                    
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse2" class="card-header" data-toggle="collapse" role="button" data-target=".infoend" aria-expanded="false" aria-controls="collapse1">
                                                        <span class="lead collapse-title">Beginning Information</span>
                                                        <div id="statustitlesB"></div>
                                                    </div>
                                                    <div id="collapse2" role="tabpanel" aria-labelledby="headingCollapse2" class="collapse infoend">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table style="width: 100%;" class="infotbl">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Beginning Doc. No.</label></td>
                                                                                            <td style="width: 70%"><label id="infoendinningdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Ending Doc. No.</label></td>
                                                                                            <td id="ending_doc_lbl"></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Store/ Station</label></td>
                                                                                            <td><label id="infoendingstorename" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Fiscal Year</label></td>
                                                                                            <td><label id="infoendingfiscalyear" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Remark</label></td>
                                                                                            <td><label id="infoendingremark" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table id="customerendinginfotbl" class="infotbl" style="width: 100%;display:none;">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                                            <td style="width: 70%"><label id="infoendingcustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                                            <td><label id="infoendingcustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                                            <td><label id="infoendingcustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                                            <td><label id="infoendingcustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                                            <td><label id="infoendingcustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
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
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 product_type_div" id="ending_commodity_div">
                                    <table id="endingtbl" class="mb-0 cbegtable" style="width:100%;">
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 product_type_div" id="ending_goods_div">
                                    <table id="goods_ending_tbl" class="mb-0 rtable" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:12%">Location</th>
                                                <th style="width:13%">Item Name</th>
                                                <th style="width:12%">UOM</th>
                                                <th style="width:12%">Average Cost</th>
                                                <th style="width:12%">System Count</th>
                                                <th style="width:12%">Physical Count <label style="color: red; font-size:16px;">*</label></th>
                                                <th style="width:12%">Variance Shortage</th>
                                                <th style="width:12%">Variance Overage</th>
                                            </tr>
                                        <thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="background-color:#FFFFFF;padding: 0px 0px 0px 0px;border-color:#FFFFFF;text-align:left" colspan="5">
                                                    <label style="font-size: 16px;text-align:right;float:right;">Total</label>
                                                </th>
                                                <th style="background-color:#efefef;border-color:#FFFFFF;text-align:center">
                                                    <label style="font-size: 16px;font-weight:bold;" class="infototalcost" id="info_total_system_count"></label>
                                                </th>
                                                <th style="background-color:#efefef;border-color:#FFFFFF;text-align:center">
                                                    <label style="font-size: 16px;font-weight:bold;" class="infototalcost" id="info_total_physical_count"></label>
                                                </th>
                                                <th style="background-color:#efefef;border-color:#FFFFFF;text-align:center">
                                                    <label style="font-size: 16px;font-weight:bold;" class="infototalcost" id="info_total_variance_shortage"></label>
                                                </th>
                                                <th style="background-color:#efefef;border-color:#FFFFFF;text-align:center">
                                                    <label style="font-size: 16px;font-weight:bold;" class="infototalcost" id="info_total_variance_overage"></label>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1">
                                <div class="row product_type_div" id="commodity_total_div" style="display:none;">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"></div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                        <table style="width:100%;text-align:right" id="endingPricingTable" class="rtable">
                                            <tr style="background-color: #f8f9fa;">
                                                <td style="text-align: right;width:60%"><label style="font-size: 14px;">Total Number of Bag</label></td>
                                                <td style="text-align: center;width:40%">
                                                    <label id="totalnumberofbag_ending" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalnumberofbagval_ending" id="totalnumberofbagval_ending" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label id="totalweightkg" style="font-size: 14px;">Total Bag Weight by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbagweightbykg_ending" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalbagweightbykgval_ending" id="totalbagweightbykgval_ending" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td style="text-align: right;"><label style="font-size: 14px;">Total Balance by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbalancekg_ending" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalbalancekgval_ending" id="totalbalancekgval_ending" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label style="font-size: 14px;">Total Discrepancy Shortage by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="total_shortage_disc_by_kg_lbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="total_shortage_disc_by_kg_inp" id="total_shortage_disc_by_kg_inp" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label style="font-size: 14px;">Total Discrepancy Overage by KG</label></td>
                                                <td style="text-align: center;">
                                                    <label id="total_overage_disc_by_kg_lbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="total_overage_disc_by_kg_inp" id="total_overage_disc_by_kg_inp" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label style="font-size: 14px;">Total Discrepancy Shortage by Bag</label></td>
                                                <td style="text-align: center;">
                                                    <label id="total_shortage_disc_by_bag_lbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="total_shortage_disc_by_bag_inp" id="total_shortage_disc_by_bag_inp" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label style="font-size: 14px;">Total Discrepancy Overage by Bag</label></td>
                                                <td style="text-align: center;">
                                                    <label id="total_overage_disc_by_bag_lbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="total_overage_disc_by_bag_inp" id="total_overage_disc_by_bag_inp" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td><label id="totalbyferesula" style="font-size: 14px;">Total Balance by Feresula</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbalanceferesula_ending" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalferesulaval_ending" id="totalferesulaval_ending" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label id="totalbyton" style="font-size: 14px;">Total Balance by TON</label></td>
                                                <td style="text-align: center;">
                                                    <label id="totalbalanceton_ending" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="totalbalancetonval_ending" id="totalbalancetonval_ending" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                            <tr style="background-color: #FFFFFF;">
                                                <td colspan="2" style="text-align: center">-</td>
                                            </tr>
                                            <tr style="background-color: #f8f9fa;">
                                                <td><label style="font-size: 14px;">Total Value</label></td>
                                                <td style="text-align: center;">
                                                    <label id="total_ending_value_lbl" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                    <input type="hidden" class="form-control" name="total_ending_value_inp" id="total_ending_value_inp" readonly="true" value="0" />
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="customer_owner_id" id="customer_owner_id" readonly="true"/> 
                        <input type="hidden" class="form-control" name="store_id" id="store_id" readonly="true"/> 
                        <input type="hidden" class="form-control" name="fiscal_year" id="fiscal_year" readonly="true"/> 
                        <input type="hidden" class="form-control" name="beginning_id" id="beginning_id" readonly="true"/> 
                        <input type="hidden" class="form-control" name="ending_id" id="ending_id" readonly="true"/> 
                        @can('Ending-Count')
                        <button id="saveendingbutton" type="button" class="btn btn-info">Save</button>
                        @endcan
                        <button id="closebuttonend" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Ending Modal -->

    <!--Start delete modal -->
    <div class="modal fade text-left" id="deletemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteForm">
                    @csrf
                    <div class="modal-body" style="background-color:#e74a3b">
                        <label strong style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this holiday?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="delRecId" id="delRecId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleterecbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End delete modal -->

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
                            <input type="hidden" class="form-control" name="doneid" id="doneid" readonly="true">
                            <input type="hidden" class="form-control" name="statusi" id="statusi" readonly="true">
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
                            <input type="hidden" class="form-control" name="verifyid" id="verifyid" readonly="true">
                            <input type="hidden" class="form-control" name="vstatusi" id="vstatusi" readonly="true">
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
                            <input type="hidden" class="form-control" name="commentid" id="commentid" readonly="true">
                            <input type="hidden" class="form-control" name="commentstatus" id="commentstatus" readonly="true">
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
                        <label strong style="font-size: 16px; color:white;font-weight:bold;">Do you really want to post? </br>Warning: If you Post this Beginning you cant adjust Balance or Unit Cost</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="postid" id="postid" readonly="true">
                            <input type="hidden" class="form-control" name="poststatus" id="poststatus" readonly="true">
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

    <!--Start Ending Information Modal -->
    <div class="modal modal-slide-in event-sidebar fade" id="ending_informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <form id="EndingInformationForm">
        {{ csrf_field() }}
            <div class="modal-dialog sidebar-xl" role="document" style="width:95%;">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #ea5455 !important;font-weight:bold;">x</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Ending Information</h5>
                        <div style="text-align: center;padding-right:30px;" id="endingstatus_title"></div>
                    </div>

                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <section id="collapsible">
                                        <div class="card collapse-icon">
                                            <div class="collapse-default">
                                                <div class="card">
                                                    <div id="headingCollapse3" class="card-header" data-toggle="collapse" role="button" data-target=".infoending" aria-expanded="false" aria-controls="collapse3">
                                                        <span class="lead collapse-title">Ending Basic & Action Information</span>
                                                        <div id="statustitlesB"></div>
                                                    </div>
                                                    <div id="collapse3" role="tabpanel" aria-labelledby="headingCollapse3" class="collapse infoending">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-lg-8 col-md-6 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Basic Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table style="width: 100%;" class="infotbl">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Beginning Doc. No.</label></td>
                                                                                            <td style="width: 70%"><label id="end_infobeginningdocnum" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Store/ Station</label></td>
                                                                                            <td><label id="end_infostorename" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Fiscal Year</label></td>
                                                                                            <td><label id="end_infofiscalyear" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="col-lg-6 col-md-12 col-sm-12">
                                                                                    <table id="end_customerinfotbl" style="width: 100%;display:none;" class="infotbl">
                                                                                        <tr>
                                                                                            <td style="width: 30%"><label style="font-size: 14px;">Customer Code</label></td>
                                                                                            <td style="width: 70%"><label id="end_infocustomercode" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Name</label></td>
                                                                                            <td><label id="end_infocustomername" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer TIN</label></td>
                                                                                            <td><label id="end_infocustomertin" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Phone</label></td>
                                                                                            <td><label id="end_infocustomerphone" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><label style="font-size: 14px;">Customer Email</label></td>
                                                                                            <td><label id="end_infocustomeremail" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4 col-md-6 col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h6 class="card-title">Action Information</h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                                                    <ul id="ending_actiondiv" class="timeline mb-0 mt-0"></ul>
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
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                    <div class="row ending_info_datatable" id="ending_goods_info">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <table id="goods_endinginfo_tbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 3%;">#</th>
                                                        <th style="width: 10%;">Location</th>
                                                        <th style="width: 17%;">Item Name</th>
                                                        <th style="width: 10%;">UOM</th>
                                                        <th style="width: 10%;">System Count</th>
                                                        <th style="width: 10%;">Physical Count</th>
                                                        <th style="width: 10%;">Unit Cost</th>
                                                        <th style="width: 10%;">Total Cost</th>
                                                        <th style="width: 10%;">Variance Shortage</th>
                                                        <th style="width: 10%;">Variance Overage</th>
                                                    </tr> 
                                                </thead>
                                                <tbody class="table table-sm"></tbody>
                                                <tfoot>
                                                    <th colspan="4" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                    <th style="font-size: 16px;padding:6px;" id="goods_total_system_count"></th>
                                                    <th style="font-size: 16px;padding:6px;" id="goods_total_physical_count"></th>
                                                    <th style="font-size: 16px;padding:6px;"></th>
                                                    <th style="font-size: 16px;padding:6px;" id="goods_total_cost_data"></th>
                                                    <th style="font-size: 16px;padding:6px;" id="goods_total_variance_shortage"></th>
                                                    <th style="font-size: 16px;padding:6px;" id="goods_total_variance_overage"></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row ending_info_datatable" id="ending_commodity_info">
                                        <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                                            <div class="table-responsive scroll scrdiv" id="comm_ending_div" style="display: none;">
                                                <table id="endinginfo_tbl" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2">#</th>
                                                            <th rowspan="2">Floor Map</th>
                                                            <th rowspan="2">Type</th>
                                                            <th rowspan="2">Supplier</th>
                                                            <th rowspan="2" title="GRN Number">GRN No.</th>
                                                            <th rowspan="2" title="Production Order Number">Production Order No.</th>
                                                            <th rowspan="2" title="Certificate Number">Certificate No.</th>
                                                            <th rowspan="2">Commodity</th>
                                                            <th rowspan="2">Grade</th>
                                                            <th rowspan="2">Process Type</th>
                                                            <th rowspan="2">Crop Year</th>
                                                            <th rowspan="2">UOM/ Bag</th>
                                                            <th colspan="6">System Count</th>
                                                            <th colspan="12">Physical Count</th>
                                                        </tr> 
                                                        <tr>
                                                            <th>No. of Bag</th>
                                                            <th>Bag Weight by KG</th>
                                                            <th>Total KG</th>
                                                            <th>Net KG</th>
                                                            <th>Variance Shortage by KG</th>
                                                            <th>Variance Overage by KG</th>
                                                            <th>No. of Bag</th>
                                                            <th>Bag Weight by KG</th>
                                                            <th>Discrepancy Shortage by Bag</th>
                                                            <th>Discrepancy Overage by Bag</th>
                                                            <th>Total KG</th>
                                                            <th>Net KG</th>
                                                            <th>Feresula</th>
                                                            <th>TON</th>
                                                            <th>Discrepancy Shortage by KG</th>
                                                            <th>Discrepancy Overage by KG</th>
                                                            <th>Unit Cost</th>
                                                            <th>Total Cost</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table table-sm"></tbody>
                                                    <tfoot>
                                                        <th colspan="12" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                        <th style="font-size: 14px;" id="end_totalbag"></th>
                                                        <th style="font-size: 14px;" id="end_totalbagweight"></th>
                                                        <th style="font-size: 14px;" id="end_totalkg"></th>
                                                        <th style="font-size: 14px;" id="end_totalnetkg"></th>
                                                        <th style="font-size: 14px;" id="end_total_shortage_variance"></th>
                                                        <th style="font-size: 14px;" id="end_total_overage_variance"></th>
                                                        
                                                        <th style="font-size: 14px;" id="end_totalbag_pc"></th>
                                                        <th style="font-size: 14px;" id="end_totalbagweight_pc"></th>
                                                        <th style="font-size: 14px;" id="end_totaldisc_shortage_bag"></th>
                                                        <th style="font-size: 14px;" id="end_totaldisc_overage_bag"></th>
                                                        <th style="font-size: 14px;" id="end_totakg_pc"></th>
                                                        <th style="font-size: 14px;" id="end_totalnetkg_pc"></th>
                                                        <th style="font-size: 14px;" id="end_totalferesula_pc"></th>
                                                        <th style="font-size: 14px;" id="end_totalton_pc"></th>
                                                        <th style="font-size: 14px;" id="end_totaldisc_shortage_kg"></th>
                                                        <th style="font-size: 14px;" id="end_totaldisc_overage_kg"></th>
                                                        <th style="font-size: 14px;" id="end_totalunitcost"></th>
                                                        <th style="font-size: 14px;" id="end_totalcost"></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="endingRecId" id="endingRecId" readonly="true"/> 
                        <input type="hidden" class="form-control linkid" name="reqId" id="reqId" readonly="true">
                        <input type="hidden" class="form-control linkname" name="filenameinfo" id="filenameinfo" readonly="true">
                        <input type="hidden" class="form-control" name="statusi" id="statusi" readonly="true">
                        <input type="hidden" class="form-control" name="statusid" id="statusid" readonly="true">
                        <input type="hidden" class="form-control" name="currentStatus" id="currentStatus" readonly="true">
                        @can('Ending-ChangeToPending')
                        <button id="changetopending" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Change to Pending</button>
                        <button id="backtodraft" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Draft</button>
                        @endcan
                        @can('Ending-Verify')
                        <button id="verifybtn_end" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Verify Ending</button>
                        <button id="backtopending" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Pending</button>
                        @endcan
                        @can('Ending-Approve')
                        <button id="approvebtn" type="button" onclick="forwardActionFn()" class="btn btn-info actionpropbtn">Approve Ending</button>
                        {{-- <button id="backtoverify" type="button" class="btn btn-info backwardbtn actionpropbtn">Back to Verify</button> --}}
                        {{-- <button id="rejectbtn" type="button" class="btn btn-info backwardbtn actionpropbtn">Reject</button> --}}
                        @endcan
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--End Ending Information Modal -->

    <!--Start forward action modal -->
    <div class="modal fade text-left" id="forwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="forwardActionForm">
                    @csrf
                    <div class="modal-body" id="modalBodyId">
                        <label style="font-size: 16px;font-weight:bold;" id="forwardActionLabel"></label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="forwardReqId" id="forwardReqId" readonly="true">
                            <input type="hidden" class="form-control" name="newForwardStatusValue" id="newForwardStatusValue" readonly="true">
                            <input type="hidden" class="form-control" name="forwarkBtnTextValue" id="forwarkBtnTextValue" readonly="true">
                            <input type="hidden" class="form-control" name="forwardActionValue" id="forwardActionValue" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="forwardActionBtn" type="button" class="btn btn-info"></button>
                        <button id="closebuttonforwardAction" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End forward action modal -->

    <!--Start backward action modal -->
    <div class="modal fade text-left" id="backwardActionModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backwardActionForm">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;" id="backwardActionLabel"></label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment/Reason here..." class="form-control" rows="3" name="CommentOrReason" id="CommentOrReason" onkeyup="commentValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="commentres-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="backwardReqId" id="backwardReqId" readonly="true">
                        <input type="hidden" class="form-control" name="newBackwardStatusValue" id="newBackwardStatusValue" readonly="true">
                        <input type="hidden" class="form-control" name="backwardBtnTextValue" id="backwardBtnTextValue" readonly="true">
                        <input type="hidden" class="form-control" name="backwardActionValue" id="backwardActionValue" readonly="true">
                        <button id="backwardActionBtn" type="button" class="btn btn-info"></button>
                        <button id="closebuttonbackwardAction" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End backward action modal -->

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var j=0;
        var i=0;
        var m=0;

        var j2=0;
        var i2=0;
        var m2=0;

        var j3=0;
        var i3=0;
        var m3=0;
        var ctable = "";
        var otable = "";

        var statusTransitions = {
            'Draft': {
                forward: {
                    status: 'Pending',
                    text: 'Change to Pending',
                    action: 'Change to Pending',
                    message: 'Do you really want to change ending to pending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                }
            },
            'Pending': {
                forward: {
                    status: 'Verified',
                    text: 'Verify',
                    action: 'Verified',
                    message: 'Do you really want to verify ending?',
                    forecolor: '#6e6b7b',
                    backcolor: '#f6c23e'
                },
                backward: {
                    status: 'Draft',
                    text: 'Back to Draft',
                    action: 'Back to Draft',
                    message: 'Comment'
                }
            },
            'Verified': {
                forward: {
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Do you really want to approve ending?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                },
                backward: {
                    status: 'Pending',
                    text: 'Back to Pending',
                    action: 'Back to Pending',
                    message: 'Comment'
                },
                reject: {
                    status: 'Rejected',
                    text: 'Reject',
                    action: 'Rejected',
                    message: 'Reason'
                }
            },
            'Approved': {
                backward: {
                    status: 'Verified',
                    text: 'Back to Verify',
                    action: 'Back to Verify',
                    message: 'Comment'
                },
                reject: {
                    status: 'Rejected',
                    text: 'Reject',
                    action: 'Rejected',
                    message: 'Reason'
                }
            },
            'Rejected': {
                forward: {
                    status: 'Approved',
                    text: 'Approve',
                    action: 'Approved',
                    message: 'Do you really want to approve ending?',
                    forecolor: '#FFFFFF',
                    backcolor: '#28c76f'
                }
            },
        };

        var fyears = $('#fiscalyear').val();
        var cus_fyears = $('#cus_fiscalyear').val();
        var currentdate = $('#CurrentDateVal').val();

        function getCommBeg(fyears){
            $('#fiscalyear_div').hide();
            $('#owner_dt').hide();

            otable = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                autoWidth: false,
                deferRender: true,
                "order": [[0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/commbeglist/'+fyears,
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
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'DocumentNumber', name: 'DocumentNumber',width:"13%"},
                    { data: 'EndingDocumentNumber', name: 'EndingDocumentNumber',
                        "render": function (data, type, row, meta) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=commEndingInfoFn(${row.id})>${data == null || data === null ? "" : data}</a>`;
                        },
                        width:"13%"
                    },
                    { data: 'ProductType', name: 'ProductType',width:"13%"},
                    { data: 'StoreName', name: 'StoreName',width:"15%"},
                    { data: 'Monthrange', name: 'Monthrange',width:"13%"},
                    { data: 'Date', name: 'Date',width:"13%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Ready"){
                                return `<span class="badge bg-info bg-glow">${data}</span>`;
                            }
                            else if(data == "Counting"){
                                return `<span class="badge bg-info bg-glow">${data}</span>`;
                            }
                            else if(data == "Posted"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Verified"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Finish-Counting"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Rejected"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"13%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        @can('Commodity-Beginning-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addcommbeg" data-toggle="modal">Add</button>
                        @endcan
                    `);
                },
                drawCallback: function () { 
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
                    $('#fiscalyear_div').show();
                    $('#owner_dt').show();
                },
            });
        }

        function getCommBegData(fyears){
            $('#cus_fiscalyear_div').hide();
            $('#customer_dt').hide();

            ctable = $('#customersdatatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                autoWidth: false,
                deferRender: true,
                "order": [[0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons2'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/cuscommbeglist/'+fyears,
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
                },
                columns: [
                    { data: 'id', name: 'id','visible': false},
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'DocumentNumber', name: 'DocumentNumber',width:"9%"},
                    { data: 'EndingDocumentNumber', name: 'EndingDocumentNumber',
                        "render": function (data, type, row, meta) {
                            return `<a style="text-decoration:underline;color:blue;" onclick=commEndingInfoFn(${row.id})>${data == null || data === null ? "" : data}</a>`;
                        },
                        width:"9%"
                    },
                    { data: 'ProductType', name: 'ProductType',width:"9%"},
                    { data: 'CustomerCode', name: 'CustomerCode',width:"9%"},
                    { data: 'CustomerName', name: 'CustomerName',width:"12%"},
                    { data: 'TinNumber', name: 'TinNumber',width:"9%"},
                    { data: 'StoreName', name: 'StoreName',width:"9%"},
                    { data: 'Monthrange', name: 'Monthrange',width:"9%"},
                    { data: 'Date', name: 'Date',width:"9%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Ready"){
                                return `<span class="badge bg-info bg-glow">${data}</span>`;
                            }
                            else if(data == "Counting"){
                                return `<span class="badge bg-info bg-glow">${data}</span>`;
                            }
                            else if(data == "Posted"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Verified"){
                                return `<span class="badge bg-primary bg-glow">${data}</span>`;
                            }
                            else if(data == "Finish-Counting"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Rejected"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-dark bg-glow">${data}</span>`;
                            }
                        },
                        width:"9%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons2').html(`
                        @can('Commodity-Beginning-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addcommbeg" data-toggle="modal">Add</button>
                        @endcan
                    `);
                },
                drawCallback: function () { 
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
                    $('#cus_fiscalyear_div').show();
                    $('#customer_dt').show();
                    $('#customer-tab').show();
                },
            });
        }

        $(document).ready( function () {
            $('#customer-tab').hide();

            getCommBeg(fyears);
            getCommBegData(cus_fyears);

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable
                    .tables({ visible: true, api: true })
                    .columns.adjust();
            });
        });

        $('#product_type').change(function(){
            var selected = $('#product_type option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                otable.column(4).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                otable.column(4).search(searchRegex, true, false).draw();
            }
        });

        $('#cus_product_type').change(function(){
            var selected = $('#cus_product_type option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                ctable.column(4).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                ctable.column(4).search(searchRegex, true, false).draw();
            }
        });

        function fiscalyrfn(){
            var fyearsch=$('#fiscalyear').val();
            getCommBeg(fyearsch);
        }

        function cus_fiscalyrfn(){
            var cus_fy = $('#cus_fiscalyear').val();
            getCommBegData(cus_fy);
        }

        $('body').on('click', '.addcommbeg', function() {

            $('#ProductType').val(null).select2
            ({
                placeholder: "Select Product type here",
                minimumResultsForSearch: -1
            });
            $('#stores_id').val(null).trigger('change').select2
            ({
                placeholder: "Select store here...",
            });
            $('#customers_id').val(null).trigger('change').select2
            ({
                placeholder: "Select customer here...",
            });
            $('#recId').val("");
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#statusdisplay').html('');
            $('#pricingTable').hide();
            $('.dynamictblclass').hide();
            $('#dynamicTable > tbody').empty();
            $('#operationtypes').val("1");
            $("#modaltitle").html("Add Commodity Beginning");

            $('#commodity_div').show(); 

            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#savebutton').show();

            $('#savebuttongood').text('Save');
            $('#savebuttongood').prop("disabled",false);
            $('#savebuttongood').hide();

            $("#inlineForm").modal('show');
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().html('<span class="badge badge-center rounded-pill bg-secondary">'+(++index)+'</span>');
                $('#numberofItemsLbl').html(index - 1);
                ind = index;
            });
            if (ind == 0 || ind==undefined) {
                $('#pricingTable').hide();
            } else {
                $('#pricingTable').show();
            }
        }

        function FloorMapFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var floormapcnt=0;
            var floormapcntB=0;
            for(var k=1;k<=m;k++){
                if(($('#FloorMap'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        floormapcnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "")){
                        floormapcntB+=1;
                    }
                }
            }
            if(parseInt(floormapcnt)<=1 && parseInt(floormapcntB)<=1){
                $('#select2-FloorMap'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(floormapcnt)>1 || parseInt(floormapcntB)>1){
                $('#FloorMap'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Floor map here",
                });
                $('#select2-FloorMap'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Floor map is selected with all property","Error");
            }
        }

        function SupplierFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var suppliercnt=0;
            var suppliercntB=0;
            for(var k=1;k<=m;k++){
                if(($('#Supplier'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        suppliercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        suppliercntB+=1;
                    }
                }
            }
            if(parseInt(suppliercnt)<=1 && parseInt(suppliercntB)<=1){
                $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(suppliercnt)>1 || parseInt(suppliercntB)>1){
                $('#Supplier'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Supplier here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Supplier is selected with all property","Error");
            }
        }

        function GrnNumberErrFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var grnnumbercnt=0;
            var grnnumbercntB=0;
            for(var k=1;k<=m;k++){
                if(($('#GrnNumber'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        grnnumbercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        grnnumbercntB+=1;
                    }
                }
            }
            if(parseInt(grnnumbercnt)<=1 && parseInt(grnnumbercntB)<=1){
                $('#GrnNumber'+idval).css("background","white");
            }
            else if(parseInt(grnnumbercnt)>1 || parseInt(grnnumbercntB)>1){
                $('#GrnNumber'+idval).css("background",errorcolor);
                $('#GrnNumber'+idval).val("");
                toastrMessage('error',"GRN number exist with all property","Error");
            }
        }

        function CertNumberErrFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var certnumbercnt=0;
            var certnumbercntB=0;
            for(var k=1;k<=m;k++){
                if(($('#CertificateNum'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        certnumbercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        certnumbercntB+=1;
                    }
                }
            }
            if(parseInt(certnumbercnt)<=1 && parseInt(certnumbercntB)<=1){
                $('#CertificateNum'+idval).css("background","white");
            }
            else if(parseInt(certnumbercnt)>1 || parseInt(certnumbercntB)>1){
                $('#CertificateNum'+idval).css("background",errorcolor);
                $('#CertificateNum'+idval).val("");
                toastrMessage('error',"Certificate number exist with all property","Error");
            }
        }

        function ProductionNumErrFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var productionnumbercnt=0;
            var productionnumbercntB=0;
            for(var k=1;k<=m;k++){
                if(($('#ProductionNum'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        productionnumbercnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        productionnumbercntB+=1;
                    }
                }
            }
            if(parseInt(productionnumbercnt)<=1 && parseInt(productionnumbercntB)<=1){
                $('#ProductionNum'+idval).css("background","white");
            }
            else if(parseInt(productionnumbercnt)>1 || parseInt(productionnumbercntB)>1){
                $('#ProductionNum'+idval).css("background",errorcolor);
                $('#ProductionNum'+idval).val("");
                toastrMessage('error',"Production number exist with all property","Error");
            }
        }

        function GrnNumberFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#GrnNumber'+idval).css("background","white");
        }

        function CertificateNumFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#CertificateNum'+idval).css("background","white");
        }

        function ProductionNumFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#ProductionNum'+idval).css("background","white");
        }

        function arrdateFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var arrdatecnt=0;
            var arrdatecntB=0;
            for(var k=1;k<=m;k++){
                if(($('#arrdate'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        arrdatecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "")){
                        arrdatecntB+=1;
                    }
                }
            }
            if(parseInt(arrdatecnt)<=1 && parseInt(arrdatecntB)<=1){
                $('#arrdate'+idval).css("background","white");
            }
            else if(parseInt(arrdatecnt)>1 || parseInt(arrdatecntB)>1){
                $('#arrdate'+idval).css("background",errorcolor);
                $('#arrdate'+idval).val("");
                toastrMessage('error',"Arrival date is selected with all property","Error");
            }
        }

        function arrdateclearFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#arrdate'+idval).val("");
            $('#arrdate'+idval).css("background","white");
        }

        function CommTypeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var commtypecnt=0;
            var commtypecntB=0;
            for(var k=1;k<=m;k++){
                if(($('#CommType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        commtypecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        commtypecntB+=1;
                    }
                }
            }

            if(parseInt(commtypecnt)<=1 && parseInt(commtypecntB)<=1){
                var defaultoption = '<option selected value=""></option>';
                $('#Origin'+idval).empty();
                var originoptions = $("#origindefault > option").clone();
                $('#Origin'+idval).append(originoptions);
                $('.typeprop'+idval).hide();

                if(parseInt(commtype)==1 || parseInt(commtype)==4){
                    $('#supplierdiv'+idval).show();
                    $('#grndiv'+idval).show();
                    $('#CertificateNum'+idval).val("");
                    $('#CertificateNum'+idval).css("background","white");
                    $('#ProductionNum'+idval).val("");
                    $('#ProductionNum'+idval).css("background","white");
                    $("#Origin"+idval+" option[title!=1]").remove(); 
                }
                else if(parseInt(commtype)==2 || parseInt(commtype)==5 || parseInt(commtype)==6){
                    $('#cernumdiv'+idval).show();
                    $('#productiondiv'+idval).show();
                    $('#Supplier'+idval).val(null).select2({
                        placeholder:"Select Supplier here",
                        dropdownCssClass : 'commprp',
                    });
                    $('#GrnNumber'+idval).val("");
                    $('#GrnNumber'+idval).css("background","white");
                    $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    $("#Origin"+idval+" option[title!=2]").remove(); 
                }
                else if(parseInt(commtype)==3){
                    $('#cernumdiv'+idval).show();
                    $('#productiondiv'+idval).show();
                    $('#Supplier'+idval).val(null).select2({
                        placeholder:"Select Supplier here",
                        dropdownCssClass : 'commprp',
                    });
                    $('#GrnNumber'+idval).val("");
                    $('#GrnNumber'+idval).css("background","white");
                    $('#select2-Supplier'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    $("#Origin"+idval+" option[title!=3]").remove(); 
                }

                $('#Origin'+idval).append(defaultoption);
                $('#Origin'+idval).select2
                ({
                    placeholder: "Select Commodity here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-CommType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(commtypecnt)>1 || parseInt(commtypecntB)>1){
                $('#CommType'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-CommType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Commodity Type is selected with all property","Error");
            }
        }

        function OriginFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            
            var origincnt=0;
            var origincntB=0;
            for(var k=1;k<=m;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        origincnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        origincntB+=1;
                    }
                }
            }

            if(parseInt(origincnt)<=1 && parseInt(origincntB)<=1){
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(origincnt)>1 || parseInt(origincntB)>1){
                $('#Origin'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Origin here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Origin is selected with all property","Error");
            }
        }

        function GradeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var gradecnt=0;
            var gradecntB=0;
            for(var k=1;k<=m;k++){
                if(($('#Grade'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        gradecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        gradecntB+=1;
                    }
                }
            }

            if(parseInt(gradecnt)<=1 && parseInt(gradecntB)<=1){
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(gradecnt)>1 || parseInt(gradecntB)>1){
                $('#Grade'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Grade here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Grade is selected with all property","Error");
            }
        }

        function ProcessTypeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var processtypecnt=0;
            var processtypecntB=0;
            for(var k=1;k<=m;k++){
                if(($('#ProcessType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        processtypecnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        processtypecntB+=1;
                    }
                }
            }

            if(parseInt(processtypecnt)<=1 && parseInt(processtypecntB)<=1){
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(processtypecnt)>1 || parseInt(processtypecntB)>1){
                $('#ProcessType'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Process type here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Process type is selected with all property","Error");
            }
        }

        function CropYearFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var arrdate=$('#arrdate'+idval).val();
            var supplierdata=$('#Supplier'+idval).val();
            var grndata=$('#GrnNumber'+idval).val();
            var certnumdata=$('#CertificateNum'+idval).val();
            var productionnum=$('#ProductionNum'+idval).val();
            var cropyearcnt=0;
            var cropyearcntB=0;
            for(var k=1;k<=m;k++){
                if(($('#CropYear'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#Supplier'+k).val() == parseInt(supplierdata)) && ($('#GrnNumber'+k).val() == grndata) && (!isNaN(parseInt($('#Supplier'+k).val()))) && ($('#GrnNumber'+k).val() != null)){
                        cropyearcnt+=1;
                    }
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && ($('#arrdate'+k).val() == arrdate) && ($('#CertificateNum'+k).val() == certnumdata) && ($('#CertificateNum'+k).val() != "") && ($('#ProductionNum'+k).val() == productionnum) && ($('#ProductionNum'+k).val() != "")){
                        cropyearcntB+=1;
                    }
                }
            }

            if(parseInt(cropyearcnt)<=1 && parseInt(cropyearcntB)<=1){
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(cropyearcnt)>1 || parseInt(cropyearcntB)>1){
                $('#CropYear'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Crop year here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Crop year is selected with all property","Error");
            }
        }

        function UomFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var uomid=$('#Uom'+idval).val();
            var numofbag=$('#BalanceByUom'+idval).val()||0;
            var uomopt = $('#uomdefault').find('option[value="' +uomid+ '"]');
            var uomfactor=uomopt.attr('title');
            var uombagweight=uomopt.attr('label');
            var totalbagweight=parseFloat(uombagweight)*parseFloat(numofbag);
            $('#TotalBagWeight'+idval).val(totalbagweight == 0 ? '' : totalbagweight.toFixed(2));
            $('#uomFactor'+idval).val(uomfactor);
            $('#bagWeight'+idval).val(uombagweight);
            $('#BalanceByUom'+idval).prop("readonly",false);
            $('#Balance'+idval).prop("readonly",true);
            $('#UnitPrice'+idval).prop("readonly",false);
            $('#Balance'+idval).val("");
            $('#TotalPrice'+idval).val("");
            $('#UnitPrice'+idval).val("");
            $('#BalanceByUom'+idval).css("background","white");
            $('#TotalBagWeight'+idval).css("background","#efefef");
            $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            CalculateGrandTotal();
        }

        function BalanceByUomFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var balancebyuom=$('#BalanceByUom'+idval).val()||0;
            var bagweight=$('#bagWeight'+idval).val()||0;
            $('#Balance'+idval).val("");
            $('#Feresula'+idval).val("");
            $('#UnitPrice'+idval).val("");
            $('#TotalPrice'+idval).val("");
            $('#TotalBagWeight'+idval).val("");
            $('#TotalKg'+idval).val("");
            $('#varianceoverage'+idval).val("");
            $('#varianceshortage'+idval).val("");
            $('#varianceLbl'+idval).html("");
            if(parseFloat(balancebyuom)==0){
                $('#BalanceByUom'+idval).css("background",errorcolor);
                $('#BalanceByUom'+idval).val("");
                toastrMessage('error',"Zero(0) is invalid input","Error");
            }
            else if(parseFloat(balancebyuom)>0){
                var totalbagweight=parseFloat(balancebyuom)*parseFloat(bagweight);
                $('#BalanceByUom'+idval).css("background","white");
                $('#TotalBagWeight'+idval).val(totalbagweight.toFixed(2));
                $('#TotalBagWeight'+idval).css("background","#efefef");
            }
            CalculateGrandTotal();
        }

        function TotalKgFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var totalkgval=$('#TotalKg'+idval).val()||0;
            var balance=$('#Balance'+idval).val()||0;
            var numofbag=$('#BalanceByUom'+idval).val()||0;
            var uomfactor=$('#uomFactor'+idval).val()||0;
            var bagweight=$('#TotalBagWeight'+idval).val()||0;
            var commfactor=1;
            var nextnumofbag=parseFloat(numofbag)+parseInt(commfactor);
            var nextweightkg=parseFloat(nextnumofbag)*parseFloat(uomfactor);
            var totalkg=parseFloat(numofbag)*parseFloat(uomfactor);
            var variance=0;
            var netkg=0;
            var feresulafac=17;

            if(parseFloat(totalkgval)==0){
                $('#Balance'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#TotalPrice'+idval).val("");
                $('#Balance'+idval).css("background","#efefef");
                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");
                toastrMessage('error',"Zero(0) is invalid input","Error");
            }
            else if(parseFloat(totalkgval)>0 && parseFloat(numofbag)>0){
                var balance=$('#Balance'+idval).val()||0;
                netkg=parseFloat(totalkgval)-parseFloat(bagweight);
                var result=parseFloat(netkg)/parseFloat(feresulafac);
                $('#Balance'+idval).val(netkg.toFixed(2));
                $('#Feresula'+idval).val(result.toFixed(2));
                $('#Balance'+idval).css("background","#efefef");
                $('#Feresula'+idval).css("background","#efefef");

                var unitprice=$('#UnitPrice'+idval).val()||0;
                var feresula=$('#Feresula'+idval).val()||0;
                var balancekg=$('#Balance'+idval).val()||0;

                unitprice = unitprice == '' ? 0 : unitprice;
                feresula = feresula == '' ? 0 : feresula;
                balancekg = balancekg == '' ? 0 : balancekg;

                var totalprice=parseFloat(unitprice)*parseFloat(balancekg);
                $('#TotalPrice'+idval).val(totalprice.toFixed(2));
                $('#TotalPrice'+idval).css("background","#efefef");
                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");

                if(parseFloat(netkg)>parseFloat(totalkg)){
                    variance=parseFloat(netkg)-parseFloat(totalkg);
                    $('#varianceoverage'+idval).val(variance.toFixed(2));
                    $('#varianceshortage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Overage: "+ numformat(variance.toFixed(2))+" KG");
                }
                else if(parseFloat(totalkg)>parseFloat(netkg)){
                    variance=parseFloat(totalkg)-parseFloat(netkg);
                    $('#varianceshortage'+idval).val(variance.toFixed(2));
                    $('#varianceoverage'+idval).val("");
                    $('#varianceLbl'+idval).html("Variance Shortage: "+ numformat(variance.toFixed(2))+" KG");
                }
            }
            CalculateGrandTotal();
        }

        function BalanceFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var balance=$('#Balance'+idval).val()||0;
            var numofbag=$('#BalanceByUom'+idval).val()||0;
            var uomfactor=$('#uomFactor'+idval).val()||0;
            var commfactor=1;
            var nextnumofbag=parseFloat(numofbag)+parseInt(commfactor);
            var nextweightkg=parseFloat(nextnumofbag)*parseFloat(uomfactor);
            var totalkg=parseFloat(numofbag)*parseFloat(uomfactor);
            var variance=0;
            if(parseFloat(balance)==0){
                $('#Balance'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#TotalPrice'+idval).val("");
                $('#Balance'+idval).css("background",errorcolor);
                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");
                toastrMessage('error',"Zero(0) is invalid input","Error");
            }
            else if(parseFloat(numofbag)==0){
                $('#Balance'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#TotalPrice'+idval).val("");
                $('#BalanceByUom'+idval).css("background",errorcolor);
                $('#varianceoverage'+idval).val("");
                $('#varianceshortage'+idval).val("");
                $('#varianceLbl'+idval).html("");
                toastrMessage('error',"Balance by UOM/Bag can not be empty","Error");
            }
            // else if(parseFloat(balance)>=parseFloat(nextweightkg)){
            //     $('#Balance'+idval).val("");
            //     $('#Feresula'+idval).val("");
            //     $('#TotalPrice'+idval).val("");
            //     $('#Balance'+idval).css("background",errorcolor);
            //     toastrMessage('error',"Balance by KG can not be greater than or equal to <b>"+nextweightkg+" KG</b>","Error");
            // }
            // else if(parseFloat(balance)>parseFloat(totalkg)){
            //     variance=parseFloat(balance)-parseFloat(totalkg);
            //     $('#varianceoverage'+idval).val(variance.toFixed(2));
            //     $('#varianceshortage'+idval).val("");
            //     $('#varianceLbl'+idval).html("Variance Overage: "+ numformat(variance.toFixed(2))+" KG");
            // }
            // else if(parseFloat(totalkg)>parseFloat(balance)){
            //     variance=parseFloat(totalkg)-parseFloat(balance);
            //     $('#varianceshortage'+idval).val(variance.toFixed(2));
            //     $('#varianceoverage'+idval).val("");
            //     $('#varianceLbl'+idval).html("Variance Shortage: "+ numformat(variance.toFixed(2))+" KG");
            // }
            // else if(parseFloat(balance)>0 && parseFloat(numofbag)>0){
            //     var result=parseFloat(balance)/17;
            //     $('#Feresula'+idval).val(result.toFixed(2));
            //     $('#Balance'+idval).css("background","white");
            //     $('#Feresula'+idval).css("background","#efefef");

            //     var unitprice=$('#UnitPrice'+idval).val()||0;
            //     var feresula=$('#Feresula'+idval).val()||0;
            //     var balancekg=$('#Balance'+idval).val()||0;

            //     unitprice = unitprice == '' ? 0 : unitprice;
            //     feresula = feresula == '' ? 0 : feresula;
            //     balancekg = balancekg == '' ? 0 : balancekg;

            //     var totalprice=parseFloat(unitprice)*parseFloat(balancekg);
            //     $('#TotalPrice'+idval).val(totalprice.toFixed(2));
            //     $('#TotalPrice'+idval).css("background","#efefef");
            //     $('#varianceoverage'+idval).val("");
            //     $('#varianceshortage'+idval).val("");
            //     $('#varianceLbl'+idval).html("");
            // }
            // CalculateGrandTotal();
        }

        function BalanceErrFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var balance=$('#Balance'+idval).val()||0;
            var numofbag=$('#BalanceByUom'+idval).val()||0;
            var uomfactor=$('#uomFactor'+idval).val()||0;
            var commfactor=1;
            var prevnumofbag=parseFloat(numofbag)-parseInt(commfactor);
            var prevweightkg=parseFloat(prevnumofbag)*parseFloat(uomfactor);
            
            // if(parseFloat(balance)<parseFloat(prevweightkg)){
            //     $('#Balance'+idval).val("");
            //     $('#UnitPrice'+idval).val("");
            //     $('#Feresula'+idval).val("");
            //     $('#TotalPrice'+idval).val("");
            //     $('#Balance'+idval).css("background",errorcolor);
            //     toastrMessage('error',"Balance by KG can not be less than <b>"+prevweightkg+" KG</b>","Error");
            //     CalculateGrandTotal();
            // }
        }

        function UnitPriceFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var unitprice=$('#UnitPrice'+idval).val()||0;
            if(parseFloat(unitprice)==0){
                $('#UnitPrice'+idval).val("");
                $('#Feresula'+idval).val("");
                $('#TotalPrice'+idval).val("");
                toastrMessage('error',"Zero(0) is invalid input","Error");
            }
            else if(parseFloat(unitprice)>0){
                var feresula=$('#Feresula'+idval).val()||0;
                var balancekg=$('#Balance'+idval).val()||0;
                unitprice = unitprice == '' ? 0 : unitprice;
                feresula = feresula == '' ? 0 : feresula;
                balancekg = balancekg == '' ? 0 : balancekg;

                var result=parseFloat(unitprice)*parseFloat(balancekg);
                $('#TotalPrice'+idval).val(result.toFixed(2));
                $('#UnitPrice'+idval).css("background","white");
                $('#TotalPrice'+idval).css("background","#efefef");
                CalculateGrandTotal();
            }
        }

        function CalculateGrandTotal() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var balancebybag=0;
            var varianceoverage=0;
            var varianceshortage=0;
            var totalbagweight=0;

            $.each($('#dynamicTable').find('.TotalPrice'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });

            $.each($('#dynamicTable').find('.BalanceByUom'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    balancebybag += parseFloat($(this).val());
                }
            });

            $.each($('#dynamicTable').find('.varianceoverage'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    varianceoverage += parseFloat($(this).val());
                }
            });

            $.each($('#dynamicTable').find('.varianceshortage'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    varianceshortage += parseFloat($(this).val());
                }
            });

            $.each($('#dynamicTable').find('.TotalBagWeight'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalbagweight += parseFloat($(this).val());
                }
            });

            tax=((parseFloat(subtotal)*15)/100).toFixed(2);
            grandTotal=(parseFloat(subtotal)+parseFloat(tax)).toFixed(2);
            $('#totalnumberofbag').html(numformat(balancebybag.toFixed(2)));
            $('#totalvarianceoverage').html(numformat(varianceoverage.toFixed(2)));
            $('#totalvarianceshortage').html(numformat(varianceshortage.toFixed(2)));
            $('#totalbagweightbykg').html(numformat(totalbagweight.toFixed(2)));
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#taxLbl').html(numformat(tax));
            $('#grandtotalLbl').html(numformat(grandTotal));
            CalculateTotalBalance();
        }
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveCommodityBeg',
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
                        if (data.errors.stores_id) {
                            var text=data.errors.stores_id[0];
                            text = text.replace("stores id", "store");
                            $('#store-error').html(text);
                        }
                        if (data.errors.customers_id) {
                            var text=data.errors.customers_id[0];
                            text = text.replace("customers id", "customer");
                            $('#customer-error').html(text);
                        }
                        
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.errorv2) {
                        var cusid=$('#customers_id').val();
                        for(var k=1;k<=m;k++){
                            var floormap=$('#FloorMap'+k).val();
                            var arrivaldate=$('#arrdate'+k).val();
                            var commtype=$('#CommType'+k).val();
                            var origin=$('#Origin'+k).val();
                            var grade=$('#Grade'+k).val();
                            var processtype=$('#ProcessType'+k).val();
                            var cropyear=$('#CropYear'+k).val();
                            var supplier=$('#Supplier'+k).val();
                            var grnnum=$('#GrnNumber'+k).val();
                            var cernum=$('#CertificateNum'+k).val();
                            var prdnum=$('#ProductionNum'+k).val();
                            var balancebyuom=$('#BalanceByUom'+k).val();
                            var uoms=$('#Uom'+k).val();

                            var balance=$('#Balance'+k).val();
                            var feresula=$('#Feresula'+k).val();
                            var unitprice=$('#UnitPrice'+k).val();
                            var totalprice=$('#TotalPrice'+k).val();

                            if(($('#FloorMap'+k).val())!=undefined){
                                if(floormap==""||floormap==null){
                                    $('#select2-FloorMap'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            
                            if(($('#CommType'+k).val())!=undefined){
                                if(commtype==""||commtype==null){
                                    $('#select2-CommType'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#Origin'+k).val())!=undefined){
                                if(origin==""||origin==null){
                                    $('#select2-Origin'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#Supplier'+k).val())!=undefined){
                                if((supplier==""||supplier==null) && parseInt(cusid)==1  && (parseInt(commtype)==1 || parseInt(commtype)==4)){
                                    $('#select2-Supplier'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#GrnNumber'+k).val())!=undefined){
                                if((grnnum==""||grnnum==null) && parseInt(cusid)==1 && (parseInt(commtype)==1 || parseInt(commtype)==4)){
                                    $('#GrnNumber'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#CertificateNum'+k).val())!=undefined){
                                if((cernum==""||cernum==null) && parseInt(cusid)==1  && (parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==5 || parseInt(commtype)==6)){
                                    $('#CertificateNum'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#ProductionNum'+k).val())!=undefined){
                                if((prdnum==""||prdnum==null) && parseInt(cusid)==1  && (parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==5 || parseInt(commtype)==6)){
                                    $('#ProductionNum'+k).css("background", errorcolor);
                                }
                            }
                            
                            if(($('#Grade'+k).val())!=undefined){
                                if(grade==""||grade==null){
                                    $('#select2-Grade'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#ProcessType'+k).val())!=undefined){
                                if(processtype==""||processtype==null){
                                    $('#select2-ProcessType'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#CropYear'+k).val())!=undefined){
                                if(cropyear==""||cropyear==null){
                                    $('#select2-CropYear'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#Uom'+k).val())!=undefined){
                                if(uoms==""||uoms==null){
                                    $('#select2-Uom'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#BalanceByUom'+k).val())!=undefined){
                                if(balancebyuom==""||balancebyuom==null){
                                    $('#BalanceByUom'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#Balance'+k).val())!=undefined){
                                if(balance==""||balance==null){
                                    $('#Balance'+k).css("background", errorcolor);
                                }
                            }
                            // if(($('#Feresula'+k).val())!=undefined){
                            //     if(feresula==""||feresula==null){
                            //         $('#Feresula'+k).css("background", errorcolor);
                            //     }
                            // }
                            // if(($('#UnitPrice'+k).val())!=undefined){
                            //     if((unitprice==""||unitprice==null) && parseInt(cusid)==1){
                            //         $('#UnitPrice'+k).css("background", errorcolor);
                            //     }
                            // }
                            // if(($('#TotalPrice'+k).val())!=undefined){
                            //     if((totalprice==""||totalprice==null) && parseInt(cusid)==1){
                            //         $('#TotalPrice'+k).css("background", errorcolor);
                            //     }
                            // }
                        }
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if(data.suppcnt || data.grnnumcnt || data.cernumcnt || data.prdnumcnt){
                        var cusid=$('#customers_id').val();
                        for(var k=1;k<=m;k++){
                            var commtype=$('#CommType'+k).val();
                            var supplier=$('#Supplier'+k).val();
                            var grnnum=$('#GrnNumber'+k).val();
                            var cernum=$('#CertificateNum'+k).val();
                            var prdnum=$('#ProductionNum'+k).val();
                            if(($('#Supplier'+k).val())!=undefined){
                                if((supplier==""||supplier==null) && parseInt(cusid)==1 && (parseInt(commtype)==1 || parseInt(commtype)==4)){
                                    $('#select2-Supplier'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                }
                            }
                            if(($('#GrnNumber'+k).val())!=undefined){
                                if((grnnum==""||grnnum==null) && parseInt(cusid)==1 && (parseInt(commtype)==1 || parseInt(commtype)==4)){
                                    $('#GrnNumber'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#CertificateNum'+k).val())!=undefined){
                                if((cernum==""||cernum==null) && parseInt(cusid)==1 && (parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==5 || parseInt(commtype)==6)){
                                    $('#CertificateNum'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#ProductionNum'+k).val())!=undefined){
                                if((prdnum==""||prdnum==null) && parseInt(cusid)==1 && (parseInt(commtype)==2 || parseInt(commtype)==3 || parseInt(commtype)==5 || parseInt(commtype)==6)){
                                    $('#ProductionNum'+k).css("background", errorcolor);
                                }
                            }
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if(data.emptyerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add atleast one commodity","Error");
                    } 
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
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
                            $('#savebutton').text('Save');
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

                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        $("#adds").click(function() {
            var storeid=$('#stores_id').val();
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var floormap=$('#FloorMap'+lastrowcount).val();
            var commtype=$('#CommType'+lastrowcount).val();
            var origin=$('#Origin'+lastrowcount).val();
            var grade=$('#Grade'+lastrowcount).val();
            var processtype=$('#ProcessType'+lastrowcount).val();
            var cropyear=$('#CropYear'+lastrowcount).val();
            var supplier=$('#Supplier'+lastrowcount).val();
            var grnNum=$('#GrnNumber'+lastrowcount).val();
            var certnum=$('#CertificateNum'+lastrowcount).val();
            var borcolor="";
            if(isNaN(parseInt(storeid))){
                $('#store-error').html("Store is required"); 
                toastrMessage('error',"Please select store first","Error");
            }
            else if((floormap!==undefined && isNaN(parseFloat(floormap))) || (commtype!==undefined && isNaN(parseFloat(commtype))) || (origin!==undefined && isNaN(parseFloat(origin))) || (grade!==undefined && isNaN(parseFloat(grade))) || (processtype!==undefined && processtype=="") || (cropyear!==undefined && isNaN(parseFloat(cropyear)))){
                if(floormap!==undefined && isNaN(parseFloat(floormap))){
                    $('#select2-FloorMap'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(commtype!==undefined && isNaN(parseFloat(commtype))){
                    $('#select2-CommType'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(origin!==undefined && isNaN(parseFloat(origin))){
                    $('#select2-Origin'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(grade!==undefined && isNaN(parseFloat(grade))){
                    $('#select2-Grade'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(processtype!==undefined && processtype==""){
                    $('#select2-ProcessType'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(cropyear!==undefined && isNaN(parseFloat(cropyear))){
                    $('#select2-CropYear'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                // if(parseInt(commtype)==1 && (isNaN(parseInt(supplier)) || grnNum == "")){
                //     if(isNaN(parseInt(supplier))){
                //         $('#select2-Supplier'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                //     }
                //     if(grnNum == "" || grnNum == null){
                //         $('#GrnNumber'+lastrowcount).css("background",errorcolor);
                //     }
                // }
                // if((parseInt(commtype)==2 || parseInt(commtype)==3) && certnum == ""){
                //     if(certnum == "" || certnum == null){
                //         $('#CertificateNum'+lastrowcount).css("background",errorcolor);
                //     }
                // }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            // else if(parseInt(commtype)==1 && (isNaN(parseInt(supplier)) || grnNum == "")){
            //     if(isNaN(parseInt(supplier))){
            //         $('#select2-Supplier'+lastrowcount+'-container').parent().css('background-color',errorcolor);
            //     }
            //     if(grnNum == "" || grnNum == null){
            //         $('#GrnNumber'+lastrowcount).css("background",errorcolor);
            //     }
            // }
            // else if((parseInt(commtype)==2 || parseInt(commtype)==3) && certnum == ""){
            //     if(certnum == "" || certnum == null){
            //         $('#CertificateNum'+lastrowcount).css("background",errorcolor);
            //     }
            // }
            else{
                ++i;
                ++m;
                ++j;

                // $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:2%;text-align:center;">'+j+'</td>'+
                //     '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                //     '<td style="width:6%;"><select id="FloorMap'+m+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m+'][FloorMap]"></select></td>'+
                //     '<td style="width:7%;"><input type="text" id="arrdate'+m+'" name="row['+m+'][arrdate]" class="arrdate form-control" placeholder="YYYY-MM-DD" onchange="arrdateFn(this)" ondblclick="arrdateclearFn(this)"/></td>'+
                //     '<td style="width:8%;"><select id="CommType'+m+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m+'][CommType]"></select></td>'+
                //     '<td style="width:12%;"><select id="Origin'+m+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select></td>'+
                //     '<td style="width:7%;"><select id="Grade'+m+'" class="select2 form-control form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select></td>'+
                //     '<td style="width:7%;"><select id="ProcessType'+m+'" class="select2 form-control form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select></td>'+
                //     '<td style="width:7%;"><select id="CropYear'+m+'" class="select2 form-control form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select></td>'+
                //     '<td style="width:7%;"><select id="Uom'+m+'" class="select2 form-control form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select></td>'+
                //     '<td style="width:8%;"><input type="number" name="row['+m+'][Balance]" placeholder="Write Balance here..." id="Balance'+m+'" class="Balance form-control numeral-mask commnuminp" onkeyup="BalanceFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                //     '<td style="width:8%;"><input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" class="UnitPrice form-control numeral-mask commnuminp" onkeyup="UnitPriceFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                //     '<td style="width:8%;"><input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" class="TotalPrice form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                //     '<td style="width:10%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" placeholder="Write Remark here..."/></td>'+
                //     '<td style="width:2%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                //     '<td style="display:none;"><input type="number" name="row['+m+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m+'" class="Feresula form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                //     '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td></tr>'
                // );

                if(parseInt(j)%2===0){
                    borcolor="#f8f9fa";
                }
                else{
                    borcolor="#FFFFFF";
                }

                $("#dynamicTable > tbody").append('<tr id="rowind'+m+'" class="mb-1" style="background-color:'+borcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                    '<span class="badge badge-center rounded-pill bg-secondary">'+j+'</span>'+
                '</td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                '<td style="width:96%;">'+
                    '<div class="row">'+
                        '<div class="col-xl-8 col-md-8 col-lg-8" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="FloorMap'+m+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m+'][FloorMap]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Arrival Date</label>'+
                                    '<input type="text" id="arrdate'+m+'" name="row['+m+'][arrdate]" class="arrdate form-control" placeholder="YYYY-MM-DD" onchange="arrdateFn(this)" ondblclick="arrdateclearFn(this)"/>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CommType'+m+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m+'][CommType]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="supplierdiv'+m+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Supplier</label>'+
                                    '<select id="Supplier'+m+'" class="select2 form-control Supplier" onchange="SupplierFn(this)" name="row['+m+'][Supplier]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="grndiv'+m+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">GRN No.</label>'+
                                    '<input type="number" name="row['+m+'][GrnNumber]" placeholder="Write GRN number here..." id="GrnNumber'+m+'" class="GrnNumber form-control numeral-mask commnuminp" onkeyup="GrnNumberFn(this)" onblur="GrnNumberErrFn(this)" onkeypress="return ValidateOnlyNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="productiondiv'+m+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Production Order No.</label>'+
                                    '<input type="number" name="row['+m+'][ProductionNum]" placeholder="Write Production order number here..." id="ProductionNum'+m+'" class="ProductionNum form-control numeral-mask commnuminp" onkeyup="ProductionNumFn(this)" onblur="ProductionNumErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="cernumdiv'+m+'" style="display:none;">'+
                                    '<label style="font-size: 12px;">Certificate No.</label>'+
                                    '<input type="number" name="row['+m+'][CertificateNum]" placeholder="Write Certificate Number here..." id="CertificateNum'+m+'" class="CertificateNum form-control numeral-mask commnuminp" onkeyup="CertificateNumFn(this)" onblur="CertNumberErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Origin'+m+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Grade'+m+'" class="select2 form-control form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="ProcessType'+m+'" class="select2 form-control form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select>'+
                                '</div>'+
                                '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CropYear'+m+'" class="select2 form-control form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                    '<label style="font-size: 12px;">Remark</label>'+
                                    '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m+'][Remark]" id="Remark'+m+'"></textarea>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-xl-4 col-md-4 col-lg-4">'+
                            '<div class="row">'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Uom'+m+'" class="select2 form-control form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m+'][BalanceByUom]" placeholder="Write Balance by UOM/Bag here" id="BalanceByUom'+m+'" class="BalanceByUom form-control numeral-mask commnuminp" onkeyup="BalanceByUomFn(this)" onkeypress="return ValidateOnlyNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">Bag Weight by KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m+'][TotalBagWeight]" placeholder="Bag weight" id="TotalBagWeight'+m+'" class="TotalBagWeight form-control numeral-mask commnuminp" onkeyup="BagWeightFn(this)" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-6 col-lg-6 mt-1">'+
                                    '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m+'" class="TotalKg form-control numeral-mask commnuminp" onkeyup="TotalKgFn(this)" onblur="TotalKgErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-6 col-lg-6 mt-1">'+
                                    '<label style="font-size: 12px;">Net KG<i class="fa-solid fa-circle-info" title="Total KG - Bag Weight by KG"></i></label>'+
                                    '<input type="number" name="row['+m+'][Balance]" placeholder="Write Balance here..." id="Balance'+m+'" class="Balance form-control numeral-mask commnuminp" onkeyup="BalanceFn(this)" onblur="BalanceErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-6 col-lg-6 mt-1">'+
                                    '<label style="font-size: 12px;">Unit Cost<i class="fa-solid fa-circle-info" title="Before VAT"></i></label>'+
                                    '<input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" class="UnitPrice form-control numeral-mask commnuminp" onkeyup="UnitPriceFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-6 col-lg-6 mt-1">'+
                                    '<label style="font-size: 12px;">Total Cost<i class="fa-solid fa-circle-info" title="Net KG * Unit Cost"></i></label>'+
                                    '<input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" class="TotalPrice form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-6 col-lg-6 mb-1"></div>'+
                                '<div class="col-xl-9 col-md-6 col-lg-6 mb-1">'+
                                    '<label style="font-size: 12px;font-weight:bold;" id="varianceLbl'+m+'"></label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
                '<td style="width:2%;text-align:right;vertical-align: top;">'+
                    '<button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:'+borcolor+';border-color:'+borcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                '</td>'+
                '<td style="display:none;"><input type="number" name="row['+m+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m+'" class="Feresula form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m+'][bagWeight]" id="bagWeight'+m+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m+'][uomFactor]" id="uomFactor'+m+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m+'][varianceshortage]" id="varianceshortage'+m+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m+'][varianceoverage]" id="varianceoverage'+m+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '</tr>');

                var defaultoption = '<option selected value=""></option>';
                var commtypeoptions = '<option value="1">Arrival</option><option value="2">Export</option><option value="3">Reject</option><option value="4">Others(Pre-Clean)</option><option value="5">Others(Export-Excess)</option><option value="6">Others(Caneclled-Export)</option>';
                $('#CommType'+m).append(commtypeoptions);
                $('#CommType'+m).append(defaultoption);
                $('#CommType'+m).select2
                ({
                    placeholder: "Select here",
                    dropdownCssClass : 'cusmidprp',
                });
                
                var gradeoptions = '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="100">UG (Under Grade)</option><option value="101">NG (No Grade)</option><option value="102">Peaberry Coffee</option>';
                $('#Grade'+m).append(gradeoptions);
                $('#Grade'+m).append(defaultoption);
                $('#Grade'+m).select2
                ({
                    placeholder: "Select Grade here...",
                    dropdownCssClass : 'cusmidprp',
                });

                var processtypeoptions = '<option value="Anaerobic">Anaerobic</option><option value="UnWashed">UnWashed</option><option value="Washed">Washed</option><option value="Winey">Winey</option>';
                $('#ProcessType'+m).append(processtypeoptions);
                $('#ProcessType'+m).append(defaultoption);
                $('#ProcessType'+m).select2
                ({
                    placeholder: "Select Process type here...",
                    dropdownCssClass : 'cusmidprp',
                });

                var cropyearoptions = '<option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="0">NCY (No Crop Year)</option>';
                $('#CropYear'+m).append(cropyearoptions);
                $('#CropYear'+m).append(defaultoption);
                $('#CropYear'+m).select2
                ({
                    placeholder: "Select Crop year here...",
                    dropdownCssClass : 'cusmidprp',
                });

                var uomoptions = $("#uomdefault > option").clone();
                $('#Uom'+m).append(uomoptions);
                $('#Uom'+m).append(defaultoption);
                $('#Uom'+m).select2
                ({
                    placeholder: "Select UOM here",
                    dropdownCssClass : 'cusprop',
                });

                var floormapopt = $("#locationdefault > option").clone();
                $('#FloorMap'+m).append(floormapopt);
                $("#FloorMap"+m+" option[title!="+storeid+"]").remove(); 
                $('#FloorMap'+m).append(defaultoption);
                $('#FloorMap'+m).select2
                ({
                    placeholder: "Select Floor map here",
                });

                var supplieropt = $("#supplierdefault > option").clone();
                $('#Supplier'+m).append(supplieropt);
                $('#Supplier'+m).append(defaultoption);
                $('#Supplier'+m).select2
                ({
                    placeholder: "Select Supplier here",
                    dropdownCssClass : 'commprp',
                });

                $('#Origin'+m).select2
                ({
                    placeholder: "Select here",
                    minimumResultsForSearch: -1
                });

                flatpickr('#arrdate'+m, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
                $('#arrdate'+m).val("");
                $('#arrdate'+m).css("background","white");
                
                $('#Feresula'+m).prop("readonly",true);
                $('#TotalPrice'+m).prop("readonly",true);
                $('#BalanceByUom'+m).prop("readonly",true);
                $('#Balance'+m).prop("readonly",true);
                $('#UnitPrice'+m).prop("readonly",true);
                CalculateGrandTotal();
                renumberRows();
                $('#select2-FloorMap'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CommType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Origin'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Grade'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-ProcessType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CropYear'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Uom'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        function commEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            $('.dynamictblclass').hide();
            $('.savebtnclass').hide();
            var borcolor = "";
            var forecolor = "";
            j=0;
            $.ajax({
                url: '/showCommBeg'+'/'+recordId,
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
                    $.each(data.commbegdata, function(key, value) {
                        $('#ProductType').val(value.product_type).select2({minimumResultsForSearch: -1});
                        $('#stores_id').val(value.stores_id).trigger('change').select2();
                        $('#customers_id').val(value.customers_id).trigger('change').select2();
                        $("#Remark").val(value.Remark);

                        if (value.Status == "Ready") 
                        {
                            forecolor = "#f6c23e";
                        }
                        else if (value.Status == "Counting") 
                        {
                            forecolor = "#4e73df";
                        }
                        else if (value.Status == "Posted") 
                        {
                            forecolor = "#1cc88a";
                        }
                        else if (value.Status == "Finish-Counting") 
                        {
                            forecolor = "#858796";
                        }
                        else if (value.Status == "Verified") 
                        {
                            forecolor = "#5bc0de";
                        }
                        else if (value.Status == "Rejected") 
                        {
                            forecolor = "#e74a3b";
                        }
                        $("#statusdisplay").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;'>${value.DocumentNumber}, ${value.Status}</span>`);
                    });

                    if(parseInt(data.product_type) == 1){
                        $('#dynamicTable > tbody').empty();
                        $.each(data.commbegdetaildata, function(key, value) {
                            ++i;
                            ++m;
                            ++j;
                            // $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:2%;text-align:center;">'+j+'</td>'+
                            //     '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            //     '<td style="width:6%;"><select id="FloorMap'+m+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m+'][FloorMap]"></select></td>'+
                            //     '<td style="width:7%;"><input type="text" id="arrdate'+m+'" name="row['+m+'][arrdate]" class="arrdate form-control" placeholder="YYYY-MM-DD" onchange="arrdateFn(this)" ondblclick="arrdateclearFn(this)"/></td>'+
                            //     '<td style="width:8%;"><select id="CommType'+m+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m+'][CommType]"></select></td>'+
                            //     '<td style="width:12%;"><select id="Origin'+m+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select></td>'+
                            //     '<td style="width:7%;"><select id="Grade'+m+'" class="select2 form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select></td>'+
                            //     '<td style="width:7%;"><select id="ProcessType'+m+'" class="select2 form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select></td>'+
                            //     '<td style="width:7%;"><select id="CropYear'+m+'" class="select2 form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select></td>'+
                            //     '<td style="width:7%;"><select id="Uom'+m+'" class="select2 form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select></td>'+
                            //     '<td style="width:8%;"><input type="number" name="row['+m+'][Balance]" placeholder="Write Balance here..." id="Balance'+m+'" value="'+value.Balance+'" class="Balance form-control numeral-mask commnuminp" onkeyup="BalanceFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                            //     '<td style="width:8%;"><input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" value="'+value.UnitPrice+'" class="UnitPrice form-control numeral-mask commnuminp" onkeyup="UnitPriceFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                            //     '<td style="width:8%;"><input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" value="'+value.TotalPrice+'" class="TotalPrice form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                            //     '<td style="width:10%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" value="'+value.Remark+'" placeholder="Write Remark here..."/></td>'+
                            //     '<td style="width:2%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            //     '<td style="display:none;"><input type="number" name="row['+m+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m+'" value="'+value.Feresula+'" class="Feresula form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                            //     '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td></tr>'
                            // );

                            if(parseInt(j)%2===0){
                                borcolor="#f8f9fa";
                            }
                            else{
                                borcolor="#FFFFFF";
                            }

                            $("#dynamicTable > tbody").append('<tr id="rowind'+m+'" class="mb-1" style="background-color:'+borcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                                '<span class="badge badge-center rounded-pill bg-secondary">'+j+'</span>'+
                            '</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width:96%;">'+
                                '<div class="row">'+
                                    '<div class="col-xl-8 col-md-8 col-lg-8" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                                        '<div class="row">'+
                                            '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="FloorMap'+m+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m+'][FloorMap]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Arrival Date</label>'+
                                                '<input type="text" id="arrdate'+m+'" name="row['+m+'][arrdate]" class="arrdate form-control" placeholder="YYYY-MM-DD" onchange="arrdateFn(this)" ondblclick="arrdateclearFn(this)"/>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CommType'+m+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m+'][CommType]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="supplierdiv'+m+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Supplier</label>'+
                                                '<select id="Supplier'+m+'" class="select2 form-control Supplier" onchange="SupplierFn(this)" name="row['+m+'][Supplier]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="grndiv'+m+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">GRN No.</label>'+
                                                '<input type="number" name="row['+m+'][GrnNumber]" placeholder="Write GRN number here..." id="GrnNumber'+m+'" class="GrnNumber form-control numeral-mask commnuminp" value="'+value.GrnNumber+'" onkeyup="GrnNumberFn(this)" onblur="GrnNumberErrFn(this)" onkeypress="return ValidateOnlyNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="productiondiv'+m+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Production Order No.</label>'+
                                                '<input type="number" name="row['+m+'][ProductionNum]" placeholder="Write Production order number here..." id="ProductionNum'+m+'" class="ProductionNum form-control numeral-mask commnuminp" value="'+value.ProductionNumber+'" onkeyup="ProductionNumFn(this)" onblur="ProductionNumErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1 typeprop'+m+'" id="cernumdiv'+m+'" style="display:none;">'+
                                                '<label style="font-size: 12px;">Certificate No.</label>'+
                                                '<input type="number" name="row['+m+'][CertificateNum]" placeholder="Write Certificate Number here..." id="CertificateNum'+m+'" class="CertificateNum form-control numeral-mask commnuminp" value="'+value.CertNumber+'" onkeyup="CertificateNumFn(this)" onblur="CertNumberErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                            '</div>'+
                                            
                                        '</div>'+
                                        '<div class="row">'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Origin'+m+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Grade'+m+'" class="select2 form-control form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="ProcessType'+m+'" class="select2 form-control form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-2 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CropYear'+m+'" class="select2 form-control form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mb-1">'+
                                                '<label style="font-size: 12px;">Remark</label>'+
                                                '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m+'][Remark]" id="Remark'+m+'">'+value.Remark+'</textarea>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-xl-4 col-md-4 col-lg-4">'+
                                        '<div class="row">'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Uom'+m+'" class="select2 form-control form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m+'][BalanceByUom]" placeholder="Write Balance by UOM/Bag here" id="BalanceByUom'+m+'" class="BalanceByUom form-control numeral-mask commnuminp" value="'+value.NumOfBag+'" onkeyup="BalanceByUomFn(this)" onkeypress="return ValidateOnlyNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">Bag Weight</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m+'][TotalBagWeight]" placeholder="Write Bag weight here" id="TotalBagWeight'+m+'" class="TotalBagWeight form-control numeral-mask commnuminp" value="'+value.BagWeight+'" onkeyup="BagWeightFn(this)" readonly onkeypress="return ValidateNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-6 col-lg-6 mt-1">'+
                                                '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m+'" class="TotalKg form-control numeral-mask commnuminp" value="'+value.TotalKg+'" onkeyup="TotalKgFn(this)" onblur="TotalKgErrFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-6 col-lg-6 mt-1">'+
                                                '<label style="font-size: 12px;">Net KG<i class="fa-solid fa-circle-info" title="Total KG - Bag Weight by KG"></i></label>'+
                                                '<input type="number" name="row['+m+'][Balance]" placeholder="Write Balance here..." id="Balance'+m+'" class="Balance form-control numeral-mask commnuminp" value="'+value.Balance+'" onkeyup="BalanceFn(this)" onblur="BalanceErrFn(this)" readonly onkeypress="return ValidateNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mt-1">'+
                                                '<label style="font-size: 12px;">Unit Cost<i class="fa-solid fa-circle-info" title="Before VAT"></i></label>'+
                                                '<input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" class="UnitPrice form-control numeral-mask commnuminp" value="'+value.UnitPrice+'" onkeyup="UnitPriceFn(this)" onkeypress="return ValidateNum(event);"/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-4 mt-1">'+
                                                '<label style="font-size: 12px;">Total Cost<i class="fa-solid fa-circle-info" title="Net KG * Unit Cost"></i></label>'+
                                                '<input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" class="TotalPrice form-control numeral-mask" value="'+value.TotalPrice+'" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-6 col-lg-6 mb-1"></div>'+
                                            '<div class="col-xl-9 col-md-6 col-lg-6 mb-1">'+
                                                '<label style="font-size: 12px;font-weight:bold;" id="varianceLbl'+m+'"></label>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                            '<td style="width:2%;text-align:right;vertical-align: top;">'+
                                '<button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:'+borcolor+';border-color:'+borcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                            '</td>'+
                            '<td style="display:none;"><input type="number" name="row['+m+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m+'" class="Feresula form-control numeral-mask" value="'+value.Feresula+'" onkeypress="return ValidateNum(event);" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m+'][bagWeight]" id="bagWeight'+m+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" value="'+value.bagweight+'" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m+'][uomFactor]" id="uomFactor'+m+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" value="'+value.uomamount+'" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m+'][varianceshortage]" id="varianceshortage'+m+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" value="'+value.VarianceShortage+'" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m+'][varianceoverage]" id="varianceoverage'+m+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" value="'+value.VarianceOverage+'" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td>'+
                            '</tr>');

                            var commtypename="";
                            var defaultorigindata = '<option selected value='+value.woredas_id+'>'+value.Origin+'</option>';
                            var defaultgradedata = '<option selected value='+value.Grade+'>'+value.GradeName+'</option>';
                            var defaultprocesstypedata = '<option selected value='+value.ProcessType+'>'+value.ProcessType+'</option>';
                            var defaultcropyeardata = '<option selected value='+value.CropYear+'>'+value.CropYearData+'</option>';
                            var defaultuomdata = '<option selected value='+value.uoms_id+'>'+value.UomName+'</option>';
                            var defaultfloormap = '<option selected value='+value.LocationId+'>'+value.LocationName+'</option>';
                            var defaultsupplier = '<option selected value='+value.SupplierId+'>'+value.SupplierCode+'   ,   '+value.SupplierName+'   ,   '+value.SupplierTIN+'</option>';

                            $('.typeprop'+m).hide();

                            if (parseInt(value.CommodityType)==1){
                                commtypename="Arrival";
                                $('#supplierdiv'+m).show();
                                $('#grndiv'+m).show();
                            }
                            else if (parseInt(value.CommodityType)==2){
                                commtypename="Export";
                                $('#cernumdiv'+m).show();
                                $('#productiondiv'+m).show();
                            }
                            else if (parseInt(value.CommodityType)==3){
                                commtypename="Reject";
                                $('#cernumdiv'+m).show();
                                $('#productiondiv'+m).show();
                            }
                            else if (parseInt(value.CommodityType)==4){
                                commtypename="Others(Pre-Clean)";
                                $('#supplierdiv'+m).show();
                                $('#grndiv'+m).show();
                            }
                            else if (parseInt(value.CommodityType)==5){
                                commtypename="Others(Export-Excess)";
                                $('#cernumdiv'+m).show();
                                $('#productiondiv'+m).show();
                            }
                            else if (parseInt(value.CommodityType)==6){
                                commtypename="Others(Cancelled-Export)";
                                $('#cernumdiv'+m).show();
                                $('#productiondiv'+m).show();
                            }
                            var defaultcommtype = '<option selected value='+value.CommodityType+'>'+commtypename+'</option>';
                            var commtypeoptions = '<option value="1">Arrival</option><option value="2">Export</option><option value="3">Reject</option><option value="4">Others(Pre-Clean)</option><option value="5">Others(Export-Excess)</option><option value="6">Others(Caneclled-Export)</option>';
                            $('#CommType'+m).append(commtypeoptions);
                            $("#CommType"+m+" option[value='"+value.CommodityType+"']").remove(); 
                            $('#CommType'+m).append(defaultcommtype);
                            $('#CommType'+m).select2
                            ({
                                placeholder: "Select here",
                                dropdownCssClass : 'cusmidprp',
                            });

                            var originoptions = $("#origindefault > option").clone();
                            $('#Origin'+m).append(originoptions);
                            $("#Origin"+m+" option[title!="+value.CommodityType+"]").remove(); 
                            $("#Origin"+m+" option[value='"+value.woredas_id+"']").remove(); 
                            $('#Origin'+m).append(defaultorigindata);
                            $('#Origin'+m).select2
                            ({
                                placeholder: "Select Commodity here",
                                dropdownCssClass : 'commprp',
                            });

                            var supplieropt = $("#supplierdefault > option").clone();
                            $('#Supplier'+m).append(supplieropt);
                            $("#Supplier"+m+" option[value='"+value.SupplierId+"']").remove(); 
                            $('#Supplier'+m).append(defaultsupplier);
                            $('#Supplier'+m).select2
                            ({
                                placeholder: "Select Supplier here",
                                dropdownCssClass : 'commprp',
                            });

                            var floormapopt = $("#locationdefault > option").clone();
                            $('#FloorMap'+m).append(floormapopt);
                            $("#FloorMap"+m+" option[title!="+value.stores_id+"]").remove(); 
                            $("#FloorMap"+m+" option[value='"+value.LocationId+"']").remove(); 
                            $('#FloorMap'+m).append(defaultfloormap);
                            $('#FloorMap'+m).select2
                            ({
                                placeholder: "Select Floor map here",
                            });

                            flatpickr('#arrdate'+m, { dateFormat: 'Y-m-d',clickOpens:true,maxDate:currentdate});
                            $('#arrdate'+m).val(value.ArrivalDate);

                            var gradeoptions = '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="100">UG (Under Grade)</option><option value="101">NG (No Grade)</option><option value="102">Peaberry Coffee</option>';
                            $('#Grade'+m).append(gradeoptions);
                            $("#Grade"+m+" option[value='"+value.Grade+"']").remove(); 
                            $('#Grade'+m).append(defaultgradedata);
                            $('#Grade'+m).select2
                            ({
                                placeholder: "Select Grade here...",
                                dropdownCssClass : 'cusmidprp',
                            });

                            var processtypeoptions = '<option value="Washed">Washed</option><option value="UnWashed">UnWashed</option><option value="GreenBean">GreenBean</option>';
                            $('#ProcessType'+m).append(processtypeoptions);
                            $("#ProcessType"+m+" option[value='"+value.ProcessType+"']").remove(); 
                            $('#ProcessType'+m).append(defaultprocesstypedata);
                            $('#ProcessType'+m).select2
                            ({
                                placeholder: "Select Process type here...",
                                minimumResultsForSearch: -1
                            });

                            var cropyearoptions = '<option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="0">NCY (No Crop Year)</option>';
                            $('#CropYear'+m).append(cropyearoptions);
                            $("#CropYear"+m+" option[value='"+value.CropYear+"']").remove(); 
                            $('#CropYear'+m).append(defaultcropyeardata);
                            $('#CropYear'+m).select2
                            ({
                                placeholder: "Select Crop year here...",
                                dropdownCssClass : 'cusmidprp',
                            });

                            var uomoptions = $("#uomdefault > option").clone();
                            $('#Uom'+m).append(uomoptions);
                            $("#Uom"+m+" option[value='"+value.uoms_id+"']").remove(); 
                            $('#Uom'+m).append(defaultuomdata);
                            $('#Uom'+m).select2
                            ({
                                placeholder: "Select UOM here",
                                minimumResultsForSearch: -1
                            });

                            if(parseFloat(value.VarianceShortage)>0){
                                $('#varianceLbl'+m).html("Variance Shortage: "+numformat(value.VarianceShortage)+" KG");
                            }
                            else if(parseFloat(value.VarianceOverage)>0){
                                $('#varianceLbl'+m).html("Variance Overage: "+numformat(value.VarianceOverage)+" KG");
                            }
                            else if(parseFloat(value.VarianceShortage)==0 || isNaN(parseFloat(value.VarianceShortage)) && parseFloat(value.VarianceOverage)==0 || isNaN(parseFloat(value.VarianceOverage))){
                                $('#varianceLbl'+m).html("");
                            }

                            $('#Feresula'+m).prop("readonly",true);
                            $('#TotalPrice'+m).prop("readonly",true);
                            $('#Balance'+m).prop("readonly",true);
                            $('#select2-FloorMap'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-CommType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Origin'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Grade'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-ProcessType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-CropYear'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Uom'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Supplier'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        });
                        CalculateGrandTotal();
                        renumberRows();
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled",false);
                        $('#savebutton').show();
                        $('#commodity_div').show(); 
                    }
                    else if(parseInt(data.product_type) == 2){
                        $('#goodsDynamicTable > tbody').empty();
                        $.each(data.commbegdetaildata, function(key, value) {
                            ++i3;
                            ++m3;
                            ++j3;
                            $("#goodsDynamicTable > tbody").append(`<tr>
                                <td style="font-weight:bold;text-align:center;width:3%">${j3}</td>
                                <td style="display:none;"><input type="hidden" name="goodsrow[${m3}][goodsval]" id="goodsval${m3}" class="goodsval form-control" readonly="true" style="font-weight:bold;" value="${m3}"/></td>
                                <td style="width:13%">
                                    <select id="FloorMapGoods${m3}" class="select2 form-control FloorMapGoods" onchange="FloorMapGoodsFn(this)" name="goodsrow[${m3}][FloorMapGoods]"></select>
                                </td>
                                <td style="width:16%">
                                    <select id="ItemGoods${m3}" class="select2 form-control ItemGoods" onchange="ItemGoodsFn(this)" name="goodsrow[${m3}][ItemGoods]"></select>
                                </td>
                                <td style="width:13%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="uomgoods${m3}">${value.UomName}</label>
                                    <input type="hidden" name="goodsrow[${m3}][uom_id]" id="uom_id${m3}" class="uom_id form-control numeral-mask" step="any" value="${value.uoms_id}"/>
                                </td>
                                <td style="width:13%">
                                    <input type="number" name="goodsrow[${m3}][QuantityGoods]" placeholder="Quantity" id="quantitygoods${m3}" class="quantitygoods form-control numeral-mask" onkeyup="CalculateGoodsTotal(this)" onkeypress="return ValidateOnlyNum(event);" step="any" value="${value.quantity}"/>
                                </td>
                                <td style="width:13%">
                                    <input type="number" name="goodsrow[${m3}][UnitCostGoods]" placeholder="Unit Cost" id="unitcostgoods${m3}" class="unitcostgoods form-control numeral-mask" onkeyup="CalculateGoodsTotal(this)" onkeypress="return ValidateNum(event);" step="any" value="${value.UnitPrice}"/>
                                </td>
                                <td style="width:13%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px;" class="readonlyfield" id="totalcostgood${m3}">${parseFloat(value.TotalPrice) == 0 || isNaN(parseFloat(value.TotalPrice)) ? '' : value.TotalPrice}</label>
                                    <input type="hidden" name="goodsrow[${m3}][TotalCostGoods]" id="TotalCostGoods${m3}" class="totalcostgoods form-control numeral-mask" step="any" value="${parseFloat(value.TotalPrice) == 0 || isNaN(parseFloat(value.TotalPrice)) ? '' : value.TotalPrice}"/>
                                </td>
                                <td style="width:13%">
                                    <input type="text" name="goodsrow[${m3}][remarkgoods]" placeholder="Remark..." id="remarkgoods${m3}" class="remarkgoods form-control" value="${value.Remark}"/>
                                    
                                </td>
                                <td style="width:3%;text-align:center;">
                                    <button type="button" class="btn btn-light btn-sm remove_trg" id="remove_trg${m3}" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                                </td>
                            </tr>`);

                            var default_location = `<option selected value="${value.LocationId}">${value.LocationName}</option>`;
                            var default_item = `<option selected value="${value.item_id}">${value.item_name}</option>`;

                            var floormapopt = $("#locationdefault > option").clone();
                            $(`#FloorMapGoods${m3}`).append(floormapopt);
                            $(`#FloorMapGoods${m3} option[title!="${value.stores_id}"]`).remove(); 
                            $(`#FloorMapGoods${m3}`).append(default_location);
                            $(`#FloorMapGoods${m3} option[value="${value.LocationId}"]`).remove(); 
                            $(`#FloorMapGoods${m3}`).select2();

                            var itemopt = $("#itemsdefault > option").clone();
                            $(`#ItemGoods${m3}`).append(itemopt);
                            $(`#ItemGoods${m3}`).append(default_item);
                            $(`#ItemGoods${m3} option[value="${value.item_id}"]`).remove(); 
                            $(`#ItemGoods${m3}`).select2();

                            $(`#select2-FloorMapGoods${m3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $(`#select2-ItemGoods${m3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        });
                        renumberGoodsRows();
                        GoodsGrandTotal();
                        $('#savebuttongood').text('Update');
                        $('#savebuttongood').prop("disabled",false);
                        $('#savebuttongood').show();
                        $('#goods_div').show(); 
                    }
                }
            });
            $("#modaltitle").html("Edit Commodity Beginning");
            $("#inlineForm").modal('show'); 
        }

        function commInfoFn(recordId) { 
            $("#recInfoId").val(recordId);
            var lidata="";
            $(".detail_table").hide();
            $.ajax({
                url: '/showCommBeg'+'/'+recordId,
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
                success: function(data) {
                    $.each(data.commbegdata, function(key, value) {
                        $("#infobeginningdocnum").html(value.DocumentNumber);
                        $("#infoendingdocnum").html(value.EndingDocumentNumber);
                        $("#infoproducttype").html(value.ProductType);
                        $("#infostorename").html(value.StoreName);
                        $("#infocustomercode").html(value.CustomerCode);
                        $("#infocustomername").html(value.CustomerName);
                        $("#infocustomertin").html(value.TinNumber);
                        $("#infocustomerphone").html(value.PhoneNumber+"   ,   "+value.OfficePhone);
                        $("#infocustomeremail").html(value.EmailAddress);
                        $("#infofiscalyear").html(value.Monthrange);
                        $("#inforemark").html(value.Remark);

                        $(".exportbtns").hide();
                                                
                        if(parseInt(value.customers_id)==1){
                            $("#customerinfotbl").hide();
                            $("#customerOrOwnerName").val("Owner");
                        }
                        else if(parseInt(value.customers_id)>1){
                            $("#customerinfotbl").show();
                            $("#customerOrOwnerName").val(value.CustomerName);
                        }

                        if (value.Status == "Ready") 
                        {
                            $("#statustitles").html("<span style='color:#f6c23e;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+", "+value.Status+"</span>");
                        }
                        else if (value.Status == "Counting") 
                        {
                            $("#statustitles").html("<span style='color:#4e73df;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+", "+value.Status+"</span>");
                            $("#changetocntbtn").hide();
                            $("#verifybtn").hide();
                            $("#postbtn").hide();
                            $("#donebtn").show();
                        }
                        else if (value.Status == "Posted") 
                        {
                            $("#statustitles").html("<span style='color:#1cc88a;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+", "+value.Status+"</span>");
                            $("#changetocntbtn").hide();
                            $("#verifybtn").hide();
                            $("#postbtn").hide();
                            $("#donebtn").hide();
                            $(".exportbtns").show();
                        }
                        else if (value.Status == "Finish-Counting") 
                        {
                            $("#statustitles").html("<span style='color:#858796;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+", "+value.Status+"</span>");
                            $("#changetocntbtn").show();
                            $("#verifybtn").show();
                            $("#postbtn").hide();
                            $("#donebtn").hide();
                        }
                        else if (value.Status == "Verified") 
                        {
                            $("#statustitles").html("<span style='color:#5bc0de;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+", "+value.Status+"</span>");
                            $("#changetocntbtn").show();
                            $("#verifybtn").hide();
                            $("#postbtn").show();
                            $("#donebtn").hide();
                        }
                        else if (value.Status == "Rejected") 
                        {
                            $("#statustitles").html("<span style='color:#e74a3b;font-weight:bold;font-size:16px;'>"+value.DocumentNumber+", "+value.Status+"</span>");
                            $("#changetocntbtn").hide();
                            $("#verifybtn").hide();
                            $("#postbtn").hide();
                            $("#donebtn").hide();
                        }
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited / Counting" || value.action == "Created / Counting"){
                            classes="warning";
                        }
                        else if(value.action == "Finish-Counting" || value.action == "Verified" || value.action == "Change to Counting"){
                            classes="primary";
                        }
                        else if(value.action == "Posted"){
                            classes="success";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><i class="fa-solid fa-file"></i> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+='<li class="timeline-item"><span class="timeline-point timeline-point-'+classes+' timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">'+value.action+'</h6><span class="text-muted"><i class="fa-regular fa-user"></i> '+value.FullName+'</span>'+reasonbody+'</br><span class="text-muted"><i class="fa-regular fa-clock"></i> '+value.time+'</span></div></li>';
                    });

                    $("#actiondiv").empty();
                    $('#actiondiv').append(lidata);

                    if(parseInt(data.product_type) == 1){
                        fetchCommodityData(recordId);
                    }
                    else if(parseInt(data.product_type) == 2){
                        fetchGoodsData(recordId);
                    }
                }
            });
        }

        function fetchGoodsData(recordId){
            $('#goodsdatatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,  
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                autoWidth: false,
                deferRender: true,
                "order": [
                    [2, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showOriginData/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:"13%"
                    },
                    {
                        data: 'item_name',
                        name: 'item_name',
                        width:"16%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"13%"
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        width:"13%"
                    },
                    {
                        data: 'UnitPrice',
                        name: 'UnitPrice',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"13%"
                    },
                    {
                        data: 'TotalPrice',
                        name: 'TotalPrice',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"13%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"16%"
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

                    var total_cost = api
                    .column(6)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    $('#goods_total_cost').html(total_cost === 0 ? '' : numformat(parseFloat(total_cost).toFixed(2)));
                },
                drawCallback: function(settings) {
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
                    $("#goods_dt_div").show();
                    $(".infoscl").collapse('show');
                    $("#informationmodal").modal('show');
                }
            });
            $('#goodsdatatable').DataTable().columns.adjust().draw();
        }

        function fetchCommodityData(recordId){
            $('#origindetailtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                autoWidth: false,
                deferRender: true,
                "order": [
                    [2, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showOriginData/' + recordId,
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
                        width:"4%"
                    },
                    {
                        data: 'ArrivalDate',
                        name: 'ArrivalDate',
                        width:"4%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"4%"
                    },
                    {
                        data: 'SupplierName',
                        name: 'SupplierName',
                        width:"5%"
                    },
                    {
                        data: 'GrnNumber',
                        name: 'GrnNumber',
                        width:"4%"
                    },
                    {
                        data: 'ProductionNumber',
                        name: 'ProductionNumber',
                        width:"5%"
                    },
                    {
                        data: 'CertNumber',
                        name: 'CertNumber',
                        width:"4%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"5%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"4%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"5%"
                    },
                    {
                        data: 'CropYearData',
                        name: 'CropYearData',
                        width:"4%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"4%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'Balance',
                        name: 'Balance',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'UnitPrice',
                        name: 'UnitPrice',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'TotalPrice',
                        name: 'TotalPrice',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'VarianceShortage',
                        name: 'VarianceShortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'VarianceOverage',
                        name: 'VarianceOverage',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"4%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"5%"
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
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalbagweight = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalgrosskg = api
                    .column(15)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalkgvar = api
                    .column(16)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totaltonvar = api
                    .column(17)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    var totalferesulavar = api
                    .column(18)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvaluedata = api
                    .column(20)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceshr = api
                    .column(21)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var totalvarianceov = api
                    .column(22)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#totalbag').html(totalbagvar === 0 ? '' : numformat(totalbagvar.toFixed(2)));
                    $('#totalbagweight').html(totalbagweight === 0 ? '' : numformat(totalbagweight.toFixed(2)));
                    $('#totalgrosskg').html(totalgrosskg === 0 ? '' : numformat(totalgrosskg.toFixed(2)));
                    $('#totalkg').html(totalkgvar === 0 ? '' : numformat(totalkgvar.toFixed(2)));
                    $('#totalton').html(totaltonvar === 0 ? '' : numformat(totaltonvar.toFixed(2)));
                    $('#totalferesula').html(totalferesulavar === 0 ? '' : numformat(totalferesulavar.toFixed(2)));
                    $('#totalvaluedata').html(totalvaluedata === 0 ? '' : numformat(totalvaluedata.toFixed(2)));
                    $('#totalvarshortage').html(totalvarianceshr === 0 ? '' : numformat(totalvarianceshr.toFixed(2)));
                    $('#totalvarovrage').html(totalvarianceov === 0 ? '' : numformat(totalvarianceov.toFixed(2)));
                },
                drawCallback: function(settings) {
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
                    $("#commodity_dt_div").show();
                    $(".infoscl").collapse('show');
                    $("#informationmodal").modal('show');
                }
            })
        }

        function commBegAttFn(recordId) { 
            var link = "/commbegnote/"+recordId;
            window.open(link, 'Commodity Beginning Note', 'width=1200,height=800,scrollbars=yes');
        }

        $('#deleterecbtn').click(function() {
            var delform = $("#deleteForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteholiday',
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
                    $('#deleterecbtn').text('Deleting...');
                    $('#deleterecbtn').prop("disabled", true);
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
                    if (data.dberrors) {
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
                    }
                    else if(data.success){
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#deletemodal").modal('hide');
                    }
                }
            });
        });

        //----------Start Goods----------

        $("#addgoods").click(function() {
            var storeid = $('#stores_id').val();
            var lastrowcount = $('#goodsDynamicTable > tbody tr:last').find('td').eq(1).find('input').val();
            var floormap = $(`#FloorMapGoods${lastrowcount}`).val();
            var item = $(`#ItemGoods${lastrowcount}`).val();

            if(isNaN(parseInt(storeid))){
                $('#store-error').html("Store is required"); 
                toastrMessage('error',"Please select store/ station first","Error");
            }
            else if((floormap !== undefined && isNaN(parseFloat(floormap))) || (item !== undefined && isNaN(parseFloat(item)))){
                if(floormap !== undefined && isNaN(parseFloat(floormap))){
                    $(`#select2-FloorMapGoods${lastrowcount}-container`).parent().css('background-color',errorcolor);
                }
                if(item !== undefined && isNaN(parseFloat(item))){
                    $(`#select2-ItemGoods${lastrowcount}-container`).parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i3;
                ++m3;
                ++j3;
                $("#goodsDynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j3}</td>
                    <td style="display:none;"><input type="hidden" name="goodsrow[${m3}][goodsval]" id="goodsval${m3}" class="goodsval form-control" readonly="true" style="font-weight:bold;" value="${m3}"/></td>
                    <td style="width:13%">
                        <select id="FloorMapGoods${m3}" class="select2 form-control FloorMapGoods" onchange="FloorMapGoodsFn(this)" name="goodsrow[${m3}][FloorMapGoods]"></select>
                    </td>
                    <td style="width:16%">
                        <select id="ItemGoods${m3}" class="select2 form-control ItemGoods" onchange="ItemGoodsFn(this)" name="goodsrow[${m3}][ItemGoods]"></select>
                    </td>
                    <td style="width:13%;background-color:#efefef;text-align:center">
                        <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="uomgoods${m3}"></label>
                        <input type="hidden" name="goodsrow[${m3}][uom_id]" id="uom_id${m3}" class="uom_id form-control numeral-mask" step="any"/>
                    </td>
                    <td style="width:13%">
                        <input type="number" name="goodsrow[${m3}][QuantityGoods]" placeholder="Quantity" id="quantitygoods${m3}" class="quantitygoods form-control numeral-mask" onkeyup="CalculateGoodsTotal(this)" onkeypress="return ValidateOnlyNum(event);" step="any"/>
                    </td>
                    <td style="width:13%">
                        <input type="number" name="goodsrow[${m3}][UnitCostGoods]" placeholder="Unit Cost" id="unitcostgoods${m3}" class="unitcostgoods form-control numeral-mask" onkeyup="CalculateGoodsTotal(this)" onkeypress="return ValidateNum(event);" step="any"/>
                    </td>
                    <td style="width:13%;background-color:#efefef;text-align:center">
                        <label style="font-weight:bold;font-size:14px;" class="readonlyfield" id="totalcostgood${m3}"></label>
                        <input type="hidden" name="goodsrow[${m3}][TotalCostGoods]" id="TotalCostGoods${m3}" class="totalcostgoods form-control numeral-mask" step="any"/>
                    </td>
                    <td style="width:13%">
                        <input type="text" name="goodsrow[${m3}][remarkgoods]" placeholder="Remark..." id="remarkgoods${m3}" class="remarkgoods form-control"/>
                        
                    </td>
                    <td style="width:3%;text-align:center;">
                        <button type="button" class="btn btn-light btn-sm remove_trg" id="remove_trg${m3}" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                </tr>`);

                var defaultoption = '<option selected value=""></option>';

                var floormapopt = $("#locationdefault > option").clone();
                $(`#FloorMapGoods${m3}`).append(floormapopt);
                $(`#FloorMapGoods${m3} option[title!="${storeid}"]`).remove(); 
                $(`#FloorMapGoods${m3}`).append(defaultoption);
                $(`#FloorMapGoods${m3}`).select2
                ({
                    placeholder: "Select Location here..",
                });

                var itemopt = $("#itemsdefault > option").clone();
                $(`#ItemGoods${m3}`).append(itemopt);
                $(`#ItemGoods${m3}`).append(defaultoption);
                $(`#ItemGoods${m3}`).select2
                ({
                    placeholder: "Select Item here...",
                });

                $(`#select2-FloorMapGoods${m3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-ItemGoods${m3}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                renumberGoodsRows();
            }
        });

        function FloorMapGoodsFn(ele) {
            var idval = $(ele).closest('tr').find('.goodsval').val();
            const row = $(ele).closest('tr');
            var location = $(`#FloorMapGoods${idval}`).val() || 0;
            var item = $(`#ItemGoods${idval}`).val() || 0;

            checkDuplicateCombination(location,item,idval,row[0],1);
        }

        function ItemGoodsFn(ele) {
            var idval = $(ele).closest('tr').find('.goodsval').val();
            const row = $(ele).closest('tr');
            var location = $(`#FloorMapGoods${idval}`).val() || 0;
            var item = $(`#ItemGoods${idval}`).val() || 0;

            $(`#uomgoods${idval}`).html("");

            checkDuplicateCombination(location,item,idval,row[0],2);
        }

        function checkDuplicateCombination(loc, itm, indx, excludeRow, param) {
            if (loc == null || itm == null || loc === '' || itm === '') return false;
            
            const targetKey = String(loc) + '||' + String(itm);
            let found = false;

            // Loop through each row in the table
            $('#goodsDynamicTable tbody tr').each(function () {

                if (excludeRow && this === excludeRow) return; 

                let location = $(this).find('.FloorMapGoods').val();
                let item = $(this).find('.ItemGoods').val();

                if (!location || !item) return; 

                const key = String(location) + '||' + String(item);

                if (key === targetKey) {
                    found = true;
                    if(param == 1){
                        $(`#FloorMapGoods${indx}`).val(null).select2
                        ({
                            placeholder: "Select Item here",
                        });
                        $(`#select2-FloorMapGoods${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                    }
                    if(param == 2){
                        $(`#ItemGoods${indx}`).val(null).select2
                        ({
                            placeholder: "Select Item here",
                        });
                        $(`#select2-ItemGoods${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                    }
                }
            });

            if (found) {
                toastrMessage('error',"Duplicate Location and Item found","Error");
                return true; 
            }

            if(param == 1){
                $(`#select2-FloorMapGoods${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            if(param == 2){
                fetchUOM(itm,indx);
                $(`#select2-ItemGoods${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            return false; 
        }

        function CalculateGoodsTotal(ele) {
            var idval = $(ele).closest('tr').find('.goodsval').val();
            var inputid = ele.getAttribute('id');
            var quantity = $(ele).closest('tr').find('.quantitygoods').val();
            var unitcost = $(ele).closest('tr').find('.unitcostgoods').val();

            quantity = quantity == '' ? 0 : quantity;
            unitcost = unitcost == '' ? 0 : unitcost;

            $(`#TotalCostGoods${idval}`).val("");
            $(`#totalcostgood${idval}`).html("");

            if (!isNaN(parseFloat(quantity)) && !isNaN(parseFloat(unitcost))) {
                var total = parseFloat(quantity) * parseFloat(unitcost);
                $(`#TotalCostGoods${idval}`).val(total === 0 ? '' : parseFloat(total).toFixed(2));
                $(`#totalcostgood${idval}`).html(total === 0 ? '' : parseFloat(total).toFixed(2));
            }

            if(inputid === `quantitygoods${idval}`){
                $(`#quantitygoods${idval}`).css("background","white");
            }
            if(inputid === `unitcostgoods${idval}`){
                $(`#unitcostgoods${idval}`).css("background","white");
            }

            GoodsGrandTotal();
        }

        function GoodsGrandTotal(){
            var grandtotal = 0;
            $.each($('#goodsDynamicTable').find('.totalcostgoods'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandtotal += parseFloat($(this).val());
                }
            });
            $('#infototalcost').html(grandtotal === 0 ? '' : numformat(parseFloat(grandtotal).toFixed(2)));
        }

        $(document).on('click', '.remove_trg', function() {
            $(this).parents('tr').remove();
            GoodsGrandTotal();
            renumberGoodsRows();
            --i3;
        });

        function renumberGoodsRows() {
            var ind;
            $('#goodsDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                ind = index;
            });
        }

        function fetchUOM(itm,indx){
            var item_id = "";
            $.ajax({
                url: '/fetchitemprop',
                type: 'POST',
                data:{
                    item_id:itm,
                },
                success: function(data) {
                    $.each(data.itemdata, function(key, value) {
                        $(`#uom_id${indx}`).val(value.MeasurementId);
                        $(`#uomgoods${indx}`).html(value.uom_name);
                    });
                },
            });
        }

        $('#savebuttongood').click(function(){
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame = "";
            var lastdep = "";

            $.ajax({
                url: '/saveGoodsBeg',
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
                        $('#savebuttongood').text('Saving...');
                        $('#savebuttongood').prop("disabled", true);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebuttongood').text('Updating...');
                        $('#savebuttongood').prop("disabled", true);
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
                        if (data.errors.stores_id) {
                            var text=data.errors.stores_id[0];
                            text = text.replace("stores id", "store");
                            $('#store-error').html(text);
                        }
                        if (data.errors.customers_id) {
                            var text=data.errors.customers_id[0];
                            text = text.replace("customers id", "customer");
                            $('#customer-error').html(text);
                        }
                        
                        if(parseFloat(optype)==1){
                            $('#savebuttongood').text('Save');
                            $('#savebuttongood').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebuttongood').text('Update');
                            $('#savebuttongood').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.errorv2) {
                        $('#goodsDynamicTable > tbody > tr').each(function () {
                            let location = $(this).find('.FloorMapGoods').val();
                            let item = $(this).find('.ItemGoods').val();
                            let quantity = $(this).find('.quantitygoods').val();
                            let unit_cost = $(this).find('.unitcostgoods').val();
                            let rowind = $(this).find('.goodsval').val();

                            if(isNaN(parseFloat(location)) || parseFloat(location)==0){
                                $(`#select2-FloorMapGoods${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(isNaN(parseFloat(item)) || parseFloat(item)==0){
                                $(`#select2-ItemGoods${rowind}-container`).parent().css('background-color',errorcolor);
                            }
                            if(quantity != undefined){
                                if(isNaN(parseFloat(quantity)) || parseFloat(quantity)==0){
                                    $(`#quantitygoods${rowind}`).css("background", errorcolor);
                                }
                            }
                            if(unit_cost != undefined){
                                if(isNaN(parseFloat(unit_cost)) || parseFloat(unit_cost)==0){
                                    $(`#unitcostgoods${rowind}`).css("background", errorcolor);
                                }
                            }
                        });

                        if(parseFloat(optype)==1){
                            $('#savebuttongood').text('Save');
                            $('#savebuttongood').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttongood').text('Update');
                            $('#savebuttongood').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                    }
                    else if(data.emptyerror){
                        if(parseFloat(optype)==1){
                            $('#savebuttongood').text('Save');
                            $('#savebuttongood').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttongood').text('Update');
                            $('#savebuttongood').prop("disabled",false);
                        }
                        toastrMessage('error',"Please add atleast one item","Error");
                    } 
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebuttongood').text('Save');
                            $('#savebuttongood').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttongood').text('Update');
                            $('#savebuttongood').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebuttongood').text('Save');
                            $('#savebuttongood').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttongood').text('Update');
                            $('#savebuttongood').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        closeRegisterModal();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        //----------End Goods----------

        function getDoneInfo()
        {
            var recId=$('#recInfoId').val();
            $('#doneid').val(recId);
            $('#donecountconfirmation').modal('show');
            $('#donecountbtn').prop( "disabled", false );
        }

        function getVerifyInfo()
        {
            var recId=$('#recInfoId').val();
            $('#verifyid').val(recId);
            $('#verifycountconfirmation').modal('show');
            $('#verifyBegbtn').prop( "disabled", false );
        }

        function getChangeBtn()
        {
            var recId=$('#recInfoId').val();
            $('#commentid').val(recId);
            $('#Comment').val("");
            $('#commentModal').modal('show');
            $('#changecountingbtn').prop( "disabled", false );
            $('#Comment').focus();
        }

        function getPostInfo()
        {
            var recId=$('#recInfoId').val();
            $('#postid').val(recId);
            $('#postbgmodal').modal('show');
            $('#bgpostbtn').prop( "disabled", false );
        }

        //Start change to done
        $('#donecountbtn').click(function(){
            var registerForm = $("#donecountform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/doneCommCount',
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
                        $("#donecountconfirmation").modal('hide');
                        $("#informationmodal").modal('hide');
                        toastrMessage('error',"Status should be on Counting","Error");
                    }
                    else if(data.qnterror){
                        var commname="";
                        $.each(data.qnterrorlist, function(key, value) {
                            ++key;
                            commname+=key+". "+value.Commodity+"<br>";
                        });
                        $('#donecountbtn').text('Finish Counting');
                        $("#donecountconfirmation").modal('hide');
                        toastrMessage('error',"Quantities for the following commodities have not been entered</br>--------------</br>"+commname,"Error");
                    }
                    else if(data.costerror){
                        var commname="";
                        $.each(data.costerrorlist, function(key, value) {
                            ++key;
                            commname+=key+". "+value.Commodity+"<br>";
                        });
                        $('#donecountbtn').text('Finish Counting');
                        $("#donecountconfirmation").modal('hide');
                        toastrMessage('error',"Unit Cost for the following commodities have not been entered</br>--------------</br>"+commname,"Error");
                    }
                    else if(data.success) {
                        $('#donecountbtn').text('Finish Counting');
                        toastrMessage('success',"Beginning changed to Finish counting","Success");
                        $("#donecountconfirmation").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                    }
                },
            });
        });
        //End change to done

        //Start change to counting
        $('#changecountingbtn').click(function() {
            var registerForm = $("#commentform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/commentCommCount',
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
                        $('#changecountingbtn').prop( "disabled",false);
                        toastrMessage('error',"Check your inputs","Error"); 
                    }
                    if(data.success) 
                    {
                        $('#changecountingbtn').text('Change to Counting');
                        toastrMessage('success',"Beginning changed to Counting","Success");
                        $("#commentModal").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                    }
                },
            });
        });
        //End change to counting

        //Start change to verify
        $('#verifyBegbtn').click(function() {
            var registerForm = $("#verifycountform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/verifyCommCount',
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
                        $("#verifycountconfirmation").modal('hide');
                        $("#informationmodal").modal('hide');
                        toastrMessage('error',"Status should be on Finish Counting","Error");
                    }
                    else if(data.qnterror){
                        var commname="";
                        $.each(data.qnterrorlist, function(key, value) {
                            ++key;
                            commname+=key+". "+value.Commodity+"<br>";
                        });
                        $('#verifyBegbtn').text('Verify');
                        $("#verifycountconfirmation").modal('hide');
                        toastrMessage('error',"Quantities for the following commodities have not been entered</br>--------------</br>"+commname,"Error");
                    }
                    else if(data.costerror){
                        var commname = "";
                        $.each(data.costerrorlist, function(key, value) {
                            ++key;
                            commname += key+". "+value.Commodity+"<br>";
                        });
                        toastrMessage('error',"Unit Cost for the following commodities have not been entered</br>--------------</br>"+commname,"Error");
                        $('#verifyBegbtn').text('Verify');
                        $("#verifycountconfirmation").modal('hide');
                    }
                    else if(data.success) {
                        $('#verifyBegbtn').text('Verify');
                        toastrMessage('success',"Beginning changed to Verify","Success");
                        $("#verifycountconfirmation").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                    }
                },
            });
        });
        //End change to verify

        //Start change to post
        $('#bgpostbtn').click(function(){
            var registerForm = $("#postform");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/postCommCount',
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
                    if(data.valerror)
                    {
                        $("#postbgmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                        toastrMessage('error',"Status should be on Verified","Error");
                    }
                    else if(data.qnterror){
                        var commname="";
                        $.each(data.qnterrorlist, function(key, value) {
                            ++key;
                            commname+=key+". "+value.Commodity+"<br>";
                        });
                        $('#bgpostbtn').text('Post');
                        $("#postbgmodal").modal('hide');
                        toastrMessage('error',"Quantities for the following commodities have not been entered</br>--------------</br>"+commname,"Error");
                    }
                    else if(data.costerror){
                        
                        if(data.type == 1){
                            var commname="";
                            $.each(data.costerrorlist, function(key, value) {
                                ++key;
                                commname+=key+". "+value.Commodity+"<br>";
                            });
                            toastrMessage('error',"Unit Cost for the following commodities have not been entered</br>--------------</br>"+commname,"Error");
                        }
                        else if(data.type == 2){
                            var item_name = "";
                            $.each(data.costerrorlist, function(key, value) {
                                ++key;
                                item_name += key+". "+value.Item_Name+"<br>";
                            });
                            toastrMessage('error',"Unit Cost for the following items have not been entered</br>--------------</br>"+item_name,"Error");
                        }
                        $('#bgpostbtn').text('Post');
                        $("#postbgmodal").modal('hide');
                        
                    }
                    else if(data.success) 
                    {
                        $('#bgpostbtn').text('Post');
                        toastrMessage('success',"Beginning Posted","Success");
                        $("#postbgmodal").modal('hide');
                        $("#informationmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        var iTable = $('#customersdatatable').dataTable();
                        iTable.fnDraw(false);
                    }
                },
            });
        });
        //End change to post

        function CalculateTotalBalance(){
            var totalkg=0;
            var totalferesula=0;
            var totalton=0;
            var ferval=17;
            var tonval=1000;
            $.each($('#dynamicTable').find('.Balance'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalkg+= parseFloat($(this).val());
                }
            });
            totalferesula=parseFloat(totalkg)/parseFloat(ferval);
            totalton=parseFloat(totalkg)/parseFloat(tonval);

            $('#totalbalancekg').html(numformat(totalkg.toFixed(2)));
            $('#totalbalanceferesula').html(numformat(totalferesula.toFixed(2)));
            $('#totalbalanceton').html(numformat(totalton.toFixed(2)));

            $('#totalbalancekgval').val(totalkg.toFixed(2));
            $('#totalferesulaval').val(totalferesula.toFixed(2));
            $('#totalbalancetonval').val(totalton.toFixed(2));
        }

        function closeRegisterModal() {
            $('.mainforminp').val("");
            $('#status').val("Active");
            $('.errordatalabel').html('');
            $('#recId').val("");
            $('#operationtypes').val("1");
            $('#pricingTable').hide();
            $('#dynamicTable > tbody').empty();
        }

        function storeFn() {
            var storeid=$('#stores_id').val();
            var defaultoption = '<option selected value=""></option>';
            var floormapopt = $("#locationdefault > option").clone();
            $('.FloorMap').empty();
            $('.FloorMap').append(floormapopt);
            $(".FloorMap option[title!="+storeid+"]").remove(); 
            $('.FloorMap').append(defaultoption);
            $('.FloorMap').select2
            ({
                placeholder: "Select Floor map here",
            });

            $('.FloorMapGoods').empty();
            $('.FloorMapGoods').append(floormapopt);
            $(".FloorMapGoods option[title!="+storeid+"]").remove(); 
            $('.FloorMapGoods').append(defaultoption);
            $('.FloorMapGoods').select2
            ({
                placeholder: "Select Location here...",
            });
            $('.select2-selection__rendered').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#store-error').html('');
        }

        $("#downloatoexcel").click(function () {
            let customername=$('#customerOrOwnerName').val();
            let fiscalyear=$('#infofiscalyear').text();

            var table = document.getElementById("origindetailtable");
            var workbook = new ExcelJS.Workbook();
            var worksheet = workbook.addWorksheet("Beginning_Data");

            let headerRowIndex = 1; // Adjust based on where your headers start
            let totalColumns = 24;

            let mergeCells = [];
            let maxColumnWidths = {}; // Store max column widths

            let titleRow = worksheet.addRow([`Beginning Data of ${customername} (${fiscalyear})`]);
            titleRow.font = { bold: true, size: 14, color: { argb: "000000" } };
            titleRow.alignment = { horizontal: "center", vertical: "middle" };

            worksheet.mergeCells(1, 1, 1, 24); // 🔹 Merge across all columns

            // **🔹 Leave an empty row below the title**
            worksheet.addRow([]);

            function processTableRows(tableSection, startRow, isHeader = false) {
                let excelRowIndex = startRow;
                let rowSpanMap = {}; 

                $(tableSection).find("tr").each(function () {
                    let rowData = [];
                    let colIndex = 1;

                    $(this).find("th, td").each(function () {
                        let text = $(this).text().trim();
                        let colspan = parseInt($(this).attr("colspan") || 1);
                        let rowspan = parseInt($(this).attr("rowspan") || 1);

                        // Ensure column is not occupied by previous row span
                        while (rowSpanMap[`${excelRowIndex}-${colIndex}`]) {
                            colIndex++;
                        }

                        rowData[colIndex - 1] = text;
                        let estimatedWidth = text.length * 1.2; // 1.2 units per character (better scaling)
                        estimatedWidth = Math.max(estimatedWidth, 5); // Minimum width for any column

                        if (colIndex === 1) {
                            maxColumnWidths[colIndex] = 5;
                        }
                        else{
                            maxColumnWidths[colIndex] = Math.max(maxColumnWidths[colIndex] || 5, estimatedWidth);
                            maxColumnWidths[colIndex] = Math.min(maxColumnWidths[colIndex], 50); // **Limit max width to 30**
                        }

                        if (colspan > 1 || rowspan > 1) {
                            
                            mergeCells.push({
                                start: { row: excelRowIndex, col: colIndex },
                                end: { row: excelRowIndex + rowspan - 1, col: colIndex + colspan - 1 }
                            });

                            for (let r = 0; r < rowspan; r++) {
                                for (let c = 0; c < colspan; c++) {
                                    rowSpanMap[`${excelRowIndex + r}-${colIndex + c}`] = true;
                                }
                            }
                        }

                        colIndex += colspan;
                    });

                    let row = worksheet.addRow(rowData);

                    if (isHeader) {
                        row.eachCell((cell) => {
                            cell.font = { bold: true, size: 12, color: { argb: "000000" } };
                            cell.fill = { type: "pattern", pattern: "solid", fgColor: { argb: "cccccc" } };
                            cell.alignment = { horizontal: "center", vertical: "middle" };
                        });
                    }

                    excelRowIndex++;
                });

                return excelRowIndex;
            }

            let lastRow = processTableRows($(table).find("thead"), 3, true);
            worksheet.autoFilter = {
                from: { row: 3, column: 1 }, // Header row
                to: { row: 3, column: totalColumns } // Last column
            };
            lastRow = processTableRows($(table).find("tbody"), lastRow);
            processTableRows($(table).find("tfoot"), lastRow, false, true); // Handle footer

            mergeCells.forEach((cell) => {
                worksheet.mergeCells(
                    cell.start.row,
                    cell.start.col,
                    cell.end.row,
                    cell.end.col
                );
            });

            worksheet.eachRow((row) => {
                row.eachCell((cell) => {
                    cell.border = {
                        top: { style: "thin" },
                        left: { style: "thin" },
                        bottom: { style: "thin" },
                        right: { style: "thin" },
                    };
                    cell.alignment = { horizontal: "center", vertical: "middle" };
                });
            });

            worksheet.columns.forEach((column, i) => {
                column.width = maxColumnWidths[i + 1] || 5; // **Set a default min width of 10**
            });

            workbook.xlsx.writeBuffer().then((data) => {
                var blob = new Blob([data], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                });
                saveAs(blob,`Beginning_Data_of_${customername}_(${fiscalyear}).xlsx`);
            });
        });

        $("#downloadtopdf").click(function () {
            let customername=$('#customerOrOwnerName').val();
            let fiscalyear=$('#infofiscalyear').text();

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            let headers = [];
            let bodyData = [];
            let mergeCells = [];

            // Get headers (handling colspan for headers)
            $("#origindetailtable thead tr").each(function () {
                let rowData = [];
                let headerMerge = []; // Store merge info for headers

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push({ content: text, colSpan: colspan }); // Use colSpan key

                    if (colspan > 1) {
                        headerMerge.push({
                            col: colIndex,
                            colspan: colspan,
                        });
                    }
                });
                headers.push(rowData);
            });


            // Get body data (handling colspan)
            $("#origindetailtable tbody tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("td").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }
                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            });

            $("#origindetailtable tfoot tr").each(function (rowIndex) {
                let rowData = [];
                let colIndexOffset = 0;

                $(this).find("th").each(function (colIndex) {
                    let colspan = parseInt($(this).attr("colspan")) || 1;
                    let text = $(this).text().trim();

                    rowData.push(text);

                    if (colspan > 1) {
                        mergeCells.push({
                            row: bodyData.length, // Corrected row index
                            col: colIndex + colIndexOffset,
                            colspan: colspan,
                        });

                        for (let i = 1; i < colspan; i++) {
                            rowData.push("");
                        }

                        colIndexOffset += colspan - 1;
                    }
                });

                bodyData.push(rowData);
            }); 

            doc.setFontSize(12);  // Title font size
            doc.setFont("Montserrat, Helvetica, Arial, serif", "bold");
            doc.setTextColor(0, 0, 0);  
            
            const pageWidth = doc.internal.pageSize.width;
            const titleText =`Beginning Data of ${customername} (${fiscalyear})`;
            const textWidth = doc.getStringUnitWidth(titleText) * doc.internal.getFontSize() / doc.internal.scaleFactor;
            const xCoordinate = (pageWidth - textWidth) / 2;  // Centering the text

            doc.text(titleText, xCoordinate, 10);  

            doc.autoTable({
                head: headers,  // Correctly formatted headers
                body: bodyData,
                theme: "grid",
                styles: {
                    fontSize: 5,
                    cellPadding: 0.3,
                    overflow: "linebreak",
                    valign: "middle",
                    halign: "center",
                    whiteSpace: "pre-wrap", // ✅ Forces wrapping
                },
                columnStyles: {
                    "*": { 
                        cellWidth: "wrap" // Adjust the width as needed
                    }
                },
                headStyles: {
                    fillColor: [204, 204, 204], 
                    textColor: [0, 0, 0], 
                    lineWidth: 0.1, // Border thickness
                    lineColor: [0, 0, 0], // White border
                    fontStyle: "bold",
                },
                
                margin: { top: 12, left: 1, right: 1 },
                didParseCell: function (data) {
                    if (data.row.section === "body"){
                        mergeCells.forEach(function (merge) {
                            if (data.row.index === merge.row && data.column.index === merge.col) {
                                data.cell.colSpan = merge.colspan;
                                data.cell.styles.fontStyle = 'bold';
                            }
                            if(parseInt(data.cell.colSpan)==13){
                                data.cell.styles.halign = "right";
                            }
                        });

                        data.cell.styles.lineWidth = 0.1;  // Thickness of the border
                        data.cell.styles.lineColor = [0, 0, 0];  // Black border color
                    }

                    let pageSize = doc.internal.pageSize;
                    let pageHeight = pageSize.height;
                    let pageNumber = doc.getNumberOfPages();
                    
                    doc.setFontSize(5);
                    doc.setTextColor(100);
                },
            });

            let totalPages = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPages; i++) {
                doc.setPage(i);
                doc.setFontSize(5);
                doc.setTextColor(100);
                doc.text(`Page ${i} of ${totalPages}`, pageWidth / 2, doc.internal.pageSize.height - 10, { align: "center" });
            }

            doc.save(`Beginning_Data_of_${customername}_(${fiscalyear}).pdf`);
        });

        function prTypeFn() {
            var productType = $('#ProductType').val();
            $('.savebtnclass').hide();
            $('.dynamictblclass').hide();
            $('#CommoditySource').empty();
            $('#dynamicTable > tbody').empty();
            $('#goodsDynamicTable > tbody').empty();    

            if(productType == 1){
                $('#commodity_div').show(); 
                $('#savebutton').show(); 
                $("#modaltitle").html("Add Commodity Beginning");
            }
            else if(productType == 2){
                $('#goods_div').show(); 
                $('#savebuttongood').show();
                $("#modaltitle").html("Add Goods Beginning");
            }
            $('#prdtype-error').html("");
        }

        //-----------Start Ending-------------
        function commEndingFn(recordId) { 
            $("#beginning_id").val(recordId);
            $("#ending_id").val("");
            $(".product_type_div").hide();
            var beg_id = "";
            var backcolor = "";
            var total_kg = 0;
            var variance = 0;
            var variance_lbl = "";
            var product_type = "";
            j2 = 0;
            j3 = 0;
            $("#endingtbl > tbody").empty();
            $("#customerendinginfotbl").hide();
            $.ajax({
                url: '/showCommBeg'+'/'+recordId,
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
                
                success: function(data) {
                    product_type = data.product_type;
                    $.each(data.commbegdata, function(key, value) {
                        $("#infoendinningdocnum").html(value.DocumentNumber);
                        $("#ending_doc_lbl").html(`<a style="text-decoration:underline;color:blue;" onclick=commEndingInfoFn(${recordId})>${value.EndingDocumentNumber == null || value.EndingDocumentNumber === null ? "" : value.EndingDocumentNumber}</a>`);
                        $("#infoendingstorename").html(value.StoreName);
                        $("#infoendingcustomercode").html(value.CustomerCode);
                        $("#infoendingcustomername").html(value.CustomerName);
                        $("#infoendingcustomertin").html(value.TinNumber);
                        $("#infoendingcustomerphone").html(value.PhoneNumber+"   ,   "+value.OfficePhone);
                        $("#infoendingcustomeremail").html(value.EmailAddress);
                        $("#infoendingfiscalyear").html(value.Monthrange);
                        $("#infoendingremark").html(value.Remark);
                                                
                        if(parseInt(value.customers_id)==1){
                            $("#customerendinginfotbl").hide();
                            $("#customerOrOwnerName").val("Owner");
                        }
                        else if(parseInt(value.customers_id)>1){
                            $("#customerendinginfotbl").show();
                            $("#customerOrOwnerName").val(value.CustomerName);
                        }

                        $("#customer_owner_id").val(value.customers_id);
                        $("#store_id").val(value.stores_id);
                        $("#fiscal_year").val(value.FiscalYear);           
                    });
                }
            });

            $.ajax({
                url: "{{url('fetchEndingBalance')}}",
                type: 'POST',
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
                data:{
                    beg_id: recordId,
                },
                dataType: "json",
                success: function(data) {
                    if (data.type == 1){
                        $.each(data.balance, function(key, value) {
                            ++i2;
                            ++m2;
                            ++j2;
                            
                            if(parseInt(j2) % 2 === 0){
                                backcolor = "#f8f9fa";
                            }
                            else{
                                backcolor = "#FFFFFF";
                            }

                            total_kg = parseFloat(value.available_net_kg) + parseFloat(value.bagweight * value.available_bag);
                            variance = parseFloat(value.available_bag * value.uomamount) - parseFloat(value.available_net_kg);
                            
                            var bag_weight = parseFloat(value.bagweight) * parseFloat(value.available_bag);
                            variance_lbl = parseFloat(variance) > 0 ? `Variance Shortage: <b>${numformat(parseFloat(variance).toFixed(2))}</b>` : (parseFloat(variance) < 0 ? `Variance Overage: <b>${numformat(parseFloat(variance).toFixed(2)) * (-1)}</b>` : "");

                            $("#endingtbl > tbody").append(`
                                <tr id="commentr${m2}" class="mb-1" style="background-color:${backcolor}">
                                    <td style="width:2%;text-align:left;vertical-align: top;">
                                        <span class="badge badge-center rounded-pill bg-secondary">${j2}</span>
                                    </td>
                                    <td style="display:none;"><input type="hidden" name="endrow[${m2}][endvals]" id="endvals${m2}" class="endvals form-control" readonly="true" style="font-weight:bold;" value="${m2}"/></td>
                                    <td style="width:98%;">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Commodity Type: <b>${value.CommodityType}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Commodity Name: <b>${value.Commodity}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Grade: <b>${value.Grade}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Process Type: <b>${value.ProcessType}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Crop Year: <b>${value.CropYear}</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Supplier: <b>${value.Supplier}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">GRN No.: <b>${value.GrnNumber}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Production Order No.: <b>${value.ProductionNumber}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Certificate No.: <b>${value.CertNumber}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Floor Map: <b>${value.FloorMap}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Store/ Station: <b>${value.StoreName}</b></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                        <label style="font-size: 12px;"><b><u>System Count</u></b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">No. of Bag: <b>${numformat(parseFloat(value.available_bag).toFixed(2))} ${value.UomName}</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Bag Weight: <b>${numformat(parseFloat(bag_weight).toFixed(2))} KG</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Total KG: <b>${numformat(parseFloat(total_kg).toFixed(2))} KG</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Net KG: <b>${numformat(parseFloat(value.available_net_kg).toFixed(2))} KG</b></label>
                                                    </div>
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">${variance_lbl}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="text-align: center;">
                                                        <label style="font-size: 12px;"><b><u>Physical Count</u></b></label>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>
                                                        <input type="number" step="any" name="endrow[${m2}][num_of_bag]" placeholder="Write number of bag here..." id="num_of_bag${m2}" class="num_of_bag form-control numeral-mask commnuminp" onkeyup="num_of_bagFn(this)" onkeypress="return ValidateOnlyNum(event);" value="${value.no_of_bag}" />
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Bag Weight</label><label style="color: red; font-size:16px;">*</label>
                                                        <input type="number" step="any" name="endrow[${m2}][bag_weight]" placeholder="Bag Weight" id="bag_weight${m2}" class="bag_weight form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" value="${value.bag_weight}"/>
                                                    </div>
                                                    
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>
                                                        <input type="number" step="any" name="endrow[${m2}][total_kg]" placeholder="Write total kg here..." id="total_kg${m2}" class="total_kg form-control numeral-mask commnuminp" onkeyup="total_kgFn(this)" onkeypress="return ValidateNum(event);" value="${value.total_kg}"/>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                                        <label style="font-size: 12px;">Net KG</label><label style="color: red; font-size:16px;">*</label>
                                                        <input type="number" step="any" name="endrow[${m2}][net_kg]" placeholder="Net KG" id="net_kg${m2}" class="net_kg form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" value="${value.net_kg}"/>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label style="font-size: 12px;" id="discr_lbl${m2}"></label>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label style="font-size: 12px;" id="discr_kg_lbl${m2}"></label>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                        <label style="font-size: 12px;">Unit Cost</label><label style="color: red; font-size:16px;">*</label>
                                                        <input type="number" step="any" name="endrow[${m2}][unit_cost]" placeholder="Write unit cost..." id="unit_cost${m2}" class="unit_cost form-control numeral-mask commnuminp" onkeyup="unit_costFn(this)" onkeypress="return ValidateNum(event);" value="${value.unit_cost}"/>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                                        <label style="font-size: 12px;">Total Cost</label><label style="color: red; font-size:16px;">*</label>
                                                        <input type="number" step="any" name="endrow[${m2}][total_cost]" placeholder="Total Cost" id="total_cost${m2}" class="total_cost form-control numeral-mask commnuminp" readonly onkeypress="return ValidateNum(event);" value="${value.total_cost}"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="display:none;">
                                        <input type="number" step="any" name="endrow[${m2}][detail_id]" id="detail_id${m2}" value="${value.detail_id}" class="detail_id form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][bag_weight_factor]" id="bag_weight_factor${m2}" value="${value.bagweight}" class="bag_weight_factor form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][available_bag]" id="available_bag${m2}" value="${value.available_bag}" class="available_bag form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][total_kg_val]" id="total_kg_val${m2}" value="${total_kg}" class="total_kg_val form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][available_net_kg]" id="available_net_kg${m2}" value="${value.available_net_kg}" class="available_net_kg form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="text" name="endrow[${m2}][uom_name]" id="uom_name${m2}" value="${value.UomName}" class="uom_name form-control commnuminp" readonly/>

                                        <input type="number" step="any" name="endrow[${m2}][disc_shortage_bag]" id="disc_shortage_bag${m2}" value="${value.disc_shortage_bag}" class="disc_shortage_bag form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][disc_overage_bag]" id="disc_overage_bag${m2}" value="${value.disc_overage_bag}" class="disc_overage_bag form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][disc_shortage_kg]" id="disc_shortage_kg${m2}" value="${value.disc_shortage_kg}" class="disc_shortage_kg form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                        <input type="number" step="any" name="endrow[${m2}][disc_overage_kg]" id="disc_overage_kg${m2}" value="${value.disc_overage_kg}" class="disc_overage_kg form-control numeral-mask commnuminp" readonly onkeypress="return ValidateOnlyNum(event);"/>
                                    </td>
                                </tr>`
                            );

                            //$(`#discr_lbl${m2}`).html(parseFloat(value.disc_overage_bag) > 0 ? `Discrepancy Overage: <b>${value.disc_overage_bag} ${value.UomName}</b>` : (parseFloat(value.disc_shortage_bag) > 0 ? `Discrepancy Shortage: <b>${value.disc_shortage_bag} ${value.UomName}</b>` : ""));
                            //$(`#discr_kg_lbl${m2}`).html(parseFloat(value.disc_overage_kg) > 0 ? `Discrepancy Overage: <b>${value.disc_overage_kg} KG</b>` : (parseFloat(value.disc_shortage_kg) > 0 ? `Discrepancy Shortage: <b>${value.disc_shortage_kg} KG</b>` : ""));
                            calcDiscrepancy(m2);
                        });
                        CalcEndingGrandTotal();

                        $("#commodity_total_div").show();
                        $("#ending_commodity_div").show();
                    }
                    else if(data.type == 2){
                        $("#goods_ending_tbl > tbody").empty();
                        $.each(data.balance, function(key, value) {
                            ++i3;
                            ++m3;
                            ++j3;
                            $("#goods_ending_tbl > tbody").append(`<tr>
                                <td style="font-weight:bold;text-align:center;width:3%">${j3}</td>
                                <td style="display:none;"><input type="hidden" name="goodsrow[${m3}][goods_ending_val]" id="goods_ending_val${m3}" class="goods_ending_val form-control" readonly="true" style="font-weight:bold;" value="${m3}"/></td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="ending_location${m3}">${value.location_name}</label>
                                </td>
                                <td style="width:13%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="ending_item${m3}">${value.item_name}</label>
                                </td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="ending_uom${m3}">${value.uom_name}</label>
                                </td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="average_cost${m3}">${value.average_cost}</label>
                                    <input type="hidden" name="goodsrow[${m3}][AverageCost]" placeholder="Average cost..." id="average_cost_inp${m3}" class="average_cost_inp form-control numeral-mask" onkeypress="return ValidateOnlyNum(event);" step="any" value="${value.average_cost}"/>
                                </td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="system_count${m3}">${value.system_count}</label>
                                    <input type="hidden" name="goodsrow[${m3}][SystemCount]" placeholder="System count" id="system_count_inp${m3}" class="system_count_inp form-control numeral-mask" onkeypress="return ValidateNum(event);" step="any" value="${value.system_count}"/>
                                </td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <input type="number" name="goodsrow[${m3}][PhysicalCount]" placeholder="Physical count" id="physical_count_inp${m3}" class="physical_count_inp form-control numeral-mask" onkeyup="physicalCountFn(${m3})" onkeypress="return ValidateNum(event);" step="any" value="${value.quantity}"/>
                                </td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield variance_class" id="variance_shortage${m3}">${value.variance_shortage}</label>
                                    <input type="hidden" name="goodsrow[${m3}][VarianceShortage]" placeholder="Variance shortage..." id="variance_shortage_inp${m3}" class="variance_shortage_inp variance_class form-control numeral-mask" onkeypress="return ValidateNum(event);" step="any" value="${value.variance_shortage}"/>
                                </td>
                                <td style="width:12%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield variance_class" id="variance_overage${m3}">${value.variance_overage}</label>
                                    <input type="hidden" name="goodsrow[${m3}][VarianceOverage]" placeholder="Variance overage..." id="variance_overage_inp${m3}" class="variance_overage_inp variance_class form-control numeral-mask" onkeypress="return ValidateNum(event);" step="any" value="${value.variance_overage}"/>
                                </td>
                                <td style="display:none;">
                                    <input type="hidden" name="goodsrow[${m3}][record_id]" id="record_id${m3}" class="record_id form-control numeral-mask" onkeypress="return ValidateNum(event);" step="any" value="${value.record_id}"/>
                                </td>
                            </tr>`);

                            physicalCountFn(m3);
                        });
                        //CalcGoodsGrandTotal();
                        $("#goods_ending_tbl").show();
                        $("#ending_goods_div").show();
                    }
                }
            });

            $('#saveendingbutton').text('Save');
            $('#saveendingbutton').prop("disabled", false);
            $(".infoend").collapse('show');
            $("#manageendingmodal").modal('show');
        }

        function num_of_bagFn(ele){
            var indx = $(ele).closest('tr').find('.endvals').val();
            var current_no_bag = $(`#num_of_bag${indx}`).val();
            var bag_weight = $(`#bag_weight${indx}`).val();
            var bag_weight_factor = $(`#bag_weight_factor${indx}`).val();
            var available_bag = $(`#available_bag${indx}`).val();
            var total_kg = $(`#total_kg${indx}`).val();
            var available_net_kg = $(`#available_net_kg${indx}`).val();
            var uom_name = $(`#uom_name${indx}`).val();
            var current_bag_weight = parseFloat(bag_weight_factor) * parseFloat(current_no_bag);
            var current_net_kg = parseFloat(total_kg) - parseFloat(current_bag_weight);

            $(`#disc_shortage_bag${indx}`).val("");
            $(`#disc_overage_bag${indx}`).val("");

            if(parseFloat(current_no_bag) > parseFloat(available_bag)){
                var disc = parseFloat(current_no_bag) - parseFloat(available_bag);
                $(`#discr_lbl${indx}`).html(`Discrepancy Overage: <b>${disc} ${uom_name}</b>`);
                $(`#disc_overage_bag${indx}`).val(disc);
            }
            if(parseFloat(current_no_bag) < parseFloat(available_bag)){
                var disc = parseFloat(available_bag) - parseFloat(current_no_bag);
                $(`#discr_lbl${indx}`).html(`Discrepancy Shortage: <b>${disc} ${uom_name}</b>`);
                $(`#disc_shortage_bag${indx}`).val(disc);
            }
            if(parseFloat(current_no_bag) == parseFloat(available_bag)){
                $(`#discr_lbl${indx}`).html("");
                $(`#disc_shortage_bag${indx}`).val("");
                $(`#disc_overage_bag${indx}`).val("");
            }

            $(`#bag_weight${indx}`).val(parseFloat(current_bag_weight).toFixed(2));
            calcEndingNetKg(indx);
            CalcEndingGrandTotal();
            $(`#num_of_bag${indx}`).css("background","white");
        }

        function total_kgFn(ele){
            var indx = $(ele).closest('tr').find('.endvals').val();
            var current_no_bag = $(`#num_of_bag${indx}`).val();
            var current_total_kg = $(`#total_kg${indx}`).val();
            var bag_weight = $(`#bag_weight${indx}`).val();
            var bag_weight_factor = $(`#bag_weight_factor${indx}`).val();
            var available_bag = $(`#available_bag${indx}`).val();
            var total_kg = $(`#total_kg${indx}`).val();
            var available_net_kg = $(`#available_net_kg${indx}`).val();
            var current_net_kg = parseFloat(current_total_kg) - parseFloat(bag_weight);

            $(`#disc_shortage_kg${indx}`).val("");
            $(`#disc_overage_kg${indx}`).val("");

            if(parseFloat(current_net_kg) > parseFloat(available_net_kg)){
                var disc = parseFloat(current_net_kg) - parseFloat(available_net_kg);
                $(`#discr_kg_lbl${indx}`).html(`Discrepancy Overage: <b>${numformat(parseFloat(disc).toFixed(2))} KG</b>`);
                $(`#disc_overage_kg${indx}`).val(disc);
            }
            if(parseFloat(current_net_kg) < parseFloat(available_net_kg)){
                var disc = parseFloat(available_net_kg) - parseFloat(current_net_kg);
                $(`#discr_kg_lbl${indx}`).html(`Discrepancy Shortage: <b>${numformat(parseFloat(disc).toFixed(2))} KG</b>`);
                $(`#disc_shortage_kg${indx}`).val(disc);
            }
            if(parseFloat(current_net_kg) == parseFloat(available_net_kg)){
                $(`#discr_kg_lbl${indx}`).html("");
                $(`#disc_shortage_kg${indx}`).val("");
                $(`#disc_overage_kg${indx}`).val("");
            }
            $(`#net_kg${indx}`).val(parseFloat(current_net_kg) > 0 ? (parseFloat(current_net_kg).toFixed(2)) : "");
            $(`#total_kg${indx}`).css("background","white");
            CalcEndingGrandTotal();
        }

        function unit_costFn(ele){
            var indx = $(ele).closest('tr').find('.endvals').val();
            calcTotalEndingCost(indx);
            $(`#unit_cost${indx}`).css("background","white");
            CalcEndingGrandTotal();
        }

        function calcEndingNetKg(indx){
            var current_no_bag = $(`#num_of_bag${indx}`).val();
            var bag_weight_factor = $(`#bag_weight_factor${indx}`).val();
            var total_kg = $(`#total_kg${indx}`).val();

            var current_bag_weight = parseFloat(bag_weight_factor) * parseFloat(current_no_bag);
            var current_net_kg = parseFloat(total_kg) - parseFloat(current_bag_weight);

            $(`#net_kg${indx}`).val(parseFloat(current_net_kg) > 0 ? parseFloat(current_net_kg).toFixed(2) : "");
        }

        function calcDiscrepancy(indx){
            var current_no_bag = $(`#num_of_bag${indx}`).val();
            var available_bag = $(`#available_bag${indx}`).val();
            var uom_name = $(`#uom_name${indx}`).val();

            var available_net_kg = $(`#available_net_kg${indx}`).val();
            var current_net_kg = $(`#net_kg${indx}`).val();

            $(`#disc_shortage_bag${indx}`).val("");
            $(`#disc_overage_bag${indx}`).val("");

            $(`#disc_shortage_kg${indx}`).val("");
            $(`#disc_overage_kg${indx}`).val("");

            if(parseFloat(current_no_bag) > parseFloat(available_bag)){
                var disc = parseFloat(current_no_bag) - parseFloat(available_bag);
                $(`#discr_lbl${indx}`).html(`Discrepancy Overage: <b>${disc} ${uom_name}</b>`);
                $(`#disc_overage_bag${indx}`).val(disc);
            }
            if(parseFloat(current_no_bag) < parseFloat(available_bag)){
                var disc = parseFloat(available_bag) - parseFloat(current_no_bag);
                $(`#discr_lbl${indx}`).html(`Discrepancy Shortage: <b>${disc} ${uom_name}</b>`);
                $(`#disc_shortage_bag${indx}`).val(disc);
            }
            if(parseFloat(current_no_bag) == parseFloat(available_bag)){
                $(`#discr_lbl${indx}`).html("");
                $(`#disc_shortage_bag${indx}`).val("");
                $(`#disc_overage_bag${indx}`).val("");
            }

            if(parseFloat(current_net_kg) > parseFloat(available_net_kg)){
                var disc = parseFloat(current_net_kg) - parseFloat(available_net_kg);
                $(`#discr_kg_lbl${indx}`).html(`Discrepancy Overage: <b>${numformat(parseFloat(disc).toFixed(2))} KG</b>`);
                $(`#disc_overage_kg${indx}`).val(disc);
            }
            if(parseFloat(current_net_kg) < parseFloat(available_net_kg)){
                var disc = parseFloat(available_net_kg) - parseFloat(current_net_kg);
                $(`#discr_kg_lbl${indx}`).html(`Discrepancy Shortage: <b>${numformat(parseFloat(disc).toFixed(2))} KG</b>`);
                $(`#disc_shortage_kg${indx}`).val(disc);
            }
            if(parseFloat(current_net_kg) == parseFloat(available_net_kg)){
                $(`#discr_kg_lbl${indx}`).html("");
                $(`#disc_shortage_kg${indx}`).val("");
                $(`#disc_overage_kg${indx}`).val("");
            }
        }

        function calcTotalEndingCost(indx){
            var net_kg = $(`#net_kg${indx}`).val();
            var unit_cost = $(`#unit_cost${indx}`).val();
            var total_cost = parseFloat(net_kg) * parseFloat(unit_cost);
            $(`#total_cost${indx}`).val(parseFloat(total_cost) > 0 ? parseFloat(total_cost).toFixed(2) : "");
        }

        function CalcEndingGrandTotal(){
            var num_of_bag = 0;
            var bag_weight = 0;
            var net_kg = 0;
            var disc_shortage_kg = 0;
            var disc_overage_kg = 0;
            var disc_shortage_bag = 0;
            var disc_overage_bag = 0;
            var total_feresula = 0;
            var total_ton = 0;
            var total_cost = 0;

            $.each($('#endingtbl').find('.num_of_bag'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    num_of_bag += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.bag_weight'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    bag_weight += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.net_kg'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    net_kg += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.disc_shortage_kg'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    disc_shortage_kg += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.disc_overage_kg'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    disc_overage_kg += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.disc_shortage_bag'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    disc_shortage_bag += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.disc_overage_bag'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    disc_overage_bag += parseFloat($(this).val());
                }
            });

            $.each($('#endingtbl').find('.total_cost'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    total_cost += parseFloat($(this).val());
                }
            });

            total_feresula = parseFloat(net_kg) / 17;
            total_ton = parseFloat(net_kg) / 1000;

            $('#totalnumberofbagval_ending').val(parseFloat(num_of_bag) > 0 ? parseFloat(num_of_bag).toFixed(2) : 0);
            $('#totalbagweightbykgval_ending').val(parseFloat(bag_weight) > 0 ? parseFloat(bag_weight).toFixed(2) : 0);
            $('#totalbalancekgval_ending').val(parseFloat(net_kg) > 0 ? parseFloat(net_kg).toFixed(2) : 0);
            $('#total_shortage_disc_by_kg_inp').val(parseFloat(disc_shortage_kg) > 0 ? parseFloat(disc_shortage_kg).toFixed(2) : 0);
            $('#total_overage_disc_by_kg_inp').val(parseFloat(disc_overage_kg) > 0 ? parseFloat(disc_overage_kg).toFixed(2) : 0);
            $('#total_shortage_disc_by_bag_inp').val(parseFloat(disc_shortage_bag) > 0 ? parseFloat(disc_shortage_bag).toFixed(2) : 0);
            $('#total_overage_disc_by_bag_inp').val(parseFloat(disc_overage_bag) > 0 ? parseFloat(disc_overage_bag).toFixed(2) : 0);
            $('#totalferesulaval_ending').val(parseFloat(total_feresula) > 0 ? parseFloat(total_feresula).toFixed(2) : 0);
            $('#totalbalancetonval_ending').val(parseFloat(total_ton) > 0 ? parseFloat(total_ton).toFixed(2) : 0);
            $('#total_ending_value_inp').val(parseFloat(total_cost) > 0 ? parseFloat(total_cost).toFixed(2) : 0);

            $('#totalnumberofbag_ending').html(parseFloat(num_of_bag) > 0 ? numformat(parseFloat(num_of_bag).toFixed(2)) : "");
            $('#totalbagweightbykg_ending').html(parseFloat(bag_weight) > 0 ? numformat(parseFloat(bag_weight).toFixed(2)) : "");
            $('#totalbalancekg_ending').html(parseFloat(net_kg) > 0 ? numformat(parseFloat(net_kg).toFixed(2)) : "");
            $('#total_shortage_disc_by_kg_lbl').html(parseFloat(disc_shortage_kg) > 0 ? numformat(parseFloat(disc_shortage_kg).toFixed(2)) : "");
            $('#total_overage_disc_by_kg_lbl').html(parseFloat(disc_overage_kg) > 0 ? numformat(parseFloat(disc_overage_kg).toFixed(2)) : "");
            $('#total_shortage_disc_by_bag_lbl').html(parseFloat(disc_shortage_bag) > 0 ? numformat(parseFloat(disc_shortage_bag).toFixed(2)) : "");
            $('#total_overage_disc_by_bag_lbl').html(parseFloat(disc_overage_bag) > 0 ? numformat(parseFloat(disc_overage_bag).toFixed(2)) : "");
            $('#totalbalanceferesula_ending').html(parseFloat(total_feresula) > 0 ? numformat(parseFloat(total_feresula).toFixed(2)) : "");
            $('#totalbalanceton_ending').html(parseFloat(total_ton) > 0 ? numformat(parseFloat(total_ton).toFixed(2)) : "");
            $('#total_ending_value_lbl').html(parseFloat(total_cost) > 0 ? numformat(parseFloat(total_cost).toFixed(2)) : "");
        }

        function CalcGoodsGrandTotal(){
            var system_count = 0;
            var physical_count = 0;
            var variance_shortage = 0;
            var variance_overage = 0;

            $.each($('#goods_ending_tbl').find('.system_count_inp'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    system_count += parseFloat($(this).val());
                }
            });

            $.each($('#goods_ending_tbl').find('.physical_count_inp'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    physical_count += parseFloat($(this).val());
                }
            });

            $.each($('#goods_ending_tbl').find('.variance_shortage_inp'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    variance_shortage += parseFloat($(this).val());
                }
            });

            $.each($('#goods_ending_tbl').find('.variance_overage_inp'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    variance_overage += parseFloat($(this).val());
                }
            });

            $('#info_total_system_count').html(parseFloat(system_count) > 0 ? numformat(parseFloat(system_count).toFixed(2)) : "");
            $('#info_total_physical_count').html(parseFloat(physical_count) > 0 ? numformat(parseFloat(physical_count).toFixed(2)) : "");
            $('#info_total_variance_shortage').html(parseFloat(variance_shortage) > 0 ? numformat(parseFloat(variance_shortage).toFixed(2)) : "");
            $('#info_total_variance_overage').html(parseFloat(variance_overage) > 0 ? numformat(parseFloat(variance_overage).toFixed(2)) : "");
        }

        function physicalCountFn(indx){
            var system_count = $(`#system_count_inp${indx}`).val() || 0;
            var physical_count = $(`#physical_count_inp${indx}`).val() || 0;

            var variance = parseFloat(physical_count) - parseFloat(system_count);

            $(`#variance_shortage${indx}`).html("");
            $(`#variance_shortage_inp${indx}`).val("");
            $(`#variance_overage${indx}`).html("");
            $(`#variance_overage_inp${indx}`).val("");

            if(parseFloat(variance) > 0){
                $(`#variance_overage_inp${indx}`).val(parseFloat(variance) > 0 ? parseFloat(variance).toFixed(2) : 0);
                $(`#variance_overage${indx}`).html(parseFloat(variance) > 0 ? parseFloat(variance).toFixed(2) : "");
            }
            if(parseFloat(variance) < 0){
                variance = Math.abs(variance);
                $(`#variance_shortage_inp${indx}`).val(parseFloat(variance) > 0 ? parseFloat(variance).toFixed(2) : 0);
                $(`#variance_shortage${indx}`).html(parseFloat(variance) > 0 ? parseFloat(variance).toFixed(2) : "");
            }
            $(`#physical_count_inp${indx}`).css("background", "#FFFFFF");

            CalcGoodsGrandTotal();
        }

        $('#saveendingbutton').click(function(){
            var registerForm = $('#EndingForm');
            var formData = registerForm.serialize();
            $.ajax({ 
                url: '/saveCommEnding',
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
                    $('#saveendingbutton').text('Saving...');
                    $('#saveendingbutton').prop("disabled", true);
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
                    if(data.errorv2){
                        if(data.type == 1){
                            $('#endingtbl > tbody > tr').each(function () {
                                let num_of_bag = $(this).find('.num_of_bag').val();
                                let total_kg = $(this).find('.total_kg').val();
                                let unit_cost = $(this).find('.unit_cost').val();

                                let rowind = $(this).find('.endvals').val();

                                if(num_of_bag != undefined){
                                    if(isNaN(parseFloat(num_of_bag)) || parseFloat(num_of_bag)==0){
                                        $(`#num_of_bag${rowind}`).css("background", errorcolor);
                                    }
                                }
                                if(total_kg != undefined){
                                    if(isNaN(parseFloat(total_kg)) || parseFloat(total_kg)==0){
                                        $(`#total_kg${rowind}`).css("background", errorcolor);
                                    }
                                }
                                if(unit_cost != undefined){
                                    if(isNaN(parseFloat(unit_cost)) || parseFloat(unit_cost)==0){
                                        $(`#unit_cost${rowind}`).css("background", errorcolor);
                                    }
                                }
                            });
                        }
                        else if(data.type == 2){
                            $('#goods_ending_tbl > tbody > tr').each(function () { 
                                let physical_count = $(this).find('.physical_count_inp').val();
                                let rowind = $(this).find('.goods_ending_val').val();

                                if(physical_count != undefined){
                                    if(isNaN(parseFloat(physical_count)) || parseFloat(physical_count)==0){
                                        $(`#physical_count_inp${rowind}`).css("background", errorcolor);
                                    }
                                }
                            });
                        }

                        $('#saveendingbutton').text('Save');
                        $('#saveendingbutton').prop("disabled", false);
                        toastrMessage('error',"Please insert valid data on highlighted fields!","Error");
                    }
                    else if (data.dberrors) {
                        $('#saveendingbutton').text('Save');
                        $('#saveendingbutton').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#saveendingbutton').text('Save');
                        $('#saveendingbutton').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $("#manageendingmodal").modal('hide');
                    }
                }
            });
        });

        function commEndingInfoFn(recordId) { 
            var lidata = "";
            var forecolor = "";
            var product_type = "";
            $("#end_customerinfotbl").hide();
            $(".actionpropbtn").hide();
            $(".ending_info_datatable").hide();
            $.ajax({
                url: '/showCommEnd'+'/'+recordId,
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
                success: function(data) {
                    product_type = data.type;
                    $.each(data.commenddata, function(key, value) {
                        $("#end_infobeginningdocnum").html(value.DocumentNumber);
                        $("#end_infostorename").html(value.StoreName);
                        $("#end_infocustomercode").html(value.CustomerCode);
                        $("#end_infocustomername").html(value.CustomerName);
                        $("#end_infocustomertin").html(value.TinNumber);
                        $("#end_infocustomerphone").html(value.PhoneNumber+"   ,   "+value.OfficePhone);
                        $("#end_infocustomeremail").html(value.EmailAddress);
                        $("#end_infofiscalyear").html(value.Monthrange);

                        $("#currentStatus").val(value.status);
                        $("#endingRecId").val(value.eid);
                                                
                        if(parseInt(value.customers_id)==1){
                            $("#end_customerinfotbl").hide();
                            $("#customerOrOwnerName").val("Owner");
                        }
                        else if(parseInt(value.customers_id)>1){
                            $("#end_customerinfotbl").show();
                            $("#customerOrOwnerName").val(value.CustomerName);
                        }

                        if(value.status == "Draft"){
                            $("#changetopending").show();
                            forecolor = "#82868b";
                        }
                        else if(value.status == "Pending"){
                            $("#backtodraft").show();
                            $("#verifybtn_end").show();
                            forecolor = "#ff9f43";
                        }
                        else if(value.status == "Verified"){
                            $("#approvebtn").show();
                            $("#backtopending").show();
                            $("#rejectbtn").show();
                            forecolor = "#7367f0";
                        }
                        else if(value.status == "Approved"){
                            $("#backtoverify").show();
                            forecolor = "#28c76f";
                        }
                        else if(value.status == "Rejected"){
                            $("#approvebtn").show();
                            forecolor = "#ea5455";
                        }
                        else if(value.status == "Void" || value.status == "Void(Draft)" || value.status == "Void(Pending)" || value.status == "Void(Verified)" || value.status == "Void(Approved)"){
                            $(".actionpropbtn").hide();
                            forecolor = "#ea5455";
                        }
                        else{
                            $(".actionpropbtn").hide();
                            forecolor = "#ea5455";
                        }
                        $("#endingstatus_title").html(`<span style='color:${forecolor};font-weight:bold;font-size:16px;text-align:right;'>${value.document_number}, ${value.status}</span>`);


                        // $("#customer_owner_id").val(value.customers_id);
                        // $("#store_id").val(value.stores_id);
                        // $("#fiscal_year").val(value.FiscalYear);           
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited" || value.action == "Change to Pending"){
                            classes="warning";
                        }
                        else if(value.action == "Verified"){
                            classes="primary";
                        }
                        else if(value.action == "Created" || value.action == "Back to Draft" || value.action == "Back to Pending" || value.action == "Back to Verify" || value.action == "Undo Void"){
                            classes="secondary";
                        }
                        else if(value.action == "Approved"){
                            classes="success";
                        }
                        else if(value.action == "Void" || value.action=="Void(Draft)" || value.action=="Void(Pending)" || value.action=="Void(Verified)" || value.action=="Void(Approved)" || value.action=="Rejected"){
                            classes="danger";
                        }

                        if(value.reason!=null && value.reason!=""){
                            reasonbody='</br><span class="text-muted"><b>Reason:</b> '+value.reason+'</span>';
                        }
                        else{
                            reasonbody="";
                        }
                        lidata+=`<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span>${reasonbody}</br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#ending_actiondiv").empty();
                    $('#ending_actiondiv').append(lidata);

                    if(product_type == 1){
                        fetchCommEndingData(recordId);
                    }
                    else if(product_type == 2){
                        fetchGoodsEndingData(recordId);
                    }
                }
            });
        }

        function fetchCommEndingData(recordId){
            var beg_id="";
            $('#comm_ending_div').hide();
            $('#endinginfo_tbl').DataTable({
                destroy: true,
                processing: false,
                serverSide: true,
                searching: true,
                info: true,
                fixedHeader: true,
                paging: true,
                searchHighlight: true,
                responsive:true,
                autoWidth: false,
                deferRender: true,
                "lengthMenu": [[200, 100, 50], [200, 100, 50]],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showCommEnding')}}",
                    type: 'POST',
                    data:{
                        beg_id: recordId,
                    },
                    dataType: "json",
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                    },
                    {
                        data: 'FloorMap',
                        name: 'FloorMap'
                    },
                    {
                        data: 'CommodityType',
                        name: 'CommodityType'
                    },
                    {
                        data: 'Supplier',
                        name: 'Supplier'
                    },
                    {
                        data: 'GrnNumber',
                        name: 'GrnNumber'
                    },
                    {
                        data: 'ProductionNumber',
                        name: 'ProductionNumber'
                    },
                    {
                        data: 'CertNumber',
                        name: 'CertNumber'
                    },
                    {
                        data: 'Commodity',
                        name: 'Commodity'
                    },
                    {
                        data: 'Grade',
                        name: 'Grade'
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType'
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear'
                    },
                    {
                        data: 'UomName',
                        name: 'UomName'
                    },

                    {
                        data: 'available_bag',
                        name: 'available_bag',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'available_bagweight',
                        name: 'available_bagweight',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'available_net_kg',
                        name: 'available_net_kg',
                        "render": function (data, type, row, meta) {
                            var total_kg = parseFloat(data) + parseFloat(row.bag_weight);
                            return numformat(parseFloat(total_kg).toFixed(2));
                        },
                    },
                    {
                        data: 'available_net_kg',
                        name: 'available_net_kg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'variance_shortage',
                        name: 'variance_shortage',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'variance_overage',
                        name: 'variance_overage',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },

                    {
                        data: 'no_of_bag',
                        name: 'no_of_bag',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'bag_weight',
                        name: 'bag_weight',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'disc_shortage_bag',
                        name: 'disc_shortage_bag',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'disc_overage_bag',
                        name: 'disc_overage_bag',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total_kg',
                        name: 'total_kg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'net_kg',
                        name: 'net_kg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'feresula',
                        name: 'feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'net_kg',
                        name: 'net_kg',
                        "render": function (data, type, row, meta) {
                            var net_kg = parseFloat(data) / 1000;
                            return numformat(parseFloat(net_kg).toFixed(2));
                        },
                    },
                    {
                        data: 'disc_shortage_kg',
                        name: 'disc_shortage_kg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'disc_overage_kg',
                        name: 'disc_overage_kg',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'unit_cost',
                        name: 'unit_cost',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total_cost',
                        name: 'total_cost',
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var av_total_bag = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var av_total_bagweight = api
                    .column(13)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var av_totalkg_data = api
                    .column(14)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );  

                    var av_netkg = api
                        .column(15)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var av_totalkg = parseFloat(av_netkg) + parseFloat(av_total_bagweight);

                    //var av_netkg = parseFloat(av_totalkg) - parseFloat(av_total_bagweight);

                    var av_total_variance_shortage = api
                    .column(16)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var av_total_variance_overage = api
                    .column(17)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_bag = api
                    .column(18)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_bagweight = api
                    .column(19)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_disc_shortage_bag = api
                    .column(20)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_disc_overage_bag = api
                    .column(21)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_kg = api
                    .column(22)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_netkg = api
                    .column(23)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_feresula = parseFloat(total_netkg) / 17;

                    var total_ton = parseFloat(total_netkg) / 1000;

                    var total_disc_shortage_kg = api
                    .column(26)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_disc_overage_kg = api
                    .column(27)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_cost = api
                    .column(29)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#end_totalbag').html(av_total_bag === 0 ? '' : numformat(parseFloat(av_total_bag.toFixed(2))));
                    $('#end_totalbagweight').html(av_total_bagweight === 0 ? '' : numformat(parseFloat(av_total_bagweight.toFixed(2))));
                    $('#end_totalkg').html(av_totalkg === 0 ? '' : numformat(parseFloat(av_totalkg.toFixed(2))));
                    $('#end_totalnetkg').html(av_netkg === 0 ? '' : numformat(parseFloat(av_netkg.toFixed(2))));
                    $('#end_total_shortage_variance').html(av_total_variance_shortage === 0 ? '' : numformat(parseFloat(av_total_variance_shortage.toFixed(2))));
                    $('#end_total_overage_variance').html(av_total_variance_overage === 0 ? '' : numformat(parseFloat(av_total_variance_overage.toFixed(2))));
                    
                    $('#end_totalbag_pc').html(total_bag === 0 ? '' : numformat(parseFloat(total_bag.toFixed(2))));
                    $('#end_totalbagweight_pc').html(total_bagweight === 0 ? '' : numformat(parseFloat(total_bagweight.toFixed(2))));
                    $('#end_totaldisc_shortage_bag').html(total_disc_shortage_bag === 0 ? '' : numformat(parseFloat(total_disc_shortage_bag.toFixed(2))));
                    $('#end_totaldisc_overage_bag').html(total_disc_overage_bag === 0 ? '' : numformat(parseFloat(total_disc_overage_bag.toFixed(2))));
                    $('#end_totakg_pc').html(total_kg === 0 ? '' : numformat(parseFloat(total_kg.toFixed(2))));
                    $('#end_totalnetkg_pc').html(total_netkg === 0 ? '' : numformat(parseFloat(total_netkg.toFixed(2))));
                    $('#end_totalferesula_pc').html(total_feresula === 0 ? '' : numformat(parseFloat(total_feresula.toFixed(2))));
                    $('#end_totalton_pc').html(total_ton === 0 ? '' : numformat(parseFloat(total_ton.toFixed(2))));
                    $('#end_totaldisc_shortage_kg').html(total_disc_shortage_kg === 0 ? '' : numformat(parseFloat(total_disc_shortage_kg.toFixed(2))));
                    $('#end_totaldisc_overage_kg').html(total_disc_overage_kg === 0 ? '' : numformat(parseFloat(total_disc_overage_kg.toFixed(2))));
                    $('#end_totalcost').html(total_cost === 0 ? '' : numformat(parseFloat(total_cost.toFixed(2))));
                },
                drawCallback: function(settings) {
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

                    $('#ending_commodity_info').show();
                    $(".infoending").collapse('show');
                    $("#ending_informationmodal").modal('show');
                }
            });
        }

        function fetchGoodsEndingData(recordId){
            var beg_id="";
            $('#goods_endinginfo_tbl').DataTable({
                destroy: true,
                processing: false,
                serverSide: true,
                searching: true,
                info: true,
                fixedHeader: true,
                paging: true,
                searchHighlight: true,
                responsive:true,
                autoWidth: false,
                deferRender: true,
                "lengthMenu": [[200, 100, 50], [200, 100, 50]],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{url('showCommEnding')}}",
                    type: 'POST',
                    data:{
                        beg_id: recordId,
                    },
                    dataType: "json",
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'location_name',
                        name: 'location_name',
                        width:"10%"
                    },
                    {
                        data: 'item_name',
                        name: 'item_name',
                        width:"17%"
                    },
                    {
                        data: 'uom_name',
                        name: 'uom_name',
                        width:"10%"
                    },
                    {
                        data: 'system_count',
                        name: 'system_count',
                        width:"10%",
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        width:"10%"
                    },
                    {
                        data: 'unit_cost',
                        name: 'unit_cost',
                        width:"10%",
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'total_cost',
                        name: 'total_cost',
                        width:"10%",
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'variance_shortage',
                        name: 'variance_shortage',
                        width:"10%",
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    },
                    {
                        data: 'variance_overage',
                        name: 'variance_overage',
                        width:"10%",
                        render: $.fn.dataTable.render.number(',', '.', 2, '')
                    }
                ],
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(),data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var total_system_count = api
                    .column(4)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_physical_count = api
                    .column(5)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_cost = api
                    .column(7)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                    var total_variance_shortage = api
                        .column(8)
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    var total_variance_overage = api
                    .column(9)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                    $('#goods_total_system_count').html(total_system_count === 0 ? '' : numformat(parseFloat(total_system_count.toFixed(2))));
                    $('#goods_total_physical_count').html(total_physical_count === 0 ? '' : numformat(parseFloat(total_physical_count.toFixed(2))));
                    $('#goods_total_cost_data').html(total_cost === 0 ? '' : numformat(parseFloat(total_cost.toFixed(2))));
                    $('#goods_total_variance_shortage').html(total_variance_shortage === 0 ? '' : numformat(parseFloat(total_variance_shortage.toFixed(2))));
                    $('#goods_total_variance_overage').html(total_variance_overage === 0 ? '' : numformat(parseFloat(total_variance_overage.toFixed(2))));
                },
                drawCallback: function(settings) {
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

                    $("#ending_goods_info").show();
                    $(".infoending").collapse('show');
                    $("#ending_informationmodal").modal('show');
                }
            });
        }

        function forwardActionFn() {
            const requestId = $('#endingRecId').val();
            const currentStatus = $('#currentStatus').val();
            const transition = statusTransitions[currentStatus].forward;

            $('#forwardReqId').val(requestId);
            $('#newForwardStatusValue').val(transition.status);
            $('#forwardActionLabel').html(transition.message);
            $('#forwarkBtnTextValue').val(transition.text);
            $('#forwardActionBtn').text(transition.text);
            $('#forwardActionValue').val(transition.action);
            $("#modalBodyId").css({"background-color":transition.backcolor});
            $("#forwardActionLabel").css({'color':transition.forecolor});
            $('#forwardActionModal').modal('show');
        }

        $('.backwardbtn').click(function(){
            const requestId = $('#endingRecId').val();
            const currentStatus = $('#currentStatus').val();

            const transition = $(this).attr('id') == "rejectbtn" ? statusTransitions[currentStatus].reject : statusTransitions[currentStatus].backward;

            $('#backwardReqId').val(requestId);
            $('#newBackwardStatusValue').val(transition.status);
            $('#backwardActionLabel').html(transition.message);
            $('#backwardBtnTextValue').val(transition.text);
            $('#backwardActionBtn').text(transition.text);
            $('#backwardActionValue').val(transition.action);
            $('#CommentOrReason').val("");
            $('#commentres-error').html("");
            $('#backwardActionModal').modal('show');
        });

        $('#forwardActionBtn').click(function() {
            var forwardForm = $("#forwardActionForm");
            var formData = forwardForm.serialize();
            var btntxt = $('#forwarkBtnTextValue').val();
            $.ajax({
                url: '/endingForwardAction',
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
                    $('#forwardActionBtn').text('Changing...');
                    $('#forwardActionBtn').prop("disabled", true);
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
                    $('#forwardActionBtn').text(btntxt);
                    $('#forwardActionBtn').prop("disabled",false);
                },
                success: function(data) {
                    if(data.receiving_error){
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"There are incomplete records in the receiving page. Please ensure all records are completed.","Error");
                    }
                    else if(data.requisition_error){
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"There are incomplete records in the requisition page. Please ensure all records are completed.","Error");
                    }
                    else if(data.production_error){
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"There are incomplete records in the production page. Please ensure all records are completed.","Error");
                    }
                    else if(data.discrepancy_error){
                        var commodity_lbl = "";
                        $.each(data.discrepancy_error_list, function(key, value) {
                            commodity_lbl += `${++key}) ${value.CommodityType}, ${value.Commodity}, ${value.Grade}, ${value.CropYear}, ${value.ProcessType}  |   ${value.Supplier}, ${value.GrnNumber}, ${value.ProductionNumber}, ${value.CertNumber}, ${value.FloorMap}`;
                        });
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"A discrepancy has been detected in the Ending Form. Please review and ensure all entries are free from discrepancy.","Error");
                    }
                    else if(data.unit_cost_error){
                        var commodity_lbl = "";
                        $.each(data.unit_cost_error_list, function(key, value) {
                            commodity_lbl += `${++key}) ${value.CommodityType}, ${value.Commodity}, ${value.Grade}, ${value.CropYear}, ${value.ProcessType}  |   ${value.Supplier}, ${value.GrnNumber}, ${value.ProductionNumber}, ${value.CertNumber}, ${value.FloorMap}`;
                        });
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"Please enter a value for all empty Unit Cost fields before proceeding.","Error");
                    }
                    else if(data.fiscalyear_error){
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"Please change fiscal year before proceeding.","Error");
                    }
                    else if (data.dberrors) {
                        $('#forwardActionBtn').text(btntxt);
                        $('#forwardActionBtn').prop("disabled",false);
                        $("#forwardActionModal").modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if (data.success) {
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#forwardActionModal").modal('hide');
                        $("#ending_informationmodal").modal('hide');
                        $("#manageendingmodal").modal('hide');
                    }
                }
            });
        });

        $("#backwardActionBtn").click(function() {
            var registerForm = $("#backwardActionForm");
            var formData = registerForm.serialize();
            var btntxt = $('#backwardBtnTextValue').val();

            $.ajax({
                url: '/endingBackwardAction',
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

                    $('#backwardActionBtn').text('Changing...');
                    $('#backwardActionBtn').prop("disabled", true);
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
                    $('#backwardActionBtn').text(btntxt);
                    $('#backwardActionBtn').prop("disabled", false);
                },

                success: function(data) {
                    if (data.errors) {
                        if (data.errors.CommentOrReason) {
                            $('#commentres-error').html(data.errors.CommentOrReason[0]);
                        }
                        $('#backwardActionBtn').text(btntxt);
                        $('#backwardActionBtn').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backwardActionBtn').text(btntxt);
                        $('#backwardActionBtn').prop("disabled",false);
                        $('#backwardActionModal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $('#backwardActionModal').modal('hide');
                        $("#ending_informationmodal").modal('hide');
                        $("#manageendingmodal").modal('hide');
                    }
                }
            });
        });

        function commentValFn() {
            $('#commentres-error').html("");
        }
        //-----------End Ending--------------

        function customerFn() {
            $('#customer-error').html('');
        }

        function remarkFn() {
            $('#remark-error').html('');
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

        function tableReloadFn(flg) {
            // var oTable = $('#laravel-datatable-crud').dataTable(); 
            // oTable.fnDraw(false);

            // var iTable = $('#customersdatatable').dataTable(); 
            // iTable.fnDraw(false);
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

    </script>
@endsection
