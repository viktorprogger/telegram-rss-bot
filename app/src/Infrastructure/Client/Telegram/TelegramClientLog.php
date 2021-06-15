<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Client\Telegram;

use Psr\Log\LoggerInterface;
use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\Domain\Client\TelegramClientInterface;

final class TelegramClientLog implements TelegramClientInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function sendMessage(string $token, TelegramMessage $message): void
    {
        $this->send('sendMessage', $token, $message->getArray());
    }

    public function send(string $apiEndpoint, string $token, array $data = []): ?array
    {
        $fields = [
            'endpoint' => $apiEndpoint,
            'token' => $token,
            'data' => $data,
        ];

        $this->logger->debug('A message to Telegram', $fields);

        return null;
    }
}
