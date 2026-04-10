@extends('layout.app1')

@section('title')
@endsection

@section('content')

    @can('Woreda-View')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Woreda / Kebele</h3>
                            @can('Woreda-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addworeda" data-toggle="modal">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>
                                    <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="width:3%;">#</th>
                                                <th style="width:15%;">Type</th>
                                                <th style="width:15%;">Woreda / Kebele Name</th>
                                                <th style="width:15%;">Dispatch Station</th>
                                                <th style="width:17%;">Region</th>
                                                <th style="width:16%;">Zone</th>
                                                <th style="width:14%;">Status</th>
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
        </section>
    </div>
    @endcan

    <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="banktitlelbl" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modaltitle">Add Woreda & Kebele</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-md-6 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Type</label><label style="color: red; font-size:16px;">*</label>
                                <select class="select2 form-control" name="Type" id="Type" onchange="typeFn()">
                                    <option disabled value=""></option>
                                    <option value="1">Arrival</option>
                                    <option value="2">Export</option>
                                    <option value="3">Reject</option>
                                </select>
                                <span class="text-danger">
                                    <strong id="type-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-12 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Woreda/Kebele Name</label><label style="color: red; font-size:16px;">*</label>
                                <input type="text" placeholder="Woreda or Kebele Name" class="form-control mainforminp" name="Woreda_Name" id="Woreda_Name" onkeyup="woredaNameFn()"/>
                                <span class="text-danger">
                                    <strong id="name-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-4 col-md-12 col-sm-12 mb-1 arrproptype" id="dispatchStationDiv">
                                <label style="font-size: 14px;">Dispatch Station</label>
                                <input type="text" placeholder="Dispatch Station" class="form-control mainforminp" name="Station" id="Station" onkeyup="stationFn()"/>
                                <span class="text-danger">
                                    <strong id="station-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-12 mb-1" id="regionDiv">
                                <label style="font-size: 14px;">Region</label>
                                <select class="select2 form-control" name="Region" id="Region" onchange="regionFn()">
                                    @foreach ($regions as $regions)
                                    <option value="{{$regions->id}}">{{$regions->Rgn_Name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="region-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-6 col-md-12 col-sm-12 mb-1" id="zoneDiv">
                                <label style="font-size: 14px;">Zone</label>
                                <select class="select2 form-control" name="Zone" id="Zone" onchange="zoneFn()"></select>
                                <span class="text-danger">
                                    <strong id="zone-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12 mb-1">
                                <label style="font-size: 14px;">Email</label>
                                <input type="text" id="Email" name="Email" class="form-control mainforminp" placeholder="Email address" onkeydown="emailFn()" onkeyup="ValidateEmail(this);"/>
                                <span class="text-danger">
                                    <strong id="Email-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12">
                                <label style="font-size: 14px;">Phone Number</label>
                                <input type="number" id="PhoneNumber" name="PhoneNumber" class="form-control mainforminp" onkeypress="return ValidateNum(event);" placeholder="Phone number or Mobile number" onkeyup="phoneFn()" />
                                <span class="text-danger">
                                    <strong id="Phonenumber-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Certification</label>
                                <select class="select2 form-control" name="Certification[]" multiple id="Certification" onchange="certificationFn()">
                                    @foreach ($comcertnum as $comcertnum)
                                    <option value="{{$comcertnum->id}}">{{$comcertnum->Certification}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    <strong id="cert-error" class="errordatalabel"></strong>
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
                        <div style="display: none;">
                            <select class="select2 form-control" name="ZoneDefault" id="ZoneDefault">
                                @foreach ($zones as $zones)
                                <option title="{{$zones->Rgn_Id}}" value="{{$zones->id}}">{{$zones->Zone_Name}}</option>
                                @endforeach
                            </select>
                            <div class="col-xl-4 col-md-12 col-sm-12 mb-1">
                                <label style="font-size: 14px;">Symbol</label><label style="color: red; font-size:16px;">*</label>
                                <input type="text" placeholder="Symbol" class="form-control mainforminp" name="Symbol" id="Symbol" onkeyup="symbolFn()" style="text-transform: uppercase;"/>
                                <span class="text-danger">
                                    <strong id="symbol-error" class="errordatalabel"></strong>
                                </span>
                            </div>
                        </div>
                        <input type="hidden" placeholder="" class="form-control" name="recId" id="recId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savenewbutton" type="button" class="btn btn-info">Save & New</button>
                        <button id="savebutton" type="button" class="btn btn-info">Save & Close</button>
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Start Information Modal -->
    <div class="modal fade" id="informationmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Woreda / Kebele Information</h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="InformationForm">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="2">
                                                <label id="basictitle" style="font-size: 16px;font-weight:bold;">Basic Information</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%"><label style="font-size: 14px;">Type</label></td>
                                            <td style="width: 70%"><label id="infotype" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Woreda / Kebele Name</label></td>
                                            <td><label id="infoworedaname" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Dispatch Station</label></td>
                                            <td><label id="infostation" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Region</label></td>
                                            <td><label id="inforegion" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Zone</label></td>
                                            <td><label id="infozone" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Email</label></td>
                                            <td><label id="infoemail" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Phone Number</label></td>
                                            <td><label id="infophonenumber" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Certification</label></td>
                                            <td><label id="infocertification" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Description</label></td>
                                            <td><label id="descriptionlbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Status</label></td>
                                            <td><label id="statuslbl" style="font-size: 14px;font-weight:bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">-</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                    <table style="width: 100%;">
                                        <tr>
                                            <td colspan="2">
                                                <label id="actiontitle" style="font-size: 16px;font-weight:bold;">Action Information</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%"><label style="font-size: 14px;">Created By</label></td>
                                            <td style="width: 70%"><label id="createdbylbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Created Date</label></td>
                                            <td><label id="createddatelbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Last Edited By</label></td>
                                            <td><label id="lasteditedbylbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                        <tr>
                                            <td><label style="font-size: 14px;">Last Edited Date</label></td>
                                            <td><label id="lastediteddatelbl" style="font-size:14px;font-weight:bold;"></label></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
                        <label style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this woreda?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="delRecId" id="delRecId" readonly="true">
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
            $('#HolidayDate').daterangepicker({ 
                singleDatePicker: true,
                showDropdowns: true,
                autoApply:true,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
            var ctable=$('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searchHighlight: true,
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
                    url: '/woredalist',
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
                columns: [
                    { data: 'id', name: 'id', 'visible': false},
                    { data: 'DT_RowIndex',width:"3%"},
                    { data: 'CommType', name: 'CommType',width:"15%"},
                    { data: 'Woreda_Name', name: 'Woreda_Name',width:"15%"},
                    { data: 'Wh_name', name: 'Wh_name',width:"15%"},
                    { data: 'Rgn_Name', name: 'Rgn_Name',width:"17%"},
                    { data: 'Zone_Name', name: 'Zone_Name',width:"16%"},
                    { data: 'status', name: 'status',width:"14%"},
                    { data: 'action', name: 'action',width:"5%"}
                ],
                "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
                {
                    if (aData.status == "Active")
                    {
                        $(nRow).find('td:eq(6)').css({"color": "#4CAF50", "font-weight": "bold","text-shadow":"1px 1px 10px #4CAF50"});
                    }
                    else if (aData.status == "Inactive")
                    {
                        $(nRow).find('td:eq(6)').css({"color": "#f44336", "font-weight": "bold","text-shadow":"1px 1px 10px #f44336"});
                    }
                }
            });
        });

        $('.addworeda').click(function(){
            $('.mainforminp').val("");
            $('.errordatalabel').html('');
            $('#status').val("Active");
            $('#status').select2({
                minimumResultsForSearch: -1
            });
            $('#Region').val(null).trigger('change').select2
            ({
                placeholder: "Select Region here",
            });
            $('#Zone').empty();
            $('#Zone').select2({placeholder: "Select Region first",minimumResultsForSearch: -1});
            $('#Certification').val(null).trigger('change').select2
            ({
                placeholder: "Select Certification here",
                allowClear:true,
            });
            $('#Type').val(null).select2({
                placeholder: "Select Type here",
                minimumResultsForSearch: -1
            });
            $('#recId').val("");
            $('#operationtypes').val("1");
            $("#modaltitle").html("Add Woreda / Kebele");
            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled",false);
            $('#savebutton').show();
            $('#savenewbutton').show();
            $('.arrproptype').hide();
            $("#inlineForm").modal('show');
        });
       
        $('#savebutton').click(function() {
            var optype = $("#operationtypes").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveWoreda',
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
                        if (data.errors.Type) {
                            $('#type-error').html(data.errors.Type[0]);
                        }
                        if (data.errors.Woreda_Name) {
                            var text = data.errors.Woreda_Name[0];
                            text = text.replace("woreda  name","woreda or kebele name");
                            $('#name-error').html(text);
                        }
                        if (data.errors.Symbol) {
                            $('#symbol-error').html(data.errors.Symbol[0]);
                        }
                        if (data.errors.Station) {
                            var text = data.errors.Station[0];
                            text = text.replace("1","arrival");
                            $('#station-error').html(text);
                        }
                        if (data.errors.Region) {
                            var text = data.errors.Region[0];
                            text = text.replace("1","arrival");
                            $('#region-error').html(text);
                        }
                        if (data.errors.Zone) {
                            var text = data.errors.Zone[0];
                            text = text.replace("1","arrival");
                            $('#zone-error').html(text);
                        }
                        if (data.errors.Email) {
                            $('#Email-error').html(data.errors.Email[0]);
                        }
                        if (data.errors.PhoneNumber) {
                            $('#Phonenumber-error').html(data.errors.PhoneNumber[0]);
                        }
                        if (data.errors.Certification) {
                            $('#cert-error').html(data.errors.Certification[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save & Close');
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
                            $('#savebutton').text('Save & Close');
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
                            $('#savebutton').text('Save & Close');
                            $('#savebutton').prop("disabled", false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled", false);
                        }
                        toastrMessage('success',"Successful","Success");
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
            var depmame="";
            var lastdep="";
            $.ajax({
                url: '/saveWoreda',
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
                    $('#savenewbutton').prop("disabled", true);
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
                        if (data.errors.Type) {
                            $('#type-error').html(data.errors.Type[0]);
                        }
                        if (data.errors.Woreda_Name) {
                            var text = data.errors.Woreda_Name[0];
                            text = text.replace("woreda  name","woreda or kebele name");
                            $('#name-error').html(text);
                        }
                        if (data.errors.Symbol) {
                            $('#symbol-error').html(data.errors.Symbol[0]);
                        }
                        if (data.errors.Station) {
                            var text = data.errors.Station[0];
                            text = text.replace("1","arrival");
                            $('#station-error').html(text);
                        }
                        if (data.errors.Region) {
                            var text = data.errors.Region[0];
                            text = text.replace("1","arrival");
                            $('#region-error').html(text);
                        }
                        if (data.errors.Zone) {
                            var text = data.errors.Zone[0];
                            text = text.replace("1","arrival");
                            $('#zone-error').html(text);
                        }
                        if (data.errors.Email) {
                            $('#Email-error').html(data.errors.Email[0]);
                        }
                        if (data.errors.PhoneNumber) {
                            $('#Phonenumber-error').html(data.errors.PhoneNumber[0]);
                        }
                        if (data.errors.Certification) {
                            $('#cert-error').html(data.errors.Certification[0]);
                        }
                        if (data.errors.Description) {
                            $('#description-error').html(data.errors.Description[0]);
                        }
                        if (data.errors.status) {
                            $('#status-error').html(data.errors.status[0]);
                        }

                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('error',"Please check your input","Error");
                    }
                    
                    else if (data.dberrors) {
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('error',"Please contact administrator","Error");
                    }
                    else if(data.success){
                        $('#savenewbutton').text('Save & New');
                        $('#savenewbutton').prop("disabled", false);
                        toastrMessage('success',"Successful","Success");
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        closeRegisterModal();
                    }
                }
            });
        });

        function woredaEditFn(recordId) { 
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#recId").val(recordId);
            $('#Zone').empty();
            var selectedVals=[];
            $.ajax({
                url: '/showWoreda'+'/'+recordId,
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
                    $.each(data.woredadata, function(key, value) {
                        $('#Type').val(value.Type).select2();
                        $('#Woreda_Name').val(value.Woreda_Name);
                        $('#Symbol').val(value.Symbol);
                        $('#Station').val(value.Wh_name);
                        $('#Region').val(value.RegionId).select2();
                        var defaultoption = '<option selected value='+value.zone_id+'>'+value.Zone_Name+'</option>';
                        var zoneoption = $("#ZoneDefault > option").clone();
                        $('#Zone').append(zoneoption);
                        $("#Zone option[title!="+value.RegionId+"]").remove(); 
                        $("#Zone option[value="+value.zone_id+"]").remove();
                        $('#Zone').append(defaultoption);
                        $('#Zone').select2();
                        $('#Email').val(value.email);
                        $('#PhoneNumber').val(value.phone);
                        $("#Description").val(value.description);
                        $('#status').val(value.status).trigger('change').select2({minimumResultsForSearch: -1});
                    });

                    $.each(data.woredacer, function(key, value) {
                        selectedVals.push(value.com_certificates_id);
                    });
                    $('#Certification').val(selectedVals).trigger('change').select2();
                }
            });

            

            $("#modaltitle").html("Edit Woreda / Kebele");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').hide();
            $("#inlineForm").modal('show'); 
        }

        function woredaInfoFn(recordId) { 
            var selectedcert="";
            var wtype="";
            $.ajax({
                url: '/showWoreda'+'/'+recordId,
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
                    $.each(data.woredadata, function(key, value) {
                        if(parseInt(value.Type)==1){
                            wtype="Arrival";       
                        }
                        else if(parseInt(value.Type)==2){
                            wtype="Export";
                        }
                        else if(parseInt(value.Type)==3){
                            wtype="Reject";
                        }
                        $('#infotype').html(wtype);
                        $('#infoworedaname').html(value.Woreda_Name);
                        //$('#Symbol').val(value.Symbol);
                        $('#infostation').html(value.Wh_name);
                        $('#inforegion').html(value.Rgn_Name);
                        $('#infozone').html(value.Zone_Name);
                        $('#infoemail').html(value.email);
                        $('#infophonenumber').html(value.phone);
                        $("#descriptionlbl").html(value.Description);
                        $("#createdbylbl").html(value.created_by);
                        $("#createddatelbl").html(value.CreatedDateTime);
                        $("#lasteditedbylbl").html(value.updated_by);
                        if(value.updated_by==null || value.updated_by==""){
                            $("#lastediteddatelbl").html("");
                        }
                        if(value.updated_by!=null && value.updated_by!=""){
                            $("#lastediteddatelbl").html(value.UpdatedDateTime);
                        }
                        
                        var st=value.status;
                        if(st=="Active"){
                            $("#statuslbl").html("<b style='color:#1cc88a'>"+value.status+"</b>");
                        }
                        if(st=="Inactive"){
                            $("#statuslbl").html("<b style='color:#e74a3b'>"+value.status+"</b>");
                        }
                    });

                    $.each(data.woredacer, function(key, value) {
                        selectedcert+=value.Certification+", ";
                    });
                    $('#infocertification').html(selectedcert);
                }
            });

            $("#informationmodal").modal('show');
        }

        function woredaDeleteFn(recordId) { 
            var leavefromval=0;
            $("#delRecId").val(recordId);
            $.ajax({
                url: '/showWoreda'+'/'+recordId,
                type: 'GET',
               
                success: function(data) {
                    if(parseInt(data.count)==0){
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        $("#deletemodal").modal('show');
                    }
                    else if(parseInt(data.count)>0){
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
                    }
                }
            });
        }

        $('#deleterecbtn').click(function() {
            var delform = $("#deleteForm");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteWoreda',
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
                    if (data.existerror) {
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        $("#deletemodal").modal('hide');
                        toastrMessage('error',"Error found</br>This record cannot be deleted because it exists with other records.","Error");
                    }
                    else if (data.dberrors) {
                        $('#deleterecbtn').text('Delete');
                        $('#deleterecbtn').prop("disabled", false);
                        $("#deletemodal").modal('hide');
                        toastrMessage('error',"Error found</br>Please contact administrator","Error");
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
            $('.errordatalabel').html('');
            $('#status').val("Active");
            $('#status').select2({
                minimumResultsForSearch: -1
            });
            $('#Type').val(null).select2({
                minimumResultsForSearch: -1
            });
            $('#Region').val(null).trigger('change').select2
            ({
                placeholder: "Select Region here",
            });
            $('#Zone').empty();
            $('#Zone').select2({placeholder: "Select Region first",minimumResultsForSearch: -1});
            $('#Certification').val(null).trigger('change').select2
            ({
                placeholder: "Select Certification here",
                allowClear:true,
            });

            $('#recId').val("");
            $('#operationtypes').val("1");
            $('#savebutton').text('Save & Close');
            $('#savebutton').prop("disabled",false);
            $('#savenewbutton').text('Save & New');
            $('#savenewbutton').prop("disabled",false);
            $('#savebutton').show();
        }

        function typeFn() {
            var type= $('#Type').val();
            $('.arrproptype').hide();
            if(parseInt(type)==1){
                $('#dispatchStationDiv').show();
                $('#regionDiv').show();
                $('#zoneDiv').show();
            }
            else if(parseInt(type)==2 || parseInt(type)==3){
                $('#dispatchStationDiv').hide();
                $('#regionDiv').show();
                $('#zoneDiv').show();
            }
            $('#Region').val(null).trigger('change').select2
            ({
                placeholder: "Select Region here",
            });
            //$('#Zone').empty();
            //$('#Zone').select2({placeholder: "Select Region first",minimumResultsForSearch: -1});
            $('#Station').val("");
            $('#station-error').html('');
            $('#region-error').html('');
            $('#zone-error').html('');
            $('#type-error').html('');
        }

        function woredaNameFn() {
            $('#name-error').html('');
        }

        function stationFn() {
            $('#station-error').html('');
        }

        function symbolFn() {
            $('#symbol-error').html('');
        }

        function regionFn() {
            var regionId=$('#Region').val();
            var defaultoption = '<option selected value=""></option>';
            $('#Zone').empty();
            var zoneoption = $("#ZoneDefault > option").clone();
            $('#Zone').append(zoneoption);
            $("#Zone option[title!="+regionId+"]").remove(); 
            $('#Zone').append(defaultoption);
            $('#Zone').select2
            ({
                placeholder: "Select Zone here",
            });
            $('#region-error').html('');
        }

        function zoneFn() {
            $('#zone-error').html('');
        }

         function symbolFn() {
            $('#symbol-error').html('');
        }

        function emailFn() {
            $('#Email-error').html('');
        }

        function phoneFn() {
            $('#Phonenumber-error').html('');
        }

        function certificationFn() {
            $('#cert-error').html('');
        }

        function descriptionfn() {
            $('#description-error').html('');
        }

        function statusFn() {
            $('#status-error').html('');
        }
    </script>
@endsection
