<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserInterface;

final class User implements UserInterface
{
    public function __construct(private UserIdInterface $id)
    {
    }

    public function getId(): UserIdInterface
    {
        return $this->id;
    }
}
