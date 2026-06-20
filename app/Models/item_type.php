<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item_type extends Model
{
    use HasFactory;
    protected $table = 'item_types';
    public $primarykey = 'id';
    public $timestamps = true; 
}
