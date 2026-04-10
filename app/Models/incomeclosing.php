<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incomeclosing extends Model
{
    use HasFactory;
    protected $table='incomeclosings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['IncomeDocumentNumber','stores_id','StartDate','EndDate','TotalCashDeposited','TotalCash', 'WitholdAmount','VatAmount',
        'OtherIncome','CreditFiscalOtherIncome','CashManualOtherIncome','FisCashIncome','FisCreditIncome','ManCashIncome','ManCreditIncome','CreditSettIncome',
        'CreditManualOtherIncome','NetCashReceived','TotalZAmount','ShortageAmount','OverageAmount','PreparedBy','PreparedDate',
        'VerifiedBy','VerifiedDate','ConfirmedBy','ConfirmedDate','ChangeToPendingBy','ChangeToPendingDate','LastEditedBy','LastEditedDate','Memo','Status','OldStatus','IsVoid','VoidBy','VoidReason','VoidDate',
        'UndoVoidBy','UndoVoidReason','UndoVoidDate','ZDocumentName','ZDocumentPath','SlipDocumentName','SlipDocumentPath','FiscalYear'
    ];

    public function incmrc(){
        return $this->belongsToMany(incomeclosingmrc::class,'incomeclosingmrcs','incomeclosings_id','incomeclosings_id')->withTimestamps();
    }

    public function incbank(){
        return $this->belongsToMany(bank::class,'incomeclosingbanks','incomeclosings_id','banks_id')->withTimestamps();
    }
}
