<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\User;

interface UserInterface
{
    public function getId(): UserIdInterface;
}
