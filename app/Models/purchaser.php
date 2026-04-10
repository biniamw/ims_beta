<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaser extends Model
{
    use HasFactory;
    protected $table='purchasers';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['UserId'];

    public function setCatAttribute($value)
    {
        $this->attributes['PurchaserName'] = json_encode($value);
    }

    public function getCatAttribute($value)
    {
        return $this->attributes['PurchaserName'] = json_decode($value);
    }
}

