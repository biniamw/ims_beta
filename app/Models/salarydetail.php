<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salarydetail extends Model
{
    use HasFactory;
    protected $table='salarydetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['salaries_id','salarytypes_id','Amount','NonTaxableAmount','TotalAmount','TaxPercent','Deduction','Type','EarningAmount','DeductionAmount','Remark','Status'];
}
