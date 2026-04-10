<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $table='transactions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['id','HeaderId','ItemId','StockIn','UnitCost','BeforeTaxCost','WitholdCost','DiscountCost','TaxAmountCost','TotalCost','StoreId','LocationId','StockOut','UnitPrice','BeforeTaxPrice','TaxAmountPrice','WitholdPrice','DiscountPrice','TotalPrice',
    'RequireSerialNumber','RequireExpireDate','ConvertedQuantity','ConversionAmount','NewUOMId','DefaultUOMId','IsVoid','IsPriceVoid','IsOnShipment','ShipmentQuantity','ShipmentQuantityFeresula','ShipmentQuantityNumofBag','TransactionType','TransactionsType','ItemType',
    'RetailerPrice','Wholeseller','DocumentNumber','FiscalYear','Memo','Date','Username','ArrivalDate','SupplierId','GrnNumber','CertNumber','ProductionNumber','woredaId','uomId','BagWeight','TotalKg','StockInNumOfBag','StockOutNumOfBag','CommodityType','Grade','ProcessType',
    'CropYear','StockInComm','StockInFeresula','UnitCostComm','TotalCostComm','TaxCostComm','GrandTotalCostComm','StockOutComm','StockOutFeresula','UnitPriceComm','TotalPriceComm','TaxPriceComm','GrandTotalPriceComm','VarianceShortage','VarianceOverage','SourceStore',
    'customers_id','created_at','updated_at'
    ];
}
