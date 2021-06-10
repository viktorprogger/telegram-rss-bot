<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

interface WalletRepositoryInterface
{
    public function create(WalletCreationData $data): void;

    public function update(WalletIdInterface $id, WalletUpdateData $data): void;

    public function remove(WalletIdInterface $id): void;

    public function findById(WalletIdInterface $id): ?Wallet;

    /**
     * @param UserIdInterface $userId
     *
     * @return list<Wallet>
     */
    public function findByUser(UserIdInterface $userId): array;
}
