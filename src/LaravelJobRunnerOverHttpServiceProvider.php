<?php

namespace BrajMohan\LaravelJobRunnerOverHttp;

use Illuminate\Support\ServiceProvider;

class LaravelJobRunnerOverHttpServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes([__DIR__ . '/routes.php' => base_path('/routes/job-runner.php')]);
    }
}
