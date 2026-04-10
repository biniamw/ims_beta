<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employe extends Model
{
    use HasFactory;
    protected $table='employes';
    public $primarykey='id';
    protected $fillable = ['EmployeeId','departments_id','Name', 'TinNumber','states_id','Nationality','Country','cities_id','subcities_id','Woreda', 'Location','Mobile','Phone','Email','ResidanceId','PassportNo','DOB', 'Occupation',
    'Gender','IdentificationId','HealthStatus','Memo','Picture','Status','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate','EmergencyName','EmergencyMobile','EmergencyLocation'
    ,'devices_id','PersonUUID','LeftThumb','LeftIndex','LeftMiddle','LeftRing','LeftPinky','RightThumb','RightIndex','RightMiddle','RightRing','RightPinky'];

    public function empdet(){
        return $this->belongsToMany(service::class,'employeedetails','employes_id','services_id')->withTimestamps();
    }
}
