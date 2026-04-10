<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class appconsolidate extends Model
{
    use HasFactory;
    protected $table='appconsolidates';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['applications_id','memberships_id','services_id','periods_id','type','RegistrationDate','ExpiryDate','FreezeRegistrationDate','FreezeExpiryDate','FreezedBy',
    'FreezedDate','UnFreezedBy','UnFreezedDate','ExtendDay','RemainingDay','devices_id','Status','OldStatus'
    ];
}
