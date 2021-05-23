<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\User;

interface UserIdFactoryInterface
{
    public function create(?string $value): UserIdInterface;
}
