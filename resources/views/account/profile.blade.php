@extends('layout.app1')
@section('title')
@endsection
@section('content')
    <div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Profile</h3>
                            <div class="nav-horizontal">
                                <ul class="nav nav-tabs justify-content-center" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tabgeneral" data-toggle="tab" aria-controls="generaltab" href="#generaltab" role="tab" aria-selected="true"><i data-feather='user'></i> General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tabpassword" data-toggle="tab" aria-controls="passwordtab" href="#passwordtab" role="tab" aria-selected="false"><i data-feather='lock'></i>  Change Password</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-datatable">
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
                        <div class="tab-content">
                        <div class="tab-pane active" id="generaltab" aria-labelledby="generaltab" role="tabpanel">
                          <div style="width:98%; margin-left:1%;">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                    
                                        <section id="input-mask-wrapper">
                                    <div class="col-md-12">
                                        <form id="generalform">
                                        <div class="row">
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Full Name</label>
                                                <input type="hidden" placeholder="customerid" class="form-control" name="id" id="id"/>
                                                <input type="text" placeholder="Full Name" class="form-control" name="FullName" id="FullName" value="{{Auth::user()->FullName}}" readonly/>
                                                <span class="text-danger">
                                                    <strong id="name-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-6 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">User Name</label>
                                                <input type="text" placeholder="User Name" class="form-control" name="UserName" id="UserName" value="{{Auth::user()->username}}" readonly/>
                                                <span class="text-danger">
                                                    <strong id="uname-error"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="divider">
                                            <div class="divider-text">-</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Phone Number</label>
                                                <input type="text" placeholder="Phone Number" class="form-control" name="PhoneNumber" id="PhoneNumber" value="{{Auth::user()->phone}}" onkeypress="return ValidatePhone(event);" onkeyup="removephoneerror();"/>
                                                <span class="text-danger">
                                                    <strong id="PhoneNumber-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Alternate Phone Number</label>
                                                <input type="text" placeholder="Alternate Phone Number" class="form-control" name="AlternatePhoneNumber" id="AlternatePhoneNumber" value="{{Auth::user()->AlternatePhone}}" onkeypress="return ValidatePhone(event);" onkeyup="removealternatephoneerror();"/>
                                                <span class="text-danger">
                                                    <strong id="AlternatePhoneNumber-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Email</label>
                                                <input type="text" placeholder="Email Address" class="form-control" name="EmailAddress" id="EmailAddress"  value="{{Auth::user()->email}}" onkeyup="ValidateEmail(this);" onkeypress="removeemailerror();"/>
                                                <span class="text-danger">
                                                    <strong id="email-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Address</label>
                                                <input type="text" placeholder="Address" class="form-control" name="Address" id="Address" value="{{Auth::user()->Address}}"/>
                                                <span class="text-danger">
                                                    <strong id="Address-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Nationality</label>
                                                <div>
                                                    <select class="selectpicker form-control" data-live-search="true" data-style="btn btn-outline-secondary waves-effect" name="Nationality" id="Nationality" onchange="nationalityVal()">
                                                    <option value="{{Auth::user()->Nationality}}" selected>{{Auth::user()->Nationality}}</option>
                                                        @foreach ($counrtys as $cn)
                                                            <option value="{{$cn->Name}}">{{$cn->Name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                                    <strong id="Nationality-error"></strong>
                                                </span>
                                            </div>
                                            <div class="col-xl-4 col-md-6 col-sm-12 mb-2">
                                                <label strong style="font-size: 14px;">Gender</label>
                                                <select class="invoiceto form-control" name="Gender" id="Gender" aria-errormessage="Select Status" onchange="genderVal()">
                                                    <option value="{{Auth::user()->Gender}}" selected>{{Auth::user()->Gender}}</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                                <span class="text-danger">
                                                    <strong id="Gender-error"></strong>
                                                </span>
                                            </div>
                                            
                                        </div> 
                                    </div>

                                    </form>
                                </section>
                    <div class="modal-footer">
                       
                        <button id="savebuttonuser" type="button" class="btn btn-info">Save Changes</button>
                       
                    </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="passwordtab" aria-labelledby="passwordtab" role="tabpanel">

                          <div style="width:98%; margin-left:1%;">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                      <!-- change password -->
                                      
                                            <!-- form -->
                                            <form id="changepass-form">
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="account-old-password">Old Password</label>
                                                            <div class="input-group form-password-toggle input-group-merge">
                                                                <input type="password" class="form-control" id="account-old-password" name="password" placeholder="Old Password" onkeyup="removeroldpasserror();" />
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text cursor-pointer">
                                                                        <i data-feather="eye"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger">
                                                        <strong id="password-error"></strong>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="account-new-password">New Password</label>
                                                            <div class="input-group form-password-toggle input-group-merge">
                                                                <input type="password" id="account-new-password" name="newpassword" class="form-control" placeholder="New Password" onkeyup="removenewpasserror();" />
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text cursor-pointer">
                                                                        <i data-feather="eye"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger">
                                                        <strong id="newpassword-error"></strong>
                                                    </span>
                                                    </div>
                                                    <div class="col-12 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="account-retype-new-password">Retype New Password</label>
                                                            <div class="input-group form-password-toggle input-group-merge">
                                                                <input type="password" class="form-control" id="account-retype-new-password" name="confirmnewpassword" placeholder="New Password" onkeyup="removerconfirmpasserror();" />
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text cursor-pointer"><i data-feather="eye"></i></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger">
                                                        <strong id="cnewpassword-error"></strong>
                                                    </span>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="button" id="savebutton" class="btn btn-info waves-effect waves-float waves-light">Save changes</button>
                                                        <button type="reset" class="btn btn-danger waves-effect waves-float waves-light" onclick="clearallerrors();"> Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--/ form -->
                                        
                                        <!--/ change password -->

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
     </div>
@endsection
@section('scripts')

<script  type="text/javascript">

$('#savebuttonuser').click(function(){ 
            var registerForm = $("#generalform");
            var formData = registerForm.serialize(); 
            $.ajax({
                url:'/userinfoupdate',
                type:'POST',
                data:formData,
                    beforeSend:function(){$('#savebuttonuser').text('saving...');},
                    success:function(data) 
                    {
                    if(data.success)
                    {
                    $('#savebuttonuser').text('Save Changes');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Successfull");
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                   
                    }
                    if(data.errors)
                    {
                        $('#savebuttonuser').text('Save Changes');
                        if(data.errors.PhoneNumber)
                        {
                            $('#PhoneNumber-error').html( data.errors.PhoneNumber[0] );  
                        }
                        if(data.errors.AlternatePhoneNumber)
                        {
                            $('#AlternatePhoneNumber-error').html( data.errors.AlternatePhoneNumber[0] );  
                        }
                        if(data.errors.EmailAddress)
                        {
                            $('#email-error').html( data.errors.EmailAddress[0] );  
                        }
                    }

                    },
            });


});
$('#savebutton').click(function(){  
             var registerForm = $("#changepass-form");
            var formData = registerForm.serialize(); 
            $.ajax({
                url:'/changepassword',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){$('#savebutton').text('saving...');},
                    success:function(data) 
                    {
                        if(data.success)
                        {
                    $('#savebutton').text('Save Changes');
                    $("#myToast").toast({ delay: 4000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html("Successfull");
                    $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    //$("#inlineForm").modal('hide');
                    $("#changepass-form")[0].reset();
                    window.location="/ims";

                        }
                        if(data.errors)
                        {
                            $('#savebutton').text('Save Changes');
                        if(data.errors.password)
                        {
                            $('#password-error').html( data.errors.password[0] );  
                        }
                        if(data.errors.newpassword)
                        {
                            if(data.errors.newpassword[0]=='The newpassword format is invalid.')
                            {
                                $('#newpassword-error').html('Your password must be more than 6 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character');
                            }
                            else
                            {
                                $('#newpassword-error').html( data.errors.newpassword[0]);
                            }
                            
                        }
                        if(data.errors.confirmnewpassword)
                        {
                            $('#cnewpassword-error').html(data.errors.confirmnewpassword[0]);
                        }

                        }
                        



                 },
            });

});

function removephoneerror()
{
    $('#PhoneNumber-error').html('');  
}
function removealternatephoneerror()
{
    $('#AlternatePhoneNumber-error').html('');
}
function removeemailerror()
{
    $('#email-error').html('');
}
function removenewpasserror()
{
    $('#newpassword-error').html('');
}
function removerconfirmpasserror()
{
    
    $('#cnewpassword-error').html('');
}

function removeroldpasserror()
{
    $('#password-error').html(''); 
}

function clearallerrors()
{
    $('#password-error').html(''); 
    $('#cnewpassword-error').html('');
    $('#newpassword-error').html('');


}
</script>   
@endsection
  