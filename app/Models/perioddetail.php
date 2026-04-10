<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perioddetail extends Model
{
    use HasFactory;
    protected $table='perioddetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['periods_id','days_id','Days','FirstHalfFrom','FirstHalfTo','SecondHalfFrom','SecondHalfTo','Remark','Status'];
}
