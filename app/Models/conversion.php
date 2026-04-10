<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\uom;

class conversion extends Model
{
   use HasFactory;
   protected $table='conversions';
   public $primarykey='id';
   public $timestamps=true; 

   protected $fillable = [
    'FromUomID',
    'ToUomID',
    'description',
    'Amount',
    'ActiveStatus','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'
];

public function unitof()
{
   // return $this->belongsTo(uom::class);
   return $this->hasMany(uom::class,'FromUomID');
}
public function unitofs()
{
   // return $this->belongsTo(uom::class);
   return $this->hasMany(uom::class,'ToUomID');
}

}
