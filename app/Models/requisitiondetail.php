<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requisitiondetail extends Model
{
    use HasFactory;
    protected $table='requisitiondetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId', 'Quantity','UnitCost','BeforeTaxCost','TaxAmount','TotalCost','StoreId','DestStoreId',
    'LocationId','RetailerPrice','Wholeseller','Date','RequireSerialNumber','RequireExpireDate','ConvertedQuantity','ConversionAmount',
    'NewUOMId','DefaultUOMId','ItemType','PartNumber','Memo','Common','TransactionType','CommodityId','CommodityType','Grade','ProcessType',
    'CropYear','NumOfBag','TotalKg','NetKg','Feresula','VarianceShortage','VarianceOverage','BagWeight','SupplierId','GrnNumber','ProductionOrderNo',
    'CertNumber','ExportCertNumber','DispNumOfBag','DispNetKg','DispFeresula'];
}
