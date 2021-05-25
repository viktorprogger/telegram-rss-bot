<?php

declare(strict_types=1);

namespace Resender\SubDomain\Wallet\Infrastructure\Entity\Category;

use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Money\Currency;
use Money\Money;
use Resender\SubDomain\Wallet\Domain\Entity\Category\Category;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryCreationData;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryIdInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryRepositoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Category\CategoryUpdateData;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdFactoryInterface;
use Resender\SubDomain\Wallet\Domain\Entity\Wallet\WalletIdInterface;
use RuntimeException;

// TODO Replace exceptions with custom ones
final class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(
        private ORM $orm,
        private CategoryIdFactoryInterface $categoryIdFactory,
        private WalletIdFactoryInterface $walletIdFactory,
    ) {
    }

    public function create(CategoryCreationData $data): void
    {
        if ($this->orm->getRepository(CategoryEntity::class)->findByPK($data->getId()->value())) {
            throw new RuntimeException('Category with the given id already exists');
        }
        $filter = ['walletId' => $data->getWalletId()->value(), 'title' => $data->getTitle(), 'active' => true];
        if ($this->orm->getRepository(CategoryEntity::class)->findOne($filter)) {
            throw new RuntimeException('Category with a such title in the given wallet already exists');
        }

        $entity = new CategoryEntity();
        $entity->id = $data->getId()->value();
        $entity->active = $data->isActive();
        $entity->walletId = $data->getWalletId()->value();
        $entity->title = $data->getTitle();
        $entity->amount = $data->getTargetFunds()->getAmount();

        (new Transaction($this->orm))->persist($entity)->run();
    }

    public function update(CategoryIdInterface $id, CategoryUpdateData $data): void
    {
        $entity = $this->orm->getRepository(CategoryEntity::class)->findByPK($id->value());
        if ($entity === null) {
            throw new RuntimeException('Category with the given id doesn\'t exist');
        }

        $entity->active = $data->isActive();
        $entity->title = $data->getTitle();

        (new Transaction($this->orm))->persist($entity)->run();
    }

    public function findById(CategoryIdInterface $id): ?Category
    {
        $result = null;
        /** @var CategoryEntity|null $entity */
        $entity = $this->orm->getRepository(CategoryEntity::class)->findByPK($id->value());

        if ($entity !== null) {
            $result = new Category(
                $id,
                $this->walletIdFactory->create($entity->walletId),
                $entity->active,
                $entity->title,
                new Money($entity->amount, new Currency('RUB')),
            );
        }

        return $result;
    }

    public function findByWallet(WalletIdInterface $walletId): iterable
    {
        $result = [];
        /** @var CategoryEntity[] $entities */
        $entities = $this->orm->getRepository(CategoryEntity::class)->findAll(['id' => $walletId->value()]);
        foreach ($entities as $entity) {
            $result[] = new Category(
                $this->categoryIdFactory->create($entity->id),
                $walletId,
                $entity->active,
                $entity->title,
                new Money($entity->amount, new Currency('RUB')),
            );
        }

        return $result;
    }

    public function remove(CategoryIdInterface $id): void
    {
        /** @var CategoryEntity|null $entity */
        $entity = $this->orm->getRepository(CategoryEntity::class)->findByPK($id->value());
        if ($entity === null) {
            throw new RuntimeException('Category with the given id does not exist');
        }

        (new Transaction($this->orm))->delete($entity)->run();
    }
}
