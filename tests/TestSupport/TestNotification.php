<?php

namespace NotificationChannels\Smspoh\Tests\TestSupport;

use Illuminate\Notifications\Notification;
use NotificationChannels\Smspoh\SmspohMessage;

class TestNotification extends Notification
{
    /**
     * @param $notifiable
     * @return SmspohMessage
     */
    public function toSmspoh($notifiable): SmspohMessage
    {
        return (new SmspohMessage('this is my message'))->sender('5554443333');
    }
}
