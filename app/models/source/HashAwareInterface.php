<?php

declare(strict_types=1);

namespace rssBot\models\source;

interface HashAwareInterface
{
    public function getHash(): string;
}
