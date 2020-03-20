<?php

declare(strict_types=1);

namespace rssBot\models\sender\converter;

use rssBot\models\source\ItemInterface;
use Yiisoft\Validator\DataSetInterface;

interface ConverterInterface
{
    public function convert(ItemInterface $item): DataSetInterface;
}
