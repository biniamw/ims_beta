<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prd_order_cert extends Model
{
    use HasFactory;
    protected $table='prd_order_certs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['prd_orders_id','CertificateNumber','uoms_id','NumofBag','GrainPro'];
}
