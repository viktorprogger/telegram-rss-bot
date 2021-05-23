<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Web;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

final class TelegramController
{
    public function __construct(private ResponseFactoryInterface $responseFactory)
    {
    }

    public function webhook(): ResponseInterface
    {
        // TODO

        return $this->responseFactory->createResponse();
    }
}
