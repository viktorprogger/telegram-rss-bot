<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Source;

use Resender\Domain\Source\SourceInterface;
use Resender\Domain\Source\SourceRepositoryInterface;

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
}
