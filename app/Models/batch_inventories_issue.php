<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class batch_inventories_issue extends Model
{
    use HasFactory;
    protected $table='batch_inventories_issues';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['batches_id','sold_issued_qty','source_id','source_type','status'];
}
