@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('Store-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">Store / Shop</h3>
                        @can('Store-Add')
                        <button type="button" class="btn btn-gradient-info btn-sm addstorebutton" data-toggle="modal" >Add</button>
                        @endcan
                    </div>
                    <div class="card-datatable">
                        <div style="width:98%; margin-left:1%;">
                            <div>
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Id</th>
                                            <th>Type</th>
                                            <th>Name</th>
                                            <th style="width: 30%;">MRC</th>
                                            <th>Address</th>
                                            <th>Credit Sales</th>
                                            <th>Status</th>
                                            <th style="width: 7%;">Action</th>
                                        </tr>
                                    </thead>
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

    <!--Toast Start-->
    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert" style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!--Toast End-->


<!--Registration Modal -->
<div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Register Store / Shop</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Register">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class=row>
                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1" >
                            <label strong style="font-size: 16px;">Type <b style="color:red;">*</b></label>
                            <div class="form-group">
                                <input type="hidden" placeholder="storeid" class="form-control" name="storeid" id="storeid">
                                <select class="select2 form-control something" name="type" id="type" data-placeholder="Select Type" autofocus>
                                </select>
                                <span class="text-danger">
                                    <strong id="type-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1" >
                            <label strong style="font-size: 16px;">Name <b style="color:red;">*</b></label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Name" class="form-control" name="name" id="name" onkeypress="removeNameValidation()" />
                                <span class="text-danger">
                                    <strong id="name-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                            <label strong style="font-size: 16px;">Address</label>
                            <div class="form-group">
                                <input type="text" placeholder="Enter Address" class="form-control" name="address" id="address" onkeypress="removePlaceValidation()"/>
                                <span class="text-danger">
                                    <strong id="place-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1" id="allowcrsales" style="display: none;">
                            <label strong style="font-size: 16px;">Credit Sales <b style="color:red;">*</b></label>
                            <div class="form-group">
                                <select class="select2 form-control" name="IsAllowedCreditSales" id="IsAllowedCreditSales" data-placeholder="Allow or Not-Allow" onchange="alowcreditsales()">
                                    <option value=""></option>
                                    <option value="Allow">Allow</option>
                                    <option value="Not-Allow">Not-Allow</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="allowcreditsales-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                            <label strong style="font-size: 16px;">Status <b style="color:red;">*</b></label>
                            <div class="form-group">
                                <select class="form-control" name="status" id="status" onchange="removeStatusValidation()">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="status-error"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" placeholder="" class="form-control" name="usernamehidden" id="usernamehidden" readonly="true"/> 
                    <input type="hidden" placeholder="" class="form-control" name="createddatehidden" id="createddatehidden" readonly="true"/> 
                    @can('Store-Add')
                    <button id="savenewbutton" type="button" class="btn btn-info">Save & New</button>
                    <button id="savebutton" type="button" class="btn btn-info">Save & Close</button>
                    @endcan
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Registation Modal -->

<!--- Start Update Modal -->
<div class="modal fade text-left" id="examplemodal-edit" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Edit Strore Informatoin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateregisterform">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Name</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="id" id="id">
                        <input type="text" placeholder="Store Name" class="form-control" name="name" id="name" onkeypress="removeNameValidation()"/>
                        <span class="text-danger">
                            <strong id="uname-error"></strong>
                        </span>
                    </div>
                    <label strong style="font-size: 16px;">Address</label>
                    <div class="form-group">
                        <input type="text" placeholder="Store Address" class="form-control" name="place" id="place" onkeypress="removePlaceValidation()"/>
                        <span class="text-danger">
                            <strong id="uplace-error"></strong>
                        </span>
                    </div>
                    <label strong style="font-size: 16px;">Status</label>
                    <div class="form-group">
                    <div class="invoice-customer">
                        <select class="invoiceto form-control" name="status" id="status" onchange="removeStatusValidation()">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <span class="text-danger">
                            <strong id="ustatus-error"></strong>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('Store-Edit')
                    <button id="updatebutton1" type="button" class="btn btn-info">Update</button>
                    @endcan
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---End Update Modal -->

<!--Start Delete modal -->
<div class="modal fade text-left" id="examplemodal-delete" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="deletform" >
                @csrf
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="id" id="did">
                        <span class="text-danger">
                            <strong id="uname-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deletebtn" type="button" class="btn btn-info">Delete</button>
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->

<!--Location Registration Modal -->
<div class="modal fade text-left" id="mrcmodalform" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel3356">Register MRC  <strong id="st-name"></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ClearmrcValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card-body">
                        <!-- Accordion with margin start -->
                        <section id="accordion-with-margin">
                            <form id="mrcform">
                                {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card collapse-icon">
                                        <div class="card-body">
                                            <div class="collapse-margin" id="accordionExample">
                                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" onclick="addLocation()" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        <span class="lead collapse-title" onclick="addLocation()"> Add MRC </span>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;">MRC <b style="color:red;">*</b></label>
                                                                    <input type="hidden" name="mrcstoreid" id="mrcstoreid" class="form-control">
                                                                    <input type="hidden" name="mrcid" id="mrcid" class="form-control">
                                                                    <input type="text"  placeholder="MRC No" class="form-control" name="mrcNumber" id="mrcNumber" oninput="this.value = this.value.toUpperCase()" maxlength="10" onclick="removemrcValidation()" />
                                                                    <span class="text-danger">
                                                                        <strong id="mrcNumber-error"></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="">
                                                                    <label>Cash Prefix <b style="color:red;">*</b></label>
                                                                    <input type="text"  placeholder="Csh Prefix" class="form-control" name="cashPrefix" id="cashPrefix" oninput="this.value = this.value.toUpperCase()"  onclick="removecashprefixValidation()" />
                                                                        
                                                                            <span class="text-danger">
                                                                                <strong id="cashPrefix-error"></strong>
                                                                            </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="">
                                                                    <label>Credit Prefix <b style="color:red;">*</b></label>
                                                                    <input type="text"  placeholder="Credit Prefix" class="form-control" name="creditPrefix" id="creditPrefix" oninput="this.value = this.value.toUpperCase()"  onclick="removecreditprefixValidation()" />
                                                                        
                                                                            <span class="text-danger">
                                                                                <strong id="creditPrefix-error"></strong>
                                                                            </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="divfiscalvoid">
                                                                    <label>Cancel Type <b style="color:red;">*</b></label>
                                                                    <select class="selectpicker form-control" name="fiscalVoidType" id="fiscalVoidType" title="Select type" data-live-search="true" data-style="btn btn-outline-secondary waves-effect">
                                                                        <option value="1">Fs #</option>
                                                                        <option value="2">Invoice #</option>
                                                                    </select>
                                                                        
                                                                            <span class="text-danger">
                                                                                <strong id="fiscalVoidType-error"></strong>
                                                                            </span>
                                                                </div>
                                                                <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;">Status <b style="color:red;">*</b></label>
                                                                    <div class="invoice-customer">
                                                                        <select class="form-control" name="status" id="mrcstatus"  onchange="statusmrcremoveValidation()">
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>
                                                                        </select>
                                                                        <span class="text-danger">
                                                                            <strong id="status-error"></strong>
                                                                        </span>
                                                                        </div>
                                                                </div>
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;"></label>
                                                                    <div>
                                                                    
                                                                        <button type="button" id="savemrcNumberbutton" class="btn btn-info waves-effect waves-float waves-light">
                                                                            <span id="loadid"></span>
                                                                            <span id="saveid">Add</span>
                                                                        
                                                                        </button>
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
                        </form>
                        </section>
                        <!-- Accordion with margin end -->
                </div>
                <div style="width:98%; margin-left:1%;" id="card-block">
                    <table id="mrclistable" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width:100%">
                    <thead>
                        <tr><th>#</th>
                            <th>Id</th>
                            <th>MRC No</th>
                            <th>Cash Prefix</th>
                            <th>Credit Prefix</th>
                            <th>Cancel Type</th>
                            <th>Status</th>

                            <th style="width: 25%">Action</th>
                        </tr>
                    </thead>
                </table>
                </div>
                </div>

                <div class="modal-footer">
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>

        </div>
    </div>
</div>

<!--Location Registration Modal -->
<div class="modal fade text-left" id="locationForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel3356">Register Location  <strong id="st-name"></strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="LocationRegister">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="card-body">
                        <!-- Accordion with margin start -->
                        <section id="accordion-with-margin">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card collapse-icon">
                                        <div class="card-body">
                                            <div class="collapse-margin" id="accordionExample">
                                                    <div class="card-header" id="headingOne" data-toggle="collapse" role="button" onclick="addLocation()" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        <span class="lead collapse-title" onclick="addLocation()"> Add Location </span>
                                                    </div>
                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;">Name</label>
                                                                    <input type="hidden" id="storeid" class="form-control" name="storeid"/>
                                                                    <input type="text" id="lname" placeholder="Location Name" class="form-control" name="name" onkeypress="removeNameValidation()" autofocus/>
                                                                    <span class="text-danger">
                                                                        <strong id="lname-error"></strong>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;">Status</label>
                                                                    <div class="invoice-customer">
                                                                        <select class="invoiceto form-control" name="status" id="lstatus" onchange="removeStatusValidation()">
                                                                            <option value="Active">Active</option>
                                                                            <option value="Inactive">Inactive</option>
                                                                        </select>
                                                                        <span class="text-danger">
                                                                            <strong id="lstatus-error"></strong>
                                                                        </span>
                                                                        </div>
                                                                </div>
                                                                <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                                    <label strong style="font-size: 16px;"></label>
                                                                    <div>
                                                                        <button id="savelocationbtn" type="button" class="btn btn-info">Add Location</button>
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
                        <!-- Accordion with margin end -->
                </div>
                <div style="width:98%; margin-left:1%;">
                <table id="laravel-datatable-crud-location" class="table table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>StoreId</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th style="width: 20%;">Action</th>
                        </tr>
                    </thead>
                </table>
                </div>
                </div>

                <div class="modal-footer">
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Location Registation Modal -->

<!--- Start Location Update Modal -->
<div class="modal fade text-left" id="examplemodal-locedit" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Edit Location Informatoin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeLocEditModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updatelocform">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Name</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="id" id="id">
                        <input type="hidden" placeholder="id" class="form-control" name="sid" id="sid">
                        <input type="text" placeholder="Location Name" class="form-control" name="name" id="name" onkeypress="removeLocNameValidation()"/>
                        <span class="text-danger">
                            <strong id="luname-error"></strong>
                        </span>
                    </div>
                    <label strong style="font-size: 16px;">Status</label>
                    <div class="form-group">
                        <div class="invoice-customer">
                        <select class="form-control" name="status" id="status" onchange="removeLocStatusValidation()">
                            <option value="" disabled selected>Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <span class="text-danger">
                            <strong id="lustatus-error"></strong>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="updatelocbutton" type="button" class="btn btn-info">Update</button>
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeLocEditModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!---End Location Update Modal -->

<!--Start Location Delete modal -->
<div class="modal fade text-left" id="examplemodal-locdelete" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="deletelocform" >
                @csrf
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Are you sure you want to delete</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="id" id="did">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deletelocbtn" type="button" class="btn btn-info">Delete</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Location Delete Modal -->

<!--Begin of wrap up customer Modal -->
<div class="modal fade" id="mrcmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel333">Add MRC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ClearmrcValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

        </div>
    </div>
</div>
<!--End wrap up customer Modal -->

<div class="modal fade text-left" id="storeinfomodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel35"> Store / Shop Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="storeform">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 35%;"><label style="font-size: 14px;">Type</label></td>
                                    <td style="width: 65%;"><label id="typeinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label style="font-size: 14px;">Name</label></td>
                                    <td><label id="storenameinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label style="font-size: 14px;">Address</label></td>
                                    <td><label id="addressinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label style="font-size: 14px;">Credit Sales</label></td>
                                    <td><label id="creditsalesinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label style="font-size: 14px;">Status</label></td>
                                    <td><label id="statusinfo" style="font-size: 14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="divider newext">
                                            <div class="divider-text">Action Information</div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label strong style="font-size: 14px;">Created By</label></td>
                                    <td><label id="createdbylbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label strong style="font-size: 14px;">Created Date</label></td>
                                    <td><label id="createddatelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label strong style="font-size: 14px;">Last Edited By</label></td>
                                    <td><label id="lasteditedbylbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                </tr>
                                <tr>
                                    <td><label strong style="font-size: 14px;">Last Edited Date</label></td>
                                    <td><label id="lastediteddatelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                            <div style="width:98%; margin-left:1%;">
                                <table id="mrcinfotbl" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>MRC</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script  type="text/javascript">

    $(function () {
        pagecardSection = $('#page-block');
    });

    var k=0;
    var grid;//global variable
    //Show modal with focus textbox starts
    function deletemrc(id) {

swal.fire({
        title: "Delete",
        icon: 'question',
        text: "Are You sure do you want to delete this data!",
        type: "warning",
        showCancelButton: !0,
        allowOutsideClick: false,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        reverseButtons: !0
    }).then(function (e) {

if (e.value === true) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'DELETE',
        url: "{{url('/mrcdelete')}}/" + id,
        data: {_token: CSRF_TOKEN},
        dataType: 'JSON',
        success: function (results) {
            if(results.deleted){
                    swal.fire({
                        position: 'top-end',
                        title:"Done",
                        icon: 'success',
                        text:results.deleted,
                                showConfirmButton: false,
                                timer:2000
                                })
                                var oTable = $('#mrclistable').dataTable();
                                oTable.fnDraw(false);
                                var sTable = $('#laravel-datatable-crud').dataTable();
                                sTable.fnDraw(false);
                    }
                else if(results.dberrors){
                        swal.fire({
                        position: 'top-end',
                        title:"Error",
                        icon: 'error',
                        text:'Unable to delete this MRC',
                                showConfirmButton: false,
                                timer:2000
                                })
                    }
                    else {
                            swal.fire({
                                title:"Whoos",
                                icon:'error',
                                text:'This operation is coudnt execute please contact your technical support team',
                            });
                    }
                }
            });

        } else {
            e.dismiss;
        }

        }, function (dismiss) {
        return false;
        })
    }
    function mrcedit(id){
        $('#mrcid').val(id);
        $.get("getmrcedit/"+id,function (data, textStatus, jqXHR) {

                    $('#mrcstoreid').val(data.mrcedit.store_id);
                    $('#mrcNumber').val(data.mrcedit.mrcNumber);
                    $('#cashPrefix').val(data.mrcedit.cashprefix);
                    $('#creditPrefix').val(data.mrcedit.creditprefix);
                    $('#mrcstatus').val(data.mrcedit.status);
                    $('#fiscalVoidType').selectpicker('val',data.mrcedit.fiscalvoidtype);
                    $('#collapseOne').collapse('show');
            });
            $('#saveid').text('Update');
    }
    $(function () {
            cardSection = $('#card-block');
            
        });
    $('#savemrcNumberbutton').click(function(){
        var registerForm = $("#mrcform");
        var formData = registerForm.serialize();
        $.ajax({
            type: "POST",
            url: "{{ url('mrcstore') }}",
            data: formData,
            dataType: "json",
            
                        beforeSend:function(){
                    
                    $('#savemrcNumberbutton').prop('disabled',true);
                    $('#loadid').addClass('spinner-border spinner-border-sm');
                    $('#saveid').addClass('sml-25 align-middle').text('Please wait...');
                    cardSection.block({
                                message:
                                '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-0">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                                
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
                            $('#savemrcNumberbutton').prop('disabled',false);
                            $('#loadid').removeClass('spinner-border spinner-border-sm');
                            $('#saveid').text('Add');
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
                if(response.success)
                {
                    
                    toastrMessage("success","MRC Saved Successfully","Success");
                    //$('#collapseOne').collapse('hide');
                    $("#mrcform")[0].reset();
                    $('#mrcid').val('');
                    $('#fiscalVoidType').val('null').trigger('change');
                    var oTable = $('#mrclistable').dataTable();
                    oTable.fnDraw(false);
                    var sTable = $('#laravel-datatable-crud').dataTable();
                    sTable.fnDraw(false);
                }
                if(response.errors){
                    if(response.errors.mrcNumber){
                        $('#mrcNumber-error' ).html(response.errors.mrcNumber[0]);
                    }
                    if(response.errors.fiscalVoidType){
                        var text=response.errors.fiscalVoidType[0];
                        text = text.replace("fiscal void", "cancel");
                        $('#fiscalVoidType-error' ).html(text);
                        
                    }
                    if(response.errors.cashPrefix){
                        $('#cashPrefix-error' ).html(response.errors.cashPrefix[0]);
                        
                    }
                    if(response.errors.creditPrefix){
                        $('#creditPrefix-error' ).html(response.errors.creditPrefix[0]);
                        
                    }
                }
            }
        });
    });

        $('#fiscalVoidType').on ('change', function () {
            $('#fiscalVoidType-error').html('');
        });

    function ClearmrcValidation(){
        $('#mrcNumber-error' ).html('');
        $('#status-error' ).html('');
        $("#mrcform")[0].reset();
        $('#mrcid').val('');
    }
    $("#mrcNumber").keypress(function() {
            if($(this).val().length < 10) {
                $('#mrcNumber-error' ).html('MRC number should be 10 character');
            } else {
                $('#mrcNumber-error' ).html('');
            }
        });
    function removemrcValidation(){
        $('#mrcNumber-error' ).html('');
    }
    function removecashprefixValidation(){
        
        $('#cashPrefix-error' ).html('');
    }
    function removecreditprefixValidation(){
        $('#creditPrefix-error' ).html('');
    }
    function alowcreditsales(){
        $('#allowcreditsales-error' ).html('');
    }
    function statusmrcremoveValidation(){
        $('#status-error' ).html('');
    }
        $("#addnewmrc").on('click', function() {
                var sid=$('#storeid').val();
                $("#mrcform")[0].reset();
                $('#mrcid').val('');
                $('#mrcstoreid').val(sid);
                $("#mrcmodal").modal('show');
        });
    $(document).on('shown.bs.modal', '.modal', function ()
    {
        $(this).find('[autofocus]').focus();
    });
    //Show modal with focus textbox ends
    $('#type').on ('change', function () {
        var type=$('#type').val();
        $('#type-error' ).html('');
        var storeid=$('#storeid').val();
        if(type==="Shop"){
           $('#allowcrsales').show();
        }
        else{
            $('#allowcrsales').hide();
        }
        $('#IsAllowedCreditSales').val(null).trigger('change');
        $('#allowcreditsales-error').html("");
    });

            $(document).on('click', '.addRow', function() {
                    ++k;
                    var tr='<tr>'+
                    '<td><input type="text" name="mrcrow['+k+'][mrcNumber]" placeholder="Mrc Number" class="form-control mrcName" required></td>'+
                    '<td><select class="select2 form-control mrcname" name="mrcrow['+k+'][status]"<option></option><option value="Active">Active</option><option value="Inactive">Inactive</option></select></td>'+
                    '<td><a href="javascript:void(0)" class="btn-sm btn-danger deleteRow">x</td>'+
                    '</tr>';
                    $("#mracddtable").append(tr);
        });
        $(document).on('click', '.deleteRow', function() {
            --k;
            $(this).parents('tr').remove();
        });

    $('.addstorebutton').click(function(){ 
        $('#storeid').val('');
        var oprions="<option>Shop</option><option>Store</option>";
        $('#type').empty();
        $('#type').append(oprions);
        $('#type').select2();
        $('#savenewbutton').show();
        $('#savebutton').text('Save & Close');
        $('#type').val(null).trigger('change');
        $("#inlineForm").modal('show');
        $('#allowcrsales').hide();
        $('#IsAllowedCreditSales').val(null).trigger('change');
    });

    $('body').on('click', '.storeInfo', function() {
        var strid = $(this).data('id');
        $.ajax({
            type: "get",
            url: "{{url('getstore')}}"+'/'+strid,
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
            success: function (data) {
                $.each(data.storeinfo, function(key, value) {
                    $('#typeinfo').html(value.type);
                    $('#storenameinfo').html(value.Name);
                    $('#addressinfo').html(value.Place);
                    if(value.IsAllowedCreditSales=="Allow"){
                        $('#creditsalesinfo').html("Allowed");
                    }
                    if(value.IsAllowedCreditSales=="Not-Allow"){
                        $('#creditsalesinfo').html("Not-Allowed");
                    }
                    
                    $('#createdbylbl').html(value.CreatedBy);
                    $('#createddatelbl').html(value.CreatedDateTime);
                    $('#lasteditedbylbl').html(value.LastEditedBy);
                    $('#lastediteddatelbl').html(value.LastEditedDate);
                    if(value.ActiveStatus=="Active"){
                        $("#statusinfo").html("<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:14px;'>"+value.ActiveStatus+"</span>");
                    }
                    else{
                        $("#statusinfo").html("<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:14px;'>"+value.ActiveStatus+"</span>");
                    }
                });
            },
        });

        var ctable=$('#mrcinfotbl').DataTable({
            destroy:true,
            processing: true,
            serverSide: true,
            "order": [[ 1, "desc" ]],
            "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here"},
            "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-12'i>>",
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/mrcinfodata'+'/'+strid,
                type: 'DELETE',
            },
            columns: [
                {data:'DT_RowIndex'},
                { data: 'mrcNumber', name: 'mrcNumber' },
                { data: 'status', name: 'status' },
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                if (aData.status == "Active")
                {
                    $(nRow).find('td:eq(2)').css({"color": "#4CAF50", "font-weight": "bold"});
                }
                else if (aData.status == "Inactive")
                {
                    $(nRow).find('td:eq(2)').css({"color": "#f44336", "font-weight": "bold"});
                }
            }
        });
        $('#storeinfomodal').modal('show');
    });

    //Reset forms or modals starts
    function closeModalWithClearValidation()
    {
        $("#Register")[0].reset();
        $("#mrcform")[0].reset();
        $("#LocationRegister")[0].reset();
        $( '#name-error' ).html("");
        $( '#place-error' ).html("");
        $( '#status-error' ).html("");
        $( '#uname-error' ).html("");
        $( '#ustatus-error' ).html("");
        $( '#lname-error' ).html("");
        $( '#lstatus-error' ).html("");
        $( '#fiscalVoidType-error' ).html("");

    }

    function closeLocEditModalWithClearValidation()
    {
        $("#updatelocform")[0].reset();
        $('#luname-error' ).html("");
        $('#lustatus-error' ).html("");
    }
    //Reset forms or modals ends

    //Remove error messages on keyup event starts
    function removeNameValidation()
    {
        $( '#name-error' ).html("");
        $( '#uname-error' ).html("");
        $( '#lname-error' ).html("");
    }

    function removePlaceValidation()
    {
        $( '#place-error' ).html("");
        $( '#uplace-error' ).html("");
    }

    function removeStatusValidation()
    {
        $( '#status-error' ).html("");
        $( '#ustatus-error' ).html("");
        $( '#lstatus-error' ).html("");
    }

    function removeLocNameValidation()
    {
        $( '#luname-error' ).html("");
    }

    function removeLocStatusValidation()
    {
        $( '#lustatus-error' ).html("");
    }
    //Remove error messages on keyup event ends

    //Datatable read property starts
    $(document).ready( function () {
        // $('#mrcdiv').hide();
    var strable=$('#laravel-datatable-crud').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/storedata',
            type: 'DELETE',
        },
        columns: [
            { data:'DT_RowIndex' },
            { data: 'id',name: 'id','visible':false},
            { data: 'type',name:'type'},
            { data: 'Name',name:'Name'},
            { data: 'MRCNumbers',name:'MRCNumbers'},
            { data: 'Place', name: 'Place' },
            { data: 'IsAllowedCreditSale', name: 'IsAllowedCreditSale' },
            { data: 'ActiveStatus', name: 'ActiveStatus'},
            { data: 'action', name: 'action' }
        ],

        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
        {
            if (aData.ActiveStatus == "Active")
            {
                $(nRow).find('td:eq(6)').css({"color": "#4CAF50", "font-weight": "bold","text-shadow":"1px 1px 10px #4CAF50"});
            }
            else if (aData.ActiveStatus == "Inactive")
            {
                $(nRow).find('td:eq(6)').css({"color": "#f44336", "font-weight": "bold","text-shadow":"1px 1px 10px #f44336"});
            }
        }
        });
        strable.on( 'draw', function () {
            var body = $( strable.table().body() );
            body.unhighlight();
            body.highlight( strable.search() );
        });
    });
    //Datatable read property ends

    //Save Records to database starts
    $('#savebutton').click(function(){
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        var opt=$("#storeid").val();
        $('#name-error').html("");
        $('#storename-error').html("");
        $('#status-error').html("");
        $.ajax({
            url:'/savestore',
            type:'POST',
            data:formData,
            beforeSend:function(){
                pagecardSection.block({
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
                if(isNaN(parseFloat(opt))){
                    $('#savebutton').text('Saving...');
                    $('#savebutton').prop("disabled", true);
                }
                else if(!isNaN(parseFloat(opt))){
                    $('#savebutton').text('Updating...');
                    $('#savebutton').prop("disabled", true);
                }
            },
            complete: function () { 
                pagecardSection.block({
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
                if(data.errors) {
                    if(data.errors.name){
                        $( '#name-error' ).html( data.errors.name[0] );
                    }
                    if(data.errors.place){
                        $( '#place-error' ).html( data.errors.place[0] );
                    }
                    if(data.errors.status){
                        $( '#status-error' ).html( data.errors.status[0] );
                    }
                    if(data.errors.type){
                        $( '#type-error' ).html( data.errors.type[0]);
                    }
                    if(data.errors.IsAllowedCreditSales){
                        $( '#allowcreditsales-error' ).html("Credit sales field is required when type is Shop.");
                    }
                    if(data.errors.address){
                        $('#place-error' ).html( data.errors.address[0]);
                    }
                    if(isNaN(parseFloat(opt))){
                        $('#savebutton').prop("disabled", false);
                        $('#savebutton').text('Save & Close');
                    }
                    else if(!isNaN(parseFloat(opt))){
                        $('#savebutton').prop("disabled", false);
                        $('#savebutton').text('Update');
                    }
                    toastrMessage('error','Check Your inputs','Error');
                }
                if(data.errorv2){
                    var error_html = '';
                    for(var count = 0; count < data.errorv2.length; count++)
                    {
                        error_html += '<p>'+data.errorv2[count]+'</p>';
                    }
                    toastrMessage("error",error_html,"Error");
                    if(isNaN(parseFloat(opt))){
                        $('#savebutton').prop("disabled", false);
                        $('#savebutton').text('Save & Close');
                    }
                    else if(!isNaN(parseFloat(opt))){
                        $('#savebutton').prop("disabled", false);
                        $('#savebutton').text('Update');
                    }
                }
                if(data.success) {
                    if(isNaN(parseFloat(opt))){
                        $('#savebutton').prop("disabled", false);
                        $('#savebutton').text('Save & Close');
                        toastrMessage("success","Store Saved Successfully","Success");
                    }
                    else if(!isNaN(parseFloat(opt))){
                        $('#savebutton').prop("disabled", false);
                        $('#savebutton').text('Update');
                        toastrMessage("success","Store Updated Successfully","Success");
                    }
                    $("#inlineForm").modal('hide');
                    $("#Register")[0].reset();
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //Save records and close modal ends

    //Save records and new starts
    $('#savenewbutton').click(function(){  
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $('#name-error').html("");
        $('#storename-error').html("");
        $('#status-error').html("");
        $.ajax({
            url:'/savestore',
            type:'POST',
            data:formData,
            beforeSend:function(){
                pagecardSection.block({
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
                $('#savenewbutton').prop("disabled", true);
            },
            complete: function () { 
                pagecardSection.block({
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
                if(data.errors) {
                    if(data.errors.name){
                        $( '#name-error' ).html( data.errors.name[0] );
                    }
                    if(data.errors.place){
                        $( '#place-error' ).html( data.errors.place[0] );
                    }
                    if(data.errors.status){
                        $( '#status-error' ).html( data.errors.status[0] );
                    }
                    if(data.errors.type){
                        $( '#type-error' ).html( data.errors.type[0]);
                    }
                    if(data.errors.IsAllowedCreditSales){
                        $( '#allowcreditsales-error' ).html("Credit sales field is required when type is Shop.");
                    }
                    if(data.errors.address){
                        $('#place-error' ).html( data.errors.address[0]);
                    }
                    $('#savenewbutton').prop("disabled", false);
                    $('#savenewbutton').text('Save & New');
                    toastrMessage('error','Check Your inputs','Error');
                }
                if(data.errorv2){
                            var error_html = '';
                            for(var count = 0; count < data.errorv2.length; count++)
                                {
                                    error_html += '<p>'+data.errorv2[count]+'</p>';
                                }
                                $('#savebutton').text('Save');
                                $('#savebutton').prop('disabled',false);
                                toastrMessage("error",error_html,"Error");
                            $('#savebutton').prop("disabled", false);
                            $('#savebutton').text('Save & Close');
                        }
                if(data.success) {
                    $('#savenewbutton').prop("disabled", false);
                    $('#savenewbutton').text('Save & New');
                    toastrMessage('success','Store Saved Successfully','Success');
                    $("#Register")[0].reset();
                    $('#type').val(null).trigger('change');
                    $('#NameFocus').focus();
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //Save records and new ends

    //Open Edit Modal With Value Starts
    $('#examplemodal-edit').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget)
        var id=button.data('id')
        var name=button.data('name')
        var place=button.data('place')
        var status=button.data('status')
        console.log(id)
        var modal=$(this)
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #place').val(place);
        modal.find('.modal-body #status').val(status);
        modal.find('.modal-body #id').val(id);
    });

    $('body').on('click', '.editstore', function() {
        var id = $(this).data('id');
            $('#type').empty();
            $('#mrc').empty();
        $.get("getstore/"+id,function (data, textStatus, jqXHR) {
            $('#storeid').val(data.store.id);
            var types=data.store.type;
            var $newOption = $("<option selected='selected'></option>").val(types).text(types);
            $("#type").append($newOption).trigger('change');
            $('#name').val(data.store.Name);
            $('#address').val(data.store.Place);
            $('#status').val(data.store.ActiveStatus);
            $('#usernamehidden').val(data.store.CreatedBy);
            $('#createddatehidden').val(data.store.CreatedDate);
            $('#IsAllowedCreditSales').val(data.store.IsAllowedCreditSales).trigger('change').select2();
                if(types==="Shop" ){
                    var $storeoption = $("<option></option>").val("Store").text("Store");
                    $("#type").append($storeoption);
                    $("#mrclistable").show();
                    $("#addnewmrc").show();
                    $("#mracddtable").hide();
                }
                if(types=="Store"){
                    var $storeoption = $("<option></option>").val("Shop").text("Shop");
                    $("#type").append($storeoption);
                    $("#mrclistable").hide();
                    $("#addnewmrc").hide();
                    $("#mracddtable").hide();
                }
            $('#savenewbutton').hide();
            $('#savebutton').text('Update');
            $('#inlineForm').modal('show');
            });

    })
    //Open Edit Modal With Value Ends

    //Update Records Starts
    $('#updatebutton1').click(function() {
        var registerForm = $("#updateregisterform");
        var formData = registerForm.serialize();
        $( '#uname-error' ).html( "" );
        $( '#uplace-error' ).html( "" );
        $( '#ustatus-error' ).html( "" );
        console.log('button clickbale')
        $.ajax({
            url:'/storeupdate',
            type:'POST',
            data:formData,
            beforeSend:function(){$('#updatebutton1').text('Updating...');},
            success:function(data) {
                console.log(data);
                if(data.errors)
                {
                    if(data.errors.name){
                        $('#uname-error' ).html( data.errors.name[0] );
                    }
                    if(data.errors.place){
                        $( '#uplace-error' ).html( data.errors.place[0] );
                    }
                    if(data.errors.status){
                        $('#ustatus-error' ).html( data.errors.status[0] );
                    }
                    $('#updatebutton1').text('Update');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Check Your Inputs");
                    $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                }
                if(data.success) {
                    $('#updatebutton1').text('Update');
                    $("#myToast").toast({ delay: 4000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Store Updated Successfully");
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#examplemodal-edit").modal('hide');
                    $("#updateregisterform")[0].reset();
                    var oTable = $('#laravel-datatable-crud').dataTable();
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //Update Records Ends

    //Starts Delete Modal With Value
    $('#examplemodal-delete').on('show.bs.modal',function(event)
    {
        console.log('delete')
        var button=$(event.relatedTarget)
        var id=button.data('id')
        console.log(id)
        var modal=$(this)
        modal.find('.modal-body #did').val(id);
    });
    //End Delete Modal With Value

    //Delete Records Starts
    $('#deletebtn').click(function()
    {
        var cid = document.forms['deletform'].elements['id'].value;
        var registerForm = $("#deletform");
        var formData = registerForm.serialize();
        console.log('ccid=='+cid)
        $.ajax(
        {
        url:'/deletestore/'+cid,
        type:'DELETE',
        data:formData,
        beforeSend:function(){
        $('#deletebtn').text('Deleting...');},
        success:function(data)
        {

            if(data.errors)
            {
                $('#deletebtn').text('Delete');
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("Unable to delete this store");
                $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                $('#examplemodal-delete').modal('hide');
                $('#deletebtn').text('Delete');
                var oTable = $('#laravel-datatable-crud').dataTable();
                oTable.fnDraw(false);
            }
            else if(data.dberrors)
            {
                $('#deletebtn').text('Delete');
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("Unable to delete this store");
                $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                $('#examplemodal-delete').modal('hide');
                $('#deletebtn').text('Delete');
                var oTable = $('#laravel-datatable-crud').dataTable();
                oTable.fnDraw(false);
            }
            if(data.success)
            {
                $('#deletebtn').text('Delete');
                $("#myToast").toast('show');
                $('#toast-massages').html("Store Removed Successfully");
                $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                $('#examplemodal-delete').modal('hide');
                $('#deletebtn').text('Delete');
                var oTable = $('#laravel-datatable-crud').dataTable();
                oTable.fnDraw(false);
            }
        }
    })
 });
 //Delete Records Ends

    $('#mrcmodalform').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget)
        var id=button.data('id')
        var locname=button.data('name');
        var modal=$(this)
        modal.find('.modal-body #storeid').val(id);
        modal.find('.modal-body #st-name').val(id);
        $('#mrcstoreid').val(id);
        modal.find('.modal-header #myModalLabel3356').text('Register MRC in '+locname+' shop');
        $("#collapseOne").collapse('hide');

            var mrctable=$('#mrclistable').DataTable({
                            responsive: true,
                            processing: true,
                            serverSide: true,
                            searching: true,
                            paging: false,
                            info: true,
                            destroy: true,
                            "order": [[ 1, "desc" ]],
                            "pagingType": "simple",
                            language: { search: '', searchPlaceholder: "Search here"},
                                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
                            ajax: {
                                url: '/getassignedmrc/'+id,
                                type: 'GET',
                                },
                            columns: [
                                { data:'DT_RowIndex' },
                                { data: 'id', name: 'id', 'visible': false },
                                { data: 'mrcNumber', name: 'mrcNumber' },
                                { data: 'cashprefix', name: 'cashprefix' },
                                { data: 'creditprefix', name: 'creditprefix' },
                                { data: 'fiscalvoidtype', name: 'fiscalvoidtype' },
                                { data: 'status', name: 'status' },
                                { data: 'id', name: 'id' }
                            ],
                            columnDefs: [ {
                                targets:5,
                                render: function (data ,type,row,meta){
                                    if(data==1){
                                        return "Fs #";
                                    }
                                    else if(data==2){
                                        return "Invoice #";
                                    }
                                    else{
                                        return "Not set";
                                    }
                                }

                            },{
                            targets: 7,
                            data: "",
                            render: function ( data, type, row, meta ) {
                                var btn =  ' <a data-id="'+data+'" class="btn btn-icon btn-gradient-info btn-sm mrcedit" data-toggle="modal" onclick="mrcedit('+data+')" style="color: white;" title="Edit Record"><i class="fa fa-edit"></i></a>';
                                btn = btn+' <a data-id="'+data+'" class="btn btn-icon btn-gradient-danger btn-sm mrcdelete"  onclick="deletemrc('+data+')" style="color: white;" title="Delete Record"><i class="fa fa-trash"></i></a>';
                                return btn;
                        }
                        }],
                            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
                                {
                                    if (aData.status == "Active")
                                    {
                                        $(nRow).find('td:eq(5)').css({"color": "#4CAF50", "font-weight": "bold","text-shadow":"1px 1px 10px #4CAF50"});
                                    }
                                    else if (aData.status == "Inactive")
                                    {
                                        $(nRow).find('td:eq(5)').css({"color": "#f44336", "font-weight": "bold","text-shadow":"1px 1px 10px #f44336"});
                                    }
                                }
                        });
                        mrctable.on( 'draw', function () {
                var body = $(mrctable.table().body());
                body.unhighlight();
                body.highlight(mrctable.search());
                });

    });
//Open Location add Modal With Value Starts
    $('#locationForm').on('show.bs.modal',function(event)
    {
        var button=$(event.relatedTarget)
        var id=button.data('id')
        var locname=button.data('name');
        console.log(id)
        var modal=$(this)
        modal.find('.modal-body #storeid').val(id);
        modal.find('.modal-body #st-name').val(id);
        modal.find('.modal-header #myModalLabel3356').text('Register Location in '+locname);
        $("#collapseOne").collapse('hide');
        $(document).ready( function () {
            $('#laravel-datatable-crud-location').DataTable({
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
                url: '/showloaction/'+id,
                type: 'GET',
                },
            columns: [
                { data: 'id', name: 'id', 'visible': false },
                { data: 'StoreId', name: 'StoreId' ,'visible': false},
                { data: 'Name', name: 'Name' },
                { data: 'ActiveStatus', name: 'ActiveStatus'},
                { data: 'action', name: 'action' }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                if (aData.ActiveStatus == "Active")
                {
                    $(nRow).find('td:eq(1)').css({"color": "#4CAF50", "font-weight": "bold","text-shadow":"1px 1px 10px #4CAF50"});
                }
                else if (aData.ActiveStatus == "Inactive")
                {
                    $(nRow).find('td:eq(1)').css({"color": "#f44336", "font-weight": "bold","text-shadow":"1px 1px 10px #f44336"});
                }
            }
            });
        });
    });
    //Location add Modal With Value Ends

     //Save locations and new starts
    $('#savelocationbtn').click(function(){
        var registerForm = $("#LocationRegister");
        var formData = registerForm.serialize();
        $( '#lname-error' ).html( "" );
        $( '#lstatus-error' ).html( "" );
        $.ajax({
           url:'/savelocation',
            type:'POST',
            data:formData,
            beforeSend:function(){$('#savelocationbtn').text('Adding...');},
            success:function(data) {
                console.log(data);
                if(data.errors) {
                    if(data.errors.name){
                        $( '#lname-error' ).html( data.errors.name[0] );
                    }
                    if(data.errors.status){
                        $( '#lstatus-error' ).html( data.errors.status[0] );
                    }
                    $('#savelocationbtn').text('Add Location');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Check Your Inputs");
                    $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                }
                if(data.success) {
                    $('#savelocationbtn').text('Add Location');
                    $("#myToast").toast({ delay: 4000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Location Added Successfully");
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#LocationRegister")[0].reset();
                    $('#lname').focus();
                    var oTable = $('#laravel-datatable-crud-location').dataTable();
                    oTable.fnDraw(false);

                }
            },
        });
    });
    //Save location and new ends

    //Open Location Edit Modal With Value Starts
    $('#examplemodal-locedit').on('show.bs.modal',function(event)
    {
        console.log('we')
        var button=$(event.relatedTarget)
        var id=button.data('id')
        var storeids=button.data('storeid')
        var name=button.data('name')
        var status=button.data('status')
        console.log(id)
        var modal=$(this)
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #sid').val(storeids);
        modal.find('.modal-body #status').val(status);
        modal.find('.modal-body #id').val(id);
        $( '#lname-error' ).html("");
        $( '#lstatus-error' ).html("");

    });
    //Location Edit Modal With Value Ends

    //Update Location records Starts
    $('#updatelocbutton').click(function(){
        var updateForm = $("#updatelocform");
        var cid = document.forms['updatelocform'].elements['id'].value;
        console.log(cid);
        var formData = updateForm.serialize();
        $( '#luname-error' ).html( "" );
        $( '#lustatus-error' ).html( "" );
        console.log('button clickbale')
        $.ajax({
            url:'/locationupdate/'+cid,
            type:'GET',
            data:formData,
            beforeSend:function(){$('#updatelocbutton').text('Updating...');},
            success:function(data) {
                if(data.errors)
                {
                    if(data.errors.name){
                        $('#luname-error' ).html( data.errors.name[0] );
                    }
                    if(data.errors.status){
                        $('#lustatus-error' ).html( data.errors.status[0] );
                    }
                    $('#updatelocbutton').text('Update');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Check Your Inputs");
                    $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                }
                if(data.success) {
                    $('#updatelocbutton').text('Update');
                    $("#myToast").toast({ delay: 4000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Location Updated Successfully");
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#examplemodal-locedit").modal('hide');
                    $("#updatelocform")[0].reset();
                    var oTable = $('#laravel-datatable-crud-location').dataTable();
                    oTable.fnDraw(false);
                }
            },
        });
    });
    //Update Location Records Ends

    //Starts Delete Modal With Value
    $('#examplemodal-locdelete').on('show.bs.modal',function(event)
    {
        console.log('delete')
        var button=$(event.relatedTarget)
        var id=button.data('id')
        console.log(id)
        var modal=$(this)
        modal.find('.modal-body #did').val(id);
        $( '#lname-error' ).html("");
        $( '#lstatus-error' ).html("");
    });
    //End Delete Modal With Value

    //Delete Records Starts
    $('#deletelocbtn').click(function()
    {
        var cid = document.forms['deletelocform'].elements['id'].value;
        var deleteForm = $("#deletelocform");
        var formData = deleteForm.serialize();
        $.ajax(
        {
            url:'/deletelocation/'+cid,
            type:'DELETE',
            data:formData,
            beforeSend:function(){
            $('#deletelocbtn').text('Deleting...');},
            success:function(data)
            {
                $('#deletelocbtn').text('Delete');
                $("#myToast").toast('show');
                $('#toast-massages').html("Location Removed Successfully");
                $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                $('#examplemodal-locdelete').modal('hide');
                var oTable = $('#laravel-datatable-crud-location').dataTable();
                oTable.fnDraw(false);
            }
        });
    });
 //Delete Records Ends

    function addLocation()
    {
        $('#lname').val("");
        $('#lname-error').html("");
        $('#mrcNumber-error').html("");
        $('#fiscalVoidType-error').html("");
    }
</script>
@endsection
