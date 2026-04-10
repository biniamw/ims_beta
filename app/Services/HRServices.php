<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use App\Models\actions;
use App\Models\attendance;
use App\Models\attendance_log;
use App\Models\attendance_summary;
use App\Models\employee;
use App\Models\timetable;
use App\Models\device;
use App\Models\mqttmessage;
use App\Models\attendance_import_log;
use App\Models\attendance_overtime;
use App\Models\shift_day_time;
use App\Models\shift_day;
use App\Models\shiftschedule_timetable;
use App\Models\shiftschedule;
use App\Models\shiftscheduledetail;
use App\Models\hr_leave;
use App\Models\holiday;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AttendanceImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Response;
use Yajra\Datatables\Datatables;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\Examples\Shared\SimpleLogger;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\MqttClient;
use Psr\Log\LogLevel;
use Image;


class HRServices
{
    public function checkAttendanceStatus($employeeId, $date){

        $statusSummary = null;
        $data = [];
        $timetables = shiftschedule_timetable::join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
            ->join('employees','shiftschedules.employees_id','employees.id')
            ->join('timetables','shiftschedule_timetables.timetables_id','timetables.id')
            ->join('shifts','shiftschedule_timetables.shifts_id','shifts.id')
            ->where('shiftschedules.employees_id', $employeeId)
            ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
            ->get(['shiftschedule_timetables.*','employees.id AS EmpId']);

        // Fetch all punch records
        $attendances = attendance_log::where('attendance_logs.employees_id', $employeeId)
            ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
            ->orderBy('attendance_logs.Time', 'asc')
            ->get();

        // Check if employee is on leave
        $leave = hr_leave::where('hr_leaves.requested_for', $employeeId)
            ->whereBetween(DB::raw($date), [DB::raw('DATE(hr_leaves.LeaveFrom)'),DB::raw('DATE(hr_leaves.LeaveTo)')])
            ->where('hr_leaves.Status', 'Approved')
            ->exists();  

        $statuses = [];

        $offftime = [];

        $totalworkinghr=0;
        $totalbreaktime=0;
        $totalbeforeot=0;
        $totalafterot=0;
        $totalot=0;
        $totallatechekinhr=0;
        $totallatechekouthr=0;
        $totalbeforeondutytime=0;
        $totalafteroffdutytime=0;
        $breakDuration = 0;
        $offShiftOvertime = 0;
        $offShiftOvertimeLevelPercent = 0;

        foreach ($timetables as $timetable) {
            
            $shiftscheuledata = shiftscheduledetail::where('id',$timetable->shiftscheduledetails_id)->first();
            $timetabledata = timetable::where('id',$timetable->timetables_id)->first();
            $attendancescount = attendance_log::where('attendance_logs.employees_id', $employeeId)
            ->where('attendance_logs.timetables_id',$timetable->timetables_id)
            ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
            ->orderBy('attendance_logs.Time', 'asc')
            ->get();
            
            $requiredPunches = ($timetabledata->PunchingMethod == 4) ? 4 : 2;
            if ($attendancescount->count() < $requiredPunches && $attendancescount->count() > 0) {
                $statuses[] = 8; //'Incomplete Punch';
                //continue;
            }

            // Extract punch-in and punch-out times
            //$punchTimes = $attendances->pluck('Time')->map(fn($time) => strtotime($time))->toArray();// First approach
            $punchTimes = $attendancescount->pluck('Time')->map(fn($time) => strtotime($time))->toArray();
            $firstPunch = reset($punchTimes);
            $lastPunch = end($punchTimes);

            $beginningIn =  $timetabledata->id != 1 ? strtotime($timetabledata->BeginningIn) : $firstPunch;
            $endingOut = $timetabledata->id != 1 ? strtotime($timetabledata->EndingOut) : $lastPunch;
            $onDuty = $timetabledata->id != 1 ? strtotime($timetabledata->OnDutyTime) : $firstPunch;
            $offDuty = $timetabledata->id != 1 ? strtotime($timetabledata->OffDutyTime) : $lastPunch;
            $endingIn = $timetabledata->id != 1 ? strtotime($timetabledata->EndingIn) : $lastPunch;
            $overtimeStart = strtotime($timetabledata->OvertimeStart);
            $breakStartTime = strtotime($timetabledata->BreakStartTime);
            $breakEndTime = strtotime($timetabledata->BreakEndTime);
            
            //flag to catch present
            $isPresent = true;

            // **No Check-In Handling**
            if (!$firstPunch) {
                $statuses[] = $timetabledata->NoCheckInFlag == 1 ? 1 : 4; //1 Absent 4 Late checkIn
                //continue;
            }

            // **No Check-Out Handling**
            if (!$lastPunch) {
                $statuses[] = $timetabledata->NoCheckOutFlag == 1 ? 1 : 6; //'Absent' : 'Early';
                //continue;
            }

            // **Check-In Late for X min → Mark as Absent**
            if ($firstPunch > $onDuty + ($timetabledata->CheckInLateMinute * 60)) {
                $statuses[] = 1; //'Absent';
                $isPresent = false;
                //continue;
            }

            // **Check-Out Early for X min → Mark as Absent**
            if ($lastPunch < $offDuty - ($timetabledata->CheckOutEarlyMinute * 60)) {
                $statuses[] = 1; //'Absent';
                $isPresent = false;
                //continue;
            }            

            // **Late Check-In**
            if ($firstPunch > $onDuty + ($timetabledata->LateTime * 60) && $firstPunch < $endingIn) {
                $earlyCheckinMinutes = round(($firstPunch - $onDuty) / 60);
                $totallatechekinhr += $earlyCheckinMinutes;
                $statuses[] = 4; //'Late-CheckIn';
                $isPresent = false;
            }

            if ($firstPunch < $onDuty) {
                if ($timetabledata->EarlyCheckInOvertime == 1 && $shiftscheuledata->EffectiveOt == 1) {
                    $statuses[] = 5; //'Early-CheckIn (Overtime)';
                } else {
                    $statuses[] = 5; //'Early-CheckIn';
                }
                $beforeondutytime = round(($onDuty - $firstPunch) / 60);
                $totalbeforeondutytime += $beforeondutytime;
            }

            // **Early Check-Out**
            if ($lastPunch < $offDuty - ($timetabledata->LeaveEarlyTime * 60) && $lastPunch >= $offDuty - ($timetabledata->CheckOutEarlyMinute * 60)) {
                $earlyCheckoutMinutes = round(($offDuty - $lastPunch) / 60);
                $totallatechekouthr += $earlyCheckoutMinutes;
                $statuses[] = 6; //'Early-CheckOut';
                $isPresent = false;
            }

            // **Late Check-Out**
            if ($lastPunch > $endingOut) {
                $statuses[] = 7; //'Late-CheckOut';
                $afterondutytime = round(($lastPunch - $endingOut) / 60);
                $totalafteroffdutytime += $afterondutytime;
            }

            // **Overtime Calculation**
            // if ($lastPunch > $offDuty + ($overtimeStart * 60) && $shiftscheuledata->EffectiveOt == 1) {
            //     $overtimeMinutes = ($lastPunch - ($offDuty + ($overtimeStart * 60))) / 60;
            //     $statuses[] = "Overtime ({$overtimeMinutes} min)";
            // }

            // **Mark Present if no Late, Early, or Absent status is assigned**
            if ($isPresent && !in_array(4, $statuses) && !in_array(6, $statuses)) {
                $statuses[] = 2; //'Present';
            }

            if ($shiftscheuledata->CheckInNotReq == 1 && $shiftscheuledata->CheckOutNotReq == 1) {
                $statuses[] = 2; //'Present'; // No punches required, automatically present
            }

            if ($shiftscheuledata->CheckInNotReq == 1 && !empty($punchTimes)) {
                $statuses[] = 2; //'Present'; // Check-in not required but has check-out
            }

            if ($shiftscheuledata->CheckOutNotReq == 1 && !empty($punchTimes)) {
                $statuses[] = 2; //'Present'; // Check-out not required but has check-in
            }

            // **Off-Shift Detection**
            $unassignedPunches = attendance_log::where('attendance_logs.employees_id', $employeeId)
                ->where('attendance_logs.timetables_id',1)
                ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                ->exists();
            
            $checkWorkOnLeave = attendance_log::where('attendance_logs.employees_id', $employeeId)
                ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
                ->exists();

            if ($unassignedPunches) {
                $statuses=[];
                $statuses[] = 13; //'Off Shift (Unscheduled Punch)';
            }

            if(!$checkWorkOnLeave && $timetable->isworkday == 2){
                $statuses=[];
                $statuses[] = 9; //"Day Off";
            }

            if($timetable->isworkday == 3){
                if(!$checkWorkOnLeave){
                    $statuses=[];
                    $statuses[] = 10; //"Holiday";
                }
                if($checkWorkOnLeave){
                    
                    $statuses=[];
                    $statuses[] = 15; //"Works on Holiday";
                }
            }

            if (!$checkWorkOnLeave) {
                if ($leave) {
                    $statuses=[];
                    $statuses[] = 11; //'On Leave';
                }
            }

            if ($checkWorkOnLeave) {
                if ($leave) {
                    $statuses=[];
                    $statuses[] = 12; //'Works-On-Leave';
                }
            }

            if(empty($statuses)){
                $statuses[] = 1; //"Absent";
            }

            // ---Calculate Hours-----
            $endingIn = strtotime($timetabledata->EndingIn);
            $beginningOut = strtotime($timetabledata->BeginningOut);

            $breakPunches = attendance_log::where('attendance_logs.employees_id', $employeeId)
            ->where('attendance_logs.timetables_id',$timetable->timetables_id)
            ->where(DB::raw('DATE(attendance_logs.Date)'), $date)
            ->whereBetween('Time', [date('H:i', $endingIn), date('H:i', $beginningOut)])
            ->orderBy('attendance_logs.Time', 'asc')
            ->pluck('Time')
            ->map(fn($time) => strtotime($time))
            ->toArray();

            $holidayData = holiday::join('overtimes','holidays.overtime_id','overtimes.id')
            ->where('holidays.HolidayDate', $date)
            ->first();

            if (count($breakPunches) < 2) {
                $breakDuration = 0;
            }
            else if (count($breakPunches) >= 2) {
                if($timetabledata->BreakHourFlag == 1){
                    // Find the minimum and maximum punch time if it is flexible
                    $punchOutForBreak = min($breakPunches);
                    $punchInFromBreak = max($breakPunches);
                    $breakDuration = ($punchInFromBreak - $punchOutForBreak) / 60; // Convert seconds to minute
                }
                if($timetabledata->BreakHourFlag == 0){
                    //Calculate Break Hour and Status when it is Fixed
                    // **Early Check-Out For Break**
                    $punchOutForBreak = min($breakPunches);
                    $punchInFromBreak = max($breakPunches);
                    $breakDuration = ($punchInFromBreak - $punchOutForBreak) / 60; // Convert seconds to minute

                    if ($punchOutForBreak < $breakStartTime - ($timetabledata->LeaveEarlyTimeBreak * 60)) {
                        $earlyBreakCheckoutMinutes = round(($breakStartTime - $punchOutForBreak) / 60);
                        $totallatechekouthr += $earlyBreakCheckoutMinutes;
                        $statuses[] = 6; //'Early-CheckOut';
                        $isPresent = false;
                    }

                    if ($punchInFromBreak > $breakEndTime + ($timetabledata->LateTimeBreak * 60)) {
                        $earlyBreakCheckinMinutes = round(($punchInFromBreak - $breakEndTime) / 60);
                        $totallatechekinhr += $earlyBreakCheckinMinutes;
                        $statuses[] = 4; //'Late-CheckIn';
                        $isPresent = false;
                    }

                }
            }

            $offshiftot = 0;
            if($checkWorkOnLeave && $timetable->isworkday == 3 && $shiftscheuledata->EffectiveOt == 1){
                $offshiftot = $lastPunch - $firstPunch;
                $offShiftOvertimeLevelPercent = $holidayData->WorkhourRate;
            }

            $workingHours = (( ( $lastPunch <= $offDuty ? $lastPunch : $offDuty ) - ( $firstPunch >= $onDuty ? $firstPunch : $onDuty )) / 60) - $breakDuration ?? 0; // Convert to minute

            $beforeOvertime = ($timetabledata->EarlyCheckInOvertime == 1 && $shiftscheuledata->EffectiveOt == 1 && $firstPunch < $onDuty && $firstPunch >= $beginningIn) ? ($onDuty - $firstPunch) / 60 : 0;
            
            $afterOvertime = ($lastPunch > $overtimeStart && $shiftscheuledata->EffectiveOt == 1) ? ($lastPunch - $overtimeStart) / 60 : 0;

            $totalOvertime = $beforeOvertime + $afterOvertime;

            $offShiftOvertime += $offshiftot;
            $totalworkinghr += $workingHours;
            $totalbreaktime += $breakDuration;
            $totalbeforeot += $beforeOvertime;
            $totalafterot += $afterOvertime;
            $totalot += $totalOvertime;
        }

        //Count number of shift assigned
        $countTimetable = DB::table('shiftschedule_timetables')
            ->join('shiftschedules','shiftschedule_timetables.shiftschedules_id','shiftschedules.id')
            ->join('employees','shiftschedules.employees_id','employees.id')
            ->where(DB::raw('DATE(shiftschedule_timetables.Date)'), $date)
            ->where('shiftschedules.employees_id', $employeeId)
            ->distinct('timetables_id')
            ->count('timetables_id');

        if ($countTimetable == 1) {
            if (array_intersect([5,7,2], $statuses)) {
                $statusSummary = 2; //Present
            }
            if (in_array(8, $statuses)) {
                $statusSummary = 8; //Incomplete Punch
            }
            if (in_array(4, $statuses)) {
                $statusSummary = 4; //"Late-CheckIn";
            }
            if (in_array(6, $statuses)) {
                $statusSummary = 6; //"Early-CheckOut";
            }
            if (in_array(4, $statuses) && in_array(6, $statuses)) {
                $statusSummary = 14; //"Late-CheckIn & Early-CheckOut";
            }
            
            if (in_array(9, $statuses)) {
                $statusSummary = 9; //"Day Off";
            }
            if (in_array(10, $statuses)) {
                $statusSummary = 10; //Holiday
            }
            if (in_array(11, $statuses)) {
                $statusSummary = 11; //On-Leave
            }
            if (in_array(13, $statuses)) {
                $statusSummary = 13; //"Off-Shift";
            }
            if (in_array(15, $statuses)) {
                $statusSummary = 15; //"Works on Holiday";
            }
            if (in_array(12, $statuses)) {
                $statusSummary = 12; //"Works-On-Leave";
            }
            if (in_array(1, $statuses)) {
                $statusSummary = 1; //Absent
            }
        }
        if ($countTimetable > 1) {
            if (array_intersect([5,7,2], $statuses)) {
                $statusSummary = 2; //"Present";
            }
            if (in_array(1, $statuses) && in_array(2, $statuses) && !in_array(8, $statuses)) {
                $statusSummary = 3; //"Partial Present";
            }
            if (in_array(8, $statuses)) {
                $statusSummary = 8; //Incomplete Punch
            }
            
            if (in_array(4, $statuses)) {
                $statusSummary = 4; //"Late-CheckIn";
            }
            if (in_array(6, $statuses)) {
                $statusSummary = 6; //"Early-CheckOut";
            }
            if (in_array(4, $statuses) && in_array(6, $statuses)) {
                $statusSummary = 14; //"Late-CheckIn & Early-CheckOut";
            }
            if (in_array(9, $statuses)) {
                $statusSummary = 9; //"Day Off";
            }
            if (in_array(10, $statuses)) {
                $statusSummary = 10; //Holiday
            }
            if (in_array(11, $statuses)) {
                $statusSummary = 11; //On-Leave
            }
            if (in_array(15, $statuses)) {
                $statusSummary = 15; //"Works on Holiday";
            }
            if (in_array(12, $statuses)) {
                $statusSummary = 12; //"Works-On-Leave";
            }
            if (in_array(13, $statuses)) {
                $statusSummary = 13; //"Off-Shift";
            }
            if (in_array(1, $statuses) && !in_array(2, $statuses)) {
                $statusSummary = 1; //Absent
            }
        }

        $data[]=[
                'employees_id' => $employeeId,
                'Date' => $date,
                'WorkingTimeAmount' => round(($totalworkinghr - $offShiftOvertime),2),
                'BreakTimeAmount' => round($totalbreaktime,2),
                'BeforeOvertimeAmount' => round($totalbeforeot,2),
                'AfterOvertimeAmount' => round($totalafterot,2),
                'TotalOvertimeAmount' => round($totalot,2),
                'LateCheckInTimeAmount' => round($totallatechekinhr,2),
                'EarlyCheckOutTimeAmount' => round($totallatechekouthr,2),
                'BeforeOnDutyTimeAmount' => round($totalbeforeondutytime,2),
                'AfterOffDutyTimeAmount' => round($totalafteroffdutytime,2),
                'OffShiftOvertime' => round($offShiftOvertime,2),
                'OffShiftOvertimeLevelPercent' => round($offShiftOvertimeLevelPercent,2),
                'Status' => $statusSummary,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

        $this->syncAttendance($data);
    }

    public function syncAttendance($data) {
        
        foreach ($data as $record) {
            // Define unique identifiers (adjust based on your table structure)
            $employeeId = $record['employees_id'];
            $date = $record['Date']; // Assuming date is stored in 'Y-m-d' format

            // Check if the record exists
            $existingRecord = DB::table('attendance_summaries')
                ->where('employees_id', $employeeId)
                ->where('Date', $date)
                ->first();

            if ($existingRecord) {
                // Convert to an array for comparison
                $existingData = (array) $existingRecord;
                unset($existingData['id']); // Remove ID if it's auto-incremented

                // Check if data has changed
                if (array_diff_assoc($record, $existingData)) {
                    // Update only if there is a difference
                    DB::table('attendance_summaries')
                        ->where('employees_id', $employeeId)
                        ->where('Date', $date)
                        ->update($record);
                }
            } else {
                // Insert new record if not exists
                DB::table('attendance_summaries')->insert($record);
            }
        }
    }

}
