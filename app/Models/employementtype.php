<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employementtype extends Model
{
    use HasFactory;
    protected $table='employementtypes';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['EmploymentTypeName','Description','CreatedBy','LastEditedBy','Status'];
}
