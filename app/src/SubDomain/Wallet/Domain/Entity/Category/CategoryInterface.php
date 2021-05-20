<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

use Money\Money;

interface CategoryInterface
{
    public function getId(): CategoryIdInterface;

    public function getTitle(): string;

    public function getTargetFunds(): Money;
}
