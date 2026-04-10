<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class requisition extends Model
{
    use HasFactory;
    protected $table='requisitions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber','Type','SourceStoreId','DestinationStoreId','productionId','Date','Purpose','Department',
    'RequestedBy','RequestDate','AuthorizedBy','AuthorizedDate','ReviewedBy','ReviewedDate','ApprovedBy','ApprovedDate','ReceivedBy','ReceivedDate',
    'CommentedBy','CommentedDate','IssuedBy','IssuedDate','PreparedBy','PreparedDate','RejectedBy','RejectedDate','Memo',
    'Status','Common','fiscalyear','VoidBy','VoidDate','VoidReason','IssueId','CompanyType','RequestReason','CustomerOrOwner',
    'CustomerReceiver','Reference','BookingNumber','LabStation','DriverName','TruckPlateNo','DriverPhoneNo','DriverLicenseNo',
    'ContainerNo','CurrentDocumentNumber','ChangeToPendingBy','ChangeToPendingDate','DispatchDocumentNo','DispatchNumber','DispatchStatus'
    ];

    public function items(){
        return $this->belongsToMany(Regitem::class,'requisitiondetails','HeaderId','ItemId')->withTimestamps();
    }
}
