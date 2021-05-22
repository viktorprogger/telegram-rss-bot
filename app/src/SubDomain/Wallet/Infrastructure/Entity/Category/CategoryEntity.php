<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Category;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet\WalletEntity;

#[Entity(table: 'wl_category')]
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

    #[Column(type: 'string')]
    public string $walletId;

    #[BelongsTo(target: WalletEntity::class)]
    public WalletEntity $wallet;
}
