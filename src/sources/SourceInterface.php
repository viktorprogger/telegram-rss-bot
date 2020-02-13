<?php

declare(strict_types=1);

namespace rssBot\sources;

use rssBot\orm\items\ItemInterface;
use rssBot\receivers\ReceiverInterface;
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

    /**
     * @return ReceiverInterface[]
     */
    public function getReceivers(): iterable;
}
