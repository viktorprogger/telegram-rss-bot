<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'wl_user')]
final class UserEntity
{
    #[Column(type: 'string', primary: true)]
    public string $id;
}
