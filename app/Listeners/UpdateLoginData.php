<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLoginData
{
    /**
     * Handle the event.
     */
    public function handle(Login $event)
    {
        $user = $event->user;

        $user->total_logins += 1;
        $user->save();
    }
}
