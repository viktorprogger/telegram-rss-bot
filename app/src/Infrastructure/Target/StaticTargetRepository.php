<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Target;

use Resender\Domain\Target\TargetIdInterface;
use Resender\Domain\Target\TargetInterface;
use Resender\Domain\Target\TargetRepositoryInterface;

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
