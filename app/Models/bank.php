<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    use HasFactory;
    protected $table='banks';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['BankName','Description','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];

    public function banksdet(){
        return $this->belongsToMany(bankdetail::class,'bankdetails','banks_id','banks_id')->withTimestamps();
    }
}
