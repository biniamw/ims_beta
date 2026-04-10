<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class storemrc extends Model
{
    use HasFactory;
    protected $table='storemrcs';
    public $primarykey='id';
    public $timestamps=true;
    public $fillable = ['id', 'store_id','mrcNumber','status','fiscalvoidtype','cashPrefix','creditPrefix'];
    public function stores()
    {
        return $this->belongsTo(store::class);
    }
    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
