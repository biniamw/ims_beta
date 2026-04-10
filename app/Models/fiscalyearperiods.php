<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fiscalyearperiods extends Model
{
    use HasFactory;
    protected $table='fiscalyearperiods';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['header_id','PeriodName', 'PeriodStartDate', 'PeriodEndDate','Order'];
}
