
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
    <link rel="stylesheet" href="{{ asset('app-assets/selectpicker/css/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('app-assets/selectpicker/css/bootstrap-select.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
    <!-- BEGIN: Vendor CSS-->
    <!-- END: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/file-uploaders/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-file-uploader.css') }}">
    <link rel="stylesheet" href="{{ asset('customcss/sweetalert2.min.css') }}">
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
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/toaster/toastr.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/toaster/toastr.js')  }}"/>
  <link rel="stylesheet" href="{{ asset('customcss/quill.snow.css') }}" />

  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-invoice.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

  <!-- END: Page CSS-->
    {{-- css data picker --}}

    {{-- end css date picker --}}

  <link rel="stylesheet" type="text/css" href="{{ asset('customcss/daterangepicker.css') }}" />

  <!-- BEGIN: Custom CSS-->

  <link href="{{ asset('app-assets/css/multiselect.css') }}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
  <script src="{{ asset('app-assets/js/multiselect.min.js') }}"></script>

  <style>
    table.dataTable span.highlight {
  background-color: #FFFF88;
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
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern menu-expanded pace-done footer-fixed navbar-sticky" data-open="click" data-menu="vertical-menu-modern" data-col="" id="page-block">
    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center navbar-light navbar-shadow fixed-top" id="navbar">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">

                </ul>
                <ul class="nav navbar-nav">

                </ul>
            </div>
            <div class="row justify-content-md-center" style="margin-left:1%;margin-right:auto;display:block;"><h1 style="color:#7367f0"><b>{{Session::get('companyName')}}</b></h1></div>
            <ul class="nav navbar-nav align-items-center ml-auto">
                {{-- some code is removed from here --}}
                <a class="customizer-toggle d-flex align-items-center justify-content-center" href="javascript:void(0);"><i class="spinners" data-feather="settings"></i></a>
                <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name font-weight-bolder">{{ Auth::user()->username }}</span><span class="user-status"></span></div><span class="avatar"><img class="round" src="{{ asset('app-assets/images/portrait/small/default-profile-pic.jpg') }}" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user"><a class="dropdown-item" href="profile"><i class="mr-50" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item"  href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                              <i class="mr-50" data-feather="power"></i>   {{ __('Logout') }}
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
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/xls.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/jpg.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/pdf.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/doc.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a href="javascript:void(0);">
                <h6 class="section-label mt-75 mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion justify-content-between"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="mr-75" data-feather="alert-circle"></span><span>No results found.</span></div>
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
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if(auth()->user()->can('sales-show') || auth()->user()->can('sale-holdView'))
              <li class="nav-item"><a class="d-flex align-items-center" ><i data-feather="shopping-bag"></i><span class="menu-title text-truncate" data-i18n="Sales & Marketing">Sales & Marketing</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                <ul class="menu-content">
                  @if(auth()->user()->can('sales-show') || auth()->user()->can('sale-holdView'))
                    <li>
                          <a class="d-flex align-items-center" href="{{ url('sales') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Sales">Sales</span></a>
                    </li>
                    @endif
                    <li>
                      <a class="d-flex align-items-center" href="{{url('Consignor')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Consignor">Consignor</span></a>
                    </li>
                    <li>
                    <a class="d-flex align-items-center" href="{{url('Consignee')}}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Consignee">Consignee</span></a>
                    </li>
                    <li>
                      <a class="d-flex align-items-center" href="{{ url('proforma') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Proforma">Proforma</span></a>
                    </li>
                </ul>
              </li>
              @endif
              @if(auth()->user()->can('Receiving-View') || auth()->user()->can('Hold-View')|| auth()->user()->can('Requisition-View')|| auth()->user()->can('Transfer-View')||auth()->user()->can('Approver-Transfer-View') || auth()->user()->can('Approver-Requisition-View')||auth()->user()->can('Issue-Transfer-View') || auth()->user()->can('Issue-Requisition-View')|| auth()->user()->can('Adjustment-View')|| auth()->user()->can('Begining-View')|| auth()->user()->can('StoreBalance-View')|| auth()->user()->can('DeadStock-View'))
              <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Inventory">Inventory</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                    <ul class="menu-content">
                    @if(auth()->user()->can('Receiving-View') || auth()->user()->can('Hold-View'))
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('receiving') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="GoodsReceiving">Goods Receiving</span></a>
                      </li>
                      @endif
                      @can('Requisition-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('requisition') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="StoreRequisition ">Store Requisition</span></a>
                      </li>
                      @endcan
                      @can('Transfer-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('transfer') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="StoreTransfer ">Store Transfer</span></a>
                      </li>
                      @endcan
                      @if(auth()->user()->can('Approver-Transfer-View') || auth()->user()->can('Approver-Requisition-View'))
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('approver') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="StoreApprover">Store Approver</span></a>
                      </li>
                      @endif
                      @if(auth()->user()->can('Issue-Transfer-View') || auth()->user()->can('Issue-Requisition-View'))
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('issue') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Issue">Store Issue</span></a>
                      </li>
                      @endif
                      @can('Adjustment-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('adjustment') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="StoreAdjustment">Store Adjustment</span></a>
                      </li>
                      @endcan
                      @can('Begining-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('begining') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="StoreBegining">Store Begining</span></a>
                      </li>
                      @endcan
                      @can('Begining-View')
                        <li>
                          <a class="d-flex align-items-center" href="ending"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Ending">Ending</span></a>
                        </li>
                      @endcan
                      @can('StoreBalance-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('stockbalance') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="stockbalance">Store Balance</span></a>
                      </li>
                      @endcan
                      @can('DeadStock-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('deadstock') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dead Stock" style="color:#ea5455;">Dead Stock</span></a>
                      </li>
                      @endcan
                      @can('DS-Beginning')
                          <li>
                            <a class="d-flex align-items-center" href="dsbegining"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dead Stock" style="color:#ea5455;">DS Begining</span></a>
                          </li>
                      @endcan
                    </ul>
              </li>
              @endif
              @if(auth()->user()->can('Category-View') ||auth()->user()->can('UOM-View')|| auth()->user()->can('Conversion-view')||auth()->user()->can('Item-View')||auth()->user()->can('Customer-View') || auth()->user()->can('Blacklist-View')||auth()->user()->can('Store-View')||auth()->user()->can('Brand-View'))
              <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="menu"></i><span class="menu-title text-truncate" data-i18n="Registry">Registry</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                    <ul class="menu-content">
                      @can('Category-View')
                        <li>
                              <a class="d-flex align-items-center" href="{{ url('category') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Category">Category</span></a>
                        </li>
                        @endcan
                        @if(auth()->user()->can('UOM-View') || auth()->user()->can('Conversion-view'))
                        <li>
                              <a class="d-flex align-items-center" href="{{ url('uom') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="UOM">UOM</span></a>
                        </li>
                        @endif
                        @can('Item-View')
                        <li>
                          <a class="d-flex align-items-center" href="{{ url('items') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="ItemService">Item/Service</span></a>
                        </li>
                        @endcan
                        @if(auth()->user()->can('Customer-View') || auth()->user()->can('Blacklist-View'))
                        <li>
                          <a class="d-flex align-items-center" href="{{ url('customer') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Customer/Supplier">Customer/Supplier</span></a>
                        </li>
                        @endif
                        @can('Store-View')
                        <li>
                              <a class="d-flex align-items-center" href="{{ url('store') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Store">Store</span></a>
                        </li>
                        @endcan
                        @can('Brand-View')
                        <li>
                          <a class="d-flex align-items-center" href="{{ url('brand') }}" style="display:none;"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Brand & Model">Brand & Model</span></a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                  <a class="d-flex align-items-center" href="#"><i data-feather="book-open"></i><span class="menu-title text-truncate" data-i18n="Report">Report</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                   @if (auth()->user()->can('GeneralPurchase-View') ||auth()->user()->can('PurchaseDetail-View') || auth()->user()->can('PurchaseBySupplier-View') || auth()->user()->can('PurchaseByItem-View'))
                            <ul class="menu-content">
                                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i
                                            data-feather="file"></i><span class="menu-title text-truncate"
                                            data-i18n="salesreport">Purchase Report</span><span
                                            class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                                    <ul class="menu-content">
                                        @can('GeneralPurchase-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="purchaseui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="General Purchase">General Purchase</span></a>
                                            </li>
                                        @endcan
                                        @can('PurchaseDetail-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="purchasedetailui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="Purchase Detail">Purchase Detail</span></a>
                                            </li>
                                        @endcan
                                        @can('PurchaseBySupplier-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="purchasebysupplierui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="By Supplier">By Supplier</span></a>
                                            </li>
                                        @endcan
                                        @can('PurchaseByItem-View')
                                            <li>
                                                <a class="d-flex align-items-center" href="purchasebyitemui"><i
                                                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="By Item">By Item</span></a>
                                            </li>
                                        @endcan
                                    </ul>
                            </ul>
                        @endif
                  <ul class="menu-content">
                      <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file"></i><span class="menu-title text-truncate" data-i18n="salesreport">Sales Report</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                        <ul class="menu-content">
                          @can('GeneralSales-View')
                            <li>
                            <a class="d-flex align-items-center" href="{{ url('saleReport') }}" style="display:none;"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="General Sales">General Sales</span></a>
                            </li>
                          @endcan
                          @can('SalesDetial-View')
                            <li>
                            <a class="d-flex align-items-center" href="{{ url('salesdetailview') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Sales Detail">Sales Detail</span></a>
                            </li>
                          @endcan
                          @can('SalesByCustomer-View')
                            <li>
                            <a class="d-flex align-items-center" href="{{ url('salebycustomer') }}" style="display:none;"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="By Customer">By Customer</span></a>
                            </li>
                          @endcan
                          @can('SalesByItem-View')
                            <li>
                            <a class="d-flex align-items-center" href="{{ url('salebyitem') }}" style="display:none;"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="By Item">By Item</span></a>
                            </li>
                          @endcan
                          @can('Withold-&-VAT')
                            <li>
                            <a class="d-flex align-items-center" href="{{ url('witholdView') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Sales Deduct">Sales Deduct</span></a>
                            </li>
                          @endcan
                        </ul>
                    </ul>
                    <ul class="menu-content">
                      <li>
                          <a class="d-flex align-items-center" href="#"><i data-feather="file"></i><span class="menu-item text-truncate" data-i18n="Inventory">Inventory Report</span></a>
                          <ul class="menu-content">
                                @can('ItemMovement-View')
                              <li>
                                  <a class="d-flex align-items-center" href="{{ url('movementui') }}"><span class="menu-item text-truncate" data-i18n="Item Movement">Item Movement</span></a>
                              </li>
                                @endcan
                                @can('StoreBalanceReport-View')
                              <li>
                                  <a class="d-flex align-items-center" href="{{ url('balanceui') }}"><span class="menu-item text-truncate" data-i18n="Store Balance Report">Store Balance Report</span></a>
                              </li>
                              @endcan
                              @can('Inventory-Value-View')
                                  <li>
                                      <a class="d-flex align-items-center" href="{{ url('value') }}"><span
                                              class="menu-item text-truncate"
                                              data-i18n="Invetory Value Report">Inventory Value Report</span></a>
                                  </li>
                              @endcan
                              @can('Reorder-View')
                                  <li>
                                      <a class="d-flex align-items-center" href="{{ url('reorder') }}"><span
                                              class="menu-item text-truncate"
                                              data-i18n="Reorder Report">Reorder Report</span></a>
                                  </li>
                               @endcan
                                <li>
                                    <a class="d-flex align-items-center" href="dsgenpo"><span class="menu-item text-truncate" data-i18n="DS General PullOut Report">DS General PullOut Report</span></a>
                                </li>
                               @can('DS-Inventory-Movement')
                                    <li>
                                        <a class="d-flex align-items-center" href="dsmovement"><span class="menu-item text-truncate" data-i18n="DS Item Movement Report">DS Item Movement Report</span></a>
                                    </li>
                                @endcan
                                @if (auth()->user()->can('DeadStock-View') ||auth()->user()->can('DS-Beginning'))
                                <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" style="color:#ea5455;" data-i18n="DS">DS</span></a>
                                  <ul class="menu-content">
                                      @can('DeadStock-View')
                                          <li>
                                              <a class="d-flex align-items-center" href="deadstock"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dead Stock" style="color:#ea5455;">DS I </span></a>
                                          </li>
                                      @endcan
                                      @can('DS-Beginning')
                                          <li>
                                              <a class="d-flex align-items-center" href="dsbegining"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dead Stock" style="color:#ea5455;">DS Begining</span></a>
                                          </li>
                                      @endcan
                                  </ul>
                                </li>
                              @endif
                          </ul>
                      </li>
                  </li>
                    </ul>
                </li>
                @can('Setting-Change')
                <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Setting">Setting</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                  <ul class="menu-content">
                      @can('Setting-Change')
                      <li>
                            <a class="d-flex align-items-center" href="{{ url('setting') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="General">General</span></a>
                      </li>
                      @endcan
                  </ul>
                </li>
                @endcan
                @if(auth()->user()->can('User-View') || auth()->user()->can('Role-View'))
                  <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Account">Account</span><span class="badge badge-light-warning badge-pill ml-auto mr-1"></span></a>
                  <ul class="menu-content">
                    @can('User-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('user') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Users">Users</span></a>
                      </li>
                      @endcan
                      @can('Role-View')
                      <li>
                        <a class="d-flex align-items-center" href="{{ url('role') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Role">Role</span></a>
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
        <!-- BEGIN: Customizer-->
    <div class="customizer d-none d-md-block"><div class="customizer-content">
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
          <input
            type="radio"
            id="skinlight"
            name="skinradio"
            class="custom-control-input layout-name"
            checked
            data-layout=""
          />
          <label class="custom-control-label" for="skinlight">Light</label>
        </div>
        <div class="custom-control custom-radio mr-1">
          <input
            type="radio"
            id="skinbordered"
            name="skinradio"
            class="custom-control-input layout-name"
            data-layout="bordered-layout"
          />
          <label class="custom-control-label" for="skinbordered">Bordered</label>
        </div>
        <div class="custom-control custom-radio mr-1">
          <input
            type="radio"
            id="skindark"
            name="skinradio"
            class="custom-control-input layout-name"
            data-layout="dark-layout"
          />
          <label class="custom-control-label" for="skindark">Dark</label>
        </div>
        <div class="custom-control custom-radio">
          <input
            type="radio"
            id="skinsemidark"
            name="skinradio"
            class="custom-control-input layout-name"
            data-layout="semi-dark-layout"
          />
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
          <input type="radio" id="layout-width-full" name="layoutWidth" class="custom-control-input" checked />
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
          <input type="radio" id="nav-type-floating" name="navType" class="custom-control-input" checked />
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
          <input type="radio" id="footer-type-static" name="footerType" class="custom-control-input" checked />
          <label class="custom-control-label" for="footer-type-static">Static</label>
        </div>
        <div class="custom-control custom-radio mr-1">
          <input type="radio" id="footer-type-hidden" name="footerType" class="custom-control-input" />
          <label class="custom-control-label" for="footer-type-hidden">Hidden</label>
        </div>
      </div>
    </div>
  </div>
  </div>
      <!-- End: Customizer-->
      <div class="sidenav-overlay"></div>
      <div class="drag-target"></div>
      <!-- BEGIN: Footer-->
      <footer class="footer footer-static footer-light">
      </footer>
      <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
      <!-- END: Footer-->
      {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
      <!-- BEGIN: Vendor JS-->
      <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
      <!-- BEGIN Vendor JS-->
      <!-- BEGIN: Page Vendor JS-->
      <script src="{{ asset('app-assets/js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
      <script src="https://cdn.datatables.net/fixedheader/3.2.2/js/dataTables.fixedHeader.min.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
      <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>


      <script src="{{ asset('app-assets/js/dataTables.bootstrap5.min.js') }}"></script>
      <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
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
      <script type="text/javascript" src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
      <script type="text/javascript" src="{{ asset('app-assets/js/scripts/pages/app-invoice.js') }}"></script>
      <script src="../../../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- END: Page JS-->
      <!-- BEGIN: Page Vendor JS-->
      <script src="{{ asset('app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
      <script src="{{ asset('app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js') }}"></script>
      <script src="{{ asset('app-assets/js/scripts/forms/form-input-mask.js')  }}"></script>
      <!-- END: Page Vendor JS-->
      <script src="{{ asset('customjs/sweetalert2.all.min.js')}}"></script>
      <script src="{{ asset('customjs/table2excel.js') }}"></script>
      <script src="{{ asset('customjs/jquery.table2excel.js') }}"></script>

   <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });

        function toastrMessage($type,$message,$info){
          toastr[$type]($message,$info,{
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
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

</script>

@yield('scripts')
</body>
<!-- END: Body-->
</html>