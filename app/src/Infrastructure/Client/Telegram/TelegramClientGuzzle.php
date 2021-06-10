<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Client\Telegram;

use GuzzleHttp\Client;
use Resender\Domain\Client\TelegramClientInterface;

final class TelegramClientGuzzle implements TelegramClientInterface
{
    private const URI = 'https://api.telegram.org/';

    public function __construct(private Client $client)
    {
    }

    public function sendMessage(string $token, string $chat, string $text, ?string $mode = null): void
    {
        $data = [
            'text' => $text,
            'chat_id' => $chat,
        ];

        if ($mode !== null) {
            $data['parse_mode'] = $mode;
        }

        $this->send('sendMessage', $token, $data);
    }

    public function send(string $apiEndpoint, string $token, array $data = []): ?array
    {
        $response = $this->client->post(self::URI . "bot$token/$apiEndpoint", ['json' => $data])->getBody()->getContents();
        if (!empty($response)) {
            return json_decode($response, true, flags: JSON_THROW_ON_ERROR);
        }

        return null;
    }
}
