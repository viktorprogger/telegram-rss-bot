<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Web;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Queue\WebhookMessage;
use Yiisoft\Yii\Queue\QueueFactoryInterface;

final class TelegramController
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
        private QueueFactoryInterface $queueFactory,
        private UserIdFactoryInterface $userIdFactory,
    ) {
    }

    public function webhook(ServerRequestInterface $request): ResponseInterface
    {

        $telegramRequest = new TelegramRequest(
            $userId,
            $walletId,
            $categoryId,
            $data
        );

        $message = new WebhookMessage($state, $telegramRequest);
        $this->queueFactory->get(WebhookMessage::NAME)->push($message);

        return $this->responseFactory->createResponse();
    }
}
