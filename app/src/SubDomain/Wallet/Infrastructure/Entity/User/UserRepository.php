<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\User;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Resender\SubDomain\Wallet\Domain\Entity\User\User;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserRepositoryInterface;
use RuntimeException;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(private ORM $orm)
    {
    }

    public function create(UserCreationData $data): void
    {
        if ($this->orm->getRepository(UserEntity::class)->findByPK($data->getId()->value())) {
            throw new RuntimeException('User with the given id already exists');
        }

        $entity = new UserEntity();
        $entity->id = $data->getId()->value();

        (new Transaction($this->orm))->persist($entity)->run();
    }

    public function findById(UserIdInterface $id): ?User
    {
        $result = null;
        /** @var UserEntity|null $entity */
        $entity = $this->orm->getRepository(UserEntity::class)->findByPK($id->value());

        if ($entity !== null) {
            $result = new User($id);
        }

        return $result;
    }
}
