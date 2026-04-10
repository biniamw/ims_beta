@extends('layout.app')
@section('title')
@endsection
@section('content')
<div class="app-content content">
        <section id="responsive-datatable">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">General Sales Report</h3>
                        </div>
                        <div class="card-datatable">
                            <div style="width:98%;">
                                <div style="width:98%; margin-left:2%; margin-top:2%;">
                                    <div class="row">
                                        <div class="col-xl-5 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;color">Select Date Range</label>
                                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                                <i class="fa fa-calendar"></i>&nbsp;
                                                <span></span> <i class="fa fa-caret-down"></i>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                                <div>
                                                    <label strong style="font-size: 14px;color">Point of Sales</label>
                                                </div>
                                                <div>
                                                <select class="form-control" id="store" multiple="multiple">
                                                    @foreach ($store as $store)
                                                        <option value="{{$store->id}}">{{$store->Name}}   </option>
                                                    @endforeach                
                                                </select>
                                                </div>
                                                <span class="text-danger">
                                              <strong id="pointofsale-error"></strong>
                                              </span>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;color">Payment Type</label>
                                                <div>
                                                    <select class="form-control" id="paymenttype" multiple="multiple" >
                                                        <option value='"Cash"'>Cash</option> 
                                                        <option value='"Credit"'>Credit</option>                 
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                              <strong id="paymenttype-error"></strong>
                                              </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <label strong style="font-size: 14px;color">Item Group</label>
                                                <div>
                                                    <select class="form-control" id="itemgroup" multiple="multiple" >
                                                        <option value='"Local"'>Local</option> 
                                                        <option value='"Imported"'>Imported</option>                 
                                                    </select>
                                                </div>
                                                <span class="text-danger">
                                              <strong id="itemgroup-error"></strong>
                                              </span>
                                        </div>
                                        <div class="col-xl-3 col-md-6 col-sm-12 mb-2">
                                            <div class="row">
                                                .
                                            </div>
                                            <div class="row">
                                                <button id="reportbutton" type="button" class="btn btn-info btn-sm"><i data-feather="refresh-ccw"></i>  Load</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                 <div style="width:98%; margin-left:0%;"> 
                                    <?php //$report->render(); ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
         </section>
     </div>
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
@endsection

@section('scripts')


<script type="text/javascript">

var $fr='';
var $tr='';
document.multiselect('#store')
		.setCheckBoxClick("checkboxAll", function(target, args) {        
        })
		.setCheckBoxClick("1", function(target, args) {
		});
        document.multiselect('#paymenttype')
		.setCheckBoxClick("checkboxAll", function(target, args) {	
		})
		.setCheckBoxClick("1", function(target, args) {			
		});
        document.multiselect('#itemgroup')
		.setCheckBoxClick("checkboxAll", function(target, args) {		
		})
		.setCheckBoxClick("1", function(target, args) {		
		});
$(function() {
var start = moment().subtract(29, 'days');
var end = moment();
function cb(start, end) {
    $('#reportrange span').html(start.format('MMMM DD, YYYY') + ' - ' + end.format('MMMM DD, YYYY'));
  var from=start.format('YYYY-MM-DD');
  var to=end.format('YYYY-MM-DD');
  $fr=from;
  $tr=to; 
}

$('#reportrange').daterangepicker({
    startDate: start,
    endDate: end,
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
}, cb);

cb(start, end);



});

$('#reportbutton').click(function()
{    
    var storeval=$('#store').val(); 
    var paymenttype=$('#paymenttype').val(); 
    var itemgroup=$('#itemgroup').val(); 

    if(storeval=='')
    {
    $( '#pointofsale-error' ).html('Point of sale is required');
    }
    else if(paymenttype=='')
    {
        $( '#paymenttype-error' ).html('Payment type is required');
    }
    else if(itemgroup=='')
    {
        $( '#itemgroup-error' ).html('Item group is required');
    }
    else
    {   
        $( '#paymenttype-error' ).html('');
        $( '#pointofsale-error' ).html('');
        $( '#itemgroup-error' ).html('');
        $.get('/salesdetailreport/'+$fr+'/'+$tr+'/'+storeval+'/'+paymenttype+'/'+itemgroup  , function (data) 
        {
            var link='/salesdetailreport/'+$fr+'/'+$tr+'/'+storeval+'/'+paymenttype+'/'+itemgroup;
            window.open(link, 'Sales', 'width=1400,height=800,scrollbars=yes');
        });
    }
}); 

</script>

@endsection



