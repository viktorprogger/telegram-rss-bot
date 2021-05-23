<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

interface WalletRepositoryInterface
{
    public function create(WalletCreationData $data);

    public function update(WalletIdInterface $id, WalletUpdateData $data);

    public function remove(WalletIdInterface $id);

    public function findById(WalletIdInterface $id);

    public function findByUser(UserIdInterface $userId);
}
