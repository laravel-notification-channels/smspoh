<?php

use GuzzleHttp\Client;
use NotificationChannels\Smspoh\Exceptions\CouldNotSendNotification;
use NotificationChannels\Smspoh\SmspohApi;

it('has config with default', function () {
    $endpoint = 'https://smspoh.com/api/v2/send';

    config()->set('services.smspoh.token', 'token');
    config()->set('services.smspoh.endpoint', $endpoint);

    $smspoh = getExtendedSmspohApi('token', new Client);

    $this->assertEquals('token', $smspoh->getToken());
    $this->assertEquals($endpoint, $smspoh->getEndpoint());
});

it('can check smspoh responded with error', function () {
    $smspoh = new SmspohApi('token', new Client());

    $smspoh->send([
        'sender' => '5554443333',
        'to' => '5555555555',
        'message' => 'this is my message',
        'test' => true,
    ]);
})->throws(CouldNotSendNotification::class);

it('can check not communicate with smspoh', function () {
    config()->set('services.smspoh.endpoint', 'https://smspoh2.com/api/v2/send');

    $smspoh = new SmspohApi('token', new Client());

    $smspoh->send([
        'sender' => '5554443333',
        'to' => '5555555555',
        'message' => 'this is my message',
        'test' => true,
    ]);
})->throws(CouldNotSendNotification::class);

function getExtendedSmspohApi(string $token, Client $httpClient): SmspohApi
{
    return new class($token, $httpClient) extends SmspohApi
    {
        public function getEndpoint(): string
        {
            return $this->endpoint;
        }

        public function getToken(): string
        {
            return $this->token;
        }
    };
}
