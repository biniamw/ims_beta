<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasevaulation extends Model
{
    use HasFactory;
    protected $table='purchasevaulations';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['rfq','documentumber','date','type','petype','status','oldstatus','source','department_id','user_id','currency','contingency','isapproved',
                        'coffeesource','itemtype','totalewithcontingency','preparedby','lasteditedby','voidby','reason','undovoidby','verifyby','aouthorizeby','samplerequire',
                        'store_id','totalprice','withold','net','approveby','docnumber','fiscalyear','commudtytype','isorganic','coffestat','requiredate','memo',
                        'priority','cropyear'];
    public function items(){
        return $this->belongsToMany(Regitem::class,'purchasevaulationdetails','purchasevaulation_id','regitem_id')->withTimestamps();
    }
    public function commuidities(){
        return $this->belongsToMany(Commudity::class,'purchasevaulationdetails','purchasevaulation_id','commudities_id')->withTimestamps();
    }
    public function woredas(){
        return $this->belongsToMany(Woreda::class,'purchasevaulationdetails','purchasevaulation_id','woreda_id')->withTimestamps();
    }

    public function Peinitiationsitems(){
        return $this->belongsToMany(Regitem::class,'peinitiations','purchasevaulation_id','regitem_id')->withTimestamps();
    }

    public function Peinitiationsworedas(){
        return $this->belongsToMany(Woreda::class,'peinitiations','purchasevaulation_id','woreda_id')->withTimestamps();
    }

    public function purchasevualationsupplier(){
        return $this->belongsToMany(customer::class,'pesuplliers','purchasevaulation_id','customers_id')->withTimestamps();
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function departments(){
        return $this->belongsTo(department::class);
    }
    public function actions(){
        return $this->hasMany(actions::class,'pageid');
    }

    public function suppliers(){
        return $this->hasMany(Pesuplliers::class,'purchasevaulation_id');
    }

    public function evaulations(){
        return $this->hasMany(Purchasevaulationdetail::class,'purchasevaulation_id','id');
    }
}
