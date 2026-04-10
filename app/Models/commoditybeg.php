<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Woreda;

class commoditybeg extends Model
{
    use HasFactory;
    protected $table='commoditybegs';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['product_type','DocumentNumber','EndingDocumentNumber','stores_id','customers_id','FiscalYear','TotalPrice','Tax','GrandTotal','Remark','Status','LastDocNumber'];

    public function commdityBegDetail()
    {
        return $this->belongsToMany(Woreda::class, 'commoditybegdetails', 'commoditybegs_id', 'woredas_id')->withTimestamps();
    }
}
