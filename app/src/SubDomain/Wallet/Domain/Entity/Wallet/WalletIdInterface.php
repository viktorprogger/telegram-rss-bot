<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\Wallet;

interface WalletIdInterface
{
    public function value(): string;
}
