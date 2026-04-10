<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payrollsalary extends Model
{
    use HasFactory;
    protected $table='payrollsalaries';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['payrolls_id', 'employees_id', 'salarytypes_id','overtimes_id',
    'earning_amount','non_taxable','deduction_amount','salarytype_src','payrolladditions_id',
    'percent','tax_deduction'];

}
