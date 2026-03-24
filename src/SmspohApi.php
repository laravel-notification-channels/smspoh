<?php

namespace NotificationChannels\Smspoh;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use NotificationChannels\Smspoh\Exceptions\CouldNotSendNotification;
use Psr\Http\Message\ResponseInterface;

class SmspohApi
{
    public const ENDPOINT = 'https://v3.smspoh.com/api/rest/send';

    protected HttpClient $client;

    protected string $endpoint;

    protected string $sender;

    protected mixed $token;

    public function __construct($token = null, $httpClient = null)
    {
        $this->token = $token;
        $this->client = $httpClient;

        $this->endpoint = config('services.smspoh.endpoint', self::ENDPOINT);
    }

    /**
     * Send text message.
     *
     * <code>
     * $message = [
     *   'from'               => '', // String - The Sender ID (alphanumeric or numeric, depending on your account settings). Please note that the Sender ID is case-sensitive.
     *   'to'                 => '', // String - Recipient mobile numbers. The mobile number can start with (09, 959 or +959) prefixes.
     *   'message'            => '', // String - The message text to be sent.
     *   'test'               => '', // Boolean - Send a test message.
     *   'clientReference'    => '', // String - Your reference value for this transaction.
     *   'scheduledAt'        => '', // String - Scheduling delivery. The datetime string should be in Y-m-d H:i:s format.
     *   'encrypt'            => '', // Boolean - Encrypt the message content.
     *   'encryptKey'         => '', // String - The encryption key for message content.
     *   'unicode'            => '', // Boolean - Send as unicode message.
     *   'deliveryReceiptUrl' => '', // String - Callback URL to receive delivery receipts.
     * ];
     * </code>
     *
     * @link https://smspoh.com/v3/developers/restful-sms-api-specification#send-sms-url
     *
     * @return mixed|ResponseInterface
     *
     * @throws CouldNotSendNotification
     */
    public function send(array $message)
    {
        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'headers' => [
                    'Authorization' => "Bearer {$this->token}",
                ],
                'json' => array_filter([
                    'from' => Arr::get($message, 'from') ?: Arr::get($message, 'sender'),
                    'to' => Arr::get($message, 'to'),
                    'message' => Arr::get($message, 'message'),
                    'clientReference' => Arr::get($message, 'clientReference'),
                    'test' => Arr::get($message, 'test'),
                    'scheduledAt' => Arr::get($message, 'scheduledAt'),
                    'encrypt' => ($encrypt = Arr::get($message, 'encrypt')) !== null ? (int) $encrypt : null,
                    'encryptKey' => Arr::get($message, 'encryptKey'),
                    'unicode' => ($unicode = Arr::get($message, 'unicode')) !== null ? (int) $unicode : null,
                    'deliveryReceiptUrl' => Arr::get($message, 'deliveryReceiptUrl'),
                ], static fn ($value) => $value !== null),
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $e) {
            throw CouldNotSendNotification::smspohRespondedWithAnError($e);
        } catch (GuzzleException $e) {
            throw CouldNotSendNotification::couldNotCommunicateWithSmspoh($e);
        }
    }
}
