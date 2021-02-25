<?php

namespace BrajMohan\LaravelJobRunnerOverHttp\Tests;

use BrajMohan\LaravelJobRunnerOverHttp\LaravelJobRunnerOverHttpServiceProvider;
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
            LaravelJobRunnerOverHttpServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // Nothing here
    }
}
