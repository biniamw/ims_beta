<?php
namespace App\Reports;
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;
use \koolreport\processes\DateTimeFormat;
use koolreport\KoolReport;


class IncomeFollowUpBank extends \koolreport\KoolReport
{
    use \koolreport\laravel\Friendship;
    use \koolreport\bootstrap4\Theme;

    function setup () 
    {  
        $id = $this->params["id"];
        $this->src('mysql')  // use any of your preferred connection type in config/database.php
        ->query('SELECT banks.BankName,bankdetails.AccountNumber,incomeclosingbanks.SlipNumber,incomeclosingbanks.Amount FROM incomeclosingbanks INNER JOIN banks ON incomeclosingbanks.banks_id=banks.id INNER JOIN bankdetails ON incomeclosingbanks.bankdetails_id=bankdetails.id WHERE incomeclosingbanks.incomeclosings_id='.$id.' ORDER BY incomeclosingbanks.id ASC')
        ->pipe($this->dataStore('incbanksrc'));
    }
}