<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_bom extends Model
{
    use HasFactory;
    protected $table='prd_boms';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['BomNumber','BomName','type','TotalCost','Description','Status','BomChildNumber'];
}
