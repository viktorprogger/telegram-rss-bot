<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Category;

interface CategoryIdFactoryInterface
{
    public function create(?string $value): CategoryIdInterface;
}
