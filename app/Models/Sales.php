<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table='sales';
    public $primarykey='id';
    public $fillable = ['CustomerId', 'PaymentType','VoucherNumber',
    'VoucherType','VoidedDate','StoreId','SubTotal','Tax','GrandTotal',
    'Status','Common','CustomerMRC','WitholdAmount','NetPay','Vat','Username',
    'DiscountAmount','DiscountPercent','CheckedBy','CheckedDate','ConfirmedBy',
    'ConfirmedDate','ChangeToPendingBy','ChangeToPendingDate','VatSetle',
    'WitholdSetle','VoidedBy','RefundBy','RefundDate','UnvoidBy','UnVoidDate',
    'CreatedDate','witholdNumber','vatNumber','Np',
];
    public $timestamps=true; 
}
