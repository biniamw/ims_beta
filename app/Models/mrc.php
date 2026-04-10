<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mrc extends Model
{
    use HasFactory;
    protected $table='mrcs';
    public $primarykey='id';
    public $timestamps=true; 
}
