<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Ramsey\Uuid\Uuid;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

final class UserIdUuid implements UserIdInterface
{
    public function __construct(private Uuid $id)
    {
    }

    public function value(): string
    {
        return $this->id->toString();
    }
}
