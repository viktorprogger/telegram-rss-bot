<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'wl_wallet_user')]
final class WalletUserEntity
{
    #[Column(type: 'primary')]
    public int $id;
}
