<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Routing;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

final class MessageRouter
{
    public function __construct(private RouteCollection $routes)
    {
    }

    public function handle(ChatState $state, TelegramRequest $request): TelegramMessage
    {
        return $this->routes->find($state)->handle($state, $request);
    }
}
