<?php

declare(strict_types=1);

namespace Resender\Domain\Client;

interface TelegramClientInterface
{
    public function sendMessage(string $token, string $chat, string $text, ?string $mode = null): void;

    public function send(string $apiEndpoint, string $token, array $data = []): void;
}
