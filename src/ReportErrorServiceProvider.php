<?php

namespace Glitchbl\ReportError;

use Illuminate\Support\ServiceProvider;
use Illuminate\Log\Events\MessageLogged;
use Glitchbl\ReportError\Listeners\MessageLoggedListener;

class ReportErrorServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__.'/../config/report-error.php');
        $this->publishes([$source => config_path('report-error.php')]);
        $this->mergeConfigFrom($source, 'report-error');
        $this->loadViewsFrom(__DIR__.'/../views', 'report-error');
        if (config('app.env', 'production') == 'production')
            $this->app['events']->listen(MessageLogged::class, MessageLoggedListener::class);
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
