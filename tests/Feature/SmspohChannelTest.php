<?php

use NotificationChannels\Smspoh\Exceptions\CouldNotSendNotification;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotifiable;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotifiableWithoutRouteNotificationForSmspoh;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotification;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotificationLimitCountMessage;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotificationStringMessage;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotificationTooLongMessage;

it('can send a notification', function () {
    $this->smspohApi->shouldReceive('send')->with([
        'sender' => '5554443333',
        'to' => '5555555555',
        'message' => 'this is my message',
        'test' => false,
    ])->once();

    $this->channel->send(new TestNotifiable, new TestNotification);
});

it('can send string message', function () {
    $this->smspohApi->shouldReceive('send')->once();

    $this->channel->send(new TestNotifiable, new TestNotificationStringMessage);
});

it('does not send a message when to missed', function () {
    $this->smspohApi->shouldNotReceive('send');

    $this->channel->send(new TestNotifiableWithoutRouteNotificationForSmspoh, new TestNotification);
});

it('can check long content length', function () {
    $this->channel->send(new TestNotifiable, new TestNotificationTooLongMessage);
})->throws(CouldNotSendNotification::class, 'Notification was not sent. Content length may not be greater than 918 characters.');

it('can check limit count content', function () {
    $this->smspohApi->shouldReceive('send')->once();

    $this->channel->send(new TestNotifiable, new TestNotificationLimitCountMessage);
});
