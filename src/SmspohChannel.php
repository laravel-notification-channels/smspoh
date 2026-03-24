<?php

namespace NotificationChannels\Smspoh;

use Illuminate\Notifications\Notification;
use NotificationChannels\Smspoh\Exceptions\CouldNotSendNotification;
use Psr\Http\Message\ResponseInterface;

class SmspohChannel
{
    /**
     * The Smspoh client instance.
     */
    protected SmspohApi $smspoh;

    /**
     * The phone number notifications should be sent from.
     */
    protected string $from;

    /**
     * The message body content count should be no longer than 6 message parts(918).
     */
    protected int $character_limit_count = 918;

    public function __construct(SmspohApi $smspoh, $from)
    {
        $this->smspoh = $smspoh;
        $this->from = $from;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @return mixed|ResponseInterface|void
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('smspoh', $notification)) {
            return;
        }

        /* @phpstan-ignore-next-line */
        $message = $notification->toSmspoh($notifiable);

        if (is_string($message)) {
            $message = new SmspohMessage($message);
        }

        if (mb_strlen($message->content) > $this->character_limit_count) {
            throw CouldNotSendNotification::contentLengthLimitExceeded($this->character_limit_count);
        }

        return $this->smspoh->send([
            'from' => $message->from ?: $message->sender ?: $this->from,
            'to' => $to,
            'message' => trim($message->content),
            'test' => $message->test ?: false,
            'clientReference' => $message->clientReference,
            'scheduledAt' => $message->scheduledAt,
            'encrypt' => $message->encrypt,
            'encryptKey' => $message->encryptKey,
            'unicode' => $message->unicode,
            'deliveryReceiptUrl' => $message->deliveryReceiptUrl,
        ]);
    }
}
