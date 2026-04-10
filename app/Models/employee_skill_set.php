<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_skill_set extends Model
{
    use HasFactory;
    protected $table='employee_skill_sets';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','skills_id','level_id','remark','type','description','created_at','updated_at'];
}
