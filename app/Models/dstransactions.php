<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dstransactions extends Model
{
    use HasFactory;
    protected $table='deadstocktransaction';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','ItemId ','StockIn','UnitCost','BeforeTaxCost','WitholdCost','DiscountCost',
        'TaxAmountCost','TotalCost','StoreId','LocationId','StockOut','UnitPrice','BeforeTaxPrice','TaxAmountPrice',
        'WitholdPrice','DiscountPrice','TotalPrice','RequireSerialNumber','RequireExpireDate','ConvertedQuantity',
        'ConversionAmount','NewUOMId','DefaultUOMId','IsVoid','TransactionType','TransactionsType','ItemType',
        'RetailerPrice','Wholeseller','DocumentNumber','FiscalYear','Memo','Date','Username'];
}
