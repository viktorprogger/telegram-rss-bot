<?php

declare(strict_types=1);

namespace Resender\Domain\Target;

interface TargetIdInterface
{
    public function value(): string;
}
