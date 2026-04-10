<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance_log extends Model
{
    use HasFactory;
    protected $table='attendance_logs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','timetables_id','Date','Time','PunchType','AttType','offshiftstatus','Remark'];
}
