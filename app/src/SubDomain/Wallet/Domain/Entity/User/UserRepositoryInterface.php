<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function create(UserCreationData $data): void;

    public function findById(UserIdInterface $id): ?UserInterface;
}
