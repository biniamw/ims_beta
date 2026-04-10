<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class storeassignment extends Model
{
    use HasFactory;
    protected $table='storeassignments';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['UserId', 'StoreId','Type'];
}
