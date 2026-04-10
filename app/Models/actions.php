<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actions extends Model
{
    use HasFactory;
    protected $table='actions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['user_id','pageid','pagename','action','status','time','reason'];

}
