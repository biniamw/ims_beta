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
                        <h3 class="card-title">Import Data</h3>
                    </div>
                    <div class="card-datatable">
                        <form id="Register">
                            {{ csrf_field()}}
                            <div style="width:98%; margin-left:1%;margin-right:1%;">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-12 mt-1">
                                        <label strong style="font-size: 14px;">Document Type</label>
                                        <div>
                                            <select class="select2 form-control" name="doctype" id="doctype" onchange="doctypefn()">
                                                <option selected disabled value=""></option>
                                                <option value="1">Category Data</option>
                                                <option value="2">UOM Data</option>
                                                <option value="3">Item Data</option>
                                                <option value="4">Customer Data</option>
                                                <option value="5">Store Data</option>
                                                <option value="6">Beginning Data</option>
                                            </select>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="doctype-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-lg-12 mt-1" style="display:none;" id="sheetnumdiv">
                                        <label strong style="font-size: 14px;">Sheet #</label>
                                        <div class="input-group input-group-merge">
                                            <input type="text" placeholder="Sheet Number" class="form-control" name="SheetNumber" id="SheetNumber" onkeypress="return ValidateOnlyNum(event);" onkeyup="sheetNumberfn()"/>
                                        </div>
                                        <span class="text-danger">
                                            <strong id="sheetnum-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-3 col-lg-12 mt-1" style="display:none;" id="browsediv">
                                        <label strong style="font-size: 14px;">Browse Document</label>
                                        <div>
                                            <input type="file" accept=".xlsx, .xls" name="excel_file" id="excel_file"/><br><button type="button" id="clearbtnid" onclick="clearData()" class="btn btn-sm btn-flat-danger waves-effect">X</button>
                                        </div>
                                        <span>
                                            <strong class="text-danger" id="browsedoc-error"></strong>
                                        </span>
                                    </div>
                                    <div class="col-xl-2 col-lg-12 mt-1" style="display:none;" id="numofrowdiv">
                                        <label strong style="font-size:14px;"># of Rows</label>
                                        <div>
                                            <label id="numofrows" style="font-size: 14px;font-weight:bold;"></label>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-12 mt-1" style="display:none;text-align:right;" id="btndiv">
                                        <label strong style="font-size: 14px;"></label>
                                        <div>
                                            <button type="submit" id="importbtn" class="btn btn-info waves-effect waves-float waves-light">Import</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider">
                                    <div class="divider-text">-</div>
                                </div>
                                <div class="table-responsive">
                                    <div id="excel_data" class="mt-1 mb-1"></div>
                                </div>
                            </div>
                        </form>
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

        $(document).ready( function () {
            $('#sheetnumdiv').hide();
            $('#browsediv').hide();
            $('#btndiv').hide();
            $('#numofrowdiv').hide();
            $('#clearbtnid').hide();
            $('#excel_file').val("");
        });

        function doctypefn() 
        {
            $('#doctype-error').html("");
            $('#sheetnumdiv').show();
            $('#SheetNumber').val("1");
            $('#browsediv').show();
            $('#excel_data').hide();
            $('#excel_file').val("");
            $('#clearbtnid').hide();
            $('#btndiv').hide();
            $('#numofrowdiv').hide();
        }
        
        function sheetNumberfn() 
        {
            var sheetnum=$('#SheetNumber').val();
            if(!isNaN(parseFloat(sheetnum))){
                $('#browsediv').show();
            }
            if(isNaN(parseFloat(sheetnum))){
                $('#browsediv').hide();
                $('#excel_file').val("");
                $('#excel_data').hide();
            }
            $('#sheetnum-error').html("");
        }

        function clearData() 
        {
            $('#excel_data').hide();
            $('#excel_file').val("");
            $('#clearbtnid').hide();
            $('#numofrowdiv').hide();
            $('#btndiv').hide();
        }

        function numformat(val) {
            while (/(\d+)(\d{3})/.test(val.toString())) {
                val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
            }
            return val;
        }

        function containsDuplicates(a) {
            for (let i = 0; i < a.length; i++) {
                if (a.indexOf(a[i]) !== a.lastIndexOf(a[i])) {
                    return 1
                }
            }
            return 0
        }

        function getOccurrence(array, value) {
            var count = 0;
            array.forEach((v) => (v === value && count++));
            return count;
        }

        $('#Register').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "{{url('importdata')}}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    cardSection.block({
                        message:
                            '<div class="d-flex justify-content-center align-items-center"><p class="mr-50 mb-50">Loading Please Wait...</p><div class="spinner-grow spinner-grow-sm text-white" role="status"></div></div>',
                        css: {
                            backgroundColor: 'transparent',
                            color: '#fff',
                            border: '0'
                        },
                        overlayCSS: {
                            opacity: 0.5
                        }
                    });
                    $('#importbtn').text('Importing...');
                    $('#importbtn').prop("disabled", false);
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
                   
                    if (data.imperror) {
                        toastrMessage('error',data.imperror,"Error");
                        $('#importbtn').text('Import');
                        $('#importbtn').prop("disabled", false);
                    }
                    if (data.success) {
                        var doctypes="";
                        $("#doctype :selected").each(function() {
                            doctypes=this.text+" ";
                        });
                        $('#importbtn').text('Import');
                        $('#importbtn').prop("disabled", false);
                        $('#sheetnumdiv').hide();
                        $('#browsediv').hide();
                        $('#btndiv').hide();
                        $('#numofrowdiv').hide();
                        $('#clearbtnid').hide();
                        $('#excel_file').val("");
                        $('#excel_data').hide();
                        $('#doctype').val(null).trigger('change');
                        toastrMessage('success',doctypes+" Imported Successfully","Success");
                    }
                },
            });
        });
   
        var excel_file = document.getElementById('excel_file');
        var opt=document.getElementById('doctype');
        var shnum=document.getElementById('SheetNumber');
        $('#excel_data').empty();
        var arraya = [];
        var arrayb = [];
        var arrayc = [];
        var arrayd = [];
        var itemcoderow=0;
        var itemnamerow=0;
        var itemskurow=0;
        var itempnumow=0;
        var cuscoderow=0;
        var cusnamerow=0;
        var catnamerow=0;
        var uomnamerow=0;
        var strnamerow=0;
        var begnamerow=0;
        
        excel_file.addEventListener('change', (event) => {
            if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
            {
                document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';
                excel_file.value = '';
                return false;
            }
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
            var reader = new FileReader();
            reader.readAsArrayBuffer(event.target.files[0]);
            reader.onload = function(event){
                var data = new Uint8Array(reader.result);
                var work_book = XLSX.read(data, {type:'array'});
                var sheet_name = work_book.SheetNames;
                var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[$('#SheetNumber').val()-1]], {header:1});
                if(sheet_data.length > 0)
                {
                    arraya=[];
                    arrayb=[];
                    arrayc=[];
                    arrayd=[];
                    itemcoderow=0;
                    itemnamerow=0;
                    itemskurow=0;
                    itempnumow=0;
                    cuscoderow=0;
                    cusnamerow=0;
                    uomnamerow=0;
                    strnamerow=0;
                    begnamerow=0;
                    var table_output = '<table class="table table-striped table-bordered table-sm">';
                    for(var row = 0; row < sheet_data.length; row++)
                    {
                        if(row!=0){
                            if(parseFloat($('#doctype').val())==1){
                                arraya.push(sheet_data[row][0]);
                                if(getOccurrence(arraya,sheet_data[row][0])>1){
                                    catnamerow=row;
                                }
                            }
                            if(parseFloat($('#doctype').val())==2){
                                arraya.push(sheet_data[row][0]);
                                if(getOccurrence(arraya,sheet_data[row][0])>1){
                                    uomnamerow=row;
                                }
                            }
                            if(parseFloat($('#doctype').val())==3){
                                arraya.push(sheet_data[row][0]);
                                arrayb.push(sheet_data[row][1]);
                                arrayc.push(sheet_data[row][19]);
                                arrayd.push(sheet_data[row][17]);
                                if(getOccurrence(arraya,sheet_data[row][0])>1){
                                    itemcoderow=row;
                                }
                                if(getOccurrence(arrayb,sheet_data[row][1])>1){
                                    itemnamerow=row;
                                }
                                if(getOccurrence(arrayc,sheet_data[row][19])>1){
                                    itemskurow=row;
                                }
                                if(getOccurrence(arrayd,sheet_data[row][17])>1){
                                    itempnumow=row;
                                }
                            }
                            if(parseFloat($('#doctype').val())==4){
                                arraya.push(sheet_data[row][0]);
                                arrayb.push(sheet_data[row][1]);
                                if(getOccurrence(arraya,sheet_data[row][0])>1){
                                    cuscoderow=row;
                                }
                                if(getOccurrence(arrayb,sheet_data[row][1])>1){
                                    cusnamerow=row;
                                }
                            }
                            if(parseFloat($('#doctype').val())==5){
                                arraya.push(sheet_data[row][1]);
                                if(getOccurrence(arraya,sheet_data[row][1])>1){
                                    strnamerow=row;
                                }
                            }
                            if(parseFloat($('#doctype').val())==6){
                                arraya.push(sheet_data[row][1]);
                                if(getOccurrence(arraya,sheet_data[row][1])>1){
                                    begnamerow=row;
                                }
                            }
                        }
                        
                        table_output += '<tr>';
                        for(var cell = 0; cell < sheet_data[row].length; cell++)
                        {
                            if(row == 0)
                            {
                                table_output += '<th>'+sheet_data[row][cell]+'</th>';
                            }
                            else
                            {
                                if(parseFloat($('#doctype').val())==1){
                                    if(row==catnamerow && cell==0){
                                        if(row==catnamerow && cell==0){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][0]+'</td>';
                                        }
                                    }
                                    else{
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }

                                else if(parseFloat($('#doctype').val())==2){
                                    if(row==uomnamerow && cell==0){
                                        if(row==uomnamerow && cell==0){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][0]+'</td>';
                                        }
                                    }
                                    else{
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }

                                else if(parseFloat($('#doctype').val())==3){
                                    if((row==itemcoderow && cell==0)||(row==itemnamerow && cell==1)||(row==itempnumow && cell==17)||(row==itemskurow && cell==19)){
                                        if(row==itemcoderow && cell==0){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][0]+'</td>';
                                        }
                                        if(row==itemnamerow && cell==1){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][1]+'</td>';
                                        }
                                        if(row==itempnumow && cell==17){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][17]+'</td>';
                                        }
                                        if(row==itemskurow && cell==19){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][19]+'</td>';
                                        }
                                    }
                                    else{
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }

                                else if(parseFloat($('#doctype').val())==4){
                                    if((row==cuscoderow && cell==0)||(row==cusnamerow && cell==1)){
                                        if(row==cuscoderow && cell==0){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][0]+'</td>';
                                        }
                                        if(row==cusnamerow && cell==1){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][1]+'</td>';
                                        }
                                    }
                                    else{
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }

                                else if(parseFloat($('#doctype').val())==5){
                                    if(row==strnamerow && cell==1){
                                        if(row==strnamerow && cell==1){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][1]+'</td>';
                                        }
                                    }
                                    else{
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }

                                else if(parseFloat($('#doctype').val())==6){
                                    if(row==begnamerow && cell==1){
                                        if(row==begnamerow && cell==1){
                                            table_output += '<td style="background-color:#ea5455;color:#ffffff;">'+sheet_data[row][1]+'</td>';
                                        }
                                    }
                                    else{
                                        table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                    }
                                }

                                else{
                                    table_output += '<td>'+sheet_data[row][cell]+'</td>';
                                }

                                $('#numofrows').html(numformat(row)+" <i>Rows</i>");
                            }
                        }
                        table_output += '</tr>';
                        itemcoderow=0;
                        itemnamerow=0;
                        itemskurow=0;
                        cuscoderow=0;
                        cusnamerow=0;
                        catnamerow=0;
                        uomnamerow=0;
                    }
                    table_output += '</table>';
                    document.getElementById('excel_data').innerHTML = table_output;
                    $('#excel_data').show();
                    $('#btndiv').show();
                    $('#numofrowdiv').show();
                    $('#clearbtnid').show();
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
                }
            }
        });
    </script>

@endsection
