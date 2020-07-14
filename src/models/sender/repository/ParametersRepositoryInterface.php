<?php

declare(strict_types=1);

namespace rssBot\models\sender\repository;

use rssBot\models\sender\SenderInterface;
use rssBot\models\source\SourceInterface;

class ParametersRepositoryInterface implements SenderRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getBySource(SourceInterface $source): iterable
    {

    }
}
