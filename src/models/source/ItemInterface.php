<?php

declare(strict_types=1);

namespace rssBot\models\source;

use JsonSerializable;
use Yiisoft\Validator\DataSetInterface;

interface ItemInterface extends DataSetInterface, JsonSerializable
{
    public function getResourceCode(): string;
}
