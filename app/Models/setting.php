<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    use HasFactory;
   
    public function setCatAttribute($value)
    {
        $this->attributes['PurchaserName'] = json_encode($value);
    }

    public function getCatAttribute($value)
    {
        return $this->attributes['PurchaserName'] = json_decode($value);
    }
}

