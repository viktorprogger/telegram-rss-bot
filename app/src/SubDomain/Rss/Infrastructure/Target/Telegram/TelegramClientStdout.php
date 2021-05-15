<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Target\Telegram;

class TelegramClientStdout implements TelegramClientInterface
{
    public function send(string $token, string $chat, string $text, ?string $mode = null): void
    {
        echo json_encode(
            [
                'token' => $token,
                'chat' => $chat,
                'text' => $text,
                'mode' => $mode,
            ],
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        );
    }
}
