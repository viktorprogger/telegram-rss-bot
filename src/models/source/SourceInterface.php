<?php

declare(strict_types=1);

namespace rssBot\models\source;

use Yiisoft\Validator\Validator;

interface SourceInterface
{
    /**
     * Return filtered item list
     *
     * @return ItemInterface[]
     */
    public function getItems(): iterable;

    public function attachFilter(Validator $validator): void;
}
