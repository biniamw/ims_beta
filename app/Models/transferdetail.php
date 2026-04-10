<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transferdetail extends Model
{
    use HasFactory;
    protected $table='transferdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId','Quantity','ApprovedQuantity','IssuedQuantity','DispatchQuantity','ReceivedQuantity','UnitCost',
    'BeforeTaxCost','TaxAmount','TotalCost','StoreId','DestStoreId','LocationId','RetailerPrice','Wholeseller','Date','RequireSerialNumber',
    'RequireExpireDate','ConvertedQuantity','ConversionAmount','NewUOMId','DefaultUOMId','ItemType','PartNumber','Memo','ApprovedMemo','Common',
    'TransactionType','SerialnumIds'];
}
