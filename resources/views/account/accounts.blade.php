@extends('layout.app')

@section('title')

@endsection

@section('content')

<div class="app-content content ">
    <section id="responsive-datatable">
       <div class="row">
       <div class="col-12">
           <div class="card">
           <div class="card-header border-bottom">
               <h3 class="card-title">Users</h3>
               <button type="button" class="btn btn-gradient-info btn-sm addaccount" data-toggle="modal" data-target="#inlineForm">Add</button>
               
           </div>
           <div class="card-datatable">
               @include('inc.messsages') 
               <table id="laravel-datatable-b1" class="dt-responsive table" style="width: 100%">
                   <thead>
                       <tr>
                           <th style="width: 10%; border: 1px solid #D3D3D3;">Id</th>
                           <th style="width: 30%; border: 1px solid #D3D3D3;">Name</th>
                           <th style="width: 30%; border: 1px solid #D3D3D3;">User Name</th>
                           <th style="width: 30%; border: 1px solid #D3D3D3;">Email</th>
                           <th style="width: 30%; border: 1px solid #D3D3D3;">Role</th>

                           <th style="width: 35%; border: 1px solid #D3D3D3;">Action</th>
                       </tr>
                   </thead>
                   
               
               </table>
              
           </div>
       </div>
       </div>
       </div>
    </section>
   </div>

   <div class="modal fade text-left" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Register Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="Register">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label strong style="font-size: 16px;">Name</label>
                    <div class="form-group">
                        <input type="text" placeholder="name" class="form-control" name="name" id='name' onclick="removeNameValidation()" autofocus/>
                        <span class="text-danger">
                            <strong id="name-error"></strong>
                        </span>
                    </div>
                    <label strong style="font-size: 16px;">User Name</label>
                    <div class="form-group">
                        <input type="text" placeholder="username" class="form-control" name="username" id='username' onclick="removeusernameValidation()" autofocus/>
                        <span class="text-danger">
                            <strong id="username-error"></strong>
                        </span>
                    </div>

                    <label strong style="font-size: 16px;">Email</label>
                    <div class="form-group">
                        <input type="text" placeholder="email" class="form-control" name="email" id='email' onclick="removeuseremailValidation()" autofocus/>
                        <span class="text-danger">
                            <strong id="email-error"></strong>
                        </span>
                    </div>

                    <label strong style="font-size: 16px;">password</label>
                    <div class="form-group">
                        <input type="password" placeholder="password" class="form-control" name="password" value="123456" id='password' onclick="removeuserpasswordValidation()" autofocus/>
                        <span class="text-danger">
                            <strong id="password-error"></strong>
                        </span>
                    </div>
                    
                    <label strong style="font-size: 16px;">Confirm Password</label>
                    <div class="form-group">
                        <input type="password" placeholder="confirm password" class="form-control" name="confirmpassword" value="123456" id='confirmpassword' onclick="removeuserconfirmpasswordValidation()" autofocus/>
                        <span class="text-danger">
                            <strong id="confirmpassword-error"></strong>
                        </span>
                    </div>

                    <label strong style="font-size: 16px;">Role</label>
                    <div class="form-group">
                        <select class="invoiceto form-control" name="role" id="role" onchange="reqroleVal()">
                            <option disabled selected ></option>
                            @foreach ($roles as $role)
                            <option value='{{$role}}'>{{$role}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="role-error"></strong>
                        </span>
                    </div>

                </div>
                <div class="modal-footer">
                    {{-- <button id="savenewbutton" type="button" class="btn btn-info">Save & New</button> --}}
                    <button id="savebutton" type="button" class="btn btn-info">Save</button>
                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script type="text/javascript">

$('#savebutton').click(function(){  
                var registerForm = $("#Register");
                var formData = registerForm.serialize(); 

                $.ajax({
                    url:'/saveaccount',
                    type:'POST',
                    data:formData,
                    beforeSend:function(){$('#savebutton').text('saving...');},
                    success:function(data) {

                           if(data.errors)
                           {
                                if(data.errors.role)
                               {
                               $( '#role-error' ).html( data.errors.role[0] );
                               }
                              if(data.errors.name)
                               {
                                $( '#name-error' ).html( data.errors.name[0] );
                               }
                               if(data.errors.username)
                               {
                                $( '#username-error' ).html( data.errors.username[0] );
                               }
                               if(data.errors.email)
                               {
                                $( '#email-error' ).html( data.errors.email[0] );
                               }
                               if(data.errors.password)
                               {
                                $( '#password-error' ).html( data.errors.password[0] );
                               }
                               if(data.errors.confirmpassword)
                               {
                                $( '#confirmpassword-error' ).html( data.errors.confirmpassword[0] );
                               }
                            
                           } 
                           if(data.success)
                           {
                            $("#myToast").toast('show');
                            $('#toast-massages').html("Saved Successfully");
                            $('#savebutton').text('save');
                             $('.toast-body').css({"background-color": "	#28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"}); 
                            $('#inlineForm').modal('hide');
                            
                            
                             var oTable = $('#laravel-datatable-b1').dataTable(); 
                             oTable.fnDraw(false);
                            
                           }
                    },
                });
            
        });

$(document).ready( function () 
    {
        $('#laravel-datatable-b1').DataTable({
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
            url: '/account',
            type: 'GET',
            },
        columns: [
            { data: 'id', name: 'id', 'visible': false },
            { data: 'name', name: 'name' },
            { data: 'username', name: 'username' }, 
            { data: 'email', name: 'email' },  
            { data: 'role', name: 'role' },
            { data: 'action', name: 'action' }
        ],
       
        });

    });


    function removeNameValidation()
{
    $( '#name-error' ).html('');   
}
function removeusernameValidation()
{
    $( '#username-error' ).html('');   
}
function  removeuseremailValidation()
{
    $( '#email-error' ).html('');   
}
function removeuserpasswordValidation()
{
    $( '#password-error' ).html('');   
}
function removeuserconfirmpasswordValidation()
{
    $( '#confirmpassword-error' ).html('');   
}
function reqroleVal()
{
    $( '#role-error' ).html('');   
}
    </script>

@endsection

