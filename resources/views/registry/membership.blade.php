@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Client-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Clients</h3>
                            <div class="row" style="position: absolute;left: 270px;top: 80px;width:50%;z-index: 10;display:none" id="filter_div"> 
                                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4">
                                    <select class="selectpicker form-control dropdownclass" id="LoyaltyStatusFilter" name="LoyaltyStatusFilter" title="Select loyalty status here..." data-style="btn btn-outline-secondary waves-effect" data-live-search="true" multiple="multiple" data-actions-box="true">
                                        @foreach ($loyaltystatusfilter as $loyaltystatusfilter)
                                            <option selected value="{{$loyaltystatusfilter->LoyalityStatus}}">{{$loyaltystatusfilter->LoyalityStatus}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-datatable">
                            <div style="width:99%; margin-left:0.5%;" style="display: none;" id="mem_tbl">
                                <table id="laravel-datatable-crud" class="display table-bordered table-striped table-hover dt-responsive defaultdatatable mb-0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="display: none;"></th>
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 5%;">Face ID</th>
                                            <th style="width: 11%;">Client ID</th>
                                            <th style="width: 14%;">Full Name</th>
                                            <th style="width: 11%;">Gender</th>
                                            <th style="width: 11%;">DOB</th>
                                            <th style="width: 13%;">Phone</th>
                                            <th style="width: 11%;">Loyalty Status</th>
                                            <th style="width: 11%;">Client Status</th>
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
                                                <div class="col-xl-3 col-md-6 col-sm-12">
                                                    <label strong style="font-size: 14px;">Client's Full Name <b style="color:red;">*</b></label>
                                                    <input type="text" name="Name" id="Pname" class="form-control" placeholder="Enter Full Name here" onkeyup="clearPnameError()" @can('Edit-Verified-Client') ondblclick="adjClientName(this);" @endcan/>
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
                                                    <label style="font-size: 14px;" for="fp-default">DOB <i style="font-size: 10px;">(Date of Birth)</i></label>
                                                    <input type="text" name="Dob" id="Dob" class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" onchange="clearDobError()"  />
                                                    <span class="text-danger">
                                                        <strong id="dob-error"></strong>
                                                    </span>
                                                </div>
                                                <div class="col-xl-2 col-md-6 col-sm-12">
                                                    <label style="font-size: 14px;" class="form-label" for="TinNumbers">TIN</label>
                                                    <input type="text" name="TinNumber" id="TinNumber" class="form-control" minlength="10" maxlength="13" placeholder="Enter TIN here" onkeypress="return ValidateNum(event);" onkeydown="clearTinnumberError()" onkeyup="TinNumberCounter()"/>
                                                    <span><label strong style="font-size: 14px;color" id="tinCounter">0/13</label></span>
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
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label">City</label>
                                            <select name="city" id="city-dd" class="select2 form-control">
                                                <option selected value=16836>-</option>
                                                @foreach ($city as $data)
                                                <option value="{{$data->id}}">{{$data->city_name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger">
                                                <strong id="city-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label">Subcity</label>
                                            <select class="select2 form-control" name="subcity" id="subcity-dd" onchange="clearSubcityError()">
                                                <option selected value=13>-</option>
                                            </select>
                                            <span class="text-danger">
                                                <strong id="subcity-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-2 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label">Woreda</label>
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
                                        <div class="col-xl-5 col-md-6 col-sm-12 mt-1">
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
                                        <div class="col-xl-4 col-md-6 col-sm-12 mt-1">
                                            <label style="font-size: 14px;" class="form-label">Email</label>
                                            <input type="text" id="Email" name="Email" class="form-control" placeholder="Enter Email Address here" onkeydown="clearEmailError()" onkeyup="ValidateEmail(this);"/>
                                            <span class="text-danger">
                                                <strong id="Email-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mt-1">
                                            <label style="font-size: 14px;" class="form-label" for="Occupation">Occupation <b style="color:red;">*</b></label>
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
                                        <div class="col-xl-4 col-md-6 col-sm-12 mt-1">
                                            <label strong style="font-size: 14px;">Memo</label>
                                            <div>
                                                <textarea type="text" placeholder="Write Memo here..." class="form-control" name="Memo" id="Memo"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="memo-error"></strong>
                                            </span>
                                        </div>
                                        
                                        <div class="col-xl-3 col-md-6 col-sm-12 mt-1">
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
                                    
                                    <div class="divider mt-1">
                                        <div class="divider-text">Emergency Contact</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label strong style="font-size: 14px;">Medical Information</label>
                                            <div>
                                                <textarea type="text" placeholder="Write Medical information here..." class="form-control" name="HealthStatus" id="HealthStatus" onkeyup="healthst()"></textarea>
                                            </div>
                                            <span class="text-danger">
                                                <strong id="healthst-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="contactName" title="Emergency Contact Name">Contact Name</label>
                                            <input type="text" id="contactName" name="contactName" class="form-control" placeholder="Enter Emergency Contact Person here"/>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="contactMobileNumber" title="Emergency Contact Phone Number">Contact Phone No.</label>
                                            <input type="number" id="contactMobileNumber" name="contactMobileNumber" onkeypress="return ValidateNum(event);" class="form-control" placeholder="Enter Emergency Contact Phone Number here"/>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="contactLocation" title="Emergency Contact Location">Contact Location</label>
                                            <input type="text" id="contactLocation" name="contactLocation" class="form-control" placeholder="Enter Emergency Contact Location here" />
                                        </div>
                                    </div>
                                    <div class="divider">
                                        <div class="divider-text">Document Uploads</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-sm-12">
                                            <label style="font-size: 14px;" class="form-label" for="Identification">Identification ID</label>
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="file" name="Identification" id="Identification" class="form-control" onchange="clearIdentificationError()">
                                                    </td>
                                                    <td>
                                                        <button type="button" id="removeidnbtn" name="removeidnbtn" class="btn btn-flat-danger waves-effect btn-sm removeidnbtnclas"><i class="fa fa-times" aria-hidden="true"></i></button>
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
                                <div class="col-xl-3">
                                    {{-- <div class="divider">
                                        <div class="divider-text">Document Upload</div>
                                    </div>
                                    <div class="row">
                                        
                                    </div> --}}
                                    <div class="divider">
                                        <div class="divider-text">Biometric Data</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12" style="display:none;">
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
                                                    <button type="button" id="removepicbtn" name="removepicbtn" class="btn btn-flat-danger waves-effect btn-sm removebtncls">X</button>
                                                    <strong id="picture-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12">
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
                                        <div class="col-xl-12 col-lg-12 biodata">
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
                        <input type="hidden" class="form-control" name="LeftThumbVal" id="LeftThumbVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="LeftIndexVal" id="LeftIndexVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="LeftMiddelVal" id="LeftMiddelVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="LeftRingVal" id="LeftRingVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="LeftPickyVal" id="LeftPickyVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="RightThumbVal" id="RightThumbVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="RightIndexVal" id="RightIndexVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="RightMiddleVal" id="RightMiddleVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="RightRingVal" id="RightRingVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="RightPickyVal" id="RightPickyVal" readonly="true" value=""/>
                        <input type="hidden" class="form-control" name="faceidencoded" id="faceidencoded" readonly="true" value=""/>  
                        <input type="hidden" class="form-control" name="personuuid" id="personuuid" readonly="true" value=""/>     
                        <input type="hidden" class="form-control" name="memberId" id="memberId" readonly="true" value=""/>     
                        <input type="hidden" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        @can('Client-Add')
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
                    <h4 class="modal-title" id="myModalLabel334">Client Info</h4>
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
                                                    <td><label style="font-size: 14px;" strong>ID</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="memberidslbl" strong></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;" strong>Full Name</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="NameLbl" strong></label></td>
                                                </tr>
                                                <tr id="gendertr">
                                                    <td> <label style="font-size: 14px;" strong>Gender</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="GenderLbl" strong></label></td>
                                                </tr>
                                                <tr id="dobtr">
                                                    <td> <label style="font-size: 14px;" strong>DOB</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="DOBLbl" strong></label></td>
                                                </tr>
                                                <tr id="tintr">
                                                    <td> <label style="font-size: 14px;" strong>TIN </label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="TinNumberLbl" strong></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;" strong>Nationality</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="NationalityLbl" strong></label></td>
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
                                                    <td><label style="font-size: 14px;" strong>Medical Information</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="healthstatuslbl" strong></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;" strong>Name</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="emergencyconnamelbl" strong></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;" strong>Phone</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="emergencyphonelbl" strong></label></td>
                                                </tr>
                                                <tr>
                                                    <td><label style="font-size: 14px;" strong>Location</label></td>
                                                    <td><label style="font-size: 14px;font-weight:bold;" id="emergencyloclbl" strong></label></td>
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
                                                        <td> <label style="font-size: 14px;" strong>Country</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="CountryLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>City</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="CityLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Sub City</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="SubCityLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Woreda</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="WoredaLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Location</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="LocationLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Mobile Phone</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="PhoneLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Email</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="EmailLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Occupation</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="occLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label style="font-size: 14px;" strong>Passport #</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="PassportNoLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Residance ID</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="ResidanceIdLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Identification ID</label></td>
                                                        <td><a style="text-decoration:underline;color:blue;" onclick="identificationidval()" id="IdentificationIdLbl"></a></td>
                                                    </tr> 
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Memo</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="memolbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Loyalty Status</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="LoyalityStatusLbl" strong></label></td>
                                                    </tr>
                                                    <tr>
                                                        <td> <label style="font-size: 14px;" strong>Client Status</label></td>
                                                        <td><label style="font-size: 14px;font-weight:bold;" id="StatusLbl" strong></label></td>
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
                                                        <td style="width: 40%"><label strong style="font-size: 14px;">Enroll Device</label></td>
                                                        <td style="width: 60%"><label id="enrolldeviceinfo" strong style="font-size:14px;font-weight:bold;"></label></td>
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
                    <input type="hidden" class="form-control" name="memberInfoId" id="memberInfoId" readonly="true" value=""/>
                    <input type="hidden" class="form-control" name="filenameInfo" id="filenameInfo" readonly="true" value=""/>
                    <button id="closebuttong" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--  end of info show madal  -->
    
    <!--Start member delete modal -->
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
                        <label strong style="font-size: 16px;font-weight:bold;color:white;">Do you really want to delete this client?</label>
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="memberDelId" id="memberDelId" readonly="true">
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
    <!-- End member delete modal -->

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
        var j = 0;
        var i = 0;
        var m = 0;
        var dtable = "";

        $(document).ready(function() {
            $('#Dob').pickadate({
                format: 'yyyy-mm-dd',
                selectMonths: true,
                selectYears: 60,
                max: true
            });

            $('#mem_tbl').hide();
            $('#filter_div').hide();
            
            dtable = $('#laravel-datatable-crud').DataTable({
                destroy: true,
                processing: true,
                responsive: true,
                searchHighlight: true,
                serverSide: true,
                "lengthMenu": [50,100],
                "order": [
                    [0, "desc"]
                ],
                "pagingType": "simple",
                language: {
                    search: '',
                    searchPlaceholder: "Search here"
                },
                scrollY:'60vh',
                scrollX: true,
                scrollCollapse: true,
                "dom": "<'row'<'col-sm-12 col-md-2'f><'col-sm-12 col-md-7 left-dom'><'col-sm-12 col-md-3 custom-buttons'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4 d-flex justify-content-center'i><'col-sm-12 col-md-4 d-flex justify-content-end'p>>",
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/membershiplist',
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
                        name: 'id',
                        'visible': false
                    },
                    {
                        data:'DT_RowIndex',
                        width:'3%'
                    },
                    {
                        data: 'Picture',
                        name: 'Picture',
                        "render": function( data, type, row, meta) {
                            if(data != null){
                                return `<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/MemberPicture/${data}" alt="-" width="80px" height="80px"></div>`;
                            } 
                            if(data == null){
                                if(row.Gender == "Male"){
                                    return '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/MemberPicture/dummymale.jpg" alt="-" width="80px" height="80px"></div>';
                                }
                                if(row.Gender == "Female"){
                                    return '<div style="text-align:left;margin-left:-2%;width:70px;height:82px;"><img src="../../../storage/uploads/MemberPicture/dummyfemale.jpg" alt="-" width="80px" height="80px"></div>';
                                }   
                            }
                        },
                        width:"5%"
                    },
                    {
                        data: 'MemberId',
                        name: 'MemberId',
                        width:'11%'
                    },
                    {
                        data: 'Name',
                        name: 'Name',
                        width:'14%'
                    },
                    {
                        data: 'Gender',
                        name: 'Gender',
                        width:'11%'
                    },
                    {
                        data: 'DOB',
                        name: 'DOB',
                        width:'11%'
                    },
                    {
                        data: 'MobilePhone',
                        name: 'MobilePhone',
                        width:'13%'
                    },
                    {
                        data: 'loyalty_status',
                        name: 'loyalty_status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Bronze"){
                                return `<span class="badge bg-glow" style="background-color:#cd7f32 !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Silver"){
                                return `<span class="badge bg-glow" style="background-color:#c0c0c0 !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Gold"){
                                return `<span class="badge bg-glow" style="background-color:#ffd700 !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Platinum"){
                                return `<span class="badge bg-glow" style="background-color:#e5e4e2 !important;color:#000000">${data}</span>`;
                            }
                            else if(data == "Sapphire"){
                                return `<span class="badge bg-glow" style="background-color:#0f52ba !important;color:#FFFFFF">${data}</span>`;
                            }
                            else if(data == "Diamond"){
                                return `<span class="badge bg-glow" style="background-color:#b9f2ff !important;color:#000000">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-glow" style="background-color:#000000 !important;color:#FFFFFF">${data}</span>`;
                            }
                        },
                        width:"11%"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        "render": function ( data, type, row, meta ) {
                            if(data == "Active"){
                                return `<span class="badge bg-success bg-glow">${data}</span>`;
                            }
                            else{
                                return `<span class="badge bg-danger bg-glow">${data}</span>`;
                            }
                        },
                        width:'11%'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        width:'4%'
                    }
                ],
                "initComplete": function () {
                    $('.custom-buttons').html(`
                       @can('Client-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addmembutton" id="addmembutton">Add</button>
                        @endcan 
                    `);
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
                    $('#mem_tbl').show();
                    $('#filter_div').show();
                },
            });
        });

        $('#LoyaltyStatusFilter').change(function(){
            var selected = $('#LoyaltyStatusFilter option:selected');
            var search = [];

            // Collect selected option values
            $.each(selected, function() {
                search.push($(this).val());
            });

            if (search.length === 0) {
                // No option selected: force DataTable to return no data
                dtable.column(8).search('^$', true, false).draw(); // Match an impossible pattern
            } else {
                // Options selected: build regex for filtering
                var searchRegex = search.join('|'); // OR-separated values for regex
                dtable.column(8).search(searchRegex, true, false).draw();
            }
        });

        $('body').on('click', '#addmembutton', function() {    
            $('#subcity-dd').empty();
            var subdef = '<option selected value=13>-</option>';
            $('#subcity-dd').append(subdef);
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
            $('#EnrollDevice').select2
            ({
                placeholder: "Select Enroll device here",
            });
            $("#Pname").prop("readonly", false);
            $('#memberId').val("");
            $('#operationtypes').val("1");
            $("#membertitle").html("Add Client");
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
            $("#inlineForm").modal('show');
        });

        function memberInfo(recordId){
            //var recordId = $(this).data('id');
            $.get("/showmember"+'/'+recordId , function(data) {
                $.each(data.memlist, function(key, value) {
                    $('#memberInfoId').val(value.id);
                    $('#NameLbl').html(value.Name);
                    $('#GenderLbl').html(value.Gender);
                    $('#DOBLbl').html(value.DOB);
                    $('#TinNumberLbl').html(value.TinNumber);
                    $('#NationalityLbl').html(value.Nationality);
                    $('#CountryLbl').html(value.Country);
                    $('#CityLbl').html(value.city_name);
                    $('#SubCityLbl').html(value.subcity_name);
                    $('#WoredaLbl').html(value.Woreda);
                    $('#LocationLbl').html(value.Location);
                    $('#PhoneLbl').html(value.MobileNo+"  ,   "+value.PhoneNo);
                    $('#EmailLbl').html(value.Email);
                    $('#occLbl').html(value.Occupation);
                    $('#healthstatuslbl').html(value.HealthStatus);
                    $('#memolbl').html(value.Memo);
                    $('#memberidslbl').html(value.MemberId);
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
                    var loyaltyst=value.LoyalityStatus;
                    if(st=="Active"){
                        $("#StatusLbl").html("<b style='color:#1cc88a'>"+value.Status+"</b>");
                    }
                    if(st=="Inactive"){
                        $("#StatusLbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }
                    if(st=="Block"){
                        $("#StatusLbl").html("<b style='color:#e74a3b'>"+value.Status+"</b>");
                    }

                    if(loyaltyst=="Bronze"){
                        $("#LoyalityStatusLbl").html("<b style='color:#CD7F32'>"+value.LoyalityStatus+"</b>");
                    }
                    if(loyaltyst=="Silver"){
                        $("#LoyalityStatusLbl").html("<b style='color:#808080'>"+value.LoyalityStatus+"</b>");
                    }
                    if(loyaltyst=="Gold"){
                        $("#LoyalityStatusLbl").html("<b style='color:#FFD700'>"+value.LoyalityStatus+"</b>");
                    }
                    if(loyaltyst=="Platinum"){
                        $("#LoyalityStatusLbl").html("<b style='color:#e2e2e2'>"+value.LoyalityStatus+"</b>");
                    }

                    if(value.Picture===null){
                        $('#previewInfoImg').attr("src","");
                        $('#previewInfoImg').attr("alt","Face ID not found");
                        $("#previewInfoImg").show(); 
                    }
                    else if(value.Picture!=null){
                        $('#previewInfoImg').attr("src","../../../storage/uploads/MemberPicture/"+value.Picture);
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
            });
            $("#memberInfoModal").modal('show'); 
        }

        function memberEdit(recordId){
            var membercnt=0;
            var picdatabin=null;
            $('.select2').select2();
            $("#operationtypes").val("2");
            $("#memberId").val(recordId);
            $.get("/showmember"+'/'+recordId , function(data) {
                membercnt=data.membercountcon;
                picdatabin=data.picdata;
                
                if(parseFloat(membercnt)>0){
                    $("#Pname").prop("readonly",true);
                }
                else if(parseFloat(membercnt)==0){
                    $("#Pname").prop("readonly",false);
                }
                $.each(data.memlist, function(key, value) {
                    $('#Pname').val(value.Name);
                    $('#TinNumber').val(value.TinNumber);
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
                    $('#personuuid').val(value.PersonUUID);
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
                        $('#previewImg').attr("src","../../../storage/uploads/MemberPicture/"+value.Picture);
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

                });
            });
            $('#syncbutton').text('Get FaceID');
            $('#syncbutton').prop("disabled", false);         
            $('#syncbuttonfp').text('Get FingerPrint');
            $('#syncbuttonfp').prop("disabled", false);
            $("#imageprv").show();
            $("#membertitle").html("Edit Client Information");
            $('#savebutton').text('Update');
            $('#savebutton').prop("disabled",false);
            $("#syncbutton").show();
            $("#syncbuttonfp").show();
            $(".biodata").show();
            $("#inlineForm").modal('show'); 
        }

        function memberDelete(recordId){
            var membercnt=0;
            $("#memberDelId").val(recordId);
            $.get("/showmember"+'/'+recordId , function(data) {
                membercnt=data.membercount;
                if(parseFloat(membercnt)>=1){
                    toastrMessage('error',"Unable to delete client, transaction is saved with this client","Error");
                }
                else if(parseFloat(membercnt)==0){
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
                url: "{{ url('savemembership') }}",
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
                            var text=data.errors.HealthStatus[0];
                            text = text.replace("health status", "medical information");
                            $('#healthst-error').html(text);
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
                            text = text.replace("The tin number format is invalid", "The tin must be 10 or 13 digit");
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
                        var oTable = $('#laravel-datatable-crud').dataTable();
                        oTable.fnDraw(false);
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
                    url:'/getFaceid',
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
                            var pic = data.success.pic;
                            var picfl = data.picflag;
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
                    url:'/getFingerprint',
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
                url: '/deletemember',
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
                        message:'',
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

        function enrolldevFn() {
            $('#enroll-error').html('');
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

        $(document).on('click', '.identificationidcls', function() {
            var recordId = $('#memberId').val();
            var filenames = $('#Identificationupdate').val();
            $.get("/downloadidn" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/Identification/" + filenames;
                window.open(link, '', 'width=1200,height=800,scrollbars=yes');
            });
        });

        function identificationidval() {
            var recordId = $('#memberInfoId').val();
            var filenames = $('#filenameInfo').val();
            $.get("/downloadidn" + '/' + recordId + '/' + filenames, function(data) {
                var link = "../../../storage/uploads/Identification/" + filenames;
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
            var file = $("#Picture").get(0).files[0];
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

        function adjClientName(ele){
            $("#Pname").prop("readonly", false);
        }
        
        function closeRegisterModal() {
            $("#Occupation").val(null).trigger('change');
            $('#subcity-dd').val(null).trigger('change');
            $("#city-dd").val(null).trigger('change');
            $('#Woreda').val(null).trigger('change');
            $('#nationality').val(null).trigger('change');
            $('#EnrollDevice').val(1).trigger('change');
            $('#Register').trigger('reset');
            $("#subcity-dd").empty();
            $("#Pictureupdate").val("");
            $("#captureimages").val("");
            $("#Identificationupdate").val("");
            $("#memberId").val("");
            $("#personuuid").val("");
            $('#Email').val('');
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
            $('#VatRegistrationNumber-error').html('');
            $('#healthst-error').html('');
            $('#tinCounter').html('0/13');
            $('#enroll-error').html('');
            $("#identificationidlinkbtn").hide();
            $("#previewImg").hide();
            $("#removepicbtn").hide();
            $("#syncbutton").hide();
            $("#syncbuttonfp").hide();
            $(".biodata").hide();
            $("#imageprv").hide();
            $('#subcity-dd').empty();
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
            //var oTable = $('#laravel-datatable-crud').dataTable();
            //oTable.fnDraw(false);
        }
    </script>
@endsection