<?php

declare(strict_types=1);

namespace Resender\Infrastructure\Target;

use Resender\Domain\Target\TargetIdInterface;

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
