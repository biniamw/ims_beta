<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjustmentdetail extends Model
{
    use HasFactory;
    protected $table='adjustmentdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId', 'StockIn','StockOut','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StockOutUnitCost','StockOutBeforeTaxCost',
    'StockOutTaxAmount','StockOutTotalCost','StoreId','DestStoreId','LocationId','RetailerPrice','Wholeseller','Date','RequireSerialNumber','RequireExpireDate',
    'ConvertedQuantity','ConversionAmount','NewUOMId','DefaultUOMId','ItemType','PartNumber','Memo','Common','TransactionType','Reason','SupplierId', 'GrnNumber', 
    'CertNumber', 'ProductionNumber', 'woredas_id', 'CommodityType', 'Grade', 'ProcessType', 'CropYear', 'uoms_id', 'NumOfBag', 'BagWeight', 'TotalKg', 'NetKg', 
    'Feresula', 'unit_cost_or_price', 'total_cost_or_price', 'VarianceShortage', 'VarianceOverage', 'Remark'];
}
