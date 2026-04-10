<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $table='customers';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['Name','Code','CustomerCategory','DefaultPrice','TinNumber','VatNumber','MRCNumber','VatType','Witholding','PhoneNumber','OfficePhone',
    'EmailAddress','Address','Website','Country','Memo','ActiveStatus','Reason','IsDeleted','CreditLimitPeriod','CreditLimit','salesamount','IsAllowedCreditSales',
    'CreditSalesLimitStart','CreditSalesLimitEnd','CreditSalesLimitFlag','CreditSalesLimitDay','CreditSalesAdditionPercentage','SettleAllOutstanding','MinimumPurchaseAmount',
    'IsWholesaleBefore','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'
    ];
}
