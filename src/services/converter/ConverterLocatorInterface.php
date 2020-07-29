<?php

declare(strict_types=1);

namespace rssBot\services\converter;

use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\SenderInterface;

interface ConverterLocatorInterface
{
    public function getConverter(SenderInterface $sender, $sourceItem): ConverterInterface;
}
