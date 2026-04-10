<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
class Product extends Model
{
    //use HasFactory;
    protected $table='products';
   public $primarykey='id';
   protected $guarded = ['id'];
   public $timestamps=true; 

   public function category()
   {
       return $this->belongsTo(Category::class);
   }
}
