<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class NotifyVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $usersfullname,$usersusername,$usersemail;
    //public function __construct($usersfullname,$usersusername,$usersemail)
    public function __construct($usersfullname,$usersusername,$usersemail)
    {
        //
        $this->fullname = $usersfullname;
        $this->username = $usersusername;
        $this->email = $usersemail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullname= $this->fullname;
        $username= $this->username;
        $useremail= $this->email;
        $cdate = Carbon::today()->toDateString();
        $nws = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('g:i A');
        $currentdateandtime=$cdate." @ ".$nws;
        return $this->subject('Verify new Record')->view('email.verifyemail',compact('fullname','username','useremail','currentdateandtime'));
    }
}
