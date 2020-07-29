<?php

declare(strict_types=1);

namespace rssBot\models\sender\converter;

interface ConverterInterface
{
    public function convert($item);
}
