<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet;

use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;
use Resender\SubDomain\Wallet\Infrastructure\Entity\UuidFactory;

final class WalletIdFactory implements WalletIdFactoryInterface
{
    public function __construct(private UuidFactory $uuidFactory)
    {
    }

    public function create(?string $value): WalletIdInterface
    {
        return new WalletIdUuid($this->uuidFactory->create($value));
    }
}
