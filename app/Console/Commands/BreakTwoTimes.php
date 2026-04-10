<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BreakTwoTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'break:cron';

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
        ini_set('max_execution_time', '300000000');
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '-1');
        $currentdate = Carbon::today()->toDateString();
        $currentime = Carbon::now()->format('H:i');
        $currenthour=Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('H');
        return 0;
    }
}
