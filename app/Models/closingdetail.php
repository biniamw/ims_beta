<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class closingdetail extends Model
{
    use HasFactory;
    protected $table='closingdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['header_id','item_id','Quantity','PhysicalCount','ShortageVariance','OverageVariance','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','store_id','deststore_id',
    'location_id','RetailerPrice','Wholeseller','Date','RequireSerialNumber','RequireExpireDate','ConvertedQuantity','ConversionAmount',
    'newuom_id','defaultuom_id','ItemType','PartNumber','Memo','Common','TransactionType'];
}
