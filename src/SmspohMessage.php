<?php

namespace NotificationChannels\Smspoh;

class SmspohMessage
{
    /**
     * The message content.
     */
    public string $content;

    /**
     * The sander name the message should be sent from.
     *
     * @deprecated Use $from instead.
     */
    public ?string $sender = null;

    /**
     * The Sender ID (alphanumeric or numeric, depending on your account settings). Please note that the Sender ID is case-sensitive.
     */
    public ?string $from = null;

    /**
     * Set the test message Send a test message to specific mobile number.
     */
    public bool $test = false;

    /**
     * Unique client reference.
     */
    public ?string $clientReference = null;

    /**
     * Create a new message instance.
     */
    public function __construct(string $content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     */
    public function content(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the sender name the message should be sent from.
     *
     * @deprecated Use from() instead.
     */
    public function sender(string $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Set the sender name the message should be sent from.
     */
    public function from(string $from): static
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the test message Send a test message to specific mobile number.
     */
    public function test(bool $test = true): static
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Set the client reference.
     */
    public function clientReference(string $clientReference): static
    {
        $this->clientReference = $clientReference;

        return $this;
    }
}
