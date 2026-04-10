<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shift_day extends Model
{
    use HasFactory;
    protected $table='shift_days';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['shifts_id','daynum','days_id'];
}
