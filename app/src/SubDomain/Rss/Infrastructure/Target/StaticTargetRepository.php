<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Target;

use Resender\SubDomain\Rss\Domain\Target\TargetIdInterface;
use Resender\SubDomain\Rss\Domain\Target\TargetInterface;
use Resender\SubDomain\Rss\Domain\Target\TargetRepositoryInterface;

class StaticTargetRepository implements TargetRepositoryInterface
{
    public function __construct(private array $targets)
    {
    }

    public function getById(TargetIdInterface $id): ?TargetInterface
    {
        return $this->targets[$id->value()] ?? null;
    }
}
