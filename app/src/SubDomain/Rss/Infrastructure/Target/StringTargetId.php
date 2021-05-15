<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Infrastructure\Target;

use Resender\SubDomain\Rss\Domain\Target\TargetIdInterface;

class StringTargetId implements TargetIdInterface
{
    public function __construct(private string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }
}
