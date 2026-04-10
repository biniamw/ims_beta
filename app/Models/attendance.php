<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;
    protected $table='attendances';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','Date','Time','offshiftstatus'];
}
