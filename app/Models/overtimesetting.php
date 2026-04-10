<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class overtimesetting extends Model
{
    use HasFactory;
    protected $table='overtimesettings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['overtime_id','daynum','StartTime','EndTime'];

}
