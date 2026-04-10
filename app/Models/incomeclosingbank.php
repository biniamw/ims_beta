<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incomeclosingbank extends Model
{
    use HasFactory;
    protected $table='incomeclosingbanks';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['incomeclosings_id','PaymentType','banks_id','bankdetails_id','SlipNumber','SlipDate','Amount','Remark'];

}
