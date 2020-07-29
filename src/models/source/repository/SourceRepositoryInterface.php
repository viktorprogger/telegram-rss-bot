<?php

declare(strict_types=1);

namespace rssBot\models\source\repository;

use rssBot\models\source\SourceInterface;

interface SourceRepositoryInterface
{
    public function get(string $code): SourceInterface;

    /**
     * @return string[]
     */
    public function getCodes(): iterable;
}
