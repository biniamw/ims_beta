<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class timetable extends Model
{
    use HasFactory;
    protected $table='timetables';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['TimetableName','PunchingMethod','BreakTimeAsWorkTime','BreakTimeAsOvertime','EarlyCheckInOvertime','OnDutyTime','OffDutyTime','WorkTime',
    'LateTime','LeaveEarlyTime','BeginningIn','EndingIn','BeginningOut','EndingOut','is_night_shift','OvertimeStart','BreakHourFlag','BreakStartTime','BreakEndTime',
    'BreakHour','LateTimeBreak','LeaveEarlyTimeBreak','CheckInLateMinute','CheckOutEarlyMinute','NoCheckInFlag','NoCheckInMinute','NoCheckOutFlag','NoCheckOutMinute',
    'TimetableColor','Description','CreatedBy','LastEditedBy','LastEditedDate','Status'];
}
