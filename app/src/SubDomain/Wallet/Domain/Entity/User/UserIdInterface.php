<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\User;

interface UserIdInterface
{
    public function value(): string;
}
