<?php

namespace Glitchbl\ReportError\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Log\Events\MessageLogged;

class Error extends Mailable
{
    use Queueable, SerializesModels;

    public $event;

    /**
     * @param MessageLogged $event
     * @return void
     */
    public function __construct(MessageLogged $event)
    {
        $this->event = $event;
    }

    /**
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name') . ' - Report - ' . ucfirst($this->event->level))->markdown('report-error::error');
    }
}
