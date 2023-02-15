<?php

namespace NotificationChannels\Smspoh\Tests;

use Mockery;
use NotificationChannels\Smspoh\SmspohApi;
use NotificationChannels\Smspoh\SmspohChannel;
use NotificationChannels\Smspoh\SmspohServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected SmspohApi $smspohApi;

    protected SmspohChannel $channel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->singleton(SmspohApi::class, function () {
            return Mockery::mock(SmspohApi::class);
        });

        $this->smspohApi = app(SmspohApi::class);

        $this->channel = new SmspohChannel($this->smspohApi, '4444444444');
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [
            SmspohServiceProvider::class,
        ];
    }
}
