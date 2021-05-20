<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

use InvalidArgumentException;
use Money\Money;

final class CategoryUpdateData
{
    public function __construct(private string $title, private Money $targetFunds)
    {
        if (strlen($this->title) < 4) {
            // TODO Convert to a module-specific exception
            throw new InvalidArgumentException('Category title length must be more than 3 characters');
        }
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
