<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deadstockrec extends Model
{
    use HasFactory;
    protected $table = 'deadstockrecs';
    public $primarykey = 'id';
    public $fillable = ['Type','DocumentNumber','CustomerId','PaymentType','VoucherType','VoucherNumber','CustomerMRC',
                        'SourceStore','StoreId','PurchaserName','IsVoid','VoidReason','VoidedBy','VoidedDate','TransactionDate',
                        'Status','StatusOld','WitholdPercent','WitholdAmount','SubTotal','Tax','GrandTotal','NetPay','Username',
                        'ReceivedBy','DeliveredBy','Common','Memo','CheckedBy','CheckedDate','ConfirmedBy','ConfirmedDate',
                        'ChangeToPendingBy','ChangeToPendingDate','IsHide'
                    ];
                        
    public $timestamps = true; 
}
