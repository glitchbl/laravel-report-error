<?php

namespace Glitchbl\ReportError\Tests;

use Glitchbl\ReportError\ReportErrorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ReportErrorServiceProvider::class,
        ];
    }
}
