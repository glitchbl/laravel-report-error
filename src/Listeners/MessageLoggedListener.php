<?php

namespace Glitchbl\ReportError\Listeners;

use Glitchbl\ReportError\Mail\Error as Email;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Log\Events\MessageLogged;

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
        $levels = config('report-error.levels', []);
        $ignores = config('report-error.ignores', []);

        if (is_array($levels) && !in_array($event->level, $levels))
            return;

        if (is_array($ignores)) {
            foreach ($ignores as $ignore) {
                if (strpos($event->message, $ignore) !== false)
                    return;
            }
        }
        
        $email = config('report-error.email');
        app(Mailer::class)->to($email)->send(new Email($event));
    }
}
