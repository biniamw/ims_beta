<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incomeclosingmrc extends Model
{
    use HasFactory;
    protected $table='incomeclosingmrcs';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['incomeclosings_id','MrcNumber','ZNumber','ZDate','CashAmount','CreditAmount', 'TotalAmount','BusinessDay'];
}
