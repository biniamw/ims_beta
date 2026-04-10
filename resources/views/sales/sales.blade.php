@extends('layout.app')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    <div class="card-header border-bottom">
                        <h3 class="card-title">Sales</h3>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                @can('sales-show')
                                <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#salestab" aria-controls="customer" role="tab" aria-selected="true">Sale</a>                                </li>
                                    @endcan
                            <li class="nav-item">
                            @can('sale-holdView')
                                <a class="nav-link" id="salehold-tab" data-toggle="tab" href="#saleshold" aria-controls="blacklist" role="tab" aria-selected="false">Sales Hold</a>
                            @endcan
                            </li>
                        </ul>
                       
                        <button type="button"  class="btn btn-gradient-info btn-sm addbutton" data-toggle="modal" data-target="" style='float:right; margin-top:2%; margin-right:1%;'>Add</button>
                        
                    </div>
                    <div class="card-datatable">
                        
                        <div class="tab-content">
                            <div class="tab-pane active" id="salestab" aria-labelledby="sales-tab" role="tabpanel">
                               
                                <div style="width:98%; margin-left:1%;">
                                    <div class="table-responsive">
                                    @can('sales-show')
                                <table id="laravel-datatable-crud" class="table table-bordered table-striped table-hover dt-responsive table mb-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category</th>
                                            <th>Customer Name</th>
                                            <th>TIN No.</th>
                                            <th>payment Type</th>
                                            <th>Voucher Type</th>
                                            <th>Voucher No.</th>
                                            <th>MRC No.</th>
                                            <th>Point Of Sales</th>
                                            <th>Date</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>    
                                </table>
                                @endcan
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="saleshold" aria-labelledby="saleshold-tab" role="tabpanel">
                               
                                <div style="width:98%; margin-left:1%;">
                                    <div class="table-responsive">
                                @can('sale-holdView')
                                <table id="datatable-crud-bl" class="table table-bordered table-striped table-hover dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Customer Category</th>
                                            <th>Customer Name</th>
                                            <th>TIN No.</th>
                                            <th>payment Type</th>
                                            <th>Voucher Type</th>
                                            <th>Voucher Number</th>
                                            <th>MRC No.</th>
                                            <th>Point Of Sales</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>    
                                </table>
                                @endcan
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
<div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;" >
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel333">New Sales</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeinlineFormModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Register">
                {{ csrf_field() }}
                <div class="modal-body">
                    <section id="input-mask-wrapper">
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-xl-9 col-lg-12">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="customerdiv">
                                            <label strong style="font-size: 14px;color">Customer </label>
                                            <input type="hidden" name="id" id="id">
                                                <input type="hidden" name="ce" id="ce">
                                            <div>
                                               
                                                <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="customer" id="customer">
                                                    <option selected disabled  value=""></option>
                                                    <div id="wrdiv">
                                                    @foreach ($customerSrc as $customerSrc)
                                                    <option value="{{$customerSrc->id}}">{{$customerSrc->Code}}  ,  {{$customerSrc->Name}} ,   {{$customerSrc->TinNumber}} </option>
                                                    @endforeach
                                                    </div>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="customer-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="customerrdiv">
                                            <label strong style="font-size: 14px;color">Customer </label>
                                           
                                            <div>
                                               
    
                                                <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="Retailcustomer" id="Retailcustomer">
                                                    <option selected disabled  value=""></option>
                                                    <div id="wrdiv">  
                                                    @foreach ($customerSrcr as $customerSrc)
                                                    <option value="{{$customerSrc->id}}">{{$customerSrc->Code}}  ,  {{$customerSrc->Name}} ,   {{$customerSrc->TinNumber}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="customer-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="customerwdiv">
                                            <label strong style="font-size: 14px;color">Customer </label>
                                           
                                            <div>
                                               
    
                                                <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="Wholesellercustomer" id="Wholesellercustomer">
                                                    <option selected disabled  value=""></option>
                                                   
                                        
                                                    
                                                    @foreach ($customerSrcw as $customerSrc)
                                                    <option value="{{$customerSrc->id}}">{{$customerSrc->Code}}  ,  {{$customerSrc->Name}} ,   {{$customerSrc->TinNumber}} </option>
                                                    @endforeach
                                                    

                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="customer-error"></strong>
                                            </span>
                                        </div>
                                      
                                        <div class="col-xl-2 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Payment Type</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="paymentType" id="paymentType" onchange="paymenttyperemoveeroor();">
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="paymenttype-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Voucher Type</label>
                                            <div class="input-group input-group-merge">
                                                <select class="form-control" name="voucherType" id="voucherType" onchange="mrcValid()">
                                                    <option value="Fiscal-Receipt">Fiscal-Receipt</option>
                                                    <option value="Manual-Receipt">Manual-Receipt</option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="vouchertype-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Voucher Number</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" placeholder="Voucher Number" class="form-control" name="voucherNumber" id="voucherNumber" onkeyup="removevoucherNumberValidation()" onkeypress="return ValidateOnlyNum(event);"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="vouchernumber-error"></strong>
                                            </span>
                                        </div>
                                     </div>
                                     <div class="row">

                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="storediv">
                                            <label strong style="font-size: 14px;">Point Of Sales</label>
                                            <div>
                                                
                                                <select class="selectpicker form-control form-control-lg" data-live-search="true"  data-style="btn btn-outline-secondary waves-effect" name="store" id="store" onchange="removeStoreValidation()">
                                                   
                                                    @foreach ($storeSrc as $storeSrc)
                                                        <option value="{{$storeSrc->StoreId}}">{{$storeSrc->StoreName}}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="salecounti" id="salecounti" readonly="true"/>
                                                <input type="hidden" name="calcutionhide" id="calcutionhide" readonly="true"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="store-error"></strong>
                                            </span>
                                        </div>

                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2" id="storedivedit">
                                            <label strong style="font-size: 14px;">Issue Store</label>
                                            <div>
                                            <div class="input-group input-group-merge">
                                                <input type="text" placeholder="Issue Store" class="form-control" name="storeedit" id="storeedit" readonly/>
                                            </div>
                                                
                                                
                                            </div>
                                            <span class="text-danger">
                                                <strong id="store-error"></strong>
                                            </span>
                                        </div>
                                      
                                        <div class="col-xl-4 col-md-6 col-sm-12 mb-2" id="mrcdiv">
                                            <label strong style="font-size: 14px;">MRC</label>
                                            <div class="input-group input-group-merge">
                                                <select class="selectpicker form-control form-control-lg" data-live-search="true"  data-style="btn btn-outline-secondary waves-effect" name="CustomerMRC" id="CustomerMRC" onchange="removeMrcValidation()">
                                                    @foreach ($mrc as $mrc)
                                                    <option value="{{$mrc->MRCNumber}}">{{$mrc->MRCNumber}}</option>
                                                    @endforeach     
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="CustomerMRC-error"></strong>
                                            </span>
                                        </div>


                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;">Date</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text"  name="date" id="date" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="removeDateValidation()"/>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="date-error"></strong>
                                            </span>
                                        </div>
                                       
            
                                    </div>       
                                 </div>
                                 <div class="col-xl-3 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Customer  Info</h6>
                                        </div>
                                        <div class="card-body" id="customerInfoCardDiv">
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Name: </label>
                                                <label id="cname" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Category: </label>
                                                <label id="ccategory" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Defualt price: </label>
                                                <label id="cdefaultPrice" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Tin Number: </label>
                                                <label id="ctinNumber" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Vat: </label>
                                                <label id="cvat" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                            <div class="row">
                                                <label strong style="font-size: 12px;">Withold: </label>
                                                <label id="cwithold" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>

                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <span id="dynamic-error"></span>
                                        <div style="width:98%; margin-left:1%;">
                                            <div class="table-responsive">
                                        <table  id="dynamicTable">  
                                            <tr>
                                                <th>#</th>
                                                <th>Item Name</th>
                                                <th>UOM</th>
                                                <th>Qty.on Hand</th>
                                                <th>Quantity</th>
                                                <th id="dprthead">D Price</th>
                                                <th>Unit price</th>
                                                @can('sales-discount')
                                                <th>Discount</th>
                                                @endcan
                                                
                                                <th>Before Tax</th>
                                                <th>Tax Amount</th>
                                                <th>Total Price</th>
                                                <th></th>
                                            </tr>
                                          
                                            
                                        </table> 
                                        
                                        <table id="datatable-crud-child" class="table table-bordered table-striped table-hover dt-responsive table mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th id="itemheadholdedit">D Price</th>
                                                    <th>Unitprice</th>
                                                    <th>Discount(%)</th>
                                                    <th>Before Tax</th>
                                                    <th>Tax Amount</th>
                                                    <th>Total Pric</th>
                                                    <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>    
                                        </table>
                                        <table id="datatable-crud-childsale" class="table table-bordered table-striped table-hover dt-responsive table mb-0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th id="itemhead">D Price</th>
                                                    <th>Unitprice</th>
                                                    <th>Discount(%)</th>
                                                    <th>Before Tax</th>
                                                    <th>Tax Amount</th>
                                                    <th>Total Price</th>
                                                    <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>    
                                        </table>

                                        <table>
                                            <tr>
                                                <td><button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i data-feather='plus'></i> Add New </button>
                                                    <button type="button" name="addnew" id="addnew" class="btn btn-success btn-sm"><i data-feather='plus'></i> Add New</button>
                                                    <button type="button" name="addnewhold" id="addnewhold" class="btn btn-success btn-sm"><i data-feather='plus'></i> Add New</button></td>
                                            </tr>
                                        </table>
                                        <table style="width:100%;" id="pricetable">

                                           

                                            <tr>
                                                <td style="text-align: right;"><label strong style="font-size: 16px;">Sub Total:</label></td>
                                                <td style="text-align: right; width:10%"><label id="subtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                <td><input type="hidden" placeholder="" class="form-control" name="subtotali" id="subtotali" readonly="true" value="0"/></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;"><label strong style="font-size: 16px;">Tax:</label></td>
                                                <td style="text-align: right; width:10%"><label id="taxLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                <td><input type="hidden" placeholder="" class="form-control" name="taxi" id="taxi" readonly="true" value="0"/></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total:</label></td>
                                                <td style="text-align: right; width:10%"><label id="grandtotalLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                                <td><input type="hidden" placeholder="" class="form-control" name="grandtotali" id="grandtotali" readonly="true" value="0"/></td>
                                            </tr>
                                          

                                            <tr id="witholdingTr">
                                                <td style="text-align: right;"><label id="withodingTitleLbl" strong style="font-size: 16px;">Witholding:</label></td>
                                                <td style="text-align: right; width:10%">
                                                    <label id="witholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                    <input type="hidden" placeholder="" class="form-control" name="witholdingAmntin" id="witholdingAmntin" readonly="true" value="0"/>
                                                </td>
                                            </tr>
                                            
                                            
                                            <tr id="vatTr">
                                                <td style="text-align: right;"><label id="vatTitleLbl" strong style="font-size: 16px;">Vat:</label></td>
                                                <td style="text-align: right; width:10%">
                                                    <label id="vatAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                    <input type="hidden" placeholder="" class="form-control" name="vatAmntin" id="vatAmntin" readonly="true" value="0"/>
                                                </td>
                                            </tr>
                                           
                                            </tr>
                                            <tr id="netpayTr">
                                                <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay:</label></td>
                                                <td style="text-align: right; width:10%">
                                                    <label id="netpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                                    <input type="hidden" placeholder="" class="form-control" name="netpayin" id="netpayin" readonly="true" value="0"/>
                                                </td>
                                            </tr>
                                            

                                            <tr>
                                                <td colspan="2" style="text-align: right;">
                                                   —-------------------------------
                                                </td>
                                            </tr>
                                            <tr id="discountTr">
                                             <td style="text-align: right;"><label strong style="font-size: 16px;color:#dc3545;" id="discountamountextLbl">Discount:</label></td>
                                                <td style="text-align: right; width:10%"><label id="discountamountLbl" strong style="font-size: 16px; font-weight: bold;color:#dc3545;"></label></td>
                                                <td><input type="hidden" placeholder="" class="form-control" name="discountamountli" id="discountamountli" readonly="true" /></td>
                                                <td><input type="hidden" placeholder="" class="form-control" name="discountpercenti" id="discountpercenti" readonly="true" /></td>
                                            </tr>
                                            <!-- <tr id="discountnetpayTr">
                                                <td style="text-align: right;"><label strong style="font-size: 16px;color:#026928;" id="dicountnetpayLbl">NetPay:</label></td>
                                                <td style="text-align: right; width:10%"><label id="discountnetpayAmountLbl" strong style="font-size: 16px; font-weight: bold;color:#dc3545;"></label></td>
                                            </td> -->
                                            <tr>
                                                <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items:</label></td>
                                                <td style="text-align: right; width:10%"><label id="numberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                <td><input type="hidden" name="numbercounti" id="numbercounti"/></td>
                                            </tr>

                                            <tr id="hidewitholdTr">
                                                <td colspan="3" style="text-align: right;">
                                                <div class="form-check form-check-inline" id="hidewitholddiv">
                                                        <label class="form-check-label" >Hide Deduction: </label>
                                                        <input class="form-check-input" name="hidewithold" type="checkbox" id="hidewithold" />
                                                        <input type="hidden" placeholder="" class="form-control" name="hidewitholdi" id="hidewitholdi" readonly="true" value="1"/>
                                                        <input type="hidden" placeholder="" class="form-control" name="hidevati" id="hidevati" readonly="true" value="1"/>
                                                    </div>
                                                
                                                </td>
                                            </tr>

                                        </table>    
                                </div>
                            </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-12" id="iteminfo">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title">Item Info</h6>
                                                <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                                            </div>
                                            <div class="card-body" id="itemInfoCardDiv">
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Item Code: </label>
                                                    <label id="itemcodeInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Item Name: </label>
                                                    <label id="itemInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">UOM: </label>
                                                    <label id="uomInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Category: </label>
                                                    <label id="itemCategoryInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Retailer Price: </label>
                                                    <label id="rpInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Wholeseller Price: </label>
                                                    <label id="wsInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Tax %: </label>
                                                    <label id="taxInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">SKU #: </label>
                                                    <label id="skuInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                                <div class="row">
                                                    <label strong style="font-size: 12px;">Part #: </label>
                                                    <label id="partNumInfoLbl" strong style="font-size: 12px;" class="badge badge-warning"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" name="witholdMinAmounti" id="witholdMinAmounti" readonly="true"/>
                    <input type="hidden" class="form-control" name="servicewitholdMinAmounti" id="servicewitholdMinAmounti" readonly="true"/>
                    <input type="hidden" class="form-control" name="witholdPercenti" id="witholdPercenti" readonly="true"/>
                    <input type="hidden" class="form-control" name="vatPercenti" id="vatPercenti" readonly="true"/>
                    <input type="hidden" class="form-control" name="vatAmount" id="vatAmount" readonly="true"/>
                    <!-- {{-- <button id="updatecustomer" type="button" class="btn btn-info">Update</button> --}} -->
                    <button id="saveupbutton" type="button" class="btn btn-info">Update</button>
                    <!-- {{-- <button id="savenewbutton" type="button" class="btn btn-info">Save & New</button> --}} -->
                    <button id="savebuttoncopy" type="button" class="btn btn-info">Save</button>
                    @can('sales-add')
                    <button id="savebutton" type="button" class="btn btn-info">Save</button>
                    @endcan
                    @can('sale-holdAdd')
                    <button id="savebuttonhold" type="button" class="btn btn-info">Hold</button>
                    @endcan
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeinlineFormModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
           
        </div>
    </div>
</div>
<!--End Registation Modal -->

{{-- start of item edit form --}}

<div class="modal fade" id="IteminlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel333">Add Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeIteminlineFormModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="itemRegisterForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <section id="input-mask-wrapper">
                    <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div style="width:98%; margin-left:1%;">
                                    <div class="">
                                <table>
                                    <tr>
                                        <td style="width: 20%">
                                            <label strong style="font-size: 14px;">Item Name</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">UOM</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Qty on Hand</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Quantity</label>
                                        </td>
                                        <td id="editptypeth">
                                            <label strong style="font-size: 14px;">D Price</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Unit Price</label>
                                        </td>
                                        @can('sales-discount')
                                        <td>
                                            <label strong style="font-size: 14px;">Discount(%)</label>
                                        </td>
                                        @endcan

                                        <td>
                                            <label strong style="font-size: 14px;">Before Tax</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Tax Amount</label>
                                        </td>
                                        <td>
                                            <label strong style="font-size: 14px;">Total Price</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="itemid" id="itemid" class="form-control">
                                            <input type="hidden" name="HeaderId" id="HeaderId" class="form-control"> 
                                            <input type="hidden" name="storeId" id="storeId" class="form-control"> 
                                            <input type="hidden" name="commonId" id="commonId" class="form-control"> 
                                            <select class="selectpicker form-control form-control-lg ItemName" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="ItemName" id="ItemName" onchange="removeItemNameValidation()">
                                                <option selected value=""></option>
                                                @foreach ($itemSrcss as $storeSrc)
                                                   
                                                    <option value="{{$storeSrc->ItemId}}">{{$storeSrc->Code}}, {{$storeSrc->ItemName}}, {{$storeSrc->SKUNumber}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                       
                                        <td style="width: 10%">
                                            <select id="uoms" class="select2 form-control uoms" onchange="uomsavedVal(this)" name="uoms"></select>
                                        </td>
                                        <td>
                                        <input type="text" placeholder="Qty on hand" name="avQuantitiy" id="avQuantitiy" class="form-control" readonly /> 
                                        <input type="hidden" placeholder="Qty on hand" name="avQuantitiyh" id="avQuantitiyh" class="form-control" readonly /> 
                                        </td>

                                        <td>
                                            <input type="text"  placeholder="Quantity" class="form-control" name="Quantity" id="Quantity" onkeyup="CalculateAddHoldTotal(this)" onclick="removeQuantityValidation()" onkeypress="return ValidateNum(event);"/>
                                        </td>
                                        <td style="width: 10%" id="editptypetd">
                                        <select class="form-control" name="defPrice" id="defPrice" onchange="defPricechange()">
                                                <option selected disabled value=""></option>

                                                    <option value="Rp">Rp</option>
                                                    <option value="Ws">Ws</option>
                                               
                                            </select> 
                                        </td>   
                                        <td>
                                            <input type="text" placeholder="unit price" class="form-control" name="UnitPrice" id="UnitPrice" onkeyup="CalculateAddHoldTotal(this)" onclick="removeUnitPriceValidation()" onkeypress="return ValidateNum(event);" readonly  @can('UnitPrice-Active') ondblclick="unitpriceSingleActive();" @endcan/>
                                        </td>
                                        @can('sales-discount')
                                        <td>
                                            <input type="text" placeholder="Discount"  class="form-control" name="Discounts" id="Discount" value="" onkeyup="CalculateDiscountSingle(this)" onclick="removeDiscountValidation()" onkeypress="return ValidateNum(event);"/>
                                        </td>
                                        @endcan
                                        <td>
                                            <input type="text"  name="BeforeTaxPrice" id="BeforeTaxPrice"  placeholder="Before Tax Price" class="form-control"  readonly />
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Tax" name="TaxAmount" id="TaxAmount" class="form-control" readonly /> 
                                        </td>
                                        <td>
                                        <input type="text" placeholder="Total" name="TotalPrice" id="TotalPrice" class="form-control" readonly /> 
                                        
                                        <input type="hidden" class="form-control" name="defaultuomi" id="defaultuomi" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="newuomi" id="newuomi" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="convertedqi" id="convertedqi" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="convertedamnti" id="convertedamnti" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="mainPricei" id="mainPricei" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="maxicost" id="maxicost" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="discountiamount" id="discountiamount" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="triggervalue" id="triggervalue" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="Wsaleminamount" id="Wsaleminamount" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="Rsaleprice" id="Rsaleprice" value="0" readonly="true"/>
                                        <input type="hidden" class="form-control" name="Wsaleprice" id="Wsaleprice" value="0" readonly="true"/>


                                        </td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="ItemName-error"></strong>
                                        </span>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="Quantity-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="UnitPrice-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="discount-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="BeforeTaxPrice-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="TaxAmount-error"></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-danger">
                                            <strong id="TotalPrice-error"></strong>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                       
                    </section>
                </div>
                <div class="modal-footer">
                    <button id="savebuttonsaleitem" type="button" class="btn btn-info">Add</button>
                    <button id="savebuttonitem" type="button" class="btn btn-info">Add</button>
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeIteminlineFormModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
           
        </div>
    </div>
</div>



{{-- end of item edit form --}}

{{-- info show modal --}}
<div class="modal fade" id="InfoinlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel333">Sales info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="row">
                    
                    <div class="col-xl-12 col-lg-12" id="iteminfo">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title"> Information About Your Sales</h6>
                                <a data-action="reload"><i data-feather="rotate-cw"></i></a>
                            </div>
                            <div class="card-body" id="itemInfoCardDiv">
                                
                                <div class="row">
                                    <label strong style="font-size: 12px;">Customer Name: </label>
                                    <label id="CustomerIdLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Payment Type: </label>
                                    <label id="PaymentTypeLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Voucher Type: </label>
                                    <label id="VoucherTypeLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Voucher Number: </label>
                                    <label id="VoucherNumberLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Customer MRC: </label>
                                    <label id="CustomerMRCLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Store Id: </label>
                                    <label id="StoreIdLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Purchaser Name: </label>
                                    <label id="PurchaserNameLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Void: </label>
                                    <label id="IsVoidLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Reason: </label>
                                    <label id="VoidReasonLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">By: </label>
                                    <label id="VoidedByLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Date: </label>
                                    <label id="VoidedDateLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Transaction Date: </label>
                                    <label id="TransactionDateLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Status: </label>
                                    <label id="StatusLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Withold Percent: </label>
                                    <label id="WitholdPercentLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Withold: </label>
                                    <label id="WitholdAmountLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Discount Percent: </label>
                                    <label id="DiscountPercentLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;" id="">Discount : </label>
                                    <label id="DiscountAmountLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Sub Total: </label>
                                    <label id="SubTotalLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Tax: </label>
                                    <label id="TaxLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Grand Total: </label>
                                    <label id="GrandTotalLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                <div class="row">
                                    <label strong style="font-size: 12px;">Username: </label>
                                    <label id="UsernameLbl" strong style="font-size: 12px;" class="badge badge-success"></label>
                                </div>
                                
                                

                            </div>
                        </div>
                    </div>
                </div>


        </div>
    </div>
</div>

<!--  end of info show madal  -->


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
                        <input type="hidden" placeholder="id" class="form-control" name="did" id="did">
                        <input type="hidden" placeholder="hhaderid" class="form-control" name="hid" id="hid">
                        <span class="text-danger">
                            <strong id="uname-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="deleteBtn" type="button" class="btn btn-info">Delete</button>
                    <button id="deleteBtnsaleItemChild" type="button" class="btn btn-info">Delete </button>
                    <button id="deleteBtnItemChild" type="button" class="btn btn-info">Delete</button>
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->
            
   <!--Start Info Modal -->
<div class="modal fade text-left" id="docInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="holdInfo">
                @csrf
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <input type="hidden" placeholder="" class="form-control" name="statusid" id="statusid" readonly="true">
                                    <table class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <tr>
                                            
                                            <th><label strong style="font-size: 14px;">Customer Category</label></th>
                                            <th><label strong style="font-size: 14px;">Customer Name</label></th>
                                            <th><label strong style="font-size: 14px;">Payment Type</label></th>
                                            <th><label strong style="font-size: 14px;">Voucher Type</label></th>
                                            <th><label strong style="font-size: 14px;">Voucher No.</label></th>
                                            <th><label strong style="font-size: 14px;">Withold Reciept.</label></th>
                                            <th><label strong style="font-size: 14px;">Vat Reciept.</label></th>
                                            <th><label strong style="font-size: 14px;">Point Of Sales.</label></th>
                                            <th><label strong style="font-size: 14px;">Date</label></th>
                                            <th><label strong style="font-size: 14px;">Prepared By</label></th>
                                            <th><label strong style="font-size: 14px;">Checked By</label></th>
                                            <th><label strong style="font-size: 14px;">Checked Date</label></th>
                                            <th><label strong style="font-size: 14px;">Confirmed By</label></th>
                                            <th><label strong style="font-size: 14px;">Confirmed Date</label></th>
                                            <th><label strong style="font-size: 14px;">Change To Pending By</label></th>
                                            <th><label strong style="font-size: 14px;">Change To Pending Date</label></th>
                                            <th><label strong style="font-size: 14px;">Void By</label></th>
                                            <th><label strong style="font-size: 14px;">Void Date</label></th>
                                            <th><label strong style="font-size: 14px;">Unvoid By</label></th>
                                            <th><label strong style="font-size: 14px;">UnVoid Date</label></th>
                                            <th><label strong style="font-size: 14px;">Created Date</label></th>
                                        </tr>
                                        <tr>
                                            
                                                
                                            <td><label id="infoDocCustomerCategory" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocCustomerName" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocPaymentType" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocVoucherType" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocVoucherNumber" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDowitholdNumber" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocVatNumber" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocsaleShop" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocDate" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoDocholdby" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoCheckedby" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoCheckedDate" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoConfirmedby" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoConfirmedDate" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoPendingby" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infoPendingDate" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infovoidby" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infovoidate" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infounvoidby" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infunvoiddate" strong style="font-size: 12px;"></label></td>
                                            <td><label id="infocreateddate" strong style="font-size: 12px;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="divider">
                            <div class="divider-text">Detail Information</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="table-responsive">
                                    <div id="holdtable">
                                      <table id="docInfoholdItem" class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <thead>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>SKU No.</th>
                                                    <th>Quantity</th>
                                                    <th id="itemheadinfohold">D Price</th>
                                                    <th>Unitprice</th>
                                                    <th>Discount</th>
                                                    <th>Before Tax</th>
                                                    <th>Tax Amount</th>
                                                    <th>Total Price</th>
                                        </thead>
                                       </table>
                                    </div>
                                    <div id="saletable">
                                     <table id="docInfosaleItem" class="table table-bordered table-striped table-hover dt-responsive table mb-0">
                                        <thead>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>SKU #</th>
                                            <th>Quantity</th>
                                            <th id="itemheadinfo">D price</th>
                                            <th>Unitprice</th>
                                            <th>Discount</th>
                                            <th>Before Tax</th>
                                            <th>Tax Amount</th>
                                            <th>Total Price</th>
                                        </thead>
                                     </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table style="width:100%;" id="infopricingTable">
                                <tr>
                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Sub Total:</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infosubtotalLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infosubtotali" id="infosubtotali" readonly="true" value="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Tax:</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infotaxLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infotaxi" id="infotaxi" readonly="true" value="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Grand Total:</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infograndtotalLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infograndtotali" id="infograndtotali" readonly="true" value="0"/>
                                    </td>
                                </tr>
                                

                                <tr id="infowitholdingTr">
                                    <td style="text-align: right;"><label id="infowithodingTitleLbl" strong style="font-size: 16px;">Witholding:</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infowitholdingAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infowitholdingAmntin" id="infowitholdingAmntin" readonly="true" value="0"/>
                                    </td>
                                </tr>
                                <tr id="infovatTr">
                                    <td style="text-align: right;"><label id="infovatTitleLbl" strong style="font-size: 16px;">Vatt:</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infovatAmntLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infovatAmntin" id="infovatAmntin" readonly="true" value="0"/>
                                    </td>
                                </tr>
                                <tr id="infonetpayTr">
                                    <td style="text-align: right;"><label strong style="font-size: 16px;">Net Pay:</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infonetpayLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infonetpayin" id="infonetpayin" readonly="true" value="0"/>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                       ---------------------------------
                                    </td>
                                </tr>
                                <tr id="infodiscountTr" style="">
                                    <td style="text-align: right;"><label id="infodiscountamountextLbl" strong style="font-size: 16px;color:#dc3545;">Discount :</label></td>
                                    <td style="text-align: right; width:10%">
                                        <label id="infodiscountLbl" class="formattedNum" strong style="font-size: 16px; font-weight: bold;color:#dc3545;"></label>
                                        <input type="hidden" placeholder="" class="form-control" name="infodiscountin" id="infodiscountin" readonly="true" value="0"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items:</label></td>
                                    <td style="text-align: right; width:10%"><label id="infonumberofItemsLbl" strong style="font-size: 16px; font-weight: bold;"></label></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @can('sale-pending')
                    <button id="changetopending" type="button" class="btn btn-info">Change to Pending</button>
                   @endcan
                   @can('sale-check')
                    <button id="checksales" type="button" onclick="getCheckInfoConf()" class="btn btn-info">Check Sale</button>
                    @endcan
                    @can('sale-confirm')
                    <button id="confirmsales" type="button" class="btn btn-info">Confirm Sale</button>
                    @endcan
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Hold Info -->

<!--Start Check Receiving modal -->
<div class="modal fade text-left" id="receivingcheckmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="checkreceivingform">
                {{ csrf_field() }}
                <div class="modal-body" style="background-color:#f6c23e">
                    <label id="confirmLbl" strong style="font-size: 16px;">Are you sure you want Check Sales</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="checkedid" id="checkedid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="checkedst" id="checkedst" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="currentstatus" id="currentstatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="currentstore" id="currentstore" readonly="true">

                    </div>
                     <div class="form-group" id="voucherNumberDive">
                    <label strong style="font-size: 14px;">Enter Voucher Number</label>
                  
                    <input type="number" placeholder="Enter Voucher Number" class="form-control" name="undoVoucherNumber" id="undoVoucherNumber" onkeypress="removeundoVoucherNumberError();" autofocus/>
                                        <span class="text-danger">
                                            <strong id="undoVoucherNumber-error"></strong>
                                        </span>

                                        </div>
                </div>
                <div class="modal-footer">
                    <button id="checkedbtnvoid" type="button" class="btn btn-info">Void</button>
                    <button id="checkedbtnunvoid" type="button" class="btn btn-info">Undo Void</button>
                    <button id="checkedbtnpending" type="button" class="btn btn-info">Change to Pending</button>
                    <button id="checkedbtnsale" type="button" class="btn btn-info">Check Sales</button>
                    <button id="checkedbtnconfirm" type="button" class="btn btn-info">Confirm Sales</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeundoVoucherNumberErrorclose();">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- End Check Receiving modal --> 

<!-- Start refund modal -->
<div class="modal fade text-left" id="refundreasonmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="refundreasonform">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label strong style="font-size: 16px;">Are you sure you want Refund Sales</label>
                    </div>
                    <div class="divider">
                        <div class="divider-text">Reason</div>
                    </div>
                    <label strong style="font-size: 16px;"></label>
                    <div class="form-group">
                        <textarea type="text" placeholder="Write Reason here..." class="form-control" rows="3" name="Reason" id="Reason" onkeyup="voidReason()"></textarea>
                        <span class="text-danger">
                            <strong id="reason-error"></strong>
                        </span>
                    </div>
                    <div class="form-group">
                        <input type="hidden" placeholder="" class="form-control" name="refundid" id="refundid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="refundtatus" id="refundtatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="refundcurrentstatus" id="refundcurrentstatus" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="refundbtn" type="button" class="btn btn-info">Refund</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="voidReason()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End refund modal  --}}

{{-- Start vat modal --}}
<div class="modal fade text-left" id="vatmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="vatmodaltitle">Receipt Form</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="vatform">
                @csrf
                <div class="modal-body">
                  <div id="witholdiv"> 
                     <div class="form-group">
                            <label strong style="font-size: 16px;" id="withldamountTitleLbl">Enter Withold Receipt Number</label>
                            </div>
                            <label strong style="font-size: 16px;" id="witholdAmountLbl">Withold Amount</label>
                            <div class="form-group">
                            <input type="text" placeholder="Enter Reciept Number" class="form-control" name="witholdNumber" id="witholdRecieptNumber" onkeypress="witholdRecieptNumberError();" ondblclick="withholdActive();" autofocus/>
                            <span class="text-danger">
                                <strong id="witholdRecieptNumber-error"></strong>
                            </span>
                        </div>
                 </div>
                

                    <div id="vatdiv">

                      <div class="form-group">
                        <label strong style="font-size: 16px;" id="vatamountTitleLbl">Enter Vat Reciept Number</label>
                      </div>
                   
                      <label strong style="font-size: 16px;" id="vatAmountLbl">Vat Amount</label>
                      <div class="form-group">
                      <input type="text" placeholder="Enter Reciept Number" class="form-control" name="vatNumber" id="vatNumber" onkeypress="removeRecieptnumberError();" ondblclick="vatActive();" autofocus/>
                        <span class="text-danger">
                            <strong id="Recieptnumber-error"></strong>
                        </span>
                     </div>

                    </div>
                    <div class="form-group">
                      <input type="hidden" placeholder="Withold Amount" class="form-control" name="vatAmountvalue" id="vatAmountvalue" readonly="true" value='0'>
                       <input type="hidden" placeholder="Withold Amount" class="form-control" name="witholdAmountvalue" id="witholdAmountvalue" readonly="true" value='0'>
                        <input type="hidden" placeholder="Netpay " class="form-control" name="netpayvlaue" id="netpayvlaue" readonly="true" value='0'>
                        <input type="hidden" placeholder="" class="form-control" name="recieptid" id="recieptid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="customerid" id="customerid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="recipstatus" id="recipstatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="recipstatuscurrent" id="recipstatuscurrent" readonly="true">

                        <input type="hidden" placeholder="" class="form-control" name="witholdRecieptNumberid" id="witholdRecieptNumberid" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="witholdRecieptNumberStatus" id="witholdRecieptNumberStatus" readonly="true">
                        <input type="hidden" placeholder="" class="form-control" name="witholdRecieptNumberStatusc" id="witholdRecieptNumberStatusc" readonly="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="vatbtn" type="button" class="btn btn-info">Save Changes</button>
                    <button id="closebutton" type="button" class="btn btn-danger" data-dismiss="modal" onclick="removeRecieptnumberError()">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- End vat modal  --}}



         


@endsection
@section('scripts')

<script type="text/javascript">

//start checkbox change function
$(function () {
        $("#hidewithold").click(function () {
            if ($(this).is(":checked")) {
            //    $('#hidewitholdi').val('0');   
            //    $('#hidevati').val('0');            
               $("#witholdingTr").hide();
               $("#vatTr").hide();
               $("#netpayTr").hide();
              // $("#hidewitholdTr").hide();
               
                
            } else {
                var vat=$('#vatAmntin').val();
                var withold=$('#witholdingAmntin').val();
                if(vat>0)
                {
                    $("#vatTr").show();
                }
                if(withold>0)
                {
                    $("#witholdingTr").show();
                }
            //  $('#hidewitholdi').val('0');
            //  $('#hidevati').val('0');
             $("#netpayTr").show();
            // $("#hidewitholdTr").hide();
               
            }
        });
    });
    //end checkbox change function
//Start Store events
$(document).ready(function () {
   
   

    $('#store').on ('change', function () {
        var sroreidvar = $('#store').val(); 
        $('.storeappend').val(sroreidvar); 

        var calhide=$("#calcutionhide").val();
        if(calhide==0)
        {
             $('#subtotalLbl').html('0.0');
             $('#taxLbl').html('0.0');
             $('#grandtotalLbl').html('0.0');
             $('#numberofItemsLbl').html('0');
		
		     $('#grandtotalLbl').text('0');
             $('#subtotali').val('0');
             $('#taxi').val('0');  
             $('#grandtotali').val('0');

             $("#witholdingTr").hide();
             $("#netpayTr").hide();
             $("#vatTr").hide(); 
             $("#hidewitholdTr").hide();
             $('#witholdingAmntin').val("0");
             $('#vatAmntin').val("0");
             $('#netpayin').val("0");
             $('#netpayLbl').html("0");
             $('#witholdingAmntLbl').html("0");
             $('#vatAmntLbl').html("0");
        }
           


    });
    $('#customerInfoCardDiv').hide();
        $('#itemInfoCardDiv').hide();
        $("#iteminfo").hide();

        


        // $("#witholdingTr").hide();
        // $("#netpayTr").hide();
        // $("#vatTr").hide(); 
});
//End Store events
//Start get customer info
$(document).ready(function () {
    
$(".selectpicker").selectpicker({
        noneSelectedText : ''
    });
    $('#customer').on ('change', function () {
        $('#customer-error').html('')
        $('#customerInfoCardDiv').show();
        $("#dynamicTable").empty();
        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th><th id="dprthead">D Price</th> <th>Unit Price</th>@can('sales-discount')<th>Discount</th>@endcan<th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>');
      
             $('#subtotalLbl').html('0.0');
             $('#taxLbl').html('0.0');
             $('#grandtotalLbl').html('0.0');
             $('#numberofItemsLbl').html('0');
		
		    $('#grandtotalLbl').text('0');
            $('#subtotali').val('0');
            $('#taxi').val('0');  
            $('#grandtotali').val('0');

            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $("#vatTr").hide(); 
            $("#hidewitholdTr").hide();
            $('#witholdingAmntin').val("00");
            $('#vatAmntin').val("0");
            $('#netpayin').val("0");
            $('#netpayLbl').html("0");
            $('#witholdingAmntLbl').html("0");
            $('#vatAmntLbl').html("0");


        

            var nm = $('#customer').val(); 
            var witholdsetle=$('#hidewitholdi').val();
            var vatsetled=$('#hidevati').val();
            console.log('id='+nm);
            if(nm!=null)
            {

                $.get("/showcustomer" +'/' + nm , function (data) 
            {     
            $('#cname').text(data.Name);
            $('#ccategory').text(data.CustomerCategory);
            $('#cdefaultPrice').text(data.DefaultPrice);
            $('#ctinNumber').text(data.TinNumber);
            $('#cvat').text(data.VatType+"%");
            $('#witholdPercenti').val(data.Witholding);
            $('#vatPercenti').val(data.VatType);

            if(witholdsetle=='0')
            {
              $('#withodingTitleLbl').html("<p style='color:#f0ad4e;'><b>Not Settled </b>Withold Deduction  ("+data.Witholding+"%):</p>");
            }
            if(witholdsetle=='1')
            {
                $('#withodingTitleLbl').html("<p style='color:#f0ad4e;'><b>Withold Deduction</b> ("+data.Witholding+"%):</p>");
            }
            if(vatsetled=='0')
            {
            $('#vatTitleLbl').html("<p style='color:#f0ad4e;'<b> Not Settled </b>Vat Deduction ("+data.VatType+"%):</p>");
            }
            if(vatsetled=='1')
            {
            // $('#vatTitleLbl').html("<p style='color:#f0ad4e;'<b>Vat Deduction</b> ("+data.VatType+"%):</p>");
             $('#vatTitleLbl').html("<p style='color:#f0ad4e;'><b>Vat Deduction</b> ("+data.VatType+"%):</p>");
            }

           $('#cwithold').html(data.Witholding+"%");          
            calculateIndividaulGrandTotal();
    
      });
            }

            
     

    });

    $('#Retailcustomer').on ('change', function () {
        $('#Retailcustomer-error').html('')
        $('#customerInfoCardDiv').show();
        $("#dynamicTable").empty();
        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th> <th id="dprthead">D Price</th><th>Unit Price</th>@can('sales-discount')<th>Discount</th>@endcan<th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>');
      
            

            var nm = $('#Retailcustomer').val(); 

            //console.log('id='+nm);
            var witholdsetle=$('#hidewitholdi').val();
         var vatsetled=$('#hidevati').val();

            if(nm!=null)
            {
                $.get("/showcustomer" +'/' + nm , function (data) 
            {     
            $('#cname').text(data.Name);
            $('#ccategory').text(data.CustomerCategory);
            $('#cdefaultPrice').text(data.DefaultPrice);
            $('#ctinNumber').text(data.TinNumber);
            $('#cvat').text(data.VatType+"%");
            $('#witholdPercenti').val(data.Witholding);
            $('#vatPercenti').val(data.VatType);
            // $('#withodingTitleLbl').html("Witholding ("+data.Witholding+"%):");
            // $('#vatTitleLbl').html("Vat ("+data.VatType+"%):");
            if(witholdsetle=='0')
            {
              $('#withodingTitleLbl').html("<p style='color:#f0ad4e;'><b>Not Settled </b>Withold Deduction  ("+data.Witholding+"%):</p>");
            }
            if(witholdsetle=='1')
            {
                $('#withodingTitleLbl').html("<p style='color:#f0ad4e;'><b>Withold Deduction</b> ("+data.Witholding+"%):</p>");
            }
            if(vatsetled=='0')
            {
            $('#vatTitleLbl').html("<p style='color:#f0ad4e;'<b> Not Settled </b>Vat Deduction ("+data.VatType+"%):</p>");
            }
            if(vatsetled=='1')
            {
            // $('#vatTitleLbl').html("<p style='color:#f0ad4e;'<b>Vat Deduction</b> ("+data.VatType+"%):</p>");
             $('#vatTitleLbl').html("<p style='color:#f0ad4e;'><b>Vat Deduction</b> ("+data.VatType+"%):</p>");
            }
            $('#cwithold').html(data.Witholding+"%");  
            calculateIndividaulGrandTotal();
           });

            }
           
    });
         $('#Wholesellercustomer').on ('change', function () {
        $('#Wholesellercustomer-error').html('')
        $('#customerInfoCardDiv').show();
        $("#dynamicTable").empty();
        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th> <th id="dprthead">D Price</th><th>Unit Price</th>@can('sales-discount')<th>Discount</th>@endcan<th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>');
      
            var nm = $('#Wholesellercustomer').val(); 
            var witholdsetle=$('#hidewitholdi').val();
            var vatsetled=$('#hidevati').val();
            console.log('id='+nm);
            if(nm!=null)
            {
                $.get("/showcustomer" +'/' + nm , function (data) 
                            {     
                            $('#cname').text(data.Name);
                            $('#ccategory').text(data.CustomerCategory);
                            $('#cdefaultPrice').text(data.DefaultPrice);
                            $('#ctinNumber').text(data.TinNumber);
                            $('#cvat').text(data.VatType+"%");
                            $('#witholdPercenti').val(data.Witholding);
                            $('#vatPercenti').val(data.VatType);
                            // $('#withodingTitleLbl').html("Witholding ("+data.Witholding+"%):");
                            // $('#vatTitleLbl').html("Vat ("+data.VatType+"%):");
                            if(witholdsetle=='0')
            {
              $('#withodingTitleLbl').html("<p style='color:#f0ad4e;'><b>Not Settled </b>Withold Deduction  ("+data.Witholding+"%):</p>");
            }
            if(witholdsetle=='1')
            {
                $('#withodingTitleLbl').html("<p style='color:#f0ad4e;'><b>Withold Deduction</b> ("+data.Witholding+"%):</p>");
            }
            if(vatsetled=='0')
            {
            $('#vatTitleLbl').html("<p style='color:#f0ad4e;'<b> Not Settled </b>Vat Deduction ("+data.VatType+"%):</p>");
            }
            if(vatsetled=='1')
            {
            // $('#vatTitleLbl').html("<p style='color:#f0ad4e;'<b>Vat Deduction</b> ("+data.VatType+"%):</p>");
             $('#vatTitleLbl').html("<p style='color:#f0ad4e;'><b>Vat Deduction</b> ("+data.VatType+"%):</p>");
            }
                            $('#cwithold').html(data.Witholding+"%");  
                            calculateIndividaulGrandTotal();
                    });
            }
    });
     });
//End get customer info


    $('#add').click(function(){  
    var i=1;  
           i++;  
         
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text" name="namess[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  

    });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      }); 

      $('#changetopending').click(function(){ 
            var headid=$('#statusid').val();
          console.log('head id='+headid);
        $('#checkedid').val(headid);
        $('#checkedst').val('pending..');
        $('#checkedbtnconfirm').text('Change To Pending ');
        $('#confirmLbl').text('Are you sure you want to Change to Pending..');
        $("#receivingcheckmodal").modal('show');
        $("#voucherNumberDive").hide();
        $("#checkedbtnsale").hide();
        $("#checkedbtnconfirm").hide();
        $("#checkedbtnpending").show();
        $("#checkedbtnvoid").hide();
        $("#checkedbtnunvoid").hide();
      });

      $('#checksales').click(function(){ 
            var headid=$('#statusid').val();
          console.log('head id='+headid);
          $('#checkedid').val(headid);
          $('#checkedst').val('Checked');
          $("#receivingcheckmodal").modal('show');
          $('#confirmLbl').text('Are you sure you want Check Sales ');
         $("#checkedbtnsale").show();
         $("#checkedbtnconfirm").hide();
         $("#voucherNumberDive").hide();
        $("#checkedbtnpending").hide();
        $("#checkedbtnvoid").hide();
        $("#checkedbtnunvoid").hide();

      });

      $('#confirmsales').click(function(){ 
         var headid=$('#statusid').val();
          console.log('head id='+headid);
          $('#checkedbtnconfirm').text('Confirm Sales ');
          $('#confirmLbl').text('Are you sure you want Confirm Sales ');
          $('#checkedid').val(headid);
          $('#checkedst').val('Confirmed');
         $("#receivingcheckmodal").modal('show');
         $("#checkedbtnsale").hide();
         $("#voucherNumberDive").hide();
         $("#checkedbtnconfirm").show();
        $("#checkedbtnpending").hide();
        $("#checkedbtnvoid").hide();
        $("#checkedbtnunvoid").hide();
      });


      $('#checkedbtnpending').click(function(){ 

        //console.log('checked bnt sale is clicked');
        $('#checkedbtnpending').prop( "disabled", true );
        var headid=$('#statusid').val();
        console.log('hid='+headid);

        $.get("/showSale" +'/' + headid , function (data) 
        { 
                    
                    var status=data.sale.Status;
                    if(status=='Confirmed')
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already Confirmed");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                   // $('#laravel-datatable-crud').DataTable().ajax.reload();

                    }
                    else if(status=='Void')
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already Void");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    }
                    else if(status=="pending..")
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already on Pending Status");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    }
                    else
                    {
                        var registerForm = $("#checkreceivingform");
                     var formData = registerForm.serialize();   

        $.ajax({
        url:'/checkedsale/'+headid,
        type:'DELETE',
        data:formData,
        beforeSend:function(){$('#checkedbtnpending').text('Pending...');},
        success:function(data) {

                if(data.success)
                {
                    if(data.success)
                {
        $('#checkedbtnpending').prop( "disabled", false );
        $('#checkedbtnconfirm').text('Change To Pending ');
        $("#myToast").toast({ delay: 4000 });
        $("#myToast").toast('show');
        $('#toast-massages').html("Sale  Pending Successfully");
        $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
        $("#receivingcheckmodal").modal('hide');
        $("#docInfoModal").modal('hide');
        $("#checkreceivingform")[0].reset();
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
                }
            }

        },
        });


                    }


        });
        
       
});


      $('#checkedbtnconfirm').click(function(){ 

    // console.log('checked bnt sale is clicked');
    $('#checkedbtnconfirm').prop( "disabled", true );

    var headid=$('#statusid').val();
    console.log('hid='+headid);
    $.get("/showSale" +'/' + headid , function (data) 
        { 
                    
                    var status=data.sale.Status;
                  //  alert(status);
                    if(status=='Confirmed')
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already Confirmed");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                   // $('#laravel-datatable-crud').DataTable().ajax.reload();

                    }
                    else if(status=='Void')
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already Void");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    }
                    else
                    {
                        var registerForm = $("#checkreceivingform");
                     var formData = registerForm.serialize();    
                     $.ajax({
                     url:'/checkedsale/'+headid,
                     type:'DELETE',
                     data:formData,
                     beforeSend:function(){$('#checkedbtnconfirm').text('Confirm...');
                    
                        },
                     success:function(data) {

                                if(data.success)
                                {
                                    if(data.success)
                                {
         $('#checkedbtnconfirm').prop( "disabled", false );
         $('#checkedbtnconfirm').text('Confirm Sales ');
         $("#myToast").toast({ delay: 4000 });
         $("#myToast").toast('show');
         $('#toast-massages').html("Sale  confirmed Successfully");
         $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
         $("#receivingcheckmodal").modal('hide');
         $("#docInfoModal").modal('hide');
        
        $("#checkreceivingform")[0].reset();
        var oTable = $('#laravel-datatable-crud').dataTable(); 
        oTable.fnDraw(false);
                }
                
            }
            if(data.valerror)
                {
                    $('#checkedbtnconfirm').prop( "disabled", false);
                    var singleVal='';
                    var loopedVal='';
                    var len=data['valerror'].length;
                    for(var i=0;i<=len;i++) 
                    {  
                        var count=data.countedval;
                        var inc=i+1;
                        singleVal=(data['countItems'][i].Name);
                        loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                        $('#checkedbtnconfirm').text('Confirm Sales ');
                      //  $('#conissuetrbtn').prop( "disabled", false );
                        $("#myToast").toast({ delay: 10000000 });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("There is no available quantity for "+count+"  Items"+loopedVal);
                        $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                        $("#receivingcheckmodal").modal('hide');
                        $("#checkreceivingform")[0].reset();
                    }    

                }

        },
  });

                    }

        });

   
});


      $('#checkedbtnsale').click(function(){ 

      //  console.log('checked bnt sale is clicked');
      $('#checkedbtnsale').prop("disabled", true);
        var headid=$('#statusid').val();
        console.log('hid='+headid);


        $.get("/showSale" +'/' + headid , function (data) 
             { 
                    
                    var status=data.sale.Status;
                    if(status=='Confirmed')
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already Confirmed");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                   // $('#laravel-datatable-crud').DataTable().ajax.reload();

                    }
                    else if(status=='Void')
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already Void");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    }
                    else if(status=="Checked")
                    {
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sales already on Checked Status");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#receivingcheckmodal").modal('hide');
                    $("#docInfoModal").modal('hide');
                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                    oTable.fnDraw(false);
                    }
                    else
                    {
                        var registerForm = $("#checkreceivingform");
                         var formData = registerForm.serialize();   
          
                        $.ajax({
                        url:'/checkedsale/'+headid,
                        type:'DELETE',
                        data:formData,
                        beforeSend:function(){$('#checkedbtnsale').text('checking...');
                        },
                        success:function(data) {

                        if(data.success)
                        {
                      if(data.success)
                      {
                        $('#checkedbtnsale').prop( "disabled", false);
                        $('#checkedbtnsale').text('Check Sales ');
                        $("#myToast").toast({ delay: 4000 });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Sale  Checked Successfully");
                        $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                        $("#receivingcheckmodal").modal('hide');
                        $("#docInfoModal").modal('hide');
              
                        $("#checkreceivingform")[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                      }
                  }

                },
          });


                    }

        });
        
      });

//button save to sales
$('#savebutton').click(function(){       
    var cust = customer.value;
    var custr = Retailcustomer.value;
    var custw = Wholesellercustomer.value;
    var storeval = store.value;
    var voucherTypeVal=voucherType.value; 
    var CustomerMRCVal=CustomerMRC.value;
    var paymentTypeval=paymentType.value;


      var arr = [];

      var found = 0;
       $('.eName').each (function() { 

           var name=$(this).val();

           console.log("ename="+name);

              if(arr.includes(name))
               found++;
                  else
                   arr.push(name);

                       });
                  if(found) 
                  {
                   console.log('found');
                   $("#myToast").toast({ delay: 10000 });
                   $("#myToast").toast('show');
                   $('#toast-massages').html("Item Name Can't Duplicate");
                   $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});   

                  }
                   if(cust=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("Invalid customer Selection");
                 $( '#customer-error' ).html("Invalid customer Selection");
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }
                 

                 if(storeval=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("Invalid Store Selection");
                 $( '#store-error' ).html('Invalid Store Selection');
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }

             

                if(found==0)
                       {
                       
                console.log('unique');
             var headid=$('#id').val();
             var numofitems=$('#numberofItemsLbl').text();
             var registerForm = $("#Register");
             var formData = registerForm.serialize();   
          
                if(voucherTypeVal=="Fiscal-Receipt" &&  CustomerMRCVal=='')
                {
                
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("Invalid Mrc Selection");
                $( '#CustomerMRC-error' ).html('For Fiscal Reciept MRC Is Required');
                $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
            
                }
              else if(cust=="2" && paymentTypeval=='Credit')
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("You can not Select credit payment for Walking customer");
                 $( '#paymenttype-error' ).html("Invalid Payment type Selection");
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }
                else if(custr=="2" && paymentTypeval=='Credit')
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("You can not Select credit payment for Walking customer");
                 $( '#paymenttype-error' ).html("Invalid Payment type Selection");
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }

                else
                {
                 $.ajax({
                 url:'/savesale',
                 type:'POST',
                 data:formData,
                 beforeSend:function(){
                  $('#savebutton').text('Saving sale...');
                  $('#savebutton').prop('disabled',true);
                  },
                 success:function(data) {

                  if(data.success)
                  {
                      $('#savebutton').prop('disabled',false);
                      closeinlineFormModalWithClearValidation();
                      if(data.success)
                      {
               
                        $('#savebutton').text('Save ');
                        $("#myToast").toast({ delay: 4000 });
                        $("#myToast").toast('show');
                        $('#toast-massages').html("Sale  Saved Successfully");
                        $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                        $("#inlineForm").modal('hide');
                        $("#dynamicTable").empty();
                        $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th><th id="dprthead">D Price</th> <th>Unit Price</th>@can('sales-discount')<th>Discount</th>@endcan<th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>');
                        ///$("#pricetable").hide();
                        $("#Register")[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        $('#customer').val(null).trigger('change');

                      }
                  }

                  if(data.errors)
                  {
                            $('#savebutton').text('Save');
                            $('#savebutton').prop('disabled',false);
                            if(data.errors.customer){
                            $( '#customer-error' ).html( data.errors.customer[0] );
                            }
                            if(data.errors.paymentType){
                                $( '#paymenttype-error' ).html( data.errors.paymentType[0] );
                            }
                            if(data.errors.voucherType){
                                $( '#vouchertype-error' ).html( data.errors.voucherType[0] );
                            }
                            if(data.errors.voucherNumber){
                                $( '#vouchernumber-error' ).html( data.errors.voucherNumber[0] );
                            }
                            if(data.errors.date){
                                $( '#date-error' ).html( data.errors.date[0] );
                            }
                            if(data.errors.store){
                                $( '#store-error' ).html( data.errors.store[0] );
                            }

                  }
                    // if(headid=='')
                    // {
                        if(numofitems==0)
                {
                    $('#savebutton').text('Save');
                    $('#savebutton').prop('disabled',false);
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("You should add atleast one item");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                }
                    
                 
                    if(data.dberrors)
                    {
                        $('#savebutton').text('Save');
                        $('#savebutton').prop('disabled',false);
                        $( '#vouchernumber-error' ).html('This Voucher Number Has All Ready Taken');
                    }

                  if(data.errorv2)
                  {
                      
                            var error_html = '';
                             for(var count = 0; count < data.errorv2.length; count++)
                         {
                            error_html += '<p>'+data.errorv2[count]+'</p>';
                         }
                   
                            $('#savebutton').text('Save');
                            $('#savebutton').prop('disabled',false);
                            $("#myToast").toast({ delay: 10000 });
                            $("#myToast").toast('show');
                            $('#toast-massages').html(error_html);
                            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"})

                    }


                },
          });
                       }
      }


  });

    $('#savebuttoncopy').click(function()
            { 
  
                var cust = customer.value;
                 var storeval = store.value;
                 var voucherTypeVal=voucherType.value; 
                 var CustomerMRCVal=CustomerMRC.value;	
                
                var hid=$('#id').val();
                var numbercount=$('#numberofItemsLbl').text();
                var numbercounti=$('#numbercounti').val();

                console.log('header id='+hid);
                console.log('number count='+numbercount);

                if(numbercounti==0)
                {
                    $('#savebuttoncopy').text('Save');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("You should add atleast one item");
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                }

              else if(cust=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("Invalid customer Selection");
                 $( '#customer-error' ).html("Invalid customer Selection");
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }
                else if(storeval=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("Invalid Store Selection");
                 $( '#store-error' ).html('Invalid Store Selection');
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }

                else if(voucherTypeVal=="Fiscal-Receipt" &&  CustomerMRCVal=='')
                {
                
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("Invalid Mrc Selection");
                $( '#CustomerMRC-error' ).html('For Fiscal Reciept MRC Is Required');
                $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
              
                }

                else
                {

                var registerForm = $("#Register");
                var formData = registerForm.serialize();   
                

                $.ajax({
                    url:'/saveholdcopy',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
                        $('#savebuttoncopy').text('saving...');
                        $('#savebuttoncopy').prop('disabled',true);
                        },
                    success:function(data) {


                        if(data.copydberrors)
                        {
                            $('#savebuttoncopy').prop('disabled',false);
                            $('#savebuttoncopy').text('Save');
                            $('#vouchernumber-error').html("The Voucher Number has been taken");
                        }
                    if(data.errors)
                    {
                        $('#savebuttoncopy').prop('disabled',false);
                        $('#savebuttoncopy').text('Save');
                        if(data.errors.voucherNumber)
                        {
                            $('#vouchernumber-error').html( data.errors.voucherNumber[0]);
                        }
                        if(data.errors.date)
                        {
                            $('#date-error').html( data.errors.date[0]);
                        }
                        $('#store-error').html( data.errors.store[0]);
                        $('#vouchertype-error').html( data.errors.voucherType[0] );
                        $('#paymenttype-error').html( data.errors.paymentType[0] );
                        $('#customer-error').html( data.errors.customer[0] );
                        
                    }
                    if(data.valerror)
                            {
                                var singleVal='';
                                var loopedVal='';
                                var len=data['valerror'].length;
                                for(var i=0;i<=len;i++) 
                                {  
                                    var count=data.countedval;
                                    var inc=i+1;
                                    singleVal=(data['countItems'][i].Name);
                                    loopedVal=loopedVal+"</br>"+inc+" ) "+singleVal;
                                    $('#savebuttoncopy').text('Save');
                                    $('#savebuttoncopy').prop( "disabled", false );
                                    $("#myToast").toast({ delay: 10000000 });
                                    $("#myToast").toast('show');
                                    $('#toast-massages').html("There is no available quantity for "+count+" Item(s) "+loopedVal);
                                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                                    $("#inlineForm").modal('hide');
                                    var oTable = $('#laravel-datatable-crud').dataTable(); 
                                    oTable.fnDraw(false);
                                    var holdTable = $('#datatable-crud-bl').dataTable(); 
                                   holdTable.fnDraw(false);
                                    $("#Register")[0].reset();
                                    closeinlineFormModalWithClearValidation();
                                }    
                            }

                    if(data.copySuccess)
                    {
                        
                            $('#savebuttoncopy').text('save');
                            $('#savebuttoncopy').prop('disabled',false);
                            $("#myToast").toast({ delay: 4000 });
                            $("#myToast").toast('show');
                            $('#toast-massages').html(" Hold data copyed Successfully");
                            $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                            $("#inlineForm").modal('hide');
                            $("#Register")[0].reset();
                            var oTable = $('#laravel-datatable-crud').dataTable(); 
                            oTable.fnDraw(false);
                            var holdTable = $('#datatable-crud-bl').dataTable(); 
                            holdTable.fnDraw(false);
                            closeinlineFormModalWithClearValidation();
                            
                    }

                      
                       

                      },
                });

                } // end of else
                

            });

     // savebuttonhold
         $('#savebuttonhold').click(function(){       
      
            var storeval = store.value;

            var arr = [];

            var found = 0;
             $('.eName').each (function() { 

                 var name=$(this).val();

                 console.log("ename="+name);

                    if(arr.includes(name))
                     found++;
                        else
                         arr.push(name);

                             });
                        if(found) 
                        {
                         console.log('found');
                         $("#myToast").toast({ delay: 10000 });
                         $("#myToast").toast('show');
                         $('#toast-massages').html("Item Name Can't Duplicate");
                         $('.toast-body').css({"background-color": "	#dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});   
                        }

                

                        
                 if(found==0)
                       {
                console.log('unique');
                var registerForm = $("#Register");
                var formData = registerForm.serialize();   
              
                $.ajax({
                    url:'/savehold',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
                        $('#savebuttonhold').text('holding...');
                        $('#savebuttonhold').prop('disabled',true);
                        },
                    success:function(data) {

                        if(data.success)
                        {
                            closeinlineFormModalWithClearValidation();
                            if(data.success)
                            {
                    $('#savebuttonhold').prop('disabled',false);
                    $('#savebuttonhold').text('Hold');
                    $("#myToast").toast({ delay: 4000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Sale Hold Saved Successfully");
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#inlineForm").modal('hide');
                    $("#Register")[0].reset();
                    var oTable = $('#datatable-crud-bl').dataTable(); 
                    oTable.fnDraw(false);
                            }
                        }
                        if(data.dberrors)
                        {
                            $('#savebuttonhold').text('Hold');
                            $('#savebuttonhold').prop('disabled',false);

                        }
                        if(data.errors)
                        {
                            $('#savebuttonhold').text('Hold');
                            $('#savebuttonhold').prop('disabled',false);
                            if(data.errors.customer){
                             $( '#customer-error' ).html( data.errors.customer[0] );
                    }
                    if(data.errors.paymentType){
                        $( '#paymenttype-error' ).html( data.errors.paymentType[0] );
                    }
                    if(data.errors.voucherType){
                        $( '#vouchertype-error' ).html( data.errors.voucherType[0]);
                    }
                    if(data.errors.voucherNumber){
                        $( '#vouchernumber-error' ).html( data.errors.voucherNumber[0]);
                    }
                    if(data.errors.date){
                        $( '#date-error' ).html( data.errors.date[0]);
                    }
                    if(data.errors.store){
                        $( '#store-error' ).html( data.errors.store[0] );
                    }

                        }

                        if(data.errorv2)
                        {
                            $('#savebuttonhold').prop('disabled',false);
                            var error_html = '';
                            for(var count = 0; count < data.errorv2.length; count++)
                             {
                            error_html += '<p>'+data.errorv2[count]+'</p>';
                             }
                           
                           $('#savebuttonhold').text('Hold');
                            $('#savebuttonhold').prop('disabled',false);
                            $("#myToast").toast({ delay: 10000 });
                            $("#myToast").toast('show');
                            $('#toast-massages').html(error_html);
                            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"})

                             }

                      },
                });
            }
    

        });

        $('#savebuttonsaleitem').click(function(){  
                var registerForm = $("#itemRegisterForm");
                var formData = registerForm.serialize(); 

                $.ajax({
                    url:'/savesaleitem',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
                        $('#savebuttonsaleitem').text('Saving...');
                        $('#savebuttonsaleitem').prop('disabled',true);
                        },
                    success:function(data) {

                           if(data.errors)
                           {
                            $('#savebuttonsaleitem').prop('disabled',false);
                               if(data.errors.Quantity)
                               {
                                $('#Quantity-error' ).html( data.errors.Quantity[0]);
                               }
                               if(data.errors.UnitPrice)
                               {
                                $('#UnitPrice-error' ).html( data.errors.UnitPrice[0]);
                               }
                               if(data.errors.Discounts)
                               {
                                $('#discount-error' ).html( data.errors.Discounts[0]);
                               }
                               if(data.errors.ItemName)
                               {
                                $('#ItemName-error' ).html( data.errors.ItemName[0]);
                               }
                                if(data.errors.Type)
                                {
                                    $('#ItemType-error' ).html( data.errors.Type[0]);
                                }
                                $('#savebuttonsaleitem').text('Add');
                                
                               
                           }
                           if(data.dberrors)
                            {
                                $('#ItemName-error').html("The Item Name has already been taken.");
                                $('#savebuttonsaleitem').text('Add');
                                $('#savebuttonsaleitem').prop('disabled',false);
                                $("#myToast").toast({ delay: 10000 });
                                $("#myToast").toast('show');
                                $('#toast-massages').html("Check Your Inputs");
                                $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                            } 
                           
                           if(data.success)
                           {
                            $("#myToast").toast('show');
                            $('#toast-massages').html("Sale Item Updated Successfully");
                            $('#savebuttonsaleitem').text('Add');
                            $('#savebuttonsaleitem').prop('disabled',false);
                             $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
                            $('#IteminlineForm').modal('hide');
                            $("#hidewithold").prop( "checked", false);
                             var oTable = $('#datatable-crud-childsale').dataTable(); 
                             oTable.fnDraw(false);
                             $('#numberofItemsLbl').text(data.Totalcount);
                             $('#numbercounti').val(data.Totalcount);
                            var len=data.PricingVal.length;
                                for(var i=0;i<=len;i++)
                                {
                                    var DiscountAmounts=data.PricingVal[i].DiscountAmount;
                                    var beforetax=data.PricingVal[i].BeforeTaxPrice;
                                    var tax=parseFloat(beforetax)*15/100;
                                    var grandTotal=parseFloat(beforetax)+parseFloat(tax);
                                    $('#subtotalLbl').html(numformat(beforetax));
                                    $('#taxLbl').html(numformat(tax.toString().match(/^\d+(?:\.\d{0,2})?/)));  
                                    $('#grandtotalLbl').text(numformat(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)));
                                    $('#discountamountLbl').html(DiscountAmounts);
                                    $('#discountamountextLbl').html('Discount ('+data.PricingVal[i].DiscountPercent+'%):');
                                    $('#subtotali').val(data.PricingVal[i].BeforeTaxPrice);
                                    $('#taxi').val(tax.toString().match(/^\d+(?:\.\d{0,2})?/));  
                                    $('#grandtotali').val(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)); 
                                    $('#discountamountli').val(data.PricingVal[i].DiscountAmount); 
                                    $('#discountpercenti').val(data.PricingVal[i].DiscountPercent);
                                    
                                
                                    var discounthider=data.PricingVal[i].DiscountAmount;
                                 // alert(discounthider);
                                    if(parseFloat(discounthider)>0)
                                    {
                                        $("#discountTr").show();
                                    }
                                   else
                                    {
                                        $("#discountTr").hide();
                                    }
                                calculateIndividaulGrandTotal();

                                }
                                  

    
                           }
                    },
                });
            
               // calculateIndividaulGrandTotal();
        });

        $('#savebuttonitem').click(function(){  
                var registerForm = $("#itemRegisterForm");
                var formData = registerForm.serialize(); 

                $.ajax({
                    url:'/saveholditem',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
                        $('#savebuttonitem').text('Updating...');
                        $('#savebuttonitem').prop('disabled',true);
                        },
                    success:function(data) {

                           if(data.errors)
                           {
                           
                               if(data.errors.ItemName)
                               {
                                $( '#ItemName-error' ).html( data.errors.ItemName[0] );
                               }
                               if(data.errors.Quantity)
                               {
                                $( '#Quantity-error' ).html( data.errors.Quantity[0] );
                               }
                               if(data.errors.UnitPrice)
                               {
                                $('#UnitPrice-error' ).html( data.errors.UnitPrice[0] );
                               }
                               if(data.errors.Discounts)
                               {
                                $('#discount-error' ).html( data.errors.Discounts[0] );
                               }
                               if(data.errors.Type)
                               {
                                $('#ItemType-error' ).html( data.errors.Type[0] );  
                               }
                               $('#savebuttonitem').text('Add');
                               $('#savebuttonitem').prop('disabled',false);
                           } 
                           if(data.dberrors)
                           {
                            $('#savebuttonitem').text('Add');
                            $('#savebuttonitem').prop('disabled',false);
                            $( '#ItemName-error' ).html('Item Name Has All Ready Taken');   
                           }
                           if(data.success)
                           {
                            $("#myToast").toast('show');
                            $('#toast-massages').html("Hold Item Updated Successfully");
                            $('#savebuttonitem').text('Add');
                            $('#savebuttonitem').prop('disabled',false);
                             $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
                            $('#IteminlineForm').modal('hide');
                            
                            
                             var oTable = $('#datatable-crud-child').dataTable(); 
                             oTable.fnDraw(false);
                             $('#numberofItemsLbl').text(data.Totalcount);
                             $('#numbercounti').val(data.Totalcount);
                            var len=data.PricingVal.length;
                                for(var i=0;i<=len;i++)
                                {
                                    var beforetax=data.PricingVal[i].BeforeTaxPrice;
                                    var tax=parseFloat(beforetax)*15/100;
                                    var grandTotal=parseFloat(beforetax)+parseFloat(tax);
                                   
                                   

                                    $('#subtotalLbl').text(data.PricingVal[i].BeforeTaxPrice);
                                    // $('#taxLbl').text(data.PricingVal[i].TaxAmount);  
                                    // $('#grandtotalLbl').text(data.PricingVal[i].TotalPrice);
                                    $('#taxLbl').html(tax.toString().match(/^\d+(?:\.\d{0,2})?/)); 
                                    $('#grandtotalLbl').text(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/));
                                    $('#discountamountLbl').text(data.PricingVal[i].DiscountAmount);
                                    $('#discountamountextLbl').html('Discount ('+data.PricingVal[i].DiscountPercent+'%):');
                                    $('#subtotali').val(data.PricingVal[i].BeforeTaxPrice);
                                    // $('#taxi').val(data.PricingVal[i].TaxAmount);  
                                    // $('#grandtotali').val(data.PricingVal[i].TotalPrice);  
                                    $('#taxi').val(tax.toString().match(/^\d+(?:\.\d{0,2})?/));  
                                    $('#grandtotali').val(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)); 
                                    $('#discountamountli').val(data.PricingVal[i].DiscountAmount);  

                                    var discounthider=data.PricingVal[i].DiscountAmount;
                                //  alert(discounthider);
                                    if(parseFloat(discounthider)>0)
                                    {
                                        $("#discountTr").show();
                                    }
                                    else
                                    {
                                        $("#discountTr").hide();
                                    }

                                    calculateIndividaulGrandTotal();

                                }
                           }
                    },
                });
            
        });


        
        $('#deleteBtn').click(function(){ 

        var cid = document.forms['deletform'].elements['did'].value;
        var registerForm = $("#deletform"); 
        var formData = registerForm.serialize();
        //console.log('ccid=='+cid)
        $.ajax({
        url:'/saleholddelete/'+cid,
        type:'DELETE',
        data:formData,
        beforeSend:function(){
            $('#deleteBtn').text('Deleting sales...');
            $('#deleteBtn').prop('disabled',true);
        },
        success:function(data)
        {
            $("#myToast").toast('show');
            $('#toast-massages').html("Hold Sales Removed Successfully");
            $('#deleteBtn').text('Delete');
            $('#deleteBtn').prop('disabled',false);
            $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
            $('#examplemodal-delete').modal('hide');
            
            var oTable = $('#datatable-crud-bl').dataTable(); 
            oTable.fnDraw(false);
        }
       });


        });

$('#deleteBtnsaleItemChild').click(function(){ 
var cid = document.forms['deletform'].elements['did'].value;
var registerForm = $("#deletform"); 
var formData = registerForm.serialize();
//console.log('ccid=='+cid)
$.ajax({
url:'/saleitemdelete/'+cid,
type:'DELETE',
data:formData,
beforeSend:function(){
    $('#deleteBtnsaleItemChild').text('Deleting sale Item...');
    $('#deleteBtnsaleItemChild').prop('disabled',true);
    },
success:function(data)
{
    $("#myToast").toast('show');
    $('#toast-massages').html("Item Removed Successfully");
    $('#deleteBtnsaleItemChild').text('Delete ');
    $('#deleteBtnsaleItemChild').prop('disabled',false);
    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
    $('#examplemodal-delete').modal('hide');
    $("#hidewithold" ).prop( "checked", false);
    // $('#deletebtnconversion').text('Delete');
    var oTable = $('#datatable-crud-childsale').dataTable(); 
    oTable.fnDraw(false);
        $('#numberofItemsLbl').text(data.Totalcount);
        $('#numbercounti').val(data.Totalcount);
        var len=data.PricingVal.length;
         for(var i=0;i<=len;i++)
         {

            var beforetax=data.PricingVal[i].BeforeTaxPrice;
            var tax=parseFloat(beforetax)*15/100;
            var grandTotal=parseFloat(beforetax)+parseFloat(tax);

            
            

            $('#subtotalLbl').text(numformat(data.PricingVal[i].BeforeTaxPrice));
           // $('#taxLbl').text(data.PricingVal[i].TaxAmount);  
            //$('#grandtotalLbl').text(data.PricingVal[i].TotalPrice);
            $('#taxLbl').html(numformat(tax.toString().match(/^\d+(?:\.\d{0,2})?/))); 
            $('#grandtotalLbl').text(numformat(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)));

            $('#discountamountLbl').text(data.PricingVal[i].DiscountAmount);
            $('#subtotali').val(data.PricingVal[i].BeforeTaxPrice);
            // $('#taxi').val(data.PricingVal[i].TaxAmount);  
            // $('#grandtotali').val(data.PricingVal[i].TotalPrice);
            $('#taxi').val(tax.toString().match(/^\d+(?:\.\d{0,2})?/));  
            $('#grandtotali').val(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)); 
            $('#discountamountli').val(data.PricingVal[i].DiscountAmount); 
            $('#discountpercenti').val(data.PricingVal[i].DiscountPercent); 
            $('#discountamountextLbl').html('Discount ('+data.PricingVal[i].DiscountPercent+'%):');
            
                       var discounthider=data.PricingVal[i].DiscountAmount;
                      // alert(discounthider);
                               if(parseFloat(discounthider)>0)
                                    {
                                        $("#discountTr").show();
                                    }
                                    else
                                    {
                                        $("#discountTr").hide();
                                    }

            calculateIndividaulGrandTotal();

        }
}
});

});
        
        $('#deleteBtnItemChild').click(function(){ 

        var cid = document.forms['deletform'].elements['did'].value;
        var registerForm = $("#deletform"); 
        var formData = registerForm.serialize();
        //console.log('ccid=='+cid)
        $.ajax({
        url:'/saleholditemdelete/'+cid,
        type:'DELETE',
        data:formData,
        beforeSend:function(){
            $('#deleteBtnItemChild').text('Deleting Item...');
            $('#deleteBtnItemChild').prop('disabled',true);
        },
        success:function(data)
        {
            $("#myToast").toast('show');
            $('#toast-massages').html("Item Removed Successfully");
            $('#deleteBtnItemChild').text('Delete');
            $('#deleteBtnItemChild').prop('disabled',false);
            $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
            $('#examplemodal-delete').modal('hide');
            // $('#deletebtnconversion').text('Delete');
            var oTable = $('#datatable-crud-child').dataTable(); 
            oTable.fnDraw(false);
                $('#numberofItemsLbl').text(data.Totalcount);
                $('#numbercounti').val(data.Totalcount);
                var len=data.PricingVal.length;
                 for(var i=0;i<=len;i++)
                 {
                        var beforetax=data.PricingVal[i].BeforeTaxPrice;
                        var tax=parseFloat(beforetax)*15/100;
                        var grandTotal=parseFloat(beforetax)+parseFloat(tax);
                       
                    $('#taxi').val(tax.toString().match(/^\d+(?:\.\d{0,2})?/));  
                    $('#grandtotali').val(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/)); 
                    $('#subtotalLbl').text(data.PricingVal[i].BeforeTaxPrice);
                    // $('#taxLbl').text(data.PricingVal[i].TaxAmount);  
                    // $('#grandtotalLbl').text(data.PricingVal[i].TotalPrice);
                    $('#taxLbl').html(tax.toString().match(/^\d+(?:\.\d{0,2})?/)); 
                    $('#grandtotalLbl').text(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/));
                    $('#discountamountLbl').text(data.PricingVal[i].DiscountAmount);
                    $('#discountamountextLbl').html('Discount ('+data.PricingVal[i].DiscountPercent+'%):');
                    $('#subtotali').val(data.PricingVal[i].BeforeTaxPrice);
                    // $('#taxi').val(data.PricingVal[i].TaxAmount);  
                    // $('#grandtotali').val(data.PricingVal[i].TotalPrice); 
                    $('#taxi').val(tax.toString().match(/^\d+(?:\.\d{0,2})?/));  
                    $('#grandtotali').val(grandTotal.toString().match(/^\d+(?:\.\d{0,2})?/));
                    $('#discountamountli').val(data.PricingVal[i].DiscountAmount);
                    
                    var discounthider=data.PricingVal[i].DiscountAmount;
                          if(parseFloat(discounthider)>0)
                                    {
                                        $("#discountTr").show();
                                    } 
                                    else
                                 //   else if(parseFloat(discounthider<=0)||discounthider==null||discounthider==='')
                                    {
                                        $("#discountTr").hide();
                                    }

                    calculateIndividaulGrandTotal();
                }
        }
       });

        });
 
        $("#addnewhold").on('click', function() 
        {
          //  var hid = document.forms['Register'].elements['id'].value;
          var hid=$('#id').val();
          var storeid=$('#store').val();
          var commonVal=$('#salecounti').val();
          $('#itemid').val('');
       // console.log('ssdsds=='+storeid);
       $('#ItemName').val(null).trigger('change');
       $('#uoms').val(null).trigger('change');
       
        $("#IteminlineForm").modal('show');
        $("#itemRegisterForm")[0].reset();
        $('#storeId').val(storeid);   
        $('#HeaderId').val(hid);
        $('#commonId').val(commonVal);
        $('#savebuttonitem').show();
        $('#savebuttonsaleitem').hide();

        var defaultprice=$('#cdefaultPrice').html();
         if(defaultprice=='Wholeseller')
         {
             $('#editptypeth').show();
             $('#editptypetd').show();

            //$('tr td:nth-child(5)').show();
         }
         if(defaultprice=='Retailer')
         {
            $('#editptypeth').hide();
            $('#editptypetd').hide();
           
         }

    });
        $("#addnew").on('click', function() 
        {
            
        var hid=$('#id').val();
        var storeid=$('#store').val();
        var commonVal=$('#salecounti').val();
        $('#triggervalue').val('0'); 
        $('#itemid').val('');

       // console.log('ssdsds=='+storeid);
       $('#ItemName').val(null).trigger('change');
        $('#uoms').val(null).trigger('change'); 

        $("#IteminlineForm").modal('show');
        $("#itemRegisterForm")[0].reset();
        $('#storeId').val(storeid); 
        $('#HeaderId').val(hid);
        $('#commonId').val(commonVal);
        $('#savebuttonitem').hide();
        $('#savebuttonsaleitem').show();

        var defaultprice=$('#cdefaultPrice').html();
         if(defaultprice=='Wholeseller')
         {
             $('#editptypeth').show();
             $('#editptypetd').show();

            //$('tr td:nth-child(5)').show();
         }
         if(defaultprice=='Retailer')
         {
            $('#editptypeth').hide();
            $('#editptypetd').hide();
           
         }

    });

    


        var i = 0;
        var j=0;
         $("#adds").on('click', function() {
         ++i;
         ++j;
         $("#dynamicTable").append('<tr id="row'+i+'" class="dynamic-added"><td>'+j+'</td><td style="width: 20%;"><select id="itemNameSl" class="select2 form-control form-control-lg eName" onchange="itemVal(this)" name="row['+i+'][ItemId]"><option selected disabled value=""></option>@foreach ($itemSrcs as $itemSrcs)<option value="{{$itemSrcs->ItemId}}">{{$itemSrcs->Code}},  {{$itemSrcs->ItemName}},  {{$itemSrcs->SKUNumber}}</option>@endforeach</select></td><td style="width:10%"><select id="uom" class="select2 form-control uom" onchange="uomVal(this)" name="row['+i+'][uom]"></select></td><td><input type="text" name="row['+i+'][AvQuantity]" id="AvQuantity" class="AvQuantity form-control"  readonly/><input type="hidden" name="row['+i+'][AvQuantityh]" id="AvQuantityh" class="AvQuantityh form-control"  readonly/></td><td><input type="text" name="row['+i+'][Quantity]" placeholder="Quantity" id="quantity" class="quantity form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" onkeydown="ValidQuantity(this)"/></td><td id="editptypetdd" style="width: 5%;"><select id="DefualtPrice" class="select2 form-control form-control-lg Dprice" onchange="DefualPriceChange(this)" name="row['+i+'][Dprice]"><option selected disabled  value=""></option><option value="Rp">Rp  </option><option value="Ws">Ws </option></select></td><td style="width:10%"><input type="text" name="row['+i+'][UnitPrice]" placeholder="Unit Cost" id="unitprice" class="unitprice form-control" onkeyup="CalculateTotal(this)" onkeypress="return ValidateNum(event);" readonly  @can('UnitPrice-Active') ondblclick="unitpriceActive(this)"; @endcan </td>@can('sales-discount')<td><input type="text" name="row['+i+'][Discount]" placeholder="Enter your discount" class="form-control discount" onkeyup="Calculatediscount(this)" onkeypress="return ValidateNum(event);"/></td>@endcan<td><input type="text" name="row['+i+'][BeforeTaxPrice]" id="" class="beforetax form-control"  style="font-weight:bold;" readonly/></td><td><input type="text" name="row['+i+'][TaxAmount]" id="taxamounts" class="taxamount form-control"  style="font-weight:bold;" readonly/></td><td><input type="text" name="row['+i+'][TotalPrice]" id="total" class="total form-control"  style="font-weight:bold;" readonly/></td> <td><input type="hidden" name="row['+i+'][StoreId]" id="storeappend" class="storeappend form-control" readonly/></td><td> <td><input type="hidden" name="row['+i+'][Common]" id="common" class="common form-control" readonly/></td><td><input type="hidden" name="row['+i+'][TransactionType]" id="TransactionType" class="TransactionType form-control" value="Sales" readonly/></td><td><input type="hidden" name="row['+i+'][ItemType]" id="ItemType" class="ItemType form-control" value="Goods" readonly/></td><td><input type="hidden" name="row['+i+'][DefaultUOMId]" id="DefaultUOMId" class="DefaultUOMId form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][NewUOMId]" id="NewUOMId" class="NewUOMId form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][ConversionAmount]" id="ConversionAmount" class="ConversionAmount form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][ConvertedQuantity]" id="ConvertedQuantity" class="ConvertedQuantity form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][mainPrice]" id="mainPrice" class="mainPrice form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][maxCost]" id="maxCost" class="maxCost form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][DiscountAmount]" id="discountamount" class="discountamount form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][wholesaleminamount]" id="wholesaleminamount" class="wholesaleminamount form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][retailprice]" id="retailprice" class="retailprice form-control" readonly="true" style="font-weight:bold;"/></td><td><input type="hidden" name="row['+i+'][wholesaleprice]" id="wholesaleprice" class="wholesaleprice form-control" readonly="true" style="font-weight:bold;"/></td><td><button type="button" class="btn btn-danger btn-sm remove-tr">X</button></td>');
            var sc= $('#salecounti').val();
            $('.common').val(sc);
            renumberRows();

            var sroreidvar = $('#store').val(); 
            $('.storeappend').val(sroreidvar); 
                        $(".eName").select2
                    ({
                        placeholder: "Select Item here",
                    });

            var defaultprice=$('#cdefaultPrice').html();
            if(defaultprice=='Wholeseller')
            {
             $('#dprthead').show();
             //$('#editptypetdd').show();
              $('tr td:nth-child(6)').show(); 
             // $closest('tr').find('.DefualtPrice').show();

         }
         if(defaultprice=='Retailer')
         {
            $('#dprthead').hide();
            //$('#editptypetdd').hide();
             $('tr td:nth-child(6)').hide();
         //  $closest('tr').find('.DefualtPrice').hide();
           
         }  
        });

        $(document).on('click', '.remove-tr', function(){  
            --i;
        $(this).parents('tr').remove();
        $("#hidewithold" ).prop( "checked", false );
       // $("#dynamicTable").sortable("refresh");
         CalculateGrandTotal();

         renumberRows();

         var discounthider=$("#discountamountli").val();
            if(parseFloat(discounthider)>0)
            {
                $("#discountTr").show();
            }
            else 
            {
                $("#discountTr").hide();
            }

    });  

function ValidQuantity(ele)
{
    

}
function unitpriceSingleActive()
{
    $("#UnitPrice").prop("readonly", false); 
}
function unitpriceActive(ele)
    {
      
      $(ele).closest('tr').find('.unitprice').prop("readonly", false);
     
    }
//Start UOM Change
function uomVal(ele) 
{
    var uomnewval = $(ele).closest('tr').find('.uom').val();
    var UnitpriceVal= $(ele).closest('tr').find('.unitprice').val();
    var mainpriceval= $(ele).closest('tr').find('.mainPrice').val();
    var quantityOnhand=$(ele).closest('tr').find('.AvQuantity').val();
    var quantityOnhandh=$(ele).closest('tr').find('.AvQuantityh').val();
    
    $(ele).closest('tr').find('.NewUOMId').val(uomnewval);
    var uomdefval = $(ele).closest('tr').find('.DefaultUOMId').val();
    if(parseFloat(uomnewval)==parseFloat(uomdefval))
    {
        $(ele).closest('tr').find('.ConversionAmount').val("1");
        $(ele).closest('tr').find('.unitprice').val(mainpriceval);
        $(ele).closest('tr').find('.AvQuantity').val(quantityOnhandh);
    }
    else if(parseFloat(uomnewval)!=parseFloat(uomdefval))
    {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        if(uomnewval!=null)
        {
            $.ajax({
            url:'getsaleUOMAmount/'+uomdefval+"/"+uomnewval,
            type:'DELETE',
            data:formData,
            success:function(data)
            {
                if(data.sid)
                {
                    var amount=data['sid'];
                    $(ele).closest('tr').find('.ConversionAmount').val(amount);
                    var Result= mainpriceval/amount;
                    var onhandResult=quantityOnhandh/amount;

                    $(ele).closest('tr').find('.unitprice').val(Result);
                    $(ele).closest('tr').find('.AvQuantity').val(onhandResult);

                    
                }
            },
        });

        }
        
    }
    $(ele).closest('tr').find('.quantity').val("");
    $(ele).closest('tr').find('.ConvertedQuantity').val("");
}
//End UOM change
function rst()
{
            $('#witholdingAmntLbl').html("0");
            $('#vatAmntLbl').html("0");
            $('#witholdingAmntin').val("0");
            $('#vatAmntin').val("0");            
            $('#netpayLbl').html("0");
            $('#netpayin').val("0");
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $("#vatTr").hide(); 
            $("#hidewitholdTr").hide(); 
            $('#grandtotalLbl').html('0');
            $('#subtotalLbl').html('0');
            $('#taxLbl').html('0');
            $('#discountamountLbl').html('0');
            $('#discountamountextLbl').html('0');
            $('#subtotali').val('0');
            $('#taxi').val('0');  
            $('#grandtotali').val('0');
            $('#discountamountli').val('0');
            $('#discountpercenti').val('0');
}
function rex(ele)
{
  // alert('clicked');
}
    function DefualPriceChange(ele)
    {
        var defprice= $(ele).closest('tr').find('.Dprice').val(); 
        var retialprice=$(ele).closest('tr').find('.retailprice').val();
        var wholesaleprice=$(ele).closest('tr').find('.wholesaleprice').val();
        var availableq = $(ele).closest('tr').find('.AvQuantity').val();
        var quantity = $(ele).closest('tr').find('.quantity').val();
        var minAmount=$(ele).closest('tr').find('.wholesaleminamount').val();
        var  defualtprice=$('#cdefaultPrice').html();
        var taxpercent="15";

       
        if(defprice=='Rp')
        {
         $(ele).closest('tr').find('.unitprice').val(retialprice); 
        }
        if(defprice=='Ws')
        {
            if(parseFloat(quantity)<parseFloat(minAmount))
        {
           
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Invalid Price,The quantity is lessthan the amount of whole sale minimum quantity");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
            $(ele).closest('tr').find('.unitprice').val(retialprice); 
            $(ele).closest('tr').find('.Dprice').val('Rp'); 
        }
        else
        {
            $(ele).closest('tr').find('.unitprice').val(wholesaleprice);
        }
          
        }

        
        var unitprice = $(ele).closest('tr').find('.unitprice').val();

        $(ele).closest('tr').find('.discount').val('');
        $(ele).closest('tr').find('.discountamount').val('0');

        unitprice = unitprice == '' ? 0 : unitprice;
        quantity = quantity == '' ? 0 : quantity;
        if (!isNaN(unitprice) && !isNaN(quantity)) {
            var total = parseFloat(unitprice) * parseFloat(quantity);
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
          //  $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
        }

        var defuom=$(ele).closest('tr').find('.DefaultUOMId').val();
        var newuom=$(ele).closest('tr').find('.NewUOMId').val();
        var convamount=$(ele).closest('tr').find('.ConversionAmount').val();
        var convertedq=parseFloat(quantity)/parseFloat(convamount);
        $(ele).closest('tr').find('.ConvertedQuantity').val(convertedq);

        CalculateGrandTotal();

        

      

    }

    function CalculateTotal(ele) {

        var availableq = $(ele).closest('tr').find('.AvQuantity').val();
        var quantity = $(ele).closest('tr').find('.quantity').val();
        var minAmount=$(ele).closest('tr').find('.wholesaleminamount').val();
        var retialprice=$(ele).closest('tr').find('.retailprice').val();
        var wholesaleprice=$(ele).closest('tr').find('.wholesaleprice').val();
        var  defualtprice=$('#cdefaultPrice').html();
        $("#hidewithold" ).prop( "checked", false );
        var inputid = ele.getAttribute('id');
        
       // alert(quantity);
            if(inputid=='quantity')
            {

                if(defualtprice=='Wholeseller')
                {
                        if(parseFloat(quantity)<parseFloat(minAmount))
                        {
                            $(ele).closest('tr').find('.unitprice').val(retialprice); 
                            $(ele).closest('tr').find('.Dprice').val('Rp'); 

                        }
                        if(parseFloat(quantity)>=parseFloat(minAmount))
                        {
                            $(ele).closest('tr').find('.unitprice').val(wholesaleprice); 
                            $(ele).closest('tr').find('.Dprice').val('Ws'); 

                        }
                }
        
            }
            if(inputid=='unitprice')
            {
                $(ele).closest('tr').find('.Dprice').val(''); 
            }
      
       

        if(parseFloat(quantity)==0)
        {
            $(ele).closest('tr').find('.quantity').val('');
            $(ele).closest('tr').find('.Dprice').val('');
        }
        if(quantity.length===0)
        {
            $(ele).closest('tr').find('.Dprice').val('');
        }
    if(parseFloat(quantity)>parseFloat(availableq))
    {
        $("#myToast").toast({ delay: 10000 });
        $("#myToast").toast('show');
        $('#toast-massages').html("There is no available quantity");
        $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
        $(ele).closest('tr').find('.quantity').val('');
        $("#hidewithold" ).prop( "checked", false );
    }

        var taxpercent="15";
        var unitprice = $(ele).closest('tr').find('.unitprice').val();
        var quantity = $(ele).closest('tr').find('.quantity').val();
        $(ele).closest('tr').find('.discount').val('');
        $(ele).closest('tr').find('.discountamount').val('0');


        unitprice = unitprice == '' ? 0 : unitprice;
        quantity = quantity == '' ? 0 : quantity;
        if (!isNaN(unitprice) && !isNaN(quantity)) {
            var total = parseFloat(unitprice) * parseFloat(quantity);
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
          //  $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
        }

        var defuom=$(ele).closest('tr').find('.DefaultUOMId').val();
        var newuom=$(ele).closest('tr').find('.NewUOMId').val();
        var convamount=$(ele).closest('tr').find('.ConversionAmount').val();
        var convertedq=parseFloat(quantity)/parseFloat(convamount);
        $(ele).closest('tr').find('.ConvertedQuantity').val(convertedq);
        
       


        CalculateGrandTotal();

        var discounthider=$("#discountamountli").val();
            if(parseFloat(discounthider)>0)
            {
                $("#discountTr").show();
            }
            else 
            {
                $("#discountTr").hide();
            }
    }

    

   function calculateIndividaulGrandTotal()
   {
      
        var subtotal = 0;
        var tax = 0;
        var grandTotal = 0;
        var witholdam=$('#witholdMinAmounti').val();
        var vatamount=$('#vatAmount').val();
        var vatpercent=$('#vatPercenti').val();
        var Servicewitholdam=$('#servicewitholdMinAmounti').val();
        var witholdpr=$('#witholdPercenti').val();

        subtotal=$('#subtotali').val();
        tax=$('#taxi').val();
        grandTotal=$('#grandtotali').val();


        var cc=$('#ccategory').text();
        if((parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)|| (parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0))
        {
            
            var st=parseFloat(subtotal);
            var wp=parseFloat(witholdpr);
            var vt=parseFloat(vatpercent);
            var tp=0;
            
            var tt=0;
            var np=0;
            
            if(parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)
            {
                tp=wp;
                    $("#witholdingTr").show();
                    $("#netpayTr").show();  
                    $("#vatTr").hide(); 
                    $("#hidewitholdTr").show();
            }
            if(parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0)
            {
                tp=vt;
                   $("#witholdingTr").hide();
                    $("#netpayTr").show();  
                    $("#vatTr").show(); 
                    $("#hidewitholdTr").show();
            }
            if((parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)&& (parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0))
            {
                tp=vt+wp;
                    $("#witholdingTr").show();
                    $("#netpayTr").show();  
                    $("#vatTr").show(); 
                    $("#hidewitholdTr").show();
            }
           // alert(tp);
            tt=((st*tp)/100).toString().match(/^\d+(?:\.\d{0,2})?/);
            var ttwithold=(st*wp)/100;
            var ttvat=(st*vt)/100;
            
            np=parseFloat(grandTotal)-parseFloat(tt);
            $('#witholdingAmntLbl').html(numformat(ttwithold.toFixed(2)));
            $('#witholdingAmntin').val(ttwithold.toFixed(2));
            $('#vatAmntLbl').html(numformat(ttvat.toFixed(2)));
            $('#vatAmntin').val(ttvat.toFixed(2));
            $('#netpayLbl').html(numformat(np.toFixed(2)));
            $('#netpayin').val(np.toFixed(2));
                            if(cc==="Foreigner-Supplier"||cc==="Person")
                            {
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide(); 
                                $("#vatTr").hide(); 
                                $("#hidewitholdTr").hide(); 
                            }
                    else if(parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)
                    {
                    // $("#witholdingTr").show();
                    // $("#netpayTr").show();  
                    // $("#vatTr").show(); 
                    }
            
        }
 // vat calculate
        

        else if(parseFloat(subtotal)<parseFloat(witholdam)||parseFloat(witholdpr)==0)
            {
            $('#witholdingAmntLbl').html("0");
            $('#vatAmntLbl').html("0");
            $('#witholdingAmntin').val("0");
            $('#vatAmntin').val("0");            
            $('#netpayLbl').html("0");
            $('#netpayin').val("0");
            $("#witholdingTr").hide();
            $("#netpayTr").hide();
            $("#vatTr").hide(); 
            $("#hidewitholdTr").hide();

            }
        // end

        $('#subtotalLbl').html(numformat(subtotal));
        $('#taxLbl').html(numformat(tax));
        $('#grandtotalLbl').html(numformat(grandTotal));
        $('#subtotali').val(subtotal);
        $('#taxi').val(tax);  
        $('#grandtotali').val(grandTotal);


   } 

    function CalculateGrandTotal() {
        var subtotal = 0;
        var tax = 0;
        var grandTotal = 0;
        var discountamount=0;
        var discountPercent=0;
        var witholdam=$('#witholdMinAmounti').val();
        var vatamount=$('#vatAmount').val();
        var vatpercent=$('#vatPercenti').val();
        var Servicewitholdam=$('#servicewitholdMinAmounti').val();
        var witholdpr=$('#witholdPercenti').val();

        $.each($('#dynamicTable').find('.beforetax'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                subtotal += parseFloat($(this).val());
            }
        });

        $.each($('#dynamicTable').find('.taxamount'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                tax += parseFloat($(this).val());
            }
        });
        $.each($('#dynamicTable').find('.total'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                grandTotal += parseFloat($(this).val());
            }
        });

        $.each($('#dynamicTable').find('.discountamount'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                discountamount += parseFloat($(this).val());
            }
        });

        $.each($('#dynamicTable').find('.discount'), function () {
            if ($(this).val() != '' && !isNaN($(this).val())) {
                discountPercent += parseFloat($(this).val());
            }
        });

        //start
// withhold
        var cc=$('#ccategory').text();
        if((parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)|| (parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0))
        {
           // console.log('gebtwal one');

            var st=parseFloat(subtotal);
            var wp=parseFloat(witholdpr);
            var vt=parseFloat(vatpercent);
            var tp=0;           
            var tt=0;
            var np=0;
            if(parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)
            {
                tp=wp;
                console.log('1');
            }
            if(parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0)
            {
                tp=vt;
                console.log('2');
            }
            if((parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)&& (parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0))
            {
                tp=vt+wp;
                console.log('3');
            }
           // alert(tp);
            tt=((st*tp)/100).toFixed(2);
          //  alert(tt+  grandTotal);
            var ttwithold=(st*wp)/100;
            
            var ttvat=(st*vt)/100;
           // grandTotal=grandTotal.toFixed(2);
           var taxinp=(parseFloat(subtotal)*15)/100;
            var grandTotalinp=(parseFloat(taxinp)+parseFloat(subtotal)).toString().match(/^\d+(?:\.\d{0,2})?/);
            //alert(grandTotalinp+ tt);
                        np=parseFloat(grandTotalinp)-parseFloat(tt);
                        
                        $('#witholdingAmntLbl').html(numformat(ttwithold.toFixed(2)));
                        $('#witholdingAmntin').val(ttwithold);
                        $('#vatAmntLbl').html(numformat(ttvat.toFixed(2)));
                        $('#vatAmntin').val(ttvat.toFixed(2));
                        $('#netpayLbl').html(numformat(np.toFixed(2)));
                        $('#netpayin').val(np.toFixed(2));
                       
                            if(cc==="Foreigner-Supplier"||cc==="Person")
                            {
                                $("#witholdingTr").hide();
                                $("#netpayTr").hide(); 
                                $("#vatTr").hide();  
                                $("#hidewitholdTr").hide();
                            }
                       if(parseFloat(subtotal)>=parseFloat(witholdam)&&parseFloat(witholdpr)>0)
                        {
                        $("#witholdingTr").show();
                        $("#netpayTr").show();  
                        $("#hidewitholdTr").show(); 
                        }
                        if(parseFloat(subtotal)>=parseFloat(vatamount)&&parseFloat(vatpercent)>0)
                        {
                        $("#netpayTr").show();  
                        $("#vatTr").show(); 
                        $("#hidewitholdTr").show(); 
                        }
            
        }
 // vat calculate
            if(parseFloat(vatpercent)==0)
                {
                $("#vatTr").hide();
                }

            if(parseFloat(subtotal)<parseFloat(witholdam)||parseFloat(witholdpr)==0)
            {
               
            $('#witholdingAmntLbl').html("0");
            //$('#vatAmntLbl').html("0");
            $('#witholdingAmntin').val("0");
            //$('#vatAmntin').val("0");            
           // $('#netpayLbl').html("0");
            //$('#netpayin').val("0");
            $("#witholdingTr").hide();
            //$("#netpayTr").hide();
           // $("#vatTr").hide(); 
           // $("#hidewitholdTr").hide(); 
            }
        // end

                         if(parseFloat(subtotal)<parseFloat(vatamount)||parseFloat(vatpercent)==0)
                            {

                            //$('#witholdingAmntLbl').html("0");
                            $('#vatAmntLbl').html("0");
                            //$('#witholdingAmntin').val("0");
                            $('#vatAmntin').val("0");            
                           // $('#netpayLbl').html("0");
                           // $('#netpayin').val("0");
                            //$("#witholdingTr").hide();
                           // $("#netpayTr").hide();
                            $("#vatTr").hide(); 
                           // $("#hidewitholdTr").hide(); 
                            }

              if((parseFloat(subtotal)<parseFloat(vatamount)&&parseFloat(vatpercent)==0)||(parseFloat(subtotal)<parseFloat(witholdam)&&parseFloat(witholdpr)==0))
                        {
                        $('#netpayLbl').html("0");
                        $('#netpayin').val("0");
                        $("#netpayTr").hide();  
                        }

                        if((parseFloat(subtotal)<parseFloat(vatamount))||(parseFloat(subtotal)<parseFloat(witholdam)))
                        {
                        $('#netpayLbl').html("0");
                        $('#netpayin').val("0");
                        $("#netpayTr").hide();  
                        }
            

            var taxi=(parseFloat(subtotal)*15)/100;
            var grandTotali=parseFloat(taxi)+parseFloat(subtotal);
            var grandTotalbeforediscount=parseFloat(grandTotali)+parseFloat();
             $('#subtotalLbl').html(numformat(subtotal.toFixed(2)));
             $('#taxLbl').html(numformat(taxi.toString().match(/^\d+(?:\.\d{0,2})?/)));
            //$('#grandtotalLbl').html(numformat(grandTotal.toFixed(2)));
            $('#grandtotalLbl').html(numformat(grandTotali.toString().match(/^\d+(?:\.\d{0,2})?/)));
            $('#discountamountLbl').html(numformat(discountamount.toFixed(2)));
            $('#discountamountextLbl').html('Discount ('+discountPercent+'%):');
            $('#subtotali').val(subtotal.toFixed(2));
            $('#taxi').val(taxi.toString().match(/^\d+(?:\.\d{0,2})?/));  
            $('#grandtotali').val(grandTotali.toString().match(/^\d+(?:\.\d{0,2})?/));
            $('#discountamountli').val(discountamount.toFixed(2));
         //   $('#discountnetpayAmountLbl').html(numformat(grandTotali.toString().match(/^\d+(?:\.\d{0,2})?/)));

        
          
    }

function Calculatediscount(ele)

{
    
    var taxpercent="15";
    var discount=$(ele).closest('tr').find('.discount').val();
    var unitprice=$(ele).closest('tr').find('.unitprice').val();
    var quantity=$(ele).closest('tr').find('.quantity').val();
    var maxcost=$(ele).closest('tr').find('.maxCost').val();
            if(parseFloat(discount)==0)
            {
                $(ele).closest('tr').find('.discount').val(''); 
            }
            var total = parseFloat(unitprice) * parseFloat(quantity);
            total=total-(total*discount)/100;
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            var discountunitprice=parseFloat(total)/parseFloat(quantity);
            var discountAmount=parseFloat(unitprice)-parseFloat(discountunitprice);
            discountAmount=discountAmount*quantity;
            //alert(discountunitprice+"max="+maxcost+" disamount="+discountAmount);
        if(discountunitprice<maxcost)
        {
            $(ele).closest('tr').find('.discount').val('');
            var discounts=$(ele).closest('tr').find('.discount').val();
            var total = parseFloat(unitprice) * parseFloat(quantity);        
            total=total-(total*discounts)/100;
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
            $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
            $(ele).closest('tr').find('.discountamount').val('0');
            CalculateGrandTotal();
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Discount Amount is Greater Than Cost");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
           // $("#discountTr").hide();
           var discounthider=$("#discountamountli").val();
            if(parseFloat(discounthider)>0)
            {
                $("#discountTr").show();
            }
            else 
            {
                $("#discountTr").hide();
            }
        }
    else if(discountunitprice>=maxcost)
     
            {
                //alert(discountAmount);
            $(ele).closest('tr').find('.beforetax').val(total.toFixed(2));
            $(ele).closest('tr').find('.taxamount').val(taxamount.toFixed(2));
            $(ele).closest('tr').find('.total').val(linetotal.toFixed(2));
            $(ele).closest('tr').find('.discountamount').val(discountAmount.toFixed(2));

            CalculateGrandTotal();

            var discounthider=$("#discountamountli").val();
            if(parseFloat(discounthider)>0)
            {
                $("#discountTr").show();
            }
            else 
            {
                $("#discountTr").hide();
            }
        
        }
     
    

    

}
function selectTypeadd()
{
    $( '#ItemType-error' ).html(''); 
    $( '#UnitPrice-error' ).html(''); 
    

    var sid=$('#ItemName').val();
    var type=$('#Type').val();
    if(sid!=null)
    {
        $.get("/showItemInfo" +'/' + sid , function (data)
    {
        var len=data.length;
        for(var i=0;i<=len;i++) 
             {  
                 var rprice=(data[i].RetailerPrice);
                 var wprice=(data[i].WholesellerPrice);
                 if(type=='rp')
                 {
                    $('#UnitPrice').val(rprice);
                 }
                 if(type=='ws')
                 {
                    $('#UnitPrice').val(wprice);
                 }
                 
             }

    });
    }
    
   // console.log('itemname='+sid);
}
function selectType(ele)
{
    var sid = $(ele).closest('tr').find('.eName').val();
    var type=$(ele).closest('tr').find('.eType').val();
    
        if(sid!=null)
        {
            $.get("/showItemInfo" +'/' + sid , function (data)
    {
        var len=data.length;
        for(var i=0;i<=len;i++) 
             {  
                 var rprice=(data[i].RetailerPrice);
                 var wprice=(data[i].WholesellerPrice);
                 if(type=='rp')
                 {
                    $(ele).closest('tr').find('.unitprice').val(rprice);  
                 }
                 if(type=='ws')
                 {
                    $(ele).closest('tr').find('.unitprice').val(wprice);  
                 }
                 
             }

    });
        }
    

}

function itemVal(ele) 
{
    //$('#itemInfoCardDiv').show();
    var sid = $(ele).closest('tr').find('.eName').val();
    $(ele).closest('tr').find('.quantity').val('');
    $(ele).closest('tr').find('.beforetax').val('0.0');
    $(ele).closest('tr').find('.taxamount').val('0.0');
    $(ele).closest('tr').find('.total').val('0.0');
    $(ele).closest('tr').find('.discount').val('');
    $(ele).closest('tr').find('.discountamount').val('');
    $(ele).closest('tr').find('.Dprice').val('');
    $("#hidewithold" ).prop( "checked", false );
    
    var defaultprice=$('#cdefaultPrice').html();
    var storeval = store.value;
    console.log('defualt price=='+defaultprice);
    if(sid!=null)
    {

        $.get("/showItemInfo" +'/' + sid +'/'+ storeval, function (data) 
     {     
        if(data.Regitem)
        {
        var len=data['Regitem'].length;
        for(var i=0;i<=len;i++) 
        {  
        var itemRpVar=data['Regitem'][i].RetailerPrice;
        console.log('rretail price='+itemRpVar);
        var itemWsVar=data['Regitem'][i].WholesellerPrice;
        var avalaiblequantity=data['getQuantity'][i].AvailableQuantity;
        var maxCostval=data['Regitem'][i].Maxcost;
        var wholesaleminAmountVar=data['Regitem'][i].wholeSellerMinAmount;
        $(ele).closest('tr').find('.wholesaleminamount').val(wholesaleminAmountVar);
        $(ele).closest('tr').find('.wholesaleprice').val((itemWsVar/1.15).toFixed(2));
        $(ele).closest('tr').find('.retailprice').val((itemRpVar/1.15).toFixed(2));
        if(maxCostval>=0)
        {
            $(ele).closest('tr').find('.maxCost').val(maxCostval/1.15);  
        }
        if(maxCostval==null)
        {
            $(ele).closest('tr').find('.maxCost').val('0');
        }
        
        
        if(defaultprice=='Retailer')
        {
            if(parseFloat(maxCostval)>parseFloat(itemRpVar))
            {
                $(ele).closest('tr').find('.unitprice').val("0"); 
                $(ele).closest('tr').find('.mainPrice').val("0"); 
            }
            else
            {
                $(ele).closest('tr').find('.unitprice').val((itemRpVar/1.15).toFixed(2)); 
                $(ele).closest('tr').find('.mainPrice').val((itemRpVar/1.15).toFixed(2)); 
            }
            
        }
        if(defaultprice=='Wholeseller')
        {
            if(parseFloat(maxCostval)>parseFloat(itemWsVar))
            {
                $(ele).closest('tr').find('.unitprice').val("0"); 
                $(ele).closest('tr').find('.mainPrice').val("0"); 
            }
            else
            {
                $(ele).closest('tr').find('.unitprice').val((itemWsVar/1.15).toFixed(2)); 
                $(ele).closest('tr').find('.mainPrice').val((itemWsVar/1.15).toFixed(2)); 
            }
        
        }

          if(avalaiblequantity>=0){ 
            $(ele).closest('tr').find('.AvQuantity').val(avalaiblequantity);
            $(ele).closest('tr').find('.AvQuantityh').val(avalaiblequantity);
             }

             if(avalaiblequantity==null)
             { 
                $(ele).closest('tr').find('.AvQuantity').val('0');
             }
       
       
              // CalculateGrandTotal();
              // $('#itemInfoCardDiv').show();
            }

             }
        
     });
    }
    

    $(ele).closest('tr').find('.uom').empty();
    if(sid!='')
    {
        $.ajax({
        url:'saleUOMS/'+sid,
        type:'DELETE',
        data:'',
        success:function(data)
        {
            if(data.sid)
            {
                var defname=data['defuom'];
                var defid=data['uomid'];
                var option = "<option selected value='"+defid+"'>"+defname+"</option>";
                $(ele).closest('tr').find('.uom').append(option);
                $(ele).closest('tr').find('.DefaultUOMId').val(defid);
                $(ele).closest('tr').find('.NewUOMId').val(defid);
                $(ele).closest('tr').find('.ConversionAmount').val("1");
                var len=data['sid'].length;
                for(var i=0;i<=len;i++)
                {
                    var name=data['sid'][i].ToUnitName;
                    var id=data['sid'][i].ToUomID;
                    var option = "<option value='"+id+"'>"+name+"</option>";
                    $(ele).closest('tr').find('.uom').append(option);
                    
                }
                $(ele).closest('tr').find('.uom').select2();
            }
            },
        });
    }
     


           CalculateGrandTotal();

          var discounthider=$("#discountamountli").val();
            if(parseFloat(discounthider)>0)
            {
                $("#discountTr").show();
            }
            else 
            {
                $("#discountTr").hide();
            }


}

 

$(document).ready( function () 
    {
        $('#datatable-crud-bl').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            url: '/saleholdlist',
            type: 'GET',
            },
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data: 'CustomerCategory', name: 'CustomerCategory' },
            { data: 'Name', name: 'Name' },
            { data: 'TinNumber', name: 'TinNumber' },
            { data: 'PaymentType', name: 'PaymentType' },
            { data: 'VoucherType', name: 'VoucherType' },
            { data: 'VoucherNumber', name: 'VoucherNumber' },
            { data: 'CustomerMRC', name: 'CustomerMRC' },
            { data: 'StoreName', name: 'StoreName' },
            { data: 'VoidedDate', name: 'VoidedDate' },

            { data: 'action', name: 'action' }
        ],
       
        });

    });


    $(document).ready( function () 
    {
        $('#laravel-datatable-crud').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,   
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
           "<'row'<'col-sm-12'tr>>" +
           "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
        ajax: {
            url: '/salelist',
            type: 'GET',
            },
         columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data: 'CustomerCategory', name: 'CustomerCategory' },
            { data: 'Name', name: 'Name' },
            { data: 'TinNumber', name: 'TinNumber' },
            { data: 'PaymentType', name: 'PaymentType' },
            { data: 'VoucherType', name: 'VoucherType' },
            { data: 'VoucherNumber', name: 'VoucherNumber' },
            { data: 'CustomerMRC', name: 'CustomerMRC' },
            { data: 'StoreName', name: 'StoreName' },
            { data: 'CreatedDate', name: 'CreatedDate' },
            { data: 'Status', name: 'Status' },
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Status == "pending..") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#f6c23e", "font-weight": "bold","text-shadow":"1px 1px 10px #f6c23e"});
            }
            else if (aData.Status == "Checked") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#4e73df", "font-weight": "bold","text-shadow":"1px 1px 10px #4e73df"});
            }
            else if (aData.Status == "Confirmed") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
            }
            else if (aData.Status == "Void") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
            }
            else if (aData.Status == "Refund") 
            {
                $(nRow).find('td:eq(9)').css({"color": "#858796", "font-weight": "bold","text-shadow":"1px 1px 10px #858796"});
            }
        }
       
        });

    });

    
   


   

    $('body').on('click', '.addbutton', function () {
        $("#id").val("");
        $("#calcutionhide").val("0");
        $("#inlineForm").modal('show'); 
        $("#savenewbutton").show();
        $("#savebutton").show();
        $("#savebuttonhold").show(); 
        $("#savebuttoncopy").hide();
        $('#customerInfoCardDiv').hide();
        $('#storedivedit').hide();
        $('#customerdiv').show();
        $('#customerrdiv').hide();
        $('#customerwdiv').hide();
        $("#customer #wdiv").hide();
        $("#customer #wrdiv").show();
        $("#customer #rdiv").hide();
        $('#storediv').show();
        $('#itemInfoCardDiv').hide();
        $("#saveupbutton").hide();
        $("#dynamicTable").show();
        $("#adds").show();
        $("#addnew").hide();
        $("#addnewhold").hide();
        $('#subtotalLbl').html('0.0');
        $('#taxLbl').html('0.0');
        $('#grandtotalLbl').html('0.0');
        $('#numberofItemsLbl').html('0');
        $('#hidewitholdi').val('1');
        $('#hidevati').val('1'); 
        $("#datatable-crud-child").hide();
        $("#datatable-crud-childsale").hide();
        $("#witholdingTr").hide();
        $("#netpayTr").hide(); 
        $("#vatTr").hide();
        $("#hidewitholdTr").hide();
        $('#mrcdiv').show();
        $("#discountTr").hide();
        var today = new Date();
        var dd = today.getDate();
        var mm  = ((today.getMonth().length+1) === 1)? (today.getMonth()+1) : '0' + (today.getMonth()+1);
         var yyyy = today.getFullYear();
        var formatedCurrentDate=yyyy+"-"+mm+"-"+dd;
        $('#date').val(formatedCurrentDate);
        $("#iteminfo").hide();
        $('#myModalLabel333').html("Add Sales");
        $.get("/getcountable" , function (data) {           
            var rnum=(Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
            var commoncount=data.salecount;
            $('.common').val(data.salecount);
            $('#salecounti').val(rnum+commoncount);
            $('#witholdMinAmounti').val(data.SalesWithHold);
            $('#servicewitholdMinAmounti').val(data.ServiceWithHold);
            $('#vatAmount').val(data.vatDeduct);
            //servicewitholdMinAmounti
        });


    });
    $('#vatbtn').click(function(){ 

        var registerForm = $("#vatform");
        var formData = registerForm.serialize(); 

         $.ajax({
            url:'updateVatNumber',
            type:'POST',
            data:formData,
            beforeSend:function(){
                $('#vatbtn').text('Change...');
                        },
            success:function(data) {
                if(data.success)
                {
                    $('#vatbtn').text('Save Changes');
                    $("#myToast").toast({ delay: 4000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html(data.success);
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $("#vatmodal").modal('hide');
                    $("#vatform")[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                }
                if(data.errors)
                {
                    $('#vatbtn').text('Save Changes');
                    if(data.errors.vatNumber)
                    {
                    $( '#Recieptnumber-error' ).html( data.errors.vatNumber[0] );
                    }
                    if(data.errors.witholdNumber)
                            {
                            $( '#witholdRecieptNumber-error' ).html( data.errors.witholdNumber[0] );
                            }


                }
                if(data.dberrors)
                {
                    $('#vatbtn').text('Save Changes');
                    $( '#Recieptnumber-error' ).html('This Vat Number has been taken');
                }

            },

         });        

    });

                    $('#witholdbtn').click(function(){ 

                var registerForm = $("#witholdform");
                var formData = registerForm.serialize(); 

                $.ajax({
                    url:'updateWitholdNumber',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){
                        $('#witholdbtn').text('Change...');
                                },
                    success:function(data) {
                        if(data.success)
                        {
                        $('#witholdbtn').text('Save Changes');
                        $("#myToast").toast({ delay: 4000 });
                        $("#myToast").toast('show');
                        $('#toast-massages').html(data.success);
                        $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                        $("#witholdmodal").modal('hide');
                        $("#witholdform")[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);

                        }
                        if(data.errors)
                        {
                            $('#witholdbtn').text('Save Changes');
                            if(data.errors.witholdRecieptNumber)
                            {
                            $( '#witholdRecieptNumber-error' ).html( data.errors.witholdRecieptNumber[0] );
                            }

                        }
                        if(data.dberrors)
                        {
                            $('#witholdbtn').text('Save Changes');
                            $( '#witholdRecieptNumber-error' ).html('The Withold Number has been taken'); 
                        }

                    },

                });        

                });




      $('body').on('click', '.addvat', function () {
       var id=$(this).data('id');
       $('#recieptid').val(id);
        // $("#vatmodal").modal('show');
        $.get("/showVat" +'/' + id , function (data) 
        {
            var vatNumber=data.saledata.vatNumber;
            var witholdNumber=data.saledata.witholdNumber;
            var cvat=data.cvat;
            var cwithold=data.cwithold;
            var SubTotal=data.saledata.SubTotal;
            var GrandTotal=data.saledata.GrandTotal;
            var vatAmount=0;
            var witholdAmount=0;
            var netpay=0;


            if(vatNumber==null)
            {
              $("#vatNumber").attr("readonly", false);
            }
            if(vatNumber!=null)
            {
               $("#vatNumber").attr("readonly", true);
            }
            if(witholdNumber==null)
            {
              $("#witholdRecieptNumber").attr("readonly", false);
            }
            if(witholdNumber!=null)
            {
               $("#witholdRecieptNumber").attr("readonly", true);
            }


           // $('#vatAmountLbl').html('Vat Amount: <b>'+data.saledata.Vat+'</b>');
            $('#vatNumber').val(data.saledata.vatNumber);
            //$('#witholdAmountLbl').html('Withold Amount: <b>'+data.saledata.WitholdAmount+'</b>');
            $('#witholdRecieptNumber').val(data.saledata.witholdNumber);
            $('#customerid').val(data.saledata.CustomerId);
           // customerid
           if(cvat!='0'||cwithold!='0')
           {
            $("#vatmodal").modal('show');
           }

            if(cvat=='0' && cwithold=='0')
            {
            
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("This Customer doesn't withold or vat deduction, Please check the customers have withold or vat deduction");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
            }

           if(cvat==="0")
            {
                $("#vatamountTitleLbl").hide();
                $("#vatNumber").hide();
                $("#vatAmountLbl").hide();
                //Recieptnumber-error
            }
            if(cvat!="0")
            {
                $("#vatTitleLbl").show();
                $("#vatNumber").show();
                $("#vatAmountLbl").show();
                 vatAmount=(SubTotal*cvat)/100;
               
               
            }
            if(cwithold=='0')
            {
                $("#withldamountTitleLbl").hide();
                $("#witholdRecieptNumber").hide();
                $("#witholdAmountLbl").hide();
            }
            if(cwithold!='0')
            {
                $("#withldamountTitleLbl").show();
                $("#witholdRecieptNumber").show();
                $("#witholdAmountLbl").show();
                 witholdAmount=(SubTotal*cwithold)/100;                  
            }

            netpay=GrandTotal-(witholdAmount+vatAmount);
              $('#vatAmountLbl').html('Vat Amount <b>('+data.cvat+'%)</b>: '+vatAmount.toString().match(/^\d+(?:\.\d{0,2})?/));
                $('#witholdAmountLbl').html('Withold Amount <b>('+data.cwithold+'%)</b>: '+witholdAmount.toString().match(/^\d+(?:\.\d{0,2})?/));
                $('#vatAmountvalue').val(vatAmount.toString().match(/^\d+(?:\.\d{0,2})?/));
                $('#witholdAmountvalue').val(witholdAmount.toString().match(/^\d+(?:\.\d{0,2})?/));
                $('#netpayvlaue').val(netpay.toString().match(/^\d+(?:\.\d{0,2})?/));
        });
    });
    function vatActive()
    {
        $("#vatNumber").attr("readonly", false);

    }

    $('body').on('click', '.addWithold', function () {
        var id=$(this).data('id');
        $('#witholdRecieptNumberid').val(id);
        $("#witholdmodal").modal('show');
        $.get("/showVat" +'/' + id , function (data) 
        {
            var witholdNumber=data.saledata.witholdNumber;
            if(witholdNumber==null)
            {
              $("#witholdRecieptNumber").attr("readonly", false);
            }
            if(witholdNumber!=null)
            {
               $("#witholdRecieptNumber").attr("readonly", true);
            }

            $('#witholdAmountLbl').html('Withold Amount: <b>'+data.saledata.WitholdAmount+'</b>');
            $('#witholdRecieptNumber').val(data.saledata.witholdNumber);
        });
    
    });

    function withholdActive()
    {
        $("#witholdRecieptNumber").attr("readonly", false);

    }
    
    $('body').on('click', '.infoProductItem', function () {
        //console.log('info is clicked');
        
        //$("#InfoinlineForm").modal('show');
        var sid = $(this).data('id');
        $("#docInfoModal").modal('show');
        
        $("#docInfoholdItem").show();
        $("#docInfosaleItem").hide();
        $("#holdtable").show();
        $("#saletable").hide();
        $("#changetopending").hide();
        $("#checksales").hide();
        $("#confirmsales").hide(); 

        
        $.get("/showhold" +'/' + sid , function (data) 
        {
            
            $('#infoDocCustomerCategory').text(data.ccat);
            $('#infoDocCustomerName').text(data.cname);
            $('#infoDocPaymentType').text(data.salehold.PaymentType);
            $('#infoDocVoucherType').text(data.salehold.VoucherType);
            $('#infoDocVoucherNumber').text(data.salehold.VoucherNumber);
           
            $('#infoDocsaleShop').text(data.storeName);
            $('#infoDocDate').text(data.salehold.VoidedDate);
            $('#infoDocholdby').text(data.salehold.Username);
            $('#infonumberofItemsLbl').text(data.countitem);
            $('#infosubtotalLbl').text(data.salehold.SubTotal);
            $('#infotaxLbl').text(data.salehold.Tax);  
            $('#infowitholdingAmntLbl').text(data.salehold.WitholdAmount);
            $('#infovatAmntLbl').text(data.salehold.Vat);
            $('#infonetpayLbl').text(data.salehold.NetPay);
            $('#infograndtotalLbl').text(data.salehold.GrandTotal);
            $('#infosubtotali').val(data.salehold.BeforeTaxPrice);
            $('#infotaxi').val(data.salehold.TaxAmount);  
            $('#infograndtotali').val(data.salehold.TotalPrice);
            $('#infodiscountin').val(data.salehold.DiscountAmount);
            $('#infodiscountLbl').text(data.salehold.DiscountAmount);
            $('#infodiscountamountextLbl').html('Discount ('+data.salehold.DiscountPercent+'%):');



                        var withHoldval=data.salehold.WitholdAmount;
                        var vatval=data.salehold.Vat;
                        var netPayval=data.salehold.NetPay;
                        var discounthider=data.salehold.DiscountAmount;
                        var defaultPriceval=data.defualPrice;
                        if(defaultPriceval=='Retailer')
                        {
                            $('#itemheadinfohold').hide();
                        }
                        if(defaultPriceval=='Wholeseller')
                        {
                            $('#itemheadinfohold').show(); 
                        }
		  
              if(discounthider<=0||discounthider==null)
              {
                  $('#infodiscountTr').hide();
              }
              if(discounthider>0&&discounthider!=null)
              {
                  $('#infodiscountTr').show();
              }
                        if(withHoldval=='0')
                        {
                            $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide(); 
                             //$("#infovatTr").show(); 

                        }
                        if(vatval=='0')
                        {
                          //  $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide(); 
                             $("#infovatTr").hide(); 

                        }  
                        if(withHoldval!='0')
                        {
                            $("#infowitholdingTr").show();
                            $("#infonetpayTr").show(); 
                            // $("#infovatTr").show(); 
                        }
                        if(vatval!='0')
                        {
                            $("#infonetpayTr").show(); 
                             $("#infovatTr").show(); 
                        }



        });

    //     $(document).ready( function () 
    // {
        $('#docInfoholdItem').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        paging: false,
        info: false,
        destroy: true,
        
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search hold"},
        "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
       
        ajax: {
            url: '/saleinfodholdlist/'+sid,
            type: 'GET',
            },
        columns: [
           // { data: 'id', name: 'id', 'visible': false },
            { data: 'Code', name: 'Code' },
            { data: 'ItemName', name: 'ItemName' },
            { data: 'SKUNumber', name: 'SKUNumber' },
            { data: 'Quantity', name: 'Quantity' },
            { data: 'Dprice', name: 'Dprice' },
            { data: 'UnitPrice', name: 'UnitPrice' },
            { data: 'Discount', name: 'Discount' },
            { data: 'BeforeTaxPrice', name: 'BeforeTaxPrice' },
            { data: 'TaxAmount', name: 'TaxAmount' },
            { data: 'TotalPrice', name: 'TotalPrice' }
           // { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Dprice!=null) 
            {
                $(nRow).find('td:eq(4)').show();
            }
            else
            {
                $(nRow).find('td:eq(4)').hide();
            }
        }

        });
        
   // });



    });

    $('body').on('click', '.deleteProduct', function () {
        $("#examplemodal-delete").modal('show');
        $("#deleteBtnItemChild").hide();
        $("#deleteBtn").show();
        $("#deleteBtnsaleItemChild").hide();
        
        var sid = $(this).data('id');
        $('#did').val(sid); 
    });

$('body').on('click', '.saledeleteItem', function () {

// console.log('delete button is clicked');
var numbercount=$('#numberofItemsLbl').html();
console.log('number of item='+numbercount);
if(numbercount=='1')
{
console.log('you can not remove ');
    $("#myToast").toast({ delay: 10000 });
    $("#myToast").toast('show');
    $('#toast-massages').html("You cant remove all items");
    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
}
else
{
$("#examplemodal-delete").modal('show');
$("#deleteBtnItemChild").hide();
$("#deleteBtn").hide();
$("#deleteBtnsaleItemChild").show();
var sid = $(this).data('id');
var headerid=$(this).data('hid');
console.log('table id='+sid)
console.log('hedaer id='+headerid);
$('#did').val(sid);
$('#hid').val(headerid);
}



});
    $('body').on('click', '.deleteItem', function () {

        // console.log('delete button is clicked');
       
        $("#examplemodal-delete").modal('show');
        $("#deleteBtnItemChild").show();
        $("#deleteBtnsaleItemChild").hide();
        
        $("#deleteBtn").hide();
        var sid = $(this).data('id');
        var headerid=$(this).data('hid');
        console.log('hedaer id='+headerid);
        $('#did').val(sid);
        $('#hid').val(headerid);


    });

    
    $('body').on('click', '.saleunVoid', function () {
        var status=$(this).data('status');
        if(status=='Void')
        {
        $("#receivingcheckmodal").modal('show');
        $("#confirmLbl").html('Are you sure you want Undo Void Sales');
        $("#voucherNumberDive").show();
        $("#checkedbtnvoid").hide();
        $("#checkedbtnunvoid").show();
        $("#checkedbtnpending").hide();
        $("#checkedbtnsale").hide();
        $("#checkedbtnconfirm").hide();

        var headid= $(this).data('id');
        //  console.log('head id='+headid);
          $('#checkedid').val(headid);
          $('#checkedst').val('unVoid');

        }
        else
        {
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Sales Should be Void First");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
        
        }

    });

    $('#checkedbtnunvoid').click(function(){ 

//console.log('checked bnt sale is clicked');
var headid=$('#checkedid').val();
console.log('vhid='+headid);

var registerForm = $("#checkreceivingform");
var formData = registerForm.serialize();   

$.ajax({
url:'/checkedsale/'+headid,
type:'DELETE',
data:formData,
beforeSend:function(){
    $('#checkedbtnunvoid').text(' Un Void...');
    $('#checkedbtnunvoid').prop('disabled',true);

},
success:function(data) {

        if(data.success)
        {
            if(data.success)
        {
$('#checkedbtnunvoid').text('Undo Void');
$('#checkedbtnunvoid').prop('disabled',false);
$("#myToast").toast({ delay: 4000 });
$("#myToast").toast('show');
$('#toast-massages').html("Sale Undo Void Successfully");
$('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
$("#receivingcheckmodal").modal('hide');
$("#docInfoModal").modal('hide');
$("#checkreceivingform")[0].reset();
var oTable = $('#laravel-datatable-crud').dataTable(); 
oTable.fnDraw(false);
        }
    }
    if(data.dberrors)
    {
        $('#checkedbtnunvoid').prop('disabled',false);
        $('#checkedbtnunvoid').text('Undo Void');
        $( '#undoVoucherNumber-error' ).html("The Voucher number has been taken");

    }
    if(data.errors)
    {
       
        if(data.errors.undoVoucherNumber)
        {
            $('#checkedbtnunvoid').prop('disabled',false);
           $('#checkedbtnunvoid').text('Undo Void');
            $( '#undoVoucherNumber-error' ).html( data.errors.undoVoucherNumber[0] );
        }

    }

},
});

});

$('body').on('click', '.saleRefund', function () {
    var status=$(this).data('status');
      // $('#currentstatus').val(status);
     // console.log('st=='+status);
       if(status=='Refund')
       {
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Sales Already Refund");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
       }
       else
       {

        $("#refundreasonmodal").modal('show');
        var headid= $(this).data('id');
        //  console.log('head id='+headid);
          $('#refundid').val(headid);
          $('#refundtatus').val('Refund');
          $('#refundcurrentstatus').val(status);
       }


});

     $('body').on('click', '.saleVoid', function () {
       
        var status=$(this).data('status');
        $('#currentstatus').val(status);
        if(status=='Void')
        {
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Sales already voided");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
        }
        else
        {
        $("#receivingcheckmodal").modal('show');
        $("#confirmLbl").html('Are you sure you want Void Sales');
        $("#voucherNumberDive").hide();
        $("#checkedbtnvoid").show();
        $("#checkedbtnunvoid").hide();
        $("#checkedbtnpending").hide();
        $("#checkedbtnsale").hide();
        $("#checkedbtnconfirm").hide();

        var headid= $(this).data('id');
        //  console.log('head id='+headid);
          $('#checkedid').val(headid);
          $('#checkedst').val('Void');
       }
       

       

    });

    $('#refundbtn').click(function(){ 

//console.log('checked bnt sale is clicked');
var headid=$('#refundid').val();
//console.log('vhid='+headid);

var registerForm = $("#refundreasonform");
var formData = registerForm.serialize();   

$.ajax({
url:'/refundsale/'+headid,
type:'DELETE',
data:formData,
beforeSend:function(){$('#refundbtn').text('Refund...');},
success:function(data) {

        if(data.success)
        {
            if(data.success)
        {
$('#refundbtn').text('Refund');
$("#myToast").toast({ delay: 4000 });
$("#myToast").toast('show');
$('#toast-massages').html("Sale  Refund Successfully");
$('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
$("#refundreasonmodal").modal('hide');
//$("#docInfoModal").modal('hide');
$("#refundreasonform")[0].reset();
var oTable = $('#laravel-datatable-crud').dataTable(); 
oTable.fnDraw(false);
        }
    }
    if(data.errors)
    {
        $('#refundbtn').text('Refund');
        $('#reason-error' ).html( data.errors.Reason[0] );
    }

},
});

});

    $('#checkedbtnvoid').click(function(){ 

//console.log('checked bnt sale is clicked');
var headid=$('#checkedid').val();
console.log('vhid='+headid);

var registerForm = $("#checkreceivingform");
var formData = registerForm.serialize();   

$.ajax({
url:'/checkedsale/'+headid,
type:'DELETE',
data:formData,
beforeSend:function(){$('#checkedbtnvoid').text('Void...');},
success:function(data) {

        if(data.success)
        {
            if(data.success)
        {
            $('#checkedbtnvoid').text('Void');
            $("#myToast").toast({ delay: 4000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Sale  Void Successfully");
            $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
            $("#receivingcheckmodal").modal('hide');
            $("#docInfoModal").modal('hide');
            $("#checkreceivingform")[0].reset();
            var oTable = $('#laravel-datatable-crud').dataTable(); 
            oTable.fnDraw(false);
        }
    }
},
});

});

    
    
    $('body').on('click', '.saleinfoProductItem', function () {
        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
        var sid = $(this).data('id');
        var vstatus='';
        $('#statusid').val(sid);
        $("#docInfoModal").modal('show');  
        $("#saletable").show();
        $("#holdtable").hide();
        $("#docInfoholdItem").hide();
        $("#docInfosaleItem").show();
        $.get("/showSale" +'/' + sid , function (data) 
                 { 
                        $('#infoDocCustomerCategory').text(data.ccat);
                        $('#infoDocCustomerName').text(data.cname);
                        $('#infoDocPaymentType').text(data.sale.PaymentType);
                        $('#infoDocVoucherType').text(data.sale.VoucherType);
                        $('#infoDocVoucherNumber').text(data.sale.VoucherNumber);
                        $('#infoDowitholdNumber').text(data.sale.witholdNumber);
                        $('#infoDocVatNumber').text(data.sale.vatNumber);
                        $('#infoDocsaleShop').text(data.storeName);
                        $('#infoDocDate').text(data.sale.CreatedDate);
                        $('#infoDocholdby').text(data.sale.Username);
                        $('#infoCheckedby').text(data.sale.CheckedBy);
                        $('#infoCheckedDate').text(data.sale.CheckedDate);
                        $('#infoConfirmedby').text(data.sale.ConfirmedBy);
                        $('#infoConfirmedDate').text(data.sale.ConfirmedDate);
                        $('#infoPendingby').text(data.sale.ChangeToPendingBy);
                        $('#infoPendingDate').text(data.sale.ChangeToPendingDate);
                        $('#infovoidby').text(data.sale.VoidedBy);
                        $('#infovoidate').text(data.sale.VoidedDate);
                        $('#infounvoidby').text(data.sale.UnvoidBy);
                        $('#infunvoiddate').text(data.sale.UnVoidDate);
                        $('#infocreateddate').text(data.createdate);
                        


                        $('#infowitholdingAmntLbl').text(numformat(data.sale.WitholdAmount));
                        $('#infovatAmntLbl').text(numformat(data.sale.Vat));
                        $('#infonetpayLbl').text(numformat(data.sale.NetPay));
                        $('#infonumberofItemsLbl').text(numformat(data.countItem));
                        $('#infosubtotalLbl').text(numformat(data.sale.SubTotal));
                        $('#infotaxLbl').text(numformat(data.sale.Tax)); 
                        $('#infograndtotalLbl').text(numformat(data.sale.GrandTotal));
                        $('#infodiscountamountextLbl').html('Discount ('+data.sale.DiscountPercent+'%):');
                        $('#infodiscountLbl').text(numformat(data.sale.DiscountAmount));
                        
                        $('#infosubtotali').val(data.sale.BeforeTaxPrice);
                        $('#infotaxi').val(data.sale.TaxAmount);  
                        $('#infograndtotali').val(data.sale.TotalPrice);
                        $('#infodiscountin').val(data.sale.DiscountAmount);

                        vstatus=data.sale.Status;
                        console.log('status='+vstatus);
                        var p=data.sale.PaymentType;
                        console.log('pp='+p);

                        var withHoldval=data.sale.WitholdAmount;
                        var vatval=data.sale.Vat;
                        var netPayval=data.sale.NetPay;

                        var discounthider=data.sale.DiscountAmount;
                        var witholdsetle=data.sale.WitholdSetle;
                        var vatsetled=data.sale.VatSetle;
                        var defaultPriceVal=data.defualPrice;
                        var custvat=data.custvat;
                        var custwithold=data.custwithold;
                        var SubTotal=data.sale.SubTotal;
                        var GrandTotal=data.sale.GrandTotal;
                        var SalesWithHold=data.SalesWithHold;
                        var vatDeduct=data.vatDeduct;

                        if(defaultPriceVal=='Retailer')
                                {
                                    $('#itemheadinfo').show();  
                                }
                                if(defaultPriceVal=='Wholeseller')
                                {
                                    $('#itemheadinfo').show();  
                                }
                        
                        if(vatsetled=='0')
                        {
                           // alert(vatsetled);
                           $('#infovatTitleLbl').html("<p style='color:#f0ad4e;'><b>Not Settled</b> Vat("+custvat+'%):</p>'); 
                        }
                        if(vatsetled=='1')
                        {
                           $('#infovatTitleLbl').html("Vat("+custvat+'%):'); 
                        }
                        if(witholdsetle=='0')
                        {
                           $("#infowithodingTitleLbl").html("<p style='color:#f0ad4e;'><b>Not Settled</b> WithHold("+custwithold+'%):</p>'); 
                        }
                        if(witholdsetle=='1')
                        {
                           $('#infowithodingTitleLbl').html("WithHold("+custwithold+'%):'); 
                        }
                        if(discounthider<=0||discounthider==null)
                            {
                                $('#infodiscountTr').hide();
                            }
                            if(discounthider>0&&discounthider!=null)
                            {
                                $('#infodiscountTr').show();
                            }
                        if(withHoldval=='0')
                        {
                            $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide(); 
                             //$("#infovatTr").show(); 

                        }

                        if(vatval=='0')
                        {
                          //  $("#infowitholdingTr").hide();
                            $("#infonetpayTr").hide(); 
                             $("#infovatTr").hide(); 

                        }

                        
                        if(withHoldval!='0')
                        {
                            $("#infowitholdingTr").show();
                            $("#infonetpayTr").show(); 
                            // $("#infovatTr").show(); 
                        }
                        if(vatval!='0')
                        {
                            $("#infonetpayTr").show(); 
                             $("#infovatTr").show(); 
                        }
                        if(parseFloat(withHoldval)==0&&parseFloat(custwithold)!=0&&parseFloat(SubTotal)>=parseFloat(SalesWithHold))
                        {
                            var newWithold=((parseFloat(SubTotal)*parseFloat(custwithold))/100).toString().match(/^\d+(?:\.\d{0,2})?/);
                            var newnetpay=(parseFloat(GrandTotal)-parseFloat(newWithold)).toString().match(/^\d+(?:\.\d{0,2})?/);
                            $("#infowithodingTitleLbl").html("<p style='color:#f0ad4e;'><b>Not Settled</b> WithHold("+custwithold+'%):</p>'); 
                            $('#infowitholdingAmntLbl').text(numformat(newWithold));
                            $('#infonetpayLbl').text(numformat(newnetpay));
                            $("#infonetpayTr").show();
                            $("#infowitholdingTr").show();
                        }

                        if(parseFloat(vatval)==0&&parseFloat(custvat)!=0&&parseFloat(SubTotal)>=parseFloat(vatDeduct))
                        {
                            var newVat=((parseFloat(SubTotal)*parseFloat(custvat))/100).toString().match(/^\d+(?:\.\d{0,2})?/);
                            var newnetpay=(parseFloat(GrandTotal)-parseFloat(newVat)).toString().match(/^\d+(?:\.\d{0,2})?/);
                            $('#infovatTitleLbl').html("<p style='color:#f0ad4e;'><b>Not Settled</b> Vat("+custvat+'%):</p>'); 
                            $('#infovatAmntLbl').text(numformat(newVat));
                            $('#infonetpayLbl').text(numformat(newnetpay));
                            $("#infonetpayTr").show();
                            $("#infovatTr").show(); 
                        }
                        
                        if((parseFloat(vatval)==0&&parseFloat(custvat)!=0&&parseFloat(SubTotal)>=parseFloat(vatDeduct))&&(parseFloat(withHoldval)==0&&parseFloat(custwithold)!=0&&parseFloat(SubTotal)>=parseFloat(SalesWithHold)))
                        {
                            var newVat=((parseFloat(SubTotal)*parseFloat(custvat))/100).toString().match(/^\d+(?:\.\d{0,2})?/);
                            var newWithold=((parseFloat(SubTotal)*parseFloat(custwithold))/100).toString().match(/^\d+(?:\.\d{0,2})?/);
                            var deduct=parseFloat(newVat)+parseFloat(newWithold);
                            var newnetpay=(parseFloat(GrandTotal)-parseFloat(deduct)).toString().match(/^\d+(?:\.\d{0,2})?/);
                            $('#infovatTitleLbl').html("<p style='color:#f0ad4e;'><b>Not Settled</b> Vat("+custvat+'%):</p>'); 
                            $('#infovatAmntLbl').text(numformat(newVat));
                            $("#infowithodingTitleLbl").html("<p style='color:#f0ad4e;'><b>Not Settled</b> WithHold("+custwithold+'%):</p>'); 
                            $('#infowitholdingAmntLbl').text(numformat(newWithold));
                            $('#infonetpayLbl').text(numformat(newnetpay));
                            $("#infonetpayTr").show();
                            $("#infovatTr").show(); 
                            $("#infowitholdingTr").show();
                        }

            
                            if(vstatus=='pending..')
                            {
                            $("#changetopending").hide();
                            $("#checksales").show();
                            $("#confirmsales").hide(); 
                            }

                            if(vstatus=='Checked')
                            {
                            $("#changetopending").show();
                            $("#checksales").hide();
                            $("#confirmsales").show(); 
                            }

                            if(vstatus=='Confirmed')
                            {
                            $("#changetopending").hide();
                            $("#checksales").hide();
                            $("#confirmsales").hide(); 
                            }
                            if(vstatus=='Refund')
                            {
                            $("#changetopending").hide();
                            $("#checksales").hide();
                            $("#confirmsales").hide(); 
                            }

                            if(vstatus=='Void')
                            {
                            $("#changetopending").hide();
                            $("#checksales").hide();
                            $("#confirmsales").hide(); 
                            }


       // calculateIndividaulGrandTotal();

        });
        

        $('#docInfosaleItem').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                searching: true,
                paging: false,
                info: false,
                //retrieve: true,
                destroy:true,
        
                "order": [[ 0, "desc" ]],
                "pagingType": "simple",
                language: { search: '', searchPlaceholder: "Search here"},
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
       
         ajax: {
            url: '/saleinfoslateitemlist/'+sid,
            type: 'GET',
            },
            columns: [
           // { data: 'id', name: 'id', 'visible': false },
           { data: 'Code', name: 'Code' },
            { data: 'ItemName', name: 'ItemName' },
            { data: 'SKUNumber', name: 'SKUNumber' },
            { data: 'Quantity', name: 'Quantity' },
            { data: 'Dprice', name: 'Dprice' },
            { data: 'UnitPrice', name: 'UnitPrice' },
            { data: 'Discount', name: 'Discount' },
            { data: 'BeforeTaxPrice', name: 'BeforeTaxPrice' },
            { data: 'TaxAmount', name: 'TaxAmount' },
            { data: 'TotalPrice', name: 'TotalPrice' }
           // { data: 'action', name: 'action' }
            ],

        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Dprice!=null) 
            {
                $(nRow).find('td:eq(4)').show();
            }
            else
            {
                $(nRow).find('td:eq(4)').show();
            }
        }
        });

        var oTable = $('#docInfosaleItem').dataTable(); 
         oTable.fnDraw(false);


    });

    
   

    $('body').on('click', '.infoItem', function () {
   // console.log('info item is clicked');
    var sid = $(this).data('id');
    if(sid!=null)
    {

        $.get("/showItemInfo" +'/' + sid , function (data) 
        {  
            var len=data.length;
            for(var i=0;i<=len;i++) 
            {  
            var itemCodeVar=(data[i].Code);
            var itemTypeVar=(data[i].Type);
            var itemNameVar=(data[i].Name);
            var itemUOMVar=(data[i].UOM);
            var itemCategoryVar=(data[i].Category);
            var itemRpVar=(data[i].RetailerPrice);
            var itemWsVar=(data[i].WholesellerPrice);
            var itemPnVar=(data[i].PartNumber);
            var itemSnVar=(data[i].SKUNumber);
            var itemTaxVar=(data[i].TaxTypeId);
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
    

    });

    $('body').on('click', '.saleeditItem', function () {
        $("#IteminlineForm").modal('show');
        $("#savebuttonsaleitem").show();
        $("#savebuttonitem").hide();
        var id = $(this).data('id');
        var storeid=$('#store').val();
        var uomname = $(this).data('uom');

	    $('#storeId').val(storeid); 
        $('#triggervalue').val('1'); 
        //var ItemIdSend='';
        // console.log(id);
        
        $('#itemid').val(id);
        $.get("/showsaleItem" +'/' + id , function (data) {

           
            $('#ItemName').selectpicker('val',data.saleholditem.ItemId).trigger('change');
           var ItemIdSend=data.saleholditem.ItemId;
            $('#HeaderId').val(data.saleholditem.HeaderId);
            $('#Quantity').val(data.saleholditem.Quantity);
            $('#defPrice').val(data.saleholditem.Dprice);
            
            $('#UnitPrice').val(data.saleholditem.UnitPrice);
            $('#commonId').val(data.saleholditem.Common);
            $('#mainPricei').val(data.saleholditem.UnitPrice*data.saleholditem.ConversionAmount);
             $('#Discount').val(data.saleholditem.Discount);
             $('#BeforeTaxPrice').val(data.saleholditem.BeforeTaxPrice);
             $('#TaxAmount').val(data.saleholditem.TaxAmount);
             $('#TotalPrice').val(data.saleholditem.TotalPrice);
             $('#discountiamount').val(data.saleholditem.DiscountAmount);
             $('#convertedqi').val(data.saleholditem.ConvertedQuantity);
            $('#convertedamnti').val(data.saleholditem.ConversionAmount);
            $('#newuomi').val(data.saleholditem.NewUOMId);
            $('#defaultuomi').val(data.saleholditem.DefaultUOMId);


        

         $("#uoms").empty();
        $('#uoms').find('option').not(':first').remove();
        var newuom= $('#newuomi').val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            if(ItemIdSend!=null)
            {

                $.ajax({
                url:'saleUOMS/'+ItemIdSend,
                type:'DELETE',
                data:'',
                success:function(data)
                {
                    if(data.sid)
                    {
                        var options = "<option selected value='"+newuom+"'>"+uomname+"</option>";
                        $("#uoms").append(options);
                        var defname=data['defuom'];
                        var defid=data['uomid'];
                        var option = "<option value='"+defid+"'>"+defname+"</option>";
                        $("#uoms").append(option);
                        var len=data['sid'].length;
                        for(var i=0;i<=len;i++)
                        {
                            var name=data['sid'][i].ToUnitName;
                            var id=data['sid'][i].ToUomID;
                            var option = "<option value='"+id+"'>"+name+"</option>";
                            $("#uoms").append(option); 
                        }
                        
                        $("#uoms").select2();
                    }
                },
            });
            }
            

        });

        var defaultprice=$('#cdefaultPrice').html();
         if(defaultprice=='Wholeseller')
         {
             $('#editptypeth').show();
             $('#editptypetd').show();
            //$('tr td:nth-child(5)').show();
         }
         if(defaultprice=='Retailer')
         {
            $('#editptypeth').hide();
            $('#editptypetd').hide();
            // $('#dprthead').hide();
           // $('tr td:nth-child(5)').hide();
         }

             });

    $('body').on('click', '.editItem', function () {
        $("#IteminlineForm").modal('show');
        $("#savebuttonsaleitem").hide();
        $("#savebuttonitem").show();

        
        var id = $(this).data('id');
        // console.log(id);
        
        $('#itemid').val(id);
        $.get("/showholdItem" +'/' + id , function (data) {

            $('#ItemName').selectpicker('val',data.saleholditem.ItemId).trigger('change');
            $('#HeaderId').val(data.saleholditem.HeaderId);
            $('#Quantity').val(data.saleholditem.Quantity);
            $('#defPrice').val(data.saleholditem.Dprice);
            $('#UnitPrice').val(data.saleholditem.UnitPrice);
            $('#commonId').val(data.saleholditem.Common);
             $('#mainPricei').val(data.saleholditem.UnitPrice*data.saleholditem.ConversionAmount);
             $('#Discount').val(data.saleholditem.Discount);
             $('#BeforeTaxPrice').val(data.saleholditem.BeforeTaxPrice);
             $('#TaxAmount').val(data.saleholditem.TaxAmount);
             $('#TotalPrice').val(data.saleholditem.TotalPrice);

        });

        var defaultprice=$('#cdefaultPrice').html();
         if(defaultprice=='Wholeseller')
         {
             $('#editptypeth').show();
             $('#editptypetd').show();

            //$('tr td:nth-child(5)').show();
         }
         if(defaultprice=='Retailer')
         {
            $('#editptypeth').hide();
            $('#editptypetd').hide();
           
         }


             });

             $('body').on('click', '.enVoice', function () {
                var id = $(this).data('id');
                var link=$(this).data('link');
               // console.log('clicked yes='+id);
               // console.log('liink='+link);
               window.open(link, 'Sales', 'width=1200,height=800,scrollbars=yes');
              
             
            });
             $('body').on('click', '.saleeditProduct', function () {
                var id = $(this).data('id');
                var status = $(this).data('status');

                if(status=='pending..'||status=='Checked')
                {
                // $('#customerdivedit').show();
                // $('#customerdiv').hide();
                $('#storedivedit').show();
                $('#storediv').hide();
                $("#inlineForm").modal('show');  
                $("#dynamicTable").hide();
                $("#pricetable").show();
                $("#datatable-crud-child").hide();
                $("#datatable-crud-childsale").show();
                $("#adds").hide();
                $("#addnew").show();
                $("#addnewhold").hide();
                $("#saveupbutton").hide();
                $("#savebuttonhold").hide();
                $("#savebuttoncopy").hide();
                $("#savebutton").show();
                // $('#hidewitholdi').val('1');
                // $('#hidevati').val('1'); 
                // $("#rdiv").hide();
                // $("#wdiv").hide();
               $('#myModalLabel333').html("Update Sale");
                
                $('#id').val(id);
                 

                $.get("/showSale" +'/' + id , function (data) {
                   // alert(data.sale.DiscountPercent);
                   $('#discountamountli').val(data.sale.DiscountAmount);
           
               
           // $('#customer').selectpicker('val',data.sale.CustomerId).trigger('change');
            $('#paymentType').val(data.sale.PaymentType);
            $('#voucherType').val(data.sale.VoucherType);
            $('#voucherNumber').val(data.sale.VoucherNumber);

            $('#date').val(data.sale.CreatedDate);
            $('#CustomerMRC').selectpicker('val',data.sale.CustomerMRC);
            $('#store').selectpicker('val',data.sale.StoreId);
            $('#customeredit').val(data.custcode+" "+data.cname+" "+data.custTinNumber);
            $('#storeedit').val(data.storeName);
            $('#salecounti').val(data.sale.Common);
            $('#numberofItemsLbl').html(data.countItem);
            $('#numbercounti').val(data.countItem);
                    var SubTotal=data.sale.SubTotal;
            $('#subtotalLbl').html(numformat(SubTotal));
            $('#taxLbl').html(numformat(data.sale.Tax));  
            $('#grandtotalLbl').html(numformat(data.sale.GrandTotal));
            $('#discountamountLbl').html(numformat(data.sale.DiscountAmount));
            $('#discountamountextLbl').html('Discount ('+data.sale.DiscountPercent+'%):');

            $('#witholdingAmntLbl').html(numformat(data.sale.WitholdAmount));
            $('#netpayLbl').html(numformat(data.sale.NetPay));
            $('#vatAmntLbl').html(numformat(data.sale.Vat));

            $('#witholdingAmntin').val(data.sale.WitholdAmount);
            $('#netpayin').val(data.sale.NetPay);  
            $('#vatAmntin').val(data.sale.Vat);     


            $('#subtotali').val(data.sale.SubTotal);
            $('#taxi').val(data.sale.Tax);  
            $('#grandtotali').val(data.sale.GrandTotal);
            $('#discountamountli').val(data.sale.DiscountAmount);
            $('#discountpercenti').val(data.sale.DiscountPercent);
           
            

            $('#witholdMinAmounti').val(data.SalesWithHold);
            $('#servicewitholdMinAmounti').val(data.ServiceWithHold);
            $('#vatAmount').val(data.vatDeduct);
            

            var voucherTypeVal=data.sale.VoucherType;
            var discounthider=data.sale.DiscountAmount;
            var WitholdAmountVal=data.sale.WitholdAmount;
            var NetPayVal=data.sale.NetPay;
            var vatVal=data.sale.vat;
            var defaultPriceVal=data.defualPrice;
            var witholdsetle=data.sale.WitholdSetle;
            var vatsetled=data.sale.VatSetle;
            $('#hidewitholdi').val(witholdsetle);
            $('#hidevati').val(vatsetled);

           
           // alert(defaultPriceVal); 
           if(defaultPriceVal=='Retailer')
           {
            $('#Retailcustomer').selectpicker('val',data.sale.CustomerId).trigger('change');
            $('#customerdiv').hide();
            $('#customerrdiv').show();
            $('#customerwdiv').hide();
            $('#itemhead').hide();
            
           }
           if(defaultPriceVal=='Wholeseller')
           {
            $('#Wholesellercustomer').selectpicker('val',data.sale.CustomerId).trigger('change');
            $('#customerdiv').hide();
            $('#customerrdiv').hide();
            $('#customerwdiv').show(); 
            $('#itemhead').show();
           }
            if(voucherTypeVal=='Manual-Receipt')
            { 
                $('#mrcdiv').hide();
            }
            if(voucherTypeVal=='Fiscal-Receipt')
            {
                $('#mrcdiv').show();
            }
          //  alert(discounthider);
            if(discounthider<=0||discounthider==null)
            {
                $('#discountTr').hide();
            }
            if(discounthider>0&&discounthider!=null)
            {
                $('#discountTr').show();
            }

           $('#storeedit').prop('readonly', true);
           
            calculateIndividaulGrandTotal();

           

                });

                

                
                 

 $('#datatable-crud-childsale').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        info: false,
        destroy: true,
        
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
       
        ajax: {
            url: '/salechildsalelist/'+id,
            type: 'GET',
            },
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data: 'ItemName', name: 'ItemName' },
            { data: 'Quantity', name: 'Quantity' },
            { data: 'Dprice', name: 'Dprice' },
            { data: 'UnitPrice', name: 'UnitPrice' },
            { data: 'Discount', name: 'Discount'},
            { data: 'BeforeTaxPrice', name: 'BeforeTaxPrice' },
            { data: 'TaxAmount', name: 'TaxAmount' },
            { data: 'TotalPrice', name: 'TotalPrice' },
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Dprice!=null) 
            {
                $(nRow).find('td:eq(2)').show();
                $('#itemhead').show();
            }
            if(aData.Dprice==null)
            {
                $(nRow).find('td:eq(2)').hide();
                $('#itemhead').hide();
            }
        }
       
        });

                }
                else
                {
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Pending Data is only Editable");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
       
                }
               
                });
    $('body').on('click', '.editProduct', function () {
       // $("#Register")[0].reset();
        $("#inlineForm").modal('show');
        $("#saveupbutton").hide();
        $("#savenewbutton").hide();
        $('#storedivedit').hide();
        $('#storediv').show();
        // $('#customerdivedit').show();
        // $('#customerdiv').hide();
        $("#savebutton").hide();
        $("#savebuttonhold").show();
        $("#savebuttoncopy").show();
        $("#dynamicTable").hide();
        $("#adds").hide();
        $("#addnew").hide();
        $("#addnewhold").show();
        $("#pricetable").show();
        $("#iteminfo").hide();
        $("#datatable-crud-child").show();
        $("#datatable-crud-childsale").hide();
        $('#myModalLabel333').html("Update Hold Sales");
        $("#witholdingTr").show();
        $("#netpayTr").show(); 
        $("#vatTr").show(); 
        $("#calcutionhide").val('1');
        var id = $(this).data('id');
        $.get("/showhold" +'/' + id , function (data) {
        $('#id').val(id);
            
            console.log(data.salehold.CustomerId);
            
         //$('#customer option[value="'+data.salehold.CustomerId+'"]').attr('selected',true);
          
            var text1=data.custname;
            console.log(text1);
           
          //  $('#customer').selectpicker('val',data.salehold.CustomerId).trigger('change');
            $('#paymentType').val(data.salehold.PaymentType);
            $('#voucherType').val(data.salehold.VoucherType);
            $('#voucherNumber').val(data.salehold.VoucherNumber);
            $('#date').val(data.salehold.VoidedDate);
            // $('#store').val(data.salehold.StoreId);
            $('#CustomerMRC').selectpicker('val',data.salehold.CustomerMRC);
            $('#store').selectpicker('val',data.salehold.StoreId);
            $('#customeredit').val(data.cname);
            $('#salecounti').val(data.salehold.Common);
            $('#numberofItemsLbl').text(data.countitem);
            $('#numbercounti').val(data.countitem);           
            $('#subtotalLbl').text(data.salehold.SubTotal);
            $('#taxLbl').text(data.salehold.Tax);  
            $('#grandtotalLbl').text(data.salehold.GrandTotal);
            $('#discountamountLbl').text(data.salehold.DiscountAmount);
            $('#discountamountextLbl').html('Discount ('+data.salehold.DiscountPercent+'%):');
           


            $('#witholdingAmntLbl').text(data.salehold.WitholdAmount);
            $('#netpayLbl').text(data.salehold.NetPay);
            $('#vatAmntLbl').text(data.salehold.Vat);

            $('#witholdingAmntin').val(data.salehold.WitholdAmount);
            $('#netpayin').val(data.salehold.NetPay);  
            $('#vatAmntin').val(data.salehold.Vat); 

            $('#subtotali').val(data.salehold.SubTotal);
            $('#taxi').val(data.salehold.Tax);  
            $('#grandtotali').val(data.salehold.GrandTotal); 
            $('#discountamountli').val(data.salehold.DiscountAmount); 
            $('#discountpercenti').val(data.salehold.DiscountPercent);



            $('#witholdMinAmounti').val(data.SalesWithHold);
            $('#servicewitholdMinAmounti').val(data.ServiceWithHold);
            $('#vatAmount').val(data.vatDeduct);

            var voucherTypeVal=data.salehold.VoucherType;
            var discounthider=data.salehold.DiscountAmount;

            var defaultPriceVal=data.defualPrice;
           // alert(defaultPriceVal); 
           if(defaultPriceVal=='Retailer')
           {
            $('#Retailcustomer').selectpicker('val',data.salehold.CustomerId).trigger('change');
            $('#customerdiv').hide();
            $('#customerrdiv').show();
            $('#customerwdiv').hide();
            $('#itemheadholdedit').hide();
           }
           if(defaultPriceVal=='Wholeseller')
           {
            $('#Wholesellercustomer').selectpicker('val',data.salehold.CustomerId).trigger('change');
            $('#customerdiv').hide();
            $('#customerrdiv').hide();
            $('#customerwdiv').show(); 
            $('#itemheadholdedit').show();
           }
   
            if(voucherTypeVal=='Manual-Receipt')
            {
                $('#mrcdiv').hide();
            }
            if(voucherTypeVal=='Fiscal-Receipt')
            {
                $('#mrcdiv').show();
            }
            if(discounthider<=0||discounthider==null)
            {
                $('#discountTr').hide();
            }
            if(discounthider>0&&discounthider!=null)
            {
                $('#discountTr').show();
            }

          calculateIndividaulGrandTotal();

        });

        $(document).ready( function () 
    {
        $('#datatable-crud-child').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        searching: false,
        paging: false,
        info: false,
       destroy: true,
        "order": [[ 0, "desc" ]],
        "pagingType": "simple",
        language: { search: '', searchPlaceholder: "Search here"},
       
        ajax: {
            url: '/salechildholdlist/'+id,
            type: 'GET',
            },
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data: 'ItemName', name: 'ItemName' },
            { data: 'Quantity', name: 'Quantity' },
            { data: 'Dprice', name: 'Dprice' },
            { data: 'UnitPrice', name: 'UnitPrice' },
            { data: 'Discount', name: 'Discount' },
            { data: 'BeforeTaxPrice', name: 'BeforeTaxPrice' },
            { data: 'TaxAmount', name: 'TaxAmount' },
            { data: 'TotalPrice', name: 'TotalPrice' },
            { data: 'action', name: 'action' }
        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) 
        {
            if (aData.Dprice!=null) 
            {
                $(nRow).find('td:eq(2)').show();
            }
            else
            {
                $(nRow).find('td:eq(2)').hide();
            }
        }
        });
        
    });



    });


function mrcValid()
{
    var voucherTypeVal=voucherType.value; 
    var CustomerMRCVal=CustomerMRC.value;
    
    if(voucherTypeVal=="Manual-Receipt")
    {
        $('#mrcdiv').hide();
        $('#CustomerMRC').val('');
    }
    else
    {
        $('#mrcdiv').show();
       
    }

}
function removeundoVoucherNumberErrorclose()
{
$('#undoVoucherNumber-error').html('');
$('#undoVoucherNumber').val("");
}
function removeundoVoucherNumberError()
{
$('#undoVoucherNumber-error').html('');
//$('#undoVoucherNumber').val("");
}
function removeQuantityValidation()
{ 
$('#Quantity-error').html('');
}
function removeUnitPriceValidation()
{ 
$('#UnitPrice-error').html('');
}
function removeDiscountValidation()
{ 
$('#discount-error').html('');
}
     $(".ItemName").on("show.bs.select", function() {
         // alert("hello");
         $('#triggervalue').val('0');
        });
function removeItemNameValidation()
{ 
            $('#ItemName-error' ).html('');
            $('#ItemType-error' ).html(''); 
            $('#UnitPrice-error' ).html(''); 
            $('#Quantity').val('');
			$('#Discount').val('');
			$('#BeforeTaxPrice').val('0');
            $('#TaxAmount').val('0');
            $('#TotalPrice').val('0');
            

       var sid=$('#ItemName').val();
       var type=$('#Type').val();
       var defaultprice=$('#cdefaultPrice').html();
       var storeval = store.value;
    console.log('defualt price add=='+defaultprice);
    if(sid!='')
    {
        $.get("/showItemInfo" +'/' + sid +'/'+storeval , function (data)
    {
        var len=data['Regitem'].length;
        for(var i=0;i<=len;i++) 
             {  
                 var rprice=(data['Regitem'][i].RetailerPrice);
                 var wprice=(data['Regitem'][i].WholesellerPrice);
                 var wholesalminamount=data['Regitem'][i].wholeSellerMinAmount;
                 var avalaiblequantity=data['getQuantity'][i].AvailableQuantity;
                 $('#maxicost').val(data['Regitem'][i].Maxcost/1.15);
                  var maxcostVal=data['Regitem'][i].Maxcost;
                    var triggerVal=$('#triggervalue').val(); 

                    if(triggerVal==='0')
                    {

                        if(defaultprice=='Retailer')
                        {
                        if(parseFloat(maxcostVal)>parseFloat(rprice))
                         {
                        $('#UnitPrice').val("");
                        $('#mainPricei').val("");
                         } 
                        else
                         {
                        $('#UnitPrice').val((rprice/1.15).toFixed(2));
                        $('#mainPricei').val((rprice/1.15).toFixed(2));
                        }
                    

                            }
                            if(defaultprice=='Wholeseller')
                            {
                        if(parseFloat(maxcostVal)>parseFloat(wprice))
                            {
                            $('#UnitPrice').val("");
                            $('#mainPricei').val("");
                            } 
                            else
                            {
                            $('#UnitPrice').val((wprice/1.15).toFixed(2));
                            $('#mainPricei').val((wprice/1.15).toFixed(2));
                            }
                        
                        }
                        }
                 
                        if(avalaiblequantity>0){ 
                        
                        $('#avQuantitiy').val(avalaiblequantity);
                        $('#avQuantitiyh').val(avalaiblequantity);
                        }
                        if(avalaiblequantity==null||avalaiblequantity==0)
                        { 
                        
                        $('#avQuantitiy').val('0');
                        }

                        $('#Wsaleminamount').val(wholesalminamount);
                        $('#Rsaleprice').val((rprice/1.15).toFixed(2));
                        $('#Wsaleprice').val((wprice/1.15).toFixed(2));



                 
             }

    });

    }
    

    $("#uoms").empty();
    // var registerForm = $("#Register");
    // var formData = registerForm.serialize();
    if(sid!='')
    {

        $.ajax({
        url:'saleUOMS/'+sid,
        type:'DELETE',
        data:'',
        success:function(data)
        {
            if(data.sid)
            {
                var defname=data['defuom'];
                var defid=data['uomid'];
                var option = "<option selected value='"+defid+"'>"+defname+"</option>";
                $("#uoms").append(option);
                
                $("#defaultuomi").val(defid);
                $("#newuomi").val(defid);
                $("#convertedamnti").val("1");
                var len=data['sid'].length;
                for(var i=0;i<=len;i++)
                {
                    var name=data['sid'][i].ToUnitName;
                    var id=data['sid'][i].ToUomID;
                    var option = "<option value='"+id+"'>"+name+"</option>";
                    $("#uoms").append(option);
                    
                }
                $("#uoms").select2();
            }
        },
    });

    }
    



}
function removeMrcValidation()
{
    $('#CustomerMRC-error' ).html('');
}
function removevoucherNumberValidation()
{ 
$('#vouchernumber-error' ).html('');
}
function removeStoreValidation()
{
    $('#store-error' ).html('');
    $("#dynamicTable").empty();
    $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th>  <th id="dprthead">D Price</th><th>Unit Price</th>@can('sales-discount')<th>Discount</th>@endcan<th>Before Tax</th> <th>Tax Amount</th> <th>Total Price</th><th></th>');
       
}
function removeDateValidation()
{  
    
$('#date-error' ).html('');
}

//Start UOM Change
function uomsavedVal(ele) 
{
    var uomnewval =  $('#uoms').val();
    $('#newuomi').val(uomnewval);
    var uomdefval =  $('#defaultuomi').val();
    var mainpriceVal=$('#mainPricei').val();
    var quntityOnhand=$('#avQuantitiy').val();
    var quntityOnhandh=$('#avQuantitiyh').val();

    if(parseFloat(uomnewval)==parseFloat(uomdefval))
    {
        $('#convertedamnti').val("1");
        $('#UnitPrice').val(mainpriceVal);
        $('#avQuantitiy').val(quntityOnhandh);


    }
    else if(parseFloat(uomnewval)!=parseFloat(uomdefval))
    {
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        if(uomnewval!=null)
        {
            $.ajax({
            url:'getsaleUOMAmount/'+uomdefval+"/"+uomnewval,
            type:'DELETE',
            data:'',
            success:function(data)
            {
                if(data.sid)
                {
                  
                    var amount=data['sid'];
                   
                   var Result=mainpriceVal/amount;
                   var onHandQuantity=quntityOnhandh/amount;
                   $('#UnitPrice').val(Result);
                    $('#convertedamnti').val(amount);
                    $('#avQuantitiy').val(onHandQuantity);

                }
            },
        });

        }
        
    }
    $('#convertedqi').val("");
    $('#Quantity').val("");

    
}
//End UOM change
function defPricechange()
{
    var defp=  $('#defPrice').val();
    var rprice=$('#Rsaleprice').val();
    var wsprice=$('#Wsaleprice').val();
    var taxpercent="15";
    var quantity = $('#Quantity').val();
   
    var minAmount =  $('#Wsaleminamount').val();


    if(defp=='Rp')
    {
    $('#UnitPrice').val(rprice);
    }
    if(defp=='Ws')
    {
        if(parseFloat(quantity)<parseFloat(minAmount))
        {
            $("#myToast").toast({ delay: 10000 });
            $("#myToast").toast('show');
            $('#toast-massages').html("Invalid Price ,The quantity is lessthan the amount of whole sale minimum quantity");
            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
            $('#defPrice').val('Rp');
            $('#UnitPrice').val(rprice);
        }
        else{
            $('#UnitPrice').val(wsprice);
        }

       
    }

    var unitcost =  $('#UnitPrice').val();
           
            //var discount =  $('#Discount').val();

            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;

            if (!isNaN(unitcost) && !isNaN(quantity)) 
            {  
              //  alert('uu');
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
                var linetotal=parseFloat(total)+parseFloat(taxamount);
                $('#BeforeTaxPrice').val(total.toFixed(2));
                $('#TaxAmount').val(taxamount.toFixed(2));
                $('#TotalPrice').val(linetotal.toFixed(2));
            }
            var defuom= $('#defaultuomi').val();
            var newuom=$('#newuomi').val();
            var convamount=$('#convertedamnti').val();
            var convertedq=parseFloat(quantity)/parseFloat(convamount);
            $('#convertedqi').val(convertedq);

}
function CalculateAddHoldTotal(ele) 
    {

        var availableq = $(ele).closest('tr').find('#avQuantitiy').val();
        var quantitys = $(ele).closest('tr').find('#Quantity').val();
        var minAmount=$(ele).closest('tr').find('#Wsaleminamount').val();
        var retialprice=$(ele).closest('tr').find('#Rsaleprice').val();
        var wholesaleprice=$(ele).closest('tr').find('#Wsaleprice').val();
      
        var inputid = ele.getAttribute('id');
        var  defualtprice=$('#cdefaultPrice').html();
       
        if(inputid=='Quantity')
        {
            if(defualtprice=='Wholeseller')
            {
                if(parseFloat(quantitys)<parseFloat(minAmount))
                {
                    $(ele).closest('tr').find('#UnitPrice').val(retialprice); 
                    $('#defPrice').val('Rp');
                }
                if(parseFloat(quantitys)>=parseFloat(minAmount))
                {
                    $(ele).closest('tr').find('#UnitPrice').val(wholesaleprice); 
                    $('#defPrice').val('Ws');
                }
            }
        }
        if(inputid=='UnitPrice')
        {
            $('#defPrice').val('');
        }
        if(parseFloat(quantitys)==0)
        {
            $(ele).closest('tr').find('#Quantity').val('');  
            $('#defPrice').val(''); 
        }
        if(quantitys.length==0)
        {
            $('#defPrice').val(''); 
        }
        $('#Discount').val('');
        $('#discountiamount').val('0');

            if(parseFloat(quantitys)>parseFloat(availableq))
            {
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("There is no available quantity");
                $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                $(ele).closest('tr').find('#Quantity').val('');
            }
            var taxpercent="15";
            var quantity = $('#Quantity').val();
            var unitcost =  $('#UnitPrice').val();
            //var discount =  $('#Discount').val();

            unitcost = unitcost == '' ? 0 : unitcost;
            quantity = quantity == '' ? 0 : quantity;
           

            if (!isNaN(unitcost) && !isNaN(quantity)) 
            {
                var total = parseFloat(unitcost) * parseFloat(quantity);
                var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
                var linetotal=parseFloat(total)+parseFloat(taxamount);
                $('#BeforeTaxPrice').val(total.toFixed(2));
                $('#TaxAmount').val(taxamount.toFixed(2));
                $('#TotalPrice').val(linetotal.toFixed(2));
            }
            var defuom= $('#defaultuomi').val();
            var newuom=$('#newuomi').val();
            var convamount=$('#convertedamnti').val();
            var convertedq=parseFloat(quantity)/parseFloat(convamount);
            $('#convertedqi').val(convertedq);



    }

    function CalculateDiscountSingle(ele)
    {
        var taxpercent="15";
        var quantity = $('#Quantity').val();
        var unitcost =  $('#UnitPrice').val();
        var discount= $('#Discount').val();
        var maxcost=$('#maxicost').val();
        if(parseFloat(discount)==0)
        {
            $('#Discount').val('');
        }
        var total = parseFloat(unitcost) * parseFloat(quantity);
        total=total-(total*discount)/100;

        console.log('ttty='+total);
        var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
        var linetotal=parseFloat(total)+parseFloat(taxamount);
        var discountunitprice=parseFloat(total)/parseFloat(quantity);
        var discountAmount=parseFloat(unitcost)-parseFloat(discountunitprice);
        discountAmount=discountAmount*quantity;
        
        if(discountunitprice<maxcost)
        {
            $('#Discount').val('');
            
            var discounts= $('#Discount').val();
            var total = parseFloat(unitcost) * parseFloat(quantity);
            total=total-(total*discounts)/100;
            var taxamount=(parseFloat(total)*parseFloat(taxpercent)/100);
            var linetotal=parseFloat(total)+parseFloat(taxamount);
            var discountunitprice=parseFloat(total)/parseFloat(quantity);


        $('#BeforeTaxPrice').val(total.toFixed(2));
        $('#TaxAmount').val(taxamount.toFixed(2));
        $('#TotalPrice').val(linetotal.toFixed(2));
        $('#discountiamount').val('0');

        $("#myToast").toast({ delay: 10000 });
        $("#myToast").toast('show');
        $('#toast-massages').html("Discount Amount is Greater Than Cost");
        $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
        
        }
        else if(discountunitprice>=maxcost)
        {
        $('#BeforeTaxPrice').val(total.toFixed(2));
        $('#TaxAmount').val(taxamount.toFixed(2));
        $('#TotalPrice').val(linetotal.toFixed(2));
        $('#discountiamount').val(discountAmount);
        }
        var discounthider=$("#discountamountli").val();
            if(parseFloat(discounthider)>0)
            {
                $("#discountTr").show();
            }
        
    //CalculateGrandTotal();

    }



    function renumberRows() 
    {
        var ind;
        $('#dynamicTable tr').each(function(index, el)
        {
            $(this).children('td').first().text(index++);
            $('#numberofItemsLbl').html(index-1);
            $('#numbercounti').val(index-1);

            ind=index-1;
        });
        if (ind==0)
        {
            $('#itemcodeInfoLbl').text("");
            $('#itemInfoLbl').text("");
            $('#itemInfoLbl').text("");
            $('#uomInfoLbl').text("");
            $('#itemCategoryInfoLbl').text("");
            $('#rpInfoLbl').text("");
            $('#wsInfoLbl').text("");
            $('#partNumInfoLbl').text("");
            $('#skuInfoLbl').text("");
            $('#taxInfoLbl').text("");
            $('#itemInfoCardDiv').hide();
            $('#pricingTable').hide();
        }
        else
        {
            $('#itemInfoCardDiv').show();
            $('#pricingTable').show();
        }
    }


    function closeinlineFormModalWithClearValidation() 
{
    $('#savebutton').prop('disabled',false);
    $("#dynamicTable").empty();
    $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th>UOM</th><th>Qty.on Hand</th><th>Quantity</th> <th>Unit Price</th>@can('sales-discount')<th>Discount</th>@endcan<th>Before Tax</th> <th>Tax Amount</th> <th>Total Pricet</th><th></th>');
    $("#Register")[0].reset(); 
    $('#customer').val(null).trigger('change');     //to make null
   // $('#store').val('--').trigger('change');
    //$('#store').val('1').trigger('change'); // to make null store;
    //$('#CustomerMRC').val('').trigger('change');
        $('#customer-error').html('');
        $('#Quantity-error').html('');
		$('#UnitPrice-error').html('');
		$('#discount-error').html('');
		$('#ItemName-error' ).html('');
		$('#vouchernumber-error' ).html('');
		$('#date-error' ).html('');
        $('#CustomerMRC-error' ).html('');
        $('#customerInfoCardDiv').hide();
        $('#itemInfoCardDiv').hide();
        $('tr td:nth-child(6)').show();
        $( '#paymenttype-error' ).html("");


}

function closeIteminlineFormModalWithClearValidation()
{
        $('#Quantity-error').html('');
		$('#UnitPrice-error').html('');
		$('#discount-error').html('');
		$('#ItemName-error' ).html('');
        $('#ItemType-error' ).html('');
        $('#savebuttonsaleitem').text('Add');
        $('#savebuttonitem').text('Add');
       
        $('#savebuttonitem').prop('disabled',false);
        $('#savebuttonsaleitem').prop('disabled',false);
}
function voidReason() 
    {
        $( '#reason-error' ).html("");
    }
  function removeRecieptnumberError()
  {
    $('#Recieptnumber-error' ).html("");
    $('#witholdRecieptNumber-error' ).html("");
  } 
  function witholdRecieptNumberError()
  {
    $('#witholdRecieptNumber-error' ).html(""); 
  }

  function paymenttyperemoveeroor()
  {
    $( '#paymenttype-error' ).html("");
  }
    function numformat(val)
    {
        while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }
</script>   

@endsection
  