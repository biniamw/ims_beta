<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class LeaveRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recdata,$userdata,$requesterdata,$prepareddata,$optypes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recdata,$userdata,$requesterdata,$prepareddata,$optypes)
    {
        $this->recdata = $recdata;
        $this->userdata = $userdata;
        $this->requesterdata = $requesterdata;
        $this->prepareddata = $prepareddata;
        $this->optypes = $optypes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullname= $this->userdata['FullName'];
        $leaveid= $this->recdata['LeaveID'];
        $requstername= $this->requesterdata['FullName'];
        $useremail= $this->recdata['LeaveID'];
        $optypesval=$this->optypes;
        $cdate = Carbon::today()->toDateString();
        $nws = Carbon::now(new \DateTimeZone('Africa/Addis_Ababa'))->format('g:i A');
        $currentdateandtime=$cdate." @ ".$nws;

        $messagebody="";
        $messagesubject="";

        if($optypesval==1){
            $messagesubject="Leave Request Created";
            $messagebody=" created ".$leaveid." leave request.";
        }
        if($optypesval==2){
            $messagesubject="Leave Request Updated";
            $messagebody=" updated ".$leaveid." leave request.";
        }
        if($optypesval==3){
            $messagesubject="Leave Request Voided";
            $messagebody=" voided your ".$leaveid." leave request.";
        }
        if($optypesval==4){
            $messagesubject="Leave Request Undo-Void";
            $messagebody=" undo void your ".$leaveid." leave request.";
        }
        if($optypesval==5){
            $messagesubject="Leave Request Approved";
            $messagebody=" approved your ".$leaveid." leave request.";
        }
        if($optypesval==6){
            $messagesubject="Leave Request Commented";
            $messagebody=" commented on your ".$leaveid." leave request.";
        }
        if($optypesval==7){
            $messagesubject="Leave Request Rejected";
            $messagebody=" rejected your ".$leaveid." leave request.";
        }

        if($optypesval==1 ||$optypesval==2){
            return $this->subject($messagesubject)->view('email.leavereq',compact('fullname','requstername','messagebody','leaveid','currentdateandtime'));
        }
        if($optypesval==3 ||$optypesval==4 ||$optypesval==5 ||$optypesval==6||$optypesval==7){
            return $this->subject($messagesubject)->view('email.leavereqemp',compact('fullname','requstername','messagebody','leaveid','currentdateandtime'));
        }

        
    }
}
