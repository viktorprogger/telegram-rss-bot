<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain;

use Resender\Domain\Client\Telegram\TelegramMessage;

interface MiddlewareInterface
{
    public function handle(ChatState $state, TelegramRequest $request, MiddlewareInterface $middleware): TelegramMessage;
}
