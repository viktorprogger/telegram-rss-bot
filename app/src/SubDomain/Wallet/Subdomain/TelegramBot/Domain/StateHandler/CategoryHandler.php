<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

final class CategoryHandler implements HandlerInterface
{
    public function handle(ChatState $state, TelegramRequest $request): ?TelegramMessage
    {
        // TODO: Implement handle() method.
    }
}
