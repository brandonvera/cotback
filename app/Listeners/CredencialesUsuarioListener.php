<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NuevoUsuarioEvent;
use App\Notifications\CredencialesUsuarioNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CredencialesUsuarioListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NuevoUsuarioEvent $event)
    {
        $last = User::latest()->first();

        Notification::send($last, new CredencialesUsuarioNotification($event->user, $event->pw));
    }
}
