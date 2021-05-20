<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

use InvalidArgumentException;
use Money\Money;

final class CategoryCreationData
{
    public function __construct(private CategoryIdInterface $id, private string $title, private Money $targetFunds)
    {
        if (strlen($this->title) < 4) {
            // TODO Convert to a module-specific exception
            throw new InvalidArgumentException('Category title length must be more than 3 characters');
        }
    }

    public function getId(): CategoryIdInterface
    {
        return $this->id;
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
