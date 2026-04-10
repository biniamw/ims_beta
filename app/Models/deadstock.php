<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deadstock extends Model
{
    use HasFactory;
    protected $table='deadstockrecs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['Type','DocumentNumber', 'CustomerId','PaymentType','VoucherType','VoucherNumber','SourceStore','CustomerMRC','StoreId',
    'PurchaserName','IsVoid','VoidReason','VoidedBy','VoidedDate','TransactionDate','Status','StatusOld','WitholdPercent','WitholdAmount',
    'SubTotal','Tax','GrandTotal','NetPay','Username','ReceivedBy','ReceivedDate','DeliveredBy','Common','Memo','CreatedBy','CreatedDate','CheckedBy','CheckedDate',
    'ConfirmedBy','ConfirmedDate','ChangeToPendingBy','ChangeToPendingDate','IsHide','FiscalYear'];
    public function items(){
        return $this->belongsToMany(Regitem::class,'deadstockdetails','HeaderId','ItemId')->withTimestamps();
    }
}
