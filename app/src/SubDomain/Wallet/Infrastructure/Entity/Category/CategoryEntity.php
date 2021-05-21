<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Category;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity]
final class CategoryEntity
{
    #[Column(type: 'string', primary: true)]
    public string $id;

    #[Column(type: 'boolean')]
    public bool $active = true;

    #[Column(type: 'string')]
    public string $title;

    #[Column(type: 'string', nullable: true)]
    public string $amount;
}
