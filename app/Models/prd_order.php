<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_order extends Model
{
    use HasFactory;
    protected $table='prd_orders';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['ProductionOrderNumber','CompanyType','customers_id','RepName','RepPhone','ProductionType','OutputType','prd_bomchildren_id','ExpectedAmount','woredas_id','CropYear','Grade','ProcessType','CommodityType','Symbol','OrderDate','Deadline','ProductionStartDate',
    'ProductionEndDate','ContractNumber','GrainPro','SieveSize','CGrade','ThickCoffee','Moisture','WaterActivity','DefectCount','FrontSideBagLabel','BackSideBagLabel','AdditionalInstruction','users_id','AdditionalFile','Remark','MoisturePercent','PrdWeightByKg',
    'PrdNumofBag','PrdBagByKg','PrdAdjustment','PrdNetWeight','ExportNumofBag','ExportWeightbyKg','ExportRemark','RejectNumofBag','RejectWeightbyKg','RejectRemark','WastageNumofBag','WastageWeightbyKg','WastageRemark','StubbleNumofBag','StubbleWeightbyKg',
    'VarianceShortage','VarianceOverage','StubbleRemark','CurrentDocumentNumber','FiscalYear','PrdWarehouse','Status','OldStatus','PrdStatus','CurrentWorkStatus'];
}
