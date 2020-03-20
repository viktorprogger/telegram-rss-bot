<?php

declare(strict_types=1);

namespace rssBot\models\sender;

use rssBot\models\sender\converter\ConverterInterface;
use rssBot\models\sender\messages\AbstractMessage;
use rssBot\models\source\ItemInterface;
use Yiisoft\Validator\ValidatorInterface;

interface SenderInterface
{
    public function send(AbstractMessage $message): void;

    public function addFilter(ValidatorInterface ...$filters);

    public function suits(ItemInterface $message): bool;

    public function getConverter(): ConverterInterface;
}
