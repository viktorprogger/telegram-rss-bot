<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain;

use ArrayAccess;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\StateHandler\HandlerInterface;
use RuntimeException;

final class MessageRouter
{
    public function __construct(private ArrayAccess $config)
    {
    }

    public function handle(ChatState $state): HandlerInterface
    {
        return $this->config[$state]
            ?? throw new RuntimeException("The given state is not handled in the application: {$state->getValue()}");
    }
}
