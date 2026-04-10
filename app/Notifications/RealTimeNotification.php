<?php

namespace App\Notifications;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;


class RealTimeNotification extends Notification implements ShouldBroadcast
{
    //use Queueable;

    public $username;    
    public $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct($username,$message)
    {
        //
        $this->username = $username;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
   

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
   
    public function toDatabase($notifiable)
    {
        return [
            'username'=>$this->username,
            'message' => $this->message
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'username'=>$this->username,
            'message' => $this->message
            //'message' => "$this->message (User $notifiable->id)"
           
        ]);
    }
}
