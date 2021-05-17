<?php

declare(strict_types=1);

namespace Resender\Domain\Client;

interface TelegramClientInterface
{
    public function send(string $token, string $chat, string $text, ?string $mode = null): void;
}
