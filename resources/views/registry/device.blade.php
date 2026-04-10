@extends('layout.app1')

@section('title')
@endsection

@section('content')
    @can('Device-View')
        <div class="app-content content ">
            <section id="responsive-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom fit-content mb-0 pb-0">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: left !important;align-items: center;padding: 10px 5px;">
                                            <h3 class="card-title form_title">Devices</h3>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align: right !important;align-items: center;padding: 10px 5px;">
                                            <button type="button" class="btn btn-icon btn-icon rounded-circle btn-flat-info waves-effect btn-sm" onclick="refreshDeviceDataFn()"><i class="fas fa-sync-alt"></i></button>
                                            @if (auth()->user()->can('Device-Add'))
                                            <button type="button" class="btn btn-gradient-info btn-sm adddevices header-prop" id="adddevices"><i class="fas fa-plus"></i><span class="header-text">&nbsp Add</span></button>
                                            @endcan 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-datatable fit-content">
                                <div style="width:99%; margin-left:0.5%;" id="main-datatable" style="display: none;">
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover defaultdatatable mb-0 mobile-dt" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:20%;">Branch Name</th>
                                                <th style="width:18%;">Device ID</th>
                                                <th style="width:20%;">Device Name</th>
                                                <th style="width:18%;">IP Address</th>
                                                <th style="width:17%;">Status</th>
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
            </section>
        </div>
    @endcan

    <!--Start Information Modal -->
    <div class="modal fade fit-content" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Device Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-1 mb-1">
                                    <div class="card shadow-none border m-0">
                                        <div class="card-body">
                                            <h6 class="card-title mb-0"><i class="fas fa-database"></i> Basic Information</h6>
                                            <hr class="my-50">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl">Branch</label></td>
                                                            <td><label class="info_lbl" id="branchnameinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Device ID</label></td>
                                                            <td><label class="info_lbl" id="deviceidinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Device Name</label></td>
                                                            <td><label class="info_lbl" id="devicenameinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">IP Address</label></td>
                                                            <td><label class="info_lbl" id="ipaddressinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Time Zone</label></td>
                                                            <td><label class="info_lbl" id="timezoneinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Description</label></td>
                                                            <td><label class="info_lbl" id="descriptioninfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <table class="infotbl" style="width:100%;font-size:12px;">
                                                        <tr>
                                                            <td><label class="info_lbl" title="Registration Device">Reg. Device</label></td>
                                                            <td><label class="info_lbl" id="registariondeviceinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl" title="Attendance Device">Att. Device</label></td>
                                                            <td><label class="info_lbl" id="attendanceinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td><label class="info_lbl">Port</label></td>
                                                            <td><label class="info_lbl" id="portinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Sync Mode</label></td>
                                                            <td><label class="info_lbl" id="syncmodeinfolbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label class="info_lbl">Status</label></td>
                                                            <td><label class="info_lbl" id="statuslbl" style="font-weight: bold;"></label></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card shadow-none border m-0">
                                        <div class="card-body mb-0">
                                            <h6 class="card-title mb-0"><i class="fas fa-sliders-v"></i> Control Panel</h6>
                                            <hr class="my-50">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-1">
                                                    <button id="testconnbtninfo" type="button" class="btn btn-outline-info waves-effect" style="width: 100%">Test Connection</button>
                                                </div>
                                                @can('Open-Door')
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-1">
                                                    <button id="opendoorbtninfo" type="button" class="btn btn-outline-info waves-effect" style="width: 100%">Open Door</button>
                                                </div>
                                                @endcan
                                                @can('Restart-Device')
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mt-1">
                                                    <button id="restartdevbtninfo" type="button" class="btn btn-outline-info waves-effect" style="width: 100%">Restart Device</button>
                                                </div>
                                                @endcan
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:left">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle hide-arrow action-btn form_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-sharp fa-solid fa-caret-down fa-xl"></i><span class="btn-text">&nbsp Actions</span>
                                        </button>
                                        <ul class="dropdown-menu" id="device_action_ul"></ul>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" style="text-align:right">
                                    <input type="hidden" class="form-control" name="devicedelId" id="devicedelId" readonly="true">
                                    <input type="hidden" class="form-control" name="devicesidinfo" id="devicesidinfo" readonly="true"/>
                                    <input type="hidden" class="form-control" name="ipaddressinfo" id="ipaddressinfo" readonly="true"/>
                                    <input type="hidden" class="form-control" name="portinfo" id="portinfo" readonly="true"/>
                                    <input type="hidden" class="form-control" name="usernameinfo" id="usernameinfo" readonly="true"/>
                                    <input type="hidden" class="form-control" name="passwordinfo" id="passwordinfo" readonly="true"/>
                                    <button id="closebuttondev" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Information Modal -->
    
    <div class="modal fade text-left fit-content" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title form_title" id="devicestitle"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Branch<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="Branch" id="Branch" onchange="branchfn()">
                                        @foreach ($branchs as $branchs)
                                            <option value="{{$branchs->id}}">{{$branchs->BranchName}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="branch-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Registration Device<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="RegistrationDevice" id="RegistrationDevice" onchange="regdevicefn()">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="regdev-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Device ID<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="text" placeholder="Write Device ID here" class="form-control reg_form" name="DeviceId" id="DeviceId" onkeyup="deviceidfn()"/>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="deviceid-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Attendance Device<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="AttendanceDevice" id="AttendanceDevice" onchange="attdevicefn()">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="attdev-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Device Name<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="text" placeholder="Write Device Name here" class="form-control reg_form" name="DeviceName" id="DeviceName" onkeyup="devicenamefn()"/>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="devicename-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">User Name<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="text" placeholder="Write Username here" class="form-control reg_form" name="UserName" id="UserName" onkeyup="usernamefn()"/>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="username-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Password<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="password" placeholder="Write Password here" class="form-control reg_form" name="Password" id="Password" onkeyup="passwordfn()"/>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="password-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">IP Address</label>
                                    <input type="text" placeholder="Write IP Address here" class="form-control reg_form" name="IPAddress" id="IPAddress" onkeyup="ipaddressfn()" onblur="ipaddresschecker()" onkeypress="return ValidateIpAddress(event);"/>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="ipaddress-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Port<b style="color: red; font-size:16px;">*</b></label>
                                    <input type="number" placeholder="Write Port here" class="form-control reg_form" name="Port" id="Port" onkeyup="portfn()" onkeypress="return ValidateOnlyNum(event);"/>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="port-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Time Zone<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="TimeZone" id="TimeZone" onchange="timezonefn()">
                                        <option selected value="1">UTC +3:00 Nairobi</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="timezone-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Sync Mode<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="SyncMode" id="SyncMode" onchange="syncmodefn()">
                                        <option value="Real-Time">Real-Time</option>
                                        <option value="Timing">Timing</option>
                                        <option value="Manual">Manual</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="syncmode-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Description</label>
                                    <textarea type="text" placeholder="Write Description here..." class="form-control reg_form" rows="1" name="Description" id="Description" onkeyup="descriptionfn()"></textarea>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="description-error"></strong>
                                    </span>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1">
                                    <label class="form_lbl">Status<b style="color: red; font-size:16px;">*</b></label>
                                    <select class="select2 form-control" name="status" id="status" onchange="statusFn()">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                    <span class="text-danger">
                                        <strong class="errordatalabel" id="status-error"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-5 col-5" style="text-align: left;">
                                    <button id="testconnbtn" type="button" class="btn btn-outline-info form_btn">Test Connection</button>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-7 col-7" style="text-align: right;">
                                    <input type="hidden" class="form-control reg_form" name="devicesid" id="devicesid" readonly="true"/>
                                    <input type="hidden" class="form-control reg_form" name="operationtypes" id="operationtypes" readonly="true"/>
                                    <button id="savebutton" type="button" class="btn btn-info form_btn">Save</button>
                                    <button id="closebutton" type="button" class="btn btn-danger form_btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layout.universal-component')

    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        var globalIndex = -1;
        
        $(function () {
            cardSection = $('#page-block');
        });

        $("#adddevices").click(function() {
            resetDeviceForm();
            $("#devicestitle").html("Add Device");
            $("#inlineForm").modal('show');
        });

        $(document).ready( function () {
            $('#main-datatable').hide();
            $('#laravel-datatable-crud').DataTable({
                destroy:true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
                "order": [[ 0, "desc" ]],
                "lengthMenu": [25,50,100,250,500],
                "pagingType": "simple",
                language: { 
                    search: '', 
                    searchPlaceholder: "Search here"
                },
                scrollY:'100%',
                scrollX: true,
                scrollCollapse: true, 
                deferRender: true,
                fixedHeader:true,
                dom: "<'row'<'col-sm-3 col-md-2 col-6'f><'col-sm-3 col-md-2 col-6 mt-1 custom-1'><'col-sm-3 col-md-2 col-6 mt-1 custom-2'><'col-sm-3 col-md-2 col-6 mt-1 custom-3'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4 col-md-4 col-4'l><'col-sm-4 col-md-4 col-4 d-flex justify-content-center'i><'col-sm-4 col-md-4 col-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/devicelist',
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
                        setFocus('#laravel-datatable-crud');
                        $('#laravel-datatable-crud').DataTable().columns.adjust();
                    },
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:'3%'
                    },
                    {
                        data: 'BranchName',
                        name: 'BranchName',
                        width:'20%'
                    },
                    {
                        data: 'DeviceId',
                        name: 'DeviceId',
                        width:'18%'
                    },
                    {
                        data: 'DeviceName',
                        name: 'DeviceName',
                        width:'20%'
                    },
                    {
                        data: 'IpAddress',
                        name: 'IpAddress',
                        width:'18%'
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
                        width:'17%'
                    },
                    {
                        data: 'action',name: 'action',
                        "render": function ( data, type, row, meta ) {
                            return `<div class="text-center"><a class="deviceInfo" href="javascript:void(0)" onclick="deviceInfoFn(${row.id})" data-id="device_id${row.id}" id="device_id${row.id}" title="Open device information form"><i class="fa-sharp fa-regular fa-circle-info fa-xl" style="color: #00cfe8;"></i></a></div>`;
                        },
                        width:'4%'
                    }
                ],
               
                drawCallback: function(settings) {
                    this.api().columns().every(function() {
                        var column = this;
                        var header = $(column.header()).text().trim();
                        
                        $(column.nodes()).each(function() {
                            $(this).attr('data-title', header);
                        });
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
                    $('#main-datatable').show();
                    $('#laravel-datatable-crud').DataTable().columns.adjust();
                },
                fixedHeader: {
                    header: true,
                    headerOffset: $('.header-navbar').outerHeight(),
                },
            });
        });

        $('#laravel-datatable-crud tbody').on('click', 'tr', function () {
            $('#laravel-datatable-crud tbody > tr').removeClass('selected');
            $(this).addClass('selected');
            globalIndex = $(this).index();
        });

        function setFocus(targetTable) {
            $($(targetTable + ' tbody > tr')[globalIndex]).addClass('selected');
        }

        $('#testconnbtn').click(function(){
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/testconn',
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
                    $('#testconnbtn').text('Testing...');
                    $('#testconnbtn').prop("disabled", false);
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
                    if(data.errors) {
                        if(data.errors.DeviceId){
                            $('#deviceid-error').html(data.errors.DeviceId[0]);
                        }
                        if(data.errors.IPAddress){
                            var text=data.errors.IPAddress[0];
                            text = text.replace("i p", "ip");
                            $('#ipaddress-error').html(text);
                        }
                        if(data.errors.UserName){
                            $('#username-error').html(data.errors.UserName[0]);
                        }
                        if(data.errors.Password){
                            $('#password-error').html(data.errors.Password[0]);
                        }
                        $('#testconnbtn').text('Test Connection');
                        $('#testconnbtn').prop("disabled", false);
                        toastrMessage('error',"Please fill all required fields","Error");
                    }
                    if(data.connerror){
                        toastrMessage('error',"Connection failed<br>Detail: "+data.connerror,"Failed");
                        $('#testconnbtn').text('Test Connection');
                        $('#testconnbtn').prop("disabled", false);
                    }
                    if(data.success) {
                        var result=data.success.info.Result;
                        if(result=="Fail"){
                            toastrMessage('error',"Connection failed<br>Plese try again!<br>Detail: <b>"+data.success.info.Detail+"</b>","Failed");
                        }
                        if(result==undefined){
                            toastrMessage('success',"Connection succeed","Success");
                        }
                        $('#testconnbtn').text('Test Connection');
                        $('#testconnbtn').prop("disabled", false);
                    }
                },
            });
        });

        $('#testconnbtninfo').click(function(){
            var registerForm = $("#InformationForm");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/testconninfo',
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
                    $('#testconnbtninfo').text('Testing...');
                    $('#testconnbtninfo').prop("disabled", false);
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
                    
                    if(data.connerror){
                        toastrMessage('error',"Connection failed<br>Detail: "+data.connerror,"Failed");
                        $('#testconnbtninfo').text('Test Connection');
                        $('#testconnbtninfo').prop("disabled", false);
                    }
                    if(data.success) {
                        var result=data.success.info.Result;
                        if(result=="Fail"){
                            toastrMessage('error',"Connection failed<br>Plese try again!<br>Detail: <b>"+data.success.info.Detail+"</b>","Failed");
                        }
                        if(result==undefined){
                            toastrMessage('success',"Connection succeed","Success");
                        }
                        $('#testconnbtninfo').text('Test Connection');
                        $('#testconnbtninfo').prop("disabled", false);
                    }
                },
            });
        });

        $('#opendoorbtninfo').click(function(){
            var registerForm = $("#InformationForm");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/opendoorinfo',
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
                    $('#opendoorbtninfo').text('Opening...');
                    $('#opendoorbtninfo').prop("disabled", true);
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
                    
                    if(data.connerror){
                        toastrMessage('error',"Open door failed<br>Detail: "+data.connerror,"Failed");
                        $('#opendoorbtninfo').text('Open Door');
                        $('#opendoorbtninfo').prop("disabled", false);
                    }
                    if(data.success) {
                        var result=data.success.info.Result;
                        if(result=="Fail"){
                            toastrMessage('error',"Open door failed<br>Plese try again!<br>Detail: <b>"+data.success.info.Detail+"</b>","Failed");
                        }
                        if(result==undefined){
                            toastrMessage('success',"Door Opened","Success");
                        }
                        $('#opendoorbtninfo').text('Open Door');
                        $('#opendoorbtninfo').prop("disabled", false);
                    }
                },
            });
        });

        $('#restartdevbtninfo').click(function(){
            var registerForm = $("#InformationForm");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/restartdeviceinfo',
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
                    $('#restartdevbtninfo').text('Restarting...');
                    $('#restartdevbtninfo').prop("disabled", true);
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
                    
                    if(data.connerror){
                        toastrMessage('error',"Restart device failed<br>Detail: "+data.connerror,"Failed");
                        $('#restartdevbtninfo').text('Restart Device');
                        $('#restartdevbtninfo').prop("disabled", false);
                    }
                    if(data.success) {
                        var result=data.success.info.Result;
                        if(result=="Fail"){
                            toastrMessage('error',"Restart device failed<br>Plese try again!<br>Detail: <b>"+data.success.info.Detail+"</b>","Failed");
                        }
                        if(result==undefined){
                            toastrMessage('success',"Device Restarted","Success");
                        }
                        $('#restartdevbtninfo').text('Restart Device');
                        $('#restartdevbtninfo').prop("disabled", false);
                    }
                },
            });
        });

        $('#savebutton').click(function(){
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
            url:'/savedevice',
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
                success:function(data) {
                    if(data.errors) {
                        if(data.errors.Branch){
                            $('#branch-error').html(data.errors.Branch[0]);
                        }
                        if(data.errors.DeviceId){
                            $('#deviceid-error').html(data.errors.DeviceId[0]);
                        }
                        if(data.errors.DeviceName){
                            $('#devicename-error').html(data.errors.DeviceName[0]);
                        }
                        if(data.errors.IPAddress){
                            var text=data.errors.IPAddress[0];
                            text = text.replace("i p", "ip");
                            $('#ipaddress-error').html(text);
                        }
                        if(data.errors.Port){
                            $('#port-error').html(data.errors.Port[0]);
                        }
                        if(data.errors.SyncMode){
                            $('#syncmode-error').html(data.errors.SyncMode[0]);
                        }
                        if(data.errors.RegistrationDevice){
                            $('#regdev-error').html(data.errors.RegistrationDevice[0]);
                        }
                        if(data.errors.AttendanceDevice){
                            $('#attdev-error').html(data.errors.AttendanceDevice[0]);
                        }
                        if(data.errors.UserName){
                            $('#username-error').html(data.errors.UserName[0]);
                        }
                        if(data.errors.Password){
                            $('#password-error').html(data.errors.Password[0]);
                        }
                        if(data.errors.Description){
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if(data.errors.status){
                            $('#status-error').html(data.errors.status[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please check your input","Error");
                    }
                    else if (data.dberrors) {
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success) {
                        if(parseFloat(optype) == 2){
                            createDeviceInfoFn(data.rec_id);
                        }
                        toastrMessage('success',"Successful","Success");
                        resetDeviceForm();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        $("#inlineForm").modal('hide');
                    }
                },
            });
        });

        function deviceInfoFn(recordId) { 
            createDeviceInfoFn(recordId);
            $("#informationmodal").modal('show');
        }

        function createDeviceInfoFn(recordId){
            var action_links = "";
            var lidata = "";
            $.ajax({
                type: "get",
                url: "{{url('showdevice')}}"+'/'+recordId,
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
                    $.each(data.devicelist, function(key, value) {
                        $("#branchnameinfolbl").html(value.BranchName);
                        $("#deviceidinfolbl").html(value.DeviceId);
                        $("#devicenameinfolbl").html(value.DeviceName);
                        $("#ipaddressinfolbl").html(value.IpAddress);
                        $("#portinfolbl").html(value.Port);
                        $("#timezoneinfolbl").html("UTC +3:00 Nairobi");
                        $("#syncmodeinfolbl").html(value.SyncMode);
                        $("#registariondeviceinfolbl").html(value.RegistrationDevice);
                        $("#attendanceinfolbl").html(value.AttendanceDevice);
                        $("#descriptioninfolbl").html(value.Description);
                        $("#devicesidinfo").val(value.DeviceId);
                        $("#ipaddressinfo").val(value.IpAddress);
                        $("#portinfo").val(value.Port);
                        $("#usernameinfo").val(value.Username);
                        $("#passwordinfo").val(value.Password);
                        $("#statuslbl").html(value.Status == "Active" ? 
                            `<span style='color:#1cc88a;font-weight:bold;text-shadow;1px 1px 10px #1cc88a;font-size:12px;'>${value.Status}</span>` :
                            `<span style='color:#e74a3b;font-weight:bold;text-shadow;1px 1px 10px #e74a3b;font-size:12px;'>${value.Status}</span>`
                        );
                    });

                    $.each(data.activitydata, function(key, value) {
                        var classes = "";
                        if(value.action == "Edited"){
                            classes = "warning";
                        }
                        else if(value.action == "Created"){
                            classes = "success";
                        }
                        else{
                            classes = "danger";
                        }
                        lidata += `<li class="timeline-item"><span class="timeline-point timeline-point-${classes} timeline-point-indicator"></span><div class="timeline-header mb-sm-0 mb-0"><h6 class="mb-0">${value.action}</h6><span class="text-muted"><i class="fa-regular fa-user"></i> ${value.FullName}</span></br><span class="text-muted"><i class="fa-regular fa-clock"></i> ${value.time}</span></div></li>`;
                    });
                    $("#universal-action-log-canvas").empty().append(lidata);

                    action_links = `
                        <li>
                            <a class="dropdown-item viewDeviceAction" onclick="viewDeviceFn(${recordId})" data-id="view_device_actionbtn${recordId}" id="view_device_actionbtn${recordId}" title="View user log">
                            <span><i class="fa-solid fa-eye"></i> View User Log</span>  
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @can("Device-Edit")
                        <li>
                            <a class="dropdown-item deviceEdit" onclick="deviceEditFn(${recordId})" data-id="edit_device_linkbtn${recordId}" id="edit_device_linkbtn${recordId}" title="Open device edit form">
                            <span><i class="fa-solid fa-pencil"></i> Edit</span>  
                            </a>
                        </li>
                        @endcan
                        @can("Device-Delete")
                        <li>
                            <a class="dropdown-item deviceDelete" onclick="deviceDeleteFn(${recordId})" data-id="delete_device_linkbtn${recordId}" id="delete_device_linkbtn${recordId}" title="Open device delete confirmation">
                            <span><i class="fa-solid fa-xmark"></i> Delete</span>  
                            </a>
                        </li>
                        @endcan
                    `;
                    $("#device_action_ul").empty().append(action_links);
                },
            });
        }

        function viewDeviceFn(recordId){
            $("#action-log-title").html("User Log Information");
            $("#action-log-universal-modal").modal('show');
        }

        function deviceEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val(2);
            $("#devicesid").val(recordId);
            $.ajax({
                type: "get",
                url: "{{url('showdevice')}}"+'/'+recordId,
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
                    $.each(data.devicelist, function(key, value) {
                        $('#Branch').val(value.branches_id).trigger('change').select2();
                        $("#DeviceId").val(value.DeviceId);
                        $("#DeviceName").val(value.DeviceName);
                        $("#IPAddress").val(value.IpAddress);
                        $("#Port").val(value.Port);
                        $('#TimeZone').val(value.TimeZone).trigger('change').select2({minimumResultsForSearch: -1});
                        $('#SyncMode').val(value.SyncMode).trigger('change').select2({minimumResultsForSearch: -1});
                        $('#RegistrationDevice').val(value.RegistrationDevice).trigger('change').select2({minimumResultsForSearch: -1});
                        $('#AttendanceDevice').val(value.AttendanceDevice).trigger('change').select2({minimumResultsForSearch: -1});
                        $('#status').val(value.Status).trigger('change').select2({minimumResultsForSearch: -1});
                        $("#UserName").val(value.Username);
                        $("#Password").val(value.Password);
                        $("#Description").val(value.Description);
                    });
                    $("#devicestitle").html("Edit Device");
                    $('#savebutton').text('Update');
                    $('#savebutton').prop("disabled",false);
                    $("#inlineForm").modal('show');
                }
            });
        }

        function deviceDeleteFn(recordId) { 
            var device_count = 0;

            $.ajax({
                type: "get",
                url: "{{url('showdevice')}}"+'/'+recordId,
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
                    device_count = data.device_cnt;
                    if(parseInt(device_count) > 0){
                        toastrMessage('error',"This record cannot be deleted because it is currently linked to other entries.","Error");
                    }
                    else{
                        Swal.fire({
                            title: warning_title,
                            text: delete_record_text1,
                            icon: warning_icon,
                            showCloseButton: true,
                            showCancelButton: true,      
                            allowOutsideClick: false,
                            confirmButtonText: 'Delete',
                            cancelButtonText: 'Close',
                            customClass: {
                                confirmButton: 'btn btn-info',
                                cancelButton: 'btn btn-danger'
                            }
                        }).then(function (result) {
                            if (result.value) {
                                $("#devicedelId").val(recordId);
                                deleteDeviceFn(recordId);
                            }
                            else if (result.dismiss === Swal.DismissReason.cancel) {}
                        });
                    }
                }
            });
        }

        function deleteDeviceFn(recordId){
            var delform = $("#InformationForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deletedevice',
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
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#informationmodal").modal('hide');
                    }
                }
            });
        }

        function resetDeviceForm(){
            $('#Branch').val(null).select2({placeholder: "Select Branch here"});
            $('#SyncMode').val(null).select2
            ({
                placeholder: "Select Sync mode here",
                minimumResultsForSearch: -1
            });
            $('#RegistrationDevice').val(null).select2
            ({
                placeholder: "Select Registration device here",
                minimumResultsForSearch: -1
            });
            $('#AttendanceDevice').val(null).select2
            ({
                placeholder: "Select Attendance device here",
                minimumResultsForSearch: -1
            });
            $('#status').val("Active").select2({minimumResultsForSearch: -1});
            $('.reg_form').val("");
            $('.errordatalabel').html("");
            $('#operationtypes').val(1);
            $('#TimeZone').val(1);
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled", false);
            $('#testconnbtn').text('Test Connection');
            $('#testconnbtn').prop("disabled", false);
        }

        function refreshDeviceDataFn(){
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }

        function branchfn(){
            $('#branch-error').html("");
        }
        function deviceidfn(){
            $('#deviceid-error').html("");
        }
        function devicenamefn(){
            $('#devicename-error').html("");
        }
        function ipaddressfn(){
            $('#ipaddress-error').html("");
        }
        function portfn(){
            $('#port-error').html("");
        }
        function timezonefn(){
            $('#timezone-error').html("");
        }
        function syncmodefn(){
            $('#syncmode-error').html("");
        }
        function regdevicefn(){
            $('#regdev-error').html("");
        }
        function attdevicefn(){
            $('#attdev-error').html("");
        }
        function usernamefn(){
            $('#username-error').html("");
        }
        function passwordfn(){
            $('#password-error').html("");
        }
        function descriptionfn(){
            $('#description-error').html("");
        }
        function statusFn(){
            $('#status-error').html("");
        }

        function ipaddresschecker(){
            var ipaddress = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/; 
            var content = $("#IPAddress").val(); 
            if (!ipaddress.test(content) && content!="") { 
                $('#IPAddress').val("");
                $("#ipaddress-error").html("ip address is invalid"); 
            } 
        }

        function ValidateIpAddress(event) {
            var regex = new RegExp("^[0-9/.]");
            var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        }       
    </script>
@endsection
