<?php

namespace App\Packages\Src\Listeners;

use Illuminate\Log\Events\MessageLogged;
use App\Packages\Src\Notifications\ErrorReport;
use App\Packages\Src\Notifiables\User;

class MessageLoggedListener
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
     * @param  MessageLogged  $event
     * @return void
     */
    public function handle(MessageLogged $event)
    {
        if (!in_array($event->level, config('report-error.levels')))
            return;
        $user = new User();
        $user->email = config('report-error.email');
        $user->notify(new ErrorReport($event));
    }
}
