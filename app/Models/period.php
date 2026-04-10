<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class period extends Model
{
    use HasFactory;
    protected $table='periods';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['PeriodName','Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];

    public function perioddet(){
        return $this->belongsToMany(days::class,'perioddetails','periods_id','days_id')->withTimestamps();
    }
}
