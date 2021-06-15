<?php

declare(strict_types=1);

namespace Resender\Domain\Client;

use Resender\Domain\Client\Telegram\TelegramMessage;

interface TelegramClientInterface
{
    public function sendMessage(string $token, TelegramMessage $message): void;

    public function send(string $apiEndpoint, string $token, array $data = []): ?array;
}
