<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

final class Wallet
{
    private array $userIds;

    public function __construct(
        private WalletIdInterface $id,
        private UserIdInterface $ownerId,
        private string $title,
        UserIdInterface ...$userIds
    ) {
        $this->userIds = $userIds;
    }

    public function getId(): WalletIdInterface
    {
        return $this->id;
    }

    public function getOwnerId(): UserIdInterface
    {
        return $this->ownerId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return UserIdInterface[]
     */
    public function getUserIds(): array
    {
        return $this->userIds;
    }
}
