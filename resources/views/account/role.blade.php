@extends('layout.app1')
@section('title')
@endsection
@section('content')
@can('Role-View')
    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Roles</h3>
                            @can('Role-Add')
                            <button type="button" class="btn btn-gradient-info btn-sm addrole" data-toggle="modal" data-target="">Add</button>
                            @endcan
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%; margin-left:1%;">
                                <div>
                                    <table id="laravel-datatable-b1" class="display table-bordered table-striped table-hover dt-responsive mb-0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="width:3%">#</th>
                                                <th style="width:46%">Role Name</th>
                                                <th style="width:46%">Status</th>
                                                <th style="width:5%">Action</th>
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
    <div class="toast align-items-center text-white bg-primary border-0" id="myToast" role="alert" style="position: absolute; top: 2%; right: 40%; z-index: 7000; border-radius:15px;">
        <div class="toast-body">
            <strong id="toast-massages"></strong>
            <button type="button" class="ficon" data-feather="x" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div class="modal fade" id="inlineForm" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="roleregmodaltitle" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="roleregmodaltitle">Add Role & Permission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModalWithClearValidation()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="Register">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <section id="input-mask-wrapper">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-5" style="border-right-style: solid;border-right-color:rgba(34, 41, 47, 0.2);border-right-width: 1px;">
                                        <div class="divider">
                                            <div class="divider-text">Role Section</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label strong style="font-size: 14px;">Role Name</label>
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" name="roleID" id='roleID' />
                                                    <input type="text" placeholder="Enter Role Name here..." class="form-control" name="role" id='role' onkeyup="removeNameValidation()" autofocus/>
                                                    <span class="text-danger">
                                                        <strong id="role-error"></strong>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-xl-4 mt-1">
                                                <label strong style="font-size: 14px;">Status</label>
                                                <div class="form-group">
                                                    <select class="form-control" name="status" id="status" onchange="reqstatusVal()">
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive </option>
                                                    </select>
                                                    <span class="text-danger">
                                                        <strong id="status-error"></strong>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-xl-8 mt-1">
                                                <label strong style="font-size: 14px;">Description</label>
                                                <div class="form-group">
                                                        <textarea type="text" placeholder="Write Description here..." class="form-control" rows="3" name="description" id="description"> </textarea>
                                                        <span class="text-danger">
                                                            <strong id="description-error"></strong>
                                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7">
                                        <div class="divider">
                                            <div class="divider-text">Permission Section</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <ul id="tree">
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="menu"></i>   Registry</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="categoryFn('Category')"><i data-feather="circle"></i>   Category</a></li>
                                                            <li><a href="#" onclick="uomFn('UOM')"><i data-feather="circle"></i>   UOM</a></li>
                                                            <li><a href="#" onclick="itemFn('Item')"><i data-feather="circle"></i>   Item/Service</a></li>
                                                            <li><a href="#" onclick="customerFn('Customer')"><i data-feather="circle"></i>   Customer/Supplier</a></li>
                                                            <li><a href="#" onclick="shopFn('Store')"><i data-feather="circle"></i>   Store/Shop</a></li>
                                                            <li><a href="#" onclick="brandFn('Brand')"><i data-feather="circle"></i>   Brand & Model</a></li>
                                                            <li><a href="#" onclick="deviceFn('Devices')"><i data-feather="circle"></i>   Device</a></li>
                                                            <li><a href="#" onclick="bankFn('Bank')"><i data-feather="circle"></i>   Bank</a></li>
                                                            <li><a href="#" onclick="periodFn('Period')"><i data-feather="circle"></i>   Period</a></li>
                                                            <li><a href="#" onclick="groupFn('Group')"><i data-feather="circle"></i>   Group</a></li>
                                                            <li><a href="#" onclick="paymenttermFn('PaymentTerm')"><i data-feather="circle"></i>   PaymentTerm</a></li>
                                                            <li><a href="#" onclick="serviceFn('Service')"><i data-feather="circle"></i>   Service</a></li>
                                                            <li><a href="#" onclick="branchFn('Branch')"><i data-feather="circle"></i>   Branch</a></li>
                                                            <li><a href="#" onclick="departmentFn('Department')"><i data-feather="circle"></i>   Department</a></li>
                                                            <li><a href="#" onclick="memberFn('Client')"><i data-feather="circle"></i>   Client</a></li>
                                                            <li><a href="#" onclick="employeeFn('Employee')"><i data-feather="circle"></i>   Staff</a></li>

                                                            <li><a href="#" onclick="regionFn('Region')"><i data-feather="circle"></i>   Region</a></li>
                                                            <li><a href="#" onclick="zoneFn('Zone')"><i data-feather="circle"></i>   Zone</a></li>
                                                            <li><a href="#" onclick="woredaFn('Woreda')"><i data-feather="circle"></i>   Woreda</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="shopping-bag"></i>   Sales & Marketing</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="salesFn('Sales')"><i data-feather="circle"></i>   Sales</a></li>
                                                            <li><a href="#" onclick="proformaFn('Proforma')"><i data-feather="circle"></i>   Proforma</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="home"></i>   Warehouse & Inventory</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="receivingFn('Receiving')"><i data-feather="circle"></i>   Good Receiving</a></li>
                                                            <li><a href="#" onclick="reqFn('Requisition')"><i data-feather="circle"></i>   Stock Requisition</a></li>
                                                            <li><a href="#" onclick="transferFn('Transfer')"><i data-feather="circle"></i>   Stock Transfer</a></li>
                                                            <li><a href="#" onclick="stbalanceFn('Balance')"><i data-feather="circle"></i>   Stock Balance</a></li>
                                                            <li><a href="#" onclick="adjustmentFn('Adjustment')"><i data-feather="circle"></i>   Stock Adjustment</a></li>
                                                            <li><a href="#" onclick="beginningFn('Beginning')"><i data-feather="circle"></i>   Stock Beginning</a></li>
                                                            <li><a href="#" onclick="commBeginningFn('CommBeginning')"><i data-feather="circle"></i>   Commodity Beginning</a></li>
                                                            <li><a href="#" onclick="commStockBalanceFn('CommStockBalance')"><i data-feather="circle"></i>   Commodity Stock Balance</a></li>
                                                            <li><a href="#" onclick="dispatchFn('Dispatch')"><i data-feather="circle"></i>   Dispatch</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="home"></i>   D S</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="dsinvFn('DSI')"><i data-feather="circle"></i>   DS</a></li>
                                                            <li><a href="#" onclick="dStockInFn('directstockIn')"><i data-feather="circle"></i>   Stock-IN</a></li>
                                                            <li><a href="#" onclick="dStockOutFn('directstockOut')"><i data-feather="circle"></i>   Stock-OUT</a></li>
                                                            <li><a href="#" onclick="dStockBalanceFn('directstockBalance')"><i data-feather="circle"></i>   Stock Balance</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="star"></i>   Utility</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="salessettFn('SalesSettlement')"><i data-feather="circle"></i>   Sales Settlement</a></li>
                                                            <li><a href="#" onclick="closingFn('SalesClosing')"><i data-feather="circle"></i>   Income Follow-Up</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i class="fa fa-industry" aria-hidden="true"></i>  Production</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="bomFn('bom')"><i data-feather="circle"></i>   Bill of Material (BOM)</a></li>
                                                            <li><a href="#" onclick="prOrderFn('prorder')"><i data-feather="circle"></i>   Production Order</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="package"></i>   Ftness & Spa</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="applicationFormFn('FitnessForm')"><i data-feather="circle"></i>   Fitness Form</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i class="fa fa-user" aria-hidden="true"></i>   HR</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="leaveRequestFn('LeaveRequest')"><i data-feather="circle"></i>  Leave Request</a></li>
                                                            <li><a href="#" onclick="shiftSchFn('ShiftSchedule')"><i data-feather="circle"></i>  Shift Schedule</a></li>
                                                            <li><a href="#" onclick="attendanceFn('Attendance')"><i data-feather="circle"></i>  Attendance</a></li>
                                                            <li><a href="#" onclick="payrollAddFn('PayrollAdd')"><i data-feather="circle"></i>  Payroll Addition/Deduction</a></li>
                                                            <li><a href="#" onclick="payrollFn('Payroll')"><i data-feather="circle"></i>  Payroll</a></li>
                                                            <li><a href="#" onclick="moduleFn()"><i class="fa fa-cog" aria-hidden="true"></i> Set Up</a>
                                                                <ul class="opt">
                                                                    <li><a href="#" onclick="overtimeFn('Overtime-Level')"><i data-feather="circle"></i>  Overtime Level</a></li>
                                                                    <li><a href="#" onclick="holidayFn('Holiday')"><i data-feather="circle"></i>  Holiday</a></li>
                                                                    <li><a href="#" onclick="leaveTypeFn('Leave-Type')"><i data-feather="circle"></i>  Leave Type</a></li>
                                                                    <li><a href="#" onclick="salaryTypeFn('SalaryComponent')"><i data-feather="circle"></i>   Salary Component</a></li>
                                                                    <li><a href="#" onclick="salaryFn('Salary')"><i data-feather="circle"></i>   Salary</a></li>
                                                                    <li><a href="#" onclick="positionFn('Position')"><i data-feather="circle"></i>   Position</a></li>
                                                                    <li><a href="#" onclick="timetableFn('Timetable')"><i data-feather="circle"></i>   Timetable</a></li>
                                                                    <li><a href="#" onclick="shiftFn('Shift')"><i data-feather="circle"></i>   Shift</a></li>
                                                                    <li><a href="#" onclick="employeeFn('Employee')"><i data-feather="circle"></i>   Employee</a></li>
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="book-open"></i>   Report</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="reportsFn('Reports')"><i data-feather="circle"></i>   Reports</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="settings"></i>   Setting</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="settingFn('Setting')"><i data-feather="circle"></i>   Setting-Change</a></li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="#" onclick="moduleFn()"><i data-feather="users"></i>   Account</a>
                                                        <ul class="opt">
                                                            <li><a href="#" onclick="userFn('User')"><i data-feather="circle"></i>   User</a></li>
                                                            <li><a href="#" onclick="roleFn('Role')"><i data-feather="circle"></i>   Role</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xl-7">

                                                <div class="card cardpermission" id="Category">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Category Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="jstree-catcheckbox"></div>
                                                        @foreach ($categorypermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="UOM">
                                                    <div class="card-header">
                                                        <h6 class="card-title">UOM Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($uompermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>  

                                                <div class="card cardpermission" id="Item">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Item Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($itempermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>  

                                                <div class="card cardpermission" id="Customer">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Customer/ Supplier Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($customerpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>  

                                                <div class="card cardpermission" id="Store">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Store/ Shop Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($storerpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>   

                                                <div class="card cardpermission" id="Brand">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Brand & Model Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($brandpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                <div class="card cardpermission" id="Devices">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Device Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($devicepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                <div class="card cardpermission" id="Bank">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Bank Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($bankpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Period">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Period Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($periodpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Group">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Group Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($grouppermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="PaymentTerm">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Payment Term Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($paymenttermpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                
                                                <div class="card cardpermission" id="Service">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Service Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($servicepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Branch">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Branch Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($branchpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Department">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Department Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($departmentpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Region">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Region Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($regionpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Zone">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Zone Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($zonepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Woreda">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Woreda Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($woredapermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="SalaryComponent">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Salary Component Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($salarytypepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Salary">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Salary Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($salarypermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Position">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Position Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($positionpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Shift">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Shift Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($shiftpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Timetable">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Timetable Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($timetablepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="ShiftSchedule">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Shift Schedule Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($shiftschpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Attendance">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Attendance Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($attendancepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Client">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Client Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($memberpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Employee">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Employee Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($employeepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Staff">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Staff Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($staffpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Sales">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Sales Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($salespermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Receiving">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Receiving Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($recievingpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Requisition">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Stock Requisition Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($requisitiongpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Transfer">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Stock Transfer Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($storetransferpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Aprroval Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($approvalpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Issue Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($issuepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Adjustment">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Stock Adjustment Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($adjustmentpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Beginning">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Stock Beginning Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($beginingpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Dispatch">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Dispatch Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($dispatchpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="CommBeginning">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Commodity Beginning Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($commoditybegpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="CommStockBalance">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Commodity Stock Balance Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($commoditystockbalancepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Balance">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Stock Balance Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($stockbalancepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="DSI">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Dead Stock Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($deadpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="directstockIn">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Direct Stock-IN Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($directstockin as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="directstockOut">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Direct Stock-OUT Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($directstockout as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="directstockBalance">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Direct Stock Balance Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($directstockbalance as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="SalesSettlement">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Sales Settlement Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($settlementpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="SalesClosing">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Income Follow-Up Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($incomefollowuppermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="bom">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Bill of Material (BOM) Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($bompermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="prorder">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Production Order Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($prorderpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="FitnessForm">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Application Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($applicationpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="LeaveRequest">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Leave Request Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($leaverequestpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Holiday">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Holiday Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($holidaypermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Overtime-Level">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Overtime Level Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="jstree-catcheckbox"></div>
                                                        @foreach ($otlevelpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="PayrollAdd">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Payroll-Addition / Deduction Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($payrolladdpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Payroll">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Payroll Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($payrollpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Leave-Type">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Leave Type Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($leavetypepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Reports">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Report Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($reportpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Setting">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Setting Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($setingpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="User">
                                                    <div class="card-header">
                                                        <h6 class="card-title">User Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($accountpermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="card cardpermission" id="Role">
                                                    <div class="card-header">
                                                        <h6 class="card-title">Role Permission</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @foreach ($rolepermission as $data)
                                                        <div class="custom-control custom-control-primary custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input userpermission" id="colorCheck{{ $data->id }}" name="permission[]" value="{{ $data->id }}"/>
                                                            <label class="custom-control-label" for="colorCheck{{ $data->id }}">{{ $data->name }}</label>                                                
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" placeholder="" class="form-control" name="operationtypes" id="operationtypes" readonly="true"/>
                        <button id="savebuttonupdate" type="button" class="btn btn-info">Save</button>
                        <button id="savebutton" type="button" class="btn btn-info">Save</button>
                        <button id="closebuttons" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    <label strong style="font-size: 16px;">Are You Sure You Want to Delete This Roles</label>
                    <div class="form-group">
                        <input type="hidden" placeholder="id" class="form-control" name="rid" id="rid">
                        <input type="hidden" placeholder="hhaderid" class="form-control" name="hid" id="hid">
                        <span class="text-danger">
                            <strong id="uname-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">

                    <button id="deleteBtn" type="button" class="btn btn-info">Delete</button>


                    <button id="closebutton" type="button" class="btn btn-danger" onclick="closeModalWithClearValidation()" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(function () {
        pageSection = $('#page-block');
    });

    $(function () {
        cardSection = $('#page-block');
    });

    //start checkbox change function
    $(function () {
        $("#fullpermission").click(function () {
            if ($(this).is(":checked")) {
                $("#allPermission").find('option').prop("selected",true);
                $("#allPermission").trigger('change');
            } else {
                $("#allPermission").find('option').prop("selected",false);
                $("#allPermission").trigger('change');
            }
        });
        var checkboxTree = $('#jstree-catcheckbox'),
        ajaxTree = $('#jstree-ajax');       
    });
    //end checkbox change function



    function GetRegistryPermission()
    {

    }

    function GetSalePermission()
    {
        
    }


    $('body').on('click', '.addrole', function () {
        $("#roleID").val('');
        $("#inlineForm").modal('show');
        $("#roleregmodaltitle").text('Add Role & Permission');
        $("#savebuttonupdate").hide();
        $("#permsionu").hide();
        $("#permsion").show();
        $("#savebutton").show();
        $("#allPermission").find('option').prop("selected",false);
        $("#allPermission").trigger('change');
        $("#description").val('');
        GetRegistryPermission();
        $(".opt").hide();
        $(".cardpermission").hide();
        $('#operationtypes').val("1");
        $('#savebutton').text('Save');
        $('#savebutton').prop("disabled",false);
    });

    $('body').on('click', '.deleteUser', function () {
        $("#examplemodal-delete").modal('show');
        var sid = $(this).data('id');
        $("#rid").val(sid);
    });

    $('body').on('click', '.editRole', function () {
        $("#inlineForm").modal('show');
        $("#roleregmodaltitle").text('Update Role & Permission');
        $("#roleTab").tab('show');
        $("#savebuttonupdate").hide();
        $("#savebutton").show();
        $("#permsionu").show();
        $("#permsion").hide();
        $("#allPermission").find('option').prop("selected",false);
        $("#allPermission").trigger('change');
        var sid = $(this).data('id');
        $("#roleID").val(sid);
        $("#categoryPermission").empty();
        $("#UOMPermission").empty();
        $("#itemPermission").empty();
        $("#cusotmerPermission").empty();
        $("#storePermission").empty();
        $("#brandPermission").empty();
        $("#salePermission").empty();
        $("#recievingPermission").empty();
        $("#requisitionPermission").empty();
        $("#storeTransferPermission").empty();
        $("#settingPermission").empty();
        $("#issuePermission").empty();
        $("#approvalPermission").empty();
        $("#rolePermission").empty();
        $("#beginingPermission").empty();
        $("#storeBalancePermission").empty();
        $("#adjustmentPermission").empty();
        $("#approvalPermission").empty();
        $("#deadStockPermission").empty();
        $("#reportPermission").empty();
        $("#userPermission").empty();
        $("#rolePermission").empty();
        $(".opt").hide();
        $(".cardpermission").hide();
        $('#operationtypes').val("2");
        $('#savebutton').text('Update');
        $('#savebutton').prop("disabled",false);
        $.ajax({
            type: "GET",
            url: "{{ url('editrole') }}/"+sid,
            data: "",
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
            success: function (response) {
                $("#role").val(response.role.name);
                $("#status").val(response.role.status);
                $("#description").val(response.role.description);
                $.each(response.rolePermissions, function (index, value) { 
                $('.userpermission').each(function(e){
                    if($(this).val() == value.id){
                        $(this).prop("checked", true);
                    }
                });
            });
            }
        });

        $('#savebuttonupdate').click(function(){
            var sid= $("#roleID").val();
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $.ajax({
                url:'/updaterole/'+sid,
                type:'PUT',
                data:formData,
                beforeSend:function(){$('#savebuttonupdate').text('updating...');},
                success:function(data) {
                    if(data.errors)
                    {
                        if(data.errors.role)
                            {
                                $( '#role-error' ).html( data.errors.role[0] );
                            }
                            if(data.errors.permissions)
                                {
                                    $( '#permissions-error' ).html( data.errors.permissions[0] );
                            }
                    }
                },
            });
        });
    });

    $('#deleteBtn').click(function(){
        var cid = document.forms['deletform'].elements['rid'].value;
        var registerForm = $("#deletform");
        var formData = registerForm.serialize();
        $.ajax({
            url:'/deleterole/'+cid,
            type:'DELETE',
            data:formData,
            beforeSend:function(){
                $('#deleteBtn').text('Deleting Role...');
            },
            success:function(data)
            {
                if(data.success)
                {
                    $('#deleteBtn').text('Delete');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html(data.success);
                    $('.toast-body').css({"background-color": "  #28a745","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $('#examplemodal-delete').modal('hide');
                    var oTable = $('#laravel-datatable-b1').dataTable();
                    oTable.fnDraw(false);
                }
                if(data.deleterrors)
                {
                    $('#deleteBtn').text('Delete');
                    $("#myToast").toast({ delay: 10000 });
                    $("#myToast").toast('show');
                    $('#toast-massages').html(data.deleterrors);
                    $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                    $('#examplemodal-delete').modal('hide');
                    $('#deletebtn').text('Delete');
                    var oTable = $('#laravel-datatable-b1').dataTable();
                    oTable.fnDraw(false);
                }
            }
        });
    });

    
    $('#savebutton').click(function(){
        var optype = $("#operationtypes").val();
        var registerForm = $("#Register");
        var formData = registerForm.serialize();
        $.ajax({
            url:'/saverole',
            type:'POST',
            data:formData,
            beforeSend:function(){
                if(parseFloat(optype)==1){
                    $('#savebutton').text('Saving...');
                    $('#savebutton').prop("disabled", true);
                }
                else if(parseFloat(optype)==2){
                    $('#savebutton').text('Updating...');
                    $('#savebutton').prop("disabled", true);
                }
                pageSection.block({
                        message:
                        '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mt-0">Loading Please wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div> </div>',
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
                if(parseFloat(optype)==1){
                    $('#savebutton').text('Save');
                    $('#savebutton').prop('disabled',false);
                }
                else if(parseFloat(optype)==2){
                    $('#savebutton').text('Update');
                    $('#savebutton').prop('disabled',false);
                }
                pageSection.block({
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
                if(data.errors)
                {
                    if(data.errors.role)
                    {
                        if(data.errors.role[0]=='The role format is invalid.')
                        {
                            $("#myToast").toast({ delay: 10000 });
                            $("#myToast").toast('show');
                            $('#toast-massages').html("Role Format is invalid, Do not use space in role name");
                            $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                        }
                        $('#role-error' ).html( data.errors.role[0] );
                    }
                    if(data.errors.permission)
                    {
                        $( '#permission-error' ).html( data.errors.permission[0] );
                    }
                    toastrMessage('error','Check Your Inputs','Error');
                }
                if(data.success)
                {
                    toastrMessage('success','Successfully Saved','successfull');
                    $('#inlineForm').modal('hide');
                    $("#Register")[0].reset();
                    var oTable = $('#laravel-datatable-b1').dataTable();
                    oTable.fnDraw(false);
                    closeModalWithClearValidation();
                }
            },
        });
    });

    // Treeview Initialization
    $(document).ready(function() {
        $("#tree").explr();
    });

    $(document).ready( function ()
    {
        $('#laravel-datatable-b1').DataTable({
            processing: true,
            serverSide: true,
            searchHighlight: true,
            "order": [[ 0, "desc" ]],
            "lengthMenu": [50,100],
            "pagingType": "simple",
            language: { search: '', searchPlaceholder: "Search here"},
            scrollY:'55vh',
            scrollX: true,
            scrollCollapse: true,
            "dom": "<'row'<'col-lg-10 col-md-10 col-xs-8'f><'col-lg-2 col-md-2 col-xs-8'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'i><'col-sm-12 col-md-3'p>>",
            ajax: {
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                url: '/rolelist',
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
                { data: 'id', name: 'id', 'visible': false },
                { data:'DT_RowIndex',width:"3%"},
                { data: 'name', name: 'name',width:"46%"},
                { data: 'status', name: 'status',width:"46%"},
                { data: 'action', name: 'action',width:"5%"}
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
            {
                if (aData.status == "Active")
                {
                    $(nRow).find('td:eq(2)').css({"color": "#4CAF50", "font-weight": "bold","text-shadow":"1px 1px 10px #4CAF50"});
                }
                else if (aData.status == "Inactive")
                {
                    $(nRow).find('td:eq(2)').css({"color": "#f44336", "font-weight": "bold","text-shadow":"1px 1px 10px #f44336"});
                }
            }
        });
    });

    $('#laravel-datatable-b1 tbody').on('click', 'tr', function () {
        if($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            $('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    function removeNameValidation()
    {
        $( '#role-error' ).html('');
    }

    function v()
    {
        $('#permissions-error' ).html('');
    }

    function categoryFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function uomFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function itemFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function customerFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function shopFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function brandFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function deviceFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function bankFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function periodFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function groupFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function paymenttermFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function serviceFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function branchFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function departmentFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function regionFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function zoneFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function woredaFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }


    function salaryTypeFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function salaryFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function positionFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function timetableFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function shiftFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function memberFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function staffFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function trainerFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function employeeFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function salesFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function proformaFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function receivingFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function reqFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function transferFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function stbalanceFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function adjustmentFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function beginningFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function dispatchFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function commBeginningFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function commStockBalanceFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function dsinvFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function dStockInFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function dStockOutFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function dStockBalanceFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function salessettFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function closingFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function bomFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function prOrderFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function applicationFormFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function leaveRequestFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function shiftSchFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function attendanceFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function payrollAddFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function payrollFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function holidayFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function overtimeFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function leaveTypeFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function reportsFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function settingFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function userFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function roleFn(name)
    {
        $(".cardpermission").hide();
        $("#"+name).show();
    }

    function moduleFn(name)
    {
        $(".cardpermission").hide();
    }

    function closeModalWithClearValidation()
    {
        $('#role-error' ).html('');
        $('#status-error' ).html('');
        $('#permission-error' ).html('');
        $('#permissions-error' ).html('');
        $('#savebutton').text('Save');
        $("#Register")[0].reset();
        $('#savebutton').prop('disabled',false);
    }
    </script>

    
@endsection

