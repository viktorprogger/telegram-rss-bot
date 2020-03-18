<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\source\ItemInterface;
use Yiisoft\Validator\ValidatorInterface;

interface SenderInterface
{
    public function send(ItemInterface $item): void;

    public function addFilter(ValidatorInterface ...$filters);

    public function suits(ItemInterface $item): bool;
}
