<?php

declare(strict_types=1);

namespace rssBot\models\source\repository;

use rssBot\models\source\SourceInterface;

interface SourceRepositoryInterface
{
    /**
     * @param array $codes Unique codes of sources
     * @param int $timestamp Sources with last fetch time more than this won't be returned
     *
     * @return SourceInterface[]
     */
    public function get(array $codes, int $timestamp): iterable;
}
