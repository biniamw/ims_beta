<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shiftschedule extends Model
{
    use HasFactory;
    protected $table='shiftschedules';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','Date','CheckInNotReq','CheckOutNotReq','ScheduleOnHoliday','EffectiveOt','ShiftFlag','CreatedBy','LastEditedBy','LastEditedDate'];

    public function shiftdata(){
        return $this->belongsToMany(shift::class,'shiftscheduledetails','shiftschedules_id','shifts_id')->withTimestamps();
    }

    public function shifttimedata(){
        return $this->belongsToMany(shift::class,'shiftschedule_timetables','shiftschedules_id','shifts_id')->withTimestamps();
    }
}
