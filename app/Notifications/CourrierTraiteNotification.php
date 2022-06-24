<?php

namespace App\Notifications;

use App\Models\Courrier\CrCourrier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourrierTraiteNotification extends Mailable
{
    use Queueable;



    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CrCourrier $courrier)
    {
        $this->courrier = $courrier;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Traitement du courrier " . $this->courrier->libelle)
            ->markdown('mail.inscription.courrier-traiter', ['url' => env('APP_URL') . '/courrier/entrant', 'courrier' => $this->courrier]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
