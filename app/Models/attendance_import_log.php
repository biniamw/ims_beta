<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance_import_log extends Model
{
    use HasFactory;
    protected $table='attendance_import_logs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['RecordId','empid','Name','DateTime','deviceid','DeviceCode','similarity1','similarity2','ImportType'];
}
