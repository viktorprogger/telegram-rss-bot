<?php

declare(strict_types=1);

namespace rssBot\models\source;

interface ItemInterface
{
    public function getHash(): string;

    public function __toString();
}
