<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class models extends Model
{
    use HasFactory;
    protected $table='models';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['Name','description','ActiveStatus','IsDeleted'];
}
