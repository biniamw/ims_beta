<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
         
            @page 
            {
                margin: 100px 40px;
            }
            header {
                position: fixed;
                top: -50px;
                left: 0px;
                right: 0px;
                height: 100px;
            }
            footer 
            {
                position: fixed; 
                bottom: -50px; 
                left: 0px; 
                right: 0px;
                height: 100px; 

            }
           body 
           { 
               margin:-35;
               padding:14; 
            }
            h1,h2,h3,h4,h5,h6,p,span,div { 
                font-family: Arial, Helvetica, sans-serif;  
                font-size:14px;
                font-weight: normal;
            }
            th,td { 
                font-family: Times, Times New Roman, serif;
                font-size:14px;
            }
            
            table {
                width: 100%;
                max-width: 100%;
                margin-bottom: 0px;
                border-spacing: 0;
                border-collapse: collapse;
                background-color: transparent;
                margin-left: 0%;
                table-layout:fixed;
            }
            thead  {
                text-align: left;
                display: table-header-group;
                vertical-align: middle;
            }
            th, td  {
               
                padding: 6px;
            }
           
            .headers
            {
                text-align:center;
            }
            .bordertables
            {
                border: 1px solid black;
            }
            .bordertableswhite
            {
                border: 1px solid white;
                color:white;
            }
            .bordertablessign
            {
                border: 1px solid white;
            }
            .headerHeight
            {
                height: 100px;
            }
            .doctitle
            {
                font-size:1.5rem;
            }
            .headerTable
            {
                border-bottom: 1px solid black; 
                margin-top:0px;
            }
            .headerTitles
            {
                text-align:center;
                font-size:1.7rem;
            }
            table td img {
                display: inline-block;  
                float: left;
                width: 100%;
                height: 120px;
                table-layout: fixed; 
            }
        </style>
    </head>
    <body>
    <div id="html1" style='position: absolute'>

        <table id="tblMembers">
            <tr>
                <td colspan="3">
                    <table class="headerTable">
                        <tr>
                            <td colspan="6" class="headerTitles"><b>{{$companyname}}</b></td>
                            <td rowspan="4"><img src="data:image/png;base64,{{chunk_split(base64_encode($companyLogo))}}"></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;"><b>Tel: </b></td>
                            <td style="width: 50%;" colspan="2">{{$companyphone}},{{$companyoffphone}}</td>
                            <td style="width: 10%;"><b>Website: </b></td>
                            <td style="width: 30%;" colspan="2">{{$companywebsite}}</td>
                        </tr>
                        <tr>
                            <td><b>Email: </b></td>
                            <td colspan="2">{{$companyemail}}</td>
                            <td><b>Address: </b></td>
                            <td colspan="2">{{$companyaddress}}</td>
                        </tr>
                        <tr>
                            <td><b>TIN No.: </b></td>
                            <td colspan="2">{{$companytin}}</td>
                            <td><b>VAT No.: </b></td>
                            <td colspan="2">{{$companyvat}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="headers doctitle"><b>Sales Detail Report</b></td>
            </tr>
            
            <tr>
                <td colspan="3">
                    <table id="example" style="width: 100%" class="headers bordertables">
                        <thead>
                            <tr>
                               
                                <th style="width: 14%;" class="bordertables">Category</th>
                                <th style="width: 30%;" class="bordertables">Item Name</th>
                                <th style="width: 13%;" class="bordertables">Quantity</th>
                                <th style="width: 9%;" class="bordertables">SubTotal</th>
                                <th style="width: 8%;" class="bordertables">Tax</th>
                                <th style="width: 8%;" class="bordertables">Total Price</th>
                                
                            </tr>
                        </thead>
                        @foreach ($report as $r)
                        <tr>           
                            
                            <td class="bordertables">{{$r->Category}}</td>
                            <td class="bordertables">{{$r->Name}}</td>
                            <td class="bordertables">{{$r->Quantity}}</td>
                            <td class="bordertables">{{$r->SubTotal}}</td>
                            <td class="bordertables">{{$r->Tax}}</td>
                            <td class="bordertables">{{$r->TotalPrice}}</td>
                            
                        </tr>
                    @endforeach
                    </table>
                </td>
            </tr>
            <tr>
                <table style="width: 100%">
                    <tr>
                        <td>
                            <table style="width: 100%">
                                <tr>
                                    <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Adjusted By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Name: </b><u></u></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                </table>
            </tr>
        </table>
        <!-- <footer>
            <table>
                <tr>
                    <td style="height:30px;"><div style="height:30px;"><p style="color: white;"><b>.</b>.</p><br><p style="color: white;"><b>.</b>.</p>
                        <br><p style="">{{$systemalladdress}}</p>
                    </div></td>
                </tr>
                <tr>
                    <td style="height:5px; border-bottom: 1px solid black;"><div style="height:5px;"><p><b>Printed on: </b>{{$currentdate}}</p></div></td>
                </tr>
            </table>
        </footer> -->
        </div>
    
        </body>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="../../../app-assets/js/jquery.table.marge.js"></script>
    <script src='../../../app-assets/dist/jspdf.min.js'></script>
    <script src='../../../app-assets/dist/jspdf.debug.js'></script>
    
   
   
   <script>
    
    $(document).ready(function() {
       
  var table = $("table");
var rows = table.find($("tr"));
var colsLength = $(rows[0]).find($("td")).length;
var removeLater = new Array();
for(var i=0; i<colsLength; i++){
    var startIndex = 0;
    var lastIndex = 0;
    var startText = $($(rows[0]).find("td")[i]).text();
    for(var j=1; j<rows.length; j++){
        var cRow =$(rows[j]);
        var cCol = $(cRow.find("td")[i]);
        var currentText = cCol.text();
        if(currentText==startText){
            cCol.css("background","gray");
            console.log(cCol);
            removeLater.push(cCol);
            lastIndex=j;
        }else{
            var spanLength = lastIndex-startIndex;
            if(spanLength>=1){
                console.log(lastIndex+" - "+startIndex)
                //console.log($($(rows[startIndex]).find("td")[i]))
                $($(rows[startIndex]).find("td")[i]).attr("rowspan",spanLength+1);
            }
            lastIndex = j;
            startIndex = j;
            startText = currentText;
        }
            
    }
    var spanLength = lastIndex-startIndex;
            if(spanLength>=1){
                console.log(lastIndex+" - "+startIndex)
                //console.log($($(rows[startIndex]).find("td")[i]))
                $($(rows[startIndex]).find("td")[i]).attr("rowspan",spanLength+1);
            }
    console.log("---");
}

for(var i in removeLater){
    $(removeLater[i]).remove();
}
    
        });

    // $('#example').margetable({

    // type: 2,

    // colindex: [0, 1]// column 1, 2
    // });

    </script>
    

</html>
