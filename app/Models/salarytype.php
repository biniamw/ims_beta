<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salarytype extends Model
{
    use HasFactory;
    protected $table='salarytypes';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['SalaryTypeName','SalaryType','NonTaxableAmount','Description','show_on_payroll','CreatedBy','LastEditedBy','LastEditedDate','Status'];
}
