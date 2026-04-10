<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hr_employee_leave extends Model
{
    use HasFactory;
    protected $table='hr_employee_leaves';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['emp_leaveallocs_id','employees_id','hr_leavetypes_id','LeaveBalance','IsAllowed','DepOnBalance','Remark'];

}
