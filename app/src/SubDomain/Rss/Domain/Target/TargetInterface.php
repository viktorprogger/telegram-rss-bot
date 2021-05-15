<?php

declare(strict_types=1);

namespace Resender\SubDomain\Rss\Domain\Target;

use Resender\SubDomain\Rss\Domain\Source\Entry;

interface TargetInterface
{
    public function getId(): TargetIdInterface;

    public function sendRssItem(Entry $item): void;
}
