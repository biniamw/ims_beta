<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesHold extends Model
{
    use HasFactory;
    protected $table='sales_holds';
    public $primarykey='id';
    public $fillable = ['CustomerId', 'PaymentType','VoucherNumber','VoucherType','VoidedDate','StoreId','SubTotal','Tax','GrandTotal','Status','Common','CustomerMRC','WitholdAmount','NetPay','Vat','Username','DiscountAmount','DiscountPercent'];
    public $timestamps=true; 
}
