<?php

declare(strict_types=1);

namespace Resender\Domain\Target;

interface TargetRepositoryInterface
{
    public function getById(TargetIdInterface $id): ?TargetInterface;
}
