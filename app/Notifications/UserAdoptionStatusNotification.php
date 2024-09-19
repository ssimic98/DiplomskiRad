<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserAdoptionStatusNotification extends Notification
{
    use Queueable;
    protected $status;
    protected $adoptionRequest;
    /**
     * Create a new notification instance.
     */
    public function __construct($adoptionRequest,$status )
    {
        $this->adoptionRequest=$adoptionRequest;
        $this->status=$status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
                'adoption_request_id'=>$this->adoptionRequest->id,
                'message'=>'Vaš zahtjev za udomljavanjem je '.$this->status,
                'status'=>$this->status,
                'url'=>url('user/adoption/status',$this->adoptionRequest->id),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
