@extends('layout.app1')
@section('title')
@endsection
@section('content')

    <div class="app-content content">
        <section id="responsive-datatable">
            @can('Region-View')
            <div class="row">
                <div class="col-12">
                    <!-- Your HTML content goes here -->
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Regions</h3>
                            @can('Region-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm" data-toggle="modal" data-target="#inlineForm">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>

                                    <table id="laravel-datatable-crud"
                                        class="display table-bordered table-striped table-hover dt-responsive mb-0 dataTable no-footer"
                                        style="width: 100%;" role="grid" aria-describedby="laravel-datatable-crud_info">
                                        <thead>
                                            <tr role="row">
                                                <th style="width:3%;">#</th>
                                                <th style="width:31%;">Region Name</th>
                                                <th style="width:31%;">Region Number</th>
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
           
            <!-- BEGIN: Region Add modal  -->
            <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1"
                role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" style="overflow-y: scroll;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Add Region</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="closeModalWithClearValidation()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <ul id="save_msgList"></ul>
                        <form id="Register">
                            {{ csrf_field() }}

                            <div class="modal-body">
                                <label strong style="font-size: 16px;">Region Name</label><label
                                    style="color: red; font-size:16px;">*</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Write Region Name here" class="form-control"
                                        name="Rgn_Name" id='NameFocus' onclick="removeRgnNameValidation()" autofocus />
                                    <span class="text-danger">
                                        <strong id="name-error"></strong>
                                    </span>
                                </div>
                                <label strong style="font-size: 16px;">Region Number</label><label
                                    style="color: red; font-size:16px;">*</label>
                                <div class="form-group">
                                    <input type="number" placeholder="Write Region Number here" class="form-control"
                                        name="Rgn_Number" id="number" onclick="removeNumberValidation()" />
                                    <span class="text-danger">
                                        <strong id="number-error"></strong>
                                    </span>
                                </div>
                                <label strong style="font-size: 16px;">Description</label><label
                                    style="color: red; font-size:16px;"></label>
                                <div class="form-group">
                                    <textarea name="description" id="description" placeholder="Write Description here" cols="20" rows="4"
                                        class="form-control" onclick="removeDescriptionValidation()"></textarea>
                                    <span class="text-danger">
                                        <strong id="description-error"></strong>
                                    </span>
                                </div>
                                <label strong style="font-size: 16px;">Status</label><label
                                    style="color: red; font-size:16px;">*</label>
                                <div class="form-group">
                                    <div>
                                        <select class="custom-select browser-default select2" name="status"
                                            id="status" onclick="removeStatusValidation()">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                        <span class="text-danger">
                                            <strong id="status-error"></strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="savenewbutton" type="button" class="btn btn-info">Save &
                                    New</button>
                                <button id="savebutton" type="button" class="btn btn-info">Save & Close</button>
                                <button id="closebutton" type="button" class="btn btn-danger"
                                    onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Region update modal  -->
            <div class="modal fade text-left" id="examplemodal-edit" data-keyboard="false" data-backdrop="static"
                tabindex="-1" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true"
                style="overflow-y: scroll;">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel34">Update Region</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="closeModalWithClearValidation()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <ul id="save_msgList"></ul>
                        <form id="updateRegister">
                            {{ csrf_field() }}

                            <input type="hidden" id="edit_id" />
                            <div class="modal-body">
                                <label strong style="font-size: 16px;">Region Name</label><label
                                    style="color: red; font-size:16px;">*</label>
                                <div class="form-group">
                                    <input type="text" placeholder="Write Region Name" class="form-control"
                                        name="Rgn_Name" id='edit_name' onclick="removeRgnNameValidation()" autofocus />
                                    <span class="text-danger">
                                        <strong id="uname-error"></strong>
                                    </span>
                                </div>
                                <label strong style="font-size: 16px;">Region Number</label><label
                                    style="color: red; font-size:16px;">*</label>
                                <div class="form-group">
                                    <input type="number" placeholder="Write Region Number" class="form-control"
                                        name="Rgn_Number" id="edit_number" onclick="removeNumberValidation()" />
                                    <span class="text-danger">
                                        <strong id="unumber-error"></strong>
                                    </span>
                                </div>
                                <label strong style="font-size: 16px;">Description</label><label
                                    style="color: red; font-size:16px;"></label>
                                <div class="form-group">
                                    <textarea name="description" placeholder="Wriet descriptio here" id="edit_description" cols="20"
                                        rows="4" class="form-control" onclick="removeDescriptionValidation()"></textarea>
                                    <span class="text-danger">
                                        <strong id="udescription-error"></strong>
                                    </span>
                                </div>
                                <label strong style="font-size: 16px;">Status</label><label
                                    style="color: red; font-size:16px;">*</label>
                                <div class="form-group">
                                    <div>
                                        <select class="custom-select browser-default select2" name="status"
                                            id="edit_status" onclick="removeStatusValidation()">
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
                                <button id="updatebutton" type="button" class="btn btn-info">Update</button>
                                <button id="closebutton" type="button"
                                    class="btn btn-danger wave-effect waves-float waves-light" data-dismiss="modal"
                                    onclick="closeModalWithClearValidation()">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Info modal -->
            <div class="modal fade text-left" id="infoModal" data-keyboard="false" data-backdrop="static"
                tabindex="-1" role="dialog" aria-labelledby="myModalLabel133" aria-hidden="true"
                style="overflow-y: scroll;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Region Information</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="regionform">
                            <input type="hidden" class="_token">
                            <div class="modal-body">
                                <table style="width: 100%">
                                    <tbody>
                                        <tr>
                                            <td style="width: 25%">
                                                <label style="font-size: 14px;">Region Name</label>
                                            </td>
                                            <td style="width: 75%">
                                                <label id="nameinfo" style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Region Number</label>
                                            </td>
                                            <td>
                                                <label id="numberinfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Description</label>
                                            </td>
                                            <td>
                                                <label id="descriptioninfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Status</label>
                                            </td>
                                            <td>
                                                <label id="statusinfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="divider newext">
                                                    <div class="divider-text">Action Information</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Created By</label>
                                            </td>
                                            <td>
                                                <label id="createdbyinfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Created Date</label>
                                            </td>
                                            <td>
                                                <label id="createddateinfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label style="font-size: 14px;">Last Edited By</label>
                                            </td>
                                            <td>
                                                <label id="lasteditedbyinfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%">
                                                <label style="font-size: 14px;">Last Edited Date</label>
                                            </td>
                                            <td style="width: 70%">
                                                <label id="lastediteddateinfo"
                                                    style="font-size: 14px; font-weight: bold;"></label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button id="closebuttonk" type="button"
                                    class="btn btn-danger waves-effect waves-float waves-light"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- BEGIN: Delete Modal --}}
            <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Delete Region Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="closeModalWithClearValidation()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="background-color:#e74a3b">
                            <label strong style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this region?</label>
                            <input type="hidden" id="deleteing_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info delete_region">Delete</button>
                            <button id="closebutton" type="button" class="btn btn-danger"
                                onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script type="text/javascript">
        $(function() {
            cardSection = $('#page-block');
        });
        $(document).ready(function() {
            /* BEGIN: yajra datatable*/
            var rtable = $('#laravel-datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                "pagingType": "simple",
                searchHighlight: true,
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                "dom": "<'row'<'col-lg-3 col-md-5 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",

                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/get-region',
                    type: 'DELETE',
                    beforeSend: function() {
                        cardSection.block({
                            message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                        orderable: false,
                        searchable: false,
                        width:"3%"
                    }, {
                        data: 'Rgn_Name',
                        name: 'Rgn_Name',
                        width:"31%"
                    },
                    {
                        data: 'Rgn_Number',
                        name: 'Rgn_Number',
                        width:"31%"
                    },
                    {
                        data: 'status',
                        name: 'status',
                        width:"30%"
                    },
                    {
                        data: null,
                        render: function(data, type, full, meta) {
                            return '<div class="btn-group dropleft"><button type="button" class="btn btn-sm dropdown-toffle hide-arrow" data-toggle="dropdown" arial-haspopup="true" arial-expanded="false"><i class="fa fa-ellipsis-v"></i></button><div class = "dropdown-menu" > <a  class ="dropdown-item regionInfo" title="show" data-id = "' +
                                data.id +
                                '"><i class="fa fa-info"></i><span> Info </span></a>' +
                                '@can("Region-Edit")<a class ="dropdown-item editbtn" data-name="Lockset" data-status data-toggle="modal" id="smallButton" data-target="#examplemodal-edit" title="Edit" data-id = "' +
                                data.id +
                                '"><i class="fa fa-edit"></i><span> Edit </span></a>@endcan' +
                                '@can("Region-Delete")<a class ="dropdown-item deletebtn" data-status data-toggle="modal" id="smallButton" data-target="#examplemodal-delete" data-attr title="Delete Record" data-id = "' +
                                data.id +
                                '"><i class="fa fa-trash"></i><span> Delete </span></a>@endcan</div></div> ';
                        },
                        orderable: false,
                        searchable: false,
                        width:"5%"
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
            /* End: Yajra data table*/
            $('#laravel-datatable-crud tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                } else {
                    $('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
            });

            $('#status').select2({
                minimumResultsForSearch: -1
            });
        });


        /* BEGIN: Save button operation*/
        $('body').on('click', '#savebutton', function() {
            var registerForm = $('#Register');
            var formData = registerForm.serialize();
            $('#name-error').html("");
            $('#number-error').html("");
            $('#description-error').html("");
            $('#status-error').html("");
            $.ajax({
                url: '/regions.store',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#savebutton').text('Saving...')
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.Rgn_Name) {
                            $('#name-error').html(data.errors.Rgn_Name[0].replace(
                                'rgn',
                                'Region'));
                        }
                        if (data.errors.Rgn_Number) {
                            $('#number-error').html(data.errors.Rgn_Number[0].replace(
                                'rgn',
                                'Region'));
                        }
                        if (data.errors.description) {
                            $('#description-error').html(data.errors.description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }
                        if (data.type == "dup") {
                            $('#savebutton').text('Save & Close');
                            toastrMessage('error',
                                "<p style='background: white; padding: 10px; color: red'>Duplicate entry. Region name or region number already exists.</p>",
                                "Error"
                            );
                        } else if (data.type == "faild") {
                            $('#savebutton').text('Save & Close');
                            toastrMessage('error',
                                "<p style='background: white; padding: 10px; color: red'>An error occured.</p>",
                                "Error"
                            );
                        } else {
                            $('#savebutton').text('Save & Close');
                            toastrMessage('error',
                                "<p style='color: white'>Check your inputs</p>", "Error"
                            );
                        }
                    }
                    if (data.success) {
                        $('#savebutton').text('Save & Close');
                        $('#inlineForm').modal('hide');
                        toastrMessage('success',
                            "<span style='color: white;'>Region Created Successfully.</span>",
                            "Success");
                        $('#Register')[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        /* BEGIN: Save new button operation*/
        $('body').on('click', '#savenewbutton', function() {
            var registerForm = $('#Register');
            var formData = registerForm.serialize();
            $('#name-error').html("");
            $('#number-error').html("");
            $('#description-error').html("");
            $('#status-error').html("");
            $.ajax({
                url: '/regions.store',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#savenewbutton').text('Saving...')
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.Rgn_Name) {
                            $('#name-error').html(data.errors.Rgn_Name[0]);
                        }
                        if (data.errors.Rgn_Number) {
                            $('#number-error').html(data.errors.Rgn_Number[0]);
                        }
                        if (data.errors.description) {
                            $('#description-error').html(data.errors.description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        if (data.type == "dup") {
                            $('#savenewbutton').text('Save & New');
                            toastrMessage('error',
                                "<p style='background: white; padding: 10px; color: red'>Duplicate entry. Region name or region number already exists.</p>",
                                "Error"
                            );
                        } else if (data.type == "faild") {
                            $('#savenewbutton').text('Save & New');
                            toastrMessage('error',
                                "<p style='background: white; padding: 10px; color: red'>An error occured.</p>",
                                "Error"
                            );
                        } else {
                            $('#savenewbutton').text('Save & New');
                            toastrMessage('error',
                                "<p style='color: white'>Check your inputs</p>", "Error"
                            );
                        }
                    }
                    if (data.success) {
                        $('#savenewbutton').text('Save & New');
                        toastrMessage('success',
                            "<span style='color: white;'>Region Created Successfully.</span>",
                            "Success");
                        $("#inlineForm").modal('show');
                        $("#NameFocus").focus();
                        $("#Register")[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        });

        /* Began: Region editing*/
        $(document).on('click', '.editbtn', function(e) {
            e.preventDefault();
            var edit_id = $(this).attr('data-id');
            // alert(edit_id);
            $.ajax({
                type: "GET",
                url: "/region_edit/" + edit_id,
                success: function(response) {
                    if (response.status == 200) {
                        // console.log(response.region.name);
                        $('#edit_name').val(response.region.Rgn_Name);
                        $('#edit_number').val(response.region.Rgn_Number);
                        $('#edit_description').val(response.region.description);
                        $('#edit_status').val(response.region.status);
                        $('#edit_id').val(response.region.id);
                    } else {

                    }
                }
            });
        });

        /* BEGIN: Region updating */
        $('body').on('click', '#updatebutton', function() {
            var registerForm = $('#updateRegister');
            var formData = registerForm.serialize();
            var id = $('#edit_id').val();
            $('#uname-error').html("");
            $('#unumber-error').html("");
            $('#udescription-error').html("");
            $('#ustatus-error').html("");
            $.ajax({
                url: '/regions.store/' + id,
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#updatebutton').text('Updating...')
                },
                success: function(data) {
                    if (data.errors) {
                        if (data.errors.Rgn_Name) {
                            $('#uname-error').html(data.errors.Rgn_Name[0]);
                        }
                        if (data.errors.Rgn_Number) {
                            $('#unumber-error').html(data.errors.Rgn_Number[0]);
                        }
                        if (data.errors.description) {
                            $('#udescription-error').html(data.errors.description[0]);
                        }
                        if (data.errors.status) {
                            $('#ustatus-error').html(data.errors.status[0]);
                        }
                        if (data.type == "dup") {
                            $('#updatebutton').text('Update');
                            toastrMessage('error',
                                "<p style='background: white; padding: 10px; color: red'>Duplicate entry. Region name or region number already exists.</p>",
                                "Error"
                            );
                        } else if (data.type == "faild") {
                            $('#updatebutton').text('Update');
                            toastrMessage('error',
                                "<p style='background: white; padding: 10px; color: red'>An error occured.</p>",
                                "Error"
                            );
                        } else {
                            $('#updatebutton').text('Update');
                            toastrMessage('error',
                                "<p style='color: white'>Check your inputs</p>", "Error"
                            );
                        }
                    }
                    if (data.success) {
                        $('#updatebutton').text('Update');
                        $('#examplemodal-edit').modal('hide');
                        toastrMessage('success',
                            "<span style='color: white;'>Region Updated Successfully.</span>",
                            "Success");
                        $('#updateRegister')[0].reset();
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                },
            });
        });
        /* BEGIN: delete region */
        $(document).on('click', '.deletebtn', function() {
            var delete_id = $(this).attr('data-id');
            $('#DeleteModal').modal('show');
            $('#deleteing_id').val(delete_id);
        });
        $(document).on('click', '.delete_region', function(e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-region/" + id,
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 404) {
                        toastrMessage('error',
                            "<p style='color: white'>Something wrond</p>", "Error");
                        $('.delete_region').text('Yes Delete');
                    } else {
                        toastrMessage('success',
                            "<span style='color: white;'>Region Deleted Successfully</span>",
                            "Success");
                        $('.delete_region').text('Delete');
                        $('#DeleteModal').modal('hide');
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                }
            });
        });
        /* BEGIN: region info */
        $(document).on('click', '.regionInfo', function() {

            var regid = $(this).attr('data-id');
            //alert(regid)
            $.ajax({
                type: 'get',
                url: "/region_show/" + regid,
                dataType: "json",
                beforeSend: function() {
                    cardSection.block({
                        message: '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
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
                            background: '',
                            color: '',
                            border: ''
                        },
                    });
                },
                success: function(response) {
                    if (response.status == 200) {
                        $('#nameinfo').html(response.region.Rgn_Name);
                        $('#numberinfo').html(response.region.Rgn_Number);
                        $('#descriptioninfo').html(response.region.description);
                        $('#createdbyinfo').html(response.cr.username);
                        $('#lasteditedbyinfo').html(response.ur.username);
                        $('#createddateinfo').html(response.crdate);

                        if (response.ur !== "") {
                            $('#lastediteddateinfo').html(response.upgdate);
                        }
                        if (response.region.status == "Active") {
                            $('#statusinfo').html("<sapn style='color: #1cc88a; font-weight: bold;font-size: 16px;'>" +response.region.status + "</span>");
                        } else {
                            $('#statusinfo').html("<sapn style='color: #e74a3b; font-weight: bold; font-size: 16px;'>" +response.region.status + "</span>");
                        }
                    } else {}
                },
            });
            $('#infoModal').modal('show');
        });
        
        /* BEGIN: validation function */
        function removeRgnNameValidation() {
            $('#name-error').html('');
            $('#uname-error').html('');
        }

        function removeNumberValidation() {
            $('#number-error').html('');
            $('#unumber-error').html('');
        }

        function removeDescriptionValidation() {
            $('#description-error').html('');
            $('#udescription-error').html('');
        }

        function removeStatusValidation() {
            $('#status-error').html('');
            $('#ustatus-error').html('');
        }

        function closeModalWithClearValidation() {
            $('#name-error').html('');
            $('#uname-error').html('');
            $('#status-error').html('');
            $('#ustatus-error').html('');
            $('#description-error').html('');
            $('#udescription-error').html('');
            $('#number-error').html('');
            $('#unumber-error').html('');
            $('#savebutton').html('Save & Close');
            $('#updatebutton').html('Update');
            $('#savenewbutton').html('Save & New');
            $('#Register')[0].reset();
            $('#updateregisterform')[0].reset();
            $('#status').val('Active').trigger('change').select2({
                minimumResultsForSearch: -1
            });
        }
    </script>
@endsection
