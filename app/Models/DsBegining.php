<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DsBegining extends Model
{
    use HasFactory;
    protected $table='dsbeginings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber', 'StoreId','FiscalYear','Username','Status','CalendarType','Memo','Common','Date'];
}
