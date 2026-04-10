<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skill extends Model
{
    use HasFactory;
    protected $table='skills';
    public $primarykey='id';
    public $timestamps=true;
    public $fillable = ['name','type','remark','description','status'];
}
