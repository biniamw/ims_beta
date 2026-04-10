<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_duration extends Model
{
    use HasFactory;
    protected $table='prd_durations';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_orders_id','StartTime','EndTime','Duration','StartedBy','PausedBy'];
}
