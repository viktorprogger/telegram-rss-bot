<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Subdomain\TelegramBot\Domain;

use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;

final class TelegramRequest
{
    public function __construct(
        private UserIdInterface $userId,
        private ?WalletIdInterface $walletId,
        private ?CategoryIdInterface $categoryId,
        private mixed $data,
    ) {
    }

    public function getUserId(): UserIdInterface
    {
        return $this->userId;
    }

    public function getWalletId(): ?WalletIdInterface
    {
        return $this->walletId;
    }

    public function getCategoryId(): ?CategoryIdInterface
    {
        return $this->categoryId;
    }

    public function getData(): mixed
    {
        return $this->data;
    }
}
