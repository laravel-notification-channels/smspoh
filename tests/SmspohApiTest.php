<?php

namespace NotificationChannels\Smspoh\Tests;

use GuzzleHttp\Client;
use NotificationChannels\Smspoh\Exceptions\CouldNotSendNotification;
use NotificationChannels\Smspoh\SmspohApi;

class SmspohApiTest extends TestCase
{
    private string $token = 'token';

    /** @test */
    public function it_has_config_with_default(): void
    {
        $endpoint = 'https://smspoh.com/api/v2/send';

        config()->set('services.smspoh.token', $this->token);
        config()->set('services.smspoh.endpoint', $endpoint);

        $smspoh = $this->getExtendedSmspohApi($this->token);

        $this->assertEquals($this->token, $smspoh->getToken());
        $this->assertEquals($endpoint, $smspoh->getEndpoint());
    }

    /** @test */
    public function it_can_check_smspoh_responded_with_error(): void
    {
        $this->withoutExceptionHandling();

        $smspoh = new SmspohApi($this->token, new Client());

        $this->expectException(CouldNotSendNotification::class);
        $this->expectExceptionCode(401);

        $smspoh->send([
            'sender' => '5554443333',
            'to' => '5555555555',
            'message' => 'this is my message',
            'test' => true,
        ]);
    }

    /** @test */
    public function it_can_check_not_communicate_with_smspoh(): void
    {
        $this->withoutExceptionHandling();

        config()->set('services.smspoh.endpoint', 'https://smspoh2.com/api/v2/send');

        $smspoh = new SmspohApi($this->token, new Client());

        $this->expectException(CouldNotSendNotification::class);

        $smspoh->send([
            'sender' => '5554443333',
            'to' => '5555555555',
            'message' => 'this is my message',
            'test' => true,
        ]);
    }

    private function getExtendedSmspohApi($token)
    {
        return new class($token) extends SmspohApi
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
}
