<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_order_process extends Model
{
    use HasFactory;
    protected $table='prd_order_processes';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_orders_id','prd_order_details_id','Date','LocationId','uoms_id',
    'QuantityByUom','QuantityByKg','VarianceShortage','VarianceOverage','Remark'];
}
