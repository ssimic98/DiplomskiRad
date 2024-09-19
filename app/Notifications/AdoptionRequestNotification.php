<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class AdoptionRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $adoptionRequest;

    /**
     * Create a new notification instance.
     *
     * @param $adoptionRequest
     */
    public function __construct($adoptionRequest)
    {
        $this->adoptionRequest = $adoptionRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $url = url('/shelter/dogs/adoptionanswersdetail/' . $this->adoptionRequest->id);
    
        Log::info('Generirani URL:', ['url' => $url]);
        return [
            'adoption_request_id' => $this->adoptionRequest->id,
            'message' => 'Novi zahtjev za udomljavanjem od ' . $this->adoptionRequest->user->name,
            'url' => url('shelter/dogs/adoptionanswersdetail/' . $this->adoptionRequest->id),

        ];
    }
}
