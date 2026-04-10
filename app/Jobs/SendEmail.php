<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NotifyVerification;
use Mail;
use Illuminate\Support\Facades\DB;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $usersattr=DB::select('SELECT users.FullName,users.username,users.email FROM users INNER JOIN model_has_roles ON users.id=model_has_roles.model_id WHERE (users.email is not null AND users.email <>"") AND users.id>0 AND model_has_roles.role_id IN(SELECT role_has_permissions.role_id FROM role_has_permissions WHERE role_has_permissions.permission_id=(SELECT permissions.id FROM permissions WHERE permissions.name="Invoice-Verify"))');
        foreach($usersattr as $row){
            $usersfullname=$row->FullName;
            $usersusername=$row->username;
            $usersemail=$row->email;
            Mail::to($row->email)->send(new NotifyVerification($usersfullname,$usersusername,$usersemail));
        }
        return 1;
    }
}
