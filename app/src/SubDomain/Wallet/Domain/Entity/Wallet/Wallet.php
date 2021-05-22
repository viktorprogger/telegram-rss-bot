<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

final class Wallet
{
    private array $guestIds;

    public function __construct(
        private WalletIdInterface $id,
        private UserIdInterface $ownerId,
        private bool $active,
        private string $title,
        UserIdInterface ...$guestIds
    ) {
        $this->guestIds = $guestIds;
    }

    public function getId(): WalletIdInterface
    {
        return $this->id;
    }

    public function getOwnerId(): UserIdInterface
    {
        return $this->ownerId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return UserIdInterface[]
     */
    public function getGuestIds(): array
    {
        return $this->guestIds;
    }
}
