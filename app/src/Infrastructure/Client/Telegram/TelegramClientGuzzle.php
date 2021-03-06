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

    public function send(string $token, string $chat, string $text, ?string $mode = null): void
    {
        $data = [
            'text' => $text,
            'chat_id' => $chat,
        ];

        if ($mode !== null) {
            $data['parse_mode'] = $mode;
        }

        $this->client->post(self::URI . "bot$token/sendMessage", ['json' => $data]);
    }
}
