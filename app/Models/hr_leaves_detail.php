<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hr_leaves_detail extends Model
{
    use HasFactory;
    protected $table='hr_leaves_details';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['hr_leaves_id','hr_leavetypes_id','Year','LeavePaymentType','RequireBalance','NumberOfDays','Remark'];

}
