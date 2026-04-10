<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membership extends Model
{
    use HasFactory;
    protected $table='memberships';
    public $primarykey='id';
    protected $fillable = ['MemberId','Name', 'TinNumber','states_id','Nationality','Country','cities_id','subcities_id','Woreda', 'Location','Mobile','Phone','Email','ResidanceId','PassportNo','DOB', 'Occupation',
        'Gender','IdentificationId','HealthStatus','Memo','Picture','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate','EmergencyName','EmergencyMobile','EmergencyLocation','LoyalityStatus','loyaltystatuses_id',
        'DateOfJoining','devices_id','PersonUUID','LeftThumb','LeftIndex','LeftMiddle','LeftRing','LeftPinky','RightThumb','RightIndex','RightMiddle','RightRing','RightPinky'
    ];
   
}
