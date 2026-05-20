<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serial_number extends Model
{
    use HasFactory;
    protected $table='serial_numbers';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['batches_id','serial_number','is_sold_issued','sold_issue_id','source_type','serial_uuid'];
}
