<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Routing;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler\HandlerInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

interface MiddlewareInterface
{
    public function handle(ChatState $state, TelegramRequest $request, HandlerInterface $handler): TelegramMessage;
}
