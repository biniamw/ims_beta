@extends('layout.app1')
@section('title')
@endsection
@section('content')
    @can('ItemMovement-View')
        <div class="app-content content">
            <section id="responsive-datatable">
                <form id="dashboardform">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="row">
                                <div class="col-xl-7 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Last 7 day sales</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getSalesfn()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <canvas id="chart" height="120"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Today's sales</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getSalesPie()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <canvas id="todayspie" height="175"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Gross Profit Margin as of Today</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getsalesptype()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <canvas id="chartProgress" height="150"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Payment Type by POS</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getsalesptype()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table id="salespaymenttbl" class="table table-hover-animation table-sm" style="width: 100%">
                                                                <thead>
                                                                    <th>POS</th>
                                                                    <th style="text-align: center">Cash</th>
                                                                    <th style="text-align: center">Credit</th>
                                                                    <th style="text-align: center">Total</th>
                                                                </thead>
                                                                <tbody id="salespttbody"></tbody>
                                                                <tfoot id="salespttfoot"></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Ongoing Fiscal Year Sales Trends by POS</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getsalestrend()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table id="salestrendtbl" class="table table-hover-animation table-sm" style="width: 100%">
                                                                <thead>
                                                                    <th>POS</th>
                                                                    <th style="text-align: center">Pending</th>
                                                                    <th style="text-align: center">Checked</th>
                                                                    <th style="text-align: center">Confirmed</th>
                                                                    <th style="text-align: center">Void</th>
                                                                    <th style="text-align: center">Refund</th>
                                                                    <th style="text-align: center">Test</th>
                                                                    <th style="text-align: center">Cancelled</th>
                                                                    <th style="text-align: center">Total</th>
                                                                </thead>
                                                                <tbody id="salestbody"></tbody>
                                                                <tfoot id="salestfoot"></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Voucher Type by POS</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getsalesvtype()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table id="salesvouchertypetbl" class="table table-hover-animation table-sm" style="width: 100%">
                                                                <thead>
                                                                    <th>POS</th>
                                                                    <th style="text-align: center">Fiscal</th>
                                                                    <th style="text-align: center">Manual</th>
                                                                    <th style="text-align: center">Total</th>
                                                                </thead>
                                                                <tbody id="salesvttbody"></tbody>
                                                                <tfoot id="salesvttfoot"></tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Top 10 high value items</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getItemValsfn()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <canvas id="itmvalchart" height="125"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Top 10 high value items</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getItemValsfn()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Customer & Supplier</h4>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li>
                                                        <a data-action="reload" onclick="getsuppfn()"><i data-feather="rotate-cw"></i></a>
                                                    </li>
                                                    <li>
                                                        <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-responsive">
                                                            <table class="table-sm" style="width: 100%;">
                                                                <tr>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="customersval"></label></br>
                                                                        <label style="font-size: 12px;">Customers</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="supplierval"></label></br>
                                                                        <label style="font-size: 12px;">Suppliers</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="customersuppval"></label></br>
                                                                        <label style="font-size: 12px;">Customers & Suppliers</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="foreignersupp"></label></br>
                                                                        <label style="font-size: 12px;">Foreigner Suppliers</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="personsval"></label></br>
                                                                        <label style="font-size: 12px;">Persons</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="retailerval"></label></br>
                                                                        <label style="font-size: 12px;">Retailer</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="wholesellerval"></label></br>
                                                                        <label style="font-size: 12px;">Wholeseller</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="expirewholesellerval"></label></br>
                                                                        <label style="font-size: 12px;">Expired Wholeseller</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="blacklistval"></label></br>
                                                                        <label style="font-size: 12px;">Blacklist</label>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:33%;text-align:center;"></td>
                                                                    <td style="width:33%;text-align:center;">
                                                                        <label style="font-size: 25px;font-weight:bold;" id="inactiveval"></label></br>
                                                                        <label style="font-size: 12px;">Inactive & Blocked</label>
                                                                    </td>
                                                                    <td style="width:33%;text-align:center;"></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Items</h4>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li>
                                                                <a data-action="reload" onclick="getItemfn()"><i data-feather="rotate-cw"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table class="table-sm" style="width: 100%;">
                                                                        <tr>
                                                                            <td style="width:33%;text-align:center;">
                                                                                <label style="font-size: 25px;font-weight:bold;" id="localitemval"></label></br>
                                                                                <label style="font-size: 12px;">Local</label>
                                                                            </td>
                                                                            <td style="width:34%;text-align:center;">
                                                                                <label style="font-size: 25px;font-weight:bold;" id="importeditemval"></label></br>
                                                                                <label style="font-size: 12px;">Imported</label>
                                                                            </td>
                                                                            <td style="width:33%;text-align:center;">
                                                                                <label style="font-size: 25px;font-weight:bold;" id="inactiveitemval"></label></br>
                                                                                <label style="font-size: 12px;">Inactive</label>
                                                                            </td>
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
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Users</h4>
                                                    <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li>
                                                                <a data-action="reload" onclick="getItemfn()"><i data-feather="rotate-cw"></i></a>
                                                            </li>
                                                            <li>
                                                                <a data-action="collapse"><i data-feather="chevron-down"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="table-responsive">
                                                                    <table class="table-sm" style="width: 100%;">
                                                                        <tr>
                                                                            <td style="width:33%;text-align:center;">
                                                                                <label style="font-size: 25px;font-weight:bold;" id="malecntval"></label></br>
                                                                                <label style="font-size: 12px;">Male</label>
                                                                            </td>
                                                                            <td style="width:34%;text-align:center;">
                                                                                <label style="font-size: 25px;font-weight:bold;" id="femalecntval"></label></br>
                                                                                <label style="font-size: 12px;">Female</label>
                                                                            </td>
                                                                            <td style="width:33%;text-align:center;">
                                                                                <label style="font-size: 25px;font-weight:bold;" id="inactiveuserval"></label></br>
                                                                                <label style="font-size: 12px;">Inactive</label>
                                                                            </td>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    @endcan
@endsection

@section('scripts')
<script type="text/javascript">

    $(function () {
        cardSection = $('#page-block');
    });

    $(function () {
        storeSection = $('#storediv');
    });

    $(function () {
        itemSection = $('#itemdiv');
    });

    $(document).ready(function() {
        getsuppfn();
        getItemfn();
        getSalesfn();
        getSalesPie();
        getsalestrend();
        getsalesptype()
        getsalesvtype();
        getItemValsfn();
        getUserfn();
        getProfitMargin();
    });

    var getsuppfn = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getcustomersuppcnt',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                $.each(data.query, function(index, value) {
                    $('#supplierval').html(numformat(value.SupplierCount));
                    $('#customersval').html(numformat(value.CustomerCount));
                    $('#customersuppval').html(numformat(value.CustomerSuppCount));
                    $('#foreignersupp').html(numformat(value.ForeignSupplierCount));
                    $('#personsval').html(numformat(value.PersonCount));
                    $('#retailerval').html(numformat(value.RetailerCount));
                    $('#wholesellerval').html(numformat(value.WhollesellerCount));
                    $('#expirewholesellerval').html(numformat(value.ExpireWhollesellerCount));
                    $('#blacklistval').html(numformat(value.BlackListCount));
                    $('#inactiveval').html(numformat(value.InactiveCount));
                });
            },
        });
    }

    var getItemfn = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getitemcnt',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                $.each(data.query, function(index, value) {
                    $('#localitemval').html(numformat(value.LocalCount));
                    $('#importeditemval').html(numformat(value.ImportedCount));
                    $('#inactiveitemval').html(numformat(value.InactiveCount));
                });
            },
        });
    }

    var getUserfn = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getusercnt',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                $.each(data.query, function(index, value) {
                    $('#malecntval').html(numformat(value.MaleUserCount));
                    $('#femalecntval').html(numformat(value.FemaleUserCount));
                    $('#inactiveuserval').html(numformat(value.InactiveUserCount));
                });
            },
        });
    }

    var ctx_live = document.getElementById("chart");
    var dataFirst={};
    var dataFirst1={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst2={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst3={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst4={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst5={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst6={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst7={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst8={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst9={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst10={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var dataFirst11={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
    var mainData="";
    var chartOptions ="";
    var lineChart ="";
    var pos="";
    var colorsval="#00cfe8";
    var storeids=0;
    var subtotals=[0,0,0,0,0,0,0];
    var subtotals1=[];
    var subtotals2=[];
    var subtotals3=[];
    var dates=[];
    var compdate=[];
    var dt=[];
    var linecolor=["#00cfe8","#7367f0","#28c76f","#ff9f43","#ea5455","#2554C7","#728C00","#CD7F32","#FA8072","#872657","#93917C"];
    var idx=0;
    var cidx=18;
    var crdate="";
    var subtotalidx=0;
    var subtotalvalcomp=0;
    var subtotalcomp=0;

    var getSalesfn = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getsalescnt',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                idx=0;
                dataFirst1={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst2={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst3={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst4={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst5={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst6={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst7={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst8={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst9={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst10={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                dataFirst11={label:"",borderColor:"#FFFFFF",foreColor:"#FFFFFF"};
                storeids=0;
                cidx=18;
                colorsval="#00cfe8";
                subtotals=[0,0,0,0,0,0,0];
                $.each(data.query, function(index, value) {
                    subtotalvalcomp=value.LastDaysTotal;
                    if(parseInt(storeids)==parseInt(value.StoreId)){
                        window["dataFirst" + idx ] = {   //using a dynamic variable assignment to every POS
                            label: value.POS,
                            data: subtotals,
                            lineTension: 0,
                            fill: false,
                            borderColor: colorsval
                        };
                    }
                    if(parseInt(storeids)!=parseInt(value.StoreId)){
                        idx+=1;
                        cidx+=32;
                        if(parseInt(storeids)!=0){
                            subtotals=[0,0,0,0,0,0,0];
                            colorsval=linecolor[idx];
                        }    
                    }
                    storeids=value.StoreId;
                    var nxtdate=moment(value.CreatedDate,"YYYY-MM-DD").format('MMM-DD-YYYY');
                    compdate.push(value.CreatedDate);
                    var idxval = unique(compdate.sort()).indexOf(value.CreatedDate);
                    subtotals[idxval]=value.SubTotal;
                    dates.push(nxtdate);
                });
                
                if(parseFloat(subtotalidx)==0||parseFloat(subtotalvalcomp)!=parseFloat(subtotalcomp)){
                    mainData = {
                        labels: unique(dates.sort()),
                        datasets: [dataFirst1,dataFirst2,dataFirst3,dataFirst4,dataFirst5,dataFirst6,dataFirst7,dataFirst8,dataFirst9,dataFirst10,dataFirst11]
                    };
                    chartOptions = {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                filter: function( item, chart){                   
                                    if (item.text == "undefined" || item.text == "") {
                                    return false;
                                    }else{
                                    return item;
                                    }
                                },
                                boxWidth: 20,
                                fontColor: 'black'
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    userCallback: function(value, index, values) {
                                        value = value.toString();
                                        value = value.split(/(?=(?:...)*$)/);
                                        value = value.join(',');
                                        return value;
                                    },
                                }  
                            }]
                        },
                        plugins: {
                            datalabels: {
                                display:false,
                            },
                        },
                    };
                    lineChart = new Chart(ctx_live, {
                        type: 'line',
                        data: [],
                        options: []
                    });
                    lineChart.destroy();
                    lineChart = new Chart(ctx_live, {
                        type: 'line',
                        data: mainData,
                        options: chartOptions
                    });
                    subtotalidx+=1;
                    subtotalcomp=subtotalvalcomp;
                }
            },
        });
    }

    function unique(array)
    {
        var unique_arr=[];
        array.forEach(function(i,e)
        {
            if(unique_arr.indexOf(i)===-1) unique_arr.push(i);
        });
        return unique_arr;
    }

    var itm_val = document.getElementById("itmvalchart");
    //var itemval="";
    var choptions="";
    var datas="";
    var barChart="";
    var bardata={};
    var bardata1={label:"",borderColor:"#00cfe8",backgroundColor:"#FFFFFF"};
    var bardata2={label:"",borderColor:"#7367f0",backgroundColor:"#FFFFFF"};
    var bardata3={label:"",borderColor:"#28c76f",backgroundColor:"#FFFFFF"};
    var bardata4={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata5={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata6={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata7={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata8={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata9={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata10={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bardata11={label:"",borderColor:"#FFFFFF",backgroundColor:"#FFFFFF"};
    var bmainData="";
    var bchartOptions ="";
    var pos="";
    var bcolorsval="#00cfe8";
    var bstoreids=0;
    var itnames=[];
    var valuedata=[];
    var compdate=[];
    var dt=[];
    var dynamicvals=[0,0,0,0,0,0,0,0,0,0];
    var dynamicitem=["","","","","","","","","",""];
    var barcolor=["#00cfe899","#7367f099","#28c76f99","#ff9f4399","#ea545599","#2554C799","#728C0099","#CD7F3299","#FA807299","#87265799","#93917C99"];
    var bidx=0;
    var cidx=18;
    var stotalid=0;
    var stotalitmval=0;
    var stotalitmvalin=0;
    var getItemValsfn = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getitemval',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                itnames=[];
                valuedata=[];
                stotalitmvalin=data.totalval.toFixed(2);
                $.each(data.query, function(index, value) {
                    valuedata.push(value.InventoryValue);
                    itnames.push(value.ItemName);
                });
                if(parseFloat(stotalid)==0||parseFloat(stotalitmval)!=parseFloat(stotalitmvalin)){
                    bardata1 = {   //using a dynamic variable assignment to every bar
                        label:"",
                        data:valuedata,
                        borderColor:barcolor,
                        // backgroundColor:barcolor,
                        barThickness:47,
                        borderWidth: 250,
                        borderRadius: 15,
                        borderSkipped: false,
                    };
                    choptions = {
                        legend: {
                            display: false,
                            position: 'bottom',
                            labels: {
                                boxWidth: 20,
                                fontColor: 'black'
                            },
                        },
                        plugins: {
                            datalabels: {
                                display:false,
                            },
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display:true
                                },
                                ticks: {
                                    display:true,
                                    autoSkip: false,
                                    maxRotation: 90,
                                    minRotation: 90,
                                    padding: -215,
                                    fontStyle: "bold",
                                }  
                            }],
                            yAxes: [{
                                gridLines: {
                                    display:true
                                },  
                                ticks: {
                                   
                                    userCallback: function(value, index, values) {
                                        value = value.toString();
                                        value = value.split(/(?=(?:...)*$)/);
                                        value = value.join(',');
                                        return value;
                                    },
                                    mirror:false,
                                }  
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function(tooltipItem, data) {
                                    var value = data.datasets[0].data[tooltipItem.index];
                                    return "Values : "+numformat(value.toFixed(2))+" ETB";
                                }
                            }
                        }, 
                    };
                    const itemval = {
                        labels:itnames,
                        datasets: [bardata1]
                    };
                    barChart = new Chart(itm_val, {});
                    barChart.reset();
                    barChart.destroy();
                    barChart = new Chart(itm_val, {
                        responsive: true,
                        type: 'bar',
                        data: itemval,
                        options: choptions
                    });
                    stotalid+=1;
                    stotalitmval=stotalitmvalin;
                }
            },
        });
    }
    
    var pieval = document.getElementById("todayspie");
    var piedata1={};
    var piedatas=[];
    var pielabel=[];
    var pieoptions="";
    var totalresults=0;
    var totalresultsdb=0;
    var piecolor=["#2085ec","#72b4eb","#0a417a","#8464a0","#cea9bc","#323232","#CD7F32","#FA8072","#872657","#93917C"];
    var getSalesPie = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/gettodaysales',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                piedatas=[];
                pielabel=[];
                totalresultsdb=0;
                $.each(data.query, function(index, value) {
                    piedatas.push(value.SubTotal);
                    pielabel.push(value.POS);
                    totalresultsdb=value.TodaysTotal;// to calculate total revenue for percetage calculation
                });
                if(parseFloat(totalresults)!=parseFloat(totalresultsdb)){
                    //pie chart data
                    piedata1 = {
                        labels:pielabel,
                        datasets: [
                        {
                            label: "Todays Sales",
                            data: piedatas,
                            backgroundColor: piecolor,
                            borderColor: piecolor,
                        }]
                    };
                    //options
                    pieoptions = {
                        responsive: true,
                        legend: {
                            display: true,
                            position: "right",
                            labels: {
                                fontColor: "black",
                                boxWidth: 20,
                            }
                        },
                        plugins: {
                            datalabels: {
                                display:true,
                                formatter: (value) => {
                                    var percentageval=0;
                                    percentageval=(parseFloat(value)/parseFloat(totalresultsdb))*100;
                                    return numformat(value)+" \n ("+percentageval.toFixed(2)+" %)";
                                },
                                color: '#ffffff',
                                font: {
                                    weight: 'bold',
                                }
                            },
                        },
                    };
                    //create Chart class object
                    var chart1 = new Chart(pieval, {});
                    chart1.reset();
                    chart1.destroy();
                    var chart1 = new Chart(pieval, {
                        type: "pie",
                        data: piedata1,
                        options: pieoptions
                    });
                    totalresults=totalresultsdb;
                }
            },
        });
    }

    var pntotal=0,chtotal=0,cototal=0,vototal=0,rftotal=0,tetotal=0,catotal=0;
    var pntotaldb=0,chtotaldb=0,cototaldb=0,vototaldb=0,rftotaldb=0,tetotaldb=0,catotaldb=0,totalvaldb=0;
    var tbodyvar="",tfootvar="";
    var getsalestrend = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getsalestr',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                tbodyvar="",tfootvar="";
                totalvaldb=0;
                $.each(data.query, function(index, value) {
                   pntotaldb=value.PendingTotalCount;
                   chtotaldb=value.CheckedTotalCount;
                   cototaldb=value.ConfirmedTotalCount;
                   vototaldb=value.VoidTotalCount;
                   rftotaldb=value.RefundTotalCount;
                   tetotaldb=value.TestTotalCount;
                   catotaldb=value.CancelTotalCount;
                   totalvaldb+=parseFloat(value.TotalCount);
                   tbodyvar+='<tr style="font-weight:bold;"><td style="color:#4b4b4b">'+value.POS+'</td><td style="text-align:center;color:#ff9f43">'+numformat(value.PendingCount)+'</td><td style="text-align:center;color:#4e73df">'+numformat(value.CheckedCount)+'</td><td style="text-align:center;color:#1cc88a">'+numformat(value.ConfirmedCount)+'</td><td style="text-align:center;color:#e74a3b">'+numformat(value.VoidCount)+'</td><td style="text-align:center;color:#82868b">'+numformat(value.RefundCount)+'</td><td style="text-align:center;color:#e74a3b">'+numformat(value.TestCount)+'</td><td style="text-align:center;color:#e74a3b">'+numformat(value.CancelledCount)+'</td><td style="text-align:center;color:#00cfe8">'+numformat(value.TotalCount)+'</td></tr>';
                   tfootvar='<tfoot><tr style="font-weight:bold;"><td style="color:#4b4b4b;text-align:right;">Total </td><td style="text-align:center;background-color:#ff9f43;color:#ffffff">'+numformat(value.PendingTotalCount)+'</td><td style="text-align:center;background-color:#4e73df;color:#ffffff">'+numformat(value.CheckedTotalCount)+'</td><td style="text-align:center;background-color:#1cc88a;color:#ffffff">'+numformat(value.ConfirmedTotalCount)+'</td><td style="text-align:center;background-color:#e74a3b;color:#ffffff">'+numformat(value.VoidTotalCount)+'</td><td style="text-align:center;background-color:#82868b;color:#ffffff">'+numformat(value.RefundTotalCount)+'</td><td style="text-align:center;background-color:#e74a3b;border-right-style:solid;border-right-color:#ffffff;border-right-width:0.15em;color:#ffffff">'+numformat(value.TestTotalCount)+'</td><td style="text-align:center;background-color:#e74a3b;color:#ffffff">'+numformat(value.CancelTotalCount)+'</td><td style="text-align:center;background-color:#00cfe8;color:#ffffff">'+numformat(totalvaldb)+'</td></tr></tfoot>';
                });
                if(parseFloat(pntotal)!=parseFloat(pntotaldb) || parseFloat(chtotal)!=parseFloat(chtotaldb) || parseFloat(cototal)!=parseFloat(cototaldb) || parseFloat(vototal)!=parseFloat(vototaldb) || parseFloat(rftotal)!=parseFloat(rftotaldb) || parseFloat(tetotal)!=parseFloat(tetotaldb)|| parseFloat(catotal)!=parseFloat(catotaldb)){
                    $('#salestrendtbl tbody').empty();
                    $('#salestrendtbl tfoot').empty();
                    $('#salestrendtbl').append(tbodyvar);
                    $('#salestrendtbl').append(tfootvar);
                    pntotal=pntotaldb;
                    chtotal=chtotaldb;
                    cototal=cototaldb;
                    vototal=vototaldb;
                    rftotal=rftotaldb;
                    tetotal=tetotaldb;
                    catotal=catotaldb;
                }
            },
        });
    }

    var catotal=0,crtotal=0,catotalft=0,crtotalft=0;
    var catotaldb=0,crtotaldb=0,totalvaldbpt=0;;
    var tbodyvarpt="",tfootvarpt="";
    var getsalesptype = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getsalespt',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                tbodyvarpt="",tfootvarpt="";
                catotalft=0,crtotalft=0;
                totalvaldbpt=0;
                $.each(data.query, function(index, value) {
                   catotaldb=value.CashCount;
                   crtotaldb=value.CreditCount;
                   totalvaldbpt+=parseFloat(value.TotalCount);
                   catotalft+=parseFloat(value.CashCount);
                   crtotalft+=parseFloat(value.CreditCount);
                   tbodyvarpt+='<tr style="font-weight:bold;"><td style="color:#4b4b4b">'+value.POS+'</td><td style="text-align:center;color:#1cc88a">'+numformat(value.CashCount)+'</td><td style="text-align:center;color:#4e73df">'+numformat(value.CreditCount)+'</td><td style="text-align:center;color:#00cfe8">'+numformat(value.TotalCount)+'</td></tr>';
                   tfootvarpt='<tfoot><tr style="font-weight:bold;"><td style="color:#4b4b4b;text-align:right;">Total</td><td style="text-align:center;background-color:#1cc88a;color:#ffffff">'+numformat(catotalft)+'</td><td style="text-align:center;background-color:#4e73df;color:#ffffff">'+numformat(crtotalft)+'</td><td style="text-align:center;background-color:#00cfe8;color:#ffffff">'+numformat(totalvaldbpt)+'</td></tr></tfoot>';
                });
                if(parseFloat(catotal)!=parseFloat(catotaldb) || parseFloat(crtotal)!=parseFloat(crtotaldb)){
                    $('#salespaymenttbl tbody').empty();
                    $('#salespaymenttbl tfoot').empty();
                    $('#salespaymenttbl').append(tbodyvarpt);
                    $('#salespaymenttbl').append(tfootvarpt);
                    catotal=catotaldb;
                    crtotal=crtotaldb;
                }
            },
        });
    }

    var frtotal=0,mrtotal=0,frtotalft=0,mrtotalft=0;
    var frtotaldb=0,mrtotaldb=0,totalvaldbvt=0;;
    var tbodyvarvt="",tfootvarvt="";
    var getsalesvtype = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getsalesvt',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                tbodyvarvt="",tfootvarvt="";
                totalvaldbvt=0;
                $.each(data.query, function(index, value) {
                   frtotaldb=value.FiscalCount;
                   mrtotaldb=value.ManualCount;
                   totalvaldbvt+=parseFloat(value.TotalCount);
                   frtotalft+=parseFloat(value.FiscalCount);
                   mrtotalft+=parseFloat(value.ManualCount);
                   tbodyvarvt+='<tr style="font-weight:bold;"><td style="color:#4b4b4b">'+value.POS+'</td><td style="text-align:center;color:#1cc88a">'+numformat(value.FiscalCount)+'</td><td style="text-align:center;color:#4e73df">'+numformat(value.ManualCount)+'</td><td style="text-align:center;color:#00cfe8">'+numformat(value.TotalCount)+'</td></tr>';
                   tfootvarvt='<tfoot><tr style="font-weight:bold;"><td style="color:#4b4b4b;text-align:right;">Total</td><td style="text-align:center;background-color:#1cc88a;color:#ffffff">'+numformat(frtotalft)+'</td><td style="text-align:center;background-color:#4e73df;color:#ffffff">'+numformat(mrtotalft)+'</td><td style="text-align:center;background-color:#00cfe8;color:#ffffff">'+numformat(totalvaldbvt)+'</td></tr></tfoot>';
                });
                if(parseFloat(frtotal)!=parseFloat(frtotaldb) || parseFloat(mrtotal)!=parseFloat(mrtotaldb)){
                    $('#salesvouchertypetbl tbody').empty();
                    $('#salesvouchertypetbl tfoot').empty();
                    $('#salesvouchertypetbl').append(tbodyvarvt);
                    $('#salesvouchertypetbl').append(tfootvarvt);
                    frtotal=frtotaldb;
                    mrtotal=mrtotaldb;
                }
            },
        });
    }

    var circlechart = document.getElementById("chartProgress");
    var totalpermargin=0,updatedmargin=0;
    var getProfitMargin = function(){
        var registerForm = $("#dashboardform");
        var formData = registerForm.serialize();
        $.ajax({
            url: '/getprmargin',
            type:'POST',
            data:formData,
            cache: false,
            success:function(data)
            {
                updatedmargin=data.perc;
                if(parseFloat(updatedmargin)!=parseFloat(totalpermargin)){
                    var myChartCircle = new Chart(circlechart, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                            label: 'Gross Profit Margin as of Today',
                            percent: updatedmargin.toFixed(2),
                            backgroundColor: ['#ff9f43']
                            }]
                        },
                        plugins: [{
                            beforeInit: (chart) => {
                                const dataset = chart.data.datasets[0];
                                chart.data.labels = [dataset.label];
                                dataset.data = [dataset.percent, 100 - dataset.percent];
                            }
                            },
                            {
                            beforeDraw: (chart) => {
                                var width = chart.chart.width,
                                height = chart.chart.height,
                                ctx = chart.chart.ctx;
                                ctx.restore();
                                var fontSize= 20;
                                var fontweight='bold';
                                ctx.font = fontSize + "px Montserrat";
                                ctx.fillStyle = "#ff9f43 ";
                                ctx.textBaseline = "middle";
                                var text = chart.data.datasets[0].percent + " %",
                                textX = Math.round((width - ctx.measureText(text).width) / 2),
                                textY = height / 2;
                                ctx.fillText(text, textX, textY);
                                ctx.save();
                            }
                            }
                        ],
                        options: {
                            maintainAspectRatio: false,
                            cutoutPercentage: 70,
                            rotation: Math.PI / 2,
                            legend: {
                                display: false,
                            },
                            tooltips: {
                                filter: tooltipItem => tooltipItem.index == 0
                            },
                            plugins: {
                                datalabels: {
                                    display:false,
                                },
                            },
                        }
                    });
                    totalpermargin=updatedmargin;
                }
            },
        });
    }

    // setInterval(getsuppfn, 5000);
    // setInterval(getItemfn, 5000);
    // setInterval(getSalesfn, 5000);
    // setInterval(getItemValsfn, 5000);
    // setInterval(getsalestrend, 5000);
    // setInterval(getSalesPie, 5000);
    // setInterval(getsalesptype, 5000);
    // setInterval(getsalesvtype, 5000);
    // setInterval(getProfitMargin, 10000);

    function numformat(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
            val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
    }


</script>
@endsection