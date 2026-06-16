<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regitem extends Model
{
    use HasFactory;
    protected $fillable = ['Name', 'Code','MeasurementId','CategoryId','RetailerPrice','WholesellerPrice','TaxTypeId','RequireSerialNumber','RequireExpireDate','PartNumber','Description','BarcodeType','oldBarcodeType','averageCost', 'standard_factor',
                'ActiveStatus','Type','LowStock','IsDeleted','SKUNumber','oldSKUNumber','path','imageName','BarcodeImage','itemImage','wholeSellerMinAmount','MaxCost','itemGroup','MinimumStock','wholeSellerMaxAmount','pmwholesale','pmretail'];
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

    public function category()
    {
        return $this->belongsTo(Category::class,'CategoryId', 'id',);
    }

    public function additemlog(){
        return $this->hasMany(Itemlog::class);
    }

    public function itemtransaction(){
        return $this->hasMany(transaction::class,'','ItemId');
    }

}
