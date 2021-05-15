<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain\Target;

interface TargetIdInterface
{
    public function value(): string;
}
