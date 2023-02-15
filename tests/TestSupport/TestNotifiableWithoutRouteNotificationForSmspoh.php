<?php

namespace NotificationChannels\Smspoh\Tests\TestSupport;

class TestNotifiableWithoutRouteNotificationForSmspoh extends TestNotifiable
{
    public function routeNotificationForSmspoh($notification)
    {
        return false;
    }
}
