<?php

declare(strict_types=1);

namespace Resender\Domain\Source;

use Resender\Domain\Source\Github\Source as SourceGithub;
use Resender\Domain\Source\Rss\Source as SourceRss;

interface SourceRepositoryInterface
{
    /**
     * @return SourceRss[]|SourceGithub[]
     */
    public function getSources(): iterable;
}
