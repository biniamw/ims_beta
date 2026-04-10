<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storemrcuser extends Model
{
    use HasFactory;
    protected $table='storemrc_user';
    public $primarykey='id';
    public $timestamps=true;
    public $fillable = ['id', 'user_id','storemrc_id'];
}
