<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table='sales';
    public $primarykey='id';
    public $fillable = ['CustomerId', 'PaymentType','VoucherNumber','invoiceNo','VoucherType','VoidedDate','StoreId','SubTotal','Tax','GrandTotal',
    'Status','Common','CustomerMRC','WitholdAmount','NetPay','Vat','Username','DiscountAmount','DiscountPercent','CheckedBy','CheckedDate','ConfirmedBy',
    'ConfirmedDate','ChangeToPendingBy','ChangeToPendingDate','VatSetle','WitholdSetle','VoidedBy','RefundBy','RefundDate','UnvoidBy','UnVoidDate','CreatedDate',
    'witholdNumber','vatNumber','Np','type','proforma_id','memo','VoidReason','wholesalexpireflag','lasteditedby','lasteditedate','issalesissettled','creditpercentage',
    'settlementexpiredate','salestype'
];
    public $timestamps=true;
    public function items(){
        return $this->belongsToMany(Regitem::class,'salesitems','HeaderId','ItemId')->withTimestamps();
    }
        public function transation(){
        return $this->belongsToMany(Regitem::class,'transactions','StoreId','ItemId')->withTimestamps();
    }

    public function customers(){
        return $this->belongsTo(customer::class,'CustomerId');
    }
    public function stores(){
        return $this->belongsTo(store::class,'StoreId');
    }
    public function trans()
    {
        return $this->hasManyThrough(Regitem::class, transaction::class,'transactions','StoreId','ItemId');
    }

    public function salesitems(){
        return $this->hasMany(Salesitem::class,'HeaderId');
    }
    
}
