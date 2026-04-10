<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaItem extends Model
{
    use HasFactory;
    protected $table='proforma_regitem';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = [ 'regitem_id', 'proforma_id', 'Quantity', 'UnitPrice', 'store_id', 'BeforeTaxPrice','TotalPrice', 'TaxAmount', 'RetailerPrice', 
    'RetailerPrice', 'Wholeseller', 'ConvertedQuantity', 'ConversionAmount', 'NewUOMId', 'DefaultUOMId', 'Memo', 'TransactionType', 'ItemType'
     ];
}
