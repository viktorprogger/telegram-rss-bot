<?php

declare(strict_types=1);

namespace Resender\Domain\Source;

use Resender\Infrastructure\Source\Github\Source;
use Resender\Infrastructure\Source\Github\Source as SourceGithub;

interface SourceRepositoryInterface
{
    /**
     * @return SourceInterface[]
     */
    public function getSources(): iterable;
}
