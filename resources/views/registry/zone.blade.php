@extends('layout.app1')
@section('title')
@endsection
@section('content')

    <div class="app-content content ">
        <section id="responsive-datatable">
            <!-- BEGIN: Zone table -->
            @can('Zone-View')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Zone</h3> 
                            @can('Zone-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addzones">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0 dataTable no-footer" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:3%;">#</th>
                                                <th style="width:31%;">Region</th>
                                                <th style="width:31%;">Zone</th>
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
            @endcan

            <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1"
                role="document" aria-labelledby="zonetitlelb" aria-hidden="true" style="overflow-y: scroll; display: none;"
                data-select2-id="inlineForm" arial-hidden="true">
                <div class="modal-dialog modal-lg" role="document" data-select2-id="15">
                    <div class="modal-content" data-select2-id="14">
                        <div class="modal-header">
                            <h4 class="modal-title" id="zonetitlelbl">Add Zone</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="closeRegisterModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="Register" data-select2-id="Register">
                            {{ csrf_field() }}

                            <div class="modal-body" data-select2-id="13">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-sm-12" data-select2-id="12">
                                        <label style="font-size: 14px;">Region</label><label style="color: red; font-size:16px;">*</label>
                                        <div class="form-group">
                                            <div>
                                                <select class="custom-select browser-default select2" name="Rgn_Id" id="Rgn_Id" onchange="removeRgn_idValidation()">
                                                    <option value=""></option>
                                                    @if ($regions->count() > 0)
                                                        @foreach ($regions as $region)
                                                            <option value="{{ $region->id }}">{{ $region->Rgn_Name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="Rgn_Id-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                        <label style="font-size: 14px;">Zone Name</label><label style="color: red; font-size:16px;">*</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Zone Name" class="form-control" name="Zone_Name" id='name' onkeyup="removeZoneNameValidation()" autofocus />
                                            <span class="text-danger">
                                                <strong id="name-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                        <label style="font-size: 14px;">Description</label><label></label>
                                        <div class="form-group">
                                            <textarea name="description" id="description" placeholder="Write Description here..." rows="2"
                                                class="form-control" onkeyup="removeDescriptionValidation()"></textarea>
                                            <span class="text-danger">
                                                <strong id="description-error" class="errordatalabel"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-12" dataselect2-id="12">
                                        <label style="font-size: 14px;">Status</label>
                                        <div class="form-group">
                                            <div>
                                                <select class="custom-select browser-default select2" name="status" id="status" onchange="StatusValidation()">
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="status-error" class="errordatalabel"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="zoneId" placeholder class="form-control" id="zoneId" readonly="true" value>
                                <input type="hidden" name="operationtypes" placeholder class="form-control" id="operationtypes" readonly="true">
                                <button id="savenewbutton" type="button" class="btn btn-info" style="display: none;">Save & New</button>
                                <button id="savebutton" type="button" class="btn btn-info waves-effect waves-float waves-light">Save & Close</button>
                                <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Zone Show Information Modal -->
            <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Zone Information</h4>
                            <div class="row">
                                <div style="text-align: right" id="statusdisplay"></div>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                        </div>
                        <form id="InformationForm">
                            <input type="hidden" name="_token" value="bEE2UUJ5zm8YDMuIHSOQT8ZRMeUGaxv9eDaOVNb1">
                            <div class="modal-body">
                                <section id="input-mask-wrapper">
                                    <div class="col-xl-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <table style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2" style="text-align: left">
                                                                <label style="font-size: 16px;font-weight:bold;">Basic Information</label>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 30%"><label style="font-size: 14px;">Region</label></td>
                                                            <td style="width: 70%"><label id="region_name" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%"><label style="font-size: 14px;">Zone</label></td>
                                                            <td style="width: 70%"><label id="zone_name" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label style="font-size: 14px;">Description</label></td>
                                                            <td><label id="descriptionlbl" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label style="font-size: 14px;">Status</label></td>
                                                            <td><label id="statuslbl" style="font-size:14px;font-weight:bold;"></label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <table style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <td colspan="2" style="text-align: left">
                                                                <label style="font-size: 16px;font-weight:bold;">Action Information</label>
                                                            </td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 40%"><label style="font-size: 14px;">Created By</label></td>
                                                            <td style="width: 60%"><label id="created_by" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label style="font-size: 14px;">Created Date</label></td>
                                                            <td><label id="created_at" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label style="font-size: 14px;">Last Edited By</label></td>
                                                            <td><label id="updated_by" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label style="font-size: 14px;">Last Edited Date</label></td>
                                                            <td><label id="updated_at" style="font-size:14px;font-weight:bold;"></label></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="modal-footer">
                                <button id="closebuttonk" type="button" class="btn btn-danger waves-effect waves-float waves-light" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Delete Modal --}}
            <div class="modal fade text-left" id="deletezoneconfirmation" data-keyboard="false" data-backdrop="static"
                tabindex="-1" role="dialog" aria-labelledby="myModalLabel356" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel358">Confirmation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="deletezoneform">
                            <input type="hidden" name="_token" value="1GPNBVe9vuJC6vuzXAyRoVrFeGK6BQwCzQpy9egN">
                            <div class="modal-body" style="background-color:#e74a3b">
                                 <label style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this zone?</label>
                                <div class="form-group">
                                    <input type="hidden" placeholder="" class="form-control" name="zonedelId" id="zonedelId" readonly="true">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="deletezonebtn" type="button" class="btn btn-info waves-effect waves-float waves-light">Delete</button>
                                <button id="closebuttonj" type="button" class="btn btn-danger waves-effect waves-float waves-light" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script type="text/javascript">
        var errorcolor = "#ffcccc";
        $(function() {
            cardSection = $('#page-block');
        });

        /* BEGIN: Display zone table using yajra datatable */
        $(document).ready(function() {
            var ctable = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
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
                    url: '/get-zone',
                    type: 'DELETE',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                    complete: function() {
                        cardSection.block({
                            message: '',
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
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width:"3%",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'region.Rgn_Name',
                        name: 'region.Rgn_Name',
                        width:"31%",
                    },
                    {
                        data: 'Zone_Name',
                        name: 'Zone_Name',
                        width:"31%",
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width:"30%",
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            return '<div class="btn-group dropleft"><button type="button" class="btn btn-sm dropdown-toffle hide-arrow" data-toggle="dropdown" arial-haspopup="true" arial-expanded="false"><i class="fa fa-ellipsis-v"></i></button><div class = "dropdown-menu" > <a class="dropdown-item zoneInfo" onclick="zoneInfoFn(' +
                                data.id +
                                ')" id="dtinfobtn" title="Open zone information page" data-id = "' +
                                data.id +
                                '"><i class="fa fa-info"></i><span> Info </span></a>' +
                                '@can("Zone-Edit")<a class = "dropdown-item zoneEdit" onclick = "zoneEditFn(' + data
                                .id +
                                ')" id = "dteditbtn" title = "Open zone update page" data - id = "' +
                                data.id +
                                '"><i class="fa fa-edit"></i><span> Edit </span></a>@endcan' +
                                '@can("Zone-Delete")<a class = "dropdown-item" onclick = "zoneDeleteFn(' +
                                data
                                .id +
                                ')" id = "dtdeletebtn" title = "Delete" data-id = "' +
                                data.id +
                                '"><i class="fa fa-trash"></i><span> Delete </span></a>@endcan</div></div> ';
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.status == "Active") {
                        $(nRow).find('td:eq(3)').css({
                            "color": "#4CAF50",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #4CAF50"
                        });
                    } else if (aData.status == "Inactive") {

                        $(nRow).find('td:eq(3)').css({
                            "color": "#f44336",
                            "font-weight": "bold",
                            "text-shadow": "1px 1px 10px #f44336"
                        });
                    }
                }
            });
            ctable.on('draw', function() {
                var body = $(ctable.table().body());
                body.unhighlight();
                body.highlight(ctable.search());
            })
        });
        /* BEGIN: Add zone button */
        $('.addzones').click(function() {
            $('#Zone_Name').val("");
            $('#description').val("");
            $('#dynamicTable tbody').empty();
            $('#zoneId').val("");
            $('#status').val('Active').trigger('change').select2({
                minimumResultsForSearch: -1
            });
            $('#Rgn_Id').select2({
                placeholder: "Select Region here",
            });
            $('#operationtypes').val("1");
            $("#zonetitlelbl").html("Add Zone");
            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled", false);
            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled", false);
            $('#savenewbutton').show();
            $('.errordatalabel').html('');
            $("#inlineForm").modal('show');
        });
        /* BEGIN: Add woreda button */

        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/saveZone',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                        css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                    if (parseFloat(optype) == 1) {
                        $('#savebutton').text('Saving...');
                        $('#savebutton').prop("disabled", true);
                    } else if (parseFloat(optype) == 2) {
                        $('#savebutton').text('Updating...');
                        $('#savebutton').prop("disabled", true);
                    }
                },
                complete: function() {
                    cardSection.block({
                        message: '',
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
                        if (data.errors.Zone_Name) {
                            $('#name-error').html(data.errors.Zone_Name[0]);
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        }
                        if (data.errors.Rgn_Id) {
                            var text = data.errors.Rgn_Id[0];
                            text = text.replace("rgn  id", "region");
                            $('#Rgn_Id-error').html(text);
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        }
                        if (data.errors.woredas) {
                            $('#table-error').html('data.errors.woredas[0]');
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        }
                        if (data.type == "dup") {
                            $('#table-error').html(data.errors);
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        } else if (data.type == "zone-dup") {
                            $('#name-error').html(data.errors);
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        } else if (data.type == "faild") {
                            $('#savebutton').text('Save & Close');
                            toastrMessage('error', data.error, "Error");
                            if (parseFloat(optype) == 1) {
                                $('#savebutton').text('Save & Close');
                                $('#savebutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savebutton').text('Update');
                                $('#savebutton').prop("disabled", false);
                            }
                        }
                    } 
                    else if (data.success) {
                        if (parseFloat(optype) == 1) {
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled", false);
                        } else if (parseFloat(optype) == 2) {
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success', "Successful", "Success");
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        closeRegisterModal();
                        $("#inlineForm").modal('hide');
                    }
                }
            });
        });

        $('#savenewbutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url: '/saveZone',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                        css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                    if (parseFloat(optype) == 1) {
                        $('#savenewbutton').text('Saving...');
                        $('#savenewbutton').prop("disabled", true);
                    } else if (parseFloat(optype) == 2) {
                        $('#savenewbutton').text('Updating...');
                        $('#savenewbutton').prop("disabled", true);
                    }
                },
                complete: function() {
                    cardSection.block({
                        message: '',
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
                        if (data.errors.Zone_Name) {
                            $('#name-error').html(data.errors.Zone_Name[0]);
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        }
                        if (data.errors.Rgn_Id) {
                            var text = data.errors.Rgn_Id[0];
                            text = text.replace("rgn  id", "region");
                            $('#Rgn_Id-error').html(text);
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        }
                        if (data.errors.woredas) {
                            $('#table-error').html('data.errors.woredas[0]');
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        }
                        if (data.type == "dup") {
                            $('#table-error').html(data.errors);
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        } else if (data.type == "zone-dup") {
                            $('#name-error').html(data.errors);
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        } else if (data.type == "faild") {
                            $('#savenewbutton').text('Save & New');
                            toastrMessage('error', data.error, "Error");
                            if (parseFloat(optype) == 1) {
                                $('#savenewbutton').text('Save & New');
                                $('#savenewbutton').prop("disabled", false);
                            } else if (parseFloat(optype) == 2) {
                                $('#savenewbutton').text('Update');
                                $('#savenewbutton').prop("disabled", false);
                            }
                        }
                    } 
                    else if (data.success) {
                        if (parseFloat(optype) == 1) {
                            $('#savenewbutton').text('Save & New');
                            $('#savenewbutton').prop("disabled", false);
                        } else if (parseFloat(optype) == 2) {
                            $('#savenewbutton').text('Update');
                            $('#savenewbutton').prop("disabled", false);
                        }
                        toastrMessage('success', "Successful", "Success");
                        var oTable = $('#laravel-datatable-crud').dataTable(); 
                        oTable.fnDraw(false);
                        closeRegisterModal();
                    }
                }
            });
        });

        /* BEGIN: Edit button */
        function zoneEditFn(recordId) {
            $("#operationtypes").val("2");
            $("#zoneId").val(recordId);
            $.get("/showzones" + '/' + recordId, function(data) {
                $.each(data.zone, function(key, value) {
                    $('#name').val(data.zone.Zone_Name);
                    $('#Rgn_Id').val(data.zone.Rgn_Id).trigger('change');
                    $('#description').val(data.zone.description);
                    $('#status').val(data.zone.status).trigger('change');
                });
            });
            $("#zonetitlelbl").html("Edit Zone");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled", false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show');
        }

        function zoneInfoFn(recordId) {
            $.get("/show_zone" + '/' + recordId, function(data) {
                $.each(data.zone, function(key, value) {
                    $("#region_name").html(data.rn.Rgn_Name);
                    $("#zone_name").html(data.zone.Zone_Name);
                    $("#descriptionlbl").html(data.zone.description);
                    $("#created_by").html(data.cr.username);
                    $("#updated_by").html(data.ur.username);
                    var st = data.zone.status;
                    var ca = new Date(data.zone.created_at);

                    $("#created_at").html(data.crdate);

                    if (data.ur !== "") {
                        $("#updated_at").html(data.upgdate);
                    }
                    if (st == "Active") {
                        $("#statuslbl").html("<b style='color:#1cc88a'>" + data.zone.status + "</b>");
                    }
                    if (st == "Inactive") {
                        $("#statuslbl").html("<b style='color:#e74a3b'>" + data.zone.status + "</b>");
                    }
                });
            });
            $("#informationmodal").modal('show');
        }
        
        function zoneDeleteFn(recordId) {
            var detcnt = 0;
            $("#zonedelId").val(recordId);
            $.get("/del_zone" + '/' + recordId, function(data) {
                detcnt = data.zonedetcnt;
                if (parseFloat(detcnt) >= 1) {
                    toastrMessage('error',
                        "<span style='color: white;'>Unable to delete Zone, there is a Woreda under this Zone</span>",
                        "Error");
                } else if (parseFloat(detcnt) == 0) {
                    $('#deletezonebtn').text('Delete');
                    $('#deletezonebtn').prop("disabled", false);
                    $("#deletezoneconfirmation").modal('show');
                }
            });
        }

        $('#deletezonebtn').click(function() {
            id = $('#zonedelId').val();
            $.ajax({
                url: '/deletezone/' + id,
                type: 'get',
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
                        css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                    $('#deletezonebtn').text('Deleting...');
                    $('#deletezonebtn').prop("disabled", true);
                },
                complete: function() {
                    cardSection.block({
                        message: '',
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
                        $('#deletezonebtn').text('Delete');
                        $('#deletezonebtn').prop("disabled", false);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',
                            "<span>" + data.success + "</span>","Success");
                        $("#deletezoneconfirmation").modal('hide');
                    } else if (data.deleteerror) {
                        $('#deletezonebtn').text('Delete');
                        $('#deletezonebtn').prop("disabled", false);
                        toastrMessage('error',
                            "<span>" + data.deleteerror + "</span>",
                            "Error");
                        $("#deletezoneconfirmation").modal('hide');
                    }
                    if (data.error) {
                        $('#deletezonebtn').text('Delete');
                        $('#deletezonebtn').prop("disabled", false);
                        toastrMessage('error',
                            "<span>" + data.error + "</span>",
                            "Error");
                        $("#deletezoneconfirmation").modal('hide');
                    }
                }
            });
        });

       
        /* BEGIN: Close button */
        function closeRegisterModal() {
            $('#name').val("");
            $('#description').val("");
            $('#status').val('Active').trigger('change');
            $('#Rgn_Id').val('').trigger('change');
            $('.errordatalabel').html('');
            $('#zoneId').val("");
            $('#operationtypes').val("1");
        }
        /* BEGIN: Remove error button */
        function wrfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $('#Wr_Name' + cid).css("background", "white");
            $('#table-error').html('');
        }

        function whfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $('#Wh_name' + cid).css("background", "white");
            $('#table-error').html('');
        }

        function emailfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $('#email' + cid).css("background", "white");
            $('#table-error').html('');
        }

        function phonefn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $('#phone' + cid).css("background", "white");
            $('#table-error').html('');
        }

        function descfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $('#wr_description' + cid).css("background", "white");
        }

        function statusvalfn(ele) {
            var cid = $(ele).closest('tr').find('.vals').val();
            $('#select2-Status' + cid + '-container').parent().css({
                "background": "white",
                "position": "relative",
                "z-index": "2",
                "display": "grid",
                "table-layout": "fixed",
                "width": "100%"
            });
        }

        function removeZoneNameValidation() {
            $('#name-error').html('');
        }

        function removeRgn_idValidation() {
            $('#Rgn_Id-error').html('');
        }

        function StatusValidation() {
            $('#status-error').html('');
        }

        function statusFn() {
            $('#status-error').html('');
        }
    </script>
@endsection
