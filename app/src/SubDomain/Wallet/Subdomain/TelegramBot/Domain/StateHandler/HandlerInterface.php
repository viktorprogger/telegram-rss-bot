<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler;

use Resender\Domain\Client\Telegram\TelegramMessage;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

interface HandlerInterface
{
    public function handle(TelegramRequest $message): TelegramMessage;

    public function validate(TelegramRequest $message): bool;
}
