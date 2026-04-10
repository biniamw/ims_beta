<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentterm extends Model
{
    use HasFactory;
    protected $table='paymentterms';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['PaymentTermName','PaymentTermAmount', 'Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];
}
