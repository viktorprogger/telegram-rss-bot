<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\Action;

use Resender\Domain\Client\Telegram\Response;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;

interface ActionInterface
{
    public function handle(TelegramRequest $request, Response $response): Response;
}
