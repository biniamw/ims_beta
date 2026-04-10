<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payrolldetail extends Model
{
    use HasFactory;
    protected $table='payrolldetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['payrolls_id', 'employees_id','working_day','suppose_to_work_hr','actual_work_hr','per_hr_salary',
    'lateabsent_hr','absent_day','actual_salary','basic_salary','total_earning','non_taxable_earning','taxable_earning','total_deduction','net_pay'];
}
