<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;

interface CategoryRepositoryInterface
{
    public function create(CategoryCreationData $data): void;

    public function update(CategoryIdInterface $id, CategoryUpdateData $data): void;

    public function findById(CategoryIdInterface $id): ?Category;

    /**
     * @param WalletIdInterface $walletId
     *
     * @return Category[]
     */
    public function findByWallet(WalletIdInterface $walletId): array;

    public function remove(CategoryIdInterface $id): void;
}
