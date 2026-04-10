<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    use HasFactory;
    protected $table='positions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['PositionName','departments_id','salaries_id','Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];
}
