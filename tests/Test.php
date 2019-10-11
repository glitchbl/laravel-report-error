<?php

namespace Glitchbl\ReportError\Tests;

use Glitchbl\ReportError\Mail\Error as Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Test extends TestCase
{
    public function test_email()
    {
        Mail::fake();
        Log::error('test');
        Mail::assertSent(Email::class, function ($mail) {
            $mail->build();
            return $mail->hasTo(config('report-error.email')) &&
                   $mail->subject == config('app.name') . ' - Report - Error' &&
                   $mail->event->level == 'error' &&
                   $mail->event->message == 'test';
        });
    }

    public function test_ignores()
    {
        config()->set('report-error.levels', ['error']);
        config()->set('report-error.ignores', ['should not trigger']);
        Mail::fake();
        Log::error('this error should not trigger the event');
        Log::info('neither this one');
        Mail::assertNotSent(Email::class);
    }
}
