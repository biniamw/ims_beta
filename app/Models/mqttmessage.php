<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mqttmessage extends Model
{
    use HasFactory;
    protected $table='mqttmessages';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['userid','uuid','message'];
}
