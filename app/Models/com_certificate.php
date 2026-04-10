<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class com_certificate extends Model
{
    use HasFactory;
    protected $table='com_certificates';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['Certification','Status'];

}
