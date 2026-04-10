<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shiftscheduledetail extends Model
{
    use HasFactory;
    protected $table='shiftscheduledetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['shiftschedules_id','shifts_id','ValidDate','CheckInNotReq',
    'CheckOutNotReq','ScheduleOnHoliday','EffectiveOt','ShiftFlag','ScheduleType','Status'];
}
