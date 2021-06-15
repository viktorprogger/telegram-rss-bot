<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Client\Telegram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\Domain\Client\TelegramClientInterface;

final class TelegramClientGuzzle implements TelegramClientInterface
{
    private const URI = 'https://api.telegram.org/';

    public function __construct(private Client $client)
    {
    }

    public function sendMessage(string $token, TelegramMessage $message): void
    {
        $this->send('sendMessage', $token, $message->getArray());
    }

    public function send(string $apiEndpoint, string $token, array $data = []): ?array
    {
        try {
            dump($data);
            $response = $this->client->post(self::URI . "bot$token/$apiEndpoint", ['json' => $data])->getBody(
            )->getContents();

            if (!empty($response)) {
                dump($response);

                return json_decode($response, true, flags: JSON_THROW_ON_ERROR);
            }
        } catch (ClientException $exception) {
            dump(json_decode($exception->getResponse()->getBody()->getContents()));
        }

        return null;
    }
}
