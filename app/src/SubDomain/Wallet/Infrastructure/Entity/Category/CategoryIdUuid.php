<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Category;

use Ramsey\Uuid\Uuid;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdInterface;

final class CategoryIdUuid implements CategoryIdInterface
{
    public function __construct(private Uuid $id)
    {
    }

    public function value(): string
    {
        return $this->id->toString();
    }
}
