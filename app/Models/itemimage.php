<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemimage extends Model
{
    use HasFactory;
    protected $table='itemimages';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['regitem_id','imagename', 'imagepath'];
}
