<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain\Target;

interface TargetRepositoryInterface
{
    public function getById(TargetIdInterface $id): ?TargetInterface;
}
