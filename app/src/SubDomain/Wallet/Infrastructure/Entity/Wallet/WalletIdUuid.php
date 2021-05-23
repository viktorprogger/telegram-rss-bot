<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet;

use Ramsey\Uuid\UuidInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;

final class WalletIdUuid implements WalletIdInterface
{
    public function __construct(private UuidInterface $id)
    {
    }

    public function value(): string
    {
        return $this->id->toString();
    }
}
