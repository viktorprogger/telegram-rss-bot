<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\User;

final class UserCreationData
{
    public function __construct(private UserIdInterface $id)
    {
    }

    public function getId(): UserIdInterface
    {
        return $this->id;
    }
}
