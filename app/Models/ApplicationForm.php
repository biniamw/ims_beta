<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;
    protected $table='applications';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['groupmembers_id','paymentterms_id','stores_id','ApplicationNumber','RegistrationDate','ExpiryDate','Type','TIN','VoucherType','Mrc','PaymentType','VoucherNumber','InvoiceNumber','InvoiceDate','SubTotal','TotalTax','GrandTotal','DiscountPercent',
    'DiscountAmount','PreparedBy','PreparedDate','VerifiedBy','VerifiedDate','LastEditedBy','LastEditedDate','IsVoid','VoidBy','VoidDate','VoidReason','UndoVoidBy','UndoVoidDate','RefundBy','RefundDate','RefundReason','UndoRefundBy','UndoRefundDate','Memo','DocumentUploadPath','DocumentOriginalName','Status','OldStatus','ApplicationType','RenewParentId','FiscalYear','sendflag'];

    public function memb(){
        return $this->belongsToMany(membership::class,'appmembers','applications_id','memberships_id')->withTimestamps();
    }

    public function serv(){
        return $this->belongsToMany(service::class,'appservices','applications_id','services_id')->withTimestamps();
    }

    public function consolidate(){
        return $this->belongsToMany(membership::class,'appconsolidates','applications_id','memberships_id')->withTimestamps();
    }

    public function trainer(){
        return $this->belongsToMany(employe::class,'apptrainers','applications_id','employes_id')->withTimestamps();
    }
}
