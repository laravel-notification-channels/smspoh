<?php

namespace NotificationChannels\Smspoh\Tests\TestSupport;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public string $phone_number = '5555555555';

    public function routeNotificationForSmspoh($notification)
    {
        return $this->phone_number;
    }
}
