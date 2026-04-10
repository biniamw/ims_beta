<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    use HasFactory;
    protected $table='services';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['ServiceName','categories_id', 'Description','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate','Status'];

    public function groups(){
        return $this->belongsToMany(groupmember::class,'servicedetails','services_id','groupmembers_id')->withTimestamps();
    }
}
