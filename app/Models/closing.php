<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class closing extends Model
{
    use HasFactory;
    protected $table='closings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber', 'store_id','FiscalYear','Username','Status','CalendarType','Memo','Common','beginningnumber','CountedBy','CountedDate',
    'VerifiedBy','VerifiedDate','PostedBy','PostedDate','AdjustedBy','AdjustedDate','Date'];
}
