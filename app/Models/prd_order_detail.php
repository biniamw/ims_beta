<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_order_detail extends Model
{
    use HasFactory;
    protected $table='prd_order_details';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_orders_id','CommodityType','woredas_id','Grade','ProcessType','CropYear','Symbol',
    'SupplierId','GrnNumber','ProductionNumber','CertNumber','stores_id','LocationId','uoms_id','Quantity','QuantityInKG',
    'UnitCost','TotalCost','UomFactor','Remark','MoisturePercent','PrdWeightByKg','PrdNumofBag','PrdBagByKg',
    'PrdAdjustment','PrdNetWeight','RatioVarianceShortage','RatioVarianceOverage','VarianceShortage','VarianceOverage'];
}
