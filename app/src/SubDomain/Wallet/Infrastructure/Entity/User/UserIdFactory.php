<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;
use Resender\SubDomain\Wallet\Infrastructure\Entity\UuidFactory;

final class UserIdFactory implements UserIdFactoryInterface
{
    public function __construct(private UuidFactory $uuidFactory)
    {
    }

    public function create(?string $value): UserIdInterface
    {
        if ($value === null) {
            $id = $this->uuidFactory->create()->toString();
        } else {
            $id = $value;
        }

        return new UserIdGeneric($id);
    }
}
