<?php

declare(strict_types=1);

namespace rssBot\models\sender\repository;

use rssBot\models\sender\SenderInterface;
use rssBot\models\source\SourceInterface;

interface SenderRepositoryInterface
{
    /**
     * Returns senders filtered by the given source
     *
     * @param SourceInterface $source
     *
     * @return SenderInterface[]
     */
    public function getBySource(SourceInterface $source): iterable;
}
