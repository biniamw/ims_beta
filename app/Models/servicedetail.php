<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicedetail extends Model
{
    use HasFactory;
    protected $table='servicedetails';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['services_id','paymentterms_id','groupmembers_id','periods_id','MemberPrice','NewMemberPrice','Discount','NewMemDiscount','NewTrainerFee','ExistingTrainerFee','Description','Status'];
}
