<?php

namespace App\Packages\Src;

use Illuminate\Support\ServiceProvider;

class ReportErrorServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__ . '/../config/report-error.php');
        $this->publishes([$source => config_path('report-error.php')]);
        $this->mergeConfigFrom($source, 'report-error');
        $this->app['events']->listen('Illuminate\Log\Events\MessageLogged', 'App\Packages\Src\Listeners\MessageLoggedListener');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
