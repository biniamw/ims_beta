<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payrollemployee extends Model
{
    use HasFactory;
    protected $table='payrollemployees';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['payrolls_id', 'employees_id', 'WorkingDays', 'BasicSalary', 'OtherEarning', 'TotalEarning', 'TaxableEarning', 'IncomeTax', 'Pension', 'ComPension', 'OtherDeduction', 'TotalDeduction', 'NetPay'];
}
