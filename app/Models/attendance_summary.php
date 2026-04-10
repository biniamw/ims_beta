<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance_summary extends Model
{
    use HasFactory;
    protected $table='attendance_summaries';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','Date','WorkingTimeAmount','BreakTimeAmount','BeforeOvertimeAmount','AfterOvertimeAmount',
                        'TotalOvertimeAmount','LateCheckInTimeAmount','EarlyCheckOutTimeAmount','BeforeOnDutyTimeAmount','OffShiftOvertime',
                        'OffShiftOvertimeLevelPercent','AfterOffDutyTimeAmount','Status','AllStatus','IsPayrollMade','is_unpaid_leave','is_leave_half_day',
                        'Remark'
                    ];
}
