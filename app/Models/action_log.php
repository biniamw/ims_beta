<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class action_log extends Model
{
    use HasFactory;
    protected $table='action_logs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['user_id','action','model','model_id','old_data','new_data'];
}
