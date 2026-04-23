<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class batch_serial_transaction extends Model
{
    use HasFactory;
    protected $table='batch_serial_transactions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['batches_id','serial_number_id','in_quantity','out_quantity','stores_id','reference_id',
    'reference_number','transaction_type','transaction_date','is_batch_or_serial'];
}
