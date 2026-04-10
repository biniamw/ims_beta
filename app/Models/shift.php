<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\shiftdetail;
use App\Models\days;
use App\Models\shift_day;
use App\Models\shift_day_time;
use App\Models\timetable;

class shift extends Model
{
    use HasFactory;
    protected $table='shifts';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['ShiftName','BegininngDate','CycleNumber','CycleUnit','Description','Status','ShiftFlag','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];

    public function shiftday()
    {
        // return $this->belongsToMany(days::class, 'shift_days', 'shifts_id', 'days_id')->withTimestamps();
        return $this->belongsToMany(days::class, 'shift_days', 'shifts_id', 'shifts_id')->withTimestamps();
    }

    public function shiftdaytime()
    {
        return $this->belongsToMany(timetable::class, 'shift_day_times', 'shifts_id', 'timetables_id')->withTimestamps();
    }

}
