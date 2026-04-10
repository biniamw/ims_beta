<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_output extends Model
{
    use HasFactory;
    protected $table='prd_outputs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_orders_id','LocationId','CertificationId','CleanProductType','BiProductId','OutputType','FullUomId','FullNumofBag','FullWeightbyKg',
    'BagWeight','NetKg','Feresula','VarianceShortage','VarianceOverage','Percentage','UnitCost','TotalCost','TaxCost','GrandTotalCost','PartialUomId','PartialNumofBag',
    'PartialWeightbyKg','TotalNumofBag','TotalWeightbyKg','Inspection'];
}
