<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_biproduct extends Model
{
    use HasFactory;
    protected $table='prd_biproducts';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['BiProductName','Type','Status'];
}
