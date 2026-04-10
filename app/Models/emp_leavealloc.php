<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_leavealloc extends Model
{
    use HasFactory;
    protected $table='emp_leaveallocs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','LeaveAllocationNo','Type','Date','Memo','Status','AllocationNo','created_at','updated_at'];
}
