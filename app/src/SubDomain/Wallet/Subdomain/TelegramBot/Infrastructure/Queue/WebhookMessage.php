<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Infrastructure\Queue;

use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\ChatState;
use Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain\TelegramRequest;
use Yiisoft\Yii\Queue\Message\AbstractMessage;

final class WebhookMessage extends AbstractMessage
{
    public const NAME = 'wallet-webhook';

    public function __construct(private ChatState $state, private TelegramRequest $request)
    {
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getData(): array
    {
        return [
            'state' => $this->state->getValue(),
            'request' => [
                'userId' => $this->request->getUserId(),
                'walletId' => $this->request->getWalletId(),
                'categoryId' => $this->request->getCategoryId(),
                'data' => $this->request->getData(),
            ],
        ];
    }
}
