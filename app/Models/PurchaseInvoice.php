<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;
    protected $table='purchaseinvoices';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['docno','productype','supplier','reference','poid','commoditysource','commoditype','commoditystatus','name','path','invoicedate','invoicetype','paymentype','voucherno',
                        'invoiceno','mrc','fiscalyear','status','oldstatus','istaxable','subtotal','tax','grandtotal','withold','vat','netpay','memo','fiscalyear'];

                        public function actions(){

                        return $this->hasMany(actions::class,'pageid');

                    }
}
