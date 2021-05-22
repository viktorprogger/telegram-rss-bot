<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

use Money\Money;

final class Category
{
    public function __construct(
        private CategoryIdInterface $id,
        private bool $active,
        private string $title,
        private Money $targetFunds
    ) {
    }

    public function getId(): CategoryIdInterface
    {
        return $this->id;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTargetFunds(): Money
    {
        return $this->targetFunds;
    }
}
