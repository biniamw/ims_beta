<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fiscalyear extends Model
{
    use HasFactory;
    protected $table='fiscalyear';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['FiscalYear','Monthrange', 'Yearnumber'];
}
