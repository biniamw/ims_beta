<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deadstocksale extends Model
{
    use HasFactory;
    protected $table='deadstocksale';
    public $primarykey='id';
    public $fillable = ['Type','DocumentNumber','CustomerId','PaymentType','VoucherType','VoucherNumber','Reference',
    'CustomerMRC','DestinationStore','StoreId','PurchaserName','IsVoid','VoidReason','VoidedBy','VoidDate',
    'unVoidBy','unVoidDate','CreatedDate','TransactionDate','Status','StatusOld','WitholdPercent','WitholdAmount',
    'SubTotal','Tax','GrandTotal','NetPay','Username','ReceivedBy','DeliveredBy','Common','Memo','CreatedBy',
    'CheckedBy','CheckedDate','ApprovedBy','ApprovedDate','ConfirmedBy','ConfirmedDate','ChangeToPendingBy',
    'ChangeToPendingDate','IsHide','FiscalYear'];
                        
    public $timestamps=true; 
    public function items(){
        return $this->belongsToMany(Regitem::class,'deadstocksalesitems','HeaderId','ItemId')->withTimestamps();
    }
}
