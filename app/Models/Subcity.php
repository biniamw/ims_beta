<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcity extends Model
{
    use HasFactory;
    protected $fillable = [
        'subcity_name',
        'city_id',
    ];
    protected $table='subcities';
    public $primarykey='id';
}
