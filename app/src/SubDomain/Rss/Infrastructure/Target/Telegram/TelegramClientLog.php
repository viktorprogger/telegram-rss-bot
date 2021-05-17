<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Target\Telegram;

use Psr\Log\LoggerInterface;

class TelegramClientLog implements TelegramClientInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function send(string $token, string $chat, string $text, ?string $mode = null): void
    {
        $fields = [
            'token' => $token,
            'chat' => $chat,
            'text' => $text,
            'mode' => $mode,
        ];

        $this->logger->debug('A message to Telegram', $fields);
    }
}
