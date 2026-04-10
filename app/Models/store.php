<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class store extends Model
{
    use HasFactory;
    protected $table='stores';
    public $primarykey='id';
    public $timestamps=true;
    public $fillable = ['type','Name','Place','ActiveStatus','IsPurchaseStore','IsAllowedCreditSales','CreatedBy',
    'QtyOnHandFlag','CheckQtyOnHand','CreatedDate','LastEditedBy','LastEditedDate','IsDeleted'];


    public function companymrc(){
        return $this->belongsToMany(companymrc::class)->withTimestamps();
    }
    public function companymrcnotin(){
        return $this->belongsToMany(companymrc::class)->withTimestamps();
    }

    public function strmrc()
    {
        return $this->hasMany(storemrc::class);
    }
}
