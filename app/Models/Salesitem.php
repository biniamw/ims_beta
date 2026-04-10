<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salesitem extends Model
{
    use HasFactory;
    protected $table='salesitems';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId', 'Quantity', 'UnitPrice','BeforeTaxPrice',
    'TaxAmount','TotalPrice','Common','Discount','StoreId','TransactionType','ConvertedQuantity',
    'ConversionAmount','NewUOMId','DefaultUOMId','ItemType','DiscountAmount','Dprice'];

   
}
