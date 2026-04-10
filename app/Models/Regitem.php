<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regitem extends Model
{
    use HasFactory;
    protected $fillable = ['Name', 'Code','MeasurementId','CategoryId',
                'RetailerPrice','WholesellerPrice','TaxTypeId','RequireSerialNumber',
                'RequireExpireDate','PartNumber','Description','BarcodeType',
                'ActiveStatus','Type','LowStock','IsDeleted','SKUNumber',
                'BarcodeImage','itemImage','wholeSellerMinAmount','MaxCost','itemGroup','MinimumStock'];
    protected $table='regitems';
    public $primarykey='id';
    //protected $guarded =['id'];
    public $timestamps=true; 

    public function Salesitem()
    {
        return $this->belongsTo(Regitem::class,'ItemId','id');
    }

    public function items()
    {
        return $this->hasMany(Salesitem::class,'id','id');
    }
}
