<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hr_leave_transaction extends Model
{
    use HasFactory;
    protected $table='hr_leave_transactions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HeaderId','employees_id','hr_leavetypes_id','Year','LeaveEarned','LeaveUsage','Remark','RecordType','ReferenceNumber','Date','BaseHeaderId'];
}
