<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hr_leavetype extends Model
{
    use HasFactory;
    protected $table='hr_leavetypes';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['LeaveType','RequiresBalance','LeavePaymentType','Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];

}
