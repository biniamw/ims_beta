<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\conversion;

class uom extends Model
{
    use HasFactory;
    protected $table='uoms';
    public $primarykey='id';
    public $timestamps=true; 
    protected $fillable=['Name','description','ActiveStatus','IsDeleted','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate'];
    public function conversionss()
{
  //  return $this->hasMany(conversion::class);
   return $this->belongsTo(conversion::class);

}

}
