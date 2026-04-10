<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settlementdetail extends Model
{
    use HasFactory;
    protected $table='settlementdetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['settlements_id','sales_id','banks_id','bankdetails_id','PaymentType','BankName','ChequeNumber','BankTransferNumber','SubTotal','Tax','GrandTotal',
        'RemainingAmount','WitholdAmount','Vat','WitholdSetle','VatSetle','SettlementAmount','Remark','SettlementStatus',
    ];
}
