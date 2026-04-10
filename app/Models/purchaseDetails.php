<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseDetails extends Model
{
    use HasFactory;
    protected $table='purdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['purequest_id','regitem_id','commudities_id','woreda_id','cropyear','grade','proccesstype','oum','uomamount','qty','ton','feresula',
                                        'totalkg','price','totalprice','remark'];

}
