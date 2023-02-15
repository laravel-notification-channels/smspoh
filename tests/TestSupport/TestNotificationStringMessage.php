<?php

namespace NotificationChannels\Smspoh\Tests\TestSupport;

use Illuminate\Notifications\Notification;

class TestNotificationStringMessage extends Notification
{
    public function toSmspoh($notifiable): string
    {
        return 'this is my message';
    }
}
