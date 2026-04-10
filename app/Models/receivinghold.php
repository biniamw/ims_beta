<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receivinghold extends Model
{
    use HasFactory;
    protected $table='receivingholds';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['Type','DocumentNumber', 'CustomerId','PaymentType','VoucherStatus','VoucherType','VoucherNumber','InvoiceNumber','CustomerMRC','StoreId',
    'PurchaserName','IsVoid','VoidReason','VoidedBy','VoidedDate','TransactionDate','Status','WitholdPercent','WitholdAmount',
    'SubTotal','Tax','GrandTotal','NetPay','Username','Memo','Common','fiscalyear'
    ];

   public function items(){
        return $this->belongsToMany(Regitem::class,'receivingholddetails','HeaderId','ItemId')->withTimestamps();
    }
}
