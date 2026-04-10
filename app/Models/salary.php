<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;
    protected $table='salaries';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['SalaryName','TotalEarnings','TaxableEarning','NonTaxableEarning','TotalDeductions','NetSalary','CompanyPension','IsFixed','Description','UpdateSalaryFlag','CreatedBy','LastEditedBy','LastEditedDate','Status'];

    public function salarytype(){
        return $this->belongsToMany(salarytype::class,'salarydetails','salaries_id','salarytypes_id')->withTimestamps();
    }
}
