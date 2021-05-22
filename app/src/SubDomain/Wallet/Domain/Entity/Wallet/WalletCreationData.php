<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

final class WalletCreationData
{
    public function __construct(
        private WalletIdInterface $id,
        private UserIdInterface $userId,
        private bool $active,
        private string $title
    ) {
    }

    public function getId(): WalletIdInterface
    {
        return $this->id;
    }

    public function getOwnerId(): UserIdInterface
    {
        return $this->userId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
