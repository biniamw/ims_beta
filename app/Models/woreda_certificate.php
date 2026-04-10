<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class woreda_certificate extends Model
{
    use HasFactory;
    protected $table='woreda_certificates';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['woredas_id','com_certificates_id'];
}
