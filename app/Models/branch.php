<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    use HasFactory;
    protected $table='branches';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['BranchName','BranchLocation','EmailAddress','PhoneNumber','Description','CreatedBy','LastEditedBy','LastEditedDate','Status'];
}
