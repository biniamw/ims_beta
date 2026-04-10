<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceDetails extends Model
{
    use HasFactory;

    protected $table='purchaseinvoicedetails';
    public $primarykey='id';
    protected $guarded = ['id'];
    public $timestamps=true; 
    public $fillable = ['purchaseinvoice_id','grn','commodity','grade','proccesstype','cropyear','uom','totalkg',
                        'nofbag','bagwieght','ton','price','total','feresula','netkg','reciveid'
                        
                        ];
}
