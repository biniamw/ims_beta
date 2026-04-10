<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjustment extends Model
{
    use HasFactory;
    protected $table='adjustments';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber','Type','StoreId','Date','Reason','fiscalyear',
    'AdjustedBy','AdjustedDate','Memo','Status','Common','StatusOld','customers_id','product_type',
    'company_type','last_doc_number','CheckedBy','CheckedDate','ConfirmedBy','ConfirmedDate','ChangetoPendingBy',
    'ChangetoPendingDate','VoidBy','VoidDate','VoidReason','UndoVoidBy','UndoVoidDate','EditConfirmedBy',
    'EditConfirmedDate','TotalValue'];

    public function items(){
        return $this->belongsToMany(Regitem::class,'adjustmentdetails','HeaderId','ItemId')->withTimestamps();
    }
}
