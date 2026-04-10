<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
    <head>
        <style>
           
           body 
           { 
               margin:-35;
               padding:14; 
               display:flex;
            }
            h1,h2,h3,h4,h5,h6,p,span,div { 
                font-family: Arial, Helvetica, sans-serif;  
                font-size:14px;
                font-weight: normal;
            }
            th,td { 
                font-family: Arial, Helvetica, sans-serif;  
                font-size:14px;
            }
            
            .container {
  display: flex;
  flex-direction: column;
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
            table thead th { 
                background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
            }
            .headerTable
            {
                border-bottom: 1px solid black; 
                margin-top:1px;
            }
            .doctitle
            {
                font-size:1.5rem;
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
            td{
                border: 1px solid black;
            }
            #firstdiv {
                order: 4;
            } 
            #seconddiv {
                order: 3;
            } 
            #thirddiv {
                order: 2;
            } 
            #fourthdiv{
                order: 1;
            }
        </style>
      

    </head>
    <body>
        <htmlpageheader name="myheader">
            <table style="border: 0px solid white;">
                <tr>
                    <td colspan="3" style="border: 0px solid white;">
                        <table class="headerTable">
                            <tr>
                                <td colspan="6" class="headerTitles" style="text-align: center;border: 0px solid white;"><b>{{$companyname}}</b></td>
                                {{-- <td rowspan="4" style="width:15%;border:none;"><img src="data:image/png;base64,{{ chunk_split(base64_encode($compInfo->Logo)) }}" width="150" height="150"></td> --}}
                            </tr>
                            <tr>
                                <td style="border: 0px solid white;"><b>TIN : </b></td>
                                <td style="border: 0px solid white;" colspan="2">{{$companytin}}</td>
                                <td style="border: 0px solid white;"><b>Address: </b></td>
                                <td style="border: 0px solid white;" colspan="2">{{$companyaddress}}</td>
                                
                            </tr>
                            <tr>
                                <td style="border: 0px solid white;"><b>VAT No.: </b></td>
                                <td style="border: 0px solid white;" colspan="2">{{$companyvat}}</td>
                                <td style="border: 0px solid white;"><b>Email: </b></td>
                                <td style="border: 0px solid white;" colspan="2">{{$companyemail}}</td>
                            </tr>
                            <tr>
                                <td style="width: 10%;border: 0px solid white;"><b>Phone: </b></td>
                                <td style="width: 40%;border: 0px solid white;" colspan="2">{{$companyphone}},{{$companyoffphone}}</td>
                                <td style="width: 10%;border: 0px solid white;"><b>Website: </b></td>
                                <td style="width: 40%;border: 0px solid white;" colspan="2">{{$companywebsite}}</td>   
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
        <div style="border-top: 1px solid #000000; font-size: 9pt;padding-top: 3mm; ">
            <table style="width: 100%">  
                <tr>
                    <td style="border: 0px solid white;"><b>Printed on: </b>{{$currentdate}}</td>
                    <td style="text-align: right;border: 0px solid white;">Page {PAGENO} of {nb}</td>
                </tr>
            </table>
        </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
        <sethtmlpagefooter name="myfooter" value="on"/>
        <table>
            <tr>
                <td colspan="3" class="headers doctitle" style="border: 0px solid white;"><b>Income Follow-Up Note</b></td>
            </tr>
            <tr>
                <td colspan="3" style="width: 100%;border: 0px solid white;">
                    <table style="width: 100%" class="bordertables">
                        <tbody>
                            <tr class="headerHeight">
                                <td class="headers bordertables" style="height:20px;" colspan="2"><div style="height:20px;"><b>Basic Information</b></div></td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Document Number</b></td>
                                <td class="bordertables">{{$incdoc}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Point of Sales</b></td>
                                <td class="bordertables">{{$storename}}</td>
                            </tr>
                            <tr>
                                <td class="bordertables"><b>Date</b></td>
                                <td class="bordertables">{{$startdate}} to {{$enddate}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <br/>

        <div class="container">
            <div id="seconddiv" style="margin-top:-10px;">
                <table width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
                    <thead>
                        <tr>
                            <th colspan="8" style="text-align: center;" class="bordertables">MRC & Z-Number Information</th>
                        </tr>
                        <tr>
                            <th style="width: 3%;" class="bordertables">#</th>
                            <th style="width: 13%;" class="bordertables">MRC Number</th>
                            <th style="width: 13%;" class="bordertables">Z-Number</th>
                            <th style="width: 13%;" class="bordertables">Z-Date</th>
                            <th style="width: 15%;" class="bordertables">Cash Amount</th>
                            <th style="width: 15%;" class="bordertables">Credit Amount</th>
                            <th style="width: 15%;" class="bordertables">Total Amount</th>
                            <th style="width: 13%;" class="bordertables">Business Day</th>
                        </tr>
                    </thead>
                    @foreach ($detailTable as $det)
                    <tr>           
                        <td style="text-align: center" class="bordertables">{{++$count}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->MrcNumber}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->ZNumber}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->ZDate}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->CashAmounts}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->CreditAmounts}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->TotalAmounts}}</td>
                        <td style="text-align: center" class="bordertables">{{$det->BusinessDays}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div id="thirddiv" style="margin-top:20px;">
                
                <table width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
                    <thead>
                        <tr>
                            <th colspan="8" style="text-align: center;" class="bordertables">Bank & Account Information</th>
                        </tr>
                        <tr>
                            <th style="width: 3%;" class="bordertables">#</th>
                            <th style="width: 10%;" class="bordertables">Payment Mode</th>
                            <th style="width: 18%;" class="bordertables">Bank Name</th>
                            <th style="width: 15%;" class="bordertables">Account Number</th>
                            <th style="width: 14%;" class="bordertables">Transaction Ref.</th>
                            <th style="width: 10%;" class="bordertables">Date</th>
                            <th style="width: 14%;" class="bordertables">Amount</th>
                            <th style="width: 16%;" class="bordertables">Remark</th>
                        </tr>
                    </thead>
                    @foreach ($bankdata as $bdata)
                    <tr>           
                        <td style="text-align: center" class="bordertables">{{++$bcount}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->PaymentType}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->BankName}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->AccountNumber}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->SlipNumber}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->SlipDate}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->Amounts}}</td>
                        <td style="text-align: center" class="bordertables">{{$bdata->Remarks}}</td>
                    </tr>
                    @endforeach
                </table></br>
                <table style="border: 0px solid white;">
                    <tr style="border: 0px solid white;">
                        <td style="width:50%;border: 0px solid white;"></td>
                        <td style="width:50%;border: 0px solid white;">
                            <table style="width: 100%" class="bordertables">
                                <tbody>
                                    <tr>
                                        <td style="width: 40%" class="bordertables">Total Cash Deposited</td>
                                        <td style="width: 60%;text-align:center" class="bordertables">{{$totalcashdep}}</td>
                                    </tr>
                                    <tr>
                                        <td class="bordertables">Total Cash Received</td>
                                        <td style="text-align:center" class="bordertables">{{$totalcash}}</td>
                                    </tr>
                                    @if($witholds>0)
                                    <tr>
                                        <td class="bordertables">Witholding</td>
                                        <td style="text-align:center" class="bordertables">{{$witholds}}</td>
                                    </tr>
                                    @endif
                                    @if($vats>0)
                                    <tr>
                                        <td class="bordertables">Vat</td>
                                        <td style="text-align:center" class="bordertables">{{$vats}}</td>
                                    </tr>
                                    @endif
                                    @if($witholds>0 || $vats>0)
                                    <tr>
                                        <td class="bordertables">Net Cash Received</td>
                                        <td style="text-align:center" class="bordertables">{{$netcashrec}}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table></br>
                <div>Memo:  <u>{{$mem}}</u></div><br>
                <table style="width: 100%">
                    <tr>
                        <td style="border: 0px solid white;">
                            <table style="width: 100%">
                                <tr>
                                    <td id="prepbylbl" class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Prepared By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 0px solid white;"><b>Name: </b><u>{{$preparedby}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$transactiondate}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                                </tr>
                            </table>
                        </td>
                        <td style="border: 0px solid white;">
                            <table style="width: 100%">
                                <tr>
                                    <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Verified By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 0px solid white;"><b>Name: </b><u>{{$checkedby}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$checkeddate}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                                </tr>
                            </table>
                        </td>
                        <td style="border: 0px solid white;">
                            <table style="width: 100%">
                                <tr>
                                    <td class="headers bordertables" style="height:15px;" colspan="2"><div style="height:15px;"><b>Confirmed By</b></div></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border: 0px solid white;"><b>Name: </b><u>{{$confirmedby}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Date: </b><u>{{$confirmeddate}}</u></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bordertablessign"><b>Signature: </b>____________________</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
            </div>
            <div id="fourthdiv" style="margin-top:10px;">
                
                
            </div>
        </div>
    </body>
</html>
