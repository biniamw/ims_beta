@extends('layout.app1')

@section('title')
@endsection

@section('content')

    <div class="app-content content ">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Booking</h3>


                        </div>
                        <div class="card-datatable">
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function () {
            cardSection = $('#page-block');
        });
    </script>

@endsection
