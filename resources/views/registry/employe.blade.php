@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Trainer-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Trainer</h3>
                            @can('Trainer-Add')
                                <button type="button" class="btn btn-gradient-info btn-sm addempbutton">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;display:none;" id="main-datatable">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 10%;">Face ID</th>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 10%;">Type</th>
                                            <th style="width: 18%;">Full Name</th>
                                            <th style="width: 10%;">Gender</th>
                                            <th style="width: 10%;">DOB</th>
                                            <th style="width: 15%;">Phone</th>
                                            <th style="width: 10%;">Status</th>
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
                    <h4 class="modal-title" id="membertitle"></h4>
                    <div class="row">
                        <div style="text-align: right" id="statusdisplay"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeRegisterModal()"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="row">
                                <div class="col-xl-9" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12">
                                            <div class="divider">
                                                <div class="divider-text">Basic Information</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-2 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;">Type <b style="color:red;">*</b></label>
                                                    <select name="type" id="type" class="select2 form-control" placeholder="Select Type" onchange="clearTypeError()">
                                                        <option selected value=""></option>
                                                        @foreach ($department as $department)
                                                        <option value="{{$department->id}}">{{$department->DepartmentName}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="type-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;">Full Name <b style="color:red;">*</b></label>
                                                    <input type="text" name="Name" id="Pname" class="form-control" placeholder="Enter Full Name here" onkeyup="clearPnameError()" @can('Edit-Verified-Staff') ondblclick="adjEmployeeName(this);" @endcan/>
                                                    <span class="text-danger">
                                                        <strong id="Pname-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-3 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;" class="form-label" for="Gender">Gender <b style="color:red;">*</b></label>
                                                    <div class="demo-inline-spacing">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio1" name="gender" class="custom-control-input " value="Male" onclick="cleargendererror()"/>
                                                            <label style="font-size: 14px;" class="custom-control-label" for="customRadio1">Male</label>
                                                        </div>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="customRadio2" name="gender" class="custom-control-input" value="Female" onclick="cleargendererror()"/>
                                                            <label style="font-size: 14px;" class="custom-control-label" for="customRadio2" >Female</label>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger">
                                                        <strong id="gender-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;" for="fp-default">DOB <i>(Date of Birth)</i><b style="color:red;">*</b></label>
                                                    <input type="text" name="Dob" id="Dob" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="clearDobError()"  />
                                                    <span class="text-danger">
                                                        <strong id="dob-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12" style="display: none;">
                                                    <label style="font-size: 14px;" class="form-label" for="TinNumbers">TIN Number</label>
                                                    <input type="text" name="TinNumber" id="TinNumber" class="form-control" minlength="10" maxlength="13" placeholder="Enter TIN Number here" onkeypress="return ValidateNum(event);" onkeydown="clearTinnumberError()" onkeyup="TinNumberCounter()"/>
                                                    <span><label style="font-size: 14px;color" id="tinCounter">0/13</label></span>
                                                    <span class="text-danger">
                                                        <strong id="TinNumber-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12">
                                                    <div class="form-group">
                                                        <label style="font-size: 14px;" class="form-label">Nationality <b style="color:red;">*</b></label> 
                                                        <select name="nationality" id="nationality" class="select2 form-control" placeholder="Select Nationality" onchange="clearNationalityError()">
                                                            <option selected value=""></option>
                                                            @foreach ($countrynat as $countrynat)
                                                            <option value="{{$countrynat->name}}">{{$countrynat->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            <strong id="nationality-error"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Address & Other Information</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-2 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label style="font-size: 14px;" class="form-label">Country</label> 
                                                <select name="country" id="country-dd" class="select2 form-control" onchange="clearCountryError()">
                                                    @foreach ($country as $data)
                                                    <option selected value="{{$data->name}}">{{$data->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="country-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label">City <b style="color:red;">*</b></label>
                                            <select name="city" id="city-dd" class="select2 form-control">
                                                <option selected value=""></option>
                                                @foreach ($city as $data)
                                                <option value="{{$data->id}}">{{$data->city_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="city-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label">Subcity <b style="color:red;">*</b></label>
                                            <select class="select2 form-control" name="subcity" id="subcity-dd" onchange="clearSubcityError()"></select>
                                            <span class="text-danger">
                                                <strong id="subcity-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label">Woreda <b style="color:red;">*</b></label>
                                            <select class="select2 form-control" name="Woreda" id="Woreda" onchange="clearWoredaError()">
                                                <option selected value=""></option>
                                                <option value="Woreda 1">Woreda 1</option>
                                                <option value="Woreda 2">Woreda 2</option>
                                                <option value="Woreda 3">Woreda 3</option>
                                                <option value="Woreda 4">Woreda 4</option>
                                                <option value="Woreda 5">Woreda 5</option>
                                                <option value="Woreda 6">Woreda 6</option>
                                                <option value="Woreda 7">Woreda 7</option>
                                                <option value="Woreda 8">Woreda 8</option>
                                                <option value="Woreda 9">Woreda 9</option>
                                                <option value="Woreda 10">Woreda 10</option>
                                                <option value="Woreda 11">Woreda 11</option>
                                                <option value="Woreda 12">Woreda 12</option>
                                                <option value="Woreda 13">Woreda 13</option>
                                                <option value="Woreda 14">Woreda 14</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="Woreda-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="Location">Location</label>
                                            <input type="text" id="Location" name="Location" class="form-control" placeholder="Enter Location here" />
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mt-1">
                                            <label style="font-size: 14px;" class="form-label" for="Mobilenumber ">Mobile or Phone Number <b style="color:red;">*</b></label>
                                                <div class="input-group">
                                                    <input type="number" id="Mobile" name="Mobile" class="form-control" onkeypress="return ValidateNum(event);" placeholder="Enter Mobile Number here" onclick="clearMobileError()" />
                                                    <input type="number" id="Phone" name="Phone" class="form-control" onkeypress="return ValidateNum(event);" placeholder="Enter Phone Number here" onclick="clearpPhoneError()" />
                                                </div>
                                            <span class="text-danger">
                                                <strong id="Mobilenumber-error"></strong>
                                            </span>
                                            <span class="text-danger">
                                                <strong id="Phonenumber-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mt-1">
                                            <label style="font-size: 14px;" class="form-label">Email</label>
                                            <input type="text" id="Email" name="Email" class="form-control" placeholder="Enter Email Address here" onkeydown="clearEmailError()" onkeyup="ValidateEmail(this);"/>
                                            <span class="text-danger">
                                                <strong id="Email-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mt-1" style="display: none;">
                                            <label style="font-size: 14px;" class="form-label" for="Occupation">Occupation</label>
                                            <select class="select2 form-control" name="Occupation" id="Occupation" data-placeholder="Select Occupation here" onchange="clearOccupationError()">
                                                <option selected value=""></option>
                                                <option value="Employed">Employed</option>
                                                <option value="Self-Employed">Self-Employed</option>
                                                <option value="Student">Student</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="Occupation-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-5 col-md-6 col-sm-12 mt-1">
                                            <label style="font-size: 14px;" class="form-label" for="PassportNO">Passport No or Residance ID</label>
                                            <div class="input-group">
                                                <input type="text" id="PassportNO" name="PassportNumber" class="form-control" onkeyup="clearPassportnoError()" placeholder="Enter Passport Number here" />
                                                <input type="text" id="Residenceid" name="ResidenceId" class="form-control" onkeyup="clearResidenceidError()" placeholder="Enter Residance ID here" />
                                            </div>
                                            <span class="text-danger">
                                                <strong id="Residenceid-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12 mt-2" style="display: none;">
                                            <label style="font-size: 14px;">Health Status</label>
                                            <div>
                                                <textarea type="text" placeholder="Write Health status here..." class="form-control" name="HealthStatus" id="HealthStatus" onkeyup="healthst()"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="healthst-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12 mt-2">
                                            <label style="font-size: 14px;">Memo</label>
                                            <div>
                                                <textarea type="text" placeholder="Write Memo here..." class="form-control" name="Memo" id="Memo"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mt-2">
                                            <label style="font-size: 14px;" class="form-label">Status</label>
                                            <select class="select2 form-control" name="Status" id="Status">
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                                <option value="Block">Block</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="Status-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Emergency Contact</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="contactName">Emergency Contact Name</label>
                                            <input type="text" id="contactName" name="contactName" class="form-control" placeholder="Enter Emergency Contact Person here"/>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="contactMobileNumber">Emergency Contact Phone Number</label>
                                            <input type="number" id="contactMobileNumber" name="contactMobileNumber" onkeypress="return ValidateNum(event);" class="form-control" placeholder="Enter Mobile Number here"/>
                                        </div>
                                        <div class="col-xl-4 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="contactLocation">Emergency Contact Location</label>
                                            <input type="text" id="contactLocation" name="contactLocation" class="form-control" placeholder="Enter Location here" />
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12 mt-1 skillcls">
                                            <div class="divider skillcls">
                                                <div class="divider-text">Skills</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;" class="form-label">Skill <b style="color:red;">*</b></label>
                                                    <select class="select2 form-control" name="skill[]" id="skill" multiple data-placeholder="Select Trainers Skill Set here" onchange="clearSkillerror()">
                                                        @foreach ($service as $service)
                                                            <option value="{{$service->id}}">{{$service->ServiceName}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="skill-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12 mt-1">
                                            <div class="divider">
                                                <div class="divider-text">Document Uploads</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;" class="form-label" for="Identification">Identification ID</label>
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <input type="file" name="Identification" id="Identification" class="form-control" onchange="clearIdentificationError()">
                                                            </td>
                                                            <td>
                                                                <button type="button" id="removeidnbtn" name="removeidnbtn" class="btn btn-flat-danger waves-effect btn-sm removeidnbtnclas">X</button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <input type="hidden" name="Identificationupdate" id="Identificationupdate" class="form-control" readonly>
                                                    <span class="text-danger">
                                                        <button type="button" id="identificationidlinkbtn" name="identificationidlinkbtn" class="btn btn-flat-info waves-effect identificationidcls" style="display: :none;"></button>
                                                        <strong id="Identification-error"></strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="divider">
                                        <div class="divider-text">Biometric Data</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 mt-1">
                                            <label style="font-size: 14px;" class="form-label">Enroll Device</label>
                                            <select class="select2 form-control" name="EnrollDevice" id="EnrollDevice" onchange="enrolldevFn()">
                                                @foreach ($devices as $devices)
                                                <option value="{{$devices->id}}">{{$devices->DeviceName}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="enroll-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-6 mt-1">
                                            <button id="syncbutton" type="button" class="btn btn-outline-info waves-effect" title="Get Face ID data from the device" style="width: 100%;">Get FaceID</button>
                                        </div>
                                        <div class="col-xl-6 mt-1">
                                            <button id="syncbuttonfp" type="button" class="btn btn-outline-info waves-effect" title="Get Fingerprint data from the device" style="width: 100%;">Get Fingerprint</button>
                                        </div>
                                        
                                        <div class="col-xl-12 col-md-6 col-sm-12 biodata">
                                            <div class="col-xl-12 col-lg-12 mt-1" id="imageprv" style="text-align: center;">
                                                <label style="font-size: 14px;font-weight:bold;" class="form-label">Face ID</label></br>
                                                <img id="previewImg" src="" alt="Face ID not found" height="50%" width="60%" style="text-align: center;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 mt-1 biodata">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td colspan="5" style="text-align: center;">
                                                        <label style="font-size: 14px;font-weight:bold;" class="form-label"><u>Registered & Non-Registered Finger Print</u></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:24;"><label style="font-size:12px;" class="form-label">Left Thumb</label></td>
                                                    <td style="width:24;"><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftthumblbl"></label></td>
                                                    <td style="width:4;"></td>
                                                    <td style="width:24;"><label style="font-size:12px;" class="form-label">Right Thumb</label></td>
                                                    <td style="width:24;"><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightthumblbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size:12px;" class="form-label">Left Index</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftindexlbl"></label></td>
                                                    <td></td>
                                                    <td><label style="font-size:12px;" class="form-label">Right Index</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightindexlbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size:12px;" class="form-label">Left Middle</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftmiddlelbl"></label></td>
                                                    <td></td>
                                                    <td><label style="font-size:12px;" class="form-label">Right Middle</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightmiddlelbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size:12px;" class="form-label">Left Ring</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftringlbl"></label></td>
                                                    <td></td>
                                                    <td><label style="font-size:12px;" class="form-label">Right Ring</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightringlbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size:12px;" class="form-label">Left Pinky</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftpinkylbl"></label></td>
                                                    <td></td>
                                                    <td><label style="font-size:12px;" class="form-label">Right Pinky</label></td>
                                                    <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightpinkylbl"></label></td>
                                                </tr>
                                            </table>
                                        </div>

                                        <div class="col-xl-12 col-md-6 col-sm-12" style="display: none;">
                                            <label style="font-size: 14px;" class="form-label" for="Picture">Picture</label>
                                            <div>
                                                <div class="btn-group dropup" style="width:100%;">
                                                    <button type="button" class="btn btn-outline-secondary">Browse or Take Picture</button>
                                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu  dropdown-menu-right">
                                                        <input type="file" name="Picture" id="Picture" accept="image/*" onchange="clearPictureError()">
                                                        <a class="dropdown-item" onclick="openCaptureModal()">Take a Picture</a>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="captureimages" id="captureimages" class="form-control" readonly>
                                                <input type="hidden" name="Pictureupdate" id="Pictureupdate" class="form-control" readonly>
                                                <span class="text-danger">
                                                    <img id="previewImg" src="" alt="" height="100%" width="100%">
                                                    <button type="button" id="removepicbtn" name="removepicbtn" class="btn btn-flat-danger waves-effect btn-sm removebtncls">X</button>
                                                    <strong id="picture-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <div style="display: none;">
                            <select name="subcitycbx" id="subcitycbx" class="select2 form-control">
                                <option selected value=""></option>
                                @foreach ($subcity as $subcity)
                                <option label="{{$subcity->city_id}}" value="{{$subcity->id}}">{{$subcity->subcity_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" placeholder="" class="form-control" name="LeftThumbVal" id="LeftThumbVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="LeftIndexVal" id="LeftIndexVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="LeftMiddelVal" id="LeftMiddelVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="LeftRingVal" id="LeftRingVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="LeftPickyVal" id="LeftPickyVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="RightThumbVal" id="RightThumbVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="RightIndexVal" id="RightIndexVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="RightMiddleVal" id="RightMiddleVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="RightRingVal" id="RightRingVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="RightPickyVal" id="RightPickyVal" readonly="true" value=""/>
                        <input type="hidden" placeholder="" class="form-control" name="faceidencoded" id="faceidencoded" readonly="true" value=""/>  
                        <input type="hidden" placeholder="" class="form-control" name="personuuid" id="personuuid" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="currentdatehidden" id="currentdatehidden" readonly="true" value="{{$currentdate}}"/>
                        <input type="hidden" placeholder="" class="form-control" name="memberId" id="memberId" readonly="true" value=""/>     
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        @can('Trainer-Add')
                            <button id="savebutton" type="submit" class="btn btn-info">Save</button>
                        @endcan   
                        <button id="closebutton" type="button" class="btn btn-danger" onclick="closeRegisterModal()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Registation Modal -->

    {{-- info show modal --}}
    <div class="modal fade text-left" id="memberInfoModal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel334">Info</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cleartenantinfovalue()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12" id="iteminfo">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Basic Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <td><label style="font-size: 14px;">ID</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="memberidslbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;">Type</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="typenamelbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;">Full Name</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="NameLbl"></label></td>
                                                </tr>
                                                <tr id="gendertr">
                                                    <td> <label style="font-size: 14px;">Gender</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="GenderLbl"></label></td>
                                                </tr>
                                                <tr id="dobtr">
                                                    <td> <label style="font-size: 14px;">DOB</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="DOBLbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;">Nationality</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="NationalityLbl"></label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title">Emergency Contact</h6>
                                        </div>
                                        <div class="card-body">
                                            <table>
                                                <tr>
                                                    <td><label style="font-size: 14px;">Name</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="emergencyconnamelbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;">Phone</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="emergencyphonelbl"></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;">Location</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="emergencyloclbl"></label></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Address & Other Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <table>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Country</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="CountryLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">City</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="CityLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Sub City</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="SubCityLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Woreda</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="WoredaLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Location</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="LocationLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Mobile Phone</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="PhoneLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Email</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="EmailLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size: 14px;">Passport #</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="PassportNoLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Residance ID</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="ResidanceIdLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Identification ID</label></td>
                                                        <td><a style="text-decoration:underline;color:blue;" onclick="identificationidval()" id="IdentificationIdLbl"></a></td>
                                                    </tr>
                                                    <tr style="display:none;">
                                                        <td> <label style="font-size: 14px;">Health Status</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="healthstatuslbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;">Memo</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="memolbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size: 14px;">Status</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="StatusLbl"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="divider newext">
                                                                <div class="divider-text">Action Information</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size: 14px;">Created By</label></td>
                                                        <td><label id="createdbylbl" style="font-size:14px;font-weight:bold;"></label></td>
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
                                        <div class="divider">
                                            <div class="divider-text">-</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="width: 10%"><label style="font-size: 14px;">Skills</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="SkillsLblInfo"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Biometric Data</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 mb-2" style="border-bottom-style: solid;border-bottom-color:rgba(34, 41, 47, 0.2);border-bottom-width: 1px;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="width: 40%"><label style="font-size: 14px;">Enroll Device</label></td>
                                                        <td style="width: 60%"><label id="enrolldeviceinfo" style="font-size:14px;font-weight:bold;"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-12 col-lg-12">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <label style="font-size: 14px;font-weight:bold;" class="form-label">Face ID</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                                                <img id="previewInfoImg" src="" alt="No picture uploaded" height="300" width="100%">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 mt-2">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td colspan="5" style="text-align: center;">
                                                            <label style="font-size: 14px;font-weight:bold;" class="form-label"><u>Registered & Non-Registered Finger Print</u></label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:24;"><label style="font-size:12px;" class="form-label">Left Thumb</label></td>
                                                        <td style="width:24;"><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftthumblblinfo"></label></td>
                                                        <td style="width:4;"></td>
                                                        <td style="width:24;"><label style="font-size:12px;" class="form-label">Right Thumb</label></td>
                                                        <td style="width:24;"><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightthumblblinfo"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size:12px;" class="form-label">Left Index</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftindexlblinfo"></label></td>
                                                        <td></td>
                                                        <td><label style="font-size:12px;" class="form-label">Right Index</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightindexlblinfo"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size:12px;" class="form-label">Left Middle</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftmiddlelblinfo"></label></td>
                                                        <td></td>
                                                        <td><label style="font-size:12px;" class="form-label">Right Middle</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightmiddlelblinfo"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size:12px;" class="form-label">Left Ring</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftringlblinfo"></label></td>
                                                        <td></td>
                                                        <td><label style="font-size:12px;" class="form-label">Right Ring</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightringlblinfo"></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size:12px;" class="form-label">Left Pinky</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="leftpinkylblinfo"></label></td>
                                                        <td></td>
                                                        <td><label style="font-size:12px;" class="form-label">Right Pinky</label></td>
                                                        <td><label style="font-size:12px;font-weight:bold;" class="form-label" id="rightpinkylblinfo"></label></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" placeholder="" class="form-control" name="memberInfoId" id="memberInfoId" readonly="true" value=""/>
                    <input type="hidden" placeholder="" class="form-control" name="filenameInfo" id="filenameInfo" readonly="true" value=""/>
                    <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--  end of info show madal  -->
    
    <!--Start service delete modal -->
    <div class="modal fade text-left" id="deletemembershipmodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deletememberform">
                    @csrf
                    <div class="modal-body" style="background-color:#e74a3b">
                        <label style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this employee?</label>
                        <div class="form-group">
                            <input type="hidden" placeholder="" class="form-control" name="memberDelId" id="memberDelId" readonly="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="deletememberbtn" type="button" class="btn btn-info">Delete</button>
                        <button id="closebuttonk" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End service delete modal -->

    <!--Start capture modal -->
    <div class="modal fade text-left" id="capturemodal" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color:#f2f3f4 ">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"><b>Capture Picture</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeCaptureModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="captureform">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" style="text-align: center;">
                                <div id="my_camera"></div>
                                <input type="hidden" name="image" class="image-tag">
                            </div>
                            <div class="divider">
                                <div class="divider-text"></div>
                            </div>  
                            <div class="col-md-12" style="text-align: center;">
                                <button type="button" class="btn btn-outline-info btn-block waves-effect btn-lg" onclick="take_snapshot()"><i class="fa fa-camera" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End capture modal -->

    <script type="text/javascript">
        var errorcolor="#ffcccc";
        $(function () {
            cardSection = $('#page-block');
        });
        var j=0;
        var i=0;
        var m=0;

        $(document).ready(function() {
            $('#Dob').pickadate({
                format: 'yyyy-mm-dd',
                selectMonths: true,
                selectYears: 60,
                max: true
            });

            $('#laravel-datatable-crud').DataTable({
                destroy: true,
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
                "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-4'><'col-sm-12 col-md-3'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/employeelist',
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
                        data: 'eid',
                        name: 'eid',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex'
                    },
                    {
                        data: 'Picture',
                        "render": function( data, type, row, meta) {
                            if(data==null){
                                if(row.Gender=="Male"){
                                    return '<div style="text-align:left;margin-left:-10%;width:111px;height:111px;"><img src="../../../storage/uploads/EmployeePicture/dummymale.jpg" alt="-" width="140px" height="110px"></div>';
                                }
                                if(row.Gender=="Female"){
                                    return '<div style="text-align:left;margin-left:-10%;width:111px;height:111px;"><img src="../../../storage/uploads/EmployeePicture/dummyfemale.jpg" alt="-" width="140px" height="110px"></div>';
                                }   
                            }
                            if(data!=null){
                                return '<div style="text-align:left;margin-left:-10%;width:111px;height:111px;"><img src="../../../storage/uploads/EmployeePicture/'+data+'" alt="-" width="140px" height="110px"></div>';
                            } 
                        },
                    },
                    {
                        data: 'EmployeeId',
                        name: 'EmployeeId',
                    },
                    {
                        data: 'DepartmentName',
                        name: 'DepartmentName',
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                    },
                    {
                        data: 'Gender',
                        name: 'Gender'
                    },
                    {
                        data: 'DOB',
                        name: 'DOB',
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone',
                    },
                    {
                        data: 'EmployeeStatus',
                        name: 'EmployeeStatus',
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                columnDefs:[{targets:[2],"width":"10%"}],
                "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    if (aData.EmployeeStatus == "Active") {
                        $(nRow).find('td:eq(8)').css({"color": "#1cc88a", "font-weight": "bold","text-shadow":"1px 1px 10px #1cc88a"});
                    } else if (aData.EmployeeStatus == "Inactive"||aData.EmployeeStatus == "Block") {
                        $(nRow).find('td:eq(8)').css({"color": "#e74a3b", "font-weight": "bold","text-shadow":"1px 1px 10px #e74a3b"});
                    }
                }
            });
        });

        $('.addempbutton').click(function(){
            $('#nationality').select2
            ({
                placeholder: "Select Nationality here",
            });
            $('#country-dd').select2({
                minimumResultsForSearch: -1
            });
            $('#city-dd').select2
            ({
                placeholder: "Select City here",
            });
            $('#subcity-dd').select2
            ({
                placeholder: "Select Subcity here",
            });
            $('#Woreda').select2
            ({
                placeholder: "Select Woreda here",
            });
            $('#Status').select2({
                minimumResultsForSearch: -1
            });
            $('#type').select2
            ({
                placeholder: "Select Type here",
            });
            $('#skill').select2
            ({
                placeholder: "Select Trainers Skill Set here",
            });
            $('#EnrollDevice').select2
            ({
                placeholder: "Select Enroll device here",
            });
            $("#Pname").prop("readonly",false);
            $('#operationtypes').val("1");
            $("#membertitle").html("Add Employee");
            $('#savebutton').text('Save');
            $('#savebutton').prop("disabled",false);
            $('#tinCounter').html('0/13');
            $("#identificationidlinkbtn").hide();
            $("#previewImg").hide();
            $("#removepicbtn").hide();
            $("#removeidnbtn").hide();
            $("#Pictureupdate").val("");
            $("#captureimages").val("");
            $("#Identificationupdate").val("");
            $("#memberId").val("");
            $("#personuuid").val("");
            $('#faceidencoded').val("");
            $("#syncbutton").hide();
            $("#syncbuttonfp").hide();
            $(".biodata").hide();
            $(".skillcls").hide();
            $("#inlineForm").modal('show');
        });

        function employeeInfo(recordId){
            //var recordId = $(this).data('id');
            var servicenames="";
            $.get("/showemp"+'/'+recordId , function(data) {
                $.each(data.memlist, function(key, value) {
                    $('#memberInfoId').val(value.id);
                    $('#NameLbl').html(value.Name);
                    $('#typenamelbl').html(value.DepartmentName);
                    $('#GenderLbl').html(value.Gender);
                    $('#DOBLbl').html(value.DOB);
                    $('#NationalityLbl').html(value.Nationality);
                    $('#CountryLbl').html(value.Country);
                    $('#CityLbl').html(value.city_name);
                    $('#SubCityLbl').html(value.subcity_name);
                    $('#WoredaLbl').html(value.Woreda);
                    $('#LocationLbl').html(value.Location);
                    $('#PhoneLbl').html(value.MobileNo+"  ,   "+value.PhoneNo);
                    $('#EmailLbl').html(value.Email);
                    $('#healthstatuslbl').html(value.HealthStatus);
                    $('#memolbl').html(value.Memo);
                    $('#memberidslbl').html(value.EmployeeId);
                    $('#ResidanceIdLbl').html(value.ResidanceId);
                    $('#PassportNoLbl').html(value.PassportNo);
                    $('#IdentificationIdLbl').text(value.IdentificationId);
                    $('#filenameInfo').val(value.IdentificationId);
                    $('#emergencyconnamelbl').html(value.EmergencyName);
                    $('#emergencyphonelbl').html(value.EmergencyMobile);
                    $('#emergencyloclbl').html(value.EmergencyLocation);
                    $("#createdbylbl").html(value.CreatedBy);
                    $("#createddatelbl").html(value.CreatedTime);
                    $("#lasteditedbylbl").html(value.LastEditedBy);
                    $("#lastediteddatelbl").html(value.LastEditedDate);
                    $("#enrolldeviceinfo").html(value.DeviceName);

                    var leftthumb=value.LeftThumb;
                    var leftind=value.LeftIndex;
                    var leftmiddle=value.LeftMiddle;
                    var leftring=value.LeftRing;
                    var leftpicky=value.LeftPinky;
                    var rightthumb=value.RightThumb;
                    var rightind=value.RightIndex;
                    var rightmiddle=value.RightMiddle;
                    var rightring=value.RightRing;
                    var rightpicky=value.RightPinky;

                    var st=value.Status;
                    if(st=="Active"){
                        $("#StatusLbl").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                    }
                    if(st=="Inactive"){
                        $("#StatusLbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }
                    if(st=="Block"){
                        $("#StatusLbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }
                    if(value.Picture===null){
                        $('#previewInfoImg').attr("src","");
                        $('#previewInfoImg').attr("alt","Face ID not found");
                        $("#previewInfoImg").show(); 
                    }
                    else if(value.Picture!=null){
                        $('#previewInfoImg').attr("src","../../../storage/uploads/EmployeePicture/"+value.Picture);
                        $('#previewInfoImg').show();
                    }
                    
                    if(leftthumb===null||leftthumb===''||leftthumb==='NULL'){
                        $('#leftthumblblinfo').html('Non-Registered');
                        $("#leftthumblblinfo").css("color","#5e5873");
                    }
                    if(leftthumb!==null && leftthumb!=='' && leftthumb!=='NULL'){
                        $('#leftthumblblinfo').html('Registered');
                        $("#leftthumblblinfo").css("color","#1CC88A");
                    }

                    if(leftind===null||leftind===''||leftind==='NULL'){
                        $('#leftindexlblinfo').html('Non-Registered');
                        $("#leftindexlblinfo").css("color","#5e5873");
                    }
                    if(leftind!==null && leftind!=='' && leftind!=='NULL'){
                        $('#leftindexlblinfo').html('Registered');
                        $("#leftindexlblinfo").css("color","#1CC88A");
                    }

                    if(leftmiddle===null||leftmiddle===''||leftmiddle==='NULL'){
                        $('#leftmiddlelblinfo').html('Non-Registered');
                        $("#leftmiddlelblinfo").css("color","#5e5873");
                    }
                    if(leftmiddle!==null && leftmiddle!=='' && leftmiddle!=='NULL'){
                        $('#leftmiddlelblinfo').html('Registered');
                        $("#leftmiddlelblinfo").css("color","#1CC88A");
                    }

                    if(leftring===null||leftring===''||leftring==='NULL'){
                        $('#leftringlblinfo').html('Non-Registered');
                        $("#leftringlblinfo").css("color","#5e5873");
                    }
                    if(leftring!==null && leftring!=='' && leftring!=='NULL'){
                        $('#leftringlblinfo').html('Registered');
                        $("#leftringlblinfo").css("color","#1CC88A");
                    }

                    if(leftpicky===null||leftpicky===''||leftpicky==='NULL'){
                        $('#leftpinkylblinfo').html('Non-Registered');
                        $("#leftpinkylblinfo").css("color","#5e5873");
                    }
                    if(leftpicky!==null && leftpicky!=='' && leftpicky!=='NULL'){
                        $('#leftpinkylblinfo').html('Registered');
                        $("#leftpinkylblinfo").css("color","#1CC88A");
                    }

                    if(rightthumb===null||rightthumb===''||rightthumb==='NULL'){
                        $('#rightthumblblinfo').html('Non-Registered');
                        $("#rightthumblblinfo").css("color","#5e5873");
                    }
                    if(rightthumb!==null && rightthumb!=='' && rightthumb!=='NULL'){
                        $('#rightthumblblinfo').html('Registered');
                        $("#rightthumblblinfo").css("color","#1CC88A");
                    }

                    if(rightind===null||rightind===''||rightind==='NULL'){
                        $('#rightindexlblinfo').html('Non-Registered');
                        $("#rightindexlblinfo").css("color","#5e5873");
                    }
                    if(rightind!==null && rightind!=='' && rightind!=='NULL'){
                        $('#rightindexlblinfo').html('Registered');
                        $("#rightindexlblinfo").css("color","#1CC88A");
                    }

                    if(rightmiddle===null||rightmiddle===''||rightmiddle==='NULL'){
                        $('#rightmiddlelblinfo').html('Non-Registered');
                        $("#rightmiddlelblinfo").css("color","#5e5873");
                    }
                    if(rightmiddle!==null && rightmiddle!=='' && rightmiddle!=='NULL'){
                        $('#rightmiddlelblinfo').html('Registered');
                        $("#rightmiddlelblinfo").css("color","#1CC88A");
                    }

                    if(rightring===null||rightring===''||rightring==='NULL'){
                        $('#rightringlblinfo').html('Non-Registered');
                        $("#rightringlblinfo").css("color","#5e5873");
                    }
                    if(rightring!==null && rightring!=='' && rightring!=='NULL'){
                        $('#rightringlblinfo').html('Registered');
                        $("#rightringlblinfo").css("color","#1CC88A");
                    }

                    if(rightpicky===null||rightpicky===''||rightpicky==='NULL'){
                        $('#rightpinkylblinfo').html('Non-Registered');
                        $("#rightpinkylblinfo").css("color","#5e5873");
                    }
                    if(rightpicky!==null && rightpicky!=='' && rightpicky!=='NULL'){
                        $('#rightpinkylblinfo').html('Registered');
                        $("#rightpinkylblinfo").css("color","#1CC88A");
                    }
                });

                $.each(data.employeedt, function(key, value) {
                    servicenames+=value.ServiceName+",  ";
                });
                $('#SkillsLblInfo').html(servicenames);
            });
            $("#memberInfoModal").modal('show'); 
        }

        function employeeEdit(recordId){
            var employeecnt=0;
            var picdatabin=null;
            $('.select2').select2();
            var servicearr=[];
            $("#operationtypes").val("2");
            $("#memberId").val(recordId);
            $.get("/showemp"+'/'+recordId , function(data) {
                employeecnt=data.employeecntcon;
                picdatabin=data.picdata;

                if(parseFloat(employeecnt)>0){
                    $("#Pname").prop("readonly",true);
                }
                else if(parseFloat(employeecnt)==0){
                    $("#Pname").prop("readonly",false);
                }
                $.each(data.memlist, function(key, value) {
                    $('#Pname').val(value.Name);
                    $('#TinNumber').val(value.TinNumber);
                    $('#type').select2('destroy');
                    $('#type').val(value.departments_id).trigger('change').select2();
                    $('#Country').select2('destroy');
                    $('#Country').val(value.Country).trigger('change').select2();
                    $('#nationality').select2('destroy');
                    $('#nationality').val(value.Nationality).trigger('change').select2();
                    $('#city-dd').select2('destroy');
                    $('#city-dd').val(value.cities_id).trigger('change').select2();
                    $('#subcity-dd').select2('destroy');
                    $('#subcity-dd').val(value.subcities_id).trigger('change').select2();
                    $('#Woreda').select2('destroy');
                    $('#Woreda').val(value.Woreda).trigger('change').select2();
                    $('#Location').val(value.Location);
                    $('#Mobile').val(value.Mobile);
                    $('#Phone').val(value.Phone);
                    $('#Email').val(value.Email);
                    $('#Residenceid').val(value.ResidanceId);
                    $('#PassportNO').val(value.PassportNo);
                    $('#Dob').val(value.DOB);
                    $('#HealthStatus').val(value.HealthStatus);
                    $('#Memo').val(value.Memo);
                    $('#Occupation').select2('destroy');
                    $('#Occupation').val(value.Occupation).trigger('change').select2();
                    $('#EnrollDevice').select2('destroy');
                    $('#EnrollDevice').val(value.devices_id).trigger('change').select2();
                    $('#Status').select2('destroy');
                    $('#Status').val(value.Status).trigger('change').select2({
                        minimumResultsForSearch: -1
                    });
                    $('#contactName').val(value.EmergencyName);
                    $('#contactMobileNumber').val(value.EmergencyMobile);
                    $('#contactLocation').val(value.EmergencyLocation);
                    $('#Identificationupdate').val(value.IdentificationId);
                    $('#Pictureupdate').val(value.Picture);
                    var leftthumb=value.LeftThumb;
                    var leftind=value.LeftIndex;
                    var leftmiddle=value.LeftMiddle;
                    var leftring=value.LeftRing;
                    var leftpicky=value.LeftPinky;
                    var rightthumb=value.RightThumb;
                    var rightind=value.RightIndex;
                    var rightmiddle=value.RightMiddle;
                    var rightring=value.RightRing;
                    var rightpicky=value.RightPinky;

                    var tin=value.TinNumber||"";
                    var len=tin.length;
                    $('#LeftThumbVal').val(leftthumb);
                    $('#LeftIndexVal').val(leftind);
                    $('#LeftMiddelVal').val(leftmiddle);
                    $('#LeftRingVal').val(leftring);
                    $('#LeftPickyVal').val(leftpicky);
                    $('#RightThumbVal').val(rightthumb);
                    $('#RightIndexVal').val(rightind);
                    $('#RightMiddleVal').val(rightmiddle);
                    $('#RightRingVal').val(rightring);
                    $('#RightPickyVal').val(rightpicky);
                    $('#tinCounter').html(len+'/13');
                    if (value.Gender == "Male") {
                        $("#customRadio1").prop("checked", true);
                        $("#customRadio2").prop("checked", false);
                    } 
                    else if (value.Gender == "Female") {
                        $("#customRadio1").prop("checked", false);
                        $("#customRadio2").prop("checked", true);
                    }
                    if(value.IdentificationId===null){
                        $("#identificationidlinkbtn").hide(); 
                        $("#removeidnbtn").hide();
                    }
                    else if(value.IdentificationId!=null){
                        $('#identificationidlinkbtn').text(value.IdentificationId);
                        $('#identificationidlinkbtn').show();
                        $("#removeidnbtn").show();
                    }

                    if(value.Picture===null){
                        $('#previewImg').attr("src","");
                        $('#previewImg').attr("alt","Face ID not found");
                        $("#previewImg").show(); 
                        $("#removepicbtn").hide();
                        $("#faceidencoded").val("");
                    }
                    if(value.Picture!==null){
                        $('#previewImg').attr("src","../../../storage/uploads/EmployeePicture/"+value.Picture);
                        $('#previewImg').show();
                        $("#removepicbtn").hide();
                        $("#faceidencoded").val(picdatabin);
                    }

                    if(leftthumb===null||leftthumb===''||leftthumb==='NULL'){
                        $('#leftthumblbl').html('Non-Registered');
                        $("#leftthumblbl").css("color","#5e5873");
                    }
                    if(leftthumb!==null && leftthumb!=='' && leftthumb!=='NULL'){
                        $('#leftthumblbl').html('Registered');
                        $("#leftthumblbl").css("color","#1CC88A");
                    }

                    if(leftind===null||leftind===''||leftind==='NULL'){
                        $('#leftindexlbl').html('Non-Registered');
                        $("#leftindexlbl").css("color","#5e5873");
                    }
                    if(leftind!==null && leftind!=='' && leftind!=='NULL'){
                        $('#leftindexlbl').html('Registered');
                        $("#leftindexlbl").css("color","#1CC88A");
                    }

                    if(leftmiddle===null||leftmiddle===''||leftmiddle==='NULL'){
                        $('#leftmiddlelbl').html('Non-Registered');
                        $("#leftmiddlelbl").css("color","#5e5873");
                    }
                    if(leftmiddle!==null && leftmiddle!=='' && leftmiddle!=='NULL'){
                        $('#leftmiddlelbl').html('Registered');
                        $("#leftmiddlelbl").css("color","#1CC88A");
                    }

                    if(leftring===null||leftring===''||leftring==='NULL'){
                        $('#leftringlbl').html('Non-Registered');
                        $("#leftringlbl").css("color","#5e5873");
                    }
                    if(leftring!==null && leftring!=='' && leftring!=='NULL'){
                        $('#leftringlbl').html('Registered');
                        $("#leftringlbl").css("color","#1CC88A");
                    }

                    if(leftpicky===null||leftpicky===''||leftpicky==='NULL'){
                        $('#leftpinkylbl').html('Non-Registered');
                        $("#leftpinkylbl").css("color","#5e5873");
                    }
                    if(leftpicky!==null && leftpicky!=='' && leftpicky!=='NULL'){
                        $('#leftpinkylbl').html('Registered');
                        $("#leftpinkylbl").css("color","#1CC88A");
                    }

                    if(rightthumb===null||rightthumb===''||rightthumb==='NULL'){
                        $('#rightthumblbl').html('Non-Registered');
                        $("#rightthumblbl").css("color","#5e5873");
                    }
                    if(rightthumb!==null && rightthumb!=='' && rightthumb!=='NULL'){
                        $('#rightthumblbl').html('Registered');
                        $("#rightthumblbl").css("color","#1CC88A");
                    }

                    if(rightind===null||rightind===''||rightind==='NULL'){
                        $('#rightindexlbl').html('Non-Registered');
                        $("#rightindexlbl").css("color","#5e5873");
                    }
                    if(rightind!==null && rightind!=='' && rightind!=='NULL'){
                        $('#rightindexlbl').html('Registered');
                        $("#rightindexlbl").css("color","#1CC88A");
                    }

                    if(rightmiddle===null||rightmiddle===''||rightmiddle==='NULL'){
                        $('#rightmiddlelbl').html('Non-Registered');
                        $("#rightmiddlelbl").css("color","#5e5873");
                    }
                    if(rightmiddle!==null && rightmiddle!=='' && rightmiddle!=='NULL'){
                        $('#rightmiddlelbl').html('Registered');
                        $("#rightmiddlelbl").css("color","#1CC88A");
                    }

                    if(rightring===null||rightring===''||rightring==='NULL'){
                        $('#rightringlbl').html('Non-Registered');
                        $("#rightringlbl").css("color","#5e5873");
                    }
                    if(rightring!==null && rightring!=='' && rightring!=='NULL'){
                        $('#rightringlbl').html('Registered');
                        $("#rightringlbl").css("color","#1CC88A");
                    }

                    if(rightpicky===null||rightpicky===''||rightpicky==='NULL'){
                        $('#rightpinkylbl').html('Non-Registered');
                        $("#rightpinkylbl").css("color","#5e5873");
                    }
                    if(rightpicky!==null && rightpicky!=='' && rightpicky!=='NULL'){
                        $('#rightpinkylbl').html('Registered');
                        $("#rightpinkylbl").css("color","#1CC88A");
                    }

                    // if(value.Picture===null){
                    //     $("#previewImg").hide(); 
                    //     $("#removepicbtn").hide();
                    // }
                    // else if(value.Picture!=null){
                    //     $('#previewImg').attr("src","../../../storage/uploads/EmployeePicture/"+value.Picture);
                    //     $('#previewImg').show();
                    //     $("#removepicbtn").show();
                    // }
                });

                $.each(data.employeedt, function(key, value) {
                    servicearr.push(value.services_id);
                });
                $('#skill').val(servicearr).trigger('change').select2();

            });
            $('#syncbutton').text('Get FaceID');
            $('#syncbutton').prop("disabled", false);         
            $('#syncbuttonfp').text('Get FingerPrint');
            $('#syncbuttonfp').prop("disabled", false);
            $("#imageprv").show();
            $("#membertitle").html("Edit Employee Information");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#syncbutton").show();
            $("#syncbuttonfp").show();
            $(".biodata").show();
            $("#inlineForm").modal('show'); 
        }

        function employeeDelete(recordId){
            var employeecnt=0;
            $("#memberDelId").val(recordId);
            $.get("/showemp"+'/'+recordId , function(data) {
                employeecnt=data.employeecnt;
                if(parseFloat(employeecnt)>=1){
                    toastrMessage('error',"Unable to delete employee, transaction is saved with this employee","Error");
                }
                else if(parseFloat(employeecnt)==0){
                    $('#deletememberbtn').text('Delete');
                    $('#deletememberbtn').prop("disabled", false);
                    $("#deletemembershipmodal").modal('show');
                }
            }); 
        }

        $('#Register').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            var optype = $("#operationtypes").val();
            $.ajax({
                url: "{{ url('saveemployee') }}",
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
                        if(parseFloat(optype)==1){
                            $('#savebutton').text('Save');
                            $('#savebutton').prop("disabled",false);
                        }
                        else if(parseFloat(optype)==2){
                            $('#savebutton').text('Update');
                            $('#savebutton').prop("disabled",false);
                        }
                        if (data.errors.ResidenceId) {
                            $('#Residenceid-error').html(data.errors.ResidenceId[0]);
                        }
                        if (data.errors.Occupation) {
                            $('#Occupation-error').html(data.errors.Occupation[0]);
                        }
                        if (data.errors.nationality) {
                            $('#nationality-error').html(data.errors.nationality[0]);
                        }
                        if(data.errors.gender){
                            var text=data.errors.gender[0];
                            text = text.replace("gender field", "gender option");
                            $('#gender-error').html(text);
                        }
                        if (data.errors.License) {
                            $('#License-error').html(data.errors.License[0]);
                        }
                        if (data.errors.Identification) {
                            $('#Identification-error').html(data.errors.Identification[0]);
                        }
                        if (data.errors.Status) {
                            $('#Status-error').html(data.errors.Status[0]);
                        }
                        if (data.errors.Country) {
                            $('#country-error').html(data.errors.Country[0]);
                        }
                        if (data.errors.city) {
                            $('#city-error').html(data.errors.city[0]);
                        }
                        if (data.errors.subcity) {
                            $('#subcity-error').html(data.errors.subcity[0]);
                        }
                        if (data.errors.Woreda) {
                            $('#Woreda-error').html(data.errors.Woreda[0]);
                        }
                        if (data.errors.Mobile) {
                            $('#Mobilenumber-error').html(data.errors.Mobile[0]);
                        }
                        if(data.errors.Phone){
                            $('#Phonenumber-error').html(data.errors.Phone[0]);
                        }
                        if (data.errors.Email) {
                            $('#Email-error').html(data.errors.Email[0]);
                        }
                        if (data.errors.HealthStatus) {
                            $('#healthst-error').html(data.errors.HealthStatus[0]);
                        }
                        if (data.errors.type) {
                            $('#type-error').html(data.errors.type[0]);
                        }
                        if (data.errors.skill) {
                            $('#skill-error').html("The skill field is required when type is trainer");
                        }
                        if (data.errors.Name) {
                            var text=data.errors.Name[0];
                            text = text.replace("name", "full name");
                            $('#Pname-error').html(text);
                        }
                        if (data.errors.Dob) {
                            var text=data.errors.Dob[0];
                            text = text.replace("dob", "date of birth");
                            $('#dob-error').html(text);
                        }
                        if (data.errors.TinNumber) {
                            var text=data.errors.TinNumber[0];
                            text = text.replace("The tin number format is invalid", "The tin number must be 10 or 13 digit");
                            $('#TinNumber-error').html("</br>"+text);
                        }
                        toastrMessage('error',"Please check your inputs","Error");
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
                        toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                    }
                    else if (data.success) {
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

        $('#syncbutton').click(function() {
            var optype = $("#operationtypes").val();
            var enrolldev = $("#EnrollDevice").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            if(parseInt(enrolldev)==1){
                $('#enroll-error').html('The enrollment device is required!');
                toastrMessage('error',"Plese select enrollment device","Error");
            }
            else if(parseInt(enrolldev)>1){
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url:'/getEmpFaceid',
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
                        $('#syncbutton').text('Getting...');
                        $('#syncbutton').prop("disabled", true);
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
                                $('#enroll-error').html(data.errors.DeviceId[0]);
                            }
                            $('#syncbutton').text('Get FaceID');
                            $('#syncbutton').prop("disabled", false);
                            toastrMessage('error',"Please fill all required fields","Error");
                        }
                        else if (data.dberrors) {
                            $('#syncbutton').text('Get FaceID');
                            $('#syncbutton').prop("disabled", false);
                            toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                        }
                        else if(data.success) {
                            var pic=data.success.pic;
                            var picfl=data.picflag;
                            $('#previewImg').show();
                            $('#imageprv').show();

                            if(parseInt(picfl)==0){
                                $('#previewImg').attr("src","");
                                $('#previewImg').attr("alt","Face ID not found");
                                toastrMessage('warning',"Face ID not found","Warning");
                            }
                            if(parseInt(picfl)==1){
                                $('#faceidencoded').val(pic);
                                $('#previewImg').attr("src",pic);
                            }
                            
                            $('#syncbutton').text('Get FaceID');
                            $('#syncbutton').prop("disabled", false);
                        }
                    },
                });
            }
        });

        $('#syncbuttonfp').click(function() {
            var optype = $("#operationtypes").val();
            var enrolldev = $("#EnrollDevice").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            if(parseInt(enrolldev)==1){
                $('#enroll-error').html('The enrollment device is required!');
                toastrMessage('error',"Plese select enrollment device","Error");
            }
            else if(parseInt(enrolldev)>1){
                var registerForm = $("#Register");
                var formData = registerForm.serialize();
                $.ajax({
                    url:'/getEmpFingerprint',
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
                        $('#syncbuttonfp').text('Getting...');
                        $('#syncbuttonfp').prop("disabled", true);
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
                                $('#enroll-error').html(data.errors.DeviceId[0]);
                            }
                            $('#syncbuttonfp').text('Get FingerPrint');
                            $('#syncbuttonfp').prop("disabled", false);
                            toastrMessage('error',"Please fill all required fields","Error");
                        }
                        else if (data.dberrors) {
                            $('#syncbuttonfp').text('Get FingerPrint');
                            $('#syncbuttonfp').prop("disabled", false);
                            toastrMessage('error',"Connection Failed </br>Please try again!</br>"+data.dberrors,"Error");
                        }
                        else if(data.success) {
                            var leftthumb=data.success.info.LeftThumb;
                            var leftind=data.success.info.LeftIndex;
                            var leftmiddle=data.success.info.LeftMiddle;
                            var leftring=data.success.info.LeftRing;
                            var leftpicky=data.success.info.LeftPinky;
                            var rightthumb=data.success.info.RightThumb;
                            var rightind=data.success.info.RightIndex;
                            var rightmiddle=data.success.info.RightMiddle;
                            var rightring=data.success.info.RightRing;
                            var rightpicky=data.success.info.RightPinky;

                            var leftthumbval=0;
                            var leftindval=0;
                            var leftmiddleval=0;
                            var leftringval=0;
                            var leftpickyval=0;
                            var rightthumbval=0;
                            var rightindval=0;
                            var rightmiddleval=0;
                            var rightringval=0;
                            var rightpickyval=0;
                            var totalfingerprintcnt=0;
                            $('#LeftThumbVal').val(leftthumb);
                            $('#LeftIndexVal').val(leftind);
                            $('#LeftMiddelVal').val(leftmiddle);
                            $('#LeftRingVal').val(leftring);
                            $('#LeftPickyVal').val(leftpicky);
                            $('#RightThumbVal').val(rightthumb);
                            $('#RightIndexVal').val(rightind);
                            $('#RightMiddleVal').val(rightmiddle);
                            $('#RightRingVal').val(rightring);
                            $('#RightPickyVal').val(rightpicky);


                            if(leftthumb===null||leftthumb===''||leftthumb==='NULL'||leftthumb===undefined){
                                $('#leftthumblbl').html('Non-Registered');
                                $("#leftthumblbl").css("color","#5e5873");
                                leftthumbval=0;
                            }
                            if(leftthumb!==null && leftthumb!=='' && leftthumb!=='NULL' && leftthumb!==undefined){
                                $('#leftthumblbl').html('Registered');
                                $("#leftthumblbl").css("color","#1CC88A");
                                leftthumbval=1;
                            }

                            if(leftind===null||leftind===''||leftind==='NULL'||leftind===undefined){
                                $('#leftindexlbl').html('Non-Registered');
                                $("#leftindexlbl").css("color","#5e5873");
                                leftindval=0;
                            }
                            if(leftind!==null && leftind!=='' && leftind!=='NULL' && leftind!==undefined){
                                $('#leftindexlbl').html('Registered');
                                $("#leftindexlbl").css("color","#1CC88A");
                                leftindval=1;
                            }

                            if(leftmiddle===null||leftmiddle===''||leftmiddle==='NULL'||leftmiddle===undefined){
                                $('#leftmiddlelbl').html('Non-Registered');
                                $("#leftmiddlelbl").css("color","#5e5873");
                                leftmiddleval=0;
                            }
                            if(leftmiddle!==null && leftmiddle!=='' && leftmiddle!=='NULL' && leftmiddle!==undefined){
                                $('#leftmiddlelbl').html('Registered');
                                $("#leftmiddlelbl").css("color","#1CC88A");
                                leftmiddleval=1;
                            }

                            if(leftring===null||leftring===''||leftring==='NULL'||leftring===undefined){
                                $('#leftringlbl').html('Non-Registered');
                                $("#leftringlbl").css("color","#5e5873");
                                leftringval=0;
                            }
                            if(leftring!==null && leftring!=='' && leftring!=='NULL' && leftring!==undefined){
                                $('#leftringlbl').html('Registered');
                                $("#leftringlbl").css("color","#1CC88A");
                                leftringval=1;
                            }

                            if(leftpicky===null||leftpicky===''||leftpicky==='NULL'||leftpicky===undefined){
                                $('#leftpinkylbl').html('Non-Registered');
                                $("#leftpinkylbl").css("color","#5e5873");
                                leftpickyval=0;
                            }
                            if(leftpicky!==null && leftpicky!=='' && leftpicky!=='NULL' && leftpicky!==undefined){
                                $('#leftpinkylbl').html('Registered');
                                $("#leftpinkylbl").css("color","#1CC88A");
                                leftpickyval=1;
                            }

                            if(rightthumb===null||rightthumb===''||rightthumb==='NULL'||rightthumb===undefined){
                                $('#rightthumblbl').html('Non-Registered');
                                $("#rightthumblbl").css("color","#5e5873");
                                rightthumbval=0;
                            }
                            if(rightthumb!==null && rightthumb!=='' && rightthumb!=='NULL' && rightthumb!==undefined){
                                $('#rightthumblbl').html('Registered');
                                $("#rightthumblbl").css("color","#1CC88A");
                                rightthumbval=1;
                            }

                            if(rightind===null||rightind===''||rightind==='NULL'||rightind===undefined){
                                $('#rightindexlbl').html('Non-Registered');
                                $("#rightindexlbl").css("color","#5e5873");
                                rightindval=0;
                            }
                            if(rightind!==null && rightind!=='' && rightind!=='NULL' && rightind!==undefined){
                                $('#rightindexlbl').html('Registered');
                                $("#rightindexlbl").css("color","#1CC88A");
                                rightindval=1;
                            }

                            if(rightmiddle===null||rightmiddle===''||rightmiddle==='NULL'||rightmiddle===undefined){
                                $('#rightmiddlelbl').html('Non-Registered');
                                $("#rightmiddlelbl").css("color","#5e5873");
                                rightmiddleval=0;
                            }
                            if(rightmiddle!==null && rightmiddle!=='' && rightmiddle!=='NULL' && rightmiddle!==undefined){
                                $('#rightmiddlelbl').html('Registered');
                                $("#rightmiddlelbl").css("color","#1CC88A");
                                rightmiddleval=1;
                            }

                            if(rightring===null||rightring===''||rightring==='NULL'||rightring===undefined){
                                $('#rightringlbl').html('Non-Registered');
                                $("#rightringlbl").css("color","#5e5873");
                                rightringval=0;
                            }
                            if(rightring!==null && rightring!=='' && rightring!=='NULL' && rightring!==undefined){
                                $('#rightringlbl').html('Registered');
                                $("#rightringlbl").css("color","#1CC88A");
                                rightringval=1;
                            }

                            if(rightpicky===null||rightpicky===''||rightpicky==='NULL'||rightpicky===undefined){
                                $('#rightpinkylbl').html('Non-Registered');
                                $("#rightpinkylbl").css("color","#5e5873");
                                rightpickyval=0;
                            }
                            if(rightpicky!==null && rightpicky!=='' && rightpicky!=='NULL' && rightpicky!==undefined){
                                $('#rightpinkylbl').html('Registered');
                                $("#rightpinkylbl").css("color","#1CC88A");
                                rightpickyval=1;
                            }
                            
                            totalfingerprintcnt=parseInt(leftthumbval)+parseInt(leftindval)+parseInt(leftmiddleval)+parseInt(leftringval)+parseInt(leftpickyval)+parseInt(rightthumbval)+parseInt(rightindval)+parseInt(rightmiddleval)+parseInt(rightringval)+parseInt(rightpickyval);
                            
                            toastrMessage('success',"<b>"+totalfingerprintcnt+ "</b>  Fingerprint found","Success");
                            $('#syncbuttonfp').text('Get FingerPrint');
                            $('#syncbuttonfp').prop("disabled", false);
                        }
                    },
                });
            }
        });

        $('#deletememberbtn').click(function() {
            var delform = $("#deletememberform");
            var formData = delform.serialize();
            $.ajax({
                url: '/deleteemp',
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
                    $('#deletememberbtn').text('Deleting...');
                    $('#deletememberbtn').prop("disabled", true);
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
                        $('#deletememberbtn').text('Delete');
                        $('#deletememberbtn').prop("disabled", false);
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
                        toastrMessage('success',"Successful","Success");
                        $("#deletemembershipmodal").modal('hide');
                    }
                }
            });
        });

        function clearPnameError() {
            $('#Pname-error').html('');
        }

        function clearTinnumberError() {
            $('#TinNumber-error').html('');
        }

        function TinNumberCounter(){
            var tin=$('#TinNumber').val();
            var len=tin.length;
            $('#tinCounter').html(len+'/13');
        }

        function clearDobError() {
            var dob=$('#Dob').val();
            var cdate=$('#currentdatehidden').val();
            var yeardiff=calculateYears(dob,cdate);
            if(parseFloat(yeardiff)<15){
                $('#Dob').val("");
                toastrMessage('error',"Age of employee should be greather than or equal to 15","Error");
            }
            $('#dob-error').html('');
        }

        function cleargendererror(){
            $('#gender-error').html('');
        }

        function clearCountryError() {
            $('#country-error').html('');
        }

        function clearNationalityError() {
            $('#nationality-error').html('');
        }

        function calculateYears(date1, date2){
            date1 = new Date(date1);
            date2 = new Date(date2);
            var period = date2.getFullYear() - date1.getFullYear();
            if (date2.getMonth() < date1.getMonth() - 1){
                period--;
            }
            if (date1.getMonth() - 1 == date2.getMonth() && date2.getDate() < date1.getDate()){
                period--;
            };
            return period;
        }

        $('#city-dd').on('change', function() {
            var cityval= $('#city-dd').val();
            $('#subcity-dd').empty();
            var subdef = '<option selected value=""></option>';
            var subopt = $("#subcitycbx > option").clone();
            $('#subcity-dd').append(subopt);
            $("#subcity-dd option[label!='"+cityval+"']").remove();  
            $('#subcity-dd').append(subdef);
            $('#subcity-dd').select2
            ({
                placeholder: "Select Subcity here",
            });
            $('#city-error').html('');
        });

        function clearSubcityError() {
            $('#subcity-error').html('');
        }

        function clearWoredaError() {
            $('#Woreda-error').html('');
        }

        function clearMobileError() {
            $('#Mobilenumber-error').html('');
            $('#Phonenumber-error').html('');
        }

        function clearpPhoneError(){
            $('#Phonenumber-error').html('');
            $('#Mobilenumber-error').html('');
            $('#Phonenumber-error').html('');
        }

        function clearEmailError() {
            $('#Email-error').html('');
        }

        function clearOccupationError() {
            $('#Occupation-error').html('');
        }

        function clearIdentificationError() {
            $('#Identification-error').html('');
            $("#removeidnbtn").show();
        }

        function healthst() {
            $('#healthst-error').html('');
        }

        function clearPassportnoError() {
            $('#Residenceid-error').html('');
            $('#Residenceidtenantrep-error').html('');
        }

        function clearResidenceidError() {
            $('#Residenceid-error').html('');
            $('#Residenceidtenantrep-error').html('');
        }

        function enrolldevFn() {
            $('#enroll-error').html('');
        }

        function clearTypeError() {
            var typeid = $('#type').val();
            if(parseFloat(typeid)==3){
                $(".skillcls").show();
            }
            else{
                $(".skillcls").hide();
            }
            $('#skill').val(null).trigger('change');
            $('#type-error').html('');
        }

        function clearSkillerror() {
            $('#skill-error').html('');
        }

        $(document).on('click', '.identificationidcls', function() {
            var recordId = $('#memberId').val();
            var filenames = $('#Identificationupdate').val();
            $.get("/downloadidnemp" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/EmployeeIdentification/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        });

        function identificationidval() {
            var recordId = $('#memberInfoId').val();
            var filenames = $('#filenameInfo').val();
            $.get("/downloadidnemp" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/EmployeeIdentification/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        }

        $(document).on('click', '.removebtncls', function() {
            $("#removepicbtn").hide();
            $("#previewImg").hide();
            $('#Picture').val('');
            $("#Pictureupdate").val("");
            $("#captureimages").val("");
        });

        $(document).on('click', '.removeidnbtnclas', function() {
            $("#removeidnbtn").hide();
            $("#identificationidlinkbtn").hide();
            $('#Identification').val('');
            $("#Identificationupdate").val("");
        });

        function openCaptureModal() {
            Webcam.set({
                width: 460,
                height: 350,
                image_format: 'jpeg',
                jpeg_quality: 99
            });
            Webcam.attach('#my_camera');
            $("#capturemodal").modal('show');
        }

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                $("#captureimages").val(data_uri);
                $('#Picture').val('');
                $("#previewImg").attr("src",data_uri);
                $("#previewImg").show();
                $("#removepicbtn").show();
            });
        }

        function clearPictureError() {
            var file = $("input[type=file]").get(0).files[0];
            
            if (file) {
                var reader = new FileReader();
                reader.onload = function() {
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
                $('#previewImg').show();
                $("#removepicbtn").show();
            }
            $("#captureimages").val("");
            $('#picture-error').html('');
        }

        function closeCaptureModal() {
            Webcam.reset();
        }

        function adjEmployeeName(ele){
            $("#Pname").prop("readonly", false);
        }
        
        function closeRegisterModal() {
            $("#Occupation").val(null).trigger('change');
            $('#subcity-dd').val(null).trigger('change');
            $("#city-dd").val(null).trigger('change');
            $('#Woreda').val(null).trigger('change');
            $('#nationality').val(null).trigger('change');
            $('#type').val(null).trigger('change');
            $('#skill').val(null).trigger('change');
            $('#Register').trigger('reset');
            $("#subcity-dd").empty();
            $("#Pictureupdate").val("");
            $("#captureimages").val("");
            $("#Identificationupdate").val("");
            $("#memberId").val("");
            $("#memberId").val("");
            $("#personuuid").val("");
            $('#Email').html('');
            $('#faceidencoded').val('');
            $('#subcity-error').html('');
            $('#gender-error').html('');
            $('#Residenceid-error').html('');
            $('#TinNumber-error').html('');
            $('#Occupation-error').html('');
            $('#Mobilenumber-error').html('');
            $('#Woreda-error').html('');
            $('#city-error').html('');
            $('#subcity-error').html('');
            $('#country-error').html('');
            $('#Identification-error').html('');
            $('#Phonenumber-error').html('');
            $('#name-error').html('');
            $('#Pname-error').html('');
            $('#dob-error').html('');
            $('#Addresstenantrep-error').html('');
            $('#houseNotenantrep-error').html('');
            $('#referenceNumber-error').html('');
            $('#Woredatenantrep-error').html('');
            $('#phonetenantrep-error').html('');
            $('#type-error').html('');
            $('#skill-error').html('');
            $('#VatRegistrationNumber-error').html('');
            $('#tinCounter').html('0/13');
            $("#identificationidlinkbtn").hide();
            $("#previewImg").hide();
            $("#syncbutton").hide();
            $("#syncbuttonfp").hide();
            $(".biodata").hide();
            $("#removepicbtn").hide();
            $('#enroll-error').html('');
            $(".skillcls").hide();
            var subdef = '<option selected value=13>-</option>';
            $('#subcity-dd').append(subdef);
            $('#LeftThumbVal').val("");
            $('#LeftIndexVal').val("");
            $('#LeftMiddelVal').val("");
            $('#LeftRingVal').val("");
            $('#LeftPickyVal').val("");
            $('#RightThumbVal').val("");
            $('#RightIndexVal').val("");
            $('#RightMiddleVal').val("");
            $('#RightRingVal').val("");
            $('#RightPickyVal').val("");
            $('#faceidencoded').val("");
            var oTable = $('#laravel-datatable-crud').dataTable();
            oTable.fnDraw(false);
        }
    </script>
@endsection