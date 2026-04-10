<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseOrderDetails extends Model
{
    use HasFactory;
    protected $table='purchaseordersdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['purchaseorder_id','pesupllier_id','itemid','cropyear','proccesstype','uom','feresula','price',
    'Total','qty','totalkg','status','rank','reason','ton','grade','bagweight','netkg','beforetax','price'];
}
