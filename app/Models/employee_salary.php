<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_salary extends Model
{
    use HasFactory;
    protected $table='employee_salaries';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['doc_number','employees_id','is_negotiable','salaries_id','doc_name','actual_file_name',
    'date','remark','status','old_status','inc_value','created_at','updated_at'];
}
