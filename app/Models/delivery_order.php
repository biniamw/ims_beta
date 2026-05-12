<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class delivery_order extends Model
{
    use HasFactory;
    protected $table='delivery_orders';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['document_number','reference_type','reference_id','product_type','station','delivery_date',
    'expiry_date','order_by','sales_person','supporting_doc_no','payment_type','payment_term','show_pricing','customers_id',
    'delivery_by','phone_no','id_no','plate_no','total_price','fiscal_year','current_document_no','prepared_by',
    'prepared_date','verified_by','verified_date','approved_by','approved_date','remark','status','status_old','created_at','updated_at'];
}
