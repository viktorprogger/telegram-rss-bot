<?php

declare(strict_types=1);

namespace rssBot\services\converter;

use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\SenderInterface;
use rssBot\models\source\ItemInterface;

interface ConverterLocatorInterface
{
    public function getConverter(SenderInterface $sender, ItemInterface $sourceItem): ConverterInterface;
}
