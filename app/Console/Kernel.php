<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\DemoCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('personnelLog:cron')->everyMinute();
        $schedule->command('attendance:sync')->everyMinute();
        //$schedule->command('sync:members')->everyMinute();
        //$schedule->command('auto:subscribe')->everyMinute();
        // $schedule->command('inspire')->hourly();
        // $schedule->command('demo:cron')->everyMinute();
        // $schedule->call(function () {
        //     $curdate=Carbon::today()->toDateString();
        //     //DB::table('applications')->where('ExpiryDate',$curdate)->update(['Status'=>"Expired"]);
        //     DB::table('appconsolidates')->where('ExpiryDate',$curdate)->update(['Status'=>"Expired"]);
        // })->dailyAt('13:26')->timezone('Africa/Addis_Ababa');


        $schedule->call(function () {
            $curdate = Carbon::today()->toDateString();

            $attendacesumm = DB::select('SELECT attendance_summaries.id,attendance_summaries.employees_id FROM attendance_summaries WHERE attendance_summaries.Date="'.$curdate.'" AND attendance_summaries.Status=1');
            foreach($attendacesumm as $row){
                $leavedata = DB::select('SELECT * FROM hr_leaves WHERE "'.$curdate.'" BETWEEN hr_leaves.LeaveFrom AND hr_leaves.LeaveTo AND hr_leaves.LeaveDurationType="Non-Consecutive" AND hr_leaves.Status="Approved" AND hr_leaves.requested_for='.$row->employees_id);

                $leave_from = $leavedata[0]->LeaveFrom ?? "";
                $leave_to = $leavedata[0]->LeaveTo ?? "";
                $no_of_days = ceil($leavedata[0]->NumberOfDays ?? 0);

                $attendance_count = DB::select('SELECT COUNT(attendance_summaries.id) AS utilized_leave FROM attendance_summaries WHERE attendance_summaries.Date BETWEEN "'.$leave_from.'" AND "'.$leave_to.'" AND attendance_summaries.employees_id='.$row->employees_id.' AND attendance_summaries.Status=11');
                $utilized_leave = $attendance_count[0]->utilized_leave;

                if($utilized_leave <= $no_of_days && $no_of_days > 0){
                    DB::table('attendance_summaries')->where('attendance_summaries.id',$row->id)->update(['Status'=>11]);
                }
            }

        })->dailyAt('23:59')->timezone('Africa/Addis_Ababa');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
