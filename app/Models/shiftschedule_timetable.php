<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shiftschedule_timetable extends Model
{
    use HasFactory;
    protected $table='shiftschedule_timetables';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['shiftschedules_id','shiftscheduledetails_id','shifts_id','timetables_id','Date','isworkday','have_priority','OldTimetable'];
}
