<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dispatchparent extends Model
{
    use HasFactory;
    protected $table='dispatchparents';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['Type','ReqId','DispatchDocNo','DispatchMode','DriverName','DriverLicenseNo','DriverPhoneNo','PlateNumber',
    'ContainerNumber','FiscalYear','SealNumber','PersonName','PersonPhoneNo','Date','Remark','PreparedBy','PreparedDate','VerifiedBy',
    'VerifiedDate','ApprovedBy','ApprovedDate','ReceivedBy','ReceivedDate','CurrentDocumentNumber','Status','OldStatus'];
}
