<?php

declare(strict_types=1);

namespace rssBot\models\sender\converter;

use rssBot\models\sender\messages\MessageInterface;
use rssBot\models\source\ItemInterface;

interface ConverterInterface
{
    public function convert(ItemInterface $item): MessageInterface;
}
