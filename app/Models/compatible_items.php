<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compatible_items extends Model
{
    use HasFactory;
    protected $table = 'compatible_items';
    public $primarykey = 'id';
    public $timestamps = true; 
    public $fillable = ['base_item_id','compatible_item_id'];
}
