<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;
    protected $table='employees';
    public $primarykey='id';
    public $timestamps=true; 
    public $fillable = ['id','title','name','phone','EmployeeID','FirstName','MiddleName','LastName','branches_id','departments_id','positions_id','salaries_id','employementtypes_id','employees_id','HiredDate','Tin',
    'Dob','Gender','ResidanceIdNumber','NationalIdNumber','PassportNumber','Email','MobileNumber','OfficePhoneNumber','Postcode','DrivingLicenseNumber','Address','Nationality','MartialStatus','blood_type','Country','cities_id',
    'subcities_id','Woreda','kebele','house_no','EmergencyName','EmergencyPhone','EmergencyAddress','EnableAttendance','EnableHoliday','AccessStatus','AccessRole','banks_id','PaymentPeriond','PaymentType','BankAccountNumber','PensionNumber','CompanyPensionPercent',
    'ProvidentFundAccount','BasicSalary','NetSalary','MedicalAllowance','HomeRentAllowance','TransportAllowance','Bonus','OtherEarning','Tax','ProvidentFund','Loan','CostSharingDeduction','monthly_work_hour','OtherDeduction','UpdateSalaryFlag',
    'ContractSignDate','RenewDate','ContractDuration','ResumeDocument','WorkExpDocument','AwardDocument','TrainingDocument','RecommendationDocument','OtherDocument','SignedContractDocument','devices_id','PIN','CardNumber','ActualPicture',
    'BiometricPicture','PersonUUID','LeftThumb','LeftIndex','LeftMiddle','LeftRing','LeftPinky','RightThumb','RightIndex','RightMiddle','RightRing','RightPinky','GeneralMemo','PersonalMemo','EmergencyMemo','BiometricMemo',
    'AttendanceMemo','AccessMemo','PayrollMemo','DocumentMemo','ContractMemo','LeaveAllocationMemo','AnnualLeave','SickLeave','MaternityLeave','PaternityLeave','CasualLeave','BereavementLeave','CompensatoryLeave','UnpaidLeave','LeaveA',
    'LeaveB','LeaveC','IsOnLeave','CreatedBy','CreatedDate','LastEditedBy','LastEditedDate','WorkingMinute','PensionPercent','AllowancePercent','GuarantorName','GuarantorPhone','GuarantorAddress','GuarantorDocument','Status'];


    public function leavetype(){
        return $this->belongsToMany(hr_leavetype::class,'hr_employee_leaves','employees_id','hr_leavetypes_id')->withTimestamps();
    }

    public function negsalarytype(){
        return $this->belongsToMany(salarytype::class,'hr_employee_salaries','employees_id','salarytypes_id')->withTimestamps();
    }
}
