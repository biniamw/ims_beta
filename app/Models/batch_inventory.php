<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class batch_inventory extends Model
{
    use HasFactory;
    protected $table='batch_inventories';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['batches_id','received_qty','sold_issued_qty','created_at','updated_at'];
}
