<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hr_leave extends Model
{
    use HasFactory;
    protected $table='hr_leaves';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['requested_for','LeaveID','LeaveDurationType','hr_leavetypes_id','RequestedDate','LeaveFrom','LeaveTo','LeaveReason','AddressDuringLeave',
    'DocumentUpload','EmergencyName','EmergencyPhone','EmergencyEmail','NumberOfDays','Remark','Status','OldStatus'];

}
