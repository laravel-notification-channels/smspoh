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
