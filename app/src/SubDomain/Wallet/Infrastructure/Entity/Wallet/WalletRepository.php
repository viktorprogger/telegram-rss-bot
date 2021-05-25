<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Wallet;

use Cycle\ORM\ORM;
use Cycle\ORM\Select\QueryBuilder;
use Cycle\ORM\Transaction;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\User\UserIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\Wallet;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletRepositoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletUpdateData;
use RuntimeException;

// TODO Replace exceptions with custom ones
final class WalletRepository implements WalletRepositoryInterface
{
    public function __construct(
        private ORM $orm,
        private WalletIdFactoryInterface $walletIdFactory,
        private UserIdFactoryInterface $userIdFactory,
    ) {
    }

    public function create(WalletCreationData $data): void
    {
        if ($this->orm->getRepository(WalletEntity::class)->findByPK($data->getId()->value())) {
            throw new RuntimeException('Wallet with the given id already exists');
        }
        $filter = ['ownerId' => $data->getOwnerId()->value(), 'title' => $data->getTitle(), 'active' => true];
        if ($this->orm->getRepository(WalletEntity::class)->findOne($filter)) {
            throw new RuntimeException('Wallet with a such title for the given user already exists');
        }

        $entity = new WalletEntity();
        $entity->id = $data->getId()->value();
        $entity->active = $data->isActive();
        $entity->ownerId = $data->getOwnerId()->value();
        $entity->title = $data->getTitle();

        (new Transaction($this->orm))->persist($entity)->run();
    }

    public function update(WalletIdInterface $id, WalletUpdateData $data): void
    {
        $entity = $this->orm->getRepository(WalletEntity::class)->findByPK($id->value());
        if ($entity === null) {
            throw new RuntimeException('Wallet with the given id doesn\'t exist');
        }

        $entity->active = $data->isActive();
        $entity->title = $data->getTitle();

        (new Transaction($this->orm))->persist($entity)->run();
    }

    public function remove(WalletIdInterface $id): void
    {
        /** @var WalletEntity|null $entity */
        $entity = $this->orm->getRepository(WalletEntity::class)->findByPK($id->value());
        if ($entity === null) {
            throw new RuntimeException('Wallet with the given id does not exist');
        }

        (new Transaction($this->orm))->delete($entity)->run();
    }

    public function findById(WalletIdInterface $id): ?Wallet
    {
        $result = null;
        /** @var WalletEntity|null $entity */
        $entity = $this->orm->getRepository(WalletEntity::class)->findByPK($id->value());

        if ($entity !== null) {
            $guests = [];
            foreach ($entity->guests as $guest) {
                $guests[] = $this->userIdFactory->create($guest->id);
            }

            $result = new Wallet(
                $id,
                $this->userIdFactory->create($entity->ownerId),
                $entity->active,
                $entity->title,
                ...$guests,
            );
        }

        return $result;
    }

    public function findByUser(UserIdInterface $userId): iterable
    {
        $result = [];
        /** @var WalletEntity[] $entities */
        $entities = $this->orm
            ->getRepository(WalletEntity::class)
            ->select()
            ->where('active', true)
            ->andWhere(
                static function (QueryBuilder $select) use ($userId) {
                    $select
                        ->where('ownerId', $userId->value())
                        ->orWhere('guests.id', $userId->value());
                }
            )
            ->load('guests')
            ->fetchAll();
        foreach ($entities as $entity) {
            $guests = [];
            foreach ($entity->guests as $guest) {
                $guests[] = $this->userIdFactory->create($guest->id);
            }

            $result[] = new Wallet(
                $this->walletIdFactory->create($entity->id),
                $this->userIdFactory->create($entity->ownerId),
                $entity->active,
                $entity->title,
                ...$guests,
            );
        }

        return $result;
    }
}
