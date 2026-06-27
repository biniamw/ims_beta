<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item_suppliers extends Model
{
    use HasFactory;
    protected $table = 'item_suppliers';
    public $primarykey = 'id';
    public $timestamps = true; 
    public $fillable = ['item_id','supplier_id','uom_id','quantity','price','availability','remark','status'];
}
