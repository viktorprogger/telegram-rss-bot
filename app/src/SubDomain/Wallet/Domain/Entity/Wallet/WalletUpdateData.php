<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

final class WalletUpdateData
{
    private array $userIds;

    public function __construct(private bool $active, private string $title, UserIdInterface ...$userIds)
    {
        $this->userIds = $userIds;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUserIds(): array
    {
        return $this->userIds;
    }
}
