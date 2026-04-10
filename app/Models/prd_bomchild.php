<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_bomchild extends Model
{
    use HasFactory;
    protected $table='prd_bomchildren';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_boms_id','BomChildName','TotalCost','Description','Status'];
}
