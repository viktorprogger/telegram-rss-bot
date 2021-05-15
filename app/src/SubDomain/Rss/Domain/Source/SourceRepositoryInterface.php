<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain\Source;

use Resender\SubDomain\Rss\Infrastructure\Source\Github\Source;
use Resender\SubDomain\Rss\Infrastructure\Source\Github\Source as SourceGithub;

interface SourceRepositoryInterface
{
    /**
     * @return SourceInterface[]
     */
    public function getSources(): iterable;

    public function getById(string $id): ?SourceInterface;
}
