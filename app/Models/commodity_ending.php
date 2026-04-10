<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class commodity_ending extends Model
{
    use HasFactory;
    protected $table='commodity_endings';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['commoditybegs_id', 'document_number', 'stores_id', 'customers_id', 'fiscal_year', 'total_cost', 'tax', 'grand_total', 'remark', 'status', 'last_doc_number'];
}
