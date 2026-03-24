<?php

use NotificationChannels\Smspoh\SmspohMessage;

it('can accept a content when constructing a message', function () {
    $message = new SmspohMessage('hello');

    $this->assertEquals('hello', $message->content);
});

it('can set the content', function () {
    $message = (new SmspohMessage)->content('hello');

    $this->assertEquals('hello', $message->content);
});

it('can set the from', function () {
    $message = (new SmspohMessage)->sender('Smspoh');

    $this->assertEquals('Smspoh', $message->sender);
});

it('can set the test', function () {
    $message = (new SmspohMessage)->test(true);

    $this->assertTrue($message->test);
});

it('can set the client reference', function () {
    $message = (new SmspohMessage)->clientReference('abcde12345');

    $this->assertEquals('abcde12345', $message->clientReference);
});

it('can set the scheduledAt', function () {
    $message = (new SmspohMessage)->scheduledAt('2026-03-24 12:00:00');

    $this->assertEquals('2026-03-24 12:00:00', $message->scheduledAt);
});

it('can set the encrypt', function () {
    $message = (new SmspohMessage)->encrypt(true);

    $this->assertTrue($message->encrypt);
});

it('can set the encrypt key', function () {
    $message = (new SmspohMessage)->encryptKey('SecretKey');

    $this->assertEquals('SecretKey', $message->encryptKey);
});

it('can set the unicode', function () {
    $message = (new SmspohMessage)->unicode(true);

    $this->assertTrue($message->unicode);
});

it('can set the delivery receipt url', function () {
    $message = (new SmspohMessage)->deliveryReceiptUrl('https://example.com/webhook');

    $this->assertEquals('https://example.com/webhook', $message->deliveryReceiptUrl);
});
