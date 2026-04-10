<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serialandbatchnum extends Model
{
    use HasFactory;
    protected $table='serialandbatchnums';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['header_id','item_id', 'store_id', 'brand_id','ModelName','ManufactureDate','ExpireDate','SerialNumber','BatchNumber','IsIssued','IsSold','TransactionType','TransactionDate','Common','IsConfirmed'];
}
