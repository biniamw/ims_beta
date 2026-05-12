<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderItems extends Model
{
    use HasFactory;

    protected $table='sales_order_items';
    public $primarykey='id';
    public $fillable = ['sales_order_id', 'regitem_id','uom_id','user_id','quantity','unit_price','total_price'];
}
