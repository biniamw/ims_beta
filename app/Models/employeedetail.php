<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeedetail extends Model
{
    use HasFactory;
    protected $table='employeedetails';
    public $primarykey='id';
    protected $fillable = ['employes_id','services_id'];
}
