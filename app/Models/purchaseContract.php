<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseContract extends Model
{
    use HasFactory;

    protected $table='purchasecontracts';
    public $primarykey='id';
    protected $guarded = ['id'];
    public $timestamps=true; 
    public $fillable = ['customer_id','reciever','docno','ecxno','ddano','signedate','endate','name','path','date','status','oldstatus','type',
                        'istaxable','subtotal','tax','grandtotal','withold','netpay','contractype'];

    public function actions(){
        return $this->hasMany(actions::class,'pageid');
    }
}
