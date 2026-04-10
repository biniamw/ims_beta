<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class begining extends Model
{
    use HasFactory;
    protected $table='beginings';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['DocumentNumber','StoreId','FiscalYear','Username','Status','CalendarType','Memo','Common','Date'];
}
