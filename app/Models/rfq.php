<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rfq extends Model
{
    use HasFactory;
    protected $table='rfqs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['purequest_id','documentumber','date','supplier','type','currency','contingency','isapproved',
                        'status','preparedby','lasteditedby','voidby','reason','undovoidby','verifyby','aouthorizeby',
                        'approveby','oldstatus','docnumber','fiscalyear','lastsubmittiondate','evrequire','samplerequire'];
    public function customers(){
        return $this->belongsToMany(customer::class)->withTimestamps();
    }

    public function actions(){
        return $this->hasMany(actions::class,'pageid');
    }
}
