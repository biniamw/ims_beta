<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status extends Model
{
    use HasFactory;
    protected $table='statuses';
    public $primarykey='id';
    public $timestamps=true;
    public $fillable = ['StatusName','IsActive'];
}
