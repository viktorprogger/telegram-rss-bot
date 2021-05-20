<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

interface WalletInterface
{
    public function getId(): WalletIdInterface;

    public function getOwnerId(): UserIdInterface;

    public function getTitle(): string;

    /**
     * @return UserIdInterface[]
     */
    public function getUserIds(): iterable;
}
