<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymenthistorygym extends Model
{
    use HasFactory;
    protected $table='paymenthistorygyms';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','groupmembers_id','paymentterms_id','stores_id','TIN','VoucherType','Mrc','PaymentType','VoucherNumber','InvoiceNumber','InvoiceDate','SubTotal','TotalTax','GrandTotal','DiscountPercent',
    'DiscountAmount','IsIntialRecord','PreparedBy','PreparedDate','VerifiedBy','VerifiedDate','LastEditedBy','LastEditedDate','IsVoid','VoidBy','VoidDate','UndoVoidBy','UndoVoidDate','Memo'];

    
}
