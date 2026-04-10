<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer extends Model
{
    use HasFactory;
    protected $table='transfers';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber', 'Type','SourceStoreId','DestinationStoreId','Date','Reason','Department',
    'TransferBy','TransferDate','ChangeToPendingBy','ChangeToPendingDate','AuthorizedBy','ReviewedBy','ReviewedDate',
    'AuthorizedDate','ApprovedBy','ApprovedDate','ReceivedBy','ReceivedDate','CommentedBy','CommentedDate','IssuedBy',
    'IssuedDate','PreparedBy','PreparedDate','RejectedBy','RejectedDate','Memo','fiscalyear','Status','Common','VoidBy',
    'VoidDate','VoidReason','IssueId','DispatchStatus'
    ];

    public function items(){
        return $this->belongsToMany(Regitem::class,'transferdetails','HeaderId','ItemId')->withTimestamps();
    }
}
