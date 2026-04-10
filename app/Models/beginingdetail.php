<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class beginingdetail extends Model
{
    use HasFactory;
    protected $table='beginingdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','DestStoreId',
    'LocationId','RetailerPrice','Wholeseller','Date','RequireSerialNumber','RequireExpireDate','ConvertedQuantity','ConversionAmount',
    'NewUOMId','DefaultUOMId','ItemType','PartNumber','Memo','Common','TransactionType' ];
}
