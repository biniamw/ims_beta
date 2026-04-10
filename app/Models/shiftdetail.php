<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shiftdetail extends Model
{
    use HasFactory;
    protected $table='shiftdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['shifts_id','Days','BlEarlyStartTime','BlStartTime','BlLateStartTime','BlLateStartTime','BlEndTime','BlLateEndTime'
    ,'BreakStartTime','BreakEndTime','BreakHour','AlEarlyStartTime','AlStartTime','AlLateStartTime','AlEarlyEndTime','AlEarlyEndTime','AlLateEndTime','Remark','Status'];

}
