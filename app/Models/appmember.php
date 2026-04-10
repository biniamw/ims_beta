<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appmember extends Model
{
    use HasFactory;
    protected $table='appmembers';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','memberships_id','RegistrationDate','ExpiryDate','IsMemberBefore','Status','LoyalityStatus','OldLoyalityStatus'];

}
