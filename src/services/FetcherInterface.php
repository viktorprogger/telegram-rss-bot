<?php

declare(strict_types=1);

namespace rssBot\services;

use rssBot\models\source\SourceInterface;

interface FetcherInterface
{
    public function fetch(SourceInterface $source): void;
}
