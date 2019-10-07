<?php

namespace Glitchbl\ReportError\Tests;

use Illuminate\Mail\Events\MessageSending;
use Event;
use Log;

class Test extends TestCase
{
    public function test_mail()
    {
        $_SERVER['__report-error.test'] = false;
        $log_message = uniqid();
        Event::listen(MessageSending::class, function ($event) use ($log_message) {
            $passed = true;
            if ($event->data['subject'] !== 'Laravel - Report - Error') 
                $passed = false;
            if (!isset($event->data['introLines'][0]) || $event->data['introLines'][0] !== $log_message) 
                $passed = false;
            $_SERVER['__report-error.test'] = $passed;
        });
        Log::error($log_message);
        $this->assertTrue($_SERVER['__report-error.test']);
        Event::flush(MessageSending::class);
    }

    public function test_ignores()
    {
        config()->set('report-error.levels', ['error']);
        config()->set('report-error.ignores', ['should not trigger']);
        $_SERVER['__report-error.test'] = true;
        Event::listen(MessageSending::class, function ($event) {
            $_SERVER['__report-error.test'] = false;
        });
        Log::error('this error should not trigger event');
        Log::info('neither this one');
        $this->assertTrue($_SERVER['__report-error.test']);
        Event::flush(MessageSending::class);
    }
}
