<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hr_employee_salary extends Model
{
    use HasFactory;
    protected $table='hr_employee_salaries';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','salaries_id','EarningAmount','DeductionAmount','Remark','Status'];
}
