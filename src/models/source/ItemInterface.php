<?php

declare(strict_types=1);

namespace rssBot\models\source;

use Yiisoft\Validator\DataSetInterface;

interface ItemInterface extends DataSetInterface
{
    public function __toString();

    public function getSource(): SourceInterface;
}
