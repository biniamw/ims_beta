<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class batches extends Model
{
    use HasFactory;
    protected $table='batches';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['source_id','brand_id','model_id','item_id','batch_number','manufacturing_date',
    'expiry_date','status','batch_uuid','source_type',
    'remark'];
}
