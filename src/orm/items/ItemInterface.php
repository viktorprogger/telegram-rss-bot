<?php

declare(strict_types=1);

namespace rssBot\orm\items;

interface ItemInterface
{
    public function getHash(): string;
}
