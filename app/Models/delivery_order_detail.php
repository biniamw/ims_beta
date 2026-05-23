<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class delivery_order_detail extends Model
{
    use HasFactory;
    protected $table='delivery_order_details';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['delivery_order_id','regitems_id','quantity','unit_price','total_price','factor',
    'quantity_pcs','standard_kg','price_per_kg','std_total_price','new_uom','default_uom','converted_quantity',
    'entered_qty','entered_serial_qty','is_fully_entered','reference_detail_id','remark','std_remark'];
}
