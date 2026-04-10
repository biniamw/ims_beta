<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;
    protected $table='departments';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['departments_id','DepartmentName','Description','CreatedBy','LastEditedBy','Status'];
}
