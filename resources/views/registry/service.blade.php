@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Service-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Services</h3>
                            
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;display:none;" id="main-datatable">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 33%;">Service Name</th>
                                            <th style="width: 30%;">Category</th>
                                            <th style="width: 30%;">Status</th>
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
        </section>
    </div>
@endcan

    <!--Registration Modal -->
    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="servicetitle">Add Service</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-xl-3 col-md-6 col-sm-12">
                                                <label strong style="font-size: 14px;">Service Name <b style="color:red;">*</b></label>
                                                <input type="text" placeholder="Enter Service Name here" class="form-control" name="ServiceName" id="ServiceName" onkeyup="removeNameValidation()"/>
                                                <span class="text-danger">
                                                    <strong id="servicename-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12">
                                                <label strong style="font-size: 14px;">Category <b style="color:red;">*</b></label>
                                                <select class="select2 form-control" placeholder="Select category here" name="Category" id="Category" onchange="categoryval()">
                                                    <option selected disabled value=""></option>
                                                    @foreach ($category as $category)
                                                        <option value="{{$category->id}}">{{$category->Name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="category-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12">
                                                <label strong style="font-size: 14px;">Description</label>
                                                <textarea type="text" placeholder="Write description here..." class="form-control" name="Description" id="Description" onkeyup="descval()"></textarea>
                                                <span class="text-danger">
                                                    <strong id="description-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-3 col-md-6 col-sm-12">
                                                <label strong style="font-size: 14px;">Status</label>
                                                <select class="select2 form-control" id="status" name="status" onchange="removeStatusValidation()">
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
                                <div class="divider">
                                    <div class="divider-text">-</div>
                                </div>  
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="table-responsive">
                                            <table id="dynamicTable" class="mb-0 rtable" style="width:100%;">  
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2">#</th>
                                                        <th rowspan="2">Period <b style="color:red;">*</b></th>
                                                        <th rowspan="2">Group <b style="color:red;">*</b></th>
                                                        <th rowspan="2">Payment Term <b style="color:red;">*</b></th>
                                                        <th colspan="2">New Client</th>
                                                        <th colspan="2">Existing Client</th>
                                                        <th rowspan="2">Remark</th>
                                                        <th rowspan="2">Status</th>
                                                        <th rowspan="2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Price <b style="color:red;">*</b></th>
                                                        <th>Trainer Fee</th>
                                                        <th>Price <b style="color:red;">*</b></th>
                                                        <th>Trainer Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            <table style="width:100%">
                                                <tr>
                                                    <td colspan="2">
                                                        <button type="button" name="adds" id="adds" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>    Add New</button>
                                                    <td>
                                                </tr>
                                                <tr style="display:none;" class="totalrownumber">
                                                    <td colspan="2" style="text-align: right;">
                                                        ---------------------------------
                                                    </td>
                                                </tr>
                                                <tr style="display:none;" class="totalrownumber">
                                                    <td style="text-align: right;"><label strong style="font-size: 16px;">No. of Items:</label></td>
                                                    <td style="text-align: right; width:2%"><label id="numberofItemsLbl" strong style="font-size: 16px; font-weight: bold;">0</label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select class="select2 form-control" name="groupcbx" id="groupcbx">
                                <option value=""></option>
                                @foreach ($group as $group)
                                    <option value="{{ $group->id }}">{{ $group->GroupName }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="paymenttermcbx" id="paymenttermcbx">
                                <option value=""></option>
                                @foreach ($pterms as $pterms)
                                    <option value="{{ $pterms->id }}">{{ $pterms->PaymentTermName }}</option>
                                @endforeach
                            </select>
                            <select class="select2 form-control" name="periodcbx" id="periodcbx">
                                <option value=""></option>
                                @foreach ($periodopt as $periodopt)
                                    <option value="{{ $periodopt->id }}">{{ $periodopt->PeriodName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" placeholder="" class="form-control" name="serviceId" id="serviceId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        @if (auth()->user()->can('Service-Add') ||auth()->user()->can('Service-Edit'))
                            <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        @endif
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Service Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Basic Information</h4>
                                                <div class="heading-elements">
                                                    <ul class="list-inline mb-0">
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-content collapse show">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td style="width: 30%"><label strong style="font-size: 14px;">Service Name</label></td>
                                                                <td style="width: 70%"><label id="servicenamelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label strong style="font-size: 14px;">Category</label></td>
                                                                <td><label id="categorynamelbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label strong style="font-size: 14px;">Description</label></td>
                                                                <td><label id="descriptionlbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                            <tr>
                                                                <td><label strong style="font-size: 14px;">Status</label></td>
                                                                <td><label id="statuslbl" strong style="font-size:14px;font-weight:bold;"></label></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="divider newext">
                                                        <div class="divider-text">Action Information</div>
                                                    </div> 
                                                    <div class="row">
                                                        <table style="width: 100%;">
                                                            <tr>
                                                                <td style="width: 35%"><label strong style="font-size: 14px;">Created By</label></td>
                                                                <td style="width: 65%"><label id="createdbylbl" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Payment Term Information</h4>
                                                <div class="heading-elements">
                                                    <ul class="list-inline mb-0">
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-content collapse show">
                                                <div class="card-body">
                                                    <table id="servicedetailtbl" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th style="width: 0%;">#</th>
                                                                <th>Period</th>
                                                                <th>Group</th>
                                                                <th>Payment Term</th>
                                                                <th>New Client Price</th>
                                                                <th>New Trainer Fee</th>
                                                                <th>Existing Client Price</th>
                                                                <th>Existing Trainer Fee</th>
                                                                <th>Remark</th>
                                                                <th>Status</th>
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
                    <div class="modal-footer">
                        <button id="closebuttonb" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->

    <!--Start service delete modal -->
    <div class="modal fade text-left" id="deleteservicemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteserviceform">
                    @csrf
                    <div class="modal-body" style="background-color:#e74a3b">
                        <label strong style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this service?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="serviceDelId" id="serviceDelId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deleteservicebtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonj" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End service delete modal -->


    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });

        var j=0;
        var i=0;
        var m=0;

        $(document).ready(function() {
            $("#main-datatable").hide();
            $('#laravel-datatable-crud').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "lengthMenu": [50,100],
                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/servicelist',
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

                columns: [  
                    {
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:"3%"
                    },
                    {
                        data: 'ServiceName',
                        name: 'ServiceName',
                        width:"33%"
                    },
                    {
                        data: 'CategoryName',
                        name: 'CategoryName',
                        width:"30%"
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
                    {
                        data: 'action',
                        name: 'action',

                    }
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                        @can('Service-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addserbutton" id="addserbutton">Add</button>
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

        $('body').on('click', '#addserbutton', function() {
            $('#Category').select2
            ({
                placeholder: "Select Category here",
            });
            $('#status').select2({
                minimumResultsForSearch: -1
            });
            j = 0;
            $('#ServiceName').val("");
            $('#Description').val("");
            $('#status').val("Active");
            $('#servicename-error').html('');
            $('#category-error').html('');
            $('#description-error').html('');
            $('#status-error').html('');
            $('#dynamicTable tbody').empty();
            $('#serviceId').val("");
            $('#operationtypes').val("1");
            $('.totalrownumber').hide();
            $("#servicetitle").html("Add Service");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show');
        });

        $("#adds").click(function() {
            var lastrowcount=$('#dynamicTable tr:last').find('td').eq(1).find('input').val();
            var grp=$('#GroupVal'+lastrowcount).val();
            var pterms=$('#PaymenTermtVal'+lastrowcount).val();
            var periods=$('#PeriodName'+lastrowcount).val();
            if((grp!==undefined && isNaN(parseFloat(grp))) || (pterms!==undefined && isNaN(parseFloat(pterms))) || (periods!==undefined && isNaN(parseFloat(periods)))){
                if(grp!==undefined && isNaN(parseFloat(grp))){
                    $('#select2-GroupVal'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(pterms!==undefined && isNaN(parseFloat(pterms))){
                    $('#select2-PaymenTermtVal'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                if(periods!==undefined && isNaN(parseFloat(periods))){
                    $('#select2-PeriodName'+lastrowcount+'-container').parent().css('background-color',errorcolor);
                }
                toastrMessage('error',"Please fill all required fields","Error");
            }
            else{
                ++i;
                ++m;
                ++j;
                $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                    '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                    '<td style="width:11%;"><select id="PeriodName'+m+'" class="select2 form-control form-control PeriodName" onchange="PeriodNameFn(this)" name="row['+m+'][periods_id]"></select></td>'+
                    '<td style="width:11%;"><select id="GroupVal'+m+'" class="select2 form-control form-control GroupVal" onchange="GroupValFn(this)" name="row['+m+'][groupmembers_id]"></select></td>'+
                    '<td style="width:12%;"><select id="PaymenTermtVal'+m+'" class="select2 form-control form-control PaymenTermtVal" onchange="PaymenTermtValFn(this)" name="row['+m+'][paymentterms_id]"></select></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][NewMemberPrice]" placeholder="New Member Price" id="NewMemberPrice'+m+'" class="NewMemberPrice form-control numeral-mask" onblur="removeMemberPr(this)" onkeyup="newMemberFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][NewTrainerFee]" placeholder="New Trainer Fee" id="NewTrainerFee'+m+'" class="NewTrainerFee form-control numeral-mask" onkeyup="trainerFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][MemberPrice]" placeholder="Existing Member Price" id="MemberPrice'+m+'" class="MemberPrice form-control numeral-mask" onkeyup="memberFn(this)" ondblclick="CloneValue(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:10%;"><input type="number" name="row['+m+'][ExistingTrainerFee]" placeholder="Existing Trainer Fee" id="ExistingTrainerFee'+m+'" class="ExistingTrainerFee form-control numeral-mask" onkeyup="extrainerFn(this)" ondblclick="CloneTrValue(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="width:10%;"><input type="text" name="row['+m+'][Description]" id="Description'+m+'" class="Description form-control" placeholder="Remark..."/></td>'+
                    '<td style="width:10%;"><select id="Status'+m+'" class="select2 form-control form-control Status" name="row['+m+'][Status]"></select></td>'+
                    '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                    '<td style="display:none;"><input type="number" name="row['+m+'][NewMemDiscount]" placeholder="Discount New Member" id="NewMemDiscount'+m+'" class="NewMemDiscount form-control numeral-mask" onkeyup="discountNewMemFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                    '<td style="display:none;"><input type="number" name="row['+m+'][Discount]" placeholder="Discount Existing Member" id="Discount'+m+'" class="Discount form-control numeral-mask" onkeyup="discountFn(this)" onkeypress="return ValidateNum(event);"/></td></tr>'
                );
                
                var groupdefopt = '<option selected value=""></option>';
                var memopt = $("#periodcbx > option").clone();
                $('#PeriodName'+m).append(memopt);
                $('#PeriodName'+m).append(groupdefopt);
                $('#PeriodName'+m).select2
                ({
                    placeholder: "Select Period here",
                });
                var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                $('#Status'+m).append(statusopt);
                $('#Status'+m).select2
                ({
                    placeholder: "Select Status here",
                    minimumResultsForSearch: -1
                });
                $('#GroupVal'+m).append(groupdefopt);
                $('#GroupVal'+m).select2
                ({
                    placeholder: "Select Period first",
                });
                $('#PaymenTermtVal'+m).append(groupdefopt);
                $('#PaymenTermtVal'+m).select2
                ({
                    placeholder: "Select Group first",
                });
                renumberRows();
                $('#select2-PeriodName'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-GroupVal'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-PaymenTermtVal'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                $('#select2-Status'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
            }
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
            renumberRows();
            --i;
        });

        function renumberRows() {
            var ind;
            $('#dynamicTable > tbody tr').each(function(index,el) {
                $(this).children('td').first().text(index+=1);
                $('#numberofItemsLbl').html(index);
                ind = index;
            });
            if (ind == 0) {
               $('.totalrownumber').hide();
            } else {
               $('.totalrownumber').hide();
            }
        }

        function PeriodNameFn(ele) {
            var groupidval = $(ele).closest('tr').find('.GroupVal').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#GroupVal'+idval).empty();
            var groupdefopt = '<option selected value=""></option>';
            var groupopt = $("#groupcbx > option").clone();
            $('#GroupVal'+idval).append(groupopt);
            $('#GroupVal'+idval).append(groupdefopt);
            $('#GroupVal'+idval).select2
            ({
                placeholder: "Select Group here",
            });
            $('#select2-PeriodName'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            $('#select2-GroupVal'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function GroupValFn(ele) {
            var groupidval = $(ele).closest('tr').find('.GroupVal').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            $('#PaymenTermtVal'+idval).empty();
            var paymentdefopt = '<option selected disabled value=""></option>';
            var paymentopt = $("#paymenttermcbx > option").clone();
            $('#PaymenTermtVal'+idval).append(paymentopt);
            $('#PaymenTermtVal'+idval).append(paymentdefopt);
            $('#PaymenTermtVal'+idval).select2
            ({
                placeholder: "Select Payment term here",
            });
            $('#select2-PaymenTermtVal'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            $('#select2-GroupVal'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
        }

        function PaymenTermtValFn(ele) {
            var totalpaymentterms=0;
            var groupidval = $(ele).closest('tr').find('.GroupVal').val();
            var paymenttermval = $(ele).closest('tr').find('.PaymenTermtVal').val();
            var periodname = $(ele).closest('tr').find('.PeriodName').val();
            var idval = $(ele).closest('tr').find('.vals').val();
            for(var k=1;k<=m;k++){
                if(($('#PaymenTermtVal'+k).val())!=undefined){
                    if(($('#GroupVal'+k).val()==groupidval) && ($('#PeriodName'+k).val()==periodname) && ($('#PaymenTermtVal'+k).val()==paymenttermval)){
                        totalpaymentterms+=1;
                    }
                }
            }
            $('#select2-PaymenTermtVal'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            if(parseFloat(totalpaymentterms)>1){
                $('#PaymenTermtVal'+idval).empty();
                toastrMessage('error',"For this period and group, you selected this payment terms","Error");
                var paymentdefopt = '<option selected disabled value=""></option>';
                var paymentopt = $("#paymenttermcbx > option").clone();
                $('#PaymenTermtVal'+idval).append(paymentopt);
                $('#PaymenTermtVal'+idval).append(paymentdefopt);
                $('#PaymenTermtVal'+idval).select2
                ({
                    placeholder: "Select Payment term here",
                });
                $('#select2-PaymenTermtVal'+idval+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%","background-color":"white"});
            } 
        }

        function newMemberFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var newmemberpr = $(ele).closest('tr').find('.NewMemberPrice').val();
            var memberpr = $(ele).closest('tr').find('.MemberPrice').val();
            var discountpr = $(ele).closest('tr').find('.Discount').val();
            var discountvar=0;
            // if(!isNaN(parseFloat(memberpr))){
            //     discountvar=parseFloat(newmemberpr)-parseFloat(memberpr);
            //     if(parseFloat(discountvar)==0){
            //         $(ele).closest('tr').find('.Discount').val("");
            //     }
            //     if(parseFloat(discountvar)>0){
            //         $(ele).closest('tr').find('.Discount').val(discountvar);
            //     }
            // }
            $('#NewMemberPrice'+idval).css("background","white");
            if(parseFloat(newmemberpr)==0){
                $(ele).closest('tr').find('.NewMemberPrice').val("");
                $('#NewMemberPrice'+idval).css("background",errorcolor);
                toastrMessage('error',"Existing member price cannot be zero","Error");
            }  
        }

        function removeMemberPr(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var newmemberpr = $(ele).closest('tr').find('.NewMemberPrice').val();
            var memberpr = $(ele).closest('tr').find('.MemberPrice').val();
            var discountpr = $(ele).closest('tr').find('.Discount').val();
            if(!isNaN(parseFloat(memberpr))){
                if(parseFloat(memberpr)>parseFloat(newmemberpr)){
                    $(ele).closest('tr').find('.NewMemberPrice').val("");
                    $(ele).closest('tr').find('.NewMemDiscount').val("");
                    $('#NewMemberPrice'+idval).css("background",errorcolor);
                    toastrMessage('error',"New member price is less than existing member price","Error");
                }
            }
        }

        function memberFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var newmemberpr = $(ele).closest('tr').find('.NewMemberPrice').val();
            var memberpr = $(ele).closest('tr').find('.MemberPrice').val();
            var discountpr = $(ele).closest('tr').find('.Discount').val();
            var discountvar=0;
            $('#MemberPrice'+idval).css("background","white");
            if(!isNaN(parseFloat(newmemberpr))){
                if(parseFloat(memberpr)>parseFloat(newmemberpr)){
                    $(ele).closest('tr').find('.MemberPrice').val("");
                    $(ele).closest('tr').find('.Discount').val("");
                    $('#MemberPrice'+idval).css("background",errorcolor);
                    toastrMessage('error',"Existing member price is greater than new member price","Error");
                }
                // else if(parseFloat(memberpr)<=parseFloat(newmemberpr)){
                //     discountvar=parseFloat(newmemberpr)-parseFloat(memberpr);
                //     if(parseFloat(discountvar)==0){
                //         $(ele).closest('tr').find('.Discount').val("");
                //     }
                //     if(parseFloat(discountvar)>0){
                //         $(ele).closest('tr').find('.Discount').val(discountvar);
                //     }
                //     $('#MemberPrice'+idval).css("background","white");
                // }
            }  
            if(parseFloat(memberpr)==0){
                $(ele).closest('tr').find('.MemberPrice').val("");
                $(ele).closest('tr').find('.Discount').val("");
            } 
            if(isNaN(parseFloat(memberpr))){
                $(ele).closest('tr').find('.MemberPrice').val("");
                $(ele).closest('tr').find('.Discount').val("");
            } 
        }

        function trainerFn(ele) {
            var newtrainerpr = $(ele).closest('tr').find('.NewTrainerFee').val();
            if(parseFloat(newtrainerpr)==0){
                $(ele).closest('tr').find('.NewTrainerFee').val("");
            } 
        }

        function extrainerFn(ele) {
            var exstrainerpr = $(ele).closest('tr').find('.ExistingTrainerFee').val();
            if(parseFloat(exstrainerpr)==0){
                $(ele).closest('tr').find('.ExistingTrainerFee').val("");
            } 
        }

        function discountNewMemFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var newmemberpr = $(ele).closest('tr').find('.NewMemberPrice').val();
            var memberpr = $(ele).closest('tr').find('.MemberPrice').val();
            var discountpr = $(ele).closest('tr').find('.NewMemDiscount').val();
            var memberpricevar=0;
            $('#NewMemDiscount'+idval).css("background","white");
            if(isNaN(parseFloat(newmemberpr))){
                $(ele).closest('tr').find('.NewMemDiscount').val("");
                toastrMessage('error',"Please enter new member price","Error");
            }
            else if(parseFloat(newmemberpr)<=parseFloat(discountpr)){
                $(ele).closest('tr').find('.NewMemDiscount').val("");
                $('#NewMemDiscount'+idval).css("background",errorcolor);
                toastrMessage('error',"Discount cannot be equal or greater than new member price","Error");
            }
        }

        function discountFn(ele) {
            var idval = $(ele).closest('tr').find('.vals').val();
            var newmemberpr = $(ele).closest('tr').find('.NewMemberPrice').val();
            var memberpr = $(ele).closest('tr').find('.MemberPrice').val();
            var discountpr = $(ele).closest('tr').find('.Discount').val();
            var memberpricevar=0;
            $('#Discount'+idval).css("background","white");
            if(isNaN(parseFloat(memberpr))){
                $(ele).closest('tr').find('.Discount').val("");
                toastrMessage('error',"Please enter new member price","Error");
            }
            else if(parseFloat(memberpr)<=parseFloat(discountpr)){
                $(ele).closest('tr').find('.Discount').val("");
                $('#Discount'+idval).css("background",errorcolor);
                toastrMessage('error',"Discount cannot be equal or greater than existing member price","Error");
            }
        }

        function CloneValue(ele) {
            var newmemberpr = $(ele).closest('tr').find('.NewMemberPrice').val();
            $(ele).closest('tr').find('.MemberPrice').val(newmemberpr);
            $(ele).closest('tr').find('.MemberPrice').css("background","white");
            $(ele).closest('tr').find('.Discount').val("");
        }

        function CloneTrValue(ele) {
            var trainerfee = $(ele).closest('tr').find('.NewTrainerFee').val();
            $(ele).closest('tr').find('.ExistingTrainerFee').val(trainerfee);
            $(ele).closest('tr').find('.ExistingTrainerFee').css("background","white");
        }

        function deleteservicefn(recordId){
            var srvcnt=0;
            $("#serviceDelId").val(recordId);
            $.get("/showservice"+'/'+recordId , function(data) {
                srvcnt=data.servicecountval;
                if(parseFloat(srvcnt)>=1){
                    toastrMessage('error',"Unable to delete service, transaction is saved with this service","Error");
                }
                else if(parseFloat(srvcnt)==0){
                    $('#deleteservicebtn').text('Delete');
                    $('#deleteservicebtn').prop("disabled", false);
                    $("#deleteservicemodal").modal('show');
                }
            });
        }

        function editservicefn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#serviceId").val(recordId);
            j=0;
            $.get("/showservice"+'/'+recordId , function(data) {
                $.each(data.servlist, function(key, value) {
                    $('#ServiceName').val(value.ServiceName);
                    $('#Category').select2('destroy');
                    $('#Category').val(value.categories_id).trigger('change').select2();
                    $("#Description").val(value.Description);
                    $('#status').select2('destroy');
                    $('#status').val(value.Status).trigger('change').select2();
                });

                $.each(data.detdata, function(key, value) {
                    ++i;
                    ++m;
                    ++j;
                    $("#dynamicTable > tbody").append('<tr id="rowind'+m+'"><td style="font-weight:bold;width:3%;text-align:center;">'+j+'</td>'+
                        '<td style="display:none;"><input type="hidden" name="row['+m+'][vals]" id="vals'+m+'" class="vals form-control" readonly="true" style="font-weight:bold;" value="'+m+'"/></td>'+
                        '<td style="width:11%;"><select id="PeriodName'+m+'" class="select2 form-control form-control PeriodName" onchange="PeriodNameFn(this)" name="row['+m+'][periods_id]"></select></td>'+
                        '<td style="width:11%;"><select id="GroupVal'+m+'" class="select2 form-control form-control GroupVal" onchange="GroupValFn(this)" name="row['+m+'][groupmembers_id]"></select></td>'+
                        '<td style="width:12%;"><select id="PaymenTermtVal'+m+'" class="select2 form-control form-control PaymenTermtVal" onchange="PaymenTermtValFn(this)" name="row['+m+'][paymentterms_id]"></select></td>'+
                        '<td style="width:10%;"><input type="number" name="row['+m+'][NewMemberPrice]" placeholder="New Member Price" id="NewMemberPrice'+m+'" class="NewMemberPrice form-control numeral-mask" value="'+value.NewMemberPrice+'" onblur="removeMemberPr(this)" onkeyup="newMemberFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="width:10%;"><input type="number" name="row['+m+'][NewTrainerFee]" placeholder="New Trainer Fee" id="NewTrainerFee'+m+'" class="NewTrainerFee form-control numeral-mask" value="'+value.NewTrainerFees+'" onkeyup="trainerFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="width:10%;"><input type="number" name="row['+m+'][MemberPrice]" placeholder="Existing Member Price" id="MemberPrice'+m+'" class="MemberPrice form-control numeral-mask" value="'+value.MemberPrice+'" onkeyup="memberFn(this)" ondblclick="CloneValue(this)" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="width:10%;"><input type="number" name="row['+m+'][ExistingTrainerFee]" placeholder="Existing Trainer Fee" id="ExistingTrainerFee'+m+'" class="ExistingTrainerFee form-control numeral-mask" value="'+value.ExistingTrainerFees+'" onkeyup="extrainerFn(this)" ondblclick="CloneTrValue(this)" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="width:10%;"><input type="text" name="row['+m+'][Description]" id="Description'+m+'" class="Description form-control" placeholder="Remark..." value="'+value.Remark+'"/></td>'+
                        '<td style="width:10%;"><select id="Status'+m+'" class="select2 form-control Status" name="row['+m+'][Status]"></select></td>'+
                        '<td style="width:3%;text-align:center;"><button type="button" id="removebtn'+m+'" class="btn btn-light btn-sm remove-tr" style="color:#ea5455;background-color:#FFFFFF;border-color:#FFFFFF"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button></td>'+
                        '<td style="display:none;border: 1px solid #d8d6de;"><input type="number" name="row['+m+'][NewMemDiscount]" placeholder="Discount New Member" id="NewMemDiscount'+m+'" class="NewMemDiscount form-control numeral-mask" value="'+value.NewMemDiscount+'" onkeyup="discountNewMemFn(this)" onkeypress="return ValidateNum(event);"/></td>'+
                        '<td style="display:none;border: 1px solid #d8d6de;"><input type="number" name="row['+m+'][Discount]" placeholder="Discount" id="Discount'+m+'" class="Discount form-control numeral-mask" value="'+value.Discounts+'" onkeyup="discountFn(this)" onkeypress="return ValidateNum(event);"/></td></tr>'
                    );  
                    var groupdefopt='<option selected value="'+value.groupmembers_id+'">'+value.GroupName+'</option>';
                    var paymentdefopt='<option selected value="'+value.paymentterms_id+'">'+value.PaymentTermName+'</option>';
                    var statusdefopt='<option selected value="'+value.Status+'">'+value.Status+'</option>';
                    var periodsdef='<option selected value="'+value.periods_id+'">'+value.PeriodName+'</option>';
                    
                    if(parseFloat(value.TransactionFlag)>=1){
                        $('#removebtn'+m).hide();
                    }
                    else if(parseFloat(value.TransactionFlag)==0){
                        var memopt = $("#periodcbx > option").clone();
                        $('#PeriodName'+m).append(memopt);
                        $("#PeriodName"+m+" option[value='"+value.periods_id+"']").remove();  
                        
                        var groupopt = $("#groupcbx > option").clone();
                        $('#GroupVal'+m).append(groupopt);
                        $("#GroupVal"+m+" option[value='"+value.groupmembers_id+"']").remove();   
                        
                        var paymentopt = $("#paymenttermcbx > option").clone();
                        $('#PaymenTermtVal'+m).append(paymentopt);
                        $("#PaymenTermtVal"+m+" option[value='"+value.paymentterms_id+"']").remove();     
                    }
                    $('#GroupVal'+m).append(groupdefopt);
                    $('#PeriodName'+m).append(periodsdef);
                    $('#PaymenTermtVal'+m).append(paymentdefopt);

                    var statusopt = '<option value="Active">Active</option><option value="Inactive">Inactive</option>';
                    $('#Status'+m).append(statusopt);
                    $("#Status"+m+" option[value='"+value.Status+"']").remove(); 
                    $('#Status'+m).append(statusdefopt);
                    
                    $('#PeriodName'+m).select2();
                    $('#GroupVal'+m).select2();
                    $('#PaymenTermtVal'+m).select2();
                    $('#Status'+m).select2({
                        minimumResultsForSearch: -1
                    });
                    $('#select2-PeriodName'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('#select2-GroupVal'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('#select2-PaymenTermtVal'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                    $('#select2-Status'+m+'-container').parent().css({"position":"relative","z-index":"2","display":"grid","table-layout":"fixed","width":"100%"});
                });
            });
            $("#servicetitle").html("Update Service");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#inlineForm").modal('show'); 
        }

        $(document).on('click', '.serviceInfo', function() {
            var recordId = $(this).data('id');
            $.get("/showservice"+'/'+recordId , function(data) {
                $.each(data.servlist, function(key, value) {
                    $("#servicenamelbl").html(value.ServiceName);
                    $("#categorynamelbl").html(value.CategoryName);
                    $("#descriptionlbl").html(value.Description);
                    $("#createdbylbl").html(value.CreatedBy);
                    $("#createddatelbl").html(value.CreatedDate);
                    $("#lasteditedbylbl").html(value.LastEditedBy);
                    $("#lastediteddatelbl").html(value.LastEditedDate);
                    var st=value.Status;
                    if(st=="Active"){
                        $("#statuslbl").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                    }
                    if(st=="Inactive"){
                        $("#statuslbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }
                });
            });

            $('#servicedetailtbl').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "lengthMenu": [50,100],
                "order": [
                    [0, "asc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'55vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-4'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/servicelistinfo/'+recordId,
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
                    { data:'DT_RowIndex'},
                    {
                        data: 'PeriodName',
                        name: 'PeriodName',
                    },
                    {
                        data: 'GroupName',
                        name: 'GroupName',
                    },
                    {
                        data: 'PaymentTermName',
                        name: 'PaymentTermName'
                    },
                    {
                        data: 'NewMemberPrice',
                        name: 'NewMemberPrice',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'NewTrainerFees',
                        name: 'NewTrainerFees',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'MemberPrice',
                        name: 'MemberPrice',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'ExistingTrainerFees',
                        name: 'ExistingTrainerFees',
                        render: $.fn.dataTable.render.number(',', '.',2,'')
                    },
                    {
                        data: 'Description',
                        name: 'Description'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.Status == "Active") {
                        $(nRow).find('td:eq(9)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    } else if (aData.Status == "Inactive") {
                        $(nRow).find('td:eq(9)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                    }
                }
            });
            $(".collapse").collapse('show'); 
            $("#informationmodal").modal('show'); 
        });

        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/saveService',
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
                        if (data.errors.ServiceName) {
                            $('#servicename-error').html(data.errors.ServiceName[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.Category) {
                            $('#category-error').html(data.errors.Category[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                            if(parseFloat(optype)==1){
                                $('#savebutton').text('Save');
                                $('#savebutton').prop("disabled", false);
                            }
                            else if(parseFloat(optype)==2){
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }  
                        }
                    }
                    else if (data.errorv2) {
                        for(var k=1;k<=m;k++){
                            var member=($('#PeriodName'+k)).val();
                            var groupvl=($('#GroupVal'+k)).val();
                            var pterms=($('#PaymenTermtVal'+k)).val();
                            var newmem=($('#NewMemberPrice'+k)).val();
                            var exsmem=($('#MemberPrice'+k)).val();
                            var status=($('#Status'+k)).val();
                            if(($('#PeriodName'+k).val())!=undefined){
                                if(member==""||member==null){
                                    $('#select2-PeriodName'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#GroupVal'+k).val())!=undefined){
                                if(groupvl==""||groupvl==null){
                                    $('#select2-GroupVal'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#PaymenTermtVal'+k).val())!=undefined){
                                if(pterms==""||pterms==null){
                                    $('#select2-PaymenTermtVal'+k+'-container').parent().css('background-color',errorcolor);
                                }
                            }
                            if(($('#NewMemberPrice'+k).val())!=undefined){
                                if(newmem==""||newmem==null){
                                    $('#NewMemberPrice'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#MemberPrice'+k).val())!=undefined){
                                if(exsmem==""||exsmem==null){
                                    $('#MemberPrice'+k).css("background", errorcolor);
                                }
                            }
                            if(($('#Status'+k).val())!=undefined){
                                if(status==""||status==null){
                                    $('#select2-Status'+k+'-container').parent().css('background-color',errorcolor);
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
                        toastrMessage('error',"You should add atleast one group and payment term","Error");
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
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        $('#deleteservicebtn').click(function() {
            var delform = $("#deleteserviceform");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteservice',
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
                    $('#deleteservicebtn').text('Deleting...');
                    $('#deleteservicebtn').prop("disabled", true);
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
                    if(data.success){
                        $('#deleteservicebtn').text('Delete');
                        $('#deleteservicebtn').prop("disabled", false);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#deleteservicemodal").modal('hide');
                    }
                }
            });
        });

        function closeRegisterModal() {
            $('#Category').select2('destroy');
            $('#ServiceName').val("");
            $('#Description').val("");
            $('#Category').val(null).select2();
            $('#status').val("Active");
            $('#servicename-error').html('');
            $('#category-error').html('');
            $('#description-error').html('');
            $('#status-error').html('');
            $('#dynamicTable tbody').empty();
            $('#serviceId').val("");
            $('#operationtypes').val("1");
            $('.totalrownumber').hide();
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function removeNameValidation() {
            $('#servicename-error').html('');
        }

        function categoryval() {
            $('#category-error').html('');
        }

        function descval() {
            $('#description-error').html('');
        }

        function removeStatusValidation() {
            $('#status-error').html('');
        }
    </script>
@endsection