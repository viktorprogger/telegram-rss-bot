<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Category;

use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdInterface;
use Resender\SubDomain\Wallet\Infrastructure\Entity\UuidFactory;

class CategoryIdFactory implements CategoryIdFactoryInterface
{
    public function __construct(private UuidFactory $uuidFactory)
    {
    }

    public function create(?string $value): CategoryIdInterface
    {
        return new CategoryIdUuid($this->uuidFactory->create($value));
    }
}
