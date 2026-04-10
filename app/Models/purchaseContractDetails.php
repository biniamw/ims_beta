<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchaseContractDetails extends Model
{
    use HasFactory;

    protected $table='pcdetails';
    public $primarykey='id';
    protected $guarded = ['id'];
    public $timestamps=true; 
    public $fillable = ['purchasecontract_id','itemid','proccesstype','pcontractsupplier_id','grade','ton','kg','feresula',
                            'percentage','signedate','endate','ectalocation','recievestation','uom','nofbag','supplier','price',
                            'total','cropyear',
                        ];
}
