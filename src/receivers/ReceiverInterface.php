<?php

declare(strict_types=1);

namespace rssBot\receivers;

use rssBot\orm\items\ItemInterface;
use Yiisoft\Validator\Validator;

interface ReceiverInterface
{
    public function attachFilter(Validator $validator): void;

    public function suites(ItemInterface $item): bool;

    public function send(ItemInterface $item): void;
}
