<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use DB;
use App\Notifications\RealTimeNotification;
use App\Http\Controllers\HomeController;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Route;

class DemoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $days=0;
        $settingsval = DB::table('settings')->latest()->first();
        $expdate=$settingsval->ExpireDate;

        $checkexpdate=DB::select('SELECT DATEDIFF("'.$expdate.'",CURDATE()) AS RemainingDate,"'.$expdate.'" AS ExpiredateVal'); 
        foreach($checkexpdate as $row){
            $days=$row->RemainingDate;
        }
        if($days<= 80){
            \Log::info("This is lessthan 80 ".$days);
        }
        else if($days> 80){
            \Log::info("This is greatherthan 80 ".$days);
        }
        $usersIssue = User::join('storeassignments', 'storeassignments.UserId', '=', 'users.id')
        ->where(['storeassignments.UserId' => 1])
        ->get(['users.*']);

        //Replace your key, app_id and secret in the following lines 
       
     //  Route::get('/showexpdate','HomeController@checkExpireDate');

        Notification::send($usersIssue, new RealTimeNotification("A",''));
       // $html = view('submodal')->render();
        //return $html;
        // return response()->json(['checkexpdate'=>$checkexpdate]);
        //Route::get('/showexpdate','HomeController@checkExpireDate');
       // Notification::send(1, new RealTimeNotification(" Approved Your Requistion",'Approved'));
        //\Log::info($usersIssue);
        //$this->info('Hourly Update has been send successfully');
        //dd("hi there!");
       // echo "Cron is working fine!";
        //return 0;
    }
}
