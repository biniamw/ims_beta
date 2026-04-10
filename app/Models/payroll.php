<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payroll extends Model
{
    use HasFactory;
    protected $table='payrolls';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber', 'type', 'PayRangeFrom', 'PayRangeTo', 'PreparedBy', 'PreparedDate', 'LastEditedBy', 'LastEditedDate', 'ApprovedBy', 'ApprovedDate', 'RejectBy', 'RejectDate', 'UndoRejectBy', 'UndoRejectDate', 'VoidBy', 'VoidDate', 'VoidReason', 'UndoVoidBy', 'UndoVoidDate', 'Remark', 'Status', 'OldStatus'];
}
