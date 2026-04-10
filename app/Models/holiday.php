<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class holiday extends Model
{
    use HasFactory;
    protected $table='holidays';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['HolidayName','overtime_id','FiscalYear','HolidayDate','Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];
}
