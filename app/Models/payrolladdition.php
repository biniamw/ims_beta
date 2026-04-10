<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payrolladdition extends Model
{
    use HasFactory;
    protected $table='payrolladditions';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber','type','branches_id','departments_id','positions_id','PayRangeFrom','PayRangeTo','LastEditedBy','LastEditedDate',
    'PreparedBy','PreparedDate','ApprovedBy','ApprovedDate','RejectBy','RejectDate','UndoRejectBy','UndoRejectDate','VoidBy','VoidDate','VoidReason','UndoVoidBy','UndoVoidDate','Remark','Status','OldStatus'];
}
