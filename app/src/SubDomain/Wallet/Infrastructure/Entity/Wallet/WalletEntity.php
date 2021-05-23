<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Relation\BelongsTo;
use Cycle\Annotated\Annotation\Relation\ManyToMany;
use Cycle\ORM\Relation\Pivoted\PivotedCollection;
use Resender\SubDomain\Wallet\Infrastructure\Entity\User\UserEntity;
use Resender\SubDomain\Wallet\Infrastructure\Entity\User\WalletUserEntity;

#[Entity(table: 'wl_wallet')]
final class WalletEntity
{
    #[Column(type: 'string', primary: true)]
    public string $id;

    #[Column(type: 'boolean')]
    public bool $active = true;

    #[Column(type: 'string')]
    public string $title;

    #[Column(type: 'string')]
    public string $ownerId;

    #[BelongsTo(target: UserEntity::class)]
    public UserEntity $owner;

    #[ManyToMany(target: UserEntity::class, though: WalletUserEntity::class)]
    /** @var UserEntity[]|PivotedCollection */
    public array|PivotedCollection $guests;

    public function __construct()
    {
        $this->guests = new PivotedCollection();
    }
}
