<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;
    protected $table='proformas';
    public $primarykey='id';
    public $fillable = [ 'CustomerId', 'DocumentNumber', 'ContactPerson', 'ContactPersonPhone', 'store_id', 'TransactionDate', 'WitholdPercent', 'WitholdAmount', 
    'DiscountPercent', 'DiscountAmount', 'SubTotal', 'Tax', 'GrandTotal', 'NetPay', 'Vat', 'Status', 'OldStatus', 'Username', 'OrderBy', 'Common', 'CheckedBy', 
    'CheckedDate', 'ConfirmedBy', 'ConfirmedDate', 'ChangeToPendingBy', 'ChangeToPendingDate', 'CreatedDate', 'Memo', 'UnvoidBy', 'UnVoidDate', 'WitholdSetle', 
    'VatSetle', 'witholdNumber', 'vatNumber', 'RfQNumber'
     ];
    public $timestamps=true; 

    public function items()
    {
        return $this->belongsToMany(Regitem::class);
    }
}
