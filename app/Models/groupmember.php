<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groupmember extends Model
{
    use HasFactory;
    protected $table='groupmembers';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['GroupName','GroupSize', 'Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];
}
