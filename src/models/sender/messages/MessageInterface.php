<?php

declare(strict_types=1);

namespace rssBot\models\sender\messages;

use JsonSerializable;
use Yiisoft\Validator\DataSetInterface;

interface MessageInterface extends DataSetInterface, JsonSerializable
{
}
