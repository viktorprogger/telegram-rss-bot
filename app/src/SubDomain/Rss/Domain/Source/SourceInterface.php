<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain\Source;

use Resender\SubDomain\Rss\Domain\Target\TargetIdInterface;

interface SourceInterface
{
    public function getId(): string;

    /**
     * @return Entry[]
     */
    public function getItems(): iterable;

    /**
     * @return TargetIdInterface[]
     */
    public function getTargetIds(): array;
}
