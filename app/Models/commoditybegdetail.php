<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commoditybegdetail extends Model
{
    use HasFactory;
    protected $table='commoditybegdetails';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['commoditybegs_id','customers_id','stores_id','LocationId','ArrivalDate','item_id','quantity',
    'SupplierId','GrnNumber','CertNumber','ProductionNumber','VarianceShortage','VarianceOverage','NumOfBag','BagWeight',
    'woredas_id','CommodityType','Grade','ProcessType','CropYear','uoms_id','TotalKg','Balance','Feresula','UnitPrice','TotalPrice','Remark'];
}
