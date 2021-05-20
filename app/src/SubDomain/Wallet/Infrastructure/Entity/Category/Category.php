<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Category;

use Money\Money;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryInterface;

final class Category implements CategoryInterface
{
    public function __construct(private CategoryIdInterface $id, private string $title, private Money $targetFunds)
    {
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
