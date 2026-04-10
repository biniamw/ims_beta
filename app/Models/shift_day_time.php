<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shift_day_time extends Model
{
    use HasFactory;
    protected $table='shift_day_times';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['shifts_id','timetables_id','daynum'];

}
