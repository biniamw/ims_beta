<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bankdetail extends Model
{
    use HasFactory;
    protected $table='bankdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['banks_id','AccountNumber','OpeningBalance','ContactNumber','Branch','Status'];
}
