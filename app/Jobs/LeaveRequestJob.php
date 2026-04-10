<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\LeaveRequestMail;
use App\Models\hr_leave;
use App\Models\User;
use Mail;
use Illuminate\Support\Facades\DB;

class LeaveRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $leaveid,$optype;
    public function __construct($leaveid,$optype)
    {
        //
        $this->leaveid = $leaveid;
        $this->optype = $optype;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $leavids= $this->leaveid;
        $optypes= $this->optype;
        $recdata=hr_leave::findorFail($leavids);
        $userdata=User::findorFail($recdata->supervisor);
        $requesterdata=User::findorFail($recdata->requested_for);
        $prepareddata=User::findorFail($recdata->prepared_by);

        if($optypes==1 ||$optypes==2){
            Mail::to($userdata->email)->send(new LeaveRequestMail($recdata,$userdata,$requesterdata,$prepareddata,$optypes));
        }
        if($optypes==3 ||$optypes==4||$optypes==5 ||$optypes==6||$optypes==7){
            Mail::to($requesterdata->email)->send(new LeaveRequestMail($recdata,$userdata,$requesterdata,$prepareddata,$optypes));
        }
        return 1;
    }
}
