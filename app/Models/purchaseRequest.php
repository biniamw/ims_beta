<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseRequest extends Model
{
    use HasFactory;
    protected $table='purequests';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['type','source','date','department_id','user_id','currency','contingency','isapproved','coffeesource','itemtype','totalewithcontingency',
                        'status','preparedby','lasteditedby','voidby','reason','undovoidby','verifyby','aouthorizeby','store_id','totalprice','withold','net',
                        'approveby','oldstatus','docnumber','fiscalyear','commudtytype','isorganic','coffestat','requiredate','memo','priority','cropyear','istaxable','tax'];
    public function items(){
        return $this->belongsToMany(Regitem::class,'purdetails','purequest_id','regitem_id')->withTimestamps();
    }
    public function commuidities(){
        return $this->belongsToMany(Commudity::class,'purdetails','purequest_id','commudities_id')->withTimestamps();
    }

    public function woredas(){
        return $this->belongsToMany(Woreda::class,'purdetails','purequest_id','woreda_id')->withTimestamps();
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function departments(){
        return $this->belongsTo(department::class);
    }
    public function puchaseactions(){
        return $this->hasMany(praction::class,'purequest_id');
    }
}
