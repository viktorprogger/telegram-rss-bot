<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

use InvalidArgumentException;
use Money\Money;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;

final class CategoryCreationData
{
    public function __construct(
        private CategoryIdInterface $id,
        private bool $active,
        private WalletIdInterface $walletId,
        private string $title,
        private Money $targetFunds
    )
    {
        if (strlen($this->title) < 4) {
            // TODO Convert to a module-specific exception and maybe extract to a common validator
            throw new InvalidArgumentException('Category title length must be more than 3 characters');
        }
    }

    public function getId(): CategoryIdInterface
    {
        return $this->id;
    }

    public function getWalletId(): WalletIdInterface
    {
        return $this->walletId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getTitle(): string
    {
        return trim($this->title);
    }

    public function getTargetFunds(): Money
    {
        return $this->targetFunds;
    }
}
