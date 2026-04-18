<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receivingdetail extends Model
{
    use HasFactory;
    protected $table='receivingdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId',
    'LocationId','RetailerPrice','Wholeseller','Date','RequireSerialNumber','RequireExpireDate','ConvertedQuantity','ConversionAmount',
    'NewUOMId','DefaultUOMId','IsVoid','Memo','Common','item_uuid','PoDetId','CommodityType','CommodityId','Grade','ProcessType','CropYear','NumOfBag',
    'TotalKg','NetKg','Feresula','VarianceShortage','VarianceOverage','TransactionType','TransactionsType','ItemType']; 
}
