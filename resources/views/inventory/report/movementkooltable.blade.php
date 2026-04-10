@extends('layout.app')
@section('title')
@endsection
@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">Item Movement</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('saleReport') }}">General Report</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('salesdetailview') }}">Sales Detail</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('salebycustomer') }}">Sales By Customer
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('salebyitem') }}">Sales By Item </a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ url('witholdView') }}">Sales By Deduct </a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">

                <!-- Complex Headers -->
                <section id="complex-header-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <h4 class="card-title">Sale By Customer</h4>
                                </div>
                                <div class="card-datatable">
                                    @php
                                        
                                        ini_set('max_execution_time', '0');
                                        ini_set('pcre.backtrack_limit', '5000000');
                                        $report->render();
                                        
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Complex Headers -->
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
