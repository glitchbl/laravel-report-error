<?php

namespace Glitchbl\ReportError\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ErrorReport extends Notification
{
    use Queueable;

    /**
     * @var MessageLogged
     */
    public $event;

    /**
     * @param  MessageLogged  $event
     * @return void
     */
    public function __construct(MessageLogged  $event)
    {
        $this->event = $event;
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
                    ->subject(config('app.name') . ' - Report - ' . ucfirst($this->event->level))
                    ->line($this->event->message);
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
