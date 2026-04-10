<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_document extends Model
{
    use HasFactory;
    protected $table='employee_documents';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['employees_id','type','doc_date','sign_date','expire_date','duration','doc_name',
    'actual_file_name','remark','upload_type','description','created_at','updated_at'];
}
