<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Source;

use Resender\SubDomain\Rss\Domain\Source\SourceInterface;
use Resender\SubDomain\Rss\Domain\Source\SourceRepositoryInterface;

class StaticSourceRepository implements SourceRepositoryInterface
{
    private array $sources;

    public function __construct(SourceInterface ...$sources)
    {
        $this->sources = $sources;
    }

    public function getSources(): iterable
    {
        return $this->sources;
    }

    public function getById(string $id): ?SourceInterface
    {
        foreach ($this->sources as $source) {
            if ($source->getId() === $id) {
                return $source;
            }
        }

        return null;
    }
}
