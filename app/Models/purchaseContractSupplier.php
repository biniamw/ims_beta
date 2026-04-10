<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseContractSupplier extends Model
{
    use HasFactory;
    protected $table='pcontractsuppliers';
    public $primarykey='id';
    protected $guarded = ['id'];
    public $timestamps=true; 
    public $fillable = ['purchasecontract_id','docno','date','ecxno','ddano','oldstatus','status','signedate','endate'];
}
