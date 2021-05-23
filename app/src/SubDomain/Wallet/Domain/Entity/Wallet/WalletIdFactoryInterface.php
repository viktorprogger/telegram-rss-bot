<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

interface WalletIdFactoryInterface
{
    public function create(?string $value): WalletIdInterface;
}
