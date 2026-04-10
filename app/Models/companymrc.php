<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class companymrc extends Model
{
    use HasFactory;
    protected $table='companymrcs';
    public $primarykey='id';
    public $timestamps=true; 
}
