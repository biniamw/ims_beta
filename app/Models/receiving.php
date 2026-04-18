<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receiving extends Model
{
    use HasFactory;
    protected $table='receivings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = [
        'Type','source_type','DocumentNumber','productiono','requisitiono','CustomerId','PaymentType','VoucherStatus',
        'VoucherType','VoucherNumber','InvoiceNumber','CustomerMRC','StoreId','PurchaserName','IsVoid','VoidReason','VoidedBy','VoidedDate',
        'TransactionDate','Status','StatusOld','WitholdPercent','WitholdAmount','SubTotal','Tax','GrandTotal','NetPay','Username','ReceivedBy',
        'DeliveredBy','Common','form_uuid','fiscalyear','Memo','CheckedBy','CheckedDate','ConfirmedBy','ConfirmedDate','ChangeToPendingBy','ChangeToPendingDate',
        'IsHide','UndoVoidBy','UndoVoidDate','EditConfirmedBy','EditConfirmedDate','ProductType','PoId','CommoditySource','CommodityType','CompanyType',
        'CustomerOrOwner','DeliveryOrderNo','DispatchStation','DriverName','TruckPlateNo','DriverPhoneNo','ReceivedDate','CurrentDocumentNumber',
        'IsFromProcurement','InvoiceStatus','is_cost_shown','FileName'
    ];

    public function items(){
        return $this->belongsToMany(Regitem::class,'receivingdetails','HeaderId','ItemId')->withTimestamps();
    }
}
