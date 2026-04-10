<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documents extends Model
{
    use HasFactory;
    protected $table = 'documents';
    public $primarykey = 'id';
    public $timestamps = true; 
    public $fillable = [
        'record_id','record_type','document_type','date','doc_name',
        'actual_file_name','remark','status','created_at','updated_at'
    ];
}
