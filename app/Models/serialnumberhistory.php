<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serialnumberhistory extends Model
{
     use HasFactory;
    protected $table='serialnumberhistories';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['serialnumheader_id','transactionheader_id', 'DocumentNumber', 'TransactionType','TransactionDate'];
}
