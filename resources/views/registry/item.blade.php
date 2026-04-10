@extends('layout.app1')
@section('title')

@endsection

@section('content')

    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Items / Servicess</h3>
                            @can('Item-Add')
                                <button type="button" class="btn btn-gradient-info btn-sm addbutton" data-toggle="modal"
                                    data-target="" style='float: right;'>Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div class="table-responsive">
                                    @can('Item-View')
                                        <table id="laravel-datatable-crud"
                                            class="table table-bordered table-striped table-hover dt-responsive mb-0"
                                            style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Code</th>
                                                    <th>Type</th>
                                                    <th>SKU #</th>
                                                    <th>Name</th>
                                                    <th>Group</th>
                                                    <th>UOM</th>
                                                    <th>Category</th>
                                                    <th>Retail Price</th>
                                                    <th>Wholesale Price</th>
                                                    <th>Wholesale Minimum Quantity</th>
                                                    <th>Wholesale Maximum Quantity</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    @endcan
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!--Toast Start-->
    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert"
        style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!--Toast End-->


    {{-- //  item register modal-body --}}

    <div class="modal fade text-left" id="addItemForm" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel333">Register Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="RegisterItem" enctype="multipart/form-data" class="mt-2">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <!-- Input Mask start -->
                        <section id="input-mask-wrapper" class="quill-editor">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="withDiv">
                                            <label strong style="font-size: 14px;">Type </label>
                                            <input type="hidden" placeholder="Item ID" class="form-control" name="id"
                                                id="ids" />
                                            <input type="hidden" class="form-control" name="notifiablemaxcostid"
                                                id="notifiablemaxcostid" />
                                            <input type="hidden" class="form-control" name="notifiablereailerpriceid"
                                                id="notifiablereailerpriceid" />
                                            <input type="hidden" class="form-control" name="notifiablewholesellerpriceid"
                                                id="notifiablewholesellerpriceid" />
                                            <div class="input-group input-group-merge">
                                                <select class="invoiceto form-control" name="TypeId" id="TypeId"
                                                    onchange="changeType()">
                                                    <option value="Goods">Goods</option>
                                                    <option value="Service">Service</option>
                                                    <option value="Consumption">Consumption</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="type-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="GroupDiv">
                                            <label strong style="font-size: 14px;">Group </label>

                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="group" id="igroup">
                                                    <option value="Local">Local</option>
                                                    <option value="Imported">Imported</option>

                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="group-error"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="codeDiv">
                                            <label strong style="font-size: 14px;">Code</label>
                                            <input type="text" placeholder="Code" class="form-control" name="code"
                                                id="code" onkeyup="removeCodeValidation()"
                                                onkeypress="return ValidateCode(event);" />
                                            <span class="text-danger">
                                                <strong id="code-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="nameDiv">
                                            <label strong style="font-size: 14px;">Name</label>

                                            <input type="text" placeholder="Name" class="form-control" name="name"
                                                id="name" onkeypress="removeNameValidation()" autofocus />
                                            <span class="text-danger">
                                                <strong id="name-error"></strong>
                                            </span>
                                        </div>


                                        <div class="col-xl-1 col-md-6 col-sm-12 mb-2" id="uomDiv">
                                            <label strong style="font-size: 14px;">UOM</label>
                                            <div>
                                                <select class="selectpicker form-control" data-live-search="true"
                                                    data-style="btn btn-outline-secondary waves-effect" name="Uom" id="Uom"
                                                    onchange="uomValidation()">
                                                    <option value="" disabled selected></option>
                                                    @foreach ($uom as $um)
                                                        <option value="{{ $um->id }}">{{ $um->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="uom-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="categoryDiv">
                                            <label strong style="font-size: 14px;">Category</label>
                                            <div>
                                                <select class="selectpicker form-control" data-live-search="true"
                                                    data-style="btn btn-outline-secondary waves-effect" name="Category"
                                                    id="Category" onchange="categoryValidation()">
                                                    <option value="" disabled selected></option>
                                                    @foreach ($category as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->Name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="category-error"></strong>
                                            </span>
                                        </div>
                                        @can('Max-cost')
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="maxCostDiv">
                                                <label strong style="font-size: 14px;text-align:center;" id="maxcostlabel">Max
                                                    Cost</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" placeholder="Before VAT"
                                                        class="form-control" name="maxcostbv" id="maxcostbv"
                                                        onkeyup="copyMaxCostBv()" onkeypress="return ValidateNum(event);"
                                                        style="color:black;font-weight:bold; border-style:solid;" />
                                                    <input type="number" step="any" placeholder="After VAT"
                                                        class="form-control" name="maxcost" id="maxcost"
                                                        onkeyup="copyMaxCost()" onkeypress="return ValidateNum(event);" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="maxcost-error"></strong>
                                                </span>
                                            </div>
                                        @endcan
                                        @can('Price-update')
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="retailerDiv">
                                                <label strong style="font-size: 14px;" id="lblretailprice">Retail Price</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" placeholder="Before VAT"
                                                        class="form-control" name="retailPricebv" id="retailPricebv"
                                                        onkeyup="retailerPriceValidationbv()"
                                                        onkeypress="return ValidateNum(event);"
                                                        style="color:black;font-weight:bold; border-style:solid;" />
                                                    <input type="number" step="any" placeholder="After VAT"
                                                        class="form-control" name="retailPrice" id="retailPrice"
                                                        onkeyup="retailerPriceValidation()"
                                                        onkeypress="return ValidateNum(event);" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="retailPrice-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="wholesellerDiv">
                                                <label strong style="font-size: 14px;">Wholesale Price & Minimum
                                                    Quantity</label>
                                                <div class="input-group">
                                                    <input type="number" step="any" placeholder="Before VAT"
                                                        class="form-control" name="wholeSellerPricebv" id="wholeSellerPricebv"
                                                        onkeyup="wholesellerPriceValidationBv()"
                                                        onkeypress="return ValidateNum(event);"
                                                        style="color:black;font-weight:bold; border-style:solid;" />
                                                    <input type="number" step="any" placeholder="After VAT"
                                                        class="form-control" name="wholeSellerPrice" id="wholeSellerPrice"
                                                        onkeyup="wholesellerPriceValidation()"
                                                        onkeypress="return ValidateNum(event);" />
                                                    <input type="number" step="any" placeholder="Minimum Quantity"
                                                        class="form-control" name="wholeSellerMinAmount"
                                                        id="wholeSellerMinAmount" onkeyup="wholeSellerMinAmountValidation()"
                                                        onkeypress="return ValidateNum(event);" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="wholeSellerPrice-error"></strong>
                                                </span>
                                                <span class="text-danger">
                                                    <strong id="wholeSellerMinAmount-error"></strong>
                                                </span>
                                            </div>
                                            {{-- <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="wholesellerMinAmounDiv">
                                        <label strong style="font-size: 14px;">Wholesale MinQ</label>
                                        <input type="number" step="any" placeholder="Wholesale MinQ" class="form-control" name="wholeSellerMinAmount" id="wholeSellerMinAmount" onkeyup="wholeSellerMinAmountValidation()" onkeypress="return ValidateNum(event);"/>
                                        <span class="text-danger">
                                            <strong id="wholeSellerMinAmount-error"></strong>
                                        </span>
                                    </div> --}}
                                        @endcan
                                        @can('Store-Min-Quantity')
                                            <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="minimumstockdiv">
                                                <div class="input-group">
                                                    <label strong style="font-size: 14px;">Store Minimun Quantity </label>
                                                    <label id="availableqntlbl" strong style="font-size: 14px;"> | Available
                                                        Quantity</label>
                                                    <input type="number" step="any" placeholder="Store Minimum Quantity"
                                                        class="form-control" name="minimumstock" id="minimumstock"
                                                        onkeyup="minimumstockValidation()"
                                                        onkeypress="return ValidateNum(event);" style="width:55%;" />

                                                    <input type="number" step="any" placeholder="" class="form-control"
                                                        name="balance" id="balance" onkeyup="minimumstockValidation()"
                                                        onkeypress="return ValidateNum(event);" readonly="true"
                                                        style="width:45%;display:none;font-weight:bold;" />
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="minimumstock-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="lowStockDiv">
                                                <label strong style="font-size: 14px;">Reorder Value</label>
                                                <input type="number" placeholder="Value" class="form-control" name="lowStock"
                                                    id="lowStock" onkeyup="lowStockValidation()"
                                                    onkeypress="return ValidateNum(event);" />
                                                <span class="text-danger">
                                                    <strong id="lowStock-error"></strong>
                                                </span>
                                            </div>
                                        @endcan
                                        @can('Price-update')
                                            <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="taxtypeDiv">
                                                <label strong style="font-size: 14px;">Tax Type</label>
                                                <div>
                                                    <select class="invoiceto form-control" name="TaxType" id="TaxType"
                                                        onchange="taxTypeValidation()">
                                                        @foreach ($taxtypes as $tx)
                                                            <option value="{{ $tx->Value }}">{{ $tx->Name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="taxType-error"></strong>
                                                </span>
                                            </div>
                                        @endcan
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="serialNumDiv">
                                            <label strong style="font-size: 14px;"> Serial No</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="ReqSerialNumber"
                                                    id="ReqSerialNumber" onchange="reqSerialNumValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Require">Require</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="requireSerialNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="expireDateDiv">
                                            <label strong style="font-size: 14px;"> Expire Date </label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="ReqExpireDate"
                                                    id="ReqExpireDate" onchange="reqExpDateValidation()">
                                                    <option value="Not-Require">Not-Require</option>
                                                    <option value="Require-ExpireDate">Require-ExpireDate</option>
                                                    <option value="Require-BatchNumber">Require-BatchNumber</option>
                                                    <option value="Require-Both">Require-Both</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="requireExpireDate-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2" id="partNumDiv">
                                            <label strong style="font-size: 14px;">Part No</label>
                                            <input type="text" placeholder="PartNo" class="form-control" name="partNumber"
                                                id="partNumber" onkeypress="partNumberValidation()" />
                                            <span class="text-danger">
                                                <strong id="partNumber-error"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="statusDiv">
                                            <label strong style="font-size: 14px;">Status</label>
                                            <select class="invoiceto form-control" name="status" id="status"
                                                onchange="removeStatusValidation()">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="activeStatus-error"></strong>
                                            </span>
                                        </div>
                                        @php
                                            $sk = $setings->prefix . $setings->skunumber;
                                        @endphp

                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="skuNumberDiv">
                                            <label strong style="font-size: 14px;">SKU Number </label>
                                            <button type="button" class="btn btn-flat-success btn-sm" id="readBtn"
                                                onclick="ReadBarcode()">R</button>
                                            <button type="button" class="btn btn-flat-success btn-sm" id="generateBtn"
                                                onclick="GenerateBarcode()">G</button>
                                            <button type="button" class="btn btn-flat-danger btn-sm" id="closeGenBtn"
                                                onclick="closeBarcode()">C</button>
                                            <input type="hidden" class="form-control" name="skupdate" id="skupdate"
                                                value="" />
                                            {{-- <input type="text" class="form-control" name="skupdate" id="skupdate"/> --}}
                                            <input type="text" placeholder="SKU Number" class="form-control"
                                                name="skuNumber" id="skuNumber" onkeyup="removeSknumbervalidation()" />
                                            <input type="hidden" class="form-control" name="BarcodeTypes"
                                                id="BarcodeTypes" value="None" />
                                            {{-- <input type="text" class="form-control" name="skgenerate" id="skgenerate" value="{{$sk}}"/> --}}
                                            <input type="hidden" class="form-control" name="skgenerate" id="skgenerate" />
                                            <input type="hidden" class="form-control" name="lastbarcode" id="lastbarcode"
                                                value="" />
                                            <div id="barcodeDiv">
                                                <div style="" class="text-center">
                                                    <b><label id="barcodeCode"></label></b>
                                                </div>
                                                <!-- barcodec images -->
                                                <div id="barcodeimages" class="text-center">
                                                </div>
                                                <div class="form-check form-check-inline" id="printbardiv">
                                                    <label class="form-check-label" for="printbar">Print Barcode : </label>
                                                    <input class="form-check-input" name="printBar" type="checkbox"
                                                        id="printBar" />
                                                    <input type="hidden" class="form-control" name="checkboxVali"
                                                        id="checkboxVali" readonly />
                                                </div>

                                                <div style="padding-left: 20%">
                                                    <b><label id="barcodeNumberss"></label></b>
                                                    <b><label id="barcodeNumber"></label></b>
                                                </div>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="skuNumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="browseImageDiv">
                                            <label strong style="font-size: 14px;">Browse Image</label>
                                            <div id="kv-avatar-errors-1" class="center-block" style="display:none;">
                                            </div>
                                            <div class="kv-avatar center-block">
                                                <input type="file" id="user_image" name="item_image" class="form-control"
                                                    style="width:100%;" onchange="previewFile(this);" />

                                            </div>
                                            <span class="text-danger">
                                                <strong id="image-error"></strong>
                                            </span>

                                            <div class="col-xl-12 col-lg-12" id="imageload">
                                                <div class="card">

                                                    <div class="card-img-top" id="imageloads">



                                                    </div>

                                                </div>

                                            </div>
                                            <div class="col-xl-12 col-lg-12" id="imagepreview">
                                                <div class="card">

                                                    <div class="card-img-top" id="imagepreviews">

                                                        <img id="previewImg" src="" alt="" width="350" height="250">
                                                        <button type="button" id='imageresetbutton' class="close"
                                                            aria-label="Close" onclick="Hideimage()">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2" id="descriptionDiv">
                                            <label strong style="font-size: 14px;">Description </label>
                                            <div id="toolbar-container">
                                                <span class="ql-formats">
                                                    <select class="ql-font"></select>
                                                    <select class="ql-size"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-bold"></button>
                                                    <button class="ql-italic"></button>
                                                    <button class="ql-underline"></button>
                                                    <button class="ql-strike"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <select class="ql-color"></select>
                                                    <select class="ql-background"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-script" value="sub"></button>
                                                    <button class="ql-script" value="super"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-header" value="1"></button>
                                                    <button class="ql-header" value="2"></button>
                                                    <button class="ql-blockquote"></button>
                                                    <button class="ql-code-block"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-list" value="ordered"></button>
                                                    <button class="ql-list" value="bullet"></button>
                                                    <button class="ql-indent" value="-1"></button>
                                                    <button class="ql-indent" value="+1"></button>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-direction" value="rtl"></button>
                                                    <select class="ql-align"></select>
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-link"></button>
                                                    {{-- <button class="ql-image"></button> --}}
                                                    <button class="ql-video"></button>
                                                    {{-- <button class="ql-formula"></button> --}}
                                                </span>
                                                <span class="ql-formats">
                                                    <button class="ql-clean"></button>
                                                </span>
                                                <div id="editor-container"></div>
                                            </div>

                                            <textarea type="text" placeholder="Write Description here..."
                                                class="form-control" name="description" id="description"
                                                style="display:none;"></textarea>
                                            <span class="text-danger">
                                                <strong id="description-error"></strong>
                                            </span>
                                        </div>


                                    </div>
                                </div>
                        </section>



                    </div>


                    <div class="modal-footer">

                        <input type="hidden" placeholder="max cost" class="form-control" name="maxcosti" id="maxcosti" />
                        <button id="savebutton" type="submit" class="btn btn-info">Save</button>
                        <button id="closebutton1" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- end of item Register --}}


    <div class="modal fade text-left" id="deleteitem" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Item Delete </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="itemdeleteform">
                    @csrf
                    <div class="modal-body">
                        <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="id" class="form-control" name="did" id="did">
                            <span class="text-danger">
                                <strong id="uname-error"></strong>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletebtnitem" type="button" class="btn btn-info">Delete</button>
                        <button id="closebutton" type="button" class="btn btn-danger"
                            onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1"
        role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel334">Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="holdInfo">
                    @csrf
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-12" id="iteminfo">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Item Info</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-body" id="itemInfoCardDiv">
                                            <table>

                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Code: </label></td>
                                                    <td> <label id="itemcodeInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Type: </label></td>
                                                    <td> <label id="itemtypeInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Group: </label></td>
                                                    <td> <label id="itemgroupInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Item Name: </label></td>
                                                    <td> <label id="itemInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">UOM: </label></td>
                                                    <td> <label id="uomInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Category: </label></td>
                                                    <td> <label id="itemCategoryInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <!-- @can('Max-cost') -->
                                                    @if (auth()->user()->can('Max-cost') &&
            auth()->user()->can('Item-Edit-Imported'))
                                                        <tr id="importmaxcost">
                                                            <td><label strong style="font-size: 12px;">Max Cost: </label></td>
                                                            <td> <label id="maxcostInfoLbli" strong style="font-size: 12px;"
                                                                    class="badge badge-warning"></label></td>
                                                        </tr>
                                                    @endif

                                                    @if (auth()->user()->can('Max-cost'))
                                                        <tr id="localmaxcost">
                                                            <td><label strong style="font-size: 12px;">Max Cost: </label></td>
                                                            <td> <label id="maxcostInfoLbl" strong style="font-size: 12px;"
                                                                    class="badge badge-warning"></label></td>
                                                        </tr>
                                                    @endif
                                                <!-- @endcan -->
                                                @if (auth()->user()->can('Price-update'))
                                                    <tr>
                                                        <td><label strong style="font-size: 12px;">Retailer Price: </label>
                                                        </td>
                                                        <td> <label id="rpInfoLbl" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label></td>
                                                    </tr>
                                                @endif
                                                @if (auth()->user()->can('Price-update'))
                                                    <tr>
                                                        <td><label strong style="font-size: 12px;">Wholeseller Price:
                                                            </label></td>
                                                        <td> <label id="wsInfoLbl" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label></td>
                                                    </tr>
                                                @endif
                                                @if (auth()->user()->can('Price-update'))
                                                    <tr>
                                                        <td><label strong style="font-size: 12px;">Wholeseller Min Q:
                                                            </label></td>
                                                        <td> <label id="wsminInfoLbl" strong style="font-size: 12px;"
                                                                class="badge badge-warning"></label></td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Tax: </label></td>
                                                    <td> <label id="taxInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">SKU: </label></td>
                                                    <td> <label id="skuInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Reorder Value: </label></td>
                                                    <td> <label id="reorderInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label strong style="font-size: 12px;">Part Number: </label></td>
                                                    <td> <label id="partnumberInfoLbl" strong style="font-size: 12px;"
                                                            class="badge badge-warning"></label></td>
                                                </tr>
                                            </table>


                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-12" id="barcodeimage">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Barcode</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-body" id="itemInfoCardDiv">

                                            <div id="barcodeinfo" class="text-center">
                                                <b><label id="barcodeinfocode"></label></b>
                                                <div id="barcodeinfoimages">

                                                </div>
                                                <b><label id="barcodeskuNumber"></label></b>
                                            </div>
                                            <input type="hidden" name="printid" id="printid" />
                                            <button id="printbutton" type="button" class="btn btn-info">Print</button>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-xl-3 col-lg-12" id="productimage">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Item Image</h6>
                                            <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                        </div>
                                        <div class="card-img-top" id="imageloadss">

                                        </div>
                                        <div style="overflow-y:scroll;">
                                            <span id='imagedescription' class=""></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        let quill;
        quill = new Quill('#editor-container', {
            modules: {
                syntax: true,
                toolbar: '#toolbar-container'
            },
            placeholder: 'Write Description here..',
            theme: 'snow'
        });
        quill.on('text-change', function(delta, oldDelta, source) {
            $('#description').text($(".ql-editor").html());
        });
        //start checkbox change function
        $(function() {
            $("#printBar").click(function() {
                if ($(this).is(":checked")) {
                    $('#checkboxVali').val('1');

                } else {
                    $('#checkboxVali').val('0');
                }
            });
        });
        //end checkbox change function

        $(document).ready(function() {
            $("#skuNumber").attr("readonly", true);
            $("#barcodeDiv").hide();
            $("#imagepreview").hide();
            $(".selectpicker").selectpicker({
                noneSelectedText: ''
            });

            $('#laravel-datatable-crud').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
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
                    url: '/itemdata',
                    type: 'DELETE',
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data: 'Code',
                        name: 'Code'
                    },
                    {
                        data: 'Type',
                        name: 'Type',
                        'visible': false
                    },
                    {
                        data: 'SKUNumber', 
                        name: 'SKUNumber'
                    },
                    {
                        data: 'Name',
                        name: 'Name'
                    },
                    {
                        data: 'itemGroup',
                        name: 'itemGroup'
                    },
                    {
                        data: 'UOM',
                        name: 'UOM'
                    },
                    {
                        data: 'Category',
                        name: 'Category'
                    },
                    {
                        data: 'RetailerPrice',
                        name: 'RetailerPrice'
                    },
                    {
                        data: 'WholesellerPrice',
                        name: 'WholesellerPrice'
                    },
                    {
                        data: 'wholeSellerMinAmount',
                        name: 'wholeSellerMinAmount'
                    },
                    {
                        data: 'MinimumStock',
                        name: 'MinimumStock',
                    },
                    {
                        data: 'Balance',
                        name: 'Balance',
                        'visible': false
                    },
                     {
                        data: 'PendingQuantity',
                        name: 'PendingQuantity',
                        'visible': false
                    },
                    {
                        data: 'ActiveStatus',
                        name: 'ActiveStatus'
                    },

                    {
                        data: 'id',
                        name: 'id'
                    }
                ],
                 columnDefs: [{
                targets: 15,
                data: "",
                render: function ( data, type, row, meta ) {
                var itemeditlink='';
                var itedeletelink='';
                if(row.itemGroup=='Local'){
                    itemeditlink='@can("Item-Edit")<a class="dropdown-item editItem" href="javascript:void(0)" data-toggle="modal"  data-id="'+data+'" data-type="'+row.Type+'" data-original-title="Edit" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>@endcan';
                }
                if(row.itemGroup=='Imported'){
                    itemeditlink='@can("Item-Edit-Imported")<a class="dropdown-item editItem" href="javascript:void(0)" data-toggle="modal"  data-id="'+data+'" data-type="'+row.Type+'" data-original-title="Edit" title="Edit Record"><i class="fa fa-edit"></i><span> Edit</span></a>@endcan';
                }
                itedeletelink='<a class="dropdown-item deleteItem" data-id="'+data+'" data-status="" data-toggle="modal" id="smallButton"  data-attr="" title="Delete Record"><i class="fa fa-trash"></i><span> Delete</span></a>';
                var btn='<div class="btn-group dropleft">'+
                '<button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                    '<i class="fa fa-ellipsis-v"></i>'+
                '</button>'+
                '<div class="dropdown-menu">'+
                '<a class="dropdown-item showItem" data-id="'+data+'"  data-uom="'+row.UOM+'" data-category="'+row.Category+'"  data-toggle="modal" id="smallButton" data-target="#MRCRegModal" title="Show item info">'+
                      '<i class="fa fa-info"></i><span> Info</span>'+  
                  '</a>'+
                    itemeditlink+
                    itedeletelink+
                '</div>'+
            '</div>';
            return btn;
                }
            } ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.ActiveStatus == "Active") {
                        $(nRow).find('td:eq(10)').css({
                            "color": "#4CAF50",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #4CAF50"
                        });
                    } else if (aData.ActiveStatus == "Inactive") {
                        $(nRow).find('td:eq(10)').css({
                            "color": "#f44336",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #f44336"
                        });
                    }
                    if (aData.Balance<= aData.MinimumStock) {
                        $(nRow).find('td:eq(7)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                    }
                    if (aData.Balance == 0 || aData.Balance == null) {
                        $(nRow).find('td:eq(6)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                        $(nRow).find('td:eq(7)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                        $(nRow).find('td:eq(8)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                    }

                    if ((aData.Balance-aData.PendingQuantity-aData.MinimumStock)<0) {
                        $(nRow).find('td:eq(9)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                        $(nRow).find('td:eq(8)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                        $(nRow).find('td:eq(7)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                    }

                    if ((aData.Balance-aData.PendingQuantity)<aData.wholeSellerMinAmount) {
                        $(nRow).find('td:eq(9)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                        $(nRow).find('td:eq(8)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                        $(nRow).find('td:eq(7)').css({
                            "text-decoration": "line-through",
                            "text-decoration-color": "red"
                        });
                    }
                }
            });
        });

        $('body').on('click', '.addbutton', function() {

            $('#ids').val('');
            quill.clipboard.dangerouslyPasteHTML('');
            $('#notifiablemaxcostid').val('');
            $('#notifiablereailerpriceid').val('');
            $('#notifiablewholesellerpriceid').val('');
            $("#RegisterItem")[0].reset();
            $('#lblretailprice').html('Retail');
            $("#addItemForm").modal('show');
            $("#savebutton").show();
            $('#closeGenBtn').hide();
            $("#itemupdatebutton").hide();
            $('#barcodeNumberss').show();
            $('#barcodeNumber').hide();
            $("#previewImg").hide();
            $("#imageloads").hide();
            $("#barcodeDiv").hide();
            $("#imageresetbutton").hide();
            $("#balance").hide();
            $("#availableqntlbl").hide();
            $('#skuNumber').val('');
            $("#checkboxVali").val('0');

        });
        $('body').on('click', '.deleteItem', function() {
            $('#deleteitem').modal('show');
            var item_id = $(this).data('id');
            $('#did').val(item_id);

        });

        $('body').on('click', '.showItem', function() {

            var item_id = $(this).data('id');
            var uom = $(this).data('uom');
            var category = $(this).data('category');

            $("#printid").val(item_id);
            $('#Category').val(category);
            $('#Uom').val(uom);
            var myForm = $('#RegisterItem').find('input');


            $('#docInfoModal').modal('show');
            $('#s').hide(); // hide save buttoon
            $('#itemupdatebutton').hide(); // show update button
            $('#myModalLabel334').html("Item Information");
            $.get("/showitem" + '/' + item_id, function(data) {


                var len = data.length;

                for (var i = 0; i <= len; i++) {
                    $('#ids').val(data[i].id);
                    $('#itemtypeInfoLbl').text(data[i].Type);
                    $('#itemgroupInfoLbl').text(data[i].itemGroup);
                    $('#itemInfoLbl').text(data[i].Name);
                    $('#itemcodeInfoLbl').text(data[i].Code);
                    $('#itemCategoryInfoLbl').text(category);
                    $('#uomInfoLbl').text(uom);
                    $('#maxcostInfoLbli').text(data[i].MaxCost);
                    $('#maxcostInfoLbl').text(data[i].MaxCost);
                    $('#rpInfoLbl').text(data[i].RetailerPrice);
                    $('#wsInfoLbl').text(data[i].WholesellerPrice);
                    $('#wsminInfoLbl').text(data[i].wholeSellerMinAmount);
                    $('#taxInfoLbl').text(data[i].TaxTypeId);
                    $('#partnumberInfoLbl').text(data[i].PartNumber);
                    $('#reorderInfoLbl').text(data[i].LowStock);
                    $('#skuInfoLbl').text(data[i].SKUNumber);
                    $('#barcodeinfocode').text(data[i].Code);
                    var itemdescription = data[i].Description;
                    // var x=editor.setData(itemdescription);
                    $('#imagedescription').html(itemdescription);
                    var bt = data[i].BarcodeType;
                    var itemgrioup = data[i].itemGroup;
                    if (itemgrioup == "Local") {
                        $('#localmaxcost').show();
                        $('#importmaxcost').hide();
                    }
                    if (itemgrioup == "Imported") {
                        $('#localmaxcost').hide();
                        $('#importmaxcost').show();
                    }

                    if (bt == "Generate") {
                        $('#barcodeDiv').show();
                    } else {
                        $('#barcodeDiv').hide();
                    }
                }

            });
            $.get("/getimages" + '/' + item_id, function(data) {
                $("#imageloadss").html(data.uploaded_image);
                //  $("#barcodeinfoimages").html(data.uploaded_barcodeimage);


            });

            $.get("/getbarcodes" + '/' + item_id, function(data) {

                $("#barcodeinfoimages").html(data.uploaded_barcodeimage);
            });

        });

        $('body').on('click', '.editItem', function() {

            var item_id = $(this).data('id');
            var ItemType = $(this).data('type');

            var myForm = $('#RegisterItem').find('input');
            $(myForm).prop('disabled', false);
            $('#addItemForm').modal('show');
            $("#imagepreview").hide();
            $('#closeGenBtn').hide();
            $("#imageload").show();
            $("#imageloads").show();
            $("#savebutton").show(); // hide save buttoon
            $('#itemupdatebutton').show();
            $('#barcodeNumberss').hide();
            $('#barcodeNumber').show();
            $("#balance").show();
            $("#availableqntlbl").show();
            $("#checkboxVali").val('0');
            $('#myModalLabel333').html("Item Update");
            $.get("/itemedit" + '/' + item_id, function(data) {
                var len = data.length;
                for (var i = 0; i <= len; i++) {
                    $('#ids').val(data[i].id);
                    $('#name').val(data[i].Name);
                    $('#igroup').val(data[i].itemGroup);
                    $('#code').val(data[i].Code);
                    $('#Category').selectpicker('val', data[i].CategoryId);
                    $('#Uom').selectpicker('val', data[i].MeasurementId);
                    $('#retailPrice').val(data[i].RetailerPrice);
                    $('#wholeSellerPrice').val(data[i].WholesellerPrice);
                    $('#wholeSellerMinAmount').val(data[i].wholeSellerMinAmount);
                    $('#minimumstock').val(data[i].MinimumStock);
                    $('#TaxType').val(data[i].TaxTypeId);
                    $('#ReqSerialNumber').val(data[i].RequireSerialNumber);
                    $('#ReqExpireDate').val(data[i].RequireExpireDate);
                    $('#partNumber').val(data[i].PartNumber);
                    $('#lowStock').val(data[i].LowStock);
                    $('#skuNumber').val(data[i].SKUNumber);
                    $('#skuNumber').val(data[i].SKUNumber);
                    $('#maxcost').val(data[i].MaxCost);
                    $('#maxcosti').val(data[i].MaxCost);
                    $('#notifiablemaxcostid').val(data[i].MaxCost);
                    $('#notifiablereailerpriceid').val(data[i].RetailerPrice);
                    $('#notifiablewholesellerpriceid').val(data[i].WholesellerPrice);
                    $('#barcodeCode').html(data[i].Code);
                    $('#BarcodeTypes').val(data[i].BarcodeType);
                    $('#lastbarcode').val(data[i].id);
                    $('#status').val(data[i].ActiveStatus);
                    $('#balance').val(data[i].AvailableQuantity);
                    var retail = data[i].RetailerPrice;
                    var wholesell = data[i].WholesellerPrice;
                    var max = data[i].MaxCost;

                    var rresult = parseFloat(retail) / 1.15;
                    $('#retailPricebv').val(rresult.toString().match(/^\d+(?:\.\d{0,2})?/));

                    var wresult = parseFloat(wholesell) / 1.15;
                    $('#wholeSellerPricebv').val(wresult.toString().match(/^\d+(?:\.\d{0,2})?/));

                    var mresult = parseFloat(max) / 1.15;
                    $('#maxcostbv').val(mresult.toString().match(/^\d+(?:\.\d{0,2})?/));

                    var itemdescription = data[i].Description;
                    quill.clipboard.dangerouslyPasteHTML(itemdescription);
                    var bt = data[i].BarcodeType;
                    if (bt == "Generate") {
                        $('#barcodeDiv').show();
                        $('#BarcodeTypes').val(bt);
                    } else {
                        $('#barcodeDiv').hide();
                        $('#BarcodeTypes').val(bt);
                    }

                    if (ItemType == 'Service') {
                        //lblretailprice
                        $('#lblretailprice').html('Price');
                        $('#TypeId').val(data[i].Type);

                        $('#serialNumDiv').hide();
                        $('#expireDateDiv').hide();
                        $('#partNumDiv').hide();
                        $('#lowStockDiv').hide();
                        $('#skuNumberDiv').hide();
                        $('#browseImageDiv').hide();
                        $('#wholesellerDiv').hide();
                        $('#wholesellerMinAmounDiv').hide();
                        $("#ReqSerialNumber").val("Not-Require");
                        $("#ReqExpireDate").val("Not-Require");
                        $("#partNumber").val("");
                        $("#lowStock").val("");
                        $("#skuNumber").val("");
                        $('#requireSerialNumber-error').html("");
                        $('#requireExpireDate-error').html("");
                        $('#partNumber-error').html("");
                        $('#lowStock-error').html("");
                        $('#skuNumber-error').html("");
                    }

                    if (ItemType == 'Goods') {
                        $('#TypeId').val(data[i].Type);
                        $('#lblretailprice').html('Retail');
                        $('#nameDiv').show();
                        $('#codeDiv').show();
                        $('#categoryDiv').show();
                        $('#uomDiv').show();
                        $('#retailerDiv').show();
                        $('#wholesellerDiv').show();
                        $('#wholesellerMinAmounDiv').show();
                        $('#taxtypeDiv').show();
                        $('#serialNumDiv').show();
                        $('#expireDateDiv').show();
                        $('#partNumDiv').show();
                        $('#lowStockDiv').show();
                        $('#skuNumberDiv').show();
                        $('#browseImageDiv').show();
                        $('#statusDiv').show();
                        $('#descriptionDiv').show();

                    }

                    if (ItemType == 'Consumption') {
                        $('#TypeId').val(data[i].Type);
                        $('#retailerDiv').hide();
                        $('#wholesellerDiv').hide();
                        $('#wholesellerMinAmounDiv').hide();
                        $('#taxtypeDiv').hide();
                        $('#serialNumDiv').show();
                        $('#expireDateDiv').show();
                        $('#partNumDiv').show();
                        $('#lowStockDiv').show();
                        $('#skuNumberDiv').show();
                        $('#browseImageDiv').show();

                    }

                }

            });
            $.get("/getimages" + '/' + item_id, function(data) {
                $("#imageloads").html(data.uploaded_image);


            });
            $.get("/getbarcodes" + '/' + item_id, function(data) {

                $("#barcodeimages").html(data.uploaded_barcodeimage);
            });

            // $('#BarcodeTypes').val('None');
        });


        $('#printbutton').click(function() {
            var cid = document.forms['holdInfo'].elements['printid'].value;

            console.log('print id=' + cid);
            var link = '/printbarcodes/' + cid;

            window.open(link, 'Barcodes', 'width=1200,height=800,scrollbars=yes');

        });

        $('#deletebtnitem').click(function() {
            var cid = document.forms['itemdeleteform'].elements['did'].value;
            var registerForm = $("#itemdeleteform");
            var formData = registerForm.serialize();
            console.log('ccid==' + cid)
            $.ajax({
                url: '/itemdelete/' + cid,
                type: 'DELETE',
                data: formData,
                beforeSend: function() {
                    $('#deletebtnitem').text('Deleting Item...');
                },
                success: function(data) {
                    if (data.success) {
                        $("#myToast").toast('show');
                        $('#toast-massages').html(data.success);
                        $('#deletebtnitem').text('Delete');
                        $('.toast-body').css({
                            "background-color": "	#28a745",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                        $('#deleteitem').modal('hide');
                        $('#deletebtnconversion').text('Delete');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                    if (data.deleteErrors) {

                        $("#myToast").toast({
                            delay: 10000
                        });
                        $("#myToast").toast('show');
                        $('#toast-massages').html(
                            "This Item Can not be Deleted, There is data with these items on other tables"
                        );
                        $('#deletebtnitem').text('Delete');
                        $('.toast-body').css({
                            "background-color": "	#dc3545",
                            "color": "white",
                            "font-weight": "bold",
                            "font-size": "15px",
                            "border-radius": "15px"
                        });
                        // $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
                        $('#deleteitem').modal('hide');
                        $('#deletebtnconversion').text('Delete');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);

                    }
                }
            })

        });



        $('#RegisterItem').submit(function(e) {
            e.preventDefault();
            var wholesalVal = parseFloat($('#wholeSellerPrice').val());
            var wholesalMinVal = parseFloat($('#wholeSellerMinAmount').val());
            var maxCostVal = parseFloat($('#maxcosti').val());
            var retailval = parseFloat($('#retailPrice').val());


            if (parseFloat($('#retailPrice').val()) < parseInt($('#wholeSellerPrice').val()))
            // if(14<8)
            {
                $('#retailPrice-error').html("Invalid input");
                $('#wholeSellerPrice-error').html("Invalid input");
                $("#myToast").toast({
                    delay: 10000
                });
                $("#myToast").toast('show');
                $('#toast-massages').html("Retailer price is greather than wholeseller price");
                $('.toast-body').css({
                    "background-color": "	#dc3545",
                    "color": "white",
                    "font-weight": "bold",
                    "font-size": "15px",
                    "border-radius": "15px"
                });
            } else if ((wholesalVal == '') && (wholesalMinVal != '')) {
                $('#wholeSellerMinAmount-error').html("Please Enter Whole Sale Price First");

            } else if ((maxCostVal != '') && (wholesalVal < maxCostVal || retailval < maxCostVal)) {
                $("#myToast").toast({
                    delay: 10000
                });
                $("#myToast").toast('show');
                $('#toast-massages').html("Invalid Inputs");
                $('.toast-body').css({
                    "background-color": "	#dc3545",
                    "color": "white",
                    "font-weight": "bold",
                    "font-size": "15px",
                    "border-radius": "15px"
                });

            } else {
                console.log('save is clicked');
                let formData = new FormData(this);

                $.ajax({
                    url: '/saveitems',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#savebutton').text('saving item..');
                        $('#savebutton').prop("disabled", true);

                    },
                    success: function(data) {

                        if (data.success) {
                            $('#savebutton').prop("disabled", false);
                            $('#savebutton').text('Save');
                            $("#myToast").toast({
                                delay: 4000
                            });
                            $("#myToast").toast('show');
                            $('#toast-massages').html("Item Saved Successfully");
                            $('.toast-body').css({
                                "background-color": "  #28a745",
                                "color": "white",
                                "font-weight": "bold",
                                "font-size": "15px",
                                "border-radius": "15px"
                            });
                            $("#addItemForm").modal('hide');
                            $("#RegisterItem")[0].reset();
                            //$("#RegisterItem")[0].reset();
                            $('#Category').val(null).trigger('change');
                            $('#Uom').val(null).trigger('change');
                            var oTable = $('#laravel-datatable-crud').dataTable();
                            oTable.fnDraw(false);
                            closeModalWithClearValidation();

                            //var cval="0"; 
                            var cval = $("#checkboxVali").val();
                            // alert(cval);    
                            if (cval == 1) {
                                //var recid= data.receivingId;

                                var len = data.latest.length;
                                for (var i = 0; i <= len; i++) {
                                    // console.log('last id='+data.latest[i].id);
                                    var itemid = data.latest[i].id;
                                    var link = "/printbarcodes/" + itemid;
                                    window.open(link, 'Print Barcode',
                                        'width=1200,height=800,scrollbars=yes');
                                }



                            }

                        }
                        if (data.errors) {
                            $('#savebutton').text('Save');
                            if (data.errors.name) {
                                $('#name-error').html(data.errors.name[0]);
                            }
                            if (data.errors.code) {
                                $('#code-error').html(data.errors.code[0]);
                            }
                            if (data.errors.Category) {
                                $('#category-error').html(data.errors.Category[0]);
                            }
                            if (data.errors.Uom) {
                                $('#uom-error').html(data.errors.Uom[0]);
                            }
                            if (data.errors.skuNumber) {
                                $('#skuNumber-error').html(data.errors.skuNumber[0]);
                            }
                            if (data.errors.item_image) {
                                $('#image-error').html(data.errors.item_image[0]);
                                //image-error
                            }
                            if (data.errors.wholeSellerPrice) {
                                $('#wholeSellerPrice-error').html(data.errors.wholeSellerPrice[0]);
                            }
                            if (data.errors.wholeSellerMinAmount) {
                                $('#wholeSellerMinAmount-error').html(data.errors.wholeSellerMinAmount[
                                    0]);
                            }
                            $('#savebutton').prop("disabled", false);
                            $('#savebutton').text('Save');
                            $("#myToast").toast({
                                delay: 10000
                            });
                            $("#myToast").toast('show');
                            $('#toast-massages').html("Check Your Inputs");
                            $('.toast-body').css({
                                "background-color": "	#dc3545",
                                "color": "white",
                                "font-weight": "bold",
                                "font-size": "15px",
                                "border-radius": "15px"
                            });

                        }
                    },

                });

            }

        });







        function copyMaxCost() {
            var mx = $('#maxcost').val();
            $('#maxcosti').val(mx);
            var max = $('#maxcost').val();
            var result = parseFloat(max) / 1.15;
            $('#maxcostbv').val(result.toFixed(2));
        }

        function copyMaxCostBv() {
            var maxc = $('#maxcostbv').val();
            var result = parseFloat(maxc) * 1.15;
            $('#maxcost').val(result.toFixed(2));
            $('#maxcosti').val(result.toFixed(2));
        }
        //Start removing error validation


        function removeNameValidation() {
            $('#name-error').html("");
        }

        function removeCodeValidation() {
            $('#code-error').html("");
            var code = $('#code').val();
            $('#barcodeCode').html(code);
        }

        function categoryValidation() {
            $('#category-error').html("");
        }

        function uomValidation() {
            $('#uom-error').html("");
        }

        function retailerPriceValidation() {
            $('#retailPrice-error').html("");
            var retail = $('#retailPrice').val();
            var result = parseFloat(retail) / 1.15;
            $('#retailPricebv').val(result.toFixed(2));
        }

        function retailerPriceValidationbv() {
            var retail = $('#retailPricebv').val();
            var result = parseFloat(retail) * 1.15;
            $('#retailPrice').val(result.toFixed(2));
        }

        function wholesellerPriceValidation() {
            $('#wholeSellerPrice-error').html("");
            var wholesell = $('#wholeSellerPrice').val();
            var result = parseFloat(wholesell) / 1.15;
            $('#wholeSellerPricebv').val(result.toFixed(2));
        }

        function wholesellerPriceValidationBv() {
            var wholesell = $('#wholeSellerPricebv').val();
            var result = parseFloat(wholesell) * 1.15;
            $('#wholeSellerPrice').val(result.toFixed(2));
        }

        function wholeSellerMinAmountValidation() {
            $('#wholeSellerMinAmount-error').html("");
        }

        function taxTypeValidation() {
            $('#taxType-error').html("");
        }

        function reqSerialNumValidation() {
            $('#requireSerialNumber-error').html("");
        }

        function reqExpDateValidation() {
            $('#requireExpireDate-error').html("");
        }

        function partNumberValidation() {
            $('#partNumber-error').html("");
        }

        function lowStockValidation() {
            $('#lowStock-error').html("");
        }

        function skuValidation() {
            $('#skuNumber-error').html("");
        }

        function removeStatusValidation() {
            $('#activeStatus-error').html("");
        }

        function removeSknumbervalidation() {
            $('#skuNumber-error').html("");
        }

        function descriptionValidation() {
            $('#description-error').html("");
        }
        // end of show items

        //Start dropdown features
        $(function() {
            $('#TypeId').change(function() {
                $('#type-error').html("");
                if ($(this).val() == "Goods") {
                    $('#lblretailprice').html('Retail');
                    $('#retailPrice').val('');
                    $('#nameDiv').show();
                    $('#codeDiv').show();
                    $('#categoryDiv').show();
                    $('#uomDiv').show();
                    $('#retailerDiv').show();
                    $('#wholesellerDiv').show();
                    $('#wholesellerMinAmounDiv').show();
                    $('#taxtypeDiv').show();
                    $('#serialNumDiv').show();
                    $('#expireDateDiv').show();
                    $('#partNumDiv').show();
                    $('#lowStockDiv').show();
                    $('#skuNumberDiv').show();
                    $('#browseImageDiv').show();
                    $('#statusDiv').show();
                    $('#descriptionDiv').show();
                } else if ($(this).val() == "Consumption") {
                    $('#retailPrice').val('');
                    $('#wholeSellerPrice').val('');
                    $('#retailerDiv').hide();
                    $('#wholesellerDiv').hide();
                    $('#wholesellerMinAmounDiv').hide();
                    $('#taxtypeDiv').hide();
                    $('#serialNumDiv').show();
                    $('#expireDateDiv').show();
                    $('#partNumDiv').show();
                    $('#lowStockDiv').show();
                    $('#skuNumberDiv').show();
                    $('#browseImageDiv').show();
                    $('#barcodeDiv').hide();
                    $('#generateBtn').show();
                    $('#readBtn').show();
                    $('#closeGenBtn').hide();

                } else {
                    $('#lblretailprice').html('Price');
                    $('#retailerDiv').show();
                    $('#wholesellerDiv').hide();
                    $('#wholesellerMinAmounDiv').hide();
                    $('#serialNumDiv').hide();
                    $('#expireDateDiv').hide();
                    $('#partNumDiv').hide();
                    $('#lowStockDiv').hide();
                    $('#skuNumberDiv').hide();
                    $('#browseImageDiv').hide();
                    $("#ReqSerialNumber").val("Not-Require");
                    $("#ReqExpireDate").val("Not-Require");
                    $("#partNumber").val("");
                    $("#lowStock").val("");
                    $("#skuNumber").val("");
                    $('#requireSerialNumber-error').html("");
                    $('#requireExpireDate-error').html("");
                    $('#partNumber-error').html("");
                    $('#lowStock-error').html("");
                    $('#skuNumber-error').html("");
                }
            });
        });
        //End dropdown features

        //Start Close modal with clear validations
        function closeModalWithClearValidation() {
            $("#RegisterItem")[0].reset();
            $('#previewImg').hide(); //hide preview image box
            $('#nameDiv').show();
            $('#codeDiv').show();
            $('#categoryDiv').show();
            $('#uomDiv').show();
            $('#retailerDiv').show();
            $('#wholesellerDiv').show();
            $('#wholesellerMinAmounDiv').show();
            $('#taxtypeDiv').show();
            $('#serialNumDiv').show();
            $('#expireDateDiv').show();
            $('#partNumDiv').show();
            $('#lowStockDiv').show();
            $('#skuNumberDiv').show();
            $('#browseImageDiv').show();
            $('#statusDiv').show();
            $('#descriptionDiv').show();
            $('#Category').val(null).trigger('change');
            $('#Uom').val(null).trigger('change');
            $('#name-error').html("");
            $('#code-error').html("");
            $('#category-error').html("");
            $('#uom-error').html("");
            $('#retailPrice-error').html("");
            $('#wholeSellerPrice-error').html("");
            $('#wholeSellerMinAmount-error').html("");
            $('#taxType-error').html("");
            $('#requireSerialNumber-error').html("");
            $('#requireExpireDate-error').html("");
            $('#partNumber-error').html("");
            $('#lowStock-error').html("");
            $('#skuNumber-error').html("");
            $('#activeStatus-error').html("");
            $('#description-error').html("");
            $('#image-error').html("");
            $('#barcodeDiv').hide();
            $("#skuNumber").attr("readonly", true); //disable sku number
            $('#BarcodeTypes').val("None");
            $('#closeGenBtn').hide();
            $('#generateBtn').show();
            $('#readBtn').show();
            $('#savebutton').prop("disabled", false);
            $('#savebutton').text('Save');
            $("#balance").hide();
            $("#availableqntlbl").hide();
            $('#retailPricebv').val("");
            $('#wholeSellerPricebv').val("");
            $('#maxcostbv').val("");
        }
        //End Close modal with clear validations

        //Start Generate barcode
        function GenerateBarcode() {
            $("#skuNumber").attr("readonly", true); //enable sku number
            $('#skuNumber-error').html("");
            if ($('#code').val().length === 0) {
                $('#code-error').html("Code is required");
                $("#myToast").toast({
                    delay: 10000
                });
                $("#myToast").toast('show');
                $('#toast-massages').html("Code is required");
                $('.toast-body').css({
                    "background-color": "	#dc3545",
                    "color": "white",
                    "font-weight": "bold",
                    "font-size": "15px",
                    "border-radius": "15px"
                });
            } else {

                $('#BarcodeTypes').val("Generate");

                $.get("/getsknumber", function(data) {
                    $("#skupdate").val(data.setting.skunumber);
                    $("#skuNumber").val(data.setting.prefix + data.numberpaddging + data.padded);
                    // $("#barcodeNumberss").html(data.setting.prefix+data.numberpaddging);

                });
                var skupdate = $("#skupdate").val();
                $.get("/getgeneratebarcode", function(data) {
                    $("#barcodeimages").html(data.generated_barcodeimage);
                });
                var barCodeCodeTxt = $("#code");
                var barCodeCodeLbl = $("#barcodeCode");
                $('#closeGenBtn').show();
                $('#generateBtn').hide();
                $('#readBtn').hide();
                barCodeCodeLbl.html(barCodeCodeTxt.val());
                $("#barcodeDiv").show();
            }

        }
        //End Generate barcode

        //Start Read barcode
        function ReadBarcode() {
            $("#skuNumber").val('');
            $("#skuNumber").focus();
            $('#barcodeDiv').hide();
            $("#skuNumber").attr("readonly", false); //enable sku number
            $('#BarcodeTypes').val("Read");
            $('#closeGenBtn').show();
            $('#generateBtn').hide();
            $('#readBtn').hide();
        }
        //End read barcode

        //Start barcode close
        function closeBarcode() {
            $('#barcodeDiv').hide();
            $("#skuNumber").attr("readonly", true); //disable sku number
            $('#BarcodeTypes').val("None");
            $('#closeGenBtn').hide();
            $('#generateBtn').show();
            $('#readBtn').show();
            $("#skuNumber").val('');
        }
        //End barcode close

        //Start Image preview 
        function previewFile(input) {

            var file = $("input[type=file]").get(0).files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
                $("#imagepreview").show();
                $("#imageresetbutton").show();
                $("#imageload").hide();
                $('#previewImg').show();
                $('#image-error').html('');
            }
        }
        //End Image preview

        function PrintDiv() {
            var contents = document.getElementById("barcodeinfo").innerHTML;
            var frame1 = document.createElement('iframe');
            frame1.name = "frame1";
            frame1.style.position = "absolute";
            frame1.style.top = "-1000000px";
            document.body.appendChild(frame1);
            var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1
                .contentDocument.document : frame1.contentDocument;
            frameDoc.document.open();
            frameDoc.document.write('<html><head><title>DIV Contents</title>');
            frameDoc.document.write('</head><body>');
            frameDoc.document.write(contents);
            frameDoc.document.write('</body></html>');
            frameDoc.document.close();
            setTimeout(function() {
                window.frames["frame1"].focus();
                window.frames["frame1"].print();
                document.body.removeChild(frame1);
            }, 500);
            return false;
        }

        function Hideimage() {
            $("#imagepreview").hide();
            $("#imageresetbutton").hide();
            $("#user_image").val('');
            //user_image
        }

        function minimumstockValidation() {
            var minstock = $("#minimumstock").val();
            if (parseFloat(minstock) == 0) {
                $("#minimumstock").val("");
            }
        }
    </script>

@endsection
