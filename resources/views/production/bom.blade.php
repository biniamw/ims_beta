@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('BOM-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Bill of Material (BOM)</h3>
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;" style="display: none;" id="main-datatable">
                                <div>
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:24%;">BOM Number</th>
                                                <th style="width:23%;">BOM Type</th>
                                                <th style="width:23%;">BOM Name</th>
                                                <th style="width:23%;">Status</th>
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
        </section>
    </div>
    @endcan

    <!--Start BOM regiseration Modal -->
    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add BOM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row mt-1">
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="type" id="type" onchange="typeFn()">
                                    <option value="1">Commodity</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="type-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Name</label><label style="color: red; font-size:16px;">*</label>
                                <input type="text" placeholder="BOM Name" class="form-control mainforminp" name="BomName" id="BomName" onkeyup="bomNameFn()"/>
                                <span class="text-danger">
                                    <strong id="name-error" class="errordatalabel"></strong>
                                </span>
                            </div>    
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control mainforminp" rows="2" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                <span class="text-danger">
                                    <strong id="description-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Status</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="status" id="status" onchange="statusFn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="status-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End BOM regiseration Modal -->

    <!--Start BOM Datatable Modal -->
    <div class="modal fade text-left" id="bomdatatablemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Manage Child BOM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="BomDatatable">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row mt-1">
                            <div class="col-xl-10 col-md-10 col-sm-10">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 8%;"><label style="font-size: 14px;">BOM Number</label></td>
                                        <td style="width: 92%;"><label id="bomnumberdt" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">BOM Type</label></td>
                                        <td><label id="bomtypedt" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">BOM Name</label></td>
                                        <td><label id="bomnamedt" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Description</label></td>
                                        <td><label id="bomdescriptiondt" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                    <tr>
                                        <td><label style="font-size: 14px;">Status</label></td>
                                        <td><label id="bomstatusdt" style="font-size: 14px;font-weight:bold;"></label></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-2 col-md-2 col-sm-2" style="text-align: right;">
                                
                            </div>
                        </div>
                        <hr class="m-0"/>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 mb-1" style="display: none;" id="child_bom_dt">
                                <table id="bomchildtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width:3%;">#</th>
                                            <th style="width:32%;">Child BOM Name</th>
                                            <th style="width:31%;">Total Cost</th>
                                            <th style="width:30%;">Status</th>
                                            <th style="width:4%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table table-sm"></tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="dtRecId" id="dtRecId" readonly="true" value=""/> 
                        <button id="closebuttondt" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End BOM Datatable Modal -->

    <!--Start BOM child Modal -->
    <div class="modal fade text-left" id="inlineFormChild" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitlech">Add BOM</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="ChildForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row mt-1">
                            <div class="col-xl-4 col-md-4 col-sm-12">
                                <label style="font-size: 14px;">Child BOM Name</label><label style="color: red; font-size:16px;">*</label>
                                <input type="text" placeholder="Child BOM Name" class="form-control mainforminp" name="BomChildName" id="BomChildName" onkeyup="chBomNameFn()" readonly style="font-weight: bold;"/>
                                <span class="text-danger">
                                    <strong id="chname-error" class="errordatalabel"></strong>
                                </span>
                            </div>    
                            <div class="col-xl-3 col-md-3 col-sm-12">
                                <label style="font-size: 14px;">Description</label>
                                <textarea type="text" placeholder="Write Description here..." class="form-control mainforminp" rows="2" name="DescriptionChild" id="DescriptionChild" onkeyup="chDescriptionfn()"></textarea>
                                <span class="text-danger">
                                    <strong id="chdescription-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-2 col-sm-12">
                                <label style="font-size: 14px;">Status</label><label style="color: rgb(255, 0, 0); font-size:16px;">*</label>
                                <select class="select2 form-control" name="statusChild" id="statusChild" onchange="chStatusFn()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="chstatus-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-12">
                                <div class="card">
                                    <div class="card-header" style="background-color: hsl(47,83%,91%);height:0.5rem;border: 0.5px solid hsl(47,65%,84%);position:relative;">
                                        <div class="card-title">
                                            <p style="margin-top:-10px;margin-left:-15px;">
                                                <label id="bomparentlbl" style="font-size: 13px;font-weight:bold;">Parent BOM Information</label>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card-body" id="infoCardDiv" style="background-color: hsl(47,87%,94%);border: 0.5px solid hsl(47,65%,84%);">
                                        <div style="text-align: left;">
                                            <table style="width: 100%;margin-left:-15px;margin-top:5px;">
                                                <tr>
                                                    <td style="width: 27%;"><label style="font-size: 12px;">BOM #</label></td>
                                                    <td style="width: 73%;"><label id="bomnumberform" style="font-size: 12px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 12px;">BOM Type</label></td>
                                                    <td><label id="bomtypeform" style="font-size: 12px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 12px;">BOM Name</label></td>
                                                    <td><label id="bomnameform" style="font-size: 12px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 12px;">Description</label></td>
                                                    <td><label id="bomdescriptionform" style="font-size: 12px;font-weight:bold;"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 12px;">Status</label></td>
                                                    <td><label id="bomstatusform" style="font-size: 12px;font-weight:bold;"></label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider" style="margin-top: -1.2rem;">
                            <div class="divider-text">-</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:16%">Region, Zone, Woreda</th>
                                                <th style="width:8%">Grade</th>
                                                <th style="width:10%">Process Type</th>
                                                <th style="width:9%">Crop Year</th>
                                                <th style="width:8%">UOM</th>
                                                <th style="width:10%">Quantity</th>
                                                <th style="width:10%">Unit Cost</th>
                                                <th style="width:10%">Total Cost</th>
                                                <th style="width:13%">Remark</th>
                                                <th style="width:3%"></th>
                                            </tr>
                                        <thead>
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
                                            <tr>
                                                <td style="text-align: right;width:45%">
                                                    <label id="totalcostlbl" style="font-size: 14px;">Total Cost</label>
                                                </td>
                                                <td style="text-align: center; width:55%">
                                                    <label id="totalcostvalLbl" class="formattedNum" strong style="font-size: 14px; font-weight: bold;"></label>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="uomdefault" id="uomdefault">
                                @foreach ($uomdata as $uomdata)
                                    <option value="{{ $uomdata->id }}">{{ $uomdata->Name }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="origindefault" id="origindefault">
                                <option selected disabled value=""></option>
                                @foreach ($origin as $origin)
                                    <option title="{{$origin->CommType}}" value="{{ $origin->id }}">{{ $origin->Origin }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="parentRecId" id="parentRecId" readonly="true" value=""/> 
                        <input type="hidden" class="form-control" name="recChildId" id="recChildId" readonly="true" value=""/>    
                        <input type="hidden" class="form-control" name="operationtypesch" id="operationtypesch" readonly="true"/>
                        <button id="savebuttonch" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttonch" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End BOM child Modal -->

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Bill of Material (BOM) Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <section id="collapsible">
                                    <div class="card collapse-icon">
                                        <div class="collapse-default">
                                            <div class="card">
                                                <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                    <span class="lead collapse-title">Basic & Action Information</span>
                                                    <div id="statustitlesA"></div>
                                                </div>
                                                <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Basic Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <table style="width: 100%;">
                                                                            <tr>
                                                                                <td style="width: 20%;"><label style="font-size: 14px;">BOM Number</label></td>
                                                                                <td style="width: 80%;"><label id="bomnumberinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label style="font-size: 14px;">BOM Type</label></td>
                                                                                <td><label id="bomtypeinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label style="font-size: 14px;">BOM Name</label></td>
                                                                                <td><label id="bomnameinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label style="font-size: 14px;">Description</label></td>
                                                                                <td><label id="bomdescriptioninfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label style="font-size: 14px;">Status</label></td>
                                                                                <td><label id="bomstatusinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">Action Information</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:9rem">
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
                        <hr class="m-0"/>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display: none;" id="bom_info_dt"> 
                                <table id="bomdetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="width:3%;">#</th>
                                            <th style="width:10%">Child BOM</th>
                                            <th style="width:13%">Region, Zone, Woreda</th>
                                            <th style="width:8%">Grade</th>
                                            <th style="width:9%">Process Type</th>
                                            <th style="width:9%">Crop Year</th>
                                            <th style="width:8%">UOM</th>
                                            <th style="width:9%">Quantity</th>
                                            <th style="width:9%">Unit Cost</th>
                                            <th style="width:9%">Total Cost</th>
                                            <th style="width:13%">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table table-sm"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="recInfoId" id="recInfoId" readonly="true" value=""/> 
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <!--Start Information Modal -->
    <div class="modal fade" id="bomchildinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Bill of Material (BOM) Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="ChildBomInformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <div class="table-responsive">
                                        <section id="collapsible">
                                            <div class="card collapse-icon">
                                                <div class="collapse-default">
                                                    <div class="card">
                                                        <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                            <span class="lead collapse-title">Child BOM Basic & Action Information</span>
                                                            <div id="statustitles"></div>
                                                        </div>
                                                        <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-4 col-md-4 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Parent BOM Information</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <td style="width: 20%;"><label style="font-size: 14px;">BOM #</label></td>
                                                                                        <td style="width: 80%;"><label id="bomnumbersecinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">BOM Type</label></td>
                                                                                        <td><label id="bomtypesecinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">BOM Name</label></td>
                                                                                        <td><label id="bomnamesecinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Description</label></td>
                                                                                        <td><label id="bomdescriptionsecinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Status</label></td>
                                                                                        <td><label id="bomstatusecinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Child BOM Information</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <table style="width: 100%;">
                                                                                    <tr>
                                                                                        <td style="width: 20%;"><label style="font-size: 14px;">BOM Name</label></td>
                                                                                        <td style="width: 80%;"><label id="childbomnameinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Description</label></td>
                                                                                        <td><label id="childbomdescinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label style="font-size: 14px;">Status</label></td>
                                                                                        <td><label id="childbomstatusinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4 col-md-4 col-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h6 class="card-title">Action Information</h6>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:15rem">
                                                                                        <ul id="childactiondiv" class="timeline mb-0 mt-0"></ul>
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
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-lg-12">
                                    <div class="divider">
                                        <div class="divider-text">Detail Information</div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-lg-12">
                                            <table id="childbomdetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:16%">Region, Zone, Woreda</th>
                                                        <th style="width:8%">Grade</th>
                                                        <th style="width:10%">Process Type</th>
                                                        <th style="width:9%">Crop Year</th>
                                                        <th style="width:8%">UOM</th>
                                                        <th style="width:10%">Quantity</th>
                                                        <th style="width:10%">Unit Cost</th>
                                                        <th style="width:10%">Total Cost</th>
                                                        <th style="width:16%">Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <th colspan="8" style="text-align: right;">
                                                        Total Cost
                                                    </th>
                                                    <th colspan="2" style="text-align: left;" class="totalvaluedata"></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="chRecInfoId" id="chRecInfoId" readonly="true" value=""/> 
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->


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
                        <label style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this BOM?</label>
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

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var j=0;
        var i=0;
        var m=0;

        $(document).ready( function () {
            $("#main-datatable").hide();
            var ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/bomlist',
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
                    { data:'DT_RowIndex',width:"3%"},
                    { data: 'BomNumber', name: 'BomNumber',width:"24%"},
                    { data: 'BomType', name: 'BomType',width:"23%"},
                    { data: 'BomName', name: 'BomName',width:"23%"},
                    { data: 'Status', name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Inactive"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                        },
                        width:"23%"},
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        @can('BOM-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addbom" id="addbom" data-toggle="modal">Add</button>
                        @endcan
                    `);
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
                    $("#main-datatable").show();
                },
            });
        });

        $('body').on('click', '#addbom', function() {
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#type').val(1);
            $('#type').select2({
                minimumResultsForSearch: -1
            });
            $('#status').val("Active");
            $('#status').select2({
                minimumResultsForSearch: -1
            });
            $('#recId').val("");
            $('#dynamicTable > tbody').empty();
            $('#pricingTable').hide();
            $('#operationtypes').val("1");
            $("#modaltitle").html("Add BOM");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });
       
        $("#adds").click(function() {
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var commtype=$('#CommType'+lastrowcount).val();
            var origin=$('#Origin'+lastrowcount).val();
            var grade=$('#Grade'+lastrowcount).val();
            var processtype=$('#ProcessType'+lastrowcount).val();
            var cropyear=$('#CropYear'+lastrowcount).val();
            if((commtype!==undefined && isNaN(parseFloat(commtype))) || (origin!==undefined && isNaN(parseFloat(origin))) || (grade!==undefined && isNaN(parseFloat(grade))) || (processtype!==undefined && processtype=="") || (cropyear!==undefined && isNaN(parseFloat(cropyear)))){
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
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i;
                ++m;
                ++j;
                $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="width:16%;"><select id="Origin'+m+'" class="select2 form-control form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select></td>'+
                    '<td style="width:8%;"><select id="Grade'+m+'" class="select2 form-control form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select></td>'+
                    '<td style="width:10%;"><select id="ProcessType'+m+'" class="select2 form-control form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select></td>'+
                    '<td style="width:9%;"><select id="CropYear'+m+'" class="select2 form-control form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select></td>'+
                    '<td style="width:8%;"><select id="Uom'+m+'" class="select2 form-control form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][Quantity]" placeholder="Write Quantity here..." id="Quantity'+m+'" class="Quantity form-control numeral-mask commnuminp" onkeyup="QuantityFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" class="UnitPrice form-control numeral-mask commnuminp" onkeyup="UnitCostFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" class="TotalPrice form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                    '<td style="width:13%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" placeholder="Write Remark here..."/></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td></tr>'
                );
                var defaultoption = '<option selected value=""></option>';
                var originoptions = $("#origindefault > option").clone();
                $('#Origin'+m).append(originoptions);
                $('#Origin'+m).append(defaultoption);
                $('#Origin'+m).select2
                ({
                    placeholder: "Select Region, Zone, Woreda here",
                    dropdownCssClass : 'commprp',
                });

                var gradeoptions = '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="100">UG (Under Grade)</option><option value="101">NG (No Grade)</option><option value="102">Peaberry Coffee</option>';
                $('#Grade'+m).append(gradeoptions);
                $('#Grade'+m).append(defaultoption);
                $('#Grade'+m).select2
                ({
                    placeholder: "Select Grade here...",
                    dropdownCssClass : 'cusprop',
                });

                var processtypeoptions = '<option value="Anaerobic">Anaerobic</option><option value="UnWashed">UnWashed</option><option value="Washed">Washed</option><option value="Winey">Winey</option>';
                $('#ProcessType'+m).append(processtypeoptions);
                $('#ProcessType'+m).append(defaultoption);
                $('#ProcessType'+m).select2
                ({
                    placeholder: "Select Process type here...",
                    dropdownCssClass : 'cusprop',
                });

                var cropyearoptions = '<option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option>';
                $('#CropYear'+m).append(cropyearoptions);
                $('#CropYear'+m).append(defaultoption);
                $('#CropYear'+m).select2
                ({
                    placeholder: "Select Crop year here...",
                    minimumResultsForSearch: -1
                });

                var uomoptions = $("#uomdefault > option").clone();
                $('#Uom'+m).append(uomoptions);
                $('#Uom'+m).select2
                ({
                    placeholder: "Select UOM here",
                    minimumResultsForSearch: -1
                });
                
                $('#TotalPrice'+m).prop("readonly",true);
                CalculateGrandTotal();
                renumberRows();
                $('#select2-Origin'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Grade'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-ProcessType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CropYear'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Uom'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable tr').each(function(index, el) {
                $(this).children('td').first().text(index++);
                $('#numberofItemsLbl').html(index - 1);
                ind = index - 1;
            });
            if (ind == 0) {
                $('#totalcostvalLbl').html("");
                $('#pricingTable').hide();
            } else {
                $('#pricingTable').show();
            }
        }

        function CalculateGrandTotal() {
            var totalcost = 0;
            $.each($('#dynamicTable').find('.TotalPrice'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalcost += parseFloat($(this).val());
                }
            });
            $('#totalcostvalLbl').html(numformat(totalcost.toFixed(2)));
        }

        function OriginFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var origincnt=0;
            for(var k=1;k<=m;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear))){
                        origincnt+=1;
                    }
                }
            }

            if(parseInt(origincnt)<=1){
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(origincnt)>1){
                $('#Origin'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Region, Zone, Woreda here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Origin is selected with all property","Error");
            }
        }

        function GradeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var gradecnt=0;
            for(var k=1;k<=m;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear))){
                        gradecnt+=1;
                    }
                }
            }

            if(parseInt(gradecnt)<=1){
                $('#select2-Grade'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(gradecnt)>1){
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
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var processtypecnt=0;
            for(var k=1;k<=m;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear))){
                        processtypecnt+=1;
                    }
                }
            }

            if(parseInt(processtypecnt)<=1){
                $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(processtypecnt)>1){
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
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var cropyearcnt=0;
            for(var k=1;k<=m;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear))){
                        cropyearcnt+=1;
                    }
                }
            }

            if(parseInt(cropyearcnt)<=1){
                $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(cropyearcnt)>1){
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
            $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function QuantityFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var quantity=$('#Quantity'+idval).val()||0;
            if(parseFloat(quantity)==0){
                $('#Quantity'+idval).val("");
                toastrMessage('error',"Zero(0) is invalid input","Error");
            }
            else if(parseFloat(quantity)>0){
                $('#Quantity'+idval).css("background","white");

                var unitcost=$('#UnitPrice'+idval).val()||0;
                var quantity=$('#Quantity'+idval).val()||0;

                unitcost = unitcost == '' ? 0 : unitcost;
                quantity = quantity == '' ? 0 : quantity;
                var totalcost=parseFloat(unitcost)*parseFloat(quantity);
                $('#TotalPrice'+idval).val(totalcost.toFixed(2));
                $('#TotalPrice'+idval).css("background","#efefef");
                CalculateGrandTotal();
            }
        }

        function UnitCostFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var unitcost=$('#UnitPrice'+idval).val()||0;
            if(parseFloat(unitcost)==0){
                $('#UnitPrice'+idval).val("");
                toastrMessage('error',"Zero(0) is invalid input","Error");
            }
            else if(parseFloat(unitcost)>0){
                var quantity=$('#Quantity'+idval).val()||0;
                unitcost = unitcost == '' ? 0 : unitcost;
                quantity = quantity == '' ? 0 : quantity;

                var result=parseFloat(unitcost)*parseFloat(quantity);
                $('#TotalPrice'+idval).val(result.toFixed(2));
                $('#UnitPrice'+idval).css("background","white");
                $('#TotalPrice'+idval).css("background","#efefef");
                CalculateGrandTotal();
            }
        }

        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveBom',
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
                statusCode: {
                    401: function() {
                        toastrMessage('error',"Session Expired!","Error");
                        location.reload(false);
                    },
                    503: function(){
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Saving...');
                            $('#savebutton').prop("disabled", true);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Updating...');
                            $('#savebutton').prop("disabled", true);
                        }
                        toastrMessage('error',"Authentication Failed","Error");
                    }
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.type) {
                            $('#type-error').html(data.errors.type[0]);
                        }
                        if (data.errors.BomName) {
                            $('#name-error').html(data.errors.BomName[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
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
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        $('#savebuttonch').click(function() {
            var optype = $("#operationtypesch").val();
            var registerForm = $("#ChildForm");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveChildBom',
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
                        $('#savebuttonch').text('Saving...');
                        $('#savebuttonch').prop("disabled", true);
                    }
                    else if(parseFloat(optype)==2){
                        $('#savebuttonch').text('Updating...');
                        $('#savebuttonch').prop("disabled", true);
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
                statusCode: {
                    401: function() {
                        toastrMessage('error',"Session Expired!","Error");
                        location.reload(false);
                    },
                    503: function(){
                        if(parseFloat(optype)==1){
                            $('#savebuttonch').text('Saving...');
                            $('#savebuttonch').prop("disabled", true);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonch').text('Updating...');
                            $('#savebuttonch').prop("disabled", true);
                        }
                        toastrMessage('error',"Authentication Failed","Error");
                    }
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.BomChildName) {
                            $('#chname-error').html(data.errors.BomChildName[0]);
                        }
                        if (data.errors.DescriptionChild) {
                            $('#chdescription-error').html(data.errors.DescriptionChild[0]);
                        }
                        if (data.errors.statusChild) {
                            $('#chstatus-error').html(data.errors.statusChild[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebuttonch').text('Save');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        if(parseFloat(optype)==2){
                            $('#savebuttonch').text('Update');
                            $('#savebuttonch').prop("disabled", false);
                        }  
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.errorv2) {
                        for(var k=1;k<=m;k++){
                            var origin=$('#Origin'+k).val();
                            var grade=$('#Grade'+k).val();
                            var processtype=$('#ProcessType'+k).val();
                            var cropyear=$('#CropYear'+k).val();

                            var quantity=$('#Quantity'+k).val();
                            var unitcost=$('#UnitPrice'+k).val();
                            var totalprice=$('#TotalPrice'+k).val();

                            if(($('#Origin'+k).val())!=undefined){
                                if(origin==""||origin==null){
                                    $('#select2-Origin'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
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
                            if(($('#Quantity'+k).val())!=undefined){
                                if(quantity==""||quantity==null){
                                    $('#Quantity'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#UnitPrice'+k).val())!=undefined){
                                if(unitcost==""||unitcost==null){
                                    $('#UnitPrice'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#TotalPrice'+k).val())!=undefined){
                                if(totalprice==""||totalprice==null){
                                    $('#TotalPrice'+k).css("background", errorcolor);
                                }
                            }
                        }
                        if(parseFloat(optype)==1){
                            $('#savebuttonch').text('Save');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonch').text('Update');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        toastrMessage('error',"Please insert valid data on highlighted fields","Error");
                    }
                    else if(data.emptyerror)
                    {
                        if(parseFloat(optype)==1){
                            $('#savebuttonch').text('Save');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonch').text('Update');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        toastrMessage('error',"You should add atleast one commodity","Error");
                    } 
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebuttonch').text('Save');
                            $('#savebuttonch').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonch').text('Update');
                            $('#savebuttonch').prop("disabled",false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        if(parseFloat(optype)==1){
                            $('#savebuttonch').text('Save');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebuttonch').text('Update');
                            $('#savebuttonch').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
                        closeRegisterModal();
                        var oTable = $('#bomchildtable').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineFormChild").modal('hide');
                    }
                }
            });
        });

        function bomEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            j=0;
            $.ajax({
                url: '/showBom'+'/'+recordId,
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
                    $.each(data.bomdata, function(key, value) {
                        $('#type').val(value.type).trigger('change').select2();
                        $("#BomName").val(value.BomName);
                        $("#Description").val(value.Description);
                        $('#status').val(value.Status).trigger('change').select2({
                            minimumResultsForSearch: -1
                        });
                    });

                    $.each(data.bomdetaildata, function(key, value) {
                        ++i;
                        ++m;
                        ++j;
                        $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width:16%;"><select id="Origin'+m+'" class="select2 form-control form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select></td>'+
                            '<td style="width:8%;"><select id="Grade'+m+'" class="select2 form-control form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select></td>'+
                            '<td style="width:10%;"><select id="ProcessType'+m+'" class="select2 form-control form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select></td>'+
                            '<td style="width:9%;"><select id="CropYear'+m+'" class="select2 form-control form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select></td>'+
                            '<td style="width:8%;"><select id="Uom'+m+'" class="select2 form-control form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select></td>'+
                            '<td style="width:10%;"><input type="number" name="row['+m+'][Quantity]" placeholder="Write Quantity here..." id="Quantity'+m+'" value="'+value.Quantity+'" class="Quantity form-control numeral-mask commnuminp" onkeyup="QuantityFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                            '<td style="width:10%;"><input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" value="'+value.UnitCost+'" class="UnitPrice form-control numeral-mask commnuminp" onkeyup="UnitCostFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                            '<td style="width:10%;"><input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" value="'+value.TotalCost+'" class="TotalPrice form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                            '<td style="width:13%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" value="'+value.Remark+'" placeholder="Write Remark here..."/></td>'+
                            '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" value="'+value.id+'" style="font-weight:bold;"/></td></tr>'
                        );
                        var commtypename="";
                        var defaultorigindata = '<option selected value='+value.woredas_id+'>'+value.Origin+'</option>';
                        var defaultgradedata = '<option selected value='+value.Grade+'>'+value.Grade+'</option>';
                        var defaultprocesstypedata = '<option selected value='+value.ProcessType+'>'+value.ProcessType+'</option>';
                        var defaultcropyeardata = '<option selected value='+value.CropYear+'>'+value.CropYear+'</option>';
                        var defaultuomdata = '<option selected value='+value.uoms_id+'>'+value.UomName+'</option>';
                        

                        var originoptions = $("#origindefault > option").clone();
                        $('#Origin'+m).append(originoptions);
                        $("#Origin"+m+" option[value='"+value.woredas_id+"']").remove(); 
                        $('#Origin'+m).append(defaultorigindata);
                        $('#Origin'+m).select2
                        ({
                            placeholder: "Select Region, Zone, Woreda here",
                            dropdownCssClass : 'commprp',
                        });

                        var gradeoptions = '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
                        $('#Grade'+m).append(gradeoptions);
                        $("#Grade"+m+" option[value='"+value.Grade+"']").remove(); 
                        $('#Grade'+m).append(defaultgradedata);
                        $('#Grade'+m).select2
                        ({
                            placeholder: "Select Grade here...",
                            minimumResultsForSearch: -1
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

                        var cropyearoptions = '<option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option>';
                        $('#CropYear'+m).append(cropyearoptions);
                        $("#CropYear"+m+" option[value='"+value.CropYear+"']").remove(); 
                        $('#CropYear'+m).append(defaultcropyeardata);
                        $('#CropYear'+m).select2
                        ({
                            placeholder: "Select Crop year here...",
                            minimumResultsForSearch: -1
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

                        $('#Feresula'+m).prop("readonly",true);
                        $('#TotalPrice'+m).prop("readonly",true);
                        $('#select2-Origin'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Grade'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-ProcessType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-CropYear'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Uom'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });
                    CalculateGrandTotal();
                    renumberRows();
                }
            });
            $("#modaltitle").html("Edit BOM");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show'); 
        }

        function chBomEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypesch").val("2");
            $("#recChildId").val(recordId);
            j=0;
            $.ajax({
                url: '/showChBom'+'/'+recordId,
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
                    $.each(data.bomdata, function(key, value) {
                        $("#parentRecId").val(value.prd_boms_id);
                        $("#BomChildName").val(value.BomChildName);
                        $("#DescriptionChild").val(value.Description);
                        $('#statusChild').val(value.Status).trigger('change').select2({
                            minimumResultsForSearch: -1
                        });
                    });

                    $.each(data.bomparentdata, function(key, value) {
                        $("#bomnumberform").html(value.BomNumber);
                        $("#bomtypeform").html(value.BomType);
                        $("#bomnameform").html(value.BomName);
                        $("#bomdescriptionform").html(value.Description);
                        if(value.Status=="Active"){
                            $("#bomstatusform").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                        }
                        if(value.Status=="Inactive"){
                            $("#bomstatusform").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                        }
                    }); 

                    $.each(data.bomdetaildata, function(key, value) {
                        ++i;
                        ++m;
                        ++j;
                        $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                            '<td style="width:16%;"><select id="Origin'+m+'" class="select2 form-control form-control Origin" onchange="OriginFn(this)" name="row['+m+'][Origin]"></select></td>'+
                            '<td style="width:8%;"><select id="Grade'+m+'" class="select2 form-control form-control Grade" onchange="GradeFn(this)" name="row['+m+'][Grade]"></select></td>'+
                            '<td style="width:10%;"><select id="ProcessType'+m+'" class="select2 form-control form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m+'][ProcessType]"></select></td>'+
                            '<td style="width:9%;"><select id="CropYear'+m+'" class="select2 form-control form-control CropYear" onchange="CropYearFn(this)" name="row['+m+'][CropYear]"></select></td>'+
                            '<td style="width:8%;"><select id="Uom'+m+'" class="select2 form-control form-control Uom" onchange="UomFn(this)" name="row['+m+'][Uom]"></select></td>'+
                            '<td style="width:10%;"><input type="number" name="row['+m+'][Quantity]" placeholder="Write Quantity here..." id="Quantity'+m+'" value="'+value.Quantity+'" class="Quantity form-control numeral-mask commnuminp" onkeyup="QuantityFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                            '<td style="width:10%;"><input type="number" name="row['+m+'][UnitPrice]" placeholder="Write Unit cost here..." id="UnitPrice'+m+'" value="'+value.UnitCost+'" class="UnitPrice form-control numeral-mask commnuminp" onkeyup="UnitCostFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                            '<td style="width:10%;"><input type="number" name="row['+m+'][TotalPrice]" placeholder="Write Total cost here..." id="TotalPrice'+m+'" value="'+value.TotalCost+'" class="TotalPrice form-control numeral-mask" onkeypress="return ValidateNum(event);" style="font-weight:bold;" readonly/></td>'+
                            '<td style="width:13%;"><input type="text" name="row['+m+'][Remark]" id="Remark'+m+'" class="Remark form-control" value="'+value.Remark+'" placeholder="Write Remark here..."/></td>'+
                            '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m+'][id]" id="id'+m+'" class="id form-control" readonly="true" value="'+value.id+'" style="font-weight:bold;"/></td></tr>'
                        );
                        var commtypename="";
                        var defaultorigindata = '<option selected value='+value.woredas_id+'>'+value.Origin+'</option>';
                        var defaultgradedata = '<option selected value='+value.Grade+'>'+value.Grade+'</option>';
                        var defaultprocesstypedata = '<option selected value='+value.ProcessType+'>'+value.ProcessType+'</option>';
                        var defaultcropyeardata = '<option selected value='+value.CropYear+'>'+value.CropYear+'</option>';
                        var defaultuomdata = '<option selected value='+value.uoms_id+'>'+value.UomName+'</option>';
                        

                        var originoptions = $("#origindefault > option").clone();
                        $('#Origin'+m).append(originoptions);
                        $("#Origin"+m+" option[value='"+value.woredas_id+"']").remove(); 
                        $('#Origin'+m).append(defaultorigindata);
                        $('#Origin'+m).select2
                        ({
                            placeholder: "Select Region, Zone, Woreda here",
                            dropdownCssClass : 'commprp',
                        });

                        var gradeoptions = '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
                        $('#Grade'+m).append(gradeoptions);
                        $("#Grade"+m+" option[value='"+value.Grade+"']").remove(); 
                        $('#Grade'+m).append(defaultgradedata);
                        $('#Grade'+m).select2
                        ({
                            placeholder: "Select Grade here...",
                            minimumResultsForSearch: -1
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

                        var cropyearoptions = '<option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option>';
                        $('#CropYear'+m).append(cropyearoptions);
                        $("#CropYear"+m+" option[value='"+value.CropYear+"']").remove(); 
                        $('#CropYear'+m).append(defaultcropyeardata);
                        $('#CropYear'+m).select2
                        ({
                            placeholder: "Select Crop year here...",
                            minimumResultsForSearch: -1
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

                        $('#Feresula'+m).prop("readonly",true);
                        $('#TotalPrice'+m).prop("readonly",true);
                        $('#select2-Origin'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Grade'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-ProcessType'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-CropYear'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        $('#select2-Uom'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    });
                    CalculateGrandTotal();
                    renumberRows();
                }
            });
            $("#modaltitlech").html("Edit Child BOM");
            $('#savebuttonch').text('Update');
            $('#savebuttonch').prop("disabled",false);
            $("#inlineFormChild").modal('show'); 
        }

        function bomInfoFn(recordId) { 
            $("#recInfoId").val(recordId);
            $("#bom_info_dt").hide();
            var lidata="";
            $.ajax({
                url: '/showBom'+'/'+recordId,
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
                    $.each(data.bomdata, function(key, value) {
                        $("#bomnumberinfo").html(value.BomNumber);
                        $("#bomtypeinfo").html(value.BomType);
                        $("#bomnameinfo").html(value.BomName);
                        $("#bomdescriptioninfo").html(value.Description);
                        $(".totalvaluedata").html(numformat(value.TotalCost.toFixed(2)));
                        if(value.Status=="Active"){
                            $("#bomstatusinfo").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                        }
                        if(value.Status=="Inactive"){
                            $("#bomstatusinfo").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                        }
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited"){
                            classes="warning";
                        }
                        else if(value.action == "Created"){
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
                }
            });

            $('#bomdetailtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                "order": [
                    [2, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons2'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showBomDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'BomChildName',
                        name: 'BomChildName',
                        width:"10%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"13%"
                    },
                    {
                        data: 'Grade',
                        name: 'Grade',
                        width:"8%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"9%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"9%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"8%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"9%"
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"9%"
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"9%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"13%"
                    },
                ],
                order: [[1, 'asc']],
                rowGroup: {
                    startRender: function ( rows, group,level ) {
                        var color = 'style="color:black;font-weight:bold;background:#f2f3f4;"';
                        if(level===0){
                            return $('<tr style="font-weight:bold" >')
                            .append('<td colspan="11" style="text-align:left;"><b>' + group + ' </b></td></tr>')
                        }                        
                    },
                    endRender: function ( rows, group,level ) {
                        var intVal = function ( i ) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '')*1 :
                                typeof i === 'number' ?
                                        i : 0;
                        };

                        var totalcostdata = rows
                            .data()
                            .pluck('TotalCost')
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                        }, 0);
                        
                        
                        if(level===0){
                            return $('<tr style="font-weight:bold" >')
                                .append('<td colspan="9" style="text-align:right;"><b>Total Cost of: ' + group + ' </b></td>')
                                .append('<td colspan="2" style="text-align:left;">'+ numformat(totalcostdata.toFixed(2))+'</td></tr>');
                        }
                    },
                    dataSrc: ['BomChildName']
                },
                drawCallback: function(settings) {
                    var api = this.api();
                    var currentIndex = 1;
                    var currentGroup = null;
                    api.rows({ page: 'current', search: 'applied' }).every(function() {
                        var rowData = this.data();
                        if (rowData) {
                            var group = rowData['BomChildName']; // Assuming 'group_column' is the name of the column used for grouping
                            if (group !== currentGroup) {
                                currentIndex = 1; // Reset index for a new group
                                currentGroup = group;
                            }
                            $(this.node()).find('td:first').text(currentIndex++);
                        }
                    });
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
                    $("#bom_info_dt").show();
                },
            });
            
            $(".infoscl").collapse('show');
            $("#informationmodal").modal('show');
        }

        function chBomInfoFn(recordId) { 
            $("#chRecInfoId").val(recordId);
            var lidata="";
            $.ajax({
                url: '/showChBom'+'/'+recordId,
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
                    
                    $.each(data.bomparentdata, function(key, value) {
                        $("#bomnumbersecinfo").html(value.BomNumber);
                        $("#bomtypesecinfo").html(value.BomType);
                        $("#bomnamesecinfo").html(value.BomName);
                        $("#bomdescriptionsecinfo").html(value.Description);
                        if(value.Status=="Active"){
                            $("#bomstatusecinfo").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                        }
                        if(value.Status=="Inactive"){
                            $("#bomstatusecinfo").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                        }
                    }); 

                    $.each(data.bomdata, function(key, value) {
                        $("#childbomnameinfo").html(value.BomChildName);
                        $("#childbomdescinfo").html(value.Description);
                        $(".totalvaluedata").html(numformat(value.TotalCost.toFixed(2)));
                        if(value.Status=="Active"){
                            $("#childbomstatusinfo").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                        }
                        if(value.Status=="Inactive"){
                            $("#childbomstatusinfo").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                        }
                    });
                   
                    $.each(data.activitydata, function(key, value) {
                        var classes="";
                        var reasonbody="";
                        if(value.action == "Edited"){
                            classes="warning";
                        }
                        else if(value.action == "Created"){
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
                    $("#childactiondiv").empty();
                    $('#childactiondiv').append(lidata);
                }
            });

            $('#childbomdetailtable').DataTable({
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
                    url: '/showChBomDetail/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"13%"
                    },
                    {
                        data: 'Grade',
                        name: 'Grade',
                        width:"8%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"9%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"8%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"8%"
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"8%"
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"8%"
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"8%"
                    },
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:"8%"
                    },
                ],
            });

            $(".infoscl").collapse('show');
            $("#bomchildinfomodal").modal('show'); 
        }

        function bomAddFn(recordId) { 
            $("#dtRecId").val(recordId);
            $("#child_bom_dt").hide();
            $.ajax({
                url: '/showBom'+'/'+recordId,
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
                    $.each(data.bomdata, function(key, value) {
                        $("#bomnumberdt").html(value.BomNumber);
                        $("#bomtypedt").html(value.BomType);
                        $("#bomnamedt").html(value.BomName);
                        $("#bomdescriptiondt").html(value.Description);
                        if(value.Status=="Active"){
                            $("#bomstatusdt").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                        }
                        if(value.Status=="Inactive"){
                            $("#bomstatusdt").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                        }
                    }); 
                }
            });

            $('#bomchildtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons2'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",

                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/showChildBom/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'BomChildName',
                        name: 'BomChildName',
                        width:"32%"
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"31%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else if(data == "Inactive"){
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-warning bg-glow">${data}</span>`;
                            }
                        },
                        width:"30%"
                    },
                    { data: 'action', name: 'action',width:"4%"}
                ],
                "initComplete": function () {
                    $('.custom-buttons2').html(`
                        @can('BOM-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addbomchild" id="addbomchild" data-toggle="modal">Add Child BOM</button>
                        @endcan
                    `);
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
                    $("#child_bom_dt").show();
                },
            });

            $("#bomdatatablemodal").modal('show'); 
        }

        function bomDeleteFn(recordId) { 
            $("#delRecId").val(recordId);
            $('#deleterecbtn').text('Delete');
            $('#deleterecbtn').prop("disabled", false);
            $("#deletemodal").modal('show');
        }

        $('body').on('click', '#addbomchild', function() {
            var recordId=$("#dtRecId").val();
            $("#parentRecId").val(recordId);
            $.ajax({
                url: '/showBom'+'/'+recordId,
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
                    $.each(data.bomdata, function(key, value) {
                        $("#BomChildName").val(value.BomChildNumberData);
                        $("#bomnumberform").html(value.BomNumber);
                        $("#bomtypeform").html(value.BomType);
                        $("#bomnameform").html(value.BomName);
                        $("#bomdescriptionform").html(value.Description);
                        if(value.Status=="Active"){
                            $("#bomstatusform").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                        }
                        if(value.Status=="Inactive"){
                            $("#bomstatusform").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                        }
                    }); 
                }
            });
            $("#recChildId").val("");
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#statusChild').val("Active");
            $('#statusChild').select2({
                minimumResultsForSearch: -1
            });
            $('#dynamicTable > tbody').empty();
            $('#pricingTable').hide();
            $('#operationtypesch').val("1");
            $("#modaltitlech").html("Add Child BOM");
            $('#savebuttonch').text('Save');
            $('#savebuttonch').prop("disabled",false);
            $("#inlineFormChild").modal('show');
        });

        $('#deleterecbtn').click(function() {
            var delform = $("#deleteForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteBom',
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
                        toastrMessage('success',"Successful","Success");
                        $("#deletemodal").modal('hide');
                    }
                }
            });
        });

        function closeRegisterModal() {
            $('.mainforminp').val("");
            $('#status').val("Active");
            $('.errordatalabel').html('');
            $('#recId').val("");
            $('#operationtypes').val("1");
            $('#status').select2({
                minimumResultsForSearch: -1
            });
			$('#status').val("Active");
            $('#dynamicTable > tbody').empty();
        }

        function typeFn() {
            $('#type-error').html('');
        }

        function bomNameFn() {
            $('#name-error').html('');
        }

        function descriptionfn() {
            $('#description-error').html('');
        }

        function statusFn() {
            $('#status-error').html('');
        }

        function chBomNameFn() {
            $('#chname-error').html('');
        }

        function chDescriptionfn() {
            $('#chdescription-error').html('');
        }

        function chStatusFn() {
            $('#chstatus-error').html('');
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }
    </script>
@endsection
