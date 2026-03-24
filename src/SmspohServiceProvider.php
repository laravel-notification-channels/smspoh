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
    public function boot(): void {}

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(SmspohApi::class, static function () {
            $key = config('services.smspoh.key');
            $secret = config('services.smspoh.secret');

            $token = $key && $secret ? base64_encode("{$key}:{$secret}") : config('services.smspoh.token');

            return new SmspohApi(
                $token,
                app(HttpClient::class)
            );
        });

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('smspoh', static fn ($app) => new SmspohChannel(
                $app[SmspohApi::class],
                $app['config']['services.smspoh.from'] ?: $app['config']['services.smspoh.sender']
            ));
        });
    }
}
