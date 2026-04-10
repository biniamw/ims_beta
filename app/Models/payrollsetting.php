<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payrollsetting extends Model
{
    use HasFactory;
    protected $table='payrollsettings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['MinAmount','MaxAmount','TaxRate','Deduction'];
}
