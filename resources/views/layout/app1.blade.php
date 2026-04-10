<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/fonts.css') }}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/ui-feather.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/selectpicker/css/bootstrap-select.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/selectpicker/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('customcss/fixedHeader.dataTables.min.css') }}" />
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-file-uploader.css') }}">
   
    <link rel="stylesheet" href="{{ asset('customcss/jquery.timepicker.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fontawesome/css/fontawesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fontawesome/css/all.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/fontawesome6/pro/css/all.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/toaster/toastr.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/toaster/toastr.js')  }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('customcss/quill.snow.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('customcss/tableexport.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/jstree.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/extensions/ext-component-tree.css') }}">

  {{-- <link href="jquery-explr-VERSION.css" rel="stylesheet"> --}}

  <!-- END: Page CSS-->
    {{-- css data picker --}}

    {{-- end css date picker --}}

  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/daterangepicker.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/jsPlumb.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/main.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/tree_maker.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/jquerysctipttop.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/jquery.timeselector.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/imagepreview.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/cardcustom.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/style.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/jquery.schedule.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/jquery.skedTape.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/hummingbird-treeview.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/fixedColumns.dataTables.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/payroll-tree.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/sweetalert2.min.css') }}">
  {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/jquery-explr-1.4.css') }}">
  {{-- <link rel="stylesheet" type="text/css" href="{{ asset('customcss/custom-datatable.css') }}" /> --}}

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fperucic/treant-js/Treant.css">
  <!-- BEGIN: Custom CSS-->

  <link href="{{ asset('app-assets/css/multiselect.css') }}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css"/>

  @yield('styles')

  <style>

    table.dataTable span.highlight {
        background-color: #FFFF88; 
    }

    table.dataTable tbody tr.selected {
        background-color: #E2E1E1; 
    }

    table.dataTable tbody tr.removezero {
       display: none;
    }

    .display {
        font-size: 12px;
    }

    .d-flex {
        font-size: 13px;
    }

    .table {
        font-size: 12px;
    }

    .dataTables_scrollBody::-webkit-scrollbar {
        height:8px;
        width:8px;
    }

    .dataTables_scrollBody::-webkit-scrollbar-track {
        -webkit-box-shadow:inset 0 0 2px rgba(0,0,0,0.3); 
        border-radius:5px;
    }

    .dataTables_scrollBody::-webkit-scrollbar-thumb:horizontal{
        border-radius:5px;
        height: 1px;
        -webkit-box-shadow: inset 0 0 12px #82868b !important; 
    }

    .dataTables_scrollBody::-webkit-scrollbar-thumb:vertical{
        border-radius:5px;
        width: 1px;
        overflow: hidden;
        -webkit-box-shadow: inset 0 0 12px #82868b !important; 
    }

    .dataTables_scrollBody.scrollmenu a:hover {
        background-color: #82868b;
    }

    .dataTables_scrollBody:hover {
        overflow-x: scroll;
        overflow-y: scroll;
    }

    .dataTables_scrollBody {
        min-height: 250px !important;
    }

    .scroll::-webkit-scrollbar {
        height:8px;
    }

    .scroll::-webkit-scrollbar-track {
        -webkit-box-shadow:inset 0 0 2px rgba(0,0,0,0.3); 
        border-radius:5px;
    }

    .scroll::-webkit-scrollbar-thumb:horizontal{
        border-radius:5px;
        height: 1px;
        -webkit-box-shadow: inset 0 0 12px #82868b !important; 
    }

    .scroll.scrollmenu a:hover {
        background-color: #82868b;
    }

    .scrollhor::-webkit-scrollbar {
        width:8px;
        padding: 0px 0px 0px 0px;
    }

    .scrollhor::-webkit-scrollbar-track {
        -webkit-box-shadow:inset 0 0 2px rgba(0,0,0,0.3); 
        border-radius:5px;
    }

    .scrollhor::-webkit-scrollbar-thumb:vertical{
        border-radius:5px;
        -webkit-box-shadow: inset 0 0 12px #82868b !important; 
    }

    .scrollhor.scrollmenu a:hover {
        background-color: #82868b;
    }

    .scrollver::-webkit-scrollbar {
        width:1px;
        padding: 0px 0px 0px 0px;
    }

    .scrollver::-webkit-scrollbar-track {
        -webkit-box-shadow:inset 0 0 2px rgba(0,0,0,0.3); 
        border-radius:5px;
    }

    .scrollver::-webkit-scrollbar-thumb:vertical{
        border-radius:5px;
        -webkit-box-shadow: inset 0 0 12px #82868b !important; 
    }

    .scrollver.scrollmenu a:hover {
        background-color: #82868b;
    }

    .scrdiv{
        overflow: hidden;
    }

    .scrdiv:hover {
        overflow-x: scroll;
    }

    .scrdivhor{
        overflow: hidden;
    }

    .scrdivhor:hover {
        overflow-y: scroll;
    }

    .popover {
        max-width: 1000px;
        width: auto;
    }

    fieldset {
        border: 0.5px solid #D3D3D3 !important;
        border-radius: 5px;
        padding: 15px;
    }

    fieldset legend {
        color: #696969 !important;
        padding: 5px 10px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        box-shadow: 0 0 0 1px white;
        margin-left: 20px;
    }

    .fset {
        border: 0.5px solid #D3D3D3 !important;
        border-radius: 5px;   
        padding: 15px;
    }

    .fset legend {
        color: #696969 !important;
        background-color: #F8F8F8;
        padding: 5px 10px ;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        box-shadow: 0 0 0 1px #D3D3D3;
        margin-left: 20px;
    }

    .appiddrp {
        width: 80% !important;
    }

    .commprp {
        width: 40% !important;
    }

    .cusmidprp {
        width: 30% !important;
    }

    .cusprop {
        width: 20% !important;
    }

    .dynamicselect2 {
        width: 50% !important;
    }
    
    .select2width {
        width: 100% !important;
    }



    .truncate {
        max-width:130px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .rtable th {
        text-align: center;
        background: #f8f8f8;
        padding: 6px 6px 6px 6px;
        border: 0.1px solid #d9d7ce;
    }

    .rtable td {
        padding: 0px 0px;
        border: 0.1px solid #d9d7ce;
    }

    .custom-buttons{
        padding-right: 15px !important;
        padding-top: 15px !important;
        text-align: right;
    }

    .custom-buttons2{
        padding-right: 15px !important;
        padding-top: 15px !important;
        text-align: right;
    }

    .left-dom{
        padding-left: 15px !important;
        padding-top: 10px !important;
        text-align: left;
        margin-top: 5px;
    }

    .report_table th {
        text-align: center;
        background: #f8f8f8;
        padding: 6px 6px 6px 6px;
        border: 0.1px solid #000000;
    }

    .report_table td {
        padding: 0px 0px;
        border: 0.1px solid #000000;
    }

    .cbegtable tr {
        padding: 1px 1px;
        border: 0.1px solid #d9d7ce;
    }

    .infotbl tr td label{
        padding: 0px;
        margin: 0px 0px 0.1rem !important;
        border-collapse: collapse;
    }

    .infotbl td:first-child {
        white-space: nowrap; /* Keep label on one line */
        padding-right: 10px; /* Fixed gap */
    }

    .infotbl td:last-child {
        width: 100%; /* Take remaining space */
    }
    
    .tdselect2{
        white-space: nowrap;
        max-width: 67px;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .tblheadercls{
        background:white;
    }
    .datatableHeaderPadding {
        padding:0px 0px 0px 0px;
    }
    .infodatatbl thead tr th{
        padding:0px 0px 0px 7px;
        text-align: left;
    }
    .infodatatbl tfoot tr th{
        padding:0px 0px 0px 7px;
        text-align: left;
    }

    .defaultdatatable thead tr th{
        padding-left: 7px;
        text-align: left;
    }

    .text-style {
        font-size: 11px;
        text-align: left !important;
        padding-left: 2px !important;
    }

    .display thead{
        background-color: #F3F4F6;
    }
    .display thead th{
        background: linear-gradient(145deg, #F3F4F6 0%, #e2e4e9 100%);
        border-bottom: 1px solid #dcdfe4;
        border-right: 1px solid #e9ebef;
        /* border: 1px solid #D1D5DB; */
    }
    .display tbody td{
        max-width: 10ch;      /* ~10 characters */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media print{
        body *{
            visibility: hidden;
        }

        #saleReportDatatables, #saleReportDatatables *{
            visibility: visible;
        }

        .shortcut-buttons-flatpickr-buttons {
            justify-content: center;
            width: 100%;
        }
    }

    td.details-control {
        background: url(https://www.datatables.net/examples/resources/details_open.png) no-repeat center center;
        cursor: pointer;
        transition: .5s;
    }

    tr.shown td.details-control {
        background: url(https://www.datatables.net/examples/resources/details_close.png) no-repeat center center;

        transition: .5s;
    }

    td.details-control1 {
        background: url(https://www.datatables.net/examples/resources/details_open.png) no-repeat center center;
        cursor: pointer;

        transition: .5s;
    }

    tr.shown td.details-control1 {
        background: url(https://www.datatables.net/examples/resources/details_close.png) no-repeat center center;

        transition: .5s;
    }

    td.details-control2 {
        background: url(https://www.datatables.net/examples/resources/details_open.png) no-repeat center center;
        cursor: pointer;

        transition: .5s;
    }

    tr.shown td.details-control2 {
        background: url(https://www.datatables.net/examples/resources/details_close.png) no-repeat center center;
        width:0px
        transition: .5s;
    }

    .fee-col {
        text-align: right;
        width:8%;
    }

    .label-col {
        text-align: left;
        width:32%;
    }
    .label-col2 {
        text-align: left;
        width:31%;
    }
    .label-col3 {
        text-align: left;
        width:30%;
    }

    tr.shown td {
        background-color: lightgrey !important;
        transition: .5s;
        font-weight: 800
    }

    td.invoice-date {
        background-color: rgba(237, 205, 255, .2);
        width:100px;
    }
    td.invoice-author {
        background-color: rgba(237, 205, 255, .2);
        width:100px;
    }
    td.invoice-notes {
        background-color: rgba(237, 205, 255, .2);
        white-space: normal !important;
    }
    .input-group > .select2-container{
        width: auto !important;
        flex: 1 1 auto !important;
    }

    .highlightsearch {
        background-color: yellow;
    }

    #tbodydata tr {
        transition: background-color 0.3s ease;
    }

    /* Style for focused rows on hover */
    #tbodydata tr:hover {
        background-color: #f0f0f0;
    }

    /* Style for focused rows */
    #tbodydata tr:focus {
        background-color: #e0e0e0;
        outline: none; /* Remove default focus outline */
    }

    #adjustment_header_tbl tr td {
        padding: 0rem 0rem;
    }

    .selectpicker:focus, 
        .dropdown-toggle:focus {
            outline: none !important;
            box-shadow: none !important;
        }

    .strclass {
        width: 100%;
        height: auto;
        overflow: auto;
    }

    .google-visualization-orgchart-node {
        border: none !important;
        background: transparent !important;
        box-shadow: none !important;
        min-width: 10px !important;
        padding: 1px !important;
    }

    .google-visualization-orgchart-table {
        transform: scale(0.8); /* Scale down the whole tree */
        transform-origin: top left;
    }

    .strclass table tr td {
        border-color: #00cfe8 !important;
        border-width: 2px !important;
    }

    .serhighlight {
      box-shadow: 0 0 10px 3px #28a745;
    }

    .google-visualization-orgchart-lineleft,
    .google-visualization-orgchart-lineright,
    .google-visualization-orgchart-linetop,
    .google-visualization-orgchart-linebottom {
        border-color: #ccc !important; /* or change this to your preferred line color */
    }

    .google-visualization-orgchart-linenode{
        max-width: 2px !important;
    }
    
    </style>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    <script>
        window.Laravel.userId = {{auth()->user()->id}}
        
    </script>
    <script type="text/javascript" src="{{ asset('app-assets/js/helpers.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/template-customizer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/config.js') }}"></script>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern menu-expanded pace-done footer-fixed navbar-sticky" data-open="click" data-menu="vertical-menu-modern" data-col="" id="page-block">
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center navbar-light navbar-shadow fixed-top fit-content" id="navbar">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i
                                class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">

                </ul>
                <ul class="nav navbar-nav">

                </ul>
            </div>
            <div class="row justify-content-md-center" style="margin-left:1%;margin-right:auto;display:block;">
                <h1 style="color:#7367f0"><b>{{ Session::get('companyName') }}</b></h1>
            </div>
            <ul class="nav navbar-nav align-items-center ml-auto">
                <div id="app">
                    <example-component :userid="{{ auth()->id() }}" :unreads="{{ auth()->user()->unreadNotifications }}"></example-component>
                </div>
                <a class="customizer-toggle d-flex align-items-center justify-content-center"
                    href="javascript:void(0);"><i class="spinners" data-feather="settings"></i></a>
                <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                            data-feather="moon"></i></a></li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                        id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span
                            class="user-name font-weight-bolder">{{ Auth::user()->username }}</span><span
                            class="user-status"></span></div><span class="avatar"><img
                            class="round"
                            src="../../../../app-assets/images/portrait/small/default-profile-pic.jpg" alt="avatar"
                            height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">
                        <a class="dropdown-item" href="profile"><i class="mr-50" data-feather="user"></i>Profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mr-50" data-feather="power"></i> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                        {{-- <a class="dropdown-item" href="page-auth-login-v2"><i class="mr-50" data-feather="power"></i> Logout</a> --}}
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <ul class="main-search-list-defaultlist d-none">
        <li class="d-flex align-items-center"><a href="javascript:void(0);">
                <h6 class="section-label mt-75 mb-0">Files</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/xls.png" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small
                            class="text-muted">Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/jpg.png" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd
                            Developer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/pdf.png" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital
                            Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100"
                href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/doc.png" alt="png"
                            height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web
                            Designer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a href="javascript:void(0);">
                <h6 class="section-label mt-75 mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg"
                            alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg"
                            alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd
                            Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg"
                            alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital
                            Marketing Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100"
                href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg"
                            alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web
                            Designer</small>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion justify-content-between"><a
                class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="mr-75"
                        data-feather="alert-circle"></span><span>No results found.</span></div>
            </a></li>


    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="/ims">
                        <span class="brand-logo">

                        </span>
                        <h2 class="brand-text">IMS</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                            class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary"
                            data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                @if (auth()->user()->can('sales-show') || auth()->user()->can('sale-holdView'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                data-feather="shopping-bag"></i><span class="menu-title text-truncate"
                                data-i18n="Sales & Marketing">Salesss & Marketing</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @if (auth()->user()->can('sales-show') || auth()->user()->can('sale-holdView'))
                                <li>
                                    <a class="d-flex align-items-center" href="sales"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="Sales">Sales</span></a>
                                </li>
                            @endif
                            <li>
                                <a class="d-flex align-items-center" href="proforma"><i data-feather="circle"></i><span
                                        class="menu-item text-truncate" data-i18n="Proforma">Proforma</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Receiving-View') ||
                    auth()->user()->can('Hold-View') ||
                    auth()->user()->can('Requisition-View') ||
                    auth()->user()->can('Transfer-View') ||
                    auth()->user()->can('Approver-Transfer-View') ||
                    auth()->user()->can('Approver-Requisition-View') ||
                    auth()->user()->can('Issue-Transfer-View') ||
                    auth()->user()->can('Issue-Requisition-View') ||
                    auth()->user()->can('Adjustment-View') ||
                    auth()->user()->can('Begining-View') ||
                    auth()->user()->can('Commodity-Beginning-View') ||
                    auth()->user()->can('Commodity-StockBalance-View') ||
                    auth()->user()->can('StoreBalance-View') ||
                    auth()->user()->can('Dispatch-View') ||
                    auth()->user()->can('DeadStock-View'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                data-feather="home"></i><span class="menu-title text-truncate"
                                data-i18n="Inventory">Inventory</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @if (auth()->user()->can('Receiving-View') || auth()->user()->can('Hold-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="receiving"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="GoodsReceiving">Goods Receiving</span></a>
                                </li>
                            @endif
                            @can('Requisition-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="requisition"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="StoreRequisition ">Store Requisition</span></a>
                                </li>
                            @endcan
                            @can('Transfer-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="transfer"><i data-feather="circle"></i><span
                                            class="menu-item text-truncate" data-i18n="StoreTransfer ">Store
                                            Transfer</span></a>
                                </li>
                            @endcan
                            @if (auth()->user()->can('Approver-Transfer-View') || auth()->user()->can('Approver-Requisition-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="approver"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="StoreApprover">Store Approver</span></a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Issue-Transfer-View') ||auth()->user()->can('Issue-Requisition-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="issue"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="Issue">Store Issue</span></a>
                                </li>
                            @endif
                            @can('Adjustment-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="adjustment"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="StoreAdjustment">Store Adjustment</span></a>
                                </li>
                            @endcan
                            @can('Begining-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="begining"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="StoreBegining">Store Beginning</span></a>
                                </li>
                            @endcan
                            @can('Begining-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="ending"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Ending">Ending</span></a>
                                </li>
                            @endcan
                            @can('Commodity-Beginning-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="commoditybeg"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Commodity Beginning">Commodity Beginning</span></a>
                                </li>
                            @endcan
                            @can('Commodity-StockBalance-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="comstockbalance"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Commodity Stock Balance">Commodity Stock Balance</span></a>
                                </li>
                            @endcan
                            @can('StoreBalance-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="stockbalance"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="Store Balance">Store Balance</span></a>
                                </li>
                            @endcan
                            @can('Dispatch-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="dispatch"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dispatch">Dispatch</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                
                @if (auth()->user()->can('DeadStock-View') || auth()->user()->can('Direct-StockIN-View') || auth()->user()->can('Direct-StockOUT-View') || auth()->user()->can('DS-Beginning')||auth()->user()->can('DS-Inventory-Movement')||auth()->user()->can('DS-Store-Balance')||auth()->user()->can('DS-Inventory-Value')||auth()->user()->can('DS-General-PullOut')||auth()->user()->can('DS-General-HandIn'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="DS">D S</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @can('Direct-StockIN-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="dstockin"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Stock-IN">Stock-IN</span></a>
                                </li>
                            @endcan
                            @can('Direct-StockOUT-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="dstockout"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Stock-OUT">Stock-OUT</span></a>
                                </li>
                            @endcan
                            @can('DS-Balance-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="dstockbalance"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Stock Balance">Stock Balance</span></a>
                                </li>
                            @endcan
                            @can('DeadStock-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="deadstock"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="DS I">DS I</span></a>
                                </li>
                            @endcan
                            @can('DS-Beginning')
                                <li>
                                    <a class="d-flex align-items-center ref" href="dsbegining"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="DS Begining">DS Begining</span></a>
                                </li>
                            @endcan
                            @if (auth()->user()->can('DS-Inventory-Movement')||auth()->user()->can('DS-Store-Balance')||auth()->user()->can('DS-Inventory-Value')||auth()->user()->can('DS-General-PullOut')||auth()->user()->can('DS-General-HandIn'))
                                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                                data-feather="file"></i><span class="menu-title text-truncate"
                                                data-i18n="DS Report">DS Report</span><span
                                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                                    <ul class="menu-content">
                                        @can('DS-General-PullOut')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsgenpo"><span class="menu-item text-truncate" data-i18n="DS General PullOut Report">DS General PullOut Report</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-General-HandIn')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsgenhi"><span class="menu-item text-truncate" data-i18n="DS General HandIn Report">DS General HandIn Report</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-Inventory-Movement')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsmovement"><span class="menu-item text-truncate" data-i18n="DS Item Movement Report">DS Item Movement Report</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-Store-Balance')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsbalance"><span class="menu-item text-truncate" data-i18n="DS Store Balance Report">DS Store Balance Report</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-Inventory-Value')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsvalue"><span class="menu-item text-truncate" data-i18n="DS Inventory Value Report">DS Inventory Value Report</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-ItemRank-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsitemrank"><span class="menu-item text-truncate" data-i18n="DS Rank By Item">DS Rank By Item</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-CustomerRank-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dscusrank"><span class="menu-item text-truncate" data-i18n="DS Rank By Customer">DS Rank By Customer</span></a>
                                            </li>
                                        @endcan
                                        @can('DS-FSNAnalysis-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="dsfsn"><span class="menu-item text-truncate" data-i18n="DS FSN Analysis">DS FSN Analysis</span></a>
                                            </li>
                                        @endcan
                                        @if (auth()->user()->can('DS-PLGeneral-View') ||auth()->user()->can('DS-PLByCustomer-View') || auth()->user()->can('DS-PLByItem-View') || auth()->user()->can('DS-PLByPointofSales-View'))
                                            <ul class="menu-content">
                                                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                                            data-feather="file"></i><span class="menu-title text-truncate"
                                                            data-i18n="financialreport">DS P&L Report</span><span
                                                            class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                                                    <ul class="menu-content">
                                                        @can('DS-PLGeneral-View')
                                                            <li>
                                                                <a class="d-flex align-items-center ref" href="{{url('dsplreport')}}"><i
                                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                                        data-i18n="DS PL General Report">DS P&L General</span></a>
                                                            </li>
                                                        @endcan
                                                        @can('DS-PLByPointofSales-View')
                                                            <li>
                                                                <a class="d-flex align-items-center ref" href="{{url('dsplreportsum')}}"><i
                                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                                        data-i18n="DS PL By POS">DS P&L By POS</span></a>
                                                            </li>
                                                        @endcan
                                                        @can('DS-PLByCustomer-View')
                                                            <li>
                                                                <a class="d-flex align-items-center ref" href="{{url('dsplreportcus')}}"><i
                                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                                        data-i18n="DS PL By Customer">DS P&L By Customer</span></a>
                                                            </li>
                                                        @endcan
                                                        @can('DS-PLByItem-View')
                                                            <li>
                                                                <a class="d-flex align-items-center ref" href="{{url('dsplreportitm')}}"><i
                                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                                        data-i18n="DS PL By Item">DS P&L By Item</span></a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                            </ul>
                                        @endif
                                    </ul>
                                </li>
                            @endif 
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('Sales-Settlement-View') || auth()->user()->can('Income-Follow-Up-View'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                data-feather='star'></i><span class="menu-title text-truncate"
                                data-i18n="Utility">Utility</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @can('Sales-Settlement-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="settlement"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Settlement">Settlement</span></a>
                                </li>
                            @endcan
                            @can('Income-Follow-Up-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="closing"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Income Follow-Up">Income Follow-Up</span></a>
                                </li>
                            @endcan  
                        </ul>
                    </li>
                @endif
                
                @if (auth()->user()->can('BOM-View') || auth()->user()->can('Production-Order-View'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-industry" aria-hidden="true"></i><span class="menu-title text-truncate"
                                data-i18n="Production">Production</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @if (auth()->user()->can('BOM-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="bom"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="BOM">BOM</span></a>
                                </li>
                            @endif   
                            @if (auth()->user()->can('Production-Order-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="prdorder"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Production Order">Production Order</span></a>
                                </li>
                            @endif   
                            <li>
                                <a class="d-flex align-items-center ref" href="prdcost"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Production Cost">Production Cost</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('Invoice-View'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='package'></i><span class="menu-title text-truncate"
                                data-i18n="Fitness & Spa">Fitness & Spa</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @if (auth()->user()->can('Invoice-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="application"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Fitness Form">Fitness Form</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-user" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="HR">HR</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center ref" href="{{ url('leavemgt') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Leave Request">Leave Request</span></a>
                        </li>
                        @can('Shift-Schedule-View')
                        <li>
                            <a class="d-flex align-items-center ref" href="{{ url('shiftsch') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shift Schedule">Shift Schedule</span></a>
                        </li>
                        @endcan
                        @can('Attendance-View')
                        <li>
                            <a class="d-flex align-items-center ref" href="{{ url('attendance') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Attendance">Attendance</span></a>
                        </li>
                        @endcan

                        @if (auth()->user()->can('Payroll-Addition-Deduction-View') || auth()->user()->can('Payroll-View'))
                        <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa-regular fa-credit-card"></i><span class="menu-title text-truncate" data-i18n="Payroll">Payroll</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                            <ul class="menu-content">
                                @can('Payroll-Addition-Deduction-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('payrolladd') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Payroll Addition / Deduction">Payroll Addition / Deduction</span></a>
                                </li>
                                @endcan
                                @can('Payroll-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('payroll') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Payroll">Payroll Registration</span></a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endif
                        @if (auth()->user()->can('Holiday-View')||auth()->user()->can('Salary-View')||auth()->user()->can('Position-View')||auth()->user()->can('Shift-View')||auth()->user()->can('Timetable-View')||auth()->user()->can('Employee-View')||auth()->user()->can('Leave-Type-View')||auth()->user()->can('Salary-Component-View')||auth()->user()->can('Overtime-Level-View'))
                        <li class="nav-item"><a class="d-flex align-items-center" href="#"><i class="fa fa-cog" aria-hidden="true"></i><span class="menu-title text-truncate" data-i18n="Set Up">Set Up</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                            <ul class="menu-content">
                                @can('Overtime-Level-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('overtime') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Overtime Level">Overtime Level</span></a>
                                </li>
                                @endcan
                                @can('Holiday-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('holiday') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Holidays">Holidays</span></a>
                                </li>
                                @endcan
                                @can('Leave-Type-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('leavetype') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Leave Type">Leave Type</span></a>
                                </li>
                                @endcan
                                @can('Salary-Component-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('salarytype') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Salary Component">Salary Component</span></a>
                                </li>
                                @endcan
                                @can('Salary-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="{{ url('salary') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Salary">Salary</span></a>
                                </li>
                                @endcan
                                @can('Position-View')
                                    <li>
                                        <a class="d-flex align-items-center ref" href="{{ url('position') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Position">Position</span></a>
                                    </li>
                                @endcan
                                @can('Timetable-View')
                                    <li>
                                        <a class="d-flex align-items-center ref" href="{{ url('timetable') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Timetable">Timetable</span></a>
                                    </li>
                                @endcan   
                                @can('Shift-View')
                                    <li>
                                        <a class="d-flex align-items-center ref" href="{{ url('shift') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Shift">Shift</span></a>
                                    </li>
                                @endcan
                                @can('Employee-View')
                                    <li>
                                        <a class="d-flex align-items-center ref" href="{{ url('employee') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Employee">Employee</span></a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                        @endif
                    </ul>
                </li>
                @if (auth()->user()->can('Category-View') ||
    auth()->user()->can('UOM-View') ||
    auth()->user()->can('Conversion-view') ||
    auth()->user()->can('Item-View') ||
    auth()->user()->can('Customer-View') ||
    auth()->user()->can('Blacklist-View') ||
    auth()->user()->can('Store-View') ||
    auth()->user()->can('Brand-View') ||
    auth()->user()->can('Device-View') ||
    auth()->user()->can('Bank-View') ||
    auth()->user()->can('Period-View')||
    auth()->user()->can('Group-View')||
    auth()->user()->can('PaymentTerm-View')||
    auth()->user()->can('Service-View')||
    auth()->user()->can('Branch-View')||
    auth()->user()->can('Department-View')||
    auth()->user()->can('Client-View'))
                    <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                data-feather="menu"></i><span class="menu-title text-truncate"
                                data-i18n="Registry">Registry</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                            @can('Category-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="category"><i data-feather="circle"></i><span
                                            class="menu-item text-truncate" data-i18n="Category">Category</span></a>
                                </li>
                            @endcan
                            @if (auth()->user()->can('UOM-View') || auth()->user()->can('Conversion-view'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="uom"><i data-feather="circle"></i><span
                                            class="menu-item text-truncate" data-i18n="UOM">UOM</span></a>
                                </li>
                            @endif
                            @can('Item-View')
                                <li>
                                    <a class="d-flex align-items-center" href="items"><i data-feather="circle"></i><span
                                            class="menu-item text-truncate" data-i18n="ItemService">Item/Service</span></a>
                                </li>
                            @endcan
                            @if (auth()->user()->can('Customer-View') ||auth()->user()->can('Blacklist-View'))
                                <li>
                                    <a class="d-flex align-items-center ref" href="customer"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="Customer/Supplier">Customer/Supplier</span></a>
                                </li>
                            @endif
                            @can('Store-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="store"><i data-feather="circle"></i><span
                                            class="menu-item text-truncate" data-i18n="Store">Store</span></a>
                                </li>
                            @endcan
                            @can('Brand-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="brand"><i
                                            data-feather="circle"></i><span class="menu-item text-truncate"
                                            data-i18n="Brand & Model">Brand & Model</span></a>
                                </li>
                            @endcan
                            @can('Device-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="device"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Devices">Devices</span></a>
                                </li>
                            @endcan
                            @can('Bank-View')
                            <li>
                                <a class="d-flex align-items-center ref" href="bank"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bank">Bank</span></a>
                            </li>
                            @endcan
                            @can('Period-View')
                            <li>
                                <a class="d-flex align-items-center ref" href="period"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Period">Period</span></a>
                            </li>
                            @endcan
                            @can('Group-View')
                            <li>
                                <a class="d-flex align-items-center ref" href="group"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Group">Group</span></a>
                            </li>
                            @endcan
                            @can('PaymentTerm-View')
                            <li>
                                <a class="d-flex align-items-center ref" href="paymentterm"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Payment Term">Payment Term</span></a>
                            </li>
                            @endcan
                            @can('Service-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="service"><i data-feather="circle"></i><span
                                            class="menu-item text-truncate" data-i18n="Services">Services</span></a>
                                </li>
                            @endcan
                            @can('Branch-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="branch"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Branch">Branch</span></a>
                                </li>
                            @endcan
                            @can('Department-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="department"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Department">Department</span></a>
                                </li>
                            @endcan
                            
                            
                            @can('Client-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="membership"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Membership">Client</span></a>
                                </li>
                            @endcan
                            @can('Trainer-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="employe"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Trainer">Trainer</span></a>
                                </li>
                            @endcan
                            
                            @can('Region-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="region"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Region">Region</span></a>
                                </li>
                            @endcan
                            @can('Zone-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="zone"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Zone">Zone</span></a>
                                </li>
                            @endcan
                            @can('Woreda-View')
                                <li>
                                    <a class="d-flex align-items-center ref" href="woreda"><i data-feather="circle"></i><span
                                    class="menu-item text-truncate" data-i18n="Woreda">Woreda</span></a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('GeneralSales-View') || auth()->user()->can('SalesDetial-View') ||auth()->user()->can('SalesByCustomer-View') ||auth()->user()->can('SalesByItem-View') ||auth()->user()->can('Withold-&-VAT') ||auth()->user()->can('GeneralPurchase-View') ||auth()->user()->can('PurchaseDetail-View') ||auth()->user()->can('PurchaseBySupplier-View') ||auth()->user()->can('PurchaseByItem-View') ||auth()->user()->can('ItemMovement-View') ||auth()->user()->can('StoreBalanceReport-View')||auth()->user()->can('Inventory-Value-View')||auth()->user()->can('Reorder-View')||auth()->user()->can('PLDetail-View') ||auth()->user()->can('PLByCustomer-View') || auth()->user()->can('PLByItem-View') || auth()->user()->can('PLByPointofSales-View')||auth()->user()->can('Item-Sales-History-By-Customer-View')||auth()->user()->can('ERCA-Purchase-Report-View')|| auth()->user()->can('ERCA-Sales-Report-View')||auth()->user()->can('General-Service-Income') ||auth()->user()->can('Service-Income-By-Service')||auth()->user()->can('Service-Income-By-Client')||auth()->user()->can('Service-Income-By-Invoice')||auth()->user()->can('Service-Status') || auth()->user()->can('Bank-Report'))
                    <li class="nav-item">
                        <a class="d-flex align-items-center" href="#"><i data-feather="book-open"></i><span
                                class="menu-title text-truncate" data-i18n="Report">Report</span><span
                                class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        @if (auth()->user()->can('GeneralPurchase-View') ||auth()->user()->can('PurchaseDetail-View') || auth()->user()->can('PurchaseBySupplier-View') || auth()->user()->can('PurchaseByItem-View')|| auth()->user()->can('ERCA-Purchase-Report-View'))
                            <ul class="menu-content">
                                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                            data-feather="file"></i><span class="menu-title text-truncate"
                                            data-i18n="salesreport">Purchase Report</span><span
                                            class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                                    <ul class="menu-content">
                                        @can('GeneralPurchase-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="{{url('purchaseui')}}"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="General Purchase">General Purchase</span></a>
                                            </li>
                                        @endcan
                                        @can('PurchaseDetail-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="purchasedetailui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="Purchase Detail">Purchase Detail</span></a>
                                            </li>
                                        @endcan
                                        @can('PurchaseBySupplier-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="purchasebysupplierui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="By Supplier">By Supplier</span></a>
                                            </li>
                                        @endcan
                                        @can('PurchaseByItem-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="purchasebyitemui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="By Item">By Item</span></a>
                                            </li>
                                        @endcan
                                        @can('ERCA-Purchase-Report-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="{{url('prcustom')}}"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="ERCA Purchase Report">ERCA Purchase Report</span></a>
                                            </li>
                                        @endcan
                                    </ul>
                            </ul>
                        @endif

                        @if (auth()->user()->can('GeneralSales-View') ||auth()->user()->can('SalesDetial-View') ||auth()->user()->can('SalesByCustomer-View') ||auth()->user()->can('SalesByItem-View') ||auth()->user()->can('Withold-&-VAT')||auth()->user()->can('ERCA-Sales-Report-View'))
                            <ul class="menu-content">
                                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                            data-feather="file"></i><span class="menu-title text-truncate"
                                            data-i18n="salesreport">Sales Report</span><span
                                            class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                                    <ul class="menu-content">
                                        @can('GeneralSales-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="saleReport"
                                                    style="display:none;"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate" data-i18n="General Sales">General
                                                        Sales</span></a>
                                            </li>
                                        @endcan
                                        @can('SalesDetial-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="salesdetailview"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="Sales Detail">Sales Detail</span></a>
                                            </li>
                                        @endcan
                                        @can('SalesByCustomer-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="salebycustomer"
                                                    style="display:none;"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate" data-i18n="By Customer">By
                                                        Customer</span></a>
                                            </li>
                                        @endcan
                                        @can('SalesByItem-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="salebyitem"
                                                    style="display:none;"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate" data-i18n="By Item">By
                                                        Item</span></a>
                                            </li>
                                        @endcan
                                        @can('ERCA-Sales-Report-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="{{url('custom')}}"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="ERCA Sales Report">ERCA Sales Report</span></a>
                                            </li>
                                        @endcan
                                        @can('Withold-&-VAT')
                                            <li>
                                                <a class="d-flex align-items-center" href="witholdView"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="Sales Deduct">Sales Deduct</span></a>
                                            </li>
                                        @endcan
                                        @can('ItemRank-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="{{url('itemrank')}}"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="Item Rank">Item Rank</span></a>
                                            </li>
                                        @endcan
                                        @can('CustomerRank-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="{{url('cusrank')}}"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="Customer Rank">Customer Rank</span></a>
                                            </li>
                                        @endcan
                                    </ul>
                                    @if (auth()->user()->can('PLGeneral-View') ||auth()->user()->can('PLByCustomer-View') || auth()->user()->can('PLByItem-View') || auth()->user()->can('PLByPointofSales-View'))
                                        <ul class="menu-content">
                                            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                                        data-feather="file"></i><span class="menu-title text-truncate"
                                                        data-i18n="financialreport">P&L Report</span><span
                                                        class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                                                <ul class="menu-content">
                                                    @can('PLGeneral-View')
                                                        <li>
                                                            <a class="d-flex align-items-center ref" href="{{url('plreport')}}"><i
                                                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="PL General Report">P&L General Report</span></a>
                                                        </li>
                                                    @endcan
                                                    @can('PLByPointofSales-View')
                                                        <li>
                                                            <a class="d-flex align-items-center ref" href="{{url('plreportsum')}}"><i
                                                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="PL By POS">P&L By POS</span></a>
                                                        </li>
                                                    @endcan
                                                    @can('PLByCustomer-View')
                                                        <li>
                                                            <a class="d-flex align-items-center ref" href="{{url('plreportcus')}}"><i
                                                                    data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="PL By Customer">P&L By Customer</span></a>
                                                        </li>
                                                    @endcan
                                                    @can('PLByItem-View')
                                                        <li>
                                                            <a class="d-flex align-items-center ref" href="{{url('plreportitm')}}"><i data-feather="circle"></i><span class="menu-item text-truncate"
                                                                    data-i18n="PL By Item">P&L By Item</span></a>
                                                        </li>
                                                    @endcan
                                                   
                                                </ul>
                                        </ul>
                                    @endif
                            </ul>
                        @endif

                        @if (auth()->user()->can('ItemMovement-View') ||auth()->user()->can('StoreBalanceReport-View')||auth()->user()->can('Inventory-Value-View')||auth()->user()->can('Reorder-View')||auth()->user()->can('DS-Inventory-Movement')||auth()->user()->can('DS-Store-Balance')||auth()->user()->can('DS-Inventory-Value')||auth()->user()->can('DS-General-PullOut')||auth()->user()->can('DS-General-HandIn') || auth()->user()->can('Good-Receiving-View'))
                            <ul class="menu-content">
                                <li>
                                    <a class="d-flex align-items-center" href="#"><i data-feather="file"></i><span
                                            class="menu-item text-truncate" data-i18n="Inventory">Inventory
                                            Report</span></a>
                                    <ul class="menu-content">
                                        @can('ItemMovement-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="movementui"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate" data-i18n="Item Movement">Item
                                                        Movement</span></a>
                                            </li>
                                        @endcan
                                        @can('StoreBalanceReport-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="balanceui"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate"
                                                        data-i18n="Store Balance Report">Store Balance Report</span></a>
                                            </li>
                                        @endcan
                                        @can('Inventory-Value-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="value"><i data-feather="circle"></i><span
                                                    class="menu-item text-truncate"
                                                    data-i18n="Invetory Value Report">Inventory Value Report</span></a>
                                            </li>
                                        @endcan
                                        @can('Reorder-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="reorder"><i data-feather="circle"></i><span
                                                    class="menu-item text-truncate"
                                                    data-i18n="Reorder Report">Reorder Report</span></a>
                                            </li>
                                        @endcan
                                        @can('FSNAnalysis-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="fsn"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate"
                                                        data-i18n="FSN Analysis Report">FSN Analysis Report</span></a>
                                            </li>
                                        @endcan
                                        @can('Good-Receiving-View')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="receivingrep"><i data-feather="circle"></i><span
                                                        class="menu-item text-truncate"
                                                        data-i18n="Good Receiving Report">Good Receiving Report</span></a>
                                            </li>
                                        @endcan

                                    </ul>
                                </li>
                            </ul>
                        @endif

                        @if (auth()->user()->can('General-Service-Income') ||auth()->user()->can('Service-Income-By-Service')||auth()->user()->can('Service-Income-By-Client')||auth()->user()->can('Service-Income-By-Invoice')||auth()->user()->can('Service-Status'))
                            <ul class="menu-content">
                                <li>
                                    <a class="d-flex align-items-center" href="#"><i data-feather="file"></i><span
                                            class="menu-item text-truncate" data-i18n="Fitness Report">Fitness
                                            Report</span></a>
                                    <ul class="menu-content">
                                        @can('General-Service-Income')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="generalservice"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="General Service Income">General Service Income</span></a>
                                            </li>
                                        @endcan
                                        @can('Service-Income-By-Service')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="servicebyservice"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service Income by Service Type">Income by Service Type</span></a>
                                            </li>
                                        @endcan
                                        @can('Service-Income-By-Client')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="servicebyclient"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service Income by Client">Income by Client</span></a>
                                            </li>
                                        @endcan
                                        @can('Service-Income-By-Invoice')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="invoicedetail"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service Income by Invoice">Income by Invoice</span></a>
                                            </li>
                                        @endcan
                                        @can('Service-Status')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="servicestatus"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Service Status">Service Status</span></a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            </ul>
                        @endif

                        @if (auth()->user()->can('Bank-Report'))
                            <ul class="menu-content">
                                <li>
                                    <a class="d-flex align-items-center" href="#"><i data-feather="file"></i><span
                                            class="menu-item text-truncate" data-i18n="Fitness Report">Income Follow-Up
                                            Report</span></a>
                                    <ul class="menu-content">
                                        @can('Bank-Report')
                                            <li>
                                                <a class="d-flex align-items-center ref" href="bankrep"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Bank Report">Bank Report</span></a>
                                            </li>
                                        @endcan
                                        
                                    </ul>
                                </li>
                            </ul>
                        @endif
                </li>
            @endif

            @can('Setting-Change')
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather='settings'></i><span class="menu-title text-truncate"
                            data-i18n="Setting">Setting</span><span
                            class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                    <ul class="menu-content">
                        @can('Setting-Change')
                            <li>
                                <a class="d-flex align-items-center ref" href="setting"><i data-feather="circle"></i><span
                                        class="menu-item text-truncate" data-i18n="General">General</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @if (auth()->user()->can('User-View') || auth()->user()->can('Role-View'))
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                            data-feather='users'></i><span class="menu-title text-truncate"
                            data-i18n="Account">Account</span><span
                            class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                    <ul class="menu-content">
                        @can('User-View')
                            <li>
                                <a class="d-flex align-items-center ref" href="/user"><i data-feather="circle"></i><span
                                        class="menu-item text-truncate" data-i18n="Users">Users</span></a>
                            </li>
                        @endcan
                        @can('Role-View')
                            <li>
                                <a class="d-flex align-items-center ref" href="/role"><i data-feather="circle"></i><span
                                        class="menu-item text-truncate" data-i18n="Role">Role</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div id="main-content">
        @yield('content')
    </div>
    <!-- END: Content-->

    <div class="modal fade text-left" id="expirenotice" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Subscription Renew Notice</h4>
                    <button type="button" class="close" onclick="closemodal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #e74a3b;text-align:center;">
                    <label id="renewlbl" strong style="font-size: 26px;color:white;font-weight:bold;">Total Outstanding Amount</label>
                </div>
                <div class="modal-footer">
                    <button id="closebuttonk" type="button" class="btn btn-danger" onclick="closemodal()">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN: Customizer-->
    <div class="customizer d-none d-md-block">
        <div class="customizer-content">
            <!-- Customizer header -->
            <div class="customizer-header px-2 pt-1 pb-0 position-relative">
                <h4 class="mb-0">Theme Setting</h4>
                <p class="m-0"></p>
                <a class="customizer-close" href="javascript:void(0);"><i data-feather="x"></i></a>
            </div>

            <hr />

            <!-- Styling & Text Direction -->
            <div class="customizer-styling-direction px-2">
                <p class="font-weight-bold">Skin</p>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="skinlight" name="skinradio" class="custom-control-input layout-name"
                            checked data-layout="" />
                        <label class="custom-control-label" for="skinlight">Light</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="skinbordered" name="skinradio" class="custom-control-input layout-name"
                            data-layout="bordered-layout" />
                        <label class="custom-control-label" for="skinbordered">Bordered</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="skindark" name="skinradio" class="custom-control-input layout-name"
                            data-layout="dark-layout" />
                        <label class="custom-control-label" for="skindark">Dark</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="skinsemidark" name="skinradio" class="custom-control-input layout-name"
                            data-layout="semi-dark-layout" />
                        <label class="custom-control-label" for="skinsemidark">Semi Dark</label>
                    </div>
                </div>
            </div>

            <hr />

            <!-- Menu -->
            <div class="customizer-menu px-2">
                <div id="customizer-menu-collapsible" class="d-flex">
                    <p class="font-weight-bold mr-auto m-0">Menu Collapsed</p>
                    <div class="custom-control custom-control-primary custom-switch">
                        <input type="checkbox" class="custom-control-input" id="collapse-sidebar-switch" />
                        <label class="custom-control-label" for="collapse-sidebar-switch"></label>
                    </div>
                </div>
            </div>
            <hr />

            <!-- Layout Width -->
            <div class="customizer-footer px-2">
                <p class="font-weight-bold">Layout Width</p>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="layout-width-full" name="layoutWidth" class="custom-control-input"
                            checked />
                        <label class="custom-control-label" for="layout-width-full">Full Width</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="layout-width-boxed" name="layoutWidth" class="custom-control-input" />
                        <label class="custom-control-label" for="layout-width-boxed">Boxed</label>
                    </div>
                </div>
            </div>
            <hr />

            <!-- Navbar -->
            <div class="customizer-navbar px-2">
                <div id="customizer-navbar-colors">
                    <p class="font-weight-bold">Navbar Color</p>
                    <ul class="list-inline unstyled-list">
                        <li class="color-box bg-white border selected" data-navbar-default=""></li>
                        <li class="color-box bg-primary" data-navbar-color="bg-primary"></li>
                        <li class="color-box bg-secondary" data-navbar-color="bg-secondary"></li>
                        <li class="color-box bg-success" data-navbar-color="bg-success"></li>
                        <li class="color-box bg-danger" data-navbar-color="bg-danger"></li>
                        <li class="color-box bg-info" data-navbar-color="bg-info"></li>
                        <li class="color-box bg-warning" data-navbar-color="bg-warning"></li>
                        <li class="color-box bg-dark" data-navbar-color="bg-dark"></li>
                    </ul>
                </div>

                <p class="navbar-type-text font-weight-bold">Navbar Type</p>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="nav-type-floating" name="navType" class="custom-control-input"
                            checked />
                        <label class="custom-control-label" for="nav-type-floating">Floating</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="nav-type-sticky" name="navType" class="custom-control-input" />
                        <label class="custom-control-label" for="nav-type-sticky">Sticky</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="nav-type-static" name="navType" class="custom-control-input" />
                        <label class="custom-control-label" for="nav-type-static">Static</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" id="nav-type-hidden" name="navType" class="custom-control-input" />
                        <label class="custom-control-label" for="nav-type-hidden">Hidden</label>
                    </div>
                </div>
            </div>
            <hr />

            <!-- Footer -->
            <div class="customizer-footer px-2">
                <p class="font-weight-bold">Footer Type</p>
                <div class="d-flex">
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="footer-type-sticky" name="footerType" class="custom-control-input" />
                        <label class="custom-control-label" for="footer-type-sticky">Sticky</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="footer-type-static" name="footerType" class="custom-control-input"
                            checked />
                        <label class="custom-control-label" for="footer-type-static">Static</label>
                    </div>
                    <div class="custom-control custom-radio mr-1">
                        <input type="radio" id="footer-type-hidden" name="footerType" class="custom-control-input" />
                        <label class="custom-control-label" for="footer-type-hidden">Hidden</label>
                    </div>
                </div>
            </div>
        </div>
    @if(Session::has('jsAlert'))

    <script type="text/javascript" >
        alert({{ session()->get('jsAlert') }});
    </script>

    @endif
    </div>
    <!-- End: Customizer-->
    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light fit-content"></footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->

    <script src="{{ mix('js/app.js') }}"></script>
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/jszip.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/pdfmake.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/vfs_fonts.js')}}"></script>
    <script src="{{ asset('app-assets/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('app-assets/js/dataTables.select.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/customizer.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-number-input.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/ui/ui-feather.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/form-file-uploader.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <script src="{{ asset('app-assets/selectpicker/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('app-assets/selectpicker/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/components/components-collapse.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/extensions/ext-component-blockui.js') }}"></script>
    <!--Begin Load Custom Javascripts-->
    <script src="{{ asset('app-assets/js/validation.js') }}"></script>
    <!--End Load Custom Javascripts-->
    <script type="text/javascript" src="{{ asset('customjs/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/moment.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/highlight.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/quill.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.highlight.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/dataTables.searchHighlight.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/datetimepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jsPlumb.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jsplumb-tree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/tree-maker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/orgchart.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.dateandtime.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.timeselector.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/timepicki.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>
    <!-- END: Page JS-->
      <!-- BEGIN: Page Vendor JS-->
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/scripts/forms/form-input-mask.js')  }}"></script>
      <!-- END: Page Vendor JS-->

    <script type="text/javascript" src="{{ asset('customjs/table2excel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.table2excel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery-explr-1.4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/tree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.almightree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/webcam.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.multiselect.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/scripts/charts/chart-chartjs.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/chart.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/canvasjs.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/SimpleChart.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/charts/chartjs-plugin-datalabels.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/scripts/components/components-popovers.js')}}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/multiselect.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/vendors/js/extensions/jstree.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/scripts/extensions/ext-component-tree.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/pickr/pickr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/jquery-timepicker/jquery-timepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/pickr/pickr.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app-assets/js/cards-actions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.schedule.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.skedTape.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/jquery.skedTape.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/hummingbird-treeview.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/dataTables.fixedColumns.js') }}"></script>
    <script type="text/javascript" src="{{ asset('customjs/sweetalert2.all.min.js') }}"></script>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/exceljs/dist/exceljs.min.js"></script>
    <script type="text/javascript">

        $(function () {
            cardSection = $('#page-block');
        });

        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

        $("body").on('click','.refs',function(){
            var url = this.href;
            $.get(url, function(data){
                $("#main-content").html(data);

                //history manipulation here
            });
            return false;
        });

        $(".ref").off("click").on('click',function(e) {
            let CSRF_TOKEN=null;
            e.preventDefault();
            //e.stopPropagation();
            CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
            var href = $(this).attr('href');
            $("li").removeClass("active"); 
            $('.fitreportfooter').hide();
            $('.fitreportfooter').text("");
            $.ajax({
                url: href,
                type:'get',
                data:{
                    CSRF_TOKEN
                }, 
                beforeSend: function () { 
                    cardSection.block({
                        message:
                        '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50"></p></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: '0'
                        },
                        overlayCSS: {
                            backgroundColor: '#fff',
                            opacity: 0.8
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
                statusCode: {
                    401: function() {
                        toastrMessage('error',"Session Expired!","Error");
                        location.reload(false);
                    }
                },
                success: function (data) {
                    window.history.pushState("data","Title",href);
                    $("#main-content").html(data);
                    $(".selectpicker").selectpicker({
                        noneSelectedText : ''
                    });
                    $('.select2').select2();
                    $('#contenthidden').text('');
                    $('.fitreportfooter').hide();
                    currentDate();
                }
            });  
        });

        function changeurl(url){
            var new_url = url;
            window.history.pushState("data","Title",new_url);
            $("#main-content").load(new_url);
        }

        function toastrMessage($type,$message,$info){
            toastr[$type]($message,$info,{
                "closeButton": true,
                "debug": true,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "preventOpenDuplicates": true,
                "onclick": null,
                "showDuration": "3000",
                "hideDuration": "1000",
                "timeOut": "10000",
                "extendedTimeOut": "10000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
        }

        var checkexpiredate = function(){
            var remdate = 0;
            var expiredate = "";
            $.get("/showexpdate" , function(data) { 
                $.each(data.checkexpdate, function(index, value) {
                    remdate = value.RemainingDate;
                    expiredate = value.ExpiredateVal;
                });
                if(parseFloat(remdate) <= 300){
                    $('#renewlbl').html("Your anual subscription expires in "+remdate+" days. Please renew your subscription.</br>If you have any questions regarding the renewal process or need help contact us at");
                    $('#expirenotice').modal('show');
                }
            }); 
        }
        //setInterval(checkexpiredate,3600000);

        function currentDate(){
            var dates = "";
            $.get("/showcurrentdate" , function(data) { 
                dates = data.curdate;   
                flatpickr('.flatpickr-basic', { dateFormat: 'Y-m-d',clickOpens:true,maxDate:dates});
            }); 
        }

        currentDate();

        function closemodal(){
            $('#expirenotice').modal('hide');
        }

        $(document).ready(function () {
            const timeout = 18000000;  // 30 minutes
            var idleTimer = null;
            $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
                clearTimeout(idleTimer);

                idleTimer = setTimeout(function () {
                    document.getElementById('logout-form').submit();
                }, timeout);
            });
            $("body").trigger("mousemove");
        });

        $('.display td').tooltip({
            title: function () {
                return $(this).text();
            },
            placement: 'top'
        });

        $(document).on('mouseenter', '.display td', function () {
            $(this).attr('title', $(this).text());
        });

        window.addEventListener("load", function () {
            // Restore saved mode
            let savedMode = localStorage.getItem("navbarMode");
            if (savedMode) {
                document.body.setAttribute("data-navbar", savedMode);
            }

            // Watch navbar mode toggles
            document.querySelectorAll("[data-toggle='navbar-style']").forEach(el => {
                el.addEventListener("click", function () {
                    let mode = this.getAttribute("data-navbar"); // e.g. "dark", "light"
                    document.body.setAttribute("data-navbar", mode);
                    localStorage.setItem("navbarMode", mode);
                });
            });
        });

        function blockPage(element,message) {
            element.block({
                message: 
                `<div class="d-flex justify-content-center align-items-center">
                    <p class="mr-50 mb-50">${message}</p>
                    <div class="spinner-grow spinner-grow-sm text-white" role="status"></div>
                </div>`,
                css: {
                    backgroundColor: 'transparent',
                    color: '#fff',
                    border: '0'
                },
                overlayCSS: {
                    opacity: 0.5
                },
            });
        }

        function unblockPage(element) {
            element.unblock();
        }

    </script>

    <div style="display:none;" id="contenthidden">
        @yield('content')
    </div>
    
    <script>
        $('#contenthidden').text('');
    </script>
</body>
<!-- END: Body-->

</html>