<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Client\Telegram;

use Psr\Log\LoggerInterface;
use Resender\Domain\Client\TelegramClientInterface;

final class TelegramClientLog implements TelegramClientInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function sendMessage(string $token, string $chat, string $text, ?string $mode = null): void
    {
        $fields = [
            'chat' => $chat,
            'text' => $text,
            'mode' => $mode,
        ];

        $this->send('sendMessage', $token, $fields);
    }

    public function send(string $apiEndpoint, string $token, array $data = []): void
    {
        $fields = [
            'endpoint' => $apiEndpoint,
            'token' => $token,
            'data' => $data,
        ];

        $this->logger->debug('A message to Telegram', $fields);
    }
}
