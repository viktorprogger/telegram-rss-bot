<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;

/**
 * String representation of this id - telegram user id, a big numeric string
 */
final class UserIdTelegram implements UserIdInterface
{
    public function __construct(private string $id)
    {
    }

    public function value(): string
    {
        return $this->id;
    }
}
