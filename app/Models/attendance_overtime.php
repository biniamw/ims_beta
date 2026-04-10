<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance_overtime extends Model
{
    use HasFactory;
    protected $table='attendance_overtimes';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','overtime_id','daynum','Date','OtStartTime','OtEndTime','OtDurationMin','Rate','IsPayrollClosed','Type'];

}
