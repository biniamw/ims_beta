@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Receiving-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom" style="height: 5rem;padding: 0.8rem;">
                            
                                <h3 class="card-title">Goods Receiving</h3>
                          
                            <ul class="nav nav-tabs justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="owner-tab" data-toggle="tab" href="#ownertab" aria-controls="ownertab" role="tab" aria-selected="true">Owner</a>                                
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="customer-tab" data-toggle="tab" href="#customertab" aria-controls="customertab" role="tab" aria-selected="false" style="display: none;">Customers</a>
                                </li>
                            </ul>
                            <div style="text-align: right;">  
                            
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div class="tab-content">
                                <div class="tab-pane active" id="ownertab" aria-labelledby="ownertab" role="tabpanel">
                                    <div class="col-lg-2 col-xl-2 col-md-4 col-sm-12 col-12" style="position: absolute;left: 260px;top: 85px;z-index: 10;display:none;" id="fiscalyear_div">
                                        <select class="select2 form-control" name="fiscalyear[]" id="fiscalyear">
                                        @foreach ($fiscalyears as $ownerfy)
                                            <option value="{{ $ownerfy->FiscalYear }}">{{ $ownerfy->Monthrange }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div style="width:99%; margin-left:0.5%;display:none;" id="owner_dt">
                                        <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 0%;display:none;"></th>
                                                    <th style="width: 3%;">#</th>
                                                    <th style="width: 11%;">Receiving Doc. No.</th>
                                                    <th style="width: 10%;">Product Type</th>
                                                    <th style="width: 10%;">Reference</th>
                                                    <th style="width: 11%;">Reference No.</th>
                                                    <th style="width: 11%;">Supplier Name</th>
                                                    <th style="width: 10%;">TIN</th>
                                                    <th style="width: 10%;">Received Station</th>
                                                    <th style="width: 10%;">Received Date</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 4%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table table-sm"></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="customertab" aria-labelledby="customertab" role="tabpanel">
                                    <div class="col-lg-2 col-xl-2 col-md-4 col-sm-12 col-12" style="position: absolute;left: 260px;top: 85px;z-index: 10;display:none;" id="cus_fiscalyear_div">
                                        <select class="select2 form-control" name="cus_fiscalyear[]" id="cus_fiscalyear">
                                        @foreach ($fiscalyears as $customerfy)
                                            <option value="{{ $customerfy->FiscalYear }}">{{ $customerfy->Monthrange }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div style="width:99%; margin-left:0.5%;display:none;" id="customer_dt">
                                        <table id="customer-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 0%;display:none;"></th>
                                                    <th style="width: 3%;">#</th>
                                                    <th style="width: 10%;">Receiving Doc. No.</th>
                                                    <th style="width: 8%;">Product Type</th>
                                                    <th style="width: 8%;">Reference</th>
                                                    <th style="width: 8%;">Reference No.</th>
                                                    <th style="width: 14%;">Customer</th>
                                                    <th style="width: 14%;">Supplier Name</th>
                                                    <th style="width: 8%;">TIN</th>
                                                    <th style="width: 8%;">Received Station</th>
                                                    <th style="width: 8%;">Received Date</th>
                                                    <th style="width: 7%;">Status</th>
                                                    <th style="width: 4%;">Action</th>
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
        </section>
    </div>
@endcan

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newreceivingmodaltitles">Add Receiving</h4>
                    <div class="row">
                        <div style="text-align: right;" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()"><span aria-hidden="true">&times;</span></button>
                    </div>   
                </div>
                <form id="RegisterRec">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                                <fieldset class="fset">
                                                    <legend>Basic Information</legend>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1">
                                                            <label style="font-size: 14px;">Reference</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="ReceivingType" id="ReceivingType" onchange="typeFn()">
                                                                <option selected disabled value=""></option>
                                                                @foreach ($receivingTypedata as $receivingTypedata)
                                                                    <option value="{{ $receivingTypedata->ReceivingTypeValue }}">{{ $receivingTypedata->ReceivingType }}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="type-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        
                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1" id="ponumdiv">
                                                            <label style="font-size: 14px;">Reference No.</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="PONumber" id="PONumber" onchange="poNumberFn()">
                                                                <option selected value=""></option>
                                                                
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="ponumber-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1">
                                                            <label style="font-size: 14px;">Product Type</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="ProductType" id="ProductType" onchange="prTypeFn()"></select>
                                                            <span class="text-danger">
                                                                <strong id="prdtype-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1">
                                                            <label style="font-size: 14px;">Supplier</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="supplier" id="supplier" onchange="supplierVal()">
                                                                    <option selected disabled value=""></option>
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="supplier-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1 commprop">
                                                            <label style="font-size: 14px;">Commodity Source</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="CommoditySource" id="CommoditySource" onchange="commoditySrcFn()"></select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="commoditysrc-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1 commprop">
                                                            <label style="font-size: 14px;">Commodity Type</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="CommodityType" id="CommodityType" onchange="commodityTypeFn()">
                                                                    <option selected value="Coffee">Coffee</option>
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="commoditytype-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-1">
                                                            <label style="font-size: 14px;">Company Type</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="CompanyType" id="CompanyType" onchange="compTypeFn()">
                                                                <option selected value=""></option>
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="comptype-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-8 col-md-12 col-sm-12 mb-1 customerdiv">
                                                            <label style="font-size: 14px;">Customer</label><label style="color: red; font-size:16px;">*</label>
                                                            <select class="select2 form-control" name="Customer" id="Customer" onchange="customerFn()">
                                                                @foreach ($customerdatasrc as $customerdatasrc)
                                                                <option value="{{$customerdatasrc->id}}">{{$customerdatasrc->Code}} , {{$customerdatasrc->Name}} , {{$customerdatasrc->TinNumber}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger">
                                                                <strong id="customer-error" class="errordatalabel cusreprerr"></strong>
                                                            </span>
                                                        </div>
                                                        
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <fieldset class="fset">
                                                    <legend>Delivery, Receiving & Other Information</legend>
                                                    <div class="row">
                                                        <div class="col-xl-3 col-md-4 col-sm-6 mb-1">
                                                            <label style="font-size: 14px;">Delivery Order No.</label><label style="color: red; font-size:16px;">*</label>
                                                            <input type="text" name="DeliveryOrderNo" id="DeliveryOrderNo" placeholder="Write Delivery order number here" class="DeliveryOrderNo form-control mainforminp" onkeyup="deliveryOrdNumFn()"/>
                                                            <span class="text-danger">
                                                                <strong id="deliveryordnumber-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-3 col-md-4 col-sm-6">
                                                            <label style="font-size: 14px;">Dispatch Station</label><label style="color: red; font-size:16px;">*</label>
                                                            <input type="text" name="DispatchStation" id="DispatchStation" placeholder="Write Dispatch station here" class="DispatchStation form-control mainforminp" onkeyup="dispatchStFn()"/>
                                                            <span class="text-danger">
                                                                <strong id="dispatchst-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-3 col-md-4 col-sm-6">
                                                            <label style="font-size: 14px;">Receiving Station</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="store" id="store" onchange="storeVal()">
                                                                    <option selected disabled value=""></option>
                                                                    @foreach ($storeSrc as $storeSrc)
                                                                        <option value="{{ $storeSrc->StoreId }}">{{ $storeSrc->StoreName }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="store-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-3 col-md-4 col-sm-6">
                                                            <label style="font-size: 14px;">Received By</label><label style="color: red; font-size:16px;">*</label>
                                                            <div>
                                                                <select class="select2 form-control" name="ReceivedBy" id="ReceivedBy" onchange="recievedByFn()">
                                                                    <option selected disabled value=""></option>
                                                                    @foreach ($purchaser as $purchaser)
                                                                        <option value="{{ $purchaser->username }}"> {{ $purchaser->username }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="receivedby-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                        <div class="col-xl-12 col-md-12 col-sm-12 mt-1">
                                                            <div class="divider" style="margin-top:-1rem;">
                                                                <div class="divider-text"><b>Transportation Detail</b></div>
                                                            </div>
                                                            <div class="row" style="margin-top:-1rem;">
                                                                <div class="col-xl-3 col-md-4 col-sm-4">
                                                                    <label style="font-size: 14px;">Driver Name</label><label style="color: red; font-size:16px;">*</label>
                                                                    <input type="text" name="DriverName" id="DriverName" placeholder="Write Driver name here" class="DriverName form-control mainforminp" onkeyup="truckDriverFn()"/>
                                                                    <span class="text-danger">
                                                                        <strong id="truckdriver-error" class="errordatalabel"></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-4 col-sm-4">
                                                                    <label style="font-size: 14px;">Plate No.</label><label style="color: red; font-size:16px;">*</label>
                                                                    <input type="text" name="PlateNumber" id="PlateNumber" placeholder="Write Truck plate number here" class="PlateNumber form-control mainforminp" onkeyup="plateNumFn()" style="text-transform:uppercase"/>
                                                                    <span class="text-danger">
                                                                        <strong id="platenum-error" class="errordatalabel"></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-4 col-sm-4">
                                                                    <label style="font-size: 14px;">Driver Phone No.</label>
                                                                    <input type="number" name="DriverPhoneNumber" id="DriverPhoneNumber" placeholder="Write Driver phone number here" class="DriverPhoneNumber form-control mainforminp" onkeypress="return ValidateOnlyNum(event);" onkeyup="driverPhoneNumFn()"/>
                                                                    <span class="text-danger">
                                                                        <strong id="driverphonenum-error" class="errordatalabel"></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-4 col-sm-6">
                                                                    <label style="font-size: 14px;">Delivered By</label><label style="color: red; font-size:16px;">*</label>
                                                                    <input type="text" name="DeliveredBy" id="DeliveredBy" placeholder="Write Name here" class="DeliveredBy form-control mainforminp" onkeyup="deliveredByFn()"/>
                                                                    <span class="text-danger">
                                                                        <strong id="deliveredby-error" class="errordatalabel"></strong>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <hr class="m-1">
                                                            
                                                        </div>

                                                        <div class="col-xl-4 col-md-6 col-sm-6">
                                                            <label style="font-size: 14px;">Received Date</label><label style="color: red; font-size:16px;">*</label>
                                                            <input type="text" name="ReceivedDate" id="ReceivedDate" placeholder="YYYY-MM-DD" class="ReceivedDate form-control mainforminp" onchange="recdateFn()"/>
                                                            <span class="text-danger">
                                                                <strong id="receiveddate-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6 col-sm-6">
                                                            <label style="font-size: 14px;">Document Upload</label>
                                                            <input class="form-control fileuploads mainforminp" type="file" id="DocumentUpload" name="DocumentUpload" accept=".jpg, .jpeg, .png,.pdf">
                                                            <span>
                                                                <button type="button" id="documentuploadlinkbtn" name="documentuploadlinkbtn" class="btn btn-flat-info waves-effect btn-sm documentuploadlinkbtn" onclick="documentUploadFn()" style="display:none;"></button>
                                                                <button type="button" id="docBtn" name="docBtn" class="btn btn-flat-danger waves-effect btn-sm docBtn" onclick="docBtnFn();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                                <strong id="documentupload-error" class="text-danger errordatalabel"></strong>
                                                                <input type="hidden" class="form-control mainforminp" name="documentuploadfilelbl" id="documentuploadfilelbl" readonly="true" value=""/> 
                                                            </span>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6 col-sm-12">
                                                            <label style="font-size: 14px;">Remark</label>
                                                            <div>
                                                                <textarea type="text" placeholder="Write Remark here..." class="form-control mainforminp" name="Remark" id="Remark"></textarea>
                                                            </div>
                                                            <span class="text-danger">
                                                                <strong id="remark-error" class="errordatalabel"></strong>
                                                            </span>
                                                        </div>

                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-1">
                                
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xl-12 col-12 productcls" id="goodsdiv">
                                        <div class="table-responsive">
                                            <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:3%;">#</th>
                                                        <th style="width:13%">Location</th>
                                                        <th style="width:14%">Item Name</th>
                                                        <th style="width:13%">UOM</th>
                                                        <th style="width:13%">Quantity</th>
                                                        <th style="width:13%">Requested Qty.</th>
                                                        <th style="width:13%">Remaining Qty.</th>
                                                        <th style="width:15%">Remark</th>
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
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 productcls" id="commoditydiv">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="commDynamicTable" class="mb-0 cbegtable" style="width:100%;">
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9" style="text-align: left;">
                                                <table class="mb-0">
                                                    <tr>
                                                        <td>
                                                            <button type="button" name="commadds" id="commadds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>  Add New</button>
                                                        <td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 mt-1" style="text-align: right;">
                                                <table style="width: 100%" class="rtable" id="commTotalTable">
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td style="text-align: right;width:60%"><label id="totalnumofbag" style="font-size: 14px;">Total Number of Bag</label></td>
                                                        <td style="text-align: center;width:40%">
                                                            <label id="totalnumberofbag" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td><label id="totalweightkg" style="font-size: 14px;">Total Bag Weight by KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalbagweightbykg" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td style="text-align: right;"><label id="totalbykg" style="font-size: 14px;">Total Net KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalnetkg" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td><label id="totalvarinceshortage" style="font-size: 14px;">Total Variance Shortage by KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalvarianceshortage" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td><label id="totalvarinceoverage" style="font-size: 14px;">Total Variance Overage by KG</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalvarianceoverage" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #FFFFFF;">
                                                        <td><label id="totalbyferesula" style="font-size: 14px;">Total by Feresula</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalbalanceferesula" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                    <tr style="background-color: #f8f9fa;">
                                                        <td><label id="totalbyferesula" style="font-size: 14px;">Total by TON</label></td>
                                                        <td style="text-align: center;">
                                                            <label id="totalbalanceton" class="formattedNum" style="font-size: 14px; font-weight: bold;"></label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <div style="display:none;">
                            <select class="select2 form-control" name="po_goods_default" id="po_goods_default">
                                <option selected disabled value=""></option>
                            </select>
                            <select class="select2 form-control" name="supplierdefault" id="supplierdefault" onchange="supplierVal()">
                                <option selected disabled value=""></option>
                                {{-- @can('Customer-Add')<option value="supp01" data-icon="fa fa-plus">Add New Supplier</option>@endcan --}}
                                @foreach ($customerSrc as $customerSrc)
                                    <option value="{{ $customerSrc->id }}">{{ $customerSrc->Code }}     ,       {{ $customerSrc->Name }}  ,     {{ $customerSrc->TinNumber }}</option>
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
                            <select class="select2 form-control" name="commoditydefault" id="commoditydefault">
                                <option selected disabled value=""></option>
                                @foreach ($poCommDataSrc as $poCommDataSrc)
                                    <option tabindex="{{$poCommDataSrc->DetailId }}" contextmenu="{{$poCommDataSrc->PurDetailProp}}" label="{{$poCommDataSrc->purchaseorder_id}}" title="{{$poCommDataSrc->CommType}}" value="{{ $poCommDataSrc->CommId }}">{{ $poCommDataSrc->Origin }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="goodsdefault" id="goodsdefault">
                                <option selected disabled value=""></option>
                                @foreach ($poGoodsDataSrc as $poGoodsDataSrc)
                                    <option title="{{$poGoodsDataSrc->purchaseorder_id}}" value="{{ $poGoodsDataSrc->id }}">{{ $poGoodsDataSrc->Name }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="commoditytypedefault" id="commoditytypedefault">
                                <option selected disabled value=""></option>
                                @foreach ($commtypedata as $commtypedata)
                                    <option value="{{ $commtypedata->CommodityTypeValue }}">{{ $commtypedata->CommodityType }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="cropyeardefault" id="cropyeardefault">
                                <option selected disabled value=""></option>
                                @foreach ($cropyeardata as $cropyeardata)
                                    <option value="{{ $cropyeardata->CropYearValue }}">{{ $cropyeardata->CropYear }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="processtypedefault" id="processtypedefault">
                                <option selected disabled value=""></option>
                                @foreach ($prctypedata as $prctypedata)
                                    <option value="{{ $prctypedata->ProcessTypeValue }}">{{ $prctypedata->ProcessType }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="gradedefault" id="gradedefault">
                                <option selected disabled value=""></option>
                                @foreach ($gradedata as $gradedata)
                                    <option value="{{ $gradedata->GradeValue }}">{{ $gradedata->Grade }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="commoditysourcedefault" id="commoditysourcedefault">
                                <option selected disabled value=""></option>
                                @foreach ($commsrcdata as $commsrcdata)
                                    <option value="{{ $commsrcdata->CommoditySourceValue }}">{{ $commsrcdata->CommoditySource }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control" name="producttypedefault" id="producttypedefault">
                                <option selected disabled value=""></option>
                                @foreach ($productTypedata as $productTypedata)
                                    <option value="{{ $productTypedata->ProductType }}">{{ $productTypedata->ProductType }}</option>
                                @endforeach
                            </select>

                            <select class="select2 form-control eNames" data-style="btn btn-outline-secondary waves-effect" name="eNames" id="itemnamefooter">
                                <option selected disabled value=""></option>
                                @foreach ($itemSrcs as $itemSrcs)
                                    <option value="{{ $itemSrcs->id }}">{{ $itemSrcs->Code }} , {{ $itemSrcs->Name }} , {{ $itemSrcs->SKUNumber }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <input type="hidden" class="form-control" name="ispoamntauthvals" id="ispoamntauthvals" readonly="true" value="{{$isPoAmntAuth}}"/>
                        <input type="hidden" class="form-control" name="cdatevals" id="cdatevals" readonly="true" value="{{$curdate}}"/>
                        <input type="hidden" class="form-control" name="hiddenstoreval" id="hiddenstoreval" readonly="true"/>
                        <input type="hidden" class="form-control" name="tid" id="tid" readonly="true"/>
                        <input type="hidden" class="form-control" name="receivingId" id="receivingId" readonly="true"/>
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true" value="1"/>
                        <input type="hidden" class="form-control" name="witholdMinAmounti" id="witholdMinAmounti" readonly="true"/>
                        <input type="hidden" class="form-control" name="witholdPercenti" id="witholdPercenti" readonly="true"/>
                        <input type="hidden" class="form-control" name="commonVal" id="commonVal" readonly="true"/>
                        <input type="hidden" class="form-control" name="holdnumberi" id="holdnumberi" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="receivingnumberi" id="receivingnumberi" readonly="true" value=""/>
                        @can('Receiving-Add')
                            <button id="saveHoldbutton" type="button" class="btn btn-info">Save</button>
                            <button id="savebutton" type="submit" class="btn btn-info">Save</button>
                        @endcan
                        @can('Hold-Add')
                            {{-- <button id="holdbutton" type="button" class="btn btn-info">Hold</button> --}}
                        @endcan
                        <button id="closebuttonk" type="button" class="btn btn-danger closebutton" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start Delete modal -->
    <div class="modal fade text-left" id="examplemodal-delete" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size:16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="id" id="did">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletebtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->

    <!--Start add new hold modal -->
    <div class="modal fade text-left" id="newholdmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeHoldAddModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="newHoldform">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="table-responsive" style="min-height: 250px;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width:30%;">
                                            <label style="font-size: 14px;">Item Name</label>
                                        </td>
                                        <td>
                                            <label style="font-size: 14px;">UOM</label>
                                        </td>
                                        <td>
                                            <label style="font-size: 14px;">Quantity</label>
                                        </td>
                                        <td>
                                            <label style="font-size: 14px;">Unit_Cost</label>
                                        </td>
                                        <td>
                                            <label style="font-size: 14px;">Before_Tax</label>
                                        </td>
                                        <td>
                                            <label style="font-size: 14px;">Tax_Amount</label>
                                        </td>
                                        <td>
                                            <label style="font-size: 14px;">Total_Cost</label>
                                        </td>
                                    </tr>
                                    <tr style="height: 50%;">
                                        <td>
                                            <select class="selectpicker form-control" data-live-search="true"
                                                data-style="btn btn-outline-secondary waves-effect" name="addHoldItem"
                                                id="addHoldItem" onchange="itemNameHoldVal()" style="position: absolute;">
                                                <option selected disabled value=""></option>
                                                @foreach ($itemSrcAddHold as $itemSrcAddHold)
                                                    <option style="width: 20%" value="{{ $itemSrcAddHold->id }}">
                                                        {{ $itemSrcAddHold->Code }} ,
                                                        {{ $itemSrcAddHold->Name }} , {{ $itemSrcAddHold->SKUNumber }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" class="form-control" name="itid" id="itid"
                                                readonly="true" />
                                            <input type="hidden" class="form-control" name="receivingidinput"
                                                id="receivingidinput" readonly="true" />
                                            <input type="hidden" class="form-control" name="receIds" id="receIds"
                                                readonly="true" />
                                            <input type="hidden" class="form-control" name="recId" id="recId"
                                                readonly="true" />
                                            <input type="hidden" class="form-control" name="recevingedit"
                                                id="recevingedit" readonly="true" />
                                            <input type="hidden" class="form-control" name="stId" id="stId"
                                                readonly="true" />
                                            <input type="hidden" class="form-control" name="receivingstoreid"
                                                id="receivingstoreid" readonly="true" />
                                            <input type="hidden" class="form-control" name="editVal" id="editVal"
                                                value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="defaultuomi" id="defaultuomi"
                                                value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="newuomi" id="newuomi"
                                                value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="convertedqi" id="convertedqi"
                                                value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="convertedamnti"
                                                id="convertedamnti" value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="itemidi" id="itemidi"
                                                value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="retailerpricei"
                                                id="retailerpricei" value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="wholeselleri"
                                                id="wholeselleri" value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="taxpercenti" id="taxpercenti"
                                                value="0" readonly="true" />
                                            <input type="hidden" class="form-control" name="itemtypei" id="itemtypei"
                                                value="0" readonly="true" />
                                        </td>
                                        <td>
                                            <select id="uoms" class="select2 form-control uoms"
                                                onchange="uomsavedVal(this)" name="uoms"></select>
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" name="quantityhold" placeholder="Quantity"
                                                id="quantityhold" class="quantityhold form-control"
                                                onkeyup="CalculateAddHoldTotal(this)"
                                                onkeypress="return ValidateNum(event);" onkeydown="validateQuantityVal();"
                                                ondrop="return false;" onpaste="return false;" />
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" name="unitcosthold" placeholder="Unit Cost"
                                                id="unitcosthold" class="unitcosthold form-control"
                                                onkeyup="CalculateAddHoldTotal(this)"
                                                onkeypress="return ValidateNum(event);" onkeydown="validateUnitcostVal();"
                                                ondrop="return false;" onpaste="return false;" />
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" name="beforetaxhold" placeholder="Before Tax"
                                                id="beforetaxhold" class="beforetaxhold form-control" readonly
                                                style="font-weight:bold;" />
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" name="taxamounthold" placeholder="Tax Amount"
                                                id="taxamounthold" class="taxamounthold form-control" readonly
                                                style="font-weight:bold;" />
                                        </td>
                                        <td style="width: 10%">
                                            <input type="number" name="totalcosthold" placeholder="Total Cost"
                                                id="totalcosthold" class="totalcosthold form-control" readonly
                                                style="font-weight:bold;" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addholdItem-error"></strong>
                                            </span>
                                        </td>
                                        <td></td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldQuantity-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldunitCost-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldbeforeTax-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldTaxAmount-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                                <strong id="addHoldTotalAmount-error"></strong>
                                            </span>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="savenewreceiving" type="button" class="btn btn-info">Save</button>
                        <button id="savenewhold" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttona" type="button" class="btn btn-danger" onclick="closeHoldAddModal()"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End add new hold Modal -->

    <!--Start Hold Data Delete modal -->
    <div class="modal fade text-left" id="holddataremoved" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteholddataform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="holddataremove" id="holddataremove" readonly="true">
                            <span class="text-danger">
                                <strong id="holddata-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteholddata" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonb" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Hold Data Delete Modal -->

    <!--Start Hold Item Delete modal -->
    <div class="modal fade text-left" id="holdremovemodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteholditemform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="holdremoveid" id="holdremoveid" readonly="true">
                            <input type="hidden" class="form-control" name="holdremoveheaderid" id="holdremoveheaderid" readonly="true">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteholdbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonc" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Hold Item Delete Modal -->

    <!--Start Receiving Item Delete modal -->
    <div class="modal fade text-left" id="receivingremovemodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletereceivingitemform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="receivingremoveid" id="receivingremoveid" readonly="true">
                            <input type="hidden" class="form-control" name="receivingremoveheaderid" id="receivingremoveheaderid" readonly="true">
                            <input type="hidden" class="form-control" name="numofitemi" id="numofitemi" readonly="true">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletereceivingbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttond" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Receiving Item Delete Modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="receivinginfomodaltitle">Receiving Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statustitles"></div>
                        <button type="button" class="close" data-dismiss="modal" onclick="closeInfoModal()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                </div>
                <form id="holdInfo">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <section id="collapsible">
                                                <div class="card collapse-icon">
                                                    <div class="collapse-default">
                                                        <div class="card">
                                                            <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target=".infoscl" aria-expanded="false" aria-controls="collapse1">
                                                                <span class="lead collapse-title">Basic, Delivery, Receiving & Other Information</span>
                                                                <div style="text-align: right;" id="statustitlesA"></div>
                                                            </div>
                                                            <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse infoscl">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Basic Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <table style="width: 100%" class="infotbl">
                                                                                            <tr style="display: none;">
                                                                                                <td style="width: 42%"><label style="font-size: 14px;">Document No.</label></td>
                                                                                                <td style="width: 58%"><label class="font-weight-bolder infolbls" id="infoDocDocNo" style="font-size: 14px;"></label></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td style="width: 42%"><label style="font-size: 14px;">Reference</label></td>
                                                                                                <td style="width: 58%"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="referenceLbl"></label></td>
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
                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                                                            <div class="card">
                                                                                <div class="card-header">
                                                                                    <h6 class="card-title">Delivery, Receiving & Other Information</h6>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                            <table style="width: 100%" class="infotbl">
                                                                                                <tr>
                                                                                                    <td style="width: 42%;"><label style="font-size: 14px;">Delivery Order No.</label></td>
                                                                                                    <td style="width: 58%;"><label class="font-weight-bolder infolbls" id="deliveryOrderLbl" style="font-size: 14px;"></label></td>
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
                                                                                                    <td><label style="font-size: 14px;">Invoice Status</label></td>
                                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="invoiceStatusLbl"></label></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Return Status</label></td>
                                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="returnStatusLbl"></label></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                            <table style="width: 100%" class="infotbl">
                                                                                                <tr>
                                                                                                    <td style="width: 42%;"><label style="font-size: 14px;">Driver Name</label></td>
                                                                                                    <td style="width: 58%;"><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="driverNameLbl"></label></td>
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
                                                                                                    <td><label style="font-size: 14px;">Document Upload</label></td>
                                                                                                    <td><a style="text-decoration:underline;color:blue;" onclick="grvFileDownload()" id="infodocumentuploadlinkbtn"></a></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label style="font-size: 14px;">Remark</label></td>
                                                                                                    <td><label class="font-weight-bolder infolbls" style="font-size: 14px;" id="remarkLbl"></label></td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
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
                                                                                        <div class="col-lg-12 col-md-12 col-sm-12 scrdivhor scrollhor" style="overflow-y: scroll;height:10rem">
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

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <ul class="nav nav-tabs nav-fill" role="tablist" style="border:1px solid #D3D3D3">
                                        <li class="nav-item">
                                            <a class="nav-link propdtable active" id="purchasedtab" data-toggle="tab" aria-controls="purchasedtab" href="#purchasedtabBody" role="tab" aria-selected="true">Purchased</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link propdtable" id="returnedtab" data-toggle="tab" aria-controls="returnedtab" href="#returnedtabBody" role="tab" aria-selected="true">Returned Commodity</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane propdtableBody active" id="purchasedtabBody" role="tabpanel" aria-labelledby="purchasedtabBody">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="table-responsive scroll scrdiv">
                                                        
                                                        <div class="row datatableinfocls" style="display: none;" id="goods_div">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <table id="docInfoItem" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable" style="width: 100%;">
                                                                    <thead>
                                                                        <th style="width:3%;">#</th>
                                                                        <th style="width:19%;">Location</th>
                                                                        <th style="width:20%;">Item Name</th>
                                                                        <th style="width:19%;">UOM</th>
                                                                        <th style="width:19%;">Quantity</th>
                                                                        <th style="width:20%;">Remark</th>
                                                                    </thead>
                                                                    <tbody class="table table-sm"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                            
                                                        <div class="row datatableinfocls" style="display: none;" id="commodity_div">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <table id="origindetailtable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
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

                                        <div class="tab-pane propdtableBody" id="returnedtabBody" role="tabpanel" aria-labelledby="returnedtabBody">
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                    <div class="table-responsive scroll scrdiv">
                                                        <table id="commdatatable" class="display table-bordered table-striped table-hover dt-responsive mb-0 defaultdatatable" style="width: 100%">
                                                            <thead> 
                                                                <tr>
                                                                    <th style="width:2%;">#</th>
                                                                    <th style="width:8%">Requisition Doc. No.</th>
                                                                    <th style="width:5%">Type</th>
                                                                    <th style="width:8%">Commodity</th>
                                                                    <th style="width:5%">Grade</th>
                                                                    <th style="width:5%">Process Type</th>
                                                                    <th style="width:5%">Crop Year</th>
                                                                    <th style="width:5%">UOM/ Bag</th>
                                                                    <th style="width:5%">No. of Bag</th>
                                                                    <th style="width:5%">Bag Weight by KG</th>
                                                                    <th style="width:5%">Total KG</th>
                                                                    <th style="width:5%">Net KG</th>
                                                                    <th style="width:5%">TON<label id="feresulainfolbl" title="TON= Net KG / 1000"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                    <th style="width:5%">Feresula<label id="feresulainfolbl" title="Feresula= Net KG / 17"><i class="fa-solid fa-circle-info"></i></label></th>
                                                                    <th style="width:6%">Variance Shortage by KG</th>
                                                                    <th style="width:6%">Variance Overage by KG</th>
                                                                    <th style="width:10%">Remark</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="table table-sm"></tbody>
                                                            <tfoot>
                                                                <th colspan="8" style="font-size:16px;text-align: right;padding-right:7px;">Total</th>
                                                                <th style="font-size: 14px;" id="totalbagRet"></th>
                                                                <th style="font-size: 14px;" id="totalbagweightRet"></th>
                                                                <th style="font-size: 14px;" id="totalgrosskgRet"></th>
                                                                <th style="font-size: 14px;" id="totalkgRet"></th>
                                                                <th style="font-size: 14px;" id="totaltonRet"></th>
                                                                <th style="font-size: 14px;" id="totalferesulaRet"></th>
                                                                <th style="font-size: 14px;" id="totalvarshortageRet"></th>
                                                                <th style="font-size: 14px;" id="totalvarovrageRet"></th>
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

                            <div class="row"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="usernamelbl" id="usernamelbl" readonly="true" value="{{$user}}">
                        <input type="hidden" class="form-control" name="selectedids" id="selectedids" readonly="true">
                        <input type="hidden" class="form-control" name="recordIds" id="recordIds" readonly="true">
                        <input type="hidden" class="form-control" name="statusIds" id="statusIds" readonly="true">
                        <input type="hidden" class="form-control" name="infogrvfilename" id="infogrvfilename" readonly="true">
                        
                        @can('Receiving-ChangeToPending')
                            <button id="changetopending" type="button" onclick="getPendingInfoConf()" class="btn btn-info recpropbtn">Change to Pending</button>
                            <button id="backtodraft" type="button" onclick="backToDraftFn()" class="btn btn-info recpropbtn">Back to Draft</button>
                        @endcan
                        @can('Receiving-Verify')
                            <button id="checkreceiving" type="button" onclick="getCheckInfoConf()" class="btn btn-info recpropbtn">Verify Receiving</button>
                            <button id="backtopending" type="button" onclick="backToPendingFn()" class="btn btn-info recpropbtn">Back to Pending</button>
                        @endcan
                        @can('Receiving-Confirm')
                            <button id="confirmreceiving" type="button" onclick="getConfirmInfoConf()" class="btn btn-info recpropbtn">Change to Confirm</button>
                        @endcan
                        <button id="closebuttone" type="button" class="btn btn-danger" onclick="closeInfoModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Hold Info -->

    <!--Start Check Receiving modal -->
    <div class="modal fade text-left" id="receivingcheckmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="checkreceivingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to verify receiving?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="checkedid" id="checkedid"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="checkedbtn" type="button" class="btn btn-info">Verify Receiving</button>
                        <button id="closebuttonf" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Check Receiving modal -->

    <!--Start Pending Receiving modal -->
    <div class="modal fade text-left" id="receivingpendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="pendingreceivingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to change receiving to pending?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="pendingid" id="pendingid"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="pendingbtn" type="button" class="btn btn-info">Change to Pending</button>
                        <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Pending Receiving modal -->

    <!--Start Confimed Receiving modal -->
    <div class="modal fade text-left" id="receivingconfirmedmodal" data-keyboard="false" data-backdrop="static"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="confirmedreceivingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to change receiving to received?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="confirmid" id="confirmid"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="confirmbtn" type="button" class="btn btn-info">Change to Confirm</button>
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Confimed Receiving modal -->

    <!--Start Void modal -->
    <div class="modal fade text-left" id="voidreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="voidReason()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="voidreasonform">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label style="font-size: 16px;font-weight:bold;">Do you really want to void receiving?</label>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Reason</div>
                        </div>
                        <label style="font-size: 16px;"></label>
                        <textarea type="text" placeholder="Write Reason here..." class="form-control Reason" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="void-error"></strong>
                        </span>
                        <div class="form-group">
                            <input type="hidden" class="form-control voidid" name="voidid" id="voidid" readonly="true">
                            <input type="hidden" class="form-control vstatus" name="vstatus" id="vstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="voidbtn" type="button" class="btn btn-info">Void</button>
                        <button id="closebuttoni" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReason()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Void modal -->

    <!--Start undo void modal -->
    <div class="modal fade text-left" id="undovoidmodal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="undovoidform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to undo void receiving?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="undovoidid" id="undovoidid" readonly="true">
                            <input type="hidden" class="form-control" name="ustatus" id="ustatus" readonly="true">
                            <input type="hidden" class="form-control" name="oldstatus" id="oldstatus" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="undovoidbtn" type="button" class="btn btn-info">Undo Void</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End undo void modal -->

    <!--Start Hide Receiving modal -->
    <div class="modal fade text-left" id="hidereceivingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="hidereceivingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to hide receiving?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="hiderecid" id="hiderecid"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="hiderecbtn" type="button" class="btn btn-info">Hide Receiving</button>
                        <button id="closebuttonl" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Hide Receiving modal -->

    <!--Start Show Receiving modal -->
    <div class="modal fade text-left" id="showreceivingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="showreceivingform">
                    @csrf
                    <div class="modal-body" style="background-color:#f6c23e">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to show receiving?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="showrecid" id="showrecid"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="showrecbtn" type="button" class="btn btn-info">Show Receiving</button>
                        <button id="closebuttono" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Show Receiving modal -->

    <!--Start Info Modal -->
    <div class="modal fade text-left" id="witholdSettleModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="witholdSettleInfoTitle">Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="witholdSettleForm">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="table-responsive">
                                        <input type="hidden" class="form-control" name="statusid"
                                            id="statusid" readonly="true">
                                        <label style="font-size: 14px;display:none;" id="infoDocType" strong
                                            style="font-size: 12px;"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="witholdSettleTable" class="col-xl-12 col-lg-12">
                                    <table id="witholdTables"
                                        class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <thead>
                                            <th style="display:none;">id</th>
                                            <th style="display:none;">Type</th>
                                            <th>GRV / Document Number</th>
                                            <th>Doc/Fs No.</th>
                                            <th>Sub Total</th>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td colspan=4 style="text-align:right;"><b><label
                                                            id="witholdAmountTotalTitleSett" strong
                                                            style="font-size: 16px;font-weight:bold;">Total</label></b></td>
                                                <td><label id="witholdSubtotalLblSett" strong
                                                        style="font-size: 16px;font-weight:bold;"></label></td>
                                            </tr>
                                            <tr>
                                                <td colspan=4 style="text-align:right;">
                                                    <label id="witholdreceiptlblsett" class="badge badge-success badge-sm"
                                                        style="font-size: 12px;font-weight:bold;"></label>
                                                    <label id="settledLabelSett" class="badge badge-success badge-sm"
                                                        style="font-size: 12px;font-weight:bold;">Settled</label>
                                                    <label id="notsettledLabelSett" class="badge badge-warning badge-sm"
                                                        style="font-size: 12px;font-weight:bold;">Not-Settled</label>
                                                    <b><label id="witholdAmountLblTitleSett" strong
                                                            style="font-size: 16px;font-weight:bold;"></label></b>
                                                </td>
                                                <td><label id="witholdAmountLblSett" strong
                                                        style="font-size: 16px;font-weight:bold;"></label></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">-</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xl-3 col-lg-12"></div>
                                <label class="col-sm-2 col-form-label">Receipt No.</label>
                                <div class="col-sm-3">
                                    <input type="number" placeholder="Receipt Number" class="form-control"
                                        name="ReceiptNumber" id="ReceiptNumber" onkeyup="ReceiptNumberVal();"
                                        onkeypress="return ValidateOnlyNum(event);" />
                                    <span class="text-danger">
                                        <strong id="receipt-error"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="recSettIds" id="recSettIds"
                            readonly="true" />
                        <input type="hidden" class="form-control" name="selectedIdsWithold"
                            id="selectedIdsWithold" readonly="true" />
                        <input type="hidden" class="form-control" name="witholdPercentisett"
                            id="witholdPercentisett" readonly="true" />
                        <input type="hidden" class="form-control" name="infowitholdingTitlesett"
                            id="infowitholdingTitlesett" readonly="true" />
                        <input type="hidden" class="form-control" name="witholdMinAmountisett"
                            id="witholdMinAmountisett" readonly="true" />
                        <input type="hidden" class="form-control" name="WitholdCustomerId"
                            id="WitholdCustomerId" readonly="true" />
                        <input type="hidden" class="form-control" name="witholdTransactionDate"
                            id="witholdTransactionDate" readonly="true" />
                        @can('Withold-Settle')
                            <button id="settlewitholdbtn" type="button" class="btn btn-info">Settle</button>
                        @endcan
                        <button id="closebuttonp" type="button" class="btn btn-danger" onclick="ReceiptNumberVal();"
                            data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Hold Info -->

    <!--Start Show Separate Settlement modal -->
    <div class="modal fade text-left" id="separateSettleModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 10px;" id="witholdSettlementHeader"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="ReceiptNumberVals();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="sepwitholdSettleForm">
                    @csrf
                    <div class="modal-body">
                        <label id="witholdsettleLbl" style="font-size: 16px;"></label>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" style="font-size: 16px;">Receipt No.</label>
                            <div class="col-sm-9">
                                <input type="number" placeholder="Receipt Number" class="form-control"
                                    name="ReceiptNumbers" id="ReceiptNumbers" onkeyup="ReceiptNumberVals();"
                                    onkeypress="return ValidateOnlyNum(event);" />
                                <span class="text-danger">
                                    <strong id="receipts-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="separatesettid"
                                id="separatesettid" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="separateSettleBtn" type="button" class="btn btn-info">Settle</button>
                        <button id="closebuttono" type="button" class="btn btn-danger" data-dismiss="modal"
                            onclick="ReceiptNumberVals();">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Show Separate Settlement modal -->

    <!--Start Show Receiving modal -->
    <div class="modal fade text-left" id="showUnsettledModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="showunsettledform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to remove withold receipt?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="unsettledid" id="unsettledid"
                                readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="singleUnSettledId"
                            id="singleUnSettledId" readonly="true" />
                        <input type="hidden" class="form-control" name="UnWitholdCustomerId"
                            id="UnWitholdCustomerId" readonly="true" />
                        <input type="hidden" class="form-control" name="UnwitholdTransactionDate"
                            id="UnwitholdTransactionDate" readonly="true" />
                        <button id="removeReceiptBtn" type="button" class="btn btn-info">Remove</button>
                        <button id="closebuttonp" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Show Receiving modal -->

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
                                <label style="font-size: 14px;">Brand</label>
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
                                <label style="font-size: 14px;">Model</label>
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
                                <label style="font-size: 14px;">Manufacture Date</label>
                                <input type="text" id="ManufactureDate" name="ManufactureDate" class="form-control" placeholder="YYYY-MM-DD" onchange="mfgDateVal();" readonly="true"/>
                                <span class="text-danger">
                                    <strong id="manfdate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="expiredatediv" style="display:none;">
                                <label style="font-size: 14px;">Expired Date</label>
                                <input type="text" id="ExpireDate" name="ExpireDate" class="form-control" placeholder="YYYY-MM-DD" onchange="expireDateVal();" readonly="true"/>
                                <span class="text-danger">
                                    <strong id="expiredate-error"></strong>
                                </span>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="batchnumberdiv" style="display:none;">
                                <label style="font-size: 14px;">Batch Number</label>
                                <div class="invoice-customer">
                                    <input type="text" placeholder="Enter batch number" class="form-control" name="BatchNumber" id="BatchNumber" onkeyup="batchNumberVal();"/>       
                                    <span class="text-danger">
                                        <strong id="batchnum-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="serialnumdiv" style="display:none;">
                                <label style="font-size: 14px;">Serial Number</label>
                                <div class="invoice-customer">
                                    <input type="text" placeholder="Enter serial number" class="form-control" name="SerialNumber" id="SerialNumber" onkeyup="serialNumberVal();"/>       
                                    <span class="text-danger">
                                        <strong id="serialnum-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xl-2 col-md-6 col-sm-12 mb-0" id="quantitydiv" style="display:none;">
                                <label style="font-size: 14px;">Quantity</label>
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
                                <label style="font-size: 16px;"></label>
                                <div style="text-align: right;">
                                    <div id="dynamicbuttondiv">
                                        <button id="saveSerialNum" type="button" class="btn btn-info btn-sm">Add</button>
                                        <button id="closeSerialNum" type="button" class="btn btn-danger btn-sm" style="display: none;" onclick="closeSn();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
                                    <div id="staticbuttondiv" display="display:none;">
                                        <button id="saveSerialNumSt" type="button" class="btn btn-info btn-sm">Add</button>
                                        <button id="closeSerialNumSt" type="button" class="btn btn-danger btn-sm" style="display: none;" onclick="closeSnSt();"><i class="fa fa-times" aria-hidden="true"></i></button>
                                    </div>
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
                                            <td><label style="font-size: 12px;">Total Qty </label></td>
                                            <td><label id="totalQuantityLbl" style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 12px;">Inserted </label></td>
                                            <td><label id="insertedQuantityLbl" style="font-size: 12px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 12px;">Remaining </label></td>
                                            <td><label id="remainingQuantityLbl" style="font-size: 12px;font-weight:bold;"></label></td>
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
                    <div id="dynamicTableDiv">        
                        <table id="laravel-datatable-crud-sn" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
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
                    <div id="staticTableDiv" style="display:none;">        
                        <table id="laravel-datatable-crud-snedit" class="display table-bordered table-striped table-hover dt-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
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
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="tableid" class="form-control" name="tableid" readonly="true"/>
                    <input type="hidden" id="serialnumreq" class="form-control" name="serialnumreq" readonly="true"/>
                    <input type="hidden" id="expirenumreq" class="form-control" name="expirenumreq" readonly="true"/>
                    <input type="hidden" id="seritemid" class="form-control" name="seritemid" readonly="true"/>
                    <input type="hidden" id="serheaderid" class="form-control" name="serheaderid" readonly="true"/>
                    <input type="hidden" id="serstoreid" class="form-control" name="serstoreid" readonly="true"/>
                    <input type="hidden" id="storeQuantity" class="form-control" name="storeQuantity" readonly="true"/>
                    <input type="hidden" id="commonserval" class="form-control" name="commonserval" readonly="true"/>
                    <input type="hidden" id="dynamicrownum" class="form-control" name="dynamicrownum" readonly="true"/>
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
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="sid" id="sid" readonly="true">
                            <input type="hidden" class="form-control" name="totalBegQuantity" id="totalBegQuantity" readonly="true">
                            <input type="hidden" class="form-control" name="dynamicdelval" id="dynamicdelval" readonly="true">
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

    <!--Start Static Serial Number Delete modal -->
    <div class="modal fade text-left" id="sernumDeleteModalSt" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteserialnumformst">
                    <div class="modal-body">
                        <label style="font-size: 16px;font-weight:bold;">Do you really want to delete?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="stid" id="stid" readonly="true">
                            <input type="hidden" class="form-control" name="totalBegQuantityst" id="totalBegQuantityst" readonly="true">
                            <input type="hidden" class="form-control" name="dynamicdelvalst" id="dynamicdelvalst" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteSerialNumberBtnSt" type="button" class="btn btn-info">Delete</button>
                        <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Static Serial Number Delete Modal -->

    <!-- add settlement info modal-->
    <div class="modal modal-slide-in event-sidebar fade" id="suppliermodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y:scroll;">
        <div class="modal-dialog sidebar-xl" style="width: 97%;">
            <form id="Register">
                <div class="modal-content p-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetsupplierform()">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title">Add Supplier</h5>
                    </div>
                    <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                        <div>
                            <div class="row">
                                <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <div class="divider">
                                        <div class="divider-text">Basic Information</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Supplier ID</label>
                                            <input type="text" placeholder="Supplier Id" class="form-control" name="CustomerId" id="Code" onkeyup="cusCodeCV();"  autofocus/>
                                            <input type="hidden" class="form-control" readonly="true" name="codetypeinput"
                                                id="codetypeinput" />
                                            <span class="text-danger">
                                                <strong id="id-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Category</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="CustomerCategory" id="CustomerCategory" onchange="cusCatCV()" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan/>
                                                    <option value="Supplier">Supplier</option>
                                                    <option value="Customer&Supplier">Customer&Supplier</option>
                                                    <option value="Foreigner-Supplier">Foreigner-Supplier</option>
                                                    <option value="Person">Person</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="cuscategory-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Supplier Name</label>
                                            <input type="hidden" placeholder="customerid" class="form-control" name="id" id="id" onkeyup="cusNameCV();" />
                                            <input type="text" placeholder="Supplier Name" class="form-control" name="name" id="name" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="cusNameCV();" />
                                            <span class="text-danger">
                                                <strong id="name-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="tinDiv">
                                            <label style="font-size: 14px;">TIN</label>
                                            <input type="number" placeholder="TIN Number" class="form-control tinrestriction" name="TinNumber" id="TinNumber" onkeypress="return ValidateOnlyNum(event);" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="countTinChar(this)" ondrop="return false;" onpaste="return false;" />
                                            <span class="text-danger">
                                                <strong id="tin-error"></strong>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="mrcDiv">
                                            <label style="font-size: 14px;">MRC</label>
                                            <input type="text" placeholder="MRC Number" class="form-control" name="MrcNumber" id="MRCNumber" onkeypress="return ValidateMrc(event);" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="countMrcChar(this)" ondrop="return false;" onpaste="return false;" />
                                            <span class="text-danger">
                                                <strong id="mrc-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="vatRegDiv">
                                            <label style="font-size: 14px;">VAT Registration No.</label>
                                            <input type="number" placeholder="VAT Registration Number" class="form-control" name="VatNumber" id="VatNumber" onkeypress="return ValidateOnlyNum(event);" @can('Edit-Transactions') ondblclick="adjustprop(this);" @endcan onkeyup="cusVATCV();" ondrop="return false;" onpaste="return false;" />
                                            <span class="text-danger">
                                                <strong id="VatNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="vatDiv" style="display: none;">
                                            <label style="font-size: 14px;">VAT Deduct</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="VatDeduct" id="VatType" onchange="cusVATDedCV()">
                                                    @foreach ($vats as $vt)
                                                        <option value="{{ $vt->Value }}">{{ $vt->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="VatDeduct-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="withDiv" style="display: none;">
                                            <label style="font-size: 14px;">Witholding Deduct</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="WitholdDeduct" id="Witholding" onchange="cusWithDedCV()">
                                                    @foreach ($witholds as $wh)
                                                        <option value="{{ $wh->Value }}">{{ $wh->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="WitholdDeduct-error"></strong>
                                            </span>
                                        </div>
                                        @can('Customer-Adjust-Default-Price')
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="defpaymentDiv">
                                                <label style="font-size: 14px;">Default Price</label>
                                                <div>
                                                    <select class="form-control"
                                                        data-style="btn btn-outline-secondary waves-effect" name="DefaultPayment"
                                                        id="DefaultPrice" onchange="cusDefPayCV()">
                                                        <option value="Retailer">Retailer</option>
                                                        <option value="Wholeseller">Wholeseller</option>
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="defaultpayment-error"></strong>
                                                </span>
                                            </div>
                                        @endcan
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="creditLimitPeriodDiv"
                                            style="display:none;">
                                            <label style="font-size: 14px;">Minimum Period(day) & Purchase Limit</label>
                                            <div class="input-group">
                                                <input type="number" placeholder="Input days" class="form-control" value="0"
                                                    name="CreditLimitPeriod" id="CreditLimitPeriod"
                                                    onkeyup="creditLimitPeriodVal()" onkeypress="return ValidateOnlyNum(event);"
                                                    ondrop="return false;" onpaste="return false;" readonly="true"
                                                    ondblclick="crPerLimitVal()" />
                                                <input type="number" placeholder="Credit Limit" class="form-control" value="0"
                                                    name="CreditLimit" id="CreditLimit" onkeyup="creditLimitVal()"
                                                    onkeypress="return ValidateNum(event);" ondrop="return false;"
                                                    onpaste="return false;" readonly="true" ondblclick="crLimitVal()" />
                                            </div>
                                            <div class="input-group">
                                                <span class="text-danger">
                                                    <strong id="creditlimitperiod-error"></strong>
                                                </span>
                                                <span class="text-danger">
                                                    <strong id="creditlimit-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-0 col-md-6 col-sm-12 mb-2" id="creditLimitDiv" style="display:none;">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="allowedcrsales">
                                            <label style="font-size: 14px;">Credit Sales</label>
                                            <div>
                                                <select class="form-control" data-style="btn btn-outline-secondary waves-effect" name="IsAllowedCreditSales" id="IsAllowedCreditSales">
                                                    <option selected disabled value="">-Select here-</option>
                                                    @can('Change-Credit-Sales-Option')<option value="Allow">Allow</option>@endcan
                                                    <option value="Not-Allowed">Not-Allow</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="allowedcreditsales-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;">
                                            <label style="font-size: 14px;">Credit Sales Min Amount</label>
                                            <div>
                                                <input type="number" class="form-control crdprop" name="CreditSalesLimitStart" id="CreditSalesLimitStart" onkeyup="creditlimitstart()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credminval()"/>
                                                <span class="text-danger">
                                                    <strong id="creditlimitstart-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;" ondblclick="unlimiteddblcl()">
                                            <label style="font-size: 14px;">Credit Sales Max Amount</label>
                                            <div>
                                                <input type="number" class="form-control crdprop" name="CreditSalesLimitEnd" id="CreditSalesLimitEnd" onkeyup="creditlimitend()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credmaxval()"/>
                                                <span>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <input class="unlimitcreditslcbx" name="unlimitcreditslcbx" type="checkbox" id="unlimitcreditslcbx"/>
                                                            <label class="col-form-label" for="unlimitcreditslcbx" style="font-size: 11px;">Unlimit credit sales</label>
                                                        </div>
                                                    </div>
                                                    <strong class="text-danger" id="creditlimitend-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;">
                                            <label style="font-size: 14px;">Credit Sales Payment Term</label>
                                            <div>
                                                <input type="number" class="form-control crdprop" name="CreditSalesLimitDay" id="CreditSalesLimitDay" onkeyup="creditslimitval()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credlimitdayval()"/>
                                                <span class="text-danger">
                                                    <strong id="creditslimit-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;">
                                            <label style="font-size: 14px;">Credit Sales Additional %</label>
                                            <div>
                                                <input type="number" class="form-control crdprop" name="CreditSalesAdditionPercentage" id="CreditSalesAdditionPercentage" onkeyup="creditsalesaddval()" onkeypress="return ValidateOnlyNum(event);" ondblclick="credsalesperval()"/>
                                                <span class="text-danger">
                                                    <strong id="creditsalesadd-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2 creditprop" style="display: none;" ondblclick="settdblval()">
                                            <label style="font-size:14px;" for="settleallouts">Settle All Previous Outstanding for New Credit Sales</label>
                                            <div>
                                                <div id="settlecbxdiv">
                                                    <input name="settleallouts" id="settleallouts" type="checkbox" readonly="readonly" ondblclick="settdblval()"/>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="isprevioussalespaid-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Address Information & Other Information</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Phone Number</label>
                                            <input type="text" placeholder="Phone or Mobile Number" class="form-control"
                                                name="PhoneNumber" id="PhoneNumber" onkeypress="return ValidatePhone(event);"
                                                onkeyup="cusPhoneCV()" />
                                            <span class="text-danger">
                                                <strong id="PhoneNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Office Phone Number</label>
                                            <input type="text" placeholder="Office Phone Number" class="form-control"
                                                name="OfficePhoneNumber" id="OfficePhone"
                                                onkeypress="return ValidatePhone(event);" onkeyup="cusOffPhoneCV()" />
                                            <span class="text-danger">
                                                <strong id="OfficePhoneNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Email</label>
                                            <input type="text" placeholder="Email Address" class="form-control"
                                                name="EmailAddress" id="EmailAddress" onkeyup="ValidateEmail(this);" />
                                            <span class="text-danger">
                                                <strong id="email-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Address</label>
                                            <input type="text" placeholder="Address" class="form-control" name="Address"
                                                id="Address" onkeyup="cusAddressv()" />
                                            <span class="text-danger">
                                                <strong id="Address-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Website</label>
                                            <input type="text" placeholder="Website" class="form-control" name="Website"
                                                id="Website" onkeyup="ValidateWebsite(this);" />
                                            <span class="text-danger">
                                                <strong id="Website-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Country</label>
                                            <div>
                                                <select class="select2 form-control" name="Country"
                                                    id="Country" onchange="cusCountryVC()">
                                                    @foreach ($counrtys as $cn)
                                                        <option value="{{ $cn->Name }}">{{ $cn->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="Country-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Memo</label>
                                            <textarea type="text" placeholder="Write Memo here..." class="form-control"
                                                rows="2" name="Memo" id="Memo" onkeyup="cusMemoV()"></textarea>
                                            <span class="text-danger">
                                                <strong id="Memo-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2">
                                            <label style="font-size: 14px;">Status</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="CustomerStatus" id="ActiveStatus"
                                                    aria-errormessage="Select Status" onchange="customerstatusCV()">
                                                    <option value="Active">Active</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="status-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="ReasonDiv">
                                            <label style="font-size: 14px;">Reason</label>
                                            <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="1" name="Reason" id="Reason" onkeyup="cusReasonV()"></textarea>
                                            <span class="text-danger">
                                                <strong id="Reason-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="creditminlimithidden" id="creditminlimithidden" readonly="true" value="{{ $setting->CreditSalesLimitStart }}"/>
                        <input type="hidden" class="form-control" name="creditmaxlimithidden" id="creditmaxlimithidden" readonly="true" value="{{ $setting->CreditSalesLimitEnd }}"/>
                        <input type="hidden" class="form-control" name="creditlimitdayhidden" id="creditlimitdayhidden" readonly="true" value="{{ $setting->CreditSalesLimitDay }}"/>
                        <input type="hidden" class="form-control" name="creditsalesadditionhidden" id="creditsalesadditionhidden" readonly="true" value="{{ $setting->CreditSalesAdditionPercentage }}"/>
                        <input type="hidden" class="form-control" name="unlimitflag" id="unlimitflag" readonly="true" value="{{ $setting->CreditSalesLimitFlag }}"/>
                        <input type="hidden" class="form-control" name="settleoutstanding" id="settleoutstanding" readonly="true" value="{{ $setting->SettleAllOutstanding }}"/>
                        <input type="hidden" class="form-control" name="dprice" id="dprice" value="Retailer" />
                        @can('Customer-Add')
                            <button id="savenewbutton" type="button" class="btn btn-info">Save</button>
                        @endcan
                        <button id="closebuttonab" type="button" class="btn btn-danger" onclick="resetsupplierform()" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--/ add settlement info modal-->

    <!--Start Comment modal -->
    <div class="modal fade text-left" id="backtodraftmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeBackToDraftFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backtodraftform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;">Comment</label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="Comment" id="Comment" onkeyup="commentValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="comment-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="commentid" id="commentid" readonly="true">
                        <button id="backtodraftbtn" type="button" class="btn btn-info">Back to Draft</button>
                        <button id="closebuttonh" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeBackToDraftFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Comment modal -->

    <!--Start Back to Pending modal -->
    <div class="modal fade text-left" id="backtopendingmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeBackToPendingFn()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="backtopendingform">
                    @csrf
                    <div class="modal-body">
                        <label style="font-size: 14px;">Comment</label>
                        <div class="form-group">
                            <textarea type="text" placeholder="Write Comment here..." class="form-control" rows="3" name="BackToPendingComment" id="BackToPendingComment" onkeyup="backToPenValFn()"></textarea>
                            <span class="text-danger">
                                <strong id="backtopending-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control" name="backtopendingid" id="backtopendingid" readonly="true">
                        <button id="backtopendingbtn" type="button" class="btn btn-info">Back to Pending</button>
                        <button id="closebacktopending" type="button" class="btn btn-danger" data-dismiss="modal" onclick="closeBackToPendingFn()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Back to Pending modal -->

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        var voideditor;
        var fyears = $('#fiscalyear').val();
        var cus_fyears = $('#cus_fiscalyear').val();

        $(function () {
            cardSection = $('#page-block');
        });

        function formatText (icon) {
            return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
        };

        // $('#supplier').select2({
        //     templateSelection: formatText,
        //     templateResult: formatText,
        // });

        function getReceivingData(fyears){
            $('#fiscalyear_div').hide();
            $('#owner_dt').hide();

            var table =$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/receivingtable/1/'+fyears,
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
                },

                columns: [{
                        data: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"11%"
                    },
                    {
                        data: 'ProductType',
                        name: 'ProductType',
                        width:"10%"
                    },
                    {
                        data: 'Reference',
                        name: 'Reference',
                        width:"10%"
                    },
                    {
                        data: 'porderno',
                        name: 'porderno',
                        width:"11%"
                    },
                    {
                        data: 'CustomerName',
                        name: 'CustomerName',
                        width:"11%"
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:"10%"
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"10%"
                    },
                    {
                        data: 'ReceivedDate',
                        name: 'ReceivedDate',
                        width:"10%"
                    },
                    {
                        data: 'Status',name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            
                            else if((data == "Confirmed" || data == "Confirmed(Returned)") && (row.InvoiceStatus==0 || row.InvoiceStatus==1)){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if((data == "Confirmed" || data == "Confirmed(Returned)") && row.InvoiceStatus==2){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Confirmed)" || data == "Void(Received)"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"10%"
                    },
                    {
                        data: 'action',
                        width:"4%"
                    }
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        @if (auth()->user()->can('Receiving-Add'))
                            <button type="button" class="btn btn-gradient-info btn-sm addrecprocbutton" data-toggle="modal">Add</button>
                        @endif
                    `);
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
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
           
            var htable=$('#laravel-datatable-crud-hold').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [50,100],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-3 col-md-10 col-xs-1'f><'col-lg-2 col-md-2 col-xs-12'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-6'><'col-sm-12 col-md-2'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/holdtable/'+fyears,
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
                        data: 'DocumentNumber',
                        name: 'DocumentNumber'
                    },
                    {
                        data: 'CustomerCategory',
                        name: 'CustomerCategory'
                    },
                    {
                        data: 'CustomerName',
                        name: 'CustomerName'
                    },
                    {
                        data: 'TIN',
                        name: 'TIN'
                    },
                    {
                        data: 'PaymentType',
                        name: 'PaymentType'
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName'
                    },
                    {
                        data: 'VoucherType',
                        name: 'VoucherType'
                    },
                    {
                        data: 'CustomerMRC',
                        name: 'CustomerMRC'
                    },
                    {
                        data: 'VoucherNumber',
                        name: 'VoucherNumber'
                    },
                    {
                        data: 'InvoiceNumber',
                        name: 'InvoiceNumber'
                    },                   
                    {
                        data: 'TransactionDate',
                        name: 'TransactionDate'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        }

        function getCustomerData(fyears){
            $('#cus_fiscalyear_div').hide();
            $('#customer_dt').hide();

            $('#customer-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                responsive: true,
                searchHighlight: true,
                "order": [[0, "desc"]],
                "pagingType": "simple",
                "lengthMenu": [50,100],
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons2'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/receivingtable/2/'+fyears,
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
                },
                columns: [{
                        data: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"10%"
                    },
                    {
                        data: 'ProductType',
                        name: 'ProductType',
                        width:"8%"
                    },
                    {
                        data: 'Reference',
                        name: 'Reference',
                        width:"8%"
                    },
                    {
                        data: 'porderno',
                        name: 'porderno',
                        width:"8%"
                    },
                    {
                        data: 'CusorOwner',
                        name: 'CusorOwner',
                        width:"14%"
                    },
                    {
                        data: 'CustomerName',
                        name: 'CustomerName',
                        width:"14%"
                    },
                    {
                        data: 'TIN',
                        name: 'TIN',
                        width:"8%"
                    },
                    {
                        data: 'StoreName',
                        name: 'StoreName',
                        width:"8%"
                    },
                    {
                        data: 'ReceivedDate',
                        name: 'ReceivedDate',
                        width:"8%"
                    },
                    {
                        data: 'Status',name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Draft"){
                                return '<span class="badge bg-secondary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Pending"){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Verified"){
                                return '<span class="badge bg-primary bg-glow">'+data+'</span>';
                            }
                            else if(data == "Confirmed" && (row.InvoiceStatus==0 || row.InvoiceStatus==1)){
                                return '<span class="badge bg-warning bg-glow">'+data+'</span>';
                            }
                            else if(data == "Confirmed" && row.InvoiceStatus==2){
                                return '<span class="badge bg-success bg-glow">'+data+'</span>';
                            }
                            else if(data == "Void" || data == "Void(Draft)" || data == "Void(Pending)" || data == "Void(Verified)" || data == "Void(Confirmed)" || data == "Void(Received)"){
                                return '<span class="badge bg-danger bg-glow">'+data+'</span>';
                            }
                            else{
                                return '<span class="badge bg-dark bg-glow">'+data+'</span>';
                            }
                        },
                        width:"7%"
                    },
                    {
                        data: 'action',
                        width:"4%"
                    }
                ],
                "initComplete": function () {
                    $('.custom-buttons2').html(`
                        @if (auth()->user()->can('Receiving-Add'))
                            <button type="button" class="btn btn-gradient-info btn-sm addrecprocbutton" data-toggle="modal">Add</button>
                        @endif
                    `);
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
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
            $.fn.dataTable.ext.errMode = 'throw';
        }

        //Start page load
        $(document).ready(function() {
            $('#fiscalyear').select2();
            $('#cus_fiscalyear').select2();
            getReceivingData(fyears);
            getCustomerData(fyears);
            $("#ManufactureDate").datepicker({ dateFormat:"yy-mm-dd",changeYear:true,changeMonth:true,yearRange: "1990:2099"}).datepicker();
            $("#ExpireDate").datepicker({ dateFormat:"yy-mm-dd",changeYear:true,changeMonth:true,yearRange: "1990:2099"}).datepicker();
            $('#infoCardDiv').hide();
            $('#invoicenumberdiv').hide();
            $('#mrcDiv').hide();
            $('#itemInfoCardDiv').hide();
            $('#pricingTable').hide();
            $('#changetopending').hide();
            $('#checkreceiving').hide();
            $('#confirmreceiving').hide();
            $('#iteminfocard').hide();
            $("#beforetax").attr("disabled", true);
            $("#taxamount").attr("disabled", true);
            $("#total").attr("disabled", true);
            $("#beforetax").css("font-weight","Bold");
            $("#taxamount").css("font-weight","Bold");
            $("#total").css("font-weight", "Bold");
            $("#beforetaxhold").css("font-weight", "Bold");
            $("#taxamounthold").css("font-weight", "Bold");
            $("#totalcosthold").css("font-weight", "Bold");
            $('#recId').val("");
            $('#recevingedit').val("");
            var today = new Date();
            var dd = today.getDate();
            var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : +(today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate = yyyy + "-" + mm + "-" + dd;

            $("#dynamicTable").show();
            $("#adds").show();
            $("#holdEditTable").hide();
            $("#receivingEditTable").hide();
            $("#holdEditDiv").hide();
            $("#receivingEditDiv").hide();
            $("#addhold").hide();
            $("#addreceiving").hide();
            $("#saveHoldbutton").hide();
            $("#savebutton").show();
            $("#holdbutton").show();
            $('#tid').val("");
            $('#receivingId').val("");
            $('#recevingedit').val("");
            $('#editVal').val("0");
            $("#voucherType option[value=Declarasion]").hide();
            $("#voucherType option[value=Fiscal-Receipt]").show();
            $("#voucherType option[value=Manual-Receipt]").show();
            $(".selectpicker").selectpicker({
                noneSelectedText: ''
            });
            $("#printgrvdiv").show();
            $("#witholdingTr").hide();
            $("#netpayTr").hide();

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $.fn.dataTable
                    .tables({ visible: true, api: true })
                    .columns.adjust();
            });
        });
        //End page load

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#laravel-datatable-crud-hold tbody').on('click', 'tr', function () {
            if($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            }
            else {
                $('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        //Reset forms or modals starts
        function closeModalWithClearValidation() {
            $("#RegisterRec")[0].reset();
            $('#infoCardDiv').hide();
            $('#itemInfoCardDiv').hide();
            $('#mrcDiv').hide();
            $('#supplier').val(null).trigger('change');
            $('#store').val(null).trigger('change');
            $('#supplier-error').html("");
            $('#paymentType-error').html("");
            $('#voucherType-error').html("");
            $('#voucherNumber-error').html("");
            $('#mrcNumber-error').html("");
            $('#date-error').html("");
            $('#store-error').html("");
            $('#purchaser-error').html("");
            var today = new Date();
            var dd = today.getDate();
            var mm = ((today.getMonth().length + 1) === 1) ? (today.getMonth() + 1) : +(today.getMonth() + 1);
            var yyyy = today.getFullYear();
            var formatedCurrentDate = yyyy + "-" + mm + "-" + dd;
            $('#subtotalLbl').html("0");
            $('#taxLbl').html("0");
            $('#grandtotalLbl').html("0");
            $('#witholdingAmntLbl').html("0");
            $('#netpayLbl').html("0");
            $('#numberofItemsLbl').html("0");
            $('#subtotali').val("0");
            $('#taxi').val("0");
            $('#grandtotali').val("0");
            $("#dynamicTable > tbody").empty();
            $('#pricingTable').hide();
            $("#dynamicTable").show();
            $("#adds").show();
            $("#holdEditTable").hide();
            $("#addhold").hide();
            $("#receivingEditTable").hide();
            $("#holdEditDiv").hide();
            $("#receivingEditDiv").hide();
            $("#addreceiving").hide();
            $('#tid').val("");
            $('#receivingId').val("");
            $("#saveHoldbutton").hide();
            $("#savebutton").show();
            $("#holdbutton").show();
            $("#printgrvdiv").show();
            $('#Purchaser').val(null).trigger('change');
            $('#MrcNumber').val(null).trigger('change');
            $("#checkboxVali").val("1");
            $("#operationtypes").val("1");
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $("#invoicenumberdiv").hide();
            $("#InvoiceNumber").val("");
            $("#invoiceNumber-error").html("");
            $("#voucherstatus-error").html("");
            $("#Memo").val("");
            $('#docinfolbl').html("FS Number");
            $("#voucherType option[value=Declarasion]").hide();
            $("#voucherType option[value=Fiscal-Receipt]").show();
            $("#voucherType option[value=Manual-Receipt]").show();
            $('#documentuploadlinkbtn').hide();
            //$("#dynamicTable").append('<tr><th style="width:3%;">#</th><th style="width:25%">Item Name</th><th style="width:10%">UOM</th><th style="width:11%">Quantity</th><th style="width:12%">Unit Cost</th><th style="width:12%">Before Tax</th><th style="width:12%">Tax Amount</th><th style="width:12%">Total Cost</th><th style="width:3%"></th>');
        }
        //Reset forms or modals ends

        //Start get customer info
        $(document).ready(function() {
            $('#supplier').on('change', function() {
                var sid = $('#supplier').val();
                var voucherTypeVar = $('#voucherType').val();
                if(sid=="supp01"){
                    addsupplier();
                }
                else{
                    $.get("/showSupplierInfo" + '/' + sid, function(data) {
                        var len = data.length;
                        for (var i = 0; i <= len; i++) {
                            var supNameVar = (data[i].Name);
                            var supCategoryVar = (data[i].CustomerCategory);
                            var supTinNumberVar = (data[i].TinNumber);
                            var supVatNumberVar = (data[i].VatNumber);
                            $('#nameInfoLbl').text(supNameVar);
                            $('#categoryInfoLbl').text(supCategoryVar);
                            $('#tinInfoLbl').text(supTinNumberVar);
                            $('#vatInfoLbl').text(supVatNumberVar);
                            $('#infoCardDiv').show();
                            if ((supCategoryVar === "Supplier" || supCategoryVar ==="Customer&Supplier") && voucherTypeVar === "Fiscal-Receipt") {
                                $("#voucherType option[value=Fiscal-Receipt]").show();
                                $("#voucherType option[value=Manual-Receipt]").show();
                                $("#voucherType option[value=Declarasion]").hide();
                                $("#netpayin").val($("#netpayLbl").text());
                                $("#witholdingAmntin").val($("#witholdingAmntLbl").text());
                            }
                           
                            else if (supCategoryVar != "Foreigner-Supplier" && voucherTypeVar ==="Manual-Receipt") {
                                $('#invoicenumberdiv').hide();
                                $('#MrcNumber').val(null).trigger('change');
                                $("#voucherType option[value=Fiscal-Receipt]").show();
                                $("#voucherType option[value=Manual-Receipt]").show();
                                $("#voucherType option[value=Declarasion]").hide();
                                $("#netpayin").val($("#netpayLbl").text());
                                $("#witholdingAmntin").val($("#witholdingAmntLbl").text());
                            } else if (supCategoryVar === "Foreigner-Supplier") {
                                $('#invoicenumberdiv').hide();
                                $('#MrcNumber').val(null).trigger('change');
                                $("#voucherType option[value=Fiscal-Receipt]").hide();
                                $("#voucherType option[value=Manual-Receipt]").hide();
                                $("#voucherType").val("Declarasion");
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide();
                                $("#netpayin").val("0");
                                $("#witholdingAmntin").val("0");
                            } else {
                                //$('#MrcNumber').val(null).trigger('change');
                                $("#voucherType option[value=Fiscal-Receipt]").show();
                                $("#voucherType option[value=Manual-Receipt]").show();
                                $("#voucherType option[value=Declarasion]").hide();
                                $("#witholdingTr").show();
                                $("#netpayTr").show();
                                $("#netpayin").val($("#netpayLbl").text());
                                $("#witholdingAmntin").val($("#witholdingAmntLbl").text());
                            }
                            CalculateGrandTotal();
                        }
                    });

                    $('#MrcNumber').find('option').not(':first').remove();
                    var registerForm = $("#RegisterRec");
                    var formData = registerForm.serialize();
                    $.ajax({
                        url: 'showMRCInfo/' + sid,
                        type: 'DELETE',
                        data: formData,
                        success: function(data) {
                            if (data.mrc) {
                                var len = data['mrc'].length;
                                for (var i = 0; i <= len; i++) {
                                    var name = data['mrc'][i].MRCNumber;
                                    var option = "<option value='" + name + "'>" + name +"</option>";
                                    $("#MrcNumber").append(option);
                                }
                                $('#MrcNumber').select2
                                ({
                                    placeholder: "Select MRC here",
                                });
                            }
                        },
                    });
                    
                }
            });
        });
        //End get customer info

        //Start get item info
        $(document).ready(function() {
            $('#itemNameSl').on('change', function() {
                var sid = $('#itemNameSl').val();
                $.get("/showItemInfo" + '/' + sid, function(data) {
                    var len = data.length;
                    for (var i = 0; i <= len; i++) {
                        var itemCodeVar = (data[i].Code);
                        var itemTypeVar = (data[i].Type);
                        var itemNameVar = (data[i].Name);
                        var itemUOMVar = (data[i].UOM);
                        var itemCategoryVar = (data[i].Category);
                        var itemRpVar = (data[i].RetailerPrice);
                        var itemWsVar = (data[i].WholesellerPrice);
                        var itemPnVar = (data[i].PartNumber);
                        var itemSnVar = (data[i].SKUNumber);
                        var itemTaxVar = (data[i].TaxTypeId);
                        $('#itemcodeInfoLbl').text(itemCodeVar);
                        $('#itemInfoLbl').text(itemTypeVar);
                        $('#itemInfoLbl').text(itemNameVar);
                        $('#uomInfoLbl').text(itemUOMVar);
                        $('#itemCategoryInfoLbl').text(itemCategoryVar);
                        $('#rpInfoLbl').text(itemRpVar);
                        $('#wsInfoLbl').text(itemWsVar);
                        $('#partNumInfoLbl').text(itemPnVar);
                        $('#skuInfoLbl').text(itemSnVar);
                        $('#taxInfoLbl').text(itemTaxVar);
                        $('#itemInfoCardDiv').show();
                    }
                })
            });
        });
        //End get item info

        //Start Show Item Info
        function showItemInfos(sid){
            //var sid = $(this).data('id');
            $.get("/showItemInfo" + '/' + sid, function(data) {
                var len = data.length;
                for (var i = 0; i <= len; i++) {
                    var itemCodeVar = (data[i].Code);
                    var itemTypeVar = (data[i].Type);
                    var itemNameVar = (data[i].Name);
                    var itemUOMVar = (data[i].UOM);
                    var itemCategoryVar = (data[i].Category);
                    var itemRpVar = (data[i].RetailerPrice);
                    var itemWsVar = (data[i].WholesellerPrice);
                    var itemPnVar = (data[i].PartNumber);
                    var itemSnVar = (data[i].SKUNumber);
                    var itemTaxVar = (data[i].TaxTypeId);
                    $('#itemcodeInfoLbl').text(itemCodeVar);
                    $('#itemInfoLbl').text(itemTypeVar);
                    $('#itemInfoLbl').text(itemNameVar);
                    $('#uomInfoLbl').text(itemUOMVar);
                    $('#itemCategoryInfoLbl').text(itemCategoryVar);
                    $('#rpInfoLbl').text(itemRpVar);
                    $('#wsInfoLbl').text(itemWsVar);
                    $('#partNumInfoLbl').text(itemPnVar);
                    $('#skuInfoLbl').text(itemSnVar);
                    $('#taxInfoLbl').text(itemTaxVar);
                    $('#itemInfoCardDiv').show();
                }
            });
        }
        //End Show Item Info
        
        function itemNameHoldVal() {
            var sid = $("#addHoldItem").val();
            $("#uoms").empty();
            var registerForm = $("#RegisterRec");
            var formData = registerForm.serialize();
            $.ajax({
                url: 'getUOMS/' + sid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    if (data.sid) {
                        var retailer = data['retailer'];
                        var wholeseller = data['wholeseller'];
                        var taxper = data['taxpr'];
                        var itemtype = data['itemtype'];
                        var lastcost = data['lastCost'];
                        $("#taxpercenti").val(taxper);
                        $("#retailerpricei").val(retailer);
                        $("#wholeselleri").val(wholeseller);
                        var defname = data['defuom'];
                        var defid = data['defuomid'];
                        var option = "<option selected value='" + defid + "'>" + defname + "</option>";
                        $("#uoms").append(option);
                        $("#defaultuomi").val(defid);
                        $("#newuomi").val(defid);
                        $("#convertedamnti").val("1");
                        $("#itemtypei").val(itemtype);
                        $("#unitcosthold").val(lastcost);
                        CalculateAddHoldTotal(this);
                        var len = data['sid'].length;
                        for (var i = 0; i <= len; i++) {
                            var name = data['sid'][i].ToUnitName;
                            var id = data['sid'][i].ToUomID;
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $("#uoms").append(option);
                        }
                        $("#uoms").select2();

                    }
                },
            });

            $('#addholdItem-error').html("");
        }
        //Start Show Item Info
        function itemVal(ele) {
            var sid = $(ele).closest('tr').find('.itemName').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            var arr = [];
            var found = 0;
            $('.itemName').each (function() 
            { 
                var name=$(this).val();
                if(arr.includes(name))
                found++;
                else
                arr.push(name);
            });
            
            if(found) 
            {
                toastrMessage('error',"Item already exist","Error");
                $(ele).closest('tr').find('.itemName').val("0").trigger('change');
                $(ele).closest('tr').find('.ItemType').val("");
                $(ele).closest('tr').find('.RetailerPrice').val("");
                $(ele).closest('tr').find('.Wholeseller').val("");
                $(ele).closest('tr').find('.tax').val("");
                $(ele).closest('tr').find('.RequireSerialNumber').val("");
                $(ele).closest('tr').find('.RequireExpireDate').val("");
                $(ele).closest('tr').find('.uom').empty();
                $(ele).closest('tr').find('.quantity').val("");
                $(ele).closest('tr').find('.beforetax').val("");
                $(ele).closest('tr').find('.taxamount').val("");
                $(ele).closest('tr').find('.total').val("");
                $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',errorcolor);
                CalculateGrandTotal();
            }
            else{
                $.get("/showItemInfo" + '/' + sid, function(data) {
                var len = data.length;
                for (var i = 0; i <= len; i++) {
                    var itemCodeVar = (data[i].Code);
                    var itemTypeVar = (data[i].Type);
                    var itemNameVar = (data[i].Name);
                    var itemUOMVar = (data[i].UOM);
                    var itemCategoryVar = (data[i].Category);
                    var itemRpVar = (data[i].RetailerPrice);
                    var itemWsVar = (data[i].WholesellerPrice);
                    var itemPnVar = (data[i].PartNumber);
                    var itemSnVar = (data[i].SKUNumber);
                    var itemTaxVar = (data[i].TaxTypeId);
                    var reqsn = (data[i].RequireSerialNumber);
                    var reqed = (data[i].RequireExpireDate);                    
                    $('#itemcodeInfoLbl').text(itemCodeVar);
                    $('#itemInfoLbl').text(itemTypeVar);
                    $('#itemInfoLbl').text(itemNameVar);
                    $('#uomInfoLbl').text(itemUOMVar);
                    $('#itemCategoryInfoLbl').text(itemCategoryVar);
                    $('#rpInfoLbl').text(itemRpVar);
                    $('#wsInfoLbl').text(itemWsVar);
                    $('#partNumInfoLbl').text(itemPnVar);
                    $('#skuInfoLbl').text(itemSnVar);
                    $('#taxInfoLbl').text(itemTaxVar);
                    $('#itemInfoCardDiv').show();
                    $(ele).closest('tr').find('.addsernum').attr('title','Add serial number or expire date for '+itemCodeVar+' ,   '+itemNameVar+' ,   '+itemSnVar+' item!');
                    $(ele).closest('tr').find('.ItemType').val(itemTypeVar);
                    $(ele).closest('tr').find('.RetailerPrice').val(itemRpVar);
                    $(ele).closest('tr').find('.Wholeseller').val(itemWsVar);
                    $(ele).closest('tr').find('.tax').val(itemTaxVar);
                    $(ele).closest('tr').find('.RequireSerialNumber').val(reqsn);
                    $(ele).closest('tr').find('.RequireExpireDate').val(reqed);
                    $(ele).closest('tr').find('.uom').empty();
                    $(ele).closest('tr').find('.quantity').val("");
                    $(ele).closest('tr').find('.beforetax').val("");
                    $(ele).closest('tr').find('.taxamount').val("");
                    $(ele).closest('tr').find('.total').val("");
                    if(reqsn!="Not-Require"||reqed!="Not-Require"){
                        $(ele).closest('tr').find('.addsernum').show();
                    }
                    CalculateGrandTotal();
                }
            });
            var registerForm = $("#RegisterRec");
            var formData = registerForm.serialize();
            $.ajax({
                url: 'getUOMS/' + sid,
                type: 'DELETE',
                data: formData,
                success: function(data) {
                    if (data.sid) {
                        var defname = data['defuom'];
                        var defid = data['defuomid'];
                        var lastcost = data['lastCost'];
                        var taxper = data['taxpr'];
                        if(parseFloat(lastcost)>0){
                            $('#unitcost'+idval).css("background","white");
                            $(ele).closest('tr').find('.unitcost').css("background","white");
                        }
                        $("#taxpercenti").val(taxper);
                        $(ele).closest('tr').find('.unitcost').val(lastcost);
                        var option = "<option selected value='" + defid + "'>" + defname + "</option>";
                        $(ele).closest('tr').find('.uom').append(option);
                        $(ele).closest('tr').find('.DefaultUOMId').val(defid);
                        $(ele).closest('tr').find('.NewUOMId').val(defid);
                        $(ele).closest('tr').find('.ConversionAmount').val("1");
                        var len = data['sid'].length;
                        for (var i = 0; i <= len; i++) {
                            var name = data['sid'][i].ToUnitName;
                            var id = data['sid'][i].ToUomID;
                            var option = "<option value='" + id + "'>" + name + "</option>";
                            $(ele).closest('tr').find('.uom').append(option);
                        }
                        $(ele).closest('tr').find('.uom').select2();
                    }
                },
            });
            $('#select2-itemNameSl'+idval+'-container').parent().css('background-color',"white");
        }
        }
        //End Show Item Info

        //Start UOM Change
        function uomsavedVal(ele) {
            var uomnewval = $('#uoms').val();
            $('#newuomi').val(uomnewval);
            var uomdefval = $('#defaultuomi').val();
            if (parseFloat(uomnewval) == parseFloat(uomdefval)) {
                $('#convertedamnti').val("1");
            } else if (parseFloat(uomnewval) != parseFloat(uomdefval)) {
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getUOMAmount/' + uomdefval + "/" + uomnewval,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var amount = data['sid'];
                            $('#convertedamnti').val(amount);
                        }
                    },
                });
            }
            $('#convertedqi').val("");
            $('#quantityhold').val("");
        }
        //End UOM change

        //Start UOM Change
        function uomVal(ele) {
            var uomnewval = $(ele).closest('tr').find('.uom').val();
            $(ele).closest('tr').find('.NewUOMId').val(uomnewval);
            var uomdefval = $(ele).closest('tr').find('.DefaultUOMId').val();
            if (parseFloat(uomnewval) == parseFloat(uomdefval)) {
                $(ele).closest('tr').find('.ConversionAmount').val("1");
            } else if (parseFloat(uomnewval) != parseFloat(uomdefval)) {
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getUOMAmount/' + uomdefval + "/" + uomnewval,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var amount = data['sid'];
                            $(ele).closest('tr').find('.ConversionAmount').val(amount);
                        }
                    },
                });
            }
            $(ele).closest('tr').find('.quantity').val("");
            $(ele).closest('tr').find('.ConvertedQuantity').val("");
        }
        //End UOM change

        //Add serial no or batch no or expire date
        function addser(ele){
            var itemnames="";
            var optype=$("#operationtypes").val();
            var headerid = $("#receivingId").val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            var itemid = $(ele).closest('tr').find('.itemName').val();
            var storeid = $(ele).closest('tr').find('.storeid').val();
            var common = $(ele).closest('tr').find('.common').val();
            var reqsnm = $(ele).closest('tr').find('.RequireSerialNumber').val();
            var reqexd = $(ele).closest('tr').find('.RequireExpireDate').val();
            var vals = $(ele).closest('tr').find('.vals').val();
            var inserted = $(ele).closest('tr').find('.insertedqty').val();
            var itemname = $(ele).closest('tr').find('.itemName :selected').text();
            $(".itemName :selected").each(function() {
                itemnames+=this.text+" , ";
            });
            if(parseFloat(optype)==1){
                $("#serialnumbertitle").html("Register Serial number , Batch number or Expire date for <b><u>"+itemname+"<u></b>");
                quantity = quantity == '' ? 0 : quantity;
                if(quantity==0){
                    toastrMessage('error',"Please insert quantity first","Error");
                }
                else{
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
                    $("#serialnumreq").val(reqsnm);
                    $("#expirenumreq").val(reqexd);
                    $("#tableid").val("");
                    $("#seritemid").val(itemid);
                    $("#serstoreid").val(storeid);
                    $("#storeQuantity").val(quantity);
                    $("#commonserval").val(common);
                    $("#dynamicrownum").val(vals);
                    var remaining=parseFloat(quantity)-parseFloat(inserted);
                    $("#totalQuantityLbl").html(quantity);
                    $("#insertedQuantityLbl").html(inserted);
                    $("#remainingQuantityLbl").html(remaining);
                    $("#serialNumberModal").modal('show');
                    $("#staticTableDiv").hide();
                    $("#dynamicTableDiv").show();
                    $("#staticbuttondiv").hide();
                    $("#dynamicbuttondiv").show();   
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
                            url: '/showSerialNmRec/'+common+'/'+itemid,
                            type: 'GET',
                            },
                        columns: [
                            { data: 'id', name: 'id', 'visible': false },
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
                }
            }
            else if(parseFloat(optype)==2){
                $("#serialnumbertitle").html("Register Serial number , Batch number or Expire date for <b><u>"+itemname+"<u></b>");
                quantity = quantity == '' ? 0 : quantity;
                if(quantity==0){
                    toastrMessage('error',"Please insert quantity first","Error");
                }
                else{
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
                    $("#serialnumreq").val(reqsnm);
                    $("#expirenumreq").val(reqexd);
                    $("#tableid").val("");
                    $("#serheaderid").val(headerid);
                    $("#seritemid").val(itemid);
                    $("#serstoreid").val(storeid);
                    $("#storeQuantity").val(quantity);
                    var remaining=parseFloat(quantity)-parseFloat(inserted);
                    $("#totalQuantityLbl").html(quantity);
                    $("#insertedQuantityLbl").html(inserted);
                    $("#remainingQuantityLbl").html(remaining);
                    $("#serialNumberModal").modal('show');
                    $("#staticTableDiv").show();
                    $("#dynamicTableDiv").hide();
                    $("#staticbuttondiv").show();
                    $("#dynamicbuttondiv").hide();
                    $('#laravel-datatable-crud-snedit').DataTable({
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
                            url: '/showSerialNmRecStatic/'+headerid+'/'+itemid,
                            type: 'GET',
                            },
                        columns: [
                            { data: 'id', name: 'id', 'visible': false },
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
                }
            }  
        }
        //End serial no or batch no or expire date

        //Add serial no or batch no or expire date

        $('.addSerialnumbes').click(function() {
            var quantity = $(this).data('qnt');
            var headerid = $(this).data('headerid');
            var itemid = $(this).data('itemid');
            var storeid = $(this).data('storeid');
            var reqsnm = $(this).data('reqsn');
            var reqexd = $(this).data('reqed');
            var inserted = $(this).data('itemcnt');
            var itemname = $(this).data('itmname');
            $("#serialnumbertitle").html("Register Serial number , Batch number or Expire date for <b><u>"+itemname+"<u></b>");
            quantity = quantity == '' ? 0 : quantity;
            if(quantity==0){
                toastrMessage('error',"Please insert quantity first","Error");
            }
            else{
                
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
                $("#serialnumreq").val(reqsnm);
                $("#expirenumreq").val(reqexd);
                $("#tableid").val("");
                $("#serheaderid").val(headerid);
                $("#seritemid").val(itemid);
                $("#serstoreid").val(storeid);
                $("#storeQuantity").val(quantity);
                var remaining=parseFloat(quantity)-parseFloat(inserted);
                $("#totalQuantityLbl").html(quantity);
                $("#insertedQuantityLbl").html(inserted);
                $("#remainingQuantityLbl").html(remaining);
                $("#serialNumberModal").modal('show');
                $("#staticTableDiv").show();
                $("#dynamicTableDiv").hide();
                $("#staticbuttondiv").show();
                $("#dynamicbuttondiv").hide();
                $('#laravel-datatable-crud-snedit').DataTable({
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
                    url: '/showSerialNmRecStatic/'+headerid+'/'+itemid,
                    type: 'GET',
                    },
                columns: [
                    { data: 'id', name: 'id', 'visible': false },
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
            }
        });
        //End serial no or batch no or expire date

        //Start Voucher type info
        $(document).ready(function() {
            $('#voucherType').on('change', function() {
                var sid = $('#supplier').val();
                var voucherTypeVar = $('#voucherType').val();
                if (voucherTypeVar === "Manual-Receipt") {
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val(null).trigger('change');
                    $('#invoicenumberdiv').hide();
                    $('#InvoiceNumber').val("");
                    $('#invoiceNumber-error').html("");
                    $('#docinfolbl').html("Doc. Number");
                }
                else if (voucherTypeVar === "Fiscal-Receipt") {
                    $('#mrcDiv').show();
                    $('#MrcNumber').val(null).trigger('change');
                    $('#invoicenumberdiv').show();
                    $('#InvoiceNumber').val("");
                    $('#invoiceNumber-error').html("");
                    $('#docinfolbl').html("FS Number");
                } 
                else if (($('#categoryInfoLbl').text() == "Supplier" || $('#categoryInfoLbl').text() =="Customer&Supplier") && voucherTypeVar == "Fiscal-Receipt") {
                    $('#mrcDiv').show();
                    $('#invoicenumberdiv').show();
                    $('#InvoiceNumber').val("");
                    $('#invoiceNumber-error').html("");
                    $('#docinfolbl').html("FS Number");
                } else if ($('#categoryInfoLbl').text() == "") {
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val(null).trigger('change');
                    $('#invoicenumberdiv').hide();
                    $('#InvoiceNumber').val("");
                    $('#invoiceNumber-error').html("");
                    $('#docinfolbl').html("Doc. Number");
                } else {
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val(null).trigger('change');
                    $('#invoicenumberdiv').hide();
                    $('#InvoiceNumber').val("");
                    $('#invoiceNumber-error').html("");
                    $('#docinfolbl').html("Doc. Number");
                }
            });
        });
        //End Voucher type info

        //Start Store events
        $(document).ready(function() {
            $('#store').on('change', function() {
                var sroreidvar = $('#store').val();
                $('.storeid').val(sroreidvar);
            });
        });
        //End Store events

        var j = 0;
        var i = 0;
        var m = 0;

        var j2 = 0;
        var i2 = 0;
        var m2 = 0;

        $("#adds").click(function() {
            var voucherst = $('#VoucherStatus').val() || 0;
            var sroreidvar = $('#store').val();
            var lastrowcount = $('#dynamicTable > tbody > tr:last').find('td').eq(1).find('input').val();
            var itemids = $(`#itemNameSl${lastrowcount}`).val();
            var locationid = $(`#location${lastrowcount}`).val();
            var receiving_type = $('#ReceivingType').val();
            var options = "";
            if(isNaN(parseFloat(sroreidvar)) || sroreidvar == null){
                toastrMessage('error',"Please select source receiving store/station first","Error");
                $('#store-error').html("The receiving store/station field is required.");
            }
            else if((itemids !== undefined && itemids === null) || (locationid !== undefined && locationid === null)){
                if(itemids !== undefined && itemids === null){
                    $(`#select2-itemNameSl${lastrowcount}-container`).parent().css('background-color',errorcolor);
                }
                if(locationid !== undefined && locationid === null){
                    $(`#select2-location${lastrowcount}-container`).parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i;
                ++m;
                j += 1;
                $("#dynamicTable > tbody").append(`<tr>
                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                    <td style="width:13%">
                        <select id="location${m}" class="select2 form-control location" onchange="locationFn(this)" name="row[${m}][location]"></select>
                    </td>
                    <td style="width:14%">
                        <select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select>
                    </td>
                    <td style="width:13%">
                        <select id = "uom${m}" class ="select2 form-control uom" onchange = "uomVal(this)" name = "row[${m}][uom]"></select>
                    </td>
                    <td style="width:13%">
                        <input type="number" name="row[${m}][Quantity]" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="qtyFn(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/>
                    </td>
                    <td style="width:13%;background-color:#efefef;text-align:center">
                        <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="requested_qty_inp${m}"></label>
                        <input type="hidden" name="row[${m}][requested_qty]" id="requested_qty${m}" placeholder="Requested Quantity" class="requested_qty form-control numeral-mask" onkeypress="return ValidateNum(event);"/>
                    </td>
                    <td style="width:13%;background-color:#efefef;text-align:center">
                        <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="remaining_qty_inp${m}"></label>
                        <input type="hidden" name="row[${m}][remaining_qty]" id="remaining_qty${m}" placeholder="Remaining Quantity" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/>
                    </td>
                    <td style="width:15%;">
                        <input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" placeholder="Write remark here..."/>
                    </td>
                    <td style="width:3%;text-align:center;">
                        <button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="addser(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                    </td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][Common]" id="common${m}" class="common form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][TransactionType]" id="TransactionType${m}" class="TransactionType form-control" readonly="true" value="Receiving" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][ItemType]" id="ItemType${m}" class="ItemType form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][StoreId]" id="storeid${m}" class="storeid form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][DefaultUOMId]" id="DefaultUOMId${m}" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][NewUOMId]" id="NewUOMId${m}" class="NewUOMId form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][ConversionAmount]" id="ConversionAmount${m}" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][ConvertedQuantity]" id="ConvertedQuantity${m}" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][RetailerPrice]" id="RetailerPrice${m}" class="RetailerPrice form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][Wholeseller]" id="Wholeseller${m}" class="Wholeseller form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][tax]" id="tax${m}" class="tax form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][RequireSerialNumber]" id="RequireSerialNumber${m}" class="RequireSerialNumber form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][RequireExpireDate]" id="RequireExpireDate${m}" class="RequireExpireDate form-control" readonly="true" style="font-weight:bold;"/></td>
                    <td style="display:none;"><input type="hidden" name="row[${m}][insertedqty]" id="insertedqtyi+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="0"/></td>
                </tr>`);

                if(parseInt(voucherst) == 1 || parseInt(voucherst) == 0){
                    $('.vatproperty').show();
                }
                else if(parseInt(voucherst)==2){
                    $('.vatproperty').hide();
                }

                var rnum = $('#commonVal').val();
                $('.common').val(rnum);
                
                $('.storeid').val(sroreidvar);
                var opt = '<option selected disabled value=""></option>';
                var location = $("#locationdefault > option").clone();
                $(`#location${m}`).append(location);
                $(`#location${m} option[title!="${sroreidvar}"]`).remove(); 
                $(`#location${m}`).append(opt);
                $(`#location${m}`).select2
                ({
                    placeholder: "Select location here...",
                });

                if(parseInt(receiving_type) == 1){
                    options = $("#itemnamefooter > option").clone();
                }
                else if(parseInt(receiving_type) == 2){
                    options = $("#po_goods_default > option").clone();
                }

                $(`#itemNameSl${m}`).append(options);
                $(`#itemNameSl${m}`).append(opt);
                $(`#itemNameSl${m}`).select2
                ({
                    placeholder: "Select Item here",
                    dropdownCssClass : 'commprp',
                });
                $(`#uom${m}`).select2
                ({
                    placeholder: "Select UOM here",
                });

                $(`#select2-location${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            
                CalculateGrandTotal();
                renumberRows();
            }
        });

        function locationFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            const row = $(ele).closest('tr');
            var location = $(`#location${idval}`).val() || 0;
            var item = $(`#itemNameSl${idval}`).val() || 0;

            checkDuplicateCombination(location,item,idval,row[0],1);
        }

        function itemFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            const row = $(ele).closest('tr');
            var location = $(`#location${idval}`).val() || 0;
            var item = $(`#itemNameSl${idval}`).val() || 0;

            $(`#uom${idval}`).empty();

            checkDuplicateCombination(location,item,idval,row[0],2);
        }

        function checkDuplicateCombination(loc, itm, indx, excludeRow, param) {
            if (loc == null || itm == null || loc === '' || itm === '') return false;

            const targetKey = String(loc) + '||' + String(itm);
            let found = false;

            // Loop through each row in the table
            $('#dynamicTable tbody tr').each(function () {

                if (excludeRow && this === excludeRow) return; 

                let location = $(this).find('.location').val();
                let item = $(this).find('.itemName').val();

                if (!location || !item) return; 

                const key = String(location) + '||' + String(item);

                if (key === targetKey) {
                    found = true;
                    if(param == 1){
                        $(`#location${indx}`).val(null).select2
                        ({
                            placeholder: "Select location here...",
                        });
                        $(`#select2-location${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                    }
                    if(param == 2){
                        $(`#itemNameSl${indx}`).val(null).select2
                        ({
                            placeholder: "Select item here...",
                            dropdownCssClass : 'commprp',
                        });
                        $(`#select2-itemNameSl${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                    }
                }
            });

            if (found) {
                toastrMessage('error',"Duplicate Location and Item found","Error");
                return true; 
            }

            if(param == 1){
                $(`#select2-location${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            if(param == 2){
                fetchUOM(itm,indx);
                CalculateReqAmount(indx);
                $(`#select2-itemNameSl${indx}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            return false; 
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
                    $(`#uom${indx}`).empty();
                    $.each(data.itemdata, function(key, value) {
                        $(`#uom${indx}`).append(`<option selected value="${value.MeasurementId}">${value.uom_name}</option>`);
                        $(`#uom${indx}`).select2({minimumResultsForSearch: -1});
                    });
                },
            });
        }

        function qtyFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var rem_qty = $(`#remaining_qty${idval}`).val() || 0;
            var qty = $(`#quantity${idval}`).val() || 0;
            var rec_type = $('#ReceivingType').val() || 0;
            $(`#quantity${idval}`).css("background-color","white");

            if(parseFloat(qty) > parseFloat(rem_qty) && parseInt(rec_type) == 2){
                $(`#quantity${idval}`).css("background-color",errorcolor);
                $(`#quantity${idval}`).val("");
                toastrMessage('error',"Quantity can not be greater than Remaining quantity","Error");
            }
        }

        $("#commadds").click(function() {
            var storeid=$('#store').val();
            var rectype=$('#ReceivingType').val();
            var lastrowcount=$('#commDynamicTable tr:last').find('td').eq(1).find('input').val();
            var floormap=$('#FloorMap'+lastrowcount).val();
            var commtype=$('#CommType'+lastrowcount).val();
            var origin=$('#Origin'+lastrowcount).val();
            var grade=$('#Grade'+lastrowcount).val();
            var processtype=$('#ProcessType'+lastrowcount).val();
            var cropyear=$('#CropYear'+lastrowcount).val();
            var borcolor="";
            if(isNaN(parseInt(storeid))){
                $('#store-error').html("Station is required"); 
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
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i2;
                ++m2;
                ++j2;

                if(parseInt(j2)%2===0){
                    borcolor="#f8f9fa";
                }
                else{
                    borcolor="#FFFFFF";
                }

                $("#commDynamicTable > tbody").append('<tr id="rowind'+m2+'" class="mb-1" style="background-color:'+borcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                    '<span class="badge badge-center rounded-pill bg-secondary">'+j2+'</span>'+
                '</td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m2+'][vals]" id="vals'+m2+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m2+'"/></td>'+
                '<td style="width:96%;">'+
                    '<div class="row">'+
                        '<div class="col-xl-6 col-md-6 col-lg-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="FloorMap'+m2+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m2+'][FloorMap]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CommType'+m2+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m2+'][CommType]"></select>'+
                                '</div>'+
                                '<div class="col-xl-6 col-md-4 col-lg-6 mb-1">'+
                                    '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Origin'+m2+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m2+'][Origin]"></select>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Grade'+m2+'" class="select2 form-control Grade" onchange="GradeFn(this)" name="row['+m2+'][Grade]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="ProcessType'+m2+'" class="select2 form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m2+'][ProcessType]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="CropYear'+m2+'" class="select2 form-control CropYear" onchange="CropYearFn(this)" name="row['+m2+'][CropYear]"></select>'+
                                '</div>'+
                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                    '<label style="font-size: 12px;">Remark</label>'+
                                    '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m2+'][Remark]" id="Remark'+m2+'"></textarea>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-xl-4 col-md-4 col-lg-4" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                            '<div class="row">'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<select id="Uom'+m2+'" class="select2 form-control Uom" onchange="UomFn(this)" name="row['+m2+'][Uom]"></select>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][NumOfBag]" placeholder="Write Number of bag here" id="NumOfBag'+m2+'" class="NumOfBag form-control numeral-mask commnuminp" onkeyup="NumOfBagFn(this)" onkeypress="return ValidateOnlyNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                    '<label style="font-size: 12px;">Bag Weight by KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][TotalBagWeight]" placeholder="Bag weight" id="TotalBagWeight'+m2+'" class="TotalBagWeight form-control numeral-mask commnuminp" onkeyup="BagWeightFn(this)" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                    '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                    '<input type="number" name="row['+m2+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m2+'" class="TotalKg form-control numeral-mask commnuminp" onkeyup="TotalKgFn(this)" onblur="TotalKgErrFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                    '<label style="font-size: 12px;">Net KG<i class="fa-solid fa-circle-info" title="Total KG - Bag Weight by KG"></i></label>'+
                                    '<input type="number" name="row['+m2+'][NetKg]" placeholder="Write Net KG here..." id="NetKg'+m2+'" class="NetKg form-control numeral-mask commnuminp" onkeyup="NetKgFn(this)" onblur="NetKgErrFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                    '<label style="font-size: 12px;">Feresula<i class="fa-solid fa-circle-info" title="Net KG / 17"></i></label>'+
                                    '<input type="number" name="row['+m2+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m2+'" class="Feresula form-control numeral-mask commnuminp" onkeypress="return ValidateNum(event);" step="any"/>'+
                                '</div>'+
                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0"></div>'+
                                '<div class="col-xl-8 col-md-8 col-lg-8 mb-0">'+
                                    '<label style="font-size: 12px;font-weight:bold;" id="varianceLbl'+m2+'"></label>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-xl-2 col-md-2 col-lg-2">'+
                            '<div class="row" id="podatatbl'+m2+'" style="display:none;">'+
                                '<div class="col-xl-12 col-md-12 col-lg-12 mt-0" style="text-align:center;">'+
                                    '<label style="font-size: 13px;"><b>Requested Amount</b></label>'+
                                '</div>'+
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;" id="reqnumofbaglbl'+m2+'">No. of Bag</label>'+
                                '</div>'+ 
                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;font-weight:bold;" id="reqnumofbag'+m2+'"></label>'+
                                '</div>'+ 
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;" id="reqweightkglbl'+m2+'">Weight by KG</label>'+
                                '</div>'+ 
                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;font-weight:bold;" id="reqweightkg'+m2+'"></label>'+
                                '</div>'+ 
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;" id="reqferesulalbl'+m2+'">Feresula</label>'+
                                '</div>'+ 
                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;font-weight:bold;" id="reqferesula'+m2+'"></label>'+
                                '</div>'+ 
                                '<div class="col-xl-12 col-md-12 col-lg-12 mt-0" style="text-align:center;">'+
                                    '<label style="font-size: 13px;"><b>Remaining Amount</b></label>'+
                                '</div>'+
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;" id="remnumofbaglbl'+m2+'">No. of Bag</label>'+
                                '</div>'+ 
                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;font-weight:bold;" id="remnumofbag'+m2+'"></label>'+
                                '</div>'+ 
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;" id="remweightkglbl'+m2+'">Weight by KG</label>'+
                                '</div>'+ 
                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;font-weight:bold;" id="remweightkg'+m2+'"></label>'+
                                '</div>'+ 
                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;" id="remferesulalbl'+m2+'">Feresula</label>'+
                                '</div>'+ 
                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                    '<label style="font-size: 10px;font-weight:bold;" id="remferesula'+m2+'"></label>'+
                                '</div>'+ 
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</td>'+
                '<td style="width:2%;text-align:right;vertical-align: top;">'+
                    '<button type="button" id="commremovebtn'+m2+'" class="btn btn-light btn-sm commremove-tr" style="color:#ea5455;background-color:'+borcolor+';border-color:'+borcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                '</td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][reUnitCost]" id="reUnitCost'+m2+'" class="reUnitCost form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][remBagNum]" id="remBagNum'+m2+'" class="remBagNum form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][remKg]" id="remKg'+m2+'" class="remKg form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][bagWeight]" id="bagWeight'+m2+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][uomFactor]" id="uomFactor'+m2+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][varianceshortage]" id="varianceshortage'+m2+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="number" name="row['+m2+'][varianceoverage]" id="varianceoverage'+m2+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m2+'][podetid]" id="podetid'+m2+'" class="podetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '<td style="display:none;"><input type="hidden" name="row['+m2+'][id]" id="id'+m2+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td>'+
                '</tr>');

                var defaultoption = '<option selected value=""></option>';
                var commtypeoptions = $("#commoditytypedefault > option").clone();
                $('#CommType'+m2).append(commtypeoptions);
                $('#CommType'+m2).append(defaultoption);
                $('#CommType'+m2).select2
                ({
                    placeholder: "Select here",
                    dropdownCssClass : 'cusmidprp',
                });
                
                var gradeoptions = $("#gradedefault > option").clone();
                $('#Grade'+m2).append(gradeoptions);
                $('#Grade'+m2).append(defaultoption);
                $('#Grade'+m2).select2
                ({
                    placeholder: "Select Grade here...",
                    dropdownCssClass : 'cusmidprp',
                });

                var processtypeoptions = $("#processtypedefault > option").clone();
                $('#ProcessType'+m2).append(processtypeoptions);
                $('#ProcessType'+m2).append(defaultoption);
                $('#ProcessType'+m2).select2
                ({
                    placeholder: "Select Process type here...",
                    dropdownCssClass : 'cusmidprp',
                });

                var cropyearoptions =  $("#cropyeardefault > option").clone();
                $('#CropYear'+m2).append(cropyearoptions);
                $('#CropYear'+m2).append(defaultoption);
                $('#CropYear'+m2).select2
                ({
                    placeholder: "Select Crop year here...",
                    dropdownCssClass : 'cusmidprp',
                });

                var uomoptions = $("#uomdefault > option").clone();
                $('#Uom'+m2).append(uomoptions);
                $('#Uom'+m2).append(defaultoption);
                $('#Uom'+m2).select2
                ({
                    placeholder: "Select UOM/Bag here",
                    dropdownCssClass : 'cusprop',
                });

                var floormapopt = $("#locationdefault > option").clone();
                $('#FloorMap'+m2).append(floormapopt);
                $("#FloorMap"+m2+" option[title!="+storeid+"]").remove(); 
                $('#FloorMap'+m2).append(defaultoption);
                $('#FloorMap'+m2).select2
                ({
                    placeholder: "Select Floor map here",
                });
               
                $('#Origin'+m2).select2
                ({
                    placeholder: "Select Type here",
                    minimumResultsForSearch: -1
                });
                
                if(parseInt(rectype)==1){
                    $('#podatatbl'+m2).hide();
                }
                else if(parseInt(rectype)==2){
                    $('#podatatbl'+m2).show();
                }
                $('#Feresula'+m2).prop("readonly",true);
                $('#NumOfBag'+m2).prop("readonly",true);
                $('#NetKg'+m2).prop("readonly",true);
                CalculateCommTotal();
                commRenumberRows();
                $('#select2-FloorMap'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CommType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Origin'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Grade'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-ProcessType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-CropYear'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Uom'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });  

        $(document).on('click', '.commremove-tr', function() {
            $(this).parents('tr').remove();
            CalculateCommTotal();
            commRenumberRows();
            --i2;
        });

        function commRenumberRows() {
            var ind=0;
            $('#commDynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().html('<span class="badge badge-center rounded-pill bg-secondary">'+(++index)+'</span>');
                ind = index;
            });
            if (ind == 0) {
               $('#commTotalTable').hide();
            } else {
                $('#commTotalTable').show();
            }
            $('#commadds').show();
        }

        function FloorMapFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var uomid=$('#Uom'+idval).val();

            var floormapcnt=0;
            var floormapcntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#FloorMap'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        floormapcnt+=1;
                    }
                    
                }
            }
            if(parseInt(floormapcnt)<=1){
                $('#select2-FloorMap'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(floormapcnt)>1){
                $('#FloorMap'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Floor map here",
                });
                $('#select2-FloorMap'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Floor map is selected with all property","Error");
            }
            CalculateCommTotal();
        }

        function CommTypeFn(ele) {
            var originoptions="";
            var receivingType=$('#ReceivingType').val();
            var poNumberId=$('#PONumber').val()||0;
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var uomid=$('#Uom'+idval).val();

            var commtypecnt=0;
            var commtypecntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#CommType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        commtypecnt+=1;
                    }
                }
            }

            if(parseInt(commtypecnt)<=1){
                var defaultoption = '<option selected value=""></option>';
                $('#Origin'+idval).empty();
                if(parseInt(receivingType)==1){
                    originoptions = $("#origindefault > option").clone();
                }
                else if(parseInt(receivingType)==2){
                    originoptions = $("#commoditydefault > option").clone();
                }
                
                $('#Origin'+idval).append(originoptions);
                $('.typeprop'+idval).hide();

                if(parseInt(commtype)==1){
                    $("#Origin"+idval+" option[title!=1]").remove(); 
                    if(parseInt(receivingType)==2){
                        $("#Origin"+idval+" option[label!="+poNumberId+"]").remove(); 
                    }
                }
                else if(parseInt(commtype)==2 || parseInt(commtype)==4 || parseInt(commtype)==5 || parseInt(commtype)==6){
                    $("#Origin"+idval+" option[title!=2]").remove(); 
                    if(parseInt(receivingType)==2){
                        $("#Origin"+idval+" option[label!="+poNumberId+"]").remove(); 
                    }
                }
                else if(parseInt(commtype)==3){
                    $("#Origin"+idval+" option[title!=3]").remove(); 
                    if(parseInt(receivingType)==2){
                        $("#Origin"+idval+" option[label!="+poNumberId+"]").remove(); 
                    }
                }

                $('#Origin'+idval).append(defaultoption);
                $('#Origin'+idval).select2
                ({
                    placeholder: "Select Commodity here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-CommType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(commtypecnt)>1){
                $('#CommType'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select here...",
                    minimumResultsForSearch: -1
                });
                $('#select2-CommType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Commodity Type is selected with all property","Error");
            }
            CalculateCommTotal();
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
            var recType=$('#ReceivingType').val();
            var uomid=$('#Uom'+idval).val();

            var purdetprop="";
            var defcropyear="";
            var defproctype="";
            var defuomdata="";
            var uomval="";
            var uomtext="";
            var defalutuomdata="";
            var defaultoption = '<option selected value=""></option>';

            if(parseInt(recType)==2){
                var selectedOption = $('#Origin'+idval).find('option:selected');
                var poDetId = selectedOption.prop('tabindex');
                $('#podetid'+idval).val(poDetId);
                var defoptdata = $('#commoditydefault').find('option[tabindex="' + poDetId + '"]');
                purdetprop=defoptdata.attr('contextmenu');
                var commPropArray = purdetprop.split('-');
                var cryear=commPropArray[0];
                var prtype=commPropArray[1];
                var uomval=commPropArray[2];
            }
            var origincnt=0;
            var origincntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#Origin'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        origincnt+=1;
                    }
                }
            }

            if(parseInt(origincnt)<=1){
                if(parseInt(recType)==2){
                    if(parseInt(cryear)==0){
                        defcropyear='<option selected value=0>NCY (No Crop Year)</option>';
                    }
                    else{
                        defcropyear='<option selected value='+cryear+'>'+cryear+'</option>';
                    }

                    defproctype='<option selected value='+prtype+'>'+prtype+'</option>';

                    uomtext = $('#uomdefault option[value="' + uomval + '"]').text();
                    defalutuomdata='<option selected value='+uomval+'>'+uomtext+'</option>';
                    
                    $('#CropYear'+idval).empty();
                    $('#CropYear'+idval).append(defcropyear);
                    $('#CropYear'+idval).select2
                    ({
                        placeholder: "Select Crop year here...",
                        dropdownCssClass : 'cusprop',
                        minimumResultsForSearch: -1
                    });
                    
                    $('#ProcessType'+idval).empty();
                    $('#ProcessType'+idval).append(defproctype);
                    $('#ProcessType'+idval).select2
                    ({
                        placeholder: "Select Process type here...",
                        dropdownCssClass : 'cusprop',
                        minimumResultsForSearch: -1
                    });

                    $('#Uom'+idval).empty();
                    $('#Uom'+idval).append(defalutuomdata);
                    $('#Uom'+idval).append(defaultoption);
                    $('#Uom'+idval).select2
                    ({
                        placeholder: "Select UOM/Bag here...",
                        dropdownCssClass : 'cusprop',
                        minimumResultsForSearch: -1
                    });

                    $('#NumOfBag'+idval).prop("readonly",false);
                    $('#select2-CropYear'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                    $('#select2-ProcessType'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                
                    if(parseInt(origin)>0 && processtype!="" && cropyear!="" && parseInt(uomid)>0){
                        CalculateReqAmount(idval);
                    }
                }
                
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            }
            else if(parseInt(origincnt)>1){
                $('#Origin'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select Commodity here",
                    dropdownCssClass : 'commprp',
                });
                $('#select2-Origin'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                toastrMessage('error',"Commodity is selected with all property","Error");
            }
            CalculateCommTotal();
        }

        function GradeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var uomid=$('#Uom'+idval).val();
            var poids=$('#PONumber').val();

            var gradecnt=0;
            var gradecntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#Grade'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        gradecnt+=1;
                    }
                }
            }

            if(parseInt(gradecnt)<=1){
                if(parseInt(origin)>0 && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(poids)>0){
                    CalculateReqAmount(idval);
                }
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
            CalculateCommTotal();
        }

        function ProcessTypeFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var uomid=$('#Uom'+idval).val();
            var poids=$('#PONumber').val();

            var processtypecnt=0;
            var processtypecntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#ProcessType'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        processtypecnt+=1;
                    }
                }
            }

            if(parseInt(processtypecnt)<=1){
                if(parseInt(origin)>0 && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(poids)>0){
                    CalculateReqAmount(idval);
                }
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
            CalculateCommTotal();
        }

        function CropYearFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var uomid=$('#Uom'+idval).val();
            var poids=$('#PONumber').val();

            var cropyearcnt=0;
            var cropyearcntB=0;
            for(var k=1;k<=m2;k++){
                if(($('#CropYear'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        cropyearcnt+=1;
                    }
                }
            }

            if(parseInt(cropyearcnt)<=1){
                if(parseInt(origin)>0 && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(poids)>0){
                    CalculateReqAmount(idval);
                }
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
            CalculateCommTotal();
        }

        function UomFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var commtype=$('#CommType'+idval).val()||0;
            var origin=$('#Origin'+idval).val()||0;
            var grade=$('#Grade'+idval).val()||0;
            var processtype=$('#ProcessType'+idval).val();
            var cropyear=$('#CropYear'+idval).val()||0;
            var floormap=$('#FloorMap'+idval).val();
            var uomid=$('#Uom'+idval).val();
            var poids=$('#PONumber').val();
            var numofbag=$('#NumOfBag'+idval).val()||0;
            var uomopt = $('#uomdefault').find('option[value="' +uomid+ '"]');
            var uomfactor=uomopt.attr('title');
            var uombagweight=uomopt.attr('label');
            var totalbagweight=parseFloat(uombagweight)*parseFloat(numofbag);
             
            var uomcnt=0;
            for(var k=1;k<=m2;k++){
                if(($('#Uom'+k).val())!=undefined){
                    if((parseInt($('#CommType'+k).val()) == parseInt(commtype)) && (parseInt($('#Origin'+k).val()) == parseInt(origin)) && (parseInt($('#Grade'+k).val()) == parseInt(grade)) && ($('#ProcessType'+k).val()==processtype) && (parseInt($('#CropYear'+k).val()) == parseInt(cropyear)) && (parseInt($('#FloorMap'+k).val()) == parseInt(floormap)) && (parseInt($('#Uom'+k).val()) == parseInt(uomid))){
                        uomcnt+=1;
                    }
                }
            }

            if(parseInt(uomcnt)<=1){
                $('#TotalBagWeight'+idval).val(totalbagweight == 0 ? '' : totalbagweight.toFixed(2));
                $('#uomFactor'+idval).val(uomfactor);
                $('#bagWeight'+idval).val(uombagweight);
                $('#NumOfBag'+idval).prop("readonly",false);
                $('#NetKg'+idval).prop("readonly",true);
                $('#NetKg'+idval).val("");
                $('#TotalBagWeight'+idval).css("background","#efefef");
                $('#Uom'+idval).select2
                ({
                    placeholder: "Select UOM/Bag here...",
                    dropdownCssClass : 'cusprop',
                });
                $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
                
                if(parseInt(origin)>0 && processtype!="" && cropyear!="" && parseInt(uomid)>0 && parseInt(poids)>0){
                    CalculateReqAmount(idval);
                }
            }
            else if(parseInt(uomcnt)>1){
                $('#TotalBagWeight'+idval).val("");
                $('#uomFactor'+idval).val("");
                $('#bagWeight'+idval).val("");
                $('#NumOfBag'+idval).prop("readonly",true);
                $('#NetKg'+idval).prop("readonly",true);
                $('#NetKg'+idval).val("");
                $('#TotalBagWeight'+idval).css("background","#efefef");
                $('#Uom'+idval).val(null).trigger('change').select2
                ({
                    placeholder: "Select UOM/Bag here...",
                    dropdownCssClass : 'cusprop',
                });
                $('#select2-Uom'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
            }
            CalculateCommTotal();
        }

        function NumOfBagFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var numofbag=$('#NumOfBag'+idval).val()||0;
            var bagweight=$('#bagWeight'+idval).val()||0;
            var rembag=$('#remBagNum'+idval).val()||0;
            var remkg=$('#remKg'+idval).val()||0;
            var rectype=$('#ReceivingType').val();
            var ispoamntauth=$('#ispoamntauthvals').val();
            

            $('#NetKg'+idval).val("");
            $('#Feresula'+idval).val("");
            $('#TotalBagWeight'+idval).val("");
            $('#TotalKg'+idval).val("");
            $('#varianceoverage'+idval).val("");
            $('#varianceshortage'+idval).val("");
            $('#varianceLbl'+idval).html("");
            if(parseInt(rectype)==1){
                if(parseFloat(numofbag)==0){
                    $('#NumOfBag'+idval).css("background",errorcolor);
                    $('#NumOfBag'+idval).val("");
                    toastrMessage('error',"Zero(0) is invalid input","Error");
                }
                else if(parseFloat(numofbag)>0){
                    var totalbagweight=parseFloat(numofbag)*parseFloat(bagweight);
                    $('#NumOfBag'+idval).css("background","white");
                    $('#TotalBagWeight'+idval).val(totalbagweight.toFixed(2));
                    $('#TotalBagWeight'+idval).css("background","#efefef");
                }
            }
            else if(parseInt(rectype)==2){
                if(parseFloat(numofbag)>parseFloat(rembag) && parseInt(ispoamntauth)==0){
                    $('#NumOfBag'+idval).css("background",errorcolor);
                    $('#NumOfBag'+idval).val("");
                    $('#TotalBagWeight'+idval).css("background","#efefef");
                    $('#TotalBagWeight'+idval).val("");
                    toastrMessage('error',"Inserted number of bag is greater than remaining amount","Error");
                }
                else{
                    if(parseFloat(numofbag)==0){
                        $('#NumOfBag'+idval).css("background",errorcolor);
                        $('#NumOfBag'+idval).val("");
                        toastrMessage('error',"Zero(0) is invalid input","Error");
                    }
                    else if(parseFloat(numofbag)>0){
                        var totalbagweight=parseFloat(numofbag)*parseFloat(bagweight);
                        $('#NumOfBag'+idval).css("background","white");
                        $('#TotalBagWeight'+idval).val(totalbagweight.toFixed(2));
                        $('#TotalBagWeight'+idval).css("background","#efefef");
                    } 
                }
            }
            CalculateCommTotal();
        }

        function TotalKgFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var totalkgval=$('#TotalKg'+idval).val()||0;
            var balance=$('#NetKg'+idval).val()||0;
            var numofbag=$('#NumOfBag'+idval).val()||0;
            var uomfactor=$('#uomFactor'+idval).val()||0;
            var bagweight=$('#TotalBagWeight'+idval).val()||0;
            var rembag=$('#remBagNum'+idval).val()||0;
            var remkg=$('#remKg'+idval).val()||0;
            var rectype=$('#ReceivingType').val();
            var commfactor=1;
            var nextnumofbag=parseFloat(numofbag)+parseInt(commfactor);
            var nextweightkg=parseFloat(nextnumofbag)*parseFloat(uomfactor);
            var totalkg=parseFloat(numofbag)*parseFloat(uomfactor);
            var variance=0;
            var netkg=0;
            var feresulafac=17;
            var ispoamntauth=$('#ispoamntauthvals').val();
            
            if(parseInt(rectype)==1){
                if(parseFloat(totalkgval)==0){
                    $('#NetKg'+idval).val("");
                    $('#Feresula'+idval).val("");
                    $('#NetKg'+idval).css("background","#efefef");
                    $('#varianceoverage'+idval).val("");
                    $('#varianceshortage'+idval).val("");
                    $('#varianceLbl'+idval).html("");
                    toastrMessage('error',"Zero(0) is invalid input","Error");
                }
                else if(parseFloat(totalkgval)>0 && parseFloat(numofbag)>0){
                    var balance=$('#NetKg'+idval).val()||0;
                    netkg=parseFloat(totalkgval)-parseFloat(bagweight);
                    var result=parseFloat(netkg)/parseFloat(feresulafac);
                    $('#NetKg'+idval).val(netkg.toFixed(2));
                    $('#Feresula'+idval).val(result.toFixed(2));
                    $('#NetKg'+idval).css("background","#efefef");
                    $('#Feresula'+idval).css("background","#efefef");

                    var feresula=$('#Feresula'+idval).val()||0;
                    var balancekg=$('#NetKg'+idval).val()||0;

                    feresula = feresula == '' ? 0 : feresula;
                    balancekg = balancekg == '' ? 0 : balancekg;
                    
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
                    $('#TotalKg'+idval).css("background","white");
                }
            }

            else if(parseInt(rectype)==2){
                if(parseFloat(totalkgval)>parseFloat(remkg) && parseInt(ispoamntauth)==0){
                    $('#TotalKg'+idval).val("");
                    $('#NetKg'+idval).val("");
                    $('#Feresula'+idval).val("");
                    $('#NetKg'+idval).css("background","#efefef");
                    $('#TotalKg'+idval).css("background",errorcolor);
                    $('#varianceoverage'+idval).val("");
                    $('#varianceshortage'+idval).val("");
                    $('#varianceLbl'+idval).html("");
                    toastrMessage('error',"Inserted number of bag is greater than remaining amount","Error");
                }
                else{
                    if(parseFloat(totalkgval)==0){
                        $('#NetKg'+idval).val("");
                        $('#Feresula'+idval).val("");
                        $('#NetKg'+idval).css("background","#efefef");
                        $('#varianceoverage'+idval).val("");
                        $('#varianceshortage'+idval).val("");
                        $('#varianceLbl'+idval).html("");
                        toastrMessage('error',"Zero(0) is invalid input","Error");
                    }
                    else if(parseFloat(totalkgval)>0 && parseFloat(numofbag)>0){
                        var balance=$('#NetKg'+idval).val()||0;
                        netkg=parseFloat(totalkgval)-parseFloat(bagweight);
                        var result=parseFloat(netkg)/parseFloat(feresulafac);
                        $('#NetKg'+idval).val(netkg.toFixed(2));
                        $('#Feresula'+idval).val(result.toFixed(2));
                        $('#NetKg'+idval).css("background","#efefef");
                        $('#Feresula'+idval).css("background","#efefef");

                        var feresula=$('#Feresula'+idval).val()||0;
                        var balancekg=$('#NetKg'+idval).val()||0;

                        feresula = feresula == '' ? 0 : feresula;
                        balancekg = balancekg == '' ? 0 : balancekg;
                        
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
                    $('#TotalKg'+idval).css("background","white");
                }
            }
           CalculateCommTotal();
        }

        function CalculateCommTotal(){
            var numberofbag=0;
            var totalbagweight=0;
            var totalnetkg=0;
            var totalferesula=0;
            var totalvarianceshortage=0;
            var totalvarianceoverage=0;
            var totalton=0;

            $.each($('#commDynamicTable').find('.NumOfBag'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    numberofbag += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.TotalBagWeight'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalbagweight += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.NetKg'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalnetkg += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.Feresula'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalferesula += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.varianceshortage'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalvarianceshortage += parseFloat($(this).val());
                }
            });

            $.each($('#commDynamicTable').find('.varianceoverage'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    totalvarianceoverage += parseFloat($(this).val());
                }
            });

            totalton=parseFloat(totalnetkg)/1000;
            $('#totalnumberofbag').html(numformat(numberofbag.toFixed(2)));
            $('#totalbagweightbykg').html(numformat(totalbagweight.toFixed(2)));
            $('#totalnetkg').html(numformat(totalnetkg.toFixed(2)));
            $('#totalbalanceferesula').html(numformat(totalferesula.toFixed(2)));
            $('#totalvarianceshortage').html(numformat(totalvarianceshortage.toFixed(2)));
            $('#totalvarianceoverage').html(numformat(totalvarianceoverage.toFixed(2)));
            $('#totalbalanceton').html(numformat(totalton.toFixed(2)));
            $('#commTotalTable').show();
        }

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            CalculateGrandTotal();
            renumberRows();
            $('#adds').show();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody > tr').each(function(index, el) {
                $(this).children('td').first().text(++index);
                $('#numberofItemsLbl').html(index - 1);
                ind = index - 1;
            });
            if (ind == 0) {
                $('#pricingTable').hide();
            } else {
                $('#pricingTable').show();
            }
        }

        //Start save receiving
        $('#RegisterRec').submit(function(e) {
            e.preventDefault();
            var fname="";
            let formData = new FormData(this);
            var optype = $("#operationtypes").val();
            var sup = supplier.value;
            var str = store.value;
            var arr = [];
            var found = 0;
            
            if (sup == "1" && str == "1") {
                $('#store-error').html("Invalid Selection");
                $('#supplier-error').html("Invalid Selection");
                if(parseFloat(optype)==1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                    $('#saveHoldbutton').prop("disabled", false);
                }
                else if(parseFloat(optype)==2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"Invalid supplier and store selection","Error");
            } else if (str == "1") {
                $('#store-error').html("Invalid Selection");
                if(parseFloat(optype)==1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop("disabled", false);
                    $('#saveHoldbutton').prop("disabled", false);
                }
                else if(parseFloat(optype)==2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled", false);
                }
                toastrMessage('error',"Invalid Store Selection","Error");
            } else {
                var numofitems = $('#numberofItemsLbl').text();
              
                $.ajax({
                    url: "{{url('saveProcReceiving')}}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
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
                            if (data.errors.ReceivingType) {
                                var text=data.errors.ReceivingType[0];
                                text = text.replace("receiving type", "reference");
                                $('#type-error').html(text);
                            }
                            if (data.errors.ProductType) {
                                var text=data.errors.ProductType[0];
                                text = text.replace("product type", "product type");
                                $('#prdtype-error').html(text);
                            }
                            if (data.errors.PONumber) {
                                var text=data.errors.PONumber[0];
                                text = text.replace("2", "PO (Purchase-Order)");
                                text = text.replace("p o", "reference");
                                text = text.replace("receiving type", "reference");
                                $('#ponumber-error').html(text);
                            }
                            if (data.errors.supplier) {
                                $('#supplier-error').html(data.errors.supplier[0]);
                            }
                            if (data.errors.CommoditySource) {
                                $('#commoditysrc-error').html(data.errors.CommoditySource[0]);
                            }
                            if (data.errors.CommodityType) {
                                $('#commoditytype-error').html(data.errors.CommodityType[0]);
                            }
                            if (data.errors.CompanyType) {
                                $('#comptype-error').html(data.errors.CompanyType[0]);
                            }
                            if (data.errors.Customer) {
                                var text=data.errors.Customer[0];
                                text = text.replace("2", "customer");
                                $('#customer-error').html(text);
                            }
                            if (data.errors.DeliveryOrderNo) {
                                var text=data.errors.DeliveryOrderNo[0];
                                text = text.replace("delivery order no", "delivery order no");
                                $('#deliveryordnumber-error').html(text);
                            }
                            if (data.errors.DispatchStation) {
                                var text=data.errors.DispatchStation[0];
                                text = text.replace("dispatch station", "dispatch station");
                                $('#dispatchst-error').html(text);
                            }
                            if (data.errors.store) {
                                var text=data.errors.store[0];
                                text = text.replace("store", "receiving station");
                                $('#store-error').html(text);
                            }
                            if (data.errors.ReceivedBy) {
                                var text=data.errors.ReceivedBy[0];
                                text = text.replace("received by", "received by");
                                $('#receivedby-error').html(text);
                            }
                            if (data.errors.DriverName) {
                                var text=data.errors.DriverName[0];
                                text = text.replace("driver name", "driver name");
                                $('#truckdriver-error').html(text);
                            }
                            if (data.errors.PlateNumber) {
                                var text=data.errors.PlateNumber[0];
                                text = text.replace("plate number", "plate number");
                                $('#platenum-error').html(text);
                            }
                            if (data.errors.DriverPhoneNumber) {
                                var text=data.errors.DriverPhoneNumber[0];
                                text = text.replace("driver phone number", "driver phone number");
                                $('#driverphonenum-error').html(text);
                            }
                            if (data.errors.DeliveredBy) {
                                var text=data.errors.DeliveredBy[0];
                                text = text.replace("delivered by", "delivered by");
                                $('#deliveredby-error').html(text);
                            }
                            if (data.errors.ReceivedDate) {
                                var text=data.errors.ReceivedDate[0];
                                text = text.replace("received date", "received date");
                                $('#receiveddate-error').html(text);
                            }
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Check your inputs","Error");
                        } 
                        else if (data.errorv2) {
                            var cusid = $('#customers_id').val();

                            if(data.product_type == 1){
                                for(var k=1;k<=m2;k++){
                                    var floormap=$('#FloorMap'+k).val();
                                    var commtype=$('#CommType'+k).val();
                                    var origin=$('#Origin'+k).val();
                                    var grade=$('#Grade'+k).val();
                                    var processtype=$('#ProcessType'+k).val();
                                    var cropyear=$('#CropYear'+k).val();
                                    
                                    var numofbag=$('#NumOfBag'+k).val();
                                    var totalkg=$('#TotalKg'+k).val();
                                    var uoms=$('#Uom'+k).val();

                                    if(($('#FloorMap'+k).val())!=undefined){
                                        if(floormap=="" || floormap==null){
                                            $('#select2-FloorMap'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#CommType'+k).val())!=undefined){
                                        if(commtype=="" || commtype==null){
                                            $('#select2-CommType'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    
                                    if(($('#Origin'+k).val())!=undefined){
                                        if(origin=="" || origin==null){
                                            $('#select2-Origin'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    
                                    if(($('#Grade'+k).val())!=undefined){
                                        if(grade=="" || grade==null){
                                            $('#select2-Grade'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#ProcessType'+k).val())!=undefined){
                                        if(processtype=="" || processtype==null){
                                            $('#select2-ProcessType'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#CropYear'+k).val())!=undefined){
                                        if(cropyear=="" || cropyear==null){
                                            $('#select2-CropYear'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#Uom'+k).val())!=undefined){
                                        if(uoms=="" || uoms==null){
                                            $('#select2-Uom'+k+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":errorcolor});
                                        }
                                    }
                                    if(($('#NumOfBag'+k).val())!=undefined){
                                        if(numofbag=="" || numofbag==null){
                                            $('#NumOfBag'+k).css("background", errorcolor);
                                        }
                                    }
                                    if(($('#TotalKg'+k).val())!=undefined){
                                        if(totalkg=="" || totalkg==null){
                                            $('#TotalKg'+k).css("background", errorcolor);
                                        }
                                    }
                                }
                            }
                            
                            if(data.product_type == 2){
                                $('#dynamicTable > tbody > tr').each(function () {
                                    let location = $(this).find('.location').val();
                                    let item = $(this).find('.itemName').val();
                                    let quantity = $(this).find('.quantity').val();
                                    let rowind = $(this).find('.vals').val();

                                    if(isNaN(parseFloat(location)) || parseFloat(location)==0){
                                        $(`#select2-location${rowind}-container`).parent().css('background-color',errorcolor);
                                    }
                                    if(isNaN(parseFloat(item)) || parseFloat(item)==0){
                                        $(`#select2-itemNameSl${rowind}-container`).parent().css('background-color',errorcolor);
                                    }
                                    if(quantity != undefined){
                                        if(isNaN(parseFloat(quantity)) || parseFloat(quantity)==0){
                                            $(`#quantity${rowind}`).css("background", errorcolor);
                                        }
                                    }
                                });
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
                        else if (data.dberrors) {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please contact administrator","Error");
                        }
                        else if(data.emptyerror)
                        {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please add atleast one item or commodity","Error");
                        } 
                        else if(data.dateerrors)
                        {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"Please post ending first to register this purchase","Error");
                        }
                        else if(data.strdifferrors)
                        {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"You cant change current store/shop to posted store/shop","Error");
                        }
                        else if(data.fydaterror)
                        {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('error',"The Invoice date is outoff the current system fisical year. please check the invoce date </br>OR</br>Post the ending","Error");
                        }
                       
                        
                        else if (data.success) {
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                                $('#saveHoldbutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                            toastrMessage('success',"Successful","Success");
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            $('#laravel-datatable-crud-hold').DataTable().ajax.reload();
                            $("#inlineForm").modal('hide');
                            var cval = "";
                            cval = $('#checkboxVali').val();
                            if (cval == 1) {
                                var recid = data.receivingId;
                                var link = "/grv/" + recid;
                                window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
                            }
                            closeModalWithClearValidation();
                        }
                    },
                });
            }
        });
        //End save receiving

        //start checkbox change function
        $(function() {
            $("#printGRVCBX").click(function() {
                if ($(this).is(":checked")) {
                    $('#checkboxVali').val('1');

                } else {
                    $('#checkboxVali').val('0');
                }
            });
        });
        //end checkbox change function

        //start checkbox change function
        $(function() {
            $("#hideGRVCBX").click(function() {
                if ($(this).is(":checked")) {
                    $('#hidegrvcheckbox').val('1');

                } else {
                    $('#hidegrvcheckbox').val('0');
                }
            });
        });
        //end checkbox change function

        //Start save hold receiving
        $('#saveHoldbutton').click(function() {
            var sup = supplier.value;
            var str = store.value;
            var numofitems = $('#numberofItemsLbl').text();
            if (sup == "1" && str == "1") {
                $('#store-error').html("Invalid Selection");
                $('#supplier-error').html("Invalid Selection");
                $('#savebutton').text('Save');
                $('#savebutton').prop("disabled", false);
                $('#saveHoldbutton').prop("disabled", false);
                toastrMessage('error',"Invalid Supplier and Store Selection","Error");
            } else if (sup == "1") {
                $('#supplier-error').html("Invalid Selection");
                $('#savebutton').text('Save');
                $('#savebutton').prop("disabled", false);
                $('#saveHoldbutton').prop("disabled", false);
                toastrMessage('error',"Invalid Supplier Selection","Error");
            } else if (str == "1") {
                $('#store-error').html("Invalid Selection");
                $('#savebutton').text('Save');
                $('#savebutton').prop("disabled", false);
                $('#saveHoldbutton').prop("disabled", false);
                toastrMessage('error',"Invalid Store Selection","Error");
            } else if (numofitems == 0) {
                $('#saveHoldbutton').text('Save');
                $('#saveHoldbutton').prop("disabled", false);
                $('#savebutton').prop("disabled", false);
                toastrMessage('error',"You should add atleast one item","Error");
            } else {
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/saveHoldRec',
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        $('#saveHoldbutton').text('Saving...');
                        $('#saveHoldbutton').prop("disabled", true);
                        $('#savebutton').prop("disabled", true);
                    },
                    success: function(data) {
                        if (data.errors) {
                            if (data.errors.receivingnumberi) {
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Document Number already exist" +' <button id="getNewHoldbtn" type="button" class="btn btn-gradient-secondary">Get New Document No.</button>',"Error");
                            }
                            if (data.errors.supplier) {
                                $('#supplier-error').html(data.errors.supplier[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.PaymentType) {
                                $('#paymentType-error').html(data.errors.PaymentType[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.voucherType) {
                                $('#voucherType-error').html(data.errors.voucherType[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.VoucherNumber) {
                                $('#voucherNumber-error').html(data.errors.VoucherNumber[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.InvoiceNumber) {
                                $('#invoiceNumber-error').html(data.errors.InvoiceNumber[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.MrcNumber) {
                                $('#mrcNumber-error').html(data.errors.MrcNumber[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.date) {
                                $('#date-error').html(data.errors.date[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.store) {
                                $('#store-error').html(data.errors.store[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.Purchaser) {
                                $('#purchaser-error').html(data.errors.Purchaser[0]);
                                $('#saveHoldbutton').text('Save');
                                $('#saveHoldbutton').prop("disabled", false);
                                $('#savebutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                        } else if (data.dberrors) {
                            $('#voucherNumber-error').html("The doc/fs number has already been taken.");
                            $('#saveHoldbutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                            $('#saveHoldbutton').prop("disabled", false);
                            toastrMessage('error',"Check your inputs","Error");
                        } else if (data.success) {
                            $('#saveHoldbutton').text('Save');
                            $('#saveHoldbutton').prop("disabled", false);
                            $('#savebutton').prop("disabled", false);
                            toastrMessage('success',"Successful","Success");
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            var oTable = $('#laravel-datatable-crud-hold').dataTable();
                            oTable.fnDraw(false);
                            $("#inlineForm").modal('hide');
                            var cval = "1";
                            cval = $('#checkboxVali').val();
                            if (cval == 1) {
                                var recid = data.receivingId;
                                var link = "/grv/" + recid;
                                window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
                            }
                            closeModalWithClearValidation();
                        }
                    },
                });
            }
        });
        //End save hold receiving

        //Start get hold number value
        $('body').on('click', '.addrecprocbutton', function() {
            $("#inlineForm").modal('show');
            $("#newreceivingmodaltitles").html("Add Receiving");
            $('#tid').val("");
            $('#receivingId').val("");
            $('#hiddenstoreval').val("");
            var cdatevar=$('#cdatevals').val();
            
            $('#supplier').select2
            ({
                //templateSelection: formatText,
                //templateResult: formatText,
                placeholder: "Select Supplier here",
                dropdownCssClass : 'commprp',
            });
            $('#store').select2
            ({
                placeholder: "Select Station here",
                dropdownCssClass : 'cusprop',
            });
            $('#ReceivedBy').select2
            ({
                placeholder: "Select Received by here",
            });
            $('#ReceivingType').select2
            ({
                placeholder: "Select Reference here",
                minimumResultsForSearch: -1
            });
            $('#PONumber').select2
            ({
                placeholder: "Select Reference No. here",
            });
            $('#ProductType').select2
            ({
                placeholder: "Select Reference first",
                minimumResultsForSearch: -1
            });
            $('#CommoditySource').select2
            ({
                placeholder: "Select Commodity source here",
            });
            $('#CommodityType').select2
            ({
                placeholder: "Select Commodity type here",
                minimumResultsForSearch: -1
            });
            $('#CompanyType').select2
            ({
                placeholder: "Select Company type here",
                minimumResultsForSearch: -1
            });
            $('#Customer').select2
            ({
                placeholder: "Select Customer here",
            });
            flatpickr('#ReceivedDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
            $(".errordatalabel").html("");
            $(".mainforminp").val("");
            $('.customerdiv').hide();
            $('.commprop').hide();
            $('.productcls').hide();
            $('#commTotalTable').hide();
            $('#CommoditySource').empty();
            $('#ProductType').empty();
            $('#CompanyType').empty();
            $("#ponumdiv").hide();
            $("#saveHoldbutton").hide();
            $("#savebutton").show();
            $("#holdbutton").show();
            $("#printgrvdiv").show();
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $('#saveHoldbutton').prop("disabled", false);
            $("#checkboxVali").val("1");
            $("#operationtypes").val("1");
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $('.docBtn').hide();
            $("#invoicenumberdiv").show();
            $("#InvoiceNumber").val("");
            $("#invoiceNumber-error").html("");
            $("#Memo").val("");
            $("#statusdisplay").html("");
            $('#docinfolbl').html("FS Number");
            $("#voucherType option[value=Declarasion]").hide();
            $("#voucherType option[value=Manual-Receipt]").show();
            $('#invoicenumberdiv').hide();
            $('.invprop').show(); 
            $('.vatproperty').show();
            $('#beforeAfterTax').html("Before Tax");
            $('#subGrandTotalLbl').html("Grand Total");
            $('#invdatelbl').html("Invoice Date");
            $('#mrcDiv').hide();
        });
        //End get hold number value

        //Start get hold number value
        $('#getNewHoldbtn').click(function(){
            $.get("/getNewHoldNumber", function(data) {
                $('#holdnumberi').val(data.holdnum);
                $('#receivingnumberi').val(data.recnum);
            });
        });
        //End get hold number value

        //Start hold receiving
        $('#holdbutton').click(function() {

            var arr = [];
            var found = 0;
            $('.itemName').each(function() {
                var name = $(this).val();
                if (arr.includes(name)) {
                    found++;
                } else {
                    arr.push(name);
                }
            });
            if (found) {
                $('#holdbutton').text('Hold');
                $('#holdbutton').prop("disabled", false);
                toastrMessage('error',"There is duplicate Item","Error");
            } else {
                var numofitems = $('#numberofItemsLbl').text();
                var supplierval = supplier.value;
                var storevar = store.value;
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: '/saveHolding',
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
                        $('#holdbutton').text('Holding...');
                        $('#holdbutton').prop("disabled", true);
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
                        if (numofitems == 0 && (supplierval == "" || storevar == "")) {
                            if (supplierval == "") {
                                $('#supplier-error').html("The supplier field is required");
                            }
                            if (storevar == "") {
                                $('#store-error').html("The store field is required");
                            }
                            $('#holdbutton').text('Hold');
                            $('#holdbutton').prop("disabled", false);
                            toastrMessage('error',"You should add atleast one item </br>OR</br>Select customer and store","Error");
                        } else if (data.errors) {
                            if (data.errors.holdnumberi) {
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Document Number already exist" +' <button id="getNewHoldbtn" type="button" class="btn btn-gradient-secondary">Get New Document No.</button>',"Error");
                            }
                            if (data.errors.supplier) {
                                $('#supplier-error').html(data.errors.supplier[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.PaymentType) {
                                $('#paymentType-error').html(data.errors.PaymentType[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.voucherType) {
                                $('#voucherType-error').html(data.errors.voucherType[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.VoucherNumber) {
                                $('#voucherNumber-error').html(data.errors.VoucherNumber[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.InvoiceNumber) {
                                $('#invoiceNumber-error').html(data.errors.InvoiceNumber[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.MrcNumber) {
                                $('#mrcNumber-error').html(data.errors.MrcNumber[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.date) {
                                $('#date-error').html(data.errors.date[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.store) {
                                $('#store-error').html(data.errors.store[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                            if (data.errors.Purchaser) {
                                $('#purchaser-error').html(data.errors.Purchaser[0]);
                                $('#holdbutton').text('Hold');
                                $('#holdbutton').prop("disabled", false);
                                toastrMessage('error',"Check your inputs","Error");
                            }
                        } else if (data.errorv2) {
                            var error_html = '';
                            var selecteditemsvar = '';
                            for(var k=1;k<=m;k++){
                                var itmid=($('#itemNameSl'+k)).val();
                                var insqnt=($('#insertedqty'+k)).val();
                                if(($('#quantity'+k).val())!=undefined){
                                    var qnt=$('#quantity'+k).val();
                                    if(isNaN(parseFloat(qnt))||parseFloat(qnt)==0){
                                        $('#quantity'+k).css("background", errorcolor);
                                    }
                                }
                                if(($('#unitcost'+k).val())!=undefined){
                                    var unitc=$('#unitcost'+k).val();
                                    if(isNaN(parseFloat(unitc))||parseFloat(unitc)==0){
                                        $('#unitcost'+k).css("background", errorcolor);
                                    }
                                }
                                if(($('#beforetax'+k).val())!=undefined){
                                    var beforetx=$('#beforetax'+k).val();
                                    if(isNaN(parseFloat(beforetx))||parseFloat(beforetx)==0){
                                        $('#beforetax'+k).css("background", errorcolor);
                                    }
                                }
                                if(($('#taxamounts'+k).val())!=undefined){
                                    var totaltax=$('#taxamounts'+k).val();
                                    if(isNaN(parseFloat(totaltax))||parseFloat(totaltax)==0){
                                        $('#taxamounts'+k).css("background", errorcolor);
                                    }
                                }
                                if(($('#total'+k).val())!=undefined){
                                    var gtotal=$('#total'+k).val();
                                    if(isNaN(parseFloat(gtotal))||parseFloat(gtotal)==0){
                                        $('#total'+k).css("background", errorcolor);
                                    }
                                }
                                if(isNaN(parseFloat(itmid))||parseFloat(itmid)==0){
                                    $('#select2-itemNameSl'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            // for (var count = 0; count < data.errorv2.length; count++) {
                            //     error_html += '<p>' + data.errorv2[count] + '</p>';
                            // }
                            $('#holdbutton').text('Hold');
                            $('#holdbutton').prop("disabled", false);
                            toastrMessage('error',"Please insert valid data on highlighted fields");
                        } else if (found) {
                            $('#holdbutton').text('Hold');
                            $('#holdbutton').prop("disabled", false);
                            toastrMessage('error',"There is duplicate item");
                        }
                        else if (data.strdifferrors) {
                            $('#holdbutton').text('Hold');
                            $('#holdbutton').prop("disabled", false);
                            toastrMessage('error',"You cant change current store/shop to posted store/shop","Error");
                        } 
                        else if (data.success) {
                            $('#holdbutton').text('Hold');
                            $('#holdbutton').prop("disabled", false);
                            toastrMessage('success',"Hold Successful","Success");
                            closeModalWithClearValidation();
                            var oTable = $('#laravel-datatable-crud-hold').dataTable();
                            oTable.fnDraw(false);
                            $("#inlineForm").modal('hide');
                        }
                    },
                });
            }
        });
        //End hold receiving

        function calculateVat(vstatus){
            var quantity=0;
            var unitcost=0;
            var beforetax=0;
            var tax=0;
            var total=0;
            var linetotal=0;
            var taxpercent = 15;
            if(parseInt(vstatus)==1){
                for(var i=0;i<=m;i++){
                    quantity=$('#quantity'+i).val()||0;
                    unitcost=$('#unitcost'+i).val()||0;
                    unitcost = unitcost == '' ? 0 : unitcost;
                    quantity = quantity == '' ? 0 : quantity;
                    total = parseFloat(unitcost) * parseFloat(quantity);
                    taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                    linetotal = parseFloat(total) + parseFloat(taxamount);
                    $('#beforetax'+i).val(total.toFixed(2));
                    $('#taxamounts'+i).val(taxamount.toFixed(2));
                    $('#total'+i).val(linetotal.toFixed(2));
                }
            }
            else if(parseInt(vstatus)==2){
                for(var i=0;i<=m;i++){
                    quantity=$('#quantity'+i).val()||0;
                    unitcost=$('#unitcost'+i).val()||0;
                    unitcost = unitcost == '' ? 0 : unitcost;
                    quantity = quantity == '' ? 0 : quantity;
                    total = parseFloat(unitcost) * parseFloat(quantity);
                    
                    $('#beforetax'+i).val(total.toFixed(2));
                    $('#taxamounts'+i).val("0");
                    $('#total'+i).val(total.toFixed(2));
                }
            }
            CalculateGrandTotal();
        }

        

        function CalculateTotal(ele) {
            var taxpercent = $(ele).closest('tr').find('.tax').val();
            var unitcost = $(ele).closest('tr').find('.unitcost').val();
            var quantity = $(ele).closest('tr').find('.quantity').val();
            var retailerprice = $(ele).closest('tr').find('.RetailerPrice').val();
            var wholeseller = $(ele).closest('tr').find('.Wholeseller').val();
            var reqexp = $(ele).closest('tr').find('.RequireExpireDate').val();
            var reqser = $(ele).closest('tr').find('.RequireSerialNumber').val();
            var cid=$(ele).closest('tr').find('.vals').val();
            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;
            retailerprice = retailerprice == '' ? 0 : retailerprice;
            wholeseller = wholeseller == '' ? 0 : wholeseller;
            var inputid = ele.getAttribute('id');
            if (!isNaN(unitcost) && !isNaN(quantity)) {
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                var linetotal = parseFloat(total) + parseFloat(taxamount);
                $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
                $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
                $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
                if(inputid==="unitcost"+cid){
                    $(ele).closest('tr').find('.unitcost').css("background","white");
                }
                if(inputid==="quantity"+cid){
                    $(ele).closest('tr').find('.quantity').css("background","white");
                }
                if(parseFloat(total)>0){
                    $(ele).closest('tr').find('.beforetax').css("background","#efefef");
                    $(ele).closest('tr').find('.taxamount').css("background","#efefef");
                    $(ele).closest('tr').find('.total').css("background","#efefef");
                }
            }
            var defuom = $(ele).closest('tr').find('.DefaultUOMId').val();
            var newuom = $(ele).closest('tr').find('.NewUOMId').val();
            var convamount = $(ele).closest('tr').find('.ConversionAmount').val();
            var convertedq = parseFloat(quantity) / parseFloat(convamount);
            $(ele).closest('tr').find('.ConvertedQuantity').val(convertedq);
            if(reqexp==="Not-Require" && reqser==="Not-Require"){
                $(ele).closest('tr').find('.insertedqty').val(quantity);
            }
            CalculateGrandTotal();
        }

        function CalculateGrandTotal() {
            var subtotal = 0;
            var tax = 0;
            var grandTotal = 0;
            var witholdam = $('#witholdMinAmounti').val()||0;
            var witholdpr = $('#witholdPercenti').val()||0;
            $.each($('#dynamicTable').find('.beforetax'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    subtotal += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.taxamount'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    tax += parseFloat($(this).val());
                }
            });
            $.each($('#dynamicTable').find('.total'), function() {
                if ($(this).val() != '' && !isNaN($(this).val())) {
                    grandTotal += parseFloat($(this).val());
                }
            });
            var cc = $('#categoryInfoLbl').text();
            if (parseFloat(subtotal.toFixed(2)) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                var st = parseFloat(subtotal.toFixed(2));
                var wp = parseFloat(witholdpr);
                var tt = 0;
                var np = 0;
                tt = (st * wp) / 100;
                np = parseFloat(grandTotal.toFixed(2)) - tt;
                $('#witholdingAmntLbl').html(numformat(tt.toFixed(2)));
                $('#witholdingAmntin').val(tt.toFixed(2));
                $('#netpayLbl').html(numformat(np.toFixed(2)));
                $('#netpayin').val(np.toFixed(2));
                if (cc === "Foreigner-Supplier" || cc === "Person") {
                    $("#witholdingTr").hide();
                    $("#netpayTr").hide();
                } 
                else if (parseFloat(subtotal.toFixed(2)) >= parseFloat(witholdam) && parseFloat(witholdpr) > 0) {
                    $("#witholdingTr").show();
                    $("#netpayTr").show();
                }
            } 
            else if (parseFloat(subtotal.toFixed(2)) < parseFloat(witholdam) || parseFloat(witholdpr) == 0 || cc ==="Foreigner-Supplier" || cc === "Person") {
                $('#witholdingAmntLbl').html("0");
                $('#witholdingAmntin').val("0");
                $('#netpayLbl').html("0");
                $('#netpayin').val("0");
                $("#witholdingTr").hide();
                $("#netpayTr").hide();
            }
            $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxLbl').html(numformat(tax.toFixed(2)));
            $('#taxi').val(tax.toFixed(2));
            $('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#grandtotali').val(grandTotal.toFixed(2));
        }

        function CalculateAddHoldTotal(ele) {
            var taxpercent = $("#taxpercenti").val();
            var quantity = $('#quantityhold').val();
            var unitcost = $('#unitcosthold').val();
            var retailerprice = $('#retailerpricei').val();
            var wholeseller = $('#wholeselleri').val();
            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;
            if (!isNaN(unitcost) && !isNaN(quantity)) {
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount = (parseFloat(total) * parseFloat(taxpercent) / 100);
                var linetotal = parseFloat(total) + parseFloat(taxamount);
                $('#beforetaxhold').val(total.toFixed(2));
                $('#taxamounthold').val(taxamount.toFixed(2));
                $('#totalcosthold').val(linetotal.toFixed(2));
            }
            var defuom = $('#defaultuomi').val();
            var newuom = $('#newuomi').val();
            var convamount = $('#convertedamnti').val();
            var convertedq = parseFloat(quantity) / parseFloat(convamount);
            $('#convertedqi').val(convertedq);
        }

        //Start save new hold record
        $('#savenewhold').click(function(){
            var registerForm = $('#newHoldform');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/savenewhold',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#savenewhold').text('Saving...');
                    $('#savenewhold').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.addHoldItem) {
                            $('#addholdItem-error').html(data.errors.addHoldItem[0]);
                        }
                        if (data.errors.quantityhold) {
                            $('#addHoldQuantity-error').html(data.errors.quantityhold[0]);
                        }
                        if (data.errors.unitcosthold) {
                            $('#addHoldunitCost-error').html(data.errors.unitcosthold[0]);
                        }
                        $('#savenewhold').text('Save');
                        $('#savenewhold').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.dberrors) {
                        $('#addholdItem-error').html("The add hold item has already been taken.");
                        $('#savenewhold').text('Save');
                        $('#savenewhold').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#savenewhold').text('Save');
                        $('#savenewhold').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#newholdmodal").modal('hide');
                        closeHoldAddModal();
                        var oTable = $('#holdEditTable').dataTable();
                        oTable.fnDraw(false);
                        $('#recId').val("");
                        $('#recevingedit').val("");
                        $('#editVal').val("0");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len = data.PricingVal.length;
                        for (var i = 0; i <= len; i++) {
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            $('#taxLbl').html(numformat(data.PricingVal[i].TaxAmount));
                            $('#grandtotalLbl').html(numformat(data.PricingVal[i].TotalCost));
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#taxi').val(data.PricingVal[i].TaxAmount);
                            $('#grandtotali').val(data.PricingVal[i].TotalCost);
                            var stotal = parseFloat($('#subtotali').val());
                            var gtotal = parseFloat($('#grandtotali').val());
                            var withamnt = parseFloat($('#witholdMinAmounti').val());
                            var withprc = parseFloat($('#witholdPercenti').val());
                            var cc = $('#categoryInfoLbl').text();
                            if (stotal >= withamnt && withprc > 0) {
                                var st = parseFloat(stotal);
                                var wp = parseFloat(withprc);
                                var tt = 0;
                                var np = 0;
                                tt = (st * wp) / 100;
                                np = parseFloat(gtotal) - tt;
                                $('#witholdingAmntLbl').html(tt.toFixed(2));
                                $('#witholdingAmntin').val(tt.toFixed(2));
                                $('#netpayLbl').html(np.toFixed(2));
                                $('#netpayin').val(np.toFixed(2));
                                if (cc === "Foreigner-Supplier" || cc === "Person") {
                                    $("#witholdingTr").hide();
                                    $("#netpayTr").hide();
                                } else if (stotal >= withamnt && withprc > 0 && cc !=
                                    "Foreigner-Supplier" && cc != "Person") {
                                    $("#witholdingTr").show();
                                    $("#netpayTr").show();
                                }
                            } 
                            else if (stotal < withamnt || withprc == 0 || cc ===  "Foreigner-Supplier" || cc === "Person") {
                                $('#witholdingAmntLbl').html("0");
                                $('#witholdingAmntin').val("0");
                                $('#netpayLbl').html("0");
                                $('#netpayin').val("0");
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide();
                            }
                        }
                    }
                },
            });
        });
        //Ends save new hold record

        //Start save new hold record
        $('#savenewreceiving').click(function(){
            var registerForm = $('#newHoldform');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/savenewitemrec',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#savenewreceiving').text('Saving...');
                    $('#savenewreceiving').prop("disabled", true);
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.addHoldItem) {
                            $('#addholdItem-error').html(data.errors.addHoldItem[0]);
                        }
                        if (data.errors.quantityhold) {
                            $('#addHoldQuantity-error').html(data.errors.quantityhold[0]);
                        }
                        if (data.errors.unitcosthold) {
                            $('#addHoldunitCost-error').html(data.errors.unitcosthold[0]);
                        }
                        $('#savenewreceiving').text('Save');
                        $('#savenewreceiving').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.dberrors) {
                        $('#addholdItem-error').html("The add hold item has already been taken.");
                        $('#savenewreceiving').text('Save');
                        $('#savenewreceiving').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#savenewreceiving').text('Save');
                        $('#savenewreceiving').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#newholdmodal").modal('hide');
                        closeHoldAddModal();
                        var oTable = $('#receivingEditTable').dataTable();
                        oTable.fnDraw(false);
                        $('#recId').val("");
                        $('#recevingedit').val("");
                        $('#editVal').val("0");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len = data.PricingVal.length;
                        for (var i = 0; i <= len; i++) {
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            $('#taxLbl').html(numformat(data.PricingVal[i].TaxAmount));
                            $('#grandtotalLbl').html(numformat(data.PricingVal[i].TotalCost));
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#taxi').val(data.PricingVal[i].TaxAmount);
                            $('#grandtotali').val(data.PricingVal[i].TotalCost);
                            var stotal = parseFloat($('#subtotali').val());
                            var gtotal = parseFloat($('#grandtotali').val());
                            var withamnt = parseFloat($('#witholdMinAmounti').val());
                            var withprc = parseFloat($('#witholdPercenti').val());
                            var cc = $('#categoryInfoLbl').text();
                            if (stotal >= withamnt && withprc > 0) {
                                var st = parseFloat(stotal);
                                var wp = parseFloat(withprc);
                                var tt = 0;
                                var np = 0;
                                tt = (st * wp) / 100;
                                np = parseFloat(gtotal) - tt;
                                $('#witholdingAmntLbl').html((tt.toFixed(2)));
                                $('#witholdingAmntin').val(tt.toFixed(2));
                                $('#netpayLbl').html((np.toFixed(2)));
                                $('#netpayin').val(np.toFixed(2));
                                $("#witholdingTr").show();
                                $("#netpayTr").show();
                                if (cc === "Foreigner-Supplier" || cc === "Person") {
                                    $("#witholdingTr").hide();
                                    $("#netpayTr").hide();
                                } else if (stotal >= withamnt && withprc > 0 && cc !=
                                    "Foreigner-Supplier" && cc != "Person") {
                                    $("#witholdingTr").show();
                                    $("#netpayTr").show();
                                }
                            } else if (stotal < withamnt || withprc == 0 || cc ===
                                "Foreigner-Supplier" || cc === "Person") {
                                $('#witholdingAmntLbl').html("0");
                                $('#witholdingAmntin').val("0");
                                $('#netpayLbl').html("0");
                                $('#netpayin').val("0");
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide();
                            }
                        }

                    }
                },
            });
        });
        //Ends save new hold record

        //Start withold settle 
        $('#settlewitholdbtn').click(function(){
            var registerForm = $('#witholdSettleForm');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/settleWitholdFn',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    
                    $('#settlewitholdbtn').text('Please Wait...');
                    $('#settlewitholdbtn').prop("disabled", true);
                },
                
                success: function(data) {
                    if (data.recerror) {
                        $('#receipt-error').html("receipt number already taken.");
                        $('#settlewitholdbtn').text('Settle');
                        $('#settlewitholdbtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.errors) {
                        if (data.errors.ReceiptNumber) {
                            $('#receipt-error').html(data.errors.ReceiptNumber[0]);
                        }
                        $('#settlewitholdbtn').text('Settle');
                        $('#settlewitholdbtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#settlewitholdbtn').text('Settle');
                        $('#settlewitholdbtn').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#witholdSettleModal").modal('hide');
                        var oTable = $('#witholdingTables').dataTable();
                        oTable.fnDraw(false);
                        ids = [];
                        $('#selectedids').val(ids);
                        ReceiptNumberVal();
                        var len = data.recData.length;
                        for (var i = 0; i <= len; i++) {
                            var settleType = data.recData[i].IsWitholdSettle;
                            $('#infoWitholdReceiptLbl').html(data.recData[i].WitholdReceipt);
                            $('#infoWitholdSettleBy').html(data.recData[i].WitholdSettledBy);
                            $('#infoWitholdSettleDate').html(data.recData[i].WitholdSettleDate);
                            if (settleType === "Settled") {
                                $('#settledLabelPr').show();
                                $('#notsettledLabelPr').hide();
                            } else if (settleType === "Not-Settled") {
                                $('#settledLabelPr').hide();
                                $('#notsettledLabelPr').show();
                            }
                            var total = data.TotalCount;
                            var settled = data.Settled;
                            var notsettled = data.NotSettled;

                            if (parseFloat(total) == parseFloat(settled) && parseFloat(notsettled) ==
                                0) {
                                $('#settledLabel').show();
                                $('#notsettledLabel').hide();
                            } else if (parseFloat(total) == parseFloat(notsettled) && parseFloat(
                                    settled) == 0) {
                                $('#settledLabel').hide();
                                $('#notsettledLabel').show();
                                $('#notsettledLabel').text('Not-Settled');
                            } else if (parseFloat(settled) >= 1 && parseFloat(notsettled) >= 1) {
                                $('#settledLabel').hide();
                                $('#notsettledLabel').show();
                                $('#notsettledLabel').text('Partially-Settled');
                            }
                        }
                    }
                },
            });
        });
        //End withold settle number

        //Start withold settle 
        $('#separateSettleBtn').click(function(){
            var registerForm = $('#sepwitholdSettleForm');
            var formData = registerForm.serialize();
            $.ajax({
                url: '/sepsettleWitholdFn',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#separateSettleBtn').text('Please Wait...');
                    $('#separateSettleBtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.recerror) {
                        $('#receipts-error').html("receipt number already taken.");
                        $('#separateSettleBtn').text('Settle');
                        $('#separateSettleBtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.errors) {
                        if (data.errors.ReceiptNumbers) {
                            $('#receipts-error').html(data.errors.ReceiptNumbers[0]);
                        }
                        $('#separateSettleBtn').text('Settle');
                        $('#separateSettleBtn').prop("disabled", false);
                        toastrMessage('error',"Check your inputs","Error");
                    }
                    if (data.success) {
                        $('#separateSettleBtn').text('Settle');
                        $('#separateSettleBtn').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#separateSettleModal").modal('hide');
                        ReceiptNumberVal();
                    }
                },
            });
        });
        //End withold settle number

        //edit hold modal open
        function editholddata(holdIdVar){
            $('.select2').select2();
            //var holdIdVar = $(this).data('id');
            $('#tid').val(holdIdVar);
            $('#itid').val(holdIdVar);
            $("#newreceivingmodaltitles").html("Update Hold");
            $("#operationtypes").val("1");
            $("#statusdisplay").html("");
            var j=0;
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
            $('#inlineForm').modal('show');
            $.get("/getHoldNumber", function(data) {
                $('#holdnumberi').val(data.holdnum);
                $('#receivingnumberi').val(data.recnum);
                $('#witholdPercenti').val(data.witholdPer);
                $('#withodingTitleLbl').html("Witholding (" + data.witholdPer + "%)");
                $('#witholdMinAmounti').val(data.witholdAmnt);
                var dbval = data.ReceivingHoldCount;
                var rnum = (Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
                $('#commonVal').val(rnum + dbval);
            });
            $.get("/holdedit" + '/' + holdIdVar, function(data) {
                $('#holdnumberi').val(data.recHold.DocumentNumber);
                
                $('#supplier').select2('destroy');
                $('#supplier').val(data.recHold.CustomerId).trigger('change').select2();
                $('#PaymentType').select2('destroy');
                $('#PaymentType').val(data.recHold.PaymentType).trigger('change').select2();
                $('#VoucherStatus').select2('destroy');
                $('#VoucherStatus').val(data.recHold.VoucherStatus).select2();
                $('#voucherType').select2('destroy');
                $('#voucherType').val(data.recHold.VoucherType).trigger('change').select2();
                $('#VoucherNumber').val(data.recHold.VoucherNumber);
                $('#InvoiceNumber').val(data.recHold.InvoiceNumber);
                $('#MrcNumber').select2('destroy');
                $('#MrcNumber').val(data.recHold.CustomerMRC).select2();
                $('#Purchaser').select2('destroy');
                $('#Purchaser').val(data.recHold.PurchaserName).select2();
                $('#date').val(data.recHold.TransactionDate);
                $('#store').select2('destroy');
                $('#store').val(data.recHold.StoreId).trigger('change').select2();
                $('#subtotalLbl').html(numformat(data.recHold.SubTotal));
                $('#taxLbl').html(numformat(data.recHold.Tax));
                $('#grandtotalLbl').html(numformat(data.recHold.GrandTotal));
                $('#witholdingAmntLbl').html((data.recHold.WitholdAmount));
                $('#witholdingAmntin').val(data.recHold.WitholdAmount);
                $('#subtotali').val(data.recHold.SubTotal);
                $('#taxi').val(data.recHold.Tax);
                $('#grandtotali').val(data.recHold.GrandTotal);
                $('#netpayin').val(data.recHold.NetPay);
                $('#netpayLbl').html((data.recHold.NetPay));
                $('#hiddenstoreval').val(data.recHold.StoreId);
                $('#numberofItemsLbl').text(data.count);
                
                var sid = data.recHold.CustomerId;

                $.each(data.receivingdt, function(key, value) {
                    ++i;
                    ++m;
                    ++j;
                    var vis="";
                    if(value.ReSerialNm=="Not-Require" && value.ReExpDate=="Not-Require"){
                        vis="none";
                    }
                    else if(value.ReSerialNm==="" && value.ReExpDate===""){
                        vis="none";
                    }
                    else if(value.ReSerialNm=="Require" || value.ReExpDate=="Require"){
                        vis="visible";
                    }
                    $("#dynamicTable > tbody").append('<tr><td style="font-weight:bold;text-align:center;width:3%;">'+j+'</td>'+
                        '<td style="width:25%;"><select id="itemNameSl'+m+'" class="select2 form-control itemName" onchange="itemVal(this)" name="row['+m+'][ItemId]"><option selected value="'+value.ItemId+'">'+value.ItemCode+'  ,   '+value.ItemName+'  ,   '+value.SKUNumber+'</option>@foreach ($itemSrcedho as $itemSrcedho)<option value="{{ $itemSrcedho->id }}">{{ $itemSrcedho->Code }} , {{ $itemSrcedho->Name }} , {{ $itemSrcedho->SKUNumber }}</option>@endforeach </select></td>'+
                        '<td style="width:10%"><select id="uom'+m+'" class = "select2 form-control uom" onchange = "uomVal(this)" name = "row['+m+'][uom]"><option selected disabled value="'+value.DefaultUOMId+'">'+value.UomName+'</option></select></td>'+
                        '<td style="width:11%"><input type="number" name="row['+m+'][Quantity]" placeholder="Quantity" id="quantity'+m+'" class="quantity form-control numeral-mask" onkeyup="CalculateTotal(this)" value="'+value.Quantity+'" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;"/></td>'+
                        '<td style="width:12%"><input type="number" name="row['+m+'][UnitCost]" placeholder="Unit Cost" id="unitcost'+m+'" class="unitcost form-control numeral-mask" onkeyup="CalculateTotal(this)" value="'+value.UnitCost+'" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="width:12%"><input type="number" name="row['+m+'][BeforeTaxCost]" id="beforetax'+m+'" class="beforetax form-control numeral-mask" readonly="true" value="'+value.BeforeTaxCost+'" style="font-weight:bold;"/></td>'+
                        '<td style="width:12%" class="vatproperty"><input type="number" name="row['+m+'][TaxAmount]" id="taxamounts'+m+'" class="taxamount form-control numeral-mask" readonly="true" value="'+value.TaxAmount+'" style="font-weight:bold;"/></td>'+
                        '<td style="width:12%" class="vatproperty"><input type="number" name="row['+m+'][TotalCost]" id="total'+m+'" class="total form-control numeral-mask" readonly="true" value="'+value.TotalCost+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][Common]" id="common'+m+'" class="common form-control" readonly="true" value="'+value.recdetcommon+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][TransactionType]" id="TransactionType'+m+'" class="TransactionType form-control" readonly="true" value="Receiving" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][ItemType]" id="ItemType'+m+'" class="ItemType form-control" readonly="true" value="'+value.ItemType+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][StoreId]" id="storeid'+m+'" class="storeid form-control" readonly="true" value="'+value.recdetstoreid+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][DefaultUOMId]" id="DefaultUOMId'+m+'" class="DefaultUOMId form-control" value="'+value.DefaultUOMId+'" readonly="true" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][NewUOMId]" id="NewUOMId'+m+'" class="NewUOMId form-control" readonly="true" value="'+value.NewUOMId+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][ConversionAmount]" id="ConversionAmount'+m+'" class="ConversionAmount form-control" value="'+value.ConversionAmount+'" readonly="true" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][ConvertedQuantity]" id="ConvertedQuantity'+m+'" class="ConvertedQuantity form-control" readonly="true" value="'+value.ConvertedQuantity+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][RetailerPrice]" id="RetailerPrice'+m+'" class="RetailerPrice form-control" readonly="true" value="'+value.RetailerPrice+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][Wholeseller]" id="Wholeseller'+m+'" class="Wholeseller form-control" readonly="true" value="'+value.Wholeseller+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][tax]" id="tax'+m+'" class="tax form-control" readonly="true" value="15" style="font-weight:bold;"/></td>'+
                        '<td style="width:3%;text-align:center"><button type="button" class="btn btn-light btn-sm addsernum" style="display:'+vis+';color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="addser(this)" title="Add serial number or expire date for '+value.ItemCode+' ,   '+value.ItemName+'  ,   '+value.SKUNumber+' item!"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button><button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireSerialNumber]" id="RequireSerialNumber'+m+'" class="RequireSerialNumber form-control" readonly="true" value="'+value.ReSerialNm+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][RequireExpireDate]" id="RequireExpireDate'+m+'" class="RequireExpireDate form-control" readonly="true" value="'+value.ReExpDate+'" style="font-weight:bold;"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][insertedqty]" id="insertedqty'+i+'" class="insertedqty form-control" readonly="true" style="font-weight:bold;" value="'+value.Quantity+'"/></td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td></tr>'
                    );
                    $("#itemNameSl"+m).select2();
                    $('#numberofItemsLbl').text(j);
                    $('#select2-itemNameSl'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('#select2-uom'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                });
                CalculateGrandTotal();
            });
            $('#holdEditTable').DataTable({
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
                    url: '/showholDetail/' + holdIdVar,
                    type: 'DELETE',
                    dataType: "json",
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
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'HeaderId',
                        name: 'HeaderId',
                        'visible': false
                    },
                    {
                        data: 'ItemCode',
                        name: 'ItemCode'
                    },
                    {
                        data: 'ItemName',
                        name: 'ItemName'
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber'
                    },
                    {
                        data: 'UOM',
                        name: 'UOM'
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity'
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost'
                    },
                    {
                        data: 'BeforeTaxCost',
                        name: 'BeforeTaxCost'
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount'
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],

            });

            $("#dynamicTable").show();
            $("#adds").show();
            $("#holdEditTable").hide();
            $("#holdEditDiv").hide();
            $("#addhold").hide();
            $("#pricingTable").show();
            $("#receivingEditTable").hide();
            $("#receivingEditDiv").hide();
            $("#addreceiving").hide();
            $("#saveHoldbutton").hide();
            $("#savebutton").show();
            $("#printgrvdiv").show();
            $("#checkboxVali").val("1");
            // var oTable = $('#holdEditTable').dataTable();
            // oTable.fnDraw(false);
            // $('#holdEditTable').DataTable().ajax.reload();
        }
        //end edit hold modal open

        //Open Show modal
        $('.hideModal').click(function() {
            var recIdVar = $(this).data('id');
            $('#hiderecid').val(recIdVar);
            $('#hidereceivingmodal').modal('show');
            $('#hiderecbtn').prop("disabled", false);
        });
        //End Show modal

        //Open Show modal
        //$('body').on('click', '.showModal', function() {
        function showModal(recIdVar){
            $('#showrecid').val(recIdVar);
            $('#showreceivingmodal').modal('show');
            $('#showrecbtn').prop("disabled", false);
        }
        //End Show modal

        //edit hold modal open
        
        function editrecdata(recIdVar) {
            var customercat="";
            $('.select2').select2();
            var cdatevar = $('#cdatevals').val();
            var comptype = '<option value="1">Owner</option><option value="2">Customer</option>';
            var commoditysourcedata = $("#commoditysourcedefault > option").clone();
            var supplierdata = $("#supplierdefault > option").clone();
            var prdtype = $("#producttypedefault > option").clone();
            var commsrc = $("#commoditysourcedefault > option").clone();
            var defaultcomptype = "";
            var defaultponumber = "";
            var fore_color = "";
            var statusvals = "";
            var fyearrec = "";
            var fyearcurr = "";
            var fyearstore = "";
            var rectype = "";
            var product_type = "";
            $("#operationtypes").val("2");
            $('#CompanyType').empty();
            $('#CommoditySource').empty();
            $('#supplier').empty();
            $('#PONumber').empty();
            $("#commDynamicTable > tbody").empty();
            $("#dynamicTable > tbody").empty();
            $('.productcls').hide();
            $('.commprop').hide();
            j2 = 0;
            j = 0;
            getPoList();
            $.ajax({
                url: '/recevingedit'+'/'+recIdVar,
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
                    
                    statusvals = data.Status;
                    fyearrec = data.fiscalyear;
                    fyearcurr = data.fiscalyr;
                    fyearstore = data.fiscalyrval;
                    rectype = data.rectype;
                    product_type = data.product_type;
                    
                    if (statusvals == "Void") {
                        toastrMessage('error',"You cant update on this status","Error");
                    }
                    // else if(parseFloat(fyearrec)!=parseFloat(fyearstore)){
                    //     toastrMessage('error',"You cant update a closed fiscal year transaction","Error");
                    // }
                    else{
                        $.each(data.recData, function(key,value) {
                            defaultponumber='<option selected value='+value.PoId+'>'+value.porderno+'     ,     '+value.Name+'     ,     '+value.TinNumber+'</option>';
                            $('#receivingId').val(recIdVar);
                            $('#receivingnumberi').val(value.DocumentNumber);
                            $('#DeliveryOrderNo').val(value.DeliveryOrderNo);
                            $('#DispatchStation').val(value.DispatchStation);
                            $('#store').val(value.StoreId).select2();
                            $('#ReceivedBy').val(value.ReceivedBy).select2();
                            $('#DriverName').val(value.DriverName);
                            $('#PlateNumber').val(value.TruckPlateNo);
                            $('#DriverPhoneNumber').val(value.DriverPhoneNo);
                            $('#DeliveredBy').val(value.DeliveredBy);
                            flatpickr('#ReceivedDate', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:cdatevar});
                            $('#ReceivedDate').val(value.ReceivedDate);
                            $('#Remark').val(value.Memo);

                            if(parseInt(value.CompanyType)==1){
                                $('.customerdiv').hide();
                                defaultcomptype='<option selected value="1">Owner</option>';
                            }
                            else if(parseInt(value.CompanyType)==2){
                                $('.customerdiv').show();
                                defaultcomptype='<option selected value="2">Customer</option>';
                                $('#Customer').val(value.CustomerOrOwner).select2();
                            }
                            
                            $('#CommodityType').val(value.CommodityType).select2({minimumResultsForSearch: -1});
                            if(parseInt(value.Type)==1){
                                $('#supplier').append(supplierdata);
                                $("#supplier option[value="+value.CustomerId+"]").remove(); 
                                $('#supplier').append('<option selected value='+value.CustomerId+'>'+value.Name+'   ,   '+value.TinNumber+'   ,   '+value.PhoneNumber+'   ,   '+value.OfficePhone+'</option>').select2({minimumResultsForSearch: -1});
                                
                                $('#ProductType').append(prdtype);
                                $("#ProductType option[value="+value.ProductType+"]").remove(); 
                                $('#ProductType').append('<option selected value='+value.ProductType+'>'+value.ProductType+'</option>').select2({minimumResultsForSearch: -1});
                                
                                $('#CommoditySource').append(commsrc);
                                $("#CommoditySource option[value="+value.CommoditySource+"]").remove(); 
                                $('#CommoditySource').append('<option selected value='+value.CommoditySource+'>'+value.CommoditySource+'</option>').select2();

                                $('#CompanyType').append(comptype);
                                $("#CompanyType option[value="+value.CompanyType+"]").remove(); 
                                $("#CompanyType option[value=''").remove(); 
                                $('#CompanyType').append(defaultcomptype).select2
                                ({
                                    minimumResultsForSearch: -1
                                });
                                $('#ponumdiv').hide();
                            }
                            else if(parseInt(value.Type)==2){
                                $('#CommoditySource').append('<option selected value='+value.CommoditySource+'>'+value.CommoditySource+'</option>').select2({minimumResultsForSearch: -1});
                                $('#supplier').append('<option selected value='+value.CustomerId+'>'+value.Name+'   ,   '+value.TinNumber+'   ,   '+value.PhoneNumber+'   ,   '+value.OfficePhone+'</option>').select2({minimumResultsForSearch: -1,dropdownCssClass : 'cusmidprp'});
                                $('#ProductType').append('<option selected value='+value.ProductType+'>'+value.ProductType+'</option>').select2({minimumResultsForSearch: -1});
                                $('#CompanyType').append(defaultcomptype).select2({minimumResultsForSearch: -1});
                                $('#ponumdiv').show();
                            }

                            if(value.ProductType=="Goods"){
                                $('#goodsdiv').show();
                            }
                            else if(value.ProductType=="Commodity"){
                                $('#commoditydiv').show();
                            }

                            $('#ReceivingType').val(value.Type).select2({minimumResultsForSearch: -1});
                            $("#PONumber option[value="+value.PoId+"]").remove(); 
                            $('#PONumber').append(defaultponumber).select2({dropdownCssClass : 'cusmidprp'});

                            if(value.FileName==null){
                                $("#docBtn").hide();
                                $("#documentuploadlinkbtn").hide();
                                $("#documentuploadlinkbtn").text(value.FileName);
                                $("#documentuploadfilelbl").val(value.FileName);
                            }
                            else if(value.FileName!=null){
                                $("#docBtn").show();
                                $("#documentuploadlinkbtn").show();
                                $("#documentuploadlinkbtn").text(value.FileName);
                                $("#documentuploadfilelbl").val(value.FileName);
                            }

                            if(value.Status=="Draft"){
                                fore_color = "#A8AAAE";
                            }
                            else if(value.Status=="Pending"){
                                fore_color = "#f6c23e";
                            }
                            else if(value.Status=="Verified"){
                                fore_color = "#4e73df";
                            }
                            else if(value.Status=="Received" || value.Status=="Confirmed"){
                                fore_color = "#1cc88a";
                            }
                            else{
                                fore_color = "#e74a3b";
                            }
                            $("#statusdisplay").html(`<span style='color:${fore_color};font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:16px;'>${value.DocumentNumber} ,  ${value.Status}</span>`);
                        });

                        if(product_type == 1){
                            $.each(data.origindata, function(key, value) {
                                ++i2;
                                ++m2;
                                ++j2;

                                if(parseInt(j2)%2===0){
                                    borcolor="#f8f9fa";
                                }
                                else{
                                    borcolor="#FFFFFF";
                                }

                                $("#commDynamicTable > tbody").append('<tr id="rowind'+m2+'" class="mb-1" style="background-color:'+borcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                                    '<span class="badge badge-center rounded-pill bg-secondary">'+j2+'</span>'+
                                '</td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m2+'][vals]" id="vals'+m2+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m2+'"/></td>'+
                                '<td style="width:96%;">'+
                                    '<div class="row">'+
                                        '<div class="col-xl-6 col-md-6 col-lg-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                                            '<div class="row">'+
                                                '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                                    '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="FloorMap'+m2+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m2+'][FloorMap]"></select>'+
                                                '</div>'+
                                                '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                                    '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="CommType'+m2+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m2+'][CommType]"></select>'+
                                                '</div>'+
                                                '<div class="col-xl-6 col-md-4 col-lg-6 mb-1">'+
                                                    '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="Origin'+m2+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m2+'][Origin]"></select>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="row">'+
                                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                    '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="Grade'+m2+'" class="select2 form-control Grade" onchange="GradeFn(this)" name="row['+m2+'][Grade]"></select>'+
                                                '</div>'+
                                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                    '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="ProcessType'+m2+'" class="select2 form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m2+'][ProcessType]"></select>'+
                                                '</div>'+
                                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                    '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="CropYear'+m2+'" class="select2 form-control CropYear" onchange="CropYearFn(this)" name="row['+m2+'][CropYear]"></select>'+
                                                '</div>'+
                                                '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                    '<label style="font-size: 12px;">Remark</label>'+
                                                    '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m2+'][Remark]" id="Remark'+m2+'">'+value.Remark+'</textarea>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-xl-4 col-md-4 col-lg-4" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                                            '<div class="row">'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                    '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<select id="Uom'+m2+'" class="select2 form-control Uom" onchange="UomFn(this)" name="row['+m2+'][Uom]"></select>'+
                                                '</div>'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                    '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<input type="number" name="row['+m2+'][NumOfBag]" placeholder="Write Number of bag here" id="NumOfBag'+m2+'" class="NumOfBag form-control numeral-mask commnuminp" onkeyup="NumOfBagFn(this)" onkeypress="return ValidateOnlyNum(event);" step="any"/>'+
                                                '</div>'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                    '<label style="font-size: 12px;">Bag Weight by KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<input type="number" name="row['+m2+'][TotalBagWeight]" placeholder="Bag weight" id="TotalBagWeight'+m2+'" class="TotalBagWeight form-control numeral-mask commnuminp" onkeyup="BagWeightFn(this)" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;" step="any"/>'+
                                                '</div>'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                                    '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                    '<input type="number" name="row['+m2+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m2+'" class="TotalKg form-control numeral-mask commnuminp" onkeyup="TotalKgFn(this)" onblur="TotalKgErrFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                                '</div>'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                                    '<label style="font-size: 12px;">Net KG<i class="fa-solid fa-circle-info" title="Total KG - Bag Weight by KG"></i></label>'+
                                                    '<input type="number" name="row['+m2+'][NetKg]" placeholder="Write Net KG here..." id="NetKg'+m2+'" class="NetKg form-control numeral-mask commnuminp" onkeyup="NetKgFn(this)" onblur="NetKgErrFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                                '</div>'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                                    '<label style="font-size: 12px;">Feresula<i class="fa-solid fa-circle-info" title="Net KG / 17"></i></label>'+
                                                    '<input type="number" name="row['+m2+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m2+'" class="Feresula form-control numeral-mask commnuminp" onkeypress="return ValidateNum(event);" step="any"/>'+
                                                '</div>'+
                                                '<div class="col-xl-4 col-md-4 col-lg-4 mb-0"></div>'+
                                                '<div class="col-xl-8 col-md-8 col-lg-8 mb-0">'+
                                                    '<label style="font-size: 12px;font-weight:bold;" id="varianceLbl'+m2+'"></label>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-xl-2 col-md-2 col-lg-2">'+
                                            '<div class="row" id="podatatbl'+m2+'" style="display:none;">'+
                                                '<div class="col-xl-12 col-md-12 col-lg-12 mt-0" style="text-align:center;">'+
                                                    '<label style="font-size: 13px;"><b>Requested Amount</b></label>'+
                                                '</div>'+
                                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;" id="reqnumofbaglbl'+m2+'">No. of Bag</label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;font-weight:bold;" id="reqnumofbag'+m2+'"></label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;" id="reqweightkglbl'+m2+'">Weight by KG</label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;font-weight:bold;" id="reqweightkg'+m2+'"></label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;" id="reqferesulalbl'+m2+'">Feresula</label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;font-weight:bold;" id="reqferesula'+m2+'"></label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-12 col-md-12 col-lg-12 mt-0" style="text-align:center;">'+
                                                    '<label style="font-size: 13px;"><b>Remaining Amount</b></label>'+
                                                '</div>'+
                                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;" id="remnumofbaglbl'+m2+'">No. of Bag</label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;font-weight:bold;" id="remnumofbag'+m2+'"></label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;" id="remweightkglbl'+m2+'">Weight by KG</label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;font-weight:bold;" id="remweightkg'+m2+'"></label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;" id="remferesulalbl'+m2+'">Feresula</label>'+
                                                '</div>'+ 
                                                '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                    '<label style="font-size: 10px;font-weight:bold;" id="remferesula'+m2+'"></label>'+
                                                '</div>'+ 
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                                '<td style="width:2%;text-align:right;vertical-align: top;">'+
                                    '<button type="button" id="commremovebtn'+m2+'" class="btn btn-light btn-sm commremove-tr" style="color:#ea5455;background-color:'+borcolor+';border-color:'+borcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                                '</td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][reUnitCost]" id="reUnitCost'+m2+'" class="reUnitCost form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][remBagNum]" id="remBagNum'+m2+'" class="remBagNum form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][remKg]" id="remKg'+m2+'" class="remKg form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][bagWeight]" id="bagWeight'+m2+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][uomFactor]" id="uomFactor'+m2+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][varianceshortage]" id="varianceshortage'+m2+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="number" name="row['+m2+'][varianceoverage]" id="varianceoverage'+m2+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m2+'][podetid]" id="podetid'+m2+'" class="podetid form-control" readonly="true" style="font-weight:bold;" value="'+value.PoDetId+'"/></td>'+
                                '<td style="display:none;"><input type="hidden" name="row['+m2+'][id]" id="id'+m2+'" class="id form-control" readonly="true" style="font-weight:bold;" value="'+value.id+'"/></td>'+
                                '</tr>');

                                var defaultfloormap='<option selected value='+value.LocationId+'>'+value.LocationName+'</option>';
                                var defaultcommodity='<option selected value='+value.CommodityId+'>'+value.Origin+'</option>';
                                var defaultcommoditytype='<option selected value='+value.CommTypeId+'>'+value.CommType+'</option>';
                                var defaultgrade='<option selected value='+value.Grade+'>'+value.GradeName+'</option>';
                                var defaultcropyear='<option selected value='+value.CropYearData+'>'+value.CropYearData+'</option>';
                                var defaultprocesstype='<option selected value='+value.ProcessType+'>'+value.ProcessType+'</option>';
                                var defaultuom='<option selected value='+value.DefaultUOMId+'>'+value.UomName+'</option>';

                                var defaultoption = '<option selected value=""></option>';
                                var originoptions = $("#commoditydefault > option").clone();
                                $('#Origin'+m2).append(originoptions);
                                $("#Origin"+m2+" option[value!="+value.CommodityId+"]").remove(); 

                                var cropyearoptions = $("#cropyeardefault > option").clone();
                                $('#CropYear'+m2).append(cropyearoptions);
                                $("#CropYear"+m2+" option[value="+value.CropYear+"]").remove(); 

                                var processtypeoption = $("#processtypedefault > option").clone();
                                $('#ProcessType'+m2).append(processtypeoption);
                                $("#ProcessType"+m2+" option[value="+value.ProcessType+"]").remove(); 

                                var uomdataoptions = $("#uomdefault > option").clone();
                                $('#Uom'+m2).append(uomdataoptions);
                                $("#Uom"+m2+" option[value="+value.DefaultUOMId+"]").remove(); 

                                if(parseInt(rectype)==2){
                                    $("#Origin"+m2+" option[label!="+value.PoId+"]").remove(); 
                                    $('#CropYear'+m2).empty();
                                    $('#ProcessType'+m2).empty();
                                    $('#Uom'+m2).empty();
                                    $('#podatatbl'+m2).show();
                                }
                                $('#Origin'+m2).append(defaultcommodity);
                                $('#CropYear'+m2).append(defaultcropyear);
                                $('#ProcessType'+m2).append(defaultprocesstype);
                                $('#Uom'+m2).append(defaultuom);
                                
                                //To remove duplicate values in the dropdown
                                $('#Origin'+m2).find('option').each(function() {
                                    var currentValue = $(this).val();
                                    $(this).siblings('[value="' + currentValue + '"]').remove();
                                });

                                $('#Origin'+m2).select2
                                ({
                                    placeholder: "Select Commodity here",
                                    dropdownCssClass : 'commprp',
                                    minimumResultsForSearch: -1
                                });

                                var origindata = $('#Origin'+m2).find('option[value="' + value.itemid + '"]');
                                var commtype=origindata.attr('title');
                                var commtypeoptions = $("#commoditytypedefault > option").clone();
                                //$('#CommType'+m2).append(commtypeoptions);
                                //$("#CommType"+m2+" option[value="+value.CommTypeId+"]").remove(); 
                                $('#CommType'+m2).append(defaultcommoditytype);
                                $('#CommType'+m2).select2
                                ({
                                    placeholder: "Select Commodity type here",
                                    dropdownCssClass : 'cusprop',
                                    minimumResultsForSearch: -1
                                });

                                $('#Uom'+m2).select2
                                ({
                                    placeholder: "Select UOM/Bag here",
                                    dropdownCssClass : 'cusprop',
                                    minimumResultsForSearch: -1
                                });

                                var uomopt = $('#uomdefault').find('option[value="' +value.DefaultUOMId+ '"]');
                                var uomfactor=uomopt.attr('title');
                                var uombagweight=uomopt.attr('label');

                                $('#uomFactor'+m2).val(uomfactor);
                                $('#bagWeight'+m2).val(uombagweight);

                                $('#CropYear'+m2).select2
                                ({
                                    placeholder: "Select Crop year here",
                                    dropdownCssClass : 'cusprop',
                                    minimumResultsForSearch: -1
                                });
                                
                                $('#ProcessType'+m2).select2
                                ({
                                    placeholder: "Select Process type here",
                                    dropdownCssClass : 'cusprop',
                                    minimumResultsForSearch: -1
                                });

                                var gradeoption = $("#gradedefault > option").clone();
                                $('#Grade'+m2).append(gradeoption);
                                $("#Grade"+m2+" option[value="+value.Grade+"]").remove(); 
                                $('#Grade'+m2).append(defaultgrade);
                                $('#Grade'+m2).select2
                                ({
                                    placeholder: "Select Grade here",
                                    dropdownCssClass : 'cusprop',
                                });

                                var floormapopt = $("#locationdefault > option").clone();
                                $('#FloorMap'+m2).append(floormapopt);
                                $("#FloorMap"+m2+" option[title!="+value.StoreId+"]").remove(); 
                                $("#FloorMap"+m2+" option[value="+value.LocationId+"]").remove(); 
                                $('#FloorMap'+m2).append(defaultfloormap);
                                $('#FloorMap'+m2).select2
                                ({
                                    placeholder: "Select Floor map here",
                                });
                                
                                $('#NumOfBag'+m2).val(value.NumOfBag);
                                $('#TotalBagWeight'+m2).val(value.BagWeight);
                                $('#TotalKg'+m2).val(value.TotalKg);
                                $('#NetKg'+m2).val(value.NetKg);
                                $('#reUnitCost'+m2).val(value.UnitCost);
                                $('#Feresula'+m2).val(value.Feresula);
                                $('#varianceshortage'+m2).val(value.VarianceShortage);
                                $('#varianceoverage'+m2).val(value.VarianceOverage);

                                $('#Feresula'+m2).prop("readonly",true);
                                $('#NumOfBag'+m2).prop("readonly",false);
                                $('#NetKg'+m2).prop("readonly",true);

                                $('#reqnumofbag'+m2).html(value.qty);
                                $('#reqweightkg'+m2).html(value.totalkg);
                                $('#reqferesula'+m2).html(value.feresula);

                                $('#remnumofbag'+m2).html(value.qty);
                                $('#remweightkg'+m2).html(value.totalkg);
                                $('#remferesula'+m2).html(value.feresula);

                                $('#remBagNum'+m2).val(value.qty);
                                $('#remKg'+m2).val(value.totalkg);

                                $('#podetid'+m2).val(value.PoDetId);

                                if(parseFloat(value.VarianceShortage)>0){
                                    $('#varianceLbl'+m2).html("Variance Shortage: "+numformat(value.VarianceShortage)+" KG");
                                }
                                else if(parseFloat(value.VarianceOverage)>0){
                                    $('#varianceLbl'+m2).html("Variance Overage: "+numformat(value.VarianceOverage)+" KG");
                                }
                                else if(parseFloat(value.VarianceShortage)==0 || isNaN(parseFloat(value.VarianceShortage)) && parseFloat(value.VarianceOverage)==0 || isNaN(parseFloat(value.VarianceOverage))){
                                    $('#varianceLbl'+m2).html("");
                                }

                                if(parseInt(rectype)==2){
                                    CalculateReqAmount(m2);
                                }

                                $('#select2-FloorMap'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $('#select2-CommType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $('#select2-Origin'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $('#select2-Grade'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $('#select2-ProcessType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $('#select2-CropYear'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $('#select2-Uom'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            });

                            $('.commprop').show();
                            if(parseInt(rectype)==1){
                                $('#commadds').show();
                            }
                            else if(parseInt(rectype)==2){
                                $('#commadds').hide();
                            }
                            CalculateCommTotal();
                            commRenumberRows();
                        }

                        else if(product_type == 2){
                            $.each(data.origindata, function(key, value) {
                                ++i;
                                ++j;
                                ++m;

                                $("#dynamicTable > tbody").append(`<tr>
                                    <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                                    <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                                    <td style="width:13%">
                                        <select id="location${m}" class="select2 form-control location" onchange="locationFn(this)" name="row[${m}][location]"></select>
                                    </td>
                                    <td style="width:14%">
                                        <select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select>
                                    </td>
                                    <td style="width:13%">
                                        <select id = "uom${m}" class ="select2 form-control uom" onchange = "uomVal(this)" name = "row[${m}][uom]"></select>
                                    </td>
                                    <td style="width:13%">
                                        <input type="number" name="row[${m}][Quantity]" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="qtyFn(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;" value="${value.Quantity}"/>
                                    </td>
                                    <td style="width:13%;background-color:#efefef;text-align:center">
                                        <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="requested_qty_inp${m}"></label>
                                        <input type="hidden" name="row[${m}][requested_qty]" id="requested_qty${m}" placeholder="Requested Quantity" class="requested_qty form-control numeral-mask" onkeypress="return ValidateNum(event);"/>
                                    </td>
                                    <td style="width:13%;background-color:#efefef;text-align:center">
                                        <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="remaining_qty_inp${m}"></label>
                                        <input type="hidden" name="row[${m}][remaining_qty]" id="remaining_qty${m}" placeholder="Remaining Quantity" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/>
                                    </td>
                                    <td style="width:15%;">
                                        <input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" value="${value.Memo == "" || value.Memo == null ? "" : value.Memo}"/>
                                    </td>
                                    <td style="width:3%;text-align:center;">
                                        <button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="addser(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button>
                                        <button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                                    </td>
                                </tr>`);

                                var default_location = `<option selected value="${value.LocationId}">${value.LocationName}</option>`;
                                var default_item = `<option selected value="${value.ItemId}">${value.item_name}</option>`;

                                var location = $("#locationdefault > option").clone();
                                $(`#location${m}`).append(location);
                                $(`#location${m} option[title!="${value.StoreId}"]`).remove();
                                $(`#location${m} option[value="${value.LocationId}"]`).remove();
                                $(`#location${m}`).append(default_location);
                                $(`#location${m}`).select2();

                                var item_data = $("#itemnamefooter > option").clone();
                                $(`#itemNameSl${m}`).append(item_data); 
                                $(`#itemNameSl${m} option[value="${value.ItemId}"]`).remove();
                                $(`#itemNameSl${m}`).append(default_item);
                                $(`#itemNameSl${m}`).select2({dropdownCssClass : 'commprp'});

                                $(`#uom${m}`).append(`<option selected value="${value.DefaultUOMId}">${value.UomName}</option>`);
                                $(`#uom${m}`).select2({minimumResultsForSearch: -1});

                                $(`#select2-location${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                                
                                if(parseInt(rectype) == 2){
                                    CalculateReqAmount(m);
                                }
                                renumberRows();
                            });
                            $('.commprop').hide();
                        }
                        $('#newreceivingmodaltitles').html('Edit Receiving');
                        $('#savebutton').text('Update');
                        $('#savebutton').prop("disabled",false);
                        $('.errordatalabel').html("");
                        $('#inlineForm').modal('show');
                    }
                }
            });
        }
        //end edit hold modal open

        //start edit hold item modal
        $('body').on('click', '.editHoldItem', function() { 
            var holdItemIdVar = $(this).data('id');
            $('#recId').val(holdItemIdVar);
            var uomname = $(this).data('uom');
            var itemid = "";
            $('#newholdmodal').modal('show');
            $.get("/holditemedit" + '/' + holdItemIdVar, function(data) {
                $('#addHoldItem').selectpicker('val', data.recHoldId.ItemId).trigger('change');
                $('#quantityhold').val(data.recHoldId.Quantity);
                $('#unitcosthold').val(data.recHoldId.UnitCost);
                $('#beforetaxhold').val(data.recHoldId.BeforeTaxCost);
                $('#taxamounthold').val(data.recHoldId.TaxAmount);
                $('#totalcosthold').val(data.recHoldId.TotalCost);
                $('#stId').val(data.recHoldId.StoreId);
                $('#convertedqi').val(data.recHoldId.ConvertedQuantity);
                $('#convertedamnti').val(data.recHoldId.ConversionAmount);
                $('#newuomi').val(data.recHoldId.NewUOMId);
                $('#defaultuomi').val(data.recHoldId.DefaultUOMId);
                $('#editVal').val("1");
                $('#itemidi').val(data.recHoldId.ItemId);
                var newuom = $('#newuomi').val();
                var sid = $("#itemidi").val();
                $("#uoms").empty();
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getUOMS/' + sid,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var options = "<option selected value='" + newuom + "'>" + uomname +
                                "</option>";
                            $("#uoms").append(options);
                            var defname = data['defuom'];
                            var defid = data['defuomid'];
                            var taxper = data['taxpr'];
                            $("#taxpercenti").val(taxper);
                            var option = "<option value='" + defid + "'>" + defname +
                                "</option>";
                            $("#uoms").append(option);
                            var len = data['sid'].length;
                            for (var i = 0; i <= len; i++) {
                                var name = data['sid'][i].ToUnitName;
                                var id = data['sid'][i].ToUomID;
                                var option = "<option value='" + id + "'>" + name + "</option>";
                                $("#uoms").append(option);
                            }

                            $("#uoms").select2();
                        }
                    },
                });
            });
            $('#savenewreceiving').hide();
            $('#savenewhold').show();
        });
        //end edit hold item modal

        //start edit hold item modal
        $('body').on('click', '.editRecDatas', function() {
            $('#savenewreceiving').text("Update");
            var recItemVar = $(this).data('id');
            var uomname = $(this).data('uom');
            var itemid = "";
            $('#recevingedit').val(recItemVar);
            $('#newholdmodal').modal('show');
            $.get("/recitemedit" + '/' + recItemVar, function(data) {
                $('#addHoldItem').selectpicker('val', data.recDataId.ItemId);
                $('#quantityhold').val(data.recDataId.Quantity);
                $('#unitcosthold').val(data.recDataId.UnitCost);
                $('#beforetaxhold').val(data.recDataId.BeforeTaxCost);
                $('#taxamounthold').val(data.recDataId.TaxAmount);
                $('#totalcosthold').val(data.recDataId.TotalCost);
                $('#stId').val(data.recDataId.StoreId);
                $('#convertedqi').val(data.recDataId.ConvertedQuantity);
                $('#convertedamnti').val(data.recDataId.ConversionAmount);
                $('#newuomi').val(data.recDataId.NewUOMId);
                $('#defaultuomi').val(data.recDataId.DefaultUOMId);
                $('#editVal').val("1");
                $('#itemidi').val(data.recDataId.ItemId);
                var newuom = $('#newuomi').val();
                var sid = $("#itemidi").val();
                $("#uoms").empty();
                var registerForm = $("#RegisterRec");
                var formData = registerForm.serialize();
                $.ajax({
                    url: 'getUOMS/' + sid,
                    type: 'DELETE',
                    data: formData,
                    success: function(data) {
                        if (data.sid) {
                            var options = "<option selected value='" + newuom + "'>" + uomname +
                                "</option>";
                            $("#uoms").append(options);
                            var defname = data['defuom'];
                            var defid = data['defuomid'];
                            var taxper = data['taxpr'];
                            $("#taxpercenti").val(taxper);
                            var option = "<option value='" + defid + "'>" + defname +
                                "</option>";
                            $("#uoms").append(option);
                            var len = data['sid'].length;
                            for (var i = 0; i <= len; i++) {
                                var name = data['sid'][i].ToUnitName;
                                var id = data['sid'][i].ToUomID;
                                var option = "<option value='" + id + "'>" + name + "</option>";
                                $("#uoms").append(option);
                            }
                            $("#uoms").select2();
                        }
                    },
                });
            });
            var sid = $('#store').val();
            $('#receivingstoreid').val(sid);
            var hid = $('#receivingId').val();
            $('#receIds').val(hid);
            $('#savenewreceiving').show();
            $('#savenewhold').hide();
        });
        //end edit hold item modal

        //Starts Hold Data Delete Modal With Value 
        $('#holddataremoved').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #holddataremove').val(id);
        });
        //End Hold Data Delete Modal With Value

        //Delete Records Starts
        $('#deleteholddata').click(function() {
            var delid = document.forms['deleteholddataform'].elements['holddataremove'].value;
            var deleteForm = $("#deleteholddataform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/deleteholddataw/' + delid,
                type: 'DELETE',
                data: formData,
                beforeSend: function() {
                    $('#deleteholddata').text('Deleting...');
                    $('#deleteholddata').prop("disabled", true);
                },
                success: function(data) {
                    $('#deleteholddata').text('Delete');
                    $('#deleteholddata').prop("disabled", false);
                    toastrMessage('success',"Hold Deleted","Success");
                    var oTable = $('#laravel-datatable-crud-hold').dataTable();
                    oTable.fnDraw(false);
                    $('#laravel-datatable-crud-hold').DataTable().ajax.reload();
                    $("#holddataremoved").modal('hide');
                    $('#recId').val("");
                }
            })
        });
        //Delete Records Ends

        //Starts Hold Item Delete Modal With Value 
        $('#holdremovemodal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var hid = button.data('hid');
            var modal = $(this);
            modal.find('.modal-body #holdremoveid').val(id);
            modal.find('.modal-body #holdremoveheaderid').val(hid);
        });
        //End Hold Item Delete Modal With Value

        //Delete Hold Item Records Starts
        $('#deleteholdbtn').click(function() {
            var delid = document.forms['deleteholditemform'].elements['holdremoveid'].value;
            var deleteForm = $("#deleteholditemform");
            var formData = deleteForm.serialize();
            $.ajax({
                url: '/deleteholditemdata/' + delid,
                type: 'DELETE',
                data: formData,
                beforeSend: function() {
                    $('#deleteholdbtn').text('Deleting...');
                    $('#deleteholdbtn').prop("disabled", true);
                },
                success: function(data) {
                    $('#deleteholdbtn').text('Delete');
                    $('#deleteholdbtn').prop("disabled", false);
                    toastrMessage('success',"Deleted","Success");
                    var oTable = $('#holdEditTable').dataTable();
                    oTable.fnDraw(false);
                    $('#holdEditTable').DataTable().ajax.reload();
                    $("#holdremovemodal").modal('hide');
                    $('#recId').val("");
                    $('#numberofItemsLbl').text(data.Totalcount);
                    var len = data.PricingVal.length;
                    for (var i = 0; i <= len; i++) {
                        $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                        $('#taxLbl').html(numformat(data.PricingVal[i].TaxAmount));
                        $('#grandtotalLbl').html(numformat(data.PricingVal[i].TotalCost));
                        $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                        $('#taxi').val(data.PricingVal[i].TaxAmount);
                        $('#grandtotali').val(data.PricingVal[i].TotalCost);
                        var stotal = parseFloat($('#subtotali').val());
                        var gtotal = parseFloat($('#grandtotali').val());
                        var withamnt = parseFloat($('#witholdMinAmounti').val());
                        var withprc = parseFloat($('#witholdPercenti').val());
                        if (stotal >= withamnt && withprc > 0) {
                            var st = parseFloat(stotal);
                            var wp = parseFloat(withprc);
                            var tt = 0;
                            var np = 0;
                            tt = (st * wp) / 100;
                            np = parseFloat(gtotal) - tt;
                            $('#witholdingAmntLbl').html((tt.toFixed(2)));
                            $('#witholdingAmntin').val(tt.toFixed(2));
                            $('#netpayLbl').html((np.toFixed(2)));
                            $('#netpayin').val(np.toFixed(2));
                            $("#witholdingTr").show();
                            $("#netpayTr").show();
                        } else if (stotal < withamnt || withprc == 0) {
                            $('#witholdingAmntLbl').html("0");
                            $('#witholdingAmntin').val("0");
                            $('#netpayLbl').html("0");
                            $('#netpayin').val("0");
                            $("#witholdingTr").hide();
                            $("#netpayTr").hide();
                        }
                    }
                }
            })
        });
        //Delete Hold Item Records Ends

        //Starts Receiving Item Delete Modal With Value 
        $('#receivingremovemodal').on('show.bs.modal', function(event) {
            var numofitem = $("#numberofItemsLbl").html();
            $("#numofitemi").val(numofitem);
            var button = $(event.relatedTarget)
            var id = button.data('id');
            var hid = button.data('hid');
            var modal = $(this);
            modal.find('.modal-body #receivingremoveid').val(id);
            modal.find('.modal-body #receivingremoveheaderid').val(hid);

        });
        //End Receiving Item Delete Modal With Value

        //start edit hold item modal
        $('body').on('click', '.deleteRecDatas', function() {
            var numofitem = $("#numberofItemsLbl").html();

            if (parseFloat(numofitem) == 1) {
                toastrMessage('error',"You cant remove all items","Error");
            } else if (parseFloat(numofitem) >= 2) {

                $('#receivingremovemodal').modal('show');
                var button = $(event.relatedTarget)
                var id = button.data('id');
                var hid = button.data('hid');
                var modal = $(this);
                modal.find('.modal-body #receivingremoveid').val(id);
                modal.find('.modal-body #receivingremoveheaderid').val(hid);
            }
        });
        //end edit hold item modal

        //Delete Receiving Item Records Starts
        $('#deletereceivingbtn').click(function() {
            var num = $("#numofitemi").val();
            if (parseFloat(num) == 1) {
                toastrMessage('error',"You cant remove all items","Error");
            } else if (parseFloat(num) >= 2) {
                var delid = document.forms['deletereceivingitemform'].elements['receivingremoveid'].value;
                var deleteForm = $("#deletereceivingitemform");
                var formData = deleteForm.serialize();
                $.ajax({
                    url: '/deletereceivingitemdata/' + delid,
                    type: 'DELETE',
                    data: formData,
                    beforeSend: function() {
                        $('#deletereceivingbtn').text('Deleting...');
                        $('#deletereceivingbtn').prop("disabled", true);
                    },
                    success: function(data) {
                        $('#deletereceivingbtn').text('Delete');
                        $('#deletereceivingbtn').prop("disabled", false);
                        toastrMessage('success',"Deleted","Success");
                        var oTable = $('#receivingEditTable').dataTable();
                        oTable.fnDraw(false);
                        $("#receivingremovemodal").modal('hide');
                        $('#recId').val("");
                        $('#numberofItemsLbl').text(data.Totalcount);
                        var len = data.PricingVal.length;
                        for (var i = 0; i <= len; i++) {
                            $('#subtotalLbl').html(numformat(data.PricingVal[i].BeforeTaxCost));
                            $('#taxLbl').html(numformat(data.PricingVal[i].TaxAmount));
                            $('#grandtotalLbl').html(numformat(data.PricingVal[i].TotalCost));
                            $('#subtotali').val(data.PricingVal[i].BeforeTaxCost);
                            $('#taxi').val(data.PricingVal[i].TaxAmount);
                            $('#grandtotali').val(data.PricingVal[i].TotalCost);
                            var stotal = parseFloat($('#subtotali').val());
                            var gtotal = parseFloat($('#grandtotali').val());
                            var withamnt = parseFloat($('#witholdMinAmounti').val());
                            var withprc = parseFloat($('#witholdPercenti').val());
                            if (stotal >= withamnt && withprc > 0) {
                                var st = parseFloat(stotal);
                                var wp = parseFloat(withprc);
                                var tt = 0;
                                var np = 0;
                                tt = (st * wp) / 100;
                                np = parseFloat(gtotal) - tt;
                                $('#witholdingAmntLbl').html((tt.toFixed(2)));
                                $('#witholdingAmntin').val(tt.toFixed(2));
                                $('#netpayLbl').html((np.toFixed(2)));
                                $('#netpayin').val(np.toFixed(2));
                                $("#witholdingTr").show();
                                $("#netpayTr").show();
                            } else if (stotal < withamnt || withprc == 0) {
                                $('#witholdingAmntLbl').html("0");
                                $('#witholdingAmntin').val("0");
                                $('#netpayLbl').html("0");
                                $('#netpayin').val("0");
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide();
                            }
                        }
                    }
                })
            }
        });
        //Delete Receiving Item Records Ends

        //Start Resetting modal add hold
        function closeHoldAddModal() {
            $("#newHoldform")[0].reset();
            $('#addHoldItem').val(null).trigger('change');
            $('#addholdItem-error').html("");
            $('#addHoldQuantity-error').html("");
            $('#addHoldunitCost-error').html("");
            $('#addHoldbeforeTax-error').html("");
            $('#addHoldTaxAmount-error').html("");
            $('#addHoldTotalAmount-error').html("");
            $('#savenewreceiving').hide();
            $('#savenewhold').hide();
            $('#recId').val("");
            $('#recevingedit').val("");
            $('#editVal').val("0");
        }
        //End Resetting modal add hold

        //Start show hold info
        //$(document).on('click', '.DocInfo', function() {
        function DocInfo(recordId,vStatus){
            //var recordId = $(this).data('id');
            $('.infolbls').text("");
            $('#receivinginfomodaltitle').html("Hold Information Detail");
            var visibilitymode=false;
            if(parseInt(vStatus)==1){
                visibilitymode=true;
                $('.vatpropholdinfo').show();
            }
            else if(parseInt(vStatus)==2){
                visibilitymode=false;
                $('.vatpropholdinfo').hide();
                
            }
            $.get("/getWithNumber", function(data) {
                $('#witholdPercenti').val(data.witholdPer);
                $('#infowitholdingTitle').html("Witholding (" + data.witholdPer + "%)");
                $('#witholdMinAmounti').val(data.witholdAmnt);
            });
            $.get("/showHoldData" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    $('#infoDocType').text(data.holdHeader[i].Type);
                    $('#infoDocDocNo').text(data.holdHeader[i].DocumentNumber);
                    $('#infoDocCustomerCategory').text(data.holdHeader[i].CustomerCategory);
                    $('#infoDocCustomerName').text(data.holdHeader[i].CustomerName);
                    $('#infoDocPaymentType').text(data.holdHeader[i].PaymentType);
                    $('#infoVoucherStatus').text(data.holdHeader[i].VoucherStatusName);
                    $('#infoDocVoucherType').text(data.holdHeader[i].VoucherType);
                    $('#infoDocVoucherNumber').text(data.holdHeader[i].VoucherNumber);
                    $('#infoinvoicenumber').text(data.holdHeader[i].InvoiceNumber);
                    $('#infoDocMrcNumber').text(data.holdHeader[i].CustomerMRC);
                    $('#infoDocReceivingStore').text(data.holdHeader[i].StoreName);
                    $('#infoDocPurchaserName').text(data.holdHeader[i].PurchaserName);
                    $('#infoDocDate').text(data.holdHeader[i].TransactionDate);
                    $('#infoDocholdby').text(data.holdHeader[i].Username);
                    $('#infosubtotalLblh').html(numformat(data.holdHeader[i].SubTotal));
                    $('#infotaxLblh').html(numformat(data.holdHeader[i].Tax));
                    $('#infograndtotalLblh').html(numformat(data.holdHeader[i].GrandTotal));
                    $('#infowitholdinglblh').html(numformat(data.holdHeader[i].WitholdAmount));
                    $('#infoNetPayLblh').html((data.holdHeader[i].NetPay));
                    $('#infowitholdingih').val(data.holdHeader[i].WitholdAmount);
                    $('#infoNetPayih').val(data.holdHeader[i].NetPay);
                    $('#infosubtotalih').val(data.holdHeader[i].SubTotal);
                    $('#infotaxih').val(data.holdHeader[i].Tax);
                    $('#infograndtotalih').val(data.holdHeader[i].GrandTotal);
                    $('#infonumberofItemsLblh').text(data.count);
                    $('#infocreateddate').text(data.holdHeader[i].created_at);
                    var stotal = parseFloat($('#infosubtotalih').val());
                    var withamnt = parseFloat($('#witholdMinAmounti').val());
                    var withprc = parseFloat($('#witholdPercenti').val());
                    var cc = $('#infoDocCustomerCategory').text();
                    if (stotal >= withamnt && withprc > 0 && cc != "Foreigner-Supplier" && cc != "Person") {
                        $("#infowitholdingTrh").show();
                        $("#infonetpayTrh").show();
                    } else if (stotal < withamnt || withprc == 0 || cc === "Foreigner-Supplier" || cc ==="Person") {
                        $("#infowitholdingTrh").hide();
                        $("#infonetpayTrh").hide();
                    }

                    var voucherstatus=data.holdHeader[i].VoucherStatus;

                    // if(parseInt(voucherstatus)==1){
                    //     $('.vatpropholdinfo').show();
                    // }
                    // else if(parseInt(voucherstatus)==2){
                    //     $('.vatpropholdinfo').hide();
                    // }
                }
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
            $('#editconfirmdocbytr').show();
            $('#editconfirmdocdatetr').show();

            $('#docInfoItem').DataTable({
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
                    url: '/showholDetail/' + recordId,
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
                    },
                    {
                        data: 'SKUNumber',
                        name: 'SKUNumber',
                        width:'10%',
                    },
                    {
                        data: 'UOM',
                        name: 'UOM',
                        width:'10%',
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.','', '')
                    },
                    {
                        data: 'UnitCost',
                        name: 'UnitCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'BeforeTaxCost',
                        name: 'BeforeTaxCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'TaxAmount',
                        name: 'TaxAmount',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },
                    {
                        data: 'TotalCost',
                        name: 'TotalCost',
                        width:'10%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    }
                ],
                "columnDefs": [
                    {
                        "targets": [8,9],
                        "visible": visibilitymode,
                    },
                ]
            });

           
            $("#statustitles").html("");
            $("#docInfoModal").modal('show');
            $(".infoscl").collapse('show');
            $("#docRecInfoItem").hide();
            $("#infoRecDiv").hide();
            $("#docInfoItem").show();
            $("#infoHoldDiv").show();
            $('#changetopending').hide();
            $('#checkreceiving').hide();
            $('#confirmreceiving').hide();
            $('#witholdingSettleTable').hide();
            $('#settledLabelPr').hide();
            $('#notsettledLabelPr').hide();
            //var oTable = $('#docInfoItem').dataTable();
            //oTable.fnDraw(false);
            //$('#docInfoItem').DataTable().ajax.reload();
        }
        //End show hold info

        //Start show receiving doc info      
        function DocRecInfo(recordId,vStatus){
            //var recordId = $(this).data('id');
            //var statusval = $(this).data('status');
            $('#receivinginfomodaltitle').html("Receiving Information");
            $("#statusid").val(recordId);
            $("#recordIds").val(recordId);
            $('.datatableinfocls').hide();
            $('.recpropbtn').hide();
            $('#purchasedtab').html("");
            $('#returnedtab').html("");
            var visibilitymode = false;
            var lidata = "";
            var fore_color = "";
            var product_type = "";
            
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
                
                success: function(data) {
                    product_type = data.product_type;
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
                        $('#infodocumentuploadlinkbtn').text(value.FileName);
                        $('#infogrvfilename').val(value.FileName);
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
                            $("#invoiceStatusLbl").html(`<b style="color:#ff9f43">Waiting</b>`);
                        }
                        else if(parseInt(value.InvoiceStatus)==1){
                            $("#invoiceStatusLbl").html(`<b style="color:#7367f0">Partially-Received</b>`);
                        }
                        else if(parseInt(value.InvoiceStatus)==2){
                            $("#invoiceStatusLbl").html(`<b style="color:#28c76f">Fully-Received</b>`);
                        }

                        if(parseInt(value.ReturnStatus)==0){
                            $("#returnStatusLbl").html(`<b style="color:#ff9f43">Not-Returned</b>`);
                        }
                        else if(parseInt(value.ReturnStatus)==1){
                            $("#returnStatusLbl").html(`<b style="color:#7367f0">Partially-Returned</b>`);
                        }
                        else if(parseInt(value.ReturnStatus)==2){
                            $("#returnStatusLbl").html(`<b style="color:#28c76f">Fully-Returned</b>`);
                        }

                        if(statusvals==="Draft"){
                            $("#changetopending").show();
                            fore_color = "#A8AAAE";
                        }
                        else if(statusvals==="Pending"){
                            $("#backtodraft").show();
                            $("#checkreceiving").show();
                            fore_color = "#f6c23e";
                        }
                        else if(statusvals==="Verified"){
                            $("#confirmreceiving").show();
                            $("#backtopending").show();
                            fore_color = "#7367F0";
                        }
                        else if(statusvals==="Confirmed" || statusvals==="Partially-Received" || statusvals==="Fully-Received"){
                            $("#changetopending").hide();
                            $("#checkadjustment").hide();
                            $("#confirmadjustment").hide();
                            fore_color = "#1cc88a";
                        }
                        else{
                            $("#changetopending").hide();
                            $("#checkadjustment").hide();
                            $("#confirmadjustment").hide();
                            fore_color = "#e74a3b";
                        }

                        $("#statustitles").html(`<span style='color:${fore_color};font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:16px;'>${value.DocumentNumber} ,     ${statusvals == "Void" ? statusvals+"("+statusvalsold+")" : statusvals}</span>`);

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
                    
                    if(product_type == 1){
                        fetchCommodityData(recordId);
                        fetchReturnData(recordId);
                        $('#purchasedtab').html("Purchased Commodity");
                        $('#returnedtab').html("Returned Commodity");
                        $('#returnedtab').prop("disabled", false);
                    }
                    else if(product_type == 2){
                        fetchGoodsData(recordId);
                        $('#purchasedtab').html("Purchased Goods");
                        $('#returnedtab').html("");
                        $('#returnedtab').prop("disabled", true);
                    }
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
        }
        //End show receiving doc info

        function fetchGoodsData(recordId){
            $('#docInfoItem').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                autoWidth: false, 
                "order": [
                    [0, "asc"]
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
                    url: '/showRecCommodity/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:'3%'
                    },
                    {
                        data: 'LocationName',
                        name: 'LocationName',
                        width:'19%',
                    },
                    {
                        data: 'item_name',
                        name: 'item_name',
                        width:'20%',
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:'19%',
                    },
                    {
                        data: 'Quantity',
                        name: 'Quantity',
                        width:'19%',
                        render: $.fn.dataTable.render.number(',', '.',0, '')
                    },     
                    {
                        data: 'Remark',
                        name: 'Remark',
                        width:'20%',
                    },    
                ],
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

                    $(".propdtable").removeClass("active");
                    $(".propdtableBody").removeClass("active");
                    $("#purchasedtab").addClass("active");
                    $("#purchasedtabBody").addClass("active");

                    $("#goods_div").show();
                    $(".infoscl").collapse('show');
                    $("#docInfoModal").modal('show');
                    // $("#infoRecDiv").show();
                    // $("#docInfoItem").hide();
                    // $("#infoHoldDiv").hide();
                },
            });
        }

        function fetchCommodityData(recordId){
            $("#commodity_div").hide();
            $('#origindetailtable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                info: true,
                searchHighlight: true,
                autoWidth: false, 
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

                    $(".propdtable").removeClass("active");
                    $(".propdtableBody").removeClass("active");
                    $("#purchasedtab").addClass("active");
                    $("#purchasedtabBody").addClass("active");

                    $("#commodity_div").show();
                    $(".infoscl").collapse('show');
                    $("#docInfoModal").modal('show');
                    // $("#infoRecDiv").show();
                    // $("#docInfoItem").hide();
                    // $("#infoHoldDiv").hide();
                },
            });
        }

        function fetchReturnData(recordId){
            $('#commdatatable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                paging: false,
                searching: true,
                info: false,
                searchHighlight: true,
                autoWidth: false, 
                "order": [
                    [0, "desc"]
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
                    url: '/showReturnedCommodity/' + recordId,
                    type: 'DELETE',
                },
                columns: [
                    {
                        data:'DT_RowIndex',
                        width:"2%"
                    },
                    {
                        data: 'DocumentNumber',
                        name: 'DocumentNumber',
                        width:"8%"
                    },
                    {
                        data: 'CommType',
                        name: 'CommType',
                        width:"5%"
                    },
                    {
                        data: 'Origin',
                        name: 'Origin',
                        width:"8%"
                    },
                    {
                        data: 'GradeName',
                        name: 'GradeName',
                        width:"5%"
                    },
                    {
                        data: 'ProcessType',
                        name: 'ProcessType',
                        width:"5%"
                    },
                    {
                        data: 'CropYear',
                        name: 'CropYear',
                        width:"5%"
                    },
                    {
                        data: 'UomName',
                        name: 'UomName',
                        width:"5%"
                    },
                    {
                        data: 'NumOfBag',
                        name: 'NumOfBag',
                        render: $.fn.dataTable.render.number(',', '.',0, ''),
                        width:"5%"
                    },
                    {
                        data: 'BagWeight',
                        name: 'BagWeight',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'TotalKg',
                        name: 'TotalKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'NetKg',
                        name: 'NetKg',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'WeightByTon',
                        name: 'WeightByTon',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
                    },
                    {
                        data: 'Feresula',
                        name: 'Feresula',
                        render: $.fn.dataTable.render.number(',', '.', 2, ''),
                        width:"5%"
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
                        data: 'Memo',
                        name: 'Memo',
                        width:"10%"
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

                    var totaltonvar = api
                    .column(12)
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );


                    var totalferesulavar = api
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
                    
                    $('#totalbagRet').html(totalbagvar === 0 ? '' : numformat(totalbagvar));
                    $('#totalbagweightRet').html(totalbagweight === 0 ? '' : numformat(parseFloat(totalbagweight).toFixed(2)));
                    $('#totalgrosskgRet').html(totalgrosskg === 0 ? '' : numformat(parseFloat(totalgrosskg).toFixed(2)));
                    $('#totalkgRet').html(totalkgvar === 0 ? '' : numformat(parseFloat(totalkgvar).toFixed(2)));
                    $('#totaltonRet').html(totaltonvar === 0 ? '' : numformat(parseFloat(totaltonvar).toFixed(2)));
                    $('#totalferesulaRet').html(totalferesulavar === 0 ? '' : numformat(parseFloat(totalferesulavar).toFixed(2)));
                    $('#totalvarshortageRet').html(totalvarianceshr === 0 ? '' : numformat(parseFloat(totalvarianceshr).toFixed(2)));
                    $('#totalvarovrageRet').html(totalvarianceov === 0 ? '' : numformat(parseFloat(totalvarianceov).toFixed(2)));
                },
            });
        }

        //Start show receiving doc info
        //$(document).on('click', '.SettleWihold', function() {
        function SettleWihold(recordId){
            //var recordId = $(this).data('id');
            //var statusval = $(this).data('status');
            $("#statusid").val(recordId);
            $.get("/getWithNumber", function(data) {
                $('#witholdPercentisett').val(data.witholdPer);
                $('#infowitholdingTitlesett').html("Witholding (" + data.witholdPer + "%)");
                $('#witholdMinAmountisett').val(data.witholdAmnt);
            });
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    $('#infoDocType').text(data.holdHeader[i].Type);
                    $('#infoDocDocNo').text(data.holdHeader[i].DocumentNumber);
                    $('#infoDocCustomerCategory').text(data.holdHeader[i].CustomerCategory);
                    $('#infoDocCustomerName').text(data.holdHeader[i].CustomerName);
                    $('#infoDocPaymentType').text(data.holdHeader[i].PaymentType);
                    $('#infoVoucherStatus').text(data.holdHeader[i].VoucherStatusName);
                    $('#infoDocVoucherType').text(data.holdHeader[i].VoucherType);
                    $('#infoDocVoucherNumber').text(data.holdHeader[i].VoucherNumber);
                    $('#infoinvoicenumber').text(data.holdHeader[i].InvoiceNumber);
                    $('#infoDocMrcNumber').text(data.holdHeader[i].CustomerMRC);
                    $('#infoDocReceivingStore').text(data.holdHeader[i].StoreName);
                    $('#infoDocPurchaserName').text(data.holdHeader[i].PurchaserName);
                    $('#infoDocDate').text(data.holdHeader[i].TransactionDate);
                    $('#infoDocholdby').text(data.holdHeader[i].Username);
                    $('#infoCheckedBy').text(data.holdHeader[i].CheckedBy);
                    $('#infoCheckeddate').text(data.holdHeader[i].CheckedDate);
                    $('#infoConfirmedby').text(data.holdHeader[i].ConfirmedBy);
                    $('#infoConfirmeddate').text(data.holdHeader[i].ConfirmedDate);
                    $('#infochangetopending').text(data.holdHeader[i].ChangeToPendingBy);
                    $('#infochangetopendingdate').text(data.holdHeader[i].ChangeToPendingDate);
                    $('#infoStatus').text(data.holdHeader[i].Status);
                    $('#infosubtotalLbl').html(numformat(data.holdHeader[i].SubTotal));
                    $('#infotaxLbl').html(numformat(data.holdHeader[i].Tax));
                    $('#infograndtotalLbl').html(numformat(data.holdHeader[i].GrandTotal));
                    $('#infowitholdinglbl').html(numformat(data.holdHeader[i].WitholdAmount));
                    $('#infoNetPayLbl').html(numformat(data.holdHeader[i].NetPay));
                    $('#infotaxi').val(data.holdHeader[i].Tax);
                    $('#infograndtotali').val(data.holdHeader[i].GrandTotal);
                    $('#infowitholdingi').val(data.holdHeader[i].WitholdAmount);
                    $('#infoNetPayi').val(data.holdHeader[i].NetPay);
                    $('#infonumberofItemsLbl').text(data.count);
                    $('#infocreateddate').text(data.holdHeader[i].created_at);
                    $('#ReceiptNumber').val("");
                    $('#WitholdCustomerId').val(data.holdHeader[i].CustomerId);
                    $('#witholdTransactionDate').val(data.holdHeader[i].TransactionDate);
                    $('#infowitholdingTitle').html("Witholding(" + data.holdHeader[i].WitholdPercent +"%)");
                    $('#witholdSettleInfoTitle').html("Settle Withold for <b>" + data.holdHeader[i]
                        .CustomerName + "</b> on <b>" + data.holdHeader[i].TransactionDate + "</b> date"
                    );
                    var trdate = data.holdHeader[i].TransactionDate;
                    var cusId = data.holdHeader[i].CustomerId;
                    var settlementType = data.holdHeader[i].IsWitholdSettle;
                    var stotal = parseFloat($('#infosubtotali').val());
                    var withamnt = data.holdHeader[i].WitholdAmount;
                    var withprc = data.holdHeader[i].WitholdPercent;
                    var cc = $('#infoDocCustomerCategory').text();
                    var st = data.holdHeader[i].Status;
                    var status = data.holdHeader[i].Status;
                    if (parseFloat(withamnt) > 0 && parseFloat(withprc) > 0 && cc != "Foreigner-Supplier" &&
                        cc != "Person") {
                        $("#infowitholdingTr").show();
                        $("#infonetpayTr").show();
                    } else if (parseFloat(withamnt) == 0 || parseFloat(withprc) == 0 || cc ===
                        "Foreigner-Supplier" || cc === "Person") {
                        $("#infowitholdingTr").hide();
                        $("#infonetpayTr").hide();
                    }
                    var ln = data.pricingsett.length;
                    for (var i = 0; i <= ln; i++) {
                        var st = data.pricingsett[i].SubTotal;
                        var withamnt = parseFloat($('#witholdMinAmountisett').val());
                        if (parseFloat(st) >= withamnt) {

                            $('#witholdTables').DataTable({
                                destroy: true,
                                processing: true,
                                serverSide: true,
                                paging: false,
                                searching: false,
                                info: false,
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
                                    url: '/showwitholdDtsep/' + cusId + '/' + trdate,
                                    type: 'DELETE',
                                },
                                columns: [{
                                        data: 'id',
                                        name: 'id',
                                        'visible': false
                                    },
                                    {
                                        data: 'Type',
                                        name: 'Type',
                                        'visible': false
                                    },
                                    {
                                        data: 'DocumentNumber',
                                        name: 'DocumentNumber'
                                    },
                                    {
                                        data: 'VoucherNumber',
                                        name: 'VoucherNumber'
                                    },
                                    {
                                        data: 'SubTotal',
                                        name: 'SubTotal'
                                    },
                                ],
                            });
                            var totalval = 0;
                            var totalwithold = 0;
                            totalval = parseFloat(st) * parseFloat(withprc);
                            totalwithold = parseFloat(totalval) / 100;
                            $('#witholdSubtotalLblSett').html(numformat(st));
                            $('#witholdAmountLblSett').html(numformat(totalwithold.toString().match(
                                /^\d+(?:\.\d{0,2})?/)));
                            $('#witholdAmountLblTitleSett').html("Withold (" + withprc + "%)");
                            $('#witholdSettleModal').modal('show');
                            if (settlementType === "Settled") {
                                $('#settledLabelSett').hide();
                                $('#notsettledLabelSett').hide();
                            } else {
                                $('#settledLabelSett').hide();
                                $('#notsettledLabelSett').hide();
                            }
                        } else {
                            toastrMessage('error',"You cant settle on this transaction","Error");
                        }
                    }
                }
            });
        }
        //End show receiving doc info

        //Start open withold settlement
        $('.SettleWiholdBtn').click(function() {
            var recordId = $("#recordIds").val();
            var statusval = $("#statusIds").val();
            var selectedidsVal = $("#selectedids").val();
            if (selectedidsVal === "") {
                toastrMessage('error',"Please select receiving records","Error");
            } else {
                $("#selectedIdsWithold").val(selectedidsVal);
                $("#statusid").val(recordId);
                $.get("/getWithNumber", function(data) {
                    $('#witholdPercentisett').val(data.witholdPer);
                    $('#infowitholdingTitlesett').html("Witholding (" + data.witholdPer + "%)");
                    $('#witholdMinAmountisett').val(data.witholdAmnt);
                });
                $.get("/showRecDataRecSettle" + '/' + recordId + '/' + selectedidsVal, function(data) {
                    var dc = data;
                    var len = data.holdHeader.length;
                    for (var i = 0; i <= len; i++) {
                        $('#infoDocType').text(data.holdHeader[i].Type);
                        $('#infoDocDocNo').text(data.holdHeader[i].DocumentNumber);
                        $('#infoDocCustomerCategory').text(data.holdHeader[i].CustomerCategory);
                        $('#infoDocCustomerName').text(data.holdHeader[i].CustomerName);
                        $('#infoDocPaymentType').text(data.holdHeader[i].PaymentType);
                        $('#infoVoucherStatus').text(data.holdHeader[i].VoucherStatusName);
                        $('#infoDocVoucherType').text(data.holdHeader[i].VoucherType);
                        $('#infoDocVoucherNumber').text(data.holdHeader[i].VoucherNumber);
                        $('#infoinvoicenumber').text(data.holdHeader[i].InvoiceNumber);
                        $('#infoDocMrcNumber').text(data.holdHeader[i].CustomerMRC);
                        $('#infoDocReceivingStore').text(data.holdHeader[i].StoreName);
                        $('#infoDocPurchaserName').text(data.holdHeader[i].PurchaserName);
                        $('#infoDocDate').text(data.holdHeader[i].TransactionDate);
                        $('#infoDocholdby').text(data.holdHeader[i].Username);
                        $('#infoCheckedBy').text(data.holdHeader[i].CheckedBy);
                        $('#infoCheckeddate').text(data.holdHeader[i].CheckedDate);
                        $('#infoConfirmedby').text(data.holdHeader[i].ConfirmedBy);
                        $('#infoConfirmeddate').text(data.holdHeader[i].ConfirmedDate);
                        $('#infochangetopending').text(data.holdHeader[i].ChangeToPendingBy);
                        $('#infochangetopendingdate').text(data.holdHeader[i].ChangeToPendingDate);
                        $('#infoStatus').text(data.holdHeader[i].Status);
                        $('#infosubtotalLbl').html(numformat(data.holdHeader[i].SubTotal));
                        $('#infotaxLbl').html(numformat(data.holdHeader[i].Tax));
                        $('#infograndtotalLbl').html(numformat(data.holdHeader[i].GrandTotal));
                        $('#infowitholdinglbl').html(numformat(data.holdHeader[i].WitholdAmount));
                        $('#infoNetPayLbl').html(numformat(data.holdHeader[i].NetPay));
                        $('#infotaxi').val(data.holdHeader[i].Tax);
                        $('#infograndtotali').val(data.holdHeader[i].GrandTotal);
                        $('#infowitholdingi').val(data.holdHeader[i].WitholdAmount);
                        $('#infoNetPayi').val(data.holdHeader[i].NetPay);
                        $('#infonumberofItemsLbl').text(data.count);
                        $('#infocreateddate').text(data.holdHeader[i].created_at);
                        $('#ReceiptNumber').val("");
                        $('#recSettIds').val(data.holdHeader[i].id);
                        $('#WitholdCustomerId').val(data.holdHeader[i].CustomerId);
                        $('#witholdTransactionDate').val(data.holdHeader[i].TransactionDate);
                        $('#infowitholdingTitle').html("Witholding(" + data.holdHeader[i].WitholdPercent +"%)");
                        $('#witholdSettleInfoTitle').html("Settle Withold for <b>" + data.holdHeader[i]
                            .CustomerName + "</b> on <b>" + data.holdHeader[i].TransactionDate +
                            "</b> date");
                        var trdate = data.holdHeader[i].TransactionDate;
                        var cusId = data.holdHeader[i].CustomerId;
                        var settlementType = data.holdHeader[i].IsWitholdSettle;
                        var stotal = parseFloat($('#infosubtotali').val());
                        var withamnt = data.holdHeader[i].WitholdAmount;
                        var withprc = data.holdHeader[i].WitholdPercent;
                        var cc = $('#infoDocCustomerCategory').text();
                        var st = data.holdHeader[i].Status;
                        var status = data.holdHeader[i].Status;
                        if (parseFloat(withamnt) > 0 && parseFloat(withprc) > 0 && cc !=
                            "Foreigner-Supplier" && cc != "Person") {
                            $("#infowitholdingTr").show();
                            $("#infonetpayTr").show();
                        } else if (parseFloat(withamnt) == 0 || parseFloat(withprc) == 0 || cc ===
                            "Foreigner-Supplier" || cc === "Person") {
                            $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide();
                        }
                        var ln = data.pricingsett.length;
                        for (var i = 0; i <= ln; i++) {
                            var st = data.allVal[i].SubTotal;
                            var all = data.allVal[i].SubTotal;
                            var diff = data.diffVal[i].SubTotal;

                            var withamnt = parseFloat($('#witholdMinAmountisett').val());
                            if (parseFloat(all) >= withamnt && (parseFloat(diff) >= withamnt || parseFloat(
                                    diff) == 0)) {
                                $('#witholdTables').DataTable({
                                    destroy: true,
                                    processing: true,
                                    serverSide: true,
                                    paging: false,
                                    searching: false,
                                    info: false,
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
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                                'content')
                                        },
                                        url: '/showwitholdDtSelected/' + cusId + '/' + trdate +
                                            '/' + selectedidsVal,
                                        type: 'DELETE',
                                    },
                                    columns: [{
                                            data: 'id',
                                            name: 'id',
                                            'visible': false
                                        },
                                        {
                                            data: 'Type',
                                            name: 'Type',
                                            'visible': false
                                        },
                                        {
                                            data: 'DocumentNumber',
                                            name: 'DocumentNumber'
                                        },
                                        {
                                            data: 'VoucherNumber',
                                            name: 'VoucherNumber'
                                        },
                                        {
                                            data: 'SubTotal',
                                            name: 'SubTotal'
                                        },
                                    ],
                                });
                                var totalval = 0;
                                var totalwithold = 0;
                                totalval = parseFloat(st) * parseFloat(withprc);
                                totalwithold = parseFloat(totalval) / 100;
                                $('#witholdSubtotalLblSett').html(numformat(st));
                                $('#witholdAmountLblSett').html(numformat(totalwithold.toString().match(
                                    /^\d+(?:\.\d{0,2})?/)));
                                $('#witholdAmountLblTitleSett').html("Withold (" + withprc + "%)");
                                $('#witholdSettleModal').modal('show');
                                //$('#docInfoModal').modal('hide');
                                if (settlementType === "Settled") {
                                    $('#settledLabelSett').hide();
                                    $('#notsettledLabelSett').hide();
                                } else {
                                    $('#settledLabelSett').hide();
                                    $('#notsettledLabelSett').hide();
                                }
                            } else {
                                toastrMessage('error',"You cant settle on this transaction","Error");
                            }
                        }
                    }
                });
            }
            $('#ReceiptNumber').val("");
        });
        //End open withold settlement

        //Start open withold settlement
        $('.UnSettleWiholdBtn').click(function() {
            var recordId = $("#recordIds").val();
            var statusval = $("#statusIds").val();
            var selectedidsVal = $("#selectedids").val();
            if (selectedidsVal === "") {
                toastrMessage('error',"Please select receiving records","Error");
            } else {
                $('#removeReceiptBtn').text('Remove');
                $('#removeReceiptBtn').prop("disabled", false);
                $("#unsettledid").val(selectedidsVal);
                $("#statusid").val(recordId);
                $.get("/getWithNumber", function(data) {
                    $('#witholdPercentisett').val(data.witholdPer);
                    $('#infowitholdingTitlesett').html("Witholding (" + data.witholdPer + "%)");
                    $('#witholdMinAmountisett').val(data.witholdAmnt);
                });
                $.get("/showRecDataRecUnSettle" + '/' + recordId + '/' + selectedidsVal, function(data) {
                    var dc = data;
                    var len = data.holdHeader.length;
                    for (var i = 0; i <= len; i++) {
                        $('#infoDocType').text(data.holdHeader[i].Type);
                        $('#infoDocDocNo').text(data.holdHeader[i].DocumentNumber);
                        $('#infoDocCustomerCategory').text(data.holdHeader[i].CustomerCategory);
                        $('#infoDocCustomerName').text(data.holdHeader[i].CustomerName);
                        $('#infoDocPaymentType').text(data.holdHeader[i].PaymentType);
                        $('#infoVoucherStatus').text(data.holdHeader[i].VoucherStatusName);
                        $('#infoDocVoucherType').text(data.holdHeader[i].VoucherType);
                        $('#infoDocVoucherNumber').text(data.holdHeader[i].VoucherNumber);
                        $('#infoinvoicenumber').text(data.holdHeader[i].InvoiceNumber);
                        $('#infoDocMrcNumber').text(data.holdHeader[i].CustomerMRC);
                        $('#infoDocReceivingStore').text(data.holdHeader[i].StoreName);
                        $('#infoDocPurchaserName').text(data.holdHeader[i].PurchaserName);
                        $('#infoDocDate').text(data.holdHeader[i].TransactionDate);
                        $('#infoDocholdby').text(data.holdHeader[i].Username);
                        $('#infoCheckedBy').text(data.holdHeader[i].CheckedBy);
                        $('#infoCheckeddate').text(data.holdHeader[i].CheckedDate);
                        $('#infoConfirmedby').text(data.holdHeader[i].ConfirmedBy);
                        $('#infoConfirmeddate').text(data.holdHeader[i].ConfirmedDate);
                        $('#infochangetopending').text(data.holdHeader[i].ChangeToPendingBy);
                        $('#infochangetopendingdate').text(data.holdHeader[i].ChangeToPendingDate);
                        $('#infoStatus').text(data.holdHeader[i].Status);
                        $('#infosubtotalLbl').html(numformat(data.holdHeader[i].SubTotal));
                        $('#infotaxLbl').html(numformat(data.holdHeader[i].Tax));
                        $('#infograndtotalLbl').html(numformat(data.holdHeader[i].GrandTotal));
                        $('#infowitholdinglbl').html(numformat(data.holdHeader[i].WitholdAmount));
                        $('#infoNetPayLbl').html(numformat(data.holdHeader[i].NetPay));
                        $('#infotaxi').val(data.holdHeader[i].Tax);
                        $('#infograndtotali').val(data.holdHeader[i].GrandTotal);
                        $('#infowitholdingi').val(data.holdHeader[i].WitholdAmount);
                        $('#infoNetPayi').val(data.holdHeader[i].NetPay);
                        $('#infonumberofItemsLbl').text(data.count);
                        $('#infocreateddate').text(data.holdHeader[i].created_at);
                        $('#ReceiptNumber').val("");
                        $('#singleUnSettledId').val(data.holdHeader[i].id);
                        $('#UnWitholdCustomerId').val(data.holdHeader[i].CustomerId);
                        $('#UnwitholdTransactionDate').val(data.holdHeader[i].TransactionDate);
                        $('#infowitholdingTitle').html("Witholding(" + data.holdHeader[i].WitholdPercent +"%)");
                        $('#witholdSettleInfoTitle').html("Settle Withold for <b>" + data.holdHeader[i]
                            .CustomerName + "</b> on <b>" + data.holdHeader[i].TransactionDate +
                            "</b> date");
                        var trdate = data.holdHeader[i].TransactionDate;
                        var cusId = data.holdHeader[i].CustomerId;
                        var settlementType = data.holdHeader[i].IsWitholdSettle;
                        var stotal = parseFloat($('#infosubtotali').val());
                        var withamnt = data.holdHeader[i].WitholdAmount;
                        var withprc = data.holdHeader[i].WitholdPercent;
                        var cc = $('#infoDocCustomerCategory').text();
                        var st = data.holdHeader[i].Status;
                        var status = data.holdHeader[i].Status;
                        if (parseFloat(withamnt) > 0 && parseFloat(withprc) > 0 && cc !=
                            "Foreigner-Supplier" && cc != "Person") {
                            $("#infowitholdingTr").show();
                            $("#infonetpayTr").show();
                        } else if (parseFloat(withamnt) == 0 || parseFloat(withprc) == 0 || cc ===
                            "Foreigner-Supplier" || cc === "Person") {
                            $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide();
                        }
                        var ln = data.pricingsett.length;
                        for (var i = 0; i <= ln; i++) {
                            var st = data.allVal[i].SubTotal;
                            var all = data.allVal[i].SubTotal;
                            var diff = data.diffVal[i].SubTotal;
                            var diffRec = data.diffValReceipt[i].SubTotal;

                            var withamnt = parseFloat($('#witholdMinAmountisett').val());
                            if (parseFloat(all) >= withamnt && (parseFloat(diff) >= withamnt || parseFloat(
                                    diff) == 0) && (parseFloat(diffRec) >= withamnt || parseFloat(
                                    diffRec) == 0)) {
                                var totalval = 0;
                                var totalwithold = 0;
                                totalval = parseFloat(st) * parseFloat(withprc);
                                totalwithold = parseFloat(totalval) / 100;
                                $('#witholdSubtotalLblSett').html(numformat(st));
                                $('#witholdAmountLblSett').html(numformat(totalwithold.toString().match(
                                    /^\d+(?:\.\d{0,2})?/)));
                                $('#witholdAmountLblTitleSett').html("Withold (" + withprc + "%)");
                                $('#showUnsettledModal').modal('show');
                                //$('#docInfoModal').modal('hide');
                                if (settlementType === "Settled") {
                                    $('#settledLabelSett').hide();
                                    $('#notsettledLabelSett').hide();
                                } else {
                                    $('#settledLabelSett').hide();
                                    $('#notsettledLabelSett').hide();
                                }
                            } else {
                                toastrMessage('error',"You cant remove this withold receipt","Error");
                            }
                        }
                    }
                });
            }
        });
        //End open withold settlement

        var ids = [];
        var DT1 = $('#witholdingTables').DataTable();
        $("#example-select-all").on("click", function(e) {
            if ($(this).is(":checked")) {
                var recId = $("#recordIds").val();
                $.get("/showRecDataRec" + '/' + recId, function(data) {
                    var dc = data;
                    var len = data.holdHeader.length;
                    for (var i = 0; i <= len; i++) {
                        var trdate = data.holdHeader[i].TransactionDate;
                        var cusId = data.holdHeader[i].CustomerId;
                        var ln = data.getids.length;
                        for (var i = 0; i <= ln; i++) {
                            var recordId = data.getids[i].id;
                            ids = [];
                            ids.push(recordId);
                            $('#selectedids').val(ids);
                        }
                    }
                });
                $(".settleSeparateCbx").prop("checked", true);
            } else {
                $(".settleSeparateCbx").prop("checked", false);
                ids = [];
                $('#selectedids').val("");
            }
        });

        $(document).on('change', '.settleSeparateCbx', function() {
            var recordId = $(this).data('id');
            var ischecked = $(this).is(":checked");
            if (ischecked) {
                ids.push(recordId);
            } else {
                12
            }
            $('#selectedids').val(ids);
        });
        
        //Start Separate Settlement 
        //$(document).on('click', '.settleSeparate', function() {
        function settleSeparate(recordId){
            //var recordId = $(this).data('id');
            $('#separatesettid').val(recordId);
            $.get("/getWithNumber", function(data) {
                $('#witholdPercentisett').val(data.witholdPer);
                $('#witholdMinAmountisett').val(data.witholdAmnt);
            });
            $.get("/showRecDataRecSep" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var doc = data.holdHeader[i].DocumentNumber;
                    var cus = data.holdHeader[i].CustomerName;
                    var trd = data.holdHeader[i].TransactionDate;
                    $('#witholdSettlementHeader').html("Settle Withold for <b>" + cus + "</b> on <b>" +
                        trd + "</b> and <b>" + doc + "</b>");
                    var ln = data.pricing.length;
                    for (var i = 0; i <= ln; i++) {
                        var wa = $('#witholdMinAmountisett').val();
                        var wp = $('#witholdPercentisett').val();
                        var st = data.pricing[i].SubTotal;
                        var stsingle = data.pricingsingle[i].SubTotal;
                        if ((parseFloat(st) >= parseFloat(wa)) && (parseFloat(stsingle) >= parseFloat(
                                wa))) {
                            var totalval = 0;
                            var totalwithold = 0;
                            totalval = parseFloat(st) * parseFloat(wp);
                            totalwithold = parseFloat(totalval) / 100;
                            $('#witholdsettleLbl').html("Withold Amount : <b>" + numformat(totalwithold.toString().match(/^\d+(?:\.\d{0,2})?/)) + "</b>");
                            $('#separateSettleModal').modal('show');
                        } else if ((parseFloat(st) < parseFloat(wa)) || (parseFloat(stsingle) < parseFloat(wa))) {
                            toastrMessage('error',"You cant settle on this transaction","Error");
                        }
                    }
                }
            });
        }
        //End Separate Settlement

        //Start change to checked
        $('#checkedbtn').click(function(){
            var recordId = $('#checkedid').val();
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var stold = data.holdHeader[i].StatusOld;
                    if (st === "Confirmed") {
                        toastrMessage('error',"Receiving already confirmed","Error");
                        $("#receivingcheckmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Void") {
                        toastrMessage('error',"Receiving already voided","Error");
                        $("#receivingcheckmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Verified") {
                        toastrMessage('error',"Receiving already checked","Error");
                        $("#receivingcheckmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Pending") {
                        var registerForm = $("#checkreceivingform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/checkStatus',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#checkedbtn').text('Verifying...');
                                $('#checkedbtn').prop("disabled", true);
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
                                        $('#checkedbtn').text('Verify Receiving');
                                        $('#checkedbtn').prop( "disabled", false );
                                        toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+"  Items"+loopedVal,"Error");
                                        $("#receivingcheckmodal").modal('hide');
                                    }    
                                }
                                if (data.success) {
                                    $('#checkedbtn').text('Verify Receiving');
                                    toastrMessage('success',"Successful","Success");
                                    $("#receivingcheckmodal").modal('hide');
                                    $("#docInfoModal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    }
                }
            });
        });
        //End change to checked

        //Start change to pending
        $('#pendingbtn').click(function(){  
            var recordId = $('#pendingid').val();
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var stold = data.holdHeader[i].StatusOld;
                    if (st === "Confirmed") {
                        toastrMessage('error',"Receiving already confirmed","Error");
                        $("#receivingpendingmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Void") {
                        toastrMessage('error',"Receiving already voided","Error");
                        $("#receivingpendingmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Pending") {
                        toastrMessage('error',"Receiving already pending status","Error");
                        $("#receivingpendingmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Draft") {
                        var registerForm = $("#pendingreceivingform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/pendingStatus',
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
                                $('#pendingbtn').text('Changing...');
                                $('#pendingbtn').prop("disabled", true);
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
                                if (data.success) {
                                    $('#pendingbtn').text('Change to Pending');
                                    toastrMessage('success',"Successful","Success");
                                    $("#receivingpendingmodal").modal('hide');
                                    $("#docInfoModal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    }
                }
            });
        });
        //End change to pending

        //hide receiving btn starts
        $('#hiderecbtn').click(function(){ 
            $('#hiderecbtn').prop("disabled", true);
            var recordId = $('#hiderecid').val();
            var registerForm = $("#hidereceivingform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/hideReceiving',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#hiderecbtn').text('Hiding...');
                    $('#hiderecbtn').prop("disabled", true);
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
                    if (data.success) {
                        $('#hiderecbtn').text('Hide Receiving');
                        toastrMessage('success',"Successful","Success");
                        $("#hidereceivingmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //Hide receiving btn ends

        //show receiving btn starts
        $('#showrecbtn').click(function(){
            $('#showrecbtn').prop("disabled", true);
            var recordId = $('#showrecid').val();
            var registerForm = $("#showreceivingform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/showReceiving',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#showrecbtn').text('Showing...');
                    $('#showrecbtn').prop("disabled", true);
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
                    if (data.success) {
                        $('#showrecbtn').text('Show Receiving');
                        toastrMessage('success',"Successful","Success");
                        $("#showreceivingmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        //show receiving btn ends

        //Start change to confirm
        $('#confirmbtn').click(function(){ 
            $('#confirmbtn').prop("disabled", true);
            var recordId = $('#confirmid').val();
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var stold = data.holdHeader[i].StatusOld;
                    if (st === "Confirmed") {
                        toastrMessage('error',"Receiving already confirmed","Error");
                        $("#receivingconfirmedmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Void") {
                        toastrMessage('error',"Receiving already voided","Error");
                        $("#receivingconfirmedmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    } else if (st === "Verified") {
                        $('#confirmbtn').prop("disabled", true);
                        var registerForm = $("#confirmedreceivingform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/confirmStatus',
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
                                $('#confirmbtn').text('Confirming...');
                                $('#confirmbtn').prop("disabled", true);
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
                                        $('#confirmbtn').text('Change to Confirm');
                                        $('#confirmbtn').prop( "disabled", false );
                                        toastrMessage('error',"Please insert serial number, batch number or expire date for "+count+"  Items"+loopedVal,"Error");
                                        $("#receivingconfirmedmodal").modal('hide');
                                    }    
                                }
                                if (data.success) {
                                    $('#confirmbtn').text('Change to Confirm');
                                    toastrMessage('success',"Successful","Success");
                                    $("#receivingconfirmedmodal").modal('hide');
                                    $("#docInfoModal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    }
                }
            });
        });
        //End change to confirm

        //Start Void Modal With Value 
        function voidlnbtn(recordId){
            //var recordId = $(this).data('id');
            $('.Reason').val("");
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var fiscalyearcurr=data.fyear;
                var fyearstrs=data.fyearstr;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var fyearrec = data.holdHeader[i].fiscalyear;
                    if (st === "Void") {
                        toastrMessage('error',"Receiving already voided","Error");
                        $("#voidreasonmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                    // else if(parseFloat(fyearrec)!=parseFloat(fyearstrs)){
                    //     toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                    //     $("#voidreasonmodal").modal('hide');
                    //     var oTable = $('#laravel-datatable-crud').dataTable();
                    //     oTable.fnDraw(false);
                    // }
                    else{
                        $("#voidid").val(recordId);
                        $('#vstatus').val(st);
                        $('#voidbtn').prop("disabled", false);
                        $('#voidbtn').text("Void");
                        $("#voidreasonmodal").modal('show');
                    }
                }
            });
        }

        // $('#voidreasonmodal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var id = button.data('id');
        //     var statusval = button.data('status');
        //     var modal = $(this);
        //     modal.find('.modal-body #voidid').val(id);
        //     modal.find('.modal-body #vstatus').val(statusval);
        //     $('#voidbtn').prop("disabled", false);
        // });
        //End Void Modal With Value 

        //Start void
        $('#voidbtn').click(function(){    
            var recordId = $('#voidid').val();
            var fiscalyearcurr="";
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                fiscalyearcurr=data.fyear;
                var fyearstrs=data.fyearstr;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var fyearrec = data.holdHeader[i].fiscalyear;
                    if (st === "Void") {
                        toastrMessage('error',"Receiving already voided","Error");
                        $("#voidreasonmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#voidreasonform")[0].reset();
                    }
                    // else if(parseFloat(fyearrec)!=parseFloat(fyearstrs)){
                    //     toastrMessage('error',"You cant void a closed fiscal year transaction","Error");
                    //     $("#voidreasonmodal").modal('hide');
                    //     var oTable = $('#laravel-datatable-crud').dataTable();
                    //     oTable.fnDraw(false);
                    //     $("#voidreasonform")[0].reset();
                    // }
                    else if (st === "Confirmed" || st === "Received") {
                        var registerForm = $("#voidreasonform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/voidReceiving',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#voidbtn').text('Voiding...');
                                $('#voidbtn').prop("disabled", true);
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
                                if (data.valerror) {
                                    var singleVal = '';
                                    var singleValTemp = '';
                                    var loopedVal = '';
                                    var len = data['valerror'].length;
                                    for (var i = 0; i <= len; i++) {
                                        var count = data.countedval;
                                        var inc = i + 1;
                                        singleVal = (data['countItems'][i].Name);
                                        loopedVal = loopedVal + "</br>" + inc + " ) " + singleVal+"</br>";
                                        $('#voidbtn').text('Void');
                                        $('#voidbtn').prop("disabled", false);
                                        toastrMessage('error',"You cant void <b>" + count +"</b> item(s) because item(s) have transaction" + loopedVal,"Error");
                                        $("#voidreasonmodal").modal('hide');
                                        var oTable = $('#laravel-datatable-crud').dataTable();
                                        oTable.fnDraw(false);
                                        $("#voidreasonform")[0].reset();
                                    }
                                }
                                if (data.errors) {
                                    if (data.errors.Reason) {
                                        $('#void-error').html(data.errors.Reason[0]);
                                    }
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop("disabled", false);
                                    toastrMessage('error',"Check your inputs","Error");
                                }
                                if (data.success) {
                                    $('#voidbtn').text('Void');
                                    toastrMessage('success',"Receiving voided","Success");
                                    $("#voidreasonmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#voidreasonform")[0].reset();
                                }
                            },
                        });
                    } else {
                        var registerForm = $("#voidreasonform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/voidRec',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#voidbtn').text('Voiding...');
                                $('#voidbtn').prop("disabled", true);
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
                                if (data.errors) {
                                    if (data.errors.Reason) {
                                        $('#void-error').html(data.errors.Reason[0]);
                                    }
                                    $('#voidbtn').text('Void');
                                    $('#voidbtn').prop("disabled", false);
                                    toastrMessage('error',"Check your inputs","Error");
                                }
                                if (data.success) {
                                    $('#voidbtn').text('Void');
                                    toastrMessage('success',"Receiving voided","Success");
                                    $("#voidreasonmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#voidreasonform")[0].reset();
                                }
                            },
                        });
                    }
                }
            });
        });
        //End void

        //Start undo void Modal With Value 
        // $('#undovoidmodal').on('show.bs.modal', function(event) {
        //     var button = $(event.relatedTarget);
        //     var id = button.data('id');
        //     var status = button.data('status');
        //     var ostatus = button.data('ostatus');
        //     var modal = $(this);
        //     modal.find('.modal-body #undovoidid').val(id);
        //     modal.find('.modal-body #ustatus').val(status);
        //     modal.find('.modal-body #oldstatus').val(ostatus);
        //     $('#undovoidbtn').prop("disabled", false);
        // });
        //End undo void Modal With Value 

        //Start Void Modal With Value 
        function undovoidlnbtn(recordId){
            //var recordId = $(this).data('id');
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var fiscalyearcurr=data.fyear;
                var fyearstrs=data.fyearstr;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var fyearrec = data.holdHeader[i].fiscalyear;
                    if (st != "Void") {
                        toastrMessage('error',"Receiving should be void","Error");
                        $("#undovoidmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                    // else if(parseFloat(fyearrec)!=parseFloat(fyearstrs)){
                    //     toastrMessage('error',"You cant undo void a closed fiscal year transaction","Error");
                    //     $("#undovoidmodal").modal('hide');
                    //     var oTable = $('#laravel-datatable-crud').dataTable();
                    //     oTable.fnDraw(false);
                    // }
                    else{
                        $('#undovoidid').val(recordId);
                        $('#ustatus').val(st);
                        $('#undovoidbtn').prop("disabled", false);
                        $('#undovoidbtn').text("Undo Void");
                        $("#undovoidmodal").modal('show');
                    }
                }
            });
        }

        //Start undo void
        $('#undovoidbtn').click(function(){
            $('#undovoidbtn').prop("disabled", true);
            var statusVal = $("#ustatus").val();
            var oldstatusVal = $("#oldstatus").val();
            var recordId = $('#undovoidid').val();
            $.get("/showRecDataRec" + '/' + recordId, function(data) {
                var dc = data;
                var len = data.holdHeader.length;
                for (var i = 0; i <= len; i++) {
                    var st = data.holdHeader[i].Status;
                    var stold = data.holdHeader[i].StatusOld;
                    if (st === "Void" && stold === "Confirmed") {
                        var registerForm = $("#undovoidform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/undoVoid',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#undovoidbtn').text('Changing...');
                                $('#undovoidbtn').prop("disabled", true);
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
                                if(data.undoerror)
                                {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('error',"This doc/fs number is taken by another transaction","Error");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#undovoidform")[0].reset();
                                }
                                else if(data.pocnterror)
                                {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('error',"You cannot undo the void because the PO was created with another receiving.","Error");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#undovoidform")[0].reset();
                                }
                                else if (data.success) {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('success',"Successful","Success");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#undovoidform")[0].reset();
                                }
                            },
                        });
                    } else if (st == "Void" && stold != "Confirmed") {
                        var registerForm = $("#undovoidform");
                        var formData = registerForm.serialize();
                        $.ajax({
                            url: '/undoVd',
                            type: 'POST',
                            data: formData,
                            beforeSend: function() {
                                $('#undovoidbtn').text('Changing...');
                                $('#undovoidbtn').prop("disabled", true);
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
                                if(data.undoerror)
                                {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('error',"This doc/fs number is taken by another transaction","Error");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#undovoidform")[0].reset();
                                }
                                else if(data.pocnterror)
                                {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('error',"You cannot undo the void because the PO was created with another receiving.","Error");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                    $("#undovoidform")[0].reset();
                                }
                                else if (data.success) 
                                {
                                    $('#undovoidbtn').text('Undo Void');
                                    toastrMessage('success',"Successful","Success");
                                    $("#undovoidmodal").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable();
                                    oTable.fnDraw(false);
                                }
                            },
                        });
                    } else if (st != "Void") {
                        toastrMessage('error',"Receiving should be void","Error");
                        $("#undovoidmodal").modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#undovoidform")[0].reset();
                    }
                }
            });
        });
        //End undo void

        //hide receiving btn starts
        $('#removeReceiptBtn').click(function(){    
            $('#removeReceiptBtn').prop("disabled", true);
            var recordId = $('#unsettledid').val();
            var registerForm = $("#showunsettledform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/unsettleWithold',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#removeReceiptBtn').text('Removing...');
                    $('#removeReceiptBtn').prop("disabled", true);
                },
                success: function(data) {
                    if (data.success) {
                        $('#removeReceiptBtn').text('Remove');
                        $('#removeReceiptBtn').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        $("#showUnsettledModal").modal('hide');
                        var oTable = $('#witholdingTables').dataTable();
                        oTable.fnDraw(false);
                        ids = [];
                        $('#selectedids').val(ids);
                        var len = data.recData.length;
                        for (var i = 0; i <= len; i++) {
                            var settleType = data.recData[i].IsWitholdSettle;
                            $('#infoWitholdReceiptLbl').html(data.recData[i].WitholdReceipt);
                            $('#infoWitholdSettleBy').html(data.recData[i].WitholdSettledBy);
                            $('#infoWitholdSettleDate').html(data.recData[i].WitholdSettleDate);
                            if (settleType === "Settled") {
                                $('#settledLabelPr').show();
                                $('#notsettledLabelPr').hide();
                            } else if (settleType === "Not-Settled") {
                                $('#settledLabelPr').hide();
                                $('#notsettledLabelPr').show();
                            }
                            var total = data.TotalCount;
                            var settled = data.Settled;
                            var notsettled = data.NotSettled;

                            if (parseFloat(total) == parseFloat(settled) && parseFloat(notsettled) == 0) {
                                $('#settledLabel').show();
                                $('#notsettledLabel').hide();
                            } else if (parseFloat(total) == parseFloat(notsettled) && parseFloat(
                                    settled) == 0) {
                                $('#settledLabel').hide();
                                $('#notsettledLabel').show();
                                $('#notsettledLabel').text('Not-Settled');
                            } else if (parseFloat(settled) >= 1 && parseFloat(notsettled) >= 1) {
                                $('#settledLabel').hide();
                                $('#notsettledLabel').show();
                                $('#notsettledLabel').text('Partially-Settled');
                            }
                        }
                    }
                },
            });
        });
        //Hide receiving btn ends

        //Start Print Attachment
        $('body').on('click', '.printRecAttachment', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        //Start Print Attachment
        $('body').on('click', '.printCommRecAttachment', function() {
            var id = $(this).data('id');
            var link = $(this).data('link');
            window.open(link, 'GRV', 'width=1200,height=800,scrollbars=yes');
        });
        //End Print Attachment

        function getheaderId() {
            var hid = $('#tid').val();
            $('#itid').val(hid);
            var sid = $('#store').val();
            $('#stId').val(sid);
            $('#savenewreceiving').hide();
            $('#savenewhold').show();
        }

        function getCheckInfoConf() {
            var stid = $('#statusid').val();
            $('#checkedid').val(stid);
            $('#receivingcheckmodal').modal('show');
            $('#checkedbtn').prop("disabled", false);
        }

        function getPendingInfoConf() {
            var stid = $('#statusid').val();
            $('#pendingid').val(stid);
            $('#receivingpendingmodal').modal('show');
            $('#pendingbtn').prop("disabled", false);
        }

        function getConfirmInfoConf() {
            var stid = $('#statusid').val();
            $('#confirmid').val(stid);
            $('#receivingconfirmedmodal').modal('show');
            $('#confirmbtn').prop("disabled", false);
        }

        function getReceivingHeader() {
            var hid = $('#receivingId').val();
            $('#receivingidinput').val(hid);
            $('#receIds').val(hid);
            var sid = $('#store').val();
            $('#receivingstoreid').val(sid);
            $('#savenewreceiving').show();
            $('#savenewhold').hide();
            $('#savenewreceiving').text("Add");
        }

        function backToDraftFn() {
            var stid = $('#recordIds').val();
            $('#commentid').val(stid);
            $('#Comment').val("");
            $('#comment-error').html("");
            $('#backtodraftmodal').modal('show');
            $('#backtodraftbtn').text("Back to Draft");
            $('#backtodraftbtn').prop("disabled", false);
        }

        function commentValFn() {
            $('#comment-error').html("");
        }

        function backToPendingFn(){
            var stid = $('#recordIds').val();
            $('#backtopendingid').val(stid);
            $('#BackToPendingComment').val("");
            $('#backtopending-error').html("");
            $('#backtopendingmodal').modal('show');
            $('#backtopendingbtn').text("Back to Pending");
            $('#backtopendingbtn').prop("disabled", false);
        }

        function backToPenValFn() {
            $('#backtopending-error').html("");
        }

        $("#backtodraftbtn").click(function() {
            var registerForm = $("#backtodraftform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/recBackToDraft',
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

                    $('#backtodraftbtn').text('Changing...');
                    $('#backtodraftbtn').prop("disabled", true);
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
                        if (data.errors.Comment) {
                            $('#comment-error').html(data.errors.Comment[0]);
                        }
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        $('#backtodraftmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtodraftbtn').text('Back to Draft');
                        $('#backtodraftbtn').prop("disabled",false);
                        $('#backtodraftmodal').modal('hide');
                        toastrMessage('error',"Production order status should be on Pending","Error");
                    }
                    else if(data.success){
                        $('#backtodraftmodal').modal('hide');
                        $('#docInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        $("#backtopendingbtn").click(function() {
            var registerForm = $("#backtopendingform");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/recBackToPending',
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

                    $('#backtopendingbtn').text('Changing...');
                    $('#backtopendingbtn').prop("disabled", true);
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
                        if (data.errors.BackToPendingComment) {
                            $('#backtopending-error').html(data.errors.BackToPendingComment[0]);
                        }
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        toastrMessage('error',"Check your input","Error");
                    }
                    else if (data.dberrors) {
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        $('#backtopendingmodal').modal('hide');
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.statuserror){
                        $('#backtopendingbtn').text('Back to Pending');
                        $('#backtopendingbtn').prop("disabled",false);
                        $('#backtopendingmodal').modal('hide');
                        toastrMessage('error',"Production order status should be on Ready","Error");
                    }
                    else if(data.success){
                        $('#backtopendingmodal').modal('hide');
                        $('#docInfoModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                    }
                }
            });
        });

        function supplierVal() {
            $('#supplier-error').html("");
            CalculateGrandTotal();
        }

        function typeFn() {
            var rectype=$('#ReceivingType').val();
            $('#ponumdiv').hide();
           
            $('#commTotalTable').hide();
            $('.customerdiv').hide();
            $('#CommoditySource').empty();
            $('#ProductType').empty();
            $('#CompanyType').empty();
            $('#supplier').empty();
            $('#dynamicTable > tbody').empty();
            $('#commDynamicTable > tbody').empty();
            $('#adds').hide();
            $('#commadds').hide();

            $('#goodsdiv').hide();
            $('#commoditydiv').hide();
            var polist="";
            var commsrc=$("#commoditysourcedefault > option").clone();
            var prdtype=$("#producttypedefault > option").clone();
            var comptype='<option value="1">Owner</option><option value="2">Customer</option>';
            var comptypeowner='<option selected value="1">Owner</option>';
            var suppdefault = $("#supplierdefault > option").clone();
            var defaultoption = '<option selected value=""></option>';
            $('#PONumber').val(null).select2
            ({
                placeholder: "Select Reference number here",
                dropdownCssClass : 'cusmidprp',
            });

            if(parseInt(rectype) == 1){
                $('#commoditydiv').show();
                $('#ponumdiv').hide();
                
                $('#CommoditySource').append(commsrc).select2({
                    placeholder:"Select Commodity source here",
                });

                $('#ProductType').append(prdtype).select2({
                    placeholder:"Select Product type here",
                    minimumResultsForSearch: -1
                });

                $('#supplier').append(suppdefault);
                $('#supplier').append(defaultoption);
                $('#supplier').val(null).select2
                ({
                    placeholder: "Select Supplier here",
                    dropdownCssClass : 'commprp',
                });

                $('#CompanyType').append(comptype);
                $('#CompanyType').append(defaultoption);
                $('#CompanyType').val(null).select2
                ({
                    placeholder: "Select Company type here",
                    minimumResultsForSearch: -1
                });
            }

            else if(parseInt(rectype) == 2){
                getPoList();
                $('#ponumdiv').show();
                $('#goodsdiv').hide();
                
                $('#CommoditySource').val(null).select2({
                    placeholder:"Select Commodity source here",
                });
                $('#ProductType').val(null).select2({
                    placeholder:"Select Product type here",
                    minimumResultsForSearch: -1
                });
                $('#supplier').val(null).select2
                ({
                    placeholder: "Select Supplier here",
                    dropdownCssClass : 'commprp',
                });

                $('#CompanyType').append(comptypeowner);
                $('#CompanyType').select2
                ({
                    placeholder: "Select Company type here",
                    minimumResultsForSearch: -1
                });
            }
            $('#type-error').html("");
        }

        function getPoList(){
            var polist="";
            $.ajax({
                url: '/getPoNumberList',
                type: 'POST',
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
                    $('#PONumber').empty();
                    polist='<option selected disabled></option>';
                    $.each(data.podatasrc, function(key, value) {
                        polist+='<option value='+value.id+'>'+value.porderno+'     ,     '+value.Name+'     ,     '+value.TinNumber+'</option>';
                    });

                    $('#PONumber').append(polist).select2({
                        placeholder:"Select Reference number here",
                        dropdownCssClass : 'cusmidprp',
                    });
                }
            });
        }

        function poNumberFn() {
            var ponumber = "";
            var prdtype = "";
            var defaultsup = "";
            var defcommsrc = "";
            var storeid = $('#store').val() || 0;
            var product_type = "";
            var po_item = "";
            j2 = 0;
            j = 0;
            $('#supplier').empty();
            $('#CommoditySource').empty();
            $('#po_goods_default').empty();
            $('#commDynamicTable > tbody').empty();
            $('#dynamicTable > tbody').empty();
            $('#adds').hide();
            $('#commadds').hide();
            $.ajax({
                url: '/getPoData',
                type: 'POST',
                data:{
                    ponumber:$('#PONumber').val(),
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
                    product_type = data.prtype == "Commodity" ? 1 : 2;

                    $.each(data.polist, function(key, value) {
                        defaultsup='<option selected value='+value.customers_id+'>'+value.Name+'    ,   '+value.TinNumber+'    ,   '+value.PhoneNumber+'    ,   '+value.OfficePhone+'</option>';
                        defcommsrc='<option selected value='+data.commsrc+'>'+data.commsrc+'</option>';
                        $('.productcls').hide();
                        if(product_type == 1){
                            prdtype='<option selected value='+data.prtype+'>'+data.prtype+'</option>';
                            $('.commprop').show();
                            $('#commoditydiv').show();
                        }
                        else if(product_type == 2){
                            prdtype='<option selected value="Goods">Goods</option>';
                            $('.commprop').hide();
                            $('#goodsdiv').show();
                        }

                        $('#ProductType').append(prdtype).select2({
                            placeholder:"Select Product type here",
                            minimumResultsForSearch: -1
                        });

                        $('#CommoditySource').append(defcommsrc).select2({
                            placeholder:"Select Commodity source here",
                            minimumResultsForSearch: -1
                        });

                        $('#supplier').append(defaultsup);
                        $('#supplier').select2
                        ({
                            placeholder: "Select Supplier here",
                            dropdownCssClass : 'commprp',
                            minimumResultsForSearch: -1
                        });
                    });

                    if(product_type == 1){
                        $.each(data.purdetaildata, function(key, value) {
                            ++i2;
                            ++m2;
                            ++j2;

                            if(parseInt(j2) % 2 === 0){
                                borcolor = "#f8f9fa";
                            }
                            else{
                                borcolor = "#FFFFFF";
                            }

                            $("#commDynamicTable > tbody").append('<tr id="rowind'+m2+'" class="mb-1" style="background-color:'+borcolor+';"><td style="width:2%;text-align:left;vertical-align: top;">'+
                                '<span class="badge badge-center rounded-pill bg-secondary">'+j2+'</span>'+
                            '</td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m2+'][vals]" id="vals'+m2+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m2+'"/></td>'+
                            '<td style="width:96%;">'+
                                '<div class="row">'+
                                    '<div class="col-xl-6 col-md-6 col-lg-6" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                                        '<div class="row">'+
                                            '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Floor Map</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="FloorMap'+m2+'" class="select2 form-control FloorMap" onchange="FloorMapFn(this)" name="row['+m2+'][FloorMap]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-4 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CommType'+m2+'" class="select2 form-control CommType" onchange="CommTypeFn(this)" name="row['+m2+'][CommType]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-6 col-md-4 col-lg-6 mb-1">'+
                                                '<label style="font-size: 12px;">Commodity</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Origin'+m2+'" class="select2 form-control Origin" onchange="OriginFn(this)" name="row['+m2+'][Origin]"></select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="row">'+
                                            '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Grade</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Grade'+m2+'" class="select2 form-control Grade" onchange="GradeFn(this)" name="row['+m2+'][Grade]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Process Type</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="ProcessType'+m2+'" class="select2 form-control ProcessType" onchange="ProcessTypeFn(this)" name="row['+m2+'][ProcessType]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Crop Year</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="CropYear'+m2+'" class="select2 form-control CropYear" onchange="CropYearFn(this)" name="row['+m2+'][CropYear]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-3 col-md-3 col-lg-3 mb-1">'+
                                                '<label style="font-size: 12px;">Remark</label>'+
                                                '<textarea type="text" placeholder="Write Remark here..." class="Remark form-control mainforminp" rows="1" name="row['+m2+'][Remark]" id="Remark'+m2+'"></textarea>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-xl-4 col-md-4 col-lg-4" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">'+
                                        '<div class="row">'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">UOM/Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<select id="Uom'+m2+'" class="select2 form-control Uom" onchange="UomFn(this)" name="row['+m2+'][Uom]"></select>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">No. of Bag</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][NumOfBag]" placeholder="Write Number of bag here" id="NumOfBag'+m2+'" class="NumOfBag form-control numeral-mask commnuminp" onkeyup="NumOfBagFn(this)" onkeypress="return ValidateOnlyNum(event);" step="any"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0">'+
                                                '<label style="font-size: 12px;">Bag Weight by KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][TotalBagWeight]" placeholder="Bag weight" id="TotalBagWeight'+m2+'" class="TotalBagWeight form-control numeral-mask commnuminp" onkeyup="BagWeightFn(this)" readonly onkeypress="return ValidateNum(event);" style="font-weight:bold;" step="any"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                                '<label style="font-size: 12px;">Total KG</label><label style="color: red; font-size:16px;">*</label>'+
                                                '<input type="number" name="row['+m2+'][TotalKg]" placeholder="Write total kg here..." id="TotalKg'+m2+'" class="TotalKg form-control numeral-mask commnuminp" onkeyup="TotalKgFn(this)" onblur="TotalKgErrFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                                '<label style="font-size: 12px;">Net KG<i class="fa-solid fa-circle-info" title="Total KG - Bag Weight by KG"></i></label>'+
                                                '<input type="number" name="row['+m2+'][NetKg]" placeholder="Write Net KG here..." id="NetKg'+m2+'" class="NetKg form-control numeral-mask commnuminp" onkeyup="NetKgFn(this)" onblur="NetKgErrFn(this)" onkeypress="return ValidateNum(event);" step="any"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mt-1">'+
                                                '<label style="font-size: 12px;">Feresula<i class="fa-solid fa-circle-info" title="Net KG / 17"></i></label>'+
                                                '<input type="number" name="row['+m2+'][Feresula]" placeholder="Write Feresula here..." id="Feresula'+m2+'" class="Feresula form-control numeral-mask commnuminp" onkeypress="return ValidateNum(event);" step="any"/>'+
                                            '</div>'+
                                            '<div class="col-xl-4 col-md-4 col-lg-4 mb-0"></div>'+
                                            '<div class="col-xl-8 col-md-8 col-lg-8 mb-0">'+
                                                '<label style="font-size: 12px;font-weight:bold;" id="varianceLbl'+m2+'"></label>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-xl-2 col-md-2 col-lg-2">'+
                                        '<div class="row" id="podatatbl'+m2+'" style="display:none;">'+
                                            '<div class="col-xl-12 col-md-12 col-lg-12 mt-0" style="text-align:center;">'+
                                                '<label style="font-size: 13px;"><b>Requested Amount</b></label>'+
                                            '</div>'+
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;" id="reqnumofbaglbl'+m2+'">No. of Bag</label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;font-weight:bold;" id="reqnumofbag'+m2+'"></label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;" id="reqweightkglbl'+m2+'">Weight by KG</label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;font-weight:bold;" id="reqweightkg'+m2+'"></label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;" id="reqferesulalbl'+m2+'">Feresula</label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;font-weight:bold;" id="reqferesula'+m2+'"></label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-12 col-md-12 col-lg-12 mt-0" style="text-align:center;">'+
                                                '<label style="font-size: 13px;"><b>Remaining Amount</b></label>'+
                                            '</div>'+
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;" id="remnumofbaglbl'+m2+'">No. of Bag</label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;font-weight:bold;" id="remnumofbag'+m2+'"></label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;" id="remweightkglbl'+m2+'">Weight by KG</label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;font-weight:bold;" id="remweightkg'+m2+'"></label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-5 col-md-5 col-lg-5 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;" id="remferesulalbl'+m2+'">Feresula</label>'+
                                            '</div>'+ 
                                            '<div class="col-xl-7 col-md-7 col-lg-7 mb-0" style="text-align:left;">'+
                                                '<label style="font-size: 10px;font-weight:bold;" id="remferesula'+m2+'"></label>'+
                                            '</div>'+ 
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</td>'+
                            '<td style="width:2%;text-align:right;vertical-align: top;">'+
                                '<button type="button" id="commremovebtn'+m2+'" class="btn btn-light btn-sm commremove-tr" style="color:#ea5455;background-color:'+borcolor+';border-color:'+borcolor+';padding: 4px 5px;"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+
                            '</td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][reUnitCost]" id="reUnitCost'+m2+'" class="reUnitCost form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][remBagNum]" id="remBagNum'+m2+'" class="remBagNum form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][remKg]" id="remKg'+m2+'" class="remKg form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][bagWeight]" id="bagWeight'+m2+'" class="bagWeight form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][uomFactor]" id="uomFactor'+m2+'" class="uomFactor form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][varianceshortage]" id="varianceshortage'+m2+'" class="varianceshortage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="number" name="row['+m2+'][varianceoverage]" id="varianceoverage'+m2+'" class="varianceoverage form-control numeral-mask" style="font-weight:bold;" step="any" readonly/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m2+'][podetid]" id="podetid'+m2+'" class="podetid form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '<td style="display:none;"><input type="hidden" name="row['+m2+'][id]" id="id'+m2+'" class="id form-control" readonly="true" style="font-weight:bold;"/></td>'+
                            '</tr>');

                            var defaultoption = '<option selected value=""></option>';
                            var defaultgrade='<option selected value='+value.grade+'>'+value.GradeName+'</option>';
                            var originoptions = $("#commoditydefault > option").clone();
                            $('#Origin'+m2).append(originoptions);
                            $("#Origin"+m2+" option[value!="+value.itemid+"]").remove(); 
                            $("#Origin"+m2+" option[label!="+value.purchaseorder_id+"]").remove(); 

                            //To remove duplicate values in the dropdown
                            $('#Origin'+m2).find('option').each(function() {
                                var currentValue = $(this).val();
                                $(this).siblings('[value="' + currentValue + '"]').remove();
                            });

                            $('#Origin'+m2).select2
                            ({
                                placeholder: "Select Commodity here",
                                dropdownCssClass : 'commprp',
                                minimumResultsForSearch: -1
                            });

                            var origindata = $('#Origin'+m2).find('option[value="' + value.itemid + '"]');
                            var commtype=origindata.attr('title');
                            var commtypeoptions = $("#commoditytypedefault > option").clone();
                            $('#CommType'+m2).append(commtypeoptions);
                            $("#CommType"+m2+" option[value!="+commtype+"]").remove(); 
                            $('#CommType'+m2).select2
                            ({
                                placeholder: "Select Commodity type here",
                                dropdownCssClass : 'cusprop',
                                minimumResultsForSearch: -1
                            });

                            var uomdataoptions = $("#uomdefault > option").clone();
                            $('#Uom'+m2).append(uomdataoptions);
                            $("#Uom"+m2+" option[value!="+value.uom+"]").remove(); 
                            $('#Uom'+m2).select2
                            ({
                                placeholder: "Select UOM/Bag here",
                                dropdownCssClass : 'cusprop',
                                minimumResultsForSearch: -1
                            });

                            var uomopt = $('#uomdefault').find('option[value="' +value.uom+ '"]');
                            var uomfactor=uomopt.attr('title');
                            var uombagweight=uomopt.attr('label');

                            $('#uomFactor'+m2).val(uomfactor);
                            $('#bagWeight'+m2).val(uombagweight);

                            var cropyearoptions = $("#cropyeardefault > option").clone();
                            $('#CropYear'+m2).append(cropyearoptions);
                            $("#CropYear"+m2+" option[value!="+value.cropyear+"]").remove(); 
                            $('#CropYear'+m2).select2
                            ({
                                placeholder: "Select Crop year here",
                                dropdownCssClass : 'cusprop',
                                minimumResultsForSearch: -1
                            });

                            var processtypeoption = $("#processtypedefault > option").clone();
                            $('#ProcessType'+m2).append(processtypeoption);
                            $("#ProcessType"+m2+" option[value!="+value.proccesstype+"]").remove(); 
                            $('#ProcessType'+m2).select2
                            ({
                                placeholder: "Select Process type here",
                                dropdownCssClass : 'cusprop',
                                minimumResultsForSearch: -1
                            });

                            var gradeoption = $("#gradedefault > option").clone();
                            $('#Grade'+m2).append(gradeoption);
                            $("#Grade"+m2+" option[value="+value.grade+"]").remove(); 
                            $('#Grade'+m2).append(defaultgrade);
                            $('#Grade'+m2).select2
                            ({
                                placeholder: "Select Grade here",
                                dropdownCssClass : 'cusprop',
                            });

                            var floormapopt = $("#locationdefault > option").clone();
                            $('#FloorMap'+m2).append(floormapopt);
                            $("#FloorMap"+m2+" option[title!="+storeid+"]").remove(); 
                            $('#FloorMap'+m2).append(defaultoption);
                            $('#FloorMap'+m2).select2
                            ({
                                placeholder: "Select Floor map here",
                            });

                            $('#Feresula'+m2).prop("readonly",true);
                            $('#NumOfBag'+m2).prop("readonly",false);
                            $('#NetKg'+m2).prop("readonly",true);

                            $('#podetid'+m2).val(value.PoDetId);
                            // $('#reqnumofbag'+m2).html(value.qty);
                            // $('#reqweightkg'+m2).html(value.totalkg);
                            // $('#reqferesula'+m2).html(value.feresula);

                            // $('#remnumofbag'+m2).html(value.qty);
                            // $('#remweightkg'+m2).html(value.totalkg);
                            // $('#remferesula'+m2).html(value.feresula);
                            // $('#remKg'+m2).val(value.totalkg);

                            $('#podatatbl'+m2).show();

                            CalculateReqAmount(m2);

                            $('#select2-FloorMap'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-CommType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Origin'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Grade'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-ProcessType'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-CropYear'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $('#select2-Uom'+m2+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                        });

                        CalculateCommTotal();
                        commRenumberRows();
                    }

                    else if(product_type == 2){
                        po_item = `<option selected disabled value=""></option>`;
                        $.each(data.po_items, function(key, value) {
                            po_item += `<option value="${value.id}">${value.item_name}</option>`;
                        });
                        $('#po_goods_default').append(po_item);
                        $('#po_goods_default').select2();

                        $.each(data.goods_purdetaildata, function(key, value) {
                            ++i;
                            ++j;
                            ++m;

                            $("#dynamicTable > tbody").append(`<tr id="row_ind${m}">
                                <td style="font-weight:bold;text-align:center;width:3%">${j}</td>
                                <td style="display:none;"><input type="hidden" name="row[${m}][vals]" id="vals${m}" class="vals form-control" readonly="true" style="font-weight:bold;" value="${m}"/></td>
                                <td style="width:13%">
                                    <select id="location${m}" class="select2 form-control location" onchange="locationFn(this)" name="row[${m}][location]"></select>
                                </td>
                                <td style="width:14%">
                                    <select id="itemNameSl${m}" class="select2 form-control itemName" onchange="itemFn(this)" name="row[${m}][ItemId]"></select>
                                </td>
                                <td style="width:13%">
                                    <select id = "uom${m}" class ="select2 form-control uom" onchange = "uomVal(this)" name = "row[${m}][uom]"></select>
                                </td>
                                <td style="width:13%">
                                    <input type="number" name="row[${m}][Quantity]" placeholder="Quantity" id="quantity${m}" class="quantity form-control numeral-mask" onkeyup="qtyFn(this)" onkeypress="return ValidateNum(event);" ondrop="return false;" onpaste="return false;" value="${value.Quantity}"/>
                                </td>
                                <td style="width:13%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="requested_qty_inp${m}"></label>
                                    <input type="hidden" name="row[${m}][requested_qty]" id="requested_qty${m}" placeholder="Requested Quantity" class="requested_qty form-control numeral-mask" onkeypress="return ValidateNum(event);"/>
                                </td>
                                <td style="width:13%;background-color:#efefef;text-align:center">
                                    <label style="font-weight:bold;font-size:14px" class="readonlyfield" id="remaining_qty_inp${m}"></label>
                                    <input type="hidden" name="row[${m}][remaining_qty]" id="remaining_qty${m}" placeholder="Remaining Quantity" class="remaining_qty form-control numeral-mask" readonly="true" style="font-weight:bold;"/>
                                </td>
                                <td style="width:15%;">
                                    <input type="text" name="row[${m}][Memo]" id="Memo${m}" class="Memo form-control" placeholder="Write remark here..."/>
                                </td>
                                <td style="width:3%;text-align:center;">
                                    <button type="button" class="btn btn-light btn-sm addsernum" style="display:none;color:#28c76f;background-color:#FFFFFF;border-color:#FFFFFF" onclick="addser(this)"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></button>
                                    <button type="button" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>
                                </td>
                            </tr>`);

                            var default_option = `<option selected disabled value=""></option>`;
                            var default_item = `<option selected value="${value.itemid}">${value.item_name}</option>`;

                            var location = $("#locationdefault > option").clone();
                            $(`#location${m}`).append(location);
                            $(`#location${m} option[title!="${storeid}"]`).remove();
                            $(`#location${m}`).append(default_option);
                            $(`#location${m}`).select2({placeholder: "Select Location here...",});

                            var item_data = $("#itemnamefooter > option").clone();
                            $(`#itemNameSl${m}`).append(default_item);
                            $(`#itemNameSl${m}`).select2({
                                dropdownCssClass : 'commprp',
                                minimumResultsForSearch: -1
                            });

                            $(`#uom${m}`).append(`<option selected value="${value.uom_id}">${value.uom_name}</option>`);
                            $(`#uom${m}`).select2({minimumResultsForSearch: -1});

                            $(`#select2-location${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $(`#select2-itemNameSl${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                            $(`#select2-uom${m}-container`).parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});

                            CalculateReqAmount(m);
                        });
                        
                    }
                }
            });    
            
            $('#commadds').hide();
            $('#ponumber-error').html("");
            $('#prdtype-error').html("");
            $('#supplier-error').html("");
            $('#commoditysrc-error').html("");
            $('#commoditytype-error').html("");
        }

        function prTypeFn() {
            var productType=$('#ProductType').val();
            var commsrc=$("#commoditysourcedefault > option").clone();
            $('.commprop').hide();
            $('#CommoditySource').empty();
            $('#dynamicTable > tbody').empty();
            $('#commDynamicTable > tbody').empty();
            $('#adds').hide();
            $('#commadds').hide();
            $('.productcls').hide();           
            if(productType == 'Commodity'){
                $('.commprop').show();
                $('#commoditydiv').show();
                $('#CommoditySource').append(commsrc).select2({
                    placeholder:"Select Commodity source here",
                });
                $("#commadds").show();
            }
            else if(productType == 'Goods'){
                $('.commprop').hide();
                $('#goodsdiv').show();
                $('#CommoditySource').val(null).select2({
                    placeholder:"Select Commodity source here",
                });
                $('#adds').show();
            }
            $('#prdtype-error').html("");
        }

        function CalculateReqAmount(indx){
            var item_id="";
            var commodity="";
            var grade="";
            var prtype="";
            var cropyear="";
            var uomval="";
            var poId="";
            var poDetId="";
            var recId="";
            var numofbag=0;
            var weightbykg=0;
            var feresula=0;

            var recnumofbag=0;
            var recweightbykg=0;
            var recferesula=0;

            var othnumofbag=0;
            var othweightbykg=0;
            var othferesula=0;

            var remnumofbag=0;
            var remweightbykg=0;
            var remferesula=0;

            var req_qty = 0;
            var rec_qty = 0;
            var rem_qty = 0;
            var other_rec = 0;

            $.ajax({
                url: '/calcReqAmount',
                type: 'POST',
                data:{
                    item_id:$('#itemNameSl'+indx).val() || 0,
                    commodity:$('#Origin'+indx).val() || 0,
                    grade:$('#Grade'+indx).val() || 0,
                    prtype:$('#ProcessType'+indx).val() || 0,
                    cropyear:$('#CropYear'+indx).val() || 0,
                    uomval:$('#Uom'+indx).val() || 0,
                    poDetId:$('#podetid'+indx).val() || 0,
                    poId:$('#PONumber').val() || 0,
                    recId:$('#receivingId').val() || 0,
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
                    if (data.product_type == 1){
                        $.each(data.purdetaildata, function(key, value) { 
                            $(`#reqnumofbag${indx}`).html(value.qty);
                            $(`#reqweightkg${indx}`).html(parseFloat(value.totalkg).toFixed(2));
                            $(`#reqferesula${indx}`).html(parseFloat(value.feresula).toFixed(2));
                            $(`#reUnitCost${indx}`).val(parseFloat(value.price/17).toFixed(2));

                            numofbag=value.qty;
                            weightbykg=value.totalkg;
                            feresula=value.feresula;
                        }); 

                        $.each(data.recdetaildata, function(key, value) {
                            recnumofbag=value.NumOfBag;
                            recweightbykg=value.TotalKg;
                            recferesula=value.Feresula;
                        });

                        $.each(data.othersdetaildata, function(key, value) {
                            othnumofbag=value.NumOfBag||0;
                            othweightbykg=value.TotalKg||0;
                            othferesula=value.Feresula||0;
                        });

                        remnumofbag=(parseFloat(numofbag)-parseFloat(othnumofbag));
                        remweightbykg=(parseFloat(weightbykg)-parseFloat(othweightbykg));
                        remferesula=(parseFloat(feresula)-parseFloat(othferesula));

                        remnumofbag = remnumofbag < 0 ? 0 : remnumofbag;
                        remweightbykg = remweightbykg < 0 ? 0 : remweightbykg;
                        remferesula = remferesula < 0 ? 0 : remferesula;

                        $(`#remnumofbag${indx}`).html(remnumofbag);
                        $(`#remweightkg${indx}`).html(remweightbykg.toFixed(2));
                        $(`#remferesula${indx}`).html(remferesula.toFixed(2));
                        $(`#remBagNum${indx}`).val(remnumofbag);
                        $(`#remKg${indx}`).val(remweightbykg);

                        if(parseFloat(remnumofbag) <= 0){
                            $(`#rowind${indx}`).remove();
                        }
                    }
                    else if(data.product_type == 2){
                        $.each(data.purdetaildata, function(key, value) { 
                            $(`#requested_qty${indx}`).val(value.qty);
                            $(`#requested_qty_inp${indx}`).html(value.qty);

                            req_qty = value.qty || 0;
                        }); 

                        $.each(data.recdetaildata, function(key, value) {
                            rec_qty = value.Quantity || 0;
                        });

                        $.each(data.othersdetaildata, function(key, value) {
                            other_rec = value.Quantity || 0;
                        });

                        rem_qty = (parseFloat(req_qty)-parseFloat(other_rec));
                        $(`#remaining_qty${indx}`).val(rem_qty);
                        $(`#remaining_qty_inp${indx}`).html(rem_qty);

                        if(parseFloat(rem_qty) <= 0){
                            $(`#row_ind${indx}`).remove();
                            renumberRows();
                        }
                    }
                }
            });
        }

        function documentUploadFn() {
            var recordId = $('#receivingId').val();
            var filenames = $('#documentuploadfilelbl').val();
            $.get("/downloadGrvDoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/GoodReceivingDocument/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function grvFileDownload() {
            var recordId = $('#recordIds').val();
            var filenames = $('#infogrvfilename').val();
            $.get("/downloadGrvDoc" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/GoodReceivingDocument/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        function commoditySrcFn() {
            $('#commoditysrc-error').html("");
        }

        function commodityTypeFn() {
            $('#commoditytype-error').html("");
        }

        function compTypeFn() {
            var comtype=$('#CompanyType').val();
            if(parseInt(comtype)==1){
                $('.customerdiv').hide();
                $('#Customer').val(1).select2({
                    placeholder:"Select Customer here",
                    dropdownCssClass : 'commprp',
                });
            }
            else if(parseInt(comtype)==2){
                $('.customerdiv').show();
                $('#Customer').val(null).select2({
                    placeholder:"Select Customer here",
                    dropdownCssClass : 'commprp',
                });
            }

            $('.cusrepr').val("");
            $('.cusreprerr').html("");
            $('#comptype-error').html('');
        }

        function storeVal() {
            var storeid=$('#store').val();
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

            $('.location').empty();
            $('.location').append(floormapopt);
            $(".location option[title!="+storeid+"]").remove(); 
            $('.location').append(defaultoption);
            $('.location').select2
            ({
                placeholder: "Select Location here...",
            });

            $('.select2-selection__rendered').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            $('#store-error').html('');
        }

        function recdateFn() {
            $('#receiveddate-error').html("");
        }

        function customerFn() {
            $('#customer-error').html("");
        }

        function recievedByFn() {
            $('#receivedby-error').html("");
        }

        function dispatchStFn() {
            $('#dispatchst-error').html("");
        }

        function deliveredByFn() {
            $('#deliveredby-error').html("");
        }

        function truckDriverFn() {
            $('#truckdriver-error').html("");
        }

        function plateNumFn() {
            $('#platenum-error').html("");
        }

        function driverPhoneNumFn() {
            $('#driverphonenum-error').html("");
        }

        function deliveryOrdNumFn() {
            $('#deliveryordnumber-error').html("");
        }

        function purchaserVal() {
            $('#purchaser-error').html("");
        }

        function validateQuantityVal() {
            $('#addHoldQuantity-error').html("");
        }

        function validateUnitcostVal() {
            $('#addHoldunitCost-error').html("");
        }

        function voidReason() {
            $('#void-error').html("");
        }

        function ReceiptNumberVal() {
            $('#receipt-error').html("");
        }

        function ReceiptNumberVals() {
            $('#receipts-error').html("");
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        function updateTextView(_obj) {
            var num = getNumber(_obj.val());
            if (num == 0) {
                _obj.val('');
            } else {
                _obj.val(num.toLocaleString());
            }
        }

        function getNumber(_str) {
            var arr = _str.split('');
            var out = new Array();
            for (var cnt = 0; cnt < arr.length; cnt++) {
                if (isNaN(arr[cnt]) == false) {
                    out.push(arr[cnt]);
                }
            }
            return Number(out.join(''));
        }
        // $(document).ready(function() {
        //     $('input[type=text]').on('keyup', function() {
        //         updateTextView($(this));
        //     });
        // });

    $('#brand').on('change', function () 
    {
        var sid = $('#brand').val();
        $('#modelNumber').find('option').not(':first').remove();
        var registerForm = $("#serialNumberRegForm");
        var formData = registerForm.serialize();
        $.ajax({
            url:'showModelsRec/'+sid,
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

    $('#saveSerialNum').click(function()
    {
        var registerForm = $('#serialNumberRegForm');
        var formData = registerForm.serialize();
        $.ajax({
           url:'/addSerialnumbersRec',
            type:'POST',
            data:formData,
            beforeSend:function(){$('#saveSerialNum').text('Adding...');
            $('#saveSerialNum').prop( "disabled", true );
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
                    $('#saveSerialNum').prop("disabled",false);
                    toastrMessage('error',"Inserted for all quantity","Error");
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
                    $('#saveSerialNum').prop("disabled", false);
                    toastrMessage('success',"Successful","Success");
                    $('#insertedQuantityLbl').text(data.Totalcount);
                    var inserted=data.Totalcount;
                    var dval=$('#dynamicrownum').val();
                    var totalcnt=$('#totalQuantityLbl').text();
                    var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                    $('#remainingQuantityLbl').text(netQ);
                    $('#insertedqty'+dval).val(inserted);
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

    $('#saveSerialNumSt').click(function()
    {
        var registerForm = $('#serialNumberRegForm');
        var formData = registerForm.serialize();
        $.ajax({
           url:'/addSerialnumbersRecStatic',
            type:'POST',
            data:formData,
            beforeSend:function(){$('#saveSerialNumSt').text('Adding...');
            $('#saveSerialNumSt').prop( "disabled", true );
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
                    $('#saveSerialNumSt').text('Add');
                    $('#saveSerialNumSt').prop( "disabled", false );
                    toastrMessage('error',"Check your inputs","Error");
                }
                if(data.valerror)
                {
                    $('#saveSerialNumSt').text('Add');
                    $('#saveSerialNumSt').prop( "disabled", false );
                    toastrMessage('error',"Inserted for all quantity","Error");
                }
                if(data.qnterror)
                {
                    $('#saveSerialNumSt').text('Add');
                    $('#saveSerialNumSt').prop( "disabled", false );
                    toastrMessage('error',"The remaining quantity is not the same with inserted quantity","Error");
                }
                if(data.success) 
                {    
                    $('#saveSerialNumSt').text('Add');
                    $('#saveSerialNumSt').prop("disabled", false );
                    toastrMessage('success',"Successful","Success");
                    $('#insertedQuantityLbl').text(data.Totalcount);
                    var inserted=data.Totalcount;
                    var dval=$('#dynamicrownum').val();
                    var totalcnt=$('#totalQuantityLbl').text();
                    var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                    $('#remainingQuantityLbl').text(netQ);
                    $('#insertedqty').val(inserted);
                    $('#SerialNumber').val("");
                    $('#tableid').val("");
                    var iTable = $('#laravel-datatable-crud-snedit').dataTable(); 
                    iTable.fnDraw(false);
                    var kTable = $('#laravel-datatable-crud-sn').dataTable(); 
                    kTable.fnDraw(false);
                    var oTable = $('#doneinfodetail').dataTable(); 
                    oTable.fnDraw(false);
                    var jTable = $('#receivingEditTable').dataTable();
                    jTable.fnDraw(false);
                    clearSnSt();
                    $('#modelNumber').empty();
                }
            },
        });
    });

    $("#DocumentUpload").change(function() {
        $('#docBtn').show();
        $('#documentupload-error').html('');
    });

    function docBtnFn() {
        $('#DocumentUpload').val("");
        $('#documentuploadfilelbl').val("");
        $('#DocumentUpload').val(null);
        $('#docBtn').hide();
        $('#documentupload-error').html('');
        $("#documentuploadlinkbtn").hide();
    }

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

    function closeSnSt()
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
        $('#saveSerialNumSt').text("Add");
        $('#saveSerialNumSt').prop( "disabled", false );
        $('#closeSerialNumSt').hide();
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

    function clearSnSt()
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
        $('#saveSerialNumSt').text("Add");
        $('#saveSerialNumSt').prop( "disabled", false );
        $('#closeSerialNumSt').hide();
    }

    //start edit serial number modal
    function editSN(recIdVar){
        //var recIdVar = $(this).data('id');
        //var mod = $(this).data('mod');
        $('#modelNumber').empty();
       // var options = "<option selected value="+mod+">"+mod+"</option>";
        //$('#modelNumber').append(options);
        $.get("/serialnumbereditRec" +'/' + recIdVar , function (data)
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
    }
    //end edit serial number modal

    //start edit serial number modal
    function editSNSt(recIdVar){
        //var recIdVar = $(this).data('id');
        //var mod = $(this).data('mod');
        $('#modelNumber').empty();
        //var options = "<option selected value="+mod+">"+mod+"</option>";
        //$('#modelNumber').append(options);
        $.get("/serialnumbereditRecStatic" +'/' + recIdVar , function (data)
        {
            $('#tableid').val(recIdVar);
            $('#brand').selectpicker('val',data.recData.brand_id).trigger('change');
            $('#ManufactureDate').val(data.recData.ManufactureDate);
            $('#ExpireDate').val(data.recData.ExpireDate);
            $('#BatchNumber').val(data.recData.BatchNumber);
            $('#SerialNumber').val(data.recData.SerialNumber);
        });
        $('#saveSerialNumSt').text("Update");
        $('#saveSerialNumSt').prop( "disabled", false );
        $('#closeSerialNumSt').show();
        $('#serialNumberModal').animate({scrollTop: 0},'slow');
    }
    //end edit serial number moda

    $('#sernumDeleteModal').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var totalqnt=$('#totalQuantityLbl').text();
        $('#dynamicdelval').val($('#dynamicrownum').val());
        $('#totalBegQuantity').val(totalqnt);
        var id=button.data('id');
        var modal=$(this);
        modal.find('.modal-body #sid').val(id);
    });

    $('#sernumDeleteModalSt').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget);
        var totalqnt=$('#totalQuantityLbl').text();
        $('#dynamicdelval').val($('#dynamicrownum').val());
        $('#totalBegQuantity').val(totalqnt);
        var id=button.data('id');
        var modal=$(this);
        modal.find('.modal-body #stid').val(id);
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
            url:'/serialdeleteRec/'+sid,
            type:'DELETE',
            data:'',
            beforeSend:function(){
            $('#deleteSerialNumberBtn').text('Deleting...');},
            success:function(data)
            {
                $('#deleteSerialNumberBtn').text('Delete');
                toastrMessage('success',"Removed","Success");
                $('#sernumDeleteModal').modal('hide');
                $('#insertedQuantityLbl').text(data.Totalcount);
                var dval=$('#dynamicdelval').val();
                var inserted=data.Totalcount;
                var totalcnt=$('#totalBegQuantity').val();
                var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                $('#remainingQuantityLbl').text(netQ);
                $('#insertedqty'+dval).val(inserted);
                var oTable = $('#doneinfodetail').dataTable(); 
                oTable.fnDraw(false);
                var iTable = $('#laravel-datatable-crud-sn').dataTable(); 
                iTable.fnDraw(false);
            }
        });
    });
    //Delete Records Ends

    //Delete Records Starts
    $('#deleteSerialNumberBtnSt').click(function()
    {
        var deleteForm = $("#deleteserialnumformst");
        var formData = deleteForm.serialize();
        var sid=$('#stid').val();
        $.ajax(
        {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:'/serialdeleteRecStatic/'+sid,
            type:'DELETE',
            data:'',
            beforeSend:function(){
            $('#deleteSerialNumberBtnSt').text('Deleting...');},
            success:function(data)
            {
                $('#deleteSerialNumberBtnSt').text('Delete');
                toastrMessage('success',"Removed","Success");
                $('#sernumDeleteModalSt').modal('hide');
                $('#insertedQuantityLbl').text(data.Totalcount);
                var dval=$('#dynamicdelval').val();
                var inserted=data.Totalcount;
                var totalcnt=$('#totalBegQuantity').val();
                var netQ=parseFloat(totalcnt)-parseFloat(inserted);
                $('#remainingQuantityLbl').text(netQ);
                $('#insertedqty'+dval).val(inserted);
                var oTable = $('#doneinfodetail').dataTable(); 
                oTable.fnDraw(false);
                var iTable = $('#laravel-datatable-crud-snedit').dataTable(); 
                iTable.fnDraw(false);
                var kTable = $('#laravel-datatable-crud-sn').dataTable(); 
                kTable.fnDraw(false);
                var jTable = $('#receivingEditTable').dataTable();
                jTable.fnDraw(false);
            }
        });
    });
    //Delete Records Ends

    $(function () {
        cardSection = $('#page-block');
    });

    $('#fiscalyear').on('change', function() {
        var fyear = $('#fiscalyear').val();
        getReceivingData(fyear);
    });

    $('#cus_fiscalyear').on('change', function() {
        var cus_fyear = $('#cus_fiscalyear').val();
        getCustomerData(cus_fyear);
    });

        function refreshbothtbl(){
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
            var iTable = $('#laravel-datatable-crud-hold').dataTable(); 
            iTable.fnDraw(false);
        }

        function closeInfoModal() 
        {
            //var oTable = $('#laravel-datatable-crud').dataTable(); 
           // oTable.fnDraw(false);
        }

        //------------Supplier add section--------------------

        function addsupplier(){
            $("#suppliermodal").modal('show');
            $('#DefaultPrice').val("Retailer");
            $('#creditLimitPeriodDiv').hide();
            $('#creditLimitDiv').hide();
            $('#CreditLimitPeriod').val("0");
            $('#CreditLimit').val("0");
            $('#dprice').val("Retailer");
            $('#creditLimitPeriodDiv').hide();
            $('#creditLimitDiv').hide();
            $('#allowedcrsales').show();
            $('#allowedcreditsales-error').html("");
            $("#name").prop("readonly", false);
            $("#TinNumber").prop("readonly", false);
            $("#MRCNumber").prop("readonly", false);
            $("#VatNumber").prop("readonly", false);
            resetsupplierform();
            $("#CustomerCategory option[value!=100]").show();
            $.get("/getCustomerCode", function(data) {
                $("#codetypeinput").val(data.ctype);
                var codetype = data.ctype;
                if (codetype == "1") {
                    $("#Code").prop("readonly", true);
                    $("#Code").val(data.cuscode);
                }
                if (codetype == "0") {
                    $("#Code").prop("readonly", false);
                    $("#Code").val("");
                }
            });
        }

        //Reset forms or modals starts
        function resetsupplierform() {
            $("#Register")[0].reset();
            $('#name-error').html("");
            $('#status-error').html("");
            $('#uname-error').html("");
            $('#ustatus-error').html("");
            $('#tinDiv').show();
            $('#TinNumber').val("");
            $('#tin-error').html("");
            $('#bltin-error').html("");
            $('#vatRegDiv').show();
            $('#VatNumber').val("");
            $('#VatNumber-error').html("");
            $('#mrcDiv').show();
            $('#MrcNumber').val("");
            $('#mrc-error').html("");
            $('#vatDiv').hide();
            $('#VatDeduct').val("");
            $('#VatDeduct-error').html("");
            $('#withDiv').hide();
            $('#WitholdDeduct').val("");
            $('#WitholdDeduct-error').html("");
            $('#defpaymentDiv').hide();
            $('#DefaultPayment').val("");
            $('#defaultpayment-error').html("");
            $('#ReasonDiv').hide();
            $('#Reason').val("");
            $('#Reason-error').html("");
            $('#mname-error').html("");
            $('#id-error').html("");
            $('#cuscategory-error').html("");
            $('#tin-error').html("");
            $('#VatNumber-error').html("");
            $('#mrc-error').html("");
            $('#VatDeduct-error').html("");
            $('#WitholdDeduct-error').html("");
            $('#defaultpayment-error').html("");
            $('#PhoneNumber-error').html("");
            $('#OfficePhoneNumber-error').html("");
            $('#Address-error').html("");
            $('#Country-error').html("");
            $('#Memo-error').html("");
            $('#status-error').html("");
            $('#Reason-error').html("");
            $('#ReasonDiv').hide();
            $('#savenewbutton').show();
            $('#savebutton').show();
            $('#updatecustomer').hide();
            $('#myModalLabel333').html("Add Supplier");
            $('#blname-error').html("");
            $('#blid-error').html("");
            $('#blVatNumber-error').html("");
            $('#blPhoneNumber-error').html("");
            $('#blOfficePhoneNumber-error').html("");
            $('#blAddress-error').html("");
            $('#blCountry-error').html("");
            $('#blMemo-error').html("");
            $('#savenewblbutton').show();
            $('#saveblbutton').show();
            $('#updateblcustomer').hide();
            $('#myModalLabel334').html("Register Blacklist");
            $('#DefaultPrice').val("Retailer");
            $('#dprice').val("Retailer");
            $('#allowedcrsales').hide();
            $('.creditprop').hide();
            $('#IsAllowedCreditSales').val("");
            $('#CustomerCategory').val("Supplier");
            $('#creditlimitstart-error').html("");
            $('#creditlimitend-error').html("");
            $('#creditslimit-error').html("");
            $('#creditsalesadd-error').html("");
            $('#allowedcreditsales-error').html("");
            $('#allowedcreditsales-error').html("");
            $('#supplier').val(null).trigger('change');
        }

        //dropdown events starts
        $(function() {
            $('#CustomerCategory').change(function() {
                $('#cuscategory-error').html("");
                if ($(this).val() == "Customer") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#mrcDiv').show();
                    $('#vatDiv').show();
                    $('#withDiv').show();
                    $('#defpaymentDiv').show();
                    $('#mrc-error').html("");
                    $('#DefaultPrice').val("Retailer");
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                    $('#dprice').val("Retailer");
                    $('#allowedcrsales').show();
                } else if ($(this).val() == "Customer&Supplier") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').show();
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct-error').html("");
                    $('#withDiv').show();
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').show();
                    $('#defaultpayment-error').html("");
                    $('#DefaultPrice').val("Retailer");
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                    $('#allowedcrsales').show();
                    $('#dprice').val("Retailer");
                } else if ($(this).val() == "Supplier") {
                    $('#tinDiv').show();
                    $('#vatRegDiv').show();
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').show();
                    $('#vatDiv').hide();
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#defaultpayment-error').html("");
                    $('#DefaultPrice').val("");
                    $('#dprice').val("");
                    $('#allowedcrsales').hide();
                    $('#IsAllowedCreditSales').val("");
                    $('.creditprop').hide();
                } else if ($(this).val() == "Person") {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').show();
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#DefaultPrice').val("Retailer");
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#CreditLimitPeriod').val("0");
                    $('#CreditLimit').val("0");
                    $('#dprice').val("Retailer");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').show();
                    $('#IsAllowedCreditSales').val("");
                } else if ($(this).val() == "Foreigner-Supplier") {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#DefaultPayment').val("");
                    $('#DefaultPrice').val("");
                    $('#dprice').val("");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').hide();
                    $('#IsAllowedCreditSales').val("");
                    $('.creditprop').hide();
                } else {
                    $('#tinDiv').hide();
                    $('#TinNumber').val("");
                    $('#tin-error').html("");
                    $('#vatRegDiv').hide();
                    $('#VatNumber').val("");
                    $('#VatNumber-error').html("");
                    $('#mrcDiv').hide();
                    $('#MrcNumber').val("");
                    $('#mrc-error').html("");
                    $('#vatDiv').hide();
                    $('#VatDeduct').val("");
                    $('#VatDeduct-error').html("");
                    $('#withDiv').hide();
                    $('#WitholdDeduct').val("");
                    $('#WitholdDeduct-error').html("");
                    $('#defpaymentDiv').hide();
                    $('#creditLimitPeriodDiv').hide();
                    $('#creditLimitDiv').hide();
                    $('#DefaultPayment').val("");
                    $('#defaultpayment-error').html("");
                    $('#allowedcrsales').hide();
                    $('#IsAllowedCreditSales').val("");
                    $('.creditprop').hide();
                }
            });
        });

        $(function() {
            $('#ActiveStatus').change(function() {
                $('#status-error').html("");
                if ($(this).val() == "Inactive" || $(this).val() == "Block") {
                    $('#ReasonDiv').show();
                    $('#Reason-error').html("");
                } else {
                    $('#ReasonDiv').hide();
                    $('#Reason').val("");
                    $('#Reason-error').html("");
                }
            });
        });
        //dropdown events ends

        function tableReloadFn(flg) {
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
            var iTable = $('#customer-crud').dataTable(); 
            iTable.fnDraw(false);
            $('#customer-crud').DataTable().columns.adjust().draw();
        }

        //Reset Validation Starts
        function cusNameCV() {
            $('#name-error').html("");
            $('#mname-error').html("");
            $('#blname-error').html("");
        }

        function cusCodeCV() {
            var codeValue;
            codeValue = document.getElementById("Code").value.toUpperCase();
            document.getElementById("Code").value = codeValue;
            $('#id-error').html("");
            $('#blid-error').html("");
        }

        function cusCatCV() {
            $('#cuscategory-error').html("");
        }

        function cusVATCV() {
            $('#VatNumber-error').html("");
            $('#blVatNumber-error').html("");
        }

        function cusVATDedCV() {
            $('#VatDeduct-error').html("");
        }

        function cusWithDedCV() {
            $('#WitholdDeduct-error').html("");
        }

        function creditLimitPeriodVal() {
            $('#creditlimitperiod-error').html("");
        }

        function creditLimitVal() {
            $('#creditlimit-error').html("");
        }

        function cusDefPayCV() {
            $('#defaultpayment-error').html("");
            $('#dprice').val($('#DefaultPrice').val());
            var dprices = $('#DefaultPrice').val();
            if (dprices === "Wholeseller") {
                $('#creditLimitPeriodDiv').show();
                $('#creditLimitDiv').hide();
                $('#CreditLimitPeriod').val("180");
                $('#CreditLimit').val("50000");
            } else if (dprices === "Retailer") {
                $('#creditLimitPeriodDiv').hide();
                $('#creditLimitDiv').hide();
                $('#CreditLimitPeriod').val("0");
                $('#CreditLimit').val("0");
            }
            creditLimitVal();
            creditLimitPeriodVal();
        }

        function cusPhoneCV() {
            $('#PhoneNumber-error').html("");
            $('#blPhoneNumber-error').html("");
        }

        function cusOffPhoneCV() {
            $('#OfficePhoneNumber-error').html("");
            $('#blOfficePhoneNumber-error').html("");
        }

        function cusAddressv() {
            $('#Address-error').html("");
            $('#blAddress-error').html("");
        }

        function cusCountryVC() {
            $('#Country-error').html("");
            $('#blCountry-error').html("");
        }

        function cusMemoV() {
            $('#Memo-error').html("");
            $('#blMemo-error').html("");
        }

        function customerstatusCV() {
            $('#status-error').html("");
        }

        function cusReasonV() {
            $('#Reason-error').html("");
        }

        function removeMrcNameValidation() {
            $('#muname-error').html("");
        }

        function creditlimitstart() {
            $('#creditlimitstart-error').html("");
        }

        function creditlimitend() {
            $('#creditlimitend-error').html("");
            $("#unlimitcreditslcbx").prop("checked", false);     
            $('#unlimitflag').val('0');       
        }

        function creditslimitval() {
            $('#creditslimit-error').html("");
        }
        
        function creditsalesaddval() {
            $('#creditsalesadd-error').html("");
        }
        //Reset Validation Ends

        function adjustprop(ele){
            $("#name").prop("readonly", false);
            $("#TinNumber").prop("readonly", false);
            $("#MRCNumber").prop("readonly", false);
            $("#VatNumber").prop("readonly", false);
            $("#CustomerCategory option[value!=100]").show();
        }

        //Start Save records and new
        $('#savenewbutton').click(function() {
            var tinnum="";
            var cc = CustomerCategory.value;
            var ast = ActiveStatus.value;
            var tn = document.getElementById("tin-error").innerHTML;
            var mc = document.getElementById("mrc-error").innerHTML;
            var em = document.getElementById("email-error").innerHTML;
            var wb = document.getElementById("Website-error").innerHTML;
            if (((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") || (tn !=
                    "" || mc != "" || em != "" || wb != "")) {
                if ((ast == "Inactive" || ast == "Block") && document.getElementById("Reason").value == "") {
                    $('#Reason-error').html("Reason is required");
                }
                if (tn != "" || mc != "" || em != "" || wb != "") {
                    toastrMessage('error',"Check your inputs","Error");
                }
                toastrMessage('error',"Check your inputs","Error");
            } else {
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $('#name-error').html("");
                $('#id-error').html("");
                $('#cuscategory-error').html("");
                $('#tin-error').html("");
                $('#VatNumber-error').html("");
                $('#mrc-error').html("");
                $('#VatDeduct-error').html("");
                $('#WitholdDeduct-error').html("");
                $('#defaultpayment-error').html("");
                $('#PhoneNumber-error').html("");
                $('#OfficePhoneNumber-error').html("");
                $('#Address-error').html("");
                $('#Country-error').html("");
                $('#Memo-error').html("");
                $('#status-error').html("");
                $('#Reason-error').html("");
                $.ajax({
                    url: '/savecustomer',
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
                        $('#savenewbutton').text('Saving...');
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
                            if (data.errors.name) {
                                $('#name-error').html(data.errors.name[0]);
                            }
                            if (data.errors.CustomerId) {
                                $('#id-error').html(data.errors.CustomerId[0]);
                            }
                            if (data.errors.CustomerCategory) {
                                $('#cuscategory-error').html(data.errors.CustomerCategory[0]);
                            }
                            if (data.errors.DefaultPayment) {
                                $('#defaultpayment-error').html(data.errors.DefaultPayment[0]);
                            }
                            if (data.errors.TinNumber) {
                                var text=data.errors.TinNumber[0];
                                text = text.replace("customer category", "category");
                                $('#tin-error').html(text);
                            }
                            if (data.errors.VatNumber) {
                                $('#VatNumber-error').html(data.errors.VatNumber[0]);
                            }
                            if (data.errors.MrcNumber) {
                                var text=data.errors.MrcNumber[0];
                                text = text.replace("customer category", "category");
                                $('#mrc-error').html(text);
                            }
                            if (data.errors.VatDeduct) {
                                $('#VatDeduct-error').html(data.errors.VatDeduct[0]);
                            }
                            if (data.errors.WitholdDeduct) {
                                $('#WitholdDeduct-error').html(data.errors.WitholdDeduct[0]);
                            }
                            if (data.errors.CreditLimitPeriod) {
                                $('#creditlimitperiod-error').html(
                                    "The minimum period period field is required when default payment is Wholeseller."
                                );
                            }
                            if (data.errors.CreditLimit) {
                                $('#creditlimit-error').html(
                                    "The minimum purchase limit field is required when default payment is Wholeseller."
                                );
                            }
                            if (data.errors.PhoneNumber) {
                                var text=data.errors.PhoneNumber[0];
                                text = text.replace("is allowed credit sales", "credit sales");
                                $('#PhoneNumber-error').html(text);
                            }
                            if (data.errors.OfficePhoneNumber) {
                                $('#OfficePhoneNumber-error').html(data.errors.OfficePhoneNumber[0]);
                            }
                            if (data.errors.EmailAddress) {
                                $('#email-error').html(data.errors.EmailAddress[0]);
                            }
                            if (data.errors.Address) {
                                $('#Address-error').html(data.errors.Address[0]);
                            }
                            if (data.errors.Website) {
                                $('#Website-error').html(data.errors.Website[0]);
                            }
                            if (data.errors.Country) {
                                $('#Country-error').html(data.errors.Country[0]);
                            }
                            if (data.errors.Memo) {
                                $('#Memo-error').html(data.errors.Memo[0]);
                            }
                            if (data.errors.CustomerStatus) {
                                $('#status-error').html(data.errors.CustomerStatus[0]);
                            }
                            if (data.errors.Reason) {
                                $('#Reason-error').html(data.errors.Reason[0]);
                            }
                            if (data.errors.IsAllowedCreditSales) {
                                $('#allowedcreditsales-error').html("Credit sales field is required");
                            }
                            if (data.errors.CreditSalesLimitStart) {
                                var text=data.errors.CreditSalesLimitStart[0];
                                text = text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitstart-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitEnd) {
                                var text=data.errors.CreditSalesLimitEnd[0];
                                text = text.replace("credit sales limit end", "credit sales max amount");
                                text=text.replace("credit sales limit start", "credit sales min amount");
                                $('#creditlimitend-error').html(text);
                            }
                            if (data.errors.CreditSalesLimitDay) {
                                var text=data.errors.CreditSalesLimitDay[0];
                                text = text.replace("credit sales limit day", "credit sales payment term");
                                $('#creditslimit-error').html(text);
                            }
                            if (data.errors.CreditSalesAdditionPercentage) {
                                $('#creditsalesadd-error').html(data.errors.CreditSalesAdditionPercentage[0]);
                            }
                            $('#savenewbutton').text('Save');
                            toastrMessage('error',"Check your inputs","Error");
                        }
                        if (data.success) {
                            $('#savenewbutton').text('Save');
                            toastrMessage('success',"Successful","Success");
                            //$("#Register")[0].reset();
                            $('#savenewbutton').show();
                            $('#ReasonDiv').hide();
                            $('#defpaymentDiv').show();
                            $('#tinDiv').show();
                            $('#vatRegDiv').show();
                            $('#mrcDiv').show();
                            $('#vatDiv').show();
                            $('#withDiv').show();
                            $('#DefaultPrice').val("Retailer");
                            $('#dprice').val("Retailer");
                            $('#Country').val(null).trigger('change');
                            $.ajax({
                                url: '/getcustlastid',
                                type: 'POST',
                                data:{
                                    tinnum:$('#TinNumber').val(),
                                },
                                success: function(data) {
                                    $.each(data.customer, function(key, value) {
                                        $('#supplier').append("<option selected value='" + value.id + "'>" + value.Code+"    ,   " +value.Name+" ,   "+value.TinNumber+"</option>").trigger('change');
                                    });
                                }
                            });
                            $("#suppliermodal").modal('hide');
                        }
                    },
                });
            }
        });
        //End Save records and new

    </script>
@endsection
