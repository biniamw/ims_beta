<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_bomdetail extends Model
{
    use HasFactory;
    protected $table='prd_bomdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_boms_id','prd_bomchildren_id','woredas_id','Grade','ProcessType','CropYear','uoms_id','Quantity','UnitCost','TotalCost','Remark'];
}
