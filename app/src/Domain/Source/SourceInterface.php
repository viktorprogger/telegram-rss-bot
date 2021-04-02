<?php

declare(strict_types=1);

namespace Resender\Domain\Source;

use Resender\Domain\Target\TargetIdInterface;
use Resender\Infrastructure\Source\Github\GithubNotification;
use Resender\Infrastructure\Source\Rss\RssEntry;

interface SourceInterface
{
    /**
     * @return \Resender\Infrastructure\Source\Rss\RssEntry[]|GithubNotification[]
     */
    public function getItems(): iterable;

    /**
     * @return TargetIdInterface[]
     */
    public function getTargetIds(): array;
}
