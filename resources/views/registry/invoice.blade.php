<!DOCTYPE html>
<html lang="ar">
<!-- <html lang="ar"> for arabic only -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Barcode Printed</title>
    <style>
        @media print {
            @page {
                /* margin-top: 0 auto; /* imprtant to logo margin */
                /*imprtant to set paper size */
            }
            html {
                /* direction: rtl; */
            }
            html,body{}
            #printContainer {
                
               
                /*padding: 10px;*/
                /*border: 2px dotted #000;*/
          
            }

           
           
        }
        


        .imgs
           {
               display: inline-block;
               width: 1500px;
               height: 700px;
                /* padding-left: 5px !important;
                padding-top: -100px !important; */
              

           }
           /* #code
           {
            font-size: 20px;
           } */
    </style>
</head>
<body>
<h1 id="logo" class="text-center"></h1>

<div id='printContainer'>
    <h1 id="code" style="margin-top:0; text-align:center; font-size:100px;" >{{$bacode->Code}}</h1>
    <img class="imgs" src="data:image/png;base64,{{ chunk_split(base64_encode($bacode->BarcodeImage)) }}">
    
</div>
</body>
<script  type="text/javascript">

    window.onload = function () {
    window.print();
    setTimeout(window.close, 0);
}


</script>
</html>