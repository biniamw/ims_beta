<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payrolladdetail extends Model
{
    use HasFactory;
    protected $table='payrolladdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['payrolladditions_id','employees_id','salarytypes_id','Amount','Remark'];

}
