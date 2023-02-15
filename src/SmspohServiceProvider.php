<?php

namespace NotificationChannels\Smspoh;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SmspohServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(SmspohApi::class, static fn () => new SmspohApi(
            config('services.smspoh.token'),
            app(HttpClient::class)
        ));

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('smspoh', static fn ($app) => new SmspohChannel(
                $app[SmspohApi::class],
                $this->app['config']['services.smspoh.sender'])
            );
        });
    }
}
