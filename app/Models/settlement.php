<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settlement extends Model
{
    use HasFactory;
    protected $table='settlements';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['stores_id','customers_id','CrvNumber','DocumentDate','OutstandingAmount', 'SettlementAmount','UnSettlementAmount','SettledBy','SettledDate','VerifiedBy','VerifiedDate','ConfirmedBy',
        'ConfirmedDate','ChangeToPendingBy','ChangeToPendingDate','LastEditedBy','LastEditedDate','Memo','Status','OldStatus','IsVoid','VoidBy','VoidReason','VoidDate','fiscalyear',
        'UndoVoidBy','UndoVoidReason','UndoVoidDate',
    ];

    public function sales(){
        return $this->belongsToMany(Sales::class,'settlementdetails','settlements_id','sales_id')->withTimestamps();
    }
}
