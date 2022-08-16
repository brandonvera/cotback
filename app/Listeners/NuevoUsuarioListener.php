<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\NuevoUsuarioEvent;
use App\Notifications\NuevoUsuarioNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NuevoUsuarioListener
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
        $cod = $last->codigo;

        $admins = User::where([
            ['id_tipo', 1],
            ['estado', 'ACTIVO'],
            ['codigo', '<>', $cod]
        ])->get();

        Notification::send($admins, new NuevoUsuarioNotification($event->user));
    }
}
