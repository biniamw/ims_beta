<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memberpaymenthistory extends Model
{
    use HasFactory;
    protected $table='memberpaymenthistories';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','paymenthistorygyms_id','memberships_id','RegistrationDate','ExpiryDate','IsMemberBefore','Status'];
}
