<?php

use Illuminate\Notifications\Notification;
use NotificationChannels\Smspoh\Exceptions\CouldNotSendNotification;
use NotificationChannels\Smspoh\SmspohMessage;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotifiable;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotifiableWithoutRouteNotificationForSmspoh;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotification;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotificationLimitCountMessage;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotificationStringMessage;
use NotificationChannels\Smspoh\Tests\TestSupport\TestNotificationTooLongMessage;

it('can send a notification', function () {
    $this->smspohApi->shouldReceive('send')->with([
        'from' => '5554443333',
        'to' => '5555555555',
        'message' => 'this is my message',
        'test' => false,
        'clientReference' => null,
        'scheduledAt' => null,
        'encrypt' => null,
        'encryptKey' => null,
        'unicode' => null,
        'deliveryReceiptUrl' => null,
    ])->once();

    $this->channel->send(new TestNotifiable, new TestNotification);
});

it('can send a notification using sender fallback', function () {
    $this->smspohApi->shouldReceive('send')->with([
        'from' => '5554443333',
        'to' => '5555555555',
        'message' => 'this is my message',
        'test' => false,
        'clientReference' => null,
        'scheduledAt' => null,
        'encrypt' => null,
        'encryptKey' => null,
        'unicode' => null,
        'deliveryReceiptUrl' => null,
    ])->once();

    $notification = new class extends Notification
    {
        public function toSmspoh($notifiable): SmspohMessage
        {
            return (new SmspohMessage('this is my message'))->sender('5554443333');
        }
    };

    $this->channel->send(new TestNotifiable, $notification);
});

it('can send string message', function () {
    $this->smspohApi->shouldReceive('send')->once();

    $this->channel->send(new TestNotifiable, new TestNotificationStringMessage);
});

it('can send a notification with additional options', function () {
    $this->smspohApi->shouldReceive('send')->with([
        'from' => '5554443333',
        'to' => '5555555555',
        'message' => 'this is my message',
        'test' => false,
        'clientReference' => null,
        'scheduledAt' => '2026-03-24 12:00:00',
        'encrypt' => true,
        'encryptKey' => 'SecretKey',
        'unicode' => true,
        'deliveryReceiptUrl' => 'https://example.com/webhook',
    ])->once();

    $notification = new class extends Notification
    {
        public function toSmspoh($notifiable): SmspohMessage
        {
            return (new SmspohMessage('this is my message'))
                ->from('5554443333')
                ->scheduledAt('2026-03-24 12:00:00')
                ->encrypt()
                ->encryptKey('SecretKey')
                ->unicode()
                ->deliveryReceiptUrl('https://example.com/webhook');
        }
    };

    $this->channel->send(new TestNotifiable, $notification);
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
