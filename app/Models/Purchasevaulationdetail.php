<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasevaulationdetail extends Model
{
    use HasFactory;
    protected $table='purchasevaulationdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['rfq','regitem_id','purchasevaulation_id','purchasevaulation_id','commudities_id','proccesstype','sampleamount','remark'];

}
