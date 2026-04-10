<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receivingholddetail extends Model
{
    use HasFactory;
    protected $table='receivingholddetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','LocationId','RetailerPrice','Wholeseller',
    'Date','RequireSerialNumber','RequireExpireDate','ConvertedQuantity','ConversionAmount','NewUOMId','DefaultUOMId','IsVoid','Memo','Common','TransactionType',
    'ItemType','RequireSerialNumber','RequireExpireDate'
    ]; 
}
