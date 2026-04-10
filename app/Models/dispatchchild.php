<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dispatchchild extends Model
{
    use HasFactory;
    protected $table='dispatchchildren';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['ReqDetailId','dispatchparents_id','Quantity','NumOfBag','TotalKG','NetKG','Remark'];
}
