<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CredencialesUsuarioNotification extends Notification
{
    use Queueable;

    public $user;
    public $pw;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $pw)
    {
        $this->user = $user;
        $this->pw = $pw;
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
        $usuario = $this->user;
        $pw = $this->pw;

        return (new MailMessage)->view(
            'notification.CredencialesUsuario',
            compact('usuario', 'pw')
        );
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
